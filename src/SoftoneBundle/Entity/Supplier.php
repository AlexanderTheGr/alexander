<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supplier
 *
 * @ORM\Table(name="supplier", indexes={@ORM\Index(name="reference", columns={"reference"})})
 * @ORM\Entity
 */
class Supplier {

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
    protected $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_code", type="string", length=255, nullable=false)
     */
    protected $supplierCode;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_trdr_supfindata_lbal", type="string", length=255, nullable=false)
     */
    protected $supplierTrdrSupfindataLbal;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_name", type="string", length=255, nullable=false)
     */
    protected $supplierName;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_afm", type="string", length=255, nullable=false)
     */
    protected $supplierAfm;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_address", type="string", length=255, nullable=false)
     */
    protected $supplierAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_district", type="string", length=255, nullable=false)
     */
    protected $supplierDistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_zip", type="string", length=255, nullable=false)
     */
    protected $supplierZip;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_city", type="string", length=255, nullable=false)
     */
    protected $supplierCity;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_phone01", type="string", length=255, nullable=false)
     */
    protected $supplierPhone01;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_phone02", type="string", length=255, nullable=false)
     */
    protected $supplierPhone02;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_fax", type="string", length=255, nullable=false)
     */
    protected $supplierFax;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_webpage", type="string", length=255, nullable=false)
     */
    protected $supplierWebpage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="supplier_upddate", type="datetime", nullable=false)
     */
    protected $supplierUpddate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="supplier_insdate", type="datetime", nullable=false)
     */
    protected $supplierInsdate;

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
     * @ORM\Column(name="flat_data", type="text", length=65535, nullable=false)
     */
    protected $flatData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Supplier
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
     * Set supplierCode
     *
     * @param string $supplierCode
     *
     * @return Supplier
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
     * Set supplierTrdrSupfindataLbal
     *
     * @param string $supplierTrdrSupfindataLbal
     *
     * @return Supplier
     */
    public function setSupplierTrdrSupfindataLbal($supplierTrdrSupfindataLbal) {
        $this->supplierTrdrSupfindataLbal = $supplierTrdrSupfindataLbal;

        return $this;
    }

    /**
     * Get supplierTrdrSupfindataLbal
     *
     * @return string
     */
    public function getSupplierTrdrSupfindataLbal() {
        return $this->supplierTrdrSupfindataLbal;
    }

    /**
     * Set supplierName
     *
     * @param string $supplierName
     *
     * @return Supplier
     */
    public function setSupplierName($supplierName) {
        $this->supplierName = $supplierName;

        return $this;
    }

    /**
     * Get supplierName
     *
     * @return string
     */
    public function getSupplierName() {
        return $this->supplierName;
    }

    /**
     * Set supplierAfm
     *
     * @param string $supplierAfm
     *
     * @return Supplier
     */
    public function setSupplierAfm($supplierAfm) {
        $this->supplierAfm = $supplierAfm;

        return $this;
    }

    /**
     * Get supplierAfm
     *
     * @return string
     */
    public function getSupplierAfm() {
        return $this->supplierAfm;
    }

    /**
     * Set supplierAddress
     *
     * @param string $supplierAddress
     *
     * @return Supplier
     */
    public function setSupplierAddress($supplierAddress) {
        $this->supplierAddress = $supplierAddress;

        return $this;
    }

    /**
     * Get supplierAddress
     *
     * @return string
     */
    public function getSupplierAddress() {
        return $this->supplierAddress;
    }

    /**
     * Set supplierDistrict
     *
     * @param string $supplierDistrict
     *
     * @return Supplier
     */
    public function setSupplierDistrict($supplierDistrict) {
        $this->supplierDistrict = $supplierDistrict;

        return $this;
    }

    /**
     * Get supplierDistrict
     *
     * @return string
     */
    public function getSupplierDistrict() {
        return $this->supplierDistrict;
    }

    /**
     * Set supplierZip
     *
     * @param string $supplierZip
     *
     * @return Supplier
     */
    public function setSupplierZip($supplierZip) {
        $this->supplierZip = $supplierZip;

        return $this;
    }

    /**
     * Get supplierZip
     *
     * @return string
     */
    public function getSupplierZip() {
        return $this->supplierZip;
    }

    /**
     * Set supplierCity
     *
     * @param string $supplierCity
     *
     * @return Supplier
     */
    public function setSupplierCity($supplierCity) {
        $this->supplierCity = $supplierCity;

        return $this;
    }

    /**
     * Get supplierCity
     *
     * @return string
     */
    public function getSupplierCity() {
        return $this->supplierCity;
    }

    /**
     * Set supplierPhone01
     *
     * @param string $supplierPhone01
     *
     * @return Supplier
     */
    public function setSupplierPhone01($supplierPhone01) {
        $this->supplierPhone01 = $supplierPhone01;

        return $this;
    }

    /**
     * Get supplierPhone01
     *
     * @return string
     */
    public function getSupplierPhone01() {
        return $this->supplierPhone01;
    }

    /**
     * Set supplierPhone02
     *
     * @param string $supplierPhone02
     *
     * @return Supplier
     */
    public function setSupplierPhone02($supplierPhone02) {
        $this->supplierPhone02 = $supplierPhone02;

        return $this;
    }

    /**
     * Get supplierPhone02
     *
     * @return string
     */
    public function getSupplierPhone02() {
        return $this->supplierPhone02;
    }

    /**
     * Set supplierFax
     *
     * @param string $supplierFax
     *
     * @return Supplier
     */
    public function setSupplierFax($supplierFax) {
        $this->supplierFax = $supplierFax;

        return $this;
    }

    /**
     * Get supplierFax
     *
     * @return string
     */
    public function getSupplierFax() {
        return $this->supplierFax;
    }

    /**
     * Set supplierWebpage
     *
     * @param string $supplierWebpage
     *
     * @return Supplier
     */
    public function setSupplierWebpage($supplierWebpage) {
        $this->supplierWebpage = $supplierWebpage;

        return $this;
    }

    /**
     * Get supplierWebpage
     *
     * @return string
     */
    public function getSupplierWebpage() {
        return $this->supplierWebpage;
    }

    /**
     * Set supplierUpddate
     *
     * @param \DateTime $supplierUpddate
     *
     * @return Supplier
     */
    public function setSupplierUpddate($supplierUpddate) {
        $this->supplierUpddate = $supplierUpddate;

        return $this;
    }

    /**
     * Get supplierUpddate
     *
     * @return \DateTime
     */
    public function getSupplierUpddate() {
        return $this->supplierUpddate;
    }

    /**
     * Set supplierInsdate
     *
     * @param \DateTime $supplierInsdate
     *
     * @return Supplier
     */
    public function setSupplierInsdate($supplierInsdate) {
        $this->supplierInsdate = $supplierInsdate;

        return $this;
    }

    /**
     * Get supplierInsdate
     *
     * @return \DateTime
     */
    public function getSupplierInsdate() {
        return $this->supplierInsdate;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Supplier
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
     * @return Supplier
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
     * @return Supplier
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
     * @return Supplier
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
     * @return Supplier
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

}
