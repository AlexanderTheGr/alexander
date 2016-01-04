<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BrandGroup
 *
 * @ORM\Table(name="brand_group", indexes={@ORM\Index(name="brand", columns={"brand"})})
 * @ORM\Entity
 */
class BrandGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="brand", type="integer", nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_group", type="string", length=255, nullable=false)
     */
    private $brandGroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    private $enable = '0';

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
     * @return BrandGroup
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
     * Set brandGroup
     *
     * @param string $brandGroup
     *
     * @return BrandGroup
     */
    public function setBrandGroup($brandGroup)
    {
        $this->brandGroup = $brandGroup;

        return $this;
    }

    /**
     * Get brandGroup
     *
     * @return string
     */
    public function getBrandGroup()
    {
        return $this->brandGroup;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return BrandGroup
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
