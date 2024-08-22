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
    table.price_items_table {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }
    table.price_items_table th {
        background: #e2e2e2;
        padding: 7px;
    }
    table.price_items_table td {
        padding: 5px;
    }
    .select_box_error {
    border-radius: 2px;
    border: 1px solid #e47074 !important;
    background-color: #ffedad !important;
    box-shadow: 0 0 2px rgb(159 0 6 / 30%) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
</style>
<!-- add a back button  -->
<div class="estimateReportMenuButtons">
    <a class="show_item_pdf btn blue-button" style="float: left; margin-top: 5px;">
        <i class="fa fa-fw fa-file-text-o"></i> View PDF
    </a>
    <!-- <a  href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="btn blue-button" style="float:right;margin-top: 5px;">
        Back
    </a> -->

    <a class="addTypeItem btn blue-button" style="float:right;margin-right:5px;">
        <i class="fa fa-fw fa-plus"></i> Add Item
    </a>

    <div class="clearfix" style="height: 0;"></div>

</div>
<div class="clearfix"></div>
<div class="estimatePriceReportFilters">

    <strong><span style="position: relative; top: 4px; float: left; margin-right: 20px">
            Category Filters</span></strong>

    <div class="estimatePriceReportFilter">
        <label>
            <input type="checkbox" class="filterCategory" value="1">
            <span style="position: relative; top: 4px;">Material</span>
        </label>
    </div>

    <div class="estimatePriceReportFilter">
        <label>
            <input type="checkbox" class="filterCategory" value="2">
            <span style="position: relative; top: 4px;">Equipment</span>
        </label>
    </div>

    <div class="estimatePriceReportFilter">
        <label>
            <input type="checkbox" class="filterCategory" value="3">
            <span style="position: relative; top: 4px;">Labor</span>
        </label>
    </div>

    <div class="estimatePriceReportFilter">
        <label>
            <input type="checkbox" class="filterCategory" value="5">
            <span style="position: relative; top: 4px;">Services</span>
        </label>
    </div>

    <div class="clearfix"></div>

</div>



<table id="estimatePricingTable" style="width: 100%;">
    <thead>
        <tr>
            <th width="10%">Category</th>
            <th width="10%">Type</th>
            <th width="21%">Item</th>
            <th width="9%">Base Price</th>
            <th width="9%">Unit</th>
            <th width="6%">PM</th>
            <th width="6%">OH</th>
            <th width="6%">Tax</th>
            <th width="10%">Total Price</th>
            <th width="13%">Actions</th>
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

<div id="itemPriceHistoryDialog" title="Item Price History" style="display:none;">
    <h3 class="heading_item_name"></h3>
    <table class="price_items_table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>IP</th>
                    <th>User</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
       
</div>

<div id="estimatingItemModal" >
    <?php 
    
    $this->load->view('account/my_account/estimating/item-dialog'); ?>
</div>

<div id="servicesDialog">

    <h3>Assign Template to Item: <span id="assignTypeName"></span></h3>
    
    <div class="clearfix"></div>

    <div id="assignLoading" style="display: none; text-align: center;">
        <img src="/static/loading_animation.gif" />
    </div>

    <a href="#" id="checkAll">All</a> / <a href="#" id="checkNone">None</a>
    <div class="clearfix"></div>

    <input type="hidden" id="assignItemId">

    <?php foreach ($templates as $template) : ?>
        <div class="serviceTypeCheckContainer">
            <label>
                <input type="checkbox" class="serviceCheck" data-template-id="<?php echo $template->getId() ?>"
                       value="<?php echo $template->getId() ?>" />
                <span style="position: relative; top: 3px;"><?php echo $template->getName(); ?></span>
            </label>

        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <hr />

    <a class="left btn btn-default" href="#" id="cancelAssign">
        <i class="fa fa-fw fa-close"></i> Cancel
    </a>

    <a class="right btn blue-button saveAssignments"  href="javascript:void(0);" >
        <i class="fa fa-fw fa-save"></i> Save Assignments
    </a>

</div>
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">
var defaultOverheadPct = <?php echo $estimationSettings->getDefaultOverhead(); ?>;
var defaultProfitPct = <?php echo $estimationSettings->getDefaultProfit(); ?>;
var truckingType = <?php echo ESTIMATING_TRUCKING_TYPE; ?>;
var pricingTable;
var activityTable;
$("#itemPdfDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
});

