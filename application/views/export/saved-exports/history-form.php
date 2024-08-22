<div class="content-box">
    <div class="box-header">
        Edit Saved Export - <?php echo $export->getReportName(); ?>
        <a class="box-action" href="<?php echo site_url('account/export') ?>">Back</a>
    </div>
    <div class="box-content" style="padding: 15px;">

        <div id="export-forms">
            <form action="" method="post" id="proposals-form">
                <input type="hidden" name="export" value="proposals"/>
                <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td valign="top">
                            <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
                                <thead>
                                </thead>
                                <tbody>
                                <tr>
                                    <td valign="top">
                                        <label>Choose Year</label>
                                        <select name="year" id="year" style="margin-top: 3px;">
                                            <?php
                                            $endY = date('Y');
                                            for ($y = $endY; $y >= $startY; $y--) {
                                                ?>
                                                <option value="<?php echo $y; ?>"<?php echo ($y == $params['year']) ? ' selected' : ''; ?>><?php echo $y ?></option><?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <label>User</label>
                                        <select name="user" id="user">
                                            <option value="0">All</option>
                                            <?php
                                            foreach ($accounts as $acc) {
                                                ?>
                                                <option value="<?php echo $acc->getAccountId() ?>"<?php echo ($acc->getAccountId() == $params['user']) ? ' selected' : ''; ?>><?php echo $acc->getFullName() ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="">
                                    <td>
                                        <label>Export Name</label>
                                        <input type="text" class="text" name="saveExportName" id="saveExportName" placeholder="Enter Export Name" value="<?php echo $export->getReportName(); ?>" />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <label>&nbsp;</label><button type="submit" name="saveExport" class="btn ui-button update-button" value="1">Save Export
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>