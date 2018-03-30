<?php

namespace EdiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use AppBundle\Entity\Tecdoc as Tecdoc;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * EdiItem
 */
class EdiItem extends Entity {

    var $tecdoc;

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var string
     */
    private $itemCode;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $partno;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $cats;

    /**
     * @var string
     */
    private $cars;

    /**
     * @var integer
     */
    private $dlnr;

    /**
     * @var string
     */
    private $artNr;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var string
     */
    private $retailprice;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    var $id;

    /**
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return EdiItem
     */
    public function setItemCode($itemCode) {
        $this->itemCode = $itemCode;

        return $this;
    }

    /**
     * Get itemCode
     *
     * @return string
     */
    public function getItemCode() {
        return $this->itemCode;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return EdiItem
     */
    public function setBrand($brand) {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * Set partno
     *
     * @param string $partno
     *
     * @return EdiItem
     */
    public function setPartno($partno) {
        $this->partno = $partno;

        return $this;
    }

    /**
     * Get partno
     *
     * @return string
     */
    public function getPartno() {
        return $this->partno;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return EdiItem
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set cats
     *
     * @param string $cats
     *
     * @return EdiItem
     */
    public function setCats($cats) {
        $this->cats = serialize($cats);
        return $this;
    }

    /**
     * Get cats
     *
     * @return string
     */
    public function getCats() {
        return unserialize($this->cats);
    }

    /**
     * Set cats
     *
     * @param string $cars
     *
     * @return EdiItem
     */
    public function setCars($cars) {
        $this->cars = serialize($cars);
        return $this;
    }

    /**
     * Get cars
     *
     * @return string
     */
    public function getCars() {
        return unserialize($this->cars);
    }

    /**
     * Set dlnr
     *
     * @param integer $dlnr
     *
     * @return EdiItem
     */
    public function setDlnr($dlnr) {
        $this->dlnr = $dlnr;

        return $this;
    }

    /**
     * Get dlnr
     *
     * @return integer
     */
    public function getDlnr() {
        return $this->dlnr;
    }

    /**
     * Set artNr
     *
     * @param string $artNr
     *
     * @return EdiItem
     */
    public function setArtNr($artNr) {
        $this->artNr = $artNr;

        return $this;
    }

    /**
     * Get artNr
     *
     * @return string
     */
    public function getArtNr() {
        return $this->artNr;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EdiItem
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return EdiItem
     */
    public function setActioneer($actioneer) {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer() {
        return $this->actioneer;
    }

    /**
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return EdiItem
     */
    public function setRetailprice($retailprice) {
        $this->retailprice = $retailprice;

        return $this;
    }

    /**
     * Get retailprice
     *
     * @return string
     */
    public function getRetailprice() {
        return $this->retailprice;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return EdiItem
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return EdiItem
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @var \EdiBundle\Entity\Edi
     */
    private $Edi;

    /**
     * Set edi
     *
     * @param \EdiBundle\Entity\Edi $edi
     *
     * @return EdiItem
     */
    public function setEdi(\EdiBundle\Entity\Edi $edi = null) {
        $this->Edi = $edi;

        return $this;
    }

    /**
     * Get edi
     *
     * @return \EdiBundle\Entity\Edi
     */
    public function getEdi() {
        return $this->Edi;
    }

    /**
     * @var string
     */
    private $tecdocArticleName;

    /**
     * @var integer
     */
    private $tecdocGenericArticleId;

    /**
     * @var integer
     */
    private $tecdocArticleId;
    
    /**
     * @var integer
     */
    private $tecdocArticleId3;
    /**
     * Set tecdocArticleName
     *
     * @param string $tecdocArticleName
     *
     * @return EdiItem
     */
    public function setTecdocArticleName($tecdocArticleName) {
        $this->tecdocArticleName = $tecdocArticleName;

        return $this;
    }

    /**
     * Get tecdocArticleName
     *
     * @return string
     */
    public function getTecdocArticleName() {
        return $this->tecdocArticleName;
    }

    /**
     * Set tecdocGenericArticleId
     *
     * @param integer $tecdocGenericArticleId
     *
     * @return EdiItem
     */
    public function setTecdocGenericArticleId($tecdocGenericArticleId) {
        $this->tecdocGenericArticleId = $tecdocGenericArticleId;

        return $this;
    }

    /**
     * Get tecdocGenericArticleId
     *
     * @return integer
     */
    public function getTecdocGenericArticleId() {
        return $this->tecdocGenericArticleId;
    }

    /**
     * Set tecdocArticleId
     *
     * @param integer $tecdocArticleId
     *
     * @return EdiItem
     */
    public function setTecdocArticleId($tecdocArticleId) {
        $this->tecdocArticleId = $tecdocArticleId;

        return $this;
    }
    /**
     * Set tecdocArticleId
     *
     * @param integer $tecdocArticleId3
     *
     * @return EdiItem
     */
    public function setTecdocArticleId3($tecdocArticleId3) {
        $this->tecdocArticleId = $tecdocArticleId3;

        return $this;
    }    

    function updatetecdoc($forceupdate = false) {
        //$data = array("service" => "login", 'username' => 'dev', 'password' => 'dev', 'appId' => '2000');

        if ((int) $this->dlnr == 0 OR $this->artNr == '')
            return;


        //echo $this->getTecdocArticleId();




        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        //$data_string = json_encode($data);
        /*
          if ($_SERVER["DOCUMENT_ROOT"] == 'C:\symfony\alexander\web') {
          $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
          @$fields = array(
          'action' => 'updateTecdoc',
          'tecdoc_code' => $this->artNr,
          'tecdoc_supplier_id' => $this->dlnr,
          );

          //print_r($fields);

          $fields_string = '';
          foreach ($fields as $key => $value) {
          @$fields_string .= $key . '=' . $value . '&';
          }
          rtrim($fields_string, '&');
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $out = json_decode(curl_exec($ch));
          print_r($out);

          } else {
         */
        $postparams = array(
            "articleNumber" => $this->artNr,
            "brandno" => $this->dlnr,
            "lng" => 20
        );
        
        $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            $postparams = array(
                "articleNumber" => $this->artNr,
                "brandno" => $this->dlnr,
                "lng" => 20
            );
            print_r($postparams);
            $term = preg_replace("/[^a-zA-Z0-9]+/", "", $postparams["articleNumber"]);
            $sql = "SELECT * FROM magento2_base4q2017.suppliers, magento2_base4q2017.articles art,magento2_base4q2017.products pt,magento2_base4q2017.art_products_des artpt,magento2_base4q2017.text_designations tex
                    WHERE 
                    artpt.art_id = art.art_id AND 
                    suppliers.sup_id = art.art_sup_id AND 
                    pt.pt_id = artpt.pt_id AND
                    tex.des_id = pt.pt_des_id AND
                    tex.des_lng_id = '" . $postparams["lng"] . "' AND 
                    (
                    art_article_nr_can LIKE '" . $term . "' AND sup_id = '" . $postparams["brandno"] . "'
            )";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $datas = unserialize(file_get_contents($url));
            //$result = mysqli_query($this->conn,$sql);
            //$datas = mysqli_fetch_all($result,MYSQLI_ASSOC);
            $data = $datas[0];
            //$out = array();
            $out = new \stdClass();
            if ($data) {
                $out->articleId = $data["art_id"];
                $out->articleName = $data["des_text"];
                $out->genericArticleId = $data["pt_des_id"];
            }
            //print_r($out);
            if (@$out->articleId) {
                $this->setTecdocArticleId($out->articleId);
                $this->setTecdocArticleName($out->articleName);
                //$this->tecdocArticleId= $out->articleId;
                $categories = array();
                $cars = array();
                $sql = "update partsbox_db.`edi_item` set tecdoc_article_id3 = '" . $out->articleId . "' where id = '" . $this->id . "'";
                echo $sql."<BR>";
                $em->getConnection()->exec($sql);
                $this->tecdocArticleId2 = $out->articleId;
                $this->getDetailssnew();
            }
            return;
        }        
        return;
        //echo ".";
        if ($this->getTecdocArticleId() > 0 and $forceupdate == false)
            return;
        $tecdoc = $this->tecdoc ? $this->tecdoc : new Tecdoc(); //new Tecdoc();

        $articleDirectSearchAllNumbers = $tecdoc->getArticleDirectSearchAllNumbers($postparams);
        $tectdoccode = $this->artNr;
        if (count($articleDirectSearchAllNumbers->data->array) == 0) {
            $articleId = $tecdoc->getCorrectArtcleNr($tectdoccode, $postparams["brandno"]);
            if ($article != $tectdoccode) {
                $params = array(
                    "articleNumber" => $articleId,
                    "brandno" => $postparams["brandno"]
                );
                $articleDirectSearchAllNumbers = $tecdoc->getArticleDirectSearchAllNumbers($params);
            }
        }
        if (count($articleDirectSearchAllNumbers->data->array) == 0) {
            $articleId = $tecdoc->getCorrectArtcleNr2(strtolower($tectdoccode), $postparams["brandno"]);
            if ($article != strtolower($tectdoccode)) {
                $params = array(
                    "articleNumber" => $articleId,
                    "brandno" => $postparams["brandno"]
                );
                $articleDirectSearchAllNumbers = $tecdoc->getArticleDirectSearchAllNumbers($params);
            }
        }
        $out = $articleDirectSearchAllNumbers->data->array[0];
        //print_r($out);
        // }

        try {
            //$em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
            //$webserviceProduct = WebserviceProduct::model()->findByAttributes(array('product' =>  $this->id,"webservice"=>$this->webservice));
            //$sql = "Delete from SoftoneBundle:WebserviceProduct p where p.product = '" . $this->id . "'";
            //$em->createQuery($sql)->getResult();
            //$em->execute();
            if (@$out->articleId) {
                //echo $out->articleId."<BR>";
                //echo $this->id . "<BR>";
                $this->setTecdocArticleId($out->articleId);
                $this->setTecdocArticleName($out->articleName);
                //$this->setTecdocGenericArticleId($out->articleName);
                $cats = $tecdoc->getTreeForArticle($out->articleId);
                //print_r((array)$cats);

                $params = array(
                    "articleId" => $out->articleId
                );
                $articleLinkedAllLinkingTarget = $tecdoc->getArticleLinkedAllLinkingTarget($params);
                $cars = array();
                $linkingTargetId = 0;
                foreach ($articleLinkedAllLinkingTarget->data->array as $v) {
                    if ($linkingTargetId == 0)
                        $linkingTargetId = $v->linkingTargetId;
                    $cars[] = $v->linkingTargetId;
                    //break;
                }
                $categories2 = array();
                foreach ($cats as $cat) {
                    $categories2[] = $cat->tree_id;
                }
                $categories = $this->checkForUniqueCategory($out, $cats, $tecdoc, $linkingTargetId);
                if (count($categories) == 0) {
                    $categories = $categories2;
                }
                //print_r($categories);
                //print_r($cars);

                $sql = "update partsbox_db.edi_item set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . addslashes($out->articleName) . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
                //echo $sql."<BR>";
                $em->getConnection()->exec($sql);

                $this->setCats($categories);
                $this->setCars($cars);
                //$em->persist($this);
                //$em->flush();
            } else {
                /*
                  $this->setTecdocArticleId(-1);
                  //$this->setTecdocGenericArticleId($out->articleName);
                  $em->persist($this);
                  $em->flush();
                 * 
                 */
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        //echo $result;
    }
    
    
    
     function getDetailssnew() {
        
        
        echo "[".$this->tecdocArticleId2."]";
        if ($this->tecdocArticleId2 == 0)
            return;
        //$this->getDetails();
        //return;
        $this->lng = 20;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        //$this->connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $sql = "select * from partsbox_db.edi_product_model_type where product = '" . $this->getId() . "'";
        echo $sql."<BR>";
        //$results = $this->connection->fetchAll($sql);
        $categories = array();
        $cars = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();

        if (count($results) == 0) {
            $sql = "Select mod_lnk_vich_id from magento2_base4q2017.art_mod_links a, magento2_base4q2017.models_links b where `mod_lnk_type` = 1 AND a.mod_lnk_id = b.mod_lnk_id and art_id = '" . $this->tecdocArticleId . "' group by `mod_lnk_vich_id`";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $out = unserialize(file_get_contents($url));
            //$out = $this->connection->fetchAll($sql);
            //$result = mysqli_query($this->conn,$sql);
            //$out =  mysqli_fetch_all($result,MYSQLI_ASSOC);		
            $sql = "delete from partsbox_db.edi_product_model_type where product = '" . $this->getId() . "'";
            $em->getConnection()->exec($sql);
            //$this->connection->query($sql);
            foreach ($out as $model_type) {
                if ($model_type == 0)
                    continue;
                $sql = "insert ignore partsbox_db.edi_product_model_type set product = '" . $this->getId() . "', model_type = '" . $model_type["mod_lnk_vich_id"] . "'";
                //echo $sql."<BR>";
                //$this->connection->query($sql);
                $cars[] = $model_type["mod_lnk_vich_id"];
                $em->getConnection()->exec($sql);
            }
        }
        //return;		
        $sql = "select * from magento2_base4q2017.article_criteria, magento2_base4q2017.criteria, magento2_base4q2017.text_designations
			where acr_cri_id = 100 AND cri_id = acr_cri_id AND des_id = cri_des_id and des_lng_id = '" . $this->lng . "' and acr_art_id = '" . $this->tecdocArticleId2. "'";
        //$criteria = $this->connection->fetchRow($sql);
        //echo $sql."<BR>";

        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
        $criteria = unserialize(file_get_contents($url));

        //$result = mysqli_query($this->conn,$sql);
        //$criteria =  mysqli_fetch_all($result,MYSQLI_ASSOC);
        //echo mysqli_error();
        //print_r($criteria);
        //exit;
        $criteria = $criteria[0];
        //print_r($criteria);
        //echo "<BR>";
        if ($criteria["acr_kv_kt_id"]) {
            $sql = "select kv_kv from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["acr_kv_kt_id"] . "' AND kv_kv = '" . $criteria["acr_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";
            echo $sql . "<BR>";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $kv_kv = unserialize(file_get_contents($url));
            //$result = $result = mysqli_query($this->conn,$sql);
            //$kv_kv =  mysqli_fetch_row($result,MYSQLI_ASSOC);	
            $kv_kv = $kv_kv[0];
            $kv = $kv_kv["kv_kv"]; // kv_kv HA VA
        }

        //if ($kv != 'VA' AND $kv != 'HA' ) return;

        $sql = "SELECT `str_id` FROM magento2_base4q2017.link_pt_str WHERE `str_type` = 1 AND pt_id in (Select pt_id from magento2_base4q2017.art_products_des where art_id = '" . $this->tecdocArticleId. "')";
        //$out = $this->connection->fetchAll($sql); 
        //echo $sql."<BR>";

        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
        $out = unserialize(file_get_contents($url));

        //$result = mysqli_query($this->conn,$sql);
        //$out =  mysqli_fetch_all($result,MYSQLI_ASSOC);	
        //print_r($out);
        //
        //exit;
        
        $del = false;
        $array = array(11023, 11199, 11001, 11109, 11176, 11024, 11200, 11002, 11110, 11177);
        foreach ($out as $category) {
            $sql = "select * from cat2cat where oldnew_id = '" . $category["str_id"] . "'";
            //$cats = $this->connection->fetchAll($sql);
            $connection = $em->getConnection();
            $statement = $connection->prepare($sql);
            $statement->execute();
            $cats = $statement->fetchAll();    
            $statement->closeCursor();
            foreach ($cats as $cat) {
                if (in_array($cat["w_str_id"], $array)) {
                    $del = true;
                    if ($kv == "") {
                        $term = preg_replace("/[^a-zA-Z0-9]+/", "", $this->artNr);
                        $sql = "SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '" . $term . "'";
                        //$arts = $this->connection->fetchAll($sql);
                        //$result = mysqli_query($this->conn,$sql);
                        //$arts =  mysqli_fetch_all($result,MYSQLI_ASSOC);							
                        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                        $arts = unserialize(file_get_contents($url));

                        foreach ($arts as $art) {
                            $sql = "select * from magento2_base4q2017.article_criteria, magento2_base4q2017.criteria, magento2_base4q2017.text_designations
								where acr_cri_id = 100 AND cri_id = acr_cri_id AND des_id = cri_des_id and des_lng_id = '" . $this->lng . "' and acr_art_id = '" . $art["all_art_id"] . "'";
                            //$criteria = $this->connection->fetchRow($sql);
                            //$result = $result = mysqli_query($this->conn,$sql);
                            //$criteria =  mysqli_fetch_row($result,MYSQLI_ASSOC);	

                            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                            $criteria = unserialize(file_get_contents($url));
                            $criteria = $criteria[0];
                            if ($criteria["acr_kv_kt_id"]) {
                                $sql = "select kv_kv from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["acr_kv_kt_id"] . "' AND kv_kv = '" . $criteria["acr_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";
                                //$kv = $this->connection->fetchOne($sql); // kv_kv HA VA	
                                //$result = $result = mysqli_query($this->conn,$sql);
                                //$kv_kv =  mysqli_fetch_row($result,MYSQLI_ASSOC);		
                                $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                                $kv_kv = unserialize(file_get_contents($url));
                                $kv_kv = $kv_kv[0];
                                $kv = $kv_kv["kv_kv"]; // kv_kv HA VA
                            }

                            if ($kv != "") {
                                echo "<BR>[" . $kv . "]<BR>";
                                break;
                            }
                        }
                        //$sql = "insert ignore partsbox_db.edi_product_category set product = '" . $product->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                        //echo "ΗΑVA: ".$sql."<BR>";
                    }
                }
            }
        }
        $sql = "delete from partsbox_db.edi_product_category where product = '" . $this->getId() . "'";
        $em->getConnection()->exec($sql);
        echo "<BR>" . $sql . "<BR>";
        //return;
        echo "<BR>" . $kv . "<BR>";
        //return;
        $connection = $em->getConnection();
        $sqls = array();
        foreach ($out as $category) {
            $sql1 = "select * from magento2_base4q2017.cat2cat where oldnew_id = '" . $category["str_id"] . "'";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql1);
            $cats = unserialize(file_get_contents($url));
            /*
            $sql = "select * from cat2cat where oldnew_id = '" . $category["str_id"] . "'";
            //$cats = $this->connection->fetchAll($sql);
            
            $statement = $connection->prepare($sql);
            $statement->execute();
            $cats = $statement->fetchAll();
            $statement->closeCursor();
            unset($statement);
            //$statement->close();
            */
            foreach ($cats as $cat) {

                // 11001, 11176 --> VA
                // 11002, 11177 --> HA
                if ($cat["w_str_id"] == 11023 OR $cat["w_str_id"] == 11199 OR $cat["w_str_id"] == 11001 OR $cat["w_str_id"] == 11109 OR $cat["w_str_id"] == 11176) {
                    if ($kv == 'VA') {
                        $sql = "insert ignore partsbox_db.edi_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                        $catva = true;
                        //echo "VA: " . $sql . "<BR>";
                        $categories[] = $cat["w_str_id"];
                    }
                } elseif ($cat["w_str_id"] == 11024 OR $cat["w_str_id"] == 11200 OR $cat["w_str_id"] == 11002 OR $cat["w_str_id"] == 11110 OR $cat["w_str_id"] == 11177) {
                    if ($kv == 'HA') {
                        $sql = "insert ignore partsbox_db.edi_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                        $catha = true;
                        //echo "ΗΑ: " . $sql . "<BR>";
                        $categories[] = $cat["w_str_id"];
                    }
                } else {
                    $sql = "insert ignore partsbox_db.edi_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                    $cattt = true;
                    //echo "VA: " . $sql . "<BR>";
                    $categories[] = $cat["w_str_id"];
                }
                //echo "[[".$sql."]]<BR>";
                //$this->connection->query($sql);
                $sqls[] = $sql;
                //$em->getConnection()->exec($sql);
                //echo "..";
            }
        }
        
        $em->flush(); // if you need to update something
        $em->clear();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        foreach($sqls as $sql) {
            $em->getConnection()->exec($sql);
        }
        //$sql = "update `softone_product` set cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
        //$em->getConnection()->exec($sql);        
        //print_r($out);
    }   

    function checkForUniqueCategory($article, $cats, $tecdoc, $linkingTargetId) {
        if ($cats <= 2)
            return array();
        $categories = array();
        foreach ($cats as $c) {

            $params = array(
                "assemblyGroupNodeId" => (int) $c->tree_id,
                "linkingTargetId" => (int) $linkingTargetId,
            );
            $articles = $tecdoc->getArticleIds($params);
            $getArticleIds = array();
            foreach ($articles->data->array as $v) {
                $getArticleIds[] = $v->articleId;
            }
            if (in_array($article->articleId, $getArticleIds)) {
                $categories[] = $c->tree_id;
            }
        }
        return $categories;
    }

    public function toErp() {

        if ($this->getSetting("AppBundle:Erp:erpprefix") == '/erp01') {
            $this->toMegasoftErp();
        } else {
            return $this->toSoftoneErp();
        }
    }

    private function createManufacturer() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }




        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $tecdocSupplier = $em->getRepository("MegasoftBundle:TecdocSupplier")
                ->findOneBy(array('supplier' => $this->fixsuppliers($this->brand)));

        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));


        $sql = "Select max(id) as max from megasoft_manufacturer";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $max = $statement->fetch();
        //if ($tecdocSupplier)
        $manufacturerCode = $tecdocSupplier ? $tecdocSupplier->getId() : $max["max"];

        $data["ManufacturerCode"] = $manufacturerCode;
        $data["ManufacturerName"] = $this->fixsuppliers($this->brand);
        $params["Login"] = $login;
        $params["JsonStrWeb"] = json_encode($data);
        $soap->__soapCall("SetManufacturer", array($params));
        unset($params["JsonStrWeb"]);

        $response = $soap->__soapCall("GetManufacturers", array($params));
        if (count($response->GetManufacturersResult->ManufacturerDetails) == 1) {
            $ManufacturerDetails[] = $response->GetManufacturersResult->ManufacturerDetails;
        } elseif (count($response->GetManufacturersResult->ManufacturerDetails) > 1) {
            $ManufacturerDetails = $response->GetManufacturersResult->ManufacturerDetails;
        }
        foreach ($ManufacturerDetails as $data) {
            $data = (array) $data;
            $entity = $em->getRepository("MegasoftBundle:Manufacturer")
                    ->find((int) $data["ManufacturerID"]);
            if (!$entity) {
                //$q[] = "`reference` = '" . $data[$params["megasoft_table"]] . "'";
                $sql = "insert megasoft_manufacturer set id = '" . $data["ManufacturerID"] . "', code = '" . $data["ManufacturerCode"] . "', title = '" . $data["ManufacturerName"] . "'";
                echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            } else {
                //$sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                $sql = "update megasoft_manufacturer set code = '" . $data["ManufacturerCode"] . "', title = '" . $data["ManufacturerName"] . "' where id = '" . $entity->getId() . "'";
                echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            }
        }
        $manufacturer = $em->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array('title' => $this->fixsuppliers($this->brand)));
        return $manufacturer;
    }

    private function toMegasoftErp() {

        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->updatetecdoc();

        $manufacturer = $em->getRepository("MegasoftBundle:Manufacturer")
                ->findOneBy(array('title' => $this->fixsuppliers($this->brand)));
        if (!$manufacturer) {
            $manufacturer = $this->createManufacturer();
        } else {
            //echo $manufacturer->getTitle();
        }
        $tecdocSupplier = $em->getRepository("MegasoftBundle:TecdocSupplier")->find($this->dlnr);


        $sql = "Select id from megasoft_product where replace(replace(replace(replace(replace(`supplier_item_code`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $this->clearstring($this->itemCode) . "' AND edi_id = '" . $this->getEdi()->getItemMtrsup() . "'";
        //echo $sql . "<BR>";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        $product = false;
        $supplier = $em->getRepository("MegasoftBundle:Supplier")->find($this->getEdi()->getItemMtrsup());
        if ($data["id"] > 0)
            $product = $em->getRepository("MegasoftBundle:Product")->find($data["id"]);

        if (!$product) {
            $erpCode = $this->clearCode($this->partno) . "-" . $manufacturer->getCode();
            $product = $em->getRepository("MegasoftBundle:Product")->findOneBy(array("erpCode" => $erpCode));
        }

        if (!$product) {
            $erpCode = $this->clearCode($this->partno) . "-" . $manufacturer->getCode();
            $product = $em->getRepository("MegasoftBundle:Product")->findOneBy(array("supplierCode" => $this->clearCode($this->partno), "manufacturer" => $manufacturer));
        }

        if ($product) {
            $product->setSupplierItemCode($this->itemCode);
            $product->setEdiId($this->getEdi()->getId());
            $product->setCars($this->getCars());
            $product->setCats($this->getCats());
            $storeWholeSalePrice = (float) $this->getEdiMarkupPrice("storeWholeSalePrice");
            $storeRetailPrice = (float) $this->getEdiMarkupPrice("storeRetailPrice");
            $product->setStoreRetailPrice($storeRetailPrice);
            $product->setStoreWholeSalePrice($storeWholeSalePrice);
            if ($supplier)
                $product->setSupplier($supplier);
            $em->persist($product);
            $em->flush();
            $product->toMegasoft();
            return;
        }

        $erpCode = $this->clearCode($this->partno) . "-" . $manufacturer->getCode();
        $productsale = $em->getRepository('MegasoftBundle:Productsale')->find(1);
        $dt = new \DateTime("now");
        $product = new \MegasoftBundle\Entity\Product;
        $product->setEdiId($this->getEdi()->getId());
        $product->setProductSale($productsale);
        if ($supplier)
            $product->setSupplier($supplier);

        $product->setTecdocSupplierId($tecdocSupplier);
        $product->setTecdocCode($this->artNr);
        $product->setTitle($this->description);
        $product->setTecdocArticleId($this->tecdocArticleId);
        $product->setManufacturer($manufacturer);
        $product->setErpCode($erpCode);
        $product->setSupplierItemCode($this->itemCode);
        $product->setCars($this->getCars());
        $product->setCats($this->getCats());
        $product->setSupplierCode($this->clearCode($this->partno));


        $storeWholeSalePrice = (float) $this->getEdiMarkupPrice("storeWholeSalePrice");
        $storeRetailPrice = (float) $this->getEdiMarkupPrice("storeRetailPrice");

        $product->setStoreRetailPrice($storeRetailPrice);
        $product->setStoreWholeSalePrice($storeWholeSalePrice);

        $product->setBarcode('');
        $product->setPlace('');
        $product->setRemarks('');

        $product->setTs($dt);
        $product->setCreated($dt);
        $product->setModified($dt);

        $em->persist($product);
        $em->flush();
        $product->setProductFreesearch();
        $product->toMegasoft();
    }

    private function toSoftoneErp() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->updatetecdoc();
        //$TecdocSupplier = new \SoftoneBundle\Entity\TecdocSupplier;
        //$TecdocSupplier->updateToSoftone();
        //$this->brand = $this->fixsuppliers($this->brand);

        $SoftoneSupplier = $em->getRepository("SoftoneBundle:SoftoneSupplier")
                ->findOneBy(array('title' => $this->fixsuppliers($this->brand)));

        //echo $SoftoneSupplier->id;
        //exit;
        if (@$SoftoneSupplier->id == 0) {

            $TecdocSupplier = $em->getRepository("SoftoneBundle:TecdocSupplier")
                    ->findOneBy(array('supplier' => $this->fixsuppliers($this->brand)));
            if (@$TecdocSupplier->id == 0) {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($this->fixsuppliers($this->brand));
                $SoftoneSupplier->setCode(' ');
                $em->persist($SoftoneSupplier);
                $em->flush();
                $SoftoneSupplier->setCode("G" . $SoftoneSupplier->getId());
                $em->persist($SoftoneSupplier);
                $em->flush();
                $SoftoneSupplier->toSoftone();
            } else {
                $SoftoneSupplier = new \SoftoneBundle\Entity\SoftoneSupplier;
                $SoftoneSupplier->setTitle($TecdocSupplier->getSupplier());
                $SoftoneSupplier->setCode($TecdocSupplier->id);
                $em->persist($SoftoneSupplier);
                $em->flush();
                $SoftoneSupplier->toSoftone();
            }
        } else {
            $SoftoneSupplier->toSoftone();
        }

        /*
          $TecdocSuppliers = $em->getRepository("SoftoneBundle:TecdocSupplier")->findAll();
          foreach($TecdocSuppliers as $TecdocSupplier) {
          $TecdocSupplier->toSoftone();
          }
         */
        if ($this->getEdi()->getFunc() == 'getComlineEdiPartMaster') {
            $this->setComlineSoap();
        }
        $TecdocSupplier = $em->getRepository("SoftoneBundle:TecdocSupplier")
                ->find($this->dlnr);


        if ($TecdocSupplier)
            $TecdocSupplier->toSoftone();


        $sql = "Select id from softone_product where replace(replace(replace(replace(replace(`item_cccref`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $this->clearstring($this->itemCode) . "' AND edi = '" . $this->getEdi()->getItemMtrsup() . "'";
        //echo $sql . "<BR>";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        $product = false;
        if ($data["id"] > 0)
            $product = $em->getRepository("SoftoneBundle:Product")->find($data["id"]);

        if (!$product) {
            $erpCode = $this->clearCode($this->partno) . "-" . $SoftoneSupplier->getCode();
            $product = $em->getRepository("SoftoneBundle:Product")->findOneBy(array("erpCode" => $erpCode));
        }
        if (@$product->id > 0) {
            //$product = $em->getRepository("SoftoneBundle:Product")->find($this->getProduct());
            //if ($product->getReference() == 0) {
            $product->setItemMtrmanfctr($SoftoneSupplier->getId());
            $product->setErpCode($this->clearCode($this->partno) . "-" . $SoftoneSupplier->getCode());
            $product->setItemCode($product->getErpCode());
            $product->setCars($this->getCars());
            $product->setCats($this->getCats());
            $product->setSupplierId($SoftoneSupplier);
            $product->setCccRef($this->itemCode);
            $product->setCccPriceUpd(1);
            //echo "itemPricer:".$this->getEdiMarkupPrice("itemPricer")."\n";
            //echo "itemPricew:".$this->getEdiMarkupPrice("itemPricew")."\n";
            $this->wholesaleprice = $this->getEdiQtyAvailability();
            $product->setItemPricer((double) $this->getEdiMarkupPrice("itemPricer"));
            $product->setItemPricew((double) $this->getEdiMarkupPrice("itemPricew"));
            $product->setItemPricew01((double) $this->getEdiMarkupPrice("itemPricew01"));

            $em->persist($product);
            $em->flush();
            if ($TecdocSupplier) {
                $product->setTecdocSupplierId($TecdocSupplier);
            }
            $product->toSoftone();
            //echo $this->clearCode($this->partno) . "-" . $SoftoneSupplier->getCode();
            return $product;
        }


        /*
          if ($this->getProduct() > 0) {
          if (!$product->getEdiId()) {
          $product->setEdi($this->getEdi()->getId());
          $product->setEdiId($this->id);
          $em->persist($product);
          $em->flush();
          $product->toSoftone();
          return;
          } else {
          if (!$product->getEdis()) {
          $edis = array();
          } else {
          $edis = unserialize($product->getEdis());
          }
          $edis[] = $this->id;
          $edis[] = $product->getEdiId();
          $edis = array_filter(array_unique($edis));
          $product->setEdis(serialize($edis));
          $em->persist($product);
          $em->flush();
          $product->toSoftone();
          return;
          }
          return;
          }
         * 
         */

        $productsale = $em->getRepository('SoftoneBundle:Productsale')->find(1);
        $dt = new \DateTime("now");
        $product = new \SoftoneBundle\Entity\Product;

        $product->setSupplierCode($this->clearCode($this->partno));
        $product->setTitle($this->description);
        $product->setTecdocCode($this->artNr);

        $product->setItemMtrsup($this->getEdi()->getItemMtrsup());

        if ($TecdocSupplier) {
            $product->setItemMtrmark($this->dlnr);
            $product->setTecdocSupplierId($TecdocSupplier);
        }

        $product->setSupplierId($SoftoneSupplier);
        $product->setTecdocCode($this->artNr);
        $product->setItemName($this->description);
        $product->setTecdocArticleId($this->tecdocArticleId);
        $product->setItemIsactive(1);
        $product->setItemApvcode($this->artNr);
        $product->setErpSupplier($this->fixsuppliers($this->brand));
        $product->setItemMtrmanfctr($SoftoneSupplier->getId());
        $product->setErpCode($erpCode);

        $product->setCccRef($this->itemCode);
        $product->setCccPriceUpd(1);
        $product->setItemCode($product->getErpCode());
        $product->setItemCode2($this->clearCode($this->partno));
        $product->setEdi($this->getEdi()->getId());
        $product->setEdiId($this->id);
        $product->setProductSale($productsale);

        $product->setCars($this->getCars());
        $product->setCats($this->getCats());
        $this->wholesaleprice = $this->getEdiQtyAvailability();
        $product->setItemPricer((double) $this->getEdiMarkupPrice("itemPricer"));
        $product->setItemPricew((double) $this->getEdiMarkupPrice("itemPricew"));

        $product->setItemPricew01((double) $this->getEdiMarkupPrice("itemPricew01"));


        $product->setItemV5($dt);
        $product->setTs($dt);
        $product->setItemInsdate($dt);
        $product->setItemUpddate($dt);
        $product->setCreated($dt);
        $product->setModified($dt);
        $em->persist($product);
        $em->flush();
        $product->updatetecdoc();
        $product->toSoftone();
        $this->updatetecdoc();

        //$this->setProduct($product->getId());
        $em->persist($this);
        $em->flush();
        $sql = 'UPDATE  `softone_product` SET `supplier_code` =  `item_code2`, `title` =  `item_name`, `tecdoc_code` =  `item_apvcode`, `erp_code` =  `item_code`';
        $em->getConnection()->exec($sql);

        $sql = 'UPDATE  `softone_product` SET `supplier_id` =  `item_mtrmanfctr` where item_mtrmanfctr > 0 AND item_mtrmanfctr in (SELECT id FROM `softone_softone_supplier`)';
        $em->getConnection()->exec($sql);

        $sql = 'update `softone_product` set product_sale = 1 where product_sale is null';
        $em->getConnection()->exec($sql);
        return $product;
    }

