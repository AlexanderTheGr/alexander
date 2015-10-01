<?php

// src/AppBundle/Controller/LuckyController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class ProductController extends Main {

    /**
     * @Route("/product/product")
     */
    public function indexAction() {
        return $this->render('product/index.html.twig', array(
                    'pagename' => 'Products',
                    'url' => '/product/getdatatable',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/product/view/{id}")
     */
    public function viewAction($id) {
        return $this->render('product/view.html.twig', array(
                    'pagename' => 'Products',
                    'url' => '/product/gettab',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/product/gettab")
     */
    public function gettabAction(Request $request) {
        $this->repository = 'AppBundle:Product';

        $this->addTab(array("name" => "General1", "content" => $this->form1(), "index" => $this->generateRandomString(), 'search' => 'text', "active" => "active"));
        $this->addTab(array("name" => "General2", "content" => $this->form2(), "index" => $this->generateRandomString(), 'search' => 'text'));

        $json = $this->tabs();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'AppBundle:Product';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Code", "index" => 'erpCode'))
                ->addField(array("name" => "Price", "index" => 'itemPricew01'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
