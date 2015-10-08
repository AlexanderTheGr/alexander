<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routecustomer
 *
 * @ORM\Table(name="routecustomer", indexes={@ORM\Index(name="route", columns={"route"}), @ORM\Index(name="customer", columns={"customer"})})
 * @ORM\Entity
 */
class Routecustomer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="route", type="integer", nullable=false)
     */
    private $route;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer", type="integer", nullable=false)
     */
    private $customer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="default", type="boolean", nullable=false)
     */
    private $default;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set route
     *
     * @param integer $route
     *
     * @return Routecustomer
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return integer
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set customer
     *
     * @param integer $customer
     *
     * @return Routecustomer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return integer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set default
     *
     * @param boolean $default
     *
     * @return Routecustomer
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get default
     *
     * @return boolean
     */
    public function getDefault()
    {
        return $this->default;
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
