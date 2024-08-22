<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_templates")
 */
class EstimationTemplate extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="integer", nullable=true))
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $deleted = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $fixed = 0;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_rate = 0.00;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $overhead_rate = 0.00;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $overhead_price = 0.00;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $profit_rate = 0.00;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $profit_price = 0.00;
     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $base_price = 0.00;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_empty = 0;
    
    function __construct()
    {
    }
     /**
     * @ORM\Column(type="integer")
     */
    private $calculation_type = 0;
    

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getFixed()
    {
        return $this->fixed;
    }

    /**
     * @param mixed $fixed
     */
    public function setFixed($fixed)
    {
        $this->fixed = $fixed;
    }

    /**
     * @return mixed
     */
    public function getPriceRate()
    {
        return $this->price_rate;
    }

    /**
     * @param mixed $price_rate
     */
    public function setPriceRate($price_rate)
    {
        $this->price_rate = $price_rate;
    }
    /**
     * @return mixed
     */
    public function getCalculationType()
    {
        return $this->calculation_type;
    }

    /**
     * @param mixed $calculation_type
     */
    public function setCalculationType($calculation_type)
    {
        $this->calculation_type = $calculation_type;
    }

    /**
     * @return mixed
     */
    public function getOverheadRate()
    {
        return $this->overhead_rate;
    }

    /**
     * @param mixed $overhead_rate
     */
    public function setOverheadRate($overhead_rate)
    {
        $this->overhead_rate = $overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getOverheadPrice()
    {
        return $this->overhead_price;
    }

    /**
     * @param mixed $overhead_price
     */
    public function setOverheadPrice($overhead_price)
    {
        $this->overhead_price = $overhead_price;
    }



    /**
     * @return mixed
     */
    public function getProfitRate()
    {
        return $this->profit_rate;
    }

    /**
     * @param mixed $overhead_rate
     */
    public function setProfitRate($profit_rate)
    {
        $this->profit_rate = $profit_rate;
    }

    /**
     * @return mixed
     */
    public function getProfitPrice()
    {
        return $this->profit_price;
    }

    /**
     * @param mixed $profit_price
     */
    public function setProfitPrice($profit_price)
    {
        $this->profit_price = $profit_price;
    }

    /**
     * @return mixed
     */
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * @param mixed $base_price
     */
    public function setbasePrice($base_price)
    {
        $this->base_price = $base_price;
    }

     /**
     * @return mixed
     */
    public function getIsEmpty()
    {
        return $this->is_empty;
    }

    /**
     * @param mixed $is_empty
     */
    public function setIsEmpty($is_empty)
    {
        $this->is_empty = $is_empty;
    }

    public function getItemCount(){
        $CI =& get_instance();

        $Items = $CI->em->createQuery('SELECT COUNT(eti.id) AS numItems
        FROM  models\EstimateTemplateItem eti
        WHERE eti.deleted = 0 AND eti.template_id =' . $this->getId() )->getResult();

        return $Items[0]['numItems'];
    }

}