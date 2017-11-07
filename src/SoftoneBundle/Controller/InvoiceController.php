<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Invoice as Invoice;
use SoftoneBundle\Entity\InvoiceItem as InvoiceItem;
use SoftoneBundle\Entity\Softone as Softone;
use AppBundle\Controller\Main as Main;

class InvoiceController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Invoice';
    var $newentity = '';

    /**
     * @Route("/invoice/invoice")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Invoice:index.html.twig', array(
                    'pagename' => $this->getTranslation('Invoices'),
                    'url' => '/invoice/getdatatable',
                    'view' => '/invoice/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/invoice/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();

        $content = $this->gettabs($id);
        //$content = $this->getoffcanvases($id);
        $invoice = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $pagename = "";
        if ($invoice) {
            $pagename = $invoice->getInvoice();
        }
        $content = $this->content();

        return $this->render('SoftoneBundle:Invoice:view.html.twig', array(
                    'pagename' => $pagename,
                    'invoice' => $id,
                    'url' => '/invoice/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/invoice/save")
     */
    public function saveAction() {
        $entity = new \SoftoneBundle\Entity\Invoice;
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("status", 1);
        $out = $this->save();
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            //$jsonarr["returnurl"] = "/invoice/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/invoice/editinvoiceitem/")
     */
    public function editorderitemAction(Request $request) {
        $orderItem = $this->getDoctrine()
                ->getRepository('SoftoneBundle:InvoiceItem')
                ->find($request->request->get("id"));
        if ($request->request->get("qty") != '') {
            $orderItem->setQty($request->request->get("qty"));
        } else if ($request->request->get("price") != '')
            $orderItem->setPrice($request->request->get("price"));
        else if ($request->request->get("discount") != '')
            $orderItem->setDisc1prc($request->request->get("discount"));
        elseif ($request->request->get("livevalqty") != '') {
            //$orderItem->setDisc1prc($request->request->get("discount"));
            $disc1prc = 1 - ($request->request->get("livevalqty") / $orderItem->getPrice());
            $orderItem->setDisc1prc($disc1prc * 100);
        } elseif ($request->request->get("liveval") != '') {
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

    /**
     * @Route("/invoice/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new \SoftoneBundle\Entity\Invoice;
            $this->newentity[$this->repository] = $entity;
        }

        $fields["invoice"] = array("label" => $this->getTranslation("Invoice"));
        //$fields["routeName"] = array("label" => "Name");

        $forms = $this->getFormLyFields($entity, $fields);

        if ($id > 0 AND count($entity) > 0) {

            $entity2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Product')
                    ->find($id);
            $entity2->setReference("");
            $fields2["reference"] = array("label" => "Erp Code", "className" => "invoicecode col-md-12");
            $forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "", "function" => 'deleteitem');
            //$dtparams[] = array("name" => "Code", "index" => 'code');
            $dtparams[] = array("name" => $this->getTranslation("Product Name"), "function" => 'getForOrderItemsTitle', 'search' => 'text');
            $dtparams[] = array("name" => $this->getTranslation("Product Code"), "index" => 'product:erpCode');
            $dtparams[] = array("name" => $this->getTranslation("Supplier"), "function" => 'getForOrderSupplier', 'search' => 'text');
            $dtparams[] = array("name" => $this->getTranslation("Invetory"), "function" => 'getProductApothiki', 'search' => 'text');
            $dtparams[] = array("name" => $this->getTranslation("Qty"), "input" => "text", "index" => 'qty');
            $dtparams[] = array("name" => $this->getTranslation("Price"), "input" => "text", "index" => 'price');
            $dtparams[] = array("name" => $this->getTranslation("Final Price"), "index" => 'fprice');
            //$dtparams[] = array("name" => "Price", "index" => 'storeWholeSalePrice');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/invoice/invoice/getitems/' . $id;
            //$params['view'] = '/invoice/invoice/item/view';
            //$params['viewnew'] = '/invoice/invoice/item/view/new/' . $id;

            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }

        $this->addTab(array("title" => $this->getTranslation("General"), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => $this->getTranslation("Items"), "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
        }
        foreach ((array) $tabs as $tab) {
            $this->addTab($tab);
        }
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/invoice/readInvoices")
     */
    public function readInvoices() {
        $dir = '/home2/partsbox/public_html/partsbox/web/files/partsboxtsakonas/invoices/';
        $files1 = scandir($dir);
        foreach ($files1 as $file) {
            if (!in_array($file, array(".", ".."))) {
                echo $dir . $file . "<BR>";
                $this->readInvoiceFile($dir . $file);
            }
        }
        exit;
        //$this->readInvoiceFile($file);
    }

    public function readInvoiceFile($file) {
        $em = $this->getDoctrine()->getManager();
        //$file = "/home2/partsbox/public_html/partsbox/web/files/partsboxtsakonas/invoice.csv";
        $availability = false;
        $inv = array();
        if (($handle = fopen($file, "r")) !== FALSE) {
            fgetcsv($handle, 1000000, ";");
            while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                if (count($data) < 7)
                    continue;
                //if ($invoice->getReference() > 0)
                //    continue;
                $invoice = $this->getDoctrine()
                        ->getRepository($this->repository)
                        ->findOneBy(array('invoice' => $data[0]));

                if (!$invoice) {
                    $dt = new \DateTime("now");
                    $invoice = new Invoice;
                    $invoice->setInvoice($data[0]);
                    $invoice->setTs($dt);
                    $invoice->setCreated($dt);
                    $invoice->setModified($dt);
                    $this->flushpersist($invoice);
                    $invoice = $this->getDoctrine()
                            ->getRepository($this->repository)
                            ->findOneBy(array('invoice' => $data[0]));
                }
                if ($invoice->getReference() > 0)
                    continue;
                if (!$inv[$invoice->getId()] AND $invoice->getReference() == 0) {
                    $sql = "delete from  softone_invoice_item where invoice = '" . $invoice->getId() . "'";
                    $em->getConnection()->exec($sql);
                    $inv[$invoice->getId()] = true;
                }

                $data[6] = str_replace("'", "", $data[6]);
                $product = $this->getDoctrine()
                        ->getRepository("SoftoneBundle:Product")
                        ->findOneBy(array('itemCode2' => $data[6]));
                if ($product AND $invoice) {
                    $invoiceItem = new InvoiceItem;
                    $invoiceItem->setInvoice($invoice);
                    $invoiceItem->setProduct($product);
                    $invoiceItem->setCode($product->getErpCode());
                    $invoiceItem->setQty($data[5]);
                    $invoiceItem->setPrice($data[7]);
                    $invoiceItem->setFprice($data[7] * $data[5]);
                    $invoiceItem->setDiscount(0);
                    $invoiceItem->setChk(1);
                    $this->flushpersist($invoiceItem);
                }
            }
        }
        //exit;
    }

    /**
     * @Route("/invoice/addItem")
     */
    public function addItem(Request $request) {

        $json = json_encode(array("ok"));
        $product = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Product")
                ->findOneBy(array('erpCode' => $request->request->get("erp_code")));
        if (!$product)
            exit;

        $idArr = explode(":", $request->request->get("id"));
        $id = (int) $idArr[3];


        $invoice = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $invoiceItem = new InvoiceItem;

        $invoiceItem->setInvoice($invoice);
        $invoiceItem->setProduct($product);
        $invoiceItem->setCode($product->getErpCode());
        $invoiceItem->setQty(1);
        $invoiceItem->setPrice(0);
        $invoiceItem->setFprice(0);
        $invoiceItem->setDiscount(0);
        $invoiceItem->setChk(1);
        $this->flushpersist($invoiceItem);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/invoice/invoice/getitems/{id}")
     */
    public function getservicesAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:InvoiceItem';
        $this->q_and[] = $this->prefix . ".invoice = '" . $id . "'";
        $json = $this->datatable();

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

    /**
     * @Route("/invoice/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Invoice';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => $this->getTranslation("Invoice"), "index" => 'invoice'))
                ->addField(array("name" => $this->getTranslation("To Softone"), "index" => 'reference', 'method' => 'yesno'))
                ->addField(array("name" => $this->getTranslation("Date Time"), 'datetime' => 'Y-m-d H:s:i', "index" => 'created'));

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/invoice/saveSoftone")
     */
    function saveSoftone(Request $request) {
        $vat = 1; //1.24;
        $id = $request->request->get("id");
        $softone = new Softone();
        $object = "PURDOC";
        $invoice = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Invoice")
                ->find($id);
        /*
          $customer = $this->getDoctrine()
          ->getRepository("SoftoneBundle:Customer")
          ->find($order->getCustomer());
         */
        /*
          if ($order->getVat())
          $vatsst = $id > 0 ? $order->getVat()->getVatsts() : $this->getSetting("SoftoneBundle:Order:Vat");
          else
          $vatsst = 1410; //$this->getSetting("SoftoneBundle:Product:Vat");
         */
        $vatsst = 1410;
        /*
          if ($order->getReference() > 0) {
          $data = $softone->delData($object, (int) $order->getReference());
          }
         * 
         */
        $objectArr = array();
        $objectArr[0]["TRDR"] = 9818; //$customer->getReference();
        $objectArr[0]["SERIESNUM"] = $invoice->getId();
        $objectArr[0]["FINCODE"] = $invoice->getInvoice();
        //$objectArr[0]["TRDBRANCH"] = $order->getTrdbranch();
        //$objectArr[0]["PAYMENT"] = $customer->getCustomerPayment() > 0 ? $customer->getCustomerPayment() : 1003;
        //$objectArr[0]["TFPRMS"] = $model->tfprms;
        /*
          if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
          $objectArr[0]["ACNMSK"] = $order->getUser()->getUsername();
          $objectArr[0]["INT01"] = $order->getUser()->getReference();
          }
         */
        $objectArr[0]["SERIES"] = 2062; //$order->getSoftoneStore()->getSeries();
        $objectArr[0]["VATSTS"] = $vatsst; //$this->getSetting("SoftoneBundle:Order:Vat") != '' ? $this->getSetting("SoftoneBundle:Order:Vat") : $customer->getCustomerVatsts();
        $objectArr[0]["COMMENTS"] = ""; //$order->getRemarks(); //$customer->getCustomerPayment() > 0 ? $customer->getCustomerPayment() : 1003; // Mage::app()->getRequest()->getParam('comments');
        $objectArr[0]["REMARKS"] = ""; //$order->getRemarks();
        $objectArr[0]["COMMENTS"] = ""; //$order->getComments();
        //$objectArr[0]["WHOUSE"] = 1101;
        //$objectArr[0]["DISC1PRC"] = 10;   
        $dataOut[$object] = (array) $objectArr;


        $dataOut["ITELINES"] = array();

        $k = 0;
        //print_r($dataOut);
        foreach ($invoice->getItems() as $item) {
            //$dataOut["ITELINES"][] = array("QTY1" => $item->getQty(), "VAT" => $vat, "LINENUM" => $item->getLineval(), "MTRL" => $item->getProduct()->getReference());
            $dataOut["ITELINES"][] = array(
                "VAT" => $vatsst,
                "QTY1" => $item->getQty(),
                "LINENUM" => $k++,
                "MTRL" => $item->getProduct()->getReference(),
                "PRICE" => $item->getPrice() / $vat,
                "LINEVAL" => $item->getFprice() / $vat,
                "DISC1PRC" => 0//$item->getDisc1prc()
            );
        }

        $locateinfo = "MTRL,NAME,PRICE,QTY1,VAT;ITELINES:DISC1PRC,ITELINES:LINEVAL,MTRL,MTRL_ITEM_CODE,MTRL_ITEM_CODE1,MTRL_ITEM_NAME,MTRL_ITEM_NAME1,PRICE,QTY1;SALDOC:BUSUNITS,EXPN,TRDR,MTRL,PRICE,QTY1,VAT";
        //print_r($dataOut);
        file_put_contents("/home2/partsbox/public_html/OrderdatIn.txt", print_r($dataOut, true));
        $out = $softone->setData((array) $dataOut, $object, (int) 0);
        //print_r($out);
        //exit;
        if (@$out->id == 0) {
            $out = $softone->setData((array) $dataOut, $object, (int) 0);
        }
        if (@$out->id == 0) {
            $out = $softone->setData((array) $dataOut, $object, (int) 0);
        }
        if (@$out->id == 0) {
            $out = $softone->setData((array) $dataOut, $object, (int) 0);
        }
        if (@$out->id > 0) {
            /*
              if ($order->getReference() == 0) {
              foreach ($order->getItems() as $item) {
              $product = $item->getProduct();
              if ($product) {
              $reserved = (int) $product->getReserved();
              $reserved += $item->getQty();
              $product->setReserved($reserved);
              $this->flushpersist($product);
              //echo "\n(" . $reserved . ")\n";
              }
              }
              }
             */
            $invoice->setReference($out->id);
            $this->flushpersist($invoice);
        }
        //exit;

        $json = json_encode($out);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
