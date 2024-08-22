<style type="text/css">

    .newFilterContainer {
        position: relative;
    }

    #resetClientFilters {
        display: none;
    }

    .newFilterContainer h3 {
        margin: 5px 0;
        width: 33%;
        float: left;
    }

    #filterInfo {
        position: relative;
        padding-top: 10px;
        text-align: center;
        font-size: 1.25em;
        margin-bottom: 5px;
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

    .newFilterContainer {
        position: absolute;
        top: 30px;
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

    #topFilterRow {
        padding-bottom: 2px;
        margin: 0;
    }

    .filterColumn {
        float: left;
        width: 186px;
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
        text-align: center;
        font-weight: bold;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        cursor: pointer;
        line-height: 20px;
        padding: 6px 10px;
        background: #25AAE1 url("/static/images/content-box-header-darker.png");
        repeat-x top;
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

    #closeFilters {
        position: absolute;
        right: 0;
        font-size: 11px;
        top: 5px;
    }

    #newFilters ::-webkit-input-placeholder {
        text-align: center;
    }

    #newFilters :-moz-placeholder { /* Firefox 18- */
        text-align: center;
    }

    #newFilters ::-moz-placeholder { /* Firefox 19+ */
        text-align: center;
    }

    #newFilters :-ms-input-placeholder {
        text-align: center;
    }

    /* Override Button Alignment on DateRangePicker */
    .comiseo-daterangepicker-right .comiseo-daterangepicker-buttonpanel {
        float: right;
    }

    .comiseo-daterangepicker:nth-child(2) {
        left: 245px !important;
    }

    .checkbox-inline, .radio-inline {
        position: relative;
        display: inline-block;
        padding-left: 20px;
        margin-bottom: 3px;
        font-weight: 400;
        vertical-align: middle;
        cursor: pointer;
        width: 12.5%
    }

    .close_column {
        position: absolute;
        top: 5px;
        right: 10px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333 !important;
    }

    #newLeadColumnFilters {
        position: absolute;
        top: -110px;
        left: 0px;
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

    #newLeadColumnFilters label {
        font-weight: bold;
    }
</style>

<div id="tableFilterContainer" style="position: relative; margin-bottom: 10px;">

    <div class="materialize">
        <div style="width:72%;float:left">
            <a class="m-btn grey tiptip filterButton" title="Filter your clients"><i class="fa fa-fw fa-filter"></i>
                Filters</a>
        
        <div class="m-btn groupAction tiptip" style="position: relative;float:left;margin-right: 10px;"
             title="Carry out actions on selected contacts" id="groupActions">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize">
                <div class="collection groupActionItems" id="clientGroupActions">


                    <a class="collection-item iconLink sendEmail" href="#"><i class="fa fa-fw fa-envelope-o"></i> Send
                        Email</a>
                    <a class="collection-item iconLink resend" href="#"><i class="fa fa-fw fa-reply"></i> Resend</a>
                    <?php if ($account->getUserClass() >= 3) { ?>
                        <a class="collection-item iconLink changeOwner" href="#"><i class="fa fa-fw fa-user"></i> Change
                            Owner</a>
                    <?php } ?>
                    <a class="collection-item iconLink changeBusinessType" href="#"><i class="fa fa-fw fa-briefcase"></i>
373	
                        Change Business Type</a>
                    <a class="collection-item iconLink printLeads" href="#"><i class="fa fa-fw fa-print"></i> Print
                        Leads</a>
                    <a class="collection-item iconLink planRoute" href="#"><i class="fa fa-fw fa-location-arrow"></i>
                        Plan Route</a>
                    <!--<a class="tiptip box-action deleteLeads" href="#" title="Delete all checked leads">Delete Leads</a>-->
                    <a class="collection-item iconLink deleteLeads" href="#"><i class="fa fa-fw fa-times-circle"></i>
                        Cancel Leads</a>

                </div>
            </div>
        </div>
       
            <a class="m-btn grey tiptip resetFilterButton" title="Reset To Default Filters"><i
                        class="fa fa-fw fa-refresh"></i></a>
            <div id="filterBadges"></div>
            </div>
            <div style="width: 28%;float:right">
            <?php
        
        $resend_id = $this->uri->segment(3);
        if (count($resends) > 0) {
            $display = 'block';
        } else {
            $display = 'none';
        }
        ?>

