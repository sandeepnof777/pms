<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"  crossorigin="anonymous">
      <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/lightbox.min.css">
      <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">
      <script type="text/javascript" src="../../3rdparty/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../3rdparty/sweetalert/sweetalert2.min.css" media="all">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <style>
          
      .nav-wrapper{background-color: #FFF;}
      .has_item_value {
    background-color: #b1e5fb!important;
}
.img-wrap {
    position: relative;
    display: inline-block;
    font-size: 0;
}
.img-wrap .remove_image {
    position: absolute;
    top: 0px;
    font-family: sans-serif;
    right: 0px;
    z-index: 100;
    background-color: red;
    padding: 5px 2px 2px;
    color: #FFF;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
}
.lbl{cursor:pointer;    color: #444444;

    border: 1px solid;
    text-align: center;
    padding: 5px;
    border-radius: 3px;
    display: block;}
      .collapsible li.active i.expand {
  -ms-transform: rotate(180deg); /* IE 9 */
  -webkit-transform: rotate(180deg); /* Chrome, Safari, Opera */
  transform: rotate(180deg);
}
.collapsible li i.expand {
  -ms-transform: rotate(90deg); /* IE 9 */
  -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
  transform: rotate(90deg);
}
.add_item_btn{
  display:none;
  margin-left: auto;

}
.collapsible li.active .add_item_btn{
  display:block;
}
.collapsible-body{
    padding:10px
}
.btn{
    background-color: #25aae1
}
.btn:focus,.btn:hover{
    background-color: #25aae1
}

tr.header_tr_border>td{
    border-bottom: 2px solid #fff;
}

tr:not(.header_tr)>td{
    border-bottom: 2px solid #fff;
}
.est_checked_hide{color: transparent!important;}
.collapsible-header i{margin-right: 0px}
td, th{padding: 5px;}
.unsaved_item{
    background-color: #fbee62b0 !important;
}
@media only screen and (max-width: 600px)  {
    .input_quantity{
        margin-bottom: 1px!important;
       
    }
    .item_unit_name{
        margin-right: 5px;
        font-size:12px;
    }
    .item_unit_name::before {

    content: "\a";
    white-space: pre;

    }

}

@media only screen and (min-width: 600px)  {
    .item_unit_name{
        margin-left: 5px;
    }
    .span_quantity{
        display: flex;
        margin-left: 53%;
    }
    .item_unit_name::before {
        content: none;

white-space: revert;
        

        }
}

.secondary-content {
    float: right;
    color: #25aae1;
}


      </style>
    </head>

    <body>

    <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo center" ><img src="../../static/images/logo.png" /></a>
    </div>



  </nav>
  <div class="">


  <div class="row" style="margin-bottom:0px">
        <p style="float:left;font-weight:bold;font-size: 16px;padding-left:15px;margin-bottom:0px"><?php echo $proposal->getClient()->getClientAccount()->getName(); ?>
        - <?php echo $proposal->getProjectName(); ?> </p>
    </div>

    <ul class="collapsible" >
        <li>
            <div class="collapsible-header"><b>Job Details</b><i class="material-icons right expand">expand_less</i></div>
            <div class="collapsible-body row" style="padding:5px">


            <div class="col s12">

                <div class="col s6">

                    <p><strong>Project Name:</strong></p>

                    <?php if ($proposal->getJobNumber()): ?>
                        <p><strong>Job Number:</strong></p>
                    <?php endif;?>

                    <p><strong>Project Point:</strong></p>

                    <p><strong>Project Address:</strong></p>
                </div>

                <div class="col s6">

                    <p><?php echo $proposal->getProjectName(); ?></p>

                    <?php if ($proposal->getJobNumber()): ?>
                        <p><?php echo $proposal->getJobNumber(); ?></p>
                    <?php endif;?>

                    <p><?php echo $proposal->getOwner()->getFullName(); ?></p>
                    <p><?php echo $proposal->getProjectAddressString(); ?></p>
                </div>

                </div>
                <div class="col s12">

                <div class="col s6">
                    <p><strong>Contact Name:</strong></p>
                    <p><strong>Account:</strong></p>
                    <p><strong>Phone:</strong></p>
                    <p><strong>Cell:</strong></p>
                    <p><strong>Email:</strong></p>
                </div>

                <div class="col s6">
                    <p><?php echo $proposal->getClient()->getFullName(); ?></p>
                    <p><?php echo $proposal->getClient()->getClientAccount()->getName(); ?></p>
                    <p><?php echo $proposal->getClient()->getBusinessPhone() ?: '-'; ?></p>
                    <p><?php echo $proposal->getClient()->getCellPhone() ?: '-'; ?></p>
                    <p>
                        <a href="mailto:<?php echo $proposal->getClient()->getEmail(); ?>"><?php echo $proposal->getClient()->getEmail(); ?></a>
                    </p>
                </div>

                </div>

            </div>
        </li>

    </ul>
    <p class="complate_job_costing_msg" style="display:none;font-size: 16px;">All Item done for Job Costing</p>
    <p  style="font-size: 16px;padding-left: 10px;font-weight: bold;">Services</p>
    <div class="row">
        <ul class="collapsible">
            <?php

$count_phase = 1;
foreach ($services as $service):
    // print_r($item['phase_count']);
    $serviceSortedItems = $service['sortedItems'];
    $truckingItems = $service['truckingItems'];
    $service_details = $service['service_details'];
    $serviceFieldValues = $service['fieldValues'];
    $job_cost_price_difference = $service['job_cost_price_difference'];
    $is_service_completed = $service['is_service_completed'];
    ?>

		            <li>
		                <div class="collapsible-header service_accordion_<?=$service_details->getServiceId();?>" data-service-id="<?=$service_details->getServiceId();?>" style="display:flex; align-items:center;"><i class="material-icons expand">expand_less</i><span style="max-width:70%"> <?=$service_details->getServiceName();?></span>
		                    <!-- <span class="est_checked <?=($is_service_completed == 0) ? 'est_checked_hide' : '';?>" ><i class="fa fa-fw fa-1x fa-check-circle-o small " style="position: relative;top: 3.3px;width:21px;font-size:20px"></i></span> -->
		                    <i style=" margin-left: auto;   font-size: 16px;" class="material-icons est_checked <?=($is_service_completed == 0) ? 'est_checked_hide' : '';?>">check_circle</i>
		                </div>
		                <div class="collapsible-body">
                        <a href="javascript:void(0);" class="add_item_btn btn blue-button" style="margin-left:auto;width: 35%;height: 28px;line-height: 28px;" data-val="<?=$service_details->getServiceId();?>" ><i class="material-icons">add_circle</i><span style="position: relative;top: -5px;"> Add Item</span></a>
		                <?php

    if (count($serviceSortedItems) > 0) {
        foreach ($serviceSortedItems as $serviceSortedItem): ?>
		                                                <?php $rowTotal = 0;
        if ($serviceSortedItem['category']->getId() == '1') {
            $font_icon = 'fa-file-text-o';
        } else if ($serviceSortedItem['category']->getId() == '2') {
        $font_icon = 'fa-wrench ';
    } else if ($serviceSortedItem['category']->getId() == '3') {
        $font_icon = 'fa-male ';
    } else if ($serviceSortedItem['category']->getId() == '5') {
        $font_icon = 'fa-truck';
    } else if ($serviceSortedItem['category']->getId() == '6') {
        $font_icon = 'fa-plus-square-o';
    }
    ?>

                                                <p style="margin: 10px 0px;background-color: #efefef; padding:5px" class="category_items_toggle"><span style="float:left;margin: 0px 5px;"><i style="font-size: 1.2em;" class="fa <?=$font_icon;?> fa-fw fa-2x "></i></span><span style="font-size:15px;font-weight:bold;"><?php echo $serviceSortedItem['category']->getName(); ?></span><span style="float:right;position: relative;" >[<span class="complete_item_count"></span>/<span  class="total_item_count"></span>]</span></p>

                                                <table class="jobCostItems stripping-row"  style="width: 100%;border-collapse: separate;">

                                                    <tbody>
                                                    <?php
if (isset($serviceSortedItem['items'])) {
        foreach ($serviceSortedItem['items'] as $breaklineItem):
            $saved_values = $breaklineItem->saved_values;
            if ($breaklineItem->saved_values) {
                $saved_values = $breaklineItem->saved_values;
            } else {
                $saved_values = '';
            }
            ?>

		                                                        <tr class="header_tr header_tr_border <?=($breaklineItem->job_cost) ? 'has_item_value' : '';?>" data-item-id="<?=$breaklineItem->getId();?>"  id="tr_line_item_<?=$breaklineItem->getId();?>" data-unit-price="<?=$breaklineItem->getUnitPrice();?>" data-total-price="<?=$breaklineItem->old_total;?>" data-proposal-service-id="<?=$breaklineItem->getProposalServiceId();?>" data-quantity="<?=$breaklineItem->getQuantity();?>" data-day="<?=$breaklineItem->getDay();?>" data-hpd="<?=$breaklineItem->getHoursPerDay();?>" data-num-people="<?=$breaklineItem->getNumPeople();?>" data-base-price="<?=$breaklineItem->getBasePrice();?>" data-old-quantity="<?=$breaklineItem->old_quantity;?>" data-category-id="<?=$breaklineItem->getItemType()->getCategoryId();?>" data-val='<?php echo $saved_values; ?>'>
		                                                            <td width="5%" style="padding: 5px;"><span class="open_row tiptip" title="Details" style="float:right"><i class="fa fa-fw fa-1x fa-chevron-right  " style="cursor:pointer;"></i></span></td>
		                                                            <td width="45%" style="text-align:left;"><?php
    //print_r($breaklineItem);die;

            $check_type = $breaklineItem->item_type_time;
            echo '<b>' . $breaklineItem->getItemType()->getName() . '</b>';

            ?>
		                                                                </br>
		                                                                <?php
    if ($serviceSortedItem['category']->getId() == \models\EstimationCategory::CUSTOM) {
                echo $breaklineItem->getCustomName();
            } else {
                echo $breaklineItem->getItem()->getName();
            }

            ?>
		                                                            </td>
		                                                            <td width="5%"></td>
		                                                            <td width="45%" style="text-align:right;"><span class="span_quantity tr_edit_span"><input class="input_quantity tr_edit_input number_field" style="width: 60px; font-weight: bold; text-align: right;height: 20px !important;font-size: 18px !important;" onselectionchange="return false" type="text" value="<?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>">
		                                                                <span class="item_unit_name"><?php echo $breaklineItem->getItem()->getUnitModel()->getName(); ?></span>
		                                                            </td>


		                                                            <td width="5%" style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_save_btn tiptip tr_action_btn"   title="Save"  ><i class="material-icons">save</i></a></span></td>
		                                                        </tr>

		                                                    <tr data-base-price="<?=$breaklineItem->getBasePrice();?>" data-item-id="<?=$breaklineItem->getId();?>">

		                                                    <?php
    if ($serviceSortedItem['category']->getId() != 1) {
                if ($check_type) {

                    echo '<td colspan="4"><span style="display: inline-block;width: 33%;"><b>Days:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getDay(), 2, '.', ',')) . '" class="input_day tr_edit_input number_field" type="text"  style="width: 30px;font-size: 18px !important;    font-weight: bold;"></span><span style="display: inline-block;width: 33%;"><b>#:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getNumPeople(), 2, '.', ',')) . '" class="input_num_people tr_edit_input number_field" type="text"  style="width: 30px;font-weight: bold;font-size: 18px !important;"></span><span style="display: inline-block;width: 33%;"><b>HPD:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getHoursPerDay(), 2, '.', ',')) . '" class="input_hpd tr_edit_input number_field" type="text" style="width: 30px;font-weight: bold;font-size: 18px !important;" ></span></td>';
                } else {
                    echo '<td></td><td></td><td></td>';
                }

            } else {
                if (count($saved_values) > 0) {
                    $saved_values = json_decode($saved_values);
                    $measurement = '';
                    $unit = '';
                    $depth = '';
                    for ($i = 0; $i < count($saved_values); $i++) {
                        if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                            // if($breaklineItem->job_costing==1){
                            //     $measurement = str_replace('.00', '',$breaklineItem->area);
                            // }else{
                            $measurement = str_replace('.00', '', $saved_values[$i]->value);
                            //}

                        } else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                        if (stripos($saved_values[$i]->value, 'yard')) {
                            $unit = 'Sq. Yd';
                        } else {
                            $unit = 'Sq. Ft';
                        }
                    } else if ($saved_values[$i]->name == 'depth') {
                        // if($breaklineItem->job_costing==1){
                        //     $depth = str_replace('.00', '', $breaklineItem->depth);
                        // }else{
                        $depth = str_replace('.00', '', $saved_values[$i]->value);
                        // }

                    }
                }
                echo '<td colspan="4"><div style="width: 50%;float: left;"><span style="font-size: 14px;font-weight: bold;display: inherit;">Area</span><span>' . $measurement . '</span> <span>' . $unit . '</span></div><div style="width: 50%;float: left;"><span style="font-size: 14px;font-weight: bold;display: inherit;">Depth</span><span>' . $depth . '</span><span> Inch</span></div></td>';
            } else {
                $saved_values = [];
                echo '<td></td><td></td><td></td>';
            }
        }
        ?>
                                                            <td><a href="javascript:void(0);" style="float: right;margin-left: 2px; <?=($breaklineItem->job_cost) ? '' : 'display:none';?>" class="btn tr_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="material-icons">delete</i></a>
                                                            <!-- <a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_item_reset_btn tiptip tr_action_btn"   title="Reset"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a> -->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                        <div class="row">

                                                            <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                                <div class="image_div" style="display: inline-block;max-width: 100%;">
                                                                    <?php
