<?php $this->load->view('global/header-global'); ?>
<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4><?php echo $buttonText; ?><a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
            <?php
            if(!$user){ ?>
                <h3 class="text-center">Password Recover Key not recognized</h3>
                <h4 class="text-center"><a href="<?php echo site_url() ?>">Back to Login</a></h4>

                <?php
                }else{
                ?>
                <form action="#" method="post" class="validate big">
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="even">
                            <td>
                                <p class="text-center" style="margin-bottom: 5px;">Please enter your new password below.</p>
                                <p class="text-center">Password must be at least 6 characters long</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Password:</label>
                                <input type="password" name="password" id="password" minlength="6" class="text email" required>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>&nbsp;</label>
                                <input type="submit" value="<?php echo $buttonText; ?>" id="setPasswordBtn" class="submit btn update-button" name="reset">
                            </td>
                        </tr>
                        <?php if (!$new) { ?>
                        <tr>
                            <td align="center">
                                <a href="<?php echo site_url() ?>">Remembered your password?</a>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="even">
                            <td></td>
                        </tr>
                    </table>
                </form>
            <?php }
                ?>
            </div>
        </div>
    </div>

    <div id="passLengthDialog" title="Error">

        <p class="text-center" style="padding-top: 30px;">Password must be at least 6 characters long.</p>

    </div>

    <div class="clearfix"></div>

</div>



<script type="text/javascript">

    $(document).ready(function() {

        $("#passLengthDialog").dialog({
            modal: true,
            width: 400,
            autoOpen: false,
            buttons: [
                {
                    text: "Ok",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });


        $("#setPasswordBtn").click(function() {
            var newPass = $("#password").val();

            if (newPass.length < 6) {
                $("#passLengthDialog").dialog('open');
                return false;
            }
            else {
                return true;
            }

        });
    });

</script>




<!--#content-->  <?php $this->load->view('global/footer-global'); ?>