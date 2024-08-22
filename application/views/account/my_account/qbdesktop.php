<style type="text/css">
    .QB-desktop {
        padding: 20px;
        width: 100%;
        float: left;
    }

    .QB-desktop li {
        padding: 10px;
        display: block;
        list-style-type: circle !important
    }

    p {
        padding: 10px 0;
    }
</style>
<?php
session_start();
$configs = include('config.php');
?>

<h3>Connect with QuickBooks Desktop</h3>

<?php
    // If no QB settings
    if (!$hasQb) {
        $this->load->view('account/my_account/quickbooks/desktop/download');
    } else {

        // We have QB - check if there are accounts
        if (!count($incomeAccounts)) {
            $this->load->view('account/my_account/quickbooks/desktop/sync-instructions');
        } else {

            // Check for a selected account
            if (!$selectedIncomeAccount) {
                // Show dropdown if there isn't one
                $this->load->view('account/my_account/quickbooks/desktop/select-income-account');
            } else {
                // Otherwise we're good
                $this->load->view('account/my_account/quickbooks/desktop/connected');
            }
        }
    }
?>
</div>


