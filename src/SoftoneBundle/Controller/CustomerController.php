<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\Customer as Customer;

class CustomerController extends \SoftoneBundle\Controller\SoftoneController {

    var $repository = 'SoftoneBundle:Customer';
    var $newentity = array();

    /**
     * @Route("/customer/customer")
     */
    public function indexAction() {
        return $this->render('SoftoneBundle:Customer:index.html.twig', array(
                    'pagename' => 'Customers',
                    'url' => '/customer/getdatatable',
                    'view' => '/customer/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customer/autocompletesearch")
     */
    public function autocompletesearch() {
        $json = json_encode(array("ok"));

        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
                        "SELECT p.id, p.customerName,p.customerAfm,p.customerCode FROM " . $this->repository . " " . $this->prefix . " where p.customerName LIKE '%" . $_GET["term"] . "%' OR p.customerAfm LIKE '%" . $_GET["term"] . "%' OR p.customerCode LIKE '%" . $_GET["term"] . "%'"
                )
                ->setMaxResults(20)
                ->setFirstResult(0);
        $datas = $query->getResult();
        $out = array();
        foreach ((array) $datas as $data) {
            //print_r($data);
            //$data["flat_data"] = "";
            $json = array();
            $json["id"] = $data["id"];
            $json["value"] = $data["customerName"] . " (" . $data["customerAfm"] . " - " . $data["customerCode"] . ")";
            $json["label"] = $data["customerName"] . " (" . $data["customerAfm"] . " - " . $data["customerCode"] . ")";
            $out[] = $json;
        }


        return new Response(
                json_encode($out), 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/customer/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->content();


        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => 's',
                    'url' => '/customer/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/customer/save")
     */
    public function saveAction() {
        $entity = new Customer;
        
        //$this->repository = "SoftoneBundle:Customer";
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);
        $this->newentity[$this->repository]->setField("status", 1);
        $this->newentity[$this->repository]->setField("reference", 1);
        $this->newentity[$this->repository]->setField("group", 1);
        $out = $this->save();
        
        $jsonarr = array();
        if ($this->newentity[$this->repository]->getId()) {
            $this->newentity[$this->repository]->toSoftone();
            $jsonarr["returnurl"] = "/customer/view/" . $this->newentity[$this->repository]->getId();
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/customer/gettab")
     */
    public function gettabs($id) {

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Customer;
            $entity->setField("customerCode", "123456");
            $this->newentity[$this->repository] = $entity;
            
        }


        $fields["customerCode"] = array("label" => "Customer Code");
        $fields["customerName"] = array("label" => "Customer Name");
        $fields["customerAfm"] = array("label" => "Customer Afm");
        $fields["customerAddress"] = array("label" => "Customer Address");
        $fields["customerCity"] = array("label" => "Customer City");

        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General1", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/customer/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'SoftoneBundle:Customer';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Name", "index" => 'customerName', 'search' => 'text'))
                ->addField(array("name" => "ΑΦΜ", "index" => 'customerAfm', 'search' => 'text'))
                ->addField(array("name" => "Address", "index" => 'customerAddress', 'search' => 'text'))
                ->addField(array("name" => "Route", "index" => 'route:route'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function retrieveCustomer() {
        $where = '';
        $params["softone_object"] = 'customer';
        $params["repository"] = 'SoftoneBundle:Customer';
        $params["softone_table"] = 'TRDR';
        $params["table"] = 'softone_customer';
        $params["object"] = 'SoftoneBundle\Entity\Customer';
        $params["filter"] = '';
        $params["filter"] = 'WHERE M.SODTYPE=13 ' . $where;
        $params["relation"] = array();
        $params["extra"] = array();
        $params["extrafunction"] = array();
        $this->setSetting("SoftoneBundle:Customer:retrieveCustomer", serialize($params));

        $params = unserialize($this->getSetting("SoftoneBundle:Customer:retrieveCustomer"));
        $this->retrieve($params);
    }

    /**
     * @Route("/customer/retrieve")
     */
    function retrieveSoftoneData($params = array()) {

        $this->retrieveCustomer();


        $params = array("softone_object" => "CUSTOMER", "eav_model" => "customer", "model" => "Customer", "list" => "monitor");
        set_time_limit(100000);
        ini_set('memory_limit', '2256M');
        $softone = new Softone();
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata('SoftoneBundle\Entity\Customer')->getFieldNames();
        $date = "2016-02-01";
        $filters = "CUSTOMER.UPDDATE=" . $date . "&CUSTOMER.UPDDATE_TO=" . date("Y-m-d");
        $datas = $softone->retrieveData($params["softone_object"], $params["list"], $filters);

        foreach ($datas as $data) {
            $data = (array) $data;
            $zoominfo = $data["zoominfo"];
            $info = explode(";", $zoominfo);

            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->findOneBy(array("reference" => (int) $info[1]));
            if (@$entity->id == 0) {
                $entity = new Customer();
                $dt = new \DateTime("now");
                $entity->setTs($dt);
                $entity->setField("reference", (int) $info[1]);
                //$entity->setCustomerInsdate($dt);
                //$entity->setCustomerUpddate($dt);
                $entity->setCreated($dt);
                $entity->setModified($dt);
            }
            $this->flushpersist($entity);
            $q = array();

            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($identifier)] = addslashes($val);
                $ad = strtolower(str_replace(strtolower($params["softone_object"]) . "_", "", $identifier));
                $baz = strtolower($params["softone_object"]) . ucwords(str_replace("_", " ", $ad));
                //echo $baz."<BR>";
                if (in_array($baz, $fields)) {
                    $q[] = "`" . strtolower($identifier) . "` = '" . addslashes($val) . "'";
                    //$entity->setField($baz, $val);
                }
            }

            @$entity_id = (int) $entity->id;
            if (@$entity_id > 0) {

                $sql = "update softone_customer set " . implode(",", $q) . " where id = '" . $entity_id . "'";
                //echo $sql."<BR>";
                $em->getConnection()->exec($sql);
            }
            //break;
        }
        $datas = $softone->getCustomerAddresses();
        $sql = "truncate softone_customeraddress";
        $em->getConnection()->exec($sql);
        $fields = $em->getClassMetadata('SoftoneBundle\Entity\Customeraddress')->getFieldNames();
        //print_r($datas);
        if (@$datas->data)
            foreach ($datas->data as $data) {
                $data = (array) $data;
                $customer = $this->getDoctrine()
                        ->getRepository($this->repository)
                        ->findOneBy(array("reference" => (int) $data["TRDR"]));

                $entity = new \SoftoneBundle\Entity\Customeraddress();
                $entity->setCustomer($customer);
                $entity->setReference($data["TRDR"]);
                $this->flushpersist($entity);
                $q = array();
                foreach ($data as $identifier => $val) {
                    if (in_array(strtolower($identifier), $fields)) {
                        $q[] = "`" . strtolower($identifier) . "` = '" . addslashes($val) . "'";
                        //$entity->setField($baz, $val);
                    }
                }
                @$entity_id = (int) $entity->id;
                $sql = "update softone_customeraddress set " . implode(",", $q) . " where id = '" . $entity_id . "'";
                $em->getConnection()->exec($sql);
                //echo $sql . "<BR>";
            }
        exit;
    }

}
