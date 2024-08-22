<div>
    <form action="<?= site_url('account/sales_targets') ?>" method="POST">
        <label>From: </label>
        <input type="text" name="from" value="<?= $from ?>">
        <label>To: </label>
        <input type="text" name="to" value="<?= $to ?>">
        <input type="submit" value="Set" class="submit">
    </form>
</div>
<table class="boxed-table dataTables" width="100%" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        <td>User</td>
        <td>Sales Target</td>
        <td>$ Bid / Day</td>
        <td>Win Rate</td>
        <td>Avg Bids/Day</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($stats as $stat): ?>
        <tr>
            <td><?= $stat['user'] ?></td>
            <td>$<?= ($stat['total_bid']) ?></td>
            <td>$<?= ($stat['avg_bid_day']) ?></td>
            <td><?= round($stat['win_rate'], 2) ?>%</td>
            <td><?= round($stat['avg_bids'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3>Config Value</h3>
<pre><?php print_r($config) ?></pre>
<h3>Stats RAW</h3>
<pre><?php print_r($stats) ?></pre>