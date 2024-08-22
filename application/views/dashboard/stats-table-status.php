
<div id="statsTableSalesTargets" >
    <div id="StatusStatsTableContainer" style="display: none;">
        <table id="StatusStatsTable" >
            <thead>
                <tr>
                    <th width="150px">User</th>
                    <?php
                        foreach($statusObject as $status){
                            echo '<th>'.$status['status_name'].'</th>';
                        }
                    ?>
                    <th >Email Off</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>