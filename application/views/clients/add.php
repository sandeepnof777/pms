<?php $this->load->view('global/header'); ?>
<style>
.select2-selection__rendered{
    float: left!important;
}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
.ui-autocomplete-loading { background:url('../static/loading.gif') no-repeat right center }
.select2_box_error{  padding:2px;border-radius: 2px;border: 1px solid #e47074 !important;background-color: #ffedad !important;box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;-moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;}
</style>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                    <?php if (help_box(56)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(56, true) ?></div>
                    <?php } ?>
                    <?php echo (!isset($duplicate) || !$duplicate) ? 'Add Contact' : 'Adding duplicate contact: ' . $duplicate->getFirstName() . ' ' . $duplicate->getLastName() . ' [ ' . $duplicate->getClientAccount()->getName() . ' ]'; ?>
                    <a class="box-action" href="<?php echo site_url('clients') ?>">Back</a>
                </div>
                <div class="box-content">

                    <div id="nameWarning">
                        <div class="closeSection">&times;</div>
                        <p>You already have other contacts with a similar name. To avoid duplicating contacts, please make
                            sure this contacts hasn't already been created</p><br/>
                        <table id="existingAccountTable" class="table boxed-table">
                            <thead>
                            <th>Contact</th>
                            <th>Account</th>
                            <th>Actions</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <?php echo form_open('clients/add/' . $this->uri->segment(3), array('id' => 'clientForm', 'class' => 'form-validated', 'autocomplete' => 'off')) ?>
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2">
                                <h3>Contact Details</h3>
                            </td>
                        </tr>
                        <tr class="newAccount">
                            <td>
                                <label>Account Name</label>
                                <input class="text capitalize" type="text" name="accCompanyName"
                                       id="accCompanyName" value="<?php  if(@$duplicate){ echo $duplicate->getClientAccount()->getName();}else{ if($this->session->userdata('co_accCompanyName') !=''){ echo $this->session->userdata('co_accCompanyName');$this->session->set_userdata('co_accCompanyName','');}else{ echo set_value('accCompanyName');}} ?>" tabindex="2" placeholder="Leave Blank for Residential">
                                <input type="hidden" name="accountId" id="accountId" value="<?php  if(@$duplicate){ echo $duplicate->getClientAccount()->getId();}else{ if($this->session->userdata('co_accountId') !=''){ echo $this->session->userdata('co_accountId');}else{ echo set_value('accountId');}} ?>"/>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Zip <span>*</span></label>
                                    <input tabindex="17" class="text required" type="text" name="zip" id="zip"
                                           value="<?php echo (@$duplicate) ? $duplicate->getZip() : set_value('zip') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="10" class="text required capitalize" type="text" name="firstName"
                                           id="firstName"
                                           value="<?php  if(@$duplicate){ echo $duplicate->getFirstName();}else{ if($this->session->userdata('co_firstName') !=''){ echo $this->session->userdata('co_firstName');$this->session->set_userdata('co_firstName','');}else{ echo set_value('firstName');}} ?>">
                                </p>
                            </td>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Business Phone</label>
                                    <input tabindex="18" class="text" style="width: 100px;" type="text"
                                           name="businessPhone" id="businessPhone"
                                           value="<?php echo (@$duplicate) ? $duplicate->getBusinessPhone() : $this->input->post('businessPhone') ?>">
                                    &nbsp;&nbsp;&nbsp;<input tabindex="19" class="text tiptiptop" style="width: 50px;"
                                                             placeholder="Ext"
                                                             title="Please type the business phone extension"
                                                             type="text" name="businessPhoneExt" id="businessPhoneExt"
                                                             value="<?php echo (@$duplicate) ? $duplicate->getFirstName() : set_value('businessPhoneExt') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="11" class="text required capitalize" type="text" name="lastName"
                                           id="lastName"
                                           value="<?php  if(@$duplicate){ echo $duplicate->getLastName();}else{ if($this->session->userdata('co_lastName') !=''){ echo $this->session->userdata('co_lastName');$this->session->set_userdata('co_lastName','');}else{ echo set_value('lastName');}} ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Cell Phone</label>
                                    <input tabindex="20" class="text" type="text" name="cellPhone" id="cellPhone"
                                           value="<?php echo (@$duplicate) ? $duplicate->getCellPhone() : set_value('cellPhone') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Title</label>
                                    <input tabindex="12" class="text" type="text" name="title" id="title"
                                           value="<?php echo (@$duplicate) ? $duplicate->getTitle() : $this->input->post('title') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Fax</label>
                                    <input tabindex="21" class="text" type="text" name="fax" id="fax"
                                           value="<?php echo (@$duplicate) ? $duplicate->getFax() : $this->input->post('fax') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Address <span>*</span></label>
                                    <input tabindex="13" class="text required" type="text" name="address" id="address"
                                           value="<?php echo (@$duplicate) ? $duplicate->getAddress() : set_value('address') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Email <span>*</span></label>
                                    <input tabindex="22" class="text required email" type="text" name="email" id="email"
                                           value="<?php  if(@$duplicate){ echo $duplicate->getEmail();}else{ if($this->session->userdata('co_email') !=''){ echo $this->session->userdata('co_email');$this->session->set_userdata('co_email','');}else{ echo set_value('email');}} ?><?php echo (@$duplicate) ? $duplicate->getEmail() : set_value('email') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>City <span>*</span></label>
                                    <input tabindex="14" class="text required" type="text" name="city" id="city"
                                           value="<?php echo (@$duplicate) ? $duplicate->getCity() : set_value('city') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Website</label>
                                    <input tabindex="23" class="text" type="text" name="website" id="website"
                                           value="<?php echo (@$duplicate) ? $duplicate->getWebsite() : $this->input->post('website') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>State <span>*</span></label>
                                    <input tabindex="15" class="text required" type="text" name="state" id="state"
                                           value="<?php echo (@$duplicate) ? $duplicate->getState() : $this->input->post('state') ?>">
                                </p>
                            </td>
                            <td>
                                <label>Business Type <span>*</span></label>
                                <select tabindex="24"  class="dont-uniform businessTypeMultiple required"  style="width: 64%" name="business_type[]" multiple="multiple">
                                <?php 
                                        foreach($businessTypes as $businessType){
                                            echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                        }
                                ?>
                                </select>
                                
                            </td>
                        </tr>

                        <tr>
                        
                            <td>
                                <p class="clearfix left">
                                        <label>Owner</label>
                                        <?php
                                        $options = array();
                                        $accounts = $account->getCompany()->getAccounts();
                                        $selected = [$account->getAccountId()];
                                        foreach ($accounts as $acc) {
                                            if (!$acc->isSecretary()) {
                                                $options[$acc->getAccountId()] = $acc->getFullName();
                                            }
                                        }
                                        $params = ' style="margin-top: 5px;"';
                                        echo form_dropdown('owner', $options, $selected, ' tabindex="16"');
                                        ?>
                                    </p>
                                
                            </td>
                            <td></td>
                    </tr>
                        <!--Billing Details-->

                        <tr>
                            <td colspan="2" style="padding-top: 20px;">
                                <h3 class="left">Billing Details</h3>
                                <a href="#" class="btn small left" id="sameAsAbove" style="margin-left: 18px; margin-top: 6px;">Same as Contact Details</a>
                                <span class="left" style="margin-left: 20px; margin-top: 12px;">Add if billing details are different from contact</span>
                            </td>
                        </tr>

                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="25" class="text required capitalize" type="text" name="billingFirstName"
                                           id="billingFirstName"
                                           value="<?php echo (@$duplicate) ? $duplicate->getFirstName() : set_value('billingFirstName') ?>">
                                </p>
                            </td>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Zip <span>*</span></label>
                                    <input tabindex="31" class="text required" type="text" name="billingZip" id="billingZip"
                                           value="<?php echo (@$duplicate) ? $duplicate->getZip() : set_value('billingZip') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="26" class="text required capitalize" type="text" name="billingLastName"
                                           id="billingLastName"
                                           value="<?php echo (@$duplicate) ? $duplicate->getLastName() : set_value('billingLastName') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Business Phone</label>
                                    <input tabindex="32" class="text" style="width: 100px;" type="text"
                                           name="billingBusinessPhone" id="billingBusinessPhone"
                                           value="<?php echo (@$duplicate) ? $duplicate->getBusinessPhone() : $this->input->post('billingBusinessPhone') ?>">
                                    &nbsp;&nbsp;&nbsp;<input tabindex="33" class="text tiptiptop" style="width: 50px;"
                                                             placeholder="Ext"
                                                             title="Please type the business phone extension"
                                                             type="text" name="billingBusinessPhoneExt" id="billingBusinessPhoneExt"
                                                             value="<?php echo (@$duplicate) ? $duplicate->getFirstName() : set_value('billingBusinessPhoneExt') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Title</label>
                                    <input tabindex="27" class="text" type="text" name="billingTitle" id="billingTitle"
                                           value="<?php echo (@$duplicate) ? $duplicate->getTitle() : $this->input->post('billingTitle') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Cell Phone</label>
                                    <input tabindex="34" class="text" type="text" name="billingCellPhone" id="billingCellPhone"
                                           value="<?php echo (@$duplicate) ? $duplicate->getCellPhone() : set_value('billingCellPhone') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Address <span>*</span></label>
                                    <input tabindex="28" class="text required" type="text" name="billingAddress" id="billingAddress"
                                           value="<?php echo (@$duplicate) ? $duplicate->getAddress() : set_value('billingAddress') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Fax</label>
                                    <input tabindex="35" class="text" type="text" name="billingFax" id="billingFax"
                                           value="<?php echo (@$duplicate) ? $duplicate->getFax() : $this->input->post('billingFax') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>City <span>*</span></label>
                                    <input tabindex="29" class="text required" type="text" name="billingCity" id="billingCity"
                                           value="<?php echo (@$duplicate) ? $duplicate->getCity() : set_value('billingCity') ?>">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix left">
                                    <label>Email <span>*</span></label>
                                    <input tabindex="36" class="text required email" type="text" name="billingEmail" id="billingEmail"
                                           value="<?php echo (@$duplicate) ? $duplicate->getEmail() : set_value('billingEmail') ?>">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>State <span>*</span></label>
                                    <input tabindex="30" class="text required" type="text" name="billingState" id="billingState"
                                           value="<?php echo (@$duplicate) ? $duplicate->getState() : $this->input->post('billingState') ?>">
                                </p>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>


                        <tr class="even">
                            <td colspan="2"><label>&nbsp;</label>

                                <?php
                                if ($qbPermission) {
                                    ?>
                                    <span style="float: left; padding-top: 10px; margin-right: 20px;" id="qbAdd">

                                Add to QuickBooks?&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="addToQb" value="1" class="qbRadio"> Yes
                                <input type="radio" name="addToQb" value="0" class="qbRadio"> No

                                </span>
                                    <?php
                                }
                                ?>
                                
                                <input type="submit" tabindex="37" value="<?php echo($is_create_proposal)?'Create Proposal':'Add Contact';?>" id="addClientSave"
                                       class="btn ui-button update-button">
                            </td>
                        </tr>
                    </table>
                    <?php echo form_close() ?>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.businessTypeMultiple').select2({
                placeholder: "Select one or many"
            });
            var noNameWarning = false;
            

            $("#accCompanyName").autocomplete({
                minLength: 2,
                source: function( request, response ) {
                    $.ajax( {
                        url: "<?php echo site_url('ajax/searchClientAccountsOject'); ?>",
                    dataType: "JSON",
                    data: {
                        searchVal: request.term
                    },
                    success: function( data ) {
                        
                        response( data );
                    }
                    } );
                },
                focus: function (event, ui) {
                    $("#accCompanyName").val(ui.item.accountName);
                    return false;
                },
                select: function (event, ui) {
                    if($("#address").val() =='' && $("#city").val() =='' && $("#state").val() =='' && $("#zip").val() ==''){
                        $("#accCompanyName").val(ui.item.accountName);
                        $("#accountId").val(ui.item.value);
                        $("#address").val(ui.item.address);
                        $("#city").val(ui.item.city);
                        $("#state").val(ui.item.state);
                        $("#zip").val(ui.item.zip);
                        $("#businessPhone").val(ui.item.businessPhone);
                        $("#website").val(ui.item.website);
                    }
                    return false;
                }
            });



            $("#accCompanyName").keyup(function () {
                $("#accountId").val('');
            });

            $("#businessPhone, #accBusinessPhone, #cellPhone, #fax, #billingBusinessPhone, #billingCellPhone, #billingFax").mask("999-999-9999");

            // Enable the button if no QB
            if ($('#qbAdd').length) {
                $('#addClientSave').button("option", "disabled", true);
            }

            // Enable the save button when radio selected
            $('input.qbRadio').click(function () {
                $('#addClientSave').button("option", "disabled", false);
            });

            $("#lastName").keyup(function () {

                if (!noNameWarning) {
                    if ($(this).val().length < 3) {
                        $("#nameWarning").hide();
                    }
                    else {
                        searchClientName();
                    }
                }
                return false;
            });

            $(".closeSection").click(function () {
                $("#nameWarning").hide();
                noNameWarning = true;
            });

            $(".copyToForm").live('click', function () {
                // Grab the result
                var resultIndex = $(this).data('result-index');
                var contact = searchContacts[resultIndex];
                // Apply to form
                $("#title").val(contact.title);
                $("#address").val(contact.address);
                $("#city").val(contact.city);
                $("#state").val(contact.state);
                $("#zip").val(contact.zip);
                $("#email").val(contact.email);
                $("#businessPhone").val(contact.phone);
                $("#businessPhoneExt").val(contact.phoneExt);

                return false
            });

            $("#sameAsAbove").on('click', function () {
                $("#billingFirstName").val($("#firstName").val());
                $("#billingLastName").val($("#lastName").val());
                $("#billingTitle").val($("#title").val());
                $("#billingAddress").val($("#address").val());
                $("#billingCity").val($("#city").val());
                $("#billingState").val($("#state").val());
                $("#billingZip").val($("#zip").val());
                $("#billingBusinessPhone").val($("#businessPhone").val());
                $("#billingBusinessPhoneExt").val($("#businessPhoneExt").val());
                $("#billingCellPhone").val($("#cellPhone").val());
                $("#billingFax").val($("#fax").val());
                $("#billingEmail").val($("#email").val());

                //var validator = $( "#clientForm" ).validate();
                //validator.form();

                return false;
            });

