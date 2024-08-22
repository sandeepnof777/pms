<?php
switch ($action) {
    case 'add':
    case 'edit':
    case 'duplicate':
        $this->load->view('account/my_account/company-email-template-form');
        break;
    default:
        $this->load->view('account/my_account/company-email-templates-table');
        break;
}