<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
<div class="widthfix">

<div class="content-box">
<div class="box-header">
    <?php if ($this->uri->segment(3)) {
        echo 'Uploading ' . ucwords($this->uri->segment(3));
    } else {
        echo 'Upload Data';
    } ?>
    <a class="box-action" href="<?php echo site_url('account') ?>">Back</a>
</div>
<div class="box-content">
<div class="padded clearfix">
<h3 class="centered">
    <?php if ($this->uri->segment(3)) {
        echo 'Uploading ' . ucwords($this->uri->segment(3));
    } else {
        echo 'Upload Data';
    } ?>
</h3>
<?php if (!$this->uri->segment(3)) {
    ?>
    <h4 class="centered" style="margin-bottom: 10px;">Ready to upload your data? Choose what you want to upload and let's begin!</h4>

    <p class="centered clearfix" style="width:330px; margin: 0 auto;">
       <!-- <a class="bigButton left menu-leads" href="<?php /*echo site_url('account/upload_data/leads') */?>" style="margin-right: 10px;">
            <span class="icon"></span>
            <span class="label">Leads</span>
            <span class="text">Upload Leads</span>

        </a>-->
        <a class="bigButton left menu-prospects" href="<?php echo site_url('account/upload_data/prospects') ?>" style="margin-right: 10px;">
            <span class="icon"></span>
            <span class="label">Prospects</span>
            <span class="text">Upload Prospects</span>
        </a>
        <a class="bigButton left menu-clients" href="<?php echo site_url('account/upload_data/clients') ?>" style="margin-right: 10px;">
            <span class="icon"></span>
            <span class="label">Contacts</span>
            <span class="text">Upload Contacts</span>
        </a>
        <a class="bigButton left menu-leads" href="<?php echo site_url('account/upload_data/leads') ?>" style="margin-right: 10px;">
            <span class="icon"></span>
            <span class="label">Leads</span>
            <span class="text">Upload Leads</span>
        </a>
    </p>
    <p class="centered padded" style="margin-top: 10px;">
        After clicking one of the buttons above you will start the upload data process. We will guide you step by step!
    </p>
    <p class="centered padded">
        At the moment we only accept .csv format. If you have excel xls, or other formats, please export as .csv before uploading it here!
    </p>
<?php
} else { ?>
<?php if ($step == 1) { ?>
    <h4>Step 1 - Upload File - Must be .CSV format!</h4>
    <p>To upload your information you are able to upload 4000 accounts at a time. The file structure needs to be .csv to upload.</p>
    <p>The first line of the CSV must contain the headings of the fields, i.e. First Name, Last Name, etc so you can choose which data to upload.</p>
    <form action="#" class="big" enctype="multipart/form-data" method="post" id="fileUploadForm">
        <p class="clearfix">
            <label>CSV File</label><input type="file" name="csv" id="csv" accept=".csv" style="margin-top: 4px;">
        </p>
        <input type="hidden" name="fileUpload" value="1">
 
        <p class="clearfix">
            <label>&nbsp;</label>
            <input class="btn blue-button" type="submit" value="Upload">
            &nbsp; &nbsp;
            <a class="btn blue-button" href="<?php echo site_url('account/upload_data') ?>" style="padding: 2px 13px;">Back</a>
        </p>
    </form>
<?php
}
if ($step == 2) {
    $fieldOptions = '';
    foreach ($fieldsHeadings as $k => $v) {
        $fieldOptions .= "<option value=\"{$v}\">{$v}</option>";
    }
    ?>
    <div id="columns" class="">
    <form class="big" action="#" method="post" id="uploadClientsForm">
    <input type="hidden" name="csvFile" value="<?php echo @$fileName; ?>">
    <h4>Step 2 - Choose columns</h4>
    <?php
    switch ($this->uri->segment(3)) {
        case 'clients':
            $maps = array(
                array(
                    'label' => 'First Name',
                    'name' => 'mappings[firstName]',
                    'id' => 'firstName',
                ),
                array(
                    'label' => 'Last Name',
                    'id' => 'lastName',
                ),
                array(
                    'label' => 'Title',
                    'id' => 'title',
                ),
                array(
                    'label' => 'Company',
                    'id' => 'company',
                ),
                array(
                    'label' => 'Email',
                    'id' => 'email',
                ),
                array(
                    'label' => 'Website',
                    'id' => 'website',
                ),
                array(
                    'label' => 'Business Phone',
                    'id' => 'businessPhone',
                ),
                array(
                    'label' => 'Cell Phone',
                    'id' => 'cellPhone',
                ),
                array(
                    'label' => 'Fax',
                    'id' => 'fax',
                ),
                array(
                    'label' => 'Address',
                    'id' => 'address',
                ),
                array(
                    'label' => 'City',
                    'id' => 'city',
                ),
                array(
                    'label' => 'State',
                    'id' => 'state',
                ),
                array(
                    'label' => 'Zip',
                    'id' => 'zip',
                ),
            );
            break;
        case 'leads':
            $maps = array(
                array(
                    'label' => 'First Name',
                    'name' => 'mappings[firstName]',
                    'id' => 'firstName',
                ),
                array(
                    'label' => 'Last Name',
                    'id' => 'lastName',
                ),
                array(
                    'label' => 'Title',
                    'id' => 'title',
                ),
                array(
                    'label' => 'Company',
                    'id' => 'company',
                ),
                array(
                    'label' => 'Email',
                    'id' => 'email',
                ),
                array(
                    'label' => 'Website',
                    'id' => 'website',
                ),
                array(
                    'label' => 'Business Phone',
                    'id' => 'businessPhone',
                ),
                array(
                    'label' => 'Cell Phone',
                    'id' => 'cellPhone',
                ),
                array(
                    'label' => 'Fax',
                    'id' => 'fax',
                ),
                array(
                    'label' => 'Address',
                    'id' => 'address',
                ),
                array(
                    'label' => 'City',
                    'id' => 'city',
                ),
                array(
                    'label' => 'State',
                    'id' => 'state',
                ),
                array(
                    'label' => 'Zip',
                    'id' => 'zip',
                ),
                array(
                    'label' => 'Project Name',
                    'id' => 'projectName',
                ),
                array(
                    'label' => 'Business Type',
                    'id' => 'businessType',
                ),
                array(
                    'label' => 'Status',
                    'id' => 'status',
                ),
                array(
                    'label' => 'Rating',
                    'id' => 'rating',
                ),
                array(
                    'label' => 'Source',
                    'id' => 'source',
                ),
                
                array(
                    'label' => 'Project Address',
                    'id' => 'projectAddress',
                ),
                array(
                    'label' => 'Project City',
                    'id' => 'projectCity',
                ),
                array(
                    'label' => 'Project State',
                    'id' => 'projectState',
                ),
                array(
                    'label' => 'Project Zip',
                    'id' => 'projectZip',
                ),
            );
            break;
        case 'prospects':
            $maps = array(
                array(
                    'label' => 'First Name',
                    'name' => 'mappings[firstName]',
                    'id' => 'firstName',
                ),
                array(
                    'label' => 'Last Name',
                    'id' => 'lastName',
                ),
                array(
                    'label' => 'Title',
                    'id' => 'title',
                ),
                array(
                    'label' => 'Company',
                    'id' => 'company',
                ),
                array(
                    'label' => 'Email',
                    'id' => 'email',
                ),
                array(
                    'label' => 'Website',
                    'id' => 'website',
                ),
                array(
                    'label' => 'Business Phone',
                    'id' => 'businessPhone',
                ),
                array(
                    'label' => 'Cell Phone',
                    'id' => 'cellPhone',
                ),
                array(
                    'label' => 'Fax',
                    'id' => 'fax',
                ),
                array(
                    'label' => 'Address',
                    'id' => 'address',
                ),
                array(
                    'label' => 'City',
                    'id' => 'city',
                ),
                array(
                    'label' => 'State',
                    'id' => 'state',
                ),
                array(
                    'label' => 'Zip',
                    'id' => 'zip',
                ),
                array(
                    'label' => 'Business Type',
                    'id' => 'businessType',
                ),
                array(
                    'label' => 'Status',
                    'id' => 'status',
                ),
                array(
                    'label' => 'Rating',
                    'id' => 'rating',
                ),
                
                

            );
            break;
    }
    foreach ($maps as $map) {
        ?>
        <p class="clearfix">
            <label id="label_<?php echo $map['id'] ?>"><?php echo $map['label'] ?></label>
            <select class="mapSelect" name="mappings[<?php echo $map['id'] ?>]" id="<?php echo $map['id'] ?>">
                <option value="0">Not Provided</option>
                <?php
                foreach ($fieldsHeadings as $k => $v) {
                    $selected = '';
                    if (trim($v) == $map['label']) {
                        $selected = ' selected="selected"';
                    }
                    ?>
                    <option value="<?php echo $v ?>"<?php echo $selected; ?>><?php echo $v ?></option><?php
                }
                ?>
            </select>
            <label id="errorLabel_<?php echo $map['id'] ?>">Field Not Filled In!</label>
        </p>
    <?php
    }
    ?>

    <input type="hidden" name="mappings[country]" value="USA">
    <input type="hidden" name="pickOwners" value="1">

    <p class="clearfix">
        <label>&nbsp;</label>
        <input id="finish" class="btn" type="button" value="Continue">
        &nbsp; &nbsp;
        <a class="btn blue-button" href="<?php echo site_url('account/upload_data') ?>" style="padding: 2px 13px;">Back</a>
    </p>
    </form>
    <script type="text/javascript">
        $(document).ready(function () {

            function refreshSelects() {
                var selectOptions = <?php echo json_encode($fieldsHeadings) ?>;
                var availableOptions = selectOptions;
                $(".mapSelect").each(function () {
                    console.log($(this).val());
                    if ($(this).val() == 0) {
                        $("#label_" + $(this).attr('id')).addClass('error');
                        $("#errorLabel_" + $(this).attr('id')).show();
                    } else {
                        $("#label_" + $(this).attr('id')).removeClass('error');
                        $("#errorLabel_" + $(this).attr('id')).hide();
                    }
                    if (availableOptions.indexOf($(this).val()) >= 0) {
                        availableOptions.splice(availableOptions.indexOf($(this).val()), 1);
                    }
                });
                $(".mapSelect").each(function () {
                    var optionString = '<option value="0">Not Provided</option>';
                    if ($(this).val() != 0) {
                        optionString += '<option selected="selected">' + $(this).val() + '</option>';
                    }
                    for (i in availableOptions) {
                        optionString += '<option>' + availableOptions[i] + '</option>';
                    }
                    $(this).html(optionString);
                });
                $.uniform.update();
            }

            refreshSelects();
            $(".mapSelect").change(function () {
                refreshSelects();
            });

            //functionality for the submit button
            $("#uploadNotice").dialog({
                autoOpen: false,
                modal: true,
                width: 500,
                buttons: {
                    Continue: function () {
                        $("#uploadClientsForm").submit();
                        $(this).dialog('close');
                    },
                    Cancel: function () {
                        $(this).dialog('close');
                    }
                }
            });
            $("#finish").click(function () {
                var formOk = true;
                $(".mapSelect").each(function () {
                    if ($(this).val() == 0) {
                        formOk = false;
                    }
                });
                if (!formOk) {
                    $("#uploadNotice").dialog('open');
                } else {
                    $("#uploadClientsForm").submit();
                }
            });
        });
    </script>
    </div>
    <div id="uploadNotice">
        Some of the fields are not provided from the csv! <br>
        <b>Are you sure you want to continue?</b> <br>
        <span style="color: #c00">This can not be undone!</span>
    </div>
    <?php /*var_dump($fieldsHeadings)*/ ?>
<?php } ?>
<?php if ($step == 3) {
$ownerHtml = '<select name="owner[#ID#]" class="rowOwnerSelect">';
$count = 0;
foreach ($accounts as $id => $account) {
    $ownerHtml .= '<option value="' . $id . '">' . $account . '</option>';
}
$ownerHtml .= '</select>';
?>


<h4>Assign owners and save</h4>
    <h4 id="owners">Select owner for all entries:</h4>

    <select class="changeOwner">
        <?php
        foreach ($accounts as $id => $account) {
            echo '<option value="' . $id . '">' . $account . '</option>';
        }
        ?>
    </select>

<p class="clearfix" style="line-height: 20px; margin-top: 10px;"><img src="<?php echo site_url('static') ?>/duplicate-icon.png" style="float: left; margin-right: 5px;"> Duplicate email already exists in the database</p>
</div>
                   <!--         <pre>
<?php //print_r($fieldsValues) ?>
<?php //print_r($mappings) ?>
</pre>-->
<form action="#" method="post">
    <p class="clearfix" style="padding: 5px;">
        <input class="btn blue-button" type="submit" name="addData" value="Upload Selected Accounts">
        &nbsp; &nbsp;
        <a class="btn blue-button" href="<?php echo site_url('account/upload_data') ?>" style="padding: 2px 13px;">Back</a>
    </p>
    <input type="hidden" name="csvFile" value="<?php echo $this->input->post('csvFile') ?>">

    <div style="max-height: 400px; overflow-y: auto;">
    <table class="display striped-table" id="uploadUserSelectTable">
        <thead>
        <tr>
            <th width="50"><input type="checkbox" id="masterUploadCheck" checked="checked" class="dont-uniform" /></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Choose Account Owner</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        foreach ($fieldsValues as $key => $row) {
            if ((((count($row) > 1)) || ((count($row) == 1) && ($row[0])))) {
                $duplicate = (@$row['isPossibleDuplicate']) ? 'gradeX' : '';
                ?>
                <tr class="<?php echo $duplicate; ?>">
                    <td>
                        <?php if ($duplicate) { ?><img class="tiptip" title="Duplicate" src="<?php echo site_url('static') ?>/duplicate-icon.png" alt="Duplicate" style="float: left; /*margin-top: 4px; margin-left: 3px; margin-bottom: 4px;*/"><?php } else { ?>
                        <input type="checkbox" class="uploadCheck" <?php if (!$duplicate) { ?>checked="checked"<?php } ?> name="add[<?php echo $k ?>]" id="enable_<?php echo $k; ?>" style="<?php if ($duplicate) { ?>float: left; margin-top: 7px;<?php } else { ?>margin-top: 5px;<?php } ?>">
                    <?php } ?>
                    </td>
                    <td><?php echo ($mappings['firstName']) ? @$row[$mappings['firstName']] : ''; ?></td>
                    <td><?php echo ($mappings['lastName']) ? @$row[$mappings['lastName']] : ''; ?></td>
                    <td><?php echo ($mappings['company']) ? @$row[$mappings['company']] : ''; ?></td>
                    <td><?php echo ($mappings['email']) ? @$row[$mappings['email']] : ''; ?></td>
                    <td><?php echo str_replace('#ID#', $k, $ownerHtml) ?></td>
                </tr>
            <?php
            }
            $k++;
        }
        ?>
        </tbody>
    </table>
    </div>
    <?php
    foreach ($mappings as $key => $map) {
        ?><input type="hidden" name="mappings[<?php echo $key ?>]" value="<?php echo $map; ?>"><?php
    }
    ?>

    <p class="clearfix" style="padding: 5px;">
        <input class="btn blue-button" type="submit" name="addData" value="Upload Selected Accounts">
        &nbsp;
        <a class="btn blue-button" href="<?php echo site_url('account/upload_data') ?>" style="padding: 2px 13px;">Back</a>
    </p>
</form>
<div class="padded clearfix">
    <?php } ?>
    <?php if ($step == 4) { ?>
        <h3 style="text-align: center; padding-top: 20px; padding-bottom: 20px;">Data upload complete! <?php echo $numberAdded ?> <?php echo $this->uri->segment(3) ?> added succesfully!</h3>
 <?php } ?>
    <?php } ?>
</div>
</div>
</div>
</div>
<?php if ($step == 3) { ?>
    <style type="text/css">
        .dataTables_length select {
            float: none !important;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {

            $(".changeOwner").change(function() {

                var selectedVal = $(this).val();
                console.log(selectedVal);

                $(".rowOwnerSelect").val($(this).val());
                $.uniform.update('select');

                return false;
            });

        });
    </script>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#loading").dialog({
            autoOpen: false,
            modal: true,
            width: 400
        });
        $("#fileUploadForm").submit(function () {
            $("#loading").dialog('open');
        });

        $("#masterUploadCheck").change(function() {
            var checkValue = $(this).is(':checked');
            console.log(checkValue);
            $(".uploadCheck").prop('checked', checkValue);
            $.uniform.update();
        });

        /*
        $("#uploadUserSelectTable").DataTable({
            paging: false,
            searchable: false
        });
         */
    });
</script>
</div>
<div id="loading" title="Please wait">
    <p><img src="<?php echo site_url('static') ?>/loading_animation.gif" alt="Loading"></p>

    <p class="clearfix">Please wait while the file is uploading. When the upload is complete, you will be redirected to Step 2 of the upload process.</p>
</div>
<?php $this->load->view('global/footer'); ?>
