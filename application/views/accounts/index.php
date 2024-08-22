<?php /* @var $account \models\Accounts */ ?>
<?php $this->load->view('global/header'); ?>
    <style>
        .dataTables-companies {
            table-layout: fixed;
            width: 100% !important;
        }

        .paging_full_numbers {
            width: 500px !important;
        }

        .dataTables_info {
            width: 46% !important;
            clear: none !important;
        }
        .locked-tag .select2-selection__choice__remove{
            display: none!important;
        }
        .locked-tag:before {
            font-family: "FontAwesome";
            content: "\f023";
            border-right: 1px solid #aaa;
            cursor: pointer;
            font-weight: bold;
            padding: 0 4px;
        }
        .select2-container .select2-search--inline .select2-search__field{margin-top:8px!important;}
.dataTables-companies tbody tr.odd.selectedRow,
.dataTables-companies tbody tr.even.selectedRow,
.dataTables-companies tbody tr.even.selectedRow td.sorting_1,
.dataTables-companies tbody tr.odd.selectedRow td.sorting_1
{
    background-color: #e4e3e3!important;
}
#residential_delete
{
    color: red;
    font-weight: bold;
    margin-top: 12px;
}    
</style>

    <input type="hidden" id="delayUI" value="1" />
    <div id="content" class="clearfix">
        <div class="widthfix">

            <?php
            if ($account->hasFullAccess()) {
                $this->load->view('templates/accounts/filters-new');
            }
            ?>
                    
            <div class="content-box">
                <div class="box-header">
                    <span style="float: left; color: #fff; margin-right: 15px; ">Accounts</span>

                    <div class="tableLoader" style="width: 150px; display: none; position: absolute; left: 421px; top: 8px;">
                        <img src="/static/loading-bars.svg">
                    </div>

                    <a class="box-action tiptip add_contact_btn"href="javascript:void(0);"  title="Add a new contact">Add
                        Contact</a>
                    <!-- <a class="box-action box-action-left groupAction" id="groupMerge">Merge</a>
                    <?php if ($account->isAdministrator()) { ?>
                    <a class="box-action box-action-left groupAction" id="groupDelete">Delete</a>
                    <?php } ?> -->
                    <div class="clearfix"></div>
                </div>
                <div class="box-content">
                    <table cellpadding="0" cellspacing="0" border="0" class="dataTables-companies display"
                           id="accountTable">
                        <thead>
                        <tr>
                            <td><input type="checkbox" id="accountMasterCheck"></td>
                            <td></td>
                            <td>Company</td>
                            <td>Business</td>
                            <td>Contacts</td>
                            <td>Proposals</td>
                            <td>Total Bid</td>
                            <td>Won <a href="javascript:void(0);" class="tiptipleft" title="Total Value of proposals that have a 'Won' status. This includes Completed, Invoiced etc.<br/><br/>This value excludes dupliate proposals"><i class="fa fa-fw fa-info-circle " ></i></a></td>
                            <td>Win Rate <a href="javascript:void(0);" class="tiptipleft" title="Percentage of Total Amount Bid that was Won.<br/><br/>This value excludes duplicate proposals"><i class="fa fa-fw fa-info-circle " ></i></a></td>
                            <td>Owner</td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <div class="javascript_loaded">

        <div id="confirm-delete-message" title="Confirmation">
            <p>Are you sure you want to delete the account?</p>

            <a id="client-delete" href="" rel=""></a>
        </div>

        <div id="group-delete-confirm" title="Confirmation">
            <p>Are you sure you want to delete these accounts?</p><br/>
            <p>All contacts and proposals for this account will also be deleted.</p>
            <p></p>
            <p id="residential_delete"></p>
        </div>

        <div id="confirm-merge-message" title="Confirmation">
            <p>Are you sure you want to merge this account?</p>
            <br/>
            <div id="accountReassign">
                <p>All clients and proposals will be moved to the selected account. The original account will be
                    deleted.</p>
                <br/>
                <strong>Search Account</strong>
                <select name="accountReassignTo" id="accountReassignTo" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option></option></select>
            
                <br/><br/>
                <p>You can manage your account clients <a href="" id="accountClientsLink">here</a></p>

                <a id="client-merge" href="" rel=""></a>
                <input type="hidden" id="client-merge-id">
                
            </div>
        </div>

        <div id="group-merge-message" title="Confirmation">
            <p>Are you sure you want to merge these account?</p>
            <br/>
            <div id="accountReassign">
                <p>All clients and proposals will be moved to the selected account. The original accounts will be
                    deleted.</p>
                <br/>
                
                <strong>Search Account</strong>
                <select name="groupReassignTo" id="groupReassignTo" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option></option></select>
                <br/>
                
            </div>
        </div>

        
        <div id="change-business-type" title="Change Account Business Type">
                    <p>Choose one or many Business Types to assign to the selected  <span id="changeBusinessTypeNum"></span> Accounts</p><br/>
                    <p><strong> Note:</strong> Any existing business types will be removed and replaced with the selected business types only</p><br/>
                    <label style="padding-left: 4px;padding-right: 3px;">Account Business Type</label> 
                    <select  class="dont-uniform businessTypeMultiple"  style="width: 64%" name="business_type[]" multiple="multiple">
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select>
                    <p style="padding-left: 145px;padding-top: 8px;float: left;"><input type="checkbox" name="apply_bt_on_contact" id="apply_bt_on_contact"><span style="padding-top: 2px;float: left;"> Edit all Contacts and Proposals to this Business Type</span></p>
                    
                    <p style="padding-top: 8px;float: left;" class="bt_on_proposal_p">
                    <label >Proposal Business Type</label>
                        <select name="apply_bt_on_proposal" id="apply_bt_on_proposal"> 
                        <option value=""> Please select</option>
                        <?php 
                                    foreach($businessTypes as $businessType){
                                        echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                    }
                               ?></select></p> 
                    <p class="bt_on_proposal_p" style="padding-left: 147px;padding-top: 8px;float: left;">Please select any one(1) Business Type for proposals.</p><br/>               
                    <p id="changeBusinessTypeStatus" style="float: left;padding-top: 10px;"></p>
                </div>
            <div id="change-account-business-type" title="Update Account Business Type">
            <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;padding-left: 94px;">Account: </span><span class="change-bt-account-name"></span></p>
                   
                <label style="padding-left: 5px;"><strong>Account Business Type</strong></label> 
                <input type="hidden" id="business_account_id" name="accountsChangeBusinessTypes">
                <select  class="dont-uniform accountBusinessTypeMultiple"  style="width: 64%" name="account_business_type[]" multiple="multiple">
                    <?php 
                        foreach($businessTypes as $businessType){
                            echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                        }
                    ?>
                </select>
                <p style="padding-left: 155px;padding-top: 8px;float: left;"><input type="checkbox" name="apply_account_bt_on_contact" id="apply_account_bt_on_contact"><span style="padding-top: 2px;float: left;"> Edit all Contacts and Proposals to this Business Type</span></p>
                    
                    <p style="padding-top: 8px;float: left;display:none" class="account_bt_on_proposal_p">
                    <label ><strong>Proposal Business Type</strong></label>
                        <select name="apply_account_bt_on_proposal" id="apply_account_bt_on_proposal"> 
                        <option value=""> Please select</option>
                        <?php 
                                    foreach($businessTypes as $businessType){
                                        echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                    }
                               ?></select></p> 
                <p class="account_bt_on_proposal_p" style="display:none;padding-left: 160px;padding-top: 8px;float: left;">Please select any one(1) Business Type for proposals.</p><br/>               
                    

            </div>

        <div id="group-merge-status" title="Confirmation">
            <br/>
            <p id="groupMergeText" style="text-align: center;"></p>
        </div>

        <div id="group-delete-status" title="Confirmation">
            <br/>
            <p id="groupDeleteText" style="text-align: center;"></p>
        </div>

        <div id="permission-denied" title="Error">
            <br/>
            <p>You do not have the permission to do this. Please contact your administrator.</p>
        </div>

    </div>
    <script src="<?= site_url('3rdparty/DataTables-new/datatables.min.js'); ?>"></script>
    <script src="<?= site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.jqueryui.min.js'); ?>"></script>


    <link rel="stylesheet" type="text/css" href="<?= site_url('3rdparty/DataTables-new/datatables.min.css'); ?>"
          media="all">

    <div id="datatablesError" title="Error" style="text-align: center; display: none;">
        <h3>Oops, something went wrong</h3>

        <p>We're having a problem loading this page.</p><br/>
        <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact
                support</a> if this keeps happening.</p>
    </div>
    <style>.select2-container {
width: 250px !important;
padding: 0;
}</style>
<div id="template" style="display: none;">
        <div class="dropdownMenuContainer single">

            <div class="closeDropdown closeAccountDropdown" style="line-height: 10px;position: absolute;right: 0;">
                <a href="javascript:void(0);" class="closeDropdownMenu1">&times;</a>
            </div>

            <div class="" style="font-size: 17px;padding:8px 15px;    border-bottom: 1px solid #e2e2e2;">
                <p>Accounts Options</p>
            </div>

            <div class="" style="font-size: 18px;padding:8px 15px;">
                <p style="text-align: center;">{companyName} | {ownerFullname}</p>
            </div>
            
            
        <ul class="dropdownMenu">
            
            <li>
                <a href="<?php echo site_url('accounts/info/{accountId}') ?>">
                    <img src="/3rdparty/icons/information.png"> Account Info
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('accounts/proposals/{accountId}') ?>">
                    <img src="/3rdparty/icons/page_go.png"> View Proposals
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('accounts/clients/{accountId}') ?>">
                    <img src="/3rdparty/icons/user_gray.png"> View Contacts
                </a>
            </li>
        </ul>
        <ul class="dropdownMenu">
            <li>
                <a href="<?php echo site_url('accounts/edit/{accountId}') ?>">
                    <img src="/3rdparty/icons/user_edit.png"> Edit Account
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('accounts/merge/{accountId}') ?>"
                   data-account-id="{accountId}"
                   data-num-clients="{numContacts}"
                   class="confirm-merge">
                    <img src="/3rdparty/icons/arrow_join.png"> Merge Account
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('accounts/delete/{accountId}') ?>"
                   data-account-id="{accountId}"
                   data-num-clients="{numContacts}"
                   class="confirm-delete">
                    <img src="/3rdparty/icons/delete.png"> Delete Account
                </a>
            </li>

        </ul>
        </div>
    </div>

    <script type="text/javascript">
