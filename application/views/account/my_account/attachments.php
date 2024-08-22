
<p class="materialize right" style="padding: 5px 5px 10px 0px;">
    <a href="<?php echo site_url('account/company_add_attachment') ?>" class="m-btn blue-button"><i class="fa fa-fw fa-plus"></i> Add Attachment</a>
</p>
<table cellpadding="0" cellspacing="0" border="0" class="dataTables_a display half">
    <thead>
    <tr>
        <td>Attachment Name</td>
        <td>Category</td>
        <td>Include Automatically</td>
        <td width="70">Actions</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($attatchments as $attachment) {
        ?>
        <tr>
            <td>
                <a href="<?php echo site_url('attachments/' . $account->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath() ?>"><?php echo $attachment->getFileName() ?></a>
            </td>
            <td><?php echo ($attachment->getCategory() == 'admin') ? 'Admin &amp; Sales' : 'Marketing'; ?></td>
            <td>
                <?php echo ($attachment->getInclude()) ? 'Yes' : 'No'; ?>
            </td>
            <td style="text-align: center;">
                <a title="Edit Attachment" href="<?php echo site_url('account/edit_attachment/' . $attachment->getAttatchmentId()) ?>" class="tiptip btn-edit">&nbsp;</a>
                <a title="Delete Attachment" href="<?php echo site_url('account/company_attachments/delete/' . $attachment->getAttatchmentId()) ?>" class="tiptip confirm-deletion-attachment btn-delete">&nbsp;</a>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('.dataTables_a').dataTable({
            "bJQueryUI": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });
    });
</script>