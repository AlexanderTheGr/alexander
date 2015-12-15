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
        $em = $this->getDoctrine()->getManager();
        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);
            foreach ($data as $key => $attr) {
                $attrs[$key] = strtolower($attr);
            }
            while ($data = fgetcsv($handle, 100000, "\t")) {
                /*
                foreach ($data as $key => $val) {
                    $attributes[$this->from_camel_case($attrs[$key])] = $val;
                }
                 * 
                 */


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
                //if ((int) $eltrekaedi["id"] == 0) {
                @$eltrekaedi["id"] = (int)$eltrekaedi->id;
                //}
                if ($eltrekaedi["id"] == 0) {
                    echo ".";
                } 
                $sql = "replace eltrekaedi set id = '" . $eltrekaedi["id"] . "', " . implode(",", $q);
                $em->getConnection()->exec($sql);
            }
        }
    }
    function from_camel_case($str) {
        $str = $this->createName($str);
        //echo $str;
        //$str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return $c[1];');
        return preg_replace_callback('/([A-Z])/', $func, $str);
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
