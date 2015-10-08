<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orderitem
 *
 * @ORM\Table(name="orderitem", indexes={@ORM\Index(name="order", columns={"order"}), @ORM\Index(name="product", columns={"product"})})
 * @ORM\Entity
 */
class Orderitem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var integer
     *
     * @ORM\Column(name="product", type="integer", nullable=false)
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="qty", type="integer", nullable=false)
     */
    private $qty;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="disc1prc", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $disc1prc;

    /**
     * @var string
     *
     * @ORM\Column(name="lineval", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $lineval;

    /**
     * @var integer
     *
     * @ORM\Column(name="store", type="integer", nullable=false)
     */
    private $store = '7021';

    /**
     * @var boolean
     *
     * @ORM\Column(name="chk", type="boolean", nullable=false)
     */
    private $chk;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Orderitem
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return Orderitem
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return integer
     */
    public function getProduct()
    {
        return $this->product;
    }

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
     * Set disc1prc
     *
     * @param string $disc1prc
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
}
