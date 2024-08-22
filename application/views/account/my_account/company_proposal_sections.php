<!-- add a back button   -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3> 
            <div class="content-box">
                <div class="box-header">
                    Proposal Section
                    
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
                                        <th>show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($proposalCoolSections as $proposalCoolSection) {
                                        $unSortable = '';
                                        $disable = '';
                                            if ($proposalCoolSection->section_code == 'title-page'){
                                                $unSortable = 'unsortable';
                                                $disable = 'disabled';
                                            }
                                        ?>
                                        <tr class="even <?= $unSortable;?>" data-section-code="<?=  $proposalCoolSection->section_code;?>" id="type_<?php echo $proposalCoolSection->company_section_id; ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                                <i class="fa fa-fw <?php echo $proposalCoolSection->icon_code; ?>"></i> 
                                                <?php echo $proposalCoolSection->section_name; ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input style="margin: 0px auto;" <?php if($proposalCoolSection->c_hidden==1){ echo 'checked';}; ?> type="checkbox" <?=$disable;?> class="section_check" data-section-id="<?php echo $proposalCoolSection->company_section_id; ?>"></td>
                                            
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
                                        <th>show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    
                                    foreach ($proposalStandardSections as $proposalStandardSection) {
                                            $unSortable = '';
                                            $disable = '';
                                            if ($proposalStandardSection->section_code == 'title-page'){
                                                $unSortable = 'unsortable';
                                                $disable = 'disabled';
                                            }
                                        ?>
                                        <tr class="even <?= $unSortable;?>" data-section-code="<?=  $proposalStandardSection->section_code;?>" id="type_<?php echo $proposalStandardSection->company_section_id; ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $proposalStandardSection->icon_code; ?>"></i> 
                                                <?php echo $proposalStandardSection->section_name; ?>
                                            </td>
                                            
                                            <td width="10" style="padding: 0px 20px;"><input type="checkbox" <?=$disable;?> <?php if($proposalStandardSection->c_hidden==1){ echo 'checked';}; ?> class="section_check" data-section-id="<?php echo $proposalStandardSection->company_section_id; ?>"></td>
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
                                        <th>show</th>
                                    </tr>
                                    </thead>
                                    <tbody class="type-sortable">
                                    <?php
                                    foreach ($proposalCustomSections as $proposalCustomSection) {
                                        $unSortable = '';
                                        $disable = '';
                                            if ($proposalCustomSection->section_code == 'title-page'){
                                                $unSortable = 'unsortable';
                                                $disable = 'disabled';
                                            }
                                        ?>
                                        <tr class="even <?=  $unSortable;?>" data-section-code="<?=  $proposalCustomSection->section_code;?>" id="type_<?php echo $proposalCustomSection->company_section_id; ?>">
                                            <td style="text-align: center">
                                                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0px auto;"
                                                    title="Drag to sort"></span>
                                            </td>
                                            <td >
                                            <i class="fa fa-fw <?php echo $proposalCustomSection->icon_code; ?>"></i> 
                                                <?php echo $proposalCustomSection->section_name; ?>
                                            </td>
                                            <td width="10" style="padding: 0px 20px;"><input type="checkbox" <?=$disable;?> <?php if($proposalCustomSection->c_hidden==1){ echo 'checked';}; ?> class="section_check" data-section-id="<?php echo $proposalCustomSection->company_section_id; ?>"></td>
                                            
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
                        type_id = type_id.replace('type_', '');
                        var ordered_data = 'type[]='+type_id+'&';

                        ordered_data += $(this).sortable("serialize");

                        //var ordered_data = $(this).sortable("serialize");
                        
                        ordered_data += '&layout='+activeTabIdx;
                        $.ajax({
                            url: '<?php echo site_url('account/order_company_proposal_section') ?>',
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
                        url: '/account/hide_show_company_proposal_section',
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




    </script>
