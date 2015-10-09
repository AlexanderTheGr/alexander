<?php

namespace PartsboxBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class PageLoadListener extends controller {

    private $securityContext;
    protected $container;
    protected $query;

    public function __construct(SecurityContext $context, $container, array $query = array()) {
        $this->securityContext = $context;
        $this->container = $container;
        $this->query = $query;
    }

    public function onKernelRequest(GetResponseEvent $event) {
        //if you are passing through any data
        $request = $event->getRequest();
        //if you need to update the session data
        $session = $request->getSession();
        //Whatever else you need to do...
    }

}