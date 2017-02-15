<?php

namespace MegasoftBundle\Entity;

/**
 * Orderitem
 */
class Orderitem
{
    /**
     * @var integer
     */
    private $qty = '0';

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
    private $store = '0';

    /**
     * @var boolean
     */
    private $chk;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \MegasoftBundle\Entity\Product
     */
    private $product;

    /**
     * @var \MegasoftBundle\Entity\Order
     */
    private $order;


    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Orderitem
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
     * @return Orderitem
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
     * @return Orderitem
     */
    public function setDisc1prc($disc1prc)
    {
        $this->disc1prc = $disc1prc;

        return $this;
    }

    /**
     * Get disc1prc
     *
     * @return string
     */
    public function getDisc1prc()
    {
        return $this->disc1prc;
    }

    /**
     * Set lineval
     *
     * @param string $lineval
     *
     * @return Orderitem
     */
    public function setLineval($lineval)
    {
        $this->lineval = $lineval;

        return $this;
    }

    /**
     * Get lineval
     *
     * @return string
     */
    public function getLineval()
    {
        return $this->lineval;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return Orderitem
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
     * @return Orderitem
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
     * Set product
     *
     * @param \MegasoftBundle\Entity\Product $product
     *
     * @return Orderitem
     */
    public function setProduct(\MegasoftBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MegasoftBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set order
     *
     * @param \MegasoftBundle\Entity\Order $order
     *
     * @return Orderitem
     */
    public function setOrder(\MegasoftBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \MegasoftBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
