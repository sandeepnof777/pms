<div class="left" style="width: 49px;">
    <label class="filterLabel">Filter</label>
</div>
<div class="left" style="width: 900px;">

    <div class="clearfix" style="margin-bottom: 10px;">
        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterStatus') && ($this->session->userdata('pFilterStatus') != 'All')) ? 'filterActive' : '' ?>" id="statusFilter">
            <a class="trigger" href="#">Status: <?php echo ($this->session->userdata('pFilterStatus') && ($this->session->userdata('pFilterStatus') != 'All')) ? $this->session->userdata('pFilterStatusName') : 'All' ?></a>

            <div class="filter-code">
                <ul class="filter-list">
                    <li><a title="Status: All" rel="All" href="#">All</a></li>
                    <?php
                    foreach ($statusCollection as $status){
                        ?>
                        <li><a title="Status: <?php echo $status->getText(); ?>" rel="<?php echo $status->getStatusId(); ?>" href="#"><?php echo $status->getText(); ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <?php if ($account->getUserClass() >= 2) { ?>
            <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilter') && ($this->session->userdata('pFilterBranch') || ($this->session->userdata('pFilterBranch') == '0'))) ? 'filterActive' : ''; ?>" id="branchFilter">
                <a class="trigger" href="#">Branch: <?php
                    $foundBranch = false;
                    foreach ($branches as $branchId => $branch) {
                        if ($branchId == $this->session->userdata('pFilterBranch')) {
                            $foundBranch = true;
                            echo $branch->getBranchName();
                        }
                    }
                    if (!$foundBranch) {
                        if ($this->session->userdata('pFilter') && (($this->session->userdata('pFilterBranch') == 'Main') || ($this->session->userdata('pFilterBranch') == '0'))) {
                            echo 'Main';
                        } else {
                            echo 'All';
                        }
                    }
                    ?>
                </a>

                <div class="filter-code">
                    <ul class="filter-list">
                        <li><a title="Branch: All" rel="All" href="#">All</a></li>
                        <li><a href="#" title="Branch: Main" rel="0">Main</a></li>
                        <?php
                        foreach ($branches as $branch) {
                            ?>
                            <li><a title="Branch: <?php echo $branch->getBranchName() ?>" rel="<?php echo $branch->getBranchId() ?>" href="#"><?php echo $branch->getBranchName() ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
        <?php if ($account->getUserClass() >= 1) { ?>
            <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterUser') && ($this->session->userdata('pFilterUser') != 'All')) ? 'filterActive' : ''; ?>" id="userFilter">
                <a class="trigger" href="#">User: <?php
                    $found = false;
                    if ($this->session->userdata('pFilterUser') && ($this->session->userdata('pFilterUser') != 'All')) {
                        foreach ($accounts as $acc) {
                            if ($acc->getAccountId() == $this->session->userdata('pFilterUser')) {
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
                                <li class="branchUser branch_<?php echo $acc->getBranch() ?>"><a title="User: <?php echo $acc->getFullName() ?>" rel="<?php echo $acc->getAccountId() ?>" href="#"><?php echo $acc->getFullName() ?></a></li>
                            <?php
                            }
                        }
                        ?>
                    </ul>
                </div>

            </div>
        <?php } ?>


        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterClientAccount') && ($this->session->userdata('pFilterClientAccount') != 'All')) ? 'filterActive' : ''; ?>" id="clientAccountFilter">
            <a class="trigger" href="#">Account: <?php
                $found = false;
                if ($this->session->userdata('pFilterClientAccount') && ($this->session->userdata('pFilterClientAccount') != 'All')) {
                    foreach ($clientAccounts as $clientAccount) {
                        if ($clientAccount->getId() == $this->session->userdata('pFilterClientAccount')) {
                            $found = true;
                            echo $clientAccount->getName();
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
                    <li><a title="Account: All" rel="All" href="#">All</a></li>
                    <?php
                    foreach ($clientAccounts as $clientAccount) { ?>
                        <li class="clientAccount clientAccount_<?php echo $clientAccount->getId(); ?>"><a title="Account: <?php echo $clientAccount->getName() ?>" rel="<?php echo $clientAccount->getId() ?>" href="#"><?php echo $clientAccount->getName() ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>

        </div>

        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterService')) ? 'filterActive' : ''; ?>" id="servicesFilter">
            <a class="trigger" href="#">Service: <?php
                $foundService = false;
                foreach ($categories as $cat) {
                    if (is_array(@$services[$cat->getServiceId()])) {
                        foreach ($services[$cat->getServiceId()] as $service) {
                            if ($service->getServiceId() == $this->session->userdata('pFilterService')) {
                                echo (strlen($service->getServiceName()) <= 10) ? $service->getServiceName() : substr($service->getServiceName(), 0, 10) . '...';
                                $foundService = true;
                                break;
                            }
                        }
                    }
                }
                if (!$foundService) {
                    echo 'All';
                }
                ?></a>

            <div class="filter-code" style="width: 200px; padding: 5px;">
                <label>Select Service:</label>
                <select name="services[]" id="filterServiceSelect" style="display: block;">
                    <option value="0">All</option>
                    <?php
                    foreach ($categories as $cat) {
                        ?>
                        <optgroup label="<?php echo $cat->getServiceName() ?>">
                            <?php
                            if (isset($services[$cat->getServiceId()])) {
                                foreach ($services[$cat->getServiceId()] as $service) {
                                    ?>
                                    <option value="<?php echo $service->getServiceId() ?>" <?php if ($this->session->userdata('pFilterService') == $service->getServiceId()) { ?> selected="selected"<?php }  ?>><?php echo $service->getServiceName() ?></option>
                                <?php
                                }
                            }
                            ?>
                        </optgroup>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterFrom') || $this->session->userdata('pFilterTo')) ? 'filterActive' : ''; ?>" id="datesFilter">
            <a class="trigger active" href="#">Date Range</a>

            <div class="filter-code" style="padding: 5px; width: 270px; left: 50%; margin-left: -135px;">
                <p class="clearfix" style="margin-bottom: 5px;">
                    <?php
                    $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
                    $startDate = date('m/d/Y', $companyStart);
                    $endDate = date('m/d/Y');
                    ?>
                    <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">From: </label> <input class="text left" value="<?php echo ($this->session->userdata('pFilterFrom')) ? $this->session->userdata('pFilterFrom') : $startDate; ?>" type="text" name="from" id="from" style="width: 66px;"/>
                    <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">To: </label> <input class="text left" value="<?php echo ($this->session->userdata('pFilterTo')) ? $this->session->userdata('pFilterTo') : $endDate; ?>" type="text" name="to" id="to" style="width: 66px;"/>
                </p>
                <a href="#" class="filterButton actionButton" id="allDates" style="margin-left: 55px; width: 70px; text-align: center; padding: 0;">Choose All</a>
                <a class="filterButton blue actionButton" id="setDates" href="#" style="margin-left: 36px; width: 80px; text-align: center; padding: 0;">Apply</a>
            </div>
        </div>

        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterQueue')) ? 'filterActive' : ''; ?>" id="queuedFilter">
            <a class="trigger" href="#"><?php
                switch ($this->session->userdata('pFilterQueue')) {
                    case '1':
                        echo 'Queued Proposals';
                        break;
                    case '2':
                        echo 'Denied Proposals';
                        break;
                    case 'duplicate':
                        echo 'Duplicate Proposals';
                        break;
                    default:
                        echo 'All Proposals';
                        break;
                }
                ?></a>

            <div class="filter-code" style="">
                <ul class="filter-list">
                    <li><a href="#" rel="0">All Proposals</a></li>
                    <?php if ((QUEUEDPROPOSALS > 0) || (DECLINEDPROPOSALS > 0)) { ?>
                        <li><a href="#" rel="1">Queued Proposals</a></li>
                        <li><a href="#" rel="2">Declined Proposals</a></li>
                    <?php } ?>
                    <li><a href="#" rel="duplicate">Duplicate Proposals</a></li>
                </ul>
            </div>
        </div>

        <!--
        <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterEmailStatus')) ? 'filterActive' : ''; ?>" id="emailFilter">
            <a class="trigger" href="#"><?php
                switch ($this->session->userdata('pFilterEmailStatus')) {
                    case \models\Proposals::EMAIL_UNSENT :
                        echo 'Unsent Proposals';
                        break;
                    case \models\Proposals::EMAIL_SENT :
                        echo 'Sent Proposals';
                        break;
                    case \models\Proposals::EMAIL_EDITED :
                        echo 'Edited Proposals';
                        break;
                    case 'd':
                        echo 'Delivered Proposals';
                        break;
                    case 'o' :
                        echo 'Opened Proposals';
                        break;
                    case 'uo':
                        echo 'Unopened Proposals';
                        break;
                    case 'u':
                        echo 'Undelivered Proposals';
                        break;
                    default:
                        echo 'Email Status';
                        break;
                }
                ?></a>

            <div class="filter-code" style="">
                <ul class="filter-list">
                    <li><a href="#" rel="0">All Proposals</a></li>
                    <li><a href="#" rel="1">Unsent Proposals</a></li>
                    <li><a href="#" rel="2">Sent Proposals</a></li>
                    <li><a href="#" rel="3">Edited Proposals</a></li>
                    <li><a href="#" rel="d">Delivered Proposals</a></li>
                    <li><a href="#" rel="o">Opened Proposals</a></li>
                    <li><a href="#" rel="uo">Unopened Proposals</a></li>
                    <li><a href="#" rel="u">Undelivered Proposals</a></li>
                </ul>
            </div>
        </div>
        -->

        <div class="filter-box filter-loading" style="display: none;">
            <img style="margin-top: 5px;" src="/static/loading.gif">
        </div>

    </div>

    <div class="clearfix">
<!--        <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>-->
        <?php if ($this->session->userdata('pFilter')) { ?>
            <a class="filterButton" href="<?php echo site_url('proposals/resetFilter/1') ?>">Reset</a>
        <?php } ?>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
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
        $("#filter-dialog").dialog({
            modal: true,
            buttons: {
                Apply: function () {
                    $("#filter-form").submit();
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
        });
        $("#filter").click(function () {
            $("#filter-dialog").dialog('open');
        });
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 75, 300 ],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
        $("#alldates, #allDates").click(function () {
            <?php
$companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
$startDate = date('m/d/Y', $companyStart);
$endDate = date('m/d/Y');
?>
            $("#from").val('<?php echo $startDate ?>');
            $("#to").val('<?php echo $endDate ?>');
            return false;
        });

        $("#services_dropdowns").hide();
        $("#AllServices").attr('checked', 'checked');
        $("#buttonset2 input").change(function () {
            if ($(this).val() == '1') {
                $("#services_dropdowns").show();
            } else {
                $("#services_dropdowns").hide();
            }
        });


        $("#reset-filter, .filterButton.reset").click(function () {
            
            resetFilters();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('proposals/resetFilter') ?>',
                success: function () {
                    $("#reset-filter").hide();
                    $("#All").attr('checked', 'checked');
                    $("#allusers").attr('checked', 'checked');
                    $("#service option:first").attr('selected', 'selected');
                    $("#from, #to").val('');
                    $.uniform.update();
//                    initProposals();
                    document.location.reload();
                    $("#proposals-filter-box-name").html('Proposals Filter');
                }
            });
            return false;
        });
        $("#apply-filter").click(function () {
            $("#reset-filter").show();
            var user = $('input[name=user]:checked').val();
            var status = $('input[name=status]:checked').val();
            var service = $("#service").val();
            var from = $("#from").val();
            var to = $("#to").val();
            console.log('working');
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setProposalFilter') ?>',
                data: {
                    pFilterUser: user,
                    pFilterStatus: status,
                    pFilterService: service,
                    pFilterFrom: from,
                    pFilterTo: to
                },
                dataType: 'JSON',
                success: function () {
                    setTimeout(function () {
//                        initProposals();
                        document.location.reload();
                        $("#proposals-filter-box-name").html('Proposals Filter - Active');
                    }, 500);
                }
            });
            return false;
        });


        /*New Filter Code*/
        function closeFilters() {
            $("#newFilter .trigger").removeClass('active');
            $(".filter-code").hide();
            $(".filterOverlay").hide();
        }

        //updates branch users -- hides the users that are not needed when a branch is selected.
        function updateBranchUsers() {
            //show all
            $(".branchUser").show();
            if (($("#filterBranchValue").val() != 'All') && ($("#filterBranchValue").val() != '')) {
                var userClass = 'branch_' + $("#filterBranchValue").val();
//                console.log('userClass:' + userClass);
                //hide users that do not belong
                $(".branchUser:not(." + userClass + ")").hide();
                //reset user filter selector
                $("#userFilter").removeClass('filterActive');
                $("#userFilter .trigger").text('User: All');
            } else {
//                console.log('NOUP');
            }
        }

//        updateBranchUsers();
        closeFilters(); //init with all filters closed to prevent the browser refresh cache

        function resetFilters() {
            $("#statusFilter").removeClass('filterActive');
            $("#statusFilter .trigger").text('Status: All');
            $("#userFilter").removeClass('filterActive');
            $("#userFilter .trigger").text('User: All');
            $("#branchFilter").removeClass('filterActive');
            $("#branchFilter .trigger").text('Branch: All');
            $("#datesFilter").removeClass('filterActive');
            $("#datesFilter .trigger").text('Date Range');
            $("#queuedFilter").removeClass('filterActive');
            $("#queuedFilter .trigger").text('All Proposals');
            $("#emailFilter").removeClass('filterActive');
            $("#emailFilter .trigger").text('Email Status');
            $("#clientAccountFilter").removeClass('filterActive');
            $("#clientAccountFilter .trigger").text('Account');
        }

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
        });
        //Code for status change filter
        $("#statusFilter li a").click(function () {
            $("#statusFilter .trigger").text($(this).attr('title'));
            $("#filterStatusValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == 'All') {
                $("#statusFilter").removeClass('filterActive');
            } else {
                $("#statusFilter").addClass('filterActive');
            }
            closeFilters();
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

        // Client Account Filter
        $("#clientAccountFilter li a").click(function () {
            $("#clientAccountFilter .trigger").text($(this).attr('title'));
            $("#filterClientAccountValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == 'All') {
                $("#clientAccountFilter").removeClass('filterActive');
            } else {
                $("#clientAccountFilter").addClass('filterActive');
            }
            closeFilters();
            return false;
        });
        //Code for branch change filter
        $("#branchFilter li a").click(function () {
            $("#branchFilter .trigger").text($(this).attr('title'));
            $("#filterBranchValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == 'All') {
                $("#branchFilter").removeClass('filterActive');
            } else {
                $("#branchFilter").addClass('filterActive');
            }
            updateBranchUsers();
            closeFilters();
            return false;
        });
        $("#filterServiceSelect").live('change', function () {
            var text = $(this).find(':selected').text();
            if (text.length > 10) {
                text = text.substr(0, 10) + '...';
            }
            $("#servicesFilter .trigger").text('Service: ' + text);
            $("#filterServiceValue").val($(this).find(':selected').val());
            if ($(this).find(':selected').text() == 'All') {
                $("#servicesFilter").removeClass('filterActive');
            } else {
                $("#servicesFilter").addClass('filterActive');
            }
            closeFilters();
            applyFilter();
        });
        //Code for date pickers
        $("#setDates").live('click', function () {
            $("#datesFilter").addClass('filterActive');
            $("#datesFilter .trigger").text('Date Range: ...');
            $("#filterServiceFrom").val($("#from").val());
            $("#filterServiceTo").val($("#to").val());
            closeFilters();
            applyFilter();
        });
        /*
         * Apply Filter Functionality
         * */

        $(".filter-list a").on('click', function () {
            applyFilter();
        });

        $("#applyFilter").click(function () {
            applyFilter();
            return false;
        });

        function applyFilter() {
             
            $(".filter-loading").show();
            setTimeout(function() {
                $("#reset-filter").show();
                var branch = $("#filterBranchValue").val();
                var status = $("#filterStatusValue").val();
                var user = $("#filterUserValue").val();
                var service = $("#filterServiceValue").val();
                var from = $("#filterServiceFrom").val();
                var to = $("#filterServiceTo").val();
                var queue = $("#filterQueueValue").val();
                var emailStatus = $("#filterEmailStatus").val();
                var clientAccount = $("#filterClientAccountValue").val();
                console.log('working1');
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('ajax/setProposalFilter') ?>',
                    data: {
                        pFilterUser: user,
                        pFilterStatus: status,
                        pFilterService: service,
                        pFilterFrom: from,
                        pFilterTo: to,
                        pFilterBranch: branch,
                        pFilterQueue: queue,
                        pFilterEmailStatus: emailStatus,
                        pFilterClientAccount: clientAccount
                    },
                    dataType: 'JSON',
                    success: function () {
                        setTimeout(function () {
                            //disable reload for debug functionality
//                        document.location.reload();
                            document.location.href = '<?php echo site_url(uri_string()) ?>';
                        }, 500);
                    }
                });
            }, 500);
        }
        /*
         * Queued Filter Functionality
         */
        $("#queuedFilter li a").click(function () {
            $("#queuedFilter .trigger").text($(this).text());
            $("#filterQueueValue").val($(this).attr('rel'));
            if ($(this).attr('rel') == '0') {
                $("#queuedFilter").removeClass('filterActive');
            } else {
                $("#queuedFilter").addClass('filterActive');
            }
            closeFilters();
            return false;
        });
        /*
         * Email Filter Functionality
         */
        $("#emailFilter li a").click(function () {
            $("#emailFilter .trigger").text($(this).text());
            $("#filterEmailStatus").val($(this).attr('rel'));
            if ($(this).attr('rel') == '0') {
                $("#emailFilter").removeClass('filterActive');
            } else {
                $("#emailFilter").addClass('filterActive');
            }
            closeFilters();
            return false;
        });

    });
</script>