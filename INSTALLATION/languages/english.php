<?php

/************************************************************************/
/* PHPNuke Installer                                                    */
/* Copyright (c) 2005 by Piero Trono                                    */
/* http://php-multishop.com                                             */
/* ======================================                               */
/*                                                                      */
/* This	program	is free	software. You can redistribute it and/or modify	*/
/* it under the	terms of the GNU General Public	License	as published by	*/
/* the Free Software Foundation; either	version	2 of the License.       */
/************************************************************************/
/* $Id: english.php,v 1.2 2005/07/03 22:11:48 tropic Exp $ */

define('CHARSET', 'UTF-8');

define("TEXT_INSTALLATION_NOTE","Nukelearn CMS is an advanced and <i>intelligent</i> content management system designed and programmed with very hard work. You can easilly design a new and powerfull website with this system by just joining us at  <a href=\"http://nukelearn.com\">http://nukelearn.com</a> where you can find thousands of modules/addons, themes, blocks, graphics, utilities and much more...");
define("TEXT_READ_LICENSE","Please, read the following License, and keep in mind for the next step what the license tells in the <b>2(c)</b> item about <i>Copyright Notice</i>:");
define("TEXT_ACCEPT","I accept the Agreement");
define("TEXT_LICENSE_STOP","You haven't read the notice about the Disclaimer that will be displayed at the footer of the portal.<br><br>Please, click on the <u>retry</u> button and chek the checkbox with the label '<i>" . TEXT_ACCEPT . "</i>'.");
define("TEXT_CREATE_DB","A test connection made to the database was <b>NOT</b> successful.<br><br>Please click on the <i>back</i> button below to review your database server settings."
		."<br>If you require help with your database server settings, please consult your Hosting Company or Administrator.");
define("TEXT_IMPORT_DB","Please enter the DataBase server information:");
define("TEXT_MISSING_DATA","Some data is missing,<br>please click on the <i>back</i> button below and enter all datas.");
define("TEXT_ERROR_DB",TEXT_CREATE_DB);
define("TEXT_ERROR_SQL_FILE","<b>Error</b>: the Sql Import was <b>NOT</b> successful, perhaps the SQL file was not found.<br><br>Check the path on your server:");
define("TEXT_IMPORT_DB_OK","DataBase <b>Successfully</b> imported.");
define("TEXT_ADMIN_FILE","Administration panel filename: '<i>admin</i>' by default for '<i>".ADMIN_PHP."</i>'. To improve security please rename the old admin.php file on your server and insert here the new filename without the .php extension. Note: if you aren't sure set this value to 0.");
define("TEXT_SUBSCRIPTION","If you manage subscriptions on your site, you must write here the url of the subscription information/renewal page. This will send by email if set.");

define("TEXT_DIAMAIN_GUIDE","Please enter your website url with www and https");
define("TEXT_ADVANCED_EDITOR","Turn on/off editor");
define("TEXT_SECURITY_CODE","Security code configuration");
define("TEXT_NOT_WRITABLE","<b>Warning</b>: the <i>config.php</i> file is not writable."
		."<br><br>Please set <font color=\"#ff0000\">chmod 666</font> (writable) to config.php file, "
		."then click on <i>next</i> button.<br><br>For example, on a Unix-like System:");
define("TEXT_CONFIG_FILE_NOT_FOUND","Warning: file <i>config.php</i> NOT found");
define("TEXT_FILE_NOT_FOUND","Please, check the path of '<i>config.php</i>' file on your FileSystem.<br>This file could be located in the same directory where you placed the '<i>install</i>' folder.<br><br>"
		."Also, set the config.php file as writable (chmod 666), so click on <i>retry</i> button.");
define("WRITE_OK","The configuration was <b>successful!</b>");
define("TEXT_WRITE_OK","Configuation has been successfully ended.");
define("TEXT_RETRY_CHMOD","Please change back the permission of config.php file to either 444 or 644");
define("TEXT_WARNING_CHMOD","Please change back the permission of config.php file to either 444 or 644");
define("TEXT_CREATE_ADMIN","So, you must create the <i>Super-Administrator</i> of your Portal.");
define("TEXT_CREATE_USER","Create also an User with this account?");
define("TEXT_ADMIN_STOP","Some error has occurred.<br>Please enter and check all the required datas.");
define("TEXT_ADMIN_CREATED","Congratulation: Super-Administrator created Successfully!<br><br>"
		."Now you must log-in with this account to set some <i>Preferences</i> in the Admin Panel, "
		."after you can use your New Portal.<br>The most important values of <i>Preferences</i> that you <font color=\"#ff0000\"><b>must change</b></font> are:");


