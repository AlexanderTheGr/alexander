<?php

namespace MegasoftBundle\Entity;

/**
 * Customerrule
 */
class Customerrule {

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
     * @var \MegasoftBundle\Entity\Customer
     */
    private $customer;

    /**
     * Set val
     *
     * @param string $val
     *
     * @return Customerrule
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
     * @return Customerrule
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
     * @return Customerrule
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
     * @return Customerrule
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
     * @return Customerrule
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
     * Set customer
     *
     * @param \MegasoftBundle\Entity\Customer $customer
     *
     * @return Customerrule
     */
    public function setCustomer(\MegasoftBundle\Entity\Customer $customer = null) {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \MegasoftBundle\Entity\Customer
     */
    public function getCustomer() {
        return $this->customer;
    }
    
    function validateRule($product, $editem = false) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        if ($editem) {
            $cats = $editem->getCats();
        } else {
            $cats = $product->getCats();
        }

        $rule = json_decode($this->rule, true);
        $categories = $em->getRepository("MegasoftBundle:Category")->findById($cats);
        $categoriesArr = array();
        $catsEp = array();
        //print_r($cats);
        foreach ($categories as $category) {
            $catsEp[] = $category->getSortCode();
            $pcategory = $em->getRepository("MegasoftBundle:Category")->find($category->getParent());
            $catsEp[] = $pcategory->getSortCode();
        }
        //print_r($catsEp);
        $supplier = 122220;
        $productsale = 1;
        $erpcode = '';
        if ($editem) {
            $MegasoftSupplier = $em->getRepository("MegasoftBundle:MegasoftSupplier")
                    ->findOneBy(array('title' => $editem->getBrand()));
            if ($MegasoftSupplier)
                $supplier = $MegasoftSupplier->getId();
        } else {
            $supplier = $product->getSupplier() ? $product->getSupplier()->getId() : 0;
            if ($product->getProductsale()) {
                $productsale = $product->getProductsale()->getId();
            }
            $erpcode = $product->getErpCode();
        }
        //
        //echo $this->rulesLoop($rule, $catsEp, $supplier) ? "true" : "false";
        return $this->rulesLoop($rule, $catsEp, $supplier, $erpcode, $productsale);
    }

    function rulesLoop($rule, $catsEp, $supplier, $code, $productsale) {
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

                if ($rl["id"] == "productsale") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] == $productsale) {
                            return true;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] != $productsale) {
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


                if ($rl["id"] == "productsale") {
                    if ($rl["operator"] == "equal") {
                        if ($rl["value"] != $productsale) {
                            return false;
                        }
                    }
                    if ($rl["operator"] == "not_equal") {
                        if ($rl["value"] == $productsale) {
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
}
