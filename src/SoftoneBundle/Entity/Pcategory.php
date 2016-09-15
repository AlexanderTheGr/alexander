<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * Pcategory
 *
 * @ORM\Table(name="pcategory", indexes={@ORM\Index(name="reference", columns={"reference"})})
 * @ORM\Entity
 */
class Pcategory extends Entity {

    public function getField($field) {
        return $this->$field;
    }

    public function setRepositories() {
        
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    var $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="itecategory_mtrcategory", type="integer", nullable=false)
     */
    protected $itecategoryMtrcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="itecategory_code", type="string", length=255, nullable=false)
     */
    protected $itecategoryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="itecategory_name", type="string", length=255, nullable=false)
     */
    protected $itecategoryName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=false)
     */
    protected $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    protected $modified;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_data", type="text", length=65535, nullable=false)
     */
    protected $flatData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Pcategory
     */
    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * Set itecategoryMtrcategory
     *
     * @param integer $itecategoryMtrcategory
     *
     * @return Pcategory
     */
    public function setItecategoryMtrcategory($itecategoryMtrcategory) {
        $this->itecategoryMtrcategory = $itecategoryMtrcategory;

        return $this;
    }

    /**
     * Get itecategoryMtrcategory
     *
     * @return integer
     */
    public function getItecategoryMtrcategory() {
        return $this->itecategoryMtrcategory;
    }

    /**
     * Set itecategoryCode
     *
     * @param string $itecategoryCode
     *
     * @return Pcategory
     */
    public function setItecategoryCode($itecategoryCode) {
        $this->itecategoryCode = $itecategoryCode;

        return $this;
    }

    /**
     * Get itecategoryCode
     *
     * @return string
     */
    public function getItecategoryCode() {
        return $this->itecategoryCode;
    }

    /**
     * Set itecategoryName
     *
     * @param string $itecategoryName
     *
     * @return Pcategory
     */
    public function setItecategoryName($itecategoryName) {
        $this->itecategoryName = $itecategoryName;

        return $this;
    }

    /**
     * Get itecategoryName
     *
     * @return string
     */
    public function getItecategoryName() {
        return $this->itecategoryName;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Pcategory
     */
    public function setTs($ts) {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs() {
        return $this->ts;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Pcategory
     */
    public function setActioneer($actioneer) {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer() {
        return $this->actioneer;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Pcategory
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Pcategory
     */
    public function setModified($modified) {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * Set flatData
     *
     * @param string $flatData
     *
     * @return Pcategory
     */
    public function setFlatData($flatData) {
        $this->flatData = $flatData;

        return $this;
    }

    /**
     * Get flatData
     *
     * @return string
     */
    public function getFlatData() {
        return $this->flatData;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

}
