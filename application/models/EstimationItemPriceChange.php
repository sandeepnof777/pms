<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_item_price_changes")
 */
class EstimationItemPriceChange extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $item_id;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $old_base_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $old_overhead_rate;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $old_profit_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $old_unit_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $old_tax_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_base_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $new_overhead_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_profit_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_unit_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $new_tax_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $old_overhead_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $old_profit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_overhead_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_profit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $ip;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $new_tax_price;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $account_id;
    /**
     * @ORM\Column(type="string")
     */
    private $user_name;
    
     /**
     * @ORM\Column(type="string")
     */
    private $details;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getOldBasePrice()
    {
        return $this->old_base_price;
    }

    /**
     * @param mixed $old_base_price
     */
    public function setOldBasePrice($old_base_price)
    {
        $this->old_base_price = $old_base_price;
    }

    /**
     * @return mixed
     */
    public function getOldOverheadRate()
    {
        return $this->old_overhead_rate;
    }

    /**
     * @param mixed $old_overhead_rate
     */
    public function setOldOverheadRate($old_overhead_rate)
    {
        $this->old_overhead_rate = $old_overhead_rate;
    }

    

    /**
     * @return mixed
     */
    public function getOldProfitRate()
    {
        return $this->old_profit_rate;
    }

    /**
     * @param mixed $old_profit_rate
     */
    public function setOldProfitRate($old_profit_rate)
    {
        $this->old_profit_rate = $old_profit_rate;
    }

    /**
     * @return mixed
     */
    public function getOldUnitPrice()
    {
        return $this->old_unit_price;
    }

    /**
     * @param mixed $old_unit_price
     */
    public function setOldUnitPrice($old_unit_price)
    {
        $this->old_unit_price = $old_unit_price;
    }

    /**
     * @return mixed
     */
    public function getOldTaxRate()
    {
        return $this->old_tax_rate;
    }

    /**
     * @param mixed $old_tax_rate
     */
    public function setOldTaxRate($old_tax_rate)
    {
        $this->old_tax_rate = $old_tax_rate;
    }

    /**
     * @return mixed
     */
    public function getNewBasePrice()
    {
        return $this->new_base_price;
    }
    /**
     * @param mixed $new_base_price
     */
    public function setNewBasePrice($new_base_price)
    {
        $this->new_base_price = $new_base_price;
    }

    /**
     * @return mixed
     */
    public function getNewOverheadRate()
    {
        return $this->new_overhead_rate;
    }

    /**
     * @param mixed $new_overhead_rate
     */
    public function setNewOverheadRate($new_overhead_rate)
    {
        $this->new_overhead_rate = $new_overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getNewProfitRate()
    {
        return $this->new_profit_rate;
    }

    /**
     * @param mixed $new_profit_rate
     */
    public function setNewProfitRate($new_profit_rate)
    {
        $this->new_profit_rate = $new_profit_rate;
    }

    /**
     * @return mixed
     */
    public function getNewUnitPrice()
    {
        return $this->new_unit_price;
    }

    /**
     * @param mixed $new_unit_price
     */
    public function setNewUnitPrice($new_unit_price)
    {
        $this->new_unit_price = $new_unit_price;
    }

    /**
     * @return mixed
     */
    public function getNewTaxRate()
    {
        return $this->new_tax_rate;
    }

    /**
     * @param mixed $new_tax_rate
     */
    public function setNewTaxRate($new_tax_rate)
    {
        $this->new_tax_rate = $new_tax_rate;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getOldOverheadPrice()
    {
        return $this->old_overhead_price;
    }

    /**
     * @param mixed $custom_unit_price
     */
    public function setOldOverheadPrice($old_overhead_price)
    {
        $this->old_overhead_price = $old_overhead_price;
    }


    
    /**
     * @return mixed
     */
    public function getOldProfitPrice()
    {
        return $this->old_profit_price;
    }

    /**
     * @param mixed $old_profit_price
     */
    public function setOldProfitPrice($old_profit_price)
    {
        $this->old_profit_price = $old_profit_price;
    }

    /**
     * @return mixed
     */
    public function getNewOverheadPrice()
    {
        return $this->new_overhead_price;
    }

    /**
     * @param mixed $trucking_overhead_price
     */
    public function setNewOverheadPrice($new_overhead_price)
    {
        $this->new_overhead_price = $new_overhead_price;
    }

    /**
     * @return mixed
     */
    public function getNewProfitPrice()
    {
        return $this->new_profit_price;
    }

    /**
     * @param mixed $new_profit_price
     */
    public function setNewProfitPrice($new_profit_price)
    {
        $this->new_profit_price = $new_profit_price;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getNewTaxPrice()
    {
        return $this->new_tax_price;
    }

    /**
     * @param mixed $new_tax_price
     */
    public function setNewTaxPrice($new_tax_price)
    {
        $this->new_tax_price = $new_tax_price;
    }

   
    /**
     * @return mixed
     */
    public function getDetail()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetail($details)
    {
        $this->details = $details;
    }

    
}