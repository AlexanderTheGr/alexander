<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class CategoryController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Category';

    /**
     * @Route("/category/category")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Category:index.html.twig', array(
                    'pagename' => 'Categorys',
                    'url' => '/category/getdatatable',
                    'view' => '/category/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/category/view/{id}")
     */
    public function viewAction($id) {

        
        
        $content = $this->gettabs($id);
        $content = $this->content();
        
        return $this->render('SoftoneBundle:Category:view.html.twig', array(
                    'pagename' => 'Category',
                    'url' => '/category/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    //'tabs' => $this->gettabs($id),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/category/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/category/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        //$fields["categoryCode"] = array("label" => "Code");
        $fields["name"] = array("label" => "Name");

        $forms = $this->getFormLyFields($entity, $fields);

        
        if ($id > 0 AND count($entity) > 0) {
            $entity2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Category')
                    ->find($id);  

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "Name", "index" => 'name');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/category/getparent/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }        
        
        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $this->addTab(array("title" => "Categories", "datatables" => $datatables, "form" => '', "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/category/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Category';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                //->addField(array("name" => "Code", "index" => 'categoryCode'))
                ->addField(array("name" => "Name", "index" => 'name'));

        $this->q_and[] = $this->prefix . ".parent = 0";

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
