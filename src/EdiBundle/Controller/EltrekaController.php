<?php

namespace EdiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use EdiBundle\Entity\Eltrekaedi;
use AppBundle\Controller\Main as Main;

class EltrekaController extends Main {

    var $repository = 'EdiBundle:Eltrekaedi';

    /**
     * @Route("/edi/eltreka")
     */
    public function indexAction() {

        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        return $this->render('EdiBundle:Eltreka:index.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/getdatatable',
                    'view' => '/edi/eltreka/view',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/view/{id}")
     */
    public function viewAction($id) {
        $buttons = array();
        $Eltrekaedi = $this->getDoctrine()
                ->getRepository('EdiBundle:Eltrekaedi')
                ->find($id);
        $Eltrekaedi->GetAvailability();
        
        
        $Eltrekaedi->toErp();

        
        return $this->render('EdiBundle:Eltreka:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/save',
                    'buttons' => $buttons,
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $this->gettabs($id),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/save")
     */
    public function savection() {
        $this->save();
        $json = json_encode(array("ok"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

    /**
     * @Route("/edi/eltreka/getPartMaster")
     */
    public function getPartMasterAction() {
        $this->getPartMaster();
    }
    
    public function getPartMaster() {

        $eltrekaedi = new Eltrekaedi();
        $file = $eltrekaedi->getPartMasterFile();       
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            while ($data = fgetcsv($handle, 100000, "\t")) {

                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = $val;
                }

                $attributes["wholeprice"] = str_replace(",", ".", $attributes["wholeprice"]);
                $attributes["retailprice"] = str_replace(",", ".", $attributes["retailprice"]);
                $attributes["gross_weight_gr"] = str_replace(",", ".", $attributes["gross_weight_gr"]);
                $attributes["lenght_mm"] = str_replace(",", ".", $attributes["lenght_mm"]);
                $attributes["width_mm"] = str_replace(",", ".", $attributes["width_mm"]);
                $attributes["height_mm"] = str_replace(",", ".", $attributes["height_mm"]);

                $eltrekaedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Eltrekaedi')
                        ->findOneByPartno($attributes["partno"]);
                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                @$eltrekaedi_id = (int) $eltrekaedi->id;
                if ($eltrekaedi_id == 0) {
                    $sql = "replace eltrekaedi set id = '" . $eltrekaedi_id . "', " . implode(",", $q);
                    $em->getConnection()->exec($sql);
                }
            }
        }
    }    

    /**
     * @Route("/edi/eltreka/gettab")
     */
    public function gettabs($id) {

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $buttons = array();
        $buttons[] = array("label" => 'Get PartMaster', 'position' => 'right', 'class' => 'btn-success');

        $fields["partno"] = array("label" => "Part No");
        $fields["description"] = array("label" => "Description");
        $fields["supplierdescr"] = array("label" => "Supplier");
        $fields["factorypartno"] = array("label" => "Factorypart Ni");
        $fields["wholeprice"] = array("label" => "Wholeprice");
        $fields["retailprice"] = array("label" => "Retailprice");


        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General", 'buttons' => $buttons, "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
        $json = $this->tabs();
        return $json;
    }

    /**
     * @Route("/edi/eltreka/getdatatable")
     */
    public function getdatatableAction(Request $request) {

        $this->repository = 'EdiBundle:Eltrekaedi';
        $this->addField(array("name" => "ID", "index" => 'id'))
                ->addField(array("name" => "Part No", "index" => 'partno', 'search' => 'text'))
                ->addField(array("name" => "Description", "index" => 'description', 'search' => 'text'))
                ->addField(array("name" => "Supplier", "index" => 'supplierdescr', 'search' => 'text'))
                ->addField(array("name" => "Factorypart No", "index" => 'factorypartno', 'search' => 'text'))
                ->addField(array("name" => "Wholeprice", "index" => 'wholeprice', 'search' => 'text'))
                ->addField(array("name" => "Retailprice", "index" => 'retailprice', 'search' => 'text'))

        ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }
    
    /**
     * @Route("/edi/eltreka/install")
     */
    public function installAction() {
        $this->install();
        $this->getPartMaster();
    }
}
