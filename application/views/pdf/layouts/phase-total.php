<?php /** @var $proposal \models\Proposals */ ?>

<?php //$this->load->view('global/header'); 

?>
<style type="text/css">
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            padding-top: 0px;
            padding-bottom: 10px;
        }

        #header {
            position: fixed;
            top: -30px;
            left: -10%;
            color: #000;
            border-bottom: 1px solid #666;
            padding-bottom: 0px;
            padding-left: 10%;
            width: 120%;
        }

        #header h2 {
            font-size: 17px;
            line-height: 20px;
            margin: 0;
            padding: 2px 0 3px 50px;
        }

        .sales_person {
            position: fixed;
            top: -20px;
            right: -40px;
            width: 200px;
            text-align: center;
        }

        h1.top {
            margin: 0;
            padding: 0 0 3px 0;
            font-size: 25px;
            line-height: 25px;
        }

        .address {
            font-weight: normal;
            padding-left: 0;
            padding-top: 15px;
        }

        #footer {
            text-align: center;
            font-size: 11px;
            color: #999;
            font-style: italic;
            position: fixed;
            bottom: -3mm;
            left: 0;
        }

        h1.title {
            text-align: center;
            border-bottom: 2px solid #000000;
            padding-bottom: 2mm;
        }

        h1.title2 {
            text-align: center;
            padding-bottom: 2mm;
            padding-top: 40mm;
        }

        h1.underlined {
            border-bottom: 2px solid #000000;
            padding-bottom: 2mm;
            margin-bottom: 0;
            font-size: 38px;
        }

        h2 {
            font-size: 17px;
            margin-bottom: 10px;
        }

        thead td {
            padding: 3px;
        }

        td {
            padding: 0;
        }

        tbody td {
            padding: 0;
        }

        tfoot td {
            padding: 5px;
        }

        #front_left {
            width: 45%;
            position: absolute;
            left: 0;
        }

        #front_right {
            width: 35%;
            position: absolute;
            right: 0;
            text-align: right;
        }

        .issuedby {
            text-align: center;
            padding-top: 170mm;
        }

        .odd {
            background: #eee;
        }

        .even {
        }

        .table-container {
            border: 1px solid #000;
        }

        /* Fix for lists */
        li {
            line-height: 15px;
            padding-bottom: 4px;
        }

        .logo {
            position: fixed;
            bottom: 20px;
            right: -30px;
            width: 200px;
            text-align: right;
        }

        .driving {
            font-weight: normal;
            text-align: right;
            margin: 0;
            padding: 0;
        }

        #footer:after {
            content: "Page" counter(page, roman);
        }

        .texts {
            padding-top: 0;
            padding-left: 10px;
        }

        .texts:first-of-type {
            padding-bottom: 20px;
        }

        .item-content, .driving {
            font-size: 14px;
            padding-left: 20px;
            text-align: left;
        }

        .driving {
            padding-left: 0;
        }

        .item-content h2 {
            font-size: 15px;
            margin: 0;
            padding: 0 0 5px 0 !important;
        }

        .item-content ul, .item-content ol {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 5px;
            padding-left: 30px;
        }

        .item-content p {
            margin: 0;
            padding-left: 16px;
            padding-top: 0;
            padding-bottom: 5px;
        }

        .item-content li {
            line-height: 17px;
            padding-bottom: 1px;
        }

        .theLogo {
            width: 133px;
            height: 54px;
        }

        .proposalImage_l {
            width: 650px;
        }

        .proposalImage_p {
            height: 500px;
        }

        span.header-left {
            display: inline-block;
            width: 160px;
            text-align: right;
        }

        h2 span.header-left {
            width: 120px;
        }

        table.header-table {
        }

        table.header-table td {
            font-size: 20px;
        }

        td.imageNotes ol, td.imageNotes ul {
            width: 100%;
            display: block;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 5px;
            padding-left: 30px;
            clear: both;
        }

        td.imageNotes ol li {
            line-height: 20px;
            list-style-position: inside;
        }
        table#estimateSummaryItems { border-collapse: collapse; margin-bottom: 20px; }
