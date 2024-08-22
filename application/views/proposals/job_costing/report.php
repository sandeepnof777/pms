<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header'); ?>
<link rel="stylesheet" href="<?php echo site_url('static') ?>/css/lightbox.min.css">

<style>
.tr_row_green{background-color: #A1C4AD!important;border-bottom: 1px solid #88a592;}
.tr_row_red{background-color: #F0A1A3!important; border-bottom: 1px solid #c59192;}
.materialize td, .materialize th {
    padding: 5px;
    border-radius: 0px;
}
.stripping-row tr:nth-child(even) {
        background-color: #efefef;
}
.stripping-row tr:nth-child(odd) {
        background-color: #fafafa;
}
.card2{
  width:100%;
  height:auto;
  margin: 4% auto;
  box-shadow:-3px 5px 15px #000;
  cursor: pointer;
  -webkit-transition: all 0.2s;
  transition: all 0.2s;
}
.dataTables_filter label input {
    background: #ddd!important;
    color: #000!important;
    border: 1px solid #888!important;
    height:auto!important;
    width:auto!important;
}
</style>
<div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">

    
    <h4 style="float:left">Job Cost Report: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?>
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
                    <li><a href="#tabs-3">Totals</a></li>
                    <li><a href="#tabs-5">Service Totals</a></li>
                    <li><a href="#tabs-2">All Items</a></li>
                    <li><a href="#tabs-4">Breakdown</a></li>
                    <?php if($image_count>0){?>
                        <li><a href="#tabs-6">Images</a></li>
                    <?php } ?>
                    <?php if(count($attachments)>0){?>
                        <li><a href="#tabs-8">Attachments</a></li>
                    <?php } ?>
                    <li><a href="#tabs-7">History</a></li>
                    
                   
                    
                </ul>
                
                <div id="tabs-2">
                    <div class="row" style="margin-bottom:0px">
                       
                        <div class="col s12">

                            <?php


                            foreach ($sortedItems as $newsortedItem) : ?>
                                <?php $rowTotal = 0; ?>
                                <?php 
                               // print_r($category_total);
                                foreach ($category_total as $val) {
                                   
                                            if ($val['category_id'] == $newsortedItem['category']->getId()) {
                                                if($val['difference_total']<0){
                                                    $total = '-$'.number_format(abs($val['difference_total']), 2, '.', ',');
                                                }else{
                                                    $total = '$'.number_format(abs($val['difference_total']), 2, '.', ',');
                                                }
                                                
                                                echo '<p style="font-size:15px;font-weight:bold;float:right">Total: '. $total. '</p>';
                                              
                                            }
                                        }
                                    ?>
                                <p style="font-size:15px;font-weight:bold;"><?php echo $newsortedItem['category']->getName(); ?></p>
                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                    <thead style="border-bottom: none;">
                                    <tr>
                                        <th width="15%">Type</th>
                                        <th width="17%">Item</th>
                                        <th width="8%" style="text-align:right;">Est QTY</th>
                                        <th width="8%" style="text-align:right;">Actual QTY</th>
                                        <th width="8%" style="text-align:right;">Est Cost</th>
                                        <th width="8%" style="text-align:right;">Actual Cost</th>
                                        <th width="8%" style="text-align:right;">Difference %</th>
                                        <th width="8%" style="text-align:right;">Difference $</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    if(isset($newsortedItem['items'])){
                                        foreach ($newsortedItem['items'] as $lineItem) : 
                                            
                                            $prefix ='';
                                            $color_class = 'tr_row_green'; 
                                            if($lineItem->diff<0){
                                                $prefix ='-';
                                            }else if($lineItem->diff>0)
                                            {
                                                $prefix ='+';
                                                $color_class = 'tr_row_red';
                                            }
                                        
                                            ?>

                                            <tr class="<?=$color_class;?>">
                                                <td style="text-align:left"><?php
                                                    $saved_values = $lineItem->saved_values;
                                                    $check_type = $lineItem->item_type_time;
                                                    echo $lineItem->getItemType()->getName(); ?></td>
                                                <td style="text-align:left">
                                                    <?php
                                                    
                                                    
                                                    $ratio = ($lineItem->getQuantity()>0) ? ($lineItem->act_qty / $lineItem->getQuantity()) : 0;
                                                    $percent = 0;
                                                    if($ratio==0){
                                                        $percent = 0;
                                                        $percent_prefix = '';
                                                        
                                                    } else if($ratio<1){
                                                        $percent = ($ratio-1) * 100;
                                                        $percent_prefix = '';
                                                        
                                                    } else{
                                                        $percent_prefix = '+';
                                                        $percent = '+'.($ratio-1) * 100;
                                                    }
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
                                                
                                                <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                </td>
                                                
                                                <td style="text-align:right;"><?php echo trimmedQuantity($lineItem->act_qty); ?> <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></td>
                                                <td style="text-align:right;"><span class="span_total ">$<?php echo str_replace('.00', '', number_format(($lineItem->getBasePrice() *$lineItem->getQuantity()), 2, '.', ',')); ?></span></td>
                                                <td style="text-align:right;"><span class="span_total ">$<?php echo str_replace('.00', '', number_format($lineItem->act_total, 2, '.', ',')); ?></span></td>
                                                <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                                <td style="text-align:right;"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($lineItem->diff), 2, '.', ','));  ?></td>
                                            

                                            </tr>
                                        
                                        <?php endforeach; 
                                        }?>
                                    <?php 
                                    if(isset($newsortedItem['job_cost_items'])){
                                        foreach ($newsortedItem['job_cost_items'] as $jobCostItem) : 
                                                        
                                                        $prefix ='';
                                                        $color_class = 'tr_row_green'; 
                                                        if($jobCostItem->getPriceDifference()<0){
                                                            $prefix ='-';
                                                        }else if($jobCostItem->getPriceDifference()>0)
                                                        {
                                                            $prefix ='+';
                                                            $color_class = 'tr_row_red';
                                                        }
                                                    
                                                        ?>
                                                      
                                                        <tr class="<?=$color_class;?>" id="tr_job_cost_item_<?=$jobCostItem->getId();?>" data-unit-price="<?=$jobCostItem->getActualUnitPrice();?>" data-total-price="<?=$jobCostItem->getActualTotalPrice();?>" data-proposal-service-id="<?=$jobCostItem->getProposalServiceId();?>" >
                                                            
                                                            <td style="text-align:left;">Job Cost Item</td>
                                                            <td style="text-align:left;"><?php echo $jobCostItem->getCustomItemName();?></td>
                                                            <td></td>
                                                            <td style="text-align:right;"><?php echo trimmedQuantity($jobCostItem->getActualQty()); ?> </td>
                                                            <td></td>
                                           
                                            <td style="text-align:right;"><span class="span_total ">$<?php echo str_replace('.00', '', number_format($jobCostItem->getActualTotalPrice(), 2, '.', ',')); ?></span></td>
                                            <td></td>
                                            <td style="text-align:right;"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($jobCostItem->getPriceDifference()), 2, '.', ','));  ?></td>                
                                                            
                                                             </tr>
                                                        
                                                    <?php endforeach; }?>
                                    
                                    </tbody>
                                </table>

                            <?php endforeach; ?>
                             <!-- custom job items list -->

                             

                            <?php
                            foreach ($subContractorItems as $subContractorItem) :
                                $rowTotal = 0; ?>
                                <p style="font-size:15px;font-weight:bold;">Sub Contractors</p>
                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                    <thead style="border-bottom: none;">
                                    <tr>
                                        <th width="15%">Type</th>
                                        <th width="17%">Item</th>
                                        <th width="8%" style="text-align:right;">Est QTY</th>
                                        <th width="8%" style="text-align:right;">Actual QTY</th>
                                        <th width="8%" style="text-align:right;">Est Cost</th>
                                        <th width="8%" style="text-align:right;">Actual Cost</th>
                                        <th width="8%" style="text-align:right;">Difference %</th>
                                        <th width="8%" style="text-align:right;">Difference $</th>
                                    </tr>
                                    </thead>
                                    
                                
                                    <tbody>
                                    <?php foreach ($subContractorItem['items'] as $lineItem) : 

                                        $prefix ='';
                                            $color_class = 'tr_row_green'; 
                                            if($lineItem->diff<0){
                                                $prefix ='-';
                                            }else if($lineItem->diff>0)
                                            {
                                                $prefix ='+';
                                                $color_class = 'tr_row_red';
                                            }
                                        
                                            ?>

                                            <tr class="<?=$color_class;?>">
                                                <td style="text-align:left"><?php
                                                    $saved_values = '';
                                                    $check_type = '';?>Sub Contractors</td>
                                                <td style="text-align:left">
                                                    <?php
                                                    
                                                    
                                                    $ratio = ($lineItem->getQuantity()>0) ? ($lineItem->act_qty / $lineItem->getQuantity()) : 0;
                                                    $percent = 0;
                                                    if($ratio==0){
                                                        $percent = 0;
                                                        $percent_prefix = '';
                                                        
                                                    } else if($ratio<1){
                                                        $percent = ($ratio-1) * 100;
                                                        $percent_prefix = '';
                                                        
                                                    } else{
                                                        $percent_prefix = '+';
                                                        $percent = '+'.($ratio-1) * 100;
                                                    }
                                                    if ($lineItem->getIsCustomSub() == 1) {
                                                        echo $lineItem->getCustomName();
                                                    } else {
                                                        echo $lineItem->getSubContractor()->getCompanyName();
                                                    }
                                                    ?>
                                                </td>
                                                
                                                <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?>
                                                </td>
                                                
                                                <td style="text-align:right;"><?php echo trimmedQuantity($lineItem->act_qty); ?> <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></td>
                                                <td style="text-align:right;"><span class="span_total ">$<?php echo str_replace('.00', '', number_format(($lineItem->getBasePrice() *$lineItem->getQuantity()), 2, '.', ',')); ?></span></td>
                                                <td style="text-align:right;"><span class="span_total ">$<?php echo str_replace('.00', '', number_format($lineItem->act_total, 2, '.', ',')); ?></span></td>
                                                <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                                <td style="text-align:right;"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($lineItem->diff), 2, '.', ','));  ?></td>
                                            

                                        
                                        </tr>
                                        <?php $rowTotal = $rowTotal + ($lineItem->getBasePrice() *$lineItem->getQuantity()); ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
                <div id="tabs-3">

                    

                    <div class="row" style="margin-bottom:0px">

                        <div class="col s12">

                            <table id="estimateSummaryItems" class="" style="width: 100%;text-align: right;">
                                <thead>
                                <tr>
                                    <th width="16%" style="text-align: left;">Category</th>
                                    <!-- <th width="8%" style="text-align:right;">Est QTY</th>
                                    <th width="8%" style="text-align:right;">Actual QTY</th> -->
                                    <th width="8%" style="text-align:right;">Estimated Cost</th>
                                    <th width="8%" style="text-align:right;">Actual Cost</th>
                                    <th width="8%" style="text-align:right;">Difference %</th>
                                    <th width="8%" style="text-align:right;">Difference $</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $est_qty_total = 0;
                                $act_qty_total = 0;
                                $est_cost_total = 0;
                                $act_cost_total = 0;
                                $diff_total = 0;

                                foreach ($category_total as $category) { 

                                        $prefix ='';
                                        $color_class = 'tr_row_green'; 
                                        if($category['difference_total']<0){
                                            $prefix ='-';
                                        }else if($category['difference_total']>0)
                                        {
                                            $prefix ='+';
                                            $color_class = 'tr_row_red';
                                        }
                                        
                                       
                                        $ratio = ($category['estimated_total']>0) ? ($category['actual_total'] / $category['estimated_total']) : 0;
                                        $percent = 0;
                                        if($ratio==0){
                                            $percent = 0;
                                            $percent_prefix = '';
                                            
                                        }else if($ratio<1){
                                            $percent = ($ratio-1) * 100;
                                            $percent_prefix = '';
                                            
                                        } else{
                                            $percent_prefix = '+';
                                            $percent = ($ratio-1) * 100;
                                        }

                                        $est_qty_total = $est_qty_total + $category['estimated_qty_total'];
                                        $act_qty_total = $act_qty_total + $category['actual_qty_total'];
                                        $est_cost_total = $est_cost_total + $category['estimated_total'];
                                        $act_cost_total = $act_cost_total + $category['actual_total'];
                                        $diff_total = $diff_total + $category['difference_total'];
                                    ?>
                                   
                                    <tr  class="<?=$color_class;?>">
                                        <td style="text-align: left;"><?php echo $category['category_name']; ?></td>
                                        <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($category['estimated_qty_total'], 2)); ?></td>
                                        <td style="text-align: right;">
                                            <?php echo str_replace('.00', '', number_format($category['actual_qty_total'], 2, '.', ',')); ?></td> -->
                                        <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($category['estimated_total'], 2, '.', ',')); ?>
                                           
                                        </td>
                                        <td style="text-align: right;">
                                            $<?php echo str_replace('.00', '', number_format($category['actual_total'], 2, '.', ',')); ?> </td>
                                        <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                        <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($category['difference_total']), 2, '.', ','));  ?>
                                            
                                        </td>
                                        

                                    </tr>
                                <?php }
                                foreach ($sub_contractor_total as $category) { ?>
                                    <!-- <?php $rowTotal = 0;
                                    // $overheadtotal = $overheadtotal + $tsortedItem['aggregateOverheadPrice'];
                                    // $profittotal = $profittotal + $tsortedItem['aggregateProfitPrice'];
                                    // $finaltotal = $finaltotal + $tsortedItem['aggregateTotalRate'];
                                    // $taxtotal = $taxtotal + $tsortedItem['aggregateTaxPrice'];
                                    // $basetotal = $basetotal + $tsortedItem['aggregateBaseCost'];
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

                                    </tr> -->
                                    <?php
                                        $prefix ='';
                                        $color_class = 'tr_row_green'; 
                                        if($category['difference_total']<0){
                                            $prefix ='-';
                                        }else if($category['difference_total']>0)
                                        {
                                            $prefix ='+';
                                            $color_class = 'tr_row_red';
                                        }
                                        

                                        $ratio = ($category['estimated_total']>0) ? ($category['actual_total'] / $category['estimated_total']) : 0;
                                        $percent = 0;
                                        if($ratio==0){
                                            $percent = 0;
                                            $percent_prefix = '';
                                            
                                        }else if($ratio<1){
                                            $percent = ($ratio-1) * 100;
                                            $percent_prefix = '';
                                            
                                        } else{
                                            $percent_prefix = '+';
                                            $percent = ($ratio-1) * 100;
                                        }

                                        $est_qty_total = $est_qty_total + $category['estimated_qty_total'];
                                        $act_qty_total = $act_qty_total + $category['actual_qty_total'];
                                        $est_cost_total = $est_cost_total + $category['estimated_total'];
                                        $act_cost_total = $act_cost_total + $category['actual_total'];
                                        $diff_total = $diff_total + $category['difference_total'];
                                        ?>

                                        <tr  class="<?=$color_class;?>">
                                        <td style="text-align: left;">Sub Contractors</td>
                                        <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($category['estimated_qty_total'], 2)); ?></td>
                                        <td style="text-align: right;">
                                            <?php echo str_replace('.00', '', number_format($category['actual_qty_total'], 2, '.', ',')); ?></td> -->
                                        <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($category['estimated_total'], 2, '.', ',')); ?>
                                            
                                        </td>
                                        <td style="text-align: right;">
                                            $<?php echo str_replace('.00', '', number_format($category['actual_total'], 2, '.', ',')); ?> </td>
                                        <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                        <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($category['difference_total']), 2, '.', ','));  ?>
                                            
                                        </td>
                                        

                                        </tr>
