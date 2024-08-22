<?php
     // $realPrice = ($proposal->price) ? str_replace(array(',', '$'), '', $proposal->price) : 0;
     // $formattedPrice = number_format($realPrice);
     // $priceBreakdown = '';
     // $totalPrice  =  '$' . number_format($breakdownData['totalPrice'], 2);
     // $totalPrice = '$' . number_format($breakdownData['totalPrice'] != 0.00 ? $breakdownData['totalPrice'] : $proposal->price,2);
     ?>
<!-- <span class="ajax-price-tiptip22 proposal_table_price_breakdown_tiptip tiptip" title="Loading..." style="cursor:pointer;border-bottom: 1px dashed #25aae1;" data-proposal-id="<?php echo $proposal->proposalId; ?>" ><?php echo $totalPrice?></span> -->

<?php
     $realPrice = ($proposal->price) ? str_replace(array(',', '$'), '', $proposal->price) : 0;
     $formattedPrice = number_format($realPrice);
     $priceBreakdown = '';
    // $totalPrice  =  '$' . number_format($breakdownData['totalPrice'], 2);
    // $totalPrice = '$' . number_format($breakdownData['totalPrice'] != 0.00 ? $breakdownData['totalPrice'] : $proposal->price,2);
?>
<span class="ajax-price-tiptip22 proposal_table_price_breakdown_tiptip tiptip" title="Loading..." style="cursor:pointer;border-bottom: 1px dashed #25aae1;" data-proposal-id="<?php echo $proposal->proposalId; ?>" ><?php echo $formattedPrice?></span>