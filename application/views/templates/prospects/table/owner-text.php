<?php
if (isset($accounts[$prospect->account])) {
    echo $accounts[$prospect->account]->getFullName();
} else {
    echo 'ZZZ';
}