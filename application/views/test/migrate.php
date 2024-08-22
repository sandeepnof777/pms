<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">

        <h2>Service Migration</h2>


        <?php
            foreach ($customServices as $customService) {
                /* @var $customService \models\Services */
        ?>
            <p style="margin-bottom: 10px;"><strong><?php echo $customService->getServiceId() . ': ' . $customService->getServiceName(); ?> - <?php echo $customService->hasCustomTitle($company->getCompanyId()) ? $customService->getCustomTitle($company->getCompanyId())->getTitle() : ''; ?></strong></p>
            <p>
                <strong>Texts Found:</strong>
                <ul style="margin: 10px;">
<?php 
    foreach($customService->getTexts($company->getCompanyId()) as $text) {
        /* @var $text \models\ServiceText */
?>
                    <li style="list-style-type: disc;"><?php echo $text->getText(); ?></li>
<?php
    }                
?>
                </ul>

            </p>

            <p style="margin: 10px;"></p>
            <strong>Fields Found:</strong>
                <ul style="margin: 10px;">
<?php
                foreach($company->getServiceFields($customService->getServiceId()) as $field) {
                    /* @var $field \models\ServiceField */
                    ?>
                    <li style="list-style-type: disc;"><?php echo $field->getFieldName() . ' [' . $field->getFieldCode() . ']'; ?></li>
                <?php
                }
                ?>
                </ul>

        <br />

        <?php
            $proposalServices = $customService->getProposalServices($company->getCompanyId());

                if (count($proposalServices)) {
                    foreach ($proposalServices as $proposalService) {
                        echo '<p>ProposalService ID: ' . $proposalService->getServiceId() . '</p>';
                    }
                } else {
                    echo '<p>This service is not used in any proposals.</p>';
                }

        ?>
        <br />
        <?php
            }
        ?>


    </div>

<?php $this->load->view('global/footer'); ?>