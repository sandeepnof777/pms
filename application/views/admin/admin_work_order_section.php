<?php $this->load->view('global/header-admin'); ?>
<style>
 #add_business_type_popup h2 {
    font-size: 20px;
    line-height: 20px!important;
}
#add_business_type_popup .swal2-confirm {
    float: right;
}
#add_business_type_popup .swal2-cancel {
    float: left;
}
.swal2-modal .swal2-content {
    font-size: 15px!important;
}
</style>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                Work Order Section
                    <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                    
                </div>
                <div class="box-content">
                    <div class="nav-content">
                        
                                    <table   class="boxed-table sectionTable1" width="100%"  cellspacing="0" >
                                    <thead>
                                    <tr>
                                        <th style="width: 80px;padding: 8px;">Order</th>
                                        <th>Work Order Section</th>
                                        <th>Show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($workOrderSections as $workOrderSection) {
                                        $unSortable = '';
                                        $disable = '';
                                        if ($workOrderSection->getSectionCode() == 'map-direction'){
                                            $unSortable = 'unsortable';
                                            $disable = 'disabled';
                                        }
                                        
                                        ?>
                                        <tr class="even <?= $unSortable;?>" data-section-code="<?=$workOrderSection->getSectionCode();?>" id="type_<?php echo $workOrderSection->getId(); ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $workOrderSection->getIconCode(); ?>"></i> 
                                                <?php echo $workOrderSection->getSectionName(); ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input style="margin: 0px auto;"  <?php if($workOrderSection->getVisible()==1){ echo 'checked';}; ?> type="checkbox" <?=$disable;?> class="section_check" data-section-id="<?php echo $workOrderSection->getId(); ?>"></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            
                            
                    </div>
                </div>
            </div>


        </div>
    </div>







    <!--#content-->

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
                            url: '<?php echo site_url('admin/order_admin_work_order_section') ?>',
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


    


$(document).on("click",".section_check",function(e) {
        var section_id = $(this).attr('data-section-id');
        var check_box = 0;
        var title = 'Hidden';
        var text = 'Hide';

        $this = $(this);
        if($(this).is(':checked')){
            check_box = 1;
            var title = 'Visible';
            var text = 'Show';
        }           
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
                        url: '/admin/hide_show_admin_work_order_section',
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


                } else {
                    swal("Cancelled", "", "error");
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




    </script>

<?php $this->load->view('global/footer'); ?>