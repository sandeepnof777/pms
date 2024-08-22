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

</style>
 
    <div id="content" class="clearfix">
        <div class="widthfix">
            <?php echo form_open($this->uri->segment(1) . '/edit/' . $this->uri->segment(3), array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
            <div class="content-box">
                <div class="box-header">
                    Edit Contact - <?php echo $client->getFullName(); ?> - <?php echo $client->getClientAccount()->getName(); ?>
                    <a class="box-action" href="<?php echo ($this->uri->segment(4)) ? site_url('proposals/edit/' . $this->uri->segment(4)) : site_url('clients') ?>">Back</a>
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
                                <tr>
                                    <td colspan="2">
                                        <h3>Contact Details</h3>
                                    </td>
                                </tr>
                                <tr  class="even">
                                    <td>
                                        <label>Account Name</label>
                                        <input class="text capitalize" type="text" name="accCompanyName"
                                               id="accCompanyName" value="<?php echo $client->getClientAccount()->getName(); ?>"
                                               tabindex="2" placeholder="Leave Blank for Residential">
                                        <input type="hidden" name="accountId" id="accountId"
                                               value="<?php echo $client->getClientAccount()->getId(); ?>"
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Zip <span>*</span></label>
                                            <input tabindex="17" class="text required tiptiptop" title="Please type the zip code"
                                                   type="text" name="zip" id="zip" value="<?php echo $client->getZip() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <p class="clearfix">
                                            <label>First Name <span>*</span></label>
                                            <input tabindex="10" class="text required tiptip capitalize"
                                                   title="Please type the first name" type="text" name="firstName"
                                                   id="firstName"
                                                   value="<?php echo ($this->input->post('firstName')) ? $this->input->post('firstName') : $client->getFirstName() ?>">
                                        </p>
                                    </td>
                                    <td width="50%">
                                        <p class="clearfix left">
                                            <label>Business Phone </label>
                                            <input tabindex="18" class="text tiptiptop" style="width: 100px;"
                                                   title="Please type the business phone" type="text" name="businessPhone"
                                                   id="businessPhone"
                                                   value="<?php echo ($this->input->post('businessPhone')) ? $this->input->post('businessPhone') : $client->getBusinessPhone() ?>">
                                            &nbsp;&nbsp;&nbsp;<input tabindex="19" class="text tiptiptop" style="width: 50px;"
                                                                     placeholder="Ext"
                                                                     title="Please type the business phone extension"
                                                                     type="text" name="businessPhoneExt" id="businessPhoneExt"
                                                                     value="<?php echo ($this->input->post('businessPhoneExt')) ? $this->input->post('businessPhoneExt') : $client->getBusinessPhoneExt() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Last Name <span>*</span></label>
                                            <input tabindex="11" class="text required tiptip capitalize"
                                                   title="Please type the last name" type="text" name="lastName" id="lastName"
                                                   value="<?php echo $client->getLastName() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Cell Phone</label>
                                            <input tabindex="20" class="text tiptiptop" title="Please type the cell phone"
                                                   type="text" name="cellPhone" id="cellPhone"
                                                   value="<?php echo $client->getCellPhone() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Title</label>
                                            <input tabindex="12" class="text tiptip" title="Please type the title" type="text"
                                                   name="title" id="title" value="<?php echo $client->getTitle() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Fax</label>
                                            <input tabindex="21" class="text tiptiptop" title="Please type the fax number"
                                                   type="text" name="fax" id="fax" value="<?php echo $client->getFax() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Address <span>*</span></label>
                                            <input tabindex="13" class="text required tiptip" title="Please type the address"
                                                   type="text" name="address" id="address"
                                                   value="<?php echo $client->getAddress() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Email <span>*</span></label>
                                            <input tabindex="22" class="text required email tiptiptop"
                                                   title="Please type the email" type="text" name="email" id="email"
                                                   value="<?php echo $client->getEmail() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>City <span>*</span></label>
                                            <input tabindex="14" class="text required tiptip" title="Please type the city"
                                                   type="text" name="city" id="city" value="<?php echo $client->getCity() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Website</label>
                                            <input tabindex="23" class="text tiptiptop" title="Please type the website" type="text"
                                                   name="website" id="website" value="<?php echo $client->getWebsite() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>State <span>*</span></label>
                                            <input tabindex="15" class="text required tiptip" title="Please type the state"
                                                   type="text" name="state" id="state"
                                                   value="<?php echo $client->getState() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <div>
                                        <label>Business Type <span>*</span></label>
                                                <select tabindex="24" class="dont-uniform businessTypeMultiple required"  style="width: 64%" name="business_type[]" multiple="multiple">
                                        <?php 
                                                foreach($businessTypes as $businessType){
                                                    if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected';}else{ $selected = '';}
                                                    if(in_array($businessType->getId(), $disableBusinessTypes)){ $disabled = 'disabled="disabled"';}else{ $disabled = '';}
                                                    echo '<option  value="'.$businessType->getId().'"  '.$selected.' '.$disabled.' >'.$businessType->getTypeName().'</option>';
                                                }
                                                $proposal_select_display = (count($assignedBusinessTypes)>1)?'block':'none';
                                        ?>
                                        </select>
                                        </div>

                                        <div style="padding-left: 148px;padding-top: 8px;padding-bottom: 8px;float: left;"><input type="checkbox" tabindex="25" value="1"  name="apply_bt_on_contact" id="apply_bt_on_contact"><span style="padding-top: 4px;float: left;">Edit all Proposals Business Types</span></div>
                                        <div style="display: none;float:left" class="bt_on_proposal_p" ><label style="margin-right: 8px;">Proposal Type <span>*</span></label>
                                            <select tabindex="26" name="apply_bt_on_proposal"  id="apply_bt_on_proposal"> 
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

                                <?php
                                if ($account->isAdministrator()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <p class="clearfix left">
                                                <label>Owner</label>
                                                <?php
                                                $options = array();
                                                $accounts = $client->getCompany()->getAccounts();
                                                foreach ($accounts as $acc) {
                                                    if (!$acc->isSecretary()) {
                                                        $options[$acc->getAccountId()] = $acc->getFullName();
                                                    }
                                                }
                                                $selected = array($client->getAccount()->getAccountId());
                                                $params = ' style="margin-top: 5px;"';
                                                echo form_dropdown('owner', $options, $selected, ' tabindex="16"');
                                                ?>
                                            </p>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                <?php } ?>

                                

                                <!--Billing details-->
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
                                            <input tabindex="27" class="text required capitalize" type="text" name="billingFirstName"
                                                   id="billingFirstName"
                                                   value="<?php echo $client->getBillingFirstName() ?>">
                                        </p>
                                    </td>
                                    <td width="50%">
                                        <p class="clearfix left">
                                            <label>Zip <span>*</span></label>
                                            <input tabindex="33" class="text required" type="text" name="billingZip" id="billingZip"
                                                   value="<?php echo $client->getBillingZip() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Last Name <span>*</span></label>
                                            <input tabindex="28" class="text required capitalize" type="text" name="billingLastName"
                                                   id="billingLastName"
                                                   value="<?php echo $client->getBillingLastName() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Business Phone</label>
                                            <input tabindex="34" class="text" style="width: 100px;" type="text"
                                                   name="billingBusinessPhone" id="billingBusinessPhone"
                                                   value="<?php echo $client->getBillingBusinessPhone() ?>">
                                            &nbsp;&nbsp;&nbsp;<input tabindex="35" class="text tiptiptop" style="width: 50px;"
                                                                     placeholder="Ext"
                                                                     title="Please type the business phone extension"
                                                                     type="text" name="billingBusinessPhoneExt" id="billingBusinessPhoneExt"
                                                                     value="<?php echo $client->getBillingBusinessPhoneExt() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Title</label>
                                            <input tabindex="29" class="text" type="text" name="billingTitle" id="billingTitle"
                                                   value="<?php echo $client->getBillingTitle() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Cell Phone</label>
                                            <input tabindex="36" class="text" type="text" name="billingCellPhone" id="billingCellPhone"
                                                   value="<?php echo $client->getBillingCellPhone() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Address <span>*</span></label>
                                            <input tabindex="30" class="text required" type="text" name="billingAddress" id="billingAddress"
                                                   value="<?php echo $client->getBillingAddress() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Fax</label>
                                            <input tabindex="37" class="text" type="text" name="billingFax" id="billingFax"
                                                   value="<?php echo $client->getBillingFax() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>City <span>*</span></label>
                                            <input tabindex="31" class="text required" type="text" name="billingCity" id="billingCity"
                                                   value="<?php echo $client->getBillingCity() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Email <span>*</span></label>
                                            <input tabindex="38" class="text required email" type="text" name="billingEmail" id="billingEmail"
                                                   value="<?php echo $client->getBillingEmail() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>State <span>*</span></label>
                                            <input tabindex="32" class="text required" type="text" name="billingState" id="billingState"
                                                   value="<?php echo $client->getBillingState() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>

                                        <?php if ($qbPermission) {
?>
                                            <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <?php
                                            if ($qbLinked) {
                                                ?>
                                    <td>
                                        <?php
                                        if ($account->isAdministrator()) {
                                            ?>

                                            <p class="clearfix left">
                                                <label>Owner</label>
                                                <?php
                                                $options = array();
                                                $accounts = $client->getCompany()->getAccounts();
                                                foreach ($accounts as $acc) {
                                                    if (!$acc->isSecretary()) {
                                                        $options[$acc->getAccountId()] = $acc->getFullName();
                                                    }
                                                }
                                                $selected = array($client->getAccount()->getAccountId());
                                                $params = ' style="margin-top: 5px;"';
                                                echo form_dropdown('owner', $options, $selected, ' tabindex="23"');
                                                ?>
                                            </p>
                                        <?php } ?>
                                    </td>
                                </tr>


                                <!--Billing details-->
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
                                            <input tabindex="110" class="text required capitalize" type="text" name="billingFirstName"
                                                   id="billingFirstName"
                                                   value="<?php echo $client->getBillingFirstName() ?>">
                                        </p>
                                    </td>
                                    <td width="50%">
                                        <p class="clearfix left">
                                            <label>Zip <span>*</span></label>
                                            <input tabindex="116" class="text required" type="text" name="billingZip" id="billingZip"
                                                   value="<?php echo $client->getBillingZip() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Last Name <span>*</span></label>
                                            <input tabindex="111" class="text required capitalize" type="text" name="billingLastName"
                                                   id="billingLastName"
                                                   value="<?php echo $client->getBillingLastName() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Business Phone</label>
                                            <input tabindex="123" class="text" style="width: 100px;" type="text"
                                                   name="billingBusinessPhone" id="billingBusinessPhone"
                                                   value="<?php echo $client->getBillingBusinessPhone() ?>">
                                            &nbsp;&nbsp;&nbsp;<input tabindex="124" class="text tiptip" style="width: 50px;"
                                                                     placeholder="Ext"
                                                                     title="Please type the business phone extension"
                                                                     type="text" name="billingBusinessPhoneExt" id="billingBusinessPhoneExt"
                                                                     value="<?php echo $client->getBillingBusinessPhoneExt() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Title</label>
                                            <input tabindex="112" class="text" type="text" name="billingTitle" id="billingTitle"
                                                   value="<?php echo $client->getBillingTitle() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Cell Phone</label>
                                            <input tabindex="118" class="text" type="text" name="billingCellPhone" id="billingCellPhone"
                                                   value="<?php echo $client->getBillingCellPhone() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>Address <span>*</span></label>
                                            <input tabindex="113" class="text required" type="text" name="billingAddress" id="billingAddress"
                                                   value="<?php echo $client->getBillingAddress() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Fax</label>
                                            <input tabindex="119" class="text" type="text" name="billingFax" id="billingFax"
                                                   value="<?php echo $client->getBillingFax() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="clearfix left">
                                            <label>City <span>*</span></label>
                                            <input tabindex="114" class="text required" type="text" name="billingCity" id="billingCity"
                                                   value="<?php echo $client->getBillingCity() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        <p class="clearfix left">
                                            <label>Email <span>*</span></label>
                                            <input tabindex="120" class="text required email" type="text" name="billingEmail" id="billingEmail"
                                                   value="<?php echo $client->getBillingEmail() ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <p class="clearfix left">
                                            <label>State <span>*</span></label>
                                            <input tabindex="115" class="text required" type="text" name="billingState" id="billingState"
                                                   value="<?php echo $client->getBillingState() ?>">
                                        </p>
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                        </td>
                        <td>
                            <?php if ($qbPermission) {

                                if ($qbLinked) {
                                    ?>

                                    <span id="clientQbSyncStatus">

                                    <label>QB Sync Status</label>

                                        <?php
                                    if ($qbSynced) {
                                        ?>

                                        <div>
                                                <img src="/3rdparty/icons/bullet_green.png"/> Synced
                                            </div>

                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="/3rdparty/icons/bullet_orange.png"/> Out of Sync <a class="btn"
                                                                                                                  style="margin-left: 10px;"
                                                                                                                  href="<?php echo site_url('quickbooks/quickbooksclient/' . $client->getClientId()); ?>"> Compare</a>
                                                    <?php
                                                }
                                            } ?>
                                            </span>
                                    </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } else {
                                        ?>
                                        <img src="/3rdparty/icons/bullet_orange.png"/> Out of Sync <a class="btn"
                                                                                                      style="margin-left: 10px;"
                                                                                                      href="<?php echo site_url('quickbooks/quickbooksclient/' . $client->getClientId()); ?>"> Compare</a>
                                        <?php
                                    }
                                } ?>
                        </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="<?php echo $account->isAdministrator() ? 'even' : ''; ?>">
                                <p class="clearfix">
                                    <label>&nbsp;</label>
                                    <?php
                                    // Different radio/button options for QB users
                                    if ($qbPermission) {
                                        if ($qbLinked) {
                                            // This is the interface for a client that has already been linked to QB
                                            ?>
                                            <span style="float: left; padding-top: 10px; margin-right: 20px;"
                                                  id="qbEdit">

                                     Update QuickBooks?&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="radio" name="updateQb" value="1" class="qbRadio"> Yes
                                     <input type="radio" name="updateQb" value="0" class="qbRadio"> No

                                     </span>
                                                    <?php
                                                } else {
                                                    // Client has not been linked to QB
                                                    ?>
                                                    <span style="float: left; padding-top: 10px; margin-right: 20px;"
                                                          id="qbEdit">

                                     Add to QuickBooks?&nbsp;&nbsp;&nbsp;&nbsp;
                                     <input type="radio" name="addToQb" value="1" class="qbRadio"> Yes
                                     <input type="radio" name="addToQb" value="0" class="qbRadio"> No

                                     </span>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <input tabindex="39" type="button" value="Save Contact" id="editClientSave"
                                                   class="btn update-button ui-button">
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--Scheduled Events tab-->
                        <div id="tabs-2" class="clearfix" style="padding: 0 !important;">
                            <div class="clearfix">
                                <h3 class="padded left" style="margin: 0;">Upcoming Events</h3>
                                <a href="#" class="btn small right scheduleClientCall" style="margin: 10px;" data-client="<?= $client->getClientId() ?>" data-account="<?= $client->getAccount()->getAccountId(); ?>"
                                   data-contactname="<?= $client->getFirstName() . ' ' . $client->getLastName() ?>" data-phone="<?= $client->getBusinessPhone(true) ?>"
                                   data-redirect="clients/edit/<?= $client->getClientId() ?>/schedule">Add Event</a>
                            </div>
                            <?php $this->load->view('templates/events/table'); ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php echo form_close() ?>
            <script type="text/javascript">
            var disable_business_types = [<?=(implode(',',$disableBusinessTypes));?>];
                $(document).ready(function () {

$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
    var oldRemoveChoice = Search.prototype.searchRemoveChoice;
    
    Search.prototype.searchRemoveChoice = function (e) {
 
 var check_id = arguments[1].id;

        var checked = $('#apply_bt_on_contact').is(':checked');
        var disabled = $(".businessTypeMultiple option[value='"+check_id+"']").prop('disabled');
         if(disabled && !checked){
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
                                tag.title = 'This business type can not be deleted</br>Because a proposal for this contact has this Business Type';
                                tag.locked = true;
                            }else{
                                tag.title = tag.text;
                            }
                            return tag.text;
                        },
                    });
});

                    var opt = $('.businessTypeMultiple option:disabled').map(function(i,v) {
                        return this.value;
                    }).get();
                   
                    if(opt.length){
                        $('.businessTypeMultiple').removeClass('required');
                    }else{
                       // $('.businessTypeMultiple').addClass('required');
                    }
                    $(".tag_tiptip").tipTip({defaultPosition:'left'});
                    $("#tabs").tabs();
                    <?php if ($this->uri->segment(4) == 'schedule'): ?>
                    $('#tabs').tabs('select', "tabs-2");
                    <?php endif; ?>

                    $('.validate').validate({});
                    $("#businessPhone, #accBusinessPhone, #cellPhone, #fax, #billingBusinessPhone, #billingCellPhone, #billingFax").mask("999-999-9999");



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
                            $("#accCompanyName").val(ui.item.accountName);
                            $("#accountId").val(ui.item.value);
                            if($("#address").val() =='' && $("#city").val() =='' && $("#state").val() =='' && $("#zip").val() ==''){
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

                    // Watch for changes to highlight QB option
                    if ($('#qbEdit').length > 0) {

                        $(":input").on('input propertychange', function () {
                            $('#clientQbSyncStatus').hide();
                        });
                    }

                    // Enable the button if no QB
                    if ($('#qbEdit').length) {
                        $('#editClientSave').button("option", "disabled", true);
                    }

                    // Enable the save button when radio selected
                    $('input.qbRadio').click(function () {
                        $('#editClientSave').button("option", "disabled", false);
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
                    $('span.tiptip').tipTip({
                        defaultPosition: "top",
                        delay: 0,
                        maxWidth: '400px'
                    });

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
                                    $("#apply_bt_on_proposal").val('');
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
     $(document).on("click","#editClientSave",function(e) {
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
                    $.get("<?php echo site_url('ajax/getClientProposalCount') ?>/"+<?=$client->getClientId();?>, function(proposal_count){
                    var bt_value = $('.businessTypeMultiple option:selected').map(function(i,v) {
                                        return this.value;
                                    }).get();
                    if(bt_value && bt_value.length > 1){
                        
                        var btName = $( "#apply_bt_on_proposal option:selected" ).text();
                    }else{
                        var btName = $( ".businessTypeMultiple option:selected" ).text();
                    }
                    var cName =$('#firstName').val()+' '+$('#lastName').val();
                    var acName =$('#accCompanyName').val();
                   var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>"+
                                    "<table style='text-align: left;line-height: 25px;width:100%'><tr><th style='text-align: right;width:30%'>Contact Name:</th><td style='padding-left:10px'>"+cName+"</td></tr>"+
                                    "<tr><th style='text-align: right;'>Account:</th><td style='padding-left:10px'>"+acName+"</td></tr>"+
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
                            return false;
                        }
                    });
                });
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
            }else{
                $('.form-validated').submit();
            }
        
     });
            </script>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>