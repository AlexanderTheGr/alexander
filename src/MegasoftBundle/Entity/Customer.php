<?php

namespace MegasoftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;

/**
 * Customer
 */
class Customer extends Entity {

    var $repositories = array();

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

    public function setRepositories() {
        $this->repositories['customergroup'] = 'MegasoftBundle:Customergroup';
        //$this->repositories['tecdocSupplierId'] = 'MegasoftBundle:MegasoftSupplier';
        $this->types['customergroup'] = 'object';
        //$this->types['supplierId'] = 'object';
        //$this->repositories['tecdocSupplierId'] = 'MegasoftBundle:TecdocSupplier';
        //$this->types['tecdocSupplierId'] = 'object';
        //$this->tecdocSupplierId = new \MegasoftBundle\Entity\TecdocSupplier;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        $this->repositories['customergroup'] = 'MegasoftBundle:Customergroup';
        return $this->repositories[$repo];
    }

    public function gettype($field) {
        $this->types['customergroup'] = 'object';
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
     * @var integer
     */
    var $reference;

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
     * Set reference
     *
     * @param integer $reference
     *
     * @return Customer
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
     * Set group
     *
     * @param integer $group
     *
     * @return Customer
     */
    public function setGroup($group) {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return integer
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Customer
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set customerCode
     *
     * @param string $customerCode
     *
     * @return Customer
     */
    public function setCustomerCode($customerCode) {
        $this->customerCode = $customerCode;

        return $this;
    }

    /**
     * Get customerCode
     *
     * @return string
     */
    public function getCustomerCode() {
        return $this->customerCode;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Customer
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
     * Set customerAfm
     *
     * @param string $customerAfm
     *
     * @return Customer
     */
    public function setCustomerAfm($customerAfm) {
        $this->customerAfm = $customerAfm;

        return $this;
    }

    /**
     * Get customerAfm
     *
     * @return string
     */
    public function getCustomerAfm() {
        return $this->customerAfm;
    }

    /**
     * Set customerAddress
     *
     * @param string $customerAddress
     *
     * @return Customer
     */
    public function setCustomerAddress($customerAddress) {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get customerAddress
     *
     * @return string
     */
    public function getCustomerAddress() {
        return $this->customerAddress;
    }

    /**
     * Set customerCity
     *
     * @param string $customerCity
     *
     * @return Customer
     */
    public function setCustomerCity($customerCity) {
        $this->customerCity = $customerCity;

        return $this;
    }

    /**
     * Get customerCity
     *
     * @return string
     */
    public function getCustomerCity() {
        return $this->customerCity;
    }

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return Customer
     */
    public function setCustomerEmail($customerEmail) {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail() {
        return $this->customerEmail;
    }

    /**
     * Set customerZip
     *
     * @param integer $customerZip
     *
     * @return Customer
     */
    public function setCustomerZip($customerZip) {
        $this->customerZip = $customerZip;

        return $this;
    }

    /**
     * Get customerZip
     *
     * @return integer
     */
    public function getCustomerZip() {
        return $this->customerZip;
    }

    /**
     * Set customerPhone1
     *
     * @param string $customerPhone1
     *
     * @return Customer
     */
    public function setCustomerPhone1($customerPhone1) {
        $this->customerPhone1 = $customerPhone1;

        return $this;
    }

    /**
     * Get customerPhone1
     *
     * @return string
     */
    public function getCustomerPhone1() {
        return $this->customerPhone1;
    }

    /**
     * Set customerPhone2
     *
     * @param string $customerPhone2
     *
     * @return Customer
     */
    public function setCustomerPhone2($customerPhone2) {
        $this->customerPhone2 = $customerPhone2;

        return $this;
    }

    /**
     * Get customerPhone2
     *
     * @return string
     */
    public function getCustomerPhone2() {
        return $this->customerPhone2;
    }

    /**
     * Set customerFax
     *
     * @param string $customerFax
     *
     * @return Customer
     */
    public function setCustomerFax($customerFax) {
        $this->customerFax = $customerFax;

        return $this;
    }

    /**
     * Get customerFax
     *
     * @return string
     */
    public function getCustomerFax() {
        return $this->customerFax;
    }

    /**
     * Set customerWebpage
     *
     * @param string $customerWebpage
     *
     * @return Customer
     */
    public function setCustomerWebpage($customerWebpage) {
        $this->customerWebpage = $customerWebpage;

        return $this;
    }

    /**
     * Get customerWebpage
     *
     * @return string
     */
    public function getCustomerWebpage() {
        return $this->customerWebpage;
    }

    /**
     * Set customerIrsdata
     *
     * @param string $customerIrsdata
     *
     * @return Customer
     */
    public function setCustomerIrsdata($customerIrsdata) {
        $this->customerIrsdata = $customerIrsdata;

        return $this;
    }

    /**
     * Get customerIrsdata
     *
     * @return string
     */
    public function getCustomerIrsdata() {
        return $this->customerIrsdata;
    }

    /**
     * Set customerJobtypetrd
     *
     * @param string $customerJobtypetrd
     *
     * @return Customer
     */
    public function setCustomerJobtypetrd($customerJobtypetrd) {
        $this->customerJobtypetrd = $customerJobtypetrd;

        return $this;
    }

    /**
     * Get customerJobtypetrd
     *
     * @return string
     */
    public function getCustomerJobtypetrd() {
        return $this->customerJobtypetrd;
    }

    /**
     * Set customerPayment
     *
     * @param integer $customerPayment
     *
     * @return Customer
     */
    public function setCustomerPayment($customerPayment) {
        $this->customerPayment = $customerPayment;

        return $this;
    }

    /**
     * Get customerPayment
     *
     * @return integer
     */
    public function getCustomerPayment() {
        return $this->customerPayment;
    }

    /**
     * Set customerTrdcategory
     *
     * @param integer $customerTrdcategory
     *
     * @return Customer
     */
    public function setCustomerTrdcategory($customerTrdcategory) {
        $this->customerTrdcategory = $customerTrdcategory;

        return $this;
    }

    /**
     * Get customerTrdcategory
     *
     * @return integer
     */
    public function getCustomerTrdcategory() {
        return $this->customerTrdcategory;
    }

    /**
     * Set customerVatsts
     *
     * @param integer $customerVatsts
     *
     * @return Customer
     */
    public function setCustomerVatsts($customerVatsts) {
        $this->customerVatsts = $customerVatsts;

        return $this;
    }

    /**
     * Get customerVatsts
     *
     * @return integer
     */
    public function getCustomerVatsts() {
        return $this->customerVatsts;
    }

    /**
     * Set priceField
     *
     * @param string $priceField
     *
     * @return Customer
     */
    public function setPriceField($priceField) {
        $this->priceField = $priceField;

        return $this;
    }

    /**
     * Get priceField
     *
     * @return string
     */
    public function getPriceField() {
        return $this->priceField;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set customergroup
     *
     * @param \MegasoftBundle\Entity\Customergroup $customergroup
     *
     * @return Customer
     */
    public function setCustomergroup(\MegasoftBundle\Entity\Customergroup $customergroup = null) {
        $this->customergroup = $customergroup;

        return $this;
    }

    /**
     * Get customergroup
     *
     * @return \MegasoftBundle\Entity\Customergroup
     */
    public function getCustomergroup() {
        return $this->customergroup;
    }

    function toMegasoft() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $login = $this->getSetting("MegasoftBundle:Webservice:Login"); //"demo-fastweb-megasoft";
        //$em = $this->getDoctrine()->getManager();
        $soap = new \SoapClient("http://wsprisma.megasoft.gr/mgsft_ws.asmx?WSDL", array('cache_wsdl' => WSDL_CACHE_NONE));

        if ($this->reference > 1)
            $data["CustomerId"] = $this->reference;
        $data["CustomerCode"] = (string)$this->customerCode;
        $data["CustomerName"] = (string)$this->customerName;
        $data["CustomerAfm"] = (string)$this->customerAfm;
        $data["CustomerEmail"] = (string)$this->customerEmail;
        $data["CustomerAddress"] = (string)$this->customerAddress;
        $data["CustomerCity"] = (string)$this->customerCity;
        $data["CustomerZip"] = (string)$this->customerZip;
        $data["CustomerPhone1"] = (string)$this->customerPhone1;
        $data["CustomerPhone2"] = (string)$this->customerPhone2;
        $data["CustomerDoy"] = (string)$this->customerIrsdata;
        $data["CustomerOccupation"] = (string)$this->customerJobtypetrd;
        $data["CustomerPricelist"] = (string)$this->CustomerPricelist == 'storeRetailPrice' ? 2 : 1; //$this->CustomerPricelist;
        
        /*
          $ns = 'http://schemas.xmlsoap.org/soap/envelope/';
          $headerbody = array('Login' => "alexander", 'Date' => "2016-10-10");
          $header = new SOAPHeader($ns,"AuthHeader",$headerbody);
          $soap->__setSoapHeaders($header);
         */

        $params["Login"] = $login;
        $params["JsonStrWeb"] = json_encode($data);
        print_r($params);
        $response = $soap->__soapCall("SetCustomer", array($params));
        print_r($response);
        if ($response->SetProductResult > 0 AND $this->reference == 0) {
            $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
            $this->reference = $response->SetProductResult;
            $em->persist($this);
            $em->flush();
        }
        return $response;
        //exit;
    }

    private $rules = array();

    public function loadCustomerrules() {
        //if ($this->reference)
        if (count($this->rules) > 0)
            return $this;
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $grouprules = $em->getRepository('MegasoftBundle:Customerrule')->findBy(array("customer" => $this), array('sortorder' => 'ASC'));
        foreach ((array) $grouprules as $grouprule) {
            $this->rules[] = $grouprule;
        }

        return $this;
    }

    public function getRules() {
        return $this->rules;
    }

}
