<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header'); ?>
<style>
table#estimateSummaryItems td {
    padding: 10px;
}
tr:hover .tr_edit_icon{display: block}
.tr_edit_icon{display:none;}
.tr_job_cost_edit_icon{display:none;}
tr:hover .tr_job_cost_edit_icon{display: block}
tr:hover .tr_job_item_delete_btn{display: block}

.tr_edit_input{display: none;background-color: #fff!important;
    border: 1px solid #ccc!important;
    border-bottom: 1px solid #ccc!important;
    height: auto!important;margin:0px!important;font-size:14px!important;
    padding: 3px 5px!important;
    font-size: 12px!important;
    border-radius: 3px!important}
.tr_action_btn{display: none;}
.tr_action_btn span{padding: 0px!important}
.has_item_value {
    background-color: #b1e5fb!important;
}
.input60{
    width:60px!important
}
.add_item_btn span{padding: 2px!important;}
h3.accordionHeader {
    font-size: 12px;
    padding-top: 6px;
    padding-bottom: 5px;
}
.stripping-row tr:nth-child(even) {
        background-color: #efefef;
}
.stripping-row tr:nth-child(odd) {
        background-color: #fafafa;
}
.materialize td, .materialize th {
    padding: 5px;
    border-radius: 0px;
}
.jobCostItems span.tiptip{border-bottom:0px}
</style>
<div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">

    <!-- <a href="<?php echo site_url('proposals/estimate/' . $proposal->getProposalId()); ?>" class="btn right">
        <i class="fa fa-chevron-left"></i> Back
    </a>
    <a href="<?php echo site_url('pdf/live2/download/item-sheet-total/' . $proposal->getAccessKey() . '.pdf'); ?>"
       class="btn right total_item">
        Download
    </a> -->
    
    
    <h4 style="float:left">Job Cost: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?>
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


       


        <div class="clearfix relative">
            <div >
                
                
                <div >
                <p style="font-size:18px;position: absolute;right: 100px;top: -11px;width: 40%;font-weight:bold;" >Total Price Difference: <span class="proposal_price_diff"><?php echo ($proposaljob_cost_price_difference<0)?'-$'.number_format(abs($proposaljob_cost_price_difference),2):'$'.number_format($proposaljob_cost_price_difference,2);  ?></span> </p>
                <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative;top: -12px;left: 82%;" >Complete Job Costing</a>
                <!-- <div style="position: absolute;right: 21px;top: 4px;">
                        <select class="dont-uniform select_service" style=" display:block;height:15px!important;border: 1px solid #25aae1;width: 200px;">
                            <option value="all">All Services</option>
                            <?php
                            foreach ($all_proposal_services as $all_proposal_service) :
                                echo '<option value="' . $all_proposal_service->getServiceId() . '">' . $all_proposal_service->getServiceName() . '</option>';
                            endforeach;
                            ?>
                        </select>
                </div> -->
                <div class="accordionContainer">
                    <?php

                    $count_phase = 1;
                    foreach ($services as $service) :
                        // print_r($item['phase_count']);
                        $serviceSortedItems = $service['sortedItems'];
                        $service_details = $service['service_details'];
                        $serviceFieldValues = $service['fieldValues'];
                        $job_cost_price_difference = $service['job_cost_price_difference'];
                        
                        //if (count($serviceSortedItems) > 0) {?>
      <h3 class="accordionHeader" style="margin: 0px;">
      <span><?= $service_details->getServiceName(); ?></span>
      <a href="javascript:void(0);" class="add_item_btn btn blue-button" style="font-size:12px;top: -5px;" data-val="<?= $service_details->getServiceId(); ?>" >Add Item</a>
      <p style="font-size:14px;font-weight:bold;float:right;margin-right: 10px;margin-top: -5px;" class="service_price_diff_<?= $service_details->getServiceId(); ?>"><?php echo ($job_cost_price_difference < 0)?'-$'.number_format(abs($job_cost_price_difference),2):'$'.number_format($job_cost_price_difference,2); ?> </p>
    </h3>
                            <!-- <div class="row all_service_box table_<?= $service_details->getServiceId(); ?>" id="" style="margin-bottom:0px">
                               
                            <p style="font-size:18px;font-weight:bold;"><span><?= $service_details->getServiceName(); ?></span> <a href="javascript:void(0);" class="add_item_btn btn blue-button" style="font-size:12px" data-val="<?= $service_details->getServiceId(); ?>" >Add Item</a>  </p>
                            <p style="font-size:18px;font-weight:bold;" class="service_price_diff_<?= $service_details->getServiceId(); ?>"><?php echo ($job_cost_price_difference < 0)?'-$'.number_format(abs($job_cost_price_difference),2):'$'.number_format($job_cost_price_difference,2); ?> </p> -->
                            <div class="clearfix relative" >

                                

                                    <div class="col s12" style="padding:0px">

                                        <?php

                                        if (count($serviceSortedItems) > 0) {
                                            foreach ($serviceSortedItems as $serviceSortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;"><?php echo $serviceSortedItem['category']->getName(); ?></p>
                                                <table class="jobCostItems stripping-row"  style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th width="14%">Type</th>
                                                        <th width="14%">Item</th>
                                                        <?php if ($serviceSortedItem['category']->getId() != 1) { ?>
                                                            <th width="7%">Days</th>
                                                            <th width="7%">#</th>
                                                            <th width="6%">Hrs/Day</th>
                                                        <?php } else { ?>
                                                            <th width="12%">Area</th>
                                                            <th width="10%">Depth</th>
                                                            <th width="1%"></th>
                                                        <?php } ?>
                                                        <th width="12%" style="text-align:right;">Quantity</th>
                                                        
                                                        <th width="14%" style="text-align:right;">Total Price</th>
                                                        <th width="8%"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                     if(isset($serviceSortedItem['items'])){
                                                        foreach ($serviceSortedItem['items'] as $breaklineItem) : 
                                                            $saved_values = $breaklineItem->saved_values;
                                                            if($breaklineItem->saved_values){
                                                                $saved_values = $breaklineItem->saved_values;
                                                            }else{
                                                                $saved_values = '';
                                                            }
                                                            ?>
                                                      
                                                        <tr class="<?= ($breaklineItem->job_cost)?'has_item_value':'';?>" id="tr_line_item_<?=$breaklineItem->getId();?>" data-unit-price="<?=$breaklineItem->getUnitPrice();?>" data-total-price="<?=$breaklineItem->old_total;?>" data-proposal-service-id="<?=$breaklineItem->getProposalServiceId();?>" data-quantity="<?=$breaklineItem->getQuantity();?>" data-base-price="<?=$breaklineItem->getBasePrice();?>" data-quantity="<?=$breaklineItem->old_quantity;?>" data-category-id="<?=$breaklineItem->getItemType()->getCategoryId();?>" data-val='<?php echo $saved_values;?>'>
                                                            <td style="padding: 5px;"><span class="tr_edit_icon tiptip" title="Enter Cost" style="float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="cursor:pointer;"></i></span></td>
                                                            <td style="text-align:left;"><?php
                                                                //print_r($breaklineItem);die;
                                                                
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
                                                                    
                                                                    echo '<td><span class="span_day tr_edit_span">' . str_replace('.00', '', number_format($breaklineItem->getDay(), 2, '.', ',')) . '</span><input value="' . str_replace('.00', '', number_format($breaklineItem->getDay(), 2, '.', ',')) . '" class="input_day tr_edit_input number_field" type="text"  style="width: 30px;"></td><td><span class="span_num_people tr_edit_span">' . str_replace('.00', '', number_format($breaklineItem->getNumPeople(), 2, '.', ',')) . '</span><input value="' . str_replace('.00', '', number_format($breaklineItem->getNumPeople(), 2, '.', ',')) . '" class="input_num_people tr_edit_input number_field" type="text"  style="width: 30px;"></td><td><span class="span_hpd tr_edit_span">' . str_replace('.00', '', number_format($breaklineItem->getHoursPerDay(), 2, '.', ',')) . '</span><input value="' . str_replace('.00', '', number_format($breaklineItem->getHoursPerDay(), 2, '.', ',')) . '" class="input_hpd tr_edit_input number_field" type="text" style="width: 30px;" ></td>';
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
                                                                            // if($breaklineItem->job_costing==1){
                                                                            //     $measurement = str_replace('.00', '',$breaklineItem->area);
                                                                            // }else{
                                                                                $measurement = str_replace('.00', '',$saved_values[$i]->value);
                                                                            //}
                                                                            
                                                                        } else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                                            if (stripos($saved_values[$i]->value, 'yard')) {
                                                                                $unit = 'Sq. Yd';
                                                                            } else {
                                                                                $unit = 'Sq. Ft';
                                                                            }
                                                                        } else if ($saved_values[$i]->name == 'depth') {
                                                                            // if($breaklineItem->job_costing==1){
                                                                            //     $depth = str_replace('.00', '', $breaklineItem->depth);
                                                                            // }else{
                                                                                $depth = str_replace('.00', '',$saved_values[$i]->value);
                                                                           // }
                                                                            
                                                                        }
                                                                    }
                                                                    echo '<td><span class=" span_measurement">' . $measurement . '</span> <span>' . $unit . '</span></td><td><span class=" span_depth">' . $depth . '</span><span> Inch</span></td><td></td>';
                                                                } else {
                                                                    $saved_values = [];
                                                                    echo '<td></td><td></td><td></td>';
                                                                }
                                                            }
                                                            ?>
                                                            <td style="text-align:right;"><span class="span_quantity tr_edit_span"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?></span><input class="input_quantity tr_edit_input number_field" style="width: 50px;" type="text" value="<?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>">
                                                                <?php echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                            </td>
                                                            
                                                            <td style="text-align:right;">
                                                                <?php 
                                                                echo ($breaklineItem->getFixedTemplate()==2) ? 'Fixed Rate Item': '<span class="span_total ">$'.str_replace('.00', '', number_format($breaklineItem->base_total , 2, '.', ',')).'</span>'
                                                                ?></td>
                                                            <td style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_item_reset_btn tiptip tr_action_btn"   title="Reset"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip tr_action_btn tr_cancel_btn"   title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_save_btn tiptip tr_action_btn"   title="Save"  ><i class="fa fa-fw fa-1x fa-check " ></i></a></span></td>
                                                        </tr>
                                                        
                                                    <?php endforeach; }?>
                                                    <!-- custom job items list -->
                                                    
                                                    <?php 
                                                    if(isset($serviceSortedItem['job_cost_items'])){

                                                    
                                                    foreach ($serviceSortedItem['job_cost_items'] as $jobCostItem) : 
                                                        
                                                        ?>
                                                      
                                                        <tr class="has_item_value" id="tr_job_cost_item_<?=$jobCostItem->getId();?>" data-unit-price="<?=$jobCostItem->getActualUnitPrice();?>" data-total-price="<?=$jobCostItem->getActualTotalPrice();?>" data-proposal-service-id="<?=$jobCostItem->getProposalServiceId();?>" >
                                                            <td style="padding: 5px;"><span class="tr_job_cost_edit_icon tiptip" title="Enter Cost" style="float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="cursor:pointer;"></i></span></td>
                                                            <td style="text-align:left;">Job Cost Item</td>
                                                            <td style="text-align:left;"><?php echo $jobCostItem->getCustomItemName();?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="text-align:right;"><span class="span_quantity tr_edit_span"><?php echo trimmedQuantity($jobCostItem->getActualQty()); ?></span><input class="input_quantity tr_edit_input number_field" style="width: 50px;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualQty()); ?>">
                                                                <?php // echo $breaklineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                            </td>
                                                            
                                                            <td style="text-align:right;">
                                                                <span class="span_total tr_edit_span"><?php echo  '$'.str_replace('.00', '', number_format($jobCostItem->getActualTotalPrice(), 2, '.', ','));?></span><input class="input_job_item_total tr_edit_input currency_field" style="width: 50px;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualTotalPrice()); ?>">
                                                            </td>
                                                            <td style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="fa fa-fw fa-1x fa-trash " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip tr_action_btn tr_cancel_btn"   title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_save_btn tiptip tr_action_btn"   title="Save"  ><i class="fa fa-fw fa-1x fa-check " ></i></a></span></td>
                                                        </tr>
                                                        
                                                    <?php 
                                                            
                                                            endforeach; 
                                                            
                                                        }?>

                                                    </tbody>
                                                </table>

                                            <?php endforeach;
                                        }
                                        if (count($service['subContractorItem']) > 0) {
                                            $breaksortedItems = $service['subContractorItem'];
                                            foreach ($breaksortedItems as $breaksortedItem) : ?>
                                                <?php $rowTotal = 0; ?>
                                                <p style="font-size:15px;font-weight:bold;">Sub Contractors</p>
                                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th width="25%">Sub Contractor Name</th>

                                                        <th width="15%" style="text-align:right;">Quantity</th>
                                                        <th width="15%" style="text-align:right;">Total Price</th>
                                                        <th width="10%"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($breaksortedItem['items'] as $breaklineItem) : ?>
                                                        <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                                        <tr class="<?= ($breaklineItem->job_cost)?'has_item_value':'';?>" id="tr_line_item_<?=$breaklineItem->getId();?>" data-unit-price="<?=$breaklineItem->getUnitPrice();?>" data-total-price="<?=$breaklineItem->old_total;?>" data-proposal-service-id="<?=$breaklineItem->getProposalServiceId();?>" data-quantity="<?=$breaklineItem->getQuantity();?>" data-base-price="<?=$breaklineItem->getBasePrice();?>" data-quantity="<?=$breaklineItem->old_quantity;?>"  >
                                                        <td style="padding: 5px;"><span class="tr_edit_icon tiptip" title="Enter Cost" style="float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="cursor:pointer;"></i></span></td>
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

                                                            <td style="text-align:right;">
                                                            <span class="span_quantity tr_edit_span"><?php echo trimmedQuantity($breaklineItem->getQuantity()); ?></span><input class="input_quantity tr_edit_input number_field" style="width: 50px;" type="text" value="<?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>">
                                                            
                                                                Qty

                                                            </td>
                                                            <td style="text-align:right;"><span class="span_total ">
                                                                $<?php echo number_format($breaklineItem->base_total, 2, '.', ',') ?></span></td>
                                                                <td style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_item_reset_btn tiptip tr_action_btn"   title="Reset"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip tr_action_btn tr_cancel_btn"   title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_save_btn tiptip tr_action_btn"   title="Save"  ><i class="fa fa-fw fa-1x fa-check " ></i></a></span></td>
                                                        </tr>
                                                        <?php $rowTotal = $rowTotal + $breaklineItem->getTotalPrice(); ?>
                                                    <?php endforeach; ?>

                                                   
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

                            <!-- </div> -->
                            <?php

                      //  }
                    endforeach; ?>
                </div>
                

                
            </div>


        </div>

    </div>

</div>


</div>

<div id="add_job_cost_item_modal" title="Add Job Cost Item" style="display: none;">
    <!-- <h3 class="text-center">Change Calculation Type</h3> -->
    
    <form action="<?php echo site_url('ajax/save_job_cost_item'); ?>" method="post">
    <input type="hidden" name="proposal_id" value="<?php echo $proposal->getProposalId(); ?>">
    <input type="hidden" class="proposal_service_id" name="proposal_service_id" value="">
    <table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <label for="defaultOverhead" style="width: 150px;"> Category</label>
                <span class="cwidth4_container">
                <select name="categoryType" class="categoryType">
                    <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category->getId() ?>">
                        <?php echo $category->getName(); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                </span>
            </td>
        </tr>
        <tr >
            <td>
                <label for="" style="width: 150px;"> Name</label>
                <input type="text" name="job_cost_item_name" class="text " style=" text-align: left"
                       value="">
            </td>
        </tr>
        <tr >
            <td>
                <label for="" style="width: 150px;"> Quantity</label>
                <input type="text" name="job_cost_item_quantity" class="text input60 job_cost_item_quantity number_field"  style="text-align: right"
                       value="">
            </td>
        </tr>
        <!-- <tr >
            <td>
                <label for="" style="width: 150px;">Unit Price</label>
                <input type="text" name="job_cost_item_unit_price" class="text input45 job_cost_item_unit_price"  style="text-align: right"
                       value="">
            </td>
        </tr> -->
        <tr >
            <td>
                <label for="" style="width: 150px;">Total</label>
                <input type="text" name="job_cost_item_total" class="text input60 job_cost_item_total currency_field"   style="text-align: right"
                       value="0.00">
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn blue-button" type="submit" style="float: right;">
                    <i class="fa fa-fw fa-save"></i> Save 
                </button>
            </td>
        </tr>

    </table>

</form>
</div>
<?php $this->load->view('global/footer'); ?>
<script src='/static/js/inputmask.js'></script>
<script>
        $(document).ready(function() {

var openAccordion = localStorage.getItem('selectedJobCostAccordionId');
        
        if(openAccordion){
            setTimeout(function() {
                if (openAccordion) {
                    $("#" + openAccordion).trigger('click');
                }
            }, 100);
        }
        

            $("#add_job_cost_item_modal").dialog({
                modal: true,
                autoOpen: false,
                width: 600
            });

            $( ".accordionContainer" ).accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "h3",
            activate : function (event, ui) {
                if (ui.newHeader[0]) {
                    var selectedAccordionId = ui.newHeader[0].id;
                    if(hasLocalStorage){
                        localStorage.setItem('selectedJobCostAccordionId', selectedAccordionId);
                    }
                } else {
                    localStorage.removeItem('selectedJobCostAccordionId');
                }
                
                

            },
            
            });

            var total_items  = $('.jobCostItems tbody tr').length;
            var saved_items = $('.has_item_value').length;
            if(total_items==saved_items){
                $('.complate_job_costing').removeClass('disabled');
            }

});
    $(function () {
        $(".total_item").hide();
        $(".breakdown_total").show();
        $(".phase_total").hide();
        $(".service_total").hide();
        $(".service_breakdown").hide();
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
                } else if (ui.newPanel.selector == '#tabs-2') {
                    $(".total_item").show();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                }else if (ui.newPanel.selector == '#tabs-6') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").show();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
                }else if (ui.newPanel.selector == '#tabs-5') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").show();
                    $(".service_breakdown").hide();
                }else if (ui.newPanel.selector == '#tabs-4') {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").show();
                }else {
                    $(".total_item").hide();
                    $(".breakdown_total").hide();
                    $(".phase_total").hide();
                    $(".service_total").hide();
                    $(".service_breakdown").hide();
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
    $(document).on('click', '.tr_edit_icon', function() {
        $('.tr_edit_input').hide();
        $('.tr_action_btn').hide();
        $('.tr_edit_span').show();

        $(this).closest('tr').find('.tr_edit_input').show();
        $(this).closest('tr').find('.tr_action_btn').show();
        $(this).closest('tr').find('.tr_edit_span').hide();
    });

    $(document).on('click', '.tr_job_cost_edit_icon', function() {
        $('.tr_edit_input').hide();
        $('.tr_action_btn').hide();
        $('.tr_edit_span').show();

        $(this).closest('tr').find('.tr_edit_input').show();
        $(this).closest('tr').find('.tr_action_btn').show();
        $(this).closest('tr').find('.tr_edit_span').hide();
    });
    $(document).on('click', '.tr_cancel_btn', function() {
        $('.tr_edit_input').hide();
        $('.tr_action_btn').hide();
        $('.tr_edit_span').show();
    });
    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });
    $(".number_field").inputmask("decimal",
    {
        "radixPoint": ".",
        "groupSeparator":",",
        "digits":2,
        "allowMinus": false,
        "autoGroup":true,
    });
    $(document).on('click', '.tr_job_item_delete_btn', function() {
        var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = tr_item_id.replace(new RegExp("^" + 'tr_job_cost_item_'), '');
        var tr_row =$(this).closest('tr');
        swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/deleteCustomJobCostItems',
                        type: "POST",
                        data: {
                            "item_id": id,
                        },

                        success: function(data){
                            tr_row.remove();
                            swal('Item Deleted')
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
            
        $(this).closest('tr').find('.input_job_item_total').val('0');
        $(this).closest('tr').find('.input_quantity').val('0');
 
     });
    
    $(document).on('click', '.tr_item_reset_btn', function() {
        var tr_row =$(this).closest('tr');
        swal({
                title: "Are you sure?",
                text: "Item values will be reset",
                showCancelButton: true,
                confirmButtonText: 'Reset Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    tr_row.find('.span_total ').text('$0');
                    tr_row.find('.input_quantity').val('0');
                    
                    tr_row.find('.input_day').val('0');
                    tr_row.find('.input_num_people').val('0');
                    tr_row.find('.input_hpd').val('0');


                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
       
       

    });
    $(document).on('click', '.tr_job_item_save_btn', function() {
        
        var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = tr_item_id.replace(new RegExp("^" + 'tr_job_cost_item_'), '');
        var total = cleanNumber($(this).closest('tr').find('.input_job_item_total').val());
        var quantity = cleanNumber($(this).closest('tr').find('.input_quantity').val()); 
        
        var proposal_service_id = $(this).closest('tr').attr('data-proposal-service-id');
        var tr_row =$(this).closest('tr');

        $.ajax({
            url: '/ajax/updateJobCostCustomItem/',
            type: 'post',
            data: {
                
                'quantity':quantity,
                'total':total,
                'id':id,
                
                
            },
            success: function(data){
                swal('Saved');
                data =JSON.parse(data)
                tr_row.find('.span_quantity').text(quantity);
                tr_row.find('.span_total').text('$'+addCommas(parseFloat(total).toFixed(2)));
                tr_row.addClass('has_item_value');
                $('.tr_edit_input,.tr_action_btn').hide();
                $('.tr_edit_span').show();
                if(parseFloat(data.service_price_diff)<0){
                    var service_price_diff = '-$'+addCommas(number_test2(Math.abs(data.service_price_diff)));
                }else{
                    var service_price_diff = '$'+addCommas(number_test2(data.service_price_diff));
                    
                }

                if(parseFloat(data.proposal_price_diff)<0){
                    var proposal_price_diff = '-$'+addCommas(number_test2(Math.abs(data.proposal_price_diff)));
                    
                }else{
                    var proposal_price_diff = '$'+addCommas(number_test2(data.proposal_price_diff));
                    
                }
                $('.service_price_diff_'+proposal_service_id).text(service_price_diff);
                $('.proposal_price_diff').text(proposal_price_diff);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        }); 

    });
    $(document).on('click', '.tr_save_btn', function() {
        
        var overhead = '';
        var profit = '';
        var tax = '';
        var taxPrice = '';
        var total = '';

        var overheadPrice = '';
        var profitPrice = '';
        var taxPrice = '';

        
        var day = $(this).closest('tr').find('.input_day').val();
        day = (day)?cleanNumber(day):'';
        var num_people = $(this).closest('tr').find('.input_num_people').val();
        num_people = (num_people)?cleanNumber(num_people):'';
        var hpd = $(this).closest('tr').find('.input_hpd').val();
        hpd = (hpd)?cleanNumber(hpd):'';
        var quantity = $(this).closest('tr').find('.input_quantity').val();
        quantity = (quantity)?cleanNumber(quantity):'';
        var item_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
        var proposal_service_id =$(this).closest('tr').attr('data-proposal-service-id')
        
        var old_quantity = $(this).closest('tr').attr('data-quantity');
        var old_total = parseFloat(item_price * old_quantity);
        var category_id = $(this).closest('tr').attr('data-category-id');
        var tr_row =$(this).closest('tr');


        var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = tr_item_id.replace(new RegExp("^" + 'tr_line_item_'), '');
        var cal_values =  $(this).closest('tr').attr('data-val')
        
        // if(cal_values){
        //     cal_values =  JSON.parse(cal_values);

        //     for($i=0;$i<cal_values.length;$i++){
        //         if(cal_values[$i].name=='cal_overhead'){
        //             overhead = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_profit'){
        //             profit = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_tax'){
        //             tax = cleanNumber(cal_values[$i].value);
        //         }
        //     }
        //     var item_base_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
        //     var tempoverheadPrice = ((item_base_price * overhead) / 100);
        //     var tempprofitPrice = ((item_base_price * profit) / 100);
        //     overheadPrice = tempoverheadPrice * quantity;
        //     profitPrice = tempprofitPrice * quantity;
        
        //     var item_price =cleanNumber($(this).closest('tr').attr('data-unit-price'));
        //     var temp_total = quantity * item_price;


        //     taxPrice = ((temp_total * tax) / 100);

        //     total = parseFloat(temp_total) + parseFloat(taxPrice);

        // }else{
            
            var total = quantity * item_price;
        //}
        $.ajax({
            url: '/ajax/updateJobCostItem/',
            type: 'post',
            data: {
                'day':day,
                'num_people':num_people,
                'hpd':hpd,
                'quantity':quantity,
                'total':total,
                'id':id,
                'proposal_service_id':proposal_service_id,
                'proposal_id':<?=$proposal->getProposalId();?>,
                'overhead':overhead,
                'overheadPrice':overheadPrice,
                'profit':profit,
                'profitPrice':profitPrice,
                'tax':tax,
                'taxPrice':taxPrice,
                'old_total':old_total,
                'category_id':category_id,
                'old_quantity':old_quantity
                
            },
            success: function(data){
                swal('Saved');
                data =JSON.parse(data)
                tr_row.find('.span_day').text(day);
                tr_row.find('.span_num_people').text(num_people);
                tr_row.find('.span_hpd').text(hpd);
                tr_row.find('.span_quantity').text(quantity);
                tr_row.find('.span_total').text('$'+addCommas(parseFloat(total).toFixed(2)));
                tr_row.addClass('has_item_value');
                $('.tr_edit_input,.tr_action_btn').hide();
                $('.tr_edit_span').show();
                
                if(parseFloat(data.service_price_diff)<0){
                    var service_price_diff = '-$'+addCommas(number_test2(Math.abs(data.service_price_diff)));
                }else{
                    var service_price_diff = '$'+addCommas(number_test2(data.service_price_diff));
                    
                }

                if(parseFloat(data.proposal_price_diff)<0){
                    var proposal_price_diff = '-$'+addCommas(number_test2(Math.abs(data.proposal_price_diff)));
                    
                }else{
                    var proposal_price_diff = '$'+addCommas(number_test2(data.proposal_price_diff));
                    
                }
                $('.service_price_diff_'+proposal_service_id).text(service_price_diff);
                $('.proposal_price_diff').text(proposal_price_diff);
                var total_items  = $('.jobCostItems tbody tr').length;
                var saved_items = $('.has_item_value').length;
                if(total_items==saved_items){
                    $('.complate_job_costing').removeClass('disabled');
                }

            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });

    });

    function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

    $(document).on('keyup', '.input_day,.input_num_people,.input_hpd', function() {
        var day = $(this).closest('tr').find('.input_day').val();
        day = (day)?cleanNumber(day):'';
        var num_people = $(this).closest('tr').find('.input_num_people').val();
        num_people = (num_people)?cleanNumber(num_people):'';
        var hpd = $(this).closest('tr').find('.input_hpd').val();
        hpd = (hpd)?cleanNumber(hpd):'';

        var quantity = day * num_people * hpd;
        $(this).closest('tr').find('.input_quantity').val(quantity);
        var cal_values =  $(this).closest('tr').attr('data-val')
        var item_base_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
        // if(cal_values){
        //     cal_values =  JSON.parse(cal_values);
        
        //     var overhead = '';
        //     var profit = '';
        //     var tax = '';
        //     for($i=0;$i<cal_values.length;$i++){
        //         if(cal_values[$i].name=='cal_overhead'){
        //             overhead = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_profit'){
        //             profit = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_tax'){
        //             tax = cleanNumber(cal_values[$i].value);
        //         }
        //     }
        //     var item_base_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
        //     var tempoverheadPrice = ((item_base_price * overhead) / 100);
        //     var tempprofitPrice = ((item_base_price * profit) / 100);
        //     overheadPrice = tempoverheadPrice * quantity;
        //     profitPrice = tempprofitPrice * quantity;
            
        //     var item_price =cleanNumber($(this).closest('tr').attr('data-unit-price'));
        //     var temp_total = quantity * item_price;


        //     var taxPrice = ((temp_total * tax) / 100);

        //     var total = parseFloat(temp_total) + parseFloat(taxPrice);
        //     console.log(total);
            

        // }else{
            var item_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
            var total = quantity * item_price;
        //}
        $(this).closest('tr').find('.span_total').text('$'+addCommas(parseFloat(total).toFixed(2)));
    });


    $(document).on('keyup', '.input_quantity', function() {
        

        var quantity = $(this).closest('tr').find('.input_quantity').val();
        quantity = (quantity)?cleanNumber(quantity):'';
        var cal_values =  $(this).closest('tr').attr('data-val')
        var item_base_price = cleanNumber($(this).closest('tr').attr('data-base-price'));
        // if(cal_values){
        //     cal_values =  JSON.parse(cal_values);
        
        //     var overhead = '';
        //     var profit = '';
        //     var tax = '';
        //     for($i=0;$i<cal_values.length;$i++){
        //         if(cal_values[$i].name=='cal_overhead'){
        //             overhead = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_profit'){
        //             profit = cleanNumber(cal_values[$i].value);
        //         }else if(cal_values[$i].name=='cal_tax'){
        //             tax = cleanNumber(cal_values[$i].value);
        //         }
        //     }
            
        //     var tempoverheadPrice = ((item_base_price * overhead) / 100);
        //     var tempprofitPrice = ((item_base_price * profit) / 100);
        //     overheadPrice = tempoverheadPrice * quantity;
        //     profitPrice = tempprofitPrice * quantity;
            
        //     var item_price =cleanNumber($(this).closest('tr').attr('data-unit-price'));
        //     var temp_total = quantity * item_price;


        //     var taxPrice = ((temp_total * tax) / 100);

        //     var total = parseFloat(temp_total) + parseFloat(taxPrice);
           

        // }
        var total = quantity * item_base_price;
        $(this).closest('tr').find('.span_total').text('$'+addCommas(parseFloat(total).toFixed(2)));
    });

    function number_test2(n)
    {
        var result = (n - Math.floor(n)) !== 0;

        if (result){
        return parseFloat(n).toFixed(2);
         }else{
        return parseInt(n);
        }


    }

    $('.add_item_btn').on('click', function(e) {
        e.stopPropagation();
        var service_id = $(this).attr('data-val');
        $('.proposal_service_id').val(service_id);
        $('.categoryType').val('');
        $.uniform.update();
        $("#add_job_cost_item_modal").dialog('open');
    });
    

    $(".currency_span").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });

 
        $(document).on('keyup', '.job_cost_item_unit_price,.job_cost_item_quantity', function() { 
            var unit_price = $('.job_cost_item_unit_price').val();
            
            var quantity = $('.job_cost_item_quantity').val();
            var total = unit_price * quantity;
            $('.job_cost_item_total').val(parseFloat(total).toFixed(2));
        })     

        
        $(document).on('click', '.complate_job_costing', function() { 
            
            var total_items  = $('.jobCostItems tbody tr').length;
            var saved_items = $('.has_item_value').length;
            if(total_items!=saved_items){
                swal('All Item are not saved')

            }else{

                swal({
                    title: "Are you sure?",
                    text: "Job costing will be completed",
                    showCancelButton: true,
                    confirmButtonText: 'Complete',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        location.href = "/ajax/completeJobCosting/<?php echo $proposal->getProposalId(); ?>";
                        

                    } else {
                        swal("Cancelled", "Your Estimation is safe :)", "error");
                    }
                });

            }
        });
</script>