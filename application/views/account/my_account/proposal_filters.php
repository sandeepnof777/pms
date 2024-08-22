<style>
.swal2-input.error {
    border-color: #e47074 !important;
}

span.help{
    height: 13px;
    line-height: 13px;
    font-size: 10px;
    width: 15px;
}
.dropdownButton.currentActive {
        z-index: 100;
}
.dropdownToggle.open {
        background-color:transparent;
        background:none;
}

#typeSection_2, #typeSection_3, #typeSection_4, #typeSection_5 {
    display: none;
}
#filter_details_container table tr td:first-child {
    text-align: left;
}
#filter_details_container p strong {
    text-align: left!important;
}

    </style>

<h3>
    Saved Filters
</h3>

<div class="nav-header">
    <ul class="nav-bar">
                                                                    <li>
                                        <a style="cursor:pointer;font-weight: normal !important;" id="activeHead_1" class="typeLink typeSection_1 active" onclick="showFilterTable(1)"> Proposal</a>
                                    </li>
                                                                        <li>
                                        <a style="cursor:pointer;font-weight: normal !important;" id="activeHead_2" class="typeLink typeSection_2"  onclick="showFilterTable(2)"> Client</a>
                                    </li>
                                                                        <li>
                                        <a style="cursor:pointer;font-weight: normal !important;" id="activeHead_3" class="typeLink typeSection_3"  onclick="showFilterTable(3)"> Account</a>
                                    </li>
                                                                        <li>
                                        <a style="cursor:pointer;font-weight: normal !important;" id="activeHead_4" class="typeLink typeSection_4"  onclick="showFilterTable(4)"> Lead</a>
                                    </li>
                                                                        <li>
                                        <a style="cursor:pointer;font-weight: normal !important;" id="activeHead_5" class="typeLink typeSection_5"  onclick="showFilterTable(5)"> Prospect</a>
                                    </li>
                                                                </ul>
                                                                <a href="JavaScript:void('0');" class="btn blue-button left group_delete " style="visibility:hidden; float:left; margin:4px 0px; margin-left:-16px"><i class="fa fa-fw fa-trash"></i>Delete Filters</a>
