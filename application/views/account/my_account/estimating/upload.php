<h3>
    Estimating Items Upload
    <a href="#" class="btn blue-button small-button" id="downloadTemplate">
        <i class="fa fa-fw fa-download"></i>
        Download .csv Template
    </a>
</h3>


<form id="uploadForm" enctype="multipart/form-data">
<div>
    <p style="padding: 10px;">
        Upload File
        <input type="file" name="uploadCsv" id="uploadCsv" accept=".csv" />
    </p>

    <p style="padding: 10px;">
        <button class="btn blue-button" id="uploadBtn" type="submit">
            <i class="fa fa-fw fa-upload"></i> Upload File
        </button>
    </p>

</div>
</form>

<script type="text/javascript">

    var uploadInput = document.getElementById('uploadCsv');

    $(document).ready(function() {


        $("#uploadForm").submit(function(event) {

            event.preventDefault();

            // Check for file
            var file = $("#uploadCsv").val();

            if (!file) {
                swal('Please select a file to upload');
                return false;
            }

            // We have a file - send the data
            $.ajax({
                url: "<?php echo site_url('ajax/upload_estimate_items') ?>",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                dataType: "json",
                beforeSend : function()
                {
                    swal({
                        title: 'Uploading File',
                        text: 'Please Wait',
                        showCancelButton: false,
                        showConfirmButton: false
                    }).then(
                        function () {},
                        // handling the promise rejection
                        function (dismiss) {

                        }
                    )
                },
                success: function(data)
                {
                    swal.close();

                    console.log(data.error);

                    if (data.error) {
                        swal('Error', "Cell " + data.errorDetails.column + data.errorDetails.row + ": " + data.errorDetails.message
                             + "<br /><br />Please edit your file and try again. No items were imported");
                    } else {
                        swal('File OK');
                    }
                },
                error: function(e)
                {
                    swal.close();
                    swal('An error occurred');
                }
            });

            return false;
        });


        // End document ready
    });


</script>