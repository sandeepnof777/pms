<div style="position: relative">
<?php 
$show_br_btn =0;
$estimate_permission = 0;
$estimate_status =0;
$email_permission =1;
$show_signature_btn = 0;

// echo "hasQB ".$userAccount->getCompany()->hasQB();
// echo "<br>";
// echo "hasFullAccess  ".$userAccount->hasFullAccess();
// echo "<br>";
// echo "proposalStatus  ".$proposal->proposalStatus;
// echo "<br>";
// echo "INVOICED ". \models\Status::INVOICED_QB;
// echo "<br>";
// echo "QBID ". $proposal->QBID;
// echo  "<br>";

 
if ($userAccount->getCompany()->hasQB() && $userAccount->hasFullAccess() && $proposal->proposalStatus != \models\Status::INVOICED_QB && !$proposal->QBID) { 
    $show_br_btn =1;
}
 
if ($userAccount->hasEstimatingPermission() ) {
    $estimate_permission = 1;
}
if($proposal->job_cost_status == 3 && $proposal->win_date != NULL) {
    $estimate_status =1;
}else if($proposal->win_date != NULL && $proposal->job_cost_status != 3) {
    $estimate_status =2;
}

if ($userAccount->requiresApproval()) {
    // Check if we're above the approval limit
    if ($userAccount->getApprovalLimit() <= $proposal->price) {
        // Has it been approved already
        if (!$proposal->approved) {
            $email_permission =0;
        }
    }
}
if (!$userAccount->isAdministrator() && ($userAccount->getFullAccess() == 'no')) { //check if user is not an admin
    //if user is branch manager and the proposal is in a differnet branch
    if ($userAccount->getAccountId() != $proposal->owner ) {
        $show_signature_btn = 1;
    }
}
if($proposal->company_signature_id){
    $show_signature_btn = 1;
}

if (($userAccount->getCompany()->getCompanyId() == $proposal->company_id) && (($userAccount->isAdministrator()) || ($userAccount->getFullAccess() == 'yes') || ($userAccount->getAccountId() == $proposal->owner))) {
    $edit_client_permission = 1;
}else{
    $edit_client_permission = 0;
}


?>
<div class="dropdownButton">
    <a class="dropdownToggle1 proposalsTableDropdownToggle" href="javascript:void(0);" style="font-weight: 700"
    data-project-id="<?=$proposal->proposalId;?>"
    data-account-id="<?=$proposal->account;?>"
    data-project-name="<?=$proposal->projectName;?>"
    data-client-name ="<?php echo $proposal->clientAccountName; ?>"
    data-client-id="<?=$proposal->clientId;?>"
    data-has-estimate="<?php echo ($proposal->estimate_status_id == 1) ? 0 : 1; ?>"
    data-has-audit-key="<?=$proposal->audit_key;?>"
    data-access-key="<?=$proposal->access_key;?>"
    data-show-qbbtn="<?=$show_br_btn;?>"
    data-estimate-permission="<?=$estimate_permission;?>"
    data-estimate-status="<?=$estimate_status;?>"
    data-email-permission="<?=$email_permission;?>"
    data-proposal-url="<?=$proposalViewUrl;?>"
    data-proposal-access-key="<?=$proposal->access_key;?>"
    data-contact-name="<?php echo $proposal->clientFN . ' ' . $proposal->clientLN ; ?>"
    data-proposal-hidden="<?=$proposal->is_hidden_to_view;?>"
    data-proposal-excluded="<?=$proposal->resend_excluded;?>"
    data-proposal-auto-resend="<?=$proposal->resend_enabled;?>"
    data-business-type="<?=($proposal->business_type_id)?:0;?>" 
    data-contact-email="<?=$proposal->clientEmail; ?>"
    data-proposal-views ="<?=$proposal->proposal_view_count; ?>"
    data-company-signature ="<?=$show_signature_btn; ?>"
    data-client-edit-permission="<?=$edit_client_permission;?>"
    data-is-child-company = "<?= ($is_child_company)?'1':'0';?>"
    data-is-shared-proposal = "<?= $shared_proposal;?>"
    >GO</a>
    
</div>