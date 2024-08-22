<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Add New User
                <a class="box-action" href="<?php echo site_url('account/company_users') ?>">Back</a>
            </div>
            <div class="box-content">
                <?php echo form_open('account/add_account', array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
                <table cellpadding="0" cellspacing="0" border="0" class="boxed-table" width="100%">
                    <tr>
                        <td width="50%">
                            <p class="clearfix">
                                <label>First Name <span>*</span></label>
                                <input tabindex="1" class="tiptip text required" type="text" title="Enter the user's First Name" name="firstName" id="firstName" value="<?php echo $this->input->post('firstName') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Fax</label>
                                <input tabindex="9" class="tiptip text" type="text" title="Enter the user's Fax #" name="fax" id="fax" value="<?php echo $account->getCompany()->getAlternatePhone() ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>Last Name <span>*</span></label>
                                <input tabindex="2" class="tiptip text required" type="text" title="Enter the user's Last Name" name="lastName" id="lastName" value="<?php echo $this->input->post('lastName') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Address <span>*</span></label>
                                <input tabindex="9" class="tiptip text required" type="text" title="Enter the user's Address" name="address" id="address" value="<?php echo $account->getCompany()->getCompanyAddress() ?>">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix">
                                <label>Title <span>*</span></label>
                                <input tabindex="3" class="tiptip text required" type="text" title="Enter the user's Title" name="title" id="title" value="<?php echo $this->input->post('title') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>City <span>*</span></label>
                                <input tabindex="10" class="tiptip text required" type="text" title="Enter the user's City" name="city" id="city" value="<?php echo $account->getCompany()->getCompanyCity() ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>Email <span>*</span></label>
                                <input tabindex="4" class="tiptip text required email" type="text" title="Enter a valid email address" name="email" id="email" value="<?php echo $this->input->post('email') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>State <span>*</span></label>
                                <input tabindex="11" class="tiptip text required" type="text" title="Enter the user's State" name="state" id="state" value="<?php echo $account->getCompany()->getCompanyState() ?>">
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix">
                                <label>Password <span>*</span></label>
                                <input tabindex="5" class="tiptip text required" title="Enter the user's Password" type="password" name="password" id="password">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Zip Code <span>*</span></label>
                                <input tabindex="12" class="tiptip text required" title="Enter the user's Zip Code" type="text" name="zip" id="zip" value="<?php echo $account->getCompany()->getCompanyZip() ?>">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>Retype Password <span>*</span></label>
                                <input tabindex="6" class="tiptip text required" title="Retype the user's Password" type="password" name="password2" id="password2">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Time Zone <span>*</span></label>
                                <!--                                <input class="tiptip text required" type="text" title="Enter the user's Time Zone" name="timeZone" id="timeZone" value="--><?php //echo $this->input->post('timeZone') ?><!--">-->
                                <?php echo form_dropdown('timeZone', array(
                                'EST' => 'Eastern Time',
                                'CST' => 'Central Time',
                                'MST' => 'Mountain Time',
                                'PST' => 'Pacific Time',
                            ), $this->input->post('timeZone'), ' tabindex="14"') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix">
                                <label>Cell Phone <span>*</span></label>
                                <input tabindex="7" class="tiptip text required" type="text" title="Enter the user's Cell Phone" name="cellPhone" id="cellPhone" value="<?php echo $this->input->post('cellPhone') ?>">
                            </p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Full Access</label>
                                <?php $options = array('no' => 'No', 'yes' => 'Yes');
                                echo form_dropdown('fullAccess', $options, $this->input->post('fullAccess'), ' tabindex="15"');
                                ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>Office Phone <span>*</span></label>
                                <input tabindex="8" class="tiptip text required" title="Enter the user's Office Phone" type="text" name="officePhone" id="officePhone" value="<?php echo $account->getCompany()->getCompanyPhone() ?>">
                            </p>
                        </td>
                        <td>
                            <?php
                            if ($logged_account->isGlobalAdministrator()) {
                                ?>
                                <label>Expiration Date</label>
                                <input tabindex="28" type="text" name="expires" id="expires" style="width: 75px; text-align: center;" value="<?php echo date('n/j') ?>/<?php echo (date('Y', time()) + 1) ?>" class="text">
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>&nbsp;</label><input tabindex="100" type="submit" value="Create" class="btn">
                            </p></td>
                        <td></td>
                    </tr>
                </table>
                <?php echo form_close() ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $("#cellPhone").mask("999-999-9999");
                        $("#officePhone").mask("999-999-9999");
                        $("#fax").mask("999-999-9999");
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!--#content-->
<?php $this->load->view('global/footer'); ?>