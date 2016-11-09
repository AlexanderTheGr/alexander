<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\Product as Product;
use SoftoneBundle\Entity\Sisxetiseis as Sisxetiseis;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Product';
    var $object = 'item';

    /**
     * @Route("/product/product")
     * 
     */
    public function indexAction() {
        
        $products = $this->getDoctrine()->getRepository("SoftoneBundle:Product")
                ->findAll();
        foreach ($products as $product) {
            $product->setProductFreesearch();
        }
        
        return $this->render('SoftoneBundle:Product:index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/product/getdatatable',
                    'view' => '/product/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/product/createProduct")
     */
    public function createProductAction(Request $request) {
        $json = json_encode(array("ok"));


        $asd = unserialize($this->getArticlesSearchByIds($request->request->get("ref")));
        $asd = $asd[0];
        $json = json_encode($asd);



        $em = $this->getDoctrine();
        $SoftoneSupplier = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")
                ->findOneBy(array('title' => $asd->brandName));

        //echo $asd->brandName . " " . @(int) $SoftoneSupplier->id;

        if (@$SoftoneSupplier->id == 0) {
            $TecdocSupplier = $em->getRepository("SoftoneBundle:TecdocSupplier")
                    ->findOneBy(array('supplier' => $asd->brandName));
            if (@$TecdocSupplier->id == 0) {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($asd->brandName);
                $SoftoneSupplier->setCode(' ');
                @$this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->setCode("S" . $SoftoneSupplier->getId());
                @$this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->toSoftone();
            } else {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($TecdocSupplier->getSupplier());
                $SoftoneSupplier->setCode("T" . $TecdocSupplier->id);
                @$this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->toSoftone();
            }
        } else {
            
        }

        $TecdocSupplier = $em->getRepository("SoftoneBundle:TecdocSupplier")
                ->findOneBy(array('supplier' => $asd->brandName));

        $erpCode = $this->clearCode($asd->articleNo) . "-" . $SoftoneSupplier->getCode();

        $product = $em->getRepository("SoftoneBundle:Product")->findOneBy(array('erpCode' => $erpCode));
        $json = array("error" => 1);
        if (@$product->id > 0) {
            $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/product/view/' . (int) $product->id));
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }

        $dt = new \DateTime("now");
        $product = new \SoftoneBundle\Entity\Product;
        $product->setSupplierCode($asd->articleNo);
        $product->setTitle($asd->genericArticleName);
        $product->setTecdocCode($asd->articleNo);
        $product->setItemMtrmark($TecdocSupplier->getId());
        $product->setTecdocSupplierId($TecdocSupplier);
        $product->setItemName($asd->genericArticleName);
        $product->setTecdocArticleId($asd->articleId);

        //$product->setItemCode($this->partno);
        $product->setItemApvcode($asd->articleNo);
        $product->setErpSupplier($asd->brand);
        $product->setItemMtrmanfctr($SoftoneSupplier->getId());
        $product->setErpCode($erpCode);
        $product->setItemCode($product->getErpCode());

        $product->setItemV5($dt);
        $product->setTs($dt);
        $product->setItemInsdate($dt);
        $product->setItemUpddate($dt);
        $product->setCreated($dt);
        $product->setModified($dt);
        @$this->flushpersist($product);

        $product->updatetecdoc();
        $product->setProductFreesearch();
        $product->toSoftone();

        $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/product/view/' . (int) $product->id));

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getArticlesSearchByIds($search) {
        //if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //$data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //return $data;
        //} else {
        $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
        $fields = array(
            'action' => 'getSearchByIds',
            'search' => $search
        );
        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($ch);
        //file_put_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term", $data);
        return $data;
        //}
    }

    /**
     * @Route("/product/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();


        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id > 0 AND count($product) > 0) {
            $product->updatetecdoc();
            $product->setProductFreesearch();
        }
        //$product->toSoftone();
        //exit;
        $content = $this->gettabs($id);

        //$content = $this->getoffcanvases($id);
        $content = $this->content();
        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => 's',
                    'url' => '/product/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));


        $datatables = array();
        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => 'Product',
                    'url' => '/product/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id, $datatables),
                    'datatables' => $datatables,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/product/save")
     */
    public function savection() {
        
        $product = new Product;
        $this->newentity[$this->repository] = $product;
        $this->initialazeNewEntity($product);
        @$this->newentity[$this->repository]->setField("status", 1);
        $this->error[$this->repository] = array();
        
        $entities = $this->save();
        
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($entities[$this->repository]);

        $erpCode = $this->clearCode($product->getSupplierCode()) . "-" . $product->getSupplierId()->getCode();
        $product->setErpCode($erpCode);

        $product->setItemCode($product->getErpCode());
        $product->setItemMtrmanfctr($product->getTecdocSupplierId()->getId());
        $product->setItemMtrmark($product->getSupplierId()->getId());
        $product->setItemApvcode($product->getTecdocCode());

        @$this->flushpersist($product);
        $product->updatetecdoc();
        $product->toSoftone();
        //print_r($this->error);
        //echo $product->id;
        if (count($this->error[$this->repository])) {
            $json = json_encode(array("error" => 1, "id" => (int) $product->id, 'unique' => $this->error[$this->repository]));
        } else {        
            $json = json_encode(array("error" => 0, "id" => (int) $product->id, 'returnurl' => '/product/view/' . (int) $product->id));
        }
        
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/product/addRelation")
     */
    public function addRelation(Request $request) {

        $json = json_encode(array("ok"));
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->findOneBy(array('erpCode' => $request->request->get("erp_code")));

        $idArr = explode(":", $request->request->get("id"));
        $id = (int) $idArr[3];

        $asd[] = $id;
        $asd[] = $product->getId();
        $json = json_encode($asd);
        if ($id > 0 AND count($product) > 0) {

            $sisxetisi = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Sisxetiseis')
                    ->findOneBy(array('product' => $id, 'sisxetisi' => $product->getId()));
            if (count($sisxetisi) == 0) {
                $sisxetisi = new Sisxetiseis();
                $sisxetisi->setProduct($id);
                $sisxetisi->setSisxetisi($product->getId());
                @$this->flushpersist($sisxetisi);
                $this->updateSisxetiseis($sisxetisi);
            }

            $sisxetisi = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Sisxetiseis')
                    ->findOneBy(array('sisxetisi' => $id, 'product' => $product->getId()));

            if (count($sisxetisi) == 0) {
                $sisxetisi = new Sisxetiseis();
                $sisxetisi->setProduct($product->getId());
                $sisxetisi->setSisxetisi($id);
                @$this->flushpersist($sisxetisi);
                $this->updateSisxetiseis($sisxetisi);
            }
        }

        //$json = json_encode($product);
        //print_r($product);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function updateSisxetiseis($sisx) {
        $sisxetiseis = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Sisxetiseis')
                ->findBy(array('sisxetisi' => $sisx->getProduct()));

        foreach ($sisxetiseis as $sisxetis) {
            if ($sisx->getSisxetisi() != $sisxetis->getProduct()) {
                $sisxetisi = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Sisxetiseis')
                        ->findOneBy(array('product' => $sisx->getSisxetisi(), 'sisxetisi' => $sisxetis->getProduct()));

                if (count($sisxetisi) == 0) {
                    $sisxetisi = new Sisxetiseis();
                    $sisxetisi->setProduct($sisx->getSisxetisi());
                    $sisxetisi->setSisxetisi($sisxetis->getProduct());
                    try {
                        @$this->flushpersist($sisxetisi);
                        $this->updateSisxetiseis($sisxetisi);
                    } catch (Exception $e) {
                        
                    }
                }
                $sisxetisi = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Sisxetiseis')
                        ->findOneBy(array('sisxetisi' => $sisx->getSisxetisi(), 'product' => $sisxetis->getProduct()));
                if (count($sisxetisi) == 0) {
                    $sisxetisi = new Sisxetiseis();
                    $sisxetisi->setProduct($sisxetis->getProduct());
                    $sisxetisi->setSisxetisi($sisx->getSisxetisi());
                    try {
                        @$this->flushpersist($sisxetisi);
                        $this->updateSisxetiseis($sisxetisi);
                    } catch (Exception $e) {
                        
                    }
                }
            }
        }
    }

    /**
     * @Route("/product/gettab")
     */
    /*
      public function gettabs($id) {


      $entity = $this->getDoctrine()
      ->getRepository($this->repository)
      ->find($id);

      $fields["erpCode"] = array("label" => "Erp Code");
      $fields["itemPricew01"] = array("label" => "Price Name");

      $forms = $this->getFormLyFields($entity, $fields);

      $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
      $json = $this->tabs();
      return $json;
      }
     * 
     */

    public function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Product')
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Product;
        }
        $entity->updatetecdoc();
        $fields["title"] = array("label" => "Title", "required" => true, "className"=>"col-md-6 col-sm-6");
        $fields["erpCode"] = array("label" => "Erp Code", "required" => true, "className"=>"col-md-6 col-sm-6");
        
        $fields["tecdocSupplierId"] = array("label" => "Tecdoc Supplier", "required" => true,"className"=>"col-md-6", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:TecdocSupplier', 'name' => 'supplier', 'value' => 'id'));
        $fields["tecdocCode"] = array("label" => "Tecdoc Code", "required" => true,"className"=>"col-md-6");
        
        $fields["supplierId"] = array("label" => "Supplier","className"=>"col-md-6", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'SoftoneBundle:SoftoneSupplier', 'name' => 'title', 'value' => 'id'));
        $fields["supplierCode"] = array("label" => "Supplier Code","className"=>"col-md-6", "required" => true);
        
        $fields["itemPricew"] = array("label" => "Wholesale Price","className"=>"col-md-3","required" => true);
        $fields["itemPricer"] = array("label" => "Retail Price","className"=>"col-md-3", "required" => true);
        
        $fields["itemMarkupw"] = array("label" => "Wholesale Markup","className"=>"col-md-3","required" => true);
        $fields["itemMarkupr"] = array("label" => "Retail Markup","className"=>"col-md-3", "required" => true);
        
        $forms = $this->getFormLyFields($entity, $fields);

        if ($id > 0 AND count($entity) > 0) {
            $entity2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Product')
                    ->find($id);
            $entity2->setReference("");
            $fields2["reference"] = array("label" => "Erp Code", "className" => "synafiacode col-md-12");
            $forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "Title", "index" => 'title');
            $dtparams[] = array("name" => "Code", "index" => 'erpCode');
            $dtparams[] = array("name" => "Price", "index" => 'itemPricew01');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/product/getrelation/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }


        $tabs[] = array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);
        if ($id > 0 AND count($entity) > 0)
            $tabs[] = array("title" => "Retaltions", "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);

        foreach ($tabs as $tab) {
            $this->addTab($tab);
        }

        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/product/getrelation/{id}")
     */
    public function getrelationAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:Product';
        $this->q_and[] = $this->prefix . ".id in  (Select k.sisxetisi FROM SoftoneBundle:Sisxetiseis k where k.product = '" . $id . "')";
        $json = $this->datatable();

        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $table1 = array();
            foreach ($table as $f => $val) {
                $table1[$f] = $val;
            }
            $datatable->data[$key] = $table1;
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * 
     * 
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $fields = array();
        $fields = unserialize($this->getSetting("SoftoneBundle:Product:getdatatable"));
        if (count($fields) == 0 OR $this->getSetting("SoftoneBundle:Product:getdatatable") == '') {
            $fields[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $fields[] = array("name" => "Title", "index" => 'title');
            $fields[] = array("name" => "Code", "index" => 'erpCode');
            $fields[] = array("name" => "Price", "index" => 'itemPricew01');
            $this->setSetting("SoftoneBundle:Product:getdatatable", serialize($fields));
        }


        foreach ($fields as $field) {
            $this->addField($field);
        }

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    
    
     /**
     * 
     * 
     * @Route("/product/productInfo")
     */
    public function productInfo(Request $request) {

        $buttons = array();
        $content = $this->gettabs(1);

        //$content = $this->getoffcanvases($id);
        $content = $this->content();       
        
        //$content = 'sss';
        return $this->render('SoftoneBundle:Product:productInfo.html.twig', array(
                    'pagename' => 's',
                    'order' => $id,
                    'url' => '/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->originals($request->request->get("ref")),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }   

    /**
     * @Route("/product/fororderajaxjson")
     */
    public function fororderajaxjsonAction() {
        return new Response(
                "", 200
        );
    }

    function retrieveMtrcategory() {
        $params = unserialize($this->getSetting("SoftoneBundle:Product:retrieveMtrcategory"));
        if (count($params) > 0) {
            $params["softone_object"] = 'itecategory';
            $params["repository"] = 'SoftoneBundle:Pcategory';
            $params["softone_table"] = 'MTRCATEGORY';
            $params["table"] = 'softone_pcategory';
            $params["object"] = 'SoftoneBundle\Entity\Pcategory';
            $params["filter"] = '';
            $params["relation"] = array();
            $params["extra"] = array();
            $params["extrafunction"] = array();
            $this->setSetting("SoftoneBundle:Product:retrieveMtrcategory", serialize($params));
        }

        $this->retrieve($params);
    }

    function retrieveMtrl() {
        $params = unserialize($this->getSetting("SoftoneBundle:Product:retrieveMtrl"));
        if (count($params) > 0) {
            $where = '';
            $params["softone_object"] = "item";
            $params["repository"] = 'SoftoneBundle:Product';
            $params["softone_table"] = 'MTRL';
            $params["table"] = 'softone_product';
            $params["object"] = 'SoftoneBundle\Entity\Product';
            $params["filter"] = 'WHERE M.SODTYPE=51 ' . $where;
            $params["relation"] = array();
            $params["extra"] = array();
            $params["extrafunction"] = array();
            //$params["extra"]["CCCFXRELTDCODE"] = "CCCFXRELTDCODE";
            //$params["extra"]["CCCFXRELBRAND"] = "CCCFXRELBRAND";
            $params["relation"]["reference"] = "MTRL";
            $params["relation"]["erpCode"] = "CODE";
            $params["relation"]["supplierCode"] = "CODE2";
            $params["relation"]["title"] = "NAME";
            $params["relation"]["tecdocCode"] = "APVCODE";
            $params["relation"]["tecdocSupplierId"] = "MTRMARK";
            $params["extrafunction"][] = "updatetecdoc";
            $this->setSetting("SoftoneBundle:Product:retrieveMtrl", serialize($params));
        }
        $this->retrieve($params);
    }

    /**
     * 
     * @Route("/product/retrieveSoftone")
     */
    function retrieveSoftoneDataAction($params = array()) {
        set_time_limit(100000);
        ini_set('memory_limit', '2256M');
        echo $this->retrieveMtrcategory();
        echo $this->retrieveMtrl();

        return new Response(
                "", 200
        );
    }

    //getmodeltypes
    /**
     * 
     * @Route("/product/getbrands")
     */
    function getBrandsction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getbrands';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

    /**
     * 
     * @Route("/product/getmodels")
     */
    function getModelsAction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getmodels';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

    /**
     * 
     * @Route("/product/getmodeltypes")
     */
    function getModeltypesAction(Request $request) {
        $url = 'http://www.partsbay.gr/antallaktika/init/getmodeltypes';
        $fields_string = '';
        $fields["brand"] = $request->request->get("brand");
        $fields["model"] = $request->request->get("model");
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
    }

}
