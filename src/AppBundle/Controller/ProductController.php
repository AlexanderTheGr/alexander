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
        return $this->render('elements/datatable.twig', array(
                    'pagename' => 'Products',
                    'url'=>'/product/getdatatable',
                    'ctrl'=>'ctrlProduct',
                    'app'=>'productApp',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/product/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'AppBundle:Product';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Code", "index" => 'erpCode'))
                ->addField(array("name" => "Price", "index" => 'itemPricew01'));
        
        $json = $this->datatable();
        
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
