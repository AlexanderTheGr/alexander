<?php

namespace EdiBundle\Entity;

/**
 * EdiItem
 */
class EdiItem
{
    /**
     * @var string
     */
    private $itemCode;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $partno;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $dlnr;

    /**
     * @var string
     */
    private $artNr;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var string
     */
    private $retailprice;

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
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return EdiItem
     */
    public function setItemCode($itemCode)
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    /**
     * Get itemCode
     *
     * @return string
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return EdiItem
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
     * Set partno
     *
     * @param string $partno
     *
     * @return EdiItem
     */
    public function setPartno($partno)
    {
        $this->partno = $partno;

        return $this;
    }

    /**
     * Get partno
     *
     * @return string
     */
    public function getPartno()
    {
        return $this->partno;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return EdiItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dlnr
     *
     * @param integer $dlnr
     *
     * @return EdiItem
     */
    public function setDlnr($dlnr)
    {
        $this->dlnr = $dlnr;

        return $this;
    }

    /**
     * Get dlnr
     *
     * @return integer
     */
    public function getDlnr()
    {
        return $this->dlnr;
    }

    /**
     * Set artNr
     *
     * @param string $artNr
     *
     * @return EdiItem
     */
    public function setArtNr($artNr)
    {
        $this->artNr = $artNr;

        return $this;
    }

    /**
     * Get artNr
     *
     * @return string
     */
    public function getArtNr()
    {
        return $this->artNr;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EdiItem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return EdiItem
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
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return EdiItem
     */
    public function setRetailprice($retailprice)
    {
        $this->retailprice = $retailprice;

        return $this;
    }

    /**
     * Get retailprice
     *
     * @return string
     */
    public function getRetailprice()
    {
        return $this->retailprice;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return EdiItem
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
     * @return EdiItem
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
     * @var \EdiBundle\Entity\Edi
     */
    private $Edi;


    /**
     * Set edi
     *
     * @param \EdiBundle\Entity\Edi $edi
     *
     * @return EdiItem
     */
    public function setEdi(\EdiBundle\Entity\Edi $edi = null)
    {
        $this->Edi = $edi;

        return $this;
    }

    /**
     * Get edi
     *
     * @return \EdiBundle\Entity\Edi
     */
    public function getEdi()
    {
        return $this->Edi;
    }
}
