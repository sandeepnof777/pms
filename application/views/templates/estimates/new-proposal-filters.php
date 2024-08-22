<style type="text/css">

    #newFilterContainer {
        position: relative;
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


</style>

<div id="proposalsTopContent" style="position: relative;">

    <div class="materialize">
        <a class="m-btn grey tiptip" title="Filter your proposals" id="newProposalFilterButton"><i
                    class="fa fa-fw fa-filter"></i> Filters</a>
        <a class="m-btn grey tiptip" title="Reset All Filters" id="newResetProposalFilterButton"><i
                    class="fa fa-fw fa-refresh"></i></a>
        <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
             id="groupActionsButton">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="materialize groupActionsContainer">
                <div class="collection groupActionItems">
                    <a href="#" id="groupResend" class="collection-item iconLink">
                        <i class="fa fa-fw fa-envelope"></i> Send Proposals
                    </a>
                    <a href="#" id="groupDelete" class="collection-item iconLink">
                        <i class="fa fa-fw fa-trash"></i> Delete Proposals
                    </a>
                    <a href="#" id="groupChangeStatus" class="collection-item iconLink">
                        <i class="fa fa-fw fa-external-link-square"></i> Change Status
                    </a>
                    <a href="#" id="groupUnduplicate" class="collection-item iconLink">
                        <i class="fa fa-fw fa-external-link"></i> Set as Standalone
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
        <div id="filterBadges"></div>
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
                                       value="<?php echo ($this->session->userdata('pCreatedFrom')) ? date('m/d/y', $this->session->userdata('pCreatedFrom')) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pCreatedTo"
                                       value="<?php echo ($this->session->userdata('pCreatedTo')) ? date('m/d/y', $this->session->userdata('pCreatedTo')) : '' ?>">
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
                                       value="<?php echo ($this->session->userdata('pActivityFrom')) ? date('m/d/y', $this->session->userdata('pActivityFrom')) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pActivityTo"
                                       value="<?php echo ($this->session->userdata('pActivityTo')) ? date('m/d/y', $this->session->userdata('pActivityTo')) : '' ?>">
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

                <div class="filterColumnWide filterCollapse">

                    <div class="filterColumnRow">

                        <div class="filterColumnHeader" id="priceRangeFilterHeader">
                            <i class="fa fa-fw fa-usd"></i>&nbsp;Price Range: <span class="headerText"
                                    id="priceRangeHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p style="text-align: center" id="priceRangeText">$<span
                                        id="minBid"><?php echo readableValue($minBid); ?></span> - $<span
                                        id="maxBid"><?php echo readableValue($maxBid); ?></span></p>
                            <div id="priceSlider"></div>
                            <input type="hidden" id="pMinBid" data-original-value="<?php echo $minBid; ?>"
                                   value="<?php echo $minBid; ?>">
                            <input type="hidden" id="pMaxBid" data-original-value="<?php echo $maxBid; ?>"
                                   value="<?php echo $maxBid; ?>">
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>

            <div class="filterRow">

            <div class="filterColumn filterCollapse">
                <div class="filterColumnHeader" id="estimateFilterHeader">
                    <i class="fa fa-fw fa-calculator"></i> Estimate Status: <span class="headerText"
                            id="estimateHeaderText">[ All ]</span>
                    <a class="filterHeaderToggle fa fa-fw"></a>
                </div>

                <?php
                $allEstimateStatuses = false;

                $estimateFilterStatuses = $this->session->userdata('pEstimateFilterStatus') ?: [];

                if (!count($estimateFilterStatuses) || (count($estimateFilterStatuses) == count($estimateStatuses))) {
                    $allEstimateStatuses = true;
                }
                ?>

                <div class="filterColumnScroll">
                    <div class="filterColumnRow">
                        <input type="checkbox" class="filterColumnCheck"
                               data-affected-class="statusFilterCheck"<?php echo $allEstimateStatuses ? ' checked="checked"' : '' ?>>
                        <strong>All</strong>
                    </div>
                    <div class="filterColumnRow">
                        <hr/>
                    </div>
                    <?php foreach ($estimateStatuses as $estimateStatus) { ?>
                        <div class="filterColumnRow">
                            <input type="checkbox"
                                   class="filterCheck statusFilterCheck"<?php echo ($allEstimateStatuses || in_array($estimateStatus->getId(), $estimateFilterStatuses)) ? ' checked' : ''; ?>
                                   value="<?php echo $estimateStatus->getId(); ?>"
                                   data-text-value="<?php echo $estimateStatus->getName(); ?>"/>
                            <?php echo $estimateStatus->getName(); ?>
                        </div>
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
                    $filterUsers = $this->session->userdata('pFilterUser') ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('pFilterBranch') ?: [];

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
                    $filterAccounts = $this->session->userdata('pFilterClientAccount') ?: [];

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

                        <div class="filterColumnRow">
                            <hr/>
                        </div>

                    </div>
                </div>

            </div>

            <div class="clearfix filterRow"></div>

            

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
            $(this).parents('.filterColumnWide').toggleClass('filterCollapse');
        });

        $(".filterColumn .filterColumnHeader").click(function () {
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

