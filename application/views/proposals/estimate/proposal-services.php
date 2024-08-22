<style>
    a.toggle {

        display: block;
        color: #fefefe;
        border-radius: 0.15em;
    }
    .inner {

        overflow: hidden;
        display: none;
    }

    .input80{
        width:80px;
    }
    .small{
        font-size: 1.6em!important;
    }
    .nav-row{
        display:flex !important;
        justify-content: flex-start;
        align-items:center;
        color:#444444 !important;
    }

    .nav-row p{
        flex:1;
        padding:0 5px;
        text-align:left;
        line-height:normal;
    }
    .estimate-page a.undo-btn span {
        padding: 0.1em 0.1em;
        font-size: 11px;
    }
    .mb-5px{
        margin-bottom:5px;
    }
    .text-active-color{
        background-color:#25AAE1 !important;
        color:#ffffff !important;
    }
    .text-active-color2{
        color:#ffffff !important;
    }
    .edit_field_btns{
        height:28px;
    }

    .cancel_field_save span {
        padding: 0.2em 0.3em!important;
        font-size: 12px!important;
    }
    .show_proposal_overhead_and_profit{display:none;}
    .service_specifications{display:none;}
    
    .styleInputbox{

        border: 1px solid #ccc!important; /* Set the border */
    padding: 2px!important;/* Set padding inside the input box */
    border-radius: 5px; /* Add rounded corners */
    background-color: #f0f0f0!important; /* Set the background color */
    color: #333!important;/* Set the text color */
 
 
    }
 
