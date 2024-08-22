<?php
namespace Pms\Calculators\Material;

use Pms\CalculatorInterface;
use Pms\Calculators\CalculatorValues\TimeCalculatorValue;

class TimeCalculator implements CalculatorInterface
{
    private $quantity;
    private $days;
    private $hoursPerDay;
    private $itemBasePrice;
    private $ohRate;
    private $pmRate;
    private $taxRate;
    private $unitType;

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getHoursPerDay()
    {
        return $this->hoursPerDay;
    }

    /**
     * @param mixed $hoursPerDay
     */
    public function setHoursPerDay($hoursPerDay)
    {
        $this->hoursPerDay = $hoursPerDay;
    }


    /**
     * @return mixed
     */
    public function getItemBasePrice()
    {
        return $this->itemBasePrice;
    }

    /**
     * @param mixed $itemBasePrice
     */
    public function setItemBasePrice($itemBasePrice)
    {
        $this->itemBasePrice = $itemBasePrice;
    }

    /**
     * @return mixed
     */
    public function getOhRate()
    {
        return $this->ohRate;
    }

    /**
     * @param mixed $ohRate
     */
    public function setOhRate($ohRate)
    {
        $this->ohRate = $ohRate;
    }

    /**
     * @return mixed
     */
    public function getPmRate()
    {
        return $this->pmRate;
    }

    /**
     * @param mixed $pmRate
     */
    public function setPmRate($pmRate)
    {
        $this->pmRate = $pmRate;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param mixed $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return mixed
     */
    public function getUnitType()
    {
        return $this->unitType;
    }

    /**
     * @param mixed $unitType
     */
    public function setUnitType($unitType)
    {
        $this->unitType = $unitType;
    }

    /**
     * @return AsphaltCalculatorValue
     * @throws \Exception
     */
    public function run()
    {
        // Check we have everything
        if (
            is_null($this->getQuantity()) ||
            is_null($this->getDays()) ||
            is_null($this->getHoursPerDay()) ||
            is_null($this->getItemBasePrice()) ||
            is_null($this->getOhRate()) ||
            is_null($this->getPmRate()) ||
            is_null($this->getTaxRate())||
            is_null($this->getUnitType())
        ) {
            throw new \Exception('Not all calculation parameters were supplied');
        }

        // Get the quantity
        if($this->unitType=='Day'){
            $quantity = ($this->quantity * $this->days);
        }else{
            $quantity = ($this->quantity * $this->days * $this->hoursPerDay);
        }
        

        // Calculate overhead
        $unitOverheadPrice = ($this->itemBasePrice * $this->ohRate) / 100;
        $overheadPrice = $unitOverheadPrice * $quantity;

        // Calculate profit
        $unitProfitPrice = ($this->itemBasePrice * $this->pmRate) / 100;
        $profitPrice = $unitProfitPrice * $quantity;

        // Calculate Unit Price
        $itemUnitPrice = $this->itemBasePrice + $unitOverheadPrice + $unitProfitPrice;

        // Pre Tax total
        $preTaxTotal = $itemUnitPrice * $quantity;

        // Tax Amount
        $taxPrice = $preTaxTotal * ($this->taxRate / 100);

        // Total Price
        $totalPrice = $preTaxTotal + $taxPrice;

        // Cost Per Unit
        //$costPerUnit = $preTaxTotal / $this->measurement;

        // Response
        $response = new TimeCalculatorValue();
        $response->itemPrice = $itemUnitPrice;
        $response->quantity = $quantity;
        $response->overheadUnitPrice = $unitOverheadPrice;
        $response->profitUnitPrice = $unitProfitPrice;
        $response->profitPrice = $profitPrice;
        $response->overheadPrice = $overheadPrice;
        $response->taxPrice = $taxPrice;
        $response->totalPrice = $totalPrice;

        return $response;
    }


}