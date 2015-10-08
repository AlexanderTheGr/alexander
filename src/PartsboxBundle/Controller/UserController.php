<?php

// src/PartsboxBundle/Controller/LuckyController.php

namespace PartsboxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PartsboxBundle\Controller\Main as Main;

class UserController extends Main {

    /**
     * @Route("/user/index")
     */
    public function indexAction() {
        return $this->render('user/index.html.twig', array(
                    'pagename' => 'asss',
                    'url'=>'/user/getusers',
                    'ctrl'=>'ctrlProduct',
                    'app'=>'myApp',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/user/getusers")
     */
    public function getusersAction(Request $request) {
        $this->repository = 'PartsboxBundle:Product';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Code", "index" => 'erpCode'))
                ->addField(array("name" => "Price", "index" => 'itemPricew01'));
        
        $json = $this->getData();
        
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
