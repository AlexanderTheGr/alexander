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
        return $this->render('EdiBundle:Eltreka:index.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/getdatatable',
                    'view' => '/edi/eltreka/view',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }

    /**
     * @Route("/edi/eltreka/view/{id}")
     */
    public function viewAction($id) {

        return $this->render('EdiBundle:Eltreka:view.html.twig', array(
                    'pagename' => 'Eltrekaedis',
                    'url' => '/edi/eltreka/save',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'tabs' => $this->gettabs($id),
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

        $eltrekaedi = new Eltrekaedi();
        $file = $eltrekaedi->getPartMasterFile();
        echo $file;

        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            $em = $this->getDoctrine()->getManager();
            while ($data = fgetcsv($handle, 100000, "\t")) {
                foreach ($data as $key => $val) {
                    $attributes[$this->createName($attrs[$key])] = $val;
                }



                $attributes["wholeprice"] = str_replace(",", ".", $attributes["wholeprice"]);
                $attributes["retailprice"] = str_replace(",", ".", $attributes["retailprice"]);
                $attributes["grossWeightGr"] = str_replace(",", ".", $attributes["grossWeightGr"]);
                $attributes["lenghtMm"] = str_replace(",", ".", $attributes["lenghtMm"]);
                $attributes["widthMm"] = str_replace(",", ".", $attributes["widthMm"]);
                $attributes["heightMm"] = str_replace(",", ".", $attributes["heightMm"]);


                
                $eltrekaedi = new Eltrekaedi();
                $eltrekaedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Eltrekaedi')
                        ->findOneByPartno($attributes["partno"]);
                
                if (@!$eltrekaedi->id) {
                    $eltrekaedi = new Eltrekaedi();                
                    foreach ($attributes as $field => $val) {
                        $eltrekaedi->setField($field, $val);
                    }
                    //exit;
                   
                    $em->persist($eltrekaedi);
                    $em->flush();
                    echo ".";   
                } else {
                    echo $eltrekaedi->id."<BR>";                    
                }
                //exit;

                /*
                  $sql = "select id from eltrekaedi where partno = '".$attributes["partno"]."'";
                  $eltrekaedi = Yii::app()->db->createCommand($sql)->queryRow();
                 */

                /*
                  $sql = "replace eltrekaedi set id = '".$eltrekaedi["id"]."', ".implode(",",$q);
                  echo $eltrekaedi["id"]."<BR>";
                  Yii::app()->db->createCommand($sql)->execute();
                  //if ($i++ > 10)
                  //exit;
                 * 
                 */
            }
        }
    }

    function createName($str) {
        $strArr = explode("_", $str);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        $strArr = explode(".", $b);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        return lcfirst($b);
    }

    /**
     * @Route("/edi/eltreka/gettab")
     */
    public function gettabs($id) {

        $entity = $this->getDoctrine()
                ->getRepository($this->repository)
                ->find($id);
        $fields["customerCode"] = array("label" => "Eltrekaedi Code");
        $fields["customerName"] = array("label" => "Eltrekaedi Name");
        $fields["customerAfm"] = array("label" => "Eltrekaedi Afm");
        $fields["customerAddress"] = array("label" => "Eltrekaedi Address");
        $fields["customerCity"] = array("label" => "Eltrekaedi City");

        $forms = $this->getFormLyFields($entity, $fields);
        $this->addTab(array("title" => "General1", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
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

        ;
        $json = $this->datatable();

        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );
    }

}
