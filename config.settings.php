<?php

ini_set('display_errors', !IS_ENV_PRODUCTION); //whether or not to display errors to users based upon production environment setting

//establish a connection to the database server
$GLOBALS['DB'] = new mysqli(ZIPSME_DB_HOST, ZIPSME_DB_USER, ZIPSME_DB_PASSWORD, ZIPSME_DB_NAME);
if ($GLOBALS['DB']->connect_errno) {
	trigger_error("Failed to connect to MySQL: " . $GLOBALS['DB']->connect_error);	
}

//autoload classes
function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

//include common functions
include('functions.php');

//encrypted password
define('ZIPSME_PASSWORD_CRYPT', getEncryptedPassword(ZIPSME_PASSWORD));

?>