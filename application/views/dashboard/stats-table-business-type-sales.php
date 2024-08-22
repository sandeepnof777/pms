<div class="box-content">

    <div style="padding:0px 0px 15px 0px;color:#000">
        <a href="javascript:void(0);" data-val="table" class="btn update-button business_table_breakdown active_section" style="font-size:12px;width:100px" ><i class="fa fa-fw fa-table"></i> Table</a> 
        <a href="javascript:void(0);" data-val="breakdown" class="btn business_table_breakdown" style="font-size:12px;width:100px"><i class="fa fa-fw fa-pie-chart"></i> Breakdown</a>
    </div>

    <div id="statsTableBusinessSales" >
        <table id="salesBusinessStatsTable" class="dataTables-business-types display" style="display:none">
                                            <thead>
                                            <tr>
                                                <th>Business Type</th>
                                                <th>Proposals</th>
                                                <th>Total Bid</th>
                                                <th>Open </th>
                                                <th><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that are not Open and have not been Won.<br/><br/>This value excludes duplicate proposals">Other</a></th>
                                                <th><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that have a 'Won' status. This includes Completed, Invoiced etc.<br/><br/>This value excludes dupliate proposals">Won</a></th>
                                                <th><a href="javascript:void(0);" class="tiptip" title="Percentage of Total Amount Bid that was Won.<br/><br/>This value excludes duplicate proposals<br/><br/>Note: This does not include sales that were bid outside of the selected time period">W/R</a></th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
    </div>
    <div class="breakdown_box hide" style="overflow: hidden;" >
           
        <div style="width: 70%;float:left" id="table_div">
            <table id="business_type_breakdown_table" class="display " style="border-collapse: collapse!important;width: 100%; float: left">
                <thead>
                    <tr><th>Business Type</th><th>Bid $</th><th>Bid %</th><th>Bid</th><th>Win $</th><th>Win %</th><th>Win</th><th>+/-</th></tr>
                </thead>
            </table>
            
        </div>
        <div style="width: 30%;float:left">
            <div style="margin-left: 15px;" id="userBusinessTypePie"></div>
            
        </div>
    </div>
</div>