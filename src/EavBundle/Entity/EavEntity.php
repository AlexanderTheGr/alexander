<?php

namespace EavBundle\Entity;

/**
 * EavEntity
 */
class EavEntity {

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $list;

    /**
     * @var string
     */
    private $viewstyle;

    /**
     * @var \DateTime
     */
    private $ts = '0000-00-00 00:00:00';

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
    private $eav_attribute_items;

    /**
     * Constructor
     */
    public function __construct() {
        $this->eav_attribute_items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return EavEntity
     */
    public function setEntity($entity) {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * Set list
     *
     * @param string $list
     *
     * @return EavEntity
     */
    public function setList($list) {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return string
     */
    public function getList() {
        return $this->list;
    }

    /**
     * Set viewstyle
     *
     * @param string $viewstyle
     *
     * @return EavEntity
     */
    public function setViewstyle($viewstyle) {
        $this->viewstyle = $viewstyle;

        return $this;
    }

    /**
     * Get viewstyle
     *
     * @return string
     */
    public function getViewstyle() {
        return $this->viewstyle;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return EavEntity
     */
    public function setTs($ts) {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs() {
        return $this->ts;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return EavEntity
     */
    public function setActioneer($actioneer) {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer() {
        return $this->actioneer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return EavEntity
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return EavEntity
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified() {
        return $this->modified;
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
     * Add eavAttributeItem
     *
     * @param \EavBundle\Entity\EavAttributeItem $eavAttributeItem
     *
     * @return EavEntity
     */
    public function addEavAttributeItem(\EavBundle\Entity\EavAttributeItem $eavAttributeItem) {
        $this->eav_attribute_items[] = $eavAttributeItem;

        return $this;
    }

    /**
     * Remove eavAttributeItem
     *
     * @param \EavBundle\Entity\EavAttributeItem $eavAttributeItem
     */
    public function removeEavAttributeItem(\EavBundle\Entity\EavAttributeItem $eavAttributeItem) {
        $this->eav_attribute_items->removeElement($eavAttributeItem);
    }

    /**
     * Get eavAttributeItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEavAttributeItems() {
        return $this->eav_attribute_items;
    }

}
