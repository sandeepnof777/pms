<?php $this->load->view('global/header'); ?>
    <div id="content">
        <div class="clearfix">
            <div class="content-box">
                <div class="box-header">Decline Proposal</div>
                <div class="box-content padded">
                    <form action="#" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <p>You are declining the proposal "<?php echo $proposal->getProjectName() ?>". Type in a reason in the box below and the user will get notified in e-mail and he will review his work.</p>

                                    <p>&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><label>Reason:</label></p>
                                    <textarea name="reason" id="reason" cols="30" rows="5" style="width: 99%">Type in your reason here.</textarea>

                                    <p>&nbsp;</p>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" style="clearfix"><input class="btn left" name="send" type="submit" value="Send"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('global/footer');