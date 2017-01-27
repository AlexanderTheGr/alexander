<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use AppBundle\Entity\User as User;

class UserController extends Main {

    var $repository = 'AppBundle:User';

    /**
     * @Route("/users/user")
     */
    public function indexAction() {

        return $this->render('AppBundle:User:index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/user/getdatatable',
                    'view' => '/user/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/user/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();


        return $this->render('AppBundle:User:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/user/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/user/save")
     */
    public function saveAction() {
        $entity = new User;
        $this->initialazeNewEntity($entity);
        //$this->newentity[$this->repository]->setField("status", 1);
        //$this->newentity[$this->repository]->setField("route", 0);
        $out = $this->save();
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $jsonarr["returnurl"] = "/user/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function save() {
        $data = $this->formLybase64();
        $dt = new \DateTime("now");
        $entities = array();
        foreach ($data as $key => $val) {
            $df = explode(":", $key);
            if (!@$entities[$df[0] . ":" . $df[1]]) {
                $entities[$df[0] . ":" . $df[1]] = $this->getDoctrine()
                        ->getRepository($df[0] . ":" . $df[1])
                        ->find($df[3]);
            }
            if ($df[3] == 0) {
                $entities[$df[0] . ":" . $df[1]] = $this->newentity[$df[0] . ":" . $df[1]];
            }
            echo $df[0] . ":" . $df[1];
            $type = $entities[$df[0] . ":" . $df[1]]->gettype($df[2]);
            if ($type == 'object') {
                $obj = $entities[$df[0] . ":" . $df[1]]->getField($df[2]);
                $repository = $entities[$df[0] . ":" . $df[1]]->getRepositories($df[2]);
                $entity = $this->getDoctrine()
                        ->getRepository($repository)
                        ->find($val);
                $entities[$df[0] . ":" . $df[1]]->setField($df[2], $entity);
            } else {
                if ($df[2] == 'password') {
                    if ($val) {
                        $pass = $this->getSaltCode($val, $entities[$df[0] . ":" . $df[1]]);
                        $entities[$df[0] . ":" . $df[1]]->setField($df[2], $pass);
                    }
                } else {
                    $entities[$df[0] . ":" . $df[1]]->setField($df[2], $val);
                }
            }
        }
        foreach ($entities as $key => $entity) {

            $entity->setModified($dt);
            $this->flushpersist($entity);
            $out[$key] = $entity->getId();
        }
        return $out;
    }

    function getSaltCode($val, $entinty) {
        $encodeFactory = $this->container->get('security.encoder_factory');
        $encoder = $encodeFactory->getEncoder($entinty);
        return $encoder->encodePassword($val, $entinty->getSalt());
    }

    public function gettabs($id) {
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new User;
            $this->newentity[$this->repository] = $entity;
        }

        $entity->setPassword('');
        $fields["email"] = array("label" => "Email");
        $fields["username"] = array("label" => "Username");
        $fields["password"] = array("label" => "Password", 'required' => 'no');
        $fields["softoneStore"] = array("label" => "Store", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Store', 'name' => 'title', 'value' => 'id'));
        //$fields["itemPricew01"] = array("label" => "Price Name");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", "datatables" => array(), "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));

        $json = $this->tabs();
        return $json;
    }

    /**
     * 
     * 
     * @Route("/user/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Email", "index" => 'email'))
        ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
