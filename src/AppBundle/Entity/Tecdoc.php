<?php

/*
  if (file_exists(Mage::getBaseDir() . "/zois/Tecdoc.php")) {
  require Mage::getBaseDir() . "/zois/Tecdoc.php";
  }
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Entity;

if (file_exists("/home2/partsbox/Tecdoc.php")) {
    require_once "/home2/partsbox/Tecdoc.php";
}
if (file_exists("/tecdoc3/php/Tecdoc3.php")) {
    //require "/tecdoc3/php/Tecdoc4.php";
}

class Tecdoc extends Entity {

    public $soap;
    public $country = 'GR';  //GR
    public $lang = 'EL';     //EL
    public $provider = 202;  //tecdoc code. Useless
    public $linkingTargetType = 'C';
    public $articleIdsParams = array();
    public $useSOAP = false;
    public $tecdoc;
    public $tecdocproductids;
    private $write;
    public $tecdoccategory;
    public $useCustomSearch = true;

    public function __construct() {


        $this->linkingTargetType = "C";
        $this->tecdoc = new \Tecdoc_first();
    }

    public function setLng($lng) {
        $this->tecdoc->lng = $lng;
    }

    public function getVehicleManufacturers($params) {
        $params = array(
            "carType" => 1,
            "countriesCarSelection" => $this->country,
            "countryGroupFlag" => false,
            "evalFavor" => false,
            "lang" => "en", //$this->lang,
            "provider" => $this->provider,
        );
        if ($this->useSOAP) {
            return $this->soap->getVehicleManufacturers3($params);
        } else {
            return $this->package($this->tecdoc->getManufacturers());
        }
    }

    public function getVehicleManufacturerModels($params) {
        $params = array(
            "carType" => 1,
            "countriesCarSelection" => $this->country,
            "countryGroupFlag" => false,
            "evalFavor" => false,
            "lang" => "en", //$this->lang,
            "provider" => $this->provider,
            "manuId" => (int) $params["manuId"],
        );
        if ($this->useSOAP) {
            return $this->soap->getVehicleModels3($params);
        } else {
            return $this->package($this->tecdoc->getModels($params['manuId']));
        }
    }

    public function getVehicleManufacturerModelTypes($params) {
        $params = array(
            "carType" => 1,
            "countriesCarSelection" => $this->country,
            "countryGroupFlag" => false,
            "evalFavor" => false,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "manuId" => (int) $params["manuId"],
            "modId" => (int) $params["modId"],
        );
        if ($this->useSOAP) {
            return $this->soap->getVehicleIdsByCarTypeManuIdModelIdCriteria3($params);
        } else {
            return $this->package($this->tecdoc->getTypes($params['modId']));
        }
    }

    public function getThumbnailByArticleId($params) {
        return $this->soap->getThumbnailByArticleId(array("provider" => $this->provider, "articleId" => $params["articleId"]));
    }

    /*
      public function getLinkedChildNodesAllLinkingTarget($params) {
      $params = array(
      "country" => $this->country,
      "lang" => $this->lang,
      "provider" => $this->provider,
      "childNodes" => false,
      "linkingTargetType" => $this->linkingTargetType,
      "parentNodeId" => $params["parentNodeId"],
      "linkingTargetId" => $params["linkingTargetId"]
      );
      if ($this->useSOAP) {
      return $this->soap->getLinkedChildNodesAllLinkingTarget($params);
      } else {
      return $this->package($this->tecdoc->getTree($params["linkingTargetId"], $params["parentNodeId"]));
      }
      }
     */

    public function getLinkedChildNodesAllLinkingTarget($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "childNodes" => false,
            "linkingTargetType" => $this->linkingTargetType,
            "parentNodeId" => (int) $params["parentNodeId"],
            "linkingTargetId" => (int) $params["linkingTargetId"]
        );


        if ($this->useSOAP) {
            return $this->soap->getLinkedChildNodesAllLinkingTarget($params);
        } else {
            if ($this->useCustomSearch)
                return $this->package($this->tecdoc->getTree2($params["linkingTargetId"], $params["parentNodeId"]));
            else
                return $this->package($this->tecdoc->getTree($params["linkingTargetId"], $params["parentNodeId"]));
        }
    }

    function linkedChildNodesAllLinkingTargetTreeIds($params = array(), $lvl = 0) {

        $linkedChildNodesAllLinkingTarget = $this->getLinkedChildNodesAllLinkingTarget($params);
        $lvl++;
        if (!$params["linkingTargetId"]) {
            $params["linkingTargetId"] = 1;
        }

        //echo serialize($linkedChildNodesAllLinkingTarget->data->array);

        foreach ($linkedChildNodesAllLinkingTarget->data->array as $v) {
            $hasChilds = $v->hasChilds;
            if ($v->articles_count == 0 AND $v->parentNodeId > 0) {
                //echo $v->assemblyGroupName."<BR>";
                continue;
            }


            if ($v->parentNodeId > 0) {
                $params = array(
                    "sort" => 2,
                    'assemblyGroupNodeId' => $v->assemblyGroupNodeId,
                    "linkingTargetId" => $params["linkingTargetId"],
                );
                $articles = $this->getArticleIds($params);
                $articleIds = array();
                foreach ($articles->data->array as $vl) {
                    if (!in_array($vl->articleId, $articleIds))
                        $articleIds[] = $vl->articleId;
                }
                $v->articleIds = $articleIds;
            }
            $this->c[$v->assemblyGroupNodeId] = $v;

            if (!in_array($v->assemblyGroupNodeId, (array) $this->cids))
                $this->cids[] = $v->assemblyGroupNodeId;


            if ($hasChilds) {
                $params["parentNodeId"] = $v->assemblyGroupNodeId;
                $this->linkedChildNodesAllLinkingTargetTree($params, $lvl);
            }
        }
        return array_unique($this->cids);
        //echo serialize($this->c);
    }

    function linkedChildNodesAllLinkingTargetTree($params = array(), $lvl = 0) {

        $linkedChildNodesAllLinkingTarget = $this->getLinkedChildNodesAllLinkingTarget($params);
        $lvl++;
        if (!$params["linkingTargetId"]) {
            $params["linkingTargetId"] = 1;
        }

        //echo serialize($linkedChildNodesAllLinkingTarget->data->array);

        foreach ($linkedChildNodesAllLinkingTarget->data->array as $v) {
            $hasChilds = $v->hasChilds;
            if ($v->articles_count == 0 AND $v->parentNodeId > 0) {
                //echo $v->assemblyGroupName."<BR>";
                continue;
            }


            if ($v->parentNodeId > 0) {
                $params = array(
                    "sort" => 2,
                    'assemblyGroupNodeId' => $v->assemblyGroupNodeId,
                    "linkingTargetId" => $params["linkingTargetId"],
                );
                $articles = $this->getArticleIds($params);
                $articleIds = array();
                foreach ($articles->data->array as $vl) {
                    if (!in_array($vl->articleId, $articleIds))
                        $articleIds[] = $vl->articleId;
                }
                $v->articleIds = $articleIds;
            }
            $this->c[$v->assemblyGroupNodeId] = $v;

            if ($hasChilds) {
                $params["parentNodeId"] = $v->assemblyGroupNodeId;
                $this->linkedChildNodesAllLinkingTargetTree($params, $lvl);
            }
        }
        return $this->c;
        //echo serialize($this->c);
    }

    public function getArticleIds($params) {

        //$this->articleIdsParams["brandNo"] = array(43);

        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "linkingTargetType" => $this->linkingTargetType,
            "sort" => 2,
            /*
              "brandNo" => array(
              "empty" => empty($this->articleIdsParams["brandNo"]) ? true : false,
              "array" => $this->articleIdsParams["brandNo"]
              ),
              "genericArticleId" => array(
              "empty" => empty($this->articleIdsParams["genericArticleId"]) ? true : false,
              "array" => $this->articleIdsParams["genericArticleId"]
              ),
             * 
             */
//            "brandNo" => $params["brandNo"],
//            "genericArticleId" => $params["genericArticleId"],
            "assemblyGroupNodeId" => (int) $params["assemblyGroupNodeId"],
            "linkingTargetId" => (int) $params["linkingTargetId"],
        );

        if ($this->useSOAP) {
            return $this->soap->getArticleIds3($params);
        } else {
            if ($this->useCustomSearch)
                return $this->package($this->tecdoc->getArticlesforType_tree2($params["linkingTargetId"], $params["assemblyGroupNodeId"], $params['brandNo']['array'], $params['genericArticleId']['array']));
            else
                return $this->package($this->tecdoc->getArticlesforType_tree($params["linkingTargetId"], $params["assemblyGroupNodeId"], $params['brandNo']['array'], $params['genericArticleId']['array']));
        }
    }

    public function getArticlesSearch($params) {
        if ($this->useSOAP) {
            return $this->soap->getArticleIds3($params);
        } else {
            //print_r($this->tecdoc->getArticlesSearch($params["search"]));
            //echo $params["search"];
            return $this->package($this->tecdoc->getArticlesSearch($params["search"]));
        }
    }

    public function getChildNodesAllLinkingTarget() {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "childNodes" => true,
            "linkingTargetType" => $this->linkingTargetType);
        return $this->soap->getChildNodesAllLinkingTarget2($params);
    }

    public function getVehicleDetails($params) {

        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "countriesCarSelection" => $this->country,
            "countryUserSetting" => $this->country,
            "childNodes" => true,
            "carIds" => (int) $params["carId"],
            "countryGroupFlag" => false,
            "vehicleTerms" => false,
            "motorCodes" => false,
            "vehicleDetails" => true,
            "axles" => false,
            "secondaryTypes" => false,
            "cabs" => false,
            "wheelbases" => false
        );
        if ($this->useSOAP) {
            return $this->soap->getVehicleByIds2Single($params);
        } else {
            return $this->package($this->tecdoc->getVehicleDetails($params['carIds']));
        }
    }

    public function getTreeForArticle($id) {
        return $this->tecdoc->getTreeForArticle((int) $id);
    }

    public function countArticleIds1($params) {
        //return 1;

        $params = array(
            /*
              "brandNo" =>
              array("empty" => false,
              "array" => $this->articleIdsParams["brandNo"]
              ),
              "genericArticleId" =>
              array("empty" => false,
              "array" => $this->articleIdsParams["genericArticleId"]
              ),
             */
            "sort" => 2,
            'assemblyGroupNodeId' => $params["assemblyGroupNodeId"],
            'linkingTargetId' => $params["linkingTargetId"],
        );
        $articles = $this->getArticleIds($params);
        return count($articles->data->array);
    }

    public function countArticleIds2($params) {
        //return 1;
        /*
          if (!$this->articleIdsParams["brandNo"])
          return;
          if (!$this->articleIdsParams["genericArticleId"])
          return;
         */

        $articles = $this->getArticleIds($params);
        $articleIds = array();
        foreach ($articles->data->array as $v) {
            $articleIds[] = $v->articleId;
        }
        $articles = array();


        if (count($articleIds) > 0) {
            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');



            $query = 'SELECT count(id) as cnt FROM autoparts_tecdoc_product WHERE model_type="' . $params["linkingTargetId"] . '" AND tecdoc_article_id in (' . implode(',', $articleIds) . ')';
            $cnt = $readConnection->fetchOne($query);

            //$articles = Mage::getSingleton('tecdoc/product')->getCollection()->addFieldToFilter('tecdoc_article_id', array('in' => $articleIds));
            //$sql        = "Select id autoparts_tecdoc_product where tecdoc_article_id in (".explode(",",$articleIds).")";
            //$articles   = $connection->fetchAll($sql); 
            //return array_diff($this->tecdocproductids,$articleIds);
        } else {
            return 0;
        }
        return $cnt['cnt'];
        //return count($articles);
    }

    public function getArticleDirectSearchAllNumbers($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "sortType" => 1,
            "numberType" => 0,
            "searchExact" => true,
            "articleNumber" => $params["articleNumber"], //$model->getTecdocCode(),
            "brandno" => $params["brandno"]//$model->getTecdocSupplierId()
        );
        if ($this->useSOAP) {
            return $this->soap->getArticleDirectSearchAllNumbers2($params);
        } else {
            return $this->package($this->tecdoc->getArticle($params['articleNumber'], $params['brandno']));
        }
    }

    public function getArticleLinkedAllLinkingTarget($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "linkingTargetType" => $this->linkingTargetType,
            "linkingTargetId" => "",
            "sortType" => 1,
            "articleId" => (int) $params["articleId"]// $model->tecdoc_article_id
        );

        if ($this->useSOAP) {
            return $articleLinkedAllLinkingTarget = $this->soap->getArticleLinkedAllLinkingTarget2($params);
        } else {
            return $this->package($this->tecdoc->getTypesForArticle($params["articleId"]));
        }
    }

    public function getAssignedArticlesByIds($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "linkingTargetType" => $this->linkingTargetType,
            "manuId" => "",
            "modId" => "",
            //"linkingTargetId" => "",
            "attributs" => true,
            "info" => false,
            "prices" => false,
            "eanNumbers" => false,
            "usageNumbers" => false,
            "replacedNumbers" => false,
            "replacedByNumbers" => false,
            "mainArticles" => false,
            "documents" => false,
            "oeNumbers" => false,
            "normalAustauschPrice" => false,
            "immediateAttributs" => false,
            "immediateInfo" => false,
            "documentsData" => false,
            "articleLinkId" => '',
            "articleId" => (int) $params["articleId"], // array("empty" => false,"array" => array($params["articleId"])
            //"articleId" => $params["articleId"]// $model->tecdoc_article_id
            "linkingTargetId" => $params["linkingTargetId"]
        );

        if ($this->useSOAP) {
            return $this->soap->getAssignedArticlesByIds2Single($params);
        } else {
            return $this->package($this->tecdoc->getArticleCriteria($params["articleId"], $params["linkingTargetId"]));
        }
    }

    public function getArticleImages($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "linkingTargetType" => $this->linkingTargetType,
            "linkingTargetId" => "",
            "sortType" => 1,
            "articleId" => (int) $params["articleId"]// $model->tecdoc_article_id
        );
        return $this->package($this->tecdoc->getArticleImages($params["articleId"]));
    }

    public function getArticlesSearchByIds($params) {

        if ($this->useSOAP) {
            return $this->soap->getArticleIds3($params);
        } else {
            return $this->package($this->tecdoc->getArticlesSearchByIds($params["search"]));
        }
    }

    public function getOriginals($params) {
        $params = array(
            "country" => $this->country,
            "lang" => $this->lang,
            "provider" => $this->provider,
            "linkingTargetType" => $this->linkingTargetType,
            "linkingTargetId" => "",
            "sortType" => 1,
            "articleId" => (int) $params["articleId"]// $model->tecdoc_article_id
        );
        return $this->package($this->tecdoc->getOriginals($params["articleId"]));
    }

    function originals($params) {


        $originals = $this->getOriginals($params);
        $html = "<ul>";
        foreach ($originals->data->array as $v) {
            $html .= "<li><b>" . $v->brand . "</b>: " . $v->original . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    function efarmoges($params) {

        $articleLinkedAllLinkingTarget = $this->getArticleLinkedAllLinkingTarget($params);
        //print_r($articleLinkedAllLinkingTarget);
        $out = array();
        foreach ($articleLinkedAllLinkingTarget->data->array as $v) {
            if ($kkk++ > 500)
                break;
            $out[] = $v->linkingTargetId;
        }
        return $out;
    }

    function articleAttributesRow($params = array()) {

        $attributs = $this->getAssignedArticlesByIds($params);
        $arr = array();
        //echo serialize($attributs->data->array[0]->articleAttributes->array);
        //return;

        $descrption .= "<ul class='product_attributes'>";
        $attributes = array();
        foreach ($attributs->data->array[0]->articleAttributes->array as $attribute) {
            if (!$attributes[$attribute->attrId]) {
                $attributes[$attribute->attrId][] = trim(str_replace("[" . $attribute->attrUnit . "]", "", $attribute->attrName)) . ": " . $attribute->attrValue . $attribute->attrUnit;
            } else {
                $attributes[$attribute->attrId][] = $attribute->attrValue . $attribute->attrUnit;
            }
        }
        foreach ($attributes as $attrId => $attribute) {
            //if (!in_array($attribute->attrId, $arr)) {
            $arr[$attrId] = $attribute->attrId;
            $descrption .= "<li class='attr_" . $attrId . "'>" . implode(" / ", $attribute) . "</li>";
            //}
        }
        $descrption .= "</ul>";
        return $descrption;
    }

    /*
      public function getCorrectArtcleNr($article_nr, $supp_nr) {
      return $this->tecdoc->getCorrectArtcleNr($article_nr, $supp_nr);
      }
     */

    public function getCorrectArtcleNr($article_nr, $supp_nr) {
        return $this->tecdoc->getCorrectArtcleNr($article_nr, $supp_nr);
    }

    public function getCorrectArtcleNr2($article_nr, $supp_nr) {
        return $this->tecdoc->getCorrectArticleNr2($article_nr, $supp_nr);
    }

    public function createArticleIdsParams($linkingTargetId) {
        return;
        $sql = "Select tecdoc_supplier_id, tecdoc_generic_article_id from autoparts_tecdoc_product where id in (select product from autoparts_tecdoc_product_linking_model_type where model_type = '" . $linkingTargetId . "')";
        $datas = Mage::getSingleton("core/resource")->getConnection("core_read")->fetchAll($sql);
        foreach ($datas as $data) {
            if (!in_array($data["tecdoc_supplier_id"], $this->articleIdsParams["brandNo"]))
                $this->articleIdsParams["brandNo"][] = $data["tecdoc_supplier_id"];
            if (!in_array($data["tecdoc_generic_article_id"], $this->articleIdsParams["genericArticleId"]))
                $this->articleIdsParams["genericArticleId"][] = $data["tecdoc_generic_article_id"];
        }
        return $this->articleIdsParams;
    }

    public function createCategories() {
        $cats = $this->getChildNodesAllLinkingTarget();
        foreach ($cats->data->array as $v) {
            $category = Mage::getModel('catalog/category')->load($v->assemblyGroupNodeId);
            if ($category->getEntityId() > 0) {
                continue;
            } else {
                $category = Mage::getModel('catalog/category');
                $category->setEntityId($v->assemblyGroupNodeId);
                $category->setName($v->assemblyGroupName);
                $category->setUrlKey($this->greeklish($v->assemblyGroupName));
                $category->setIsActive(1);
                $category->setIsAnchor(1); //for active achor
                $category->setStoreId(Mage::app()->getStore()->getId());
                $category->save();
                if ($v->parentNodeId > 0) {
                    $this->setParentCategory($category, $v->parentNodeId);
                } else {
                    $this->setParentCategory($category, $this->tecdoccategory);
                }
            }
        }
    }

    public function createCategory($category, $v) {
        if ($category->getEntityId() > 0) {
            //$category = Mage::getModel('catalog/category');
            //$category->setEntityId($v->assemblyGroupNodeId);


            return $category;

            $category->setName($v->assemblyGroupName);
            $category->setWeight($v->weight);
            $category->setQty(1);
            $category->setUrlKey($this->greeklish($v->assemblyGroupName));
            $category->setIsActive(1);
            $category->setIsAnchor(1); //for active achor
            //$category->setStoreId(Mage::app()->getStore()->getId());
            $category->setStoreId(2);
            $category->save();

            /*
              if ($v->parentNodeId > 0) {
              try {
              $this->setParentCategory($category, $v->parentNodeId);
              } catch (Exception $e) {
              $this->setParentCategory($category, $this->tecdoccategory);
              }
              } else {
              $this->setParentCategory($category, $this->tecdoccategory);
              }
             */
            return $category;
        } else {
            $category = Mage::getModel('catalog/category');
            $category->setEntityId($v->assemblyGroupNodeId);
            $category->setName($v->assemblyGroupName);
            $category->setWeight($v->weight);
            $category->setQty(1);
            $category->setUrlKey($this->greeklish($v->assemblyGroupName));
            $category->setIsActive(1);
            $category->setIsAnchor(1); //for active achor
            $category->setStoreId(Mage::app()->getStore()->getId());
            $category->save();
            if ($v->parentNodeId > 0) {
                try {
                    $this->setParentCategory($category, $v->parentNodeId);
                } catch (Exception $e) {
                    $this->setParentCategory($category, $this->tecdoccategory);
                }
            } else {
                $this->setParentCategory($category, $this->tecdoccategory);
            }
            return $category;
        }
    }

    public function countArticleIds($params) {
        return $this->countArticleIds2($params);
    }

    public function greeklish($name) {
        $greek = array('α', 'ά', 'Ά', 'Α', 'β', 'Β', 'γ', 'Γ', 'δ', 'Δ', 'ε', 'έ', 'Ε', 'Έ', 'ζ', 'Ζ', 'η', 'ή', 'Η', 'θ', 'Θ', 'ι', 'ί', 'ϊ', 'ΐ', 'Ι', 'Ί', 'κ', 'Κ', 'λ', 'Λ', 'μ', 'Μ', 'ν', 'Ν', 'ξ', 'Ξ', 'ο', 'ό', 'Ο', 'Ό', 'π', 'Π', 'ρ', 'Ρ', 'σ', 'ς', 'Σ', 'τ', 'Τ', 'υ', 'ύ', 'Υ', 'Ύ', 'φ', 'Φ', 'χ', 'Χ', 'ψ', 'Ψ', 'ω', 'ώ', 'Ω', 'Ώ', ' ', "'", "'", ',');
        $english = array('a', 'a', 'A', 'A', 'b', 'B', 'g', 'G', 'd', 'D', 'e', 'e', 'E', 'E', 'z', 'Z', 'i', 'i', 'I', 'th', 'Th', 'i', 'i', 'i', 'i', 'I', 'I', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'x', 'X', 'o', 'o', 'O', 'O', 'p', 'P', 'r', 'R', 's', 's', 'S', 't', 'T', 'u', 'u', 'Y', 'Y', 'f', 'F', 'ch', 'Ch', 'ps', 'Ps', 'o', 'o', 'O', 'O', '-', '-', '-', '-');
        $string = str_replace($greek, $english, $name);
        return $string;
    }

    public function setParentCategory($category, $parent_id, $afterId = 1) {
        $category->move($parent_id, $afterId);
        return true;
    }

    public function setArticleIdsParams($articleIdsParams) {
        $this->articleIdsParams = $articleIdsParams;
        return $this;
    }

    private function package($data) {
        $package = new \stdClass();
        $package->data = new \stdClass();
        $package->data->array = $data;
        $package->data->empty = empty($data);
        $package->status = 200;
        $package->statusText = null;
        return $package;
    }

}

?>
