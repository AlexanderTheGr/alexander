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
                $sql = "update `softone_product` set tecdoc_generic_article_id = '" . $out->genericArticleId . "', tecdoc_article_name = '" . $out->articleName . "', tecdoc_article_id = '" . $out->articleId . "', cars = '" . serialize($cars) . "', cats = '" . serialize($categories) . "' where id = '" . $this->id . "'";
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
				
				if ($data["MTRMANFCTR"]!=$this->itemMtrmanfctr) $op = true;
				if ($data["MTRMARK"]!=$this->itemMtrmark) $op = true;
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
        $objectArr2["MTRUNIT1"] = 101;
        $objectArr2["VAT"] = 1410;
        $objectArr2["CODE2"] = $this->supplierCode;
        
        $objectArr2["REMARKS"] = $this->itemRemarks;
        $objectArr2["MTRMARK"] = $this->itemMtrmark;
        $objectArr2["MTRMANFCTR"] = $this->itemMtrmanfctr > 0 ? $this->itemMtrmanfctr : $this->getSupplierId()->getId();
        $objectArr2["ISACTIVE"] = (int)$this->itemIsactive;
        $objectArr[0] = $objectArr2;
        $dataOut[$object] = (array) $objectArr;
        
        
        
        
        if ($this->getSetting("SoftoneBundle:Softone:merchant") == 'foxline') {
            @$dataOut["ITEEXTRA"][0] = array("varchar05" => $this->sisxetisi,"VARCHAR02" => $this->sisxetisi);
        } else {
            $objectArr2["CCCREF"] = $this->cccRef;  
            @$dataOut["ITEEXTRA"][0] = array("VARCHAR02" => $this->sisxetisi);
        }
        //print_r(@$dataOut);

        $out = $softone->setData((array) $dataOut, $object, (int) $this->reference);
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
			if (!$op) {
				$softone->createSql($params);
			}
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
        $sql = "replace softone_product_freesearch set id = '" . $this->id . "', data_index='" . $dataindex . "'";
        $em->getConnection()->exec($sql);
        $sql = "replace softone_product_search set id = '" . $this->id . "',item_code='" . $this->itemCode . "',item_code1='" . $this->itemCode1 . "',item_code2='" . $this->supplierCode . "'";
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

    public function getForOrderCode() {

        $out = '<a title="' . $this->title . '" class="product_info" car="" data-articleId="' . $this->tecdocArticleId . '" data-ref="' . $this->id . '" href="#">' . $this->erpCode . '</a>
        <br>
        <span class="text-sm text-info">' . $this->erpCode . '</span>';

        return $out;
    }

    public function getForOrderTitle() {


        $out = '<a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/product/view/' . $this->id . '">' . $this->title . '</a>
        <br>
        <span class="text-sm tecdocArticleName text-info">' . $this->tecdocArticleName . '</span>';

        return $out;
    }

    
    public function getEditLink() {
        $out = '<a target="_blank" title="' . $this->title . '" class="" car="" data-articleId="' . $this->tecdocArticleId . '" ref="' . $this->id . '" href="/product/view/' . $this->id . '">Edit</a>';
        return $out;
    }
    
    public function getForOrderSupplier() {


        $tecdoc = $this->getTecdocSupplierId() ? $this->getTecdocSupplierId()->getSupplier() : "";
        $ti = $this->getSupplierId() ? $this->getSupplierId()->getTitle() : "";

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
        $qty = $this->qty - $this->reserved;
        return $this->qty . ' / <span class="text-lg text-bold text-accent-dark">' . ($qty) . '</span> (' . $this->itemMtrplace . ")";
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

}