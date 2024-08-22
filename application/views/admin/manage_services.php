<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box" id="add-service">
            <div class="box-header">
                Add Service
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
            </div>
            <div class="box-content">
                <form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post" action="<?php echo site_url('admin/manage_services') ?>">
                    <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
                        <tbody>
                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Parent</label>
                                    <select name="parent" id="parent">
                                        <option value="0">New Category</option>
                                        <?php
                                        foreach ($categories as $cat) {
                                            ?>
                                            <option value="<?php echo $cat->getServiceId() ?>"><?php echo $cat->getServiceName() ?></option>
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
                                    <label>Service Name <span>*</span></label>
                                    <input type="text" value="" id="serviceName" name="serviceName" class="text required" tabindex="2">
                                </p>
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                                <label>&nbsp;</label><input type="submit" class="btn ui-button ui-widget ui-state-default ui-corner-all" value="Add Service" tabindex="28" role="button" aria-disabled="false" name="add_service">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div class="widthfix">
        <div class="content-box" id="manage-items">
            <div class="box-header">
                Manage Services
            </div>
            <div class="box-content padded">
                <div id="admin-services">
                    <?php
                    foreach ($categories as $cat) {
                        ?>
                        <div class="service" id="services_<?php echo $cat->getServiceId() ?>">
                            <p class="header">
                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <span class="tiptip editServiceCat" title="Click to edit" id="cat_<?php echo $cat->getServiceId() ?>"><?php echo $cat->getServiceName() ?></span>
                                <a class="deleteService tiptip" title="Delete Category" href="<?php echo site_url('admin/delete_service/' . $cat->getServiceId()) ?>">Delete</a>
                            </p>
                            <?php
                            if (!isset($services[$cat->getServiceId()])) {
                                ?>
                                <p>No Services in category</p>
                                <?php
                            } else {
                                ?>
                                <ul>
                                    <?php
                                    foreach ($services[$cat->getServiceId()] as $service) {
                                        ?>
                                        <li id="services_<?php echo $service->getServiceId() ?>">
                                            <span class="serviceHandle ui-icon ui-icon-arrowthick-2-n-s" style="margin-top: 15px;"></span>
                                            <div class="serviceRowContent" style="padding: 5px;">
                                                <p style="width: 60%; float: left; margin-top: 10px; padding-left: 15px;"><?php echo $service->getServiceName() ?></span></p>

                                                <div style="width: 35%; float: right;">

                                                    <a class="deleteService tiptip btn" title="Delete Service" href="<?php echo site_url('admin/delete_service/' . $service->getServiceId()) ?>">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                    </a>
                                                    <a class="editService tiptip btn" title="Edit Service"href="<?php echo site_url('admin/edit_service/' . $service->getServiceId()) ?>">
                                                        <i class="fa fa-fw fa-edit"></i>
                                                    </a>
                                                    <a class="estimateFields tiptip btn" title="Estimate Fields"
                                                       data-service-id="<?php echo $service->getServiceId(); ?>"
                                                       data-service-name="<?php echo $service->getServiceName(); ?>"
                                                       data-category-id="<?php echo $cat->getServiceId()?>" href="#">
                                                        <i class="fa fa-fw fa-list"></i>
                                                    </a>

                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

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

                        // Send the data
                        $.ajax({
                            url: '/admin/saveEstimatingServiceFields',
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

        //Sort categories
        $("#admin-services").sortable({
            handle:".handle",
            stop:function () {
                var postData = $("#admin-services").sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('admin/updateServiceCategoryOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });
        //Sort services
        $(".service ul").each(function () {
            var ul = $(this);
            $(this).sortable({
                handle:".serviceHandle",
                stop:function () {
                    var postData = ul.sortable("serialize");
                    $.ajax({
                        type:"POST",
                        url:"<?php echo site_url('admin/updateServiceCategoryOrder') ?>",
                        data:postData,
                        async:false
                    });
                }
            });
        });
        //Edit Category Name
        $(".editServiceCat").editable('<?php echo site_url('admin/editServiceCatName') ?>', {
            cancel:'Cancel',
            submit:'OK'
        });
        //Confirm deletion dialog
        var deleteURL = '';
        $(".deleteService").click(function () {
            deleteURL = $(this).attr('href');
            $("#confirm-delete").dialog('open');
            return false;
        });
        $("#confirm-delete").dialog({
            autoOpen:false,
            buttons:{
                Ok:function () {
                    document.location.href = deleteURL;
                    $(this).dialog('close');
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            }
        });

        $(".estimateFields").click(function() {

            console.log('here');

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
                    measurementColumn, unitColumn, depthColumn,excDepthColumn
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
                url: '/admin/getEstimatingServiceFields',
                type: 'post',
                data: {
                    'serviceId':serviceId
                },
                success: function(data){
                    data = JSON.parse(data);

                    $.each(data, function (idx, field) {

                        $("#estimationFieldsTable tbody").append('<tr>' +
                            '<td>' + field.name + '</td>' +
                            '<td><input type="radio" value="' + field.id + '" name="measurement"' + (field.cesf.measurement ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="unit"' + (field.cesf.unit ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="excDepth"' + (field.cesf.exc_depth ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="baseDepth"' + (field.cesf.base_depth ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="depth"' + (field.cesf.depth ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="gravelDepth"' + (field.cesf.gravel_depth ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="area"' + (field.cesf.area ? " checked" : '') + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="qty"' + (field.cesf.qty ? " checked" : '') + ' /> </td>' +
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

                    // Now opent he dialog
                    $("#estimatingServiceFieldsDialog").dialog('open');

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                },
            });


            return false;
        });
    });
</script>
<div id="confirm-delete" title="Confirm Deletion">
    <p>Are you sure you want to delete this?</p>
</div>
<?php $this->load->view('global/footer'); ?>
