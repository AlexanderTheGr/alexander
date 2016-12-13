<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class CustomergroupController extends \SoftoneBundle\Controller\SoftoneController  {

    var $repository = 'SoftoneBundle:Customergroup';

    /**
     * @Route("/customergroup/customergroup")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Customergroup:index.html.twig', array(
                    'pagename' => 'Customergroups',
                    'url' => '/customergroup/getdatatable',
                    'view' => '/customergroup/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customergroup/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('SoftoneBundle:Customergroup:view.html.twig', array(
                    'pagename' => 'Customergroup',
                    'url' => '/customergroup/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customergroup/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/customergroup/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["title"] = array("label" => "Title");
        $fields["basePrice"] = array("label" => "Price");

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/customergroup/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Customergroup';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Title", "index" => 'title'))
                ->addField(array("name" => "Price", "index" => 'basePrice'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
