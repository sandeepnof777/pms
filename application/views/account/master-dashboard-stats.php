<style type="text/css">



    .filterColumn {
        float: right;
        width: 186px;
        background-color: #dcdcdc;
        border-radius: 10px;
        margin: 0 1px;
    }



    .filterColumn.filterCollapse .filterColumnRow,
    .filterColumn.filterCollapse .filterColumnScroll,
    .filterColumn.filterCollapse .filterSearchBar,
    .filterColumnWide.filterCollapse .filterColumnRowContent {
        display: none;
    }

   

    .filterHeaderToggle:before {
        content: "\f077";
    }

    .filterColumnWide.filterCollapse .filterHeaderToggle:before,
    .filterColumn.filterCollapse .filterHeaderToggle:before {
        content: "\f078";
    }

    

    .filterColumnHeader {
        position: relative;
        text-align: center;
        font-weight: bold;
        border-radius: 8px!important;
       
        cursor: pointer;
        line-height: 20px;
        padding: 3px;
        background: #25AAE1;
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
        top: 8px;
        color: #fff;
        cursor: pointer;
    }

    .filterColumnScroll {
        position: absolute;
        right: 0;
        background-color: #ebedea;
        width: 300px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        padding: 0 5px 10px 5px;
        z-index: 10000;
        border-radius: 5px;
        margin-top: 1px;
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
        margin-top: 1px;
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

    #statType{margin-top: 4px;}
   /* .branchCheckRow,.userCheckRow,.branchCheckHR,.userCheckHR{display: none;} */

   
</style>

<div class="content-box light">

    <div class="box-header clearfix">
        


        <div class="statControl" style="text-align: center; font-style: normal;">


        <div class="left" style="width: 200px;margin-left: 0px;">
                <?php if (($account->getUserClass() > 0) && !$account->getCompany()->isSingleUser()) {
                    $showTabs = true;
                } else {
                    $showTabs = false;
                }
                ?>
                <div id="statType" <?php echo (!$showTabs) ? 'style="visibility: hidden"' : '' ?>>
                    <a href="#" data-type="headline" id="headlineButton" class="statTypeSelector btn update-button statTypeSelected">All Stats</a>
                    <a href="#" data-type="user" id="userButton" class="statTypeSelector btn" style="width: 125px;">Company Breakdown</a>
                </div>
            </div>

            


            <p id="dashboardDateRangeView" style="position: absolute;right: 390px;top: 10px;font-size:15px;font-weight:bold"><i class="fa fa-fw fa-calendar"></i>&nbsp;<span class="dashboardTabFrom" style="top: 1px;position: relative;color: #665874;"></span> - <span class="dashboardTabTo" style="top: 1px;position: relative;color: #665874;"></span></p>

            <p id="dashboardTabsLoader" style="display:none;position: absolute;right: 365px;top: 12px;"><img src="/static/loading_animation.gif"></p>
            



            <span style="text-align: left;position: relative;color: #665874;margin-left: 416px;top: 5px;font-size: 12px;font-weight:bold">Company: </span>
           
            <div class="filterColumn filterCollapse company_filter" style="width: 240px;text-align: left;font-size: 11px;margin-top: 2px;">
            
                    <div class="filterColumnHeader" id="parentCompanyFilter" style="text-align:left;font-size:11px">
                    &nbsp; <span class="showCompanyName" style="width: 190px;float: right;text-align: center;margin-right: 25px;color: #FFF;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;">All</span>
                        <a class="filterHeaderToggle fa fa-fw"></a>
                    </div>

                   

                    <div class="filterColumnScroll" style="max-height: 650px;overflow-y:auto">

                        <div class="filterColumnRow sticky">
                            <input type="checkbox" value="-1" class="filterColumnCheck companyCheck" id="allCOmpanyCheck"
                                   data-affected-class="companyFilterCheck" checked="checked">
                                   <label for="allCOmpanyCheck"><strong>All Companies</strong></label>

                        </div>
                        <?php 
                            foreach($childCompanies as $childCompany){
                                echo '<div class="filterColumnRow">
                                      <input type="checkbox" value="'.$childCompany->companyId.'" id="companyCheck'.$childCompany->companyId.'" class="filterColumnCheck companyCheck companyCheckIds" data-company-name="'.$childCompany->companyName.'" checked="checked"  data-affected-class="companyFilterCheck">
                                      <label for="companyCheck'.$childCompany->companyId.'"><strong>'.$childCompany->companyName.'</strong></label>
                                    </div>';
                                
                            }
                            ?>
                        <div class="branchCheckHR"><hr/><strong style="color:#25AAE1;">Branches</strong></div>
                        

                        <?php
                            // echo "<pre>";print_r($masterBranches);die;
                            // $usersList = array();
                            $j=0;
                            foreach($masterBranches as $companyId => $branches){
                                    foreach($branches as $branch){
                                echo    '<div class="filterColumnRow branchCheckRow" data-company-id="'.$companyId.'">
                                            <input type="checkbox" value="'.$branch['Id'].'" id="branchCheck'.$j.'" checked="checked" class="filterColumnCheck branchCheck" data-company-id="'.$companyId.'" data-affected-class="companyFilterCheck">
                                            <label  for="branchCheck'.$j.'" ><strong class="tiptip" title ="'.$branch['companyName'].'">'.$branch['Name'].' ['.$branch['companyName'].']</strong></label>
                                        </div>';

                                $usersList[$j] = array(
                                    'companyId' =>$companyId,
                                    'branchId' =>$branch['Id'],
                                    'users'     =>$branch['Users']
                                );
                                $j++;
                            }
                        }

                        ?>

                        <div class="userCheckHR"><hr/><strong style="color:#25AAE1;">Users</strong></div>

                        <?php
                            foreach($usersList as $i => $users){
                                    $companyId = $users['companyId'];
                                    $branchId = $users['branchId'];
                                    foreach($users['users'] as $userId => $user){
                                echo    '<div class="filterColumnRow userCheckRow"  data-company-id="'.$companyId.'" data-branch-id="'.$branchId.'">
                                            <input type="checkbox" value="'.$userId.'" checked="checked" class="filterColumnCheck userCheck" data-company-id="'.$companyId.'" data-branch-id="'.$branchId.'" data-affected-class="companyFilterCheck">
                                            <strong>'.$user.'</strong>
                                        </div>';
                            }
                        }

                        ?>

                       
                           
                            <div class="filterColumnRow">
                                <hr/>
                            </div>
                           

                        
                    </div>
                </div>















           

            
        </div>
        

    </div>

    <div class="box-content padded">


        <div id="customDates">
            From: <input type="text" id="customFrom" value="<?php echo ($this->session->userdata('pFilterStatusFrom')) ?: $defaultCustomFrom; ?>"/>
            To: <input type="text" id="customTo" value="<?php echo ($this->session->userdata('pFilterStatusTo')) ?: $defaultCustomTo; ?>"/>
            <a href="#" id="applyCustomDates" class="btn ui-button">Apply</a>
        </div>
        <div class="clearfix"></div>


        <div id="dashboardTabs">
        
        
        <div id="statControls" style="width: 290px;float: right;color: #665874;
    font-size: 12px;
    font-weight: bold;">

                <!-- <span id="statsLoader">
                    <img src="/static/loading.gif"/>
                </span> -->

                <span style="top: 2px;position: relative;">Time Period:</span>
                <select id="statRange" style="width: 100px!important;">
                    <option data-range="year">Year</option>
                    <option data-range="quarter">Quarter</option>
                    <option data-range="month">Month</option>
                    <option data-range="week">Week</option>
                    <option data-range="day">Day</option>
                    <option data-range="prevYear">Previous Year</option>
                    <option data-range="custom">Custom</option>
                </select>

            </div>
        <ul>
                <li style="display: none;">
                    <a href="#startFinish">View 1</a>
                </li>
                <li>
                    <a href="#finish">Proposals</a>
                </li>
                <li>
                    <a href="#leadsStats">Leads View</a>
                </li>
                <?php // Check for config
                if(1) {
                ?>
                <li>
                    <a href="#salesTargets">Sales Targets</a>
                </li>
                 <li>
                    <a href="#businessTypeSales">Business Type</a>
                </li>
                <li>
                    <a href="#statusBreakdown">Status</a>
                </li> 
                
                <?php } ?>
            </ul>

            <div style="display: none;" id="startFinish">
                <?php
                // Include the stat boxes - visible to everyoneh
                $this->load->view('account/headline-stats-sf');

                // Include the stats table - only visible to admins
                if ($account->getUserClass() > 0) {
                    $this->load->view('dashboard/stats-table-sf');
                }
                ?>
            </div>

            <div id="finish">
                <?php
                // Include the stat boxes - visible to everyoneh
                $this->load->view('account/headline-stats');

                // Include the stats table - only visible to admins
               // if ($account->getUserClass() > 0) {
                    $this->load->view('dashboard/stats-table');
               // }
                ?>
            </div>

            <div id="leadsStats">
                <?php
                // Include the stat boxes - visible to everyoneh
                $this->load->view('account/leads-stats');

                // Include the stats table - only visible to admins
               // if ($account->getUserClass() > 0) {
                    $this->load->view('dashboard/stats-table-leads');
                //}
                ?>
            </div>

            <?php
            if (1) { // Set as per config
            ?>
            <div id="salesTargets">
                <?php $this->load->view('dashboard/stats-table-sales-targets'); ?>
            </div>
            <?php
            }
            ?>
              <div id="businessTypeSales">
                <?php $this->load->view('dashboard/stats-table-business-type-sales'); ?>
            </div>
            <div id="statusBreakdown">
                <?php $this->load->view('dashboard/stats-table-status'); ?>
            </div> 
            
        </div>

        <span class="statsReload"><a href="#" id="reload">Reload</a></span>
        <span class="statsReload"><a href="#" id="exportProposal">Export</a></span>


    </div>
    <div class="clearfix"></div>

</div>
