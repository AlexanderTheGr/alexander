<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * Customergroup
 *
 * @ORM\Table(name="customergroup")
 * @ORM\Entity
 */
class Customergroup extends Entity {

    var $repositories = array();

    public function __construct() {
        //$this->customergrouprules = new \Doctrine\Common\Collections\ArrayCollection();
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
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:TecdocSupplier';
        $this->types['tecdocSupplierId'] = 'object';
        //$this->tecdocSupplierId = new \SoftoneBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:TecdocSupplier';
        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['tecdocSupplierId'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    function createName($str) {
        $strArr = explode("_", $str);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        $strArr = explode(".", $b);
        $i = 0;
        $b = "";
        foreach ($strArr as $a) {
            $b .= ucfirst($a);
        }
        return $b;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="base_price", type="string", length=255, nullable=false)
     */
    protected $basePrice;

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
     * @return Customergroup
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
     * Set basePrice
     *
     * @param string $basePrice
     *
     * @return Customergroup
     */
    public function setBasePrice($basePrice) {
        $this->basePrice = $basePrice;

        return $this;
    }

    /**
     * Get basePrice
     *
     * @return string
     */
    public function getBasePrice() {
        return $this->basePrice;
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
     * @var \DateTime
     */
    private $ts;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Customergroup
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
     * @return Customergroup
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
     * @return Customergroup
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
     * @return Customergroup
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $customergrouprules;

    /**
     * Add customergrouprule
     *
     * @param \SoftoneBundle\Entity\Customergrouprule $customergrouprule
     *
     * @return Customergroup
     */
    public function addCustomergrouprule(\SoftoneBundle\Entity\Customergrouprule $customergrouprule) {
        $this->customergrouprules[] = $customergrouprule;
        return $this;
    }

    /**
     * Remove customergrouprule
     *
     * @param \SoftoneBundle\Entity\Customergrouprule $customergrouprule
     */
    public function removeCustomergrouprule(\SoftoneBundle\Entity\Customergrouprule $customergrouprule) {
        $this->customergrouprules->removeElement($customergrouprule);
    }

    /**
     * Get customergrouprules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomergrouprules() {
        return $this->customergrouprules;
    }
    
    private $rules = array();
    public function loadCustomergrouprules() {
        //if ($this->reference)
        if (count($this->rules) > 0) return $this;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');        
        $grouprules = $em->getRepository('SoftoneBundle:Customergrouprule')->findBy( array("group"=>$this));
        foreach ((array)$grouprules as $grouprule) {
            $this->rules[] = $grouprule;
            
        }
  
        return $this;
    }
    public function getRules() {
        return $this->rules;
    }
}
