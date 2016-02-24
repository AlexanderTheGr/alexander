<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class UserController extends Main {

    var $repository = 'AppBundle:User';

    /**
     * @Route("/users/user")
     */
    public function indexAction() {

        return $this->render('AppBundle:User:index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/user/getdatatable',
                    'view' => '/user/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    

    /**
     * @Route("/user/view/{id}")
     */    
    public function viewAction($id) {
        $datatables = array();
        return $this->render('AppBundle:User:view.html.twig', array(
                    'pagename' => 'Product',
                    'url' => '/user/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id, $datatables),
                    'datatables' => $datatables,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }    

    
     /**
     * @Route("/user/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    
    public function gettabs($id, $datatables) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $fields["email"] = array("label" => "Email");
        //$fields["itemPricew01"] = array("label" => "Price Name");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));

        $json = $this->tabs();
        return $json;
    }      
    /**
     * 
     * 
     * @Route("/user/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Email", "index" => 'email'))
                ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }    

}
