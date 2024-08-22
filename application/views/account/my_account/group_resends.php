<?php $this->load->view('global/header'); ?>
<style type="text/css">

  .row_red .color_highlight{
    background-color: #e6a5a5!important;
} 
.row_red .color_highlight::after {
    right: 0;
    background-color: #e6a5a5!important;
}
.row_red .color_highlight::before {
    right: 0;
    background-color: transparent!important;
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
    .brb_wh{border-bottom: 1px solid #fff!important;}
    .boxed-table label {
        line-height: 20px!important;
    }
    #status_breakdown_table_wrapper .ui-toolbar {
    padding: 0px;
    
}
#status_breakdown_table_wrapper {
    margin-top: 5px!important;
    
}

#status_breakdown_table th {
    background-color: #e4e2e2  !important;
    color: #6d6d6d;
}
.dark_header_tr{
    background: #54575c url(images/content-box-header-darker.png) repeat-x top!important;
    color: #e6e8eb;
}

.camp_st_tb1 td{
    border-bottom: 1px solid #eee !important;
}
#campaign_stats_popup .swal2-close{
    top: -6px;
    right: 3px;
}


.camp_st_tb1 td{
    border-bottom: 1px solid #eee !important;
}
#campaign_stats_popup .swal2-close{
    top: -6px;
    right: 3px;
}
.estimatePricingTable tbody tr.odd.selectedRow,
.estimatePricingTable tbody tr.even.selectedRow,
.estimatePricingTable tbody tr.even.selectedRow td.sorting_1,
.estimatePricingTable tbody tr.odd.selectedRow td.sorting_1
{
    background-color: #e4e3e3!important;
} 
#newProposalFilterButton,.Proposal_left_actions{display: none!important;} 
#proposalsTopContent .materialize{
    height: 30px;
}
#proposalsTable_wrapper{margin-top: 5px!important;}
</style>


<div id="content" class="clearfix">
    <p>
        <!-- <span style="font-size: 15px;margin-top: 10px;position: absolute;"><strong>Proposal Resend Campaigns</strong></span> -->
        
        <a style="margin-bottom: 10px;" href="<?php echo site_url('proposals'); ?>" class="btn right">
            <i class="fa fa-chevron-left"></i> Back
        </a>
        <a style="margin-bottom: 10px;margin-right: 8px;" href="javascript:void(0);" class="blue-button btn right reload_table">
        <i class="fa fa-refresh"></i> Reload Table
        </a>
    </p>
    <div id="proposal_resend_tabs" style="float: left;width:930px ">
                    
        <ul>
            <li><a href="#tabs-1">Proposal Resend Campaigns</a></li>
            <li><a href="#tabs-2">Automatic Resends</a></li>
            
        </ul>
        <div id="tabs-1">
            <template id="groupActionsTemplate">
                <div class="materialize">
                    <div class="m-btn groupActionsButton" id="groupActionsButton" style="margin-top: -12px; margin-left: -5px;">
                        <i class="fa fa-fw fa-check-square-o"></i>
                        Group Actions

                        <div class="groupActionsContainerResend" id="campaignGroupActions">
                            <div class="collection groupActionItems">
                                <a href="#" id="groupCampaignDelete" class="collection-item iconLink">
                                    <i class="fa fa-fw fa-trash"></i>
                                    Delete
                                </a>
                                <!-- <a href="#" id="groupUnopenedResend" class="collection-item iconLink">
                                    <i class="fa fa-fw fa-envelope"></i>
                                    Resend Unopened Proposals
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
        <div id="tabs-2" style="padding-top: 5px;">
            <div id="newFilter" style="margin-bottom: 0px;">
                <div class="clearfix">
                    <?php
                    
                    if ($action != 'search') {
                        $this->load->view('templates/proposals/filters/new-proposal-filters');
                        //$this->load->view('templates/proposals/filters/default-filters');
                    } ?>
                </div>
                <input type="hidden" id="pageAction" value="<?php echo $action; ?>"/>
                <input type="hidden" id="group" value="<?php echo $group; ?>"/>
                <input type="hidden" id="search" value="<?php echo $search; ?>"/>

                <div class="filterOverlay"></div>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="dataTables-proposalsNew display" id="proposalsTable" style="display: none; width: 1100px;">
                <thead>
                <tr>
                    <td class="proposal_table_checkbox"><input type="checkbox" id="proposalMasterCheck"></td>
                    <td style="text-align: center;">Go</td>
                    <td>Sent Date</td>
                    <td>Date</td>
                    <td>Status</td>
                    <td width="52">Job#</td>
                    <td>Account</td>
                    <td>Project Name</td>
                    <td><i class="fa fa-fw fa-image"></td>
                    <td>Price</td>
                    <td>Contact</td>
                    <td>User</td>
                    <td>Last Activity</td>
                    <td><img src="/3rdparty/icons/email_unsent.png" class="tiptiptop" style="margin-top: 9px;" title="Email Status"></td>
                    <td width="30"><div class="badge blue tiptiptop" title="Delivery Status">D</div></td>
                    <td width="30"><div class="badge green tiptiptop" title="Open Status">O</div></td>
                    <td width="30"><div class="badge green tiptiptop" title="Audit Status">A</div></td>
                    <td width="30"><div class="badge green tiptiptop" title="Estimate Status">E</div></td>
                    <td width="30">GP</td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="proposalsMapContainer" style="display: none; position: relative;">
                    <?php $this->load->view('templates/proposals/map/info'); ?>
                    <?php $this->load->view('templates/proposals/map/map'); ?>
                </div>
        </div>
    </div>
