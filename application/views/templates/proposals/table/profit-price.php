<?php if($proposal->profit_margin_value ==0){ echo '-';}else{ ?>
<span class="tiptip" title="Profit Margin: <?= ($proposal->profit_margin_percent>0)? $proposal->profit_margin_percent.'%' :'' ;?>"><?php  echo ($proposal->profit_margin_value<0) ? '-' : ''.'$'.str_replace('.00', '', number_format(abs($proposal->profit_margin_value), 2, '.', ','));?></span>
<?php } ?>