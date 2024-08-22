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
    h3.accordionHeader .groupAction{
        display:none;
    }

    h3.accordionHeader .ui-state-active .groupAction{
        display:inline-block;
    }

    a#uploadItems {
        padding: 0;
        margin-top: -5px;
    }
    table.dataTable.no-footer {
    border-bottom: none!important;
}
</style>
<?php $excavation_id ='29';?>

<!-- <a class="btn blue-button" href="<?php echo site_url('account/my_account/proposal_settings') ?>" style="float: right;margin-top: 2px;margin-right: 10px;padding: 0.3em 0.5em;
    font-size: 12px;" >
  Back
</a> -->
<h3>
    Estimation Items
    <a class="btn blue-button" id="uploadItems" href="<?php echo site_url('account/estimating_item_upload'); ?>">
        <i class="fa fa-fw fa-upload"></i> Upload
    </a>
  
</h3>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Items. You can add, edit, delete and reorder.</p>

<div class="clearfix"></div>

<div id="categoryTabs">
    <ul>
        <?php foreach ($categories as $category) : 
             if($category->getId() != models\EstimationCategory::CUSTOM ){?>
            <li><a href="#categoryTab<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a></li>
        <?php } endforeach; ?>
    </ul>
    <?php foreach ($categories as $category) : 
         if($category->getId() != models\EstimationCategory::CUSTOM ){?>
        <div id="categoryTab<?php echo $category->getId(); ?>">

            <div class="accordionContainer">
                <?php if (count($sortedTypes[$category->getid()])) : ?>
                <?php foreach ($sortedTypes[$category->getid()] as $categoryType) : ?>
                    <h3 class="accordionHeader" id="typeHeading<?php echo $categoryType->getId(); ?>"
                        data-type-id="<?php echo $categoryType->getId() ?>">
                        <?php echo $categoryType->getName(); ?> [<span class="items_count" data-type-id="<?php echo $categoryType->getId(); ?>"><?php echo count($sortedItems[$category->getId()][$categoryType->getId()]) ?></span>]
                        <div class="materialize" style="display:inline-block;">
                        <a class="addTypeItem btn blue-button m-btn" style="font-weight: normal; top:-1px!important"
                           data-category-id="<?php echo $category->getId(); ?>"
                           data-type-id="<?php echo $categoryType->getId() ?>">
                            <i class="fa fa-fw fa-plus"></i> Add Item
                        </a>
                        </div>
                         <!---Start Filter button---->
                         <div class="materialize" style="font-weight: normal;min-width: 100px !important;position: absolute;top: 4px;right: 115px;white-space: nowrap;">
                                
                                <div class="m-btn groupAction tiptip" id="groupAction_<?php echo $categoryType->getId(); ?>" style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected contacts" >
                                    <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                                    <div class="groupActionsContainer materialize" style="width:160px">
                                        <div class="collection groupActionItems" >
                                            
                                            <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                                                <i class="fa fa-fw fa-trash"></i> Delete Items
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div id="filterBadges"></div>
                                <div class="clearfix"></div>
                            </div>
                        <!---End Filter button---->
                    </h3>
                    <div>
                       
                        <?php if (count($sortedItems[$category->getId()][$categoryType->getId()])) : ?>
                        <table id="itemsType<?php echo $categoryType->getId(); ?>" data-type-id="<?php echo $categoryType->getId(); ?>" class="estimatingItemsTable" >
                            <thead>
                            <tr>
                                <th width="3%"><span class="span_checkbox_th"><input type="checkbox" class="check_all" data-category-type-id="<?php echo $categoryType->getId(); ?>"></th>
                                <th width="4%">Order</th>
                                <th width="24%">Item Name</th>
                                <th width="15%">Unit</th>
                                <th width="14%">Unit Price</th>
                                <th width="6%">OH</th>
                                <th width="6%">PM</th>
                                <th width="6%">TR</th>
                                <th width="22%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sortedItems[$category->getId()][$categoryType->getId()] as $typeItem) : ?>
                                <?php /* @var $typeItem \models\EstimationItem */ ?>
                                <tr  id="items_<?php echo $typeItem->getId(); ?>">
                                    <td><span class="span_checkbox"><input type="checkbox" class="item_check" data-item-id="<?php echo $typeItem->getId(); ?>" data-category-type-id="<?php echo $categoryType->getId(); ?>"></span></td>
                                    <td style="text-align: center">
                                        <a class="handle">
                                            <i class="fa fa-fw fa-sort"></i>
                                        </a>
                                    </td>
                                    <td width="25%"><?php echo $typeItem->getName(); ?></td>
                                    <td width="15%"><?php echo $typeItem->getUnitModel()->getName(); ?></td>
                                    <td width="15%">$<?php echo $typeItem->getUnitPrice(); ?></td>
                                    <td  width="6%" style="text-align: center"><?php echo $typeItem->getOverheadRate(); ?>%</td>
                                    <td  width="6%" style="text-align: center"><?php echo $typeItem->getProfitRate(); ?>%</td>
                                    <td  width="6%" style="text-align: center"><?php echo $typeItem->getTaxable() ? $typeItem->getTaxRate() . '%' : '-'; ?></td>
                                    <td  width="23%">
                                        <?php if($typeItem->getCompanyId()) : ?>
                                        <a href="#" class="editItem btn tiptip" title="Edit Item"
                                           data-item-id="<?php echo $typeItem->getId(); ?>"
                                           data-unit-id="<?php echo $typeItem->getUnit(); ?>"
                                           data-category-id="<?php echo $category->getId(); ?>"
                                           data-type-id="<?php echo $categoryType->getId(); ?>"
                                           data-item-name="<?php echo $typeItem->getName(); ?>"
                                           data-item-vendor="<?php echo $typeItem->getVendor(); ?>"
                                           data-item-sku="<?php echo $typeItem->getSku(); ?>"
                                           data-item-base-price="<?php echo $typeItem->getBasePrice() ?>"
                                           data-item-overhead-rate="<?php echo $typeItem->getOverheadRate() ?>"
                                           data-item-overhead-price="<?php echo $typeItem->getOverheadPrice(); ?>"
                                           data-item-profit-rate="<?php echo $typeItem->getProfitRate(); ?>"
                                           data-item-profit-price="<?php echo $typeItem->getProfitPrice(); ?>"
                                           data-item-taxable="<?php echo $typeItem->getTaxable(); ?>"
                                           data-item-notes="<?php echo $typeItem->getNotes(); ?>"
                                           data-item-unit-price="<?php echo $typeItem->getUnitPrice(); ?>"
                                           data-item-tax-rate="<?php echo $typeItem->getTaxRate(); ?>"
                                           data-item-capacity="<?php echo $typeItem->getCapacity(); ?>"
                                           data-item-minimum-hours="<?php echo $typeItem->getMinimumHours(); ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </a>
                                        <?php endif; ?>
                                        <a href="#" class="copyItem btn tiptip" title="Duplicate Item"
                                           data-item-id="<?php echo $typeItem->getId(); ?>"
                                           data-unit-id="<?php echo $typeItem->getUnit(); ?>"
                                           data-category-id="<?php echo $category->getId() ?>"
                                           data-type-id="<?php echo $categoryType->getId() ?>"
                                           data-item-name="<?php echo $typeItem->getName() ?>"
                                           data-item-base-price="<?php echo $typeItem->getBasePrice() ?>"
                                           data-item-overhead-rate="<?php echo $typeItem->getOverheadRate() ?>"
                                           data-item-overhead-price="<?php echo $typeItem->getOverheadPrice(); ?>"
                                           data-item-profit-rate="<?php echo $typeItem->getProfitRate(); ?>"
                                           data-item-profit-price="<?php echo $typeItem->getProfitPrice(); ?>"
                                           data-item-taxable="<?php echo $typeItem->getTaxable(); ?>"
                                           data-item-notes="<?php echo $typeItem->getNotes(); ?>"
                                           data-item-unit-price="<?php echo $typeItem->getUnitPrice(); ?>"
                                           data-item-tax-rate="<?php echo $typeItem->getTaxRate(); ?>"
                                           data-item-capacity="<?php echo $typeItem->getCapacity(); ?>"
                                           data-item-minimum-hours="<?php echo $typeItem->getMinimumHours(); ?>">
                                            <i class="fa fa-fw fa-files-o"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn tiptip assignTemplate" title="Assign Template"
                                            data-item-id="<?php echo $typeItem->getId(); ?>">
                                            <i class="fa fa-list"></i>
                                        </a>
                                        <a href="#" class="deleteItem btn tiptip" title="Delete Item"
                                           data-item-id="<?php echo $typeItem->getId(); ?>"
                                           data-item-name="<?php echo $typeItem->getName() ?>">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else : 
                            
                            ?>
                            
                            <br />
                            <p>There are no items in this category</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php else : ?>
                    <p>There are no types in this category.</p>
                <?php endif ?>
            </div>
        </div>
    <?php } endforeach; ?>
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

