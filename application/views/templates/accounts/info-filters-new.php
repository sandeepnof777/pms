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
        top: 65px;
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
    .filterCollapse{
        width:33%!important;
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



</style>

<div id="tableFilterContainer" style="position: relative; margin-bottom: 5px;">

<div class="materialize">
        <a class="m-btn grey tiptip filterButton" title="Filter your clients"><i class="fa fa-fw fa-filter"></i> Filters</a>

        <a class="m-btn grey tiptip resetFilterButton" style="display:none" title="Reset All Filters"><i class="fa fa-fw fa-refresh"></i></a>
        
        <a href="<?php echo site_url('accounts'); ?>" class="btn right">
                    <i class="fa fa-chevron-left"></i> All Accounts
        </a>
        <div id="filterBadges"></div>
        <div class="clearfix"></div>
    </div>


    <div class="newFilterContainer">
        <div id="newFilters">

            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif">
                <p id="filterResults"><span id="filterNumResults"></span> Accounts found
                    <a href="#" class="btn ui-button update-button" id="closeFilters2">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
                <a href="#" class="btn ui-button update-button" id="closeFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
            </div>

            <div class="clearfix"></div>

            <div id="topFilterRow">

                <div class="filterColumn filterCollapse" style="width:33%">
                    <div class="filterColumnHeader" id="aUserFilterHeader">
                        User: <span id="userHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allUsers = false;
                    $filterUsers = $this->session->userdata('accFilterAUser') ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('cFilterBranch') ?: [];

                    ?>

                    <div class="filterColumnScroll">

                        <div class="filterColumnRow">
                            <input type="checkbox" class="filterColumnCheck" id="allAUsersCheck"
                                   data-affected-class="aUserFilterCheck"<?php echo $allUsers ? ' checked="checked"' : '' ?>>
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
                                    <input type="checkbox" class="filterCheck aUserFilterCheck aBranchFilterCheck"
                                           data-affected-class="aUserFilterCheck"
                                           data-branch-id="0""<?php echo $allUsers || (in_array(0,
                                        $filterBranches)) ? ' checked' : ''; ?>> <strong>Main Branch</strong>
                                </div>
                            <?php } ?>

                            <?php foreach ($branches as $branch) { ?>
                                <div class="filterColumnRow">
                                    <input type="checkbox" class="filterCheck aUserFilterCheck aBranchFilterCheck"
                                           data-affected-class="aUserFilterCheck"
                                           data-branch-id="<?php echo $branch->getBranchId() ?>"<?php echo ($allUsers || in_array($branch->getBranchId(),
                                            $filterBranches)) ? ' checked' : ''; ?>>
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
                                       class="filterCheck aUserFilterCheck"<?php echo ($allUsers || in_array($acc->getAccountId(),
                                        $filterUsers)) ? ' checked' : ''; ?> value="<?php echo $acc->getAccountId(); ?>"
                                       data-text-value="<?php echo $acc->getFullName(); ?>"
                                       data-branch-id="<?php echo $acc->getBranch(); ?>"/>
                                <?php echo $acc->getFullName(); ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>

                <!-- <div class="filterColumnWide filterCollapse" style="width:33%">
                    <div class="filterColumnRow">
                        <div class="filterColumnHeader containsCalendar" id="createdFilterHeader">
                            Date Range: <span id="createdHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p>
                                <label>From:</label>
                                <input type="text" id="lCreatedFrom" class="text" style="margin-left: 11px;" value="<?php echo ($this->session->userdata('accFilterFrom')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterFrom'))) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="lCreatedTo" value="<?php echo ($this->session->userdata('accFilterTo')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterTo'))) : '' ?>">
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
                </div> -->
                
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(function () {
    var loaded =true;
    applyFilter();


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

            // Removing Account user filter
            $(document).on('click', '#removeCreatedFilter', function () {
                $("#from").val("");
                $("#to").val("");
                $.uniform.update();
                applyFilter();
            });
$(".filterButton").click(function () {
                $(".newFilterContainer").toggle();
                
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
                $.uniform.update();
            });


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
                $("#from").val("");
                $("#to").val("");

                // Reset All Checkboxes
                $(".filterCheck, .filterColumnCheck").prop('checked', true);
                $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

                // Set Active as it's default (by unchecking others)
                $(".statusFilterCheck[value!='Active']").prop('checked', false);

                $.uniform.update();
                applyFilter();

                return false;
            });

            

            $("#from, #pCrelCreatedToatedTo").on('input', function () {
                $("#preset").val('custom');
                $.uniform.update();
                applyFilter();
            });

            $("#preset").change(function () {

                var selectVal = $(this).val();

                if (selectVal) {

                    if (selectVal == 'custom') {
                        $("#from").focus();
                    } else {
                        console.log(selectVal)
                        //var preset = datePreset(selectVal);
                        setDates();
                        // $("#from").val(preset.startDate);
                        // $("#to").val(preset.endDate);
                        applyFilter();
                    }
                }
            });


            // Run the filter by default
            //applyFilter();

            function applyFilter() {
                $("#filterResults").hide();
                $("#filterLoading").hide();
                setTimeout(function () {
                    $(".resetFilter").show();

                    // Users & Branches
                    var users = [];
                    var userValues = [];
                    var aUsers = [];
                    var aUserValues = [];
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
                    var lCreatedFrom = $("#from").val();
                    var lCreatedTo = $("#to").val();

                    // Filter Badges  and UI Update//

                    var filterBadgeHtml = '';
                    var createdHeaderText = ' [ All ]';
                    var userHeaderText = ' [ All ]';
                    var aUserHeaderText = ' [ All ]';
                    var sourceHeaderText = ' [ All ]';
                    var statusHeaderText = ' [ All ]';
                    var dueDateHeaderText = ' [ All ]';
                    var numFilters = 0;


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
                            '<div class="filterBadgeTitle">Users: </div>' +
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
                    } else {
                        $(".filterButton").addClass('update-button');
                        $(".filterButton").removeClass('grey');
                        $('.resetFilterButton').show();
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

                if(loaded){

                    
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('ajax/setAccountsFilter') ?>',
                        data: {


                            accFilterUser: users,
                            accFilterAUser: aUsers,
                            accFilterFrom: lCreatedFrom,
                            accFilterTo: lCreatedTo,
                            accFilterBranch: selectedBranches,
                            accFilterABranch: selectedABranches
                        },
                        dataType: 'JSON',
                        success: function () {
                            loadAccountInfoStats();
                            
                        }
                    });
                }
                loaded =true;
                }, 500);
            }

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
        $("#from").val(from);
        $("#to").val(to);
       
        $(".is_custom_selected").hide();

        $(".show_from_date").text(from);
        $(".show_to_date").text(to);

       ///add functions to refresh
       
    }else{
        $(".is_custom_selected").show();
        var temp_date = moment().format('MM/DD/YYYY');
        $("#from").val(temp_date);
        $("#to").val(temp_date);
        $(".show_from_date").text(temp_date);
        $(".show_to_date").text(temp_date);
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

                    case 'last7d':
                        startDate = moment().subtract(6, 'days');
                        endDate = moment();
                        break;

                    case 'monthtd':
                        startDate = moment().startOf('month');
                        endDate = moment();
                        break;

                    case 'prevmonth':
                        startDate = moment().subtract(1, 'month').startOf('month');
                        endDate = moment().subtract(1, 'month').endOf('month');
                        break;

                    case 'ytd':
                        startDate = moment().startOf('year');
                        endDate = moment();
                        break;

                    case 'prevyear':
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


        });

</script>