</style>
<ul id="proposal_services">



    <?php
    $i=0;
    foreach ($proposalServices as $proposalService) {
        $service = $proposalService['service'];
        $fieldValues = $proposalService['fields'];
        $show_estimate_fields = 0;
        foreach ($fieldValues as $fieldValue) {
            if( $fieldValue['cesf']->getMeasurement()==1        || 
                $fieldValue['cesf']->getGravelDepth()==1        || 
                $fieldValue['cesf']->getBaseDepth()==1          ||
                $fieldValue['cesf']->getExcavationDepth()==1    ||
                $fieldValue['cesf']->getDepth()==1              ||
                $fieldValue['cesf']->getUnit() ==1              ||
                $fieldValue['cesf']->getLength() ==1){
                    $show_estimate_fields = 1;
               
             }

             
        }
        ?>
        <li class="service clearfix" data-no="<?= $i++;?>" data-edit-fields="<?=$show_estimate_fields;?>" id="service_<?php echo $service->getServiceId() ?>" data-val="<?php echo $service->getServicesModel()->getParent()?>" data-no-price="<?php echo $service->getNoPrice() ?>">

            <a class="<?php echo ($service->getNoPrice()) ? 'toggle_disable':'toggle';?> nav-row " href="javascript:void(0);" style="background-color: #aeaeae;text-align: center; font-weight: bold;">
                <p class="service_title_name"><?php echo $service->getServiceName() ?></p>
                <i class="fa fa-exclamation-triangle service_child_flag tiptip service_child_has_updated_flag_<?php echo $service->getServiceId() ?>" style="margin-right: 2px; display:none;" title="This service has items that need to be checked"></i>
                <?php if($service->getOptional()){?>
                    <span class="option_service tiptipleft" title="This is an optional service" >[OS]</span>
                <?php }?>
                <?php if($service->getNoPrice()){?>
                    <span class="est_disable">
                        <i class="fa fa-fw fa-2x fa-ban small tiptip" title="This service is no price and cannot be estimated" style="position: relative;top: 3.3px;"></i>
                    </span>
                <?php }else{?>
                <span class="est_checked">
                    <i class="fa fa-fw fa-2x fa-check-circle-o small " style="position: relative;top: 3.3px;width:21px"></i>
                </span>
                <?php }?>
            </a>


            <ul class="inner serviceFieldValues" >
                <li class="set_loader_phase" style="display: block;height:40px">
                    <div class="cssloader" style="display: block;left: 0px;top: 20px;">loading</div>
                </li>
                <li class="add_phase_li" style="margin-left: 32%;padding: 0px;width:68%;display: inline-block;line-height: 22px;top: -6px;position: relative;">
                
                <strong style="margin-left: 90px;color:#a5a5a5;position: relative;top: -0.85px;">phase</strong><span style="float:right">
                <?php if($proposal_status_id !=5){?>
                    <a href="javascript:void('0');" class="add_phases_btn" style="color:#000;    margin-right: 2px;"><i style ="top: 1.5px;position: relative;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                <?php }?>
                </span>
                
                    <ul class="sortable-phase" style="border-top:1px solid #fff">
                        <li class="add_phase_input_li"  >
                            <input type="text" style="float:left;text-align: left;" value=""  class="text input135 add_phase_input_field" id="" >
                            <a href="javascript:void(0);" style="float:right;margin-top: 3px;margin-right: 3px;" class="btn  tiptip cancel_new_phase"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a>
                            <a href="javascript:void('0');" style="float:left;margin-top: 3px;"  class="btn mb-5px blue-button save_new_phase" >Save</a>
                        </li>
                    </ul>
                </li>

                <hr style="margin-top:0px;"/>
                <li class="specification_sep" style=""><i class="fa fa-fw  fa-file-text-o " ></i> <strong style="font-size:12px">Specification</strong>
                    <span style="float:right;">
                        <a href="javascript:void('0');" class="show_service_spec_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                    </span>
                </li>
                <?php
                $check =0;
                
                foreach ($fieldValues as $fieldValue) {

                    ?>

                    <li class="service_specifications"  data-field-code="<?php echo $fieldValue['field']->getFieldCode(); ?>" data-field-id="<?php echo $fieldValue['field']->getFieldId(); ?>" data-data-type="<?php echo $fieldValue['field']->getFieldType(); ?>" data-data-value="<?php echo join(',', explode("\n", $fieldValue['field']->getFieldValue())); ?>"  data-measurement-field="<?php echo $fieldValue['cesf']->getMeasurement(); ?>" data-depth-field="<?php echo $fieldValue['cesf']->getDepth(); ?>" data-area="<?php echo $fieldValue['cesf']->getArea(); ?>" data-length="<?php echo $fieldValue['field']->getLength(); ?>" data-qty="<?php echo $fieldValue['cesf']->getQty(); ?>" data-unit-field="<?php echo $fieldValue['cesf']->getUnit(); ?>"  data-gravel-depth-field="<?php echo $fieldValue['cesf']->getGravelDepth(); ?>" data-excavation-depth-field="<?php echo $fieldValue['cesf']->getExcavationDepth(); ?>" data-base-depth-field="<?php echo $fieldValue['cesf']->getBaseDepth(); ?>"><strong><?php echo $fieldValue['field']->getFieldName(); ?>:</strong>
                        <span class="show_input_span" style="float: right;cursor:pointer"> <?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldValue() : '';  ?></span>

                        <div>


                            <a href="javascript:void(0);" style="display:none; float:left" class="btn cancel_field_save tiptip"  title="Cancel"  >
                            <i class="fa fa-fw fa-1x fa-close " ></i></a>
                            <input type="button" style="display:none;padding: 0.22em 0.3em; float:left" value="Save" class="field_btn btn mb-5px blue-button " id="btn_<?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldId() : ''; ?>" >
                        <?php
                        if($fieldValue['cesf']->getMeasurement()==1){
                           echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2"  title="Measurement field" ></i>';

                        }else if($fieldValue['cesf']->getGravelDepth()==1 ){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2 gravel_depth_field_tiptip"  title="Depth field"  ></i>';

                         }else if($fieldValue['cesf']->getBaseDepth()==1 ){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2 base_depth_field_tiptip"  title="Depth field"  ></i>';

                         }else if($fieldValue['cesf']->getExcavationDepth()==1 ){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2 excavation_depth_field_tiptip"  title="Depth field"  ></i>';

                         }else if($fieldValue['cesf']->getDepth()==1 ){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2 depth_field_tiptip"  title="Depth field"  ></i>';

                         }else if($fieldValue['cesf']->getUnit() ==1){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2"  title="Unit field"  ></i>';
                        }else if($fieldValue['cesf']->getLength() ==1){
                            echo '<i class="fa fa-info-circle fa-2x info_tip2 tiptip2"  title="Length field"  ></i>';
                        }

                        if($fieldValue['field']->getFieldType()=='text'){?>
                            <input type="text" style="display:none; float:right;" value="<?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldValue() : '';  ?>" class="field_input text number_field input45" id="input_<?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldId() : ''; ?>" >

                        <?php
                        }else{
                            $select_values =explode("\n", $fieldValue['field']->getFieldValue());
                            ?>
                            <select style="display:none; float:right; border-radius: 3px;padding: 0.1em;width: 110px;" value="<?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldValue() : '';  ?>" class="field_input dont-uniform" id="input_<?php echo $fieldValue['values'] ? $fieldValue['values']->getFieldId() : ''; ?>">
                            <?php foreach($select_values as $select_value){
                                $selected = '';
                                if($fieldValue['values']){
                                    if($fieldValue['values']->getFieldValue()==$select_value){
                                        $selected = 'selected';
                                    }
                                }
                                
                                echo "<option value='".$select_value."' ".$selected ." >".$select_value."</option>";
                            }
                            echo "</select>";
                        } ?>

                        </div>
                        </li>

                    <?php
                }?>
                <li class="service_specifications">
                        <a href="#" style="float:right; margin-top: 5px;" class="btn mb-5px editServiceSpec" data-service-id="<?php echo $service->getServiceId() ?>" >
                            Edit Service</a>
                        <div class="clearfix"></div>
                    </li>
                <hr/>

                <li style="text-align:center"><h4>Estimate Info</h4></li>
                <!-- <li><span style="font-weight:bold">Profit:<input type="text"    value="" class="text proposal_service_profit input45 percentFormat "></span>
                    <span style="font-weight:bold">Overhead:<input type="text"    value="" class="text proposal_service_overhead input45 percentFormat "></span>
                    </li> -->
                <li><span style="font-weight:bold">Days:</span><span style="float:right" class="phase_max_days"></span>
               
                </li> 
                <li><strong>Estimate Price:</strong>
                    <span   id="service_total_<?php echo $service->getServiceId() ?>">
                    <input type="text"    style="border: 0px;background: transparent;width:70px;" readonly="readonly"    size="15" value="<?php echo $service->getPrice();?>" class="hide_input_style service_total_input currency_field styleInput service_total_<?php echo $service->getServiceId() ?>">
                    <input type="hidden"  id="ProposalId" value="<?php echo $service->getProposal(); ?>">
                    <?php if($oh_pm_type==1){?>
                        <span style=" ">
                        <a href="javascript:void('0');" class="proposal_service_estimate_price_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                      
                        <?php if ($account->getEditPrice()) { ?>
                        <span class="item_unit_edit_icon  tiptipleft"  data-service-id="<?php echo $service->getServiceId(); ?>" title="Service Total Price" style="margin-left: 5px; "><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                        <?php } ?>

                        
                        </span>
                    <?php }?>

                </span>
                <input type="hidden" value="<?php echo $service->getPrice();?>" id="old_total_val_save" class="old_total_val_save<?php echo $service->getServiceId();?>"><!--store prev val-->
                <input type="hidden" value="<?php echo $service->getServiceId();?>" id="get_service_id"><!--store prev val-->

            
                </li>
                <li class="list-item show_proposal_overhead_and_profit "  style="padding-right: 2px;">
                <?php if ($account->getEditPrice()) { ?>
                        <span class="if_edit_item_unit_price">
                            <a href="javascript:void(0);" style="margin-left: 157px;"  data-service-id="<?php echo $service->getServiceId(); ?>"  class="service_total_input btn  btn mb-5px tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a>
                            <a href="javascript:void(0);"   class="service_total_input btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a>
                       </span>
                        <!-- <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px; "><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span> -->
                    <?php } ?>
                </li>
                <li class="show_proposal_overhead_and_profit"  style="padding-right: 2px;"><strong>OH:</strong>
               
                    <span style="float: right;" >
                    <!-- <input type="text"   size="15" value="" class="  text percentFormat  proposal_service_overhead input45">  -->
                    <div class="input-group plus-minus-input">
                    <?php if($proposal_status_id !=5){?>
                        <div class="input-group-button" style=" float: left;">

                            <a  class="btn " style="padding: 0 1px;margin-right:0px" data-quantity="minus" data-field="proposal_service_overhead">
                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php }?>
                        <input type="text"   value="<?=$settings->getDefaultOverhead();?>" name ="proposal_service_overhead" class="quantity22  percentFormat proposal_service_overhead <?php if($proposal_status_id ==5){ echo "input60 hide_input_style ";}else{ echo "input45 text ";}?>"  <?php if($proposal_status_id ==5){ echo "readonly='readonly'";}?>>
                        <?php if($proposal_status_id !=5){?>
                        <div class="input-group-button" style=" float: right;">
                            <a  class="btn " style="padding: 0 1px;margin-right:0px" data-quantity="plus" data-field="proposal_service_overhead">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php }?>
                    </div>
                    </span>
                
                    <span style="float: right;margin-right:5px" class="proposal_service_overhead_price">10,000</span>
                </li>
                <li class="show_proposal_overhead_and_profit" style="padding-right: 2px;"><strong>PM: </strong>
               
                    <span style="float: right;" >
                    <!-- <input type="text"   size="15" value="" class="  text percentFormat  proposal_service_profit input45">  -->
                    
                    <div class="input-group plus-minus-input">
                    <?php if($proposal_status_id !=5){?>
                        <div class="input-group-button" style=" float: left;">

                            <a  class="btn " style="padding: 0 1px;margin-right:0px" data-quantity="minus" data-field="proposal_service_profit">
                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php }?>
                        <input type="text"   value="<?=$settings->getDefaultProfit();?>" name ="proposal_service_profit" class="quantity22  percentFormat proposal_service_profit  <?php if($proposal_status_id ==5){ echo "input60 hide_input_style ";}else{ echo "input45 text ";}?>" <?php if($proposal_status_id ==5){ echo "readonly='readonly'";}?> >
                        <?php if($proposal_status_id !=5){?>
                        <div class="input-group-button" style=" float: right;">
                            <a  class="btn " style="padding: 0 1px;margin-right:0px" data-quantity="plus" data-field="proposal_service_profit">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                        <?php }?>
                    </div>
                    <!-- <span class="proposal_service_profit_price2">10,000</span> -->
                    
                    </span>
                <?php //}?>
                    <span style="float: right;margin-right:5px" class="proposal_service_profit_price">10,000</span>
                    <!-- <div class="proposal_service_profit_price" style="line-height: 10px;margin-left: 134px;">10,000</div> -->
                </li>
                <li class="show_proposal_overhead_and_profit" style="padding-right: 0px;">
                <strong>Tax: </strong>
                    <div style="width:50%; float:right;padding-top: 4px;">
                    &nbsp;
                    <?php if($proposal_status_id !=5){?>
                        <a href="javascript:void(0);" style="float:right;padding:2px;margin-right:5px"  class="btn mb-5px blue-button save_adjust_profit_overhead_btn"   >
                        Save</a>
                        <a href="javascript:void(0);" style="float:right;padding:2px; margin-right:5px"  class="btn reset_overhead_profit_rate"   >
                    <i class="fa fa-fw fa-1x fa-undo "></i></a>
                    <?php }?>
                        </div>
                        <span style="float: right;margin-right:0px" class="proposal_service_tax_price"></span>
                </li>
                <li id="adjusted_total_<?php echo $service->getServiceId() ?>" style="display:none"><strong>Adjusted Price:</strong>
                    <span style="float: right;" ><input type="text"   size="15" value="<?=$service->getPrice();?>" class="adjusted_total_<?php echo $service->getServiceId() ?>  text adjusted_total_input currency_field input80"> </span>

                    <span style="float: right;display:none" class="span_adjusted_total_<?php echo $service->getServiceId() ?>"></span>
                    <a href="javascript:void(0);" style="float:right; margin-top:7px; margin-right:5px" class="btn undo-btn remove_adjusted_price_btn_<?php echo $service->getServiceId() ?>"  onclick="remove_adjusted_price()" >
                        <i class="fa fa-fw fa-1x fa-undo "></i></a>
                </li>
                <!-- <li >
                    <a href="javascript:void(0);" style="float:left;margin-top: 5px;" class="btn mb-5px blue-button adjust_price_btn_<?php echo $service->getServiceId() ?>"  onclick="adjust_price()" >
                        Adjust Price</a>
                    <div class="set_loader"><div class="cssloader" style="display: none;">loading</div></div>
                    <a href="javascript:void(0);" style="display:none; float:right;" onclick="save_adjust_price()" class="btn mb-5px blue-button save_adjust_price_btn_<?php echo $service->getServiceId() ?>"   >
                        Save</a>
                    <a href="javascript:void(0);" style="display:none;float:right;" onclick="revert_adjust_price()" class="btn mb-5px blue-button cancel_adjust_price_btn_<?php echo $service->getServiceId() ?>"  >
                        Cancel</a>

                </li> -->


            </ul>

        </li>
        <?php
    }
    ?>


</ul>

<a class="btn blue-button edit_proposal_btn" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId()); ?>" style="margin-left: 3px; margin-top: 2px; padding: 5px;">
    <i class="fa fa-fw fa-pencil"></i> Edit Proposal
