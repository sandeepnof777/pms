<?php $this->load->view('global/header'); ?>
<style>
.select2-selection__rendered{
    float: left!important;
}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
.select_box_error {
    border-radius: 2px;
    border: 1px solid #e47074 !important;
    background-color: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
.select2_box_error{  padding:2px;border-radius: 2px;border: 1px solid #e47074 !important;background-color: #ffedad !important;box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;-moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;}
</style>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                    You are now converting a lead to a proposal. Good Luck!!
                    <a class="tiptip box-action" href="<?php echo site_url('leads') ?>" title="Back to Leads" style="margin-left: 10px;">Back</a>
                </div>
                <div class="box-content">
                    <form class="form-validated" action="<?php echo site_url('leads/convert/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0" class="boxed-table">
                            <thead>
                            <tr>
                                <td colspan="2">
                                    <h4 style="text-align: left;">Contact Information
                                        <?php if ($client) {
                                            echo ' - Selected Existing Contact - ' . $client->getCompanyName() . ' (' . $client->getFullName() . ')';
                                            ?>
                                            <input type="hidden" name="clientId" value="<?php echo $client->getClientId() ?>"/>
                                        <?php
                                        } ?></h4>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (!$client) {
                                if (isset($clients) && count($clients)) {
                                    ?>
                                    <tr class="even">
                                        <td colspan="2">
                                            <span style="color: red;"><b>Warning:</b> Contact may already be in the database - pick from the following if it applies: </span> <?php
                                            foreach ($clients as $client) {
                                                ?><a class="tiptip" href="<?php echo site_url('leads/convert/' . $this->uri->segment(3) . '/' . $client->getClientId()) ?>" title="Click to use <?php echo $client->getCompanyName() . ' (' . $client->getFirstName() . ' ' . $client->getLastName() . ')' ?> existing client"><?php echo $client->getCompanyName(). ' (' . $client->getFirstName() . ' ' . $client->getLastName() . ')' ?></a>  &nbsp;  <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <h3>Contact Details</h3>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td>
                                        <label>Company Name <span>*</span></label>
                                        <input class="text required capitalize" type="text" name="accCompanyName" id="accCompanyName" value="<?php echo $lead->getCompanyName(); ?>">
                                        <input type="hidden" name="accountId" id="accountId" value="<?php echo ($lead->getClient() && $client) ? $client->getClientAccount()->getId() : ''; ?>"/>
                                    </td>
                                    <td>
                                        <label>Zip <span>*</span></label>
                                        <input class="text required" type="text" name="zip" id="zip" tabindex="58" value="<?php echo $lead->getZip() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>First Name <span>*</span></label>
                                        <input class="text required" type="text" name="firstName" id="firstName" tabindex="8" value="<?php echo $lead->getFirstName() ?>">
                                    </td>
                                    <td>
                                        <label>Business Phone <span>*</span></label>
                                        <input class="text required" style="width: 100px;" type="text" name="businessPhone" id="businessPhone" tabindex="60" value="<?php echo $lead->getBusinessPhone() ?>">
                                        &nbsp;&nbsp;&nbsp;<input tabindex="23"class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension" type="text" name="businessPhoneExt" id="businessPhoneExt" value="<?php echo $lead->getBusinessPhoneExt(); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Last Name <span>*</span></label>
                                        <input class="text required" type="text" name="lastName" id="lastName" tabindex="10" value="<?php echo $lead->getLastName() ?>">
                                    </td>
                                    <td>
                                        <label>Cell Phone <span>*</span></label>
                                        <input class="text required" type="text" name="cellPhone" id="cellPhone" tabindex="62" value="<?php echo $lead->getCellPhone() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Title <span>*</span></label>
                                        <input class="text required" type="text" name="title" id="title" tabindex="12" value="<?php echo $lead->getTitle() ?>">
                                    </td>
                                    <td>
                                        <label>Fax</label>
                                        <input class="text" type="text" name="fax" id="fax" tabindex="63" value="<?php echo $lead->getFax() ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Address <span>*</span></label>
                                        <input class="text required" type="text" name="address" id="address" tabindex="14" value="<?php echo $lead->getAddress() ?>">
                                    </td>
                                    <td>
                                        <label>Email <span>*</span></label>
                                        <input class="text required email" type="text" name="email" id="email" tabindex="64" value="<?php echo $lead->getEmail() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>City <span>*</span></label>
                                        <input class="text required" type="text" name="city" id="city" tabindex="16" value="<?php echo $lead->getCity() ?>">
                                    </td>
                                    <td>
                                        <label>Website</label>
                                        <input class="text" type="text" name="website" id="website" tabindex="66" value="<?php echo $lead->getWebsite() ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>State <span>*</span></label>
                                        <input class="text required" type="text" name="state" id="state" tabindex="17" value="<?php echo $lead->getState() ?>">
                                    </td>
                                    <td><label>Business Type <span>*</span></label>
                                        <select  class="dont-uniform contactBusinessTypeMultiple required" id="contact_business_type" style="width: 64%;"   name="contact_business_type[]" multiple >
                                                <option value="">Please Select</option>
                                    <?php 
                                            foreach($businessTypes as $businessType){
                                                if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected="selected"';}else{ $selected = '';}
                                                echo '<option value="'.$businessType->getId().'" '.$selected.'>'.$businessType->getTypeName().'</option>';
                                            }
                                    ?>
                                    </select></td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <thead>
                            <tr>
                                <td colspan="2">
                                    <h4 style="text-align: left;">Project Information</h4>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="even">
                                <td>
                                    <label>Proposal Title <span>*</span></label>
                                    <input class="text required" type="text" name="projectTitle" id="projectTitle" value="Pavement Maintenance Proposal">
                                </td>
                                <td>
                                    <a class="btn" href="#" id="titleChoices">View Choices</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Project Name <span>*</span></label>
                                    <input class="text required" type="text" name="projectName" id="projectName" tabindex="18" value="<?php echo $lead->getProjectName() ?>">
                                </td>
                                <td>
                                    <label>State <span>*</span></label>
                                    <input class="text required" type="text" name="projectState" id="projectState" tabindex="68" value="<?php echo $lead->getProjectState() ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Address <span>*</span></label>
                                    <input class="text required" type="text" name="projectAddress" id="projectAddress" tabindex="20" value="<?php echo $lead->getProjectAddress() ?>">
                                </td>
                                <td>
                                    <label>Zip <span>*</span></label>
                                    <input class="text required" type="text" name="projectZip" id="projectZip" tabindex="70" value="<?php echo $lead->getProjectZip() ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>City <span>*</span></label>
                                    <input class="text required" type="text" name="projectCity" id="projectCity" tabindex="22" value="<?php echo $lead->getProjectCity() ?>">
                                </td>
                                <td>
                                    <label>Business Phone <span>*</span></label>
                                    <input class="text required" style="width: 100px;" type="text" name="projectPhone" id="projectPhone" tabindex="72" value="<?php echo $lead->getProjectPhone() ?>">
                                    &nbsp;&nbsp;&nbsp;<input tabindex="23"class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension" type="text" name="businessPhoneExt" id="businessPhoneExt" value="<?php echo $lead->getBusinessPhoneExt(); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Proposal Owner</label>
                                    <select name="owner" id="owner">
                                        <?php
                                        $selectId = $lead->getAccount() ?: $account->getAccountId();
                                        foreach ($userAccounts as $userAccount) {
                                            if (!$userAccount->getSecretary()) {
                                                ?>
                                                <option
                                                    value="<?php echo $userAccount->getAccountId() ?>"<?php if ($userAccount->getAccountId() == $selectId) { echo ' selected';} ?>><?php echo $userAccount->getFullName() ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><label>Business Type <span>*</span></label>
                                <select  class=" businessTypeMultiple required" id="business_type"   name="business_type" >
                                        <option value="">Please Select</option>
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected="selected"';}else{ $selected = '';}
                                        echo '<option value="'.$businessType->getId().'" '.$selected.'>'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>&nbsp&nbsp;</label>
                                    <input class="btn submit_form" type="submit" value="Continue" name="continue">
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.contactBusinessTypeMultiple').select2({
                        placeholder: "Select one or many "
                    });
                    var accounts = [];

                    <?php
                    foreach ($clientAccounts as $clientAccount) {
                    /* @var $clientAccount \models\ClientCompany */
                    $accountData = new stdClass();
                    $accountData->value = $clientAccount->getId();
                    $accountData->accountName = $clientAccount->getName();
                    $accountData->label = $clientAccount->getName();
                    $accountData->address = $clientAccount->getAddress();
                    $accountData->city = $clientAccount->getCity();
                    $accountData->state = $clientAccount->getState();
                    $accountData->zip = $clientAccount->getZip();
                    $accountData->businessPhone = $clientAccount->getPhone();
                    $accountData->website = $clientAccount->getWebsite();
                    ?>
                    var accountData = <?php echo json_encode($accountData); ?>;
                    accounts.push(accountData);
                    <?php
                    }
                    ?>


                    $("#accCompanyName").autocomplete({
                        minLength: 0,
                        source: accounts,
                        focus: function (event, ui) {
                            $("#accCompanyName").val(ui.item.accountName);
                            return false;
                        },
                        select: function (event, ui) {
                            $("#accCompanyName").val(ui.item.accountName);
                            $("#accountId").val(ui.item.value);
                            //$("#address").val(ui.item.address);
                            //$("#city").val(ui.item.city);
                            //$("#state").val(ui.item.state);
                            //$("#zip").val(ui.item.state);
                            //$("#businessPhone").val(ui.item.businessPhone);
                            //$("#website").val(ui.item.website);
                            return false;
                        }
                    });


                    if (!$("#accountId").val()) {
                        $("#accCompanyName").autocomplete('search', $("#accCompanyName").val());
                    }

                    $("#accCompanyName").keyup(function () {
                        $("#accountId").val('');
                    });

                    $("#titleChoices").click(function () {
                        $("#choices").dialog('open');
                        return false;
                    });
                    $(".choice").click(function () {
                        var id = $(this).attr('rel');
                        var text = $(id).html();
                        $("#projectTitle").val(text);
                        $("#choices").dialog('close');
                    });
                    $("#choices").dialog({
                        modal: true,
                        autoOpen: false,
                        width: 450,
                        buttons: {
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        }
                    });

                    $("#client_account").change(function() {
                        toggleNewAccountFields();
                    });

                    function toggleNewAccountFields() {
                        var selectedVal = $("#client_account").val();

                        if (selectedVal == 0) {
                            $(".newAccount").show();
                            $("#accCompanyName").addClass('required');
                        }
                        else {
                            $(".newAccount").hide();
                            $("#accCompanyName").removeClass('required');
                        }
                    }
                });

                $(document).on("change","#contact_business_type",function(e) {
         
                    if($(this).val()){
                        $(this).closest('td').find('.select2-container ').removeClass('select2_box_error');
                    }else{
                         $(this).closest('td').find('.select2-container ').addClass('select2_box_error');
                    }
                    
                });

                $(document).on("change","#business_type",function(e) {
         
                    if($(this).val()){
                        $(this).closest('div').removeClass('select_box_error');
                    }else{
                        $(this).closest('div').addClass('select_box_error');
                    }
                    
                });

                $(document).on("click",".submit_form",function(e) {
                    if($('#contact_business_type').val()){
                        $('#contact_business_type').closest('td').find('.select2-container ').removeClass('select2_box_error');
                    }else{
                        $('#contact_business_type').closest('td').find('.select2-container ').addClass('select2_box_error');
                    }

                    if($('#business_type').val()){
                        $('#business_type').closest('div').removeClass('select_box_error');
                    }else{
                        $('#business_type').closest('div').addClass('select_box_error');
                    }
                    
                });
            </script>
            <div class="javascript_loaded">

                <div id="choices" title="Choices">
                    <p class="clearfix"><span id="choice-1">Pavement Maintenance Proposal</span> <a class="btn choice" href="#" rel="#choice-1">Select</a></p>

                    <p class="clearfix"><span id="choice-2">Pavement Maintenance Plan</span> <a class="btn choice" href="#" rel="#choice-2">Select</a></p>

                    <p class="clearfix"><span id="choice-3">Your Parking Lot Proposal</span> <a class="btn choice" href="#" rel="#choice-3">Select</a></p>

                    <p class="clearfix"><span id="choice-4">Pavement Repair Plan</span> <a class="btn choice" href="#" rel="#choice-4">Select</a></p>

                    <p class="clearfix"><span id="choice-5">Pavement Maintenance & Beautification Proposal</span> <a class="btn choice" href="#" rel="#choice-5">Select</a></p>
                </div>
            </div>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>