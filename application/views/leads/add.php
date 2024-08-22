<?php $this->load->view('global/header'); ?>
<style>
.select2-container {
width: 30.5% !important;
padding: 0;
}
.select2-selection__rendered{
    float: left!important;
}
.select2-selection--multiple{
    overflow: hidden !important;
    height: auto !important;
}
.select2-selection__arrow{
    display: none;
}
.select_box_error {
    border-radius: 2px;
    border: 1px solid #e47074 !important;
    background-color: #ffedad !important;
    box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
}
<?php if($this->uri->segment(3)){ ?>
    .before_select_lead_type{
        display: none; 
    }
<?php }else{ ?>
    .add_lead_table tr:not(.before_select_lead_type) {
  display: none;
}
    
    <?php } ?>
.add_lead_table tbody{
    min-height: 300px;
}
</style>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                    Add New Lead 
                    <a class="tiptip box-action" href="<?php echo site_url('leads') ?>" title="Back to Leads" style="margin-left: 10px;">Back</a>
                </div>
                <div class="box-content" style="min-height:350px;">
                    <form class="form-validated" method="post" action="<?php echo site_url('leads/add') ?>">
                    <input type="hidden" name="convert_prospect"  value="<?php echo ($prospect && !$client_id) ? $prospect->getProspectId() : '0'; ?>">
                        <table class="boxed-table add_lead_table" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                            
                            </thead>
                            <tbody>
                            <tr class="before_select_lead_type">
                                <td colspan="2" style="padding-top: 25px;border-bottom: none;">
                                    <p id="search_box_p">
                                        <label style="margin-left: 21%;">Search</label>
                                        <select name="SeachcompanyName" id="SeachcompanyName" tabindex="1" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option></option></select>
                                    </p>
                                    <a href="javascript:void(0);" style="display: none;margin-left: 44%;position: relative;" class="hide btn blue-button search_again_btn" >Search Again</a>
                                </td>
                                <!-- <td style="width:50%"><a class="btn blue-button create_new_lead_btn" style="margin-left: 25%;"><i class="fa fa-fw fa-plus"></i> Create Lead New Contact</a></td> -->
                            </tr>
                            
                            
                            <tr>
                                <td>
                                    <label>Account Name</label>
                                    <!-- <input class="text" type="text" name="companyName" id="companyName" tabindex="6" value="<?php //echo $companyName; ?>" placeholder="Leave Blank for Residential"> -->
                                    <input name="companyName" id="companyName" tabindex="2"  class="text" placeholder="Leave Blank for Residential">
                                    <input id="client" type="hidden" name="client" value="<?php echo $client_id; ?>" >
                                </td>
                                <td>
                                    <label>Zip</label>
                                    <input class="text" type="text" name="zip" id="zip" tabindex="9" value="<?php echo ($prospect) ? $prospect->getZip() : ''; ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>First Name <span>*</span></label>
                                    <input class="text required capitalize2" type="text" name="firstName" id="firstName" tabindex="3" value="<?php echo ($prospect) ? $prospect->getFirstName() : ''; ?>">
                                </td>
                                <td>
                                    <label>Business Phone</label>
                                    <input class="text" type="text" style="width: 100px;" name="businessPhone" id="businessPhone" tabindex="10" value="<?php echo ($prospect) ? $prospect->getBusinessPhone() : ''; ?>">
                                    &nbsp;&nbsp;&nbsp;<input tabindex="11" class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension" type="text" name="businessPhoneExt" id="businessPhoneExt" value="<?php echo ($prospect) ? $prospect->getBusinessPhoneExt() : set_value('businessPhoneExt') ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Last Name <span>*</span></label>
                                    <input class="text required capitalize2" type="text" name="lastName" id="lastName" tabindex="4" value="<?php echo ($prospect) ? $prospect->getLastName() : ''; ?>">
                                </td>
                                <td>
                                    <label>Cell Phone</label>
                                    <input class="text" type="text" name="cellPhone" id="cellPhone" tabindex="12" value="<?php echo ($prospect) ? $prospect->getCellPhone() : ''; ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Title</label>
                                    <input class="text " type="text" name="title" id="title" tabindex="5" value="<?php echo ($prospect) ? $prospect->getTitle() : ''; ?>">
                                </td>
                                <td>
                                    <label>Fax</label>
                                    <input class="text" type="text" name="fax" id="fax" tabindex="13" value="<?php echo ($prospect) ? $prospect->getFax() : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Address</label>
                                    <input class="text " type="text" name="address" id="address" tabindex="6" value="<?php echo ($prospect) ? $prospect->getAddress() : ''; ?>">
                                </td>
                                <td>
                                    <label>Email</label>
                                    <input class="text  email" type="text" name="email" id="email" tabindex="14" value="<?php echo ($prospect) ? $prospect->getEmail() : ''; ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>City</label>
                                    <input class="text " type="text" name="city" id="city" tabindex="7" value="<?php echo ($prospect) ? $prospect->getCity() : ''; ?>">
                                </td>
                                <td>
                                    <label>Website</label>
                                    <input class="text" type="text" name="website" id="website" tabindex="15" value="<?php echo ($prospect) ? $prospect->getWebsite() : ''; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>State</label>
                                    <input class="text " type="text" name="state" id="state" autocomplete="off" tabindex="8" value="<?php echo ($prospect) ? $prospect->getState() : ''; ?>">
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                            <thead>
                            <tr>
                                <td colspan="2">
                                    <h4 style="text-align: left;">
                                        Project Info
                                        <a class="btn" href="#" style="font-size: 12px; margin-left: 10px;" id="sameAsAbove">Same as Above</a>
                                        <span style="font-size: 12px; line-height: 16px; margin-left: 10px; color: #3F3F41;">Add location if different than above.</span>
                                    </h4>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <label>Project Name</label>
                                    <input class="text " type="text" name="projectName" id="projectName" tabindex="16">
                                </td>
                                <td>
                                    <label>Address</label>
                                    <input class="text " type="text" name="projectAddress" id="projectAddress" tabindex="24">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Contact Name</label>
                                    <input class="text" type="text" name="projectContact" id="projectContact" tabindex="17">
                                </td>
                                <td>
                                    <label>City</label>
                                    <input class="text " type="text" name="projectCity" id="projectCity" tabindex="25">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Business Phone</label>
                                    <input class="text" style="width: 100px;" type="text" name="projectPhone" id="projectPhone" tabindex="18">
                                    &nbsp;&nbsp;&nbsp;<input tabindex="19" class="text tiptip" style="width: 50px;" placeholder="Ext" title="Please type the business phone extension (if applicable)" type="text" name="projectPhoneExt" id="projectPhoneExt" value="">
                                </td>
                                <td>
                                    <label>State</label>
                                    <input class="text" type="text" name="projectState" id="projectState" tabindex="26">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Cell Phone</label>
                                    <input class="text" type="text" name="projectCellPhone" id="projectCellPhone" tabindex="20">
                                </td>
                                <td>
                                    <label>Zip</label>
                                    <input class="text" type="text" name="projectZip" id="projectZip" tabindex="27">
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    <label>Source</label>
                                    <?php echo form_dropdown('source', $sources, $prospectSource, 'id="source" tabindex="21"') ?>
                                </td>
                                <td>
                                    <label>Due Date</label>
                                    <input class="required text" tabindex="28" type="text" name="dueDate" id="dueDate" value="<?php echo date('n/j/Y', time() + (86400 * 2)) ?>" style="width: 70px;">
                                </td>
                            </tr>
                            <tr class="even">
                                <td width="50%">
                                    <label>Status</label>
                                    <?php echo form_dropdown('status', $statuses, '', 'id="statuses" tabindex="22"') ?>
                                </td>
                                <td>
                                    
                                    <label>Business Type <span>*</span></label>
                                    <select id="business_type"  class="businessTypeMultiple required"  style="width: 64%" name="business_type" tabindex="29" >
                                        <option value="">Please Select</option>
                                    <?php 
                                    
                                            foreach($businessTypes as $businessType){
                                                if($businessType->getId() == $business_type_id){ $selected = 'selected="selected"';}else{ $selected = '';}
                                                echo '<option value="'.$businessType->getId().'" '. $selected.'>'.$businessType->getTypeName().'</option>';
                                            }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    <label>Rating</label>
                                    <?php echo form_dropdown('rating', $ratings, '', 'id="rating" tabindex="23"') ?>
                                </td>
                                <td></td>
                                 
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
                                        <input tabindex="<?php echo(40 + $k) ?>" style="margin-top: 5px;" type="checkbox" name="services[<?php echo $service->getServiceId() ?>]" value="<?php echo $service->getServiceId() ?>" id="service_<?php echo $service->getServiceId() ?>">
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr class="even">
                                <td >
                                    <h4>Notes</h4>
                                </td>
                                <td >
                                    <h4>Attachments</h4>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    
                                    <p class="clearfix">
                                        <textarea name="notes" id="notes" tabindex="100" cols="30" rows="10" style="width: 440px; height: 100px;"></textarea>
                                    </p>

                                    <p>* All information will be emailed to the assigned salesperson.</p>
                                </td>
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
                                                    <input type="text" tabindex="101" class="text tiptip" title="Please enter a file title!" name="fileName" id="fileName" style="width: 180px;">
                                                </p>
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td>
                                                <p class="clearfix">
                                                    <label> File</label><input type="file" tabindex="102" name="file" id="file">
                                                </p>

                                                <p class="clearfix">
                                                    <span style="display: block;" class="clearfix"> Note: You can upload any type of file, within a limit of 10MB.</span>
                                                </p>
                                                <input type="button" tabindex="103" value="Upload" name="uploadFile" id="uploadFile" class="btn" style="position: absolute;right: 45px;margin-top: -27px;">
                                            </td>
                                        </tr>
                                        
                                        <tr><div id="lead-attachments"></div></tr>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            function resetAttachmentForm() {
                                                $("#fileName").val('');
                                                $("#uploadFile").val('Upload');
                                                document.getElementById("file").value = "";
                                            }

                                            function addFile(fileObject) {
                                                $("#noAttachments").hide();
                                                $("#lead-attachments").append('<div class="leadAttachment">' +
                                                    '<a href="' + fileObject.fileURL + '" class="file_name" target="_blank">' + fileObject.fileName + '</a>' +
                                                    '<a href="#" class="right removeTemporaryAttachment">Remove</a>' +
                                                    '<a href="#" class="right editTemporaryAttachment" style="margin-right: 6px;">Edit</a>' +
                                                    '<input type="hidden" name="attachmentFiles[]" value="' + fileObject.filePath + '">' +
                                                    '<input type="hidden" name="attachmentFileNames[]" class="file_name" value="' + fileObject.fileName + '"></div>');
                                            }

                                            $(document).on('click', ".removeTemporaryAttachment", function () {
                                                swal({
                                                    title: "Are you sure?",
                                                    text: "You will not be able to recover the attachment after deletion!",
                                                    type: "warning",
                                                    showCancelButton: true,
                                                    confirmButtonColor: "#DD6B55",
                                                    confirmButtonText: "Yes, delete it!",
                                                    closeOnConfirm: false
                                                }).then(function () {
                                                    $(this).parent().remove();
                                                }.bind(this));
                                                return false;
                                            });

                                            $(document).on('click', ".editTemporaryAttachment", function () {
                                                var fileLink = $(this).parent().find("a.file_name");
                                                var fileInput = $(this).parent().find("input.file_name");
                                                var attachmentName = fileLink.text();
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
                                                    fileLink.text(result);
                                                    fileInput.val(result);
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
                                                    url: '<?= site_url('leads/addTemporaryAttachment') ?>',
                                                    type: 'POST',
                                                    data: formData,
                                                    dataType: "JSON",
                                                    processData: false,
                                                    contentType: false,
                                                    success: function (data) {
                                                        if (data.success) {
                                                            resetAttachmentForm();
                                                            addFile(data);
                                                        } else {
                                                            swal('Error', 'There was an error uploading your file!', 'warning');
                                                        }
//                                                        console.log(data);
//                                                        alert(data);
                                                    }
                                                });
                                                return false;
                                            });
                                        });
                                    </script>
                                </td>
                                
                            </tr>
                            
                            <?php
                            if ($account->hasPsaCreds()) {
                                $showPsa = true;
                            } else {
                                $showPsa = false;
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
                                                        <label style="width: 100px;">Assigned To</label>
                                                        <select name="account" id="account" tabindex="104" >
                                                            <option value="0">To Be Assigned</option>
                                                            <?php
                                                            foreach ($users as $user) {
                                                                ?>
                                                                <option <?php if ($user->getAccountId() == $account->getAccountId()) { ?>selected="selected" <?php } ?> value="<?php echo $user->getAccountId() ?>" data-psa="<?php echo $user->hasPsaCreds() ? '1' : '0'; ?>"><?php echo $user->getFullName() ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </p>
                                                <?php } else { ?>
                                                    <select name="account"  id="account" tabindex="105">
                                                        <option value="<?php echo $account->getAccountId(); ?>" data-psa="<?php echo $account->hasPsaCreds() ? '1' : '0'; ?>"><?php echo $account->getFullName(); ?></option>
                                                    </select>
                                                <?php } ?>
                                            </td>
                                            <td width="20%" class="psaSegment" <?php echo ($showPsa) ? '' : 'style="display:none"'; ?>>
                                                <label style="width: 200px;"><input style="margin-top: 5px;" type="checkbox" tabindex="106" name="psaAuditCheck" value="1" id="psaAuditCheck"
                                                        <?php echo ($showPsa) ? 'checked="checked"' : ''; ?> />Create audit in ProSiteAudit</label>
                                            </td>
                                            <td width="40%" class="psaSegment"<?php echo ($showPsa) ? '' : 'style="display:none"'; ?>>
                                                <div id="auditTypeContainer">
                                                    <label style="width: 100px;">Audit Type</label>
                                                    <select name="auditType" tabindex="107" id="auditType">
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                            </tr>

                            
                            <tr>
                                
                                <td colspan="2" valign="top">
                                    <div style="display: flex;justify-content: center;align-items: center;">              
                                    <input type="submit" tabindex="108" class="btn blue" name="add" id="addLead" value="Add Lead" tabindex="250" style="padding: 10px 20px;font-size: 20px;">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="javascript_loaded">
            </div>

            <div id="auditTypeRequired" title="Error">
                <p class="clearfix">Please select an audit type</p>
            </div>

            <div id="authenticationFailed" title="Error - ProSiteAudit Login Error">
                <p class="clearfix">Your username/password are incorrect for ProSiteAudit.</p><br/>
                <p class="clearfix">Please assign to a different user, or update your ProSiteAudit username and password in my account, or ask your administrator to do so.</p>
            </div>

            <script type="text/javascript">
                $(document).ready(function () {

                    // $('.businessTypeMultiple').select2({
                    //     placeholder: "Select one or many"
                    // });
                    loadAuditTypeSelect();

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
                    $("#dueDate").datepicker({
                        minDate: "+0D"
                    });
                    $("#clientType").change(function () {
                        if ($(this).val() == 1) {
                            $("#clientSearch").hide();
                        } else {
                            $("#clientSearch").show();
                        }
                    });



//Select2 start

$("#SeachcompanyName").select2({
  ajax: {
    url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
    dataType: 'json',
    delay: 250,
    
    data: function (params) {
      return {
        startsWith: params.term, // search term
        firstName: $("#firstName").val(),
        lastName: $("#lastName").val(),
        page: params.page
      };
    },
    processResults: function (data, params) {

      params.page = params.page || 1;
      
      
      return {
        results: data.items,
        pagination: {
          more: (params.page * 30) < data.total_count
        }
      };
      

      //'<span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-SeachcompanyName-results" aria-expanded="true" aria-hidden="false"><li role="alert" aria-live="assertive" class="select2-results__option select2-results__message">+Add New</li></ul></span>';
    },
    cache: true
  },
  placeholder: 'Search for a repository',
  allowClear: true,
  debug: true,
  minimumInputLength: 1,
  language: {
    inputTooShort: function () { return ''; },
    noResults: function(){
           return "Contact Not Found";
       }
},
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});
<?php if(!$this->uri->segment(3)){ ?>
setTimeout(function() {
    $('#SeachcompanyName').select2('open');
    if($('.add_new_class').length<1){
        $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="javascript:void(0);" onclick="add_new_lead()" style="color: #25AAE1;font-size:14px;"><i class="fa fa-fw fa-plus"></i> Create Lead New Contact</li></ul></span>');
      }
}, 500);
<?php } ?>

function formatRepo (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      
      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Contact:</th><td class='select2-result-repository_contact'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Owner:</th><td class='select2-result-repository_owner'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Proposals:</th><td class='select2-result-repository_proposal'></td></tr>"+
      "</div>" +
    "</div>"
  );
  
  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);
  $container.find(".select2-result-repository_address").html(repo.address);
  $container.find(".select2-result-repository_owner").text(repo.owner);
  $container.find(".select2-result-repository_proposal").html(repo.proposals_count);

  return $container;
}

function formatRepoSelection (repo) {
  return repo.label ;
}
$(".select2-selection__placeholder").text('Search existing contact')

$('#SeachcompanyName').on("select2:selecting", function(e) { 
   // what you would like to happen
   $('.add_lead_table tr').show();
   $('#search_box_p').hide();
   $('.search_again_btn').show();
   var select_id = e.params.args.data.id
   $("#client").val(select_id);
                            $.ajax({
                                url: "<?php echo site_url('ajax/getClientData') ?>/" + select_id,
                                type: "POST",
                                dataType: "json",
                                success: function (data) {
                                    $("#companyName").val(data.clientAccount);
                                    $("#firstName").val(data.firstName);
                                    $("#lastName").val(data.lastName);
                                    $("#title").val(data.title);
                                    $("#address").val(data.address);
                                    $("#city").val(data.city);
                                    $("#fax").val(data.fax);
                                    $("#state").val(data.state);
                                    $("#zip").val(data.zip);
                                    $("#businessPhone").val(data.businessPhone);
                                    $("#cellPhone").val(data.cellPhone);
                                    $("#email").val(data.email);
                                    $("#website").val(data.website);
                                    $("#account").val(data.accountId.toString());
                                    $.uniform.update();
                                    $('form').valid();
                                    loadAuditTypeSelect();
                                }
                            });
                            event.preventDefault();
});

$(document).on("click",".select2-container",function(e) {
    //$('.select2-dropdown').css('margin-left','0px');
})

//Select2 end


                    $("#companyName").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "<?php echo site_url('ajax/ajaxSearchClientsName') ?>",
                                type: "POST",
                                dataType: "json",
                                data: {
                                    maxRows: 12,
                                    startsWith: request.term,
                                    firstName: $("#firstName").val(),
                                    lastName: $("#lastName").val()
                                },
                                success: function (data) {

                                    response($.map(data, function (item) {
                                        console.log(data);
                                            return {
                                                label: item.label,
                                                value: item.value
                                            }
                                        }
                                    ));
                                }
                            });
                        },
                        minLength: 2,
                        select: function (event, ui) {
                            $("#client").val(ui.item.value);
                            $.ajax({
                                url: "<?php echo site_url('ajax/getClientData') ?>/" + ui.item.value,
                                type: "POST",
                                dataType: "json",
                                success: function (data) {
                                    $("#companyName").val(data.clientAccount);
                                    $("#firstName").val(data.firstName);
                                    $("#lastName").val(data.lastName);
                                    $("#title").val(data.title);
                                    $("#address").val(data.address);
                                    $("#city").val(data.city);
                                    $("#fax").val(data.fax);
                                    $("#state").val(data.state);
                                    $("#zip").val(data.zip);
                                    $("#businessPhone").val(data.businessPhone);
                                    $("#cellPhone").val(data.cellPhone);
                                    $("#email").val(data.email);
                                    $("#website").val(data.website);
                                    $("#account").val(data.accountId.toString());
                                    $.uniform.update();
                                    $('form').valid();
                                    loadAuditTypeSelect();
                                }
                            });
                            event.preventDefault();
                        },
                        open: function () {
                            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                        },
                        close: function () {
                            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                        }
                    });


                    $("#account").change(function () {

                        var value = '' + $(this).val() + '';
                        $("#account").val(value);

                        loadAuditTypeSelect();

                    });
                    $("#businessPhone, #cellPhone, #projectPhone, #projectCellPhone, #fax").mask("999-999-9999");

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

                    $("#addLead").click(function () {
                        if ($("#psaAuditCheck").is(':checked')) {

                            if ($("#auditType").val() > 0) {
                                $("#auditTypeError").hide();
                                return true;
                            }
                            else {
                                $("#auditTypeError").show();
                                $("#auditTypeRequired").dialog('open');
                                return false;
                            }
                        }
                        return true;
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

                    $("#authenticationFailed").dialog({
                        width: 400,
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
                        auditTypeSelect.html('');

                        $.ajax({
                            url: "<?php echo site_url('ajax/getUserAuditTypes') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                accountId: $(selectedOption).val()
                            },
                            success: function (data) {

                                if (data.authError) {
                                    $("#authenticationFailed").dialog('open');
                                    $("#psaAuditCheck").attr('checked', false);
                                } else {
                                    var numTypes = Object.keys(data.auditTypes).length;

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

                initAutocomplete();

                function initAutocomplete() {
                    // Create the autocomplete object, restricting the search to geographical
                    // location types.
                    autocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('address')),
                        {
                            fields: ["name", "geometry.location", "address_component"]
                        });

                    google.maps.event.addListener(autocomplete, 'place_changed', function() {

                        var place = autocomplete.getPlace();
                        var parsedPlace = placeParser(place);

                        $("#address").val(place.name);
                        $("#city").val(parsedPlace.locality);
                        $("#state").val(parsedPlace.state);
                        $("#zip").val(parsedPlace.postal_code);
                    });
                }

                $('#address').keydown(function (e) {
                    if (e.which == 13 && $('.pac-container:visible').length) return false;
                });

                initProjectAddressAutocomplete();

                function initProjectAddressAutocomplete() {
                    // Create the autocomplete object, restricting the search to geographical
                    // location types.
                    var paAutocomplete = new google.maps.places.Autocomplete(
                        /** @type {!HTMLInputElement} */(document.getElementById('projectAddress')),
                        {
                            fields: ["name", "geometry.location", "address_component"]
                        });

                    google.maps.event.addListener(paAutocomplete, 'place_changed', function() {

                        var place = paAutocomplete.getPlace();
                        var parsedPlace = placeParser(place);

                        $("#projectAddress").val(place.name);
                        $("#projectCity").val(parsedPlace.locality);
                        $("#projectState").val(parsedPlace.state);
                        $("#projectZip").val(parsedPlace.postal_code);
                    });
                }

                $('#projectAddress').keydown(function (e) {
                    if (e.which == 13 && $('.pac-container:visible').length) return false;
                });

                $(document).on("change","#business_type",function(e) {
         
                    if($(this).val()){
                        $(this).closest('div').removeClass('select_box_error');
                    }else{
                        
                    
                            $(this).closest('div').addClass('select_box_error');
                    
                    }
                    
                });
                $(document).on("click","#addLead",function(e) {
                    if($('#business_type').val()){
                        $('#business_type').closest('div').removeClass('select_box_error');
                    }else{
                        
                            $('#business_type').closest('div').addClass('select_box_error');
            
                    }
                    
                });

                $(".capitalize2").keyup(function() {
                    $(this).capitalize();
                });
                $(document).on("click",".search_again_btn",function(e) {
                    //$('.form-validated').reset();
                    
                    $('.form-validated').trigger("reset");
                    $('#SeachcompanyName').val('').trigger('change');
                    $('#search_box_p').show();
                    $('.search_again_btn').hide();
                   
                    setTimeout(function() {
                        $('#SeachcompanyName').select2('open');
                        $(".select2-selection__placeholder").text('Search existing contact')
                    }, 400);
                    $('.add_lead_table tr').hide();
                    $('.before_select_lead_type').show();
                    
                });
                 
                 function add_new_lead(){
                    var search_val = $('.select2-search__field').val();
                    if(search_val){
                        var res = search_val.split(" ");
                        var firstname = search_val.substr(0,search_val.indexOf(' ')); 
                        var lastname = search_val.substr(search_val.indexOf(' ')+1);
                        $('#firstName').val(firstname.charAt(0).toUpperCase() + firstname.slice(1).toLowerCase());
                        $('#lastName').val(lastname.charAt(0).toUpperCase() + lastname.slice(1).toLowerCase());
                    }
                    $('#companyName').focus();
                    $('#search_box_p').hide();
                    $('.search_again_btn').show();
                    $('#SeachcompanyName').select2('close');
                    $('.add_lead_table tr').show();
                 }
                
            </script>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>