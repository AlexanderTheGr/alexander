<?php

namespace EdiBundle\Entity;

/**
 * Edirule
 */
class Edirule {

    /**
     * @var string
     */
    private $val;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $title;

    /**
     * @var integer
     */
    private $sortorder;

    /**
     * @var string
     */
    private $rule;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \EdiBundle\Entity\Edi
     */
    private $edi;

    /**
     * Set val
     *
     * @param string $val
     *
     * @return Edirule
     */
    public function setVal($val) {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal() {
        return $this->val;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Edirule
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Edirule
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
     * Set sortorder
     *
     * @param integer $sortorder
     *
     * @return Edirule
     */
    public function setSortorder($sortorder) {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer
     */
    public function getSortorder() {
        return $this->sortorder;
    }

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return Edirule
     */
    public function setRule($rule) {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule() {
        return $this->rule;
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
     * Set group
     *
     * @param \EdiBundle\Entity\Edi $edi
     *
     * @return Edirule
     */
    public function setEdi(\EdiBundle\Entity\Edi $edi = null) {
        $this->edi = $edi;

        return $this;
    }

    /**
     * Get group
     *
     * @return \EdiBundle\Entity\Edi
     */
    public function getEdi() {
        return $this->group;
    }

    function validateRule($ediitem) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        //$ediitem->tecdoc = new Tecdoc();
        if (!$ediitem->getCats()) {
            $ediitem->updatetecdoc(true);
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $cats = $ediitem->getCats();
        $rule = json_decode($this->rule, true);
        $categories = $em->getRepository("SoftoneBundle:Category")->findById($cats);
        $categoriesArr = array();
        $catsEp = array();
        //print_r($cats);
        foreach ($categories as $category) {
            $catsEp[] = $category->getSortCode();
            $pcategory = $em->getRepository("SoftoneBundle:Category")->find($category->getParent());
            $catsEp[] = $pcategory->getSortCode();
        }
        //echo $ediitem->getBrand();
        $SoftoneSupplier = $em->getRepository("SoftoneBundle:SoftoneSupplier")
                ->findOneBy(array('title' => $this->fix($ediitem->getBrand())));
        
        //print_r($rule);
        
        if ($SoftoneSupplier)
            $supplier = $SoftoneSupplier->getId();
        
        //$supplier = $ediitem->getSupplierId()->getId();
        //echo $this->rulesLoop($rule, $catsEp, $supplier) ? "true" : "false";
        return $this->rulesLoop($rule, $catsEp, $supplier, $ediitem->getItemCode());
    }

    
    function fix($supplier) {
        $supplier = str_replace("MANN", "MANN-FILTER", $supplier);
        $supplier = str_replace("MEAT&DORIA", "MEAT & DORIA", $supplier);
        $supplier = str_replace("BEHR-HELLA", "BEHR HELLA SERVICE", $supplier);
        $supplier = str_replace("BLUEPRINT", "BLUE-PRINT", $supplier);
        $supplier = str_replace("BLUE PRINT", "BLUE-PRINT", $supplier);
        $supplier = str_replace("BENDIX WBK", "BENDIX", $supplier);
        $supplier = str_replace("CONTI-TECH", "CONTITECH", $supplier);
        $supplier = str_replace("Fai AutoParts", "FAI AutoParts", $supplier);
        $supplier = str_replace("FIAAM", "COOPERSFIAAM FILTERS", $supplier);
        $supplier = str_replace("FIBA", "FI.BA", $supplier);
        $supplier = str_replace("FLENOR", "FLENNOR", $supplier);
        $supplier = str_replace("FRITECH", "fri.tech.", $supplier);
        $supplier = str_replace("HERTH & BUSS JAKOPARTS", "HERTH+BUSS JAKOPARTS", $supplier);
        $supplier = str_replace("KAYABA", "KYB", $supplier);
        $supplier = str_replace("KM", "KM Germany", $supplier);
        $supplier = str_replace("LUK", "LuK", $supplier);
        $supplier = str_replace("FEBI BILSTEIN BILSTEIN", "FEBI BILSTEIN", $supplier);
        $supplier = str_replace("COOPERSCOOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        $supplier = str_replace("COOPERSCOOPERSCOOPERSFIAAM FILTERS FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        $supplier = str_replace("COOPERSCOOPERSFIAAM FILTERS FILTERS", "COOPERSFIAAM FILTERS", $supplier);
        $supplier = str_replace("MANN", "MANN-FILTER", $supplier);
        $supplier = str_replace("MANN-FILTER-FILTER", "MANN-FILTER", $supplier);
        $supplier = str_replace("MANN-FILTEREX", "MANN-FILTER", $supplier);
        $supplier = str_replace("METALCAUCHO", "Metalcaucho", $supplier);
        $supplier = str_replace("MULLER", "MULLER FILTER", $supplier);
        $supplier = str_replace("RICAMBI", "GENERAL RICAMBI", $supplier);
        $supplier = str_replace("VERNET", "CALORSTAT by Vernet", $supplier);
        $supplier = str_replace("ZIMMERMANN-FILTER", "ZIMMERMANN", $supplier);
        $supplier = str_replace("FEBI", "FEBI BILSTEIN", $supplier);
        $supplier = str_replace("LESJ?FORS", "LESJOFORS", $supplier);
        $supplier = str_replace("LEMF?RDER", "LEMFORDER", $supplier);
        return $supplier;
    }   
    
    function rulesLoop($rule, $catsEp, $supplier, $code) {
        foreach ($rule["rules"] as $rl) {

            if (count($rl["rules"])) {
                $out = $this->rulesLoop($rl, $catsEp, $supplier, $code);
                if ($rule["condition"] == "OR" AND $out == true) {
                    return true;
                }
                if ($rule["condition"] == "AND" AND $out == false) {
                    return false;
                }
            }
            if ($rule["condition"] == "OR") {
                $out = false;
                if ($rl["id"] == "default") {
                    return true;
                }                
                if ($rl["id"] == "category") {
                    if ($rl["operator"] == "equal") {
                        if (in_array($rl["value"], $catsEp)) {
                            return true;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if (!in_array($rl["value"], $catsEp)) {
                            return true;
                        }
                    }
                }
                if ($rl["id"] == "supplier") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] == $supplier) {
                            return true;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] != $supplier) {
                            return true;
                        }
                    }
                }

                if ($rl["id"] == "code") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] == $code) {
                            return true;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] != $code) {
                            return true;
                        }
                    }
                }
            } elseif ($rule["condition"] == "AND") {
                $out = true;
                if ($rl["id"] == "default") {
                    return true;
                }
                if ($rl["id"] == "category") {
                    if ($rl["operator"] == "equal") {
                        if (!in_array($rl["value"], $catsEp)) {
                            return false;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if (in_array($rl["value"], $catsEp)) {
                            return false;
                        }
                    }
                }
                if ($rl["id"] == "supplier") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] != $supplier) {
                            return false;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] == $supplier) {
                            return false;
                        }
                    }
                }
                if ($rl["id"] == "code") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] != $code) {
                            return false;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] == $code) {
                            return false;
                        }
                    }
                }
            }
        }
        return $out;
    }

    /**
     * @var string
     */
    private $price_field;

    /**
     * Set priceField
     *
     * @param string $priceField
     *
     * @return Edirule
     */
    public function setPriceField($priceField) {
        $this->price_field = $priceField;

        return $this;
    }

    /**
     * Get priceField
     *
     * @return string
     */
    public function getPriceField() {
        return $this->price_field;
    }

}
