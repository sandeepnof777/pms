<?php $this->load->view('global/header') ?>
    <div id="content" class="clearfix dashboard">
        <div class="widthfix" id="calculators">
            <div class="content-box">
                <div class="box-header">
                    Check out all of our calculators!
                </div>
                <div class="box-content padded">
                    <a class="btn" href="<?php echo site_url('account/calculators/sealcoating') ?>">Sealcoating Calc</a>
                    <a class="btn" href="<?php echo site_url('account/calculators/crackseal') ?>">CrackSeal Calc</a>
                    <a class="btn" href="<?php echo site_url('account/calculators/striping') ?>">Striping Calc</a>
                    <!--                    <a class="btn" href="--><?php //echo site_url('account/calculators/tankmix') ?><!--">Tank Mix Design Calc</a>-->
                </div>
            </div>
            <div class="clearfix">
                <?php
                switch ($this->uri->segment(3)) {
                    case 'sealcoating':
                        $this->load->view('account/calculators/sealcoat');
                        break;
                    case 'crackseal':
                        $this->load->view('account/calculators/crackseal');
                        break;
                    case 'striping':
                        $this->load->view('account/calculators/striping');
                        break;
                    case 'tankmix':
                        $this->load->view('account/calculators/tankmix');
                        break;
                }
                ?>
            </div>
        </div>
        <h4 class="centered">Proudly offered by:</h4>

        <p class="clearfix centered">
            <a href="<?= base_url();?>" target="_blank">
                <img src="<?= base_url();?>/static/images/logo.png" alt="<?php echo SITE_NAME;?>"/>
            </a>

        </p>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            function addCommas(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }

            /*
             * The print function
             * */
            $.printCalc = function (settings) {
                //do some checks
                if (typeof(settings.title) == 'undefined') {
                    settings.title = 'No Title';
                }
                if (typeof(settings.project_name) == 'undefined') {
                    settings.project_name = 'No Project Name';
                }
                //do post
                var request = $.ajax({
                    url: "<?php echo site_url('ajax/printCalc') ?>",
                    type: "POST",
                    dataType: "html",
                    data: settings,
                    success: function (data) {
                        //new Window
                        printWindow = window.open("<?php echo site_url('ajax/printCalc') ?>", '_blank', 'width=800,height=500,scrollbars=1');
                        printWindow.document.write(data);
                        printWindow.print();
                    }
                });
            }
            $(":text").click(function () {
                $(this).val('');
            });
            //Number formats
            $('.numberFormat').each(function () {
                $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true, symbol: '' });
            });
            $('.numberFormat').keyup(function () {
                $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true, symbol: '' });
            });
        });
    </script>
    <!--#content-->
<?php $this->load->view('global/footer') ?>