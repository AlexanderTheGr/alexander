<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Synafies
 *
 * @ORM\Table(name="synafies", indexes={@ORM\Index(name="id1", columns={"id1"}), @ORM\Index(name="id2", columns={"id2"})})
 * @ORM\Entity
 */
class Synafies
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id1", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id1;

    /**
     * @var integer
     *
     * @ORM\Column(name="id2", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id2;



    /**
     * Set id1
     *
     * @param integer $id1
     *
     * @return Synafies
     */
    public function setId1($id1)
    {
        $this->id1 = $id1;

        return $this;
    }

    /**
     * Get id1
     *
     * @return integer
     */
    public function getId1()
    {
        return $this->id1;
    }

    /**
     * Set id2
     *
     * @param integer $id2
     *
     * @return Synafies
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;

        return $this;
    }

    /**
     * Get id2
     *
     * @return integer
     */
    public function getId2()
    {
        return $this->id2;
    }
}
