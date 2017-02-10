<?php

namespace MegasoftBundle\Entity;

/**
 * Customer
 */
class Customer
{
    /**
     * @var integer
     */
    private $reference;

    /**
     * @var integer
     */
    private $group;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $customerCode;

    /**
     * @var string
     */
    private $customerName;

    /**
     * @var string
     */
    private $customerAfm;

    /**
     * @var string
     */
    private $customerAddress;

    /**
     * @var string
     */
    private $customerCity;

    /**
     * @var string
     */
    private $customerEmail;

    /**
     * @var integer
     */
    private $customerZip;

    /**
     * @var string
     */
    private $customerPhone1;

    /**
     * @var string
     */
    private $customerPhone2;

    /**
     * @var string
     */
    private $customerFax;

    /**
     * @var string
     */
    private $customerWebpage;

    /**
     * @var string
     */
    private $customerIrsdata;

    /**
     * @var string
     */
    private $customerJobtypetrd;

    /**
     * @var integer
     */
    private $customerPayment;

    /**
     * @var integer
     */
    private $customerTrdcategory;

    /**
     * @var integer
     */
    private $customerVatsts;

    /**
     * @var string
     */
    private $priceField;

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
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;

    /**
     * @var \MegasoftBundle\Entity\Customergroup
     */
    private $customergroup;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Customer
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
     * Set group
     *
     * @param integer $group
     *
     * @return Customer
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return integer
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Customer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set customerCode
     *
     * @param string $customerCode
     *
     * @return Customer
     */
    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;

        return $this;
    }

    /**
     * Get customerCode
     *
     * @return string
     */
    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Customer
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
     * Set customerAfm
     *
     * @param string $customerAfm
     *
     * @return Customer
     */
    public function setCustomerAfm($customerAfm)
    {
        $this->customerAfm = $customerAfm;

        return $this;
    }

    /**
     * Get customerAfm
     *
     * @return string
     */
    public function getCustomerAfm()
    {
        return $this->customerAfm;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     *
     * @return Customer
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     *
     * @return Customer
     */
    public function setCustomerCity($customerCity)
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string
     */
    public function getCustomerCity()
    {
        return $this->customerCity;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return Customer
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * Set customerZip
     *
     * @param integer $customerZip
     *
     * @return Customer
     */
    public function setCustomerZip($customerZip)
    {
        $this->customerZip = $customerZip;

        return $this;
    }

    /**
     * Get customerZip
     *
     * @return integer
     */
    public function getCustomerZip()
    {
        return $this->customerZip;
    }

    /**
     * Set customerPhone1
     *
     * @param string $customerPhone1
     *
     * @return Customer
     */
    public function setCustomerPhone1($customerPhone1)
    {
        $this->customerPhone1 = $customerPhone1;

        return $this;
    }

    /**
     * Get customerPhone1
     *
     * @return string
     */
    public function getCustomerPhone1()
    {
        return $this->customerPhone1;
    }

    /**
     * Set customerPhone2
     *
     * @param string $customerPhone2
     *
     * @return Customer
     */
    public function setCustomerPhone2($customerPhone2)
    {
        $this->customerPhone2 = $customerPhone2;

        return $this;
    }

    /**
     * Get customerPhone2
     *
     * @return string
     */
    public function getCustomerPhone2()
    {
        return $this->customerPhone2;
    }

    /**
     * Set customerFax
     *
     * @param string $customerFax
     *
     * @return Customer
     */
    public function setCustomerFax($customerFax)
    {
        $this->customerFax = $customerFax;

        return $this;
    }

    /**
     * Get customerFax
     *
     * @return string
     */
    public function getCustomerFax()
    {
        return $this->customerFax;
    }

    /**
     * Set customerWebpage
     *
     * @param string $customerWebpage
     *
     * @return Customer
     */
    public function setCustomerWebpage($customerWebpage)
    {
        $this->customerWebpage = $customerWebpage;

        return $this;
    }

    /**
     * Get customerWebpage
     *
     * @return string
     */
    public function getCustomerWebpage()
    {
        return $this->customerWebpage;
    }

    /**
     * Set customerIrsdata
     *
     * @param string $customerIrsdata
     *
     * @return Customer
     */
    public function setCustomerIrsdata($customerIrsdata)
    {
        $this->customerIrsdata = $customerIrsdata;

        return $this;
    }

    /**
     * Get customerIrsdata
     *
     * @return string
     */
    public function getCustomerIrsdata()
    {
        return $this->customerIrsdata;
    }

    /**
     * Set customerJobtypetrd
     *
     * @param string $customerJobtypetrd
     *
     * @return Customer
     */
    public function setCustomerJobtypetrd($customerJobtypetrd)
    {
        $this->customerJobtypetrd = $customerJobtypetrd;

        return $this;
    }

    /**
     * Get customerJobtypetrd
     *
     * @return string
     */
    public function getCustomerJobtypetrd()
    {
        return $this->customerJobtypetrd;
    }

    /**
     * Set customerPayment
     *
     * @param integer $customerPayment
     *
     * @return Customer
     */
    public function setCustomerPayment($customerPayment)
    {
        $this->customerPayment = $customerPayment;

        return $this;
    }

    /**
     * Get customerPayment
     *
     * @return integer
     */
    public function getCustomerPayment()
    {
        return $this->customerPayment;
    }

    /**
     * Set customerTrdcategory
     *
     * @param integer $customerTrdcategory
     *
     * @return Customer
     */
    public function setCustomerTrdcategory($customerTrdcategory)
    {
        $this->customerTrdcategory = $customerTrdcategory;

        return $this;
    }

    /**
     * Get customerTrdcategory
     *
     * @return integer
     */
    public function getCustomerTrdcategory()
    {
        return $this->customerTrdcategory;
    }

    /**
     * Set customerVatsts
     *
     * @param integer $customerVatsts
     *
     * @return Customer
     */
    public function setCustomerVatsts($customerVatsts)
    {
        $this->customerVatsts = $customerVatsts;

        return $this;
    }

    /**
     * Get customerVatsts
     *
     * @return integer
     */
    public function getCustomerVatsts()
    {
        return $this->customerVatsts;
    }

    /**
     * Set priceField
     *
     * @param string $priceField
     *
     * @return Customer
     */
    public function setPriceField($priceField)
    {
        $this->priceField = $priceField;

        return $this;
    }

    /**
     * Get priceField
     *
     * @return string
     */
    public function getPriceField()
    {
        return $this->priceField;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Customer
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
     * Set actioneer
     *
     * @param integer $actioneer
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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

    /**
     * Add address
     *
     * @param \MegasoftBundle\Entity\Customeraddress $address
     *
     * @return Customer
     */
    public function addAddress(\MegasoftBundle\Entity\Customeraddress $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \MegasoftBundle\Entity\Customeraddress $address
     */
    public function removeAddress(\MegasoftBundle\Entity\Customeraddress $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Set customergroup
     *
     * @param \MegasoftBundle\Entity\Customergroup $customergroup
     *
     * @return Customer
     */
    public function setCustomergroup(\MegasoftBundle\Entity\Customergroup $customergroup = null)
    {
        $this->customergroup = $customergroup;

        return $this;
    }

    /**
     * Get customergroup
     *
     * @return \MegasoftBundle\Entity\Customergroup
     */
    public function getCustomergroup()
    {
        return $this->customergroup;
    }
}