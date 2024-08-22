<?php $this->load->view('global/header-super-user') ?>
    <!-- <script type="text/javascript" src="../../3rdparty/ckeditor4/ckeditor.js"></script> -->

    
<style>

#preview_popup .tox-tinymce{
    border: 0px;   
}

#statsTable .dataTables_filter{
    float: left!important;
}
#salesTargetsStatsTable_wrapper .dataTables_filter {
    /* float: right !important; */
    text-align: right !important;
    width: 60% !important;
}
#salesTargetsStatsTable_wrapper{
    display: none;
}
#salesTargetsStatsTable td:not(.dtCenter) {
    padding-left: 5px;
}

#salesBusinessStatsTable_wrapper .dataTables_filter {
    float: right !important;
    text-align: right !important;
    width: 60% !important;
}
#salesBusinessStatsTable_wrapper th { background-color: #555555 !important; color: #eee;}
#salesBusinessStatsTable_wrapper th a{ color: #eee!important;}
#business_type_breakdown_table_wrapper th { background-color: #555555 !important; color: #eee;}
#business_type_breakdown_table_wrapper th a{ color: #eee!important;}

#salesBusinessStatsTable td:not(.dtCenter) {
    padding-left: 5px;
}
.business_table_breakdown{color:#000!important}
.active_section{color:#25AAE1!important}
#addProposalDialog .select2-container {
width: 60.5% !important;
padding: 0;
}

/* Stats Table */

#salesTargetsStatsTable td:not(.dtCenter) {
    padding-left: 5px;
}

#salesBusinessStatsTable_wrapper .dataTables_filter {
    float: right !important;
    text-align: right !important;
    width: 60% !important;
}
#StatusStatsTable_wrapper th {
    font-size: 13px !important;
    background-color: #555555 !important;
    color: #eee !important;
    white-space: nowrap;
}

#StatusStatsTable tr td{
    text-align: center!important;
}
#StatusStatsTable tr td:first-child{
    text-align: left!important;
}

#StatusStatsTable_wrapper .dataTables_filter {
   
    text-align: right !important;
    width: 60% !important;
}

.filterColumnRow .checker,.filterColumnRow label{
    cursor: pointer;
}

.blue_back{
    background-color: #25AAE1!important;
    background-image: none!important;
}
</style>
<?php
//some_function_to_cause_error();
?>

