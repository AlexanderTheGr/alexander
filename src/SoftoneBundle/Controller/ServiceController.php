<?php

namespace SoftoneBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SoftoneBundle\Entity\Pcategory as Pcategory;
use AppBundle\Controller\Main as Main;

class ServiceController extends Main {

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

        $dataarray[] = array("value" => "matchModels", "name" => "Match Models");
        $dataarray[] = array("value" => "match", "name" => "Match");
        $dataarray[] = array("value" => "original2", "name" => "Original");
        $dataarray[] = array("value" => "ppergostat", "name" => "Ergostatio2");
        $dataarray[] = array("value" => "ergostatio", "name" => "Ergostatio");
        $dataarray[] = array("value" => "getoriginals", "name" => "Get Originals");
        
        

        $pcats = $this->getDoctrine()
                ->getRepository('SoftoneBundle:Category')
                ->findBy(array("parent" => 0));

        $dataarray2[] = array("value" => 0, "name" => "Select");
        foreach ($pcats as $pcat) {


            //$html .= "<option value='" . $pcat->getId() . "'>".$pcat->getName()."</option>";

            $dataarray2[] = array("value" => $pcat->getId(), "name" => $pcat->getName());
            $cats = $this->getDoctrine()
                    ->getRepository('SoftoneBundle:Category')
                    ->findBy(array("parent" => $pcat->getId()));
            foreach ($cats as $cat) {
                $dataarray2[] = array("value" => $cat->getId(), "name" => "--" . $cat->getName());
            }
        }
        $brands = $this->getDoctrine()
                        ->getRepository('SoftoneBundle:Brand')->findAll(array(), array('brand' => 'ASC'));

