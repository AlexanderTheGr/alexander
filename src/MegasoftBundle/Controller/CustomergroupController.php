<?php

namespace MegasoftBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Main as Main;
use MegasoftBundle\Entity\Customergroup as Customergroup;
use MegasoftBundle\Entity\Customergrouprule as Customergrouprule;

class CustomergroupController extends Main {

    var $repository = 'MegasoftBundle:Customergroup';
    var $newentity = array();

    /**
     * @Route("/erp01/customergroup/customergroup")
     */
    public function indexAction() {

        return $this->render('MegasoftBundle:Customergroup:index.html.twig', array(
                    'pagename' => 'Customergroups',
                    'url' => '/erp01/customergroup/getdatatable',
                    'view' => '/erp01/customergroup/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/erp01/customergroup/view/{id}")
     */
    public function viewAction($id) {



        //$user = $this->get('security.token_storage')->getToken()->getUser();
        //echo $user->getCroup()->getId();

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->content();
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Customergroup;
        }


        $productsales = $this->getDoctrine()->getRepository("MegasoftBundle:ProductSale")->findAll();
        $productsaleArr = array();
        foreach ($productsales as $productsale) {
            $productsaleArr[$productsale->getId()] = $productsale->getTitle();
        }
        $productsalejson = json_encode($productsaleArr);

        $suppliers = $this->getDoctrine()->getRepository("MegasoftBundle:Manufacturer")->findAll();
        $supplierArr = array();
        foreach ($suppliers as $supplier) {
            $supplierArr[$supplier->getId()] = $supplier->getTitle();
        }
        $supplierjson = json_encode($supplierArr);
        
        $suppliers2 = $this->getDoctrine()->getRepository("MegasoftBundle:Supplier")->findAll();
        $supplier2Arr = array();
        foreach ($suppliers2 as $supplier) {
            $supplier2Arr[$supplier->getId()] = $supplier->getSupplierName();
        }
        $supplier2json = json_encode($supplier2Arr);
        
        $categories = $this->getDoctrine()->getRepository("MegasoftBundle:Category")->findBy(array("parent" => 0));
        $categoriesArr = array();
        foreach ($categories as $category) {
            //$CategoryLang = $this->getDoctrine()->getRepository("MegasoftBundle:CategoryLang")->findOneBy(array("category" => $category));
            //$category->setSortcode($category->getId()."00000");
            //$this->flushpersist($category);
            $categoriesArr[$category->getSortcode()] = $category->getName();
            $categories2 = $this->getDoctrine()->getRepository("MegasoftBundle:Category")->findBy(array("parent" => $category->getId()));
            foreach ($categories2 as $category2) {
                //$CategoryLang = $this->getDoctrine()->getRepository("MegasoftBundle:CategoryLang")->findOneBy(array("category" => $category2));
                $categoriesArr[$category2->getSortcode()] = "-- " . $category2->getName();
                //$category2->setSortcode($category->getId().$category2->getId());
                //$this->flushpersist($category2);
            }
        }
        $categoryjson = json_encode($categoriesArr);
        $grouprules = $entity->loadCustomergrouprules()->getRules();
        $rules = array();
        foreach ($grouprules as $grouprule) {
            if ($grouprule->getGroup()->getId() == $id) {
                $rules[$grouprule->getId()]["rule"] = $grouprule->getRule();
                $rules[$grouprule->getId()]["val"] = $grouprule->getVal();
                $rules[$grouprule->getId()]["sortorder"] = $grouprule->getSortorder();
                $rules[$grouprule->getId()]["title"] = $grouprule->getTitle();
                $rules[$grouprule->getId()]["price"] = $grouprule->getPrice();
            }
        }
        return $this->render('MegasoftBundle:Customergroup:view.html.twig', array(
                    'pagename' => "Ομάδες Πελατών: " . $entity->getTitle(),
                    'url' => '/erp01/customergroup/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'rules' => $rules,
                    'group' => $id,
                    'supplierjson' => $supplierjson,
                    "categoryjson" => $categoryjson,
                    "productsalejson" => $productsalejson,
                    "supplier2json" => $supplier2json,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/erp01/customergroup/save")
     */
    public function saveAction() {
        $entity = new Customergroup;

        //$this->repository = "MegasoftBundle:Customer";
        $this->newentity[$this->repository] = $entity;
        $this->initialazeNewEntity($entity);
        $this->save();
        $entity = $this->newentity[$this->repository];
        $jsonarr["returnurl"] = "/erp01/customergroup/view/" . $entity->getId();
        $json = json_encode($jsonarr);
        //$json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/erp01/customergroup/saverule")
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
            $customergrouprule = new Customergrouprule;
            $this->initialazeNewEntity($entity);
            $customergroup = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->find($group);
            $customergrouprule->setGroup($customergroup);
        } else {
            $customergrouprule = $this->getDoctrine()->getRepository('MegasoftBundle:Customergrouprule')->find($id);
        }
        $customergrouprule->setRule(json_encode($rule));
        $customergrouprule->setVal($val);
        $customergrouprule->setSortorder($sortorder);
        $customergrouprule->setTitle($title);
        $customergrouprule->setPrice($price);
        $this->flushpersist($customergrouprule);

        /*
          $grouprules = $this->getDoctrine()->getRepository('MegasoftBundle:Customergrouprule')->findBy(array("group"=>$customergroup));
          $i=0;
          foreach ((array)$grouprules as $grouprule) {
          echo $i++;
          $grouprule->setSortorder($i++);
          $this->flushpersist($grouprule);
          }
         * 
         */

        $json = json_encode(array("id" => $customergrouprule->getId()));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );

        exit;
    }

    /**
     * @Route("/erp01/customergroup/deleterule")
     */
    function deleteruleAction(Request $request) {
        $id = $request->request->get("id");
        $customergrouprule = $this->getDoctrine()->getRepository('MegasoftBundle:Customergrouprule')->find($id);
        //$customergrouprule->delete();
        $this->flushremove($customergrouprule);
        exit;
    }

    /**
     * @Route("/erp01/customergroup/gettab")
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


        if ($id > 0 AND count($entity) > 0) {
            //$entity2 = $this->getDoctrine()
            //        ->getRepository('MegasoftBundle:Customergrouprule')
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
            $params['url'] = '/erp01/customergroup/getrules/' . $id;
            //$params['view'] = '/erp01/customergroup/getrule/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }



        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        //$this->addTab(array("title" => "Rules", "content" => $this->getRules($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
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
     * @Route("/erp01/customergroup/getrules/{id}")
     */
    public function getRulesAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'MegasoftBundle:Customergrouprule';
        $this->q_and[] = $this->prefix . ".group = '" . $id . "'";
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
     * @Route("/erp01/customergroup/getrulesjson/{id}")
     */
    public function getCustomerRulesJsonAction($id) {
        $allowedips = $this->getSetting("MegasoftBundle:Product:Allowedips");
        $allowedipsArr = explode(",", $allowedips);
        if (in_array($_SERVER["REMOTE_ADDR"], $allowedipsArr)) {
            $customer = $this->getDoctrine()->getRepository("MegasoftBundle:Customer")->findOneBy(array("reference" => $id));
            //echo $customer->getCustomergroup()->getId();
            $rules = $this->getDoctrine()->getRepository("MegasoftBundle:Customergrouprule")->findBy(array("group" => $customer->getCustomergroup()));
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

    function getRuleAction() {
        $total = 0;


        $suppliers = $this->getDoctrine()->getRepository("MegasoftBundle:MegasoftSupplier")->findAll();
        $supplierArr = array();
        foreach ($suppliers as $supplier) {
            $supplierArr[$supplier->getId()] = $supplier->getTitle();
        }
        $supplierjson = json_encode($supplierArr);

        $categories = $this->getDoctrine()->getRepository("MegasoftBundle:CategoryLang")->findAll();
        $categoriesArr = array();
        foreach ($categories as $category) {
            $categoriesArr[$category->getCategory()->getId()] = $category->getName();
        }
        $categoryjson = json_encode($categoriesArr);


        $response = $this->get('twig')->render('MegasoftBundle:Customergroup:rules.html.twig', array('supplierjson' => $supplierjson, "categoryjson" => $categoryjson));
        return str_replace("\n", "", htmlentities($response));
    }

    /**
     * @Route("/erp01/customergroup/getdatatable")
     */
    public function getdatatableAction(Request $request) {
        $this->repository = 'MegasoftBundle:Customergroup';

        $this->addField(array("name" => "ID", "index" => 'id', "active" => "active"))
                ->addField(array("name" => "Title", "index" => 'title'))
                ->addField(array("name" => "Price", "index" => 'basePrice'));
        $json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