<input type="hidden" name="filterType" id="filterType">
<input type="hidden" name="filterIds" id="filterIds">
    <div id="content" class="clearfix dashboard">
        <div class="widthfix">

        

            <?php


            
            // Show stats
            $this->load->view('account/master-dashboard-stats');
            ?>


            <div class="clearfix">
                <div class="content-box left half" style="overflow: visible;">
                    <div class="box-header centered">Your Pipeline</div>
                    <div class="box-content padded">

                        <!-- Div to show if no data -->
                        <div id="noPieData" style="display: none; text-align: center">
                            <p>No data available for this time period!</p>
                        </div>

                        <!--Div that will hold the pie chart-->
                        <div id="dashboardPie"></div>

                    </div>
                </div>
                <div class="content-box right half">
                    <div class="box-header centered">Top 10 Open Proposals</div>
                    <div class="box-content">
                        <table class="boxed-table2" width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <td class="centered">#</td>
                                <td class="centered">Date</td>
                                <td class="centered">Account</td>
                                <td class="centered">Project</td>
                                <td class="centered">Amount</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*
                             *  NEW CODE STARTS HERE ONLY TESTING AT THE MOMENT
                             */
                            if ($account->getCompany()->getCompanyId() == 3 || 1) {
                                $k = 0;
                                foreach ($top_ten as $proposal) {
                                    $k++;
                                    //Price Breakdown
                                    $servicess = $this->db->query("select * from proposal_services where proposal=" . $proposal->proposalId);
                                    $priceBreakdown = '';
                                    foreach ($servicess->result() as $service) {
                                        $priceBreakdown .= "<p class='clearfix'><strong class='title'>" . htmlspecialchars($service->serviceName) . "</strong><strong class='price'>" . htmlspecialchars($service->price) . '</strong></p>';
                                    }
                                    ?>
                                    <tr class="<?php echo ($k % 2 == 0) ? 'even' : ''; ?>">
                                        <td class="centered"><?php echo $k ?></td>
                                        <td class="centered"><?php echo date('m/d/Y', $proposal->created + TIMEZONE_OFFSET); ?></td>
                                        <td class="centered"><span class="tiptip"
                                                                   title="<b><?php echo htmlspecialchars($proposal->companyName); ?></b> <br> <strong>Contact:</strong> <?php echo $proposal->firstName . ' ' . $proposal->lastName; ?> <br> <strong>Cell:</strong><?php echo $proposal->cellPhone; ?> <br> <strong>Phone:</strong> <?php echo $proposal->businessPhone; ?><p class='clearfix'></p>"><?php echo ($proposal->companyName) ? $proposal->companyName : $proposal->firstName . ' ' . $proposal->lastName; ?></span>
                                        </td>
                                        <td class="centered"><a class="tiptip"
                                                                title="Company: <?php echo $proposal->p_company_name ?> Proposal"
                                                                href="javascript:void(0)"><?php echo $proposal->projectName ?></a>
                                        </td>
                                        <td class="centered">
                                            <span class="price-tiptip2"
                                                  title="<b>Price Breakdown</b><?php echo $priceBreakdown; ?>">$<?php echo number_format($proposal->price) ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ($k == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="centered">No information to display.</td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"></td><td style="display: none;"> </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="content-box">
                <div class="box-header centered">Your Leads</div>
                <div class="box-content">
                    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <td class="centered">#</td>
                            <td class="centered">Due Date</td>
                            <td class="centered">Status</td>
                            <td class="centered">Rating</td>
                            <td>Company</td>
                            <td>Project Name</td>
                            <td class="centered">Contact</td>
                            <td class="centered">Owner</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!count($leads)) {
                            ?>
                            <tr>
                                <td colspan="8" class="centered">No information to display.</td>
                            </tr>
                            <?php
                        } else {
                            $k = 0;
                            foreach ($leads as $lead) {
                                $k++;
                                ?>
                                <tr class="<?php echo ($k % 2 == 0) ? 'even' : ''; ?>">
                                    <td class="centered"><?php echo $k; ?></td>
                                    <td class="centered"><?php echo date('m/d/Y', $lead->dueDate + TIMEZONE_OFFSET) ?></td>
                                    <td class="centered"><?php echo $lead->status ?></td>
                                    <td class="centered"><?php echo $lead->rating ?></td>
                                    <td class="centered"><?php echo $lead->companyName ?></td>
                                    <td class="centered"><a class="tiptip"
                                                            href="<?php echo site_url('leads/edit/' . $lead->leadId) ?>"
                                                            title="View Lead Details"><?php echo $lead->projectName ?></a>
                                    </td>
                                    <td class="centered">
                                        <span class="tiptip"
                                              title="<strong>Title:</strong><?php echo $lead->title ?><br> <strong>Cell:</strong><?php echo $lead->cellPhone; ?> <br> <strong>Phone:</strong> <?php echo $lead->businessPhone; ?><p class='clearfix'></p>"><?php echo $lead->firstName . ' ' . $lead->lastName ?></span>
                                    </td>
                                    <td class="centered"><?php
                                        if (isset($accounts[$lead->account])) {
                                            ?>
                                            <span class="tiptip"
                                                  title="<?php echo $accounts[$lead->account]->getFullName() ?>"><?php
                                                $names = explode(' ', trim($accounts[$lead->account]->getFullName()));
                                                foreach ($names as $name) {
                                                    if ($name) {
                                                        echo substr($name, 0, 1) . '. ';
                                                    }
                                                }
                                                ?></span>
                                            <?php
                                        } else {
                                            echo 'Not Assigned';
                                        } ?></td>
                                </tr>
                                <?php
                                if ($k == 10) {
                                    break;
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div> -->

        </div>
    </div>
    </div>

    <div id="datatablesError" title="Error" style="text-align: center; display: none;">
        <h3>Oops, something went wrong</h3>

        <p>We're having a problem loading this page.</p><br/>
        <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact
                support</a> if this keeps happening.</p>
    </div>

    <div id="addProposalDialog" title="Proposal " style="display: none;">
        <p style="padding-top:25px"><label style="margin-left: 6%;">Search</label>
        <select name="SeachcontactName" id="SeachcontactName" class="dont-uniform"  ><option></option></select></p>
        <input type="hidden" id="add_proposal_contact_id_hidden">
        <a class="btn blue-button" id="add_proposal_select_btn" style="top: 31px;position: absolute;right: 20px;">Create Proposal</a>
    </div>


    <script src="<?= site_url('3rdparty/DataTables-new/datatables.min.js'); ?>"></script>
    <script src="<?= site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.jqueryui.min.js'); ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= site_url('3rdparty/DataTables-new/datatables.min.css'); ?>"
          media="all">

    <script type="text/javascript">
var statusObject = <?= json_encode($statusObject);?>;

var childCompanyCount = <?= count($childCompanies);?>;
$(document).ready(function () {

    $('#filterType').val('all');
    $('#filterIds').val(getChildCompanyIds());

    if(!localStorage.getItem("dashboardTabIndex") || localStorage.getItem("dashboardTabIndex")==0){
        if(hasLocalStorage){
            localStorage.setItem("dashboardTabIndex", 1);
        }
    }

    if( localStorage.getItem("dashboardTabIndex")!=3 && localStorage.getItem("dashboardTabIndex")!=4 && localStorage.getItem("dashboardTabIndex")!=5){
        $('.statTypeSelector').css("visibility", "visible");
    }else{
        $('.statTypeSelector').css("visibility", "hidden");
    }
            // Datatables error Dialog
            $("#datatablesError").dialog({
                width: 500,
                modal: true,
                buttons: {
                    Retry: function () {
                        window.location.reload();
                    }
                },
                autoOpen: false
            });
            $.fn.dataTable.ext.errMode = 'none';
            $(".boxed-table2").on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
                $("#datatablesError").dialog('open');
            })
                .DataTable({
                    "ordering": false,
                    "searching": false,
                    "paging": false,
                    "jQueryUI": true,
                    "deferLoading": 0
                });


            var userId = <?php echo $account->getAccountId(); ?>;

            <?php if ($psaError) { ?>
            swal({
                type: 'info',
                title: 'ProSiteAudit Connection',
                html: '<p>Your current ProSiteAudit login details are incorrect</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-cog"></i> Change Password',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Ignore'
            }).then(
                function () {
                    window.location.href = '/account/psa';
                }, function (dismiss) {

                }
            );
            <?php } ?>

            var announcements = <?php echo json_encode($announcements); ?>;
            var numAnnouncements = announcements.length;
            var allContent = '';
            var theTitle = '<i class="fa fa-fw fa-bullhorn"></i> Announcements';

            if (numAnnouncements > 0) {

                for (var i = 0; i < numAnnouncements; i++) {
                    allContent += '<div class="announcementContent">';
                    allContent += '<h3>' + announcements[i].title + '</h3>';
                    allContent += '<textarea id="announcement_text_' + i + '">' + announcements[i].content + '</textarea>';
                    allContent += '<hr />';
                    allContent += '</div><style>#cke_announcement_text_' + i + ' .cke_reset_all{display:none;}#cke_announcement_text_' + i + '{border: 0px;}</style>';

                    //CKEDITOR.replace( 'announcement_text_'+i,{removePlugins: 'elementspath',readOnly:true,height:'auto'} );
                }

                if (allContent.length > 0) {

                    swal.setDefaults({
                        input: 'checkbox',
                        inputValue: 0,
                        inputPlaceholder: "Don't show me this again"
                    });

                    swal({
                        title: theTitle,
                        html: allContent,
                        width: '650px',
                        confirmButtonText: '<i class="fa fa-fw fa-graduation-cap"></i> Go To Tutorials',
                        showCancelButton: true,
                        cancelButtonText: '<i class="fa fa-fw fa-close"></i> Close',
                        onOpen: function () {
                            for (var i = 0; i < numAnnouncements; i++) {
                                // CKEDITOR.replace('announcement_text_' + i, {
                                //     removePlugins: 'elementspath',
                                //     readOnly: true,
                                //     height: '200px'
                                // });
                                tinymce.init({selector: '#announcement_text_' + i,elementpath: false,menubar: false,relative_urls : false,remove_script_host : false,convert_urls : true,statusbar: false,toolbar : false,paste_as_text: true,height:'200',readonly : true});

                            }

                            $('.swal2-modal').attr('id','announcements_popup');
                            //$('.swal2-modal').attr('id','announcements_popup');
                            setTimeout(function(){
                                $('.swal2-cancel').focus();
                            });
                            $('#announcements_popup').find(".swal2-cancel").focus();
                        }
                        
                    }).then((result) => {

                            if (result === 1) {
                                // Hide it
                                var toHide = [];
                                // Get ann array to hide
                                for (var i = 0; i < announcements.length; i++) {
                                    toHide.push(announcements[i].id);
                                }

                                // Send request
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('ajax/hideAnnouncements') ?>",
                                    data: {
                                        accountId: userId,
                                        announcements: toHide
                                    },
                                    dataType: 'json'
                                })
                                    .done(function (data) {
                                        // Nothing to do
                                    });
                            }

                            // Now redirct
                            window.location.href = 'https://pavementlayers.zendesk.com/hc/en-us';
                        },
                        function (dismiss) {

                            // This is here to prevent errors
                            if ($("#swal2-checkbox").is(':checked')) {
                                var toHide = [];
                                // Get ann array to hide
                                for (var i = 0; i < announcements.length; i++) {
                                    toHide.push(announcements[i].id);
                                }

                                // Send request
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('ajax/hideAnnouncements') ?>",
                                    data: {
                                        accountId: userId,
                                        announcements: toHide
                                    },
                                    dataType: 'json'
                                })
                                    .done(function (data) {
                                        // Nothing to do
                                    });
                            }
                        });
                }
            }


            //search fields js
            $("#searchProposal, #searchClient").focus(function () {
                if ($(this).val() == $(this).attr('title')) {
                    $(this).val('');
                }
            });
            $("#searchProposal, #searchClient").blur(function () {
                if ($(this).val() == '') {
                    $(this).attr('title');
                }
            });


            customIndex = 6;
            loadSavedState();

            function loadSavedState() {
                showSelectedRange();
                showLastStatsTab();
                setSelectedUser();
            }

            function showLastStatsTab() {
                $(".statTypeSelector").removeClass('update-button statTypeSelected');

                switch (sessionStorage.getItem('statTypeSelector')) {

                    case 'headline':
                        $("#headlineButton").addClass('update-button statTypeSelected');
                        $("#userButton").removeClass('update-button statTypeSelected');
                        $("#headline-stats").show();
                        $("#headline-stats-leads").show();
                        $("#statsTable").hide();
                        $("#statUserControl").show();
                        break;

                    case 'user':
                        $("#userButton").addClass('update-button statTypeSelected');
                        $("#headlineButton").removeClass('update-button statTypeSelected');
                        //$("#statsTable").show();  Moved into fnDraw of table to load nicely
                        $("#headline-stats").hide();
                        $("#headline-stats-leads").hide();
                        $("#headline-stats-sf").hide();
                        //$("#statUserControl").hide();
                        break;

                    default:
                        $("#headlineButton").addClass('update-button statTypeSelected');
                        $("#userButton").removeClass('update-button statTypeSelected');
                        $("#headline-stats").show();
                        $("#headline-stats-leads").show();
                        $("#statsTable").hide();
                        $("#statUserControl").show();
                        break;
                }

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

            function setSelectedUser() {

                if (sessionStorage.getItem('statUser')) {

                    if($("#statsUser option[value='" + sessionStorage.getItem('statUser') + "']").length > 0) {
                        document.getElementById('statsUser').selectedIndex = sessionStorage.getItem('statUser');
                        $.uniform.update();
                    }
                }
            }

            $('#customFrom').datepicker();
            $('#customTo').datepicker();

            // Stat Type Select
            $(".statTypeSelector").click(function () {
                // Clear formatting
                $(".statTypeSelector").removeClass('update-button statTypeSelected');
                // Highlight Selected
                $(this).addClass('update-button statTypeSelected');

                // Hide containers
                $(".statTypeContainer").hide();

                // Remember the tab
                sessionStorage.setItem('statTypeSelector', $(this).data('type'));

                switch ($(this).data('type')) {

                    case 'headline':
                        $("#headline-stats").show();
                        $("#headline-stats-leads").show();
                        $("#headline-stats-sf").show();
                        $("#statUserControl").show();
                        $("#statsTable").hide();
                        $("#statsTableSF").hide();
                        break;

                    case 'user':
                        //$("#statsTable").show();
                        //$("#statUserControl").hide();
                        break;
                }
                if(localStorage.getItem("dashboardTabIndex")!=3 && localStorage.getItem("dashboardTabIndex")!=4 && localStorage.getItem("dashboardTabIndex")!=5){
                    updateStats();
                }


                return false;
            });


            // Statistic date range buttons
            $("#statRange").change(function () {

                var range = $(this).find(':selected').data('range');

                if (range == 'custom') {
                    $('#customDates').show();
                    sessionStorage.setItem('statRangeIndex', customIndex);
                } else {
                    $('#customDates').hide();

                    updateDateFilters();
                    
                }

                return false;
            });

            // Statistic date range buttons
            $(".statUserSelect a").click(function () {

                // Highlight the selected button
                $('.statUserSelect a').removeClass('update-button selectedUser');
                $(this).addClass('update-button selectedUser');

                // Reset the dropdown
                $("#statsUser").val($("#statsUser option:first").val());
                $.uniform.update();
                
                if ($(this).data('user') != 'user') {
                    // Only update stats here/ User select will update on change
                    updateStats();
                }

                return false;
            });

            $("#applyCustomDates").click(function () {

                $("#dashboardTabsLoader").show();
                $("#dashboardDateRangeView").hide();
                var customFrom = $("#customFrom").val();
                var customTo = $("#customTo").val();

                if (!customFrom || !customTo) {
                    alert("Please select a 'from' and 'to' date for custom date ranges");
                    $("#dashboardTabsLoader").hide();
                    $("#dashboardDateRangeView").show();
                } else {
                    updateDateFilters();
                }

                return false;
            });

            // User selection
            $("#statsUser").change(function () {

                // Remember the range - old school javascript
                var index = document.getElementById('statsUser').selectedIndex;
                sessionStorage.setItem('statUser', index);

                // Highlight the selected button
                $('.statUserSelect a').removeClass('update-button selectedUser');
                $('#userSelectButton').addClass('update-button selectedUser');

                updateStats();
                drawDashboardPieChart();
            });

            function getSelectedRange() {
                return $("#statRange").find(':selected').data('range');
            }


            function updateLinks() {
                // For company, reset links to base-link
                //if ($("#statsUser").val() == 'company') {
                    // Reset each link if selecting company
                    $(".statDrilldown").each(function () {
                        // Add the user details to URL
                        // var newURL = $(this).data('base-link');
                        // if ($(this).parents('#headline-stats-sf').length) {
                        //     newURL = $(this).data('base-link') + '/sf';
                        // }
                        // $(this).prop('href', newURL);
                        $(this).prop('href', 'javascript:void(0)');
                    });
                //}

                // For users, update links
                if ($("#statsUser").val() == 'user') {
                    var accountID = $("#statsUser").find(':selected').data('account');
                    if (accountID !== undefined && accountID !== null) {
                        // Reset each link if selecting company
                        $(".statDrilldown").each(function () {
                            // Add the user details to URL
                            // var newURL = $(this).data('base-link') + '/user/' + accountID;
                            // if ($(this).parents('#headline-stats-sf').length) {
                            //     newURL = $(this).data('base-link') + '/user/' + accountID + '/sf';
                            // }
                            // $(this).prop('href', newURL);
                            $(this).prop('href', 'javascript:void(0)');
                        });
                    }
                }

                // For branch, update links
                if ($("#statsUser").val() == 'branch') {
                    var branchId = $("#statsUser").find(':selected').data('branch');
                    if (branchId !== undefined && branchId !== null) {
                        // Reset each link if selecting company
                        $(".statDrilldown").each(function () {
                            // Add the user details to URL
                            // var newURL = $(this).data('base-link') + '/branch/' + branchId;
                            // if ($(this).parents('#headline-stats-sf').length) {
                            //     newURL = $(this).data('base-link') + '/branch/' + branchId + '/sf';
                            // }
                            // $(this).prop('href', newURL);
                            $(this).prop('href', 'javascript:void(0)');
                        });

                    }
                }
                /*
                 * Leads links update
                 */
                var leadsURLSuffix = '';
                //user/branch dropdown
                switch ($("#statsUser").val()) {
                    case 'company':
                        break;
                    case 'user':
                        var accountID = $("#statsUser").find(':selected').data('account');
                        if (accountID !== undefined && accountID !== null) {
                            leadsURLSuffix += '/user/' + accountID;
                        }
                        break;
                    case 'branch':
                        var branchId = $("#statsUser").find(':selected').data('branch');
                        if (branchId !== undefined && branchId !== null) {
                            leadsURLSuffix += '/branch/' + branchId;
                        }
                        break;
                }
                //date range
                var range = getSelectedRange();
                leadsURLSuffix += '/range/' + range;
                if (range == 'custom') {
                    var from = $("#customFrom").val();
                    var to = $("#customTo").val();
                    from = from.replace(/\//g, '-');
                    to = to.replace(/\//g, '-');
                    leadsURLSuffix += '/from/' + from + '/to/' + to;
                }
                $(".statDrilldownLeads").each(function () {
                    //$(this).prop('href', $(this).data('base-link') + leadsURLSuffix);
                    $(this).prop('href', 'javascript:void(0)');
                });

            }

            function updateDateFilters() {

                $("#dashboardTabsLoader").show();
                $("#dashboardDateRangeView").hide();

                var range = getSelectedRange();
                var customFrom = $("#customFrom").val();
                var customTo = $("#customTo").val();

                var index = document.getElementById('statRange').selectedIndex;
                sessionStorage.setItem('statRangeIndex', index);

                $.ajax({
                    url: '<?php echo site_url('ajax/setProposalStatusDateFilter') ?>',
                    type: 'POST',
                    data: {
                        range: range,
                        customFrom: customFrom,
                        customTo: customTo
                    }
                }).done(function (data, status, jqXHR) {
                    var resData = JSON.parse(data);
                    $('.dashboardTabFrom').html(resData.startDate);
                    $('.dashboardTabTo').html(resData.finishDate);
                    updateStats();
                    drawDashboardPieChart();
                }).error(function () {
                    updateStats();
                });

            }

            function updateStats() {
                $("#dashboardDateRangeView").hide();
                $("#dashboardTabsLoader").show();
                updateLinks();

                    // for first 3 tabs
                       
                        if( localStorage.getItem("dashboardTabIndex")==3){
                            console.log('tab3');
                            updateSalesTargetsTable();
                        }else if(localStorage.getItem("dashboardTabIndex")==4){
                            console.log('tab4');
                            updateBusinessTable();
                        }else if(localStorage.getItem("dashboardTabIndex")==5){
                            updateStatusTable();
                        }else{

                            console.log('tab12');
                        var statType = getStatType();

                            switch (statType) {

                                case 'headline':
                                    updateStatBoxes();
                                
                                    break;

                                case 'user':
                                    updateTable();
                                    break;

                                default:
                                    updateStatBoxes();
                            }
                        
                        }

                
            }

            function getStatType() {
                return $(".statTypeSelected").data('type');
            }

            function updateStatBoxes() {

             var filterType =  $('#filterType').val();
             var filterIds =  $('#filterIds').val();


                var range = getSelectedRange();
                var user = $("#statsUser").val();
                var accountId = $("#statsUser").find(':selected').data('account');
                var customFrom = $("#customFrom").val();
                var customTo = $("#customTo").val();
                var branchId = $("#statsUser").find(':selected').data('branch');
                var companyId = $("#statsUser").find(':selected').data('company');
                var company = $('.companyCheck:checked').val();

                // Get single user / non admin account value
                if (!accountId) {
                    var accountId = $("#statsUser").data('account');
                }

                if (range == 'custom') {

                    // Make sure date selectors are visible
                    $('#customDates').show();

                    if (!customFrom || !customTo) {
                        alert("Please select a 'from' and 'to' date for custom date ranges");
                        return false;
                    }
                }


                $.ajax({
                    url: '<?php echo site_url('ajax/masterDashboardStats') ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        range: range,
                        user: user,
                        accountId: accountId,
                        customFrom: customFrom,
                        customTo: customTo,
                        branchId: branchId,
                        companyId:companyId,
                        company:company,
                        tabId: localStorage.getItem("dashboardTabIndex"),
                        filterType:filterType,
                        filterIds:filterIds

                    }
                })
                    .success(function (data) {

                        if(localStorage.getItem("dashboardTabIndex")==0){
                            // Total Value
                            $("#totalValueSF").html(data.readableTotalValue);
                            // Completed Pct
                            $("#completedPct").html(data.completedPct);
                            // Won Pct
                            $("#wonPct").html(data.wonPct);
                            // Lost Pct
                            $("#lostPct").html(data.lostPct);
                            // Open Pct
                            $("#openPct").html(data.openPct);
                            //Rollover Value
                            $("#rolloverValueSF").html(data.rolloverValue);
                            // Magic Number Value
                            $("#magicNumberValue").html(data.magicNumberValue);
                            // SF Values
                            $("#proposalCountSF").html(data.proposalCount);
                             // Completed
                            $("#completedValueSF").html(data.completedValueSF);
                            // Open
                            $("#openValueSF").html(data.openValueSF);
                            // Won
                            $("#wonValueSF").html(data.wonValueSF);
                            // Lost
                            $("#lostValueSF").html(data.lostValueSF);
                            
                        }else if(localStorage.getItem("dashboardTabIndex")==1){
                            // Total Value
                            $("#totalValue").html(data.readableTotalValue);
                             // Completed Value
                            $("#completedValue").html(data.completedValue);
                            // Average Value
                            $("#avgValue").html(data.avgValue);
                            // Won Value
                            $("#wonValue").html(data.wonValue);
                             // Lost Value
                            $("#lostValue").html(data.lostValue);
                            // Open Value
                            $("#openValue").html(data.openValue);
                            //Rollover Value
                            $("#rolloverValue").html(data.rolloverValue);
                            // Proposal Count
                            $("#proposalCount").html(data.proposalCount);
                            
                        }else if(localStorage.getItem("dashboardTabIndex")==2){
                            /*Leads data*/
                            $("#leadsCount").html(data.leadsCount);
                            $("#leadsActive").html(data.leadsActive);
                            $("#leadsAdded").html(data.leadsAdded);
                            $("#leadsConverted").html(data.leadsConverted);
                            $("#leadsCancelled").html(data.leadsCancelled);
                            $("#leadsNew").html(data.leadsNew);
                            $("#leadsCurrent").html(data.leadsCurrent);
                            $("#leadsOld").html(data.leadsOld);
                            $("#leadsAvgConversion").html(data.leadsAvgConversion);
                        }
                       

                        $("#dashboardTabsLoader").hide();
                        $("#dashboardDateRangeView").show();
                    });
            }

            var oTable;
            var oSFTable;
            var oLeadsTable;
            var oSalesTargetsTable;
            var btTable;
            var stTable;
            var oStatusTable;

            function updateTable() {
                
                // Separate function as this is used in both All Stats and User Views
                if(localStorage.getItem("dashboardTabIndex")==0){
                    //$('#statsTableLoadingSF').show();

                    if (typeof oSFTable !== 'undefined') {

                        oSFTable.ajax.reload();
                        return false;

                    }else{
                            
                        oSFTable = $("#userStatsTableSF").DataTable({
                            "bStateSave": true,
                            "ajax": {
                                "url": '<?php echo site_url('ajax/dashboardTableSF'); ?>',
                                "type": 'POST',
                                "data": buildTableData
                            },
                            "bJQueryUI": true,
                            "bPaginate": false,
                            "iDisplayLength": -1,
                            "aoColumns": [
                                {"sWidth": "100px"},                        // 0  User
                                {"bVisible": false, "type": "num"},        // 1 Magic Number Amt
                                {"iDataSort": 1},                         // 2 Magic Number Readable
                                {"bVisible": false, "type": "num"},        // 3 Int bid value
                                {"iDataSort": 3, "type": "html"},           // 4 Readable bid value
                                {"bVisible": false, "type": "num"},        // 5 Comp Bid Amt
                                {"iDataSort": 5},                           // 6 Readable Comp Amt
                                {"bVisible": false, "type": "num"},        // 7 Comp Bid Pct float
                                {"iDataSort": 7},                           // 8 Comp %
                                {"bVisible": false, "type": "num"},        // 9 Int Open value
                                {"iDataSort": 9},                           // 10 Readable Open Value
                                {"bVisible": false, "type": "num"},        // 11 Open Bid Pct float
                                {"iDataSort": 11},                          // 12 Open Bid %
                                {"bVisible": false, "type": "num"},        // 13 Won Bid Amt
                                {"iDataSort": 13},                          // 14 Readable Won Amount
                                {"bVisible": false, "type": "num"},        // 15 Won Bid Pct float
                                {"iDataSort": 15},                          // 16 Won Bid %
                                {"bVisible": false, "type": "num"},         // 17 Proposals Num
                                {"sClass": "dtCenter", "iDataSort": 17}    // 18 Num Proposals
                            ],
                            "fnInitComplete": function () {
                                setTimeout(function () {
                                    $("#statsTableSF").show();
                                }, 1500);

                                //$("#statsLoaderSF").hide();
                            },
                            "fnDrawCallback": function () {
                                $("#statsTableSF").show();
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                               // $('#statsTableLoadingSF').hide();
                            }
                        });

                    }
                }else if(localStorage.getItem("dashboardTabIndex")==1){

                    //$('#statsTableLoading').show();

                    if (typeof oTable !== 'undefined') {

                        oTable.ajax.reload();
                        return false;

                    }else{

                        
                        oTable = $("#userStatsTable").DataTable({
                            "bStateSave": true,
                            "ajax": {
                                "url": '<?php echo site_url('ajax/dashboardProposalCompanyBreakDownTable'); ?>',
                                "type": 'POST',
                                "data": getFilterCheckedCompanyData,
                            },
                            "bJQueryUI": true,
                            "bPaginate": false,
                            "iDisplayLength": -1,
                            "aoColumns": [
                                {"sWidth": "100px"},                        // 0  User
                                {"bVisible": false, "type": "num"},         // 1 Proposals Num
                                {"sClass": "dtCenter", "iDataSort": 1},     // 2 Num Proposals
                                {"bVisible": false, "type": "num"},        // 3 Bid value
                                {"iDataSort": 3, "type": "html"},           // 4 Readable bid value
                                {"bVisible": false, "type": "num"},        // 5 Int avf bid value
                                {"iDataSort": 5, "type": "html"},           // 6 Readable avg bid value
                                {"bVisible": false, "type": "num"},        // 7 Comp Bid Amt
                                {"iDataSort": 7},                           // 8 Readable Comp Amt
                                {"bVisible": false, "type": "num"},        // 9 Int Open value
                                {"iDataSort": 9},                           // 10 Readable Open Value
                                {"bVisible": false, "type": "num"},        // 11 Won Bid Amt
                                {"iDataSort": 11},                          // 12 Readable Won Amount
                                {"bVisible": false, "type": "num"},        // 13 Lost Bid Amt
                                {"iDataSort": 13}                          // 14 Readable Lost Amount
                            ],
                            "fnInitComplete": function () {
                                setTimeout(function () {
                                    $("#statsTable").show();
                                }, 1500);

                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                            },
                            "fnDrawCallback": function () {
                                $("#statsTable").show();
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                                //$('#statsTableLoading').hide();
                            }
                        });

                        $(oTable.column(0).header()).text('Company');

                    }

                }else if(localStorage.getItem("dashboardTabIndex")==2){
                    //$('#statsTableLoadingLeads').show();
                    
                    if (typeof oLeadsTable !== 'undefined') {
                        
                        oLeadsTable.settings()[0].jqXHR.abort();
                        oLeadsTable.ajax.reload();
                        return false;
                    }else{

                        oLeadsTable = $("#leadsStatsTable").DataTable({
                        "bStateSave": true,
                        "bAsync": true,
                        "ajax": {
                            "url": '<?php echo site_url('ajax/superDashboardTableLeads'); ?>',
                            "type": 'POST',
                            "data": getFilterCheckedCompanyData
                        },
                        "bJQueryUI": true,
                        "bPaginate": false,
                        "iDisplayLength": -1,
                        "fnInitComplete": function () {
                            setTimeout(function () {
                                $("#statsTableLeads").show();
                            }, 1500);

                            $("#dashboardTabsLoader").hide();
                            $("#dashboardDateRangeView").show();
                        },
                        "fnDrawCallback": function () {
                            $("#statsTableLeads").show();
                            $("#statsLoaderLeads").hide();
                            //$('#statsTableLoadingLeads').hide();
                            $("#dashboardTabsLoader").hide();
                            $("#dashboardDateRangeView").show();
                        }
                    });

                    }

                    $(oLeadsTable.column(0).header()).text('Company');

                }

                
            }
            
            function updateSalesTargetsTable() {

                if (oSalesTargetsTable) {
                    oSalesTargetsTable.ajax.reload();
                } else {
                    
                    oSalesTargetsTable = $("#salesTargetsStatsTable").on('processing.dt', function (e, settings, processing) {
                            if (processing) {
                               
                                $("#dashboardTabsLoader").show();
                                $("#dashboardDateRangeView").hide();
                                
                            } else {
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                               
                            }
                        }).DataTable({
                        "bJQueryUI": true,
                        "bPaginate": false,
                        "iDisplayLength": -1,
                        "searching": true,
                        "bInfo" : false,
                        "ajax": {
                            "url": '<?php echo site_url('ajax/dashboardTableMasterSalesTargets'); ?>',
                            "type": "POST",
                            "data": buildMasterTableData
                        },
                        "aoColumns": [
                            {},                                         // 0  User
                            {"bVisible": false, "type": "num"},         // 1 Smiley Int
                             {"iDataSort": 1, "className": "dtCenter"},  // 2 Smileys hide
                            
                            {"iDataSort": 14, "className": "dtCenter"},  // 3 Sales

                            {"className": "dtLeft"},  // 4 Target %

                            {"iDataSort": 6,"className": "dtLeft"},  // 5 Different amount

                            {"bVisible": false, "type": "num"},         // 6 $ Bid Int
                            
                            

                            {"iDataSort": 18, "className": "dtLeft"},  // 7 Open amount

                            {"bVisible": false, "type": "num"},         // 8 $ Bid Int
                            {"iDataSort": 8, "className": "dtCenter"},  // 9 $ Bid

                            {"iDataSort": 19,"className": "dtLeft"},  // 10 Other amount

                            {"iDataSort": 15, "className": "dtCenter"},  // 11 Win Rate

                            {"className": "dtCenter"},  // 12 Proposals

                            {"className": "dtCenter"},  // 13 Bid per day

                            
                            
                            {"bVisible": false, "type": "num"},         // 14 Sales Int

                            {"bVisible": false, "type": "num"},         // 15 Win Rate Int
                            

                            {"bVisible": false, "type": "num"},         // 16 Sales Target Int
                            {"iDataSort": 16, "className": "dtLeft"},   // 17 Sales Target Readable
                            {"bVisible": false, "type": "num"},//open num
                            {"bVisible": false, "type": "num"},//Other num
                        ],
                        "order": [[9, 'desc']],
                        "fnInitComplete": function () {
                            
                            $("#salesTargetsStatsTable_wrapper").show();
                            $("#salesTargetsStatsTable").show();
                        },
                        "fnDrawCallback": function () {
                            $("#statsLoaderSalesTargets").hide();
                            $("#statsTableSalesTargets").show();
                            initTiptip();
                            //$("#dashboardTabsLoader").hide();

                        }
                    });
                }

            }

            function updateBusinessTable(){
                if($('.business_table_breakdown.update-button').data('val')=='breakdown'){
                    
                    loadUserBusinessTypePie();
                               
                    if(stTable){
                        
                        stTable.ajax.reload(null,false );
                    }else{
                        initial_business_breakdown_load_table();
                    }
                }else{

                    if (btTable){
                        btTable.ajax.reload();
                    }else{
                        btTable = $('#salesBusinessStatsTable').on('error.dt', function (e, settings, techNote, message) {
                            console.log('An error has been reported by DataTables: ', message);
                            //$("#datatablesError").dialog('open');

                        })
                        .on('processing.dt', function (e, settings, processing) {
                            if (processing) {
                                $("#dashboardTabsLoader").show();
                                $("#dashboardDateRangeView").hide();
                                //$('#salesBusinessStatsTable_wrapper').hide();
                            } else {
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                                //$('#salesBusinessStatsTable_wrapper').show();
                            }
                        })
                        .DataTable({
                            "processing": true,
                            "serverSide": true,
                            "bJQueryUI": true,
                            "bPaginate": false,
                            "iDisplayLength": -1,
                            "searching": true,
                            "bInfo" : false,
                            "ajax": {
                                url: "<?php echo site_url('ajax/ajaxGetParentDashboardBusinessTypes');?>",

                                data: function(d) {
                                    // d.user = $("#statsUser").val();
                                    // d.accountId = $("#statsUser").find(':selected').data('account');
                                    // d.branchId = $("#statsUser").find(':selected').data('branch');
                                    d.filterType =  $('#filterType').val();
                                    d.filterIds =  $('#filterIds').val();
                                }
                            },
                           
                            "columnDefs": [
                            
                                {
                                    "targets": [0],
                                    "sortable": true,
                                    "width":'29%'
                                },
                                
                                {"targets": [1],"width":'8%', "sortable": true,'class': 'dtCenter'},
                                {"targets": [2],"width":'11%', "sortable": true, },
                                {"targets": [3],"width":'10%', "sortable": true,},
                                {"targets": [4],"width":'10%', "sortable": true},
                                {"targets": [5],"width":'10%', "sortable": true},
                                {"targets": [6], "width":'12%',"sortable": true},
                                
                            ],
                            "sorting": [
                                [2, "desc"]
                            ],
                            "jQueryUI": true,
                            "autoWidth": false,
                            "stateSave": true,
                            "scrollY": "70vh",
                            "scrollCollapse": true,
                            "paginationType": "full_numbers",
                            "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                            "lengthMenu": [
                                [10, 25, 50, 100, 200, 500, 1000],
                                [10, 25, 50, 100, 200, 500, 1000]
                            ],
                            "preDrawCallback": function( settings ) {

                                
                            },
                            "drawCallback": function(){
                                initTiptip();
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                                if(btTable){
                                    btTable.columns.adjust();
                                }
                                
                                $('.dataTables-business-types').show();
                                
                                
                            }

                            
                        });
                    }
                }


            }

            function buildTableData() {
                var aoData = {
                    "user": $("#statsUser").val(),
                    "accountId": $("#statsUser").find(':selected').data('account'),
                    "branchId": $("#statsUser").find(':selected').data('branch')
                };

                return aoData;
            }

            function buildMasterTableData() {

                var filterType =  $('#filterType').val();
                var filterIds =  $('#filterIds').val();
                var aoData = {
                    "filterType":filterType,
                    "filterIds":filterIds
                    };

                return aoData;
            }

            function getCheckedCompanyData() {

              
                var filterIds =  [];
                var j = 0;
                $('.companyCheck:checked').each(function(i){
                    if($(this).val() != '-1'){                    
                        filterIds[j] = $(this).val();
                        j++;
                    }
                });

                var aoData = {
                    "filterType":'Company',
                    "filterIds":filterIds
                    };

                return aoData;
            }

            function getFilterCheckedCompanyData() {

              
                var companyIds =  [];
                var j = 0;
                $('.companyCheck:checked').each(function(i){
                    if($(this).val() != '-1'){                    
                        companyIds[j] = $(this).val();
                        j++;
                    }
                });

                var filterType =  $('#filterType').val();
                var filterIds =  $('#filterIds').val();
                var aoData = {
                    "filterType":filterType,
                    "filterIds":filterIds,
                    "companyIds":companyIds
                    };

                return aoData;
            }

            

            $('#reload').click(function () {
                updateStats();
                return false;
            });


            // Load the Visualization API and the piechart package.
            google.load('visualization', '1', {
                'packages': ['corechart'], callback: function () {
                    //updateStats()
                    updateDateFilters();
                }
            });

            // Set a callback to run when the Google Visualization API is loaded.
            //google.setOnLoadCallback(updateStats());

            function drawDashboardPieChart() {

                var range = getSelectedRange();
                //var user = $("#statsUser").val();
                //var accountId = $("#statsUser").find(':selected').data('account');
                var customFrom = $("#customFrom").val();
                var customTo = $("#customTo").val();
                //var branchId = $("#statsUser").find(':selected').data('branch');
                var filterType =  $('#filterType').val();
                var filterIds =  $('#filterIds').val();

                // Get single user / non admin account value
                if (!accountId) {
                    var accountId = $("#statsUser").data('account');
                }

                




                $.ajax({
                    url: '<?php echo site_url('ajax/dashboardParentPie') ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        range: range,
                        filterType: filterType,
                        filterIds: filterIds,
                        customFrom: customFrom,
                        customTo: customTo
                    }
                }).success(function (data) {


                //data = JSON.parse(jsonData);


                if (!data.empty) {
                var Trows = data.table.rows;
                var colorArray = [];
                for($i=0;$i<Trows.length;$i++){
                    var found_color = $.grep(statusObject, function(v) {
                            return v.status_name === Trows[$i].c[0].v;
                        });
                        colorArray.push(found_color[0].status_color);
                }

                    $("#noPieData").hide();
                    $("#dashboardPie").show();

                    // Create our data table out of JSON data loaded from server.
                    var data = new google.visualization.DataTable(data.table);

                    var formatter = new google.visualization.NumberFormat(
                        {prefix: '$', pattern: '#,###,###'});
                    formatter.format(data, 1); // Apply formatter to second column

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById('dashboardPie'));

                    // Pie Chart Options
                    var options = {
                        width: 450,
                        height: 350,
                        chartArea: {
                            width: '100%',
                            height: '90%'
                        },
                        colors: colorArray,
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

                    chart.draw(data, options);
                } else {
                    $("#dashboardPie").hide();
                    $("#noPieData").show();
                }

                        
            });




            }

            // Dashboard Stats Tabs
            $("#dashboardTabs").tabs({
                active: localStorage.getItem("dashboardTabIndex"),
                activate: function (event, ui) {
                    if(hasLocalStorage){
                        localStorage.setItem("dashboardTabIndex", $(this).tabs('option', 'active'));
                    }
                    updateStats();
                    if( localStorage.getItem("dashboardTabIndex")!=3 && localStorage.getItem("dashboardTabIndex")!=4 && localStorage.getItem("dashboardTabIndex")!=5){
                        $('.statTypeSelector').css("visibility", "visible");
                    }else{
                        $('.statTypeSelector').css("visibility", "hidden");
                    }
                }
            });


        

        $(document).on('click','.business_table_breakdown',function(){
            $('.business_table_breakdown').removeClass('update-button');
           
            $(this).addClass('update-button');
            if($(this).attr('data-val')=='table'){
                $('#statsTableBusinessSales').show();
                
                $('.breakdown_box').hide();
                updateBusinessTable();
            }else{
                $('#statsTableBusinessSales').hide();
                $("#dashboardTabsLoader").show();
                $("#dashboardDateRangeView").hide();
                if(stTable){
                    stTable.ajax.reload(null,false );
                }else{
                    initial_business_breakdown_load_table();
                }
                loadUserBusinessTypePie();
                
                $('.breakdown_box').show();
            }
        });

        
function loadUserBusinessTypePie() {
    var aoData = {

                    "filterType" : $('#filterType').val(),
                    "filterIds" : $('#filterIds').val()
                };

            var jsonData = $.ajax({
                url: "/ajax/businessTypeParentDashboardInfoPie",
                dataType: "json",
                async: false,
                data: aoData,
                type: 'post',
                cache: false
            }).responseText;

            data = JSON.parse(jsonData);
            if (!data.empty) {
                var Trows = data.table.rows;
                
                

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable(data.table);

                var formatter = new google.visualization.NumberFormat(
                    {prefix: '$', pattern: '#,###,###'});
                formatter.format(data, 1); // Apply formatter to second column

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('userBusinessTypePie'));
                
                // Pie Chart Options
                var options = {
                    
                    width: 260,
                    height: 260,
                    chartArea: {
                        width: '90%',
                        height: '90%'
                    },
                    
                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.1,
                    legend: 'none',
                    animation: {
                        startup: true
                    }
                };

                chart.draw(data, options);
            }
            else {
                // $("#accountUserStatsPie").hide();
                // $("#noUserStatsPieData").show();
            }
            
    }

    
