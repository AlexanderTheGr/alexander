<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\Eltrekaedi;
use AppBundle\Controller\Main as Main;

class EltrekaOrderController extends Main {

    var $repository = 'EdiBundle:EltrekaediOrder';

    /**
     * @Route("/edi/eltreka/order")
     */
    public function indexAction() {
        
        $buttons = array();
        $buttons[] = array("label"=>'Get PartMaster','position'=>'right','class'=>'btn-success');        
        
        return $this->render('EdiBundle:Eltreka:index.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/order/getdatatable',
                    'view' => '/edi/eltreka/order/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/order/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('EdiBundle:Eltreka:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/order/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/order/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }


    /**
     * @Route("/edi/eltreka/gettab")
     */
    public function gettabs($id) {

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $buttons = array();
        $buttons[] = array("label"=>'Get PartMaster','position'=>'right','class'=>'btn-success');
        
        $fields["partno"] = array("label" => "Part No");
        $fields["description"] = array("label" => "Description");
        $fields["supplierdescr"] = array("label" => "Supplier");
        $fields["factorypartno"] = array("label" => "Factorypart Ni");
        $fields["wholeprice"] = array("label" => "Wholeprice");
        $fields["retailprice"] = array("label" => "Retailprice");
        

        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/edi/eltreka/order/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        //$this->repository = 'EdiBundle:Eltrekaedi';
        $this->addField(array("name" => "ID", "index" => 'id'))


        ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
