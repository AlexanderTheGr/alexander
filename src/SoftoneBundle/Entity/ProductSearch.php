<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductSearch
 *
 * @ORM\Table(name="product_search", indexes={@ORM\Index(name="item_code", columns={"item_code"}), @ORM\Index(name="search", columns={"search"}), @ORM\Index(name="gnisia", columns={"gnisia"}), @ORM\Index(name="item_code1", columns={"item_code1"}), @ORM\Index(name="item_code2", columns={"item_code2"}), @ORM\Index(name="item_code_2", columns={"item_code"}), @ORM\Index(name="item_code1_2", columns={"item_code1"}), @ORM\Index(name="item_code2_2", columns={"item_code2"})})
 * @ORM\Entity
 */
class ProductSearch
{
    /**
     * @var string
     *
     * @ORM\Column(name="item_code", type="string", length=255, nullable=false)
     */
    private $itemCode;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code1", type="string", length=255, nullable=false)
     */
    private $itemCode1;

    /**
     * @var string
     *
     * @ORM\Column(name="item_code2", type="string", length=255, nullable=false)
     */
    private $itemCode2;

    /**
     * @var string
     *
     * @ORM\Column(name="search", type="string", length=255, nullable=false)
     */
    private $search;

    /**
     * @var string
     *
     * @ORM\Column(name="gnisia", type="string", length=255, nullable=false)
     */
    private $gnisia;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return ProductSearch
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
     * Set itemCode1
     *
     * @param string $itemCode1
     *
     * @return ProductSearch
     */
    public function setItemCode1($itemCode1)
    {
        $this->itemCode1 = $itemCode1;

        return $this;
    }

    /**
     * Get itemCode1
     *
     * @return string
     */
    public function getItemCode1()
    {
        return $this->itemCode1;
    }

    /**
     * Set itemCode2
     *
     * @param string $itemCode2
     *
     * @return ProductSearch
     */
    public function setItemCode2($itemCode2)
    {
        $this->itemCode2 = $itemCode2;

        return $this;
    }

    /**
     * Get itemCode2
     *
     * @return string
     */
    public function getItemCode2()
    {
        return $this->itemCode2;
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
     * Set gnisia
     *
     * @param string $gnisia
     *
     * @return ProductSearch
     */
    public function setGnisia($gnisia)
    {
        $this->gnisia = $gnisia;

        return $this;
    }

    /**
     * Get gnisia
     *
     * @return string
     */
    public function getGnisia()
    {
        return $this->gnisia;
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
