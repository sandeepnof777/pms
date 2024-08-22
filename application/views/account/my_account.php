<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="nav-box clearfix">
            <?php $this->load->view('account/account_sidebar'); ?>
            <div class="nav-right">
                <div class="content-box">
                    <div class="nav-header">
                        <?php
                        /* Company Info sub-nav */
                        if (in_array($this->uri->segment(2), array('my_account','company_info', 'edit_company_info', 'company_logo', 'company_users', 'edit_user', 'add_user', 'company_workorder',
                            'company_edit_workorder', 'add_work_order_address', 'edit_work_order_address', 'work_order_recipients', 'branches', 'bid_approval','foremen_list'))
                        ) {
                            ?>
                            <h2>
                                Company Information
                                <?php if (help_box(9)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(9, true) ?></div>
                                <?php } ?>
                               
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_info', 'edit_company_info'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_info') ?>">Summary</a></li>
                                <?php if ($account->isAdministrator()) { ?>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_users', 'edit_user', 'add_user'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_users') ?>">Users</a></li>
                                    <li><a class="<?php echo ($this->uri->segment(2) == 'branches') ? 'active' : ''; ?>" href="<?php echo site_url('account/branches') ?>">Branches</a></li>
                                    <li><a class="<?php echo ($this->uri->segment(2) == 'company_logo') ? 'active' : ''; ?>" href="<?php echo site_url('account/company_logo') ?>">Logo</a></li>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_workorder', 'company_edit_workorder', 'add_work_order_address', 'edit_work_order_address'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_workorder') ?>">Work Order - Addresses</a></li>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('work_order_recipients', 'add_work_order_recipient'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/work_order_recipients') ?>">Work Order Recipients</a></li>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('bid_approval', 'bid_approval'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/bid_approval') ?>">Bid Approval</a></li>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('foremen_list', 'add_foremen'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/foremen_list') ?>">Foremen</a></li>
                                <?php } ?>
                            </ul>

                            <?php
                        }/* My Info sub-nav */
                        if (in_array($this->uri->segment(2), array('my_info'))) {
                            ?>
                            <h2>
                                User Information
                            </h2>
                            <ul class="nav-bar">
                                <li>&nbsp;</li>
                            </ul>

                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_proposal_settings', 'company_proposal_settings2', 'company_proposal_settings3', 'company_proposal_settings4',
                            'company_proposal_settings5', 'company_proposal_settings6', 'company_proposal_settings7', 'company_proposal_notifications','company_proposal_sections','company_work_order_sections', 'company_settings', 'company_proposal_intro'))) {
                              ?>
                            <h2>
                                Proposal Settings
                                <?php if (help_box(58)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(58, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings2'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings2') ?>">About Company</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings3', 'company_proposal_settings', 'company_proposal_settings6', 'company_proposal_settings5'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings3') ?>">Layout
                                        Settings</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings4'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings4') ?>">Job #</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings7'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings7') ?>">Proposal Links</a></li>
                                <?php if($checkActive==0){ ?>
                                  <li><a class="automatic-resend-li <?php echo (in_array($this->uri->segment(2), array('company_proposal_notifications'))) ? 'active' : ''; ?>" href="#">Automatic Re-Send</a></li>
                                <?php } else{ ?>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_notifications'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_notifications') ?>">Automatic Re-Send</a></li>
                                <?php }  ?>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_sections'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_sections') ?>">Proposal Layout</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_work_order_sections'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_work_order_sections') ?>" style="padding: 0 14px;">WorkOrder Layout</a></li>
                               <!-- <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_intro'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_intro') ?>">Company Intro</a></li>  
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_settings') ?>">Proposal Signature</a></li>  -->
                            </ul>
                            <?php
 
                        }
                        //prospect nav
                        if (in_array($this->uri->segment(2), array('prospect_settings', 'prospect_rating_settings', 'prospect_status_settings'))) {
                        ?>
                            <h2>
                                Prospect Settings
                                <?php if (help_box(58)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(58, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('prospect_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/prospect_settings') ?>">Sources</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('prospect_rating_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/prospect_rating_settings') ?>">Rating</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('prospect_status_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/prospect_status_settings') ?>">Status</a></li>
                            </ul>
                        <?php
                        }

                        //end prospect nav
                       
                        if (in_array($this->uri->segment(2), array('lead_settings', 'lead_settings2'))) {
                            ?>
                            <h2>
                                Lead Settings
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('lead_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/lead_settings') ?>">Unassigned Leads Notifications</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('lead_settings2'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/lead_settings2') ?>">Lead Sources</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_services', 'edit_service'))) {
                            ?>
                             <!-- <a style="float: right;margin-right: 20px;margin-top: 12px;font-size: 14px;font-weight: bold;" href="<?php echo site_url('account/my_account') ?>">Back</a> -->
                            <h2>
                                Scope of Work
                                <?php if (help_box(53)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(53, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li>&nbsp;</li>
                            </ul>
                            <?php
                        }

                        if (in_array($this->uri->segment(2), array('company_videos'))) {
                            ?>
                        
                            <h2>
                                Company Videos
                                
                            </h2>
                            <!-- add a back button  -->
                            &nbsp;
                                <!-- <a style="float:right;margin-right:15px;font-weight:bold;margin-top:25px;" href="<?php echo site_url('account/my_account') ?>">Back</a> -->
                            <ul class="nav-bar">

                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_videos'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_videos') ?>">Video Library</a></li>
                            </ul>
                           
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_proposal_details'))) {
                            ?>
                            <h2>
                                Custom Texts
                                <?php if (help_box(55)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(55, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo ($this->uri->segment(2) == 'company_proposal_details') ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_details') ?>">All Texts</a></li>
                                <li><a href="#" id="addcat">Add Category</a></li>
                                <li><a href="#" id="addtext">Add Text</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_legal', 'company_legal2', 'company_legal3'))) {
                            ?>
                            <h2>
                                Legal
                                <?php if (help_box(59)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(59, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_legal'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_legal') ?>">Contract Copy </a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_legal2'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_legal2') ?>">Payment Term </a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_legal3'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_legal3') ?>">Payment Default Days</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_attachments', 'company_add_attachment', 'edit_attachment'))) {
                            ?>
                                                       
                            <!-- add a back button  -->
                             &nbsp;
                            <!-- <a style="float:right;margin-top:27px;font-size:14px;margin-right:10px;font-weight:bold;" href="<?php echo site_url('account/my_account') ?>">Back</a> -->
                            <h2>
                                Company Attachments
                                <?php if (help_box(18)) { ?>
                                    
                                    <div class="help right tiptip" title="Help"><?php help_box(18, true) ?></div>
                                   
                                <?php } ?>
                            </h2>
                           

                            <ul class="nav-bar">
                                <li>&nbsp;</li>
                            </ul>
                            <?php
                        }
                        /*Proposal Statuses*/
                        if (in_array($this->uri->segment(2), array('company_proposal_statuses'))) {
                            ?>
                            <!-- add a back button  -->
                            &nbsp;
                            <!-- <a style="float:right;margin-top:27px;font-size:14px;margin-right:10px;font-weight:bold;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
                            <h2>
                                Proposal Statuses
                                <?php if (help_box(88)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(88, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li>&nbsp;</li>
                            </ul>
                            <?php
                        }
                        /*Email Templates*/
                        if (in_array($this->uri->segment(2), array('company_email_templates'))) {
                            ?>
                            <h2>
                                Company Email Templates
                                <?php if (help_box(90)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(90, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <?php
                                foreach ($templateTypes as $templateType) {
                                    /** @var $templateType \models\ClientEmailTemplateType */
                                    ?>
                                    <li>
                                        <a href="<?php echo site_url('account/company_email_templates/' . $templateType->getTypeId()) ?>" class="typeLink typeLink_<?php echo $templateType->getTypeId() ?>" style="font-weight: normal !important;" data-type-id="<?php echo $templateType->getTypeId() ?>"><?= $templateType->getTypeName() ?></a>
                                    </li>
                                 
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                        /* Services*/
                        if (in_array($this->uri->segment(2), array('services'))) {
                            ?>
                            <h2>
                                Services
                                <?php if (help_box(90)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(90, true) ?></div>
                                <?php } ?>
                            </h2>
                            <?php
                        }
                        /*Reminders*/
                        if (in_array($this->uri->segment(2), array('event_types'))) {
                            ?>
                            <h2>
                                Calendar / Events Settings
                                <?php if (help_box(55) && 1) { ?>
                                    <!--<div class="help right tiptip" title="Help"><?php help_box(55, true) ?></div>-->
                                <?php } ?>
                            </h2>
                             <!-- add a back button  -->
                            &nbsp;
                                <!-- <a style="font-size:14px;float:right;margin-right:10px; font-weight:bold;margin-top:22px;" href="<?php echo site_url('account/my_account') ?>">Back</a> -->
                            <ul class="nav-bar">
                                <li><a class="<?php echo ($this->uri->segment(2) == 'event_types') ? 'active' : ''; ?>" href="<?php echo site_url('account/event_types') ?>">Event Types</a></li>
                                <!--                                <li><a class="--><?php //echo ($this->uri->segment(2) == 'automatic_reminders') ? 'active' : ''; ?><!--" href="--><?php //echo site_url('account/automatic_reminders') ?><!--">Scheduled Events</a></li>-->
                            </ul>
                            <?php
                        }
                        /* Company Info sub-nav */
                        if (in_array($this->uri->segment(2), array('sales_targets', 'sales_targets_config', 'sales_targets_users_config'))
                        ) {
                            ?>
                             <h2>
                                Sales Targets
                            </h2>
                            <ul class="nav-bar">
                                <!--<li><a class="--><?php //echo (in_array($this->uri->segment(2), array('sales_targets'))) ? 'active' : ''; ?><!--" href="--><?php //echo site_url('account/sales_targets') ?><!--">Stats</a></li>-->
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('sales_targets_config'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/sales_targets_config') ?>">Company Default</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('sales_targets_users_config'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/sales_targets_users_config') ?>">User Targets</a></li>
                              <!-- add a back button  -->
                                <li class="right" style="margin-right:5px;">
                                    <!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="btn blue">Back</a> -->
                                </li>
                                <?php if (in_array($this->uri->segment(2), array('sales_targets_users_config'))) { ?>
                                    <li class="right" style="float:right;margin-right:5px;">
                                        <a class="btn blue saveConfig"><i class="fa fa-fw fa-save"></i> Save User Targets</a>
                                    </li>
                                   
                                 <?php } ?>
                            </ul>
                            <?php
                        }
                        /* Company Info sub-nav */
                        if (in_array($this->uri->segment(2), array('modify_prices', 'modify_prices_history'))
                        ) {
                            ?>
                            <!-- <a style="color:#999;float: right;margin-right: 20px;margin-top: 12px;font-size: 14px;font-weight: bold;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->

                            <h2>
                                Modify Prices
                            </h2>
                            <ul class="nav-bar">
                                <!--<li><a class="--><?php //echo (in_array($this->uri->segment(2), array('sales_targets'))) ? 'active' : ''; ?><!--" href="--><?php //echo site_url('account/sales_targets') ?><!--">Stats</a></li>-->
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('modify_prices'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/modify_prices') ?>">Modify Prices</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('modify_prices_history'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/modify_prices_history') ?>">Modify Price History</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('estimating', 'estimating_categories',
                            'estimating_types', 'estimating_items', 'estimating_templates', 'estimating_settings',
                            'estimating_plants', 'estimating_dumps','estimating_subs','estimating_crews', 'estimating_phases', 'estimating_item_upload'))
                        ) {
                            ?>
                            <h2>
                                Estimating
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_settings') ?>">Estimating Settings</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating') ?>">Categories</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_types'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_types') ?>">Types</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_items'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_items') ?>">Items</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_templates'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_templates') ?>">Assemblies</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_plants'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_plants') ?>">Plants</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_dumps'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_dumps') ?>">Dumps</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_subs'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_subs') ?>">Subs</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_phases'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_phases') ?>">Phases</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('estimating_reports', 'estimating_price_report', 'estimating_material_report','estimating_equipment_report','estimating_labor_report','estimating_services_report'))
                        ) {
                            ?>
                            <h2>
                                Estimating Reports
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_price_report'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_price_report') ?>">Pricing Report</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_material_report'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_material_report') ?>">Material Report</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_equipment_report'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_equipment_report') ?>">Equipment Report</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_labor_report'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_labor_report') ?>">Labor Report</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('estimating_services_report'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/estimating_services_report') ?>">Services Report</a></li>
                            </ul>
                            <?php
                        }
                        if (in_array($this->uri->segment(2), array('job_cost_reports'))
                        ) {
                            ?>
                            <h2>
                            Job Cost Reports
                            </h2>
                            <!-- add a back button  -->
                            <!-- <a style="float: right;margin-right: 20px;margin-top: 12px;font-size: 14px;font-weight: bold;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
                            <?php
                        }
                        
                        
                         if (in_array($this->uri->segment(2), array('group_resends'))
                        ) {
                            ?>
                            <h2>
                            Group Resend
                            </h2>
                            
                            <?php
                        }
                        
                        ?>
                        
                    </div>
                    <div class="nav-content clearfix">
                        <?php if ((in_array($this->uri->segment(2), array('company_proposal_settings3', 'company_proposal_settings', 'company_proposal_settings6', 'company_proposal_settings5')))):   ?>
                            <ul class="nav-bar" style="padding-left: 30px;">
                                <li>
                                    <a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings3'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings3') ?>">
                                        Standard Layout
                                    </a>
                                </li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings') ?>">Cool Layout</a></li>
                                <?php if ($account->getCompany()->getNewLayouts()) { ?>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings6'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings6') ?>">Custom Layout</a></li>
                                <?php } ?>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings5'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings5') ?>">Layout Defaults</a></li>
                            </ul>
                        <?php endif; ?>
                        <?php $this->load->view($layout); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#content-->
 
<?php $this->load->view('global/footer') ?>
