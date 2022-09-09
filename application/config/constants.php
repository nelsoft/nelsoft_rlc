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
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

define('GET_VERSIONNO',		"Version 3.0");
define('GET_DATABASE',		"Nelsoft_Clients_new");
define('GET_HOST',		"127.0.0.1");
define('GET_USER',		"root");
define('GET_PASSWORD',		"121586");

define("SYSTEM_LOGS_LOCATION", "C:\Client Base\System Logs\\");
define("CLIENT_DETAILS_ATTACHMENTS_LOCATION", "C:\Client Base\COR Documents\\");
define("CLIENT_GROUP_MODULE", "ClientGroup");
define("NETWORK_MODULE", "Network");
define("BRANCH_MODULE", "Branch");
define("TERMINAL_MODULE", "Terminal-PC");
define("COR_MODULE", "COR");
define("TERMINAL_UPDATE_MANAGER_MODULE", "TUM");
define("SQL_FILE_DIRECTORY", "C:\Client Base\SQL File\\");
define("ANNOUNCEMENT_FILE_DIRECTORY", "C:\Client Base\Announcements\\");
define("PTU_FILE_DIRECTORY", "C:\Client Base\PTU\\");

define("CLIENTBASE_API_DIRECTORY", "http://localhost:85/index.php/api/v1");

/*Constants for id and secret key for Terminal Manaager Update Model API*/
define("RETAIL_POS_ID", "7");
define("RETAIL_POS_SECRET_KEY", "LxMCrAOuE4p5VnG9BjIoDbJETkgz35JsZU2TuM4Z");
define("CIRMS_POS_ID", "6");
define("CIRMS_POS_SECRET_KEY", "qdY2bErLnmWLiFSYfW5cWx1cXmZav3vqlFEAgtF1");
define("LETTUCE_POS_ID", "27");
define("LETTUCE_POS_SECRET_KEY", "DzWp8HBzInNCwXWLKviFyKEfNnXBwPH5gINjuVIH");
