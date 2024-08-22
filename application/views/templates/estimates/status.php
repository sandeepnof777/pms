<?php
// Load status info
$estimateStatus = $this->em->find('\models\EstimateStatus', $proposal->estimate_status_id);
if ($estimateStatus) {
    echo $estimateStatus->getName();
}
?>
