<?php /* @var $account \models\Accounts */ ?>
<h3>My ProSiteAudit Credentials</h3>

<form id="psa_form" action="<?php echo site_url('account/psa') ?>" method="post" class="form-validated" autocomplete="off">
<!-- PSA COnnection -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
    </thead>
    <tbody>
    <tr>
        <td width="50%">
            <div class="padded">
                <p style="text-align: center">
                    <img src="/static/images/psa.jpeg" width="200px"/>
                </p>
                <p style="margin-top: 20px; text-align: center">
                    Enter your ProSiteAudit email and password to allow data sync between sites.
                </p>

            </div>

        </td>
        <td width="50%">

                <table class="boxed-table">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td>
                            <label>Email</label>
                            <input type="text" name="psaEmail" id="psaEmail" class="text required" autocomplete="off"
                                   value="<?php echo $account->getPsaEmail(); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                            <input type="password" name="psaPass" id="psaPass" class="text required" autocomplete="off"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <input class="btn blue" name="savePsa" id="savePsa" type="submit" value="Save Credentials" style="float: none !important;">
                        </td>
                    </tr>
                    </tbody>
                </table>

        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p style="text-align: center; padding: 15px;">
                <a href="https://my.prositeaudit.com/account/forgot" target="_blank">Click here</a> to reset your ProSiteAudit password
            </p>
        </td>
    </tr>
    <?php if ($account->hasPsaCreds()) { ?>
        <!--
    <tr>
        <td style="text-align: center; padding: 10px;">
            <p>You can also completely remove any saved login</p><br />
            <p><input class="btn" name="removePsa" id="removePsa" type="submit" value="Remove Login" style="float: none !important;">
        </td>
        <td></td>
    </tr>
    -->
    <?php } ?>
    </tbody>
</table>
</form>

