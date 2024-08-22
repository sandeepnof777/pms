<!-- Confirm delete dialog -->
<div id="delete-clients" title="Confirmation">
    <h3>Confirmation - Delete Contacts</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> contacts.</p>
    <br />
    <p><strong>It will also delete all of their proposals</strong></p>
    <br />
    <p>Are you sure that you want to proceed?</p>
</div>

<!-- Delete contact Feedback -->
<div id="delete-clients-status" title="Confirmation">
    <h3>Confirmation - Delete Contacts</h3>

    <p id="deleteClientsStatus"></p>
</div>
<style>
    #addAtCursorEdit {
        position: absolute;
        margin-top: 1px;
        margin-left: 16px;
    }

    #addAtCursorEdit span {
        padding-top: 2px;
        padding-bottom: 2px;
    }

    #uniform-templateFields span {
        width: 125px !important;
    }

    #uniform-templateFields {
        width: 150px !important;
        margin-left: 41px;
    }


    #uniform-resendSelect span {
        width: 200px !important;
    }

    #uniform-resendSelect {
        width: 225px !important;
    }

    #uniform-templateSelect span {
        width: 200px !important;
    }

    #uniform-templateSelect {
        width: 225px !important;
    }

    #cke_event_email_content .cke_reset_all {
        display: none
    }

    #email_events_table_info {
        width: 18% !important;
        clear: none !important;
    }
</style>
<!-- Client Email Dialog -->
<div id="client-email" title="Confirmation">
    <h3>Confirmation - Send Email</h3>
    <p>
        <span style="padding-right: 33px;font-weight:bold">Email Template:</span>
        <select id="templateSelect">
            <?php
            foreach ($clientTemplates as $template) {
                /* @var $template \models\ClientEmailTemplate */
            ?>
                <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
            <?php
            }
            ?>
        </select>

        <?php if ($account->isAdministrator()) { ?>
            <span style="float: right;padding-right: 205px;"><input type="checkbox" id="emailCustom"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

        <?php } ?>
    </p><br />
    <p style="margin-bottom: 15px;"><span style="padding-right: 12px;font-weight:bold">Choose Campaign:</span>

        <select name="resendId" id="resendSelect">
            <option value="">Select Resend Campaign</option>
            <option value="0">New</option>
            <option value="-1">No Campaign</option>
            <?php
            foreach ($resends as $resend) {
                /* @var $template \models\ClientEmailTemplate */
            ?>
                <option value="<?php echo $resend->id; ?>"><?php echo $resend->resend_name; ?></option>
            <?php
            }
            ?>
        </select>

        <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Campaign Name:</label>
        <input type="text" class="text new_resend_name no_campaign" name="new_resend_name" />


    </p>



    <p style="margin-bottom: 15px;">
        <span style="width: 100px; display: inline-block;padding-right: 39px;font-weight:bold ">Subject:</span><input class="text" type="text" id="messageSubject" style="width: 225px;">
        <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Add Field:</label>
        <select id="templateFields">
            <option value="">- Select a field</option>
            <?php
            foreach ($email_template_fields as $fields) {
            ?>
                <option value="{<?php echo $fields->field_code; ?>}"><?php echo $fields->field_name; ?></option>
            <?php
            }
            ?>
        </select>
        <a class="btn" href="javascript:void(0);" id="addAtCursorEdit"><i class="fa fa-fw fa-plus-circle"></i> Add</a>


    </p>
    <?php if ($account->isAdministrator()) { ?>
        <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from
            the owner of the proposal.</p>
        <p class="emailFromOption" style="margin-bottom: 10px;"><span style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input class="text" type="text" id="messageFromName" style="width: 200px;"><span style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input class="text" type="text" id="messageFromEmail" style="width: 200px;"></p>

    <?php } ?>




    <p style="font-weight:bold;margin-bottom: 10px;">Email Content</p>
    <span style="color: rgb(184, 25, 0);margin-bottom: 10px;display:none" class="is_templateSelect_disable adminInfoMessage "><i class="fa fa-fw fa-info-circle"></i> Email content cannot be edited when adding to an existing campaign</span>
    <textarea id="message">This is the content</textarea>


    <!-- <p>This will send a total of <strong><span id="sendNum"></span></strong> email(s) to contacts.</p>
    <br/> -->

    <p>Are you sure that you want to proceed?</p>
</div>

<div id="preconfirm-resend-clients" title="Confirmation">
    <h3>Confirmation - Send Email</h3>

    <div style="width:88%;float: left;background-color: #ccc;border: 2px solid #aba8a8;padding: 10px 20px;margin-top:5px;border-radius:4px;line-height: 20px;">
        <div style="width: 95%;float: left;"><strong>This will send <span id="resendIncludeNum"></span> emails</strong></div>
        <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="sendNum"></span></strong> Clients Selected</div>
        <div style="width: 95%;float: left;" class="has_excluded"><strong><span id="resendExcludeNum"></span></strong> emails are tagged as 'Email Off'</div>
        <div style="width: 95%;float: left;margin-top:5px;" class="has_excluded_hide"><input type="checkbox" id="sendExcludedEmail" style="margin-left:0px;margin-top:0px;"><span style="margin-top: -2px;position: absolute;">Send All Emails <i class="fa fa-fw fa-info-circle tiptipright" style="cursor:pointer;" title="Send ALL Emails, even if tagged as 'Email Off'"></i></span></div>
    </div>
</div>

<!-- Client Business type Dialog -->
<div id="change-business-type" title="Change Client Business Type">
    <p>Choose one or many Business Types to assign to the selected <span id="changeBusinessTypeNum"></span> Clients</p><br />
    <p><strong> Note:</strong> Any existing assignments will be removed and replaced with the selected assignments only</p><br />
    <label style="padding-left: 7px;padding-right: 3px;">Contact Business Type</label>
    <select class="dont-uniform businessTypeMultiple" style="width: 64%" name="business_type[]" multiple="multiple">
        <?php
        foreach ($businessTypes as $businessType) {
            echo '<option value="' . $businessType->getId() . '">' . $businessType->getTypeName() . '</option>';
        }
        ?>
    </select>

    <p style="padding-left: 145px;padding-top: 8px;float:left"><input type="checkbox" name="apply_bt_on_contact" id="apply_bt_on_contact"><span style="padding-top: 2px;float: left;">Edit all Proposals Business Types</span></p>
    <p style="padding-top: 8px;display:none;float:left" class="bt_on_proposal_p">
        <label>Proposal Business Type</label>
        <select name="apply_bt_on_proposal" id="apply_bt_on_proposal">
            <option value=""> Please select</option>
            <?php
            foreach ($businessTypes as $businessType) {
                echo '<option value="' . $businessType->getId() . '">' . $businessType->getTypeName() . '</option>';
            }
            ?>
        </select>
    </p>
    <p class="bt_on_proposal_p" style="padding-left: 147px;padding-top: 8px;float: left;">Please select any one(1) Business Type for proposals.</p><br />

    <p id="changeBusinessTypeStatus" style="float: left;padding-top: 10px;"></p>
</div>
<!-- Client inline Business type Dialog -->
<div id="change-client-business-type" title="Update Client Business Type">
    <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;padding-left: 110px;">Client: </span><span class="change-bt-account-name"></span></p>

    <label style="padding-left: 10px;"><strong>Contact Business Type</strong></label>
    <input type="hidden" id="business_client_id" name="clientsChangeBusinessTypes">
    <input type="hidden" id="business_change_account_name">
    <select class="dont-uniform clientBusinessTypeMultiple" style="width: 64%" name="client_business_type[]" multiple="multiple">
        <?php
        foreach ($businessTypes as $businessType) {
            echo '<option value="' . $businessType->getId() . '">' . $businessType->getTypeName() . '</option>';
        }
        ?>
    </select>
    <p style="padding-left: 155px;padding-top: 8px;float: left;"><input type="checkbox" name="apply_client_bt_on_contact" id="apply_client_bt_on_contact"><span style="padding-top: 2px;float: left;">Edit all Proposals Business Types</span></p>

    <p style="padding-top: 8px;float: left;display:none" class="client_bt_on_proposal_p">
        <label><strong>Proposal Business Type</strong></label>
        <select name="apply_client_bt_on_proposal" id="apply_client_bt_on_proposal">
            <option value=""> Please select</option>
            <?php
            foreach ($businessTypes as $businessType) {
                echo '<option value="' . $businessType->getId() . '">' . $businessType->getTypeName() . '</option>';
            }
            ?>
        </select>
    </p>
    <p class="client_bt_on_proposal_p" style="display:none;padding-left: 160px;padding-top: 8px;float: left;">Please select any one(1) Business Type for proposals.</p><br />

</div>

<!-- Send Email feedback -->
<div id="email-clients-status" title="Confirmation">
    <h3>Confirmation - Email Contacts</h3>

    <p id="emailClientsStatus" style="text-align:center;margin-top:15px"></p>
</div>


