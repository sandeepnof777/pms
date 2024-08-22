<?php
namespace Pms\Calculators\CalculatorValues;

use Pms\CalculatorValueInterface;

class TruckingCalculatorValue implements CalculatorValueInterface {

    public $trips;
    public $roundTime;
    public $roundsPerDay;
    public $tonsPerDayPerTruck;
    public $numTrucks;
    public $itemPrice;
    public $quantity;
    public $hoursPerTruck;
    public $profitPrice;
    public $overheadPrice;
    public $taxPrice;
    public $totalPrice;
    public $newProductionRate;
    public $trucksPerDay;
    public $NewDays;

    public function toJson() {
        return json_encode($this);
    }
}