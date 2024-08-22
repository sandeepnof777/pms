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

            <div class="filterRow">


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
                    <div class="filterColumnHeader" id="statusFilterHeader">
                        <i class="fa fa-fw fa-align-left"></i>&nbsp;Status: <span  class="headerText"
                                                                                   id="statusHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allStatuses = false;
                    $filterStatuses = $this->session->userdata('pFilterStatus') ?: [];

                    if (!count($filterStatuses) || (count($filterStatuses) == count($statusCollection))) {
                        $allStatuses = true;
                    }
                    ?>

                    <div class="filterColumnScroll">
                        <div class="filterColumnRow">
                            <input type="checkbox" class="filterColumnCheck"
                                   data-affected-class="statusFilterCheck"<?php echo $allStatuses ? ' checked="checked"' : '' ?>>
                            <strong>All</strong>
                        </div>
                        <div class="filterColumnRow">
                            <hr/>
                        </div>
                        <?php if(!empty($statusCollection)){ foreach ($statusCollection as $status) { ?>
                            <div class="filterColumnRow">
                                <input type="checkbox"
                                       class="filterCheck statusFilterCheck"<?php echo ($allStatuses || in_array($status->getStatusId(), $filterStatuses)) ? ' checked' : ''; ?>
                                       value="<?php echo $status->getStatusId(); ?>"
                                       data-text-value="<?php echo $status->getText(); ?>"/>
                                <?php echo $status->getText(); ?>
                            </div>
                        <?php }} ?>
                    </div>

                </div>

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
        });

        $(".filterColumnWide .filterColumnHeader").click(function () {
            $(this).parents('.filterColumnWide').toggleClass('filterCollapse');
        });

        $(".filterColumn .filterColumnHeader").click(function () {
            $(this).parents('.filterColumn').toggleClass('filterCollapse');
        });


        // Imported
        $("#newProposalFilterButton").click(function () {
            //hideInfoSlider();
            $("#newProposalFilters").toggle();
            // Clear search so that filters aren't affected
            //oTable.fnFilter('');
            // Hide group action menu
            $(".groupActionsContainer").hide();
        });

    });

</script>

