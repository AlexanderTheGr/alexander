<?php

namespace EdiBundle\Entity;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * Eltrekaedi
 */
class Eltrekaedi {

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
    var $id;

    /**
     * @var integer
     */
    private $sos;

    /**
     * @var string
     */
    private $partno;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $factorypartno;

    /**
     * @var integer
     */
    private $tecdocsupplierno;

    /**
     * @var string
     */
    private $tecdocpartno;

    /**
     * @var string
     */
    private $wholeprice;

    /**
     * @var string
     */
    private $retailprice;

    /**
     * @var string
     */
    private $supplierno;

    /**
     * @var string
     */
    private $supplierdescr;

    /**
     * @var string
     */
    private $division;

    /**
     * @var string
     */
    private $eltrekkaCat;

    /**
     * @var string
     */
    private $eltrekkaCatDe;

    /**
     * @var string
     */
    private $eltrekkaSubCat;

    /**
     * @var string
     */
    private $eltrekkaSubCatDe;

    /**
     * @var string
     */
    private $photo;

    /**
     * @var string
     */
    private $grossWeightGr;

    /**
     * @var string
     */
    private $lenghtMm;

    /**
     * @var string
     */
    private $widthMm;

    /**
     * @var string
     */
    private $heightMm;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set sos
     *
     * @param integer $sos
     *
     * @return Eltrekaedi
     */
    public function setSos($sos) {
        $this->sos = $sos;

        return $this;
    }

    /**
     * Get sos
     *
     * @return integer
     */
    public function getSos() {
        return $this->sos;
    }

    /**
     * Set partno
     *
     * @param string $partno
     *
     * @return Eltrekaedi
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
     * @return Eltrekaedi
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
     * Set factorypartno
     *
     * @param string $factorypartno
     *
     * @return Eltrekaedi
     */
    public function setFactorypartno($factorypartno) {
        $this->factorypartno = $factorypartno;

        return $this;
    }

    /**
     * Get factorypartno
     *
     * @return string
     */
    public function getFactorypartno() {
        return $this->factorypartno;
    }

    /**
     * Set tecdocsupplierno
     *
     * @param integer $tecdocsupplierno
     *
     * @return Eltrekaedi
     */
    public function setTecdocsupplierno($tecdocsupplierno) {
        $this->tecdocsupplierno = $tecdocsupplierno;

        return $this;
    }

    /**
     * Get tecdocsupplierno
     *
     * @return integer
     */
    public function getTecdocsupplierno() {
        return $this->tecdocsupplierno;
    }

    /**
     * Set tecdocpartno
     *
     * @param string $tecdocpartno
     *
     * @return Eltrekaedi
     */
    public function setTecdocpartno($tecdocpartno) {
        $this->tecdocpartno = $tecdocpartno;

        return $this;
    }

    /**
     * Get tecdocpartno
     *
     * @return string
     */
    public function getTecdocpartno() {
        return $this->tecdocpartno;
    }

    /**
     * Set wholeprice
     *
     * @param string $wholeprice
     *
     * @return Eltrekaedi
     */
    public function setWholeprice($wholeprice) {
        $this->wholeprice = $wholeprice;

        return $this;
    }

    /**
     * Get wholeprice
     *
     * @return string
     */
    public function getWholeprice() {
        return $this->wholeprice;
    }

    /**
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return Eltrekaedi
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

    /**
     * Set supplierno
     *
     * @param string $supplierno
     *
     * @return Eltrekaedi
     */
    public function setSupplierno($supplierno) {
        $this->supplierno = $supplierno;

        return $this;
    }

    /**
     * Get supplierno
     *
     * @return string
     */
    public function getSupplierno() {
        return $this->supplierno;
    }

    /**
     * Set supplierdescr
     *
     * @param string $supplierdescr
     *
     * @return Eltrekaedi
     */
    public function setSupplierdescr($supplierdescr) {
        $this->supplierdescr = $supplierdescr;

        return $this;
    }

