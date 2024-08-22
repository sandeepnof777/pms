<?php $this->load->view('global/header-admin'); ?>
<style>

.box-action a, a:link, a:visited{
    margin-bottom: 3px!important;
}
    #dataTables-history-new td {
        padding-left: 5px;
    }
    #dataTables-history-new th {
        text-align: left !important;
    }
    th.sorting_asc,
    th.sorting {
        text-align: left !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
    }
    .dataTables_filter {float: left !important;text-align: left !important;width: 50% !important;}
    .dataTables_length {margin-top: 5px!important;}

    .paging_full_numbers {
        width: 500px !important;
    }
 
    /* Change border color when the select box is focused */
    select[name="dataTables-quickbook-error_length"].focused-visible,
    select[name="dataTables-quickbook-error_length"].option-selected {
        border-color: #666;
    }

    /* Apply default focus styling for accessibility */
    select[name="dataTables-quickbook-error_length"]:focus-visible {
        outline: unset !important;
    }
    #dataTables-quickbook-error
    {
        top:-24px!important;
        position:relative!important;
    }
    ::selection {
        background: #25AAE1;
        color: #fff;
    }
    .row_red .color_highlight a {
        background: #ff0000;
        padding: 3px 13px;
        border-radius: 5px;
        color: #fff;
        font-size: 12px;
    }
    .row_green .color_highlight a {
        background: #027300;
        padding: 3px 6px;
        border-radius: 5px;
        color: #fff;

    }
    .error_data {
        text-align: justify;
    }

    .inovice_filter {
     width:325px;
     float:left;
     margin-left:5px;
}

.inovice_filter_span{
   float:left;
   margin-top:15px;
}
.box-content .ui-corner-tl
{
    width: 719px!important;
    margin-left:214px!important;
    top: -24px;
    position: relative;
} 
div.selector
{
    top:8px!important;
    border:unset!important;
}
div.selector span {
   width: 95px!important;
   padding: 0px!important;
 }

 div.selector select
 {
    min-width: 95px!important;
   padding: 0px!important;
 }

 .dataTables_paginate
 {
    margin-bottom: -20px!important;
 }

    /* add css for sorting icon */
</style>

<div id="content" class="clearfix">
    <div class="widthfix">

        <div class="clearfix"></div>
        <div class="content-box">
            <div class="box-header">
                <div>QuickBook Sync <?php if (!$this->uri->segment(3)) { ?> <?php } else { ?>(<?php echo $company->getCompanyName() ?>)<?php } ?>
                        <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div id="proposalsTableLoader" style="width: 150px; float: left; display: none; margin-left: 413px;margin-top:-17px;">
                    <img src="/static/loading-bars.svg" />
                </div>
            </div>

            <div class="inovice_filter">
                <span class="inovice_filter_span">Entity Type &nbsp;</span>
                <select name="dataTables-quickbook-error_length" aria-controls="dataTables-quickbook-error" class="filter-select">
                    <option value="">Please Select</option>
                    <option value="proposal">Proposal</option>
                    <option value="service">Service</option>
                    <option value="customer">Customer</option>
                    </select>
            </div> 

            <div class="box-content">
                <table cellpadding="0" cellspacing="0" id="dataTables-quickbook-error" border="0" class="dataTables-history-new display">
                    <thead>
                        <tr>
                            <th>Entity Id</th>
                            <th>Entity Type</th>
                            <th>Entity Name</th>
                            <th>Sync At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="loader" style="display: none;">
                    <!-- Your loader HTML or image goes here -->
                    <img src="path/to/loading.gif" alt="Loading..." />
                </div>
            </div>
        </div>
    </div>
</div>

<div id="datatablesError" title="Error" style="text-align: center; display: none;">
    <h3>Oops, something went wrong</h3>
    <p>We're having a problem loading this page.</p><br />
    <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact
            support</a> if this keeps happening.</p>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Datatables error Dialog
        $("#datatablesError").dialog({
            width: 500,
            modal: true,
            buttons: {
                Retry: function() {
                    window.location.reload();
                }
            },
            autoOpen: false
        });
    });
</script>


