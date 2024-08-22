<!-- <div class="nav-left" >
                <h1 class="nav-heading">
                    My Account
                </h1>
            
                <ul class="nav-menu" style="height:410px;" >
                    <?php if ($account->isAdministrator()) { ?>
                        <?php $comSett = (in_array($this->uri->segment(2), array('company_info','company_videos','company_users','branches','company_logo','company_workorder',
                        'work_order_recipients','bid_approval','foremen_list','my_account','', '','company_legal','company_legal2','event_types','company_services',
                        'company_legal3','company_attachments','business_type_settings','company_add_attachment','add_user','add_work_order_address','edit_company_info'))) ? 'active' : ''; ?>

                        <?php $proSet=(in_array($this->uri->segment(2), array('proposal_setting','company_proposal_settings7','company_proposal_settings','company_proposal_settings6', 'company_proposal_settings2', 'company_proposal_settings3', 'company_proposal_settings4',
                         'company_proposal_notifications','company_proposal_sections', 'company_work_order_sections','company_settings', 'company_proposal_intro','company_proposal_details',
                         'job_cost_reports','estimating_reports','estimating_price_report','estimating_material_report','sales_targets_config','sales_targets_users_config','company_proposal_statuses',
                         'estimating_equipment_report','estimating_labor_report','estimating_services_report','estimating_settings','estimating','estimating_types','estimating_items','estimating_templates','estimating_plants',
                         'estimating_dumps','estimating_subs','estimating_phases','modify_prices','modify_prices_history'))) ? 'active' : '';
                         ?>
                        
                        <?php $prospSet= (in_array($this->uri->segment(2),array("prospect_settings","prospect_rating_settings","prospect_status_settings")))?'active':''?>
                        <?php $leadSett =(in_array($this->uri->segment(2),array("lead_settings","lead_settings2")))?'active':'' ?>
                        <?php $emailTemp =(in_array($this->uri->segment(2),array("company_email_templates")))?'active':'' ?>
                        <?php $report =(in_array($this->uri->segment(1),array("reports")))?'active':'' ?>
                        <?php $psa =(in_array($this->uri->segment(2),array("psa")))?'active':'' ?>
                        <?php $qbonline =(in_array($this->uri->segment(2),array("qbonline")))?'active':'' ?>

                        <li class="<?php echo $comSett; ?>">
                               <?php 
                                if((in_array($this->uri->segment(2), array('my_account')) && (($comSett==true) || $proSet==true||$prospSet==true || $leadSett==true||$emailTemp==true||$psa==true||$qbonline==true))) {?>
                                       <a href="#" class="show-div" data-target="company_setting">Company Settings</a>
                                       <?php } else{?>
                                        <a href="<?php echo site_url('account/my_account') ?>">Company Settings</a>
                              <?php } ?>
                        </li>

                        <li class="<?php echo $proSet;?>">
                              <?php if(!in_array($this->uri->segment(2), array('my_account')) && (($proSet==true)|| $comSett==true||$prospSet==true||$leadSett==true||$emailTemp==true||$psa==true||$qbonline==true)) {?>
                                <a   href="<?php echo site_url('account/my_account/proposal_settings') ?>">Proposal Settings</a>
                                <?php } else{?>
                                  <a href="#" class="show-div" data-target="proposal_setting">Proposal Settings</a>
                                  <?php } ?>

                        </li>
                        
                        <li class="<?php echo $prospSet; ?>"><a href="<?php echo site_url('account/prospect_settings') ?>">Prospect Settings</a></li>
                        <li class="<?php echo $leadSett;?>"><a href="<?php echo site_url('account/lead_settings') ?>">Lead Setting</a></li>
                        <li class="<?php echo $emailTemp;?>"><a href="<?php echo site_url('account/company_email_templates') ?>">Email Templates</a></li>
                        <li><a href="<?php echo site_url('export') ?>">Exports</a></li>
                        <li class="<?php echo $report; ?>"><a href="<?php echo site_url('reports') ?>">Reports</a></li>

                        <?php
                    } else {
                        ?>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('company_info','my_account', 'edit_company_info', 'company_logo', 'company_users', 'add_user', 'company_workorder',
                           'company_edit_workorder', 'add_work_order_address', 'edit_work_order_address', 'work_order_recipients', 'edit_user', 'branches', 'bid_approval','foremen_list'))) ? 'active' : ''; ?>">
                        <a href="<?php echo site_url('account/company_info') ?>">Company Info</a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('my_info'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/my_info') ?>">My Info</a>
                        </li>
                        <?php
                    } ?>
                    <?php

                    if ($account->getCompany()->hasPSA()) {
                        ?>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('psa'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/psa') ?>">ProSiteAudit</a>
                        </li>
                    <?php } ?>

                    <?php if ($account->hasFullAccess()) { ?>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('qbonline'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/qbsettings') ?>">QuickBooks</a>
                        </li>
                    <?php } ?>

                    <li class="<?php echo (in_array($this->uri->segment(2), array('proposal_filters'))) ? 'active' : ''; ?>">
                        <a href="<?php echo site_url('account/proposal_filters') ?>">Saved Filters</a>
                    </li>
                </ul>
            </div>

          -->


          <!--add a back button -->

          <div class="nav-left" >
         
            
                <ul class="nav-menu" style="height:410px;" >
                    
                <li class="back-active" style="padding-left:20px;padding:0px;margin:0px;">

                        <a href="<?php echo site_url('account/my_account') ?>">Back</a>
                    </li>
                </ul>
            </div>

         
          <!--add a back button -->