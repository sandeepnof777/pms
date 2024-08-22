<div id="newFilter">
    <div class="clearfix">
        <div class="left" style="width: 49px;">
            <label class="filterLabel">Filter</label>
        </div>
        <div class="left" style="width: 900px;">

            <div class="clearfix" style="margin-bottom: 10px;">

                <?php if ($account->getUserClass() >= 1) { ?>
                    <div
                        class="filter-box clearfix <?php echo ($this->session->userdata('accFilterUser') && ($this->session->userdata('accFilterUser') != 'All')) ? 'filterActive' : ''; ?>"
                        id="userFilter">
                        <a class="trigger" href="#">User: <?php
                            $found = false;
                            if ($this->session->userdata('accFilterUser') && ($this->session->userdata('accFilterUser') != 'All')) {
                                foreach ($accounts as $acc) {
                                    if ($acc->getAccountId() == $this->session->userdata('accFilterUser')) {
                                        $found = true;
                                        echo $acc->getFullName();
                                        break;
                                    }
                                }
                            }
                            if (!$found) {
                                echo 'All';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="User: All" rel="All" href="#">All</a></li>
                                <?php
                                foreach ($accounts as $acc) {
                                    if ((($account->getUserClass() == 1) && ($acc->getBranch() == $account->getBranch())) || ($account->getUserClass() >= 2)) {
                                        ?>
                                        <li class="branchUser branch_<?php echo $acc->getBranch() ?>"><a
                                                title="User: <?php echo $acc->getFullName() ?>"
                                                rel="<?php echo $acc->getAccountId() ?>"
                                                href="#"><?php echo $acc->getFullName() ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-box clearfix <?php echo (($this->session->userdata('accFilterBranch') || $this->session->userdata('accFilterBranch') === '0') && ($this->session->userdata('accFilterBranch') != 'All')) ? 'filterActive' : ''; ?>"
                            id="branchFilter">
                        <a class="trigger" href="#">Branch: <?php
                            $found = false;
                            if (($this->session->userdata('accFilterBranch') || $this->session->userdata('accFilterBranch') === '0') && ($this->session->userdata('accFilterBranch') != 'All')) {

                                if ($this->session->userdata('accFilterBranch') === '0') {
                                    $found = true;
                                    echo 'Main';
                                }
                                else {
                                    foreach ($branches as $branch) {
                                        if ($branch->getBranchId() == $this->session->userdata('accFilterBranch')) {
                                            $found = true;
                                            echo $branch->getBranchName();
                                            break;
                                        }
                                    }
                                }
                            }
                            if (!$found) {
                                echo 'All';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="Branch: All" rel="All" href="#">All</a></li>
                                <li><a title="Branch: Main" rel="0" href="#">Main</a></li>
                                <?php
                                foreach ($branches as $branch) {
                                    ?>
                                    <li><a
                                                title="Branch: <?php echo $branch->getBranchName(); ?>"
                                                rel="<?php echo $branch->getBranchId();  ?>"
                                                href="#"><?php echo $branch->getBranchName(); ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <div class="filter-box clearfix <?php echo ($this->session->userdata('accFilterFrom') || $this->session->userdata('accFilterTo')) ? 'filterActive' : ''; ?>" id="accDateFilter">
                    <a class="trigger active" href="#">Date Range</a>

                    <div class="filter-code" style="padding: 5px; width: 270px; left: 50%; margin-left: -135px;">
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

                <div class="filter-box filter-loading" style="display: none;">
                    <img style="margin-top: 5px;" src="/static/loading.gif">
                </div>

                <!--                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>-->
                <?php if ($this->session->userdata('accFilter')) { ?>
                    <a class="filterButton" id="resetFilter" href="#">Reset</a>
                <?php } ?>

            </div>

        </div>
    </div>
    <input type="hidden" name="filterUserValue" id="filterUserValue"
           value="<?php echo $this->session->userdata('accFilterUser'); ?>"/>
    <input type="hidden" id="filterFrom" name="filterFrom"
           value="<?php echo $this->session->userdata('accFilterFrom') ?>"/>
    <input type="hidden" id="filterTo" name="filterTo"
           value="<?php echo $this->session->userdata('accFilterTo') ?>"/>
    <input type="hidden" id="filterBranchValue" name="filterBranchValue"
           value="<?php echo $this->session->userdata('accFilterBranch') ?>"/>

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

        $("#branchFilter li a").click(function () {
            $("#branchFilter .trigger").text($(this).attr('title'));
            $("#filterBranchValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == 'All') {
                $("#branchFilter").removeClass('filterActive');
            } else {
                $("#branchFilter").addClass('filterActive');
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

        $("#resetFilter").click(function () {
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
        });

    });

    function applyFilter() {
        $(".filter-loading").show();
        $("#reset-filter").show();

        var user = $("#filterUserValue").val();
        var from = $("#filterFrom").val();
        var to = $("#filterTo").val();
        var branch = $("#filterBranchValue").val();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/setAccountsFilter') ?>',
            data: {
                accFilterUser: user,
                accFilterFrom: from,
                accFilterTo: to,
                accFilterBranch: branch
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

    function resetFilters() {
        $("#userFilter").removeClass('filterActive');
        $("#userFilter .trigger").text('User: All');
    }




</script>