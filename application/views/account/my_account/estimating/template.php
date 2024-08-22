<style type="text/css">
    tr.inTemplate td { background-color: rgba(84, 179, 81, 0.57) !important;}

    #defaultsDialog td { padding: 5px; }
    #defaultsDialog label { font-weight: bold; }

</style>
<?php /* @var \models\EstimationTemplate $template */  ?>
<h3>
    Editing Estimate Assembly - <?php echo $template->getName(); ?>
    <a href="<?php echo site_url('account/estimating_templates'); ?>" class="btn blue-button right">
        <i class="fa fa-fw fa-chevron-left"></i> Back to Assemblies
    </a>
    <div class="clearfix"></div>
</h3>

<div class="clearfix" style="padding: 20px;">

    <div id="estimateTemplateTabs">
        <ul>
            <li>
                <a href="#existingItems">
                    <i class="fa fa-fw fa-list"></i> Assembly Items
                </a>
            </li>
            <li>
                <a href="#allItems">
                    <i class="fa fa-fw fa-search"></i> Add Items
                </a>
            </li>
        </ul>
        <div id="existingItems">
            <table id="estimateTemplateItems" style="width: 100%" class="display">
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Item</th>
                    <?php if(!$template->getFixed()){?><th >Days</th><?php }?>
                    <th>Qty</th>
                    <?php if(!$template->getFixed()){?><th>Hrs/Day</th><?php }?>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="allItems">

            <div class="clearfix"></div>
            <div class="estimatePriceReportFilters">

                <strong><span style="position: relative; top: 3px; float: left; margin-right: 20px">
            Category Filters</span></strong>

                <!-- <div class="estimatePriceReportFilter">
                    <label>
                        <input type="checkbox" class="filterCategory" value="1">
                        <span style="position: relative; top: 3px;">Material</span>
                    </label>
                </div> -->

                <div class="estimatePriceReportFilter">
                    <label>
                        <input type="checkbox" class="filterCategory" value="2">
                        <span style="position: relative; top: 3px;">Equipment</span>
                    </label>
                </div>

                <div class="estimatePriceReportFilter">
                    <label>
                        <input type="checkbox" class="filterCategory" value="3">
                        <span style="position: relative; top: 3px;">Labor</span>
                    </label>
                </div>

                <div class="estimatePriceReportFilter">
                    <label>
                        <input type="checkbox" class="filterCategory" value="5">
                        <span style="position: relative; top: 3px;">Services</span>
                    </label>
                </div>

                <div class="clearfix"></div>

            </div>
            <br />

            <table id="allItemsTable" style="width: 100%" class="display">
                <thead>
                <tr>
                    <th><i class="fa fafw fa-check-circle"></i></th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Item</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>

<div id="defaultsDialog">

    <div class="content-box" id="add-type">
        <div class="box-header">
            Default Values: <?php echo $template->getName(); ?>
        </div>
        <div class="box-content" style="padding: 20px;">

            <p style="font-weight: bold">
                <span id="itemCategoryName"></span> / <span id="itemTypeName"></span> / <span id="itemName"></span>
            </p><br />
            <form id="defaultsValuesForm">
            <input type="hidden" id="eti" value="" />
            <table width="100%" class="boxed-table2">
            <?php if(!$template->getFixed()){?>
                <tr>
                    <td><label>Default Days:</label></td>
                    <td><input type="number" class="text" id="defaultDays" name="defaultDays" /></td>
                </tr>
            <?php }?>
                <tr>
                    <td><label>Default Quantity:</label></td>
                    <td><input type="number" class="text" id="defaultQty" name="defaultQty" /></td>
                </tr>
            <?php if(!$template->getFixed()){?>
                <tr>
                    <td><label>Default Hours Per Day:</label></td>
                    <td><input type="number" class="text" id="defaultHpd" name="defaultHpd" /></td>
                </tr>
            <?php }?>
            </table>
            </form>
        </div>
    </div>
    <p class="if_error_show_msg" style="text-align: center; border: 2px solid red; padding: 7px 10px; width:93%; font-weight: bold; float: left; border-radius: 5px; font-size: 14px; display: none;">Value must be a whole number above zero</p>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js" ></script>
