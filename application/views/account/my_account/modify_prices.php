<div style="padding: 10px;">

    <p>You can update the price of proposals with a selected status. Choose the statuses to update, choose your % and click apply.</p>
    <p>THe price of all proposals with the selected status will be updated.</p><br /><br />

    <div class="content-box">
        <div class="box-header">Step 1: Select Proposal Status(es)</div>
        <div class="box-content" style="padding: 20px">


        <p><a href="#" id="allStatuses">All</a> / <a href="#" id="clearStatuses">None</a></p>

        <?php
        foreach ($statuses as $status) {
            if (!$status->isSales()) {
                ?>
                <div class="priceModifyStatus">
                <label>
                <input type="checkbox" class="statusCheck" name="priceModifyStatus[]" value="<?php echo $status->getStatusId() ?>" />
            <p><?php echo $status->getText(); ?></p>
            </label>


            </div>

            <?php
            }
        }
        ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="content-box">
        <div class="box-header">
            Step 2: Select Date Range
        </div>
        <div class="box-content" style="padding: 20px;">
        <div id="created_inputs_tab">
                                <p>
                                    <label>From:</label>
                                    <input type="text" id="pModifyFrom" class="text" style="margin-left: 11px;"
                                        value="">
                                    <label>To:</label>
                                    <input type="text" class="text" id="pModifyTo"
                                        value="">
                                    <a class="filterDateClear" id="resetCreatedDate">Reset</a>
                                </p>
                                <p style="padding-top: 5px;">
                                    <label>Preset:</label>
                                    <select id="createdPreset" style="margin-left: 4px;">
                                        <option value="">Choose Preset</option>
                                        <option value="custom">Custom</option>
                                        <option value="yesterday">Yesterday</option>
                                        <option value="last7days">Last 7 Days</option>
                                        <option value="monthToDate">Month To Date</option>
                                        <option value="previousMonth">Previous Month</option>
                                        <option value="yearToDate">Year To Date</option>
                                        <option value="previousYear">Previous Year</option>
                                    </select>
                                </p>
                            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="content-box">
        <div class="box-header">
            Step 3: Select Price Modifier
        </div>
        <div class="box-content" style="padding: 20px;">
            <div style="width: 30%; float: left;">
                <input type="number" step="0.01" id="priceModifierValue" value="0.00" style="width: 80px; padding: 5px; font-size: 20px" /> %
            </div>
            <div style="width: 70%; float: right; line-height: 1.4;">
                <p>You can choose a positive or negative percentage to adjust proposal prices by.</p>
                <p>To increase prices by 10%, enter 10.</p>
                <p>To decrease prices by 10%, enter -10.</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="content-box">
        <div class="box-header">
            Step 4: Apply Price Modifier
        </div>
        <div class="box-content" style="padding: 20px">

            <p>This will update the prices of all proposals of the selected status(es). Proceed Carefully!</p><br /><br />

            <a class="btn ui-btn update-button" id="applyPriceMod">
                Apply To Selected Proposals
            </a>
        </div>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("#pModifyFrom").datepicker();
        $("#pModifyTo").datepicker();

        $(document).on('click', '#resetCreatedDate', function () {
            $("#pModifyFrom").val("");
            $("#pModifyTo").val("");
            
            //applyFilter();
        });

        // Handle change
    $("#pModifyFrom, #pModifyTo").change(function () {
        $("#createdPreset").val('custom');
        $.uniform.update();
    });

        $("#allStatuses").click(function() {
            $(".statusCheck").prop('checked', true);
            $.uniform.update();
            highlightSelectedStatuses();
            return false;
        });

        $("#clearStatuses").click(function() {
            $(".statusCheck").prop('checked', false);
            $.uniform.update();
            highlightSelectedStatuses();
            return false;
        });

        $(".statusCheck").change(function() {
            highlightSelectedStatuses();
        });

        $("#applyPriceMod").click(function() {

            var statusIds = getSelectedStatusIds();
            var modifier = $("#priceModifierValue").val();
            var pModifyFrom = $("#pModifyFrom").val();
            var pModifyTo = $("#pModifyTo").val();


            // Check we have statuses
            if (!statusIds.length) {
                swal('You did not select any statuses!');
                return;
            }

            // Check we have statuses
            if (pModifyFrom =='' || pModifyTo=='') {
                swal('You did not enter date range!');
                return;
            }

            // Check we have a modifier
            if (modifier == 0) {
                swal("Please choose a price modifier %");
                return;
            }

            // Good to go, send request
            //swal('Updating Prices...');
            swal({
                        title: 'Updating..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 10000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'ids': statusIds,
                    'modifier': modifier,
                    'pModifyFrom':pModifyFrom,
                    'pModifyTo':pModifyTo,

                },
                url: "<?php echo site_url('ajax/modifyPricesStatus') ?>",
                dataType: "JSON"
            })
            .success(function (data) {

                swal.close();

                if (data.success) {
                    //swal(data.updatedCount + ' proposals updated!');
                    swal('',"We are updating your prices. This may take a minute or two. Please be patient and we'll let you know when this is complete");
                } else {
                    swal('An error occurred. Please try again or contact support');
                }
            });

        });

    });

    function highlightSelectedStatuses() {
        $(".statusCheck").each(function() {
           if ($(this).is(":checked")) {
               $(this).parents(".priceModifyStatus").addClass('selected');
           } else {
               $(this).parents(".priceModifyStatus").removeClass('selected');
           }
        });
    }

    function getSelectedStatusIds() {
        var IDs = new Array();
        $(".statusCheck:checked").each(function () {
            IDs.push($(this).val());
        });
        return IDs;
    }

    $("#createdPreset").change(function () {

        var selectVal = $(this).val();

        if (selectVal) {

            if (selectVal == 'custom') {
                $("#pModifyFrom").focus();
            }
            else {
                var preset = datePreset(selectVal);
                $("#pModifyFrom").val(preset.startDate);
                $("#pModifyTo").val(preset.endDate);
                //applyFilter();
            }
        }
    });

    
    function datePreset(preset) {

    var startDate;
    var endDate;

switch (preset) {

    case 'today':
        startDate = moment();
        endDate = moment();
        break;

    case 'yesterday':
        startDate = moment().subtract(1, 'days');
        endDate = moment().subtract(1, 'days');
        break;

    case 'last7days':
        startDate = moment().subtract(6, 'days');
        endDate = moment();
        break;

    case 'monthToDate':
        startDate = moment().startOf('month');
        endDate = moment();
        break;

    case 'previousMonth':
        startDate = moment().subtract(1, 'month').startOf('month');
        endDate = moment().subtract(1, 'month').endOf('month');
        break;

    case 'yearToDate':
        startDate = moment().startOf('year');
        endDate = moment();
        break;

    case 'previousYear':
        startDate = moment().subtract(1, 'year').startOf('year');
        endDate = moment().subtract(1, 'year').endOf('year');
        break;
}

var presetDate = {
    startDate: startDate.format('MM/DD/YYYY'),
    endDate: endDate.format('MM/DD/YYYY')
};

return presetDate;

}
</script>