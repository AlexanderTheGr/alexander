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
    private $discount;

    /**
     * @var string
     */
    private $finalprice;

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
     * Set finalprice
     *
     * @param string $finalprice
     *
     * @return Orderitem
     */
    public function setFinalprice($finalprice)
    {
        $this->finalprice = $finalprice;

        return $this;
    }

    /**
     * Get finalprice
     *
     * @return string
     */
    public function getFinalprice()
    {
        return $this->finalprice;
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

