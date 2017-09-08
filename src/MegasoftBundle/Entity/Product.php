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
        $this->repositories['manufacturer'] = 'MegasoftBundle:Manufacturer';
        $this->repositories['productSale'] = 'MegasoftBundle:ProductSale';
        $this->repositories['supplier'] = 'MegasoftBundle:Supplier';

        $this->types['tecdocSupplierId'] = 'object';
        $this->types['supplier'] = 'object';
        $this->types['productSale'] = 'object';
        $this->types['manufacturer'] = 'object';
        //$this->uniques = array("erpCode");
        //$this->tecdocSupplierId = new \MegasoftBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        $this->repositories['tecdocSupplierId'] = 'MegasoftBundle:TecdocSupplier';
        $this->repositories['manufacturer'] = 'MegasoftBundle:Manufacturer';
        $this->repositories['productSale'] = 'MegasoftBundle:ProductSale';
        $this->repositories['supplier'] = 'MegasoftBundle:Supplier';

        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['tecdocSupplierId'] = 'object';
        $this->types['supplier'] = 'object';
        $this->types['manufacturer'] = 'object';
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
    var $reference;

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
    private $erpCode2;

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
    var $cars;

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
     * Set erpCode2
     *
     * @param string $erpCode2
     *
     * @return Product
     */
    public function setErpCode2($erpCode2) {
        $this->erpCode2 = $erpCode2;

        return $this;
    }

    /**
     * Get erpCode2
     *
     * @return string
     */
    public function getErpCode2() {
        return $this->erpCode2;
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
        $this->cats = serialize($cats);
        //$this->cats = $cats;

        return $this;
    }

    /**
     * Get cats
     *
     * @return string
     */
    public function getCats() {
        return (array) unserialize($this->cats);
    }

    /**
     * Set cars
     *
     * @param string $cars
     *
     * @return Product
     */
    public function setCars($cars) {
        //$this->cars = $cars;
        $this->cars = serialize($cars);
        return $this;
    }

    /**
     * Get cars
     *
     * @return string
     */
    public function getCars() {
        return (array) unserialize($this->cars);
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
        
        if ($this->getTecdocArticleId() > 0) return;
        //$this->setTecdocArticleId($out->articleId);
        //$this->setTecdocArticleName($out->articleName);

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
                $sql = "update `megasoft_product` set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . addslashes($out->articleName) . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
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
        //return;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        //if ($this->getSupplier())
        //    $this->erpSupplier = $this->getSupplier()->getTitle();

        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $dataindexarr = array();

        $dataindexarr[] = $this->erpCode;
        if ($this->erpCode2 != '')
            $dataindexarr[] = $this->erpCode2;

        if ($this->tecdocCode != '')
            $dataindexarr[] = $this->tecdocCode;

        if ($this->supplierCode != '')
            $dataindexarr[] = $this->supplierCode;


        if ($this->barcode != '')
            $dataindexarr[] = $this->barcode;

        $dataindexarr[] = trim($this->title);


        $dataindexarr[] = trim(strtolower($this->greeklish($this->title)));
        $dataindexarr[] = trim(strtolower($this->greeklish($this->erpSupplier)));

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
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        //$em = $this->getDoctrine()->getManager();
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));

        if ($this->erpCode2 == "") {
            //$this->erpCode2 = $this->erpCode;
        }

        if ($this->reference > 0)
            $data["StoreId"] = $this->reference;

        //if ($this->hasTransactions == 0) {
        $data["StoreDescr"] = $this->title;
        $data["StoreKwd"] = $this->erpCode;
        //}

        $data["StoreRetailPrice"] = (float) $this->storeRetailPrice;
        $data["StoreWholeSalePrice"] = (float) $this->storeWholeSalePrice;
        $data["RetailMarkup"] = (float) $this->retailMarkup;
        $data["WholeSaleMarkup"] = (float) $this->wholeSaleMarkup;

        $data["SupplierCode"] = $this->supplierCode;
        if ($this->getManufacturer())
            $data["SupplierId"] = $this->getManufacturer()->getCode();
        if ($this->getTecdocSupplierId())
            $data["fwSupplierId"] = $this->getTecdocSupplierId()->getId();
        $data["fwCode"] = $this->tecdocCode;
        $data["barcode"] = $this->barcode;
        $data["place"] = $this->place;
        $data["remarks"] = $this->remarks;
        $data["webupd"] = $this->webupd == 1 ? 'True' : 'False';
        $data["supref"] = $this->getSupplier() ? $this->getSupplier()->getSupplierCode() : "";
        //if ($this->getSupplier())
        $data["mtrsup"] = $this->getSupplier() ? $this->getSupplier()->getReference() : "";
        $data["sisxetisi"] = $this->sisxetisi;
        $data["fwSupplierItemCode"] = $this->supplierItemCode;
        $data["StoreCodeErp"] = ""; //$this->erpCode2;
        /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */

        $params["Login"] = $login;
        $params["JsonStrWeb"] = json_encode($data);
        //print_r($params);
        $response = $soap->__soapCall("SetProduct", array($params));
        //print_r($response);
        if ($response->SetProductResult > 0 AND $this->reference == 0) {
            $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
            $this->reference = $response->SetProductResult;
            $em->persist($this);
            $em->flush();
        }
        return $response;
        //exit;
    }

    public function getForOrderCode() {
        $r = ($this->lreplacer != '' AND $this->lreplacer != $this->erpCode) ? '['.$this->lreplacer.']' : '';
        $out = '<a title="' . $this->title . '" class="product_info" car="" data-articleId="' . $this->tecdocArticleId . '" data-ref="' . $this->id . '" href="#">' . $this->erpCode . ' '.$r.'</a>
        <br>
        <span class="text-sm text-info">' . $this->erpCode . '</span>';

        return $out;
    }

    public function getForOrderTitle() {


        $out = '<a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/erp01/product/view/' . $this->id . '">' . $this->title . '</a>
        <br>
        <span class="text-sm tecdocArticleName text-info">' . $this->tecdocArticleName . '</span>';

        return $out;
    }

    public function getEditLink() {
        $out = '<a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/erp01/product/view/' . $this->id . '">Edit</a>';
        return $out;
    }

    public function getForOrderSupplier() {

        //return "";
        $tecdoc = $this->getTecdocSupplierId() ? $this->getTecdocSupplierId()->getSupplier() : "";
        $ti = $this->getManufacturer() ? $this->getManufacturer()->getTitle() : "";
        //$ti = $this->erpSupplier;
        $out = '<a target="_blank" title="' . $ti . '"  class="" car="" data-articleId="' . $this->tecdocArticleId . '" data-ref="' . $this->id . '" href="#">' . $ti . '</a>
        <br>
        <span class="text-sm text-info">' . $tecdoc . '</span>';

        return $out;
    }

    function getArticleAttributes() {
        //return "";
        $tecdoc = new Tecdoc();

        $attributs = $tecdoc->getAssignedArticlesByIds(
                array(
                    "articleId" => $this->tecdocArticleId,
                    "linkingTargetId" => (string) $linkingTargetId
        ));
        $arr = array();
        $descrption .= "<ul class='product_attributes' style='max-height: 100px; overflow: hidden;'>";
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

    function getArticleAttributes2($linkingTargetId) {
        //return "";
        $tecdoc = new Tecdoc();

        $attributs = $tecdoc->getAssignedArticlesByIds(
                array(
                    "articleId" => $this->tecdocArticleId,
                    "linkingTargetId" => (string) $linkingTargetId
        ));
        $arr = array();
        $descrption .= "<ul class='product_attributes' style='max-height: 100px; overflow: hidden;'>";
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

    function getApothiki() {
        $qty = $this->qty - $this->reserved;
        return $this->qty . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty) . '</span>';
    }

    function getGroupedDiscountPrice(\MegasoftBundle\Entity\Customer $customer, $vat = 1) {
        $rules = $customer->loadCustomerrules()->getRules();
        $sortorder = 0;
        $discount = 0;
        $price = 0;
        $ruled = false;
        foreach ((array) $rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
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
                if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                    $sortorder = $rule->getSortorder();
                    $discount = $rule->getVal();
                    $price = $rule->getPrice();
                }
            }
        }

        //loadCustomerrules
        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "storeWholeSalePrice";
        $price = $price > 0 ? $price : $this->$pricefield;
        $discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        $finalprice = $discount > 0 ? $discountedPrice : $price;

        return number_format($finalprice * $vat, 2, '.', '');
    }

    function getGroupedDiscount(\MegasoftBundle\Entity\Customer $customer, $vat = 1) {
        $rules = $customer->loadCustomerrules()->getRules();
        $sortorder = 0;
        $discount = 0;
        $price = 0;
        $ruled = false;
        foreach ((array) $rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
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
                if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                    $sortorder = $rule->getSortorder();
                    $discount = $rule->getVal();
                    $price = $rule->getPrice();
                }
            }
        }
        //$pricefield = $customer->getPriceField() ? $customer->getPriceField() : "storeWholeSalePrice";
        //$price = $price > 0 ? $price : $this->$pricefield;
        //$discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        //$finalprice = $discount > 0 ? $discountedPrice : $price;
        return (float) $discount;
        //return number_format($price * $vat, 2, '.', '') . " (" . (float) $discount . "%)";
    }

    var $itemMtrplace = '';

    function getItemMtrplace() {
        return $this->itemMtrplace;
    }

    function getGroupedPrice(\MegasoftBundle\Entity\Customer $customer, $vat = 1) {
        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "storeWholeSalePrice";
        return number_format($this->$pricefield * $vat, 2, '.', '');
    }

    function getDiscount(\MegasoftBundle\Entity\Customer $customer, $vat = 1) {
        $rules = $customer->loadCustomerrules()->getRules();
        $sortorder = 0;
        $discount = 0;
        $price = 0;
        $ruled = false;
        foreach ((array) $rules as $rule) {
            if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
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
                if ($rule->validateRule($this) AND $sortorder <= $rule->getSortorder()) {
                    $sortorder = $rule->getSortorder();
                    $discount = $rule->getVal();
                    $price = $rule->getPrice();
                }
            }
        }

        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "storeWholeSalePrice";
        $price = $price > 0 ? $price : $this->$pricefield;
        $discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        //$finalprice = $discount > 0 ? $discountedPrice : $price;

        return number_format($price * $vat, 2, '.', '') . " (" . (float) $discount . "%)";
    }

    function getTick($order) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $orderItem = $em->getRepository("SoftoneBundle:Orderitem")
                ->findOneBy(array("order" => $order, "product" => $this));

        //if (@$orderItem->id == 0) {
        $display = @$orderItem->id == 0 ? "display:none" : "display:block";
        //}

        return '<img width="20" style="width:20px; max-width:20px; ' . $display . '" class="tick_' . $this->id . '" src="/assets/img/tick.png">';
    }

    /**
     * @var \MegasoftBundle\Entity\Manufacturer
     */
    private $manufacturer;

    /**
     * Set manufacturer
     *
     * @param \MegasoftBundle\Entity\Manufacturer $manufacturer
     *
     * @return Product
     */
    public function setManufacturer(\MegasoftBundle\Entity\Manufacturer $manufacturer = null) {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return \MegasoftBundle\Entity\Manufacturer
     */
    public function getManufacturer() {
        return $this->manufacturer;
    }

    /**
     * @var string
     */
    private $remarks;

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Product
     */
    public function setRemarks($remarks) {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks() {
        return $this->remarks;
    }

    /**
     * @var \MegasoftBundle\Entity\Supplier
     */
    private $supplier;

    /**
     * Set supplier
     *
     * @param \MegasoftBundle\Entity\Supplier $supplier
     *
     * @return Product
     */
    public function setSupplier(\MegasoftBundle\Entity\Supplier $supplier = null) {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \MegasoftBundle\Entity\Supplier
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * @var string
     */
    private $supref;

    /**
     * Set supref
     *
     * @param string $supref
     *
     * @return Product
     */
    public function setSupref($supref) {
        $this->supref = $supref;

        return $this;
    }

    /**
     * Get supref
     *
     * @return string
     */
    public function getSupref() {
        return $this->supref;
    }

    /**
     * @var string
     */
    private $place;

    /**
     * Set place
     *
     * @param string $place
     *
     * @return Product
     */
    public function setPlace($place) {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace() {
        return $this->place;
    }

    /**
     * @var string
     */
    private $barcode;

    /**
     * @var boolean
     */
    private $webupd = '0';

    /**
     * Set barcode
     *
     * @param string $barcode
     *
     * @return Product
     */
    public function setBarcode($barcode) {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode() {
        return $this->barcode;
    }

    /**
     * Set webupd
     *
     * @param boolean $webupd
     *
     * @return Product
     */
    public function setWebupd($webupd) {
        $this->webupd = $webupd;

        return $this;
    }

    /**
     * Get webupd
     *
     * @return boolean
     */
    public function getWebupd() {
        return $this->webupd;
    }

    /**
     * @var boolean
     */
    private $priceupd = '0';

    /**
     * @var boolean
     */
    private $hasTransactions = '0';

    /**
     * @var boolean
     */
    private $active = '1';

    /**
     * Set priceupd
     *
     * @param boolean $priceupd
     *
     * @return Product
     */
    public function setPriceupd($priceupd) {
        $this->priceupd = $priceupd;

        return $this;
    }

    /**
     * Get priceupd
     *
     * @return boolean
     */
    public function getPriceupd() {
        return $this->priceupd;
    }

    /**
     * Set hasTransactions
     *
     * @param boolean $hasTransactions
     *
     * @return Product
     */
    public function setHasTransactions($hasTransactions) {
        $this->hasTransactions = $hasTransactions;

        return $this;
    }

    /**
     * Get hasTransactions
     *
     * @return boolean
     */
    public function getHasTransactions() {
        return $this->hasTransactions;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Product
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * @var string
     */
    private $retailMarkup;

    /**
     * @var string
     */
    private $wholeSaleMarkup;

    /**
     * Set retailMarkup
     *
     * @param string $retailMarkup
     *
     * @return Product
     */
    public function setRetailMarkup($retailMarkup) {
        $this->retailMarkup = $retailMarkup;

        return $this;
    }

    /**
     * Get retailMarkup
     *
     * @return string
     */
    public function getRetailMarkup() {
        return $this->retailMarkup;
    }

    /**
     * Set wholeSaleMarkup
     *
     * @param string $wholeSaleMarkup
     *
     * @return Product
     */
    public function setWholeSaleMarkup($wholeSaleMarkup) {
        $this->wholeSaleMarkup = $wholeSaleMarkup;

        return $this;
    }

    /**
     * Get wholeSaleMarkup
     *
     * @return string
     */
    public function getWholeSaleMarkup() {
        return $this->wholeSaleMarkup;
    }

    /**
     * @var string
     */
    private $supplierItemCode;

    /**
     * Set supplierItemCode
     *
     * @param string $supplierItemCode
     *
     * @return Product
     */
    public function setSupplierItemCode($supplierItemCode) {
        $this->supplierItemCode = $supplierItemCode;

        return $this;
    }

    /**
     * Get supplierItemCode
     *
     * @return string
     */
    public function getSupplierItemCode() {
        return $this->supplierItemCode;
    }

    /**
     * @var string
     */
    private $var1 = '';

    /**
     * @var string
     */
    private $var2 = '';

    /**
     * @var string
     */
    private $var3 = '';

    /**
     * @var string
     */
    private $var4 = '';

    /**
     * @var string
     */
    private $var5 = '';

    /**
     * @var integer
     */
    private $int1 = '0';

    /**
     * @var integer
     */
    private $int2 = '0';

    /**
     * @var integer
     */
    private $int3 = '0';

    /**
     * @var integer
     */
    private $int4 = '0';

    /**
     * @var integer
     */
    private $int5 = '0';

    /**
     * @var string
     */
    private $text1;

    /**
     * @var string
     */
    private $text2;

    /**
     * Set var1
     *
     * @param string $var1
     *
     * @return Product
     */
    public function setVar1($var1) {
        $this->var1 = $var1;

        return $this;
    }

    /**
     * Get var1
     *
     * @return string
     */
    public function getVar1() {
        return $this->var1;
    }

    /**
     * Set var2
     *
     * @param string $var2
     *
     * @return Product
     */
    public function setVar2($var2) {
        $this->var2 = $var2;

        return $this;
    }

    /**
     * Get var2
     *
     * @return string
     */
    public function getVar2() {
        return $this->var2;
    }

    /**
     * Set var3
     *
     * @param string $var3
     *
     * @return Product
     */
    public function setVar3($var3) {
        $this->var3 = $var3;

        return $this;
    }

    /**
     * Get var3
     *
     * @return string
     */
    public function getVar3() {
        return $this->var3;
    }

    /**
     * Set var4
     *
     * @param string $var4
     *
     * @return Product
     */
    public function setVar4($var4) {
        $this->var4 = $var4;

        return $this;
    }

    /**
     * Get var4
     *
     * @return string
     */
    public function getVar4() {
        return $this->var4;
    }

    /**
     * Set var5
     *
     * @param string $var5
     *
     * @return Product
     */
    public function setVar5($var5) {
        $this->var5 = $var5;

        return $this;
    }

    /**
     * Get var5
     *
     * @return string
     */
    public function getVar5() {
        return $this->var5;
    }

    /**
     * Set int1
     *
     * @param integer $int1
     *
     * @return Product
     */
    public function setInt1($int1) {
        $this->int1 = $int1;

        return $this;
    }

    /**
     * Get int1
     *
     * @return integer
     */
    public function getInt1() {
        return $this->int1;
    }

    /**
     * Set int2
     *
     * @param integer $int2
     *
     * @return Product
     */
    public function setInt2($int2) {
        $this->int2 = $int2;

        return $this;
    }

    /**
     * Get int2
     *
     * @return integer
     */
    public function getInt2() {
        return $this->int2;
    }

    /**
     * Set int3
     *
     * @param integer $int3
     *
     * @return Product
     */
    public function setInt3($int3) {
        $this->int3 = $int3;

        return $this;
    }

    /**
     * Get int3
     *
     * @return integer
     */
    public function getInt3() {
        return $this->int3;
    }

    /**
     * Set int4
     *
     * @param integer $int4
     *
     * @return Product
     */
    public function setInt4($int4) {
        $this->int4 = $int4;

        return $this;
    }

    /**
     * Get int4
     *
     * @return integer
     */
    public function getInt4() {
        return $this->int4;
    }

    /**
     * Set int5
     *
     * @param integer $int5
     *
     * @return Product
     */
    public function setInt5($int5) {
        $this->int5 = $int5;

        return $this;
    }

    /**
     * Get int5
     *
     * @return integer
     */
    public function getInt5() {
        return $this->int5;
    }

    /**
     * Set text1
     *
     * @param string $text1
     *
     * @return Product
     */
    public function setText1($text1) {
        $this->text1 = $text1;

        return $this;
    }

    /**
     * Get text1
     *
     * @return string
     */
    public function getText1() {
        return $this->text1;
    }

    /**
     * Set text2
     *
     * @param string $text2
     *
     * @return Product
     */
    public function setText2($text2) {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return string
     */
    public function getText2() {
        return $this->text2;
    }

    /**
     * @var string
     */
    private $var6 = '';

    /**
     * @var integer
     */
    private $int6 = '0';

    /**
     * Set var6
     *
     * @param string $var6
     *
     * @return Product
     */
    public function setVar6($var6) {
        $this->var6 = $var6;

        return $this;
    }

    /**
     * Get var6
     *
     * @return string
     */
    public function getVar6() {
        return $this->var6;
    }

    /**
     * Set int6
     *
     * @param integer $int6
     *
     * @return Product
     */
    public function setInt6($int6) {
        $this->int6 = $int6;

        return $this;
    }

    /**
     * Get int6
     *
     * @return integer
     */
    public function getInt6() {
        return $this->int6;
    }

    /**
     * @var string
     */
    private $decimal1 = '0';

    /**
     * @var string
     */
    private $decimal2 = '0';

    /**
     * @var string
     */
    private $decimal3 = '0';

    /**
     * @var string
     */
    private $decimal4 = '0';

    /**
     * @var string
     */
    private $decimal5 = '0';

    /**
     * @var string
     */
    private $decimal6 = '0';

    /**
     * Set decimal1
     *
     * @param string $decimal1
     *
     * @return Product
     */
    public function setDecimal1($decimal1) {
        $this->decimal1 = $decimal1;

        return $this;
    }

    /**
     * Get decimal1
     *
     * @return string
     */
    public function getDecimal1() {
        return $this->decimal1;
    }

    /**
     * Set decimal2
     *
     * @param string $decimal2
     *
     * @return Product
     */
    public function setDecimal2($decimal2) {
        $this->decimal2 = $decimal2;

        return $this;
    }

    /**
     * Get decimal2
     *
     * @return string
     */
    public function getDecimal2() {
        return $this->decimal2;
    }

    /**
     * Set decimal3
     *
     * @param string $decimal3
     *
     * @return Product
     */
    public function setDecimal3($decimal3) {
        $this->decimal3 = $decimal3;

        return $this;
    }

    /**
     * Get decimal3
     *
     * @return string
     */
    public function getDecimal3() {
        return $this->decimal3;
    }

    /**
     * Set decimal4
     *
     * @param string $decimal4
     *
     * @return Product
     */
    public function setDecimal4($decimal4) {
        $this->decimal4 = $decimal4;

        return $this;
    }

    /**
     * Get decimal4
     *
     * @return string
     */
    public function getDecimal4() {
        return $this->decimal4;
    }

    /**
     * Set decimal5
     *
     * @param string $decimal5
     *
     * @return Product
     */
    public function setDecimal5($decimal5) {
        $this->decimal5 = $decimal5;

        return $this;
    }

    /**
     * Get decimal5
     *
     * @return string
     */
    public function getDecimal5() {
        return $this->decimal5;
    }

    /**
     * Set decimal6
     *
     * @param string $decimal6
     *
     * @return Product
     */
    public function setDecimal6($decimal6) {
        $this->decimal6 = $decimal6;

        return $this;
    }

    /**
     * Get decimal6
     *
     * @return string
     */
    public function getDecimal6() {
        return $this->decimal6;
    }

    /**
     * @var string
     */
    private $replaced = '';

    /**
     * @var string
     */
    private $lreplacer = '';

    /**
     * Set replaced
     *
     * @param string $replaced
     *
     * @return Product
     */
    public function setReplaced($replaced) {
        $this->replaced = $replaced;
        return $this;
    }

    
    public function setChainReplacer() {
        //if (!$this->replaced) return;
        //if ($this->lreplacer != '' AND $this->lreplacer != $this->erpCode) return;
        
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $product = $em->getRepository("MegasoftBundle:Product")
                ->findOneBy(array("replaced" => $this->erpCode));
        
        while ($product) {
            $this->lreplacer = $this->erpCode;
            $product->lreplacer = $this->erpCode;
            $em->persist($product);
            $em->flush();  
            $product = $em->getRepository("MegasoftBundle:Product")->findOneBy(array("replaced" => $product->erpCode));
            if ($i++ > 30) return;
        }
        $em->persist($this);
        $em->flush(); 
        return $this;        
    }
    
    
    public function setReplacer() {
        if (!$this->replaced) return;
        if ($this->lreplacer != '' AND $this->lreplacer != $this->erpCode) return;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $product = $em->getRepository("MegasoftBundle:Product")
                ->findOneBy(array("erpCode" => $this->replaced));
        
        if (!$product) {
            $this->replaced = '';
            $em->persist($this);
            $em->flush();            
            return;
        }
        $products = $em->getRepository("MegasoftBundle:Product")
                ->findBy(array("replaced" => $this->replaced));        
        if (count($products) > 1) {
            $this->replaced = '';
            $em->persist($this);
            $em->flush();            
            return;
        }
        
        $product->lreplacer = $this->replaced;
        $em->persist($product);
        $em->flush();
        
        $this->lreplacer = $this->replaced;

        $products = $em->getRepository("MegasoftBundle:Product")
                ->findBy(array("lreplacer" => $this->erpCode)); 
        
        foreach($products as $product) {
            $product->lreplacer = $this->replaced;
            $em->persist($product);
            $em->flush();
        }
        
        $em->persist($this);
        $em->flush();
        
        return $this;
    }    
    
    
    /**
     * Get replaced
     *
     * @return string
     */
    public function getReplaced() {
        return $this->replaced;
    }

    /**
     * Set lreplacer
     *
     * @param string $lreplacer
     *
     * @return Product
     */
    public function setLreplacer($lreplacer) {
        //$this->lreplacer = $lreplacer;
        return $this;
    }

    /**
     * Get lreplacer
     *
     * @return string
     */
    public function getLreplacer() {
        return $this->lreplacer;
    }

    /**
     * @var string
     */
    private $price1 = '0';

    /**
     * @var string
     */
    private $price2 = '0';

    /**
     * @var string
     */
    private $price3 = '0';

    /**
     * @var string
     */
    private $price4 = '0';

    /**
     * @var string
     */
    private $price5 = '0';


    /**
     * Set price1
     *
     * @param string $price1
     *
     * @return Product
     */
    public function setPrice1($price1)
    {
        $this->price1 = $price1;

        return $this;
    }

    /**
     * Get price1
     *
     * @return string
     */
    public function getPrice1()
    {
        return $this->price1;
    }

    /**
     * Set price2
     *
     * @param string $price2
     *
     * @return Product
     */
    public function setPrice2($price2)
    {
        $this->price2 = $price2;

        return $this;
    }

    /**
     * Get price2
     *
     * @return string
     */
    public function getPrice2()
    {
        return $this->price2;
    }

    /**
     * Set price3
     *
     * @param string $price3
     *
     * @return Product
     */
    public function setPrice3($price3)
    {
        $this->price3 = $price3;

        return $this;
    }

    /**
     * Get price3
     *
     * @return string
     */
    public function getPrice3()
    {
        return $this->price3;
    }

    /**
     * Set price4
     *
     * @param string $price4
     *
     * @return Product
     */
    public function setPrice4($price4)
    {
        $this->price4 = $price4;

        return $this;
    }

    /**
     * Get price4
     *
     * @return string
     */
    public function getPrice4()
    {
        return $this->price4;
    }

    /**
     * Set price5
     *
     * @param string $price5
     *
     * @return Product
     */
    public function setPrice5($price5)
    {
        $this->price5 = $price5;

        return $this;
    }

    /**
     * Get price5
     *
     * @return string
     */
    public function getPrice5()
    {
        return $this->price5;
    }
}
