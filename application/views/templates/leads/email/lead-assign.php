<?php 
    /* @var $account \models\Accounts */
    /* @var $lead \models\Leads */
 ?>
<p>
    Hello, <?php echo $account->getFirstName() ?>!</p>
<p>
    You have a new lead that was assigned to you!</p>
<p>
    <strong>Lead Information:</strong></p>
<p>
    <strong>Company Name:</strong> <?php echo $lead->getCompanyName(); ?><br />
    <!--<strong>Requested Work:</strong> <?php echo $lead->get ?><br />-->
    <strong>Contact:</strong> <?php echo $lead->getFirstName() . ' ' . $lead->getLastName(); ?><br />
    <strong>Title:</strong> <?php echo $lead->getTitle(); ?><br />
    <strong>Business Phone:</strong> <?php echo $lead->getBusinessPhone(true); ?><br />
    <strong>Cell Phone:</strong> <?php echo $lead->getCellPhone(); ?><br />
    <strong>Email: </strong><?php echo $lead->getEmail(); ?><br />
    <strong>Lead Address:</strong> <?php echo $lead->getAddress() . ' ' . $lead->getCity() . ' ' . $lead->getState() . ' ' . $lead->getZip(); ?></p>
<p>
    <strong>Project Information:</strong></p>
<p>
    <strong><strong>Project Name:</strong> <?php echo $lead->getProjectName(); ?><br />
        Address:</strong> <?php echo $lead->getProjectAddress() . ' ' . $lead->getProjectCity() . ' ' . $lead->getProjectState() . ', ' . $lead->getProjectZip() ?><br />
    <strong>Contact:</strong> <?php echo $lead->getProjectContact(); ?><br />
    <strong>Phone: </strong><?php echo $lead->getProjectPhone() ?><br />
    &nbsp;</p>
<p>
    <strong>Notes:</strong></p>
<p>
    <?php echo nl2br($lead->getNotes()); ?></p>
<p>
    ---------------------------------------------<br />
    Thank you,</p>
<p>
<?php echo SITE_NAME;?> Team</p>
<p>
    Any questions, please contact us at <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN;?>?subject=Help!">support@<?php echo SITE_EMAIL_DOMAIN;?></a></p>