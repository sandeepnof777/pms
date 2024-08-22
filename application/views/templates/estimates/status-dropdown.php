<?php
// Load status info
$estimateStatus = $this->em->find('\models\EstimateStatus', $proposal->estimate_status_id);
$statusText = ($estimateStatus) ? $estimateStatus->getName() : '';
?>
<span class="tiptip change-proposal-status" title="Click to change status" id="status_<?php echo $proposal->proposalId; ?>"><?php echo $statusText; ?></span>