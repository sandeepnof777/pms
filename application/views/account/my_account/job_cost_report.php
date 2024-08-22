<style type="text/css">
.redClass{
    color: #A00705!important;
}
tr.redClass td.sorting_1 {
    color: #A00705!important;
}
#newFilterContainer {
        position: relative;
    }

    #newProposalFilterButton, #newResetProposalFilterButton {
        display: inline-block;
        float: left;
        margin-right: 10px;
    }

    #newResetProposalFilterButton {
        display: none;
    }

    #newFilterContainer h3 {
        margin: 5px 0;
        width: 33%;
        float: left;
    }

    #filterInfo {
        position: relative;
        padding-top: 10px;
        text-align: center;
        font-size: 1.25em;
        margin-bottom: 10px;
    }

    #filterInfo #filterResults {
        display: none;
    }

    #filterNumResults {
        font-weight: bold;
    }

    #filterControls {
        width: 20px;
        float: right;
        padding-top: 5px;
        text-align: right;
    }

    #newProposalFilters {
        position: absolute;
        top: 0;
        left: 0;
        background-color: #ebedea;
        width: 325px;
        -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
        padding: 0 5px 10px 5px;
        z-index: 100;
        display: none;
        border-radius: 5px;
        margin-top: 1px;
    }

    #topFilterRow, .filterRow {
        padding-bottom: 2px;
        margin: 0;
    }

    .filterColumn {
        float: left;
        width: 311px;
        background-color: #dcdcdc;
        border-radius: 10px;
        margin: 0 1px;
    }

    .filterColumnWide {
        float: left;
        width: 312px;
        background-color: #dcdcdc;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .filterColumnWide:first-child {
        margin-left: 1px;
        margin-right: 1px;
    }

    .filterColumnWide:nth-child(2) {
        margin-right: 0;
        margin-right: 1px;
    }

    .filterColumn.filterCollapse .filterColumnRow,
    .filterColumn.filterCollapse .filterColumnScroll,
    .filterColumn.filterCollapse .filterSearchBar,
    .filterColumnWide.filterCollapse .filterColumnRowContent {
        display: none;
    }

    .filterSearch {
        width: 200px;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 5px;
    }

    a.filterSearchClear {
        cursor: pointer;
        margin-top: 6px;
        font-size: 1.5em;
        margin-right: 7px;
        width: 10px;
        float: right;
        color: #B41D16;
        display: none;
    }

    a.filterDateClear {
        cursor: pointer;
        font-size: 0.8em;
        width: 10px;
        color: #B41D16;
        margin-top: 2px;
    }

    .filterHeaderToggle:before {
        content: "\f077";
    }

    .filterColumnWide.filterCollapse .filterHeaderToggle:before,
    .filterColumn.filterCollapse .filterHeaderToggle:before {
        content: "\f078";
    }

    .filterSliderColumn {
        float: left;
        width: 298px;
        margin-left: 2px;
    }

    .filterColumnHeader {
        position: relative;
        text-align: left;
        font-weight: bold;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        cursor: pointer;
        line-height: 20px;
        padding: 6px 10px;
        background: #5f5f5f;
        color: #e6e8eb;
    }

    .filterColumn.filterCollapse .filterColumnHeader,
    .filterColumnWide.filterCollapse .filterColumnHeader {
        border-bottom-right-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .filterColumnHeader.activeFilter {
        background: none;
        background-color: #25AAE1;
        color: #fff;
    }

    .filterColumnHeader .checker {
        position: absolute;
        left: 7px;
        top: 7px;
    }

    .filterColumnHeader span {
        font-weight: bold;
        color: #fff;
    }

    .filterColumnHeader i {
        margin-right: 10px;
    }

    .filterColumn.filterCollapse .filterColumnHeader .checker {
        display: none;
    }

    .filterColumnHeader .filterHeaderToggle {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #fff;
        cursor: pointer;
    }

    .filterColumnHeader .headerText {
        float: right;
        margin-right: 30px;
    }

    .filterColumnScroll {
        padding-top: 5px;
        height: 250px;
        overflow-y: auto;
    }

    .filterColumnStack {
        padding-top: 5px;
        max-height: auto;
    }

    .filterColumnRow {
        display: block;
        padding: 4px 2px;
    }

    .filterColumnWide .filterColumnRow {
        padding: 0;
    }

    .filterColumnRow .filterColumnRowContent {
        padding: 10px;
        border-right: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .filterColumnRowContent input.text {
        width: 70px;
        margin-right: 10px;
    }

    .filterColumnRow .checker {
        margin-top: -3px;
    }

    #filterBadges {
        float: left;
        padding-left: 10px;
        width: 500px;
    }

    .filterBadge {
        float: left;
        border-radius: 3px;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 5px;
        font-size: 11px;
        margin-top: 3px;
    }

    .filterBadgeTitle {
        display: inline;
        float: left;
        padding: 5px 2px;
        font-weight: bold;
    }

    .filterBadgeContent {
        display: inline;
        float: left;
        padding: 5px 2px;
    }

    .filterBadgeRemove {
        display: inline;
        float: left;
        padding: 5px 2px;
    }

    .filterBadgeRemove a {
        display: inline-block;
        height: 100%;
        width: 100%;
    }

    #priceSlider {
        margin: 2px 10px;
    }

    .ui-slider-range {
        background-color: #505050;
    }

    .comiseo-daterangepicker {
        z-index: 101 !important;
    }

    #closeProposalFilters {
        position: absolute;
        right: 0;
        font-size: 11px;
        top: 5px;
    }

    #openFilterPresets {
        position: absolute;
        left: 0;
        font-size: 11px;
        top: 5px;
    }

    /* Override Button Alignment on DateRangePicker */
    .comiseo-daterangepicker-right .comiseo-daterangepicker-buttonpanel {
        float: right;
    }

    .comiseo-daterangepicker:nth-child(2) {
        left: 245px !important;
    }


    #updateStatusContent {
        display: none;
    }

    .updateStatusCheckContainer {
        width: 150px;
        padding: 5px 20px;
        float: left;
        display: inline-block;
        border: 1px solid #67696c;
        margin-right: 5px;
        border-radius: 5px;
    }

    .updateStatusCheckContainer.statusSelected {
        background-color: #25aae1;
        border: 1px solid #25aae1;
        color: #fff;
    }
