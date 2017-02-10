<?php

namespace MegasoftBundle\Entity;

/**
 * Customergrouprule
 */
class Customergrouprule
{
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
     * @var \MegasoftBundle\Entity\Customergroup
     */
    private $group;


    /**
     * Set val
     *
     * @param string $val
     *
     * @return Customergrouprule
     */
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Customergrouprule
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
     * Set title
     *
     * @param string $title
     *
     * @return Customergrouprule
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set sortorder
     *
     * @param integer $sortorder
     *
     * @return Customergrouprule
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return Customergrouprule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
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
     * Set group
     *
     * @param \MegasoftBundle\Entity\Customergroup $group
     *
     * @return Customergrouprule
     */
    public function setGroup(\MegasoftBundle\Entity\Customergroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \MegasoftBundle\Entity\Customergroup
     */
    public function getGroup()
    {
        return $this->group;
    }
}
