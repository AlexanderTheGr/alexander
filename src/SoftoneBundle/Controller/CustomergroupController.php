<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

use SoftoneBundle\Entity\Customergroup as Customergroup;

class CustomergroupController extends \SoftoneBundle\Controller\SoftoneController  {

    var $repository = 'SoftoneBundle:Customergroup';
    var $newentity = array();

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

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->content();


        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => 's',
                    'url' => '/customergroup/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
        
    }

    /**
     * @Route("/customergroup/save")
     */
    public function saveAction() {
        $entity = new Customergroup;

        //$this->repository = "SoftoneBundle:Customer";
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);        
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

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Customergroup;
            $this->newentity[$this->repository] = $entity;
        }
        
        $fields["title"] = array("label" => "Title");
        $fields["basePrice"] = array("label" => "Price");

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $this->addTab(array("title" => "Rules", "content" => $this->getRules($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        
        
        $json = $this->tabs();
        return $json;
    }

    function getRules($entity) {
        $total = 0;

        
        $suppliers = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")->findAll();
        $supplierArr = array();
        foreach($suppliers as $supplier) {
            $supplierArr[$supplier->getId()] = $supplier->getTitle();            
        }
        $supplierjson = json_encode($supplierArr);
        $response = $this->get('twig')->render('SoftoneBundle:Customergroup:rules.html.twig', array('supplierjson' => $supplierjson));
        return str_replace("\n", "", htmlentities($response));
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
