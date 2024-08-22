<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Company Accounts</h1>
        <h2>&nbsp;</h2>
        <p><a href="<?php echo site_url('account/add_sub_account') ?>" class="btn">Add Company Account</a></p>
        <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
            <thead>
            <tr>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Cell Phone</td>
                <td>Type</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($accounts as $account) {
                ?>
            <tr>
                <td><?php echo $account->firstName ?></td>
                <td><?php echo $account->lastName ?></td>
                <td><?php echo $account->email ?></td>
                <td><?php echo $account->cellPhone ?></td>
                <td><?php
                    switch ($account->accountType) {
                        case '1': echo 'Administrator'; break;
                        case '2': echo 'User'; break;
                        case '3': echo 'User+'; break;
                    }
                    ?></td>
                <td><a href="<?php echo site_url('account/edit_sub_account/' . $account->userId) ?>" class="btn-edit">&nbsp;</a> <a href="<?php echo site_url('account/delete_account/' . $account->userId) ?>" rel="<?php echo site_url('account/delete_account/' . $account->userId) ?>" class="confirm-deletion btn-delete">&nbsp;</a><!--<a href="#" class="btn">View Proposals</a>--></td>
            </tr>
                <?php

            }
            ?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.dataTables').dataTable({
                    "bJQueryUI": true,
                    "bAutoWidth": false,
                    "sPaginationType": "full_numbers"
                });
                $("#dialog-message").dialog({
                    width: 400,
                    modal: true,
                    buttons: {
                        Close: function() {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false,
                    beforeClose: function(event, ui) {
                        $("#dialog-message span").html('');
                    }
                });
                $("#confirm-delete-message").dialog({
                    width: 400,
                    modal: true,
                    buttons: {
                        Ok: function() {
                            document.location.href = $("#client-delete").attr('rel');
                            $(this).dialog("close");
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });
                $(".confirm-deletion").click(function() {
                    $("#client-delete").attr('rel', $(this).attr('rel'));
                    $("#confirm-delete-message").dialog('open');
                    return false;
                });
                $('.viewClient').click(function() {
                    var userId = $(this).attr('rel');
                    $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + userId, function(data) {
                        var items = [];
                        $.each(data, function(key, val) {
                            $("#field_" + key).html(val);
                        });
                    });
                    $("#dialog-message").dialog("open");
                });
            });
        </script>
        <div id="dialog-message" title="Contact Information">
            <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span id="field_firstName"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span id="field_lastName"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span id="field_company"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Emmail:</strong> <span id="field_email"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span id="field_cellPhone"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span id="field_businessPhone"></span></p>
            <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span></p>
        </div>
        <div id="confirm-delete-message" title="Confirmation">
            <p>Are you sure you want to delete your contact? <br>This will delete all the proposals sent to him.</p>
            <a id="client-delete" href="" rel=""></a>
        </div>
    </div>
</div>
<!--#content-->