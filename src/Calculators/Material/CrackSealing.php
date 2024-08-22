<?php
namespace Pms\Calculators\Material;

use Pms\CalculatorInterface;
use Pms\Calculators\CalculatorValues\CreckSealingCalculatorValue;
use Pms\Traits\RepositoryTrait;

class CrackSealing implements CalculatorInterface
{
    use RepositoryTrait;

    private $width;
    private $length;
    private $depth;
    private $itemBasePrice;
    private $ohRate;
    private $pmRate;
    private $taxRate;
    // private $multiplier = 0.055;

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
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


    public function run()
    {
        // Check we have everything
        if (
            is_null($this->getWidth()) ||
            is_null($this->getLength()) ||
            is_null($this->getDepth()) ||
            is_null($this->getItemBasePrice()) ||
            is_null($this->getOhRate()) ||
            is_null($this->getPmRate()) ||
            is_null($this->getTaxRate())
        ) {
            throw new \Exception('Not all calculation parameters were supplied');
        }

        //$width = $_POST['width'];
                //$depth = $_POST['depth'];
                $feetPerUnit = $this->width * $this->depth;
                $product = '0';
                if ($product == 1) {
                    $feetPerUnit = $feetPerUnit * 12.5;
                } else {
                    $feetPerUnit = $feetPerUnit * 2;
                }
                
        $quantity = round(($this->length / $feetPerUnit),2);
        
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
        $response = new CreckSealingCalculatorValue();
        $response->itemPrice = $itemUnitPrice;
        $response->quantity = $quantity;
        $response->costPerUnit = 0;
        $response->profitPrice = $profitPrice;
        $response->overheadPrice = $overheadPrice;
        $response->taxPrice = $taxPrice;
        $response->totalPrice = $totalPrice;

        return $response;
    }


}