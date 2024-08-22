
<br />
<p><i class="fa fa fw fa-info-circle"></i> Add notes here that will only be visible to your crew on the work order.</p>
<br />

<textarea id="workOrderNotes">
    <?= $proposal->getWorkOrderNotes(); ?>
</textarea>

<a class="btn update-button saveIcon right" id="saveWorkOrderNotes">
    Save Work Order Notes
</a>

<div class="clearfix"></div>