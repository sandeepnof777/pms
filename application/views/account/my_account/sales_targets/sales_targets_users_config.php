<div id="salesTargetUsersGroupActions" style="padding: 10px; display: none">
    <button class="btn" id="setToDefault">Set To Company Default</button>
</div>

<input type="hidden" id="defaultWinRate" value="<?= $config['win_rate'] ?>" />
<input type="hidden" id="defaultSalesTarget" value="<?= $config['sales_target'] ?>" />
<input type="hidden" id="defaultWeeks" value="<?= $config['weeks_per_year'] ?>" />

<table class="boxed-table" width="100%" cellspacing="0" cellpadding="0" id="salesTargetsUserConfig">
    <thead>
    <tr>
        <td><input type="checkbox" id="checkAll"></td>
        <td style="text-align: left">User</td>
        <td style="text-align: left;">Start Date <a class="tiptipwide" title="Whne the user signed up. Can be edited for statistical purposes"><i class="fa fa-fw fa-info-circle"></i></a></td>
        <td style="text-align: left;">Win Rate <a class="tiptipwide" title="The % of work that each user is expected to win"><i class="fa fa-fw fa-info-circle"></i></a></td>
        <td style="text-align: left;">Sales Target <a class="tiptipwide" title="The yearly revenue of each salesperson set by company."><i class="fa fa-fw fa-info-circle"></i></a></td>
        <td style="text-align: left;">Weeks / Year <a class="tiptipwide" title="This is the available weeks in a year to provide proposals on average"><i class="fa fa-fw fa-info-circle"></i></a></td>
        <td style="text-align: left;">Must Bid <a class="tiptipleftwide" title="The amount of work based on your 'Win Rate' percentage you must bid to reach your Sales Target"><i class="fa fa-fw fa-info-circle"></i></a></td>
        <td style="text-align: left;">$ Bid / Wk <a class="tiptipleftwide" title="How much the user should bid per week to reach the sale target based on the Win Rate %"><i class="fa fa-fw fa-info-circle"></i></a></td>
    </tr>
    </thead>
    <tbody>
        <tr class="companyConfig" style="background-color: #c5c5c5">
            <td></td>
            <td><strong>Company Default</strong></td>
            <td style="text-align: center; font-weight: bold"></td>
            <td style="text-align: center; font-weight: bold"><?= $config['win_rate'] ?>%</td>
            <td style="text-align: center; font-weight: bold">$<?= number_format(round($config['sales_target'])) ?></td>
            <td style="text-align: center; font-weight: bold"><?= $config['weeks_per_year'] ?></td>
            <td id="">$<?= number_format(round($config['bid_target'])); ?></td>
            <td id="">$<?= number_format(round($config['bid_per_day'] * 5)); ?></td>
        </tr>

    <?php foreach ($accounts as $account): ?>
        <?php /** @var $account \models\Accounts */ ?>
        <tr class="userConfig" id="userConfig_<?= $account->getAccountId() ?>" data-id="<?= $account->getAccountId() ?>">
            <td><input type="checkbox" value="<?php echo $account->getAccountId() ?>" class="accountCheck" /></td>
            <td><strong><?= $account->getFullName() ?></strong></td>
            <td><input type="text" class="dateInput" style="width: 50px;" id="startDate_<?= $account->getAccountId() ?>" data-id="<?= $account->getAccountId() ?>" data-key="start_date" value="<?= date('m/d/y', $accountStats[$account->getAccountId()]['start_date']) ?>"></td>
            <td><input type="text" class="percentInput" style="width: 50px;" id="winRate_<?= $account->getAccountId() ?>" data-id="<?= $account->getAccountId() ?>" data-key="win_rate" value="<?= $accountStats[$account->getAccountId()]['win_rate'] ?>"></td>
            <td><input type="text" class="salesTarget" style="width: 80px;" id="salesTarget_<?= $account->getAccountId() ?>" data-id="<?= $account->getAccountId() ?>" data-key="sales_target" value="<?= $accountStats[$account->getAccountId()]['sales_target'] ?>"></td>
            <td><input type="text" style="width: 50px;" id="weeksPerYear_<?= $account->getAccountId() ?>" data-id="<?= $account->getAccountId() ?>" data-key="weeks_per_year" value="<?= $accountStats[$account->getAccountId()]['weeks_per_year'] ?>"></td>
            <td id="bidTarget_<?= $account->getAccountId() ?>"></td>
            <td id="bidPerDay_<?= $account->getAccountId() ?>"></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="5">
            <button id="saveConfig" class="btn btn-large blue ui-button saveConfig" tabindex="200" style="margin-right: 5px;"><i class="fa fa-fw fa-save"></i> Save User Targets</button>
        </td>
    </tr>
    </tbody>
</table>