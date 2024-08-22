<?php
echo $this->html->getBodyCodes();
?>
<!--Errors and Success Messages-->
<?php if ($this->session->flashdata('error') || $this->session->flashdata('notice') || $this->session->flashdata('success') || validation_errors()):
    $type = 'warning';
    $message = $this->session->flashdata('error');
    $title = 'Error';
    if ($this->session->flashdata('notice')) {
        $type = 'info';
        $message = $this->session->flashdata('notice');
        $title = 'Notice';
    }
    if ($this->session->flashdata('success')) {
        $type = 'success';
        $message = $this->session->flashdata('success');
        $title = 'Success';
    }
    ?>
    <script>
        $(document).ready(function () {

            swal({
                title: '<?= $title ?>',
                text: '<?= $message ?>',
                width: '350px',
                html: false
            });
            $('.swal2-select').addClass('dont-uniform');
        });
    </script>
<?php endif; ?>

<!--Verification code: fqw##859!@ -->
</body>
</html>