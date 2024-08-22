<?php $this->load->view('global/header'); ?>
<style>
.rightbox {
    position: relative;
    display:inline-block;
    overflow:hidden;
    width:0;
    height:15px;
    vertical-align:top;
    transition: width 0.5s;
}
.badge_content{
    width:100px;
    position:absolute;
    left:0;
    top:0;
}
#filterListNew ul li:hover > .created_badge {  width: 49px; }
#filterListNew ul li:hover > .user_badge {  width: 35px; }
#filterListNew ul li:hover > .branch_badge {  width: 45px; }
#filterListNew ul li:hover > .status_badge {  width: 43px; }
#filterListNew ul li:hover > .account_badge {  width: 52px; }
#filterListNew ul li:hover > .business_badge {  width: 90px; }
#filterListNew ul li{
    display:inline;
    background-color: #ccc;
    padding: 5px;
    padding-left: 0;
    margin-right: 10px;
    border-radius: 5px;
}
#filterListNew ul{
   
    padding: 5px 0px;
   
}

#filterListNew ul li .badge-icon{
    padding: 5px;
    background-color: #000;
    color: #fff;
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;

}

#filterListNew ul li strong{
    padding: 5px 5px 5px 0px;
   
}

.filterColumnDisable {
    float: left;
    width: 311px;
    border-radius: 10px;
    margin: 0 1px;
}
.filterColumnDisable .filterColumnHeader{
    background: #bdbaba;
}

