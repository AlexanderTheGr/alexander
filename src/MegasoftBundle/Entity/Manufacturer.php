<?php

namespace MegasoftBundle\Entity;
use AppBundle\Entity\Entity;
use AppBundle\Entity\Tecdoc as Tecdoc;
use MegasoftBundle\Entity\TecdocSupplier as TecdocSupplier;

/**
 * Manufacturer
 */
class Manufacturer extends Entity {

    var $repositories = array();
    var $uniques = array();

    public function setRepositories() {

        //$this->tecdocSupplierId = new \SoftoneBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {

        return $this->repositories[$repo];
    }

    public function gettype($field) {
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }
    
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
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set code
     *
     * @param string $code
     *
     * @return Manufacturer
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Manufacturer
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
