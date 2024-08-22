<style type="text/css">

    #newFilterContainer {
        position: relative;
    }

    div.sticky {
        position: -webkit-sticky;
        position: sticky;
        background-color: #DCDCDC;
        top: 0px;
        z-index: 99;
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
        top: 0;
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
        padding-top: 5px;
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

    #filterBadges {
        float: left;
        padding-left: 10px;
        width: 430px;
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
    #uniform-createdPreset,#uniform-activityPreset,#uniform-wonPreset{
    margin-left: 1px;
    }

</style>

<div id="proposalsTopContent" style="position: relative;">

    <div class="materialize">
    
    <a class="m-btn grey tiptip" style="float:right" title="Column Filters" id="tableColumnFilterButton"><i
                    class="fa fa-fw fa-table"></i></a>
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
                    <a href="#" id="bouncedGroupResend" data-resend-id="<?=$this->uri->segment(3);?>" class="bouncedGroupResend collection-item iconLink ">
                        <i class="fa fa-fw fa-envelope"></i>Resend Bounced Proposals
                    </a>
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
                    <a href="#" id="groupProposalExport" class="collection-item iconLink">
                        <i class="fa fa-fw fa-cloud-download"></i> Export Proposals
                    </a>

                </div>
                <div class="collection groupActionItems" style="width:298px; float:left">
                    <a href="#" id="groupCopySameClient" class="collection-item iconLink">
                        <i class="fa fa-fw fa-copy"></i> Copy Proposals - Same Contact
                    </a>
                    <a href="#" id="groupChangeDate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Change Proposal Date
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
                        <a href="#" id="groupPriceModify" class="collection-item iconLink">
                            <i class="fa fa-fw fa-usd"></i> Modify Price
                        </a>
                    <?php } ?>


                </div>
            </div>
        </div>
        <?php //if($this->uri->segment(2)!='resend'){?>
            <div id="filterBadges"></div>
        <?php
           // }
           $resend_id = $this->uri->segment(3);
            if(count($resends)>0){
                $display='block';
            }else{
                $display='none';
            }
       ?>
        <a href="<?=site_url('account/group_resends');?>" class="m-btn grey tiptip campaign_btn" style="float:right;margin-right:10px;display:<?=$display;?>" title="Campaigns"><i class="fa fa-fw fa-envelope"></i> Campaigns</a>
        
        <div class="clearfix"></div>
        
    
    </div>


    <div id="newFilterContainer">

        <div id="newProposalFilters">

            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif">
                <p id="filterResults">
                    <a href="#" class="btn ui-button" id="openFilterPresets">
                        Presets <i id="presetChevron" class="fa fw fa-chevron-down"></i>
                    </a>
                    <span id="filterNumResults"></span> proposals found
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
                            <p>
                                <label>From:</label>
                                <input type="text" id="pCreatedFrom" class="text" style="margin-left: 11px;"
                                       value="<?php echo ($this->session->userdata('prCreatedFrom_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prCreatedFrom_'.$resend_id)) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pCreatedTo"
                                       value="<?php echo ($this->session->userdata('prCreatedTo_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prCreatedTo_'.$resend_id)) : '' ?>">
                                <a class="filterDateClear" id="resetCreatedDate">Reset</a>
                            </p>
                            <p style="padding-top: 5px;">
                                <label>Preset:</label>
                                <select id="createdPreset">
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
                                       value="<?php echo ($this->session->userdata('prActivityFrom_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prActivityFrom_'.$resend_id)) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pActivityTo"
                                       value="<?php echo ($this->session->userdata('prActivityTo_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prActivityTo_'.$resend_id)) : '' ?>">
                                <a class="filterDateClear" id="resetActivityDate">Reset</a>
                            </p>
                            <p style="padding-top: 5px;">
                                <label>Preset:</label>
                                <select id="activityPreset">
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
                                       value="<?php echo ($this->session->userdata('prWonFrom_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prWonFrom_'.$resend_id)) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pWonTo"
                                       value="<?php echo ($this->session->userdata('prWonTo_'.$resend_id)) ? date('m/d/y', $this->session->userdata('prWonTo_'.$resend_id)) : '' ?>">
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
                    $filterStatuses = $this->session->userdata('prFilterStatus_'.$resend_id) ?: [];
                    $pResendToStatus = $this->session->userdata('pResendToStatusId') ?: '';
            
                    
                    if (!count($filterStatuses) || (count($filterStatuses) == count($statusCollection)) ) {
                        $allStatuses = true;
                    }
                    if($pResendToStatus){
                        $allStatuses = false;
                    }
                    ?>

