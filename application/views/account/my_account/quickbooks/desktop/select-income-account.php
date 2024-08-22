<div class="padded">

    <p><strong>Final Step!</strong></p>

    <p>
        Choose the Income Account in your QuickBooks application that you want your proposals invoices to be assigned to.
    </p>


    <form method="post">
        <table width="100%">
            <tr>
                <td>
                    <label>Income Account</label>
                </td>
                <td>
                    <select name="income_account">
                        <option value="">-- Select Income Account</option>
                        <?php foreach ($incomeAccounts as $incomeAccount) { ?>
                            <option value="<?php echo $incomeAccount->getAccName(); ?>"
                                <?php echo  ($incomeAccount->getAccName() === $selectedIncomeAccount) ? 'selected' : ''; ?>>
                                <?php echo $incomeAccount->getAccName(); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </table>

        <p style="margin-top: 10px;">
            <button class="btn update-button" type="submit" name="save_accounts" value="1">Save Income Account</button>
        </p>
    </form>

</div>

