<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebserviceProduct
 *
 * @ORM\Table(name="webservice_product", uniqueConstraints={@ORM\UniqueConstraint(name="product_2", columns={"product", "webservice"})}, indexes={@ORM\Index(name="product", columns={"product"}), @ORM\Index(name="webservice", columns={"webservice"}), @ORM\Index(name="article_id", columns={"article_id"})})
 * @ORM\Entity
 */
class WebserviceProduct
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
     * @ORM\Column(name="webservice", type="integer", nullable=false)
     */
    private $webservice;

    /**
     * @var integer
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var string
     *
     * @ORM\Column(name="article_name", type="string", length=255, nullable=false)
     */
    private $articleName;

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
     * @return WebserviceProduct
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
     * Set webservice
     *
     * @param integer $webservice
     *
     * @return WebserviceProduct
     */
    public function setWebservice($webservice)
    {
        $this->webservice = $webservice;

        return $this;
    }

    /**
     * Get webservice
     *
     * @return integer
     */
    public function getWebservice()
    {
        return $this->webservice;
    }

    /**
     * Set articleId
     *
     * @param integer $articleId
     *
     * @return WebserviceProduct
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get articleId
     *
     * @return integer
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set articleName
     *
     * @param string $articleName
     *
     * @return WebserviceProduct
     */
    public function setArticleName($articleName)
    {
        $this->articleName = $articleName;

        return $this;
    }

    /**
     * Get articleName
     *
     * @return string
     */
    public function getArticleName()
    {
        return $this->articleName;
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
