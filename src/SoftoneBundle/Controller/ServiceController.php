<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use AppBundle\Controller\Main as Main;

class ServiceController extends Main{

    var $repository = 'SoftoneBundle:Pcategory';

    /**
     * @Route("/service/service")
     */
    public function indexAction() {

        

        $content = $this->gettabs();
        return $this->render('SoftoneBundle:Category:view.html.twig', array(
                    'pagename' => 'Service',
                    'url' => '/service/save',
                    'view' => '',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
    public function gettabs() {
        $entity = new Pcategory;
                
        $fields["itecategoryName"] = array("label" => "Original",'type' => "textarea");

        $forms = $this->getFormLyFields($entity, $fields);
        
        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
   
        $json = $this->tabs();
        return $json;
    }
    /**
     * @Route("/service/save")
     */
    public function save() {
        $json = json_decode($this->formLybase64());
        
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );        
        
    }    

}
