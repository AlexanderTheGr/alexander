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

class OrderController extends \SoftoneBundle\Controller\SoftoneController {

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
                    'order' => $id,
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
        //$this->newentity[$this->repository]->setField("route", 0);
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
        $order->setCustomer($request->request->get("customer"));

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
            $fields["customerName"] = array("label" => "Customer Name", 'class' => 'asdfg');
            $fields["fincode"] = array("label" => "Code", 'class' => 'asdfg');
        } else {
            if ($entity->getFincode() == '') {
                $fincode = (int) $this->getSetting("SoftoneBundle:Order:fincode");
                $entity->setField("fincode", str_pad($fincode, 7, "0", STR_PAD_LEFT));
                $fincode++;
                $this->setSetting("SoftoneBundle:Order:fincode", $fincode);
            }
            $fields["fincode"] = array("label" => "Code", 'class' => 'asdfg');
            $fields["customerName"] = array("label" => "Customer Name", 'class' => 'asdfg');
            $fields["route"] = array("label" => "Route", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Route', 'name' => 'route', 'value' => 'id'));
            $fields["vat"] = array("label" => "Vat", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Vat', 'name' => 'vat', 'value' => 'id'));
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


        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            $this->addTab(array("title" => "Search", "datatables" => array(), "form" => '', "content" => $this->getTabContentSearch($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
            $this->addTab(array("title" => "Items", "datatables" => $datatables, "form" => '', "content" => $this->getTotals($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
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

        $dtparams = array();
        $dtparams[] = array("name" => "ID", "index" => 'id', "input" => 'checkbox', "active" => "active");
        $dtparams[] = array("name" => "Erp Code", "index" => 'erpCode', 'search' => 'text');
        $dtparams[] = array("name" => "TecDoc Code", "index" => 'tecdocCode', 'search' => 'text');
        $dtparams[] = array("name" => "Title", "index" => 'title', 'search' => 'text');
        $dtparams[] = array("name" => "Supplier", "index" => 'erpSupplier', 'search' => 'text');
        $dtparams[] = array("name" => "Price", "index" => 'itemPricew01', "input" => 'text', 'search' => 'text');
        $dtparams[] = array("name" => "QTY", "index" => 'qty', "input" => 'text', 'search' => 'text');
        $dtparams[] = array("name" => "EDI", "index" => 'edi', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "ID", "function" => 'getAvailability', "active" => "active");
        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases_' . $id;
        $params['url'] = '/order/getfororderitems/' . $id;
        $params["ctrl"] = 'ctrlgetoffcanvases';
        $params["app"] = 'appgetoffcanvases';
        $params["drawCallback"] = 'fororder(' . $id . ')';
        $datatables[] = $this->contentDatatable($params);





        $dtparams = array();
        $dtparams[] = array("name" => "ID", "index" => 'id', "input" => 'checkbox', "active" => "active");
        $dtparams[] = array("name" => "Edi", "index" => 'Edi:name', 'search' => 'select', 'type' => 'select');
        $dtparams[] = array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text');
        $dtparams[] = array("name" => "Brand", "index" => 'brand', 'search' => 'text');
        $dtparams[] = array("name" => "Part No", "index" => 'partno', 'search' => 'text');
        $dtparams[] = array("name" => "Description", "index" => 'description', 'search' => 'text');
        //$dtparams[] = array("name" => "Tecdoc Name", "index" => 'tecdocArticleName', 'search' => 'text');
        $dtparams[] = array("name" => "Price", "index" => 'retailprice', 'search' => 'text');
        $dtparams[] = array("name" => "QTY1", "index" => 'qty1', "input" => 'text', 'search' => 'text');
        $dtparams[] = array("name" => "QTY2", "index" => 'qty2', "input" => 'text', 'search' => 'text');
        //$dtparams[] = array("name" => "QTY", "index" => 'qty', "input" => 'text', 'search' => 'text');



        $params['dtparams'] = $dtparams;
        $params['id'] = $dtparams;
        $params['key'] = 'getoffcanvases2_' . $id;
        $params['url'] = '/edi/ediitem/getorderdatatable/1';
        $params["ctrl"] = 'ctrlgetoffcanvases2';
        $params["app"] = 'appgetoffcanvases2';
        $params["drawCallback"] = 'fororder2(' . $id . ')';
        $datatables[] = $this->contentDatatable($params);


        //$datatables = array();
        $this->addOffCanvas(array('id' => 'asdf', "content" => '', "index" => $this->generateRandomString(), "datatables" => $datatables));
        //$this->addOffCanvas(array('id' => 'asdf2', "content" => '', "index" => $this->generateRandomString(), "datatables" => $datatables));
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

        $json = $this->fororderitemsDatatable($id);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function fororderitemsDatatable($id = false) {
        ini_set("memory_limit", "1256M");
        $request = Request::createFromGlobals();

        $recordsTotal = 0;
        $recordsFiltered = 0;
        //$this->q_or = array();
        //$this->q_and = array();

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

            $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($dt_search["value"])));
            @$articleIds2 = unserialize(base64_decode($dt_search["value"]));



            $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);

            //print_r($articleIds2["articleIds"]);

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







                $this->createWhere();


                $this->prefix = "po";
                $sql = 'SELECT  po.id
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                ' . $this->where . ' ' . $tecdoc_article;

                $this->prefix = "p";
                $this->q_or[] = $this->prefix . ".id in  (Select k.product FROM SoftoneBundle:Sisxetiseis k where k.sisxetisi in (".$sql."))";
                
                $this->createWhere();

                $this->createOrderBy($fields, $dt_order);
                $this->createSelect($s);
                $select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";

                $recordsFiltered = $em->getRepository($this->repository)->recordsFiltered($this->where);
                $tecdoc_article = '';
                if (count((array) $articleIds))
                    $tecdoc_article = 'OR p.tecdocArticleId in (' . implode(",", $articleIds) . ')';


                $sql = 'SELECT  ' . $this->select . ', p.reference
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                ' . $this->where . ' ' . $tecdoc_article . '
                                ORDER BY ' . $this->orderBy;

                echo  $sql;


                $query = $em->createQuery(
                                $sql
                        )
                        ->setMaxResults($request->request->get("length"))
                        ->setFirstResult($request->request->get("start"));

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
                                $value = $field["index"] == 'qty' ? 1 : '---';
                                $value = $field["index"] == 'edi' ? 1 : '---';
                                $json[] = "<input data-id='" . $result["id"] . "' data-rep='" . $this->repository . "' data-ref='" . $ref . "' id='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "_" . $result["id"] . "' data-id='" . $result["id"] . "' class='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "' type='" . $field["input"] . "' value='$value'>";
                            } else {
                                $json[] = $val;
                            }
                        }
                    } elseif (@$field["function"]) {
                        $func = $field["function"];
                        $obj = $em->getRepository($this->repository)->find($result["id"]);
                        $json[] = $obj->$func(count($results));
                    }
                }
                $json["DT_RowClass"] = "dt_row_" . strtolower($r[1]);
                $json["DT_RowId"] = 'dt_id_' . strtolower($r[1]) . '_' . $result["id"];
                if ($result["reference"]) {
                    $jsonarr[(int) $result["reference"]] = $json;
                } else {
                    $jsonarrnoref[$result["id"]] = $json;
                }
            }

            $jsonarr = $this->softoneCalculate($jsonarr, $id);
            //echo count($jsonarr);
            $jsonarr = array_merge($jsonarr, $jsonarrnoref);


            //print_r($articleIds);
            $f = array_unique((array) $f);
            $articleIds = array_unique((array) $articleIds);
            $de = array_diff((array) $articleIds, (array) $f);
            //print_r($de);
            $out = unserialize($this->getArticlesSearchByIds(implode(",", (array) $de)));
            $p = array();
            foreach ($out as $v) {
                $p[$v->articleId] = $v;
                $json = array();

                $json[] = "";
                $json[] = "<span  car='' class='product_info' ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->articleNo . "</span></a><BR><a class='create_product' ref='" . $v->articleId . "' style='font-size:10px; color:rose' href='#'>Create Product</a>";
                $json[] = "<span  car='' class='product_info' ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->articleNo . "</span>";
                $json[] = "<span  car='' class='product_info' ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->genericArticleName . "</span>";
                $json[] = "<span  car='' class='product_info' ref='" . $v->articleId . "' style='font-size:10px; color:blue'>" . $v->brandName . "</span>";
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
        foreach ($out->data->ITELINES as $item) {
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
        $id = $request->request->get("id");
        $softone = new Softone();
        $object = "SALDOC";
        $order = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")
                ->find($id);
        $customer = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Customer")
                ->find($order->getCustomer());
        $vat = $id > 0 ? $order->getVat()->getVatsts() : $this->getSetting("SoftoneBundle:Product:Vat");
        //$vat = $id > 0 ? $order->getVat()->getId() : $this->getSetting("SoftoneBundle:Product:Vat");

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

        foreach ($order->getItems() as $item) {
            //$dataOut["ITELINES"][] = array("QTY1" => $item->getQty(), "VAT" => $vat, "LINENUM" => $item->getLineval(), "MTRL" => $item->getProduct()->getReference());
            $dataOut["ITELINES"][] = array(
                "VAT" => $vat,
                "QTY1" => $item->getQty(),
                "LINENUM" => $k++,
                "MTRL" => $item->getProduct()->getReference(),
                "PRICE" => $item->getPrice(),
                "LINEVAL" => $item->getLineval(),
                "DISC1PRC" => $item->getDisc1prc()
            );
        }

        $locateinfo = "MTRL,NAME,PRICE,QTY1,VAT;ITELINES:DISC1PRC,ITELINES:LINEVAL,MTRL,MTRL_ITEM_CODE,MTRL_ITEM_CODE1,MTRL_ITEM_NAME,MTRL_ITEM_NAME1,PRICE,QTY1;SALDOC:BUSUNITS,EXPN,TRDR,MTRL,PRICE,QTY1,VAT";

        $out = $softone->setData((array) $dataOut, $object, (int) 0);
        //print_r($out);

        if (@$out->id > 0) {
            $order->setReference($out->id);
            $this->flushpersist($order);
        }
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
        return $data;
        //}
    }

    public function getArticlesSearch($search) {
        // if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //    $data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //   return $data;
        //} else {
        //ADBRP002
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
    }

    function getTabContentSearch($order) {
        $response = $this->get('twig')->render('SoftoneBundle:Order:search.html.twig', array(
            'brands' => $this->getBrands(),
            'order' => $order->getId()
        ));
        return str_replace("\n", "", htmlentities($response));
    }

    function getBrands() {
        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:Brand');
        $brands = $repository->findAll(array(), array('brand' => 'ASC'));
        return $brands;
    }

    /**
     * @Route("/order/getmodels")
     */
    function getmodels(Request $request) {
        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:BrandModel');
        $brandsmodels = $repository->findBy(array('brand' => $request->request->get("brand")));
        $out = array();
        foreach ($brandsmodels as $brandsmodel) {
            $o["id"] = $brandsmodel->getId();
            $o["name"] = $brandsmodel->getBrandModel();
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
        $brandsmodeltypes = $repository->findBy(array('brandModel' => $request->request->get("model")));
        $out = array();
        foreach ($brandsmodeltypes as $brandsmodeltype) {
            $o["id"] = $brandsmodeltype->getId();
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

        //$url = "http://service4.fastwebltd.com/";
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

        $repository = $this->getDoctrine()->getRepository('SoftoneBundle:Product');
        $query = $repository->createQueryBuilder('p')
                ->where('p.tecdocArticleId > :tecdocArticleId')
                ->setParameter('tecdocArticleId', '0')
                ->getQuery();

        $products = $query->getResult();
        $tecdocArticleIds = array();
        foreach ($products as $product) {
            $tecdocArticleIds[] = $product->getTecdocArticleId();
        }
        //print_r($tecdocArticleIds);

        foreach ($data as $key => $dt) {
            $matched = array_intersect(@(array) $dt->articleIds, $tecdocArticleIds);
            $dt->matched = array();
            $dt->matched = base64_encode(serialize($matched));
            $dt->matched_count = count($matched);
            $all["matched"] = (array) $matched;
            $all["articleIds"] = @(array) $dt->articleIds;
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



        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $tbl = (array) $table;
            $table1 = array();
            foreach ($table as $f => $val) {
                if ($f == 0 AND $f != 'DT_RowId' AND $f != 'DT_RowClass') {
                    $table1[$f] = $val;
                    $table1[1] = $this->getOrderItemsPopup($val);
                } else if ($f == 1) {
                    $table1[$f] = $table1[1] . $val;
                } else {
                    $table1[$f] = $val;
                }
            }
            $datatable->data[$key] = $table1;
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
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
                $items = array();
                $items["id"] = $item->getId();
                $items["Title"] = $item->getProduct()->getTitle();
                $items["Qty"] = $item->getQty();
                $items["Price"] = $item->getLineval();
                @$total += $item->getLineval();
                $content[] = $items;
            }
            $items = array();
            $items["id"] = "";
            $items["Title"] = "";
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
            $of = "7";
            ;
            $total += $item->$of;
        }
        $json[0] = "";
        $json[1] = "";
        $json[2] = "";
        $json[3] = "";
        $json[4] = "";
        $json[5] = "";
        $json[6] = "Total";
        $json[7] = $total;

        $data->data[] = $json;
        return json_encode($data);
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
        $orderItem = new Orderitem;
        $orderItem->setOrder($order);
        $orderItem->setProduct($product);

        if (!$product->reference) {
            $product = $this->saveProductSoftone($product);
        }

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
            $objectArr2["PRICER01"] = $objectArr2["PRICEW01"] * 1.23;
            $objectArr2["PRICER02"] = $objectArr2["PRICEW02"] * 1.23;
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
            $objectArr2["PRICER01"] = $objectArr2["PRICEW01"] * 1.23;
            $objectArr2["PRICER02"] = $objectArr2["PRICEW02"] * 1.23;
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

    function imitelisMethod($value) {
        return "YES";
    }

}
