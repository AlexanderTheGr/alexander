<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
            $jsonarr["returnurl"] = "/invoice/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
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
            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            //$dtparams[] = array("name" => "Code", "index" => 'code');
            $dtparams[] = array("name" => $this->getTranslation("Product Name"), "function" => 'getForOrderItemsTitle', 'search' => 'text');
            $dtparams[] = array("name" => $this->getTranslation("Product Code"), "index" => 'product:erpCode');
            $dtparams[] = array("name" => $this->getTranslation("Qty"), "input" => "text", "index" => 'qty');
            //$dtparams[] = array("name" => "Title", "index" => 'km');
            //$dtparams[] = array("name" => "Price", "index" => 'storeWholeSalePrice');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/invoice/invoice/getitems/' . $id;
            $params['view'] = '/invoice/invoice/item/view';
            $params['viewnew'] = '/invoice/invoice/item/view/new/' . $id;

            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }

        $this->addTab(array("title" => $this->getTranslation("General"), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => $this->getTranslation("Items"), "datatables" => $datatables, "form" => '', "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => false);
        } 
        foreach ((array) $tabs as $tab) {
            $this->addTab($tab);
        }        
        $json = $this->tabs();
        return $json;
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