<?php if($this->session->userdata('co_accountId') !=''){?>
        var temp_co_accountId = "<?=$this->session->userdata('co_accountId');?>";

        $.ajax( {
                    url: "<?php echo site_url('ajax/searchClientAccountOject'); ?>/"+temp_co_accountId,
                    dataType: "JSON",
                    
                    success: function( data ) {
                        $("#address").val(data[0].address);
                        $("#city").val(data[0].city);
                        $("#state").val(data[0].state);
                        $("#zip").val(data[0].zip);
                        $("#businessPhone").val(data[0].businessPhone);
                        $("#website").val(data[0].website);
                        $('#title').focus();
                    }
                });


            // $("#accCompanyName").val(ui.item.accountName);
            // $("#accountId").val(ui.item.value);
            
<?php $this->session->set_userdata('co_accountId',''); } ?>

        });

        initAutocomplete();

        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('address')),
                {
                    fields: ["name", "geometry.location", "formatted_address"]
                });

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();

                var address = place.formatted_address;
                var value = address.split(",");

                var addr = value[0];
                var count = value.length;
                var state = value[count-2];
                var city = value[count-3];
                var stateZip = state.split(" ");
                var stateTxt = stateZip[1];
                var zipTxt = stateZip[2];

                $("#address").val(addr.trim());
                $("#city").val(city.trim());
                $("#state").val(stateTxt.trim());
                $("#zip").val(zipTxt.trim());
            });
        }

        $('#address').keydown(function (e) {
            if (e.which == 13 && $('.pac-container:visible').length) return false;
        });


        var searchContacts = [];

        var req = null;
        function searchClientName() {
            if (req != null) req.abort();

            searchContacts = [];

            req = $.ajax({
                type: "GET",
                url: "/ajax/ajaxSearchClientName",
                data: {
                    'firstName': $("#firstName").val(),
                    'lastName': $("#lastName").val()
                },
                dataType: "json",
                success: function (data) {


                    $("#existingAccountTable tbody").html('');
                    if (data.length > 0) {
                        $.each(data, function (index, value) {
                            searchContacts[index] = value;

                            $("#existingAccountTable tbody").append('<tr>' +
                                '<td>' + value.name + '</td>' +
                                '<td>' + value.account + '</td>' +
                                '<td class="text-center">' +
                                '<a href="/clients/edit/' + value.id + '" class="box-action">Edit</a>' +
                                '<a href="/proposals/add/' + value.id + '" class="box-action">Add Proposal</a>' +
                                '<a href="#" class="box-action copyToForm" data-result-index="' + index + '">Copy Contact Details</a>' +
                                '</td>' +
                                '</tr>');
                        });
                        $("#nameWarning").show();
                    }
                    else {
                        $("#nameWarning").hide();
                    }
                }
            });

        }

    $(document).on("change",".businessTypeMultiple",function(e) {
         
         if($(this).val()){
             $(this).closest('td').find('.select2-container ').removeClass('select2_box_error');
         }else{
            
            
                $(this).closest('td').find('.select2-container ').addClass('select2_box_error');
           
         }
        
     });
     $(document).on("click","#addClientSave",function(e) {
        if($('.businessTypeMultiple').val()){
             $('.businessTypeMultiple').closest('td').find('.select2-container ').removeClass('select2_box_error');
         }else{
            
                $('.businessTypeMultiple').closest('td').find('.select2-container ').addClass('select2_box_error');
          
         }
        
     });
    </script>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>