<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class AppController extends Main {

    
    /**
    * @Route("/app/install")
    */
    public function installAction(Request $request) {
        // replace this example code with whatever you need
        $this->install();
    }    

}
