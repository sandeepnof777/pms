<?php

class System_email extends MY_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_DB_driver
     */
    var $db;
    /**
     * @var Settings
     */
    var $settings;
    protected $protocol;
    protected $headers;
    protected $global_data;
    protected $wrap_top;
    protected $wrap_bottom;
    protected $default_from_name;
    protected $default_from_email;
    protected $defaultReplyTo;
    protected $default_notifications_email;
    protected $site_name;
    public $categories;
    public $uniqueArgs;
    protected array $mailDefaults = [
        'siteLogoUrl' => 'https://pms.pavementlayers.com/static/home_logo.png'
    ];

    function __construct() {
        parent::__construct();
        $ci =& get_instance();
        $ci->load->model('settings');
        $this->header_default_from = 'From: ' . $ci->settings->get('from_name') . ' <' . $ci->settings->get('from_email') . '>' . "\r\n";
        $this->default_from_name = $ci->settings->get('from_name');
        $this->default_from_email = $ci->settings->get('from_email');
        $this->defaultReplyTo = $this->default_from_email;
        $this->site_title = $ci->settings->get('site_title');
        $this->headers .= 'MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $this->global_data = array();
        $this->protocol = 'mail'; //only mail for now soon to add smtp etc
        $this->categories = array();
        $this->uniqueArgs = array();

        $this->default_notifications_email = 'proposals' . substr($this->default_from_email, strpos($this->default_from_email, '@'));
        $this->wrap_top = '<html><head>
<title>Email</title>
<style type="text/css">
body {font-size: 12px; font-family: Helvetica, Arial, sans-serif;}
</style>
</head>
<body>';
        $this->wrap_bottom = '</body></html>';
    }

    function sendEmail($emailId, $to = '', $mailData = array(), $args = [],$fromName = '',$fromEmail = '', $replyTo = '') {

        //load email information
        $emailTemplate = $this->em->find('models\Email_templates', $emailId);
        if (!$emailTemplate) {
            return false;
        }

        $data = array_merge($this->mailDefaults, $mailData);

        //set up the data array
        $dataArray = array();
        $fields = $emailTemplate->getFields();
        $replaceFields = array();
        foreach ($fields as $field) {
            $replaceFields['{' . $field->getFieldCode() . '}'] = $field->getDefaultValue();
        }
        foreach ($data as $fieldCode => $fieldValue) {
            $replaceFields['{' . $fieldCode . '}'] = $fieldValue;
        }
        //prepare search and replace arrays
        $searchArray = array();
        $replaceArray = array();
        foreach ($replaceFields as $search => $replace) {
            $searchArray[] = $search;
            $replaceArray[] = $replace;
        }

        if($fromName){
            $this->default_from_name = $fromName;
        }

        if($fromEmail){
            $this->default_from_email = $fromEmail;
        }

        if($replyTo){
            $this->defaultReplyTo = $replyTo;
        }

        $ci =& get_instance();
        $ci->load->model('settings');
        /* Load additional replace fields */
        $searchArray[] = '{site_title}';
        $replaceArray[] = $ci->settings->get('site_title');
        $searchArray[] = '{login_url}';
        $replaceArray[] = '<a href="' . site_url('home/signin') . '">' . site_url('home/signin') . '</a>';
        /*Replace*/
        $body = str_replace($searchArray, $replaceArray, $emailTemplate->getTemplateBody());
       // $body .= '<p>' . $ci->settings->get('email_footer') . '</p>';
        $subject = $emailTemplate->getTemplateSubject();
        $subject = str_replace($searchArray, $replaceArray, $subject);
        //send
        $this->send_mail($to, $subject, $body, false, false, $args,$replyTo);
        return true;
    }

    function send_mail($to, $subject, $body, $from = false, $debug = false, $args = [],$replyTo = '') {
        //wrap body around code
        if (!$from) {
            $fromName = $this->default_from_name;
            $fromEmail = $this->default_from_email;
        } else {
            $fromName = substr($from, 0, (strpos($from, '<') - 1)); //Chris: here is the part where we lose the From Email forever in the darkness
            if (!$fromName) {
                $fromName = $this->default_from_name;
            }
            $fromEmail = (strpos($from, '<')) ? substr($from, (strpos($from, '<') + 1), (strlen($from) - (strpos($from, '<') + 2))) : FALSE;
            if (!$fromEmail) {
                $fromEmail = $this->default_from_email;
            }
        }
        $email_body = $this->wrap_top . $body . $this->wrap_bottom;
        //mail($to, $subject, $body, $headers);

        //set reply To
        if($replyTo){
            $EmailReplyTo = $replyTo;
        }else{
            $EmailReplyTo = $this->defaultReplyTo;
        }

        // Send this mail via the web api

        $emailData = [
            'to' => $to,
            'fromName' => $fromName,
            'fromEmail' => $fromEmail,
            'replyTo' =>  $EmailReplyTo,
            'subject' => $subject,
            'body' => $email_body,
            'categories' => $this->categories,
        ];

        // Pass in unique arguments if we have them
        if (isset($args['uniqueArg']) && isset($args['uniqueArgVal'])) {
            $emailData['uniqueArg'] = $args['uniqueArg'];
            $emailData['uniqueArgVal'] = $args['uniqueArgVal'];
        }

        if (isset($args['attachments']) ) {
            $emailData['attachments'] = $args['attachments'];
        }


        $result = $this->getEmailRepository()->send($emailData);

        if ($debug) {
            echo '<pre>';
            print_r($result);
            echo "From Name: {$fromName} -- From Email: {$fromEmail}";
            echo '</pre>';
        }

        if (isset($result->errors)) {
            $message = 'Errors: ' . implode(' | ', $result->errors);
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            $message.= '<br> File Name: '. $caller['file'];
            $message.= '<br> Line Number: '. $caller['line'];
            $this->send_mail('support@'.SITE_EMAIL_DOMAIN, 'Critical: Email not being sent out', $message);
        }
    }
}