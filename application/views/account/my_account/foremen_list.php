<!-- add a back button  -->
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
    Foremen - Add your Foremen here
    <a href="#" id="addRecipient">Add New Foremen</a>
</h3>
<div id="addRecipientForm" style="display: none;">
    <form action="#" name="addRecipient" style="padding: 8px 10px; text-align: center;">
        <label>Name</label>
        <input type="text" name="name" id="name"/>
        <label>Phone</label>
        <input type="text" name="contact" id="contact"/>
        <label>Email</label>
        <input type="text" name="email" id="email"/>
        <input type="submit" value="Add"/>
        <a class="btn btn-delete right tiptip" href="#" style="margin-top: -3px;" id="addRecipientFormClose" title="Cancel">&nbdp;</a>
    </form>
</div>
<table class="boxed-table foremen-list" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td><i class="fa fa-fw fa-sort"></i> </td>
        <td style="text-align: left;" width="30%">Name</td>
        <td style="text-align: left;" width="30%">Phone</td>
        <td style="text-align: left;" width="30%">Email</td>
        <td style="text-align: left;" width="10%">Delete</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $k = 0;
    foreach ($foremens as $foremen) {
        $k++;
        ?>
        <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>" id="foremen_<?php echo $foremen->getId(); ?>">
        <td class="center">
                <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
            </td>
            <td><span class="editName tiptip" id="foremenName_<?php echo $foremen->getId() ?>" title="Click to Edit"><?php echo $foremen->getName(); ?></span></td>
            <td><span class="editContact tiptip" id="foremenContact_<?php echo $foremen->getId() ?>" title="Click to Edit"><?php echo $foremen->getContact(); ?></span></td>
            <td><span class="editEmail tiptip" id="foremenEmail_<?php echo $foremen->getId() ?>" title="Click to Edit"><?php echo $foremen->getEmail(); ?></span></td>
            <td><a class="tiptip btn btn-delete delete-foremen" href="<?php echo site_url('account/deleteForemen/' . $foremen->getId()) ?>" title="Delete <?php echo $foremen->getName(); ?>">&nbsp;</a></td>
        </tr>
    <?php
    }
    if (!count($foremens)) {
        ?>
    <tr>
        <td colspan="3" class="centered">No Foremens defined! Please add some to get started!</td>
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
                url: '<?php echo site_url('account/addForemen') ?>',
                data: {
                    name: $('#name').val(),
                    contact: $('#contact').val(),
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
        $(".editName,editContact, .editEmail").editable('<?php echo site_url('account/saveForemenInfo') ?>', {
            cancel: 'Cancel',
            submit: 'OK',
            width: 200,
            height: 100
        });
        var deleteURL;
        $(".delete-foremen").click(function () {
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
    var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
    // Sortable categories
    $(".foremen-list tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                console.log(postData);
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateForemenOrder') ?>",
                    data:postData,
                    //async:false
                });
            }
        });

        
</script>
<div id="confirm">
    Are you sure you want to delete the Foremen?
</div>