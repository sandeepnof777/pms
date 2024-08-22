<?php $this->load->view('global/header-admin'); ?>
    <div id="content" class="clearfix">
        <div class="widthfix">

            <div class="content-box">
                <div class="box-header">
                    Edit Proposal Statuses
                    <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                </div>
                <div class="box-content">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table"
                           id="defaultStatuses">
                        <thead>
                        <tr>
                            <th style="height: 33px;">Order</th>
                            <th>Status</th>
                            <th>Sold Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody class="status-sortable">
                        <?php
                        foreach ($statuses as $status) {
                            /** @var $status \models\Status */
                            ?>
                            <tr class="even" id="status_<?php echo $status->getStatusId(); ?>">
                                <td style="text-align: center">
                                    <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip"
                                          title="Drag to sort"></span>
                                </td>
                                <td style="border-left: 4px solid #<?php echo $status->getColor(); ?>;">
                                    <?php echo $status->getText(); ?>
                                </td>
                                <td style="text-align: center">
                                    <?php if ($status->isSales()) { ?>
                                        <i class="fa fa-fw fa-check-circle"></i>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center">
                                    <a href="#" class="edit-status tiptip" title="Edit Status" style="padding:5px;"
                                       data-sold="<?php echo $status->getSales() ?>"
                                       data-status-id="<?php echo $status->getStatusId(); ?>"
                                       data-status-text="<?php echo $status->getText(); ?>"
                                       data-status-color="<?php echo $status->getColor(); ?>"><img
                                                src="/3rdparty/icons/application_edit.png"></a>
                                    <a href="#" class="delete-status tiptip" title="Delete Status"
                                       style="padding:5px; margin-left: 20px"
                                       data-status-id="<?php echo $status->getStatusId(); ?>"><img
                                                src="/3rdparty/icons/delete.png"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="content-box collapse open">
                <div class="box-header">
                    Add New Proposal Status
                </div>
                <div class="box-content" style="padding: 20px;">
                    <form method="post" action="">
                    <input type="hidden" name="action" value="add"/>
                    <table class="boxed-table">
                        <tr>
                            <td>
                                <label>Status Name: </label>
                            </td>
                            <td>
                                <input type="text" class="text" name="newStatus"/>
                                <input type="text" id="newColor"  name="newColor" style="visibility:hidden;width:1px" class="jsColor" onchange="updateAddBgPreview(this.jscolor)">
                                <div style="width: 25px;float: left;height: 22px;background-color: rgb(255, 51, 25);cursor:pointer;border:1px solid #cccccc" onclick="document.getElementById('newColor').jscolor.show()"  id="click_add_color_pick"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Sold Status:</label>
                            </td>
                            <td>
                                <input type="checkbox" class="checkbox" name="newStatusSold" />
                            </td>
                        </tr>
                       
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submitNewStatus" class="btn ui-button update-button"
                                       value="Add Status"/>
                            </td>
                        </tr>
                    </table>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Status Dialog -->
    <div id="edit-status" title="Edit Status">

        <form method="post">
            <input type="hidden" name="action" value="edit"/>
            <input type="hidden" name="statusId" id="statusId" value=""/>

            <table class="boxed-table">
                <tr>
                    <td>Status Name</td>
                    <td>
                        <input type="text" name="statusText" id="statusText" value="" style="width: 200px;"/>
                        <input type="text" id="editColor"  name="editColor" style="display:none" class="jsColor" onchange="updateBgPreview(this.jscolor)">
                        <div style="width: 25px;float: left;margin-left: 5px;height: 18px;background-color: rgb(255, 51, 25);cursor:pointer;border:1px solid #cccccc" onclick="document.getElementById('editColor').jscolor.show()"  id="click_color_pick"></div>
                    </td>
                </tr>
                <tr>
                    <td>Sold Status</td>
                    <td>
                        <input type="checkbox" name="editStatusSold" id="editStatusSold">
                    </td>
                </tr>
                
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" class="btn ui-button update-button">Save</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <!-- Delete Status Dialog -->
    <div id="delete-status" title="Delete Status">

        <form method="post">
            <input type="hidden" name="action" value="delete"/>
            <input type="hidden" name="statusId" id="deleteStatusId" value=""/>
            <p>Transfer proposal with this status to:</p><br/>

            <select name="targetStatus">
                <?php foreach ($statuses as $status) { ?>
                    <option value="<?php echo $status->getStatusId(); ?>"><?php echo $status->getText(); ?></option>
                <?php } ?>
            </select>
            <br/><br/>
            <p>
                <button type="submit" class="btn ui-button update-button">Confirm</button>
            </p>
        </form>
    </div>


    <!--#content-->

    <script type="text/javascript">

        $(document).ready(function () {

            // Edit status dialog
            $("#edit-status").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                },
                autoOpen: false
            });

            // Edit Status dialog open
            $('.edit-status').click(function () {

                // Populate the fields before displaying
                $('#statusId').val($(this).data('status-id'));
                $('#statusText').val($(this).data('status-text'));
               
                $('#editColor').val($(this).data('status-color'));

            $('#click_color_pick').css('background-color','#'+$(this).data('status-color'));
                // Sold Checkbox
                $("#editStatusSold").prop('checked', $(this).data('sold'));
                $.uniform.update();

                $("#edit-status").dialog('open');
            });

            // Delete status dialog
            $("#delete-status").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                },
                autoOpen: false
            });

            // Delete Status dialog open
            $('.delete-status').click(function () {
                $('#deleteStatusId').val($(this).data('status-id'));
                $("#delete-status").dialog('open');
            });

            // Sortable statuses
            $('.status-sortable').sortable({
                    handle: '.handle',
                    stop: function () {
                        var ordered_data = $(this).sortable("serialize");
                        $.ajax({
                            url: '<?php echo site_url('ajax/order_default_statuses') ?>',
                            type: "POST",
                            data: ordered_data,
                            dataType: "json",
                            success: function (data) {
                                console.log(data);

                                if (data.error) {
                                    alert(data.error);
                                } else {
//                                document.location.reload();
                                }
                            },
                            error: function () {
                                alert('There was an error processing the request. Please try again later.');
                            }
                        });
                    }
                }
            );

        });


   $(document).on('click', '#editColor', function(){
       
        $( ".ui-widget-overlay" ).next().css('z-index','1020'  );
        var left_position = $("#click_color_pick").offset().left - $(document).scrollLeft();


        var top_position = $("#click_color_pick").offset().top - $(document).scrollTop();
        top_position = parseInt(top_position) + parseInt(20);


        $( ".ui-widget-overlay" ).next().css('top',top_position);
        $( ".ui-widget-overlay" ).next().css('left',left_position);
    });

    $(document).on('click', '#click_color_pick', function(){
        
       $( "#editColor" ).click();
      // $( "#editColor" ).trigger( "focus" );
   });
    
    
    function updateBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $("#click_color_pick").css("background-color", rgbColor);
    } 

    $(document).on('click', '#newColor', function(){
       
      
//        var left_position = $("#newColor").offset().left - $(document).scrollLeft();


//        var top_position = $("#newColor").offset().top - $(document).scrollTop();
//        top_position = parseInt(top_position) + parseInt(20);

// console.log(top_position);
//        $( ".ui-widget-overlay" ).next().css('top',top_position);
//        $( ".ui-widget-overlay" ).next().css('left',left_position);
   });

    $(document).on('click', '#click_add_color_pick', function(){
        
        $( "#newColor" ).click();
    });
    function updateAddBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $("#click_add_color_pick").css("background-color", rgbColor);
    } 
    </script>

<?php $this->load->view('global/footer'); ?>