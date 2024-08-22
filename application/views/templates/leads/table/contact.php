

<span class="tiptip"
      title="<strong>Title:</strong><?php echo $lead->title ?><br>
      <strong>Cell:</strong><?php echo $lead->cellPhone; ?><br>
      <strong>Phone:</strong> <?php echo $lead->businessPhone; ?><br />
      <strong>Email:</strong> <?php echo $lead->email; ?><br />
      <?php if(count($types)>0){
             $business_type_tooltip = array();
             foreach($types as $type){
                
                 array_push($business_type_tooltip,$type->type_name);
             }
             $business_type_tooltip = implode(', ',$business_type_tooltip);
            ?>
            <strong>Business:</strong> <?=$business_type_tooltip;?>
           
      <?php } ?>
      <p class='clearfix'></p>"><?php echo $lead->firstName . ' ' . $lead->lastName; ?></span>