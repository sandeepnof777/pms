<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
        <div class="widthfix">
<style>
.ui-state-active{
    color:#ffffff!important;
}
</style>
<h3>Estimation Types</h3>
<!-- <p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Types. You can add, edit, delete and reorder.</p> -->
<!------------------------------->
<div style="padding: 1em 1.4em;">
<div id="categoryTabs">
    <ul>
        <?php foreach ($categories as $category) : 
        if($category->getId() != models\EstimationCategory::CUSTOM ){?>
            <li><a href="#categoryTab<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a></li>
        <?php } endforeach; ?>
    </ul>
     <!---Start Filter button---->
     <div class="materialize" style="position: absolute;width: 275px;top: 4px;right: 5px;white-space: nowrap;">
                                                    
                                                    <div class="m-btn groupAction tiptip" id="typeGroupAction" style="position: absolute;display:none;font-size: 14px;" title="Carry out actions on selected Types" >
                                                        <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                                                        <div class="groupActionsContainer materialize" style="width:160px">
                                                            <div class="collection groupActionItems" >
                                                                
                                                                <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                                                                    <i class="fa fa-fw fa-trash"></i> Delete Types
                                                                </a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="filterBadges"></div>
                                                    <div class="clearfix"></div>
                                                    <a class="m-btn " id="addNewType" href="#" style="position: absolute;right:0px">
                                                        <i class="fa fa-fw fa-plus"></i> Add Type
                                                    </a>
                                                </div>
                                                    <!---End Filter button---->
    <?php foreach ($categories as $category) : 
         if($category->getId() != models\EstimationCategory::CUSTOM ){?>
        <div id="categoryTab<?php echo $category->getId(); ?>">
                   
        <div>
                        
                        <?php if (count($types[$category->getId()])) : ?>
                        <table id="itemsCat<?php echo $category->getId(); ?>" class="estimatingItemsTable" data-category-id="<?php echo $category->getId(); ?>">
                            <thead>
                                <tr>
                                <th width="3%"><input type="checkbox" class="check_all" data-category-id="<?php echo $category->getId(); ?>"></th>
                                    <th width="20"></td>
                                    <th>Type Name</td>
                                    <th width="100">Actions</td>
                                </tr>
                            </thead>
                            <tbody >
                            <?php foreach ($types[$category->getId()] as $type)  : ?>
                                <?php /* @var $typeItem \models\EstimationItem */ ?>
                                <tr id="types_<?php echo $type->getId(); ?>">
                                <td><input type="checkbox" class="type_check" data-type-id="<?php echo $type->getId(); ?>" data-category-id="<?php echo $category->getId(); ?>"></td>
                                    <td>
                                        <a class="handle">
                                            <i class="fa fa-fw fa-sort"></i>
                                        </a>
                                    </td>
                                    <td><?php echo $type->getName(); ?></td>
                                    <td>
                                        <?php //if($type->getCompanyId()) : ?>
                                        <a href="#" class="btn tiptip editType" title="Edit <?php echo $type->getName(); ?> Type"
                                            data-type-id="<?php echo $type->getId(); ?>"
                                            data-type-name="<?php echo $type->getName(); ?>"
                                            data-category-id="<?php echo $category->getId(); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php //endif; ?>
                                        <!-- <a href="#" class="btn tiptip deleteType" title="Delete <?php echo $type->getName(); ?> Type"
                                        data-type-id="<?php echo $type->getId(); ?>">
                                            <i class="fa fa-trash"></i>
                                        </a> -->
                                        <a href="#" class="btn tiptip assignType" title="Assign Services"
                                            data-type-id="<?php echo $type->getId(); ?>"
                                            data-type-name="<?php echo $type->getName(); ?>">
                                            <i class="fa fa-list"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else : ?>
                            <br />
                            <p>There are no type in this category</p>
                        <?php endif; ?>
                    </div>
        </div>
    <?php } endforeach; ?>
