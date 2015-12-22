<?php

namespace EdiBundle\Entity;

/**
 * EltrekaediOrderItem
 */
class EltrekaediOrderItem {

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
    private $order;

    /**
     * @var integer
     */
    private $product;

    /**
     * @var integer
     */
    private $qty;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $disc1prc;

    /**
     * @var string
     */
    private $lineval;

    /**
     * @var integer
     */
    private $store = '7021';

    /**
     * @var boolean
     */
    private $chk;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return EltrekaediOrderItem
     */
    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return EltrekaediOrderItem
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

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return EltrekaediOrderItem
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
     * Set price
     *
     * @param string $price
     *
     * @return EltrekaediOrderItem
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set disc1prc
     *
     * @param string $disc1prc
     *
     * @return EltrekaediOrderItem
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
     * Set lineval
     *
     * @param string $lineval
     *
     * @return EltrekaediOrderItem
     */
    public function setLineval($lineval) {
        $this->lineval = $lineval;

        return $this;
    }

    /**
     * Get lineval
     *
     * @return string
     */
    public function getLineval() {
        return $this->lineval;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return EltrekaediOrderItem
     */
    public function setStore($store) {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore() {
        return $this->store;
    }

    /**
     * Set chk
     *
     * @param boolean $chk
     *
     * @return EltrekaediOrderItem
     */
    public function setChk($chk) {
        $this->chk = $chk;

        return $this;
    }

    /**
     * Get chk
     *
     * @return boolean
     */
    public function getChk() {
        return $this->chk;
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
     * @var \EdiBundle\Entity\Eltrekaedi
     */
    private $eltrekaedi;

    /**
     * Set eltrekaedi
     *
     * @param \EdiBundle\Entity\Eltrekaedi $eltrekaedi
     *
     * @return EltrekaediOrderItem
     */
    public function setEltrekaedi(\EdiBundle\Entity\Eltrekaedi $eltrekaedi = null) {
        $this->eltrekaedi = $eltrekaedi;

        return $this;
    }

    /**
     * Get eltrekaedi
     *
     * @return \EdiBundle\Entity\Eltrekaedi
     */
    public function getEltrekaedi() {
        return $this->eltrekaedi;
    }

    /**
     * @var \EdiBundle\Entity\EltrekaediOrder
     */
    private $eltrekaediorder;

    /**
     * Set eltrekaediorder
     *
     * @param \EdiBundle\Entity\EltrekaediOrder $eltrekaediorder
     *
     * @return EltrekaediOrderItem
     */
    public function setEltrekaediorder(\EdiBundle\Entity\EltrekaediOrder $eltrekaediorder = null) {
        $this->eltrekaediorder = $eltrekaediorder;

        return $this;
    }

    /**
     * Get eltrekaediorder
     *
     * @return \EdiBundle\Entity\EltrekaediOrder
     */
    public function getEltrekaediorder() {
        return $this->eltrekaediorder;
    }

    /**
     * @var string
     */
    private $discount;


    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return EltrekaediOrderItem
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}
