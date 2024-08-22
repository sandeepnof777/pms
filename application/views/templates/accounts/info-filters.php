<div id="newFilter">
    <div class="clearfix">

        <div class="right" style="width: 400px; padding-top: 5px;">

            <div class="clearfix">

                <!--                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>-->
                <?php if ($this->session->userdata('accFilter')) { ?>
                    <a class="filterButton right" id="resetFilter" href="#">Reset</a>
                <?php
                        $rangeString = $this->session->userdata('accFilterFrom') . ' - ' . $this->session->userdata('accFilterTo');
                    }
                ?>

                <div class="filter-box right filter-loading" style="display: none;">
                    <img style="margin-top: 5px;" src="/static/loading.gif">
                </div>

                <div class="filter-box right clearfix <?php echo ($this->session->userdata('accFilterFrom') || $this->session->userdata('accFilterTo')) ? 'filterActive' : ''; ?>" id="accDateFilter">
                    <a class="trigger active" href="#">Date Range<?php echo ($this->session->userdata('accFilter')) ? ': ' . $rangeString . ' ' : ''; ?></a>

                    <div class="filter-code" style="padding: 5px; width: 270px; left: 50%; margin-left: -233px;">
                        <p class="clearfix" style="margin-bottom: 5px;">
                            <?php
                            $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
                            $startDate = date('m/d/Y', $companyStart);
                            $endDate = date('m/d/Y');
                            ?>
                            <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">From: </label> <input class="text left" value="<?php echo ($this->session->userdata('accFilterFrom')) ? $this->session->userdata('accFilterFrom') : $startDate; ?>" type="text" name="from" id="from" style="width: 66px;"/>
                            <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">To: </label> <input class="text left" value="<?php echo ($this->session->userdata('accFilterTo')) ? $this->session->userdata('accFilterTo') : $endDate; ?>" type="text" name="to" id="to" style="width: 66px;"/>
                        </p>
                        <a href="#" class="filterButton actionButton" id="allDates" style="margin-left: 55px; width: 70px; text-align: center; padding: 0;">Choose All</a>
                        <a class="filterButton blue actionButton" id="setDates" href="#" style="margin-left: 36px; width: 80px; text-align: center; padding: 0;">Apply</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <input type="hidden" id="filterFrom" name="filterFrom"
           value="<?php echo $this->session->userdata('accFilterFrom') ?>"/>
    <input type="hidden" id="filterTo" name="filterTo"
           value="<?php echo $this->session->userdata('accFilterTo') ?>"/>

    <div class="filterOverlay"></div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">

    $(document).ready(function(){

        closeFilters();

        var dates = $("#from, #to").datepicker({
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

        //Code for date pickers
        $("#setDates").live('click', function () {
            $("#datesFilter").addClass('filterActive');
            $("#datesFilter .trigger").text('Date Range: ...');
            $("#filterFrom").val($("#from").val());
            $("#filterTo").val($("#to").val());
            closeFilters();
            applyFilter();
        });

        $(".filterOverlay").live('click', function () {
            closeFilters();
        });
        $(".trigger.reset").live('click', function () {
            resetFilters();
        });

        $("#newFilter .trigger").live('click', function () {
            if ($(this).hasClass('active')) {
                //hide the filter
                closeFilters();
            } else {
                //show the filter
                closeFilters();
                $(this).addClass('active');
                $(this).next().show();
                $(".filterOverlay").css({
                    display: "block",
                    width: "100%",
                    height: "100%"
                });
            }
            return false;
        });

        //Code for user change filter
        $("#userFilter li a").click(function () {
            $("#userFilter .trigger").text($(this).attr('title'));
            $("#filterUserValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == 'All') {
                $("#userFilter").removeClass('filterActive');
            } else {
                $("#userFilter").addClass('filterActive');
            }
            closeFilters();
            return false;
        });

        $(".filter-list a").on('click', function () {
            applyFilter();
        });

        $("#applyFilter").click(function () {
            applyFilter();
            return false;
        });

        $("#allDates").click (function() {
            resetFilter();
        });

        $("#resetFilter").click(function() {
            resetFilter();
        });
    });

    function applyFilter() {
        $(".filter-loading").show();
        $("#reset-filter").show();

        var user = $("#filterUserValue").val();
        var from = $("#filterFrom").val();
        var to = $("#filterTo").val();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/setAccountsFilter') ?>',
            data: {
                accFilterUser: user,
                accFilterFrom: from,
                accFilterTo: to
            },
            dataType: 'JSON',
            success: function () {
                setTimeout(function () {
                    //disable reload for debug functionality
//                    document.location.reload();
                    document.location.href = '<?php echo site_url(uri_string()) ?>';
                }, 500);
            }
        });
    }

    function closeFilters() {
        $("#newFilter .trigger").removeClass('active');
        $(".filter-code").hide();
        $(".filterOverlay").hide();
    }

    function resetFilter() {
        $("#reset-filter").show();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/resetAccountsFilter') ?>',
            data: {},
            dataType: 'JSON',
            success: function () {
                setTimeout(function () {
                    //disable reload for debug functionality
                    document.location.reload();
                }, 300);
            }
        });
        return false;
    }



</script>