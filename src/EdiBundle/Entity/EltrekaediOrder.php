<?php

namespace EdiBundle\Entity;

/**
 * EltrekaediOrder
 */
class EltrekaediOrder {

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var integer
     */
    private $reference = '0';

    /**
     * @var \DateTime
     */
    private $insdate;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var string
     */
    private $PurchaseOrderNo;

    /**
     * @var integer
     */
    private $StoreNo;

    /**
     * @var integer
     */
    private $PmtTermsCode;

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
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var integer
     */
    private $user;

    /**
     * @var integer
     */
    private $route;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $EltrekaediOrderItem;

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

    private function auth() {
        if ($this->SoapClient)
            return $this;
        $this->SoapClient = new \SoapClient($this->soap_url);
        $ns = 'http://eltrekka.gr/edi/';
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($ns, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        return $this;
    }
    public function placeOrder() {
        $this->auth();
        $items = $this->getEltrekaediOrderItem();
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
        $out = $this->SoapClient->PlaceOrder($params);
        $xmlNode = new \SimpleXMLElement($out->PlaceOrderResult->any);
        return (array)$xmlNode;
    }

    private function getPartBuffer($items) {
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
}
