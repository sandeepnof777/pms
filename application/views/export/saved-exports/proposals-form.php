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
                                    <label class="checkbox-label">Branch <input type="checkbox"<?php echo isset($params['fields']['branch']) ? ' checked="checked"' : ''; ?> name="fields[branch]" id="branch" value="Branch"/></label>
                                    <label class="checkbox-label">Date Issued <input type="checkbox"<?php echo isset($params['fields']['dateIssued']) ? ' checked="checked"' : ''; ?> name="fields[dateIssued]" id="dateIssued" value="Date Issued"/></label>
                                    <label class="checkbox-label">Status <input type="checkbox"<?php echo isset($params['fields']['status']) ? ' checked="checked"' : ''; ?> name="fields[status]" id="status" value="Status"/></label>
                                    <label class="checkbox-label">Job Number <input type="checkbox"<?php echo isset($params['fields']['jobNumber']) ? ' checked="checked"' : ''; ?> name="fields[jobNumber]" id="jobNumber" value="Job Number"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Project Name <input type="checkbox"<?php echo isset($params['fields']['projectName']) ? ' checked="checked"' : ''; ?> name="fields[projectName]" id="projectName" value="Project Name"/></label>
                                    <label class="checkbox-label">Total Price <input type="checkbox"<?php echo isset($params['fields']['totalPrice']) ? ' checked="checked"' : ''; ?> name="fields[totalPrice]" id="totalPrice" value="Total Price"/></label>
                                    <label class="checkbox-label">Owner <input type="checkbox"<?php echo isset($params['fields']['owner']) ? ' checked="checked"' : ''; ?> name="fields[owner]" id="owner" value="Owner"/></label>
                                    <label class="checkbox-label">Contact First Name <input type="checkbox"<?php echo isset($params['fields']['client-firstName']) ? ' checked="checked"' : ''; ?> name="fields[client-firstName]" id="client-firstName" value="Contact First Name"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Contact Last Name <input type="checkbox"<?php echo isset($params['fields']['client-lastName']) ? ' checked="checked"' : ''; ?> name="fields[client-lastName]" id="client-lastName" value="Contact Last Name"/></label>
                                    <label class="checkbox-label">Contact Company <input type="checkbox"<?php echo isset($params['fields']['client-company']) ? ' checked="checked"' : ''; ?> name="fields[client-company]" id="client-company" value="Contact Company"/></label>
                                    <label class="checkbox-label">Contact Title <input type="checkbox"<?php echo isset($params['fields']['client-title']) ? ' checked="checked"' : ''; ?> name="fields[client-title]" id="title" value="Contact Title"/></label>
                                    <label class="checkbox-label">Contact Address <input type="checkbox"<?php echo isset($params['fields']['client-address']) ? ' checked="checked"' : ''; ?> name="fields[client-address]" id="client-address" value="Contact Address"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Contact City <input type="checkbox"<?php echo isset($params['fields']['client-city']) ? ' checked="checked"' : ''; ?> name="fields[client-city]" id="client-city" value="Contact City"/></label>
                                    <label class="checkbox-label">Contact State <input type="checkbox"<?php echo isset($params['fields']['client-state']) ? ' checked="checked"' : ''; ?> name="fields[client-state]" id="client-state" value="Contact State"/></label>
                                    <label class="checkbox-label">Contact Zip <input type="checkbox"<?php echo isset($params['fields']['client-zip']) ? ' checked="checked"' : ''; ?> name="fields[client-zip]" id="client-zip" value="Contact Zip"/></label>
                                    <label class="checkbox-label">Contact Office Ph <input type="checkbox"<?php echo isset($params['fields']['client-businessPhone']) ? ' checked="checked"' : ''; ?> name="fields[client-businessPhone]" id="client-businessPhone" value="Contact Business Phone"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Contact Cell Phone <input type="checkbox"<?php echo isset($params['fields']['client-cellPhone']) ? ' checked="checked"' : ''; ?> name="fields[client-cellPhone]" id="client-cellPhone" value="Contact Cell Phone"/></label>
                                    <label class="checkbox-label">Contact Email <input type="checkbox"<?php echo isset($params['fields']['client-email']) ? ' checked="checked"' : ''; ?> name="fields[client-email]" id="client-email" value="Contact Email"/></label>
                                    <label class="checkbox-label">Contact Website <input type="checkbox"<?php echo isset($params['fields']['client-website']) ? ' checked="checked"' : ''; ?> name="fields[client-website]" id="client-website" value="Contact Website"/></label>
                                    <label class="checkbox-label">Services <input type="checkbox"<?php echo isset($params['fields']['services']) ? ' checked="checked"' : ''; ?> name="fields[services]" id="services" value="Services"/></label>
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
                                    <option value="<?php echo $status->getStatusId() ?>"<?php echo ($status->getStatusId() == $params['status']) ? ' selected' : ''?>><?php echo $status->getText(); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="clearfix"></div>

                            <div style="display: block">

                                <label>Status Change Date: </label><input type="checkbox" id="statusApply" name="statusApply"<?php echo isset($params['statusApply']) ? ' checked="checked"' : ''; ?> /><label style="display: block; padding-right: 3px; text-align: left; width: auto;">Apply</label>
                                <div class="clearfix"></div>
                                <label>From: </label><input type="text" class="text" name="statusFrom" id="statusFrom" size="12" style="width: 66px;" value="<?php echo $params['statusFrom'];  ?>">
                                <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="statusTo" id="statusTo" size="12" style="width: 66px;" value="<?php echo $params['statusTo'];  ?>">
                                <a style="margin-left: 10px; float: left;" class="btn" id="statusAllDates" href="#">All Time</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" id="statusHelp" title="Enter dates or period here to see the actual date that a status changed. <br /><br />For instance, a proposal was created 2/5/14 and changed to 'Won' on 6/14/14."><div class="help" style="display: inline-block; margin-top: 2px;" title="Help">?</div></a>

                            </div>
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
                            <label>Service</label>
                            <select name="service" id="service">
                                <option value="0">All</option>
                                <?php
                                foreach ($categories as $cat) {
                                    ?>
                                    <optgroup label="<?php echo $cat->getServiceName() ?>">
                                        <?php
                                        if (isset($services[$cat->getServiceId()])) {
                                            foreach ($services[$cat->getServiceId()] as $service) {
                                                ?>
                                                <option value="<?php echo $service->getServiceId() ?>"<?php echo ($service->getServiceId() == $params['service']) ? ' selected' : ''; ?>><?php echo $service->getServiceName() ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </optgroup>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="">
                        <td>
                            <label>Created Date - From: </label><input type="text" class="text" name="from" id="from" size="12" style="width: 66px;" value="<?php echo $params['from'] ?>">
                            <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="to" id="to" size="12" style="width: 66px;" value="<?php echo $params['to']; ?>">
                            <a style="margin-left: 10px; float: left;" class="btn" id="alldates" href="#">All Time</a>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Export Name</label>
                            <input type="text" class="text" name="saveExportName" id="saveExportName" placeholder="Enter Export Name" value="<?php echo $export->getReportName(); ?>" />
                        </td>

                    </tr>
                    <tr class="odd">
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