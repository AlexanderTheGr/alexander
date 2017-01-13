<?php

namespace EdiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * Edi
 */
class Edi extends Entity {

    public function __construct() {
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:SoftoneSupplier';
        //$this->types['tecdocSupplierId'] = 'object';
        //$this->tecdocSupplierId = new \SoftoneBundle\Entity\SoftoneSupplier;
    }

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:SoftoneSupplier';
        return $this->repositories[$repo];
    }

    public function gettype($field) {
        //$this->types['tecdocSupplierId'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    /**
     * @var string
     */
    var $name;

    /**
     * @var string
     */
    var $token;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var string
     */
    //private $retailprice;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Edi
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Edi
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Edi
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Edi
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
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return Edi
     */
    public function setRetailprice($retailprice) {
        $this->retailprice = $retailprice;

        return $this;
    }

    /**
     * Get retailprice
     *
     * @return string
     */
    public function getRetailprice() {
        return $this->retailprice;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Edi
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
     * @return Edi
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
     * @var string
     */
    private $func;

    /**
     * Set func
     *
     * @param string $func
     *
     * @return Edi
     */
    public function setFunc($func) {
        $this->func = $func;

        return $this;
    }

    /**
     * Get func
     *
     * @return string
     */
    public function getFunc() {
        return $this->func;
    }

    /**
     * Get customeredirules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEdirules() {
        return $this->edirules;
    }

    private $rules = array();

    public function loadEdirules($pricefield = false) {
        //if ($this->reference)
        //if (count($this->rules) > 0)
        //    return $this;
        $this->rules = array();
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        if ($pricefield) {
            $edirules = $em->getRepository('EdiBundle:Edirule')->findBy(array("edi" => $this, 'price_field' => $pricefield), array('sortorder' => 'ASC'));
            foreach ((array) $edirules as $edirule) {
                if ($pricefield == $edirule->getPriceField()) {
                    $this->rules[] = $edirule;
                }
            }
        } else {
            $edirules = $em->getRepository('EdiBundle:Edirule')->findBy(array("edi" => $this), array('sortorder' => 'ASC'));
            foreach ((array) $edirules as $edirule) {
                //if ($pricefield == $edirule->getPriceField()) {
                $this->rules[] = $edirule;
                //}
            }
        }
        //echo count($edirules);    


        return $this;
    }

    public function getRules() {
        return $this->rules;
    }

    /**
     * @var integer
     */
    private $itemMtrsup;


    /**
     * Set itemMtrsup
     *
     * @param integer $itemMtrsup
     *
     * @return Edi
     */
    public function setItemMtrsup($itemMtrsup)
    {
        $this->itemMtrsup = $itemMtrsup;

        return $this;
    }

    /**
     * Get itemMtrsup
     *
     * @return integer
     */
    public function getItemMtrsup()
    {
        return $this->itemMtrsup;
    }
    /**
     * @var string
     */
    private $markup;


    /**
     * Set markup
     *
     * @param string $markup
     *
     * @return Edi
     */
    public function setMarkup($markup)
    {
        $this->markup = $markup;

        return $this;
    }

    /**
     * Get markup
     *
     * @return string
     */
    public function getMarkup()
    {
        return $this->markup;
    }
}
