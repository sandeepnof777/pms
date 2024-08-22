<div id="newFilter">
    <div class="clearfix">
        <div class="left" style="width: 49px;">
            <label class="filterLabel">Filter</label>
        </div>
        <div class="left" style="width: 900px;">


            <div class="clearfix" style="margin-bottom: 10px;">

                <div class="filter-box clearfix <?php echo ($this->session->userdata('cFilterClientAccount') && ($this->session->userdata('cFilterClientAccount') != 'All')) ? 'filterActive' : ''; ?>" id="clientAccountFilter">
                    <a class="trigger" href="#">Account: <?php
                        $found = false;
                        if ($this->session->userdata('cFilterClientAccount') && ($this->session->userdata('cFilterClientAccount') != 'All')) {
                            foreach ($clientAccounts as $clientAccount) {
                                if ($clientAccount->getId() == $this->session->userdata('cFilterClientAccount')) {
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
                                <li class="clientAccount clientAccount_<?php echo $clientAccount->getId() ?>"><a title="Account: <?php echo $clientAccount->getName() ?>" rel="<?php echo $clientAccount->getId() ?>" href="#"><?php echo $clientAccount->getName() ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>

                </div>


                <?php if ($account->getUserClass() >= 3) { ?>
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('cFilter') && ($this->session->userdata('cFilterBranch') || ($this->session->userdata('cFilterBranch') == '0'))) ? 'filterActive' : ''; ?>" id="branchFilter">
                        <a class="trigger" href="#">Branch: <?php
                            $foundBranch = false;
                            foreach ($branches as $branchId => $branch) {
                                if ($branchId == $this->session->userdata('cFilterBranch')) {
                                    $foundBranch = true;
                                    echo $branch->getBranchName();
                                }
                            }
                            if (!$foundBranch) {
                                if ($this->session->userdata('cFilter') && (($this->session->userdata('cFilterBranch') == 'Main') || ($this->session->userdata('cFilterBranch') == '0'))) {
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
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('cFilterUser') && ($this->session->userdata('cFilterUser') != 'All')) ? 'filterActive' : ''; ?>" id="userFilter">
                        <a class="trigger" href="#">User: <?php
                            $found = false;
                            if ($this->session->userdata('cFilterUser') && ($this->session->userdata('cFilterUser') != 'All')) {
                                foreach ($accounts as $acc) {
                                    if ($acc->getAccountId() == $this->session->userdata('cFilterUser')) {
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

                <div class="filter-box filter-loading" style="display: none;">
                    <img style="margin-top: 5px;" src="/static/loading.gif">
                </div>
            </div>

            <div class="clearfix">
                <!--                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>-->
                <?php if ($this->session->userdata('cFilter')) { ?>
                    <a class="filterButton" id="resetFilter" href="#">Reset</a>
                <?php } ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="filterUserValue" id="filterUserValue" value="<?php echo $this->session->userdata('cFilterUser'); ?>"/>
    <input type="hidden" id="filterBranchValue" name="filterBranchValue" value="<?php echo $this->session->userdata('cFilterBranch') ?>"/>
    <input type="hidden" id="filterClientAccountValue" name="filterClientAccountValue" value="<?php echo $this->session->userdata('cFilterClientAccount') ?>"/>

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
        $("#userFilter").removeClass('filterActive');
        $("#userFilter .trigger").text('User: All');
        $("#branchFilter").removeClass('filterActive');
        $("#branchFilter .trigger").text('Branch: All');
        $("#clientAccountFilter").removeClass('filterActive');
        $("#clientAccountFilter .trigger").text('Account: All');

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

    //Code for client account change filter
    $("#clientAccountFilter li a").click(function () {
        $("#clientAccountFilter .trigger").text($(this).attr('title'));
        $("#filterClientAccountValue").val($(this).attr('rel'));
        if ($(this).attr('rel') == 'All') {
            $("#clientAccountFilter").removeClass('filterActive');
            $("#filterClientAccountValue").val('');
        } else {
            $("#clientAccountFilter").addClass('filterActive');
        }
        updateBranchUsers();
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

    function applyFilter() {
        $(".filter-loading").show();
        $("#reset-filter").show();
        var branch = $("#filterBranchValue").val();
        var user = $("#filterUserValue").val();
        var account = $("#filterClientAccountValue").val();

        $.ajax({
            type: "POST",
            url: '<?php echo site_url('ajax/setClientFilter') ?>',
            data: {
                cFilterUser: user,
                cFilterBranch: branch,
                cFilterClientAccount: account,
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
            url: '<?php echo site_url('ajax/resetClientFilter') ?>',
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


</script>