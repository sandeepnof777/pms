<?php $this->load->view('global/header-super-user') ?>
<style>
    .dataTables-history-new {
        table-layout: fixed;
        width: 100% !important;
    }

    .paging_full_numbers {
        width: 500px !important;
    }

    .dataTables_info {
        width: 46% !important;
        clear: none !important;
    }

</style>
<input type="hidden" id="delayUI" value="1"/>
<div id="content" class="clearfix">
    <div class="widthfix">
        <p style="padding: 5px 0px;float: right;">
            <!-- <label><strong>Date Filter:</strong></label> -->
            <input type="hidden" id="hCreatedFrom">
            <input type="hidden" id="hCreatedTo">
            
            
            <select name="actionParent" id="actionParent" class="pull-right" style="margin-right: 10px;">
                <option value="0">All Actions</option>
               <?php
                foreach($actionTypes as $action){
                 echo '<option value="'.$action->getId().'">'.$action->getActivityActionName().'</option>';
                }?>
            </select>
            <select name="actionChild" id="actionChild" disabled class="pull-right">
            </select>
            <select id="createdPreset">
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last7days">Last 7 Days</option>
                <option value="monthToDate">Month To Date</option>
                <option value="previousMonth">Previous Month</option>
                <option value="last12month">Last 12 Months</option>
                <option value="yearToDate">Year To Date</option>
                <option value="previousYear">Previous Year</option>
                <option value="alltime">All Time</option>
            </select>
        </p>
        <div class="clearfix"></div>
        <div class="content-box clearfix">
            <div class="box-header">History <?php if ($this->uri->segment(3)) {
                    echo 'for ' . $user->getFullName();
                } ?>
            </div>

            <div class="tableLoader" style="width: 150px; display: none; position: absolute; left: 421px; top: 8px;">
                <img src="/static/loading-bars.svg">
            </div>

            <div class="box-content">

                <table cellpadding="0" cellspacing="0" id="dataTables-history-new" border="0"
                       class="dataTables-history-new display">
                    <thead>
                    <tr>
                        <td width="140">Date</td>
                        <td>Timestamp</td>
                        <td>User</td>
                        <td>IP Address</td>
                        <td>Contact</td>
                        <td>Proposal</td>
                        <td>Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="datatablesError" title="Error" style="text-align: center; display: none;">
    <h3>Oops, something went wrong</h3>

    <p>We're having a problem loading this page.</p><br/>
    <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact
            support</a> if this keeps happening.</p>
</div>
<script type="text/javascript">

    $(document).ready(function () {

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
    });
