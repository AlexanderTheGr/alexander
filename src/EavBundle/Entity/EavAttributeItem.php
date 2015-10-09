<?php

namespace EavBundle\Entity;

/**
 * EavAttributeItem
 */
class EavAttributeItem
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $css;

    /**
     * @var string
     */
    private $listStyle = 'horizontal';

    /**
     * @var string
     */
    private $selectData;

    /**
     * @var boolean
     */
    private $required;

    /**
     * @var boolean
     */
    private $visible;

    /**
     * @var boolean
     */
    private $unique = '0';

    /**
     * @var integer
     */
    private $sort;

    /**
     * @var integer
     */
    private $column = '1';

    /**
     * @var integer
     */
    private $groupId = '1';

    /**
     * @var string
     */
    private $access;

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
     * @var \EavBundle\Entity\EavAttribute
     */
    private $eav_attribute;

    /**
     * @var \EavBundle\Entity\EavEntity
     */
    private $eav_entity;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return EavAttributeItem
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
     * Set css
     *
     * @param string $css
     *
     * @return EavAttributeItem
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * Get css
     *
     * @return string
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Set listStyle
     *
     * @param string $listStyle
     *
     * @return EavAttributeItem
     */
    public function setListStyle($listStyle)
    {
        $this->listStyle = $listStyle;

        return $this;
    }

    /**
     * Get listStyle
     *
     * @return string
     */
    public function getListStyle()
    {
        return $this->listStyle;
    }

    /**
     * Set selectData
     *
     * @param string $selectData
     *
     * @return EavAttributeItem
     */
    public function setSelectData($selectData)
    {
        $this->selectData = $selectData;

        return $this;
    }

    /**
     * Get selectData
     *
     * @return string
     */
    public function getSelectData()
    {
        return $this->selectData;
    }

    /**
     * Set required
     *
     * @param boolean $required
     *
     * @return EavAttributeItem
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return EavAttributeItem
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set unique
     *
     * @param boolean $unique
     *
     * @return EavAttributeItem
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;

        return $this;
    }

    /**
     * Get unique
     *
     * @return boolean
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     *
     * @return EavAttributeItem
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set column
     *
     * @param integer $column
     *
     * @return EavAttributeItem
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Get column
     *
     * @return integer
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Set groupId
     *
     * @param integer $groupId
     *
     * @return EavAttributeItem
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set access
     *
     * @param string $access
     *
     * @return EavAttributeItem
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return EavAttributeItem
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
     * @return EavAttributeItem
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
     * @return EavAttributeItem
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
     * @return EavAttributeItem
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
     * Set eavAttribute
     *
     * @param \EavBundle\Entity\EavAttribute $eavAttribute
     *
     * @return EavAttributeItem
     */
    public function setEavAttribute(\EavBundle\Entity\EavAttribute $eavAttribute = null)
    {
        $this->eav_attribute = $eavAttribute;

        return $this;
    }

    /**
     * Get eavAttribute
     *
     * @return \EavBundle\Entity\EavAttribute
     */
    public function getEavAttribute()
    {
        return $this->eav_attribute;
    }

    /**
     * Set eavEntity
     *
     * @param \EavBundle\Entity\EavEntity $eavEntity
     *
     * @return EavAttributeItem
     */
    public function setEavEntity(\EavBundle\Entity\EavEntity $eavEntity = null)
    {
        $this->eav_entity = $eavEntity;

        return $this;
    }

    /**
     * Get eavEntity
     *
     * @return \EavBundle\Entity\EavEntity
     */
    public function getEavEntity()
    {
        return $this->eav_entity;
    }
}
