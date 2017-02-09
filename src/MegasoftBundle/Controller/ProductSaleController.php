<?php

namespace MegasoftBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MegasoftBundle\Entity\ProductSale as ProductSale;
use AppBundle\Controller\Main as Main;

class ProductSaleController extends Main {

    var $repository = 'MegasoftBundle:ProductSale';

    /**
     * @Route("/megasoft/productsale/productsale")
     */
    public function indexAction() {

        return $this->render('MegasoftBundle:ProductSale:index.html.twig', array(
                    'pagename' => 'ProductSales',
                    'url' => '/megasoft/productsale/getdatatable',
                    'view' => '/megasoft/productsale/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/megasoft/productsale/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->content();


        return $this->render('MegasoftBundle:ProductSale:view.html.twig', array(
                    'pagename' => 's',
                    'url' => '/megasoft/productsale/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/megasoft/productsale/save")
     */
    public function savection() {
        $entity = new ProductSale;

        //$this->repository = "MegasoftBundle:Customer";
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);

        $out = $this->save();

        $jsonarr = array();
        //if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/productsale/view/" . $this->newentity[$this->repository]->getId();
        //}
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/megasoft/productsale/gettab")
     */
    public function gettabs($id) {



        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new ProductSale;
        }

        
        $fields["title"] = array("label" => "Title");
        $fields["expired"] = array("label" => "Expired","type"=>'datetime', "className" => "col-md-12 col-sm-12 datetime");
        
        
        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/megasoft/productsale/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'MegasoftBundle:ProductSale';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Name", "index" => 'title'))
                //->addField(array("name" => "Expired", "index" => 'expired'))
                ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    /**
     * @Route("/megasoft/productsale/retrieve")
     */    
    function retrieveProductSale() {
        $where = '';
        $params["megasoft_object"] = 'productsale';
        $params["repository"] = 'MegasoftBundle:ProductSale';
        $params["megasoft_table"] = 'TRDR';
        $params["table"] = 'megasoft_productsale';
        $params["object"] = 'MegasoftBundle\Entity\ProductSale';
        $params["filter"] = '';
        $params["filter"] = 'WHERE M.SODTYPE=12 ' . $where;
        $params["relation"] = array();
        $params["extra"] = array();
        $params["extrafunction"] = array();
        $this->setSetting("MegasoftBundle:ProductSale:retrieveProductSale", serialize($params));

        $params = unserialize($this->getSetting("MegasoftBundle:ProductSale:retrieveProductSale"));
        $this->retrieve($params);
        return new Response(
                json_encode(array()), 200, array('Content-Type' => 'application/json')
        );        
    }
}
