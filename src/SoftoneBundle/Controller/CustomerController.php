<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\Customer as Customer;
use SoftoneBundle\Entity\Customerrule as Customerrule;

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
        
        
        $productsales = $this->getDoctrine()->getRepository("SoftoneBundle:ProductSale")->findAll();
        $productsaleArr = array();
        foreach ($productsales as $productsale) {
            $productsaleArr[$productsale->getId()] = $productsale->getTitle();
        }
        $productsalejson = json_encode($productsaleArr);

        $suppliers = $this->getDoctrine()->getRepository("SoftoneBundle:SoftoneSupplier")->findAll();
        $supplierArr = array();
        foreach ($suppliers as $supplier) {
            $supplierArr[$supplier->getId()] = $supplier->getTitle();
        }
        $supplierjson = json_encode($supplierArr);

        $categories = $this->getDoctrine()->getRepository("SoftoneBundle:Category")->findBy(array("parent" => 0));
        $categoriesArr = array();
        foreach ($categories as $category) {
            //$CategoryLang = $this->getDoctrine()->getRepository("SoftoneBundle:CategoryLang")->findOneBy(array("category" => $category));
            //$category->setSortcode($category->getId()."00000");
            //$this->flushpersist($category);
            $categoriesArr[$category->getSortcode()] = $category->getName();
            $categories2 = $this->getDoctrine()->getRepository("SoftoneBundle:Category")->findBy(array("parent" => $category->getId()));
            foreach ($categories2 as $category2) {
                //$CategoryLang = $this->getDoctrine()->getRepository("SoftoneBundle:CategoryLang")->findOneBy(array("category" => $category2));
                $categoriesArr[$category2->getSortcode()] = "-- " . $category2->getName();
                //$category2->setSortcode($category->getId().$category2->getId());
                //$this->flushpersist($category2);
            }
        }
        $categoryjson = json_encode($categoriesArr);
        $grouprules = $entity->loadCustomerrules()->getRules();
        $rules = array();
        foreach ($grouprules as $grouprule) {
            if ($grouprule->getCustomer()->getId() == $id) {
                $rules[$grouprule->getId()]["rule"] = $grouprule->getRule();
                $rules[$grouprule->getId()]["val"] = $grouprule->getVal();
                $rules[$grouprule->getId()]["sortorder"] = $grouprule->getSortorder();
                $rules[$grouprule->getId()]["title"] = $grouprule->getTitle();
                $rules[$grouprule->getId()]["price"] = $grouprule->getPrice();
            }
        }
        return $this->render('SoftoneBundle:Customer:view.html.twig', array(
                    'pagename' => $pagename,
                    'url' => '/customer/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'rules' => $rules,
                    'group' => $id,
                    'supplierjson' => $supplierjson,
                    "categoryjson" => $categoryjson,
                    "productsalejson" => $productsalejson,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));    
        
        
        /*
        return $this->render('SoftoneBundle:Product:view.html.twig', array(
                    'pagename' => $pagename,
                    'url' => '/customer/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
         * 
         */
    }

    
    /**
     * @Route("/customer/getrulesjson/{id}")
     */
    public function getCustomerRulesJsonAction($id) {
        $allowedips = $this->getSetting("SoftoneBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $customer = $this->getDoctrine()->getRepository("SoftoneBundle:Customer")->findOneBy(array("reference" => $id));
            //echo $customer->getCustomergroup()->getId();
            $rules = $this->getDoctrine()->getRepository("SoftoneBundle:Customerrule")->findBy(array("customer" => $customer));
            $as["id"] = 0;
            $as["val"] = 0;
            $as["sortorder"] = 0;
            $as["price"] = "";
            $as["rules"] = array();
            $as["price_field"] = $customer->getPriceField();      
            $jsonarr[0] = $as;
            foreach ((array) $rules as $rule) {
                $as["id"] = $rule->getId();
                $as["val"] = $rule->getVal();
                $as["sortorder"] = $rule->getSortorder();
                $as["price"] = $rule->getPrice();
                $as["rules"] = json_decode($rule->getRule(), true);
                $as["price_field"] = $customer->getPriceField();
                $jsonarr[$rule->getId()] = $as;
            }
            $json = json_encode($jsonarr);
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        } else {
            $json = json_encode(array("opssss"));
            return new Response(
                    $json, 200, array('Content-Type' => 'application/json')
            );
        }
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
        
        $fields["customerIrsdata"] = array("label" => "ΔΟΥ", "className" => "col-md-6", "required" => false);
        $fields["customerJobtypetrd"] = array("label" => "Επάγγελμα", "className" => "col-md-6", "required" => false);        
        
        $fields["customerAddress"] = array("label" => "Customer Address", "className" => "col-md-6", "required" => false);
        $fields["customerCity"] = array("label" => "Customer City", "className" => "col-md-6", "required" => false);
        $fields["customerPhone01"] = array("label" => "Τηλέφωνο", "required" => false);

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
        
        
        
        if ($id > 0 AND count($entity) > 0) {
            //$entity2 = $this->getDoctrine()
            //        ->getRepository('SoftoneBundle:Customergrouprule')
            //       ->find($id);
            //$fields2["reference"] = array("label" => "Erp Code", "className" => "synafiacode col-md-12");
            //$forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "Title", "index" => 'title');
            $dtparams[] = array("name" => "Discount", "index" => 'val');
            $dtparams[] = array("name" => "Price", "index" => 'price');
            $dtparams[] = array("name" => "Order", "index" => 'sortorder');

            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/customer/getrules/' . $id;
            //$params['view'] = '/customergroup/getrule/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }
        
        
        
        $this->addTab(array("title" => "General1", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => "Rules", "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);
        }
        foreach ((array) $tabs as $tab) {
            $this->addTab($tab);
        }        
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
            //continue;
            $em->getConnection()->exec($sql);
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
    /**
     * @Route("/customer/getrules/{id}")
     */
    public function getRulesAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'SoftoneBundle:Customerrule';
        $this->q_and[] = $this->prefix . ".customer = '" . $id . "'";
        $json = $this->datatable();

        $datatable = json_decode($json);
        $datatable->data = (array) $datatable->data;
        foreach ($datatable->data as $key => $table) {
            $table = (array) $table;
            $table1 = array();
            foreach ($table as $f => $val) {
                $table1[$f] = $val;
            }
            $datatable->data[$key] = $table1;
        }
        $json = json_encode($datatable);


        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    /**
     * @Route("/customer/saverule")
     */
    function saveruleAction(Request $request) {

        $id = $request->request->get("id");
        $rule = $request->request->get("rule");
        $val = $request->request->get("val");
        $sortorder = $request->request->get("sortorder");
        $title = $request->request->get("title");
        $price = $request->request->get("price");
        $group = $request->request->get("group");
        if ($id == 0) {
            $customerrule = new Customerrule;
            $this->initialazeNewEntity($entity);
            $customer = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->find($group);
            $customerrule->setCustomer($customer);
        } else {
            $customerrule = $this->getDoctrine()->getRepository('SoftoneBundle:Customerrule')->find($id);
        }
        $customerrule->setRule(json_encode($rule));
        $customerrule->setVal($val);
        $customerrule->setSortorder($sortorder);
        $customerrule->setTitle($title);
        $customerrule->setPrice($price);
        $this->flushpersist($customerrule);

        /*
          $grouprules = $this->getDoctrine()->getRepository('SoftoneBundle:Customergrouprule')->findBy(array("group"=>$customergroup));
          $i=0;
          foreach ((array)$grouprules as $grouprule) {
          echo $i++;
          $grouprule->setSortorder($i++);
          $this->flushpersist($grouprule);
          }
         * 
         */

        $json = json_encode(array("id" => $customerrule->getId()));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );

        exit;
    }

    /**
     * @Route("/customer/deleterule")
     */
    function deleteruleAction(Request $request) {
        $id = $request->request->get("id");
        $customerrule = $this->getDoctrine()->getRepository('SoftoneBundle:Customerrule')->find($id);
        //$customerrule->delete();
        $this->flushremove($customerrule);
        exit;
    }

}
