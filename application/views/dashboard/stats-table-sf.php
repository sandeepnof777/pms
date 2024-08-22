<div id="statsTableLoadingSF" style="text-align: center; display: none">
    <p>Loading Table</p>
    <p><img src="/static/loading_animation.gif" /></p>
</div>


<div id="statsTableSF" class="statTypeContainer" style="display: none">

    <table id="userStatsTableSF" style="width: 100%">
        <thead>
        <tr>
            <th>User</th>
            <th>Magic Number Amt</th>
            <th>Magic<br />Number</th>
            <th>Total Bid Amt</th>
            <th>Total Bid</th>
            <th><?php echo $completeStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $completeStatus->getText(); ?> $</th>
            <th><?php echo $completeStatus->getText(); ?> % Num</th>
            <th><?php echo $completeStatus->getText(); ?> %</th>
            <th><?php echo $openStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $openStatus->getText(); ?> $</th>
            <th><?php echo $openStatus->getText(); ?> % Num</th>
            <th><?php echo $openStatus->getText(); ?> %</th>
            <th><?php echo $wonStatus->getText(); ?> Bid Amt</th>
            <th><?php echo $wonStatus->getText(); ?> $</th>
            <th><?php echo $wonStatus->getText(); ?> % Num</th>
            <th><?php echo $wonStatus->getText(); ?> %</th>
            <th>Proposals Amt</th>
            <th>Proposals</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>