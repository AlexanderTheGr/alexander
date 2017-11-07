<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Invoice as Invoice;
use SoftoneBundle\Entity\InvoiceItem as InvoiceItem;
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

        $content = $this->content();

        return $this->render('SoftoneBundle:Invoice:view.html.twig', array(
                    'pagename' => 's',
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
     * @Route("/invoice/readInvoiceFile")
     */
    public function readInvoiceFile() {
        $em = $this->getDoctrine()->getManager();
        $file = "/home2/partsbox/public_html/partsbox/web/files/partsboxtsakonas/invoice.csv";
        $availability = false;
        $inv = array();
        if (($handle = fopen($file, "r")) !== FALSE) {
            fgetcsv($handle, 1000000, ";");
            while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
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
                if (!$inv[$invoice->getId()]) {
                    $sql = "delete from  softone_invoice_item where invoice = '" . $invoice->getId() . "'";
                    $em->getConnection()->exec($sql);
                    $inv[$invoice->getId()] = true;
                }
                $data[6] = str_replace("'", "", $data[6]);
                $product = $this->getDoctrine()
                        ->getRepository("SoftoneBundle:Product")
                        ->findOneBy(array('itemCode2' => $data[6]));
                $invoiceItem = new InvoiceItem;
                $invoiceItem->setInvoice($invoice);
                $invoiceItem->setProduct($product);
                $invoiceItem->setCode($product->getErpCode());
                $invoiceItem->setQty($data[9]);
                $invoiceItem->setPrice($data[7]);
                $invoiceItem->setFprice($data[7]*$data[9]);
                $invoiceItem->setDiscount(0);
                $invoiceItem->setChk(1);
                $this->flushpersist($invoiceItem);
            }
        }
        exit;
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
                ->addField(array("name" => $this->getTranslation("Invoice"), "index" => 'invoice'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