table#estimateSummaryItems td { text-align: center }
table#estimateSummaryItems tr:nth-child(odd) {background-color: #fafafa;}
table#estimateSummaryItems tr:nth-child(even){background-color: #efefef;}

table#estimateSummaryItems th {
    background: #ccc;
    padding: 5px;
    text-align: left;
}

table#estimateSummaryItems td {
    padding: 5px;
    text-align: left;
}
.row {
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 20px;
}
.row .col.s6 {
    width: 50%;
    margin-left: auto;
    left: auto;
    right: auto;
}
.row .col.s4 {
    width: 33.3333333333%;
    margin-left: auto;
    left: auto;
    right: auto;
}

.row .col.s8 {
    width: 66.6666666667%;
    margin-left: auto;
    left: auto;
    right: auto;
}
.summaryPhaseHeading {
    padding: 3px 0 3px 10px !important;
    border-radius: 2px;
    font-weight: bold;
    background-color: #25aae1;
    margin-bottom: 8px;
    margin-top: 10px;
    float: left;
    width: 100%;
}
.summaryPhaseHeadingText {
    padding-left: 0 !important;
    padding-right: 0 !important;
    font-size: 18px;
    float: left;
    color: #fff;
}
.summaryPhaseHeadingPriceText {
    padding-left: 0 !important;
    padding-right: 0 !important;
    float: left;
    font-size: 14px;
    color: #fff;
    padding-top: 3px !important;
}
span.priceTitleHeading {
    font-weight: bold;
    /* padding: 2px; */
    border-radius: 2px;
    background-color: #25AAE1;
    color: #fff;
}
.clearfix {
    clear:both;
}
    </style>
<style>
    



