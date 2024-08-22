<!-- add back button -->
<h3>
     &nbsp;
    &nbsp;
    <?php if ($account->isAdministrator()) { ?><a href="<?php echo site_url('account/edit_company_info') ?>">Edit</a><?php } ?>
</h3>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td width="180" align="right"><strong>Company Name</strong></td>
        <td width="285"><?php echo $account->getCompany()->getCompanyName() ?></td>
        <td width="180" align="right"><strong>Company Website</strong></td>
        <td width="285"><?php echo $account->getCompany()->getCompanyWebsite() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Company Address</strong></td>
        <td><?php echo $account->getCompany()->getCompanyAddress() ?></td>
        <td align="right"><strong>Administrator Email</strong></td>
        <td><?php echo $account->getCompany()->getAdministrator()->getEmail() ?></td>
    </tr>
    <tr>
        <td align="right"><strong>Company City</strong></td>
        <td><?php echo $account->getCompany()->getCompanyCity() ?></td>
        <td align="right"><strong>Company Phone Number</strong></td>
        <td><?php echo $account->getCompany()->getCompanyPhone() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Company State</strong></td>
        <td><?php echo $account->getCompany()->getCompanyState() ?></td>
        <td align="right"><strong>Fax</strong></td>
        <td><?php echo $account->getCompany()->getAlternatePhone() ?></td>
    </tr>
    <tr>
        <td align="right"><strong>Company Zip</strong></td>
        <td><?php echo $account->getCompany()->getCompanyZip() ?></td>
        <td align="right"><strong>Administrator</strong></td>
        <td><?php echo $account->getCompany()->getAdministrator()->getFullName() ?></td>
    </tr>
    </tbody>
</table>