<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="PartsboxBundle\Entity\ProductRepository")
 */
class Product {
    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="catalogue", type="integer", nullable=false)
     */
    private $catalogue;

    /**
     * @var string
     *
     * @ORM\Column(name="erp_code", type="string", length=255, nullable=false)
     */
    private $erpCode;

    /**
     * @var string
     *
     * @ORM\Column(name="tecdoc_code", type="string", length=255, nullable=false)
     */
    private $tecdocCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="tecdoc_supplier_id", type="integer", nullable=true)
     */
    private $tecdocSupplierId;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_code", type="string", length=255, nullable=false)
     */
    private $supplierCode;

    /**
     * @var string
     *
     * @ORM\Column(name="erp_supplier", type="string", length=255, nullable=false)
     */
    private $erpSupplier;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="disc1prc", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $disc1prc;

    /**
     * @var string
     *
     * @ORM\Column(name="tecdoc_article_name", type="string", length=255, nullable=false)
     */
    private $tecdocArticleName;

    /**
     * @var integer
     *
     * @ORM\Column(name="tecdoc_generic_article_id", type="integer", nullable=false)
     */
    private $tecdocGenericArticleId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_insdate", type="datetime", nullable=false)
     */
    private $itemInsdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_upddate", type="datetime", nullable=false)
     */
    private $itemUpddate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="item_isactive", type="boolean", nullable=false)
     */
    private $itemIsactive = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="item_cccfxrelbrand", type="integer", nullable=false)
     */
    private $itemCccfxrelbrand;

    /**
     * @var string
     *
     * @ORM\Column(name="item_cccfxreltdcode", type="string", length=255, nullable=false)
     */
    private $itemCccfxreltdcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_vat", type="integer", nullable=false)
     */
    private $itemVat;

    /**
     * @var string
     *
     * @ORM\Column(name="item_cccfxcode1", type="string", length=255, nullable=false)
     */
    private $itemCccfxcode1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrmanfctr", type="string", length=255, nullable=false)
     */
    private $itemMtrmanfctr;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricer;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $itemPricew;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew01", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricew01;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew02", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricew02;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew03", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricew03;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer01", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricer01;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer02", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemPricer02;

    /**
     * @var string
     *
     * @ORM\Column(name="item_markupw", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemMarkupw;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrunit1", type="integer", nullable=false)
     */
    private $itemMtrunit1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name1", type="string", length=255, nullable=false)
     */
    private $itemName1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name", type="string", length=255, nullable=false)
     */
    private $itemName;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code", type="string", length=255, nullable=false)
     */
    private $itemCode;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code1", type="string", length=255, nullable=false)
     */
    private $itemCode1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code2", type="string", length=255, nullable=false)
     */
    private $itemCode2;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrplace", type="string", length=255, nullable=false)
     */
    private $itemMtrplace;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrsup", type="integer", nullable=false)
     */
    private $itemMtrsup;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrcategory", type="integer", nullable=false)
     */
    private $itemMtrcategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrl_itemtrdata_qty1", type="integer", nullable=false)
     */
    private $itemMtrlItemtrdataQty1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="updated", type="boolean", nullable=false)
     */
    private $updated = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=false)
     */
    private $media;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    private $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=false)
     */
    private $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_data", type="text", nullable=false)
     */
    private $flatData;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=255, nullable=false)
     */
    private $search;

    /**
     * @var string
     *
     * @ORM\Column(name="gnisia", type="string", length=255, nullable=false)
     */
    private $gnisia;

    /**
     * @var string
     *
     * @ORM\Column(name="search2", type="text", length=65535, nullable=false)
     */
    private $search2;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrl_iteextra_num02", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $itemMtrlIteextraNum02;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v3", type="integer", nullable=false)
     */
    private $itemV3;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v4", type="integer", nullable=false)
     */
    private $itemV4;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_v5", type="datetime", nullable=false)
     */
    private $itemV5;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v6", type="integer", nullable=false)
     */
    private $itemV6;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v7", type="integer", nullable=false)
     */
    private $itemV7;

    /**
     * @var string
     *
     * @ORM\Column(name="rafi1", type="string", length=255, nullable=false)
     */
    private $rafi1;

    /**
     * @var string
     *
     * @ORM\Column(name="rafi2", type="string", length=255, nullable=false)
     */
    private $rafi2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

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
     * Set catalogue
     *
     * @param integer $catalogue
     *
     * @return Product
     */
    public function setCatalogue($catalogue) {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * Get catalogue
     *
     * @return integer
     */
    public function getCatalogue() {
        return $this->catalogue;
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
     * Set tecdocSupplierId
     *
     * @param integer $tecdocSupplierId
     *
     * @return Product
     */
    public function setTecdocSupplierId($tecdocSupplierId) {
        $this->tecdocSupplierId = $tecdocSupplierId;

        return $this;
    }

    /**
     * Get tecdocSupplierId
     *
     * @return integer
     */
    public function getTecdocSupplierId() {
        return $this->tecdocSupplierId;
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
     * Set disc1prc
     *
     * @param string $disc1prc
     *
     * @return Product
     */
    public function setDisc1prc($disc1prc) {
        $this->disc1prc = $disc1prc;

        return $this;
    }

    /**
     * Get disc1prc
     *
     * @return string
     */
    public function getDisc1prc() {
        return $this->disc1prc;
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
     * Set itemInsdate
     *
     * @param \DateTime $itemInsdate
     *
     * @return Product
     */
    public function setItemInsdate($itemInsdate) {
        $this->itemInsdate = $itemInsdate;

        return $this;
    }

    /**
     * Get itemInsdate
     *
     * @return \DateTime
     */
    public function getItemInsdate() {
        return $this->itemInsdate;
    }

    /**
     * Set itemUpddate
     *
     * @param \DateTime $itemUpddate
     *
     * @return Product
     */
    public function setItemUpddate($itemUpddate) {
        $this->itemUpddate = $itemUpddate;

        return $this;
    }

    /**
     * Get itemUpddate
     *
     * @return \DateTime
     */
    public function getItemUpddate() {
        return $this->itemUpddate;
    }

    /**
     * Set itemIsactive
     *
     * @param boolean $itemIsactive
     *
     * @return Product
     */
    public function setItemIsactive($itemIsactive) {
        $this->itemIsactive = $itemIsactive;

        return $this;
    }

    /**
     * Get itemIsactive
     *
     * @return boolean
     */
    public function getItemIsactive() {
        return $this->itemIsactive;
    }

    /**
     * Set itemCccfxrelbrand
     *
     * @param integer $itemCccfxrelbrand
     *
     * @return Product
     */
    public function setItemCccfxrelbrand($itemCccfxrelbrand) {
        $this->itemCccfxrelbrand = $itemCccfxrelbrand;

        return $this;
    }

    /**
     * Get itemCccfxrelbrand
     *
     * @return integer
     */
    public function getItemCccfxrelbrand() {
        return $this->itemCccfxrelbrand;
    }

    /**
     * Set itemCccfxreltdcode
     *
     * @param string $itemCccfxreltdcode
     *
     * @return Product
     */
    public function setItemCccfxreltdcode($itemCccfxreltdcode) {
        $this->itemCccfxreltdcode = $itemCccfxreltdcode;

        return $this;
    }

    /**
     * Get itemCccfxreltdcode
     *
     * @return string
     */
    public function getItemCccfxreltdcode() {
        return $this->itemCccfxreltdcode;
    }

    /**
     * Set itemVat
     *
     * @param integer $itemVat
     *
     * @return Product
     */
    public function setItemVat($itemVat) {
        $this->itemVat = $itemVat;

        return $this;
    }

    /**
     * Get itemVat
     *
     * @return integer
     */
    public function getItemVat() {
        return $this->itemVat;
    }

    /**
     * Set itemCccfxcode1
     *
     * @param string $itemCccfxcode1
     *
     * @return Product
     */
    public function setItemCccfxcode1($itemCccfxcode1) {
        $this->itemCccfxcode1 = $itemCccfxcode1;

        return $this;
    }

    /**
     * Get itemCccfxcode1
     *
     * @return string
     */
    public function getItemCccfxcode1() {
        return $this->itemCccfxcode1;
    }

    /**
     * Set itemMtrmanfctr
     *
     * @param string $itemMtrmanfctr
     *
     * @return Product
     */
    public function setItemMtrmanfctr($itemMtrmanfctr) {
        $this->itemMtrmanfctr = $itemMtrmanfctr;

        return $this;
    }

    /**
     * Get itemMtrmanfctr
     *
     * @return string
     */
    public function getItemMtrmanfctr() {
        return $this->itemMtrmanfctr;
    }

    /**
     * Set itemPricer
     *
     * @param string $itemPricer
     *
     * @return Product
     */
    public function setItemPricer($itemPricer) {
        $this->itemPricer = $itemPricer;

        return $this;
    }

    /**
     * Get itemPricer
     *
     * @return string
     */
    public function getItemPricer() {
        return $this->itemPricer;
    }

    /**
     * Set itemPricew
     *
     * @param string $itemPricew
     *
     * @return Product
     */
    public function setItemPricew($itemPricew) {
        $this->itemPricew = $itemPricew;

        return $this;
    }

    /**
     * Get itemPricew
     *
     * @return string
     */
    public function getItemPricew() {
        return $this->itemPricew;
    }

    /**
     * Set itemPricew01
     *
     * @param string $itemPricew01
     *
     * @return Product
     */
    public function setItemPricew01($itemPricew01) {
        $this->itemPricew01 = $itemPricew01;

        return $this;
    }

    /**
     * Get itemPricew01
     *
     * @return string
     */
    public function getItemPricew01() {
        return $this->itemPricew01;
    }

    /**
     * Set itemPricew02
     *
     * @param string $itemPricew02
     *
     * @return Product
     */
    public function setItemPricew02($itemPricew02) {
        $this->itemPricew02 = $itemPricew02;

        return $this;
    }

    /**
     * Get itemPricew02
     *
     * @return string
     */
    public function getItemPricew02() {
        return $this->itemPricew02;
    }

    /**
     * Set itemPricew03
     *
     * @param string $itemPricew03
     *
     * @return Product
     */
    public function setItemPricew03($itemPricew03) {
        $this->itemPricew03 = $itemPricew03;

        return $this;
    }

    /**
     * Get itemPricew03
     *
     * @return string
     */
    public function getItemPricew03() {
        return $this->itemPricew03;
    }

    /**
     * Set itemPricer01
     *
     * @param string $itemPricer01
     *
     * @return Product
     */
    public function setItemPricer01($itemPricer01) {
        $this->itemPricer01 = $itemPricer01;

        return $this;
    }

    /**
     * Get itemPricer01
     *
     * @return string
     */
    public function getItemPricer01() {
        return $this->itemPricer01;
    }

    /**
     * Set itemPricer02
     *
     * @param string $itemPricer02
     *
     * @return Product
     */
    public function setItemPricer02($itemPricer02) {
        $this->itemPricer02 = $itemPricer02;

        return $this;
    }

    /**
     * Get itemPricer02
     *
     * @return string
     */
    public function getItemPricer02() {
        return $this->itemPricer02;
    }

    /**
     * Set itemMarkupw
     *
     * @param string $itemMarkupw
     *
     * @return Product
     */
    public function setItemMarkupw($itemMarkupw) {
        $this->itemMarkupw = $itemMarkupw;

        return $this;
    }

    /**
     * Get itemMarkupw
     *
     * @return string
     */
    public function getItemMarkupw() {
        return $this->itemMarkupw;
    }

    /**
     * Set itemMtrunit1
     *
     * @param integer $itemMtrunit1
     *
     * @return Product
     */
    public function setItemMtrunit1($itemMtrunit1) {
        $this->itemMtrunit1 = $itemMtrunit1;

        return $this;
    }

    /**
     * Get itemMtrunit1
     *
     * @return integer
     */
    public function getItemMtrunit1() {
        return $this->itemMtrunit1;
    }

    /**
     * Set itemName1
     *
     * @param string $itemName1
     *
     * @return Product
     */
    public function setItemName1($itemName1) {
        $this->itemName1 = $itemName1;

        return $this;
    }

    /**
     * Get itemName1
     *
     * @return string
     */
    public function getItemName1() {
        return $this->itemName1;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     *
     * @return Product
     */
    public function setItemName($itemName) {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName() {
        return $this->itemName;
    }

    /**
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return Product
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
     * Set itemCode1
     *
     * @param string $itemCode1
     *
     * @return Product
     */
    public function setItemCode1($itemCode1) {
        $this->itemCode1 = $itemCode1;

        return $this;
    }

    /**
     * Get itemCode1
     *
     * @return string
     */
    public function getItemCode1() {
        return $this->itemCode1;
    }

    /**
     * Set itemCode2
     *
     * @param string $itemCode2
     *
     * @return Product
     */
    public function setItemCode2($itemCode2) {
        $this->itemCode2 = $itemCode2;

        return $this;
    }

    /**
     * Get itemCode2
     *
     * @return string
     */
    public function getItemCode2() {
        return $this->itemCode2;
    }

    /**
     * Set itemMtrplace
     *
     * @param string $itemMtrplace
     *
     * @return Product
     */
    public function setItemMtrplace($itemMtrplace) {
        $this->itemMtrplace = $itemMtrplace;

        return $this;
    }

    /**
     * Get itemMtrplace
     *
     * @return string
     */
    public function getItemMtrplace() {
        return $this->itemMtrplace;
    }

    /**
     * Set itemMtrsup
     *
     * @param integer $itemMtrsup
     *
     * @return Product
     */
    public function setItemMtrsup($itemMtrsup) {
        $this->itemMtrsup = $itemMtrsup;

        return $this;
    }

    /**
     * Get itemMtrsup
     *
     * @return integer
     */
    public function getItemMtrsup() {
        return $this->itemMtrsup;
    }

    /**
     * Set itemMtrcategory
     *
     * @param integer $itemMtrcategory
     *
     * @return Product
     */
    public function setItemMtrcategory($itemMtrcategory) {
        $this->itemMtrcategory = $itemMtrcategory;

        return $this;
    }

    /**
     * Get itemMtrcategory
     *
     * @return integer
     */
    public function getItemMtrcategory() {
        return $this->itemMtrcategory;
    }

    /**
     * Set itemMtrlItemtrdataQty1
     *
     * @param integer $itemMtrlItemtrdataQty1
     *
     * @return Product
     */
    public function setItemMtrlItemtrdataQty1($itemMtrlItemtrdataQty1) {
        $this->itemMtrlItemtrdataQty1 = $itemMtrlItemtrdataQty1;

        return $this;
    }

    /**
     * Get itemMtrlItemtrdataQty1
     *
     * @return integer
     */
    public function getItemMtrlItemtrdataQty1() {
        return $this->itemMtrlItemtrdataQty1;
    }

    /**
     * Set updated
     *
     * @param boolean $updated
     *
     * @return Product
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return boolean
     */
    public function getUpdated() {
        return $this->updated;
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
     * Set flatData
     *
     * @param string $flatData
     *
     * @return Product
     */
    public function setFlatData($flatData) {
        $this->flatData = $flatData;

        return $this;
    }

    /**
     * Get flatData
     *
     * @return string
     */
    public function getFlatData() {
        return $this->flatData;
    }

    /**
     * Set search
     *
     * @param string $search
     *
     * @return Product
     */
    public function setSearch($search) {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string
     */
    public function getSearch() {
        return $this->search;
    }

    /**
     * Set gnisia
     *
     * @param string $gnisia
     *
     * @return Product
     */
    public function setGnisia($gnisia) {
        $this->gnisia = $gnisia;

        return $this;
    }

    /**
     * Get gnisia
     *
     * @return string
     */
    public function getGnisia() {
        return $this->gnisia;
    }

    /**
     * Set search2
     *
     * @param string $search2
     *
     * @return Product
     */
    public function setSearch2($search2) {
        $this->search2 = $search2;

        return $this;
    }

    /**
     * Get search2
     *
     * @return string
     */
    public function getSearch2() {
        return $this->search2;
    }

    /**
     * Set itemMtrlIteextraNum02
     *
     * @param string $itemMtrlIteextraNum02
     *
     * @return Product
     */
    public function setItemMtrlIteextraNum02($itemMtrlIteextraNum02) {
        $this->itemMtrlIteextraNum02 = $itemMtrlIteextraNum02;

        return $this;
    }

    /**
     * Get itemMtrlIteextraNum02
     *
     * @return string
     */
    public function getItemMtrlIteextraNum02() {
        return $this->itemMtrlIteextraNum02;
    }

    /**
     * Set itemV3
     *
     * @param integer $itemV3
     *
     * @return Product
     */
    public function setItemV3($itemV3) {
        $this->itemV3 = $itemV3;

        return $this;
    }

    /**
     * Get itemV3
     *
     * @return integer
     */
    public function getItemV3() {
        return $this->itemV3;
    }

    /**
     * Set itemV4
     *
     * @param integer $itemV4
     *
     * @return Product
     */
    public function setItemV4($itemV4) {
        $this->itemV4 = $itemV4;

        return $this;
    }

    /**
     * Get itemV4
     *
     * @return integer
     */
    public function getItemV4() {
        return $this->itemV4;
    }

    /**
     * Set itemV5
     *
     * @param \DateTime $itemV5
     *
     * @return Product
     */
    public function setItemV5($itemV5) {
        $this->itemV5 = $itemV5;

        return $this;
    }

    /**
     * Get itemV5
     *
     * @return \DateTime
     */
    public function getItemV5() {
        return $this->itemV5;
    }

    /**
     * Set itemV6
     *
     * @param integer $itemV6
     *
     * @return Product
     */
    public function setItemV6($itemV6) {
        $this->itemV6 = $itemV6;

        return $this;
    }

    /**
     * Get itemV6
     *
     * @return integer
     */
    public function getItemV6() {
        return $this->itemV6;
    }

    /**
     * Set itemV7
     *
     * @param integer $itemV7
     *
     * @return Product
     */
    public function setItemV7($itemV7) {
        $this->itemV7 = $itemV7;

        return $this;
    }

    /**
     * Get itemV7
     *
     * @return integer
     */
    public function getItemV7() {
        return $this->itemV7;
    }

    /**
     * Set rafi1
     *
     * @param string $rafi1
     *
     * @return Product
     */
    public function setRafi1($rafi1) {
        $this->rafi1 = $rafi1;

        return $this;
    }

    /**
     * Get rafi1
     *
     * @return string
     */
    public function getRafi1() {
        return $this->rafi1;
    }

    /**
     * Set rafi2
     *
     * @param string $rafi2
     *
     * @return Product
     */
    public function setRafi2($rafi2) {
        $this->rafi2 = $rafi2;

        return $this;
    }

    /**
     * Get rafi2
     *
     * @return string
     */
    public function getRafi2() {
        return $this->rafi2;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


}
