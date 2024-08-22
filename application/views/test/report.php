<?php $this->load->view('global/header'); ?>
<form action="" method="post" id="proposals-form" target="downloadFrame">
    <input type="hidden" name="export" value="proposals"/>
    <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <td>
                <h3 style="text-align: left;">Proposals</h3>
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td valign="top">
                <p class="clearfix">
                    Check on/off all the fields you need to export and click the download button to begin your export. Be patient as the download will start in a few seconds, depending on your internet speed.
                </p>

                <p class="clearfix">
                    <label style="text-align: left;">Check <a href="#" class="checkAll proposals-fields">All</a> | <a href="#" class="checkNone proposals-fields">None</a></label>
                </p>

                <div class="clearfix" id="proposals-fields">
                    <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Branch <input type="checkbox" checked="checked" name="fields[branch]" id="branch" value="Branch"/></label>
                        <label class="checkbox-label">Date Issued <input type="checkbox" checked="checked" name="fields[dateIssued]" id="dateIssued" value="Date Issued"/></label>
                        <label class="checkbox-label">Status <input type="checkbox" checked="checked" name="fields[status]" id="status" value="Status"/></label>
                        <label class="checkbox-label">Job Number <input type="checkbox" checked="checked" name="fields[jobNumber]" id="jobNumber" value="Job Number"/></label>
                    </div>
                    <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Project Name <input type="checkbox" checked="checked" name="fields[projectName]" id="projectName" value="Project Name"/></label>
                        <label class="checkbox-label">Total Price <input type="checkbox" checked="checked" name="fields[totalPrice]" id="totalPrice" value="Total Price"/></label>
                        <label class="checkbox-label">Owner <input type="checkbox" checked="checked" name="fields[owner]" id="owner" value="Owner"/></label>
                        <label class="checkbox-label">Client First Name <input type="checkbox" checked="checked" name="fields[client-firstName]" id="client-firstName" value="Client First Name"/></label>
                    </div>
                    <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Client Last Name <input type="checkbox" checked="checked" name="fields[client-lastName]" id="client-lastName" value="Client Last Name"/></label>
                        <label class="checkbox-label">Client Company <input type="checkbox" checked="checked" name="fields[client-company]" id="client-company" value="Client Company"/></label>
                        <label class="checkbox-label">Client Title <input type="checkbox" checked="checked" name="fields[client-title]" id="title" value="Client Title"/></label>
                        <label class="checkbox-label">Client Address <input type="checkbox" checked="checked" name="fields[client-address]" id="client-address" value="Client Address"/></label>
                    </div>
                    <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Client City <input type="checkbox" checked="checked" name="fields[client-city]" id="client-city" value="Client City"/></label>
                        <label class="checkbox-label">Client State <input type="checkbox" checked="checked" name="fields[client-state]" id="client-state" value="Client State"/></label>
                        <label class="checkbox-label">Client Zip <input type="checkbox" checked="checked" name="fields[client-zip]" id="client-zip" value="Client Zip"/></label>
                        <label class="checkbox-label">Client Office Ph <input type="checkbox" checked="checked" name="fields[client-businessPhone]" id="client-businessPhone" value="Client Business Phone"/></label>
                    </div>
                    <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Client Cell Phone <input type="checkbox" checked="checked" name="fields[client-cellPhone]" id="client-cellPhone" value="Client Cell Phone"/></label>
                        <label class="checkbox-label">Client Email <input type="checkbox" checked="checked" name="fields[client-email]" id="client-email" value="Client Email"/></label>
                        <label class="checkbox-label">Client Website <input type="checkbox" checked="checked" name="fields[client-website]" id="client-website" value="Client Website"/></label>
                        <label class="checkbox-label">Services <input type="checkbox" checked="checked" name="fields[services]" id="services" value="Services"/></label>
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
                        <option value="<?php echo $status->getStatusId() ?>"><?php echo $status->getText(); ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="clearfix"></div>

                <div style="display: block">

                    <label>Status Change Date: </label><input type="checkbox" id="statusApply" name="statusApply" /><label style="display: block; padding-right: 3px; text-align: left; width: auto;">Apply</label>
                    <div class="clearfix"></div>
                    <label>From: </label><input type="text" class="text" name="statusFrom" id="statusFrom" size="12" style="width: 66px;" value="<?php //echo $this->session->userdata('pFilterFrom') ?>">
                    <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="statusTo" id="statusTo" size="12" style="width: 66px;" value="<?php //echo $this->session->userdata('pFilterTo') ?>">
                    <!--<a style="margin-left: 10px; float: left;" class="btn" id="statusAllDates" href="#">All Time</a>-->
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
                        <option value="<?php echo $acc->getAccountId() ?>"><?php echo $acc->getFullName() ?></option>
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
                                    <option value="<?php echo $service->getServiceId() ?>"><?php echo $service->getServiceName() ?></option>
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
                <label>Created Date - From: </label><input type="text" class="text" name="from" id="from" size="12" style="width: 66px;" value="<?php echo $this->session->userdata('pFilterFrom') ?>">
                <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="to" id="to" size="12" style="width: 66px;" value="<?php echo $this->session->userdata('pFilterTo') ?>">
                <a style="margin-left: 10px; float: left;" class="btn" id="alldates" href="#">All Time</a>
            </td>
        </tr>
        <tr class="even">
            <td>
                <label>Save Export</label>
                <input type="checkbox" name="saveExport" id="saveExport" />
                <input type="text" class="text" name="saveExportName" id="saveExportName" placeholder="Enter Export Name" />
            </td>

        </tr>
        <tr class="odd">
            <td>
                <label>&nbsp;</label><a class="btn blue exportButton" id="proposals" href="#">Download .csv file</a>
                <button type="submit">Submit</button>
            </td>
        </tr>
        </tbody>
    </table>
</form>
<?php $this->load->view('global/footer'); ?>