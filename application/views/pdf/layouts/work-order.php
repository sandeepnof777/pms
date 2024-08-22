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
    /* margin-left: auto; */
    float:left;
    left: auto;
    right: auto;
}
.row .col.s4 {
    width: 33.3333333333%;
    /* margin-left: auto; */
    left: auto;
    right: auto;
    float:left;
}
.row .col.s8 {
    width: 66.6666666667%;
    /* margin-left: auto; */
    float:left;
    left: auto;
    right: auto;
}
.row .col.s12 {
    width: 100%;
    /* margin-left: auto; */
    float:left;
    left: auto;
    right: auto;
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
                        <?php if ($proposal->getJobNumber()) : ?>
                        <tr >
                            
                            <th style="text-align:left"><strong>Job Number:</strong></th>
                            <td><?php echo $proposal->getJobNumber(); ?></td>
                           

                            
                            
                        </tr>
                        <?php endif; ?>
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
            foreach ($services as $service) :
                // print_r($item['phase_count']);
                $serviceSortedItems = $service['sortedItems'];
                $service_details = $service['service_details'];
                $serviceFieldValues = $service['fieldValues'];
                //if (count($serviceSortedItems) > 0) {?>

                    <div class="row" style="margin-bottom:0px">
                    <p style="font-size:18px;font-weight:bold;"><?= $service_details->getServiceName(); ?> <a class="expandSpecDetail"></a></p>
                    <?php
                                if ($serviceFieldValues) {
                                        $measurementValue = 0;
                                        $unitValue = 0;
                                    ?>
                                    <table style="width:100%;float:left; ">
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
                                        
                                           
                                    <?php
                                }
                                ?>

                    <div class="clearfix relative">

                        

                            <div class="col s12">

                                <?php

                                if ($serviceSortedItems) {
                                    foreach ($serviceSortedItems as $serviceSortedItem) : ?>
                                        <?php $rowTotal = 0; ?>
                                        <p style="font-size:15px;font-weight:bold;"><?php echo $serviceSortedItem['category']->getName(); ?></p>
                                        <table id="estimateSummaryItems" class="" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th width="20%">Type</th>
                                                <th width="12%">Item</th>
                                                <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                    <th width="9%">Days</th>
                                                    <th width="9%">#</th>
                                                    <th width="7%">Hrs/Day</th>
                                                <?php } else { ?>
                                                    <th width="15%">Area</th>
                                                    <th width="10%">Depth</th>
                                                    <th width="1%"></th>
                                                <?php } ?>
                                                <th width="21%" style="text-align:right;">Quantity</th>
                                                

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($serviceSortedItem['items'] as $breaklineItem) : ?>
                                                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                                <tr>
                                                    <td style="text-align:left;"><?php
                                                        //print_r($breaklineItem);die;
                                                        $saved_values = $breaklineItem->saved_values;
                                                        $check_type = $breaklineItem->item_type_time;
                                                        echo $breaklineItem->getItemType()->getName();

                                                        ?></td>
                                                    <td style="text-align:left;">
                                                        <?php
                                                        if ($serviceSortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                                            echo $breaklineItem->getCustomName();
                                                        } else {
                                                            echo $breaklineItem->getItem()->getName();
                                                        }
                                                        if ($breaklineItem->item_type_trucking == 1) {
                                                            echo '<br/>' . $breaklineItem->plant_dump_address;
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    if ($serviceSortedItem['category']->getId() != 1) {
                                                        if ($check_type) {
                                                        
                                                            echo '<td>' . $breaklineItem->getDay() . '</td><td>' . $breaklineItem->getNumPeople() . '</td><td>' . $breaklineItem->getHoursPerDay() . '</td>';
                                                        } else {
                                                            echo '<td></td><td></td><td></td>';
                                                        }

                                                    } else {
                                                        if ($saved_values) {
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
                                                                    $depth = $saved_values[$i]->value . ' Inch';
                                                                }
                                                            }
                                                            echo '<td>' . $measurement . ' ' . $unit . '</td><td>' . $depth . '</td><td></td>';
                                                        } else {
                                                            $saved_values = [];
                                                            echo '<td></td><td></td><td></td>';
                                                        }
                                                    }
                                                    ?>
                                                    <td style="text-align:right;"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>
                                                        <?php echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                    </td>
                                                    

                                                </tr>
                                                
                                            <?php endforeach; ?>

                                            
                                            </tbody>
                                        </table>

                                    <?php endforeach;
                                }
                                if ($service['subContractorItem']) {
                                    $breaksortedItems = $service['subContractorItem'];
                                    foreach ($breaksortedItems as $breaksortedItem) : ?>
                                        <?php $rowTotal = 0; ?>
                                        <p style="font-size:15px;font-weight:bold;">Sub Contractors</p>
                                        <table id="estimateSummaryItems" class="" style="width: 100%;">
                                            <thead>
                                            <tr>

                                                <th width="25%">Sub Contractor Name</th>

                                                <th width="15%" style="text-align:right;">Quantity</th>
                                                <th width="15%" style="text-align:right;">Total Price</th>
                                                <th width="3%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($breaksortedItem['items'] as $breaklineItem) : ?>
                                                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                                <tr>

                                                    <td style="text-align:left;">
                                                        <?php
                                                        // if ($breaksortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                                        //echo $breaklineItem->getSubContractor()->getCompanyName();
                                                        if ($breaklineItem->getIsCustomSub() == 1) {
                                                            echo $breaklineItem->getCustomName();
                                                        } else {
                                                            echo $breaklineItem->getSubContractor()->getCompanyName();
                                                        }
                                                        // } else {
                                                        //     echo $breaklineItem->getItem()->getName();
                                                        // }
                                                        ?>
                                                    </td>

                                                    <td style="text-align:right;"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>
                                                        Qty

                                                    </td>
                                                    <td style="text-align:right;">
                                                        $<?php echo number_format($breaklineItem->getTotalPrice(), 2, '.', ',') ?></td>
                                                    <td></td>
                                                </tr>
                                                <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                            <?php endforeach; ?>

                                            
                                            </tbody>
                                        </table>

                                    <?php endforeach;

                                } if(!$service['subContractorItem'] && !$serviceSortedItems){
                                    echo '<p  style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                } 
                                ?>
                            </div>

                        </div>

                    </div>
                    <div style="clear: both;"></div>
                    <hr/>
                    <?php

                //}
            endforeach; ?>

    

</div>

</div>
</div>

</div>

        </div>

    </div>



<?php //die;?>