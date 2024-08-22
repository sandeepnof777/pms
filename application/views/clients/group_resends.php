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
        <span style="font-size: 15px;margin-top: 10px;position: absolute;"><strong>Client Campaigns</strong></span>
        
        <a style="margin-bottom: 10px;" href="<?php echo site_url('clients'); ?>" class="btn right">
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
                        <!-- <a href="#" id="groupUnopenedResend" class="collection-item iconLink">
                            <i class="fa fa-fw fa-envelope"></i>
                            Resend Unopened Emails
                        </a> -->
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

<div id="resend-proposals" title="Confirmation">
    <h3 id="resend-proposals-title"><i class="fa fa-fw fa-envelope-o"></i> Group Resend Emails</h3>

    
    <p style="margin-bottom: 15px;"><span style="padding-right: 33px;font-weight:bold">Email Template:</span>
        <input type="hidden" id="resendSelect" >
        <input type="hidden" id="unclicked" >
        <select id="templateSelect">
            <?php
            foreach ($clientTemplates as $template) {
                /* @var $template \models\ClientEmailTemplate */
                ?>
                <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
                <?php
            }
            ?>
        </select>

        <?php if ($account->isAdministrator()) { ?>
            <span style="float: right;padding-right: 205px;"><input type="checkbox" id="emailCustom"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

        <?php } ?>

        
    </p>

    <p><span style="width: 100px; display: inline-block;padding-right: 39px;font-weight:bold ">Subject:</span><input
                class="text" type="text" id="messageSubject" style="width: 225px;">
        <label style="padding-left: 150px;font-weight:bold">Campaign Name:</label>
        <input type="text" class="text new_resend_name" name="new_resend_name"/>
        
</p><br/>


    <?php if ($account->isAdministrator()) { ?>
        <!-- <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from
            the owner of the proposal.</p> -->
        <p class="emailFromOption" style="margin-bottom: 10px;"><span
                    style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input class="text"
                                                                                                         type="text"
                                                                                                         id="messageFromName"
                                                                                                         style="width: 200px;"><span
                    style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input
                    class="text" type="text" id="messageFromEmail" style="width: 200px;"></p>

    <?php } ?>
    <div style="background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;border-radius:4px;width: 50%;line-height: 20px;">
        <p><strong>Resend Details</strong></p>
        <p>Initial Campaign: <span id="totalNum"></span> Emails were sent</p>
        <p id="unopend_unclicked_count_msg"></p>
        <p class="if_proposal_status_change" style="display:none">- <span id="changeStatusNum"></span> proposals has had status change and will not be resent</p>
        <p class="if_proposal_email_off" style="display:none">- <span id="check_resendExcludeNum"></span> contacts has Email Off</p>
        <p><strong>Sending <span id="resendNum"></span> emails</strong></p>
    </div>
    
    <br/>
    <p style="font-weight:bold;margin-bottom: 10px;">Email Content</p>
    <span style="color: rgb(184, 25, 0);margin-bottom: 10px;display:none"
          class="is_templateSelect_disable adminInfoMessage "><i class="fa fa-fw fa-info-circle"></i> Email content cannot be edited when adding to an existing campaign</span>
    <textarea id="message">This is the content</textarea>
   
</div>

<div id="resend-proposals-status" title="Confirmation">
        <h3>Confirmation - Resend Contacts</h3>

        <p id="resendProposalsStatus"></p>
        <p id="alreadyProposals" style="margin-top: 10px;"></p>
        <p id="bouncedProposals" style="margin-top: 10px;"></p>
        <p id="unsentProposals" style="margin-top: 10px;"></p>
</div>

<div id="preconfirm-resend-proposals" title="Confirmation">
        <h3>Confirmation - Resend Contacts</h3>
        <input id="check_unclick" type="hidden">
        <input id="check_total_resending" type="hidden">
        <input id="check_total_opened" type="hidden">
        
        <div style="width:88%;float: left;background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;margin-top:5px;border-radius:4px;line-height: 20px;">
            <!-- <div style="width: 95%;float: left;"><strong>This will send <span id="resendIncludeNum"></span> emails</strong></div> -->
            
            <p>Initial Campaign: <span id="check_totalNum"></span> Emails were sent</p>
            <!-- <p id="check_unopend_unclicked_count_msg"></p>
            <p class="if_proposal_status_change" style="display:none">- <span id="check_changeStatusNum"></span> proposals has had status change and will not be resent</p> -->
            <!-- <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="confirm_resendNum"></span></strong> Proposals Selected</div> -->
            <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="resendExcludeNum"></span></strong> emails are tagged as 'Email Off'</div>
            <div style="width: 95%;float: left;margin-top:5px;" class="has_excluded_hide"><input type="checkbox" id="sendExcludedEmail" style="margin-left:0px;margin-top:0px;"><span style="margin-top: -2px;position: absolute;" >Send All Emails <i class="fa fa-fw fa-info-circle tiptipright" style="cursor:pointer;" title="Send ALL proposals, even if tagged as 'Email Off'"></i></span></div>
        </div>
    </div>