</div>

<div id="emailContentDialog" title="Preview Email" style="display:none;">
    <div id="email-preview" style="padding:10px"></div>
</div>
<div id="bounced-resend-proposals" title="Bounced Email Resend" style="display:none;">

<input type="hidden" id="bounced_campaign_id">
<div style="background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;border-radius:4px;width: 91%;line-height: 20px;">
        <p><strong>Bounced Resend Details</strong></p>
        <p>Initial Campaign: <span id="bounced_totalNum"></span> Emails were sent</p>
        <p id="bounced_count_msg"></p>
        <p><strong>Sending <span id="bounced_resendNum"></span> emails</strong></p>
    </div>
</div>
<div id="resend-proposals-new" title="Confirmation">
    <h3 id="resend-proposals-title" style="font-size:18px;color: #25AAE1;"><i class="fa fa-fw fa-envelope-o"></i> Group Resend Emails</h3>
   
    
    <p style="margin-bottom: 15px;"><span style="padding-right: 33px;font-weight:bold">Email Template:</span>
        <input type="hidden" id="resendSelect-new" >
        <input type="hidden" id="unclicked-new" >
        <input type="hidden" id="bouncedEmail-new" >
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
                    <span style="float: right;padding-right: 65px;"><input type="checkbox" id="emailCustom-new"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

                <?php } ?>
                <span style="float: right;padding-right: 15px;"><input type="checkbox" id="emailCC"> <span
                    style="display: inline-block; padding-top: 2px;"> Send CC to User</span></span>

        
    </p>
    
    <p><span style="width: 100px; display: inline-block;padding-right: 39px;font-weight:bold ">Subject:</span><input
                class="text" type="text" id="messageSubject-new" style="width: 225px;">
                <label style="padding-left: 150px;font-weight:bold">Campaign Name:</label>
                <input type="text" class="text new_resend_name" name="new_resend_name"/>
                
    </p><br/>


    <?php if ($account->isAdministrator()) { ?>
        <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from
            the owner of the proposal.</p>
        <p class="emailFromOption" style="margin-bottom: 10px;"><span
                    style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input class="text"
                                                                                                         type="text"
                                                                                                         id="messageFromName-new"
                                                                                                         style="width: 200px;"><span
                    style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input
                    class="text" type="text" id="messageFromEmail-new" style="width: 200px;"></p>

    <?php } ?>
    <div style="background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;border-radius:4px;width: 50%;line-height: 20px;">
        <p><strong>Resend Details</strong></p>
        <p>Initial Campaign: <span id="totalNum"></span> Emails were sent</p>
        <p id="unopend_unclicked_count_msg"></p>
        <p class="if_proposal_status_change" style="display:none">- <span id="changeStatusNum"></span> proposals has had status change and will not be resent</p>
        <p class="if_proposal_email_off" style="display:none">- <span id="check_resendExcludeNum"></span> proposals has Email Off</p>
        
        <p><strong>Sending <span id="resendNum"></span> emails</strong></p>
    </div>
    <br/>
    <p style="font-weight:bold;margin-bottom: 10px;">Email Content</p>
    <span style="color: rgb(184, 25, 0);margin-bottom: 10px;display:none"
          class="is_templateSelect_disable adminInfoMessage "><i class="fa fa-fw fa-info-circle"></i> Email content cannot be edited when adding to an existing campaign</span>
    <textarea id="message">This is the content</textarea>


    
    
