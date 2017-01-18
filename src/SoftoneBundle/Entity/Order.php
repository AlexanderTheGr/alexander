<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * Order
 *
 * @ORM\Table(name="order", indexes={@ORM\Index(name="user_id", columns={"actioneer"}), @ORM\Index(name="customer", columns={"customer"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="store", columns={"store"}), @ORM\Index(name="route", columns={"route"})})
 * @ORM\Entity
 */
class Order extends Entity {

    private $repository = 'SoftoneBundle:Order';
    private $types = array();
    var $repositories = array();
    var $uniques = array();

    public function __construct() {
        $this->repositories['route'] = 'SoftoneBundle:Route';
        $this->repositories['customer'] = 'SoftoneBundle:Customer';
        $this->types['route'] = 'object';
        $this->route = new \SoftoneBundle\Entity\Route;
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->repositories['route'] = 'SoftoneBundle:Route';
        $this->repositories['customer'] = 'SoftoneBundle:Customer';
        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['route'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    protected $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    protected $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="store", type="integer", nullable=false)
     */
    protected $store = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="route", type="integer", nullable=false)
     */
    protected $route;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255, nullable=false)
     */
    protected $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name2", type="string", length=255, nullable=false)
     */
    protected $customerName2;

    /**
     * @var integer
     *
     * @ORM\Column(name="tfprms", type="integer", nullable=false)
     */
    protected $tfprms;

    /**
     * @var integer
     *
     * @ORM\Column(name="fprms", type="integer", nullable=false)
     */
    protected $fprms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insdate", type="datetime", nullable=false)
     */
    protected $insdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="seriesnum", type="integer", nullable=false)
     */
    protected $seriesnum;

    /**
     * @var integer
     *
     * @ORM\Column(name="series", type="integer", nullable=false)
     */
    protected $series;

    /**
     * @var string
     *
     * @ORM\Column(name="fincode", type="string", length=255, nullable=false)
     */
    protected $fincode;

    /**
     * @var string
     *
     * @ORM\Column(name="expn", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $expn;

    /**
     * @var string
     *
     * @ORM\Column(name="disc1prc", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $disc1prc;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", length=65535, nullable=false)
     */
    protected $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fullytrans", type="boolean", nullable=false)
     */
    protected $fullytrans;

    /**
     * @var integer
     *
     * @ORM\Column(name="trdbranch", type="integer", nullable=false)
     */
    protected $trdbranch;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", length=65535, nullable=false)
     */
    protected $remarks;

    /**
     * @var boolean
     *
     * @ORM\Column(name="noorder", type="boolean", nullable=false)
     */
    protected $noorder;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=true)
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
     * Set reference
     *
     * @param integer $reference
     *
     * @return Order
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
     * Set store
     *
     * @param integer $store
     *
     * @return Order
     */
    public function setStore($store) {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore() {
        return $this->store;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Order
     */
    public function setCustomerName($customerName) {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName() {
        return $this->customerName;
    }

    /**
     * Set customerName2
     *
     * @param string $customerName2
     *
     * @return Order
     */
    public function setCustomerName2($customerName2) {
        $this->customerName2 = $customerName2;

        return $this;
    }

    /**
     * Get customerName2
     *
     * @return string
     */
    public function getCustomerName2() {
        return $this->customerName2;
    }

    /**
     * Set tfprms
     *
     * @param integer $tfprms
     *
     * @return Order
     */
    public function setTfprms($tfprms) {
        $this->tfprms = $tfprms;

        return $this;
    }

    /**
     * Get tfprms
     *
     * @return integer
     */
    public function getTfprms() {
        return $this->tfprms;
    }

    /**
     * Set fprms
     *
     * @param integer $fprms
     *
     * @return Order
     */
    public function setFprms($fprms) {
        $this->fprms = $fprms;

        return $this;
    }

    /**
     * Get fprms
     *
     * @return integer
     */
    public function getFprms() {
        return $this->fprms;
    }

    /**
     * Set insdate
     *
     * @param \DateTime $insdate
     *
     * @return Order
     */
    public function setInsdate($insdate) {
        $this->insdate = $insdate;

        return $this;
    }

    /**
     * Get insdate
     *
     * @return \DateTime
     */
    public function getInsdate() {
        return $this->insdate;
    }

    /**
     * Set seriesnum
     *
     * @param integer $seriesnum
     *
     * @return Order
     */
    public function setSeriesnum($seriesnum) {
        $this->seriesnum = $seriesnum;

        return $this;
    }

    /**
     * Get seriesnum
     *
     * @return integer
     */
    public function getSeriesnum() {
        return $this->seriesnum;
    }

    /**
     * Set series
     *
     * @param integer $series
     *
     * @return Order
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
     * Set fincode
     *
     * @param string $fincode
     *
     * @return Order
     */
    public function setFincode($fincode) {
        $this->fincode = $fincode;

        return $this;
    }

    /**
     * Get fincode
     *
     * @return string
     */
    public function getFincode() {
        return $this->fincode;
    }

    /**
     * Set expn
     *
     * @param string $expn
     *
     * @return Order
     */
    public function setExpn($expn) {
        $this->expn = $expn;

        return $this;
    }

    /**
     * Get expn
     *
     * @return string
     */
    public function getExpn() {
        return $this->expn;
    }

    /**
     * Set disc1prc
     *
     * @param string $disc1prc
     *
     * @return Order
     */
    public function setDisc1prc($disc1prc) {
        $this->disc1prc = $disc1prc;

        return $this;
    }

    /**
     * Get disc1prc
     *
     * @return string
     */
    public function getDisc1prc() {
        return $this->disc1prc;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Order
     */
    public function setComments($comments) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Set fullytrans
     *
     * @param boolean $fullytrans
     *
     * @return Order
     */
    public function setFullytrans($fullytrans) {
        $this->fullytrans = $fullytrans;

        return $this;
    }

    /**
     * Get fullytrans
     *
     * @return boolean
     */
    public function getFullytrans() {
        return $this->fullytrans;
    }

    /**
     * Set trdbranch
     *
     * @param integer $trdbranch
     *
     * @return Order
     */
    public function setTrdbranch($trdbranch) {
        $this->trdbranch = $trdbranch;

        return $this;
    }

    /**
     * Get trdbranch
     *
     * @return integer
     */
    public function getTrdbranch() {
        return $this->trdbranch;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Order
     */
    public function setRemarks($remarks) {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks() {
        return $this->remarks;
    }

    /**
     * Set noorder
     *
     * @param boolean $noorder
     *
     * @return Order
     */
    public function setNoorder($noorder) {
        $this->noorder = $noorder;

        return $this;
    }

    /**
     * Get noorder
     *
     * @return boolean
     */
    public function getNoorder() {
        return $this->noorder;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\AppBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set route
     *
     * @param \SoftoneBundle\Entity\Route $route
     *
     * @return Order
     */
    public function setRoute(\SoftoneBundle\Entity\Route $route = null) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \SoftoneBundle\Entity\Route
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * @var \DateTime
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Order
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;

    /**
     * Add item
     *
     * @param \SoftoneBundle\Entity\Orderitem $item
     *
     * @return Order
     */
    public function addItem(\SoftoneBundle\Entity\Orderitem $item) {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \SoftoneBundle\Entity\Orderitem $item
     */
    public function removeItem(\SoftoneBundle\Entity\Orderitem $item) {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * @var \SoftoneBundle\Entity\Vat
     */
    private $vat;

    /**
     * Set vat
     *
     * @param \SoftoneBundle\Entity\Vat $vat
     *
     * @return Order
     */
    public function setVat(\SoftoneBundle\Entity\Vat $vat = null) {
        $this->vat = $vat;

        return $this;
    }

    /**
     * Get vat
     *
     * @return \SoftoneBundle\Entity\Vat
     */
    public function getVat() {
        return $this->vat;
    }

    /**
     * @var \SoftoneBundle\Entity\Customer
     */
    private $customer;

    /**
     * Set customer
     *
     * @param \SoftoneBundle\Entity\Customer $customer
     *
     * @return Order
     */
    public function setCustomer(\SoftoneBundle\Entity\Customer $customer = null) {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \SoftoneBundle\Entity\Customer
     */
    public function getCustomer() {
        return $this->customer;
    }

    
    function getTotal() {
        return 0;
    }
}
