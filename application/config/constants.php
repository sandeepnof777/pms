<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

const FILE_READ_MODE = 0644;
const FILE_WRITE_MODE = 0666;
const DIR_READ_MODE = 0755;
const DIR_WRITE_MODE = 0777;
/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/



const FOPEN_READ = 'rb';
const FOPEN_READ_WRITE = 'r+b';
const FOPEN_WRITE_CREATE_DESTRUCTIVE = 'wb'; // truncates existing file data, use with care
const FOPEN_READ_WRITE_CREATE_DESTRUCTIVE = 'w+b'; // truncates existing file data, use with care
const FOPEN_WRITE_CREATE = 'ab';
const FOPEN_READ_WRITE_CREATE = 'a+b';
const FOPEN_WRITE_CREATE_STRICT = 'xb';
const FOPEN_READ_WRITE_CREATE_STRICT = 'x+b';



const QB_DSN = 'mysql://pms:ejAurK4W9XcpHh@localhost/pms_dev';
const SENDGRID_USER = 'rapidinjection';
const SENDGRID_PASS = 'weststreet3814';
//const SENDGRID_API_KEY = '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';
const IMAGE_UPLOAD_LIMIT = 12;
const MAP_IMAGE_UPLOAD_LIMIT = 4;

const SNOW_CATEGORY = 105;
/* Stripe API KEYS */

const STRIPE_SECRET_KEY = 'sk_live_XWcFOqDoVYI4mT4L4B4B9uuC';
const STRIPE_PUBLIC_KEY = 'pk_live_xMxwfzmzy2uMfb7VqXeQpjDU';

/* Google API Key for mapping */

//const GOOGLE_API_KEY = 'AIzaSyAAwPTBepSPhx3vqo0g5p4-axKBMw6wrq8';
//const GOOGLE_API_SERVER_KEY = 'AIzaSyDVz0G5M9cPjSsHIylcNqYMYB94szXOJrs';
/* Google Recaptcha Keys */

const RECAPTCHA_SECRET = '6LcGQxETAAAAAAUKXRl2TotWPYSN8_ujIIF5izqv';
/* PSA Pavement Category */

const PSA_PAVEMENT = 1;
/* Tinymce API Key for editor */

const TINYMCE_API_KEY = 'wyppo4gnalroex1h1kcpex3vykxym4hcy3ck9els6dg24ujd';
if (DEV) {
    define('ZS_ORG_ID', 45512801);
}
else {
    define('ZS_ORG_ID', 653602135);
}


const ZS_AUTH_TOKEN = '9afb4abfdcbff4891310d6ae07a50ad9';
const ZS_ACTIVATION_PLAN_ID = 'PL';
const ZS_USER_ADDON_ID = 'PLU';
const ZS_WIO_ADDON_ID = 'WIO';
const ZS_SEC_ADDON_ID = 'SEC';


const GOOGLE_ANALYTICS_KEY = 'UA-110418566-1';

const SITE_NOUN = 'Pavement';
const SITE_NAME = 'Pavement Layers';
const SITE_EMAIL_DOMAIN = 'pavementlayers.com';

const M_TO_FT = 3.28084;
const M_TO_SQ_FT = 10.7639;

const ESTIMATING_TRUCKING_TYPE = 20;

const ESTIMATING_EXCAVATION_TYPE = 29;

const BING_MAPS_KEY = 'AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN';

const ZOHO_CRM_USER = '1000.GB78UPM64KA9L3X3WWIO0QBNPE0NYH';
const ZOHO_CRM_CLIENT_SECRET = '4517f81ea905d89caf50ac8852acf2e23e1104f02e';

const ABOUT_US_WORD_LIMIT = 200;

const COMPANY_INTRO_WORD_LIMIT = 200;

// Queue Names // Removed - handling with .env
//const QUEUE_HIGH = 'high';
//const QUEUE_EMAIL = 'email';


const CACHE_SITE = 'pms_';
const CACHE_DEFAULT_LIFETIME = 3600;
const CACHE_COMPANY_WORK_ORDER_RECIP = CACHE_SITE.'work_order_recipients_';
const CACHE_COMPANY_BUSINESS_TYPE = CACHE_SITE.'company_business_type_';
const CACHE_COMPANY_STATUSES = CACHE_SITE.'company_statuses_';
const CACHE_COMPANY_SERVICES = CACHE_SITE.'company_services_';
const CACHE_COMPANY_SERVICES_MAP = CACHE_SITE.'company_services_map_';
const CACHE_JOB_COST_STATUS = CACHE_SITE.'job_cost_status';
const CACHE_COMPANY_FOREMEN = CACHE_SITE.'company_formen_';
const CACHE_PROPOSAL_EVENT_TYPE = CACHE_SITE.'proposal_event_type';
const CACHE_EVENT_EMAIL_TYPE = CACHE_SITE.'event_email_type';
const CACHE_CLIENT_EMAIL_TEMPLATE_TYPE_FIELD = CACHE_SITE.'client_email_template_type_field';
const CACHE_COMPANY_ADMIN_HEADER_LEAD_COUNT = CACHE_SITE.'header_admin_lead_count_';
const CACHE_COMPANY_BRANCH_HEADER_LEAD_COUNT = CACHE_SITE.'header_branch_lead_count_';
const CACHE_COMPANY_USER_HEADER_LEAD_COUNT = CACHE_SITE.'header_user_lead_count_';
const CACHE_COMPANY_ADMIN_HEADER_QUEUED_PROPOSAL_COUNT = CACHE_SITE.'header_admin_queued_proposal_count_';
const CACHE_COMPANY_ADMIN_HEADER_DECLINED_PROPOSAL_COUNT = CACHE_SITE.'header_admin_declined_proposal_count_';
const CACHE_COMPANY_BRANCH_HEADER_QUEUED_PROPOSAL_COUNT = CACHE_SITE.'header_branch_queued_proposal_count_';
const CACHE_COMPANY_BRANCH_HEADER_DECLINED_PROPOSAL_COUNT = CACHE_SITE.'header_branch_declined_proposal_count_';
const CACHE_COMPANY_TYPE_ADMIN_PROPOSAL_PAGE_TEMPLATE_LIST = CACHE_SITE.'admin_proposal_template_type_list_';
const CACHE_COMPANY_TYPE_USER_PROPOSAL_PAGE_TEMPLATE_LIST = CACHE_SITE.'user_proposal_template_type_list_';
const CACHE_COMPANY_PROPOSAL_MAX_PRICE = CACHE_SITE.'company_proposal_max_price_';
const CACHE_COMPANY_PROPOSAL_RESEND_LIST = CACHE_SITE.'company_proposal_resend_list_';







/* End of file constants.php */
/* Location: ./application/config/constants.php */
