<?php

namespace EdiBundle\Entity;

/**
 * Viacaredi
 */
class Viacaredi {

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var string
     */
    private $itemCode;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $partno;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $dlnr;

    /**
     * @var string
     */
    private $artNr;

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
    var $id;

    /**
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return Viacaredi
     */
    public function setItemCode($itemCode) {
        $this->itemCode = $itemCode;

        return $this;
    }

    /**
     * Get itemCode
     *
     * @return string
     */
    public function getItemCode() {
        return $this->itemCode;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Viacaredi
     */
    public function setBrand($brand) {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand() {
        return $this->brand;
    }

    /**
     * Set partno
     *
     * @param string $partno
     *
     * @return Viacaredi
     */
    public function setPartno($partno) {
        $this->partno = $partno;

        return $this;
    }

    /**
     * Get partno
     *
     * @return string
     */
    public function getPartno() {
        return $this->partno;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Viacaredi
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set dlnr
     *
     * @param integer $dlnr
     *
     * @return Viacaredi
     */
    public function setDlnr($dlnr) {
        $this->dlnr = $dlnr;

        return $this;
    }

    /**
     * Get dlnr
     *
     * @return integer
     */
    public function getDlnr() {
        return $this->dlnr;
    }

    /**
     * Set artNr
     *
     * @param string $artNr
     *
     * @return Viacaredi
     */
    public function setArtNr($artNr) {
        $this->artNr = $artNr;

        return $this;
    }

    /**
     * Get artNr
     *
     * @return string
     */
    public function getArtNr() {
        return $this->artNr;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Viacaredi
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
     * @return Viacaredi
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
     * @return Viacaredi
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
     * @return Viacaredi
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

    public function getPartMasterFile() {
        return 'http://zerog.gr/edi/fw.ashx?method=getinventoryfile&apiToken=de1751fa-f91c-4b7c-89a9-9cfbaf0e5b50';
    }

    public function getPartMaster() {

        $this->auth();
        //echo $this->getPartMaster();
        $file = $this->getPartMasterFile();
        echo $file;

        if ((($handle = fopen($file, "r")) !== FALSE)) {
            $data = fgetcsv($handle, 100000, "\t");
            //print_r($data);
            foreach ($data as $key => $attr) {
                $attrs[$key] = $attr;
            }
            while ($data = fgetcsv($handle, 100000, "\t")) {
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = $val;
                }



                $Eltrekaedi = $this->getDoctrine()
                        ->getRepository('EdiBundle:Viacaredi')
                        ->findOneByItemCode($attributes["ItemCode"]);

                foreach ($attributes as $field => $val) {
                    $this->setField($field, $val);
                }
            }
        }
    }

    /**
     * @var string
     */
    private $retailprice;

    /**
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return Viacaredi
     */
    public function setRetailprice($retailprice) {
        $this->retailprice = $retailprice;

        return $this;
    }

    /**
     * Get retailprice
     *
     * @return string
     */
    public function getRetailprice() {
        return $this->retailprice;
    }

    private $requerstUrl = 'http://zerog.gr/edi/fw.ashx?method=getiteminfo';

    public function getQtyAvailability($qty = 1) {
        $data_string = '{ "ApiToken": "de1751fa-f91c-4b7c-89a9-9cfbaf0e5b50", "Items": [ { "ItemCode": "' . $this->itemCode . '", "ReqQty": 1 } ] } ';
        //return 10;

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
        //print_r($re);
        $out["PriceOnPolicy"] = $re->Items[0]->UnitPrice;
        $out["Availability"] = $re->Items[0]->Availability;
        
        //echo print_r($re);
        return $out;
    }

    public function getAvailability($gty = 1) {

        $data_string = '{ "ApiToken": "de1751fa-f91c-4b7c-89a9-9cfbaf0e5b50", "Items": [ { "ItemCode": "' . $this->itemCode . '", "ReqQty": 1 } ] } ';
        //return 10;

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

        return 10;
    }

}