function initial_business_breakdown_load_table(){

stTable = $('#business_type_breakdown_table').DataTable({
    "processing": true,
    "serverSide": true,
    "searching":false,
    "lengthChange":false,
    "paging":false,
    "info":false,
    "ajax": {
            url: "<?php echo site_url('ajax/businessTypeBreakdownParentDashboardTable');?>",
            data: function(d) {
                d.filterType =  $('#filterType').val();
                d.filterIds =  $('#filterIds').val();
            }
        },
    

    
    "columns": [
        {width: '25%',class: 'dtLeft'},
        {width: '15%',class: 'dtLeft'},                                           // 3 Branch
        {width: '15%',class: 'dtCenter',"iDataSort": 2},       
        {width: '1%',class: 'dtCenter','visible':false}, //hide         
        {width: '15%',class: 'dtLeft'},                                   // 4 Readable status
        {width: '15%',class: 'dtLeft',"iDataSort": 4}, 
        {width: '1%',class: 'dtLeft','visible':false,},//hide                           // 5 Status Link
        {width: '15%',class: 'dtLeft'},
        
    ],
    "sorting": [
                [3, "desc"]
            ],
    
    "jQueryUI": true,
    "autoWidth": true,
    "stateSave": false,
    "paginationType": "full_numbers",
    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
    "drawCallback": function(){
        initTiptip();
        $("#dashboardTabsLoader").hide();
        $("#dashboardDateRangeView").show();
    } 
    
}); 

}

