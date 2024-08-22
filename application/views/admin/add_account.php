<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <form class="form-validated" action="<?php echo site_url('admin/add_account/' . $this->uri->segment(3)) ?>" method="post" style="float: left; width: 500px;">
            <div class="content-box" style="width: 100%;">
                <div class="box-header">
                    Add New Account
                    <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <div class="box-content">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table form-validated">
                            <thead>
                            <tr>
                                <td>Account Info</td>
                            </tr>
                            </thead>
                            <tr>
                                <td width="50%">
                                    <p class="clearfix">
                                        <label>Email <span>*</span></label>
                                        <input type="text" name="accountEmail" id="accountEmail" class="text required email tiptip" title="Enter user's email" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td width="50%">
                                    <p class="clearfix">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" name="firstName" id="firstName" class="text required tiptip" title="Enter user's first name" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <p class="clearfix">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" name="lastName" id="lastName" class="text required tiptip" title="Enter user's last name" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label>Password <span>*</span></label>
                                        <input type="text" name="password" id="password" class="text required tiptip" title="Enter user's password" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <label>Expiration Date</label>
                                    <input class="text tiptip" title="Set Company Expiration Date" name="expires" id="expires" type="text" style="width: 75px; text-align: center;" value="<?php echo date('n/j').'/'.(date('Y') + 1) ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="clearfix">
                                        <label style="width: 100%;"><span>* = Required Field</span></label>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <input type="submit" value="Add" name="addNewAccount" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
        <form action="<?php echo site_url('admin/add_accounts/' . $this->uri->segment(3)) ?>" method="post" style="float: right; width: 400px;">
            <div class="content-box" style="width: 100%;">
                <div class="box-header">
                    Add Multiple Accounts
                    <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <div class="box-content">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table form-validated">
                            <tr class="even">
                                <td>
                                    <label>Number of accounts</label>
                                    <select name="usersNumber" id="usersNumber">
                                        <?php for ($i = 1; $i <= 25; $i++) {
                                        echo '<option>' . $i . '</option>';
                                    } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <label>Expiration Date</label>
                                    <input class="text tiptip" title="Set Company Expiration Date" name="expires" id="expires2" type="text" style="width: 75px; text-align: center;" value="<?php echo date('n/j').'/'.(date('Y') + 1) ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <input type="submit" value="Add" name="addNewAccount" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#expires, #expires2").datepicker({
            dateFormat:'m/d/yy'
        });
    });
</script>
<?php $this->load->view('global/footer'); ?>
