<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <?php $this->load->view('admin/left'); ?>
        <div id="admin-right">
            <h1>Manage Contacts</h1>

            <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
                <thead>
                <tr>
                    <td>Client ID#</td>
                    <td>Company</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email</td>
                    <td>Cell Phone</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($clients as $client) {
                    ?>
                <tr>
                    <td><?php echo $client->getClientId(); ?></td>
                    <td><?php echo $client->getCompanyName(); ?></td>
                    <td><?php echo $client->getFirstName(); ?></td>
                    <td><?php echo $client->getLastName(); ?></td>
                    <td><?php echo $client->getEmail(); ?></td>
                    <td><?php echo $client->getCellPhone(); ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/edit_client/' . $client->getClientId()) ?>">Edit</a>
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
