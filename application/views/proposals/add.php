<?php $this->load->view('global/header'); ?>
<style>
.select_box_error {
    border-radius: 2px;
    border: 1px solid #e47074 !important;
    background-color: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
</style>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                    Add new proposal
                    <a class="box-action" href="<?php echo site_url('proposals') ?>">Back</a>
                </div>
                <div class="box-content">
                    <?php echo form_open('proposals/add/' . $this->uri->segment(3), array('class' => 'form-validated')) ?>
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <?php if (!$this->uri->segment(3)) { ?>
                            <tbody>
                            <tr>
                                <td colspan="2">
                                    <ul id="actions" style="padding-left: 200px;">
                                        <li id="quick-add-proposal2">
                                            <a href="<?php echo site_url('clients') ?>" class="tiptip" title="Add a new proposal for an existing contact">
                                                <span class="icon"></span>
                                                <span class="label">Add Proposal - Existing Contact</span>
                                            </a>
                                        </li>
                                        <li id="quick-add-proposal" style="margin-left: 20px;">
                                            <a href="<?php echo site_url('clients/add') ?>" class="tiptip" title="Add a new contact for adding a proposal">
                                                <span class="icon"></span>
                                                <span class="label">Add Proposal - New Contact</span>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        <?php } else { ?>
                            <tr>
                                <td>
                                    <p class="clearfix">
                                        <label>Contact</label>
                                <span style="margin-top: 6px; float: left; display: block;">
                                   <?php echo $client->getFirstName() . ' ' . $client->getLastName() . ' (' . $client->getClientAccount()->getName() . ')'; ?>
                                </span>
                                        <input type="hidden" name="clientId" value="<?php echo $this->uri->segment(3) ?>">
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <p class="clearfix">
                                        <label>Business Type</label>
                                <select  class=" businessTypeMultiple required" id="business_type"  name="business_type" >
                                    <option value="">Please Select</option>
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        $selected = '';
                                        if ($defaultBusinessTypeId) {
                                            if ($businessType->getId() == $defaultBusinessTypeId) {
                                                $selected = ' selected';
                                            }
                                        }
                                        echo '<option value="'.$businessType->getId(). '"' . $selected . '>'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label>Proposal Title</label>
                                        <input type="text" name="proposalTitle" id="proposalTitle" class="text required" value="<?php echo (set_value('proposalTitle')) ? set_value('proposalTitle') : 'Pavement Maintenance Proposal'; ?>">
                                        <a class="btn" href="#" id="titleChoices">View Choices</a>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix">
                                        <label>Project Name</label>
                                        <input type="text" name="projectName" id="projectName" class="text required" value="<?php echo set_value('projectName') ?>">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix" id="textarea_validator" style="position: relative;">
                                        <label for="projectAddress">Project Address</label>
                                        <input type="text" class="text" name="projectAddress" id="projectAddress" value="<?php echo $client->getAddress() ?>"/>
                                        <span class="message info" style="position: absolute; right: 70px; top: -2px; width: 300px; padding-top: 14px;"><b>VIP:</b> Please enter the <b>JOB SITE ADDRESS HERE</b> for accurate driving directions in your work order.</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix">
                                        <label for="projectAddress">City</label>
                                        <input type="text" class="text" name="projectCity" id="projectCity" value="<?php echo $client->getCity() ?>" style="width: 130px;"/>
                                        <label for="projectAddress" style="width: 40px;">State</label>
                                        <input type="text" class="text" name="projectState" id="projectState" value="<?php echo $client->getState() ?>" style="width: 80px;"/>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label for="projectAddress">Zip</label>
                                        <input type="text" class="text" name="projectZip" id="projectZip" value="<?php echo $client->getZip() ?>" style="width: 50px;"/>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label for="owner">Proposal Owner</label>
                                        <select name="owner" id="owner">
                                            <?php foreach ($userAccounts as $userAccount) {
                                                    if (!$userAccount->getSecretary()) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $userAccount->getAccountId() ?>"<?php if ($userAccount->getAccountId() == $client->getAccount()->getAccountId()) { echo ' selected';} ?>><?php echo $userAccount->getFullName() ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix">
                                    <button class="btn blue-button submit_form" type="submit" style="float:right;margin-right: 52%;"> <i class="fa fa-fw fa-chevron-circle-right"></i> Next</button>
                                    <button class="btn" type="button" onclick="window.location.href='<?php echo site_url('clients') ?>'" > <i class="fa fa-fw fa-close"></i> Cancel</button>
                                    
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
    <div id="choices" title="Choices">
        <p class="clearfix"><span id="choice-8">Line Striping Proposal</span> <a class="btn choice" href="#" rel="#choice-8">Select</a></p>

        <p class="clearfix"><span id="choice-1">Pavement Maintenance Proposal</span> <a class="btn choice" href="#" rel="#choice-1">Select</a></p>

        <p class="clearfix"><span id="choice-2">Pavement Maintenance Plan</span> <a class="btn choice" href="#" rel="#choice-2">Select</a></p>

        <p class="clearfix"><span id="choice-5">Pavement Maintenance & Beautification Proposal</span> <a class="btn choice" href="#" rel="#choice-5">Select</a></p>

        <p class="clearfix"><span id="choice-6">Parking Lot Sweeping</span> <a class="btn choice" href="#" rel="#choice-6">Select</a></p>

        <p class="clearfix"><span id="choice-4">Pavement Repair Plan</span> <a class="btn choice" href="#" rel="#choice-4">Select</a></p>

        <p class="clearfix"><span id="choice-7">Property Drainage Proposal</span> <a class="btn choice" href="#" rel="#choice-7">Select</a></p>

        <p class="clearfix"><span id="choice-3">Your Parking Lot Proposal</span> <a class="btn choice" href="#" rel="#choice-3">Select</a></p>
    </div>
    <script type="text/javascript">
        function htmlUnescape(value) {
            return String(value)
                .replace(/&quot;/g, '"')
                .replace(/&#39;/g, "'")
                .replace(/&lt;/g, '<')
                .replace(/&gt;/g, '>')
                .replace(/&amp;/g, '&');
        }
        $(document).ready(function () {
            $("#titleChoices").click(function () {
                $("#choices").dialog('open');
                return false;
            });
            $(".choice").click(function () {
                var id = $(this).attr('rel');
                var text = $(id).html();
                $("#proposalTitle").val(htmlUnescape(text));
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
        });

        $(document).on("change","#business_type",function(e) {
         
         if($(this).val()){
             $(this).closest('div').removeClass('select_box_error');
         }else{
            
           
                $(this).closest('div').addClass('select_box_error');
          
         }
        
     });
     $(document).on("click",".submit_form",function(e) {
        if($('#business_type').val()){
             $('#business_type').closest('div').removeClass('select_box_error');
         }else{
            
                $('#business_type').closest('div').addClass('select_box_error');
   
         }
        
     });
     
    </script>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>