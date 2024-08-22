<div id="headline-stats-sf" class="statTypeContainer" >


    <div class="statsRow">

        <div class="statBox magicNumber">

            <div class="statHeading statHeadingSF">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/magicnumber'); ?>"
                   href="<?php echo site_url('proposals/status/magicnumber/'); ?>">
                    Magic Number</a>
            </div>

            <div class="singleValue">
                $<span id="magicNumberValue"></span>
            </div>
        </div>


        <?php
        $compStatus = $account->getCompany()->getDefaultStatus(\models\Status::COMPLETED);
        /* @var $compStatus \models\Status */
        ?>

        <div class="statBox">
            <div class="statHeading statHeadingDark">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $compStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $compStatus->getStatusId(). '/' . $compStatus->getText()); ?>/sf">
                    <?php echo $compStatus->getText(); ?></a>
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<span id="completedValueSF"></span>
                </div>

                <div class="statPct">
                    <span id="completedPct"></span>%
                </div>

            </div>
        </div>

        <?php
        $openStatus = $account->getCompany()->getDefaultStatus(\models\Status::OPEN);
        /* @var $wonStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading statHeadingDark">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $openStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $openStatus->getStatusId(). '/' . $openStatus->getText()); ?>/sf">
                    <?php echo $openStatus->getText(); ?></a>
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<span id="openValueSF"></span>
                </div>

                <div class="statPct">
                    <span id="openPct"></span>%
                </div>
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
                $<span id="rolloverValueSF"></span>
            </div>

        </div>

    </div>


    <div class="statsRow">

        <div class="statBox totalStat">

            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/all'); ?>"
                   href="<?php echo site_url('proposals/status/all/'); ?>">
                    Total Bid</a>
            </div>

            <div class="singleValue">
                $<span id="totalValueSF"></span>
            </div>
        </div>

        <?php
        $wonStatus = $account->getCompany()->getDefaultStatus(\models\Status::WON);
        /* @var $wonStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading statHeadingDark">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $wonStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $wonStatus->getStatusId(). '/' . $wonStatus->getText()); ?>/sf">
                    <?php echo $wonStatus->getText(); ?></a>
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<span id="wonValueSF"></span>
                </div>

                <div class="statPct">
                    <span id="wonPct"></span>%
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <?php
        $lostStatus = $account->getCompany()->getDefaultStatus(\models\Status::LOST);
        /* @var $wonStatus \models\Status */
        ?>
        <div class="statBox">
            <div class="statHeading statHeadingDark">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/' . $lostStatus->getStatusId()); ?>"
                   href="<?php echo site_url('proposals/status/' . $lostStatus->getStatusId(). '/' . $lostStatus->getText()); ?>/sf">
                    <?php echo $lostStatus->getText(); ?></a>
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<span id="lostValueSF"></span>
                </div>

                <div class="statPct">
                    <span id="lostPct"></span>%
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="statBox proposalCount">
            <div class="statHeading">
                <a class="statDrilldown"
                   data-base-link="<?php echo site_url('proposals/status/all'); ?>"
                   href="<?php echo site_url('proposals/status/all/'); ?>">
                    Total Proposals</a>
            </div>
            <div class="singleValue">

                <span id="proposalCountSF"></span>

            </div>
        </div>

    </div>

    <div class="clearfix"></div>




</div>