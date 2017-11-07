<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * Invoice
 */
class Invoice extends Entity {

    private $repository = 'SoftoneBundle:Order';
    private $types = array();
    var $repositories = array();
    var $uniques = array();

    public function __construct() {
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

    /**
     * @var string
     */
    private $invoice;

    /**
     * @var string
     */
    private $schedule;

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
     * @var integer
     */
    private $id;

    /**
     * Set invoice
     *
     * @param string $invoice
     *
     * @return Invoice
     */
    public function setInvoice($invoice) {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return string
     */
    public function getInvoice() {
        return $this->invoice;
    }

    /**
     * Set schedule
     *
     * @param string $schedule
     *
     * @return Invoice
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
     * Set status
     *
     * @param integer $status
     *
     * @return Invoice
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
     * @return Invoice
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
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Invoice
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Invoice
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
     * @return Invoice
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;

    /**
     * Add item
     *
     * @param \SoftoneBundle\Entity\InvoiceItem $item
     *
     * @return Invoice
     */
    public function addItem(\SoftoneBundle\Entity\InvoiceItem $item) {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \SoftoneBundle\Entity\InvoiceItem $item
     */
    public function removeItem(\SoftoneBundle\Entity\InvoiceItem $item) {
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
     * @var integer
     */
    private $reference = '0';

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Invoice
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
     * @var \SoftoneBundle\Entity\Supplier
     */
    private $supplier;

    /**
     * Set supplier
     *
     * @param \SoftoneBundle\Entity\Supplier $supplier
     *
     * @return Invoice
     */
    public function setSupplier(\SoftoneBundle\Entity\Supplier $supplier = null) {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return \SoftoneBundle\Entity\Supplier
     */
    public function getSupplier() {
        return $this->supplier;
    }

}
