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
                if($account->getParentCompanyId()){
                    $width='210px';
                }else{
                    $width='170px';
                }
                
            }
            else if ($mainAccount->isGlobalAdministrator() || $account->getIsSuperUser()) {
                $width='170px';
            }else{
                $width='130px';
            }
            ?>
        <div class="widthfix clearfix" id="header-top" style="background: #fff;position: relative;">
            <a style="margin-left: 5px;position:absolute;" href="<?php echo base_url() ?>" >
                <img width="auto" height="55" src="<?php echo site_url('uploads/clients/logos/' . $account->getParentCompany()->getCompanyLogo() . '?' . rand(100000, 999999)) ?>" alt="Company Logo">
            </a>

            <form action="<?php echo site_url('dashboard/sublogin') ?>" method="POST" style="position: absolute;left: 305px;top: 20px;">
                        <label style="font-size: 13px;font-weight: bold;float:left;margin-top:6px;margin-right:4px;">Select company </label>
                        <select name="companyId">
                                <option value="">Select Company</option>
                            <?php foreach($childCompanies as $childCompany){
                                //if($account->getCompany()->getCompanyId() != $childCompany->companyId){
                                echo '<option value="'.$childCompany->companyId.'">'.$childCompany->companyName.'</option>';
                                //}
                            }
                            ?>
                        </select>
                        <input type="submit"  value="Login"  class="btn uupdate-button blue" >
                    </form> 


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
                <!-- <div class="UniversalSearchDiv tiptipleft" title="Search" style="float:left;width:40px">
                    <a href="javascript:void(0)" class="UniversalSearchOpenBtn" style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-search"></i>
                    </a>
                </div> -->
                <div class="UserDiv tiptipleft" title="User" style="float:left;width: 40px;">
                    
                    <a href="javascript:void(0)" class="UserProfileBtn" id="UserProfileBtn" style="color: #9E9E9E;font-size:2.5em">
                        <i class="fa fa-fw fa-user-circle-o"></i>
                    </a>
                </div>
                <?php
                       
                            if($account->getParentCompanyId()){
                        ?>
                        <div class="UserDiv tiptipleft" title="Back to Home" style="float:left;width: 40px;">
                            <a href="<?php echo site_url('dashboard') ?>"  style="color: #9E9E9E;font-size:2.5em">
                                <i class="fa fa-fw fa-home"></i>
                            </a>
                        </div>
               <?php
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
                                    <p class="align-center mg-t-5"><strong><a style="text-align: center;" href="<?php echo site_url('account/sublogin_logout') ?>">Logout from <?php echo $account->getCompany()->getCompanyName() ?></a></strong><p>
                            
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
                        <a href="<?php echo site_url('dashboard/super_user') ?>" id="menu-dashboard" class="<?php echo ($this->uri->segment(2) == 'super_user') ? 'current' : ''; ?>" style="width: 309px;">
                            <span class="icon"></span>
                            <span class="label">Dashboard</span>
                            <span class="text">View Short Stats</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('account/my_super_account') ?>" id="menu-account" class="<?php
                        $pages = array('my_super_account', 'edit_company');
                        echo ((in_array($this->uri->segment(1), array('account')))) ? 'current' : ''; ?>" style="width: 309px;">
                            <span class="icon"></span>
                            <span class="label">My Account</span>
                            <span class="text">Edit your settings</span>
                        </a>
                    </li>
                    
                   
                    <li>
                        <a href="#" id="menu-accounts" class="<?php echo ($this->uri->segment(1) == 'accounts') ? 'current' : ''; ?>" style="width: 309px;">
                            <span class="icon"></span>
                            <span class="label">Accounts</span>
                            <span class="text">Manage Accounts</span>
                        </a>
                    </li>
                    
                    
                   
                   
                    
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
