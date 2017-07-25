<?php

namespace MegasoftBundle\Entity;

/**
 * Productcar
 */
class Productcar
{
    /**
     * @var integer
     */
    private $product;

    /**
     * @var integer
     */
    private $car;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set product
     *
     * @param integer $product
     *
     * @return Productcar
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
     * Set car
     *
     * @param integer $car
     *
     * @return Productcar
     */
    public function setCar($car)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return integer
     */
    public function getCar()
    {
        return $this->car;
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
