<?php $this->load->view('global/header-admin'); ?>
<?php
// Variables in this view
/* @var $activeCompanies array */
/* @var $activeUsers integer */
/* @var $numTrialCompanies integer */
?>

<div id="content" class="clearfix">
    <div class="widthfix">

        <div class="materialize">

            <div class="row">
                <div class="col s3">
                    <ul class="collection">
                        <li class="collection-item">
                            <a href="<?php echo site_url('admin/company_data/Active'); ?>">
                            <span class="badge new"><?php echo count($activeCompanies) ?></span>
                            Active Companies
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col s3">
                    <ul class="collection">
                        <li class="collection-item">
                            <span class="badge new"><?php echo $activeUsers; ?></span>
                            Active Users
                        </li>
                    </ul>
                </div>
                <div class="col s3">
                    <ul class="collection">
                        <li class="collection-item">
                            <a href="<?php echo site_url('admin/company_data/Trial/Active'); ?>">
                            <span class="badge new"><?php echo $numActiveTrialCompanies; ?></span>
                            Active Trials
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col s3">
                    <ul class="collection">
                        <li class="collection-item">
                            <a href="<?php echo site_url('admin/company_data/Trial/Expired'); ?>">
                            <span class="badge new"><?php echo $numExpiredTrialCompanies; ?></span>
                            Expired Trials
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>

        <div class="content-box">
            <div class="box-header">
                Company Data
            </div>
            <div class="box-content">
                <table id="companyDataTable" class="display">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Users</th>
                        <th>Secretaries</th>
                        <th>WiO</th>
                        <th>Total Value</th>
                        <th>Next Expiry Timestamp</th>
                        <th>Next Expiry</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($activeCompanies as $companyId => $companyData) {

                        ?>
                        <tr>
                            <td><?php echo $companyId ?></td>
                            <td><?php echo $companyData['companyName']; ?></td>
                            <td><?php echo $companyData['companyStatus']; ?></td>
                            <td><a href="<?php echo site_url('admin/accounts/' . $companyId) ?>"><?php echo $companyData['activeUsers']; ?></a></td>
                            <td><?php echo $companyData['activeSecretaries']; ?></td>
                            <td><?php echo $companyData['activeWio']; ?></td>
                            <td><?php echo '$' . number_format($companyData['totalValue']); ?></td>
                            <td><?php echo $companyData['nextExpiryTime']; ?></td>
                            <td><?php echo ($companyData['nextExpiryTime']) ? ($companyData['nextExpiry']): '-'; ?></td>
                            <td><a class="btn tiptip" title="Login as admin [<?php echo $companyData['adminName']; ?>]" href="<?php echo site_url('admin/sublogin/' . $companyData['adminId']) ?>">
                                    <i class="fa fa-fw fa-sign-in"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('#companyDataTable').dataTable({
            "bProcessing": true,
            "aoColumns": [
                null, //0
                null, //1
                null, //1
                {className: "dtCenter"}, //2
                {className: "dtCenter"}, //3
                {className: "dtCenter"}, //4
                null, //5
                {"bVisible": false}, //6
                {"iDataSort": 7}, // 7
                {"bSortable": false}
            ],
            "bJQueryUI": true,
            "bAutoWidth": false,
            "bPaginate" : true,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "aaSorting": [
                [2, "desc"]
            ],
            "bStateSave": true
        });


    });


</script>

<?php $this->load->view('global/footer'); ?>
