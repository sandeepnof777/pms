<?php

$pageViewData = json_decode($proposalView->getViewData());


if($pageViewData){
    ?>
    <br/>

<table class="striped-table view-page-data-table" width="80%" style="margin-top:30px;text-align:left;font-size:17px;margin:auto;"><tr style="text-align:center"><th colspan="2">Page Times</th></tr>
    <?php
    foreach ($pageViewData as $k => $v) {
        if ($k !== 'service_section') {
            if ($v > 0) { ?>

                <tr><td style="text-align:left" width="150"><?=ucfirst($k);?></td><td style="text-align:right"><?= secondsToTime($v);?></td></tr>
       <?php
            }
        }

    }
    ?>
    </table>
    <?php
}else{
    echo '<table><tr style="text-align:center"><th colspan="2">Page Times</th></tr><tr><td>No Section Viewed</td><tr></table>';
}


?>

