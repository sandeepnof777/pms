<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
<div class="widthfix">

<div class="content-box">
<div class="box-header">
    
    Export
    <?php if (help_box(84)) { ?>
        <div class="help box-center center tiptip" title="Help"><?php help_box(84, true) ?></div>
    <?php
    } ?>

 <!-- add a back button  -->
&nbsp;
<a style="font-size:14px;float:right;color:white;" href="<?php echo site_url('account/my_account') ?>">Back</a>
 
</div>

<div class="box-content clearfix" style="background: #fafafa;">

<ul id="export-areas">
    <li><a href="#tabs-0">Home</a></li>
    <li><a href="#tabs-1">Prospects</a></li>
    <li><a href="#tabs-2">Leads</a></li>
    <li><a href="#tabs-3">Contacts</a></li>
    <li><a href="#tabs-4">Proposals</a></li>
    <li><a href="#tabs-5">History</a></li>
    <li><a href="#tabs-6">Services</a></li>
    <li><a href="#tabs-8" id="savedExportsTabLink">Saved Exports</a></li>
    <li><a href="#tabs-9" id="accountExport">Account</a></li>

    <!--    <li><a href="#tabs-7">Exports Queue</a></li>-->
</ul>
<div id="export-forms">
<div id="tabs-0">
    <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <td>
                <h3 style="text-align: left;">Exports</h3>
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td valign="top">
                <p>You can export all of your organization's data into a set of excel comma-separated values (CSV) files. This permission is granted by default only to the Company Administrator profile.</p>

                <p>
                    <br>
                    In order to view the exported file correctly, make sure that you have <b>Excel</b> or <b>Numbers</b> installed on your machine.
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div id="tabs-1">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="prospects-form" target="downloadFrame">
        <input type="hidden" name="export" value="prospects"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">Prospects</h3>
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
                        <label style="text-align: left;">Check <a href="#" class="checkAll prospects-fields">All</a> | <a href="#" class="checkNone prospects-fields">None</a></label>
                    </p>

                    <div class="clearfix" id="prospects-fields">
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Branch <input type="checkbox" checked="checked" name="fields[branch]" id="branch" value="Branch"/></label>
                            <label class="checkbox-label">First Name <input type="checkbox" checked="checked" name="fields[firstName]" id="firstName" value="First Name"/></label>
                            <label class="checkbox-label">Last Name <input type="checkbox" checked="checked" name="fields[lastName]" id="lastName" value="Last Name"/></label>
                            <label class="checkbox-label">Company <input type="checkbox" checked="checked" name="fields[company]" id="company" value="Company"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Title <input type="checkbox" checked="checked" name="fields[title]" id="title" value="Title"/></label>
                            <label class="checkbox-label">Address <input type="checkbox" checked="checked" name="fields[address]" id="address" value="Address"/></label>
                            <label class="checkbox-label">City <input type="checkbox" checked="checked" name="fields[city]" id="city" value="City"/></label>
                            <label class="checkbox-label">State <input type="checkbox" checked="checked" name="fields[state]" id="state" value="State"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Zip <input type="checkbox" checked="checked" name="fields[zip]" id="zip" value="Zip"/></label>
                            <label class="checkbox-label">Business Phone <input type="checkbox" checked="checked" name="fields[businessPhone]" id="businessPhone" value="Business Phone"/></label>
                            <label class="checkbox-label">Cell Phone <input type="checkbox" checked="checked" name="fields[cellPhone]" id="cellPhone" value="Cell Phone"/></label>
                            <label class="checkbox-label">Fax <input type="checkbox" checked="checked" name="fields[fax]" id="fax" value="Fax"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Email <input type="checkbox" checked="checked" name="fields[email]" id="email" value="Email"/></label>
                            <label class="checkbox-label">Website <input type="checkbox" checked="checked" name="fields[website]" id="website" value="Website"/></label>
                            <label class="checkbox-label">Status <input type="checkbox" checked="checked" name="fields[status]" id="status" value="Status"/></label>
                            <label class="checkbox-label">Business Type <input type="checkbox" checked="checked" name="fields[business]" id="business" value="Business Type"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Rating <input type="checkbox" checked="checked" name="fields[rating]" id="rating" value="Rating"/></label>
                            <label class="checkbox-label">Owner <input type="checkbox" checked="checked" name="fields[owner]" id="owner" value="Owner"/></label>
                            <label class="checkbox-label">Source <input type="checkbox" checked="checked" name="fields[source]" id="source" value="Source"/></label>
                        </div>
                    </div>

                    <br/>
                    <label style="width: 100px; float:left;">Save Export</label>
                    <input type="checkbox" name="saveExport" id="prospectSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="prospectSaveExportName" placeholder="Enter Export Name"/>

                </td>
            </tr>
            <tr class="even">
                <td>
                    <a class="btn blue exportButton" id="prospects" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-2">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="leads-form" target="downloadFrame">
        <input type="hidden" name="export" value="leads"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">Leads</h3>
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
                        <label style="text-align: left;">Check <a href="#" class="checkAll leads-fields">All</a> | <a href="#" class="checkNone leads-fields">None</a></label>
                    </p>

                    <div class="clearfix" id="leads-fields">
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Branch <input type="checkbox" checked="checked" name="fields[branch]" id="branch" value="Branch"/></label>
                            <label class="checkbox-label">Created Date<input type="checkbox" checked="checked" name="fields[created]" id="created" value="Created Date"/></label>
                            <label class="checkbox-label">Converted Date<input type="checkbox" checked="checked" name="fields[converted]" id="converted" value="Converted Date"/></label>
                            <label class="checkbox-label">Days to Convert<input type="checkbox" checked="checked" name="fields[daystoconvert]" id="daystoconvert" value="Days To Convert"/></label>
                            <label class="checkbox-label">Source <input type="checkbox" checked="checked" name="fields[source]" id="source" value="Source"/></label>
                            <label class="checkbox-label">Status <input type="checkbox" checked="checked" name="fields[status]" id="status" value="Status"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Rating <input type="checkbox" checked="checked" name="fields[rating]" id="rating" value="Rating"/></label>
                            <label class="checkbox-label">Due Date <input type="checkbox" checked="checked" name="fields[due_date]" id="due_date" value="Due Date"/></label>
                            <label class="checkbox-label">Owner <input type="checkbox" checked="checked" name="fields[owner]" id="owner" value="Owner"/></label>
                            <label class="checkbox-label">Company <input type="checkbox" checked="checked" name="fields[company]" id="company" value="Company"/></label>
                            <label class="checkbox-label">First Name <input type="checkbox" checked="checked" name="fields[firstName]" id="firstName" value="First Name"/></label>
                            <label class="checkbox-label">Last Name <input type="checkbox" checked="checked" name="fields[lastName]" id="lastName" value="Last Name"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Title <input type="checkbox" checked="checked" name="fields[title]" id="title" value="Title"/></label>
                            <label class="checkbox-label">Address <input type="checkbox" checked="checked" name="fields[address]" id="address" value="Address"/></label>
                            <label class="checkbox-label">City <input type="checkbox" checked="checked" name="fields[city]" id="city" value="City"/></label>
                            <label class="checkbox-label">State <input type="checkbox" checked="checked" name="fields[state]" id="state" value="State"/></label>
                            <label class="checkbox-label">Zip <input type="checkbox" checked="checked" name="fields[zip]" id="zip" value="Zip"/></label>
                            <label class="checkbox-label">Business Phone <input type="checkbox" checked="checked" name="fields[businessPhone]" id="businessPhone" value="Business Phone"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Cell Phone <input type="checkbox" checked="checked" name="fields[cellPhone]" id="cellPhone" value="Cell Phone"/></label>
                            <label class="checkbox-label">Email <input type="checkbox" checked="checked" name="fields[email]" id="email" value="Email"/></label>
                            <label class="checkbox-label">Website <input type="checkbox" checked="checked" name="fields[website]" id="website" value="Website"/></label>
                            <label class="checkbox-label">Project Name <input type="checkbox" checked="checked" name="fields[project_name]" id="project_name" value="Project Name"/></label>
                            <label class="checkbox-label">Contact Name <input type="checkbox" checked="checked" name="fields[project_contact]" id="project_contact" value="Contact Name"/></label>
                            <label class="checkbox-label">Project Phone <input type="checkbox" checked="checked" name="fields[project_phone]" id="project_phone" value="Project Phone"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Project Address <input type="checkbox" checked="checked" name="fields[project_address]" id="project_address" value="Project Address"/></label>
                            <label class="checkbox-label">Project City <input type="checkbox" checked="checked" name="fields[project_city]" id="project_city" value="Project City"/></label>
                            <label class="checkbox-label">Project State <input type="checkbox" checked="checked" name="fields[project_state]" id="project_state" value="Project State"/></label>
                            <label class="checkbox-label">Project Zip <input type="checkbox" checked="checked" name="fields[project_zip]" id="project_zip" value="Project Zip"/></label>
                            <label class="checkbox-label">Services <input type="checkbox" checked="checked" name="fields[project_services]" id="project_services" value="Services"/></label>
                            <label class="checkbox-label">Notes <input type="checkbox" name="fields[project_notes]" id="project_notes" value="Notes"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Business Type <input type="checkbox" checked="checked" name="fields[lead_business_type]" id="lead_business_type" value="Business Type"/></label>
                        </div>
                    </div>
                    <br/>
                    <label style="width: 100px; float:left;">Save Export</label>
                    <input type="checkbox" name="saveExport" id="leadSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="leadSaveExportName" placeholder="Enter Export Name"/>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <a class="btn blue exportButton" id="leads" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-3">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="clients-form" target="downloadFrame">
        <input type="hidden" name="export" value="clients"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">Clients</h3>
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
                        <label style="text-align: left;">Check <a href="#" class="checkAll clients-fields">All</a> | <a href="#" class="checkNone clients-fields">None</a></label>
                    </p>

                    <div class="clearfix" id="clients-fields">
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Branch <input type="checkbox" checked="checked" name="fields[branch]" id="branch" value="Branch"/></label>
                            <label class="checkbox-label">First Name <input type="checkbox" checked="checked" name="fields[firstName]" id="firstName" value="First Name"/></label>
                            <label class="checkbox-label">Last Name <input type="checkbox" checked="checked" name="fields[lastName]" id="lastName" value="Last Name"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Company <input type="checkbox" checked="checked" name="fields[company]" id="company" value="Company"/></label>
                            <label class="checkbox-label">Title <input type="checkbox" checked="checked" name="fields[title]" id="title" value="Title"/></label>
                            <label class="checkbox-label">Address <input type="checkbox" checked="checked" name="fields[address]" id="address" value="Address"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">City <input type="checkbox" checked="checked" name="fields[city]" id="city" value="City"/></label>
                            <label class="checkbox-label">State <input type="checkbox" checked="checked" name="fields[state]" id="state" value="State"/></label>
                            <label class="checkbox-label">Zip <input type="checkbox" checked="checked" name="fields[zip]" id="zip" value="Zip"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Business Phone <input type="checkbox" checked="checked" name="fields[businessPhone]" id="businessPhone" value="Business Phone"/></label>
                            <label class="checkbox-label">Cell Phone <input type="checkbox" checked="checked" name="fields[cellPhone]" id="cellPhone" value="Cell Phone"/></label>
                            <label class="checkbox-label">Email <input type="checkbox" checked="checked" name="fields[email]" id="email" value="Email"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Website <input type="checkbox" checked="checked" name="fields[website]" id="website" value="Website"/></label>
                            <label class="checkbox-label">Owner <input type="checkbox" checked="checked" name="fields[owner]" id="owner" value="Owner"/></label>
                        </div>
                    </div>
                    <br/>
                    <label style="width: 100px; float:left;">Save Export</label>
                    <input type="checkbox" name="saveExport" id="clientSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="clientSaveExportName" placeholder="Enter Export Name"/>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <a class="btn blue exportButton" id="clients" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-4">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="proposals-form" target="downloadFrame">
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
                            <label class="checkbox-label">Date Issued <input type="checkbox" checked="checked" name="fields[dateIssued]" id="dateIssued" value="Date Issued"/></label>
                            <label class="checkbox-label">Owner <input type="checkbox" checked="checked" name="fields[owner]" id="owner" value="Owner"/></label>
                            <label class="checkbox-label">Status <input type="checkbox" checked="checked" name="fields[status]" id="status" value="Status"/></label>
                            <label class="checkbox-label">Branch <input type="checkbox" checked="checked" name="fields[branch]" id="branch" value="Branch"/></label>
                            <label class="checkbox-label">Job Number <input type="checkbox" checked="checked" name="fields[jobNumber]" id="jobNumber" value="Job Number"/></label>
                            <label class="checkbox-label">Business Type <input type="checkbox" checked="checked" name="fields[proposal_business_type]" id="proposal_business_type" value="Business Type"/></label>

                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Project Name <input type="checkbox" checked="checked" name="fields[projectName]" id="projectName" value="Project Name"/></label>
                            <label class="checkbox-label">Project Address <input type="checkbox" checked="checked" name="fields[project-address]" id="project-address" value="Project Address"/></label>
                            <label class="checkbox-label">Project City <input type="checkbox" checked="checked" name="fields[project-city]" id="project-city" value="Project City"/></label>
                            <label class="checkbox-label">Project State <input type="checkbox" checked="checked" name="fields[project-state]" id="project-state" value="Project State"/></label>
                            <label class="checkbox-label">Project Zip <input type="checkbox" checked="checked" name="fields[project-zip]" id="project-zip" value="Project Zip"/></label>

                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">First Name <input type="checkbox" checked="checked" name="fields[client-firstName]" id="client-firstName" value="First Name"/></label>
                            <label class="checkbox-label">Last Name <input type="checkbox" checked="checked" name="fields[client-lastName]" id="client-lastName" value="Last Name"/></label>
                            <label class="checkbox-label">Contact Company <input type="checkbox" checked="checked" name="fields[client-company]" id="client-company" value="Contact Company"/></label>
                            <label class="checkbox-label">Contact Title <input type="checkbox" checked="checked" name="fields[client-title]" id="title" value="Contact Title"/></label>
                            <label class="checkbox-label">Contact Address <input type="checkbox" checked="checked" name="fields[client-address]" id="client-address" value="Contact Address"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Contact City <input type="checkbox" checked="checked" name="fields[client-city]" id="client-city" value="Contact City"/></label>
                            <label class="checkbox-label">Contact State <input type="checkbox" checked="checked" name="fields[client-state]" id="client-state" value="Contact State"/></label>
                            <label class="checkbox-label">Contact Zip <input type="checkbox" checked="checked" name="fields[client-zip]" id="client-zip" value="Contact Zip"/></label>
                            <label class="checkbox-label">Contact Office Ph <input type="checkbox" checked="checked" name="fields[client-businessPhone]" id="client-businessPhone" value="Contact Business Phone"/></label>
                            <label class="checkbox-label">Cell Phone <input type="checkbox" checked="checked" name="fields[client-cellPhone]" id="client-cellPhone" value="Cell Phone"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Contact Email <input type="checkbox" checked="checked" name="fields[client-email]" id="client-email" value="Contact Email"/></label>
                            <label class="checkbox-label">Contact Website <input type="checkbox" checked="checked" name="fields[client-website]" id="client-website" value="Contact Website"/></label>
                            <label class="checkbox-label">Services <input type="checkbox" checked="checked" name="fields[services]" id="services" value="Services"/></label>
                            <label class="checkbox-label">Total Price <input type="checkbox" checked="checked" name="fields[totalPrice]" id="totalPrice" value="Total Price"/></label>

                            <label class="checkbox-label">Lead Source <input type="checkbox" checked="checked" name="fields[lead-source]" id="lead-source" value="Lead Source"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                        <label class="checkbox-label">Won Date<input type="checkbox" checked="checked" name="fields[win-date]" id="win-date" value="Won date"/></label>
                         </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Invoice Date <input type="checkbox" checked="checked" name="fields[invoice-date]" id="invoice-date" value="Invoice Date"/></label>
                        </div>
                     <input type="hidden" checked="checked" name="fields[proposal-id]" id="proposal-id" value="proposal-id"/> 


                    </div>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Status</label>
                    <select name="status" id="status">
                        <option value="0">All</option>
                        <?php
                        foreach ($statuses as $status) {
                            ?>
                            <option value="<?php echo $status->getStatusId() ?>"><?php echo $status->getText(); ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <div class="clearfix"></div>
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
            <tr class="odd">
                <td>
                    <div style="display: block">

                        <label>Status Change Date: </label><input type="checkbox" id="statusApply" name="statusApply"/><label style="display: block; padding-right: 3px; text-align: left; width: auto;">Apply</label>

                        <div class="clearfix"></div>
                        <label>From: </label><input type="text" class="text" name="statusFrom" id="statusFrom" size="12" style="width: 66px;" value="<?php //echo $this->session->userdata('pFilterFrom') ?>">
                        <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="statusTo" id="statusTo" size="12" style="width: 66px;" value="<?php //echo $this->session->userdata('pFilterTo') ?>">
                        <a style="margin-left: 10px; float: left;" class="btn" id="statusAllDates" href="#">All Time</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#" id="statusHelp" title="Enter dates or period here to see the actual date that a status changed. <br /><br />For instance, a proposal was created 2/5/14 and changed to 'Won' on 6/14/14.">
                            <div class="help" style="display: inline-block; margin-top: 2px;" title="Help">?</div>
                        </a>


                    </div>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Save Export</label>
                    <input type="checkbox" name="saveExport" id="proposalSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="proposalSaveExportName" placeholder="Enter Export Name"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" id="saveExportHelp" title="You can save the details of this export so that they can easily be run again later with one click.">
                        <div class="help" style="display: inline-block; margin-top: 2px;" title="Help">?</div>
                    </a>
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>&nbsp;</label><a class="btn blue exportButton" id="proposals" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-5">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="history-form" target="downloadFrame">
        <input type="hidden" name="export" value="history"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">History</h3>
                </td>
            </tr>
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
                            <option><?php echo $y ?></option><?php
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
                            <option value="<?php echo $acc->getAccountId() ?>"><?php echo $acc->getFullName() ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="">
                <td>
                    <br/>
                    <label>Save Export</label>
                    <input type="checkbox" name="saveExport" id="historySaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="historySaveExportName" placeholder="Enter Export Name"/>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>&nbsp;</label><a class="btn blue exportButton" id="history" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-6">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="services-form" target="downloadFrame">
        <input type="hidden" name="export" value="services"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">Services</h3>
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
                            <label class="checkbox-label">Job Number <input type="checkbox" checked="checked" name="fields[jobNumber]" id="jobNumber" value="Job Number"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Project Name <input type="checkbox" checked="checked" name="fields[projectName]" id="projectName" value="Project Name"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Contact Company <input type="checkbox" checked="checked" name="fields[client-company]" id="client-company" value="Contact Company"/></label>
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
                        foreach ($statuses as $status) {
                            ?>
                            <option value="<?php echo $status->getStatusId() ?>"><?php echo $status->getText(); ?></option>
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
                            <option value="<?php echo $acc->getAccountId() ?>"><?php echo $acc->getFullName() ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>From: </label><input type="text" class="text" name="from" id="from2" size="12" style="width: 66px;" value="<?php echo $this->session->userdata('pFilterFrom') ?>">
                    <label style="display: block; padding-right: 3px; text-align: left; width: auto;"> To: </label><input type="text" class="text" name="to" id="to2" size="12" style="width: 66px;" value="<?php echo $this->session->userdata('pFilterTo') ?>">
                    <a style="margin-left: 10px; float: left;" class="btn" id="alldates2" href="#">All Time</a>
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Save Export</label>
                    <input type="checkbox" name="saveExport" id="serviceSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="serviceSaveExportName" placeholder="Enter Export Name"/>
                </td>
            </tr>
            <tr class="">
                <td>
                    <label>&nbsp;</label><a class="btn blue exportButton" id="services" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="tabs-7">
    <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <td>
                <h3 style="text-align: left;">Export Queue - Showing last 20 exports</h3>
            </td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td valign="top">
                <p>You can export all of your organization's data into a set of excel comma-separated values (CSV) files. This permission is granted by default only to the Company Administrator profile.</p>

                <p>
                    <br>
                    In order to view the exported file correctly, make sure that you have <b>Excel</b> or <b>Numbers</b> installed on your machine.
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<div id="tabs-8">
    <h3>Saved Exports</h3>


    <table id="tblSavedExports" class="dataTables">
        <thead>
        <tr>
            <th>Export Name</th>
            <th>Export Type</th>
            <th>Created By</th>
            <th>Details</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($savedExports as $savedExport) {
            /* @var $savedExport \models\SavedReport */

            ?>
            <tr>
                <td><?php echo $savedExport->getReportName(); ?></td>
                <td><?php echo $savedExport->getReportType()->getName(); ?></td>
                <td><?php echo $savedExport->getAccount()->getFullName(); ?></td>
                <!--<td><a href="#" class="tiptip " title="<?php echo $savedExport->getDisplayCriteria(); ?>">View Criteria</a></td>-->
                <td><a href="#" class="export-details" data-export-id="<?php echo $savedExport->getId(); ?>" title="<?php //echo $savedExport->getDisplayCriteria(); ?>">View Details</a></td>
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" class="edit-status tiptip runExport" data-export-id="<?php echo $savedExport->getId(); ?>" style="display: inline-block" title="Run Export"><img src="/3rdparty/icons/application_view_list.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="<?php echo site_url('export/edit_export/' . $savedExport->getId()); ?>" class="edit-status tiptip" style="display: inline-block" title="Edit Export"><img src="/3rdparty/icons/application_edit.png"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#" class="edit-status tiptip exportDelete" style="display: inline-block" data-export-id="<?php echo $savedExport->getId(); ?>" title="Delete Saved Export"><img src="/3rdparty/icons/application_form_delete.png"></a>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>

    </table>
</div>

<!--export account start -->
<div id="tabs-9">
    <form action="<?php echo site_url('ajax/exportCSVData') ?>" method="post" id="accounts-form" target="downloadFrame">
        <input type="hidden" name="export" value="accounts"/>
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <td>
                    <h3 style="text-align: left;">Accounts</h3>
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
                        <label style="text-align: left;">Check <a href="#" class="checkAll accounts-fields">All</a> | <a href="#" class="checkNone accounts-fields">None</a></label>
                    </p>

                    <div class="clearfix" id="accounts-fields">
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Name <input type="checkbox" checked="checked" name="fields[name]" id="name" value="name"/></label>
                            <label class="checkbox-label">Email <input type="checkbox" checked="checked" name="fields[email]" id="email" value="email"/></label>
                            <label class="checkbox-label">Phone <input type="checkbox" checked="checked" name="fields[phone]" id="phone" value="phone"/></label>

                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Address <input type="checkbox" checked="checked" name="fields[address]" id="address" value="address"/></label>
                            <label class="checkbox-label">City <input type="checkbox" checked="checked" name="fields[city]" id="city" value="city"/></label>
                            <label class="checkbox-label">State <input type="checkbox" checked="checked" name="fields[state]" id="state" value="state"/></label>
                        </div>
                        <div class="left" style="width: 155px;">
                            <label class="checkbox-label">Zip <input type="checkbox" checked="checked" name="fields[zip]" id="zip" value="zip"/></label>
                            <label class="checkbox-label">Website <input type="checkbox" checked="checked" name="fields[website]" id="website" value="website"/></label>
                          </div>
                   
                    </div>
                    <br/>
                    <label style="width: 100px; float:left;">Save Export</label>
                    <input type="checkbox" name="saveExport" id="accountSaveExport"/>
                    <input type="text" class="text" name="saveExportName" id="accountSaveExportName" placeholder="Enter Export Name"/>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <a class="btn blue exportButton" id="accounts" href="#">Download .csv file</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<!--export account close -->

</div>
</div>
</div>
</div>

<div id="confirm-delete-message" title="Confirmation" data-export-id="">
    <p>Are you sure you want to delete this saved export?</p>
</div>

<div id="confirm-run-message" title="Confirmation" data-export-id="">
    <p>Your export is being generated!</p><br/>

    <p>You will be emailed a download link as soon as the export is complete</p>
</div>


<div id="save-name-required" title="Error">
    <p>Please enter a name for your saved export!</p>
</div>

<div id="saved-export-details" title="Saved Export Details">
    <h3 id="saved-export-details-title"></h3>

    <p>Created by <span id="saved-export-details-user"></span></p><br/>
    <hr/>
    <div id="saved-export-details-criteria"></div>
    <br/><br/>
    <button id="saved-export-details-edit" data-export-id="" class="btn ui-button">Edit Export</button>
    <button id="saved-export-details-run" data-export-id="" class="btn ui-button update-button">Run Export</button>
</div>

<div id="confirm-export" title="Confirmation">
    <p>Your export is being generated!</p><br/>

    <p>You will be emailed a download link as soon as the export is complete</p>
</div>


<iframe src="about:blank" frameborder="0" width="1" height="1" name="downloadFrame" id="downloadFrame"></iframe>
</div>
<script type="text/javascript">
$(function () {
    $(".checkAll, .checkNone").click(function () {
        var id = "prospects-fields";
        //check if other buttons are clicked
        if ($(this).hasClass('leads-fields')) {
            id = 'leads-fields';
        } else if ($(this).hasClass('clients-fields')) {
            id = 'clients-fields';
        } else if ($(this).hasClass('proposals-fields')) {
            id = 'proposals-fields';
        }
        else if ($(this).hasClass('accounts-fields')) {
            id = 'accounts-fields';
        }
        //todo: once we move on
        id = '#' + id;
        var checked = true;
        if ($(this).hasClass('checkNone')) {
            checked = false;
        }
        $(id).find('input').each(function () {
            if (checked) {
                $(this).attr('checked', 'checked');
            } else {
                $(this).removeAttr('checked');
            }
        });
        $.uniform.update();
        return false;
    });

    $("#export-forms > div").hide();
    $("#export-forms > div:first").show();
    $("#export-areas a, #export-areas li").removeClass('active');
    $("#export-areas a:first").addClass('active');
    $("#export-areas a.active").parent().addClass('active');
    $("#export-areas a").click(function () {
        var tab = $(this).attr('href');
        $("#export-forms > div").hide();
        $(tab).show();
        $("#export-areas a, #export-areas li").removeClass('active');
        $(this).addClass('active');
        $("#export-areas a.active").parent().addClass('active');
        return false;
    });


    /*
     Redirect to tab if required
     */
    var selectedTab = '<?php echo $tab; ?>';

    if (selectedTab == 'savedExports') {
        // Clear other formatting
        $("#export-forms > div").hide();
        $("#export-areas a, #export-areas li").removeClass('active');

        // Highlight correct link
        $("#savedExportsTabLink").addClass('active');
        var contentTab = $(savedExportsTabLink).attr('href');
        $(contentTab).show();
    }

    //export codes here

    $(".exportButton").click(function () {
        //data for the export build up
        var data = {};
        //select export type
        var form = '';

        console.log($(this).attr('id'));

        switch ($(this).attr('id')) {
            case 'prospects':

                var prospectOk = true;

                if ($("#prospects-fields").find('input:checked').length == 0) {
                    alert('You have to select at least one field!');
                    prospectOk = false;
                }

                if ($("#prospectSaveExport").is(":checked")) {

                    if (!$("#prospectSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        prospectOk = false;
                    }
                }

                if (prospectOk) {
                    //$("#prospects-form").submit();
                    <!--                        $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#prospects-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#prospects-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }

                break;

            case 'leads':

                var leadsOk = true;

                if ($("#leads-fields").find('input:checked').length == 0) {
                    alert('You have to select at least one field!');
                    leadsOk = false;
                }

                if ($("#leadSaveExport").is(":checked")) {

                    if (!$("#leadSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        leadsOk = false;
                    }
                }

                if (leadsOk) {
                    //$("#leads-form").submit();
                    <!--                        $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#leads-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#leads-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }
                break;

            case 'clients':

                var clientsOk = true;

                if ($("#clients-fields").find('input:checked').length == 0) {
                    alert('You have to select at least one field!');
                    clientsOk = false;
                }

                if ($("#clientSaveExport").is(":checked")) {

                    if (!$("#clientSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        clientsOk = false;
                    }
                }

                if (clientsOk) {
                    //$("#clients-form").submit();
                    <!--                        $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#clients-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#clients-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }
                break;
            case 'proposals':

                var proposalsOk = true;

                if ($("#proposals-fields").find('input:checked').length == 0) {
                    alert('You have to select at least one field!');
                    proposalsOk = false;
                }

                if ($("#statusApply").is(':checked')) {
                    var statusFrom = $("#statusFrom").val();
                    var statusTo = $("#statusTo").val();

                    if (!statusFrom || !statusTo) {
                        alert("Please select a 'From' and 'To' Date for the Status Change Date filter");
                        proposalsOk = false;
                        return false;
                    }
                }

                // Make sure we have an export name if save export is selected
                if ($("#proposalSaveExport").is(":checked")) {

                    if (!$("#proposalSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        proposalsOk = false;
                        return false;
                    }
                }

                if (proposalsOk) {
                    //$("#proposals-form").submit();
                    <!--                        $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#proposals-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#proposals-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }

                break;
            case 'history':

                var historyOk = true;

                // Make sure we have an export name if save export is selected
                if ($("#historySaveExport").is(":checked")) {

                    if (!$("#historySaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        historyOk = false;
                    }
                }

                if (historyOk) {
                    //$("#history-form").submit();
                    <!--                    $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#history-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#history-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }

                break;
            case 'services':

                var servicesOk = true;

                // Make sure we have an export name if save export is selected
                if ($("#serviceSaveExport").is(":checked")) {

                    if (!$("#serviceSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        servicesOk = false;
                    }
                }

                if (servicesOk) {
                    //$("#services-form").submit();
                    <!--                    $.post('-->
                    <?php //echo site_url('ajax/exportCSVData') ?><!--', $('#services-form').serialize());-->
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#services-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }

                break;
            // start case for account 
                case 'accounts':

                var accountsOk = true;

                if ($("#accounts-fields").find('input:checked').length == 0) {
                    alert('You have to select at least one field!');
                    accountsOk = false;
                }

                if ($("#accountSaveExport").is(":checked")) {

                    if (!$("#accountSaveExportName").val()) {
                        $("#save-name-required").dialog('open');
                        accountsOk = false;
                    }
                }

                if (accountsOk) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/exportCSVData') ?>',
                        data: $('#accounts-form').serialize(),
                        async: true
                    });
                }
                else {
                    return false;
                }
                break;

            // colse case for account

        }
        swal(
            'Export Requested',
            'Your report is cooking! It might take a while until it is done, but you will be notified via email!',
            'info'
        );
        //window.location.reload(true);
        //$("#confirm-export").dialog('open');
        return false;
    });
    $("#alldates").click(function () {
        <?php
        $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
        $startDate = date('m/d/Y', $companyStart);
        $endDate = date('m/d/Y');
        ?>
        $("#from").val('<?php echo $startDate ?>');
        $("#to").val('<?php echo $endDate ?>');
        return false;
    });
    $("#alldates2").click(function () {
        $("#from2").val('<?php echo $startDate ?>');
        $("#to2").val('<?php echo $endDate ?>');
        return false;
    });
    $("#statusAllDates").click(function () {
        $("#statusFrom").val('<?php echo $startDate ?>');
        $("#statusTo").val('<?php echo $endDate ?>');
        $("#statusApply").attr('checked', true);
        $.uniform.update();
        return false;
    });
    $("#statusFrom, #statusTo").click(function () {
        $("#statusApply").attr('checked', true);
        $.uniform.update();
    });
    $("#statusHelp").tipTip({activation: 'click', defaultPosition: 'right'});
    $("#saveExportHelp").tipTip({activation: 'click', defaultPosition: 'right'});

    var dates = $("#from, #to, #statusFrom, #statusTo").datepicker({
        changeYear: true,
        changeMonth: true,
        defaultDate: "+1w",
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var option = this.id == "from" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });
    var dates = $("#from2, #to2").datepicker({
        changeYear: true,
        changeMonth: true,
        defaultDate: "+1w",
        numberOfMonths: 1,
        onSelect: function (selectedDate) {
            var option = this.id == "from2" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

    // Saved Exports data table
    $("#tblSavedExports").dataTable();

    $("a.exportDelete").live('click', function () {
        $("#confirm-delete-message").dialog('open');
        $("#confirm-delete-message").data('export-id', $(this).data('export-id'));
    });

    // Confirm deletion of saved export
    $("#confirm-delete-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                //$.get('<?php echo site_url('account/delete_proposal') ?>/' + $("#client-delete").attr('rel'));
                //$("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').fadeOut('slow');
                window.location.href = '<?php echo site_url('export/delete_export') ?>/' + $(this).data('export-id');
                $(this).dialog("close");
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // RUn export dialog
    $("#confirm-run-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Run an export
    $(".runExport").click(function () {
        var exportId = $(this).data('export-id');

        $.get('<?php echo site_url('ajax/exportCSVData') ?>/' + exportId);
        $("#confirm-run-message").dialog('open');
        return false;
    });

    // Export details dialog
    $('#saved-export-details').dialog({
        width: 600,
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    // Open the details dialog
    $(".export-details").click(function () {
        // Get the xport ID
        var exportId = $(this).data('export-id');

        // Clear the data
        $("#saved-export-details-title").html('');
        $("#saved-export-details-user").html('');
        $("#saved-export-details-criteria").html('');
        // Hide buttons
        $("#saved-export-details-run").hide();
        $("#saved-export-details-edit").hide();

        $.ajax({
            type: "GET",
            url: "<?php echo site_url('ajax/savedExportDetails') ?>/" + exportId,
            async: false,
            dataType: 'json',
            success: function (data) {

                if (data.error) {
                    //display error message
                    $("#saved-export-details-criteria").html('There was an error retrieving the details of this export');
                }
                else {
                    $("#saved-export-details-title").html(data.exportName);
                    $("#saved-export-details-user").html(data.user);
                    $("#saved-export-details-criteria").html(data.criteria);

                    // Pass the id to the buttons
                    $("#saved-export-details-run").data('export-id', exportId);
                    $("#saved-export-details-edit").data('export-id', exportId);
                    // Show the button
                    $("#saved-export-details-run").show();
                    $("#saved-export-details-edit").show();
                }
            }
        });

        $('#saved-export-details').dialog('open');
    });

    // Run export from details overlay
    $("#saved-export-details-run").click(function () {
        var exportId = $(this).data('export-id');

        $.get('<?php echo site_url('ajax/exportCSVData') ?>/' + exportId);

        // Hide the detail overlay
        $('#saved-export-details').dialog('close');
        // Open the confirmation dialog
        $("#confirm-run-message").dialog('open');
    });

    // Edit export from details overlay
    $("#saved-export-details-edit").click(function () {
        var exportId = $(this).data('export-id');
        // Redirect to edit page
        window.location.href = '<?php echo site_url('export/edit_export') ?>/' + exportId;
    });

    // Confirm export dialog
    $("#save-name-required").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $("#confirm-export").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });
});
</script>

 <script>
$(document).ready(function() {
    // Function to show the specified tab based on the URL fragment identifier
    function showTabFromURL() {
        var tabId = window.location.hash; // Get the fragment identifier from the URL
        if (tabId) {
            $("#export-forms > div").hide(); // Hide all tab content
            $(tabId).show(); // Show the tab corresponding to the fragment identifier
            // Update tab activation styles
            $("#export-areas a, #export-areas li").removeClass('active');
            $('a[href="' + tabId + '"]').addClass('active');
            $('a[href="' + tabId + '"]').parent().addClass('active');
        }
    }

    // Initially show the tab based on the URL fragment identifier
    showTabFromURL(); 
    // Window hash change event handler
    $(window).on('hashchange', function() {
        showTabFromURL();
    });
});

</script>

<?php $this->load->view('global/footer'); ?>
