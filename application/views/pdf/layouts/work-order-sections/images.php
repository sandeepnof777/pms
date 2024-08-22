
 <?php
 $images2 = array();
//proposal images
if (count($images)) {
    foreach ($images as $k => $image) {
        if ($images[$k]['image']->getActivewo()) {
            $img = array();
            $img['src'] = $images[$k]['src'];
            $img['path'] = $images[$k]['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $images[$k]['orientation'];
                $img['title'] = $images[$k]['image']->getTitle();
                $img['notes'] = $images[$k]['image']->getNotes();
                $img['image_layout'] = $images[$k]['image']->getImageLayout();
                $images2[] = $img;

   
             }
        }
    }
          //new world order code
          $imageCount = 0; //image counter
          $tableOpen = 0; //variable to check if the table open
          $old_layout = 0;
          $j=0;
          ?>
    <div style="page-break-after: always;"></div>
    <div id="images">
    <?php
    foreach ($images2 as $image) {
        $j++;
        switch ($image['image_layout']) {
            case 1:
                if ($tableOpen) {
                    if ($old_layout == 2) {
                    
                    //    //close tr's if necessary...
                        if ($imageCount % 4) {
                            echo '<td></td></tr>';
                        }
                       //close table
                       echo '</table>';
                       $tableOpen =0;
                   }
               }
                //open table
                if ($old_layout !=1) {
                    $imageCount = 0;
                }
                if (!($imageCount % 2)) {
                    if($j != 1){
                        echo '<div style="page-break-after: always"></div>';
                    }
                    ?>
                    <table  border="0" align="center" ><?php
                    $tableOpen = 1;
                  }
                //display image
                ?>
                 <tr  align="center">
                    <td width="100%" >
                        <h2 style="text-align: center;font-weight: 400;"><?php echo $image['title']; ?></h2>
                        <div><img src="<?php  echo $image['src'] ?>" alt="" style="height:290px; width: auto; margin: 0; padding: 0; border:1px solid black;"/></div>
                        <div class="smallNotes"><?php echo $image['notes'] ?></div>
                    </td>
                </tr>
                <?php
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 2 == 0) {
                    ?>
                    </table>
                    <?php
                    $tableOpen = 0;
                }
                break;
            case 2:
                if ($tableOpen) {
                    if ($old_layout == 1) {
                            if ($imageCount % 2) {
                             echo '<td></td></tr>';
                         }
                       //close table
                        echo '</table>';
                        $tableOpen =0;
                    } else {
               
                   }
               }
               if ($old_layout !=2) {
                    $imageCount = 0;
                 }
                // //open table
                 if (!($imageCount % 4)) {

                    if($j != 1){
                        echo '<div style="page-break-after: always"></div>';
                    }
                    ?>
                    <table width="100%" border="0"  align="center"><?php
                    $tableOpen = 1;
                }
                //display image
            if (!($imageCount % 2)) {
                ?>
                <tr>
            <?php
            }
                ?>
                <td width="50%"  valign="top" align="center">
                    <h2 style="font-weight: 400;"><?php echo $image['title'] ?></h2>

                    <div>
                        <img src="<?php echo $image['src'] ?>" alt="" style="height: 160px; width: auto;"/>
                    </div>
                    <div class="smallNotes"><?php echo $image['notes'] ?></div>
                </td>
                <?php
            if ($imageCount % 2) {
                ?>
                </tr>
            <?php
            }
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 4 == 0) {
                    ?>
                    </table>
                    <?php
                    $tableOpen = 0;
                }
                break;
            default: //1 image per page
            if ($tableOpen) {
             //echo $old_layout;
                if ($old_layout != 0) {
                    if ($old_layout == 2 ) {
                        //echo $imageCount;
                        if(($imageCount % 4) != 2){
                           //echo 'test';die;
                            echo '<td></td></tr></table>';
                            $tableOpen =0;
                        }else{
                            echo '</table>';
                            $tableOpen =0;
                            if(count($images2) != $j){
                               // echo '</table>';
                            }
                        }
                    }else if($old_layout == 1){
                        if ($imageCount % 2) {
                                 echo '<td></td></tr>';
                             }
                            
                        }
                        echo '</table>';
                        $tableOpen =0;
                   //close table
                   //echo '</table>';
                   //echo 'test3';die;
               }
               //echo '<div style="page-break-after: always"></div>';
           }
           if($j != 1){
                echo '<div style="page-break-after: always"></div>';
            }
       ?>
                   <div class="check" ></div>
                    <h2 style="text-align: center;font-weight: 400;"><?php echo $image['title']; ?></h2>
                    <div style="margin-left: auto;margin-right: auto;display:block;width:300px;" >
                        <img  style="width:auto; height:400px;" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $image['src']; ?>" >
                    </div>
                    <p>&nbsp;</p>
                    <div style="float: left;margin-top:370px;font-size:12px;text-align:center;">
                    <?php echo $image['notes']; ?>
                   </div>

                     
                <?php
                break;
        }
        $old_layout = $image['image_layout'];
    }
    //close tables in case they are not closed
    if ($tableOpen) {
        if ($old_layout == 1) {
           //close table
           echo '</table>';
        } else {
           //close tr's if necessary...
            if ($imageCount % 2) {
                echo '<td></td></tr>';
            }
           //close table
           echo '</table>';
       }
   }
   ?>
    </div>
<?php } ?>
 