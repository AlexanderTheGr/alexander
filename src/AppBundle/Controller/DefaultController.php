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


        $users = $this->getDoctrine()
                        ->getRepository("AppBundle:User")->findAll();
        $usersarr = "<select class='form-control' id='user_email' name='user_email'>";
        $usersarr .= "<option value=0>ALL</option>";
        foreach ($users as $user) {
            $usersarr .= "<option value='" . $user->getUsername() . "'>" . $user->getUsername() . "</option>"; //array("value" => (string) $supplier->getReference(), "name" => $supplier->getSupplierName()); // $supplier->getSupplierName();
        }
        $usersarr .= "</select>";


        $orders = $this->getDoctrine()
                        ->getRepository("SoftoneBundle:Order")->findBy(array("isnew" => 1));
        $alerts += count($orders);




        $ordersHtml = "<ul style='overflow: auto; max-height: 400px;' class='animation-expand'>";
        foreach ($orders as $order) {
            $ordersHtml .= "<li class='' style='list-style:none'><a href='/order/view/" . $order->getId() . "'>" . $order->getFincode() . " " . $order->getCustomerName() . "</a></li>";
        }
        $ordersHtml .= "</ul>";

        $ediorders = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiOrder')->findBy(array("reference" => ''));

        $ediordersHtml = "<ul style='overflow: auto; max-height: 400px;' class='animation-expand'>";
        foreach ($ediorders as $ediorder) {
            $ediordersHtml .= "<li class='' style='list-style:none'><a href='/edi/edi/order/view/" . $ediorder->getId() . "'>" . $ediorder->getRemarks() . "</a></li>";
        }
        $ediordersHtml .= "</ul>";

        return $this->render('default/alerts.html.twig', array(
                    'pagename' => '',
                    'orderscnt' => "Orders: " . count($orders),
                    'edicnt' => "EDI: " . count($ediorders),
                    'orders' => $ordersHtml,
                    'usersarr' => $usersarr,
                    'ediorders' => $ediordersHtml,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

}