    function fixsuppliers($supplier) {
        if ($supplier == "FEBI")
            $supplier = str_replace("FEBI", "FEBI BILSTEIN", $supplier);
        if ($supplier == "MANN")
            $supplier = str_replace("MANN", "MANN-FILTER", $supplier);
        if ($supplier == "MEAT&DORIA")
            $supplier = str_replace("MEAT&DORIA", "MEAT & DORIA", $supplier);
        if ($supplier == "BEHR-HELLA")
            $supplier = str_replace("BEHR-HELLA", "BEHR HELLA SERVICE", $supplier);
        if ($supplier == "BLUEPRINT")
            $supplier = str_replace("BLUEPRINT", "BLUE PRINT", $supplier);
        if ($supplier == "BLUE-PRINT")
            $supplier = str_replace("BLUE-PRINT", "BLUE PRINT", $supplier);
        if ($supplier == "BENDIX WBK")
            $supplier = str_replace("BENDIX WBK", "BENDIX", $supplier);
        if ($supplier == "CONTI-TECH")
            $supplier = str_replace("CONTI-TECH", "CONTITECH", $supplier);
        if ($supplier == "Fai AutoParts")
            $supplier = str_replace("Fai AutoParts", "FAI AutoParts", $supplier);
        if ($supplier == "FIAAM")
            $supplier = str_replace("FIAAM", "COOPERSFIAAM FILTERS", $supplier);
        if ($supplier == "FIBA")
            $supplier = str_replace("FIBA", "FI.BA", $supplier);
        if ($supplier == "FLENOR")
            $supplier = str_replace("FLENOR", "FLENNOR", $supplier);
        if ($supplier == "FRITECH")
            $supplier = str_replace("FRITECH", "fri.tech.", $supplier);
        if ($supplier == "HERTH & BUSS JAKOPARTS")
            $supplier = str_replace("HERTH & BUSS JAKOPARTS", "HERTH+BUSS JAKOPARTS", $supplier);
        if ($supplier == "KAYABA")
            $supplier = str_replace("KAYABA", "KYB", $supplier);
        if ($supplier == "KM")
            $supplier = str_replace("KM", "KM Germany", $supplier);
        if ($supplier == "LUK")
            $supplier = str_replace("LUK", "LuK", $supplier);
        if ($supplier == "FEBI BILSTEIN BILSTEIN")
            $supplier = str_replace("FEBI BILSTEIN BILSTEIN", "FEBI BILSTEIN", $supplier);
        if ($supplier == "COOPERSCOOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS FILTERS")
            $supplier = str_replace("COOPERSCOOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        if ($supplier == "COOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS")
            $supplier = str_replace("COOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        if ($supplier == "COOPERSCOOPERSFIAAM FILTERS FILTERS")
            $supplier = str_replace("COOPERSCOOPERSFIAAM FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        if ($supplier == "CoopersFiaam")
            $supplier = str_replace("CoopersFiaam", "COOPERSFIAAM FILTERS", $supplier);
        if ($supplier == "MANN")
            $supplier = str_replace("MANN", "MANN-FILTER", $supplier);
        if ($supplier == "MANN-FILTER-FILTER-FILTER-FILTER")
            $supplier = str_replace("MANN-FILTER-FILTER-FILTER-FILTER", "MANN-FILTER", $supplier);
        if ($supplier == "MANN-FILTER-FILTER")
            $supplier = str_replace("MANN-FILTER-FILTER", "MANN-FILTER", $supplier);
        if ($supplier == "MANN-FILTER-FILTER")
            $supplier = str_replace("MANN-FILTER-FILTER", "MANN-FILTER", $supplier);
        if ($supplier == "MANN-FILTEREX")
            $supplier = str_replace("MANN-FILTEREX", "MANN-FILTER", $supplier);
        if ($supplier == "METALCAUCHO")
            $supplier = str_replace("METALCAUCHO", "Metalcaucho", $supplier);
        if ($supplier == "MULLER")
            $supplier = str_replace("MULLER", "MULLER FILTER", $supplier);
        if ($supplier == "RICAMBI")
            $supplier = str_replace("RICAMBI", "GENERAL RICAMBI", $supplier);
        if ($supplier == "ZIMMERMANN-FILTER")
            $supplier = str_replace("VERNET", "CALORSTAT by Vernet", $supplier);
        if ($supplier == "ZIMMERMANN-FILTER")
            $supplier = str_replace("ZIMMERMANN-FILTER", "ZIMMERMANN", $supplier);
        if ($supplier == "LESJ?FORS")
            $supplier = str_replace("LESJ?FORS", "LESJOFORS", $supplier);
        if ($supplier == "LEMF?RDER")
            $supplier = str_replace("LEMF?RDER", "LEMFORDER", $supplier);
        if ($supplier == "SALERI")
            $supplier = str_replace("SALERI", "Saleri SIL", $supplier);
        if ($supplier == "CASTROL LUBRICANTS")
            $supplier = str_replace("CASTROL LUBRICANTS", "CASTROL", $supplier);
        if ($supplier == "FEBI BILSTEIN BILSTEIN")
            $supplier = str_replace("FEBI BILSTEIN BILSTEIN", "FEBI BILSTEIN", $supplier);
        if ($supplier == "KM Germany Germany")
            $supplier = str_replace("KM Germany Germany", "KM Germany", $supplier);
        return $supplier;
    }

    private function clearCode($code) {
        $code = str_replace(" ", "", $code);
        $code = str_replace(".", "", $code);
        $code = str_replace("-", "", $code);
        $code = str_replace("/", "", $code);
        $code = str_replace(")", "", $code);
        $code = str_replace("(", "", $code);
        $code = strtoupper($code);
        return $code;
    }

    function clearstring($search) {
        $search = str_replace(" ", "", trim($search));
        $search = str_replace(".", "", $search);
        $search = str_replace("-", "", $search);
        $search = str_replace("/", "", $search);
        $search = str_replace("*", "", $search);
        $search = strtoupper($search);
        return $search;
    }

    /**
     * Get tecdocArticleId
     *
     * @return integer
     */
    public function getTecdocArticleId() {
        return $this->tecdocArticleId;
    }
    
    /**
     * Get tecdocArticleId3
     *
     * @return integer
     */
    public function getTecdocArticleId3() {
        return $this->tecdocArticleId3;
    }
    
    public function getQty1() {
        /*
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $qty = 0;
        $query = $em->createQuery(
                        'SELECT p
                        FROM EdiBundle:EdiOrder p
                        WHERE 
                        p.reference = 0
                        AND p.Edi = :edi'
                )->setParameter('edi', $this->getEdi());
        $EdiOrder = $query->setMaxResults(1)->getOneOrNullResult();
        if (@ $EdiOrder->id > 0) {

            $query = $em->createQuery(
                    'SELECT p
                                FROM EdiBundle:EdiOrderItem p
                                WHERE 
                                p.EdiItem = ' . $this->getId() . '
                                AND p.EdiOrder = ' . $EdiOrder->getId() . ''
            );

            $EdiOrderItem = $query->setMaxResults(1)->getOneOrNullResult();
            if (@ $EdiOrderItem->id > 0) {
                $qty = $EdiOrderItem->getQty();
            }
        }
         * 
         */
        $qty = 1;
        return "<input type='text' data-id='" . $this->id . "' name='qty1_" . $this->id . "' value='" . $qty . "' size=2 id='qty1_" . $this->id . "' class='ediiteqty1'>";
    }
    var $finalprice = 0;
    public function getQty2() {
        $qty = 1;
        return "<input type='text' data-price='".$this->finalprice."' data-id='" . $this->id . "' name='qty2_" . $this->id . "' value='" . $qty . "' size=2 id='qty2_" . $this->id . "' class='ediiteqty2'>";
    }
    public function getQty3() {
        return '<a class="create_edi_product" data-id="' . $this->id . '" style="font-size:10px; color:rose" href="#">Create Product</a>';//"<input type='text' data-id='" . $this->id . "' name='qty3_" . $this->id . "' size=2  id='qty3_" . $this->id . "' class='ediiteqty3'>";
    }
    public function getQtyAvailability($cnt = 0) {
        if ($cnt > 10)
            return;
    }

    /**
     * @var integer
     */
    private $product;

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return EdiItem
     */
    public function setProduct($product) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return integer
     */
    public function getProduct() {
        return $this->product;
    }

    function getEltrekaQtyAvailability() {
        //return;
        $url = "http://b2bnew.lourakis.gr/antallaktika/init/geteltrekaavailability";
        $fields = array(
            'appkey' => 'bkyh69yokmcludwuu2',
            'partno' => $this->itemCode,
        );

        $fields_string = '';
        foreach ($fields as $key => $value) {
            @$fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $out = json_decode(curl_exec($ch));
        return $out;
    }

    function getEdiQtyAvailability($qty = 1) {
        //return;
        //return $jsonarr;
        $datas = array();
        if (strlen($this->getEdi()->getToken()) == 36) {
            //print_r($jsonarr);
            $data['ApiToken'] = $this->getEdi()->getToken();
            $data['Items'] = array();

            $Item["ItemCode"] = $this->getItemCode();
            $Item["ReqQty"] = $qty;

            $data['Items'][] = $Item;
            //$jsonarr2[(int)$key] = $json;
            //print_r($datas);
            //print_r($datas);
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            //$data_string = '{ "ApiToken": "b5ab708b-0716-4c91-a8f3-b6513990fe3c", "Items": [ { "ItemCode": "' . $this->erp_code . '", "ReqQty": 1 } ] } ';
            //return 10;
            $data_string = json_encode($data);
            //print_r($data);
            //turn;
            $result = file_get_contents($requerstUrl, null, stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' =>
                    'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data_string) . "\r\n",
                    'content' => $data_string,
                ),
            )));

            $re = json_decode($result);

            //print_r($re);
            //return;
            if (@count($re->Items))
                foreach ($re->Items as $Item) {
                    return number_format($Item->ListPrice, 2, '.', '');
                }
        } elseif ($this->getEdi()->getFunc() == 'getGbgEdiPartMaster') { // is viakar, liakopoulos
            $zip = new \ZipArchive;
            if ($zip->open('/home2/partsbox/OUTOFSTOCK_ATH.ZIP') === TRUE) {
                $zip->extractTo('/home2/partsbox/');
                $zip->close();
                $file = "/home2/partsbox/OUTOFSTOCK_ATH.txt";
                $availability = false;
                if (($handle = fopen($file, "r")) !== FALSE) {
                    //echo 'sss';
                    while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                        if ($data[0] == $this->getItemcode()) {
                            if ($data[1] == 1)
                                $availability = true;
                            break;
                        }
                    }
                }
            }
            return $availability;
        } else {
            $elteka = $this->eltekaAuth();
            $response = $elteka->getPartPrice(array('CustomerNo' => $this->CustomerNo, "EltrekkaRef" => $this->getItemcode()));
            $xml = $response->GetPartPriceResult->any;
            $xml = simplexml_load_string($xml);
            //print_r($xml);

            return $xml->Item->WholePrice;
        }
        //print_r($jsonarr);
    }

