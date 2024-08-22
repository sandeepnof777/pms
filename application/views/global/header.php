<?php $this->load->view('global/header-global'); ?>
  
<div id="wrapper">
    <div style="width: 100%; height: 0; position: relative;">
        <div id="newProposalsPopup"></div>
        <div id="newClientsPopup"></div>
        <div id="newLeadsPopup"></div>
        <div id="newProspectsPopup"></div>
        <div id="newAccountsPopup"></div>
        
        
    </div>
    <div id="header" class="clearfix">
    <?php
        if ($this->session->userdata('logged')) {
            $account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
            $mainAccount = $account;
            if ($this->session->userdata('sublogin')) {
                $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
                if ($sublogin_account) {
                    $account = $sublogin_account;
                }
            }
            if ($mainAccount->isGlobalAdministrator() && $account->getIsSuperUser()){
                $width='250px';
            }
            else if ($mainAccount->isGlobalAdministrator() || $account->getIsSuperUser()) {
                $width='210px';
            }else{
                $width='170px';
            }
            ?>
        <div class="widthfix clearfix" id="header-top" style="background: #fff;">
            <a style="margin-left: 5px;position:absolute;" href="<?php echo base_url() ?>" >
                <img width="auto" height="55" src="<?php echo site_url('uploads/clients/logos/' . $account->getCompany()->getCompanyLogo() . '?' . rand(100000, 999999)) ?>" alt="Company Logo">
            </a>
            <div id="CountdownPanel" class="clearfix hide">
                <p style="text-align: center;">
                    <strong>You will be logged out in</strong>
                </p>
                <div>  
                <div style="float:left;font-size: 18px;margin-top: 6px;margin-left: 10px;font-weight: bold;" id="logoutCountdown">02:30</div>
                <div style="float:right"><a href="#" class="btn update-button keepMeLogin">Keep Me Logged In</a> </div>
                </div>
            </div>
            
            <div id="top_panel" style="background:transparent;height:38px;float:right;width:<?=$width;?>;position:relative">
                <div class="UniversalSearchDiv tiptipleft" title="Search" style="float:left;width:40px">
                    <a href="javascript:void(0)" class="UniversalSearchOpenBtn" style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-search"></i>
                    </a>
                </div>
                <div class="UserDiv tiptipleft" title="User" style="float:left;width: 40px;">
                    
                    <a href="javascript:void(0)" class="UserProfileBtn" id="UserProfileBtn" style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-user-circle-o"></i>
                    </a>
                </div>
                <?php
                if ($account->getIsSuperUser()) {
                    if($this->uri->segment(2) == 'super_user'){ ?>
                        <div class="UserDiv tiptipleft" title="Back to Home" style="float:left;width: 40px;">
                            <a href="<?php echo site_url('dashboard') ?>"  style="color: #9E9E9E;font-size:2.5em">
                                <i class="fa fa-fw fa-home"></i>
                            </a>
                        </div>
                <?php }else{ ?>
                        <div class="UserDiv tiptipleft" title="Super User dashboard" style="float:left;width: 40px;">
                            <a href="<?php echo site_url('dashboard/super_user') ?>"  style="color: #9E9E9E;font-size:2.5em">
                                <i class="fa fa-fw fa-black-tie"></i>
                            </a>
                        </div>
                <?php } 
                }
                
                if ($mainAccount->isGlobalAdministrator()) {
                    ?>
                <div class="UserDiv tiptipleft" title="Admin" style="float:left;width: 40px;">
                    
                    <a href="<?php echo site_url('admin') ?>"  style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-users"></i>
                    </a>
                </div>
                <?php } ?>
                <div class="UserDiv tiptipleft" title="Tutorials" style="float:left;width: 40px;">
                <a href="https://pavementlayers.zendesk.com" target="_blank" style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-graduation-cap"></i>
                    </a>
                </div>
                <div class="HelpDiv tiptipleft" title="Support" style="float:left;width: 40px;margin-left:5px">
                   

                    <a href="https://pavementlayers.zendesk.com/hc/en-us/requests/new" target="_blank" style="float:left;"  >
                        <div class="help" style="width:30px;height:28px;float: left;    margin-top: 1px;"> <span style="font-size: 22px;float: left;text-align: center;padding-top: 5px;padding-left: 8px;">?</span></div></a>
                     <br>
                     <!-- <a href="https://softrivethelp.zendesk.com/hc/en-us/requests/new?ticket_form_id=15142248605202" target="_blank" style="float:left;"  >
                        <div class="help" style="width:30px;height:28px;float: left;    margin-top: 1px;"> <span style="font-size: 22px;float: left;text-align: center;padding-top: 5px;padding-left: 8px;">?</span></div>
                    </a> -->

                        <!-- <a href="https://work9148.zendesk.com/hc/en-us/requests/new?ticket_form_id=15142248605202" target="_blank" style="float:left;"  >
                        <div class="help" style="width:30px;height:28px;float: left;    margin-top: 1px;"> <span style="font-size: 22px;float: left;text-align: center;padding-top: 5px;padding-left: 8px;">?</span></div>
                    </a> -->
               
                    </div>

                <div class="UserDetailsSection" >
                    <div id="HeaderUserSection">
                    <div style="width: 100%;float: left;">
                        <a style="margin-left: 50px;" href="<?php echo base_url() ?>" id="logo"></a>
                    </div>
                    
                    <p class="align-center mg-t-5 text-white" ><strong><?php echo $account->getFullName() ?></strong></p>
                    <p class="align-center mg-t-5 " style="color: #708eb5;"><strong><?php echo $account->getTitle() ?></strong></p>
                    <p class="align-center mg-t-5"><a href="<?php echo site_url('account/logout') ?>">&nbsp;[Logout]</a></p>
                        <?php
                        if (isset($sublogin_account) && $sublogin_account) {
                            if(!$account->getParentUserId()){
                        ?>

                        <p class="align-center mg-t-5"><strong><a style="text-align: center;" href="<?php echo site_url('account/sublogin_logout') ?>">Logout of <?php echo $account->getFirstName() ?></a></strong><p>
                        <?php
                            }else{ ?>
                                    <p class="align-center mg-t-5"><strong><a style="text-align: center;" href="<?php echo site_url('account/parent_sublogin_logout') ?>">Logout from <?php echo $account->getCompany()->getCompanyName() ?></a></strong><p>
                            
                        <?php }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>

        
        <?php
        }
        
        if ($this->session->userdata('logged')) {
            ?>
            <div id="top_menu" class="clearfix widthfix">
                <ul>
                    <li>
                        <a href="<?php echo site_url('dashboard') ?>" id="menu-dashboard" class="<?php echo ($this->uri->segment(1) == 'dashboard') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Dashboard</span>
                            <span class="text">View Short Stats</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('account/my_account') ?>" id="menu-account" class="<?php
                        $pages = array('my_account', 'edit_company', 'add_account', 'attatchments', 'edit_attachment', 'edit_account', 'edit_services', 'custom_texts', 'edit_service', 'company_users',
                            'company_workorder', 'company_proposal_settings', 'company_proposal_settings2', 'company_proposal_settings3', 'company_legal', 'company_legal2', 'company_legal3',
                            'company_logo', 'company_proposal_details', 'company_services', 'company_attachments', 'edit_company_info',
                            'edit_user', 'company_edit_workorder', 'company_add_attachment', 'branches');
                        echo ((in_array($this->uri->segment(1), array('account')))) ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">My Account</span>
                            <span class="text">Edit your settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('prospects') ?>" id="menu-prospects" class="<?php echo ($this->uri->segment(1) == 'prospects' || $this->uri->segment(2) == 'add_prospect' || $this->uri->segment(2) == 'edit_prospect') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Prospects</span>
                            <span class="text">Manage Prospects</span>
                        </a>
                    </li>
                    <li>
                        <?php
                        $header_leads_count = $this->html->getleadsCount();
                        if ($header_leads_count) {
                            ?>
                            <span class="superScript red"><?php echo($header_leads_count) ?></span>
                        <?php } ?>
                        <a href="<?php echo site_url('leads') ?>" id="menu-leads" class="<?php echo ($this->uri->segment(1) == 'leads' || $this->uri->segment(2) == 'add_lead' || $this->uri->segment(2) == 'convert_lead' || $this->uri->segment(2) == 'edit_lead') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Leads</span>
                            <span class="text">Manage Leads</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('accounts') ?>" id="menu-accounts" class="<?php echo ($this->uri->segment(1) == 'accounts') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Accounts</span>
                            <span class="text">Manage Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('clients') ?>" id="menu-clients" class="<?php echo ($this->uri->segment(1) == 'clients') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Contacts</span>
                            <span class="text">Manage Contacts</span>
                        </a>
                    </li>
                    <li>
                        <?php
                        $header_queued_proposals_count = $this->html->getQueuedProposals();
                        if (!defined('QUEUEDPROPOSALS')) {
                            define('QUEUEDPROPOSALS', 0);
                        }
                        if ($header_queued_proposals_count > 0) {
                            ?>
                            <span class="superScript red"><?php echo $header_queued_proposals_count ?></span>
                        <?php } ?>
                        <a href="<?php echo site_url('proposals') ?>" id="menu-proposals" class="<?php echo (($this->uri->segment(1) == 'proposals')) ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">Proposals</span>
                            <span class="text">Manage Proposals</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('calendar') ?>" id="menu-calendar" class="<?php echo ($this->uri->segment(1) == 'calendar') ? 'current' : ''; ?>">
                            <?php if ($this->upcomingEventsCount): ?>
                                <span class="superScript red"><?php echo $this->upcomingEventsCount ?></span>
                            <?php endif; ?>
                            <span class="icon"></span>
                            <span class="label">Calendar</span>
                            <span class="text">View Events</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('history') ?>" id="menu-history" class="<?php echo ($this->uri->segment(1) == 'history') ? 'current' : ''; ?>">
                            <span class="icon"></span>
                            <span class="label">History</span>
                            <span class="text">Account History</span>
                        </a>
                    </li>
                    <?php if ($account->isAdministrator()) {
                        ?>
                        <!--
                        <li>
                            <a href="<?php echo site_url('export') ?>" id="menu-export" class="<?php echo ($this->uri->segment(1) == 'export') ? 'current' : ''; ?>">
                                <span class="icon"></span>
                                <span class="label">Export</span>
                                <span class="text">Download CSV</span>
                            </a>
                        </li>
                        -->
                    <?php } ?>
                    <?php if ($account->isGlobalAdministrator() && 0) {
                        ?>
                        <li>
                            <a href="<?php echo site_url('admin') ?>" id="menu-admin" class="<?php echo ($this->uri->segment(1) == 'admin') ? 'current' : ''; ?>">
                                <span class="icon"></span>
                                <span class="label">Global Admin</span>
                                <span class="text">BAZINGA</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if (0): ?>
                    <!--Notice Start-->
                    <h3></h3>
                    <p style="margin: 0 14px 0 0; padding: 10px; text-align: center; font-weight: bold; color: #25aae1; border: 1px solid #333; background: #eee; font-size: 13px;">
                        We are updating <?php echo SITE_NAME;?>. While this update is in progress, uploads are temporarily disabled. Thank you for your patience!
                    </p>
                    <!--Notice End-->
                <?php endif; ?>

            </div>

        <?php } ?>
        <?php
        if (0) { //Maintenance message
            ?>
            <div class="clearfix widthfix" style="background-color: #fff;">
                <h4 style="text-align: center; margin: 0; padding: 10px 20px 0; color: #bb0c0c;;">We are upgrading our software. Please be patient as some errors might occur. However this will not affect your contact's proposal viewing and tracking. Thank you for your patience.</h4>
            </div>
            <?php
        }
        ?>
    </div>
    <!--#header-->
    <div id="javascript_loading" class="widthfix">
        <p class="clearfix">Loading, Please wait</p>

        <p class="clearfix">&nbsp;</p>

        <p><img src="<?php echo site_url('static') ?>/blue-loader.svg" alt="Loading"></p>
    </div>
    <div class="javascript_loaded">
