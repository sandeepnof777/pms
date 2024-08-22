<?php

class JsonResponse {

    public $error;
    public $exportName;
    public $user;
    public $criteria;
    public $success;
    public $count;
    public $text;
    public $loginRequired;
    public $id;

    // Group Sending
    public $sent;
    public $unsent;

    // Email Template
    public $templateSubject;
    public $templateBody;

    // Deletion
    public $deleteRequested;
    public $deleteComplete;

    // Proposal URLs
    public $previewUrl;

    public function send()
    {
        echo json_encode($this);
    }

}