<?php
$projectName = '';
if ($proposal->declined) {
    $projectName .= '<span class="tiptip" title="Proposal has been declined. Please fix and resubmit."><b>[X]</b></span> ';
}
if ($proposal->approvalQueue) {
    $projectName .= '<span class="tiptip" title="Proposal waiting to be approved."><b>[Q]</b></span> ';
}
if ($proposal->duplicateOf) {
    $projectName .= '<span class="tiptip proposal-table-duplicate-name" data-proposal-id="' . $proposal->proposalId . '" title="Duplicate Proposal. Its price will not show in the Pipeline."><b>[D]</b></span> ';
}
if ($proposal->unapproved_services) {
    $projectName .= '<span class="tiptip" title="Requires Approval"><b>[A]</b></span> ';
}
//$projectName .= $proposal->projectName;

?>
<?php echo $projectName; ?><span class="price-tiptip2 proposal_table_proposal_name_tiptip tiptip" title="Loading..." data-proposal-id="<?=$proposal->proposalId;?>"
     ><?php echo $proposal->projectName; ?></span>