<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header'); ?>

<div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">

    <a href="<?php echo site_url('proposals/estimate/' . $proposal->getProposalId()); ?>" class="btn right">
        <i class="fa fa-chevron-left"></i> Back
    </a>
    <!-- <a href="<?php echo site_url('pdf/live2/download/item-sheet-total/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right total_item">
        Download
    </a>
    <a href="<?php echo site_url('pdf/live2/download/item-sheet/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right breakdown_total">
        Download
    </a>
    <a href="<?php echo site_url('pdf/live2/download/phase-total/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right phase_total">
        Download
    </a>
    <a href="<?php echo site_url('pdf/live2/download/service-total/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right service_total">
        Download
    </a>
    <a href="<?php echo site_url('pdf/live2/download/service-breakdown/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right service_breakdown">
        Download
    </a> -->
    <a href="<?php echo site_url('pdf/live2/download/work-order/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right work_order">
        Download
    </a>
    
    <h4 style="float:left">Item Summary: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?>
        - <?php echo $proposal->getProjectName(); ?> </h4>

    <div class="widthfix clearfix relative">

        <hr/>
        <div id="project-details" class="row">

            <div class="col s6">

                <div class="col s4">

                    <p><strong>Project Name:</strong></p>

                    <?php if ($proposal->getJobNumber()) : ?>
                        <p><strong>Job Number:</strong></p>
                    <?php endif; ?>

                    <p><strong>Project Point:</strong></p>

                    <p><strong>Project Address:</strong></p>
                </div>

                <div class="col s8">

                    <p><?php echo $proposal->getProjectName(); ?></p>

                    <?php if ($proposal->getJobNumber()) : ?>
                        <p><?php echo $proposal->getJobNumber(); ?></p>
                    <?php endif; ?>

                    <p><?php echo $proposal->getOwner()->getFullName(); ?></p>
                    <p><?php echo $proposal->getProjectAddressString(); ?></p>
                </div>

            </div>
            <div class="col s6">

                <div class="col s4">
                    <p><strong>Contact Name:</strong></p>
                    <p><strong>Account:</strong></p>
                    <p><strong>Phone:</strong></p>
                    <p><strong>Cell:</strong></p>
                    <p><strong>Email:</strong></p>
                </div>

                <div class="col s8">
                    <p><?php echo $proposal->getClient()->getFullName(); ?></p>
                    <p><?php echo $proposal->getClient()->getClientAccount()->getName(); ?></p>
                    <p><?php echo $proposal->getClient()->getBusinessPhone() ?: '-'; ?></p>
                    <p><?php echo $proposal->getClient()->getCellPhone() ?: '-'; ?></p>
                    <p>
                        <a href="mailto:<?php echo $proposal->getClient()->getEmail(); ?>"><?php echo $proposal->getClient()->getEmail(); ?></a>
                    </p>
                </div>

            </div>
            <hr/>
        </div>


        <?php if (count($sortedItems) > 0){ ?>


        <div class="clearfix relative">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-2">All Items</a></li>
                    <li><a href="#tabs-3">Totals</a></li>
                    <li><a href="#tabs-5">Service Totals</a></li>
                    <li><a href="#tabs-6">Phase Totals</a></li>
                    <li><a href="#tabs-4">Service Breakdown</a></li>
                    <li><a href="#tabs-1">Phase Breakdown</a></li>
                    <li><a href="#tabs-7">Work Order</a></li>

                    
                </ul>
                <div id="tabs-1" class="row">
                    <div style="position: absolute;right: 10px;top: 4px;">
                        <select class="dont-uniform select_service_phase" style=" display:block;height:15px!important;border: 1px solid #25aae1; width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($items as $item) :

                                if ($item['phase_count'] == '1') {
                                    echo '<option data-val="service" value="' . $item['proposalService']->getServiceId() . '">' . $item['proposalService']->getServiceName() . '</option>';
                                }
                                echo '<option data-val="phase" data-service-id="' . $item['proposalService']->getServiceId() . '" value="' . $item['phase']['id'] . '">--' . $item['phase']['name'] . '</option>';

                            endforeach;
                            ?>
                        </select>
                    </div>
                    <?php

                    $count_phase = 1;
                    foreach ($items as $item) :
                        // print_r($item['phase_count']);
                        $breaksortedItems = $item['sortedItems'];
                        $phaseTruckingItems = $item['phaseTruckingItems'];
                        $serviceFieldValues = $item['fieldValues'];
                        $service_details  = $item['proposalService'];
                        $phaseTemplateItems  = $item['phaseTemplateItems'];
                       
                    ?>
                            <div class="clearfix relative all_service_phase_box  service_div_<?= $item['proposalService']->getServiceId(); ?>">

                                                <div class="row" style="margin-bottom:0px">
                    <?php

                            if ($item['phase_count'] == '1') {
                                ?>
                                <a class="btn blue-button right go_to_estimate_service" data-val="<?= $item['proposalService']->getServiceId(); ?>" href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                                    <i class="fa fa-fw fa-calculator"></i> Estimator
                                </a>
                                <p style="font-size:18px;font-weight:bold;"><?= $item['proposalService']->getServiceName(); ?></p>
                            
                                <?php
                                if (count($serviceFieldValues)) {
                                    ?>
                                    <div class="row" style="">
                                        <div class="col s8" style="padding-left: 0;">

                                        <?php 
                                        $measurementValue = 0;
                                        $unitValue = 0;
                                        foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                        <?php 

                                            
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }
                                        ?>
                                            <div class="col s6" style="padding-left: 0;">
                                                <div class="col s8 right-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <strong><?= $serviceFieldValue['field']->getFieldName() ?>:</strong>
                                                    </p>

                                                </div>
                                                <div class="col s4 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <?= ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0; ?>
                                                    </p>

                                                </div>
                                            </div>

                                        <?php } ?>
                                        </div>
                                        <div class="col s4" style="padding: 0;">
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail">$<?php echo str_replace('$', '', $service_details->getPrice()); ?></p>
                                                </div>
                                            </div>
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Unit Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail"><?php echo ($measurementValue) ? $repo->pricePerUnit($measurementValue, $service_details->getPrice(), $unitValue) : '-' ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                                } ?>
                                <div class="col s12 summaryPhaseHeading">
                                    <div class="col s4 summaryPhaseHeadingText">
                                        <?php echo $item['phase_count'] . '. ' . $item['phase']['name']; ?>
                                    </div>
                                    <div class="col s2 summaryPhaseHeadingPriceText">
                                        <strong>Price:</strong> $<?php echo str_replace('$', '',number_format($item['phaseTotal'],2)); ?>
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
                            

                                    <div class="col s12" style="padding: 0px;">

                                        <?php

                                        if (count($breaksortedItems) > 0) {
                                            foreach ($breaksortedItems as $breaksortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;"><?php echo $breaksortedItem['category']->getName(); ?></p>
                                                <table id="estimateSummaryItems" class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        <?php if ($breaksortedItem['category']->getId() != 1) { ?>
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        <?php } else { ?>
                                                            <th width="12%">Area</th>
                                                            <th width="7%">Depth</th>
                                                            <th width="1%"></th>
                                                        <?php } ?>
                                                        <th width="16%" style="text-align:right;">Quantity</th>
                                                        <th width="6%"></th>
                                                        <th width="14%" style="text-align:right;">Total Price</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($breaksortedItem['items'] as $breaklineItem) : ?>
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
                                                                if ($breaksortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
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
                                                            if ($breaksortedItem['category']->getId() != 1) {
                                                                if ($check_type) {
                                                                    // if ($saved_values) {
                                                                    //     $saved_values = json_decode($saved_values);
                                                                    // } else {
                                                                    //     $saved_values = [];
                                                                    //     echo '<td></td><td></td><td></td>';
                                                                    // }

                                                                    // for ($i = 0; $i < count($saved_values); $i++) {
                                                                    //     //print_r($saved_values[$i]->name);

                                                                    //     if ($saved_values[$i]->name == 'truck_capacity') {
                                                                    //         echo '<td></td><td></td><td></td>';
                                                                    //     }else if ($saved_values[$i]->name == 'time_type_input' || $saved_values[$i]->name == 'labor_time_type_input' || $saved_values[$i]->name == 'equipement_time_type_input') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     } else if ($saved_values[$i]->name == 'number_of_person' || $saved_values[$i]->name == 'labor_number_of_person' || $saved_values[$i]->name == 'equipement_number_of_person') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     }  else if ($saved_values[$i]->name == 'hour_per_day' || $saved_values[$i]->name == 'labor_hour_per_day' || $saved_values[$i]->name == 'equipement_hour_per_day') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     }
                                                                    // }
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
                                                                            if (stripos($saved_values[$i]->value, 'yard')) {
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
                                                            <td></td>
                                                            <td style="text-align:right;">
                                                                <?php 
                                                                echo ($breaklineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($breaklineItem->getTotalPrice(), 2, '.', ',')
                                                                
                                                                ?></td>

                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>

                                                    <tr style="border-top:2px solid #bbbbbb">
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($breaksortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $breaksortedItem['category']->getName(); ?>
                                                                Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($breaksortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $breaksortedItem['category']->getName(); ?>
                                                                Overhead</strong></td>

                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($breaksortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr  <?= ($breaksortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($breaksortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $breaksortedItem['category']->getName(); ?>
                                                                Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Tax</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateTaxRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($breaksortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $breaksortedItem['category']->getName(); ?>
                                                                Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php endforeach;
                                        }

                                        if (count($phaseTruckingItems) > 0) {
                                            $breaksortedItem = $phaseTruckingItems;
                                            //foreach ($phaseTruckingItems as $breaksortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Trucking</p>
                                                <table id="estimateSummaryItems" class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        
                                                        <th width="16%" style="text-align:right;">Quantity</th>
                                                        <th width="6%"></th>
                                                        <th width="14%" style="text-align:right;">Total Price</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($breaksortedItem['items'] as $breaklineItem) : ?>
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
                                                              
                                                                    echo $breaklineItem->getItem()->getName();
                                                                
                                                                if ($breaklineItem->item_type_trucking == 1) {
                                                                    echo '<br/>' . $breaklineItem->plant_dump_address;
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php
                                                            
                                                                    echo '<td>' . $breaklineItem->getDay() . '</td><td>' . $breaklineItem->getNumPeople() . '</td><td>' . $breaklineItem->getHoursPerDay() . '</td>';
                                                               
                                                            
                                                            ?>
                                                            <td style="text-align:right;"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>
                                                                <?php echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                            </td>
                                                            <td></td>
                                                            <td style="text-align:right;">
                                                                <?php 
                                                                echo ($breaklineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($breaklineItem->getTotalPrice(), 2, '.', ',')
                                                                
                                                                ?></td>

                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>

                                                    <tr style="border-top:2px solid #bbbbbb">
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Overhead</strong></td>

                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($breaksortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr  <?= ($breaksortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Tax</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateTaxRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php 
                                        }

                        $n=0;
                    foreach ($phaseTemplateItems as $key=>$templateSortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    
            
                        <div class="phaseItemSection assembly_section" id="assembly_section_<?=$n;?>" style="page-break-inside:avoid">
                       
                        <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Assembly <?php echo ($templateSortedItem['is_empty_template']==0)? ' - '.$templateSortedItem['template_name'] : '';?></p>
                        <table id="estimateSummaryItems" class="assembly_section_table" style="width: 100%;">
                            <thead>
                            <tr>
                            <?php if($templateSortedItem['is_empty_template']==1){
                                ?>
                                
                                <th width="40%">Name</th>
                                <?php }else{?>
                                
                                <th width="10%" >Category</th>
                                <th width="20%" >Type</th>
                                <th width="20%">Item</th>
                                <?php }?>
                                        <th width="5%">Days</th>
                                        <th width="5%">#</th>
                                        
                                        <th width="5%">Hrs/Day</th>
                                    
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                    <th width="7%" >Total</th>
                                <!-- <th>Total Price</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                                
                                <tr>
                                <!--Check If Template Is Empty-->
                                <?php if($templateSortedItem['is_empty_template']==1){?>

                                    <td style="text-align: left;"><?=$templateSortedItem['template_name'];?></td>
                                
                                <?php }else{?>

                                    <td style="text-align: left;" class="phase_section_item_type"><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItemType()->getName(); ?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItem()->getName();?></td>
                                <?php } ?>
                                
                                <?php 
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                ?>
                                    <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                            <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                        </td>
                                        
                                        <td style="text-align:right"><?php echo ($lineItem->getFixedTemplate()==2) ? '-': '$'.number_format($lineItem->getTotalPrice(), 2, '.', ','); ?></td>
                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            <tr style="border-top:2px solid #bbbbbb">
                                        <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Overhead</strong></td>
                                                        
                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($templateSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($templateSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php 
                                                            if($templateSortedItem['is_fixed_template']==1){
                                                                echo number_format($templateSortedItem['fixed_template_total'], 2, '.', ',');
                                                            }else{
                                                                echo number_format($rowTotal, 2, '.', ',');
                                                             } ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    
                            </tbody>
                            
                        </table>
                        <div class="divider"></div>
                        </div>
            
                   
                    <?php 
                    $n++;
                    endforeach;



                    //Ent Fix Template Division


                                        if (count($item['subContractorItem']) > 0) {
                                            $breaksortedItems = $item['subContractorItem'];
                                            foreach ($breaksortedItems as $breaksortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Sub Contractors</p>
                                                <table id="estimateSummaryItems" class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="width: 100%;">
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

                                                    <tr style="border-top:2px solid #bbbbbb">

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Cost</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Overhead</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"><?php echo number_format($breaksortedItem['aggregateOverheadRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Profit</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateProfitRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Tax</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateTaxRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Total</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php endforeach;

                                        }
                                        if(!count($item['subContractorItem']) > 0 && !count($breaksortedItems) > 0){
                                            echo '<p class="phase_p phase_p_' . $item['phase']['id'] . '" style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                        } 
                                        ?>
                                    </div>

                                </div>

                            </div>
                            <?php

                        
                    endforeach; ?>
                </div>
                <div id="tabs-2">
                    <div class="row" style="margin-bottom:0px">
                        <a class="btn blue-button right" style="position: absolute; right: 20px; top: 4px;"
                           href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                            <i class="fa fa-fw fa-calculator"></i> Estimator
                        </a>

                        <div class="col s12">

                            <?php


                            foreach ($sortedItems as $newsortedItem) : ?>
                                <?php $rowTotal = 0; ?>
                                <p style="font-size:15px;font-weight:bold;"><?php echo $newsortedItem['category']->getName(); ?></p>
                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                    <thead style="border-bottom: none;">
                                    <tr>
                                        <th width="15%">Type</th>
                                        <th width="17%">Item</th>
                                        <?php if ($newsortedItem['category']->getId() != 1) { ?>
                                            <th width="7%">Days</th>
                                            <th width="7%">#</th>
                                            <th width="6%">Hrs/Day</th>
                                        <?php } else { ?>
                                            <th width="12%">Area</th>
                                            <th width="7%">Depth</th>
                                            <th width="1%"></th>
                                        <?php } ?>
                                        <th width="16%" style="text-align:right;">Quantity</th>
                                        <th width="6%"></th>
                                        <th width="14%" style="text-align:right;">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($newsortedItem['items'] as $lineItem) : ?>

                                        <tr>
                                            <td style="text-align:left"><?php
                                                $saved_values = $lineItem->saved_values;
                                                $check_type = $lineItem->item_type_time;
                                                echo $lineItem->getItemType()->getName(); ?></td>
                                            <td style="text-align:left">
                                                <?php
                                                if ($newsortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                                    echo $lineItem->getCustomName();
                                                } else {
                                                    echo $lineItem->getItem()->getName();
                                                }
                                                if ($lineItem->item_type_trucking == 1) {
                                                    echo '<br/>' . $lineItem->plant_dump_address;
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            if ($newsortedItem['category']->getId() != 1) {
                                                if ($check_type) {

                                                    echo '<td>' . $lineItem->getDay() . '</td><td>' . $lineItem->getNumPeople() . '</td><td>' . $lineItem->getHoursPerDay() . '</td>';

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
                                                            if (stripos($saved_values[$i]->value, 'yard')) {
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

                                                //echo '<td></td><td></td><td></td>';
                                            }
                                            ?>

                                            <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                            </td>
                                            <td></td>
                                            <td style="text-align:right">
                                                <?php 
                                                
                                                echo ($lineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($lineItem->getTotalPrice(), 2, '.', ','); ?></td>

                                        </tr>
                                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                                    <?php endforeach; ?>

                                    <tr style="border-top:2px solid #bbbbbb">
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        <?php if ($newsortedItem['category']->getId() != 1) { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } else { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                        <td style="text-align: right;">
                                            <strong><?php echo $newsortedItem['category']->getName(); ?> Cost</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                        </td>

                                    </tr>
                                    <tr <?= ($newsortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        <?php if ($newsortedItem['category']->getId() != 1) { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } else { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                        <td style="text-align: right;">
                                            <strong><?php echo $newsortedItem['category']->getName(); ?>
                                                Overhead</strong></td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateOverheadRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr <?= ($newsortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        <?php if ($newsortedItem['category']->getId() != 1) { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } else { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                        <td style="text-align: right;">
                                            <strong><?php echo $newsortedItem['category']->getName(); ?> Profit</strong>
                                        </td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateProfitRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        
                                        <td style="text-align: right;">
                                            <strong> Tax</strong>
                                        </td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateTaxRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        <?php if ($newsortedItem['category']->getId() != 1) { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } else { ?>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                        <td style="text-align: right;">
                                            <strong><?php echo $newsortedItem['category']->getName(); ?> Total</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong></td>

                                    </tr>
                                    </tbody>
                                </table>

                            <?php endforeach; ?>

                            <?php
        ///////Trucking Items

                            if(count($truckingItems)>0) { ?>
                                <?php $rowTotal = 0; 
                                $newsortedItem =$truckingItems;?>
                                <p style="font-size:15px;font-weight:bold;">Trucking</p>
                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                    <thead style="border-bottom: none;">
                                    <tr>
                                        <th width="15%">Type</th>
                                        <th width="17%">Item</th>
                                        
                                            <th width="7%">Days</th>
                                            <th width="7%">#</th>
                                            <th width="6%">Hrs/Day</th>
                                       
                                        <th width="16%" style="text-align:right;">Quantity</th>
                                        <th width="6%"></th>
                                        <th width="14%" style="text-align:right;">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($newsortedItem['items'] as $lineItem) : ?>

                                        <tr>
                                            <td style="text-align:left"><?php
                                                $saved_values = $lineItem->saved_values;
                                                $check_type = $lineItem->item_type_time;
                                                echo $lineItem->getItemType()->getName(); ?></td>
                                            <td style="text-align:left">
                                                <?php
                                                
                                                    echo $lineItem->getItem()->getName();
                                                
                                                if ($lineItem->item_type_trucking == 1) {
                                                    echo '<br/>' . $lineItem->plant_dump_address;
                                                }
                                                ?>
                                            </td>
                                            <?php
                                               

                                                    echo '<td>' . $lineItem->getDay() . '</td><td>' . $lineItem->getNumPeople() . '</td><td>' . $lineItem->getHoursPerDay() . '</td>';

                                                
                                            
                                            ?>

                                            <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                            </td>
                                            <td></td>
                                            <td style="text-align:right">
                                                <?php 
                                                
                                                echo ($lineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($lineItem->getTotalPrice(), 2, '.', ','); ?></td>

                                        </tr>
                                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                                    <?php endforeach; ?>

                                    <tr style="border-top:2px solid #bbbbbb">
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                       
                                        <td style="text-align: right;">
                                            <strong>Trucking Cost</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                        </td>

                                    </tr>
                                    <tr <?= ($newsortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                       
                                        <td style="text-align: right;">
                                            <strong>Trucking
                                                Overhead</strong></td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateOverheadRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr <?= ($newsortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                       
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        
                                        <td style="text-align: right;">
                                            <strong>Trucking Profit</strong>
                                        </td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateProfitRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                        
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        
                                        <td style="text-align: right;">
                                            <strong> Tax</strong>
                                        </td>

                                        <td style="text-align:right"><?php echo $newsortedItem['aggregateTaxRate']; ?>
                                            %
                                        </td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="background:#FFFFFF"></td>
                                       
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                            <td style="background:#FFFFFF"></td>
                                        
                                        <td style="text-align: right;">
                                            <strong>Trucking Total</strong>
                                        </td>
                                        <td></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($newsortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong></td>

                                    </tr>
                                    </tbody>
                                </table>

                            <?php } 
//Start All Item Template Division



$n=0;
                foreach ($templateItems as $key=>$templateSortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    
            
                        <div class="phaseItemSection assembly_section" id="assembly_section_<?=$n;?>" style="page-break-inside:avoid">
                       
                        <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Assembly <?php echo ($templateSortedItem['is_empty_template']==0)? ' - '.$templateSortedItem['template_name'] : '';?></p>
                        <table id="estimateSummaryItems" class="assembly_section_table" style="width: 100%;">
                            <thead>
                            <tr>
                            <?php if($templateSortedItem['is_empty_template']==1){
                                ?>
                                
                                <th width="40%">Name</th>
                                <?php }else{?>
                                
                                <th width="10%" >Category</th>
                                <th width="20%" >Type</th>
                                <th width="20%">Item</th>
                                <?php }?>
                                        <th width="5%">Days</th>
                                        <th width="5%">#</th>
                                        
                                        <th width="5%">Hrs/Day</th>
                                    
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                    <th width="7%" >Total</th>
                                <!-- <th>Total Price</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                                
                                <tr>
                                <!--Check If Template Is Empty-->
                                <?php if($templateSortedItem['is_empty_template']==1){?>

                                    <td style="text-align: left;"><?=$templateSortedItem['template_name'];?></td>
                                
                                <?php }else{?>

                                    <td style="text-align: left;" class="phase_section_item_type"><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItemType()->getName(); ?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItem()->getName();?></td>
                                <?php } ?>
                                
                                <?php 
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                ?>
                                    <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                            <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                        </td>
                                        
                                    <td style="text-align:right"><?php echo ($lineItem->getFixedTemplate()==2) ? '-': '$'.number_format($lineItem->getTotalPrice(), 2, '.', ','); ?></td>
                                    
                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            <tr style="border-top:2px solid #bbbbbb">
                                        <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Overhead</strong></td>
                                                        
                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($templateSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($templateSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php 
                                                            if($templateSortedItem['is_fixed_template']==1){
                                                                echo number_format($templateSortedItem['fixed_template_total'], 2, '.', ',');
                                                            }else{
                                                                echo number_format($rowTotal, 2, '.', ',');
                                                             } ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    
                            </tbody>
                            
                        </table>
                        <div class="divider"></div>
                        </div>
            
                   
                    <?php 
                    $n++;
                    endforeach;




//End All Item Template Division
                            foreach ($subContractorItems as $subContractorItem) :
                                $rowTotal = 0; ?>
                                <p style="font-size:15px;font-weight:bold;">Sub Contractors</p>
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
                                    <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                                        <tr>
                                            <td style="text-align:left">
                                                <?php
                                                if ($lineItem->getIsCustomSub() == 1) {
                                                    echo $lineItem->getCustomName();
                                                } else {
                                                    echo $lineItem->getSubContractor()->getCompanyName();
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                                Qty
                                            </td>
                                            <td style="text-align:right">
                                                $<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',') ?></td>
                                            <td></td>
                                        </tr>
                                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                                    <?php endforeach; ?>

                                    <tr style="border-top:2px solid #bbbbbb">
                                        <td style="background:#FFFFFF"></td>
                                        <td style="text-align: right;"><strong>Cost</strong></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($subContractorItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr <?= ($subContractorItem['aggregateOverheadPrice']<0 )?'style="color:red"':'';?>>

                                        <td style="background:#FFFFFF"></td>
                                        <td style="text-align: right;"><strong> Overhead</strong></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($subContractorItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>
                                        </td>
                                        <td style="text-align:right"><?php echo $subContractorItem['aggregateOverheadRate']; ?>
                                            %
                                        </td>
                                    </tr>
                                    <tr <?= ($subContractorItem['aggregateProfitPrice']<0 )?'style="color:red"':'';?>>

                                        <td style="background:#FFFFFF"></td>
                                        <td style="text-align: right;"><strong> Profit</strong></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($subContractorItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>
                                        </td>
                                        <td style="text-align:right"><?php echo $subContractorItem['aggregateProfitRate']; ?>
                                            %
                                        </td>
                                    </tr>
                                    <tr>

                                        <td style="background:#FFFFFF"></td>
                                        <td style="text-align: right;"><strong> Tax</strong></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($subContractorItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>
                                        </td>
                                        <td style="text-align:right"><?php echo $subContractorItem['aggregateTaxRate']; ?>
                                            %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="background:#FFFFFF"></td>
                                        <td style="text-align: right;"><strong>Total</strong></td>
                                        <td style="text-align:right">
                                            <strong>$<?php echo number_format($rowTotal, 2, '.', ','); ?></strong></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
                <div id="tabs-3">

                    <a class="btn blue-button right" style="position: absolute; right: 20px; top: 4px;"
                       href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                        <i class="fa fa-fw fa-calculator"></i> Estimator
                    </a>

                    <div class="row" style="margin-bottom:0px">

                        <div class="col s12">

                            <table id="estimateSummaryItems" class="" style="width: 100%;text-align: right;">
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

                                foreach ($sortedItems as $tsortedItem) { ?>
                                    <?php $rowTotal = 0;
                                    $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                    $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                    $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                    $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                    $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                    ?>
                                    <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
                                        <td style="text-align: left;"><?php echo $tsortedItem['category']->getName(); ?></td>
                                        <td>$<?php echo number_format($tsortedItem['aggregateBaseCost'], 2); ?></td>
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
                                        <td><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice()) * 100), 2) ?>
                                            %
                                        </td>
                                        <td style="text-align: right;">
                                            $<?php echo number_format($tsortedItem['aggregateTotalRate'], 2, '.', ','); ?> </td>

                                    </tr>
                                <?php }
                               // $truckingItems = [];
                                ///Trucking item list showing
                                if(count($truckingItems)>0){ 
                                    $tsortedItem = $truckingItems;
                                    $rowTotal = 0;
                                    $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                    $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                    $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                    $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                    $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                    ?>
                                    <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
                                        <td style="text-align: left;">Trucking</td>
                                        <td>$<?php echo number_format($tsortedItem['aggregateBaseCost'], 2); ?></td>
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
                                        <td><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice()) * 100), 2) ?>
                                            %
                                        </td>
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
                                    <tr <?= ($tsortedItem['aggregateProfitPrice']<0 || $tsortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                        <td style="text-align: left;">Sub Contractors</td>
                                        <td>$<?php echo number_format($tsortedItem['aggregateBaseCost'], 2); ?></td>
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
                                        <td><?php echo number_format((($tsortedItem['aggregateTotalRate'] / $proposal->getTotalPrice()) * 100), 2) ?>
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
                                    <td>$<?php echo number_format($basetotal, 2); ?></td>
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
                        </div>
                    </div>
                </div>
                <div id="tabs-4">
                <div style="position: absolute;right: 10px;top: 4px;">
                        <select class="dont-uniform select_service" style=" display:block;height:15px!important;border: 1px solid #25aae1;width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($all_proposal_services as $all_proposal_service) :
                                echo '<option value="' . $all_proposal_service->getServiceId() . '">' . $all_proposal_service->getServiceName() . '</option>';
                            endforeach;
                            ?>
                        </select>
                </div>
                    <?php

                    $count_phase = 1;
                    foreach ($services as $service) :
                        // print_r($item['phase_count']);
                        $serviceSortedItems = $service['sortedItems'];
                        $serviceTruckingItems = $service['truckingItems'];
                        $service_details = $service['service_details'];
                        $serviceFieldValues = $service['fieldValues'];
                        $serviceTemplateItems = $service['serviceTemplateItems'];
                        
                        
                        //if (count($serviceSortedItems) > 0) {?>
    
                            <div class="row all_service_box table_<?= $service_details->getServiceId(); ?>" id="" style="margin-bottom:0px">
                                <a class="btn blue-button right go_to_estimate_service" data-val="<?=  $service_details->getServiceId(); ?>" href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                                    <i class="fa fa-fw fa-calculator"></i> Estimator
                                </a>
                            <p style="font-size:18px;font-weight:bold;"><?= $service_details->getServiceName(); ?> </p>

                            <?php
                                if ($serviceFieldValues) {
                                    $measurementValue = 0;
                                    $unitValue = 0;
                                    ?>
                                    <div class="row" style="">
                                        <div class="col s8" style="padding-left: 0;">

                                        <?php foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                        <?php
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }
                                        ?>
                                            <div class="col s6" style="padding-left: 0;">
                                                <div class="col s8 right-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <strong><?= $serviceFieldValue['field']->getFieldName() ?>:</strong>
                                                    </p>

                                                </div>
                                                <div class="col s4 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <?= ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0; ?>
                                                    </p>

                                                </div>
                                            </div>

                                        <?php } ?>
                                        </div>
                                        <div class="col s4" style="padding: 0;">
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail">$<?php echo str_replace('$', '', $service_details->getPrice()); ?></p>
                                                </div>
                                            </div>
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Unit Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail"><?php echo ($measurementValue) ? $repo->pricePerUnit($measurementValue, $service_details->getPrice(), $unitValue) : '-' ?></p>
                                                </div>
                                            </div>
                                            <?php if($repo->serviceHasItemOfType($service_details, \models\EstimationType::ASPHALT)) {
                                                $tons = $repo->getServiceMaxTonsValue($service_details);
                                                $pricePerTon = $repo->pricePerTon($service_details->getPrice(), $tons);
                                                ?>
                                                <div class="col s12" style="padding: 0">
                                                    <div class="col s6 right-align" style="padding:0px">
                                                        <p class="priceDetail"><span class="priceTitleHeading">Price Per Ton:</span></p>
                                                    </div>
                                                    <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                        <p class="priceDetail"><?php echo $pricePerTon; ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            <div class="clearfix relative" >

                                

                                    <div class="col s12" style="padding:0px">

                                        <?php

                                        if (count($serviceSortedItems) > 0) {
                                            foreach ($serviceSortedItems as $serviceSortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;"><?php echo $serviceSortedItem['category']->getName(); ?></p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        <?php } else { ?>
                                                            <th width="12%">Area</th>
                                                            <th width="7%">Depth</th>
                                                            <th width="1%"></th>
                                                        <?php } ?>
                                                        <th width="16%" style="text-align:right;">Quantity</th>
                                                        <th width="6%"></th>
                                                        <th width="14%" style="text-align:right;">Total Price</th>

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
                                                                    // if ($saved_values) {
                                                                    //     $saved_values = json_decode($saved_values);
                                                                    // } else {
                                                                    //     $saved_values = [];
                                                                    //     echo '<td></td><td></td><td></td>';
                                                                    // }

                                                                    // for ($i = 0; $i < count($saved_values); $i++) {
                                                                    //     //print_r($saved_values[$i]->name);

                                                                    //     if ($saved_values[$i]->name == 'truck_capacity') {
                                                                    //         echo '<td></td><td></td><td></td>';
                                                                    //     }else if ($saved_values[$i]->name == 'time_type_input' || $saved_values[$i]->name == 'labor_time_type_input' || $saved_values[$i]->name == 'equipement_time_type_input') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     } else if ($saved_values[$i]->name == 'number_of_person' || $saved_values[$i]->name == 'labor_number_of_person' || $saved_values[$i]->name == 'equipement_number_of_person') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     }  else if ($saved_values[$i]->name == 'hour_per_day' || $saved_values[$i]->name == 'labor_hour_per_day' || $saved_values[$i]->name == 'equipement_hour_per_day') {
                                                                    //         echo '<td>' . $saved_values[$i]->value . '</td>';
                                                                    //     }
                                                                    // }
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
                                                                            if (stripos($saved_values[$i]->value, 'yard')) {
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
                                                            <td></td>
                                                            <td style="text-align:right;">
                                                                <?php 
                                                                echo ($breaklineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($breaklineItem->getTotalPrice(), 2, '.', ',')
                                                                ?></td>

                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>

                                                    <tr style="border-top:2px solid #bbbbbb">
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $serviceSortedItem['category']->getName(); ?>
                                                                Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    <tr <?= ($serviceSortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $serviceSortedItem['category']->getName(); ?>
                                                                Overhead</strong></td>

                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($serviceSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr <?= ($serviceSortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $serviceSortedItem['category']->getName(); ?>
                                                                Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($serviceSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                      
                                                        <td style="text-align: right;">
                                                            <strong>
                                                                Tax</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($serviceSortedItem['aggregateTaxRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } else { ?>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        <?php } ?>
                                                        <td style="text-align: right;">
                                                            <strong><?php echo $serviceSortedItem['category']->getName(); ?>
                                                                Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php endforeach;
                                        }

                                        /// trucking Item list
                                        if (count($serviceTruckingItems) > 0) {
                                            $serviceSortedItem = $serviceTruckingItems;
                                            $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;">Trucking</p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        
                                                        <th width="16%" style="text-align:right;">Quantity</th>
                                                        <th width="6%"></th>
                                                        <th width="14%" style="text-align:right;">Total Price</th>

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
                                                              
                                                                    echo $breaklineItem->getItem()->getName();
                                                                
                                                                if ($breaklineItem->item_type_trucking == 1) {
                                                                    echo '<br/>' . $breaklineItem->plant_dump_address;
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php
                                                            
                                                                    echo '<td>' . $breaklineItem->getDay() . '</td><td>' . $breaklineItem->getNumPeople() . '</td><td>' . $breaklineItem->getHoursPerDay() . '</td>';
                                                               

                                                           
                                                            ?>
                                                            <td style="text-align:right;"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>
                                                                <?php echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                            </td>
                                                            <td></td>
                                                            <td style="text-align:right;">
                                                                <?php 
                                                                echo ($breaklineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '$'.number_format($breaklineItem->getTotalPrice(), 2, '.', ',')
                                                                ?></td>

                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>

                                                    <tr style="border-top:2px solid #bbbbbb">
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    <tr <?= ($serviceSortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Overhead</strong></td>

                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($serviceSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr <?= ($serviceSortedItem['aggregateProfitPrice']<0)?'style="color:red"':'';?>>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($serviceSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                      
                                                        <td style="text-align: right;">
                                                            <strong>
                                                                Tax</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($serviceSortedItem['aggregateTaxRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                            <td style="background:#FFFFFF"></td>
                                                      
                                                        <td style="text-align: right;">
                                                            <strong>Trucking
                                                                Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($serviceSortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php 
                                        }





//Start service Fix template Division

$n=0;
                foreach ($serviceTemplateItems as $key=>$templateSortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    
            
                        <div class="phaseItemSection assembly_section" id="assembly_section_<?=$n;?>" style="page-break-inside:avoid">
                       
                        <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Assembly <?php echo ($templateSortedItem['is_empty_template']==0)? ' - '.$templateSortedItem['template_name'] : '';?></p>
                        <table id="estimateSummaryItems" class="assembly_section_table" style="width: 100%;">
                            <thead>
                            <tr>
                            <?php if($templateSortedItem['is_empty_template']==1){
                                ?>
                                
                                <th width="40%">Name</th>
                                <?php }else{?>
                                
                                <th width="10%" >Category</th>
                                <th width="20%" >Type</th>
                                <th width="20%">Item</th>
                                <?php }?>
                                        <th width="5%">Days</th>
                                        <th width="5%">#</th>
                                        
                                        <th width="5%">Hrs/Day</th>
                                    
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                    <th width="7%" >Total</th>
                                <!-- <th>Total Price</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                                
                                <tr>
                                <!--Check If Template Is Empty-->
                                <?php if($templateSortedItem['is_empty_template']==1){?>

                                    <td style="text-align: left;"><?=$templateSortedItem['template_name'];?></td>
                                
                                <?php }else{?>

                                    <td style="text-align: left;" class="phase_section_item_type"><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItemType()->getName(); ?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItem()->getName();?></td>
                                <?php } ?>
                                
                                <?php 
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                ?>
                                    <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                            <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                        </td>
                                        
                                        <td style="text-align:right"><?php echo ($lineItem->getFixedTemplate()==2) ? '-': '$'.number_format($lineItem->getTotalPrice(), 2, '.', ','); ?></td>
                                    <!-- <td style="padding-top: 2px;"><div class="input_div"></div></td> -->
                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            <tr style="border-top:2px solid #bbbbbb">
                                        <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                        <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Overhead</strong></td>
                                                        
                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($templateSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($templateSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    <?php if($templateSortedItem['is_empty_template']!=1){?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                    <?php } ?>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        <td style="background:#FFFFFF"></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Assembly Total</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php 
                                                            if($templateSortedItem['is_fixed_template']==1){
                                                                echo number_format($templateSortedItem['fixed_template_total'], 2, '.', ',');
                                                            }else{
                                                                echo number_format($rowTotal, 2, '.', ',');
                                                             } ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    
                            </tbody>
                            
                        </table>
                        <div class="divider"></div>
                        </div>
            
                   
                    <?php 
                    $n++;
                    endforeach;



//End service Fix Template Division





                                        if (count($service['subContractorItem']) > 0) {
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

                                                    <tr style="border-top:2px solid #bbbbbb">

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Cost</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateOverheadPrice']<0 )?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Overhead</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"><?php echo number_format($breaksortedItem['aggregateOverheadRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateProfitPrice']<0 )?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Profit</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateProfitRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Tax</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateTaxRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Total</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php endforeach;

                                        }

                                        if(!count($service['subContractorItem']) > 0 && !count($serviceSortedItems) > 0){
                                            echo '<p  style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                        } 
                                        ?>
                                    </div>

                                </div>

                            </div>
                            <?php

                      //  }
                    endforeach; ?>
                </div>
                <div id="tabs-5">
                <div style="position: absolute;right: 10px;top: 4px;">
                        <select class="dont-uniform select_service" style=" display:block;height:15px!important;border: 1px solid #25aae1;width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($all_proposal_services as $all_proposal_service) :
                                echo '<option value="' . $all_proposal_service->getServiceId() . '">' . $all_proposal_service->getServiceName() . '</option>';
                            endforeach;
                            ?>
                        </select>
                </div>
                    <?php

                    $count_phase = 1;
                    foreach ($services as $service) :
                        $serviceSortedItems = $service['sortedItems'];
                        $serviceTruckingItems = $service['truckingItems'];
                        $service_details = $service['service_details'];
                        $subContractorItem = $service['subContractorItem'];
                        $serviceFieldValues = $service['fieldValues'];

                        $measurementValue = false;
                        $unitValue = false;
                        ?>
                        <div class="clearfix relative all_service_box table_<?= $service_details->getServiceId(); ?>" id="">

                            <div class="row" style="padding-bottom:10px">
                                <a class="btn blue-button right go_to_estimate_service" data-val="<?= $service_details->getServiceId(); ?>" href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                                    <i class="fa fa-fw fa-calculator"></i> Estimator
                                </a>
                                <p style="font-size:18px;font-weight:bold;"><?= $service_details->getServiceName(); ?></p>

                                <?php
                                if ($serviceFieldValues) {
                                    $measurementValue = 0;
                                    $unitValue = 0;
                                    ?>
                                    <div class="row" style="">
                                        <div class="col s8" style="padding-left: 0;">

                                        <?php foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                        <?php
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }
                                        ?>
                                            <div class="col s6" style="padding-left: 0;">
                                                <div class="col s8 right-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <strong><?= $serviceFieldValue['field']->getFieldName() ?>:</strong>
                                                    </p>

                                                </div>
                                                <div class="col s4 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <?= ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0; ?>
                                                    </p>

                                                </div>
                                            </div>

                                        <?php } ?>
                                        </div>
                                        <div class="col s4" style="padding: 0;">
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail">$<?php echo str_replace('$', '', $service_details->getPrice()); ?></p>
                                                </div>
                                            </div>
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Unit Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail"><?php echo ($measurementValue) ? $repo->pricePerUnit($measurementValue, $service_details->getPrice(), $unitValue) : '-' ?></p>
                                                </div>
                                            </div>
                                            <?php if($repo->serviceHasItemOfType($service_details, \models\EstimationType::ASPHALT)) {
                                                $tons = $repo->getServiceMaxTonsValue($service_details);
                                                $pricePerTon = $repo->pricePerTon($service_details->getPrice(), $tons);
                                            ?>
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Price Per Ton:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail"><?php echo $pricePerTon; ?></p>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div>
                                    <?php
                                    if (count($serviceSortedItems) > 0 || count($subContractorItem) > 0) {
                                        ?>
                                        <table id="estimateSummaryItems" class=""
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
                                                <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
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


                                            if(count($serviceTruckingItems)>0) { 
                                                $tsortedItem= $serviceTruckingItems;
                                                $rowTotal = 0;
                                                $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                                $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                                $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                                $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                                $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                                ?>
                                                <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
                                                    <td style="text-align: left;">Trucking</td>
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
                                                <tr <?= ($tsortedItem['aggregateProfitPrice']<0 || $tsortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
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
                                        echo '<p style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                    } ?>

                                </div>


                            </div>

                        </div>

                    <?php endforeach; ?>
                </div>

                <div id="tabs-6">

                    <div style="position: absolute;right: 10px;top: 4px;">
                        <select class="dont-uniform select_service_phase" style=" display:block;height:15px!important;border: 1px solid #25aae1; width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($items as $item) :

                                if ($item['phase_count'] == '1') {
                                    echo '<option data-val="service" value="' . $item['proposalService']->getServiceId() . '">' . $item['proposalService']->getServiceName() . '</option>';
                                }
                                echo '<option data-val="phase" data-service-id="' . $item['proposalService']->getServiceId() . '" value="' . $item['phase']['id'] . '">--' . $item['phase']['name'] . '</option>';

                            endforeach;
                            ?>
                        </select>
                    </div>

                    <?php

                    $count_phase = 1;
                    foreach ($items as $item) :

                        $serviceSortedItems = $item['sortedItems'];
                        $phaseTruckingItems = $item['phaseTruckingItems'];
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
                                        <a class="btn blue-button right go_to_estimate_service" data-val="<?= $service_details->getServiceId(); ?>" href="<?php echo site_url('/proposals/estimate/' . $proposal->getProposalId()); ?>">
                                            <i class="fa fa-fw fa-calculator"></i> Estimator
                                        </a>
                                        <p style="font-size:18px;font-weight:bold;"><?= $item['proposalService']->getServiceName(); ?></p>
                                        <?php
                                
                                if ($serviceFieldValues) {
                                    $measurementValue = 0;
                                    $unitValue = 0;
                                    ?>
                                    <div class="row" style="">
                                        <div class="col s8" style="padding-left: 0;">

                                        <?php foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                        <?php 

                                            
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }
                                        ?>
                                            <div class="col s6" style="padding-left: 0;">
                                                <div class="col s8 right-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <strong><?= $serviceFieldValue['field']->getFieldName() ?>:</strong>
                                                    </p>

                                                </div>
                                                <div class="col s4 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <?= ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0; ?>
                                                    </p>

                                                </div>
                                            </div>

                                        <?php } ?>
                                        </div>
                                        <div class="col s4" style="padding: 0;">
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail">$<?php echo str_replace('$', '', $service_details->getPrice()); ?></p>
                                                </div>
                                            </div>
                                            <div class="col s12" style="padding: 0">
                                                <div class="col s6 right-align" style="padding:0px">
                                                    <p class="priceDetail"><span class="priceTitleHeading">Unit Price:</span></p>
                                                </div>
                                                <div class="col s6 left-align" style="padding:0 0 0 10px;">
                                                    <p class="priceDetail"><?php echo ($measurementValue) ? $repo->pricePerUnit($measurementValue, $service_details->getPrice(), $unitValue) : '-' ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                                } ?>
                                    <div class="col s12 summaryPhaseHeading">
                                        <div class="col s4 summaryPhaseHeadingText">
                                            <?php echo $item['phase_count'] . '. ' . $item['phase']['name']; ?>
                                        </div>
                                        <div class="col s2 summaryPhaseHeadingPriceText">
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
                                                <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
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

                                            if(count($phaseTruckingItems)>0) { 
                                                $tsortedItem = $phaseTruckingItems;
                                                $rowTotal = 0;
                                                $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                                $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                                $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                                $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                                $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
                                                ?>
                                                <tr <?php  if($tsortedItem['aggregateOverheadPrice']<0 || $tsortedItem['aggregateProfitPrice']<0){ echo 'style="color:red"';}?>>
                                                    <td style="text-align: left;">Trucking</td>
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
                                                <tr <?= ($tsortedItem['aggregateProfitPrice']<0 || $tsortedItem['aggregateOverheadPrice']<0)?'style="color:red"':'';?>>
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
                                        echo '<p class="phase_p phase_p_' . $item['phase']['id'] . '" style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                    } ?>


                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
                <div id="tabs-7">
                <div style="position: absolute;right: 10px;top: 4px;">
                        <select class="dont-uniform select_service" style=" display:block;height:15px!important;border: 1px solid #25aae1;width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($all_proposal_services as $all_proposal_service) :
                                echo '<option value="' . $all_proposal_service->getServiceId() . '">' . $all_proposal_service->getServiceName() . '</option>';
                            endforeach;
                            ?>
                        </select>
                </div>
                    <?php

                    $count_phase = 1;
                    foreach ($services as $service) :
                        // print_r($item['phase_count']);
                        $serviceSortedItems = $service['sortedItems'];
                        $serviceTruckingItems = $service['truckingItems'];
                        $service_details = $service['service_details'];
                        $serviceFieldValues = $service['fieldValues'];
                        $serviceTemplateItems = $service['serviceTemplateItems'];
                        
                        
                        //if (count($serviceSortedItems) > 0) {?>
    
                            <div class="row all_service_box table_<?= $service_details->getServiceId(); ?>" id="" style="margin-bottom:0px">
                               
                            <p style="font-size:18px;font-weight:bold;background-color: #25aae16b;"><?= $service_details->getServiceName(); ?> </p>

                            <?php
                                if ($serviceFieldValues) {
                                    ?>
                                    <div class="row" style="">
                                        <div class="col s12" style="padding-left: 0;">

                                        <?php foreach ($serviceFieldValues as $serviceFieldValue) { ?>
                                        <?php
                                            if ($serviceFieldValue['cesf']->getMeasurement()) {
                                                $measurementValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }

                                            if ($serviceFieldValue['cesf']->getUnit()) {
                                                $unitValue = ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0;
                                            }
                                        ?>
                                            <div class="col s6" style="padding-left: 0;">
                                                <div class="col s8 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <strong><?= $serviceFieldValue['field']->getFieldName() ?>:</strong>
                                                    </p>

                                                </div>
                                                <div class="col s4 left-align" style="padding-left: 0;">
                                                    <p class="specDetail">
                                                        <?= ($serviceFieldValue['values']) ? $serviceFieldValue['values']->getFieldValue() : 0; ?>
                                                    </p>

                                                </div>
                                            </div>

                                        <?php } ?>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            <div class="clearfix relative" >

                                

                                    <div class="col s12" style="padding:0px">

                                        <?php

                                        if (count($serviceSortedItems) > 0) {
                                            foreach ($serviceSortedItems as $serviceSortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;"><?php echo $serviceSortedItem['category']->getName(); ?></p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        <?php } else { ?>
                                                            <th width="15%">Area</th>
                                                            <th width="5%">Depth</th>
                                                        <?php } ?>
                                                        <th width="16%" style="text-align:right;">Quantity</th>
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
                                                                if (count(json_decode($saved_values)) > 0) {
                                                                    $saved_values = json_decode($saved_values);
                                                                    $measurement = '';
                                                                    $unit = '';
                                                                    $depth = '';
                                                                    for ($i = 0; $i < count($saved_values); $i++) {
                                                                        if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                                                                            $measurement = $saved_values[$i]->value;
                                                                        } else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                                            if (stripos($saved_values[$i]->value, 'yard')) {
                                                                                $unit = 'Sq. Yd';
                                                                            } else {
                                                                                $unit = 'Sq. Ft';
                                                                            }
                                                                        } else if ($saved_values[$i]->name == 'depth') {
                                                                            $depth = $saved_values[$i]->value . ' Inch';
                                                                        }
                                                                    }
                                                                    echo '<td>' . $measurement . ' ' . $unit . '</td><td>' . $depth . '</td>';
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

                                        /// trucking Item list
                                        if (count($serviceTruckingItems) > 0) {
                                            $serviceSortedItem = $serviceTruckingItems;
                                            $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;">Trucking</p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Type</th>
                                                        <th width="17%">Item</th>
                                                        
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        
                                                        <th width="16%" style="text-align:right;">Quantity</th>
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
                                                              
                                                                    echo $breaklineItem->getItem()->getName();
                                                                
                                                                if ($breaklineItem->item_type_trucking == 1) {
                                                                    echo '<br/>' . $breaklineItem->plant_dump_address;
                                                                }
                                                                ?>
                                                            </td>
                                                            <?php
                                                            
                                                                    echo '<td>' . $breaklineItem->getDay() . '</td><td>' . $breaklineItem->getNumPeople() . '</td><td>' . $breaklineItem->getHoursPerDay() . '</td>';
                                                               

                                                           
                                                            ?>
                                                            <td style="text-align:right;"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>
                                                                <?php echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                            </td>

                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                            <?php 
                                        }





//Start service Fix template Division

$n=0;
                foreach ($serviceTemplateItems as $key=>$templateSortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    
            
                        <div class="phaseItemSection assembly_section" id="assembly_section_<?=$n;?>" style="page-break-inside:avoid">
                       
                        <p class="phase_table phase_table_<?= $item['phase']['id']; ?>" style="font-size:15px;font-weight:bold;">Assembly <?php echo ($templateSortedItem['is_empty_template']==0)? ' - '.$templateSortedItem['template_name'] : '';?></p>
                        <table id="estimateSummaryItems" class="assembly_section_table" style="width: 100%;">
                            <thead>
                            <tr>
                            <?php if($templateSortedItem['is_empty_template']==1){
                                ?>
                                
                                <th width="40%">Name</th>
                                <?php }else{?>
                                
                                <th width="10%" >Category</th>
                                <th width="20%" >Type</th>
                                <th width="20%">Item</th>
                                <?php }?>
                                        <th width="5%">Days</th>
                                        <th width="5%">#</th>
                                        
                                        <th width="5%">Hrs/Day</th>
                                    
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                <!-- <th>Total Price</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                                
                                <tr>
                                <!--Check If Template Is Empty-->
                                <?php if($templateSortedItem['is_empty_template']==1){?>

                                    <td style="text-align: left;"><?=$templateSortedItem['template_name'];?></td>
                                
                                <?php }else{?>

                                    <td style="text-align: left;" class="phase_section_item_type"><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItemType()->getName(); ?></td>
                                    <td style="text-align: left;"><?php echo $lineItem->getItem()->getName();?></td>
                                <?php } ?>
                                
                                <?php 
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                ?>
                                    <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                            <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                        </td>
                                        
                                    <!-- <td style="padding-top: 2px;"><div class="input_div"></div></td> -->
                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>       
                            </tbody>
                            
                        </table>
                        <div class="divider"></div>
                        </div>
            
                   
                    <?php 
                    $n++;
                    endforeach;



//End service Fix Template Division





                                        if (count($service['subContractorItem']) > 0) {
                                            $breaksortedItems = $service['subContractorItem'];
                                            foreach ($breaksortedItems as $breaksortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;">Sub Contractors</p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>

                                                        <th width="25%">Sub Contractor Name</th>

                                                        <th width="15%" style="text-align:right;">Quantity</th>
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

                                                    <tr style="border-top:2px solid #bbbbbb">

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Cost</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateOverheadPrice']<0 )?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Overhead</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"><?php echo number_format($breaksortedItem['aggregateOverheadRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr <?= ($breaksortedItem['aggregateProfitPrice']<0 )?'style="color:red"':'';?>>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Profit</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateProfitRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Tax</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTaxPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        <td style="text-align:right"> <?php echo number_format($breaksortedItem['aggregateTaxRate'], 1, '.', ','); ?>
                                                            %
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td style="background:#FFFFFF"></td>

                                                        <td style="text-align: right;"><strong> Total</strong></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($breaksortedItem['aggregateTotalRate'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            <?php endforeach;

                                        }

                                        if(!count($service['subContractorItem']) > 0 && !count($serviceSortedItems) > 0){
                                            echo '<p  style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
                                        } 
                                        ?>
                                    </div>

                                </div>

                            </div>
                            <?php

                      //  }
                    endforeach; ?>
                </div>

            </div>


        </div>

    </div>

</div>

<?php } else { ?>

    <h4>This estimate contains no items</h4>

<?php } ?>
</div>

<?php $this->load->view('global/footer'); ?>
<script>
    $(function () {
        $(".total_item").hide();
        $(".breakdown_total").show();
        $(".phase_total").hide();
        $(".service_total").hide();
        $(".service_breakdown").hide();
        $(".work_order").hide();

        $("#tabs").tabs({
            beforeActivate: function (event, ui) {
                reset_dropdowns();
                if (ui.newPanel.selector == '#tabs-1') {

                    // Hide the frame
                    $(".total_item").hide();
                    $(".phase_total").hide();
                    $(".breakdown_total").show();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                    $(".work_order").hide();
                } else if (ui.newPanel.selector == '#tabs-2') {
                    $(".total_item").show();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                    $(".work_order").hide();
                }else if (ui.newPanel.selector == '#tabs-6') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").show();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                    $(".work_order").hide();
                }else if (ui.newPanel.selector == '#tabs-5') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").show();
                    $(".service_breakdown").hide();
                    $(".work_order").hide();
                }else if (ui.newPanel.selector == '#tabs-4') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").show();
                    $(".work_order").hide();
                } else if (ui.newPanel.selector == '#tabs-7'){
                    $(".total_item").hide();
                    $(".phase_total").hide();
                    $(".breakdown_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                    $(".work_order").show();
                }else {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                    $(".work_order").hide();
                }
            }
        });
    });
    $(document).on("change", ".select_service", function () {
        $('.all_service_box').hide();
        if ($(this).val() == 'all') {
            $('.all_service_box').show();
        } else {
            $('.table_' + $(this).val()).show();
        }
    });

    $(document).on("change", ".select_service_phase", function () {
        $('.all_service_phase_box').hide();
        if ($(this).val() == 'all') {
            $('.all_service_phase_box').show();
            $('.phase_p,.phase_table').show();
        } else {

            if ($('option:selected', this).attr('data-val') == 'service') {
                $('.phase_p,.phase_table').show();
                $('.service_div_' + $(this).val()).show();
            } else {
                $('.phase_p,.phase_table').hide();


                $('.service_div_' + $('option:selected', this).attr('data-service-id')).show();
                $('.phase_p_' + $(this).val() + ',.phase_table_' + $(this).val()).show();
            }


        }
    });
function reset_dropdowns(){
    console.log('check');
    $(".select_service_phase").val('all');
    $(".select_service").val('all');
    $(".select_service_phase").trigger('change');
    $(".select_service").trigger('change');
}
    $(document).on('click', '.expandSpecDetail', function() {
        $(this).toggleClass('open');
        $(this).parents('.row').find('.specsDetail').toggle();
    });
    
    $(document).on('click', '.go_to_estimate_service', function() {
        if(hasLocalStorage){
            localStorage.setItem("service_id", $(this).data('val'));
        }
    });
</script>