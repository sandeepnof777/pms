<div id="stats-week" class="statsRange">


    <div class="statBoxLarge totalStat">

        <div class="statHeading">
            Total Bid
        </div>

        <div class="statValue">
            <p>$<?php echo readableValue($weekProposalPrice); ?></p>
        </div>
    </div>

    <div class="statBoxSmallContainer">


        <div class="statBox">
            <div class="statHeading">
                Completed
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($weekCompletedPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $weekCompletedPct; ?>%
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
                    $<?php echo readableValue($weekWonPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $weekWonPct; ?>%
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
                    $<?php echo readableValue($weekLostPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $weekLostPct; ?>%
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
                    $<?php echo readableValue($weekOpenPrice); ?>
                </div>

                <div class="statPct">
                    <span><?php echo $weekOpenPct; ?>%</span>
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
            <p>$<?php echo readableValue($weekMagicNumber); ?></p>
        </div>
    </div>

</div>