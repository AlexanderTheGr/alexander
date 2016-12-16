<?php

namespace SoftoneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customergrouprule
 *
 * @ORM\Table(name="customergrouprule", indexes={@ORM\Index(name="group", columns={"group"}), @ORM\Index(name="group_2", columns={"group"})})
 * @ORM\Entity
 */
class Customergrouprule
{
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
     * @var \SoftoneBundle\Entity\Customergroup
     *
     * @ORM\ManyToOne(targetEntity="SoftoneBundle\Entity\Customergroup")
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
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string
     */
    public function getVal()
    {
        return $this->val;
    }

    /**
     * Set supplier
     *
     * @param string $supplier
     *
     * @return Customergrouprule
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get supplier
     *
     * @return string
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set group
     *
     * @param \SoftoneBundle\Entity\Customergroup $group
     *
     * @return Customergrouprule
     */
    public function setGroup(\SoftoneBundle\Entity\Customergroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \SoftoneBundle\Entity\Customergroup
     */
    public function getGroup()
    {
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
    public function setRule($rule)
    {
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
    
    function validateRule($product) {
        global $kernel;
        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');          
        $cats = $product->getCats();
        $rule = json_decode($this->rule,true);
        $categories = $em->getRepository("SoftoneBundle:Category")->findById($cats);
        $categoriesArr = array();
        $catsEp = array();
        foreach ($categories as $category) {
            $catsEp[] = $category->getSortCode();
            $pcategory = $em->getRepository("SoftoneBundle:Category")->find($category->getParent());
            $catsEp[] = $pcategory->getSortCode();
        }
        print_r($catsEp);
        $this->rulesLoop($rule,$catsEp);
    }
    function rulesLoop($rule,$catsEp) {
        foreach ($rule["rules"] as $rl ) {
            if ($rl["rule"]) {
                $this->rulesLoop($rule,$catsEp);
            }
            if ($rl["id"] == "category") {
                if ($rl["operator"] == "equal") {
                    
                }
            }
        }
    }
}
