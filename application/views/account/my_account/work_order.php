<!-- add a back button -->
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
    &nbsp;
    <a href="<?php echo site_url('account/add_work_order_address') ?>">Add New Address</a>
</h3>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td style="text-align: left;">Address</td>
        <td style="text-align: left;" width="75">Actions</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!count($addresses)) {
        ?>
        <tr>
            <td colspan="2" class="padded centered">No addresses defined! Use the buttons above to add.</td>
        </tr>
    <?php
    } else {
        $k = 0;
        foreach ($addresses as $address) {
            $k++;
            ?>
            <tr class="<?php echo ($k % 2) ? 'even' : 'odd'; ?>">
                <td><?php echo $address->getAddress() . ', ' . $address->getCity() . ', ' . $address->getState() . ', ' . $address->getZip() ?></td>
                <td><a class="btn-edit tiptip" title="Edit Address" href="<?php echo site_url('account/edit_work_order_address/' . $address->getAddressId()) ?>">&nbsp;</a>
                    <a class="btn-delete tiptip" title="Delete Address" href="<?php echo site_url('account/delete_work_order_address/' . $address->getAddressId()) ?>" id="deleteWO">&nbsp;</a></td>
            </tr>
        <?php
        }
    }
    ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $("#deleteWO").click(function () {
            return confirm('Are you sure you want to delete the address?');
        });
    });
</script>