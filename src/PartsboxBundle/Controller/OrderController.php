<?php

// src/PartsboxBundle/Controller/LuckyController.php

namespace PartsboxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class OrderController extends Main {

    /**
     * @Route("/orders/order")
     */
    public function indexAction() {
        return $this->render('elements/datatable.twig', array(
                    'pagename' => 'Orders',
                    'url'=>'/orders/getdatatable',
                    'ctrl'=>'ctrlOrder',
                    'app'=>'orderApp',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/orders/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'PartsboxBundle:Order';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Code", "index" => 'customerName'))
                ->addField(array("name" => "Price", "index" => 'insdate'))                
                ;
        
        $json = $this->datatable();
        
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
