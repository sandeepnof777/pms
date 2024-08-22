<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
        <div class="widthfix">
        
    
        <div class="content-box light">

<div class="box-header clearfix">
   


    <div class="statControl" style="text-align: center; font-style: normal;">

        <!-- <div id="statControls">

            <span id="statsLoader">
                <img src="/static/loading.gif"/>
            </span>

            Time Period:
            <select id="statRange" style="width: 100px; !important;">
                <option data-range="year">Year</option>
                <option data-range="quarter">Quarter</option>
                <option data-range="month">Month</option>
                <option data-range="week">Week</option>
                <option data-range="day">Day</option>
                <option data-range="prevYear">Previous Year</option>
                <option data-range="custom">Custom</option>
            </select>

        </div> -->
        <div class="filterColumnRowContent">
                    <p style="float:left;">
                                <label>Preset:</label>
                                <select id="createdPreset">
                                    <option value="">Choose Preset</option>
                                    <option value="custom">Custom</option>
                                    <option value="yesterday">Yesterday</option>
                                    <option value="last7days">Last 7 Days</option>
                                    <option value="monthToDate">Month To Date</option>
                                    <option value="previousMonth">Previous Month</option>
                                    <option value="yearToDate">Year To Date</option>
                                    <option value="previousYear">Previous Year</option>
                                </select>
                            </p>
                            <p style="float:left;">
                                <label>From:</label>
                                <input type="text" id="pCreatedFrom" class="text" style="margin-left: 11px;"
                                       value="<?php echo ($this->session->userdata('pECreatedFrom')) ? date('m/d/y', strtotime($this->session->userdata('pECreatedFrom'))) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pCreatedTo"
                                       value="<?php echo ($this->session->userdata('pECreatedTo')) ? date('m/d/y', strtotime($this->session->userdata('pECreatedTo'))) : '' ?>">
                                <a class="filterDateClear" id="resetCreatedDate">Reset</a>
                            </p>
                            
                        </div>
       

        <div class="help tiptip center" style="position: absolute; right: 10px; top:9px; z-index: 200;" title="Help"><?php echo help_box(92, true) ?></div>

    </div>

</div>


<div class="clearfix"></div>

</div>

    

    
<div class="materialize">

<div class="row">
    <div class="col s8">
        <div class="col s6">
            <ul class="collection">
                <li class="collection-item">
                    <a href="#">
                    <span class="badge new estimates_started"><?= $estimates_started;?></span>
                    Estimates Created
                    </a>
                </li>
            </ul>
        </div>
        <div class="col s6">
            <ul class="collection">
                <li class="collection-item">
                    <a href="#">
                    <span class="badge new estimates_completed"><?=number_format((float)$estimates_completed, 2, '.', '') ;?>%</span>
                    Completed %
                    </a>
                </li>
            </ul>
        </div>
        <div class="col s6">
            <ul class="collection">
                <li class="collection-item">
                    <a href="#">
                    <span class="badge new estimated_total"><?= "$".number_format($estimated_total);?></span>
                    Total Estimate Value
                    </a>
                </li>
            </ul>
        </div>

        <div class="col s6">
            <ul class="collection">
                <li class="collection-item">
                    <a href="#">
                    <span class="badge new estimated_average"><?= "$".number_format($estimated_average);?></span>
                    Average Estimate Price
                    </a>
                </li>
            </ul>
        </div>
        <div class="col s6">
            <ul class="collection">
                <li class="collection-item">
                    <a href="#">
                    <span class="badge new company_count"><?= $company_count;?></span>
                    Companies
                    </a>
                </li>
            </ul>
        </div>

        
    </div>

    <div class="col s4">
        <div id="piechart" style=" margin: 0px auto;display: table;"></div>
    </div>
</div>


</div>
    
    </div>
