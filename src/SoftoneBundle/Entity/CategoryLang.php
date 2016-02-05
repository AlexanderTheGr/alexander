<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryLang
 *
 * @ORM\Table(name="category_lang", indexes={@ORM\Index(name="category", columns={"category"}), @ORM\Index(name="language", columns={"language"})})
 * @ORM\Entity
 */
class CategoryLang
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \SoftoneBundle\Entity\Language
     *
     * @ORM\ManyToOne(targetEntity="SoftoneBundle\Entity\Language")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="language", referencedColumnName="id")
     * })
     */
    protected $language;

    /**
     * @var \SoftoneBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="SoftoneBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    protected $category;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return CategoryLang
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set language
     *
     * @param \SoftoneBundle\Entity\Language $language
     *
     * @return CategoryLang
     */
    public function setLanguage(\SoftoneBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \SoftoneBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set category
     *
     * @param \SoftoneBundle\Entity\Category $category
     *
     * @return CategoryLang
     */
    public function setCategory(\SoftoneBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \SoftoneBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
