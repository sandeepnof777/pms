<?php
namespace Pms\Calculators\Material;

use Pms\CalculatorInterface;
use Pms\Calculators\CalculatorValues\TruckingCalculatorValue;

class TruckingCalculator implements CalculatorInterface
{
    private $tons;
    private $capacity;
    private $tripTime;
    private $plantTime;
    private $siteTime;
    private $hoursPerDay;
    private $days;
    private $trucksPerDay;
    private $itemBasePrice;
    private $ohRate;
    private $pmRate;
    private $taxRate;
    private $maxProductionRate;
    private $oldProductionRate;

    /**
     * @return mixed
     */
    public function getTons()
    {
        return $this->tons;
    }

    /**
     * @param mixed $tons
     */
    public function setTons($tons)
    {
        $this->tons = $tons;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed
     */
    public function getTripTime()
    {
        return $this->tripTime;
    }

    /**
     * @param mixed $tripTime
     */
    public function setTripTime($tripTime)
    {
        $this->tripTime = $tripTime;
    }

    /**
     * @return mixed
     */
    public function getPlantTime()
    {
        return $this->plantTime;
    }

    /**
     * @param mixed $plantTime
     */
    public function setPlantTime($plantTime)
    {
        $this->plantTime = $plantTime;
    }

    /**
     * @return mixed
     */
    public function getSiteTime()
    {
        return $this->siteTime;
    }

    /**
     * @param mixed $siteTime
     */
    public function setSiteTime($siteTime)
    {
        $this->siteTime = $siteTime;
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
    public function getTrucksPerDay()
    {
        return $this->trucksPerDay;
    }

    /**
     * @param mixed $trucksPerDay
     */
    public function setTrucksPerDay($trucksPerDay)
    {
        $this->trucksPerDay = $trucksPerDay;
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
    public function getMaxProductionRate()
    {
        return $this->maxProductionRate;
    }

    /**
     * @param mixed $maxProductionRate
     */
    public function SetMaxProductionRate($maxProductionRate)
    {
        $this->maxProductionRate = $maxProductionRate;
    }

    /**
     * @return mixed
     */
    public function getOldProductionRate()
    {
        return $this->oldProductionRate;
    }

    /**
     * @param mixed $oldProductionRate
     */
    public function SetOldProductionRate($oldProductionRate)
    {
        $this->oldProductionRate = $oldProductionRate;
    }

    /**
     * @return AsphaltCalculatorValue
     * @throws \Exception
     */
    public function run()
    {
        // Check we have everything
        if (
            is_null($this->getTons()) ||
            is_null($this->getCapacity()) ||
            is_null($this->getTripTime()) ||
            is_null($this->getPlantTime()) ||
            is_null($this->getSiteTime()) ||
            is_null($this->getHoursPerDay()) ||
            is_null($this->getDays()) ||
            is_null($this->getItemBasePrice()) ||
            is_null($this->getOhRate()) ||
            is_null($this->getPmRate()) ||
            is_null($this->getTaxRate()) ||
            is_null($this->getmaxProductionRate()) ||
            is_null($this->getoldProductionRate()) ||
            is_null($this->gettrucksPerDay())
        ) {
            throw new \Exception('Not all calculation parameters were supplied');
        }

        // NUm trips - rounded up as we need an integer
         $numTrips = ceil($this->tons / $this->capacity);
        
        // Round Time
         $roundTime = ($this->tripTime * 2) + ($this->plantTime * 60) + ($this->siteTime * 60);
         
        // Round per day (rounded down for complete trips)
         $roundsPerDay = floor(($this->hoursPerDay * 60) / $roundTime);

        // Tons per day per truck
        $tonsPerDayPerTruck = $this->capacity * $roundsPerDay;

        // Number of trucks
        $numTrucks = ceil($this->tons / $tonsPerDayPerTruck);

        // Total hours - this is the quantity
        $quantity = ($numTrips * $roundTime) / 60;
       // echo 'siteTime-'.$this->siteTime;
//echo '<br/>';
     // echo $quantity;
//echo '<br/>';

//var ton_day_per_truck = Math.ceil($roundsPerDay * $this->capacity);
//  echo 'old'.$this->oldProductionRate;
//  echo '<br/>';
//  echo 'tons'.$this->tons;
//  echo '<br/>';
// die;
if($this->oldProductionRate < $this->tons){

    if((int)$this->tons < (int)$this->maxProductionRate){
        $this->oldProductionRate =$this->tons;
    }else{
        $this->oldProductionRate =$this->maxProductionRate;
    }
    $this->trucksPerDay = floor($this->oldProductionRate/$tonsPerDayPerTruck);
    $newDays = $this->days;
    // echo $tonsPerDayPerTruck;
    // echo '<br/>';
    // echo $this->trucksPerDay;
    // echo '<br/>';
    if($this->trucksPerDay==0){
        $this->trucksPerDay =1;
    }
    $tons_per_day = $tonsPerDayPerTruck*$this->trucksPerDay;
    //echo $tons_per_day;die;
    $newDays =ceil($this->tons/$tons_per_day);
}else{
    $this->oldProductionRate =$this->tons;
    $this->trucksPerDay = floor($this->oldProductionRate/$tonsPerDayPerTruck);
    if($this->trucksPerDay ==0){$this->trucksPerDay =1;}
    $tons_per_day = ($tonsPerDayPerTruck*$this->trucksPerDay) ? $tonsPerDayPerTruck*$this->trucksPerDay : 1;
    $newDays =ceil($this->tons/$tons_per_day);
    
}
 
if($this->trucksPerDay==0){$this->trucksPerDay=1;}
        $temp_in_out_trip = ($this->tripTime / 60);
        // echo $reduce_in_out_time = ($numTrucks *$temp_in_out_trip);
         $temp_total_trucking = ceil($newDays) * floor($this->trucksPerDay);

          $reduce_in_out_time = ($temp_total_trucking *$temp_in_out_trip);
         
        $quantity  = $quantity - $reduce_in_out_time;

        $hoursPerTruck = ($quantity /floor($this->trucksPerDay));

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
        $response = new TruckingCalculatorValue();
        $response->trips = $numTrips;
        $response->roundTime = $roundTime;
        $response->roundsPerDay = $roundsPerDay;
        $response->numTrucks = $numTrucks;
        $response->tonsPerDayPerTruck = $tonsPerDayPerTruck;
        $response->itemPrice = $itemUnitPrice;
        $response->quantity = $quantity;
        $response->hoursPerTruck  = round($hoursPerTruck, 2);
        $response->profitPrice = $profitPrice;
        $response->overheadPrice = $overheadPrice;
        $response->taxPrice = $taxPrice;
        $response->totalPrice = $totalPrice;
        $response->trucksPerDay = $this->trucksPerDay;
        $response->newProductionRate = $this->oldProductionRate;
        $response->newDays = $newDays;

        return $response;
    }


}