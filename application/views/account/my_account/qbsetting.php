<?php
session_start();
$configs = include('config.php');
$redirect_uri = $configs['oauth_redirect_uri'];
$openID_redirect_uri = $configs['openID_redirect_uri'];
$refreshTokenPage = $configs['refreshTokenPage'];

if (isset($_SESSION['access_token']) && !empty($_SESSION['access_token']) ) {

    if ($this->uri->segment(3) != 'qblogin' && !$_SESSION['connected']) {
        echo '<p style="text-align:center">Please wait, connecting your account...</p><br/>
        <div style=" width: 100%;">
            <img style="margin-left: auto;margin-right: auto;display: block;" src="/static/loading_animation.gif">
        </div>';
        redirect('/datauploadqb/insertQbLogin/' . $_SESSION['access_token'] . '/' . $_SESSION['refresh_token'], 'refresh');
    }
} ?>

<script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere-1.3.3.js"></script>
<script type="text/javascript">
    var redirectUrl = "<?=$redirect_uri?>"
    intuit.ipp.anywhere.setup({
        grantUrl: redirectUrl,
        datasources: {
            quickbooks: true,
            payments: true
        },
        paymentOptions: {
            intuitReferred: true
        }
    });
</script>
<style type="text/css">
    .disconnect-btn {
        margin-top: 10px;
        font-size: 14px;
        padding: 5px;
        border-radius: 4px;
        display: inline-block;
    }
</style>

<div style="padding: 10px">


    <!-- QB Connection -->
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <thead>
        </thead>
        <tbody>
        <tr>
            <td width="50%">
                <div class="padded">
                    <p style="text-align: center"><img src="/qbo.png"/></p>
                    <p style="margin-top: 20px; text-align: center">
                        <?php
                        if ($account->getCompany()->hasQb()) {
                            ?>
                            <?php echo $account->getCompany()->getCompanyName(); ?> is connected with Quickbooks.
                            <?php
                        } else {
                            ?>
                            Click 'Connect to Quickbooks' to connect your company with your QuickBooks Online account
                            <?php
                        } ?>
                    </p>
                </div>
            </td>
            <td width="50%" style="text-align: center"><?php
                if ($account->getCompany()->hasQb()) {
                    echo '<a class="btn red disconnect-btn" href="javascript:void(0)" onclick="return intuit.ipp.anywhere.logout(function () { window.location.href = \'/OAuth_2/RefreshToken.php?deleteSession=true\'; });">Disconnect from Quickbooks</a>&nbsp;&nbsp;&nbsp;';
                } else {
                    echo "<br /></br></br> <ipp:connectToIntuit></ipp:connectToIntuit><br />";
                } ?>
            </td>
        </tr>
        </tbody>
    </table>

    <?php

    if ($account->getCompany()->hasQb()) {
        $incomeAccountId = $account->getCompany()->getQuickbooksSettings()->getIncomeAccountId();
        $expenseAccountId = $account->getCompany()->getQuickbooksSettings()->getExpenseAccountId();

        $hiddenAccounts = false;
        if ($incomeAccountId || $expenseAccountId) {
            $hiddenAccounts = true;
        }

        if($hiddenAccounts) {
?>
        <div  style="padding: 20px;">

            <h3>You're all set!</h3>

            <p style="padding: 10px;">
                You can now generate invoices in QuickBooks Online directly from <?php echo SITE_NAME;?>!<br />
            </p>

            <p style="padding: 10px;">
                Simple select 'Invoice' From the QuickBooks option on the proposals page and the invoice will be generated within 2 minutes.
            </p>

            <p style="padding: 10px;">
                <a href="#" id="toggleAccountSettings">
                    Show Expense Account Settings
                </a>
            </p>

        </div>
<?php
        }
    ?>

        <div style="padding: 20px;<?php echo $hiddenAccounts ? ' display: none;' : ''; ?>" id="expenseAccountSettings">

            <h3>Select QuickBooks Accounts</h3><br/>

            <p>When your services are synced to QuickBooks as Items, they must be attached to an Income Account and an Expense Account.</p>

            <p>Please choose the relevant accounts below to link your items to.</p>

            <br/><br/>

            <form method="post">
                <table style="padding: 10px;" width="100%">
                    <tr>
                        <td>
                            <label>Income Account</label>
                        </td>
                        <td>
                            <select name="income_account" id="incomeAccountSelect">
                                <option value="">-- Select Income Account</option>
                                <?php if(count($incomeAccounts)) { ?>
                                    <?php foreach ($incomeAccounts as $incomeAccount) { ?>
                                    <option value="<?php echo $incomeAccount->Id; ?>"<?php echo ($incomeAccount->Id == $incomeAccountId) ? ' selected' : ''; ?>><?php echo $incomeAccount->Name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>

                            <p>If you do not see any income accounts listed, <a href="mailto:andy@pavementlayers.com">send us an email</a></p>
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 10px;">
                    <button class="btn update-button" type="submit" id="saveIncomeAccount" name="save_accounts" value="1">Save Account Settings</button>
                </p>
            </form>
        </div>
        <?php
    }
    ?>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("#toggleAccountSettings").click(function() {
            $("#expenseAccountSettings").show();
            return false;
        });


        // Validate income account
        $("#saveIncomeAccount").click(function() {
            var incomeAccountId = $("#incomeAccountSelect").val();

            if (!incomeAccountId) {
                swal('Please select an Income Account!');
                return false;
            } else {
                return true;
            }
        });

    });

</script>