    var $soapPrice;
    var $soapStock;
    var $soapAvail1;
    var $soapAvail2;

    public function setComlineSoap($qty = 1) {
        $LogUniqueKey = "";
        $LogUniqueKey = $this->getSetting("EdiBundle:Comline:LogUniqueKey"); //""; //Mage::getModel("core/cookie")->get('LogUniqueKey');
        //$client = new SoapClient("http://www.keysoft.gr/WseService.asmx?wsdl");
        //$lstLst = $client->lstPrice("sko@keysoft.gr;sko1;81-194;1");
        if ($LogUniqueKey == "") {
            //    Mage::getSingleton('customer/session')->logout();
            //$login['username'] = "01111-101";
            //$login['password'] = "88qq";
            $client = new \SoapClient("http://www.comlinehellas.gr/WseService.asmx?wsdl");
            $params = array(
                "ssParameters" => $this->getEdi()->getToken()//$login['username'] . ";" . $login['password']
            );
            $response = $client->__soapCall("lstLogin", array($params));
            $LogUniqueKey = $response->lstLoginResult->lstLogin->LogUniqueKey;
            $this->setSetting("EdiBundle:Comline:LogUniqueKey", $LogUniqueKey);
        }
        $client = new \SoapClient("http://www.comlinehellas.gr/WseService.asmx?wsdl");
        $params = array(
            "ssParameters" => $LogUniqueKey . ";;" . $this->getItemCode() . ";" . $qty
        );

        if ($qty > 100) {
            //print_r($params);
        }
        $response = $client->__soapCall("lstPrice", array($params));
        if ($qty > 100) {
            //print_r($response);
        }
        //print_r($response);
        $ProOrdCus = $response->lstPriceResult->lstPrice->ProOrdCus > 0 ? $response->lstPriceResult->lstPrice->ProOrdCus : 0;
        $stock = $response->lstPriceResult->lstPrice->ProStock - $ProOrdCus;
        $this->wholesaleprice = $response->lstPriceResult->lstPrice->PplPrice;
        $this->soapPrice = str_replace(",", ".", $response->lstPriceResult->lstPrice->PplPrice);
        $this->soapStock = $stock > 0 ? $stock : 0;
        $this->soapAvail1 = $response->lstPriceResult->lstPrice->ProAvail1;
        $this->soapAvail2 = $response->lstPriceResult->lstPrice->ProAvail2;

        return $response->lstPriceResult->lstPrice;
    }

