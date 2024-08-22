
<?php $this->load->view('global/header-admin'); ?>

 <style>
.dataTables_filter{
    position: absolute !important;
    top: -24px !important;
    right: unset !important;
    z-index: 1000 !important;
    left: -315px !important;

}

.dataTables_filter label {
      width: 235px!important;
}

#dashboardDateRangeView{
    position: absolute!important;
    font-size: 15px!important;
    font-weight: bold!important;
    margin-left: 365px!important;
    margin-top:20px!important;
}
.dashboardTabFrom
{
    top: 1px;
    position:relative;
    color: #665874; 
}

.dashboardTabTo{
    top: 1px;
    position:relative;
    color:#665874;
}

#statControls
{
   width: 290px;
   float: right;
   color: #665874;
   font-size: 12px;
   font-weight: bold;
   margin-top:20px;
}

#customDates
{
    margin-top:5px!important;
    margin-left:200px!important;
    float:left!important;
    margin-bottom: unset!important;
} 

</style>
<div id="content" class="clearfix" style="padding-top:5px">
<div class="widthfix">
        <div class="content-box">
            <div class="box-header centered" style="position: relative;">
       
                Recent Added User
                <div style="position: absolute; right: 10px; top: 6px;">
                    <a class="box-action" href="#" id="recentExportUser">Export User</a>
                </div>
            </div>
           

            <div id="customDates">
            From: <input type="text" id="customFrom" value="<?php echo ($this->session->userdata('pFilterStatusFrom')) ?: $defaultCustomFrom; ?>"/>
            To: <input type="text" id="customTo" value="<?php echo ($this->session->userdata('pFilterStatusTo')) ?: $defaultCustomTo; ?>"/>

            <a href="#" id="applyCustomDates" class="btn ui-button">Apply</a>
        </div>
        <div class="clearfix"></div>
           <div class="showDates">
           <p id="dashboardDateRangeView" ><i class="fa fa-fw fa-calendar"></i>&nbsp;
             <span class="dashboardTabFrom" ></span> - <span class="dashboardTabTo"></span></p>
           <p id="dashboardTabsLoader" style="display:none;position: absolute;right: 371px;margin-top:20px;"><img src="/static/loading_animation.gif"></p>

           </div>
            <div id="statControls"> 
                    <span style="top: 2px;position: relative;">Time Period:</span>
                    <select id="statRange" style="width: 100px!important;">
                        <option data-range="last12thMonth">Last 12th Month</option>
                        <option data-range="year">Year</option>
                        <option data-range="quarter">Quarter</option>
                        <option data-range="month">Month</option>
                        <option data-range="week">Week</option>
                        <option data-range="day">Day</option>
                        <option data-range="custom">Custom</option>
                    </select>
                </div>
            <input type="hidden" id="updateRange" value="last12thMonth">
            <input type="hidden" id="fromDate" value="">
            <input type="hidden" id="toDate" value="">

             <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables-recent-user display">
                    <thead>
                    <tr>
                          <!-- <td>User Name</td> 
                          <td>Email</td> 
                          <td>Phone</td> 
                          <td>Company Name</td> 
                          <td>Role</td> 
                          <td>Status</td> 
                          <td style="white-space: nowrap;">Created date</td> 
                          <td style="white-space: nowrap;">Expires date</td> -->


                          <td style="white-space: nowrap;">Created date</td> 
                          <td style="white-space: nowrap;">Expires date</td>
                          <td>Status</td> 
                          <td>Company Name</td> 
                          <td>User Name</td> 
                          <td>Role</td> 
                          <td>Email</td> 
                          <td>Phone</td> 

                     </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
 
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
 
    initializeDataTable();
    updateDateFilters();


});



function updateStats() {
                $("#dashboardDateRangeView").hide();
                $("#dashboardTabsLoader").show();
}



function getSelectedRange() {
                return $("#statRange").find(':selected').data('range');
            }
