<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\EdiItem;
use EdiBundle\Entity\Edi;
use AppBundle\Entity\Tecdoc as Tecdoc;
use AppBundle\Controller\Main as Main;

class EdiItemController extends Main {

    var $repository = 'EdiBundle:EdiItem';

    /**
     * @Route("/edi/ediitem")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Edi:index.html.twig', array(
                    'pagename' => 'EdiItems',
                    'url' => '/edi/ediitem/getdatatable',
                    'view' => '/edi/ediitem/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/ediitem/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();
        $EdiItem = $this->getDoctrine()
                ->getRepository('EdiBundle:EdiItem')
                ->find($id);
        $EdiItem->GetAvailability();
        return $this->render('EdiBundle:Edi:view.html.twig', array(
                    'pagename' => 'EdiItems',
                    'url' => '/edi/ediitem/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/ediitem/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getPartMasterFile() {
        $apiToken = $this->getSetting("EdiBundle:Edi:apiToken");
        return 'http://zerog.gr/edi/fw.ashx?method=getinventoryfile&apiToken=' . $apiToken;
    }

    /**
     * @Route("/edi/ediitem/getPartMaster")
     */
    public function getPartMasterAction() {
        $this->getPartMaster();
    }

    public function getPartMaster() {
        //echo $this->getPartMaster();
        //$fiestr = gzdecode(file_get_contents($this->getPartMasterFile()));
        //file_put_contents('file.csv', $fiestr);
        set_time_limit(100000);
        ini_set('memory_limit', '14096M');
        $file = 'file.csv';
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            //print_r($attrs);
            $i = 0;
            while ($data = fgetcsv($handle, 100000, "\t")) {
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = $val;
                }

                $ediedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:EdiItem')
                        ->findOneByItemCode($attributes["itemcode"]);

                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$ediedi_id = (int) $ediedi->id;
                if (@$ediedi_id == 0) {
                    $sql = "replace ediedi set id = '" . $ediedi_id . "', " . implode(",", $q);
                    $em->getConnection()->exec($sql);
                }
                //if ($i++ > 10) exit;
            }
        }
    }

    /**
     * @Route("/edi/ediitem/gettab")
     */
    public function gettabs($id) {

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        $fields["partno"] = array("label" => "Part No");
        $fields["description"] = array("label" => "Description");
        //$fields["supplierdescr"] = array("label" => "Supplier");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/edi/ediitem/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $this->repository = 'EdiBundle:EdiItem';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Edi", "index" => 'Edi:name', 'search' => 'select', 'type' => 'select'))
                ->addField(array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text'))
                ->addField(array("name" => "Brand", "index" => 'brand', 'search' => 'text'))
                ->addField(array("name" => "Part No", "index" => 'partno', 'search' => 'text'))
                ->addField(array("name" => "Description", "index" => 'description', 'search' => 'text'))
                ->addField(array("name" => "Price", "index" => 'wholesaleprice', 'search' => 'text'))

        ;
        $json = $this->datatable('setEdiQtyAvailability');
        //$json = $this->datatable();
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/ediitem/getorderedis")
     */
    public function getOrderEdisAction(Request $request) {
        //echo 'SELECT  ' . $this->prefix . '.id FROM ' . $this->repository . ' where ' . $this->prefix . '.partno = "' . $request->request->get("terms") . '"';
        $html = "";
        $em = $this->getDoctrine()->getManager();


        $search = $request->request->get("terms");
        $dt_search = $request->request->get("search");
        $search = explode(":", $request->request->get("value"));


        if ($search[1]) {

            if ($search[0] == 'productfano') {
                $search[1] = str_pad($search[1], 4, "0", STR_PAD_LEFT);
                $query = $em->createQuery(
                        "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.partno != '' AND  e.id = 11 AND
                        p.itemCode LIKE '" . $search[1] . "%' "
                );
            } else {
                if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                    $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
                    @$articleIds2 = unserialize(base64_decode($search[1]));
                    $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
                    $articleIds[] = 1;
                    $query = $em->createQuery(
                            "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.partno != '' AND
                        (p.artNr = '" . $search[1] . "' OR p.partno = '" . $search[1] . "' OR p.itemCode = '" . $search[1] . "' OR p.tecdocArticleId3 in (" . implode(",", $articleIds) . ")) "
                    );
                } else {
                    $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
                    @$articleIds2 = unserialize(base64_decode($search[1]));
                    $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
                    $articleIds[] = 1;
                    $query = $em->createQuery(
                            "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.partno != '' AND
                        (p.artNr = '" . $search[1] . "' OR p.partno = '" . $search[1] . "' OR p.itemCode = '" . $search[1] . "' OR p.tecdocArticleId in (" . implode(",", $articleIds) . ")) "
                    );
                }
            }
        } else {
            if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[0])));

                @$articleIds2 = unserialize(base64_decode($search[0]));
                $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
                $articleIds = $articleIds2["edimatched"];
                $articleIds[] = 1;
                //print_r($articleIds);
                $query = $em->createQuery(
                        "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.tecdocArticleId3 in (" . implode(",", $articleIds) . ")"
                );
            } else {
                $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[0])));

                @$articleIds2 = unserialize(base64_decode($search[0]));
                $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
                $articleIds[] = 1;
                $query = $em->createQuery(
                        "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.tecdocArticleId in (" . implode(",", $articleIds) . ")"
                );
            }
        }





        //echo "(p.partno LIKE '%" . $search[1] . "%' OR p.tecdocArticleId in (" . implode(",", $articleIds) . ")) ";
        $results = $query->getResult();
        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            //print_r($results);
        }
        $html .= '<button type="button" class="edibutton btn btn-raised ink-reaction" data-id="0">Invetory</button>';
        $edi = array();
        //print_r($results);
        foreach ($results as $data) {
            $edi[$data['eid']] = $data;
        }
        $query = $em->createQuery(
                "SELECT  e.id, e.name
                    FROM EdiBundle:Edi e"
        );
        $results = $query->getResult();


        foreach ($results as $dt) {
            if (@$edi[$dt['id']]) {
                $data = $edi[$dt['id']];
                $html .= '<button type="button" class="edibutton btn btn-raised ink-reaction btn-success" data-id="' . $data['eid'] . '">' . $data['edi'] . '</button>';
            } else {
                $html .= '<button type="button" class="btn btn-raised ink-reaction btn-danger" data-id="' . $dt['id'] . '">' . $dt['name'] . '</button>';
            }
        }


        $json["html"] = $html;
        return new Response(
                json_encode($json), 200, array('Content-Type' => 'application/json')
        );
        exit;
    }

    /**
     * @Route("/edi/ediitem/getorderdatatable/{id}")
     */
    public function getOrderDatatableAction(Request $request, $id) {

        $this->repository = 'EdiBundle:EdiItem';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Edi", "index" => 'Edi:name', 'search' => 'select', 'type' => 'select'))
                ->addField(array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text'))
                ->addField(array("name" => "Brand", "index" => 'brand', 'search' => 'text'))
                ->addField(array("name" => "Part No", "index" => 'partno', 'search' => 'text'))
                ->addField(array("name" => "Description", "index" => 'description', 'search' => 'text'))
                //->addField(array("name" => "Tecdoc Name", "index" => 'tecdocArticleName', 'search' => 'text'))
                ->addField(array("name" => "Price", "index" => 'wholesaleprice', 'search' => 'text'))
                ->addField(array("name" => "Price", "index" => 'wholesaleprice', 'search' => 'text'))
                ->addField(array("name" => "ID", "function" => 'getQty1', "active" => "active"))
                ->addField(array("name" => "ID", "function" => 'getQty2', "active" => "active"))
                ->addField(array("name" => "ID", "function" => 'getQty3', "active" => "active"))


        ;
        $json = $this->ediitemdatatable('setEdiQtyAvailability', $id);

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/ediitem/autocompletesearch/{edi}")
     */
    public function autocompletesearchAction($edi) {


        $entity = $this->getDoctrine()
                ->getRepository("EdiBundle:EdiOrder")
                ->find($edi);
        $json = json_encode(array("ok"));
        $em = $this->getDoctrine()->getManager();


        $query = $em->createQuery(
                        "SELECT p.id, p.itemCode,p.partno,p.artNr,p.artNr,p.description, p.brand FROM " . $this->repository . " " . $this->prefix . " where p.Edi=" . $entity->getEdi()->getId() . " AND (p.partno LIKE '" . $_GET["term"] . "' OR p.itemCode LIKE '%" . $_GET["term"] . "%' OR p.artNr LIKE '" . $_GET["term"] . "%')"
                )
                ->setMaxResults(20)
                ->setFirstResult(0);
        $datas = $query->getResult();
        $out = array();
        $elteka = $this->eltekaAuth();
        foreach ((array) $datas as $data) {
            //print_r($data);
            //$data["flat_data"] = "";
            if (strlen($entity->getEdi()->getToken()) == 36) {
                
            } else {

                $response = $elteka->getAvailability(
                        array('CustomerNo' => $this->CustomerNo,
                            "RequestedQty" => 1,
                            "EltrekkaRef" => $data["itemCode"]));
                $xml = $response->GetAvailabilityResult->any;

                $xml = simplexml_load_string($xml);

                foreach (@$xml->Item->AvailabilityDetails as $details) {
                    if ($entity->getStore() == (int) $details->StoreNo AND $details->IsAvailable == 'Y') {
                        $asd = $details->IsAvailable;
                        $avail = true;
                        break;
                    } else {
                        $asd = "(" . $details->EstimatedBODeliveryTime . ")";
                    }
                }
                if ($avail)
                    $asd = '';
            }


            $json = array();
            $json["id"] = $data["id"];
            $json["value"] = $data["description"] . " (" . $data["itemCode"] . " - " . $data["brand"] . " " . $data["partno"] . ") ";
            $json["label"] = $data["description"] . " (" . $data["itemCode"] . " - " . $data["brand"] . " " . $data["partno"] . ") " . $asd;
            $out[] = $json;
        }


        return new Response(
                json_encode($out), 200, array('Content-Type' => 'application/json')
        );
        exit;
    }

    /**
     * @Route("/edi/ediitem/updatetecdoc")
     */
    public function getUpdateTecdocAction($funct = false) {
        $em = $this->getDoctrine()->getManager();



        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            /*
              $query = $em->createQuery(
              "SELECT  p.id
              FROM " . $this->repository . " p, EdiBundle:Edi e
              where
              e.id = p.Edi AND p.dlnr > 0  order by p.id desc"
              );
             */
            $sql = "Select id from partsbox_db.edi_item where tecdoc_article_id3 = 0  AND id > 971090 order by id";
            $connection = $em->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();
        } else {

            $query = $em->createQuery(
                    "SELECT  p.id
                        FROM " . $this->repository . " p, EdiBundle:Edi e
                        where 
                            e.id = p.Edi AND p.tecdocArticleId IS NULL AND p.dlnr > 0 order by p.id desc"
            );
            $results = $query->getResult();
        }
        /*
         * \
          $query = $em->createQuery(
          "SELECT  p.id
          FROM " . $this->repository . " p, EdiBundle:Edi e
          where
          e.id = p.Edi AND p.dlnr > 0 order by p.id asc"
          );
         * 
         */


        echo "[".count($results)."]";
        $i = 0;
        $tecdoc = new Tecdoc();
        foreach ($results as $result) {
            //if ($result["id"] > 64889) {
            $ediediitem = $em->getRepository($this->repository)->find($result["id"]);
            //$ediediitem->tecdoc = $tecdoc;
            $ediediitem->updatetecdoc();
            unset($ediediitem);
            echo $result["id"] . "<BR>";
            //if ($i++ > 3000)
            //    exit;
            //}
        }
        exit;
    }

    public function ediitemdatatable($funct = false, $id = false) {
        ini_set("memory_limit", "14096M");
        $request = Request::createFromGlobals();


        $recordsTotal = 0;
        $recordsFiltered = 0;
        //$this->q_or = array();
        //$this->q_and = array();

        $s = array();
        if ($request->request->get("length")) {
            $em = $this->getDoctrine()->getManager();

            $doctrineConfig = $em->getConfiguration();
            $doctrineConfig->addCustomStringFunction('FIELD', 'DoctrineExtensions\Query\Mysql\Field');

            $dt_order = $request->request->get("order");
            $dt_search = $request->request->get("search");
            $articles = unserialize(base64_decode($dt_search["value"]));
            $dt_columns = $request->request->get("columns");

            $search = explode(":", $dt_columns[4]["search"]["value"]);

            if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                //print_r(unserialize(base64_decode($dt_search["value"])));
            }

            $search11 = explode(":", $dt_search["value"]);
            if ($search11[0] != 'productfano') {
                if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                    $articleIds = count($articles["edimatched"]) ? $articles["edimatched"] : (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
                    $articleIds[] = 1;
                } else {
                    $articleIds = count($articles["edimatched"]) ? $articles["edimatched"] : (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
                    $articleIds[] = 1;
                }
            } else {
                $search11[1] = str_pad($search11[1], 4, "0", STR_PAD_LEFT);
            }



            // print_r($search11);
            $dt_search["value"] = '';

            $recordsTotal = $em->getRepository($this->repository)->recordsTotal();
            $fields = array();
            foreach ($this->fields as $index => $field) {
                if (@$field["index"]) {
                    $fields[] = $field["index"];
                    $field_relation = explode(":", $field["index"]);
                    if (count($field_relation) == 1) {
                        if ($this->clearstring($dt_search["value"]) != "") {
                            $this->q_or[] = $this->prefix . "." . $field["index"] . " LIKE '%" . $this->clearstring($dt_search["value"]) . "%'";
                        }
                        if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "") {
                            $this->q_and[] = $this->prefix . "." . $this->fields[$index]["index"] . " LIKE '%" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "%'";
                        }
                        $s[] = $this->prefix . "." . $field_relation[0];
                    } else {
                        if ($dt_search["value"] === true) {
                            if ($this->clearstring($dt_search["value"]) != "") {
                                $this->q_or[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_search["value"]) . "'";
                            }
                        }
                        if (@$this->clearstring($dt_columns[$index]["search"]["value"]) != "") {
                            $field_relation = explode(":", $this->fields[$index]["index"]);
                            $this->q_and[] = $this->prefix . "." . $field_relation[0] . " = '" . $this->clearstring($dt_columns[$index]["search"]["value"]) . "'";
                            //$s[] = $this->prefix . "." . $field_relation[0];  
                        }
                    }
                }
            }


            $this->createOrderBy($fields, $dt_order);
            $this->createSelect($s);
            $select = count($s) > 0 ? implode(",", $s) : $this->prefix . ".*";


            //$articles["articleIds"][] = 2556734;
            //print_r($articles["articleIds"]);
            $this->createWhere();
            $edi = $dt_columns[1]["search"]["value"];
            if (count($articleIds)) {

                //$edi = $em->getRepository("EdiBundle:Edi")->find(1);
                //$this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".partno != '' AND ((" . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".artNr = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";

                if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                    if ($search11[0] == 'productfano') {
                        $this->where = " where " . $this->prefix . ".itemCode LIKE '" . $search[1] . "%'))";
                    } else {
                        if ($search[1])
                            $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".partno != '' AND ((" . $this->prefix . ".tecdocArticleId3 in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".artNr = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";
                        else
                            $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".tecdocArticleId3 in (" . (implode(",", $articleIds)) . ")";
                        //$this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".artNr != '' AND " . $this->prefix . ".partno != '' AND ((" . $this->prefix . ".tecdocArticleId3 in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".artNr = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";
                    }

                    //echo $this->where;
                    //exit;
                } else {
                    if ($search11[0] == 'productfano') {
                        $this->where = " where " . $this->prefix . ".itemCode LIKE '" . $search[1] . "%'))";
                    } else {
                        if ($search[1])
                            $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".partno != '' AND ((" . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".artNr = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";
                        else
                            $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ")";
                        //$this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".artNr != '' AND " . $this->prefix . ".partno != '' AND ((" . $this->prefix . ".tecdocArticleId3 in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".artNr = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";
                    }
                }


                /*
                  if ($search[1]) {
                  $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND ((" . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '" . $search[1] . "' OR " . $this->prefix . ".itemCode = '" . $search[1] . "'))";
                  } else {
                  $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND (" . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ")";
                  }
                 */
            } else {
                if ($search11[0] == 'productfano') {
                    $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND " . $this->prefix . ".itemCode LIKE '" . $search11[1] . "%'";
                } else {
                    $this->createWhere();
                }
            }

            //echo $this->where."\n\n";
            $recordsFiltered = $em->getRepository($this->repository)->recordsFiltered($this->where);

            $query = $em->createQuery(
                            'SELECT  ' . $this->select . '
                                FROM ' . $this->repository . ' ' . $this->prefix . '
                                ' . $this->where . '
                                ORDER BY ' . $this->orderBy
                    )
                    ->setMaxResults($request->request->get("length"))
                    ->setFirstResult($request->request->get("start"));
            $results = $query->getResult();
            //if (count($results) > 1000) return;
        }
        $data["fields"] = $this->fields;
        $jsonarr = array();
        $r = explode(":", $this->repository);

        foreach (@(array) $results as $result) {
            $json = array();
            $obj = $em->getRepository($this->repository)->find($result["id"]);
            foreach ($data["fields"] as $field) {
                if (@$field["index"]) {
                    $field_relation = explode(":", $field["index"]);
                    if (count($field_relation) > 1) {
                        //echo $this->repository;
                        //$obj = $em->getRepository($this->repository)->find($result["id"]);
                        foreach ($field_relation as $relation) {
                            if ($obj)
                                $obj = $obj->getField($relation);
                        }
                        $val = $obj;
                    } else {
                        $val = $result[$field["index"]];
                    }
                    if (@$field["method"]) {
                        $method = $field["method"] . "Method";
                        $json[] = $this->$method($val);
                    } else {
                        if (@$field["input"]) {
                            $json[] = "<input id='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "_" . $result["id"] . "' data-id='" . $result["id"] . "' class='" . str_replace(":", "", $this->repository) . ucfirst($field["index"]) . "' type='" . $field["input"] . "' value='" . $val . "'>";
                        } else {
                            $json[] = $val;
                        }
                    }
                } elseif (@$field["function"]) {
                    $func = $field["function"];
                    $obj = $em->getRepository($this->repository)->find($result["id"]);
                    $json[] = $obj->$func(count($results));
                }
            }



            $sql = "Select id from softone_product where replace(replace(replace(replace(replace(`item_cccref`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $this->clearstring($obj->getItemCode()) . "' AND item_mtrsup = '" . $obj->getEdi()->getItemMtrsup() . "'";
            if ($this->getSetting("AppBundle:Erp:erpprefix") == '/erp01') {
                $sql = "Select id from megasoft_product where replace(replace(replace(replace(replace(`supplier_item_code`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $this->clearstring($obj->getItemCode()) . "' AND supplier = '" . $obj->getEdi()->getItemMtrsup() . "'";
            }
            //echo $sql . "<BR>";
            $connection = $em->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $refdata = $statement->fetch();


            $prd = $refdata["id"] > 0 ? ' bold ' : '';
            $json["DT_RowClass"] = $prd . "dt_row_" . strtolower($r[1]);

            $json["DT_RowId"] = 'dt_id_' . strtolower($r[1]) . '_' . $result["id"];
            $jsonarr[] = $json;
        }
        
        if ($funct) {
            $jsonarrnoref = array();
            if (count($jsonarr)) {
                $jsonarr = $this->$funct($jsonarr, $id);
                $jsonarr = array_merge($jsonarr, $jsonarrnoref);
            }
        }

        $data["data"] = $jsonarr;
        $data["recordsTotal"] = $recordsTotal;
        $data["recordsFiltered"] = $recordsFiltered;
        return json_encode($data);
    }

    protected $SoapClient = false;
    protected $Username = '';
    protected $Password = '';
    protected $CustomerNo = '';
    protected $SoapUrl = '';
    protected $SoapNs = '';

    protected function eltekaAuth() {

        $this->SoapUrl = $this->getSetting("EdiBundle:Eltreka:SoapUrl");
        $this->SoapNs = $this->getSetting("EdiBundle:Eltreka:SoapNs");
        $this->Username = $this->getSetting("EdiBundle:Eltreka:Username");
        $this->Password = $this->getSetting("EdiBundle:Eltreka:Password");
        $this->CustomerNo = $this->getSetting("EdiBundle:Eltreka:CustomerNo");

        if ($this->SoapClient) {
            return $this->SoapClient;
        }

        $this->SoapClient = new \SoapClient($this->SoapUrl);
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($this->SoapNs, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        //$session->set('SoapClient', $this->SoapClient);
        return $this->SoapClient;
    }

    function getEltrekaQtyAvailability($itemCode) {
        //return;
        /*
          $url = "http://b2bnew.lourakis.gr/antallaktika/init/geteltrekaavailability";
          $fields = array(
          'appkey' => 'bkyh69yokmcludwuu2',
          'partno' => $itemCode,
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          @$fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $out = json_decode(curl_exec($ch));
          print_r($out);
         * ?
         *
         */
        return unserialize(file_get_contents("http://b2bnew.lourakis.gr/antallaktika/init/geteltrekaavailability?itemCode=" . $itemCode));
        //return $out;        
    }

    function setEdiQtyAvailability($jsonarr, $id = 0) {
        $limit = 25;
        $vat = 1.24;
        //return;
        //return $jsonarr;
        $datas = array();
        //print_r($jsonarr);

        if ($this->getSetting("AppBundle:Erp:erpprefix") == '/erp01') {
            $order = $this->getDoctrine()
                    ->getRepository("MegasoftBundle:Order")
                    ->find($id);
        } else {
            $order = $this->getDoctrine()
                    ->getRepository("SoftoneBundle:Order")
                    ->find($id);
        }

        $customer = $order->getCustomer();
        if ($customer->getCustomerTrdcategory() == 3001) {
            $vat = 1.17;
        }
        if ($customer->getCustomerTrdcategory() == 3003) {
            $vat = 1;
        }
        $request = Request::createFromGlobals();
        $dt_columns = $request->request->get("columns");
        if ($dt_columns[1]["search"]["value"] == 4) {
            foreach ((array) $this->getEltrekaQtyAvailability($dt_columns[4]["search"]["value"]) as $data) {
                $eltrekaavailability[$data["erp_code"]] = $data["apothema"];
            }
            $elteka = $this->eltekaAuth();
        }

        if (count($jsonarr) >= $limit * 5 OR count($jsonarr) == 0)
            return $jsonarr;




        //return;
        $i = 0;
        $k = 0;
        foreach ($jsonarr as $key => $json) {
            if ($i++ % $limit == 0) {
                $k++;
            }
            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->find($json[0]);
            if ($entity->getEdi()->getFunc() == 'getGbgEdiPartMaster') { // is viakar, liakopoulos
                $zip = new \ZipArchive;
                if ($zip->open('/home2/partsbox/OUTOFSTOCK_ATH.ZIP') === TRUE) {
                    $zip->extractTo('/home2/partsbox/');
                    $zip->close();
                    $file = "/home2/partsbox/OUTOFSTOCK_ATH.txt";
                    $availability = false;
                    if (($handle = fopen($file, "r")) !== FALSE) {
                        //echo 'sss';
                        while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                            if ($data[0] == $entity->getItemcode()) {
                                if ($data[1] == 1)
                                    $availability = true;
                                break;
                            }
                        }
                    }
                }

                $entities[$entity->getItemcode()] = $entity;
                @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
                @$jsonarr[$key]['DT_RowClass'] .= $availability ? ' text-success ' : ' text-danger ';
            } elseif ($entity->getEdi()->getFunc() == 'getEdiPartMaster') { // is viakar, liakopoulos
                if (@!$datas[$entity->getEdi()->getId()][$k]) {
                    $datas[$entity->getEdi()->getId()][$k]['ApiToken'] = $entity->getEdi()->getToken();
                    $datas[$entity->getEdi()->getId()][$k]['Items'] = array();
                }
                $Items[$entity->getEdi()->getId()][$k]["ItemCode"] = $entity->getItemcode();
                $Items[$entity->getEdi()->getId()][$k]["ReqQty"] = 1;
                $datas[$entity->getEdi()->getId()][$k]['Items'][] = $Items[$entity->getEdi()->getId()][$k];

                $ands[$entity->getItemcode()] = $key;
                $entities[$entity->getItemcode()] = $entity;
            } elseif ($entity->getEdi()->getFunc() == 'getFibaEdiPartMaster') {
                $AvailabilityDetailsHtml = '';
                $entity->setFibaSoap();
                if ($entity->soapStock >= 1) {
                    $availability = "Y";
                }
                @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
                @$jsonarr[$key]['7'] = number_format((float) $entity->soapPrice, 2, '.', '');
                @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
                @$jsonarr[$key]['DT_RowClass'] .= $availability == "Y" ? ' text-success ' : ' text-danger ';
            } elseif ($entity->getEdi()->getFunc() == 'getComlineEdiPartMaster') {
                $entity->setComlineSoap();
                $AvailabilityDetailsHtml = '';
                $availability = '';
                $apoth = "";
                $AvailabilityDetailsHtml = $entity->soapStock . "," . $entity->soapAvail1 . "," . $entity->soapAvail2;
                if ($entity->soapStock >= 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                    $availability = "Y";
                }

                if ($entity->soapStock < 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                    $AvailabilityDetailsHtml = "Μη Διαθέσιμο&nbsp;";
                    //psColor = "Orange";
                    //$qty = "<img title='Μη Διαθέσιμο' alt='Μη Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Μη Διαθέσιμο".$apoth;
                } else if ($entity->soapStock >= 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                    $AvailabilityDetailsHtml = "&nbsp;Διαθέσιμο&nbsp;";
                    $availability = "Y";
                    //psColor = "Green";
                    //$qty = "<img title='Διαθέσιμο' alt='Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/diathesimo.png'><br>Διαθέσιμο ".$apoth;
                } else if ($entity->soapStock <= 0 && $entity->soapAvail1 > 0) {
                    $AvailabilityDetailsHtml = "&nbsp;Μη Διαθέσιμο&nbsp;";
                    //psColor = "Red";
                    //$qty = "<img title='Μη Διαθέσιμο' alt='Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/midiathesimo.png'><BR>Μη Διαθέσιμο".$apoth;
                } else if ($entity->soapStock > 0 && $entity->soapStock <= $entity->soapAvail1 && $entity->soapAvail1 > 0) {
                    $AvailabilityDetailsHtml = "&nbsp;Χαμηλή&nbsp;";
                    $availability = "Y";
                    //psColor = "Orange";
                    //$qty = "<img title='Χαμηλή' alt='Χαμηλή' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Χαμηλή".$apoth;
                } else if ($entity->soapStock > $entity->soapAvail1 && $entity->soapStock <= $entity->soapAvail2 && $entity->soapAvail1 > 0) {
                    $AvailabilityDetailsHtml = "&nbsp;Μεσαία&nbsp;";
                    $availability = "Y";
                    //psColor = "DodgerBlue";
                    //$qty = "<img title='Μεσαία' alt='Μεσαία' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Μεσαία".$apoth;
                } else if ($entity->soapStock > $entity->soapAvail2 && $entity->soapAvail2 > 0) {
                    $AvailabilityDetailsHtml = "&nbsp;Πλήρης&nbsp;";
                    $availability = "Y";
                    //psColor = "Green";
                    //$qty = "<img title='Πλήρης' alt='Πλήρης' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/diathesimo.png'><BR>Πλήρης".$apoth;
                }




                @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
                @$jsonarr[$key]['7'] = number_format((float) $entity->soapPrice, 2, '.', '');
                @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
                @$jsonarr[$key]['DT_RowClass'] .= $availability == "Y" ? ' text-success ' : ' text-danger ';
            } elseif ($entity->getEdi()->getFunc() == 'getRaskosEdiPartMaster') {

                $json = file_get_contents("http://actedi.actae.gr/PartInfo/api/ActPriceAndAvail/c9ff4c75-2ef9-4dbd-9708-f8175d441f96/" . $entity->getItemCode());

                $ed = json_decode($json);

                $AvailabilityDetailsHtml = ""; //$json;//print_r($ed,true);
                if ($ed[0]->price > 0) {
                    $entity->getWholesaleprice($ed[0]->price);
                }
                @$jsonarr[$key]['6'] = ""; //$entity->getDiscount($customer, $vat);
                @$jsonarr[$key]['7'] = number_format((float) $entity->getWholesaleprice(), 2, '.', '');
                @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
                @$jsonarr[$key]['DT_RowClass'] .= $ed[0]->avail == "green" ? ' text-success ' : ' text-danger ';
            } else {
                
                /*
                  @$jsonarr[$key]['DT_RowClass'] .= $eltrekaavailability[$entity->getItemcode()] > 0 ? ' text-success ' : ' text-danger ';

                  $response = $elteka->getPartPrice(array('CustomerNo' => $this->CustomerNo, "EltrekkaRef" => $entity->getItemcode()));
                  $xml = $response->GetPartPriceResult->any;
                  $xml = simplexml_load_string($xml);
                  $price = (float) $xml->Item->PriceOnPolicy;
                  //echo "---".$xml->Item->WholePrice."\n";
                  @$jsonarr[$key]['6'] = number_format($price, 2, '.', '');
                  @$jsonarr[$key]['DT_RowClass'] .= $xml->Item->Header->Available == "Y" ? ' text-success ' : ' text-danger ';
                 */
                //if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
                    
                //} else
                if (count($jsonarr) < 50) {
                    $response = $elteka->getAvailability(
                            array('CustomerNo' => $this->CustomerNo,
                                "RequestedQty" => 1,
                                "EltrekkaRef" => $entity->getItemcode()));
                    $xml = $response->GetAvailabilityResult->any;
                    $xml = simplexml_load_string($xml);
                    $AvailabilityDetailsHtml = "<select data-id='" . $entity->getId() . "' class='edistore' id='store_" . $entity->getId() . "' style=''>";
                    $asd = (array) $xml->Item;
                    
                    
                    
                    foreach ((array) $asd["AvailabilityDetails"] as $details) {
                        if ($details->IsAvailable == 'Y') {
                            $selected = (int) $xml->Item->Header->SUGGESTED_STORE == (int) $details->StoreNo ? "selected" : "";
                            $AvailabilityDetailsHtml .= "<option " . $selected . " value='" . $details->StoreNo . "' style='color:green'>" . $details->StoreNo . "</option>";
                        } else {
                            $AvailabilityDetailsHtml .= "<option value='" . $details->StoreNo . "' style='color:red'>" . $details->StoreNo . " (" . $details->EstimatedBODeliveryTime . ")</option>";
                        }
                    }
                    $AvailabilityDetailsHtml .= "</select>";

                    //print_r($xml->Item->Header);
                    
                    $entity->setWholesaleprice($xml->Item->Header->WholePrice);
                    @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
                    @$jsonarr[$key]['7'] = number_format((float) $xml->Item->Header->WholePrice, 2, '.', '') . " / " . number_format((float) $xml->Item->Header->PriceOnPolicy, 2, '.', '');
                    @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
                    @$jsonarr[$key]['DT_RowClass'] .= $xml->Item->Header->Available == "Y" ? ' text-success ' : ' text-danger ';
                }
            }
            @$jsonarr[$key]['9'] = $entity->getQty2();
            //$jsonarr2[(int)$key] = $json;
            @$jsonarr[$key]['DT_RowClass'] .= ' text-danger ';
        }
        if (count($datas)) {
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            foreach ($datas as $catalogue => $packs) {
                foreach ($packs as $k => $data) {
                    $data_string = json_encode($data);

                    //continue;
                    $result = file_get_contents($requerstUrl, null, stream_context_create(array(
                        'http' => array(
                            'method' => 'POST',
                            'header' =>
                            'Content-Type: application/json' . "\r\n"
                            . 'Content-Length: ' . strlen($data_string) . "\r\n",
                            'content' => $data_string,
                        ),
                    )));
                    $re = json_decode($result);

                    //print_r($re);
                    if (@count($re->Items)) {
                        foreach ($re->Items as $Item) {
                            $qty = $Item->Availability == 'green' ? 100 : 0;
                            $Item->UnitPrice;

                            //echo $Item->ItemCode."\n";
                            if (@$jsonarr[$ands[$Item->ItemCode]]) {
                                $entity = $entities[$Item->ItemCode];
                                //if ()
                                $entity->setWholesaleprice($Item->ListPrice);

                                @$jsonarr[$ands[$Item->ItemCode]]['6'] = $entity->getDiscount($customer, $vat);
                                @$jsonarr[$ands[$Item->ItemCode]]['7'] = number_format($Item->ListPrice, 2, '.', '') . " / " . number_format($Item->UnitPrice, 2, '.', '');
                                @$jsonarr[$ands[$Item->ItemCode]]['9'] = $entity->getQty2();

                                //$entity->setRetailprice(number_format($Item->UnitPrice, 2, '.', ''));
                                //$this->flushpersist($entity);
                                //echo $Item->Availability;    
                                if ($Item->Availability == 'green') {

                                    @$jsonarr[$ands[$Item->ItemCode]]['DT_RowClass'] .= ' text-success ';
                                }
                            }
                        }
                    }
                }
            }
        }


        //print_r($jsonarr);
        return $jsonarr;
        /*
          if (round($this->retail,2) != round($Item->UnitPrice,2)) {
          $this->retail = $Item->UnitPrice;
          $this->retail_special = $Item->UnitPrice;
          $out["Availability"] = $Item->Availability;
          $this->fretail = $this->retail * (1+($this->markup/100)) + $this->markupplus;
          $this->fretail_special  = $this->retail_special * (1+($this->markup/100)) + $this->markupplus;
          $this->fretail_special = $this->fretail_special > 0 ? $this->fretail_special : $this->fretail;
          $this->updated == 0;
          $this->save();
          $this->updateProduct();
          }
         */
    }

    public function getArticlesSearchByIds($search) {
        //if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //$data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //return $data;
        //} else {
        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          $fields = array(
          'action' => 'getSearchByIds',
          'search' => $search
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
          //file_put_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term", $data);
         */
        $params = array(
            'search' => $search
        );
        $tecdoc = new Tecdoc();
        $data = $tecdoc->getArticlesSearchByIds($params);
        return $data->data->array;

        //return $data;
        //}
    }

    public function getArticlesSearch($search) {
        // if (file_exists(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term")) {
        //    $data = file_get_contents(Yii::app()->params['root'] . "cache/terms/" . md5($search) . ".term");
        //   return $data;
        //} else {
        //ADBRP002
        /*
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          $fields = array(
          'action' => 'getSearch',
          'search' => $search
          );
          $fields_string = '';
          foreach ($fields as $key => $value) {
          $fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = curl_exec($ch);
          return $data;
         */
        //}
        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            $articleIds = array();
            $term = preg_replace("/[^a-zA-Z0-9]+/", "", $search);
            $sql = "SELECT art.art_id as articleId FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."'))";			
            $url = "http://magento2.fastwebltd.com/service.php";
            //$datas = unserialize(file_get_contents($url)); 
            $datas = unserialize($this->curlit($url, "sql=" . base64_encode($sql)));
            foreach($datas as $data) {
                if ($data["articleId"]) {
                    $articleIds[] = $data["articleId"]; 
                }
            }
            return serialize($articleIds);
            //print_r($articleIds);
        }        
        $tecdoc = new Tecdoc();
        $articles = $tecdoc->getArticlesSearch(array('search' => $this->clearstring($search)));
        //print_r($articles);
        //echo $search;
        foreach ($articles->data->array as $v) {
            $articleIds[] = $v->articleId;
        }
        return serialize($articleIds);
    }
    function curlit($url, $fields_string) {
        rtrim($fields_string, '&');
        $ch = curl_init();
        //echo $fields_string."\n";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $datas = curl_exec($ch);
        //echo $datas;
        //exit;
        return $datas;
    }
    /**
     * @Route("/edi/ediitem/install")
     */
    public function installAction(Request $request) {
        $this->install();
        $this->getPartMaster();
    }

    /**
     * @Route("/edi/ediitem/getEdiMarkup")
     */
    public function getEdiMarkupAction(Request $request) {



        $jsonarr = json_decode($request->getContent(), true);


        $edi = $this->getDoctrine()
                ->getRepository('EdiBundle:Edi')
                ->findOneBy(array("itemMtrsup" => $jsonarr["mtrsup"]));
        if ($edi) {
            $ediItem = $this->getDoctrine()
                    ->getRepository('EdiBundle:EdiItem')
                    ->findOneBy(array('Edi' => $edi, 'itemCode' => $jsonarr["itemcode"]));
            if ($ediItem) {
                //$jsonarr["itemcode"] = $itemcode;
                $pricer = $jsonarr["pricer"] != '' ? $jsonarr["pricer"] : "itemPricer";
                $pricew = $jsonarr["pricew"] != '' ? $jsonarr["pricew"] : "itemPricew";

                $jsonarr["markupr"] = (double) $ediItem->getEdiMarkup($pricer);
                $jsonarr["markupw"] = (double) $ediItem->getEdiMarkup($pricew);
                //$jsonarr["rules"] = $ediItem->getRulesss($pricew);

                $jsonarr["pricer"] = $pricer;
                $jsonarr["pricew"] = $pricew;

                $jsonarr["edi"] = $edi->getId();
            }
        }
        $json = json_encode($jsonarr);
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
