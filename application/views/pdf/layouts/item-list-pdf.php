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
<?php foreach ($companyItems as $data){
//echo $data['category']->getName();
$items =$data['items'];

?>
<div class="col s12" style="page-break-inside: avoid">
            
            <p style="font-size:20px;"><?php echo $data['category']->getName(); ?></p>
<table class="estimateSummaryItems" width="100%" >
    <thead>
        <tr>
            <th width="10%">Type</th>
            <th width="20%">Item</th>
            <th width="10%">Base Price</th>
            <th width="10%">Unit</th>
            <th width="10%">PM</th>
            <th width="10%">OH</th>
            <th width="10%">Tax</th>
            <th width="20%">Total Price</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) :
        /* @var \models\EstimationItem $item */
    ?>
        <tr>
            <td><?php echo $item->getType()->getName(); ?></td>
            <td><?php echo $item->getName(); ?></td>
            <td>$<?php echo $item->getBasePrice(); ?></td>
            <td><?php echo $item->getUnitModel()->getSingleName(); ?></td>
            <td><?php echo $item->getProfitRate(); ?>%</td>
            <td><?php echo $item->getOverheadRate(); ?>%</td>
            <td><?php echo $item->getTaxRate() ?: 0; ?>%</td>
            <td>$<?php echo $item->getUnitPrice(); ?></td>
            
        </tr>
    <?php endforeach; ?>
    </tbody>
</table></div>
<?php //die;

    }?>