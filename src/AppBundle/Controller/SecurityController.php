<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class SecurityController extends Main {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {
        return $this->render('AppBundle:Security:login.html.twig', array(
                    'pagename' => 'Login',
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

}
