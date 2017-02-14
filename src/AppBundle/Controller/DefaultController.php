<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Setting as Setting;
use AppBundle\Controller\Main as Main;

class DefaultController extends Main {

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
     * @Route("/chat", name="chat")
     */
    public function chat() {
        $users = $this->getDoctrine()
                        ->getRepository("AppBundle:User")->findAll();
        $usersarr = "<select class='form-control' id='user_email' name='user_email'>";
        $usersarr .= "<option value=0>ALL</option>";
        foreach ($users as $user) {
            $usersarr .= "<option value='" . $user->getUsername() . "'>" . $user->getUsername() . "</option>"; //array("value" => (string) $supplier->getReference(), "name" => $supplier->getSupplierName()); // $supplier->getSupplierName();
        }
        $usersarr .= "</select>";
        
        return $this->render('default/chat.html.twig', array(
                    'usersarr' => $usersarr,
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
                    'orderscntbkg' => count($orders) > 0 ? "#ff1100": "#ff9800",
                    'edicnt' => "EDI: " . count($ediorders),
                    'orders' => $ordersHtml,
                    'usersarr' => $usersarr,
                    'ediorders' => $ediordersHtml,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
    /**
     * @Route("/erpprefix", name="erpprefix")
     */
    public function erpprefix() {
        return $this->render('default/alerts.html.twig', array(
                    'erpprefix' => $this->getSetting("AppBundle:Erp:erpprefix") ?  $this->getSetting("AppBundle:Erp:erp") : $this->setSetting("AppBundle:Erp:erp", ""),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));        
        //return  $this->getSetting("AppBundle:Erp:erpprefix") ?  $this->getSetting("AppBundle:Erp:erp") : $this->setSetting("AppBundle:Erp:erp", "");
    }
    function getSetting($path) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Setting');
        $setting = $repository->findOneBy(
                array('path' => $path)
        );
        if (!$setting) {
            $dt = new \DateTime("now");
            $setting = new Setting;
            $setting->setTs($dt);
            $setting->setCreated($dt);
            $setting->setModified($dt);
            $setting->setPath($path);
            $this->flushpersist($setting);
        }
        return $setting->getValue();
    }

    function setSetting($path, $value) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Setting');
        $setting = $repository->findOneBy(
                array('path' => $path)
        );
        if (!$setting) {
            $dt = new \DateTime("now");
            $setting = new Setting;
            $setting->setTs($dt);
            $setting->setCreated($dt);
            $setting->setModified($dt);
            $setting->setPath($path);
            $this->flushpersist($setting);
        }
        $setting->setValue($value);
        $this->flushpersist($setting);
        return $setting->getValue();
    }    
}
