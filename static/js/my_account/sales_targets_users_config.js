function calculateValues() {
    $("tbody tr.userConfig").each(function () {
        var id = $(this).data("id");
        var salesTarget = ($("#salesTarget_" + id).val());
        salesTarget = salesTarget.replace('$', '');
        salesTarget = salesTarget.replace(/,/g, '');
        salesTarget = parseInt(salesTarget);
        var winRate = parseInt($("#winRate_" + id).val());
        var weeksPerYear = parseInt($("#weeksPerYear_" + id).val());
        var bidTarget = Math.round(salesTarget * (100 / winRate));
        var bidPerDay = Math.round(bidTarget / weeksPerYear);
        $("#bidTarget_" + id).html("$" + bidTarget.formatMoney(0));
        $("#bidPerDay_" + id).html("$" + bidPerDay.formatMoney(0));
    });
}

function updateSalesTarget(id) {

    var dollarValue = $("#" + id).val();
    dollarValue = dollarValue.replace('$', '');
    dollarValue = dollarValue.replace(/,/g, '');
    var val = parseInt(dollarValue);
     if (val == '') {
     val = 0;
     }
    var formattedString = "$" + val.formatMoney(0);
    $("#" + id).val(formattedString);
}

var unsavedChanges = false;

$(document).ready(function () {

    formatInputs();
    setSalesTargets();
    calculateValues();

    $(".percentInput").mask("9?9%");
    $(".dateInput").mask("99/99/99");

    $(".percentInput").on("blur", function() {
        var value = $(this).val().length == 1 ? $(this).val() + '%' : $(this).val();
        $(this).val( value );
    });

    $(".salesTarget").keyup(function() {
        var id = $(this).attr('id');
        updateSalesTarget(id);
    });

    $("tbody input:text").change(function () {
        calculateValues();
    });

    $("tbody input:text").keyup(function () {
        calculateValues();
    });

    $(".saveConfig").on('click', function () {

        swal({
            title: "Saving",
            text: "Saving Targets Data",
            type: "info",
            showConfirmButton: false,
        });

        var configData = {
            userConfigs: {}
        };

        var inputError = false;
        var errorFields = [];

        $("#salesTargetsUserConfig input:text").each(function () {
            var id = $(this).data('id');
            var key = $(this).data('key');
            var val = ($(this).val());
            val = val.replace('$', '');
            val = val.replace(/,/g, '');

            if (key != 'start_date') {
                val = parseInt(val);
            }

            if (typeof configData.userConfigs[id] == 'undefined') {
                configData.userConfigs[id] = {};
            }
            configData.userConfigs[id][key] = val;

            if (configData.userConfigs[id]['win_rate'] < 1) {
                inputError = true;
                errorFields.push($("#winRate_" + id));
            }

            if (configData.userConfigs[id]['weeks_per_year'] < 1 || configData.userConfigs[id]['weeks_per_year'] > 52) {
                inputError = true;
                errorFields.push($("#weeksPerYear_" + id));
            }
        });

        // Highlight the errors
        if (inputError || errorFields.length) {
            $.each(errorFields, function (key, element) {
                element.addClass('error');
            });

            swal({
                title: "Error",
                html: "<p><strong>Win Rate</strong> must be a minimum of 1</p>" +
                "<p><strong>Weeks Per Year</strong> must be between 1 - 52</p>" +
                "<br />" +
                "<p>Please update any highlighted fields</p>",
                type: "warning"
            });

            return false;
        }

        $.ajax({
            type: "POST",
            url: "/account/save_sales_targets_users",
            data: {
                config: configData
            },
            success: function (data) {
                calculateValues();
                unsavedChanges = false;
                swal({
                    title: "Success",
                    text: "Data saved!",
                    type: "success"
                });
            },
            error: function (data) {
                swal({
                    title: "Error",
                    text: "There was an error saving the data. Please refresh and try again.",
                    type: "warning"
                });
            }
        });
    });

    $('input[type="text"]').uniform();

    // When checking/unchecking all
    $("#checkAll").change(function() {
        var checked = false;

        if ($(this).is(':checked')) {
            checked = true;
        }

        $(".accountCheck").prop('checked', checked);
        $.uniform.update();
        toggleGroupActions();
    });

    // Checking/unchecking
    $('.accountCheck').change(function() {
       toggleGroupActions();
    });

    // Default button click
    $("#setToDefault").click(function() {
        var ids = getSelectedIds();

        var defaultWinRate = $("#defaultWinRate").val();
        var defaultSalesTarget = $("#defaultSalesTarget").val();
        var defaultWeeks = $("#defaultWeeks").val();

        var i = 0;
        $.each(ids, function(index, value){
            $("#winRate_" + value).val(defaultWinRate + '%');
            $("#salesTarget_" + value).val(defaultSalesTarget);
            $("#weeksPerYear_" + value).val(defaultWeeks);
            updateSalesTarget("salesTarget_" + value);
            i++;
        });
        calculateValues();

        swal({
            title: i + " users set to default values.",
            html: "<p>Click <strong>OK</strong> to save, or <strong>Cancel</strong> to revert.</p>",
            type: "info",
            showCancelButton: true,
            showLoaderOnConfirm: true
        }).then(function() {
            $(".saveConfig").trigger('click');
        }, function (dismiss) {
            window.location.reload();
            var alert = swal({
                title: "Reloading",
                text: "We're reloading the previous values",
                type: "info",
                showConfirmButton: false,
                showLoading: true
            });
            alert.disableButtons();
            alert.showLoading();

        });

    });

    // Mark Values as unsaved when changed
    $("input").on('input', function() {
        unsavedChanges = true;
    });

    function toggleGroupActions() {
        var numChecked = $('.accountCheck:checked').length;

        if (numChecked > 0) {
           $("#salesTargetUsersGroupActions").show();
           return false;
        }
        $("#salesTargetUsersGroupActions").hide();
    }

    function getSelectedIds() {
        var IDs = new Array();

        $(".accountCheck:checked").each(function () {
            IDs.push($(this).val());
        });

        return IDs;
    }

    function formatInputs() {
        $(".percentInput").each(function() {
            $(this).val(parseInt($(this).val()) + "%");
        });
    }

    function setSalesTargets() {
        $(".salesTarget").each(function () {
            var id = $(this).attr('id');
            updateSalesTarget(id);
        });
    }

    function unloadPage(){

        if (unsavedChanges) {
            return 'You have unsaved changes!'
        }

    }

    window.onbeforeunload = unloadPage;

});