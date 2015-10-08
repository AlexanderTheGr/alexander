<?php

namespace PartsboxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Order2
 *
 * @ORM\Table(name="order2", indexes={@ORM\Index(name="user_id", columns={"actioneer"}), @ORM\Index(name="customer", columns={"customer"}), @ORM\Index(name="status", columns={"status"}), @ORM\Index(name="store", columns={"store"})})
 * @ORM\Entity
 */
class Order2
{
    /**
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="user", type="integer", nullable=false)
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="store", type="integer", nullable=false)
     */
    private $store = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="customer", type="integer", nullable=false)
     */
    private $customer;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer_ref", type="integer", nullable=false)
     */
    private $customerRef;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255, nullable=false)
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name2", type="string", length=255, nullable=false)
     */
    private $customerName2;

    /**
     * @var integer
     *
     * @ORM\Column(name="tfprms", type="integer", nullable=false)
     */
    private $tfprms;

    /**
     * @var integer
     *
     * @ORM\Column(name="fprms", type="integer", nullable=false)
     */
    private $fprms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insdate", type="datetime", nullable=false)
     */
    private $insdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="seriesnum", type="integer", nullable=false)
     */
    private $seriesnum;

    /**
     * @var integer
     *
     * @ORM\Column(name="series", type="integer", nullable=false)
     */
    private $series;

    /**
     * @var string
     *
     * @ORM\Column(name="fincode", type="string", length=255, nullable=false)
     */
    private $fincode;

    /**
     * @var string
     *
     * @ORM\Column(name="disc1prc", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $disc1prc;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", length=65535, nullable=false)
     */
    private $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fullytrans", type="boolean", nullable=false)
     */
    private $fullytrans;

    /**
     * @var integer
     *
     * @ORM\Column(name="trdbranch", type="integer", nullable=false)
     */
    private $trdbranch;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", length=65535, nullable=false)
     */
    private $remarks;

    /**
     * @var boolean
     *
     * @ORM\Column(name="noorder", type="boolean", nullable=false)
     */
    private $noorder;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=true)
     */
    private $actioneer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime", nullable=false)
     */
    private $modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Order2
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return Order2
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set store
     *
     * @param integer $store
     *
     * @return Order2
     */
    public function setStore($store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return integer
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set customer
     *
     * @param integer $customer
     *
     * @return Order2
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
     * Set customerRef
     *
     * @param integer $customerRef
     *
     * @return Order2
     */
    public function setCustomerRef($customerRef)
    {
        $this->customerRef = $customerRef;

        return $this;
    }

    /**
     * Get customerRef
     *
     * @return integer
     */
    public function getCustomerRef()
    {
        return $this->customerRef;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Order2
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerName2
     *
     * @param string $customerName2
     *
     * @return Order2
     */
    public function setCustomerName2($customerName2)
    {
        $this->customerName2 = $customerName2;

        return $this;
    }

    /**
     * Get customerName2
     *
     * @return string
     */
    public function getCustomerName2()
    {
        return $this->customerName2;
    }

    /**
     * Set tfprms
     *
     * @param integer $tfprms
     *
     * @return Order2
     */
    public function setTfprms($tfprms)
    {
        $this->tfprms = $tfprms;

        return $this;
    }

    /**
     * Get tfprms
     *
     * @return integer
     */
    public function getTfprms()
    {
        return $this->tfprms;
    }

    /**
     * Set fprms
     *
     * @param integer $fprms
     *
     * @return Order2
     */
    public function setFprms($fprms)
    {
        $this->fprms = $fprms;

        return $this;
    }

    /**
     * Get fprms
     *
     * @return integer
     */
    public function getFprms()
    {
        return $this->fprms;
    }

    /**
     * Set insdate
     *
     * @param \DateTime $insdate
     *
     * @return Order2
     */
    public function setInsdate($insdate)
    {
        $this->insdate = $insdate;

        return $this;
    }

    /**
     * Get insdate
     *
     * @return \DateTime
     */
    public function getInsdate()
    {
        return $this->insdate;
    }

    /**
     * Set seriesnum
     *
     * @param integer $seriesnum
     *
     * @return Order2
     */
    public function setSeriesnum($seriesnum)
    {
        $this->seriesnum = $seriesnum;

        return $this;
    }

    /**
     * Get seriesnum
     *
     * @return integer
     */
    public function getSeriesnum()
    {
        return $this->seriesnum;
    }

    /**
     * Set series
     *
     * @param integer $series
     *
     * @return Order2
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
    }

    /**
     * Get series
     *
     * @return integer
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Set fincode
     *
     * @param string $fincode
     *
     * @return Order2
     */
    public function setFincode($fincode)
    {
        $this->fincode = $fincode;

        return $this;
    }

    /**
     * Get fincode
     *
     * @return string
     */
    public function getFincode()
    {
        return $this->fincode;
    }

    /**
     * Set disc1prc
     *
     * @param string $disc1prc
     *
     * @return Order2
     */
    public function setDisc1prc($disc1prc)
    {
        $this->disc1prc = $disc1prc;

        return $this;
    }

    /**
     * Get disc1prc
     *
     * @return string
     */
    public function getDisc1prc()
    {
        return $this->disc1prc;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Order2
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set fullytrans
     *
     * @param boolean $fullytrans
     *
     * @return Order2
     */
    public function setFullytrans($fullytrans)
    {
        $this->fullytrans = $fullytrans;

        return $this;
    }

    /**
     * Get fullytrans
     *
     * @return boolean
     */
    public function getFullytrans()
    {
        return $this->fullytrans;
    }

    /**
     * Set trdbranch
     *
     * @param integer $trdbranch
     *
     * @return Order2
     */
    public function setTrdbranch($trdbranch)
    {
        $this->trdbranch = $trdbranch;

        return $this;
    }

    /**
     * Get trdbranch
     *
     * @return integer
     */
    public function getTrdbranch()
    {
        return $this->trdbranch;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return Order2
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set noorder
     *
     * @param boolean $noorder
     *
     * @return Order2
     */
    public function setNoorder($noorder)
    {
        $this->noorder = $noorder;

        return $this;
    }

    /**
     * Get noorder
     *
     * @return boolean
     */
    public function getNoorder()
    {
        return $this->noorder;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Order2
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
     * @return Order2
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Order2
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
     * @return Order2
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
