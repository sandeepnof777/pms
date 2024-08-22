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
                    Proposal Section
                    <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                    
                </div>
                <div class="box-content">
                    <div class="nav-content">
                        <div id="categoryTabs">
                            <ul>
                                <li><a href="#sectionTab1">Cool</a></li>
                                <li><a href="#sectionTab2">Standard</a></li>
                                <li><a href="#sectionTab3">Custom</a></li>
                            </ul>
                                <div id="sectionTab1">
                                    <table   class="boxed-table sectionTable1" width="100%"  cellspacing="0" >
                                    <thead>
                                    <tr>
                                        <th style="width: 80px;padding: 8px;">Order</th>
                                        <th>Proposal Section</th>
                                        <th>Show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($proposalCoolSections as $proposalCoolSection) {
                                        $unSortable = '';
                                        $disable = '';
                                        if ($proposalCoolSection->getSectionCode() == 'title-page'){
                                            $unSortable = 'unsortable';
                                            $disable = 'disabled';
                                        }
                                        ?>
                                        <tr class="even <?=$unSortable;?>" data-section-code="<?=$proposalCoolSection->getSectionCode();?>" id="type_<?php echo $proposalCoolSection->getId(); ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $proposalCoolSection->getIconCode(); ?>"></i> 
                                                <?php echo $proposalCoolSection->getSectionName(); ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input style="margin: 0px auto;" <?=$disable;?> <?php if($proposalCoolSection->getVisible()==1){ echo 'checked';}; ?> type="checkbox" class="section_check" data-section-id="<?php echo $proposalCoolSection->getId(); ?>"></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="sectionTab2">
                                    <table   class="boxed-table sectionTable2" width="100%"  cellspacing="0" >
                                    <thead>
                                    <tr>
                                        <th style="width: 80px;padding: 8px;">Order</th>
                                        <th>Proposal Section</th>
                                        <th>Show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($proposalStandardSections as $proposalStandardSection) {
                                        $unSortable = '';
                                        $disable = '';
                                        if ($proposalStandardSection->getSectionCode() == 'title-page'){
                                            $unSortable = 'unsortable';
                                            $disable = 'disabled';
                                        }
                                        ?>
                                        <tr class="even <?=$unSortable;?>" data-section-code="<?=$proposalStandardSection->getSectionCode();?>" id="type_<?php echo $proposalStandardSection->getId(); ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $proposalStandardSection->getIconCode(); ?>"></i> 
                                                <?php echo $proposalStandardSection->getSectionName(); ?>
                                            </td>
                                            
                                            <td width="10" style="padding: 0px 20px;"><input type="checkbox" <?=$disable;?> <?php if($proposalStandardSection->getVisible()==1){ echo 'checked';}; ?> class="section_check" data-section-id="<?php echo $proposalStandardSection->getId(); ?>"></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="sectionTab3">
                                    <table   class="boxed-table sectionTable3" width="100%"  cellspacing="0" >
                                    <thead>
                                    <tr>
                                        <th style="width: 80px;padding: 8px;">Order</th>
                                        <th>Proposal Section</th>
                                        <th>Show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($proposalCustomSections as $proposalCustomSection) {
                                        $unSortable = '';
                                        $disable = '';
                                        if ($proposalCustomSection->getSectionCode() == 'title-page'){
                                            $unSortable = 'unsortable';
                                            $disable = 'disabled';
                                        }
                                        ?>
                                        <tr class="even <?=$unSortable;?>" data-section-code="<?=$proposalCustomSection->getSectionCode();?>" id="type_<?php echo $proposalCustomSection->getId(); ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $proposalCustomSection->getIconCode(); ?>"></i> 
                                                <?php echo $proposalCustomSection->getSectionName(); ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input type="checkbox" <?=$disable;?> <?php if($proposalCustomSection->getVisible()==1){ echo 'checked';}; ?> class="section_check" data-section-id="<?php echo $proposalCustomSection->getId(); ?>"></td>
                                            
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


        </div>
    </div>







    <!--#content-->

    <script type="text/javascript">

        $(document).ready(function () {

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
            

            // Sortable types
            $('.type-sortable').sortable({
                    handle: '.handle',
                    items: "tr:not(.unsortable)",
                    stop: function () {
                        
                        var activeTabIdx = $('#categoryTabs').tabs('option','active');
                        activeTabIdx = activeTabIdx+1;
                        
                        var type_id = $('.sectionTable'+activeTabIdx).find('tr[data-section-code="title-page"]').attr('id');
                        console.log(type_id);
                        type_id = type_id.replace('type_', '');
                        var ordered_data = 'type[]='+type_id+'&';

                        ordered_data += $(this).sortable("serialize");

                        $.ajax({
                            url: '<?php echo site_url('account/order_admin_proposal_section') ?>',
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
                        url: '/admin/hide_show_admin_proposal_section',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: check_box,
                            sectionId : section_id
                        },

                        success: function( data){

                            swal('','Proposal Section Update');
                            
                            
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
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




    </script>

<?php $this->load->view('global/footer'); ?>