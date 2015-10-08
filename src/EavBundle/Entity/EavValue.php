<?php

namespace EavBundle\Entity;

/**
 * EavValue
 */
class EavValue
{
    /**
     * @var string
     */
    private $value;

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
    private $attributeItem;

    /**
     * @var integer
     */
    private $entityId;


    /**
     * Set value
     *
     * @param string $value
     *
     * @return EavValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return EavValue
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
     * @return EavValue
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
     * @return EavValue
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
     * Set attributeItem
     *
     * @param integer $attributeItem
     *
     * @return EavValue
     */
    public function setAttributeItem($attributeItem)
    {
        $this->attributeItem = $attributeItem;

        return $this;
    }

    /**
     * Get attributeItem
     *
     * @return integer
     */
    public function getAttributeItem()
    {
        return $this->attributeItem;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return EavValue
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
}

