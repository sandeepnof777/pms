<?php
$branch = (isset($branches[$proposal->branch])) ? $branches[$proposal->branch]->getBranchName() : 'Main';
echo $branch;