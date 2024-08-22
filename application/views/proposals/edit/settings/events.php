<div class="clearfix">
    <a href="#" class="btn small right scheduleProposalEvent update-button" style="margin: 10px;"
       data-proposal="<?= $proposal->getProposalId() ?>"
       data-account="<?= $proposal->getOwner()->getAccountId(); ?>"
       data-projectname="<?= $proposal->getProjectName() ?>"
       data-phone="<?= $proposal->getClient()->getBusinessPhone(true) ?>">
       <i class="fa fa-fw fa-calendar"></i> Add Event</a>
</div>
<?php $this->load->view('templates/events/table'); ?>