$add_icon1 = 'block';
        $image_preview1 = '';
        if ($breaklineItem->job_cost_files) {
            if (isset($breaklineItem->job_cost_files[0])) {
                $image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/'  .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '"  /></a></span>';
                $add_icon1 = 'none';
            }
        }
        ?>
                                                                    <label class="lbl add_icon1" style='display:<?=$add_icon1?>;' for="image1_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>First Ticket</span></label>
                                                                    <form method="post" name="image_upload_form" id="image1_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                        <input type="file" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" data-file-number="1" class="form-control" style="display:none" id="image1_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                        <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                        <!-- <input type="button" data-file-number="1"  onclick="file_upload(this)" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                    </form>
                                                                    <div class="image_preview1">
                                                                        <?=$image_preview1?>
                                                                    </div>
                                                                    <!-- <div class="progress" style="height:15px;display:none;">
                                                                            <div class="bar"></div >
                                                                            <div class="percent">0%</div >
                                                                        </div>
                                                                    <div class="status"></div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                                <div class="image_div" style="display: inline-block;max-width:100%">
                                                                    <?php
$add_icon2 = 'block';
        $image_preview2 = '';
        if ($breaklineItem->job_cost_files) {
            if (isset($breaklineItem->job_cost_files[1])) {
                //$image_preview2 =   '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing').'/'.$breaklineItem->job_cost_files[1]->getFileName().'"  /><span data-file-id="'.$breaklineItem->job_cost_files[1]->getId().'" data-file-number="2" class="remove_image"><i  class="fa fa-trash fa-fw fa-2x "></i></span></span>';
                $image_preview2 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[1]->getId() . '" data-file-number="2" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') .  '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '"  /></a></span>';
                $add_icon2 = 'none';
            }
        }
        ?>
                                                                    <label class="lbl add_icon2" style='display:<?=$add_icon2?>; max-width:100%' for="image2_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>Last Ticket</span></label>
                                                                    <!-- <label class="lbl add_icon2" style='color:#444444;display:<?=$add_icon2?>;' for="image2_file_<?=$breaklineItem->getId();?>"><i  class="fa fa-camera fa-fw fa-2x "></i></label> -->
                                                                    <form method="post" name="image_upload_form" id="image2_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                        <input type="file" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" data-file-number="2" class="form-control" style="display:none" id="image2_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                        <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                        <!-- <input type="button" data-file-number="2"  onclick="file_upload(this)" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                    </form>
                                                                    <div class="image_preview2">
                                                                        <?=$image_preview2?>
                                                                    </div>
                                                                    <!-- <div class="progress" style="height:15px;display:none;">
                                                                            <div class="bar"></div >
                                                                            <div class="percent">0%</div >
                                                                        </div>
                                                                    <div class="status"></div> -->
                                                                </div>
                                                            </div>

                                                        </div>




                                                        </td>
                                                        <!-- <td class="image_preview" colspan="3">
                                                            <?php

        //  if(count($breaklineItem->job_cost_files)>0){
        //     print_r($breaklineItem->job_cost_files);
        //      foreach($breaklineItem->job_cost_files as $files){
        //         print_r($files);
        // //     echo  '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing/').$files->getFileName().'"  /></span>';
        //      }
        //  }
        ?>
                                                        </td> -->


                                                    </tr>

                                                    <?php endforeach;}?>
                                                    <!-- custom job items list -->

                                                    <?php
