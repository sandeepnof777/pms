<?php
    if ($proposal->image_count > 0) {
?>
    <a href="#" data-proposal-id="<?php echo $proposal->proposalId; ?>" class="previewProposalImages tiptip" title="Preview Images"><?php echo $proposal->image_count; ?></a>
<?php
    }
    else {
?>
    <span style="color: red; font-weight: bold;"><?php echo $proposal->image_count; ?>
<?php
    }
?>