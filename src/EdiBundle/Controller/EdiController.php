<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\Edi as Edi;
use EdiBundle\Entity\Eltrekaedi;
use AppBundle\Controller\Main as Main;

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
        $Edi = $this->getDoctrine()
                ->getRepository('EdiBundle:Edi')
                ->find($id);
        return $this->render('EdiBundle:Edi:view.html.twig', array(
                    'pagename' => 'Edis',
                    'url' => '/edi/edi/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/edi/save")
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
        $this->createSelect(array($this->prefix . ".token", $this->prefix . ".func", $this->prefix . ".id"));
        $collection = $this->collection($this->repository);
        $i = 0;
        foreach ($collection as $entity) {
            if ($i++ <= 1) continue;
            $func = $entity["func"];
            $this->$func($entity);
        }
        exit;
    }

    public function getEdiPartMaster($entity) {
        //echo $this->getPartMaster();
        //return;
        $apiToken = $entity["token"];
        echo $apiToken . "<BR>";
        return;
        $file = "/home2/partsbox/".$apiToken . '.csv';
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
                $attrs[$key] = strtolower($attr);
            }
            print_r($attrs);
            $i = 0;
            while ($data = fgetcsv($handle, 1000, "\t")) {
                //if ($i++ == 0) continue;
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = trim(addslashes($val));
                }

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
                echo @$ediediitem->id . "<BR>";
                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$ediedi_id = (int) $ediediitem->id;
                if (@$ediedi_id == 0) {
                    $sql = "replace edi_item set id = '" . $ediedi_id . "', edi='" . $entity["id"] . "', " . implode(",", $q);
                    $em->getConnection()->exec($sql);
                    $ediediitem = $this->getDoctrine()
                            ->getRepository('EdiBundle:EdiItem')
                            ->findOneBy(array("itemCode" => $attributes["itemcode"], "Edi" => $ediedi));
                }
                $ediediitem->updatetecdoc();
                //if ($i++ > 6000) exit;
            }
        }
    }

    public function getEltrekaPartMaster($entity) {
        return;
        set_time_limit(100000);
        $eltrekaedi = new Eltrekaedi();
        $file = $eltrekaedi->getPartMasterFile();
        //$file = 'http://195.144.16.7/EltrekkaEDI/Temp/Parts/RE4V1G9V.txt';
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            $i = 0;
            while ($data = fgetcsv($handle, 100000, "\t")) {
                //if ($i++ < 130000) continue;
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = trim(addslashes($val));
                }
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
                    $sql = "replace edi_item set "
                            . "id = '" . $ediedi_id . "', "
                            . "edi='" . $entity["id"] . "', "
                            . "itemcode='" . $attributes["partno"] . "', "
                            . "brand='" . $attributes["supplierdescr"] . "', "
                            . "partno='" . $attributes["factorypartno"] . "', "
                            . "description='" . $attributes["description"] . "', "
                            . "dlnr='" . $attributes["tecdocsupplierno"] . "', "
                            . "artnr='" . $attributes["tecdocpartno"] . "', "
                            . "retailprice='" . $attributes["retailprice"] . "'";
                    $em->getConnection()->exec($sql);
                    //echo $sql."<BR>";
                    $ediediitem = $this->getDoctrine()
                            ->getRepository('EdiBundle:EdiItem')
                            ->findOneBy(array("itemCode" => $attributes["partno"], "Edi" => $ediedi));
                    @$ediedi_id = (int) $ediediitem->id;
                }
                $ediediitem->updatetecdoc();

                $eltrekaedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Eltrekaedi')
                        ->findOneByPartno($attributes["partno"]);

                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$eltrekaedi_id = (int) $eltrekaedi->id;
                //if ($eltrekaedi_id == 0) {
                $sql = "replace eltrekaedi set id = '" . $eltrekaedi_id . "', ediitem = '" . $ediedi_id . "', " . implode(",", $q);
                $em->getConnection()->exec($sql);
                //}
                //if ($i++ > 30) return;
            }
        }
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
        }

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        $fields["name"] = array("label" => "Name");
        $fields["token"] = array("label" => "Token");
        $fields["func"] = array("label" => "Func");
        //$fields["supplierdescr"] = array("label" => "Supplier");
        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
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
