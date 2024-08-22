<?php
    /* @var \models\ProposalSignee $clientSignee */
    /* @var \models\ProposalSignee $companySignee */
?>
<div class="clearfix" id="customSignatureIntro">
    <p>You can customize the names of the signatories of the proposal below.</p>
    <p>Check the boxes to override the default signatures with the information that you provide.</p>
</div>

<div class="clearfix">

    <div id="customClientSignature" class="customSignatureContainer">

        <h3><input type="checkbox" id="useClientSig" <?php echo $clientSignee->getId() ? 'checked="checked"' : ''; ?>/> Client Signature</h3>

        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="even">
                    <td>
                        <label>First Name: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigFirstName" value="<?php echo $clientSignee->getFirstName(); ?>">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Last Name: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigLastName" value="<?php echo $clientSignee->getLastName(); ?>">
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <label>Company: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigCompanyName" value="<?php echo $clientSignee->getCompanyName(); ?>">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Title: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigTitle" value="<?php echo $clientSignee->getTitle(); ?>">
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <label>Address: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigAddress" value="<?php echo $clientSignee->getAddress(); ?>">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>City: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigCity" value="<?php echo $clientSignee->getCity(); ?>">
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <label>State: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigState" value="<?php echo $clientSignee->getState(); ?>">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Zip: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigZip" value="<?php echo $clientSignee->getZip(); ?>">
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <label>Office Phone: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigOfficePhone" value="<?php echo $clientSignee->getOfficePhone(); ?>">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Cell Phone: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigCellPhone" value="<?php echo $clientSignee->getCellPhone(); ?>">
                    </td>
                </tr>
                <tr class="odd">
                    <td>
                        <label>Email: </label>
                    </td>
                    <td>
                        <input type="text" id="clientSigEmail" value="<?php echo $clientSignee->getEmail(); ?>">
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    <div id="customCompanySignature" class="customSignatureContainer clearfix">

        <h3><input type="checkbox" id="useCompanySig" <?php echo $companySignee->getId() ? 'checked="checked"' : ''; ?> />Company Signature</h3>

        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
            <tbody>
            <tr class="even">
                <td>
                    <label>First Name: </label>
                </td>
                <td>
                    <input type="text" id="companySigFirstName" value="<?php echo $companySignee->getFirstName(); ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Last Name: </label>
                </td>
                <td>
                    <input type="text" id="companySigLastName" value="<?php echo $companySignee->getLastName(); ?>">
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Company: </label>
                </td>
                <td>
                    <input type="text" id="companySigCompanyName" value="<?php echo $companySignee->getCompanyName(); ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Title: </label>
                </td>
                <td>
                    <input type="text" id="companySigTitle" value="<?php echo $companySignee->getTitle(); ?>">
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Address: </label>
                </td>
                <td>
                    <input type="text" id="companySigAddress" value="<?php echo $companySignee->getAddress(); ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>City: </label>
                </td>
                <td>
                    <input type="text" id="companySigCity" value="<?php echo $companySignee->getCity(); ?>">
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>State: </label>
                </td>
                <td>
                    <input type="text" id="companySigState" value="<?php echo $companySignee->getState(); ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Zip: </label>
                </td>
                <td>
                    <input type="text" id="companySigZip" value="<?php echo $companySignee->getZip(); ?>">
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Office Phone: </label>
                </td>
                <td>
                    <input type="text" id="companySigOfficePhone" value="<?php echo $companySignee->getOfficePhone(); ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Cell Phone: </label>
                </td>
                <td>
                    <input type="text" id="companySigCellPhone" value="<?php echo $companySignee->getCellPhone(); ?>">
                </td>
            </tr>
            <tr class="odd">
                <td>
                    <label>Email: </label>
                </td>
                <td>
                    <input type="text" id="companySigEmail" value="<?php echo $companySignee->getEmail(); ?>">
                </td>
            </tr>

            </tbody>
        </table>

    </div>

    <a class="btn ui-btn update-button clearfix" id="saveSigSettings">
        <i class="fa fa-fw fa-floppy-o"></i>Save Signature Settings
    </a>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $(".customSignatureContainer input").uniform();

        $("#saveSigSettings").click(function() {

            $(".customSignatureContainer .boxed-table input.text").removeClass('error');

            // Check if overriding client setting
            var clientSig = $("#useClientSig").is(":checked");

            if (clientSig) {

                // Error flag
                var clientError = false;

                // Input values
                var clientSigFirstName = $("#clientSigFirstName").val();
                var clientSigLastName = $("#clientSigLastName").val();
                var clientSigCompanyName = $("#clientSigCompanyName").val();
                var clientSigTitle = $("#clientSigTitle").val();
                var clientSigAddress = $("#clientSigAddress").val();
                var clientSigCity = $("#clientSigCity").val();
                var clientSigState = $("#clientSigState").val();
                var clientSigZip = $("#clientSigZip").val();
                var clientSigOfficePhone = $("#clientSigOfficePhone").val();
                var clientSigCellPhone = $("#clientSigCellPhone").val();
                var clientSigEmail = $("#clientSigEmail").val();

                // Validate
                if (! clientSigFirstName) {
                    $("#clientSigFirstName").addClass('error');
                    clientError = true;
                }

                if (! clientSigLastName) {
                    $("#clientSigLastName").addClass('error');
                    clientError = true;
                }

                if (! clientSigTitle) {
                    $("#clientSigTitle").addClass('error');
                    clientError = true;
                }

                if (! clientSigCompanyName) {
                    $("#clientSigCompanyName").addClass('error');
                    clientError = true;
                }

                if (! clientSigAddress) {
                    $("#clientSigAddress").addClass('error');
                    clientError = true;
                }

                if (! clientSigCity) {
                    $("#clientSigCity").addClass('error');
                    clientError = true;
                }

                if (! clientSigState) {
                    $("#clientSigState").addClass('error');
                    clientError = true;
                }

                if (! clientSigState) {
                    $("#clientSigZip").addClass('error');
                    clientError = true;
                }
            }

            // Check if overriding client setting
            var companySig = $("#useCompanySig").is(":checked");

            if (companySig) {

                // Error flag
                var companyError = false;

                // Input values
                var companySigFirstName = $("#companySigFirstName").val();
                var companySigLastName = $("#companySigLastName").val();
                var companySigCompanyName = $("#companySigCompanyName").val();
                var companySigTitle = $("#companySigTitle").val();
                var companySigAddress = $("#companySigAddress").val();
                var companySigCity = $("#companySigCity").val();
                var companySigState = $("#companySigState").val();
                var companySigZip = $("#companySigZip").val();
                var companySigOfficePhone = $("#companySigOfficePhone").val();
                var companySigCellPhone = $("#companySigCellPhone").val();
                var companySigEmail = $("#companySigEmail").val();

                // Validate
                if (! companySigFirstName) {
                    $("#companySigFirstName").addClass('error');
                    clientError = true;
                }

                if (! companySigLastName) {
                    $("#companySigLastName").addClass('error');
                    clientError = true;
                }

                if (!companySigTitle) {
                    $("#companySigTitle").addClass('error');
                    companyError = true;
                }

                if (!companySigCompanyName) {
                    $("#companySigCompanyName").addClass('error');
                    companyError = true;
                }

                if (!companySigAddress) {
                    $("#companySigAddress").addClass('error');
                    companyError = true;
                }

                if (!companySigCity) {
                    $("#companySigCity").addClass('error');
                    companyError = true;
                }

                if (!companySigState) {
                    $("#companySigState").addClass('error');
                    companyError = true;
                }

                if (!companySigZip) { new
                    $("#companySigZip").addClass('error');
                    companyError = true;
                }
            }

            if (companyError || clientError) {
                swal('Error', 'Please complete all of the highlighted fields');
                return false;
            }

            var postData = {
                proposalId: <?php echo $proposal->getProposalId(); ?>,
                clientSig: clientSig ? 1 : 0,
                clientSigFirstName :  clientSigFirstName,
                clientSigLastName :  clientSigLastName,
                clientSigCompanyName : clientSigCompanyName,
                clientSigTitle : clientSigTitle,
                clientSigAddress : clientSigAddress,
                clientSigCity : clientSigCity,
                clientSigState : clientSigState,
                clientSigZip : clientSigZip,
                clientSigOfficePhone : clientSigOfficePhone,
                clientSigCellPhone : clientSigCellPhone,
                clientSigEmail : clientSigEmail,
                companySig: companySig ? 1: 0,
                companySigFirstName :  companySigFirstName,
                companySigLastName :  companySigLastName,
                companySigCompanyName : companySigCompanyName,
                companySigTitle : companySigTitle,
                companySigAddress : companySigAddress,
                companySigCity : companySigCity,
                companySigState : companySigState,
                companySigZip : companySigZip,
                companySigOfficePhone : companySigOfficePhone,
                companySigCellPhone : companySigCellPhone,
                companySigEmail : companySigEmail,
            }

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalSignees') ?>",
                data: postData,
                dataType: 'json'
            })
            .done(function (data) {

                if (data.error) {
                    swal(
                        'Error',
                        'There was an error saving the details'
                    );
                } else {
                    swal(
                        'Success',
                        'Signee Details Saved'
                    );
                }
            })
            .fail(function (xhr) {
                swal(
                    'Error',
                    'There was an error saving the details'
                );
            });

        });

    });

</script>