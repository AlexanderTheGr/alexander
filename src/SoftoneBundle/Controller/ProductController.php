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
use SoftoneBundle\Entity\Productcategory as Productcategory;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use AppBundle\Entity\Tecdoc as Tecdoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Product';
    var $object = 'item';

    /**
     * @Route("/product/product")
     * 
     */
    public function indexAction() {

        /*
          $products = $this->getDoctrine()->getRepository("SoftoneBundle:Product")
          ->findAll();
          $tecdoc = new Tecdoc();
          $em = $this->getDoctrine()->getManager();
          foreach ($products as $product) {
          if ($product->getId() < 96669)
          continue;
          echo $product->getId()."<BR>";
          $product->updatetecdoc($tecdoc);
          $product->setProductFreesearch();

          $cats = $product->getCats();
          $cats2 = array();
          foreach ((array) $cats as $cat) {
          $category = $this->getDoctrine()
          ->getRepository('SoftoneBundle:Productcategory')
          ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
          if (count($category) == 0) {
          //$category = new Productcategory();
          //$category->setProduct($product->getId());
          //$category->setCategory($cat);
          //@$this->flushpersist($category);
          if ($cat > 0) {
          $sql = 'insert softone_productcategory set product = "' . $product->getId() . '", category = "' . $cat . '"';
          $em->getConnection()->exec($sql);
          }
          }
          }

          //if ($i++ > 300) exit;
          }
         */
        return $this->render('SoftoneBundle:Product:index.html.twig', array(
                    'pagename' => 'Είδη',
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


        $asd = $this->getArticlesSearchByIds($request->request->get("ref"));
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
                $SoftoneSupplier->setCode("G" . $SoftoneSupplier->getId());
                @$this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->toSoftone();
            } else {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($TecdocSupplier->getSupplier());
                $SoftoneSupplier->setCode($TecdocSupplier->id);
                @$this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->toSoftone();
            }
        } else {
            
        }

        $TecdocSupplier = $em->getRepository("SoftoneBundle:TecdocSupplier")
                ->findOneBy(array('supplier' => $asd->brandName));

        $erpCode = $this->clearstring($asd->articleNo) . "-" . $SoftoneSupplier->getCode();

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
        $product->setSupplierId($SoftoneSupplier);
        $product->setItemName($asd->genericArticleName);
        $product->setTecdocArticleId($asd->articleId);

        $productsale = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Productsale')->find(1);
        $product->setItemPricew("0.00");
        $product->setItemPricer("0.00");
        $product->setItemMarkupw("0.00");
        $product->setItemMarkupr("0.00");
        $product->setProductSale($productsale);

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
        $product->setItemCode2($this->clearstring($asd->articleNo));
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
        /*
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
         */
        //file_put_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term", $data);
        $params = array(
            'search' => $search
        );
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };         
        $data = $tecdoc->getArticlesSearchByIds($params);
        return $data->data->array;
        //return $data;
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
        $pagename = "Add new Product";
        if ($id > 0 AND count($product) > 0) {
            $product->updatetecdoc();
            $product->setProductFreesearch();
            $pagename = $product->getTitle() . " " . $product->getErpCode();
        }
        //$product->toSoftone();

        $content = $this->gettabs($id);

        //$content = $this->getoffcanvases($id);
        $content = $this->content();

        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => $pagename,
                    'url' => '/product/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));

        exit;
    }

    /**
     * @Route("/product/save")
     */
    public function savection() {
        $sql = 'delete from `softone_product` where item_code is null';
        $this->getDoctrine()->getConnection()->exec($sql);
        $product = new Product;
        $this->newentity[$this->repository] = $product;
        $this->initialazeNewEntity($product);
        @$this->newentity[$this->repository]->setField("status", 1);
        $this->error[$this->repository] = array();

        $entities = $this->save();

        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($entities[$this->repository]);


        if ($product->getErpSupplier() != '' AND ! $product->getSupplierId()) {
            $sup = trim(strtoupper($product->getErpSupplier()));
            $SoftoneSupplier = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")
                    ->findOneBy(array('title' => $sup));
            if (@$SoftoneSupplier->id == 0) {
                $TecdocSupplier = $this->getDoctrine()->getRepository("SoftoneBundle:TecdocSupplier")
                        ->findOneBy(array('supplier' => $sup));
                if (@$TecdocSupplier->id == 0) {
                    $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                    $SoftoneSupplier->setTitle($sup);
                    $SoftoneSupplier->setCode(' ');
                    //$this->getDoctrine()->persist($SoftoneSupplier);
                    //$this->getDoctrine()->flush();
                    $this->flushpersist($SoftoneSupplier);
                    $SoftoneSupplier->setCode("G" . $SoftoneSupplier->getId());
                    //$this->getDoctrine()->persist($SoftoneSupplier);
                    //$this->getDoctrine()->flush();
                    $this->flushpersist($SoftoneSupplier);
                    $SoftoneSupplier->toSoftone();
                } else {
                    $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                    $SoftoneSupplier->setTitle($TecdocSupplier->getSupplier());
                    $SoftoneSupplier->setCode($TecdocSupplier->id);
                    $this->flushpersist($SoftoneSupplier);
                    $SoftoneSupplier->toSoftone();
                }
            }
            //$product->setItemMtrmanfctr($SoftoneSupplier->getId());
            $product->setSupplierId($SoftoneSupplier);
        } else {
            $sup = trim(strtoupper($product->getErpSupplier()));
            $SoftoneSupplier = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")
                    ->findOneBy(array('title' => $sup));
            if (@$SoftoneSupplier->id == 0) {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($sup);
                $SoftoneSupplier->setCode(' ');
                //$this->getDoctrine()->persist($SoftoneSupplier);
                //$this->getDoctrine()->flush();
                $this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->setCode("G" . $SoftoneSupplier->getId());
                //$this->getDoctrine()->persist($SoftoneSupplier);
                //$this->getDoctrine()->flush();
                $this->flushpersist($SoftoneSupplier);
                $SoftoneSupplier->toSoftone();
                $product->setSupplierId($SoftoneSupplier);
            }
        }

        $erpCode = $this->clearCode($product->getSupplierCode()) . "-" . $product->getSupplierId()->getCode();
        $product->setErpCode($erpCode);
        $product->setItemCode($product->getErpCode());
        if ($product->getTecdocSupplierId())
            $product->setItemMtrmark($product->getTecdocSupplierId()->getId());

        $product->setItemMtrmanfctr($product->getSupplierId()->getId());
        $product->setItemApvcode($product->getTecdocCode());
        $product->setItemName($product->getTitle());

        //$product->reference = 2350;
        @$this->flushpersist($product);
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($product->getId());
        $entity = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Product')
                ->find((int) $product->getId());

        //echo $product->id."\n";
        //echo $product->reference."\n";
        //$product = $this->newentity[$this->repository];
        $product->updatetecdoc(false, true);
        $product->toSoftone();
        $product->toB2b();
        if ($product->getSisxetisi() != '') {
            $sproducts = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findBy(array("sisxetisi" => $product->getSisxetisi()));
            foreach ($sproducts as $sproduct) {
                if ($sproduct->getSisxetisi() != '')
                    $sproduct->toSoftone();
            }
        }

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

    private function clearCode($code) {
        $code = str_replace(" ", "", $code);
        $code = str_replace(".", "", $code);
        $code = str_replace("-", "", $code);
        $code = str_replace("/", "", $code);
        $code = str_replace(")", "", $code);
        $code = str_replace("(", "", $code);
        $code = strtoupper($code);
        return $code;
    }

    /**
     * @Route("/product/addRelation")
     */
    public function addRelation(Request $request) {

        $json = json_encode(array("ok"));
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->findOneBy(array('erpCode' => $request->request->get("erp_code")));
        if (!$product)
            exit;

        $idArr = explode(":", $request->request->get("id"));
        $id = (int) $idArr[3];


        $product2 = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($product2->getSisxetisi() == '') {
            if ($product->getSisxetisi()) {
                $product2->setSisxetisi($product->getSisxetisi());
            } else {
                $product2->setSisxetisi(str_pad($product2->getId(), 10, "0", STR_PAD_LEFT));
            }
            $this->flushpersist($product2);
        }

        if ($product2->getSisxetisi()) {
            if (!$product->getSisxetisi()) {
                $product->setSisxetisi($product2->getSisxetisi());
                $this->flushpersist($product);
            } else {
                $products = $this->getDoctrine()->getRepository($this->repository)->findBy(array("sisxetisi" => $product->getSisxetisi()));
                foreach ($products as $product) {
                    $product->setSisxetisi($product2->getSisxetisi());
                    $this->flushpersist($product);
                }
            }
        }

        /*
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
         * 
         */

        //$json = json_encode($product);
        //print_r($product);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/product/addCategory")
     */
    public function addCategory(Request $request) {

        $json = json_encode(array("ok"));

        $idArr = explode(":", $request->request->get("product"));
        $id = (int) $idArr[3];

        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("product"));

        $cats = (array) $product->getCats();
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }

        $json = json_encode($asd);
        if (count($product) > 0) {
            $category = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Productcategory')
                    ->findOneBy(array('category' => $request->request->get("category"), 'product' => $product->getId()));
            if (count($category) == 0) {
                $category = new Productcategory();
                $category->setProduct($product->getId());
                $category->setCategory($request->request->get("category"));
                @$this->flushpersist($category);
            } else {
                $this->flushremove($category);
            }
        }
        $categories = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Productcategory')
                ->findBy(array('product' => $product->getId()));
        $cats = array();
        foreach ($categories as $category) {
            $cats[] = $category->getCategory();
        }
        $product->setCats($cats);
        $this->flushpersist($product);
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
            $productsale = $this->getDoctrine()
                            ->getRepository('SoftoneBundle:Productsale')->find(1);
            $entity = new Product;
            $entity->setItemPricew("0.00");
            $entity->setItemPricer("0.00");
            $entity->setItemMarkupw("0.00");
            $entity->setItemMarkupr("0.00");
            $entity->setProductSale($productsale);
        }
        $customer = $this->getDoctrine()->getRepository('SoftoneBundle:Customer')->find(1);
        //echo $entity->getGroupedDiscountPrice($customer);

        $cats = $entity->getCats();
        foreach ((array) $cats as $cat) {
            $category = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Productcategory')
                    ->findOneBy(array('category' => $cat, 'product' => $entity->getId()));
            if (count($category) == 0 AND $entity->id > 0) {
                $category = new Productcategory();
                $category->setProduct($entity->getId());
                $category->setCategory($cat);
                @$this->flushpersist($category);
            }
        }

        $entity->updatetecdoc();
        $dataarray[] = array("value" => "0", "name" => "Oxi");
        $dataarray[] = array("value" => "1", "name" => "Ναι");
        $suppliers = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Supplier')->findAll();
        $itemMtrsup = array();
        foreach ($suppliers as $supplier) {
            $sip = str_replace("'", "", $supplier->getSupplierName());
            $sip = str_replace("\"", "", $sip);
            $itemMtrsup[] = array("value" => (string) $supplier->getReference(), "name" => $sip); // $supplier->getSupplierName();
        }
        //print_r($itemMtrsup);
        //return;
        $cccPriceUpd = $entity->getCccPriceUpd() ? "1" : "0";
        $entity->setCccPriceUpd($cccPriceUpd);

        //echo $entity->getItemRemarks();

        $softoneSuppliers = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:SoftoneSupplier')->findAll();
        foreach ($softoneSuppliers as $softoneSupplier) {
            $supplierId[] = array("value" => (string) $softoneSupplier->getId(), "name" => $softoneSupplier->getTitle() . " (" . $softoneSupplier->getCode() . ")");
        }

        //$fields["reference"] = array("label" => "Ενεργό", "required" => false, "className" => "col-md-12 col-sm-12");

        $fields["itemIsactive"] = array("label" => "Ενεργό", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-2 col-sm-2");
        $fields["cccPriceUpd"] = array("label" => "Συχρονισμός", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-2 col-sm-2");
        $fields["cccWebUpd"] = array("label" => "WEB", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-2 col-sm-2");
        $fields["nosync"] = array("label" => "No Sync", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-2 col-sm-2");
        $fields["productSale"] = array("label" => "Προσφορά", "className" => "col-md-4", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'SoftoneBundle:ProductSale', 'name' => 'title', 'value' => 'id'));




        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {

            //print_r($itemMtrsup);
            //$fields["productSale"] = array("label" => "Προσφορά", "className" => "col-md-3", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'SoftoneBundle:ProductSale', 'name' => 'title', 'value' => 'id'));

            $fields["title"] = array("label" => $this->getTranslation("Product Name"), "required" => true, "className" => "col-md-6 col-sm-6");
            $fields["erpCode"] = array("label" => $this->getTranslation("Product Code"), "required" => false, "className" => "col-md-3 col-sm-3");
            $fields["itemCode1"] = array("label" => $this->getTranslation("Barcode"), "required" => false, "className" => "col-md-3 col-sm-3");

            $fields["tecdocSupplierId"] = array("label" => $this->getTranslation("Tecdoc Supplier"), "required" => false, "className" => "col-md-6", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:TecdocSupplier', 'name' => 'supplier', 'value' => 'id', 'suffix' => 'id'));
            $fields["tecdocCode"] = array("label" => $this->getTranslation("Tecdoc Code"), "required" => false, "className" => "col-md-6");


            $fields["supplierId"] = array("label" =>  $this->getTranslation("Supplier"), "className" => "col-md-3", 'type' => "select", "required" => false, 'datasource' => array('repository' => 'SoftoneBundle:SoftoneSupplier', 'name' => 'title', 'value' => 'id', 'suffix' => 'code'));

            //$fields["supplierId"] = array("label" => "Supplier", "className" => "col-md-3", 'type' => "select", "required" => false, 'dataarray' => $supplierId);

            $fields["erpSupplier"] = array("label" => $this->getTranslation("New Supplier"), "required" => false, "className" => "col-md-3");

            $fields["supplierCode"] = array("label" => $this->getTranslation("Supplier Code"), "className" => "col-md-3", "required" => true);



            $fields["itemMtrplace"] = array("label" => $this->getTranslation("Place"), "className" => "col-md-1", "required" => false);

            $fields["qty"] = array("label" => $this->getTranslation("Place"), "className" => "col-md-1", "required" => false);
            $fields["reserved"] = array("label" => $this->getTranslation("Δεσμευμενα"), "className" => "col-md-1", "required" => false);

            //$fields["itemMtrsup"] = array("label" => "Συνήθης προμηθευτής", "className" => "col-md-2", "required" => false);        
            $fields["itemMtrsup"] = array("label" => $this->getTranslation("Συνήθης προμηθευτής"), "required" => false, "className" => "col-md-2", 'type' => "select", 'dataarray' => $itemMtrsup);
            $fields["cccRef"] = array("label" =>  $this->getTranslation("Κωδικός Προμηθευτή"), "className" => "col-md-2", "required" => false);



            $remarks = str_replace("\n", "|", $entity->getItemRemarks());
            $remarks = str_replace("\r", "|", $remarks);
            $remarks = str_replace("||", "|", $remarks);
            $entity->setItemRemarks($remarks);

            if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
                $fields["itemPricew01"] = array("label" => $this->getTranslation("Retail Price"), "className" => "col-md-2", "required" => false);
                $fields["itemPricew03"] = array("label" => $this->getTranslation("Τιμή Olympic"), "className" => "col-md-2", "required" => false);
            } else {
                $fields["itemPricew01"] = array("label" => $this->getTranslation("Wholesale Price"), "className" => "col-md-2", "required" => false);
                $fields["itemPricew02"] = array("label" => $this->getTranslation("Retail Price"), "className" => "col-md-1", "required" => false);
                $fields["itemPricew04"] = array("label" => $this->getTranslation("Eshop Price"), "className" => "col-md-1", "required" => false);
            }
            $fields["itemMarkupw"] = array("label" => $this->getTranslation("Wholessle Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemMarkupr"] = array("label" => $this->getTranslation("Retail Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemRemarks"] = array("label" => $this->getTranslation("Remarks"), "required" => false, "className" => "col-md-6 col-sm-6");
            $fields["sisxetisi"] = array("label" => $this->getTranslation("Κωδικός Συσχέτισης"), "className" => "col-md-6", "required" => false);
            //$fields["edis"] = array("label" => "Αντιστοιχίες Εκτός Αποθήκης", "className" => "col-md-6", "required" => false);      
        } else {

            //$fields["productSale"] = array("label" => "Προσφορά", "className" => "col-md-3", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'SoftoneBundle:ProductSale', 'name' => 'title', 'value' => 'id'));

            $fields["title"] = array("label" => $this->getTranslation("Product Name"), "required" => true, "className" => "col-md-6 col-sm-6");
            $fields["erpCode"] = array("label" => $this->getTranslation("Product Code"), "required" => false, "className" => "col-md-3 col-sm-3");
            $fields["itemCode1"] = array("label" => $this->getTranslation("Barcode"), "required" => false, "className" => "col-md-3 col-sm-3");

            $fields["tecdocSupplierId"] = array("label" => $this->getTranslation("Tecdoc Supplier"), "required" => false, "className" => "col-md-6", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:TecdocSupplier', 'name' => 'supplier', 'value' => 'id', 'suffix' => 'id'));
            $fields["tecdocCode"] = array("label" => $this->getTranslation("Tecdoc Code"), "required" => false, "className" => "col-md-6");


            $fields["supplierId"] = array("label" =>  $this->getTranslation("Supplier"), "className" => "col-md-3", 'type' => "select", "required" => false, 'datasource' => array('repository' => 'SoftoneBundle:SoftoneSupplier', 'name' => 'title', 'value' => 'id', 'suffix' => 'code'));

            //$fields["supplierId"] = array("label" => "Supplier", "className" => "col-md-3", 'type' => "select", "required" => false, 'dataarray' => $supplierId);

            $fields["erpSupplier"] = array("label" => $this->getTranslation("New Supplier"), "required" => false, "className" => "col-md-3");

            $fields["supplierCode"] = array("label" => $this->getTranslation("Supplier Code"), "className" => "col-md-3", "required" => true);



            $fields["itemMtrplace"] = array("label" => $this->getTranslation("Place"), "className" => "col-md-1", "required" => false);

            $fields["qty"] = array("label" => $this->getTranslation("Place"), "className" => "col-md-1", "required" => false);
            $fields["reserved"] = array("label" => $this->getTranslation("Δεσμευμενα"), "className" => "col-md-1", "required" => false);

            //$fields["itemMtrsup"] = array("label" => "Συνήθης προμηθευτής", "className" => "col-md-2", "required" => false);        
            $fields["itemMtrsup"] = array("label" => $this->getTranslation("Συνήθης προμηθευτής"), "required" => false, "className" => "col-md-2", 'type' => "select", 'dataarray' => $itemMtrsup);
            $fields["cccRef"] = array("label" =>  $this->getTranslation("Κωδικός Προμηθευτή"), "className" => "col-md-2", "required" => false);



            $fields["itemMarkupw"] = array("label" => $this->getTranslation("Wholessle Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemMarkupr"] = array("label" => $this->getTranslation("Retail Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemMarkupw"] = array("label" => $this->getTranslation("Wholessle Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemMarkupr"] = array("label" => $this->getTranslation("Retail Markup"), "className" => "col-md-2", "required" => false);
            $fields["itemRemarks"] = array("label" => $this->getTranslation("Remarks"), "required" => false, "className" => "col-md-6 col-sm-6");
            $fields["sisxetisi"] = array("label" => $this->getTranslation("Κωδικός Συσχέτισης"), "className" => "col-md-6", "required" => false);
            $fields["edis"] = array("label" => $this->getTranslation("Αντιστοιχίες Εκτός Αποθήκης"), "className" => "col-md-6", "required" => false);
        }
        //$fields["itemMarkupw"] = array("label" => "Markup Χοδρικής", "className" => "col-md-2", "required" => false);
        //$fields["itemMarkupr"] = array("label" => "Markup Λιανικής", "className" => "col-md-2", "required" => false);
        // $fields["itemRemarks"] = array("label" => "Remarks", "required" => false, 'type' => "textarea", "className" => "col-md-6 col-sm-6");
        // $fields["sisxetisi"] = array("label" => "Κωδικός Συσχέτισης", "className" => "col-md-6", "required" => false);


        $forms = $this->getFormLyFields($entity, $fields);

        if ($id > 0 AND count($entity) > 0) {
            $entity2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Product')
                    ->find($id);
            $entity2->setReference("");
            $fields2["reference"] = array("label" => "Erp Code", "className" => "synafiacode col-md-12");
            $forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => $this->getTranslation("Title"), "index" => 'title');
            $dtparams[] = array("name" => $this->getTranslation("Code"), "index" => 'erpCode');
            $dtparams[] = array("name" => $this->getTranslation("Price"), "index" => 'itemPricew01');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/product/getrelation/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }


        $tabs[] = array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => $this->getTranslation("Αντιστοιχίες Εντός Αποθήκης"), "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
            $tabs[] = array("title" => $this->getTranslation("Categories"), "datatables" => '', "form" => '', "content" => $this->getCategories($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
        }

        foreach ($tabs as $tab) {
            $this->addTab($tab);
        }

        $json = $this->tabs();
        return $json;
    }

    public function getCategories($product) {
        $entities = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Category')
                ->findBy(array("parent" => 0));
        $html = "<ul class='productcategory'>";

        $cats = (array) $product->getCats();

        foreach ($entities as $entity) {
            $html .= "<li class='parentcategoryli' data-ref='" . $entity->getId() . "'>";


            $entities2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Category')
                    ->findBy(array("parent" => $entity->getId()));
            $style = "";
            foreach ($entities2 as $entity2) {
                //$style = in_array($entity2->getId(), $cats) ? "style='color:red'" : '';
                if (in_array($entity2->getId(), (array) $cats)) {
                    $style = "style='color:red'";
                }
            }
            $html .= "<a " . $style . " data-ref='" . $entity->getId() . "' class='parentcategorylia'>" . $entity->getName() . "</a>";

            $html .= "<ul class='productcategory categoryul categoryul_" . $entity->getId() . "'>";

            foreach ($entities2 as $entity2) {
                $checked = in_array($entity2->getId(), (array) $cats) ? 'checked' : '';
                $style = in_array($entity2->getId(), $cats) ? "style='color:red'" : '';
                $html .= "<li " . $style . " class='categoryli categoryli_" . $entity->getId() . "'><input " . $checked . " class='productcategorychk' data-product='" . $product->getId() . "' data-ref='" . $entity2->getId() . "' type='checkbox'/>" . $entity2->getName() . "</li>";
            }
            $html .= '</ul>';

            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
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
        $this->q_and[] = $this->prefix . ".sisxetisi in  (Select k.sisxetisi FROM SoftoneBundle:Product k where k.id = '" . $id . "') AND " . $this->prefix . ".sisxetisi != ''  AND " . $this->prefix . ".id != '" . $id . "'";
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
        //$fields = unserialize($this->getSetting("SoftoneBundle:Product:getdatatable"));
        //if (count($fields) == 0 OR $this->getSetting("SoftoneBundle:Product:getdatatable") == '') {
        $fields[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $fields[] = array("name" => $this->getTranslation("Product Title"), "index" => 'title');
        $fields[] = array("name" => $this->getTranslation("Product Code"), "index" => 'erpCode');
        $fields[] = array("name" => $this->getTranslation("Product Supplier"), "index" => 'supplierId:title', 'type' => 'select', 'object' => 'SoftoneSupplier');
        $fields[] = array("name" => $this->getTranslation("Offer"), "index" => 'productSale:title', 'type' => 'select', 'object' => 'ProductSale');
        $fields[] = array("name" => $this->getTranslation("Product Place"), "index" => 'itemMtrplace');
        $fields[] = array("name" => $this->getTranslation("Syncrhonize"), "index" => 'cccPriceUpd', 'method' => 'yesno');


        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'foxline') {
            $fields[] = array("name" => $this->getTranslation("Retail"), "index" => 'itemPricew02');
            $fields[] = array("name" => $this->getTranslation("Wholesale"), "index" => 'itemPricew01');
            $fields[] = array("name" => $this->getTranslation("Eshop Price"), "index" => 'itemPricew04');
        } elseif ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
            $fields[] = array("name" => $this->getTranslation("Wholesale"), "index" => 'itemPricew01');
            $fields[] = array("name" => $this->getTranslation("Olympic"), "index" => 'itemPricew03');
        } else {
            $fields[] = array("name" => $this->getTranslation("Retail"), "index" => 'itemPricer');
            $fields[] = array("name" => $this->getTranslation("Wholesale"), "index" => 'itemPricew');
        }




        $fields[] = array("name" => $this->getTranslation("Invetory"), "function" => 'getApothiki', 'search' => 'text');
        $fields[] = array("name" => "", "function" => 'getEditLink', 'search' => 'text');
        $this->setSetting("SoftoneBundle:Product:getdatatable", serialize($fields));
        //}


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
        //$content = $this->gettabs(1);
        //$content = $this->getoffcanvases($id);
        //$content = $this->content();

        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };         
        $article_id = $request->request->get("articleId");
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($request->request->get("ref"));

        $params["articleId"] = $article_id;

        $params["linkingTargetId"] = $request->request->get("car");
        $out["originals"] = $tecdoc->originals($params);
        $out["articleAttributes"] = $tecdoc->articleAttributesRow($params, 0) . "<img width=100% src='" . $this->media($params["articleId"]) . "'/>[" . $this->media($params["articleId"]) . "]";

        //$asd = unserialize($this->getArticlesSearchByIds($article_id));
        //$out["articlesSearch"] = $tecdoc->getArticlesSearch($asd[0]->articleNo);
        //$out["articlesSearch"] = unserialize($this->getArticlesSearchByIds(implode(",", (array) $out["articlesSearch"])));
        //print_r( $out["articlesSearch"]);
        $egarmoges = '<ul>';
        foreach ($tecdoc->efarmoges($params) as $efarmogi) {
            $brandModelType = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModelType')->find($efarmogi);
            if (!$brandModelType)
                continue;
            $brandModel = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModel')->find($brandModelType->getBrandModel());
            if (!$brandModel)
                continue;
            $brand = $this->getDoctrine()->getRepository('SoftoneBundle:Brand')->find($brandModel->getBrand());
            if (!$brand)
                continue;
            $egarmoges .= '<li>' . $brand->getBrand() . ' ' . $brandModel->getBrandModel() . ' ' . $brandModelType->getBrandModelType() . '</li>';
        }
        $egarmoges .= '</ul>';
        $out["efarmoges"] = $egarmoges;

        //$content = 'sss';
        return $this->render('SoftoneBundle:Product:productInfo.html.twig', array(
                    'pagename' => 's',
                    'order' => $id,
                    'url' => '/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $out,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    public function media($tecdocArticleId) {

        //$product = json_decode($this->flat_data);
        if ($tecdocArticleId == "")
            return;


        $url = "http://service5.fastwebltd.com/";
        $fields = array(
            'action' => 'media',
            'tecdoc_article_id' => $tecdocArticleId
        );

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
        //$this->media = $data;
        //$this->save();
        return $data;
    }

    /**
     * @Route("/product/fororderajaxjson")
     */
    public function fororderajaxjsonAction() {
        return new Response(
                "", 200
        );
    }

    /**
     * @Route("/product/tob2b/{id}")
     */
    function tob2bAction($id) {
        //return;
        //$requerstUrl = $this->getSetting("SoftoneBundle:Softone:b2burl")."test.php"; 
        $requerstUrl = $this->getSetting("SoftoneBundle:Softone:b2burl") . "antallaktika/init/setpartsbox";
        $em = $this->getDoctrine()->getManager();
        $object = "SoftoneBundle\Entity\Product";
        $fields = $em->getClassMetadata($object)->getFieldNames();
        //print_r($fields);

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        foreach ($fields as $field) {
            $data[$field] = $entity->getField($field);
        }
        $out["a"] = 1;
        //print_r($data);
        $data_string = json_encode($data);

        //echo  $data_string;	
        //echo $requerstUrl;
        //urlencode
        $result = file_get_contents($requerstUrl . "?data=" . urlencode($data_string), null, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                'Content-Type: application/json' . "\r\n"
                . 'Content-Length: ' . strlen($data_string) . "\r\n",
                'content' => $data_string,
            ),
        )));

        //echo $result;
        exit;
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

    function retrieveMtrmanfctr() {
        $params["fSQL"] = "SELECT M.* FROM MTRMANFCTR M ";
        $softone = new Softone();
        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            $datas = $softone->getManufactures($params);
            $datas = $softone->createSql($params);
        } else {
            $datas = $softone->createSql($params);
        }
        //echo 'sss';
        //echo "<PRE>";
        //print_r($datas);
        //echo "</PRE>";
        //exit;

        foreach ((array) $datas->data as $data) {
            $data = (array) $data;
            //print_r($data);
            $SoftoneSupplier = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")->find($data["MTRMANFCTR"]);
            if ($SoftoneSupplier->id == 0) {
                if ($data["ISACTIVE"] == 1) {
                    $sql = "Insert softone_softone_supplier SET id = '" . $data["MTRMANFCTR"] . "', title = '" . addslashes($data["NAME"]) . "', code = '" . $data["CODE"] . "'";
                    $this->getDoctrine()->getConnection()->exec($sql);
                }
            } else {
                //echo $data["ISACTIVE"]."<BR>";
                if ($data["ISACTIVE"] == 1) {
                    if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'gianop') {
                        $name = str_replace(" - " . $data["CODE"], "", $data["NAME"]);
                        $sql = "update softone_softone_supplier SET title = '" . addslashes($name) . "', code = '" . $data["CODE"] . "' where id = '" . $data["MTRMANFCTR"] . "'";
                        echo $sql . "<BR>";
                        //$this->getDoctrine()->getConnection()->exec($sql);
                    }
                } else {
                    $sql = "delete from softone_softone_supplier where id = '" . $data["MTRMANFCTR"] . "'";
                    echo $sql . "<BR>";
                    //$this->getDoctrine()->getConnection()->exec($sql);
                }
                //$this->getDoctrine()->getConnection()->exec($sql);			
            }
        }
        //exit;
    }

    function retrieveMtrl($MTRL = 0) {
        ini_set('memory_limit', '12256M');

        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline' OR $this->getSetting("SoftoneBundle:Softone:merchant") == 'gianop') {
            //$MTRL = 263528;
            $MTRL1 = 0;
            $MTRL2 = 100;
            $UPDDATE = date("-1 week");
        }

        $params = unserialize($this->getSetting("SoftoneBundle:Product:retrieveMtrl"));



        //$extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND", "CCCFXTDBRAND" => "CCCFXTDBRAND");
        //$extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND");

        if (count($params) > 0) {
            if ($MTRL1 > 0) {
                //$where = " AND  UPDDATE >= '" . date("Y-m-d", strtotime("-35 days")) . "' ORDER BY MTRL";
                $where = " AND  MTRL >= ".$MTRL1." AND MTRL < ".$MTRL2."  ORDER BY MTRL"; 
                //$where = " AND UPDDATE = '" . date("Y-m-d") . "'";
            } else {
                $where = " AND UPDDATE >= '" . date("Y-m-d", strtotime("-8 days")) . "' ORDER BY MTRL";
            }
            

            if ($MTRL > 0) {
                $where = ' AND MTRL = ' . $MTRL . ' ';
            }

            $params["softone_object"] = "item";
            $params["repository"] = 'SoftoneBundle:Product';
            $params["softone_table"] = 'MTRL';
            $params["table"] = 'softone_product';
            $params["object"] = 'SoftoneBundle\Entity\Product';
            if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'gianop') {
                $params["filter"] = 'WHERE M.SODTYPE=51 ' . $where;
                //$params["filter"] = "WHERE M.SODTYPE=51 AND M.CODE2 = '19050'";
                //$extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND");
                $params["extra"] = array(); //$this->getSetting("SoftoneBundle:Softone:merchant") ? $extra[$this->getSetting("SoftoneBundle:Softone:merchant")] : array("cccRef" => "cccRef", "cccWebUpd" => "cccWebUpd", "cccPriceUpd" => "cccPriceUpd");
            } else {
                if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
                    $where = " AND UPDDATE >= '" . date("Y-m-d", strtotime("-5 days")) . "' ORDER BY MTRL";
                    //$where = " AND UPDDATE >= '2017-02-18' ORDER BY MTRL";
                    $extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND", "CCCFXTDBRAND" => "CCCFXTDBRAND");
                } else {
                    $extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND");
                }
                $extra["foxline"] = array();//array("CCCFXRELTDCODE" => "CCCFXRELTDCODE");
                $params["filter"] = 'WHERE M.SODTYPE=51 ' . $where;
                $params["extra"] = $this->getSetting("SoftoneBundle:Softone:merchant") ? $extra[$this->getSetting("SoftoneBundle:Softone:merchant")] : array("cccRef" => "cccRef", "cccWebUpd" => "cccWebUpd", "cccPriceUpd" => "cccPriceUpd");
            }
            $params["relation"] = array();
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
        $this->retrieveProduct($params);


        $sql = 'update `softone_product` set `tecdoc_supplier_id` =  `item_mtrmark` where tecdoc_supplier_id is null';
        $this->getDoctrine()->getConnection()->exec($sql);

        $sql = 'UPDATE  `softone_product` SET tecdoc_supplier_id = NULL WHERE  `tecdoc_supplier_id` = 0';
        $this->getDoctrine()->getConnection()->exec($sql);

        $sql = 'update `softone_product` set product_sale = 1 where product_sale is null';
        $this->getDoctrine()->getConnection()->exec($sql);

        $sql = 'UPDATE  `softone_product` SET `supplier_id` =  `item_mtrmanfctr` WHERE  `item_mtrmanfctr` IS NOT NULL AND item_mtrmanfctr in (select id from softone_softone_supplier)';
        $this->getDoctrine()->getConnection()->exec($sql);

        $sql = 'UPDATE  `softone_product` SET `supplier_code` =  `item_code2`, `title` =  `item_name`, `tecdoc_code` =  `item_apvcode`, `erp_code` =  `item_code`';
        $this->getDoctrine()->getConnection()->exec($sql);

        if ($MTRL > 0) {
            $tecdoc = new Tecdoc();
            if ($this->getSetting("AppBundle:Entity:lng") > 0) {
                $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
            };             
            $entity = $this->getDoctrine()
                    ->getRepository($params["repository"])
                    ->findOneBy(array("reference" => (int) $MTRL));
            if (@$entity->id > 0) {
                $entity->tecdoc = $tecdoc;
                $entity->updatetecdoc();
            }
        }
    }

    function retrieveProduct($params = array()) {
        ini_set('memory_limit', '12256M');
        $object = $params["object"];
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata($params["object"])->getFieldNames();
        //print_r($fields);

        $itemfield = array();
        $itemfield[] = "M." . $params["softone_table"];

        /*
          $special[] = "CCCREF";
          $special[] = "CCCWEBUPD";
          $special[] = "CCCPRICEUPD";
         */
        //,M.CCCWEBUPD,M.CCCPRICEUPD

        foreach ($fields as $field) {
            $ffield = " " . $field;
            if (strpos($ffield, $params["softone_object"]) == true) {
                $itemfield[] = "M." . strtoupper(str_replace($params["softone_object"], "", $field));
            }
        }
        foreach ($params["extra"] as $field => $extra) {
            //if (@$data[$extra] AND in_array($field, $fields)) {
            if ($field == $extra)
                $itemfield[] = "M." . strtoupper($field);
            else
                $itemfield[] = "M." . strtoupper($field) . " as $extra";
            //}
        }

        $selfields = implode(",", $itemfield);
        $params["fSQL"] = 'SELECT ' . $selfields . ' FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        //echo $params["fSQL"];
        //exit;
        //$params["fSQL"] = 'SELECT M.* FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        //$params["fSQL"] = "SELECT VARCHAR02, MTRL FROM MTREXTRA WHERE VARCHAR02 != ''";
        //$sql = "SELECT M.MTRL,M.INSDATE,M.UPDDATE,M.ISACTIVE,M.VAT,M.MTRMANFCTR,M.MTRMARK,M.REMARKS,M.MARKUPW,M.MARKUPR,M.PRICER,M.PRICEW,M.PRICEW01,M.PRICEW02,M.PRICEW03,M.PRICEW04,M.PRICEW05,M.PRICER01,M.PRICER02,M.PRICER03,M.PRICER04,M.PRICER05,M.NAME,M.NAME1,M.CODE,M.CODE1,M.CODE2,M.APVCODE,M.MTRPLACE,M.MTRSUP,M.MTRCATEGORY,M.MTRGROUP FROM MTRL M WHERE M.SODTYPE=51 AND MTRL = 421443";
        // echo "<BR>";
        //echo $params["fSQL"];
        echo $params["fSQL"];
        // echo "<BR>";
        //return;
        $softone = new Softone();
        $datas = $softone->createSql($params);
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
            echo "<PRE>";
            //print_r($datas);
            echo "</PRE>";
            //exit;
        }
        //echo "<BR>" . count($datas->data) . "<BR>";
        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'gianop') {
            //exit;
        }
        $em = $this->getDoctrine()->getManager();

        echo "<BR><BR><BR>";
        /*
          foreach ((array) $datas->data as $data) {
          $sql = "update softone_product set sisxetisi = '" . $data->VARCHAR02 . "' where reference = '" . $data->MTRL . "'";
          echo $sql . "<BR>";
          $em->getConnection()->exec($sql);
          }
          exit;
         * 
         */
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };         
        ini_set('memory_limit', '12256M');
        
        echo count($datas->data);
        print_r($datas);
        echo "<BR>";
        exit;
        foreach ((array) $datas->data as $data) {
            $data = (array) $data;
            //print_r($data);
            //echo "<BR>";
            //exit;
            //echo $data["MTRL"]."<BR>";
            if ($i++ < 23000) continue;
            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneBy(array("reference" => (int) $data["MTRL"]));

            echo "[" . @$entity->id . " -- " . $data["MTRL"] . "]<BR>";
            //if ($data[$params["softone_table"]] != 13121) continue;
            $dt = new \DateTime("now");
            /*
              if (@$entity->id == 0) {
              $entity = $this->getDoctrine()
              ->getRepository($params["repository"])
              ->findOneBy(array("itemCode" => $data["CODE"]));
              }
             * 
             */
            if (@$entity->id == 0) {
                $entity = new $object();
                $entity->setTs($dt);
                $entity->setCreated($dt);
                $entity->setModified($dt);
            } else {
                continue;
                //$entity->setRepositories();                
            }

            //@print_r($entity->repositories);
            foreach ($params["relation"] as $field => $extra) {
                //echo $field." - ".@$data[$extra]."<BR>";
                if (@$data[$extra] AND in_array($field, $fields)) {
                    $entity->setField($field, @$data[$extra]);
                }
                //echo @$entity->repositories[$field];
                if (@$data[$extra] AND @ $entity->repositories[$field]) {
                    $rel = $this->getDoctrine()->getRepository($entity->repositories[$field])->findOneById($data[$extra]);
                    $entity->setField($field, $rel);
                }
            }
            echo $data[$params["softone_table"]] . "<BR>";
            /*
              $imporetedData = array();
              $entity->setReference($data[$params["softone_table"]]);

              $em->persist($entity);
              $em->flush();
             */
            //$this->flushpersist($entity);
            $q = array();
            $hasmark = false;
            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($params["softone_object"] . "_" . $identifier)] = addslashes($val);
                $ad = strtolower($identifier);
                $baz = $params["softone_object"] . ucwords(str_replace("_", " ", $ad));

                if (in_array($baz, $fields)) {
                    if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline' AND strtolower($params["softone_object"] . "_" . $identifier) == 'item_apvcode') {
                        continue;
                    }
                    //echo $this->getSetting("SoftoneBundle:Softone:merchant")."<BR>";    
                    if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
                        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
                            $identifier = strtolower($identifier);
                            if ($identifier != 'mtrmark' AND $identifier != 'apvcode') {
                                //$q[] = "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'";
                                //echo $identifier."<BR>";
                            }
                        //} elseif ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
                        //    $hasmark = true;
                        } else {
                            if ($identifier != 'mtrmark' AND $identifier != 'apvcode') {
                                $q[] = "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'";
                                $hasmark = true;
                                //echo  "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'<BR>";
                            }
                        }
                    } else {
                        $q[] = "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'";
                        //echo  "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'<BR>";
                        $hasmark = true;
                    }
                    //$entity->setField($baz, $val);
                }
            }
            //print_r($data);
            if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {

                if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
                    $data["REMARKS"] = str_replace("\n", "|", $data["REMARKS"]);
                    $data["REMARKS"] = str_replace("\r", "|", $data["REMARKS"]);
                    $data["REMARKS"] = str_replace("||", "|", $data["REMARKS"]);

                    //mtrmanfctr
                    //$data["MTRMANFCTR"];

                    if (addslashes($data["CCCFXRELTDCODE"]) != '')
                    //if (addslashes($data["CCCFXRELTDCODE"]) != '')
                        $q[] = "`" . strtolower($params["softone_object"] . "_apvcode") . "` = '" . addslashes($data["CCCFXRELTDCODE"]) . "'";
                    if (addslashes($data["CCCFXTDBRAND"]) != '' AND $hasmark == false)
                        $q[] = "`" . strtolower($params["softone_object"] . "_mtrmark") . "` = '" . addslashes($data["CCCFXTDBRAND"]) . "'";
                    //if (addslashes($data["CCCFXRELBRAND"]) != '')
                    //	$q[] = "`" . strtolower($params["softone_object"] . "_mtrmanfctr") . "` = '" . addslashes($data["CCCFXRELBRAND"]) . "'";
                } else {
                    if (addslashes($data["CCCFXTDBRAND"]) != '') {
                        $data["CCCFXRELBRAND"] = $data["CCCFXTDBRAND"];
                    }
                    //$extra["foxline"] = array("CCCFXRELTDCODE" => "CCCFXRELTDCODE", "CCCFXRELBRAND" => "CCCFXRELBRAND"); 

                    if (addslashes($data["CCCFXRELTDCODE"]) != '')
                    //if (addslashes($data["CCCFXRELTDCODE"]) != '')
                        $q[] = "`" . strtolower($params["softone_object"] . "_apvcode") . "` = '" . addslashes($data["CCCFXRELTDCODE"]) . "'";

                    if (addslashes($data["CCCFXRELBRAND"]) != '' AND $hasmark == false) {
                        $q[] = "`" . strtolower($params["softone_object"] . "_mtrmark") . "` = '" . addslashes($data["CCCFXRELBRAND"]) . "'";
                        echo "<BR><BR><BR>----------<BR><BR>";
                    }
                }
                if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
                    $q[] = "`" . strtolower($params["softone_object"] . "_mtrmark") . "` = '" . addslashes($data["CCCFXRELBRAND"]) . "'";
                }
            } else {
                $q[] = "`" . strtolower($params["softone_object"] . "_cccpriceupd") . "` = '" . addslashes($data["CCCPRICEUPD"]) . "'";
                $q[] = "`" . strtolower($params["softone_object"] . "_cccwebupd") . "` = '" . addslashes($data["CCCWEBUPD"]) . "'";
                $q[] = "`" . strtolower($params["softone_object"] . "_cccref") . "` = '" . addslashes($data["CCCREF"]) . "'";
            }
            //print_r($q);
            if (@$entity->id == 0) {
                $q[] = "`reference` = '" . $data[$params["softone_table"]] . "'";
                $sql = "insert " . strtolower($params["table"]) . " set " . implode(",", $q) . "";
                echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            } else {
                $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->id . "'";
                echo ".";
                //echo $sql . "<BR>";
                //
                //$em->getConnection()->exec($sql);
                continue;
            }
            $entity = $this->getDoctrine()
                    ->getRepository($params["repository"])
                    ->findOneBy(array("reference" => (int) $data[$params["softone_table"]]));
            if (@$entity->id > 0) {
                $entity->tecdoc = $tecdoc;
                $entity->updatetecdoc();
                $entity->setProductFreesearch();
            }
            /*
              @$entity_id = (int) $entity->id;
              //if (@$entity_id > 0) {
              $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity_id . "'";
              echo $sql."<BR>";
              $em->getConnection()->exec($sql);
              foreach ($params["extrafunction"] as $field => $func) {
              //$entity->$func();
              }
              //}
             * 
             */
            $entity = null;
            if (@$i++ > 150)
                break;
        }
    }

    /**
     * @Route("/product/autocompletesearch")
     */
    public function autocompletesearchAction() {
        //echo $_GET["term"];
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT  p.id, p.title, p.erpCode
                    FROM " . $this->repository . " p
                    where p.itemCode2 like '" . $this->clearstring($_GET["term"]) . "%' OR p.itemCode like '" . $this->clearstring($_GET["term"]) . "%' OR p.itemApvcode like '" . $this->clearstring($_GET["term"]) . "%'"
        );
        $results = $query->getResult();
        $jsonArr = array();
        foreach ($results as $result) {
            $json["id"] = $result["id"];
            $json["label"] = $result["title"] . ' ' . $result["erpCode"];
            $json["value"] = $result["erpCode"];
            $jsonArr[] = $json;
        }
        $json = json_encode($jsonArr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/product/product/updatetecdoc")
     */
    public function getUpdateTecdocAction($funct = false) {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
                "SELECT  p.id
                    FROM " . $this->repository . " p
                    where p.tecdocSupplierId > 0 AND p.tecdocArticleId IS NULL order by p.id asc"
        );
        /*
          $query = $em->createQuery(
          "SELECT  p.id
          FROM " . $this->repository . " p, EdiBundle:Edi e
          where
          e.id = p.Edi AND p.dlnr > 0 order by p.id asc"
          );
         * 
         */

        $results = $query->getResult();
        echo count($results);
        $i = 0;
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };         
        foreach ($results as $result) {
            //if ($result["id"] > 41170) {
            $ediediitem = $em->getRepository($this->repository)->find($result["id"]);
            $ediediitem->tecdoc = $tecdoc;
            $ediediitem->updatetecdoc();
            unset($ediediitem);
            echo $result["id"] . "<BR>";
            //if ($i++ > 3000) exit;
            // }
        }
        exit;
    }

    /**
     * @Route("/product/product/freeserach")
     */
    public function getFreeSearchAction($funct = false) {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
                "SELECT  p.id
                    FROM " . $this->repository . " p"
        );
        /*
          $query = $em->createQuery(
          "SELECT  p.id
          FROM " . $this->repository . " p, EdiBundle:Edi e
          where
          e.id = p.Edi AND p.dlnr > 0 order by p.id asc"
          );
         * 
         */

        $results = $query->getResult();
        echo count($results);
        $i = 0;
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };         
        echo "<BR>";
        foreach ($results as $result) {
            //if ($result["id"] > 41170) {
            echo $result["id"] . "<BR>";
            $ediediitem = $em->getRepository($this->repository)->find($result["id"]);
            //$ediediitem->tecdoc = $tecdoc;
            $ediediitem->setProductFreesearch();
            unset($ediediitem);
            //echo $result["id"] . "<BR>";
            //if ($i++ > 30) exit;
            // }
        }
        exit;
    }

    /**
     * @Route("/product/product/synchronize")
     */
    public function synchronizeAction($funct = false) {
        $softone = new Softone();
        $em = $this->getDoctrine()->getManager();
        $ediedis = $this->getDoctrine()->getRepository('EdiBundle:Edi')->findAll();
        foreach ($ediedis as $ediedi) {
            if ($ediedi->getId() == 4)
            //echo $ediedi->getItemMtrsup();
                if ($ediedi->getItemMtrsup() > 0) {
                    $products = $this->getDoctrine()->getRepository('SoftoneBundle:Product')->findBy(array("itemMtrsup" => $ediedi->getItemMtrsup()), array('id' => 'desc'));
                    echo count($products);
                    foreach ($products as $product) {
                        //echo ".";
                        //$brand = $product->getSupplierId() ? $product->getSupplierId()->getTitle() : "";
                        /*
                          $ediediitem = $this->getDoctrine()
                          ->getRepository('EdiBundle:EdiItem')
                          ->findOneBy(array("itemCode" => $product->getCccRef(), "Edi" => $ediedi));
                          if (!$ediediitem) {

                          }
                         * 
                         */
                        //if ($product->getCccPriceUpd() == 1) continue;
                        //if ($i++ > 10) exit; 
                        //$this->clearstring($search);
                        //if ($product->getCccRef() != 'BR09.9824.10') continue;
                        //echo $product->getCccRef();

                        $ediediitem = false;
                        $newcccref = false;
                        $code = trim($this->clearstring($product->getCccRef()));
                        if ($code != '') {
                            $sql = "Select id from partsbox_db.edi_item where 
                                            replace(replace(replace(replace(replace(`itemcode`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $code . "' AND edi = '" . $ediedi->getId() . "'
                                            limit 0,100";

                            //echo $sql . "<BR>";
                            $connection = $em->getConnection();
                            $statement = $connection->prepare($sql);
                            $statement->execute();
                            $data = $statement->fetch();
                            ;
                            //echo "<BR>";
                            echo ".";
                            if ($data["id"] > 0)
                                $ediediitem = $this->getDoctrine()->getRepository('EdiBundle:EdiItem')->find($data["id"]);
                        }
                        if (!$ediediitem) {
                            $brand = $product->getSupplierId() ? $product->getSupplierId()->getTitle() : "";
                            if ($brand != '') {
                                $ediediitem = $this->getDoctrine()
                                        ->getRepository('EdiBundle:EdiItem')
                                        ->findOneBy(array("partno" => $this->clearstring($product->getItemCode2()), 'brand' => $brand, "Edi" => $ediedi));
                                if ($ediediitem) {
                                    echo $this->clearstring($product->getItemCode2()) . "<BR>";
                                    $product->setCccRef($ediediitem->getItemCode());
                                    $newcccref = true;
                                }
                            }
                        }

                        //if ($brand == "BERU")
                        //if ($i++ > 240)
                        //    exit;
                        //continue;
                        if ($ediediitem) {
                            $itemPricew = $ediediitem->getEdiMarkupPrice("itemPricew");
                            $itemPricer = $ediediitem->getEdiMarkupPrice("itemPricer");
                            if ($product->getCccPriceUpd() == 0 OR $newcccref OR round($itemPricew, 2) != round($product->getItemPricew(), 2) OR round($itemPricer, 2) != round($product->getItemPricer(), 2)) {
                                //echo $ediedi->getName() . " -- " . $product->getItemCode() . " -- " . $product->getSupplierId()->getTitle() . " -- " . $product->getItemCode2() . " " . $ediediitem->getWholesaleprice() . " -- " . $ediediitem->getEdiMarkupPrice("itemPricew") . " -- " . $product->getItemPricew() . "<BR>";
                                //if ($i++ > 15)
                                //    exit;
                                if ($itemPricew > 0.01 AND $product->getReference() > 0) {
                                    $color = '';
                                    if ($itemPricew == $itemPricer) {
                                        $color = 'red';
                                    }
                                    echo "<div style='color:" . $color . "'>";
                                    echo $ediedi->getName() . " " . $ediediitem->getWholesaleprice() . " -- " . $product->getItemCode() . " itemPricew:(" . $itemPricew . "/" . $product->getItemPricew() . ") itemPricer:(" . $itemPricer . "/" . $product->getItemPricer() . ")<BR>";

                                    $product->setCccPriceUpd(1);
                                    $product->setItemPricew($itemPricew);
                                    $product->setItemPricer($itemPricer);
                                    //
                                    //echo $product->id." ".$product->erp_code." --> ".$qty." -- ".$product->getApothema()."<BR>";
                                    $sql = "update softone_product set item_pricew = '" . $itemPricew . "', item_pricer = '" . $itemPricer . "', item_cccpriceupd = 1, item_cccref = '" . $product->getCccRef() . "'   where id = '" . $product->getId() . "'";
                                    echo $sql . "<BR>";
                                    $em->getConnection()->exec($sql);
                                    //$this->flushpersist($product);
                                    //$product->toSoftone();
                                    if ($newcccref)
                                        $sql = "UPDATE MTRL SET CCCREF='" . $product->getCccRef() . "', CCCPRICEUPD=1, PRICEW = " . $itemPricew . ", PRICER = " . $itemPricer . "  WHERE MTRL = " . $product->getReference();
                                    else
                                        $sql = "UPDATE MTRL SET CCCPRICEUPD=1, PRICEW = " . $itemPricew . ", PRICER = " . $itemPricer . "  WHERE MTRL = " . $product->getReference();

                                    $params["fSQL"] = $sql;
                                    $product->toSoftone();
                                    //$softone = new Softone();
                                    //$datas = $softone->createSql($params);
                                    //unset($softone);
                                    //echo $sql . "<BR>";
                                    //sleep(5);

                                    echo "</div>";
                                }
                            } else {
                                echo "<span style='color:red'>" . $product->getItemCode() . " -- " . $product->getSupplierId()->getTitle() . " -- " . $product->getItemCode2() . " " . $ediediitem->getWholesaleprice() . " -- " . $ediediitem->getEdiMarkupPrice("itemPricew") . " -- " . $product->getItemPricew() . "</span><BR>";
                            }
                        } else {
                            //echo "<span style='color:red'>".$product->getItemCode().";".$product->getSupplierId()->getTitle().";" . $product->getItemCode2() . "</span><BR>";
                        }
                        //exit;
                    }
                }
        }
        exit;
    }

    /**
     * 
     * @Route("/product/retrieveMtrl/{mtrl}")
     */
    function retrieveMtrlAction($mtrl) {

        $allowedips = $this->getSetting("SoftoneBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            echo $this->retrieveMtrl($mtrl);
            $product = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneByReference($mtrl);
            $product->updatetecdoc();
            $product->setProductFreesearch();
            return new Response(
                    "", 200
            );
        } else {
            exit;
        }
    }

    /**
     * 
     * @Route("/product/retrieveSoftone")
     */
    function retrieveSoftoneDataAction($params = array()) {
        $allowedips = $this->getSetting("SoftoneBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        echo $_SERVER["REMOTE_ADDR"];
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user or in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            set_time_limit(100000);
            //ini_set('memory_limit', '2256M');
            //echo $this->retrieveMtrcategory();
            echo $this->retrieveMtrmanfctr();
            echo $this->retrieveMtrl();
            file_put_contents("retrieveSoftone.txt", $allowedipsArr);
            //echo $this->retrieveApothema();
        } return new Response("", 200);
    }

    /**
     * 
     * @Route("/product/retrieveApothema")
     */
    function retrieveApothemaAction() {
        echo $_SERVER["REMOTE_ADDR"];
        $allowedips = $this->getSetting("SoftoneBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        file_put_contents("ip.txt", $_SERVER["REMOTE_ADDR"]);

        //if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
        //echo "aaaa";
        //exit;
        file_put_contents("ip1.txt", $_SERVER["REMOTE_ADDR"]);
        $this->retrieveApothema();
        exit;
        //} else {
        //echo 'sss';
        exit;
        //}
    }

    function retrieveApothema($filters = false) {
        //function retrieveProducts($filters=false) {
        //$this->catalogue = 4;
        //$filters = "ITEM.V3=".date("Y-m-d")."&ITEM.V4=1";//. date("Y-m-d");
        //$filters = "ITEM.V3=2015-07-29&ITEM.V4=1";//. date("Y-m-d");
        //$filters = "ITEM.SORENQTY1>1";  
        //$filters = "ITEM.UPDDATE=".date("Y-m-d")."&ITEM.UPDDATE_TO=".date("Y-m-d");  
        //$filters = "ITEM.ISACTIVE=1";  
        //return;
        $softone = new Softone();
        //$datas = $softone->retrieveData("ITEM", "apothema");

        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            $filters = "ITEM.V5=*";
            $datas = $softone->retrieveData("ITEM", "apothema", $filters);
            echo "<BR>" . count($datas) . "<BR>";
            //exit;
        } else {
            $datas = $softone->retrieveData("ITEM", "apothema");
            echo "<BR>" . count($datas) . "<BR>";
        }

        //$datas = $softone->retrieveData("ITEM", "apothema");
        //echo 'Sss';
        echo count($datas) . "<BR>";
        //print_r($datas);
        //exit;
        $em = $this->getDoctrine()->getManager();

        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            //if ($data["item_mtrl_itemtrdata_qty1"] > 0 OR $data["item_soreserved"] > 0) {
            //$sql = "update softone_product set edis='', qty = '0', reserved = '0'";
            //echo $sql . "<BR>";
            //$em->getConnection()->exec($sql);
            //}			
        }
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
            $edis = 'Γέρακας:  / <span class="text-lg text-bold text-accent-dark">0</span> (0)<BR>';
            $edis .= 'Κορωπί: 0 / <span class="text-lg text-bold text-accent-dark">0</span> (0)';
            $sql = "update softone_product set edis = '" . $edis . "', qty = '0', reserved = '0'";
            echo $sql . "<BR>";
            $em->getConnection()->exec($sql);
        }
        foreach ($datas as $data) {

            //print_r($data);
            //exit;	
            $zoominfo = $data["zoominfo"];
            $info = explode(";", $zoominfo);
            $data["reference"] = $info[1];
            //if ($data["reference"] != 21927) continue;   
            if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
                //print_r($data);
                //exit;			
                $data["item_mtrl_itemtrdata_qty1"] = $data["item_v3"] + $data["item_v4"];
                $data["item_soreserved"] = $data["item_v7"] + $data["item_v6"];
                $qty1 = (int) $data["item_v3"] - (int) $data["item_v7"];
                $qty2 = (int) $data["item_v4"] - (int) $data["item_v6"];
                $edis = "Κορωπί: " . (int) $data["item_v3"] . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty1) . '</span> (' . $data["item_mtrplace"] . ")<BR>";
                $edis .= "Γέρακας: " . (int) $data["item_v4"] . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty2) . '</span> (' . $data["item_mtrl_iteextra_varchar04"] . ")";
                $sql = "update softone_product set edis = '" . $edis . "', qty = '" . $data["item_mtrl_itemtrdata_qty1"] . "', reserved = '" . $data["item_soreserved"] . "' where reference = '" . $data["reference"] . "'";
                if ($data["item_soreserved"] > 0 OR $data["item_mtrl_itemtrdata_qty1"] > 0) {
                    echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                }
            } elseif ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
                //if ($data["item_mtrl_itemtrdata_qty1"] > 0 OR $data["item_soreserved"] > 0) {
                //$sql = "update softone_product set qty = '" . $data["item_mtrl_itemtrdata_qty1"] . "', reserved = '" . $data["item_soreserved"] . "' where reference = '" . $data["reference"] . "'";
                //echo $sql . "<BR>";
                //$em->getConnection()->exec($sql);
                if ($data["item_soreserved"] > 0) {
                    $reserveds[$data["item_soreserved"]][] = $data["reference"];
                    //$sql = "update softone_product set reserved = '" . $data["item_soreserved"] . "' where reference = '" . $data["reference"] . "'";
                    //echo $sql . "<BR>";					
                }
                $qtys[$data["item_mtrl_itemtrdata_qty1"]][] = $data["reference"];
                //$reserved[$data["item_soreserved"]][] =  $data["reference"];
                //print_r($qty);
                //exit;
                //}			
            } else {
                //if ($data["item_mtrl_itemtrdata_qty1"] > 0 OR $data["item_soreserved"] > 0) {
                //$sql = "update softone_product set qty = '" . $data["item_mtrl_itemtrdata_qty1"] . "', reserved = '" . $data["item_soreserved"] . "' where reference = '" . $data["reference"] . "'";
                //echo $sql . "<BR>";
                //$em->getConnection()->exec($sql);

                if ($data["item_soreserved"] > 0) {
                    $reserveds[$data["item_soreserved"]][] = $data["reference"];
                    //$sql = "update softone_product set reserved = '" . $data["item_soreserved"] . "' where reference = '" . $data["reference"] . "'";
                    //echo $sql . "<BR>";					
                }
                $qtys[$data["item_mtrl_itemtrdata_qty1"]][] = $data["reference"];
                //}
            }

            //$em->getConnection()->exec($sql);
            //if ($i++ > 100) return;
        }
        //if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
            
        } else {
            $sql = "update softone_product set reserved = 0";
            echo $sql . "<BR>";
            $em->getConnection()->exec($sql);
            foreach ((array) $reserveds as $reserved => $reference) {
                $sql = "update softone_product set reserved = '" . $reserved . "' where reference in (" . implode(",", $reference) . ")";
                echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            }
            foreach ((array) $qtys as $qty => $reference) {
                $sql = "update softone_product set qty = '" . $qty . "' where reference in (" . implode(",", $reference) . ")";
                echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            }
        }
        //}
        //print_r($qty);
        //exit;
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
     * 
     * @Route("/product/getProducts")
     */
    public function getProducts(Request $request) {
        //echo 'ssss';
        $allowedips = $this->getSetting("SoftoneBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        //if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $sql = "SELECT * FROM  `softone_product`";
            $connection = $this->getDoctrine()->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $arr = array();
            foreach ($results as $data) {
                $arr[] = $data;
            }
            $json = json_encode($arr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
       // } else {
         //   
            exit;
        //}
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
