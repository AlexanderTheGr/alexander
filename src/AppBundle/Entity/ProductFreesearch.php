<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductFreesearch
 *
 * @ORM\Table(name="product_freesearch", indexes={@ORM\Index(name="data_index", columns={"data_index"})})
 * @ORM\Entity
 */
class ProductFreesearch
{
    /**
     * @var string
     *
     * @ORM\Column(name="data_index", type="text", length=65535, nullable=false)
     */
    private $dataIndex;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
