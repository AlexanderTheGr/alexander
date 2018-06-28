<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use AppBundle\Entity\Tecdoc as Tecdoc;
use SoftoneBundle\Entity\Softone as Softone;
use SoftoneBundle\Entity\TecdocSupplier as TecdocSupplier;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="SoftoneBundle\Entity\ProductRepository")
 */
class Product extends Entity {

    var $repositories = array();
    var $uniques = array();
    var $lng = 20;

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
        $this->repositories['tecdocSupplierId'] = 'SoftoneBundle:TecdocSupplier';
        $this->repositories['supplierId'] = 'SoftoneBundle:SoftoneSupplier';
        $this->repositories['productSale'] = 'SoftoneBundle:ProductSale';
        $this->repositories['mtrsup'] = 'SoftoneBundle:Supplier';
        $this->types['tecdocSupplierId'] = 'object';
        $this->types['supplierId'] = 'object';
        $this->types['productSale'] = 'object';

        $this->uniques = array("erpCode", "itemCode");

        //$this->tecdocSupplierId = new \SoftoneBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        $this->repositories['tecdocSupplierId'] = 'SoftoneBundle:TecdocSupplier';
        $this->repositories['supplierId'] = 'SoftoneBundle:SoftoneSupplier';
        $this->repositories['productSale'] = 'SoftoneBundle:ProductSale';
        $this->repositories['mtrsup'] = 'SoftoneBundle:Supplier';

        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['tecdocSupplierId'] = 'object';
        $this->types['supplierId'] = 'object';
        $this->types['productSale'] = 'object';
        $this->types['mtrsup'] = 'object';
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
     *
     * @ORM\Column(name="catalogue", type="integer", nullable=false)
     */
    protected $catalogue;

    /**
     * @var string
     *
     * @ORM\Column(name="erp_code", type="string", length=255, nullable=false)
     */
    protected $erpCode;

