<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sisxetiseis
 *
 * @ORM\Table(name="sisxetiseis", indexes={@ORM\Index(name="sisxetisi", columns={"sisxetisi"}), @ORM\Index(name="product", columns={"product"})})
 * @ORM\Entity
 */
class Sisxetiseis
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
     * @ORM\Column(name="sisxetisi", type="integer", nullable=false)
     */
    private $sisxetisi;

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
     * @return Sisxetiseis
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
     * Set sisxetisi
     *
     * @param integer $sisxetisi
     *
     * @return Sisxetiseis
     */
    public function setSisxetisi($sisxetisi)
    {
        $this->sisxetisi = $sisxetisi;

        return $this;
    }

    /**
     * Get sisxetisi
     *
     * @return integer
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
