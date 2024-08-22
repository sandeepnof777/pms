<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">

        <div class="content-box">

            <div class="box-header">
                Add New Account
                <a class="tiptip box-action" href="<?php echo site_url('accounts') ?>" title="Back to Accounts" style="margin-left: 10px;">Back</a>
            </div>
            <div class="box-content">

                <div id="nameWarning" style="margin: 10px; padding: 20px; background: #ccc; border: 2px solid #777; display: none;">
                    <p>You already have an account with a similar name. To avoid duplicating accounts, please make sure this account hasn't already been created</p>
                    <ol id="existingAccountList"></ol>
                </div>


                <form class="form-validated" method="post" action="<?php echo site_url('accounts/add') ?>">

                <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <label>Company Name</label>
                            <input class="text required capitalize" type="text" name="companyName" id="companyName" value="" tabindex="1">
                        </td>
                        <td>
                            <label>Website</label>
                            <input class="text" type="text" name="website" id="website" value="" tabindex="6">
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Address</label>
                            <input class="text" type="text" name="address" id="address" tabindex="2" value="">
                        </td>
                        <td>
                            <label>Business Phone</label>
                            <input class="text" type="text" name="businessPhone" id="businessPhone" value="" tabindex="7">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>City</label>
                            <input class="text" type="text" name="city" id="city" value="" tabindex="3">
                        </td>
                        <td>
                            <label>Contact Email</label>
                            <input class="text" type="text" name="contactEmail" id="contactEmail" value="" tabindex="8">
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>State</label>
                            <input class="text " type="text" name="title" id="title" value="" tabindex="4">
                        </td>
                        <td>
                            <label>Owner</label>
                            <?php if ($account->getUserClass() > 0) { ?>
                                <p class="clearfix">
                                    <select name="account" id="account" tabindex="9">
                                        <?php
                                        foreach ($companyUsers as $user) {
                                            ?>
                                            <option <?php if ($user->getAccountId() == $account->getAccountId()) { ?>selected="selected" <?php } ?> value="<?php echo $user->getAccountId() ?>"><?php echo $user->getFullName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </p>
                            <?php } else { ?>
                                <select name="account" id="account" tabindex="9">
                                    <option value="<?php echo $account->getAccountId(); ?>"><?php echo $account->getFullName(); ?></option>
                                </select>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>
                            <label>Zip</label>
                            <input class="text " type="text" name="zip" id="zip" value="" tabindex="5">
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="btn blue" name="add" id="addAccount" value="Add Account" style="margin: 20px 0 20px 150px;" tabindex="10">
                        </td>
                    </tr>
                </table>


                </form>
            </div>

        </div>


    </div>
</div>
<script type="text/javascript">

    $(document).on('ready', function() {

        $("#businessPhone").mask("999-999-9999");

        $("#companyName").keyup(function() {
            if ($(this).val().length > 2) {
                searchAccountName($(this).val());
            }
        });
    });

    var req = null;

    function searchAccountName(value)
    {
        if (req != null) req.abort();

        req = $.ajax({
            type: "GET",
            url: "/ajax/ajaxSearchAccounts",
            data: {'search' : value},
            dataType: "json",
            success: function(data){

                $("#existingAccountList").html('');
                if (data.length > 0) {
                    $.each(data, function (index, value) {
                        $("#existingAccountList").append('<li><a href="/accounts/edit/' + value.id + '">' + value.name + '</li>');
                    });
                    $("#nameWarning").show();
                }
                else {
                    $("#nameWarning").hide();
                }
            }
        });
    }

</script>
<?php $this->load->view('global/footer'); ?>