var accountFilter;
        var ui = false;

        $(document).ready(function () {
            $('.businessTypeMultiple').select2({
                        placeholder: "Select one or many"
                    });
            
                    
  $.fn.select2.amd.require(['select2/selection/search'], function (Search) {
    var oldRemoveChoice = Search.prototype.searchRemoveChoice;
    
    Search.prototype.searchRemoveChoice = function (e) {
        var check_id = arguments[1].id;
        var checked = $('#apply_account_bt_on_contact').is(':checked');
        var disabled = $(".accountBusinessTypeMultiple option[value='"+check_id+"']").prop('disabled');
         if(disabled && !checked){
            return false;
        }else{
            oldRemoveChoice.apply(this, arguments);
            this.$search.val('');
        }
        
    };
            $('.accountBusinessTypeMultiple').select2({
                placeholder: "Select one or many",
                html: true,
                templateSelection : function (tag, container){
                            var $option = $('.accountBusinessTypeMultiple option[value="'+tag.id+'"]');
                            if ($option.attr('disabled')){
                                $(container).addClass('locked-tag');
                                $(container).addClass('tag_tiptip');
                                tag.title = 'This business type can not be deleted<br/> Because a proposal or contact belonging to this account has this Business Type';
                                tag.locked = true;
                            }else{
                                tag.title = tag.text;
                            }
                            return tag.text;
                            
                        },
            });
    });

            $("#preset").val('ytd');
            // Datatables error Dialog
            $("#datatablesError").dialog({
                width: 500,
                modal: true,
                buttons: {
                    Retry: function () {
                        window.location.reload();
                    }
                },
                autoOpen: false
            });
            
        });
    </script>
    <script type="text/javascript">
        var accTable;
        var disable_business_types;
        $(document).ready(function () {

            deletePermission = <?php echo($account->isAdministrator() ? 'true' : 'false'); ?>;
            $.fn.dataTable.ext.errMode = 'none';

            function initTable() {
                accTable = $('.dataTables-companies').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                    $("#datatablesError").dialog('open');
                })
                .on('processing.dt', function (e, settings, processing) {
                    if (processing) {
                        $(".tableLoader").show();
                    } else {
                        $(".tableLoader").hide();
                    }
                })
                .DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo site_url('ajax/ajaxGetAccounts'); ?>",
                    "columnDefs": [
                        {
                            "targets": [0],
                            "width": '15px',
                            "searchable": false,
                            "sortable": false,
                            'class': 'dtCenter'
                        },
                        {"targets": [1], "sortable": false, "width": "50px"},
                        {"targets": [2], "sortable": true},
                        {"targets": [3], "sortable": false},
                        {"targets": [4], "sortable": true, 'class': 'dtCenter'},
                        {"targets": [5], "sortable": true, 'class': 'dtCenter'},
                        {"targets": [6], "sortable": true},
                        {"targets": [7], "sortable": true},
                        {"targets": [8], "sortable": true},
                        {"targets": [9], "sortable": true},
                    ],
                    "sorting": [
                        [6, "desc"]
                    ],
                    "jQueryUI": true,
                    "autoWidth": false,
                    "stateSave": true,
                    "scrollY": '70vh',
                    "scrollCollapse": true,
                    "paginationType": "full_numbers",
                    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, 1000],
                        [10, 25, 50, 100, 200, 500, 1000]
                    ],
                    "preDrawCallback": function( settings ) {
                        if ($.fn.DataTable.isDataTable('.dataTables-companies')) {
                            var dt = $('.dataTables-companies').DataTable();

                            //Abort previous ajax request if it is still in process.
                            var settings = dt.settings();
                            if (settings[0].jqXHR) {
                                settings[0].jqXHR.abort();
                            }
                        }
                    },
                    "drawCallback": function (settings) {

                        if (!ui) {
                            initUI();
                            ui = true;
                        }
                        initTiptip();
                        check_highlighted_row();
                        updateNumSelected();
                        if (accTable) {
                            $("#filterNumResults").text(accTable.page.info().recordsDisplay);
                        }
                        $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
                        $("#accountMasterCheck").prop('checked', false);
                        $("#filterLoading").hide();
                        $("#filterResults").show();
                        //$("#filterResults").css('visibility', 'visible');
                    }
                });
            }


            $(".filterButton").click(function () {
                $(".newFilterContainer").toggle();
                $(".groupActionsContainer").hide();
            });

            $("#newProposalFilterButton").click(function () {
                hideInfoSlider();
                $("#newProposalFilters").toggle();
                // Clear search so that filters aren't affected
                accTable.search('');
                // Hide group action menu
                $(".groupActionsContainer").hide();
            });

            $("#closeFilters").click(function () {
                $(".newFilterContainer").toggle();
                $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
            });

            $(".filterColumnWide .filterColumnHeader").click(function () {
                $(this).parents('.filterColumnWide').toggleClass('filterCollapse');

            });

            $(".filterColumn .filterColumnHeader").click(function () {
                $(this).parents('.filterColumn').toggleClass('filterCollapse');
            });

            // Group Actions Button
            $("#groupActionsButton").click(function () {
                // Hide the filter content
                $(".newFilterContainer").hide();
                // Toggle the buttons
                $(".groupActionsContainer").toggle();
            });

            //Hide Menu when clicking on a group action item
            $(".groupActionItems a").click(function () {
                $(".groupActionsContainer").hide();
                return false;
            });

            $(".filterCheck").click(function () {

                // If it's a branch click
                if ($(this).hasClass('branchFilterCheck')) {
                    // So, we're clicking on a branch //
                    // How many are there? //
                    var numBranches = $(".branchFilterCheck").length;
                    var numSelectedBranches = $(".branchFilterCheck:checked").length;
                    var selectedBranches = [];

                    // If all branches selects, check the all box and all users
                    if (numSelectedBranches == numBranches) {
                        $("#allUsersCheck").prop('checked', true);
                        // Check all users
                        $('.userFilterCheck').prop('checked', true);
                    } else {
                        $("#allUsersCheck").prop('checked', false);

                        // Check the users of the selected branches
                        selectedBranches = $(".branchFilterCheck:checked").map(function () {
                            return $(this).data('branch-id');
                        }).get();

                        $('.userFilterCheck').not('.branchFilterCheck').each(function () {
                            var branchId = $(this).data('branch-id');
                            if (selectedBranches.indexOf(branchId) < 0) {
                                $(this).prop('checked', false);
                            } else {
                                $(this).prop('checked', true);
                            }
                        });

                    }
                    console.log(selectedBranches);

                } else if ($(this).hasClass('userFilterCheck')) {
                    // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
                    $('.branchFilterCheck').prop('checked', false);

                    var selectedUserBranches = $(".userFilterCheck:checked").map(function () {
                        return $(this).data('branch-id');
                    }).get();

                    var uniqueUserBranches = Array.from(new Set(selectedUserBranches));

                    if (uniqueUserBranches.length > 1) {
                        $('.branchFilterCheck').prop('checked', false);
                    } else {

                        // Do we need to check the branc box?
                        var branchIds = selectedBranches = $(".branchFilterCheck").map(function () {
                            return $(this).data('branch-id');
                        }).get();


                        $.each(branchIds, function (index, value) {
                            // Count how many there are
                            var totalBranchUsers = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').length;
                            var numUnchecked = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').not(':checked').length;

                            if (totalBranchUsers > 0 && numUnchecked == 0) {
                                $('.branchFilterCheck[data-branch-id="' + value + '"]').prop('checked', true);
                            }
                        });
                    }
                }
                
                
                
                
                
                else if ($(this).hasClass('aBranchFilterCheck')) {
                    // So, we're clicking on a branch //
                    // How many are there? //
                    var numABranches = $(".aBranchFilterCheck").length;
                    var numASelectedBranches = $(".aBranchFilterCheck:checked").length;
                    var selectedABranches = [];

                    // If all branches selects, check the all box and all users
                    if (numASelectedBranches == numABranches) {
                        $("#allAUsersCheck").prop('checked', true);
                        // Check all users
                        $('.aUserFilterCheck').prop('checked', true);
                    } else {
                        $("#allAUsersCheck").prop('checked', false);

                        // Check the users of the selected branches
                        selectedABranches = $(".aBranchFilterCheck:checked").map(function () {
                            return $(this).data('branch-id');
                        }).get();

                        $('.aUserFilterCheck').not('.aBranchFilterCheck').each(function () {
                            var branchId = $(this).data('branch-id');
                            if (selectedABranches.indexOf(branchId) < 0) {
                                $(this).prop('checked', false);
                            } else {
                                $(this).prop('checked', true);
                            }
                        });

                    }
                    console.log(selectedABranches);

                } else if ($(this).hasClass('aUserFilterCheck')) {
                    // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
                    $('.aBranchFilterCheck').prop('checked', false);

                    var selectedUserABranches = $(".aUserFilterCheck:checked").map(function () {
                        return $(this).data('branch-id');
                    }).get();

                    var uniqueUserABranches = Array.from(new Set(selectedUserABranches));

                    if (uniqueUserABranches.length > 1) {
                        $('.aBranchFilterCheck').prop('checked', false);
                    } else {

                        // Do we need to check the branc box?
                        var aBranchIds = selectedABranches = $(".aBranchFilterCheck").map(function () {
                            return $(this).data('branch-id');
                        }).get();


                        $.each(aBranchIds, function (index, value) {
                            // Count how many there are
                            var totalABranchUsers = $('[data-branch-id="' + value + '"]').not('.aBranchFilterCheck').length;
                            var numaUnchecked = $('[data-branch-id="' + value + '"]').not('.aBranchFilterCheck').not(':checked').length;

                            if (totalABranchUsers > 0 && numaUnchecked == 0) {
                                $('.aBranchFilterCheck[data-branch-id="' + value + '"]').prop('checked', true);
                            }
                        });
                    }
                } 
                
                
                else if ($(this).hasClass('statusFilterCheck')) {
                    if ($(this).val() == 'Converted' || $(this).val() == 'Cancelled' || $(this).val() == 'On Hold' || $(this).val() == 'Waiting for Subs') {
                        $(".statusFilterCheck[value='Active']").prop('checked', false);
                    } else {
                        $(".statusFilterCheck[value!='Active']").prop('checked', false);
                    }
                }
                console.log('dd')
                $.uniform.update();
            });

            console.log('dd11')
            $(document).on('change', ".filterCheck", function () {

                if ($(this).hasClass('clientAccountFilterCheck') && $(this).hasClass('searchSelected')) {
                    if (!$(this).is(':checked')) {
                        $(this).parents('.filterColumnRow').remove();
                        $('#accountSearch').trigger('input');
                    }
                } else if ($(this).hasClass('clientAccountFilterCheck')) {
                    var parent = $(this).parents('.filterColumnRow');
                    parent.addClass('searchSelectedRow');
                    $(this).addClass('searchSelected');
                    parent.insertAfter('#accountRowAll');
                }

                var numSearchSelected = $('.searchSelected').length;
                if (numSearchSelected < 1) {
                    $('#allClientAccounts').prop('checked', true);
                } else {
                    $('#allClientAccounts').prop('checked', false);
                }

                $.uniform.update();
                applyFilter();
            });

            $(document).on('change', '.filterColumnCheck', function () {

                var showAll = false;
                var className = $(this).data('affected-class');

                if ($(this).attr('id') == 'allClientAccounts') {
                    if ($(this).is(':checked')) {
                        $("#accountSearch").val('');
                        $("#accountSearch").trigger('input');
                        $('.searchSelectedRow').remove();
                    }
                }

                if ($(this).is(':checked')) {
                    showAll = true;
                }

                $('.' + className).prop('checked', showAll);
                $.uniform.update();
                applyFilter();
            });

            // Removing user filter
            $(document).on('click', '#removeUserFilter', function () {
                $(".userFilterCheck").prop('checked', false);
                $.uniform.update();
                applyFilter();
            });
            // Removing businessTypeFilterCheck filter
            $(document).on('click', '#removeBusinessTypeFilter', function () {
                $(".businessTypeFilterCheck").prop('checked', false);
                $.uniform.update();
                applyFilter();
            });

             
            // Removing Account user filter
            $(document).on('click', '#removeAUserFilter', function () {
                $(".aUserFilterCheck").prop('checked', false);
                $.uniform.update();
                applyFilter();
            });

            // Removing source filter
            $(document).on('click', '#removeSourceFilter', function () {
                $(".sourceFilterCheck").prop('checked', false);
                $.uniform.update();
                applyFilter();
            });

            // Removing status filter
            $(document).on('click', '#removeStatusFilter', function () {
                $(".statusFilterCheck").prop('checked', false);
                $(".statusFilterCheck[value='Active']").prop('checked', true);
                $.uniform.update();
                applyFilter();
            });

            // New filter reset button
            $(".resetFilterButton").click(function () {

                // Reset Dates
                $('#preset').val('ytd');
                $('#preset').trigger('change');
                // Reset All Checkboxes
                $(".filterCheck, .filterColumnCheck").prop('checked', true);
                $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
                $('#saves_filter_list').val('');
                // Set Active as it's default (by unchecking others)
                $(".statusFilterCheck[value!='Active']").prop('checked', false);

                $.uniform.update();
                applyFilter();

                return false;
            });

            $("#aCreatedFrom, #aCreatedTo").datepicker();

            // Handle preset change
            $("#aCreatedFrom, #aCreatedTo").change(function () {
                //$("#createdPreset").val('custom');
                //$.uniform.update();
               // applyFilter();
            });

            $("#apply").on("click", function () {
  
                $(".show_from_date").text($("#aCreatedFrom").val());
                $(".show_to_date").text($("#aCreatedTo").val());
                applyFilter();
            });
            $("#aCreatedFrom, #aCreatedFrom").on('input', function () {
                //$("#createdPreset").val('custom');
                //$.uniform.update();
                //applyFilter();
            });



            // Run the filter by default
            applyFilter();

            function applyFilter() {
                $("#filterResults").hide();
                //$("#filterResults").css('visibility', 'hidden');
                $("#filterLoading").show();
                setTimeout(function () {
                    $(".resetFilter").show();

                    // Users & Branches
                    var users = [];
                    var userValues = [];
                    var aUsers = [];
                    var aUserValues = [];
                    // Lead BusinessTypes
                    var leadBusinessTypes = [];
                    var leadBusinessTypeValues = [];

                    if ($(".businessTypeFilterCheck:checked").length != $(".businessTypeFilterCheck").length) {
                        leadBusinessTypes = $(".businessTypeFilterCheck:checked").map(function () {
                            leadBusinessTypeValues.push($(this).attr('data-text-value'));
                            return $(this).val();
                        }).get();
                    }

                    if (!leadBusinessTypes.length) {
                        leadBusinessTypes = [];
                    }

                    if ($(".userFilterCheck:checked").not('.branchFilterCheck').length != $(".userFilterCheck").not('.branchFilterCheck').length) {
                        users = $(".userFilterCheck:checked").not('.branchFilterCheck').map(function () {
                            userValues.push($(this).data('text-value'));
                            return $(this).val();
                        }).get();
                    }
                    if ($(".aUserFilterCheck:checked").not('.aBranchFilterCheck').length != $(".aUserFilterCheck").not('.aBranchFilterCheck').length) {
                        aUsers = $(".aUserFilterCheck:checked").not('.aBranchFilterCheck').map(function () {
                            aUserValues.push($(this).data('text-value'));
                            return $(this).val();
                        }).get();
                    }
                    if (!users.length) {
                        users = [];
                    }

                    // Lead Sources
                    var leadSources = [];
                    var leadSourceValues = [];

                    if ($(".sourceFilterCheck:checked").length != $(".sourceFilterCheck").length) {
                        leadSources = $(".sourceFilterCheck:checked").map(function () {
                            leadSourceValues.push($(this).data('text-value'));
                            return $(this).data('text-value');
                        }).get();
                    }

                    if (!leadSources.length) {
                        leadSources = [];
                    }

                    // Statuses
                    var statuses = [];
                    var statusValues = [];

                    statuses = $(".statusFilterCheck:checked").map(function () {
                        statusValues.push($(this).data('text-value'));
                        return $(this).val();
                    }).get();

                    if (!statuses.length) {
                        statusValues = [];
                    }

                    // Due Dates
                    var dueDates = [];
                    var dueDateValues = [];

                    if ($(".dueDateFilterCheck:checked").length != $(".dueDateFilterCheck").length) {
                        dueDates = $(".dueDateFilterCheck:checked").map(function () {
                            dueDateValues.push($(this).data('text-value'));
                            return $(this).val();
                        }).get();
                    }

                    if (!dueDates.length) {
                        dueDateValues = [];
                    }

                    // Created Range
                    var aCreatedFrom = $("#aCreatedFrom").val();
                    var aCreatedTo = $("#aCreatedTo").val();

                    // Filter Badges  and UI Update//

                    var filterBadgeHtml = '';
                    var createdHeaderText = ' [ All ]';
                    var userHeaderText = ' [ All ]';
                    var aUserHeaderText = ' [ All ]';
                    var sourceHeaderText = ' [ All ]';
                    var businessTypeHeaderText = ' [ All ]';
                    var statusHeaderText = ' [ All ]';
                    var dueDateHeaderText = ' [ All ]';
                    var numFilters = 0;


                    // Date Range

                    // User
                    if (userValues.length) {
                        numFilters++;
                        $('#userFilterHeader').addClass('activeFilter');

                        var userBadgeText = '[' + userValues.length + ']';

                        if (userValues.length == $(".userFilterCheck").not('.branchFilterCheck').length) {
                            userBadgeText = 'All';
                        }

                        if (userValues.length == 1) {
                            userBadgeText = userValues[0];
                        }

                        filterBadgeHtml += '<div class="filterBadge">' +
                            '<div class="filterBadgeTitle">Owners: </div>' +
                            '<div class="filterBadgeContent">' +
                            userBadgeText +
                            '</div>' +
                            '<div class="filterBadgeRemove"><a href="#" id="removeUserFilter">&times;</a></div>' +
                            '</div>';

                        userHeaderText = '[' + userValues.length + ']';

                    } else {
                        $('#userFilterHeader').removeClass('activeFilter');
                    }
                    $("#userHeaderText").text(userHeaderText);


                    // Account User
                    if (aUserValues.length) {
                        numFilters++;
                        $('#aUserFilterHeader').addClass('activeFilter');

                        var aUserBadgeText = '[' + aUserValues.length + ']';

                        if (aUserValues.length == $(".aUserFilterCheck").not('.aBranchFilterCheck').length) {
                            aUserBadgeText = 'All';
                        }

                        if (aUserValues.length == 1) {
                            aUserBadgeText = aUserValues[0];
                        }

                        filterBadgeHtml += '<div class="filterBadge">' +
                            '<div class="filterBadgeTitle">Users: </div>' +
                            '<div class="filterBadgeContent">' +
                            aUserBadgeText +
                            '</div>' +
                            '<div class="filterBadgeRemove"><a href="#" id="removeAUserFilter">&times;</a></div>' +
                            '</div>';

                        aUserHeaderText = '[' + aUserValues.length + ']';

                    } else {
                        $('#aUserFilterHeader').removeClass('activeFilter');
                    }
                    $("#userHeaderText").text(aUserHeaderText);

                    // Source
                    if (leadSourceValues.length) {

                        numFilters++;
                        $('#sourceFilterHeader').addClass('activeFilter');

                        var sourceBadgeText = '[' + leadSourceValues.length + ']';

                        if (leadSourceValues.length == $(".sourceFilterCheck:checked").not('.sourceFilterCheck').length) {
                            sourceBadgeText = 'All';
                        }

                        if (leadSourceValues.length == 1) {
                            sourceBadgeText = leadSourceValues[0];
                        }

                        filterBadgeHtml += '<div class="filterBadge">' +
                            '<div class="filterBadgeTitle">Source: </div>' +
                            '<div class="filterBadgeContent">' +
                            sourceBadgeText +
                            '</div>' +
                            '<div class="filterBadgeRemove"><a href="#" id="removeSourceFilter">&times;</a></div>' +
                            '</div>';

                        sourceHeaderText = '[' + leadSourceValues.length + ']';

                    } else {
                        $('#sourceFilterHeader').removeClass('activeFilter');
                    }
                    $("#sourceHeaderText").text(sourceHeaderText);

                    // Business Type
                            if (leadBusinessTypes.length) {

                                numFilters++;
                                $('#businessTypeFilterHeader').addClass('activeFilter');

                                var businessTypeBadgeText = '[' + leadBusinessTypes.length + ']';
                                businessTypeHeaderText = '[' + leadBusinessTypes.length + ']';
                                 if ($(".businessTypeFilterCheck:checked").length == $(".businessTypeFilterCheck").length) {
                                     businessTypeBadgeText = 'All';
                                     businessTypeHeaderText = '[ All ]';
                                 }

                                if (leadBusinessTypes.length == 1) {
                                   businessTypeBadgeText = leadBusinessTypeValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Business Type: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    businessTypeBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeBusinessTypeFilter">&times;</a></div>' +
                                    '</div>';

                                    

                            } else {
                                $('#businessTypeFilterHeader').removeClass('activeFilter');
                            }
                            $("#businessTypeHeaderText").text(businessTypeHeaderText);
                            //end busines type

                    // Status
                    if (statuses.length) {

                        numFilters++;
                        $('#statusFilterHeader').addClass('activeFilter');

                        var statusBadgeText = '[' + statusValues.length + ']';

                        if (statusValues.length == $(".statusFilterCheck").length) {
                            statusBadgeText = 'All';
                        }

                        if (statusValues.length == 1) {
                            statusBadgeText = statusValues[0];
                        }

                        filterBadgeHtml += '<div class="filterBadge">' +
                            '<div class="filterBadgeTitle">Status: </div>' +
                            '<div class="filterBadgeContent">' +
                            statusBadgeText +
                            '</div>' +
                            '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                            '</div>';

                        statusHeaderText = '[' + statusValues.length + ']';

                    } else {
                        $('#statusFilterHeader').removeClass('activeFilter');
                    }
                    $("#statusHeaderText").text(statusHeaderText);

                    // Due Date
                    if (dueDates.length) {
                        numFilters++;
                        $('#dueFilterHeader').addClass('activeFilter');

                        var dueDateBadgeText = '[' + dueDateValues.length + ']';

                        if (dueDateValues.length == $(".dueDateFilterCheck").length) {
                            dueDateBadgeText = 'All';
                        }

                        if (dueDateValues.length == 1) {
                            dueDateBadgeText = dueDateValues[0];
                        }

                        filterBadgeHtml += '<div class="filterBadge">' +
                            '<div class="filterBadgeTitle">Due Date: </div>' +
                            '<div class="filterBadgeContent">' +
                            dueDateBadgeText +
                            '</div>' +
                            '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                            '</div>';

                        dueDateHeaderText = '[' + dueDateValues.length + ']';

                    } else {
                        $('#dueFilterHeader').removeClass('activeFilter');
                    }
                    $("#dueHeaderText").text(dueDateHeaderText);


                    // Apply the HTML
                    $("#filterBadges").html(filterBadgeHtml);

                    if (numFilters < 1) {
                        $(".filterButton").removeClass('update-button');
                        $(".filterButton").addClass('grey');
                        $('.resetFilterButton').hide();
                        $('#newResetAccountFilterButton2').hide();
                    } else {
                        $(".filterButton").addClass('update-button');
                        $(".filterButton").removeClass('grey');
                        $('.resetFilterButton').show();
                        $('#newResetAccountFilterButton2').show();
                    }
                    var numBranches = $(".branchFilterCheck").length;
                    var numSelectedBranches = $(".branchFilterCheck:checked").length;


                    // If all branches selects, check the all box and all users
                    if (numSelectedBranches == numBranches) {
                        var selectedBranches = 'All';
                    } else {
                        var selectedBranches = [];
                        selectedBranches = $(".branchFilterCheck:checked").map(function () {
                            return $(this).data('branch-id');
                        }).get();
                    }

                    var numABranches = $(".aBranchFilterCheck").length;
                    var numASelectedBranches = $(".aBranchFilterCheck:checked").length;


                    // If all branches selects, check the all box and all users
                    if (numASelectedBranches == numABranches) {
                        var selectedABranches = 'All';
                    } else {
                        var selectedABranches = [];
                        selectedABranches = $(".aBranchFilterCheck:checked").map(function () {
                            return $(this).data('branch-id');
                        }).get();
                    }

            var owner_object_array = [];
            for($i=0;$i<aUsers.length;$i++){
                var queryStr = { "id" : aUsers[$i],"name": aUserValues[$i]};
                owner_object_array.push(queryStr);
            }
            var user_object_array = [];
            for($i=0;$i<users.length;$i++){
                var queryStr = { "id" : users[$i],"name": userValues[$i]};
                user_object_array.push(queryStr);
            }
            var business_type_object_array = [];
            for($i=0;$i<leadBusinessTypeValues.length;$i++){
                var queryStr = { "id" : leadBusinessTypes[$i],"name": leadBusinessTypeValues[$i]};
                business_type_object_array.push(queryStr);
            }

            
            accountFilter = { 
                    "accFilterUserObject": user_object_array,
                    "accFilterOwnerAccount": owner_object_array,
                    "accFilterUserBranchObject": Array.isArray(selectedABranches) ? selectedABranches : [],
                    "accFilterOwnerBranchAccount": Array.isArray(selectedBranches) ? selectedBranches : [],
                    "accFilterBusinessTypeObject": business_type_object_array,
                    };

                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('ajax/setAccountsFilter') ?>',
                        data: {


                            accFilterUser: users,
                            accFilterAUser: aUsers,
                            accFilterFrom: aCreatedFrom,
                            accFilterTo: aCreatedTo,
                            accFilterBranch: selectedBranches,
                            accFilterABranch: selectedABranches,
                            accFilterBusinessType: leadBusinessTypes,
                        },
                        dataType: 'JSON',
                        success: function () {
                            updateTable();
                        }
                    });
                }, 500);
            }

            function updateTable() {

                if ($.fn.DataTable.isDataTable('#accountTable')) {
                    accTable.ajax.reload();
                } else {
                    initTable();
                }

            }

            function datePreset(preset) {

                var startDate;
                var endDate;

                switch (preset) {

                    case 'today':
                        startDate = moment();
                        endDate = moment();
                        break;

                    case 'yesterday':
                        startDate = moment().subtract(1, 'days');
                        endDate = moment().subtract(1, 'days');
                        break;

                    case 'last7days':
                        startDate = moment().subtract(6, 'days');
                        endDate = moment();
                        break;

                    case 'monthToDate':
                        startDate = moment().startOf('month');
                        endDate = moment();
                        break;

                    case 'previousMonth':
                        startDate = moment().subtract(1, 'month').startOf('month');
                        endDate = moment().subtract(1, 'month').endOf('month');
                        break;

                    case 'yearToDate':
                        startDate = moment().startOf('year');
                        endDate = moment();
                        break;

                    case 'previousYear':
                        startDate = moment().subtract(1, 'year').startOf('year');
                        endDate = moment().subtract(1, 'year').endOf('year');
                        break;
                }

                var presetDate = {
                    startDate: startDate.format('MM/DD/YYYY'),
                    endDate: endDate.format('MM/DD/YYYY')
                };

                return presetDate;

            }

            function updateGroupButtons() {
                var counter = $(".groupSelect:checked").length;
                if (counter > 0) {
                    $("#groupActions").show();
                } else {
                    $("#groupActions").hide();
                }

                if (counter > 7) {
                    $('.planRoute').hide();
                } else {
                    $('.planRoute').show();
                }


                $("#numSelected, #deleteNum, #changeOwnerNum, #resendNum").html(counter);
            }

            $("#groupActions").hide();
            $(".groupSelect:checked").removeAttr('checked');

            // Delete Dialog
            $("#confirm-delete-message").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Ok: function () {
                        var url = $("#client-delete").attr('rel') + '/' + ($("#client-delete").data('reassign'));
                        document.location.href = url;
                        $(this).dialog("close");
                    },
                    Cancel: function () {
                        $(this).dialog("close");
                    }
                },
                autoOpen: false
            });

            // Permission Denied
            $("#permission-denied").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                },
                autoOpen: false
            });

            // Merge Dialog
            $("#confirm-merge-message").dialog({
                width: 400,
                modal: true,
                open: function( event, ui ) {
                   
                   $(".saveButtonClass2").button("disable");
                   
               },
                buttons: [
        
                        {
                            html: "<i class='fa fw fa-check-circle-o'></i> Merge Account",
                            "class": 'saveButtonClass2 blue-button',
                            click: function() {
                                var url = $("#client-merge").attr('rel') + '/' + ($("#client-merge").data('reassign')) ;
                                        document.location.href = url;
                                        $(this).dialog("close");
                            }
                        },{
                            text: "Cancel",
                            "class": 'cancelButtonClass',
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                ],
               autoOpen: false
            });

            $(".confirm-delete").live('click', function () {
                $('#newAccountsPopup').hide();
                if (deletePermission) {
                    var mergeAccountId = $(this).data('account-id');
                    $("#client-delete").attr('rel', $(this).attr('href'));
                    $("#confirm-delete-message").dialog('open');
                } else {
                    $("#permission-denied").dialog('open');
                }

                return false;
            });

            $(".confirm-merge").live('click', function () {
                $('#newAccountsPopup').hide();
                var mergeAccountId = $(this).data('account-id');
                $("#client-merge").data('reassign', '');
                $("#client-merge").attr('rel', $(this).attr('href'));
                $("#accountClientsLink").attr('href', '/accounts/clients/' + mergeAccountId);

                $("#client-merge-id").val(mergeAccountId);
                // Unhide all options
                $("select#accountReassignTo option").show();
                // Hide account id that we are merging so it doesn't merge with its;ef
                $("select#accountReassignTo option[value='" + mergeAccountId + "']").hide();
                $.uniform.update();

                $("#confirm-merge-message").dialog('open');
                return false;
            });

            // Merge Dialog
            $("#group-merge-message").dialog({
                width: 400,
                modal: true,
                open: function( event, ui ) {
                   
                    $(".saveButtonClass1").button("disable");
                    
                },
                buttons: [
        
                    {
                        html: "<i class='fa fw fa-check-circle-o'></i> Merge Accounts",
                        "class": 'saveButtonClass1 blue-button',
                        click: function() {
                           if ($("#groupReassignTo").val() > 0) {

                                $(this).dialog("close");
                                $("#groupMergeText").html('Merging <img src="/static/loading.gif" />');
                                $("#group-merge-status").dialog('open');

                                // Send the request
                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {
                                        'ids': getSelectedIds(),
                                        'reassignTo': $("#groupReassignTo").val(),
                                        
                                    },
                                    url: "<?php echo site_url('ajax/accountGroupMerge') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                    .success(function (data) {
                                        // Set the feedback text
                                        if (!data.error) {
                                            var mergeStatusText = data.numMerged + " accounts were merged";
                                        } else {
                                            var mergeStatusText = "An error occurred. Please try again";
                                        }
                                        $("#groupMergeText").html(mergeStatusText);
                                        accTable.ajax.reload();

                                    });
                            }
                        }
                    },{
                        text: "Cancel",
                        "class": 'cancelButtonClass',
                        click: function() {
                            $(this).dialog("close");
                        }
                    }
            ],
                
                autoOpen: false
            });

                    // Change Business Type
                    $(".changeBusinessType").click(function () {
                        $('.businessTypeMultiple').val('');
                        $('.businessTypeMultiple').trigger("change");
                        $('#apply_bt_on_contact').prop('checked',false);
                        $('.bt_on_proposal_p').hide();
                        $('#apply_bt_on_proposal').val('');
                        $.uniform.update();
                        $("#change-business-type").dialog('open');
                        $("#changeBusinessTypeNum").html($(".groupSelect:checked").length);
                        return false;
                    });

                    // Prospect Business Type Update
                    $("#change-business-type").dialog({
                        width: 520,
                        modal: true,
                        buttons: {
                            Save: {
                                'class': 'btn ui-button update-button group_change_bt_popup_btn',
                                text: 'Save',
                                click: function () {

                                    if($('#apply_bt_on_contact').is(':checked')){
                                        var selected_account_ids = getSelectedIds();
                                        $.post("<?php echo site_url('ajax/getAccountsProposalCount') ?>", {ids: selected_account_ids}, function(proposal_count){

                                            var bt_value = $('.businessTypeMultiple option:selected').map(function(i,v) {
                                                            return this.value;
                                                        }).get();
                                            if(bt_value && bt_value.length > 1){
                                                
                                                var btName = $( "#apply_bt_on_proposal option:selected" ).text();
                                            }else{
                                                var btName = $( ".businessTypeMultiple option:selected" ).text();
                                            }
                                        var selected_account =$('#changeBusinessTypeNum').text();
                                        var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>"+
                                        "<table style='text-align: left;line-height: 25px;width:100%'><tr><th style='text-align: right;width: 30%;'>Account:</th><td style='padding-left:10px'>"+selected_account+" selected</td></tr>"+
                                        "<tr><th style='text-align: right;'>New Business Type:</th><td style='padding-left:10px'>"+btName+"</td></tr>"+
                                        "<tr><th style='text-align: right;'>Proposals Affected:</th><td style='padding-left:10px'>"+proposal_count+"</td></tr></table>"
                                    swal({
                                            title: "WARNING!",
                                            text: table,
                                            width:700,
                                            showCancelButton: true,
                                            confirmButtonText: 'Save',
                                            cancelButtonText: "Cancel",
                                            dangerMode: false,
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                $("#changeBusinessTypeStatus").html('Updating Business Type, please wait...  <img src="/static/loading.gif" />');
                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    cache: false,
                                                    data: {
                                                        'ids': selected_account_ids, 
                                                        businessTypes: $('.businessTypeMultiple').val(),
                                                        apply_bt_on_contact: ($('#apply_bt_on_contact').is(':checked'))?'1':'0',
                                                        apply_bt_on_proposal: $('#apply_bt_on_proposal').val()},
                                                    url: "<?php echo site_url('ajax/groupAccountsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                                    dataType: "JSON"
                                                }).success(function (data) {
                                                    $("#changeBusinessTypeStatus").html('Done!');
                                                    //document.location.reload();
                                                    accTable.ajax.reload();
                                                    $("#change-business-type").dialog('close');
                                                    swal('','Business Type Updated');
                                                    $("#changeBusinessTypeStatus").html('');
                                                    $("#groupActions").hide();
                                                });

                                            } else {
                                                    return false;
                                            }
                                        });
                                    });
                                    }else{
                                        console.log('check1');
                                        $("#changeBusinessTypeStatus").html('Updating Business Type, please wait...  <img src="/static/loading.gif" />');
                                        $.ajax({
                                            type: "POST",
                                            async: true,
                                            cache: false,
                                            data: {
                                                'ids': getSelectedIds(), 
                                                businessTypes: $('.businessTypeMultiple').val(),
                                                apply_bt_on_contact: ($('#apply_bt_on_contact').is(':checked'))?'1':'0',
                                                apply_bt_on_proposal: $('#apply_bt_on_proposal').val()},
                                            url: "<?php echo site_url('ajax/groupAccountsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                            dataType: "JSON"
                                        }).success(function (data) {
                                            $("#changeBusinessTypeStatus").html('Done!');
                                            //document.location.reload();
                                            accTable.ajax.reload();
                                            $("#change-business-type").dialog('close');
                                            swal('','Business Type Updated');
                                            $("#changeBusinessTypeStatus").html('');
                                            $("#groupActions").hide();
                                        });


                                    }
                                    
                                    
                                }
                            },
                            Cancel: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

                    $(document).on('change', ".businessTypeMultiple", function () {
                        var bt_value =  $('.businessTypeMultiple').val();
                        var btn_disable = true;
                        if(bt_value && bt_value.length > 1){
                                if(jQuery.inArray($("#apply_bt_on_proposal").val(), bt_value) == -1){
                                    $("#apply_bt_on_proposal").val('').trigger('change');
                                }
                                
                                $("#apply_bt_on_proposal").children('option').hide();
                                for($i=0;$i<bt_value.length;$i++){
                                    $("#apply_bt_on_proposal").children("option[value=" + bt_value[$i] + "]").show()
                                }
                                $("#apply_bt_on_proposal").children("option[value='']").show();

                            if($('#apply_bt_on_contact').is(':checked')){
                               
                                $('.bt_on_proposal_p').show();
                                if($('#apply_bt_on_proposal').val()){
                                    btn_disable = true;
                                    
                                }else{
                                    btn_disable = false;
                                    
                                }
                            }else{
                                btn_disable = true;
                            }
                        }else if(bt_value && bt_value.length == 1){
                            btn_disable = true;
                            $('.bt_on_proposal_p').hide();
                        }else{
                            btn_disable = false;
                            
                        }


                        if(btn_disable){
                            $('.group_change_bt_popup_btn').prop('disabled', false);
                            $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
                        }else{
                            $('.group_change_bt_popup_btn').prop('disabled', true);
                            $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
                        }
                
            });

            $(document).on('change', "#apply_bt_on_proposal", function () {
                    if($('#apply_bt_on_proposal').val()){
                        $('.group_change_bt_popup_btn').prop('disabled', false);
                        $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
                    }else{
                        $('.group_change_bt_popup_btn').prop('disabled', true);
                        $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
                    }
            });

            $(document).on('change', "#apply_bt_on_contact", function () {
                if($('#apply_bt_on_contact').is(':checked')){
                    var bt_value =  $('.businessTypeMultiple').val();
                    if(bt_value && bt_value.length > 1){
                        $('.group_change_bt_popup_btn').prop('disabled', true);
                        $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
                        $('.bt_on_proposal_p').show();
                    }
                }else{
                    $('.bt_on_proposal_p').hide();
                    $('.group_change_bt_popup_btn').prop('disabled', false);
                    $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
                }
            })

            // Merge Dialog
            $("#group-merge-status").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                        accTable.ajax.reload();
                    }
                },
                autoOpen: false
            });

            $("#group-delete-status").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                        accTable.ajax.reload();
                    }
                },
                autoOpen: false
            });

            // Delete Dialog
            $("#group-delete-confirm").dialog({
                width: 400,
                modal: true,
                buttons: {
                    Ok: function () {

                        $(this).dialog("close");
                        $("#groupMergeText").html('Deleting <img src="/static/loading.gif" />');
                        $("#group-delete-status").dialog('open');

                        // Send the request
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                'ids': getSelectedIds()
                            },
                            url: "<?php echo site_url('ajax/accountGroupDelete') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                // Set the feedback text
                                if (!data.error) {
                                    var deleteStatusText = data.numDeleted + " accounts were deleted";
                                } else {
                                    var deleteStatusText = "An error occurred. Please try again";
                                }
                                $("#groupDeleteText").html(deleteStatusText);
                                accTable.ajax.reload();

                            });

                            $("#residential_delete").text();
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                },
                autoOpen: false
            });

            // $("#accountReassignTo").change(function () {
            //     $("#client-merge").data('reassign', $(this).val());
            // });

            // Update the counter after each change
            $(".groupSelect").live('change', function () {
                updateNumSelected();
            });

            $("#accountMasterCheck").change(function () {
                        var checked = $(this).is(":checked");
                        $(".groupSelect").prop('checked', checked);
                        $.uniform.update();
                        updateNumSelected();
            });

            // All
            $("#selectAll").live('click', function () {
                $(".groupSelect").attr('checked', 'checked');
                updateNumSelected();
                $.uniform.update();
                return false;
            });

            // None
            $("#selectNone").live('click', function () {
                $(".groupSelect").attr('checked', false);
                updateNumSelected();
                $.uniform.update();
                return false;
            });

            $("#groupMerge").click(function () {


                $("#groupReassignTo").val(null).trigger("change");
                
                $("#group-merge-message").dialog('open');
                

            });

            $("#groupDelete").click(function () {
                $("#group-delete-confirm").dialog('open');
            });


            //dropdown
            $("#preset").on("change", function () {
                setDates();
                if($(this).val() != 'custom'){
                    applyFilter();
                }
                
            });

            $("#reset").on('click', function() {
                $("#preset").val('ytd');
                setDates();
                applyFilter();
            });

           
        // Lead Business Type Update
        $("#change-account-business-type").dialog({
            width: 520,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
                    text: 'Save',
                    click: function () {
                        if($('#apply_account_bt_on_contact').is(':checked')){
                            $.get("<?php echo site_url('ajax/getAccountProposalCount') ?>/"+$('#business_account_id').val(), function(proposal_count){
                                    var bt_value = $('.accountBusinessTypeMultiple option:selected').map(function(i,v) {
                                                    return this.value;
                                                }).get();
                                    if(bt_value && bt_value.length > 1){
                                        
                                        var btName = $( "#apply_account_bt_on_proposal option:selected" ).text();
                                    }else{
                                        var btName = $( ".accountBusinessTypeMultiple option:selected" ).text();
                                    }
                                    var selected_account =$('.change-bt-account-name').text();
                                    var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>"+
                                    "<table style='text-align: left;line-height: 25px;width:100%'><tr><th style='text-align: right;width: 30%;'>Account:</th><td style='padding-left:10px'>"+selected_account+"</td></tr>"+
                                    "<tr><th style='text-align: right;'>New Business Type:</th><td style='padding-left:10px'>"+btName+"</td></tr>"+
                                    "<tr><th style='text-align: right;'>Proposals Affected:</th><td style='padding-left:10px'>"+proposal_count+"</td></tr></table>";
                                    swal({
                                            title: "WARNING!",
                                            text: table,
                                            width:700,
                                            showCancelButton: true,
                                            confirmButtonText: 'Save',
                                            cancelButtonText: "Cancel",
                                            dangerMode: false,
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                swal({
                                                    title: 'Saving..',
                                                    allowEscapeKey: false,
                                                    allowOutsideClick: false,
                                                    timer: 20000,
                                                    onOpen: () => {
                                                    swal.showLoading();
                                                    }
                                                })
                                        var businessTypes = $('.accountBusinessTypeMultiple option:selected').map(function(i,v) {
                                                    return this.value;
                                                }).get();

                                                $.ajax({
                                                    type: "POST",
                                                    async: true,
                                                    cache: false,
                                                    data: {
                                                        account_id:$('#business_account_id').val(),
                                                        businessTypes: businessTypes,
                                                        apply_bt_on_contact: ($('#apply_account_bt_on_contact').is(':checked'))?'1':'0',
                                                        apply_bt_on_proposal: $('#apply_account_bt_on_proposal').val()},
                                                    url: "<?php echo site_url('ajax/accountsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                                    dataType: "JSON"
                                                }).success(function (data) {
                                                    
                                                    accTable.ajax.reload(null,false);
                                                    $("#change-account-business-type").dialog('close');
                                                    swal('','Business Type Updated');
                                                    
                                                });

                                            } else {
                                                    return false;
                                            }
                                        });
                                    });
                                    }else{
                                        swal({
                                            title: 'Saving..',
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            timer: 20000,
                                            onOpen: () => {
                                            swal.showLoading();
                                            }
                                        })
                                        var businessTypes = $('.accountBusinessTypeMultiple option:selected').map(function(i,v) {
                                                    return this.value;
                                                }).get();

                                        $.ajax({
                                            type: "POST",
                                            async: true,
                                            cache: false,
                                            data: {
                                                account_id:$('#business_account_id').val(),
                                                businessTypes: businessTypes,
                                                apply_bt_on_contact: ($('#apply_account_bt_on_contact').is(':checked'))?'1':'0',
                                                apply_bt_on_proposal: $('#apply_account_bt_on_proposal').val()},
                                            url: "<?php echo site_url('ajax/accountsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                            dataType: "JSON"
                                        }).success(function (data) {
                                            
                                            accTable.ajax.reload(null,false);
                                            $("#change-account-business-type").dialog('close');
                                            swal('','Business Type Updated');
                                            
                                        });
                                    }
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });

        $(document).on('click', ".manage_business_type", function () {
                var company_name = '<i class="fa fa-fw fa-building-o"></i> '+$(this).closest('tr').find('.accountsTableDropdownToggle').attr('data-account-name');
                $('.change-bt-account-name').html(company_name);
                account_id = $(this).attr('rel');
                $('.accountBusinessTypeMultiple').val('');
                $(".accountBusinessTypeMultiple option").attr("disabled", false);
                $('.accountBusinessTypeMultiple').trigger("change");
                $('.account_bt_on_proposal_p').hide();
                disable_business_types = [];
                $('#apply_account_bt_on_contact').prop('checked',false);
                $.uniform.update($('#apply_account_bt_on_contact'));
               
                $('#apply_account_bt_on_proposal').val('');
                $.uniform.update($('#apply_account_bt_on_proposal'));
                $('#business_account_id').val(account_id);
                $.ajax({
                                    url: '<?php echo site_url('ajax/getaccountBusinessTyeps') ?>',
                                    type:'post',
                                    data:{account_id:account_id},
                                    cache: false,
                                    dataType: 'JSON',
                                    success: function (response) {
                                       
                                        if(response.success){
                                           var selected_bt =[];
                                            var bts = response.business_types;
                                            for($i=0;$i<bts.length;$i++){
                                               selected_bt.push(bts[$i]['business_type_id']);
                                            }
                                            $('.accountBusinessTypeMultiple').val(selected_bt);
                                            
                                            disable_business_types = response.disable_business_types;
                                            for($i=0;$i<disable_business_types.length;$i++){
                                                if($(".accountBusinessTypeMultiple option[value=" + disable_business_types[$i] + "]").is(':selected')){
                                                    $(".accountBusinessTypeMultiple option[value=" + disable_business_types[$i] + "]").attr("disabled","disabled");
                                                }
                                            }
                                            $('.accountBusinessTypeMultiple').trigger("change");
                                            $(".tag_tiptip").tipTip({defaultPosition:'top'});
                                        }
                                     $("#change-account-business-type").dialog('open');    
                                    }
                                });
                return false;
                
            });

            $(document).on('change', ".accountBusinessTypeMultiple", function () {
                var bt_value = $('.accountBusinessTypeMultiple option:selected').map(function(i,v) {
                                    return this.value;
                                }).get();
                        var btn_disable = true;
                        if(bt_value && bt_value.length > 1){
                                if(jQuery.inArray($("#apply_account_bt_on_proposal").val(), bt_value) == -1){
                                    $("#apply_account_bt_on_proposal").val('').trigger('change');
                                }
                                
                                $("#apply_account_bt_on_proposal").children('option').hide();
                                for($i=0;$i<bt_value.length;$i++){
                                    $("#apply_account_bt_on_proposal").children("option[value=" + bt_value[$i] + "]").show()
                                }
                                $("#apply_account_bt_on_proposal").children("option[value='']").show();

                            if($('#apply_account_bt_on_contact').is(':checked')){
                               
                                $('.account_bt_on_proposal_p').show();
                                if($('#apply_account_bt_on_proposal').val()){
                                    btn_disable = true;
                                    
                                }else{
                                    btn_disable = false;
                                    
                                }
                            }else{
                                btn_disable = true;
                            }
                        }else if(bt_value && bt_value.length == 1){
                            btn_disable = true;
                            $('.account_bt_on_proposal_p').hide();
                        }else{
                            btn_disable = false;
                            
                        }

                        if(btn_disable){
                            $('.change_bt_popup_btn').prop('disabled', false);
                            $('.change_bt_popup_btn').removeClass('ui-state-disabled');
                        }else{
                            $('.change_bt_popup_btn').prop('disabled', true);
                            $('.change_bt_popup_btn').addClass('ui-state-disabled');
                        }
                
                
            }); 

            $(document).on('change', "#apply_account_bt_on_contact", function () {
                if($('#apply_account_bt_on_contact').is(':checked')){
                    $(".accountBusinessTypeMultiple option").attr("disabled", false);
                    $(".accountBusinessTypeMultiple").trigger('change')
                    var bt_value = $('.accountBusinessTypeMultiple option:selected').map(function(i,v) {
                                    return this.value;
                                }).get();
                    if(bt_value && bt_value.length > 1){
                        $('.change_bt_popup_btn').prop('disabled', true);
                        $('.change_bt_popup_btn').addClass('ui-state-disabled');
                        $('.account_bt_on_proposal_p').show();
                    }
                }else{
                    for($i=0;$i<disable_business_types.length;$i++){
                        $(".accountBusinessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("selected", true);
                        $(".accountBusinessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("disabled", true);
                    }
                    $(".accountBusinessTypeMultiple").trigger('change')
                    $('.account_bt_on_proposal_p').hide();
                    $('.change_bt_popup_btn').prop('disabled', false);
                    $('.change_bt_popup_btn').removeClass('ui-state-disabled');
                }
                $(".tag_tiptip").tipTip({defaultPosition:'top'});
            });

            $(document).on('change', "#apply_account_bt_on_proposal", function () {
                     if($('#apply_account_bt_on_proposal').val()){
                       
                         $('.change_bt_popup_btn').prop('disabled', false);
                         $('.change_bt_popup_btn').removeClass('ui-state-disabled');
                     }else{
                       
                         $('.change_bt_popup_btn').prop('disabled', true);
                         $('.change_bt_popup_btn').addClass('ui-state-disabled');
                     }
            });

$(document).on('click', '#accountTable tbody td a, #accountTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-account-id');
    if(hasLocalStorage){
        localStorage.setItem("a_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("a_last_active_row", '');
    }
});

function check_highlighted_row(){
    if(localStorage.getItem("a_last_active_row")){
        var row_num =localStorage.getItem("a_last_active_row");
        $('#accountTable tbody').find("[data-account-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}


$(document).on('click', "#saveFilter", function () {
    
   
    if($('.activeFilter').length >0){
    swal({
        title: 'Save Filter',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: "Cancel",
        dangerMode: false,
        reverseButtons:false,
        html:
            '<input id="swal-input1" class="swal2-input" value="" Placeholder="Enter Filter Name"><br><span id="nameExist"></span>',
        preConfirm: function () {
            if($('#swal-input1').val()){

            
                return new Promise(function (resolve) {

                resolve(
                    $('#swal-input1').val()
                    
                )
                })
            }else{
                alert('Please Enter the filter Name');
            }
            
        },
        preConfirm: function () {
                if($('#swal-input1').val()){
                    
                    return new Promise(function (resolve) {
                    var name= $('#swal-input1').val();
                   
                    $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:name,type:'Account'},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Alredy Exist!"); 
                               $('#swal-input1').addClass("error");
                               
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
            
            $.ajax({
                        url: '/ajax/save_account_filter',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "account_filter": accountFilter,
                            "filterName":result
                        },

                        success: function (data) {
                            if (!data.error) {
                                console.log(result);
                                var $cont = $('#saves_filter_list');
                                //var op = "<option value='" + 3 + "'>check apepnd</option>";
                                var op =  "<option  data-default-filter='0' data-filter='"+data.filter_data+"' value='"+data.filter_id+"'>"+result+"</option>";
                                //if($cont.find('optgroup[id="saved_filters_lable"]').length>0){
                                    $cont.append(op);
                                // }else{
                                //     $('#saves_filter_list').append('<optgroup id="saved_filters_lable" label="Saved Filters">'+op+'</optgroup>')
                                // }
                                swal('Filter saved')
                                //update_saved_filter()
                            } else {
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
    }else{
        swal('','There are no Filters Applied!')
    }
   });


           $("#saves_filter_list").change(function() {

     
            // Reset All Checkboxes
            $(".filterCheck, .filterColumnCheck").prop('checked', true);
            $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

            $('.searchSelectedRow').remove();
            $('#accountSearch').val('');
            $('#accountSearch').trigger('input');
        
        var datePreset = $("#saves_filter_list").find(':selected').data('preset-range');
        var statusPreset = $("#saves_filter_list").find(':selected').data('preset-status');
        var is_default = $("#saves_filter_list").find(':selected').data('default-filter');

        var statuses ='';

        setTimeout(function() {
            if(is_default){
            // Date
                if (datePreset) {
                    $("#createdPreset").val(datePreset);
                    
                }

                // Status
                if (statusPreset) {
                    $('.statusFilterCheck').prop('checked', false);
                    $('.statusFilterCheck[value="' + statusPreset +'"]').prop('checked', true);
                }


                if (datePreset) {
                    $("#createdPreset").change();
                }
                else {
                    applyFilter();
                }
            }else{
                var filter = $("#saves_filter_list").find(':selected').data('filter');
                //var obj = jQuery.parseJSON(filter);
                var change_preset = false;
                $.each(filter, function(key,value) {
                     if(key=='accFilterBusinessTypeObject'){
                        $('.businessTypeFilterCheck').prop('checked', false);
                        $('#allBusinessTypes').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.businessTypeFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                       
                    }

                    else if(key=='accFilterUserBranchObject'){
                        if(value.length >2 ){
                            $('#allAUsersCheck').prop('checked', true);
                        }else{
                            $('#allAUsersCheck').prop('checked', false);
                            $('.aBranchFilterCheck').prop('checked', false);
                            for($i=0;$i<value.length;$i++){
                                $('.aBranchFilterCheck[data-branch-id="' + value[$i] +'"]').prop('checked', true);
                            }
                        }
                        
                    }
                    else if(key=='accFilterOwnerBranchAccount'){
                        if(value.length >2 ){
                            $('#allUsersCheck').prop('checked', true);
                        }else{
                            $('#allUsersCheck').prop('checked', false);
                            $('.branchFilterCheck').prop('checked', false);
                            for($i=0;$i<value.length;$i++){
                                $('.branchFilterCheck[data-branch-id="' + value[$i] +'"]').prop('checked', true);
                            }
                        }
                        
                    }
                    else if(key=='accFilterUserObject'){
                        $('.userFilterCheck').prop('checked', false);
                        $('#allUsersCheck').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.userFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                    }
                     else if(key=='accFilterOwnerAccount'){
                        $('.aUserFilterCheck').prop('checked', false);
                        $('#allAUsersCheck').prop('checked', false);
                        for($i=0;$i<value.length;$i++){
                            $('.aUserFilterCheck[value="' + value[$i].id +'"]').prop('checked', true);
                        }
                         
                     }
                    

                    
                   

                }); 

                if(change_preset) {
                   
                    $("#createdPreset").change();
                    applyFilter();
                }
                else {
                   
                    applyFilter();
                }
                $.uniform.update();
            }


        }, 500);
    });

    $(document).on("keyup","#swal-input1",function(e) {
    //$('#swal-input1').val()
    if($(this).val()){
        $.ajax({
                        url: '<?php echo site_url('ajax/checkFilterName') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {name:$('#swal-input1').val(),type:'Account'},
                        success: function (response) {
                            if(response.success == true)
                            {
                               $('#nameExist').html("Filter Name Alredy Exist!"); 
                               $('#swal-input1').addClass("error");
                               
                            }
                            else{
                                $('#swal-input1').removeClass("error");
                                $('#nameExist').html(""); 
                            }
                        }
                    })
        
    }else{
        $(this).addClass('error');
        
    }


});        


});//end ready

        // Filter Internal reset filter
        $("#newResetAccountFilterButton2").click(function () {
            $(".resetFilterButton").trigger('click')
        });

        /* Create an array of the selected IDs */
        function getSelectedIds() {

            var IDs = new Array();

            $(".groupSelect:checked").each(function () {
                IDs.push($(this).data('account-id'));
             });

            return IDs;
        }

        /* Update the number of selected items */
        function updateNumSelected() {
            var num = $(".groupSelect:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {
                //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
                $(".groupAction").hide();
            } else {
                //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
                $(".groupAction").show();
            }
            $("#numSelected").html(num);
        }



function setDates() {
    var change = true;
    var from = moment().startOf('year').format('MM/DD/YYYY');
    var to = moment().format('MM/DD/YYYY');
    $('.account-datepickers p').show();
    switch ($("#preset").val()) {
        case "custom": //custom preset
            change = false;
            break;
        case 'yesterday':
            from = moment().subtract(1, 'days').format('MM/DD/YYYY');
            to = moment().subtract(1, 'days').format('MM/DD/YYYY');
            break;
        case "last7d": //last 7 days
            from = moment().subtract(7, 'd').format('MM/DD/YYYY');
            break;
        case "monthtd": //month to date
            date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var dateFrom = new Date(y, m, 1);
            from = moment(dateFrom).format('MM/DD/YYYY');
            break;
        case "prevmonth": //previous month
            from = moment(dateFrom).subtract(1, 'months').startOf('month').format('MM/DD/YYYY');
            to = moment(dateFrom).subtract(1, 'months').endOf('month').format('MM/DD/YYYY');
            break;
        case "prevyear": //previous year
            from = moment(dateFrom).subtract(1, 'years').startOf('year').format('MM/DD/YYYY');
            to = moment(dateFrom).subtract(1, 'years').endOf('year').format('MM/DD/YYYY');
            break;
        case "all": //All Time
            from = '';
            to ='';
            $('.account-datepickers p').hide();
            break;
    }



    if (change) {
        $("#aCreatedFrom").val(from);
        $("#aCreatedTo").val(to);
       
        $(".is_custom_selected").hide();
        $(".is_custom_not_selected").show();
        // var newTo = to.split("/");
        // newTo = newTo[0] + '/' + newTo[1] + '/' + newTo[2].slice(-2);
        // var newFrom = from.split("/");
        // newFrom = newFrom[0] + '/' + newFrom[1] + '/' + newFrom[2].slice(-2);
        $(".show_from_date").text(from);
        $(".show_to_date").text(to);

       
    }else{
        $(".is_custom_selected").show();
        $(".is_custom_not_selected").hide();
        var temp_date = moment().format('MM/DD/YYYY');
        $("#aCreatedFrom").val(temp_date);
        $("#aCreatedTo").val(temp_date);
        $(".show_from_date").text(temp_date);
        $(".show_to_date").text(temp_date);
    }
}



//Select2 start

$("#accountReassignTo").select2({
  ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchClientsCompany') ?>',
    dataType: 'json',
    delay: 250,
    
    data: function (params) {
      return {
        startsWith: params.term, // search term
        client_id: $("#client-merge-id").val(),
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  allowClear: true,
  debug: true,
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

function formatRepo (repo) {
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      
      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Owner:</th><td class='select2-result-repository_contact'></td></tr>"+
       
       
      "</div>" +
    "</div>"
  );
  
  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);

  return $container;
}

function formatRepoSelection (repo) {
  return repo.label ;
}

$('#accountReassignTo').on("select2:selecting", function(e) { 
   // what you would like to happen
   var select_id = e.params.args.data.id;
   $("#client-merge").data('reassign', select_id);
   $(".saveButtonClass2").button("enable");
});

$('#accountReassignTo').on('select2:clear', function (e) {
    $(".saveButtonClass2").button("disable");
});

//Select2 start

$("#groupReassignTo").select2({
  ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchGroupClientsCompany') ?>',
    dataType: 'json',
    delay: 250,
    
    data: function (params) {
      return {
        startsWith: params.term, // search term
        client_ids: getSelectedIds(),
        page: params.page
      };
    },
    processResults: function (data, params) {
      // parse the results into the format expected by Select2
      // since we are using custom formatting functions we do not need to
      // alter the remote JSON data, except to indicate that infinite
      // scrolling can be used
      params.page = params.page || 1;

      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  allowClear: true,
  debug: true,
  minimumInputLength: 1,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});



$('#groupReassignTo').on("select2:selecting", function(e) { 
   // what you would like to happen
   var select_id = e.params.args.data.id;
   $("#client-group-merge").data('reassign', select_id);
   $(".saveButtonClass1").button("enable");
});

$('#groupReassignTo').on('select2:clear', function (e) {
    $(".saveButtonClass1").button("disable");
});

//Select2 end

$(document).on('click', ".accountsTableDropdownToggle", function (e) {
                    $('#newAccountsPopup').html('');
                    $('#newAccountsPopup').show();
                    
                    $('.is_converted').css('display', 'none');
                    $('.is_audit').css('display', 'none');
                    var template;

                    var account_id = $(this).attr('data-account-id');
                    var num_clients = $(this).attr('data-num-clients');
                    var owner_name = $(this).attr('data-owner-name');
                    var account_name = $(this).attr('data-account-name');
                    
                    if(account_name =='Residential'){
                        $("#template").find('.confirm-delete').css('display','none');
                    }else{
                        $("#template").find('.confirm-delete').css('display','block');
                    }
                    template = $("#template").html();
                    
                    template = template.toString()

                    template = template.replace(new RegExp('{accountId}', 'g'), account_id);
                    template = template.replace(new RegExp('{numContacts}', 'g'), num_clients);
                    template = template.replace(new RegExp('{companyName}', 'g'), account_name);
                    template = template.replace(new RegExp('{ownerFullname}', 'g'), owner_name);
                   
                    $('#newAccountsPopup').html(template);
});

$(document).on("click", ".closeDropdownMenu1", function (e) {
    $('#newAccountsPopup').hide();

    return false;
});

$('body').click(function (event) {
    var $trigger3 = $("#accountsTableDropdownToggle");

    if ('accountsTableDropdownToggle' !== event.target.id && !$trigger3.has(event.target).length) {
        if ($(event.target).parents('#newAccountsPopup').length == 0) {
            if (event.target.id != 'newAccountsPopup') {
                $("#newAccountsPopup").hide();
            }
        }
    }

    var $trigger4 = $("#groupActionsButton");
      
      if('groupActionsButton' !== event.target.id && !$trigger4.has(event.target).length){
        $(".groupActionsContainer").hide();

     } 

});
    

</script>
<script>
        $(document).ready(function() {
            const selectedValues = []; // Initialize an array to store selected values
            $(document).on('click', '.groupSelect', function() {
                const isChecked = $(this).is(':checked');
                const accountId = $(this).data('account-id');
                
                if (isChecked) {
                    const accountName = $(this).closest('tr').find('[data-account-name]').data('account-name');
                    selectedValues.push(accountName);

                } else {
                    const accountName = $(this).closest('tr').find('[data-account-name]').data('account-name');
                    const index = selectedValues.indexOf(accountName);
                    if (index !== -1) {
                        selectedValues.splice(index, 1);
                    }
                }
            });

            // Button click event to display selected values
            $('#groupDelete').click(function() {
                $("#residential_delete").text(""); // Remove text from the <p> tag

                var valueToCheck = "Residential";
                var exists = $.inArray(valueToCheck, selectedValues);
                console.log("exists",exists);
                console.log("selectedValues",selectedValues);

                if (exists >= 0) {

                            $("#residential_delete").text("Residential will not be deleted");

                        } else {
                            $("#residential_delete").text("");
                        }
            });

            $(".ui-icon-closethick, .ui-button-text-only, .ui-dialog-titlebar-close").on("click", function() {
                  $("#residential_delete").text(""); // Remove text from the <p> tag
 
           });

        });
    </script>

 

<?php 
$this->load->view('templates/clients/table/add-contact-popup');
$this->load->view('global/footer'); ?>