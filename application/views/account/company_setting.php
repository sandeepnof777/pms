 <div class="nav-box clearfix">
            <div class="nav-right proposal-setting main-account-setting">
            <div class="grid-container">
                <div class="card">
                    <div class="header">
                    <p>Company</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_info') ?>">Company info</a></li>
                    <li><a href="<?php echo site_url('account/company_videos') ?>">Company Videos</a></li>
                    <li><a href="<?php echo site_url('account/company_users') ?>">Users</a></li>
                    <li><a href="<?php echo site_url('account/branches') ?>">Branches</a></li>
                    <li><a href="<?php echo site_url('reports') ?>">Reports</a></li>
                    <li><a href="<?php echo site_url('account/psa') ?>">ProSiteAudit</a></li>


                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Prospect Settings</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/prospect_settings') ?>">Sources</a></li>
                    <li><a href="<?php echo site_url('account/prospect_rating_settings') ?>">Ratings</a></li>
                    <li><a href="<?php echo site_url('account/prospect_status_settings') ?>">Status</a></li>
                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Work</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_workorder') ?>">Work Order - Addresses</a></li>
                    <li><a href="<?php echo site_url('account/work_order_recipients') ?>">Work Order Recipients</a></li>
                    <li><a href="<?php echo site_url('account/company_services') ?>">Scope of Work</a></li>
                    <li><a href="<?php echo site_url('account/bid_approval') ?>">Bid Approval</a></li>
                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Business</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/business_type_settings') ?>">Business Type</a></li>
                    <li><a href="<?php echo site_url('account/company_info') ?>">Summary</a></li>
                    <li><a href="<?php echo site_url('account/event_types') ?>">Calendar/Events</a></li>
                    <li><a href="<?php echo site_url('account/company_logo') ?>">Logo</a></li>
                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Other</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_legal') ?>">Legal</a></li>
                    <li><a href="<?php echo site_url('account/company_attachments') ?>">Attachments</a></li>
                    <li><a href="<?php echo site_url('account/foremen_list') ?>">Foremen</a></li>
                    <li><a href="<?php echo site_url('account/company_email_templates') ?>">Email Templates</a></li>
                    <li><a href="<?php echo site_url('export') ?>">Exports</a></li>
                    <li><a href="<?php echo site_url('account/proposal_filters') ?>">Saved Filters</a></li>

                    </ul>
                </div>

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
                    <p>Lead Settings</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/lead_settings') ?>">Lead Settings</a></li>
                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Layout Settings</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_proposal_settings3') ?>">Layout Settings</a></li>
                    <li><a href="<?php echo site_url('account/company_work_order_sections') ?>">WorkOrder Layout</a></li>
                    <!-- <li><a href="<?php echo site_url('account/company_proposal_notifications') ?>">Automatic Re-Send</a></li> -->
                    <?php echo $checkActive == 0 ? '<li class="sales-targets-li" style="opacity:0.8"><a href="">Automatic Re-Send</a></li>' : '<li><a href="' . site_url('account/company_proposal_notifications') . '">Automatic Re-Send</a></li>'; ?>

                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Sales</p>
                    </div>
                    <ul class="container">
                    <?php echo $checkActive == 0 ? '<li class="sales-targets-li" style="opacity:0.8"><a href="">Sales Targets</a></li>' : '<li><a href="' . site_url('account/sales_targets_config') . '">Sales Targets</a></li>'; ?>

                    
                    <?php echo $checkActiveModify == 0 ? '<li class="sales-targets-li modify-price-swal" style="opacity:0.8"><a href="">Modify Prices</a></li>' : '<li><a href="' . site_url('account/modify_prices') . '">Modify Prices</a></li>'; ?>

                    <!-- <li><a href="<?php echo site_url('account/modify_prices') ?>">Modify Prices</a></li> -->
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


                <?php if ($account->hasFullAccess()) { ?>
                        <div class="card">
                            <div class="header">
                                    <p>QuickBooks</p>
                            </div>
                                <ul class="container">
                                <li><a href="<?php echo site_url('account/qbsettings') ?>">QuickBooks</a>
                                </li>
                                </ul>
                        </div>
                    <?php } ?>

                <div class="card">
                        <div class="header">
                            <p>Exports</p>
                        </div>
                        <ul class="container">
                            <li><a href="<?php echo site_url('export#tabs-1') ?>">Prospects</a></li>
                            <li><a href="<?php echo site_url('export#tabs-2') ?>">Leads</a></li>
                            <li><a href="<?php echo site_url('export#tabs-3') ?>">Contacts</a></li>
                            <li><a href="<?php echo site_url('export#tabs-4') ?>">Proposals</a></li>
                            <li><a href="<?php echo site_url('export#tabs-5') ?>">History</a></li>
                            <li><a href="<?php echo site_url('export#tabs-6') ?>">Services</a></li> 
                        </ul>
                </div>


              </div>
              <!-- <div class="filter-setting"></div>
              <div class="filter-setting-error"></div> -->

            </div>
    
        </div>

<!--#content-->

 
