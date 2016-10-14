<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;


/**
 * Customer
 *
 * @ORM\Table(name="customer", indexes={@ORM\Index(name="user_id", columns={"actioneer"}), @ORM\Index(name="customer_code", columns={"customer_code"}) })
 * @ORM\Entity
 */

class Customer extends Entity {

    var $repositories = array();

    public function __construct() {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    protected $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="group", type="integer", nullable=false)
     */
    protected $group;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=80, nullable=true)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_code", type="string", length=255, nullable=false)
     */
    protected $customerCode;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string", length=255, nullable=false)
     */
    protected $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_afm", type="string", length=255, nullable=false)
     */
    protected $customerAfm;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_address", type="string", length=255, nullable=false)
     */
    protected $customerAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_district", type="string", length=255, nullable=false)
     */
    protected $customerDistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_city", type="string", length=255, nullable=false)
     */
    protected $customerCity;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer_zip", type="integer", nullable=false)
     */
    protected $customerZip;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_phone01", type="string", length=255, nullable=false)
     */
    protected $customerPhone01;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_phone02", type="string", length=255, nullable=false)
     */
    protected $customerPhone02;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_trdr_cusextra_varchar03", type="string", length=255, nullable=false)
     */
    protected $customerTrdrCusextraVarchar03;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_fax", type="string", length=255, nullable=false)
     */
    protected $customerFax;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_webpage", type="string", length=255, nullable=false)
     */
    protected $customerWebpage;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string", length=255, nullable=false)
     */
    protected $customerEmail;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer_payment", type="integer", nullable=false)
     */
    protected $customerPayment;

    /**
     * @var integer
     *
     * @ORM\Column(name="customer_trdcategory", type="integer", nullable=false)
     */
    protected $customerTrdcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="price_field", type="string", length=255, nullable=false)
     */
    protected $priceField;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    protected $status = 'active';

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
     * @var string
     *
     * @ORM\Column(name="flat_data", type="text", nullable=false)
     */
    protected $flatData;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

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
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
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
     * Set customerDistrict
     *
     * @param string $customerDistrict
     *
     * @return Customer
     */
    public function setCustomerDistrict($customerDistrict) {
        $this->customerDistrict = $customerDistrict;

        return $this;
    }

    /**
     * Get customerDistrict
     *
     * @return string
     */
    public function getCustomerDistrict() {
        return $this->customerDistrict;
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
     * Set customerPhone01
     *
     * @param string $customerPhone01
     *
     * @return Customer
     */
    public function setCustomerPhone01($customerPhone01) {
        $this->customerPhone01 = $customerPhone01;

        return $this;
    }

    /**
     * Get customerPhone01
     *
     * @return string
     */
    public function getCustomerPhone01() {
        return $this->customerPhone01;
    }

    /**
     * Set customerPhone02
     *
     * @param string $customerPhone02
     *
     * @return Customer
     */
    public function setCustomerPhone02($customerPhone02) {
        $this->customerPhone02 = $customerPhone02;

        return $this;
    }

    /**
     * Get customerPhone02
     *
     * @return string
     */
    public function getCustomerPhone02() {
        return $this->customerPhone02;
    }

    /**
     * Set customerTrdrCusextraVarchar03
     *
     * @param string $customerTrdrCusextraVarchar03
     *
     * @return Customer
     */
    public function setCustomerTrdrCusextraVarchar03($customerTrdrCusextraVarchar03) {
        $this->customerTrdrCusextraVarchar03 = $customerTrdrCusextraVarchar03;

        return $this;
    }

    /**
     * Get customerTrdrCusextraVarchar03
     *
     * @return string
     */
    public function getCustomerTrdrCusextraVarchar03() {
        return $this->customerTrdrCusextraVarchar03;
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
     * Set status
     *
     * @param string $status
     *
     * @return Customer
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
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
     * Set flatData
     *
     * @param string $flatData
     *
     * @return Customer
     */
    public function setFlatData($flatData) {
        $this->flatData = $flatData;

        return $this;
    }

    /**
     * Get flatData
     *
     * @return string
     */
    public function getFlatData() {
        return $this->flatData;
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
     * @var \SoftoneBundle\Entity\Route
     */
    protected $route;

    /**
     * Set route
     *
     * @param \SoftoneBundle\Entity\Route $route
     *
     * @return Customer
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;


    /**
     * Add address
     *
     * @param \SoftoneBundle\Entity\Customeradress $address
     *
     * @return Customer
     */
    public function addAddress(\SoftoneBundle\Entity\Customeradress $address) {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \SoftoneBundle\Entity\Customeradress $address
     */
    public function removeAddress(\SoftoneBundle\Entity\Customeradress $address) {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses() {
        return $this->addresses;
    }

    /**
     * @var \DateTime
     */
    private $customerInsdate;

    /**
     * @var \DateTime
     */
    private $customerUpddate;

    /**
     * Set customerInsdate
     *
     * @param \DateTime $customerInsdate
     *
     * @return Customer
     */
    public function setCustomerInsdate($customerInsdate) {
        $this->customerInsdate = $customerInsdate;

        return $this;
    }

    /**
     * Get customerInsdate
     *
     * @return \DateTime
     */
    public function getCustomerInsdate() {
        return $this->customerInsdate;
    }

    /**
     * Set customerUpddate
     *
     * @param \DateTime $customerUpddate
     *
     * @return Customer
     */
    public function setCustomerUpddate($customerUpddate) {
        $this->customerUpddate = $customerUpddate;

        return $this;
    }

    /**
     * Get customerUpddate
     *
     * @return \DateTime
     */
    public function getCustomerUpddate() {
        return $this->customerUpddate;
    }

    /**
     * @var integer
     */
    private $customerVatsts;

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
    function toSoftone() {

        //if ($this->reference)
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $object = "CUSTOMER";
        $softone = new Softone();
        $fields = $softone->retrieveFields($object, $params["list"]);
        echo $this->reference."\n";
        print_r($fields); 
        $objectArr = array();
        $objectArr2 = array();
        if ((int)$this->reference > 0) {
            $data = $softone->getData($object, $this->reference);
            print_r($data);
            $objectArr = $data->data->$object;
            print_r($objectArr);
            $objectArr2 = (array) $objectArr[0];
        }
        foreach ($fields as $field) {
            $field1 = strtoupper(str_replace(strtolower($object) . "_", "", $field));
            $field2 = lcfirst($this->createName($field));
            //echo $field2 . "<BR>";
            @$objectArr2[$field1] = $this->$field2;
            //}
        }
        
        $objectArr[0] = $objectArr2;
        $dataOut[$object] = (array) $objectArr;
        //@$dataOut["ITEEXTRA"][0] = array("NUM02" => $this->item_mtrl_iteextra_num02);
        print_r(@$dataOut);
        $out = $softone->setData((array) $dataOut, $object, (int) $this->reference);
        print_r($out);
        if (@$out->id > 0) {
            $filters = "CUSTOMER.CODE=" . $this->customerCode . "&CUSTOMER.CODE_TO=" . $this->customerCode;
            $datas = $softone->retrieveData($object, $params["list"], $filters);
            print_r($datas[0]->data->$object);
            //$em->persist($this);
            //$em->flush(); 
            
        }        
    }
}
