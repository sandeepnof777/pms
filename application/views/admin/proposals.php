<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <?php $this->load->view('admin/left'); ?>
        <div id="admin-right">
            <h1>Manage Proposals</h1>

            <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
                <thead>
                <tr>
                    <td>ID#</td>
                    <td>Date Issued</td>
                    <td>Account</td>
                    <td>Company</td>
                    <td>Project Name</td>
                    <td>US$</td>
                    <td>Status</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($proposals as $proposal) {
                    ?>
                <tr>
                    <td><?php echo $proposal->getProposalId(); ?></td>
                    <td><?php echo $proposal->getCreated(); ?></td>
                    <td><?php echo $proposal->getClient()->getAccount()->getFullName(); ?></td>
                    <td><?php
                        $client = $proposal->getClient();
                        echo $client->getCompany()->getCompanyName();
                        ?></td>
                    <td><?php echo $proposal->getProjectName(); ?></td>
                    <td>$<?php echo $proposal->getTotalPrice(false); ?></td>
                    <td><?php echo $proposal->getStatus(); ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/edit_proposal/' . $proposal->getProposalId()) ?>">Edit</a>
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
