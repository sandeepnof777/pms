<p>Dear <?php echo $proposal->getClient()->getFirstName() ?>,</p>
<p>Thank you for the opportunity to bid your project. If you have any questions, please do not hesitate to contact me.</p>
<p>Please click <a href="<?php echo site_url('proposals/view/' . $this->uri->segment(5) . '/' . $this->uri->segment(3) . '.pdf') ?>">here</a> to view/print your proposal.</p>
<p>If the above link does not work, please copy paste this url to your browser: <?php echo site_url('proposals/view/' . $this->uri->segment(5) . '/' . $this->uri->segment(3) . '.pdf') ?>.</p>
<p>Best Regards,</p>
<p><?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
    <?php echo $proposal->getClient()->getAccount()->getTitle() ?><br>
    <?php echo $proposal->getClient()->getAccount()->getCompany()->getCompanyName() ?><br>
    <?php echo $proposal->getClient()->getAccount()->getCompany()->getCompanyWebsite() ?><br>
    <?php echo $proposal->getClient()->getAccount()->getEmail() ?><br>
    <?php echo $proposal->getClient()->getAccount()->getCellPhone() ?>
</p>