<?php

namespace EdiBundle\Entity;

use AppBundle\Entity\Entity;

/**
 * EltrekaediOrder
 */
class EltrekaediOrder extends Entity {



    /**
     * @var integer
     */
    protected $reference = '0';

    /**
     * @var \DateTime
     */
    protected $insdate;

    /**
     * @var string
     */
    protected $comments;

    /**
     * @var string
     */
    protected $PurchaseOrderNo;

    /**
     * @var integer
     */
    protected $StoreNo;

    /**
     * @var integer
     */
    protected $PmtTermsCode;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var integer
     */
    protected $actioneer;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $modified;

    /**
     * @var integer
     */
    protected $user;

    /**
     * @var integer
     */
    protected $route;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $EltrekaediOrderItem;

    /**
     * Constructor
     */
    public function __construct() {
        $this->EltrekaediOrderItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return EltrekaediOrder
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
     * Set insdate
     *
     * @param \DateTime $insdate
     *
     * @return EltrekaediOrder
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
     * Set comments
     *
     * @param string $comments
     *
     * @return EltrekaediOrder
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
     * Set purchaseOrderNo
     *
     * @param string $purchaseOrderNo
     *
     * @return EltrekaediOrder
     */
    public function setPurchaseOrderNo($purchaseOrderNo) {
        $this->PurchaseOrderNo = $purchaseOrderNo;

        return $this;
    }

    /**
     * Get purchaseOrderNo
     *
     * @return string
     */
    public function getPurchaseOrderNo() {
        return $this->PurchaseOrderNo;
    }

    /**
     * Set storeNo
     *
     * @param integer $storeNo
     *
     * @return EltrekaediOrder
     */
    public function setStoreNo($storeNo) {
        $this->StoreNo = $storeNo;

        return $this;
    }

    /**
     * Get storeNo
     *
     * @return integer
     */
    public function getStoreNo() {
        return $this->StoreNo;
    }

    /**
     * Set pmtTermsCode
     *
     * @param integer $pmtTermsCode
     *
     * @return EltrekaediOrder
     */
    public function setPmtTermsCode($pmtTermsCode) {
        $this->PmtTermsCode = $pmtTermsCode;

        return $this;
    }

    /**
     * Get pmtTermsCode
     *
     * @return integer
     */
    public function getPmtTermsCode() {
        return $this->PmtTermsCode;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EltrekaediOrder
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
     * @return EltrekaediOrder
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
     * @return EltrekaediOrder
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
     * @return EltrekaediOrder
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
     * Set user
     *
     * @param integer $user
     *
     * @return EltrekaediOrder
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set route
     *
     * @param integer $route
     *
     * @return EltrekaediOrder
     */
    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return integer
     */
    public function getRoute() {
        return $this->route;
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
     * Add eltrekaediOrderItem
     *
     * @param \EdiBundle\Entity\EltrekaediOrderItem $eltrekaediOrderItem
     *
     * @return EltrekaediOrder
     */
    public function addEltrekaediOrderItem(\EdiBundle\Entity\EltrekaediOrderItem $eltrekaediOrderItem) {
        $this->EltrekaediOrderItem[] = $eltrekaediOrderItem;

        return $this;
    }

    /**
     * Remove eltrekaediOrderItem
     *
     * @param \EdiBundle\Entity\EltrekaediOrderItem $eltrekaediOrderItem
     */
    public function removeEltrekaediOrderItem(\EdiBundle\Entity\EltrekaediOrderItem $eltrekaediOrderItem) {
        $this->EltrekaediOrderItem->removeElement($eltrekaediOrderItem);
    }

    /**
     * Get eltrekaediOrderItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEltrekaediOrderItem() {
        return $this->EltrekaediOrderItem;
    }

    var $SoapClient;
    var $Username = 'TESTUID';
    var $Password = 'TESTPWD';
    var $CustomerNo = '999999L';
    var $soap_url = 'http://195.144.16.7/EltrekkaEDI/EltrekkaEDI.asmx?WSDL';

    protected function auth() {
        if ($this->SoapClient)
            return $this;
        $this->SoapClient = new \SoapClient($this->soap_url);
        $ns = 'http://eltrekka.gr/edi/';
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($ns, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        return $this;
    }
    public function placeOrder($params) {
        $this->auth();
        $items = $this->getEltrekaediOrderItem();
        /*
        $params["CustomerNo"] = $this->CustomerNo;
        $params["PurchaseOrderNo"] = "100".$this->id;
        $params["StoreNo"] = 10;
        $params["PmtTermsCode"] = 1;
        $params["Make"] = "";
        $params["SerialNo"] = "";
        $params["UserId"] = "";
        $params["UserEmail"] = "";
        $params["ShipToCode"] = "";
        $params["ShipViaCode"] = 1;
        $params["PartCount"] = count($items);
        $params["PartTable"] = $this->getPartBuffer($items);
        */
        $out = $this->SoapClient->PlaceOrder($params);
        echo $out;
        return;
        $xmlNode = new \SimpleXMLElement($out->PlaceOrderResult->any);
        return (array)$xmlNode;
    }

    protected function getPartBuffer($items) {
        foreach($items as $item) {
            $buffer .= "777";
            $partsNo = $item->getEltrekaedi()->getPartno();
            while(strlen($partsNo) < 20) {
                $partsNo .= " ";
            }
            $buffer .=  $partsNo;
            $qty = $item->getQty();
            while(strlen($qty) < 5) {
                $qty = "0".$qty;
            }
            $buffer .=  $qty;
            $CustomerPartNo = $this->CustomerNo.$item->getId();
            while(strlen($CustomerPartNo) < 20) {
                $CustomerPartNo .= " ";
            }
            $buffer .= $CustomerPartNo;
        }
        return $buffer;
    }
    /**
     * @var integer
     */
    protected $Make;

    /**
     * @var string
     */
    protected $SerialNo;

    /**
     * @var string
     */
    protected $Model;

    /**
     * @var integer
     */
    protected $UserId;

    /**
     * @var string
     */
    protected $UserEmail;

    /**
     * @var string
     */
    protected $ShipToCode;

    /**
     * @var integer
     */
    protected $ShipViaCode;


    /**
     * Set make
     *
     * @param integer $make
     *
     * @return EltrekaediOrder
     */
    public function setMake($make)
    {
        $this->Make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return integer
     */
    public function getMake()
    {
        return $this->Make;
    }

    /**
     * Set serialNo
     *
     * @param string $serialNo
     *
     * @return EltrekaediOrder
     */
    public function setSerialNo($serialNo)
    {
        $this->SerialNo = $serialNo;

        return $this;
    }

    /**
     * Get serialNo
     *
     * @return string
     */
    public function getSerialNo()
    {
        return $this->SerialNo;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return EltrekaediOrder
     */
    public function setModel($model)
    {
        $this->Model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->Model;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return EltrekaediOrder
     */
    public function setUserId($userId)
    {
        $this->UserId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * Set userEmail
     *
     * @param string $userEmail
     *
     * @return EltrekaediOrder
     */
    public function setUserEmail($userEmail)
    {
        $this->UserEmail = $userEmail;

        return $this;
    }

    /**
     * Get userEmail
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->UserEmail;
    }

    /**
     * Set shipToCode
     *
     * @param string $shipToCode
     *
     * @return EltrekaediOrder
     */
    public function setShipToCode($shipToCode)
    {
        $this->ShipToCode = $shipToCode;

        return $this;
    }

    /**
     * Get shipToCode
     *
     * @return string
     */
    public function getShipToCode()
    {
        return $this->ShipToCode;
    }

    /**
     * Set shipViaCode
     *
     * @param integer $shipViaCode
     *
     * @return EltrekaediOrder
     */
    public function setShipViaCode($shipViaCode)
    {
        $this->ShipViaCode = $shipViaCode;

        return $this;
    }

    /**
     * Get shipViaCode
     *
     * @return integer
     */
    public function getShipViaCode()
    {
        return $this->ShipViaCode;
    }
}
