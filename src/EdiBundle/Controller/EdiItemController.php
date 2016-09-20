<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\EdiItem;
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
            print_r($attrs);
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




        $query = $em->createQuery(
                "SELECT  distinct(e.id) as eid, e.name as edi
                    FROM " . $this->repository . " p, EdiBundle:Edi e
                    where 
                        e.id = p.Edi AND
                        p.partno LIKE '%" . $request->request->get("terms") . "%'"
        );
        $results = $query->getResult();
        $html .= '<button type="button" class="edibutton btn btn-raised ink-reaction" data-id="0">Invetory</button>';
        $edi = array();
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

        ;
        $json = $this->datatable('setEdiQtyAvailability');

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    function setEdiQtyAvailability($jsonarr) {
        //return;
        //return $jsonarr;
        $datas = array();
        foreach ($jsonarr as $key => $json) {

            $entity = $this->getDoctrine()
                    ->getRepository($this->repository)
                    ->find($json[0]);

            if (@!$datas[$entity->getEdi()->getId()]) {
                $datas[$entity->getEdi()->getId()]['ApiToken'] = $entity->getEdi()->getToken();
                $datas[$entity->getEdi()->getId()]['Items'] = array();
            }
            $Items[$entity->getEdi()->getId()]["ItemCode"] = $entity->getPartno();
            $Items[$entity->getEdi()->getId()]["ReqQty"] = 1;
            $datas[$entity->getEdi()->getId()]['Items'][] = $Items[$entity->getEdi()->getId()];
            $ands[$entity->getPartno()] = $key;
            //$jsonarr2[(int)$key] = $json;
        }
        //print_r($datas);
        //print_r($datas);
        $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
        //$data_string = '{ "ApiToken": "b5ab708b-0716-4c91-a8f3-b6513990fe3c", "Items": [ { "ItemCode": "' . $this->erp_code . '", "ReqQty": 1 } ] } ';
        //return 10;


        foreach ($datas as $catalogue => $data) {
            $data_string = json_encode($data);
            //print_r($data);
            //turn;
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

            //print_r($jsonarr2);
            //return;
            if (@count($re->Items))
                foreach ($re->Items as $Item) {
                    $qty = $Item->Availability == 'green' ? 100 : 0;
                    $Item->UnitPrice;
                    //echo $Item->ItemCode."\n";
                    if (@$jsonarr[$ands[$Item->ItemCode]])
                        @$jsonarr[$ands[$Item->ItemCode]]['6'] = number_format($Item->UnitPrice, 2, '.', '');
                }
        }
        print_r($jsonarr);
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

    /**
     * @Route("/edi/ediitem/install")
     */
    public function installAction(Request $request) {
        $this->install();
        $this->getPartMaster();
    }

}
