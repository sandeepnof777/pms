<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">History</div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="boxed-table">
                    <tbody>
                    <tr>
                        <td>
                            <label>To <span>*</span></label><input type="text" name="to" id="to" class="tiptip" title="Separate email addresses by commas">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Subject <span>*</span></label><input type="text" name="to" id="subject" class="tiptip" title="Enter your message">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Message</label>
                            <textarea name="message" id="message" cols="30" rows="10"></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('global/footer'); ?>
