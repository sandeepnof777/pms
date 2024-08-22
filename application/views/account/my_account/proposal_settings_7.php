<!-- add a back button -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3>
<form action="<?php echo site_url('account/company_proposal_settings7') ?>" method="post" id="addLinkForm">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td><input type="text" name="name" id="name" placeholder="Name" style="width: 97%;"></td>
            <td><input type="text" name="url" id="url" placeholder="http://..." style="width: 97%;"></td>
            <td><input type="submit" value="Add Link" class="btn small" id="addLink"></td>
        </tr>
    </table>
</form>

<p style="padding: 20px;">The links defined here will show up in the "External Links" section on the edit proposal page by default. To add proposal specific links, just click the add button on the proposal edit page.</p>

<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td width="40%">Name</td>
        <td width="40%">Link</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $k = 0;
    foreach ($proposal_links as $link) {
        $k++;
        ?>
        <tr class="<?php echo ($k % 2) ? 'odd' : 'even' ?>">
            <td class="text-right editLinkName" id="name_<?php echo $link->id ?>"><?php echo $link->name ?></td>
            <td class="text-right editLinkURL" id="url_<?php echo $link->id ?>"><?php echo $link->url ?></td>
            <td><a href="#" class="btn deleteLink" data-id="<?php echo $link->id ?>">Delete</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script type="text/javascript">
    $("#addLinkForm").on('submit', function () {
        if ($("#name").val().length == 0 || $("#url").val().length == 0) {
            alert("Name and URL are required!");
            return false;
        }
    });
    $(".deleteLink").on('click', function () {
        if (confirm('Are you sure you want to delete the link?')) {
            document.location.href = '<?php echo site_url('account/deleteProposalLink') ?>/' + $(this).data('id');
        }
        return false;
    });
    $(".editLinkName").editable('<?php echo site_url('ajax/editProposalLinkName') ?>', {
        cancel: 'Cancel',
        submit: 'Save'
    });
    $(".editLinkURL").editable('<?php echo site_url('ajax/editProposalLinkURL') ?>', {
        cancel: 'Cancel',
        submit: 'Save'
    });
</script>

<!--

<div id="imageProcessing" title="Confirmation">

    <div style="text-align: center">
        <p>
            Image Processing <br/>
            <img src="/static/loading.gif"/>
        </p>
        <br />
        <p>Please wait a moment while the image is processed</p>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("#currentImage").css('opacity', $("#imageOpacity").val());
        $(".preview-heading").css('background-color', hexToRgb('#' + $("#headerBgColor").val()));
        $(".preview-heading").css('color', '#' + $("#headerFontColor").val());

        $("#imageOpacity").change(function(){
            $("#currentImage").css('opacity', $(this).val());
        });

        $("#saveImage").click(function() {
           $("#imageProcessing").dialog('open');
            return true;
        });

        $("#imageProcessing").dialog({
            width: 400,
            modal: true,
            buttons: {
            },
            autoOpen: false
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#currentImage').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gradientImage").change(function(){
            readURL(this);
            $("#previewContainer").show();
        });

    });

    function updateBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("background-color", rgbColor);
    }

    function updateHeadingPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("color", rgbColor);
    }

    function hexToRgb(hex){
        hex = hex.toLowerCase();
        if(/^#([a-f0-9]{3}){1,2}$/.test(hex)){
            if(hex.length== 4){
                hex= '#'+[hex[1], hex[1], hex[2], hex[2], hex[3], hex[3]].join('');
            }
            var c= '0x'+hex.substring(1);
            return 'rgb('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+')';
        }
    }


</script>
-->