<?php
session_start();
$configs = include('config.php');
?>

<table style="width:100%;">
	<thead>
     	<tr>
        	<th colspan="2" style="font-size:1.3em;text-align: left;padding: 10px 20px;">
            	Are you QuickBook Desktop or QuickBook Online User?
            </th>
        </tr>
    	<tr>
        	<td style="padding: 20px;">
            <a href="<?= base_url();?>account/qbdesktop" class="btn ui-button update-button ui-widget ui-state-default ui-corner-all">QuickBooks Desktop</a>
            </td>
            <td style="padding: 20px;"><a href="<?= base_url();?>account/qbonline" class="btn ui-button update-button ui-widget ui-state-default ui-corner-all">QuickBooks Online</a></td>
        </tr>
    </thead>
</table>