<div class="dropdownButton" style="float:right;margin-left: 5px;">
                    <a class="dropdownToggle m-btn grey" style="background:none;margin-right:0px" href="JavaScript:void('0');" ><i class="fa fa-cog"></i> <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdownMenuContainer openAbove" style="display: none;width: 180px; left:-112px">
                        
                        <ul class="dropdownMenu" style="width: 180px">
                            <li>
                            
                                <a  style="padding-left:10px;" href="JavaScript:void('0');" id="tableColumnFilterButton"><i
                                    class="fa fa-fw fa-table"></i> Column Filters</a>
                            </li>
                            
                            <li>
                                <a href="<?php echo site_url('leads/map') ?>" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-map" ></i> Leads Map
                                </a>
                                
                            </li>
                            <li style="display: <?=$display;?>;">
                                <a href="<?= site_url('leads/group_resends'); ?>" id="proposalMapLink" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-envelope" ></i> Campaigns [<?=count($resends);?>]
                                </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
               
                <a href="<?=site_url('leads/group_resends');?>" class="m-btn grey tiptip " style="float:right;margin-left:5px;padding:0px 5px;display:<?= $display; ?>" title="Campaigns "><i class="fa fa-fw fa-envelope"></i> <span class="campaign_count_btn"><?=count($resends);?></span></a>
                <a href="<?= site_url('leads/add'); ?>" class="m-btn blue-button right" ><i class="fa fa-fw fa-plus"></i>
                Add Lead</a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="newFilterContainer">
        <div id="newFilters">

            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif">
                <p id="filterResults"><span id="filterNumResults"></span> leads found
                    <a href="#" class="btn ui-button update-button" id="closeFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
            </div>

            <div class="clearfix"></div>

            <div id="topFilterRow">

                <div class="filterColumnWide filterCollapse">
                    <div class="filterColumnRow">
                        <div class="filterColumnHeader containsCalendar" id="createdFilterHeader">
                            Created: <span id="createdHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p>
                                <label>From:</label>
                                <input type="text" id="lCreatedFrom" class="text" style="margin-left: 11px;"
                                       value="<?php echo ($this->session->userdata('lrFilterDateStart_'.$resend_id)) ? date('m/d/Y', $this->session->userdata('lrFilterDateStart_'.$resend_id)) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="lCreatedTo"
                                       value="<?php echo ($this->session->userdata('lrFilterDateEnd_'.$resend_id)) ? date('m/d/Y', $this->session->userdata('lrFilterDateEnd_'.$resend_id)) : '' ?>">
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

                <div class="filterColumn filterCollapse" style="width: 33%;">
                    <div class="filterColumnHeader" id="userFilterHeader">
                        User: <span id="userHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allUsers = false;
                    $filterUsers = $this->session->userdata('lrFilterUser_'.$resend_id) ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('lrFilterBranch_'.$resend_id) ?: [];

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
                                           data-branch-id="0""<?php echo $allUsers || (in_array(0,
                                        $filterBranches)) ? ' checked' : ''; ?>> <strong>Main Branch</strong>
                                </div>
                            <?php } ?>
                            <?php foreach ($branches as $branch) { ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck userFilterCheck branchFilterCheck"
                                           data-affected-class="userFilterCheck"
                                           data-branch-id="<?php echo $branch->getBranchId() ?>"<?php echo ($allUsers || in_array($branch->getBranchId(),
                                            $filterBranches)) ? ' checked' : ''; ?>>
                                    <strong><?php echo $branch->getBranchName(); ?> Branch</strong>
                                </div>
                            <?php } ?>
                            <div class="filterColumnRow">
                                <hr/>
                            </div>

                            <div class="filterColumnRow">
                                <input type="checkbox"
                                       class="filterCheck userFilterCheck"<?php echo ($allUsers || in_array('unassigned',
                                        $filterUsers)) ? ' checked' : ''; ?> value="unassigned"
                                       data-text-value="Unassigned"/> Unassigned
                            </div>
                            <?php
                        }
                        foreach ($accounts as $acc) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox"
                                       class="filterCheck userFilterCheck"<?php echo ($allUsers || in_array($acc->getAccountId(),
                                        $filterUsers)) ? ' checked' : ''; ?> value="<?php echo $acc->getAccountId(); ?>"
                                       data-text-value="<?php echo $acc->getFullName(); ?>"
                                       data-branch-id="<?php echo $acc->getBranch(); ?>"/>
                                <?php echo $acc->getFullName(); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="filterColumn filterCollapse" style="width: 33%;">
                    <div class="filterColumnHeader" id="sourceFilterHeader">
                        Source: <span id="sourceHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allSources = false;
                    $filterSources = $this->session->userdata('lrFilterSource_'.$resend_id) ?: [];

                    if (!count($filterSources)) {
                        $allSources = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="sourceFilterColumn">

                        <div class="filterColumnRow" id="sourceRowAll">
                            <input type="checkbox" id="allSources" class="filterColumnCheck"
                                   data-affected-class="sourceFilterCheck"<?php echo $allSources ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php foreach ($leadSources as $leadSource) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox" class="filterCheck sourceFilterCheck"
                                    <?php echo (in_array($leadSource->getName(), $filterSources)) ? ' checked="checked"' : ''; ?>
                                       value="<?php echo $leadSource->getId(); ?>"
                                       data-text-value="<?php echo $leadSource->getName(); ?>"/>
                                <span class="sourceName"><?php echo $leadSource->getName(); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="filterRow" style="padding-top: 2px;">
                <div class="filterColumn filterCollapse" style="width: 33%;">
                    <div class="filterColumnHeader" id="statusFilterHeader">
                        Status: <span id="statusHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allStatuses = false;
                    $filterStatuses = $this->session->userdata('lrFilterStatus_'.$resend_id) ?: [];

                    $statuses = [
                        'Converted' => 'Converted',
                        'Cancelled' => 'Cancelled',
                        'On Hold' => 'On Hold',
                        'Waiting for Subs' => 'Waiting for Subs'
                    ];

                    if (!count($filterStatuses)) {
                        $allStatuses = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="statusFilterColumn">

                        <div class="filterColumnRow" id="statusRowAll">
                            <input type="checkbox" class="filterCheck statusFilterCheck"
                                <?php echo (in_array('Active', $filterStatuses)) ? ' checked="checked"' : ''; ?>
                                <?php echo (!count($filterStatuses)) ? ' checked="checked"' : ''; ?>
                                   value="Active"
                                   data-text-value="Active"/>
                            <span class="statusName">Active</span>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php foreach ($statuses as $status) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox" class="filterCheck statusFilterCheck"
                                    <?php echo (in_array($status, $filterStatuses)) ? ' checked="checked"' : ''; ?>
                                       value="<?php echo $status; ?>"
                                       data-text-value="<?php echo $status; ?>"/>
                                <span class="statusName"><?php echo $status; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!--Business Type Filter-->
                <div class="filterColumn filterCollapse" style="width: 33%;">

                    <div class="filterColumnHeader containsCalendar" id="businessTypeFilterHeader">
                        Business Type: <span id="businessTypeHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <?php
                    $allBusinessTypes = false;
                
                    $filterBusinessTypes = $this->session->userdata('lFilterBusinessType') ?: [];

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
                <!--
                <div class="filterColumn filterCollapse">
                    <div class="filterColumnHeader" id="dueFilterHeader">
                        Due Date: <span id="dueHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                $allDueDates = false;
                $filterDueDates = $this->session->userdata('lrDueDate_'.$resend_id) ?: [];

                $dueDates = [
                    'Due' => 'Due',
                    'Overdue' => 'Overdue',
                ];

                if (!count($filterDueDates)) {
                    $allDueDates = true;
                }
                ?>
                    <div class="filterColumnScroll" id="dueDateFilterColumn">

                        <div class="filterColumnRow" id="dueDateRowAll">
                            <input type="checkbox" id="allStatuses" class="filterColumnCheck"
                                   data-affected-class="dueDateFilterCheck"<?php echo $allDueDates ? ' checked="checked"' : '' ?> />
                            <strong>All</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php foreach ($dueDates as $dueDate) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox" class="filterCheck dueDateFilterCheck"
                                       checked="checked" value="<?php echo $dueDate; ?>"
                                       data-text-value="<?php echo $dueDate; ?>"/>
                                <span class="dueDateName"><?php echo $dueDate; ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                -->
                </div>
            </div>
        </div>
    </div>


    <div id="newLeadColumnFilters">


        <h4>Show / Hide Table Columns</h4>
        <a class="close_column" href="javascript:void(0);">×</a>
        <div style="padding-top:15px;position: absolute;top: -5px;left: 225px;"><a href="javascript:void(0);"
                                                                                   id="select_p_column_all">All</a> / <a
                    href="javascript:void(0);" id="select_p_column_none">None</a></div>
        <div class="clearfix"></div>

                <div class="filterRow" style="margin-top:2px">

            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="2" ><span
                        style="margin-top: 3px;position: absolute;">Created</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="3" ><span
                        style="margin-top: 3px;position: absolute;">Business</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="4" ><span
                        style="margin-top: 3px;position: absolute;">Source</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="5" ><span
                        style="margin-top: 3px;position: absolute;">Status</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="6" ><span
                        style="margin-top: 3px;position: absolute;">Rating</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="7" ><span
                        style="margin-top: 3px;position: absolute;">Due Date</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="8" ><span
                        style="margin-top: 3px;position: absolute;">Company</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="9" ><span
                        style="margin-top: 3px;position: absolute;">Zip</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="10" ><span
                        style="margin-top: 3px;position: absolute;">Project Name</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="11" ><span
                        style="margin-top: 3px;position: absolute;">Contact</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="12" ><span
                        style="margin-top: 3px;position: absolute;">Owner</span>
            </label>

            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="14" ><span
                        style="margin-top: 3px;position: absolute;">Last Activity</span>
            </label>

            <a href="javascript:void(0);" style="float:right" class="column_show_apply btn blue">Apply</a>
        </div>

        <div class="clearfix filterRow"></div>
    </div>

</div>