</style>
    <div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">
       
    <p style="font-size:20px;">Item Summary: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?> - <?php echo $proposal->getProjectName(); ?></p>
    

        <div class="widthfix clearfix relative" style="height:100px;background:#efefef;border-radius:10px;padding:20px">

  
            <table id="project-details" class="" style="width:50%;float:left; ">

                <tbody >


                        <tr >
                            
                            <th style="text-align:left"><strong>Project Name:</strong></th>
                            <td><?php echo $proposal->getProjectName(); ?></td>
                            
                           
                        </tr>
                    
                        <tr >
                            <?php if ($proposal->getJobNumber()) : ?>
                            <th style="text-align:left"><strong>Job Number:</strong></th>
                            <?php endif; ?>
                            
                            
                            <?php if ($proposal->getJobNumber()) : ?>
                                <td><?php echo $proposal->getJobNumber(); ?></td>
                            <?php endif; ?>

                            
                            
                        </tr>
                        <tr>
                            <th style="text-align:left"><strong>Project Point:</strong></th>
                            <td><?php echo $proposal->getOwner()->getFullName(); ?></td>
                        </tr>
                        <tr>
                            <th style="text-align:left"><strong>Project Address:</strong></th>
                            <td><?php echo $proposal->getProjectAddressString(); ?></td>
                        </tr>
                        </tbody >
                </table>
                <table style="width:50%;float:left; ">

                        <tr >
                            <th style="text-align:left"><strong>Contact Name:</strong></p>
                            <td><?php echo $proposal->getClient()->getFullName(); ?></td>
                           
                        </tr>
                        <tr >
                            <th style="text-align:left"><strong>Account:</strong></p>
                            <td><?php echo $proposal->getClient()->getClientAccount()->getName(); ?></td>
                        </tr>
                        <tr >
                            <th style="text-align:left"><strong>Phone:</strong></p>
                            <td><?php echo $proposal->getClient()->getBusinessPhone() ?: '-'; ?></td>
                        </tr>  
                        <tr >
                            <th style="text-align:left"><strong>Cell:</strong></p>
                            <td><?php  $proposal->getClient()->getCellPhone() ?: '-'; ?></td>
                        </tr>   
                        <tr >
                            <th style="text-align:left"><strong>Email:</strong></p>
                            <td><a href="mailto:<?php echo $proposal->getClient()->getEmail(); ?>"><?php echo $proposal->getClient()->getEmail(); ?></a></td>
                        </tr> 
                        
                    
                </table>
                
            </div>
            <?php 
            
            $j=0;
            foreach ($items as $item) :

                $serviceSortedItems = $item['sortedItems'];

                $service_details = $item['proposalService'];
                $subContractorItem = $item['subContractorItem'];
                $serviceFieldValues = $item['fieldValues'];
                ?>


                <div class="clearfix relative all_service_phase_box  service_div_<?= $service_details->getServiceId(); ?>"
                     id="">

                    <div class="row" style="margin-bottom:0px">

                        <div>
                            <?php
                            if ($item['phase_count'] == '1') {
                                ?>
                                <p style="font-size:18px;font-weight:bold;"><?= $item['proposalService']->getServiceName(); ?></p>
                                <?php
                        
                        if (count($serviceFieldValues)) {
                                $measurementValue = 0;
                                $unitValue = 0;
                            ?>
                            <table style="width:66.66%;float:left; ">
                                        <tbody>

                                        <?php 
                                        $i=1;
                                          foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                         
                                        <?php
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = $serviceFieldValue['values']->getFieldValue();
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = $serviceFieldValue['values']->getFieldValue();
                                            }
                                        ?>
                                            
                                            
                                                        
                                                        
                                                        <?php 
                                                
                                                    if (fmod($i,2)){echo '<tr>';}
                                                    //echo '<td>',$value,'</td>';
                                                    echo  '<td><strong>'.$serviceFieldValue['field']->getFieldName().':</strong></td><td>'.$serviceFieldValue['values']->getFieldValue() .'</td>';                                                 
                                                    
                                                    //if (fmod($i,2)) echo ' </tr>';
                                                    $i++;
                                                    
                                                
                                            ?>

                                        <?php 
                                    } ?>
                                    </tbody>
                                </table>
                                        <table style="width:33.33%">
                                            <tbody>
                                                <tr>
                                                    <td ><span class="priceTitleHeading">Price:</span></td>
                                                    <td>$<?php echo str_replace('$', '', $service_details->getPrice()); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="priceTitleHeading">Unit Price:</span></td>
                                                    <td><?php echo (isset($measurementValue)) ? $repo->pricePerUnit($measurementValue, $service_details->getPrice(), $unitValue) : '-' ?></td>
                                                </tr>
                                                <?php if($repo->serviceHasItemOfType($service_details, \models\EstimationType::ASPHALT)) {
                                                        $tons = $repo->getServiceMaxTonsValue($service_details);
                                                        $pricePerTon = $repo->pricePerTon($service_details->getPrice(), $tons);
                                                ?>
                                                    <tr>
                                                        <td><span class="priceTitleHeading">Price Per Ton:</span></td>
                                                        <td><?php echo $pricePerTon; ?></td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>

                                        </table>
                                                
                            
                            
                            
                                                <?php }
                             } ?>
                            <div class="col s12 summaryPhaseHeading">
                                        <div class="col s4 summaryPhaseHeadingText">
                                            <?php echo $item['phase_count'] . '. ' . $item['phase']['name']; ?>
                                        </div>
                                        <div class="col s2 summaryPhaseHeadingPriceText" style="padding-right:20px!important">
                                            <strong>Price:</strong>  $<?php echo str_replace('$', '',number_format($item['phaseTotal'],2)); ?>
                                        </div>
                                        <div class="col s4 summaryPhaseHeadingPriceText">
                                            <?php if ($item['phaseTotal'] != '0.00') { ?>
                                            <strong>Unit Price:</strong> <?php echo (isset($measurementValue)) ? $repo->pricePerUnit($measurementValue, $item['phaseTotal'], $unitValue) : '-' ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col s2 summaryPhaseHeadingPriceText">
                                            <?php if($repo->phaseHasItemOfType($item['phase']['id'], \models\EstimationType::ASPHALT)) {
                                                $tons = $repo->getPhaseMaxTonsValue($item['phase']['id']);
                                                $pricePerTon = $repo->pricePerTon($item['phaseTotal'], $tons);
                                                ?>
                                                <strong><?php echo $pricePerTon; ?> / Ton</strong>
                                            <?php } ?>
                                        </div>
                                    </div>
                            
                               
                            <?php

                            if (count($serviceSortedItems) > 0 || count($item['subContractorItem']) > 0) {
                                ?>

                                <table id="estimateSummaryItems"
                                       class="phase_table phase_table_<?= $item['phase']['id']; ?>"
                                       style="width: 100%;text-align: right;">
                                    <thead>
                                    <tr>
                                        <th width="16%" style="text-align: left;">Category</th>
                                        <th width="10%">Cost</th>
                                        <th width="10%" style="text-align: right;">Overhead</th>
                                        <th width="8%" style="text-align: center;">OH %</th>
                                        <th width="10%" style="text-align: right;">Profit</th>
                                        <th width="8%" style="text-align: center;">PM %</th>
                                        <th width="10%" style="text-align: right;">Tax</th>
                                        <th width="8%" style="text-align: center;">Tax %</th>
                                        <th width="10%" style="text-align: center;">Total %</th>
                                        <th width="10%" style="text-align: right;">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $finaltotal = 0;
                                    $overheadtotal = 0;
                                    $profittotal = 0;
                                    $taxtotal = 0;
                                    $basetotal = 0;

                                    foreach ($serviceSortedItems as $tsortedItem) { ?>
                                        <?php $rowTotal = 0;
                                        $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                        $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                        $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                        $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                        $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                        ?>
                                        <tr>
                                            <td style="text-align: left;"><?php echo $tsortedItem['category']->getName(); ?></td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateBaseCost'], 2); ?></td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateProfitPrice'], 2, '.', ','); ?> </td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateTaxPrice'], 2, '.', ','); ?> </td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateTaxRate'], 2, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;"><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice()) * 100), 2) ?>
                                                %
                                            </td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateTotalRate'], 2, '.', ','); ?> </td>

                                        </tr>
                                    <?php }
                                    foreach ($subContractorItem as $tsortedItem) { ?>
                                        <?php $rowTotal = 0;
                                        $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                        $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                        $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                        $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                        $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                        ?>
                                        <tr>
                                            <td style="text-align: left;">Sub Contractors</td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateBaseCost'], 2); ?></td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateOverheadRate'], 1, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateProfitPrice'], 2, '.', ','); ?> </td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateProfitRate'], 1, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;">
                                                $<?php echo number_format($tsortedItem['aggregateTaxPrice'], 2, '.', ','); ?> </td>
                                            <td style="text-align: right;padding-right:15px"><?php echo number_format($tsortedItem['aggregateTaxRate'], 1, '.', ','); ?>
                                                %
                                            </td>
                                            <td style="text-align: right;"><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice()) * 100), 2) ?>
                                                %
                                            </td>
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
                                        <td style="text-align: right;">
                                            $<?php echo number_format($basetotal, 2); ?></td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($overheadtotal, 2, '.', ','); ?></td>
                                        <td style="text-align: right;padding-right:15px"><?php echo number_format($aggOverheadRate, 2, '.', ','); ?>
                                            %
                                        </td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($profittotal, 2, '.', ','); ?> </td>
                                        <td style="text-align: right;padding-right:15px"><?php echo number_format($aggProfitRate, 2, '.', ','); ?>
                                            %
                                        </td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($taxtotal, 2, '.', ','); ?> </td>
                                        <td style="text-align: right;padding-right:15px"><?php echo number_format($aggTaxRate, 2, '.', ','); ?>
                                            %
                                        </td>
                                        <td></td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($finaltotal, 2, '.', ','); ?> </td>

                                    </tr>
                                    </tbody>
                                </table>
                            <?php } else {
                                echo '<p  class="clearfix" style="margin-bottom: 15px;" ><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                            } ?>


                        </div>

                    </div>

                </div>

            <?php endforeach; ?>


</div>

</div>
</div>

</div>

        </div>

    </div>



<?php //$this->load->view('global/footer'); ?>