<!-- Confirm delete dialog -->
<div id="delete-Items" title="Confirmation">
    <h3>Confirmation - Delete Items</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> items.</p>
    <br/>
    <p><strong>Items used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-items-status" title="Confirmation">
    <h3>Confirmation - Delete Items</h3>

    <p id="deleteItemsStatus"></p>
</div>

<script src="<?=site_url('3rdparty/DataTables-new/dataTables.min.js');?>"></script>
<script src="<?=site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.jqueryui.min.js');?>"></script>
<link rel="stylesheet" type="text/css" href="<?=site_url('3rdparty/DataTables-new/datatables.min.css');?>" media="all">

<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">

    var defaultOverheadPct = <?php echo $estimationSettings->getDefaultOverhead(); ?>;
    var defaultProfitPct = <?php echo $estimationSettings->getDefaultProfit(); ?>;
    var searchItems = <?php echo json_encode($searchItems); ?>;
    var truckingType = <?php echo ESTIMATING_TRUCKING_TYPE; ?>;
    var excavationType = <?php echo ESTIMATING_EXCAVATION_TYPE; ?>;
    var public_item_price ='';
    
// Services Dialog
$("#servicesDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });
    $(document).ready(function() {

        var openTab = localStorage.getItem('selectedTabId');
        var openAccordion = localStorage.getItem('selectedAccordionId');

        // Set the form
        setDropdowns();

        // Tabs for layout
        $("#categoryTabs").tabs({
            active: 0,
            activate : function(event, ui) {
                var selectedTabId = ui.newPanel.selector
                if(hasLocalStorage){
                    localStorage.setItem('selectedTabId', selectedTabId);
                }
            }
        });

        // Open the last one
        if (openTab) {
            $('#categoryTabs').tabs("select", openTab);

            setTimeout(function() {
                if (openAccordion) {
                    $("#" + openAccordion).trigger('click');
                }
            }, 100);
        }

        // Accordions
        $(".accordionContainer").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "h3",
            beforeActivate: function( event, ui ) {
                if (ui.newHeader[0]) {
                    var selectedAccordionId = ui.newHeader[0].id;
                    if(hasLocalStorage){
                        localStorage.setItem('selectedAccordionId', selectedAccordionId);
                    }
                } else {
                    localStorage.removeItem('selectedAccordionId');
                }
                $('.item_check').prop('checked',false);
                $('.check_all').prop('checked',false);
                $(".groupAction").hide();
                $.uniform.update();
            }
            
        });


        // Sortable tables
        $("table.estimatingItemsTable tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationItemsCompanyOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // Search
        $("#itemSearch").autocomplete({
            source : searchItems,
            select : function(event, ui) {

                // Get the category and type IDs
                var categoryId = ui.item.category_id;
                var typeId = ui.item.type_id;

                // Switch to the tab
                $('#categoryTabs').tabs("select", "#categoryTab" + categoryId);

                // Open the types accordion
                setTimeout(function() {
                    var selector = '.accordionHeader[data-type-id="' + typeId + '"]';

                    // Click on the header
                    if (!$(selector).hasClass('ui-accordion-header-active')) {
                        $('.accordionHeader[data-type-id="' + typeId + '"]').trigger('click');
                    }

                    // Reset the search box
                    $("#itemSearch").val('');
                }, 150);

            }
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
            updateItemPrices()
        });

        // Toggle Taxable checkbox
        $("#taxable").change(function() {
            var isChecked = $(this).is(':checked');

            $("#tax_rate").toggle(isChecked);
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
        $(".editItem").click(function() {
            
            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');
            var unitId = $(this).data('unit-id');
            var itemId = $(this).data('item-id');
            var itemName = $(this).data('item-name');
            var taxable = $(this).data('item-taxable');
            var taxRate = $(this).data('item-tax-rate');
            var unitPrice = $(this).data('item-unit-price');
            public_item_price =unitPrice;
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
            var item_minimum_hours = $(this).data('item-minimum-hours');
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
            $('#minimumHours').val(number_test(item_minimum_hours));

            $("#categoryId").prop('disabled', '');
            //update the unit type
            

            //Disable category and Type select box
          
            $("#typeId").prop('disabled', 'disabled');
            $("#categoryId").prop('disabled', 'disabled');

            $('.unit_type_text').text(' / '+$("#unitId option[value='"+unitId+"']").attr('data-val'));

            // Toggle the tax checkbox
            if (taxable) {
                $("#tax_rate").show();
            } else {
                $("#tax_rate").hide();
            }
            if(typeId == truckingType){
                $("#capacityRow").show();
                 $("#minimumHoursRow").show();
                $("#itemCapacity").addClass('required'); 
            }else{
                $("#capacityRow").hide();
                $("#minimumHoursRow").hide();
                $("#itemCapacity").removeClass('required');
            }
            // Hide the unit dropdown
            $(".unitRow").hide();

            // Select all statuses and show the status content
            $(".statusCheck").prop('checked', true);
            updateStatusUi();
            //$("#updateStatusContent").show();

            // Set dropdowns and update UI
            //setDropdowns();
            $.uniform.update();

            // Hide capacity if not trucking
            updateItemPrices();
            $("#estimatingItemModal").dialog('open');
            return false;
        });

        // New Item Form
        $(".addTypeItem").click(function() {
            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');
            $("#typeId").val(typeId);
            if(typeId ==excavationType){
              
                $("#itemOverheadRate").val(0);
                $("#itemProfitRate").val(0);
                $('#unitId option[data-val=Ton]').attr('selected','selected');
                $("#unitId").prop('disabled', 'disabled');
                
            }else{
                $("#itemOverheadRate").val(defaultOverheadPct);
                $("#itemProfitRate").val(defaultProfitPct);
                $("#unitId").prop('disabled', '');
                $("#unitId").val('');
            }

            if(categoryId== <?= models\EstimationCategory::EQUIPMENT ;?> ||categoryId== <?= models\EstimationCategory::LABOR ;?>){
                $('#unitId option[data-val=Hour]').attr('selected','selected');
            }
            $("#itemBaseCost").val(0);
            var unit_name =$("#unitId").find(':selected').attr('data-val');
            if(unit_name){
                $('.unit_type_text').text(' / '+unit_name);
            }else{
                $('.unit_type_text').text('');
            }
            
            //Disable category and Type select box
          
            $("#typeId").prop('disabled', 'disabled');
            $("#categoryId").prop('disabled', 'disabled');
            
            // Reset the ID and name
            $("#itemId").val('');
            $("#itemName").val('');
            $("#itemCapacity").val('');

            // Set the dropdowns
            $("#categoryId").val(categoryId);
            

            // Populate the defaults
           
            $(".itemOverheadPrice").text('$0.00');
            
            $(".itemProfitPrice").text('$0.00');
            $("#unitPrice").val('0.00');

            // Hide capacity row if not a truck
            if(typeId == truckingType){
                $("#capacityRow").show();
                $("#minimumHoursRow").show();
                $("#itemCapacity").addClass('required');
                
            }else{
                $("#capacityRow").hide();
                $("#minimumHoursRow").hide();
                $("#itemCapacity").removeClass('required');
                
            }
            $(".unitRow").show();
            $(".tax_amount").text('$0.00');
            $('#taxable').prop('checked', false);
            $("#tax_rate").hide();
            $("#tax_rate").val(0);
            
            // Hide the status content
            $("#updateStatusContent").hide();

            var myForm = document.getElementById("add_item_form");
            clearValidation(myForm);
            // Open the modal
            $("#estimatingItemModal").dialog('open');
            $.uniform.update();
            //setDropdowns();
            return false;
        });

        // Datatables
        $(".estimatingItemsTable").DataTable({
            ordering : false,
            searching : false,
            paging: false,
            bJqueryUi : true,
            deferLoading: 0
        });

        // Delete Button Click
        $(".deleteItem").click(function() {

            var itemId = $(this).data('item-id');
            var item_type_id =$(this).closest('table').attr('data-type-id');

            if(item_type_id=='11' || item_type_id=='12'){
                var rowCount = $(this).closest('table').find('tr').length;
                
                if(rowCount<3){
                    swal('','You must have at least one of these items for calculators to work.');
                    return false;
                }
            }
            
                swal({
                    title: 'Delete Item',
                    html: '<p>Are you sure you want to delete this item?</p>',
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText:
                        '<i class="fa fa-fw fa-trash"></i> Delete Item',
                    cancelButtonText:
                        '<i class="fa fa-fw fa-close"></i> Cancel'
                }).then(
                    function() {
                        window.location.href = '<?php echo site_url('account/deleteEstimatingItem'); ?>/' + itemId;
                    }, function (dismiss) {

                    }
                );
            
        });

        // Copy Button Click
        $(".copyItem").click(function() {
            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');
            var unitId = $(this).data('unit-id');
            var itemId = $(this).data('item-id');
            var itemName = $(this).data('item-name');
            var taxable = $(this).data('item-taxable');
            var taxRate = $(this).data('item-tax-rate');
            var unitPrice = $(this).data('item-unit-price');
            var item_capacity = $(this).data('item-capacity');
            var item_minimum_hours = $(this).data('item-minimum-hours');
            var profit_rate = $(this).data('item-profit-rate');
            var overhead_rate = $(this).data('item-overhead-rate');
            var basePrice = $(this).data('item-base-price');

            // Set the values
            $("#itemId").val('');
            $("#itemName").val(itemName + ' - COPY');
            $("#categoryId").val(categoryId);
            $("#typeId").val(typeId);
            $("#unitId").val(unitId);
            $('#taxable').prop('checked', taxable);
            $('#tax_rate').val(taxRate);
            $('#unitPrice').val('$' + unitPrice);
            $('#itemBaseCost').val(basePrice);
            $('#itemOverheadRate').val(overhead_rate);
            $('#itemProfitRate').val(profit_rate);
            $('#itemCapacity').val(item_capacity);
            console.log(number_test(item_minimum_hours));
            $('#minimumHours').val(number_test(item_minimum_hours));
            $('.unit_type_text').text(' / '+unit_name);
            // Toggle the tax checkbox
            if (taxable) {
                $("#tax_rate").show();
            } else {
                $("#tax_rate").hide();
            }
            if(typeId == truckingType){
                $("#capacityRow").show();
                $("#minimumHoursRow").show();
                $("#itemCapacity").addClass('required'); 
            }else{
                $("#capacityRow").hide();
                $("#minimumHoursRow").hide();
                $("#itemCapacity").removeClass('required');
            }

            if(typeId ==excavationType){
                $("#itemBaseCost").val(0);
                $("#itemOverheadRate").val(0);
                $("#itemProfitRate").val(0);
                $('#unitId option[data-val=Ton]').attr('selected','selected');
                $("#unitId").prop('disabled', 'disabled');
                
            }else{
                
                $("#unitId").prop('disabled', '');
                //$("#unitId").val('');
            }

            var unit_name =$("#unitId").find(':selected').attr('data-val');
            if(unit_name){
                $('.unit_type_text').text(' / '+unit_name);
            }else{
                $('.unit_type_text').text('');
            }
            //Disable category and Type select box
          
            $("#typeId").prop('disabled', 'disabled');
            $("#categoryId").prop('disabled', 'disabled');
            $(".unitRow").show();
            updateItemPrices();
            //setDropdowns();
            $.uniform.update();

            $("#estimatingItemModal").dialog('open');
            return false;
        });

        // Input Masks
        $(".currencyFormat").inputmask("decimal",
            {
                "radixPoint": ".",
                "groupSeparator":",",
                "digits":2,
                "prefix":"$",
                "autoGroup":true,
                "allowMinus": false,
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
                "allowMinus": false,
                "showMaskOnHover": false,
                "showMaskOnFocus": false,
            }
        );

        $(".numberFormat").inputmask("decimal",
            {
                "radixPoint": ".",
                "groupSeparator":",",
                "autoGroup":true,
                "digits": 2,
                "allowMinus": false,
                "showMaskOnHover": false,
                "showMaskOnFocus": false,
            }
        );

        function number_test(n)
    {
        var result = (n - Math.floor(n)) !== 0;

        if (result){
        return parseFloat(n).toFixed(2);
         }else{
        return parseInt(n);
        }


    }
        // Update prices when typing
        $("#itemBaseCost, #itemOverheadRate, #itemProfitRate").keyup(function() {
           updateItemPrices();
        });
        

        // Status checkbox changes
        $(".statusCheck").change(function() {
           updateStatusUi();
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

        // End document ready
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

        var item_id =$('#itemId').val()
        var basePrice = cleanNumber($("#itemBaseCost").val());
        var overheadRate = cleanNumber($("#itemOverheadRate").val());
        var profitRate = cleanNumber($("#itemProfitRate").val());
        var tax_rate = cleanNumber($("#tax_rate").val());
        if(!overheadRate){
            $("#itemOverheadRate").val(0);
            overheadRate=0;
        }
        if(!profitRate){
            $("#itemProfitRate").val(0);
            profitRate=0;
        }
        if(!tax_rate){
            $("#tax_rate").val(0);
            tax_rate=0;
        }
        var overheadPrice = ((basePrice * overheadRate) / 100);
        var profitPrice = ((basePrice * profitRate) / 100);
        var totalPrice = parseFloat(basePrice) + parseFloat(overheadPrice) + parseFloat(profitPrice);

       var temptaxPrice = ((totalPrice * tax_rate) / 100);
        $('.tax_amount').text('$'+addCommas(parseFloat(temptaxPrice).toFixed(2)));
        //totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);

        $(".itemOverheadPrice").text('$'+overheadPrice.toFixed(2));
        $(".itemProfitPrice").text('$'+profitPrice.toFixed(2));
       if(public_item_price != totalPrice.toFixed(2) && item_id){
            $("#updateStatusContent").show();
       }else{
            $("#updateStatusContent").hide();
       }
        $("#unitPrice").val(totalPrice.toFixed(2));
    }

    function cleanNumber(numberString) {
        
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

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

 // Unit type changes
    $("#unitId").change(function(e) {
        var unit_name =$(this).find(':selected').attr('data-val');
        $('.unit_type_text').text(' / '+unit_name);
        
        
    });


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
        //Iterate through named elements inside of the form, and mark them as error free
        $('[name]',formElement).each(function(){
        validator.successList.push(this);//mark as error free
        validator.showErrors();//remove error messages if present
        });
        validator.resetForm();//remove error class on name elements and clear history
        validator.reset();//remove all error and success data
    }
    $("#add_item_form").submit(function(e){
            $("#categoryId").prop('disabled', '');
            $("#typeId").prop('disabled', '');
            $("#unitId").prop('disabled', '');
    });



//Group action functionality

        // Group Actions Button
    $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

    /* Update the number of selected items */
    function updateNumSelected(cat_id) {
            var num = $(".item_check:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {
               // $("#groupActionIntro").show();
                $("#groupAction_"+cat_id).hide();
                //$(".groupActionsContainer").hide();
            }
            else {
                //$("#groupActionIntro").hide();
                $("#groupAction_"+cat_id).show();
            }

            //$("#numSelected").html(num);
        }

     // Update the counter after each change
     $(".item_check").live('change', function () {
         var cat_id = $(this).data('category-type-id');
        
            updateNumSelected(cat_id);
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                
                $(this).closest('table').find(".item_check").prop('checked', true);
            }else{
                
                $(this).closest('table').find(".item_check").prop('checked', false);
            }
            var cat_id = $(this).data('category-type-id');
            updateNumSelected(cat_id);
            $.uniform.update();
            //return false;
        });

        // None
        // $("#selectNone").live('click', function () {
        //     $(".groupSelect").attr('checked', false);
        //     updateNumSelected();
        //     return false;
        // });

        // Update the counter after each change
        $(".groupSelect").live('change', function () {
            updateNumSelected();
        });

        // Delete Click
        $('.groupDelete').click(function(){
            var item_type =$(".item_check:checked").attr('data-category-type-id');
            if(item_type=='12' || item_type=='11'){
                var all_item_count =$(".item_check[data-category-type-id='"+item_type+"']").length;
                
                if(all_item_count == $(".item_check:checked").length){
                    swal('','You must have at least one of these items for calculators to work.');
                }else{
                    $("#delete-Items").dialog('open');
                    $("#deleteNum").html($(".item_check:checked").length);
                }
            }else{
                $("#delete-Items").dialog('open');
                $("#deleteNum").html($(".item_check:checked").length);
            }
           
        });

        /* Create an array of the selected IDs */
        function getSelectedItemIds() {

            var IDs = new Array();

            $(".item_check:checked").each(function () {
                IDs.push($(this).data('item-id'));
            });

            return IDs;
        }

// Item Delete Update
    $("#delete-items-status").dialog({
            width: 500,
            modal: true,
            beforeClose: function (e, ui) {
                //location.reload();
            },
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                    //location.reload();
                }
            },
            autoOpen: false
        });

        // Delete dialog
        $("#delete-Items").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Items',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedItemIds()},
                            url: "<?php echo site_url('ajax/itemsGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Items were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getSelectedItemIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                   var row =  $("tr#items_" + itemIds[$i]);
                                   var table = $(row).closest('table');
                                   table.DataTable().row(row).remove().draw();
                                   var typeId = table.data('type-id');
                                   $('.items_count[data-type-id="' + typeId+'"]').text(table.DataTable().rows().count());
                                   //table.closest('.accordionHeader').find('.items_count').text(table.DataTable().rows().count())
                                   console.log(table.DataTable().rows().count());

                                }
                                $("#deleteItemsStatus").html(deleteText);
                                $("#delete-items-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteItemsStatus").html('Deleting Items...<img src="/static/loading.gif" />');
                        $("#delete-items-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
</script>