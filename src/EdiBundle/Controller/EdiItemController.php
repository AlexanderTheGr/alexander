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
        return 'http://zerog.gr/edi/fw.ashx?method=getinventoryfile&apiToken='.$apiToken;
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
                ->addField(array("name" => "Edi", "index" => 'Edi:name', 'search' => 'select','type'=>'select'))
                ->addField(array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text'))
                ->addField(array("name" => "Brand", "index" => 'brand', 'search' => 'text'))
                ->addField(array("name" => "Part No", "index" => 'partno', 'search' => 'text'))
                ->addField(array("name" => "Description", "index" => 'description', 'search' => 'text'))
                ->addField(array("name" => "Tecdoc Name", "index" => 'tecdocArticleName', 'search' => 'text'))
                
                ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/ediitem/install")
     */
    public function installAction(Request $request) {
        $this->install();
        $this->getPartMaster();
    }

}
