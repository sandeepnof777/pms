<?php $this->load->view('global/header'); ?>
<style>
.select2-selection__rendered{
    float: left!important;
}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Add Prospect
                <a class="box-action" href="<?php echo site_url('prospects') ?>">Back</a>
            </div>
            <div class="box-content">
                <?php echo form_open('prospects/add', array('class' => 'form-validated','id'=>'prospect_form', 'autocomplete' => 'off')) ?>
                <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                    <?php
                    if ($account->isAdministrator()) {
                        ?>
                        <tr class="even">
                            <td>
                                <label>Owner</label>
                                <?php
                                echo form_dropdown('account', $accounts, $account->getAccountId(), 'id="account" tabindex="1"');
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td width="50%">
                            <p class="clearfix left">
                                <label>Account Name</label>
                                <input tabindex="1" class="text" type="text" name="companyName" id="companyName" value="<?php echo set_value('companyName') ?>" placeholder="Leave blank for Residential">
                            </p>

                        </td>
                        <td width="50%">
                            <p class="clearfix left">
                                <label>Zip </label>
                                <input tabindex="21" class="text " type="text" name="zip" id="zip" value="<?php echo set_value('zip') ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix left">
                                <label>First Name <span>*</span></label>
                                <input tabindex="2" class="text capitalize required" type="text" name="firstName" id="firstName" value="<?php echo set_value('firstName') ?>">
                            </p>

                        </td>
                        <td>
                            <p class="clearfix left">
                                <label>Business Phone</label>
                                <input tabindex="23" class="text formatPhone" style="width: 100px" type="text" name="businessPhone" id="businessPhone" value="<?php echo $this->input->post('businessPhone') ?>">
                                &nbsp;&nbsp;&nbsp;<input tabindex="23"class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension" type="text" name="businessPhoneExt" id="businessPhoneExt" value="<?php echo set_value('businessPhoneExt'); ?>">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Last Name <span>*</span></label>
                                <input tabindex="3" class="text capitalize required " type="text" name="lastName" id="lastName" value="<?php echo set_value('lastName') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix left">
                                <label>Cell Phone</label>
                                <input tabindex="24" class="text formatPhone" type="text" name="cellPhone" id="cellPhone" value="<?php echo set_value('cellPhone') ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix left">
                                <label>Title</label>
                                <input tabindex="4" class="text" type="text" name="title" id="title" value="<?php echo $this->input->post('title') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix left">
                                <label>Fax</label>
                                <input tabindex="25" class="text formatPhone" type="text" name="fax" id="fax" value="<?php echo $this->input->post('fax') ?>">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Address </label>
                                <input tabindex="5" class="text" type="text" name="address" id="address" value="<?php echo set_value('address') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix left">
                                <label>Email <span>*</span></label>
                                <input tabindex="26" class="text email required" type="text" name="email" id="email" value="<?php echo set_value('email') ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix left">
                                <label>City </label>
                                <input tabindex="6" class="text" type="text" name="city" id="city" value="<?php echo set_value('city') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix left">
                                <label>Website</label>
                                <input tabindex="27" class="text" type="text" name="website" id="website" value="<?php echo $this->input->post('website') ?>">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>State </label>
                                <input tabindex="7" class="text" type="text" name="state" id="state" value="<?php echo $this->input->post('state') ?>">
                            </p>
                        </td>
                        <td>
                            <label>Business Type</label>
                            <select  class="dont-uniform businessTypeMultiple"  style="width: 64%" name="business_type[]" multiple="multiple">
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select>
                            <?php //echo form_dropdown('business', $businesses, '', 'id="business" tabindex="28"') ?>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Status</label>
                            <?php echo form_dropdown('status', $statuses, '', 'id="status" tabindex="8"') ?>
                        </td>
                        <td>
                            <label>Rating</label>
                            <?php echo form_dropdown('rating', $ratings, '', 'id="rating" tabindex="9"') ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Source</label>
                            <?php echo form_dropdown('source', $sources, '', 'id="sources" tabindex="9"') ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr class="even">
                        <td><label>&nbsp;</label><button value="1" class="btn blue-button submit_form" tabindex="28" type="submit" name="add"> <i class="fa fa-fw fa-plus"></i> Add Prospect</button></td>
                        <td></td>
                    </tr>
                </table>
                <?php echo form_close() ?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Phone formatting
        $("#businessPhone, #cellPhone, #fax").mask("999-999-9999");

        initAutocomplete();
        $('.businessTypeMultiple').select2({
            placeholder: "Select one or many"
        });
        // Address autocomplete
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

    });

    
</script>
<!--#content-->
<?php $this->load->view('global/footer'); ?>