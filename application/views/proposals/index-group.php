<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">
    <div id="newFilter">
    <div class="clearfix">
        <div class="left" style="width: 49px;">
            <label class="filterLabel">Filter</label>
        </div>
        <div class="left" style="width: 900px;">


            <div class="clearfix" style="margin-bottom: 10px;">
                <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterStatus') && ($this->session->userdata('pFilterStatus') != 'All')) ? 'filterActive' : '' ?>" id="statusFilter">
                    <a class="trigger" href="#">Status: <?php echo ($this->session->userdata('pFilterStatus') && ($this->session->userdata('pFilterStatus') != 'All')) ? $this->session->userdata('pFilterStatusName') : 'All' ?></a>

                    <div class="filter-code">
                        <ul class="filter-list">
                            <li><a title="Status: All" rel="All" href="#">All</a></li>
                            <?php
                            foreach ($statusCollection as $status) {
                                ?>
                                <li><a title="Status: <?php echo $status->getText(); ?>" rel="<?php echo $status->getStatusId(); ?>" href="#"><?php echo $status->getText(); ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php if ($account->getUserClass() >= 2) { ?>
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilter') && ($this->session->userdata('pFilterBranch') || ($this->session->userdata('pFilterBranch') == '0'))) ? 'filterActive' : ''; ?>" id="branchFilter">
                        <a class="trigger" href="#">Branch: <?php
                            $foundBranch = false;
                            foreach ($branches as $branchId => $branch) {
                                if ($branchId == $this->session->userdata('pFilterBranch')) {
                                    $foundBranch = true;
                                    echo $branch->getBranchName();
                                }
                            }
                            if (!$foundBranch) {
                                if ($this->session->userdata('pFilter') && (($this->session->userdata('pFilterBranch') == 'Main') || ($this->session->userdata('pFilterBranch') == '0'))) {
                                    echo 'Main';
                                } else {
                                    echo 'All';
                                }
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="Branch: All" rel="All" href="#">All</a></li>
                                <li><a href="#" title="Branch: Main" rel="0">Main</a></li>
                                <?php
                                foreach ($branches as $branch) {
                                    ?>
                                    <li><a title="Branch: <?php echo $branch->getBranchName() ?>" rel="<?php echo $branch->getBranchId() ?>" href="#"><?php echo $branch->getBranchName() ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($account->getUserClass() >= 1) { ?>
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterUser') && ($this->session->userdata('pFilterUser') != 'All')) ? 'filterActive' : ''; ?>" id="userFilter">
                        <a class="trigger" href="#">User: <?php
                            $found = false;
                            if ($this->session->userdata('pFilterUser') && ($this->session->userdata('pFilterUser') != 'All')) {
                                foreach ($accounts as $acc) {
                                    if ($acc->getAccountId() == $this->session->userdata('pFilterUser')) {
                                        $found = true;
                                        echo $acc->getFullName();
                                        break;
                                    }
                                }
                            }
                            if (!$found) {
                                echo 'All';
                            }
                            ?>
                        </a>

                        <div class="filter-code">
                            <ul class="filter-list">
                                <li><a title="User: All" rel="All" href="#">All</a></li>
                                <?php
                                foreach ($accounts as $acc) {
                                    if ((($account->getUserClass() == 1) && ($acc->getBranch() == $account->getBranch())) || ($account->getUserClass() >= 2)) {
                                        ?>
                                        <li class="branchUser branch_<?php echo $acc->getBranch() ?>"><a title="User: <?php echo $acc->getFullName() ?>" rel="<?php echo $acc->getAccountId() ?>" href="#"><?php echo $acc->getFullName() ?></a></li>
                                    <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                <?php } ?>


                <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterService')) ? 'filterActive' : ''; ?>" id="servicesFilter">
                    <a class="trigger" href="#">Service: <?php
                        $foundService = false;
                        foreach ($categories as $cat) {
                            if (is_array(@$services[$cat->getServiceId()])) {
                                foreach ($services[$cat->getServiceId()] as $service) {
                                    if ($service->getServiceId() == $this->session->userdata('pFilterService')) {
                                        echo (strlen($service->getServiceName()) <= 10) ? $service->getServiceName() : substr($service->getServiceName(), 0, 10) . '...';
                                        $foundService = true;
                                        break;
                                        break;
                                    }
                                }
                            }
                        }
                        if (!$foundService) {
                            echo 'All';
                        }
                        ?></a>

                    <div class="filter-code" style="width: 200px; padding: 5px;">
                        <label>Select Service:</label>
                        <select name="services[]" id="filterServiceSelect" style="display: block;">
                            <option value="0">All</option>
                            <?php
                            foreach ($categories as $cat) {
                                ?>
                                <optgroup label="<?php echo $cat->getServiceName() ?>">
                                    <?php
                                    if (isset($services[$cat->getServiceId()])) {
                                        foreach ($services[$cat->getServiceId()] as $service) {
                                            ?>
                                            <option value="<?php echo $service->getServiceId() ?>" <?php if ($this->session->userdata('pFilterService') == $service->getServiceId()) { ?> selected="selected"<?php } ?>><?php echo $service->getServiceName() ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </optgroup>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterFrom') || $this->session->userdata('pFilterTo')) ? 'filterActive' : ''; ?>" id="datesFilter">
                    <a class="trigger active" href="#">Date Range</a>

                    <div class="filter-code" style="padding: 5px; width: 270px; left: 50%; margin-left: -135px;">
                        <p class="clearfix" style="margin-bottom: 5px;">
                            <?php
                            $companyStart = $account->getCompany()->getAdministrator()->getCreated(false);
                            $startDate = date('m/d/Y', $companyStart);
                            $endDate = date('m/d/Y');
                            ?>
                            <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">From: </label> <input class="text left" value="<?php echo ($this->session->userdata('pFilterFrom')) ? $this->session->userdata('pFilterFrom') : $startDate; ?>" type="text" name="from" id="from" style="width: 66px;"/>
                            <label style="width: 50px; text-align: right; float: left; display: block; margin-top: 2px; margin-right: 5px;">To: </label> <input class="text left" value="<?php echo ($this->session->userdata('pFilterTo')) ? $this->session->userdata('pFilterTo') : $endDate; ?>" type="text" name="to" id="to" style="width: 66px;"/>
                        </p>
                        <a href="#" class="filterButton actionButton" id="allDates" style="margin-left: 55px; width: 70px; text-align: center; padding: 0;">Choose All</a>
                        <a class="filterButton blue actionButton" id="setDates" href="#" style="margin-left: 36px; width: 80px; text-align: center; padding: 0;">Apply</a>
                    </div>
                </div>
                    <div class="filter-box clearfix <?php echo ($this->session->userdata('pFilterQueue')) ? 'filterActive' : ''; ?>" id="queuedFilter">
                        <a class="trigger" href="#"><?php
                            switch ($this->session->userdata('pFilterQueue')) {
                                case '1':
                                    echo 'Queued Proposals';
                                    break;
                                case '2':
                                    echo 'Denied Proposals';
                                    break;
                                case 'duplicate':
                                    echo 'Duplicate Proposals';
                                    break;
                                default:
                                    echo 'All Proposals';
                                    break;
                            }
                            ?></a>

                        <div class="filter-code" style="">
                            <ul class="filter-list">
                                <li><a href="#" rel="0">All Proposals</a></li>
                                <?php if ((QUEUEDPROPOSALS > 0) || (DECLINEDPROPOSALS > 0)) { ?>
                                <li><a href="#" rel="1">Queued Proposals</a></li>
                                <li><a href="#" rel="2">Declined Proposals</a></li>
                                <?php } ?>
                                <li><a href="#" rel="duplicate">Duplicate Proposals</a></li>
                            </ul>
                        </div>
                    </div>
            </div>

            <div class="clearfix">
                <a class="filterButton apply blue" id="applyFilter" href="#">Apply</a>
                <?php if ($this->session->userdata('pFilter')) { ?>
                    <a class="filterButton" href="<?php echo site_url('proposals/resetFilter/1') ?>">Reset</a>
                <?php } ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="filterStatusValue" id="filterStatusValue" value="<?php echo $this->session->userdata('pFilterStatus'); ?>"/>
    <input type="hidden" name="filterQueueValue" id="filterQueueValue" value="<?php echo $this->session->userdata('pFilterQueue'); ?>"/>
    <input type="hidden" name="filterUserValue" id="filterUserValue" value="<?php echo $this->session->userdata('pFilterUser'); ?>"/>
    <input type="hidden" id="filterBranchValue" name="filterBranchValue" value="<?php echo $this->session->userdata('pFilterBranch') ?>"/>
    <input type="hidden" id="filterServiceValue" name="filterServiceValue" value="<?php echo $this->session->userdata('pFilterService') ?>"/>
    <input type="hidden" id="filterServiceFrom" name="filterServiceFrom" value="<?php echo $this->session->userdata('pFilterFrom') ?>"/>
    <input type="hidden" id="filterServiceTo" name="filterServiceTo" value="<?php echo $this->session->userdata('pFilterTo') ?>"/>

    <input type="hidden" id="pageAction" value="<?php echo $action; ?>" />

    <div class="filterOverlay"></div>
    </div>
    <div class="clearfix"><?php
        //debug
        //                print_r($this->session->all_userdata());
        ?></div>


    <div class="content-box">
        <div class="box-header">

            <span id="groupActionIntro" style="font-style: normal; color: #fff; font-weight: normal; font-size: 12px">Select proposals to display actions</span>

            <?php
            if(!$account->requiresApproval()) {
                ?>
                <a class="box-action box-action-left groupAction" id="groupResend">Send Email</a>
            <?php
            }
            ?>
            <a class="box-action box-action-left groupAction" id="groupDelete">Delete Proposals</a>
            <a class="box-action box-action-left groupAction" id="groupChangeStatus">Change Status</a>

            <!--<span id="proposals-box-name" style="color: #E6E8EB;">Proposals</span>-->
            <?php if (help_box(82)) { ?>
                <div class="help box-center center tiptip" title="Help"><?php help_box(82, true) ?></div>
            <?php
            } ?>
            <!--            <a class="box-action tiptip blue" title="View Proposals in Queue" href="#">Proposal Queue</a>-->
            <a class="box-action tiptip" href="<?php echo site_url('clients') ?>" title="Add New Proposal">Add Proposal</a>
            <a class="box-action tiptip" href="<?php echo site_url('proposals') ?>" title="Back to normal proposals page">Back</a>

            <div class="clearfix"></div>
        </div>
        <div class="box-content">
            <table cellpadding="0" cellspacing="0" border="0" class="<?php echo ($this->uri->segment(2) == 'searchProposals') ? 'dataTables-proposals-table' : 'dataTables-proposalsNew' ?> display">
                <thead>
                <tr>
                    <td style="text-align: center; width: 218px;">Actions</td>
                    <td>Date</td>
                    <td>Branch</td>
                    <td>Status</td>
                    <td width="52">Job #</td>
                    <td>Company</td>
                    <td>Project Name</td>
                    <td>Price</td>
                    <td>Price 2</td>
                    <td>Contact</td>
                    <td>Owner</td>
                    <td>Proposal ID</td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>


        <div style="display: none" id="qbLoading">
            <p style="text-align: center; margin-bottom: 20px;">Communicating with QuickBooks</p>

            <p style="text-align: center"><img src="/static/loading_animation.gif"/></p>
        </div>

    </div>

    <script type="text/javascript">
    $(document).ready(function () {
        <?php
        if ($this->uri->segment(2) != 'searchProposals') {
                ?>
        oTable = $('.dataTables-proposalsNew').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "bPaginate": true,
            "sAjaxSource": "<?php echo site_url('ajax/ajaxGroupProposals') ?>",
            "aoColumnDefs": [
                {"iDataSort": 8, "aTargets": [7]},
                {"bVisible": false, "aTargets": [8]},
                {"iDataSort": 11, "aTargets": [1]},
                {"bVisible": false, "aTargets": [11]}
            ],
            "aoColumns": [
                {bSortable: false, bSearchable: false, "sClass": 'dtCenter'},
                {"sType": "date-formatted"},
                null,
                null,
                null,
                {"sType": "html"},
                {"sType": "html", "iDataSort": 7},
                null,
                {"sType": "html"},
                {bSearchable: false, "sType": "html"},
                null
            ],
            "aaSorting": [
                [1, "desc"]
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "fnDrawCallback": function () {
                initButtons();
                initTiptip();
                initStatusChange();
                updateNumSelected();
            },
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>'
        });
        <?php
        } else {
        ?>
        //load data table normally

        var oTable = $('.dataTables-proposals-table').dataTable({
            "aaSorting": [
                [1, "desc"]
            ],
            "bJQueryUI": true,
            "bAutoWidth": false,
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "fnDrawCallback": function () {
                initButtons();
                initTiptip();
            },
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lipr>'
        });

        function initProposals() {
            $("#proposals-box-name").html('Proposals');
            var tbody = $(".dataTables-proposals-table").find('tbody');
            tbody.html('<tr><td align="center" colspan="10" style="line-height: 22px;">Please Wait, Loading data...</td></tr>');
            $(".dataTables-proposals-table thead td").each(function () {
                $(this).html($(this).text());
            });
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                url: "<?php echo site_url('ajax/ajaxProposals') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON",
                success: function (data) {
                    tbody.html('');
                    var proposals = data['aaData'];
                    var proposalsCount = proposals.length;
                    oTable.fnClearTable();
                    $("#proposals-box-name").html('Proposals (' + proposalsCount + ')');
                    oTable.fnDestroy();
                    for (i in proposals) {
                        //                    oTable.fnAddData(proposals[i]);
                        tbody.append('<tr><td>' + proposals[i][0] + '</td><td>' + proposals[i][1] + '</td><td class="proposal-' + proposals[i][2].toLowerCase() + '">' + proposals[i][2] + '</td><td>' + proposals[i][3] + '</td><td>' + proposals[i][4] + '</td><td>' + proposals[i][5] + '</td><td>' + proposals[i][6] + '</td><td>' + proposals[i][7] + '</td><td>' + proposals[i][8] + '</td><td>' + proposals[i][9] + '</td><td>' + proposals[i][10] + '</td></tr>')
                    }
                    oTable = $('.dataTables-proposals-table').dataTable({
                        "aoColumnDefs": [
                            {"iDataSort": 7, "aTargets": [6]},
                            {"bVisible": false, "aTargets": [7]},
                            {"iDataSort": 10, "aTargets": [1]},
                            {"bVisible": false, "aTargets": [10]}
                        ],
                        "aoColumns": [
                            {bSortable: false, bSearchable: false},
                            {"sType": "date-formatted"},
                            null,
                            null,
                            null,
                            null,
                            {"sType": "html"},
                            {"sType": "html", "iDataSort": 7},
                            null,
                            {"sType": "html"},
                            {bSearchable: false, "sType": "html"},
                            null
                        ],
                        "aaSorting": [
                            [1, "desc"]
                        ],
                        "bJQueryUI": true,
                        "bAutoWidth": false,
                        "sPaginationType": "full_numbers",
                        "aLengthMenu": [
                            [10, 25, 50, -1],
                            [10, 25, 50, "All"]
                        ],
                        "fnDrawCallback": function () {
                            initButtons();
                            initTiptip();
                        },
                        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lipr>',
                        "bDestroy": true,
                        "oLanguage": {
                            "sEmptyTable": "No data in table!"
                        }
                    });
                    initButtons();
                    initTiptip();
                }
            });
            //proposal status change code
        }

        initProposals();
        <?php
                }
                ?>
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
        /**
         * Notes stuff here
         */
        $("#notes").dialog({
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            width: 700
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
        $(".btn-notes, .view-notes").live('click', function () {
            var id = $(this).attr('rel');
            var frameUrl = '<?php echo site_url('account/notes/proposal') ?>/' + id;
            $("#notesFrame").attr('src', frameUrl);
            $("#relationId").val(id);
            $('#notesFrame').load(function () {
                $("#notes").dialog('open');
            });
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
        $("#add-note").submit(function () {
            var request = $.ajax({
                url: '<?php echo site_url('ajax/addNote') ?>',
                type: "POST",
                data: {
                    "noteText": $("#noteText").val(),
                    "noteType": 'proposal',
                    "relationId": $("#relationId").val()
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        //refresh frame
                        $("#noteText").val('');
                        $('#notesFrame').attr('src', $('#notesFrame').attr('src'));
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
                url: '<?php echo site_url('proposals/resetFilter') ?>',
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
        $("#apply-filter").click(function () {
            $("#reset-filter").show();
            var user = $('input[name=user]:checked').val();
            var status = $('input[name=status]:checked').val();
            var service = $("#service").val();
            var from = $("#from").val();
            var to = $("#to").val();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setProposalFilter') ?>',
                data: {
                    pFilterUser: user,
                    pFilterStatus: status,
                    pFilterService: service,
                    pFilterFrom: from,
                    pFilterTo: to
                },
                dataType: 'JSON',
                success: function () {
                    setTimeout(function () {
//                        initProposals();
                        document.location.reload();
                        $("#proposals-filter-box-name").html('Proposals Filter - Active');
                    }, 500);
                }
            });
            return false;
        });
        function resetDuplicateDialog() {
            $("#duplicate-selected-client").hide().find('strong').html('');
            $("#duplicate-select-client").show().find('input').val('');
            $(":button:contains('Duplicate')").prop("disabled", true).addClass("ui-state-disabled");
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
        $(".duplicate-proposal").live('click', function () {
            $("#duplicate-proposal-id").val($(this).attr('rel'));
            $("#duplicate-proposal").dialog('open');
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
        $("#reset-duplicate-client-search").click(function () {
            resetDuplicateDialog();
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
        $first = true;
        $statusesString = '{';
        foreach($statuses as $k=>$v) {
            if(!$first){
                $statusesString.= ', ';
            }
            $statusesString.= "'_" . $k . "' : '" . $v . "'";

            $first = false;
        }
        $statusesString .= ", 'selected' : '\" + status + \"'}";
        ?>

        function initStatusChange() {
            $('.change-proposal-status').each(function () {
                var id = $(this).attr('id');
                id = id.replace(/status_/g, '');
                var url = '<?php echo site_url('ajax/changeProposalStatus') ?>/' + id;
                var status = 'Click to Edit';
                $(this).editable(url, {
                    //data: "{'Open':'Open','Won':'Won','Completed':'Completed','Lost':'Lost','Cancelled':'Cancelled','On Hold':'On Hold', 'Invoiced via QuickBooks':'Invoiced via QuickBooks'}",
                    data: "<?php echo $statusesString; ?>",
                    type: 'select',
                    onblur: 'submit'
                });
            });

        }

        /* Removed this as the event was firing twice
         $(".change-proposal-status select").live('change', function (e) {
         //alert($(this).children("option").filter(":selected").text());
         e.stopPropagation();
         $(this).parents('form').submit();
         });
         */


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
            var queue = $("#filterQueueValue").val();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setProposalFilter') ?>',
                data: {
                    pFilterUser: user,
                    pFilterStatus: status,
                    pFilterService: service,
                    pFilterFrom: from,
                    pFilterTo: to,
                    pFilterBranch: branch,
                    pFilterQueue: queue
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
            $("#filterQueueValue").val($(this).attr('rel'));
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


        // Populate the toolbar
        $("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');

        /* Select all / none functionality */

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


        /*
         RESEND
         */

        $("#groupResend").click(function () {

            var proceed = checkProposalsSelected();

            if (proceed) {
                $("#resendNum").html($(".groupSelect:checked").length);
                $("#resend-proposals").dialog('open');
            }
        });



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

        // Resend dialog
        $("#resend-proposals").dialog({
            width: 700,
            modal: true,
            buttons: {
                "Resend": {
                    text: 'Send Email',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmResend',
                    click: function () {
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: { 'ids' : getSelectedIds(),
                                    'subject' : $("#messageSubject").val(),
                                    'body' : tinymce.get("message").getContent()},
                            url: "<?php echo site_url('ajax/groupResend') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var resendText = data.count + ' proposal emails were sent';
                                }
                                else {
                                    var resendText = 'An error occurred. Please try again';
                                }

                                $("#resendProposalsStatus").html(resendText);
                                $("#resend-proposals-status").dialog('open');

                            });
                        $(this).dialog('close');
                        $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
                        $("#resend-proposals-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });


        // Resend text editor
        $(document).ready(function () {
            // var template_editor = CKEDITOR.replace('message', {
            //     toolbar: 'Minimum',
            //     height: 400
            // });
            tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
                        elementpath: false,
                        relative_urls : false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'320',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.serviceMenu,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });

        });

        // Template change handler
        $('#templateSelect').change(function() {

            var selectedTemplate = $('#templateSelect option:selected').data('template-id');

            loadTemplateContents(selectedTemplate);
        });

        // Load the selected content
        var defaultTemplate = $('#templateSelect option:selected').data('template-id');
        loadTemplateContents(defaultTemplate);

        function loadTemplateContents(templateId){

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'templateId': templateId},
                url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
                .success(function (data) {
                    $("#messageSubject").val(data.templateSubject);
                    //CKEDITOR.instances.message.setData(data.templateBody);
                    tinymce.get("message").setContent(data.templateBody);
                });

            $.uniform.update();
        }

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
                $("#delete-proposals").dialog({
                    open: function(event, ui) {
                        alert('here');
                    }
                });
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
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedIds()},
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
            show: {
                alert('here');
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

    });
    </script>
    </div>
    </div>
    <div class="javascript_loaded">
        <div id="duplicate-proposal" title="Duplicate Proposal">
            <p class="clearfix" id="duplicate-selected-client">
                Selected Contact: <strong id="clientName">Contact</strong> <a href="#" id="reset-duplicate-client-search">Select other contact</a>
            </p>

            <p class="clearfix" id="duplicate-select-client">
                <label style="width: 100px; text-align: right; margin-right: 10px; float: left;">Select Contact</label>
                <input type="text" name="duplicate-client" id="duplicate-client" style="float: left;" class="text tiptip" title="Type contact's name or company name">
                <a class="btn" href="<?php echo site_url('clients/add') ?>" style="margin-left: 3px;">Add New Contact</a>
            </p>
            <input id="duplicate-client-id" type="hidden" name="duplicate-client-id">
            <input id="duplicate-proposal-id" type="hidden" name="duplicate-proposal-id">
        </div>
        <div id="notes" title="Proposal Notes">
            <form action="#" id="add-note">
                <p>
                    <label>Add Note</label>
                    <input type="text" name="noteText" id="noteText" style="width: 500px;">
                    <input type="hidden" name="relationId" id="relationId" value="0">
                    <input type="submit" value="Add">
                </p>
                <iframe id="notesFrame" src="" frameborder="0" width="100%" height="250"></iframe>
            </form>
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
            <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span id="field_firstName"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span id="field_lastName"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Title:</strong> <span id="field_title"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span id="field_company"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span id="field_email"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span id="field_state"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span id="field_cellPhone"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span id="field_businessPhone"></span></p>

            <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span></p>
        </div>
        <div id="no-proposals-selected" title="Error">
            <p>No proposals were selected!</p>
            <br/>

            <p>Select at least one proposal to carry out a group action</p>
        </div>

        <div id="resend-proposals" title="Confirmation">
            <h3>Confirmation - Send Email</h3>

            <p style="margin-bottom: 15px;">Select Email Template

                <select id="templateSelect">
                <?php 
                    foreach ($clientTemplates as $template) {
                    /* @var $template \models\ClientEmailTemplate */            
                ?>
                    <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
                <?php 
                    } 
                ?>
                </select>
                <?php
                    if ($account->isAdministrator()) {
                ?>
                        <!--
                    <a href="<?php echo site_url('account/company_email_templates'); ?>">Edit Email Templates</a>
                        -->
                <?php
                    }
                ?>
            </p>

            <p>Subject: <input class="text" type="text" id="messageSubject" style="width: 300px;"></p><br />

            <textarea id="message">This is the content</textarea>


            <p>This will send a total of <strong><span id="resendNum"></span></strong> email(s) to their respective contact.</p>
            <br/>

            <p>Are you sure that you want to proceed?</p>
        </div>

        <div id="resend-proposals-status" title="Confirmation">
            <h3>Confirmation - Resend Proposals</h3>

            <p id="resendProposalsStatus"></p>
        </div>

        <div id="delete-proposals" title="Confirmation">
            <h3>Confirmation - Delete Proposals</h3>

            <p>This will delete a total of <strong><span id="deleteNum"></span></strong> proposals.</p>
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
                    <?php foreach ($statuses as $k => $v) { ?>
                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
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

    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>