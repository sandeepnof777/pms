<!--<a href="<?php echo site_url('account/services/add'); ?>" class="btn ui-button update-button" style="float: right;">Add New Service</a>-->
<h3>All Services</h3>


    <?php
   // echo "<pre> categories";print_r($categories);
   // echo " <pre>services ";print_r($services);die;
    foreach ($categories as $cat) {
        ?>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    </thead>
    <tbody class="service-sortable" data-category-id="<?php echo $cat->getServiceId(); ?>"> 
        <tr class="odd">
            <td colspan="3">
                <span class="companyServiceHeading"><?php echo $cat->getServiceName() ?></span>
                    <a id="disableService_<?php echo $cat->getServiceId() ?>" class="tiptip disableService box-action small red-button right" style="<?php echo (in_array($cat->getServiceId(), $disabledServices)) ? 'display: none;' : ''; ?>" rel="<?php echo $cat->getServiceId() ?>" href="#" title="Disable (Not show on the Edit Proposal Page)"> Turn Off</a>
                    <a id="enableService_<?php echo $cat->getServiceId() ?>" class="tiptip enableService box-action small update-button right" style=" <?php echo (in_array($cat->getServiceId(), $disabledServices)) ? '' : 'display:none;'; ?>" rel="<?php echo $cat->getServiceId() ?>" href="#" title="Enable (Not shown on the Edit Proposal Page!">Turn On</a>
            </td>
        </tr>
        <?php
        if (isset($services[$cat->getServiceId()])) {
            $k = 0;
            foreach ($services[$cat->getServiceId()] as $service) {
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'alt' : ''; ?> catService_<?php echo $cat->getServiceId() ?><?php echo (in_array($service->getServiceId(), $disabledServices)) ? ' serviceDisabled' : ''; ?>" id="services_<?php echo $service->getServiceId(); ?>" style="<?php echo (in_array($cat->getServiceId(), $disabledServices)) ? 'display:none;' : ''; ?>">
                    <td width="10%"><span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;" title="Drag to sort"></span></td>
                    <td style="border-right: 1px solid #EEEEEE;" width="60%">
                        <?php echo $service->getCompany() ? '[C] ' : '' ?>
                        <?php echo (isset($service_titles[$service->getServiceId()])) ? $service_titles[$service->getServiceId()] : $service->getServiceName() ?></td>
                    <td width="30%" style="text-align: center">

                    <?php if($account->hasEstimatingPermission()){?>
                        <a href="#" class="tiptip btn estimateFields" style="display: inline-block" title="Estimating Fields"
                            data-service-id="<?php echo $service->getServiceId(); ?>"
                            data-service-name="<?php echo $service->getServiceName(); ?>"
                            data-category-id="<?php echo $cat->getServiceId(); ?>">
                            <i class="fa fa-fw fa-list"></i>
                        </a>
                    <?php } ?>
                        <a href="<?php echo site_url('account/edit_service/' . $service->getServiceId()) ?>" class="tiptip btn-edit" style="display: inline-block" title="Edit Service">&nbsp;</a>
                        <a href="<?php echo site_url('account/duplicate_service/' . $service->getServiceId()) ?>" class="tiptip btn-duplicate" style="display: inline-block" title="Duplicate Service">&nbsp;</a>
                        <?php if ($service->isEnabled($account->getCompany()->getCompanyId())) {?>
                        <a href="<?php echo site_url('account/disable_service/' . $service->getServiceId()) ?>" class="tiptip btn-disabled templateDisable" data-service-id="<?php echo $service->getServiceId(); ?>" style="display: inline-block" title="Disable Service">&nbsp;</a>
                        <?php } else { ?>
                            <a href="<?php echo site_url('account/enable_service/' . $service->getServiceId()) ?>" class="tiptip btn-enabled" data-service-id="<?php echo $service->getServiceId(); ?>" style="display: inline-block" title="Enable Service">&nbsp;</a>
                        <?php } ?>
                        <?php if ($service->getCompany() == $account->getCompany()->getCompanyId()) {?>
                        <a href="#" class="tiptip serviceDelete btn-delete" style="display: inline-block" title="Delete Service" data-service-id="<?php echo $service->getServiceId(); ?>">&nbsp;</a>
                        <?php } ?>

                    </td>
                </tr>
            <?php
            }
        }
        ?>
    </tbody>
</table>
    <?php
    }
    ?>

