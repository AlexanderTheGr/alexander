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
        $this->newentity[$this->repository] = $entity;
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
                //echo $df[0] . ":" . $df[1]." ".$df[3]."\n";
            }
            if ((int) $df[3] == 0) {
                $entities[$df[0] . ":" . $df[1]] = $this->newentity[$df[0] . ":" . $df[1]];
            }

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
                ->addField(array("name" => "Username", "index" => 'username'))
        ;
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * 
     * 
     * @Route("/user/chatprocess")
     */
    public function chatprocessAction() {

        $function = $_POST['function'];
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $log = array();

        switch ($function) {

            case('getState'):
                if (file_exists('chat.txt')) {
                    $lines = file('chat.txt');
                }
                $log['state'] = count($lines);
                foreach ((array) $lines as $line_num => $line) {
                    if ($line_num >= $state) {
                        if (strpos($line, 'from="' . $user->getUsername() . '"')) {
                            $line1 = str_replace("chatpossition", "chat-right", $line);
                            $text[] = str_replace("\n", "", $line1);
                        } elseif (strpos($line, 'to=""')) {
                            $line1 = str_replace("chatpossition", "chat-left", $line);
                            $text[] = str_replace("\n", "", $line1);
                        }
                        if (strpos($line, 'to="' . $user->getUsername() . '"')) {
                            $line1 = str_replace("chatpossition", "chat-left", $line);
                            $line1 = str_replace("chat-body", "chat-body style-accent", $line1);
                            $text[] = str_replace("\n", "", $line1);
                        }
                    }
                }

                $log['text'] = $text;
                break;

            case('update'):
                $state = $_POST['state'];
                if (file_exists('chat.txt')) {
                    $lines = file('chat.txt');
                }
                $count = count($lines);
                if ($state == $count) {
                    $log['state'] = $state;
                    $log['text'] = false;
                } else {
                    $text = array();
                    $log['state'] = $state + count($lines) - $state;
                    foreach ($lines as $line_num => $line) {
                        if ($line_num >= $state) {

                            if (strpos($line, 'from="' . $user->getUsername() . '"')) {
                                $line1 = str_replace("chatpossition", "chat-right", $line);
                                $text[] = str_replace("\n", "", $line1);
                            } elseif (strpos($line, 'to=""')) {
                                $line1 = str_replace("chatpossition", "chat-left", $line);
                                $text[] = str_replace("\n", "", $line1);
                            }
                            if (strpos($line, 'to="' . $user->getUsername() . '"')) {
                                $line1 = str_replace("chatpossition", "chat-left", $line);
                                $line1 = str_replace("chat-body", "chat-body style-accent", $line1);
                                $text[] = str_replace("\n", "", $line1);
                            }
                        }
                    }

                    $log['text'] = $text;
                }
                break;

            case('send'):
                $from = htmlentities(strip_tags($_POST['from']));
                $to = htmlentities(strip_tags($_POST['to']));
                $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                $message = htmlentities(strip_tags($_POST['message']));
                if (($message) != "\n") {

                    if (preg_match($reg_exUrl, $message, $url)) {
                        $message = preg_replace($reg_exUrl, '<a href="' . $url[0] . '" target="_blank">' . $url[0] . '</a>', $message);
                    }
                    fwrite(fopen('chat.txt', 'a'), $this->chatLine($from, $to, $message) . "\n");
                }
                break;
        }

        $json = json_encode($log);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function chatLine($from, $to, $message) {
        $message = str_replace("\n", " ", $message);
        return '<li from="' . $from . '"  to="' . $to . '" class="chatpossition"><div class="chat"><div class="chat-avatar"><img class="img-circle" src="/assets/img/avatar1.jpg?1403934956" alt="" /></div><div class="chat-body"><strong>' . $from . ' -> <i>' . $to . '</i></strong>' . $message . '<small>' . date("d/m/Y H:i:s") . '</small></div></div><!--end .chat --></li>';
    }

}
