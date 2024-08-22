<?php
if (!$company->nextExpiry) {
    echo 'Expired';
    $days = 9999;
} else {
    $days = ceil(($company->nextExpiry - time()) / 86400);
    echo $days . ' Days';
}
?>