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

class ProductController extends \SoftoneBundle\Controller\SoftoneController {

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
        $entity->updatetecdoc();
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
                ->getRepository('SoftoneBundle:Product')
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Product;
        }
        $entity->updatetecdoc();
        $fields["title"] = array("label" => "Title");
        $fields["erpCode"] = array("label" => "Erp Code");
        $fields["tecdocCode"] = array("label" => "Tecdoc Code");

        $fields["tecdocSupplierId"] = array("label" => "Tecdoc Supplier", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:SoftoneSupplier', 'name' => 'title', 'value' => 'id'));



        $fields["itemPricew"] = array("label" => "Price");
        $fields["itemPricer"] = array("label" => "Price");

        $forms = $this->getFormLyFields($entity, $fields);

        $tabs[] = array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);


        foreach ($tabs as $tab) {
            $this->addTab($tab);
        }

        $json = $this->tabs();
        return $json;
    }

    /**
     * 
     * 
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {


        $fields = unserialize($this->getSetting("SoftoneBundle:Product:getdatatable"));
        if (!count($fields) == 0) {
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

}