table.estimatePricingTable{width: 100%;
    margin: 15px 0;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 5px;}
table.estimatePricingTable td {
    padding: 5px;
}
table.estimatePricingTable th {
    background: #e2e2e2;
    padding: 7px;
}
</style>

<div class="estimateReportMenuButtons">



   
    <div class="clearfix" style="height: 10px;"></div><br />

    <div id="proposalsTopContent" style="position: relative;">

    <div class="materialize">
        <a class="m-btn grey tiptip" title="Filter your proposals" id="newProposalFilterButton"><i
                class="fa fa-fw fa-filter"></i> Filters</a>
        <a class="m-btn grey tiptip" title="Reset All Filters" id="newResetProposalFilterButton"><i
                class="fa fa-fw fa-refresh"></i></a>
        <div id="filterBadges"></div>
        <div class="clearfix"></div>
    </div>


    <div id="newFilterContainer">

        <div id="newProposalFilters">

            <div id="filterInfo">
                <img id="filterLoading" src="/static/loading.gif">
                <p id="filterResults">
                    <a href="#" class="btn ui-button" id="openFilterPresets">
                        Presets <i id="presetChevron" class="fa fw fa-chevron-down"></i>
                    </a>
                    <span id="filterNumResults"></span> proposals found
                    <a href="#" class="btn ui-button update-button" id="closeProposalFilters">
                        Next <i class="fa fw fa-chevron-right"></i>
                    </a>
                </p>
            </div>

            <div class="clearfix"></div>

            <div class="filterRow">


                <div class="filterColumnWide filterCollapse">
                    <div class="filterColumnRow">

                        <div class="filterColumnHeader containsCalendar" id="activityFilterHeader">
                            <i class="fa fa-fw fa-calendar"></i>&nbsp;Last Activity: <span class="headerText"
                                                                                           id="activityHeaderText">All</span>
                            <a class="filterHeaderToggle fa fa-fw"></a>
                        </div>

                        <div class="filterColumnRowContent">
                            <p>
                                <label>From:</label>
                                <input type="text" class="text" id="pActivityFrom" style="margin-left: 11px;"
                                       value="<?php echo ($this->session->userdata('pActivityFrom')) ? date('m/d/y', $this->session->userdata('pActivityFrom')) : '' ?>">
                                <label>To:</label>
                                <input type="text" class="text" id="pActivityTo"
                                       value="<?php echo ($this->session->userdata('pActivityTo')) ? date('m/d/y', $this->session->userdata('pActivityTo')) : '' ?>">
                                <a class="filterDateClear" id="resetActivityDate">Reset</a>
                            </p>
                            <p style="padding-top: 5px;">
                                <label>Preset:</label>
                                <select id="activityPreset">
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
                        </div>

                    </div>
                </div>



            </div>


    </div>
