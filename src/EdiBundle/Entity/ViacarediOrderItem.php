<?php

namespace EdiBundle\Entity;

/**
 * ViacarediOrderItem
 */
class ViacarediOrderItem {

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
    private $qty;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $discount;

    /**
     * @var string
     */
    private $fprice;

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
     * @var \EdiBundle\Entity\Viacaredi
     */
    private $viacaredi;

    /**
     * @var \EdiBundle\Entity\ViacarediOrder
     */
    private $ViacarediOrder;

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return ViacarediOrderItem
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
     * @return ViacarediOrderItem
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
     * Set discount
     *
     * @param string $discount
     *
     * @return ViacarediOrderItem
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
     * Set fprice
     *
     * @param string $fprice
     *
     * @return ViacarediOrderItem
     */
    public function setFprice($fprice) {
        $this->fprice = $fprice;

        return $this;
    }

    /**
     * Get fprice
     *
     * @return string
     */
    public function getFprice() {
        return $this->fprice;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return ViacarediOrderItem
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
     * @return ViacarediOrderItem
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
     * Set viacaredi
     *
     * @param \EdiBundle\Entity\Viacaredi $viacaredi
     *
     * @return ViacarediOrderItem
     */
    public function setViacaredi(\EdiBundle\Entity\Viacaredi $viacaredi = null) {
        $this->viacaredi = $viacaredi;

        return $this;
    }

    /**
     * Get viacaredi
     *
     * @return \EdiBundle\Entity\Viacaredi
     */
    public function getViacaredi() {
        return $this->viacaredi;
    }

    /**
     * Set viacarediOrder
     *
     * @param \EdiBundle\Entity\ViacarediOrder $viacarediOrder
     *
     * @return ViacarediOrderItem
     */
    public function setViacarediOrder(\EdiBundle\Entity\ViacarediOrder $viacarediOrder = null) {
        $this->ViacarediOrder = $viacarediOrder;

        return $this;
    }

    /**
     * Get viacarediOrder
     *
     * @return \EdiBundle\Entity\ViacarediOrder
     */
    public function getViacarediOrder() {
        return $this->ViacarediOrder;
    }

}