</div>
</div>
</div>
<div id="estimatingTypeDialog">

    <div class="content-box" id="add-type">
        <div class="box-header">
            Save Estimating Type
        </div>
        <div class="box-content">
            <form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post"
                  action="<?php echo site_url('admin/saveEstimatingType') ?>">
                <input type="hidden" name="typeId" id="typeId" />
                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
                    <tbody>
                    <tr>
                        <td width="50%">
                            <p class="clearfix left">
                                <label>Category</label>
                                <select name="categoryId" id="categoryId" class="required">
                                    <option value="">-- Select Category</option>
                                    <?php
                                    foreach ($categories as $cat) {
                                        ?>
                                        <option value="<?php echo $cat->getId() ?>"><?php echo $cat->getName() ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix left">
                                <label>Type Name <span>*</span></label>
                                <input type="text" value="" id="typeName" name="typeName"
                                       class="text required" tabindex="2">
                            </p>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <label>&nbsp;</label>
                            <button type="submit" class="btn blue-button" role="button" id="addType">
                                <i class="fa fa-fw fa-save"></i> Save Type
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</div>
    
<div id="servicesDialog">

    <h3>Assign Categories to Type: <span id="assignTypeName"></span></h3>
    
    <div class="clearfix"></div>

    <div id="assignLoading" style="display: none; text-align: center;">
        <img src="/static/loading_animation.gif" />
    </div>

    <a href="#" id="checkAll">All</a> / <a href="#" id="checkNone">None</a>
    <div class="clearfix"></div>

    <input type="hidden" id="assignTypeId">

    <?php foreach ($services as $category) : ?>
        <div class="serviceTypeCheckContainer">
            <label>
                <input type="checkbox" class="serviceCheck" data-service-id="<?php echo $category->getServiceId() ?>"
                       value="<?php echo $category->getServiceId() ?>" />
                <span style="position: relative; top: 3px;"><?php echo $category->getServiceName(); ?></span>
            </label>

        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <hr />

    <a class="left btn btn-default" href="#" id="cancelAssign">
        <i class="fa fa-fw fa-close"></i> Cancel
    </a>

    <a class="right btn blue-button" href="#" id="saveAssignments">
        <i class="fa fa-fw fa-save"></i> Save Assignments
    </a>

</div>

    <!-- Confirm delete dialog -->
<div id="delete-Types" title="Confirmation">
    <h3>Confirmation - Delete Types</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> types.</p>
    <br/>
    <p><strong>Types used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-types-status" title="Confirmation">
    <h3>Confirmation - Delete Types</h3>

    <p id="deleteTypesStatus"></p>
</div>


<?php $this->load->view('global/footer'); ?>




<script>
    $(document).ready(function () {

var openTab = localStorage.getItem('selectedTabId');


// Tabs for layout
$("#categoryTabs").tabs({
    active: 0,
    activate : function(event, ui) {
        var selectedTabId = ui.newPanel.selector;
        if(hasLocalStorage){
            localStorage.setItem('selectedTabId', selectedTabId);
        }
    }
});

// Open the last one
if (openTab) {
    $('#categoryTabs').tabs("select", openTab);

    setTimeout(function() {
        if (openTab) {
            $(openTab).trigger('click');
        }
    }, 100);
}



// Accordion functionality
$(".sortable-types").hide();
$(".cat a").click(function () {
    var rel = $(this).attr('rel');
    var id = $(this).attr('id');
    if ($(this).find('span').hasClass('ui-icon-plus')) {
        $(".cat a span").removeClass('ui-icon-minus').addClass('ui-icon-plus');
        $(".sortable-types").hide();
        $(this).find('span').removeClass('ui-icon-plus').addClass('ui-icon-minus');
        $(rel).fadeIn();
        if(hasLocalStorage){
            localStorage.setItem('openTypesPanel', id);
        }

    } else {
        $(".cat a span").removeClass('ui-icon-minus').addClass('ui-icon-plus');
        $(rel).fadeOut();
    }
    return false;
});

// Open the last panel
if (localStorage.getItem('openTypesPanel')) {
    var panelId = localStorage.getItem('openTypesPanel');
    $("#" + panelId).trigger('click');
}

// Sortable types
$("table.estimatingItemsTable tbody").sortable({
//$(".sortable-types").sortable({
    helper: fixHelper,
    handle:".handle",
    stop:function () {
        var postData = $(this).sortable("serialize");
        $.ajax({
            type:"POST",
            url:"<?php echo site_url('ajax/updateEstimationTypeDefaultOrder') ?>",
            data:postData,
            async:false
        });
    }
});

// Form modal
$("#estimatingTypeDialog").dialog({
    modal: true,
    autoOpen: false,
    width: 500
});

// Form for adding
$("#addNewType").click(function() {

    $("#typeId").val('');
    $("#categoryId").val('');
    $("#typeName").val('');

    $.uniform.update();

    $("#estimatingTypeDialog").dialog('open');
    return false;
});

// Form for editing
$(".editType").click(function() {

    $("#typeId").val($(this).data('type-id'));
    $("#categoryId").val($(this).data('category-id'));
    $("#typeName").val($(this).data('type-name'));

    $.uniform.update();

    $("#estimatingTypeDialog").dialog('open');
    return false;
});

// Delete button
$(".deleteType").click(function() {

    var typeId= $(this).data('type-id');

    swal({
        title: 'Delete Type',
        html: '<p>Are you sure you want to delete this type?</p>',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText:
            '<i class="fa fa-fw fa-trash"></i> Delete Type',
        cancelButtonText:
            '<i class="fa fa-fw fa-close"></i> Cancel'
    }).then(
        function() {
            window.location.href = '<?php echo site_url('account/deleteEstimatingType'); ?>/' + typeId;
        }, function (dismiss) {

        }
    );

    return false;
});

// Services Dialog
$("#servicesDialog").dialog({
    modal: true,
    autoOpen: false,
    width: 650
});

// Open Service Dialog
$(".assignType").click(function() {

    // SHow the loader
    $("#assignLoading").show();

    // Grab the vars
    var typeId = $(this).data('type-id');
    var typeName = $(this).data('type-name');

    // Clear all checkboxes
    $(".serviceCheck").prop('checked', false);

    // Load the title and form
    $("#assignTypeId").val(typeId);
    $("#assignTypeName").text(typeName);

    // Grab the assigned services for this type
    $.ajax({
        type: "POST",
        async: true,
        cache: false,
        data: {
            'typeId' : typeId
        },
        url: "<?php echo site_url('ajax/getAdminCompanyServiceTypeAssignments'); ?>",
        dataType: "JSON"
    })
    .success(function (data) {
        if (!data.error) {

            $.each(data.services, function(idx, val) {
                $('.serviceCheck[data-service-id="' + val + '"]').prop('checked', true);
            });

            $.uniform.update();

        } else {
            swal(data.message);
            console.log(data.debug);
        }

        $("#assignLoading").hide();
    });
    
    // Open the dialog
    $("#servicesDialog").dialog('open');
    return false;
});

$("#cancelAssign").click(function() {
    $("#servicesDialog").dialog('close');
    return false;
});


$("#saveAssignments").click(function() {

    var typeId = $("#assignTypeId").val();

    $.ajax({
        type: "POST",
        async: true,
        cache: false,
        data: {
            'typeId' : typeId,
            'serviceIds': getSelectedIds()
        },
        url: "<?php echo site_url('ajax/adminCompanyServiceTypeAssign'); ?>",
        dataType: "JSON"
    })
    .success(function (data) {
        if (!data.error) {
            $("#servicesDialog").dialog('close');
            swal('Assignments Saved');
        } else {
            $("#servicesDialog").dialog('close');
            swal(data.message);
            console.log(data.debug);
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

// End document ready
});

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    /* Create an array of the selected IDs */
    function getSelectedIds() {

        var IDs = new Array();

        $(".serviceCheck:checked").each(function () {
            IDs.push($(this).data('service-id'));
        });

        return IDs;
    }

    /* Create an array of the selected IDs */
    function getTypesSelectedIds() {

        var IDs = new Array();

        $(".type_check:checked").each(function () {
            IDs.push($(this).data('type-id'));
        });

        return IDs;
    }



// Accordions
$(".accordionContainer").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "h3",
            beforeActivate : function (event, ui) {
                if (ui.newHeader[0]) {
                    var selectedAccordionId = ui.newHeader[0].id;
                    if(hasLocalStorage){
                        localStorage.setItem('selectedAccordionId', selectedAccordionId);
                    }
                } else {
                    localStorage.removeItem('selectedAccordionId');
                }
                $('.type_check').prop('checked',false);
                $('.check_all').prop('checked',false);
                $(".groupAction").hide();
                $.uniform.update();
            }
        });
        $(".estimatingItemsTable").DataTable({
            ordering : false,
            searching : false,
            paging: false,
            bJqueryUi : true,
            deferLoading: 0
        });

//Group action functionality

        // Group Actions Button
        $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

/* Update the number of selected items */
function updateNumSelected() {
            var num = $(".type_check:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {
               // $("#groupActionIntro").show();
                $("#typeGroupAction").hide();
                //$(".groupActionsContainer").hide();
            }
            else {
                //$("#groupActionIntro").hide();
                $("#typeGroupAction").show();
            }

            //$("#numSelected").html(num);
        }


     // Update the counter after each change
     $(".type_check").live('change', function () {
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                console.log('ttt');
                $(this).closest('table').find(".type_check").prop('checked', true);
            }else{
                console.log('fff');
                $(this).closest('table').find(".type_check").prop('checked', false);
            }
            
            updateNumSelected();
            $.uniform.update();
            //return false;
        });

// Delete Click
$('.groupDelete').click(function(){
            $("#delete-Types").dialog('open');
            $("#deleteNum").html($(".type_check:checked").length);
        });

    // Item Delete Update
    $("#delete-types-status").dialog({
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
        $("#delete-Types").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Types',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getTypesSelectedIds()},
                            url: "<?php echo site_url('ajax/typesGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Types were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getTypesSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                   var row =  $("tr#types_" + itemIds[$i]);
                                   var table = $(row).closest('table');
                                   table.DataTable().row(row).remove().draw();
                                   var categoryId = table.data('category-id');
                                   $('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());
                                   updateNumSelected();

                                }
                                $("#deleteTypesStatus").html(deleteText);
                                $("#delete-types-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteTypesStatus").html('Deleting Items...<img src="/static/loading.gif" />');
                        $("#delete-types-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        }); 
</script>