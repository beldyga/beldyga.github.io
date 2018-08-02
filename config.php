<?php
//This is where you enter in your information
define('ZIPSME_DB_USER', 'database_user'); //Your database user name
define('ZIPSME_DB_PASSWORD', 'database_password'); //Your database password
define('ZIPSME_DB_NAME', 'database_name'); //Your database name
define('ZIPSME_DB_HOST', 'localhost'); //99% chance you won't need to change this
define ('SITE_NAME', 'Your Site'); //The name of your site
define ('SITE_URL', 'http://www.yoursite.com/zipsme/');  //The full URL of the site where Z.ips.ME is installed (including trailing slash)
define('ZIPSME_USERNAME', 'username'); //Admin username. You'll use this to log in to Z.ips.ME.  Max length 100 characters.
define('ZIPSME_PASSWORD', 'password'); //Admin password. You'll use this to log in to Z.ips.ME.  Max length 100 characters.
define('ZIPSME_PASSWORD_SALT', '598dD63J321773DwCjk7X9q95'); //used with crypt function, change for added security http://php.net/manual/en/function.crypt.php
define ('IS_ENV_PRODUCTION', true); //set true if production environment, otherwise false to see error messages
?>