if (isset($serviceSortedItem['job_cost_items'])) {

        foreach ($serviceSortedItem['job_cost_items'] as $jobCostItem):

        ?>

                                                        <tr class="has_item_value header_tr header_tr_border" data-item-id="<?=$jobCostItem->getId();?>" id="tr_job_cost_item_<?=$jobCostItem->getId();?>" data-unit-price="<?=$jobCostItem->getActualUnitPrice();?>" data-total-price="<?=$jobCostItem->getActualTotalPrice();?>" data-proposal-service-id="<?=$jobCostItem->getProposalServiceId();?>" >
                                                        <td width="5%" style="padding: 5px;"><span class="open_row tiptip" title="Details" style="float:right"><i class="fa fa-fw fa-1x fa-chevron-right  " style="cursor:pointer;"></i></span></td>
                                                            <td width="45%" style="text-align:left;"><b>Job Cost Item</b>
                                                            </br>
                                                            <?php echo $jobCostItem->getCustomItemName(); ?></td>
                                                            <td width="5%"></td>
                                                            <td width="40%" style="text-align:right;">
                                                            <span class="span_total tr_edit_span"><?php echo '$' . str_replace('.00', '', number_format($jobCostItem->getActualTotalPrice(), 2, '.', ',')); ?></span>

                                                                <?php // echo $breaklineItem->getItem()->getUnitModel()->getName(); ?>
                                                            </td>


                                                            <td width="10%" style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_save_btn tiptip tr_action_btn"   title="Save"  ><i class="material-icons">save</i></a></span></td>
                                                        </tr>
                                                        <tr>
                                                        <th width="5%"></th>

                                                        <th width="28%" >Quantity</th>
                                                        <th ></th>
                                                        <th width="28%">Total Price</th>


                                                        <th width="10%">Action</th>
                                                        </tr>
                                                    <tr id="tr_job_cost_input_<?=$jobCostItem->getId();?>" data-item-id="<?=$jobCostItem->getId();?>">
                                                    <td></td>
                                                    <td><input class="input_quantity2 tr_edit_input number_field" style="width: 60px; text-align: right;font-size: 18px !important;font-weight: bold;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualQty()); ?>"></td>
                                                    <td></td>
                                                    <td><input class="input_job_item_total tr_edit_input currency_field" style="width: 80px;font-size: 18px !important;font-weight: bold;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualTotalPrice()); ?>"></td>
                                                    <td><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="material-icons">delete</i></a>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="5">
                                                    <div class="row">

                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width: 100%;">
                                                                <?php
                                                                $add_icon1 = 'block';
                                                                    $image_preview1 = '';
                                                                    if ($jobCostItem->job_cost_files) {
                                                                        if (isset($jobCostItem->job_cost_files[0])) {
                                                                            $image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $jobCostItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-' . $jobCostItem->getId() . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[0]->getFileName() . '"  /></a></span>';
                                                                            $add_icon1 = 'none';
                                                                        }
                                                                    }
                                                                ?>
                                                                <label class="lbl add_icon1" style='display:<?=$add_icon1?>;' for="image1_file_<?=$jobCostItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>First Ticket</span></label>
                                                                <form method="post" name="image_upload_form" id="image1_upload_form_<?=$jobCostItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image1_upload_form_<?=$jobCostItem->getId();?>" data-file-number="1" class="form-control" style="display:none" id="image1_file_<?=$jobCostItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$jobCostItem->getId();?>">
                                                                    <!-- <input type="button" data-file-number="1"  onclick="file_upload(this)" data-form-id="image1_upload_form_<?=$jobCostItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview1">
                                                                    <?=$image_preview1?>
                                                                </div>
                                                                <!-- <div class="progress" style="height:15px;display:none;">
                                                                        <div class="bar"></div >
                                                                        <div class="percent">0%</div >
                                                                    </div>
                                                                <div class="status"></div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width:100%">
                                                                <?php
                                                                    $add_icon2 = 'block';
                                                                    $image_preview2 = '';
                                                                    if ($jobCostItem->job_cost_files) {
                                                                        if (isset($jobCostItem->job_cost_files[1])) {
                                                                        $image_preview2 = '<span  class="img-wrap"><span data-file-id="' . $jobCostItem->job_cost_files[1]->getId() . '" data-file-number="2" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[1]->getFileName() . '" data-lightbox="example-' . $jobCostItem->getId() . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[1]->getFileName() . '"  /></a></span>';
                                                                            $add_icon2 = 'none';
                                                                        }
                                                                    }
                                                                ?>
                                                                <label class="lbl add_icon2" style='display:<?=$add_icon2?>; max-width:100%' for="image2_file_<?=$jobCostItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>Last Ticket</span></label>
                                                                <!-- <label class="lbl add_icon2" style='color:#444444;display:<?=$add_icon2?>;' for="image2_file_<?=$jobCostItem->getId();?>"><i  class="fa fa-camera fa-fw fa-2x "></i></label> -->
                                                                <form method="post" name="image_upload_form" id="image2_upload_form_<?=$jobCostItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image2_upload_form_<?=$jobCostItem->getId();?>" data-file-number="2" class="form-control" style="display:none" id="image2_file_<?=$jobCostItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$jobCostItem->getId();?>">
                                                                    <!-- <input type="button" data-file-number="2"  onclick="file_upload(this)" data-form-id="image2_upload_form_<?=$jobCostItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview2">
                                                                    <?=$image_preview2?>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>

                                                    </div>




                                                    </td>
                                                   


                                                </tr>


                                                    <?php

        endforeach;

    }?>

                                                    </tbody>
                                                </table>

                                            <?php endforeach;
}
if (count($truckingItems) > 0) {
    foreach ($truckingItems as $serviceSortedItem): ?>
                                                    <?php $rowTotal = 0;
    
    $font_icon = 'fa-truck';

?>

                                            <p style="margin: 10px 0px;background-color: #efefef; padding:5px" class="category_items_toggle"><span style="float:left;margin: 0px 5px;"><i style="font-size: 1.2em;" class="fa <?=$font_icon;?> fa-fw fa-2x "></i></span><span style="font-size:15px;font-weight:bold;">Trucking</span><span style="float:right;position: relative;" >[<span class="complete_item_count"></span>/<span  class="total_item_count"></span>]</span></p>

                                            <table class="jobCostItems stripping-row"  style="width: 100%;border-collapse: separate;">

                                                <tbody>
                                                <?php
if (isset($serviceSortedItem['items'])) {
    foreach ($serviceSortedItem['items'] as $breaklineItem):
        $saved_values = $breaklineItem->saved_values;
        if ($breaklineItem->saved_values) {
            $saved_values = $breaklineItem->saved_values;
        } else {
            $saved_values = '';
        }
        ?>

                                                            <tr class="header_tr header_tr_border <?=($breaklineItem->job_cost) ? 'has_item_value' : '';?>" data-item-id="<?=$breaklineItem->getId();?>"  id="tr_line_item_<?=$breaklineItem->getId();?>" data-unit-price="<?=$breaklineItem->getUnitPrice();?>" data-total-price="<?=$breaklineItem->old_total;?>" data-proposal-service-id="<?=$breaklineItem->getProposalServiceId();?>" data-quantity="<?=$breaklineItem->getQuantity();?>" data-day="<?=$breaklineItem->getDay();?>" data-hpd="<?=$breaklineItem->getHoursPerDay();?>" data-num-people="<?=$breaklineItem->getNumPeople();?>" data-base-price="<?=$breaklineItem->getBasePrice();?>" data-old-quantity="<?=$breaklineItem->old_quantity;?>" data-category-id="<?=$breaklineItem->getItemType()->getCategoryId();?>" data-val='<?php echo $saved_values; ?>'>
                                                                <td width="5%" style="padding: 5px;"><span class="open_row tiptip" title="Details" style="float:right"><i class="fa fa-fw fa-1x fa-chevron-right  " style="cursor:pointer;"></i></span></td>
                                                                <td width="45%" style="text-align:left;"><?php
//print_r($breaklineItem);die;

        $check_type = $breaklineItem->item_type_time;
        echo '<b>' . $breaklineItem->getItemType()->getName() . '</b>';

        ?>
                                                                    </br>
                                                                    <?php

            echo $breaklineItem->getItem()->getName();
        

        ?>
                                                                </td>
                                                                <td width="5%"></td>
                                                                <td width="45%" style="text-align:right;"><span class="span_quantity tr_edit_span"><input class="input_quantity tr_edit_input number_field" style="width: 60px; text-align: right;height: 20px !important;font-size: 18px !important;font-weight: bold;" type="text" value="<?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>">
                                                                <span class="item_unit_name"><?php echo $breaklineItem->getItem()->getUnitModel()->getName(); ?></span>
                                                                </td>


                                                                <td width="5%" style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_save_btn tiptip tr_action_btn"   title="Save"  ><i class="material-icons">save</i></a></span></td>
                                                            </tr>

                                                        <tr data-base-price="<?=$breaklineItem->getBasePrice();?>" data-item-id="<?=$breaklineItem->getId();?>">

                                                        <?php

            if ($check_type) {

                echo '<td colspan="4"><span style="display: inline-block;width: 33%;"><b>Days:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getDay(), 2, '.', ',')) . '" class="input_day tr_edit_input number_field" type="text"  style="width: 30px;font-size: 18px !important;font-weight: bold;"></span><span style="display: inline-block;width: 33%;"><b>#:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getNumPeople(), 2, '.', ',')) . '" class="input_num_people tr_edit_input number_field" type="text"  style="font-weight: bold;width: 30px;font-size: 18px !important;"></span><span style="display: inline-block;width: 33%;"><b>HPD:</b> <input value="' . str_replace('.00', '', number_format($breaklineItem->getHoursPerDay(), 2, '.', ',')) . '" class="input_hpd tr_edit_input number_field" type="text" style="font-weight: bold;width: 30px;font-size: 18px !important;" ></span></td>';
            } else {
                echo '<td></td><td></td><td></td>';
            }


    ?>
                                                        <td><a href="javascript:void(0);" style="float: right;margin-left: 2px; <?=($breaklineItem->job_cost) ? '' : 'display:none';?>" class="btn tr_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="material-icons">delete</i></a>
                                                        <!-- <a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_item_reset_btn tiptip tr_action_btn"   title="Reset"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                    <div class="row">

                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width: 100%;">
                                                                <?php
$add_icon1 = 'block';
    $image_preview1 = '';
    if ($breaklineItem->job_cost_files) {
        if (isset($breaklineItem->job_cost_files[0])) {
            $image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '"  /></a></span>';
            $add_icon1 = 'none';
        }
    }
    ?>
                                                                <label class="lbl add_icon1" style='display:<?=$add_icon1?>;' for="image1_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>First Ticket</span></label>
                                                                <form method="post" name="image_upload_form" id="image1_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" data-file-number="1" class="form-control" style="display:none" id="image1_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                    <!-- <input type="button" data-file-number="1"  onclick="file_upload(this)" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview1">
                                                                    <?=$image_preview1?>
                                                                </div>
                                                                <!-- <div class="progress" style="height:15px;display:none;">
                                                                        <div class="bar"></div >
                                                                        <div class="percent">0%</div >
                                                                    </div>
                                                                <div class="status"></div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width:100%">
                                                                <?php
$add_icon2 = 'block';
    $image_preview2 = '';
    if ($breaklineItem->job_cost_files) {
        if (isset($breaklineItem->job_cost_files[1])) {
            //$image_preview2 =   '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing').'/'.$breaklineItem->job_cost_files[1]->getFileName().'"  /><span data-file-id="'.$breaklineItem->job_cost_files[1]->getId().'" data-file-number="2" class="remove_image"><i  class="fa fa-trash fa-fw fa-2x "></i></span></span>';
            $image_preview2 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[1]->getId() . '" data-file-number="2" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '"  /></a></span>';
            $add_icon2 = 'none';
        }
    }
    ?>
                                                                <label class="lbl add_icon2" style='display:<?=$add_icon2?>; max-width:100%' for="image2_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>Last Ticket</span></label>
                                                                <!-- <label class="lbl add_icon2" style='color:#444444;display:<?=$add_icon2?>;' for="image2_file_<?=$breaklineItem->getId();?>"><i  class="fa fa-camera fa-fw fa-2x "></i></label> -->
                                                                <form method="post" name="image_upload_form" id="image2_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" data-file-number="2" class="form-control" style="display:none" id="image2_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                    <!-- <input type="button" data-file-number="2"  onclick="file_upload(this)" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview2">
                                                                    <?=$image_preview2?>
                                                                </div>
                                                                <!-- <div class="progress" style="height:15px;display:none;">
                                                                        <div class="bar"></div >
                                                                        <div class="percent">0%</div >
                                                                    </div>
                                                                <div class="status"></div> -->
                                                            </div>
                                                        </div>

                                                    </div>




                                                    </td>
                                                    <!-- <td class="image_preview" colspan="3">
                                                        <?php

    //  if(count($breaklineItem->job_cost_files)>0){
    //     print_r($breaklineItem->job_cost_files);
    //      foreach($breaklineItem->job_cost_files as $files){
    //         print_r($files);
    // //     echo  '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing/').$files->getFileName().'"  /></span>';
    //      }
    //  }
    ?>
                                                    </td> -->


                                                </tr>

                                                <?php endforeach;}?>
                                                <!-- custom job items list -->

                                                <?php
if (isset($serviceSortedItem['job_cost_items'])) {

    foreach ($serviceSortedItem['job_cost_items'] as $jobCostItem):

    ?>

                                                    <tr class="has_item_value header_tr header_tr_border" data-item-id="<?=$jobCostItem->getId();?>" id="tr_job_cost_item_<?=$jobCostItem->getId();?>" data-unit-price="<?=$jobCostItem->getActualUnitPrice();?>" data-total-price="<?=$jobCostItem->getActualTotalPrice();?>" data-proposal-service-id="<?=$jobCostItem->getProposalServiceId();?>" >
                                                    <td width="5%" style="padding: 5px;"><span class="open_row tiptip" title="Details" style="float:right"><i class="fa fa-fw fa-1x fa-chevron-right  " style="cursor:pointer;"></i></span></td>
                                                        <td width="45%" style="text-align:left;"><b>Job Cost Item</b>
                                                        </br>
                                                        <?php echo $jobCostItem->getCustomItemName(); ?></td>
                                                        <td width="5%"></td>
                                                        <td width="40%" style="text-align:right;">
                                                        <span class="span_total tr_edit_span"><?php echo '$' . str_replace('.00', '', number_format($jobCostItem->getActualTotalPrice(), 2, '.', ',')); ?></span>

                                                            <?php // echo $breaklineItem->getItem()->getUnitModel()->getName(); ?>
                                                        </td>


                                                        <td width="10%" style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_save_btn tiptip tr_action_btn"   title="Save"  ><i class="material-icons">save</i></a></span></td>
                                                    </tr>
                                                    <tr>
                                                    <th width="5%"></th>

                                                    <th width="28%" >Quantity2</th>
                                                    <th ></th>
                                                    <th width="28%">Total Price</th>


                                                    <th width="10%">Action</th>
                                                    </tr>
                                                <tr id="tr_job_cost_input_<?=$jobCostItem->getId();?>" data-item-id="<?=$jobCostItem->getId();?>">
                                                <td></td>
                                                <td><input class="input_quantity2 tr_edit_input number_field" style="width: 60px; text-align: right;font-size: 18px !important;font-weight: bold;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualQty()); ?>"></td>
                                                <td></td>
                                                <td><input class="input_job_item_total tr_edit_input currency_field" style="width: 80px;font-size: 18px !important;font-weight: bold;" type="text" value="<?php echo trimmedQuantity($jobCostItem->getActualTotalPrice()); ?>"></td>
                                                <td><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_job_item_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="material-icons">delete</i></a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">
                                                    <div class="row">

                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width: 100%;">
                                                                <?php
                                                                $add_icon1 = 'block';
                                                                    $image_preview1 = '';
                                                                    if ($jobCostItem->job_cost_files) {
                                                                        if (isset($jobCostItem->job_cost_files[0])) {
                                                                            $image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $jobCostItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-' . $jobCostItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[0]->getFileName() . '"  /></a></span>';
                                                                            $add_icon1 = 'none';
                                                                        }
                                                                    }
                                                                ?>
                                                                <label class="lbl add_icon1" style='display:<?=$add_icon1?>;' for="image1_file_<?=$jobCostItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>First Ticket</span></label>
                                                                <form method="post" name="image_upload_form" id="image1_upload_form_<?=$jobCostItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image1_upload_form_<?=$jobCostItem->getId();?>" data-file-number="1" class="form-control" style="display:none" id="image1_file_<?=$jobCostItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$jobCostItem->job_cost_item_id;?>">
                                                                    <!-- <input type="button" data-file-number="1"  onclick="file_upload(this)" data-form-id="image1_upload_form_<?=$jobCostItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview1">
                                                                    <?=$image_preview1?>
                                                                </div>
                                                                <!-- <div class="progress" style="height:15px;display:none;">
                                                                        <div class="bar"></div >
                                                                        <div class="percent">0%</div >
                                                                    </div>
                                                                <div class="status"></div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                            <div class="image_div" style="display: inline-block;max-width:100%">
                                                                <?php
                                                                    $add_icon2 = 'block';
                                                                    $image_preview2 = '';
                                                                    if ($jobCostItem->job_cost_files) {
                                                                        if (isset($jobCostItem->job_cost_files[1])) {
                                                                        $image_preview2 = '<span  class="img-wrap"><span data-file-id="' . $jobCostItem->job_cost_files[1]->getId() . '" data-file-number="2" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[1]->getFileName() . '" data-lightbox="example-' . $jobCostItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $jobCostItem->job_cost_files[1]->getFileName() . '"  /></a></span>';
                                                                            $add_icon2 = 'none';
                                                                        }
                                                                    }
                                                                ?>
                                                                <label class="lbl add_icon2" style='display:<?=$add_icon2?>; max-width:100%' for="image2_file_<?=$jobCostItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>Last Ticket</span></label>
                                                                <!-- <label class="lbl add_icon2" style='color:#444444;display:<?=$add_icon2?>;' for="image2_file_<?=$jobCostItem->getId();?>"><i  class="fa fa-camera fa-fw fa-2x "></i></label> -->
                                                                <form method="post" name="image_upload_form" id="image2_upload_form_<?=$jobCostItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                    <input type="file" data-form-id="image2_upload_form_<?=$jobCostItem->getId();?>" data-file-number="2" class="form-control" style="display:none" id="image2_file_<?=$jobCostItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                    <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$jobCostItem->job_cost_item_id;?>">
                                                                    <!-- <input type="button" data-file-number="2"  onclick="file_upload(this)" data-form-id="image2_upload_form_<?=$jobCostItem->getId();?>" value="upload"> -->
                                                                </form>
                                                                <div class="image_preview2">
                                                                    <?=$image_preview2?>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>

                                                    </div>




                                                    </td>
                                                   


                                                </tr>


                                                <?php

    endforeach;

}?>

                                                </tbody>
                                            </table>

                                        <?php endforeach;
}


