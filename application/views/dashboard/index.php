<?php $this->load->view('global/header') ?>
<?php
//some_function_to_cause_error();
?>
    <div id="content" class="clearfix dashboard">
    <div class="widthfix">
    <div class="content-box light">
        <?php if (help_box(16)) {
            ?>
            <div class="help tiptip center" style="position: absolute; left: 50%; margin-left: -55px; top: 143px; z-index: 200;" title="Help"><?php help_box(16, true) ?></div>
        <?php
        } ?>
        <div class="box-header clearfix">
            <div class="half left">
                <form action="<?php echo site_url('proposals/search') ?>" method="post">
                    <input type="text" value="Enter Proposal Name / Job #" title="Enter Proposal Name" name="searchProposal" id="searchProposal" style="width: 200px; float: left; margin-right: 3px; text-align: center;"
                           class="text" onblur="if (this.value == '') {this.value = 'Enter Proposal Name / Job #';}" onfocus="$('#searchClient').val('Enter Contact Name'); if (this.value == 'Enter Proposal Name / Job #') {this.value = '';}">
                    <input class="box-action" type="submit" value="Search" style="float: left;">
                </form>
            </div>
            <div class="half right">
                <form action="<?php echo site_url('clients/search') ?>" method="post">
                    <input class="box-action" type="submit" value="Search">
                    <input type="text" value="Enter Contact Name" title="Enter Contact Name" name="searchClient" id="searchClient" style="width: 200px; float: right; margin-right: 3px; text-align: center;"
                           class="text" onblur="if (this.value == '') {this.value = 'Enter Contact Name';}" onfocus="$('#searchProposal').val('Enter Proposal Name'); if (this.value == 'Enter Contact Name') {this.value = '';}">
                </form>
            </div>
        </div>
        <div class="box-content padded">
            <ul id="actions">
                <li id="quick-add-proposal2">
                    <a href="<?php echo site_url('clients') ?>" class="tiptip" title="Add a new proposal for an existing contact">
                        <span class="icon"></span>
                        <span class="label">Add Proposal <br> Existing Contact</span>
                    </a>
                </li>

                <li id="quick-add-proposal">
                    <a href="<?php echo site_url('clients/add') ?>" class="tiptip" title="Add a new contact for adding a proposal">
                        <span class="icon"></span>
                        <span class="label">Add Proposal <br> New Contact</span>
                    </a>
                </li>
                <li id="quick-add-client">
                    <a href="<?php echo site_url('clients/add') ?>" class="tiptip" title="Add a new contact">
                        <span class="icon"></span>
                        <span class="label">Add Contact</span>
                    </a>
                </li>
                <li id="quick-proposals">
                    <a href="<?php echo site_url('proposals') ?>" class="tiptip" title="Edit your proposals here">
                        <span class="icon"></span>
                        <span class="label">Edit Proposal</span>
                    </a>
                </li>
                <li id="quick-add-prospect">
                    <a href="<?php echo site_url('prospects/add') ?>" class="tiptip" title="Add a new prospect">
                        <span class="icon"></span>
                        <span class="label">Add Prospect</span>
                    </a>
                </li>
                <li id="quick-add-lead">
                    <a href="<?php echo site_url('leads/add') ?>" class="tiptip" title="Add a new lead">
                        <span class="icon"></span>
                        <span class="label">Add Lead</span>
                    </a>
                </li>
                <!--
                <li id="quick-quickbooks">
                    <a href="<?php echo site_url('account/quickbooks') ?>" class="tiptip" title="Sync clients and invoice proposals with QuickBooks">
                        <span class="icon"></span>
                        <span class="label">QuickBooks</span>
                    </a>
                </li>
                -->
                <li id="quick-calculators">
                    <a href="<?php echo site_url('account/calculators') ?>" class="tiptip" title="Our Calculators">
                        <span class="icon"></span>
                        <span class="label">Our Calculators</span>
                    </a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix">
    <div class="clearfix">
        <div class="content-box left half" style="overflow: visible;">
            <div class="box-header centered">Your Pipeline</div>
            <div class="box-content padded">
                <div class="clearfix" style="margin-bottom: 5px; position: relative;">
                    <input type="text" name="from" id="from" class="text left" value="<?php echo date('n/j/Y', $firstWonDate) ?>" style="width: 65px; margin-top: 2px;">
                    <label class="left" style="margin: 5px 2px 0;">To</label>
                    <input type="text" name="to" id="to" class="text left" value="<?php echo date('n/j/Y') ?>" style="width: 65px; margin-top: 2px; margin-right: 4px;">
                    <?php if ($account->getUserClass() >= 2) { ?>
                        <select name="branch" id="branch" style="margin-top: -2px;" class="left">
                            <option value="All">All Branches</option>
                            <option value="0">Main</option>
                            <?php foreach ($branches as $branch) {
                                ?>
                                <option value="<?php echo $branch->getBranchId() ?>"><?php echo $branch->getBranchName(); ?></option><?php
                            } ?>
                        </select>
                    <?php } ?>
                    <a class="btn blue" style="display: none; position: absolute; right: <?php echo ($account->getUserClass() >= 2) ? 21 : 220 ?>px; top: -1px;" href="#" id="plot">Show</a>
                </div>

                <div id="pipeline_kendo" style="height: 277px;"></div>
            </div>
        </div>
        <div class="content-box right half">
            <div class="box-header centered">Top 10 Open Proposals</div>
            <div class="box-content">
                <table class="boxed-table1" width="100%" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <td class="centered">#</td>
                        <td class="centered">Date</td>
                        <td class="centered">Company</td>
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
                                <td class="centered"><a class="tiptip" title="View <?php echo $proposal->projectName ?> Proposal" href="<?php echo site_url('proposals/edit/' . $proposal->proposalId . '/preview') ?>"><?php echo $proposal->projectName ?></a></td>
                                <td class="centered">
                                    <span class="price-tiptip2" title="<b>Price Breakdown</b><?php echo $priceBreakdown; ?>">$<?php echo number_format($proposal->price) ?></span>
                                </td>
                            </tr>
                        <?php
                        }
                        if ($k == 0) {
                            ?>
                            <tr>
                                <td colspan="5" class="centered">No information to display.</td>
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
    <div class="content-box">
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
                        <td colspan="5" class="centered">No information to display.</td>
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
                            <td class="centered"><a class="tiptip" href="<?php echo site_url('leads/edit/' . $lead->leadId) ?>" title="View Lead Details"><?php echo $lead->projectName ?></a></td>
                            <td class="centered"><span class="tiptip" title="<strong>Title:</strong><?php echo $lead->title ?><br> <strong>Cell:</strong><?php echo $lead->cellPhone; ?> <br> <strong>Phone:</strong> <?php echo $lead->businessPhone; ?><p class='clearfix'></p>"><?php echo $lead->firstName . ' ' . $lead->lastName ?></span></td>
                            <td class="centered"><?php
                                if (isset($accounts[$lead->account])) {
                                    ?>
                                    <span class="tiptip" title="<?php echo $accounts[$lead->account]->getFullName() ?>"><?php
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
                                }?></td>
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
    </div>
    <script src="<?=site_url('3rdparty/DataTables-new/datatables.min.js');?>"></script>
<script src="<?=site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.jqueryui.min.js');?>"></script>


<link rel="stylesheet" type="text/css" href="<?=site_url('3rdparty/DataTables-new/datatables.min.css');?>" media="all">
    <script type="text/javascript">
        $(document).ready(function () {

            $(".boxed-table").DataTable({
                "ordering" : false,
                "searching" : false,
                "paging": false,
                "jQueryUI": true,
                "deferLoading": 0
        });
            //show button code
            $("#from, #to, #branch").change(function () {
                $("#plot").show();
            });
            //
            <?php
            $curMonthJS = (date('n') - 1);
            $minMonthJS = (date('n', $minDate) - 1);
            ?>
            var minDate = new Date(<?php echo date('Y,' . $minMonthJS . ',j', $minDate) ?>);
            var maxDate = new Date(<?php echo date('Y,' . $curMonthJS . ',j') ?>);
            var firstWonDate = new Date(<?php echo date('Y,n,j', $firstWonDate) ?>);
            $("#from").datepicker({
                minDate: minDate,
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#to").datepicker("option", "minDate", selectedDate);
                }
            });
            $("#to").datepicker({
                maxDate: maxDate,
                changeMonth: true,
                changeYear: true,
                onClose: function (selectedDate) {
                    $("#from").datepicker("option", "maxDate", selectedDate);
                }
            });
            $("#plot").click(function () {
                plotPie();
                $(this).hide();
                return false;
            });

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

            function plotPie() {
                $.ajax({
                    url: '<?php echo site_url('ajax/getPieData') ?>',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        from: $("#from").val(),
                        to: $("#to").val()<?php
                        if ($account->getUserClass()>=2) {
                        ?>,
                        branch: $("#branch").val()
                        <?php
                        }
                         ?>
                    },
                    success: function (data) {
                        drawKendoPie(data);
                    }
                });
            }

            function drawKendoPie(data) {
                var defaultSeriesColors = [ "#EDC240", "#3366CC", "#CB4B4B", "#4DA74D", "#944DED", "#49AFCD", "#E6813E" ];
                $("#pipeline_kendo").kendoChart({
                    legend: {
                        position: "left",
                        offsetY: 75
                    },
                    seriesDefaults: {
                        labels: {
                            visible: false,
                            format: "C",
                            template: "#= category # - $#= value #"
                        }
                    },
                    series: [
                        {
                            type: "pie",
                            data: data,
                            padding: 15
                        }
                    ],
                    seriesColors: defaultSeriesColors,
                    tooltip: {
                        visible: true,
                        format: "C",
                        template: "<b>#= category #</b> <br> #= kendo.toString(value,'C') #",
                        padding: 2
                    }

                });
            }

            plotPie();
        });
    </script>
    </div>
    </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer') ?>