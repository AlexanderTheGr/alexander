<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use SoftoneBundle\Entity\Order as Order;
use SoftoneBundle\Entity\Orderitem as Orderitem;

class OrderController extends Main {

    var $repository = 'SoftoneBundle:Order';
    var $newentity = '';

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
                    'pagename' => 's',
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
    public function saveAction() {
        $entity = new Order;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("status", 1);
        $out = $this->save();
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/order/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
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
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Order;
            $this->newentity[$this->repository] = $entity;
        }

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Product", "index" => 'product:title');
        $dtparams[] = array("name" => "Rafi", "index" => 'product:rafi1');
        $dtparams[] = array("name" => "Supplier", "index" => 'product:erpSupplier');
        $dtparams[] = array("name" => "Qty", "input" => "text", "index" => 'qty');
        $dtparams[] = array("name" => "Price", "input" => "text", "index" => 'price');
        $dtparams[] = array("name" => "Discount", "input" => "text", "index" => 'disc1prc');
        $dtparams[] = array("name" => "Final Price", "index" => 'lineval');        
        
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/order/getitems/' . $id;
        $params['key'] = 'gettabs_' . $id;
        $params["ctrl"] = 'ctrlgettabs';
        $params["app"] = 'appgettabs';        
        $datatables[] = $this->contentDatatable($params);        
        
        $fields["fincode"] = array("label" => "Code");
        $fields["customerName"] = array("label" => "Customer Name");
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
        $dtparams[] = array("name" => "Price", "index" => 'itemPricew01', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "ID", "function" => 'getAvailability', "active" => "active");
        
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
    
    
    /**
     * @Route("/order/addorderitem/")
     */
    public function addorderitemAction(Request $request) {


        $order = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Order')
                ->find($request->request->get("order"));
        $product = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Product')
                ->find($request->request->get("item"));
        /*
        $availability = $->getQtyAvailability($request->request->get("qty"));
        $Available = (array) $availability["Header"];
        $price = $Available["PriceOnPolicy"];
        if ($availability["Header"]["Available"] == 'N') {
            $json = json_encode(array("error" => true, "message" => $Available["Available"]));
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $store = $Available["SUGGESTED_STORE"];
        /*
        $json = json_encode($availability);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
         * 
         */
        $orderItem = new OrderItem;
        $orderItem->setOrder($order);
        $orderItem->setProduct($product);
        $orderItem->setField("qty", $request->request->get("qty"));
        $orderItem->setField("price", $request->request->get("price"));
        $orderItem->setField("lineval", $request->request->get("price") * $request->request->get("qty"));
        $orderItem->setField("disc1prc", 0);
        //$orderItem->setField("store", $store);
        $orderItem->setField("chk", 1);

        try {
            @$this->flushpersist($orderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => $e->getMessage()));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }    
    /**
     * @Route("/edi/eltreka/order/editorderitem/")
     */
    public function editorderitemAction(Request $request) {
        $orderItem = $this->getDoctrine()
                ->getRepository('SoftoneBundle:OrderItem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty")) {
            $orderItem->setQty($request->request->get("qty"));
            //$availability = $$orderItem->get$order()->getQtyAvailability($request->request->get("qty"));
            //$Available = (array) $availability["Header"];
            //$store = $Available["SUGGESTED_STORE"];
            /*
            if ($availability["Header"]["Available"] == 'N') {
                $json = json_encode(array("error" => true, "message" => $Available["Available"]));
                return new Response(
                        $json, 200, array('Content-Type' => 'application/json')
                );
            }
             * 
             */
            $price = $Available["PriceOnPolicy"];
            $orderItem->setPrice($price);
            $orderItem->setField("store", $store);
        } else if ($request->request->get("price"))
            $orderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount"))
            $orderItem->setDisc1prc($request->request->get("discount"));
        elseif ($request->request->get("qty") == 0) {
            try {
                $this->flushremove($$orderItem);
                $json = json_encode(array("error" => false));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => "Product Exists"));
            }
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $fprice = ($orderItem->getPrice() * $orderItem->getQty()) * (1 - ($orderItem->getDiscount() / 100));
        $orderItem->setFprice($fprice);
        try {
            $this->flushpersist($orderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    function imitelisMethod($value) {
        return "YES";
    }

}
