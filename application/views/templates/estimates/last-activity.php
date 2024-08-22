<?php
    if ($proposal->last_activity) {
        ?>
        <span class="tiptip" title="View Proposal Activity">
            <a href="<?php echo site_url('proposals/activity/' . $proposal->proposalId); ?>"
                class="lastActivityLink" data-proposal-id="<?php echo $proposal->proposalId; ?>"
                data-project-name="<?php echo $proposal->projectName; ?>">
                <?php echo date('m/d/y <\b\\r> g:ia', strtotime($proposal->last_activity)); ?>
        </a></span>
<?php
    }
?>