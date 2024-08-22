<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
    <div class="widthfix">


        <div class="nav-box clearfix">
            <div class="nav-left">
                <h1 class="nav-heading">
                    My Account
                </h1>
                <ul class="nav-menu">
                    <li class="<?php echo (in_array($this->uri->segment(2), array('my_account', 'edit_company_info', 'company_logo', 'company_users', 'add_user', 'company_workorder', 'company_edit_workorder'))) ? 'active' : ''; ?>">
                        <a href="<?php echo site_url('account/my_account') ?>">Company Info</a>
                    </li>
                    <?php if ($account->isAdministrator()) { ?>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings', 'company_proposal_settings2', 'company_proposal_settings3', 'company_proposal_settings4',
                            'company_proposal_settings5', 'company_proposal_settings6', 'company_proposal_settings7'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/company_proposal_settings2') ?>">Proposal Settings</a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('company_services', 'edit_service'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/company_services'); ?>">Scope of Work</a>
                        </li>
                        <li class="<?php echo ($this->uri->segment(2) == 'company_proposal_details') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/company_proposal_details') ?>">Custom Texts</a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('company_legal', 'company_legal2', 'company_legal3'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/company_legal') ?>">Legal</a>
                        </li>
                        <li class="<?php echo (in_array($this->uri->segment(2), array('company_attachments', 'company_add_attachment', 'edit_attachment'))) ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('account/company_attachments') ?>">Attachments</a>
                        </li>
                    <?php } else {
                        ?>
                    <li class="<?php echo (in_array($this->uri->segment(2), array('my_info'))) ? 'active' : ''; ?>">
                        <a href="<?php echo site_url('account/my_info') ?>">My Info</a>
                    </li>
                    <?php
                    } ?>
                </ul>
            </div>
            <div class="nav-right">
                <div class="content-box">
                    <div class="nav-header">
                        <?php
                        /* Company Info sub-nav */
                        if (in_array($this->uri->segment(2), array('my_account', 'edit_company_info', 'company_logo', 'company_users', 'edit_user', 'add_user', 'company_workorder', 'company_edit_workorder'))) {
                            ?>
                            <h2>
                                Company Information
                                <?php if (help_box(9)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(9, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('my_account', 'edit_company_info'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/my_account') ?>">Summary</a></li>
                                <?php if ($account->isAdministrator()) { ?>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_users', 'edit_user', 'add_user'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_users') ?>">Users</a></li>
                                    <li><a class="<?php echo ($this->uri->segment(2) == 'company_logo') ? 'active' : ''; ?>" href="<?php echo site_url('account/company_logo') ?>">Logo</a></li>
                                    <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_workorder', 'company_edit_workorder'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_workorder') ?>">Work Order Directions</a></li>
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
                        if (in_array($this->uri->segment(2), array('company_proposal_settings', 'company_proposal_settings2', 'company_proposal_settings3', 'company_proposal_settings4'
                        , 'company_proposal_settings5', 'company_proposal_settings6', 'company_proposal_settings7'))) {
                            ?>
                            <h2>
                                Proposal Settings
                                <?php if (help_box(58)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(58, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings2'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings2') ?>">About Company</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings3'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings3') ?>">Standard Layout Intro</a></li>
                                <li><a class="<?php echo (in_array($this->uri->segment(2), array('company_proposal_settings'))) ? 'active' : ''; ?>" href="<?php echo site_url('account/company_proposal_settings') ?>">Page 2 Header | Cool Layout</a></li>
                            </ul>
                        <?php
                        }
                        if (in_array($this->uri->segment(2), array('company_services', 'edit_service'))) {
                            ?>
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
                        if (in_array($this->uri->segment(2), array('company_proposal_details'))) {
                            ?>
                            <h2>
                                Custom Texts
                                <?php if (help_box(55)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(55, true) ?></div>
                                <?php } ?>
                            </h2>
                            <ul class="nav-bar">
                                <li><a class="<?php echo ($this->uri->segment(2) == 'company_proposal_details') ? 'active' : ''; ?>" href="<?php echo site_url('account/company_logo') ?>">All Texts</a></li>
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
                        ?>
                    </div>
                    <div class="nav-content">
                        <?php $this->load->view($layout); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--#content-->
<?php $this->load->view('global/footer') ?>