<!-- Delete Service Dialog -->
<div id="confirm-delete-service" title="Confirm" data-service-id="">
    <p><strong>Are you sure you want to delete this service?</strong></p><br />

    <p>This will remove the service from future use in any proposals.</p><br />

    <p>Existing proposals containing this service will not be affected.</p><br />

    <p><strong>This action cannot be undone!</strong></p>
</div>

<!-- Estimating fields dialog -->
<div id="estimatingServiceFieldsDialog" title="Edit Estimating Service Fields">
    <h3>Estimation Fields: <span id="estimateFieldsServiceName"></span></h3>

    <form id="estimationFieldsForm">
        <input type="hidden" name="serviceId" id="serviceId" />
        <table id="estimationFieldsTable">
            <thead>
            <tr>
                <th>Field</th>
                <th>Measurement</th>
                <th>Unit</th>
                <th>Excavation Depth</th>
                <th>Base Depth</th>
                <th>Depth</th>
                <th>Gravel Depth</th>
                <th>Area</th>
                <th>Qty</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>


<script type="text/javascript">
    $(document).ready(function () {
    

        // Clicks on enabling and disabling services
        $(".disableService, .enableService").live('click', function () {
            var id = $(this).attr('rel');
            var action = 'enable';
            if ($(this).hasClass('disableService')) {
                action = 'disable';
                $("#disableService_" + id).hide();
                $("#enableService_" + id).show();
                $(".catService_" + id).hide();
            } else {
                $("#disableService_" + id).show();
                $("#enableService_" + id).hide();
                $(".catService_" + id).show();
            }
            $.ajax({
                url: '<?php echo site_url('ajax/enableService') ?>',
                type: 'POST',
                data: {
                    service: id,
                    action: action
                }
            });
            return false;
        });


        // Sortable statuses
        $('.service-sortable').sortable({
                handle: '.handle',
                start: function(){
                },
                stop: function () {
                    var categoryId = $(this).data('category-id');
                    var ordered_data = $(this).sortable("serialize");

                    $.ajax({
                        url: '<?php echo site_url('ajax/orderCompanyServices') ?>/' + categoryId,
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                }
            }
        );

        // Delete Service Dialog
        $("#confirm-delete-service").dialog({
            width: 400,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete',
                    'class': 'btn ui-button update-button',
                    click: function () {
                        window.location.href = '<?php echo site_url('account/delete_service'); ?>/' + $(this).data('service-id');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        })

        // Confirm service deletions
        $(".serviceDelete").click(function() {
            // Set the service ID in the dialog and display
            $("#confirm-delete-service").data('service-id', $(this).data('service-id'));
            $("#confirm-delete-service").dialog('open');
            return false;
        });

        
        // Service Fields Dialog
        $("#estimatingServiceFieldsDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 800,
            buttons: {
                save: {
                    text: 'Save Fields',
                    class: 'blue-button',
                    click: function() {

                        // Serialize the data
                        var postData = $("#estimationFieldsForm").serializeArray();
                        if(hasDupes(postData)){
                            swal('','You Can`t assign multiple unit to same field');
                            return false;
                        }
                        
                        // Send the data
                        $.ajax({
                            url: '/ajax/saveCompanyEstimatingServiceFields',
                            type: 'post',
                            data: postData,
                            success: function (response) {
                                data = JSON.parse(response);
                                swal(data.message);
                            }
                        });

                        $(this).dialog('close');
                    }
                },
                cancel: {
                    text: 'Cancel',
                    class: 'left',
                    click: function() {
                        $(this).dialog('close')
                    }
                }
            }
        });

        $(".estimateFields").click(function() {

            // Grab the service ID/name and category
            var serviceId = $(this).data('service-id');
            var serviceName = $(this).data('service-name');
            var categoryId = $(this).data('category-id');

            // Column indexes
            var measurementColumn = 2;
            var unitColumn = 3;
            var excDepthColumn = 4;
            var baseDepthColumn = 5;
            var depthColumn = 6;
            var gravelDepthColumn = 7;
            var areaColumn = 8;
            var qtyColumn = 9;

            var serviceFields = {
                // Paving
                30: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Asphalt Repair
                7: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Sealcoating
                5: [
                    measurementColumn, unitColumn
                ],
                // Concrete
                49: [
                    measurementColumn, unitColumn, excDepthColumn
                ],
                // Line Striping
                2: [
                    measurementColumn
                ],
                // Driveway
                17: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Crack Sealing
                37: [
                    measurementColumn
                ],
                // Curb
                45: [
                    measurementColumn
                ],
                // Drainage
                21: [
                    measurementColumn, unitColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Milling
                54: [
                    measurementColumn, unitColumn, depthColumn
                ],
                // Slurry Seal
                74: [
                    measurementColumn, unitColumn
                ],
            }

            // Set the serviceId input
            $("#serviceId").val(serviceId);
            // Set the service name
            $("#estimateFieldsServiceName").text(serviceName);
            // Empty any table rows
            $("#estimationFieldsTable tbody").empty();

            // Load the assignments
            $.ajax({
                url: '/ajax/getEstimatingServiceFields',
                type: 'post',
                data: {
                    'serviceId':serviceId
                },
                success: function(data){
                    // JSON please
                    data = JSON.parse(data);

                    $.each(data, function (idx, field) {

                        $("#estimationFieldsTable tbody").append('<tr>' +
                            '<td>' + field.name + '</td>' +
                            '<td><input type="radio" value="' + field.id + '" name="measurement"' + (field.cesf.measurement ? " checked" : '') +' '+ (field.cesf.measurement ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="unit"' + (field.cesf.unit ? " checked" : '') +' '+ (field.cesf.unit ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="excDepth"' + (field.cesf.exc_depth ? " checked" : '') +' '+ (field.cesf.exc_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="baseDepth"' + (field.cesf.base_depth ? " checked" : '') +' '+ (field.cesf.base_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="depth"' + (field.cesf.depth ? " checked" : '') +' '+ (field.cesf.depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="gravelDepth"' + (field.cesf.gravel_depth ? " checked" : '') +' '+ (field.cesf.gravel_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="area"' + (field.cesf.area ? " checked" : '') +' '+ (field.cesf.area ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="qty"' + (field.cesf.qty ? " checked" : '') +' '+ (field.cesf.qty ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '</tr>');
                    });

                    // Hide all headings and data
                    $('#estimationFieldsTable td, #estimationFieldsTable th').hide();

                    // Show the first column (Fields)
                    $('#estimationFieldsTable td:nth-child(1), #estimationFieldsTable th:nth-child(1)').show();

                    // SHow/hide relevant columns
                    $(serviceFields[categoryId]).each(function(idx, columnIndex) {
                        $("#estimationFieldsTable td:nth-child(" + columnIndex + "), #estimationFieldsTable th:nth-child(" + columnIndex + ")").show();
                    });

                    // Now open the dialog
                    $("#estimatingServiceFieldsDialog").dialog('open');

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                },
            });

            return false;
        });

    });

    function hasDupes(array) {
                var hash = Object.create(null);
                return array.some(function (a) {
                    return a.value && (hash[a.value] || !(hash[a.value] = true));
                });
            }
    $(document).on("click",'#estimationFieldsTable input[type="radio"]',function(event) {
    
        var postData = $("#estimationFieldsForm").serializeArray();
        if(hasDupes(postData)){
            event.preventDefault();
            swal('','This field has already been assigned');
            return false;
        }
    });

     $(document).on("click",'#estimationFieldsTable input[type="radio"]',function(event) {
    
        var previousValue = $(this).data('val');
    
        if (previousValue) {
        $(this).prop('checked', !previousValue);
        $(this).data('val', !previousValue);
        }
        
        else{
        $(this).data('val', true);
        $("input[type=radio]:not(:checked)").data("val", false);
        }
  });
    // })
</script>