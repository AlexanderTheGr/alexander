<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class OrderController extends Main {

    var $repository = 'SoftoneBundle:Order';

    /**
     * @Route("/order/order")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Order:index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/order/getdatatable',
                    'view' => '/order/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/order/view/{id}")
     */
    public function viewAction($id) {





        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->getoffcanvases($id);

        $content = $this->content();


        return $this->render('SoftoneBundle:Order:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/order/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/gettab")
     */
    public function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Product", "index" => 'product:title');
        $dtparams[] = array("name" => "Rafi", "index" => 'product:rafi1');
        $dtparams[] = array("name" => "Supplier", "index" => 'product:erpSupplier');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/order/getitems/' . $id;
        $params['key'] = 'gettabs_' . $id;
        $datatables[] = $this->contentDatatable($params);
        

        $fields["fincode"] = array("label" => "Erp Code");
        $fields["customerName"] = array("label" => "Price Name");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            $this->addTab(array("title" => "Search", "datatables" => array(), "form" => '', "content" => $this->getTabContentSearch(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
            $this->addTab(array("title" => "Items", "datatables" => $datatables, "form" => '', "content" => "", "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
            $this->addTab(array("title" => "Customer Details", "datatables" => array(), "form" => '', "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
        }
        $json = $this->tabs();
        return $json;
    }

    
    protected function getoffcanvases($id) {
        $dtparams[] = array("name" => "ID", "index" => 'id', "input" => 'checkbox', "active" => "active");
        $dtparams[] = array("name" => "Erp Code", "index" => 'erpCode', 'search' => 'text');
        $dtparams[] = array("name" => "Title", "index" => 'title', 'search' => 'text');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/order/getfororderitems/'.$id;
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';

        $datatables[] = $this->contentDatatable($params);
        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => 'sss', "index" => $this->generateRandomString(), "datatables" => $datatables));
        return $this->offcanvases();
    }    
    /**
     * @Route("/order/getfororderitems/{id}")
     */
    public function getfororderitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_getoffcanvases_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:Product';

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }    
    function getTabContentSearch() {
        $response = $this->get('twig')->render('SoftoneBundle:Order:search.html.twig', array());
        return str_replace("\n", "", htmlentities($response));
    }

    public function getTabContentItems() {
        return;
        $tmpl = $this->get('twig')->render('SoftoneBundle:Order:index.html.twig', array(
            'pagename' => 'Customers',
            'url' => '/order/getdatatable',
            'view' => '/order/view',
            'ctrl' => $this->generateRandomString(),
            'app' => $this->generateRandomString(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
        return str_replace("\n", "", trim($tmpl));
        return $response;
    }

    /**
     * @Route("/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Παραστατικό", "index" => 'fincode'))
                ->addField(array("name" => "Customer Name", "index" => 'customerName'))
                ->addField(array("name" => "Πωλητής", "index" => 'user:email'))
                ->addField(array("name" => "Δρομολόγιο", "index" => 'route:route'))
                ->addField(array("name" => "Παραγγελία", "index" => 'reference', 'method' => 'yesno'))
                ->addField(array("name" => "Προσφορά", "index" => 'noorder', 'method' => 'yesno'))
                ->addField(array("name" => "Ημιτελής", "index" => 'id', "method" => "imitelis"))
        ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/getitems/{id}")
     */
    public function getitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:Orderitem';
        $this->q_and[] = $this->prefix . ".order = " . $id;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function imitelisMethod($value) {
        return "YES";
    }

}
