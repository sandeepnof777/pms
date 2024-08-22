<style type="text/css">
div.sticky {
        position: -webkit-sticky;
        position: sticky;
        background-color: #DCDCDC;
        top: 0px;
        z-index: 99;
    }

    #newFilterContainer {
        position: relative;
    }

    .close_column{
        position: absolute;
            top: 5px;
            right: 10px;
            transition: all 200ms;
            font-size: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #333!important;
    }
    #newProposalFilterButton, #newResetProposalFilterButton {
        display: inline-block;
        float: left;
        margin-right: 10px;
    }

    #newResetProposalFilterButton {
        display: none;
    }

    #newResetProposalFilterButton2 {
        display: none;
        color: #505050;
        cursor: pointer;
    }

    #newFilterContainer h3 {
        margin: 5px 0;
        width: 33%;
        float: left;
    }

    #filterInfo {
        
        padding-top: 10px;
        text-align: center;
        font-size: 1.25em;
        margin-bottom: 10px;
    }

    /* #filterInfo #filterResults {
        display: none;
    } */

    #filterNumResults {
        font-weight: bold;
    }

    #filterControls {
        width: 20px;
        float: right;
        padding-top: 5px;
        text-align: right;
    }
    
    .checkbox-inline, .radio-inline {
    position: relative;
    display: inline-block;
    padding-left: 20px;
    margin-bottom: 3px;
    font-weight: 400;
    vertical-align: middle;
    cursor: pointer;
    width:12.5%
}

    #newProposalColumnFilters {
        position: absolute;
        top: -136px;
        left: 0;
        background-color: #ebedea;
        width: 940px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        padding: 0 5px 10px 5px;
        z-index: 100;
        display: none;
        border-radius: 5px;
        margin-top: 1px;
    }

    #newProposalFilters {
        position: absolute;
        top: -5px;
        left: 0;
        background-color: #ebedea;
        width: 940px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        padding: 0 5px 10px 5px;
        z-index: 101;
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
        padding-top: 0px;
        height: 300px;
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
    .filterColumnRow .filterChecker {
        margin: 0px 5px;
        vertical-align: text-top;
    }
    #filterBadges {
        float: left;
    }

    .filterBadge {
        float: left;
        border-radius: 3px;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 3px;
        font-size: 11px;
        margin-top: 5px;
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
    #uniform-createdPreset,#uniform-activityPreset,#uniform-wonPreset{
    margin-left: 1px;
    }
    .dropdownButton.currentActive {
        z-index: 100;
    }
    .dropdownToggle.open {
        background-color:transparent;
        background:none;
    }
    #uniform-olderThenType{
        width: 130px!important;
    }
    #uniform-olderThenType span{
        width: 105px!important;
    }
    #uniform-newerThenType{
        width: 130px!important;
    }
    #uniform-newerThenType span{
        width: 105px!important;
    }
    #uniform-saves_filter_list{
        position: absolute;
        left: 5px;
        top: 5px;
    }
    
</style>
<?php if(count($resends)>0){
                $display='block';
            }else{
                $display='none';
            }
            ?>

