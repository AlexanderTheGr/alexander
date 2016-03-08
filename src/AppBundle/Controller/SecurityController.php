<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Main {

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {
        $this->install();
        $login = $request->request->get("LoginForm");
        $session = $request->getSession();
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();        
        return $this->render('AppBundle:Security:login.html.twig', array(
                    'pagename' => 'Login',
                    'last_username' => $lastUsername,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/login_check", name="login_check")
     */    
    public function loginCheckAction(Request $request) {
        
    
    }
    /**
     * @Route("/login_failure", name="login_failure")
     */    
    public function loginFailureAction(Request $request) {
    
    } 
    /**
     * @Route("/access_denied", name="access_denied")
     */    
    public function accessDeniedAction(Request $request) {
    
    }    
    /**
     * @Route("/logout", name="logout")
     */    
    public function logoutAction(Request $request) {
    
    }        
}
