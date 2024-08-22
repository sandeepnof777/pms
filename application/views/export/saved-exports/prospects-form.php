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
                                <label style="text-align: left;">Check <a href="#" class="checkAll prospects-fields">All</a> | <a href="#" class="checkNone prospects-fields">None</a></label>
                            </p>

                            <div class="clearfix" id="prospects-fields">
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Branch <input type="checkbox"<?php echo isset($params['fields']['branch']) ? ' checked="checked"' : ''; ?>name="fields[branch]" id="branch" value="Branch"/></label>
                                    <label class="checkbox-label">First Name <input type="checkbox"<?php echo isset($params['fields']['firstName']) ? ' checked="checked"' : ''; ?>name="fields[firstName]" id="firstName" value="First Name"/></label>
                                    <label class="checkbox-label">Last Name <input type="checkbox"<?php echo isset($params['fields']['lastName']) ? ' checked="checked"' : ''; ?>name="fields[lastName]" id="lastName" value="Last Name"/></label>
                                    <label class="checkbox-label">Company <input type="checkbox"<?php echo isset($params['fields']['company']) ? ' checked="checked"' : ''; ?>name="fields[company]" id="company" value="Company"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Title <input type="checkbox"<?php echo isset($params['fields']['title']) ? ' checked="checked"' : ''; ?>name="fields[title]" id="title" value="Title"/></label>
                                    <label class="checkbox-label">Address <input type="checkbox"<?php echo isset($params['fields']['address']) ? ' checked="checked"' : ''; ?>name="fields[address]" id="address" value="Address"/></label>
                                    <label class="checkbox-label">City <input type="checkbox"<?php echo isset($params['fields']['city']) ? ' checked="checked"' : ''; ?>name="fields[city]" id="city" value="City"/></label>
                                    <label class="checkbox-label">State <input type="checkbox"<?php echo isset($params['fields']['state']) ? ' checked="checked"' : ''; ?>name="fields[state]" id="state" value="State"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Zip <input type="checkbox"<?php echo isset($params['fields']['zip']) ? ' checked="checked"' : ''; ?>name="fields[zip]" id="zip" value="Zip"/></label>
                                    <label class="checkbox-label">Business Phone <input type="checkbox"<?php echo isset($params['fields']['businessPhone']) ? ' checked="checked"' : ''; ?>name="fields[businessPhone]" id="businessPhone" value="Business Phone"/></label>
                                    <label class="checkbox-label">Cell Phone <input type="checkbox"<?php echo isset($params['fields']['cellPhone']) ? ' checked="checked"' : ''; ?>name="fields[cellPhone]" id="cellPhone" value="Cell Phone"/></label>
                                    <label class="checkbox-label">Fax <input type="checkbox"<?php echo isset($params['fields']['fax']) ? ' checked="checked"' : ''; ?>name="fields[fax]" id="fax" value="Fax"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Email <input type="checkbox"<?php echo isset($params['fields']['email']) ? ' checked="checked"' : ''; ?>name="fields[email]" id="email" value="Email"/></label>
                                    <label class="checkbox-label">Website <input type="checkbox"<?php echo isset($params['fields']['website']) ? ' checked="checked"' : ''; ?>name="fields[website]" id="website" value="Website"/></label>
                                    <label class="checkbox-label">Status <input type="checkbox"<?php echo isset($params['fields']['status']) ? ' checked="checked"' : ''; ?>name="fields[status]" id="status" value="Status"/></label>
                                    <label class="checkbox-label">Business Type <input type="checkbox"<?php echo isset($params['fields']['business']) ? ' checked="checked"' : ''; ?>name="fields[business]" id="business" value="Business Type"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Rating <input type="checkbox"<?php echo isset($params['fields']['rating']) ? ' checked="checked"' : ''; ?>name="fields[rating]" id="rating" value="Rating"/></label>
                                    <label class="checkbox-label">Owner <input type="checkbox"<?php echo isset($params['fields']['owner']) ? ' checked="checked"' : ''; ?>name="fields[owner]" id="owner" value="Owner"/></label>
                                </div>
                            </div>
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