<?php

namespace EdiBundle\Entity;

use AppBundle\Entity\Entity;

/**
 * ViacarediOrder
 */
class ViacarediOrder extends Entity {

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
    protected $remarks;

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
    protected $ViacarediOrderItem;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ViacarediOrderItem = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * @return ViacarediOrder
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
     * Add viacarediOrderItem
     *
     * @param \EdiBundle\Entity\ViacarediOrderItem $viacarediOrderItem
     *
     * @return ViacarediOrder
     */
    public function addViacarediOrderItem(\EdiBundle\Entity\ViacarediOrderItem $viacarediOrderItem) {
        $this->ViacarediOrderItem[] = $viacarediOrderItem;

        return $this;
    }

    /**
     * Remove viacarediOrderItem
     *
     * @param \EdiBundle\Entity\ViacarediOrderItem $viacarediOrderItem
     */
    public function removeViacarediOrderItem(\EdiBundle\Entity\ViacarediOrderItem $viacarediOrderItem) {
        $this->ViacarediOrderItem->removeElement($viacarediOrderItem);
    }

    /**
     * Get viacarediOrderItem
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViacarediOrderItem() {
        return $this->ViacarediOrderItem;
    }

    protected $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=postorder';

    public function placeOrder() {
        // { "ApiToken": "de1751fa-f91c-4b7c-89a9-9cfbaf0e5b50", "Remarks": "Test Order", "Items": [ { "ItemCode": "8GH007157901", "ReqQty": 1, "UnitPrice": 15.58 }, { "ItemCode": "W 940 (10)", "ReqQty": 2, "UnitPrice": 7.28 }, { "ItemCode": "DRM17082", "ReqQty": 1, "UnitPrice": 122.80 } ] } 
        $items = $this->getViacarediOrderItem();
        $obj['ApiToken'] = $this->getSetting("EdiBundle:Viacar:apiToken");
        $obj['Remarks'] = $this->remarks;

        foreach ($items as $item) {
            $itemObj = array();
            $itemObj["ItemCode"] = $item->getViacaredi()->getItemCode();
            $itemObj["UnitPrice"] = $item->getPrice();
            $itemObj["ReqQty"] = $item->getQty();
            $obj['Items'][] = $itemObj;
        }
        $data_string = json_encode($obj);

        $result = file_get_contents($this->requerstUrl, null, stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' =>
                'Content-Type: application/json' . "\r\n"
                . 'Content-Length: ' . strlen($data_string) . "\r\n",
                'content' => $data_string,
            ),
        )));
        $re = json_decode($result);
        print_r($re);
    }

}
