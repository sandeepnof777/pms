<?php /** @var $proposal \models\Proposals */?>


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
.stripping-row tr:nth-child(even) {
        background-color: #efefef;
}
.stripping-row tr:nth-child(odd) {
        background-color: #fafafa;
}
.card{
  width:100%;
  height:auto;
  margin: 4% auto;
  box-shadow:-3px 5px 15px #000;
  cursor: pointer;
  -webkit-transition: all 0.2s;
  transition: all 0.2s;
}

</style>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">


       <p style="font-size:20px;">Job Cost Report: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?> - <?php echo $proposal->getProjectName(); ?></p>
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
<div class="row" style="margin-bottom:0px;margin-top:30px">
<p style="font-size:15px;font-weight:bold">Totals</p>

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
<hr/>
<div class="row" style="margin-bottom:0px;width:100%;float:left;margin-top:30px">
                   <p style="font-size:15px;font-weight:bold">BreakDown:</p>   
                       <div class="" style="width:100%;float:left;">
                        <table id="estimateSummaryItems" class="stripping-row proposal_final_total_table" style="width:100%">
                            <tr><td style="text-align: left;font-weight:bold;">Gross Profit:</td><td style="text-align:right"><?= ($breakdown['gross_profit']<0) ? '-' : '';?> $<?= str_replace('.00', '', number_format(abs($breakdown['gross_profit']), 2, '.', ','));?></td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Profit Margin %:</td><td style="text-align:right"><?=str_replace('.00', '', number_format($breakdown['profit_margin'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Overhead %:</td><td style="text-align:right"><?=str_replace('.00', '', number_format($breakdown['overhead_percent'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Overhead:</td><td style="text-align:right"><?= ($breakdown['overhead_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['overhead_price']), 2, '.', ','));?></td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Tax %:</td><td style="text-align:right"><?=str_replace('.00', '', number_format($breakdown['tax_percent'], 2, '.', ','));?>%</td></tr>
                            <tr><td style="text-align: left;font-weight:bold;">Total Tax:</td><td style="text-align:right"><?= ($breakdown['tax_price']<0) ? '-' : '';?>$<?=str_replace('.00', '', number_format(abs($breakdown['tax_price']), 2, '.', ','));?></td></tr>
                        </table>
                       </div>
                       <!-- <div class="" style="width:49%;float:left;" >
                           <div id="piechartParent" style="width: 58%;margin: 0px auto;">
                               <div id="piechart" style="display: inline-block;margin: 0 auto;">
                               </div>
                           </div>
                       </div> -->

        </div>
<div  style="width: 100%;float:left;" >
    <div style="float:left;">
       
        <p style="font-size: 15px;"><span style="font-weight:bold">Job Costing Complated :</span><span> <?= date_format(date_create($proposal->getJobCostCompletedAt()),"m/d/Y h:i A");?></span></p>
        <p style="font-size: 15px;"><span style="font-weight:bold">Completed : </span><span><?= $proposal->getJobCostUserName();?></span></p>
        <img class="example-image" width="150px" src="<?= UPLOADPATH.'/job_costing/'. $proposal->getProposalId(); ?>/signature.png" alt="image" />
    </div>
    <div  >
        
        
    </div>                                      
</div>

<div class="row" style="margin-bottom:0px;page-break-after: always;">
<?php

$count_phase = 1;
foreach ($services as $service) :
    $serviceSortedItems = $service['sortedItems'];
    $serviceAllSortedItems = $service['allSortedItems']; 
    //$serviceSortedItems = [];
    $service_details = $service['service_details'];
    $subContractorItem = $service['subContractorItem'];
    $serviceFieldValues = $service['fieldValues'];

    $measurementValue = false;
    $unitValue = false;
    ?>
    <div class="clearfix relative all_service_box table_<?= $service_details->getServiceId(); ?>" style="page-break-before: always;">

        <div class="row" style="padding-bottom:10px;">
            
            <p style="font-size:20px;font-weight:bold;"><?= $service_details->getServiceName(); ?></p>

           
            <p style="font-size:19px;font-weight:bold;">Service Breakdown</p>
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
            <p style="font-size:19px;font-weight:bold;">Service Items</p>
<?php
            foreach ($serviceAllSortedItems as $newsortedItem) : ?>
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
                                                
                                                echo '<table style="width: 100%;padding-bottom:5px;"><tbody><tr><td style="font-size:15px;font-weight:bold;">'.$newsortedItem['category']->getName().'</td><td style="font-size:15px;font-weight:bold;text-align:right">Total: '. $total. '</td></tr></tbody></table>';
                                              
                                            }
                                        }
                                    ?>
                               
                                <table id="estimateSummaryItems" class="" style="width: 100%;">
                                    <thead style="border-bottom: none;">
                                    <tr>
                                        <th width="15%">Type</th>
                                        <th width="17%">Item</th>
                                        <th width="8%" style="text-align:right;">Est QTY</th>
                                        <th width="8%" style="text-align:right;">QTY</th>
                                        <th width="8%" style="text-align:right;">Est Cost</th>
                                        <th width="8%" style="text-align:right;">Cost</th>
                                        <th width="8%" style="text-align:right;">Diff %</th>
                                        <th width="8%" style="text-align:right;">Diff $</th>
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
                                    <?php foreach ($newsortedItem['job_cost_items'] as $jobCostItem) : 
                                                        
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
                                                        
                                                    <?php endforeach; ?>
                                    
                                    </tbody>
                                </table>

                            <?php endforeach; ?>

        </div>

    </div>

<?php endforeach; ?>

</div>


</div>



<div class="row" style="margin-bottom:0px;width:100%;page-break-after: always;">
               <p style="font-size:15px;font-weight:bold">Item Images</p>  
                       
                       <div class="col s12">

                           <?php
    foreach ($services as $service) :
            $serviceAllSortedItems = $service['allSortedItems']; 
            $service_details = $service['service_details'];
            if(count($serviceAllSortedItems)>0){

            
            ?>
            <p style="font-size:18px;font-weight:bold;"><?= $service_details->getServiceName(); ?></p>
                           
            <?php  }     
                    foreach ($serviceAllSortedItems as $newsortedItem) : ?>
                               

                               
                              
                               
                                   <?php 
                                   if(isset($newsortedItem['items'])){
                                        foreach ($newsortedItem['items'] as $lineItem) : 
                                     
                                            if(count($lineItem->files)>0){
                                               if ($newsortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                                     echo '<p style="font-size:15px;font-weight:bold;">Item Name:-'.$lineItem->getCustomName().'</p>';
                                               } else {
                                                   echo '<p style="font-size:15px;font-weight:bold;">Item Name:-'.$lineItem->getItem()->getName().'</p>';
                                               }
                                               ?>
                                               <div class="row container-fluid" style="width:100%;border:1px solid #ccc;float:left;border-radius:3px">
                                               
                                               <?php
                                               
                                                   foreach($lineItem->files as $file){
                                                       ?>
                                                   <div class="col s6" style="width: 49%;margin-left: auto;padding:5px;float:left">
                                                  
                                                   <img class="example-image card img-responsive" src="<?=UPLOADPATH.'/job_costing/'.$proposal->getProposalId(); ?>/<?= $file->getFileName();?>" alt="image-1" />            
                                               </div>
                                                   <?php
                                                   }
                                                   
                                               }
                                                   ?>
                                                   
                                        </div>
                                          
                                                       
                                                   <?php endforeach; }?>
                                                   <?php foreach ($newsortedItem['job_cost_items'] as $jobCostItem) : 

                                                if(count($jobCostItem->files)>0){
                                                      echo '<p style="font-size:15px;font-weight:bold;">Item Name:-'.$jobCostItem->getCustomItemName().'</p>';
                                                      ?>

                                   <div class="row container-fluid"   style="width:100%;border:1px solid #ccc;float:left;border-radius:3px">
                                               
                                               <?php
                                               
                                                   foreach($jobCostItem->files as $file){
                                                       ?>
                                                   <div class="col s6" style="width: 49%;margin-left: auto;padding:5px;float:left">
                                                   
                                                   <img class="example-image card img-responsive" src="<?=UPLOADPATH.'/job_costing/'.$proposal->getProposalId(); ?>/<?= $file->getFileName();?>" alt="image" />      
                                               
                                               </div>
                                                   <?php
                                                   }
                                                   
                                               }
                                                   ?>
                                                   
                                        </div>
                                           
                                                       
                                                   <?php endforeach; ?>
                                   

                           <?php endforeach; 
                           
                        endforeach;?>
                            <!-- custom job items list -->

                            

                           <?php
                           foreach ($subContractorItems as $subContractorItem) :
                               $rowTotal = 0; ?>
                             
                                   <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                                      
                                               <?php
                                               if ($lineItem->getIsCustomSub() == 1) {
                                                   echo $lineItem->getCustomName();
                                               } else {
                                                   echo $lineItem->getSubContractor()->getCompanyName();
                                               }
                                               ?>
                                          
                                   <?php endforeach; ?>

                                   
                           <?php endforeach; ?>
                       </div>

                   </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(get_piechart_data);

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

</script>



<?php 
//die;
//$this->load->view('global/footer'); ?>