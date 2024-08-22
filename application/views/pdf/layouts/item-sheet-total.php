<?php /** @var $proposal \models\Proposals */?>

<?php //$this->load->view('global/header'); ?>
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



<div class="clearfix relative" >


<div class="row" style="margin-bottom:0px">



        <?php

foreach ($sortedItems as $sortedItem): ?>
            <?php $rowTotal = 0;?>
            <div class="col s12" style="page-break-inside: avoid">

            <p style="font-size:20px;"><?php echo $sortedItem['category']->getName(); ?></p>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                <th width="15%" >Type</th>
                    <th width="17%">Item</th>
                    <?php if ($sortedItem['category']->getId() != 1) {?>
                        <th width="7%">Days</th>
                        <th width="7%">#</th>
                        <th width="6%">Hrs/Day</th>
                    <?php } else {?>
                        <th width="12%">Area</th>
                        <th width="7%">Depth</th>
                        <th width="1%"></th>
                    <?php }?>
                    <th width="16%" style="text-align:right;">Quantity</th>
                    <th width="6%"></th>
                    <th width="14%" style="text-align:right;">Total Price</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($sortedItem['items'] as $lineItem): ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */?>
                    <tr>
                        <td style="text-align:left;"><?php
$saved_values = $lineItem->saved_values;
$check_type = $lineItem->item_type_time;
echo $lineItem->getItemType()->getName();

?></td>
                        <td>
                        <?php
if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
    echo $lineItem->getCustomName();
} else {
    echo $lineItem->getItem()->getName();
}
if($lineItem->item_type_trucking ==1){
    echo $lineItem->plant_dump_address;
}
?>
                        </td>
                        <?php
