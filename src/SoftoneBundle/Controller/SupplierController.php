<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class SupplierController extends \SoftoneBundle\Controller\SoftoneController  {

    var $repository = 'SoftoneBundle:Supplier';

    /**
     * @Route("/supplier/supplier")
     */
    public function indexAction() {

        return $this->render('supplier/index.html.twig', array(
                    'pagename' => 'Suppliers',
                    'url' => '/supplier/getdatatable',
                    'view' => '/supplier/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/supplier/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('supplier/view.html.twig', array(
                    'pagename' => 'Supplier',
                    'url' => '/supplier/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/supplier/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/supplier/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["supplierCode"] = array("label" => "Code");
        $fields["supplierName"] = array("label" => "Name");

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/supplier/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Supplier';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Code", "index" => 'supplierCode'))
                ->addField(array("name" => "Name", "index" => 'supplierName'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    /**
     * @Route("/supplier/retrieve")
     */    
    function retrieveSupplier() {
        $where = '';
        $params["softone_object"] = 'supplier';
        $params["repository"] = 'SoftoneBundle:Supplier';
        $params["softone_table"] = 'TRDR';
        $params["table"] = 'softone_supplier';
        $params["object"] = 'SoftoneBundle\Entity\Supplier';
        $params["filter"] = '';
        //$params["filter"] = 'WHERE M.SODTYPE=13 ' . $where;
        $params["relation"] = array();
        $params["extra"] = array();
        $params["extrafunction"] = array();
        $this->setSetting("SoftoneBundle:Supplier:retrieveSupplier", serialize($params));

        $params = unserialize($this->getSetting("SoftoneBundle:Supplier:retrieveSupplier"));
        $this->retrieve($params);
        return new Response(
                json_encode(array()), 200, array('Content-Type' => 'application/json')
        );        
    }
}
