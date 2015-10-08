<?php

namespace EavBundle\Entity;

/**
 * EavAttribute
 */
class EavAttribute {

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $css;

    /**
     * @var boolean
     */
    private $required = '0';

    /**
     * @var boolean
     */
    private $visible = '0';

    /**
     * @var boolean
     */
    private $searchable = '0';

    /**
     * @var boolean
     */
    private $unique = '0';

    /**
     * @var string
     */
    private $validation = 'none';

    /**
     * @var boolean
     */
    private $locked = '0';

    /**
     * @var string
     */
    private $selectData;

    /**
     * @var string
     */
    private $source;

    /**
     * @var \DateTime
     */
    private $ts = 'CURRENT_TIMESTAMP';

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
     * Set type
     *
     * @param string $type
     *
     * @return EavAttribute
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return EavAttribute
     */
    public function setIdentifier($identifier) {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return EavAttribute
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
     * Set css
     *
     * @param string $css
     *
     * @return EavAttribute
     */
    public function setCss($css) {
        $this->css = $css;

        return $this;
    }

    /**
     * Get css
     *
     * @return string
     */
    public function getCss() {
        return $this->css;
    }

    /**
     * Set required
     *
     * @param boolean $required
     *
     * @return EavAttribute
     */
    public function setRequired($required) {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired() {
        return $this->required;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return EavAttribute
     */
    public function setVisible($visible) {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible() {
        return $this->visible;
    }

    /**
     * Set searchable
     *
     * @param boolean $searchable
     *
     * @return EavAttribute
     */
    public function setSearchable($searchable) {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Get searchable
     *
     * @return boolean
     */
    public function getSearchable() {
        return $this->searchable;
    }

    /**
     * Set unique
     *
     * @param boolean $unique
     *
     * @return EavAttribute
     */
    public function setUnique($unique) {
        $this->unique = $unique;

        return $this;
    }

    /**
     * Get unique
     *
     * @return boolean
     */
    public function getUnique() {
        return $this->unique;
    }

    /**
     * Set validation
     *
     * @param string $validation
     *
     * @return EavAttribute
     */
    public function setValidation($validation) {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getValidation() {
        return $this->validation;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return EavAttribute
     */
    public function setLocked($locked) {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked() {
        return $this->locked;
    }

    /**
     * Set selectData
     *
     * @param string $selectData
     *
     * @return EavAttribute
     */
    public function setSelectData($selectData) {
        $this->selectData = $selectData;

        return $this;
    }

    /**
     * Get selectData
     *
     * @return string
     */
    public function getSelectData() {
        return $this->selectData;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return EavAttribute
     */
    public function setSource($source) {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return EavAttribute
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
     * @return EavAttribute
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
     * @return EavAttribute
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
     * @return EavAttribute
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
     * @return EavAttribute
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
