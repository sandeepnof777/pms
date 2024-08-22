<div id="proposal-docs-tabs">
    <ul>
        <li><a href="#docs-project"><i class="fa fa-fw fa-link"></i> Project Attachments</a></li>
        <li><a href="#docs-company"><i class="fa fa-fw fa-paperclip"></i> Company Attachments</a></li>
        <li><a href="#docs-custom"><i class="fa fa-fw fa-list"></i> Custom Texts</a></li>
        <li><a href="#settings-links"><i class="fa fa fa-fw fa-link"></i> Links</a></li>
        <li><a href="#docs-notes"><i class="fa fa-fw fa-sticky-note-o"></i> Notes</a></li>
        <li><a href="#docs-work-order-notes"><i class="fa fa-fw fa-sticky-note"></i> Work Order Notes</a></li>
    </ul>
    <div id="docs-project"><?php $this->load->view('proposals/edit/docs/project'); ?></div>
    <div id="docs-company"><?php $this->load->view('proposals/edit/docs/company'); ?></div>
    <div id="docs-custom"><?php $this->load->view('proposals/edit/docs/custom'); ?></div>
    <div id="settings-links"><?php $this->load->view('proposals/edit/docs/links'); ?></div>
    <div id="docs-notes"><?php $this->load->view('proposals/edit/docs/notes'); ?></div>
    <div id="docs-work-order-notes"><?php $this->load->view('proposals/edit/docs/work-order-notes'); ?></div>
</div>