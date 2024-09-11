<div style="page-break-after: always"></div>
<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Price Breakdown: <?php echo $proposal->getProjectName()  ?></h1>
<div id="price-breakdown">


<!--<p>&nbsp;</p>-->
<p>Please find the following breakdown of all services we have provided in this proposal.</p>
<p>This proposal originated on <?php echo date('F d, Y', $proposal->getCreated(false)) ?>.
    <?php
    $s = array('$', ',');
    $r = array('', '');

    if ($proposal->getJobNumber()) {
        ?>
        <strong>Job Number:</strong> <?php echo $proposal->getJobNumber() ?>
    <?php
    }
    ?>
</p>

<?php

    // Separate optional services, and no price services
    $optionalServices = [];
    $taxServices = [];
    $isMapDataAdded =false;
    $isMapDataAddedOS =false;
    foreach ($services as $k => $serviceItem) {
        if ($serviceItem->isOptional()) {
            unset($services[$k]);
            $optionalServices[] = $serviceItem;
            if($serviceItem->getMapAreaData() !=''){
                $isMapDataAddedOS =true;
            }
        }else{
            if($serviceItem->getMapAreaData() !=''){
                $isMapDataAdded =true;
            }

        }
        if($serviceItem->isNoPrice()) {
            unset($services[$k]);
        }
        if ($serviceItem->getTax()) {
            unset($services[$k]);
            $taxServices[] = $serviceItem;
        }
        
    }


    // Use standard layout for non-snow
    if(!$proposal->hasSnow()){
       
        
?>
        <div class="table-container">
            <table width="100%" class="table" border="0">
                <thead>
                <tr>
                    <td width="10%"><strong>Item</strong></td>
                    <td width="45%"><strong>Description</strong></td>
                    <?php if($isMapDataAdded){?><td width="25%"><strong>Map Area</strong></td> <?php }?>
                    <td width="20%" style="text-align: right"><strong>Cost</strong></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                $total = 0;
                $taxTotal = 0;
                $taxSubTotal = 0;
                $isTaxApplied =false;
                
                foreach ($services as $service) {
                    $k++;
                    $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                    ?>
                    <tr>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>><?php echo $k; ?>.</td>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>> <?php
                        if($taxprice>0){echo '<span style="font-weight:bold;vertical-align: sub;">* </span>'; $isTaxApplied =true;}
                            //fix for the price breakdown to show service name instead of Additional Service
                            echo $service->getServiceName();
                            ?></td>

                        <?php if($isMapDataAdded){?><td <?php if ($k % 2) {echo 'class="odd"';} ?>> <?php echo $service->getMapAreaData();?></td><?php } ?>
                    
                        <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                        <?php
                            // Price required for calculations
                            $price = (float) str_replace($s, $r, $service->getPrice());
                            

                            if ($lumpSum) {
                                echo 'Included';
                            }
                            else {
                                //echo $service->getFormattedPrice();
                                echo '$'.number_format(($price-$taxprice), 2); 
                            }
                        ?>
                        </td>
                    </tr>
                    <?php
                    $total += $price;
                    $taxSubTotal += $taxprice;
                }
                ?>
                </tbody>
                <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <?php if (count($taxServices)) { ?>
                        <tr>
                            <td></td>
                            <?php if($isMapDataAdded){?><td></td> <?php }?>
                            <td align="right">Subtotal:</td>
                            <td style="text-align: right">$<?php echo number_format($total, 2) ?></td>
                        </tr>
                        <?php
                        foreach ($taxServices as $taxService) {
                            $taxTotal += $taxService->getPrice(true);
                        }
                        ?>
                        <tr>
                            <td></td>
                            <?php if($isMapDataAdded){?><td></td> <?php }?>
                            <td align="right">Tax:</td>
                            <td style="text-align: right">$<?php echo number_format($taxTotal, 2) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($taxSubTotal>0) { ?>
                    <tr>
                            <td></td>
                            <?php if($isMapDataAdded){?><td></td> <?php }?>
                            <td align="right"><strong>Tax:</strong></td>
                            <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td></td>
                            <?php if($isMapDataAdded){?><td></td> <?php }?>
                            <td align="right"><strong>Total:</strong></td>
                            <td style="text-align: right"><strong>$<?php echo number_format($total + $taxTotal, 2) ?></strong></td>
                        </tr>
                        </tfoot>
                <?php
                }?>
            </table>
        </div>
<?php
        if (count($optionalServices)) {
?>
            <h2>Optional Services:</h2>
            <div class="table-container">
                <table width="100%" class="table" border="0">
                    <thead>
                    <tr>
                        <td width="10%"><strong>Item</strong></td>
                        <td width="45%"><strong>Description</strong></td>
                        <?php if($isMapDataAddedOS){?><td width="25%"><strong>Map Area</strong></td> <?php }?>
                        <td width="20%" style="text-align: right"><strong>Cost</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    $total = 0;
                    $taxSubTotal = 0;
                    $isTaxApplied =false;
                    foreach ($optionalServices as $service) {
                        $k++;
                        $taxprice = 0;
                        if ($service->getTaxPrice()) {
                            $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                        }
                        ?>
                        <tr>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>><?php echo $k; ?>.</td>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>>
                        <?php
                            if(floatval($taxprice > 0)){
                                echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                                $isTaxApplied = true;
                            }
                            //fix for the price breakdown to show service name instead of Additional Service
                            echo $service->getServiceName();
                        ?></td>
                        <?php if($isMapDataAddedOS){?><td <?php if ($k % 2) {echo 'class="odd"';} ?>> <?php echo $service->getMapAreaData();?></td><?php } ?>
                            <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                            <?php
                            // Price required for calculations
                            $price = (float) str_replace($s, $r, $service->getPrice());

                            //echo $service->getFormattedPrice();
                            echo '$'.number_format(($price - $taxprice), 2);
                        ?>
                        </td>
                    </tr>
                    <?php
                    $total += $price;
                    $taxSubTotal += $taxprice;

                    }
                    ?>
                    </tbody>
                    <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <?php if ($taxSubTotal>0) { ?>
                    <tr>
                        <td></td>
                        <?php if($isMapDataAddedOS){?><td></td> <?php }?>
                        <td align="right"><strong>Tax:</strong></td>
                        <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                    </tr>
                    <?php } ?>
                    <!--
                    <tr>
                        <td></td>
                        <td align="right"><strong>Total:</strong></td>
                        <td style="text-align: right"><strong>$<?php echo number_format($total + $taxSubTotal, 2) ?></strong></td>
                    </tr>
                    -->
                    </tfoot>
                    <?php } ?>
                </table>
            </div>
<?php
        }
    }
    else{
        // Snow proposal
?>
        <div class="table-container">
            <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size:15px">Service Pricing</h4>
            <table width="100%" class="table" border="0" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <td width="20"><strong>Item</strong></td>
                    <td width="200"><strong>Description</strong></td>
                    <td><strong>Freq.</strong></td>
                    <td><strong>Type</strong></td>
                    <td align="right"><strong>Price</strong></td>
                    <td align="right"><strong>Total</strong></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                $total = 0;
                $hiddenPrices = array('Noprice', 'Hour', 'Materials');
                $timeMaterialServices = array('Hour', 'Materials');
                $fixedPrices = array('Total', 'Year');
                $timeMaterial = false;
                foreach ($services as $service) {
                    if (in_array($service->getPricingType(), $timeMaterialServices)) {
                        $timeMaterial = true;
                    }
                    if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $timeMaterialServices)) {
                        $k++;
                        $class = ($k % 2) ? 'odd' : '';
                        ?>
                        <tr>
                            <td class="<?php echo $class; ?>"><?php echo $k; ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                //fix for the price breakdown to show service name instead of Additional Service
                                echo $service->getServiceName();
                                ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $fixedPrices)) {
                                    $amountQty = (is_numeric($service->getAmountQty())) ? $service->getAmountQty() : 0;
                                    echo $amountQty;
                                }
                                ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                switch ($service->getPricingType()) {
                                    case 'Total':
                                        echo 'Fixed Price';
                                        break;
                                    default:
                                        echo 'Per ' . $service->getPricingType();
                                        break;
                                }
                                ?></td>
                            <td align="right" class="<?php echo $class; ?>">$<?php
                                $price = (float) str_replace($s, $r, $service->getPrice());
                                echo @number_format($price, 2);
                                ?></td>
                            <td class="<?php echo $class; ?>" align="right"><?php
                                if (!in_array($service->getPricingType(), $hiddenPrices)) {
                                    if (in_array($service->getPricingType(), $fixedPrices)) {
                                        $amountQty = 1;
                                    }
                                    $partialTotal = ( (float) str_replace($s, $r, $price) * $amountQty);
                                    echo '$' . number_format($partialTotal, 2);
                                }
                                ?></td>
                        </tr>
                        <?php
                        if (!in_array($service->getPricingType(), $hiddenPrices)) {
                            $total += $partialTotal;
                        }
                    }
                }
                ?>
                </tbody>
                <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>Total</b></td>
                        <td align="right"><b>$<?php echo number_format($total, 2) ?></b></td>
                    </tr>
                    </tfoot>
                <?php } ?>
            </table>
            <?php if ($timeMaterial) { ?>
                <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size: 15px">Time & Material Items</h4>
                <table width="100%" class="table" border="0">
                    <thead>
                    <tr>
                        <td width="20"><strong>Item</strong></td>
                        <td width="350"><strong>Description</strong></td>
                        <td align="right"><strong>Price</strong></td>
                        <td align="right"><strong>Type</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    foreach ($services as $service) {
                        if (in_array($service->getPricingType(), $timeMaterialServices)) {
                            $k++;
                            $class = ($k % 2) ? 'odd' : '';
                            ?>
                            <tr>
                                <td class="<?php echo $class; ?>"><?php echo $k; ?></td>
                                <td class="<?php echo $class; ?>"><?php echo $service->getServiceName(); ?></td>
                                <td align="right" class="<?php echo $class; ?>">$<?php
                                    $price = (float) str_replace($s, $r, $service->getPrice());
                                    echo @number_format($price, 2);
                                    ?></td>
                                <td align="right" class="<?php echo $class; ?>">Per <?php echo ($service->getPricingType() != 'Materials') ? $service->getPricingType() : $service->getMaterial(); ?></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <?php
        if (count($optionalServices)) {
?>
            <h2>Optional Services:</h2>
            <div class="table-container">
                <table width="100%" class="table" border="0">
                    <thead>
                    <tr>
                        <td width="10%"><strong>Item</strong></td>
                        <td width="45%"><strong>Description</strong></td>
                        <?php if($isMapDataAddedOS){?><td width="25%"><strong>Map Area</strong></td> <?php }?>
                        <td width="20%" style="text-align: right"><strong>Cost</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    $total = 0;
                    $taxSubTotal = 0;
                    $isTaxApplied =false;
                    foreach ($optionalServices as $service) {
                        $k++;
                        $taxprice = 0;
                        if ($service->getTaxPrice()) {
                            $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                        }
                        ?>
                        <tr>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>><?php echo $k; ?>.</td>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>>
                        <?php
                            if(floatval($taxprice > 0)){
                                echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                                $isTaxApplied = true;
                            }
                            //fix for the price breakdown to show service name instead of Additional Service
                            echo $service->getServiceName();
                        ?></td>
                        <?php if($isMapDataAddedOS){?><td <?php if ($k % 2) {echo 'class="odd"';} ?>> <?php echo $service->getMapAreaData();?></td><?php } ?>
                            <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                            <?php
                            // Price required for calculations
                            $price = (float) str_replace($s, $r, $service->getPrice());

                            //echo $service->getFormattedPrice();
                            echo '$'.number_format(($price - $taxprice), 2);
                        ?>
                        </td>
                    </tr>
                    <?php
                    $total += $price;
                    $taxSubTotal += $taxprice;

                    }
                    ?>
                    </tbody>
                    <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <?php if ($taxSubTotal>0) { ?>
                    <tr>
                        <td></td>
                        <?php if($isMapDataAddedOS){?><td></td> <?php }?>
                        <td align="right"><strong>Tax:</strong></td>
                        <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                    </tr>
                    <?php } ?>
                    <!--
                    <tr>
                        <td></td>
                        <td align="right"><strong>Total:</strong></td>
                        <td style="text-align: right"><strong>$<?php echo number_format($total + $taxSubTotal, 2) ?></strong></td>
                    </tr>
                    -->
                    </tfoot>
                    <?php } ?>
                </table>
            </div>
<?php
    }}
    /*
    if($isTaxApplied){?> 
    <p><span style="font-weight:bold;vertical-align: sub;">*</span> Price excludes Tax</p>
    <?php 
    }
    */
?>
</div>
