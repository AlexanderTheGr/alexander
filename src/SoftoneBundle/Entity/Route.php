<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * Route
 *
 * @ORM\Table(name="route")
 * @ORM\Entity
 */
class Route extends Entity {

    var $repository = 'SoftoneBundle:Route';
    private $types = array();
    private $repositories = array();

    public function __construct() {
        $this->repositories['Order'] = 'BookingBundle:Order';
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->repositories['Order'] = 'BookingBundle:Order';
        return  $this->repositories[$repo];
    }
    public function gettype($field) {
        //return;
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
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=false)
     */
    protected $route;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="string", length=255, nullable=false)
     */
    protected $schedule;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    protected $products;

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Route
     */
    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * Set schedule
     *
     * @param string $schedule
     *
     * @return Route
     */
    public function setSchedule($schedule) {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return string
     */
    public function getSchedule() {
        return $this->schedule;
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
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $customers;

    /**
     * Add customer
     *
     * @param \SoftoneBundle\Entity\Customer $customer
     *
     * @return Route
     */
    public function addCustomer(\SoftoneBundle\Entity\Customer $customer) {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \SoftoneBundle\Entity\Customer $customer
     */
    public function removeCustomer(\SoftoneBundle\Entity\Customer $customer) {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers() {
        return $this->customers;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orders;

    /**
     * Add order
     *
     * @param \SoftoneBundle\Entity\Order $order
     *
     * @return Route
     */
    public function addOrder(\SoftoneBundle\Entity\Order $order) {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \SoftoneBundle\Entity\Order $order
     */
    public function removeOrder(\SoftoneBundle\Entity\Order $order) {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var \DateTime
     */
    private $ts;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;


    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Route
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Route
     */
    public function setActioneer($actioneer)
    {
        $this->actioneer = $actioneer;

        return $this;
    }

    /**
     * Get actioneer
     *
     * @return integer
     */
    public function getActioneer()
    {
        return $this->actioneer;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Route
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Route
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Route
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }
}