var adminTable;
var notes_tiptip_company_id;
var currentXhr;
function initializeDataTable() {

 
//range = $("#statRange").find(':selected').data('range');
var range = $("#updateRange").val();
// var customFrom = $("#customFrom").val();
// var customTo = $("#customTo").val();
  $("#fromDate").val(customFrom);
$("#toDate").val(customTo);
  
     adminTable = $('.dataTables-recent-user').DataTable({
            "bServerSide": true,
            "ajax": {
                "url": "<?php echo site_url('admin/recentAddedUserTable'); ?>",
                "data": function(d) {
                        d.range = $("#updateRange").val();
                        d.customFrom= $("#fromDate").val();
                        d.customTo= $("#toDate").val();
                       }
              },
              "dataSrc": function(josn) {
                console.log("Full JSON response:", json); // Log the entire JSON response
                if (json.data && json.data.length > 0) {
                    console.log("Data array:", json.data); // Log the data array if it exists
                } else {
                    console.warn("No data found in the JSON response.");
                }
                return json; // Return the data array to DataTable

             },
             "success": function(data) {

            },
            "error": function(xhr, error, thrown) {
                console.error(xhr.responseText); // Log the error response to the console
            },
              "fnInitComplete": function (data) {
                $("#dashboardTabsLoader").hide();
 
 
                           },
        "aoColumns": [
            null, //1
            null, //email
            null, //phone
            null, //2
            null, //3
            null, //4
            null, //5
            null, //6

         ],
        "scrollCollapse": true,
            "scrollX": true,
        "bJQueryUI": true,
        "bAutoWidth": false,
        "bPaginate" : true,
        "bInfo" : false,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, 100,500,1000,-1],
            [10, 25, 50, 100,500,1000,'All']
        ],
        "drawCallback": function (settings) {
            check_highlighted_row();
            notes_tooltip();
            initTiptip();
        },
        "aaSorting": [[ 1, "asc" ]],
        "bStateSave": true,
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop"><"#expiredFilter"><"#statusFilter">f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lipr>'
    }); 

}


function check_highlighted_row(){
    if(localStorage.getItem("ad_last_active_row")){
        var row_num =localStorage.getItem("ad_last_active_row");
        $('#DataTables_Table_0 tbody').find("[data-company-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}

function notes_tooltip() {

$(".comapny_table_notes_tiptip").tipTip({   delay :200,
        maxWidth : "400px",
        context : this,
        defaultPosition: "right",
        content: function (e) {

        setTimeout( function(){
            currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type:'post',
                        data:{relationId:notes_tiptip_company_id,type:'company'},
                        cache: false,
                        success: function (response) {
                            $('#tiptip_content').html(response);
                        }
                    });
                },200);
                    return 'Loading...';
                }
    });
};

function notes_tooltip() {

$(".comapny_table_notes_tiptip").tipTip({   delay :200,
        maxWidth : "400px",
        context : this,
        defaultPosition: "right",
        content: function (e) {

        setTimeout( function(){
            currentXhr = $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type:'post',
                        data:{relationId:notes_tiptip_company_id,type:'company'},
                        cache: false,
                        success: function (response) {
                            $('#tiptip_content').html(response);
                        }
                    });
                },200);
                    return 'Loading...';
                }
    });
};

 

$("#statRange").change(function () {
    var range = $(this).find(':selected').data('range');
     $("#updateRange").val(range);
    if (range == 'custom') {
    $('#customDates').show();
    } else {
        updateDateFilters();
        $('#customDates').hide();
    }
        adminTable.ajax.reload();
        updateDateFilters();

    return false;
    });

