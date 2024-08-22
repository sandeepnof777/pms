<?php $this->load->view('global/header'); ?>
<?php /* @var \models\Prospects $prospect */ ?>
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
        <?php echo form_open($this->uri->segment(1) . '/edit/' . $this->uri->segment(3), array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
        <div class="content-box">
            <div class="box-header">
                Edit Prospect
                <a class="box-action" href="<?php echo site_url('prospects') ?>">Back</a>
            </div>
            <div class="box-content">
                <div id="tabs" style="border-radius: 0;" class="clearfix">
                    <ul>
                        <li><a href="#tabs-1">Basic Info</a></li>
                        <li><a href="#tabs-2">Scheduled Events</a></li>
                    </ul>
                    <div id="tabs-1" style="padding: 0 !important;">
                        <table cellpadding="0" cellspacing="0" width="100%" class="boxed-table">
                            <tbody>
                            <?php
                            if ($account->isAdministrator()) {
                                ?>
                                <tr class="even">
                                    <td>
                                        <label>Owner</label>
                                        <?php
                                        echo form_dropdown('account', $accounts, $prospect->getAccount(), 'id="account" tabindex="1"');
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
                                        <input tabindex="1" class="text tiptip" title="Please type the company name" type="text" name="companyName" id="companyName" value="<?php echo $prospect->getCompanyName() ?>" placeholder="Leave blank for Residential">
                                    </p>

                                </td>
                                <td width="50%">
                                    <p class="clearfix left">
                                        <label>Zip</label>
                                        <input tabindex="21" class="text tiptip" title="Please type the zip code" type="text" name="zip" id="zip" value="<?php echo $prospect->getZip() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label>First Name</label>
                                        <input tabindex="2" class="text tiptip capitalize" title="Please type the first name" type="text" name="firstName" id="firstName" value="<?php echo ($this->input->post('firstName')) ? $this->input->post('firstName') : $prospect->getFirstName() ?>">
                                    </p>
                                </td>
                                <td>
                                    <p class="clearfix left">
                                        <label>Business Phone </label>
                                        <input tabindex="23" class="text tiptip formatPhone" style="width: 100px" title="Please type the business phone" type="text" name="businessPhone" id="businessPhone" value="<?php echo ($this->input->post('businessPhone')) ? $this->input->post('businessPhone') : $prospect->getBusinessPhone() ?>">
                                        &nbsp;&nbsp;&nbsp;<input tabindex="23"class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension" type="text" name="businessPhoneExt" id="businessPhoneExt" value="<?php echo ($this->input->post('businessPhoneExt')) ? $this->input->post('businessPhoneExt') : $prospect->getBusinessPhoneExt() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix left">
                                        <label>Last Name</label>
                                        <input tabindex="3" class="text tiptip capitalize" title="Please type the last name" type="text" name="lastName" id="lastName" value="<?php echo $prospect->getLastName() ?>">
                                    </p>
                                </td>
                                <td>
                                    <p class="clearfix left">
                                        <label>Cell Phone</label>
                                        <input tabindex="24" class="text tiptip formatPhone" title="Please type the cell phone" type="text" name="cellPhone" id="cellPhone" value="<?php echo $prospect->getCellPhone() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix left">
                                        <label>Title</label>
                                        <input tabindex="4" class="text tiptip" title="Please type the title" type="text" name="title" id="title" value="<?php echo $prospect->getTitle() ?>">
                                    </p>
                                </td>
                                <td>
                                    <p class="clearfix left">
                                        <label>Fax</label>
                                        <input tabindex="25" class="text tiptip formatPhone" title="Please type the fax number" type="text" name="fax" id="fax" value="<?php echo $prospect->getFax() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix left">
                                        <label>Address</label>
                                        <input tabindex="5" class="text tiptip" title="Please type the address" type="text" name="address" id="address" value="<?php echo $prospect->getAddress() ?>">
                                    </p>
                                </td>
                                <td>
                                    <p class="clearfix left">
                                        <label>Email</label>
                                        <input tabindex="26" class="text email tiptip" title="Please type the email" type="text" name="email" id="email" value="<?php echo $prospect->getEmail() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix left">
                                        <label>City</label>
                                        <input tabindex="6" class="text tiptip" title="Please type the city" type="text" name="city" id="city" value="<?php echo $prospect->getCity() ?>">
                                    </p>
                                </td>
                                <td>
                                    <p class="clearfix left">
                                        <label>Website</label>
                                        <input tabindex="27" class="text tiptip" title="Please type the website" type="text" name="website" id="website" value="<?php echo $prospect->getWebsite() ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix left">
                                        <label>State</label>
                                        <input tabindex="7" class="text tiptip" title="Please type the state" type="text" name="state" id="state" value="<?php echo $prospect->getState() ?>">
                                    </p>
                                </td>
                                <td>
                                    <label>Business Type</label>
                                    <select  class="dont-uniform businessTypeMultiple"  style="width: 64%" name="business_type[]" multiple="multiple">
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected="selected"';}else{ $selected = '';}
                                        echo '<option value="'.$businessType->getId().'"  '.$selected.' >'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select>
                                    <?php //echo form_dropdown('business', $businesses, $prospect->getBusiness(), 'id="status" tabindex="28"') ?>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Status</label>
                                    <?php echo form_dropdown('status', $statuses, $prospect->getStatus(), 'id="status" tabindex="8"') ?>
                                </td>
                                <td>
                                    <label>Rating</label>
                                    <?php echo form_dropdown('rating', $ratings, $prospect->getRating(), 'id="rating" tabindex="9"') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Source</label>
                                    <?php echo form_dropdown('source', $sources, $prospect->getProspectSourceId(), 'id="source" tabindex="8"') ?>
                                </td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="<?php /*if ($account->isAdministrator()) {
                            echo 'even';
                        } */?>">
                                    <p class="clearfix">
                                        <label>&nbsp;</label><input tabindex="30" name="save" type="submit" value="Save" class="btn">
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="tabs-2" class="clearfix" style="padding: 0 !important;">
                        <div class="clearfix">
                            <h3 class="padded left" style="margin: 0;">Upcoming Events</h3>
                            <a href="#" class="btn small right scheduleProspectCall" style="margin: 10px;" data-prospect="<?= $prospect->getProspectId() ?>" data-account="<?= $prospect->getAccount() ?>"
                               data-prospectname="<?= $prospect->getFirstName() . ' ' . $prospect->getLastName() ?>" data-phone="<?= $prospect->getBusinessPhone() ?>"
                               data-redirect="prospects/edit/<?= $prospect->getProspectId() ?>/schedule">Add Event</a>
                        </div>
                        <?php $this->load->view('templates/events/table'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.businessTypeMultiple').select2({
                    placeholder: "Select one or many"
                });
                $("#tabs").tabs();
                $('.validate').validate({});
                $("#businessPhone, #cellPhone, #fax").mask("999-999-9999");
            });
        </script>
    </div>
</div>
<!--#content-->
<?php $this->load->view('global/footer'); ?>