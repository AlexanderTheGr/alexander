<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttributeItems
 *
 * @ORM\Table(name="attribute_items", uniqueConstraints={@ORM\UniqueConstraint(name="eav_model_2", columns={"eav_model", "attribute_id"})}, indexes={@ORM\Index(name="eav_model", columns={"eav_model"}), @ORM\Index(name="user_id", columns={"actioneer"})})
 * @ORM\Entity
 */
class AttributeItems
{
    /**
     * @var string
     *
     * @ORM\Column(name="eav_model", type="integer", length=255, nullable=false)
     */
    private $entity;

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_id", type="integer", nullable=false)
     */
    private $attributeId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="css", type="text", length=65535, nullable=false)
     */
    private $css;

    /**
     * @var string
     *
     * @ORM\Column(name="list_style", type="string", length=255, nullable=false)
     */
    private $listStyle = 'horizontal';

    /**
     * @var string
     *
     * @ORM\Column(name="select_data", type="string", length=255, nullable=false)
     */
    private $selectData;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible;

    /**
     * @var boolean
     *
     * @ORM\Column(name="unique", type="boolean", nullable=false)
     */
    private $unique = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", nullable=false)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\Column(name="column", type="integer", nullable=false)
     */
    private $column = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     */
    private $groupId = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="text", length=65535, nullable=false)
     */
    private $access;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    private $ts = 'CURRENT_TIMESTAMP';

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
     * Set entity
     *
     * @param string $entity
     *
     * @return AttributeItems
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set attributeId
     *
     * @param integer $attributeId
     *
     * @return AttributeItems
     */
    public function setAttributeId($attributeId)
    {
        $this->attributeId = $attributeId;

        return $this;
    }

    /**
     * Get attributeId
     *
     * @return integer
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
     * @return AttributeItems
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
}
