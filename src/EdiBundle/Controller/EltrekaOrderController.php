<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\EltrekaediOrder as EltrekaediOrder;
use EdiBundle\Entity\EltrekaediOrderItem as EltrekaediOrderItem;
use AppBundle\Controller\Main as Main;

class EltrekaOrderController extends Main {

    var $repository = 'EdiBundle:EltrekaediOrder';
    var $newentity = '';

    /**
     * @Route("/edi/eltreka/order")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Eltreka:index.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/order/getdatatable',
                    'view' => '/edi/eltreka/order/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/order/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Product", "index" => 'eltrekaedi:description');
        $dtparams[] = array("name" => "Product", "index" => 'qty');
        $dtparams[] = array("name" => "Product", "index" => 'price');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/edi/eltreka/order/getitems/' . $id;

        $buttons = array();
        $buttons[] = array("label" => 'Send Order', 'position' => 'right', 'attr' => 'data-id=' . $id, 'class' => 'btn-success EltrekaediSendOrder');

        $content = $this->gettabs($id);
        $content = $this->getoffcanvases($id);

        $content = $this->content();


        return $this->render('EdiBundle:Eltreka:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/order/save")
     */
    public function saveAction() {

        $entity = new EltrekaediOrder;
        $this->newentity[$this->repository] = $entity;
        $this->newentity[$this->repository]->setField("reference", 0);
        $out = $this->save();
        
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/edi/eltreka/order/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    protected function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new EltrekaediOrder;
            $this->newentity[$this->repository] = $entity;
        }
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');
        
        $tabfields["PurchaseOrderNo"] = array("label" => "Purchase Order No","value"=>1);
        $tabfields["comments"] = array("label" => "Comments");
        
