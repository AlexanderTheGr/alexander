<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
                    'pagename' => '',
                    'alerts' => '',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
    
    /**
     * @Route("/alerts", name="alerts")
     */
    public function alerts() {
        $alerts = 0;
        $orders = $this->getDoctrine()
                ->getRepository("SoftoneBundle:Order")->findBy(array("isnew"=>1));
        $alerts += count($orders);
        
        
        $ordersHtml = "<ul>";
        foreach($orders as $order) {
            $ordersHtml .= "<li><a href='/order/view/".$order->getId()."'>".$order->getFincode()." ".$order->getCustomerName()."</a></li>";
        }
        $ordersHtml .= "</ul>";
        
        return $this->render('default/alerts.html.twig', array(
                    'pagename' => '',
                    'alerts' => count($orders),
                    'orders' => $ordersHtml,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

}
