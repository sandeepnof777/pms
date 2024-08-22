<?php
namespace Pms\Calculators\CalculatorValues;

use Pms\CalculatorValueInterface;

class SeaCoatCalculatorValue implements CalculatorValueInterface {

    public $itemPrice;
    public $quantity;
    public $costPerUnit;
    public $profitPrice;
    public $overheadPrice;
    public $taxPrice;
    public $totalPrice;

    public function toJson() {
        return json_encode($this);
    }
}