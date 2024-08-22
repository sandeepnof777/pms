<?php $this->load->view('global/header-super-user') ?>

<div id="content" class="clearfix">
    <div class="widthfix">


        <div class="nav-box clearfix">
            <div class="nav-left">
                <h1 class="nav-heading">
                    My Account
                </h1>
                <ul class="nav-menu">
                    <li class="<?php echo (in_array($this->uri->segment(2), array('my_super_account', 'super_company_users', 'super_company_logo', 'company_users', 'add_user', 'company_workorder',
                        'company_edit_workorder', 'add_work_order_address', 'edit_work_order_address', 'work_order_recipients', 'edit_user', 'branches', 'bid_approval','foremen_list'))) ? 'active' : ''; ?>">
                        <a href="<?php echo site_url('account/my_super_account') ?>">Company Info</a>
                    </li>
                    
                        <li class="">
                            <a href="<?php echo site_url('reports/parent_company') ?>">Reports</a>
                        </li>
                        
                    
                </ul>
            </div>
            <div class="nav-right">
                <div class="content-box">
                    <div class="nav-header">
                        <?php
                        /* Company Info sub-nav */
                        if (in_array($this->uri->segment(2), array('my_super_account', 'super_company_users', 'super_company_logo', 'super_company_users', 'edit_user', 'add_user', 'company_workorder',
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
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('my_super_account', 'edit_company_info'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/my_super_account') ?>">Summary</a></li>
                                
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('super_company_users', 'edit_user', 'add_user'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/super_company_users') ?>">Users</a></li>
                                    
                                    
                                    <li><a class="<?php echo ($this->uri->segment(2) == 'super_company_logo') ? 'active' : ''; ?>" href="<?php echo site_url('account/super_company_logo') ?>">Logo</a></li>
                                   
                               
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
                        
                        
                        
                        
                        ?>
                        
                    </div>
                    <div class="nav-content clearfix">
                        <?php if ((in_array($this->uri->segment(2), array('company_proposal_settings3', 'company_proposal_settings', 'company_proposal_settings6', 'company_proposal_settings5')))): ?>
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
