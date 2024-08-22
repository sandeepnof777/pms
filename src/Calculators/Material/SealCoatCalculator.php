<?php
namespace Pms\Calculators\Material;

use Pms\CalculatorInterface;
use Pms\Calculators\CalculatorValues\SeaCoatCalculatorValue;
use Pms\Traits\RepositoryTrait;

class SealCoatCalculator implements CalculatorInterface
{
    use RepositoryTrait;
    
    private $area;
    private $applicationRate;
    private $water;
    private $additive;
    private $additivePrice;
    private $sand;
    private $sandPrice;
    private $itemBasePrice;
    private $ohRate;
    private $pmRate;
    private $taxRate;
    // private $multiplier = 0.055;

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }
    /**
     * @return mixed
     */
    public function getApplicationRate()
    {
        return $this->applicationRate;
    }

    /**
     * @param mixed $applicationRate
     */
    public function setApplicationRate($applicationRate)
    {
        $this->applicationRate = $applicationRate;
    }

    /**
     * @return mixed
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * @param mixed $water
     */
    public function setWater($water)
    {
        $this->water = $water;
    }

    /**
     * @return mixed
     */
    public function getAdditive()
    {
        return $this->additive;
    }

    /**
     * @param mixed $additive
     */
    public function setAdditive($additive)
    {
        $this->additive = $additive;
    }

    /**
     * @return mixed
     */
    public function getAdditivePrice()
    {
        return $this->additivePrice;
    }

    /**
     * @param mixed $additivePrice
     */
    public function setAdditivePrice($additivePrice)
    {
        $this->additivePrice = $additivePrice;
    }

    /**
     * @return mixed
     */
    public function getSand()
    {
        return $this->sand;
    }

    /**
     * @param mixed $sand
     */
    public function setSand($sand)
    {
        $this->sand = $sand;
    }

    /**
     * @return mixed
     */
    public function getSandPrice()
    {
        return $this->sandPrice;
    }

    /**
     * @param mixed $sandPrice
     */
    public function setSandPrice($sandPrice)
    {
        $this->sandPrice = $sandPrice;
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
            is_null($this->getArea()) ||
            is_null($this->getApplicationRate()) ||
            // is_null($this->getWater()) ||
            // is_null($this->getAdditive()) ||
            // is_null($this->getAdditivePrice()) ||
            // is_null($this->getSand()) ||
            // is_null($this->getSandPrice()) ||
            is_null($this->getItemBasePrice()) ||
            is_null($this->getOhRate()) ||
            is_null($this->getPmRate()) ||
            is_null($this->getTaxRate())
        ) {
            throw new \Exception('Not all calculation parameters were supplied');
        }







        $area = str_replace(',', '', $this->area);
        $quantity = $area * $this->applicationRate;
//print_r($this->applicationRate);die;
        // $response['sealer'] = $sealer;

        // $water = $sealer * $this->water / 100;

        // $response['water'] = $water;

        // $additive = $sealer * $this->additive / 100;

        // $response['additive'] = $additive;

        // $sealerConcentrate = $sealer - $water - $additive;

        // $sand = $sealer * $this->sand;

        // $response['sand'] = $sand;

        // $sandInGall = $sand / 22.3;

        // $response['sandInGall'] = $sandInGall;

        // $totalGallons = $sealer + $water + $additive + $sandInGall;

        // $response['totalGallons'] = $totalGallons;

        // //calculate material costs
        // $sealerPrice = str_replace(',', '', $this->sealerPrice);

        // $sealerCost = $sealerPrice * $sealer;

        // $sealerCostPerUnit = ($area != 0) ? $sealerCost / $area : 0;

        // $response['sealerCost'] = $sealerCost;

        // $response['sealerCostPerUnit'] = $sealerCostPerUnit;

        // $sandPrice = str_replace(',', '', $this->sandPrice);

        // $sandCost = $sandPrice * $sand / 100;

        // $response['sandCost'] = $sandCost;

        // $sandCostPerUnit = ($area != 0) ? $sandCost / $area : 0;

        // $response['sandCostPerUnit'] = $sandCostPerUnit;

        // $additivePrice = str_replace(',', '', $this->additivePrice);

        // $additiveCost = $additive * $additivePrice;

        // $response['additiveCost'] = $additiveCost;

        // $additiveCostPerUnit = ($area != 0) ? $additiveCost / $area : 0;

        // $response['additiveCostPerUnit'] = $additiveCostPerUnit;

        // $materialCost = $sealerCost + $sandCost + $additiveCost;

        // $response['materialCost'] = $materialCost;

        // $materialCostPerUnit = ($area != 0) ? $materialCost / $area : 0;

        // $response['materialCostPerUnit'] = $materialCostPerUnit;

        // //calculate labor
        
        
        
        











        // //$width = $_POST['width'];
        //         //$depth = $_POST['depth'];
        //         $feetPerUnit = $this->width * $this->depth;
        //         $product = '0';
        //         if ($product == 1) {
        //             $feetPerUnit = $feetPerUnit * 12.5;
        //         } else {
        //             $feetPerUnit = $feetPerUnit * 2;
        //         }
                
        //$quantity = round(($this->length / $feetPerUnit),2);
        
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
        $response = new SealCoatCalculator();
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