    public function setFibaSoap($qty = 1) {
        $out = file_get_contents("http://b2b.fiba.gr/antallaktika/edi/getProductPrice/code/" . $this->itemCode . "/customer/" . $this->getEdi()->getToken());
        $arr = explode(";", $out);
        $this->soapPrice = (float) $arr[0];
        $this->soapStock = $arr[1];
    }

    protected $SoapClient = false;
    protected $Username = '';
    protected $Password = '';
    protected $CustomerNo = '';
    protected $SoapUrl = '';
    protected $SoapNs = '';

    protected function eltekaAuth() {

        $this->SoapUrl = $this->getSetting("EdiBundle:Eltreka:SoapUrl");
        $this->SoapNs = $this->getSetting("EdiBundle:Eltreka:SoapNs");
        $this->Username = $this->getSetting("EdiBundle:Eltreka:Username");
        $this->Password = $this->getSetting("EdiBundle:Eltreka:Password");
        $this->CustomerNo = $this->getSetting("EdiBundle:Eltreka:CustomerNo");

        if ($this->SoapClient) {
            return $this->SoapClient;
        }

        $this->SoapClient = new \SoapClient($this->SoapUrl);
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($this->SoapNs, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        //$session->set('SoapClient', $this->SoapClient);
        return $this->SoapClient;
    }

    function getEdiMarkupPrice($pricefield = false) {

        $rules = $this->getEdi()->loadEdirules($pricefield)->getRules();
        $sortorder = 0;
        $markup = $this->markup;
        foreach ($rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                $sortorder = $rule->getSortorder();
                $markup = $rule->getVal();
                $price = $rule->getPrice();
                //echo $markup;
            }
        }
        //$markup = $markup == 0 ? 0 : $markup; 
        //echo $markup."\n";
        $markupedPrice = (double) $this->getWholesaleprice() * (1 + $markup / 100 );
        return $price > 0 ? $price : round($markupedPrice, 2);
    }

