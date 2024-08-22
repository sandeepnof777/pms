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
                    Business Types
                    <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                    <a class="box-action addNewType" href="javascript:void(0);">Add New</a>
                </div>
                <div class="box-content">
                    <div class="nav-content">
                    <table   class="boxed-table templateTable" width="100%"  cellspacing="0"
                           id="defaultStatuses">
                        <thead>
                        <tr>
                            <th style="width: 80px;padding: 8px;">Order</th>
                            <th>Business Type</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="type-sortable">
                        <?php
                        foreach ($businessTypes as $businessType) {
                            /** @var $status \models\Status */
                            ?>
                            <tr class="even" id="type_<?php echo $businessType->getId(); ?>">
                                <td style="text-align: center">
                                    <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                          title="Drag to sort"></span>
                                </td>
                                <td >
                                    <?php echo $businessType->getTypeName(); ?>
                                </td>
                                
                                <td style="text-align: center">
                                <a href="#" class="tiptip btn-edit edit-type" style="display: inline-block" title="Edit Business Type"  data-type-id="<?php echo $businessType->getId(); ?>"
                                       data-type-text="<?php echo $businessType->getTypeName(); ?>">&nbsp;</a>
                                <a href="#" class="tiptip btn-delete delete-type" style="display: inline-block" title="Delete Business Type"  data-type-id="<?php echo $businessType->getId(); ?>" >&nbsp;</a>
                                    
                                </td>
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
            
        function updateRowColors() {
            var k = 0;
            $("tbody.type-sortable tr").each(function () {
                $(this).removeClass('even');
                k++;
                if (!(k % 2)) {
                    $(this).addClass('even');
                }
            });
        }
        updateRowColors();
           

            // Delete Status dialog open
            $('.delete-status').click(function () {
                $('#deleteStatusId').val($(this).data('status-id'));
                $("#delete-status").dialog('open');
            });

            // Sortable types
            $('.type-sortable').sortable({
                    handle: '.handle',
                    stop: function () {
                        var ordered_data = $(this).sortable("serialize");
                        $.ajax({
                            url: '<?php echo site_url('account/order_admin_business_type') ?>',
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


    

    
$(document).on("click",".addNewType",function(e) {

       
         swal({
                    title: "<i class='fa fw fa-plus-circle'></i> Add Business Type",
                    html: '<hr/>'+
                          '<form id="add_business_type_form" method="post">'+
                            '<input type="hidden" class="" name="action" value="add">'+
                            '<table class="boxed-table" style="border:0px"; width="100%" cellpadding="0" cellspacing="0">'+
                            
                            '<tr>' +
                                '<td><label for="" style="width: 150px;text-align: left;"> Business Type <span>*</span></label><input type="text" id="popup_business_type" name="newBusinessType" class="text business_type"  style="width: 300px; float: right;" required value=""></td>' +
                                '<td></td>' +
                            '</tr>'+
                            
                        '</table>' +
                        '</form>'+
                        '<p style="font-size: 12px;font-weight: bold;padding: 5px 0px 0px 0px;"><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p>',
                   
                    showCancelButton: true,
                    width: '600px',
                    confirmButtonText: '<i class="fa fw fa-plus-circle"></i> Add',
                    cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
                    dangerMode: false,
                    showCloseButton: true,
                    onOpen:function() { 
                        
                        $('.swal2-modal').attr('id','add_business_type_popup');
                        check_popup_validation();
                    }
                    
                    
                
                }).then(function (result) {
                    
                    swal({
                                title: 'Adding..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                swal.showLoading();
                                $('.swal2-modal').attr('id','')
                                }
                            })
                    $('#add_business_type_form').submit()

           
     }).catch(swal.noop);;
     return false;
    });

    $(document).on("click",".edit-type",function(e) {
        var typeName = $(this).data('type-text');
        var typeId = $(this).data('type-id');
       
        swal({
           title: "<i class='fa fw fa-plus-circle'></i> Edit Business Type",
           html: '<hr/>'+
                 '<form id="add_business_type_form" method="post">'+
                   '<input type="hidden" name="action" value="edit">'+
                   '<input type="hidden" name="businessTypeId" value="'+typeId+'">'+
                   '<table class="boxed-table" style="border:0px"; width="100%" cellpadding="0" cellspacing="0">'+
                   
                   '<tr>' +
                       '<td><label for="" style="width: 150px;text-align: left;"> Business Type <span>*</span></label><input type="text" id="popup_business_type" name="newBusinessType" class="text business_type"  style="width: 300px; float: right;" required value="'+typeName+'"></td>' +
                       '<td></td>' +
                   '</tr>'+
                   
               '</table>' +
               '</form>'+
               '<p style="font-size: 12px;font-weight: bold;padding: 5px 0px 0px 0px;"><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p>',
          
           showCancelButton: true,
           width: '600px',
           confirmButtonText: '<i class="fa fw fa-plus-circle"></i> Update',
           cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
           dangerMode: false,
           showCloseButton: true,
           onOpen:function() { 
               
               $('.swal2-modal').attr('id','add_business_type_popup');
               check_popup_validation();
           }
           
           
       
       }).then(function (result) {
           
           swal({
                       title: 'Updating..',
                       allowEscapeKey: false,
                       allowOutsideClick: false,
                       timer: 10000,
                       onOpen: () => {
                       swal.showLoading();
                       $('.swal2-modal').attr('id','')
                       }
                   })
           $('#add_business_type_form').submit()

  
    }).catch(swal.noop);;
    return false;
});

$(document).on("click",".delete-type",function(e) {
        var type_id = $(this).attr('data-type-id');
                   
            swal({
                title: "Are you sure?",
               
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })
                    
                    $.ajax({
                        url: '/admin/business_types',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: 'delete',
                            businessTypeId : type_id
                        },

                        success: function( data){

                            swal('Business Type Deleted');
                            document.location.href = '<?php echo site_url('admin/business_types') ?>';
                            
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            });
        
    });


$(document).on("keyup","#popup_business_type",function(e) {
    if($(this).val()){
        $(this).removeClass('error');
        
    }else{
        $(this).addClass('error');
        
    }
    check_popup_validation()

});

function check_popup_validation(){
    if($('#popup_business_type').val() ==''){
            $('.send_popup_validation_msg').show();
            $('#add_business_type_popup .swal2-confirm').attr('disabled', true);
    }else{
        $('.send_popup_validation_msg').hide();
        $('#add_business_type_popup .swal2-confirm').attr('disabled', false);
    }
}

    </script>

<?php $this->load->view('global/footer'); ?>