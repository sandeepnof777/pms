<?php
// Delivery status Icon
if ($proposal->email_status == \models\Proposals::EMAIL_SENT || $proposal->email_status == \models\Proposals::EMAIL_EDITED) {
    if ($proposal->deliveryTime){
?>
    <span class="badge blue tiptipleft" title="Delivered: <?php echo date('m/d/Y g:ia', realTime($proposal->deliveryTime)); ?>">D</span>
<?php
    }
    else if ($proposal->last_activity > 1554910676){
?>
    <span id="noDelivery_<?php echo $proposal->proposalId; ?>">
        <img class="tiptipleft noDelivery" data-proposal_id="<?php echo $proposal->proposalId; ?>"
             title="No delivery confirmation" src="/3rdparty/icons/warning-sign.png" />
    </span>
<?php
    }
}