if ($sortedItem['category']->getId() != 1) {
    if ($check_type) {
        // if (count($saved_values) > 0) {
        //     $saved_values = json_decode($saved_values);
        // } else {
        //     $saved_values = [];
        //     echo '<td></td><td></td><td></td>';
        // }

        // for ($i = 0; $i < count($saved_values); $i++) {
        //     //print_r($saved_values[$i]->name);

        //     if ($saved_values[$i]->name == 'truck_capacity') {
        //         echo '<td></td><td></td><td></td>';
        //     } else if ($saved_values[$i]->name == 'time_type_input' || $saved_values[$i]->name == 'labor_time_type_input' || $saved_values[$i]->name == 'equipement_time_type_input') {
        //         echo '<td>' . $saved_values[$i]->value . '</td>';
        //     }else if ($saved_values[$i]->name == 'number_of_person' || $saved_values[$i]->name == 'labor_number_of_person' || $saved_values[$i]->name == 'equipement_number_of_person') {
        //         echo '<td>' . $saved_values[$i]->value . '</td>';
        //     }  else if ($saved_values[$i]->name == 'hour_per_day' || $saved_values[$i]->name == 'labor_hour_per_day' || $saved_values[$i]->name == 'equipement_hour_per_day') {
        //         echo '<td>' . $saved_values[$i]->value . '</td>';
        //     }
        // }
        echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.$lineItem->getHoursPerDay().'</td>';
    } else {
        echo '<td></td><td></td><td></td>';
    }

} else {
    if (count($saved_values) > 0) {
        $saved_values = json_decode($saved_values);
        $measurement = '';
        $unit = '';
        $depth = '';
        for ($i = 0; $i < count($saved_values); $i++) {

            if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                $measurement = $saved_values[$i]->value;
            } else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                if ($saved_values[$i]->value == 'Square Yards') {
                    $unit = 'Sq. Yd';
                } else {
                    $unit = 'Sq. Ft';
                }
            } else if ($saved_values[$i]->name == 'depth') {
                $depth = $saved_values[$i]->value . '"';
            }
        }
        echo '<td>' . $measurement . ' ' . $unit . '</td><td>' . $depth . '</td><td></td>';
    } else {
        $saved_values = [];
        echo '<td></td><td></td><td></td>';
    }
}
?>
                        <td style="text-align:right;"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?>
                        </td>
                        <td></td>
                        <td style="text-align:right;">$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',') ?></td>


                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice();?>
                <?php endforeach;?>

                <tr style="border-top:2px solid #bbbbbb">
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php if ($sortedItem['category']->getId() != 1) {?>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                        <?php } else {?>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                        <?php }?>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Cost</strong></td>
                        <td></td>
                        <td style="text-align:right;"><strong>$<?php echo number_format($sortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong></td>

                    </tr>
                    <tr>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php if ($sortedItem['category']->getId() != 1) {?>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php } else {?>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                        <?php }?>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Overhead</strong></td>
                        <td style="text-align:right"><?php echo number_format($sortedItem['aggregateOverheadRate'], 2, '.', ','); ?>%</td>
                        <td style="text-align:right;">
                            <strong>$<?php echo number_format($sortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                        </td>

                    </tr>
                    <tr>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php if ($sortedItem['category']->getId() != 1) {?>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php } else {?>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                        <?php }?>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Profit</strong></td>
                        <td style="text-align:right"> <?php echo number_format($sortedItem['aggregateProfitRate'], 2, '.', ','); ?>%</td>
                        <td style="text-align:right;">
                            <strong>$<?php echo number_format($sortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                        </td>

                    </tr>
                    <tr>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php if ($sortedItem['category']->getId() != 1) {?>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <td style="background:#FFFFFF"></td>
                        <?php } else {?>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                            <td style="background:#FFFFFF"></td>
                        <?php }?>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Total</strong></td>
                        <td></td>
                        <td style="text-align:right;"><strong>$<?php echo number_format($rowTotal, 2, '.', ','); ?></strong></td>

                    </tr>
                </tbody>
            </table>
            </div>
        <?php endforeach;?>
        <?php
foreach ($subContractorItems as $subContractorItem):
    $rowTotal = 0;?>
				    <div class="col s12" style="page-break-inside: avoid">
				    <p style="font-size:20px;">Sub Contractors</p>

				        <table id="estimateSummaryItems" class="" style="width: 100%;">
				            <thead style="border-bottom: none;">
				            <tr>

				                <th width="25%">Item</th>

				                <th width="15%" style="text-align:right;">Quantity</th>
				                <th width="15%" style="text-align:right;">Total Price</th>
				                <th width="3%"></th>


				            </tr>
				            </thead>
				            <tbody>
				            <?php foreach ($subContractorItem['items'] as $lineItem): ?>

				                <tr>

				                    <td style="text-align:left">
				                    <?php
    echo $lineItem->getSubContractor()->getCompanyName();
    ?>
				                    </td>


				                    <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?> Qty

				                    </td>

				                    <td style="text-align:right">$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',') ?></td>
				                    <td></td>
				                </tr>
				                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice();?>
				            <?php endforeach;?>

                <tr style="border-top:2px solid #bbbbbb">

                    <td style="background:#FFFFFF"></td>

                    <td style="text-align: right;"><strong>Cost</strong></td>
                    <td style="text-align:right"><strong>$<?php echo number_format($subContractorItem['aggregateBaseCost'], 2, '.', ','); ?></strong></td>
                    <td></td>
                </tr>
                <tr>

                    <td style="background:#FFFFFF"></td>
                    <td style="text-align: right;"><strong> Overhead</strong></td>
                    <td style="text-align:right">
                        <strong>$<?php echo number_format($subContractorItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                    </td>
                    <td style="text-align:right"><?php echo $subContractorItem['aggregateOverheadRate']; ?>%</td>
                </tr>
                <tr>

                    <td style="background:#FFFFFF"></td>

                    <td style="text-align: right;"><strong> Profit</strong></td>
                    <td style="text-align:right">
                        <strong>$<?php echo number_format($subContractorItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                    </td>
                    <td style="text-align:right"><?php echo $subContractorItem['aggregateProfitRate']; ?>%</td>
                </tr>
                <tr>

                    <td style="background:#FFFFFF"></td>

                    <td style="text-align: right;"><strong>Total</strong></td>
                    <td style="text-align:right"><strong>$<?php echo number_format($rowTotal, 2, '.', ','); ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        </div>
        <?php endforeach;

//die;
?>

</div>

</div>

</div>

        </div>

    </div>



<?php //$this->load->view('global/footer'); ?>