<div id="clients-reassign" title="Reassign Contacts">

    <br />
    <p>Choose the user to reassign these contacts to:</p><br />

    <select id="reassignTo">
        <option value="0">- Select User</option>
        <?php foreach ($companyAccounts as $companyAccount) {
            /* @var $companyAccount \models\Accounts */
        ?>
            <option value="<?php echo $companyAccount->getAccountId(); ?>"><?php echo $companyAccount->getFullName(); ?></option>
        <?php } ?>
    </select>
    <!-- <a href="#" id="confirmReassignBtn" class="btn ui-button update-button">Reassign</a> -->
    <br>

    <p style="padding-top: 10px;"><input type="checkbox" class="reassignProposalCheckbox"><span style="position: relative;top: -2px;margin-left:5px;">Change owner of all proposals to new user</span></p>
</div>

<div id="clients-reassign-status" title="Reassign Contacts">

    <p id="clientReassignStatus">Reassigning Contacts...<img src="/static/loading.gif" /></p>

</div>


<div id="account-reassign" title="Reassign Account">

    <br />
    <p>Select the account to reassign these contacts to:</p><br />

    <select id="reassignAccountTo">
        <option value="0">- Select Account</option>
        <?php foreach ($clientAccounts as $clientAccount) {
            /* @var $clientAccount \models\ClientCompany */
        ?>
            <option value="<?php echo $clientAccount->getId(); ?>"><?php echo $clientAccount->getName(); ?></option>
        <?php } ?>
    </select>
    <a href="#" id="confirmAccountReassignBtn" class="btn ui-button update-button">Reassign Account</a>
</div>

<div id="clients-reassign-account-status" title="Reassign Contact Account">

    <p id="clientAccountReassignStatus">Reassigning Contact Accounts...<img src="/static/loading.gif" /></p>

</div>

<div id="template" style="display: none;">

    <div class="dropdownMenuContainer double">
        <div class="closeDropdown closeClientDropdown" style="line-height: 10px;position: absolute;right: 0;">
            <a href="javascript:void(0);" class="closeDropdownMenu1">&times;</a>
        </div>
        <div class="proposalMenuTitle">
            <h4>{clientfullName}: {clientCompanyName}</h4>

        </div>

        <ul class="dropdownMenu">
            <li class="divider noHover dtCenter">
                <b>Actions</b>
            </li>
            <li>
                <a href="<?php echo site_url('proposals/add/{clientId}'); ?>">
                    <img src="/3rdparty/icons/add.png"> Add New Proposal
                </a>
            </li>
            <li>
                <a class="send_email_individual" data-client-id="{clientId}" data-account="{clientCompanyName}" data-contact-name="{clientfullName}" data-email="{clientEmail}" href="javascript:void(0);">
                    <img src="/3rdparty/icons/email_go.png"> Send Email
                </a>
            </li>
            <li class="edit_contact_li">
                <a href="<?php echo site_url('clients/edit/{clientId}'); ?>">
                    <img src="/3rdparty/icons/user_edit.png"> Edit Contact
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('clients/delete/{clientId}'); ?>" rel="{clientId}" class="confirm-deletion" id="delete-client-{clientId}">
                    <img src="/3rdparty/icons/user_delete.png"> Delete Contact
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('clients/add/{clientId}'); ?>" rel="{clientId}">
                    <img src="/3rdparty/icons/application_double.png"> Duplicate Contact
                </a>
            </li>
            <li>
                <a href="<?php echo  site_url('leads/add/client/{clientId}'); ?>">
                    <img src="/3rdparty/icons/user_suit.png"> Create Lead
                </a>
            </li>
            <li>
                <a href="#" class="scheduleClientCall" data-client="{clientId}" data-account="{clientAccount}" data-contactname="{clientfullName}" data-phone="{clientPhone}">
                    <img src="/3rdparty/icons/time_add.png"> Schedule an Event
                </a>
            </li>
            <li>
                <a href="#" class="exclude_resend_individual" data-client="{clientId}">
                    <img src="/3rdparty/icons/time_add.png"> Email Off
                </a>
            </li>
            <li>
                <a href="#" class="include_resend_individual" data-client="{clientId}">
                    <img src="/3rdparty/icons/time_add.png"> Email On
                </a>
            </li>
        </ul>

        <ul class="dropdownMenu">
            <li class="divider noHover dtCenter">
                <b>Views</b>
            </li>

            <li>
                <a href="<?php echo site_url('proposals/clientProposals/{clientId}'); ?>">
                    <img src="/3rdparty/icons/page_go.png"> Existing Proposals
                </a>
            </li>
            <li>
                <a href="#details-{clientId}" rel="{clientId}" class="viewClient">
                    <img src="/3rdparty/icons/user_suit.png"> Contact Details
                </a>
            </li>
            <li>
                <a href="#" rel="{clientId}" class="view-notes">
                    <img src="/3rdparty/icons/comments.png"> Contact Notes
                </a>
            </li>
            <li>
                <a href="#" rel="{clientId}" class="reassign-proposals" data-client-id="{clientId}">
                    <img src="/3rdparty/icons/arrow_right.png"> Move Proposals
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" rel="{clientId}" class="email_events" data-client-id="{clientId}" data-account="{clientCompanyName}" data-contact-name="{clientfullName}">
                    <img src="/3rdparty/icons/time_add.png"> Email History
                </a>
            </li>
        </ul>
    </div>
</div>



