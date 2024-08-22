<p>Dear <?php echo $proposal->getClient()->getFirstName() ?>,</p>
<p>Thank you for the opportunity to bid your project. If you have any questions, please do not hesitate to contact me.</p>
<p>Please click the following link: <?php echo site_url('proposals/live/view/' . $layout . '/plproposal_' . $proposal->getProposalId() . '.pdf') ?> to view/print/save your proposal.</p>
<p>If you can not view the downloaded PDF file, please download Adobe Acrobat Reader from the following link: http://get.adobe.com/reader/.</p>
<p>Best Regards,</p>
<?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
<?php echo $proposal->getClient()->getAccount()->getTitle() ?><br>
<?php echo $proposal->getClient()->getAccount()->getCompany()->getCompanyName() ?><br>
<?php echo $proposal->getClient()->getAccount()->getCompany()->getCompanyWebsite() ?><br>
<?php echo $proposal->getClient()->getAccount()->getEmail() ?><br>
<?php echo $proposal->getClient()->getAccount()->getCellPhone() ?>