<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Route
 *
 * @ORM\Table(name="route")
 * @ORM\Entity
 */
class Route {

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=false)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="string", length=255, nullable=false)
     */
    private $schedule;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    protected $products;

    public function __construct() {
        $this->products = new ArrayCollection();
    }

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

    public function getField($field) {
        return $this->$field;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $customers;

    /**
     * Add customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Route
     */
    public function addCustomer(\AppBundle\Entity\Customer $customer) {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \AppBundle\Entity\Customer $customer
     */
    public function removeCustomer(\AppBundle\Entity\Customer $customer) {
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

}
