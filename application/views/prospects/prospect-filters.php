<div id="newFilter">
    <div class="clearfix">
        <div class="left" style="width: 49px;">
            <label class="filterLabel">Filter</label>
        </div>
        <div class="left" style="width: 900px;">


            <div class="clearfix" style="margin-bottom: 10px;">

                <?php if ($account->getUserClass() >= 3) { ?>
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('ptFilter') && ($this->session->userdata('ptFilterBranch') || ($this->session->userdata('ptFilterBranch') == '0'))) ? 'filterActive' : ''; ?>" id="branchFilter">
                        <a class="trigger" href="#">Branch: <?php
                            $foundBranch = false;
                            foreach ($branches as $branchId => $branch) {
                                if ($branchId == $this->session->userdata('ptFilterBranch')) {
                                    $foundBranch = true;
                                    echo $branch->getBranchName();
                                }
                            }
                            if (!$foundBranch) {
                                if ($this->session->userdata('ptFilter') && (($this->session->userdata('ptFilterBranch') == 'Main') || ($this->session->userdata('ptFilterBranch') == '0'))) {
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
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('ptFilterUser') && ($this->session->userdata('ptFilterUser') != 'All') || $this->session->userdata('ptFilterUser') === 'u') ? 'filterActive' : ''; ?>" id="userFilter">
                        <a class="trigger" href="#">User: <?php
                            $found = false;

                            if ($this->session->userdata('ptFilterUser') === 'u') {
                                $found = true;
                                echo 'Unassigned';
                            }
                            if ($this->session->userdata('ptFilterUser') && ($this->session->userdata('ptFilterUser') != 'All')) {
                                foreach ($accounts as $acc) {
                                    if ($acc->getAccountId() == $this->session->userdata('ptFilterUser')) {
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


                <div class="filter-box clearfix <?php echo ($this->session->userdata('ptFilter') && ($this->session->userdata('ptFilterRating'))) ? 'filterActive' : ''; ?>" id="ratingFilter">
                    <a class="trigger" href="#">Rating: <?php
                        $foundRating = false;
                        foreach ($prospectRatings as $prospectRating) {
                            if ($prospectRating == $this->session->userdata('ptFilterRating')) {
                                $foundRating = true;
                                echo $prospectRating;
                            }
                        }
                        if (!$foundRating) {
                            echo 'All';
                        }
                        ?>
                    </a>

                    <div class="filter-code">
                        <ul class="filter-list">
                            <li><a title="Rating" rel="" href="#">All</a></li>
                            <?php
                            foreach ($prospectRatings as $prospectRating) {
                                ?>
                                <li><a title="Rating: <?php echo $prospectRating; ?>" rel="<?php echo $prospectRating ?>" href="#"><?php echo $prospectRating; ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <div class="filter-box clearfix <?php echo ($this->session->userdata('ptFilter') && ($this->session->userdata('ptFilterSource') && ($this->session->userdata('ptFilterSource') != 'All'))) ? 'filterActive' : ''; ?>" id="sourceFilter">
                    <a class="trigger" href="#">Source: <?php
                        $foundRating = false;
                        foreach ($prospectSources as $prospectSource) {
                            if ($prospectSource->getId() == $this->session->userdata('ptFilterSource')) {
                                $foundRating = true;
                                echo $prospectSource->getName();
                            }
                        }
                        if (!$foundRating) {
                            echo 'All';
                        }
                        ?>
                    </a>

                    <div class="filter-code">
                        <ul class="filter-list">
                            <li><a title="Source" rel="All" href="#">All</a></li>
                            <?php
                            foreach ($prospectSources as $prospectSource) {
                                ?>
                                <li><a title="Source: <?php echo $prospectSource->getName(); ?>" rel="<?php echo $prospectSource->getId() ?>" href="#"><?php echo $prospectSource->getName(); ?></a></li>
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

            <div class="clearfix">
                <!--                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>-->
                <?php if ($this->session->userdata('ptFilter')) { ?>
                    <a class="filterButton" id="resetFilter" href="#">Reset Filter</a>
                <?php } ?>
            </div>

        </div>
    </div>
    <input autocomplete="off" type="hidden" name="filterUserValue" id="filterUserValue" value="<?php echo $this->session->userdata('ptFilterUser'); ?>"/>
    <input autocomplete="off" type="hidden" id="filterBranchValue" name="filterBranchValue" value="<?php echo $this->session->userdata('ptFilterBranch'); ?>"/>
    <input autocomplete="off" type="hidden" id="filterStatusValue" name="filterStatusValue" value="<?php echo $this->session->userdata('ptFilterStatus'); ?>"/>
    <input autocomplete="off" type="hidden" id="filterRatingValue" name="filterRatingValue" value="<?php echo $this->session->userdata('ptFilterRating'); ?>"/>
    <input autocomplete="off" type="hidden" id="filterSourceValue" name="filterSourceValue" value="<?php echo $this->session->userdata('ptFilterSource'); ?>"/>

    <div class="filterOverlay"></div>
</div>
<div class="clearfix"></div>

<script type="text/javascript">

    $(document).ready(function() {



    });

</script>