</div>
<div id="preconfirm-resend-proposals-new" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>
        <input id="check_unclick" type="hidden">
        <input id="check_bounced" type="hidden">
        <input id="check_total_resending" type="hidden">
        <input id="check_total_opened" type="hidden">
        
        <div style="width:88%;float: left;background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;margin-top:5px;border-radius:4px;line-height: 20px;">
            <!-- <div style="width: 95%;float: left;"><strong>This will send <span id="resendIncludeNum"></span> emails</strong></div> -->
            
            <p>Initial Campaign: <span id="check_totalNum"></span> Emails were sent</p>
            <!-- <p id="check_unopend_unclicked_count_msg"></p>
            <p class="if_proposal_status_change" style="display:none">- <span id="check_changeStatusNum"></span> proposals has had status change and will not be resent</p> -->
            <!-- <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="confirm_resendNum"></span></strong> Proposals Selected</div> -->
            <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="resendExcludeNum-new"></span></strong> emails are tagged as 'Email Off'</div>
            <div style="width: 95%;float: left;margin-top:5px;" class="has_excluded_hide"><input type="checkbox" id="sendExcludedEmail" style="margin-left:0px;margin-top:0px;"><span style="margin-top: -2px;position: absolute;" >Send All Emails <i class="fa fa-fw fa-info-circle tiptipright" style="cursor:pointer;" title="Send ALL proposals, even if tagged as 'Email Off'"></i></span></div>
        </div>
    </div>

<div id="resend-proposals-status" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>

        <p id="resendProposalsStatus"></p>
        <p id="alreadyProposals" style="margin-top: 10px;"></p>
        <p id="bouncedProposals" style="margin-top: 10px;"></p>
        <p id="unsentProposals" style="margin-top: 10px;"></p>
        <p id="unsentDetails" style="margin-top: 10px;">Only approved proposals, or proposals below the Approval Limit were sent</p>
</div>
<?php $this->load->view('templates/proposals/table/table-js'); ?>
<?php $this->load->view('global/footer'); ?>
<script src='/static/js/inputmask.js'></script>

