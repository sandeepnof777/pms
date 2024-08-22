<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <?php $this->load->view('admin/left'); ?>
        <div id="admin-right">
            <h1>Manage Companies</h1>

            <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
                <thead>
                <tr>
                    <td>ID#</td>
                    <td>Company Name</td>
                    <td>Administrator</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($companies as $company) {
                    ?>
                <tr>
                    <td><?php echo $company->getCompanyId(); ?></td>
                    <td><?php echo $company->getCompanyName(); ?></td>
                    <td><?php echo $company->getAdministrator()->getFullName() . ' (' . $company->getAdministrator()->getEmail() . ')'; ?></td>
                    <td>
                        <a class="btn-users tiptip" title="Users" href="<?php echo site_url('admin/accounts/' . $company->getCompanyId()) ?>">Users</a>
                        <a class="btn-history tiptip" title="User Activity" href="<?php echo site_url('admin/user_activity/' . $company->getCompanyId()) ?>">User Activity</a>
                        <a class="btn-add tiptip" title="Add User" href="<?php echo site_url('admin/add_account/' . $company->getCompanyId()) ?>">Add User</a>
                        <a class="btn-settings tiptip" title="Log in as Admin" href="<?php echo ($company->getAdministrator()) ? site_url('admin/sublogin/' . $company->getAdministrator()->getAccountId()) : '-1'  ?>">Log In As Admin</a>
                        <a class="btn-delete tiptip" title="Delete Company" href="<?php echo site_url('admin/delete_company/' . $company->getCompanyId()) ?>" onclick="return confirm('Are you sure? This will delete all users, clients and proposals!')">Delete</a>
                        <a class="btn-help tiptip" title="<center>Company Statistics:</center><br><br><strong>Accounts:</strong> 666<br><strong>Clients</strong>" href="#">Statistics</a>
                    </td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('global/footer'); ?>
