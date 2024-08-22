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
                                <label style="text-align: left;">Check <a href="#" class="checkAll leads-fields">All</a> | <a href="#" class="checkNone leads-fields">None</a></label>
                            </p>

                            <div class="clearfix" id="leads-fields">
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Branch <input type="checkbox"<?php echo isset($params['fields']['branch']) ? ' checked="checked"' : ''; ?>name="fields[branch]" id="branch" value="Branch"/></label>
                                    <label class="checkbox-label">Created Date<input type="checkbox"<?php echo isset($params['fields']['created']) ? ' checked="checked"' : ''; ?>name="fields[created]" id="created" value="Created Date"/></label>
                                    <label class="checkbox-label">Converted Date<input type="checkbox"<?php echo isset($params['fields']['converted']) ? ' checked="checked"' : ''; ?>name="fields[converted]" id="converted" value="Converted Date"/></label>
                                    <label class="checkbox-label">Days to Convert<input type="checkbox"<?php echo isset($params['fields']['daystoconvert']) ? ' checked="checked"' : ''; ?>name="fields[daystoconvert]" id="daystoconvert" value="Days To Convert"/></label>
                                    <label class="checkbox-label">Source <input type="checkbox"<?php echo isset($params['fields']['source']) ? ' checked="checked"' : ''; ?>name="fields[source]" id="source" value="Source"/></label>
                                    <label class="checkbox-label">Status <input type="checkbox"<?php echo isset($params['fields']['status']) ? ' checked="checked"' : ''; ?>name="fields[status]" id="status" value="Status"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Rating <input type="checkbox"<?php echo isset($params['fields']['rating']) ? ' checked="checked"' : ''; ?>name="fields[rating]" id="rating" value="Rating"/></label>
                                    <label class="checkbox-label">Due Date <input type="checkbox"<?php echo isset($params['fields']['branch']) ? ' checked="checked"' : ''; ?>name="fields[due_date]" id="due_date" value="Due Date"/></label>
                                    <label class="checkbox-label">Owner <input type="checkbox"<?php echo isset($params['fields']['owner']) ? ' checked="checked"' : ''; ?>name="fields[owner]" id="owner" value="Owner"/></label>
                                    <label class="checkbox-label">Company <input type="checkbox"<?php echo isset($params['fields']['company']) ? ' checked="checked"' : ''; ?>name="fields[company]" id="company" value="Company"/></label>
                                    <label class="checkbox-label">First Name <input type="checkbox"<?php echo isset($params['fields']['firstName']) ? ' checked="checked"' : ''; ?>name="fields[firstName]" id="firstName" value="First Name"/></label>
                                    <label class="checkbox-label">Last Name <input type="checkbox"<?php echo isset($params['fields']['lastName']) ? ' checked="checked"' : ''; ?>name="fields[lastName]" id="lastName" value="Last Name"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Title <input type="checkbox"<?php echo isset($params['fields']['title']) ? ' checked="checked"' : ''; ?>name="fields[title]" id="title" value="Title"/></label>
                                    <label class="checkbox-label">Address <input type="checkbox"<?php echo isset($params['fields']['address']) ? ' checked="checked"' : ''; ?>name="fields[address]" id="address" value="Address"/></label>
                                    <label class="checkbox-label">City <input type="checkbox"<?php echo isset($params['fields']['city']) ? ' checked="checked"' : ''; ?>name="fields[city]" id="city" value="City"/></label>
                                    <label class="checkbox-label">State <input type="checkbox"<?php echo isset($params['fields']['state']) ? ' checked="checked"' : ''; ?>name="fields[state]" id="state" value="State"/></label>
                                    <label class="checkbox-label">Zip <input type="checkbox"<?php echo isset($params['fields']['zip']) ? ' checked="checked"' : ''; ?>name="fields[zip]" id="zip" value="Zip"/></label>
                                    <label class="checkbox-label">Business Phone <input type="checkbox"<?php echo isset($params['fields']['businessPhone']) ? ' checked="checked"' : ''; ?>name="fields[businessPhone]" id="businessPhone" value="Business Phone"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Cell Phone <input type="checkbox"<?php echo isset($params['fields']['cellPhone']) ? ' checked="checked"' : ''; ?>name="fields[cellPhone]" id="cellPhone" value="Cell Phone"/></label>
                                    <label class="checkbox-label">Email <input type="checkbox"<?php echo isset($params['fields']['email']) ? ' checked="checked"' : ''; ?>name="fields[email]" id="email" value="Email"/></label>
                                    <label class="checkbox-label">Website <input type="checkbox"<?php echo isset($params['fields']['website']) ? ' checked="checked"' : ''; ?>name="fields[website]" id="website" value="Website"/></label>
                                    <label class="checkbox-label">Project Name <input type="checkbox"<?php echo isset($params['fields']['project_name']) ? ' checked="checked"' : ''; ?>name="fields[project_name]" id="project_name" value="Project Name"/></label>
                                    <label class="checkbox-label">Contact Name <input type="checkbox"<?php echo isset($params['fields']['project_contact']) ? ' checked="checked"' : ''; ?>name="fields[project_contact]" id="project_contact" value="Contact Name"/></label>
                                    <label class="checkbox-label">Project Phone <input type="checkbox"<?php echo isset($params['fields']['project_phone']) ? ' checked="checked"' : ''; ?>name="fields[project_phone]" id="project_phone" value="Project Phone"/></label>
                                </div>
                                <div class="left" style="width: 155px;">
                                    <label class="checkbox-label">Project Address <input type="checkbox"<?php echo isset($params['fields']['project_address']) ? ' checked="checked"' : ''; ?>name="fields[project_address]" id="project_address" value="Project Address"/></label>
                                    <label class="checkbox-label">Project City <input type="checkbox"<?php echo isset($params['fields']['project_city']) ? ' checked="checked"' : ''; ?>name="fields[project_city]" id="project_city" value="Project City"/></label>
                                    <label class="checkbox-label">Project State <input type="checkbox"<?php echo isset($params['fields']['project_state']) ? ' checked="checked"' : ''; ?>name="fields[project_state]" id="project_state" value="Project State"/></label>
                                    <label class="checkbox-label">Project Zip <input type="checkbox"<?php echo isset($params['fields']['project_zip']) ? ' checked="checked"' : ''; ?>name="fields[project_zip]" id="project_zip" value="Project Zip"/></label>
                                    <label class="checkbox-label">Services <input type="checkbox"<?php echo isset($params['fields']['project_services']) ? ' checked="checked"' : ''; ?>name="fields[project_services]" id="project_services" value="Services"/></label>
                                    <label class="checkbox-label">Notes <input type="checkbox"<?php echo isset($params['fields']['project_notes']) ? ' checked="checked"' : ''; ?> name="fields[project_notes]" id="project_notes" value="Notes"/></label>
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