<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Total Statistics
            </div>
            <div class="box-content padded">
                <table class="display" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="15%" align="right"><strong>Contacts:</strong></td>
                        <td width="10%"><?php echo @$clients ?></td>
                        <td width="15%" align="right"><strong>Users:</strong></td>
                        <td width="10%"><?php echo @$accounts ?></td>
                        <td width="15%" align="right"><strong>Proposals:</strong></td>
                        <td width="10%"><?php echo @$proposals ?></td>
                        <td width="15%" align="right"><strong>&nbsp;</strong></td>
                        <td width="10%">&nbsp;</td>
                    </tr>
                    <tr class="even">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr class="">
                        <td align="right"><strong>Open:</strong></td>
                        <td><?php echo @$proposals_open ?></td>
                        <td align="right"><strong>Won:</strong></td>
                        <td><?php echo @$proposals_won ?></td>
                        <td align="right"><strong>Completed:</strong></td>
                        <td><?php echo @$proposals_completed ?></td>
                        <td align="right"><strong>Lost:</strong></td>
                        <td><?php echo @$proposals_lost ?></td>
                    </tr>
                    <tr class="even">
                        <td align="right"><strong>Cancelled:</strong></td>
                        <td><?php echo @$proposals_cancelled ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('global/footer'); ?>
