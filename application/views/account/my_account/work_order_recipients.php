<!-- add a back button  -->
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
    &nbsp;
    <a href="#" id="addRecipient">Add New Recipient</a>
</h3>
<div id="addRecipientForm" style="display: none;">
    <form action="#" name="addRecipient" style="padding: 8px 10px; text-align: center;">
        <label>Name</label>
        <input type="text" name="name" id="name"/>
        <label>Email</label>
        <input type="text" name="email" id="email"/>
        <input type="submit" value="Add"/>
        <a class="btn btn-delete right tiptip" href="#" style="margin-top: -3px;" id="addRecipientFormClose" title="Cancel">&nbdp;</a>
    </form>
</div>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td style="text-align: left;" width="40%">Name</td>
        <td style="text-align: left;" width="40%">Email</td>
        <td style="text-align: left;" width="10%">Delete</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $k = 0;
    foreach ($recipients as $recipient) {
        $k++;
        ?>
        <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>">
            <td><span class="editName tiptip" id="recipientName_<?php echo $recipient->getRecipientId() ?>" title="Click to Edit"><?php echo $recipient->getName(); ?></span></td>
            <td><span class="editEmail tiptip" id="recipientEmail_<?php echo $recipient->getRecipientId() ?>" title="Click to Edit"><?php echo $recipient->getEmail(); ?></span></td>
            <td><a class="tiptip btn btn-delete delete-recipient" href="<?php echo site_url('account/deleteWorkOrderRecipient/' . $recipient->getRecipientId()) ?>" title="Delete <?php echo $recipient->getName(); ?>">&nbsp;</a></td>
        </tr>
    <?php
    }
    if (!count($recipients)) {
        ?>
    <tr>
        <td colspan="3" class="centered">No recipients defined! Please add some to get started!</td>
    </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $("#addRecipient").click(function () {
            $("#name, #email").val('');
            $("#addRecipientForm").show();
            return false;
        });
        $("#addRecipientFormClose").click(function () {
            $("#addRecipientForm").hide();
            return false;
        });
        $("#addRecipientForm").submit(function () {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('account/addWorkRecipient') ?>',
                data: {
                    name: $('#name').val(),
                    email: $("#email").val()
                },
                success: function (data) {
                    if (data == 0) {
                        document.location.reload();
                    } else {
                        document.location.reload();
                    }
                }
            });
            return false;
        });
        $(".editName, .editEmail").editable('<?php echo site_url('account/saveWorkRecipientInfo') ?>', {
            cancel: 'Cancel',
            submit: 'OK',
            width: 200,
            height: 100
        });
        var deleteURL;
        $(".delete-recipient").click(function () {
            deleteURL = $(this).attr('href');
            $("#confirm").dialog('open');
            return false;
        });
        $("#confirm").dialog({
            autoOpen: false,
            buttons: {
                Delete: function () {
                    document.location.href = deleteURL;
                },
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
    });
</script>
<div id="confirm">
    Are you sure you want to delete the recipient?
</div>