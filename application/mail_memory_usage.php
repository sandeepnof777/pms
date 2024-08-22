<?php
ob_start();
echo $this->benchmark->memory_usage();

$mem = ob_get_contents();
ob_end_clean();
//mail('chris@rapidinjection.com', 'test mb usage', $mem);