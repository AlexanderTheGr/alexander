<?php

namespace EdiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * EdiOrder
 */
class EdiOrder extends Entity {

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
    private $remarks;

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
    var $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $EdiOrderItem;

    /**
     * Constructor
     */
    public function __construct() {
        $this->EdiOrderItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return EdiOrder
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
     * @return EdiOrder
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
     * Set remarks
     *
     * @param string $remarks
     *
     * @return EdiOrder
     */
    public function setRemarks($remarks) {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks() {
        return $this->remarks;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EdiOrder
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
     * @return EdiOrder
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
     * @return EdiOrder
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
     * @return EdiOrder
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
     * @return EdiOrder
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
     * @return EdiOrder
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
     * Add ediOrderItem
     *
     * @param \EdiBundle\Entity\EdiOrderItem $ediOrderItem
     *
     * @return EdiOrder
     */
    public function addEdiOrderItem(\EdiBundle\Entity\EdiOrderItem $ediOrderItem) {
        $this->EdiOrderItem[] = $ediOrderItem;

        return $this;
    }

    /**
     * Remove ediOrderItem
     *
     * @param \EdiBundle\Entity\EdiOrderItem $ediOrderItem
     */
    public function removeEdiOrderItem(\EdiBundle\Entity\EdiOrderItem $ediOrderItem) {
        $this->EdiOrderItem->removeElement($ediOrderItem);
    }

    /**
     * Get ediOrderItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEdiOrderItems() {
        return $this->EdiOrderItem;
    }

    /**
     * @var \EdiBundle\Entity\Edi
     */
    private $Edi;

    /**
     * Set edi
     *
     * @param \EdiBundle\Entity\Edi $edi
     *
     * @return EdiOrder
     */
    public function setEdi(\EdiBundle\Entity\Edi $edi = null) {
        $this->Edi = $edi;

        return $this;
    }

    /**
     * Get edi
     *
     * @return \EdiBundle\Entity\Edi
     */
    public function getEdi() {
        return $this->Edi;
    }

    function sendOrder() {
        $datas = array();
        //print_r($jsonarr);
        if (strlen($this->getEdi()->getToken()) == 36) {
            $data['ApiToken'] = $this->getEdi()->getToken();
            $data['Items'] = array();
            foreach ($this->getEdiOrderItems() as $ediitem) {
                $Item["ItemCode"] = $ediitem->getEdiItem()->getPartno();
                $Item["ReqQty"] = $ediitem->getQty();
                $Item["UnitPrice"] = $ediitem->getPrice();
                $data['Items'][] = $Item;
            }

            //$jsonarr2[(int)$key] = $json;
            //print_r($datas);
            //print_r($datas);
            $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=postorder';
            //$data_string = '{ "ApiToken": "b5ab708b-0716-4c91-a8f3-b6513990fe3c", "Items": [ { "ItemCode": "' . $this->erp_code . '", "ReqQty": 1 } ] } ';
            //return 10;
            $data_string = json_encode($data);
            print_r($data);
            //return;
            $result = file_get_contents($requerstUrl, null, stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' =>
                    'Content-Type: application/json' . "\r\n"
                    . 'Content-Length: ' . strlen($data_string) . "\r\n",
                    'content' => $data_string,
                ),
            )));

            return json_decode($result);
        } else {
            $elteka = $this->eltekaAuth();
            foreach ($this->getEdiOrderItems() as $ediitem) {
                $PartTable = array();
                $params = array(
                    "CustomerNo"=>$this->CustomerNo,
                    "StoreNo" => "",
                    "PurchaseOrderNo"=>"EL-".$this->getId(),
                    "PmtTermsCode"=>2,
                    "Make"=>"",
                    "SerialNo"=>"",
                    "Model"=>"",
                    "UserId"=>"",
                    "UserEmail"=>"",
                    "ShipToCode"=>"",
                    "ShipVia"=>2,
                    "PartCount"=>count($this->getEdiOrderItems()),
                    "PartTable"=>$this->createPartBuffer()
                );
                $result = $elteka->PlaceOrder($params);
                print_r($result);
            }            
        }


        //print_r($jsonarr);        
    }
    
    protected function createPartBuffer() {
        $buffer = "";
        foreach ($this->getEdiOrderItems() as $ediitem) {
            $buffer .= "777";
            $buffer .= str_pad($ediitem->getEdiItem()->getItemcode(),20);
            $buffer .= str_pad($ediitem->getQty(), 5, "0", STR_PAD_LEFT);
            $buffer .= str_pad($ediitem->getEdiItem()->getItemcode(),20);
        }
    }
    protected function eltekaAuth() {

        $this->SoapUrl = $this->getSetting("EdiBundle:Eltreka:SoapUrl");
        $this->SoapNs = $this->getSetting("EdiBundle:Eltreka:SoapNs");
        $this->Username = $this->getSetting("EdiBundle:Eltreka:Username");
        $this->Password = $this->getSetting("EdiBundle:Eltreka:Password");
        $this->CustomerNo = $this->getSetting("EdiBundle:Eltreka:CustomerNo");

        if ($this->SoapClient) {
            return $this->SoapClient;
        }

        $this->SoapClient = new \SoapClient($this->SoapUrl);
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($this->SoapNs, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        //$session->set('SoapClient', $this->SoapClient);
        return $this->SoapClient;
    }
}
