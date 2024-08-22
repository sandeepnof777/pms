<h4><i class="fa fa-fw fa-envelope"></i> Proposal Links</h4>
<hr />
<div class="materialize">
    <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
             id="groupActionsButtonPreview" style="display: none;">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="materialize groupActionsContainer" style="width:298px">
                <div class="collection groupActionItems" style="width:298px; float:left">
                    <a href="#" id="groupSetExpriry" data-proposal-id="<?= $proposal->getProposalId();?>" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Set Expiry 
                    </a>
                    <a href="#" id="groupRemoveExpiry" data-proposal-id="<?= $proposal->getProposalId();?>" class="collection-item iconLink">
                        <i class="fa fa-fw fa-calendar"></i> Remove Expiry
                    </a>
                    <a href="#" class="groupPreviewEnableDisable collection-item iconLink" data-is-enable="1" data-proposal-id="<?= $proposal->getProposalId();?>" >
                        <i class="fa fa-fw fa-check-circle"></i> Enable
                    </a>
                    <a href="#" class="groupPreviewEnableDisable collection-item iconLink" data-is-enable="0" data-proposal-id="<?= $proposal->getProposalId();?>" >
                        <i class="fa fa-fw fa-ban fa-ban-dark"></i> Disable
                    </a>
                    
                    <a href="#" class="groupSignatureEnableDisable collection-item iconLink" data-is-enable="1" data-proposal-id="<?= $proposal->getProposalId();?>" >
                        <i class="fa fa-fw fa-check-circle"></i> Enable Signature
                    </a>
                    <a href="#" class="groupSignatureEnableDisable collection-item iconLink" data-is-enable="0" data-proposal-id="<?= $proposal->getProposalId();?>" >
                        <i class="fa fa-fw fa-ban fa-ban-dark"></i> Disable Signature
                    </a>

                </div>
            </div>
        </div>
    </div> 
<style>
#editProposalViews_wrapper{
    margin-top: 40px!important;
}
#editProposalViews{
padding-top: 12px;
}
</style>                   
<table id="editProposalViews" class="boxed-table" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 20px;"><input type="checkbox" id="previewMasterCheck"></th>
            <th>Status</th>
            <th>Email</th>
            <th>Sent</th>
            <th>Expires</th>
            <th>Views</th>
            <th>Last Viewed</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="date-change-confirm" title="Update Proposal Date">
        <p>This will update when the proposal Preview Expiry date</p>
        <br/>
        <input type="hidden" id="expiry_preview_id" >
        <input type="hidden" id="expiry_proposal_id" >
        <p>Select Date: <input type="text" id="dcDate"/></p>
    </div>

<div id="group-expiry-date-change-confirm" title="Update Proposal Date">
    <p>This will update when the proposal Preview Expiry date</p>
    <br/>
   
    <input type="hidden" id="group_expiry_proposal_id" >
    <p>Select Date: <input type="text" id="groupdcDate"/></p>
</div>

    