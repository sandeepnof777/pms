<?php $this->load->view('global/header-global'); ?>
<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4>Reset Password<a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <form action="#" method="post" class="validate big">
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="even">
                            <td>
                                Please enter your email address associated with your account and we will send you an email with a new generated password.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="text" name="email" id="email" class="text required email">
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>&nbsp;</label>
                                <input type="submit" value="Recover" class="submit btn" name="recover">
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="<?php echo site_url() ?>">Remembered your password?</a>
                            </td>
                        </tr>
                        <tr class="even">
                            <td></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!--#content-->  <?php $this->load->view('global/footer-global'); ?>