</script>
<script type="text/javascript">

    var ui = false;
    $(document).ready(function () {

        $('#createdPreset').val('last12month');
        var preset = datePreset('last12month');
        $("#hCreatedFrom").val(preset.startDate);
        $("#hCreatedTo").val(preset.endDate);
        var hTable;


        <?php $ajaxUrl = ($this->uri->segment(2) == 'super_user' && $this->uri->segment(3)) ? 'ajax/history/' . $this->uri->segment(3) : 'ajax/history' ?>

        $.fn.dataTable.ext.errMode = 'none';

        function initTable() {
            hTable = $('.dataTables-history-new').on('error.dt', function (e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
                $("#datatablesError").dialog('open');
            })
                .on('processing.dt', function (e, settings, processing) {
                    if (processing) {
                        $(".tableLoader").show();
                    } else {
                        $(".tableLoader").hide();
                    }
                })
                .DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo site_url($ajaxUrl); ?>",
                    "columnDefs": [
                        {
                            "targets": [0],
                            "searchable": true,
                            "sortable": true,
                            "orderData": 1,
                            "width": '15%'
                        },
                        {"targets": [1], "visible": false, "width": '10%'},
                        {"targets": [2], "sortable": true, "width": '10%'},
                        {"targets": [3], "sortable": true, "width": '10%'},
                        {"targets": [4], "sortable": true, "width": '10%'},
                        {"targets": [5], "sortable": true, "width": '10%'},
                        {"targets": [6], "sortable": true, "type": "html", "width": '35%'},
                    ],
                    "sorting": [
                        [0, "desc"]
                    ],
                    "jQueryUI": true,
                    "autoWidth": false,
                    "stateSave": true,
                    "paginationType": "full_numbers",
                    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                    "lengthMenu": [
                        [10, 25, 50, 100, 200, 500, 1000],
                        [10, 25, 50, 100, 200, 500, 1000]
                    ],
                    "preDrawCallback": function( settings ) {
                        if ($.fn.DataTable.isDataTable('.dataTables-history-new')) {
                            var dt = $('.dataTables-history-new').DataTable();

                            //Abort previous ajax request if it is still in process.
                            var settings = dt.settings();
                            if (settings[0].jqXHR) {
                                settings[0].jqXHR.abort();
                            }
                        }
                    },
                    "drawCallback": function (settings) {
                        if (!ui) {
                            initUI();
                            ui = true;
                            $.uniform.update();
                        }

                    }
                });
        }

        applyFilter();

        $("#createdPreset").change(function () {

            var selectVal = $(this).val();

            if (selectVal) {

                if (selectVal == 'alltime') {
                    $("#hCreatedFrom").val('');
                    $("#hCreatedTo").val('');
                } else {


                    var preset = datePreset(selectVal);
                    $("#hCreatedFrom").val(preset.startDate);
                    $("#hCreatedTo").val(preset.endDate);

                }
                applyFilter();
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
                case 'alltime':
                    startDate = '';
                    endDate = '';
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
                case 'last12month':
                    startDate = moment().subtract(12, 'month').startOf('month');
                    endDate = moment();
                    break;
            }

            var presetDate = {
                startDate: startDate.format('MM/DD/YYYY'),
                endDate: endDate.format('MM/DD/YYYY')
            };

            return presetDate;

        }


        function applyFilter() {

            setTimeout(function () {


                // Created Range
                var hCreatedFrom = $("#hCreatedFrom").val();
                var hCreatedTo = $("#hCreatedTo").val();

                var hActionParent = $("#actionParent").val();
                var hActionChild = $("#actionChild").val();

                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('ajax/setHistoryFilter') ?>',
                    data: {

                        hFilterFrom: hCreatedFrom,
                        hFilterTo: hCreatedTo,
                        hActionParent: hActionParent,
                        hActionChild: hActionChild,

                    },
                    dataType: 'JSON',
                    success: function () {
                        updateTable();
                    }
                });
            }, 500);
        }

        function updateTable() {

            if ($.fn.DataTable.isDataTable('#dataTables-history-new')) {
                hTable.ajax.reload();
            } else {
                initTable();
            }

        }





        function updateFilterDropdowns() {
                if ($("#actionParent").val() > 0) {
                    $("#actionChild").prop('disabled', false);
                    $("#actionChild").html('<option value="0">All</option>');
                    switch($("#actionParent").val()) {
                    <?php foreach ($actionTypes as $actionType){?>
                        case "<?=$actionType->getId();?>":
                            <?php foreach ($actions as $action){
                                   if ($action->getParentId() == $actionType->getId()){?>
                                    $("#actionChild").append('<option value="<?=$action->getId();?>"><?=$action->getActivityActionName();?></option>');
                                <?php }
                            }
                            ?>
                        break;
                    <?php } ?>
                    }
                }else{
                    $("#actionChild").prop('disabled', 'disabled');
                    $("#actionChild").html('<option value="0">Select Action Type</option>');
                }
            }
            
            
            
            updateFilterDropdowns();

             $("#actionParent").on('change', function() {
                 updateFilterDropdowns();
                 applyFilter();
             });

             
             $("#actionChild").on('change', function() {
                applyFilter();
             });

















    });
</script>

<?php $this->load->view('global/footer'); ?>
