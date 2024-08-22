<div id="proposal-settings-tabs">
     <a class="btn update-button saveIcon saveGeneralSettings1" id="topSaveGeneralSettings">Save</a>

    <ul>
        <li><a href="#settings-general"><i class="fa fa fa-fw fa-cog"></i> General</a></li>
        <!-- <li><a href="#settings-video"><i class="fa fa fa-fw fa-video-camera"></i> Video</a></li> -->
        <?php if ($account->getCompany()->hasPSA()) { ?>
            <li><a href="#settings-psa"><i class="fa fa-fw fa-map-marker"></i> ProSiteAudit</a></li>
        <?php } ?>
        <li><a href="#settings-events"><i class="fa fa fa-fw fa-calendar"></i> Events</a></li>
        <li><a href="#settings-signees"><i class="fa fa fa-fw fa-pencil"></i> Signatures</a></li>
    <?php if ($account->isAdministrator()) { ?>
        <li><a href="#user-permission"><i class="fa fa fa-fw fa-users"></i> User Permission</a></li>
    <?php } ?>
        <li><a href="#proposal-sections"><i class="fa fa fa-fw fa-list"></i> Proposal Layout</a></li>
    </ul>
    <div id="settings-general"><?php $this->load->view('proposals/edit/settings/general'); ?></div>
    <!-- <div id="settings-video"><?php //$this->load->view('proposals/edit/settings/video'); ?></div> -->
    <?php if ($account->getCompany()->hasPSA()) { ?>
    <div id="settings-psa"><?php $this->load->view('proposals/edit/settings/psa'); ?></div>
    <?php } ?>
    <div id="settings-events"><?php $this->load->view('proposals/edit/settings/events'); ?></div>
    <div id="settings-signees"><?php $this->load->view('proposals/edit/settings/signees'); ?></div>
    <?php if ($account->isAdministrator()) { ?>
        <div id="user-permission"><?php $this->load->view('proposals/edit/settings/user-permission'); ?></div>
    <?php } ?>
    <div id="proposal-sections"><?php $this->load->view('proposals/edit/settings/proposal-sections'); ?></div>
</div>