<div id="proposalsTopContent" style="position: relative;">

    <div class="materialize">

    <div style="width: 70%;float:left">

    
    
       <?php //if($this->uri->segment(2)!='resend'){?>
            <a class="m-btn grey tiptip" title="Filter your proposals" id="newProposalFilterButton"><i
                        class="fa fa-fw fa-filter"></i> Filters</a>
            <a class="m-btn grey tiptip" title="Reset All Filters" id="newResetProposalFilterButton"><i
                        class="fa fa-fw fa-refresh"></i></a>
       <?php //} ?>
        <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
             id="groupActionsButton" style="display:none">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="materialize groupActionsContainer" style="width:600px">
                <div class="collection groupActionItems" style="width:298px; float:left">
                    <a href="#" id="groupResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-envelope"></i> Send Proposals
                    </a>
                    <a href="#" id="groupDelete" class="collection-item iconLink">
                        <i class="fa fa-fw fa-trash"></i> Delete Proposals
                    </a>
                    <a href="#" id="groupHideProposal" class="collection-item iconLink">
                        <i class="fa fa-fw fa-eye-slash"></i> Hide Proposals
                    </a>
                    <a href="#" id="groupShowProposal" class="collection-item iconLink">
                        <i class="fa fa-fw fa-eye"></i> Show Proposals
                    </a>
                    <a href="#" id="groupChangeStatus" class="collection-item iconLink">
                        <i class="fa fa-fw fa-external-link-square"></i> Change Status
                    </a>
                    <a href="#" id="groupUnduplicate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-external-link"></i> Set as Standalone
                    </a>
                    <a href="#" id="groupChangeBusinessType" class="collection-item iconLink">
                        <i class="fa fa-fw fa-briefcase"></i> Change Business Type
                    </a>
                    <a href="#" id="groupExcludeResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-envelope-open-o"></i> Email Off
                    </a>
                    <a href="#" id="groupIncludeResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-envelope-open-o"></i> Email On
                    </a>
                    <a href="#" id="groupEnableResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-clock-o"></i> Enable Auto Resend
                    </a>
                    <a href="#" id="groupDisableResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-ban" style="color: #555;"></i> Disable Auto Resend
                    </a>

                </div>
                <div class="collection groupActionItems" style="width:298px; float:left">
                    <a href="#" id="groupProposalExport" class="collection-item iconLink">
                        <i class="fa fa-fw fa-cloud-download"></i> Export Proposals
                    </a>
                    <a href="#" id="groupCopySameClient" class="collection-item iconLink">
                        <i class="fa fa-fw fa-copy"></i> Copy Proposals - Same Contact
                    </a>
                    <a href="#" id="groupChangeDate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Change Proposal Date
                    </a>
                    <a href="#" id="groupChangeWinDate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Change Proposal Win Date
                    </a>
                    <a href="#" id="groupStatusChangeDate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar-o"></i> Update Status Change Date
                    </a>
                    <?php if ($account->getUserClass() > 2) { ?>
                        <a href="#" id="groupReassign" class="collection-item iconLink">
                            <i class="fa fa-fw fa-random"></i> Reassign Proposals
                        </a>
                    <?php } ?>
                    <?php if ($automatic_reminders_enabled) { ?>
                        <a href="#" id="groupResend" class="collection-item iconLink">
                            <i class="fa fa-fw fa-clock-o"></i> Auto-Resend Settings
                        </a>
                    <?php } ?>
                    <?php if ($account->isAdministrator()) { 
                        
                        //if (0) { ?>
                        
                   <?php echo $checkActiveModify == 0 ? '<a href="" class="collection-item iconLink modify-price-swal" style="opacity:0.8"><i class="fa fa-fw fa-usd"></i>Modify Price</a>':'<a href="#" id="groupPriceModify" class="collection-item iconLink"><i class="fa fa-fw fa-usd"></i>Modify Price</a>';?>

                        <?php } ?>
                    <a href="#" id="groupProposalSignature" class="collection-item iconLink">
                            <i class="fa fa-fw fa-pencil"></i> Add Signature
                        </a>

                </div>
            </div>
        </div>
        
            <div id="filterBadges"></div>
        </div>
        <div class="Proposal_left_actions" style="width: 30%;float:right">
        <?php
           

            
            if($this->uri->segment(2)=='status'){
                $pCreatedFrom = $this->session->userdata('pstsCreatedFrom');
                $pCreatedTo = $this->session->userdata('pstsCreatedTo');
                $pActivityFrom = $this->session->userdata('pstsActivityFrom');
                $pActivityTo = $this->session->userdata('pstsActivityTo');
                $pWonFrom = $this->session->userdata('pstsWonFrom');
                $pWonTo = $this->session->userdata('pstsWonTo');
                $filterStatuses = $this->session->userdata('pstsFilterStatus') ?: [];
                $filterAccounts = $this->session->userdata('pstsFilterClientAccount') ?: [];
                $filterUsers = $this->session->userdata('pstsFilterUser') ?: [];
                $filterBranches = $this->session->userdata('pstsFilterBranch') ?: [];
                $filterServices = $this->session->userdata('pstsFilterService') ?: [];
                $filterQueue = $this->session->userdata('pstsFilterQueue') ?: [];
                $filterEmail = $this->session->userdata('pstsFilterEmailStatus') ?: [];
                $estimateFilterStatuses = $this->session->userdata('pstsEstimateFilterStatus') ?: [];
                $filterMinBid = $this->session->userdata('pstsFilterMinBid');
                $filterMaxBid = $this->session->userdata('pstsFilterMaxBid');
                $filterBusinessTypes = $this->session->userdata('pstsFilterBusinessType') ?: [];
                $filterResendInclude = $this->session->userdata('pstsResendInclude');
                $filterResendExclude = $this->session->userdata('pstsResendExclude');
                $filterSigned = $this->session->userdata('pstsSigned');
                $filterUnsigned = $this->session->userdata('pstsUnsigned');
                $filterCompanySigned = $this->session->userdata('pstsCompanySigned');
                $filterCompanyUnsigned = $this->session->userdata('pstsCompanyUnsigned');
            }else if($this->uri->segment(2)=='stats'){
                $pCreatedFrom = $this->session->userdata('psttCreatedFrom');
                $pCreatedTo = $this->session->userdata('psttCreatedTo');
                $pActivityFrom = $this->session->userdata('psttActivityFrom');
                $pActivityTo = $this->session->userdata('psttActivityTo');
                $pWonFrom = $this->session->userdata('psttWonFrom');
                $pWonTo = $this->session->userdata('psttWonTo');
                $filterStatuses = $this->session->userdata('psttFilterStatus') ?: [];
                $filterAccounts = $this->session->userdata('psttFilterClientAccount') ?: [];
                $filterUsers = $this->session->userdata('psttFilterUser') ?: [];
                $filterBranches = $this->session->userdata('psttFilterBranch') ?: [];
                $filterServices = $this->session->userdata('psttFilterService') ?: [];
                $filterQueue = $this->session->userdata('psttFilterQueue') ?: [];
                $filterEmail = $this->session->userdata('psttFilterEmailStatus') ?: [];
                $estimateFilterStatuses = $this->session->userdata('psttEstimateFilterStatus') ?: [];
                $filterMinBid = $this->session->userdata('psttFilterMinBid');
                $filterMaxBid = $this->session->userdata('psttFilterMaxBid');
                $filterBusinessTypes = $this->session->userdata('psttFilterBusinessType') ?: [];
                $filterResendInclude = $this->session->userdata('psttResendInclude');
                $filterResendExclude = $this->session->userdata('psttResendExclude');
                $filterSigned = $this->session->userdata('psttSigned');
                $filterUnsigned = $this->session->userdata('psttUnsigned');
                $filterCompanySigned = $this->session->userdata('psttCompanySigned');
                $filterCompanyUnsigned = $this->session->userdata('psttCompanyUnsigned');
            }else if($this->uri->segment(2)=='account_stats'){
               //print_r($this->session->userdata('pastFilterUser'));die;
                $pCreatedFrom = $this->session->userdata('pastCreatedFrom');
                $pCreatedTo = $this->session->userdata('pastCreatedTo');
                $pActivityFrom = $this->session->userdata('pastActivityFrom');
                $pActivityTo = $this->session->userdata('pastActivityTo');
                $pWonFrom = $this->session->userdata('pastWonFrom');
                $pWonTo = $this->session->userdata('pastWonTo');
                $filterStatuses = $this->session->userdata('pastFilterStatus') ?: [];
                $filterAccounts = $this->session->userdata('pastFilterClientAccount') ?: [];
                $filterUsers = $this->session->userdata('pastFilterUser') ?: [];
                $filterBranches = $this->session->userdata('pastFilterBranch') ?: [];
                $filterServices = $this->session->userdata('pastFilterService') ?: [];
                $filterQueue = $this->session->userdata('pastFilterQueue') ?: [];
                $filterEmail = $this->session->userdata('pastFilterEmailStatus') ?: [];
                $estimateFilterStatuses = $this->session->userdata('pastEstimateFilterStatus') ?: [];
                $filterMinBid = $this->session->userdata('pastFilterMinBid') ;
                $filterMaxBid = $this->session->userdata('pastFilterMaxBid') ;
                $filterBusinessTypes = $this->session->userdata('pastFilterBusinessType') ?: [];
                $filterResendInclude = $this->session->userdata('pastResendInclude');
                $filterResendExclude = $this->session->userdata('pastResendExclude');
                $filterSigned = $this->session->userdata('pastSigned');
                $filterUnsigned = $this->session->userdata('pastUnsigned');
                $filterCompanySigned = $this->session->userdata('pastCompanySigned');
                $filterCompanyUnsigned = $this->session->userdata('pastCompanyUnsigned');
           }else{
                $pCreatedFrom = $this->session->userdata('pCreatedFrom');
                $pCreatedTo = $this->session->userdata('pCreatedTo');
                $pActivityFrom = $this->session->userdata('pActivityFrom');
                $pActivityTo = $this->session->userdata('pActivityTo');
                $pWonFrom = $this->session->userdata('pWonFrom');
                $pWonTo = $this->session->userdata('pWonTo');
                $filterStatuses = $this->session->userdata('pFilterStatus') ?: [];
                $filterAccounts = $this->session->userdata('pFilterClientAccount') ?: [];
                $filterUsers = $this->session->userdata('pFilterUser') ?: [];
                $filterBranches = $this->session->userdata('pFilterBranch') ?: [];
                $filterServices = $this->session->userdata('pFilterService') ?: [];
                $filterQueue = $this->session->userdata('pFilterQueue') ?: [];
                $filterEmail = $this->session->userdata('pFilterEmailStatus') ?: [];
                $estimateFilterStatuses = $this->session->userdata('pEstimateFilterStatus') ?: [];
                $filterMinBid = $this->session->userdata('pFilterMinBid') ;
                $filterMaxBid = $this->session->userdata('pFilterMaxBid') ;
                $filterBusinessTypes = $this->session->userdata('pFilterBusinessType') ?: [];
                $filterResendInclude = $this->session->userdata('pResendInclude');
                $filterResendExclude = $this->session->userdata('pResendExclude');
                $filterSigned = $this->session->userdata('pSigned');
                $filterUnsigned = $this->session->userdata('pUnsigned');
                $filterCompanySigned = $this->session->userdata('pCompanySigned');
                $filterCompanyUnsigned = $this->session->userdata('pCompanyUnsigned');
           }
            
       ?>
           <div class="dropdownButton" style="float:right;margin-left: 5px;margin-bottom: 5px;">
                    <a class="dropdownToggle m-btn grey" style="background:none;margin-right:0px" href="JavaScript:void('0');" ><i class="fa fa-cog"></i> <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdownMenuContainer openAbove" style="display: none;width: 180px; left:-112px">
                        
                        <ul class="dropdownMenu" style="width: 180px">
                            <li>
                            
                            <a  style="padding-left:10px;" href="JavaScript:void('0');" id="tableColumnFilterButton"><i
                                    class="fa fa-fw fa-table"></i> Column Filters</a>
                            </li>
                            <li>
                                <a href="JavaScript:void('0');" id="proposalMapLink" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-map" ></i> Map
                                </a>
                            </li>
                            <li>
                                <a href="JavaScript:void('0');" id="exportFilteredProposals" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-cloud-download" ></i> Export Proposals
                                </a>
                            </li>
                            <li style="display: <?=$display;?>;">
                                <a href="<?=site_url('account/group_resends');?>"  style="padding-left:10px;">
                                <i class="fa fa-fw fa-envelope"></i> Campaigns [<?=count($resends);?>]
                                </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
                <?php if($checkActiveCampaigns==1){ ?>
       <a href="<?=site_url('account/group_resends');?>" class="m-btn grey tiptip " style="display: <?=$display;?>;float:right;margin-left:5px;padding:0px 5px" title="Campaigns "><i class="fa fa-fw fa-envelope"></i> <span class="campaign_count_btn"><?=count($resends);?></span></a>
       <?php }  else{?>
        <a href=""  class="m-btn grey tiptip sales-targets-li campaigns" style="opacity:0.8; display: <?=$display;?>;float:right;margin-left:5px;padding:0px 5px" title="Campaigns "><i class="fa fa-fw fa-envelope"></i> <span class="campaign_count_btn"><?=count($resends);?></span></a>

        <?php } ?>
        
        <a href="JavaScript:void('0');" class="m-btn blue-button right add_proposal_btn" ><i class="fa fa-fw fa-plus"></i>
                Add Proposal</a>
        
                <div class="clearfix"></div>
        </div>
    </div>


    <div id="newFilterContainer">

        <div id="newProposalFilters">
        <?php if($this->uri->segment(2) ==''){ ?>

            <select name="saves_filter_list" style="float:left;border-radius: 3px;padding: 0.1em;"  id="saves_filter_list">
                <option value="">- Saved Filters</option>
                <optgroup label="Defaults">
                    <option value="1" data-default-filter="1" data-preset-range="previousYear" data-preset-status="1">Open - Previous Year</option>
                    <option value="2" data-default-filter="1" data-preset-range="yearToDate" data-preset-status="1">Open - This Year</option>
                    <option value="3" data-default-filter="1" data-preset-range="previousYear" data-preset-status="2">Won - Previous Year</option>
                    <option value="4" data-default-filter="1" data-preset-range="yearToDate" data-preset-status="2">Won - This Year</option>
                    <option value="5" data-default-filter="1" data-preset-range="yearToDate" data-preset-status="3">Completed - This Year</option>
                </optgroup>
                <?php if(count($save_filters)>0){?>
                <optgroup id="saved_filters_lable" label="Saved Filters">
                    <?php
                    foreach($save_filters as $saved_filter){
                        echo "<option  data-default-filter='0' data-filter='".$saved_filter->filter_data."' value='".$saved_filter->id."'>".$saved_filter->filter_name."</option>";
                    }
                    ?>
                </optgroup>
                <?php }?>
            </select>
            <a href="#" class="btn ui-button tiptip" title="Save Filter" id="saveFilter" style="position: absolute;left: 203px;font-size: 10.7px;padding: 0px 4px;top: 7px;"><i class="fa fw fa-floppy-o"></i></a>
        <?php } ?>
            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif" style="position: absolute;left: 235px;top: 11px;">
                <p id="filterResults">
                    
                    <span id="filterNumResults"></span> proposals found

                    <a class="btn ui-button tiptip" title="Reset All Filters" style="position: absolute;display: inline;font-size: 13px;top: 4px;right: 245px;" id="newResetProposalFilterButton2"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                    
                    <a href="#" class="btn ui-button update-button" id="closeProposalFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
            </div>

            <div class="clearfix"></div>

            <div class="materialize" id="proposalFilterPresets">

                <a class="m-btn grey proposalFilterPreset" id="openLastYear"
                   data-preset-range="previousYear" data-preset-status="1">Open - Previous Year</a>

                <a class="m-btn grey proposalFilterPreset" id="openThisYear"
                   data-preset-range="yearToDate" data-preset-status="1">Open - This Year</a>

                <a class="m-btn grey proposalFilterPreset" id="wonLastYear"
                   data-preset-range="previousYear" data-preset-status="2">Won - Previous Year</a>

                <a class="m-btn grey proposalFilterPreset" id="wonThisYear"
                   data-preset-range="yearToDate" data-preset-status="2">Won - This Year</a>

                <a class="m-btn grey proposalFilterPreset" id="completeThisYear"
                   data-preset-range="yearToDate" data-preset-status="3">Completed - This Year</a>

                <hr/>
                
            </div>

            <div id="topFilterRow">

                <div class="filterColumnWide filterCollapse">
                    <div class="filterColumnRow">
                        <div class="filterColumnHeader containsCalendar" id="createdFilterHeader">
                            <i class="fa fa-fw fa-calendar"></i>&nbsp;Created: <span class="headerText"
                                    id="createdHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <div style="float: left;margin-bottom: 10px;display:none"><span style="float: left;width:140px"><input type="radio" name="created_tabs" class="created_tabs" value="created" id="show_created_tab" checked="checked" style="margin:0px" > Specific Dates</span><span style="float: left;width:140px"> <input type="radio" value="older_then" name="created_tabs" id="show_older_then_tab" class="created_tabs" style="margin:0px"> Variable Range</span></div>
                            <div id="created_inputs_tab">
                                <p>
                                    <label>From:</label>
                                    <input type="text" id="pCreatedFrom" class="text" style="margin-left: 11px;"
                                        value="<?php echo ($pCreatedFrom) ? date('m/d/Y', $pCreatedFrom) : '' ?>">
                                    <label>To:</label>
                                    <input type="text" class="text" id="pCreatedTo"
                                        value="<?php echo ($pCreatedTo) ? date('m/d/Y', $pCreatedTo) : '' ?>">
                                    <a class="filterDateClear" id="resetCreatedDate">Reset</a>
                                </p>
                                <p style="padding-top: 5px;">
                                    <label>Preset:</label>
                                    <select id="createdPreset" style="margin-left: 4px;">
                                        <option value="">Choose Preset</option>
                                        <option value="custom">Custom</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="last7days">Last 7 Days</option>
                                        <option value="monthToDate">Month To Date</option>
                                        <option value="previousMonth">Previous Month</option>
                                        <option value="yearToDate">Year To Date</option>
                                        <option value="previousYear">Previous Year</option>
                                    </select>
                                </p>
                            </div>
                            <div style="display: none;" id="older_then_inputs_tab">
                            <div>
                            <label style="width: 75px;float: left;margin-top: 5px;">Older Than:</label>
                                <input type="text" id="older_then_value" class="text older_newer_then" style="width:50px" value="">
                                <input type="hidden" id="older_then_date" value="">
                                <select id="olderThenType" class="older_newer_then_type" style="margin-left: 4px;">
                                    
                                    <option value="days">Days</option>
                                    <option value="week">Weeks</option>
                                    <option value="month" selected="selected">Months</option>
                                    <option value="year">Years</option>
                                </select>
                            </div>
                            <div>
                            <label style="width: 75px;float: left;margin-top: 5px;">Newer Than:</label>
                                <input type="text" id="newer_then_value" class="text older_newer_then" style="width:50px" value="">
                                <input type="hidden" id="newer_then_date" value="">
                                <select id="newerThenType" class="older_newer_then_type" style="margin-left: 4px;">
                                   
                                    <option value="days">Days</option>
                                    <option value="week">Weeks</option>
                                    <option value="month" selected="selected">Months</option>
                                    <option value="year">Years</option>
                                </select>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filterColumnWide filterCollapse">
                    <div class="filterColumnRow">

                        <div class="filterColumnHeader containsCalendar" id="activityFilterHeader">
                            <i class="fa fa-fw fa-calendar"></i>&nbsp;Last Activity: <span class="headerText"
                                    id="activityHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p>
                                <label>From:</label>
                                <input type="text" class="text" id="pActivityFrom" style="margin-left: 11px;"
                                       value="<?php echo ($pActivityFrom) ? date('m/d/Y', $pActivityFrom) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pActivityTo"
                                       value="<?php echo ($pActivityTo) ? date('m/d/Y', $pActivityTo) : '' ?>">
                                <a class="filterDateClear" id="resetActivityDate">Reset</a>
                            </p>
                            <p style="padding-top: 5px;">
                                <label>Preset:</label>
                                <select id="activityPreset" style="margin-left: 4px;">
                                    <option value="">Choose Preset</option>
                                    <option value="custom">Custom</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last7days">Last 7 Days</option>
                                    <option value="monthToDate">Month To Date</option>
                                    <option value="previousMonth">Previous Month</option>
                                    <option value="yearToDate">Year To Date</option>
                                    <option value="previousYear">Previous Year</option>
                                </select>
                            </p>
                        </div>

                    </div>
                </div>

                <!-- new filter for won date-->
                <div class="filterColumnWide filterCollapse">
                    <div class="filterColumnRow">

                        <div class="filterColumnHeader containsCalendar" id="wonFilterHeader">
                            <i class="fa fa-fw fa-calendar"></i>&nbsp;Sold: <span class="headerText"
                                    id="wonHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p>
                                <label>From:</label>
                                <input type="text" class="text" id="pWonFrom" style="margin-left: 11px;"
                                       value="<?php echo ($pWonFrom) ? date('m/d/Y', $pWonFrom) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pWonTo"
                                       value="<?php echo ($pWonTo) ? date('m/d/Y', $pWonTo) : '' ?>">
                                <a class="filterDateClear" id="resetWonDate">Reset</a>
                            </p>
                            <p style="padding-top: 5px;">
                                <label>Preset:</label>
                                <select id="wonPreset" style="margin-left: 4px;">
                                    <option value="">Choose Preset</option>
                                    <option value="custom">Custom</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last7days">Last 7 Days</option>
                                    <option value="monthToDate">Month To Date</option>
                                    <option value="previousMonth">Previous Month</option>
                                    <option value="yearToDate">Year To Date</option>
                                    <option value="previousYear">Previous Year</option>
                                </select>
                            </p>
                        </div>

                    </div>
                </div>
                 <!--End new filter for won date-->
                
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>

            <div class="filterRow">

                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="statusFilterHeader">
                        <i class="fa fa-fw fa-align-left"></i>&nbsp;Status: <span  class="headerText"
                                id="statusHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allStatuses = false;
                    

                    if (!count($filterStatuses) || (count($filterStatuses) == count($statusCollection))) {
                        $allStatuses = true;
                    }
                    ?>