.filterColumnDisable.filterCollapse .filterColumnRow,
.filterColumnDisable.filterCollapse .filterColumnScroll,
.filterColumnDisable.filterCollapse .filterSearchBar,
.filterColumnDisable.filterCollapse .filterColumnRowContent {
    display: none;
}
.filterColumnWideDisable {
    float: left;
    width: 312px;
    background-color: #dcdcdc;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}

.filterColumnWideDisable.filterCollapse .filterColumnRow,
.filterColumnWideDisable.filterCollapse .filterColumnScroll,
.filterColumnWideDisable.filterCollapse .filterSearchBar,
.filterColumnWideDisable.filterCollapse .filterColumnRowContent {
    display: none;
}
</style>
    <div id="content" class="clearfix">
        <div id="newFilter">
            <div class="clearfix">
                
                <div id="filterListNew">

                    <ul>

                    <?php
                        // Created Dates
                        if ($this->session->userdata('pStatsFilterFrom')) { ?>
                        <li><span class="badge-icon"><i class="fa fa-fw fa-calendar"></i></span>
                        <?php if($this->uri->segment(5) != 'won'){
                              if($this->uri->segment(6) != 'won'){?>
                                <span class="rightbox created_badge">
                                <span class="badge_content"><strong>Created: </strong></span>
                                    
                                </span>
                        <?php } }?>
                            <strong><?php
                                if($this->uri->segment(5) == 'won' || $this->uri->segment(6) == 'won'){echo 'Won: ';}
                                if($created_preset && $created_preset !='custom'){
                                    echo $created_preset;
                                }else{
                                    echo $this->session->userdata('pStatsFilterFrom') .' - '. $this->session->userdata('pStatsFilterTo'); ?>
                                <?php }?>    
                            </strong>
                        
                        </li>
                    <?php }?> 
<?php if( $this->session->userdata('pStatsFilterUserName')){?>
                    <li><span class="badge-icon"><i class="fa fa-fw fa-user"></i></span>
                                <span class="rightbox user_badge">
                                    <span class="badge_content"><strong>User:</strong></span>
                                </span>
                    <strong><?php echo $this->session->userdata('pStatsFilterUserName'); ?></strong></li>
                    <?php }?> 
                <?php    if($this->session->userdata('pStatsFilterStatusNameShow')){?>
                        <li><span  class="badge-icon"><i class="fa fa-fw fa-bar-chart"></i></span>
                        <span class="rightbox status_badge">
                                    <span class="badge_content"><strong>Status:</strong></span>
                                </span>
                        <strong><?php echo $this->session->userdata('pStatsFilterStatusNameShow'); ?></strong></li> 
                    
                <?php  }else if($this->session->userdata('pStatsFilterStatusName')){?>
                        <li><span  class="badge-icon"><i class="fa fa-fw fa-bar-chart"></i></span>
                        <span class="rightbox status_badge">
                                    <span class="badge_content"><strong>Status:</strong></span>
                                </span>
                        <strong><?php echo ucfirst($this->session->userdata('pStatsFilterStatusName')); ?></strong></li> 
                    
                <?php  } ?>

                <?php    if($this->session->userdata('pStatsFilterClientAccount')){?>
                    <li><span  class="badge-icon"><i class="fa fa-fw fa-address-card"></i></span>
                            <span class="rightbox account_badge">
                                    <span class="badge_content"><strong>Account:</strong></span>
                                </span>
                    <strong><?= $client_account->getName();?></strong></li>
                <?php  } ?>
                <?php    if($this->session->userdata('pStatsFilterBusinessType')){?>
                    <li><span  class="badge-icon"><i class="fa fa-fw fa-briefcase"></i></span>
                            <span class="rightbox business_badge">
                                    <span class="badge_content"><strong>Business Type:</strong></span>
                                </span>
                    <strong><?= $business->getTypeName();?></strong></li>
                <?php  } ?>

                <?php if( $this->session->userdata('pStatsFilterBranchName')){?>
                    <li><span class="badge-icon"><i class="fa fa-fw fa-users"></i></span>
                                <span class="rightbox branch_badge">
                                    <span class="badge_content"><strong>Branch:</strong></span>
                                </span>
                    <strong><?php echo $this->session->userdata('pStatsFilterBranchName'); ?></strong></li>
                    <?php }?> 
                    </ul>
                </div>

                
            </div>
   
            


            <div id="" style="float: left;width: 100%;margin:5px 0px">
                <div class="clearfix">
                    <?php
                    
                    if ($action != 'search') {
                        $this->load->view('templates/proposals/filters/new-proposal-filters');
                    } ?>
                </div>
                <input type="hidden" id="pageAction" value="<?php echo $action; ?>"/>
                <input type="hidden" id="group" value="<?php echo $group; ?>"/>
                <input type="hidden" id="search" value="<?php echo $search; ?>"/>

                <div class="filterOverlay"></div>
            </div>  
        </div>
        <div class="clearfix"><?php
            //debug
            //echo '<pre>';
            //print_r($this->session->all_userdata());
            //echo '</pre>';
            ?></div>


        <div class="content-box">
            <div class="box-header">

                <div id="proposalsTableLoader" style="width: 150px; float: left; display: none; margin-left: 413px;">
                    <img src="/static/loading-bars.svg" />
                </div>
                    <!--<span id="proposals-box-name" style="color: #E6E8EB;">Proposals</span>-->
                    <?php
                    if (help_box(4)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(4, true) ?></div>
                        <?php
                    }
                    ?>

                <!--            <a class="box-action tiptip blue" title="View Proposals in Queue" href="#">Proposal Queue</a>-->
                <!-- <a class="box-action tiptip" href="<?php echo site_url('clients') ?>" title="Add New Proposal">Add
                    Proposal</a>
                <a class="box-action tiptip" href="<?php echo site_url('proposals') ?>" title="View All Proposals">All
                    Proposals</a> -->

                <div class="clearfix"></div>
            </div>
            <div class="box-content" style="overflow-y: scroll; overflow-y: hidden;">
                <div id="proposalsTableContainer">
                    <?php $this->load->view('templates/proposals/table/table'); ?>
                </div>
                <div id="proposalsMapContainer" style="display: none; position: relative;">
                    <?php $this->load->view('templates/proposals/map/info'); ?>
                    <?php $this->load->view('templates/proposals/map/map'); ?>
                </div>
            </div>


            <div style="display: none" id="qbLoading">
                <p style="text-align: center; margin-bottom: 20px;">Communicating with QuickBooks</p>
                <p style="text-align: center"><img src="/static/loading_animation.gif"/></p>
            </div>

        </div>
        <?php
        $this->load->view('templates/proposals/table/table-js');
        ?>


        <script type="text/javascript">

            $(document).ready(function () {

                var dates = $("#from, #to").datepicker({
                    changeYear: true,
                    changeMonth: true,
                    defaultDate: "+1w",
                    numberOfMonths: 1,
                    onSelect: function (selectedDate) {
                        var option = this.id == "from" ? "minDate" : "maxDate",
                            instance = $(this).data("datepicker"),
                            date = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings);
                        dates.not(this).datepicker("option", option, date);
                    }
                });
                var dates = $("#changeFrom, #changeTo").datepicker({
                    changeYear: true,
                    changeMonth: true,
                    defaultDate: "+1w",
                    numberOfMonths: 1,
                    onSelect: function (selectedDate) {
                        var option = this.id == "from" ? "minDate" : "maxDate",
                            instance = $(this).data("datepicker"),
                            date = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings);
                        //dates.not(this).datepicker("option", option, date);
                    }
                });
                $("#filter-dialog").dialog({
                    modal: true,
                    buttons: {
                        Apply: function () {
                            $("#filter-form").submit();
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false,
                    width: 700
                });
                $("#filter").click(function () {
                    $("#filter-dialog").dialog('open');
                });
                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: 500,
                    values: [75, 300],
                    slide: function (event, ui) {
                        $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                    }
                });
                $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
                $("#alldates, #allDates").click(function () {
                    <?php
                    $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
                    $startDate = date('m/d/Y', $companyStart);
                    $endDate = date('m/d/Y');
                    ?>
                    $("#from").val('<?php echo $startDate ?>');
                    $("#to").val('<?php echo $endDate ?>');
                    return false;
                });
                $("#allChangeDates").click(function () {
                    <?php
                    $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
                    $startDate = date('m/d/Y', $companyStart);
                    $endDate = date('m/d/Y');
                    ?>
                    $("#changeFrom").val('<?php echo $startDate ?>');
                    $("#changeTo").val('<?php echo $endDate ?>');
                    return false;
                });
                $("#confirm-delete-message").dialog({
                    width: 400,
                    modal: true,
                    buttons: {
                        Ok: function () {
                            $.get('<?php echo site_url('proposals/delete') ?>/' + $("#client-delete").attr('rel'));
                            $("#delete_proposal_" + $("#client-delete").attr('rel')).parents('tr').fadeOut('slow');
                            $(this).dialog("close");
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });
                $(".confirm-deletion").live('click', function () {
                    $("#client-delete").attr('rel', $(this).attr('rel'));
                    $("#confirm-delete-message").dialog('open');
                    return false;
                });

                $("#notes-client").dialog({
                    modal: true,
                    buttons: {
                        Close: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false,
                    width: 700
                });

                $(".client-notes").live('click', function () {
                    var id = $(this).attr('rel');
                    var frameUrl = '<?php echo site_url('account/notes/client') ?>/' + id;
                    $("#notesFrame-client").attr('src', frameUrl);
                    $("#relationId-client").val(id);
                    $('#notesFrame-client').load(function () {
                        $("#notes-client").dialog('open');
                    });
                });

                $("#add-note-client").submit(function () {
                    var request = $.ajax({
                        url: '<?php echo site_url('ajax/addNote') ?>',
                        type: "POST",
                        data: {
                            "noteText": $("#noteText-client").val(),
                            "noteType": 'client',
                            "relationId": $("#relationId-client").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                //refresh frame
                                $("#noteText-client").val('');
                                $('#notesFrame-client').attr('src', $('#notesFrame-client').attr('src'));
                            } else {
                                if (data.error) {
                                    alert("Error: " + data.error);
                                } else {
                                    alert('An error has occurred. Please try again later!')
                                }
                            }
                        }
                    });
                    return false;
                });
                $("#services_dropdowns").hide();
                $("#AllServices").attr('checked', 'checked');
                $("#buttonset2 input").change(function () {
                    if ($(this).val() == '1') {
                        $("#services_dropdowns").show();
                    } else {
                        $("#services_dropdowns").hide();
                    }
                });


                $("#reset-filter, .filterButton.reset").click(function () {


                    resetFilters();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('ajax/resetProposalStatusFilter') ?>',
                        success: function () {
                            $("#reset-filter").hide();
                            $("#All").attr('checked', 'checked');
                            $("#allusers").attr('checked', 'checked');
                            $("#service option:first").attr('selected', 'selected');
                            $("#from, #to").val('');
                            $.uniform.update();
//                    initProposals();
                            document.location.reload();
                            $("#proposals-filter-box-name").html('Proposals Filter');
                        }
                    });
                    return false;
                });

                function resetDuplicateDialog() {
                    $("#duplicate-selected-client").hide().find('strong').html('');
                    $("#duplicate-select-client").show().find('input').val('');
                    $(":button:contains('Duplicate')").prop("disabled", true).addClass("ui-state-disabled");
                }

                function resetCopyDialog() {
                    $("#copy-selected-client").hide().find('strong').html('');
                    $("#copy-select-client").show().find('input').val('');
                    $(":button:contains('Copy')").prop("disabled", true).addClass("ui-state-disabled");
                }

                $("#duplicate-proposal").dialog({
                    width: 550,
                    modal: true,
                    open: function () {
                        //reset stuff
                        resetDuplicateDialog();
                    },
                    buttons: {
                        Duplicate: function () {
                            document.location.href = '<?php echo site_url('proposals/duplicate_proposal') ?>/' + $("#duplicate-proposal-id").val() + '/' + $("#duplicate-client-id").val();
                            $(this).dialog("close");
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });
                $("#copy-proposal").dialog({
                    width: 550,
                    modal: true,
                    open: function () {
                        //reset stuff
                        resetDuplicateDialog();
                    },
                    buttons: {
                        Copy: function () {
                            document.location.href = '<?php echo site_url('proposals/copy') ?>/' + $("#copy-proposal-id").val() + '/' + $("#copy-client-id").val();
                            $(this).dialog("close");
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });
                $(".duplicate-proposal").live('click', function () {
                    $("#duplicate-proposal-id").val($(this).attr('rel'));
                    $("#duplicate-proposal").dialog('open');
                    return false;
                });
                $(".copy-proposal").live('click', function () {
                    $("#copy-proposal-id").val($(this).attr('rel'));
                    $("#copy-proposal").dialog('open');
                    return false;
                });
                $("#duplicate-client").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                maxRows: 12,
                                startsWith: request.term
                            },
                            success: function (data) {
                                response($.map(data, function (item) {
                                        return {
                                            label: item.label,
                                            value: item.value
                                        }
                                    }
                                ));
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        $("#tiptip_holder").fadeOut('fast');
                        $("#duplicate-client-id").val(ui.item.value);
                        $("#duplicate-selected-client").show().find('strong').html(ui.item.label);
                        $("#duplicate-select-client").hide();
                        $(":button:contains('Duplicate')").prop("disabled", false).removeClass("ui-state-disabled");
                        event.preventDefault();
                    },
                    open: function () {
                        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                    },
                    close: function () {
                        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                });
                $("#copy-client").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "<?php echo site_url('ajax/ajaxSearchClients') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                maxRows: 12,
                                startsWith: request.term
                            },
                            success: function (data) {
                                response($.map(data, function (item) {
                                        return {
                                            label: item.label,
                                            value: item.value
                                        }
                                    }
                                ));
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        $("#tiptip_holder").fadeOut('fast');
                        $("#copy-client-id").val(ui.item.value);
                        $("#copy-selected-client").show().find('strong').html(ui.item.label);
                        $("#copy-select-client").hide();
                        $(":button:contains('Copy')").prop("disabled", false).removeClass("ui-state-disabled");
                        event.preventDefault();
                    },
                    open: function () {
                        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                    },
                    close: function () {
                        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                });
                $("#reset-duplicate-client-search").click(function () {
                    resetDuplicateDialog();
                });
                $("#reset-copy-client-search").click(function () {
                    resetCopyDialog();
                });


                //view client details functionality

                $("#dialog-message").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        Close: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false,
                    beforeClose: function (event, ui) {
                        $("#dialog-message span").html('');
                    }
                });
                $('.viewClient').live('click', function () {
                    var clientId = $(this).attr('rel');
                    $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + clientId, function (data) {
                        var items = [];
                        $.each(data, function (key, val) {
                            $("#field_" + key).html(val);
                        });
                    });
                    $("#dialog-message").dialog("open");
                });

                <?php
                // Statuses for dropdown
                $jsonStatuses = [];

                foreach ($statuses as $status) {
                    $jsonStatuses['_' . $status->getStatusId()] = $status->getText();
                }

                ?>

                function initStatusChange() {
                    $('.change-proposal-status').each(function () {
                        var id = $(this).attr('id');
                        id = id.replace(/status_/g, '');
                        var url = '<?php echo site_url('ajax/changeProposalStatus') ?>/' + id;
                        var status = 'Click to Edit';
                        $(this).editable(url, {
                            //data: "{'Open':'Open','Won':'Won','Completed':'Completed','Lost':'Lost','Cancelled':'Cancelled','On Hold':'On Hold', 'Invoiced via QuickBooks':'Invoiced via QuickBooks'}",
                            data: <?php echo json_encode($jsonStatuses); ?>,
                            type: 'select',
                            onblur: 'submit'
                        });
                    });

                }

                /**
                 *  Now that the same datasource is in use, some settings need to be applied based on the page
                 */
                function tableSettings() {

                    if ($("#group").val() == 'group') {
                        // Populate the toolbar
                        $("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');

                    }
                }

                /*New Filter Code*/
                function closeFilters() {
                    $("#newFilter .trigger").removeClass('active');
                    $(".filter-code").hide();
                    $(".filterOverlay").hide();
                }

                //updates branch users -- hides the users that are not needed when a branch is selected.
                function updateBranchUsers() {
                    //show all
                    $(".branchUser").show();
                    if (($("#filterBranchValue").val() != 'All') && ($("#filterBranchValue").val() != '')) {
                        var userClass = 'branch_' + $("#filterBranchValue").val();
//                console.log('userClass:' + userClass);
                        //hide users that do not belong
                        $(".branchUser:not(." + userClass + ")").hide();
                        //reset user filter selector
                        $("#userFilter").removeClass('filterActive');
                        $("#userFilter .trigger").text('User: All');
                    } else {
//                console.log('NOUP');
                    }
                }

//        updateBranchUsers();
                closeFilters(); //init with all filters closed to prevent the browser refresh cache

                function resetFilters() {
                    $("#statusFilter").removeClass('filterActive');
                    $("#statusFilter .trigger").text('Status: All');
                    $("#userFilter").removeClass('filterActive');
                    $("#userFilter .trigger").text('User: All');
                    $("#branchFilter").removeClass('filterActive');
                    $("#branchFilter .trigger").text('Branch: All');
                    $("#datesFilter").removeClass('filterActive');
                    $("#datesFilter .trigger").text('Date Range');
                    $("#changeDatesFilter").removeClass('filterActive');
                    $("#changeDatesFilter .trigger").text('Status Change');
                    $("#queuedFilter").removeClass('filterActive');
                    $("#queuedFilter .trigger").text('All Proposals');
                }

                $(".filterOverlay").live('click', function () {
                    closeFilters();
                });
                $(".trigger.reset").live('click', function () {
                    resetFilters();
                });

                $("#newFilter .trigger").live('click', function () {
                    if ($(this).hasClass('active')) {
                        //hide the filter
                        closeFilters();
                    } else {
                        //show the filter
                        closeFilters();
                        $(this).addClass('active');
                        $(this).next().show();
                        $(".filterOverlay").css({
                            display: "block",
                            width: "100%",
                            height: "100%"
                        });
                    }
                });
                //Code for status change filter
                $("#statusFilter li a").click(function () {
                    $("#statusFilter .trigger").text($(this).attr('title'));
                    $("#filterStatusValue").val($(this).attr('rel'));
                    if ($(this).attr('rel') == 'All') {
                        $("#statusFilter").removeClass('filterActive');
                    } else {
                        $("#statusFilter").addClass('filterActive');
                    }
                    closeFilters();
                    return false;
                });
                //Code for user change filter
                $("#userFilter li a").click(function () {
                    $("#userFilter .trigger").text($(this).attr('title'));
                    $("#filterUserValue").val($(this).attr('rel'));
                    if ($(this).attr('rel') == 'All') {
                        $("#userFilter").removeClass('filterActive');
                    } else {
                        $("#userFilter").addClass('filterActive');
                    }
                    closeFilters();
                    return false;
                });
                //Code for branch change filter
                $("#branchFilter li a").click(function () {
                    $("#branchFilter .trigger").text($(this).attr('title'));
                    $("#filterBranchValue").val($(this).attr('rel'));
                    if ($(this).attr('rel') == 'All') {
                        $("#branchFilter").removeClass('filterActive');
                    } else {
                        $("#branchFilter").addClass('filterActive');
                    }
                    updateBranchUsers();
                    closeFilters();
                    return false;
                });
                $("#filterServiceSelect").live('change', function () {
                    var text = $(this).find(':selected').text();
                    if (text.length > 10) {
                        text = text.substr(0, 10) + '...';
                    }
                    $("#servicesFilter .trigger").text('Service: ' + text);
                    $("#filterServiceValue").val($(this).find(':selected').val());
                    if ($(this).find(':selected').text() == 'All') {
                        $("#servicesFilter").removeClass('filterActive');
                    } else {
                        $("#servicesFilter").addClass('filterActive');
                    }
                    closeFilters();
                });
                //Code for date pickers
                $("#setDates").live('click', function () {
                    $("#datesFilter").addClass('filterActive');
                    $("#datesFilter .trigger").text('Date Range: ...');
                    $("#filterServiceFrom").val($("#from").val());
                    $("#filterServiceTo").val($("#to").val());
                    closeFilters();
                });
                // Status change filter set
                $("#setChangeDates").live('click', function () {
                    $("#changeDatesFilter").addClass('filterActive');
                    $("#changeDatesFilter .trigger").text('Status Change ...');
                    $("#filterServiceChangeFrom").val($("#changeFrom").val());
                    $("#filterServiceChangeTo").val($("#changeTo").val());
                    closeFilters();
                });
                /*
                 * Apply Filter Functionality
                 * */

                $("#applyFilter").click(function () {
                    $("#reset-filter").show();
                    var branch = $("#filterBranchValue").val();
                    var status = $("#filterStatusValue").val();
                    var user = $("#filterUserValue").val();
                    var service = $("#filterServiceValue").val();
                    var from = $("#filterServiceFrom").val();
                    var to = $("#filterServiceTo").val();
                    var changeFrom = $("#filterServiceChangeFrom").val();
                    var changeTo = $("#filterServiceChangeTo").val();
                    var queue = $("#statusFilterQueueValue").val();
                    $.ajax({
                        type: "POST",
                        url: '<?php echo site_url('ajax/setProposalStatusFilter') ?>',
                        data: {
                            pStatusFilterUser: user,
                            pStatusFilterStatus: status,
                            pStatusFilterService: service,
                            pStatusFilterFrom: from,
                            pStatusFilterTo: to,
                            pStatusFilterBranch: branch,
                            pStatusFilterQueue: queue,
                            pStatusFilterChangeFrom: changeFrom,
                            pStatusFilterChangeTo: changeTo
                        },
                        dataType: 'JSON',
                        success: function () {
                            setTimeout(function () {
                                //disable reload for debug functionality
                                document.location.reload();
                            }, 500);
                        }
                    });
                    return false;
                });
                /*
                 * Queued Filter Functionality
                 */
                $("#queuedFilter li a").click(function () {
                    $("#queuedFilter .trigger").text($(this).text());
                    $("#statusFilterQueueValue").val($(this).attr('rel'));
                    if ($(this).attr('rel') == '0') {
                        $("#queuedFilter").removeClass('filterActive');
                    } else {
                        $("#queuedFilter").addClass('filterActive');
                    }
                    closeFilters();
                    return false;
                });

                /* Quickbooks invoicing loader */
                $('.createQbInvoice').live('click', function () {

                    $this = $(this);
                    $.fancybox({
                        width: 300,
                        height: 50,
                        scrolling: 'no',
                        href: '#qbLoading',
                        beforeShow: function () {
                            $('#qbLoading').show();
                        }
                    });
                    return true;
                });

                /* Select all / none functionality */

                // Do the setup first
                updateNumSelected();

                // All
                $("#selectAll").live('click', function () {
                    $(".groupSelect").attr('checked', 'checked');
                    updateNumSelected();
                    return false;
                });

                // None
                $("#selectNone").live('click', function () {
                    $(".groupSelect").attr('checked', false);
                    updateNumSelected();
                    return false;
                });

                // Update the counter after each change
                $(".groupSelect").live('change', function () {
                    updateNumSelected();
                });

                /* Update the number of selected items */
                function updateNumSelected() {
                    var num = $(".groupSelect:checked").length;

                    // Hide the options if 0 selected
                    if (num < 1) {
                        $("#groupActionIntro").show();
                        $(".groupAction").hide();
                    }
                    else {
                        $("#groupActionIntro").hide();
                        $(".groupAction").show();
                    }

                    $("#numSelected").html(num);
                }

                /* Check that at least one proposal has been selected */
                function checkProposalsSelected() {
                    var num = $(".groupSelect:checked").length;

                    if (num > 0) {
                        return true;
                    }
                    $("#no-proposals-selected").dialog('open');
                    return false;
                }

                /* get a list of the selected IDs */
                function getSelectedIds() {

                    var IDs = new Array();

                    $(".groupSelect:checked").each(function () {

                        IDs.push($(this).data('proposal-id'));
                    });

                    return IDs;
                }


                

                // No proposals dialog
                $("#no-proposals-selected").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        Close: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });





                // Proposal Resend Update
                $("#resend-proposals-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });

                /*
                 DELETE
                 */
                $("#groupDelete").click(function () {

                    var proceed = checkProposalsSelected();

                    if (proceed) {
                        $("#deleteNum").html($(".groupSelect:checked").length);
                        $("#delete-proposals").dialog('open');
                    }
                });

                // Resend dialog
                $("#delete-proposals").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        "Delete": {
                            text: 'Delete Proposals',
                            'class': 'btn ui-button update-button',
                            'id': 'confirmDelete',
                            click: function () {

                                var deleteDuplicates = ($("#deleteDuplicates").prop("checked")) ? 1 : 0;

                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {
                                        'ids': getSelectedIds(),
                                        'deleteDuplicates': deleteDuplicates
                                    },
                                    url: "<?php echo site_url('ajax/groupDelete') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                    .success(function (data) {

                                        if (data.success) {
                                            var resendText = data.count + ' proposals were deleted';
                                        }
                                        else {
                                            var resendText = 'An error occurred. Please try again';
                                        }

                                        $("#deleteProposalsStatus").html(resendText);
                                        $("#delete-proposals-status").dialog('open');

                                    });
                                $(this).dialog('close');
                                $("#deleteProposalsStatus").html('Deleting proposals...<img src="/static/loading.gif" />');
                                $("#delete-proposals-status").dialog('open');
                            }
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false,
                    open: function (event, ui) {

                        // Uncheck each time shown
                        $("#deleteDuplicates").attr("checked", false);
                        $.uniform.update();

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedIds()},
                            url: "<?php echo site_url('ajax/containsDuplicates') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                if (data.duplicates == 0) {
                                    $('#deleteDuplicatesContainer').hide();
                                }
                                else {
                                    $('#deleteDuplicatesContainer').show();
                                }
                            });


                    }
                });

                // Proposal Status Update
                $("#delete-proposals-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });


                $("#groupChangeStatus").click(function () {

                    var proceed = checkProposalsSelected();

                    if (proceed) {
                        $("#statusChangeNum").html($(".groupSelect:checked").length);
                        $("#status-proposals").dialog('open');
                    }
                });


                // Status dialog
                $("#status-proposals").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        "Update": {
                            text: 'Update Proposals',
                            'class': 'btn ui-button update-button',
                            'id': 'confirmStatus',
                            click: function () {
                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {'ids': getSelectedIds(), 'status': $("#changeStatus").val()},
                                    url: "<?php echo site_url('ajax/groupStatusChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"

                                })
                                    .success(function (data) {

                                        if (data.success) {
                                            var resendText = data.count + ' proposals were updated';
                                        }
                                        else {
                                            var resendText = 'An error occurred. Please try again';
                                        }

                                        $("#statusProposalsStatus").html(resendText);
                                        $("#status-proposals-status").dialog('open');

                                    });
                                $(this).dialog('close');
                                $("#statusProposalsStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                                $("#status-proposals-status").dialog('open');
                            }
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    autoOpen: false
                });

                // Proposal Delete Update
                $("#status-proposals-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });


                // Unduplicate
                $("#groupUnduplicate").click(function () {
                    $("#status-unduplicate").dialog('open');
                });

                $("#status-unduplicate").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: {
                            'text': 'Continue',
                            'class': 'btn ui-button update-button',
                            click: function () {
                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {'ids': getSelectedIds()},
                                    url: "<?php echo site_url('ajax/groupStandalone') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                    .success(function (data) {

                                        if (data.success) {
                                            var resendText = data.count + ' proposals were updated';
                                        }
                                        else {
                                            var resendText = 'An error occurred. Please try again';
                                        }

                                        $("#standaloneStatus").html(resendText);
                                        $("#standalone-status").dialog('open');

                                    });

                                $(this).dialog('close');
                                $("#standaloneStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                                $("#standalone-status").dialog('open');
                            }
                        },
                        Cancel: function () {
                            $(this).dialog('close');
                        }
                    },
                    autoOpen: false
                });

                $("#standalone-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });

                /* Status Date Change */

                $("#sdcDate").datepicker();

                $("#groupStatusChangeDate").click(function () {
                    $("#status-date-change-confirm").dialog('open');
                });


                $("#status-date-change-confirm").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: {
                            'text': 'Continue',
                            'class': 'btn ui-button update-button',
                            click: function () {

                                var changeDate = $("#sdcDate").val();

                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {
                                        'ids': getSelectedIds(),
                                        'changeDate': changeDate
                                    },
                                    url: "<?php echo site_url('ajax/groupStatusDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                    .success(function (data) {

                                        if (data.success) {
                                            var resendText = data.count + ' proposals were updated';
                                        }
                                        else {
                                            var resendText = 'An error occurred. Please try again';
                                        }

                                        $("#sdcStatus").html(resendText);
                                        $("#sdc-status").dialog('open');

                                    });

                                $(this).dialog('close');
                                $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                                $("#sdc-status").dialog('open');
                            }
                        },
                        Cancel: function () {
                            $(this).dialog('close');
                        }
                    },
                    autoOpen: false
                });

                $("#sdc-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });

                // Creation Date change
                $("#dcDate").datepicker();

                $("#groupChangeDate").click(function () {
                    $("#date-change-confirm").dialog('open');
                });

                $("#date-change-confirm").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: {
                            'text': 'Continue',
                            'class': 'btn ui-button update-button',
                            click: function () {

                                var changeDate = $("#dcDate").val();

                                $.ajax({
                                    type: "POST",
                                    async: true,
                                    cache: false,
                                    data: {
                                        'ids': getSelectedIds(),
                                        'changeDate': changeDate
                                    },
                                    url: "<?php echo site_url('ajax/groupDateChange') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                    dataType: "JSON"
                                })
                                    .success(function (data) {

                                        if (data.success) {
                                            var resendText = data.count + ' proposals were updated';
                                        }
                                        else {
                                            var resendText = 'An error occurred. Please try again';
                                        }

                                        $("#sdcStatus").html(resendText);
                                        $("#sdc-status").dialog('open');

                                    });

                                $(this).dialog('close');
                                $("#sdcStatus").html('Updating proposals...<img src="/static/loading.gif" />');
                                $("#sdc-status").dialog('open');
                            }
                        },
                        Cancel: function () {
                            $(this).dialog('close');
                        }
                    },
                    autoOpen: false
                });

                $("#dc-status").dialog({
                    width: 500,
                    modal: true,
                    buttons: {
                        OK: function () {
                            $(this).dialog('close');
                            oTable.fnDraw();
                        }
                    },
                    autoOpen: false
                });


                //check the apply badges 

                $('#accountFilterHeader').closest('.filterColumn').addClass('filterColumnDisable').removeClass('filterColumn');
                    $('#newProposalFilterButton').click(function (){
                        $('#accountFilterHeader span').html('<i class="fa fa-lock tiptip" title="Filter locked as page is this page is already filtering" style="font-size: 18px;"></i>');
                    })

                    var statusFrom  = '<?= $this->session->userdata('pStatsFilterFrom');?>';
                if(statusFrom!=''){
                    $('#createdFilterHeader').closest('.filterColumnWide').addClass('filterColumnWideDisable').removeClass('filterColumnWide');
                    $('#createdFilterHeader').closest('.filterColumnRow').addClass('filterColumnDisable').removeClass('filterColumnRow');
                    $('#newProposalFilterButton').click(function (){
                        initTiptip();
                        $('#createdFilterHeader span').html('<i class="fa fa-lock tiptip" title="Filter locked as page is this page is already filtering" style="font-size: 18px;"></i>');
                    })
                }

                if(<?php echo is_array($this->session->userdata('pStatsFilterUser')) ? count($this->session->userdata('pStatsFilterUser')) : 0; ?> > 0){
                    $('#userFilterHeader').closest('.filterColumn').addClass('filterColumnDisable').removeClass('filterColumn');
                    $('#newProposalFilterButton').click(function (){
                        $('#userFilterHeader span').html('<i class="fa fa-lock tiptip" title="Filter locked as page is this page is already filtering" style="font-size: 18px;"></i>');
                    })
                }
                
                var statusName  = '<?= $this->session->userdata('pStatsFilterStatusName');?>';
                var statusNameShow  = '<?= $this->session->userdata('pStatsFilterStatusNameShow');?>';
                 if(statusNameShow !='' ||  statusName !=''){
                    $('#statusFilterHeader').closest('.filterColumn').addClass('filterColumnDisable').removeClass('filterColumn');
                    $('#newProposalFilterButton').click(function (){
                        $('#statusFilterHeader span').html('<i class="fa fa-lock tiptip" title="Filter locked as page is this page is already filtering" style="font-size: 18px;"></i>');
                    })
                }


            });
        </script>
    </div>
    </div>
    <div class="javascript_loaded">
        <div id="duplicate-proposal" title="Duplicate Proposal">

            <div class="dupe-copy-wording">
                <p>Use this to send out the same proposal to several different customers.</p>
                <p><strong>Example:</strong> You are bidding the same project to 3 different General Contractors.</p>
                <p>Please understand that the number that shows up in your pipeline is the fist bid created.</p>
                <p>After you win/lose this project, delete the duplicate proposals.</p>
            </div>

            <p class="clearfix" id="duplicate-selected-client">
                Selected Contact: <strong id="clientName">Contact</strong> <a href="#"
                                                                              id="reset-duplicate-client-search">Select
                    other contact</a>
            </p>

            <p class="clearfix" id="duplicate-select-client">
                <label style="width: 120px; text-align: right; margin-right: 10px; padding-top: 5px; float: left;">Select
                    Company</label>
                <input type="text" name="duplicate-client" id="duplicate-client" style="float: left;"
                       class="text tiptip" title="Type company name">
                <a class="btn" href="<?php echo site_url('clients/add') ?>" style="margin-left: 3px;">Add New
                    Contact</a>
            </p>
            <input id="duplicate-client-id" type="hidden" name="duplicate-client-id">
            <input id="duplicate-proposal-id" type="hidden" name="duplicate-proposal-id">
        </div>
        <div id="copy-proposal" title="Copy Proposal">

            <div class="dupe-copy-wording">
                <p>Use this to copy the content of an existing proposal and send to a new customer/project.</p>
                <p>Please remember to delete any picture/images etc. prior to sending.</p>
                <p>You must have the contact name entered prior to using this feature.</p>
            </div>

            <p class="clearfix" id="copy-selected-client" style="display: none">
                Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-copy-client-search">Select
                    other contact</a>
            </p>

            <p class="clearfix" id="copy-select-client">
                <label style="width: 120px; text-align: right; margin-right: 10px; padding-top: 5px; float: left;">Select
                    Company</label>
                <input type="text" name="copy-client" id="copy-client" style="float: left;" class="text tiptip"
                       title="Type company name">
                <a class="btn" href="<?php echo site_url('clients/add') ?>" style="margin-left: 3px;">Add New
                    Contact</a>
            </p>
            <input id="copy-client-id" type="hidden" name="copy-client-id">
            <input id="copy-proposal-id" type="hidden" name="copy-proposal-id">
        </div>

        <div id="notes-client" title="Client Notes">
            <form action="#" id="add-note-client">
                <p>
                    <label>Add Note</label>
                    <input type="text" name="noteText-client" id="noteText-client" style="width: 500px;">
                    <input type="hidden" name="relationId-client" id="relationId-client" value="0">
                    <input type="submit" value="Add">
                </p>
                <iframe id="notesFrame-client" src="" frameborder="0" width="100%" height="250"></iframe>
            </form>
        </div>
        <div id="confirm-delete-message" title="Confirmation">
            <p>Are you sure you want to delete this proposal?</p>
            <a id="client-delete" href="" rel=""></a>
        </div>
        <div id="dialog-message" title="Client Information">
            <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span
                    id="field_firstName"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span id="field_lastName"></span>
            </p>

            <p class="clearfix"><strong class="fixed-width-strong">Title:</strong> <span id="field_title"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span id="field_company"></span>
            </p>

            <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span id="field_email"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span>
            </p>

            <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span id="field_state"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span>
            </p>

            <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span
                    id="field_cellPhone"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span
                    id="field_businessPhone"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span></p>
        </div>

        <div id="no-proposals-selected" title="Error">
            <p>No proposals were selected!</p>
            <br/>

            <p>Select at least one proposal to carry out a group action</p>
        </div>



        <div id="resend-proposals-status" title="Confirmation">
            <h3>Confirmation - Resend Proposals</h3>

            <p id="resendProposalsStatus"></p>
        </div>

        <div id="delete-proposals" title="Confirmation">
            <h3>Confirmation - Delete Proposals</h3>

            <p>This will delete a total of <strong><span id="deleteNum"></span></strong> proposals.</p>
            <br/>
            <p id="deleteDuplicatesContainer"><input type="checkbox" id="deleteDuplicates"> Also delete duplicates?</p>
            <br/>
            <p>Are you sure that you want to proceed?</p>
        </div>

        <div id="delete-proposals-status" title="Confirmation">
            <h3>Confirmation - Delete Proposals</h3>

            <p id="deleteProposalsStatus"></p>
        </div>

        <div id="status-proposals" title="Confirmation">
            <h3>Confirmation - Status</h3>

            <p>Change to: <select id="changeStatus">
                    <?php foreach ($statuses as $status) {
                        /* @var \models\Status $status */
                        ?>
                        <option value="<?php echo $status->getStatusId(); ?>" data-sales="<?php echo $status->getSales(); ?>"><?php echo $status->getText(); ?></option>
                    <?php } ?>
                </select>
            </p>
            <br/>

            <p>This will update the status of <strong><span id="statusChangeNum"></span></strong> proposals.</p>
            <br/>

            <p>Are you sure that you want to proceed?</p>
        </div>

        <div id="status-proposals-status" title="Confirmation">
            <h3>Confirmation - Update Proposal Status</h3>

            <p id="statusProposalsStatus"></p>
        </div>

        <div id="status-unduplicate" title="Make Standalone">
            <p>This will convert any selected duplicate proposals into standalone proposals.</p>
            <br/>
            <p>Are you sure you want to proceed?</p>
        </div>

        <div id="standalone-status" title="Confirmation">
            <h3>Confirmation - Setting proposals to Standalone</h3>

            <p id="standaloneStatus"></p>
        </div>

        <div id="status-date-change-confirm" title="Update Status Change Date">
            <p>This will update when the proposal was changed to the current status.</p>
            <br/>
            <p>Select Date: <input type="text" id="sdcDate"/></p>
        </div>

        <div id="sdc-status" title="Confirmation">
            <h3>Confirmation - Updating Status Change Date</h3>

            <p id="sdcStatus"></p>
        </div>

        <div id="date-change-confirm" title="Update Proposal Date">
            <p>This will update when the proposal was created</p>
            <br/>
            <p>Select Date: <input type="text" id="dcDate"/></p>
        </div>

        <div id="dc-status" title="Confirmation">
            <h3>Confirmation - Updating Proposal Date</h3>

            <p id="dcStatus"></p>
        </div>
    </div>

    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>