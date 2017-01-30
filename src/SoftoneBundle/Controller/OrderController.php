<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use SoftoneBundle\Entity\Order as Order;
use SoftoneBundle\Entity\Orderitem as Orderitem;
use SoftoneBundle\Entity\Softone as Softone;
use AppBundle\Entity\Tecdoc as Tecdoc;
use EdiBundle\Entity\EdiItem;
use EdiBundle\Entity\Edi;
use SoftoneBundle\Entity\Reportmodel as Reportmodel;

class OrderController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Order';
    var $newentity = '';

    public function setfullytrans() {
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT FINDOC,FULLYTRANSF FROM FINDOC WHERE FULLYTRANSF = 1";
        $params["fSQL"] = $sql;
        $softone = new Softone();
        $datas = $softone->createSql($params);
        // print_r($datas);
        //exit;
        foreach ((array) $datas->data as $data) {
            $sql = "update softone_order set fullytrans = '" . $data->FULLYTRANSF . "' where reference = '" . $data->FINDOC . "'";
            //echo $sql."<BR>";
            $em->getConnection()->exec($sql);
        }
    }

    /**
     * @Route("/order/order")
     */
    public function indexAction() {
        $this->setfullytrans();
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
     * @Route("/order/print/{id}")
     */
    public function printAction($id) {
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);

        $content = $this->printarea($order);
        /*
          return $this->render('SoftoneBundle:Order:print.html.twig', array(
          'pagename' => $pagename,
          'order' => $id,
          'content' => $content,
          'url' => '/order/save',
          'buttons' => $buttons,
          'ctrl' => $this->generateRandomString(),
          'app' => $this->generateRandomString(),
          'content' => $content,
          'displaynone' => $displaynone,
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
          ));
         */
        echo $content;
        exit;
    }

    public function printarea($order) {
        $html = "";
        if (!$order)
            return "";
        $html .= '<h2>Παραγγελία ' . $order->getfincode() . '</h2>';
        $html .= "<table>";
        $html .= '<tr><th>Όνομα πελάτη</th><td>' . $order->getCustomerName() . '</td>';
        $html .= '<tr><th>Σχόλια</th><td>' . $order->getRemarks() . '</td>';
        $html .= "</table>";

        $html .= "<table width='100%'>";
        $html .= "<thead><tr>";
        $html .= "<th>Είδος</th>";
        $html .= "<th align='left'>Κωδικός Είδους</th>";
        $html .= "<th align='left'>Supplier</th>";
        //$html .= "<th align='left'>Ράφι</th>";
        $html .= "<th align='left'>Υπόλοιπο</th>";
        $html .= "<th align='left'>Ποσότητα</th>";
        $html .= "<th align='left'>Τιμή Μονάδος</th>";
        $html .= "<th align='left'>Έκπτωση</th>";
        $html .= "<th align='left'>Τελική Τιμή</th>";
        $html .= "</tr></thead>";
        foreach ($order->getItems() as $item) {
            @$total += $item->getLineval();
            //$item->getProduct()->getReference();

            $product = $item->getProduct();
            if (!$product)
                continue;
            $ti = $product->getSupplierId() ? $product->getSupplierId()->getTitle() : "";

            $supplier = $item->getProduct()->getSupplierId() ? $item->getProduct()->getSupplierId()->getTitle() : '';
            $html .= "<tr>";
            $html .= "<td>" . $product->getTitle() . "</td>";
            $html .= "<td>" . $product->getErpCode() . "</td>";
            $html .= "<td>" . $ti . "</td>";
            //$html .= "<td>" . $product->getItemMtrplace() . "</td>";
            $html .= "<td>" . $product->getApothiki() . "</td>";
            $html .= "<td align='right'>" . $item->getQty() . "</td>";
            $html .= "<td align='right'>" . $item->getPrice() . "</td>";
            $html .= "<td align='right'>" . $item->getDisc1prc() . "</td>";
            $html .= "<td align='right'>" . $item->getLineval() . "</td>";
            $html .= "</tr>";
        }
        $html .= "<tfooter><tr>";
        $html .= "<th></th>";
        $html .= "<th align='left'></th>";
        $html .= "<th align='left'></th>";
        $html .= "<th align='left'></th>";
        //$html .= "<th align='left'></th>";
        $html .= "<th align='left'></th>";
        $html .= "<th align='left'></th>";
        $html .= "<th align='left'>Σύνολο</th>";
        $html .= "<th align='right'>" . $total . "</th>";
        $html .= "</tr></tfooter>";
        $html .= "</table>";

        $content = $html;
        return $content;
    }

    /**
     * @Route("/order/view/{id}")
     */
    public function viewAction($id) {



        if ($id == 'pelatis') {
            $entity = new Order;
            $this->newentity[$this->repository] = $entity;
            $this->initialazeNewEntity($entity);
            $customer = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Customer")
                    ->find(3);

            $entity->setCustomer($customer);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entity->setUser($user);
            
            $vat = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Vat")
                    ->findOneBy(array('enable' => 1, 'id' => $customer->getCustomerVatsts()));
            $entity->setVat($vat);
            $entity->setCustomerName($customer->getCustomerName() . " (" . $customer->getCustomerAfm() . " - " . $customer->getCustomerCode() . ")");
            $route = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Route")
                    ->find(1);
            $entity->setRoute($route);
            $entity->setIsnew(0);
            $this->flushpersist($entity);
            $id = $entity->getId();
            header("location: /order/view/" . $id);
            exit;
        }

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->getoffcanvases($id);
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);
        $pagename = "";
        $displaynone = 'display:none';
        if ($order) {
            $pagename = $order->getCustomerName();
            $displaynone = $order->getReference() > 0 ? '' : 'display:none';
        }
        $content = $this->content();
        return $this->render('SoftoneBundle:Order:view.html.twig', array(
                    'pagename' => $pagename,
                    'order' => $id,
                    'url' => '/order/save',
                    'printarea' => $this->printarea($order),
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'displaynone' => $displaynone,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/order/save")
     */
    public function saveAction() {
        $entity = new Order;
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("status", 1);
        //$this->newentity[$this->repository]->setField("route", 0);
        $out = $this->save();
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            //$jsonarr["returnurl"] = "/order/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/saveCustomer")
     */
    public function saveCustomerAction(Request $request) {
        $request->request->get("customerName");
        $request->request->get("customer");
        $id = $request->request->get("id");

        $order = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $order->id == 0) {
            $order = new Order;
            $this->newentity[$this->repository] = $order;
            $this->initialazeNewEntity($order);
            @$this->newentity[$this->repository]->setField("status", 1);
        }

        $order->setCustomerName($request->request->get("customerName"));
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $order->setUser($user);
        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->find($request->request->get("customer"));
        $order->setCustomer($customer);

        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->find($request->request->get("customer"));

        //$this->setSetting("SoftoneBundle:Product:Vat", 1310);
        $vatid = $this->getSetting("SoftoneBundle:Product:Vat");

        $vat = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Vat")
                ->findOneBy(array('enable' => 1, 'id' => $customer->getCustomerVatsts()));

        $order->setVat($vat);

        $route = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Route")
                ->find(1);

        $order->setRoute($route);

        $this->flushpersist($order);

        $jsonarr["returnurl"] = "/order/view/" . $order->getId();
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
            $fincode = (int) $this->getSetting("SoftoneBundle:Order:fincode");
            $entity->setField("fincode", str_pad($fincode, 7, "0", STR_PAD_LEFT));
            $fincode++;
            $this->setSetting("SoftoneBundle:Order:fincode", $fincode);
            $fields["customerName"] = array("label" => "Customer Name", "required" => true, 'className' => 'asdfg');
            $fields["fincode"] = array("label" => "Code", "required" => true, 'className' => 'asdfg');
        } else {
            if ($entity->getFincode() == '') {
                $fincode = (int) $this->getSetting("SoftoneBundle:Order:fincode");
                $entity->setField("fincode", str_pad($fincode, 7, "0", STR_PAD_LEFT));
                $fincode++;
                $this->setSetting("SoftoneBundle:Order:fincode", $fincode);
            }

            $entity->setIsnew(0);
            $this->flushpersist($entity);

            $fields["fincode"] = array("label" => "Code", 'className' => 'asdfg', "required" => true);
            $fields["customerName"] = array("label" => "Customer Name", "required" => true, 'className' => 'asdfg');
            $fields["route"] = array("label" => "Route", "required" => false, 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Route', 'name' => 'route', 'value' => 'id'));

            $fields["remarks"] = array("label" => "Σχόλια", 'className' => '', "required" => false);
            //$fields["vat"] = array("label" => "Vat", "required" => true, 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Vat', 'name' => 'vat', 'value' => 'id'));
        }

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "", "function" => 'deleteitem');
        $dtparams[] = array("name" => "Είδος", "index" => 'product:title');
        $dtparams[] = array("name" => "Κωδικός Είδους", "index" => 'product:erpCode');
        $dtparams[] = array("name" => "Ράφι", "index" => 'product:itemMtrplace');
        $dtparams[] = array("name" => "Supplier", "index" => 'product:supplierId:title');
        $dtparams[] = array("name" => "Αποθηκη", "function" => 'getProductApothiki', 'search' => 'text');
        $dtparams[] = array("name" => "Qty", "input" => "text", "index" => 'qty');
        $dtparams[] = array("name" => "Τιμή Καταλόγου", "input" => "text", "index" => 'price');
        $dtparams[] = array("name" => "Έκπτωση", "input" => "text", "index" => 'disc1prc');
        $dtparams[] = array("name" => "Τιμή", "input" => "text", "function" => 'getLinevalQty', 'class' => 'livevalqty');
        $dtparams[] = array("name" => "Τελική Τιμή", "input" => "text", "index" => 'lineval');

        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['url'] = '/order/getitems/' . $id;
        $params['key'] = 'gettabs_' . $id;
        $params["ctrl"] = 'ctrlgettabs';
        $params["app"] = 'appgettabs';
        $datatables[] = $this->contentDatatable($params);


        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            $this->addTab(array("title" => "Search", "datatables" => array(), "form" => '', "content" => $this->getTabContentSearch($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
            $this->addTab(array("title" => "Items", "datatables" => $datatables, "form" => '', "content" => "", "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
            $this->addTab(array("title" => "Customer Details", "datatables" => array(), "form" => '', "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
        }
        $json = $this->tabs();
        return $json;
    }

    function getTotals($entity) {
        $total = 0;
        foreach ($entity->getItems() as $item) {
            @$total += $item->getLineval();
        }
        $response = $this->get('twig')->render('SoftoneBundle:Order:totals.html.twig', array('total' => $total));
        return str_replace("\n", "", htmlentities($response));
    }

    protected function getoffcanvases($id) {

        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);

        if ($id > 0) {
            $customer = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Customer")
                    ->find($order->getCustomer());
            $priceField = $customer->getPriceField();
        } else {
            $priceField = "itemPricew";
        }


        $dtparams = array();

        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Κωδικός", "function" => 'getForOrderCode', 'search' => 'text');
        $dtparams[] = array("name" => "Είδος", "function" => 'getForOrderTitle', 'search' => 'text');

        $dtparams[] = array("name" => "Supplier", "function" => 'getForOrderSupplier', 'search' => 'text');
        $dtparams[] = array("name" => "Χαρακτ.", "function" => 'getArticleAttributes', 'search' => 'text');

        $dtparams[] = array("name" => "Remarks", "index" => "itemRemarks", 'search' => 'text');

        $dtparams[] = array("name" => "Λιανική", "index" => "itemPricer", 'search' => 'text');
        $dtparams[] = array("name" => "Τιμή Καταλόγου", "index" => $priceField, 'search' => 'text');


        $dtparams[] = array("name" => "Τελική Τιμη", "index" => $priceField, 'search' => 'text');

        $dtparams[] = array("name" => "Κωδ. Συσχετισης", "index" => "sisxetisi", 'search' => 'text');

        $dtparams[] = array("name" => "Αποθηκη", "function" => 'getApothiki', 'search' => 'text');

        $dtparams[] = array("name" => "QTY", "index" => 'qty', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "EDI", "index" => 'edi', "input" => 'text', 'search' => 'text');

        $dtparams[] = array("name" => "-", "function" => 'getTick', 'search' => 'text');

        //$dtparams[] = array("name" => "ID", "function" => 'getTest', "active" => "active");
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/order/getfororderitems/' . $id . '/1';
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';
        $datatables[] = $this->contentDatatable($params);


        $dtparams = array();
        $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
        $dtparams[] = array("name" => "Edi", "index" => 'Edi:name', 'search' => 'select', 'type' => 'select');
        $dtparams[] = array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text');
        $dtparams[] = array("name" => "Brand", "index" => 'brand', 'search' => 'text');
        $dtparams[] = array("name" => "Part No", "index" => 'partno', 'search' => 'text');
        $dtparams[] = array("name" => "Description", "index" => 'description', 'search' => 'text');
        //$dtparams[] = array("name" => "Tecdoc Name", "index" => 'tecdocArticleName', 'search' => 'text');

        $dtparams[] = array("name" => "Customer Price", "index" => 'wholesaleprice', 'search' => 'text');
        $dtparams[] = array("name" => "Price", "index" => 'wholesaleprice', 'search' => 'text');

        $dtparams[] = array("name" => "QTY1", "index" => 'qty1', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "QTY2", "index" => 'qty2', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "QTY", "index" => 'qty', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "Test", "index" => 'test', 'search' => 'text');


        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases2_' . $id;
        $params['url'] = '/edi/ediitem/getorderdatatable/' . $id;
        $params["ctrl"] = 'ctrlgetoffcanvases2';
        $params["app"] = 'appgetoffcanvases2';
        $params["drawCallback"] = 'fororder2(' . $id . ')';
        $datatables[] = $this->contentDatatable($params);


        $suppliers = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:SoftoneSupplier')->findAll();
        $tecdocArticleName = "<div style='float:left'id='tecdocArticleName'></div>";
        $itemMtrsup = "<select id='classtitem'>";
        $itemMtrsup .= "<option value=0>Select</option>";
        foreach ($suppliers as $supplier) {
            $itemMtrsup .= "<option value='" . $supplier->getId() . "'>" . $supplier->getTitle() . "</option>"; //array("value" => (string) $supplier->getReference(), "name" => $supplier->getSupplierName()); // $supplier->getSupplierName();
        }
        $itemMtrsup .= "</select>";

        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => $tecdocArticleName . $itemMtrsup, "index" => $this->generateRandomString(), "datatables" => $datatables));
        //$this->addOffCanvas(array('id' => 'asdf2', "content" => '', "index" => $this->generateRandomString(), "datatables" => $datatables));
        return $this->offcanvases();
    }

    /**
     * @Route("/order/getfororderitems/{id}/{car}")
     */
    public function getfororderitemsAction($id, $car) {
        $session = new Session();
        foreach ($session->get('params_getoffcanvases_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:Product';

        $json = $this->fororderitemsDatatable($id);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function fororderitemsDatatable($id = false) {
        ini_set("memory_limit", "1256M");
        $request = Request::createFromGlobals();
        $vat = 1.24;
        $recordsTotal = 0;
        $recordsFiltered = 0;

        //$this->q_or = array();
        //$this->q_and = array();
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);
        if ($order) {
            $customer = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Customer")
                    ->find($order->getCustomer());
            $priceField = $customer->getPriceField();
        } else {
            $priceField = "itemPricew";
        }

        $s = array();
        $f = array();
        $jsonarr = array();
        if ($request->request->get("length")) {
            $em = $this->getDoctrine()->getManager();
            $orderFields = $em->getClassMetadata('SoftoneBundle\Entity\Product')->getFieldNames();
            $doctrineConfig = $em->getConfiguration();
            $doctrineConfig->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');

            $dt_order = $request->request->get("order");
            $dt_search = $request->request->get("search");
            $dt_columns = $request->request->get("columns");
            //$recordsTotal = $em->getRepository($this->repository)->recordsTotal();
            $fields = array();
            $jsonarr = array();


            $search = $dt_search["value"];
            $search = explode(":", $dt_search["value"]);

            $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));

            if ($search[1]) {
                @$articleIds2 = unserialize(base64_decode($search[1]));
            } else {
                @$articleIds2 = unserialize(base64_decode($search[0]));
            }

            //$articleIds2["linkingTargetId"];

            $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
            //print_r($articleIds);
            //print_r($articleIds2["articleIds"]);
            $dt_search["value"] = strlen($dt_search["value"]) > 200 ? "||||" : $dt_search["value"];


            if ($this->clearstring($dt_search["value"]) != "") {

                $softone = new Softone();
                $recordsTotal = $em->getRepository($this->repository)->recordsTotal();

                foreach ($this->fields as $index => $field) {
                    if (@$field["index"]) {
                        $fields[] = $field["index"];
                        $field_relation = explode(":", $field["index"]);
                        if (count($field_relation) == 1) {
                            if ($this->clearstring($dt_search["value"]) != "" AND in_array($field["index"], $orderFields)) {
                                $this->q_or[] = $this->prefix . "." . $field["index"] . " LIKE '%" . $this->clearstring($dt_search["value"]) . "%'";
                            }
                            if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "" AND in_array($this->fields[$index]["index"], $orderFields)) {
                                $this->q_and[] = $this->prefix . "." . $this->fields[$index]["index"] . " LIKE '%" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "%'";
                            }
                            if (in_array($field_relation[0], $orderFields)) {
                                $s[] = $this->prefix . "." . $field_relation[0];
                            }
                        } else {
                            if ($dt_search["value"] === true) {
                                if ($this->clearstring($dt_search["value"]) != "" AND in_array($field_relation[0], $orderFields)) {
                                    $this->q_or[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_search["value"]) . "'";
                                }
                            }
                            if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "" AND in_array($field_relation[0], $orderFields)) {
                                $field_relation = explode(":", $this->fields[$index]["index"]);
                                $this->q_and[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "'";
                                //$s[] = $this->prefix . "." . $field_relation[0];  
                            }
                        }
                    }
                }


                if ($search[0] == 'productfreesearch') {
                    $garr = explode(" ", $search[1]);
                    foreach ($garr as $d) {
                        $likearr[] = "o.dataIndex like '%" . $d . "%'";
                    }
                    $like = implode(" AND ", $likearr);
                    $sqlearch = "Select o.id from SoftoneBundle:ProductFreesearch o where " . $like . "";
                } else {
                    $sqlearch = "Select o.id from SoftoneBundle:ProductSearch o where o.itemCode like '%" . $search[1] . "%' OR o.itemCode1 like '%" . $search[1] . "%' OR o.itemCode2 like '%" . $search[1] . "%'";
                }
                $qsupplier = "";
                if ($dt_columns[3]["search"]["value"] > 3) {

                    $supplier = $this->getDoctrine()
                                    ->getRepository('SoftoneBundle:SoftoneSupplier')->find($dt_columns[3]["search"]["value"]);
                    if ($supplier)
                        $qsupplier = " p.supplierId = '" . $supplier->getId() . "' AND ";
                }
                $qtitle = "";
                if ($dt_columns[2]["search"]["value"] != '') {
                    $qsupplier .= " (p.title = '" . $dt_columns[2]["search"]["value"] . "' OR  p.tecdocArticleName = '" . $dt_columns[2]["search"]["value"] . "') AND ";
                }

                //print_r($articleIds);
                $this->prefix = "p";
                if (count((array) $articleIds)) {
                    if ($search[1]) {
                        $tecdoc_article = "poi.tecdocArticleId in (" . implode(",", $articleIds) . ") OR poi.erpCode like '%" . $search[1] . "%'";
                        $sisxetisi = $this->prefix . ".sisxetisi in  (Select koo.sisxetisi FROM SoftoneBundle:Product koo where koo.sisxetisi != '' AND (koo.tecdocArticleId in (" . implode(",", $articleIds) . ") OR koo.erpCode like '%" . $search[1] . "%' OR koo.itemApvcode like '%" . $search[0] . "%' OR koo.itemCode1 like '%" . $search[1] . "%' OR koo.itemCode2 like '%" . $search[1] . "%'))";
                    } elseif ($search[0]) {
                        if (strlen($search[0]) > 250)
                            $search[0] = '|||||';
                        $tecdoc_article = "poi.tecdocArticleId in (" . implode(",", $articleIds) . ") OR poi.erpCode like '%" . $search[0] . "%'";
                        $sisxetisi = $this->prefix . ".sisxetisi in  (Select koo.sisxetisi FROM SoftoneBundle:Product koo where koo.sisxetisi != '' AND (koo.tecdocArticleId in (" . implode(",", $articleIds) . ") OR koo.erpCode like '%" . $search[0] . "%' OR koo.itemApvcode like '%" . $search[0] . "%' OR koo.itemCode1 like '%" . $search[0] . "%' OR koo.itemCode2 like '%" . $search[0] . "%'))";
                    } else {
                        $tecdoc_article = "poi.tecdocArticleId in (" . implode(",", $articleIds) . ")";
                        $sisxetisi = $this->prefix . ".sisxetisi in  (Select koo.sisxetisi FROM SoftoneBundle:Product koo where koo.sisxetisi != '' AND (koo.tecdocArticleId in (" . implode(",", $articleIds) . ")";
                    }
                } else {
                    $this->createWhere();
                    $sisxetisi = $this->prefix . ".sisxetisi in  (Select koo.sisxetisi FROM SoftoneBundle:Product koo where koo.sisxetisi != '' AND (koo.erpCode like '%" . $search[1] . "%' OR koo.itemApvcode like '%" . $search[0] . "%' OR koo.itemCode1 like '%" . $search[1] . "%' OR koo.itemCode2 like '%" . $search[1] . "%'))";
                }
                //echo  $sql;
                //$this->q_or[] = $this->prefix . ".id in  (Select k.product FROM SoftoneBundle:Sisxetiseis k where k.sisxetisi in (" . $sql . "))";



                $this->createWhere();

                $this->createOrderBy($fields, $dt_order);
                $this->createSelect($s);
                //$select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";

                $recordsFiltered = $em->getRepository($this->repository)->recordsFiltered($this->where);
                //$tecdoc_article = '';

                $this->orderBy = "p.qty desc";
                if (count((array) $articleIds)) {
                    $tecdoc_article = 'p.tecdocArticleId in (' . implode(",", $articleIds) . ') OR ';
                    if ($search[1])
                        $tecdoc_article2 = " p.erpCode like '%" . $search[1] . "%' OR ";
                    else
                    //$tecdoc_article2 = " p.id in (Select k.product FROM SoftoneBundle:Sisxetiseis k where k.sisxetisi in (" . $sql . ")) OR ";
                        $tecdoc_article2 = "";
                    $sql2 = 'SELECT  ' . $this->select . ', p.reference, p.id
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                where ' . $qsupplier . ' (p.erpCode like "%' . $search[1] . '%" OR ' . $tecdoc_article . $tecdoc_article2 . ' ' . $sisxetisi . ')
                                ORDER BY ' . $this->orderBy;

                    $sql = 'SELECT  ' . $this->select . ', p.reference, p.id
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                where ' . $qsupplier . ' (' . $tecdoc_article . $tecdoc_article2 . ' ' . $sisxetisi . ')
                                ORDER BY ' . $this->orderBy;
                } else {
                    $sql = 'SELECT  ' . $this->select . ', p.reference, p.id
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                where ' . $qsupplier . ' (' . $this->prefix . '.id in (' . $sqlearch . ') OR ' . $sisxetisi . ')
                                ORDER BY ' . $this->orderBy;
                }

                //echo $sql;
                //exit;

                $sql = str_replace("p.*,", "", $sql);
                //$sql = str_replace("ORDER BY p.qty asc","",$sql);

                $query = $em->createQuery(
                                $sql
                        )
                        ->setMaxResults($request->request->get("length"))
                        ->setFirstResult($request->request->get("start"))
                ;
                //echo $sql."<BR>";    
                /*
                  echo 'SELECT  ' . $this->select . ', p.reference
                  FROM ' . $this->repository . ' ' . $this->prefix . '
                  ' . $this->where . ' ' . $tecdoc_article . '
                  ORDER BY ' . $this->orderBy;
                  //exit;
                 */
                $results = $query->getResult();
            }
            $data["fields"] = $this->fields;

            $jsonarr = array();
            $jsonarrnoref = array();

            $r = explode(":", $this->repository);
            $i = 0;
            foreach (@(array) $results as $result) {
                $json = array();
                foreach ($data["fields"] as $field) {
                    if (@$field["index"]) {
                        $field_relation = explode(":", $field["index"]);
                        if (count($field_relation) > 1) {
                            //echo $this->repository;
                            $obj = $em->getRepository($this->repository)->find($result["id"]);
                            foreach ($field_relation as $relation) {
                                if ($obj)
                                    $obj = $obj->getField($relation);
                            }
                            $val = $obj;
                        } else {
                            $val = @$result[$field["index"]];
                        }
                        if (@$field["method"]) {
                            $method = $field["method"] . "Method";
                            $json[] = $this->$method($val);
                        } else {
                            if (@$field["input"]) {
                                $obj = $em->getRepository($this->repository)->find($result["id"]);
                                $ref = $obj->getField('reference'); //$result[$field["reference"]];
                                $f[] = $obj->getField('tecdocArticleId');
                                //$articleIds[] = $obj->getField('tecdocArticleId');
                                $value = $field["index"] == 'qty' ? 1 : 1;
                                $value = $field["index"] == 'edi' ? 1 : 1;
                                $json[] = "<input data-id='" . $result["id"] . "' data-rep='" . $this->repository . "' data-ref='" . $ref . "' id='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "_" . $result["id"] . "' data-id='" . $result["id"] . "' class='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "' type='" . $field["input"] . "' value='$value'>";
                            } else {
                                $json[] = $val;
                            }
                        }
                    } elseif (@$field["function"]) {
                        $func = $field["function"];
                        $obj = $em->getRepository($this->repository)->find($result["id"]);
                        $json[] = $obj->$func($order);
                    }
                }
                $apothema = $obj->getQty() - $obj->getReserved();
                $colorcss = $apothema > 0 ? "instock" : "outofstock";
                $json["DT_RowClass"] = $colorcss . " dt_row_" . strtolower($r[1]);
                $json["DT_RowId"] = 'dt_id_' . strtolower($r[1]) . '_' . $result["id"];
                /*
                  if ($result["reference"]) {
                  $jsonarr[(int) $result["reference"]] = $json;
                  } else {

                  $json[5] = str_replace("value='---'", "value='" . $obj->getField("itemPricew") . "'", $json[5]);
                  $json[6] = str_replace("value='---'", "value='1'", $json[6]);
                  $jsonarrnoref[$result["id"]] = $json;
                  }
                 * 
                 */
                $json[4] = $obj->getArticleAttributes2($articleIds2["linkingTargetId"]);
                $json[6] = number_format($json[6] * $vat, 2, '.', '');
                ;
                $json[7] = $obj->getDiscount($customer, $vat);
                $json[8] = $obj->getGroupedDiscountPrice($customer, $vat); //str_replace($obj->$priceField, $obj->getGroupedDiscountPrice($customer), $json[5]);
                //$json[6] = str_replace("value='---'", "value='1'", $json[6]);
                $jsonarrnoref[$result["id"]] = $json;
            }

            //$jsonarr = $this->softoneCalculate($jsonarr, $id);
            //echo count($jsonarr);
            $jsonarr = array_merge($jsonarr, $jsonarrnoref);


            //print_r($articleIds);
            $f = array_unique((array) $f);
            $articleIds = array_unique((array) $articleIds);
            $de = array_diff((array) $articleIds, (array) $f);
            //print_r($de);
            $out = $this->getArticlesSearchByIds(implode(",", (array) $de));
            //print_r($out);
            $p = array();

            foreach ((array) $out as $v) {
                $p[$v->articleId] = $v;
                $json = array();

                if ($supplier) {
                    if ($supplier->getTitle() != $v->brandName)
                        continue;
                }
                if ($dt_columns[2]["search"]["value"] != '') {
                    if ($dt_columns[2]["search"]["value"] != $v->genericArticleName)
                        continue;
                }


                $json[] = "";
                $json[] = "<span  car='' class='product_info' data-articleId='" . $v->articleId . "' data-ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->articleNo . "</span></a><BR><a class='create_product' data-ref='" . $v->articleId . "' style='font-size:10px; color:rose' href='#'>Create Product</a>";
                //$json[] = "<span car='' class='product_info' data-ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->articleNo . "</span>";
                $json[] = "<span car='' class='product_info tecdocArticleName' data-articleId='" . $v->articleId . "' data-ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->genericArticleName . "</span>";
                $json[] = "<span  car='' class='product_info' data-articleId='" . $v->articleId . "' data-ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->brandName . "</span>";
                $json[] = $this->getArticleAttributes($v->articleId, $articleIds2["linkingTargetId"]);
                $json[] = "";
                $json[] = "";
                $json[] = "";
                $json[] = "";
                $json[] = "";
                $json[] = "";
                $json[] = "";
                $json[] = "";

                $jsonarr[] = $json;
            }
            // print_r($p);
        }
        //$jsonarr = array_merge($jsonarr, $jsonarrnoref);

        $data["data"] = $jsonarr;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        return json_encode($data);
    }

    function getArticleAttributes($articleId, $linkingTargetId = '') {

        $tecdoc = new Tecdoc();

        $attributs = $tecdoc->getAssignedArticlesByIds(
                array(
                    "articleId" => $articleId,
                    "linkingTargetId" => $linkingTargetId
        ));
        $arr = array();
        $descrption .= "<ul class='product_attributes' style='max-height: 100px; overflow: hidden;'>";
        $attributes = array();
        foreach ($attributs->data->array[0]->articleAttributes->array as $attribute) {
            if (!$attributes[$attribute->attrId]) {
                $attributes[$attribute->attrId][] = trim(str_replace("[" . $attribute->attrUnit . "]", "", $attribute->attrName)) . ": " . $attribute->attrValue . $attribute->attrUnit;
            } else {
                $attributes[$attribute->attrId][] = $attribute->attrValue . $attribute->attrUnit;
            }
        }
        foreach ($attributes as $attrId => $attribute) {
            //if (!in_array($attribute->attrId, $arr)) {
            $arr[$attrId] = $attribute->attrId;
            $descrption .= "<li class='attr_" . $attrId . "'>" . implode(" / ", $attribute) . "</li>";
            //}
        }
        $descrption .= "</ul>";
        return $descrption;
    }

    public function softoneCalculate($jsonarr, $id) {
        if ((int) $id == 0)
            exit;
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);
        if ($id > 0) {
            $customer = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Customer")
                    ->find($order->getCustomer());
        }
        $jsonarr2 = array();
        foreach ($jsonarr as $json) {
            $jsonarr2[] = $json;
        }
        //return $jsonarr2;

        $softone = new Softone();
        $object = "SALDOC";
        $objectArr = array();
        $objectArr[0]["TRDR"] = $customer->getReference();
        $objectArr[0]["SERIESNUM"] = 1;
        $objectArr[0]["FINCODE"] = 1;
        $objectArr[0]["PAYMENT"] = 1000;
        //$objectArr[0]["TFPRMS"] = $model->tfprms;
        //$objectArr[0]["FPRMS"] = $model->fprms;
        $objectArr[0]["SERIES"] = 7021; //$model->series;
        //$objectArr[0]["DISC1PRC"] = 10;

        $dataOut[$object] = (array) $objectArr;
        $k = 9000001;
        $dataOut["ITELINES"] = array();

        $vat = $id > 0 ? $order->getVat()->getVatsts() : $this->getSetting("SoftoneBundle:Product:Vat");
        //$vat = 2310;

        foreach ($jsonarr as $MTRL => $json) {
            if ($MTRL)
                $dataOut["ITELINES"][] = array("QTY1" => 1, "VAT" => $vat, "LINENUM" => $json[1], "MTRL" => $MTRL);
        }

        //print_r($dataOut);
        $locateinfo = "MTRL,NAME,PRICE,QTY1,VAT;ITELINES:DISC1PRC,ITELINES:LINEVAL,MTRL,MTRL_ITEM_CODE,MTRL_ITEM_CODE1,MTRL_ITEM_NAME,MTRL_ITEM_NAME1,PRICE,QTY1;SALDOC:BUSUNITS,EXPN,TRDR,MTRL,PRICE,QTY1,VAT";
        $out = $softone->calculate((array) $dataOut, $object, "", "", $locateinfo);
        //print_r($out);
        //exit;
        foreach ((array) $out->data->ITELINES as $item) {
            $jsonarr[$item->MTRL][5] = str_replace("value='---'", "value='" . $item->LINEVAL . "'", $jsonarr[$item->MTRL][5]);
            $jsonarr[$item->MTRL][6] = str_replace("value='---'", "value='" . $item->LINEVAL . "'", $jsonarr[$item->MTRL][6]);
        }
        $jsonarr2 = array();
        foreach ($jsonarr as $json) {
            $jsonarr2[] = $json;
        }

        return $jsonarr2;
    }

    /**
     * @Route("/order/saveSoftone")
     */
    function saveSoftone(Request $request) {
        $vat = 1.24;
        $id = $request->request->get("id");
        $softone = new Softone();
        $object = "SALDOC";
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);
        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->find($order->getCustomer());
        if ($order->getVat())
            $vatsst = $id > 0 ? $order->getVat()->getVatsts() : $this->getSetting("SoftoneBundle:Product:Vat");
        else
            $vatsst = 1410; //$this->getSetting("SoftoneBundle:Product:Vat");

        if ($order->getReference() > 0) {
            $data = $softone->delData($object, (int) $order->getReference());
        }
        $objectArr = array();
        $objectArr[0]["TRDR"] = $customer->getReference();
        $objectArr[0]["SERIESNUM"] = $order->getId();
        $objectArr[0]["FINCODE"] = $order->getFincode();
        $objectArr[0]["PAYMENT"] = 1000;
        //$objectArr[0]["TFPRMS"] = $model->tfprms;
        //$objectArr[0]["FPRMS"] = $model->fprms;
        $objectArr[0]["SERIES"] = 7021; //$model->series;
        $objectArr[0]["VATSTS"] = $customer->getCustomerVatsts();
        //$objectArr[0]["DISC1PRC"] = 10;   
        $dataOut[$object] = (array) $objectArr;


        $dataOut["ITELINES"] = array();

        $k = 0;
        //print_r($dataOut);
        foreach ($order->getItems() as $item) {
            //$dataOut["ITELINES"][] = array("QTY1" => $item->getQty(), "VAT" => $vat, "LINENUM" => $item->getLineval(), "MTRL" => $item->getProduct()->getReference());
            $dataOut["ITELINES"][] = array(
                "VAT" => $vatsst,
                "QTY1" => $item->getQty(),
                "LINENUM" => $k++,
                "MTRL" => $item->getProduct()->getReference(),
                "PRICE" => $item->getPrice() / $vat,
                "LINEVAL" => $item->getLineval() / $vat,
                "DISC1PRC" => $item->getDisc1prc()
            );
        }

        $locateinfo = "MTRL,NAME,PRICE,QTY1,VAT;ITELINES:DISC1PRC,ITELINES:LINEVAL,MTRL,MTRL_ITEM_CODE,MTRL_ITEM_CODE1,MTRL_ITEM_NAME,MTRL_ITEM_NAME1,PRICE,QTY1;SALDOC:BUSUNITS,EXPN,TRDR,MTRL,PRICE,QTY1,VAT";
        //print_r($dataOut);
        $out = $softone->setData((array) $dataOut, $object, (int) 0);
        //print_r($out);

        if (@$out->id > 0) {
            if ($order->getReference() == 0) {
                foreach ($order->getItems() as $item) {
                    $product = $item->getProduct();
                    if ($product) {
                        $reserved = (int) $product->getReserved();
                        $reserved += $item->getQty();
                        $product->setReserved($reserved);
                        $this->flushpersist($product);
                        echo "\n(" . $reserved . ")\n";
                    }
                }
            }

            $order->setReference($out->id);
            $this->flushpersist($order);
        }
        //exit;

        $json = json_encode($out);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getArticlesSearchByIds($search) {
        //if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //$data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //return $data;
        //} else {
        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          $fields = array(
          'action' => 'getSearchByIds',
          'search' => $search
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
          //file_put_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term", $data);
         */
        $params = array(
            'search' => $search
        );
        $tecdoc = new Tecdoc();
        $data = $tecdoc->getArticlesSearchByIds($params);
        return $data->data->array;
        //}
    }

    public function getArticlesSearch($search) {
        // if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //    $data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //   return $data;
        //} else {
        //ADBRP002
        //if ($_SERVER["DOCUMENT_ROOT"] == 'C:\symfony\alexander\webb') {
        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");



          $fields = array(
          'action' => 'getSearch',
          'search' => $search
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
          return $data;
          //}
         */


        //} else {
        $tecdoc = new Tecdoc();
        $articles = $tecdoc->getArticlesSearch(array('search' => $this->clearstring($search)));
        //print_r($articles);
        //echo $search;
        foreach ($articles->data->array as $v) {
            $articleIds[] = $v->articleId;
        }
        return serialize($articleIds);
        //}
    }

    function getTabContentSearch($order) {

        $repormodels = $this->getDoctrine()->getRepository('SoftoneBundle:Reportmodel')->findBy(array('customerId' => $order->getCustomer()->getId()), array('ts' => 'DESC'));


        $history = "<ul>";
        foreach ($repormodels as $repormodel) {
            if ($i++ > 15)
                break;
            $brandModelType = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:BrandModelType')
                    ->find($repormodel->getModel());
            $brandsmodel = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:BrandModel')
                    ->find($brandModelType->getBrandModel());
            $brand = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Brand')
                    ->find($brandsmodel->getBrand());

            $yearfrom = substr($brandsmodel->getYearFrom(), 4, 2) . "/" . substr($brandsmodel->getYearFrom(), 0, 4);
            $yearto = substr($brandsmodel->getYearTo(), 4, 2) . "/" . substr($brandsmodel->getYearTo(), 0, 4);
            $yearto = $yearto == 0 ? 'Today' : $yearto;
            $year = $yearfrom . " - " . $yearto;
            $history .= "<li class='modelhistory' style='cursor:pointer' data-order='" . $order->getId() . "' data-ref='" . $repormodel->getModel() . "'>" . $brand->getBrand() . " " . $brandsmodel->getBrandModel() . " " . $year . " " . $brandModelType->getBrandModelType() . " " . $brandModelType->getEngine() . "</li>";
        }
        $history .= "</ul>";
        $response = $this->get('twig')->render('SoftoneBundle:Order:search.html.twig', array(
            'brands' => $this->getBrands(),
            'order' => $order->getId(),
            'history' => $history
        ));
        return str_replace("\n", "", htmlentities($response));
    }

    function getBrands() {
        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:Brand');
        $brands = $repository->findAll(array(), array('brand' => 'ASC'));
        return $brands;
    }

    /**
     * @Route("/order/motorsearch")
     */
    public function motorsearch() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT  p.id
                    FROM SoftoneBundle:BrandModelType p
                    where p.engine like '%" . $this->clearstring($_GET["term"]) . "%'"
        );
        $results = $query->getResult();

        foreach ($results as $result) {
            $brandModelType = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:BrandModelType')
                    ->find($result["id"]);
            $brandsmodel = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:BrandModel')
                    ->find($brandModelType->getBrandModel());
            $brand = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Brand')
                    ->find($brandsmodel->getBrand());

            $yearfrom = substr($brandsmodel->getYearFrom(), 4, 2) . "/" . substr($brandsmodel->getYearFrom(), 0, 4);
            $yearto = substr($brandsmodel->getYearTo(), 4, 2) . "/" . substr($brandsmodel->getYearTo(), 0, 4);
            $yearto = $yearto == 0 ? 'Today' : $yearto;
            $year = $yearfrom . " - " . $yearto;

            $json["id"] = $result["id"];
            $json["label"] = $brand->getBrand() . " " . $brandsmodel->getBrandModel() . " " . $year . " " . $brandModelType->getBrandModelType() . " " . $brandModelType->getEngine();
            $json["value"] = $result["id"];
            $jsonArr[] = $json;
        }

        $json = json_encode($jsonArr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/getmodels")
     */
    function getmodels(Request $request) {
        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModel');
        $brandsmodels = $repository->findBy(array('brand' => $request->request->get("brand")), array('brandModel' => 'ASC'));
        $out = array();
        $o["id"] = 0;
        $o["name"] = "Select an Option";
        $out[] = $o;
        foreach ($brandsmodels as $brandsmodel) {
            $yearfrom = substr($brandsmodel->getYearFrom(), 4, 2) . "/" . substr($brandsmodel->getYearFrom(), 0, 4);
            $yearto = substr($brandsmodel->getYearTo(), 4, 2) . "/" . substr($brandsmodel->getYearTo(), 0, 4);
            $yearto = $yearto == 0 ? 'Today' : $yearto;
            $year = $yearfrom . " - " . $yearto;
            $o["id"] = $brandsmodel->getId();
            $o["name"] = $brandsmodel->getBrandModel() . " " . $year;
            $out[] = $o;
        }

        $json = json_encode($out);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/getmodeltypes")
     */
    function getmodeltypes(Request $request) {
        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModelType');
        $brandsmodeltypes = $repository->findBy(array('brandModel' => $request->request->get("model")), array('brandModelType' => 'ASC'));
        $out = array();
        $out = array();
        $o["id"] = 0;
        $o["name"] = "Select an Option";
        $out[] = $o;
        foreach ($brandsmodeltypes as $brandsmodeltype) {
            $o["id"] = $brandsmodeltype->getId();

            $year = $yearfrom . " " . $yearto;
            if ($brandsmodeltype->getEngine() != "") {
                $o["name"] = $brandsmodeltype->getBrandModelType() . " (" . $brandsmodeltype->getEngine() . ")";
            } else {
                $o["name"] = $brandsmodeltype->getBrandModelType();
            }
            $out[] = $o;
        }

        $json = json_encode($out);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/getcategories")
     */
    function getcategories(Request $request) {


        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          $fields = array(
          'action' => 'getcarcategories',
          'linkingTargetId' => $request->request->get("car")
          );
          $fields_string = "";
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
          $data = unserialize($data);
         */
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $tecdoc = new Tecdoc();
        $params["linkingTargetId"] = $request->request->get("car");
        $data = $tecdoc->linkedChildNodesAllLinkingTargetTree($params);
        $articleIds = array();
        foreach ($data as $key => $dt) {
            foreach ((array) $dt->articleIds as $articleId) {
                $articleIds[] = $articleId;
            }
        }
        $order = $this->getDoctrine()->getRepository('SoftoneBundle:Order')->find($request->request->get("order"));
        $repormodel = $this->getDoctrine()->getRepository('SoftoneBundle:Reportmodel')->findOneBy(array("sessionId" => $session->getId(), 'customerId' => $order->getCustomer()->getId(), 'model' => $request->request->get("car")));

        if (!$repormodel)
            $repormodel = new Reportmodel();

        $dt = new \DateTime("now");
        $repormodel->setTs($dt);
        $repormodel->setCreated($dt);
        $repormodel->setModified($dt);
        $repormodel->setModel($request->request->get("car"));
        $repormodel->setCustomerId($order->getCustomer()->getId());

        $repormodel->setSessionId($session->getId());
        $repormodel->setIp($request->getClientIp());
        $repormodel->setActioneer(0);
        $repormodel->setFlatData('');
        $this->flushpersist($repormodel);

        $tecdocArticleIds = array();
        if (count($articleIds)) {
            $query = $em->createQuery(
                    "SELECT  p.tecdocArticleId
                        FROM 'SoftoneBundle:Product' p
                        where p.tecdocArticleId in (" . implode(",", $articleIds) . ")"
            );
            /*
              echo "SELECT  p.tecdocArticleId
              FROM 'SoftoneBundle:Product' p
              where p.tecdocArticleId in (" . implode(",", $articleIds) . ")";
             */
            $products = $query->getResult();
            //print_r($products);
            foreach ($products as $product) {
                $tecdocArticleIds[] = $product["tecdocArticleId"];
            }
        }


        //print_r($tecdocArticleIds);
        $tecdocEdiArticleIds = array();

        if (count($articleIds)) {
            $query = $em->createQuery(
                    "SELECT  p.tecdocArticleId
                        FROM 'EdiBundle:EdiItem' p, EdiBundle:Edi e
                        where 
                            e.id = p.Edi AND p.tecdocArticleId in (" . implode(",", $articleIds) . ")"
            );
            $products = $query->getResult();
            foreach ($products as $product) {
                $tecdocEdiArticleIds[] = $product["tecdocArticleId"];
            }
        }
        foreach ($data as $key => $dt) {
            $matched = array_intersect(@(array) $dt->articleIds, $tecdocArticleIds);
            $edimatched = array_intersect(@(array) $dt->articleIds, $tecdocEdiArticleIds);
            $dt->matched = array();
            $dt->matched = base64_encode(serialize($matched));
            $dt->matched_count = count($matched);

            $dt->edimatched = array();
            $dt->edimatched = base64_encode(serialize($edimatched));
            $dt->edimatched_count = count($edimatched);

            $all["matched"] = (array) $matched;
            $all["edimatched"] = (array) $edimatched;
            $all["articleIds"] = @(array) $dt->articleIds;
            $all["linkingTargetId"] = $params["linkingTargetId"];
            $dt->all = base64_encode(serialize($all));
            //$data[$key] = $dt;
        }
        $json = json_encode($data);
        //$data = unserialize($data);

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
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
        $this
                ->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Ημερομηνία", 'datetime' => 'Y-m-d H:s:i', "index" => 'created'))
                ->addField(array("name" => "Παραστατικό", "index" => 'fincode'))
                ->addField(array("name" => "Customer Name", "index" => 'customerName'))
                ->addField(array("name" => "ΑΦΜ", "index" => 'customer:customerAfm'))
                ->addField(array("name" => "Παραγγελία", "index" => 'reference', 'method' => 'yesno'))
                ->addField(array("name" => "Τιμολογημένη", "index" => 'fullytrans', 'method' => 'yesno'))
                ->addField(array("name" => "Πωλητής", "index" => 'user:username'))
                ->addField(array("name" => "Σύνολο", 'function' => 'getTotal'))

        ;
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT id FROM  `softone_order` WHERE id IN (SELECT s_order FROM softone_orderitem)";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();
        foreach ($results as $data) {
            $arr[] = $data["id"];
        }
        $this->q_and[] = $this->prefix . ".id in (" . implode(",", $arr) . ")";

        $json = $this->datatable();


        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        $i = 0;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $tbl = (array) $table;
            $table1 = array();

            foreach ($table as $f => $val) {
                if ($f == 0 AND $f != 'DT_RowId' AND $f != 'DT_RowClass') {
                    $table1[$f] = $val;
                    if ($i++ < 100) {
                        $table1[1] = $this->getOrderItemsPopup($val);
                    }
                    //$hasOrderItems = $this->getHasOrderItems($val);
                } else if ($f == 1) {
                    $table1[$f] = $table1[1] . $val;
                } else {
                    $table1[$f] = $val;
                }
            }
            //if ($hasOrderItems) {
            $datatable->data[$key] = $table1;
            //} else {
            //$datatable->data[$key] = $table1;
            //unset($datatable->data[$key]);
            //}
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function getHasOrderItems($id) {
        $id = (int) $id;

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $content = array();
        if ($entity) {
            if (count($entity->getItems()))
                return true;
        }
        return false;
    }

    function getOrderItemsPopup($id) {
        $id = (int) $id;

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $content = array();
        if ($entity) {
            $html = $entity->getId();

            foreach ($entity->getItems() as $item) {
                if ($item->getProduct()) {
                    $items = array();
                    $items["id"] = $item->getId();
                    $items["Code"] = $item->getProduct()->getItemCode();
                    $items["Title"] = $item->getProduct()->getTitle();
                    $items["Qty"] = $item->getQty();
                    $items["Price"] = $item->getLineval();
                    @$total += $item->getLineval();
                    $content[] = $items;
                }
            }
            $items = array();
            $items["id"] = "";
            $items["Title"] = "";
            $items["Code"] = "";
            $items["Qty"] = "";
            $items["Price"] = @$total;
            $content[] = $items;
        }

        $response = $this->get('twig')->render('SoftoneBundle:Order:items.html.twig', array('content' => $content));
        return $response;
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
        $json = $this->itemsdatatable();

        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $table1 = array();
            foreach ($table as $f => $val) {
                $table1[$f] = $val;
            }
            $datatable->data[$key] = $table1;
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function itemsdatatable() {
        $data = json_decode($this->datatable());
        $total = 0;
        foreach ($data->data as $item) {

            $of = "10";

            $text = $item->$of;
            $document = new \DOMDocument();
            $document->loadHTML($text);

            $inputs = $document->getElementsByTagName("input");
            $value = 0;
            foreach ($inputs as $input) {
                $value = $input->getAttribute("value");
                break;
            }
            $total += $value;
        }
        $total = number_format($total, 2, '.', '');
        $json[0] = "";
        $json[1] = "";
        $json[2] = "";
        $json[3] = "";
        $json[4] = "";
        $json[5] = "";
        $json[6] = "";
        $json[7] = "";
        $json[8] = "";
        $json[9] = "";
        $json[10] = "Total";
        $json[11] = $total;

        $data->data[] = $json;
        return json_encode($data);
    }

    /**
     * @Route("/order/addorderitem/")
     */
    public function addorderitemAction(Request $request) {

        $vat = 1.24;
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
         * 
         */

        $orderItem = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Orderitem")
                ->findOneBy(array("order" => $order, "product" => $product));

        if (@$orderItem->id == 0) {
            $orderItem = new Orderitem;
            $orderItem->setOrder($order);
            $orderItem->setProduct($product);
        } else {
            $qty = $orderItem->getQty();
        }


        if (!$product->reference) {
            $product = $this->saveProductSoftone($product);
        }
        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->find($order->getCustomer());
        $price = $product->getGroupedPrice($customer, $vat);

        $orderItem->setField("qty", $qty + $request->request->get("qty"));
        $orderItem->setField("price", $price);
        $orderItem->setField("lineval", $product->getGroupedDiscountPrice($customer, $vat) * $request->request->get("qty"));
        $orderItem->setField("disc1prc", $product->getGroupedDiscount($customer, $vat));
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

    function saveProductSoftone($model) {



        $object = "ITEM";
        $softone = new Softone();
        //$fields = $softone->retrieveFields($object, $params["list"]);


        $fields[] = "item_code";
        $fields[] = "item_name";
        $fields[] = "item_code1";
        $fields[] = "item_code2";
        $fields[] = "item_name1";
        $fields[] = "item_mtrunit1";
        $fields[] = "item_pricew";
        $fields[] = "item_pricer";
        $fields[] = "item_pricew01";
        $fields[] = "item_pricer01";
        $fields[] = "item_pricew02";
        $fields[] = "item_pricew03";
        $fields[] = "item_pricer02";
        $fields[] = "item_vat";
        $fields[] = "item_mtrmanfctr";
        $fields[] = "item_mtrplace";
        $fields[] = "item_isactive";

        //$fields[] = "item_mtrsup";
        $fields[] = "item_mtrcategory";
        $fields[] = "item_markupw";
        $fields[] = "item_isactive";

        $fields[] = "item_cccfxreltdcode";
        $fields[] = "item_cccfxrelbrand";
        //print_r($fields); 
        //return;
        //echo 'sss';
        if ($model->reference) {
            $data = $softone->getData($object, $model->reference);
            $objectArr = $data->data->$object;
            $objectArr2 = (array) $objectArr[0];
            foreach ($fields as $field) {
                $field1 = strtoupper(str_replace(strtolower($object) . "_", "", $field));
                $objectArr2[$field1] = $model->getField($field);
                //}
            }
            $objectArr2["CODE2"] = $model->supplier_code;
            $objectArr2["ISACTIVE"] = $model->item_isactive;
            $objectArr2["PRICER01"] = $objectArr2["PRICEW01"] * 1.24;
            $objectArr2["PRICER02"] = $objectArr2["PRICEW02"] * 1.24;
            $objectArr[0] = $objectArr2;
            $dataOut[$object] = (array) $objectArr;
            $dataOut["ITEEXTRA"][0] = array("NUM02" => $model->item_mtrl_iteextra_num02);
            //print_r($dataOut);
            $out = $softone->setData((array) $dataOut, $object, $model->reference);
            //print_r($out);
        } else {
            $objectArr = array();
            foreach ($fields as $field) {
                $field1 = strtoupper(str_replace(strtolower($object) . "_", "", $field));

                $as = explode("_", $field);
                $asf = $as[0] . ucfirst($as[1]);

                $objectArr2[$field1] = $model->getField($asf);
            }
            $objectArr2["MTRUNIT1"] = 101; //$model->supplierCode;
            //$objectArr2["ISACTIVE"] = $model->item_isactive;
            $objectArr2["PRICER01"] = $objectArr2["PRICEW01"] * 1.24;
            $objectArr2["PRICER02"] = $objectArr2["PRICEW02"] * 1.24;
            $objectArr[0] = $objectArr2;
            $dataOut[$object] = (array) $objectArr;
            //$dataOut["ITEEXTRA"][0] = array("NUM02" => $model->item_mtrl_iteextra_num02);
            //print_r($dataOut);
            $out = $softone->setData((array) $dataOut, $object, (int) $model->reference);

            if ($out->id > 0) {
                $model->setField("reference", $out->id);
                @$this->flushpersist($model);
            }
            //print_r($out);
        }
        return $model;
    }

    /**
     * @Route("/order/editorderitem/")
     */
    public function editorderitemAction(Request $request) {
        $orderItem = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Orderitem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty")) {
            $orderItem->setQty($request->request->get("qty"));
        } else if ($request->request->get("price"))
            $orderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount"))
            $orderItem->setDisc1prc($request->request->get("discount"));
        elseif ($request->request->get("livevalqty")) {
            //$orderItem->setDisc1prc($request->request->get("discount"));
            $disc1prc = 1 - ($request->request->get("livevalqty") / $orderItem->getPrice());
            $orderItem->setDisc1prc($disc1prc * 100);
        } elseif ($request->request->get("liveval")) {
            //$orderItem->setDisc1prc($request->request->get("discount"));
            $disc1prc = 1 - (($request->request->get("liveval") / $orderItem->getQty()) / $orderItem->getPrice());
            $orderItem->setDisc1prc($disc1prc * 100);
        } elseif ($request->request->get("qty") == "0") {
            try {
                $this->flushremove($orderItem);
                $json = json_encode(array("error" => false));
            } catch (\Exception $e) {
                $json = json_encode(array("error" => true, "message" => "Product Exists"));
            }
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
        $fprice = ($orderItem->getPrice() * $orderItem->getQty()) * (1 - ($orderItem->getField('disc1prc') / 100));
        $orderItem->setLineval($fprice);
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

    /**
     * @Route("/order/setb2border")
     */
    public function setb2borderAction(Request $request) {

        //$json = '{"SALDOC":[{"TRDR":"364","SERIESNUM":"1100003181","FINCODE":"B2B1100003181","PAYMENT":1010,"VATSTS":"1410","SERIES":7021,"WHOUSE":1101,"ID":"1035"}],"ITELINES":[{"VAT":"1410","QTY1":1,"LINENUM":9000001,"MTRL":"136922","PRICE":83.69,"DISC1PRC":null}]}';
        $json = $request->getContent();

        $order = json_decode($json, true);
        print_r($order);
        $ord = $order["SALDOC"][0];
        if (!$ord["ID"])
            exit;
        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->findOneByReference($ord["TRDR"]);
        $vat = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Vat")
                ->findOneBy(array('enable' => 1, 'id' => $customer->getCustomerVatsts()));

        $user = $this->getDoctrine()
                ->getRepository("AppBundle:User")
                ->find(2);
        

        $entity = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->findOneByReference($ord["ID"]);

        if (!$entity) {
            $entity = new Order;
            $this->newentity[$this->repository] = $entity;
            $this->initialazeNewEntity($entity);
        }


        $entity->setCustomer($customer);
        $entity->setUser($user);
        $entity->setReference($ord["ID"]);
        $entity->setFincode($ord["FINCODE"]);
        $entity->setSeries($ord["SERIES"]);

        $entity->setRemarks($ord["REMARKS"]);
        $entity->setComments($ord["COMMENTS"]);

        $entity->setVat($vat);
        $entity->setCustomerName($customer->getCustomerName() . " (" . $customer->getCustomerAfm() . " - " . $customer->getCustomerCode() . ")");
        $route = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Route")
                ->find(1);
        $entity->setRoute($route);
        $this->flushpersist($entity);

        $sql = 'DELETE FROM softone_orderitem where s_order = "' . $entity->getId() . '"';
        $this->getDoctrine()->getConnection()->exec($sql);
        $items = $order["ITELINES"];

        $vat = 1.24;

        foreach ($items as $item) {
            $product = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Product')
                    ->findOneByReference($item["MTRL"]);
            $orderItem = new Orderitem;
            $orderItem->setOrder($entity);
            $orderItem->setPrice($item["PRICE"] * $vat);
            $orderItem->setDisc1prc((float) $item["DISC1PRC"]);
            $orderItem->setLineval($item["LINEVAL"] * $item["QTY1"] * $vat);
            $orderItem->setQty($item["QTY1"]);
            $orderItem->setChk(1);
            $orderItem->setProduct($product);
            $this->flushpersist($orderItem);
        }

        exit;
    }

    function imitelisMethod($value) {
        return "YES";
    }

}
