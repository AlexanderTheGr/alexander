<?php

namespace MegasoftBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customergrouprule
 *
 * @ORM\Table(name="customergrouprule", indexes={@ORM\Index(name="group", columns={"group"}), @ORM\Index(name="group_2", columns={"group"})})
 * @ORM\Entity
 */
class Customergrouprule {

    /**
     * @var string
     *
     * @ORM\Column(name="val", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected $val;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier", type="string", length=255, nullable=false)
     */
    protected $supplier;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \MegasoftBundle\Entity\Customergroup
     *
     * @ORM\ManyToOne(targetEntity="MegasoftBundle\Entity\Customergroup")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group", referencedColumnName="id")
     * })
     */
    protected $group;

    /**
     * Set val
     *
     * @param string $val
     *
     * @return Customergrouprule
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
     * Set supplier
     *
     * @param string $supplier
     *
     * @return Customergrouprule
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
     * @param \MegasoftBundle\Entity\Customergroup $group
     *
     * @return Customergrouprule
     */
    public function setGroup(\MegasoftBundle\Entity\Customergroup $group = null) {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \MegasoftBundle\Entity\Customergroup
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @var string
     */
    private $rule;

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return Customergrouprule
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
            $Manufacturer = $em->getRepository("MegasoftBundle:Manufacturer")
                    ->findOneBy(array('title' => $editem->getBrand()));
            if ($Manufacturer)
                $supplier = $Manufacturer->getId();
        } else {
            $supplier = $product->getManufacturer() ? $product->getManufacturer()->getId() : 0;
            $supplier2 = $product->getSupplier() ? $product->getSupplier()->getId() : 0;
            //$supplier = 0;
            if ($product->getProductsale()) {
                $productsale = $product->getProductsale()->getId();
            }
            $erpcode = $product->getErpCode();
        }
        //echo $supplier;
        //
        //echo $this->rulesLoop($rule, $catsEp, $supplier) ? "true" : "false";
        return $this->rulesLoop($rule, $catsEp, $supplier, $erpcode, $productsale,$supplier2);
    }

    function rulesLoop($rule, $catsEp, $supplier, $code, $productsale,$supplier2) {
        foreach ($rule["rules"] as $rl) {
            $r1 = $rule["rules"][$key];
            if (count($rl["rules"])) {
                $out = $this->rulesLoop($rl, $catsEp, $supplier, $code,$productsale,$supplier2);
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
                if ($rl["id"] == "supplier2") {
                    if ($supplier2 > 0) {
                        if ($rl["operator"] == "equal") {
                            if ($rl["value"] == $supplier2) {
                                return true;
                            }
                        }
                        if ($rl["operator"] == "not_equal") {
                            if ($rl["value"] != $supplier2) {
                                return true;
                            }
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

                if ($rl["id"] == "supplier2") {
                    if ($supplier2 > 0) {
                        if ($rl["operator"] == "equal") {
                            if ($rl["value"] == $supplier2) {
                                return true;
                            }
                        }
                        if ($rl["operator"] == "not_equal") {
                            if ($rl["value"] != $supplier2) {
                                return true;
                            }
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

    /**
     * @var integer
     */
    private $sortorder;

    /**
     * Set sortorder
     *
     * @param integer $sortorder
     *
     * @return Customergrouprule
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
     * @var string
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Customergrouprule
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
     * @var string
     */
    private $price;

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Customergrouprule
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

}
