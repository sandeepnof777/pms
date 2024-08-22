<div id="stats-year" class="statsRange">

<div class="statBoxLarge totalStat">

    <div class="statHeading">
        Total Bid
    </div>

    <div class="statValue">
        <p>$<?php echo readableValue($yearProposalPrice); ?></p>
    </div>
</div>

<div class="statBoxSmallContainer">


    <div class="statBox">
        <div class="statHeading">
            Completed
        </div>
        <div class="statValues">

            <div class="statValue">
                $<?php echo readableValue($yearCompletedPrice); ?>
            </div>

            <div class="statPct">
                <?php echo $yearCompletedPct; ?>%
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
                $<?php echo readableValue($yearWonPrice); ?>
            </div>

            <div class="statPct">
                <?php echo $yearWonPct; ?>%
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
                $<?php echo readableValue($yearLostPrice); ?>
            </div>

            <div class="statPct">
                <?php echo $yearLostPct; ?>%
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
                $<?php echo readableValue($yearOpenPrice); ?>
            </div>

            <div class="statPct">
                <span><?php echo $yearOpenPct; ?>%</span>
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
        <p>$<?php echo readableValue($yearMagicNumber); ?></p>
    </div>
</div>

</div>