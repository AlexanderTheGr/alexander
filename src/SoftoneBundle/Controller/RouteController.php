<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;


class RouteController extends \SoftoneBundle\Controller\SoftoneController  {

    var $repository = 'SoftoneBundle:Route';
    var $newentity = '';
    /**
     * @Route("/route/route")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Route:index.html.twig', array(
                    'pagename' => 'Routes',
                    'url' => '/route/getdatatable',
                    'view' => '/route/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/route/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();

        $content = $this->gettabs($id);
        //$content = $this->getoffcanvases($id);

        $content = $this->content();

        return $this->render('SoftoneBundle:Route:view.html.twig', array(
                    'pagename' => 's',
                    'url' => '/route/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/route/save")
     */
    public function saveAction() {
        $entity = new \SoftoneBundle\Entity\Route;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("status", 1);
        $out = $this->save();
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/route/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/route/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new \SoftoneBundle\Entity\Route;
            $this->newentity[$this->repository] = $entity;
        }

        $fields["route"] = array("label" => "Route");
        //$fields["routeName"] = array("label" => "Name");

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/route/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Route';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Route", "index" => 'route'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
