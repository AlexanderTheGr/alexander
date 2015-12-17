<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\EltrekaediOrder as EltrekaediOrder;
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
        $datatables[] = $this->tabDatatable($params);


        return $this->render('EdiBundle:Eltreka:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/order/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id, $datatables),      
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/order/save")
     */
    public function savection() {
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

    protected function gettabs($id, $datatables) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new EltrekaediOrder;
            $this->newentity[$this->repository] = $entity;
        }

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');
        $fields["comments"] = array("label" => "Comments");

        
        $offcanvases[] = array('id'=>'asdf',"body"=>'sss');
        
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General",'offcanvases' => $offcanvases, 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($entity->getId()) {
            //$this->addTab(array("title" => "Search", "datatables" => array(), "form" => '', "content" => $this->getTabContentSearch(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
            $this->addTab(array("title" => "Items",  "datatables" => $datatables, "form" => '', "content" => $this->getTabContentSearch(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => false));
        }

        $json = $this->tabs();
        return $json;
    }

    function getTabContentSearch() {
        $response = $this->get('twig')->render('EdiBundle:Eltreka:eltrekaediordersearch.html.twig', array());
        return str_replace("\n", "", htmlentities($response));
    }

    //fororder
    /**
     * @Route("/edi/eltreka/order/fororder/")
     */
    public function fororderAction() {
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Eltreka:index.html_1.twig', array(
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
     * @Route("/edi/eltreka/order/getitems/{id}")
     */
    public function getitemsAction($id) {
        $session = new Session();
        foreach ($session->get('params') as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:EltrekaediOrderItem';
        $this->q_and[] = $this->prefix . ".eltrekaediorder = " . $id;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        //$this->repository = 'EdiBundle:Eltrekaedi';
        $this->addField(array("name" => "ID", "index" => 'id'))


        ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
