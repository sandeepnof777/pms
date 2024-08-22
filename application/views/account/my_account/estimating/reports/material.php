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

<div class="estimateReportMenuButtons">
<!-- add a back button  -->
    <!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="btn blue-button" style="float: right; margin-top: 5px;">
        Back
    </a> -->

    <a class="show_item_pdf btn blue-button" style="float: right; margin-top: 5px;margin-right:5px;">
        <i class="fa fa-fw fa-file-text-o"></i> View PDF
    </a>
    <div class="clearfix" style="height: 10px;"></div><br />

    <?php $this->load->view('templates/estimate_reports/filters/estimate-report-filters'); ?>

</div>

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
    </tbody>
</table>

<div id="itemPdfDialog" title="Preview Item" style="display:none;">
<div style="text-align: center;" id="loadingFrame2">
            <br />
            <p><strong>Loading Item</strong></p><br />
            <p><img src="/static/loading_animation.gif" /></p>
        </div>
        <iframe id="item-preview-iframe" style="width: 100%; height: 650px"></iframe>
</div>

<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">

    $(document).ready(function() {

        $(".estimatePricingTable").DataTable({
            serverSide: true,
            ajax: {
                "url": '<?php echo site_url('account/estimateCategoryReportData/' . $categoryId); ?>',
                type: "POST"
            },
            bJQueryUI: true,
            bAutoWidth: true,
            bStateSave: true,
            sPaginationType: "full_numbers",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            columns: [
                {searchable: true, sortable: true},
                {searchable: true, sortable: true},
                {searchable: true, sortable: true, class: 'dtCenter'},
                {searchable: true, sortable: true, class: 'dtRight'},
                {searchable: true, sortable: true, class: 'dtRight'},
            ]
        });

        $("#itemPdfDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });

        $(".show_item_pdf").click(function() {

            $("#itemPdfDialog").dialog('open');
            $("#item-preview-iframe").hide();
            // Show the loader
            $("#loadingFrame2").show();
            // Refresh the iframe - Load event will handle showing the frame and hiding the loader
            var currSrc = '<?php echo  site_url('pdf/material_item_list');?>';
            $("#item-preview-iframe").attr("src", currSrc);
            $("#loadingFrame2").hide();
            $("#item-preview-iframe").show();
        });

        // End document ready
    });


</script>