</div>

</div>

<table class="estimatePricingTable" width="100%" style="overflow: auto;">
    <thead>
        <tr>
            <th width="25%">Type</th>
            <th width="30%">Item</th>
            <th width="15%">Proposals</th>
            <th width="15%">Total Cost</th>
            <th width="15%">Total Price</th>
            
            <th width="15%">Price Diff</th>
            <th width="15%">Profit</th>
            <th width="15%">Total Quantity</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<div id="itemPdfDialog" title="Preview Item" style="display:none;">
<div style="text-align: center;" id="loadingFrame2">
            <br />
            <p><strong>Loading Item</strong></p><br />
            <p><img src="/static/loading_animation.gif" /></p>
        </div>
        <iframe id="item-preview-iframe" style="width: 100%; height: 650px"></iframe>
</div>

<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">
var oTable ='';
    $(document).ready(function() {

         oTable = $(".estimatePricingTable").DataTable({
            serverSide: true,
            ajax: {
                "url": '<?php echo site_url('account/jobCostReportData/'); ?>',
                type: "POST"
            },
            bJQueryUI: true,
            bAutoWidth: true,
            bStateSave: true,
            sPaginationType: "full_numbers",
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            columns: [
                {searchable: true, sortable: true},
                {searchable: true, sortable: true},
                {searchable: true, sortable: true, class: 'dtCenter'},
                {searchable: true, sortable: true, class: 'dtRight'},
                {searchable: true, sortable: true, class: 'dtRight'},
                {searchable: true, sortable: true, class: 'dtRight'},
                {searchable: true, sortable: true, class: 'dtRight'},
                {searchable: true, sortable: true, class: 'dtRight'},
            ],
            "createdRow": function( row, data, dataIndex){
                
                var value = parseFloat(data[6].replace('%',''));
                console.log(value);
                if( value < 0 ){
                   
                    $(row).addClass('redClass');
                }
            }
        });

        $("#itemPdfDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });

        $(".show_item_pdf").click(function() {

            $("#itemPdfDialog").dialog('open');
            $("#item-preview-iframe").hide();
            // Show the loader
            $("#loadingFrame2").show();
            // Refresh the iframe - Load event will handle showing the frame and hiding the loader
            var currSrc = '<?php echo  site_url('pdf/material_item_list');?>';
            $("#item-preview-iframe").attr("src", currSrc);
            $("#loadingFrame2").hide();
            $("#item-preview-iframe").show();
            
        });

        // End document ready
        $("#filterLoading").hide();
       
    });


    $(document).ready(function () {

// Show Presets
$("#openFilterPresets").click(function () {
    // Toggle the presets
    $("#proposalFilterPresets").toggle();
    // Toggle the chevron on the dropdown
    $("#presetChevron").toggleClass("fa-chevron-down fa-chevron-up");
});

// Close the filter
$("#closeProposalFilters").click(function () {
    $("#newProposalFilters").toggle();
    $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
});

$(".filterColumnWide .filterColumnHeader").click(function () {
    $(this).parents('.filterColumnWide').toggleClass('filterCollapse');
});

$(".filterColumn .filterColumnHeader").click(function () {
    $(this).parents('.filterColumn').toggleClass('filterCollapse');
});


// Imported
$("#newProposalFilterButton").click(function () {
    //hideInfoSlider();
    $("#newProposalFilters").toggle();
    // Clear search so that filters aren't affected
    //oTable.fnFilter('');
    // Hide group action menu
    $(".groupActionsContainer").hide();
});

});
$("#resetActivityDate").click(function () {
            $("#pActivityFrom").val('');
            $("#pActivityTo").val('');
            $("#activityPreset").val('');
            $.uniform.update();
            applyFilter();
        });

$("#activityPreset").change(function () {

var selectVal = $(this).val();

if (selectVal) {

    if (selectVal == 'custom') {
        $("#pActivityFrom").focus();
    }
    else {
        var preset = datePreset(selectVal);
        $("#pActivityFrom").val(preset.startDate);
        $("#pActivityTo").val(preset.endDate);
        applyFilter();
    }
}
});


$("#newResetProposalFilterButton").click(function () {


// Reset All Checkboxes
$(".filterCheck, .filterColumnCheck").prop('checked', true);


$("#pActivityFrom").val("");
$("#pActivityTo").val("");

$(".filterColumn, .filterColumnWide").addClass('filterCollapse');

$('.searchSelectedRow').remove();


$.uniform.update();
applyFilter();
$('#newResetProposalFilterButton').hide();

return false;
});
$("#pActivityFrom, #pActivityTo").change(function () {
        $("#activityPreset").val('custom');
        $.uniform.update();
        applyFilter();
    });

function applyFilter() {

console.log(oTable);
$("#filterResults").hide();
$("#filterLoading").show();
setTimeout(function () {
    $("#reset-filter").show();

   

    
    
    numFilters=0;



    // Activity Range
    var createdFrom = $("#pActivityFrom").val();
    var createdTo = $("#pActivityTo").val();

    var filterBadgeHtml = '';
    
    var activityHeaderText = ' [ All ]';


    // Info boxes


    // Activity Date Range
    if ($("#pActivityFrom").val()) {
        numFilters++;
        var fromDateString = $("#pActivityFrom").val();
        var toDateString = $("#pActivityTo").val();
        var activityRangeString = fromDateString + ' - ' + toDateString;

        filterBadgeHtml += '<div class="filterBadge">' +
            '<div class="filterBadgeTitle">Activity: </div>' +
            '<div class="filterBadgeContent">' +
            activityRangeString +
            '</div>' +
            '<div class="filterBadgeRemove"><a href="#" id="removeActivityFilter">&times;</a></div>' +
            '</div>';

        activityHeaderText = activityRangeString;
        $('#activityFilterHeader').addClass('activeFilter');
    } else {
        $('#activityFilterHeader').removeClass('activeFilter');
    }
    $("#activityHeaderText").text(activityHeaderText);



   



 
        $('#otherFilterHeader').removeClass('activeFilter');


    // Apply the HTML
    $("#filterBadges").html(filterBadgeHtml);

   
    if (numFilters < 1) {
                $("#newProposalFilterButton").removeClass('update-button');
                $("#newProposalFilterButton").addClass('grey');
                $('#newResetProposalFilterButton').hide();
            }
            else {
                $("#newProposalFilterButton").addClass('update-button');
                $("#newProposalFilterButton").removeClass('grey');
                $('#newResetProposalFilterButton').show();
            }
       
    

    $.ajax({
        type: "POST",
        url: '<?php echo site_url('ajax/setJCFilter') ?>',
        data: {
            
            jcCreatedFrom: createdFrom,
            jcCreatedTo: createdTo,
          
        },
        dataType: 'JSON',
        success: function (d) {
            
            oTable.ajax.reload();
            $("#filterLoading").hide();
        }
    });
}, 200);
}




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

$("#pCreatedFrom").datepicker();
    $("#pCreatedTo").datepicker();
    $("#pActivityFrom").datepicker();
    $("#pActivityTo").datepicker();
</script>