<script type="text/javascript">

    var itemsTable;
    var allItemsTable;

    $(document).ready(function() {

        // $("#defaultsValuesForm").validate({
        //     rules: {
        //         defaultDays: "required",
        //         defaultQty:  "required",
        //         defaultHpd:  "defaultHpd",
        //     },
        //     messages: {
        //         defaultDays: "Please specify your name",
        //         defaultQty: "Please specify your name",
        //         defaultHpd: "Please specify your name",
            
        //     }
        // });
        <?php if(!$template->getFixed()){?>
        $('#defaultsValuesForm').validate({
            rules: {
                defaultDays: {
                    required: true,
                    min: 1,
                    number: true
                },
                defaultQty: {
                    required: true,
                    min: 1,
                    number: true
                },
                defaultHpd: {
                    required: true,
                    min: 1,
                    number: true
                }
            },
            submitHandler: function (form) { 
            
            }
        });
    <?php }else{?>
        $('#defaultsValuesForm').validate({
            rules: {
               
                defaultQty: {
                    required: true,
                    min: 1,
                    number: true
                }
            },
            submitHandler: function (form) { 
            
            }
        });
        <?php } ?>
        // Tabs
        $("#estimateTemplateTabs").tabs();

        // Dialogs
        $("#defaultsDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 400,
            buttons: {
                "Cancel": {
                    html: '<i class="fa fa-fw fa-close"></i> Cancel',
                    'class': 'btn left',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                "Save": {
                    html: '<i class="fa fa-fw fa-save"></i> Save Defaults',
                    'class': 'btn blue-button',
                    click: function () {
                        if($('#defaultsValuesForm').valid()){
                            $('.if_error_show_msg').hide();
                            $.ajax({
                            type: "POST",
                            url : "<?php echo site_url('ajax/saveTemplateItemDefaults') ?>",
                            data: {
                                eti: $("#eti").val(),
                                qty: $("#defaultQty").val(),
                                hpd: $("#defaultHpd").val(),
                                days: $("#defaultDays").val()
                            },
                            dataType: 'json'
                        })
                        .done(function() {
                            $("#defaultsDialog").dialog('close');
                            swal("Defaults Saved");
                            itemsTable.ajax.reload();
                            allItemsTable.ajax.reload();
                        })
                        .fail(function() {
                            swal('An error occurred');
                        });

                        }else{
                            $('.if_error_show_msg').show();
                            console.log(false);
                        }
                        

                        
                    }
                }
            }
        });


        // Template Items Table
        itemsTable = $("#estimateTemplateItems").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "scrollCollapse": true,
            "ordering:": false,
            "ajax" : {
                "url": "<?php echo site_url('ajax/estimateTemplateItems/' . $template->getId()); ?>",
                "type": "GET"
            },
            "aoColumns": [
                {'bSearchable': true, 'orderable': false, 'class': 'dtCenter' },
                {'bSearchable': true, 'orderable': false },
                {'bSearchable': true, 'orderable': false },
                {'bSearchable': false, 'orderable': false },
                <?php if(!$template->getFixed()){?> {'bSearchable': false, 'orderable': false, 'class': 'dtCenter' },{'bSearchable': false, 'orderable': false, 'class': 'dtCenter' },<?php }?>
               
                
                {'bSearchable': false, 'orderable': false, 'class': 'dtCenter' },
                {'bSearchable': false, 'orderable': false }
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "sDom": 'Ht',
            "drawCallback" : function() {
                initButtons();
                initTiptip();
            }
        });

        // All items / search Table
        allItemsTable = $("#allItemsTable").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "scrollCollapse": true,
            "lengthMenu": [[-1, 10, 25, 50, ], ["All", 10, 25, 50]],
            "order": [[3, "asc"]],
            "ajax" : {
                "url": "<?php echo site_url('ajax/estimateItemsLookup/' . $template->getId()); ?>",
                "type": "GET",
                data: function(d) {
                    d.categories = getFilterCategories()
                }
            },
            "aoColumns": [
                {'bSearchable': false, 'bSortable': true, 'class': 'dtCenter'},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': true},
                {'bSearchable': false, 'bSortable': false}
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "sDom": 'Hlftipr',
            "drawCallback" : function() {
                initButtons();
                initTiptip();
            }
        });

       
        $(document).on("keyup","#defaultDays,#defaultQty,#defaultHpd",function() {
           
            if($('#defaultsValuesForm').valid()){
                $('.if_error_show_msg').hide();
            }else{
                $('.if_error_show_msg').show();
            }
        })

        // Add Item to template
        $(document).on('click', '.addItemToTemplate', function() {
            var itemId = $(this).data('item-id');

            $.ajax({
                type: "POST",
                url : "<?php echo site_url('ajax/addItemToTemplate') ?>",
                data: {
                    templateId: <?php echo $template->getId() ?>,
                    itemId: itemId
                },
                dataType: 'json'
            })
            .done(function() {
                swal("Item Added to Assembly");
                itemsTable.ajax.reload();
                allItemsTable.ajax.reload();
            })
            .fail(function() {
                swal('An error occurred');
            });

            return false;
        });

        // Add Item to Assembly
        $(document).on('click', '.deleteTemplateItem', function() {
            var itemId = $(this).data('item-id');

            swal({
                title: 'Remove Assembly Item',
                html: '<p>Are you sure you want to remove this item?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Remove Item',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {

                    $.ajax({
                        type: "POST",
                        url : "<?php echo site_url('ajax/deleteTemplateItem') ?>",
                        data: {
                            templateId: <?php echo $template->getId() ?>,
                            itemId: itemId
                        },
                        dataType: 'json'
                    }).done(function() {
                            swal("Item Removed from Assembly");
                            itemsTable.ajax.reload();
                            allItemsTable.ajax.reload();
                        })
                        .fail(function() {
                            swal('An error occurred');
                        });

                    
                }, function (dismiss) {
                   
                }
            );

            
            return false;
        });

        // Sortable items
        $("#estimateTemplateItems tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationTemplateItemOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });


        // Set Defaults link
        $(document).on('click', ".setItemDefaults", function() {

            // Grab the defaults
            var defaultQty = $(this).data('default-qty');
            var defaultHpd = $(this).data('default-hpd');
            var defaultDays = $(this).data('default-days');

            // Populate form
            $("#eti").val($(this).data('eti'));
            $("#defaultQty").val(defaultQty);
            $("#defaultHpd").val(defaultHpd);
            $("#defaultDays").val(defaultDays);

            // Update breadcrumb
            $("#itemCategoryName").text($(this).data('category'));
            $("#itemTypeName").text($(this).data('type'));
            $("#itemName").text($(this).data('item-name'));
            $("#defaultQty,#defaultHpd,#defaultDays").removeClass('error');
            $(".if_error_show_msg").hide();
            

            $("#defaultsDialog").dialog('open');
            return false;
        });

        // Reload table on fitler change
        $(".filterCategory").change(function() {
            allItemsTable.ajax.reload();
        });

        // End document ready
    });

    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    function getFilterCategories() {
        var filterCategories = [];

        $(".filterCategory:checked").each(function() {
            filterCategories.push($(this).val());
        });

        return filterCategories;
    }

</script>