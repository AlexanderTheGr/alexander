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

    function updatetecdoc($forceupdate = false) {
        //$data = array("service" => "login", 'username' => 'dev', 'password' => 'dev', 'appId' => '2000');

        if ((int) $this->dlnr == 0 OR $this->artNr == '')
            return;


        //echo $this->getTecdocArticleId();
        if ($this->getTecdocArticleId() > 0 and $forceupdate == false)
            return;



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
            "brandno" => $this->dlnr
        );
        //echo ".";

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
        //$this->toSoftoneErp();
        $this->toMegasoftErp();
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
                //echo $sql . "<BR>";
                $em->getConnection()->exec($sql);
            } else {
                //$sql = "update " . strtolower($params["table"]) . " set " . implode(",", $q) . " where id = '" . $entity->getId() . "'";
                //$sql = "update megasoft_manufacturer set code = '" . $data["ManufacturerCode"] . "', title = '" . $data["ManufacturerName"] . "' where id = '" . $entity->getId() . "'";
                //echo $sql . "<BR>";
                //$em->getConnection()->exec($sql);
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
            echo $manufacturer->getTitle();
        }
        $tecdocSupplier = $em->getRepository("MegasoftBundle:TecdocSupplier")->find($this->dlnr);


        $sql = "Select id from megasoft_product where replace(replace(replace(replace(replace(`supref`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $this->clearstring($this->itemCode) . "' AND edi_id = '" . $this->getEdi()->getId() . "'";
        //echo $sql . "<BR>";
        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $data = $statement->fetch();
        $product = false;
        if ($data["id"] > 0)
            $product = $em->getRepository("MegasoftBundle:Product")->find($data["id"]);

        if (!$product) {
            $erpCode = $this->clearCode($this->partno) . "-" . $manufacturer->getCode();
            $product = $em->getRepository("MegasoftBundle:Product")->findOneBy(array("erpCode" => $erpCode));
        }
        $supplier = $em->getRepository("MegasoftBundle:Supplier")->find($this->getEdi()->getItemMtrsup());
        if ($product) {
            $product->setSupref($this->itemCode);
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
        $product->setSupref($this->itemCode);
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

            $product->setItemPricer((double) $this->getEdiMarkupPrice("itemPricer"));
            $product->setItemPricew((double) $this->getEdiMarkupPrice("itemPricew"));

            $em->persist($product);
            $em->flush();
            if ($TecdocSupplier) {
                $product->setTecdocSupplierId($TecdocSupplier);
            }
            $product->toSoftone();
            echo $this->clearCode($this->partno) . "-" . $SoftoneSupplier->getCode();
            return;
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

        $product->setItemPricer((double) $this->getEdiMarkupPrice("itemPricer"));
        $product->setItemPricew((double) $this->getEdiMarkupPrice("itemPricew"));


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
        $sql = 'UPDATE  `softone_product` SET `supplier_code` =  `item_code2`, `title` =  `item_name`, `tecdoc_code` =  `item_apvcode`, `erp_code` =  `item_code`, `supplier_id` =  `item_mtrmanfctr`';
        $em->getConnection()->exec($sql);
        $sql = 'update `softone_product` set product_sale = 1 where product_sale is null';
        $em->getConnection()->exec($sql);
        return;
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
            $supplier = str_replace("BLUEPRINT", "BLUE-PRINT", $supplier);
        if ($supplier == "BLUE PRINT")
            $supplier = str_replace("BLUE PRINT", "BLUE-PRINT", $supplier);
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

    public function getQty1() {
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

        return "<input type='text' data-id='" . $this->id . "' name='qty1_" . $this->id . "' value='" . $qty . "' size=2 id='qty1_" . $this->id . "' class='ediiteqty1'>";
    }

    public function getQty2() {
        return "<input type='text' data-id='" . $this->id . "' name='qty2_" . $this->id . "' size=2  id='qty1_" . $this->id . "' class='ediiteqty2'>";
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

            $Item["ItemCode"] = $this->getPartno();
            $Item["ReqQty"] = $qty;

            $data['Items'][] = $Item;
            //$jsonarr2[(int)$key] = $json;
            //print_r($datas);
            //print_r($datas);
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
            //$data_string = '{ "ApiToken": "b5ab708b-0716-4c91-a8f3-b6513990fe3c", "Items": [ { "ItemCode": "' . $this->erp_code . '", "ReqQty": 1 } ] } ';
            //return 10;
            $data_string = json_encode($data);
            print_r($data);
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


            //return;
            if (@count($re->Items))
                foreach ($re->Items as $Item) {
                    return number_format($Item->UnitPrice, 2, '.', '');
                }
        } else {
            $elteka = $this->eltekaAuth();
            $response = $elteka->getPartPrice(array('CustomerNo' => $this->CustomerNo, "EltrekkaRef" => $this->getItemcode()));
            $xml = $response->GetPartPriceResult->any;
            $xml = simplexml_load_string($xml);
            //print_r($xml);

            return $xml->Item->PriceOnPolicy;
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
        $markupedPrice = $this->getWholesaleprice() * (1 + $markup / 100 );
        return $price > 0 ? $price : $markupedPrice;
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

        return number_format($finalprice * $vat, 2, '.', '') . " (" . (float) $discount . "%)" .$customer->getPriceField();
    }

}