    function getRulesss($pricefield = false) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        //$ediitem->tecdoc = new Tecdoc();

        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $rules = $this->getEdi()->loadEdirules($pricefield)->getRules();
        //return (array)$rules;
        $rules2 = array();
        foreach ($rules as $rule) {
            //$rule->validateRule($this);
            //if ($rule->validateRule($this)) {
            $SoftoneSupplier = $em->getRepository("SoftoneBundle:SoftoneSupplier")->findOneBy(array('title' => $this->getBrand()));
            if ($SoftoneSupplier) {
                $supplier = $SoftoneSupplier->getId();
            }
            $rules2[] = $supplier;
            $rules2[] = $rule->validateRule($this);
            //}
        }
        return (array) $rules2;
    }

    function getEdiMarkup($pricefield = false) {

        $rules = $this->getEdi()->loadEdirules($pricefield)->getRules();
        $sortorder = 0;
        $markup = $this->markup;
        //echo "-".$pricefield."-";
        foreach ($rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                $sortorder = $rule->getSortorder();
                $markup = $rule->getVal();
                $price = $rule->getPrice();
                //echo $markup;
            }
        }
        return $markup;
        //$markup = $markup == 0 ? 0 : $markup; 
        //echo $markup."\n";
        $markupedPrice = $this->getWholesaleprice() * (1 + $markup / 100 );
        return $price > 0 ? $price : $markupedPrice;
    }

    /**
     * @var string
     */
    private $wholesaleprice;

    /**
     * Set wholesaleprice
     *
     * @param string $wholesaleprice
     *
     * @return EdiItem
     */
    public function setWholesaleprice($wholesaleprice) {
        $this->wholesaleprice = $wholesaleprice;

        return $this;
    }

    /**
     * Get wholesaleprice
     *
     * @return string
     */
    public function getWholesaleprice() {
        if ($this->wholesaleprice == 0) {
            //return $this->getEdiUnitPrice();
        }
        return $this->wholesaleprice;
    }

    public function getEdiListPrice() {
        if ($this->getEdi()->getFunc() == 'getEdiPartMaster') { // is viakar, liakopoulos
            if (@!$datas[$this->getEdi()->getId()][$k]) {
                $datas[$this->getEdi()->getId()][$k]['ApiToken'] = $this->getEdi()->getToken();
                $datas[$this->getEdi()->getId()][$k]['Items'] = array();
            }
            $Items[$this->getEdi()->getId()][$k]["ItemCode"] = $this->getItemcode();
            $Items[$this->getEdi()->getId()][$k]["ReqQty"] = 1;
            $datas[$this->getEdi()->getId()][$k]['Items'][] = $Items[$this->getEdi()->getId()][$k];
        }
        if (count($datas)) {
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            foreach ($datas as $catalogue => $packs) {
                foreach ($packs as $k => $data) {
                    $data_string = json_encode($data);

                    //continue;
                    $result = file_get_contents($requerstUrl, null, stream_context_create(array(
                        'http' => array(
                            'method' => 'POST',
                            'header' =>
                            'Content-Type: application/json' . "\r\n"
                            . 'Content-Length: ' . strlen($data_string) . "\r\n",
                            'content' => $data_string,
                        ),
                    )));
                    $re = json_decode($result);

                    //print_r($re);
                    if (@count($re->Items)) {
                        foreach ($re->Items as $Item) {
                            $qty = $Item->Availability == 'red' ? 0 : 1000;
                            return $Item->ListPrice;
                        }
                    }
                }
            }
        }
    }

    public function getEdiUnitPrice() {
        if ($this->getEdi()->getFunc() == 'getEdiPartMaster') { // is viakar, liakopoulos
            if (@!$datas[$this->getEdi()->getId()][$k]) {
                $datas[$this->getEdi()->getId()][$k]['ApiToken'] = $this->getEdi()->getToken();
                $datas[$this->getEdi()->getId()][$k]['Items'] = array();
            }
            $Items[$this->getEdi()->getId()][$k]["ItemCode"] = $this->getItemcode();
            $Items[$this->getEdi()->getId()][$k]["ReqQty"] = 1;
            $datas[$this->getEdi()->getId()][$k]['Items'][] = $Items[$this->getEdi()->getId()][$k];
        }
        if (count($datas)) {
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            foreach ($datas as $catalogue => $packs) {
                foreach ($packs as $k => $data) {
                    $data_string = json_encode($data);

                    //continue;
                    $result = file_get_contents($requerstUrl, null, stream_context_create(array(
                        'http' => array(
                            'method' => 'POST',
                            'header' =>
                            'Content-Type: application/json' . "\r\n"
                            . 'Content-Length: ' . strlen($data_string) . "\r\n",
                            'content' => $data_string,
                        ),
                    )));
                    $re = json_decode($result);

                    //print_r($re);
                    if (@count($re->Items)) {
                        foreach ($re->Items as $Item) {
                            $qty = $Item->Availability == 'red' ? 0 : 1000;
                            return $Item->UnitPrice;
                        }
                    }
                }
            }
        }
    }

    //function getGroupedDiscountPrice(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
    function getGroupedDiscountPrice($customer, $vat = 1) {
        $rules = $customer->getCustomergroup()->loadCustomergrouprules()->getRules();
        $sortorder = 0;

        foreach ($rules as $rule) {
            if ($rule->validateRule($this, $this) AND $sortorder <= $rule->getSortorder()) {
                $sortorder = $rule->getSortorder();
                $discount = $rule->getVal();
                $price = $rule->getPrice();
            }
        }
        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        $this->getEdiMarkupPrice($pricefield);
        $price = $price > 0 ? $price : $this->getEdiMarkupPrice($pricefield);
        $discountedPrice = $this->getEdiMarkupPrice($pricefield) * (1 - $discount / 100 );
        $finalprice = $discount > 0 ? $discountedPrice : $price;

        return number_format($finalprice * $vat, 2, '.', '');
    }

    //function getDiscount(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
    function getDiscount($customer, $vat = 1) {
        $rules = $customer->loadCustomerrules()->getRules();
        $sortorder = 0;
        $discount = 0;
        $price = 0;
        $ruled = false;
        foreach ((array) $rules as $rule) {
            if ($rule->validateRule($this, $this) AND $sortorder <= $rule->getSortorder()) {
                $sortorder = $rule->getSortorder();
                $discount = $rule->getVal();
                $price = $rule->getPrice();
                $ruled = true;
            }
        }
        if (!$ruled) {
            $rules = $customer->getCustomergroup()->loadCustomergrouprules()->getRules();
            $sortorder = 0;
            foreach ($rules as $rule) {
                if ($rule->validateRule($this, $this) AND $sortorder <= $rule->getSortorder()) {
                    $sortorder = $rule->getSortorder();
                    $discount = $rule->getVal();
                    $price = $rule->getPrice();
                }
            }
        }



        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        $markip = $this->getEdiMarkupPrice($pricefield);
        $price = $price > 0 ? $price : $this->getEdiMarkupPrice($pricefield);
        $discountedPrice = $this->getEdiMarkupPrice($pricefield) * (1 - $discount / 100 );
        $finalprice = $discount > 0 ? $discountedPrice : $price;
        $this->finalprice = $finalprice * $vat;
        return $this->getEdiMarkupPrice($pricefield) . " / " . number_format($finalprice, 2, '.', '') . " / " . number_format($finalprice * $vat, 2, '.', '') . " (" . (float) $discount . "%)";
    }

    function ggetEdiQtyAvailability() {
        if ($this->getEdi()->getFunc() == 'getGbgEdiPartMaster') { // is viakar, liakopoulos
            $zip = new \ZipArchive;
            if ($zip->open('/home2/partsbox/OUTOFSTOCK_ATH.ZIP') === TRUE) {
                $zip->extractTo('/home2/partsbox/');
                $zip->close();
                $file = "/home2/partsbox/OUTOFSTOCK_ATH.txt";
                $availability = false;
                if (($handle = fopen($file, "r")) !== FALSE) {
                    //echo 'sss';
                    while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                        if ($data[0] == $entity->getItemcode()) {
                            if ($data[1] == 1)
                                $availability = true;
                            break;
                        }
                    }
                }
            }
            return $availability;
        } elseif ($entity->getEdi()->getFunc() == 'getEdiPartMaster') { // is viakar, liakopoulos
            if (@!$datas[$entity->getEdi()->getId()][$k]) {
                $datas[$entity->getEdi()->getId()][$k]['ApiToken'] = $entity->getEdi()->getToken();
                $datas[$entity->getEdi()->getId()][$k]['Items'] = array();
            }
            $Items[$entity->getEdi()->getId()][$k]["ItemCode"] = $entity->getItemcode();
            $Items[$entity->getEdi()->getId()][$k]["ReqQty"] = 1;
            $datas[$entity->getEdi()->getId()][$k]['Items'][] = $Items[$entity->getEdi()->getId()][$k];

            $ands[$entity->getItemcode()] = $key;
            $entities[$entity->getItemcode()] = $entity;
        } elseif ($entity->getEdi()->getFunc() == 'getFibaEdiPartMaster') {
            $AvailabilityDetailsHtml = '';
            $entity->setFibaSoap();
            if ($entity->soapStock >= 1) {
                $availability = "Y";
            }
            @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
            @$jsonarr[$key]['7'] = number_format((float) $entity->soapPrice, 2, '.', '');
            @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
            @$jsonarr[$key]['DT_RowClass'] .= $availability == "Y" ? ' text-success ' : ' text-danger ';
        } elseif ($entity->getEdi()->getFunc() == 'getComlineEdiPartMaster') {
            $entity->setComlineSoap();
            $AvailabilityDetailsHtml = '';
            $availability = '';
            $apoth = "";
            $AvailabilityDetailsHtml = $entity->soapStock . "," . $entity->soapAvail1 . "," . $entity->soapAvail2;
            if ($entity->soapStock >= 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                $availability = "Y";
            }

            if ($entity->soapStock < 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                $AvailabilityDetailsHtml = "Μη Διαθέσιμο&nbsp;";
                //psColor = "Orange";
                //$qty = "<img title='Μη Διαθέσιμο' alt='Μη Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Μη Διαθέσιμο".$apoth;
            } else if ($entity->soapStock >= 1 && $entity->soapAvail1 == 0 && $entity->soapAvail2 == 0) {
                $AvailabilityDetailsHtml = "&nbsp;Διαθέσιμο&nbsp;";
                $availability = "Y";
                //psColor = "Green";
                //$qty = "<img title='Διαθέσιμο' alt='Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/diathesimo.png'><br>Διαθέσιμο ".$apoth;
            } else if ($entity->soapStock <= 0 && $entity->soapAvail1 > 0) {
                $AvailabilityDetailsHtml = "&nbsp;Μη Διαθέσιμο&nbsp;";
                //psColor = "Red";
                //$qty = "<img title='Μη Διαθέσιμο' alt='Διαθέσιμο' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/midiathesimo.png'><BR>Μη Διαθέσιμο".$apoth;
            } else if ($entity->soapStock > 0 && $entity->soapStock <= $entity->soapAvail1 && $entity->soapAvail1 > 0) {
                $AvailabilityDetailsHtml = "&nbsp;Χαμηλή&nbsp;";
                $availability = "Y";
                //psColor = "Orange";
                //$qty = "<img title='Χαμηλή' alt='Χαμηλή' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Χαμηλή".$apoth;
            } else if ($entity->soapStock > $entity->soapAvail1 && $entity->soapStock <= $entity->soapAvail2 && $entity->soapAvail1 > 0) {
                $AvailabilityDetailsHtml = "&nbsp;Μεσαία&nbsp;";
                $availability = "Y";
                //psColor = "DodgerBlue";
                //$qty = "<img title='Μεσαία' alt='Μεσαία' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/oriakadiathesimo.png'><BR>Μεσαία".$apoth;
            } else if ($entity->soapStock > $entity->soapAvail2 && $entity->soapAvail2 > 0) {
                $AvailabilityDetailsHtml = "&nbsp;Πλήρης&nbsp;";
                $availability = "Y";
                //psColor = "Green";
                //$qty = "<img title='Πλήρης' alt='Πλήρης' src='".Mage::getBaseUrl('skin')."frontend/default/b2b/images/diathesimo.png'><BR>Πλήρης".$apoth;
            }




            @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
            @$jsonarr[$key]['7'] = number_format((float) $entity->soapPrice, 2, '.', '');
            @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
            @$jsonarr[$key]['DT_RowClass'] .= $availability == "Y" ? ' text-success ' : ' text-danger ';
        } elseif ($entity->getEdi()->getFunc() == 'getRaskosEdiPartMaster') {

            $json = file_get_contents("http://actedi.actae.gr/PartInfo/api/ActPriceAndAvail/c9ff4c75-2ef9-4dbd-9708-f8175d441f96/" . $entity->getItemCode());

            $ed = json_decode($json);

            $AvailabilityDetailsHtml = ""; //$json;//print_r($ed,true);
            if ($ed[0]->price > 0) {
                $entity->getWholesaleprice($ed[0]->price);
            }
            @$jsonarr[$key]['6'] = ""; //$entity->getDiscount($customer, $vat);
            @$jsonarr[$key]['7'] = number_format((float) $entity->getWholesaleprice(), 2, '.', '');
            @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
            @$jsonarr[$key]['DT_RowClass'] .= $ed[0]->avail == "green" ? ' text-success ' : ' text-danger ';
        } else {
            /*
              @$jsonarr[$key]['DT_RowClass'] .= $eltrekaavailability[$entity->getItemcode()] > 0 ? ' text-success ' : ' text-danger ';

              $response = $elteka->getPartPrice(array('CustomerNo' => $this->CustomerNo, "EltrekkaRef" => $entity->getItemcode()));
              $xml = $response->GetPartPriceResult->any;
              $xml = simplexml_load_string($xml);
              $price = (float) $xml->Item->PriceOnPolicy;
              //echo "---".$xml->Item->WholePrice."\n";
              @$jsonarr[$key]['6'] = number_format($price, 2, '.', '');
              @$jsonarr[$key]['DT_RowClass'] .= $xml->Item->Header->Available == "Y" ? ' text-success ' : ' text-danger ';
             */
            if (count($jsonarr) < 50) {
                $response = $elteka->getAvailability(
                        array('CustomerNo' => $this->CustomerNo,
                            "RequestedQty" => 1,
                            "EltrekkaRef" => $entity->getItemcode()));
                $xml = $response->GetAvailabilityResult->any;
                $xml = simplexml_load_string($xml);
                $AvailabilityDetailsHtml = "<select data-id='" . $entity->getId() . "' class='edistore' id='store_" . $entity->getId() . "' style=''>";
                $asd = (array) $xml->Item;
                foreach ((array) $asd["AvailabilityDetails"] as $details) {
                    if ($details->IsAvailable == 'Y') {
                        $selected = (int) $xml->Item->Header->SUGGESTED_STORE == (int) $details->StoreNo ? "selected" : "";
                        $AvailabilityDetailsHtml .= "<option " . $selected . " value='" . $details->StoreNo . "' style='color:green'>" . $details->StoreNo . "</option>";
                    } else {
                        $AvailabilityDetailsHtml .= "<option value='" . $details->StoreNo . "' style='color:red'>" . $details->StoreNo . " (" . $details->EstimatedBODeliveryTime . ")</option>";
                    }
                }
                $AvailabilityDetailsHtml .= "</select>";

                //print_r($xml->Item->Header);
                $entity->setWholesaleprice($xml->Item->Header->WholePrice);
                @$jsonarr[$key]['6'] = $entity->getDiscount($customer, $vat);
                @$jsonarr[$key]['7'] = number_format((float) $xml->Item->Header->WholePrice, 2, '.', '');
                @$jsonarr[$key]['8'] = $jsonarr[$key]['8'] . $AvailabilityDetailsHtml;
                @$jsonarr[$key]['DT_RowClass'] .= $xml->Item->Header->Available == "Y" ? ' text-success ' : ' text-danger ';
            }
        }
    }

}
