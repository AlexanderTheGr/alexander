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
                    'view' => '/customers/view',
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
                    'url' => '/customers/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customers/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }


    /**
     * @Route("/customers/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["customerCode"] = array("label" => "Customer Code");
        $fields["customerName"] = array("label" => "Customer Name");
        $fields["customerAfm"] = array("label" => "Customer Afm");
        $fields["customerAddress"] = array("label" => "Customer Address");
        $fields["customerCity"] = array("label" => "Customer City");

        $forms1 = $this->getFormLyFields($entity, $fields);
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
