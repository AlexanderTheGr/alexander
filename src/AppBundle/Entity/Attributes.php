<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attributes
 *
 * @ORM\Table(name="attributes", indexes={@ORM\Index(name="user_id", columns={"actioneer"})})
 * @ORM\Entity
 */
class Attributes
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string", length=100, nullable=false)
     */
    private $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="css", type="text", length=65535, nullable=false)
     */
    private $css;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean", nullable=false)
     */
    private $visible = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="searchable", type="boolean", nullable=false)
     */
    private $searchable = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="unique", type="boolean", nullable=false)
     */
    private $unique = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="validation", type="string", length=255, nullable=false)
     */
    private $validation = 'none';

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    private $locked = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="select_data", type="text", length=65535, nullable=false)
     */
    private $selectData;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="text", length=65535, nullable=false)
     */
    private $source;

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
     * Set type
     *
     * @param string $type
     *
     * @return Attributes
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Attributes
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Attributes
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
     * @return Attributes
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
     * Set required
     *
     * @param boolean $required
     *
     * @return Attributes
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
     * @return Attributes
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
     * Set searchable
     *
     * @param boolean $searchable
     *
     * @return Attributes
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Get searchable
     *
     * @return boolean
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Set unique
     *
     * @param boolean $unique
     *
     * @return Attributes
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
     * Set validation
     *
     * @param string $validation
     *
     * @return Attributes
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Attributes
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set selectData
     *
     * @param string $selectData
     *
     * @return Attributes
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
     * Set source
     *
     * @param string $source
     *
     * @return Attributes
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Attributes
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
     * @return Attributes
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
     * @return Attributes
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
     * @return Attributes
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
