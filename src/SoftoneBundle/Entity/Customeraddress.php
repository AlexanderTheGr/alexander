<?php

namespace SoftoneBundle\Entity;

/**
 * Customeraddress
 */
class Customeraddress {

    /**
     * @var integer
     */
    private $reference;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $country = '1000';

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $district;

    /**
     * @var integer
     */
    private $district1;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var integer
     */
    private $branch;

    /**
     * @var string
     */
    private $discount;

    /**
     * @var boolean
     */
    private $iscenter;

    /**
     * @var boolean
     */
    private $isactive;

    /**
     * @var integer
     */
    private $vatsts = '1';

    /**
     * @var integer
     */
    var $id;

    /**
     * @var \SoftoneBundle\Entity\Customeraddress
     */
    private $customer;

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Customeraddress
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
     * Set code
     *
     * @param string $code
     *
     * @return Customeraddress
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customeraddress
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set country
     *
     * @param integer $country
     *
     * @return Customeraddress
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return integer
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Customeraddress
     */
    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return Customeraddress
     */
    public function setZip($zip) {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip() {
        return $this->zip;
    }

    /**
     * Set district
     *
     * @param string $district
     *
     * @return Customeraddress
     */
    public function setDistrict($district) {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return string
     */
    public function getDistrict() {
        return $this->district;
    }

    /**
     * Set district1
     *
     * @param integer $district1
     *
     * @return Customeraddress
     */
    public function setDistrict1($district1) {
        $this->district1 = $district1;

        return $this;
    }

    /**
     * Get district1
     *
     * @return integer
     */
    public function getDistrict1() {
        return $this->district1;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Customeraddress
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Customeraddress
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set branch
     *
     * @param integer $branch
     *
     * @return Customeraddress
     */
    public function setBranch($branch) {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return integer
     */
    public function getBranch() {
        return $this->branch;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return Customeraddress
     */
    public function setDiscount($discount) {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount() {
        return $this->discount;
    }

    /**
     * Set iscenter
     *
     * @param boolean $iscenter
     *
     * @return Customeraddress
     */
    public function setIscenter($iscenter) {
        $this->iscenter = $iscenter;

        return $this;
    }

    /**
     * Get iscenter
     *
     * @return boolean
     */
    public function getIscenter() {
        return $this->iscenter;
    }

    /**
     * Set isactive
     *
     * @param boolean $isactive
     *
     * @return Customeraddress
     */
    public function setIsactive($isactive) {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return boolean
     */
    public function getIsactive() {
        return $this->isactive;
    }

    /**
     * Set vatsts
     *
     * @param integer $vatsts
     *
     * @return Customeraddress
     */
    public function setVatsts($vatsts) {
        $this->vatsts = $vatsts;

        return $this;
    }

    /**
     * Get vatsts
     *
     * @return integer
     */
    public function getVatsts() {
        return $this->vatsts;
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
     * Set customer
     *
     * @param \SoftoneBundle\Entity\Customeraddress $customer
     *
     * @return Customeraddress
     */
    public function setCustomer(\SoftoneBundle\Entity\Customer $customer = null) {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Get customer
     *
     * @return \SoftoneBundle\Entity\Customeraddress
     */
    public function getCustomer() {
        return $this->customer;
    }

}
