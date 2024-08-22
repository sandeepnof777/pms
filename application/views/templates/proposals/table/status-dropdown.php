<?php
// Load status info
$proposalStatus = $this->em->find('\models\Status', $proposal->proposalStatus);
$statusText = ($proposalStatus) ? $proposalStatus->getText() : '';
?>
<div style="display: flex;justify-content: space-between;">
    <div>
        <span class="tiptip change-proposal-status "  style="left: 0px;" title="Click to change status"  id="status_<?php echo $proposal->proposalId; ?>"><?php echo $statusText; ?></span>
    </div>

    <div>
        <span style="display: flex;float:right;justify-content: flex-end;text-align:right;font-size: 14px;">
            <?php
                if($proposal->resend_excluded){
                ?><i class="fa fa-fw fa-envelope-square tiptip include_resend_individual" rel="<?=$proposal->proposalId;?>" style="color: #ff0000bf;cursor:pointer" title="This Proposal is excluded from Campaigns" ></i>

            <?php }
            
            if($proposal->signature_id){
            ?><i class="fa fa-fw fa-pencil-square-o tiptipright proposal_signee_details_tiptip" data-proposal-id="<?php echo $proposal->proposalId; ?>" title="Loading..." style="cursor:pointer;margin-top: 1px;"></i>

            <?php }
            
            if($proposal->is_hidden_to_view){
            ?><i class="fa fa-fw fa-eye-slash tiptip" title="Proposal Hidden" style="cursor:pointer"></i>

            <?php }
            $displayAddNote = ($proposal->ncount) ? false : true;
            ?>
            <a href="javascript:void(0);" data-has-tiptip="0" class="view-notes proposal_table_notes_tiptip hasNotes" rel="<?php echo $proposal->proposalId; ?>"  id="notes_tip_<?php echo $proposal->proposalId; ?>" data-val="<?php echo $proposal->proposalId; ?>"  style="font-size: 14px;color:#a5a2a2; display: <?php echo ($displayAddNote) ? 'none' : 'block'; ?>"><i class="fa fa-fw fa-sticky-note-o "  ></i></a>
            <a href="javascript:void(0);"  class="view-notes tiptip hasNoNotes" title="Add Proposal Notes"  rel="<?php echo $proposal->proposalId; ?>"  style="font-size: 14px;color:#a5a2a2;float: right; display: <?php echo ($displayAddNote) ? 'block' : 'none'; ?>"><i class="fa fa-fw fa-plus"  ></i></a>
        </span>
    </div>
</div>