    /**
     * @var string
     *
     * @ORM\Column(name="tecdoc_code", type="string", length=255, nullable=false)
     */
    protected $tecdocCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="tecdoc_supplier_id", type="integer", nullable=true)
     */
    protected $tecdocSupplierId;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_code", type="string", length=255, nullable=false)
     */
    protected $supplierCode;

    /**
     * @var string
     *
     * @ORM\Column(name="erp_supplier", type="string", length=255, nullable=false)
     */
    protected $erpSupplier;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", length=65535, nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="disc1prc", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $disc1prc;

    /**
     * @var string
     *
     * @ORM\Column(name="tecdoc_article_name", type="string", length=255, nullable=false)
     */
    protected $tecdocArticleName;

    /**
     * @var integer
     *
     * @ORM\Column(name="tecdoc_generic_article_id", type="integer", nullable=false)
     */
    protected $tecdocGenericArticleId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_insdate", type="datetime", nullable=false)
     */
    protected $itemInsdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_upddate", type="datetime", nullable=false)
     */
    protected $itemUpddate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="item_isactive", type="boolean", nullable=false)
     */
    protected $itemIsactive = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="item_cccfxrelbrand", type="integer", nullable=false)
     */
    protected $itemCccfxrelbrand;

    /**
     * @var string
     *
     * @ORM\Column(name="item_cccfxreltdcode", type="string", length=255, nullable=false)
     */
    protected $itemCccfxreltdcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_vat", type="integer", nullable=false)
     */
    protected $itemVat;

    /**
     * @var string
     *
     * @ORM\Column(name="item_cccfxcode1", type="string", length=255, nullable=false)
     */
    protected $itemCccfxcode1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrmanfctr", type="string", length=255, nullable=false)
     */
    protected $itemMtrmanfctr;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricer;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew", type="decimal", precision=10, scale=0, nullable=false)
     */
    protected $itemPricew;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew01", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricew01;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew02", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricew02;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricew03", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricew03;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer01", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricer01;

    /**
     * @var string
     *
     * @ORM\Column(name="item_pricer02", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemPricer02;

    /**
     * @var string
     *
     * @ORM\Column(name="item_markupw", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemMarkupw;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrunit1", type="integer", nullable=false)
     */
    protected $itemMtrunit1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name1", type="string", length=255, nullable=false)
     */
    protected $itemName1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_name", type="string", length=255, nullable=false)
     */
    protected $itemName;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code", type="string", length=255, nullable=false)
     */
    protected $itemCode;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code1", type="string", length=255, nullable=false)
     */
    protected $itemCode1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code2", type="string", length=255, nullable=false)
     */
    protected $itemCode2;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrplace", type="string", length=255, nullable=false)
     */
    protected $itemMtrplace;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrsup", type="integer", nullable=false)
     */
    protected $itemMtrsup;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrcategory", type="integer", nullable=false)
     */
    protected $itemMtrcategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_mtrl_itemtrdata_qty1", type="integer", nullable=false)
     */
    protected $itemMtrlItemtrdataQty1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="updated", type="boolean", nullable=false)
     */
    protected $updated = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=false)
     */
    protected $media;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=false)
     */
    protected $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    protected $modified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="synchronized", type="datetime", nullable=false)
     */
    protected $synchronized;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_data", type="text", nullable=false)
     */
    protected $flatData;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=255, nullable=false)
     */
    protected $search;

    /**
     * @var string
     *
     * @ORM\Column(name="gnisia", type="string", length=255, nullable=false)
     */
    protected $gnisia;

    /**
     * @var string
     *
     * @ORM\Column(name="search2", type="text", length=65535, nullable=false)
     */
    protected $search2;

    /**
     * @var string
     *
     * @ORM\Column(name="item_mtrl_iteextra_num02", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $itemMtrlIteextraNum02;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v3", type="integer", nullable=false)
     */
    protected $itemV3;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v4", type="integer", nullable=false)
     */
    protected $itemV4;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="item_v5", type="datetime", nullable=false)
     */
    protected $itemV5;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v6", type="integer", nullable=false)
     */
    protected $itemV6;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_v7", type="integer", nullable=false)
     */
    protected $itemV7;

    /**
     * @var string
     *
     * @ORM\Column(name="rafi1", type="string", length=255, nullable=false)
     */
    protected $rafi1;

    /**
     * @var string
     *
     * @ORM\Column(name="rafi2", type="string", length=255, nullable=false)
     */
    protected $rafi2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

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
    public function setTs(\DateTime $ts) {
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
    public function setCreated(\DateTime $created) {
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
    public function setModified(\DateTime $modified) {
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
     * Set synchronized
     *
     * @param \DateTime $modified
     *
     * @return Product
     */
    public function setSynchronized(\DateTime $synchronized) {
        $this->synchronized = $synchronized;

        return $this;
    }

    /**
     * Get synchronized
     *
     * @return \DateTime
     */
    public function getSynchronized() {
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

    /**
     * @var string
     */
    protected $edi;

    /**
     * @var integer
     */
    protected $ediId;

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
     * @var string
     */
    private $cats;

    /**
     * @var string
     */
    private $cars;

    /**
     * Set cats
     *
     * @param string $cars
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
        return (array) unserialize($this->cats);
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

    function updatetecdoc($tecdoc = false, $forceupdate = false) {

        //$data = array("service" => "login", 'username' => 'dev', 'password' => 'dev', 'appId' => '2000');
        if (!$this->getTecdocSupplierId())
            return;
        if ($this->getTecdocSupplierId() == null AND $forceupdate == false)
            return;

        //echo 'sss';	

        $this->setTecdocArticleId($out->articleId);
        $this->setTecdocArticleName($out->articleName);

        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        //$data_string = json_encode($data);
        $url = $this->getSetting("AppBundle:Entity:tecdocServiceUrl");
        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            $postparams = array(
                "articleNumber" => $this->tecdocCode,
                "lng" => 20,
                "brandno" => $this->getTecdocSupplierId()->getId()
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
            print_r($datas);
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
            print_r($out);
            if (@$out->articleId) {
                $this->setTecdocArticleId($out->articleId);
                $this->setTecdocArticleName($out->articleName);
                //$this->tecdocArticleId= $out->articleId;
                $categories = array();
                $cars = array();
                $sql = "update `softone_product` set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . $out->articleName . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
                $em->getConnection()->exec($sql);


                $this->getDetailssnew();
            }
            return;
        } else {


            $postparams = array(
                "articleNumber" => $this->tecdocCode,
                "brandno" => $this->getTecdocSupplierId()->getId()
            );
            //if (!$tecdoc)
            $tecdoc = new Tecdoc();
            if ($this->getSetting("AppBundle:Entity:lng") > 0) {
                $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
            };
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
                    $sql = "update `softone_product` set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . $out->articleName . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
                    $em->getConnection()->exec($sql);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        $tecdoc = null;
        unset($tecdoc);
        //echo $result;
    }

    function getDetailssnew() {


        echo "[" . $this->tecdocArticleId . "]";
        if ($this->tecdocArticleId == 0)
            return;
        //$this->getDetails();
        //return;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        //$this->connection = Mage::getSingleton('core/resource')->getConnection('core_write');
        $sql = "select * from t4_product_model_type where product = '" . $this->getId() . "'";
        echo $sql . "<BR>";
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

            //echo $sql."<BR>";
            $out = unserialize(file_get_contents($url));

            //$out = $this->connection->fetchAll($sql);
            //$result = mysqli_query($this->conn,$sql);
            //$out =  mysqli_fetch_all($result,MYSQLI_ASSOC);		
            $sql = "delete from t4_product_model_type where product = '" . $this->getId() . "'";
            $em->getConnection()->exec($sql);
            //$this->connection->query($sql);
            foreach ($out as $model_type) {
                if ($model_type == 0)
                    continue;
                $sql = "insert ignore t4_product_model_type set product = '" . $this->getId() . "', model_type = '" . $model_type["mod_lnk_vich_id"] . "'";
                //echo $sql."<BR>";
                //$this->connection->query($sql);
                $cars[] = $model_type["mod_lnk_vich_id"];
                $em->getConnection()->exec($sql);
            }
        }
        //return;		
        $sql = "select * from magento2_base4q2017.article_criteria, magento2_base4q2017.criteria, magento2_base4q2017.text_designations
			where acr_cri_id = 100 AND cri_id = acr_cri_id AND des_id = cri_des_id and des_lng_id = '" . $this->lng . "' and acr_art_id = '" . $this->tecdocArticleId . "'";
        //$criteria = $this->connection->fetchRow($sql);
        //echo $sql . "<BR>";

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
            //echo $sql . "<BR>";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            $kv_kv = unserialize(file_get_contents($url));
            //$result = $result = mysqli_query($this->conn,$sql);
            //$kv_kv =  mysqli_fetch_row($result,MYSQLI_ASSOC);	
            $kv_kv = $kv_kv[0];
            $kv = $kv_kv["kv_kv"]; // kv_kv HA VA
        }

        //if ($kv != 'VA' AND $kv != 'HA' ) return;

        $sql = "SELECT `str_id` FROM magento2_base4q2017.link_pt_str WHERE `str_type` = 1 AND pt_id in (Select pt_id from magento2_base4q2017.art_products_des where art_id = '" . $this->tecdocArticleId . "')";
        //$out = $this->connection->fetchAll($sql); 
        //echo $sql."<BR>";

        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
        $out = unserialize(file_get_contents($url));

        //$result = mysqli_query($this->conn,$sql);
        //$out =  mysqli_fetch_all($result,MYSQLI_ASSOC);	
        //print_r($out);
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
            echo "<BR>[".$sql."]<BR>";
            foreach ($cats as $cat) {
                if (in_array($cat["w_str_id"], $array)) {
                    $del = true;
                    echo "<BR>[".$kv."]<BR>";
                    echo "<BR>[".$kv."]<BR>";
                    echo "<BR>[".$kv."]<BR>";
                    echo "<BR>[".$kv."]<BR>";
                    if ($kv != 'VA' AND $kv != 'HA' AND $kv != 'VL' AND $kv != 'HL' AND $kv != 'VR' AND $kv != 'HR' AND $kv != 'V' AND $kv != 'H') {
                        $term = preg_replace("/[^a-zA-Z0-9]+/", "", $product->getTecdocCode());
                        $sql = "SELECT all_art_id FROM magento2_base4q2017.art_lookup_links, magento2_base4q2017.art_lookup where all_arl_id = arl_id and arl_search_number = '" . $term . "'";
                        //$arts = $this->connection->fetchAll($sql);
                        //$result = mysqli_query($this->conn,$sql);
                        //$arts =  mysqli_fetch_all($result,MYSQLI_ASSOC);							
                        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                        $arts = unserialize(file_get_contents($url));
                        foreach ($arts as $art) {
                            $artsss[$art["all_art_id"]] = $art["all_art_id"];
                        }
                        $sql = "select acr_kv_kv, acr_kv_kt_id, count(acr_kv_kv) as cnt from magento2_base4q2017.article_criteria, magento2_base4q2017.criteria, magento2_base4q2017.text_designations
								where acr_cri_id = 100 AND cri_id = acr_cri_id AND des_id = cri_des_id and des_lng_id = '" . $this->lng . "' and acr_art_id in (" . implode(",", $artsss) . ") group by acr_kv_kv order by cnt desc";
                        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);

                        echo "<BR>" . $sql . "<BR>";

                        $criteria = unserialize(file_get_contents($url));
                        $criteria = $criteria[0];
                        print_r($criteria);
                        if ($criteria["acr_kv_kt_id"]) {

                            $kv = $criteria["acr_kv_kv"];
                            if ($kv != "") {
                                echo "<BR>[" . $kv . "]<BR>";
                                break;
                            }
                            $sql = "select kv_kv from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["acr_kv_kt_id"] . "' AND kv_kv = '" . $criteria["acr_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";
                            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                            $kv_kv = unserialize(file_get_contents($url));
                            //print_r($kv_kv);
                            $kv_kv = $kv_kv[0];
                            $kv = $kv_kv["kv_kv"]; // kv_kv HA VA
                            if ($kv != "") {
                                echo "<BR>[" . $kv . "]<BR>";
                                break;
                            }
                        }
                    }
                }
            }
        }
        $sql = "delete from t4_product_category where product = '" . $this->getId() . "'";
        $em->getConnection()->exec($sql);
        //echo "<BR>" . $sql . "<BR>";
        //return;
        //echo "<BR>" . $kv . "<BR>";
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
                    if ($kv == 'VA' OR $kv == 'VR' OR $kv == 'VL' OR $kv == 'V') {
                        $sql = "insert ignore t4_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                        $catva = true;
                        //echo "VA: " . $sql . "<BR>";
                        $categories[] = $cat["w_str_id"];
                    }
                } elseif ($cat["w_str_id"] == 11024 OR $cat["w_str_id"] == 11200 OR $cat["w_str_id"] == 11002 OR $cat["w_str_id"] == 11110 OR $cat["w_str_id"] == 11177) {
                    if ($kv == 'HA' OR $kv == 'HR' OR $kv == 'HL' OR $kv == 'H') {
                        $sql = "insert ignore t4_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
                        $catha = true;
                        //echo "ΗΑ: " . $sql . "<BR>";
                        $categories[] = $cat["w_str_id"];
                    }
                } else {
                    $sql = "insert ignore t4_product_category set product = '" . $this->getId() . "', category2 = '" . $category["str_id"] . "', category = '" . $cat["w_str_id"] . "'";
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
        foreach ($sqls as $sql) {
            echo $sql."<BR>";
            $em->getConnection()->exec($sql);
        }
        $sql = "update `softone_product` set cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
        $em->getConnection()->exec($sql);
        //print_r($out);
        exit;
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

    /**
     * @var integer
     */
    private $tecdocArticleId;

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
     * @var integer
     */
    private $tecdocArticleIdAlt;

    /**
     * Set tecdocArticleId
     *
     * @param integer $tecdocArticleId
     *
     * @return Product
     */
    public function setTecdocArticleIdAlt($tecdocArticleIdAlt) {
        $this->tecdocArticleIdAlt = $tecdocArticleIdAlt;

        return $this;
    }

    /**
     * Get tecdocArticleId
     *
     * @return integer
     */
    public function getTecdocArticleIdAlt() {
        return $this->tecdocArticleIdAlt;
    }

    /**
     * @var string
     */
    private $itemPricer03;

    /**
     * Set itemPricer03
     *
     * @param string $itemPricer03
     *
     * @return Product
     */
    public function setItemPricer03($itemPricer03) {
        $this->itemPricer03 = $itemPricer03;

        return $this;
    }

    /**
     * Get itemPricer03
     *
     * @return string
     */
    public function getItemPricer03() {
        return $this->itemPricer03;
    }

    public function calculate($customer) {
        $softone = new Softone();
        //foreach ($order->_items_ as $item) {
        $items = array();
        $items[] = $this->reference;
        //}
        $object = "SALDOC";
        $objectArr = array();
        $objectArr[0]["TRDR"] = $customer->reference;
        $objectArr[0]["SERIESNUM"] = "00";
        $objectArr[0]["FINCODE"] = "00";
        $objectArr[0]["PAYMENT"] = 1000;
        //$objectArr[0]["TFPRMS"] = $this->tfprms;
        //$objectArr[0]["FPRMS"] = $this->fprms;
        $objectArr[0]["SERIES"] = 7021; //$this->series;
        //$objectArr[0]["DISC1PRC"] = 10;

        $dataOut[$object] = (array) $objectArr;
        $k = 9000001;
        $dataOut["ITELINES"] = array();
        $vat = 1310;
        foreach ($products as $product) {
            if ($product->reference > 0)
                $dataOut["ITELINES"][] = array("QTY1" => 1, "VAT" => $vat, "LINENUM" => $product->id, "MTRL" => $product->reference);
        }
        //echo "1";
        //print_r($dataOut);
        $locateinfo = "MTRL,NAME,PRICE,QTY1,VAT;ITELINES:DISC1PRC,ITELINES:LINEVAL,MTRL,MTRL_ITEM_CODE,MTRL_ITEM_CODE1,MTRL_ITEM_NAME,MTRL_ITEM_NAME1,PRICE,QTY1;SALDOC:BUSUNITS,EXPN,TRDR,MTRL,PRICE,QTY1,VAT";
        //echo "<pre>";
        //print_r($dataOut);

        $out = $softone->calculate((array) $dataOut, $object, "", "", $locateinfo);
    }

    function toB2b() {

        //$this->getSetting("SoftoneBundle:Softone:b2burl") == 'foxline')
        if ($this->getSetting("SoftoneBundle:Softone:b2burl") == '')
            return;
        $object = "SoftoneBundle\Entity\Product";
        $requerstUrl = $this->getSetting("SoftoneBundle:Softone:b2burl") . "antallaktika/init/setpartsbox";
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $fields = $em->getClassMetadata($object)->getFieldNames();
        $apo = array("itemPricew01", "itemPricew02", "itemPricew", "itemPricer", "reference", "itemCode", "itemCode2", "itemName", "sisxetisi", "edis");
        foreach ($fields as $field) {
            if (in_array($field, $apo)) {
                $data[$field] = $this->getField($field);
            }
        }
        $data_string = json_encode($data);

        //echo  $data_string;	
        //echo $requerstUrl;
        //urlencode
        $result = file_get_contents($requerstUrl . "?data=" . urlencode($data_string), null, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                'Content-Type: application/json' . "\r\n"
                . 'Content-Length: ' . strlen($data_string) . "\r\n",
                'content' => $data_string,
            ),
        )));
        //echo $result;
        return $this;
        //echo $result;
    }

    function toSoftone() {

        //if ($this->reference)
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $object = "ITEM";
        $softone = new Softone();
        //$fields = $softone->retrieveFields($object, $params["list"]);
        //echo $softone->appId;
        $fields[] = "item_code";
        $fields[] = "item_name";
        $fields[] = "item_code1";
        $fields[] = "item_code2";
        $fields[] = "item_name1";
        $fields[] = "item_mtrunit1";
        $fields[] = "item_pricew";
        $fields[] = "item_pricer";
        $fields[] = "item_pricew01";
        $fields[] = "item_pricer01";
        $fields[] = "item_pricew02";
        $fields[] = "item_pricew03";
        $fields[] = "item_pricer02";
        $fields[] = "item_vat";
        $fields[] = "item_mtrmanfctr";
        $fields[] = "item_mtrplace";
        $fields[] = "item_apvcode";
        $fields[] = "item_isactive";

        $fields[] = "item_mtrsup";
        $fields[] = "item_mtrcategory";
        $fields[] = "item_markupw";
        $fields[] = "item_markupr";
        $fields[] = "item_isactive";
        $fields[] = "item_mtrmark";
        $fields[] = "item_apvcode";
        $fields[] = "item_mtrplace";


        $fields[] = "item_cccfxreltdcode";
        $fields[] = "item_cccfxrelbrand";
        //print_r($fields); 
        //return;
        $objectArr = array();
        $objectArr2 = array();
        if ($this->reference > 0) {
            $data = $softone->getData($object, $this->reference);
            //print_r($data);
            $objectArr = $data->data->$object;
            $objectArr2 = (array) $objectArr[0];
        } else {
            $filters = $object . ".CODE=" . $this->itemCode . "&" . $object . ".CODE_TO=" . $this->itemCode;
            $datas = $softone->retrieveData($object, "partsbox", $filters);
            foreach ($datas as $data) {
                $data = (array) $data;
                $zoominfo = $data["zoominfo"];
                $info = explode(";", $zoominfo);
                $this->reference = $info[1];

                if ($data["MTRMANFCTR"] != $this->itemMtrmanfctr)
                    $op = true;
                if ($data["MTRMARK"] != $this->itemMtrmark)
                    $op = true;
                break;
            }
            $data = $softone->getData($object, $this->reference);
            $objectArr = $data->data->$object;
            $objectArr2 = (array) $objectArr[0];
        }

        foreach ($fields as $field) {
            $field1 = strtoupper(str_replace(strtolower($object) . "_", "", $field));
            $field2 = lcfirst($this->createName($field));
            //echo $field1." -> ".$field2 . "\n";
            @$objectArr2[$field1] = $this->$field2;
            //}
        }
        $this->itemCode2 = $this->supplierCode;
        $objectArr2["MTRUNIT1"] = 101;
        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            $objectArr2["MTRPCATEGORY"] = 1000;
            $objectArr2["MTRACN"] = 101;
            $objectArr2["CCCFXRELTDCODE"] = $this->tecdocCode;
            $objectArr2["CCCFXTDBRAND"] = $this->itemMtrmark;
            $objectArr2["CCCFXRELBRAND"] = $this->itemMtrmark;
            $objectArr2["PRICER01"] = $this->itemPricew01 * 1.24;
            $objectArr2["PRICER02"] = $this->itemPricew02 * 1.24;
            if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
                $objectArr2["PRICER01"] = $this->itemPricew01 * 1.24;
                $objectArr2["PRICER02"] = $this->itemPricew02 * 1.24;
                if ($this->tecdocSupplierId)
                    $objectArr2["CCCFXTDBRAND"] = $this->tecdocSupplierId->getId();
                $objectArr2["CCCFXRELBRAND"] = $this->itemMtrmanfctr;

                //MU21
            }
        }

        unset($objectArr2["MU21"]);
        unset($objectArr2["MU12MODE"]);
        $objectArr2["VAT"] = 1410;
        $objectArr2["CODE2"] = $this->supplierCode;
        $objectArr2["CCCREF"] = $this->cccRef;
        $objectArr2["cccRef"] = $this->cccRef;
        $objectArr2["cccPriceUpd"] = $this->cccPriceUpd;
        $objectArr2["cccWebUpd"] = $this->cccWebUpd;
        $objectArr2["REMARKS"] = $this->itemRemarks;
        $objectArr2["MTRMARK"] = $this->itemMtrmark;

        $objectArr2["CRDCARDMODE"] = "Καμιά";

        $objectArr2["MTRMANFCTR"] = $this->itemMtrmanfctr > 0 ? $this->itemMtrmanfctr : $this->getSupplierId()->getId();
        $objectArr2["ISACTIVE"] = (int) $this->itemIsactive;
        $objectArr[0] = $objectArr2;
        $dataOut[$object] = (array) $objectArr;
        @$dataOut["ITEEXTRA"][0] = array("VARCHAR02" => $this->sisxetisi);
        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            @$dataOut["ITEEXTRA"][0] = array("VARCHAR05" => $this->cccRef);
            @$dataOut["ITEEXTRA"][0] = array("BOOL01" => $this->cccWebUpd);
            @$dataOut["ITEEXTRA"][0] = array("BOOL02" => $this->cccPriceUpd);
            $objectArr2["MTRPCATEGORY"] = 1000;
            $objectArr2["MTRACN"] = 101;
        }
        //@$dataOut["ITEEXTRA"][0] = array("VARCHAR02" => $this->sisxetisi); 
        //print_r(@$dataOut);
        file_put_contents("log/productIn_" . $this->getId() . ".txt", print_r($dataOut, true));
        $out = $softone->setData((array) $dataOut, $object, (int) $this->reference);
        file_put_contents("log/productOut_" . $this->getId() . ".txt", print_r($out, true));
        //print_r($out);


        if (@$out->id > 0) {
            $op = false;
            if ($this->reference) {
                $op = true;
            }
            $this->reference = $out->id;
            $em->persist($this);
            $em->flush();
            //$this->itemMtrmark = $this->itemMtrmark > 0 ? $this->itemMtrmark : 1000;
            $this->itemMtrmanfctr = $this->itemMtrmanfctr > 0 ? $this->itemMtrmanfctr : 1000;
            $params["fSQL"] = "UPDATE MTRL SET MTRMANFCTR=" . $this->getSupplierId()->getId() . " , MTRMARK=" . $this->itemMtrmark . " WHERE MTRL = " . $this->reference;
            //echo $params["fSQL"]."\n";
            //if (!$op) {
            //if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'gianop') {
            if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'carparts') {
                //$softone->createSql($params);
                //print_r($softone->createSql($params));
            }
            //$this->toB2b();
            //print_r($softone->createSql($params));
        }
    }

    function createName($str) {
        $strArr = explode("_", $str);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        $strArr = explode(".", $b);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        return $b;
    }

    /**
     * @var string
     */
    private $itemPricew04;

    /**
     * @var string
     */
    private $itemPricew05;

    /**
     * @var string
     */
    private $itemPricer04;

    /**
     * @var string
     */
    private $itemPricer05;

    /**
     * @var string
     */
    private $purlprice = 0;

    /**
     * Set itemPricew04
     *
     * @param string $itemPricew04
     *
     * @return Product
     */
    public function setPurlprice($purlprice) {
        $this->purlprice = $purlprice;
        return $this;
    }

    public function getPurlprice() {
        return $this->purlprice;
    }

    /**
     * @var string
     */
    private $cost = 0;

    /**
     * Set itemPricew04
     *
     * @param string $itemPricew04
     *
     * @return Product
     */
    public function setCost($cost) {
        $this->cost = $cost;
        return $this;
    }

    public function getCost() {
        return $this->cost;
    }

    /**
     * Set itemPricew04
     *
     * @param string $itemPricew04
     *
     * @return Product
     */
    public function setItemPricew04($itemPricew04) {
        $this->itemPricew04 = $itemPricew04;

        return $this;
    }

    /**
     * Get itemPricew04
     *
     * @return string
     */
    public function getItemPricew04() {
        return $this->itemPricew04;
    }

    /**
     * Set itemPricew05
     *
     * @param string $itemPricew05
     *
     * @return Product
     */
    public function setItemPricew05($itemPricew05) {
        $this->itemPricew05 = $itemPricew05;

        return $this;
    }

    /**
     * Get itemPricew05
     *
     * @return string
     */
    public function getItemPricew05() {
        return $this->itemPricew05;
    }

    /**
     * Set itemPricer04
     *
     * @param string $itemPricer04
     *
     * @return Product
     */
    public function setItemPricer04($itemPricer04) {
        $this->itemPricer04 = $itemPricer04;

        return $this;
    }

    /**
     * Get itemPricer04
     *
     * @return string
     */
    public function getItemPricer04() {
        return $this->itemPricer04;
    }

    /**
     * Set itemPricer05
     *
     * @param string $itemPricer05
     *
     * @return Product
     */
    public function setItemPricer05($itemPricer05) {
        $this->itemPricer05 = $itemPricer05;

        return $this;
    }

    /**
     * Get itemPricer05
     *
     * @return string
     */
    public function getItemPricer05() {
        return $this->itemPricer05;
    }

    /**
     * @var integer
     */
    private $itemMtrmark;

    /**
     * @var string
     */
    private $itemApvcode;

    /**
     * @var integer
     */
    private $itemMtrgroup;

    /**
     * Set itemMtrmark
     *
     * @param integer $itemMtrmark
     *
     * @return Product
     */
    public function setItemMtrmark($itemMtrmark) {
        $this->itemMtrmark = $itemMtrmark;

        return $this;
    }

    /**
     * Get itemMtrmark
     *
     * @return integer
     */
    public function getItemMtrmark() {
        return $this->itemMtrmark;
    }

    /**
     * Set itemApvcode
     *
     * @param string $itemApvcode
     *
     * @return Product
     */
    public function setItemApvcode($itemApvcode) {
        $this->itemApvcode = $itemApvcode;

        return $this;
    }

    /**
     * Get itemApvcode
     *
     * @return string
     */
    public function getItemApvcode() {
        return $this->itemApvcode;
    }

    /**
     * Set itemMtrgroup
     *
     * @param integer $itemMtrgroup
     *
     * @return Product
     */
    public function setItemMtrgroup($itemMtrgroup) {
        $this->itemMtrgroup = $itemMtrgroup;

        return $this;
    }

    /**
     * Get itemMtrgroup
     *
     * @return integer
     */
    public function getItemMtrgroup() {
        return $this->itemMtrgroup;
    }

    /**
     * Set tecdocSupplierId
     *
     * @param \SoftoneBundle\Entity\TecdocSupplier $tecdocSupplierId
     *
     * @return Product
     */
    public function setTecdocSupplierId(\SoftoneBundle\Entity\TecdocSupplier $tecdocSupplierId = null) {
        $this->tecdocSupplierId = $tecdocSupplierId;
        return $this;
    }

    /**
     * Get tecdocSupplierId
     *
     * @return \SoftoneBundle\Entity\TecdocSupplier
     */
    public function getTecdocSupplierId() {
        return $this->tecdocSupplierId;
    }

    /**
     * @var \SoftoneBundle\Entity\SoftoneSupplier
     */
    private $supplierId;

    /**
     * Set supplierId
     *
     * @param \SoftoneBundle\Entity\SoftoneSupplier $supplierId
     *
     * @return Product
     */
    public function setSupplierId(\SoftoneBundle\Entity\SoftoneSupplier $supplierId = null) {
        $this->supplierId = $supplierId;

        return $this;
    }

    /**
     * Get supplierId
     *
     * @return \SoftoneBundle\Entity\SoftoneSupplier
     */
    public function getSupplierId() {
        return $this->supplierId;
    }

    /**
     * @var string
     */
    private $itemMarkupr;

    /**
     * Set itemMarkupr
     *
     * @param string $itemMarkupr
     *
     * @return Product
     */
    public function setItemMarkupr($itemMarkupr) {
        $this->itemMarkupr = $itemMarkupr;

        return $this;
    }

    /**
     * Get itemMarkupr
     *
     * @return string
     */
    public function getItemMarkupr() {
        return $this->itemMarkupr;
    }

    function setProductFreesearch() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        if ($this->getSupplierId())
            $this->erpSupplier = $this->getSupplierId()->getTitle();

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

        $edis = (array) explode(",", $this->edis);
        foreach ($edis as $edi) {
            $dataindexarr[] = $edi;
            $dataindexarrs[] = $edi;
            $dataindexarr[] = $this->greeklish($edi);
            $dataindexarrs[] = $this->greeklish($edi);
        }
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

        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
            $this->itemRemarks = str_replace("\n", "|", $this->itemRemarks);
            $this->itemRemarks = str_replace("\r", "|", $this->itemRemarks);
            $this->itemRemarks = str_replace("||", "|", $this->itemRemarks);

            $remarks = explode("|", str_replace("\n", "|", $this->itemRemarks));
            foreach ((array) $remarks as $remark) {
                $dataindexarr[] = $remark;
                $dataindexarr[] = $this->greeklish($remark);
            }
            //echo "<BR>";
            //print_r($dataindexarr);
            //echo "<BR>";
        }

        $data_index = array_filter(array_unique($dataindexarr));

        $data_indexs = array_filter(array_unique($dataindexarrs));
        $dataindex = addslashes(implode("|", $data_index));

        $dataindexs = addslashes(implode("|", $data_indexs));
        $sql = "replace softone_product_freesearch set id = '" . $this->id . "', data_index='" . $dataindex . "'";
        $em->getConnection()->exec($sql);
        $sql = "replace softone_product_search set id = '" . $this->id . "',gnisia='',search='" . $dataindexs . "' ,item_code='" . $this->itemCode . "',item_code1='" . $this->itemCode1 . "',item_code2='" . $this->supplierCode . "'";
        $em->getConnection()->exec($sql);
    }

    /**
     * @var string
     */
    private $edis;

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

    function getGroupedPrice(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        return number_format($this->$pricefield * $vat, 2, '.', '');
    }

    function getGroupedDiscountPrice(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
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
        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        $price = $price > 0 ? $price : $this->$pricefield;
        $discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        $finalprice = $discount > 0 ? $discountedPrice : $price;

        return number_format($finalprice * $vat, 2, '.', '');
    }

    function getGroupedDiscount(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
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
        //$pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        //$price = $price > 0 ? $price : $this->$pricefield;
        //$discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        //$finalprice = $discount > 0 ? $discountedPrice : $price;
        return (float) $discount;
        //return number_format($price * $vat, 2, '.', '') . " (" . (float) $discount . "%)";
    }

    function getDiscount(\SoftoneBundle\Entity\Customer $customer, $vat = 1) {
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

        $pricefield = $customer->getPriceField() ? $customer->getPriceField() : "itemPricew";
        $price = $price > 0 ? $price : $this->$pricefield;
        $discountedPrice = $this->$pricefield * (1 - $discount / 100 );
        //$finalprice = $discount > 0 ? $discountedPrice : $price;

        return number_format($price * $vat, 2, '.', '') . " (" . (float) $discount . "%)";
    }

    function getEdiPrices($orderid = 0) {
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") != 'tsakonas')
            return;


        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $entity = $em
                ->getRepository('EdiBundle:Edi')
                ->find(6);

        if (@!$datas[$entity->getId()][$k]) {
            $datas[$entity->getId()][$k]['ApiToken'] = $entity->getToken();
            $datas[$entity->getId()][$k]['Items'] = array();
        }
        $Items[$entity->getId()][$k]["PartNo"] = $this->getItemCode2();
        $Items[$entity->getId()][$k]["ReqQty"] = 1;
        $Items[$entity->getId()][$k]["BrandName"] = "GBG";
        $datas[$entity->getId()][$k]['Items'][] = $Items[$entity->getId()][$k];

        $ands[$this->getItemCode2()] = $key;
        $entities[$this->getItemCode2()] = $entity;

        $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';
        foreach ($datas as $catalogue => $packs) {
            foreach ($packs as $k => $data) {
                $data_string = json_encode($data);
                //echo $data_string;
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
                        $qty = $Item->Availability == 'green' ? 100 : 0;
                        $Item->UnitPrice;
                        $itemcode = $Item->ItemCode;
                        $price[$itemcode] = $Item->ListPrice;
                        $availability[$itemcode] = $Item->Availability;
                        break;
                    }
                }
            }
        }


        $sql = "Select a.*, b.name from partsbox_db.edi_item a, edi b where a.edi = b.id and (a.itemcode =  '" . $itemcode . "' OR  a.itemcode =  '" . $this->cccRef . "' OR a.partno =  '" . $this->itemCode1 . "' OR a.partno =  '" . $this->itemCode2 . "')";

        //echo $sql;

        $connection = $em->getConnection();
        $statement = $connection->prepare($sql);
        $statement->execute();
        $results = $statement->fetchAll();
        if ($results) {

            $out = '<div class="orderitemstable style-primary-light" style="width:800px; margin-top: -10px;">
            <table class="table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Code</td>
                    <td>Title</td>
                    <td>Qty</td>
                    <td>Price</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>';
            foreach ($results as $data) {

                $entity = $em
                        ->getRepository("EdiBundle:EdiItem")
                        ->find($data["id"]);
                $entity->getEdiQtyAvailability();
                $pricef = $price[$data["itemcode"]] > 0 ? $price[$data["itemcode"]] : $data["wholesaleprice"];

                if ($data["edi"] == 11) {



                    //$availabilityf = $availability[$data["itemcode"]] != '' ? $availability[$data["itemcode"]] : $entity->getEdiQtyAvailability();
                    //$availabilityf = $availabilityf == 'green' OR $availabilityf == 1 ? "YES" : "NO";
                    // 

                    $out .= '<tr>
                                <td>' . $data["name"] . ' (ΚΑΡΠΟΥ)</td>
                                <td>' . $data["itemcode"] . '</td>
                                <td>' . $data["description"] . '</td>
                                <td>' . ($data["gbg1"] > 0 ? "YES" : "NO") . '</td>
                                <td>' . $pricef . '</td>
                                <td style="width:150px"><input type="text" data-order="' . $orderid . '" data-price="' . $pricef . '" data-id="' . $data['id'] . '" name="qty1_' . $data['id'] . '" value="0" size="2" id="qty1_' . $data['id'] . '" class="ediiteqty1"> <div class="SoftoneBundleGBGProductAdd" data-price="' . $pricef . '" data-qty="qty1" data-id="' . $data['id'] . '" style="width: 50%; float: right;"><div style="position: relative" class="gui-icon"><i class="md md-shopping-cart"></i><span class="title"><a target="_blank" href="#"></a></span></div></div> </td>    
                            </tr>';
                    $out .= '<tr>
                                <td>' . $data["name"] . ' (ΚΟΡΩΠΙ)</td>
                                <td>' . $data["itemcode"] . '</td>
                                <td>' . $data["description"] . '</td>
                                <td>' . ($data["gbg2"] > 0 ? "YES" : "NO") . '</td>
                                <td>' . $pricef . '</td>
                                <td style="width:150px"><input type="text" data-order="' . $orderid . '" data-price="' . $pricef . '" data-id="' . $data['id'] . '" name="qty2_' . $data['id'] . '" value="0" size="2" id="qty2_' . $data['id'] . '" class="ediiteqty1"> <div class="SoftoneBundleGBGProductAdd" data-price="' . $pricef . '" data-qty="qty2" data-id="' . $data['id'] . '" style="width: 50%; float: right;"><div style="position: relative" class="gui-icon"><i class="md md-shopping-cart"></i><span class="title"><a target="_blank" href="#"></a></span></div></div> </td>    
                            </tr>';
                    $out .= '<tr>
                                <td>' . $data["name"] . ' (ΛΙΟΣΙΩΝ)</td>
                                <td>' . $data["itemcode"] . '</td>
                                <td>' . $data["description"] . '</td>
                                <td>' . ($data["gbg3"] > 0 ? "YES" : "NO") . '</td>
                                <td>' . $pricef . '</td>
                                <td style="width:150px"><input type="text" data-order="' . $orderid . '" data-price="' . $pricef . '" data-id="' . $data['id'] . '" name="qty3_' . $data['id'] . '" value="0" size="2" id="qty3_' . $data['id'] . '" class="ediiteqty1"> <div class="SoftoneBundleGBGProductAdd" data-price="' . $pricef . '" data-qty="qty3" data-id="' . $data['id'] . '" style="width: 50%; float: right;"><div style="position: relative" class="gui-icon"><i class="md md-shopping-cart"></i><span class="title"><a target="_blank" href="#"></a></span></div></div></td>    
                            </tr>';
                } else {

                    $availabilityf = $availability[$data["itemcode"]] != '' ? $availability[$data["itemcode"]] : $entity->getEdiQtyAvailability();
                    //$availabilityf = $availabilityf == 'green' OR $availabilityf == 1 ? "YES" : "NO";
                    $out .= '<tr>
                            <td>' . $data["name"] . '</td>
                            <td>' . $data["itemcode"] . '</td>
                            <td>' . $data["description"] . '</td>
                            <td>' . $availabilityf . '</td>
                            <td>' . $pricef . '</td>
                            <td  style="width:150px"><input type="text" data-id="' . $data['id'] . '" name="qty1_' . $data['id'] . '" value="0" size="2" id="qty1_' . $data['id'] . '" class="ediiteqty1"> <div class="SoftoneBundleGBGProductAdd" data-qty="qty3" data-id="' . $data['id'] . '" style="width: 50%; float: right;"><div style="position: relative" class="gui-icon"><i class="md md-shopping-cart"></i><span class="title"><a target="_blank" href="#"></a></span></div></div></td>    
                        </tr>';
                }
            }
            $out .= '</tbody>
            </table>

            </div>';
            return $out;
        }
    }

    public function getFanoImageUrl($ext = 'jpg') {
        return $this->getSetting("SoftoneBundle:Product:Images") . "Photos/Parts/" . substr($this->itemCode2, 0, 4) . "/" . $this->itemCode2 . "." . $ext;
    }

    public function getForOrderImage() {

        $url = $this->getFanoImageUrl();
        if (!file_exists($url)) {
            $url = $this->getFanoImageUrl("JPG");
        }
        if (file_exists($url)) {
            $urlpath = str_replace("/home2/partsbox/public_html/partsbox/web", "", $url);
            return '<div style="display:none; position: absolute;" class="productfanoimg productfanoimg_' . $this->id . '"><img width=300 src="' . $urlpath . '" /></div>';
        }
    }

    public function getForOrderCode() {


        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'tsakonas') {
            $out = '<a title="' . $this->title . '" class="productfano_info" car="" data-articleId="' . $this->tecdocArticleId . '" data-ref="' . $this->id . '" href="#">' . $this->erpCode . '</a>
        <div class="ediprices ediprices_' . $this->id . '"></div>
        <br>
        <span class="text-sm text-info">' . $this->erpCode . '</span>';
        } else {
            $out = '<a title="' . $this->title . '" class="product_info" car="" data-articleId="' . $this->tecdocArticleId . '" data-ref="' . $this->id . '" href="#">' . $this->erpCode . '</a>
        <div class="ediprices ediprices_' . $this->id . '"></div>
        <br>
        <span class="text-sm text-info">' . $this->erpCode . '</span>';
        }
        $out .= $this->getForOrderImage();
        return $out;
    }

    public function getForOrderTitle() {


        $out = '<div style="width:400px;"><a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/product/view/' . $this->id . '">' . $this->title . '</a>
        <br>
        <span class="text-sm tecdocArticleName text-info">' . $this->tecdocArticleName . '</span></div>';

        return $out;
    }

    public function getEditLink() {
        $out = '<a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/product/view/' . $this->id . '">Edit</a>';
        return $out;
    }

    public function getForOrderSupplier($order = 0) {
        $order = (int) $order;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        if ($order > 0) {
            $sql11 = "select name from edi where id in (select edi from edi_order where id in (select ediorder from edi_order_item where porder = '" . $order . "' AND  ediitem in (SELECT id FROM partsbox_db.edi_item where edi = 11 AND replace(replace(replace(replace(`partno`, '/', ''), '.', ''), '-', ''), ' ', '') LIKE '" . $this->getItemCode2() . "')))";
            $connection = $em->getConnection();
            $statement = $connection->prepare($sql11);
            $statement->execute();
            $edi = $statement->fetch();
            //print_r($part);
        }

        $ti = $this->getSupplierId() ? $this->getSupplierId()->getTitle() : "";
        if ($edi["name"]) {
            $ti .= " (" . $edi["name"] . ")";
        }
        if ($this->tecdocArticleId == 0) {
            $out = '<a title="' . $ti . '"  class="forordersupplier" car="" data-articleId="' . $this->tecdocArticleId . '" data-order="' . $order . '" data-ref="' . $this->id . '">' . $ti . '</a>';
            return $out;
        }
        @$tecdoc = $this->getTecdocSupplierId() ? $this->getTecdocSupplierId()->getSupplier() : "";
        $out = '<a title="' . $ti . '"  class="forordersupplier" car="" data-articleId="' . $this->tecdocArticleId . '" data-order="' . $order . '" data-ref="' . $this->id . '">' . $ti . '</a>
        <br>
        <span class="text-sm text-info">' . $tecdoc . '</span>';
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'kanteres') {
            return $out;
        } else {
            return $out;
        }
    }

    function getArticleAttributes() {
        //return "";
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };
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

        if ($this->getSetting("AppBundle:Entity:newTecdocServiceUrl") != '') {
            return $this->getCriteria($linkingTargetId);
        }
        $tecdoc = new Tecdoc();
        if ($this->getSetting("AppBundle:Entity:lng") > 0) {
            $tecdoc->setLng($this->getSetting("AppBundle:Entity:lng"));
        };
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

    function getCriteria($brandmodeltype = 0) {


        if ($this->tecdocArticleId == 0 AND $this->tecdocArticleIdAlt == 0)
            return;
        //echo 'sss';
        if ($this->tecdocArticleId > 0) {

            $criterias2 = array();
            if ($brandmodeltype) {
                $sql = "select * from 
				magento2_base4q2017.la_criteria, 
				magento2_base4q2017.link_la_typ,
				magento2_base4q2017.criteria,
				umagento2_base4q2017.text_designations,
				magento2_base4q2017.la_crit_group 
				where 
				lac_la_id = lac_gr_la_id and 
				cri_id = lac_cri_id and 
				lac_gr_id = lat_lac_gr_id and
				des_id = cri_des_id and 
				(des_lng_id = '" . $this->lng . "' OR des_lng_id = 4) AND
				des_text != '' AND
				lat_typ_id = '" . $brandmodeltype . "' AND 
				lat_art_id = '" . $this->tecdocArticleId . "' order by des_lng_id";
                //$criterias = $this->connection->fetchAll($sql);	
                //$result = mysqli_query($this->conn,$sql);
                //$criterias =  mysqli_fetch_all($result,MYSQLI_ASSOC);					
                $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                $criterias = unserialize(file_get_contents($url));
                //echo $sql;
                //$criterias2 = array();
                //echo "<pre>";
                //print_r($criterias);
                //echo "</pre>";
                foreach ((array) $criterias as $criteria) {
                    if ($criteria["des_text"] == '')
                        continue;
                    if ($criteria["lac_value"]) {
                        $criteria2["value"] = $criteria["lac_value"];
                        //$criteria2["cri_id"] = $criteria["lac_cri_id"];						
                        //$criterias2[$criteria2["cri_id"]] = $criteria2;
                    } else {
                        $sql = "select des_text from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["lac_kv_kt_id"] . "' AND kv_kv = '" . $criteria["lac_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";
                        //$kv = $this->connection->fetchOne($sql);
                        $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                        $kv_kv = unserialize(file_get_contents($url));
                        $kv_kv = $kv_kv[0];
                        $kv = $kv_kv["des_text"]; // kv_kv HA VA							
                        if ($kv == "") {
                            $sql = "select * from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["lac_kv_kt_id"] . "' AND kv_kv = '" . $criteria["lac_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";
                            //$sql = "select des_text from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '".$criteria["acr_kv_kt_id"]."' AND kv_kv = '".$criteria["acr_kv_kv"]."' AND des_id = kv_des_id and des_lng_id = '4' ";
                            //echo $sql;
                            //$kvrow = $this->connection->fetchRow($sql);		
                            //print_r($kvrow);
                        }
                        $criteria2["value"] = $kv;
                    }
                    //$criteria2["cri_id"] = "(".$criteria["lac_cri_id"].")";
                    $criteria2["name"] = $criteria["des_text"];
                    $criteria2["cri_id"] = $criteria["lac_cri_id"];
                    $criterias2[$criteria2["cri_id"]] = $criteria2;
                }
            }

            //echo "[".$this->tecdocArticleId."]";
            $sql = "select * from magento2_base4q2017.article_criteria, magento2_base4q2017.criteria, magento2_base4q2017.text_designations
				where cri_id = acr_cri_id AND des_id = cri_des_id and (des_lng_id = '" . $this->lng . "' OR des_lng_id = 4) and acr_art_id = '" . $this->tecdocArticleId . "' AND des_text != '' order by des_lng_id";
            //echo $sql;
            //$criterias = $this->connection->fetchAll($sql);	
            //$result = mysqli_query($this->conn,$sql);
            //$criterias =  mysqli_fetch_all($result,MYSQLI_ASSOC);	
            //echo $sql."<BR>";
            $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
            //echo $sql;
            $criterias = unserialize(file_get_contents($url));
            //echo "<PRE>";
            //print_r($criterias);
            //echo "</PRE>";
            $out = "<ul style='width:300px; max-height: 100px; overflow: hidden; list-style:none; padding:0px;'>";
            foreach ($criterias as $criteria) {
                //if ($criteria["des_text"] == '') continue;
                if ($criteria["acr_value"] AND $criteria["des_text"]) {
                    //$out .= "<li><b>".$criteria["des_text"]."</b>: ".$criteria["acr_value"]."</li>";
                    $criteria2["name"] = $criteria["des_text"];
                    $criteria2["value"] = $criteria["acr_value"];
                    $criteria2["cri_id"] = $criteria["acr_cri_id"];
                    $criterias2[$criteria2["cri_id"]] = $criteria2;
                } else if ($criteria["acr_kv_kt_id"] AND $criteria["acr_kv_kv"]) {
                    $sql = "select des_text from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '" . $criteria["acr_kv_kt_id"] . "' AND kv_kv = '" . $criteria["acr_kv_kv"] . "' AND des_id = kv_des_id and des_lng_id = '" . $this->lng . "' ";

                    //echo "<BR>".$sql."<BR>";
                    //$kv = $this->connection->fetchOne($sql);
                    $url = "http://magento2.fastwebltd.com/service.php?sql=" . base64_encode($sql);
                    $kv_kv = unserialize(file_get_contents($url));
                    //echo "<PRE>----";
                    //print_r($kv_kv);
                    //echo "-----</PRE>";					
                    $kv_kv = $kv_kv[0];
                    $kv = $kv_kv["des_text"]; // kv_kv HA VA	
                    //$kv = $kv_kv["des_text"]; // kv_kv HA VA
                    //$sql = "select * from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '".$criteria["acr_kv_kt_id"]."' AND kv_kv = '".$criteria["acr_kv_kv"]."' AND des_id = kv_des_id and des_lng_id = '".$this->lng."' ";
                    //$kvrow = $this->connection->fetchRow($sql);
                    //$sql = "select * from magento2_base4q2017.key_values, magento2_base4q2017.text_designations where kv_kt_id = '".$criteria["acr_kv_kt_id"]."' AND kv_kv = '".$criteria["acr_kv_kv"]."' AND des_id = kv_des_id and des_lng_id = '".$this->lng."' ";
                    //$kvrow = $this->connection->fetchRow($sql);	
                    //print_r($kvrow);
                    //if (!$criteria["des_text"]) continue;
                    //$out .= "<li><b>".$criteria["des_text"]."</b>: ".$kv."</li>";
                    $criteria2["name"] = $criteria["des_text"];
                    $criteria2["value"] = $kv;
                    $criteria2["cri_id"] = $criteria["acr_cri_id"];
                    $criterias2[$criteria2["cri_id"]] = $criteria2;
                } else {
                    //$out .= "<li>".print_r($criteria,true)."</li>";
                }
            }
            //echo "<pre>";
            //print_r($criterias2);
            //echo "</pre>";			
            foreach ($criterias2 as $criteria) {
                //if (!$criteria["name"]) continue;
                //if (!$criteria["value"]) continue;
                if ($criteria["cri_id"] == 20 OR $criteria["cri_id"] == 21)
                    $criteria["value"] = str_replace(".", "/", $criteria["value"]);
                //$out .= "<li><b>".$criteria["name"]." [".$criteria["cri_id"]."]</b>:: ".mb_convert_case($criteria["value"], MB_CASE_TITLE, "UTF-8")."</li>";
                //$out .= "<li><b>".mb_convert_case($criteria["name"], MB_CASE_TITLE, "UTF-8")."</b>: ".mb_convert_case($criteria["value"], MB_CASE_TITLE, "UTF-8")."</li>";
                $out .= "<li><b>" . $criteria["name"] . "</b>: " . $criteria["value"] . "</li>";
            }
            $out .= "<ul>";
            //print_r($criterias);
            return $out;
        } elseif ($this->tecdocArticleIdAlt > 0) {
            $url = "http://service5.fastwebltd.com/";
            $fields = array(
                'action' => 'articleAttributesRow',
                'tecdoc_article_id' => $this->tecdocArticleIdAlt,
                'linkingTargetId' => $brandmodeltype,
            );
            //print_r($fields);
            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $criterias = unserialize(curl_exec($ch));
            $out = "<ul style='list-style:none; padding:0px;'>";
            foreach ($criterias as $criteria) {
                //$out .= "<li><b>".mb_convert_case($criteria->attrName, MB_CASE_TITLE, "UTF-8")."</b>: ".mb_convert_case($criteria->attrValue, MB_CASE_TITLE, "UTF-8")."</li>";
                $out .= "<li><b>" . $criteria->attrName . "</b>: " . $criteria->attrValue . "</li>";
            }
            $out .= "<ul>";
            //print_r($criterias);
            return $out;
            //print_r($criterias);
        }
    }

    public function media() {

        //$product = json_decode($this->flat_data);
        if ($this->tecdocArticleId == "")
            return;

        if ($this->media != "")
            return $this->media;


        $url = "http://service5.fastwebltd.com/";
        $fields = array(
            'action' => 'media',
            'tecdoc_article_id' => $this->tecdocArticleId
        );

        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $data = curl_exec($ch);
        //$this->media = $data;
        //$this->save();
        return $data;
    }

    function getApothiki() {
        if ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'foxline') {
            return $this->edis;
        } elseif ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'mpalantinakis') {
            return $this->edis;
        } elseif ($this->getSetting("SoftoneBundle:Softone:apothiki") == 'tsakonas') {
            $qty = $this->qty - $this->reserved;
            return $this->gbg . ' / ' . $this->qty . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty) . '</span> (' . $this->itemMtrplace . ")";
        } else {
            $qty = $this->qty - $this->reserved;
            return $this->qty . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty) . '</span> (' . $this->itemMtrplace . ")";
        }
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
     * @var string
     */
    private $itemRemarks;

    /**
     * Set itemRemarks
     *
     * @param string $itemRemarks
     *
     * @return Product
     */
    public function setItemRemarks($itemRemarks) {
        $this->itemRemarks = $itemRemarks;

        return $this;
    }

    /**
     * Get itemRemarks
     *
     * @return string
     */
    public function getItemRemarks() {
        return $this->itemRemarks;
    }

    /**
     * @var integer
     */
    var $reference;

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
     * @var \SoftoneBundle\Entity\ProductSale
     */
    private $productSale;

    /**
     * Set productSale
     *
     * @param \SoftoneBundle\Entity\ProductSale $productSale
     *
     * @return Product
     */
    public function setProductSale(\SoftoneBundle\Entity\ProductSale $productSale = null) {
        $this->productSale = $productSale;

        return $this;
    }

    /**
     * Get productSale
     *
     * @return \SoftoneBundle\Entity\ProductSale
     */
    public function getProductSale() {
        return $this->productSale;
    }

    /**
     * @var string
     */
    private $sisxetisi = '';

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
     * @var boolean
     */
    private $cccPriceUpd = '0';

    /**
     * @var boolean
     */
    private $cccWebUpd = '1';

    /**
     * Set cccPriceUpd
     *
     * @param boolean $cccPriceUpd
     *
     * @return Product
     */
    public function setCccPriceUpd($cccPriceUpd) {
        $this->cccPriceUpd = $cccPriceUpd;

        return $this;
    }

    /**
     * Get cccPriceUpd
     *
     * @return boolean
     */
    public function getCccPriceUpd() {
        return $this->cccPriceUpd;
    }

    /**
     * Set cccWebUpd
     *
     * @param boolean $cccWebUpd
     *
     * @return Product
     */
    public function setCccWebUpd($cccWebUpd) {
        $this->cccWebUpd = $cccWebUpd;

        return $this;
    }

    /**
     * Get cccWebUpd
     *
     * @return boolean
     */
    public function getCccWebUpd() {
        return $this->cccWebUpd;
    }

    private $gbg = '0';

    /**
     * Set gbg
     *
     * @param integer $gbg
     *
     * @return Product
     */
    public function setGbg($gbg) {
        $this->gbg = $gbg;

        return $this;
    }

    /**
     * Get gbg
     *
     * @return integer
     */
    public function getGbg() {
        return $this->gbg;
    }

    /**
     * @var integer
     */
    private $reserved = '0';
    private $qty = '0';

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
     * @var string
     */
    private $nosync = '';

    /**
     * Set nosync
     *
     * @param string $nosync
     *
     * @return Product
     */
    public function setNosync($nosync) {
        $this->cccRef = $nosync;

        return $this;
    }

    /**
     * Get nosync
     *
     * @return string
     */
    public function getNosync() {
        return $this->nosync;
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
     * @var string
     */
    private $cccRef = '';

    /**
     * @var \SoftoneBundle\Entity\Supplier
     */
    private $mtrsup;

    /**
     * Set cccRef
     *
     * @param string $cccRef
     *
     * @return Product
     */
    public function setCccRef($cccRef) {
        $this->cccRef = $cccRef;

        return $this;
    }

    /**
     * Get cccRef
     *
     * @return string
     */
    public function getCccRef() {
        return $this->cccRef;
    }

    /**
     * Set mtrsup
     *
     * @param \SoftoneBundle\Entity\Supplier $mtrsup
     *
     * @return Product
     */
    public function setMtrsup(\SoftoneBundle\Entity\Supplier $mtrsup = null) {
        $this->mtrsup = $mtrsup;

        return $this;
    }

    /**
     * Get mtrsup
     *
     * @return \SoftoneBundle\Entity\Supplier
     */
    public function getMtrsup() {
        return $this->mtrsup;
    }

    function priceCarparts($vat = 1) {
        $pricer1 = number_format($this->getPurlprice() * $vat, 2, '.', '');
        $pricer2 = number_format($this->getCost() * $vat, 2, '.', '');
        $pricer = $pricer1 . " / " . $pricer2;
        return $pricer;
    }

    function priceEshop($vat = 1) {
        $pricer1 = number_format($this->getItemPricew02() * $vat, 2, '.', '');
        $pricer2 = number_format($this->getItemPricew04() * $vat, 2, '.', '');
        $pricer = $pricer1 . " / " . $pricer2;
        return $pricer;
    }

    function priceMpal($vat = 1) {
        $pricer1 = number_format($this->getItemPricew01() * $vat, 2, '.', '');
        $pricer = $pricer1;
        return $pricer;
    }

    function getHistory() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $orderItems = $em->getRepository("SoftoneBundle:Orderitem")
                ->findBy(array("product" => $this), array('id' => 'desc'));
        return $orderItems;
    }

}
