<?php
session_start();
$configs = include('config.php');
$redirect_uri = $configs['oauth_redirect_uri'];
$openID_redirect_uri = $configs['openID_redirect_uri'];
$refreshTokenPage = $configs['refreshTokenPage'];
if (isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])) {
    if ($this->uri->segment(3) != 'qblogin') {
        redirect('/datauploadqb/insertQbLogin/' . $_SESSION['access_token'] . '/' . $_SESSION['refresh_token'],
            'refresh');
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


    $(document).ready(function() {

        // Validate income account
        $("#saveIncomeAccount").click(function()) {

            var incomeAccountId = $("#incomeAccountSelect").val();

            if (!incomeAccountId) {
                swal('Please select an Income Account!');
                return false;
            }

            return true;
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
        ?>

        <div style="padding: 20px;">

            <h3>Select QuickBooks Accounts</h3><br/>

            <p>When your services are synced to QuickBooks as Items, they must be attached to an Income Account.</p>

            <p>Please choose the account below to link your items to.</p>

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
                                <?php foreach ($incomeAccounts as $incomeAccount) { ?>
                                    <option value="<?php echo $incomeAccount->Id; ?>"<?php echo ($incomeAccount->Id == $incomeAccountId) ? ' selected' : ''; ?>><?php echo $incomeAccount->Name; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 10px;">
                    <button class="btn update-button" type="submit" id="saveIncomeAccount" name="save_accounts" value="1">Save Account</button>
                </p>
            </form>
        </div>
        <?php
    }
    ?>
</div>