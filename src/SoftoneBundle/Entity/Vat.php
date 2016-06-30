<?php

namespace SoftoneBundle\Entity;

/**
 * Vat
 */
class Vat {

    /**
     * @var string
     */
    private $vat;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set vat
     *
     * @param string $vat
     *
     * @return Vat
     */
    public function setVat($vat) {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return string
     */
    public function getVat() {
        return $this->vat;
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
     * @var integer
     */
    private $vatsts;


    /**
     * Set vatsts
     *
     * @param integer $vatsts
     *
     * @return Vat
     */
    public function setVatsts($vatsts)
    {
        $this->vatsts = $vatsts;

        return $this;
    }

    /**
     * Get vatsts
     *
     * @return integer
     */
    public function getVatsts()
    {
        return $this->vatsts;
    }
    /**
     * @var boolean
     */
    private $enable = '0';


    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return Vat
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
}
