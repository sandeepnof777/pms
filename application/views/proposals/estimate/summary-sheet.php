
        <!--<h4>Estimate Item Summary: <?php echo $proposalService->getServiceName(); ?></h4><br />-->

        <div class="clearfix relative" style="max-height: 600px;">
            <div id="phaseCategoryStatuses" style="position:sticky;top:-5px;background-color: #fff;">
                
                <div href="javascript:void(0);" data-val="Material" class="phaseCategoryStatus phasesBtn <?php echo $phase->getMaterial() ? 'hasItems' : ''?>">
                    <span class="phase_checked"><i class="fa fa-fw fa-2x  small <?php echo $phase->getMaterial() ? 'fa-check-circle-o' : 'fa-times-circle'?>" style="position: relative;top: 3px;padding-right: 2px;"></i></span>
                    Material 
                </div>
            
                <div href="javascript:void(0);" data-val="Equipment" class="phaseCategoryStatus phasesBtn <?php echo $phase->getEquipment() ? 'hasItems' : ''?>">
                    <span class="phase_checked"><i class="fa fa-fw fa-2x small <?php echo $phase->getEquipment() ? 'fa-check-circle-o' : 'fa-times-circle'?>"  style="position: relative;top: 3px;padding-right: 2px;"></i></span>
                    Equipment 
                </div>
            
                <div href="javascript:void(0);" data-val="Labor" class="phaseCategoryStatus phasesBtn <?php echo $phase->getLabor() ? 'hasItems' : ''?>">
                    <span class="phase_checked"><i class="fa fa-fw fa-2x small <?php echo $phase->getLabor() ? 'fa-check-circle-o' : 'fa-times-circle'?>" style="position: relative;top: 3px;padding-right: 2px;"></i></span>
                    Labor 
                </div>
            
                <div  data-val="Services" class="phaseCategoryStatus phasesBtn <?php echo $phase->getTrucking() ? 'hasItems' : ''?>" style="border-right:none">
                    <span class="phase_checked"><i class="fa fa-fw fa-2x small <?php echo $phase->getTrucking() ? 'fa-check-circle-o' : 'fa-times-circle'?>" style="position: relative;top: 3px;padding-right: 2px;"></i></span>
                    Trucking 
                </div>
                <div class="clearfix"></div>
                
            </div>
            <div class="row">

                <div class="col s12 phaseCategoryLists ">

                    <?php foreach ($sortedItems as $sortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    <div id="Section_<?php echo $sortedItem['category']->getName(); ?>" class="phaseItemSection">
                        <h4 ><?php echo $sortedItem['category']->getName(); ?></h4>
                        <table id="estimateSummaryItems" class="" style="width: 100%;">
                            <thead>
                            <tr>
                                <th width="15%">Type</th>
                                <th width="27%">Item</th>
                            <?php if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){ ?>
                                <th width="5%">Days</th>
                                <th width="5%">#</th>
                                <th width="5%">Hrs/day</th>
                            <?php }else{?>
                                <th width="5%"></th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            <?php } ?>
                                <th width="26%">Quantity</th>
                                <th width="17%" style="text-align:right">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                <tr>
                                    <td style="text-align: left;"><?php echo $lineItem->getItemType()->getName(); ?></td>
                                    <td style="text-align: left;">
                                    <?php
                                        if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                            echo $lineItem->getCustomName();
                                        } else {
                                            echo $lineItem->getItem()->getName();
                                        }
                                    ?>
                                    </td>
                                    <?php if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){ ?>
                                    <td><?= $lineItem->getDay();?></td>
                                    <td><?= $lineItem->getNumPeople();?></td>
                                    <td><?= $lineItem->getHoursPerDay();?></td>
                                    <?php }else{?>
                                        <td width="5%"></td>
                                        <td width="5%"></td>
                                        <td width="5%"></td>
                                    <?php } ?>
                                    <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                        <?php 
                                        if($lineItem->getItemId() != 0){
                                            echo $lineItem->getItem()->getUnitModel()->getName();
                                        }
                                         ?>
                                    </td>
                                    <td style="text-align:right">$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td>

                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Cost:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($sortedItem['aggregateBaseCost'], 2, '.', ',' ); ?></strong></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Overhead:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $sortedItem['aggregateOverheadRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($sortedItem['aggregateOverheadPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Profit:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $sortedItem['aggregateProfitRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($sortedItem['aggregateProfitPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Total:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($rowTotal, 2, '.', ',' ); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                        <div class="divider"></div>
                    <?php endforeach; 
                    
                    if(count($feesTypeItems)>0){
                        $rowTotal = 0;
                    ?>



<div >
                        <h4 >Fees</h4>
                        <table id="estimateSummaryItems" class="" style="width: 100%;">
                            <thead>
                            <tr>
                                <th width="15%">Type</th>
                                <th width="27%">Item</th>
                                <th width="26%">Quantity</th>
                                <th width="17%" style="text-align:right">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($feesTypeItems[0]['items'] as $lineItem) : ?>
                                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                <tr>
                                    <td style="text-align: left;">Fees</td>
                                    <td style="text-align: left;">
                                    <?php
                                       
                                            echo $lineItem->getCustomName();
                                        
                                    ?>
                                    </td>
                                    
                                    <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                        <?php 
                                        if($lineItem->getItemId() != 0){
                                            echo $lineItem->getItem()->getUnitModel()->getName();
                                        }
                                         ?>
                                    </td>
                                    <td style="text-align:right">$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td>

                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Fees Cost:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($feesTypeItems[0]['aggregateBaseCost'], 2, '.', ',' ); ?></strong></td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Fees Overhead:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $feesTypeItems[0]['aggregateOverheadRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($feesTypeItems[0]['aggregateOverheadPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Fees Profit:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $feesTypeItems[0]['aggregateProfitRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($feesTypeItems[0]['aggregateProfitPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Fees Total:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($rowTotal, 2, '.', ',' ); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                        <div class="divider"></div>

         <?php           
                    }

                    if(count($permitTypeItems)>0){
                        $rowTotal = 0;
                    ?>



<div >
                        <h4 >Permit</h4>
                        <table id="estimateSummaryItems" class="" style="width: 100%;">
                            <thead>
                            <tr>
                                <th width="15%">Type</th>
                                <th width="27%">Item</th>
                                <th width="26%">Quantity</th>
                                <th width="17%" style="text-align:right">Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($permitTypeItems[0]['items'] as $lineItem) : ?>
                                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                                <tr>
                                    <td style="text-align: left;">Permit</td>
                                    <td style="text-align: left;">
                                    <?php
                                       
                                            echo $lineItem->getCustomName();
                                        
                                    ?>
                                    </td>
                                    <td style="text-align:right"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                        <?php 
                                        if($lineItem->getItemId() != 0){
                                            echo $lineItem->getItem()->getUnitModel()->getName();
                                        }
                                         ?>
                                    </td>
                                    <td style="text-align:right">$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td>

                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Permit Cost:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($permitTypeItems[0]['aggregateBaseCost'], 2, '.', ',' ); ?></strong></td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Permit Overhead:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $permitTypeItems[0]['aggregateOverheadRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($permitTypeItems[0]['aggregateOverheadPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Permit Profit:</strong></td>
                                    <td style="text-align:right">
                                    <span style="float:left">(<?php echo $permitTypeItems[0]['aggregateProfitRate']; ?> %)</span>
                                        <strong>$<?php echo number_format($permitTypeItems[0]['aggregateProfitPrice'], 2, '.', ',' ); ?></strong>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right;"><strong>Permit Total:</strong></td>
                                    <td style="text-align:right"><strong>$<?php echo number_format($rowTotal, 2, '.', ',' ); ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                        <div class="divider"></div>

         <?php           
                    }
                    $n=0;
                    foreach ($templateItems as $key=>$templateSortedItem) : ?>
                        <?php $rowTotal = 0; ?>
                    
            
                        <div class="phaseItemSection assembly_section" id="assembly_section_<?=$n;?>" style="page-break-inside:avoid">
                        <h4 style="margin-bottom:2px;margin-top:6px;">Assembly - <?=$templateSortedItem['template_name'];?></h4>
                        <table id="estimateSummaryItems" class="assembly_section_table" style="width: 100%;">
                            <thead>
                            <tr>
                                <!-- <th width="30%">Type</th>
                                <th width="50%">Item</th>
                                <th width="20%">Quantity</th> -->
                                
                                <th width="10%" >Category</th>
                                <th width="20%" >Type</th>
                                    <th width="20%">Item</th>
                                    
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
                                <?php /* @var \models\EstimationLineItem $lineItem */ 
                                $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                                ?>
                                <tr>
                                
                                <td style="text-align: left;" class="phase_section_item_type"><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                                <td style="text-align: left;"><?php 
                                        
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
                                    <td style="text-align: left;">
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
                                        
                                    <td>$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td>
                                    <!-- <td style="padding-top: 2px;"><div class="input_div"></div></td> -->
                                </tr>
                                <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                            <?php endforeach; ?>
                            <tr style="border-top:2px solid #bbbbbb">
                                                        <td></td>
                                                        <td></td>
                                                      
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Cost</strong></td>
                                                        <td></td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateBaseCost'], 2, '.', ','); ?></strong>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                       
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Overhead</strong></td>
                                                        
                                                        <td style="text-align:right; padding: 5px 5px 5px 0;"><?php echo number_format($templateSortedItem['aggregateOverheadRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateOverheadPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                       
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                       
                                                        <td style="text-align: right;">
                                                            <strong>Profit</strong></td>
                                                        <td style="text-align:right"> <?php echo number_format($templateSortedItem['aggregateProfitRate'], 2, '.', ','); ?>
                                                            %
                                                        </td>
                                                        <td style="text-align:right;">
                                                            <strong>$<?php echo number_format($templateSortedItem['aggregateProfitPrice'], 2, '.', ','); ?></strong>

                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                       
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        
                                                        <td style="text-align: right;">
                                                            <strong>Total</strong></td>
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
                
                <th width="35%" style="text-align:left;">Item</th>
                <th width="15%" style="text-align:right;">Quantity</th>
                    
                <!-- <th>Total Price</th> -->
            </tr>
            </thead>
            <tbody>
            <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                <tr>
                    
                    <td style="text-align:left;">
                    <?php

                       if($lineItem->getIsCustomSub()==1){
                                echo $lineItem->getCustomName();
                            }else{
                                echo $lineItem->getSubContractor()->getCompanyName();
                        }
                    ?>
                    </td>
                    
                    <td style="text-align:right;"><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            QTY
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
    <?php endforeach; ?>
                </div>

            </div>

        </div>

    </div>