// add proposal functionality
    $("#addProposalDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 560,
            height:140,
            open: function(event, ui) {
                // Reset Dialog Position
                $(this).dialog('widget').position({ my: "center", at: "center", of: window });
            },
        });

        
        $(document).on('click', ".add_proposal_btn", function () {
            $('#add_proposal_contact_id_hidden').val('');
            $('#add_proposal_select_btn').hide();
            $("#addProposalDialog").dialog('open');
            setTimeout(function() {
                        $('#SeachcontactName').select2('open');
                        if($('.add_new_class').length<1){
                                $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="<?php echo  site_url();?>clients/add/proposal"  style="color: #25AAE1;font-size:14px;"><i class="fa fa-fw fa-plus"></i> Create New Contact</li></ul></span>');
                            }
                    }, 400);
        });

        $(document).on('click', "#add_proposal_select_btn", function () {
            var contact_id = $('#add_proposal_contact_id_hidden').val();
           if(contact_id){
             window.location.href = '<?php echo  site_url();?>proposals/add/'+contact_id;
           }
           
        });



//Select2 start

    $("#SeachcontactName").select2({
    ajax: {
        url: '<?php echo site_url('ajax/ajaxSelect2SearchClients') ?>',
        dataType: 'json',
        delay: 250,
        
        data: function (params) {
        return {
            startsWith: params.term, // search term
            firstName: '',
            lastName: '',
            page: params.page
        };
        },
        processResults: function (data, params) {
        
        params.page = params.page || 1;
        if($('.add_new_class').length<1){
            $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="javascript:void(0);" onclick="add_new_lead()" style="color: #25AAE1;">+ New Contact</li></ul></span>');
        }
        
        return {
            results: data.items,
            pagination: {
            more: (params.page * 30) < data.total_count
            }
        };
        

        //'<span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-SeachcompanyName-results" aria-expanded="true" aria-hidden="false"><li role="alert" aria-live="assertive" class="select2-results__option select2-results__message">+Add New</li></ul></span>';
        },
        cache: true
    },
    placeholder: 'Search for a repository',
    allowClear: true,
    debug: true,
    minimumInputLength: 1,
    language: {
        inputTooShort: function () { return ''; },
        noResults: function(){
            return "Contact Not Found";
        }
    },
    templateResult: formatRepo2,
    templateSelection: formatRepoSelection2
    });


