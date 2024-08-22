<?php /* @var $export \models\SavedReport */ ?>
<?php $this->load->view('global/header'); ?>


<div id="content" class="clearfix">
    <div class="widthfix">

<?php
    switch ($export->getReportType()->getId()){

        case \models\ReportType::PROPOSALS:
            $this->load->view('export/saved-exports/proposals-form');
            break;

        case \models\ReportType::PROSPECTS:
            $this->load->view('export/saved-exports/prospects-form');
            break;

        case \models\ReportType::LEADS:
            $this->load->view('export/saved-exports/leads-form');
            break;

        case \models\ReportType::HISTORY:
            $this->load->view('export/saved-exports/history-form');
            break;

        case \models\ReportType::CLIENTS:
            $this->load->view('export/saved-exports/clients-form');
            break;

        case \models\ReportType::SERVICES:
            $this->load->view('export/saved-exports/services-form');
            break;

    }
?>

    </div>
</div>

<script>

    $(document).ready(function(){

        <?php
            $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
            $startDate = date('m/d/Y', $companyStart);
            $endDate = date('m/d/Y');
        ?>

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


        // Status change datepicker
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

        // If a date is selected, apply the filter
        $("#statusFrom, #statusTo").click(function(){
            $("#statusApply").attr('checked', true);
            $.uniform.update();
        });

        // Status date change all time
        $("#statusAllDates").click(function () {
            $("#statusFrom").val('<?php echo $startDate ?>');
            $("#statusTo").val('<?php echo $endDate ?>');
            $("#statusApply").attr('checked', true);
            $.uniform.update();
            return false;
        });

        $("#alldates2").click(function () {
            $("#from2").val('<?php echo $startDate ?>');
            $("#to2").val('<?php echo $endDate ?>');
            return false;
        });

        // Status date change tool tip
        $("#statusHelp").tipTip({activation: 'click', defaultPosition : 'right'});

    });

</script>

<?php $this->load->view('global/footer'); ?>