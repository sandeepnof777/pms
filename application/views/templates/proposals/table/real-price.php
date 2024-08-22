<?php
    $realPrice = ($proposal->price) ? str_replace(array(',', '$'), '', $proposal->price) : 0;
    echo $realPrice;