function formatRepo2 (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      
      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Contact:</th><td class='select2-result-repository_contact'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Owner:</th><td class='select2-result-repository_owner'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Proposals:</th><td class='select2-result-repository_proposal'></td></tr>"+
      "</div>" +
    "</div>"
  );
  
  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_contact").text(repo.contact);
  $container.find(".select2-result-repository_address").html(repo.address);
  $container.find(".select2-result-repository_owner").text(repo.owner);
  $container.find(".select2-result-repository_proposal").html(repo.proposals_count);

  return $container;
}

    function formatRepoSelection2 (repo) {
    return '('+repo.label+') ' + repo.contact;
    }
$(".select2-selection__placeholder").text('Search ')

    $('#SeachcontactName').on("select2:selecting", function(e) { 
        // what you would like to happen
        $('#add_proposal_select_btn').show();
        var select_id = e.params.args.data.id;  
        $('#add_proposal_contact_id_hidden').val(select_id)
            event.preventDefault();
    });


            function updateStatusTable() {

                if (oStatusTable) {
                    oStatusTable.ajax.reload();
                } else {
                    oStatusTable = $("#StatusStatsTable").on('processing.dt', function (e, settings, processing) {
                            if (processing) {
                               
                                $("#dashboardTabsLoader").show();
                                $("#dashboardDateRangeView").hide();
                                
                            } else {
                                $("#dashboardTabsLoader").hide();
                                $("#dashboardDateRangeView").show();
                               
                            }
                        }).DataTable({
                        "jQueryUI": true,
                        "autoWidth": true,
                        "stateSave": true,
                        "scrollY": '90vh',
                        "scrollCollapse": true,
                        "scrollX": true,
                        "bPaginate": false,
                        "iDisplayLength": -1,
                        "searching": true,
                        "bInfo" : false,
                        "fixedColumns":   {
                            leftColumns: 1
                            
                        },
                        "ajax": {
                            "url": '<?php echo site_url('ajax/dashboardParentStatusTable'); ?>',
                            "type": "POST",
                            "data": buildMasterTableData
                        },
                        
                        "fnInitComplete": function () {
                            
                            $("#StatusStatsTable_wrapper").show();
                            $("#StatusStatsTable").show();
                            $("#dataTables_scrollHeadInner").show();
                        },
                        "fnDrawCallback": function () {
                            $("#statsLoaderSalesTargets").hide();
                           
                            $("#StatusStatsTableContainer").show();
                            initTiptip();

                        }
                    });
                }

            }


    $('.companyCheck').click(function() {
        
        var companyId  = $(this).val();
        if($(this).prop('checked')){
            
            //$('.companyCheck').not(this).prop('checked', false);
            if(companyId != '-1'){
                

                if((childCompanyCount == $(".companyCheck:checked").length) && (!$('#allCOmpanyCheck').prop('checked'))){
                    $('#allCOmpanyCheck').prop('checked',true);
                }
                
               // $('.branchCheckRow').hide();
                $('.branchCheck[data-company-id="'+companyId+'"]').prop('checked', true);
                $('.branchCheckRow[data-company-id="'+companyId+'"]').show();

                $('.userCheck[data-company-id="'+companyId+'"]').prop('checked', true);
                $('.userCheckRow[data-company-id="'+companyId+'"]').show();

                $('.branchCheckHR').show();
                $('.userCheckHR').show();
            }else{
                $('.companyCheck').prop('checked', true);
                $('.branchCheck').prop('checked', true);
                $('.userCheck').prop('checked', true);
                
                
                $('.branchCheckHR').show();
                $('.branchCheckRow').show();
                $('.userCheckRow').show();
                $('.userCheckHR').show();
            }
            

        }else{
            if(companyId == '-1'){
                $('.companyCheck').prop('checked', false);
                $('.branchCheck').prop('checked', false);
                $('.userCheck').prop('checked', false);
                $('.branchCheckRow').hide();
                $('.userCheckRow').hide();
                $('.userCheckHR').hide();
            }else{
                $('#allCOmpanyCheck').prop('checked',false);
                //$('.branchCheckRow[data-company-id="'+companyId+'"]').prop('checked', false);
                $('.branchCheckRow[data-company-id="'+companyId+'"]').hide();
                $('.userCheckRow[data-company-id="'+companyId+'"]').hide();
                $('.branchCheck[data-company-id="'+companyId+'"]').prop('checked', false);
                $('.userCheck[data-company-id="'+companyId+'"]').prop('checked', false);
               // $('.branchCheck[data-company-id="'+companyId+'"]').prop('checked', false);
               // $('.userCheck[data-company-id="'+companyId+'"]').prop('checked', false);
            }
            //$('.showCompanyName').text('All');
            
            // $('.userCheck').prop('checked', false);
            // $('.userCheckRow').hide();
            
 
        }
        if($(".companyCheck:checked").length == 1){
            $('.showCompanyName').text($(".companyCheck:checked").attr('data-company-name'));
            $('.showCompanyName').closest('.filterColumnHeader').addClass('blue_back');
            
        }else if($(".companyCheck:checked").length == $(".companyCheck").length){
            $('.showCompanyName').text('All');
            $('.showCompanyName').closest('.filterColumnHeader').removeClass('blue_back');
        }else{
            $('.showCompanyName').text('['+$(".companyCheck:checked").length+']');
            $('.showCompanyName').closest('.filterColumnHeader').addClass('blue_back');
        }

        if($(".branchCheckRow:visible").length == 0){
                $('.branchCheckHR').hide();
            }
        
        $.uniform.update();
       
        updateFilter();
    }); 


    $('.branchCheck').click(function() {
        var branchId  = $(this).val();
        var companyId  = $(this).attr('data-company-id');
        if($(this).prop('checked')){
           
            
            //$('.branchCheck').not(this).prop('checked', false);
            //if(branchId != '0'){
                //$('.userCheckRow').hide();
                $('.userCheck[data-company-id="'+companyId+'"][data-branch-id="'+branchId+'"]').prop('checked', true);
                $('.userCheckRow[data-company-id="'+companyId+'"][data-branch-id="'+branchId+'"]').show();

                $('.userCheckHR').show();
            // }else{
            //     $('.userCheckRow').hide();
            // }
        }else{
            
            $('.userCheckRow[data-company-id="'+companyId+'"][data-branch-id="'+branchId+'"]').hide();
            $('.userCheck[data-company-id="'+companyId+'"][data-branch-id="'+branchId+'"]').prop('checked', false);
            if($(".branchCheckRow:visible").length == 0){
                $('.userCheckHR').hide();
            }
        }
        $.uniform.update();

        updateFilter();
    }); 

    $('.userCheck').click(function() {
        updateFilter();
    }); 
    
    
    function updateFilter(){


                filterType = '';
                filterIds = [];

                
                if($(".userCheck:checked").length == $(".userCheck").length && $(".branchCheck:checked").length == $(".branchCheck").length && $(".companyCheck:checked").length == $(".companyCheck").length){
                    filterType = 'all';
                    filterIds = getChildCompanyIds();
                }else{

                   
                    
                    if($(".userCheck:checked").length != $(".userCheck:visible").length){
                                // filterType = 'branch';
                                // $('.branchCheck:checked').each(function(i){
                                //     filterIds[i] = $(this).attr('data-company-id')+'_'+$(this).val();
                                // });

                                filterType = 'user';
                                        $('.userCheck:checked').each(function(i){
                                                filterIds[i] = $(this).val();
                                            });

                        }else{

                                if($(".branchCheck:checked").length == $(".branchCheck:visible").length){
                                    filterType = 'company';
                                    $('.companyCheck:checked').each(function(i){
                                        //var c_id = $(this).attr('data-company-id');
                                        filterIds[i] = $(this).val();
                                    });
                                    
                                }else{

                                    
                                        // filterType = 'user';
                                        // $('.userCheck:checked').each(function(i){
                                        //         filterIds[i] = $(this).val();
                                        //     });

                                     filterType = 'branch';
                                     $('.branchCheck:checked').each(function(i){
                                         filterIds[i] = $(this).attr('data-company-id')+'_'+$(this).val();
                                     });


                                    }
                        }
                        
                    
                }

                $('#filterType').val(filterType);
                $('#filterIds').val(filterIds);
                updateStats();
                drawDashboardPieChart();

    }
    

    $("#parentCompanyFilter").click(function () {
        // console.log('dddd')
        $(".filterColumnWide").addClass('filterCollapse');
        $(".filterColumn").not($(this).parents('.filterColumn')).addClass('filterCollapse');
        $(this).parents('.filterColumn').toggleClass('filterCollapse');
    
        
        setTimeout(function () {
            console.log('test');
            initTiptip();
                 }, 2500);
        
        ;
    });

    $("#selected_company_stats").change(function () {
        if($(this).val() ==0){
            $('.company_filter').show();
            $('#filterType').val('all');
            $('#filterIds').val(getChildCompanyIds());

        }else{
            $('.company_filter').hide();
            $('#filterType').val('company');
            $('#filterIds').val($(this).val());
        }

        updateStats();
    });

    function getChildCompanyIds(){
        
        var searchIDs = $(".companyCheckIds").map(function(){
            return $(this).val();
        }).get(); 
        return searchIDs;
    }

    $("body").click( function(event) {
        var $trigger = $("#parentCompanyFilter");

        if(!event.target.classList.contains('filterColumnCheck') ){
            if(!$(event.target).parents('.filterColumnScroll').length==0 ){
                return false;
            }

            if("parentCompanyFilter" !== event.target.id && !$trigger.has(event.target).length){
          
                    //$(".groupActionsContainerResend").hide();
                    $('#parentCompanyFilter').parents('.filterColumn').addClass('filterCollapse')
            
            }
        }


       
   });
           
 
 

