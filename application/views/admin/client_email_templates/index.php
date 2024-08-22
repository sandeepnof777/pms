<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <?php
        switch ( $action ) {
            case 'edit':
            case 'add':
            case 'duplicate':
                $this->load->view('admin/client_email_templates/template-form');
                break;
            default:
                $this->load->view('admin/client_email_templates/template-tables');
        }
        ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {





        /*

        var template_editor = CKEDITOR.replace('body', {
            toolbar: 'Minimum'
        });
        //add tag
        $("#addAtCursor").click(function () {
            CKEDITOR.instances.body.insertText($("#field").val());
        });

        */
    });
</script>
<?php $this->load->view('global/footer'); ?>