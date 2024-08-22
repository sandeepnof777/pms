<?php $this->load->view('global/header'); ?>

<div id="content" class="clearfix javascript_loaded">
    <div class="widthfix">


    <table id="qbSyncTable">
        <thead>
            <tr>
                <th><?php echo SITE_NAME;?></th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>QuickBooks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="contactCard contactCardLeft">
                        <div class="layersLogo"></div>
                        <address>
                            <strong>Andy Long</strong><br>
                            Company Name<br><br />
                            63 N 4th St<br>
                            Batavia, OH 45103<br>
                            <abbr title="Phone">P:</abbr> 513-878-5791
                        </address>

                    </div>
                </td>
                <td><input type="radio"></td>
                <td><input type="radio"></td>

                <td>
                    <div class="contactCard contactCardRight">
                        <div class="qbLogo"></div>

                        <address>
                            <strong>QuickBooks Contact</strong><br>



                            <abbr title="Phone">P:</abbr> 513-477-2727
                        </address>

                    </div>
                </td>

            </tr>
            <tr>
                <td>
                    <div class="contactCard contactCardLeft">
                        <div class="layersLogo"></div>
                        <address>
                            <strong>Bob Smith</strong><br>
                            Company Name<br><br />
                            63 N 4th St<br>
                            Batavia, OH 45103<br>
                            <abbr title="Phone">P:</abbr> 513-878-5791
                        </address>

                    </div>
                </td>
                <td><input type="radio"></td>
                <td><input type="radio"></td>

                <td>
                    <div class="contactCard contactCardRight">
                        <div class="qbLogo"></div>

                        <address>
                            <strong>Eric Cartman</strong><br>



                            <abbr title="Phone">P:</abbr> 513-477-2727
                        </address>

                    </div>
                </td>

            </tr>

        </tbody>
   </table>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#qbSyncTable').dataTable();
    });


</script>

<?php $this->load->view('global/footer'); ?>