</div>
<div>
    <div class="clientTemplatesTypeContainer" id="typeSection_1" style="display:block;">
        <table class="boxed-table filter-list" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <td class="filter_table_checkbox" width="5%"><input type="checkbox" id="filterMasterCheckbox"></input></td>
                <td width="5%"><i class="fa fa-fw fa-sort"></i> </td>
                <td style="text-align: left;" width="15%">Created</td>
                <td style="text-align: left;" width="25%">Filter Name</td>
                <td style="text-align: left;" width="20%">Filter</td>
                <td style="text-align: left;" width="15%">Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;

            foreach ($proposal_filters as $filter) {
                $filter_check = json_decode($filter->filter_data);
                
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="filter_<?php echo $filter->id; ?>">
                <td><input type="checkbox" class="filterGroupCheckbox" data-filter-id="<?php echo $filter->id ?>"></input></td>
                    <td class="center" style="text-align: center;">
                        <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
                    </td>
                    <td>
                        <span ><?php echo date('m/d/y g:ia', strtotime($filter->created_at)); ?></span>
                    </td>
                    <td>
                        <span  id="filterName_<?php echo $filter->id ?>" ><?php echo $filter->filter_name; ?></span>
                        
                    </td>
                    
                    <td>
                        <span ><a href="#" class="filterTipTipData" data-filter-jason='<?php echo $filter->filter_data; ?>'   data-tiptip-filter-id="<?php echo $filter->id ?>"> View Filters</a> 
                    </td>
                    
                    <td>
                        <div class="dropdownButton">
                            <a class="dropdownToggle m-btn" style="background:none;margin-right:0px;color:#000!important;cursor:pointer">Actions <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 170px; left:-112px">
                                <ul class="dropdownMenu" style="width: 170px">
                                    <li style="padding: 0px;">
                                    
                                    <a class="tiptip delete-filter"  href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                        Delete</a>
                                    </li>
                                    <li style="padding: 0px;">
                                        <a class=" editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>" data-filter-page="<?php echo $filter->filter_page; ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </td>
                    <!-- <td><a class="tiptip btn btn-delete delete-filter" href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                    <!-- <td><a class="btn btn-edit editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                </tr>
            <?php
            }
            if (!count($proposal_filters)) {
                ?>
            <tr>
                <td colspan="6" class="centered">No filters defined! Please add some to get started!</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clientTemplatesTypeContainer" id="typeSection_2">
        <table class="boxed-table filter-list" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <td class="filter_table_checkbox" width="5%"><input type="checkbox" id="filterMasterCheckbox"></input></td>
                <td width="5%"><i class="fa fa-fw fa-sort"></i> </td>
                <td style="text-align: left;" width="15%">Created</td>
                <td style="text-align: left;" width="25%">Filter Name</td>
                <td style="text-align: left;" width="20%">Filter</td>
                <td style="text-align: left;" width="15%">Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;

            foreach ($client_filters as $filter) {
                $filter_check = json_decode($filter->filter_data);
                
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="filter_<?php echo $filter->id; ?>">
                <td><input type="checkbox" class="filterGroupCheckbox" data-filter-id="<?php echo $filter->id ?>"></input></td>
                    <td class="center" style="text-align: center;">
                        <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
                    </td>
                    <td>
                        <span ><?php echo date('m/d/y g:ia', strtotime($filter->created_at)); ?></span>
                    </td>
                    <td>
                        <span  id="filterName_<?php echo $filter->id ?>" ><?php echo $filter->filter_name; ?></span>
                        
                    </td>
                    
                    <td>
                        <span ><a href="#" class="filterTipTipData" data-filter-jason='<?php echo $filter->filter_data; ?>'   data-tiptip-filter-id="<?php echo $filter->id ?>"> View Filters</a> 
                    </td>
                    
                    <td>
                        <div class="dropdownButton">
                            <a class="dropdownToggle m-btn" style="background:none;margin-right:0px;color:#000!important;cursor:pointer">Actions <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 170px; left:-112px">
                                <ul class="dropdownMenu" style="width: 170px">
                                    <li style="padding: 0px;">
                                    
                                    <a class="tiptip delete-filter"  href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                        Delete</a>
                                    </li>
                                    <li style="padding: 0px;">
                                        <a class=" editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>" data-filter-page="<?php echo $filter->filter_page; ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </td>
                    <!-- <td><a class="tiptip btn btn-delete delete-filter" href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                    <!-- <td><a class="btn btn-edit editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                </tr>
            <?php
            }
            if (!count($client_filters)) {
                ?>
            <tr>
                <td colspan="6" class="centered">No filters defined! Please add some to get started!</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clientTemplatesTypeContainer" id="typeSection_3">
        <table class="boxed-table filter-list" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <td class="filter_table_checkbox" width="5%"><input type="checkbox" id="filterMasterCheckbox"></input>
        </td>
                <td width="5%"><i class="fa fa-fw fa-sort"></i> </td>
                <td style="text-align: left;" width="15%">Created</td>
                <td style="text-align: left;" width="25%">Filter Name</td>
                <td style="text-align: left;" width="20%">Filter</td>
                <td style="text-align: left;" width="15%">Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;

            foreach ($account_filters as $filter) {
                $filter_check = json_decode($filter->filter_data);
                
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="filter_<?php echo $filter->id; ?>">
                <td><input type="checkbox" class="filterGroupCheckbox" data-filter-id="<?php echo $filter->id ?>"></input></td>
                    <td class="center" style="text-align: center;">
                        <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
                    </td>
                    <td>
                        <span ><?php echo date('m/d/y g:ia', strtotime($filter->created_at)); ?></span>
                    </td>
                    <td>
                        <span  id="filterName_<?php echo $filter->id ?>" ><?php echo $filter->filter_name; ?></span>
                        
                    </td>
                    
                    <td>
                        <span ><a href="#" class="filterTipTipData" data-filter-jason='<?php echo $filter->filter_data; ?>'   data-tiptip-filter-id="<?php echo $filter->id ?>"> View Filters</a> 
                    </td>
                    
                    <td>
                        <div class="dropdownButton">
                            <a class="dropdownToggle m-btn" style="background:none;margin-right:0px;color:#000!important;cursor:pointer">Actions <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 170px; left:-112px">
                                <ul class="dropdownMenu" style="width: 170px">
                                    <li style="padding: 0px;">
                                    
                                    <a class="tiptip delete-filter"  href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                        Delete</a>
                                    </li>
                                    <li style="padding: 0px;">
                                        <a class=" editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>" data-filter-page="<?php echo $filter->filter_page; ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </td>
                    <!-- <td><a class="tiptip btn btn-delete delete-filter" href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                    <!-- <td><a class="btn btn-edit editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                </tr>
            <?php
            }
            if (!count($account_filters)) {
                ?>
            <tr>
                <td colspan="6" class="centered">No filters defined! Please add some to get started!</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clientTemplatesTypeContainer" id="typeSection_4">
        <table class="boxed-table filter-list" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <td class="filter_table_checkbox" width="5%"><input type="checkbox" id="filterMasterCheckbox"></input></td>
                <td width="5%"><i class="fa fa-fw fa-sort"></i> </td>
                <td style="text-align: left;" width="15%">Created</td>
                <td style="text-align: left;" width="25%">Filter Name</td>
                <td style="text-align: left;" width="20%">Filter</td>
                <td style="text-align: left;" width="15%">Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;

            foreach ($lead_filters as $filter) {
                $filter_check = json_decode($filter->filter_data);
                
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="filter_<?php echo $filter->id; ?>">
                <td><input type="checkbox" class="filterGroupCheckbox" data-filter-id="<?php echo $filter->id ?>"></input></td>
                    <td class="center" style="text-align: center;">
                        <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
                    </td>
                    <td>
                        <span ><?php echo date('m/d/y g:ia', strtotime($filter->created_at)); ?></span>
                    </td>
                    <td>
                        <span  id="filterName_<?php echo $filter->id ?>" ><?php echo $filter->filter_name; ?></span>
                        
                    </td>
                    
                    <td>
                        <span ><a href="#" class="filterTipTipData" data-filter-jason='<?php echo $filter->filter_data; ?>'   data-tiptip-filter-id="<?php echo $filter->id ?>"> View Filters</a> 
                    </td>
                    
                    <td>
                        <div class="dropdownButton">
                            <a class="dropdownToggle m-btn" style="background:none;margin-right:0px;color:#000!important;cursor:pointer">Actions <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 170px; left:-112px">
                                <ul class="dropdownMenu" style="width: 170px">
                                    <li style="padding: 0px;">
                                    
                                    <a class="tiptip delete-filter"  href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                        Delete</a>
                                    </li>
                                    <li style="padding: 0px;">
                                        <a class=" editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>" data-filter-page="<?php echo $filter->filter_page; ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </td>
                    <!-- <td><a class="tiptip btn btn-delete delete-filter" href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                    <!-- <td><a class="btn btn-edit editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                </tr>
            <?php
            }
            if (!count($lead_filters)) {
                ?>
            <tr>
                <td colspan="6" class="centered">No filters defined! Please add some to get started!</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="clientTemplatesTypeContainer" id="typeSection_5">
        <table class="boxed-table filter-list" width="100%" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <td class="filter_table_checkbox" width="5%"><input type="checkbox" id="filterMasterCheckbox"></input></td>
                <td width="5%"><i class="fa fa-fw fa-sort"></i> </td>
                <td style="text-align: left;" width="15%">Created</td>
                <td style="text-align: left;" width="25%">Filter Name</td>
                <td style="text-align: left;" width="20%">Filter</td>
                <td style="text-align: left;" width="15%">Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;

            foreach ($prospect_filters as $filter) {
                $filter_check = json_decode($filter->filter_data);
                
                $k++;
                ?>
                <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="filter_<?php echo $filter->id; ?>">
                <td><input type="checkbox" class="filterGroupCheckbox" data-filter-id="<?php echo $filter->id ?>"></input></td>
                    <td class="center" style="text-align: center;">
                        <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
                    </td>
                    <td>
                        <span ><?php echo date('m/d/y g:ia', strtotime($filter->created_at)); ?></span>
                    </td>
                    <td>
                        <span  id="filterName_<?php echo $filter->id ?>" ><?php echo $filter->filter_name; ?></span>
                        
                    </td>
                    
                    <td>
                        <span ><a href="#" class="filterTipTipData" data-filter-jason='<?php echo $filter->filter_data; ?>'   data-tiptip-filter-id="<?php echo $filter->id ?>"> View Filters</a> 
                    </td>
                    
                    <td>
                        <div class="dropdownButton">
                            <a class="dropdownToggle m-btn" style="background:none;margin-right:0px;color:#000!important;cursor:pointer">Actions <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 170px; left:-112px">
                                <ul class="dropdownMenu" style="width: 170px">
                                    <li style="padding: 0px;">
                                    
                                    <a class="tiptip delete-filter"  href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                        Delete</a>
                                    </li>
                                    <li style="padding: 0px;">
                                        <a class=" editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>" data-filter-page="<?php echo $filter->filter_page; ?>">
                                            <i class="fa fa-fw fa-edit"></i>
                                            Edit
                                        </a>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </td>
                    <!-- <td><a class="tiptip btn btn-delete delete-filter" href="<?php echo site_url('account/deleteProposalFilter/' . $filter->id) ?>" title="Delete <?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                    <!-- <td><a class="btn btn-edit editFilterName" data-filter-id="<?php echo $filter->id ?>" data-filter-name="<?php echo $filter->filter_name; ?>">&nbsp;</a></td> -->
                </tr>
            <?php
            }
            if (!count($prospect_filters)) {
                ?>
            <tr>
                <td colspan="6" class="centered">No filters defined! Please add some to get started!</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        
        var deleteURL;
        $(".delete-filter").click(function () {
            deleteURL = $(this).attr('href');
            $("#confirm").dialog('open');
            return false;
        });
        $("#confirm").dialog({
            autoOpen: false,
            buttons: {
                Delete: function () {
                    document.location.href = deleteURL;
                },
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
    });
    var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
    // Sortable categories
    $(".filter-list tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                console.log(postData);
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateFilterOrder') ?>",
                    data:postData,
                    //async:false
                });
            }
        });

        


        $('.editFilterName').click(function() {
            
            filterId = $(this).data('filter-id');
            filterName = $(this).data('filter-name');
            filterPage = $(this).data('filter-page');

            swal({
            title: 'Edit Filter',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons:false,
            html:
            '<input id="swal-input1" class="swal2-input" value="'+filterName+'" Placeholder="Enter Filter Name"><br><span id="nameExist"></span>',
            preConfirm: function () {
                if($('#swal-input1').val()){
                    
                    return new Promise(function (resolve) {
                    var name= $('#swal-input1').val();
                    console.log(name);
                    $.ajax({
                        url: '<?php echo site_url('ajax/checkEditFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:name,id:filterId,type:filterPage},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Alredy Exist!"); 
                               $('#swal-input1').addClass("error");
                               console.log("into if of name validation ajax");
                               return false;
                            }
                            else{
                                resolve(
                                    $('#swal-input1').val()

                                )
                            }
                        }
                    })
                        
                    })
                }else{
                    alert('Please Enter the filter Name');
                }
            },
            onOpen: function () {
                $('#swal-input1').focus();
                $('.swal2-modal').attr('id','send_proposal_popup');
            }
        }).then(function (result) {

            swal('Saving..');
            console.log(result,"of result");
            $.ajax({
                url: '<?php echo site_url('ajax/edit_proposal_filter') ?>',
                type: "POST",
                dataType: "json",
                data: {
                    "filterName":result,
                    "filterId":filterId
                },

                success: function (response) {
                    if(response.success == true)
                    {
                        swal('Filter Name saved');
                        var resFilter = response.filter_id;
                        var updatedAt = response.updatedAt;
                       
                        console.log(updatedAt);
                        $('#filterName_'+resFilter).text(result);
                        $('#updateTime_'+resFilter).text(updatedAt);
                        // var fitler_id = 'filterName_'+resFilter;
                        // var update_time = 'updateTime_'+resfilter;
                        // var updatedAt = response.updatedAt;
                        // //document.getElementById(""+update_time+"").innerHTML = updatedAt;
                        // console.log(updatedAt);
                        //document.getElementById(""+fitler_id+"").innerHTML = result;

                    }
                    else {
                        swal("Error", "An error occurred Please try again");
                        return false;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    swal("Error", "An error occurred Please try again");
                    console.log(errorThrown);
                }
            })
        }).catch(swal.noop) 
    })

    $("#filterMasterCheckbox").change(function () {
           
        var checked = $(this).is(":checked");
      
        $(".filterGroupCheckbox").prop('checked', checked);
        $.uniform.update();
        updateNumSelected();
});

    $(".filterGroupCheckbox").live('change', function () {
        updateNumSelected();
    });

    // Group action selected numbers
    function updateNumSelected(){
        var num = $(".filterGroupCheckbox:checked").length;
      

        // Hide the options if 0 selected
        if (num >0) {
            $(".group_delete").css('visibility','visible');
           
        }
        else {
            $(".group_delete").css('visibility','hidden');
            
        }
        //$("#numSelected").html(num);
    }
     /* get a list of the selected IDs */
     function getSelectedIds() {
        var IDs = new Array();
        $(".filterGroupCheckbox:checked").each(function () {
            IDs.push($(this).data('filter-id'));
        });
        return IDs;
    }
    
    $(".group_delete").click(function () {
        var count = $(".filterGroupCheckbox:checked").length;
        swal({
                title: "Delete Filters?",
                text: "Are you sure you want to delete these "+count+" filters .",
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
                        url: "<?php echo site_url('ajax/groupDeleteSavedFilter') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'filterIds': getSelectedIds(),
                        },

                        success: function( data){

                            swal(count+' Filters deleted');
                            location.reload();
                            
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Filter not Deleted :)", "error");
                }
            });
});