$("#itemPriceHistoryDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
});

// Services Dialog
$("#servicesDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });
    $(document).ready(function() {
        
        pricingTable = $("#estimatePricingTable").DataTable({
            serverSide: true,
            ajax: {
                "url": '<?php echo site_url('account/estimatePricingReportData'); ?>',
                type: "POST",
                data: function(d) {
                    d.categories = getFilterCategories()
                }
            },
            "bJQueryUI": true,
            "bAutoWidth": true,
            "bStateSave": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            order: [[2, "asc"]],
            columns: [
                // Category Name
                { name: 'itemName', searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: true, sortable: true },
                { searchable: false, sortable: false, type: 'html' },
            ],
            drawCallback: function() {
                initButtons();
                initTiptip();
            }
        });

        // All Statuses
        $("#checkAllStatuses").click(function() {
            $(".statusCheck").prop('checked', true);
            $.uniform.update();
            updateStatusUi();
            return false;
        });

        // All Statuses
        $("#uncheckAllStatuses").click(function() {
            $(".statusCheck").prop('checked', false);
            $.uniform.update();
            updateStatusUi();
            return false;
        });

        $(".filterCategory").change(function() {
            pricingTable.ajax.reload();
        });

        // End document ready
    });
// Changing category
$('#categoryId').change(function() {
            // Grab the value
            var categoryId = $(this).val();

            // If there's a value, show/hide the options
            if (categoryId) {
                $("#typeId").prop('disabled', '');

                $("#typeId option").hide();
                $('#typeId option[data-category="' + categoryId + '"]').show();
            }

            // Update the dropdowns
            setDropdowns();
        });

        // Changing Type
        $('#typeId').change(function() {
            // Update the dropdowns
            setDropdowns();
            if($('#typeId').val() == truckingType){
                $("#capacityRow").show();
                $("#itemCapacity").addClass('required'); 
            }else{
                $("#capacityRow").hide();
                $("#itemCapacity").removeClass('required');
            }
        });

        // Number format on unit price
        $("#unitPrice").keyup(function() {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: '$'
            });
        });

        // Number format on tax rate
        $("#tax_rate").keyup(function() {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: ''
            });
        });

        // Toggle Taxable checkbox
        $("#taxable").change(function() {
            var isChecked = $(this).is(':checked');

            $("#taxRateRow").toggle(isChecked);
        });
    // Form modal
        $("#estimatingItemModal").dialog({
            modal: true,
            autoOpen: false,
            width: 800,
            title: 'Item Details'
        });

        // Open the form
        $(".openForm").click(function() {
            $("#estimatingItemModal").dialog('open');
            return false;
        });

        // Edit item click
        $(document).on('click', ".editItem", function() {

            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');
            var unitId = $(this).data('unit-id');
            var itemId = $(this).data('item-id');
            var itemName = $(this).data('item-name');
            var taxable = $(this).data('item-taxable');
            var taxRate = $(this).data('item-tax-rate');
            var unitPrice = $(this).data('item-unit-price');
            var vendor = $(this).data('item-vendor');
            var sku = $(this).data('item-sku');
            var notes = $(this).data('item-notes');
            var basePrice = $(this).data('item-base-price');
            var overheadRate = $(this).data('item-overhead-rate');
            var overheadPrice = $(this).data('item-overhead-price');
            var profitRate = $(this).data('item-profit-rate');
            var profitPrice = $(this).data('item-profit-price');
            var profitPrice = $(this).data('item-profit-price');
            var capacity = $(this).data('item-capacity');
            $('input.error').removeClass("error");

            // Set the values
            $("#itemId").val(itemId);
            $("#itemName").val(itemName);
            $("#categoryId").val(categoryId);
            $("#typeId").val(typeId);
            $("#unitId").val(unitId);
            $('#taxable').prop('checked', taxable);
            $('#tax_rate').val(taxRate);
            $('#unitPrice').val('$' + unitPrice);
            $('#itemVendor').val(vendor);
            $('#itemSku').val(sku);
            $('#itemBaseCost').val(basePrice);
            $('#itemOverheadRate').val(overheadRate);
            $('.itemOverheadPrice').text('$'+overheadPrice);
            $('#itemProfitRate').val(profitRate);
            $('.itemProfitPrice').text('$'+profitPrice);
            $('#itemNotes').text(notes);
            $('#itemCapacity').val(capacity);

            //update the unit type

            $('.unit_type_text').text(' / '+$("#unitId option[value='"+unitId+"']").attr('data-val'));

            // Toggle the tax checkbox
            if (taxable) {
                $("#taxRateRow").show();
            } else {
                $("#taxRateRow").hide();
            }
            if(typeId == truckingType){
                $("#capacityRow").show();
                $("#itemCapacity").addClass('required'); 
            }else{
                $("#capacityRow").hide();
                $("#itemCapacity").removeClass('required');
            }
            // Hide the unit dropdown
            $(".unitRow").hide();

            // Select all statuses and show the status content
            $(".statusCheck").prop('checked', true);
            updateStatusUi();
            $("#updateStatusContent").show();

            // Set dropdowns and update UI
            setDropdowns();
            $.uniform.update();

            // Hide capacity if not trucking

            $("#estimatingItemModal").dialog('open');
            return false;
        });


        function updateStatusUi()
    {
        $(".statusCheck").each(function() {
           if ($(this).is(':checked')) {
               $(this).closest('.updateStatusCheckContainer').addClass('statusSelected');
           } else {
               $(this).closest('.updateStatusCheckContainer').removeClass('statusSelected');
           }
        });
    }
    function updateItemPrices() {

        var basePrice = cleanNumber($("#itemBaseCost").val());
        var overheadRate = cleanNumber($("#itemOverheadRate").val());
        var profitRate = cleanNumber($("#itemProfitRate").val());
        if(!overheadRate){
            $("#itemOverheadRate").val(0);
            overheadRate=0;
        }
        if(!profitRate){
            $("#itemProfitRate").val(0);
            profitRate=0;
        }
        var overheadPrice = ((basePrice * overheadRate) / 100);
        var profitPrice = ((basePrice * profitRate) / 100);
        var totalPrice = parseFloat(basePrice) + parseFloat(overheadPrice) + parseFloat(profitPrice);

        $(".itemOverheadPrice").text('$'+overheadPrice.toFixed(2));
        $(".itemProfitPrice").text('$'+profitPrice.toFixed(2));
        $("#unitPrice").val(totalPrice.toFixed(2));
    }

    function cleanNumber(numberString) {
        console.log(numberString);
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

    function setDropdowns() {

        if (!$("#categoryId").val()) {
            $("#typeId").prop('disabled', 'disabled');
            $("#unitId").prop('disabled', 'disabled');
        } else {
            $("#typeId").prop('disabled', '');
            if (!$("#typeId").val()) {
                $("#unitId").prop('disabled', 'disabled');
            } else {
                $("#unitId").prop('disabled', '');
            }
        }
        $.uniform.update();
    }

// Input Masks
$(".currencyFormat").inputmask("decimal",
            {
                "radixPoint": ".",
                "groupSeparator":",",
                "digits":2,
                "prefix":"$",
                "autoGroup":true,
                "showMaskOnHover": false,
                "showMaskOnFocus": false,
            }
        );

        $(".percentFormat").inputmask("decimal",
            {
                "radixPoint": ".",
                "groupSeparator":",",
                "suffix":"%",
                "autoGroup":true,
                "digits": 2,
                "showMaskOnHover": false,
                "showMaskOnFocus": false,
            }
        );

        // Update prices when typing
        $("#itemBaseCost, #itemOverheadRate, #itemProfitRate").keyup(function() {
           updateItemPrices();
        });

// New Item Form
$(".addTypeItem").click(function() {

            // Reset the ID and name
            $("#itemId").val('');
            $("#itemName").val('');
            $("#itemCapacity").val('');

            // Set the dropdowns
            $("#categoryId").val('');
            $("#typeId").val('');

            // Populate the defaults
            $("#itemOverheadRate").val(defaultOverheadPct);
            $(".itemOverheadPrice").text('$0.00');
            $("#itemProfitRate").val(defaultProfitPct);
            $(".itemProfitPrice").text('$0.00');
            $("#unitPrice").val('0.00');

            // Hide capacity row if not a truck
            // if(typeId == truckingType){
            //     $("#capacityRow").show();
            //     $("#itemCapacity").addClass('required');
            //     console.log('addclass');
            // }else{
                $("#capacityRow").hide();
                $("#itemCapacity").removeClass('required');
            //}

var myForm = document.getElementById("add_item_form");
clearValidation(myForm);
            // Show the unit dropdown
            $(".unitRow").show();

            // Hide the status content
            $("#updateStatusContent").hide();

            // Open the modal
            $("#estimatingItemModal").dialog('open');
            $.uniform.update();
            setDropdowns();
            return false;
        });
    // Unit type changes
    $("#unitId").change(function(e) {
        $('.unit_type_text').text(' / '+$(this).find(':selected').attr('data-val'));
    });

    $("#add_item_form").submit(function(){
        setTimeout(function(){ 
           
        
        console.log($('#categoryId').hasClass('error'));
        if($('#categoryId').hasClass('error')){
            $('#categoryId').closest('div').addClass('select_box_error')
        }else{
            $('#categoryId').closest('div').removeClass('select_box_error')
        }
        if($('#typeId').hasClass('error')){
            $('#typeId').closest('div').addClass('select_box_error')
        }else{
            $('#typeId').closest('div').removeClass('select_box_error')
        }
        if($('#unitId').hasClass('error')){
            $('#unitId').closest('div').addClass('select_box_error')
        }else{
            $('#unitId').closest('div').removeClass('select_box_error')
        }
    }, 100);
    });

    $("#categoryId").change(function(e) {
        if($('#categoryId').val() == ''){
            $('#categoryId').closest('div').addClass('select_box_error')
        }else{
            $('#categoryId').closest('div').removeClass('select_box_error')
        }

    });   
    
    $("#typeId").change(function(e) {
        if($('#typeId').val() == ''){
            $('#typeId').closest('div').addClass('select_box_error')
        }else{
            $('#typeId').closest('div').removeClass('select_box_error')
        }
    }); 

    $("#unitId").change(function(e) {
        if($('#unitId').val() == ''){
            $('#unitId').closest('div').addClass('select_box_error')
        }else{
            $('#unitId').closest('div').removeClass('select_box_error')
        }
    });
    
    $(".show_item_pdf").click(function() {

        $("#itemPdfDialog").dialog('open');
        $("#item-preview-iframe").hide();
        // Show the loader
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = '<?php echo  site_url('pdf/item_list');?>';
        $("#item-preview-iframe").show();
        $("#item-preview-iframe").attr("src", currSrc);

        // Hide the loader
        $("#loadingFrame2").hide();

    });

    function getFilterCategories() {
        var filterCategories = [];

        $(".filterCategory:checked").each(function() {
            filterCategories.push($(this).val());
        });

        return filterCategories;
    }




    $(document).on('click', ".item_price_changes_show", function() {

        var item_name = $(this).data('item-name');
        $('.heading_item_name').html('<i class="fa fa-fw fa-history"></i>Item Price History: '+item_name);
        var item_id = $(this).data('item-id');
        var tableUrl = '/ajax/getItemPriceHistory/'+item_id;
        $("#itemPriceHistoryDialog").dialog('open');
        if(activityTable) {
                activityTable.ajax.url(tableUrl).clear().load();
                $("#itemPriceHistoryDialog").dialog('open');
            } else {
                
                activityTable = $(".price_items_table").DataTable({
                    "width": 700,
                    "bProcessing": true,
                    "serverSide": true,
                    "scrollCollapse": true,
                    "scrollY": "300px",
                    "ajax": {
                        "url": tableUrl
                    },
                    "initComplete":function( settings, json){
                        
        },
                    "aoColumns": [
                        { bSortable: true },
                        { bSortable: false },
                        { bSortable: true },
                        { bSortable: false }
                    ],
                    "bJQueryUI": true,
                    "bAutoWidth": true,
                    "sPaginationType": "full_numbers",
                    "sDom": 'HfltiprF',
                    "aLengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "order": [[0, "desc"]],
                    "fnDrawCallback": function() {
                        $("#proposalActivity").dialog('open');
                    }
                });
                
            }

    })


    $(document).on('click', ".assignTemplate", function() {
        // SHow the loader
        $("#assignLoading").show();

        // Grab the vars
        var itemId = $(this).data('item-id');
        var typeName = $(this).data('type-name');
        console.log(itemId);
        // Clear all checkboxes
        $(".serviceCheck").prop('checked', false);

        // Load the title and form
        $("#assignItemId").val(itemId);
        $("#assignTypeName").text(typeName);

        // Grab the assigned services for this type
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('ajax/getEstimationItemTemplates'); ?>/"+itemId,
            dataType: "json",
        })
        .success(function (data) {
            console.log(data);
            if (data.length) {

                $.each(data, function(idx, val) {
                    $('.serviceCheck[data-template-id="' + val.template_id + '"]').prop('checked', true);
                });

                $.uniform.update();

            } else {
                swal(data.message);
                console.log(data.debug);
            }

            $("#assignLoading").hide();
            $.uniform.update();
        });

// Open the dialog
$("#servicesDialog").dialog('open');
return false;
});

