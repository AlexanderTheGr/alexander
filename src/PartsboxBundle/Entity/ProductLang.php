<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductLang
 *
 * @ORM\Table(name="product_lang", indexes={@ORM\Index(name="language", columns={"language"}), @ORM\Index(name="product", columns={"product"})})
 * @ORM\Entity
 */
class ProductLang
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product", type="integer", nullable=false)
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="language", type="integer", nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="tecdoc_article_name", type="string", length=255, nullable=false)
     */
    private $tecdocArticleName;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set product
     *
     * @param integer $product
     *
     * @return ProductLang
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return integer
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set language
     *
     * @param integer $language
     *
     * @return ProductLang
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return integer
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ProductLang
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set tecdocArticleName
     *
     * @param string $tecdocArticleName
     *
     * @return ProductLang
     */
    public function setTecdocArticleName($tecdocArticleName)
    {
        $this->tecdocArticleName = $tecdocArticleName;

        return $this;
    }

    /**
     * Get tecdocArticleName
     *
     * @return string
     */
    public function getTecdocArticleName()
    {
        return $this->tecdocArticleName;
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
