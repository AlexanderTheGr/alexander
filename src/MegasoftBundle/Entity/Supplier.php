<?php

namespace MegasoftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
class Supplier extends Entity {

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

    /**
     * @var integer
     */
    private $reference;

    /**
     * @var string
     */
    private $supplierCode;

    /**
     * @var string
     */
    private $supplierName;

    /**
     * @var string
     */
    private $supplierAfm;

    /**
     * @var string
     */
    private $supplierAddress;

    /**
     * @var string
     */
    private $supplierZip;

    /**
     * @var string
     */
    private $supplierCity;

    /**
     * @var string
     */
    private $supplierPhone01;

    /**
     * @var string
     */
    private $supplierPhone02;

    /**
     * @var string
     */
    private $supplierSite;

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
     * @var string
     */
    private $flatData;

    /**
     * @var integer
     */
    private $id;

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
     * Set supplierSite
     *
     * @param string $supplierSite
     *
     * @return Supplier
     */
    public function setSupplierSite($supplierSite) {
        $this->supplierSite = $supplierSite;

        return $this;
    }

    /**
     * Get supplierSite
     *
     * @return string
     */
    public function getSupplierSite() {
        return $this->supplierSite;
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