<script type="text/javascript">
    var disable_business_types;
    $(document).ready(function() {
        $("#saves_filter_list").uniform();
        $("#reassignTo").uniform();

        var popup_ui;
        var notes_tiptip_client_id;
        $('.businessTypeMultiple').select2({
            placeholder: "Select one or many"
        });




        $.fn.select2.amd.require(['select2/selection/search'], function(Search) {
            var oldRemoveChoice = Search.prototype.searchRemoveChoice;

            Search.prototype.searchRemoveChoice = function(e) {

                var check_id = arguments[1].id;

                var checked = $('#apply_client_bt_on_contact').is(':checked');
                var disabled = $(".clientBusinessTypeMultiple option[value='" + check_id + "']").prop('disabled');
                if (disabled && !checked) {
                    return false;
                } else {
                    oldRemoveChoice.apply(this, arguments);
                    this.$search.val('');
                }

            };
            $('.clientBusinessTypeMultiple').select2({
                placeholder: "Select one or many",
                html: true,
                templateSelection: function(tag, container) {
                    var $option = $('.clientBusinessTypeMultiple option[value="' + tag.id + '"]');
                    if ($option.attr('disabled')) {
                        $(container).addClass('locked-tag');
                        $(container).addClass('tag_tiptip');
                        tag.title = 'This business type can not be deleted</br> Because a proposal for this contact has this Business Type';
                        tag.locked = true;
                    }
                    return tag.text;
                },
            });
        });
        $("#tableColumnFilterButton").click(function() {
            //hideInfoSlider();
            $("#newClientColumnFilters").toggle();
            // Clear search so that filters aren't affected
            // oTable.fnFilter('');
            // Hide group action menu
            $(".groupActionsContainer").hide();
        });

        updateNumSelected();

        /* Update the number of selected items */
        function updateNumSelected() {
            var num = $(".groupSelect:checked").length;
            console.log('dfdfdf')
            // Hide the options if 0 selected
            if (num < 1) {
                $("#groupActionIntro").show();
                $(".groupAction").hide();
                $(".groupActionsContainer").hide();

            } else {
                $("#groupActionIntro").hide();
                $(".groupAction").show();
                var include_count = 0;
                var exclude_count = 0;
                $(".groupSelect:checked").closest('tr').each(function() {

                    if ($(this).find('.clientsTableDropdownToggle').attr('data-client-excluded') == 1) {
                        exclude_count = exclude_count + 1;
                    } else {
                        include_count = include_count + 1;
                    }

                })
                if (exclude_count < 1) {
                    $('#groupIncludeResend').hide()
                } else {
                    $('#groupIncludeResend').show();
                }
                if (include_count < 1) {
                    $('#groupExcludeResend').hide()
                } else {
                    $('#groupExcludeResend').show();
                }
            }


            $("#numSelected").html(num);
        }

        /* Create an array of the selected IDs */
        function getSelectedIds() {

            var IDs = new Array();

            $(".groupSelect:checked").each(function() {
                IDs.push($(this).data('client-id'));
            });

            return IDs;
        }

        // Update the counter after each change
        $(".groupSelect").live('change', function() {
            updateNumSelected();
        });


        // All / None user master check
        $("#clientMasterCheck").change(function() {
            var checked = $(this).is(":checked");
            $(".groupSelect").prop('checked', checked);
            updateNumSelected();
        });

        // Populate the toolbar
        // $("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');

        // All
        $("#selectAll").live('click', function() {
            $(".groupSelect").attr('checked', 'checked');
            updateNumSelected();
            return false;
        });

        // None
        $("#selectNone").live('click', function() {
            $(".groupSelect").attr('checked', false);
            updateNumSelected();
            return false;
        });




        // Delete Click
        $('#groupDelete').click(function() {
            $("#delete-clients").dialog('open');
            $("#deleteNum").html($(".groupSelect:checked").length);
        });

        // Delete dialog
        $("#delete-clients").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Proposals',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function() {

                        $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: {
                                    'ids': getSelectedIds()
                                },
                                url: "<?php echo site_url('ajax/clientGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            })
                            .success(function(data) {

                                if (data.success) {
                                    var deleteText = data.count + ' contacts were deleted';
                                    oTable.ajax.reload(null, false);
                                    $("#groupActionsButton").hide();
                                } else {
                                    var deleteText = 'An error occurred. Please try again';
                                }

                                $("#deleteClientsStatus").html(deleteText);
                                $("#delete-clients-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteClientsStatus").html('Deleting proposals...<img src="/static/loading.gif" />');
                        $("#delete-clients-status").dialog('open');
                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // Proposal Delete Update
        $("#delete-clients-status").dialog({
            width: 500,
            modal: true,
            buttons: {
                OK: function() {
                    $(this).dialog('close');

                    if ($('.reload_table').length) {
                        $('#child_resend').trigger('change');
                    } else {

                    }

                }
            },
            autoOpen: false
        });

        // Change Business Type
        $(".changeBusinessType").click(function() {
            $('.businessTypeMultiple').val('');
            $('.businessTypeMultiple').trigger("change");
            $("#change-business-type").dialog('open');
            $("#changeBusinessTypeNum").html($(".groupSelect:checked").length);
            $('.bt_on_proposal_p').hide();

            if (!$('#uniform-apply_bt_on_proposal').length) {
                $('#apply_bt_on_contact').uniform();
                $('#apply_bt_on_proposal').uniform();
            }
            $('#apply_bt_on_contact').prop('checked', false).uniform('refresh')
            $('#apply_bt_on_proposal').val('').trigger("change");
            return false;
        });

        // Prospect Business Type Update
        $("#change-business-type").dialog({
            width: 500,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button group_change_bt_popup_btn',
                    text: 'Save',
                    click: function() {
                        if ($('#apply_bt_on_contact').is(':checked')) {
                            var selected_account_ids = getSelectedIds();
                            $.post("<?php echo site_url('ajax/getClientsProposalCount') ?>", {
                                ids: selected_account_ids
                            }, function(proposal_count) {
                                var bt_value = $('.businessTypeMultiple option:selected').map(function(i, v) {
                                    return this.value;
                                }).get();
                                if (bt_value && bt_value.length > 1) {

                                    var btName = $("#apply_bt_on_proposal option:selected").text();
                                } else {
                                    var btName = $(".businessTypeMultiple option:selected").text();
                                }
                                var selected_account = $('#changeBusinessTypeNum').text();
                                var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>" +
                                    "<table style='text-align: left;line-height: 25px;width:100%'><tr><th style='text-align: right;width:30%'>Client:</th><td style='padding-left:10px'>" + selected_account + " selected</td></tr>" +
                                    "<tr><th style='text-align: right;'>New Business Type:</th><td style='padding-left:10px'>" + btName + "</td></tr>" +
                                    "<tr><th style='text-align: right;'>Proposals Affected:</th><td style='padding-left:10px'>" + proposal_count + "</td></tr></table>"
                                swal({
                                    title: "WARNING!",
                                    text: table,
                                    width: 700,
                                    showCancelButton: true,
                                    confirmButtonText: 'Save',
                                    cancelButtonText: "Cancel",
                                    dangerMode: false,
                                }).then(function(isConfirm) {
                                    if (isConfirm) {
                                        $("#changeBusinessTypeStatus").html('Updating Business Type, please wait...  <img src="/static/loading.gif" />');
                                        $.ajax({
                                            type: "POST",
                                            async: true,
                                            cache: false,
                                            data: {
                                                'ids': getSelectedIds(),
                                                businessTypes: $('.businessTypeMultiple').val(),
                                                apply_bt_on_contact: ($('#apply_bt_on_contact').is(':checked')) ? '1' : '0',
                                                apply_bt_on_proposal: $('#apply_bt_on_proposal').val()
                                            },
                                            url: "<?php echo site_url('ajax/groupClientsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                            dataType: "JSON"
                                        }).success(function(data) {
                                            $("#changeBusinessTypeStatus").html('Done!');
                                            //document.location.reload();
                                            oTable.ajax.reload();
                                            $("#change-business-type").dialog('close');
                                            swal('', 'Business Type Updated');
                                            $("#changeBusinessTypeStatus").html('');
                                            $("#groupActionsButton").hide();
                                        });
                                    } else {
                                        return false;
                                    }
                                });
                            });
                        } else {
                            $("#changeBusinessTypeStatus").html('Updating Business Type, please wait...  <img src="/static/loading.gif" />');
                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: {
                                    'ids': getSelectedIds(),
                                    businessTypes: $('.businessTypeMultiple').val(),
                                    apply_bt_on_contact: ($('#apply_bt_on_contact').is(':checked')) ? '1' : '0',
                                    apply_bt_on_proposal: $('#apply_bt_on_proposal').val()
                                },
                                url: "<?php echo site_url('ajax/groupClientsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function(data) {
                                $("#changeBusinessTypeStatus").html('Done!');
                                //document.location.reload();
                                oTable.ajax.reload();
                                $("#change-business-type").dialog('close');
                                swal('', 'Business Type Updated');
                                $("#changeBusinessTypeStatus").html('');
                                $("#groupActionsButton").hide();
                            });
                        }
                    }
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });

        $(document).on('change', ".businessTypeMultiple", function() {
            var bt_value = $('.businessTypeMultiple').val();
            var btn_disable = true;
            if (bt_value && bt_value.length > 1) {
                if (jQuery.inArray($("#apply_bt_on_proposal").val(), bt_value) == -1) {
                    $("#apply_bt_on_proposal").val('').trigger('change');
                }

                $("#apply_bt_on_proposal").children('option').hide();
                for ($i = 0; $i < bt_value.length; $i++) {
                    $("#apply_bt_on_proposal").children("option[value=" + bt_value[$i] + "]").show()
                }
                $("#apply_bt_on_proposal").children("option[value='']").show();

                if ($('#apply_bt_on_contact').is(':checked')) {


                    $('.bt_on_proposal_p').show();
                    if ($('#apply_bt_on_proposal').val()) {
                        btn_disable = true;

                    } else {
                        btn_disable = false;

                    }
                } else {
                    btn_disable = true;
                }
            } else if (bt_value && bt_value.length == 1) {
                btn_disable = true;
                $('.bt_on_proposal_p').hide();
            } else {
                btn_disable = false;

            }

            if (btn_disable) {
                $('.group_change_bt_popup_btn').prop('disabled', false);
                $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
            } else {
                $('.group_change_bt_popup_btn').prop('disabled', true);
                $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
            }

        });

        $(document).on('change', "#apply_bt_on_proposal", function() {
            if ($('#apply_bt_on_proposal').val()) {
                $('.group_change_bt_popup_btn').prop('disabled', false);
                $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
            } else {
                $('.group_change_bt_popup_btn').prop('disabled', true);
                $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
            }
        });

        $(document).on('change', "#apply_bt_on_contact", function() {
            if ($('#apply_bt_on_contact').is(':checked')) {
                var bt_value = $('.businessTypeMultiple').val();
                if (bt_value && bt_value.length > 1) {
                    $('.group_change_bt_popup_btn').prop('disabled', true);
                    $('.group_change_bt_popup_btn').addClass('ui-state-disabled');
                    $('.bt_on_proposal_p').show();
                }
            } else {
                $('.bt_on_proposal_p').hide();
                $('.group_change_bt_popup_btn').prop('disabled', false);
                $('.group_change_bt_popup_btn').removeClass('ui-state-disabled');
            }
        })



        // changes start----------------------------------------------//


        // Group Email action button
        $('#groupEmail').click(function() {

            var clientIds = getSelectedIds();
            if(clientIds.length > 500){
                swal('','Please select maximum 500 Clients');
                return false;
            }

            $("#sendNum").html($(".groupSelect:checked").length);
            var include_count = 0;
            var exclude_count = 0;
            $(".groupSelect:checked").closest('tr').each(function() {

                if ($(this).find('.clientsTableDropdownToggle').attr('data-client-excluded') == 1) {
                    exclude_count = exclude_count + 1;
                } else {
                    include_count = include_count + 1;
                }

            })
            $("#sendExcludedEmail").prop('checked', false);
            if (exclude_count > 0) {
                $(".preconfirm-resend-btn").prop('disabled', false);
                $(".preconfirm-resend-btn").removeClass('ui-state-disabled');

                $("#resendExcludeNum").html(exclude_count);
                $("#resendIncludeNum").html(include_count);
                $("#sendNum").html($(".groupSelect:checked").length);
                $("#preconfirm-resend-clients").dialog('open');

                if (include_count == 0) {
                    $(".preconfirm-resend-btn").prop('disabled', true);
                    $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                }


            } else {
                $("#client-email").dialog('open');
                $('.new_resend_name_span').show();
                $(".no_campaign").show();
                $('#messageFromName').prop('disabled', false);
                $('#messageFromEmail').prop('disabled', false);
                $('#messageSubject').prop('disabled', false);
                $('#templateSelect').prop('disabled', false);
                $('.is_templateSelect_disable').hide();
                $('#emailCustom').prop('disabled', false);
                $("#resendSelect").val(0);
                $(".new_resend_name").val('<?= date("m/d/Y h:ia"); ?>');
                $("#resendSelect").trigger('change');
                $("#emailCC").prop('checked', false);
                if (!popup_ui) {
                    $('#templateSelect').uniform();
                    $('#resendSelect').uniform();
                    $('#templateFields').uniform();
                    $('#emailCC').uniform();
                    $('#emailCustom').uniform();
                    popup_ui = true;
                }
                get_client_resend_lists();
            }

            $('.groupActionsContainer').hide();



            return false;
        });


        // Clients Resend pre Confirm
        $("#preconfirm-resend-clients").dialog({
            width: 400,
            modal: true,
            buttons: {
                OK: {
                    text: 'Continue',
                    'class': 'btn ui-button update-button preconfirm-resend-btn',
                    click: function() {
                        $(this).dialog("close");
                        $("#client-email").dialog('open');
                        $('.new_resend_name_span').show();
                        $(".no_campaign").show();
                        $('#messageFromName').prop('disabled', false);
                        $('#messageFromEmail').prop('disabled', false);
                        $('#messageSubject').prop('disabled', false);
                        $('#templateSelect').prop('disabled', false);
                        $('.is_templateSelect_disable').hide();
                        $('#emailCustom').prop('disabled', false);
                        //CKEDITOR.instances.message.setReadOnly(false);
                        //$('#templateSelect').trigger('change');
                        $("#resendSelect").val(0)
                        $(".new_resend_name").val('<?= date("m/d/Y h:ia"); ?>')

                        $("#resendSelect").trigger('change')
                        $("#emailCC").prop('checked', false);
                        if (!popup_ui) {

                            $('#templateSelect').uniform();
                            $('#resendSelect').uniform();
                            $('#templateFields').uniform();
                            $('#emailCC').uniform();
                            $('#emailCustom').uniform();
                            popup_ui = true;
                        }
                        get_client_resend_lists();
                    }
                },

                Cancel: {
                    text: 'Cancel',
                    'class': 'btn ui-button left',

                    click: function() {
                        $(this).dialog("close");
                    }
                }
            },
            autoOpen: false
        });

        // update total number of emails have to be send
        $("#sendExcludedEmail").click(function() {
            var include_count = 0;
            if ($('#sendExcludedEmail').prop("checked")) {
                $(".preconfirm-resend-btn").prop('disabled', false);
                $(".preconfirm-resend-btn").removeClass('ui-state-disabled');
                $("#resendIncludeNum").html($(".groupSelect:checked").length);
            } else {
                $(".groupSelect:checked").closest('tr').each(function() {
                    if ($(this).find('.clientsTableDropdownToggle').attr('data-client-excluded') != 1) {
                        include_count += 1;
                    }

                })
                $("#resendIncludeNum").html(include_count);
                if (include_count == 0) {
                    $(".preconfirm-resend-btn").prop('disabled', true);
                    $(".preconfirm-resend-btn").addClass('ui-state-disabled');
                }
            }
        });


        // Send Email dialog
        $("#client-email").dialog({
            width: 950,
            modal: true,
            open: function() {

                $("#emailCustom").attr('checked', false);
                $(".emailFromOption").hide();
                tinymce.remove("#message");
                tinymce.init({
                    selector: "textarea#message",
                    menubar: false,
                    elementpath: false,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: true,
                    browser_spellcheck: true,
                    contextmenu: false,
                    height: '320',
                    plugins: "link image code lists paste preview ",
                    toolbar: tinyMceMenus.email,
                    forced_root_block_attrs: tinyMceMenus.root_attrs,
                    fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });

                // $.uniform.update();
                //initUI();
            },
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function() {

                        
                        if ($("#emailCustom").attr('checked')) {

                            if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                                alert('Please enter a from name and email address');
                                return false;
                            }
                        }

                        if ($('#resendSelect').val() == 0 && !$('.new_resend_name').val()) {
                            alert('Please enter Resend Name');
                            return false;
                        }
                        $("#emailClientsStatus").html('Sending Contact emails...<img src="/static/loading.gif" />');
                        $("#email-clients-status").dialog('open');

                        $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: {
                                    'ids': getSelectedIds(),
                                    'subject': $("#messageSubject").val(),
                                    'fromName': $("#messageFromName").val(),
                                    'fromEmail': $("#messageFromEmail").val(),
                                    'body': tinyMCE.get('message').getContent(),
                                    'resendId': $("#resendSelect").val(),
                                    'new_resend_name': $(".new_resend_name").val(),
                                    'clientFilter': clientFilter,
                                    'exclude_override': $('#sendExcludedEmail').prop("checked") ? 1 : 0,
                                },

                                url: "<?php echo site_url('ajax/clientGroupEmail') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            })
                            .success(function(data) {

                                if (data.success) {
                                    var sendText = 'Your Emails are being sent';
                                    // var sendText = '<span style="font-weight:bold">'+data.count + ' emails were sent</span>';
                                    // if (data.duplicateEmailCount) {
                                    //     sendText += "<br /><br />" + data.duplicateEmailCount + " email(s) were not sent as they were duplicate email addresses."
                                    // }
                                } else {
                                    var sendText = 'An error occurred. Please try again';
                                }

                                $("#emailClientsStatus").html(sendText);
                                $("#email-clients-status").dialog('open');

                            });
                        $(this).dialog('close');


                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });




        // changes end------------------------------------------------------//


        $("#emailCustom").change(function() {
            if ($("#emailCustom").attr('checked')) {
                $(".emailFromOption").show();
            } else {
                $(".emailFromOption").hide();
                $(".emailFromOption input").val('');
            }
        });

        // EMail confirmation dialog
        $("#email-clients-status").dialog({
            width: 500,
            modal: true,
            buttons: {
                OK: function() {
                    oTable.ajax.reload();
                    $(this).dialog('close');
                    $(".groupSelect").prop('checked', false);
                    updateNumSelected();
                }
            },
            autoOpen: false
        });




        // Template change handler
        $('#templateSelect').change(function() {
            var selectedTemplate = $('#templateSelect option:selected').data('template-id');
            loadTemplateContents(selectedTemplate);
        });

        // Load the selected content
        var defaultTemplate = $('#templateSelect option:selected').data('template-id');
        //loadTemplateContents(defaultTemplate);

        function loadTemplateContents(templateId) {

            $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'templateId': templateId
                    },
                    url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                })
                .success(function(data) {
                    $("#messageSubject").val(data.templateSubject);
                    //CKEDITOR.instances.message.setData(data.templateBody);
                    tinymce.get('message').setContent(data.templateBody);
                });

            //$.uniform.update();
            //initUI();
        }




        /* contact Reassigning */

        // The initial Dialog
        $("#clients-reassign").dialog({
            width: 500,
            modal: true,
            autoOpen: false,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button',
                    text: 'Reassign',
                    click: function() {

                        if ($("#reassignTo").val() > 0) {
                            // Send the request
                            var reassignProposal = $('.reassignProposalCheckbox').prop('checked') ? '1' : '0';

                            $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {
                                        'ids': getSelectedIds(),
                                        'reassignTo': $("#reassignTo").val(),
                                        'reassignProposal': reassignProposal
                                    },
                                    url: "<?php echo site_url('ajax/clientGroupReassign') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                .success(function(data) {
                                    // Set the feedback text
                                    if (data.success) {
                                        var reassignText = data.count + " contacts were reassigned";

                                        oTable.ajax.reload(null, false);
                                        $("#groupActionsButton").hide();
                                    } else {
                                        var reassignText = "An error occurred. Please try again";
                                    }
                                    // Apply the text
                                    $("#clientReassignStatus").html(reassignText);

                                    // Refresh the table
                                    oTable.ajax.reload(null, false);

                                });
                            // Hide select dialog
                            $("#clients-reassign").dialog('close');
                            // Show feedback
                            $("#clients-reassign-status").dialog('open');

                        }
                    }
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#clients-reassign-status").dialog({
            width: 500,
            modal: true,
            autoOpen: false,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            }
        });

        // Click handler
        $("#groupReassign").click(function() {
            // Reset the dropdown
            $("#reassignTo option:selected").prop("selected", false);
            $("#reassignTo option:first").prop("selected", "selected");

            $("#clients-reassign").dialog('open');
            $('.reassignProposalCheckbox').prop('checked', false);
        });

        // Reassign click handler
        $("#confirmReassignBtn").click(function() {
            // Proceed as long as a user is selected
            if ($("#reassignTo").val() > 0) {
                // Send the request
                var reassignProposal = $('.reassignProposalCheckbox').prop('checked') ? '1' : '0';
                console.log(reassignProposal);
                $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'reassignTo': $("#reassignTo").val(),
                            'reassignProposal': reassignProposal
                        },
                        url: "<?php echo site_url('ajax/clientGroupReassign') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                    .success(function(data) {
                        // Set the feedback text
                        if (data.success) {
                            var reassignText = data.count + " contacts were reassigned";

                            oTable.ajax.reload(null, false);
                            $("#groupActionsButton").hide();
                        } else {
                            var reassignText = "An error occurred. Please try again";
                        }
                        // Apply the text
                        $("#clientReassignStatus").html(reassignText);

                        // Refresh the table
                        oTable.ajax.reload(null, false);

                    });
                // Hide select dialog
                $("#clients-reassign").dialog('close');
                // Show feedback
                $("#clients-reassign-status").dialog('open');

            }
            return false;
        });


        /* Client Account Reassigning */

        // The initial Dialog
        $("#account-reassign").dialog({
            width: 500,
            modal: true,
            autoOpen: false,
            buttons: {
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });

        // Update Status Dialog
        $("#clients-reassign-account-status").dialog({
            width: 500,
            modal: true,
            autoOpen: false,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            }
        });

        // Click handler
        $("#groupAccount").click(function() {
            // Reset the dropdown
            $("#reassignAccountTo option:selected").prop("selected", false);
            $("#reassignAccountTo option:first").prop("selected", "selected");

            $("#account-reassign").dialog('open');
        });

        // Reassign click handler
        $("#confirmAccountReassignBtn").click(function() {

            // Proceed as long as a user is selected
            if ($("#reassignAccountTo").val() > 0) {

                // Send the request
                $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'reassignTo': $("#reassignAccountTo").val()
                        },
                        url: "<?php echo site_url('ajax/clientGroupAccountReassign') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                    .success(function(data) {
                        // Set the feedback text
                        if (data.success) {
                            var reassignText = data.count + " contacts were reassigned";
                            oTable.ajax.reload(null, false);
                            $("#groupActionsButton").hide();
                        } else {
                            var reassignText = "An error occurred. Please try again";
                        }
                        // Apply the text
                        $("#clientAccountReassignStatus").html(reassignText);

                        // Refresh the table
                        oTable.fnDraw();

                    });
                // Hide select dialog
                $("#account-reassign").dialog('close');
                // Show feedback
                $("#clients-reassign-account-status").dialog('open');

            }
            return false;
        });






        $(document).on('click', ".clientsTableDropdownToggle", function(e) {

            $('#newClientsPopup').html('');
            $('#newClientsPopup').show();
            $('.template_class').show();

            var template;

            var client_id = $(this).attr('data-client-id');
            var client_fullname = $(this).attr('data-client-fullname');
            var client_companyname = $(this).attr('data-client-companyname');
            var client_email = $(this).attr('data-email');
            var client_account = $(this).attr('data-account');

            var client_phone = $(this).attr('data-phone');
            var client_excluded = $(this).attr('data-client-excluded');
            var edit_permission = $(this).attr('data-client-edit-permission');


            template = $("#template").html();
            template = template.toString();

            template = template.replace(new RegExp('{clientId}', 'g'), client_id);
            template = template.replace(new RegExp('{clientfullName}', 'g'), client_fullname);
            template = template.replace(new RegExp('{clientCompanyName}', 'g'), client_companyname);
            template = template.replace(new RegExp('{clientEmail}', 'g'), client_email);

            template = template.replace(new RegExp('{clientAccount}', 'g'), client_account);
            template = template.replace(new RegExp('{clientPhone}', 'g'), client_phone);
            $('#newClientsPopup').html(template);
            if (client_excluded == 1) {
                $("#newClientsPopup").find('.exclude_resend_individual').css('display', 'none');
                $("#newClientsPopup").find('.include_resend_individual').css('display', 'block');
            } else {
                $("#newClientsPopup").find('.exclude_resend_individual').css('display', 'block');
                $("#newClientsPopup").find('.include_resend_individual').css('display', 'none');
            }

            if(edit_permission==0){
                $('#newClientsPopup').find('.edit_contact_li').addClass('disable_edit_contact');
            }else{
                $('#newClientsPopup').find('.edit_contact_li').removeClass('disable_edit_contact');
            }


        });


        $('body').click(function(event) {
            // console.log('fff')



            var $trigger3 = $("#clientsTableDropdownToggle");

            if ('clientsTableDropdownToggle' !== event.target.id && !$trigger3.has(event.target).length) {
                if ($(event.target).parents('#newClientsPopup').length == 0) {
                    if (event.target.id != 'newClientsPopup') {
                        $("#newClientsPopup").hide();
                    }
                }
            }

        });


        // Client Business Type Update
        $("#change-client-business-type").dialog({
            width: 510,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
                    text: 'Save',
                    click: function() {
                        if ($('#apply_client_bt_on_contact').is(':checked')) {
                            $.get("<?php echo site_url('ajax/getClientProposalCount') ?>/" + $('#business_client_id').val(), function(proposal_count) {
                                var bt_value = $('.clientBusinessTypeMultiple option:selected').map(function(i, v) {
                                    return this.value;
                                }).get();
                                if (bt_value && bt_value.length > 1) {

                                    var btName = $("#apply_client_bt_on_proposal option:selected").text();
                                } else {
                                    var btName = $(".clientBusinessTypeMultiple option:selected").text();
                                }
                                var selected_account = $('.change-bt-account-name').text();
                                var acName = $('#business_change_account_name').val();
                                var table = "</br><p style='text-align: center;'>You are about to change all business types of your existing proposals.</br></br>You can modify and change this later in a proposal filter.</p></br><hr></br>" +
                                    "<table style='text-align: left;line-height: 25px;width:100%'><tr><th style='text-align: right;width:30%'>Contact Name:</th><td style='padding-left:10px'>" + selected_account + "</td></tr>" +
                                    "<tr><th style='text-align: right;'>Account:</th><td style='padding-left:10px'>" + acName + "</td></tr>" +
                                    "<tr><th style='text-align: right;'>New Business Type:</th><td style='padding-left:10px'>" + btName + "</td></tr>" +
                                    "<tr><th style='text-align: right;'>Proposals Affected:</th><td style='padding-left:10px'>" + proposal_count + "</td></tr></table>"
                                swal({
                                    title: "WARNING!",
                                    text: table,
                                    width: 700,
                                    showCancelButton: true,
                                    confirmButtonText: 'Save',
                                    cancelButtonText: "Cancel",
                                    dangerMode: false,
                                }).then(function(isConfirm) {
                                    if (isConfirm) {

                                        swal({
                                            title: 'Saving..',
                                            allowEscapeKey: false,
                                            allowOutsideClick: false,
                                            timer: 20000,
                                            onOpen: () => {
                                                swal.showLoading();
                                            }
                                        })
                                        var businessTypes = $('.clientBusinessTypeMultiple option:selected').map(function(i, v) {
                                            return this.value;
                                        }).get();

                                        $.ajax({
                                            type: "POST",
                                            async: true,
                                            cache: false,
                                            data: {
                                                client_id: $('#business_client_id').val(),
                                                businessTypes: businessTypes,
                                                apply_bt_on_contact: ($('#apply_client_bt_on_contact').is(':checked')) ? '1' : '0',
                                                apply_bt_on_proposal: $('#apply_client_bt_on_proposal').val()
                                            },
                                            url: "<?php echo site_url('ajax/clientsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                            dataType: "JSON"
                                        }).success(function(data) {

                                            oTable.ajax.reload(null, false);
                                            $("#change-client-business-type").dialog('close');
                                            swal('', 'Business Type changed');

                                        });
                                    } else {
                                        return false;
                                    }
                                });
                            });
                        } else {

                            swal({
                                title: 'Saving..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 20000,
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            })
                            var businessTypes = $('.clientBusinessTypeMultiple option:selected').map(function(i, v) {
                                return this.value;
                            }).get();

                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: {
                                    client_id: $('#business_client_id').val(),
                                    businessTypes: businessTypes,
                                    apply_bt_on_contact: ($('#apply_client_bt_on_contact').is(':checked')) ? '1' : '0',
                                    apply_bt_on_proposal: $('#apply_client_bt_on_proposal').val()
                                },
                                url: "<?php echo site_url('ajax/clientsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function(data) {

                                oTable.ajax.reload(null, false);
                                $("#change-client-business-type").dialog('close');
                                swal('', 'Business Type changed');

                            });

                        }
                    }
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });

        $(document).on('click', ".manage_business_type", function() {
            var company_name = '<i class="fa fa-fw fa-user-o"></i> ' + $(this).closest('tr').find('.clientsTableDropdownToggle').attr('data-client-fullname');
            $('.change-bt-account-name').html(company_name);
            $('#business_change_account_name').val($(this).closest('tr').find('.clientsTableDropdownToggle').attr('data-client-companyname'))
            client_id = $(this).attr('rel');
            $('.clientBusinessTypeMultiple').val('');
            $(".clientBusinessTypeMultiple option").attr("disabled", false);
            $('.clientBusinessTypeMultiple').trigger("change");
            $('.client_bt_on_proposal_p').hide();

            disable_business_types = [];
            $('#apply_client_bt_on_contact').prop('checked', false);
            $.uniform.update($('#apply_client_bt_on_contact'));
            $('#apply_client_bt_on_proposal').val('');
            $.uniform.update($('#apply_client_bt_on_proposal'));
            $('#business_client_id').val(client_id);
            $.ajax({
                url: '<?php echo site_url('ajax/getClientBusinessTyeps') ?>',
                type: 'post',
                data: {
                    client_id: client_id
                },
                cache: false,
                dataType: 'JSON',
                success: function(response) {

                    if (response.success) {
                        var selected_bt = [];
                        var bts = response.business_types;
                        for ($i = 0; $i < bts.length; $i++) {
                            selected_bt.push(bts[$i]['business_type_id']);
                        }
                        //$('.clientBusinessTypeMultiple').empty();
                        $('.clientBusinessTypeMultiple').val(selected_bt);

                        disable_business_types = response.disable_business_types;
                        for ($i = 0; $i < disable_business_types.length; $i++) {
                            if ($(".clientBusinessTypeMultiple option[value=" + disable_business_types[$i] + "]").is(':selected')) {
                                $(".clientBusinessTypeMultiple option[value=" + disable_business_types[$i] + "]").attr("disabled", "disabled");
                            }
                        }

                        $('.clientBusinessTypeMultiple').trigger("change");
                        $(".tag_tiptip").tipTip({
                            defaultPosition: 'top'
                        });
                    }

                    $("#change-client-business-type").dialog('open');
                }
            });
            return false;

        });


        $(document).on('change', ".clientBusinessTypeMultiple", function() {
            var bt_value = $('.clientBusinessTypeMultiple option:selected').map(function(i, v) {
                return this.value;
            }).get();
            var btn_disable = true;
            if (bt_value && bt_value.length > 1) {
                if (jQuery.inArray($("#apply_client_bt_on_proposal").val(), bt_value) == -1) {
                    $("#apply_client_bt_on_proposal").val('').trigger('change');
                }

                $("#apply_client_bt_on_proposal").children('option').hide();
                for ($i = 0; $i < bt_value.length; $i++) {
                    $("#apply_client_bt_on_proposal").children("option[value=" + bt_value[$i] + "]").show()
                }
                $("#apply_client_bt_on_proposal").children("option[value='']").show();

                if ($('#apply_client_bt_on_contact').is(':checked')) {

                    $('.client_bt_on_proposal_p').show();
                    if ($('#apply_client_bt_on_proposal').val()) {
                        btn_disable = true;

                    } else {
                        btn_disable = false;

                    }
                } else {
                    btn_disable = true;
                }
            } else if (bt_value && bt_value.length == 1) {
                btn_disable = true;
                $('.client_bt_on_proposal_p').hide();
            } else {
                btn_disable = false;

            }

            if (btn_disable) {
                $('.change_bt_popup_btn').prop('disabled', false);
                $('.change_bt_popup_btn').removeClass('ui-state-disabled');
            } else {
                $('.change_bt_popup_btn').prop('disabled', true);
                $('.change_bt_popup_btn').addClass('ui-state-disabled');
            }


        });

        $(document).on('change', "#apply_client_bt_on_contact", function() {
            if ($('#apply_client_bt_on_contact').is(':checked')) {
                $(".clientBusinessTypeMultiple option").attr("disabled", false);
                $(".clientBusinessTypeMultiple").trigger('change')
                var bt_value = $('.clientBusinessTypeMultiple option:selected').map(function(i, v) {
                    return this.value;
                }).get();
                if (bt_value && bt_value.length > 1) {
                    $('.change_bt_popup_btn').prop('disabled', true);
                    $('.change_bt_popup_btn').addClass('ui-state-disabled');
                    $('.client_bt_on_proposal_p').show();
                }
            } else {
                for ($i = 0; $i < disable_business_types.length; $i++) {
                    $(".clientBusinessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("selected", true);
                    $(".clientBusinessTypeMultiple option[value='" + disable_business_types[$i] + "']").prop("disabled", true);
                }
                $(".clientBusinessTypeMultiple").trigger('change')
                $('.client_bt_on_proposal_p').hide();
                $('.change_bt_popup_btn').prop('disabled', false);
                $('.change_bt_popup_btn').removeClass('ui-state-disabled');
            }
            $(".tag_tiptip").tipTip({
                defaultPosition: 'top'
            });
        });

        $(document).on('change', "#apply_client_bt_on_proposal", function() {
            if ($('#apply_client_bt_on_proposal').val()) {

                $('.change_bt_popup_btn').prop('disabled', false);
                $('.change_bt_popup_btn').removeClass('ui-state-disabled');
            } else {

                $('.change_bt_popup_btn').prop('disabled', true);
                $('.change_bt_popup_btn').addClass('ui-state-disabled');
            }
        });

        $('#apply_client_bt_on_contact').uniform();
        $('#apply_client_bt_on_proposal').uniform();



        $("#groupExcludeResend").click(function() {

            swal({
                title: "Contacts Email Off?",
                text: "This will stop Proposal And Contact Campaign emails being sent to this Contact.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 20000,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '<?php echo site_url('ajax/groupClientsExcludeResend') ?>',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function(data) {

                            console.log(data);
                            swal(data.count + ' Contacts Email Off');
                            oTable.ajax.reload(null, false);

                        },
                        error: function(jqXhr, textStatus, errorThrown) {
                            swal("Error", "An error occurred Please try again");
                            console.log(errorThrown);
                        }
                    })


                } else {
                    swal("Cancelled", "Your Clients not Changed :)", "error");
                }
            });

        });

        $("#groupIncludeResend").click(function() {

            swal({
                title: "Contacts Email On?",
                text: "Allow Proposal And Contact Campaign emails to be sent to this Contact.",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 20000,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '<?php echo site_url('ajax/groupClientsIncludeResend') ?>',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'ids': getSelectedIds(),
                        },

                        success: function(data) {

                            console.log(data);
                            swal(data.count + ' Contacts Email On');
                            oTable.ajax.reload(null, false);

                        },
                        error: function(jqXhr, textStatus, errorThrown) {
                            swal("Error", "An error occurred Please try again");
                            console.log(errorThrown);
                        }
                    })


                } else {
                    swal("Cancelled", "Your Clients not changed :)", "error");
                }
            });

        });



    }); //end ready

    $(document).on("keyup", ".new_resend_name", function(e) {

        if ($(this).val()) {
            $(this).removeClass('error');
        } else {

            if ($("#resendSelect").val() == 0) {
                $(this).addClass('error');
            }
        }

    });

    $(document).on("click", ".email_events", function(e) {
        $('#newClientsPopup').hide();
        var client_id = $(this).attr('data-client-id');
        var client_name = $(this).attr('data-contact-name');
        var client_account_name = $(this).attr('data-account');
        var table = '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Account: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >' + client_account_name + '</a></span></span>' +
            '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">' + client_name + '</a></span></span></p><br><hr/><div><div id="historyTableLoader" style="position: absolute;right: 100px;display: none;top: 44px;"><img src="/static/blue-loader.svg" /></div><a class="btn right blue-button reload_history_table" href="javascript:void(0);" style="border-radius: 5px;padding: 5px 10px 5px 10px;font-size: 14px;margin-bottom: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload</a></div>' +

            '<table id="email_events_table" style="width:100%" ><thead><tr><th>Sent</th><th>Subject</th><th>From</th><th>To</th><th class="delivery_column"><div class="badge blue tiptiptop" title="Delivery Status">D</div></th><th class="delivery_column"><div class="badge green tiptiptop" title="Open Status">O</div></th><th class="delivery_column"><i class="fa fa-envelope-o"></i></th></tr></thead><tbody>';


        table += '</tbody></table><div style="display:none;" id="email_event_email_content_div"><div style="width:100%;float:left;font-size: 15px;margin-bottom: 15px;text-align:left;"><div style="width:30%;float:left;"><strong>Subject: </strong><span class="content_div_subject">Test subject</span></div><div style="width:30%;float:left;"><strong>From: </strong><span class="content_div_from">Sunil yadav</span></div><div style="width:30%;float:left;"><strong>To: </strong><span class="content_div_to">test@gmail.com</span></div><div style="width:10%;float:left;"><a style="font-size: 14px;margin-bottom: 5px;float:right;padding: 5px;position: relative;" class="show_email_event_table btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only " href="#" ><i class="fa fa-chevron-left"></i> Back</a></div><div style="width:100%;float:left;margin-top: 10px;font-size: 15px;margin-bottom: 15px;text-align:left;"><div style="width:30%;float:left;"><strong>Sent: </strong><span class="content_div_sent">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Delivered: </strong><span class="content_div_delievered">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Opened: </strong><span class="content_div_opened">07/14/20 1:24 PM</span></div><div style="width:10%"></div></div></div><div style="float:left;width: 100%;"><textarea id="event_email_content"></textarea></div></div>';

        swal({
            title: "<i class='fa fw fa-envelope'></i> Email History",
            html: table,

            showCancelButton: false,
            width: '950px',
            confirmButtonText: 'Ok',

            dangerMode: false,
            showCloseButton: true,
            onOpen: function() {


                //CKEDITOR.replace( 'event_email_content',{removePlugins: 'elementspath',readOnly:true,height:300} );
                //tinymce.init({selector: "#event_email_content",elementpath: false,menubar: false,statusbar: false,toolbar : false,height:'300',readonly : true});

                $('.swal2-modal').attr('id', 'send_proposal_popup')

                hTable = $('#email_events_table').on('processing.dt', function(e, settings, processing) {
                    if (processing) {
                        $("#historyTableLoader").show();
                    } else {
                        $("#historyTableLoader").hide();
                    }
                }).DataTable({
                    "processing": true,
                    "serverSide": true,

                    "ajax": "<?php echo site_url('ajax/get_client_email_events_table_data') ?>/" + client_id,
                    "columns": [
                        // 2 Date
                        {
                            width: '25%',
                            class: 'dtLeft pad_left_10'
                        }, // 3 Branch
                        {
                            width: '20%',
                            class: 'dtLeft'
                        }, // 4 Readable status
                        {
                            width: '10%',
                            class: 'dtLeft'
                        }, // 5 Status Link
                        {
                            width: '10%',
                            class: 'dtLeft'
                        },
                        {
                            width: '8%',
                            class: 'dtCenter',
                            sortable: false
                        },
                        {
                            width: '7%',
                            class: 'dtCenter',
                            sortable: false
                        },
                        {
                            width: '8%',
                            class: 'dtCenter',
                            sortable: false
                        },
                        // 7 Company
                    ],
                    "sorting": [
                        [0, "desc"]
                    ],
                    "jQueryUI": true,
                    "autoWidth": true,
                    "stateSave": false,
                    "paginationType": "full_numbers",
                    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, 1000],
                        [10, 25, 50, 100, 200, 500, 1000]
                    ],

                    "drawCallback": function(settings) {

                        initTiptip();

                    },


                });


            },

        })

    });

    $(document).on("click", ".reload_history_table", function(e) {
        hTable.ajax.reload(null, false)
    });

    $(document).on("click", ".email_event_email_show_span", function(e) {
        var event_id = $(this).attr('data-event-id');
        var sent_at = $(this).attr('data-sent');
        var delievered_at = $(this).attr('data-delivered');
        var opened_at = $(this).attr('data-opened');
        tinymce.remove('#event_email_content')
        tinymce.init({
            selector: "#event_email_content",
            elementpath: false,
            menubar: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            statusbar: false,
            toolbar: false,
            paste_as_text: true,
            height: '300',
            readonly: true
        });

        $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'event_id': event_id
                },
                url: "<?php echo site_url('ajax/get_email_event_email_content') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
            .success(function(data) {

                //CKEDITOR.instances.event_email_content.setData(data.email_content);
                tinymce.get("event_email_content").setContent(data.email_content)
                $('.content_div_subject').text(data.email_subject);
                $('.content_div_from').text(data.sender_name);
                $('.content_div_to').text(data.to_email ? data.to_email : '-');
                $('.content_div_sent').text(sent_at);
                $('.content_div_delievered').text(delievered_at);
                $('.content_div_opened').text(opened_at);
                $('#email_events_table_wrapper').hide();
                $('#email_event_email_content_div').show();
            });

    });

    $(document).on("click", ".show_email_event_table", function(e) {

        $('#email_events_table_wrapper').show();
        $('#email_event_email_content_div').hide();
    })


    function get_client_resend_lists() {

        $.ajax({
            url: '<?php echo site_url('ajax/get_client_resend_lists') ?>',
            type: "GET",

            dataType: "json",
            success: function(data) {
                console.log(data)
                var html = '<option value="">Select Resend Campaign</option><option value="0">New</option><option value="-1">No Campaign</option>';
                for ($i = 0; $i < data.length; $i++) {
                    html += '<option value="' + data[$i].id + '">' + data[$i].resend_name + '</option>'
                }

                if (data.length) {
                    $('.campaign_btn').show();
                }
                $("#resendSelect").html(html);
            }
        });

    }


    $("#resendSelect").live('change', function() {
        // alert('ff');return false;
        $(".no_campaign").show();
        if ($("#resendSelect").val() < 1) {
            $('.new_resend_name_span').show();
            $(".new_resend_name").prop('disabled', false);
            if ($(this).val() == 0) {
                $(".new_resend_name").val('<?= date("m/d/Y h:ia"); ?>');
            } else {
                $(".new_resend_name").val('');
                $(".no_campaign").hide();
            }
            $('#messageFromName').prop('disabled', false);
            $('#messageFromEmail').prop('disabled', false);
            $('#messageSubject').prop('disabled', false);
            $('#templateSelect').prop('disabled', false);

            $('.is_templateSelect_disable').hide();
            $("#emailCustom").prop("checked", false);
            $("#emailCC").prop("checked", false);
            $("#emailCustom").trigger('change');
            $("#templateSelect").trigger('change');
            //$("#resendSelect").val(0)


            $('#emailCC').prop('disabled', false);
            $('#emailCustom').prop('disabled', false);

            //CKEDITOR.instances.message.setReadOnly(false);
            tinymce.get('message').mode.set("design");
            //$.uniform.update();
            //initUI();

        } else {


            $.ajax({
                url: '<?php echo site_url('ajax/get_client_resend_details') ?>',
                type: "POST",
                data: {
                    "resend_id": $(this).val(),

                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    if (data.success) {
                        //refresh frame

                        $('#messageSubject').val(data.subject);
                        $('#messageSubject').prop('disabled', true);
                        $('#templateSelect').prop('disabled', true);
                        $(".new_resend_name").prop('disabled', true);
                        $('.is_templateSelect_disable').css('display', 'block');
                        if (data.email_cc == 1) {
                            $("#emailCC").prop("checked", true);
                            $('#emailCC').prop('disabled', true);
                            //$.uniform.update();
                            //initUI();
                        } else {
                            $("#emailCC").prop("checked", false);
                            $('#emailCC').prop('disabled', true);
                            //$.uniform.update();
                            //initUI();
                        }

                        $(".new_resend_name").val(data.resend_name);
                        if (data.custom_sendor == 1) {
                            $("#emailCustom").prop("checked", true);
                            $('#emailCustom').prop('disabled', true);

                            //$.uniform.update();
                            //initUI();
                            $('#messageFromName').val(data.custom_sendor_name);
                            $('#messageFromEmail').val(data.custom_sendor_email);
                        } else {
                            $("#emailCustom").prop("checked", false);
                            $('#emailCustom').prop('disabled', true);
                            //$.uniform.update();
                            //initUI();
                            $('#messageFromName').val('');
                            $('#messageFromEmail').val('');
                        }
                        $("#emailCustom").trigger('change');

                        $('#messageFromName').prop('disabled', true);
                        $('#messageFromEmail').prop('disabled', true);

                        //    CKEDITOR.instances.message.setData(data.email_content);
                        //    CKEDITOR.instances.message.setReadOnly(true);
                        tinymce.get('message').setContent(data.email_content);
                        tinymce.get('message').mode.set("readonly");

                    } else {
                        if (data.error) {
                            alert("Error: " + data.error);
                        } else {
                            alert('An error has occurred. Please try again later!')
                        }
                    }

                }
            });

        }
    });

    function loadTemplateContentsForEmail() {
        var defaultTemplate = $('#templateSelect option:selected').data('template-id');
        var client_id = $('.send_email_client_id').val();
        $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'templateId': defaultTemplate,
                    'client_id': client_id
                },
                url: "<?php echo site_url('account/ajaxGetClientTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
            .success(function(data) {
                $("#poup_email_subject").val(data.templateSubject);
                //CKEDITOR.instances.email_content.setData(data.templateBody);
                tinymce.get('email_content').setContent(data.templateBody);
            });
    }



    $(".close_column").click(function() {
        $("#newClientColumnFilters").hide();
        $(".column_show").attr('checked', false);
        var column_show = localStorage.getItem("client_column_show_1");

        if (column_show) {

            var column_show = column_show.split(',');

            for ($i = 0; $i < column_show.length; $i++) {
                $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
            }
            //$.uniform.update();
        } else {
            $(".column_show").attr('checked', true);
        }
    })



    $('body').click(function(event) {

        var $trigger = $("#tableColumnFilterButton");

        if ("tableColumnFilterButton" !== event.target.id && !$trigger.has(event.target).length) {
            if ($(event.target).parents('#newClientColumnFilters').length == 0) {
                if (event.target.id != 'newClientColumnFilters') {
                    $("#newClientColumnFilters").hide();


                    var column_show = localStorage.getItem("client_column_show_1");

                    if (column_show) {
                        $(".column_show").attr('checked', false);
                        var column_show = column_show.split(',');

                        for ($i = 0; $i < column_show.length; $i++) {
                            $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
                        }

                    } else {
                        $(".column_show").attr('checked', true);
                    }
                }

            }

        }

        var $trigger4 = $("#groupActionsButton");

        if ('groupActionsButton' !== event.target.id && !$trigger4.has(event.target).length) {
            $(".groupActionsContainer").hide();

        }


    });

    // All
    $("#select_p_column_all").live('click', function() {
        $(".column_show").attr('checked', 'checked');
        //$.uniform.update();
        //updateNumSelected()
        return false;
    });

    // None
    $("#select_p_column_none").live('click', function() {
        $(".column_show").attr('checked', false);
        //$.uniform.update();
        //updateNumSelected()
        return false;
    });

    $('.column_show_apply').click(function() {
        //  oTable.api().columns( [21] ).visible( false );
        oTable.columns([2,3,4,5,6,7,8,9,11]).visible(false);
        var favorite = [];
        $.each($("input[name='column_show']:checked"), function() {
            favorite.push($(this).val());
        });
        oTable.columns(favorite).visible(true);
        if (hasLocalStorage) {
            localStorage.setItem("client_column_show_1", favorite);
        }

        oTable.ajax.reload(null, false);
        $("#newClientColumnFilters").hide();

    });


    $(document).on("click", ".send_email_individual", function(e) {

        var client_id = $(this).attr('data-client-id');
        var client_name = $(this).attr('data-contact-name');
        var client_account_name = $(this).attr('data-account');
        var to_email = $(this).attr('data-email');
        $('#newClientsPopup').hide();

        tinymce.remove();
        swal({
            title: "<i class='fa fw fa-envelope'></i> Send Email",
            html: '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Account: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >' + client_account_name + '</a></span></span>' +
                '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">' + client_name + '</a></span></span></p><br><hr/>' +
                '<form id="send_proposal_email" >' +
                '<input type="hidden" class="" name="send_email" value="Send">' +
                '<input type="hidden" class="send_email_client_id" name="client_id" value="' + client_id + '">' +
                '<table class="boxed-table pl-striped" style="border-bottom:0px"; width="100%" cellpadding="0" cellspacing="0">' +
                '<tr>' +
                '<td><label style="width: 150px;text-align: left;"> Email Template <span>*</span></label><span class="cwidth4_container" style="float: left;"><select style="border-radius: 3px;padding: 0.4em;width: 314px;" id="sendTemplateSelect"><?php foreach ($clientTemplates as $template) { ?><option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo str_replace("'", "\\'", $template->getTemplateName()); ?></option><?php } ?></select></span></td>' +
                '<td></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label for="" style="width: 150px;text-align: left;"> To <span>*</span></label><input type="text" id="popup_email_to" name="to" class="text send_to tiptiptop"  title="Separate email addresses by commas" style="width: 300px; float: right;" required value="' + to_email + '"></td>' +
                '<td><label for="" style="width: 70px;text-align: left;"> BCC</label><input type="text" name="bcc" class="text input60 send_bcc tiptiptop" title="Separate email addresses by commas" style="width: 300px; float: right; margin-right: 0;" value=""></td>' +
                '</tr>' +
                '<tr>' +
                '<td><label for="" style="width: 70px;text-align: left;"> Subject <span>*</span></label><input type="text" name="subject" required class="text input60 number_field send_subject" title="Separate email addresses by commas" style="width: 300px; float: right;" id="poup_email_subject"  value=""></td>' +
                '<td></td>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="2"><br/><textarea cols="40" rows="10" id="email_content" name="message">Brief Description here...</textarea></td>' +
                '</tr>' +
                '</table>' +
                '</form>' +
                '<p style="font-size: 12px;font-weight: bold;padding: 10px 0px 8px 10px;"><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p>',

            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen: function() {

                loadTemplateContentsForEmail();

                tinymce.init({
                    selector: "#email_content",
                    menubar: false,
                    relative_urls: false,
                    elementpath: false,
                    remove_script_host: false,
                    convert_urls: true,
                    browser_spellcheck: true,
                    contextmenu: false,
                    paste_as_text: true,
                    height: '320',
                    setup: function(ed) {
                        ed.on('keyup', function(e) {
                            check_popup_validation()
                        });
                    },
                    plugins: "link image code lists paste preview ",
                    toolbar: tinyMceMenus.email,
                    forced_root_block_attrs: tinyMceMenus.root_attrs,
                    fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });


                $('.swal2-modal').attr('id', 'send_proposal_popup');
                // Tiptip the address inputs
                initTiptip();
                // Uniform the select
                $("#sendTemplateSelect").uniform();

            },

        }).then(function(result) {




            swal({
                title: 'Sending..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                    $('.swal2-modal').attr('id', '')
                }
            })
            var values, index;

            // Get the parameters as an array
            values = $("#send_proposal_email").serializeArray();

            // Find and replace `content` if there
            for (index = 0; index < values.length; ++index) {
                if (values[index].name == "message") {
                    //values[index].value = CKEDITOR.instances.email_content.getData();
                    values[index].value = tinyMCE.get('email_content').getContent();
                    break;
                }
            }
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: values,
                url: "<?php echo site_url('ajax/send_client_individual_email') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function(data) {
                swal('', 'Email Sent');
            });



        })



        return false;
    });



    $(document).on("keyup", "#poup_email_subject,#popup_email_to", function(e) {
        if ($(this).val()) {
            $(this).removeClass('error');

        } else {
            $(this).addClass('error');

        }
        check_popup_validation()

    });

    function check_popup_validation() {
        if (tinyMCE.get('email_content').getContent() == '' || $('#poup_email_subject').val() == '' || $('#popup_email_to').val() == '') {
            $('.send_popup_validation_msg').show();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
        } else {
            $('.send_popup_validation_msg').hide();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
        }
    }

    $(document).on("click", ".closeDropdownMenu1", function(e) {
        $('#newClientsPopup').hide();

        return false;
    });
    $(document).on('click', '#addAtCursorEdit', function() {
        //CKEDITOR.instances.message.insertText($("#templateFields").val());
        tinymce.get('message').execCommand('mceInsertContent', false, $("#templateFields").val());
    });

    function notes_tooltip() {

        $(".client_table_notes_tiptip").tipTip({
            delay: 200,
            maxWidth: "400px",
            context: this,
            defaultPosition: "right",
            content: function(e) {

                setTimeout(function() {
                    $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type: 'post',
                        data: {
                            relationId: notes_tiptip_client_id,
                            type: 'client'
                        },
                        cache: false,
                        success: function(response) {
                            $('#tiptip_content').html(response);
                            //console.log('ffffggg')
                        }
                    });
                }, 200);
                return 'Loading...';
            }
        });
    };

    $(document).on('mouseenter', ".client_table_notes_tiptip", function() {
        notes_tiptip_client_id = $(this).data('val');
        return false;

    });

    $(document).on('click', '.exclude_resend_individual', function() {
        var client_id = $(this).attr('data-client');
        $('#newClientsPopup').hide();
        swal({
            title: "Contact Email Off?",
            text: "This will stop Proposal And Contact Campaign emails being sent to this Contact.",
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 20000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '<?php echo site_url('ajax/clientIndividualExcludeResend') ?>',
                    type: "POST",
                    data: {
                        "client_id": client_id,
                    },

                    success: function(data) {


                        swal('', 'Contact Email Off from Resend campaign');
                        oTable.ajax.reload(null, false);

                    },
                    error: function(jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        console.log(errorThrown);
                    }
                })


            } else {
                swal("Cancelled", "Your Contact not Excluded :)", "error");
            }
        });

    });

    $(document).on('click', '.include_resend_individual', function() {
        var client_id = $(this).attr('data-client');
        $('#newClientsPopup').hide();
        swal({
            title: "Contact Email On?",
            text: "Allow Proposal And Contact Campaign emails to be sent to this Contact.",
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 20000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '<?php echo site_url('ajax/clientIndividualIncludeResend') ?>',
                    type: "POST",
                    data: {
                        "client_id": client_id,
                    },

                    success: function(data) {

                        swal('', 'Contact Emailsset to On');
                        oTable.ajax.reload(null, false);

                    },
                    error: function(jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        console.log(errorThrown);
                    }
                })


            } else {
                swal("Cancelled", "Your Contact was not Changed :)", "error");
            }
        });

    });
</script>