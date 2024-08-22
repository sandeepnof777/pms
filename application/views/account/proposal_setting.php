             <div class="nav-right proposal-setting">
            <div class="grid-container">

                <div class="card">
                    <div class="header">
                    <p>Proposal</p>
                    </div>
                    <ul class="container">
                        <li><a href="<?php echo site_url('account/company_proposal_settings7') ?>">Proposal Links</a></li>
                        <li><a href="<?php echo site_url('account/company_proposal_statuses') ?>">Proposal Statuse</a></li>
                        <li><a href="<?php echo site_url('account/company_proposal_sections') ?>">Proposal Layout</a></li>



                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Layout Settings</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_proposal_settings3') ?>">Layout Settings</a></li>
                    <li><a href="<?php echo site_url('account/company_work_order_sections') ?>">WorkOrder Layout</a></li>
                    <li><a href="<?php echo site_url('account/company_proposal_notifications') ?>">Automatic Re-Send</a></li>



                    
                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Others</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/sales_targets_config') ?>">Sales Targets</a></li>
                    <li><a href="<?php echo site_url('account/modify_prices') ?>">Modify Prices</a></li>
                    <li><a href="<?php echo site_url('account/company_proposal_settings4') ?>">Job #</a></li>
                    <li><a href="<?php echo site_url('account/company_proposal_details') ?>">Custom Texts</a></li>
                    <li><a href="<?php echo site_url('account/company_proposal_settings2') ?>">About company</a></li>

                    </ul>
                </div>
                <?php if ($account->hasEstimatingPermission()) { ?>
                <div class="card">
                    <div class="header">
                    <p>Estimating</p>
                    </div>
                    <ul class="container">
                 
                    <li><a href="<?php echo site_url('account/estimating_settings') ?>">Estimating</a></li>
                    <li><a href="<?php echo site_url('account/estimating_reports') ?>">Estimating Reports</a></li>
                    <li><a href="<?php echo site_url('account/job_cost_reports') ?>">Job Cost Reports</a></li>
                   
                    </ul>
                </div>
                <?php } ?>
              </div>
              <!-- <div class="filter-setting"></div>
              <div class="filter-setting-error"></div> -->
            </div>
<!--#content-->
 
 
