<div id="headline-stats" class="statTypeContainer">


    <div class="statsRow">

        <div class="statBox proposalCount">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/all'); ?>"
                   href="<?php echo site_url('proposals/status/all/'); ?>">
                    Total Proposals</a>
            </div>
            <div class="singleValue">

                <span id="proposalCount"></span>
            </div>
        </div>


        <div class="statBox totalStat">

            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/all'); ?>"
                   href="<?php echo site_url('proposals/status/all/'); ?>">
                    Total Bid</a>
            </div>

            <div class="singleValue">
                $<span id="totalValue"></span>
            </div>
        </div>

        <div class="statBox avgStat">

            <div class="statHeading">
                    Avg. Bid
            </div>

            <div class="singleValue">
                $<span id="avgValue"></span>
            </div>
        </div>


        <?php
        //$rolloverStatus = $account->getCompany()->getDefaultStatus(\models\Status::ROLLOVER);
        /* @var $rolloverStatus \models\Status */
        ?>

        <div class="statBox rollover">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/rollover'); ?>"
                   href="<?php echo site_url('proposals/status/rollover/'); ?>">
                    Rollover</a>
            </div>

            <div class="singleValue">
                $<span id="rolloverValue"></span>
            </div>

        </div>

    </div>


    <div class="statsRow">


        <?php
        $openStatus = $account->getCompany()->getDefaultStatus(\models\Status::OPEN);
        /* @var $wonStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $openStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $openStatus->getStatusId(). '/' . $openStatus->getText()); ?>">
                    <?php echo $openStatus->getText(); ?></a>
            </div>
            <div class="singleValue">
                $<span id="openValue"></span>
            </div>
        </div>

        <?php
        $wonStatus = $account->getCompany()->getDefaultStatus(\models\Status::WON);
        /* @var $wonStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/won'); ?>"
                   href="<?php echo site_url('proposals/status/' . $wonStatus->getStatusId(). '/' . $wonStatus->getText()); ?>">
                    <?php echo $wonStatus->getText(); ?></a>
            </div>
            <div class="singleValue">
                $<span id="wonValue"></span>
            </div>
        </div>


        <?php
        $compStatus = $account->getCompany()->getDefaultStatus(\models\Status::COMPLETED);
        /* @var $compStatus \models\Status */
        ?>

        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $compStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $compStatus->getStatusId(). '/' . $compStatus->getText()); ?>">
                    <?php echo $compStatus->getText(); ?></a>
            </div>

            <div class="singleValue">
                $<span id="completedValue"></span>
            </div>

        </div>

        <?php
        $lostStatus = $account->getCompany()->getDefaultStatus(\models\Status::LOST);
        /* @var $lostStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $lostStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $lostStatus->getStatusId(). '/' . $lostStatus->getText()); ?>">
                    <?php echo $lostStatus->getText(); ?></a>
            </div>
            <div class="singleValue">
                $<span id="lostValue"></span>
            </div>
        </div>

    </div>
</div>

<div class="clearfix"></div>