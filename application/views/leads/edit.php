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
</style>
    <div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Edit Lead - <?= $lead->getFullName(); ?> - <?= $lead->getCompanyName(); ?>
                <a class="tiptip box-action" href="<?php echo site_url('leads') ?>" title="Back to Leads"
                   style="margin-left: 10px;">Back</a>
                <a target="_blank" class="tiptip box-action"
                   href="<?php echo site_url('pdf/lead/' . $lead->getLeadId()) ?>" title="Print Lead"
                   style="margin-left: 10px;">Print</a>
            </div>
            <div class="box-content">
                <div id="tabs" style="border-radius: 0;" class="clearfix">
                    <ul>
                        <li><a href="#tabs-1">Basic Info</a></li>
                        <li><a href="#tabs-2">Scheduled Events</a></li>
                    </ul>
                    <div id="tabs-1" style="padding: 0 !important;">
                        <form id="editLeadForm" class="form-validated" method="post"
                              action="<?php echo site_url('leads/edit/' . $this->uri->segment(3)) ?>">
                            <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <td colspan="2">
                                        <h4 style="text-align: left;">Lead Info</h4>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="even">
                                    <td>
                                        <label>Source</label>
                                        <?php echo form_dropdown('source', $sources, $lead->getSource(), 'id="source" tabindex="1"') ?>
                                    </td>
                                    <td>
                                        <label>Due Date</label>
                                        <input class="required text" tabindex="52" type="text" name="dueDate"
                                               id="dueDate" value="<?php echo $lead->getDueDate() ?>"
                                               style="width: 70px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <label>Status</label>
                                        <?php echo form_dropdown('status', $statuses, $lead->getStatus(), 'id="statuses" tabindex="2"') ?>
                                    </td>
                                    <td>
                                        <label>Business Type <span>*</span></label>
                                        <select id="business_type"  class="businessTypeMultiple required"   name="business_type" >
                                            <option value="">Please Select</option>
                                            <?php 
                                           
                                                foreach($businessTypes as $businessType){
                                                    if(in_array($businessType->getId(), $assignedBusinessTypes)){ $selected = 'selected="selected"';}else{ $selected = '';}
                                                    echo '<option value="'.$businessType->getId().'"  '.$selected.' >'.$businessType->getTypeName().'</option>';
                                                }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Rating</label>
                                        <?php echo form_dropdown('rating', $ratings, $lead->getRating(), 'id="rating" tabindex="4"') ?>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Account Name </label>
                                        <input class="text" type="text" name="companyName" id="companyName" tabindex="6"
                                               value="<?php echo $lead->getCompanyName() ?>"
                                               placeholder="Leave Blank for Residential">
                                    </td>
                                    <td>
                                        <label>Zip</label>
                                        <input class="text" type="text" name="zip" id="zip" tabindex="18"
                                               value="<?php echo $lead->getZip() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>First Name <span>*</span></label>
                                        <input class="text required capitalize" type="text" name="firstName"
                                               id="firstName" tabindex="8" value="<?php echo $lead->getFirstName() ?>">
                                    </td>
                                    <td>
                                        <label>Business Phone</label>
                                        <input class="text" type="text" style="width: 100px;" name="businessPhone"
                                               id="businessPhone" tabindex="19"
                                               value="<?php echo $lead->getBusinessPhone() ?>">
                                        &nbsp;&nbsp;&nbsp; <input tabindex="20" class="text tiptip" style="width: 50px;"
                                                                  placeholder="Ext"
                                                                  title="Please type the business phone extension"
                                                                  type="text" name="businessPhoneExt"
                                                                  id="businessPhoneExt"
                                                                  value="<?php echo $lead->getBusinessPhoneExt(); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Last Name <span>*</span></label>
                                        <input class="text required capitalize" type="text" name="lastName"
                                               id="lastName" tabindex="10" value="<?php echo $lead->getLastName() ?>">
                                    </td>
                                    <td>
                                        <label>Cell Phone</label>
                                        <input class="text" type="text" name="cellPhone" id="cellPhone" tabindex="21"
                                               value="<?php echo $lead->getCellPhone() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Title</label>
                                        <input class="text" type="text" name="title" id="title" tabindex="12"
                                               value="<?php echo $lead->getTitle() ?>">
                                    </td>
                                    <td>
                                        <label>Fax</label>
                                        <input class="text" type="text" name="fax" id="fax" tabindex="22"
                                               value="<?php echo $lead->getFax() ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Address</label>
                                        <input class="text" type="text" name="address" id="address" tabindex="16"
                                               value="<?php echo $lead->getAddress() ?>">
                                    </td>
                                    <td>
                                        <label>Email</label>
                                        <input class="text email" type="text" name="email" id="email" tabindex="24"
                                               value="<?php echo $lead->getEmail() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>City</label>
                                        <input class="text" type="text" name="city" id="city" tabindex="16"
                                               value="<?php echo $lead->getCity() ?>">
                                    </td>
                                    <td>
                                        <label>Website</label>
                                        <input class="text" type="text" name="website" id="website" tabindex="24"
                                               value="<?php echo $lead->getWebsite() ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>State</label>
                                        <input class="text" type="text" autocomplete="off" name="state" id="state"
                                               tabindex="17" value="<?php echo $lead->getState() ?>">
                                    </td>
                                    <td>
                                        <label>&nbsp;</label>
                                    </td>
                                </tr>
                                </tbody>
                                <thead>
                                <tr>
                                    <td colspan="2">
                                        <h4 style="text-align: left;">
                                            Project Info
                                            <a class="btn" href="#" style="font-size: 12px; margin-left: 10px;"
                                               id="sameAsAbove">Same as Above</a>
                                            <span style="font-size: 12px; line-height: 16px; margin-left: 10px; color: #3F3F41;">Add location if different than above.</span>
                                        </h4>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <label>Project Name</label>
                                        <input class="text" type="text" name="projectName" id="projectName"
                                               tabindex="118" value="<?php echo $lead->getProjectName() ?>">
                                    </td>
                                    <td>
                                        <label>Address</label>
                                        <input class="text" type="text" name="projectAddress" id="projectAddress"
                                               tabindex="150" value="<?php echo $lead->getProjectAddress() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Contact Name</label>
                                        <input class="text capitalize" type="text" name="projectContact"
                                               id="projectContact" tabindex="120"
                                               value="<?php echo $lead->getProjectContact() ?>">
                                    </td>
                                    <td>
                                        <label>City</label>
                                        <input class="text" type="text" name="projectCity" id="projectCity"
                                               tabindex="152" value="<?php echo $lead->getProjectCity() ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Business Phone</label>
                                        <input class="text" type="text" style="width: 100px;" name="projectPhone"
                                               id="projectPhone" tabindex="122"
                                               value="<?php echo $lead->getProjectPhone() ?>">
                                        &nbsp;&nbsp;&nbsp;<input tabindex="123" class="text tiptip" style="width: 50px;"
                                                                 placeholder="Ext"
                                                                 title="Please type the business phone extension"
                                                                 type="text" name="projectPhoneExt" id="projectPhoneExt"
                                                                 value="<?php echo $lead->getBusinessPhoneExt(); ?>">
                                    </td>
                                    <td>
                                        <label>State</label>
                                        <input class="text" type="text" name="projectState" id="projectState"
                                               tabindex="154" value="<?php echo $lead->getProjectState() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Cell Phone</label>
                                        <input class="text" type="text" name="projectCellPhone" id="projectCellPhone"
                                               tabindex="123" value="<?php echo $lead->getProjectCellPhone(); ?>">
                                    </td>
                                    <td>
                                        <label>Zip</label>
                                        <input class="text" type="text" name="projectZip" id="projectZip" tabindex="156"
                                               value="<?php echo $lead->getProjectZip() ?>">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td colspan="2">
                                        <h4>Attachments</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" style="padding: 0;">
                                        <table width="100%" class="boxed-table">
                                            <thead>
                                            <tr>
                                                <td><h4> Upload File from computer </h4></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <p class="clearfix">
                                                        <label> File Name </label>
                                                        <input type="text" class="text tiptip"
                                                               title="Please enter a file title!" name="fileName"
                                                               id="fileName" style="width: 180px;">
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <p class="clearfix">
                                                        <label> File</label><input type="file" name="file" id="file">
                                                    </p>

                                                    <p class="clearfix">
                                                        <span style="display: block;" class="clearfix"> Note: You can upload any type of file, within a limit of 10MB.</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="clearfix">
                                                        <input type="button" value="Upload" name="uploadFile"
                                                               id="uploadFile" class="btn">
                                                    </p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                function resetAttachmentForm() {
                                                    $("#fileName").val('');
                                                    $("#uploadFile").val('Upload');
                                                    document.getElementById("file").value = "";
                                                }

                                                $(document).on('click', ".removeAttachment", function () {
                                                    var removeURL = $(this).attr('href');
                                                    swal({
                                                        title: "Are you sure?",
                                                        text: "You will not be able to recover the attachment after deletion!",
                                                        type: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#DD6B55",
                                                        confirmButtonText: "Yes, delete it!",
                                                        closeOnConfirm: false
                                                    }).then(function () {
                                                        document.location.href = removeURL;
                                                    });
                                                    return false;
                                                });

                                                $(document).on('click', ".editAttachment", function () {
                                                    var fileLink = $(this).parent().find("a.file_name");
                                                    var attachmentName = fileLink.text();
                                                    var id = $(this).data('id');
                                                    swal({
                                                        title: 'Change Attachment Name',
                                                        input: 'text',
                                                        inputValue: attachmentName,
                                                        showCancelButton: true,
                                                        inputValidator: function (value) {
                                                            return new Promise(function (resolve, reject) {
                                                                if (value) {
                                                                    resolve();
                                                                } else {
                                                                    reject('You need to write something!');
                                                                }
                                                            })
                                                        }
                                                    }).then(function (result) {
                                                        $.ajax({
                                                            url: '<?= site_url('leads/editAttachmentName') ?>/' + id,
                                                            type: 'POST',
                                                            data: {
                                                                name: result
                                                            },
                                                            dataType: "JSON",
                                                            success: function (data) {
                                                                if (data.success) {
                                                                    fileLink.text(result);
                                                                }
                                                            }
                                                        });
                                                    });
                                                    return false;
                                                });

                                                $("#uploadFile").on('click', function () {
                                                    if (!$("#fileName").val().length) {
                                                        swal('Error', 'File Name Required!', 'warning');
                                                        resetAttachmentForm();
                                                        return;
                                                    }
                                                    $("#uploadFile").val('Uploading... Please wait');
                                                    //magic
                                                    var formData = new FormData();
                                                    formData.append('attachment', $('#file')[0].files[0]);
                                                    formData.append('fileName', $("#fileName").val());

                                                    $.ajax({
                                                        url: '<?= site_url('leads/addAttachment/' . $lead->getLeadId()) ?>',
                                                        type: 'POST',
                                                        data: formData,
                                                        dataType: "JSON",
                                                        processData: false,
                                                        contentType: false,
                                                        success: function (data) {
                                                            if (data.success) {
                                                                resetAttachmentForm();
                                                                document.location.reload();
                                                            } else {
                                                                swal('Error', 'There was an error uploading your file!', 'warning');
                                                            }
                                                        }
                                                    });
                                                    return false;
                                                });
                                            });
                                        </script>
                                    </td>
                                    <td valign="top">
                                        <div id="lead-attachments">
                                            <?php
                                            if (!count($attachments)) {
                                                ?><p class="centered">No Attachments found!</p><?php
                                            }
                                            foreach ($attachments as $attachment) {
                                                ?>
                                                <p class="leadAttachment">
                                                <a class="file_name"
                                                   href="<?= site_url('uploads/leads/' . $attachment->lead_id . '/' . $attachment->file_path) ?>"
                                                   target="_blank"><?= $attachment->file_name ?></a>
                                                <a href="<?= site_url('leads/removeAttachment/' . $attachment->id . '/' . $attachment->lead_id) ?>"
                                                   class="right removeAttachment">Remove</a>
                                                <a href="#" class="right editAttachment" style="margin-right: 6px;"
                                                   data-id="<?= $attachment->id ?>">Edit</a>
                                                </p><?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td colspan="2">
                                        <h4>Requested Services</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        $k = 0;
                                        foreach ($services as $service) {
                                            $k++;
                                            ?>
                                            <label for="service_<?php echo $service->getServiceId() ?>"><?php echo $service->getServiceName() ?></label>
                                            <input <?php if (in_array($service->getServiceId(), $selectedServices)) { ?> checked="checked"<?php } ?>
                                                    tabindex="<?php echo(200 + $k) ?>" style="margin-top: 5px;"
                                                    type="checkbox"
                                                    name="services[<?php echo $service->getServiceId() ?>]"
                                                    value="<?php echo $service->getServiceId() ?>"
                                                    id="service_<?php echo $service->getServiceId() ?>">
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" name="save" value="Save"/>
                                    </td>
                                </tr>
                                <?php
                                $showPsa = false;
                                if (!$lead->getPsaAuditUrl()) {
                                    $showPsa = true;
                                }
                                ?>
                                <tr class="odd">
                                    <td colspan="2">
                                        <h4>Assign Account</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table width="100%">
                                            <tr>
                                                <td width="40%">
                                                    <?php if ($account->getUserClass() > 0) { ?>
                                                        <p class="clearfix">
                                                            <label style="width: 100px">Assigned To</label>
                                                            <select name="account" id="account" tabindex="54">
                                                                <option value="0">To Be Assigned</option>
                                                                <?php
                                                                foreach ($users as $user) {
                                                                    ?>
                                                                    <option
                                                                        <?php if ($user->getAccountId() == $lead->getAccount()) { ?>selected="selected" <?php } ?>
                                                                        value="<?php echo $user->getAccountId() ?>"
                                                                        data-psa="<?php echo $user->hasPsaCreds() ? '1' : '0'; ?>"><?php echo $user->getFullName() ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <input type="hidden" name="psaUrl"
                                                                   value="<?php echo $lead->getPsaAuditUrl(); ?>"
                                                        </p>
                                                    <?php } else { ?>
                                                        <select name="account" id="account" tabindex="54">
                                                            <option value="<?php echo $account->getAccountId(); ?>"
                                                                    data-psa="<?php echo $account->hasPsaCreds() ? '1' : '0'; ?>"><?php echo $account->getFullName(); ?></option>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                                <td width="20%"
                                                    class="psaSegment" <?php echo ($showPsa) ? '' : 'style="display:none !important"'; ?>>
                                                    <?php if ($showPsa) { ?>
                                                        <label style="width: 200px;"><input style="margin-top: 5px;"
                                                                                            type="checkbox"
                                                                                            name="psaAuditCheck"
                                                                                            value="1" id="psaAuditCheck"
                                                                                            checked="checked"/>Create
                                                            audit in ProSiteAudit</label>
                                                    <?php } ?>
                                                </td>
                                                <td width="40%"
                                                    class="psaSegment" <?php echo ($showPsa) ? '' : 'style="display:none !important"'; ?>>
                                                    <?php if ($showPsa) { ?>
                                                    <div id="auditTypeContainer">

                                                        <label style="width: 100px;">Audit Type</label>
                                                        <select name="auditType" id="auditType"></select>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
                                <tr class="even">
                                    <td colspan="2">
                                        <h4>Notes</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <p class="clearfix">
                                            <textarea name="notes" id="notes" cols="30" rows="10"
                                                      style="width: 440px; height: 100px;"><?php echo $lead->getNotes() ?></textarea>
                                        </p>

                                        <p>* All information will be emailed to the assigned salesperson.</p>
                                    </td>
                                    <td valign="top">
                                        <?php if ($lead->getStatus() != 'Converted') { ?>
                                            <input type="submit" class="btn blue-button" id="editLeadSubmit" value="Resend"
                                                   tabindex="250" style="margin: 40px 0 0 185px;">
                                        <?php } else { ?>
                                            <a class="btn" href="#" id="savingDisabled" style="margin: 40px 0 0 90px;">Editing
                                                Disabled for Converted Leads</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div id="tabs-2" class="clearfix" style="padding: 0 !important;">
                        <div class="clearfix">
                            <h3 class="padded left" style="margin: 0;">Upcoming Events</h3>
                            <a href="#" class="btn small right scheduleLeadEvent" style="margin: 10px;"
                               data-lead="<?= $lead->getLeadId() ?>" data-account="<?= $lead->getAccount(); ?>"
                               data-projectname="<?= $lead->getProjectName() ?>"
                               data-phone="<?= $lead->getBusinessPhone(true) ?>"
                               data-redirect="leads/edit/<?= $lead->getLeadId() ?>/schedule">Add Event</a>
                        </div>

                        <?php $this->load->view('templates/events/table'); ?>

                    </div>

                </div>
            </div>
            <div class="javascript_loaded">
            </div>

            <div id="auditTypeRequired" title="Error">
                <p class="clearfix">Please select an audit type</p>
            </div>
            <script src="https://maps.googleapis.com/maps/api/js"></script>
            <script type="text/javascript">

                var hasAudit = <?php echo ($lead->getPsaAuditUrl()) ? 'true' : 'false'; ?>;

                $(document).ready(function () {
                    // $('.businessTypeMultiple').select2({
                    //     placeholder: "Select one or many"
                    // });
                    $("#tabs").tabs();
                    <?php if ($this->uri->segment(4) == 'schedule'): ?>
                    $('#tabs').tabs('select', "tabs-2");
                    <?php endif; ?>

                    loadAuditTypeSelect();

                    $("#editLeadSubmit").click(function () {

                        if ($("#psaAuditCheck").is(':checked')) {

                            if ($("#auditType").val() > 0) {
                                $("#auditTypeError").hide();
                                // Submit the form
                                $('#editLeadForm').submit();
                            }
                            else {
                                $("#auditTypeError").show();
                                $("#auditTypeRequired").dialog('open');
                                return false;
                            }
                        }

                    });

                    $("#sameAsAbove").click(function () {
                        $("#projectAddress").val($("#address").val());
                        $("#projectCity").val($("#city").val());
                        $("#projectState").val($("#state").val());
                        $("#projectZip").val($("#zip").val());
                        $("#projectPhone").val($("#businessPhone").val());
                        $("#projectPhoneExt").val($("#businessPhoneExt").val());
                        $("#projectCellPhone").val($("#cellPhone").val());
                        $('form').valid();
                        return false;
                    });
                    $("#savingDisabled").click(function () {
                        return false;
                    });
                    $("#dueDate").datepicker({});
                    $("#add-note").submit(function () {
                        var request = $.ajax({
                            url: '<?php echo site_url('ajax/addNote') ?>',
                            type: "POST",
                            data: {
                                "noteText": $("#noteText").val(),
                                "noteType": 'lead',
                                "relationId": $("#relationId").val()
                            },
                            dataType: "json",
                            success: function (data) {
                                if (data.success) {
                                    //refresh frame
                                    $("#noteText").val('');
                                    $('#notesFrame').attr('src', $('#notesFrame').attr('src'));
                                } else {
                                    if (data.error) {
                                        alert("Error: " + data.error);
                                    } else {
                                        alert('An error has occurred. Please try again later!')
                                    }
                                }
                            }
                        });
                        return false;
                    });
                    $("#account").change(function () {
                        var value = '' + $(this).val() + '';
                        $("#account").val(value);

                        if (hasAudit) {
                            var hasPsa = $(this).find('option:selected').data('psa');

                            if (($(this).val() > 0) && !hasPsa) {
                                swal('Warning',
                                    'This user does not have ProSiteAudit credentials and the attached ' +
                                    'audit will not be reassigned!',
                                    'warning'
                                );
                            }
                        }

                        loadAuditTypeSelect();
                    });


                    $("#businessPhone, #cellPhone, #projectPhone, #projectCellPhone, #fax").mask("999-999-9999");


                    $("#lead-map-dialog").dialog({
                        modal: true,
                        buttons: {
                            Close: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false,
                        width: 700
                    });

                    $("#loadMap").click(function () {

                        var add = $('#address').val() + ' ' + $('#state').val();
                        var url =

                            $("#lead-map-dialog").dialog('open');
                    });

                    // Show the dropdown if checkbox checked
                    $("#psaAuditCheck").change(function () {

                        if ($(this).is(":checked")) {
                            $("#auditTypeContainer").show();
                            addAddressValidation();
                        }
                        else {
                            $("#auditTypeContainer").hide();
                            removeAddressValidation();
                        }
                    });

                    $("#auditType").change(function () {
                        if ($(this).val() > 0) {
                            $("#auditTypeError").hide();
                        }
                    });

                    $("#auditTypeRequired").dialog({
                        modal: true,
                        autoOpen: false,
                        buttons: {
                            Close: function () {
                                $(this).dialog('close');
                            }
                        }
                    });

                });

                function addAddressValidation() {
                    $("#projectName").addClass('required');
                    $("#projectAddress").addClass('required');
                    $("#projectCity").addClass('required');
                    $("#projectState").addClass('required');
                    $("#projectZip").addClass('required');
                    $("#title").addClass('required');
                }

                function removeAddressValidation() {
                    $("#projectName").removeClass('required');
                    $("#projectAddress").removeClass('required');
                    $("#projectCity").removeClass('required');
                    $("#projectState").removeClass('required');
                    $("#projectZip").removeClass('required');
                    $("#title").removeClass('required');
                }

                function loadAuditTypeSelect() {

                    var pavementAuditType = <?php echo PSA_PAVEMENT ?>;
                    var selectedOption = $('#account').find(':selected');

                    if ($(selectedOption).data('psa')) {

                        var auditTypeSelect = $("#auditType");
                        auditTypeSelect.html('<option value="">Loading...</option>');

                        $.ajax({
                            url: "<?php echo site_url('ajax/getUserAuditTypes') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                accountId: $(selectedOption).val()
                            },
                            success: function (data) {
                                auditTypeSelect.html('');
                                var numTypes = Object.keys(data.auditTypes).length;

                                auditTypeSelect.append('<option value="">- Select Audit Type</option>');

                                if (numTypes > 0) {
                                    for (var k in data.auditTypes) {
                                        if (k == pavementAuditType) {
                                            auditTypeSelect.append('<option value="' + k + '" selected>' + data.auditTypes[k] + '</option>');
                                        }
                                        else {
                                            auditTypeSelect.append('<option value="' + k + '">' + data.auditTypes[k] + '</option>');
                                        }
                                    }
                                } else {
                                    auditTypeSelect.append('<option value="">No Audit Types Available</option>');
                                }

                                $.uniform.update();
                            }
                        });

                        $(".psaSegment").show();
                        $("#psaAuditCheck").prop('checked', true);
                        addAddressValidation();
                    }
                    else {
                        $(".psaSegment").hide();
                        $("#psaAuditCheck").prop('checked', false);
                        removeAddressValidation();
                    }

                    $.uniform.update();
                }

                $(document).on("change","#business_type",function(e) {
         
                if($(this).val()){
                    $(this).closest('div').removeClass('select_box_error');
                }else{
                    
                
                        $(this).closest('div').addClass('select_box_error');
                
                }
                
            });
            $(document).on("click","#editLeadSubmit",function(e) {
                if($('#business_type').val()){
                    $('#business_type').closest('div').removeClass('select_box_error');
                }else{
                    
                        $('#business_type').closest('div').addClass('select_box_error');
        
                }
                
            });
            </script>

            <div id="lead-map-dialog" title="Lead Map">

                <p id="nav-send-status">Sending Email...</p>

            </div>

        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>