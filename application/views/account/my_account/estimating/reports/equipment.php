<style type="text/css">

    #updateStatusContent {
        display: none;
    }

    .updateStatusCheckContainer {
        width: 150px;
        padding: 5px 20px;
        float: left;
        display: inline-block;
        border: 1px solid #67696c;
        margin-right: 5px;
        border-radius: 5px;
    }

    .updateStatusCheckContainer.statusSelected {
        background-color: #25aae1;
        border: 1px solid #25aae1;
        color: #fff;
    }
table.estimatePricingTable{width: 100%;
    margin: 15px 0;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 5px;}
table.estimatePricingTable td {
    padding: 5px;
}
table.estimatePricingTable th {
    background: #e2e2e2;
    padding: 7px;
}
</style>
<a class="show_item_pdf btn blue-button">
                                <i class="fa fa-fw fa-plus"></i> PDF
                            </a>

<?php 
// foreach($typeItems as $typeItem){


// echo '<h4>'.$typeItem['type']->getName().'</h4>';
?>

<table class="estimatePricingTable" width="100%">
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
</table>

    <?php //} ?>
<div id="itemPdfDialog" title="Preview Item" style="display:none;">
<div style="text-align: center;" id="loadingFrame2">
            <br />
            <p><strong>Loading Item</strong></p><br />
            <p><img src="/static/loading_animation.gif" /></p>
        </div>
<iframe id="item-preview-iframe" style="width: 100%; height: 650px"></iframe>
       
</div>


<script type="text/javascript">

$("#itemPdfDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });
    $(document).ready(function() {

        $(".estimatePricingTable").DataTable({
            ordering : true,
            searching : true,
            "bJQueryUI": true,
            "bAutoWidth": true,
            "bStateSave": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            // bJqueryUi : true,
             deferLoading: 0
        });

        // End document ready
    });

    $(".show_item_pdf").click(function() {

        $("#itemPdfDialog").dialog('open');
        $("#item-preview-iframe").hide();
        // Show the loader
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = '<?php echo  site_url('pdf/equipment_item_list');?>';
        $("#item-preview-iframe").attr("src", currSrc);
        $("#loadingFrame2").hide();
        $("#item-preview-iframe").show();
    });
</script>