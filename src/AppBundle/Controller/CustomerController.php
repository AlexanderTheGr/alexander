<?php

// src/AppBundle/Controller/customerController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class CustomerController extends Main {

    var $repository = 'AppBundle:Customer';

    /**
     * @Route("/customers/customer")
     */
    public function indexAction() {



        return $this->render('customer/index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/customers/getdatatable',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customers/view/{id}")
     */
    public function viewAction($id) {
        return $this->render('customer/view.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/customers/save/' . $id,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customers/save/{id}")
     */
    public function saveAction($id) {
        $data = $this->base64Request();
        print_r($data);
        return new Response(
                $content, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/customers/gettab")
     */
    public function gettabAction() {
        $this->addTab(array("name" => "General1", "content" => $this->form1(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => "active"));
        $this->addTab(array("name" => "General2", "content" => $this->form2(), "index" => $this->generateRandomString(), 'search' => 'text'));
        $json = $this->tabs();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function gettabs($id) {

        $model = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);


        $formLyFields["customerCode"] = array("label" => "Customer Code");
        $formLyFields["customerName"] = array("label" => "Customer Name");
        $formLyFields["customerAfm"] = array("label" => "Customer AFM");
        $formLyFields["customerAddress"] = array("label" => "Customer Address");
        $formLyFields["customerCity"] = array("label" => "Customer Address");

        $forms1 = $this->getFormLyField($model, $formLyFields);

        $this->addTab(array("title" => "General1", "form" => $forms1, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));

        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/customers/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'AppBundle:Customer';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Name", "index" => 'customerName', 'search' => 'text'))
                ->addField(array("name" => "ΑΦΜ", "index" => 'customerAfm', 'search' => 'text'))
                ->addField(array("name" => "Address", "index" => 'customerAddress', 'search' => 'text'))
                ->addField(array("name" => "Route", "index" => 'route:route'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
