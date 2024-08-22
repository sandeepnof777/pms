
<div id="attachments">
<?php

//proposal attachments
if (count($workorder_attachments)) {
    
    if($i!=1){
            ?>
            <div style="page-break-after: always"></div>
    <?php }?>

    <!--Hide Header code start-->

    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">Attachments</h1>
    <p>Please click any of the links below to view and print all documents.</p>
    <?php
    if (count($workorder_attachments)) {
        ?>
        <?php
        foreach ($workorder_attachments as $attachment) {
            $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
            ?>
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a
                        href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a>
            </h3>
            <?php
        }
    }
}
?>
</div><!--Close attachments-->