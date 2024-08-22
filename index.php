<?php
ini_set('memory_limit', '-1'); // Adjust the limit as needed
ob_start();
/*
 * PMS Version 2.0 Stable
 * */
//error_reporting(0); //prod
error_reporting(E_ALL ^ E_DEPRECATED ^ E_STRICT); //dev


//All your base are belong to me - enforce https in a nice and safe way
$host = explode(".", $_SERVER['HTTP_HOST']);

if (!strpos('---' . $_SERVER['REQUEST_URI'], 'api')) {
    if ($_SERVER["HTTPS"] != "on") {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}

define('ROOTPATH', dirname(__FILE__));
//Define important stuff
$uploadpath = dirname(__FILE__) . '/uploads';
define('UPLOADPATH', $uploadpath);
$cachedir = dirname(__FILE__) . '/cache';
define('CACHEDIR', $cachedir);
$attachmentpath = dirname(__FILE__) . '/attachments';
define('ATTACHMENTPATH', $attachmentpath);
$uploadpath = dirname(__FILE__) . '/autoPopulate';
define('POPULATE_PATH', $uploadpath);
$staticPath = dirname(__FILE__) . '/static';
define('STATIC_PATH', $staticPath);
define('CLIENT_SECRET_JSON_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'client_secret_calendar.json');

/*
 * Timezone set
 */
date_default_timezone_set('America/New_York');

/*
 * This defines the lockdown of the old proposal items system
 * Do not change this value else some things will get messed up
 * (int) Timestamp for where the lockdown of the system started
 */
define('service_system_start', 1355995996);
/*
 *---------------------------------------------------------------
 * PHP ERROR REPORTING LEVEL
 *---------------------------------------------------------------
 *
 * By default CI runs with error reporting set to ALL.  For security
 * reasons you are encouraged to change this to 0 when your site goes live.
 * For more info visit:  http://www.php.net/error_reporting
 *
 */
//error_reporting(E_ALL);


/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same  directory
 * as this file.
 *
 */
$system_path = "system";

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder then the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server.  If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 *
 */
$application_folder = "application";

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here.  For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT:  If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller.  Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 *
 */
// The directory name, relative to the "controllers" folder.  Leave blank
// if your controller is not in a sub-folder within the "controllers" folder
// $routing['directory'] = '';

// The controller class file name.  Example:  Mycontroller.php
// $routing['controller'] = '';

// The controller function you wish to be called.
// $routing['function']	= '';

/*
* -------------------------------------------------------------------
*  CUSTOM CONFIG VALUES
* -------------------------------------------------------------------
*
* The $assign_to_config array below will be passed dynamically to the
* config class when initialized. This allows you to set custom config
* items or override any default config values found in the config.php file.
* This can be handy as it permits you to share one application between
* multiple front controller files, with each file containing different
* config values.
*
* Un-comment the $assign_to_config array below to use this feature
*
*/
// $assign_to_config['name_of_config_item'] = 'value of config item';

// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
* ---------------------------------------------------------------
*  Resolve the system path for increased reliability
* ---------------------------------------------------------------
*/
if (realpath($system_path) !== FALSE) {
    $system_path = realpath($system_path) . '/';
}

// ensure there's a trailing slash
$system_path = rtrim($system_path, '/') . '/';

// Is the system path correct?
if (!is_dir($system_path)) {
    exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: " . pathinfo(__FILE__, PATHINFO_BASENAME));
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// The PHP file extension
define('EXT', '.php');

// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

// The path to the "application" folder
if (is_dir($application_folder)) {
    define('APPPATH', $application_folder . '/');
} else {
    if (!is_dir(BASEPATH . $application_folder . '/')) {
        exit("Your application folder path does not appear to be set correctly. Please open the following file and correct this: " . SELF);
    }

    define('APPPATH', BASEPATH . $application_folder . '/');
}

//define dev/prod constants - one would be enough but each should be used for clarity in writing code, to make things simpler
if (!strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')
    || strstr($_SERVER['HTTP_HOST'], 'staging.pavementlayers.com')
    || strstr($_SERVER['HTTP_HOST'], 'local.pms.pavementlayers.com')
    || strstr($_SERVER['HTTP_HOST'], 'local.php7.pms.pavementlayers.com')
    //&& !strstr($_SERVER['HTTP_HOST'], 'git.pavementlayers.com')
) {
    define('DEV', true);
    define('PROD', false);
} else {
    define('DEV', false);
    define('PROD', true);
}


// Environment for Sentry
if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')
    && !strstr($_SERVER['HTTP_HOST'], 'local.pms.pavementlayers.com')
    && !strstr($_SERVER['HTTP_HOST'], 'local.php7.pms.pavementlayers.com')) {
    define('SENTRY_ENVIRONMENT', 'production');
} else if (strstr($_SERVER['HTTP_HOST'], 'staging.pavementlayers.com')) {
    define('SENTRY_ENVIRONMENT', 'staging');
} else {
    define('SENTRY_ENVIRONMENT', 'development');
}

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 *
 */
require_once 'vendor/autoload.php';

\Sentry\init(['dsn' => 'https://2d2b260bd42a4922aaee1f08329f9b43@o526047.ingest.sentry.io/5641055' ]);

// Load Env vars
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once BASEPATH . 'core/CodeIgniter' . EXT;

ob_end_flush();
/* End of file index.php */
/* Location: ./index.php */