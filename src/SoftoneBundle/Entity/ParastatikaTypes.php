<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParastatikaTypes
 *
 * @ORM\Table(name="parastatika_types")
 * @ORM\Entity
 */
class ParastatikaTypes
{
    /**
     * @var string
     *
     * @ORM\Column(name="perigrafi", type="string", length=255, nullable=false)
     */
    protected $perigrafi;

    /**
     * @var string
     *
     * @ORM\Column(name="symperifora", type="string", length=255, nullable=false)
     */
    protected $symperifora;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $enabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;



    /**
     * Set perigrafi
     *
     * @param string $perigrafi
     *
     * @return ParastatikaTypes
     */
    public function setPerigrafi($perigrafi)
    {
        $this->perigrafi = $perigrafi;

        return $this;
    }

    /**
     * Get perigrafi
     *
     * @return string
     */
    public function getPerigrafi()
    {
        return $this->perigrafi;
    }

    /**
     * Set symperifora
     *
     * @param string $symperifora
     *
     * @return ParastatikaTypes
     */
    public function setSymperifora($symperifora)
    {
        $this->symperifora = $symperifora;

        return $this;
    }

    /**
     * Get symperifora
     *
     * @return string
     */
    public function getSymperifora()
    {
        return $this->symperifora;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return ParastatikaTypes
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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
