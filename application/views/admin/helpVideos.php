<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box collapse <?php echo ($this->accountSettings->getSetting($account->getAccountId(), 'box-add-help-video') == 'open') ? 'open' : ''; ?>" id="add-help-video">
            <div class="box-header">
                Add Video
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
            </div>
            <div class="box-content">
                <?php echo form_open('admin/addHelpVideo', array('id' => 'fileUpload', 'class' => 'form-validated')) ?>
                <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%">
                            <p class="clearfix"><label>Title</label><input class="text required" type="text" name="title" id="title" value=""></p>
                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Youtube ID</label>
                                <input class="text required" type="text" name="youtubeId" id="youtubeId" value="">
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>Category</label>
                                <select name="parent" id="parent" class="left">
                                    <?php
                                    foreach ($videos as $areaId => $area) {
                                        foreach ($area['sections'] as $sectionId => $section) {
                                            ?>
                                            <option value="<?php echo $sectionId ?>"><?php echo $area['title'] . ' - ' . $section['title'] ?></option><?php
                                        }
                                    } ?>
                                </select>
                            </p>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix"><label>&nbsp;</label><input type="submit" value="AddVideo" name="addVideo" class="btn"></p>
                        </td>
                        <td></td>
                    </tr>
                </table>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
    <div class="content-box collapse <?php echo ($this->accountSettings->getSetting($account->getAccountId(), 'box-help-videos') == 'open') ? 'open' : ''; ?>" id="help-videos">
        <div class="box-header">
            Help Videos
        </div>
        <div class="box-content padded">
            <div id="videoSections">
                <?php
                foreach ($videos as $areaId => $area) {
                    ?>
                    <h3><a href="#"><?php echo $area['title'] ?></a></h3>
                    <div>
                        <div class="padded">
                            <?php
                            if (!count($area['sections'])) {
                                ?>No Sections Found! Call Chris to add and implement. <?php
                            } else {
                                foreach ($area['sections'] as $sectionId => $section) {
                                    ?>
                                    <h4 class="clearfix">
                                        <?php echo $section['title'] ?> [<span id="enableText_<?php echo $sectionId ?>"><?php echo ($section['enabled']) ? 'Enabled' : 'Disabled' ?></span>]
                                        <a class="btn-enabled right tiptip enable-section <?php echo ($section['enabled']) ? 'dis-none' : ''; ?>" id="enableSection_<?php echo $sectionId ?>" rel="<?php echo $sectionId ?>" title="Enable" style="font-size: 13px;" href="#">&nbsp;</a>
                                        <a class="btn-disabled right tiptip disable-section <?php echo ($section['enabled']) ? '' : 'dis-none'; ?>" id="disableSection_<?php echo $sectionId ?>" rel="<?php echo $sectionId ?>" title="Disable" style="font-size: 13px;" href="#">&nbsp;</a>
                                    </h4>
                                    <table class="boxed-table bordered" width="100%" cellpadding="0" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <td width="450" style="text-align: left;">Video Title</td>
                                            <td style="text-align: left;">Youtube ID</td>
                                            <td width="50" style="text-align: left;">&nbsp;</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if (!count($section['videos'])) {
                                            ?>
                                            <tr>
                                                <td colspan="3">No Videos found! Please add videos from the form above.</td>
                                            </tr>
                                        <?php
                                        } else {
                                            $k = 0;
                                            foreach ($section['videos'] as $videoId => $video) {
                                                $k++;
                                                ?>
                                                <tr class="<?php echo ($k % 2) ? 'odd' : 'even' ?>">
                                                    <td>
                                                        <span class="editVideoTitle" id="<?php echo $videoId ?>"><?php echo $video['title'] ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="editYoutubeId" id="<?php echo $videoId ?>"><?php echo $video['youtubeId'] ?></span>
                                                    </td>
                                                    <td><a class="btn-delete right tiptip deleteVideo" title="Delete Video" href="#" rel="<?php echo $videoId ?>">&nbsp;</a></td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#videoSections").accordion({
            active: false,
            collapsible: true,
            heightStyle: "content"
        });
        //enable/disable code
        function sectionEnable(sectionId, enabled) {
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('admin/helpVideoSectionEnable') ?>',
                data: {
                    sectionId: sectionId,
                    enabled: enabled
                }
            });
        }

        $(".enable-section").live('click', function () {
            var id = $(this).attr('rel');
            $(this).addClass('dis-none');
            sectionEnable(id, 1);
            $("#disableSection_" + id).removeClass('dis-none');
            $("#enableText_" + id).html('Enabled');
            return false;
        });
        $(".disable-section").live('click', function () {
            var id = $(this).attr('rel');
            $(this).addClass('dis-none');
            sectionEnable(id, 0);
            $("#enableSection_" + id).removeClass('dis-none');
            $("#enableText_" + id).html('Disabled');
            return false;
        });
        //edit stuff
        $(".editVideoTitle").editable('<?php echo site_url('admin/helpVideochangeTitle') ?>', {
            id: 'id',
            onblur: 'submit'
        });
        $(".editYoutubeId").editable('<?php echo site_url('admin/helpVideochangeYoutube') ?>', {
            id: 'id',
            onblur: 'submit'
        });
        $(".deleteVideo").live('click', function () {
            var id = $(this).attr('rel');
            if (confirm('Are you sure you want to delete the video?')) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo site_url('admin/deleteHelpVideo') ?>',
                    data: {
                        id: id
                    },
                    success: function () {
                        document.location.reload();
                    }
                });
            }
        });
    });
</script>
<?php $this->load->view('global/footer'); ?>
