<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Entity;
/**
 * Store
 *
 * @ORM\Table(name="store")
 * @ORM\Entity
 */
class Store extends Entity {

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="series", type="integer", nullable=false)
     */
    protected $series;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=255, nullable=false)
     */
    protected $field;

    /**
     * @var string
     *
     * @ORM\Column(name="field2", type="string", length=255, nullable=false)
     */
    protected $field2;

    /**
     * @var string
     *
     * @ORM\Column(name="rafi", type="string", length=255, nullable=false)
     */
    protected $rafi;

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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Store
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set series
     *
     * @param integer $series
     *
     * @return Store
     */
    public function setSeries($series) {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return integer
     */
    public function getSeries() {
        return $this->series;
    }



    /**
     * Set rafi
     *
     * @param string $rafi
     *
     * @return Store
     */
    public function setRafi($rafi) {
        $this->rafi = $rafi;

        return $this;
    }

    /**
     * Get rafi
     *
     * @return string
     */
    public function getRafi() {
        return $this->rafi;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Store
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
     * @return Store
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
     * @return Store
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
     * @return Store
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set field2
     *
     * @param string $field2
     *
     * @return Store
     */
    public function setField2($field2)
    {
        $this->field2 = $field2;

        return $this;
    }

    /**
     * Get field2
     *
     * @return string
     */
    public function getField2()
    {
        return $this->field2;
    }
}