    /**
     * Get supplierdescr
     *
     * @return string
     */
    public function getSupplierdescr() {
        return $this->supplierdescr;
    }

    /**
     * Set division
     *
     * @param string $division
     *
     * @return Eltrekaedi
     */
    public function setDivision($division) {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision() {
        return $this->division;
    }

    /**
     * Set eltrekkaCat
     *
     * @param string $eltrekkaCat
     *
     * @return Eltrekaedi
     */
    public function setEltrekkaCat($eltrekkaCat) {
        $this->eltrekkaCat = $eltrekkaCat;

        return $this;
    }

    /**
     * Get eltrekkaCat
     *
     * @return string
     */
    public function getEltrekkaCat() {
        return $this->eltrekkaCat;
    }

    /**
     * Set eltrekkaCatDe
     *
     * @param string $eltrekkaCatDe
     *
     * @return Eltrekaedi
     */
    public function setEltrekkaCatDe($eltrekkaCatDe) {
        $this->eltrekkaCatDe = $eltrekkaCatDe;

        return $this;
    }

    /**
     * Get eltrekkaCatDe
     *
     * @return string
     */
    public function getEltrekkaCatDe() {
        return $this->eltrekkaCatDe;
    }

    /**
     * Set eltrekkaSubCat
     *
     * @param string $eltrekkaSubCat
     *
     * @return Eltrekaedi
     */
    public function setEltrekkaSubCat($eltrekkaSubCat) {
        $this->eltrekkaSubCat = $eltrekkaSubCat;

        return $this;
    }

    /**
     * Get eltrekkaSubCat
     *
     * @return string
     */
    public function getEltrekkaSubCat() {
        return $this->eltrekkaSubCat;
    }

    /**
     * Set eltrekkaSubCatDe
     *
     * @param string $eltrekkaSubCatDe
     *
     * @return Eltrekaedi
     */
    public function setEltrekkaSubCatDe($eltrekkaSubCatDe) {
        $this->eltrekkaSubCatDe = $eltrekkaSubCatDe;

        return $this;
    }

    /**
     * Get eltrekkaSubCatDe
     *
     * @return string
     */
    public function getEltrekkaSubCatDe() {
        return $this->eltrekkaSubCatDe;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Eltrekaedi
     */
    public function setPhoto($photo) {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto() {
        return $this->photo;
    }

    /**
     * Set grossWeightGr
     *
     * @param string $grossWeightGr
     *
     * @return Eltrekaedi
     */
    public function setGrossWeightGr($grossWeightGr) {
        $this->grossWeightGr = $grossWeightGr;

        return $this;
    }

    /**
     * Get grossWeightGr
     *
     * @return string
     */
    public function getGrossWeightGr() {
        return $this->grossWeightGr;
    }

    /**
     * Set lenghtMm
     *
     * @param string $lenghtMm
     *
     * @return Eltrekaedi
     */
    public function setLenghtMm($lenghtMm) {
        $this->lenghtMm = $lenghtMm;

        return $this;
    }

    /**
     * Get lenghtMm
     *
     * @return string
     */
    public function getLenghtMm() {
        return $this->lenghtMm;
    }

    /**
     * Set widthMm
     *
     * @param string $widthMm
     *
     * @return Eltrekaedi
     */
    public function setWidthMm($widthMm) {
        $this->widthMm = $widthMm;

        return $this;
    }

    /**
     * Get widthMm
     *
     * @return string
     */
    public function getWidthMm() {
        return $this->widthMm;
    }

    /**
     * Set heightMm
     *
     * @param string $heightMm
     *
     * @return Eltrekaedi
     */
    public function setHeightMm($heightMm) {
        $this->heightMm = $heightMm;

        return $this;
    }

    /**
     * Get heightMm
     *
     * @return string
     */
    public function getHeightMm() {
        return $this->heightMm;
    }

    private $SoapClient = false;
    private $Username = 'TESTUID';
    private $Password = 'TESTPWD';
    private $CustomerNo = '999999L';
    private $soap_url = 'http://195.144.16.7/EltrekkaEDI/EltrekkaEDI.asmx?WSDL';

    private function auth() {
   
        if ($this->SoapClient) {
            return $this;
        }   
        $this->SoapClient = new \SoapClient($this->soap_url);
        $ns = 'http://eltrekka.gr/edi/';
        $headerbody = array('Username' => $this->Username, 'Password' => $this->Password);
        $header = new \SOAPHeader($ns, 'AuthHeader', $headerbody);
        $this->SoapClient->__setSoapHeaders($header);
        //$session->set('SoapClient', $this->SoapClient);
        return $this;
    }

    function getPartMasterFile() {
        $this->auth();
        $response = $this->SoapClient->GetPartMaster();
        $xml = simplexml_load_string($response->GetPartMasterResult->any) or die("Error: Cannot create object");
        if (!trim($xml->ErrorCode) != "") {
            return $xml->PartMasterURL;
        } else {
            $xml->ErrorDescription;
        }
    }

    
 
    public function getQtyAvailability($qty = 1) {
        $this->auth();
        $params["CustomerNo"] = $this->CustomerNo;
        $params["EltrekkaRef"] = $this->getPartno();
        $params["RequestedQty"] = $qty;
        $out = $this->SoapClient->GetAvailability($params);
        $xmlNode = new \SimpleXMLElement($out->GetAvailabilityResult->any);
        $availability = (array)$xmlNode->Item;
        return $availability;
    }
    
    public function getAvailability($cnt=0) {
        if ($cnt > 10) return;  
        $this->auth();
        $params["CustomerNo"] = $this->CustomerNo;
        $params["EltrekkaRef"] = $this->getPartno();
        $params["RequestedQty"] = 1;
        $out = $this->SoapClient->GetAvailability($params);
        $xmlNode = new \SimpleXMLElement($out->GetAvailabilityResult->any);
        $Availability = (array)$xmlNode->Item->Header;
        return $Availability["Available"];
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
                $attrs[$key] = strtolower($attr);
            }
            while ($data = fgetcsv($handle, 100000, "\t")) {
                foreach ($data as $key => $val) {
                    $attributes[$attrs[$key]] = $val;
                }


                $attributes["wholeprice"] = str_replace(",", ".", $attributes["wholeprice"]);
                $attributes["retailprice"] = str_replace(",", ".", $attributes["retailprice"]);
                $attributes["gross_weight_gr"] = str_replace(",", ".", $attributes["gross_weight_gr"]);
                $attributes["lenght_mm"] = str_replace(",", ".", $attributes["lenght_mm"]);
                $attributes["width_mm"] = str_replace(",", ".", $attributes["width_mm"]);
                $attributes["height_mm"] = str_replace(",", ".", $attributes["height_mm"]);



                $Eltrekaedi = $this->getDoctrine()
                        ->getRepository('|EdiBundle:Eltrekaedi')
                        ->findOneByIdPartno($attributes["partnot"]);

                foreach ($attributes as $field => $val) {
                    $this->setField($field, $val);
                }

                print_r($attributes);
                exit;

                /*
                  $sql = "select id from eltrekaedi where partno = '".$attributes["partno"]."'";
                  $eltrekaedi = Yii::app()->db->createCommand($sql)->queryRow();
                 */

                $q = array();
                foreach ($attributes as $field => $val) {
                    $q[] = "`" . $field . "` = '" . addslashes($val) . "'";
                }
                if ((int) $eltrekaedi["id"] == 0) {
                    $eltrekaedi["id"] = $this->getSysId();
                }
                /*
                  $sql = "replace eltrekaedi set id = '".$eltrekaedi["id"]."', ".implode(",",$q);
                  echo $eltrekaedi["id"]."<BR>";
                  Yii::app()->db->createCommand($sql)->execute();
                  //if ($i++ > 10)
                  //exit;
                 * 
                 */
            }
        }
    }

}