        $tabforms = $this->getFormLyFields($entity, $tabfields);

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Code", "index" => 'eltrekaedi:partno');
        $dtparams[] = array("name" => "Product", "index" => 'eltrekaedi:description');
        $dtparams[] = array("name" => "Store", "index" => 'store');
        $dtparams[] = array("name" => "Qty", "input" => "text", "index" => 'qty');
        $dtparams[] = array("name" => "Price", "input" => "text", "index" => 'price');
        $dtparams[] = array("name" => "Discount", "input" => "text", "index" => 'discount');
        $dtparams[] = array("name" => "Final Price", "index" => 'fprice');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'gettabs_' . $id;
        $params['url'] = '/edi/eltreka/order/getitems/' . $id;
        $params["ctrl"] = 'ctrlgettabs';
        $params["app"] = 'appgettabs';
        $datatables[] = $this->contentDatatable($params);

        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $tabforms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            $this->addTab(array("title" => "Items", "datatables" => $datatables, "form" => '', "content" => $this->getTabContentSearch(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
        }
        return $this->tabs();
    }

    protected function getoffcanvases($id) {
        $dtparams[] = array("name" => "ID", "index" => 'id', "input" => 'checkbox', "active" => "active");
        $dtparams[] = array("name" => "Part No", "index" => 'partno', 'search' => 'text');
        $dtparams[] = array("name" => "Description", "index" => 'description', 'search' => 'text');
        $dtparams[] = array("name" => "Price", "index" => 'retailprice', "input" => 'text', 'search' => 'text');
        $dtparams[] = array("name" => "ID", "function" => 'getAvailability', "active" => "active");
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/edi/eltreka/order/getfororderitems/' . $id;
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';

        $datatables[] = $this->contentDatatable($params);
        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => 'sss', "index" => $this->generateRandomString(), "datatables" => $datatables));
        return $this->offcanvases();
    }

    function getTabContentSearch() {
        $response = $this->get('twig')->render('EdiBundle:Eltreka:eltrekaediordersearch.html.twig', array());
        return str_replace("\n", "", htmlentities($response));
    }

    /**
     * @Route("/edi/eltreka/order/addorderitem/")
     */
    public function addorderitemAction(Request $request) {


        $EltrekaediOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:EltrekaediOrder')
                ->find($request->request->get("order"));
        $Eltrekaedi = $this->getDoctrine()
                ->getRepository('EdiBundle:Eltrekaedi')
                ->find($request->request->get("item"));

        $availability = $Eltrekaedi->getQtyAvailability($request->request->get("qty"));
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
        $EltrekaediOrderItem = new EltrekaediOrderItem;
        $EltrekaediOrderItem->setEltrekaediorder($EltrekaediOrder);
        $EltrekaediOrderItem->setEltrekaedi($Eltrekaedi);
        $EltrekaediOrderItem->setField("qty", $request->request->get("qty"));
        $EltrekaediOrderItem->setField("price", $price);
        $EltrekaediOrderItem->setField("fprice", $request->request->get("price") * $request->request->get("qty"));
        $EltrekaediOrderItem->setField("discount", 0);
        $EltrekaediOrderItem->setField("store", $store);
        $EltrekaediOrderItem->setField("chk", 1);

        try {
            @$this->flushpersist($EltrekaediOrderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/editorderitem/")
     */
    public function editorderitemAction(Request $request) {
        $EltrekaediOrderItem = $this->getDoctrine()
                ->getRepository('EdiBundle:EltrekaediOrderItem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty")) {
            $EltrekaediOrderItem->setQty($request->request->get("qty"));
            $availability = $EltrekaediOrderItem->getEltrekaedi()->getQtyAvailability($request->request->get("qty"));
            $Available = (array) $availability["Header"];
            $store = $Available["SUGGESTED_STORE"];
            if ($availability["Header"]["Available"] == 'N') {
                $json = json_encode(array("error" => true, "message" => $Available["Available"]));
                return new Response(
                        $json, 200, array('Content-Type' => 'application/json')
                );
            }
            $price = $Available["PriceOnPolicy"];
            $EltrekaediOrderItem->setPrice($price);
            $EltrekaediOrderItem->setField("store", $store);
        } else if ($request->request->get("price"))
            $EltrekaediOrderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount"))
            $EltrekaediOrderItem->setDiscount($request->request->get("discount"));
        elseif ($request->request->get("qty") == 0) {
            try {
                $this->flushremove($EltrekaediOrderItem);
                $json = json_encode(array("error" => false));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => "Product Exists"));
            }
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $fprice = ($EltrekaediOrderItem->getPrice() * $EltrekaediOrderItem->getQty()) * (1 - ($EltrekaediOrderItem->getDiscount() / 100));
        $EltrekaediOrderItem->setFprice($fprice);
        try {
            $this->flushpersist($EltrekaediOrderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/getitems/{id}")
     */
    public function getitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:EltrekaediOrderItem';
        $this->q_and[] = $this->prefix . ".EltrekaediOrder = " . $id;
        //$this->q_and[] = $this->prefix . ".eltrekaediorder = " . $id;
        $json = $this->datatable();


        $data = (array) json_decode($json);
        $jsonarr = $data["data"];
        $jsono = array();

        foreach ($jsonarr as $json) {
            foreach ($json as $key => $val) {
                if ($key == 5) {
                    @$jsono[$key] += $val;
                } elseif ($key == 4) {
                    @$jsono[$key] = "Total";
                } else {
                    $jsono[$key] = '';
                }
            }
        }
        $jsono["DT_RowClass"] = "bold dt_row";
        if (@$jsono[5] > 0) {
            $jsonarr[] = $jsono;
        }
        $data["data"] = $jsonarr;
        $json = json_encode($data);

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/getfororderitems/{id}")
     */
    public function getfororderitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_getoffcanvases_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:Eltrekaedi';

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/sendorder/")
     */
    public function sendorderAction(Request $request) {
        $json = json_encode(array());

        $EltrekaediOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:EltrekaediOrder')
                ->find($request->request->get("id"));

        $json = json_encode(@$EltrekaediOrder->placeOrder());

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        //$this->repository = 'EdiBundle:Eltrekaedi';
        $this->addField(array("name" => "ID", "index" => 'id'));
        $this->addField(array("name" => "Order", "index" => 'PurchaseOrderNo'));
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
