<?php

namespace EdiBundle\Entity;

/**
 * EdiOrderItem
 */
class EdiOrderItem
{
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
     * @var \EdiBundle\Entity\EdiItem
     */
    private $EdiItem;

    /**
     * @var \EdiBundle\Entity\EdiOrder
     */
    private $EdiOrder;


    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return EdiOrderItem
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return EdiOrderItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return EdiOrderItem
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

    /**
     * Set fprice
     *
     * @param string $fprice
     *
     * @return EdiOrderItem
     */
    public function setFprice($fprice)
    {
        $this->fprice = $fprice;

        return $this;
    }

    /**
     * Get fprice
     *
     * @return string
     */
    public function getFprice()
    {
        return $this->fprice;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return EdiOrderItem
     */
    public function setStore($store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set chk
     *
     * @param boolean $chk
     *
     * @return EdiOrderItem
     */
    public function setChk($chk)
    {
        $this->chk = $chk;

        return $this;
    }

    /**
     * Get chk
     *
     * @return boolean
     */
    public function getChk()
    {
        return $this->chk;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ediItem
     *
     * @param \EdiBundle\Entity\EdiItem $ediItem
     *
     * @return EdiOrderItem
     */
    public function setEdiItem(\EdiBundle\Entity\EdiItem $ediItem = null)
    {
        $this->EdiItem = $ediItem;

        return $this;
    }

    /**
     * Get ediItem
     *
     * @return \EdiBundle\Entity\EdiItem
     */
    public function getEdiItem()
    {
        return $this->EdiItem;
    }

    /**
     * Set ediOrder
     *
     * @param \EdiBundle\Entity\EdiOrder $ediOrder
     *
     * @return EdiOrderItem
     */
    public function setEdiOrder(\EdiBundle\Entity\EdiOrder $ediOrder = null)
    {
        $this->EdiOrder = $ediOrder;

        return $this;
    }

    /**
     * Get ediOrder
     *
     * @return \EdiBundle\Entity\EdiOrder
     */
    public function getEdiOrder()
    {
        return $this->EdiOrder;
    }
}
