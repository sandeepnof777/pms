 <div class="content-box light">

    <div class="box-header clearfix">
        <div class="left" style="width: 200px;">
            <?php if (($account->getUserClass() > 0) && !$account->getCompany()->isSingleUser()) {
                $showTabs = true;
            } else {
                $showTabs = false;
            }
            ?>
            <div id="statType" <?php echo (!$showTabs) ? 'style="visibility: hidden"' : '' ?>>
                <a href="#" data-type="headline" id="headlineButton" class="statTypeSelector btn update-button statTypeSelected">All Stats</a>
                <a href="#" data-type="user" id="userButton" class="statTypeSelector btn">User Breakdown</a>
            </div>
        </div>


        <div class="statControl" style="text-align: center; font-style: normal;">

            <div id="statControls">

                <!-- <span id="statsLoader">
                    <img src="/static/loading.gif"/>
                </span> -->

                Time Period:
                <select id="statRange" style="width: 100px; !important;">
                    <option data-range="year">Year</option>
                    <option data-range="quarter">Quarter</option>
                    <option data-range="month">Month</option>
                    <option data-range="week">Week</option>
                    <option data-range="day">Day</option>
                    <option data-range="prevYear">Previous Year</option>
                    <option data-range="custom">Custom</option>
                </select>

            </div>

            <?php
            if ((($account->getUserClass() > 0) )) {
                ?>

                <div id="statUserControl">
                    User:
                    <select id="statsUser">

                    <?php
                        if ($account->hasFullAccess()) { ?>
                            <optgroup label="Company">
                                <option value="company" selected="selected">All <?php echo $account->getCompany()->getCompanyName(); ?> users</option>
                            </optgroup>
                            <?php
                            if (count($statBranches)) { ?>
                                <optgroup label="Branches">
                                    <option value="branch" data-branch="0">Main Branch
                            <?php
                                foreach ($statBranches as $statBranch) {
                            ?>
                                    <option value="branch" data-branch="<?php echo $statBranch->getBranchId(); ?>"><?php echo $statBranch->getBranchName(); ?></option>
                            <?php
                                }
                            ?>
                                </optgroup>
                            <?php
                            }

                        }
                        else if ($account->getUserClass() == 1) { // Branch Manager

                            // Handle non main branch
                            if ($account->getBranch() > 0) {
                                ?>
                                <optgroup label="Branch">
                                    <option value="branch"
                                            data-branch="<?php echo $branch->getBranchId(); ?>"><?php echo $branch->getBranchName(); ?>
                                </optgroup>
                            <?php } // Now main branch
                            else { ?>
                                <optgroup label="Branch">
                                    <option value="branch"
                                            data-branch="0">Main
                                </optgroup>
                        <?php }
                        }

                        if ($account->isBranchAdmin() || $account->hasFullAccess()) {
                            ?>
                            <optgroup label="Me">
                                <option value="user"
                                        data-account="<?php echo $account->getAccountId(); ?>"><?php echo $account->getFullName(); ?></option>
                            </optgroup>
                            <optgroup label="Users">
                                <?php
                                foreach ($sortedAccounts as $compAccount) {
                                    //$sortedAccounts = $compAccount->getFullName();
                                    /* @var $compAccount \models\Accounts */

                                    // Don't show own name
                                    if ($account->getAccountId() != $compAccount->getAccountId()) {
                                        ?>
                                        <option
                                                value="user"
                                                data-account="<?php echo $compAccount->getAccountId(); ?>"><?php echo $compAccount->getFullName(); ?></option>
                                        <?php
                                    }
                                } ?>
                            </optgroup>
                            <?php
                        } else {
                            ?>
                            <option value="user"
                                    data-account="<?php echo $account->getAccountId(); ?>"><?php echo $account->getFullName(); ?></option>
                            <?php
                        }
                    ?>
                    </select>
                </div>

            <?php
            } else {
                
                if($account->getCompany()->isSingleUser()){?>
                    <input id="statsUser" type="hidden" value="company" />
                <?php 
                }else{
                ?>
                
                <input id="statsUser" type="hidden" value="user" data-account="<?php echo $account->getAccountId(); ?>"/>
            <?php
                }    
            }
            ?>

            <div class="help tiptip center" style="position: absolute; right: 10px; top:9px; " title="Help"><?php echo help_box(92, true) ?></div>

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
        <p id="dashboardTabsLoader" style="display:none;position: absolute;right: 22px;top: 8px;"> <img src="/static/loading_animation.gif"></p>
        <p id="dashboardDateRangeView" style="position: absolute;right: 25px;top: 10px;font-size:15px;font-weight:bold"><i class="fa fa-fw fa-calendar"></i>&nbsp;<span class="dashboardTabFrom" style="top: 1px;position: relative;"></span> - <span class="dashboardTabTo" style="top: 1px;position: relative;"></span></p>
        <ul>
                <li style="display: none;">
                    <a href="#startFinish">View 1</a>
                </li>
                <li>
                    <a href="#finish">Proposals</a>
                </li>
                <li class="LeadTabCheck">
                    <a href="#leadsStats">Leads View</a>
                </li>
                <?php // Check for config
                if(1) {
                ?>
                <!-- <li>
                    <a href="#salesTargets">Sales Targets</a>
                </li> -->
                <li class="<?php echo  $checkTabActive === 0 ? 'disabled-tab' : '' ?>">
                   <a href="#salesTargets">Sales Targets</a>
                 </li>
                <li class="<?php echo  $checkTabActive === 0 ? 'disabled-tab' : '' ?>">
                    <a href="#businessTypeSales">Business Type</a>
                </li>
                <li class="<?php echo  $checkTabActive === 0 ? 'disabled-tab' : '' ?>">
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
                if ($account->getUserClass() > 0) {
                    $this->load->view('dashboard/stats-table');
                }
                ?>
            </div>

            <div id="leadsStats">
                <?php
                // Include the stat boxes - visible to everyoneh
                $this->load->view('account/leads-stats');

                // Include the stats table - only visible to admins
                if ($account->getUserClass() > 0) {
                    $this->load->view('dashboard/stats-table-leads');
                }
                ?>
            </div>

            <?php
            if (1) { // Set as per config
            ?>
            <div id="salesTargets">
                <?php $checkTabActive === 0 ? "" : $this->load->view('dashboard/stats-table-sales-targets'); ?>
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

    </div>
    <div class="clearfix"></div>

</div>
