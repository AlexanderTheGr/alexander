<?php

namespace EdiBundle\Entity;

/**
 * Edirule
 */
class Edirule {

    /**
     * @var string
     */
    private $val;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $sortorder;

    /**
     * @var string
     */
    private $rule;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \EdiBundle\Entity\Edi
     */
    private $edi;

    /**
     * Set val
     *
     * @param string $val
     *
     * @return Edirule
     */
    public function setVal($val) {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal() {
        return $this->val;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Edirule
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
     * Set title
     *
     * @param string $title
     *
     * @return Edirule
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set sortorder
     *
     * @param integer $sortorder
     *
     * @return Edirule
     */
    public function setSortorder($sortorder) {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer
     */
    public function getSortorder() {
        return $this->sortorder;
    }

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return Edirule
     */
    public function setRule($rule) {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule() {
        return $this->rule;
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
     * Set group
     *
     * @param \EdiBundle\Entity\Edi $edi
     *
     * @return Edirule
     */
    public function setEdi(\EdiBundle\Entity\Edi $edi = null) {
        $this->edi = $edi;

        return $this;
    }

    /**
     * Get group
     *
     * @return \EdiBundle\Entity\Edi
     */
    public function getEdi() {
        return $this->group;
    }

}