<script type="text/javascript">
    <?php $ajaxUrl = ($this->uri->segment(3)) ? 'ajax/quickbook_error/' . $this->uri->segment(3) : 'ajax/quickbook_error' ?>
    var ui;
    var oTable;
    var selectedValue="";
  
    $(document).ready(function() {

        oTable = $('#dataTables-quickbook-error').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
                $("#datatablesError").dialog('open');
            })
            .on('processing.dt', function(e, settings, processing) {
                if (processing) {
                      
                    $("#proposalsTableLoader").show();
                 } else {
                    $("#proposalsTableLoader").hide();
                }
            })
            .DataTable({
                "processing": true,
                "serverSide": true,
                "preDrawCallback": function(settings) {
                    if ($.fn.DataTable.isDataTable('#dataTables-quickbook-error')) {
                        var dt = $('#dataTables-quickbook-error').DataTable();

                        //Abort previous ajax request if it is still in process.
                        var settings = dt.settings();
                        if (settings[0].jqXHR) {
                            settings[0].jqXHR.abort();
                        }
                    }
                },
                "ajax": {
                    "url": "<?php echo site_url($ajaxUrl); ?>",
                    "dataType": "json",
                    "type": "POST"
                  
                },
                "columns": [{
                        "data": "entity_id",
                        "width": "7%"
                    },
                    {
                        "data": "entity_type",
                        "width": "7%"
                    },
                    {
                        "data": "entity_name",
                        "width": "25%"
                    },
                    {
                        "data": "synch_time",
                        "width": "7%",
                    },
                    {
                        "data": "statusData",
                        "width": "7%",
                        class: 'dtCenter color_highlight'
                    },
                ],
                "columnDefs": [{
                    "targets": [0],
                    "width": '5px',
                    "searchable": true,
                    "sortable": true
                }, ],
                "order": [
                    [1, 'desc']
                ],
                "jQueryUI": true,
                "paginationType": "full_numbers",
                "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                "lengthMenu": [
                    [10, 25, 50, 100, 200, 500, 1000],
                    [10, 25, 50, 100, 200, 500, 1000]
                ],
                "rowCallback": function(row, data, index) {
                    if (data.status == 1) {
                        $(row).addClass('row_green'); // Add class for green color
                        $(row).removeClass('row_red'); // Remove class for red color
                    } else {
                        $(row).addClass('row_red'); // Add class for red color
                        $(row).removeClass('row_green'); // Remove class for green color
                    }
                    $(row).find('.RedstatusData a').on('click', function() {
                        // Show Swal with QBError data
                        swal({
                            title: "Error",
                            html: "<div class='error_data'>" + data.QBError + "</div>",
                            showCancelButton: false,
                            confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                            dangerMode: false,
                            width: 700,
                            showCloseButton: true,

                        });
                    });
                },
                "drawCallback": function(settings) {
                    if (!ui) {
                        initUI(true);
                        ui = false;
                    }

                } 
            });
    
     // Delegate change event to the document and filter it to select elements with class 'inovice_filter'
    $(document).on('change', '.inovice_filter select', function() {
        // Get the selected value of the inovice_filter
          selectedValue = $(this).val();

        // Update the AJAX URL with the selected value
        var newUrl = '<?php echo site_url($ajaxUrl); ?>';
        if (selectedValue) {
            newUrl += '?inovice-filter=' + selectedValue;
             selectedValue = selectedValue.charAt(0).toUpperCase() + selectedValue.slice(1).toLowerCase();

         }

                oTable.clear().draw();

                // Update the AJAX URL for oTable
                oTable.ajax.url(newUrl).load(function(response) {
                // Check if there are rows returned
                if (oTable.rows().count() === 0) {
                // Update the message when no records are found
                $('.dataTables_empty').html('No matching records found ' + '<b>'+selectedValue+'</b>');
                }
                });

        // Update the AJAX URL for oTable
        oTable.ajax.url(newUrl).load();
    }); 
            $("#dataTables-quickbook-error").on('draw.dt', function(){
            $('#dataTables-quickbook-error .dataTables_empty').html('No matching records found ' + '<b>'+selectedValue+'</b>');
    });
});


 
</script>


<?php $this->load->view('global/footer'); ?>