<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * TecdocSupplier
 *
 * @ORM\Table(name="tecdoc_supplier")
 * @ORM\Entity
 */
class TecdocSupplier extends Entity {

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
     * @ORM\Column(name="supplier", type="string", length=255, nullable=false)
     */
    protected $supplier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ts", type="datetime", nullable=false)
     */
    protected $ts = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="actioneer", type="integer", nullable=false)
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    var $id;

    /**
     * Set supplier
     *
     * @param string $supplier
     *
     * @return TecdocSupplier
     */
    public function setSupplier($supplier) {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return string
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return TecdocSupplier
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
     * @return TecdocSupplier
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
     * @return TecdocSupplier
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
     * @return TecdocSupplier
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

    
    
    function updateToSoftone() {
        global $kernel;
        set_time_limit(100000);
        $softone = new Softone();
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');


        $query = $em->createQuery(
                "SELECT  p.id as id, p.supplier as supplier
                    FROM SoftoneBundle:TecdocSupplier p"
        );
        $i = 0;
        $results = $query->getResult();
        foreach ($results as $data) {
            $params["fSQL"] = "SELECT * FROM MTRMARK where MTRMARK = " . $data["id"];
            $datas = $softone->createSql($params);
            if (@count($datas->data))
                continue;
            $params["fSQL"] = 'Insert INTO MTRMARK (MTRMARK,NAME,CODE,COMPANY,SODTYPE) VALUES (' . $data["id"] . ',\'' . $data["supplier"]. '\', \'' . $data["id"] . '\',1000,51)';
            print_r($softone->createSql($params));
            //if ($i++ > 5) exit;
        }
    }

    function toSoftone() {
        $softone = new Softone();
        $params["fSQL"] = "SELECT * FROM MTRMARK where MTRMARK = " . $this->id;
        $datas = $softone->createSql($params);
        if (@count($datas->data))
            return;
        $params["fSQL"] = 'Insert INTO MTRMARK (MTRMARK,NAME,CODE,COMPANY,SODTYPE) VALUES (' . $this->id . ',\'' . $this->supplier . '\', \'' . $this->id . '\',1000,51)';
        print_r($softone->createSql($params));
    }

}