<div class="filterColumnScroll">
                <div class="filterColumnRow">
                    <input type="checkbox" id="statusFilterColumnCheck" class="filterColumnCheck" data-affected-class="statusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>> <strong>All</strong>
                </div>
                <div class="filterColumnRow">
                    <hr />
                </div>
            <?php foreach ($statusCollection as $status) { ?>


                <div class="filterColumnRow">
                    <input type="checkbox" class="filterCheck statusFilterCheck"<?php echo ($allStatuses || in_array($status->getStatusId(), $filterStatuses) || $status->getStatusId() == $pResendToStatus) ? ' checked' : ''; ?> value="<?php echo $status->getStatusId(); ?>" data-text-value="<?php echo $status->getText(); ?>" />
                    <?php echo $status->getText(); ?>
                </div>
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
                        <input type="checkbox" class="filterCheck statusFilterCheck prospectStatusFilterCheck"<?php echo (in_array($prospectStatus->getStatusId(), $filterStatuses)) ? ' checked' : ''; ?> value="<?php echo $prospectStatus->getStatusId(); ?>" data-text-value="<?php echo $prospectStatus->getText(); ?>" />
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
                    $filterUsers = $this->session->userdata('prFilterUser_'.$resend_id) ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('prFilterBranch_'.$resend_id) ?: [];

                    ?>

                    <div class="filterColumnScroll">

                        <div class="filterColumnRow">
                            <input type="checkbox" class="filterColumnCheck" id="allUsersCheck"
                                   data-affected-class="userFilterCheck"<?php echo $allUsers ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php
                        if (($account->hasFullAccess() || $account->isBranchAdmin()) && count($branches) > 0) {
                            if ($account->hasFullAccess() || ($account->isBranchAdmin() && $account->getBranch() < 1)) {
                                ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck userFilterCheck branchFilterCheck"
                                           data-affected-class="userFilterCheck"
                                           data-branch-id="0""<?php echo $allUsers || (in_array(0, $filterBranches)) ? ' checked' : ''; ?>
                                    > <strong>Main Branch</strong>
                                </div>
                            <?php } ?>
                            <?php foreach ($branches as $branch) { ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck userFilterCheck branchFilterCheck"
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
                                       class="filterCheck userFilterCheck"<?php echo ($allUsers || in_array($acc->getAccountId(), $filterUsers)) ? ' checked' : ''; ?>
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
                    $filterAccounts = $this->session->userdata('prFilterClientAccount_'.$resend_id) ?: [];

                    if (!count($filteredClientAccounts)) {
                        $allAccounts = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="accountsFilterColumn">

                        <div class="filterColumnRow" id="accountRowAll">
                            <input type="checkbox" id="allClientAccounts" class="filterColumnCheck"
                                   data-affected-class="clientAccountFilterCheck"<?php echo $allAccounts ? ' checked="checked"' : '' ?>>
                            <strong>All Accounts</strong>
                        </div>
                        <?php foreach ($filteredClientAccounts as $clientAccount) { ?>
                            <div class="filterColumnRow searchSelectedRow">
                                <input type="checkbox" class="filterCheck clientAccountFilterCheck searchSelected"
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
                                   value="<?php echo $minBid; ?>">
                            Max <input type="text" class="text currency_field pMaxBid" 
                                   value="<?php echo $maxBid; ?>">
                            <a href="javascript:void(0);" class="set_max_price" style="display:none">Reset Max</a>
                            <input type="hidden" id="pMinBid" data-original-value="<?php echo $minBid; ?>"
                                   value="<?php echo $minBid; ?>">
                            <input type="hidden" id="pMaxBid" data-original-value="<?php echo $maxBid; ?>"
                                   value="<?php echo $maxBid; ?>">
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
                $filterServices = $this->session->userdata('prFilterService_'.$resend_id) ?: [];

                if (!count($filterServices) || (count($filterServices) == count($services))) {
                    $allServices = true;
                }
                ?>
                <div class="filterColumnScroll">

                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterColumnCheck"
                               data-affected-class="serviceFilterCheck"<?php echo $allServices ? ' checked="checked"' : '' ?>>
                        <strong>All</strong>
                    </div>
                    <div class="filterColumnRow">
                        <hr/>
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
                                           class="filterCheck serviceFilterCheck"<?php echo ($allServices || in_array($service->getServiceId(), $filterServices)) ? ' checked' : ''; ?>
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
                $filterQueue = $this->session->userdata('prFilterQueue_'.$resend_id) ?: [];
                $filterEmail = $this->session->userdata('prFilterEmailStatus_'.$resend_id) ?: [];


                $filterResendInclude = $this->session->userdata('prResendInclude_'.$resend_id);
                $filterResendExclude = $this->session->userdata('prResendExclude_'.$resend_id);
                $filterSigned = $this->session->userdata('prSigned_'.$resend_id);
                $filterUnsigned = $this->session->userdata('prUnsigned_'.$resend_id);
                $filterCompanySigned = $this->session->userdata('prCompanySigned_'.$resend_id);
                $filterCompanyUnsigned = $this->session->userdata('prCompanyUnsigned_'.$resend_id);


                $others = array_merge($queueOptions, $emailOptions);
                $filterOther = array_merge($filterQueue, $filterEmail);

                if (!count($filterOther) || (count($filterOther) == count($others))) {
                    $allOthers = true;
                }
                ?>

                <div class="filterColumnScroll">

                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterColumnCheck"
                               data-affected-class="otherFilterCheck"<?php echo $allOthers ? ' checked="checked"' : '' ?>>
                        <strong>All</strong>
                    </div>
                    <div class="filterColumnRow">
                        <hr/>
                    </div>

                    <?php foreach ($queueOptions as $k => $v) { ?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck queueFilterCheck otherFilterCheck"<?php echo ($allOthers || in_array($k, $filterOther)) ? ' checked' : ''; ?>
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
                                   class="filterCheck emailFilterCheck otherFilterCheck"<?php echo ($allOthers || in_array($k, $filterEmail)) ? ' checked' : ''; ?>
                                   value="<?php echo $k; ?>" data-text-value="<?php echo $v; ?>"/>
                            <?php echo $v; ?>
                        </div>
                    <?php }
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
                    <!-- <div class="filterColumnRow">
                        <hr/>
                    </div>
                    <div class="filterColumnRow">
                    
                        <input type="checkbox" id="pSigned" class="filterCheck filterChecker signedCheck otherFilterCheck" <?php  if($filterSigned!=null || $filterSigned!='') { echo ($filterSigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>   data-text-value="Signed" value="1"> Signed
                    </div> 
                    <div class="filterColumnRow">        
                        <input type="checkbox" id="pUnsigned" class="filterCheck filterChecker signedCheck otherFilterCheck" <?php  if($filterUnsigned!=null || $filterUnsigned!='') { echo ($filterUnsigned==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?>  data-text-value="Unsigned" value="1"> Unsigned
                    </div>  -->

                </div>
            </div>

            <?php 
            //if ($userAccount->hasEstimatingPermission() ) {
            if (0 ) { ?>
                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="estimateFilterHeader">
                        <i class="fa fa-fw fa-calculator"></i> Estimate: <span class="headerText"
                                id="estimateHeaderText">[ All ]</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allEstimateStatuses = false;
                    $estimateFilterStatuses = $this->session->userdata('prEstimateFilterStatus_'.$resend_id) ?: [];

                    if (!count($estimateFilterStatuses) || (count($estimateFilterStatuses) == count($estimateStatuses))) {
                        $allEstimateStatuses = true;
                    }
                    ?>

                    <div class="filterColumnScroll">
                        <div class="filterColumnRow">
                            <input type="checkbox" class="filterColumnCheck"
                                data-affected-class="estimateStatusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>>
                            <strong>All Estimate Statuses</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php foreach ($estimateStatuses as $estimateStatus) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox"
                                    class="filterCheck estimateStatusFilterCheck"<?php echo ($allEstimateStatuses || in_array($estimateStatus->getId(), $estimateFilterStatuses)) ? ' checked' : ''; ?>
                                    value="<?php echo $estimateStatus->getId(); ?>"
                                    data-text-value="<?php echo $estimateStatus->getName(); ?>"/>
                                <?php echo $estimateStatus->getName(); ?>
                            </div>
                        <?php } ?>
                        <hr/>
                        <div class="filterColumnRow">
                            <input type="checkbox" class="filterColumnCheck"
                                data-affected-class="JobCostStatusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>>
                            <strong>All Job Cost Statuses</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php foreach ($estimateJobCostStatuses as $estimateJobCostStatus) {?>
                            <div class="filterColumnRow">
                                <input type="checkbox"
                                    class="filterCheck JobCostStatusFilterCheck"<?php echo ($allEstimateStatuses || in_array($estimateJobCostStatus->getId(), $estimateFilterStatuses)) ? ' checked' : ''; ?>
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
                    
                    $filterBusinessTypes = $this->session->userdata('prFilterBusinessType_'.$resend_id) ?: [];
                    
                    if (!count($filterBusinessTypes)) {
                        $allBusinessTypes = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="businessTypeFilterColumn">

                        <div class="filterColumnRow" id="businessTypeRowAll">
                            <input type="checkbox" id="allBusinessTypes" class="filterColumnCheck"
                                   data-affected-class="businessTypeFilterCheck"<?php echo $allBusinessTypes ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php
                        foreach($businessTypes as $businessType){
                        
                            ?>

                            <div class="filterColumnRow">
                                <input type="checkbox" class="filterCheck businessTypeFilterCheck"
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
        </div>

        



        <div id="newProposalColumnFilters">


            <h4>Show / Hide Table Columns</h4>
            <a class="close_column" href="javascript:void(0);">×</a>
            <div style="padding-top:15px;position: absolute;top: -5px;left: 225px;"><a href="javascript:void(0);" id="select_p_column_all">All</a> / <a href="javascript:void(0);" id="select_p_column_none">None</a></div>
            <div class="clearfix"></div>

            <div class="filterRow" style="margin-top:2px">
            <!-- <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="2">Date
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="5">Status
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
            <?php if ($userAccount->hasEstimatingPermission() ) { ?>
                <label class="checkbox-inline">
                    <input type="checkbox" class="column_show" name="column_show" value="24"><span style="margin-top: 3px;position: absolute;">Estimate Status</span>
                </label>
            <?php } ?>
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
            // Hide the filter
            $("#newProposalFilters").hide();
            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });

        //Hide Menu when clicking on a group action item
        $(".groupActionItems a").click(function () {
            $("#groupActionsContainer").hide();
            return false;
        });

    });

</script>

