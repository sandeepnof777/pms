<h3>
    Editing Company Information
    <a href="<?php echo site_url('account/my_account') ?>">Back</a>
</h3>
<form action="<?php echo site_url('account/edit_company_info') ?>" method="post" class="form-validated">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
        <tr>
            <td width="50%">
                <p class="clearfix">
                    <label>Company Name <span>*</span></label>
                    <input tabindex="1" type="text" name="companyName" id="companyName" class="trackChanges text required tiptip" title="Enter your company's name" value="<?php echo $company->getCompanyName() ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>Company Zip <span>*</span></label>
                    <input tabindex="5" type="text" name="companyZip" id="companyZip" class="text required tiptip" title="Enter your company's zip code" value="<?php echo $company->getCompanyZip() ?>">
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix">
                    <label>Company Address <span>*</span></label>
                    <input tabindex="2" type="text" name="companyAddress" id="companyAddress" class="trackChanges text required tiptip" title="Enter your company's street address" value="<?php echo $company->getCompanyAddress() ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>Company Website <span>*</span></label>
                    <input tabindex="7" type="text" name="companyWebsite" id="companyWebsite" class="trackChanges text required tiptip" title="Enter your company's website" value="<?php echo $company->getCompanyWebsite() ?>">
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="clearfix">
                    <label>Company City <span>*</span></label>
                    <input tabindex="3" type="text" name="companyCity" id="companyCity" class="trackChanges text required tiptip" title="Enter your company's city" value="<?php echo $company->getCompanyCity() ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>Company Phone <span>*</span></label>
                    <input tabindex="8" type="text" name="companyPhone" id="companyPhone" class="trackChanges text required tiptip phoneFormat" title="Enter your company's phone number" value="<?php echo $company->getCompanyPhone() ?>">
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix">
                    <label>Company State <span>*</span></label>
                    <input tabindex="4" type="text" name="companyState" id="companyState" class="trackChanges text required tiptip" title="Enter your company's state" value="<?php echo $company->getCompanyState() ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>Fax</label>
                    <input tabindex="9" type="text" name="alternatePhone" id="alternatePhone" class="trackChanges text tiptip phoneFormat" title="Enter your company's cell phone" value="<?php echo $company->getAlternatePhone() ?>">
                </p>
            </td>
        </tr>
        <tr class="">
            <td>
                <p class="clearfix">
                    <label>&nbsp;</label>
                    <input type="submit" value="Save" name="updateCompany" class="btn blue" tabindex="200" style="margin-right: 5px;">
                </p>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>