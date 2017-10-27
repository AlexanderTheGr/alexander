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
        return number_format($this->lineval / $this->qty, 2, '.', '');
        //return $this->lineval / $this->qty;
    }

    public function deleteitem() {
        return '<a style="font-size:20px; color:red; cursor: pointer" data-id="' . $this->id . '" class="deleteitem"><i class="md md-delete"></i></a>';
    }

    public function getProductApothiki() {
        return $this->getProduct()->getApothiki();
        //return $this->lineval / $this->qty;
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

    public function getForOrderSupplier() {
        return $this->getProduct()->getForOrderSupplier();
    }

    public function getForOrderItemsTitle() {


        $out = '<a title="' . $this->getProduct()->getTitle() . '" class="productfano_info" car="" data-articleId="' . $this->getProduct()->getTecdocArticleId() . '" data-ref="' . $this->getProduct()->getId() . '" href="#">' . $this->getProduct()->getTitle() . '</a>';
        $out .= '<div class="ediprices ediprices_' . $this->getProduct()->getId() . '"></div>';
        if ($this->remarks)
        $out .=  '<BR><span class="text-sm text-info">' . $this->remarks . '</span>';// "<BR>".$this->remarks;
        return $out;
    }

    /**
     * Set order
     *
     * @param \SoftoneBundle\Entity\Order $order
     *
     * @return Orderitem
     */
    public function setOrder(\SoftoneBundle\Entity\Order $order = null) {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \SoftoneBundle\Entity\Order
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", length=65535, nullable=false)
     */
    protected $remarks = '';

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Order
     */
    public function setRemarks($remarks) {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks() {
        return $this->remarks;
    }

}
