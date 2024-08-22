<?php
// Delivery status Icon
switch ($proposal->estimate_status_id) {
    case \models\EstimateStatus::NOT_STARTED:
        $class = 'fa-calculator';
        $title = 'Not Started';
        break;
    case \models\EstimateStatus::IN_PROGRESS:
    case \models\EstimateStatus::ALL_SERVICES_ESTIMATED:
        $class = 'fa-pencil';
        $title = 'In Progress';
        break;
    case \models\EstimateStatus::COMPLETE:
        $class = 'fa-check-circle';
        $title = 'Complete';
        break;
    case \models\EstimateStatus::LOCKED:
        $class = 'fa-lock';
        $title = 'Locked';
        break;
}?>

<i class="fa fa-fw <?=$class;?> tiptipleft" title="<?=$title;?>" ></i>

