<?php

namespace MegasoftBundle\Entity;

/**
 * Product
 */
class Product {

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
    public function setTecdocSupplierId(\MegasoftBundle\Entity\TecdocSupplier $tecdocSupplierId = null)
    {
        $this->tecdocSupplierId = $tecdocSupplierId;

        return $this;
    }

    /**
     * Get tecdocSupplierId
     *
     * @return \MegasoftBundle\Entity\TecdocSupplier
     */
    public function getTecdocSupplierId()
    {
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
    public function setProductSale(\MegasoftBundle\Entity\ProductSale $productSale = null)
    {
        $this->productSale = $productSale;

        return $this;
    }

    /**
     * Get productSale
     *
     * @return \MegasoftBundle\Entity\ProductSale
     */
    public function getProductSale()
    {
        return $this->productSale;
    }
}
