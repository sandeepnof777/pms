<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3> 
            <div class="content-box">
                <div class="box-header">
                    Work Order Section
                    
                </div>
                <div class="box-content">
                    <div class="nav-content">
                        
                                    <table   class="boxed-table sectionTable1" width="100%"  cellspacing="0" >
                                    <thead>
                                    <tr>
                                        <th style="width: 80px;padding: 8px;">Order</th>
                                        <th>Work Order Section</th>
                                        <th>show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($workOrderSections as $workOrderSection) {
                                        $unSortable = '';
                                        $disable = '';
                                        if ($workOrderSection->section_code == 'map-direction'){
                                            $unSortable = 'unsortable';
                                            $disable = 'disabled';
                                        }
                                        ?>
                                        <tr class="even <?= $unSortable;?>" data-section-code="<?=  $workOrderSection->section_code;?>" id="type_<?php echo $workOrderSection->company_section_id; ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                                <i class="fa fa-fw <?php echo $workOrderSection->icon_code; ?>"></i> 
                                                <?php echo $workOrderSection->section_name; ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input style="margin: 0px auto;" <?php if($workOrderSection->c_visible==1){ echo 'checked';}; ?> type="checkbox" <?=$disable;?> class="section_check" data-section-id="<?php echo $workOrderSection->company_section_id; ?>"></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            
                    </div>
                </div>
            </div>
 
    <!--#content-->

    <!-- univarsal  work order setting pdf layout-->
    <div class="content-box">
                <div class="box-header">
                     Work Order Layout                    
                </div>
                <div class="box-content">
                    <div class="nav-content">
                    <?php
 
// Define an array to hold option values and labels
$options = array(
    array("value" => 0, "label" => "LANDSCAPE"),
    array("value" => 1, "label" => "PORTRAIT")
);

?>
                        
                                    <table   class="boxed-table sectionTable1" width="100%"  cellspacing="0" >
                                    <thead>
                                   
                                    </thead>
                                    <tbody class="type-sortable">
                                    
                                    <tr class="even">
    <td>
        <label style="color:#333;">Work Order Setting</label>
    </td>
    <td>
        <select name="workOrderSetting" id="workOrderSetting" class="generalSetting">
            <?php
            // Loop through the options array
            foreach ($options as $option) {
                // Check if the value matches $workOrder
                if ($option["value"] == $workOrder) {
                    // If it matches, set the 'selected' attribute
                    echo '<option value="' . $option["value"] . '" selected>' . $option["label"] . '</option>';
                } else {
                    // Otherwise, just output the option without 'selected'
                    echo '<option value="' . $option["value"] . '">' . $option["label"] . '</option>';
                }
            }
            ?>
        </select>
    </td>
</tr>
                                    </tbody>
                                </table>
                            
                    </div>
                </div>
            </div> 

    <!-- univarsal work order setting pdf layout close-->

    <script type="text/javascript">

        $(document).ready(function () {

            

            // Sortable types
            $('.type-sortable').sortable({
                    handle: '.handle',
                    items: "tr:not(.unsortable)",
                    stop: function () {
                        var type_id = $('.sectionTable1').find('tr[data-section-code="map-direction"]').attr('id');
                        type_id = type_id.replace('type_', '')
                        var ordered_data = 'type[]='+type_id+'&';
                        ordered_data += $(this).sortable("serialize");

                        $.ajax({
                            url: '<?php echo site_url('account/order_company_work_order_section') ?>',
                            type: "POST",
                            data: ordered_data,
                            dataType: "json",
                            success: function (data) {
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
                });

        });


    


$(document).on("click",".section_check",function(e) {
        var section_id = $(this).attr('data-section-id');
        var check_box = 0;
        var title = 'Hidden';
        var text = 'Hide';
        if($(this).is(':checked')){
            check_box = 1;
            var title = 'Visible';
            var text = 'Show';
        }     

        $this = $(this);      
            swal({
                title: "Are you sure?",
                html:"This section will be "+title,
                showCancelButton: true,
                confirmButtonText: text,
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                
                if (isConfirm) {

                    swal({
                        title: 'saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })
                    
                    $.ajax({
                        url: '/account/hide_show_company_work_order_section',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: check_box,
                            sectionId : section_id
                        },

                        success: function( data){

                            swal('','Work Order Section Update');
                            
                            
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                }else {
                    console.log('dfdfd');
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            }, function(dismiss){
                if($this.is(':checked')){
                    $this.prop( "checked", false );
                }else{
                    $this.prop( "checked", true );
                }
                $.uniform.update();
            }).catch(swal.noop);

        
    });


    $(document).ready(function() { 
            // for work order setting code start here 
                // Event listener for change in workOrderSetting select
                $('#workOrderSetting').on('change', function() {
                    var selectedValue = $(this).val(); // Get the selected value
                     
                    // Perform AJAX request
                    $.ajax({
                        type: 'POST',
                        url: '/account/work_order_setting_update',
                        dataType: 'json',
                        data: {workOrderSetting: selectedValue},
                        cache:false,
                        success: function(data) {
                            // Handle success response
                             swal({
                                title: "Success",
                                text: "Work Order Setting Updated Successfully!",
                                icon: "success",
                                button: "OK",
                            });
                        },
                        error: function(jqXhr, textStatus, errorThrown) {
                            // Handle error
                            console.error('AJAX request failed:', errorThrown);
                        }
                    });
                });
});

    </script>