<div class="filterColumnScroll">
                <div class="filterColumnRow sticky">
                    <input type="checkbox" id="statusFilterColumnCheck" class="filterColumnCheck filterChecker" data-affected-class="statusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>> 
                    <strong>All</strong><hr />
                </div>
                <div class="filterColumnRow">
                    
                </div>
            <?php foreach ($statusCollection as $status) { ?>
                <div class="filterColumnRow" >
                    <input type="checkbox" class="filterCheck filterChecker statusFilterCheck"<?php echo ($allStatuses || in_array($status->getStatusId(), $filterStatuses)) ? ' checked' : ''; ?> value="<?php echo $status->getStatusId(); ?>" data-text-value="<?php echo $status->getText(); ?>" />
                    <?php echo $status->getText(); ?>
                </div>
                <?php 
                if($status->getStatusId()==2){

                    foreach ($status->WonChilds as $nStatus) { ?>
                        <div class="filterColumnRow" style="margin-left: 10px;">
                            <input type="checkbox" class="filterCheck filterChecker statusFilterCheck wonStatusCheck"<?php echo ($allStatuses || in_array($nStatus->getStatusId(), $filterStatuses)) ? ' checked' : ''; ?> value="<?php echo $nStatus->getStatusId(); ?>" data-text-value="<?php echo $nStatus->getText(); ?>" />
                            <?php echo $nStatus->getText(); ?>
                        </div>
                        <?php 
                    }
                }

                ?>
            <?php } ?>
            <?php if (count($prospectStatusCollection)) { ?>
                <div class="filterColumnRow">
                    <p style="margin-top: 20px;"><strong>Prospect Statuses</strong></p>
                </div>
                <div class="filterColumnRow">
                    <hr />
                </div>
                <?php foreach ($prospectStatusCollection as $prospectStatus) { ?>
                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterCheck filterChecker statusFilterCheck prospectStatusFilterCheck"<?php echo (in_array($prospectStatus->getStatusId(), $filterStatuses)) ? ' checked' : ''; ?> value="<?php echo $prospectStatus->getStatusId(); ?>" data-text-value="<?php echo $prospectStatus->getText(); ?>" />
                        <?php echo $prospectStatus->getText(); ?>
                    </div>
                <?php } ?>
            <?php } ?>
            </div>

                </div>

                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="userFilterHeader">
                        <i class="fa fa-fw fa-user"></i>&nbsp;User: <span class="headerText"
                                id="userHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allUsers = false;
                    

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    

                    ?>

                    <div class="filterColumnScroll">

                        <div class="filterColumnRow sticky">
                            <input type="checkbox" class="filterColumnCheck filterChecker" id="allUsersCheck"
                                   data-affected-class="userFilterCheck"<?php echo $allUsers ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                            <hr/>
                        </div>
                        <div class="filterColumnRow">
                            
                        </div>
                        <?php
                        if (($account->hasFullAccess() || $account->isBranchAdmin()) && count($branches) > 0) {
                            if ($account->hasFullAccess() || ($account->isBranchAdmin() && $account->getBranch() < 1)) {
                                ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck filterChecker userFilterCheck branchFilterCheck"
                                           data-affected-class="userFilterCheck"
                                           data-branch-id="0"<?php echo $allUsers || (in_array(0, $filterBranches)) ? ' checked' : ''; ?>
                                    > <strong>Main Branch</strong>
                                </div>
                            <?php } ?>
                            <?php foreach ($branches as $branch) { ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck filterChecker userFilterCheck branchFilterCheck"
                                           data-affected-class="userFilterCheck"
                                           data-branch-id="<?php echo $branch->getBranchId() ?>"<?php echo ($allUsers || in_array($branch->getBranchId(), $filterBranches)) ? ' checked' : ''; ?>>
                                    <strong><?php echo $branch->getBranchName(); ?> Branch</strong>
                                </div>
                            <?php } ?>
                            <div class="filterColumnRow">
                                <hr/>
                            </div>
                            <?php
                        }
                        ?>

                        <?php foreach ($accounts as $acc) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox"
                                       class="filterCheck filterChecker userFilterCheck"<?php echo ($allUsers || in_array($acc->getAccountId(), $filterUsers)) ? ' checked' : ''; ?>
                                       value="<?php echo $acc->getAccountId(); ?>"
                                       data-text-value="<?php echo $acc->getFullName(); ?>"
                                       data-branch-id="<?php echo $acc->getBranch(); ?>"/>
                                <?php echo $acc->getFullName(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="accountFilterHeader">
                        <i class="fa fa-fw fa-building-o"></i> Account: <span  class="headerText"
                           id="accountHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <div class="filterSearchBar">
                        <input class="text filterSearch" type="text" placeholder="Search Accounts" id="accountSearch"/>
                        <a class="filterSearchClear">&times;</a>
                    </div>

                    <?php
                    $allAccounts = false;
                    

                    if (!count($filteredClientAccounts)) {
                        $allAccounts = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="accountsFilterColumn">

                        <div class="filterColumnRow sticky"  style="z-index:100;" id="accountRowAll">
                            <input type="checkbox" id="allClientAccounts" class="filterColumnCheck filterChecker"
                                   data-affected-class="clientAccountFilterCheck"<?php echo $allAccounts ? ' checked="checked"' : '' ?>>
                            <strong>All Accounts</strong>
                            <hr/>
                        </div>
                        <?php foreach ($filteredClientAccounts as $clientAccount) { ?>
                            <div class="filterColumnRow searchSelectedRow">
                                <input type="checkbox" class="filterCheck filterChecker clientAccountFilterCheck searchSelected"
                                       checked="checked" value="<?php echo $clientAccount->getId(); ?>"
                                       data-text-value="<?php echo $clientAccount->getName(); ?>"/>
                                <span class="accountName"><?php echo $clientAccount->getName(); ?></span>
                            </div>
                        <?php } ?>

            
            
                        </div>
            
        </div>

            </div>

            <div class="clearfix filterRow"></div>
            <div class="filterColumnWide filterCollapse">

                    <div class="filterColumnRow">

                        <div class="filterColumnHeader" id="priceRangeFilterHeader">
                            <i class="fa fa-fw fa-usd"></i>&nbsp;Price Range: <span class="headerText"
                                    id="priceRangeHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <!-- <p style="text-align: center" id="priceRangeText">$<span
                                        id="minBid"><?php echo readableValue($minBid); ?></span> - $<span
                                        id="maxBid"><?php echo readableValue($maxBid); ?></span></p>
                            <div id="priceSlider"></div> -->

                            Min <input type="text" class="text currency_field pMinBid" 
                                   value="<?php echo $filterMinBid; ?>">
                            Max <input type="text" class="text currency_field pMaxBid" 
                                   value="<?php echo $filterMaxBid; ?>">
                            <a href="javascript:void(0);" class="set_max_price" style="display:none">Reset</a>
                            <input type="hidden" id="pMinBid" data-original-value="<?php echo $minBid; ?>"
                                   value="<?php echo $filterMinBid; ?>">
                            <input type="hidden" id="pMaxBid" data-original-value="<?php echo $maxBid; ?>"
                                   value="<?php echo $filterMaxBid; ?>">
                        </div>

                    </div>
                </div>
            <div class="filterColumn filterCollapse">
                <div class="filterColumnHeader" id="serviceFilterHeader">
                    <i class="fa fa-fw fa-list-ol"></i> Services: <span class="headerText"
                            id="serviceHeaderText"></span>
                    <a class="filterHeaderToggle fa fa-fw"></a>
                </div>

                <div class="filterSearchBar">
                    <input class="text filterSearch" type="text" placeholder="Search Services" id="serviceSearch"/>
                    <a class="filterSearchClear">&times;</a>
                </div>

                <?php
                $allServices = false;
                

                if (!count($filterServices) || (count($filterServices) == count($services))) {
                    $allServices = true;
                }
                ?>
                <div class="filterColumnScroll">

                    <div class="filterColumnRow sticky">
                        <input type="checkbox" class="filterColumnCheck filterChecker"
                               data-affected-class="serviceFilterCheck"<?php echo $allServices ? ' checked="checked"' : '' ?>>
                        <strong>All</strong>
                        <hr/>
                    </div>
                    <div class="filterColumnRow">
                       
                    </div>

                    <?php foreach ($categories as $category) { ?>
                        <div class="filterColumnRow">
                            <strong><?php echo $category->getServiceName(); ?></strong>
                        </div>

                        <?php
                        if (isset($services[$category->getServiceId()])) {
                            foreach ($services[$category->getServiceId()] as $service) {
                                ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox"
                                           class="filterCheck filterChecker serviceFilterCheck"<?php echo ($allServices || in_array($service->getServiceId(), $filterServices)) ? ' checked' : ''; ?>
                                           value="<?php echo $service->getServiceId(); ?>"
                                           data-text-value="<?php echo $service->getServiceName(); ?>"/><?php echo $service->getServiceName(); ?>
                                </div>
                            <?php }
                        } ?>

                    <?php } ?>
                </div>

            </div>

            

            <?php
            $queueOptions = [
                1 => 'Queued Proposals',
                2 => 'Denied Proposals',
                'unapproved' => 'Unapproved',
                'duplicate' => 'Duplicates',
            ];

            $emailOptions = [
                'o' => 'Email Opened',
                'd' => 'Email Delivered',
                'u' => 'Email Undelivered',
                'uo' => 'Email Unopened',
                'us' => 'Email Unsent'
            ];
            ?>


            <div class="filterColumn filterCollapse">
                <div class="filterColumnHeader" id="otherFilterHeader">
                    <i class="fa fa-fw fa-envelope-o"></i> Other: <span class="headerText"
                            id="otherHeaderText"></span>
                    <a class="filterHeaderToggle fa fa-fw"></a>
                </div>

                <?php
                $allOthers = false;
                
                $others = array_merge($queueOptions, $emailOptions);
                $filterOther = array_merge($filterQueue, $filterEmail);

                if (!count($filterOther) || (count($filterOther) == count($others))) {
                    $allOthers = true;
                }
                ?>

                <div class="filterColumnScroll">

                    <div class="filterColumnRow sticky">
                        <input type="checkbox" class="filterColumnCheck filterChecker"
                               data-affected-class="otherFilterCheck"<?php echo $allOthers ? ' checked="checked"' : '' ?>>
                        <strong>All</strong>
                        <hr/>
                    </div>
                    <div class="filterColumnRow">
                        
                    </div>

                    <?php foreach ($queueOptions as $k => $v) { ?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck filterChecker queueFilterCheck otherFilterCheck"<?php echo ($allOthers || in_array($k, $filterOther)) ? ' checked' : ''; ?>
                                   value="<?php echo $k; ?>" data-text-value="<?php echo $v; ?>"/>
                            <?php echo $v; ?>
                        </div>
                    <?php } ?>

                    <div class="filterColumnRow">
                        <hr/>
                    </div>

                    <?php
                    foreach ($emailOptions as $k => $v) { ?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck filterChecker emailFilterCheck otherFilterCheck"<?php echo ($allOthers || in_array($k, $filterEmail)) ? ' checked' : ''; ?>
                                   value="<?php echo $k; ?>" data-text-value="<?php echo $v; ?>"/>
                            <?php echo $v; ?>
                        </div>
                    <?php 
                    }
                    ?>
                    <div class="filterColumnRow">
                        <hr/>
                    </div>
                    <div class="filterColumnRow">
                        <input type="checkbox" id="pResendInclude" class="filterCheck filterChecker excludeCheck otherFilterCheck" <?php  if($filterResendInclude!=null || $filterResendInclude !='') { echo ($filterResendInclude==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>   data-text-value="Email On" value="1"> Email On 
                    </div> 
                    <div class="filterColumnRow">        
                        <input type="checkbox" id="pResendExclude" class="filterCheck filterChecker excludeCheck otherFilterCheck" <?php  if($filterResendExclude!=null || $filterResendExclude !='') { echo ($filterResendExclude==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>  data-text-value="Email Off" value="1"> Email Off
                    </div>
                    
                </div>
            </div>

            <?php 
                //if ($userAccount->hasEstimatingPermission() ) {
                if (0) { ?>
            <div class="filterColumn filterCollapse">
                <div class="filterColumnHeader" id="estimateFilterHeader">
                    <i class="fa fa-fw fa-calculator"></i> Estimate: <span class="headerText"
                            id="estimateHeaderText">[ All ]</span>
                    <a class="filterHeaderToggle fa fa-fw"></a>
                </div>

                <?php
                $allEstimateStatuses = false;
                

                if (!count($estimateFilterStatuses) || (count($estimateFilterStatuses) == count($estimateStatuses))) {
                    $allEstimateStatuses = true;
                }
                ?>

                <div class="filterColumnScroll">
                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterColumnCheck filterChecker"
                               data-affected-class="estimateStatusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>>
                        <strong>All Estimate Statuses</strong>
                    </div>
                    <div class="filterColumnRow">
                        <hr/>
                    </div>
                    <?php foreach ($estimateStatuses as $estimateStatus) { ?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck filterChecker estimateStatusFilterCheck"<?php echo ($allEstimateStatuses || in_array($estimateStatus->getId(), $estimateFilterStatuses)) ? ' checked' : ''; ?>
                                   value="<?php echo $estimateStatus->getId(); ?>"
                                   data-text-value="<?php echo $estimateStatus->getName(); ?>"/>
                            <?php echo $estimateStatus->getName(); ?>
                        </div>
                    <?php } ?>
                    <hr/>
                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterColumnCheck filterChecker"
                               data-affected-class="JobCostStatusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>>
                        <strong>All Job Cost Statuses</strong>
                    </div>
                    <div class="filterColumnRow">
                        <hr/>
                    </div>
                    <?php foreach ($estimateJobCostStatuses as $estimateJobCostStatus) {?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck filterChecker  JobCostStatusFilterCheck"<?php echo ($allEstimateStatuses || in_array($estimateJobCostStatus->getId(), $estimateFilterStatuses)) ? ' checked' : ''; ?>
                                   value="<?php echo $estimateJobCostStatus->getId(); ?>"
                                   data-text-value="<?php echo $estimateJobCostStatus->getName(); ?>"/>
                            <?php echo $estimateJobCostStatus->getName(); ?>
                        </div>
                    <?php } ?>
                </div>
                     
            </div>
                    <?php }?>

            <div class="clearfix filterRow"></div>
            <div class="filterRow ">            
                <!--Business Type Filter-->
                <div class="filterColumn filterCollapse">

                    <div class="filterColumnHeader containsCalendar" id="businessTypeFilterHeader">
                    <i class="fa fa-fw fa-briefcase"></i> Business Type: <span class="headerText" id="businessTypeHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <?php
                    $allBusinessTypes = false;
                
                    if (!count($filterBusinessTypes)) {
                        $allBusinessTypes = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="businessTypeFilterColumn">

                        <div class="filterColumnRow sticky" id="businessTypeRowAll">
                            <input type="checkbox" id="allBusinessTypes" class="filterColumnCheck filterChecker"
                                   data-affected-class="businessTypeFilterCheck"<?php echo $allBusinessTypes ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                            <hr/>
                        </div>
                        <div class="filterColumnRow">
                            
                        </div>
                        <?php
                        foreach($businessTypes as $businessType){
                        
                            ?>

                            <div class="filterColumnRow">
                                <input type="checkbox" class="filterCheck filterChecker businessTypeFilterCheck"
                                    <?php echo (in_array($businessType->getId(), $filterBusinessTypes)) ? ' checked="checked"' : ''; ?>
                                       value="<?php echo $businessType->getId(); ?>"
                                       data-text-value="<?php echo $businessType->getTypeName(); ?>"/>
                                <span class="businessTypeName"><?php echo $businessType->getTypeName(); ?></span>
                            </div>

                            <?php
                        }
                        ?>

                    </div>
                </div>
                <!-- end businedd type filter-->
                <!--Signature Filter-->
                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="signatureFilterHeader">
                        <i class="fa fa-fw fa-pencil-square-o"></i> Signature: <span class="headerText"
                                id="signatureHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <?php
                    $allSignatures = false;
                
                    if ($filterSigned && $filterUnsigned && $filterCompanySigned && $filterCompanyUnsigned) {
                    
                        $allSignatures = true;
                    }
                    ?>

                    <div class="filterColumnScroll">
                        <div class="filterColumnRow sticky" id="signatureRowAll">
                            <input type="checkbox" id="allSignatures" class="filterColumnCheck filterChecker"
                                   data-affected-class="signedCheck"<?php echo $allSignatures ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                            <hr/>
                        </div>
                        
                        <div class="filterColumnRow">
                        
                            <input type="checkbox" id="pSigned" class="filterCheck filterChecker signedCheck signatureFilterCheck" <?php  if($filterSigned!=null || $filterSigned!='') { echo ($filterSigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>   data-text-value="Signed" value="1"> Customer Signed
                        </div> 
                        <div class="filterColumnRow">        
                            <input type="checkbox" id="pUnsigned" class="filterCheck filterChecker signedCheck signatureFilterCheck" <?php  if($filterUnsigned!=null || $filterUnsigned!='') { echo ($filterUnsigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>  data-text-value="Unsigned" value="1"> Customer Unsigned
                        </div>   
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <div class="filterColumnRow">
                        
                            <input type="checkbox" id="pCompanySigned" class="filterCheck filterChecker signedCheck signatureFilterCheck" <?php  if($filterCompanySigned!=null || $filterCompanySigned!='') { echo ($filterCompanySigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>   data-text-value="Signed" value="1"> Company Signed
                        </div> 
                        <div class="filterColumnRow">        
                            <input type="checkbox" id="pCompanyUnsigned" class="filterCheck filterChecker signedCheck signatureFilterCheck" <?php  if($filterCompanyUnsigned!=null || $filterCompanyUnsigned!='') { echo ($filterCompanyUnsigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>  data-text-value="Unsigned" value="1"> Company Unsigned
                        </div>   
                    </div>
                </div>
                <!--End Signature Filter-->
            </div>

            
            <!---------------- start resend exclude------------------------------------------------->
                <!-- <div class="filterColumnWide filterCollapse" style="margin-top: -2px;">

                    <div class="filterColumnRow">

                        <div class="filterColumnHeader" id="ResendFilterHeader">
                            <i class="fa fa-fw fa-usd"></i>&nbsp;Resend Include/Exclude: <span class="headerText"
                                    id="ResendHeadercheck">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">

                            <input type="checkbox" id="pResendInclude" class="filterCheck" checked="" value="1"> Resend Include 
                            <input type="checkbox" id="pResendExclude" class="filterCheck" checked="" value="1"> Resend Exclude
                        </div>
                    </div>
                </div> -->
            <!---------------- end resend exclude-------------------------------------------------->

        </div>

        



        <div id="newProposalColumnFilters">


            <h4>Show / Hide Table Columns</h4>
            <a class="close_column" href="javascript:void(0);">×</a>
            <div style="padding-top:15px;position: absolute;top: -5px;left: 225px;"><a href="javascript:void(0);" id="select_p_column_all">All</a> / <a href="javascript:void(0);" id="select_p_column_none">None</a></div>
            <div class="clearfix"></div>

            <div class="filterRow" style="margin-top:2px">
            <!-- <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="2">Date
            </label> -->
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="4">Win Date
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="5"><span style="margin-top: 3px;position: absolute;">Job#</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="6"><span style="margin-top: 3px;position: absolute;">Account</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="7"><span style="margin-top: 3px;position: absolute;">Project Name</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="8"><span style="margin-top: 3px;position: absolute;">Image Count</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="9"><span style="margin-top: 3px;position: absolute;">Price</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="10"><span style="margin-top: 3px;position: absolute;">Contact</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="11"><span style="margin-top: 3px;position: absolute;">User</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="12"><span style="margin-top: 3px;position: absolute;">Last Activity</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="13"><span style="margin-top: 3px;position: absolute;">Email Status</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="14"><span style="margin-top: 3px;position: absolute;">Delivery Status</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="15"><span style="margin-top: 3px;position: absolute;">Open Status</span>
            </label>
            
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="16"><span style="margin-top: 3px;position: absolute;">Audit Status</span>
            </label>
            <?php
            /*if ($userAccount->hasEstimatingPermission() ) { ?>
                <label class="checkbox-inline">
                    <input type="checkbox" class="column_show" name="column_show" value="16"><span style="margin-top: 3px;position: absolute;">Estimate Status</span>
                </label>
            <?php }
            */ ?>
            <!-- <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="25"><span style="margin-top: 3px;position: absolute;">Gross Profit</span>
            </label> -->
            <a href="javascript:void(0);" style="float:right" class="column_show_apply btn blue" >Apply</a>
            </div>

            <div class="clearfix filterRow"></div>

            

            




            
        </div>








        
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        // Show Presets
        $("#openFilterPresets").click(function () {
            // Toggle the presets
            $("#proposalFilterPresets").toggle();
            // Toggle the chevron on the dropdown
            $("#presetChevron").toggleClass("fa-chevron-down fa-chevron-up");
        });

        // Close the filter
        $("#closeProposalFilters").click(function () {
            $("#newProposalFilters").toggle();
            $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

            // Get mapping data
            if ($("#proposalsMap").is(':visible')) {
//                updateMap();
            }
        });

        $(".filterColumnWide .filterColumnHeader").click(function () {

            $(".filterColumnWide").not($(this).parents('.filterColumnWide')).addClass('filterCollapse');
            $(".filterColumn").addClass('filterCollapse'); 
            $(this).parents('.filterColumnWide').toggleClass('filterCollapse');
        });

        $(".filterColumn .filterColumnHeader").click(function () {
           // console.log('dddd')
           $(".filterColumnWide").addClass('filterCollapse');
           $(".filterColumn").not($(this).parents('.filterColumn')).addClass('filterCollapse');
           $(this).parents('.filterColumn').toggleClass('filterCollapse');
       
            
        });

        // Group Actions Button
        $("#groupActionsButton").click(function () {
            console.log('dfdf')
            // Hide the filter
            $("#newProposalFilters").hide();
            // Toggle the buttons
            $(".groupActionsContainer").show();
        });

        //Hide Menu when clicking on a group action item
        $(".groupActionItems a").click(function () {
            $("#groupActionsContainer").hide();
            return false;
        });

       if($('#uniform-activityPreset').length<1){
            $("#createdPreset").uniform();
            $("#activityPreset").uniform();
            $("#olderThenType").uniform();
            $("#newerThenType").uniform();
            $("#wonPreset").uniform();
            $("#saves_filter_list").uniform();
       }

       
    // $(".sales-targets-li").click(function (e) {
    //     e.preventDefault();
    //     swal({
    //             type: 'info',
    //             title: 'Disable ',
    //             html: '<p>Please Contact Support</p>',
    //             showCloseButton: true,
    //         })
    // });
       
    });

</script>

