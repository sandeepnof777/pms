<?php

//Attachments page
$attachments = $proposal->getAttatchments();
if (count($attachments) || count($proposal_attachments)) {
    ?>
    
    <div style="page-break-after: always"></div>
    <div class="header-hider"></div>
    <h1 class="underlined header_fix" style="z-index: 2000;">Attachments</h1>
    <div id="attachments"> 
    <!--Hide Header code start-->
   
    <!--Hide Header code end-->
    
    <p>Please click any of the links below to view and print all documents.</p>
    <?php
    if (count($attachments)) {
        ?>
        <h2>Company Attachments</h2>
        <?php
        foreach ($attachments as $attachment) {
            $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
            ?>
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a></h3>
        <?php
        }
    }
    if (count($proposal_attachments)) {
        ?>
        <h2>Project Attachments</h2>
        <?php
        foreach ($proposal_attachments as $attachment) {
            $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
            ?>
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a></h3>
        <?php
        }
    }
    ?>
    </div>
    
    <?php
}
?>