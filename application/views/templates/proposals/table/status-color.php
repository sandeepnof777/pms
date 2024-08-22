<?php
// Load status info
$proposalStatus = $this->em->find('\models\Status', $proposal->proposalStatus);
if ($proposalStatus) {
    echo $proposalStatus->getColor();
}
?>
