<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <?php if ($account->getUserClass() > 2) { ?>
        <tr class="even">
            <td>
                <label>Proposal Owner</label>
            </td>
            <td>
                <select name="owner" id="owner" class="generalSetting">
                    <?php foreach ($userAccounts as $userAccount) {
                        if (!$userAccount->getSecretary()) {
                            ?>
                            <option
                                    value="<?php echo $userAccount->getAccountId() ?>"<?php if ($userAccount->getAccountId() == $proposal->getOwner()->getAccountId()) {
                                echo ' selected';
                            } ?>><?php echo $userAccount->getFullName() ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
    <?php } ?>
    <?php if ($automatic_reminders_enabled): ?>
        <tr>
            <td>
                <label>Automatic Re-Send</label>
            </td>
            <td>
                <p class="clearfix">
                    <select name="automatic_resend" id="automatic_resend" style="float: left;" class="generalSetting">
                        <option value="0" <?= (!$proposal->getResendEnabled()) ? 'selected="selected"' : '' ?>>
                            Disabled
                        </option>
                        <option value="1" <?= ($proposal->getResendEnabled()) ? 'selected="selected"' : '' ?>>Enabled
                        </option>
                    </select>
                    <select name="template" id="template" style="float: left;" class="generalSetting">
                        <?php foreach ($proposal_email_templates as $template): /** @var $template models\ClientEmailTemplate */ ?>
                            <option <?php echo ($proposal->getResendTemplate() == $template->getTemplateId()) ? ' selected="selected"' : '' ?>
                                    value="<?= $template->getTemplateId() ?>"><?= $template->getTemplateName() ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label style="width: auto;">Every</label>
                    <input type="text" name="frequency" id="frequency"
                           value="<?= (($proposal->getResendFrequency() / 86400) >= 1) ? (round($proposal->getResendFrequency() / 86400)) : 1 ?>"
                           class="text generalSetting" style="width: 20px;">
                    <label style="text-align: left; width: auto;">Days</label>
                </p>
            </td>
        </tr>
    <?php endif ?>
    <?php
    if (new_system($proposal->getCreated(false)))
    {
    ?>
    <tr>
        <td>
            <label>Proposal Layout </label>
        </td>
        <td>
        <div style=" width: 600px; float: left">
                <p class="clearfix">
                    <select name="proposalLayout" id="proposalLayout" style="float: left;" class="generalSetting">
                      
                    
                        <?php
                        foreach ($layouts as $layoutName => $layout) {
                            $selected = '';
                            if ($layout == $layoutOption) {
                                $selected = ' selected="selected" ';
                            }
                            ?>
                            <option value="<?php echo $layout ?>" <?php echo $selected ?>><?php echo $layoutName ?></option>
                            <?php
                        }
                        ?>
                        
                    </select>
                    <label style="width: 123px;">Pricing</label>
                    <select name="layout-option" class="layoutOption generalSetting">    
                            <option value="" <?php if($optionDigit == '') { echo 'selected';} ?>>Default</option>
                            <option value="2" <?php if($optionDigit == 2) { echo 'selected';} ?>>No Total</option>
                            <option value="3" <?php if($optionDigit == 3) { echo 'selected';} ?>>Lump Sum</option>
                    </select>
                </p>
            </div>  
            <div style=" width: 400px; float: right; padding-top: 5px; display: none;">
                <p>Click 'Set Layout' to see the layout options</p>
            </div>
        </td>
    </tr>
    
    <?php 
         $display_pre_popup = '';
         if($layoutOption != 'web-cool' && $layoutOption != 'web-standard') {
            $display_pre_popup = 'display: none';
         }?>
    <tr class="showPreProposalPopup" style="<?php echo  $display_pre_popup; ?>">
        <td><label>Show Pre Popup</label></td>
        <td>
        <input type="checkbox" class="generalSetting" name="preProposalPopup" id="preProposalPopup" value="1"  <?php echo ($proposal->getIsPreProposalPopup() == 1) ? 'checked' : ''; ?>>
        </td>
    </tr>

    <?php echo form_open_multipart('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4),
        array('class' => '','id'=>'company_proposal_settings6')); ?>
    <tr class="customLayoutRow">
        <td>
            <label>Custom Layout Settings</label>
        </td>
        <td>
            <p class="clearfix">

                <?php
                $gradients = [
                    '0',
                    '0.1',
                    '0.2',
                    '0.3',
                    '0.4',
                    '0.5',
                    '0.6',
                    '0.7',
                    '0.8',
                    '0.9',
                    '1'
                ];
                ?>

                <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td class="text-right">Background Image</td>
                        <td>
                        <select name="select_background_image" class="select_background_image dont-uniform" id="select_background_image">
                            <option value="" >Select Background</option>
                            <option value="1" data-base-path="" data-val="<?php echo site_url('static/images/b1.jpg') ?>" <?php echo ('1' == $proposal->getProposalBackground() ? ' selected' : '') ?>>Background 1</option>
                            <option value="2" data-val="<?php echo site_url('static/images/b2.jpg') ?>" <?php echo ('2' == $proposal->getProposalBackground() ? ' selected' : '') ?>>Background 2</option>
                            <option value="3" data-val="<?php echo site_url('static/images/b3.jpg') ?>" <?php echo ('3' == $proposal->getProposalBackground() ? ' selected' : '') ?>>Background 3</option>
                            <option value="4" data-val="<?php echo site_url('static/images/b4.jpg') ?>" <?php echo ('4' == $proposal->getProposalBackground() ? ' selected' : '') ?>>Background 4</option>
                            <option value="0" <?php echo ('0' == $proposal->getProposalBackground() ? ' selected' : '') ?>>custom</option>
                        </select>
                        <input type="hidden" name="background_url" class="background_url" value="<?=$proposal->getProposalBackground();?>">
                        <input type="hidden" name="background_image" class="background_image">
                    <br/>
                    <p class="upload_image_p" style="position: relative;margin-top: 5px;display:none"><input type="file" id="gradientImage" name="gradientImage" style="margin-top: 6px;" /> <i class="fa fa-fw fa-info-circle tiptipleft" style="right: 0px;font-size: 17px;position: absolute;top: 10px;" title="Ideal image size is 820px width and 1060px.<br/>Images of other sizes will be scaled to fit."></i></p>
                    
                </td>
    </tr>
    
    <tr class="customLayoutRow">
        <td class="text-right">Background Image Opacity</td>
        <td>
            <input type="hidden" id="hiddenImageOpacity" name="imageOpacity"
                   value="<?php echo $proposal->getGradientOpacity(); ?>"/>
            <select id="imageOpacity" name="gradientOpacity">
                <?php
                foreach ($gradients as $gradient) {
                    ?>
                    <option value="<?php echo $gradient; ?>"<?php echo($gradient == $proposal->getGradientOpacity() ? ' selected' : '') ?>><?php echo $gradient; ?></option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
    <tr class="customLayoutRow">
        <td class="text-right">Background Color</td>
        <td>
            <input id="headerBgColor" name="headerBgColor" class="jscolor"
                   value="<?php echo $proposal->getHeaderBgColor(); ?>" type="text"
                   onchange="updateBgPreview(this.jscolor)"/>
                   <a href="javascript:void(0)" class="btn"  id="headerBgColorUndo"><i class="fa fa-undo"></i></a>
        </td>
    </tr>
    <tr class="customLayoutRow">
        <td class="text-right">Text Color</td>
        <td><input id="headerFontColor" name="headerFontColor" class="jscolor" type="text"
                   value="<?php echo $proposal->getHeaderFontColor(); ?>"
                   onchange="updateHeadingPreview(this.jscolor)"/>
                   <a href="javascript:void(0)" class="btn" id="headerFontColorUndo"> <i class="fa fa-undo"></i></a>
                </td>
    </tr>
    <tr>
                <td class="text-right">Show Logo</td>
                <td>
                <input value="<?=$proposal->getIsShowProposalLogo();?>" type="hidden" name="is_show_logo" id="is_show_logo">
                <input onclick="document.getElementById('is_show_logo').value='1'" type="radio" name="show_logo" class="show_logo"  value="1" <?php echo ('1' == $proposal->getIsShowProposalLogo() ? ' checked' : '') ?>> Yes <input onclick="document.getElementById('is_show_logo').value='0'" type="radio" name="show_logo" class="show_logo" value="0" <?php echo ('0' == $proposal->getIsShowProposalLogo() ? ' checked' : '') ?>> No</td>
    </tr>
    <tr class="customLayoutRow">
        <td></td>
        <td>
            <p>
                
            <button type="button" style="background: #25AAE1!important;" id="saveImage" name="saveImage" class="btn blue ui-button"><i class="fa fa-save"></i> Save Settings</button>
            <button type="button" id="useCustomDefaults" name="useCustomDefaults"  class="btn ui-button"><i class="fa fa-close"></i> Reset To Defaults</button>
         
            </p>
        </td>
    </tr>
    <?php
    $previewDisplay = '';
    if (!$proposal->getCoverImagePath()) {
        $previewDisplay = 'display: none;';
    }
    ?>
    <tr id="previewContainer" style="<?php echo $previewDisplay; ?>" id="previewContainer" class="customLayoutRow">
        <td class="text-right"></td>
        <td>
            <h3>Preview</h3>
            <div style="position: relative; width: 410px;">
                <img id="currentImage" src="<?php echo $proposal->getCoverImageSrc('-orig'); ?>?<?php echo time(); ?>"
                     width="400px" height="530px"/>
                <h4 id="preview-heading" class="preview-heading"
                    style="position: absolute; top: 110px; width: 66%; padding: 3px; left: 17%; text-align: center; border-radius: 5px;"><?php echo $proposal->getProposalTitle(); ?></h4>
                <h4 id="preview-contact" class="preview-heading"
                    style="position: absolute; top: 210px; width: 50%; padding: 3px; left: 25%; text-align: center; border-radius: 5px;">
                    <span style="font-size: 14px;"
                          class="preview-heading"><?php echo $proposal->getClient()->getFullName(); ?></span><br/>
                    <span style="font-size: 12px;"
                          class="preview-heading"><?php echo $proposal->getClient()->getClientAccount()->getName(); ?></span>
                </h4>
                <h4 id="preview-contact" class="preview-heading"
                    style="position: absolute; top: 335px; width: 50%; padding: 3px; left: 25%; text-align: center; border-radius: 5px;">
                    <span style="display: block; font-size: 12px; padding-bottom: 10px;" class="preview-heading">Project:</span>
                    <span style="font-size: 13px;"
                          class="preview-heading"><?php echo $proposal->getProjectName(); ?></span><br/>
                    <span style="font-size: 11px;"
                          class="preview-heading"><?php echo $proposal->getProjectAddressString(); ?></span>
                </h4>
                <?php
                if (file_exists(UPLOADPATH . '/clients/logos/logo-' . $account->getCompany()->getCompanyId() . '.jpg')) {
                    ?>
                    <img id="preview-logo"
                         src="/uploads/clients/logos/logo-<?php echo $account->getCompany()->getCompanyId() ?>.jpg"
                         width="70px" style="position: absolute; bottom: 20px; right: 30px;"/>
                    <?php
                }
                ?>
            </div>
        </td>
    </tr>
    </tbody>
</table>
</p>
</td>
</tr>
<?php
    echo form_close();
}
?>
<tr class="even">
    <td>
        <label>Payment Term NET</label>
    </td>
    <td>
        <p class="clearfix">

            <input class="text generalSetting" type="text" name="paymentTerm" id="paymentTerm"
                   value="<?php echo $proposal->getPaymentTerm() ?>"
                   style="width: 30px; margin-right: 5px;" length="4" size="4" maxlength="4">
            <label style="width: auto; margin-right: 0;">Days</label>
        </p>
    </td>
</tr>
<tr class="odd">
    <td>
        <label>Proposal Date</label>
    </td>
    <td>
         <p>
            <input class="text generalSetting" type="text" name="proposalSettingDate"
                                            id="proposalSettingDate" style="width: 100px;"
                                            value="<?php echo $proposal->getCreated(); ?>"/>

            <span id="proposalActualDateSpan">
                    <label>Actual Created  Date:</label>
                    <span style="margin-top: 7px;position: absolute;" ><?php echo date_format(date_create($proposal->getActualCreatedDate()),"m/d/Y"); ?></span>
            </span>
        </p>
    </td>
</tr>
<tr class="even">
    <td>
        <label>Status Change Date</label>
    </td>
    <td>
         <input class="text generalSetting" type="text" name="proposalSettingChangeDate"
                                                 id="proposalSettingChangeDate" style="width: 100px;"
                                                 value="<?php echo date('m/d/Y',
                                                     $proposal->getStatusChangeDate()); ?>"/>
    </td>
</tr>
<?php if ($proposal->isWon() || $proposal->getProposalStatus()->isSales()) { ?>
    <tr class="even">
        <td>
            <label>Proposal Win Date</label>
        </td>
        <td>
            <input class="text generalSetting" type="text" name="proposalSettingWinDate"
                   id="proposalSettingWinDate" style="width: 100px;"
                   value="<?php echo ($proposal->getWinDate()) ? date('m/d/Y', $proposal->getWinDate()) : ''; ?>"/>
        </td>
    </tr>
<?php } ?>
<tr class="odd">
    <td>
        <label>Payment Terms</label>
    </td>
    <td>
        <a class="btn" href="#" rel="<?php echo $this->uri->segment(3) ?>" id="editPaymentTermText">Customize
            Payment Term Text</a>
    </td>
</tr>
<tr class="even">
    <td>
        <label>Contact Copy</label>
    </td>
    <td>
        <a class="btn" href="#" rel="<?php echo $this->uri->segment(3) ?>"
           id="editContractCopyText">Customize Contract Copy Text</a>
    </td>
</tr>
<tr class="even">
    <td>
        <label>Hide Proposal</label><i class="fa fa-fw fa-info-circle tiptipright" style="position: absolute;margin-top: 7px;left: 170px;cursor: pointer;" title="If checked, the proposal will not be visible to the customer"></i>
    </td>
    <td>
    <input type="checkbox" value='1' class="generalSetting" id="hide_in_view" <?php echo $proposal->getIsHiddenToView() ? 'checked="checked"' : ''; ?> />
    </td>
</tr>
<tr class="even">
    <td>
        <label>Email Stop</label><i class="fa fa-fw fa-info-circle tiptipright" style="position: absolute;margin-top: 7px;left: 170px;cursor: pointer;" title="If checked, this proposal will not be send in email campaigns"></i>
    </td>
    <td>
    <input type="checkbox" value='1' class="generalSetting" id="resend_exclude" <?php echo $proposal->getResendExcluded() ? 'checked="checked"' : ''; ?> />
    </td>
</tr>
<!--add a work order setting -->
   <?php
    if (new_system($proposal->getCreated(false)))
    {
    ?>
<tr class="even">
            <td>
                <label style="color:#333;">Work Order Setting</label>
            </td>
            <td>
                <select name="workOrderSetting" id="workOrderSetting" class="generalSetting">
                    <?php 
                      foreach ($allWorkOrder as $orderName => $orderValue) {
                        $selected = '';
                        if ($orderValue == $workOrderOption) {
                            $selected = ' selected="selected" ';
                        }
                    ?>
                   <!-- <option value="0">LANDSCAPE</option>
                   <option value="1">PORTRAIT</option> -->
                   <option value="<?php echo $orderValue ?>" <?php echo $selected ?>><?php echo $orderName ?></option>
                   <?php } ?>

                </select>
            </td>
        </tr>
<!--close a work order setting-->
<?php } ?>
<?php if ($duplicate) { ?>
    <tr class="odd">
        <td>
            <label>Unduplicate</label>
        </td>
        <td>
            <a class="btn" id="unduplicate">Save as Standalone Proposal</a>
        </td>
    </tr>
<?php } ?>
<tr id="saveGeneralSettingsRow">
    <td></td>
    <td>
        <a class="btn update-button saveIcon saveGeneralSettings">Save General Settings</a>
    </td>
</tr>
</tbody>
</table>