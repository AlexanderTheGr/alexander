<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BrandModelType
 *
 * @ORM\Table(name="brand_model_type", indexes={@ORM\Index(name="brand_model", columns={"brand_model"})})
 * @ORM\Entity
 */
class BrandModelType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="brand_model", type="integer", nullable=false)
     */
    private $brandModel;

    /**
     * @var string
     *
     * @ORM\Column(name="brand_model_type", type="string", length=255, nullable=false)
     */
    private $brandModelType;

    /**
     * @var string
     *
     * @ORM\Column(name="nodes", type="text", nullable=false)
     */
    private $nodes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="need_update", type="boolean", nullable=false)
     */
    private $needUpdate = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    private $enable = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="motor_type", type="string", length=255, nullable=false)
     */
    private $motorType;

    /**
     * @var integer
     *
     * @ORM\Column(name="power_hp", type="integer", nullable=false)
     */
    private $powerHp;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", length=65535, nullable=false)
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="text", length=65535, nullable=false)
     */
    private $engine;

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
     * Set brandModel
     *
     * @param integer $brandModel
     *
     * @return BrandModelType
     */
    public function setBrandModel($brandModel)
    {
        $this->brandModel = $brandModel;

        return $this;
    }

    /**
     * Get brandModel
     *
     * @return integer
     */
    public function getBrandModel()
    {
        return $this->brandModel;
    }

    /**
     * Set brandModelType
     *
     * @param string $brandModelType
     *
     * @return BrandModelType
     */
    public function setBrandModelType($brandModelType)
    {
        $this->brandModelType = $brandModelType;

        return $this;
    }

    /**
     * Get brandModelType
     *
     * @return string
     */
    public function getBrandModelType()
    {
        return $this->brandModelType;
    }

    /**
     * Set nodes
     *
     * @param string $nodes
     *
     * @return BrandModelType
     */
    public function setNodes($nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Get nodes
     *
     * @return string
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Set needUpdate
     *
     * @param boolean $needUpdate
     *
     * @return BrandModelType
     */
    public function setNeedUpdate($needUpdate)
    {
        $this->needUpdate = $needUpdate;

        return $this;
    }

    /**
     * Get needUpdate
     *
     * @return boolean
     */
    public function getNeedUpdate()
    {
        return $this->needUpdate;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return BrandModelType
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return BrandModelType
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
     * Set motorType
     *
     * @param string $motorType
     *
     * @return BrandModelType
     */
    public function setMotorType($motorType)
    {
        $this->motorType = $motorType;

        return $this;
    }

    /**
     * Get motorType
     *
     * @return string
     */
    public function getMotorType()
    {
        return $this->motorType;
    }

    /**
     * Set powerHp
     *
     * @param integer $powerHp
     *
     * @return BrandModelType
     */
    public function setPowerHp($powerHp)
    {
        $this->powerHp = $powerHp;

        return $this;
    }

    /**
     * Get powerHp
     *
     * @return integer
     */
    public function getPowerHp()
    {
        return $this->powerHp;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return BrandModelType
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return BrandModelType
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return BrandModelType
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
