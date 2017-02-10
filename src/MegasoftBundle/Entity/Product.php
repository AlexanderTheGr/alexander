<?php

namespace MegasoftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use AppBundle\Entity\Tecdoc as Tecdoc;
use MegasoftBundle\Entity\Megasoft as Megasoft;
use MegasoftBundle\Entity\TecdocSupplier as TecdocSupplier;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="MegasoftBundle\Entity\ProductRepository")
 */
class Product extends Entity {

    var $repositories = array();
    var $uniques = array();

    public function __construct() {
        $this->setRepositories();
    }

    public function getField($field) {

        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    public function setRepositories() {
        $this->repositories['tecdocSupplierId'] = 'MegasoftBundle:TecdocSupplier';

        $this->repositories['productSale'] = 'MegasoftBundle:ProductSale';

        $this->types['tecdocSupplierId'] = 'object';
        $this->types['supplierId'] = 'object';
        $this->types['productSale'] = 'object';

        $this->uniques = array("erpCode", "itemCode");

        //$this->tecdocSupplierId = new \MegasoftBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        $this->repositories['tecdocSupplierId'] = 'MegasoftBundle:TecdocSupplier';
        // $this->repositories['supplierId'] = 'MegasoftBundle:MegasoftSupplier';
        $this->repositories['productSale'] = 'MegasoftBundle:ProductSale';
        //$this->repositories['mtrsup'] = 'MegasoftBundle:Supplier';

        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['tecdocSupplierId'] = 'object';
        //  $this->types['supplierId'] = 'object';
        $this->types['productSale'] = 'object';
        //  $this->types['mtrsup'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    /**
     * @var integer
     */
    private $reference;

    /**
     * @var string
     */
    private $edi;

    /**
     * @var integer
     */
    private $ediId;

    /**
     * @var string
     */
    private $edis;

    /**
     * @var string
     */
    private $erpCode;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $cats;

    /**
     * @var string
     */
    private $cars;

    /**
     * @var string
     */
    private $tecdocCode;

    /**
     * @var string
     */
    private $sisxetisi = '';

    /**
     * @var integer
     */
    private $tecdocArticleId;

    /**
     * @var string
     */
    private $supplierCode;

    /**
     * @var string
     */
    private $erpSupplier;

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
    private $qty = '0';

    /**
     * @var integer
     */
    private $reserved = '0';

    /**
     * @var string
     */
    private $storeRetailPrice;

    /**
     * @var string
     */
    private $storeWholeSalePrice;

    /**
     * @var string
     */
    private $media;

    /**
     * @var \DateTime
     */
    private $ts;

    /**
     * @var integer
     */
    private $actioneer;

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
     * Set reference
     *
     * @param integer $reference
     *
     * @return Product
     */
    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * Set edi
     *
     * @param string $edi
     *
     * @return Product
     */
    public function setEdi($edi) {
        $this->edi = $edi;

        return $this;
    }

    /**
     * Get edi
     *
     * @return string
     */
    public function getEdi() {
        return $this->edi;
    }

    /**
     * Set ediId
     *
     * @param integer $ediId
     *
     * @return Product
     */
    public function setEdiId($ediId) {
        $this->ediId = $ediId;

        return $this;
    }

    /**
     * Get ediId
     *
     * @return integer
     */
    public function getEdiId() {
        return $this->ediId;
    }

    /**
     * Set edis
     *
     * @param string $edis
     *
     * @return Product
     */
    public function setEdis($edis) {
        $this->edis = $edis;

        return $this;
    }

    /**
     * Get edis
     *
     * @return string
     */
    public function getEdis() {
        return $this->edis;
    }

    /**
     * Set erpCode
     *
     * @param string $erpCode
     *
     * @return Product
     */
    public function setErpCode($erpCode) {
        $this->erpCode = $erpCode;

        return $this;
    }

    /**
     * Get erpCode
     *
     * @return string
     */
    public function getErpCode() {
        return $this->erpCode;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set cats
     *
     * @param string $cats
     *
     * @return Product
     */
    public function setCats($cats) {
        $this->cats = $cats;

        return $this;
    }

    /**
     * Get cats
     *
     * @return string
     */
    public function getCats() {
        return $this->cats;
    }

    /**
     * Set cars
     *
     * @param string $cars
     *
     * @return Product
     */
    public function setCars($cars) {
        $this->cars = $cars;

        return $this;
    }

    /**
     * Get cars
     *
     * @return string
     */
    public function getCars() {
        return $this->cars;
    }

    /**
     * Set tecdocCode
     *
     * @param string $tecdocCode
     *
     * @return Product
     */
    public function setTecdocCode($tecdocCode) {
        $this->tecdocCode = $tecdocCode;

        return $this;
    }

    /**
     * Get tecdocCode
     *
     * @return string
     */
    public function getTecdocCode() {
        return $this->tecdocCode;
    }

    /**
     * Set sisxetisi
     *
     * @param string $sisxetisi
     *
     * @return Product
     */
    public function setSisxetisi($sisxetisi) {
        $this->sisxetisi = $sisxetisi;

        return $this;
    }

    /**
     * Get sisxetisi
     *
     * @return string
     */
    public function getSisxetisi() {
        return $this->sisxetisi;
    }

    /**
     * Set tecdocArticleId
     *
     * @param integer $tecdocArticleId
     *
     * @return Product
     */
    public function setTecdocArticleId($tecdocArticleId) {
        $this->tecdocArticleId = $tecdocArticleId;

        return $this;
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
     * Set supplierCode
     *
     * @param string $supplierCode
     *
     * @return Product
     */
    public function setSupplierCode($supplierCode) {
        $this->supplierCode = $supplierCode;

        return $this;
    }

    /**
     * Get supplierCode
     *
     * @return string
     */
    public function getSupplierCode() {
        return $this->supplierCode;
    }

    /**
     * Set erpSupplier
     *
     * @param string $erpSupplier
     *
     * @return Product
     */
    public function setErpSupplier($erpSupplier) {
        $this->erpSupplier = $erpSupplier;

        return $this;
    }

    /**
     * Get erpSupplier
     *
     * @return string
     */
    public function getErpSupplier() {
        return $this->erpSupplier;
    }

    /**
     * Set tecdocArticleName
     *
     * @param string $tecdocArticleName
     *
     * @return Product
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
     * @return Product
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
     * Set qty
     *
     * @param integer $qty
     *
     * @return Product
     */
    public function setQty($qty) {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty() {
        return $this->qty;
    }

    /**
     * Set reserved
     *
     * @param integer $reserved
     *
     * @return Product
     */
    public function setReserved($reserved) {
        $this->reserved = $reserved;

        return $this;
    }

    /**
     * Get reserved
     *
     * @return integer
     */
    public function getReserved() {
        return $this->reserved;
    }

    /**
     * Set storeRetailPrice
     *
     * @param string $storeRetailPrice
     *
     * @return Product
     */
    public function setStoreRetailPrice($storeRetailPrice) {
        $this->storeRetailPrice = $storeRetailPrice;

        return $this;
    }

    /**
     * Get storeRetailPrice
     *
     * @return string
     */
    public function getStoreRetailPrice() {
        return $this->storeRetailPrice;
    }

    /**
     * Set storeWholeSalePrice
     *
     * @param string $storeWholeSalePrice
     *
     * @return Product
     */
    public function setStoreWholeSalePrice($storeWholeSalePrice) {
        $this->storeWholeSalePrice = $storeWholeSalePrice;

        return $this;
    }

    /**
     * Get storeWholeSalePrice
     *
     * @return string
     */
    public function getStoreWholeSalePrice() {
        return $this->storeWholeSalePrice;
    }

    /**
     * Set media
     *
     * @param string $media
     *
     * @return Product
     */
    public function setMedia($media) {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string
     */
    public function getMedia() {
        return $this->media;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Product
     */
    public function setTs($ts) {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs() {
        return $this->ts;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Product
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Product
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
     * @return Product
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
     * @var \MegasoftBundle\Entity\TecdocSupplier
     */
    private $tecdocSupplierId;

    /**
     * Set tecdocSupplierId
     *
     * @param \MegasoftBundle\Entity\TecdocSupplier $tecdocSupplierId
     *
     * @return Product
     */
    public function setTecdocSupplierId(\MegasoftBundle\Entity\TecdocSupplier $tecdocSupplierId = null) {
        $this->tecdocSupplierId = $tecdocSupplierId;

        return $this;
    }

    /**
     * Get tecdocSupplierId
     *
     * @return \MegasoftBundle\Entity\TecdocSupplier
     */
    public function getTecdocSupplierId() {
        return $this->tecdocSupplierId;
    }

    /**
     * @var \MegasoftBundle\Entity\Supplier
     */
    private $mtrsup;

    /**
     * @var \MegasoftBundle\Entity\ProductSale
     */
    private $productSale;

    /**
     * Set productSale
     *
     * @param \MegasoftBundle\Entity\ProductSale $productSale
     *
     * @return Product
     */
    public function setProductSale(\MegasoftBundle\Entity\ProductSale $productSale = null) {
        $this->productSale = $productSale;

        return $this;
    }

    /**
     * Get productSale
     *
     * @return \MegasoftBundle\Entity\ProductSale
     */
    public function getProductSale() {
        return $this->productSale;
    }

    function updatetecdoc($tecdoc = false, $forceupdate = false) {

        //$data = array("service" => "login", 'username' => 'dev', 'password' => 'dev', 'appId' => '2000');
        if (!$this->getTecdocSupplierId())
            return;
        if ($this->getTecdocSupplierId() == null AND $forceupdate == false)
            return;

        $this->setTecdocArticleId($out->articleId);
        $this->setTecdocArticleName($out->articleName);

        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        //$data_string = json_encode($data);
        $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
        if ($_SERVER["DOCUMENT_ROOT"] == 'C:\symfony\alexander\webb') {
            $fields = array(
                'action' => 'updateTecdoc',
                'tecdoc_code' => $this->tecdocCode,
                'tecdoc_supplier_id' => $this->getTecdocSupplierId()->getId(),
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

            // print_r($fields);
            //echo $out;
            //echo 'sssssssssss';
        } else {

            $postparams = array(
                "articleNumber" => $this->tecdocCode,
                "brandno" => $this->getTecdocSupplierId()->getId()
            );
            //if (!$tecdoc)
            $tecdoc = new Tecdoc();

            $articleDirectSearchAllNumbers = $tecdoc->getArticleDirectSearchAllNumbers($postparams);
            $tectdoccode = $this->tecdocCode;
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
        }



        try {
            //$webserviceProduct = WebserviceProduct::model()->findByAttributes(array('product' =>  $this->id,"webservice"=>$this->webservice));
            //$sql = "Delete from SoftoneBundle:WebserviceProduct p where p.product = '" . $this->id . "'";
            //$em->createQuery($sql)->getResult();
            //$em->execute();
            if (@$out->articleId) {
                $this->setTecdocArticleId($out->articleId);
                $this->setTecdocArticleName($out->articleName);
                //$this->setTecdocGenericArticleId($out->articleName);

                $cats = $tecdoc->getTreeForArticle($out->articleId);

                //print_r((array) $cats);
                //echo "<BR>";

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
                $this->setCats($categories);
                $this->setCars($cars);
                /*
                  $em->persist($this);
                  $em->flush();
                 * 
                 */
                $sql = "update `megasoft_product` set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . $out->articleName . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
                $em->getConnection()->exec($sql);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        $tecdoc = null;
        unset($tecdoc);
        //echo $result;
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
    function setProductFreesearch() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        //if ($this->getSupplierId())
        //    $this->erpSupplier = $this->getSupplierId()->getTitle();

        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $dataindexarr = array();

        $dataindexarr[] = $this->itemCode;
        $dataindexarr[] = $this->itemApvcode;
        $dataindexarr[] = $this->itemCode1;
        $dataindexarr[] = $this->itemCode2;

        $dataindexarr[] = $this->title;
        $dataindexarr[] = $this->itemName;
        $dataindexarr[] = $this->itemName1;

        $dataindexarr[] = strtolower($this->greeklish($this->title));
        $dataindexarr[] = strtolower($this->greeklish($this->itemName));
        $dataindexarr[] = strtolower($this->greeklish($this->itemName1));
        $dataindexarr[] = strtolower($this->greeklish($this->erpSupplier));

        //$article_id = $this->_webserviceProducts_[11632]->article_id;
        /*
          if (@$article_id > 0) {
          $efarmoges = unserialize($this->efarmoges($article_id));
          //print_r($efarmoges);
          $dataindexarr[] = $this->_webserviceProducts_[11632]->article_name;
          $dataindexarr[] = strtolower($this->greeklish($this->_webserviceProducts_[11632]->article_name));

          foreach ($efarmoges as $efarmogi) {
          //$sql = "replace autoparts_tecdoc_product_linking_model_type set link_id = '" . $v->articleLinkId . "', product='" . $model->getId() . "', model_type = '" . $v->linkingTargetId . "'";
          //$write->query($sql);
          $brandmodeltype = BrandModelType::model()->findByPk($efarmogi);
          $brandmodel = $brandmodeltype->_brandModel_;
          $brand = $brandmodel->_brand_;

          $yearfrom = (int) substr($brandmodel->year_from, 0, 4);
          $yearto = (int) substr($brandmodel->year_to, 0, 4);
          //echo $yearfrom." - ".$yearto."<BR>";
          $engines = explode("|", $brandmodeltype->engine);
          foreach ($engines as $engine) {
          $dataindexarr[] = $engine;
          }
          if ($yearto) {
          for ($year = $yearfrom; $year <= $yearto; $year++) {
          $dataindexarr[] = $year;
          //echo $year;
          }
          } else {
          $dataindexarr[] = $yearfrom;
          }
          $dataindexarr[] = $brand->brand;
          $dataindexarr[] = $brandmodel->brand_model;
          $dataindexarr[] = $brandmodeltype->brand_model_type;
          }
          }
         */
        $data_index = array_filter(array_unique($dataindexarr));
        $dataindex = addslashes(implode("|", $data_index));
        $sql = "replace megasoft_product_freesearch set id = '" . $this->id . "', data_index='" . $dataindex . "'";
        $em->getConnection()->exec($sql);
        $sql = "replace megasoft_product_search set id = '" . $this->id . "',erp_code='" . $this->erpCode . "',tecdoc_code='" . $this->tecdocCode . "',supplier_code='" . $this->supplierCode . "'";
        $em->getConnection()->exec($sql);
    }  
    
    function toMegasoft() {
        
    }
}
