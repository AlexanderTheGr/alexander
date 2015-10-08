<?php

namespace PartsboxBundle\Entity;

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
    private $brand;

    /**
     * @var integer
     *
     * @ORM\Column(name="group", type="integer", nullable=false)
     */
    private $group;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255, nullable=false)
     */
    private $groupName;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_model", type="string", length=255, nullable=false)
     */
    private $brandModel;

    /**
     * @var integer
     *
     * @ORM\Column(name="year_from", type="integer", nullable=false)
     */
    private $yearFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="year_to", type="integer", nullable=false)
     */
    private $yearTo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    private $enable = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



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
}
