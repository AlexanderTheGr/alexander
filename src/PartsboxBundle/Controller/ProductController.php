<?php

namespace PartsboxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class ProductController extends Main {

    var $repository = 'PartsboxBundle:Product';

    /**
     * @Route("/product/product")
     */
    public function indexAction() {

        return $this->render('product/index.html.twig', array(
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

        return $this->render('product/view.html.twig', array(
                    'pagename' => 'Product',
                    'url' => '/product/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
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

    /**
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
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
 

}
