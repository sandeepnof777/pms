<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                User Activity <?php if (!$this->uri->segment(3)) { ?>(global actions.)<?php } else { ?>(<?php echo $company->getCompanyName() ?>)<?php } ?> - Showing last 200 actions
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
            </div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
                    <thead>
                    <tr>
                        <td>Date</td>
                        <td>Company</td>
                        <td>User</td>
                        <td>IP Address</td>
                        <td>Contact</td>
                        <td>Proposal</td>
                        <td>Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($logs as $log) {
                        ?>
                    <tr>
                        <td><?php echo date('m-d-Y h:i:s A', $log->getTimeAdded() + TIMEZONE_OFFSET) ?></td>
                        <td><?php
                            try {
                                echo ($log->getCompany()) ? $log->getCompany()->getCompanyName() : 'No Company';
                            } catch (Exception $e) {
                                echo  'No Company';
                            }
                            ?></td>
                        <td><?php
                            try {
                                echo ($log->getAccount()) ? $log->getAccount()->getFullName() : 'No User';
                            } catch (Exception $e) {
                                echo  'Account Deleted';
                            }
                            ?></td>
                        <td><?php echo $log->getIp() ?></td>
                        <td><?php
                            try {
                                echo ($log->getClient()) ? $log->getClient()->getCompanyName() : 'None';
                            } catch (Exception $e) {
                                echo 'Client Deleted';
                            }
                            ?></td>
                        <td><?php
                            try {
                                echo ($log->getProposal()) ? $log->getProposal()->getProjectName() : 'None';
                            } catch (Exception $e) {
                                echo 'Proposal Deleted';
                            }
                            ?></td>
                        <td><?php echo $log->getDetails() ?></td>
                    </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('global/footer'); ?>