define("TEXT_DB_SERVER","Database Server");
define("TEXT_LOCALHOST_IP","(eg. localhost, or IP)");
define("TEXT_DB_NAME","Database Name");
define("TEXT_DB_ETC","(eg. nuke)");
define("TEXT_DB_USERNAME","Username");
define("TEXT_DB_USERNAME1","User with access to the DB");
define("TEXT_DB_PASSWORD","Password");
define("TEXT_DB_PREFIX","Prefix");
define("TEXT_DB_PREFIX1","Your Database table's prefix, default: nuke (*)");
define("TEXT_DB_USERPREFIX","User Prefix");
define("TEXT_DB_USERPREFIX1","Your Users' Database table's prefix (To share it), default: nuke (**)");
define("TEXT_DB_TYPE","DataBase Type");
define("TEXT_SERVER_TYPE","Your Database Server type, default: MySQL");
define("TEXT_NUKEVERSION","PHPNuke Version");
define("TEXT_CHOSE_VERSION","Version of PHPNuke you want to install");
define("TEXT_ERROR","Error");
define("TEXT_SECURITYCODE","Security Code");
define("TEXT_SECURITYCODE1","No check");
define("TEXT_SECURITYCODE2","Administrators login only");
define("TEXT_SECURITYCODE3","Users login only");
define("TEXT_SECURITYCODE4","New users registration only");
define("TEXT_SECURITYCODE5","Users login and new users registr");
define("TEXT_SECURITYCODE6","Admins and users login only");
define("TEXT_SECURITYCODE7","Admins and new users registration");
define("TEXT_SECURITYCODE8","Everywhere on all login options");
define("TEXT_SUBSCRIPTIONTITLE","Url Subscription");
define("TEXT_ADMINFILE","Admin File");
define("TEXT_EDITOR","Advanced Editor");
define("TEXT_EDITOROFF","Editor Off");
define("TEXT_EDITORON","Editor On");
define("TEXT_NICKNAME","Nickname");
define("TEXT_REQUIRED","(required)");
define("TEXT_HOMEPAGE","Home Page");
define("TEXT_EMAIL","Email");
define("TEXT_PASSWORD","Password");
define("TEXT_ACCOUNTYES","Yes");
define("TEXT_ACCOUNTNO"," No");
define("TEXT_IMPORTANT"," Important");
define("TEXT_SITENAME","Site Name ");
define("TEXT_SITEURL","Site URL");
define("TEXT_SITESLOGAN","Site Slogan");
define("TEXT_WEBAMSTERMAIL","Administrator/Webmaster Email");



define("TEXT_PERMISSION","Changing permission of these files are required to prevent future access problems.");
define("TEXT_PERMISSION_CHANGED","changed.");

define("TEXT_PORTALINFO","You are already using Nukelearn CMS as your website content management system.<br>
If you are looking for a way to uninstall this software please inform us of any problem or reason that caused you leave.
");
define("TEXT_INSTALLATION_OPTIONS","Options");
define("TEXT_MYBB_INSTALL","Install Mybb Forums with a bridge to Nukelearn CMS.");
define("TEXT_DEFAULT_VALUES","Default values.");
define("TEXT_ADMIN_FILE_NAME","Admin file name");
define("TEXT_PORTAL_DELETED_SUCCESSFULLY","Your database is successfully deleted.");
define("TEXT_PORTAL_DELETED_UNSUCCESSFULLY","The database has not been deleted.");
define("TEXT_DELETE_INFORMATION","Remove my database.");
define("TEXT_PASSWORD","Password");
define("TEXT_USERNAME","Username");
define("TEXT_PORTAL_DELETE_INFO","In order to be able to remove the website database you may need to enter your correct administration info.");
define("TEXT_PORTAL_DELETE","Remove");
define("TEXT_DELETE_FOLLOWING_FILES","Remove bellow files.");
define("TEXT_DELETE_INSTALL_FILE","Please remove install.php file.");
define("TEXT_DELETE_INSTALLATION_FOLDER","Please remove installation folder as well.");
define("TEXT_ACCESS_LEVEL_INFO","Please change back the permission of config.php file to either 444 or 644");

define("STEP_1","Step 1: the GNU GENERAL PUBLIC License");
define("STEP_2","Step 2: Copyright Notice");
define("STEP_3","Step 3: Create DataBase");
define("STEP_4","Step 4: DataBase Import");
define("STEP_5","Step 5: Configuration (config.php file)");
define("STEP_6","Step 6: Create the Super-Administrator");
define("STEP_7","Step 7: End of Installation");

define("YES","Yes");
define("NO","No");
define("WARNING","Warning");
define("START","Install");
define("NEXT","Next");
define("BACK","Previous");
define("RETRY","try again");
define("CANCEL","cancel");
define("ERROR","ERROR");
define("EMPTYINPUT","Please fill in all input feilds.");
define("PERM_FOLDER_PATH","Folder path");
define("PERM_CHANGE_TO","Change permission to");
define("CHANGE_PERM_GUIDE","Permission Guidance");
define("ADMINISTRATOR","Administration panel");
define("SHOWMYSITE","View Website");
define("UNINSTALL","Remove Website database");
define("UPDATE","Upgrade");
define("START_INST","Install");
define("NO_DB_FILE","There is no database name as you have entered.");
define("NO_ADMIN_FILE","Your admin file is like this  			".$_POST['admin_file']. ".php and  you can change the name to your option.");

?>
