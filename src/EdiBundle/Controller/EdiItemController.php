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
        ini_set('memory_limit', '1256M');
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
                ->addField(array("name" => "Price", "index" => 'retailprice', 'search' => 'text'))

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
            $articleIds = (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
            @$articleIds2 = unserialize(base64_decode($search[1]));
            $articleIds = array_merge((array) $articleIds, (array) $articleIds2["matched"], (array) $articleIds2["articleIds"]);
            $articleIds[] = 1;
            $query = $em->createQuery(
                    "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND
                        (p.partno LIKE '%" . $search[1] . "%' OR p.itemCode LIKE '%" . $search[1] . "%' OR p.tecdocArticleId in (" . implode(",", $articleIds) . ")) "
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





        //echo "(p.partno LIKE '%" . $search[1] . "%' OR p.tecdocArticleId in (" . implode(",", $articleIds) . ")) ";
        $results = $query->getResult();
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
                ->addField(array("name" => "Price", "index" => 'retailprice', 'search' => 'text'))
                ->addField(array("name" => "ID", "function" => 'getQty1', "active" => "active"))
                ->addField(array("name" => "ID", "function" => 'getQty2', "active" => "active"))


        ;
        $json = $this->ediitemdatatable('setEdiQtyAvailability');

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/ediitem/updatetecdoc")
     */
    public function getUpdateTecdocAction($funct = false) {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQuery(
                "SELECT  p.id
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.tecdocArticleId IS NULL AND p.dlnr > 0  order by p.id asc"
        );
        /*
        $query = $em->createQuery(
                "SELECT  p.id
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND p.dlnr > 0 order by p.id asc"
        );
         * 
         */
        
        $results = $query->getResult();
        echo count($results);
        $i = 0;
        $tecdoc = new Tecdoc();
        foreach ($results as $result) {
            if ($result["id"] > 269741) {
                $ediediitem = $em->getRepository($this->repository)->find($result["id"]);
                $ediediitem->tecdoc = $tecdoc;
                $ediediitem->updatetecdoc();
                unset($ediediitem);
                echo $result["id"]."<BR>";
            }
            
            if ($i++ > 300) exit;
        }
        exit;
    }
    

    public function ediitemdatatable($funct = false) {
        ini_set("memory_limit", "1256M");
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

            $articleIds = count($articles["articleIds"]) ? $articles["articleIds"] : (array) unserialize($this->getArticlesSearch($this->clearstring($search[1])));
            $articleIds[] = 1;



            //print_r(base64_decode($dt_search["value"]));
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
            if (count($articleIds)) {
                $edi = $dt_columns[1]["search"]["value"];

                //$edi = $em->getRepository("EdiBundle:Edi")->find(1);
                $this->where = " where " . $this->prefix . ".Edi = '" . $edi . "' AND ((" . $this->prefix . ".tecdocArticleId in (" . (implode(",", $articleIds)) . ") OR " . $this->prefix . ".partno = '".$search[1]."' OR " . $this->prefix . ".itemCode = '".$search[1]."'))";
            } else {
                $this->createWhere();
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
            $prd = $obj->getProduct() > 0 ? ' bold ' : '';
            $json["DT_RowClass"] = $prd . "dt_row_" . strtolower($r[1]);

            $json["DT_RowId"] = 'dt_id_' . strtolower($r[1]) . '_' . $result["id"];
            $jsonarr[] = $json;
        }
        if ($funct) {
            $jsonarrnoref = array();
            if (count($jsonarr)) {
                $jsonarr = $this->$funct($jsonarr);
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

    function setEdiQtyAvailability($jsonarr) {
        $limit = 25;
        //return;
        //return $jsonarr;
        $datas = array();
        //print_r($jsonarr);

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
            if (strlen($entity->getEdi()->getToken()) == 36) { // is viakar, liakopoulos
                if (@!$datas[$entity->getEdi()->getId()][$k]) {
                    $datas[$entity->getEdi()->getId()][$k]['ApiToken'] = $entity->getEdi()->getToken();
                    $datas[$entity->getEdi()->getId()][$k]['Items'] = array();
                }
                $Items[$entity->getEdi()->getId()][$k]["ItemCode"] = $entity->getPartno();
                $Items[$entity->getEdi()->getId()][$k]["ReqQty"] = 1;
                $datas[$entity->getEdi()->getId()][$k]['Items'][] = $Items[$entity->getEdi()->getId()][$k];

                $ands[$entity->getPartno()] = $key;
            } else {
                @$jsonarr[$key]['DT_RowClass'] .= $eltrekaavailability[$entity->getItemcode()] > 0 ? ' text-success ' : ' text-danger ';
                /*
                  $response = $elteka->getPartPrice(array('CustomerNo' => $this->CustomerNo, "EltrekkaRef" => $entity->getItemcode()));
                  $xml = $response->GetPartPriceResult->any;
                  $xml = simplexml_load_string($xml);
                  $price = (float) $xml->Item->PriceOnPolicy;
                 */

                //echo "---".$xml->Item->WholePrice."\n";
                //@$jsonarr[$key]['6'] = number_format($price, 2, '.', '');
                /*
                  $response = $elteka->getAvailability(
                  array('CustomerNo' => $this->CustomerNo,
                  "RequestedQty" => 1,
                  "EltrekkaRef" => $entity->getItemcode()));
                  $xml = $response->GetAvailabilityResult->any;
                  $xml = simplexml_load_string($xml);
                  @$jsonarr[$key]['6'] = number_format((float) $xml->Item->Header->PriceOnPolicy, 2, '.', '');
                  @$jsonarr[$key]['DT_RowClass'] .= $xml->Item->Header->Available == "Y" ? ' text-success ' : ' text-danger ';
                 * 
                 */
            }
            //$jsonarr2[(int)$key] = $json;
            @$jsonarr[$key]['DT_RowClass'] .= ' text-danger ';
        }
        if (count($datas)) {
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            foreach ($datas as $catalogue => $packs) {
                foreach ($packs as $k => $data) {
                    $data_string = json_encode($data);
                    //print_r($data);
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
                    //continue;
                    if (@count($re->Items)) {
                        foreach ($re->Items as $Item) {
                            $qty = $Item->Availability == 'green' ? 100 : 0;
                            $Item->UnitPrice;
                            //echo $Item->ItemCode."\n";
                            if (@$jsonarr[$ands[$Item->ItemCode]]) {
                                @$jsonarr[$ands[$Item->ItemCode]]['6'] = number_format($Item->UnitPrice, 2, '.', '');
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
        $tecdoc = new Tecdoc();
        $articles = $tecdoc->getArticlesSearch(array('search' => $this->clearstring($search)));
        //print_r($articles);
        //echo $search;
        foreach ($articles->data->array as $v) {
            $articleIds[] = $v->articleId;
        }
        return serialize($articleIds);
    }

    /**
     * @Route("/edi/ediitem/install")
     */
    public function installAction(Request $request) {
        $this->install();
        $this->getPartMaster();
    }

}
