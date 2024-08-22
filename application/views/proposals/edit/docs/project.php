<table cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="50%" valign="top" class="padded">
            <form id="addFileForm" action="<?php echo site_url('proposals/edit/' . $this->uri->segment(3)) ?>"
                  method="post" enctype="multipart/form-data">
                <table width="100%" class="boxed-table">
                    <thead>
                    <tr>
                        <td><h4> Upload File from computer </h4></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <span style="display: block;" class="clearfix"> Note: You can upload any type of file, within a limit of 10MB.</span>
                            </p>
                            <br />

                            <p class="clearfix text-center">
                                <label style="width: 35px;">File</label><input type="file" name="file" id="file" class="required" style="width: 290px;">
                            </p>


                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix">
                                <label style="width: 100px;"> File Name </label><input type="text" class="text required tiptip"
                                                                 title="Please enter a file title!"
                                                                 name="fileName" id="fileName"
                                                                 style="width: 180px;">
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="clearfix text-center">
                                <button type="submit" name="uploadFile" id="uploadFile" class="btn update-button">
                                    <i class="fa fa-fw fa-upload"></i> Upload
                                </button>
                            </p>

                            <p id="uploadingProjectAttachment" class="attachmentUpdating">Uploading [<span id="attachmentUploadPct"></span>%]</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>

        </td>
        <td valign="top" class="padded">
            <div id="accordion4">
                <?php
                $k = 0;
                foreach ($proposal_attachments as $attachment) {
                    ?>
                    <div id="attachment_<?php echo $attachment->getAttachmentId() ?>">
                        <h3>
                            <a href="#"><span
                                        id="attachmentTitle_<?php echo $attachment->getAttachmentId() ?>"><?php echo $attachment->getFileName() ?></span></a>
                            <a class="btn-delete close-accordion" href="#">&nbsp;</a>
                        </h3>

                        <div>
                            <form class="big update-attachment-form"
                                  action="#<?php echo $attachment->getAttachmentId() ?>">
                                <p class="clearfix">
                                    <label>File Name</label>
                                    <input type="text" name="attachment"
                                           id="attachmentName_<?php echo $attachment->getAttachmentId() ?>"
                                           value="<?php echo $attachment->getFileName() ?>">
                                </p>

                                <p class="clearfix">
                                    <label>Proposal</label>
                                    <input type="checkbox" name="input"
                                           id="attachmentProposal_<?php echo $attachment->getAttachmentId() ?>" <?php if ($attachment->getProposal()) {
                                        echo ' checked="checked"';
                                    } ?>>
                                    <span class="clearfix"></span>
                                    <label>Work Order</label>
                                    <input type="checkbox" name="input"
                                           id="attachmentWorkOrder_<?php echo $attachment->getAttachmentId() ?>" <?php if ($attachment->getWorkOrder()) {
                                        echo ' checked="checked"';
                                    } ?>>
                                    <span class="clearfix"></span>
                                    <label>Store</label>
                                    <input type="checkbox" name="input" checked="checked">
                                </p>

                                <p class="clearfix">
                                    <a class="btn update-button updateIcon update-attachment-button"
                                       style="margin-right: 10px;">Update</a>

                                    <a class="btn deleteIcon delete-attachment-button"
                                       id="delete<?php echo $attachment->getAttachmentId() ?>"
                                       style="margin-right: 10px;">Delete</a>

                                    <a class="btn notesIcon" target="_blank" type="button"
                                       href="<?php echo base_url() ?>uploads/companies/<?php echo $proposal->getClient()->getCompany()->getCompanyId() ?>/proposals/<?php echo $proposal->getProposalId() . '/' . $attachment->getFilePath() ?>">View
                                        File</a>
                                </p>

                            </form>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>
