<h3>
    Login Details
</h3>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td width="180" align="right"><strong>Email</strong></td>
        <td width="70%"><?php echo $account->getEmail() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Full Name</strong></td>
        <td><?php echo $account->getFullName() ?></td>
    </tr>
    <tr class="">
        <td align="right"><strong>Title</strong></td>
        <td><?php echo $account->getTitle() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Address</strong></td>
        <td><?php echo $account->getAddress() ?></td>
    </tr>
    <tr class="">
        <td align="right"><strong>City</strong></td>
        <td><?php echo $account->getCity() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>State</strong></td>
        <td><?php echo $account->getState() ?></td>
    </tr>
    <tr class="">
        <td align="right"><strong>Zip</strong></td>
        <td><?php echo $account->getZip() ?></td>
    </tr>
    <tr class="even">
        <td align="right"><strong>Country</strong></td>
        <td><?php echo $account->getCountry() ?></td>
    </tr>
    <tr class="">
        <td align="right"><strong>Timezone</strong></td>
        <td><?php echo $account->gettimeZone() ?></td>
    </tr>
    </tbody>
</table>