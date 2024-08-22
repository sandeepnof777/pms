

<div class="statBoxLarge totalStat">

    <div class="statHeading">
        Total Bid
    </div>

    <div class="statValue">
        <p>$<?php echo readableValue($calendarMonthProposalPrice); ?></p>
    </div>
</div>

<div class="statBoxSmallContainer">


    <div class="statBox">
        <div class="statHeading">
            Completed
        </div>
        <div class="statValues">

            <div class="statValue">
                $<?php echo readableValue($calendarMonthProposalsCompletedValue); ?>
            </div>

            <div class="statPct">
                <?php echo $calendarMonthProposalsCompletedPct; ?>%
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
                $<?php echo readableValue($calendarMonthProposalsWonValue); ?>
            </div>

            <div class="statPct">
                <?php echo $calendarMonthProposalsWonPct; ?>%
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
                $<?php echo readableValue($calendarMonthProposalsLostValue); ?>
            </div>

            <div class="statPct">
                <?php echo $calendarMonthProposalsLostPct; ?>%
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
                $<?php echo readableValue($calendarMonthProposalsOpenValue); ?>
            </div>

            <div class="statPct">
                <span><?php echo $calendarMonthProposalsOpenPct; ?>%</span>
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
        <p>MN</p>
    </div>
</div>
