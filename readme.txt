Z.ips.ME
Version 2.0
Requirements: Developed for PHP 5.6+ / MySQL 5.6+, however it may work on earlier versions

--------------------------------------------------------------------------------------------------

Thanks for downloading Z.ips.ME!  

Installation is pretty simple:

1. Create a MySQL database and MySQL database user on your web server.  Make sure the user has permission to SELECT, INSERT, UPDATE, DELETE, CREATE, INDEX, and ALTER. Make note of the database name, the database user name, and the password.
2. Open the config.php file in a text editor.  Edit the database information, site information, and admin username/password as instructed in the file.
3. Upload the entire contents of this folder to the directory on your site that you plan on using as your URL shortener.
4. Run the install.php file in your browser.  If your URL shortener is http://www.yoursite.com/zipsme/, the file will be located at http://www.yoursite.com/zipsme/install.php.  
5. After the install script has created the database, it will display a link to the admin section (located at  http://www.yoursite.com/admin.php). You can now log in with the username/password combination that you entered into the config.php file.

Enjoy!

Upgrading from a previous version to 2.0:

1. Before uploading, rename the new config.php file to config_new.php to avoid overwriting your config.php file
2. Open your config.php file and delete everything below the comment "You shouldn't need to modify anything below this"
3. Open the config_new.php file and copy the last two lines to your config.php file.  They should contain the ZIPSME_PASSWORD_SALT and IS_ENV_PRODUCTION varaiables

--------------------------------------------------------------------------------------------------

Questions, comments, suggestions, bugs: email info@ips.me

Change log:

2.0
* Simpler config file
* Converted to HTML 5
* Upgraded CSS reset
* Aesthetic improvements, including new fonts
* Responsive design
* Improved cookie security
* Improved SQL queries for faster load times
* Improved error messages
* Better statistics - added referring domains, improved browser detection, added % column

1.2
* added index on url_name in tbl_clicks

1.1
* modified header code in 301 redirect function 
