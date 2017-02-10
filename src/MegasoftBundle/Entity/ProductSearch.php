<?php

namespace MegasoftBundle\Entity;

/**
 * ProductSearch
 */
class ProductSearch
{
    /**
     * @var string
     */
    private $erpCode;

    /**
     * @var string
     */
    private $tecdocCode;

    /**
     * @var string
     */
    private $supplierCode;

    /**
     * @var string
     */
    private $search;

    /**
     * @var string
     */
    private $sisxetisi = '';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set erpCode
     *
     * @param string $erpCode
     *
     * @return ProductSearch
     */
    public function setErpCode($erpCode)
    {
        $this->erpCode = $erpCode;

        return $this;
    }

    /**
     * Get erpCode
     *
     * @return string
     */
    public function getErpCode()
    {
        return $this->erpCode;
    }

    /**
     * Set tecdocCode
     *
     * @param string $tecdocCode
     *
     * @return ProductSearch
     */
    public function setTecdocCode($tecdocCode)
    {
        $this->tecdocCode = $tecdocCode;

        return $this;
    }

    /**
     * Get tecdocCode
     *
     * @return string
     */
    public function getTecdocCode()
    {
        return $this->tecdocCode;
    }

    /**
     * Set supplierCode
     *
     * @param string $supplierCode
     *
     * @return ProductSearch
     */
    public function setSupplierCode($supplierCode)
    {
        $this->supplierCode = $supplierCode;

        return $this;
    }

    /**
     * Get supplierCode
     *
     * @return string
     */
    public function getSupplierCode()
    {
        return $this->supplierCode;
    }

    /**
     * Set search
     *
     * @param string $search
     *
     * @return ProductSearch
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * Set sisxetisi
     *
     * @param string $sisxetisi
     *
     * @return ProductSearch
     */
    public function setSisxetisi($sisxetisi)
    {
        $this->sisxetisi = $sisxetisi;

        return $this;
    }

    /**
     * Get sisxetisi
     *
     * @return string
     */
    public function getSisxetisi()
    {
        return $this->sisxetisi;
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

