<div class="row" style="margin-bottom:0px">

                        <div class="col s12">

                            <table id="estimateSummaryItems" class="" style="width: 100%;text-align: right;">
                                <thead>
                                <tr>
                                    <th width="20%" style="text-align: left;">Category</th>
                                    
                                    <!-- <th width="20%" style="text-align: right;">Profit</th> -->
                                    <th width="20%" style="text-align: center;">PM %</th>
                                    
                                    <th width="20%" style="text-align: center;">Total %</th>
                                    <th width="20%" style="text-align: right;">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $finaltotal = 0;
                                $overheadtotal = 0;
                                $profittotal = 0;
                                $taxtotal = 0;
                                $basetotal = 0;

                                foreach ($sortedItems as $tsortedItem) { ?>
                                    <?php $rowTotal = 0;
                                    $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                    $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                    $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                    $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                    $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                    ?>
                                    <tr>
                                        <td style="text-align: left;"><?php echo $tsortedItem['category']->getName(); ?></td>
                                       
                                        <!-- <td style="text-align: right;">
                                            $<?php //echo number_format($tsortedItem['aggregateProfitPrice'], 2, '.', ','); ?> </td> -->
                                        <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateProfitRate'], 2, '.', ','); ?>%
                                        </td>
                                       
                                        <td><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice())* 100), 2)  ?>%</td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($tsortedItem['aggregateTotalRate'], 2, '.', ','); ?> </td>

                                    </tr>
                                <?php }
                                foreach ($subContractorItems as $tsortedItem) { ?>
                                    <?php $rowTotal = 0;
                                    $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                    $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                    $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                    $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                    $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                    ?>
                                    <tr>
                                        <td style="text-align: left;">Sub Contractors</td>
                                        
                                        <!-- <td style="text-align: right;">
                                            $<?php //echo number_format($tsortedItem['aggregateProfitPrice'], 2, '.', ','); ?> </td> -->
                                        <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateProfitRate'], 1, '.', ','); ?>%
                                        </td>
                                       
                                        <td><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice())* 100), 2)  ?>%</td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($tsortedItem['aggregateTotalRate'], 2, '.', ','); ?> </td>

                                    </tr>
                                <?php }

                                if ($basetotal > 0) {
                                    $aggOverheadRate = round(($overheadtotal / $basetotal) * 100);
                                    $aggProfitRate = round(($profittotal / $basetotal) * 100);
                                    $aggTaxRate = round(($taxtotal / $basetotal) * 100);
                                } else {
                                    $aggOverheadRate = 0;
                                    $aggProfitRate = 0;
                                    $aggTaxRate = 0;
                                }
                                ?>

                                <tr style="font-weight:bold">
                                    <td style="text-align: left;">Total</td>
                                    
                                    <!-- <td style="text-align: right;">
                                        $<?php //echo number_format($profittotal, 2, '.', ','); ?> </td> -->
                                    <td style="text-align: right;padding-right:15px"><?php echo number_format($aggProfitRate, 2, '.', ','); ?>%
                                    </td>
                                   
                                    <td></td>
                                    <td style="text-align: right;">
                                        $<?php echo number_format($finaltotal, 2, '.', ','); ?> </td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>