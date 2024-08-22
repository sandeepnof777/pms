<?php $this->load->view('global/header'); ?>


    <div id="content" class="clearfix">

        <div class="content-box">

            <div class="box-header">
                Stats Table
            </div>

            <div class="box-content">

                <table id="estimateLineItemTable" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <script type="text/javascript">

        $(document).ready(function () {

            var uuid = 'abc123';

            $("#estimateLineItemTable").DataTable({
                "order": [[0, "desc"]],
                "bProcessing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "ajax" : {
                    "url": "<?php echo site_url('ajax/uuidEstimateItems'); ?>/" + uuid,
                    "type": "GET"
                },
                "aoColumns": [
                    {'bVisible': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                ],
                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HtiprF',
            });

        });
    </script>
<?php $this->load->view('global/footer'); ?>