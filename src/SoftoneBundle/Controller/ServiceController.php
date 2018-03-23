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
        return $this->render('SoftoneBundle:Service:view.html.twig', array(
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
        //$sql = "SELECT * FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."'))";			
        $sql = "SELECT `str_id` FROM magento2_base4q2017.link_pt_str WHERE `str_type` = 1 AND pt_id in (Select pt_id from magento2_base4q2017.art_products_des where art_id = '".$art_id."')";
        
        
        
        
        $html = $this->match($items);
        
        $json = json_encode(array("ok", "html" => $html,'divid'=>"resulthtml"));
        return new Response(
                $json, 200, array('Content-Type' => 'application/json')
        );         
        //echo $sql;
        
        /*
        foreach ($items as $term){
            $term = preg_replace("/[^a-zA-Z0-9]+/", "", $term);
            //$sql = "SELECT * FROM `articles` WHERE `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
            $sql = "SELECT * FROM `articles` where art_article_nr_can LIKE '".$term."'";
            
            $url = "http://magento2.fastwebltd.com/service.php?sql=".base64_encode($sql); 
            $datas = unserialize(file_get_contents($url));
            print_r($datas);
        }
         * 
         */
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

    
    function match($items) {
        if ($items) {
            
            foreach($items as $term) {
                $terms = explode("\t",$term);
                $art_article_nr_can[] = preg_replace("/[^a-zA-Z0-9]+/", "", $terms[0]);
                $sup_id[$terms[0]] = $terms[1];
            }
            
            $sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('".implode("','",$art_article_nr_can)."') order by sup_brand";
            //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
            $datas = unserialize(file_get_contents($url));        
            foreach($datas as $data) {
                if ($sup_id[$data["art_article_nr_can"]] == $data["sup_id"]) 
                    $out[$art_article_nr_can][] = "OK";
                else
                    $out[$art_article_nr_can][] = "NOT OK"; 
            }
            /*
            foreach($items as $term) {
                $terms = explode("\t",$term);
                $art_article_nr_can = preg_replace("/[^a-zA-Z0-9]+/", "", $terms[0]);
                $sup_id = $terms[1];
                $sql = "SELECT art_id FROM `articles` where art_article_nr_can = '".$art_article_nr_can."' AND art_sup_id  = '".$sup_id."' ";
                //$html .= $sql."<BR>";
                $url = "http://magento2.fastwebltd.com/service.php?sql=".base64_encode($sql); 
                $datas = unserialize(file_get_contents($url));        
                if ($datas)
                    $out[$art_article_nr_can][] = "OK";
                else
                    $out[$art_article_nr_can][] = "NOT OK";                
            }
             * 
             */
            $html .= '<table>';
            foreach ($out as $article_nr=>$arts) {
                $html .= '<tr>';
                $html .= "<td>".$article_nr."</td>";
                foreach ($arts as $art) {
                    $html .= "<td>".$art."</td>";
                }
                $html .= '</tr>';
            }
            $html .= '<tr>';
            $html .= "<td></td>";
            $html .= '</tr>';
            $html .= '<table>';            
        }
        return $html; 
    }
    
    function ergostatio2($items) {
        foreach($items as $key=>$item) {
            $items[$key] = preg_replace("/[^a-zA-Z0-9]+/", "", $item);
        }
        if ($items) {
            
            foreach($items as $term) {
                $sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
                //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('".implode("','",$items)."') order by sup_brand";
                $url = "http://magento2.fastwebltd.com/service.php?sql=".base64_encode($sql); 
                $datas = unserialize(file_get_contents($url));        
                foreach($datas as $data) {
                    $out[$term][] = $data;
                }
            }
            
            $html = '<table>';
            foreach ($out as $article_nr=>$arts) {
                $html .= '<tr>';
                $html .= "<td>".$article_nr."</td>";
                foreach ($arts as $art) {
                    $html .= "<td>".$art["sup_id"]."</td>";
                    $html .= "<td>".$art["sup_brand"]."</td>";
                    $html .= "<td>".$art["art_article_nr_can"]."</td>";
                }
                $html .= '</tr>';
            }
            $html .= '<tr>';
            $html .= "<td></td>";
            $html .= '</tr>';
            $html .= '<table>';
        }
        return $html;        
    }
    function ergostatio($items) {
        foreach($items as $key=>$item) {
            $items[$key] = preg_replace("/[^a-zA-Z0-9]+/", "", $item);
        }
        if ($items) {
            $sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('".implode("','",$items)."') order by sup_brand";
            $url = "http://magento2.fastwebltd.com/service.php?sql=".base64_encode($sql); 
            $datas = unserialize(file_get_contents($url));        
            foreach($datas as $data) {
                $out[$data["art_article_nr_can"]][] = $data;
            }
            $html = '<table>';
            foreach ($out as $article_nr=>$arts) {
                $html .= '<tr>';
                $html .= "<td>".$article_nr."</td>";
                if (count($arts)>1) {
                    $html .= "<td></td>";
                    $html .= "<td></td>";
                }
                
                foreach ($arts as $art) {
                    $html .= "<td>".$art["sup_id"]."</td>";
                    $html .= "<td>".$art["sup_brand"]."</td>";
                }
                
                $html .= '</tr>';
            }
            $html .= '<table>';
        }
        return $html;
    }
    
}
