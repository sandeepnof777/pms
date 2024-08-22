<style>
    #existing_contact_table_wrapper .paging_full_numbers {
        width: 310px !important;
    }

    #existing_contact_table_wrapper {
        margin-top: 10px !important;
    }
</style>
<div id="addContactDialog" title="Add Contact" style="display: none;">
    <p class="adminInfoMessage templateInfoMsg" style="display: block;"><i class="fa fa-fw fa-info-circle"></i> Enter
        the detail of the contact below. If it looks like you may already have this contact, we'll show you in a table
        below.</p>
    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">

        <tr>
            <td>
                <label>Account </label>

                <input type="text" class="text" name="accCompanyName" id="accCompanyName" value=""
                       autocomplete="new-password" placeholder="Leave blank for residential">
                <input type="hidden" name="accountId" id="accountId" value="">
            </td>

        </tr>
        <tr>
            <td>
                <label>First Name </label>
                <input class="text  " type="text" name="firstName" id="contact_firstname" value="">
            </td>

        </tr>
        <tr>
            <td>
                <label>Last Name </label>
                <input class="text  " type="text" name="lastName" id="contact_lastname" value="">
            </td>

        </tr>
        <tr>
            <td>
                <label>Email</label>
                <input class="text  " type="text" name="email" id="contact_email" value="">
                <span id="emailValidationMessage" style="position: relative; top: 7px;">
                                    <i class="fa fa-fw fa-warning"></i> Valid Email Required!
                                </span>
            </td>
        </tr>
        <tr>
            <td>
                <a href="javascript:void(0);" class="btn blue-button add_contact_popup_btn" style="margin-left: 150px;">
                    Add New Contact</a>
            </td>
        </tr>
    </table>

    <div style="float:left" id="existing_contact_table_div">
        <h4 style="margin-top: 10px;margin-bottom: 0px;">Please check these similar contacts</h4>
        <table id="existing_contact_table" class="display "
               style="border-collapse: collapse!important;width: 100%; float: left">
            <thead>
            <tr>
                <th>Account</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script type="text/javascript">

    var eContactTable;
    $(document).ready(function () {

        $("#addContactDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 660,
            position: ['middle', 50],
            // open: function(event, ui) {
            //     // Reset Dialog Position
            //     $(this).dialog('widget').position(['middle',10]);
            // },
        });

        $("#accCompanyName").autocomplete({
            minLength: 2,
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('ajax/searchClientAccountsOject'); ?>",
                    dataType: "JSON",
                    data: {
                        searchVal: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            focus: function (event, ui) {
                $("#accCompanyName").val(ui.item.accountName);
                return false;
            },
            select: function (event, ui) {
                $("#accCompanyName").val(ui.item.accountName);
                $("#accountId").val(ui.item.value);

                return false;
            }
        });

        $("#accCompanyName").keyup(function () {
            $("#accountId").val('');
        });


        $(document).on('click', ".add_contact_btn", function () {
            $('#accCompanyName').val('');
            $('#accCompanyName').trigger("change");
            $("#accountId").val(''),
                $("#contact_firstname").val(''),
                $("#contact_lastname").val(''),
                $("#contact_email").val(''),
                $('.add_contact_popup_btn').prop('disabled', true);
            $('.add_contact_popup_btn').addClass('ui-state-disabled');
            //$('.add_contact_btn_tr').hide();
            $('#emailValidationMessage').hide();
            $("#addContactDialog").dialog('open');
        });

        $(document).on('change', "#accCompanyName,#contact_firstname,#contact_lastname,#contact_email", function () {
            if ($("#accCompanyName").val() != '' || $("#contact_firstname").val() != '' || $("#contact_lastname").val() != '' || $("#contact_email").val() != '') {
                if (eContactTable) {
                    eContactTable.ajax.reload(null, false);
                } else {
                    initial_exiting_contact_load_table();
                }

            } else {
                $('#existing_contact_table_div').hide();

            }
            var email = $("#contact_email").val();
            var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
            var email_check = re.test(email);
            if ($("#contact_firstname").val() != '' && $("#contact_lastname").val() != '' && $("#contact_email").val() != '') {
                if (email_check) {
                    $('.add_contact_popup_btn').prop('disabled', false);
                    $('.add_contact_popup_btn').removeClass('ui-state-disabled');
                    $('#emailValidationMessage').hide();
                } else {
                    $('.add_contact_popup_btn').prop('disabled', true);
                    $('.add_contact_popup_btn').addClass('ui-state-disabled');
                    $('#emailValidationMessage').show();
                }
            } else {
                $('.add_contact_popup_btn').prop('disabled', true);
                $('.add_contact_popup_btn').addClass('ui-state-disabled');
            }

        });
        var timer = null;
        $(document).on('keyup', "#accCompanyName,#contact_firstname,#contact_lastname,#contact_email", function () {

            if ($("#accCompanyName").val() != '' || $("#contact_firstname").val() != '' || $("#contact_lastname").val() != '' || $("#contact_email").val() != '') {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    if (eContactTable) {
                        eContactTable.ajax.reload(null, false);
                    } else {
                        initial_exiting_contact_load_table();
                    }
                }, 500);

            } else {
                $('#existing_contact_table_div').hide();
            }
            var email = $("#contact_email").val();
            var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
            var email_check = re.test(email);

            $('#emailValidationMessage').hide();
            if ($("#contact_email").val() != '') {
                if (email_check) {
                    $('#emailValidationMessage').hide();
                } else {
                    $('#emailValidationMessage').show();
                }
            }

            if ($("#accCompanyName").val() != '' && $("#contact_firstname").val() != '' && $("#contact_lastname").val() != '' && $("#contact_email").val() != '') {
                if (email_check) {
                    $('.add_contact_popup_btn').prop('disabled', false);
                    $('.add_contact_popup_btn').removeClass('ui-state-disabled');

                } else {
                    $('.add_contact_popup_btn').prop('disabled', true);
                    $('.add_contact_popup_btn').addClass('ui-state-disabled');
                }
            } else {
                $('.add_contact_popup_btn').prop('disabled', true);
                $('.add_contact_popup_btn').addClass('ui-state-disabled');
            }
        });

        function initial_exiting_contact_load_table() {

            eContactTable = $('#existing_contact_table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "lengthChange": false,
                "pageLength": 5,
                "ajax": {
                    url: "<?php echo site_url('ajax/findExistingContact');?>",
                    data: function (d) {
                        d.accountId = $("#accountId").val();
                        d.accountname = $("#accCompanyName").val();
                        d.firstname = $("#contact_firstname").val();
                        d.lastname = $("#contact_lastname").val();
                        d.email = $("#contact_email").val();
                    }
                },
                "columns": [
                    {width: '35%', class: 'dtLeft'},
                    {width: '25%', class: 'dtLeft'},                                           // 3 Branch
                    {width: '25%', class: 'dtLeft'},
                    {width: '15%', class: 'dtLeft'}
                ],
                "sorting": [
                    [0, "desc"]
                ],
                "jQueryUI": true,
                "autoWidth": true,
                "stateSave": false,
                "paginationType": "full_numbers",
                "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                "drawCallback": function () {
                    if (eContactTable['context'][0]['aiDisplay'].length > 0) {
                        $('#existing_contact_table_div').show();
                        //$('.add_contact_btn_tr').hide();
                        if (eContactTable) {
                            eContactTable.columns.adjust();
                        }
                    } else {
                        $('#existing_contact_table_div').hide();
                        //$('.add_contact_btn_tr').show();
                    }
                    initTiptip();
                    initUI();
                    $("#dashboardTabsLoader").hide();
                }
            });
        }

        $(document).on('click', ".add_contact_popup_btn", function () {
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    accCompanyName: $("#accCompanyName").val(),
                    accountId: $("#accountId").val(),
                    firstName: $("#contact_firstname").val(),
                    lastName: $("#contact_lastname").val(),
                    email: $("#contact_email").val(),
                },
                url: "<?php echo site_url('clients/check_add_contact') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                //console.log(data);
                window.location.href = "<?php echo site_url('clients/add') ?>";
            });
        });

//end ready
    });
</script>