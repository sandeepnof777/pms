<?php
    $profit_realPrice = ($proposal->profit_margin_value) ? str_replace(array(',', '$'), '', $proposal->profit_margin_value) : 0;
    echo $profit_realPrice;