$(document).on('click', ".filterTipTipData", function() {

    $this = this;

    tiptip_filter_id = $(this).data('tiptip-filter-id');
    var proposal_filters = $(this).data('filter-jason');
    console.log(proposal_filters);



    var filter_text = "<div id='filter_details_container' style='max-height:400px;overflow-y:scroll;'>";
    var filter_count = 0;

    if (proposal_filters) {

        if (proposal_filters.pFilterStatus) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterStatus.length; $i++) {
                temp_text += proposal_filters.pFilterStatus[$i] + '<br/>';
            }
            console.log(temp_text)
            filter_text +=
                "<table class='filter_details' style='width:100%' ><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }
        if (proposal_filters.pFilterJobCostStatus) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterJobCostStatus.length; $i++) {
                temp_text += proposal_filters.pFilterJobCostStatus[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>JobCost Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }
        if (proposal_filters.pFilterEstimateStatus) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterEstimateStatus.length; $i++) {
                temp_text += proposal_filters.pFilterEstimateStatus[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Estimate Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }
        if (proposal_filters.pFilterUser) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterUser.length; $i++) {
                temp_text += proposal_filters.pFilterUser[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.pFilterEmailStatus) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterEmailStatus.length; $i++) {
                temp_text += proposal_filters.pFilterEmailStatus[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Email Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }
        if (proposal_filters.pFilterQueue) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterQueue.length; $i++) {
                temp_text += proposal_filters.pFilterQueue[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Queue Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }

        if (proposal_filters.pFilterClientAccount) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterClientAccount.length; $i++) {
                temp_text += proposal_filters.pFilterClientAccount[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Accounts:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }

        if (proposal_filters.pFilterBusinessType) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.pFilterBusinessType.length; $i++) {
                temp_text += proposal_filters.pFilterBusinessType[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";

        }

        var bidText = '';
        if (proposal_filters.pFilterMaxBid) {
            bidText +=
                "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Bid:</strong><span style='float:left;text-align: left;width:60%'>From $" +
                proposal_filters.pFilterMaxBid;
        }
        if (proposal_filters.pFilterMinBid > 0) {
            if (bidText != '') {
                bidText += ' To $' + proposal_filters.pFilterMinBid + '</span></p><br/>';
            } else {
                if (proposal_filters.pFilterMinBid > 0) {
                    bidText +=
                        "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Bid:</strong><span style='float:left;text-align: left;width:60%'>Up To $" +
                        proposal_filters.pFilterMinBid + "</span></p><br/>";
                }
            }

        } else {
            if (bidText != '') {
                bidText += '</span></p><br/>';
            }
        }
        filter_text += bidText;

        if (bidText != '') {
            filter_count++;
        }
        var createdText = '';
        console.log(proposal_filters.pCreatedFrom)
        if (proposal_filters.pCreatedFrom && proposal_filters.pCreatedFrom != '') {
            createdText +=
                "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Created:</strong><span style='float:left;text-align: left;width:60%'>From " +
                proposal_filters.pCreatedFrom;
        }
        if (proposal_filters.pCreatedTo && proposal_filters.pCreatedTo != '') {
            if (createdText != '') {
                createdText += ' To ' + proposal_filters.pCreatedTo + '</span></p><br/>';
            } else {
                createdText +=
                    "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Created:</strong><span style='float:left;text-align: left;width:60%'>Before " +
                    proposal_filters.pCreatedTo + "</span></p><br/>";
            }

        } else {
            if (createdText != '') {
                createdText += '</span></p><br/>';
            }
        }
        filter_text += createdText;
        if (createdText != '') {
            filter_count++;
        }

        var activityText = '';
        if (proposal_filters.pActivityFrom && proposal_filters.pActivityFrom != '') {
            activityText +=
                "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Activity:</strong><span style='float:left;text-align: left;width:60%'>From " +
                proposal_filters.pActivityFrom;
        }
        if (proposal_filters.pActivityTo && proposal_filters.pActivityTo != '') {
            if (activityText != '') {
                activityText += ' To ' + proposal_filters.pActivityTo + '</span></p><br/>';
            } else {
                activityText +=
                    "<p style='width:100%;text-align:left;'><strong style='float:left;text-align:center;width:40%'>Activity:</strong><span style='float:left;text-align: left;width:60%'>Before " +
                    proposal_filters.pActivityTo + "</span></p><br/>";
            }
        } else {
            if (activityText != '') {
                activityText += '</span></p><br/>';
            }
        }
        filter_text += activityText;
        if (activityText != '') {
            filter_count++;
        }

        //ResendEmail ON/OFF
        var resendText = '';
        if (proposal_filters.pResendInclude != proposal_filters.pResendExclude) {
            resendText +="<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Resend Email:</strong><span style='float:left;text-align: left;width:60%'>";
            if(proposal_filters.pResendInclude=='1'){
                resendText +="Email On";
            }else{
                resendText +="Email Off";
            }
            resendText += '</span></p><br/>';
        }

        filter_text += resendText;
        if (resendText != '') {
            filter_count++;
        }

        //Signature
        var signedText = '';
        if (proposal_filters.pSigned != proposal_filters.pUnsigned) {
            signedText +="<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Signature:</strong><span style='float:left;text-align: left;width:60%'>";
            if(proposal_filters.pSigned=='1'){
                signedText +="Signed";
            }else{
                signedText +="Unsigned";
            }
            signedText += '</span></p><br/>';
        }

        filter_text += signedText;
        if (signedText != '') {
            filter_count++;
        }




        // prospect filters
        if (proposal_filters.ptFilterUser) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.ptFilterUser.length; $i++) {
                temp_text += proposal_filters.ptFilterUser[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.ptFilterRating) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.ptFilterRating.length; $i++) {
                temp_text += proposal_filters.ptFilterRating[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Ratings:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.ptFilterSourceObject) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.ptFilterSourceObject.length; $i++) {
                temp_text += proposal_filters.ptFilterSourceObject[$i].name + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Sources:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.ptFilterBusinessType) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.ptFilterBusinessType.length; $i++) {
                temp_text += proposal_filters.ptFilterBusinessType[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Business Types:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        // client filter
        if (proposal_filters.cFilterUser) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.cFilterUser.length; $i++) {
                temp_text += proposal_filters.cFilterUser[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.cFilterClientAccount) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.cFilterClientAccount.length; $i++) {
                temp_text += proposal_filters.cFilterClientAccount[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Client Accounts:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.cFilterBusinessType) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.cFilterBusinessType.length; $i++) {
                temp_text += proposal_filters.cFilterBusinessType[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Business Types:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        // Lead Filters
        var leadCreated = '';
        if (proposal_filters.lFilterDateStart && proposal_filters.lFilterDateStart != '') {
            leadCreated +=
                "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Created:</strong><span style='float:left;text-align: left;width:60%'>From " +
                proposal_filters.lFilterDateStart;
        }
        if (proposal_filters.lFilterDateStart && proposal_filters.lFilterDateStart != '') {
            if (leadCreated != '') {
                leadCreated += ' To ' + proposal_filters.lFilterDateEnd + '</span></p><br/>';
            } else {
                leadCreated +=
                    "<p style='width:100%;float:left;'><strong style='float:left;text-align:center;width:40%'>Created:</strong><span style='float:left;text-align: left;width:60%'>Before " +
                    proposal_filters.lFilterDateEnd + "</span></p><br/>";
            }

        } else {
            if (leadCreated != '') {
                leadCreated += '</span></p><br/>';
            }
        }
        filter_text += leadCreated;
        if (leadCreated != '') {
            filter_count++;
        }

        if (proposal_filters.lFilterUser) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.lFilterUser.length; $i++) {
                temp_text += proposal_filters.lFilterUser[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.lFilterSource) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.lFilterSource.length; $i++) {
                temp_text += proposal_filters.lFilterSource[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Sources:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.lFilterStatus) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.lFilterStatus.length; $i++) {
                temp_text += proposal_filters.lFilterStatus[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Status:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        if (proposal_filters.lFilterBusinessType) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.lFilterBusinessType.length; $i++) {
                temp_text += proposal_filters.lFilterBusinessType[$i] + '<br/>';
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Business Types:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }

        // Account Filters

        if (proposal_filters.accFilterUserObject) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.accFilterUserObject.length; $i++) {
                temp_text += proposal_filters.accFilterUserObject[$i].name + '<br/>';
                console.log(proposal_filters.accFilterUserObject[$i].name);
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>User:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }
        
        if (proposal_filters.accFilterOwnerAccount) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.accFilterOwnerAccount.length; $i++) {
                temp_text += proposal_filters.accFilterOwnerAccount[$i].name + '<br/>';
                console.log(proposal_filters.accFilterOwnerAccount[$i].name);
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Owner:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }
        
        if (proposal_filters.accFilterBusinessTypeObject) {
            filter_count++;
            var temp_text = '';
            for ($i = 0; $i < proposal_filters.accFilterBusinessTypeObject.length; $i++) {
                temp_text += proposal_filters.accFilterBusinessTypeObject[$i].name + '<br/>';
                console.log(proposal_filters.accFilterBusinessTypeObject[$i].name);
            }
            filter_text +=
                "<table style='width:100%'><tr><td style='vertical-align: top;width:40%'><strong style='text-align:left;'>Business Types:</strong></td><td style='text-align: left;width:60%'><span>" +
                temp_text + "</span></td></tr></table>";
        }
    }

    filter_text += '</div>';
    swal({
        title: 'Filters',
        allowOutsideClick: false,
        showCancelButton: false,
        confirmButtonText: 'Ok',
        dangerMode: false,
        reverseButtons: false,
        html: filter_text,


    }).catch(swal.noop)

    return false;
});
function showFilterTable(nr) {
    document.getElementById("typeSection_1").style.display="none";
    document.getElementById("typeSection_2").style.display="none";
    document.getElementById("typeSection_3").style.display="none";
    document.getElementById("typeSection_4").style.display="none";
    document.getElementById("typeSection_5").style.display="none";
    document.getElementById("typeSection_"+nr).style.display="block";

    document.getElementById("activeHead_1").classList.remove("active");
    document.getElementById("activeHead_2").classList.remove("active");
    document.getElementById("activeHead_3").classList.remove("active");
    document.getElementById("activeHead_4").classList.remove("active");
    document.getElementById("activeHead_5").classList.remove("active");
    document.getElementById("activeHead_"+nr).classList.add("active");
}
</script>
<div id="confirm">
    Are you sure you want to delete the Filter?
</div>