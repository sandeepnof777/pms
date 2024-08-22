<?php
    //var_dump($this->session->all_userdata());
?>
<div id="newFilter">
    <div class="clearfix">
        <div class="left" style="width: 49px;">
            <label class="filterLabel">Filter</label>
        </div>
        <div class="left" style="width: <?php echo ($filter) ? 470 : 900 ?>px;">
            <?php if (!$filter) { ?>
                <div class="clearfix" style="margin-bottom: 10px;">

                    <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilterType') && ($this->session->userdata('lFilterType') != 'All')) ? 'filterActive' : ''; ?>" id="typeFilter">
                        <a class="trigger" href="#">Type: <?php
                            $found = false;

                            if ($this->session->userdata('lFilterType') && ($this->session->userdata('lFilterType') != 'All')) {
                                foreach ($leadTypes as $leadType) {
                                    if ($leadType == $this->session->userdata('lFilterType')) {
                                        $found = true;
                                        echo $leadType;
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
                                foreach ($leadTypes as $leadType) {
                                ?>
                                    <li class=""><a title="Type: <?php echo $leadType ?>" rel="<?php echo $leadType ?>" href="#"><?php echo $leadType ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

                    </div>



                    <?php if ($account->getUserClass() >= 3) { ?>
                        <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilter') && ($this->session->userdata('lFilterBranch') || ($this->session->userdata('lFilterBranch') == '0'))) ? 'filterActive' : ''; ?>" id="branchFilter">
                            <a class="trigger" href="#">Branch: <?php
                                $foundBranch = false;
                                foreach ($branches as $branchId => $branch) {
                                    if ($branchId == $this->session->userdata('lFilterBranch')) {
                                        $foundBranch = true;
                                        echo $branch->getBranchName();
                                    }
                                }
                                if (!$foundBranch) {
                                    if ($this->session->userdata('lFilter') && (($this->session->userdata('lFilterBranch') == 'Main') || ($this->session->userdata('lFilterBranch') == '0'))) {
                                        echo 'Main';
                                    } else {
                                        echo 'All';
                                    }
                                }
                                ?>
                            </a>

                            <div class="filter-code">
                                <ul class="filter-list">
                                    <li><a title="Branch: All" rel="" href="#">All</a></li>
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
                        <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilterUser') && ($this->session->userdata('lFilterUser') != 'All') || $this->session->userdata('lFilterUser') === 'u') ? 'filterActive' : ''; ?>" id="userFilter">
                            <a class="trigger" href="#">User: <?php
                                $found = false;

                                if ($this->session->userdata('lFilterUser') === 'u') {
                                    $found = true;
                                    echo 'Unassigned';
                                }
                                if ($this->session->userdata('lFilterUser') && ($this->session->userdata('lFilterUser') != 'All')) {
                                    foreach ($accounts as $acc) {
                                        if ($acc->getAccountId() == $this->session->userdata('lFilterUser')) {
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
                                    <li><a title="Unassigned" rel="u" href="#">Unassigned</a></li>
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

                    <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilter') && ($this->session->userdata('lFilterSource') && ($this->session->userdata('lFilterSource') != 'All'))) ? 'filterActive' : ''; ?>" id="sourceFilter">
                        <a class="trigger" href="#">Source: <?php
                            $foundSource = false;
                            foreach ($leadSources as $leadSource) {
                                if ($leadSource == $this->session->userdata('lFilterSource')) {
                                    $foundSource = true;
                                    echo $leadSource;
                                }
                            }
                            if ($this->session->userdata('lFilterSource') == 'All') {
                                echo 'All';
                                $foundSource = true;
                            } elseif (!$foundSource) {
                                echo 'All';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="Source: All" rel="All" href="#">All</a></li>
                                <?php
                                foreach ($leadSources as $leadSource) {
                                    ?>
                                    <li><a title="Source: <?php echo $leadSource; ?>" rel="<?php echo $leadSource ?>" href="#"><?php echo $leadSource; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilter') && ($this->session->userdata('lFilterStatus') || ($this->session->userdata('lFilterStatus') == '0'))) ? 'filterActive' : ''; ?>" id="statusFilter">
                        <a class="trigger" href="#">Status: <?php
                            $foundStatus = false;
                            foreach ($leadStatuses as $leadStatus) {
                                if ($leadStatus == $this->session->userdata('lFilterStatus')) {
                                    $foundStatus = true;
                                    echo $leadStatus;
                                }
                            }
                            if ($this->session->userdata('lFilterStatus') == 'All') {
                                echo 'All';
                                $foundStatus = true;
                            } elseif (!$foundStatus) {
                                echo 'Active';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="Status: Active" rel="" href="#">Active</a></li>
                                <?php
                                foreach ($leadStatuses as $leadStatus) {
                                    ?>
                                    <li><a title="Lead Status: <?php echo $leadStatus; ?>" rel="<?php echo $leadStatus ?>" href="#"><?php echo $leadStatus; ?></a></li>
                                    <?php
                                }
                                ?>
                                <li><a title="Lead Status: All" rel="All" href="#">All</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="filter-box clearfix <?php echo ($this->session->userdata('lFilter') && ($this->session->userdata('lFilterDue'))) ? 'filterActive' : ''; ?>" id="dueFilter">
                        <a class="trigger" href="#">Due Date: <?php
                            $foundDue = false;
                            foreach ($dueDates as $dueDate) {
                                if ($dueDate == $this->session->userdata('lFilterDue')) {
                                    $foundDue = true;
                                    echo $dueDate;
                                }
                            }
                            if (!$foundDue) {
                                echo 'All';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="Due Date: All" rel="" href="#">All</a></li>
                                <?php
                                foreach ($dueDates as $dueDate) {
                                    ?>
                                    <li><a title="Due Date: <?php echo $dueDate; ?>" rel="<?php echo $dueDate ?>" href="#"><?php echo $dueDate; ?></a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-box filter-loading" style="display: none;">
                        <img style="margin-top: 5px;" src="/static/loading.gif">
                    </div>

                </div>
            <?php } ?>
            <div class="clearfix">
                <?php if (!$filter && 0) { ?>
                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>
                <?php } ?>
                <?php if ($this->session->userdata('lFilter') || $filter) { ?>
                    <a class="filterButton" id="resetFilter" href="#">Reset</a>
                <?php } ?>
            </div>
        </div>

        <?php if ($filter) { ?>
            <div id="filterList">
                <p><strong>Showing Leads:</strong></p>
<!--                <p>--><?php //var_dump($filter) ?><!--</p>-->
                <ul>
                    <?php if (isset($filter['status'])) { ?>
                        <li>Status: <strong><?php echo ucfirst($filter['status']) ?></strong></li>
                    <?php } ?>
                    <?php if (isset($filter['user'])) { ?>
                        <li>User: <strong><?php echo (isset($accounts[$filter['user']])) ? $accounts[$filter['user']]->getFullName() : 'Unassigned' ?></strong></li>
                    <?php } ?>
                    <?php if (isset($filter['branch'])) { ?>
                        <li>Branch: <strong><?php echo (isset($branches[$filter['branch']])) ? $branches[$filter['branch']]->getBranchName() : 'Error' ?></strong></li>
                    <?php } ?>
                    <?php if (isset($filter['age'])) { ?>
                        <li>Age: <strong><?php echo ucfirst($filter['age']) ?> Active Leads</strong></li>
                    <?php } ?>
                    <?php if (isset($filter['range']) && !isset($filter['age'])) { ?>
                        <li>
                            Date Range: <strong>
                                <?php echo ucfirst($filter['range']) ?>
                                <?php if ($filter['range'] == 'custom') {
                                    ?>(<?php echo str_replace('-', '/', $filter['from']) ?> to <?php echo str_replace('-', '/', $filter['to']) ?>)<?php
                                } ?>
                            </strong>
                        </li>
                    <?php } ?>
                </ul>
                <!--<strong>Session [debug]</strong>
                <pre><?php /*var_dump($this->session->all_userdata()) */?></pre>-->
            </div>
        <?php } ?>
    </div>
    <input type="hidden" name="filterTypeValue" id="filterTypeValue" value="<?php echo $this->session->userdata('lFilterType'); ?>"/>
    <input type="hidden" name="filterUserValue" id="filterUserValue" value="<?php echo $this->session->userdata('lFilterUser'); ?>"/>
    <input type="hidden" id="filterBranchValue" name="filterBranchValue" value="<?php echo $this->session->userdata('lFilterBranch') ?>"/>
    <input type="hidden" id="filterSourceValue" name="filterSourceValue" value="<?php echo $this->session->userdata('lFilterSource') ?>"/>
    <input type="hidden" id="filterStatusValue" name="filterStatusValue" value="<?php echo $this->session->userdata('lFilterStatus') ?>"/>
    <input type="hidden" id="filterDueValue" name="filterDueValue" value="<?php echo $this->session->userdata('lFilterDue') ?>"/>

    <div class="filterOverlay"></div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">
    /*New Filter Code*/
    closeFilters(); //init with all filters closed to prevent the browser refresh cache

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

    function resetFilters() {
        $("#typeFilter").removeClass('filterActive');
        $("#typeFilter .trigger").text('Type: All');
        $("#userFilter").removeClass('filterActive');
        $("#userFilter .trigger").text('User: All');
        $("#branchFilter").removeClass('filterActive');
        $("#branchFilter .trigger").text('Branch: All');
        $("#statusFilter").removeClass('filterActive');
        $("#statusFilter .trigger").text('Status: Active');
        $("#sourceFilter").removeClass('filterActive');
        $("#sourceFilter .trigger").text('Status: Active');
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

    //Code for type change filter
    $("#typeFilter li a").click(function () {
        $("#typeFilter .trigger").text($(this).attr('title'));
        $("#filterTypeValue").val($(this).attr('rel'));
        if ($(this).attr('rel') == 'All') {
            $("#typeFilter").removeClass('filterActive');
        } else {
            $("#typeFilter").addClass('filterActive');
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

    // Source Filter
    $("#sourceFilter li a").click(function () {
        $("#sourceFilter .trigger").text($(this).attr('title'));
        $("#filterSourceValue").val($(this).attr('rel'));
        if ($(this).attr('rel') == 'All') {
            $("#sourceFilter").removeClass('filterActive');
        } else {
            $("#sourceFilter").addClass('filterActive');
        }
        closeFilters();
        return false;
    });

    // Status Filter
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

    // Due Filter
    $("#dueFilter li a").click(function () {
        $("#dueFilter .trigger").text($(this).attr('title'));
        $("#filterDueValue").val($(this).attr('rel'));
        if ($(this).attr('rel') == '') {
            $("#dueFilter").removeClass('filterActive');
        } else {
            $("#dueFilter").addClass('filterActive');
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

    function applyFilter() {
        $(".filter-loading").show();
        $("#reset-filter").show();
        var type = $("#filterTypeValue").val();
        var branch = $("#filterBranchValue").val();
        var user = $("#filterUserValue").val();
        var status = $("#filterStatusValue").val();
        var source = $("#filterSourceValue").val();
        var due = $("#filterDueValue").val();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/setLeadFilter') ?>',
            data: {
                lFilterType: type,
                lFilterUser: user,
                lFilterBranch: branch,
                lFilterStatus: status,
                lFilterDue: due,
                lFilterSource: source
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

    $("#resetFilter").click(function () {
        $("#reset-filter").show();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/resetLeadFilter') ?>',
            data: {},
            dataType: 'JSON',
            success: function () {
                setTimeout(function () {
                    //disable reload for debug functionality
//                    document.location.reload();
                    document.location.href = '<?php echo site_url('leads') ?>';
                }, 300);
            }
        });
        return false;
    });


</script>