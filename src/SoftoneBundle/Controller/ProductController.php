<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\Product as Product;
use SoftoneBundle\Entity\Pcategory as Pcategory;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProductController extends Main {

    var $repository = 'SoftoneBundle:Product';
    var $object = 'item';
    /**
     * @Route("/product/product")
     * 
     */
    public function indexAction() {

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
     * @Route("/product/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();

        
        $product = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        
        
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
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
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
                ->getRepository($this->repository)
                ->find($id);
        $entity->updatetecdoc();
        $fields["erpCode"] = array("label" => "Erp Code");
        $fields["itemPricew01"] = array("label" => "Price Name");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));

        $json = $this->tabs();
        return $json;
    }

    /**
     * 
     * 
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Title", "index" => 'title'))
                ->addField(array("name" => "Code", "index" => 'erpCode'))
                ->addField(array("name" => "Price", "index" => 'itemPricew01'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
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
        $this->object = 'itecategory';
        $this->repository = 'SoftoneBundle:Pcategory';
        $this->table = 'MTRCATEGORY';
        
        
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata('SoftoneBundle\Entity\Pcategory')->getFieldNames();
        $itemfield = array();
        $itemfield[] = "M.".$this->table;        
        foreach($fields as $field) {
            $ffield = " ".$field;
            if (strpos($ffield,$this->object) == true) {
                $itemfield[] = "M.".strtoupper(str_replace($this->object,"",$field));
            }
        }
        $selfields = implode(",",$itemfield);
        $params["fSQL"] = 'SELECT '.$selfields.' FROM '.$this->table.' M';
        echo  $params["fSQL"];
        
        $softone = new Softone();
        $datas = $softone->createSql($params);
        foreach ($datas->data as $data) {
            $data = (array) $data;
            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneBy(array("reference" => (int) $data[$this->table]));
            if (@$entity->id == 0) {
                $entity = new SoftoneBundle\Entity\Pcategory();
                $dt = new \DateTime("now");
                $entity->setTs($dt);               
                $entity->setCreated($dt);
                $entity->setModified($dt);
            }
            $imporetedData = array();
            $entity->setReference($data[$this->table]);
            $this->flushpersist($entity);
            $q = array();
            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($this->object."_" . $identifier)] = addslashes($val);
                $ad = strtolower($identifier);
                $baz = $this->object . ucwords(str_replace("_", " ", $ad));
                if (in_array($baz, $fields)) {
                    $q[] = "`" . strtolower($this->object."_" . $identifier) . "` = '" . addslashes($val) . "'";
                    //$entity->setField($baz, $val);
                }
            }
            @$entity_id = (int) $entity->id;
            if (@$entity_id > 0) {
                $sql = "update softone_pcategory set " . implode(",", $q) . " where id = '" . $entity_id . "'";
                $em->getConnection()->exec($sql);
            }

            if (@$i++ > 500)
                break;
        }        
    }   
    
    
    function retrieveMtrl() {
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata('SoftoneBundle\Entity\Product')->getFieldNames();
        $itemfield = array();
        $itemfield[] = "M.MTRCATEGORY";        
        foreach($fields as $field) {
            $ffield = " ".$field;
            if (strpos($ffield,$this->object) == true) {
                $itemfield[] = "M.".strtoupper(str_replace($this->object,"",$field));
            }
        }
        $selfields = implode(",",$itemfield);
        $params["fSQL"] = 'SELECT '.$selfields.' FROM MTRL M WHERE M.SODTYPE=51 '.$where;
        echo  $params["fSQL"];        
        
    }
    /**
     * 
     * @Route("/product/retrieveSoftone")
     */
    function retrieveSoftoneDataAction($params = array()) {
        
        set_time_limit(100000);
        ini_set('memory_limit', '2256M');
       

        
        echo $this->retrieveMtrcategory();

        return new Response(
                "", 200
        );

        
        $datas = $softone->getCustomItems($params);

        print_r($datas);
        exit;        
        
        foreach ($datas->data as $data) {
            $data = (array) $data;
            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneBy(array("reference" => (int) $data["MTRL"]));

            if (@$entity->id == 0) {
                $entity = new Product();
                $dt = new \DateTime("now");
                $entity->setTs($dt);
                $entity->setItemInsdate($dt);
                $entity->setItemUpddate($dt);
                $entity->setCreated($dt);
                $entity->setModified($dt);
            }
            $imporetedData = array();
            
            $entity->setField("reference", (int) $data["MTRL"]);
            $entity->setField('erpCode', @$data["CODE"]);
            $entity->setField('supplierCode', @$data["CODE2"]);
            $entity->setField('title', @$data["NAME"]);
            $entity->setField('tecdocCode', @$data["CCCFXRELTDCODE"]);
            $entity->setField('tecdocSupplierId', @$data["CCCFXRELBRAND"]);

            $this->flushpersist($entity);
            $q = array();
            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($this->object."_" . $identifier)] = addslashes($val);
                $ad = strtolower($identifier);
                $baz = $this->object . ucwords(str_replace("_", " ", $ad));
                if (in_array($baz, $fields)) {
                    $q[] = "`" . strtolower($this->object."_" . $identifier) . "` = '" . addslashes($val) . "'";
                    //$entity->setField($baz, $val);
                }
            }
            @$entity_id = (int) $entity->id;
            if (@$entity_id > 0) {
                $sql = "update softone_product set " . implode(",", $q) . " where id = '" . $entity_id . "'";
                $em->getConnection()->exec($sql);
            }
            $entity->updatetecdoc();
            if (@$i++ > 500)
                break;
        }
        return new Response(
                "", 200
        );
    }

}
