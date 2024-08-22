<?php $this->load->view('global/header'); ?>
<div class="widthfix" id="admin-menu-new">
    <div class="menu-container">
        <ul id="menu-ul">
            <li>
                <a href="<?php echo site_url('admin') ?>">Dashboard</a>
                <ul>
                    <li>
                        <a href="<?php echo site_url('admin/add_company') ?>" class=" <?php echo ($this->uri->segment(2) == 'add_company') ? 'current' : ''; ?>" title="Add a new company in the system">Add Company</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/master_company_list') ?>" class=" <?php echo ($this->uri->segment(2) == 'master_company_list') ? 'current' : ''; ?>" >Parent Companies</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/dashboard') ?>" class=" <?php echo ($this->uri->segment(2) == 'add_company') ? 'current' : ''; ?>" title="">Dashboard (beta)</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">Manage</a>
                <ul>
                    <li><a href="<?php echo site_url('admin/custom_texts') ?>" class=" <?php echo ($this->uri->segment(2) == 'custom_texts') ? 'current' : ''; ?>" title="Manage the default customtexts">Default Texts</a></li>
                    <li><a href="<?php echo site_url('admin/manage_services') ?>" class=" <?php echo ($this->uri->segment(2) == 'manage_services') ? 'current' : ''; ?>" title="Manage the proposal services">Services</a></li>
                    <li><a href="<?php echo site_url('admin/site_settings') ?>" class=" <?php echo ($this->uri->segment(2) == 'site_settings') ? 'current' : ''; ?>" title="Edit the site settings">Site Settings</a></li>
                    <li><a href="<?php echo site_url('admin/helpvideos') ?>" class=" <?php echo ($this->uri->segment(2) == 'helpvideos') ? 'current' : ''; ?>" title="Manage the Help Videos">Help Videos</a></li>
                    <li><a href="<?php echo site_url('admin/user_activity') ?>" class=" <?php echo ($this->uri->segment(2) == 'user_activity') ? 'current' : ''; ?>" title="See latest actions in the system">Activity</a></li>
                    <li><a href="<?php echo site_url('admin/email_templates') ?>" class=" <?php echo ($this->uri->segment(2) == 'email_templates') ? 'current' : ''; ?>" title="Edit Email Templates">Email Templates</a></li>
                    <li><a href="<?php echo site_url('admin/client_email_templates') ?>" class=" <?php echo ($this->uri->segment(2) == 'client_email_templates') ? 'current' : ''; ?>" title="Edit Client Email Templates">Client Templates</a></li>
                    <li><a href="<?php echo site_url('admin/statuses') ?>" class=" <?php echo ($this->uri->segment(2) == 'statuses') ? 'current' : ''; ?>" title="Edit Default Proposal Statuses">Statuses</a></li>
                    <li><a href="<?php echo site_url('admin/business_types') ?>" class=" <?php echo ($this->uri->segment(2) == 'business_types') ? 'current' : ''; ?>" title="Edit Default Business Type">Business Types</a></li>
                    <li><a href="<?php echo site_url('admin/proposal_sections') ?>" class=" <?php echo ($this->uri->segment(2) == 'proposal_sections') ? 'current' : ''; ?>" title="Edit Default Proposal Sections">Proposal Layout</a></li>
                    <li><a href="<?php echo site_url('admin/work_order_sections') ?>" class=" <?php echo ($this->uri->segment(2) == 'work_order_sections') ? 'current' : ''; ?>" title="Edit Default Work Order Sections">Work Order Layout</a></li>
                    <li><a  style="padding: 0 9px;" href="<?php echo site_url('admin/recent_added_user') ?>" class=" <?php echo ($this->uri->segment(2) == 'recent_added_user') ? 'current' : ''; ?>" title="Recent Added User">Recent Added User</a></li>
                    <li><a href="<?php echo site_url('admin/quickbooks_sync') ?>" class=" <?php echo ($this->uri->segment(2) == 'statuses') ? 'current' : ''; ?>" title="View Quickbook Error">QuickBook Sync</a></li>
                    <li><a href="<?php echo site_url('admin/faq') ?>" class=" <?php echo ($this->uri->segment(2) == 'statuses') ? 'current' : ''; ?>" title="Edit Default FAQs">FAQs</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo site_url('admin') ?>">Site Settings</a>
            </li>
            <li>
                <a href="#">Actions</a>
                <ul>
                    <li><a href="<?php echo site_url('admin/updateAllPrices') ?>" class=" <?php echo ($this->uri->segment(2) == 'updateAllPrices') ? 'current' : ''; ?>" title="Update Prices - Don't mess with this">UP</a></li>
                    <li><a href="<?php echo site_url('admin/exportAllUsers') ?>" class=" <?php echo ($this->uri->segment(2) == 'exportAllUsers') ? 'current' : ''; ?>" title="Export all accounts">Export Accounts</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo site_url('admin/user_activity') ?>" class=" <?php echo ($this->uri->segment(2) == 'user_activity') ? 'current' : ''; ?>" title="See latest actions in the system">Activity</a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/company_data') ?>" class=" <?php echo ($this->uri->segment(2) == 'company_data') ? 'current' : ''; ?>" title="Company Data">Company Data</a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/announcements') ?>" class=" <?php echo ($this->uri->segment(2) == 'announcements') ? 'current' : ''; ?>" title="Announcements">Announcements</a>
            </li>
            <li>
                <a href="#">Estimating</a>
                <ul>
                    <li><a href="<?php echo site_url('admin/estimating_categories') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimating_categories') ? 'current' : ''; ?>" title="Manage Estimating Categories">Categories</a></li>
                    <li><a href="<?php echo site_url('admin/estimating_types') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimating_types') ? 'current' : ''; ?>" title="Manage Estimating Types">Types</a></li>
                    <li><a href="<?php echo site_url('admin/estimating_items') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimating_items') ? 'current' : ''; ?>" title="Manage Estimating Items">Items</a></li>
                    <li><a href="<?php echo site_url('admin/estimating_templates') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimating_templates') ? 'current' : ''; ?>" title="Manage Estimating Assemblies">Assemblies</a></li>
                    
                    <li><a href="<?php echo site_url('admin/default_phases') ?>" class=" <?php echo ($this->uri->segment(2) == 'default_phases') ? 'current' : ''; ?>" title="Manage Default Estimate Phases">Default Phases</a></li>
                    <li><a href="<?php echo site_url('admin/estimating_settings') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimating_settings') ? 'current' : ''; ?>" title="Manage Default Estimate Setting">Default Setting</a></li>
                    <li><a href="<?php echo site_url('admin/estimate_stats') ?>" class=" <?php echo ($this->uri->segment(2) == 'estimate_stats') ? 'current' : ''; ?>" title="Estimate Stats">Estimate Stats</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo site_url('admin/group_resends') ?>" class=" <?php echo ($this->uri->segment(2) == 'group_resends') ? 'current' : ''; ?>" title="Email Campaigns">Email Campaigns</a>
            </li>
        </ul>
    </div>
</div>
<!--First Commit FAQ Feature branch-->