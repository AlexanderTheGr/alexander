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

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $pagename = '';
        if ($entity) {
            $pagename = $entity->getCustomerName();
        }
        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => $pagename,
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
            if ($this->newentity[$this->repository]->getReference() > 0) {
                $customerCode = (int) $this->getSetting("SoftoneBundle:Customer:customerCode");
                $customerCode++;
                $this->setSetting("SoftoneBundle:Customer:customerCode", $customerCode);
            }
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
            $customerCode = (int) $this->getSetting("SoftoneBundle:Customer:customerCode");
            $entity->setField("customerCode", str_pad($customerCode, 7, "0", STR_PAD_LEFT));
            $this->newentity[$this->repository] = $entity;
            $entity->setCustomerVatsts(1);
            $entity->setPriceField("itemPricer");
            $code = $this->getSetting("SoftoneBundle:Customer:CodeIncrement");
        }
        $vats = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Vat')->findAll();
        $itemMtrsup = array();
        foreach ($vats as $vat) {
            $vatsts[] = array("value" => (string) $vat->getId(), "name" => $vat->getVat()); // $supplier->getSupplierName();
        }

        $fields["customerCode"] = array("label" => "Κωδικός", "className" => "col-md-6", "required" => true);
        $fields["customerName"] = array("label" => "Επωνυμία", "className" => "col-md-6", "required" => true);
        $fields["customerAfm"] = array("label" => "ΑΦΜ", "className" => "col-md-6", "required" => true);
        $fields["customerEmail"] = array("label" => "Email", "className" => "col-md-6", "required" => false);
        $fields["customerAddress"] = array("label" => "Customer Address", "className" => "col-md-6", "required" => false);
        $fields["customerCity"] = array("label" => "Customer City", "className" => "col-md-6", "required" => false);
        $fields["customerPhone1"] = array("label" => "Τηλέφωνο", "required" => false);

        $fields["customergroup"] = array("label" => "Group", "className" => "col-md-6", 'type' => "select", "required" => true, 'datasource' => array('repository' => 'SoftoneBundle:Customergroup', 'name' => 'title', 'value' => 'id'));

        //$fields["supplierId"] = array("label" => "Supplier", "className" => "col-md-3", 'type' => "select", "required" => false, 'datasource' => array('repository' => 'SoftoneBundle:SoftoneSupplier', 'name' => 'title', 'value' => 'id', 'suffix' => 'code'));
        $fields["customerVatsts"] = array("label" => "ΦΠΑ", "required" => true, "className" => "col-md-6", 'type' => "select", 'dataarray' => $vatsts);

        $priceField[] = array("value" => "itemPricer", "name" => "Λιανική");
        $priceField[] = array("value" => "itemPricew", "name" => "Χονδρική");

        $priceField[] = array("value" => "itemPricer01", "name" => "Λιανική 1");
        $priceField[] = array("value" => "itemPricew01", "name" => "Χονδρική 1");

        $priceField[] = array("value" => "itemPricer02", "name" => "Λιανική 2");
        $priceField[] = array("value" => "itemPricew02", "name" => "Χονδρική 2");

        $priceField[] = array("value" => "itemPricer03", "name" => "Λιανική 3");
        $priceField[] = array("value" => "itemPricew03", "name" => "Χονδρική 3");


        $fields["priceField"] = array("label" => "Κατάλογος", "className" => "col-md-6", 'type' => "select", "required" => true, 'dataarray' => $priceField);

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
                ->addField(array("name" => "Group", "index" => 'customergroup:title'));
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

    function retrieve($params = array()) {
        $object = $params["object"];
        $em = $this->getDoctrine()->getManager();
        $fields = $em->getClassMetadata($params["object"])->getFieldNames();
        //print_r($fields);

        $itemfield = array();
        $itemfield[] = "M." . $params["softone_table"];
        foreach ($fields as $field) {
            $ffield = " " . $field;
            if (strpos($ffield, $params["softone_object"]) == true) {
                $itemfield[] = "M." . strtoupper(str_replace($params["softone_object"], "", $field));
            }
        }

        foreach ($params["extra"] as $field => $extra) {
            //if (@$data[$extra] AND in_array($field, $fields)) {
            if ($field == $extra)
                $itemfield[] = "M." . strtoupper($field);
            else
                $itemfield[] = "M." . strtoupper($field) . " as $extra";
            //}
        }


        $selfields = implode(",", $itemfield);
        $params["fSQL"] = 'SELECT ' . $selfields . ' FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        //echo $params["fSQL"];
        //$params["fSQL"] = 'SELECT M.* FROM ' . $params["softone_table"] . ' M ' . $params["filter"];
        echo "<BR>";
        echo $params["fSQL"];
        echo "<BR>";

        $softone = new Softone();
        $datas = $softone->createSql($params);
        //print_r($datas);
        ///return;
        ///exit;
        $em = $this->getDoctrine()->getManager();
        foreach ((array) $datas->data as $data) {
            $data = (array) $data;
            //$data["IRSDATA2"] = $IRSDATA[$data["IRSDATA"]];
            //print_r($data);
            //if ($i++ > 100 ) exit;


            $entity = $this->getDoctrine()
                    ->getRepository($params["repository"])
                    ->findOneBy(array("reference" => (int) $data[$params["softone_table"]]));

            echo @$entity->id . "<BR>";

            //if ($data[$params["softone_table"]] < 7385) continue;
            /*
            $dt = new \DateTime("now");
            if (@$entity->id == 0) {
                $entity = new $object();
                $entity->setTs($dt);
                $entity->setCreated($dt);
                $entity->setModified($dt);
            } else {
                continue;
                //$entity->setRepositories();                
            }
            */
            //@print_r($entity->repositories);
            foreach ($params["relation"] as $field => $extra) {
                //echo $field." - ".@$data[$extra]."<BR>";
                if (@$data[$extra] AND in_array($field, $fields)) {
                    $entity->setField($field, @$data[$extra]);
                }
                //echo @$entity->repositories[$field];
                if (@$data[$extra] AND @ $entity->repositories[$field]) {
                    $rel = $this->getDoctrine()->getRepository($entity->repositories[$field])->findOneById($data[$extra]);
                    $entity->setField($field, $rel);
                }
            }
            echo $data[$params["softone_table"]] . "<BR>";
            /*
              $imporetedData = array();
              $entity->setReference($data[$params["softone_table"]]);

              $em->persist($entity);
              $em->flush();
             */
            //$this->flushpersist($entity);
            $q = array();
            $q[] = "reference = '" . $data[$params["softone_table"]] . "'";

            foreach ($data as $identifier => $val) {
                $imporetedData[strtolower($params["softone_object"] . "_" . $identifier)] = addslashes($val);
                $ad = strtolower($identifier);
                $baz = $params["softone_object"] . ucwords(str_replace("_", " ", $ad));
                if (in_array($baz, $fields)) {
                    $q[] = "`" . strtolower($params["softone_object"] . "_" . $identifier) . "` = '" . addslashes($val) . "'";
                    //$entity->setField($baz, $val);
                }
            }
            if ($entity) {
                $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
            } else {
                $sql = "insert " . strtolower($params["table"]) . " set " . implode(",", $q) . "";
            }
            echo $sql . "<BR>";
            //if ($i++ > 100)
            //    exit;
            continue;
            //$em->getConnection()->exec($sql);
            /*
              @$entity_id = (int) $entity->id;
              //if (@$entity_id > 0) {
              $sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity_id . "'";
              echo $sql."<BR>";
              $em->getConnection()->exec($sql);
              foreach ($params["extrafunction"] as $field => $func) {
              //$entity->$func();
              }
              //}
             * 
             */
            $entity = null;
            //if (@$i++ > 1500)
            //    break;
        }
    }

    /**
     * @Route("/customer/retrieve")
     */
    function retrieveSoftoneData($params = array()) {

        $this->retrieveCustomer();
        $em = $this->getDoctrine()->getManager();

        /*
          $sql = "SELECT * FROM IRSDATA";
          $params["fSQL"] = $sql;
          $softone = new Softone();
          $datas = $softone->createSql($params);

          print_r($datas);
          foreach($datas->data as $data) {
          $sql = "Insert softone_customerirs set "
          . "id = '".$data->IRSDATA."', "
          . "name = '".$data->NAME."', "
          . "address = '".$data->ADDRESS."', "
          . "district = '".$data->DISTRICT."', "
          . "zip = '".$data->ZIP."'"
          ;
          $em->getConnection()->exec($sql);
          }
         * 
         */
        exit;

        $params["list"] = 'partsbox';

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
            break;
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
        $sql = 'update `softone_customer` set `group` = 1 where `group` is null';
        echo $sql;
        $this->getDoctrine()->getConnection()->exec($sql);
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
    }

    function getRules() {
        $rules = $this->getCustomergroup()->loadCustomergrouprules()->getRules();
        $sortorder = 0;

        foreach ($rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                $sortorder = $rule->getSortorder();
                $discount = $rule->getVal();
                $price = $rule->getPrice();
            }
        }
    }

}
