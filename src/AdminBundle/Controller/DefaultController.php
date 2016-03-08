<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class DefaultController extends Controller {

    /**
     * @Route("/admin/{name}")
     * @Template()
     */
    public function indexAction($name) {
        return array('name' => $name);
    }

    /**
     * @Route("/account/{url}/{appkey}")
     * 
     */
    public function accountAction($url,$appkey) {
        $encoder = new JsonEncoder();
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $account = $this->getDoctrine()
                ->getRepository('AdminBundle:Account')
                ->findByUrl($url);
        $serializer->serialize($account, 'json');
        return new Response(
                $serializer->serialize($account, 'json'), 200, array('Content-Type' => 'application/json')
        );
    }

}