function getSelectedIds() {

var IDs = new Array();

$(".serviceCheck:checked").each(function () {
    IDs.push($(this).data('template-id'));
});

return IDs;
}

$(document).on('click', ".saveAssignments", function() {

var itemId = $("#assignItemId").val();


    $.ajax({
        type: "POST",
        async: true,
        cache: false,
        data: {
            'itemId' : itemId,
            'templateIds': getSelectedIds()
        },
        url: "<?php echo site_url('ajax/companyTemplateItemAssign'); ?>",
        dataType: "JSON"
    })
    .success(function (data) {
        if (!data.error) {
            $("#servicesDialog").dialog('close');
            swal('Assignments Saved');
            return false;
        } else {
            $("#servicesDialog").dialog('close');
            swal(data.message);
            console.log(data.debug);
            return false;
        }
});

return false;
});

// Check All
$("#checkAll").click(function() {
            $(".serviceCheck").prop('checked', true);
            $.uniform.update();
            return false;
        });

        // Check All
        $("#checkNone").click(function() {
            $(".serviceCheck").prop('checked', false);
            $.uniform.update();
            return false;
        });

        $("#cancelAssign").click(function() {
            $("#servicesDialog").dialog('close');
            return false;
        });



function clearValidation(formElement){
 //Internal $.validator is exposed through $(form).validate()
 var validator = $(formElement).validate();
 console.log(validator);
 //Iterate through named elements inside of the form, and mark them as error free
 $('[name]',formElement).each(function(){
   validator.successList.push(this);//mark as error free
   validator.showErrors();//remove error messages if present
 });
 validator.resetForm();//remove error class on name elements and clear history
 validator.reset();//remove all error and success data
}
</script>