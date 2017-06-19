<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BrandModel
 *
 * @ORM\Table(name="brand_model", indexes={@ORM\Index(name="brand", columns={"brand"})})
 * @ORM\Entity
 */
class BrandModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="brand", type="integer", nullable=false)
     */
    protected $brand;

    /**
     * @var integer
     *
     * @ORM\Column(name="group", type="integer", nullable=false)
     */
    protected $group;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255, nullable=false)
     */
    protected $groupName;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_model", type="string", length=255, nullable=false)
     */
    protected $brandModel;
    
    /**
     * @var string
     *
     * @ORM\Column(name="brand_model_str", type="string", length=255, nullable=false)
     */
    protected $brandModelStr;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="year_from", type="integer", nullable=false)
     */
    protected $yearFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="year_to", type="integer", nullable=false)
     */
    protected $yearTo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    protected $enable = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    protected $status = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;



    /**
     * Set brand
     *
     * @param integer $brand
     *
     * @return BrandModel
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return integer
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set group
     *
     * @param integer $group
     *
     * @return BrandModel
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return integer
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     *
     * @return BrandModel
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Set brandModel
     *
     * @param string $brandModel
     *
     * @return BrandModel
     */
    public function setBrandModel($brandModel)
    {
        $this->brandModel = $brandModel;

        return $this;
    }

    /**
     * Get brandModel
     *
     * @return string
     */
    public function getBrandModel()
    {
        return $this->brandModel;
    }
    
    
    /**
     * Set brandModelStr
     *
     * @param string $brandModelStr
     *
     * @return BrandModelStr
     */
    public function setBrandModelStr($brandModelStr)
    {
        $this->brandModelStr = $brandModel;

        return $this;
    }

    /**
     * Get brandModelStr
     *
     * @return string
     */
    public function getBrandModelStr()
    {
        return $this->brandModelStr;
    }    
    

    /**
     * Set yearFrom
     *
     * @param integer $yearFrom
     *
     * @return BrandModel
     */
    public function setYearFrom($yearFrom)
    {
        $this->yearFrom = $yearFrom;

        return $this;
    }

    /**
     * Get yearFrom
     *
     * @return integer
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * Set yearTo
     *
     * @param integer $yearTo
     *
     * @return BrandModel
     */
    public function setYearTo($yearTo)
    {
        $this->yearTo = $yearTo;

        return $this;
    }

    /**
     * Get yearTo
     *
     * @return integer
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return BrandModel
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return BrandModel
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
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
     * @var boolean
     */
    private $mod_pc;

    /**
     * @var boolean
     */
    private $mod_cv;

    /**
     * @var boolean
     */
    private $mod_cc;


    /**
     * Set modPc
     *
     * @param boolean $modPc
     *
     * @return BrandModel
     */
    public function setModPc($modPc)
    {
        $this->mod_pc = $modPc;

        return $this;
    }

    /**
     * Get modPc
     *
     * @return boolean
     */
    public function getModPc()
    {
        return $this->mod_pc;
    }

    /**
     * Set modCv
     *
     * @param boolean $modCv
     *
     * @return BrandModel
     */
    public function setModCv($modCv)
    {
        $this->mod_cv = $modCv;

        return $this;
    }

    /**
     * Get modCv
     *
     * @return boolean
     */
    public function getModCv()
    {
        return $this->mod_cv;
    }

    /**
     * Set modCc
     *
     * @param boolean $modCc
     *
     * @return BrandModel
     */
    public function setModCc($modCc)
    {
        $this->mod_cc = $modCc;

        return $this;
    }

    /**
     * Get modCc
     *
     * @return boolean
     */
    public function getModCc()
    {
        return $this->mod_cc;
    }
}
