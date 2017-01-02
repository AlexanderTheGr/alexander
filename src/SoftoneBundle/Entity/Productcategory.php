<?php

namespace SoftoneBundle\Entity;

/**
 * Productcategory
 */
class Productcategory {

    /**
     * @var integer
     */
    private $product;

    /**
     * @var integer
     */
    private $category;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set product
     *
     * @param integer $product
     *
     * @return Productcategory
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
     * Set category
     *
     * @param integer $category
     *
     * @return Productcategory
     */
    public function setCategory($category) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

}