</div>
<?php $this->load->view('global/footer'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
 $("#pCreatedFrom").datepicker();
    $("#pCreatedTo").datepicker();
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(get_piechart_data);

// Draw the chart and set the chart values
function drawChart(chart_data) {
//   var data = google.visualization.arrayToDataTable([
//   ['Task', 'Hours per Day'],
//   ['Work', 8],
//   ['Eat', 2],
//   ['TV', 4],
//   ['Gym', 2],
//   ['Sleep', 8]
// ]);
var data = google.visualization.arrayToDataTable(chart_data);
  // Optional; add a title and set the width and height of the chart
  
  var options = {
                    width: 200,
                    height: 200,
                    chartArea: {
                        width: '100%',
                        height: '90%'
                    },
                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.3,
                    legend: {
                        position: 'none',
                        maxLines: 2,
                        alignment: 'left'
                    },
                    pieSliceText: 'label',
                    animation: {
                        startup: true
                    }
                };
  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}

function get_piechart_data(){
    $.ajax({		
        url: '/ajax/getAdminPieChartData/',		
        type: 'get',			
        success: function( data){
            var test_array =[['title','List'] ];	
            data = JSON.parse(data);
            if(data.length>0){
                $('#piechart').show();
                for($i=0;$i<data.length;$i++){
                
                    test_array.push([data[$i]['name'],parseFloat(data[$i]['value']) ]);
                }
           
                drawChart(test_array);
            }else{
                $('#piechart').hide();
            }
            
        }   
           
    });
}

$("#createdPreset").change(function () {

var selectVal = $(this).val();

if (selectVal) {

    if (selectVal == 'custom') {
        $("#pCreatedFrom").focus();
    }
    else {
        var preset = datePreset(selectVal);
        $("#pCreatedFrom").val(preset.startDate);
        $("#pCreatedTo").val(preset.endDate);
        applyFilter();
    }
}
});

function datePreset(preset) {

var startDate;
var endDate;

switch (preset) {

    case 'today':
        startDate = moment();
        endDate = moment();
        break;

    case 'yesterday':
        startDate = moment().subtract(1, 'days');
        endDate = moment().subtract(1, 'days');
        break;

    case 'last7days':
        startDate = moment().subtract(6, 'days');
        endDate = moment();
        break;

    case 'monthToDate':
        startDate = moment().startOf('month');
        endDate = moment();
        break;

    case 'previousMonth':
        startDate = moment().subtract(1, 'month').startOf('month');
        endDate = moment().subtract(1, 'month').endOf('month');
        break;

    case 'yearToDate':
        startDate = moment().startOf('year');
        endDate = moment();
        break;

    case 'previousYear':
        startDate = moment().subtract(1, 'year').startOf('year');
        endDate = moment().subtract(1, 'year').endOf('year');
        break;
}

var presetDate = {
    startDate: startDate.format('MM/DD/YYYY'),
    endDate: endDate.format('MM/DD/YYYY')
};

return presetDate;

}

$("#resetCreatedDate").click(function () {
            $("#pCreatedFrom").val('');
            $("#pCreatedTo").val('');
            $("#createdPreset").val('');
            $.uniform.update();
            applyFilter();
});
$("#pCreatedTo").change(function () {
            
            applyFilter();
        });
        $("#pCreatedFrom").change(function () {
            
            applyFilter();
        });

function applyFilter(){
    // Created Range
    var createdFrom = $("#pCreatedFrom").val();
    var createdTo = $("#pCreatedTo").val();

        $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setAdminEstimateFilter') ?>',
                data: {
                    
                    pECreatedFrom: createdFrom,
                    pECreatedTo: createdTo,
                    
                },
                dataType: 'JSON',
                success: function (d) {
                    reload_all_stats();
                    get_piechart_data();
                }
            });
}

function reload_all_stats(){
    $.ajax({
                type: "GET",
                url: '<?php echo site_url('ajax/estimate_stats') ?>',
                
                dataType: 'JSON',
                success: function (data) {
                   
                   $('.estimates_started').text(data.estimates_started);
                   $('.estimated_total').text(data.estimated_total);
                   $('.estimates_completed').text((data.estimates_completed).toFixed(2)+'%');
                   $('.estimated_average').text(data.estimated_average);
                   $('.company_count').text(data.company_count);
                   
                }
            });
}
</script>