</a>

<!--
<a class="btn blue-button" href="#" id="addCustomService">
    Add Custom Service
</a>
-->

<!-- Service Dialog -->
<div id="addService" title="Fine Tune and Customize Here">
    <input type="hidden" name="addServiceId" id="addServiceId" value="0">
    <h4>Service Name: <span id="addServiceName" title="Click to edit">Service Name Here</span>
    </h4>

    <div class="clearfix">
        <div id="addServiceTexts" class="serviceTexts" style="float: right; width: 660px;">

        </div>
        <div id="addServiceFields" class="serviceFields" style="float: left; width: 266px;">

        </div>
    </div>
    <div class="clearfix" style="float: right; width: 660px;">
        <form id="add-text-to-proposal" action="">
            <label style="display: none;">Add Text: &nbsp; </label>
            <input type="text" name="addServiceAddField" id="addServiceAddField"
                   style="width: 435px; margin-top: 5px; display: none">
            <a href="#" class="btn left addIcon" style="margin-top: 3px;" id="addServiceAddFieldButton">Add New Text</a>
        </form>
    </div>
</div>


<div id="editService" title="Fine Tune and Customize Here">
    <input type="hidden" name="editServiceId" id="editServiceId" value="0">
    <h4>Service Name: <span id="editServiceName" title="Click to edit">Service Name Here</span>
    </h4>

    <div class="clearfix">
        <div id="editServiceTexts" class="serviceTexts" style="float: right; width: 660px;">

        </div>
        <div id="editServiceFields" class="serviceFields" style="float: left; width: 266px;">

        </div>
        
        <form id="add-text-to-edit-proposal" action="" style="float: right; width: 660px;">
            <label style="display: none;">Add More: &nbsp; </label>
            <input type="text" name="editServiceAddField" id="editServiceAddField" style="width: 500px; display: none;">
            <a href="#" id="editServiceAddFieldButton"  class="btn left addIcon editServiceAddText" style="margin-top: 3px;">Add New Text</a>
        </form>
    </div>

