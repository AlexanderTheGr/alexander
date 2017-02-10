<?php

namespace MegasoftBundle\Entity;

/**
 * ProductFreesearch
 */
class ProductFreesearch
{
    /**
     * @var string
     */
    private $dataIndex;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set dataIndex
     *
     * @param string $dataIndex
     *
     * @return ProductFreesearch
     */
    public function setDataIndex($dataIndex)
    {
        $this->dataIndex = $dataIndex;

        return $this;
    }

    /**
     * Get dataIndex
     *
     * @return string
     */
    public function getDataIndex()
    {
        return $this->dataIndex;
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
