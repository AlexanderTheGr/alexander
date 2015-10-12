<?php
namespace PartsboxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class OrderController extends Main {

    var $repository = 'PartsboxBundle:Order';

    /**
     * @Route("/order/order")
     */
    public function indexAction() {

        return $this->render('order/index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/order/getdatatable',
                    'view' => '/order/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/order/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('order/view.html.twig', array(
                    'pagename' => 'Order',
                    'url' => '/order/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/order/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/order/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["fincode"] = array("label" => "Erp Code");
        $fields["customerName"] = array("label" => "Price Name");

        $forms = $this->getFormLyFields($entity, $fields);
        
        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Παραστατικό", "index" => 'fincode'))
                ->addField(array("name" => "Customer Name", "index" => 'customerName'))
                ->addField(array("name" => "Πωλητής", "index" => 'user:email'))
                ->addField(array("name" => "Δρομολόγιο", "index" => 'route:route'))
                ->addField(array("name" => "Παραγγελία", "index" => 'reference','method'=>'yesno'))
                ->addField(array("name" => "Προσφορά", "index" => 'noorder','method'=>'yesno'))
                ->addField(array("name" => "Ημιτελής", "index" => 'id',"method"=>"imitelis","type"=>"select"))
                ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    
    function imitelisMethod($value) {
        return "YES";
    }
    
}
