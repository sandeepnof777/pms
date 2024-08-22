<style>
    body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            padding-top: 0px;
            padding-bottom: 10px;
        }
        table.estimateSummaryItems { border-collapse: collapse; margin-bottom: 20px; }
table.estimateSummaryItems td { text-align: center }
table.estimateSummaryItems tr:nth-child(odd) {background-color: #fafafa;}
table.estimateSummaryItems tr:nth-child(even){background-color: #efefef;}

table.estimateSummaryItems th {
    background: #ccc;
    padding: 5px;
    text-align: left;
}

table.estimateSummaryItems td {
    padding: 5px;
    text-align: left;
}
</style>
<?php //foreach ($typeItems as $data){
//echo $data['category']->getName();
//$items =$data['items'];

?>
<div class="col s12" style="page-break-inside: avoid">
            
            <!-- <p style="font-size:20px;"><?php //echo $data['type']->getName(); ?></p> -->
<table class="estimateSummaryItems" width="100%" >
    <thead>
        <tr>
            <th width="25%">Type</th>
            <th width="30%">Item</th>
            <th width="15%"># Proposals</th>
            <th width="15%">Total Price</th>
            <th width="15%">Total Quantity</th>
            
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($typeItems as $item) :
        /* @var \models\EstimationItem $item */
    ?>
        <tr>
        <td><?php echo $item->typeName; ?></td>
        <td><?php echo $item->item_name; ?></td>
        <td style="text-align:center"><?php echo $item->proposal_count; ?></td>
        <td style="text-align:right">$<?php echo number_format($item->totalPrice) ?></td>
        <td style="text-align:right"><?php echo number_format($item->totalQuantity).' '.$item->unit_name; ?></td>
            
            
        </tr>
    <?php endforeach; ?>
    </tbody>
</table></div>
<?php //die;

    //}?>