<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eavmodel
 *
 * @ORM\Table(name="eavmodel", indexes={@ORM\Index(name="user_id", columns={"actioneer"})})
 * @ORM\Entity
 */
class Eavmodel {

    /**
     * @var string
     *
     * @ORM\Column(name="softone", type="string", length=255, nullable=false)
     */
    private $softone;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="string", length=255, nullable=false)
     */
    private $list;

    /**
     * @var string
     *
     * @ORM\Column(name="viewstyle", type="string", length=255, nullable=false)
     */
    private $viewstyle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    private $ts = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=true)
     */
    private $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set softone
     *
     * @param string $softone
     *
     * @return Eavmodel
     */
    public function setSoftone($softone) {
        $this->softone = $softone;

        return $this;
    }

    /**
     * Get softone
     *
     * @return string
     */
    public function getSoftone() {
        return $this->softone;
    }

    /**
     * Set list
     *
     * @param string $list
     *
     * @return Eavmodel
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
     * @return Eavmodel
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
     * @return Eavmodel
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
     * @return Eavmodel
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
     * @return Eavmodel
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
     * @return Eavmodel
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
     * @var string
     */
    private $entity;

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Eavmodel
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $attributeItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributeItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attributeItem
     *
     * @param \AppBundle\Entity\AttributeItems $attributeItem
     *
     * @return Eavmodel
     */
    public function addAttributeItem(\AppBundle\Entity\AttributeItems $attributeItem)
    {
        $this->attributeItems[] = $attributeItem;

        return $this;
    }

    /**
     * Remove attributeItem
     *
     * @param \AppBundle\Entity\AttributeItems $attributeItem
     */
    public function removeAttributeItem(\AppBundle\Entity\AttributeItems $attributeItem)
    {
        $this->attributeItems->removeElement($attributeItem);
    }

    /**
     * Get attributeItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributeItems()
    {
        return $this->attributeItems;
    }
}
