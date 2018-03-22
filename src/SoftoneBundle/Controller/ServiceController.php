<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use AppBundle\Controller\Main as Main;

class ServiceController extends Main{

    var $repository = 'SoftoneBundle:Pcategory';

    /**
     * @Route("/service/service")
     */
    public function indexAction() {

        

        $content = $this->gettabs();
        return $this->render('SoftoneBundle:Category:view.html.twig', array(
                    'pagename' => 'Service',
                    'url' => '/service/save',
                    'view' => '',
                    'ctrl' => $this->generateRandomString(),
                    'app' => $this->generateRandomString(),
                    'content' => $content,
                    'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));
    }
    public function gettabs() {
        $entity = new Pcategory;
                
        $fields["itecategoryName"] = array("label" => "Original",'type' => "textarea");

        $forms = $this->getFormLyFields($entity, $fields);
        
        $this->addTab(array("title" => "General", "form" => $forms, "content" => '', "index" => $this->generateRandomString(), 'search' => 'text', "active" => true));
   
        $json = $this->tabs();
        return $json;
    }
    /**
     * @Route("/service/save")
     */
    public function save() {
        //$json = json_decode($this->formLybase64());
        $em = $this->getDoctrine()->getManager();
        $data = $this->formLybase64();
        
        $search = $data["SoftoneBundle:Pcategory:itecategoryName:"];
        $q = $items = str_replace("\n",",", $search);
        $items = explode("\n", $search);
        //print_r($items);    
        $term = preg_replace("/[^a-zA-Z0-9]+/", "", $items[0]);
        $sql = "SELECT * FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."'))";			
        $sql = "SELECT * FROM `articles` WHERE `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
        //echo $sql;
        //exit;
        $url = "http://magento2.fastwebltd.com/service.php?sql=".base64_encode($sql);
        
        $datas = unserialize(file_get_contents($url));
	print_r($datas);
        exit;
        
        
        /*
        $search = $data["SoftoneBundle:Pcategory:itecategoryName:"];
        $q = $items = str_replace("\n",",", $search);
        //echo $q;
        //$items = explode("\n", $search);
        //print_r($items);
        $sql = "SELECT * FROM partsbox_db.crossbase WHERE code in (".$q.")";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $datas = $statement->fetchAll();  
          
        foreach($datas as $data) {
            if ($data["oem"] == 0) continue;
            $brands[$data["art_brand"]] = $data["art_brand"]; 
            $brands2[$data["art_brand"]] = ""; 
            $dfr[$data["brand"]][$data["title"]][$data["code"]][$data["art_brand"]][] = $data["art_code"];
        }
        ksort($brands);
        
        //print_r($dfr);
        $csv .=  '"";"";"";'.implode(";", $brands)."\n";
        foreach($dfr as $brand=>$branddata) {
            $csv .= $brand.";".implode(";", $brands2)."\n";
            //continue;
            foreach($branddata as $title=>$titledata) {
                $csv .= '"";'.$title.";".implode(";", $brands2)."\n";
                foreach($titledata as $code=>$codedata) { 
                    $ddf = array();
                    foreach($brands as $brand) {
                       $ddf[] = implode("|",(array)$codedata[$brand]);
                    }   
                    $csv .= '"";"";'.$code.";".implode(";",$ddf)."\n";
                }
            }
        }
        */
        
        //print_r($dfr);
        file_put_contents("assse.csv", $csv);
        $json = json_encode(array("ok", "returnurl" => "/assse.csv"));
        //exit;
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );        
        
    }    

}