</div>

<script type="text/javascript" src="<?php echo base_url() ?>3rdparty/jquery.generateId.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>3rdparty/jquery.jeditable.ckeditor.js"></script>
<script type="text/javascript">
var show_edit_flag = false;
    $(document).ready(function(){

var edit_msg ='<div id="show_edit_alert" style="float: left;width: 100%;color: red;padding-left: 20px;margin-top: -28px;"><i class="fa fa-fw fa-exclamation-circle" style="margin-right: 5px;"></i>This service has estimated items that may be updated by changing the specification</div>';
        //Add New Service
        $("#addService").dialog({
            autoOpen: false,
            modal: true,
            width: 966,
            
            draggable: false,
            resizable: false,
            buttons: {
                'Finish': {
                    id: 'addServiceFinish',
                    class: 'addServiceFinish update-button addIcon',
                    text: 'Add Service',
                    click: function () {
                        $(this).dialog('close');
                        if ($(".cke").is(":visible")) {
                            $("#textEditorOpen").dialog('open');
                            return false;
                        }
                        else {
                            $('#addServiceFinish span').text('Sending...');
                            $('#addServiceFinish').prop('disabled', true);
                            $('#addServiceFinish span').text('Add Service');
                            $('#addServiceFinish').prop('disabled', false);
                            addService(0);
                        }
                    }
                },
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });

        $("#editService").dialog({
            autoOpen: false,
            modal: true,
            width: 966,
            dialogClass: "myDialog",
            draggable: false,
            resizable: false,
            buttons: {
                'Save': {
                    id: 'editServiceSave',
                    class: 'editServiceSaveBtn update-button saveIcon',
                    text: 'Save',
                    click: function () {
                        if ($(".cke").is(":visible")) {
                            $("#textEditorOpen").dialog('open');
                            return false;
                        }
                        else {
                            $('#editServiceSave span').text('Saving...');
                            $('#editServiceSave').prop('disabled', true);
                            editService();
                        }
                    }
                },
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            },
            create: function() {
                $(".myDialog").append(edit_msg);
            }
        });
        // Open custom service dialog
        $("#addCustomService").click(function() {

            // Fetch the fields and display in popup
            $.getJSON('<?php echo site_url('ajax/getServiceDetails/1575'); ?>', function (data) {
                if (data.error == 1) {
                    alert('The service selected was not found. Please refresh the page and try again.');
                } else {
                    //init popup
                    $("#addServiceName").html('');
                    $("#addServiceTexts").html('');
                    $("#addServiceFields").html('');
                    //populate popup
                    $("#addServiceName").html(data.serviceName);
                    //add the texts
                    for (i in data.texts) {
                        $("#addServiceTexts").append('<div class="text clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + data.texts[i] + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
                    }
                    //add the fields
                    for (i in data.fields) {
                        $("#addServiceFields").append(data.fields[i]);
                    }
                    $("#addService").dialog('open');
                    $("#addServiceId").val(1575);
                    $("#addServiceAddField").val('');
                    initButtons();
                }
            });

            return false;
        });

        // Add a text
        $("#addServiceAddFieldButton").click(function () {

            $(".text").removeClass('newText');

            $("#addServiceTexts").append('<div class="text newText clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + $("#addServiceAddField").val() + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
            $("#addServiceAddField").val('');
            $("#addServiceTexts").sortable('refresh');
            var newItem = $(".newText").find('.theText').last();
            newItem.click();
            setTimeout(function () {
                newItem.click();
            }, 500);

            return false;
        });

        // Sortable service texts
        $("#addServiceTexts, #editServiceTexts").sortable({
            handle: '.handle'
        });

        //Edit Text
        $(".theText").live('click', function () {

            $(this).editable('<?php echo site_url('account/dummyPost') ?>', {
                type: 'ckeditor',
                cancel: 'Cancel',
                submit: 'OK',
                rows: 3,
                width: 510,
                height: 300,
                ckeditor: {
                    height: 100,
                    toolbar: [
                        {
                            name: 'basicstyles',
                            items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList']
                        },
                        {name: 'links', items: ['Link', 'Unlink']},
                        {name: 'spellcheck', items: ['jQuerySpellChecker']}
                    ]
                },
                onblur: 'ignore'
            });
        });

        // Adding a service
        function addService(redirect) {

            var postData = {};
            //get title
            postData.serviceName = $("#addServiceName").html();
            //get price
            postData.option = $('#optional').prop('checked') ? '1' : 0;
            postData.no_price = $('#no_price').prop('checked') ? '1' : 0;
            postData.price = $("#addPrice").val();
            postData.amountQty = $("#amountQty").val();
            postData.pricingType = $("#pricingType").val();
            postData.material = $("#material").val();
            postData.excludeFromTotals = $('#exclude_total').prop('checked') ? '1' : 0;
            postData.texts = [];
            //get texts
            var k = 0;
            $("#addServiceTexts div.text").each(function () {
                postData.texts[k] = $(this).children('span.theText').html();
                k++;
            });
            //get fields values
            postData.fields = {};
            $("#addServiceFields .field").each(function () {
                postData.fields[$(this).attr('id')] = $(this).val();
            });
            postData.serviceId = $("#addServiceId").val();
            postData.proposal = <?php echo $proposal->getProposalId(); ?>;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalAddService') ?>",
                data: postData,
                dataType: 'json'
            })
            .done(function (data) {

                if (!data.id) {
                    swal(
                        'Error',
                        'There was an error saving the information'
                    );
                    return;
                } else {
                    swal(
                        '',
                        'Service Saved. Reloading Estimator...'
                    );
                    setTimeout(function() {
                        window.location.reload();
                    }, 250);
                }
            });

        }

        // Editable Service Name
        $("#addServiceName, #editServiceName").editable('<?php echo site_url('account/dummyPost') ?>', {
            cancel: 'Cancel',
            submit: 'OK',
            width: 510,
            height: 100
        });

        // Fetch service details for edit
        $(document).on("click", ".editServiceSpec", function () {
            var serviceId = $(this).data('service-id');
            
            $.getJSON('<?php echo site_url('ajax/getProposalServiceDetails') ?>/' + serviceId, function (data) {

                    //init popup
                    $("#editServiceName").html('');
                    $("#editServiceTexts").html('');
                    $("#editServiceFields").html('');
                    $("#editServiceId").val(data.serviceId);
                    //populate popup
                    $("#editServiceName").html(data.serviceName);
                    //add the texts
                    for (i in data.texts) {
                        $("#editServiceTexts").append('<div class="text clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + data.texts[i] + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
                    }
                    //add the fields
                    for (i in data.fields) {
                        $("#editServiceFields").append(data.fields[i]);
                    }
                    $('#show_edit_alert').hide(); 
                    if(data.estimateItemCount>0){
                        $("#editPrice").attr('readonly','readonly');
                        $("#editPrice").addClass('hide_input_style2');
                        show_edit_flag = true;
                    }else{
                        $("#editPrice").removeAttr('readonly');
                        $("#editPrice").removeClass('hide_input_style2');
                        show_edit_flag = false;
                        
                    }
                    $("#editServiceAddField").val('');
                    $("#editService").dialog('open');
                    $("#editServiceTexts").sortable('refresh');
                    //updatePricingUI();
                    $.uniform.update();
                    initButtons();
                    

            });
            
            setTimeout(function(){
                console.log('fff')
                $.uniform.update();
            }, 5000);
            
            return false;
        });

        // Edit service add text
        $(".editServiceAddText").click(function () {

            $(".text").removeClass('newText');

            $("#editServiceTexts").append('<div class="text newText clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + $("#editServiceAddField").val() + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
            $("#editServiceAddField").val('');
            $("#editServiceTexts").sortable('refresh');

            var newItem = $(".newText").find('.theText').last();
            newItem.click();
            setTimeout(function () {
                newItem.click();
            }, 500);

            return false;
        });

        function editService() {

            var postData = {};
            //get title
            postData.serviceName = $("#editServiceName").html();
            //get price
            postData.noPrice = $('#edit_no_price').prop('checked') ? '1' : 0;
            postData.option = $('#editOptional').prop('checked') ? '1' : 0;
            postData.price = $("#editPrice").val();
            postData.amountQty = $("#amountQty").val();
            postData.pricingType = $("#pricingType").val();
            postData.material = $("#material").val();
            postData.texts = [];
            //get texts
            var k = 0;
            $("#editServiceTexts div.text").each(function () {
                postData.texts[k] = $(this).children('span.theText').html();
                k++;
            });
            //get fields values
            postData.fields = {};
            $("#editServiceFields .field").each(function () {
                postData.fields[$(this).attr('id')] = $(this).val();
            });
            postData.serviceId = $("#editServiceId").val();
            postData.proposal = proposalId;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalEditService') ?>",
                data: postData,
                dataType: 'json'
            })
            .done(function (data) {
                if (!data.id) {
                    swal(
                        'Error',
                        'There was an error saving the information'
                    );
                    return;
                } else {
                    swal(
                        '',
                        'Service Saved. Reloading Estimator...'
                    );
                    setTimeout(function() {
                        window.location.reload();
                        //console.log('cehc');
                    }, 250);
                }
            });
        }

        $(".remove").live('click', function () {
            console.log('remove');
            $(this).parents('.text').fadeOut('slow').remove();
            return false;
        });
        // End document ready
    });
    $(document).on("keyup","#editServiceFields input:not(#editPrice)",function(e) { 

        if(show_edit_flag){
            $('#show_edit_alert').show(); 
        }else{
            $('#show_edit_alert').hide();
        }

    });
    //
    $(document).ready(function(){
        hasReceivedFocus = false;  
             //enable input filed onclick edit button
        $('span.item_unit_edit_icon').click(function (){
        $('.service_total_input').removeAttr('readonly');
         $('.list-item').show();
         $('.styleInput').addClass("styleInputbox");
         var serviceId = $(this).data('service-id');
         console.log("sid",serviceId);
         $('.service_total_'+serviceId).focus(function() {
            if (!hasReceivedFocus) {
                hasReceivedFocus = true;
            }
         });

        });


        $('a.cancel_edit_item_unit_price').click(function (){
            var serviceId = $(this).data('service-id');
            console.log("ssss",hasReceivedFocus);
            if (hasReceivedFocus) {
                old_total_val_save =  $('.old_total_val_save'+serviceId).val(); 
                //console.log("oldValue",old_total_val_save);
                // console.log("serviceId", "old_total_val_save"+serviceId);
                $('.service_total_'+serviceId).val(old_total_val_save);
                $('.service_total_input').prop('readonly', true);
            }
        });
        $('a.update_itam_unit_price_btn').click(function (){
            $('.service_total_input').prop('readonly', true);
            $('.styleInput').removeClass("styleInputbox");
            $('.list-item').hide();
            $('.item_unit_edit_icon').show();
               var getNewvalue = $('.styleInput').val();
        });        
         
    });
    
</script>