<?php
                                }
                                $prefix ='';
                                   $color_class = 'tr_row_green'; 
                                        if($diff_total<0){
                                            $prefix ='-';
                                        }else if($diff_total>0)
                                        {
                                            $prefix ='+';
                                            $color_class = 'tr_row_red';
                                        }
                                        $ratio = ($est_cost_total>0) ? ($act_cost_total / $est_cost_total) : 0;
                                        $percent = 0;
                                        if($ratio==0){
                                            $percent = 0;
                                            $percent_prefix = '';
                                            
                                        }else if($ratio<1){
                                            $percent = ($ratio-1) * 100;
                                            $percent_prefix = '';
                                            
                                        }else{
                                            $percent_prefix = '+';
                                            $percent = ($ratio-1) * 100;
                                        }
                                ?>

                                <tr style="font-weight:bold" class="<?= $color_class ;?>">
                                    <td style="text-align: left;">Total</td>
                                    <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($est_qty_total, 2)); ?></td>
                                    <td style="text-align: right;">
                                        <?php echo str_replace('.00', '', number_format($act_qty_total, 2, '.', ',')); ?></td> -->
                                    <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($est_cost_total, 2, '.', ',')); ?>
                                        
                                    </td>
                                    <td style="text-align: right;">
                                        $<?php echo str_replace('.00', '', number_format($act_cost_total, 2, '.', ',')); ?> </td>
                                        <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                    <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($diff_total), 2, '.', ','));  ?>
                                        
                                    </td>
                                    

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div id="tabs-5">
                <div style="position: absolute;right: 21px;top: 4px;">
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
                        //$serviceSortedItems = [];
                        $service_details = $service['service_details'];
                        $subContractorItem = $service['subContractorItem'];
                        $serviceFieldValues = $service['fieldValues'];

                        $measurementValue = false;
                        $unitValue = false;
                        ?>
                        <div class="clearfix relative all_service_box table_<?= $service_details->getServiceId(); ?>" id="">

                            <div class="row" style="padding-bottom:10px">
                                
                                <p style="font-size:18px;font-weight:bold;"><?= $service_details->getServiceName(); ?></p>

                               

                                <div>
                                    <?php
                                    if (count($serviceSortedItems) > 0 || count($subContractorItem) > 0) {
                                        ?>
                                        <table id="estimateSummaryItems" class=""
                                               style="width: 100%;text-align: right;">
                                            <thead>
                                            <tr>
                                            <th width="16%" style="text-align: left;">Category</th>
                                            
                                            <th width="8%" style="text-align:right;">Estimate Cost</th>
                                            <th width="8%" style="text-align:right;">Actual Cost</th>
                                            <th width="8%" style="text-align:right;">Difference %</th>
                                            <th width="8%" style="text-align:right;">Difference $</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                             $est_qty_total = 0;
                                             $act_qty_total = 0;
                                             $est_cost_total = 0;
                                             $act_cost_total = 0;
                                             $diff_total = 0;

                                            foreach ($serviceSortedItems as $tsortedItem) { ?>
                                                <?php $rowTotal = 0;
                                               $prefix ='';
                                               $color_class = 'tr_row_green'; 
                                               if($tsortedItem['difference_total']<0){
                                                   $prefix ='-';
                                               }else if($tsortedItem['difference_total']>0)
                                               {
                                                   $prefix ='+';
                                                   $color_class = 'tr_row_red';
                                               }
                                               
                                              
                                               $ratio = ($tsortedItem['estimated_total']>0) ? ($tsortedItem['actual_total'] / $tsortedItem['estimated_total']) : 0;
                                               $percent = 0;
                                               if($ratio==0){
                                                   $percent = 0;
                                                   $percent_prefix = '';
                                                   
                                               }else if($ratio<1){
                                                   $percent = ($ratio-1) * 100;
                                                   $percent_prefix = '';
                                                   
                                               } else{
                                                   $percent_prefix = '+';
                                                   $percent = ($ratio-1) * 100;
                                               }
       
                                               $est_qty_total = $est_qty_total + $tsortedItem['estimated_qty_total'];
                                               $act_qty_total = $act_qty_total + $tsortedItem['actual_qty_total'];
                                               $est_cost_total = $est_cost_total + $tsortedItem['estimated_total'];
                                               $act_cost_total = $act_cost_total + $tsortedItem['actual_total'];
                                               $diff_total = $diff_total + $tsortedItem['difference_total'];
                                           ?>
                                          
                                           <tr  class="<?=$color_class;?>">
                                               <td style="text-align: left;"><?php echo $tsortedItem['category_name']; ?></td>
                                               <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($tsortedItem['estimated_qty_total'], 2)); ?></td>
                                               <td style="text-align: right;">
                                                   <?php echo str_replace('.00', '', number_format($tsortedItem['actual_qty_total'], 2, '.', ',')); ?></td> -->
                                               <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($tsortedItem['estimated_total'], 2, '.', ',')); ?>
                                               </td>
                                               <td style="text-align: right;">
                                                   $<?php echo str_replace('.00', '', number_format($tsortedItem['actual_total'], 2, '.', ',')); ?> </td>
                                               <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                               <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($tsortedItem['difference_total']), 2, '.', ','));  ?>
                                               </td>
                                            </tr>
       
                                            <?php }
                                            foreach ($subContractorItem as $tsortedItem) { 
                                                 $rowTotal = 0;
                                               $prefix ='';
                                               $color_class = 'tr_row_green'; 
                                               if($tsortedItem['difference_total']<0){
                                                   $prefix ='-';
                                               }else if($tsortedItem['difference_total']>0)
                                               {
                                                   $prefix ='+';
                                                   $color_class = 'tr_row_red';
                                               }
                                               
                                              
                                               $ratio = ($tsortedItem['estimated_total']>0) ? ($tsortedItem['actual_total'] / $tsortedItem['estimated_total']) : 0;
                                               $percent = 0;
                                               if($ratio==0){
                                                   $percent = 0;
                                                   $percent_prefix = '';
                                                   
                                               }else if($ratio<1){
                                                   $percent = ($ratio-1) * 100;
                                                   $percent_prefix = '';
                                                   
                                               } else{
                                                   $percent_prefix = '+';
                                                   $percent = ($ratio-1) * 100;
                                               }
       
                                               $est_qty_total = $est_qty_total + $tsortedItem['estimated_qty_total'];
                                               $act_qty_total = $act_qty_total + $tsortedItem['actual_qty_total'];
                                               $est_cost_total = $est_cost_total + $tsortedItem['estimated_total'];
                                               $act_cost_total = $act_cost_total + $tsortedItem['actual_total'];
                                               $diff_total = $diff_total + $tsortedItem['difference_total'];
                                           ?>
                                          
                                           <tr  class="<?=$color_class;?>">
                                               <td style="text-align: left;">Sub Contractors</td>
                                               <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($tsortedItem['estimated_qty_total'], 2)); ?></td>
                                               <td style="text-align: right;">
                                                   <?php echo str_replace('.00', '', number_format($tsortedItem['actual_qty_total'], 2, '.', ',')); ?></td> -->
                                               <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($tsortedItem['estimated_total'], 2, '.', ',')); ?>
                                               </td>
                                               <td style="text-align: right;">
                                                   $<?php echo str_replace('.00', '', number_format($tsortedItem['actual_total'], 2, '.', ',')); ?> </td>
                                               <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                               <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($tsortedItem['difference_total']), 2, '.', ','));  ?>
                                               </td>
                                            </tr>
                                            <?php }

                                            
                                $prefix ='';
                                $color_class = 'tr_row_green'; 
                                     if($diff_total<0){
                                         $prefix ='-';
                                     }else if($diff_total>0)
                                     {
                                         $prefix ='+';
                                         $color_class = 'tr_row_red';
                                     }
                                     $ratio = ($est_cost_total>0) ? ($act_cost_total / $est_cost_total) : 0;
                                     $percent = 0;
                                     if($ratio==0){
                                         $percent = 0;
                                         $percent_prefix = '';
                                         
                                     }else if($ratio<1){
                                         $percent = ($ratio-1) * 100;
                                         $percent_prefix = '';
                                         
                                     }else{
                                         $percent_prefix = '+';
                                         $percent = ($ratio-1) * 100;
                                     }
                             ?>

                             <tr style="font-weight:bold" class="<?= $color_class ;?>">
                                 <td style="text-align: left;">Total</td>
                                 <!-- <td style="text-align: right;"><?php echo str_replace('.00', '', number_format($est_qty_total, 2)); ?></td>
                                 <td style="text-align: right;">
                                     <?php echo str_replace('.00', '', number_format($act_qty_total, 2, '.', ',')); ?></td> -->
                                 <td style="text-align: right;padding-right:15px">$<?php echo str_replace('.00', '', number_format($est_cost_total, 2, '.', ',')); ?>
                                     
                                 </td>
                                 <td style="text-align: right;">
                                     $<?php echo str_replace('.00', '', number_format($act_cost_total, 2, '.', ',')); ?> </td>
                                     <td style="text-align:right;"><?php echo $percent_prefix.str_replace('.00', '', number_format($percent, 2, '.', ','));  ?>%</td>
                                 <td style="text-align: right;padding-right:15px"><?php echo $prefix.'$'. str_replace('.00', '', number_format(abs($diff_total), 2, '.', ','));  ?>
                                     
                                 </td>
                                 

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

                <div id="tabs-4">
                    <div class="row" style="margin-bottom:0px">
                       
                        <div class="col s8" >
                        <table class="stripping-row proposal_final_total_table" style="">
                        <tr><th style="text-align: left;font-weight:bold;"></th><th class="">Actual</th><th class=""> Estimate</th><th class="">Difference</th></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Gross Profit:</td><td class=""><?= ($breakdown['gross_profit']<0) ? '-' : '';?> $<?= str_replace('.00', '', number_format(abs($breakdown['gross_profit']), 2, '.', ','));?></td><td class=""><?= ($breakdown['estimate_gross_profit']<0) ? '-' : '';?> $<?= str_replace('.00', '', number_format(abs($breakdown['estimate_gross_profit']), 2, '.', ','));?></td><td class=""><?= ($breakdown['gross_profit_diff']<0) ? '-' : '';?> $<?= str_replace('.00', '', number_format(abs($breakdown['gross_profit_diff']), 2, '.', ','));?></td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Profit Margin %:</td><td class=""><?=str_replace('.00', '', number_format($breakdown['profit_margin'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['estimate_profit_margin'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['profit_margin_diff'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Overhead %:</td><td class=""><?=str_replace('.00', '', number_format($breakdown['overhead_percent'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['estimate_overhead_percent'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['overhead_percent_diff'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Overhead:</td><td class=""><?= ($breakdown['overhead_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['overhead_price']), 2, '.', ','));?></td><td class=""><?= ($breakdown['estimate_overhead_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['estimate_overhead_price']), 2, '.', ','));?></td><td class=""><?= ($breakdown['overhead_price_diff']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['overhead_price_diff']), 2, '.', ','));?></td></tr>
                            <!-- <tr><td style="text-align: left;font-weight:bold;">Total Tax %:</td><td class=""><?=str_replace('.00', '', number_format($breakdown['tax_percent'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['estimate_tax_percent'], 2, '.', ','));?>%</td><td class=""><?=str_replace('.00', '', number_format($breakdown['tax_percent_diff'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Tax:</td><td class=""><?= ($breakdown['tax_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['tax_price']), 2, '.', ','));?></td><td class=""><?= ($breakdown['estimate_tax_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['estimate_tax_price']), 2, '.', ','));?></td><td class=""><?= ($breakdown['tax_price_diff']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['tax_price_diff']), 2, '.', ','));?></td></tr> -->
                        </table>
                        </div>
                        <div class="col s4" >
                            <div id="piechartParent" style="width: 58%;margin: 0px auto;">
                                <div id="piechart" style="display: inline-block;margin: 0 auto;">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php if($image_count>0){?>
                <div id="tabs-6">
                
                <!-- <div class="row"  style="margin-bottom:0px"> -->
                        

                            <?php

                              $no_images = true;
                              $i=1;  
                              $open=false;
                              
                            foreach ($sortedItems as $newsortedItem) : 
                                
                                if(isset($newsortedItem['items'])){
                                    $j=0;
                                    $total_item = count($newsortedItem['items']); 
                                    foreach ($newsortedItem['items'] as $lineItem) : 
                                       
                                        $j++;
                                                if(count($lineItem->files)>0){
                                                   
                                                    if (fmod($i,2)){
                                                        $open=true;
                                                       
                                                        echo '<div class="row"  style="margin-bottom:0px">';}
                                                    echo '<div class="col s6">';
                                                    $no_images =false;
                                                    if ($newsortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                                        echo '<p style="font-size:15px;font-weight:bold;"><span >'.$lineItem->getCustomName().'</span><span style="float:right">'. trimmedQuantity($lineItem->act_qty) .' '. $lineItem->getItem()->getUnitModel()->getAbbr() .'</p>';
                                                    } else {
                                                        echo '<p style="font-size:15px;font-weight:bold;"><span>'.$lineItem->getItem()->getName().'</span><span style="float:right">'. trimmedQuantity($lineItem->act_qty) .' '. $lineItem->getItem()->getUnitModel()->getAbbr() .'</p>';
                                                    }
                                                ?>
                                                <div class="row container-fluid" style="border:1px solid #ccc;border-radius:3px">
                                                
                                                <?php
                                                
                                                    foreach($lineItem->files as $file){

                                                        ?>
                                                    <div class="col s6" style="padding:5px;">
                                                   
                                                    <a class="example-image-link " href="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" data-lightbox="example-1"><img class="example-image card img-responsive responsive-img" src="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" alt="image-1" /></a>                
                                                </div>
                                                    <?php
                                                    }
                                                    ?> </div>
                                                    </div>
                                                    <?php
                                                   if (!fmod($i,2) ){
                                                    $open=false; 
                                                    
                                                    echo '</div>';}
                                                   $i++;
                                                    
                                                }
                                                // else{
                                                //     echo '<p style="text-align: center;font-size: 15px;font-weight: bold;">No Images</p>';   
                                                // }
                                                
                                                
                                                    ?>
                                                
                                        
                                           
                                                        
                                                    <?php endforeach; ?>
                                                    
                                    

                            <?php 
                                }
                             
                           
                            $j=0;
                            $total_item = count($newsortedItem['job_cost_items']);
                             foreach ($newsortedItem['job_cost_items'] as $jobCostItem) : 
                                $j++;
                                if(count($jobCostItem->files)>0){
                                    if (fmod($i,2) && $open==false){
                                        $open=true;
                                        
                                        echo '<div class="row"  style="margin-bottom:0px">';}
                                    echo '<div class="col s6">';
                                    $no_images =false;
                                   echo '<p style="font-size:15px;font-weight:bold;">'.$jobCostItem->getCustomItemName().'</p>';
                                   ?>

                            <div class="row container-fluid"   style="border:1px solid #ccc;border-radius:3px">
                            
                            <?php
                            
                                foreach($jobCostItem->files as $file){
                                    ?>
                                <div class="col s6" style="padding:5px;">
                                
                                <a class="example-image-link " href="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" data-lightbox="example-1 card img-responsive"><img class="example-image card responsive-img" src="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" alt="image" /></a>        
                            
                            </div>
                                <?php
                                }
                               ?>
                               </div>
                               </div>
                               <?php 
                                if (!fmod($i,2)){
                                    $open=false;   
                                   
                                    echo '</div>';}
                                $i++;
                            }
                           
                                ?>
                                
                     
                        
                                    
                                <?php endforeach; 
                                
                            endforeach;
                            
                                if($open){
                                    $open =false;
                                    echo '</div>';}
                                $i=1;
                                $open =false;
                            foreach ($subContractorItems as $subContractorItem) :
                                $rowTotal = 0; 
                                 foreach ($subContractorItem['items'] as $lineItem) :
                                if(count($lineItem->job_cost_files)>0){
                                    if (fmod($i,2)){ $open =true;echo '<div class="row"  style="margin-bottom:0px">';}
                                    echo '<div class="col s6">';
                                    $no_images =false;
                                    
                                    if ($lineItem->getIsCustomSub() == 1) {
                                        echo '<p style="font-size:15px;font-weight:bold;"><span >'.$lineItem->getCustomName().'</span><span style="float:right">'. trimmedQuantity($lineItem->act_qty) .' '. $lineItem->getItem()->getUnitModel()->getAbbr() .'</p>';
                                    } else {
                                        echo '<p style="font-size:15px;font-weight:bold;"><span>'.$lineItem->getSubContractor()->getCompanyName().'</span><span style="float:right">'. trimmedQuantity($lineItem->act_qty) .' '. $lineItem->getItem()->getUnitModel()->getAbbr() .'</p>';
                                    }
                                ?>
                                <div class="row container-fluid" style="border:1px solid #ccc;border-radius:3px">
                                
                                <?php
                                
                                    foreach($lineItem->job_cost_files as $file){

                                        ?>
                                    <div class="col s6" style="padding:5px;">
                                   
                                    <a class="example-image-link " href="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" data-lightbox="example-1"><img class="example-image card img-responsive responsive-img" src="../../uploads/job_costing/<?php echo $proposal->getProposalId(); ?>/<?= $file->getFileName();?>" alt="image-1" /></a>                
                                </div>
                                    <?php
                                    }
                                    ?> </div>
                                    </div>
                                    <?php
                                   if (!fmod($i,2) ){echo '</div>'; $open =false;}
                                   $i++;
                                    
                                }
                            endforeach; 
                                
                        endforeach; 
                       
                        if($open){
                          
                            echo '</div>';}
                            ?>
                            
                             <!-- custom job items list -->
                             
                             <?php
                            
                             if($no_images){
                                                // else{
                                                     echo '<p style="text-align: center;font-size: 15px;font-weight: bold;">No Images</p>';   
                                                 }
                             

                            
                            // foreach ($subContractorItems as $subContractorItem) :
                            //     $rowTotal = 0; 
                              
                            //          foreach ($subContractorItem['items'] as $lineItem) : 
                                       
                                             
                            //                     if ($lineItem->getIsCustomSub() == 1) {
                            //                         echo $lineItem->getCustomName();
                            //                     } else {
                            //                         echo $lineItem->getSubContractor()->getCompanyName();
                            //                     }
                                               
                                           
                            //         endforeach; 
                            //          endforeach; ?>
                        

                        <!-- </div>      -->
                </div>
                <?php }?>

                <div id="tabs-7">
                    <div class="box-content">
                        <table cellpadding="0" cellspacing="0" border="0" class="dataTables-history-new display">
                            <thead>
                            <tr>
                                <td width="140">Date</td>
                                <td>Timestamp</td>
                                <td>User</td>
                                <td>IP Address</td>
                                <td>Contact</td>
                                <td>Proposal</td>
                                <td>Details</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(count($attachments)>0){?>
                <div id="tabs-8">
                    <div class="col s8" style="width:60%">
                           
                           <ul class="collection with-header attachment_lists">
                               <li class="collection-header" ><p style="font-size:14px;font-weight:bold">Attachment List</p></li>
                               <?php
                                    $i=1;
                                   foreach($attachments as $attachment){
                                       echo '<li class="collection-item"><div><span style="top: 2px;position: relative;">'.$i++.'. <a download  href="'.base_url().'uploads/job_costing/'.$proposal->getProposalId().'/'.$attachment->getFileName().'"  >'.$attachment->getFileName().'</a></span><a download target="_blank" href="'.base_url().'uploads/job_costing/'.$proposal->getProposalId().'/'.$attachment->getFileName().'" class="secondary-content btn blue-btn tiptip" title="Download" ><i class="fa fa-download"></i></a></div></li>';  
                                   }

                               ?>
                               
                           </ul>
                       </div>
                </div>
                <?php }?>
            </div>


        </div>

    </div>

</div>

<?php } else { ?>

    <h4>This estimate contains no items</h4>

<?php } ?>
</div>


<?php $this->load->view('global/footer'); ?>
<script src="<?php echo site_url('static') ?>/js/lightbox.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    $(document).ready(function () {
        <?php $ajaxUrl = 'ajax/job_cost_history/' . $proposal->getProposalId() ?>
        $('.dataTables-history-new').dataTable({
            "aaSorting": [[0, "desc"]],
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url($ajaxUrl); ?>",
            "aoColumns": [
                {iDataSort: 1},
                {bVisible: false},
                null,
                null,
                null,
                null,
                null
            ],
            "bJQueryUI": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lpir>'
        });

    });
    $(function () {
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(get_piechart_data);
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

    function get_piechart_data(){
   
    $.ajax({		
        url: '/ajax/getJobCostReportPieChartData/<?php echo $proposal->getProposalId(); ?>',		
        type: 'get',			
        success: function( data){
            var test_array =[['title','List'] ];	
            data = JSON.parse(data);
            if(data.length>0){
                $('#piechart').show();
                for($i=0;$i<data.length;$i++){
                
                    test_array.push([data[$i]['name'],parseFloat(data[$i]['value']) ]);
                }
            
                drawChart(test_array);
            }else{
                $('#piechart').hide();
            }
            
        }   
    });
}

function drawChart(chart_data) {

var data = google.visualization.arrayToDataTable(chart_data);

    var options = {
                width: 200,
                height: 200,
                chartArea: {
                    width: '100%',
                    height: '90%'
                },
                sliceVisibilityThreshold: 0,
                pieSliceText: 'none',
                pieHole: 0.3,
                legend: {
                    position: 'none',
                    maxLines: 2,
                    alignment: 'left'
                },
                pieSliceText: 'label',
                animation: {
                    startup: true
                }
            };
var formatter = new google.visualization.NumberFormat(
                {prefix: '$', pattern: '#,###,###'});
            formatter.format(data, 1);
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    
}
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