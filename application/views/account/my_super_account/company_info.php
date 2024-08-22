<h3>
    &nbsp;
     <a href="<?php echo site_url('account/edit_parent_company_info') ?>">Edit</a>

</h3>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td width="180" align="right"><strong>Company Name</strong></td>
        <td width="285"><?php echo $parentCompany->getCompanyName() ?></td>
        <td width="180" align="right"><strong>Company Website</strong></td>
        <td width="285"><?php echo $parentCompany->getCompanyWebsite() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Company Address</strong></td>
        <td><?php echo $parentCompany->getCompanyAddress() ?></td>
        <td align="right"><strong>Administrator Email</strong></td>
        <td><?php echo $parentCompany->getAdministrator()->getEmail() ?></td>
    </tr>
    <tr>
        <td align="right"><strong>Company City</strong></td>
        <td><?php echo $parentCompany->getCompanyCity() ?></td>
        <td align="right"><strong>Company Phone Number</strong></td>
        <td><?php echo $parentCompany->getCompanyPhone() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Company State</strong></td>
        <td><?php echo $parentCompany->getCompanyState() ?></td>
        <td align="right"><strong>Fax</strong></td>
        <td><?php echo $parentCompany->getAlternatePhone() ?></td>
    </tr>
    <tr>
        <td align="right"><strong>Company Zip</strong></td>
        <td><?php echo $parentCompany->getCompanyZip() ?></td>
        <td align="right"><strong>Administrator</strong></td>
        <td><?php echo $parentCompany->getAdministrator()->getFullName() ?></td>
    </tr>
    </tbody>
</table>