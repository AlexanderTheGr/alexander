<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity
 */
class Brand
{
    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=false)
     */
    protected $brand;

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
     * @var boolean
     *
     * @ORM\Column(name="top", type="boolean", nullable=false)
     */
    protected $top;

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
     * @param string $brand
     *
     * @return Brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return Brand
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
     * @return Brand
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
     * Set top
     *
     * @param boolean $top
     *
     * @return Brand
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return boolean
     */
    public function getTop()
    {
        return $this->top;
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
     * @return Brand
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
     * @return Brand
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
     * @return Brand
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
