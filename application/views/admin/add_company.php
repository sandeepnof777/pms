<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <form class="form-validated" action="<?php echo site_url('admin/add_company') ?>" method="post">
            <div class="content-box">
                <div class="box-header">
                    Add New Company
                    <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
                        <thead>
                        <tr>
                            <td>Company Info</td>
                            <td>Admin Account Information</td>
                        </tr>
                        </thead>
                        <tr>
                            <td width="50%">
                                <p class="clearfix">
                                    <label>Company Name <span>*</span></label>
                                    <input tabindex="1" type="text" name="companyName" id="companyName" class="text required tiptip" title="Enter company's name" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix">
                                    <label>Email <span>*</span></label>
                                    <input tabindex="21" type="text" name="accountEmail" id="accountEmail" class="text required email tiptip" title="Enter user's email" value="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company Address</label>
                                    <input tabindex="2" type="text" name="companyAddress" id="companyAddress" class="text  tiptip" title="Enter company's street address" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix">
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="22" type="text" name="firstName" id="firstName" class="text required tiptip" title="Enter user's first name" value="">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>Company City</label>
                                    <input tabindex="3" type="text" name="companyCity" id="companyCity" class="text  tiptip" title="Enter company's city" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix">
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="23" type="text" name="lastName" id="lastName" class="text required tiptip" title="Enter user's last name" value="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company State</label>
                                    <input tabindex="4" type="text" name="companyState" id="companyState" class="text  tiptip" title="Enter company's state" value="">
                                </p>
                            </td>
                            <td>
                                <label>Expiration Date</label>
                                <input tabindex="24" class="text tiptip" title="Set Company Expiration Date" name="expires" id="expires" type="text" style="width: 75px; text-align: center;" value="<?php echo date('n/j') . '/' . (date('Y') + 1) ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>Company Zip</label>
                                    <input tabindex="5" type="text" name="companyZip" id="companyZip" class="text  tiptip" title="Enter company's zip code" value="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company Website</label>
                                    <input tabindex="7" type="text" name="companyWebsite" id="companyWebsite" class="text  tiptip" title="Enter company's website" value="">
                                </p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="">
                            <td>
                                <p class="clearfix">
                                    <label>Company Phone</label>
                                    <input tabindex="8" type="text" name="companyPhone" id="companyPhone" class="text  tiptip" title="Enter company's phone number" value="">
                                </p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Fax</label>
                                    <input tabindex="9" type="text" name="alternatePhone" id="alternatePhone" class="text  tiptip" title="Enter company's alternate phone" value="">
                                </p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="">
                            <td>
                                <p class="clearfix">
                                    <label>Company Status</label>
                                    <select name="companyStatus" id="companyStatus">
                                        <option>Active</option>
                                        <option>Test</option>
                                        <option>Inactive</option>
                                    </select>
                                </p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="even">
                            <td colspan="2">
                                <p class="clearfix">
                                    <label style="width: 100%;"><span>* = Required Field</span></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="clearfix">
                                    <input tabindex="29" type="submit" value="Add" name="addNewCompany" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#companyPhone").mask("999-999-9999");
        $("#alternatePhone").mask("999-999-9999");
        $("#expires").datepicker({
            dateFormat:'m/d/yy'
        });
    });
</script>
<?php $this->load->view('global/footer'); ?>
