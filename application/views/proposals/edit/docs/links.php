<div style="padding: 20px;">
        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td><input type="text" id="link-name" placeholder="Name" style="width: 97%;"></td>
                <td><input type="text" id="link-url" placeholder="http://..." style="width: 97%;"></td>
                <td>
                    <a  class="btn small update-button addIcon" id="addLink">Add Link</a>
                </td>
            </tr>
        </table>
        <input type="hidden" name="proposal" value="<?php echo $proposal->getProposalId() ?>">
</div>
<table class="boxed-table striped-table" width="100%" id="linksTable">
    <thead>
    <tr>
        <td>Link</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $k = 0;
    foreach ($proposalLinks as $link) {
        $k++;
        ?>
        <tr id="linkRow_<?php echo $link->id; ?>">
            <td>
                <a id="proposal-link-<?php echo $link->id ?>" href="<?php echo $link->url ?>"
                   target="_blank"><?php echo $link->name ?></a>
                <div id="edit-form-<?php echo $link->id ?>" style="display: none;">
                    <form action="#" class="editLinkForm" data-id="<?php echo $link->id ?>">
                        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><input type="text" name="name" class="name" placeholder="Name" style="width: 97%;"
                                           value="<?php echo $link->name ?>"></td>
                                <td><input type="text" name="url" class="url" placeholder="http://..."
                                           style="width: 97%;" value="<?php echo $link->url ?>"></td>
                                <td><input type="submit" value="Save Link" class="btn small" id="saveLink"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
            <td width="150">
                <?php if ($link->proposal) { ?>
                    <a href="#" class="btn editLink" id="editLink-<?php echo $link->id ?>"
                       data-id="<?php echo $link->id ?>">Edit</a>
                    <a href="#" class="btn cancelEditLink" style="display: none;"
                       id="cancelEditLink-<?php echo $link->id ?>" data-id="<?php echo $link->id ?>">Cancel</a>
                    <a href="#" class="btn deleteLink" data-id="<?php echo $link->id ?>">Delete</a>
                <?php } ?>
            </td>
        </tr>
    <?php }
    if (!count($proposalLinks)) {
        ?>
        <tr>
            <td class="centered">No Links found. To add links use the add button or add company wide links in My Account
                -> Proposal Settings.
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>