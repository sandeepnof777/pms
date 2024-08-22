<?php $this->load->view('global/header'); ?>
    <div id="content">
        <div class="clearfix">
            <div class="content-box">
                <div class="box-header">Send Proposal in Approval Queue</div>
                <div class="box-content padded">
                    <form action="#" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <div class="padded" style="font-size: 120%;">
                                        <p>Please choose one or many from the list below to send your proposal for approval please!</p>

                                        <p>&nbsp;</p>

                                        <p><b>VIP</b>: After you send your proposal for approval, you will not be able to change/edit until it is approved. You will receive an email asap after the approval.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <?php
                                        foreach ($recipients as $recipient) {
                                            ?>
                                            <label class="nice-label" for="recipient_<?php echo $recipient->accountId ?>"><?php echo $recipient->firstName . ' ' . $recipient->lastName ?> <input type="checkbox" value="<?php echo $recipient->email ?>" name="recipients[<?php echo $recipient->accountId ?>]" id="recipient_<?php echo $recipient->accountId ?>"/></label>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <p>Message:</p>
                                        <textarea name="message" id="message" cols="30" rows="10" style="width: 50%; height: 70px;"></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <div class="padded">
                                        <input class="btn left" name="send" type="submit" value="Send"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('global/footer');