<style type="text/css">
 #newResetAccountFilterButton2 {
        display: none;
        color: #505050;
        cursor: pointer;
    }
div.sticky {
        position: -webkit-sticky;
        position: sticky;
        background-color: #DCDCDC;
        top: 0px;
        z-index: 100;
    }
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
        /* position: relative; */
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
        padding-top: 0px;
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
    #uniform-preset{
        float: right;
        
    }

    #uniform-saves_filter_list{
        position: absolute;
        left: 5px;
        top: 5px;
    }

</style>

<div id="tableFilterContainer" style="position: relative; margin-bottom: 10px;">

<div >
    <div style="width: 58%;float:left" class="materialize">
        <a class="m-btn grey tiptip filterButton" title="Filter your clients"><i class="fa fa-fw fa-filter"></i> Filters</a>
        <div class="m-btn groupAction tiptip" style="position: relative;float:left;margin-right: 10px;" title="Carry out actions on selected contacts" id="groupActionsButton">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize">
                <div class="collection groupActionItems" id="clientGroupActions">
                    <a class="collection-item iconLink groupAction" id="groupMerge"><i class="fa fa-fw fa-compress"></i> Merge</a>
                    <a class="collection-item iconLink groupAction changeBusinessType" id="changeBusinessType"><i class="fa fa-fw fa-briefcase"></i> Change Business Type</a>
                    <?php if ($account->isAdministrator()) { ?>
                    <a class="collection-item iconLink groupAction" id="groupDelete"><i class="fa fa-fw fa-trash"></i> Delete</a>
                    <?php } ?>

                    <!-- <a class="collection-item iconLink sendEmail" href="#" ><i class="fa fa-fw fa-envelope-o"></i> Send Email</a>
                    <a class="collection-item iconLink resend" href="#" ><i class="fa fa-fw fa-reply"></i> Resend</a>
                     -->
                </div>
            </div>
        </div>

        <a class="m-btn grey tiptip resetFilterButton" title="Reset All Filters"><i class="fa fa-fw fa-refresh"></i></a>
        
        <div id="filterBadges"></div>
        </div>
        <div style="width: 42%;float:right">
            <div class="account-datepickers" >

                <select name="preset" id="preset"  style="float: right;">
                    <option value="ytd">Year to Date (default)</option>
                    <option value="custom">Custom</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last7d">Last 7 Days</option>
                    <option value="monthtd">Month to Date</option>
                    <option value="prevmonth">Previous Month</option>
                    <option value="prevyear">Previous Year</option>
                    <option value="all">All Time</option>
                </select>

                <input class="text hide is_custom_selected" type="text" style="width: 64px;" name="aCreatedFrom" id="aCreatedFrom" value="<?= date('1/1/Y') ?>">
                <input class="text hide is_custom_selected" type="text" style="width: 64px;" name="aCreatedTo" id="aCreatedTo" value="<?= date('m/d/Y') ?>">
                <input type="button" value="Apply" id="apply" class="inline-form-button hide is_custom_selected" >
                <input type="button" value="Reset" id="reset" class="inline-form-button hide">
                <p class="is_custom_not_selected" style="float:right;font-size:15px;margin-right:8px;margin-top: 5px;font-weight:bold"><i class="fa fa-fw fa-calendar"></i> <span class="show_from_date"><?= date('01/01/Y') ?></span> - <span class="show_to_date"><?= date('m/d/Y') ?></span></p>
            </div>
        </div>
        
        <div class="clearfix"></div>
    </div>


    <div class="newFilterContainer">
        <div id="newFilters">
        <?php if($this->uri->segment(2) ==''){ ?>

            <select name="saves_filter_list" style="float:left;border-radius: 3px;padding: 0.1em;"  id="saves_filter_list">
                <option value="">- Saved Filters</option>
                
                <?php if(count($save_filters)>0){?>
                
                    <?php
                    foreach($save_filters as $saved_filter){
                        echo "<option  data-default-filter='0' data-filter='".$saved_filter->filter_data."' value='".$saved_filter->id."'>".$saved_filter->filter_name."</option>";
                    }
                    ?>
                
                <?php }?>
            </select>
            <a href="#" class="btn ui-button tiptip" title="Save Filter" id="saveFilter" style="position: absolute;left: 203px;font-size: 10.7px;padding: 0px 4px;top: 7px;"><i class="fa fw fa-floppy-o"></i></a>
        <?php } ?>
            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif">
                <p id="filterResults" style="height: 18px;"><span id="filterNumResults"></span> Accounts found

                <a class="btn ui-button tiptip" title="Reset All Filters" style="position: absolute;display: inline;font-size: 13px;top: 4px;right: 247px;" id="newResetAccountFilterButton2"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                    <a href="#" class="btn ui-button update-button" id="closeFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
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
                    $filterUsers = $this->session->userdata('accFilterUser') ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('cFilterBranch') ?: [];

                    ?>

                    <div class="filterColumnScroll">

                        <div class="filterColumnRow sticky">
                            <input type="checkbox" class="filterColumnCheck" id="allAUsersCheck"
                                   data-affected-class="aUserFilterCheck"<?php echo $allUsers ? ' checked="checked"' : '' ?>>
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

                
                <div class="filterColumn filterCollapse" style="width:33%">
                    <div class="filterColumnHeader" id="userFilterHeader">
                        Owner: <span id="aUserHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allUsers = false;
                    $filterUsers = $this->session->userdata('accFilterUser') ?: [];

                    if (!count($filterUsers) || (count($filterUsers) == count($accounts))) {
                        $allUsers = true;
                    }

                    $filterBranches = $this->session->userdata('cFilterBranch') ?: [];

                    ?>

                    <div class="filterColumnScroll">

                        <div class="filterColumnRow sticky">
                            <input type="checkbox" class="filterColumnCheck" id="allUsersCheck"
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
                            <?php
                        }
                        ?>
<?php foreach ($accounts as $acc) { ?>
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



                <!--Business Type Filter-->
                <div class="filterColumn filterCollapse" style="width: 33%">

                    <div class="filterColumnHeader containsCalendar" id="businessTypeFilterHeader">
                        Business Type: <span id="businessTypeHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <?php
                    $allBusinessTypes = false;
                
                    $filterBusinessTypes = $this->session->userdata('accFilterBusinessType') ?: [];

                    if (!count($filterBusinessTypes)) {
                        $allBusinessTypes = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="businessTypeFilterColumn">

                        <div class="filterColumnRow sticky" id="businessTypeRowAll">
                            <input type="checkbox" id="allBusinessTypes" class="filterColumnCheck"
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



            </div>
        </div>
    </div>
</div>



