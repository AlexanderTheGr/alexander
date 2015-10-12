<?php

namespace AccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accesslog
 *
 * @ORM\Table(name="accesslog", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="user_id_2", columns={"user_id"})})
 * @ORM\Entity
 */
class Accesslog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=false)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="actiontype", type="string", length=255, nullable=false)
     */
    private $actiontype;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="text", length=65535, nullable=false)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", length=65535, nullable=false)
     */
    private $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    private $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Accesslog
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Accesslog
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set actiontype
     *
     * @param string $actiontype
     *
     * @return Accesslog
     */
    public function setActiontype($actiontype)
    {
        $this->actiontype = $actiontype;

        return $this;
    }

    /**
     * Get actiontype
     *
     * @return string
     */
    public function getActiontype()
    {
        return $this->actiontype;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Accesslog
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Accesslog
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Accesslog
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs()
    {
        return $this->ts;
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
