<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\Edi as Edi;
use EdiBundle\Entity\Eltrekaedi;
use AppBundle\Entity\Tecdoc as Tecdoc;
use AppBundle\Controller\Main as Main;
use EdiBundle\Entity\Edirule as Edirule;

class EdiController extends Main {

    var $repository = 'EdiBundle:Edi';
    var $newentity = '';

    /**
     * @Route("/edi/edi")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Edi:index.html.twig', array(
                    'pagename' => 'Edi',
                    'url' => '/edi/edi/getdatatable',
                    'view' => '/edi/edi/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/edi/view/{id}")
     */
    public function viewAction($id) {

        $buttons = array();
        $content = $this->gettabs($id);
        $content = $this->content();
        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Customergroup;
        }

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
                $categoriesArr[$category2->getSortcode()] = "--" . $category2->getName();
                //$category2->setSortcode($category->getId().$category2->getId());
                //$this->flushpersist($category2);
            }
        }
        $categoryjson = json_encode($categoriesArr);
        $edirules = $entity->loadEdirules()->getRules();
        $rules = array();
        foreach ($edirules as $edirule) {
            //if ($edirule->getEdi()->getId() == $id) {
            $rules[$edirule->getId()]["rule"] = $edirule->getRule();
            $rules[$edirule->getId()]["val"] = $edirule->getVal();
            $rules[$edirule->getId()]["sortorder"] = $edirule->getSortorder();
            $rules[$edirule->getId()]["title"] = $edirule->getTitle();
            $rules[$edirule->getId()]["price"] = $edirule->getPrice();
            $rules[$edirule->getId()]["price_field"] = $edirule->getPriceField();
            //}
        }

        return $this->render('EdiBundle:Edi:view.html.twig', array(
                    'pagename' => "Edi: " . $entity->getName(),
                    'url' => '/edi/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'rules' => $rules,
                    'edi' => $id,
                    'supplierjson' => $supplierjson,
                    "categoryjson" => $categoryjson,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/edi/gettab")
     */
    public function gettabs($id) {


        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);

        if ($id == 0 AND @ $entity->id == 0) {
            $entity = new Edi;
            $this->newentity[$this->repository] = $entity;
        }

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');
        $suppliers = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Supplier')->findAll();
        $itemMtrsup = array();
        foreach ($suppliers as $supplier) {
            $itemMtrsup[] = array("value" => (string) $supplier->getReference(), "name" => $supplier->getSupplierName()); // $supplier->getSupplierName();
        }


        $fields["name"] = array("label" => "Name");
        $fields["token"] = array("label" => "Token");
        $fields["func"] = array("label" => "Func");
        $fields["itemMtrsup"] = array("label" => "Συνήθης προμηθευτής", "required" => false, "className" => "col-md-2", 'type' => "select", 'dataarray' => $itemMtrsup);


        $forms = $this->getFormLyFields($entity, $fields);


        if ($id > 0 AND count($entity) > 0) {
            //$entity2 = $this->getDoctrine()
            //        ->getRepository('SoftoneBundle:Customergrouprule')
            //       ->find($id);
            //$fields2["reference"] = array("label" => "Erp Code", "className" => "synafiacode col-md-12");
            //$forms2 = $this->getFormLyFields($entity2, $fields2);

            $dtparams[] = array("name" => "ID", "index" => 'id', "active" => "active");
            $dtparams[] = array("name" => "Title", "index" => 'title');
            $dtparams[] = array("name" => "Markup", "index" => 'val');
            $dtparams[] = array("name" => "Price", "index" => 'price');
            $dtparams[] = array("name" => "Order", "index" => 'sortorder');

            $params['dtparams'] = $dtparams;
            $params['id'] = $dtparams;
            $params['url'] = '/edi/edi/getrules/' . $id;
            //$params['view'] = '/edi/edi/getrule/' . $id;
            $params['key'] = 'gettabs_' . $id;
            $params["ctrl"] = 'ctrlgettabs';
            $params["app"] = 'appgettabs';
            $datatables[] = $this->contentDatatable($params);
        }



        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        //$this->addTab(array("title" => "Rules", "content" => $this->getRules($entity), "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        if ($id > 0 AND count($entity) > 0) {
            $tabs[] = array("title" => "Rules", "datatables" => $datatables, "form" => $forms2, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true);
        }
        foreach ((array) $tabs as $tab) {
            $this->addTab($tab);
        }

        $json = $this->tabs();
    }

    /**
     * @Route("/edi/edi/getrules/{id}")
     */
    public function getRulesAction($id) {
        $session = new Session();
        foreach ($session->get('params_gettabs_' . $id) as $param) {
            $this->addField($param);
        }
        $this->repository = 'EdiBundle:Edirule';
        $this->q_and[] = $this->prefix . ".edi = '" . $id . "'";
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
     * @Route("/edi/edi/saverule")
     */
    function saveruleAction(Request $request) {

        $id = $request->request->get("id");
        $rule = $request->request->get("rule");
        $val = $request->request->get("val");
        $sortorder = $request->request->get("sortorder");
        $title = $request->request->get("title");
        $price = $request->request->get("price");
        $edi = $request->request->get("edi");
        $priceField = $request->request->get("price_field");
        if ($id == 0) {
            $edirule = new Edirule;
            $this->initialazeNewEntity($entity);
            $ediobj = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->find($edi);
            $edirule->setEdi($ediobj);
        } else {
            $edirule = $this->getDoctrine()->getRepository('EdiBundle:Edirule')->find($id);
        }
        $edirule->setRule(json_encode($rule));
        $edirule->setVal($val);
        $edirule->setSortorder($sortorder);
        $edirule->setTitle($title);
        $edirule->setPrice($price);
        $edirule->setPriceField($priceField);
        $this->flushpersist($edirule);

        /*
          $grouprules = $this->getDoctrine()->getRepository('SoftoneBundle:Customergrouprule')->findBy(array("group"=>$edi));
          $i=0;
          foreach ((array)$grouprules as $grouprule) {
          echo $i++;
          $grouprule->setSortorder($i++);
          $this->flushpersist($grouprule);
          }
         * 
         */

        $json = json_encode(array("id" => $edirule->getId()));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );

        exit;
    }

    /**
     * @Route("/edi/edi/deleterule")
     */
    function deleteruleAction(Request $request) {
        $id = $request->request->get("id");
        $edirule = $this->getDoctrine()->getRepository('EdiBundle:Edirule')->find($id);
        //$edirule->delete();
        $this->flushremove($edirule);
        exit;
    }

    /**
     * @Route("/edi/save")
     */
    public function savection() {
        $entity = new Edi;
        $this->newentity[$this->repository] = $entity;

        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getEdiPartMasterFile($apiToken) {
        return 'http://zerog.gr/edi/fw.ashx?method=getinventoryfile&apiToken=' . $apiToken;
    }

    /**
     * @Route("/edi/edi/getPartMaster")
     */
    public function getPartMasterAction() {
        $this->createSelect(array($this->prefix . ".id", $this->prefix . ".token", $this->prefix . ".func", $this->prefix . ".id"));
        $collection = $this->collection($this->repository);
        $i = 0;
        foreach ($collection as $entity) {
            //if ($i++ <= 1) continue;
            if ($entity["id"] == 4) {
                $func = $entity["func"];
                $this->$func($entity);
            }
        }
        exit;
    }

    public function getComlineEdiPartMaster($entity) {
        //echo $this->getPartMaster();
        //return;
        $comlineEdiPartMaster = "http://b2b.comlinehellas.gr/antallaktika/edi/getPartMaster";
        echo $comlineEdiPartMaster . "<BR>";
        //return;
        $tecdoc = new Tecdoc();
        $file = "/home2/partsbox/comline.csv";
        $fiestr = file_get_contents($comlineEdiPartMaster);
        file_put_contents($file, $fiestr);
        set_time_limit(100000);
        ini_set('memory_limit', '4096M');

        //return;
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);

            foreach ($data as $key => $attr) {
                //similardlnr, similarartnr
                //if ($key == 'similardlnr' OR $key = 'similarartnr' ) continue;
                $attrs[$key] = strtolower($attr);
            }
            print_r($attrs);
            $i = 0;
            while ($data = fgetcsv($handle, 1000, "\t", "|")) {
                //if ($i++ == 0) continue;

                foreach ($data as $key => $val) {
                    //if ($attrs[$key])
                    $attributes[$attrs[$key]] = trim(addslashes($val));
                }

                print_r($attributes);
                if ($i++ > 10)
                    break;
                continue;
                echo ($i++) . "<BR>";
                //if ($i < 271341) continue;
                //if ($key == 'similardlnr' OR $key = 'similarartnr' ) continue;

                if ((int) $attributes['dlnr'] == 0)
                    $attributes['dlnr'] = $attributes['similardlnr'];
                if ($attributes['artnr'] == '')
                    $attributes['dlnr'] = $attributes['similarartnr'];


                $attributes['wholesaleprice'] = $attributes['pricew'];
                $attributes['retailprice'] = $attributes['pricer'];
                $attributes['partno'] = $this->clearstring($attributes['partno']);


                unset($attributes['similardlnr']);
                unset($attributes['similarartnr']);
                unset($attributes['pricer']);
                unset($attributes['pricew']);

                if (@!$ediedis[$entity["id"]]) {
                    $ediedi = $this->getDoctrine()
                            ->getRepository('EdiBundle:Edi')
                            ->findOneById($entity["id"]);
                    $ediedis[$entity["id"]] = $ediedi;
                }
                $ediedi = $ediedis[$entity["id"]];
                $ediediitem = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiItem')
                        ->findOneBy(array("itemCode" => $attributes["itemcode"], "Edi" => $ediedi));
                //echo @$ediediitem->id . "<BR>";
                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$ediedi_id = (int) $ediediitem->id;
                if (@$ediedi_id == 0) {
                    $sql = "replace partsbox_db.edi_item set id = '" . $ediedi_id . "', edi='" . $entity["id"] . "', " . implode(",", $q);
                    echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                    /*
                      $ediediitem = $this->getDoctrine()
                      ->getRepository('EdiBundle:EdiItem')
                      ->findOneBy(array("itemCode" => $attributes["itemcode"], "Edi" => $ediedi));
                     */
                    //$ediediitem->tecdoc = $tecdoc;
                    //$ediediitem->updatetecdoc();
                    //if ($i++ > 60) return;
                } else {
                    $sql = "update partsbox_db.edi_item set " . implode(",", $q) . " where id = '" . $ediedi_id . "'";
                    echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                }
            }
        }
    }

    public function getEdiPartMaster($entity) {
        //echo $this->getPartMaster();
        //return;
        $apiToken = $entity["token"];
        echo $apiToken . "<BR>";
        echo $this->getEdiPartMasterFile($entity["token"]) . "<BR>";
        //return;
        $tecdoc = new Tecdoc();
        $file = "/home2/partsbox/" . $apiToken . '.csv';
        $fiestr = gzdecode(file_get_contents($this->getEdiPartMasterFile($entity["token"])));
        file_put_contents($file, $fiestr);
        set_time_limit(100000);
        ini_set('memory_limit', '4096M');

        //return;
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);

            foreach ($data as $key => $attr) {
                //similardlnr, similarartnr
                //if ($key == 'similardlnr' OR $key = 'similarartnr' ) continue;
                $attrs[$key] = strtolower($attr);
            }
            print_r($attrs);
            $i = 0;
            while ($data = fgetcsv($handle, 1000, "\t", "|")) {
                //if ($i++ == 0) continue;

                foreach ($data as $key => $val) {
                    //if ($attrs[$key])
                    $attributes[$attrs[$key]] = trim(addslashes($val));
                }

                echo ($i++) . "<BR>";
                //if ($i < 271341) continue;
                //if ($key == 'similardlnr' OR $key = 'similarartnr' ) continue;

                if ((int) $attributes['dlnr'] == 0)
                    $attributes['dlnr'] = $attributes['similardlnr'];
                if ($attributes['artnr'] == '')
                    $attributes['dlnr'] = $attributes['similarartnr'];


                $attributes['wholesaleprice'] = $attributes['pricew'];
                $attributes['retailprice'] = $attributes['pricer'];
                $attributes['partno'] = $this->clearstring($attributes['partno']);


                unset($attributes['similardlnr']);
                unset($attributes['similarartnr']);
                unset($attributes['pricer']);
                unset($attributes['pricew']);

                if (@!$ediedis[$entity["id"]]) {
                    $ediedi = $this->getDoctrine()
                            ->getRepository('EdiBundle:Edi')
                            ->findOneById($entity["id"]);
                    $ediedis[$entity["id"]] = $ediedi;
                }
                $ediedi = $ediedis[$entity["id"]];
                $ediediitem = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiItem')
                        ->findOneBy(array("itemCode" => $attributes["itemcode"], "Edi" => $ediedi));
                //echo @$ediediitem->id . "<BR>";
                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$ediedi_id = (int) $ediediitem->id;
                if (@$ediedi_id == 0) {
                    $sql = "replace partsbox_db.edi_item set id = '" . $ediedi_id . "', edi='" . $entity["id"] . "', " . implode(",", $q);
                    echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                    /*
                      $ediediitem = $this->getDoctrine()
                      ->getRepository('EdiBundle:EdiItem')
                      ->findOneBy(array("itemCode" => $attributes["itemcode"], "Edi" => $ediedi));
                     */
                    //$ediediitem->tecdoc = $tecdoc;
                    //$ediediitem->updatetecdoc();
                    //if ($i++ > 60) return;
                } else {
                    $sql = "update partsbox_db.edi_item set " . implode(",", $q) . " where id = '" . $ediedi_id . "'";
                    echo $sql . "<BR>";
                    $em->getConnection()->exec($sql);
                }
            }
        }
    }

    public function getEltrekaPartMaster($entity) {
        //return;
        set_time_limit(100000);
        $eltrekaedi = new Eltrekaedi();
        $file = $eltrekaedi->getPartMasterFile();
        echo $file;
        exit;
        //$file = 'http://195.144.16.7/EltrekkaEDI/Temp/Parts/RE4V1G9V.txt';
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            $i = 0;
            while ($data = fgetcsv($handle, 100000, "\t")) {
                //if ($i++ < 120000) continue;
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = trim(addslashes($val));
                }
                //print_r($attributes);
                $attributes["wholeprice"] = str_replace(",", ".", $attributes["wholeprice"]);
                $attributes["retailprice"] = str_replace(",", ".", $attributes["retailprice"]);
                $attributes["gross_weight_gr"] = str_replace(",", ".", $attributes["gross_weight_gr"]);
                $attributes["lenght_mm"] = str_replace(",", ".", $attributes["lenght_mm"]);
                $attributes["width_mm"] = str_replace(",", ".", $attributes["width_mm"]);
                $attributes["height_mm"] = str_replace(",", ".", $attributes["height_mm"]);

                if (@!$ediedis[$entity["id"]]) {
                    $ediedi = $this->getDoctrine()
                            ->getRepository('EdiBundle:Edi')
                            ->findOneById($entity["id"]);
                    $ediedis[$entity["id"]] = $ediedi;
                }
                $ediedi = $ediedis[$entity["id"]];

                $ediediitem = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiItem')
                        ->findOneBy(array("itemCode" => $attributes["partno"], "Edi" => $ediedi));
                @$ediedi_id = (int) $ediediitem->id;
                echo $attributes["partno"] . " " . $ediedi_id . "<BR>";
                if (@$ediedi_id == 0) {
                    $sql = "replace partsbox_db.edi_item set "
                            . "id = '" . $ediedi_id . "', "
                            . "edi='" . $entity["id"] . "', "
                            . "itemcode='" . $attributes["partno"] . "', "
                            . "brand='" . $attributes["supplierdescr"] . "', "
                            . "partno='" . $this->clearstring($attributes["factorypartno"]) . "', "
                            . "description='" . $attributes["description"] . "', "
                            . "dlnr='" . $attributes["tecdocsupplierno"] . "', "
                            . "artnr='" . $attributes["tecdocpartno"] . "', "
                            . "wholesaleprice='" . $attributes["wholeprice"] . "', "
                            . "retailprice='" . $attributes["retailprice"] . "'";
                    $em->getConnection()->exec($sql);
                    echo $sql . "<BR>";
                    $ediediitem = $this->getDoctrine()
                            ->getRepository('EdiBundle:EdiItem')
                            ->findOneBy(array("itemCode" => $attributes["partno"], "Edi" => $ediedi));
                    @$ediedi_id = (int) $ediediitem->id;
                } else {
                    $sql = "update partsbox_db.edi_item set "
                            . "partno='" . $this->clearstring($attributes["factorypartno"]) . "', "
                            . "wholesaleprice='" . $attributes["wholeprice"] . "', "
                            . "retailprice='" . $attributes["retailprice"] . "' where id = '" . $ediedi_id . "'";
                    $em->getConnection()->exec($sql);
                    //echo $sql . "<BR>";
                    echo ".";
                }
                continue;
                //$ediediitem->updatetecdoc();

                $eltrekaedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Eltrekaedi')
                        ->findOneByPartno($attributes["partno"]);

                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$eltrekaedi_id = (int) $eltrekaedi->id;
                //if ($eltrekaedi_id == 0) {
                $sql = "replace partsbox_db.eltrekaedi set id = '" . $eltrekaedi_id . "', ediitem = '" . $ediedi_id . "', " . implode(",", $q);
                $em->getConnection()->exec($sql);
                //}
                //if ($i++ > 30)
                //    return;
            }
        }
    }

    function clearstring($search) {
        $search = str_replace(" ", "", trim($search));
        $search = str_replace(".", "", $search);
        $search = str_replace("-", "", $search);
        $search = str_replace("/", "", $search);
        $search = str_replace("*", "", $search);
        $search = strtoupper($search);
        return $search;
    }

    private function fixsuppliers() {
        $em = $this->getDoctrine()->getManager();

        $sql = "UPDATE partsbox_db.edi_item SET brand = 'FEBI BILSTEIN' WHERE brand LIKE 'FEBI'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'BENDIX', updated = 1 WHERE  brand LIKE 'BENDIX WBK'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'FEBI BILSTEIN', updated = 1 WHERE  brand LIKE 'FEBI BILSTEIN BILSTEIN'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'BLUE-PRINT' WHERE  brand LIKE 'BLUEPRINT'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'BLUE-PRINT' WHERE  brand LIKE 'BLUE PRINT'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'LEMFORDER' WHERE  brand LIKE 'LEMF?RDER'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'LESJOFORS' WHERE  brand LIKE 'LESJ?FORS'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'CONTITECH' WHERE  brand LIKE 'CONTI-TECH'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'COOPERSFIAAM FILTERS' WHERE  brand LIKE 'COOPERSFIAAM FILTERSFIAAM'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN-FILTEREX'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN-FILTER-FILTER'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MULLER FILTER' WHERE  brand LIKE 'MULLER'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'GENERAL RICAMBI' WHERE  brand LIKE 'RICAMBI'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'FAI AutoParts' WHERE  brand LIKE 'Fai AutoParts'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'BEHR HELLA SERVICE' WHERE  brand LIKE 'BEHR-HELLA'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'COOPERSFIAAM FILTERS' WHERE  brand LIKE 'COOPERSFIAAM FILTERSFIAAM'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'FI.BA' WHERE  brand LIKE 'FIBA'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'FLENNOR' WHERE  brand LIKE 'FLENOR'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'fri.tech.' WHERE  brand LIKE 'FRITECH'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'HERTH+BUSS JAKOPARTS' WHERE  brand LIKE 'HERTH & BUSS JAKOPARTS'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'KYB' WHERE  brand LIKE 'KAYABA'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'KM Germany' WHERE  brand LIKE 'KM'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'LuK' WHERE  brand LIKE 'LUK'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'ZIMMERMANN' WHERE  brand LIKE 'ZIMMERMANN-FILTER'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'CALORSTAT by Vernet' WHERE  brand LIKE 'VERNET'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'Metalcaucho' WHERE  brand LIKE 'METALCAUCHO'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN-FILTER'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'MANN-FILTER', updated = 1 WHERE  brand LIKE 'MANN-FILTER-FILTER'";
        $em->getConnection()->exec($sql);

        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'COOPERSFIAAM FILTERS', updated = 1 WHERE  brand LIKE 'COOPERSCOOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS FILTERS'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'COOPERSFIAAM FILTERS', updated = 1 WHERE  brand LIKE 'FIAAM'";
        $em->getConnection()->exec($sql);
        $sql = "UPDATE  partsbox_db.edi_item SET brand = 'COOPERSFIAAM FILTERS', updated = 1 WHERE  brand LIKE 'FIAAM'";
        $em->getConnection()->exec($sql);
    }

    /**
     * @Route("/edi/edi/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $this->repository = 'EdiBundle:Edi';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Name", "index" => 'name', 'search' => 'text'))
                ->addField(array("name" => "Token", "index" => 'token', 'search' => 'text'))

        ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/edi/install")
     */
    public function installAction(Request $request) {
        //$this->install();
        //$this->getPartMaster();
    }

}
