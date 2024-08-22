<?php
if (isset($accounts[$prospect->account])) {
    ?>
    <span class="tiptip"
          title="<?php echo $accounts[$prospect->account]->getFullName() ?>"><?php
        $names = explode(' ', trim($accounts[$prospect->account]->getFullName()));
        foreach ($names as $name) {
            if ($name) {
                echo substr($name, 0, 1) . '. ';
            }
        }
        ?></span>
    <?php
} else {
    echo 'Not Assigned';
} ?>