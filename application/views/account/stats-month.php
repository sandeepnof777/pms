<div id="stats-month" class="statsRange">


    <div class="statBoxLarge totalStat">

        <div class="statHeading">
            Total Bid
        </div>

        <div class="statValue">
            <p>$<?php echo readableValue($monthProposalPrice); ?></p>
        </div>
    </div>

    <div class="statBoxSmallContainer">


        <div class="statBox">
            <div class="statHeading">
                Completed
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($monthCompletedPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $monthCompletedPct; ?>%
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="statBox">
            <div class="statHeading">
                Won
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($monthWonPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $monthWonPct; ?>%
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                Lost
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($monthLostPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $monthLostPct; ?>%
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                Open
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($monthOpenPrice); ?>
                </div>

                <div class="statPct">
                    <span><?php echo $monthOpenPct; ?>%</span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


    </div>

    <div class="statBoxLarge magicNumber">

        <div class="statHeading">
            Magic Number
        </div>

        <div class="statValue">
            <p>$<?php echo readableValue($monthMagicNumber); ?></p>
        </div>
    </div>

</div>