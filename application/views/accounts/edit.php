<?php $this->load->view('global/header'); ?>
<style>
.select2-selection__rendered{
    float: left!important;
}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
.locked-tag .select2-selection__choice__remove{
  display: none!important;
}
.locked-tag:before {
            font-family: "FontAwesome";
            content: "\f023";
            border-right: 1px solid #aaa;
            cursor: pointer;
            font-weight: bold;
            padding: 0 4px;
        }
.select2_box_error{  padding:2px;border-radius: 2px;border: 1px solid #e47074 !important;background-color: #ffedad !important;box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;-moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;}
.select_box_error{  border-radius: 2px;border: 1px solid #e47074 !important;background-color: #ffedad !important;box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;-moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;}

/* Style for disabled input */
input:disabled {
  /* Your styles here */
  /* Add other styles to modify appearance */
  background-color: #ddd !important; 
  background-repeat: no-repeat;
}
 

</style>
<?php
/* @var $account \models\Accounts */
/* @var $cAccount \models\ClientCompany */
?>
    <div id="content" class="clearfix">
        <div class="widthfix">

            <div class="content-box">

                <div class="box-header">
                    Edit Account - <?php echo $cAccount->getName(); ?>
                    <a class="tiptip box-action" href="<?php echo site_url('accounts') ?>" title="Back to Accounts" style="margin-left: 10px;">Back</a>
                </div>
                <div class="box-content">

                    <form class="form-validated" method="post" action="<?php echo site_url('accounts/edit/' . $cAccount->getId()) ?>">
                        <div class="box-content">

                            <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2">
                                        <h3>Basic Information</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Company Name <span>*</span></label>
                                        <input class="text required capitalize <?php if(isset($disableAccountName) && $disableAccountName == 1) {echo 'tiptiptop';}?>" type="text"
                                          <?php if(isset($disableAccountName) && $disableAccountName == 1) { echo 'title="Residential account name is not editable"';}?>
                                           name="companyName" id="companyName" tabindex="1" value="<?php echo $cAccount->getName(); ?>"
                                        <?php if(isset($disableAccountName) && $disableAccountName == 1) {echo 'disabled readonly';}?>

                                        >
                                      

                                    </td>
                                    <td>
                                        <label>Website</label>
                                        <input class="text" type="text" name="website" id="website" tabindex="6" value="<?php echo $cAccount->getWebsite(); ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Address</label>
                                        <input class="text" type="text" name="address" id="address" tabindex="2" value="<?php echo $cAccount->getAddress(); ?>">
                                    </td>
                                    <td>
                                        <label>Business Phone</label>
                                        <input class="text" type="text" name="businessPhone" id="businessPhone" tabindex="7" value="<?php echo $cAccount->getPhone(); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>City</label>
                                        <input class="text" type="text" name="city" id="city" tabindex="3" value="<?php echo $cAccount->getCity(); ?>">
                                    </td>
                                    <td>
                                    <div >
                                    <label style="width: 144px;margin-right: 6px;">Account Business Type <span>*</span></label>
                                    <select  class="dont-uniform businessTypeMultiple required"  style="width: 292px" name="business_type[]" multiple="multiple"><option value=""></option>
                                        <?php 
                                                foreach($businessTypes as $businessType){
                                                    if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected="selected"';}else{ $selected = '';}
                                                    if(in_array($businessType->getId(), $disableBusinessTypes) && ($selected !='')){ $disabled = 'disabled="disabled"';}else{ $disabled = '';}
                                                    echo '<option value="'.$businessType->getId().'"  '.$selected.' '.$disabled.' >'.$businessType->getTypeName().'</option>';
                                                }
                                                $proposal_select_display = (count($assignedBusinessTypes)>1)?'block':'none';
                                        ?>
                                        </select>
                                    </div>
                                        <div style="padding-left: 148px;padding-top: 8px;padding-bottom: 8px;float: left;"><input type="checkbox" value="1"  name="apply_bt_on_contact" id="apply_bt_on_contact"><span style="padding-top: 5px;float: left;">Edit all Contacts and Proposals to this Business Type</span></div>
                                        <div style="display: none;" class="bt_on_proposal_p" ><label style="width: 147px;margin-right: 1px;">Proposal Business Type <span>*</span></label>
                                            <select name="apply_bt_on_proposal"  id="apply_bt_on_proposal"> 
                                                <option value=""> Please select</option>
                                                <?php 
                                                        foreach($businessTypes as $businessType){
                                                            //if(in_array($businessType->getId(), $assignedBusinessTypes)){ $display = 'none';}else{ $display = 'block';}
                                                            $display = (!in_array((int)$businessType->getId(), $assignedBusinessTypes)) ? 'none' : 'block';
                                                            echo '<option value="'.$businessType->getId().'" style="display:'.$display.'">'.$businessType->getTypeName().'</option>';
                                                        }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="bt_on_proposal_p" style="padding-left: 150px;padding-top: 8px;float: left;display: none">Please select any one(1) Business Type for proposals.</div><br/>                            
                            
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>State</label>
                                        <input class="text " type="text" name="state" id="state" tabindex="4" value="<?php echo $cAccount->getState(); ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr >
                                    <td>
                                        <label>Zip</label>
                                        <input class="text " type="text" name="zip" id="zip" tabindex="5" value="<?php echo $cAccount->getZip(); ?>">
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <?php if ($account->getUserClass() > 0) { ?>
                                                <p class="clearfix">
                                                    <label>Account Owner</label>
                                                    <select name="account" id="account" tabindex="9">
                                                        <?php
                                                        foreach ($companyUsers as $user) {
                                                            ?>
                                                            <option <?php if ($user->getAccountId() == $cAccount->getOwnerUser()->getAccountId()) { ?>selected="selected" <?php } ?> value="<?php echo $user->getAccountId() ?>"><?php echo $user->getFullName() ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </p>
                                            <?php } else { ?>
                                                <select name="account" id="account" tabindex="9">
                                                    <option value="<?php echo $account->getAccountId(); ?>"><?php echo $account->getFullName(); ?></option>
                                                </select>
                                            <?php } ?>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="button" class="btn blue" name="edit" id="addAccount" tabindex="10" value="Save Account" style="margin: 20px 0 20px 150px;">
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </form>
                </div>

            </div>


        </div>
    </div>

    <script type="text/javascript">
    var disable_business_types = [<?=(implode(',',$disableBusinessTypes));?>];
$(document).on('ready', function () {

$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
    var oldRemoveChoice = Search.prototype.searchRemoveChoice;
    console.log(Search)
    Search.prototype.searchRemoveChoice = function (e) {
        console.log(e);
        var checked = $('#apply_bt_on_contact').is(':checked');
         if(arguments[1].disabled && !checked){
            return false;
        }else{
            oldRemoveChoice.apply(this, arguments);
            this.$search.val('');
        }
        
    };
    
    $('.businessTypeMultiple').select2({
                placeholder: "Select one or many",
                templateSelection : function (tag, container){
                            var $option = $('.businessTypeMultiple option[value="'+tag.id+'"]');
                            
                            if ($option.attr('disabled')){
                                $(container).addClass('locked-tag');
                                $(container).addClass('tag_tiptip');
                                tag.title = 'This business type can not be deleted<br/> Because a proposal or contact belonging to this account has this Business Type';
                                tag.locked = true;
                            }else{
                                tag.title = tag.text;
                            }
                            return tag.text;
                            
                        }
            })

            $(".tag_tiptip").tipTip({defaultPosition:'left'});
});

            var opt = $('.businessTypeMultiple option:disabled').map(function(i,v) {
                        return this.value;
                    }).get();
                   
                    if(opt.length){
                        $('.businessTypeMultiple').removeClass('required');
                    }else{
                        //$('.businessTypeMultiple').addClass('required');
                    }

            $("#tabs").tabs();
            <?php if ($this->uri->segment(4) == 'schedule'): ?>
            $('#tabs').tabs('select', "tabs-2");
            <?php endif; ?>
            $("#businessPhone").mask("999-999-9999");
            $(".tag_tiptip").tipTip({defaultPosition:'left'});
        });

        $(document).on("change",".businessTypeMultiple22",function(e) {
            
            if($(this).val()){
                $(this).closest('td').find('.select2-container ').removeClass('select2_box_error');
            }else{
                
                $(this).closest('td').find('.select2-container ').addClass('select2_box_error');
            
            }
            
        });

        $(document).on('change', ".businessTypeMultiple", function () {
                        var bt_value = $('.businessTypeMultiple option:selected').map(function(i,v) {
                                    return this.value;
                                }).get();
                        var btn_disable = true;
                        if(bt_value && bt_value.length > 1){
                            if(jQuery.inArray($("#apply_bt_on_proposal").val(), bt_value) == -1){
                                $("#apply_bt_on_proposal").val('').trigger('change');;
                            }
                            
                            $("#apply_bt_on_proposal").children('option').hide();
                            for($i=0;$i<bt_value.length;$i++){
                                $("#apply_bt_on_proposal").children("option[value=" + bt_value[$i] + "]").show()
                            }
                            $("#apply_bt_on_proposal").children("option[value='']").show();
                            
                            if($('#apply_bt_on_contact').is(':checked')){
                                $("#apply_bt_on_proposal").addClass('required');
                                
                                $('.bt_on_proposal_p').show();
                                if($('#apply_bt_on_proposal').val()){
                                    btn_disable = true;
                                    
                                }else{
                                    btn_disable = false;
                                    
                                }
                            }else{
                                btn_disable = true;
                                $("#apply_bt_on_proposal").removeClass('required');
                            }
                        }else if(bt_value && bt_value.length == 1){
                            btn_disable = true;
                            $('.bt_on_proposal_p').hide();
                            $("#apply_bt_on_proposal").removeClass('required');
                        }else{
                            btn_disable = false;
                            $("#apply_bt_on_proposal").removeClass('required');
                        }

                        
                        if(bt_value.length>0){
                           $(this).closest('td').find('.select2-container ').removeClass('select2_box_error');
                        }else{
                            $(this).closest('td').find('.select2-container ').addClass('select2_box_error');
                        }
                        
                
            });

            $(document).on('change', "#apply_bt_on_proposal", function () {
                     if($('#apply_bt_on_proposal').val()){
                        $('#uniform-apply_bt_on_proposal').removeClass('select_box_error');
                    
                     }else{
                        $('#uniform-apply_bt_on_proposal').addClass('select_box_error');
                   
                     }
            });
            $(document).on('change', "#apply_bt_on_contact", function () {
                if($('#apply_bt_on_contact').is(':checked')){
                    $(".businessTypeMultiple option").attr("disabled", false);
                    $(".businessTypeMultiple").trigger('change')
                    var bt_value = $('.businessTypeMultiple option:selected').map(function(i,v) {
                                    return this.value;
                                }).get();
                    if(bt_value && bt_value.length > 1){
                        if(!$("#apply_bt_on_proposal").hasClass("required")){
                            $("#apply_bt_on_proposal").addClass('required');
                        }
                        $('.bt_on_proposal_p').show();
                    }
                }else{
                    for($i=0;$i<disable_business_types.length;$i++){
                        $(".businessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("selected", true);
                        $(".businessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("disabled", true);
                    }
                    $(".businessTypeMultiple").trigger('change')
                    $('.bt_on_proposal_p').hide();
                    $("#apply_bt_on_proposal").removeClass('required');
                }
                $(".tag_tiptip").tipTip({defaultPosition:'left'});
            })
        $(document).on("click","#addAccount",function(e) {
           
            
            if($('.businessTypeMultiple').val()){
                $('.businessTypeMultiple').closest('td').find('.select2-container ').removeClass('select2_box_error');
            }else{
                $('.businessTypeMultiple').closest('td').find('.select2-container ').addClass('select2_box_error');
            }
            
            if($('#apply_bt_on_proposal').val()=='' && $("#apply_bt_on_proposal").hasClass("required")){
                $('#uniform-apply_bt_on_proposal').addClass('select_box_error');
            }else{
                $('#uniform-apply_bt_on_proposal').removeClass('select_box_error');
            }

            var valid = $('.form-validated').valid();
            if(valid){
                if($('#apply_bt_on_contact').is(':checked')){
                    $.get("<?php echo site_url('ajax/getAccountProposalCount') ?>/"+<?=$cAccount->getId();?>, function(proposal_count){
                    
                        var bt_value = $('.businessTypeMultiple option:selected').map(function(i,v) {
                                            return this.value;
                                        }).get();
                        if(bt_value && bt_value.length > 1){
                            
                            var btName = $( "#apply_bt_on_proposal option:selected" ).text();
                        }else{
                            var btName = $( ".businessTypeMultiple option:selected" ).text();
                        }
                        var cName =$('#companyName').val();
                        var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>"+
                                    "<table style='text-align: left;line-height: 25px;width: 100%;'><tr><th style='text-align: right;width: 30%;'>Account:</th><td style='padding-left:10px'>"+cName+"</td></tr>"+
                                    "<tr><th style='text-align: right;'>New Business Type:</th><td style='padding-left:10px'>"+btName+"</td></tr>"+
                                    "<tr><th style='text-align: right;'>Proposals Affected:</th><td style='padding-left:10px'>"+proposal_count+"</td></tr></table>"
                        swal({
                            title: "WARNING!",
                            text: table,
                            width:700,
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                            cancelButtonText: "Cancel",
                            dangerMode: false,
                        }).then(function(isConfirm) {
                            if (isConfirm) {

                                $('.form-validated').submit();
                                swal({
                                    title: 'Saving..',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    timer: 20000,
                                    onOpen: () => {
                                    swal.showLoading();
                                    }
                                })

                            } else {
                                
                            }
                        });
                    });//ajax
                }else{
                    $('.form-validated').submit();
                    swal({
                                title: 'Saving..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 20000,
                                onOpen: () => {
                                swal.showLoading();
                                }
                            })
                }
            }
        });
    </script>

<?php $this->load->view('global/footer'); ?>