if (count($service['subContractorItem']) > 0) {
    $breaksortedItems = $service['subContractorItem'];
    foreach ($breaksortedItems as $breaksortedItem): ?>
                                                <?php $rowTotal = 0;?>
                                                <p style="margin: 10px 0px;background-color: #efefef; padding:5px" class="category_items_toggle"><span style="float:left;margin: 0px 5px;"><i style="font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x "></i></span><span style="font-size:15px;font-weight:bold;">Sub Contractors</span><span style="float:right;position: relative;" >[<span class="complete_item_count"></span>/<span  class="total_item_count"></span>]</span></p>
                                                <table class="jobCostItems" style="width: 100%;">
                                                 
                                                    <tbody>
                                                    <?php foreach ($breaksortedItem['items'] as $breaklineItem): ?>
                                                        <?php /* @var \models\EstimationLineItem $lineItem */?>
                                                        <tr class="header_tr header_tr_border <?=($breaklineItem->job_cost) ? 'has_item_value' : '';?>" data-item-id="<?=$breaklineItem->getId();?>"  id="tr_line_item_<?=$breaklineItem->getId();?>" data-unit-price="<?=$breaklineItem->getUnitPrice();?>" data-total-price="<?=$breaklineItem->old_total;?>" data-proposal-service-id="<?=$breaklineItem->getProposalServiceId();?>" data-quantity="<?=$breaklineItem->getQuantity();?>" data-day="<?=$breaklineItem->getDay();?>" data-hpd="<?=$breaklineItem->getHoursPerDay();?>" data-num-people="<?=$breaklineItem->getNumPeople();?>" data-base-price="<?=$breaklineItem->getBasePrice();?>" data-old-quantity="<?=$breaklineItem->old_quantity;?>" data-category-id="<?=$breaklineItem->getItemType()->getCategoryId();?>" >
                                                        
                                                            <td width="5%" style="padding: 5px;"><span class="open_row " title="Details" style="float:right"><i class="fa fa-fw fa-1x fa-chevron-right  " style="cursor:pointer;"></i></span></td>
		                                                            <td width="45%" style="text-align:left;"><?php
//print_r($breaklineItem);die;

                                                                     echo '<b>Sub Contractor</b>';

                                                                    ?>
		                                                                </br>
		                                                                <?php
                                                                            if ($breaklineItem->getIsCustomSub() == 1) {
                                                                                echo $breaklineItem->getCustomName();
                                                                            } else {
                                                                                echo $breaklineItem->getSubContractor()->getCompanyName();
                                                                            }

                                                                        ?>
		                                                            </td>
		                                                            <td width="5%"></td>
		                                                            <td width="45%" style="text-align:right;"><span class="span_quantity tr_edit_span"><input class="input_quantity tr_edit_input number_field" style="width: 60px; font-weight: bold; text-align: right;height: 20px !important;font-size: 18px !important;" onselectionchange="return false" type="text" value="<?php echo trimmedQuantity($breaklineItem->getQuantity()); ?>">
                                                                    <span class="item_unit_name">Qty</span>
		                                                            </td>


		                                                            <td width="5%" style="padding: 3px;"><span><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_save_btn tiptip tr_action_btn"   title="Save"  ><i class="material-icons">save</i></a></span></td>

                                                                </tr>
                                                                <tr data-base-price="<?=$breaklineItem->getBasePrice();?>" data-item-id="<?=$breaklineItem->getId();?>">

		                                                    <?php
    
                    echo '<td></td><td></td><td></td><td></td>';
                

            
        ?>
                                                            <td><a href="javascript:void(0);" style="float: right;margin-left: 2px; <?=($breaklineItem->job_cost) ? '' : 'display:none';?>" class="btn tr_delete_btn tiptip tr_action_btn"   title="Delete"  ><i class="material-icons">delete</i></a>
                                                            <!-- <a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn tr_item_reset_btn tiptip tr_action_btn"   title="Reset"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a> -->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                        <div class="row">

                                                            <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                                <div class="image_div" style="display: inline-block;max-width: 100%;">
                                                                    <?php
$add_icon1 = 'block';
        $image_preview1 = '';
        if ($breaklineItem->job_cost_files) {
            if (isset($breaklineItem->job_cost_files[0])) {
                $image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/'  .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[0]->getFileName() . '"  /></a></span>';
                $add_icon1 = 'none';
            }
        }
        ?>
                                                                    <label class="lbl add_icon1" style='display:<?=$add_icon1?>;' for="image1_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>First Ticket</span></label>
                                                                    <form method="post" name="image_upload_form" id="image1_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                        <input type="file" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" data-file-number="1" class="form-control" style="display:none" id="image1_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                        <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                        <!-- <input type="button" data-file-number="1"  onclick="file_upload(this)" data-form-id="image1_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                    </form>
                                                                    <div class="image_preview1">
                                                                        <?=$image_preview1?>
                                                                    </div>
                                                                    <!-- <div class="progress" style="height:15px;display:none;">
                                                                            <div class="bar"></div >
                                                                            <div class="percent">0%</div >
                                                                        </div>
                                                                    <div class="status"></div> -->
                                                                </div>
                                                            </div>
                                                            <div class="col l3 offset-l3 s6 m4 offset-m2">
                                                                <div class="image_div" style="display: inline-block;max-width:100%">
                                                                    <?php
$add_icon2 = 'block';
        $image_preview2 = '';
        if ($breaklineItem->job_cost_files) {
            if (isset($breaklineItem->job_cost_files[1])) {
                //$image_preview2 =   '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing').'/'.$breaklineItem->job_cost_files[1]->getFileName().'"  /><span data-file-id="'.$breaklineItem->job_cost_files[1]->getId().'" data-file-number="2" class="remove_image"><i  class="fa fa-trash fa-fw fa-2x "></i></span></span>';
                $image_preview2 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[1]->getId() . '" data-file-number="2" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') .  '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '" data-lightbox="example-' . $breaklineItem->job_cost_item_id . '"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' .$proposal->getProposalId().'/'. $breaklineItem->job_cost_files[1]->getFileName() . '"  /></a></span>';
                $add_icon2 = 'none';
            }
        }
        ?>
                                                                    <label class="lbl add_icon2" style='display:<?=$add_icon2?>; max-width:100%' for="image2_file_<?=$breaklineItem->getId();?>"><i class="material-icons">add_a_photo</i><br/><span>Last Ticket</span></label>
                                                                    <!-- <label class="lbl add_icon2" style='color:#444444;display:<?=$add_icon2?>;' for="image2_file_<?=$breaklineItem->getId();?>"><i  class="fa fa-camera fa-fw fa-2x "></i></label> -->
                                                                    <form method="post" name="image_upload_form" id="image2_upload_form_<?=$breaklineItem->getId();?>" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_image_upload'); ?>">
                                                                        <input type="file" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" data-file-number="2" class="form-control" style="display:none" id="image2_file_<?=$breaklineItem->getId();?>" accept="image/*" name="images_upload" onchange="preview_images2(this);" />
                                                                        <input type="hidden" name="job_cost_item_id" class="job_cost_item_id" value="<?=$breaklineItem->job_cost_item_id;?>">
                                                                        <!-- <input type="button" data-file-number="2"  onclick="file_upload(this)" data-form-id="image2_upload_form_<?=$breaklineItem->getId();?>" value="upload"> -->
                                                                    </form>
                                                                    <div class="image_preview2">
                                                                        <?=$image_preview2?>
                                                                    </div>
                                                                    <!-- <div class="progress" style="height:15px;display:none;">
                                                                            <div class="bar"></div >
                                                                            <div class="percent">0%</div >
                                                                        </div>
                                                                    <div class="status"></div> -->
                                                                </div>
                                                            </div>

                                                        </div>




                                                        </td>
                                                        <!-- <td class="image_preview" colspan="3">
                                                            <?php

        //  if(count($breaklineItem->job_cost_files)>0){
        //     print_r($breaklineItem->job_cost_files);
        //      foreach($breaklineItem->job_cost_files as $files){
        //         print_r($files);
        // //     echo  '<span style="padding: 5px;"><img width="150px" class="demo_img" src="' .site_url('uploads/job_costing/').$files->getFileName().'"  /></span>';
        //      }
        //  }
        ?>
                                                        </td> -->


                                                    </tr>

                                                    <?php endforeach;?>


                                                    </tbody>
                                                </table>

                                            <?php endforeach;

}

if (!count($service['subContractorItem']) > 0 && !count($serviceSortedItems) > 0 && !count($truckingItems) > 0) {
    echo '<p  style="margin-bottom: 15px;"><span style="background-color: #EEEEEE;padding: 5px;position: relative;border-radius: 3px;">No items estimated</span></p>';
}
?>
                                    </div>
                                </li>
                                    <?php
endforeach;
?>
                <!-- <li>
                    <div class="collapsible-header"><i class="material-icons  expand">expand_less</i>Attachments</div>
                    <div class="collapsible-body row" >
                        <div class="col s12">
                            <label class="lbl " style="width:60%;background:#25aae1;border=:0px;color:#fff"  for="attachment_upload_file"><span><i class="material-icons">add_circle</i></span><span style="position: relative;top: -7px;"> Upload Attachment</span></label>
                            <form method="post" name="attachment_upload_form" id="attachment_upload_form" enctype="multipart/form-data" action="<?php echo site_url('ajax/job_cost_attachment_upload'); ?>">
                                <input type="file" id="attachment_upload_file"  style="display:none"  name="attachment_upload" onchange="upload_attachment(this);" />
                                <input type="hidden" name="proposal_id"  value="<?=$proposal->getProposalId();?>">
                                
                            </form>
                        </div>
                        <div class="col s12">
                           
                            <ul class="collection with-header attachment_lists">
                                <li class="collection-header" ><p style="font-size:14px;font-weight:bold">Attachment List</p></li>
                                <?php
                                    foreach($attachments as $attachment){
                                        echo '<li class="collection-item"><div>'.$attachment->getFileName().'<a href="javascript:void(0);" onclick="delete_attachment('.$attachment->getId().')" class="secondary-content tiptip" title="Delete"><i class="material-icons">delete</i></a><a download target="_blank" href="'.base_url().'uploads/job_costing/'.$proposal->getProposalId().'/'.$attachment->getFileName().'" class="secondary-content tiptip" title="Download" ><i class="material-icons">file_download</i></a></div></li>';  
                                    }

                                ?>
                                
                            </ul>
                        </div>
                    </div>
                </li> -->

                </ul>
    </div>
    <p  style="font-size: 16px;padding-left: 10px;font-weight: bold;">Complete Job Costing</p>
    <div class="row">
        <ul class="collapsible collapsible_complete_parent">
                <li>
                    <div class="collapsible-header collapsible_complete" style="align-items: center;"><i class="material-icons  expand">expand_less</i>Enter Details</div>
                    <div class="collapsible-body row" >
                    <form method="post" id="complete_job_cost_form" action="/ajax/completeMobileJobCosting/<?php echo $proposal->getProposalId(); ?>">
                                <div style="margin-top:10px">
                                    <label style="font-weight: bold;" for="name">Select Foreman:</label><br>

                                    <select name="foreman"  class="foreman_select browser-default dont-uniform">
                                    <option value="0">Select Foreman</option>
                                        <?php

foreach ($foremans as $foreman) {
    $sel = ( $proposal->getJobCostForemenId() == $foreman->getId() ) ? 'selected' : '' ;
    echo '<option data-val="'.$foreman->getName().'" value="' . $foreman->getId() . '"  '.$sel.'>' . $foreman->getName() . '</option>';
}
?>
                                       <option <?php echo ($proposal->getJobCostForemenId() == '-1')?'selected':'';?> value="-1">Other</option>
                                    </select>
                                </div>
                                
                                <div class="clearfix "></div>
                                
                                <div class="custom_name" style="margin-top:10px; <?php echo ($proposal->getJobCostForemenId() == '-1') ? 'display:block':'display:none';?>">
                                    <label style="font-weight: bold;" for="name">Name:</label><br>
                                    <input type="text " required class="tr_edit_input custom_name" name="name" value="<?php echo $proposal->getJobCostUsername();?>">
                                    <input type="hidden" name="signature" class="signature">
                                </div>
                                <div>
                                    <label for="lname" style="font-weight: bold;" >Notes:</label><br>
                                    <textarea id="job_costing_note" rows="12" required name="job_costing_note" style="border: 1px solid #ddd;height: 150px;"><?php echo $proposal->getJobCostNotes();?></textarea>

                                </div>
                                <div style="margin-top:20px">
                                <label style="font-weight: bold;" >Signature:</label><br>
                                    <div id="my_pad" >
                                        <div id="signature-pad" class="signature-pad">
                                        <div class="signature-pad--body">
                                        <canvas></canvas>
                                        </div>
                                        <div class="signature-pad--footer">
                                        <div class="description">Sign above</div>

                                        <div class="signature-pad--actions">
                                            <div>
                                            <button type="button" class="button clear" data-action="clear">Clear</button>
                                        
                                            <button type="button" class="button" data-action="undo">Undo</button>
                                        </div>
                                            <div>
                                        
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="submit" id="complete_job_cost_btn" class="btn blue-button " value="Complete Job Costing" style="float:right;margin-top:20px">
                                </div>
                                    <!-- <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative; margin:10px 0px" >Complete Job Costing</a> -->
                            </form>
                    </div>
                </li>
        </ul>
    </div>

<!--end container-->


</div>

      <!--JavaScript at end of body for optimized loading-->
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" crossorigin="anonymous"></script>
      <script type="text/javascript" src="<?php echo site_url('static') ?>/js/lightbox.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
      <script src='/static/js/inputmask.js'></script>
      <script src="<?php echo site_url('static') ?>/js/signature/signature_pad.umd.js"></script>
      <script src="<?php echo site_url('static') ?>/js/signature/app.js"></script>
      
      <script>

            var openAccordion = '';
            var unsaved_item = false;
            var unsaved_item_id = '';
            var complete_job_costing =false;
            
$(document).ready(function() {

            var total_items  = $('.jobCostItems tbody tr.header_tr').length;
            var saved_items = $('.has_item_value').length;

                if(total_items==saved_items){
                    complete_job_costing =true;

                    
                }
            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');
            $('.jobCostItems tr:not(.header_tr)').hide();
            
            openAccordion = localStorage.getItem('selectedAccordionId');
            pagePosition = localStorage.getItem('pagePosition');
           
            if(openAccordion){
                $('.service_accordion_'+openAccordion).closest('li').addClass('active');
            }
            if(pagePosition){
              
                window.scrollTo(0, pagePosition);
                localStorage.removeItem('pagePosition');
            }
            count_complete_items();
 });

        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.collapsible');
            var instances = M.Collapsible.init(elems, {
                onOpenStart:function(event, ui){
                    console.log(ui)
                }

            });
        });
        
        // Or with jQuery

        $(document).ready(function(){
            $('.collapsible').collapsible();
            //$('.materialboxed').materialbox();
        });

function count_complete_items(){
    $('.category_items_toggle').each(function(index,ui) {
            var total_items  = $(ui).next('.jobCostItems').find('tbody tr.header_tr').length;
            var saved_items = $(ui).next('.jobCostItems').find('.has_item_value').length;
            $(ui).find('.complete_item_count').text(saved_items);
            $(ui).find('.total_item_count').text(total_items);
        });
}

    $(document).on("change", ".select_service", function () {
        $('.all_service_box').hide();
        if ($(this).val() == 'all') {
            $('.all_service_box').show();
        } else {
            $('.table_' + $(this).val()).show();
        }
    });

    $(document).on("change", ".select_service_phase", function () {
        $('.all_service_phase_box').hide();
        if ($(this).val() == 'all') {
            $('.all_service_phase_box').show();
            $('.phase_p,.phase_table').show();
        } else {

            if ($('option:selected', this).attr('data-val') == 'service') {
                $('.phase_p,.phase_table').show();
                $('.service_div_' + $(this).val()).show();
            } else {
                $('.phase_p,.phase_table').hide();


                $('.service_div_' + $('option:selected', this).attr('data-service-id')).show();
                $('.phase_p_' + $(this).val() + ',.phase_table_' + $(this).val()).show();
            }


        }
    });
function reset_dropdowns(){
    console.log('check');
    $(".select_service_phase").val('all');
    $(".select_service").val('all');
    $(".select_service_phase").trigger('change');
    $(".select_service").trigger('change');
}
    $(document).on('click', '.expandSpecDetail', function() {
        $(this).toggleClass('open');
        $(this).parents('.row').find('.specsDetail').toggle();
    });

    $(document).on('click', '.go_to_estimate_service', function() {
        if(hasLocalStorage){
            localStorage.setItem("service_id", $(this).data('val'));
        }
    });

    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });
    $(".number_field").inputmask("decimal",
    {
        "radixPoint": ".",
        "groupSeparator":",",
        "digits":2,
        "allowMinus": false,
        "autoGroup":true,
    });


    $(document).on('click', '.tr_delete_btn', function() {
        var item_id = cleanNumber($(this).closest('tr').attr('data-item-id'));
       var tr_delete_btn =$(this);
        if(unsaved_item ){
            if(item_id != unsaved_item_id){
            event.preventDefault();

            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            return false;
            }
        }
        var tr_row =$(this).closest('tr');
        swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/deleteJobCostItems',
                        type: "POST",
                        data: {
                            "item_id": item_id,
                        },

                        success: function(data){
                            data =JSON.parse(data)
                            $('#tr_line_item_'+item_id).removeClass('has_item_value');
                            $('#tr_line_item_'+item_id).find('.input_quantity').val(number_test2(data.qunatity));
                            swal('Item Deleted');
                            $(tr_row).find('.input_day').val(number_test2(data.day));
                            $(tr_row).find('.input_num_people').val(number_test2(data.num_people));
                            $(tr_row).find('.input_hpd').val(number_test2(data.hours));
                            tr_delete_btn.hide();
                            $('#tr_line_item_'+item_id).nextUntil('tr.header_tr').find('.job_cost_item_id').val('0');
                            if($('#tr_line_item_'+item_id).find('.fa-chevron-down').length){
                                $('#tr_line_item_'+item_id).find('.open_row').click();
                            }

                            $('#tr_line_item_'+item_id).nextUntil('tr.header_tr').find('.image_preview1').html('');
                            $('#tr_line_item_'+item_id).nextUntil('tr.header_tr').find('.add_icon1').show();
                            $('#tr_line_item_'+item_id).nextUntil('tr.header_tr').find('.image_preview2').html('');
                            $('#tr_line_item_'+item_id).nextUntil('tr.header_tr').find('.add_icon2').show();

                            if(data.is_service_completed==0){
                                $(".service_accordion_" + data.proposal_service_id).find('.est_checked').addClass('est_checked_hide');

                            }
                            var total_items  = $('.jobCostItems tbody tr.header_tr').length;
                            var saved_items = $('.has_item_value').length;

                            if(total_items!=saved_items){
                                
                                close_complete_collapse();
                                $('.job_costing_details').slideUp();
                                $('.complate_job_costing').addClass('disabled');

                                $('.complate_job_costing_msg').hide();
                            }
                            count_complete_items()
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });

    });
    $(document).on('click', '.tr_job_item_delete_btn', function() {
        var id = cleanNumber($(this).closest('tr').attr('data-item-id'));
        if(unsaved_item ){
            if(id != unsaved_item_id){
            event.preventDefault();

            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            return false;
            }
        }
        //var tr_row =$(this).closest('tr');
        var tr_row =$('#tr_job_cost_item_'+id);
        swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/deleteCustomJobCostItems',
                        type: "POST",
                        data: {
                            "item_id": id,
                        },

                        success: function(data){
                            data =JSON.parse(data);
                            tr_row.next().remove();
                            tr_row.next().remove();
                            tr_row.next().remove();
                            tr_row.remove();
                            console.log(data.is_service_completed);
                            if(data.is_service_completed==0){
                                $(".service_accordion_" + data.proposal_service_id).find('.est_checked').addClass('est_checked_hide');

                            }
                            swal('Item Deleted');
                            count_complete_items();
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Item is safe :)", "error");
                }
            });

        $(this).closest('tr').find('.input_job_item_total').val('0');
        $(this).closest('tr').find('.input_quantity').val('0');

     });

    $(document).on('click', '.tr_item_reset_btn', function() {
        var tr_row =$(this).closest('tr');
        var item_id = $(this).closest('tr').attr('data-item-id');
        var quntity = cleanNumber($('#tr_line_item_'+item_id).attr('data-quantity'));

        var day = cleanNumber($('#tr_line_item_'+item_id).attr('data-day'));
        var hpd = cleanNumber($('#tr_line_item_'+item_id).attr('data-hpd'));
        var num_people = cleanNumber($('#tr_line_item_'+item_id).attr('data-num-people'));

        swal({
                title: "Are you sure?",
                text: "Item values will be reset",
                showCancelButton: true,
                confirmButtonText: 'Reset Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    tr_row.find('.span_total ').text('$0');
                    $('#tr_line_item_'+item_id).find('.input_quantity').val(number_test2(quntity));

                    tr_row.find('.input_day').val(number_test2(day));
                    tr_row.find('.input_num_people').val(number_test2(num_people));
                    tr_row.find('.input_hpd').val(number_test2(hpd));


                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });



    });
    $(document).on('click', '.tr_job_item_save_btn', function() {

        var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = tr_item_id.replace(new RegExp("^" + 'tr_job_cost_item_'), '');
        if(unsaved_item ){
            if(id != unsaved_item_id){
            event.preventDefault();

            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            return false;
            }
        }
        $('#'+tr_item_id).find('.span_total').text($('#tr_job_cost_input_'+id).find('.input_job_item_total').val());
        var total = cleanNumber($('#tr_job_cost_input_'+id).find('.input_job_item_total').val());
        var quantity = cleanNumber($('#tr_job_cost_input_'+id).find('.input_quantity2').val());

        var proposal_service_id = $('#'+tr_item_id).attr('data-proposal-service-id');
        var tr_row =$(this).closest('tr');

        $.ajax({
            url: '/ajax/updateJobCostCustomItem/',
            type: 'post',
            data: {

                'quantity':quantity,
                'total':total,
                'id':id,


            },
            success: function(data){
                swal('Saved');
                data =JSON.parse(data);
                unsaved_item=false;
                $("#tr_job_cost_item_"+id).removeClass('unsaved_item');
                if( $("#tr_job_cost_item_"+id).find('.fa-chevron-down').length){
                    $("#tr_job_cost_item_"+id).find('.open_row').click();
                }
                if(parseFloat(data.service_price_diff)<0){
                    var service_price_diff = '-$'+addCommas(number_test2(Math.abs(data.service_price_diff)));
                }else{
                    var service_price_diff = '$'+addCommas(number_test2(data.service_price_diff));

                }

                if(parseFloat(data.proposal_price_diff)<0){
                    var proposal_price_diff = '-$'+addCommas(number_test2(Math.abs(data.proposal_price_diff)));

                }else{
                    var proposal_price_diff = '$'+addCommas(number_test2(data.proposal_price_diff));

                }
                $('.service_price_diff_'+proposal_service_id).text(service_price_diff);
                $('.proposal_price_diff').text(proposal_price_diff);
                count_complete_items();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });

    });
    $(document).on('click', '.tr_save_btn', function() {

        var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = tr_item_id.replace(new RegExp("^" + 'tr_line_item_'), '');


        if(unsaved_item ){
            if(id != unsaved_item_id){
            event.preventDefault();

            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            return false;
            }
        }
        var overhead = '';
        var profit = '';
        var tax = '';
        var taxPrice = '';
        var total = '';

        var overheadPrice = '';
        var profitPrice = '';
        var taxPrice = '';

        var day = $(this).closest('tr').nextUntil('tr.header_tr').find('.input_day').val();
        day = (day)?cleanNumber(day):'';
        var num_people = $(this).closest('tr').nextUntil('tr.header_tr').find('.input_num_people').val();
        num_people = (num_people)?cleanNumber(num_people):'';
        var hpd = $(this).closest('tr').nextUntil('tr.header_tr').find('.input_hpd').val();
        hpd = (hpd)?cleanNumber(hpd):'';
        var quantity = $(this).closest('tr').find('.input_quantity').val();
        quantity = (quantity)?cleanNumber(quantity):'';
        var item_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
        var proposal_service_id =$(this).closest('tr').attr('data-proposal-service-id')

        var old_quantity = $(this).closest('tr').attr('data-quantity');
        var old_total = parseFloat(item_price * old_quantity);
        var category_id = $(this).closest('tr').attr('data-category-id');
        var tr_row =$(this).closest('tr');



        var cal_values =  $(this).closest('tr').attr('data-val')



            var total = quantity * item_price;

        $.ajax({
            url: '/ajax/updateJobCostItem/',
            type: 'post',
            data: {
                'day':day,
                'num_people':num_people,
                'hpd':hpd,
                'quantity':quantity,
                'total':total,
                'id':id,
                'proposal_service_id':proposal_service_id,
                'proposal_id':<?=$proposal->getProposalId();?>,
                'overhead':overhead,
                'overheadPrice':overheadPrice,
                'profit':profit,
                'profitPrice':profitPrice,
                'tax':tax,
                'taxPrice':taxPrice,
                'old_total':old_total,
                'category_id':category_id,
                'old_quantity':old_quantity

            },
            success: function(data){
                swal('Saved');
                data =JSON.parse(data)
                console.log(data);
                if(data.is_service_completed==1){
                    $(".service_accordion_" + proposal_service_id).find('.est_checked').removeClass('est_checked_hide');
                    $(".service_accordion_" + proposal_service_id).trigger('click');

                }
                tr_row.find('.span_total').text('$'+addCommas(number_test2(parseFloat(total).toFixed(2))));
                tr_row.addClass('has_item_value');
                tr_row.removeClass('unsaved_item');
                unsaved_item =false;
                if(tr_row.find('.fa-chevron-down').length){
                    tr_row.find('.open_row').click();
                }
                tr_row.next('tr').find('.tr_delete_btn').show();
                //tr_row.find('.open_row').click();
                if(parseFloat(data.service_price_diff)<0){
                    var service_price_diff = '-$'+addCommas(number_test2(Math.abs(data.service_price_diff)));
                }else{
                    var service_price_diff = '$'+addCommas(number_test2(data.service_price_diff));

                }

                if(parseFloat(data.proposal_price_diff)<0){
                    var proposal_price_diff = '-$'+addCommas(number_test2(Math.abs(data.proposal_price_diff)));

                }else{
                    var proposal_price_diff = '$'+addCommas(number_test2(data.proposal_price_diff));

                }
                $('.service_price_diff_'+proposal_service_id).text(service_price_diff);
                $('.proposal_price_diff').text(proposal_price_diff);
                var total_items  = $('.jobCostItems tbody tr.header_tr').length;
                var saved_items = $('.has_item_value').length;

                if(total_items==saved_items){
                    complete_job_costing =true;

                    $('#ui-accordion-1-header-5').click();
                    $('.complate_job_costing').removeClass('disabled');
                    $('.complate_job_costing_msg').show();
                }
                count_complete_items();
                $('#tr_line_item_'+id).nextUntil('tr.header_tr').find('.job_cost_item_id').val(data.job_cost_item_id);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });

    });

    function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

    $(document).on('keyup', '.input_day,.input_num_people,.input_hpd', function() {
        var day = $(this).closest('tr').find('.input_day').val();
        var item_id = $(this).closest('tr').attr('data-item-id');
        day = (day)?cleanNumber(day):'';
        var num_people = $(this).closest('tr').find('.input_num_people').val();
        num_people = (num_people)?cleanNumber(num_people):'';
        var hpd = $(this).closest('tr').find('.input_hpd').val();
        hpd = (hpd)?cleanNumber(hpd):'';

        var quantity = day * num_people * hpd;

        $('#tr_line_item_'+item_id).find('.input_quantity').val(quantity);

            var item_price =cleanNumber($(this).closest('tr').attr('data-base-price'));
            var total = quantity * item_price;

            $('#tr_line_item_'+item_id).find('.span_total').text('$'+addCommas(number_test2(parseFloat(total).toFixed(2))));
    });


    $(document).on('keyup', '.input_quantity', function() {


        var quantity = $(this).closest('tr').find('.input_quantity').val();
        quantity = (quantity)?cleanNumber(quantity):'';

        var item_base_price = cleanNumber($(this).closest('tr').attr('data-base-price'));

        var total = quantity * item_base_price;
        $(this).closest('tr').find('.span_total').text('$'+addCommas(number_test2(parseFloat(total).toFixed(2))));
    });

    function number_test2(n)
    {
        var result = (n - Math.floor(n)) !== 0;

        if (result){
        return parseFloat(n).toFixed(2);
         }else{
        return parseInt(n);
        }


    }
   function trigger_currancy_mask(){
    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });
        $("#add_job_cost_item_form .currency_field").css('text-align','left');
   }

   function trigger_number_mask(){
        $(".number_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "allowMinus": false,
            "autoGroup":true,
        });

        $("#add_job_cost_item_form .number_field").css('text-align','left');
   }
    $(document).on('click', '.currency_field', function() {
        console.log('dddd');
        // $(".currency_field").inputmask("decimal",
        // {
        //     "radixPoint": ".",
        //     "groupSeparator":",",
        //     "digits":2,
        //     "prefix":"$",
        //     "autoGroup":true,
        //     "showMaskOnHover": false,
        //     "allowMinus": false,
        //     "showMaskOnFocus": false,
        // });
    })


    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });


        // $(document).on('keyup', '.job_cost_item_unit_price,.job_cost_item_quantity', function() {
        //     var unit_price = $('.job_cost_item_unit_price').val();

        //     var quantity = $('.job_cost_item_quantity').val();
        //     var total = unit_price * quantity;
        //     $('.job_cost_item_total').val(parseFloat(total).toFixed(2));
        // })

        $(document).on('click', '.complate_job_costing', function() {
            $('.job_costing_details').slideDown();

        });


        $(document).on('click', '.complate_job_costing2', function() {

            var total_items  = $('.jobCostItems tbody tr.header_tr').length;
            var saved_items = $('.has_item_value').length;
            if(total_items!=saved_items){
                swal('All Item are not saved')

            }else{

                swal({
                    title: "Are you sure?",
                    text: "Job costing will be completed",
                    showCancelButton: true,
                    confirmButtonText: 'Complete',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        location.href = "/ajax/completeJobCosting/<?php echo $proposal->getProposalId(); ?>";


                    } else {
                        swal("Cancelled", "Your Estimation is safe :)", "error");
                    }
                });

            }
        });

        $(".details_toggle").click(function(){
            $(".project-data").slideToggle();
            $('.details_toggle').find(".fa-chevron-right, .fa-chevron-down").toggleClass("fa-chevron-right fa-chevron-down");

        });

        $(".category_items_toggle5").click(function(){
            //$(".project-data").slideToggle();

            $(this).next(".jobCostItems").slideToggle();
            $(this).find(".fa-chevron-right, .fa-chevron-down").toggleClass("fa-chevron-right fa-chevron-down");
            var table = $(this).next(".jobCostItems");
            $(table).find('.header_tr').each(function(index,ui) {
                if($(ui).find('.open_row i').hasClass("fa-chevron-down")){
                    $(ui).find('.open_row').click();
                }
            });
        });

    $('.open_row').click(function() {
        if(unsaved_item){

            event.preventDefault();

            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            return false;
        }

        $(this).closest('tr').nextUntil('tr.header_tr').slideToggle();
        $(this).closest('tr').find(".fa-chevron-right, .fa-chevron-down").toggleClass("fa-chevron-right fa-chevron-down");
        $(this).closest('tr').toggleClass("header_tr_border");
    });

    // $('.add_item_btn').on('click', function(e) {
    //     e.stopPropagation();
    //     var service_id = $(this).attr('data-val');
    //     $('.proposal_service_id').val(service_id);
    //     $('.categoryType').val('');
    //     $.uniform.update();
    //     $("#add_job_cost_item_modal").dialog('open');
    // });
    $('.add_item_btn').on('click', function(e) {
    e.stopPropagation();
    var service_id = $(this).attr('data-val');
    console.log(window.pageYOffset);
    if(hasLocalStorage){
        localStorage.setItem('pagePosition', window.pageYOffset);
    }
    //$('.mdb-select').material_select();
    swal({
                    title: "Add Item",
                    html: '<form id="add_job_cost_item_form" action="<?php echo site_url('ajax/save_mobile_job_cost_item'); ?>" method="post">'+
                        '<input type="hidden" name="proposal_id" value="<?php echo $proposal->getProposalId(); ?>">'+
                        '<input type="hidden" class="proposal_service_id" name="proposal_service_id" value="'+service_id+'">'+
                        '<table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td><div class=" col s6"><label >Select Category</label><select name="categoryType"  class="categoryType browser-default"><?php foreach ($categories as $category): ?><option value="<?php echo $category->getId() ?>"><?php echo $category->getName(); ?></option><?php endforeach;?></select></td></tr>'+
                            '<tr ><td><label for="" style="width: 70px;"> Name</label><input type="text" name="job_cost_item_name" class="text " placeholder="Enter Item Name" style=" text-align: left" value=""></td></tr>'+
                            '<tr ><td><label for="" style="width: 70px;"> Quantity</label><input type="text" name="job_cost_item_quantity" placeholder="Enter Item Quantity" class="text input60 job_cost_item_quantity number_field"   value=""></td></tr>'+

                            '<tr><td><label for="" style="width: 70px;">Total Price</label><input type="text" name="job_cost_item_total" placeholder="Enter Item Total Price" class="text input60 job_cost_item_total currency_field"  value=""></td>'+
                            '</tr></table></form>',

                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (result) {
                $('#add_job_cost_item_form').submit();
                }).catch(swal.noop)
                trigger_currancy_mask();
                trigger_number_mask();

})


$('input[type=text]').on('focusin', function(e) {
    if(unsaved_item ){
       
            if($(this).closest('tr').attr('data-item-id') != unsaved_item_id){
            event.preventDefault();
            $('#tr_line_item_'+unsaved_item_id).find('.input_quantity').focus();
            event.returnValue = '';
            swal(
                'You have an unsaved item',
                'Please save item to continue'
            );
            
            return false;
            }
        }
})

$('input[type=text]').on('keyup', function(e) {
    unsaved_item=true;

    var item_id = $(this).closest('tr').attr('data-item-id');
    unsaved_item_id =item_id;
    if($("#tr_line_item_"+item_id).length){
         $("#tr_line_item_"+item_id).addClass('unsaved_item');
    }else{
        $("#tr_job_cost_item_"+item_id).addClass('unsaved_item');
    }

});



function readURL(input,myid)
{
	if (input.files && input.files[0])
	{
       var reader = new FileReader();
       reader.onload = function (e)
	   {
        $('#'+myid +'-tag').attr('src', e.target.result);
       }
       reader.readAsDataURL(input.files[0]);
    }
}


function preview_images()
{
 var total_file=document.getElementById("images").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<div class='col-md-3'><img class='img-responsive materialboxed' src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }
}

function preview_images2(e)
{
   // $('.image-lists').html('');
 var total_file=e.files.length;
 var image_tr_row = e.closest('tr');

 var image_number = $(e).attr('data-file-number');

 $(tr_row).find('.image_preview'+image_number).html('');
 swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

 var input =e;
 for(var i=0;i<total_file;i++)
 {
    if (input.files && input.files[i])
	{
       var reader = new FileReader();
       reader.onload = function (e)
	   {

        //$image_preview1 = '<span  class="img-wrap"><span data-file-id="' . $breaklineItem->job_cost_files[0]->getId() . '" data-file-number="1" class="remove_image">&times;</span><a class="example-image-link" href="' . site_url('uploads/job_costing') . '/' . $breaklineItem->job_cost_files[0]->getFileName() . '" data-lightbox="example-'.$breaklineItem->getId().'"><img  class="demo_img responsive-img example-image" src="' . site_url('uploads/job_costing') . '/' . $breaklineItem->job_cost_files[0]->getFileName() . '"  /></a></span>';

        $(image_tr_row).find('.image_preview'+image_number).append('<span  class="img-wrap"><span  data-file-id="" data-file-number="'+image_number+'" class="remove_image">&times;</span><a class="example-image-link" href="" data-lightbox="example-"><img  class="demo_img responsive-img example-image"  src="'+e.target.result+'"  /></a></span>');
        $(image_tr_row).find('.add_icon'+image_number).hide();

       }
       reader.readAsDataURL(input.files[i]);
    }
}

 var form_id = $(e).attr('data-form-id');
 trigger_lightbox();

if($('#'+form_id).find('.job_cost_item_id').val()==0){

   // var tr_item_id = cleanNumber($(this).closest('tr').attr('id'));
        var id  = form_id.replace(new RegExp("^" + 'image'+image_number+'_upload_form_'), '');


        // if(unsaved_item ){
        //     if(id != unsaved_item_id){
        //     event.preventDefault();

        //     event.returnValue = '';
        //     swal(
        //         'You have an unsaved item',
        //         'Please save item to continue'
        //     );
        //     return false;
        //     }
        // }
        var overhead = '';
        var profit = '';
        var tax = '';
        var taxPrice = '';
        var total = '';

        var overheadPrice = '';
        var profitPrice = '';
        var taxPrice = '';

        var day = $('#tr_line_item_'+id).nextUntil('tr.header_tr').find('.input_day').val();
        day = (day)?cleanNumber(day):'';
        var num_people = $('#tr_line_item_'+id).nextUntil('tr.header_tr').find('.input_num_people').val();
        num_people = (num_people)?cleanNumber(num_people):'';
        var hpd =$('#tr_line_item_'+id).nextUntil('tr.header_tr').find('.input_hpd').val();
        hpd = (hpd)?cleanNumber(hpd):'';
        var quantity = $('#tr_line_item_'+id).find('.input_quantity').val();
        quantity = (quantity)?cleanNumber(quantity):'';
        var item_price =cleanNumber($('#tr_line_item_'+id).attr('data-base-price'));
        var proposal_service_id =$('#tr_line_item_'+id).attr('data-proposal-service-id')

        var old_quantity = $('#tr_line_item_'+id).attr('data-quantity');
        var old_total = parseFloat(item_price * old_quantity);
        var category_id = $('#tr_line_item_'+id).attr('data-category-id');
        var tr_row =$('#tr_line_item_'+id);



        var cal_values =  $('#tr_line_item_'+id).attr('data-val')



            var total = quantity * item_price;

        $.ajax({
            url: '/ajax/updateJobCostItem/',
            type: 'post',
            data: {
                'day':day,
                'num_people':num_people,
                'hpd':hpd,
                'quantity':quantity,
                'total':total,
                'id':id,
                'proposal_service_id':proposal_service_id,
                'proposal_id':<?=$proposal->getProposalId();?>,
                'overhead':overhead,
                'overheadPrice':overheadPrice,
                'profit':profit,
                'profitPrice':profitPrice,
                'tax':tax,
                'taxPrice':taxPrice,
                'old_total':old_total,
                'category_id':category_id,
                'old_quantity':old_quantity

            },
            success: function(data){
                swal('Saved');
                data =JSON.parse(data)

                 if(data.is_service_completed==1){
                     $(".service_accordion_" + proposal_service_id).find('.est_checked').removeClass('est_checked_hide');
                     $(".service_accordion_" + proposal_service_id).trigger('click');

                 }
                tr_row.find('.span_total').text('$'+addCommas(number_test2(parseFloat(total).toFixed(2))));
                tr_row.addClass('has_item_value');
                tr_row.removeClass('unsaved_item');
                unsaved_item =false;
                // if(tr_row.find('.fa-chevron-down').length){
                //     tr_row.find('.open_row').click();
                // }
                 tr_row.next('tr').find('.tr_delete_btn').show();
                //tr_row.find('.open_row').click();

                var total_items  = $('.jobCostItems tbody tr.header_tr').length;
                var saved_items = $('.has_item_value').length;

                if(total_items==saved_items){
                    complete_job_costing =true;

                   // $('#ui-accordion-1-header-5').click();
                   // $('.complate_job_costing').removeClass('disabled');
                   // $('.complate_job_costing_msg').show();
                }

                $('#'+form_id).find('.job_cost_item_id').val(data.job_cost_item_id);




                count_complete_items();


                //var image_number = $(e).attr('data-file-number');
    //var form_id = $(e).attr('data-job_cost_item-id');
    var bar = $(e).closest('.image_div').find('.bar');
	var percent = $(e).closest('.image_div').find('.percent');
	var status = $(e).closest('.image_div').find('.status');

    $('#'+form_id).ajaxForm({
            dataType: 'json',
			beforeSend: function() {
				//$(e).closest('.image_div').find('.progress').show();
				status.empty();
				var percentVal = '0%';
				bar.width(percentVal);
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal);
				percent.html(percentVal);
			},
			success: function(data, statusText, xhr) {
                if(data.error==0){
                    $(image_tr_row).find('.image_preview'+image_number+' .demo_img').attr('src',data.imagename);
                    $(image_tr_row).find('.image_preview'+image_number+' .example-image-link').attr('href',data.imagename);
                    $(image_tr_row).find('.image_preview'+image_number+' .example-image-link').attr('data-lightbox','example-'+$('#'+form_id).find('.job_cost_item_id').val());
                    $(image_tr_row).find('.image_preview'+image_number+' .remove_image').attr('data-file-id',data.file_id);
                    var percentVal = '100%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    $(e).closest('.image_div').find('.progress').fadeOut();
                    //status.html(xhr.responseText);
                    swal('Image saved');
                }else{
                    swal(data.message);
                    $(image_tr_row).find('.image_preview'+image_number).html('');
                    $(image_tr_row).find('.add_icon'+image_number).show();
                }
                
			},
			error: function(xhr, statusText, err) {
				status.html(err || statusText);
                swal("Error", "An error occurred Please try again");
                $(image_tr_row).find('.image_preview'+image_number).html('');
                $(image_tr_row).find('.add_icon'+image_number).show();
			}
		 }).submit();
         $('.materialboxed').materialbox();
         trigger_lightbox();
         return false;



            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });











}else{


    var image_number = $(e).attr('data-file-number');
    //var form_id = $(e).attr('data-job_cost_item-id');
    var bar = $(e).closest('.image_div').find('.bar');
	var percent = $(e).closest('.image_div').find('.percent');
	var status = $(e).closest('.image_div').find('.status');

    $('#'+form_id).ajaxForm({
            dataType: 'json',
			beforeSend: function() {
				//$(e).closest('.image_div').find('.progress').show();
				status.empty();
				var percentVal = '0%';
				bar.width(percentVal);
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal);
				percent.html(percentVal);
			},
			success: function(data, statusText, xhr) {

                if(data.error==0){
                    $(image_tr_row).find('.image_preview'+image_number+' .demo_img').attr('src',data.imagename);
                    $(image_tr_row).find('.image_preview'+image_number+' .remove_image').attr('data-file-id',data.file_id);
                    $(image_tr_row).find('.image_preview'+image_number+' .example-image-link').attr('href',data.imagename);
                    $(image_tr_row).find('.image_preview'+image_number+' .example-image-link').attr('data-lightbox','example-'+$('#'+form_id).find('.job_cost_item_id').val());
                    var percentVal = '100%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    $(e).closest('.image_div').find('.progress').fadeOut();
                    //status.html(xhr.responseText);
                    swal('Image saved');
                }else{
                    swal(data.message);
                    $(image_tr_row).find('.image_preview'+image_number).html('');
                    $(image_tr_row).find('.add_icon'+image_number).show();
                }
			},
			error: function(xhr, statusText, err) {
				status.html(err || statusText);
                swal("Error", "An error occurred Please try again");
                $(image_tr_row).find('.image_preview'+image_number).html('');
                $(image_tr_row).find('.add_icon'+image_number).show();
			}
		 }).submit();
         $('.materialboxed').materialbox();
         trigger_lightbox();
         return false;
}
}


$(document).on('click', '.remove_image', function() {

    var tr_row = $(this).closest('tr');
    var image_number = $(this).attr('data-file-number');
    var file_id = $(this).attr('data-file-id');


    swal({
                title: "Are you sure?",
                text: "File will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete File',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/deleteJobCostItemFile',
                        type: "POST",
                        data: {
                            "file_id": file_id,
                        },

                        success: function(data){
                            $(tr_row).find('.image_preview'+image_number).html('');
                            $(tr_row).find('.add_icon'+image_number).show();
                            swal('File Deleted')
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your File is safe :)", "error");
                }
            });

})
$(document).on('click', '.foreman_select', function() {
    if($(this).val()=='-1'){
        $('.custom_name').show();
        $('.custom_name').val('');
    }else if($(this).val()!='-1'){
        $('.custom_name').val($(this).attr('data-val'));
        $('.custom_name').hide();
    }

})


function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function trigger_lightbox(){
    console.log('trigger')
    $('.materialboxed').materialbox();
    document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.materialboxed');
                var instances = M.Materialbox.init(elems, {});
            });
}



jQuery.fn.putCursorAtEnd = function() {

return this.each(function() {
  
  // Cache references
  var $el = $(this),
      el = this;

  // Only focus if input isn't already
  if (!$el.is(":focus")) {
   $el.focus();
  }

  // If this function exists... (IE 9+)
  if (el.setSelectionRange) {

    // Double the length because Opera is inconsistent about whether a carriage return is one character or two.
    var len = $el.val().length * 2;
    
    // Timeout seems to be required for Blink
    setTimeout(function() {
      el.setSelectionRange(len, len);
    }, 1);
  
  } else {
    
    // As a fallback, replace the contents with itself
    // Doesn't work in Chrome, but Chrome supports setSelectionRange
    $el.val($el.val());
    
  }

  // Scroll to the bottom, in case we're in a tall textarea
  // (Necessary for Firefox and Chrome)
  this.scrollTop = 999999;

});

};

$(document).on('focusin', "input[type='text']", function() {
    var input = $(this);
    input.putCursorAtEnd();
   
});
$(document).on('touchstart', "input[type='text']", function() {
    var input = $(this);
    input.putCursorAtEnd();
});
$(document).on('touchend', "input[type='text']", function() {
    var input = $(this);
    input.putCursorAtEnd();
});

$(document).on('click', ".collapsible-header", function() {
    
    if($(this).closest('li').hasClass('active')){
        var attr = $(this).attr('data-service-id');

        if (typeof attr !== typeof undefined && attr !== false) {
            if(hasLocalStorage){
                localStorage.setItem('selectedAccordionId', attr);
            }
        }
    }else{
            localStorage.removeItem('selectedAccordionId');
    }
    resizeCanvas();
    
});

$(document).on('click', "#complete_job_cost_btn", function(e) {

    e.preventDefault();
    if (signaturePad.isEmpty()) {
    alert("Please provide a signature first.");
  } else {
    var dataURL = signaturePad.toDataURL();
    $('.signature').val(dataURL);
    $('#complete_job_cost_form').submit();
      // download(dataURL, "signature.png");
  }
});

function upload_attachment(){
    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })
    $('#attachment_upload_form').ajaxForm({
            dataType: 'json',
			beforeSend: function() {
				//$(e).closest('.image_div').find('.progress').show();
				// status.empty();
				// var percentVal = '0%';
				// bar.width(percentVal);
				// percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				// var percentVal = percentComplete + '%';
				// bar.width(percentVal);
				// percent.html(percentVal);
			},
			success: function(data, statusText, xhr) {
                
                $('.attachment_lists').html(data.attachments)
               // initTiptip();
                swal('File saved');
                
               
			},
			error: function(xhr, statusText, err) {
				//status.html(err || statusText);
                swal("Error", "An error occurred Please try again");
                // $(image_tr_row).find('.image_preview'+image_number).html('');
                // $(image_tr_row).find('.add_icon'+image_number).show();
			}
		 }).submit();
         $('.materialboxed').materialbox();
         trigger_lightbox();
         return false;
}

function delete_attachment(file_id){
    swal({
                title: "Are you sure?",
                text: "File will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete File',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/deleteJobCostAttachment',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "file_id": file_id,
                        },

                        success: function(data){
                            $('.attachment_lists').html(data.attachments) ;
                            //initTiptip();
                            swal('File Deleted')
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your File is safe :)", "error");
                }
            });

}
$('.collapsible_complete').on('click', function(e) {
    
    if(!complete_job_costing){
        e.stopPropagation();
        swal('','Please complete all Items')
    }
    
  });

  function close_complete_collapse(){
 
    if($(".collapsible_complete").closest('li').hasClass("active")){
        $(".collapsible_complete").click();  
    }
    complete_job_costing =false;
  }


        </script>
    </body>
</html>
