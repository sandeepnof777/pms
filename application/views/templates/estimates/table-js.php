<?php
    $url = 'ajax/ajaxEstimates';
    if (isset($tableStatus)) {
        $url = 'ajax/ajaxProposalsStatus';
    }
    $showPsa = false;
    if (isset($account)) {
        if ($account->getCompany()->hasPSA()) {
            $showPsa = true;
        }
    }
?>
<script type="text/javascript">

var showPsa = <?php echo var_export($showPsa) ?>;

$(document).ready(function() {

    $.fn.dataTable.ext.errMode = 'none';

    var ui = false;
    var templatesLoaded = false;
    var clearPreset = true;

    // Datatable structure
    var oTable = $('.dataTables-proposalsNew')
        .on('error.dt', function (e, settings, techNote, message) {
            $("#datatablesError").dialog('open');
        }).dataTable({
            "processing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url($url . '?') . 'action=' . $action . '&group=' . $group . "&client=" . $client; ?>&t=" + Math.floor((Math.random() * 100000) + 1),
            "aoColumns": [
                {"bSortable": false, "bSearchable": false},   // 0 Checkbox
                {"bSortable": false, "bSearchable": false},   // 1 Actions
                {"sType": "date-formatted"},                                   // 2 Date
                {"bVisible": false},                                            // 3 Branch
                {"bVisible": false},                                            // 4 Readable status
                {"sType": "html", "iDataSort": 4},                              // 5 Status Link
                null,                                                           // 6 Job Number
                {"sType": "html"},                                              // 7 Company
                null,                                                           // 8 Project name
                {"sType": "html", "iDataSort": 10},                             // 9 Formatted price
                {"bSearchable": false, "sType": "numeric", "bVisible": false},  // 10 Integer Price
                {"sType": "html"},                                              // 11 Contact
                {"sType": "html"},                                              // 12 Owner
                {"sType": "num", "bVisible": false},                           // 13 Change Date Int
                {"sType": "html", "iDataSort": 13},                             // 14 Date
                {"bVisible": false},                                            // 15 Proposal Id
                {"sType": "html", "iDataSort": 17, "sClass": 'dtCenter'},      // 16 Mail status
                {"sType": "num", "bVisible": false},                            // 17 Mail Status text
                {"sClass": 'dtCenter', "iDataSort": 19},                       // 18 delivery status
                {"bVisible": false},                                           // 19 delivery status time
                {"sClass": 'dtCenter', "iDataSort": 21},                       // 20 Open status
                {"bVisible": false},                                           // 21 open status time
                {"sClass": 'dtCenter', "iDataSort": 23, "bVisible": false},    // 22 audit view status time
                {"bVisible": false},
                    // 22 audit view status time
                                            // 23 Audit Status
            ],
            "aaSorting": [
                [2, "desc"]
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "bStateSave": true,
            "sPaginationType": "full_numbers",
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
            "aLengthMenu": [
                [10, 25, 50, 100, 200, 500, 1000],
                [10, 25, 50, 100, 200, 500, 1000]
            ],
            "iDeferLoading": 1,
            "oLanguage": {
                "sZeroRecords": "Loading your proposals...",
                "sEmptyTable": "No Proposals Found"
            },
            "fnDrawCallback": function (oSettings) {
                if (!ui) {
                    initUI();
                    ui = true;

                    if (!templatesLoaded) {
                        //();
                        //templatesLoaded = true;
                    }
                }
                //initButtons();
                //initTiptip();
                initStatusChange();
                tableSettings();
                updateNumSelected();
                if (oTable) {
                    $("#filterNumResults").text(oTable.fnSettings().fnRecordsDisplay());
                    numMappedProposals = oTable.fnSettings().fnRecordsDisplay();

                    // Only Update if map is visible
                    //updateMap(true);
                }
                $("#filterLoading").hide();
                $("#filterResults").show();


            }
        });

    oTable.fnSetColumnVis(22, showPsa, false);
    oTable.fnSetColumnVis(23, false, false);

    // Table functions //

    <?php if ($search) { ?>
    var jTable = $('.dataTables-proposalsNew').DataTable();
    jTable.search($('#search').val()).draw();
    <?php }

    // Statuses for dropdown
    $jsonStatuses = [];

    foreach ($statuses as $status) {
        $jsonStatuses['_' . $status->getId()] = $status->getName();
    }
    ?>

    // Status change
    function initStatusChange() {
        $('.change-proposal-status').each(function () {
            var id = $(this).attr('id');
            
            id = id.replace(/status_/g, '');
            var status_id = $(this).val();
            console.log(status_id );
            var url = '<?php echo site_url('ajax/changeEstimateStatus') ?>/' + id;
            var status = 'Click to Edit';
            $(this).editable(url, {
                //data: "{'Open':'Open','Won':'Won','Completed':'Completed','Lost':'Lost','Cancelled':'Cancelled','On Hold':'On Hold', 'Invoiced via QuickBooks':'Invoiced via QuickBooks'}",
                data: <?php echo json_encode($jsonStatuses); ?>,
                type: 'select',
                onblur: 'submit'
            });
        });
    }

    // Apply Filters by default
    applyFilter();

    /**
     *  Now that the same datasource is in use, some settings need to be applied based on the page
     */
    function tableSettings() {
        // Populate the toolbar
        $("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
    }

    // Group action selected numbers
    function updateNumSelected(){
        var num = $(".groupSelect:checked").length;
        // Hide the options if 0 selected
        if (num < 1) {
            $("#groupActionIntro").show();
            $(".groupAction").hide();
            $(".groupActionsContainer").hide();
        }
        else {
            $("#groupActionIntro").hide();
            $(".groupAction").show();
        }
        $("#numSelected").html(num);
    }

    // All
    $("#selectAll").live('click', function () {
        $(".groupSelect").attr('checked', 'checked');
        updateNumSelected();
        return false;
    });

    // None
    $("#selectNone").live('click', function () {
        $(".groupSelect").attr('checked', false);
        updateNumSelected();
        return false;
    });

    // Update the counter after each change
    $(".groupSelect").live('change', function () {
        updateNumSelected();
    });

    /* Proposal Deletion */
    $("#confirm-delete-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function(){
                $.ajax({
                    url: '<?php echo site_url('ajax/deleteProposal') ?>/' + $("#client-delete").attr('rel'),
                    type: "GET",
                    data: {},
                    dataType: "json"
                })
                    .done(function (data) {
                        // Remove the row if delete completed
                        if (data.deleteComplete) {
                            $("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').fadeOut('slow');
                        }

                        if (data.deleteRequested) {
                            $("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').find('.change-proposal-status').text(data.text);
                        }

                    })
                    .fail(function () {
                        alert('There was a problem communicating with the server. Please try again');
                    })
                    .always(function () {
                        $("#confirm-delete-message").dialog('close');
                    });
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".confirm-deletion").live('click', function () {
        $("#client-delete").attr('rel', $(this).attr('rel'));
        $("#confirm-delete-message").dialog('open');
        return false;
    });

    /**
     * Notes stuff here
     */
    $("#notes").dialog({
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        width: 700
    });
    $("#notes-client").dialog({
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        width: 700
    });
    $(".btn-notes, .view-notes").live('click', function () {
        var id = $(this).attr('rel');
        var frameUrl = '<?php echo site_url('account/notes/proposal') ?>/' + id;
        $("#notesFrame").attr('src', frameUrl);
        $("#relationId").val(id);
        $('#notesFrame').load(function () {
            $("#notes").dialog('open');
        });
        return false;
    });
    $(".client-notes").live('click', function () {
        var id = $(this).attr('rel');
        var frameUrl = '<?php echo site_url('account/notes/client') ?>/' + id;
        $("#notesFrame-client").attr('src', frameUrl);
        $("#relationId-client").val(id);
        $('#notesFrame-client').load(function () {
            $("#notes-client").dialog('open');
        });
        return false;
    });
    $("#add-note").submit(function () {
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText").val(),
                "noteType": 'proposal',
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
    $("#add-note-client").submit(function () {
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText-client").val(),
                "noteType": 'client',
                "relationId": $("#relationId-client").val()
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                    $("#noteText-client").val('');
                    $('#notesFrame-client').attr('src', $('#notesFrame-client').attr('src'));
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

    function resetDuplicateDialog() {
        $("#duplicate-selected-client").hide().find('strong').html('');
        $("#duplicate-select-client").show().find('input').val('');
        $(":button:contains('Duplicate')").prop("disabled", true).addClass("ui-state-disabled");
    }

    function resetCopyDialog() {
        $("#copy-selected-client").hide().find('strong').html('');
        $("#copy-select-client").show().find('input').val('');
        $(":button:contains('Copy')").prop("disabled", true).addClass("ui-state-disabled");
    }

    $("#duplicate-proposal").dialog({
        width: 550,
        modal: true,
        open: function () {
            //reset stuff
            resetDuplicateDialog();
        },
        buttons: {
            Duplicate: function () {
                var duplicate_estimate = $('#duplicate_estimate').is(":checked") ? '1' : '0';
                document.location.href = '<?php echo site_url('proposals/duplicate_proposal') ?>/' + $("#duplicate-proposal-id").val() + '/' + $("#duplicate-client-id").val()+'/0/'+duplicate_estimate;
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $("#copy-proposal").dialog({
        width: 550,
        modal: true,
        open: function () {
            //reset stuff
            resetDuplicateDialog();
        },
        buttons: {
            Copy: function () {
                var copy_estimate = $('#copy_estimate').is(":checked") ? '1' : '0';
                document.location.href = '<?php echo site_url('proposals/copy') ?>/' + $("#copy-proposal-id").val() + '/' + $("#copy-client-id").val()+'/'+copy_estimate;
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".duplicate-proposal").live('click', function () {
        
        $("#duplicate_estimate").prop("checked", false);
        $("#duplicate-proposal-id").val($(this).attr('rel'));
       
        if($(this).attr('data-has-estimate')==0){
            $('#duplicate_estimate_chackbox').hide();
        }else{
            $('#duplicate_estimate_chackbox').show();
        }
        $("#duplicate-proposal").dialog('open');
        return false;
    });
    $(".copy-proposal").live('click', function () {
        $("#copy_estimate").prop("checked", false);
       
       
        if($(this).attr('data-has-estimate')==0){
            $('#copy_estimate_chackbox').hide();
        }else{
            $('#copy_estimate_chackbox').show();
        }
        $("#copy-proposal-id").val($(this).attr('rel'));
        $("#copy-proposal").dialog('open');
        return false;
    });
    $("#duplicate-client").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    maxRows: 12,
                    startsWith: request.term
                },
                success: function (data) {
                    response($.map(data, function (item) {
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
            $("#tiptip_holder").fadeOut('fast');
            $("#duplicate-client-id").val(ui.item.value);
            $("#duplicate-selected-client").show().find('strong').html(ui.item.label);
            $("#duplicate-select-client").hide();
            $(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");
            event.preventDefault();
        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
    $("#copy-client").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    maxRows: 12,
                    startsWith: request.term
                },
                success: function (data) {
                    response($.map(data, function (item) {
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
            $("#tiptip_holder").fadeOut('fast');
            $("#copy-client-id").val(ui.item.value);
            $("#copy-selected-client").show().find('strong').html(ui.item.label);
            $("#copy-select-client").hide();
            $(":button:contains('Copy')").prop("disabled", false).removeClass("ui-state-disabled");
            event.preventDefault();
        },
        open: function () {
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
    $("#reset-duplicate-client-search").click(function () {
        resetDuplicateDialog();
    });
    $("#reset-copy-client-search").click(function () {
        resetCopyDialog();
    });


    //view client details functionality

    $("#dialog-message").dialog({
        width: 500,
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        beforeClose: function (event, ui) {
            $("#dialog-message span").html('');
        }
    });
    $('.viewClient').live('click', function () {
        var clientId = $(this).attr('rel');
        $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + clientId, function (data) {
            var items = [];
            $.each(data, function (key, val) {
                $("#field_" + key).html(val);
            });
        });
        $("#dialog-message").dialog("open");
    });

    /* Check that at least one proposal has been selected */
    function checkProposalsSelected() {
        var num = $(".groupSelect:checked").length;
        if (num > 0) {
            return true;
        }
        $("#no-proposals-selected").dialog('open');
        return false;
    }

    /* get a list of the selected IDs */
    function getSelectedIds() {
        var IDs = new Array();
        $(".groupSelect:checked").each(function () {
            IDs.push($(this).data('proposal-id'));
        });
        return IDs;
    }


    /*
     RESEND
     */

    $("#groupResend").click(function () {
        var proceed = checkProposalsSelected();

        if (proceed) {
            $("#resendNum").html($(".groupSelect:checked").length);
            $("#resend-proposals").dialog('open');
            $("#emailCC").prop('checked', false);
            $.uniform.update();
            $('.groupActionsContainer').hide();
        }

        return false;
    });


    // No proposals dialog
    $("#no-proposals-selected").dialog({
        width: 500,
        modal: true,
        buttons: {
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });


    // Proposal Resend options
    $("#emailCustom").change(function () {
        if ($("#emailCustom").attr('checked')) {
            $(".emailFromOption").show();
        }
        else {
            $(".emailFromOption").hide();
            $(".emailFromOption input").val('');
        }
    });

    // Resend dialog
    $("#resend-proposals").dialog({
        width: 950,
        modal: true,
        open: function () {
            $("#emailCustom").attr('checked', false);
            $(".emailFromOption").hide();
            $.uniform.update();
        },
        buttons: {
            "Resend": {
                text: 'Send Email',
                'class': 'btn ui-button update-button',
                'id': 'confirmResend',
                click: function () {

                    if ($("#emailCustom").attr('checked')) {

                        if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                            alert('Please enter a from name and email address');
                            return false;
                        }
                    }

                    // Make sure the undent is hidden
                    $("#unsentProposals").hide();
                    $("#unsentDetails").hide();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'emailCC': $("#emailCC").is(":checked"),
                            'subject': $("#messageSubject").val(),
                            'fromName': $("#messageFromName").val(),
                            'fromEmail': $("#messageFromEmail").val(),
                            'body': tinymce.get("message").getContent()
                        },
                        url: "<?php echo site_url('ajax/groupResend') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            var resendText = '';

                            if (data.success) {

                                resendText = data.count + ' proposal emails were sent';
                                $("#unsentProposals").hide();
                                $("#unsentDetails").hide();

                                if (data.unsent > 0) {
                                    var unsentText = data.unsent + ' proposal emails were not sent';
                                    $("#unsentProposals").text(unsentText).show();
                                    $("#unsentDetails").show()
                                }
                            }
                            else {
                                resendText = 'An error occurred. Please try again';
                            }

                            $("#resendProposalsStatus").html(resendText);
                            $("#unsentProposals").html(unsentText);
                            $("#resend-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                    $("#resend-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Price Modify
    $("#price-modifier-dialog").dialog({
        width: 450,
        modal: true,
        autoOpen: false,
        buttons: {
            "Apply": {
                html: '<i class="fa fa-fw fa-refresh"></i> Apply',
                'class': 'btn ui-button update-button',
                'id': 'applyPriceModify',
                click: function () {

                    var modifier = $("#priceModifierValue").val();
 
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'modifier': modifier
                        },
                        url: "<?php echo site_url('ajax/modifyPrices') ?>",
                        dataType: "JSON"
                    })
                    .success(function (data) {

                        $("#price-modifier-dialog").dialog('close');

                        if(!data.error) {
                            swal(data.count + ' proposals updated');
                            oTable.fnDraw();
                            updateNumSelected();
                        } else {
                            swal('An error occurred');
                        }

                        $(".groupActionsContainer").hide();
                    });

                }
            },
            "Cancel": {
                html: '<i class="fa fa-fw fa-close"></i> Cancel',
                'class': 'btn ui-button',
                'id': 'cancelModify',
                click: function () {
                    $(".groupActionsContainer").hide();
                    $(this).dialog('close');
                }
            }
        }
    });

    // Price Modify Click
    $("#groupPriceModify").click(function() {
        // Reset the modifier value
        $("#priceModifierValue").val('0.00');
        // Show the dialog
       $("#price-modifier-dialog").dialog('open');
    });

    // Resend text editor
    $(document).ready(function () {
        // var template_editor = CKEDITOR.replace('message', {
        //     //toolbar: 'Minimum',
        //     height: 200
        // });

        tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
                        relative_urls : false,
                        elementpath: false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'320',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                    });
    });

    /*
     * Group Actions Auto Re-Send START
     * All code below
     */

    //
    $("#groupResendSettings").on('click', function () {
        //reset form
        $("#automatic_resend").val(0);
        $("#frequency").val('<?= round($proposal_resend_frequency / 86400) ?>');
        $("#template").val(<?= $automatic_reminders_template ?>);
        //pop modal
        $("#groupResendSettingsModal").dialog("open");
    });

    $("#groupResendSettingsModal").dialog({
        width: 700,
        modal: true,
        open: function () {
            $("#emailCustom").attr('checked', false);
            $(".emailFromOption").hide();
            $.uniform.update();
        },
        buttons: {
            "Save": {
                text: 'Save',
                'class': 'btn ui-button update-button',
                'id': 'confirmResend',
                click: function () {
                    var frequency = $("#frequency").val();
                    if (isNaN(frequency) || frequency < 1) {
                        frequency = 1;
                    }
                    var data = {
                        ids: getSelectedIds(),
                        enabled: $("#automatic_resend").val(),
                        frequency: frequency,
                        template: $("#template").val()
                    };
                    //alert('Post Data: ' + JSON.stringify(data));
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('proposals/saveResendSettingsGroup') ?>",
                        data: data,
                        success: function () {
                            swal('success', 'Proposals Auto Re-Send Settings Updated!');
                            $("#groupResendSettingsModal").dialog("close");
                        },
                        error: function () {
                            swal('warning', 'There was an error processing the request. Please try again later.');
                        }
                    });
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    /*Group Actions Auto Re-Send END*/

    // Template change handler
    $('#templateSelect').change(function () {

        var selectedTemplate = $('#templateSelect option:selected').data('template-id');

        loadTemplateContents(selectedTemplate);
    });

    // Load the selected content
    var defaultTemplate = $('#templateSelect option:selected').data('template-id');
    // loadTemplateContents(defaultTemplate);

    function loadTemplateContents(templateId) {

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'templateId': templateId},
            url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
        .success(function (data) {
            $("#messageSubject").val(data.templateSubject);
            //CKEDITOR.instances.message.setData(data.templateBody);
            tinymce.get("message").setContent(data.templateBody);
        });

        $.uniform.update();
    }

    // Proposal Resend Update
    $("#resend-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    /*
     DELETE
     */


    $("#groupDelete").click(function () {

        var proceed = checkProposalsSelected();

        if (proceed) {
            $("#deleteNum").html($(".groupSelect:checked").length);
            $("#delete-proposals").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    // Resend dialog
    $("#delete-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Delete": {
                text: 'Delete Proposals',
                'class': 'btn ui-button update-button',
                'id': 'confirmDelete',
                click: function () {

                    var deleteDuplicates = ($("#deleteDuplicates").prop("checked")) ? 1 : 0;

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'deleteDuplicates': deleteDuplicates
                        },
                        url: "<?php echo site_url('ajax/groupDelete') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were deleted';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#deleteProposalsStatus").html(resendText);
                            $("#delete-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#deleteProposalsStatus").html('Deleting proposals...<img src="/static/loading.gif" />');
                    $("#delete-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        open: function () {
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'ids': getSelectedIds()},
                url: "<?php echo site_url('ajax/containsDuplicates') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
                .success(function (data) {
                    if (data.duplicates > 0) {
                        $('#deleteDuplicatesOption').show();
                    }
                    else {
                        $('#deleteDuplicatesOption').hide();
                    }
                });
        }
    });

    // Proposal Status Update
    $("#delete-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });


    $("#groupChangeStatus").click(function () {

        // Hide the win date options
        $("#statusWin").hide();
        // Reset to open
        $("#changeStatus").val(1);
        $.uniform.update();

        var proceed = checkProposalsSelected();

        if (proceed) {

            var statusChangeNum = $(".groupSelect:checked").length;
            var unwonCount = $('.groupSelect[data-won="0"]:checked').length;
            var wonCount = $('.groupSelect[data-won="1"]:checked').length;

            $("#statusChangeNum").text(statusChangeNum);
            $("#statusUnwonCount").text(unwonCount);
            $("#statusWonCount").text(wonCount);
            $("#status-proposals").dialog('open');
            $("#changeStatus").trigger('change');
        }
        $('.groupActionsContainer').hide();
    });

    $("#changeStatus").change(function() {

        if ($(this).find('option:selected').data('sales')) {
            var unwonCount = $('.groupSelect[data-won="0"]:checked').length;

            if (unwonCount > 0) {
                $("#statusWin").show();
            }
            $("#statusUnwin").hide();
        }
        else {
            var wonCount = $('.groupSelect[data-won="1"]:checked').length;
            $("#statusWin").hide();
            if (wonCount > 0) {
                $("#statusUnwin").show();
            }

        }
    });

    // Status dialog
    $("#status-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Update": {
                text: 'Update Proposals',
                'class': 'btn ui-button update-button',
                'id': 'confirmStatus',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'status': $("#changeStatus").val(),
                            'statusWinDate' : $("#statusWinDate").val()
                        },
                        url: "<?php echo site_url('ajax/groupStatusChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"

                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#statusProposalsStatus").html(resendText);
                            $("#status-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#statusProposalsStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#status-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Proposal Delete Update
    $("#status-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    // Unduplicate
    $("#groupUnduplicate").click(function () {
        $("#status-unduplicate").dialog('open');
        $('.groupActionsContainer').hide();
    });

    $("#status-unduplicate").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {'ids': getSelectedIds()},
                        url: "<?php echo site_url('ajax/groupStandalone') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#standaloneStatus").html(resendText);
                            $("#standalone-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#standaloneStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#standalone-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#standalone-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    /* Status Date Change */

    $("#sdcDate").datepicker();

    $("#groupStatusChangeDate").click(function () {
        $("#status-date-change-confirm").dialog('open');
        $('.groupActionsContainer').hide();
    });


    $("#status-date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var changeDate = $("#sdcDate").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'changeDate': changeDate
                        },
                        url: "<?php echo site_url('ajax/groupStatusDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#sdcStatus").html(resendText);
                            $("#sdc-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#sdc-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#sdc-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });


    // Creation Date change
    $("#dcDate").datepicker();

    $("#groupChangeDate").click(function () {
        $("#date-change-confirm").dialog('open');
        $('.groupActionsContainer').hide();
    });

    $("#date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var changeDate = $("#dcDate").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'changeDate': changeDate
                        },
                        url: "<?php echo site_url('ajax/groupDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#sdcStatus").html(resendText);
                            $("#sdc-status").dialog('open');

                        });

                    $(this).dialog('close');
                    $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#sdc-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#dc-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });


    /* Reassigning */

    // Reassign dialog
    $("#reassign-proposals").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Update": {
                text: 'Reassign',
                'class': 'btn ui-button update-button',
                'id': 'confirmReassign',
                click: function () {
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {'ids': getSelectedIds(), 'userId': $("#reassignUser").val()},
                        url: "<?php echo site_url('ajax/groupProposalReassign') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"

                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' proposals were updated';
                            }
                            else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#reassignProposalsStatus").html(resendText);
                            $("#reassign-proposals-status").dialog('open');

                        });
                    $(this).dialog('close');
                    $("#reassignProposalsStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                    $("#reassign-proposals-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Reassign Status Dialog
    $("#reassign-proposals-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    // Handle the click
    $("#groupReassign").click(function () {
        $("#reassign-proposals").dialog('open');
        $('.groupActionsContainer').hide();
    });

    // ProposalActivity Dialog
    $("#proposalActivity").dialog({
        width: 800,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false,
        position: 'top',
        open: function(event, ui) {
            $(this).parent().css({'top': window.pageYOffset + 150});
        },
    });

    function getUndeliveredIds() {
        var IDs = new Array();
        $(".noDelivery").each(function () {
            IDs.push($(this).data('proposal_id'));
        });
        return IDs;
    }

    // Check delivery status
    setInterval(function () {

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'ids': getUndeliveredIds()},
            url: "<?php echo site_url('ajax/deliveryStatus') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
            .success(function (data) {
                $.each(data, function (index, value) {
                    $('#noDelivery_' + index).html('<span class="badge blue tiptipleft" title="Delivered: ' + value + '">D</span>')
                });
                initTiptip();
            });
    }, 15000);


    function applyFilter() {

        if (clearPreset) {
            $(".proposalFilterPreset").addClass('grey');
        }
        else {
            clearPreset = true
        }

        $("#filterResults").hide();
        $("#filterLoading").show();
        setTimeout(function () {
            $("#reset-filter").show();

            var statuses = [];
            var statusValues = [];
            if ($(".statusFilterCheck:checked").length != $(".statusFilterCheck").length) {
                statuses = $(".statusFilterCheck:checked").map(function () {
                    statusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!statuses.length) {
                statuses = [];
            }

            // Estimate Status
            var estimateStatuses = [];
            var estimateStatusValues = [];
            if ($(".estimateStatusFilterCheck:checked").length != $(".estimateStatusFilterCheck").length) {
                estimateStatuses = $(".estimateStatusFilterCheck:checked").map(function () {
                    estimateStatusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!estimateStatuses.length) {
                estimateStatuses = [];
            }

            var users = [];
            var userValues = [];
            if ($(".userFilterCheck:checked").not('.branchFilterCheck').length != $(".userFilterCheck").not('.branchFilterCheck').length) {
                users = $(".userFilterCheck:checked").not('.branchFilterCheck').map(function () {
                    userValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!users.length) {
                users = [];
            }

            var branches = [];
            branches = $(".branchFilterCheck:checked").map(function () {
                return $(this).data('branch-id');
            }).get();

            var clientAccounts = [];
            var clientAccountValues = [];

            var clientAccounts = $(".clientAccountFilterCheck:checked").map(function () {
                clientAccountValues.push($(this).data('text-value'));
                return $(this).val();
            }).get();

            if (!clientAccounts.length) {
                clientAccounts = [];
            }

            var services = [];
            var serviceValues = [];
            if ($(".serviceFilterCheck:checked").length != $(".serviceFilterCheck").length) {
                services = $(".serviceFilterCheck:checked").map(function () {
                    serviceValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
            }
            if (!services.length) {
                services = [];
            }


            var queues = [];
            var queueValues = [];
            var emailStatuses = [];
            var emailStatusValues = [];

            if ($(".otherFilterCheck:checked").length != $(".otherFilterCheck").length) {
                queues = $(".queueFilterCheck:checked").map(function () {
                    queueValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!queues.length) {
                    queues = [];
                }

                emailStatuses = $(".emailFilterCheck:checked").map(function () {
                    emailStatusValues.push($(this).data('text-value'));
                    return $(this).val();
                }).get();
                if (!emailStatuses.length) {
                    emailStatuses = [];
                }
            }

            // Bid Range
            var minBid = $("#pMinBid").val();
            var maxBid = $("#pMaxBid").val();

            // Created Range
            var createdFrom = $("#pCreatedFrom").val();
            var createdTo = $("#pCreatedTo").val();

            // Activity Range
            var activityFrom = $("#pActivityFrom").val();
            var activityTo = $("#pActivityTo").val();

            var filterBadgeHtml = '';
            var createdHeaderText = ' [ All ]';
            var activityHeaderText = ' [ All ]';
            var priceRangeHeaderText = ' [ All ]';
            var statusHeaderText = ' [ All ]';
            var estimateStatusHeaderText = ' [ All ]';
            var userHeaderText = ' [ All ]';
            var accountHeaderText = ' [ All ]';
            var serviceHeaderText = ' [ All ]';
            var otherHeaderText = ' [ All ]';
            var numFilters = 0;

            // Info boxes

            // Created Date Range
            if ($("#pCreatedFrom").val() || $("#pCreatedTo").val()) {
                numFilters++;
                var fromDateString;
                var toDateString;
                var createdRangeString;


                if ($("#pCreatedFrom").val() && $("#pCreatedTo").val()) {

                    fromDateString = $("#pCreatedFrom").val();
                    toDateString = $("#pCreatedTo").val();
                    createdRangeString = fromDateString + ' - ' + toDateString;
                }
                else if ($("#pCreatedFrom").val()) {
                    fromDateString = $("#pCreatedFrom").val();
                    createdRangeString = 'After ' + fromDateString;
                }
                else {
                    toDateString = $("#pCreatedTo").val();
                    createdRangeString = 'Before ' + toDateString;
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Created: </div>' +
                    '<div class="filterBadgeContent">' +
                    createdRangeString +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeCreatedFilter">&times;</a></div>' +
                    '</div>';

                createdHeaderText = createdRangeString;
                $('#createdFilterHeader').addClass('activeFilter');
            } else {
                $('#createdFilterHeader').removeClass('activeFilter');
            }
            $("#createdHeaderText").text(createdHeaderText);

            // Activity Date Range
            if ($("#pActivityFrom").val()) {
                numFilters++;

                var fromDateString = $("#pActivityFrom").val();
                var toDateString = $("#pActivityTo").val();
                var activityRangeString = fromDateString + ' - ' + toDateString;

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Activity: </div>' +
                    '<div class="filterBadgeContent">' +
                    activityRangeString +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeActivityFilter">&times;</a></div>' +
                    '</div>';

                activityHeaderText = activityRangeString;
                $('#activityFilterHeader').addClass('activeFilter');
            } else {
                $('#activityFilterHeader').removeClass('activeFilter');
            }
            $("#activityHeaderText").text(activityHeaderText);


            // Price Range
            if (($("#pMinBid").val() != $("#pMinBid").data('original-value')) || ($("#pMaxBid").val() != $("#pMaxBid").data('original-value'))) {
                numFilters++;

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Price Range: </div>' +
                    '<div class="filterBadgeContent">' +
                    $("#priceRangeText").text() +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removePriceFilter">&times;</a></div>' +
                    '</div>';

                priceRangeHeaderText = $("#priceRangeText").text();
                $('#priceRangeFilterHeader').addClass('activeFilter');
            } else {
                $('#priceRangeFilterHeader').removeClass('activeFilter');
            }
            $("#priceRangeHeaderText").text(priceRangeHeaderText);


            // Status
            if (statusValues.length) {
                numFilters++;
                $('#statusFilterHeader').addClass('activeFilter');

                var statusBadgeText = '[' + statusValues.length + ']';

                if (statusValues.length == $(".statusFilterCheck").length) {
                    statusBadgeText = 'All';
                }

                if (statusValues.length == 1) {
                    statusBadgeText = statusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Status: </div>' +
                    '<div class="filterBadgeContent">' +
                    statusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                    '</div>';

                statusHeaderText = '[' + statusValues.length + ']';

            }
            else {
                $('#statusFilterHeader').removeClass('activeFilter');
            }
            $("#statusHeaderText").text(statusHeaderText);

            // stimate Status
            if (estimateStatusValues.length) {
                numFilters++;
                $('#estimateStatusFilterHeader').addClass('activeFilter');

                var estimateStatusBadgeText = '[' + estimateStatusValues.length + ']';

                if (estimateStatusValues.length == $(".estimateStatusFilterCheck").length) {
                    estimateStatusBadgeText = 'All';
                }

                if (estimateStatusValues.length == 1) {
                    estimateStatusBadgeText = estimateStatusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Estimate: </div>' +
                    '<div class="filterBadgeContent">' +
                    estimateStatusBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                    '</div>';

                estimateStatusHeaderText = '[' + estimateStatusValues.length + ']';

            }
            else {
                $('#estimateStatusFilterHeader').removeClass('activeFilter');
            }
            $("#estimateStatusHeaderText").text(statusHeaderText);

            // User
            if (userValues.length) {
                numFilters++;
                $('#userFilterHeader').addClass('activeFilter');

                var userBadgeText = '[' + userValues.length + ']';

                if (userValues.length == $(".userFilterCheck").not('.branchFilterCheck').length) {
                    userBadgeText = 'All';
                }

                if (userValues.length == 1) {
                    userBadgeText = userValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Users: </div>' +
                    '<div class="filterBadgeContent">' +
                    userBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeUserFilter">&times;</a></div>' +
                    '</div>';


                userHeaderText = '[' + userValues.length + ']';

            } else {
                $('#userFilterHeader').removeClass('activeFilter');
            }
            $("#userHeaderText").text(userHeaderText);

            // Account
            if (clientAccountValues.length) {
                numFilters++;
                $('#accountFilterHeader').addClass('activeFilter');

                var accountBadgeText = '[' + clientAccountValues.length + ']';

                if (clientAccountValues.length == 1) {
                    accountBadgeText = clientAccountValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Account: </div>' +
                    '<div class="filterBadgeContent">' +
                    accountBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeAccountFilter">&times;</a></div>' +
                    '</div>';

                accountHeaderText = '[' + clientAccountValues.length + ']';

            } else {
                $('#accountFilterHeader').removeClass('activeFilter');
            }
            $("#accountHeaderText").text(accountHeaderText);

            // Service
            if (serviceValues.length) {
                numFilters++;
                $('#serviceFilterHeader').addClass('activeFilter');

                var serviceBadgeText = '[' + serviceValues.length + ']';

                if (serviceValues.length == $(".serviceFilterCheck").length) {
                    serviceBadgeText = 'All';
                }

                if (serviceBadgeText.length == 1) {
                    serviceBadgeText = serviceValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Services: </div>' +
                    '<div class="filterBadgeContent">' +
                    serviceBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeServiceFilter">&times;</a></div>' +
                    '</div>';

                serviceHeaderText = '[' + serviceValues.length + ']';

            } else {
                $('#serviceFilterHeader').removeClass('activeFilter');
            }
            $("#serviceHeaderText").text(serviceHeaderText);

            // Queue
            if (queueValues.length) {
                numFilters++;

                var queueBadgeText = '[' + queueValues.length + ']';

                if (queueValues.length == $(".queueFilterCheck").length) {
                    queueBadgeText = 'All';
                }

                if (queueValues.length == 1) {
                    queueBadgeText = queueValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Queue: </div>' +
                    '<div class="filterBadgeContent">' +
                    queueBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeQueueFilter">&times;</a></div>' +
                    '</div>';
            }

            // Email Status
            if (emailStatusValues.length) {
                numFilters++;

                var emailBadgeText = '[' + emailStatusValues.length + ']';

                if (emailStatusValues.length == $(".emailFilterCheck").length) {
                    emailBadgeText = 'All';
                }

                if (emailStatusValues.length == 1) {
                    emailBadgeText = emailStatusValues[0];
                }

                filterBadgeHtml += '<div class="filterBadge">' +
                    '<div class="filterBadgeTitle">Email Status: </div>' +
                    '<div class="filterBadgeContent">' +
                    emailBadgeText +
                    '</div>' +
                    '<div class="filterBadgeRemove"><a href="#" id="removeEmailStatusFilter">&times;</a></div>' +
                    '</div>';
            }

            var numOtherValues = (emailStatusValues.length + queueValues.length);

            if (numOtherValues) {
                $('#otherFilterHeader').addClass('activeFilter');
                otherHeaderText = '[' + numOtherValues + ']';
            }
            else {
                $('#otherFilterHeader').removeClass('activeFilter');
            }
            $("#otherHeaderText").text(otherHeaderText);

            // Apply the HTML
            $("#filterBadges").html(filterBadgeHtml);

            if (numFilters < 1) {
                $("#newProposalFilterButton").removeClass('update-button');
                $("#newProposalFilterButton").addClass('grey');
                $('#newResetProposalFilterButton').hide();
            }
            else {
                $("#newProposalFilterButton").addClass('update-button');
                $("#newProposalFilterButton").removeClass('grey');
                $('#newResetProposalFilterButton').show();
            }

            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setProposalEstimatesFilter') ?>',
                data: {
                    pesFilterStatus: statuses,
                    pesFilterEstimateStatus: estimateStatuses,
                    pesFilterUser: users,
                    pesFilterBranch: branches,
                    pesFilterClientAccount: clientAccounts,
                    pesFilterMinBid: minBid,
                    pesFilterMaxBid: maxBid,
                    pesFilterService: services,
                    pesFilterQueue: queues,
                    pesFilterEmailStatus: emailStatuses,
                    pesCreatedFrom: createdFrom,
                    pesCreatedTo: createdTo,
                    pesActivityFrom: activityFrom,
                    pesActivityTo: activityTo
                },
                dataType: 'JSON',
                success: function (d) {
                    if ($("#proposalsMap").is(':visible')) {
                        getFilteredProposalIds();
                    }
                    oTable.fnDraw();
                }
            });
        }, 200);
    }

    $("#newProposalFilterButton").click(function () {
        hideInfoSlider();
        $("#newProposalFilters").toggle();
        // Clear search so that filters aren't affected
        oTable.fnFilter('');
        // Hide group action menu
        $(".groupActionsContainer").hide();
    });

    // Handle filter searches - except client aaccounts which are handled differently
    $('.filterSearch').not('#accountSearch').on('input', function () {

        var searchVal = $(this).val();
        var parentCol = $(this).parents('.filterColumn');

        if (searchVal.length) {
            $(parentCol).find('.filterColumnRow').hide();
            $(parentCol).find(".filterColumnRow:iContains('" + searchVal + "')").show();
            $(parentCol).find(".filterSearchClear").show();
        } else {
            $(parentCol).find(".filterColumnRow").show();
            $(parentCol).find(".filterSearchClear").hide();
        }

    });

    $('#accountSearch').on('input', function () {
        var searchVal = $(this).val();

        if (!searchVal.length) {
            $(".searchRow").not('.searchSelectedRow').remove();
            return false;
        }

        $.ajax({
            url: '<?php echo site_url('ajax/searchClientAccounts') ?>',
            type: "post",
            data: {
                searchVal: searchVal
            },
            dataType: "json"
        })
            .success(function (data) {

                $(".searchRow").not('.searchSelectedRow').remove();

                var len = data.length;

                for (var i = 0; i < len; i++) {
                    var account = data[i];

                    $("#accountsFilterColumn").append('<div class="filterColumnRow searchRow">' +
                        '<input type="checkbox" value="' + account.value + '" class="filterCheck clientAccountFilterCheck" data-text-value="' + account.label + '" />' +
                        '<span class="accountName">' + account.label + '</span>' +
                        '</div>');
                }

                $('.clientAccountFilterCheck').not('.searchSelected').uniform();
            });

    });

    $(".filterSearchClear").click(function () {
        var searchInput = $(this).prev('.filterSearch');
        $(searchInput).val('');
        $(searchInput).trigger('input');
    });

    $(document).on('change', ".filterCheck", function () {

        if ($(this).hasClass('clientAccountFilterCheck') && $(this).hasClass('searchSelected')) {
            if (!$(this).is(':checked')) {
                $(this).parents('.filterColumnRow').remove();
                $('#accountSearch').trigger('input');
            }
        }
        else if ($(this).hasClass('clientAccountFilterCheck')) {
            var parent = $(this).parents('.filterColumnRow');
            parent.addClass('searchSelectedRow');
            $(this).addClass('searchSelected');
            parent.insertAfter('#accountRowAll');
        }

        var numSearchSelected = $('.searchSelected').length;
        if (numSearchSelected < 1) {
            $('#allClientAccounts').prop('checked', true);

        }
        else {
            $('#allClientAccounts').prop('checked', false);
        }

        $.uniform.update();
        applyFilter();
    });

    var sliderMin = <?php echo $minBid; ?>;
    var sliderMax = <?php echo $maxBid ?: 0; ?>;
    var sliderMinVal = <?php echo $filterMinBid; ?>;
    var sliderMaxVal = <?php echo $filterMaxBid ?: 0; ?>;

    $("#priceSlider").slider({
        range: true,
        min: sliderMin,
        max: sliderMax,
        step: 10000,
        values: [sliderMinVal, sliderMaxVal],
        slide: function (event, ui) {
            var minBid = ui.values[0];
            var maxBid = ui.values[1];

            $("#pMinBid").val(minBid);
            $("#pMaxBid").val(maxBid);

            $("#minBid").text(shortenLargeNumber(minBid, 2));
            $("#maxBid").text(shortenLargeNumber(maxBid, 2));
        },
        stop: function (event, ui) {
            applyFilter();
        }

    });
    // Set default values
    $("#pMinBid").val(sliderMinVal);
    $("#pMaxBid").val(sliderMaxVal);

    $("#minBid").text(shortenLargeNumber(sliderMinVal, 2));
    $("#maxBid").text(shortenLargeNumber(sliderMaxVal, 2));

    // DatePicker
    $("#pCreatedFrom").datepicker();
    $("#pCreatedTo").datepicker();
    $("#pActivityFrom").datepicker();
    $("#pActivityTo").datepicker();


    // Handle change
    $("#pCreatedFrom, #pCreatedTo").change(function () {
        $("#createdPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pActivityFrom, #pActivityTo").change(function () {
        $("#activityPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pCreatedFrom, #pCreatedTo").on('input', function () {
        $("#createdPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#pActivityFrom, #pActivityTo").on('input', function () {
        $("#activityPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

    $("#createdPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pCreatedFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pCreatedFrom").val(preset.startDate);
                $("#pCreatedTo").val(preset.endDate);
                applyFilter();
            }
        }
    });

    $("#activityPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pActivityFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pActivityFrom").val(preset.startDate);
                $("#pActivityTo").val(preset.endDate);
                applyFilter();
            }
        }
    });

    // New filter reset button
    $("#newResetProposalFilterButton").click(function () {

        // Hide the map overlay
        hideInfoSlider();

        // Reset All Checkboxes
        $(".filterCheck, .filterColumnCheck").prop('checked', true);

        // Reset the slider
        $("#priceSlider").slider("option", "values", [sliderMin, sliderMax]);
        // Update Slider Texts
        $("#pMinBid").val(sliderMin);
        $("#pMaxBid").val(sliderMax);
        $("#minBid").text(shortenLargeNumber(sliderMin, 2));
        $("#maxBid").text(shortenLargeNumber(sliderMax, 2));
        // Reset date ranges
        $("#pCreatedFrom").val("");
        $("#pCreatedTo").val("");
        $("#pActivityFrom").val("");
        $("#pActivityTo").val("");

        $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

        $('.searchSelectedRow').remove();
        $('#accountSearch').val('');
        $('#accountSearch').trigger('input');

        $.uniform.update();
        applyFilter();

        return false;
    });

    $(".filterCheck").click(function () {

        // If it's a branch click
        if ($(this).hasClass('branchFilterCheck')) {
            // So, we're clicking on a branch //
            // How many are there? //
            var numBranches = $(".branchFilterCheck").length;
            var numSelectedBranches = $(".branchFilterCheck:checked").length;
            var selectedBranches = [];

            // If all branches selects, check the all box and all users
            if (numSelectedBranches == numBranches) {
                $("#allUsersCheck").prop('checked', true);
                // Check all users
                $('.userFilterCheck').prop('checked', true);
            }
            else {
                $("#allUsersCheck").prop('checked', false);

                // Check the users of the selected branches
                selectedBranches = $(".branchFilterCheck:checked").map(function () {
                    return $(this).data('branch-id');
                }).get();

                $('.userFilterCheck').not('.branchFilterCheck').each(function () {
                    var branchId = $(this).data('branch-id');
                    if (selectedBranches.indexOf(branchId) < 0) {
                        $(this).prop('checked', false);
                    }
                    else {
                        $(this).prop('checked', true);
                    }
                });
            }
        }
        else if ($(this).hasClass('userFilterCheck')) {
            // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
            $('.branchFilterCheck').prop('checked', false);

            var selectedUserBranches = $(".userFilterCheck:checked").map(function () {
                return $(this).data('branch-id');
            }).get();

            var uniqueUserBranches = Array.from(new Set(selectedUserBranches));

            if (uniqueUserBranches.length > 1) {
                $('.branchFilterCheck').prop('checked', false);
            }
            else {
                // Do we need to check the branc box?
                var branchIds = selectedBranches = $(".branchFilterCheck").map(function () {
                    return $(this).data('branch-id');
                }).get();

                $.each(branchIds, function (index, value) {
                    // Count how many there are
                    var totalBranchUsers = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').length;
                    var numUnchecked = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').not(':checked').length;

                    if (totalBranchUsers > 0 && numUnchecked == 0) {
                        $('.branchFilterCheck[data-branch-id="' + value + '"]').prop('checked', true);
                    }
                });
            }
        }
        $.uniform.update();
    });


        $(document).on('change', '.filterColumnCheck', function () {

            var showAll = false;
            var className = $(this).data('affected-class');

            if ($(this).attr('id') == 'allClientAccounts') {
                if ($(this).is(':checked')) {
                    $("#accountSearch").val('');
                    $("#accountSearch").trigger('input');
                    $('.searchSelectedRow').remove();
                }
            }

            if ($(this).is(':checked')) {
                showAll = true;
            }

            $('.' + className).prop('checked', showAll);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeStatusFilter', function () {
            $(".statusFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeUserFilter', function () {
            $(".userFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeAccountFilter', function () {
            $(".clientAccountFilterCheck").prop('checked', false);
            $('.searchSelectedRow').remove();
            $('#allClientAccounts').prop('checked', true);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeServiceFilter', function () {
            $(".serviceFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeQueueFilter', function () {
            $(".queueFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removeEmailStatusFilter', function () {
            $(".emailFilterCheck").prop('checked', false);
            $.uniform.update();
            applyFilter();
        });

        $(document).on('click', '#removePriceFilter', function () {
            // Reset the slider
            $("#priceSlider").slider("option", "values", [sliderMin, sliderMax]);
            // Update Slider Texts
            $("#pMinBid").val(sliderMin);
            $("#pMaxBid").val(sliderMax);
            $("#minBid").text(shortenLargeNumber(sliderMin, 2));
            $("#maxBid").text(shortenLargeNumber(sliderMax, 2));
            applyFilter();
        });

        $(document).on('click', '#removeCreatedFilter', function () {
            $("#pCreatedFrom").val("");
            $("#pCreatedTo").val("");
            applyFilter();
        });

        $(document).on('click', '#removeActivityFilter', function () {
            $("#pActivityFrom").val("");
            $("#pActivityTo").val("");
            applyFilter();
        });

        $("#resetCreatedDate").click(function () {
            $("#pCreatedFrom").val('');
            $("#pCreatedTo").val('');
            $("#createdPreset").val('');
            $.uniform.update();
            applyFilter();
        });

        $("#resetActivityDate").click(function () {
            $("#pActivityFrom").val('');
            $("#pActivityTo").val('');
            $("#ActivityPreset").val('');
            $.uniform.update();
            applyFilter();
        });

        // Filter Presets
    $(".proposalFilterPreset").click(function() {

        clearPreset = false;

        $(".proposalFilterPreset").addClass('grey');
        $(this).removeClass('grey');

        var datePreset = $(this).data('preset-range');
        var statusPreset = $(this).data('preset-status');

        var statuses =

        setTimeout(function() {

            // Date
            if (datePreset) {
                $("#createdPreset").val(datePreset);
                $.uniform.update();
            }

            // Status
            if (statusPreset) {
                $('.statusFilterCheck').prop('checked', false);
                $('.statusFilterCheck[value="' + statusPreset +'"]').prop('checked', true);
            }

            $.uniform.update();

            if (datePreset) {
                $("#createdPreset").change();
            }
            else {
                applyFilter();
            }
        }, 500);
    });

        // Set default win date (today)
        var formattedToday = moment().format('MM/DD/YYYY');
        $("#statusWinDate").val(formattedToday);

        // Status win date datepicker
        $("#statusWinDate").datepicker();


        // Export dialog
        $("#exportProposals").dialog({
            modal: true,
            autoOpen: false,
            buttons: {
                "Export": {
                    text: 'Export',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmExport',
                    click: function () {

                        var exportName = $("#exportName").val();
                        exportName = exportName.replace(/[^a-zA-Z0-9_-\s]/g,'');

                        if (!exportName) {
                            swal('Error', ' Please enter a name for your export');
                        }
                        else {
                            $(this).dialog('close');
                            window.location.href = encodeURI('/proposals/export/' + exportName);
                        }

                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

        // Map Loading Dialog
        $("#mapLoading").dialog({
            modal: true,
            autoOpen: false
        });

        // Export Menu Button
        $("#exportFilteredProposals").click(function() {
            // Clear the input
            $("#exportName").val('');
            // Open the dialog
           $("#exportProposals").dialog('open');
        });

        // Copy work order link
        $(document).on('click', ".copyWorkOrderLink", function () {
            var linkInput = $(this).prev();

            swal({
                width: 600,
                html: 'Work Order Link<br />' +
                '<input type="text" style="width: 550px;" value="' + linkInput.val() + '" />'
            });
            $.uniform.update();
        });

        // Last Activity Popup
        $(document).on('click', ".lastActivityLink", function() {
            var proposalId = $(this).data('proposal-id');
            var projectName = $(this).data('project-name');

            $("#proposalActivityProjectName").text(projectName);
            var tableUrl = '/ajax/estimateHistory/' + proposalId;

            if (activityTable) {
                activityTable.ajax.url(tableUrl).clear().load();
            }
            else {
                // Activity Datatable
                activityTable = $("#proposalActivityTable").DataTable({
                    "order": [[1, "desc"]],
                    "processing": true,
                    "serverSide": true,
                    "scrollCollapse": true,
                    "scrollY": "300px",
                    "ajax": {
                        "url": tableUrl
                    },
                    "aoColumns": [
                        {'bSearchable': false},
                        {'bSearchable': false, 'iDataSort': 0},
                      
                        {'bSortable': false},
                        {'bSortable': false}
                    ],
                    "bJQueryUI": true,
                    "bAutoWidth": true,
                    "sPaginationType": "full_numbers",
                    "sDom": 'HfltiprF',
                    "aLengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "fnDrawCallback": function() {
                        $("#proposalActivity").dialog('open');
                    }
                });
            }
            return false;
        });

        $("#priceModifierValue").uniform();

        // End document ready
    });

    function shortenLargeNumber(num, digits) {
        var units = ['k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'],
            decimal;

        for (var i = units.length - 1; i >= 0; i--) {
            decimal = Math.pow(1000, i + 1);

            if (num <= -decimal || num >= decimal) {
                return +(num / decimal).toFixed(digits) + units[i];
            }
        }

        return num;
    }

    function datePreset(preset) {

        var startDate;
        var endDate;

        switch (preset) {

            case 'today':
                startDate = moment();
                endDate = moment();
                break;

            case 'yesterday':
                startDate = moment().subtract(1, 'days');
                endDate = moment().subtract(1, 'days');
                break;

            case 'last7days':
                startDate = moment().subtract(6, 'days');
                endDate = moment();
                break;

            case 'monthToDate':
                startDate = moment().startOf('month');
                endDate = moment();
                break;

            case 'previousMonth':
                startDate = moment().subtract(1, 'month').startOf('month');
                endDate = moment().subtract(1, 'month').endOf('month');
                break;

            case 'yearToDate':
                startDate = moment().startOf('year');
                endDate = moment();
                break;

            case 'previousYear':
                startDate = moment().subtract(1, 'year').startOf('year');
                endDate = moment().subtract(1, 'year').endOf('year');
                break;
        }

        var presetDate = {
            startDate: startDate.format('MM/DD/YYYY'),
            endDate: endDate.format('MM/DD/YYYY')
        };

        return presetDate;

    }

    function reset_estimation(proposalId){
     swal({
                title: "Are you sure?",
                text: "",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    location.href = "/ajax/reset_estimation/"+proposalId+"/1";
                } else {
                    swal("Cancelled", "", "error");
                   
                }
            });
}

</script>


<div class="javascript_loaded">
    <div id="duplicate-proposal" title="Duplicate Proposal">

        <div class="dupe-copy-wording">
            <p>Use this to send out the same proposal to several different customers.</p>
            <p><strong>Example:</strong> You are bidding the same project to 3 different General Contractors.</p>
            <p>Please understand that the number that shows up in your pipeline is the first bid created.</p>
            <p>After you win/lose this project, delete the duplicate proposals.</p>
        </div>

        <p class="clearfix" id="duplicate-selected-client">
            Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-duplicate-client-search">Select other contact</a>
        </p>

        <p class="clearfix" id="duplicate-select-client">
            <label style="width: 120px; text-align: right; margin-right: 10px; padding-top: 5px; float: left;">Select Company</label>
            <input type="text" name="duplicate-client" id="duplicate-client" style="float: left;" class="text tiptip" title="Type company name">
            <a class="btn" href="<?php echo site_url('clients/add') ?>" style="margin-left: 3px;">Add New Contact</a>
        </p>

        <p id="duplicate_estimate_chackbox" style="padding-top:10px;width:30%"><input type="checkbox" name="duplicate_estimate" id="duplicate_estimate" > <span style="margin-top: 2px;position: absolute;">Duplicate Estimate</span><span style="margin-top:2px;float:right"><i class="fa fa-info-circle  tiptip" title="If checked, all estimate details will be copied to the new proposal"></i></span></p>
        <input id="duplicate-client-id" type="hidden" name="duplicate-client-id">
        <input id="duplicate-proposal-id" type="hidden" name="duplicate-proposal-id">
    </div>
    <div id="copy-proposal" title="Copy Proposal">

        <div class="dupe-copy-wording">
            <p>Use this to copy the content of an existing proposal and send to a new customer/project.</p>
            <p>Please remember to delete any picture/images etc. prior to sending.</p>
            <p>You must have the contact name entered prior to using this feature.</p>
        </div>

        <p class="clearfix" id="copy-selected-client" style="display: none">
            Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-copy-client-search">Select other contact</a>
        </p>

        <p class="clearfix" id="copy-select-client">
            <label style="width: 120px; text-align: right; margin-right: 10px; padding-top: 5px; float: left;">Select Company</label>
            <input type="text" name="copy-client" id="copy-client" style="float: left;" class="text tiptip" title="Type company name">
            <a class="btn" href="<?php echo site_url('clients/add') ?>" style="margin-left: 3px;">Add New Contact</a>
        </p>
        <p id="copy_estimate_chackbox" style="padding-top:10px;width:30%"><input type="checkbox" name="copy_estimate" id="copy_estimate" > <span style="margin-top: 2px;position: absolute;">Duplicate Estimate</span><span style="margin-top:2px;float:right"><i class="fa fa-info-circle  tiptip" title="If checked, all estimate details will be copied to the new proposal"></i></span></p>
        <input id="copy-client-id" type="hidden" name="copy-client-id">
        <input id="copy-proposal-id" type="hidden" name="copy-proposal-id">
    </div>
    <div id="notes" title="Proposal Notes">
        <form action="#" id="add-note">
            <p>
                <label>Add Note</label>
                <input type="text" name="noteText" id="noteText" style="width: 500px;">
                <input type="hidden" name="relationId" id="relationId" value="0">
                <input type="submit" value="Add">
            </p>
            <iframe id="notesFrame" src="" frameborder="0" width="100%" height="250"></iframe>
        </form>
    </div>
    <div id="notes-client" title="Client Notes">
        <form action="#" id="add-note-client">
            <p>
                <label>Add Note</label>
                <input type="text" name="noteText-client" id="noteText-client" style="width: 500px;">
                <input type="hidden" name="relationId-client" id="relationId-client" value="0">
                <input type="submit" value="Add">
            </p>
            <iframe id="notesFrame-client" src="" frameborder="0" width="100%" height="250"></iframe>
        </form>
    </div>
    <div id="confirm-delete-message" title="Confirmation">
        <p>Are you sure you want to delete this proposal?</p>
        <a id="client-delete" href="" rel=""></a>
    </div>
    <div id="dialog-message" title="Client Information">
        <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span id="field_firstName"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span id="field_lastName"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Title:</strong> <span id="field_title"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span id="field_company"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span id="field_email"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span id="field_state"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span id="field_cellPhone"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span id="field_businessPhone"></span></p>

        <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span></p>
    </div>

    <div id="no-proposals-selected" title="Error">
        <p>No proposals were selected!</p>
        <br/>

        <p>Select at least one proposal to carry out a group action</p>
    </div>

    <div id="resend-proposals" title="Confirmation">
        <h3>Confirmation - Send Email</h3>

        <p style="margin-bottom: 15px;">Select Email Template

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
            <?php
            if ($account->isAdministrator()) {
                ?>
                <!--
                    <a href="<?php echo site_url('account/company_email_templates'); ?>">Edit Email Templates</a>
                        -->
                <?php
            }
            ?>
        </p>

        <p><span style="width: 100px; display: inline-block">Subject:</span><input class="text" type="text" id="messageSubject" style="width: 300px;"></p><br/>

        <p><input type="checkbox" id="emailCC"> <span style="display: inline-block; padding-top: 2px;"> Send CC to User</span></p><br/>

        <?php if ($account->isAdministrator()) { ?>
            <p><input type="checkbox" id="emailCustom"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></p><br/>
            <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from the owner of the proposal.</p>
            <p class="emailFromOption"><span style="width: 100px; display: inline-block">From Name:</span><input class="text" type="text" id="messageFromName" style="width: 300px;"></p><br/>
            <p class="emailFromOption"><span style="width: 100px; display: inline-block">From Email:</span><input class="text" type="text" id="messageFromEmail" style="width: 300px;"></p><br/>
        <?php } ?>


        <textarea id="message">This is the content</textarea>


        <p>This will send a total of <strong><span id="resendNum"></span></strong> email(s) to their respective contact.</p>
        <br/>

        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="resend-proposals-status" title="Confirmation">
        <h3>Confirmation - Resend Proposals</h3>

        <p id="resendProposalsStatus"></p>
        <p id="unsentProposals" style="margin-top: 10px;"></p>
        <p id="unsentDetails" style="margin-top: 10px;">Only approved proposals, or proposals below the Approval Limit were sent</p>
    </div>

    <div id="delete-proposals" title="Confirmation">
        <h3>Confirmation - Delete Proposals</h3>

        <p>This will delete a total of <strong><span id="deleteNum"></span></strong> proposals.</p>
        <br/>
        <p id="deleteDuplicatesOption"><input type="checkbox" id="deleteDuplicates"> Also delete duplicates?</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="delete-proposals-status" title="Confirmation">
        <h3>Confirmation - Delete Proposals</h3>

        <p id="deleteProposalsStatus"></p>
    </div>

    <div id="status-proposals" title="Confirmation">
        <h3>Updating status of <span id="statusChangeNum"></span></strong> proposals.</h3>

        <p>Change to: <select id="changeStatus">
                <?php foreach ($statuses as $status) {
                        /* @var \models\Status $status */
                ?>
                    <option value="<?php echo $status->getId(); ?>" data-sales="0"><?php echo $status->getName(); ?></option>
                <?php } ?>
            </select>
        </p>
        <br/>

        <div id="statusWin" style="display: none;">
            <p><strong><span id="statusUnwonCount"></span></strong> proposals will be marked as won.</p><br />
            <p>Select the win date for these proposals: <input type="text" class="text" id="statusWinDate" /></p>
        </div>
        <div id="statusUnwin" style="display: none;">
            <p><strong><span id="statusWonCount"></span></strong> proposals that are currently 'sold' will become unsold.</p><br />
        </div>
        <br />
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="status-proposals-status" title="Confirmation">
        <h3>Confirmation - Update Proposal Status</h3>

        <p id="statusProposalsStatus"></p>
    </div>

    <div id="status-unduplicate" title="Make Standalone">
        <p>This will convert any selected duplicate proposals into standalone proposals.</p>
        <br/>
        <p>Are you sure you want to proceed?</p>
    </div>

    <div id="standalone-status" title="Confirmation">
        <h3>Confirmation - Setting proposals to Standalone</h3>

        <p id="standaloneStatus"></p>
    </div>

    <div id="status-date-change-confirm" title="Update Status Change Date">
        <p>This will update when the proposal was changed to the current status.</p>
        <br/>
        <p>Select Date: <input type="text" id="sdcDate"/></p>
    </div>

    <div id="sdc-status" title="Confirmation">
        <h3>Confirmation - Updating Status Change Date</h3>

        <p id="sdcStatus"></p>
    </div>

    <div id="date-change-confirm" title="Update Proposal Date">
        <p>This will update when the proposal was created</p>
        <br/>
        <p>Select Date: <input type="text" id="dcDate"/></p>
    </div>

    <div id="dc-status" title="Confirmation">
        <h3>Confirmation - Updating Proposal Date</h3>

        <p id="dcStatus"></p>
    </div>


    <div id="reassign-proposals" title="Reassign Proposals">
        <h3>Confirmation - Reassign Proposals</h3>

        <p>Change to: <select id="reassignUser">
                <?php foreach ($accounts as $userAccount) { ?>
                    <option value="<?php echo $userAccount->getAccountId(); ?>"><?php echo $userAccount->getFullName() ?></option>
                <?php } ?>
            </select>
        </p>
        <br/>

        <p>This will update the owner of <strong><span id="statusChangeNum"></span></strong> proposals.</p>
        <br/>

        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="reassign-proposals-status" title="Confirmation">
        <h3>Confirmation - Reassign Proposal Status</h3>

        <p id="reassignProposalsStatus"></p>
    </div>

    <div id="groupResendSettingsModal" title="Change Auto Re-Send Settings">
        <h3>Group Auto Re-Send Settings</h3>

        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Auto Re-Send</label>
                        <select name="automatic_resend" id="automatic_resend" style="float: left;">
                            <option value="0">Disabled</option>
                            <option value="1">Enabled</option>
                        </select>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Every</label>
                        <input type="text" name="frequency" id="frequency" value="<?= (($proposal_resend_frequency / 86400) >= 1) ? (round($proposal_resend_frequency / 86400)) : 1 ?>" class="text" style="width: 20px;">
                        <label style="text-align: left; width: auto;">Days</label>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Template</label>
                        <select name="template" id="template" style="float: left;">
                            <?php foreach ($proposal_email_templates as $template): /** @var $template models\ClientEmailTemplate */ ?>
                                <option value="<?= $template->getTemplateId() ?>"><?= $template->getTemplateName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div id="exportProposals" title="Select File Name">
        <p>Enter a file name for your export</p>
        <br/>

        <p><input type="text" id="exportName" placeholder="File Name"></p>
    </div>

    <div id="proposalActivity" title="Proposal Activity">
        <h4><i class="fa fa-fw fa-history"></i> Proposal Activity: <span id="proposalActivityProjectName"></span></h4>
        <hr />

        <table id="proposalActivityTable" class="boxed-table" style="width: 100%">
            <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>IP Address</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div id="price-modifier-dialog" title="Modify Proposal Prices" style="text-align: center;">
        <br />
        <p>Choose a percentage value to modify all proposal service prices by.</p><br />

        <div style="text-align: center;">
            <input type="number" step="0.01" id="priceModifierValue" value="0.00" style="width: 80px; padding: 5px; font-size: 20px" /> %
        </div>

        <br /><br />
        <p>Click 'Apply' to adjust the price of all selected proposals.</p>
        <br /><br />

    </div>

</div>