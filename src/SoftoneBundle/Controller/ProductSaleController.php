<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class ProductSaleController extends \SoftoneBundle\Controller\SoftoneController  {

    var $repository = 'SoftoneBundle:ProductSale';

    /**
     * @Route("/productsale/productsale")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:ProductSale:index.html.twig', array(
                    'pagename' => 'ProductSales',
                    'url' => '/productsale/getdatatable',
                    'view' => '/productsale/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/productsale/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('SoftoneBundle:ProductSale:view.html.twig', array(
                    'pagename' => 'ProductSale',
                    'url' => '/productsale/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/productsale/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/productsale/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        
        $fields["title"] = array("label" => "Title");
        $fields["expited"] = array("label" => "Expited");
        
        
        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/productsale/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:ProductSale';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Name", "index" => 'title'))
                ->addField(array("name" => "Expired", "index" => 'expired'))
                ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    /**
     * @Route("/productsale/retrieve")
     */    
    function retrieveProductSale() {
        $where = '';
        $params["softone_object"] = 'productsale';
        $params["repository"] = 'SoftoneBundle:ProductSale';
        $params["softone_table"] = 'TRDR';
        $params["table"] = 'softone_productsale';
        $params["object"] = 'SoftoneBundle\Entity\ProductSale';
        $params["filter"] = '';
        $params["filter"] = 'WHERE M.SODTYPE=12 ' . $where;
        $params["relation"] = array();
        $params["extra"] = array();
        $params["extrafunction"] = array();
        $this->setSetting("SoftoneBundle:ProductSale:retrieveProductSale", serialize($params));

        $params = unserialize($this->getSetting("SoftoneBundle:ProductSale:retrieveProductSale"));
        $this->retrieve($params);
        return new Response(
                json_encode(array()), 200, array('Content-Type' => 'application/json')
        );        
    }
}
