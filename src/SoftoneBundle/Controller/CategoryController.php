<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Category as Category;
use AppBundle\Controller\Main as Main;

class CategoryController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Category';

    /**
     * @Route("/category/category")
     */
    public function indexAction() {

        return $this->render('SoftoneBundle:Category:index.html.twig', array(
                    'pagename' => 'Categories',
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


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Category;
        }
        $content = $this->gettabs($id);
        $content = $this->content();

        return $this->render('SoftoneBundle:Category:view.html.twig', array(
                    'pagename' => 'Categories:' . $entity->getName(),
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
        $entity = new Category;
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("parent", 0);
        $this->newentity[$this->repository]->setField("weight", 0);
        $out = $this->save();
        $entity = $this->newentity[$this->repository];
        if ($entity->getSortcode() == 0) {
            if ($entity->getParent() == 0)
                $entity->setSortcode($entity->getId() * 10000);
            else
                $entity->setSortcode($entity->getId() . $entity->getParent());
            $this->flushpersist($entity);
        }

        $json = json_encode(array("ok"));
        //$json = json_encode(array("ok", "returnurl" => "/category/view/" . $entity->getId()));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/category/addParent")
     */
    public function addParent(Request $request) {
        $entity = new Category;
        $this->newentity[$this->repository] = $entity;
        $entity->setName($name);
        $idArr = explode(":", $request->request->get("id"));
        $id = (int) $idArr[3];
        $entity->setParent($id);
        $this->initialazeNewEntity($entity);
        $this->flushpersist($entity);
        
        $entity->setSortcode($entity->getParent() . $entity->getId());
        $this->flushpersist($entity);


        $json = json_encode(array("ok", "returnurl" => "/category/view/" . $entity->getId()));
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
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Category;
        }
        //$fields["categoryCode"] = array("label" => "Code");
        $fields["name"] = array("label" => "Name");
        $fields["weight"] = array("label" => "Weight");

        $forms = $this->getFormLyFields($entity, $fields);


        if ($id > 0 AND count($entity) > 0 AND $entity->getParent() == 0) {
            $entity2 = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Category')
                    ->find($id);

            $entity2->setParent("");
            $fields2["parent"] = array("label" => "Name", "className" => "parentcat col-md-12");
            $forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "Name", "index" => 'name');
            //$dtparams[] = array("name" => "Weight", "index" => 'weight');
            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/category/getparent/' . $id;
            $params['view'] = '/category/view';
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($id > 0 AND count($entity) > 0 AND $entity->getParent() == 0) {
            $this->addTab(array("title" => "Categories", "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        }
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
                ->addField(array("name" => "Name", "index" => 'name'))
        //->addField(array("name" => "Weight", "index" => 'weight'))
        ;

        $this->q_and[] = "(" . $this->prefix . ".parent = 0 OR " . $this->prefix . ".parent IS NULL)";

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/category/getparent/{id}")
     */
    public function getparentAction($id) {
        $this->repository = 'SoftoneBundle:Category';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                //->addField(array("name" => "Code", "index" => 'categoryCode'))
                ->addField(array("name" => "Name", "index" => 'name'));

        $this->q_and[] = $this->prefix . ".parent = '" . $id . "'";

        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
