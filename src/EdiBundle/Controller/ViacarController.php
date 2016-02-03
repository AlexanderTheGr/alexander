<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\Viacaredi;
use AppBundle\Controller\Main as Main;

class ViacarController extends Main {

    var $repository = 'EdiBundle:Viacaredi';

    /**
     * @Route("/edi/viacar")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Viacar:index.html.twig', array(
                    'pagename' => 'Viacaredis',
                    'url' => '/edi/viacar/getdatatable',
                    'view' => '/edi/viacar/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/viacar/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();
        $Viacaredi = $this->getDoctrine()
                ->getRepository('EdiBundle:Viacaredi')
                ->find($id);
        $Viacaredi->GetAvailability();
        return $this->render('EdiBundle:Viacar:view.html.twig', array(
                    'pagename' => 'Viacaredis',
                    'url' => '/edi/viacar/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/viacar/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    public function getPartMasterFile() {
        return 'http://zerog.gr/edi/fw.ashx?method=getinventoryfile&apiToken=de1751fa-f91c-4b7c-89a9-9cfbaf0e5b50';
    }

    /**
     * @Route("/edi/viacar/getPartMaster")
     */
    public function getPartMasterAction() {


        //echo $this->getPartMaster();
        //$fiestr = gzdecode(file_get_contents($this->getPartMasterFile()));
        //file_put_contents('file.csv', $fiestr);
        set_time_limit(100000);
        ini_set('memory_limit', '128M');
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
                
                $viacaredi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Viacaredi')
                        ->findOneByItemCode($attributes["itemcode"]);
                
                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$viacaredi_id = (int) $viacaredi->id;
                if (@$viacaredi_id == 0) {
                    $sql = "replace viacaredi set id = '" . $viacaredi_id . "', " . implode(",", $q);
                    $em->getConnection()->exec($sql);
                }
                //if ($i++ > 10) exit;
            }
        }
        exit;
    }

    /**
     * @Route("/edi/viacar/gettab")
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
     * @Route("/edi/viacar/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $this->repository = 'EdiBundle:Viacaredi';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Item Code", "index" => 'itemCode', 'search' => 'text'))
                ->addField(array("name" => "Brand", "index" => 'brand', 'search' => 'text'))
                ->addField(array("name" => "Part No", "index" => 'partno', 'search' => 'text'))
                ->addField(array("name" => "Description", "index" => 'description', 'search' => 'text'));
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
