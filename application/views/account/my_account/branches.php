<!-- add a back button  -->
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
</h3>
<table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
    <thead>
    <tr>
        <td style="text-align: left;">Branch Name</td>
        <td style="text-align: left;" width="50">Users</td>
        <td style="text-align: left;" width="40" align="right">Actions</td>
    </tr>
    </thead>
    <tbody>
    <tr class="even">
        <td style="height: 31px;">Main Branch (Default)</td>
        <td><?php echo $branchUsers[0] ?></td>
        <td>&nbsp;</td>
    </tr>
    <?php
    $branchCounter = 0;
    foreach ($branches as $branch) {
        $branchCounter++;
        ?>
        <tr class="<?php echo ($branchCounter % 2) ? 'odd' : 'even' ?>">
            <td><span class="editBranchName tiptip" title="Edit Branch Name<br>(hit enter to save)" id="<?php echo $branch->getBranchId(); ?>"><?php echo $branch->getBranchName() ?></span></td>
            <td><?php echo $branchUsers[$branch->getBranchId()] ?></td>
            <td><a class="btn btn-delete tiptip" title="Delete Branch (All users will go to Main Branch)" href="<?php echo site_url('account/deleteBranch/' . $branch->getBranchId()) ?>">Delete</a></td>
        </tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="3" style="text-align: center;">
            <a href="#" class="addBranch">[+] Add Branch</a>

            <form action="<?php echo site_url('account/addBranch') ?>" style="display: block; margin: 0 auto; width: 520px;" method="post" class="addForm">
                <label style="margin-top: 3px;">Branch Name:</label>
                <input type="text" name="branchName" class="text branchName" style="margin-top: 3px;">
                <input type="submit" value="Save" class="btn" style="margin-right: 4px;">
                <input type="button" value="Cancel" class="btn cancelAdd">
            </form>
        </td>
    </tr>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        //add functionality
        $(".addForm").hide();
        $(".addBranch").live('click', function () {
            $(this).hide();
            $(".addForm").show();
            $(".branchName").val('');
            return false;
        });
        $(".cancelAdd").live('click', function () {
            $(".addForm").hide();
            $('.addBranch').show();
            return false;
        });
        //branch deletion code
        $("#confirm-delete").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    document.location.href = $("#delete-branch-url").attr('href');
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".btn-delete").live('click', function () {
            $("#delete-branch-url").attr('href', $(this).attr('href'));
            $("#confirm-delete").dialog('open');
            return false;
        });
        //name jeditable
        $('.editBranchName').editable('<?php echo site_url('account/saveBranchName') ?>', {
             });
    });
</script>
<div class="javascript_loaded">
    <div id="confirm-delete" title="Confirmation">
        <p>Are you sure you want to delete the branch? The users that belong to it will be automatically assigned to the Main branch..</p>
        <a id="delete-branch-url" href="" rel=""></a>
    </div>
</div>