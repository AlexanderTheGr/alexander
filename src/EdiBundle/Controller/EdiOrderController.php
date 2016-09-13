<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\ViacarediOrder as ViacarediOrder;
use EdiBundle\Entity\ViacarediOrderItem as ViacarediOrderItem;
use AppBundle\Controller\Main as Main;

class EdiOrderController extends Main {

    var $repository = 'EdiBundle:ViacarediOrder';
    var $newentity = '';

    /**
     * @Route("/edi/viacar/order")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Viacar:index.html.twig', array(
                    'pagename' => 'Viacaredis',
                    'url' => '/edi/viacar/order/getdatatable',
                    'view' => '/edi/viacar/order/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/viacar/order/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Product", "index" => 'viacaredi:description');
        $dtparams[] = array("name" => "Product", "index" => 'qty');
        $dtparams[] = array("name" => "Product", "index" => 'price');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/edi/viacar/order/getitems/' . $id;

        $buttons = array();
        $buttons[] = array("label" => 'Send Order', 'position' => 'right', 'attr' => 'data-id=' . $id, 'class' => 'btn-success ViacarediSendOrder');

        $content = $this->gettabs($id);
        $content = $this->getoffcanvases($id);

        $content = $this->content();


        return $this->render('EdiBundle:Viacar:view.html.twig', array(
                    'pagename' => 'Viacaredis',
                    'url' => '/edi/viacar/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/viacar/order/save")
     */
    public function saveAction() {

        $entity = new ViacarediOrder;
        $this->newentity[$this->repository] = $entity;
        $this->newentity[$this->repository]->setField("reference", 0);
        $out = $this->save();
        
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/edi/viacar/order/view/" . $this->newentity[$this->repository]->getId();
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
            $entity = new ViacarediOrder;
            $this->newentity[$this->repository] = $entity;
        }
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');
        
        //$tabfields["PurchaseOrderNo"] = array("label" => "Purchase Order No","value"=>1);
        $tabfields["remarks"] = array("label" => "Remarks");
        
        $tabforms = $this->getFormLyFields($entity, $tabfields);

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Code", "index" => 'viacaredi:partno');
        $dtparams[] = array("name" => "Product", "index" => 'viacaredi:description');
        $dtparams[] = array("name" => "Store", "index" => 'store');
        $dtparams[] = array("name" => "Qty", "input" => "text", "index" => 'qty');
        $dtparams[] = array("name" => "Price", "input" => "text", "index" => 'price');
        $dtparams[] = array("name" => "Discount", "input" => "text", "index" => 'discount');
        $dtparams[] = array("name" => "Final Price", "index" => 'fprice');
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'gettabs_' . $id;
        $params['url'] = '/edi/viacar/order/getitems/' . $id;
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
        //$dtparams[] = array("name" => "ID", "function" => 'getAvailability', "active" => "active");
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/edi/viacar/order/getfororderitems/' . $id;
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';

        $datatables[] = $this->contentDatatable($params);
        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => 'sss', "index" => $this->generateRandomString(), "datatables" => $datatables));
        return $this->offcanvases();
    }

    function getTabContentSearch() {
        $response = $this->get('twig')->render('EdiBundle:Viacar:viacarediordersearch.html.twig', array());
        return str_replace("\n", "", htmlentities($response));
    }

    /**
     * @Route("/edi/viacar/order/addorderitem/")
     */
    public function addorderitemAction(Request $request) {


        $ViacarediOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:ViacarediOrder')
                ->find($request->request->get("order"));
        $Viacaredi = $this->getDoctrine()
                ->getRepository('EdiBundle:Viacaredi')
                ->find($request->request->get("item"));

        $availability = $Viacaredi->getQtyAvailability($request->request->get("qty"));
        //$Available = (array) $availability["Header"];
        $price = $availability["PriceOnPolicy"];
        if ($availability["Availability"] != 'green') {
            $json = json_encode(array("error" => true, "message" => $Available["Available"]));
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $store = 1;//$Available["SUGGESTED_STORE"];
        /*
        $json = json_encode($availability);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
         * 
         */
        $ViacarediOrderItem = new ViacarediOrderItem;
        $ViacarediOrderItem->setViacarediorder($ViacarediOrder);
        $ViacarediOrderItem->setViacaredi($Viacaredi);
        $ViacarediOrderItem->setField("qty", $request->request->get("qty"));
        $ViacarediOrderItem->setField("price", $price);
        $ViacarediOrderItem->setField("fprice", $request->request->get("price") * $request->request->get("qty"));
        $ViacarediOrderItem->setField("discount", 0);
        $ViacarediOrderItem->setField("store", $store);
        $ViacarediOrderItem->setField("chk", 1);

        try {
            @$this->flushpersist($ViacarediOrderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/viacar/order/editorderitem/")
     */
    public function editorderitemAction(Request $request) {
        $ViacarediOrderItem = $this->getDoctrine()
                ->getRepository('EdiBundle:ViacarediOrderItem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty")) {
            $ViacarediOrderItem->setQty($request->request->get("qty"));
            $availability = $ViacarediOrderItem->getViacaredi()->getQtyAvailability($request->request->get("qty"));
            $Available = (array) $availability["Header"];
            $store = $Available["SUGGESTED_STORE"];
            if ($availability["Header"]["Available"] == 'N') {
                $json = json_encode(array("error" => true, "message" => $Available["Available"]));
                return new Response(
                        $json, 200, array('Content-Type' => 'application/json')
                );
            }
            $price = $Available["PriceOnPolicy"];
            $ViacarediOrderItem->setPrice($price);
            $ViacarediOrderItem->setField("store", $store);
        } else if ($request->request->get("price"))
            $ViacarediOrderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount"))
            $ViacarediOrderItem->setDiscount($request->request->get("discount"));
        elseif ($request->request->get("qty") == 0) {
            try {
                $this->flushremove($ViacarediOrderItem);
                $json = json_encode(array("error" => false));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => "Product Exists"));
            }
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $fprice = ($ViacarediOrderItem->getPrice() * $ViacarediOrderItem->getQty()) * (1 - ($ViacarediOrderItem->getDiscount() / 100));
        $ViacarediOrderItem->setFprice($fprice);
        try {
            $this->flushpersist($ViacarediOrderItem);
            $json = json_encode(array("error" => false));
        } catch (\Exception $e) {
            $json = json_encode(array("error" => true, "message" => "Product Exists"));
        }
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/viacar/order/getitems/{id}")
     */
    public function getitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:ViacarediOrderItem';
        $this->q_and[] = $this->prefix . ".ViacarediOrder = " . $id;
        //$this->q_and[] = $this->prefix . ".viacarediorder = " . $id;
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
     * @Route("/edi/viacar/order/getfororderitems/{id}")
     */
    public function getfororderitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params_getoffcanvases_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:Viacaredi';

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/viacar/order/sendorder/")
     */
    public function sendorderAction(Request $request) {
        $json = json_encode(array());

        $ViacarediOrder = $this->getDoctrine()
                ->getRepository('EdiBundle:ViacarediOrder')
                ->find($request->request->get("id"));

        $json = json_encode(@$ViacarediOrder->placeOrder());

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/viacar/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        //$this->repository = 'EdiBundle:Viacaredi';
        $this->addField(array("name" => "ID", "index" => 'id'));
        $this->addField(array("name" => "Order", "index" => 'remarks'));
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
