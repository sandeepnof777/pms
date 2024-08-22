

<div id="notes-section">
<?php
//proposal attachments
if ($proposal->getWorkOrderNotes() || count($work_order_notes)) {
   
    if($i!=1){ ?>
            <div style="page-break-after: always"></div>
    <?php }?>
    <!--Hide Header code start-->

    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">Notes</h1>

    <?php echo $proposal->getWorkOrderNotes(); ?>
    <br/>
        <?php
            foreach($work_order_notes as $work_order_note){

                echo '<div>'.$work_order_note->getNoteText().'</div><br/>';

            }
                    
}

?>
</div><!--notes-section-->