function updateDateFilters() {
 
$("#dashboardTabsLoader").show();

var range = getSelectedRange();
$("#updateRange").val(range);
var customFrom = $("#customFrom").val();
var customTo = $("#customTo").val();

$("#fromDate").val(customFrom);
$("#toDate").val(customTo);


console.log("customFrom",customFrom);

var index = document.getElementById('statRange').selectedIndex;
sessionStorage.setItem('statRangeIndex', index);

$.ajax({
    url: '<?php echo site_url('ajax/setRecentUserStatusDateFilter') ?>',
    type: 'POST',
    data: {
        range: range,
        customFrom: customFrom,
        customTo: customTo
    }
}).done(function (data, status, jqXHR) {
    $("#dashboardTabsLoader").hide();
    var resData = JSON.parse(data);
    $('span.dashboardTabFrom').html(resData.startDate);
    $('span.dashboardTabTo').html(resData.finishDate);
    $('#fromDate').val(resData.startDate);
    $('#toDate').val(resData.finishDate);
    $('#customFrom').val(resData.startDate);
    $('#customTo').val(resData.finishDate);

    console.log("startDate",resData.startDate);
    console.log("endDate",resData.finishDate);

   
 }).error(function () {
 });
 adminTable.ajax.reload();

}

function showSelectedRange() {

if (sessionStorage.getItem('statRangeIndex')) {
    document.getElementById('statRange').selectedIndex = sessionStorage.getItem('statRangeIndex');
    //$("#statRange").prop("selectedIndex", sessionStorage.getItem('statRangeIndex'));
    $.uniform.update();

    if (sessionStorage.getItem('statRangeIndex') == customIndex) {
        $('#customDates').show();
    }
}
}

$("#applyCustomDates").click(function () {
$("#dashboardTabsLoader").show();
//$("#dashboardDateRangeView").hide();
var customFrom = $("#customFrom").val();
var customTo = $("#customTo").val();
if (!customFrom || !customTo) {
    alert("Please select a 'from' and 'to' date for custom date ranges");
    $("#dashboardTabsLoader").hide();
    $("#dashboardDateRangeView").show();
} else {
    $("#dashboardDateRangeView").show();
    updateDateFilters();
}

return false;
});
 
$(function() {
        $('#customFrom').datepicker({
            onSelect: function(dateText) {
                $(this).val(dateText);
            },
            dateFormat: 'mm/dd/yy' // Format the date as needed

        });
        $('#customTo').datepicker({
            onSelect: function(dateText) {
                $(this).val(dateText);
            },
            dateFormat: 'mm/dd/yy' // Format the date as needed

        });
    });
 
$(document).ready(function() {
    $('#recentExportUser').on('click', function(e) {
        e.preventDefault();

        swal({
            type: 'info',
            title: 'Please Wait...',
            html: '<p>Your report is cooking! It might take a while until it is done!</p>',
            showCloseButton: true,
        });

        var range = $("#updateRange").val();
        $.ajax({
            url: '<?php echo site_url('admin/export_csv'); ?>',
            type: 'POST',
            data: {
                customFrom: $("#fromDate").val(),
                customTo: $("#toDate").val(),
                range: range
            },
            success: function(response) {
                var result = JSON.parse(response);
                var filePath = result.filePath;
                // Create a temporary link to download the file
                var link = document.createElement('a');
                link.href = '<?php echo base_url(); ?>' + filePath;
                link.download = filePath.split('/').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                swal({
                    type: 'success',
                    title: 'Download Completed',
                    text: 'Your CSV file has been downloaded successfully!',
                    showCloseButton: true,
                });
            }, 
            error: function() {
                swal({
                    type: 'error',
                    title: 'Download Failed',
                    text: 'There was an error generating the CSV file.',
                    showCloseButton: true,
                });
            }
        });
    });
});


</script>

<?php $this->load->view('global/footer'); ?>
<script type="text/javascript" src="<?php echo site_url()?>3rdparty/fullcalendar/lib/moment.min.js"></script>
<script type="text/javascript" src="<?php echo site_url()?>3rdparty/wickedpicker/wickedpicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url()?>3rdparty/wickedpicker/wickedpicker.min.css" media="all">
