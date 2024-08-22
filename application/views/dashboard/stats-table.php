<div id="statsTableLoading" style="text-align: center; display: none">
    <p>Loading Table</p>
    <p><img src="/static/loading_animation.gif" /></p>
</div>


<div id="statsTable" class="statTypeContainer" style="display: none">

    <table id="userStatsTable" style="width: 100%">
        <thead>
        <tr>
            <th>User</th>
            <th>Proposals Amt</th>
            <th>Proposals</th>
            <th>Total Bid Amt</th>
            <th>Total Bid</th>
            <th>Avg Bid Amt</th>
            <th>Average Bid</th>
            <th><?php echo $completeStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $completeStatus->getText(); ?> $</th>
            <th><?php echo $openStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $openStatus->getText(); ?> $</th>
            <th><?php echo $wonStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $wonStatus->getText(); ?> $</th>
            <th><?php echo $lostStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $lostStatus->getText(); ?> $</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>