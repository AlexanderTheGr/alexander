<?php

namespace MegasoftBundle\Entity;

/**
 * Customergroup
 */
class Customergroup
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $basePrice;

    /**
     * @var \DateTime
     */
    private $ts;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $customergrouprules;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->customergrouprules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Customergroup
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
     * Set basePrice
     *
     * @param string $basePrice
     *
     * @return Customergroup
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return string
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Customergroup
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Customergroup
     */
    public function setActioneer($actioneer)
    {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer()
    {
        return $this->actioneer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Customergroup
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Customergroup
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
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
     * Add customergrouprule
     *
     * @param \MegasoftBundle\Entity\Customergrouprule $customergrouprule
     *
     * @return Customergroup
     */
    public function addCustomergrouprule(\MegasoftBundle\Entity\Customergrouprule $customergrouprule)
    {
        $this->customergrouprules[] = $customergrouprule;

        return $this;
    }

    /**
     * Remove customergrouprule
     *
     * @param \MegasoftBundle\Entity\Customergrouprule $customergrouprule
     */
    public function removeCustomergrouprule(\MegasoftBundle\Entity\Customergrouprule $customergrouprule)
    {
        $this->customergrouprules->removeElement($customergrouprule);
    }

    /**
     * Get customergrouprules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomergrouprules()
    {
        return $this->customergrouprules;
    }
}