<?php $this->load->view('global/footer'); ?>
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">
    var oTable = '';
    $(document).ready(function () {
        //CKEDITOR.replace('message');
        tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
                        elementpath: false,
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
                "ajax": "<?php echo site_url('clients/group_resends_data/'); ?>",
                "columns": [
                    {
                        width: '10px',
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
                    {class: 'dtCenter'},                                            // 4 Readable status
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
                "autoWidth": true,
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
                        url: '/ajax/group_delete_client_campaigns',
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
                    url: '/ajax/clientGroupResendUnopened',
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
                                    'Client Emails Resent'
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
                                'fromName': $("#messageFromName").val(),
                                'fromEmail': $("#messageFromEmail").val(),
                                'resendId': $("#resendSelect").val(),
                                'unclicked': $("#unclicked").val(), 
                                'new_resend_name': $(".new_resend_name").val(),
                                'body': tinyMCE.get('message').getContent(),
                                'exclude_override' : $('#sendExcludedEmail').prop("checked") ? 1 : 0 ,

                            },
                            url: "<?php echo site_url('ajax/clientResendUnopened') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                var resendText = '';

                                if (data.success) {
                                    resendText = 'Your Emails are being sent';
                                    
                                    
                                }
                                else {
                                    resendText = 'An error occurred. Please try again';
                                }

                                $("#resendProposalsStatus").html(resendText);
                                
                                $("#resend-proposals-status").dialog('open');
                                //get_resend_lists();

                            });
                        $(this).dialog('close');
                        $("#resendProposalsStatus").html('Sending client mails...<img src="/static/loading.gif" />');
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
            url: '/ajax/get_client_resend_counts_details/',
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
                    var client_filters = JSON.parse(data.filters);
                    
                    var custom_sender_details = "Client Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = data.custom_sendor_name+' | '+data.custom_sendor_email;
                    }

                var filter_text = "";
                var filter_count =0;
                if(client_filters){


                         if(client_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+client_filters.pResendType+"</p><br/>";
                        }
                        if(client_filters.cFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterUser.length;$i++){
                                temp_text +=client_filters.cFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        
                        
                        if(client_filters.cFilterClientAccount){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterClientAccount.length;$i++){
                                temp_text +=client_filters.cFilterClientAccount[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Accounts:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(client_filters.cFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<client_filters.cFilterBusinessType.length;$i++){
                                temp_text +=client_filters.cFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        if(client_filters.cResendExclude){
                            filter_count++;
                            var temp_text ='';
                            if(client_filters.cResendExclude == 0){
                                temp_text += "Email On";
                            } else {
                                temp_text += "Email Off";
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>campaign:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        
                    }

                    if(filter_count==0){
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }

                    tinymce.remove('email_content');

                swal({
                    title: "Campaign Summary",
                    html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;"> Sent:</label><p style="margin-top:7px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;"> Filters:</label>'+filter_text_details+'</td></tr>'+
                        
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
                            tinymce.init({selector: ".email_content",elementpath: false, relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true})
                            
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

});

    // Proposal Resend pre Confirm
    $("#preconfirm-resend-proposals").dialog({
        width: 400,
        modal: true,
        buttons: {
            OK: {
                text: 'Continue',
                'class': 'btn ui-button update-button preconfirm-resend-btn',
                click: function () {
                    $(this).dialog("close");
                    
                    var unclicked  =$('#check_unclick').val();
                    var total_resending  =$('#check_total_resending').val();
                    var total_opened  =$('#check_total_opened').val();
                    var total_excluded  =$('#resendExcludeNum').html(); 
                    
                    var total_resending_msg = ' unopened';
                    var total_unopend_msg = ' emails were unopened';
                    if(unclicked=='1'){
                        total_resending_msg = ' unclicked';
                        total_unopend_msg = ' emails were opened but not clicked'
                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Proposals');
                    }else{
                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square"></i> Resend Unopened Proposals');
                    }
                    if($('#sendExcludedEmail').prop("checked")){
                        //$("#resendIncludeNum").html($('#check_total_opened').val());
                    }else{
                        total_resending = (total_resending -total_excluded);
                        $(".if_proposal_email_off").show();
                    }

                    $('#unopend_unclicked_count_msg').text('- '+total_opened+total_unopend_msg);
                    $('#resendNum').text(total_resending+ total_resending_msg);                
                    $("#resend-proposals").dialog('open');
                }
            },
            
            Cancel: {
                    text: 'Cancel',
                    'class': 'btn ui-button left',

                    click: function () {
                        $(this).dialog("close");
                    }
                }
        },
        autoOpen: false
    });


        $(document).on('click', ".resend_upopened", function () {
            
            var resend_id = $(this).attr('data-val');
            var unclicked = $(this).attr('data-unclicked');

            $('#check_unclick').val(unclicked);
            $('#sendExcludedEmail').prop('checked',false);
            $.ajax({
                        url: '/ajax/get_client_resend_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                            "clicked" : unclicked
                        },

                        success: function (data) {
                            if (data.success) {

                                if(data.total_resending>0){

                                    $(".if_proposal_email_off").hide();
                                    var total_resending_msg = ' unopened';
                                    var total_unopend_msg = ' emails were unopened';
                                    if(unclicked=='1'){
                                        total_resending_msg = ' unclicked';
                                        total_unopend_msg = ' emails were opened but not clicked'
                                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Proposals');
                                    }else{
                                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square"></i> Resend Unopened Proposals');
                                    }
                                    
                                    if(data.total_excluded>0)
                                    {
                                        $(".preconfirm-resend-btn").prop('disabled',false);
                                        $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
                                        
                                        $('#check_total_resending').val(data.total_resending);
                                        $('#check_total_opened').val(data.total_unopened);
                                        
                                        $('#check_totalNum').text(data.total_proposals);
                                        var exclude_count = data.total_excluded;
                                        
                                        if(data.excluded_override){
                                            var include_count = data.total_resending;
                                            $('#sendExcludedEmail').prop('checked',true);
                                        }else{
                                            var include_count = (data.total_resending - data.total_excluded);
                                        }
                                        
                                        $('#check_unopend_unclicked_count_msg').text('- '+data.total_opened+total_unopend_msg);
                                        $('#resendNum').text(data.total_resending+ total_resending_msg);
                                        $("#resendExcludeNum").html(exclude_count);
                                        $("#check_resendExcludeNum").html(exclude_count);
                                        $("#resendIncludeNum").html(include_count);
                                        $("#confirm_resendNum").html(data.total_resending);
                                        $("#preconfirm-resend-proposals").dialog('open');

                
                                        if(include_count==0){
                                            $(".preconfirm-resend-btn").prop('disabled',true);
                                            $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                                        }
                                    }
                                    else{
                                       
                                        $("#resend-proposals").dialog('open');
                                    }
                                    
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
                               $('#unclicked').val(unclicked);
                               $('#totalNum').text(data.total_emails);
                               $('#unopend_unclicked_count_msg').text('- '+data.total_unopened+total_unopend_msg);
                               $('#resendNum').text(data.total_resending+ total_resending_msg);
                               $('.if_proposal_status_change').hide();
                                
                               $('#excludedEmails').html(data.total_excluded);
                                if(data.excluded_override>0)
                                {
                                    $('#sendExcludedEmail').prop('checked', true);
                                }
                                else
                                {
                                    $('#sendExcludedEmail').prop('checked', false);
                                }

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
                  
                    
                   
                   //CKEDITOR.instances.message.setData(data.email_content);
                   tinymce.get('message').setContent(data.email_content);
                   
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
                        url: '/ajax/delete_client_campaign/',
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
    if(localStorage.getItem("coc_last_active_row")){
        var row_num =localStorage.getItem("coc_last_active_row");
        $('.estimatePricingTable tbody').find("[data-campaign-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}

        $("#sendExcludedEmail").click(function () {
            var include_count =0;
            if($('#sendExcludedEmail').prop("checked")){
                $("#resendIncludeNum").html($('#check_total_opened').val());
                $(".preconfirm-resend-btn").prop('disabled',false);
                $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
            }else{
                var check_value = ($('#check_total_resending').val() - $('#resendExcludeNum').html());
                $("#resendIncludeNum").html(check_value);
                console.log(check_value);
                if(check_value==0){
                    $(".preconfirm-resend-btn").prop('disabled',true);
                    $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                }
            }
        });

});

$(document).on('click', '.estimatePricingTable tbody td a, .estimatePricingTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-campaign-id');
    if(hasLocalStorage){
        localStorage.setItem("coc_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("coc_last_active_row", '');
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
                        url: '/ajax/update_client_resend_name',
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

           // Template change handler
           $('#templateSelect').change(function() {
            var selectedTemplate = $('#templateSelect option:selected').data('template-id');
            loadTemplateContents(selectedTemplate);
        });

        // Load the selected content
        var defaultTemplate = $('#templateSelect option:selected').data('template-id');
        //loadTemplateContents(defaultTemplate);

        function loadTemplateContents(templateId){

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'templateId': templateId},
                url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
            .success(function (data) {
                $("#messageSubject").val(data.templateSubject);
                //CKEDITOR.instances.message.setData(data.templateBody);
                tinymce.get('message').setContent(data.templateBody);
            });

            //$.uniform.update();
            //initUI();
        }
</script>