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

$(document).ready(function () {
    $(".percentInput").mask("9?9%");

    $(".percentInput").on("blur", function() {
        var value = $(this).val().length == 1 ? $(this).val() + '%' : $(this).val();
        $(this).val( value );
    });

    updateSalesTarget("sales_target");

    $("#sales_target").keyup(function() {
        var id = $(this).attr('id');
        updateSalesTarget(id);
    });


    $("#saveConfig").on('click', function() {

        $('input').removeClass('error');

        var sales_target = $("#sales_target").val();
        sales_target = sales_target.replace('$', '');
        sales_target = sales_target.replace(/,/g, '');
        var configData = {
            sales_target: parseInt(sales_target),
            weeks_per_year: $("#weeks_per_year").val(),
            win_rate: parseInt($("#win_rate").val()),
            enabled: $("#enabled").val()
        };


        //Validate

        // Win rate bust be over 0
        if (configData.win_rate < 1) {

            $("#win_rate").addClass('error');

            swal({
                title: "Error",
                text: "'Win Rate' must be a minimum of 1",
                type: "warning"
            });
            return false;
        }

        // Weeks per year must be at least 1
        if (configData.weeks_per_year < 1) {

            $("#weeks_per_year").addClass('error');

            swal({
                title: "Error",
                text: "'Weeks Per Year' must be a minimum of 1",
                type: "warning"
            });
            return false;
        }

        // Weeks per year can't exceed 52
        if (configData.weeks_per_year > 52) {

            $("#weeks_per_year").addClass('error');

            swal({
                title: "Error",
                text: "Maximum 'Weeks Per Year' is 52",
                type: "warning"
            });
            return false;
        }

        // Validation passed by here, save the data
        $.ajax({
            type: "POST",
            url: "/account/save_sales_targets",
            data: {
                config: configData
            },
            success: function(data) {
                swal({
                    title: "Success",
                    text: "Data Saved!",
                    type: "success"
                });
            },
            error: function(data) {
                swal({
                    title: "Error",
                    text: "There was an error saving the data. Please refresh and try again.",
                    type: "warning"
                });
            }
        });
    });
});