
<div id="estimate_items">
<?php
// Estimation Stuff
/* @var $estimationRepository \Pms\Repositories\EstimationRepository */
 $lineItemCount = $estimationRepository->proposalHasEstimateItems($proposal);

//if ($lineItemCount>0 && ($proposal->getEstimateStatusId()==4 || $proposal->getEstimateStatusId()==5)) {
if ($lineItemCount>0) {
//if ($lineItemCount) {

    if($i!=1){?>
            <div style="page-break-after: always"></div>
    <?php }?>
    <h2 style="text-align: center">Estimate Item Breakdown </h2>
    <?php
    $settings = $estimationRepository->getCompanySettings($proposal->getClient()->getCompany());
    $work_order_layout_type = $proposal->getWorkOrderLayoutType();
    $templateGroup = ($proposal->getGroupTemplateItem()==1)? true : false;
   
    
   if($work_order_layout_type != 'all_items'){

    $proposalServices = $proposal->getServices();
    $items='';
    $j=0;
            foreach ($proposalServices as $service) {

                $service_id = $service->getServiceId();

                $phases = $estimationRepository->getProposalServicePhaseArray($service,$proposal->getProposalId());
                
                $i =0;
                $items=[];
                
                if($work_order_layout_type == 'service_and_phase'){
                    foreach($phases as $phase){
                        $phaseId = $phase['id'];
                        
                        if($templateGroup){
                            $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsPhaseNonTemplate($proposal->getClient()->getCompany(),$service_id, $phaseId);
                            $templateItems = $estimationRepository->getTemplatePhaseSortedLineItems($phaseId);
                        }else{
                            $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsPhase($proposal->getClient()->getCompany(),$service_id, $phaseId);
                            $templateItems = [];
                        }
                        $items[$i]= [
                            'proposalService' => $service,
                            'phase' => $phase,
                            'subContractorItems' =>  $estimationRepository->getSubContractorPhaseSortedLineItems($phaseId),
                            'feesItems' =>  $estimationRepository->getFeesPhaseSortedLineItems($phaseId),
                            'permitItems' =>  $estimationRepository->getPermitPhaseSortedLineItems($phaseId),
                            'sortedItems' =>   $sortedItems,
                            'templateItems' => $templateItems,
                            'disposalItems' => $estimationRepository->getDisposalPhaseSortedLineItems($phaseId),
                        ];
                        $i++;
                    }

                }else{

                
                    if($templateGroup){
                        
                        $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsNonTemplate($proposal->getClient()->getCompany(),$service_id);
                        $templateItems = $estimationRepository->getTemplateSortedLineItems($service_id);
                    }else{
                        $sortedItems =  $estimationRepository->getProposalServiceSortedLineItems($proposal->getClient()->getCompany(),$service_id);
                        $templateItems = [];
                    }

                    $items[$i]= [
                        'proposalService' => $service,
                        'phase' => '',
                        'subContractorItems' =>  $estimationRepository->getSubContractorPhaseSortedLineItems($service_id),
                        'feesItems' =>  $estimationRepository->getFeesServiceSortedLineItems($service_id),
                        'permitItems' =>  $estimationRepository->getPermitServiceSortedLineItems($service_id),
                        'sortedItems' =>   $sortedItems,
                        'templateItems' => $templateItems,
                        'disposalItems' => $estimationRepository->getDisposalServiceSortedLineItems($service_id),
                    ];

                }
            // echo '<pre>';
            // print_r($items);
            //}
                    
        

            foreach ($items as $item) : 
                //print_r($item['sortedItems']);
                $sortedItems =  $item['sortedItems'];
                $subContractorItems =  $item['subContractorItems'];
                $templateItems =  $item['templateItems'];
                $feesItems =  $item['feesItems'];
                $permitItems =  $item['permitItems'];
                $disposalItems =  $item['disposalItems'];
            if(count($sortedItems)>0 || count($subContractorItems)>0 || count($templateItems)>0){

            
            ?>       
        
        
        <div class="clearfix relative <?= $j;?>" <?php if($j!=0){echo 'style="page-break-before:always"'; }
        $j++;
        ?> >
            
            <p style="margin:0px;font-size:16px;font-weight:bold"><?php echo $service->getServiceName(); if($work_order_layout_type == 'service_and_phase'){echo ' | '. $item['phase']['name'];}?> </p>
        <hr style="color:#2c2c2c;border-top:1px;margin-top:4px;margin-bottom:0px;"/>

            <?php 


            foreach ($sortedItems as $sortedItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;"><?php echo $sortedItem['category']->getName(); ?></h4>
                <table id="estimateSummaryItems" class="" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        <th width="2%" ></th>
                        <th width="20%" >Type</th>
                            <th width="30%">Item</th>
                            <?php if($sortedItem['category']->getId() !=1){ ?>
                                <th width="5%">Days</th>
                                <th width="5%">#</th>
                                
                                <th width="5%">Hrs/Day</th>
                            <?php } else{ ?>
                                <th width="12%">Area</th>
                                <th width="7%">Depth</th>
                                <th width="1%"></th>
                            <?php } ?>
                            <th width="10%" style="text-align:right;">Quantity</th>
                            <th width="7%" ></th>
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ 
                        
                        $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                        ?>
                        <tr>
                        <td><div class="checkbox_div"></div></td>
                        <td><?php 
                                $saved_values = $lineItem->saved_values;
                                $check_type = $lineItem->item_type_time;
                                echo $lineItem->getItemType()->getName(); 
                                $notes1 ='';
                                
                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/><strong>Note: </strong>';
                                    echo $notes1;
                                }
                                
                                ?></td>
                            <td>
                            <?php
                                if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM || $lineItem->getItemId() == '71') {
                                    echo $lineItem->getCustomName();
                                } else {
                                    echo $lineItem->getItem()->getName();
                                }

                                if($lineItem->item_type_trucking ==1){
                                    echo $lineItem->plant_dump_address;
                                }
                                $notes1 ='';
                        
                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/>'.$lineItem->getNotes();
                                    echo $notes1;
                                }
                            ?>
                            </td>
                            <?php 
                                    if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){
                                        if($check_type){
                                            
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                        }else{
                                            echo '<td></td><td></td><td></td>';
                                        }

                                    }else {
                                        if ($saved_values) {
                                            $saved_values = json_decode($saved_values);
                                            $measurement = '';
                                            $unit = '';
                                            $depth = '';
                                            for ($i = 0; $i < count($saved_values); $i++) {
                                                if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                                                    $measurement=$saved_values[$i]->value;
                                                }else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                    if($saved_values[$i]->value=='Square Yards'){
                                                        $unit = 'Sq. Yd';
                                                    }else{
                                                        $unit = 'Sq. Ft';
                                                    }
                                                }else if ($saved_values[$i]->name == 'depth' ) {
                                                    $depth = $saved_values[$i]->value.' Inch';
                                                }
                                            }
                                            echo '<td>'.$measurement.' '.$unit.'</td><td>'.$depth.'</td><td></td>';
                                        } else {
                                            $saved_values = [];
                                            echo '<td></td><td></td><td></td>';
                                        }
                                    }
                                    ?>
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                </td>
                                
                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                            <td style="padding-top: 2px;"><div class="input_div"></div></td>
                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); 
                        
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                    
                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach; 

        foreach ($templateItems as $key=>$templateSortedItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Assembly - <?=$templateSortedItem['template_name'];?></h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="2%" ></th>
                    <th width="10%" >Category</th>
                    <th width="20%" >Type</th>
                        <th width="20%">Item</th>
                        
                            <th width="5%">Days</th>
                            <th width="5%">#</th>
                            
                            <th width="5%">Hrs/Day</th>
                        
                        <th width="10%" style="text-align:right;">Quantity</th>
                        <th width="7%" ></th>
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><div class="checkbox_div"></div></td>
                    <td><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                    <td><?php 
                            
                            echo $lineItem->getItemType()->getName(); 
                            $notes1 ='';
                            
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/><strong>Note: </strong>';
                                echo $notes1;
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getItem()->getName();
                            

                            
                            $notes1 ='';
                    
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/>'.$lineItem->getNotes();
                                echo $notes1;
                            }
                        ?>
                        </td>
                        <?php 
                                
                                
                                        
                                        echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                    
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                            </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                        <td style="padding-top: 2px;"><div class="input_div"></div></td>
                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach; 

            foreach ($subContractorItems as $subContractorItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;">Sub Contractors</h4>
                <table id="estimateSummaryItems" class="" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        
                        <th width="35%">Item</th>
                        <th width="15%" style="text-align:right;">Quantity</th>
                            
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                        <tr>
                            
                            <td>
                            <?php
                            if($lineItem->getIsCustomSub()==1){
                                echo $lineItem->getCustomName();
                            }else{
                                echo $lineItem->getSubContractor()->getCompanyName();
                            }
                                
                            ?>
                            </td>
                            
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    QTY
                                </span>
                            </td>
                                
                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                    <?php endforeach; ?>
                    </tbody>
                    
                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach; 
            
            foreach ($feesItems as $feesItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Fees</h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>
                        
                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>
                        
                        <th width="15%" style="text-align:right;">Quantity</th>
                        
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($feesItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php 
                            
                            echo 'Fees';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }
                                
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php 
                                
                                    echo '<td></td><td></td><td></td>';
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>  
                        </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
        foreach ($permitItems as $permitItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Permit</h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>
                        
                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>
                        
                        <th width="15%" style="text-align:right;">Quantity</th>
                        
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permitItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php 
                            
                            echo 'Permit';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }
                                
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php 
                                
                                    echo '<td></td><td></td><td></td>';
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span> 
                            </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
                foreach ($disposalItems as $disposalItem) : ?>
                    <?php $rowTotal = 0; ?>
                <div class="row">
        
                    <div class="col s12" style="page-break-inside:avoid">
                    <h4 style="margin-bottom:2px;margin-top:6px;">Disposal Load</h4>
                    <table id="estimateSummaryItems" class="" style="width: 100%;">
                        <thead>
                        <tr>
                            <!-- <th width="30%">Type</th>
                            <th width="50%">Item</th>
                            <th width="20%">Quantity</th> -->
                            <th width="20%" >Type</th>
                                <th width="35%">Item</th>
                                
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                
                                <th width="7%" ></th>
                                
                            <!-- <th>Total Price</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($disposalItem['items'] as $disposallineItem) : ?>
                            
                            <tr>
                            <td>Disposal</td>
                                <td>
                                <?php echo $disposallineItem->getItem()->getName();?>
                                </td>
                                <?php 
                                        
                                            echo '<td></td><td></td>';
                                        
                                        ?>
                                <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($disposallineItem->getDisposalLoads()); ?>
                                    </span> 
                                    </td>
                                    <td style="padding-top: 2px;"><div class="input_div"></div></td>    
                                <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
        
                            </tr>
                           
                        <?php endforeach; ?>
                        </tbody>
                        
                    </table>
                    <div class="divider"></div>
                    </div>
        
                </div>
                <?php endforeach;?>
        </div>
        <?php 

                        }
        endforeach; 
        }
    }else{

        $i =0;
        $j =0;
        $items=[];
        //$templateGroup =false;
        if($templateGroup){
            $sortedItems =  $estimationRepository->getProposalSortedLineItemsNonTemplate($proposal->getClient()->getCompany(),$proposal->getProposalId());
            $templateItems = $estimationRepository->getProposalTemplateSortedLineItems($proposal->getProposalId());
        }else{
            $sortedItems =  $estimationRepository->getProposalSortedLineItemsTotal($proposal->getClient()->getCompany(), $proposal->getProposalId());
            $templateItems = [];
        }
        $subContractorItems = $estimationRepository->getSubContractorProposalSortedLineItems($proposal->getProposalId());
        $feesItems = $estimationRepository->getFeesProposalSortedLineItems($proposal->getProposalId());
        $permitItems =  $estimationRepository->getPermitProposalSortedLineItems($proposal->getProposalId());
        $disposalItems =  $estimationRepository->getDisposalProposalSortedLineItems($proposal->getProposalId());;
        

        if(count($sortedItems)>0 || count($subContractorItems)>0 || count($templateItems)>0){

            
            ?>       
        
        
        <div class="clearfix relative <?= $j;?>" <?php if($j!=0){echo 'style="page-break-before:always"'; }
        $j++;
        ?> >
        <hr style="color:#2c2c2c;border-top:1px;margin-top:4px;margin-bottom:0px;"/>

            <?php 


            foreach ($sortedItems as $sortedItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;"><?php echo $sortedItem['category']->getName(); ?></h4>
                <table id="estimateSummaryItems" class="" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        <th width="2%" ></th>
                        <th width="20%" >Type</th>
                            <th width="30%">Item</th>
                            <?php if($sortedItem['category']->getId() !=1){ ?>
                                <th width="5%">Days</th>
                                <th width="5%">#</th>
                                
                                <th width="5%">Hrs/Day</th>
                            <?php } else{ ?>
                                <th width="12%">Area</th>
                                <th width="7%">Depth</th>
                                <th width="1%"></th>
                            <?php } ?>
                            <th width="10%" style="text-align:right;">Quantity</th>
                            <th width="7%" ></th>
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ 
                        
                        $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                        ?>
                        <tr>
                        <td><div class="checkbox_div"></div></td>
                        <td><?php 
                                $saved_values = $lineItem->saved_values;
                                $check_type = $lineItem->item_type_time;
                                echo $lineItem->getItemType()->getName(); 
                                $notes1 ='';
                                
                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/><strong>Note: </strong>';
                                    echo $notes1;
                                }
                                
                                ?></td>
                            <td>
                            <?php
                                if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM || $lineItem->getItemId() == '71') {
                                    echo $lineItem->getCustomName();
                                } else {
                                    echo $lineItem->getItem()->getName();
                                }

                                if($lineItem->item_type_trucking ==1){
                                    echo $lineItem->plant_dump_address;
                                }
                                $notes1 ='';
                        
                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/>'.$lineItem->getNotes();
                                    echo $notes1;
                                }
                            ?>
                            </td>
                            <?php 
                                    if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){
                                        if($check_type){
                                            
                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                        }else{
                                            echo '<td></td><td></td><td></td>';
                                        }

                                    }else {
                                        if ($saved_values) {
                                            $saved_values = json_decode($saved_values);
                                            $measurement = '';
                                            $unit = '';
                                            $depth = '';
                                            for ($i = 0; $i < count($saved_values); $i++) {
                                                if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                                                    $measurement=$saved_values[$i]->value;
                                                }else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                    if($saved_values[$i]->value=='Square Yards'){
                                                        $unit = 'Sq. Yd';
                                                    }else{
                                                        $unit = 'Sq. Ft';
                                                    }
                                                }else if ($saved_values[$i]->name == 'depth' ) {
                                                    $depth = $saved_values[$i]->value.' Inch';
                                                }
                                            }
                                            echo '<td>'.$measurement.' '.$unit.'</td><td>'.$depth.'</td><td></td>';
                                        } else {
                                            $saved_values = [];
                                            echo '<td></td><td></td><td></td>';
                                        }
                                    }
                                    ?>
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                </td>
                                
                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                            <td style="padding-top: 2px;"><div class="input_div"></div></td>
                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); 
                        
                        ?>
                    <?php endforeach; ?>
                    </tbody>
                    
                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach; 

        foreach ($templateItems as $key=>$templateSortedItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Assembly - <?=$templateSortedItem['template_name'];?></h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="2%" ></th>
                    <th width="10%" >Category</th>
                    <th width="20%" >Type</th>
                        <th width="20%">Item</th>
                        
                            <th width="5%">Days</th>
                            <th width="5%">#</th>
                            
                            <th width="5%">Hrs/Day</th>
                        
                        <th width="10%" style="text-align:right;">Quantity</th>
                        <th width="7%" ></th>
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><div class="checkbox_div"></div></td>
                    <td><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                    <td><?php 
                            
                            echo $lineItem->getItemType()->getName(); 
                            $notes1 ='';
                            
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/><strong>Note: </strong>';
                                echo $notes1;
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getItem()->getName();
                            

                            
                            $notes1 ='';
                    
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/>'.$lineItem->getNotes();
                                echo $notes1;
                            }
                        ?>
                        </td>
                        <?php 
                                
                                
                                        
                                        echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                    
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                            </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                        <td style="padding-top: 2px;"><div class="input_div"></div></td>
                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach; 

            foreach ($subContractorItems as $subContractorItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;">Sub Contractors</h4>
                <table id="estimateSummaryItems" class="" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        
                        <th width="35%">Item</th>
                        <th width="15%" style="text-align:right;">Quantity</th>
                            
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                        <tr>
                            
                            <td>
                            <?php
                                echo $lineItem->getSubContractor()->getCompanyName();
                            ?>
                            </td>
                            
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    QTY
                                </span>
                            </td>
                                
                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                    <?php endforeach; ?>
                    </tbody>
                    
                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach; 
            
            foreach ($feesItems as $feesItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Fees</h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>
                        
                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>
                        
                        <th width="15%" style="text-align:right;">Quantity</th>
                        
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($feesItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php 
                            
                            echo 'Fees';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }
                                
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php 
                                
                                    echo '<td></td><td></td><td></td>';
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>  
                        </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
        foreach ($permitItems as $permitItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Permit</h4>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>
                        
                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>
                        
                        <th width="15%" style="text-align:right;">Quantity</th>
                        
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permitItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ 
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php 
                            
                            echo 'Permit';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }
                                
                            }
                            
                            ?></td>
                        <td>
                        <?php
                            
                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php 
                                
                                    echo '<td></td><td></td><td></td>';
                                
                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span> 
                            </td>
                            
                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>
                
            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
                foreach ($disposalItems as $disposalItem) : ?>
                    <?php $rowTotal = 0; ?>
                <div class="row">
        
                    <div class="col s12" style="page-break-inside:avoid">
                    <h4 style="margin-bottom:2px;margin-top:6px;">Disposal Load</h4>
                    <table id="estimateSummaryItems" class="" style="width: 100%;">
                        <thead>
                        <tr>
                            <!-- <th width="30%">Type</th>
                            <th width="50%">Item</th>
                            <th width="20%">Quantity</th> -->
                            <th width="20%" >Type</th>
                                <th width="35%">Item</th>
                                
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                    <th width="10%" style="text-align:right;">Quantity</th>
                                
                                <th width="7%" ></th>
                                
                            <!-- <th>Total Price</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($disposalItem['items'] as $disposalLineItem) : ?>
                           
                            <tr>
                            <td>Disposal</td>
                            <td><?php echo $disposalLineItem->getItem()->getName();?>
                                </td>
                                <?php 
                                        
                                            echo '<td></td><td></td>';
                                        
                                        ?>
                                <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getDisposalLoads()); ?>
                                    </span> 
                                    </td>
                                <td style="padding-top: 2px;"><div class="input_div"></div></td>    
                                <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
        
                            </tr>
                         
                        <?php endforeach; ?>
                        </tbody>
                        
                    </table>
                    <div class="divider"></div>
                    </div>
        
                </div>
                <?php endforeach;?>
        </div>
        <?php 

        }

    }

