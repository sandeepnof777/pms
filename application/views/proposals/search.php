<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">
    <div class="widthfix">
    <h3 class="centered">
        <?php if ($this->uri->segment(2) == 'searchProposals') { ?>
            Viewing results for "<?php echo $this->input->post('searchProposal') ?>". Showing first 20 results. <br>
        <?php
        } else {
            ?>
            Showing Proposals for <?php echo $clientCompany ?>.
        <?php } ?>
        <a href="<?php echo site_url('proposals') ?>">View All Proposals</a>
    </h3>

    <div class="content-box">
        <div class="box-header">
            <span id="proposals-box-name" style="color: #E6E8EB;">
                <?php echo ($this->uri->segment(2) == 'clientProposals') ? $clientCompany . ' | All Proposals' : 'Proposals'; ?>
            </span>
        </div>
        <div class="box-content">
            <?php $this->load->view('templates/proposals/table/table'); ?>
        </div>
    </div>
        <?php $this->load->view('templates/proposals/table/table-js'); ?>
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
        $("#filter").live('click',function () {
            $("#filter-dialog").dialog('open');
        });
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 500,
            values: [ 75, 300 ],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
        $("#alldates").live('click',function () {
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
//                    document.location.href = $("#client-delete").attr('rel');
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
        $(".btn-notes").live('click', function () {
            var id = $(this).attr('rel');
            var frameUrl = '<?php echo site_url('account/notes/proposal') ?>/' + id;
            $("#notesFrame").attr('src', frameUrl);
            $("#relationId").val(id);
            $('#notesFrame').load(function () {
                $("#notes").dialog('open');
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
        $("#services_dropdowns").hide();
        $("#AllServices").attr('checked', 'checked');
        $("#buttonset2 input").change(function () {
            if ($(this).val() == '1') {
                $("#services_dropdowns").show();
            } else {
                $("#services_dropdowns").hide();
            }
        });

        $("#reset-filter").live('click',function () {
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
                    initProposals();
                    $("#proposals-filter-box-name").html('Proposals Filter');
                }
            });
            return false;
        });
        $("#apply-filter").live('click',function () {
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
                        initProposals();
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
        $("#reset-duplicate-client-search").live('click',function () {
            resetDuplicateDialog();
        });

        <?php
                $first = true;
                $statusesString = '{';
                foreach($statuses as $k=>$v) {
                    if(!$first){
                        $statusesString.= ', ';
                    }
                    $statusesString.= "'" . $k . "' : '" . $v . "'";

                    $first = false;
                }
                $statusesString .= ", 'selected' : '\" + status + \"'}";
                ?>

        function initStatusChange() {
            $('.change-proposal-status').each(function () {
                var id = $(this).attr('id');
                id = id.replace(/status_/g, '');
                var url = '<?php echo site_url('ajax/changeProposalStatus') ?>/' + id;
                var status = $(this).html();
                $(this).editable(url, {
                    data: "<?php echo $statusesString; ?>",
                    type: 'select',
                    onblur: 'submit'
                });
            });
        }

        /* Removed as the event was firing twice
        $(".change-proposal-status select").live('change', function () {
            $(this).parents('form').submit();
        });
        */
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
                <input type="text" name="duplicate-client" id="duplicate-client" style="float: left;" class="text tiptip" title="Type client's name or company name">
            </p>
            <input id="duplicate-client-id" type="hidden" name="duplicate-client-id">
            <input id="duplicate-proposal-id" type="hidden" name="duplicate-proposal-id">
        </div>
        <div id="notes" title="Notes">
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
        <div id="confirm-delete-message" title="Confirmation">
            <p>Are you sure you want to delete this proposal?</p>
            <a id="client-delete" href="" rel=""></a>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>