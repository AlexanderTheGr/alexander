<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Category as Category;
use AppBundle\Controller\Main as Main;

class ServiceController extends Main{

    var $repository = 'SoftoneBundle:Category';

    /**
     * @Route("/service/service")
     */
    public function indexAction() {

        

        $content = $this->gettabs();
        return $this->render('SoftoneBundle:Category:view.html.twig', array(
                    'pagename' => 'Service',
                    'url' => '',
                    'view' => '',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
    public function gettabs() {




        $this->addTab(array("title" => "General", "form" => "", "content" => 'aaaa', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
   
        $json = $this->tabs();
        return $json;
    }

}
