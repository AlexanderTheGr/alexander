<?php

namespace ServicebookBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;

class WorkshopController extends \ServicebookBundle\Controller\SoftoneController {

    var $repository = 'ServicebookBundle:Workshop';

    /**
     * @Route("/servicebook/workshop/servicebook/workshop")
     */
    public function indexAction() {

        return $this->render('ServicebookBundle:Workshop:index.html.twig', array(
                    'pagename' => $this->getTranslation('Προμηθευτές'),
                    'url' => '/servicebook/workshop/getdatatable',
                    'view' => '/servicebook/workshop/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }


    /**
     * @Route("/servicebook/workshop/view/{id}")
     */
    public function viewAction($id) {

        $content = $this->gettabs($id);
        $content = $this->content();
        return $this->render('ServicebookBundle:Workshop:view.html.twig', array(
                    'pagename' => $this->getTranslation('Workshop'),
                    'url' => '/servicebook/workshop/save',
                    'supplierid' => $id,
                    'content' => $content,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/servicebook/workshop/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/servicebook/workshop/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        $fields["code"] = array("label" => $this->getTranslation("Code"));
        $fields["name"] = array("label" => $this->getTranslation("Workshop Name"));

        $forms = $this->getFormLyFields($entity, $fields);

        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/servicebook/workshop/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'ServicebookBundle:Workshop';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => $this->getTranslation("Code"), "index" => 'code'))
                ->addField(array("name" => $this->getTranslation("Name"), "index" => 'name'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }


}