//code start here

//create a csv upload function 
$('#exportProposal').on('click', function(e) {
        var filterType =  $('#filterType').val();
        var filterIds =  $('#filterIds').val();
        var range = $("#statRange").find(':selected').data('range');
        var user = $("#statsUser").val();
        var accountId = $("#statsUser").find(':selected').data('account');
        var customFrom = $("#customFrom").val();
        var customTo = $("#customTo").val();
        var branchId = $("#statsUser").find(':selected').data('branch');
        var companyId = $("#statsUser").find(':selected').data('company');
        var company = $('.companyCheck:checked').val();
        $("#dashboardTabsLoader").show();
        // Get single user / non admin account value
        if (!accountId) {
            var accountId = $("#statsUser").data('account');
        }
        if (range == 'custom') {
            // Make sure date selectors are visible
            $('#customDates').show();
            if (!customFrom || !customTo) {
                alert("Please select a 'from' and 'to' date for custom date ranges");
                return false;
            }
        }
            $.ajax({
                url: '/dashboard/proposal_data_extract', // Assuming your PHP script is named export_proposal.php
                type: 'POST',
                data: {
                    customFrom: customFrom,
                    customTo: customTo,
                    range:range,
                    accountId:accountId,
                    filterType:filterType,
                    branchId: branchId,
                    companyId:companyId,
                    filterIds:filterIds,
                    company:company,
                    tabId: localStorage.getItem("dashboardTabIndex"),

                }, // Removed 'range' since it's not defined in your code snippet
                success: function(data) {
                    console.log("data",data);
                    swal({
                            type: 'info',
                            title: 'Export Requested',
                            html: '<p>Your report is cooking! It might take a while until it is done, but you will be notified via email!</p>',
                            showCloseButton: true,
                        });
                    $("#dashboardTabsLoader").hide();

                },
                error: function(xhr, status, error) {
                    // Handle error response here
                }
            });
        e.preventDefault();
        });

//code close here

 
}); 
    </script>

    <!--#content-->
<?php 
$this->load->view('templates/clients/table/add-contact-popup');
$this->load->view('global/footer') ?>