        $dataarray3[] = array("value" => 0, "name" => "Select");
        foreach ($brands as $brand) {
            $dataarray3[] = array("value" => $brand->getId(), "name" => $brand->getBrand());
        }
        $fields["itemIsactive"] = array("label" => "Type", 'type' => "select", 'dataarray' => $dataarray, "required" => false, "className" => "col-md-3 col-sm-3");
        $fields["category"] = array("label" => "Category", 'type' => "select", 'dataarray' => $dataarray2, "required" => false, "className" => "asksksaksk col-md-3 col-sm-3");
        //$fields["brand"] = array("label" => "Brand", 'type' => "select", 'dataarray' => $dataarray3, "required" => false, "className" => "asksksaksk col-md-3 col-sm-3");
        $fields["brand"] = array("label" => $this->getTranslation("Brand"), "required" => false, "className" => "asksksaksk col-md-3", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Brand', 'name' => 'brand', 'value' => 'id', 'suffix' => 'id'));
        $fields["tecdocSupplierId"] = array("label" => $this->getTranslation("Tecdoc Supplier"), "required" => false, "className" => "asksksaksk col-md-3", 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:TecdocSupplier', 'name' => 'supplier', 'value' => 'id', 'suffix' => 'id'));
        $fields["itecategoryName"] = array("label" => "Field", 'type' => "textarea");
        //$fields["brand"] = array("label" => "Vat", "required" => false, 'type' => "select", 'datasource' => array('repository' => 'SoftoneBundle:Brand', 'name' => 'brand', 'value' => 'id'));
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
        $type = $data["SoftoneBundle:Pcategory:itemIsactive:"];
        $tecdocSupplierId = $data["SoftoneBundle:Pcategory:tecdocSupplierId:"];
        $brand = $data["SoftoneBundle:Pcategory:brand:"];
        //echo $tecdocSupplierId;
        if (!$type)
            exit;
        if ($type == 'null')
            exit;
        if ($search == "")
            exit;
        $category = $data["SoftoneBundle:Pcategory:category:"];
        $q = $items = str_replace("\n", ",", $search);
        $items = explode("\n", $search);
        //print_r($items);    
        $term = preg_replace("/[^a-zA-Z0-9]+/", "", $items[0]);
        //$sql = "SELECT * FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."'))";			
        $sql = "SELECT `str_id` FROM magento2_base4q2017.link_pt_str WHERE `str_type` = 1 AND pt_id in (Select pt_id from magento2_base4q2017.art_products_des where art_id = '" . $art_id . "')";

        if ($category > 0) {
            $sql = "select * from cat2cat where w_str_id = '" . $category . "'";
            $connection = $em->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $results = $statement->fetchAll();
            //print_r($results);
            $category = $results[0]["oldnew_id"];
        }
        //echo $type;
        $html = $this->$type((array) $items, $category, $tecdocSupplierId, $brand);
        $json = json_encode(array("ok", "html" => $html, 'divid' => "resulthtml"));
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

    function matchModels($items, $category = 0, $tecdocSupplierId = 0) {
        if (count($items)) {
            $out = array();
            foreach ($items as $term) {
                $terms = explode("\t", $term);
                $art_article_nr_can = preg_replace("/[^a-zA-Z0-9]+/", "", $terms[0]);
                $art_article_nr_cans[] = $art_article_nr_can;
                $sup_id[$art_article_nr_can] = $terms[1];
            }

            $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('" . implode("','", $art_article_nr_cans) . "') order by sup_brand";
            //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
            //echo $sql;
            //exit;
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $datas = unserialize(file_get_contents($url));

            foreach ((array) $datas as $data) {
                if ($sup_id[$data["art_article_nr_can"]] == $data["sup_id"]) {
                    if ($out[$data["art_article_nr_can"]][1] == 'OK') {
                        continue;
                    }
                    $out[$data["art_article_nr_can"]][1] = "OK";
                    $out[$data["art_article_nr_can"]][2] = $data["art_id"];

                    $sql = "Select mod_lnk_vich_id from magento2_base4q2017.art_mod_links a, magento2_base4q2017.models_links b where `mod_lnk_type` = 1 AND a.mod_lnk_id = b.mod_lnk_id and art_id = '" . $data["art_id"] . "' group by `mod_lnk_vich_id`";
                    $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                    $models = unserialize(file_get_contents($url));
                    $mdo = array();
                    foreach ($models as $model_type) {
                        $mdo[] = $model_type["mod_lnk_vich_id"];
                    }
                    $out[$data["art_article_nr_can"]][3] = count($mdo);
                    $out[$data["art_article_nr_can"]][4] = implode(",", $mdo);
                } else {
                    if ($out[$data["art_article_nr_can"]][1] == 'OK') {
                        continue;
                    }
                    $out[$data["art_article_nr_can"]][1] = "NOT OK";
                    $out[$data["art_article_nr_can"]][2] = "";
                    $out[$data["art_article_nr_can"]][3] = "";
                    $out[$data["art_article_nr_can"]][4] = "";
                }
            }

            $html .= '<table>';
            foreach ($out as $article_nr => $arts) {
                $html .= '<tr>';
                $html .= "<td>" . $article_nr . "</td>";
                $html .= "<td>" . $sup_id[$article_nr] . "</td>";
                foreach ($arts as $art) {
                    $html .= "<td>" . $art . "</td>";
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
    
    function match($items, $category = 0, $tecdocSupplierId = 0) {
        if (count($items)) {


            $out = array();
            $i = 0;
            foreach ($items as $term) {
                $i++;
                $terms = explode("\t", $term);
                $art_article_nr_can = preg_replace("/[^a-zA-Z0-9]+/", "", $terms[0]);
                $art_article_nr_cans[] = $art_article_nr_can;
                $out[$i . "||" . $art_article_nr_can] = array();
                $sup_id[$art_article_nr_can] = $terms[1];
                $is[$art_article_nr_can][] = $i;
                $artnrs[$i . "||" . $art_article_nr_can] = $terms[0];
            }
            //$i = 0;
            $sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('" . implode("','", $art_article_nr_cans) . "') order by sup_brand";
            //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
            //$url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $url = "http://magento2.fastwebltd.com/service.php";
            $datas = unserialize($this->curlit($url, "sql=" . base64_encode($sql)));
            //$datas = unserialize(file_get_contents($url));
            foreach ((array) $datas as $data) {


                foreach ((array) $is[$data["art_article_nr_can"]] as $i) {
                    if ($sup_id[$data["art_article_nr_can"]] == $data["sup_id"]) {
                        if ($out[$i . "||" . $data["art_article_nr_can"]][1] == 'OK') {
                            continue;
                        }
                        $out[$i . "||" . $data["art_article_nr_can"]][1] = "OK";
                    } else {
                        /*
                          if ($out[$data["art_article_nr_can"]][1] == 'OK') {
                          continue;
                          }
                          $out[$data["art_article_nr_can"]][1] = "NOT OK";
                         * 
                         */
                    }
                }
            }

            /*
              foreach ($items as $term) {
              $terms = explode("\t", $term);
              $art_article_nr_can = preg_replace("/[^a-zA-Z0-9]+/", "", $terms[0]);
              $sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can = '".$art_article_nr_can."' order by sup_brand";
              //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '".$term."')))";
              $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
              $datas = unserialize(file_get_contents($url));

              }
             */
            $html .= '<table>';
            foreach ($out as $articlenr => $arts) {
                $article_nrs = explode("||", $articlenr);
                $article_nr = $artnrs[$articlenr];
                $html .= '<tr>';
                $html .= "<td>" . $article_nr . "</td>";
                $html .= "<td>" . $sup_id[$article_nrs[1]] . "</td>";
                $art = "";
                foreach ($arts as $art) {
                    $html .= "<td>" . $art . "</td>";
                }
                $html .= '</tr>';
                $text .= $article_nr . "\t" . $sup_id[$article_nrs[1]] . "\t" . $art . "\n";
            }
            $html .= '<tr>';
            $html .= "<td></td>";
            $html .= '</tr>';
            $html .= '<table>';
            $textarea = "<textarea>" . $text . "</textarea><BR>";
        }
        return $textarea . $html;
    }

    function curlit($url, $fields_string) {
        rtrim($fields_string, '&');
        $ch = curl_init();
        //echo $fields_string."\n";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $datas = curl_exec($ch);
        //echo $datas;
        //exit;
        return $datas;
    }

    function ppergostat($items, $category = 0, $tecdocSupplierId = 0) {
        if (count($items)) {
            $sup = "";
            if ($tecdocSupplierId > 0) {
                $sup = " AND sup_id = '" . $tecdocSupplierId . "'";
            }
            $out = array();
            foreach ($items as $key => $item) {
                $items[$key] = preg_replace("/[^a-zA-Z0-9]+/", "", $item);
            }
            if ($items) {
                foreach ($items as $term) {
                    $out[$term] = array();
                    if ($category > 0) {
                        $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) " . $sup . " AND sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '" . $term . "')))";
                    } else
                        $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '" . $term . "')))  " . $sup . "";
                    //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('".implode("','",$items)."') order by sup_brand";
                    $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                    $datas = unserialize(file_get_contents($url));
                    foreach ($datas as $data) {
                        $out[$term][] = $data;
                    }
                }
                $html = '<table>';
                foreach ($out as $article_nr => $arts) {
                    $html .= '<tr>';
                    $html .= "<td>" . $article_nr . "</td>";
                    foreach ($arts as $art) {
                        $html .= "<td>" . $art["sup_id"] . "</td>";
                        $html .= "<td>" . $art["sup_brand"] . "</td>";
                        $html .= "<td>" . $art["art_article_nr_can"] . "</td>";
                    }
                    $html .= '</tr>';
                }
                $html .= '<tr>';
                $html .= "<td></td>";
                $html .= '</tr>';
                $html .= '<table>';
            }
        }
        return $html;
    }

    
    function getoriginals($items, $category = 0, $tecdocSupplierId = 0) {
        if (count($items)) {
            if ($tecdocSupplierId > 0)
                $sup = " AND sup_id = '" . $tecdocSupplierId . "'";
            if ($category > 0)
                $cat = " AND art.art_id in (Select des.art_id from magento2_base4q2017.art_products_des des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1))";
            
            $sql = "SELECT des_text,art.art_id, art_article_nr_can,sup_id,sup_brand FROM art_products_des artpt, text_designations tex, products pt, art_oem_numbers oem, `articles` art,suppliers 
                    where 
                    artpt.art_id = art.art_id AND 
                    pt.pt_id = artpt.pt_id AND
                    tex.des_id = pt.pt_des_id AND                    
                    art.art_id=oem.art_id AND 
                    sup_id = art_sup_id AND 
                    art_article_nr_can in ('" . implode("','", $items) . "') " . $sup . " ".$cat." order by sup_brand";
        
            return $sql;
        }    
    }    
        
    
    
    function original2($items, $category = 0, $tecdocSupplierId = 0, $brand = 0) {
        if (count($items)) {
            $sup = "";
            if ($tecdocSupplierId > 0) {
                $sup = " AND sup_id = '" . $tecdocSupplierId . "'";
            }
            $out = array();
            foreach ($items as $key => $item) {
                $term = preg_replace("/[^a-zA-Z0-9]+/", "", $item);
                $items[$key] = $term;
                $out[$term] = array();
                $out11[$term] = true;
            }
            $brand_sql = $brand > 0 ? " AND mfa_id = '" . $brand . "'" : "";
            $sql = "SELECT oem_num_can,art_id FROM `art_oem_numbers` WHERE `oem_num_can` in ('" . implode("','", $items) . "') " . $brand_sql . "";
            //echo $sql;
            $url = "http://magento2.fastwebltd.com/service.php";
            $datas = unserialize($this->curlit($url, "sql=" . base64_encode($sql)));
            foreach ($datas as $data) {
                //echo $data["oem_num_can"]."\n";
                $oems[$data["art_id"]][] = $data["oem_num_can"];
            }

            $brand_sql = $brand > 0 ? " AND mfa_id = '" . $brand . "'" : "";
            if ($category > 0) {
                //$sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) ".$sup." AND sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = art_id AND art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "'))))";                        
                $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) " . $sup . " AND sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` in ('" . implode("','", $items) . "') " . $brand_sql . ")))";
            } else {
                //$sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and  AND art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "'))))  ".$sup."";
                $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` in ('" . implode("','", $items) . "') " . $brand_sql . ")))  " . $sup . "";
                //echo $sql;
            }

            //return $sql;

            $url = "http://magento2.fastwebltd.com/service.php";
            $datas = unserialize($this->curlit($url, "sql=" . base64_encode($sql)));

            
            foreach ($datas as $data) {
                //print_r($data);
                foreach($oems[$data["art_id"]] as $oem_num_can) {
                    if ($out11[$oem_num_can]) { 
                        $out[$oem_num_can][$data["art_id"]] = $data;
                    }
                }
                //$out[$oems[$data["art_id"]]][] = $data;
            }
            $html = $tecdocSupplierId . " -- " . $brand . '<BR><table>';
            foreach ($out as $article_nr => $arts) {
                $html .= '<tr>';
                $html .= "<td>" . $article_nr . "</td>";
                $html .= "<td>" . count($arts) . "</td>";
                $arttt = "";
                foreach ($arts as $art) {
                    $html .= "<td>" . @$art["sup_id"] . "</td>";
                    $html .= "<td>" . @$art["sup_brand"] . "</td>";
                    $html .= "<td>" . @$art["art_article_nr_can"] . "</td>";
                    $arttt .= $art["sup_id"]."\t".$art["sup_brand"]."\t".$art["art_article_nr_can"]."\t";
                }
                $html .= '</tr>';
                $text .= $article_nr . "\t" .  count($arts) . "\t" . $arttt . "\n";
            }
            $html .= '<tr>';
            $html .= "<td></td>";
            $html .= '</tr>';
            $html .= '<table>';
            $textarea = "<textarea>" . $text . "</textarea><BR>";

            /*
            if ($items) {
                foreach ($items as $term) {
                    if (!$oems[$term])
                        continue;
                    $brand_sql = $brand > 0 ? " AND mfa_id = '" . $brand . "'" : "";
                    if ($category > 0) {
                        //$sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) ".$sup." AND sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = art_id AND art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "'))))";                        
                        $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) " . $sup . " AND sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "' " . $brand_sql . "))) limit 0,10";
                    } else {
                        //$sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and  AND art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "'))))  ".$sup."";
                        $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND `art_id` in (SELECT `art_id` FROM magento2_base4q2017.articles art WHERE (art.art_id in (SELECT art_id FROM `art_oem_numbers` WHERE `oem_num_can` LIKE '" . $term . "' " . $brand_sql . ")))  " . $sup . " limit 0,10";
                        //echo $sql;
                    }
                    //$sql = "SELECT art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('".implode("','",$items)."') order by sup_brand";
                    //echo $sql;
                    $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                    $datas = unserialize(file_get_contents($url));
                    foreach ($datas as $data) {
                        $out[$term][] = $data;
                    }
                }
            }
             * 
             */
        }
        return $textarea.$html;
    }

    function original($items, $category = 0, $tecdocSupplierId = 0, $brand = 0) {
        if (count($items)) {
            $out = array();
            foreach ($items as $key => $item) {
                $items[$key] = preg_replace("/[^a-zA-Z0-9]+/", "", $item);
                $out[$items[$key]] = array();
            }
            $sup = "";
            if ($tecdocSupplierId > 0) {
                $sup = " AND sup_id = '" . $tecdocSupplierId . "'";
            }
            if ($items) {
                $brand_sql = $brand > 0 ? " AND mfa_id = '" . $brand . "'" : "";
                if ($category > 0) {
                    $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1)) AND sup_id = art_sup_id AND art_id in (SELECT `art_id` FROM `art_oem_numbers` WHERE `oem_num_can` in ('" . implode("','", $items) . "')) " . $sup . " " . $brand_sql . " order by sup_brand";
                } else
                    $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_id in (SELECT `art_id` FROM `art_oem_numbers` WHERE `oem_num_can` in ('" . implode("','", $items) . "') " . $brand_sql . ") " . $sup . " order by sup_brand";
                $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                //echo $sql;
                //$sql = "(Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1))";

                $datas = unserialize(file_get_contents($url));
                foreach ((array) $datas as $data) {
                    $out[strtolower($data["art_article_nr_can"])][] = $data;
                }
                $html = '<table>';
                foreach ((array) $out as $article_nr => $arts) {
                    $html .= '<tr>';
                    $html .= "<td>" . $article_nr . "</td>";
                    if (count($arts) > 1) {
                        $html .= "<td></td>";
                        $html .= "<td></td>";
                    }

                    foreach ($arts as $art) {
                        $html .= "<td>" . $art["sup_id"] . "</td>";
                        $html .= "<td>" . $art["sup_brand"] . "</td>";
                        $html .= "<td>" . $art["cat"] . "</td>";
                        //$html .= "<td>".$art["sql"]."</td>";
                    }

                    $html .= '</tr>';
                }
                $html .= '<table>';
            }
        }
        return $html;
    }

    function ergostatio($items, $category = 0, $tecdocSupplierId = 0) {
        if (count($items)) {
            $out = array();
            foreach ($items as $key => $item) {
                //$item = strtolower($item);

                $items[$key] = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($item));
                $out[$item] = array();
                $out1[$items[$key]] = $item;
            }
            $sup = "";
            if ($tecdocSupplierId > 0) {
                $sup = " AND sup_id = '" . $tecdocSupplierId . "'";
            }
            if ($items) {
                if ($category > 0) {
                    $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where art_id in (Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' " . $sup . " AND `str_type` = 1)) AND sup_id = art_sup_id AND art_article_nr_can in ('" . implode("','", $items) . "') order by sup_brand";
                } else
                    $sql = "SELECT art_id, art_article_nr_can,sup_id,sup_brand FROM `articles`,suppliers where sup_id = art_sup_id AND art_article_nr_can in ('" . implode("','", $items) . "') " . $sup . " order by sup_brand";


                $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                //echo $sql."\n";
                //$sql = "(Select art_id from magento2_base4q2017.art_products_des where pt_id in (SELECT `pt_id` FROM magento2_base4q2017.link_pt_str WHERE str_id='" . $category . "' AND `str_type` = 1))";

                $datas = unserialize(file_get_contents($url));
                foreach ((array) $datas as $data) {
                    $data["art_article_nr_can"] = preg_replace("/[^a-zA-Z0-9]+/", "", strtolower($data["art_article_nr_can"]));
                    $out[$out1[$data["art_article_nr_can"]]][] = $data;
                }
                $html = '<table>';
                foreach ((array) $out as $article_nr => $arts) {
                    $html .= '<tr>';
                    $html .= "<td>" . $article_nr . "</td>";
                    if (count($arts) > 1) {
                        $html .= "<td></td>";
                        $html .= "<td></td>";
                    }

                    foreach ($arts as $art) {
                        $html .= "<td>" . $art["sup_id"] . "</td>";
                        $html .= "<td>" . $art["sup_brand"] . "</td>";
                        $html .= "<td>" . $art["cat"] . "</td>";
                        //$html .= "<td>".$art["sql"]."</td>";
                    }

                    $html .= '</tr>';
                }
                $html .= '<table>';
            }
        }
        return $html;
    }

}
