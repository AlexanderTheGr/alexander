<?php

namespace EdiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Entity;
use SoftoneBundle\Entity\Softone as Softone;

/**
 * Edi
 */
class Edi extends Entity {

    public function __construct() {
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:SoftoneSupplier';
        //$this->types['tecdocSupplierId'] = 'object';
        //$this->tecdocSupplierId = new \SoftoneBundle\Entity\SoftoneSupplier;
    }

    public function getField($field) {
        return $this->$field;
    }

    public function setField($field, $val) {
        $this->$field = $val;
        return $val;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function getRepositories($repo) {
        //$this->repositories['tecdocSupplierId'] = 'SoftoneBundle:SoftoneSupplier';
        return $this->repositories[$repo];
    }

    public function gettype($field) {
        //$this->types['tecdocSupplierId'] = 'object';
        if (@$this->types[$field] != '') {
            return @$this->types[$field];
        }
        if (gettype($field) != NULL) {
            return gettype($this->$field);
        }
        return 'string';
    }

    /**
     * @var string
     */
    var $name;

    /**
     * @var string
     */
    var $token;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $actioneer;

    /**
     * @var string
     */
    //private $retailprice;

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
     * Set name
     *
     * @param string $name
     *
     * @return Edi
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Edi
     */
    public function setToken($token) {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Edi
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
     * @return Edi
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
     * Set retailprice
     *
     * @param string $retailprice
     *
     * @return Edi
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Edi
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
     * @return Edi
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
     * @var string
     */
    private $func;

    /**
     * Set func
     *
     * @param string $func
     *
     * @return Edi
     */
    public function setFunc($func) {
        $this->func = $func;

        return $this;
    }

    /**
     * Get func
     *
     * @return string
     */
    public function getFunc() {
        return $this->func;
    }

    /**
     * Get customeredirules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEdirules() {
        return $this->edirules;
    }

    private $rules = array();

    public function loadEdirules($pricefield = false) {
        //if ($this->reference)
        //if (count($this->rules) > 0)
        //    return $this;
        $this->rules = array();
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        if ($pricefield) {
            $edirules = $em->getRepository('EdiBundle:Edirule')->findBy(array("edi" => $this, 'price_field' => $pricefield), array('sortorder' => 'ASC'));
            foreach ((array) $edirules as $edirule) {
                if ($pricefield == $edirule->getPriceField()) {
                    $this->rules[] = $edirule;
                }
            }
        } else {
            $edirules = $em->getRepository('EdiBundle:Edirule')->findBy(array("edi" => $this), array('sortorder' => 'ASC'));
            foreach ((array) $edirules as $edirule) {
                //if ($pricefield == $edirule->getPriceField()) {
                $this->rules[] = $edirule;
                //}
            }
        }
        //echo count($edirules);    


        return $this;
    }

    public function getRules() {
        return $this->rules;
    }

    /**
     * @var integer
     */
    private $itemMtrsup;

    /**
     * Set itemMtrsup
     *
     * @param integer $itemMtrsup
     *
     * @return Edi
     */
    public function setItemMtrsup($itemMtrsup) {
        $this->itemMtrsup = $itemMtrsup;

        return $this;
    }

    /**
     * Get itemMtrsup
     *
     * @return integer
     */
    public function getItemMtrsup() {
        return $this->itemMtrsup;
    }

    /**
     * @var string
     */
    private $markup;

    /**
     * Set markup
     *
     * @param string $markup
     *
     * @return Edi
     */
    public function setMarkup($markup) {
        $this->markup = $markup;

        return $this;
    }

    /**
     * Get markup
     *
     * @return string
     */
    public function getMarkup() {
        return $this->markup;
    }

    public function synchronize() {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $softone = new Softone();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        if ($this->getItemMtrsup() > 0) {
            $products = $em->getRepository('SoftoneBundle:Product')->findBy(array("itemMtrsup" => $this->getItemMtrsup()), array('id' => 'desc'));
            echo count($products);
            //return;
            foreach ($products as $product) {

                //return;
                $ediitem = false;
                $newcccref = false;
                $code = trim($this->clearstring($product->getCccRef()));
                if ($code != '') {
                    $sql = "Select id from partsbox_db.edi_item where 
                                            replace(replace(replace(replace(replace(`itemcode`, '/', ''), '.', ''), '-', ''), ' ', ''), '*', '')  = '" . $code . "' AND edi = '" . $this->getId() . "'
                                            limit 0,100";

                    //echo $sql . "<BR>";
                    $connection = $em->getConnection();
                    $statement = $connection->prepare($sql);
                    $statement->execute();
                    $data = $statement->fetch();
                    ;
                    //echo "<BR>";
                    echo ".";
                    if ($data["id"] > 0)
                        $ediitem = $em->getRepository('EdiBundle:EdiItem')->find($data["id"]);
                }
                if (!$ediitem) {
                    $brand = $product->getSupplierId() ? $product->getSupplierId()->getTitle() : "";
                    if ($brand != '') {
                        $ediitem = $em
                                ->getRepository('EdiBundle:EdiItem')
                                ->findOneBy(array("partno" => $this->clearstring($product->getItemCode2()), 'brand' => $brand, "Edi" => $this));
                        if ($ediitem) {
                            echo $this->clearstring($product->getItemCode2()) . "<BR>";
                            $product->setCccRef($ediitem->getItemCode());
                            $newcccref = true;
                        }
                    }
                }

                //if ($brand == "BERU")
                //if ($i++ > 240)
                //    exit;
                //continue;
                if ($ediitem) {
                    //$itemPricew = $ediitem->getEdiMarkupPrice("itemPricew");
                    //$itemPricer = $ediitem->getEdiMarkupPrice("itemPricer");
                    //if ($product->getCccPriceUpd() == 0 OR $newcccref OR round($itemPricew, 2) != round($product->getItemPricew(), 2) OR round($itemPricer, 2) != round($product->getItemPricer(), 2)) {
                        //echo $this->getName() . " -- " . $product->getItemCode() . " -- " . $product->getSupplierId()->getTitle() . " -- " . $product->getItemCode2() . " " . $ediitem->getWholesaleprice() . " -- " . $ediitem->getEdiMarkupPrice("itemPricew") . " -- " . $product->getItemPricew() . "<BR>";
                        //if ($i++ > 15)
                        //    exit;
                        $itemPricew = 1;
                        if ($itemPricew > 0.01 AND $product->getReference() > 0) {
                            $color = '';
                            if ($itemPricew == $itemPricer) {
                                $color = 'red';
                            }
                            echo "<div style='color:" . $color . "'>";
                            echo $this->getName() . " " . $ediitem->getWholesaleprice() . " -- " . $product->getItemCode() . " itemPricew:(" . $itemPricew . "/" . $product->getItemPricew() . ") itemPricer:(" . $itemPricer . "/" . $product->getItemPricer() . ")<BR>";

                            $product->setCccPriceUpd(1);
                            //$product->setItemPricew($itemPricew);
                            //$product->setItemPricer($itemPricer);
                            //
                                //echo $product->id." ".$product->erp_code." --> ".$qty." -- ".$product->getApothema()."<BR>";
                            $sql = "update softone_product set item_cccpriceupd = 1, item_cccref = '" . $product->getCccRef() . "'   where id = '" . $product->getId() . "'";
                            //$sql = "update softone_product set item_pricew = '" . $itemPricew . "', item_pricer = '" . $itemPricer . "', item_cccpriceupd = 1, item_cccref = '" . $product->getCccRef() . "'   where id = '" . $product->getId() . "'";

                            echo $sql . "<BR>";
                            //$em->getConnection()->exec($sql);
                            //$this->flushpersist($product);
                            //$product->toSoftone();

                            if ($newcccref)
                                $sql = "UPDATE MTRL SET CCCREF='" . $product->getCccRef() . "', CCCPRICEUPD=1, PRICEW = " . $itemPricew . ", PRICER = " . $itemPricer . "  WHERE MTRL = " . $product->getReference();
                            else
                                $sql = "UPDATE MTRL SET CCCPRICEUPD=1, PRICEW = " . $itemPricew . ", PRICER = " . $itemPricer . "  WHERE MTRL = " . $product->getReference();

                            $params["fSQL"] = $sql;
                            //$product->toSoftone();

                            //$softone = new Softone();
                            //$datas = $softone->createSql($params);
                            //unset($softone);
                            //echo $sql . "<BR>";
                            //sleep(5);

                            echo "</div>";
                        }
                    //} else {
                    //    echo "<span style='color:red'>" . $product->getItemCode() . " -- " . $product->getSupplierId()->getTitle() . " -- " . $product->getItemCode2() . " " . $ediitem->getWholesaleprice() . " -- " . $ediitem->getEdiMarkupPrice("itemPricew") . " -- " . $product->getItemPricew() . "</span><BR>";
                    //}
                } else {
                    //echo "<span style='color:red'>".$product->getItemCode().";".$product->getSupplierId()->getTitle().";" . $product->getItemCode2() . "</span><BR>";
                }
                //exit;
            }
        }
    }

}
