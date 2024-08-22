<?php /** @var $proposal \models\Proposals */ ?>

<?php $this->load->view('global/header'); ?>
<style>
    

table td {
    
    text-align: left!important;
}
</style>
    <div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">
        
        <a href="<?php echo site_url('proposals/estimate/' . $proposal->getProposalId()); ?>" class="btn right">
            <i class="fa fa-chevron-left"></i> Back
        </a>
        <a href="<?php echo site_url('pdf/live2/download/item-sheet/'. $proposal->getAccessKey() . '.pdf'); ?>" class="btn right">
                Download
        </a>
        <a href="<?php echo site_url('proposals/estimate_items_total/' . $proposal->getProposalId()); ?>" class="btn right ">
                Items Total
        </a>
        <a href="<?php echo site_url('proposals/estimate_items/' . $proposal->getProposalId()); ?>" class="btn right blue-button">
                Items Breakdown
        </a>
        <h4 style="float:left">Item Summary: <?php echo $proposal->getClient()->getClientAccount()->getName(); ?> - <?php echo $proposal->getProjectName(); ?> </h4>

        <div class="widthfix clearfix relative">

            <hr />
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
                            <p><a href="mailto:<?php echo $proposal->getClient()->getEmail(); ?>"><?php echo $proposal->getClient()->getEmail(); ?></a></p>
                        </div>
                    
                </div>
                <hr />
            </div>
            <?php 
            
            
            foreach ($items as $item) : 
                //print_r($item['sortedItems']);
                $sortedItems =  $item['sortedItems'];
            if(count($sortedItems)>0){

            
            ?>       
           <p style="font-size:18px;color:#fff;border-radius: 5px;font-weight:bold;padding-left: 12px;background-image: linear-gradient(to right, #25aae1 , white);"><?php echo $item['proposalService']->getServiceName() .' - '. $item['phase']['name']; ?></p>
           


<div class="clearfix relative" >


<div class="row" style="margin-bottom:0px">

    <div class="col s12">

        <?php 
      
        
        foreach ($sortedItems as $sortedItem) : ?>
            <?php $rowTotal = 0; ?>
            <p style="font-size:15px;font-weight:bold;"><?php echo $sortedItem['category']->getName(); ?></p>
            <table id="estimateSummaryItems" class="" style="width: 100%;">
                <thead>
                <tr>
                    <th width="20%">Type</th>
                    <th width="40%">Item</th>
                    <th width="20%">Quantity</th>
                    <th width="20%">Total Price</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                    <tr>
                        <td><?php echo $lineItem->getItemType()->getName(); ?></td>
                        <td>
                        <?php
                            if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                                echo $lineItem->getCustomName();
                            } else {
                                echo $lineItem->getItem()->getName();
                            }

                            if($lineItem->item_type_trucking ==1){
                                echo '<br/>'.$lineItem->plant_dump_address;
                            }
                        ?>
                        </td>
                        <td><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            <?php echo $lineItem->getItem()->getUnitModel()->getName(); ?>
                        </td>
                        <td>$<?php echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td>

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Cost</strong></td>
                        <td><strong>$<?php echo number_format($sortedItem['aggregateBaseCost'], 2, '.', ',' ); ?></strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Overhead</strong></td>
                        <td>
                            <strong>$<?php echo number_format($sortedItem['aggregateOverheadPrice'], 2, '.', ',' ); ?></strong>
                            (<?php echo $sortedItem['aggregateOverheadRate']; ?> %)
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Profit</strong></td>
                        <td>
                            <strong>$<?php echo number_format($sortedItem['aggregateProfitPrice'], 2, '.', ',' ); ?></strong>
                            (<?php echo $sortedItem['aggregateProfitRate']; ?> %)
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;"><strong><?php echo $sortedItem['category']->getName(); ?> Total</strong></td>
                        <td><strong>$<?php echo number_format($rowTotal, 2, '.', ',' ); ?></strong></td>
                    </tr>
                </tbody>
            </table>
           
        <?php endforeach; ?>
    </div>

</div>

</div>
<?php 

                        }
endforeach; ?>
</div>

        </div>

    </div>



<?php $this->load->view('global/footer'); ?>