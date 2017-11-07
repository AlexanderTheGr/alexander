<?php

namespace SoftoneBundle\Entity;

/**
 * InvoiceItem
 */
class InvoiceItem {

    /**
     * @var string
     */
    private $invoice;

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
     * @var boolean
     */
    private $chk;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \SoftoneBundle\Entity\Invoice
     */
    private $invoice;

    /**
     * Set invoice
     *
     * @param string $invoice
     *
     * @return InvoiceItem
     */
    public function setInvoice($invoice) {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return string
     */
    public function getInvoice() {
        return $this->invoice;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return InvoiceItem
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
     * @return InvoiceItem
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
     * @return InvoiceItem
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
     * @return InvoiceItem
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
     * Set chk
     *
     * @param boolean $chk
     *
     * @return InvoiceItem
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
     * @var string
     */
    private $code;


    /**
     * Set code
     *
     * @param string $code
     *
     * @return InvoiceItem
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
