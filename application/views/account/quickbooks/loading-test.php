<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">
        <div class="widthfix">

            <a href="#loading" id="loader" class="btn fancybox.inline">Load</a>

        </div>
    </div>

    <div style="display: none" id="qbLoading">
        <p style="text-align: center; margin-bottom: 20px;">Communicating with QuickBooks</p>
        <p style="text-align: center"><img src="/static/loading_animation.gif" /></p>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#loader').fancybox({
                width: 300,
                height: 50,
                scrolling: 'no'
            });
        });
    </script>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>