<?php
$os_version = ($proposalView->getPlatformVersion()) ? ' '.$proposalView->getPlatformVersion() : '';
?>
<div class="device_info" style="float: right;">
    <table style="float: right;font-size:16px">
        <tbody>
            <tr><th style="text-align: center;" colspan="2">Device Info</th></tr>
            <tr><th style="text-align: right;">OS:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getPlatform().''.$os_version;?></td></tr>
            <tr><th style="text-align: right;">Device:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getDevice();?></td></tr>
            <tr><th style="text-align: right;">Browser:</th><td style="text-align: left;padding-left: 20px;"><?= $proposalView->getBrowser();?></td></tr>
        </tbody>
    </table>
</div>