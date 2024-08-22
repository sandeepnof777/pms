<div id="stats-quarter" class="statsRange">


    <div class="statBoxLarge totalStat">

        <div class="statHeading">
            Total Bid
        </div>

        <div class="statValue">
            <p>$<?php echo readableValue($quarterProposalPrice); ?></p>
        </div>
    </div>

    <div class="statBoxSmallContainer">


        <div class="statBox">
            <div class="statHeading">
                Completed
            </div>
            <div class="statValues">

                <div class="statValue">
                    $<?php echo readableValue($quarterCompletedPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $quarterCompletedPct; ?>%
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
                    $<?php echo readableValue($quarterWonPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $quarterWonPct; ?>%
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
                    $<?php echo readableValue($quarterLostPrice); ?>
                </div>

                <div class="statPct">
                    <?php echo $quarterLostPct; ?>%
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
                    $<?php echo readableValue($quarterOpenPrice); ?>
                </div>

                <div class="statPct">
                    <span><?php echo $quarterOpenPct; ?>%</span>
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
            <p>$<?php echo readableValue($quarterMagicNumber); ?></p>
        </div>
    </div>

</div>