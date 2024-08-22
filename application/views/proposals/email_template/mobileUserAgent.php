<?php
$os_version = ($proposalView->getPlatformVersion()) ? ' '.$proposalView->getPlatformVersion() : '';
?>

<br/>
<div  style="margin-top:20px;">
    <table style="width:100%;margin:auto;font-size:16px;margin-top:20px;">
        <tbody>
            <tr><th style="text-align: center;" colspan="2">Device Info</th></tr>
            <tr><th style="text-align: right;">OS:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getPlatform().''.$os_version;?></td></tr>
            <tr><th style="text-align: right;">Device:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getDevice();?></td></tr>
            <tr><th style="text-align: right;">Browser:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getBrowser();?></td></tr>
        </tbody>
    </table>
</div>