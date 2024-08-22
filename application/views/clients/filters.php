<style type="text/css">
    div.sticky {
        position: -webkit-sticky;
        position: sticky;
        background-color: #DCDCDC;
        top: 0px;
        
    }
    #newResetClientFilterButton2 {
        display: none;
        color: #505050;
        cursor: pointer;
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

    #newClientColumnFilters {
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

    #newClientColumnFilters label {
        font-weight: bold;
    }
    #uniform-saves_filter_list{
        position: absolute;
        left: 5px;
        top: 5px;
    }
</style>

<div id="tableFilterContainer" style="position: relative; ">

    <div class="materialize">

        <div style="width: 70%;float:left">
            <a class="m-btn grey tiptip filterButton" title="Filter your clients"><i class="fa fa-fw fa-filter"></i>
                Filters</a>
            <a class="m-btn grey tiptip resetFilterButton" title="Reset All Filters"><i class="fa fa-fw fa-refresh"></i></a>
        
            <div class="m-btn groupAction tiptip" style="position: relative;" title="Carry out actions on selected contacts"
             id="groupActionsButton">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                <div class="groupActionsContainer materialize">
                    <div class="collection groupActionItems" id="clientGroupActions">
                        <a href="#" id="groupEmail" class="collection-item iconLink">
                            <i class="fa fa-fw fa-envelope"></i> Send Email
                        </a>
                        <a href="#" id="groupDelete" class="collection-item iconLink">
                            <i class="fa fa-fw fa-trash"></i> Delete Contacts
                        </a>
                        <a href="#" id="groupAccount" class="collection-item iconLink">
                            <i class="fa fa-fw fa-external-link-square"></i> Change Account
                        </a>
                        <a href="#" id="changeBusinessType" class="collection-item iconLink changeBusinessType">
                            <i class="fa fa-fw fa-briefcase"></i> Change Business Type
                        </a>
                        <a href="#" id="groupReassign" class="collection-item iconLink">
                            <i class="fa fa-fw fa-random"></i> Reassign Owner
                        </a>
                        <a href="#" id="groupExcludeResend" class="collection-item iconLink">
                            <i class="fa fa-fw fa-envelope-open-o"></i> Email Off
                        </a>
                        <a href="#" id="groupIncludeResend" class="collection-item iconLink">
                            <i class="fa fa-fw fa-envelope-open-o"></i> Email On
                        </a>
                    </div>
                </div>
        </div>
        
            <div id="filterBadges"></div>
    </div>
    <div style="width: 30%;float:right">
        <?php
        
        if (count($resends) > 0) {
            $display = 'block';
        } else {
            $display = 'none';
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
                                <a href="<?php echo site_url('account/upload_data') ?>" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-upload" ></i> Upload Contacts
                                </a>
                                
                            </li>
                            <li style="display: <?=$display;?>;">
                                <a href="<?= site_url('clients/group_resends'); ?>" id="proposalMapLink" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-envelope" ></i> Campaigns [<?=count($resends);?>]
                                </a>
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
                <a href="<?=site_url('clients/group_resends');?>" class="m-btn grey tiptip " style="float:right;margin-left:5px;padding:0px 5px;display:<?= $display; ?>" title="Campaigns "><i class="fa fa-fw fa-envelope"></i> <span class="campaign_count_btn"><?=count($resends);?></span></a>
                <a href="JavaScript:void('0');" class="m-btn blue-button right add_contact_btn" ><i class="fa fa-fw fa-plus"></i>
                Add Contact</a>
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
                <p id="filterResults" style="height: 18px;"><span id="filterNumResults"></span> Contacts found
                    
                    <a class="btn ui-button tiptip" title="Reset All Filters" style="position: absolute;display: inline;font-size: 13px;top: 4px;right: 247px;" id="newResetClientFilterButton2"><i class="fa fa-fw fa-refresh"></i> Reset</a>
                    <a href="#" class="btn ui-button update-button" id="closeFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
            </div>

            <div class="clearfix"></div>

            <div id="topFilterRow">

                <div class="filterColumn filterCollapse" style="width: 33%">
                    <div class="filterColumnHeader" id="userFilterHeader">
                        User: <span id="userHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                    <?php
                    $allUsers = false;
                    $filterUsers = $this->session->userdata('cFilterUser') ?: [];

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

                <div class="filterColumn filterCollapse" style="width: 33%">
                    <div class="filterColumnHeader" id="accountFilterHeader">
                        Account: <span id="accountHeaderText"></span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <div class="filterSearchBar">
                        <input class="text filterSearch" type="text" placeholder="Search Accounts" id="accountSearch"/>
                        <a class="filterSearchClear">&times;</a>
                    </div>

                    <?php
                    $allAccounts = false;
                    $filterAccounts = $this->session->userdata('cFilterClientAccount') ?: [];

                    if (!count($filteredClientAccounts)) {
                        $allAccounts = true;
                    }
                    ?>
                    <div class="filterColumnScroll" id="accountsFilterColumn">

                        <div class="filterColumnRow sticky" id="accountRowAll">
                            <input type="checkbox" id="allClientAccounts" class="filterColumnCheck"
                                   data-affected-class="clientAccountFilterCheck"<?php echo $allAccounts ? ' checked="checked"' : '' ?>>
                            <strong>All Accounts</strong>
                            <hr/>
                        </div>
                        <!-- <?php //foreach ($filteredClientAccounts as $clientAccount) { ?>
                            <div class="filterColumnRow searchSelectedRow">
                                <input type="checkbox" class="filterCheck clientAccountFilterCheck searchSelected"
                                       checked="checked" value="<?php //echo $clientAccount->getId(); ?>"
                                       data-text-value="<?php //echo $clientAccount->getName(); ?>"/>
                                <span class="accountName"><?php //echo $clientAccount->getName(); ?></span>
                            </div>
                        <?php //} ?> -->
                        <?php 
                                if (is_array($filteredClientAccounts)) { // Check if $filteredClientAccounts is an array
                                    foreach ($filteredClientAccounts as $clientAccount) { 
                                        if (is_object($clientAccount)) { // Check if $clientAccount is an object
                                ?>
                                            <div class="filterColumnRow searchSelectedRow">
                                                <input type="checkbox" class="filterCheck clientAccountFilterCheck searchSelected"
                                                    checked="checked" value="<?php echo $clientAccount->getId(); ?>"
                                                    data-text-value="<?php echo $clientAccount->getName(); ?>"/>
                                                <span class="accountName"><?php echo $clientAccount->getName(); ?></span>
                                            </div>
                                <?php 
                                        } else {
                                            // Handle the case where $clientAccount is not an object
                                            echo "Error: Invalid client account data.";
                                        }
                                    } 
                                } else {
                                    // Handle the case where $filteredClientAccounts is not an array
                                    echo "Error: No client accounts found.";
                                }
?>


                       

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
                
                    $filterBusinessTypes = $this->session->userdata('cFilterBusinessType') ?: [];

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
            </div><!--close top row div-->
            <div class="clearfix"></div>
            <div class="filterRow" style="padding-top: 2px;">
                <div class="filterColumn filterCollapse" style="width: 33%;margin-top: 2px;">

                    <div class="filterColumnHeader containsCalendar" id="excludeIncludeFilterHeader">
                        Campaigns: <span id="excludeIncludeHeaderText">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>
                    <div class="filterColumnScroll" id="excludeIncludeFilterColumn">

                        <div class="filterColumnRow">
                                <input type="checkbox" id="cResendInclude" <?php  if($this->session->userdata('cResendInclude')!=null) { echo ($this->session->userdata('cResendInclude')==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?> class="filterCheck excludeCheck otherFilterCheck"  data-text-value="Email On "  value="1"> Email On
                        </div> 
                        <div class="filterColumnRow">        
                            <input type="checkbox" id="cResendExclude" <?php  if($this->session->userdata('cResendExclude')!=null) { echo ($this->session->userdata('cResendExclude')==1) ? 'checked="checked"':'';}else{echo 'checked="checked"';} ?> class="filterCheck excludeCheck otherFilterCheck"  data-text-value="Email Off"  value="1"> Email Off
                        </div>  
                    </div>
                </div>        


            </div>
        </div>
    </div>


    <div id="newClientColumnFilters">


        <h4>Show / Hide Table Columns</h4>
        <a class="close_column" href="javascript:void(0);">×</a>
        <div style="padding-top:15px;position: absolute;top: -5px;left: 225px;"><a href="javascript:void(0);"
                                                                                   id="select_p_column_all">All</a> / <a
                    href="javascript:void(0);" id="select_p_column_none">None</a></div>
        <div class="clearfix"></div>

        <div class="filterRow" style="margin-top:2px">

            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="2"><span
                        style="margin-top: 3px;position: absolute;">Account</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="3"><span
                        style="margin-top: 3px;position: absolute;">Business</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="4"><span
                        style="margin-top: 3px;position: absolute;">Full Name</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="5"><span
                        style="margin-top: 3px;position: absolute;">Email</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="6"><span
                        style="margin-top: 3px;position: absolute;">Cell Phone</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="7"><span
                        style="margin-top: 3px;position: absolute;">Proposals Count</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="8"><span
                        style="margin-top: 3px;position: absolute;">Bid Total</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="9"><span
                        style="margin-top: 3px;position: absolute;">Owner</span>
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" class="column_show" name="column_show" value="11"><span
                        style="margin-top: 3px;position: absolute;">Last Activity</span>
            </label>
            

            <a href="javascript:void(0);" style="float:right" class="column_show_apply btn blue">Apply</a>
        </div>

        <div class="clearfix filterRow"></div>


    </div>
</div>




