<?php
if (isset($accounts[$lead->account])) {
?>
<span class="tiptip"
      title="<?php echo $accounts[$lead->account]->getFullName() ?>"><?php
    $names = explode(' ', trim($accounts[$lead->account]->getFullName()));
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