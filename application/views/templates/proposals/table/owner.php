<?php
    // Not sure what's going on here but I'll keep it for now
    $names = '';
    $names2 = explode(' ', trim($proposal->accountFN . ' ' . $proposal->accountLN));
    foreach ($names2 as $name) {
        $names .= substr($name, 0, 1) . ' . ';
    }
?>
<span class="tiptip proposal_table_permission_user_name_tiptip" data-proposal-id="<?php echo $proposal->proposalId;?>" title="Loading..."><?php echo $names; ?></span>