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


                            <p class="clearfix">
                                <label style="text-align: left;">Check <a href="#" class="checkAll proposals-fields">All</a> | <a href="#" class="checkNone proposals-fields">None</a></label>
                            </p>

                            <div class="clearfix" id="proposals-fields">
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Job Number <input type="checkbox"<?php echo isset($params['fields']['jobNumber']) ? ' checked="checked"' : ''; ?>name="fields[jobNumber]" id="jobNumber" value="Job Number"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Project Name <input type="checkbox"<?php echo isset($params['fields']['projectName']) ? ' checked="checked"' : ''; ?>name="fields[projectName]" id="projectName" value="Project Name"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Contact Company <input type="checkbox"<?php echo isset($params['fields']['client-company']) ? ' checked="checked"' : ''; ?>name="fields[client-company]" id="client-company" value="Contact Company"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                </div>
                                <div class="left" style="width: 155px;">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Status</label>
                            <select name="status" id="status">
                                <option value="0">All</option>
                                <?php
                                foreach($statuses as $status){
                                    ?>
                                    <option value="<?php echo $status->getStatusId() ?>"<?php echo ($status->getStatusId() == $params['status']) ? ' selected' : ''; ?>><?php echo $status->getText(); ?></option>
                                <?php
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
                    <tr class="even">
                        <td>
                            <label>From: </label><input type="text" class="text" name="from" id="from2" size="12" style="width: 66px;" value="<?php echo $params['from']; ?>">
                            <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="to" id="to2" size="12" style="width: 66px;" value="<?php echo $params['to']; ?>">
                            <a style="margin-left: 10px; float: left;" class="btn" id="alldates2" href="#">All Time</a>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>
                            <label>Export Name</label>
                            <input type="text" class="text" name="saveExportName" id="saveExportName" placeholder="Enter Export Name" value="<?php echo $export->getReportName(); ?>" />
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