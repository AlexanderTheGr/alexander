<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCatalogueMap
 *
 * @ORM\Table(name="product_catalogue_map", indexes={@ORM\Index(name="catalogue", columns={"catalogue"}), @ORM\Index(name="catalogue_2", columns={"catalogue"})})
 * @ORM\Entity
 */
class ProductCatalogueMap
{
    /**
     * @var integer
     *
     * @ORM\Column(name="catalogue", type="integer", nullable=false)
     */
    protected $catalogue;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute", type="string", length=255, nullable=false)
     */
    protected $attribute;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="csvfield", type="integer", nullable=false)
     */
    protected $csvfield;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;



    /**
     * Set catalogue
     *
     * @param integer $catalogue
     *
     * @return ProductCatalogueMap
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * Get catalogue
     *
     * @return integer
     */
    public function getCatalogue()
    {
        return $this->catalogue;
    }

    /**
     * Set attribute
     *
     * @param string $attribute
     *
     * @return ProductCatalogueMap
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProductCatalogueMap
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set csvfield
     *
     * @param integer $csvfield
     *
     * @return ProductCatalogueMap
     */
    public function setCsvfield($csvfield)
    {
        $this->csvfield = $csvfield;

        return $this;
    }

    /**
     * Get csvfield
     *
     * @return integer
     */
    public function getCsvfield()
    {
        return $this->csvfield;
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
