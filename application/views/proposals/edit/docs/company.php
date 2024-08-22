<table class="boxed-table" cellpadding="0" cellspacing="0" width="100%" id="attachments">
    <tbody>
    <tr class="even">
        <td class="centered"><strong> Admin & Sales </strong></td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <?php
                $query = $this->em->createQuery('SELECT a FROM models\Attatchments a where a.company=' . $proposal->getClient()->getCompany()->getCompanyId() . ' ORDER BY a.fileName');
                $attachments = $query->getResult();
                $k = 0;
                foreach ($attachments as $attatchment) {
                    if ($attatchment->getCategory() == 'admin') {
                        $k++;
                        ?>
                        <label class="attatchment">
                            <input <?php if (in_array($attatchment->getAttatchmentId(), $attatchedFiles)) { ?>
                                    checked="checked" <?php } ?>type="checkbox" name="attachment"
                                    id="attachment_<?php echo $attatchment->getAttatchmentId() ?>"><?php echo $attatchment->getFileName(); ?>
                        </label>
                        <?php
                    }
                }
                if (!$k) {
                ?>

            <div class="centered">No attachments found in this category!</div><?php
            }
            ?>
            </p>
        </td>
    </tr>
    <tr class="even">
        <td class="centered"><strong>Marketing</strong></td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <?php
                $query = $this->em->createQuery('SELECT a FROM models\Attatchments a where a.company=' . $proposal->getClient()->getCompany()->getCompanyId() . ' ORDER BY a.fileName');
                $attachments = $query->getResult(); // array of CmsArticle objects
                $k = 0;
                foreach ($attachments as $attatchment) {
                    if ($attatchment->getCategory() == 'marketing') {
                        $k++;
                        ?>
                        <label class="attatchment">
                            <input <?php if (in_array($attatchment->getAttatchmentId(), $attatchedFiles)) { ?>
                                    checked="checked" <?php } ?>type="checkbox" name="attachment"
                                    id="attachment_<?php echo $attatchment->getAttatchmentId() ?>"><?php echo $attatchment->getFileName(); ?>
                        </label>
                        <?php
                    }
                }
                if (!$k) {
                ?>

            <div class="centered">No attachments found in this category!</div><?php
            }
            ?>
            </p>
        </td>
    </tr>
    </tbody>
</table>