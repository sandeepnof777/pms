<style type="text/css">
    tr.inTemplate td { background-color: rgba(84, 179, 81, 0.57) !important;}

</style>
<?php /* @var \models\EstimationCrew $crew */  ?>
<h3>
    Editing Estimate Crew - <?php echo $crew->getName();?>
    <a href="<?php echo site_url('account/estimating_crews'); ?>" class="btn blue-button right">
        <i class="fa fa-fw fa-chevron-left"></i> Back to Crew
    </a>
    <div class="clearfix"></div>
</h3>

<div class="clearfix" style="padding: 20px;">

    <div id="estimatecrewTabs">
        <ul>
            <li>
                <a href="#existingItems">
                    <i class="fa fa-fw fa-list"></i> Crew Items
                </a>
            </li>
            <li>
                <a href="#allItems">
                    <i class="fa fa-fw fa-search"></i> Item Search
                </a>
            </li>
        </ul>
        <div id="existingItems">
            <table id="estimatecrewItems" style="width: 100%" class="display">
                <thead>
                <tr>
                    <th>Order</th>
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
        <div id="allItems">

            <div class="clearfix"></div>
            <div class="estimatePriceReportFilters">

                <strong><span style="position: relative; top: 3px; float: left; margin-right: 20px">
            Category Filters</span></strong>

                <div class="estimatePriceReportFilter">
                    <label>
                        <input type="checkbox" class="filterCategory" value="1">
                        <span style="position: relative; top: 3px;">Material</span>
                    </label>
                </div>

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
                        <input type="checkbox" class="filterCategory" value="4">
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
            Crew Item Defaults
        </div>
        <div class="box-content" style="padding: 20px;">

            <p style="font-weight: bold">
                <span id="itemCategoryName"></span> / <span id="itemTypeName"></span> / <span id="itemName"></span>
            </p><br />

            <input type="hidden" id="eti" value="" />
            <table width="100%">
                <tr>
                    <td><label>Default Quantity:</label></td>
                    <td><input type="number" id="defaultQty" /></td>
                </tr>
                <tr>
                    <td><label>Default Hours Per Day:</label></td>
                    <td><input type="number" id="defaultHpd" /></td>
                </tr>
                <tr>
                    <td><label>Default Days:</label></td>
                    <td><input type="number" id="defaultDays" /></td>
                </tr>
            </table>

        </div>
    </div>

</div>

<script type="text/javascript">

    var itemsTable;
    var allItemsTable;

    $(document).ready(function() {

        // Tabs
        $("#estimatecrewTabs").tabs();

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

                        $.ajax({
                            type: "POST",
                            url : "<?php echo site_url('ajax/saveCrewItemDefaults') ?>",
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

                    }
                }
            }
        });


        // crew Items Table
        itemsTable = $("#estimatecrewItems").DataTable({
            "bProcessing": true,
            "serverSide": true,
            "scrollCollapse": true,
            "ordering:": false,
            "ajax" : {
                "url": "<?php echo site_url('ajax/estimateCrewItems/' . $crew->getId()); ?>",
                "type": "GET"
            },
            "aoColumns": [
                {'bSearchable': true, 'orderable': false, 'class': 'dtCenter' },
                {'bSearchable': true, 'orderable': false },
                {'bSearchable': true, 'orderable': false },
                {'bSearchable': false, 'orderable': false },
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
                "url": "<?php echo site_url('ajax/estimateCrewItemsLookup/' . $crew->getId()); ?>",
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

        // Add Item to crew
        $(document).on('click', '.addItemToCrew', function() {
            var itemId = $(this).data('item-id');
console.log('adf');
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('ajax/addItemTocrew') ?>",
                data: {
                    crewId: <?php echo $crew->getId() ?>,
                    itemId: itemId
                },
                dataType: 'json'
            })
            .done(function() {
                swal("Item Added to crew");
                itemsTable.ajax.reload();
                allItemsTable.ajax.reload();
            })
            .fail(function() {
                swal('An error occurred');
            });

            return false;
        });

        // Add Item to crew
        $(document).on('click', '.deleteCrewItem', function() {
            var itemId = $(this).data('item-id');

            $.ajax({
                type: "POST",
                url : "<?php echo site_url('ajax/deleteCrewItem') ?>",
                data: {
                    crewId: <?php echo $crew->getId() ?>,
                    itemId: itemId
                },
                dataType: 'json'
            })
                .done(function() {
                    swal("Item Removed from crew");
                    itemsTable.ajax.reload();
                    allItemsTable.ajax.reload();
                })
                .fail(function() {
                    swal('An error occurred');
                });

            return false;
        });

        // Sortable items
        $("#estimatecrewItems tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationcrewItemOrder') ?>",
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