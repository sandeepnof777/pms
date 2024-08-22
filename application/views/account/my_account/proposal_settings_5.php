
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3> 
<p style="padding: 20px;">When this setting is saved, all company users default layouts will be set to the she selected layout.</p>
<form action="<?php echo site_url('account/company_proposal_settings5') ?>" method="post">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="text-right">Default Company Layout</td>
                <td>
                    <?php echo form_dropdown('layout', array_flip($layouts), $selected_layout) ?>
                </td>
            </tr>
            <!--<tr>
                <td class="text-right">Use Web Layout</td>
                <td>
                    <select name="webLayout" id="webLayout">
                        <option value="1" <?php if($savedWebLayout == 1){ echo "selected"; } ?>>Yes</option>
                        <option value="0" <?php if($savedWebLayout == 0){ echo "selected"; } ?>>No</option>
                    </select>
                </td>
            </tr>-->
         <?php 
        //  $display_pre_popup = '';
        //  if($savedWebLayout == 0) {
        //     $display_pre_popup = 'display: none';
        //  }
         ?>
         <!-- <tr class="showPreProposalPopup" style="<?php //echo $display_pre_popup; ?>">
                <td class="text-right">Show Pre Proposal Popup</td>
                <td>
                    <input type="checkbox" name="preProposalPopup" id="preProposalPopup" value="1" <?php echo ($isPreProposalPopup == 1) ? 'checked' : ''; ?>>
                </td>
         </tr> -->
            <tr>
                <td class="text-right"></td>
                <td>
                    <input type="submit" name="save" class="btn blue ui-button" value="Save Layout Settings" />
                </td>
            </tr>
        </tbody>
</table>
</form>

<script type="text/javascript">

    $(document).ready(function() {
        $('#webLayout').on('change', function() {
            if($(this).val() == 1 ){
                $('.showPreProposalPopup').show();
            } else {
                $('.showPreProposalPopup').hide();
            }
        })


    });
</script>
