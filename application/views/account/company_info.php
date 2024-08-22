<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Company Info</h1>
        <h2>&nbsp;</h2>

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="settings">
            <tr>
                <td colspan="2" style="width: 100%;">
                    <form action="#" method="post" class="validate small" id="companyform">
                        <p class="clearfix">
                            <label>Company Name:</label>
                            <input type="text" name="companyName" id="companyName" class="text required" value="<?php echo $companyInfo->companyName ?>">
                        </p>
                        <p class="clearfix">
                            <label>Company Address:</label>
                            <input type="text" name="companyAddress" id="companyAddress" class="text required" value="<?php echo $companyInfo->companyAddress ?>">
                        </p>
                        <p class="clearfix">
                            <label>Company Phone:</label>
                            <input type="text" name="companyPhone" id="companyPhone" class="text required" value="<?php echo $companyInfo->companyPhone ?>">
                        </p>
                        <p class="clearfix">
                            <input type="submit" value="Update" name="updateCompany" class="btn" style="margin-left: 10px;">
                        </p>
                    </form>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="float left clearfix">
                        <h2>Current Logo</h2>
                        <h2>&nbsp;</h2>
                        <img style="width: 200px; height: auto;" src="<?php
            $path = UPLOADPATH . '/clients/logos/';
                        if (!file_exists($path . $clientLogo) || !is_file($path . $clientLogo)) {
                            echo site_url('uploads/clients/logos/none.jpg');
                        } else {
                            echo site_url('uploads/clients/logos/' . $clientLogo);
                        }
                        ?>" alt="">
                    </div>
                    <div class="float right clearfix">
                        <h2>Update Logo</h2>
                        <h2>&nbsp;</h2>

                        <form action="#" method="post" class="validate2 small" enctype="multipart/form-data">
                            <p class="clearfix">
                                <label>New Logo:</label>
                                <input type="file" name="clientLogo" id="clientLogo" class="required">
                            </p>
                            <p class="clearfix">
                                <label>&nbsp;</label>
                                <input type="submit" value="Save" name="changeLogo" class="btn">
                            </p>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<!--#content-->