<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * Reportmodel
 *
 * @ORM\Table(name="reportmodel", indexes={@ORM\Index(name="customer_id", columns={"customer_id"})})
 * @ORM\Entity
 */
class Reportmodel extends Entity {

    var $repositories = array();
    var $uniques = array();
    var $qty;

    public function __construct() {
        $this->setRepositories();
    }

    public function getField($field) {

        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }
    public function setRepositories() {
    }
    public function getRepository() {
        return $this->repository;
    }
    public function getRepositories($repo) {
        return $this->repositories[$repo];
    }    
    /**
     * @var integer
     *
     * @ORM\Column(name="customer_id", type="integer", nullable=false)
     */
    protected $customerId;

    /**
     * @var integer
     *
     * @ORM\Column(name="model", type="integer", nullable=false)
     */
    protected $model;

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=255, nullable=false)
     */
    protected $sessionId;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=20, nullable=false)
     */
    protected $ip;

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
    protected $id;

    /**
     * Set customerId
     *
     * @param integer $customerId
     *
     * @return Reportmodel
     */
    public function setCustomerId($customerId) {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return integer
     */
    public function getCustomerId() {
        return $this->customerId;
    }

    /**
     * Set model
     *
     * @param integer $model
     *
     * @return Reportmodel
     */
    public function setModel($model) {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return integer
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     *
     * @return Reportmodel
     */
    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Reportmodel
     */
    public function setIp($ip) {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp() {
        return $this->ip;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Reportmodel
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
     * @return Reportmodel
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
     * @return Reportmodel
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
     * @return Reportmodel
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
     * @return Reportmodel
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