<script type="text/javascript">
    var pcsTable = '';
    $(document).ready(function () {

        $("#proposal_resend_tabs").tabs({
            beforeActivate: function(event, ui) {
                
                // If we're clicking the preview tab, we need to reload the iframe
                if (ui.newPanel.selector == '#tabs-1') {

                    pcsTable.ajax.reload(null, false);
                }

                // If we're clicking the preview tab, we need to reload the iframe
                if (ui.newPanel.selector == '#tabs-2') {

                    oTable.ajax.reload(null, false);
                }

            }
        });

        function reverseDatePreset(startDate,endDate) {
            var preset ='custom';
            if(startDate == moment().subtract(1, 'days').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'days').format('MM/DD/YYYY')){
                preset = 'Yesterday';
            }else if(startDate == moment().subtract(6, 'days').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Last 7 Days';
            }else if(startDate == moment().startOf('month').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Month To Date';
            }else if(startDate == moment().subtract(1, 'month').startOf('month').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'month').endOf('month').format('MM/DD/YYYY')){
                preset = 'Previous Month';
            }else if(startDate == moment().startOf('year').format('MM/DD/YYYY') && endDate == moment().format('MM/DD/YYYY')){
                preset = 'Year To Date';
            }else if(startDate == moment().subtract(1, 'year').startOf('year').format('MM/DD/YYYY') && endDate == moment().subtract(1, 'year').endOf('year').format('MM/DD/YYYY')){
                preset = 'Previous Year';
            }

            return preset;

        }

        function readableValue(num, digits) {
            const lookup = [
                { value: 1, symbol: "" },
                { value: 1e3, symbol: "k" },
                { value: 1e6, symbol: "M" },
                { value: 1e9, symbol: "G" },
                { value: 1e12, symbol: "T" },
                { value: 1e15, symbol: "P" },
                { value: 1e18, symbol: "E" }
            ];
            const rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
            var item = lookup.slice().reverse().find(function(item) {
                return num >= item.value;
            });
            return (num / item.value).toFixed(digits).replace(rx, "$1") + item.symbol;
        }


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

        pcsTable = $('.estimatePricingTable').on('error.dt', function (e, settings, techNote, message) {
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
                "ajax": "<?php echo site_url('account/group_resends_data/'); ?>",
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
                    {class: 'dtCenter',"visible": false}                                       // 7 Company
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
                    $(".groupActionsContainerResend").hide();
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

        // Proposal Resend Update
    $("#resend-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                pcsTable.ajax.reload(null,false);
            }
        },
        autoOpen: false
    });


        // Group Actions button toggle content
        $(document).on("click", ".groupActionsButton", function() {
            $(".groupActionsContainerResend").toggle();
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
                        url: '/ajax/group_delete_proposal_campaigns',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "campaignIds": getSelectedIds(),
                        },

                        success: function (data) {
                            if (!data.error) {
                                pcsTable.ajax.reload(null, false);
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
                    url: '/ajax/groupResendUnopened',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "resendIds": getSelectedIds(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            
                            console.log(data.total_bounce_unsent)
                            if(data.total_bounce_unsent >0){
                                swal(
                                    '',
                                    'Some email were not sent as the previous email bounced and the email address has not changed.<br/>Please check your individual campaigns'
                                );

                            }else{

                                swal(
                                    '',
                                    'Proposal Emails Resent'
                                );
                            }
                            pcsTable.ajax.reload(null, false);
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

        // Resend bounced dialog
        $("#bounced-resend-proposals").dialog({
            width: 550,
            modal: true,
            open: function () {
                // $("#emailCustom").attr('checked', false);
                // $(".emailFromOption").hide();
                // $.uniform.update();
            },
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {



                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                
                                'campaign_id': $("#bounced_campaign_id").val(),
                                'proposal_ids':0,
                            },
                            url: "<?php echo site_url('ajax/groupResendBouncedProposals') ?>?" + Math.floor((Math.random() * 100000) + 1),
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
                        $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                        $("#resend-proposals-status").dialog('open');
                        //swal("Success", "Proposal Emails Resent");
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // Resend dialog
        $("#resend-proposals-new").dialog({
            width: 950,
            modal: true,
            open: function () {
                $("#emailCustom-new").attr('checked', false);
                $(".emailFromOption").hide();
                $.uniform.update();
            },
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {


                        if ($("#emailCustom-new").attr('checked')) {

                            if (!$("#messageFromName-new").val() || !$("#messageFromEmail-new").val()) {
                                alert('Please enter a from name and email address');
                                return false;
                            }
                        }

                        

                        // Make sure the undent is hidden
                        $("#unsentProposals").hide();
                        $("#unsentDetails").hide();
                        $("#alreadyProposals").hide();
                        $("#bouncedProposals").hide();

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                
                                'emailCC': $("#emailCC").is(":checked"),
                                'subject': $("#messageSubject-new").val(),
                                'fromName': $("#messageFromName-new").val(),
                                'fromEmail': $("#messageFromEmail-new").val(),
                                'resendId': $("#resendSelect-new").val(),
                                'unclicked': $("#unclicked-new").val(),
                                'bouncedEmail': $("#bouncedEmail-new").val(), 
                                'new_resend_name': $(".new_resend_name").val(),
                                'body': tinyMCE.get('message').getContent(),
                                'exclude_override' : $('#sendExcludedEmail').prop("checked") ? 1 : 0 ,
                            },
                            url: "<?php echo site_url('ajax/groupResendUnopened2') ?>?" + Math.floor((Math.random() * 100000) + 1),
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
                        $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                        $("#resend-proposals-status").dialog('open');
                        //swal("Success", "Proposal Emails Resent");
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
                        url: '/ajax/get_resend_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                            "clicked" : 0
                        },

                        success: function (data) {
                            if (data.success) {
                          
                    var email_content = data.email_content;
                    var subject = data.subject;
                    var sent_time = data.created_at;
                    var custom_sender = data.custom_sendor;
                    var proposal_filters = JSON.parse(data.filters);
                    var custom_sender_details = "Proposal Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = data.custom_sendor_name+' | '+data.custom_sendor_email;
                    }

                    var filter_text = "";
                    var filter_count =0;
                    if(proposal_filters){

                        
                        if(proposal_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+proposal_filters.pResendType+"</p><br/>";
                        }
                       
                        if(proposal_filters.pFilterStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterStatus[$i]+'<br/>';
                            }
                            filter_text += "<table style='padding:0px'><tr style='padding:0px'><td style='text-align:left;padding:0px'><strong style='text-align:left;'>Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";

                        }
                        if(proposal_filters.pFilterJobCostStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterJobCostStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterJobCostStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>JobCost Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        if(proposal_filters.pFilterEstimateStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterEstimateStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterEstimateStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Estimate Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";

                        }
                        if(proposal_filters.pFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterUser.length;$i++){
                                temp_text +=proposal_filters.pFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        if(proposal_filters.pFilterEmailStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterEmailStatus.length;$i++){
                                temp_text +=proposal_filters.pFilterEmailStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Email Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        if(proposal_filters.pFilterQueue){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterQueue.length;$i++){
                                temp_text +=proposal_filters.pFilterQueue[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Queue Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        if(proposal_filters.pFilterClientAccount){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterClientAccount.length;$i++){
                                temp_text +=proposal_filters.pFilterClientAccount[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Accounts:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        if(proposal_filters.pFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<proposal_filters.pFilterBusinessType.length;$i++){
                                temp_text +=proposal_filters.pFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        var bidText='';
                        if(proposal_filters.pFilterMinBid!='' && proposal_filters.pFilterMinBid>0){
                            bidText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Bid:</strong>From $"+readableValue(proposal_filters.pFilterMinBid);
                        }
                        if(proposal_filters.pFilterMaxBid !='' && proposal_filters.pFilterMaxBid>0){
                            if(bidText !=''){
                                bidText +=' To $'+readableValue(proposal_filters.pFilterMaxBid)+'</p><br/>';
                            }else{
                                bidText +="<p style='padding-left:3px;'><strong style='text-align:left;'>Bid:</strong>Up To $"+readableValue(proposal_filters.pFilterMaxBid)+"</p><br/>";
                            }
                            
                        }else{
                            if(bidText !=''){
                                bidText +='</p><br/>';
                            }
                        }
                        filter_text +=bidText;

                        if(bidText !=''){
                                filter_count++;
                        }
                        
                    var createdText='';

                    if (proposal_filters.pCreatedFrom || proposal_filters.pCreatedTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var createdRangeString;

                        if (proposal_filters.pCreatedFrom !='' && proposal_filters.pCreatedTo !='') {

                            fromDateString = proposal_filters.pCreatedFrom;
                            toDateString = proposal_filters.pCreatedTo;
                            
                            createdRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                createdRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pCreatedFrom !='') {
                            fromDateString = proposal_filters.pCreatedFrom;
                            createdRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pCreatedTo;
                            createdRangeString = 'Before ' + toDateString;
                        }

                        createdText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Created:</strong>" +createdRangeString +"</p><br/>";


                    }


                        filter_text +=createdText;
                        if(createdText !=''){
                                filter_count++;
                        }

                        var activityText ='';

                        if (proposal_filters.pActivityFrom || proposal_filters.pActivityTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var activityRangeString;

                        if (proposal_filters.pActivityFrom !='' && proposal_filters.pActivityTo !='') {

                            fromDateString = proposal_filters.pActivityFrom;
                            toDateString = proposal_filters.pActivityTo;
                            activityRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                activityRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pActivityFrom !='') {
                            fromDateString = proposal_filters.pActivityFrom;
                            activityRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pActivityTo;
                            activityRangeString = 'Before ' + toDateString;
                        }

                        activityText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Activity:</strong>" +activityRangeString +"</p><br/>";


                    }

                        filter_text +=activityText;
                        if(activityText !=''){
                                filter_count++;
                        }


                        var wonDateText ='';

                        if (proposal_filters.pWonFrom || proposal_filters.pWonTo) {
                        
                        var fromDateString;
                        var toDateString;
                        var activityRangeString;

                        if (proposal_filters.pWonFrom !='' && proposal_filters.pWonTo !='') {

                            fromDateString = proposal_filters.pWonFrom;
                            toDateString = proposal_filters.pWonTo;
                            activityRangeString = fromDateString + ' - ' + toDateString;
                            var presetString = reverseDatePreset(fromDateString,toDateString);
                            if(presetString !='custom'){
                                activityRangeString = presetString;
                            }

                        }
                        else if (proposal_filters.pWonFrom !='') {
                            fromDateString = proposal_filters.pWonFrom;
                            activityRangeString = 'After ' + fromDateString;
                        }
                        else {
                            toDateString = proposal_filters.pWonTo;
                            activityRangeString = 'Before ' + toDateString;
                        }

                        wonDateText += "<p style='padding-left:3px;'><strong style='text-align:left;'>Won Date:</strong>" +activityRangeString +"</p><br/>";


                    }

                        filter_text +=wonDateText;
                        if(wonDateText !=''){
                                filter_count++;
                        }

                        if(proposal_filters.pResendInclude != proposal_filters.pResendExclude){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Email :</strong>";
                            if(proposal_filters.pResendInclude ==1){
                                filter_text += 'Email On';
                            }else{
                                filter_text += 'Email Off';
                            }
                            filter_text += "</p><br/>"
                        }

                        if(proposal_filters.pSigned != proposal_filters.pUnsigned){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Signature :</strong>";
                            if(proposal_filters.pSigned ==1){
                                filter_text += 'Signed';
                            }else{
                                filter_text += 'Unsigned';
                            }
                            filter_text += "</p><br/>"
                        }
                        


                    }

                    if(filter_count==0){
                        var filter_text_details ='<p style="padding:7px;padding-top:2px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="padding:7px;padding-top:2px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;padding-left: 2px;margin-top: -1px;float: right;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }

                swal({
                title: "Campaign Summary",
                html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;padding-top:2px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;"> Sent:</label><p style="padding:7px;padding-top:2px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;padding-top:2px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;">Filters:</label>'+filter_text_details+'</td></tr>'+
                        
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
                        tinymce.init({selector: ".email_content", elementpath: false, relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});
                        $('.swal2-modal').attr('id','summary_popup')  
                    }
                }).then(function (result) {
                //$('#add_job_cost_item_form').submit();
                }).catch(swal.noop)





                               //////////////////
  
                   
                   
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


            // $("#email-preview").html($(this).data('val'));
            
            // $("#emailContentDialog").dialog('open');
        });

    // Proposal Resend pre Confirm
    $("#preconfirm-resend-proposals-new").dialog({
        width: 400,
        modal: true,
        buttons: {
            OK: {
                text: 'Continue',
                'class': 'btn ui-button update-button preconfirm-resend-btn',
                click: function () {
                    $(this).dialog("close");
                    
                    var unclicked  =$('#check_unclick').val();
                    var bounced  =$('#check_bounced').val();
                    var total_resending  =$('#check_total_resending').val();
                    var total_opened  =$('#check_total_opened').val();
                    var total_excluded  =$('#resendExcludeNum-new').html(); 
                    
                    var total_resending_msg = ' unopened';
                    var total_unopend_msg = ' emails were unopened';
                    if(unclicked=='1'){
                        total_resending_msg = ' unclicked';
                        total_unopend_msg = ' emails were opened but not clicked'
                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Proposals');
                    }else if(bounced=='1'){
                        total_resending_msg = ' bounced';
                        total_unopend_msg = ' emails were send but not Delivered'
                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Bounced Proposals');
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
                    $("#resend-proposals-new").dialog('open');
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

    $(document).on('click', ".resend_bounced", function () {
        var resend_id = $(this).attr('data-val');
        $('#bounced_campaign_id').val(resend_id);
        bounced_campaign_id
        $.ajax({
                        url: '/ajax/get_resend_bounced_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                            
                        },

                        success: function (data) {
                            if (data.success) {
                                if(data.total_resending>0){
                                    total_resending_msg = ' bounced';
                                        total_unopend_msg = ' email(s) were sent but not delivered';
                                    $('#bounced_totalNum').text(data.total_proposals);
                                    $('#bounced_count_msg').text('- '+data.total_bounced+total_unopend_msg);
                                    $('#bounced_resendNum').text(data.total_resending+ total_resending_msg);
                                    
                                    $("#bounced-resend-proposals").dialog('open');
                                }else{
                                    
                                        swal('','This Campaign has no Bounced Proposals!');
                                    
                                    
                                    return false;
                                }
                   
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
    })

        $(document).on('click', ".resend_upopened", function () {
            
            var resend_id = $(this).attr('data-val');
            var unclicked = $(this).attr('data-unclicked');
            var bounced = $(this).attr('data-bounced');
            
            $('#check_bounced').val(bounced);
            $('#check_unclick').val(unclicked);
            $('#sendExcludedEmail').prop('checked',false);
            
            $.ajax({
                        url: '/ajax/get_resend_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                            "clicked" : unclicked,
                            "bounced" : bounced
                        },

                        success: function (data) {
                            if (data.success) {
                                if(data.total_resending>0){
                                    $(".if_proposal_email_off").hide();
                                    var total_resending_msg = ' unopened';
                                    var total_unopend_msg = ' emails were unopened';
                                    if(unclicked=='1'){
                                        total_resending_msg = ' unclicked';
                                        total_unopend_msg = ' email(s) were opened but not clicked'
                                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Proposals');
                                    }else if(bounced =='1'){
                                        total_resending_msg = ' bounced';
                                        total_unopend_msg = ' email(s) were sent but not delivered'
                                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square-o"></i> Resend Bounced Proposals');
                                    }else{
                                        $('#resend-proposals-title').html('<i class="fa fa-fw fa-share-square"></i> Resend Unopened Proposals');
                                    }
                                    if(data.total_excluded<1){
                                    
                                        
                                        $('#unopend_unclicked_count_msg').text('- '+data.total_opened+total_unopend_msg);
                                        $('#resendNum').text(data.total_resending+ total_resending_msg);
                                        $("#resend-proposals-new").dialog('open');
                                    }else{
                                        $(".preconfirm-resend-btn").prop('disabled',false);
                                        $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
                                        
                                        $('#check_total_resending').val(data.total_resending);
                                        $('#check_total_opened').val(data.total_opened);
                                        
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
                                        $("#resendExcludeNum-new").html(exclude_count);
                                        $("#check_resendExcludeNum").html(exclude_count);
                                        $("#resendIncludeNum").html(include_count);
                                        $("#confirm_resendNum").html(data.total_resending);
                                        $("#preconfirm-resend-proposals-new").dialog('open');

                
                                        if(include_count==0){
                                            $(".preconfirm-resend-btn").prop('disabled',true);
                                            $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                                        }
                                    }
                                    
                                }else{
                                    if(unclicked=='1'){
                                        swal('','This Campaign has no Unclicked Proposals!');
                                    }else if(bounced =='1'){
                                        swal('','This Campaign has no Bounced Proposals!');
                                    }else{
                                        swal('','This Campaign has no Unopened Proposals!');
                                    }
                                    
                                    return false;
                                }
                               $('.new_resend_name').val(data.resend_name);
                               $('#messageSubject-new').val(data.subject);
                               $('#resendSelect-new').val(resend_id);
                               $('#unclicked-new').val(unclicked);
                               $('#bouncedEmail-new').val(bounced);
                               $('#totalNum').text(data.total_proposals);
                               
                               if(data.total_not_sent>0){
                                  $('.if_proposal_status_change').show();
                                  $('#changeStatusNum').text(data.total_not_sent);
                                  $('#check_changeStatusNum').text(data.total_not_sent);
                               }else{
                                $('.if_proposal_status_change').hide();
                                $('#check_changeStatusNum').text(data.total_not_sent);
                               }
                               
                                
                  
                  // $('.is_templateSelect_disable').css('display','block');
                   if(data.email_cc==1){
                        $( "#emailCC" ).prop( "checked", true );
                        
                        $.uniform.update();
                   }else{
                        $( "#emailCC" ).prop( "checked", false );
                       
                        $.uniform.update();
                   }
                   

                   if(data.custom_sendor==1){
                        $( "#emailCustom-new" ).prop( "checked", true );
                        
                        $.uniform.update();
                        
                        $('#messageFromName-new').val(data.custom_sendor_name);
                        $('#messageFromEmail-new').val(data.custom_sendor_email);
                   }else{
                        $( "#emailCustom-new" ).prop( "checked", false );
                        
                        $.uniform.update();
                        $('#messageFromName-new').val('');
                        $('#messageFromEmail-new').val('');
                   }
                   $( "#emailCustom-new" ).trigger('change');
                  
                    console.log(data.email_content)
                  
                   tinymce.activeEditor.setContent(data.email_content);
                   return false;
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

        $("#sendExcludedEmail").click(function () {
            var include_count =0;
            if($('#sendExcludedEmail').prop("checked")){
                $("#resendIncludeNum").html($('#check_total_opened').val());
                $(".preconfirm-resend-btn").prop('disabled',false);
                $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
            }else{
                var check_value = ($('#check_total_resending').val() - $('#resendExcludeNum-new').html());
                $("#resendIncludeNum").html(check_value);
                console.log(check_value);
                if(check_value==0){
                    $(".preconfirm-resend-btn").prop('disabled',true);
                    $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                }
            }
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
                        url: '/ajax/delete_campaign/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                        },

                        success: function (data) {
                            if (data.success) {
                                pcsTable.ajax.reload();
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
    if(localStorage.getItem("prc_last_active_row")){
        var row_num =localStorage.getItem("prc_last_active_row");
        $('.estimatePricingTable tbody').find("[data-campaign-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}


});

$(document).on('click', '.estimatePricingTable tbody td a, .estimatePricingTable tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-campaign-id');
    if(hasLocalStorage){
        localStorage.setItem("prc_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("prc_last_active_row", '');
    }
});


 // Proposal Resend options
 $("#emailCustom-new").change(function () {
        if ($("#emailCustom-new").attr('checked')) {
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
          
                $(".groupActionsContainerResend").hide();

       
        }
       
   });

   $('.reload_table').click( function(event) {
    var activeTabIdx = $('#proposal_resend_tabs').tabs('option','active');
        if(activeTabIdx == 0){
            pcsTable.ajax.reload(null, false);
        }else{
            oTable.ajax.reload(null, false);
        }
        
       
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
                        url: '/ajax/update_proposal_resend_name',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resendId": resendId,
                            "resendName":result
                        },

                        success: function (data) {
                            if (!data.error) {
                                console.log(data)
                                swal('Campaign Name Updated')
                                pcsTable.ajax.reload(null, false);
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
    $('#templateSelect').change(function () {

        var selectedTemplate = $('#templateSelect option:selected').data('template-id');

        loadTemplateContents(selectedTemplate);
    });

    function loadTemplateContents(templateId) {

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'templateId': templateId},
            url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
            .success(function (data) {
                $("#messageSubject-new").val(data.templateSubject);
                //CKEDITOR.instances.message.setData(data.templateBody);
                tinymce.get('message').setContent(data.templateBody);
                // var select_html = '<option value="0">- Select Field</option>';
                //  for($i=0;$i<data.typeFields.length;$i++) {
                //     select_html +='<option value=""></option>
            });

        $.uniform.update();
}

$(document).on('click', ".campaign_stats", function () {
            var resend_id = $(this).data('val');
            $.ajax({
                        url: '/ajax/get_campaign_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                        },

                success: function (data) {
                    if (data.success) {
                          
                    var campaign_name = data.resend_name;
                    var sent_time = data.created_at;
                    var sent = data.resendStats.sent;
                    var bounced = data.resendStats.bounced;
                    var clicked = data.resendStats.clicked;
                    var delivered = data.resendStats.delivered;
                    var opened = data.resendStats.opened;
                    var unopened = data.resendStats.unopened;
                    var note_added = data.resendStats.note_added; 
                    var opened_p = (sent>0)?Math.round((opened/sent)*100):'0';
                    var clicked_p = (sent>0)?Math.round((clicked/sent)*100):'0';

                    var status_stats = data.status_stats;
                    var stats_table ='';
                    var hide_class = 'hide';
                    var not_hide_class = '';
                    var notes_added_btn = '0 Proposals';
                    for($i=0;$i<status_stats.length;$i++){
                        var p_total = (status_stats[$i].p_total)?addCommas(Math.round(status_stats[$i].p_total)):'0';
                        var click_link = '/proposals/resend/'+resend_id+'/'+status_stats[$i].campaign_status_id+'/'+status_stats[$i].proposal_status_id;
                        stats_table +='<tr><td style="text-align:left;padding-left: 10px;">'+status_stats[$i].campaign_status+'</td><td style="text-align:left;padding-left: 10px;">'+status_stats[$i].proposal_status+'</td><td><a href="'+click_link+'">'+status_stats[$i].p_count+'</a></td><td style="text-align:right;padding-right: 10px;"><a href="'+click_link+'">$'+p_total+'</a></td></tr>';
                    }
                    if(status_stats.length>0){
                        hide_class = '';
                        not_hide_class = 'hide';
                    }
                    if(note_added>0){
                        notes_added_btn = '<a href="/proposals/resend/'+resend_id+'/notes_added">'+note_added+' Proposals</a>';
                    }
                    
                    swal({
                    title: "",
                    html:   '<table class="boxed-table pl-striped camp_st_tb1" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                                '<tr class="dark_header_tr"><td style="width:50%"><p style="text-align:left;font-weight:bold">Campaign Stats</p></td><td style="width:50%"><p style="margin-top:1px;text-align: right;float: right;">'+sent_time+'</p><label  style="float: right;text-align: left;width: 50px;">Sent:</label></td></tr>'+
                                '<tr class="odd"><td colspan="2" style="width:50%" class="brb_wh"><label  style="padding-right: 10px;width: 130px;"> Name: </label><p style="margin-top:1px;text-align:left">'+campaign_name+'</p></td></tr>'+
                                '<tr><td style="width:60%" class="brb_wh"><label  style="padding-right: 10px;width: 130px;"> Email Sent: </label><p style="margin-top:3px;text-align:left">'+sent+'</p></td><td style="width:50%" class="brb_wh"><label  style="width: 130px;padding-right: 10px;">Email Delivered: </label><p style="margin-top:1px;text-align:left">'+delivered+'</p></td></tr>'+
                                '<tr class="odd"><td style="width:60%" class="brb_wh"><label  style="padding-right: 10px;width: 130px;"> Email Opened: </label><p style="margin-top:1px;text-align:left">'+opened+' ['+opened_p+'%]</p></td><td style="text-align: left;width:40%" class="brb_wh"><label  style="padding-right: 10px;width: 130px;">Email Clicked: </label><p style="margin-top:1px;text-align:left">'+clicked+' ['+clicked_p+'%]</p></td></tr>'+
                                '<tr><td style="width:60%"  class="brb_wh"><label  style="width: 130px;padding-right: 10px;"> Unopened: </label><p style="margin-top:1px;text-align:left">'+unopened+'</p></td><td style="text-align: left;width:40%" class="brb_wh"><label  style="width: 130px;padding-right: 10px;">Bounced: </label><p style="margin-top:1px;text-align:left">'+bounced+'</p></td></tr>'+
                                '<tr class="odd"><td colspan="2" style="width:65%" ><label  style="width: 130px;padding-right: 10px;"> Notes Added To: </label><p style="margin-top:1px;text-align:left">'+notes_added_btn+' </p></td></tr>'+
                            '</table>'+
                            '<p  style="padding: 7px 0px;margin-top:15px;width: 100%;"><span style="width: 135px;font-size: 16px;font-weight: bold;">Status Changes</span> <span class="'+not_hide_class+'" style="margin-left:10px;font-size: 16px;">None</span></p>'+
                            '<table class="display '+hide_class+'" style="font-size: 15px;border-collapse: collapse!important;width: 100%; float: left" id="status_breakdown_table">'+
                                '<thead><tr><th>From</th><th>To</th><th>#</th><th>$</th></tr></thead>'+stats_table+
                                
                            '</table>',

                        showCancelButton: false,
                        confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                        cancelButtonText: "Cancel",
                        dangerMode: false,
                        width:700,
                        showCloseButton: true,
                        onOpen:  function() {
                            initTiptip(); 
                            $('.swal2-modal').attr('id','campaign_stats_popup');
                            $('#status_breakdown_table').DataTable({
            
                            "searching":false,
                            "lengthChange":false,
                            "paging":false,
                            "info":false,
                            
                            "sorting": [
                                [2, "desc"]
                            ],
                            "jQueryUI": true,
                            "autoWidth": true,
                            "stateSave": false,
                            "paginationType": "full_numbers",
                            "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                            
                        });
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
</script>