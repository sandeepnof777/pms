<div id="admin-left">
    <ul>
        <li><a class="btn <?php echo (!$this->uri->segment(3) || $this->uri->segment(3) == 'dashboard') ? 'ui-state-hover':'';?>" href="<?php echo site_url('admin') ?>">Dashboard</a></li>
        <li><a class="btn <?php echo ($this->uri->segment(3) == 'add_company') ? 'ui-state-hover':'';?>" href="<?php echo site_url('admin/add_company') ?>">Add New Company</a></li>
        <li><a class="btn <?php echo ($this->uri->segment(3) == 'companies') ? 'ui-state-hover':'';?>" href="<?php echo site_url('admin/companies') ?>">Manage Companies</a></li>
<!--        <li><a class="btn --><?php //echo ($this->uri->segment(3) == 'accounts') ? 'ui-state-hover':'';?><!--" href="--><?php //echo site_url('admin/accounts') ?><!--">Manage Users</a></li>-->
<!--        <li><a class="btn --><?php //echo ($this->uri->segment(3) == 'clients') ? 'ui-state-hover':'';?><!--" href="--><?php //echo site_url('admin/clients') ?><!--">Manage Clients</a></li>-->
<!--        <li><a class="btn --><?php //echo ($this->uri->segment(3) == 'proposals') ? 'ui-state-hover':'';?><!--" href="--><?php //echo site_url('admin/proposals') ?><!--">Manage Proposals</a></li>-->
        <li><a class="btn <?php echo ($this->uri->segment(3) == 'user_activity') ? 'ui-state-hover':'';?>" href="<?php echo site_url('admin/user_activity') ?>">User Activity</a></li>
<!--        <li><a class="btn --><?php //echo ($this->uri->segment(3) == 'account_functions') ? 'ui-state-hover':'';?><!--" href="--><?php //echo site_url('admin/account_functions') ?><!--">Account Functions</a></li>-->
    </ul>
</div>