$subContractors = $estimationRepository->getEstimateProposalSubContractors($proposal->getProposalId());
if (count($subContractors)) {?>
 <div style="page-break-after: always"></div>
 <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h2 class="underlined header_fix" style="z-index: 200; margin-bottom: 20px">Sub Contractor Details</h2>
<?php 
    foreach($subContractors as $subContractor){?>
        <h3> <?=$subContractor->getCompanyName();?> </h3>
        <table>
            <tr><th style="text-align:right;">Address:<th><td><?=$subContractor->getAddress().' '.$subContractor->getCity().' '.$subContractor->getState().' '.$subContractor->getZip();?></td></tr>
            <tr><th style="text-align:right;">Website:<th><td><?=$subContractor->getWebsite();?> </td></tr>
            <tr><th style="text-align:right;">Phone:<th><td><?=$subContractor->getPhone();?></td></tr>
        </table>
        <!-- <p style="padding:2px; margin:2px;"><strong>Address: </strong><?=$subContractor->getAddress().' '.$subContractor->getCity().' '.$subContractor->getState().' '.$subContractor->getZip();?> </p>

        <p style="padding:2px; margin:2px;"><strong>Website: </strong><?=$subContractor->getWebsite();?> </p>
        <p style="padding:2px; margin:2px;"><strong>Phone: </strong><?=$subContractor->getPhone();?> </p> -->

    <?php }

} 
// Estimate Notes
$estimateNotes = $estimationRepository->getEstimateNotes($proposal->getProposalId());
if (count($estimateNotes)) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->

    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h2 class="underlined header_fix" style="z-index: 200; margin-bottom: 20px">Estimate Notes</h2>

    <table width="100%" style="border-collapse: collapse;"">
        <thead style="border-bottom: 1px solid #000; ">
            <tr style="padding: 3px;">
                <th width="10%" style="text-align: left;">Date</th>
                <th width="10%" style="text-align: left;">Time</th>
                <th width="60%" style="text-align: left;">Note</th>
                <th width="20%" style="text-align: left;">User</th>
            </tr>
        </thead>
        <tbody>
<?php
        $row = 1;
        foreach ($estimateNotes as $estimateNote) {

            if($row&1) {
                $rowClass = 'even';
            } else {
                $rowClass = 'odd';
            }

?>
            <tr class="<?php echo $rowClass; ?>">
                <td style="padding: 5px;"><?php echo date('m/d/Y', $estimateNote->getAdded()); ?></td>
                <td style="padding: 5px;"><?php echo date('g:i a', $estimateNote->getAdded()); ?></td>
                <td style="padding: 5px;"><?php echo $estimateNote->getNoteText(); ?></td>
                <td style="padding: 5px;"><?php echo $estimateNote->getUsername(); ?></td>
            </tr>
<?php
            $row++;
        }
?>        
        </tbody>
    </table>
<?php
}
}?>
</div><!--Close estimate_items-->