<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;
/**
 * SoftoneSupplier
 *
 * @ORM\Table(name="softone_supplier")
 * @ORM\Entity
 */
class SoftoneSupplier extends Entity {

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=false)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

    /**
     * Set code
     *
     * @param string $code
     *
     * @return SoftoneSupplier
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SoftoneSupplier
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    
    function toSoftone() {
        $softone = new Softone();
        $params["fSQL"] = "SELECT * FROM MTRMANFCTR where MTRMANFCTR = ".$this->id;
        $datas = $softone->createSql($params); 
        if (@count($datas->data)) return;
        $params["fSQL"] = 'Insert INTO MTRMANFCTR (MTRMANFCTR,NAME,CODE,COMPANY) VALUES ('.$this->id.',\''.$this->title.'\', \''.$this->code.'\',1000)';
        //print_r($softone->createSql($params));       
    }

}
