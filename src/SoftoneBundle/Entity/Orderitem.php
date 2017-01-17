<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Orderitem
 */
class Orderitem {

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
    protected $order;

    /**
     * @var integer
     */
    protected $qty;

    /**
     * @var string
     */
    protected $price;

    /**
     * @var string
     */
    protected $disc1prc;

    /**
     * @var string
     */
    protected $lineval;

    /**
     * @var integer
     */
    protected $store = '7021';

    /**
     * @var boolean
     */
    protected $chk;

    /**
     * @var integer
     */
    var $id;

    /**
     * @var \SoftoneBundle\Entity\Product
     */
    protected $product;



    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Orderitem
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
     * @return Orderitem
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
     * @return Orderitem
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
     * @return Orderitem
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
     * Get lineval
     *
     * @return string
     */
    public function getLinevalQty() {
        return $this->lineval / $this->qty;
    }    

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return Orderitem
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
     * @return Orderitem
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
     * Set product
     *
     * @param \SoftoneBundle\Entity\Product $product
     *
     * @return Orderitem
     */
    public function setProduct(\SoftoneBundle\Entity\Product $product = null) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \SoftoneBundle\Entity\Product
     */
    public function getProduct() {
        return $this->product;
    }


    /**
     * Set order
     *
     * @param \SoftoneBundle\Entity\Order $order
     *
     * @return Orderitem
     */
    public function setOrder(\SoftoneBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \SoftoneBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
