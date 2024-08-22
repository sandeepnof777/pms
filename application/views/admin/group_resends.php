<?php $this->load->view('global/header'); ?>
<style type="text/css">

.row_red .color_highlight{
    background-color: #e6a5a5!important;
}

.row_red .color_highlight a{
    background: #ff0000;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}

.row_yellow .color_highlight{
    background-color: #f7e8a1!important;
}

.row_yellow .color_highlight a{
    background: #dca032;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}

.row_green .color_highlight{
    background-color: #a8cea8!important;
}

.row_green .color_highlight a{
    background: #027300;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}

.click_row_red .click_color_highlight{
    background-color: #e6a5a5!important;
}

.click_row_red .click_color_highlight a{
    background: #ff0000;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}

.click_row_yellow .click_color_highlight{
    background-color: #f7e8a1!important;
}

.click_row_yellow .click_color_highlight a{
    background: #dca032;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}

.click_row_green .click_color_highlight{
    background-color: #a8cea8!important;
}

.click_row_green .click_color_highlight a{
    background: #027300;
    padding: 3px 5px;
    border-radius: 5px;
    color: #fff;

}
    #uniform-campaignMasterCheck {
        margin: 0px;
    left: 10px;
    }

    #groupSelectAllTop {
        display: none;
    }

    .redClass {
        color: #A00705 !important;
    }

    tr.redClass td.sorting_1 {
        color: #A00705 !important;
    }

    /* .dropdownMenuContainer {
    right:0px!important;
    left: unset!important;
    } */
    #newFilterContainer {
        position: relative;
    }
    #uniform-templateSelect span {
        width: 200px!important;
    }

    #uniform-templateSelect {
        width: 225px!important;
    }

    #newProposalFilterButton, #newResetProposalFilterButton {
        display: inline-block;
        float: left;
        margin-right: 10px;
    }

    #newResetProposalFilterButton {
        display: none;
    }

    #newFilterContainer h3 {
        margin: 5px 0;
        width: 33%;
        float: left;
    }

    #filterInfo {
        position: relative;
        padding-top: 10px;
        text-align: center;
        font-size: 1.25em;
        margin-bottom: 10px;
    }

    #filterInfo #filterResults {
        display: none;
    }

    #filterNumResults {
        font-weight: bold;
    }

    #filterControls {
        width: 20px;
        float: right;
        padding-top: 5px;
        text-align: right;
    }

    #newProposalFilters {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #ebedea;
        width: 325px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        padding: 0 5px 10px 5px;
        z-index: 100;
        display: none;
        border-radius: 5px;
        margin-top: 1px;
    }

    #topFilterRow, .filterRow {
        padding-bottom: 2px;
        margin: 0;
    }

    .filterColumn {
        float: left;
        width: 311px;
        background-color: #dcdcdc;
        border-radius: 10px;
        margin: 0 1px;
    }

    .filterColumnWide {
        float: left;
        width: 312px;
        background-color: #dcdcdc;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .filterColumnWide:first-child {
        margin-left: 1px;
        margin-right: 1px;
    }

    .filterColumnWide:nth-child(2) {
        margin-right: 0;
        margin-right: 1px;
    }

    .filterColumn.filterCollapse .filterColumnRow,
    .filterColumn.filterCollapse .filterColumnScroll,
    .filterColumn.filterCollapse .filterSearchBar,
    .filterColumnWide.filterCollapse .filterColumnRowContent {
        display: none;
    }

    .filterSearch {
        width: 200px;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 5px;
    }

    a.filterSearchClear {
        cursor: pointer;
        margin-top: 6px;
        font-size: 1.5em;
        margin-right: 7px;
        width: 10px;
        float: right;
        color: #B41D16;
        display: none;
    }

    a.filterDateClear {
        cursor: pointer;
        font-size: 0.8em;
        width: 10px;
        color: #B41D16;
        margin-top: 2px;
    }

    .filterHeaderToggle:before {
        content: "\f077";
    }

    .filterColumnWide.filterCollapse .filterHeaderToggle:before,
    .filterColumn.filterCollapse .filterHeaderToggle:before {
        content: "\f078";
    }

    .filterSliderColumn {
        float: left;
        width: 298px;
        margin-left: 2px;
    }

    .filterColumnHeader {
        position: relative;
        text-align: left;
        font-weight: bold;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        cursor: pointer;
        line-height: 20px;
        padding: 6px 10px;
        background: #5f5f5f;
        color: #e6e8eb;
    }

    .filterColumn.filterCollapse .filterColumnHeader,
    .filterColumnWide.filterCollapse .filterColumnHeader {
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .filterColumnHeader.activeFilter {
        background: none;
        background-color: #25AAE1;
        color: #fff;
    }

    .filterColumnHeader .checker {
        position: absolute;
        left: 7px;
        top: 7px;
    }

    .filterColumnHeader span {
        font-weight: bold;
        color: #fff;
    }

    .filterColumnHeader i {
        margin-right: 10px;
    }

    .filterColumn.filterCollapse .filterColumnHeader .checker {
        display: none;
    }

    .filterColumnHeader .filterHeaderToggle {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #fff;
        cursor: pointer;
    }

    .filterColumnHeader .headerText {
        float: right;
        margin-right: 30px;
    }

    .filterColumnScroll {
        padding-top: 5px;
        height: 250px;
        overflow-y: auto;
    }

    .filterColumnStack {
        padding-top: 5px;
        max-height: auto;
    }

    .filterColumnRow {
        display: block;
        padding: 4px 2px;
    }

    .filterColumnWide .filterColumnRow {
        padding: 0;
    }

    .filterColumnRow .filterColumnRowContent {
        padding: 10px;
        border-right: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .filterColumnRowContent input.text {
        width: 70px;
        margin-right: 10px;
    }

    .filterColumnRow .checker {
        margin-top: -3px;
    }

    #filterBadges {
        float: left;
        padding-left: 10px;
        width: 500px;
    }

    .filterBadge {
        float: left;
        border-radius: 3px;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 5px;
        font-size: 11px;
        margin-top: 3px;
    }

    .filterBadgeTitle {
        display: inline;
        float: left;
        padding: 5px 2px;
        font-weight: bold;
    }

    .filterBadgeContent {
        display: inline;
        float: left;
        padding: 5px 2px;
    }

    .filterBadgeRemove {
        display: inline;
        float: left;
        padding: 5px 2px;
    }

    .filterBadgeRemove a {
        display: inline-block;
        height: 100%;
        width: 100%;
    }

    #priceSlider {
        margin: 2px 10px;
    }

    .ui-slider-range {
        background-color: #505050;
    }

    .comiseo-daterangepicker {
        z-index: 101 !important;
    }

    #closeProposalFilters {
        position: absolute;
        right: 0;
        font-size: 11px;
        top: 5px;
    }

    #openFilterPresets {
        position: absolute;
        left: 0;
        font-size: 11px;
        top: 5px;
    }

    /* Override Button Alignment on DateRangePicker */
    .comiseo-daterangepicker-right .comiseo-daterangepicker-buttonpanel {
        float: right;
    }

    .comiseo-daterangepicker:nth-child(2) {
        left: 245px !important;
    }

    #updateStatusContent {
        display: none;
    }

    .updateStatusCheckContainer {
        width: 150px;
        padding: 5px 20px;
        float: left;
        display: inline-block;
        border: 1px solid #67696c;
        margin-right: 5px;
        border-radius: 5px;
    }

    .updateStatusCheckContainer.statusSelected {
        background-color: #25aae1;
        border: 1px solid #25aae1;
        color: #fff;
    }

    table.estimatePricingTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: auto;
        border-radius: 5px;
    }

    table.estimatePricingTable td {
        padding: 5px;
    }

    table.estimatePricingTable th {
        background: #e2e2e2;
        padding: 7px;
    }
    .swal2-confirm{
        float:right
    }
    .swal2-cancel{
        float:left
    }
    #summary_popup #cke_email_content .cke_bottom{
            display:none
        }
    #summary_popup .swal2-confirm {
            float: right;
        }
        #summary_popup h2 {
            font-size: 24px!important;
        }
        #cke_email_content .cke_reset_all{
            display:none
        }
        .filter_info_icon:hover{color: #25AAE1!important;}
.estimatePricingTable tbody tr.odd.selectedRow,
.estimatePricingTable tbody tr.even.selectedRow,
.estimatePricingTable tbody tr.even.selectedRow td.sorting_1,
.estimatePricingTable tbody tr.odd.selectedRow td.sorting_1
{
    background-color: #e4e3e3!important;
}        
</style>


<div id="content" class="clearfix">
    <p>
        <span style="font-size: 15px;margin-top: 10px;position: absolute;"><strong>Admin Campaigns</strong></span>
        
        <a style="margin-bottom: 10px;" href="<?php echo site_url('admin'); ?>" class="btn right">
            <i class="fa fa-chevron-left"></i> Back
        </a>
        <a style="margin-bottom: 10px;margin-right: 8px;" href="javascript:void(0);" class="blue-button btn right reload_table">
        <i class="fa fa-refresh"></i> Reload Table
        </a>
    </p>

    <template id="groupActionsTemplate">
        <div class="materialize">
            <div class="m-btn groupActionsButton" id="groupActionsButton" style="margin-top: -12px; margin-left: -5px;">
                <i class="fa fa-fw fa-check-square-o"></i>
                Group Actions

                <div class="groupActionsContainer" id="campaignGroupActions">
                    <div class="collection groupActionItems">
                        <a href="#" id="groupCampaignDelete" class="collection-item iconLink">
                            <i class="fa fa-fw fa-trash"></i>
                            Delete
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </template>

    <table class="estimatePricingTable" width="100%">
        <thead>
        <tr>
            <th style="width: 20px !important;"><input type="checkbox" id="campaignMasterCheck"></th>
            <th>Go</th>
            <th>Created</th>
            <th>Campaign Name</th>
            <th>User</th>
            <th>Sent</th>
            <th>Delivered</th>
            <th>Bounced</th>
            <th>Opened</th>
            <th>Clicked</th>
            <th>O</th> 
            <th>C</th>
            
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>

<div id="emailContentDialog" title="Preview Email" style="display:none;">
    <div id="email-preview" style="padding:10px"></div>
</div>

<div id="resend-proposals" title="Send Email to Selected Companies Users" style="padding: 0 !important;">
    <table class="boxed-table" style="width: 100%;" cellpadding="0" cellspacing="0">
            <tbody>
            
            <tr class="even">
                <td style="width: 15%;text-align: left;font-weight:bold"><span >Subject: </span></td>
                <td >
                <input type="hidden" name="resend_select_id"  id="resend_select_id" value="">
                <input type="hidden" name="unclicked"  id="unclicked" value="">
                <input class="text" type="text" id="messageSubject" style="width: 280px;"></td>
                
                <td style="text-align: left;font-weight:bold"><span  class="no_campaign">Campaign Name:</span></td>
                <td><input type="text" class="text new_resend_name no_campaign" name="new_resend_name"/></td>

                
            </tr>
            <tr>
            <td style="width: 13%;text-align: left;font-weight:bold">From Name: </td>
                <td style="width: 29%;"><input type="text" name="fromName" id="fromName" class="text" value="<?php echo $this->settings->get('from_name') ?>"/></td>
                <td  style="text-align: left;font-weight:bold">From Email: </td>
                <td><input type="text" name="fromEmail" id="fromEmail" class="text" value="<?php echo $this->settings->get('from_email') ?>"/></td>
            </tr>



            <tr>
            <td colspan="2"><div style="background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;border-radius:4px;width: 100%;line-height: 20px;">
                        <p><strong>Resend Details</strong></p>
                        <p>Initial Campaign: <span id="totalNum"></span> Emails were sent</p>
                        <p id="unopend_unclicked_count_msg"></p>
                        <p class="if_proposal_status_change" style="display:none">- <span id="changeStatusNum"></span> proposals has had status change and will not be resent</p>
                        <p><strong>Sending <span id="resendNum"></span> emails</strong></p>
                    </div>
                    </td></tr>
            <tr class="even">
                <td>Message</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea id="message" name="message">Loading Content...</textarea>
                </td>
            </tr>
            </tbody>
        </table>
    
    
</div>

<div id="resend-proposals-status" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>

        <p id="resendProposalsStatus"></p>
        <p id="alreadyProposals" style="margin-top: 10px;"></p>
        <p id="bouncedProposals" style="margin-top: 10px;"></p>
        <p id="unsentProposals" style="margin-top: 10px;"></p>
</div>
<?php $this->load->view('global/footer'); ?>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js'></script>

<script type="text/javascript">
    var oTable = '';
    $(document).ready(function () {
    //     CKEDITOR.replace('message', {
    //     toolbar: [
    //                         { name: 'styles', items: [ 'Font', 'FontSize' ] },
    //                         { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    //                         { name: 'editing', groups: ['spellchecker' ], items: [ 'Scayt' ] },
    //                         { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','-', 'RemoveFormat' ] },
    //                         { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
    //                         { name: 'links', items: [ 'Link', 'Unlink' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
    //                         [ 'Cut', 'Copy', 'Paste', 'PasteText' ],			// Defines toolbar group without name.
    //                         '/',																					// Line break - next group will be placed in new line.
	//                     ],
    //     height: 200
    // });

    tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
                        relative_urls : false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'320',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });

        oTable = $('.estimatePricingTable').on('error.dt', function (e, settings, techNote, message) {
            console.log('An error has been reported by DataTables: ', message);
            //$("#datatablesError").dialog('open');
        })
            .DataTable({
                "processing": true,
                "serverSide": true,
                "preDrawCallback": function (settings) {
                    $('.estimatePricingTable > tbody').html(
                        '<tr class="odd">' +
                        '<td valign="top" colspan="12" class="dataTables_empty"><svg width="44px" height="44px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ripple"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><g> <animate attributeName="opacity" dur="2s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="1;1;0"></animate><circle cx="50" cy="50" r="40" stroke="#afafb7" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="r" dur="2s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="0;22;44"></animate></circle></g><g><animate attributeName="opacity" dur="2s" repeatCount="indefinite" begin="1s" keyTimes="0;0.33;1" values="1;1;0"></animate><circle cx="50" cy="50" r="40" stroke="#428bca" fill="none" stroke-width="6" stroke-linecap="round"><animate attributeName="r" dur="2s" repeatCount="indefinite" begin="1s" keyTimes="0;0.33;1" values="0;22;44"></animate></circle></g></svg><br/><h3>Loading..</h3></td>' +
                        '</tr>'
                    );
                },
                "ajax": "<?php echo site_url('admin/group_resends_data/'); ?>",
                "columns": [
                    {
                        width: '2%',
                        searchable: false,
                        sortable: false,
                        class: 'dtCenter'
                    },
                    {
                        "searchable": false,
                        "sortable": false
                    },
                    {},
                    {},                                   // 2 Date
                    {class: 'dtCenter'},                                            // 3 Branch
                    {width: '10%',class: 'dtCenter'},                                            // 4 Readable status
                    {class: 'dtCenter'},                              // 5 Status Link
                    {class: 'dtCenter'},    
                    {class: 'dtCenter color_highlight'}, 
                    {class: 'dtCenter click_color_highlight'},     
                    {class: 'dtCenter',"visible": false},  
                    {class: 'dtCenter',"visible": false}                                        // 7 Company
                ],
                "sorting": [
                    [2, "desc"]
                ],
                "jQueryUI": true,
                "autoWidth": false,
                "stateSave": false,
                "paginationType": "full_numbers",
                "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                "lengthMenu": [
                    [10, 25, 50, 100, 200, 500, 1000],
                    [10, 25, 50, 100, 200, 500, 1000]
                ],
                "rowCallback": function( row, data, index ) {
                    if ( data[10] < "30" )
                    {
                        $(row).addClass('row_red');
                    }
                    else if ( data[10] < "50" )
                    {
                        $(row).addClass('row_yellow');
                    }else 
                    {
                        $(row).addClass('row_green');
                    }

                    if ( data[11] < "30" )
                    {
                        $(row).addClass('click_row_red');
                    }
                    else if ( data[11] < "50" )
                    {
                        $(row).addClass('click_row_yellow');
                    }else 
                    {
                        $(row).addClass('click_row_green');
                    }
                },

                "drawCallback": function (settings) {
                    $(".groupActionsContainer").hide();
                    $("#campaignMasterCheck").prop('checked', false);
                    var temp = document.getElementById("groupActionsTemplate");
                    var clon = temp.content.cloneNode(true);
                    $("#groupSelectAllTop").html(clon);
                    $.uniform.update();
                    initTiptip();
                    check_highlighted_row();
                }
            });

        // All / None user master check
        $("#campaignMasterCheck").change(function () {
            var checked = $(this).is(":checked");
            $(".campaignCheck").prop('checked', checked);
            toggleGroupActions();
        });

        // Update master check based on child check
        $(document).on('change', ".campaignCheck", function () {
            var totalChecks = $(".campaignCheck").length;
            var totalChecked = $(".campaignCheck:checked").length;

            if (totalChecks == totalChecked) {
                $("#campaignMasterCheck").prop('checked', true);
            } else {
                $("#campaignMasterCheck").prop('checked', false);
            }
            $.uniform.update();
            toggleGroupActions();
        });

        // Group Actions button toggle content
        $(document).on("click", ".groupActionsButton", function() {
            $(".groupActionsContainer").toggle();
            return false;
        });

        // Group Delete Button Click
        $(document).on('click', "#groupCampaignDelete", function() {

            var resend_id = $(this).attr('data-resend-id');

            swal({
                title: "Are you sure?",
                text: "Campaigns will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function (isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: '/ajax/group_delete_admin_campaigns',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "campaignIds": getSelectedIds(),
                        },

                        success: function (data) {
                            if (!data.error) {
                                oTable.ajax.reload(null, false);
                                swal(
                                    '',
                                    'Campaigns Deleted'
                                );
                                $(".campaignCheck").prop('checked', false);
                                toggleGroupActions();
                                
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
                }
            });
            return false;
        });


        $(document).on('click', "#groupUnopenedResend", function() {

        var resend_id = $(this).attr('data-resend-id');

        swal({
            title: "Are you sure?",
            text: "Resend Unopened Emails",
            showCancelButton: true,
            confirmButtonText: 'Resend',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Resending..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/ajax/adminGroupResendUnopened',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "resendIds": getSelectedIds(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            if(data.total_bounce_unsent >0){
                                swal(
                                    '',
                                    'Some email were not sent as the previous email bounced and the email address has not changed.<br/>Please check your individual campaigns'
                                );

                            }else{

                                swal(
                                    '',
                                    'Admin Emails Resent'
                                );
                            }
                            
                            oTable.ajax.reload(null, false);
                            $(".campaignCheck").prop('checked', false);
                                toggleGroupActions();
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
            }
        });
        return false;
});

        function toggleGroupActions() {
            var totalChecked = $(".campaignCheck:checked").length;

            if (totalChecked > 0) {
                $("#groupSelectAllTop").show();
            } else {
                $("#groupSelectAllTop").hide();
            }
        }

        function getSelectedIds() {
            var IDs = [];

            $(".campaignCheck:checked").each(function () {
                IDs.push($(this).data('campaign-id'));
            });

            return IDs;
        }

        // Dialog for email content
        $("#emailContentDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });

    $("#resend-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });

        // Resend dialog
        $("#resend-proposals").dialog({
            width: 950,
            modal: true,
            open: function () {
                $("#emailCustom").attr('checked', false);
                $(".emailFromOption").hide();
                $.uniform.update();
            },
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {


                        if ($("#emailCustom").attr('checked')) {

                            if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                                alert('Please enter a from name and email address');
                                return false;
                            }
                        }

                        

                        // Make sure the undent is hidden
                        $("#unsentProposals").hide();
                        $("#unsentDetails").hide();
                        $("#alreadyProposals").hide();

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                
                                'emailCC': $("#emailCC").is(":checked"),
                                'subject': $("#messageSubject").val(),
                                'fromName': $("#fromName").val(),
                                'fromEmail': $("#fromEmail").val(),
                                'resendId': $("#resend_select_id").val(),
                                'unclicked': $("#unclicked").val(), 
                                'new_resend_name': $(".new_resend_name").val(),
                                'body': tinymce.get("message").getContent()
                            },
                            url: "<?php echo site_url('admin/adminResendUnopened') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                var resendText = '';

                                if (data.success) {

                                    if (data.success) {
                                        var resendText = 'Your emails are being sent';
                                    } else {
                                        var resendText = 'An error occurred. Please try again';
                                    }
                                    
                                }
                                else {
                                    resendText = 'An error occurred. Please try again';
                                }

                                $("#resendProposalsStatus").html(resendText);
                                
                                $("#resend-proposals-status").dialog('open');
                                //get_resend_lists();

                            });
                        $(this).dialog('close');
                        $("#resendProposalsStatus").html('Sending admin mails...<img src="/static/loading.gif" />');
                        $("#resend-proposals-status").dialog('open');
                        //swal("Success", "Client Emails Resent");
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        $(document).on('click', ".show_email_content", function () {

        var resend_id = $(this).attr('data-resend-id');
        $.ajax({
            url: '/ajax/get_admin_resend_counts_details/',
            type: "POST",
            dataType: "json",
            data: {
                "resend_id": resend_id,
            },

            success: function (data) {
                if (data.success) {

                    var email_content = data.email_content;
                    var subject = data.subject;
                    var sent_time = data.created_at;
                    var custom_sender = data.custom_sendor;
                    if(data.filters){
                        var admin_filters = JSON.parse(data.filters);
                        admin_filters = admin_filters[0]
                    }else{
                        var admin_filters =''
                    }
                    
                    
                    var custom_sender_details = "Admin Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = data.custom_sendor_name+' | '+data.custom_sendor_email;
                    }

                var filter_text = "";
                var filter_count =0;
                if(admin_filters){
                        
                    if(admin_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+admin_filters.pResendType+"</p><br/>";
                    } 
                    var user_class_name = ['Main Admin','Company Admin','Full Access','Branch Manager','User','Secretary Account']
                        
                        if(admin_filters.user_class){
                            filter_count++;
                            var temp_text ='';
                            if(admin_filters.user_class.length == user_class_name.length){
                                 temp_text ='All';
                            }else{
                                for($i=0;$i<admin_filters.user_class.length;$i++){
                                    temp_text += user_class_name[admin_filters.user_class[$i]]+'<br/>';
                                }
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>User Class:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        var expired_name = ['','Only Active Users','Only Expired Users','Active and Expired Users']
                        if(admin_filters.expired){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Expired:</strong>"+expired_name[admin_filters.expired]+"</p><br/>";
                        }
                        
                        if(admin_filters.statusFilter){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Status:</strong>"+admin_filters.statusFilter+"</p><br/>";
                        }
                        
                        
                        if(admin_filters.expiryFilter){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Expiry:</strong>"+admin_filters.expiryFilter+"</p><br/>";
                        }
                        
                        
                    }


                    if(filter_count==0){
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }


                swal({
                    title: "Campaign Summary",
                    html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;"> Sent:</label><p style="margin-top:7px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;">Filters:</label>'+filter_text_details+'</td></tr>'+
                        
                            '<tr><td colspan="2"><textarea  rows="15" class="email_content" name="email_content">'+email_content+'</textarea></td>'+
                            '</tr></table></form>',
                   
                    showCancelButton: false,
                    confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                    width:800,
                    showCloseButton: true,
                    onOpen:  function() {   
                            initTiptip(); 
                            //CKEDITOR.replace( 'email_content',{removePlugins: 'elementspath',readOnly:true,height:300} ); 
                            tinymce.init({selector: ".email_content",relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});
                            $('.swal2-modal').attr('id','summary_popup') 
                        }
                    }).then(function (result) {
                
                        }).catch(swal.noop)

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



//$("#email-preview").html($(this).data('val'));
//$("#emailContentDialog").dialog('open');
});


        $(document).on('click', ".resend_upopened", function () {
            
            var resend_id = $(this).attr('data-val');
            var unclicked = $(this).attr('data-unclicked');
            $('#resend_select_id').val(resend_id); 
            $.ajax({
                        url: '/ajax/get_admin_resend_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                            "clicked" : unclicked
                        },

                        success: function (data) {
                            if (data.success) {
                                if(data.total_resending>0){
                                    var total_resending_msg = ' unopened';
                                    var total_unopend_msg = ' emails were unopened';
                                    var total_deleted = '';
                                    if(unclicked=='1'){
                                        total_resending_msg = ' unclicked';
                                        total_unopend_msg = ' emails were opened but not clicked'
                                       //$('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Client Emails');
                                    }else{
                                        //$('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square"></i> Resend Unopened Client Emails');
                                    }
                                    if(data.total_deleted_account>0){
                                        total_deleted = '<br/>- '+data.total_deleted_account+' Users have been deleted';
                                    }
                                    
                                    $("#resend-proposals").dialog('open');
                                    
                                }else{
                                    if(unclicked=='1'){
                                        swal('','This Campaign has no Unclicked Emails!');
                                    }else{
                                        swal('','This Campaign has no Unopened Emails!');
                                    }
                                    return false;
                                }
                               $('.new_resend_name').val(data.resend_name);
                               $('#messageSubject').val(data.subject);
                               $('#resendSelect').val(resend_id);
                               
                               $('#fromName').val(data.custom_sendor_name);
                               $('#fromEmail').val(data.custom_sendor_email);

                               $('#unclicked').val(unclicked);
                               $('#totalNum').text(data.total_emails);
                               $('#unopend_unclicked_count_msg').html('- '+data.total_unopened+total_unopend_msg+total_deleted);
                               $('#resendNum').text(data.total_resending+ total_resending_msg);
                                
                               $('.if_proposal_status_change').hide();
                             
                                
                  
                  // $('.is_templateSelect_disable').css('display','block');
                   if(data.email_cc==1){
                        $( "#emailCC" ).prop( "checked", true );
                        
                        $.uniform.update();
                   }else{
                        $( "#emailCC" ).prop( "checked", false );
                       
                        $.uniform.update();
                   }
                   

                   if(data.custom_sendor==1){
                        $( "#emailCustom" ).prop( "checked", true );
                        

                        $.uniform.update();
                        
                        $('#messageFromName').val(data.custom_sendor_name);
                        $('#messageFromEmail').val(data.custom_sendor_email);
                   }else{
                        $( "#emailCustom" ).prop( "checked", false );
                        
                        $.uniform.update();
                        $('#messageFromName').val('');
                        $('#messageFromEmail').val('');
                   }
                   $( "#emailCustom" ).trigger('change');
                  
                    
                   //$('#message').html(data.email_content);
                   //CKEDITOR.instances.message.setData(data.email_content);
                   tinymce.get("message").setContent(data.email_content)
                   
                            } else {
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }


                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            swal("Error", "An error occurred Please try again");
                            console.log(errorThrown);
                        }
                    });

            return false;


        });

        $(document).on('click', ".delete_campaign", function () {

            var resend_id = $(this).attr('data-val');

            swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function (isConfirm) {
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
                        url: '/ajax/delete_admin_campaign/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                        },

                        success: function (data) {
                            if (data.success) {
                                oTable.ajax.reload();
                                swal(
                                    'Campaign Deleted',
                                    ''
                                );
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
                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
        });



function check_highlighted_row(){
    if(localStorage.getItem("adc_last_active_row")){
        var row_num =localStorage.getItem("adc_last_active_row");
        $('.estimatePricingTable tbody').find("[data-campaign-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}
    
});


$(document).on('click', '.estimatePricingTable tbody td a, .estimatePricingTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-campaign-id');
    if(hasLocalStorage){
        localStorage.setItem("adc_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("adc_last_active_row", '');
    }
});
 // Proposal Resend options
 $("#emailCustom").change(function () {
        if ($("#emailCustom").attr('checked')) {
            $(".emailFromOption").show();
        }
        else {
            $(".emailFromOption").hide();
            $(".emailFromOption input").val('');
        }
    });

    $('body').click( function(event) {
        var $trigger = $("#groupActionsButton");
       
      
        if("groupActionsButton" !== event.target.id && !$trigger.has(event.target).length){
          
                $(".groupActionsContainer").hide();

       
        }
       
   });

   $('.reload_table').click( function(event) {
    oTable.ajax.reload(null, false);
       
   });

$(document).on('click', ".edit_resend_name", function () {
    
    resendId = $(this).data('resend-id');
    resendName = $(this).data('resend-name');
    swal({
        title: 'Edit Campaign Name',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: "Cancel",
        dangerMode: false,
        reverseButtons:false,
        html:
            '<input id="swal-input1" class="swal2-input" value="'+resendName+'">',
        preConfirm: function () {
            if($('#swal-input1').val()){

            
                return new Promise(function (resolve) {

                resolve(
                    $('#swal-input1').val()
                    
                )
                })
            }else{
                alert('Please Enter the Name');
            }
        },
        onOpen: function () {
            $('#swal-input1').focus()
        }
        }).then(function (result) {
           
            swal('Saving..')

            $.ajax({
                        url: '/ajax/update_admin_resend_name',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resendId": resendId,
                            "resendName":result
                        },

                        success: function (data) {
                            if (!data.error) {
                                
                                swal('Campaign Name Updated')
                                oTable.ajax.reload(null, false);
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
   });
</script>