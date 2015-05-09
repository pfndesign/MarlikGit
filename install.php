<?php
/**
 *
 * @package INSTALLATION
 * @version $Id: install.php 0999 2009-12-13 Aneeshtan $
 * @copyright (c) Marlik Group  http://www.nukelearn.com
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

define('INSTALLATION_FILE', true);
error_reporting(E_ERROR);

//===========================================
//Defined Constants
//===========================================
define('PHOENIX_BASE_DIR', dirname(__FILE__) . '/');
// Absolute Phoenix Directory And Includes
define('PHOENIX_INCLUDE_DIR', PHOENIX_BASE_DIR . 'includes/');

define("IN_USV", true);
define('BASE_PATH', dirname(__FILE__) . '/');
define('INCLUDES_PATH', 'includes/');
define('INSTALL_PATH', BASE_PATH . 'INSTALLATION/');
define('INSTALL_LANGUAGE_PATH', INSTALL_PATH . 'languages/');
define('DEF_LANGUAGE', (!empty($_COOKIE['ilang']) ? $_COOKIE['ilang'] : 'persian'));
define('INSTALL_UPLOAD', BASE_PATH . 'update/');
define('INSTALL_FILE', 'install');
define('SPONSER_URL', 'nukelearn.com');
define('MAINTENANCE_MODE', 'install');
define("USV_FILENAME", 'Tigris_1_1_6.sql');
define('USV_VERSION', 'Tigris_1_1_6');
define('MYBB_VERSION', 'mybb_1_6_4.sql');
define('INCLUDES_ACP', INCLUDES_PATH . 'acp/');
$function_call = "install_" . (!empty($_POST['step']) ? $_POST['step'] : 1);

require(INSTALL_PATH . "functions.php");

USV_INSTALL_LANGUAGE();
USV_INSTALL_HEADER();



//===========================================
//isset Functions
//===========================================
if (isset($_POST['step']) && ($_POST['step'] == 1 || $_POST['step'] == 2 || $_POST['step'] == 3 || $_POST['step'] == 4 || $_POST['step'] == 5 || $_POST['step'] == 6 || $_POST['step'] == 7 || $_POST['step'] == 8 || $_POST['step'] == 9 || $_POST['step'] == 10 || $_POST['step'] == 11)) {
    $function_call();
} elseif (isset($_REQUEST['update'])) {
    run_update();
} elseif (isset($_REQUEST['convert'])) {
    run_convert();
} else {
    check_if_portal_installed();
}

if (!empty($_REQUEST['lang'])) {
	setcookie("ilang",$_REQUEST['lang'],time()+31536000);
}

//===========================================
//INSTALLATION STEPS
//===========================================
function install_main()
{
    $content = "<div style='padding:10px;line-height:20px;'>" . TEXT_INSTALLATION_NOTE;
    $content .= '
	<center><img src="includes/upload/Nukelearn/NukelearnUSV.png"></center>
	<form name="install" action="' . INSTALL_FILE . '.php" method="post">
	<input type="hidden" name="step" value="1">
	<input type="submit"  value=' . START_INST . ' style="background:#D2E20D;color:#1E3F9E;padding-right:25px;padding-left:25px;font-size:14px;" >
	</form>
	<form name="update" action="' . INSTALL_FILE . '.php" method="post" style="background:none;" >
	</div>';
    echo $content;
    USV_INSTALL_FOOTER();
}

function uninstall_main()
{
    $content = '<div style="padding:10px;line-height:20px;">' . TEXT_PORTALINFO . '
<br> <b><a href="http://www.nukelearn.com">www.nukelearn.com</a></b>
';
    $content .= '
	<center><img src="includes/upload/Nukelearn/NukelearnUSV.png"></center>
	<form name="install" action="' . INSTALL_FILE . '.php" method="post">
	<input type="hidden" name="step" value="10">
	<input type="submit"  value="' . UNINSTALL . '" style="background:#F04509;color:#fff;padding-right:25px;padding-left:25px;font-size:14px;" >
	<a href="' . INSTALL_FILE . '.php?update=1" class="button"  style="background:#AAF466;color:#000;padding-right:25px;padding-left:25px;font-size:14px;" >
	' . UPDATE . '
	</a>
	   -  - <a href="' . INSTALL_FILE . '.php?convert=1" class="button"  style="background:#F7CC3E;color:#000;padding-right:25px;padding-left:25px;font-size:14px;" >
	   ' . CONVERT . '
	</a>
	</form>
	</div>';
    echo $content;
    USV_INSTALL_FOOTER();
}

function install_1()
{
    echo TEXT_READ_LICENSE;
?>
<div style="text-align:center;padding:20px;">
<form name="form" action="<?PHP
    echo INSTALL_FILE;
?>.php" method="post"><textarea name="gpl" rows="12" cols="72" style="width:100%" readonly>
<?php
    @include(INSTALL_LANGUAGE_PATH . "" . DEF_LANGUAGE . "-gpl.txt");
?>
</textarea> <br>
<input type="checkbox" name="choice" checked>&nbsp;<?php
    echo TEXT_ACCEPT;
?>
 <a href="<?PHP
    echo INSTALL_FILE;
?>.php">
 <br><br>
 <input	type="button" border="0" value=" <?php
    echo CANCEL;
?> "></a>
<input type="submit"
		border="0" value=" <?php
    echo NEXT;
?> ">
	<input type="hidden" name="step" value="2">
</form></div>
<?php
    USV_INSTALL_FOOTER();
}

function install_2()
{
    if ($_POST['choice'] != "on") {
        echo "<br>" . TEXT_LICENSE_STOP;
?>
<div style="text-align:center;padding:20px;">
				<form name="form" action="<?PHP
        echo INSTALL_FILE;
?>.php"
					method="post"><input type="hidden" name="step" value="1">
				<a href="<?PHP
        echo INSTALL_FILE;
?>.php"><input
					type="button" border="0" value=" <?php
        echo CANCEL;
?> "></a> <input type="submit"
					border="0" value=" <?php
        echo NEXT;
?> ">
				</form>
<?php
    } else {
        echo '<p>' . TEXT_IMPORT_DB . '</p>
	<table class="form-table">
		<form name="form" action="' . INSTALL_FILE . '.php" method="post">
		<tr>
			<th scope="row"><label>' . TEXT_DB_NAME . '</label></th>
			<td><input name="DB_DATABASE" type="text" size="25" value=""  /></td>
			<td>' . TEXT_DB_ETC . ' </td>
		</tr>
		<tr>
			<th scope="row"><label>' . TEXT_DB_USERNAME . '</label></th>

			<td><input name="DB_SERVER_USERNAME"  type="text" size="25" value="" /></td>
			<td>' . TEXT_DB_USERNAME1 . ' </td>
		</tr>
		<tr>
			<th scope="row"><label>' . TEXT_DB_PASSWORD . '</label></th>
			<td><input name="DB_SERVER_PASSWORD" type="password" size="25" value=""  /></td>
			<td>' . TEXT_DB_PASSWORD_NOTE . ' </td>
		</tr>
	</table>
	<div> 

       
        <fieldset style="background:#FFF7BF"> <legend>' . TEXT_INSTALLATION_OPTIONS . '</legend>
        <p> ' . TEXT_MYBB_INSTALL . '
        <input type="radio" name="MyBB_INST"  value="1"  checked />' . YES . '
        <input type="radio" name="MyBB_INST"  value="0"  />' . NO . '
        </p>
        </fieldset>
       
        <fieldset> <legend>' . TEXT_DEFAULT_VALUES . ' :</legend>
	<p>	' . TEXT_DB_SERVER . ' <input type="text" name="DB_SERVER"  style="color: #888888;" value="localhost" /></p>
	<p>	' . TEXT_DB_PREFIX . '<input type="text" name="DB_PREFIX"  readonly style="color: #888888;" value="nuke" /></p>
	<input type="hidden" name="DB_USER_PREFIX" value="nuke">
	</fieldset>
<p class="step">
<input type="hidden" name="step" value="5">
<a href="' . INSTALL_FILE . '.php"  class="button" >' . CANCEL . '</a> 
<input type="submit" value="' . NEXT . '" class="button">
</p>	
</form>';
        
    }
    
    
    USV_INSTALL_FOOTER();
}

function install_5()
{
    global $con;
    if (empty($_POST['DB_SERVER']) || empty($_POST['DB_SERVER_USERNAME']) || empty($_POST['DB_SERVER_PASSWORD']) || empty($_POST['DB_DATABASE'])) {
?>
	<table border="0" width="580" height="330">
		<tr>
			<td valign="top" align="right"><b><?php
        echo ERROR;
?></b>: <?php
        echo TEXT_MISSING_DATA;
?>    
	<br>
			<b><?php
        echo ERROR;
?></b>: <?php
        echo EMPTYINPUT;
?>    
	</td>
		</tr>
		<tr>
			<td valign="middle" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="bottom">
			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<tr>
					<form name="form" action="<?PHP
        echo INSTALL_FILE;
?>.php" method="post"><input
						type="hidden" name="step" value="2"> <input type="hidden"
						name="choice" value="on">
					
					
					<td align="center"><input type="submit" value=" <?php
        echo BACK;
?> "></td>
					</form>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<?php
    } else {
        $DB_SERVER          = trim(stripslashes($_POST['DB_SERVER']));
        $DB_DATABASE        = trim(stripslashes($_POST['DB_DATABASE']));
        $DB_SERVER_USERNAME = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
        $DB_PREFIX          = trim(stripslashes($_POST['DB_PREFIX']));
        $MyBB_INST        = trim(stripslashes(intval($_POST['MyBB_INST'])));
        $DB_USER_PREFIX     = "nuke_";
        $DB_SERVER_PASSWORD = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
        $DB_TYPE            = "MySQL";
        $nuke_sql           = USV_FILENAME;
        if (!file_exists(INSTALL_PATH . "versions/" . USV_FILENAME . "")) {
            die(NO_DB_FILE);
        }
        include(INSTALL_PATH . "db.php");
        
        if ($problems_DB == 1) {
?>
		<table border="0" width="580" height="330">
		<tr>
			<td valign="top" align="right"><font class="title"><?php
            echo ERROR;
?></font>
			<br>
			<br>
		<?php
            echo TEXT_ERROR_DB;
?>
		</td>
		</tr>
		<tr>
			<td valign="middle" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="bottom">
			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<tr>
					<form name="form" action="<?PHP
            echo INSTALL_FILE;
?>.php" method="post"><input
						type="hidden" name="step" value="5">
					
					
					<td align="center"><input type="submit" value=" <?php
            echo BACK;
?> "></td>
					</form>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<?php
        } else {
        	
        	$sql_file = INSTALL_PATH . "versions/" . $nuke_sql;
        	osc_set_time_limit(0);
        	$return = osc_db_install($sql_file);

        	if ($MyBB_INST == 1) {
        		osc_set_time_limit(0);
        		$sql_file2 = INSTALL_PATH . "versions/".MYBB_VERSION."";
        		$return2 = osc_db_install($sql_file2);
        	}
            
            if ($return == -1 || $return2 == -1 || !file_exists($sql_file)) {
?>
		<table border="0" width="580" height="330">
		<tr>
			<td valign="top" align="right"><font class="title"><?php
                echo "<b>".ERROR."</b><hr>";
?></font>
			<br>
			<br>
		<?php
                echo "<b>".TEXT_ERROR_SQL_FILE."</b>";
?>
		<i><?php
                echo $sql_file;
?></i></td>
		</tr>
		<tr>
			<td valign="middle" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="bottom">
			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<form name="form" action="<?PHP echo INSTALL_FILE;?>.php" method="post">
				<input	type="hidden" name="step" value="5">
			    	<tr>
					<td align="center"><input type="submit" value=" <?php
                echo RETRY;
?> "></td>
				</tr>
<?php
                reset($_POST);
                while (list($key, $value) = each($_POST)) {
                    if (($key != 'x') && ($key != 'y') && ($key != 'step')) {
                        if (is_array($value)) {
                            for ($i = 0; $i < sizeof($value); $i++) {
                                echo osc_draw_hidden_field($key . '[]', $value[$i]);
                            }
                        } else {
                            echo osc_draw_hidden_field($key, $value);
                        }
                    }
                }
?>
		</form>
			</table>
			</td>
		</tr>
	</table>
<?php
            } else {
                $currentDomain = getenv("HTTP_HOST");
                $currenturl    = !empty($currentDomain) ? $currentDomain : SPONSER_URL;
?>
		<table>
		<tr>
			<td valign="top" align="right">
			<br>
			<?php
                echo TEXT_IMPORT_DB_OK;
?> 
			<table	align="center">
				<tr>
					<form name="form1" action="<?PHP
                echo INSTALL_FILE;
?>.php" method="post">
					<tr>
					<td width="16%" valign="top" nowrap><?php
                echo TEXT_DOMAIN;
?>:</td>
					<td width="46%" valign="top"><input dir="ltr" type="text"
						name="DOMAIN_NAME" value="<?php
                echo 'http://'. $_SERVER['HTTP_HOST'].rtrim((string)dirname($_SERVER['SCRIPT_NAME']), '/\\').'';
?>"></td></tr>
					<tr>

					<td width="16%" valign="top" nowrap>
                  <?php  echo TEXT_ADMIN_FILE_NAME;  ?>
                    </td>
					<td width="46%" valign="top"><input dir="ltr" type="text"
						name="admin_file" value="admin">.php</td>
					<td width="38%" valign="top"><font class="tiny"><img src="images/icon/help.png" title="<?php
                echo TEXT_DIAMAIN_GUIDE;
?>"></font></td>
				</tr>
			</table>
<?php
                reset($_POST);
                while (list($key, $value) = each($_POST)) {
                    if (($key != 'x') && ($key != 'y') && ($key != 'step')) {
                        if (is_array($value)) {
                            for ($i = 0; $i < sizeof($value); $i++) {
                                echo osc_draw_hidden_field($key . '[]', $value[$i]);
                            }
                        } else {
                            echo osc_draw_hidden_field($key, $value);
                        }
                    }
                }
?>
			</td>
		</tr>
		<tr>
			<td valign="bottom"><input type="hidden" name="step" value="6">
			<table align="center">
				<tr>
	<hr></hr><td ><a href="<?PHP
                echo INSTALL_FILE;
?>.php"><input
		type="button" border="0" value=" <?php
                echo CANCEL;
?> "></a></input>
		 <input type="submit" value=" <?php
                echo NEXT;
?> " ></input>
					</form>
				</tr>
			</table>
			</td>
		</tr>
	</table>
			<?php
            }
        }
    }
}

function install_6()
{
    global $con;
    if (!file_exists("config.php")) {
?>
	<table border="0" width="580" height="330">
		<tr>
			<td valign="top" align="left"><br>
			<font class="title"><?php
        echo TEXT_CONFIG_FILE_NOT_FOUND;
?></font> <br>
			<br>
	<?php
        echo TEXT_FILE_NOT_FOUND;
?></p>
			</td>
		</tr>
		<tr>
			<td valign="middle" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="bottom">

			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<tr>
					<form name="form" action="<?PHP
        echo INSTALL_FILE;
?>.php" method="post"><input
						type="hidden" name="step" value="6">
	<?php
        reset($_POST);
        while (list($key, $value) = each($_POST)) {
            if (($key != 'x') && ($key != 'y') && ($key != 'step')) {
                if (is_array($value)) {
                    for ($i = 0; $i < sizeof($value); $i++) {
                        echo osc_draw_hidden_field($key . '[]', $value[$i]);
                    }
                } else {
                    echo osc_draw_hidden_field($key, $value);
                }
            }
        }
?>
	    
					
					
					<td align="center">
					
					
					<td align="center"><input type="button" value=" <?php
        echo RETRY;
?> "></td>
					</td>
					</form>
				</tr>
			</table>

			</td>
		</tr>
	</table>
<?php
    } elseif (file_exists("config.php") && !is_writeable("config.php") && !is_writeable("admin.php")) {
?>
	<table dir=rtl border="0" width="580" height="330">
		<tr>
			<td valign="top" align="right"><br>
			<p><?php
        echo TEXT_NOT_WRITABLE;
?></p>
			>
			<table cellpadding="6">
				<tr>
					<td width="30"></td>
					<td width="400" bgcolor="#000000"><font color="#ffffff"> <br>
	<?php
        echo "root@localhost#&nbsp;&nbsp;&nbsp;&nbsp;chmod 666 config.php&nbsp;";
?>
	<br>
					<br>
					</font></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td valign="middle" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="bottom">
			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<tr>
					<form name="form" action="<?PHP
        echo INSTALL_FILE;
?>.php" method="post"><input
						type="hidden" name="step" value="6">
	<?php
        reset($_POST);
        while (list($key, $value) = each($_POST)) {
            if (($key != 'x') && ($key != 'y') && ($key != 'step')) {
                if (is_array($value)) {
                    for ($i = 0; $i < sizeof($value); $i++) {
                        echo osc_draw_hidden_field($key . '[]', $value[$i]);
                    }
                } else {
                    echo osc_draw_hidden_field($key, $value);
                }
            }
        }
?>
	    
					
				<td align="center"> <input type="submit"
					border="0" value=" <?php
        echo NEXT;
?> "></td>
					</form>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<?php
    } else {
?>
	<table border="0" width="580" height="330">
		<tr>
			<td valign="top" align="right">
<?php
        $file_contents = '<?php ' . "\n\n" . '

/**
*
* @package config file														
* @version $Id: RC-7 FINAL $ 2:12 AM 12/25/2009						
* @copyright (c)Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (stristr(htmlentities($_SERVER["PHP_SELF"]), "config.php")) {Header("Location: config.php"); show_error(HACKING_ATTEMPT);}

//-----------------------------------------------------------------------

$dbhost = "' . trim(stripslashes($_POST['DB_SERVER'])) . '"; 
$dbuname = "' . trim(stripslashes($_POST['DB_SERVER_USERNAME'])) . '";  // Database username
$dbpass = "' . trim(stripslashes($_POST['DB_SERVER_PASSWORD'])) . '";	// Database password
$dbname = "' . trim(stripslashes($_POST['DB_DATABASE'])) . '";	// Database NAME

//-----------------------------------------------------------------------
$dbtype = "MySQL";
//-----------------------------------------------------------------------
$prefix = "' . trim(stripslashes($_POST['DB_USER_PREFIX'])) . '";
$user_prefix = "' . trim(stripslashes($_POST['DB_USER_PREFIX'])) . '";
$nuke_prefix = "' . trim(stripslashes($_POST['DB_USER_PREFIX'])) . '_";
//-----------------------------------------------------------------------
$display_errors = true; // Debug System 
define("BENCHMARK",false);//benchmark SYSTEM
//-----------------------------------------------------------------------
$tipath = "images/topics/";
$admin_file = "' . trim(stripslashes($_POST['admin_file'])) . '";
$ThemeDef = "Par";
$sitekey = "' . md5($_POST['DOMAIN_NAME']) . '-' . USV_VERSION . '-' . $_POST['DB_DATABASE'] . '";
define("USV_DOMAIN", "' . trim(stripslashes($_POST['DOMAIN_NAME'])) . '");
//-----------------------------------------------------------------------
' . "\n" . '?>';
        
        
        
        
        $fp = fopen('config.php', 'w');
        fputs($fp, $file_contents);
        fclose($fp);
        
		@rename("admin.php", "".trim(stripslashes($_POST['admin_file'])). ".php");
	
		if (!file_exists($_POST['admin_file'].".php")) {
			echo "<div class='error'>".NO_ADMIN_FILE."</div>";
		}
        
        echo "<div class='info'><br>". TEXT_WRITE_OK . "<br><br>";
        
        if (getenv("HTTP_HOST") != "localhost") {
       echo "<font class=\"title\" color=\"red\">" . TEXT_IMPORTANT . " </font>: " . TEXT_RETRY_CHMOD . "<br>";
        }
       echo "</div><br>" . TEXT_CREATE_ADMIN . "<br><br>\n
       
<form name=\"form\" action=\"" . INSTALL_FILE . ".php\" method=\"POST\">\n" .
 "<input type=\"hidden\" name=\"step\" value=\"7\">\n" 
       . "<input type=\"hidden\" name=\"ADMIN_FILE\" value=\"" . trim(stripslashes($_POST['admin_file'])) . "\">\n";
       
?>
	<table	align="center">
				<tr>
					<td width="30%" valign="top"><?php
        echo TEXT_NICKNAME;
?>:</td>
					<td width="70%" valign="top"><input type="text" name="name"
						size="32" value="<?php
        echo $www_location;
?>"> <font size="1"><?php
        echo TEXT_REQUIRED;
?></font></td>
				</tr>
				<tr>
					<td width="30%" valign="top"><?php
        echo TEXT_HOMEPAGE;
?>:</td>
					<td width="70%" valign="top"><input type="text" name="url"
						size="32"></td>
				</tr>
				<tr>
					<td width="30%" valign="top"><?php
        echo TEXT_EMAIL;
?>:</td>
					<td width="70%" valign="top"><input type="text" name="email"
						size="32"> <font size="1"><?php
        echo TEXT_REQUIRED;
?></font></td>
				</tr>
				<tr>
					<td width="30%" valign="top"><?php
        echo TEXT_PASSWORD;
?>:</td>
					<td width="70%" valign="top"><input type="password" name="pwd"
						size="32"> <font size="1"><?php
        echo TEXT_REQUIRED;
?></font></td>
				</tr>
				<tr>
					<td width="45%" valign="top"><?php
        echo TEXT_CREATE_USER;
?></td>
					<td width="55%" valign="top"><input type="radio" name="user_new"
						value="1" checked><?php
        echo TEXT_ACCOUNTYES;
?> &nbsp;&nbsp;
        <input type="radio" name="user_new" value="0"><?php
        echo TEXT_ACCOUNTNO;
?>
        </td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td valign="bottom">
			<table border="0" width="100%" height="40" cellspacing="0"
				cellpadding="0">
				<tr>
	<?php
        reset($_POST);
        while (list($key, $value) = each($_POST)) {
            if (($key != 'x') && ($key != 'y') && ($key != 'step')) {
                if (is_array($value)) {
                    for ($i = 0; $i < sizeof($value); $i++) {
                        echo osc_draw_hidden_field($key . '[]', $value[$i]);
                    }
                } else {
                    echo osc_draw_hidden_field($key, $value);
                }
            }
        }
?>
						
			<td align="center"><a href="<?PHP
        echo INSTALL_FILE;
?>.php"><input
					type="button" border="0" value=" <?php
        echo CANCEL;
?> "></a> <input type="submit"
					border="0" value=" <?php
        echo NEXT;
?> "></td>
					
											
					</form>
				</tr>
			</table>
			</td>
		</tr>
	</table>
<?php
        USV_INSTALL_FOOTER();
    }
}

function install_7()
{
    include(INSTALL_PATH . "db.php");
    global $prefix, $con;
    
    $admin_file = trim(stripslashes($_POST['ADMIN_FILE']));
    
    if ($_POST['stop'] == 1 || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pwd'])) {
        echo "<br>" . ERROR . ":<br>" . TEXT_ADMIN_STOP;
        
        if (is_writeable("config.php")) {
            echo "</td></tr><tr><td valign=\"middle\">" . "<font class=\"title\">" . TEXT_IMPORTANT . ":</font> " . TEXT_WARNING_CHMOD;
            
        }
?>
    </td></tr><tr><td valign="bottom">
            <table border="0" width="100%" height="40" cellspacing="0" cellpadding="0">
                      <tr>
    <form name="form" action="<?PHP
        echo INSTALL_FILE;
?>.php" method="post">
    <input type="hidden" name="step" value="6">                              
	<td align="center"><input type="SUBMIT" value=" <?php
        echo RETRY;
?> "></td>
                        </form>
                      </tr>
                    </table>
        </form>
    </td></tr>
    </table>
	<?php
        
    } else {
        $DB_SERVER          = trim(stripslashes($_POST['DB_SERVER']));
        $DB_DATABASE        = trim(stripslashes($_POST['DB_DATABASE']));
        $DB_SERVER_USERNAME = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
        $DB_PREFIX          = trim(stripslashes($_POST['DB_PREFIX']));
        $DB_USER_PREFIX     = trim(stripslashes($_POST['DB_USER_PREFIX']));
        $DB_SERVER_PASSWORD = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
        $DB_TYPE            = $_POST['DB_TYPE'];
        $MyBB_INST        = trim(stripslashes(intval($_POST['MyBB_INST'])));
        include(INSTALL_PATH . "db.php");
        global $con;

			//--- LETS SYNC THE MYBB DATA WITH OUR VALUES ====
			//--
			if ($MyBB_INST == 1) {
				global $db;
				@require_once('forums/inc/functions.php');
				@require_once('forums/inc/functions_user.php');

				// MD5 the password
				$md5password = md5($_POST['pwd']);
				// Generate our salt
				$salt = generate_salt();
				// Combine the password and salt
				$saltedpw = salt_password($md5password, $salt);
				// Generate the user login key
				$loginkey  = generate_loginkey();
							
				
				$con->sql_query("UPDATE `mybb_forums` SET `lastposter`='".sql_quote($_POST['name'])."'");
				$con->sql_query("UPDATE `mybb_posts` SET `username`='".sql_quote($_POST['name'])."'");
				$con->sql_query("UPDATE `mybb_threads` SET `username`='".sql_quote($_POST['name'])."',
				`lastposter`='".sql_quote($_POST['name'])."'");
				$con->sql_query("UPDATE `mybb_users` SET `username`='".sql_quote($_POST['name'])."'");
				$con->sql_query("UPDATE `mybb_users` SET `email`='".sql_quote($_POST['email'])."'");
				$con->sql_query("UPDATE `mybb_users` SET `password`='$saltedpw'");
				$con->sql_query("UPDATE `mybb_users` SET `salt`='$salt'");
				$con->sql_query("UPDATE `mybb_users` SET `loginkey`='$loginkey'");
				$con->sql_query("UPDATE `mybb_users` SET `regdate`='".time()."'");
				$con->sql_query("UPDATE `mybb_settings` SET `value`='".USV_DOMAIN."/forums' WHERE sid='32'");
				$con->sql_query("UPDATE `mybb_settings` SET `value`='".rtrim((string)dirname($_SERVER['SCRIPT_NAME']))."/forums/' WHERE sid='40'");
				
				if (is_writable("forums/inc/settings.php")) {
					

	replace_file("forums/inc/settings.php","/USV3/forums/","".rtrim((string)dirname($_SERVER['SCRIPT_NAME']))."/forums/");
	replace_file("forums/inc/settings.php","http://localhost/USV3/forums","".USV_DOMAIN."/forums");
				
				}else {
					echo "" . TEXT_ACCESS_LEVEL_INFO . "<br>
					<b>forums/inc/settings.php</b>
					";
				}
				
				
			}
        
        
        create_first($_POST['name'], $_POST['url'], $_POST['email'], $_POST['pwd'], $_POST['user_new']);
              
        
        echo "<br><br><img src='images/icon/tick.png' border='0'>" . TEXT_ADMIN_CREATED . "<br><br>";
        
?>
	<img src='images/icon/shield_go.png' border='0'><?php
        echo TEXT_PERMISSION;
?>
<?php

        echo "<p style='background-color:#E0D2CB'>" . TEXT_DELETE_FOLLOWING_FILES . "
		<br>" . TEXT_DELETE_INSTALLATION_FOLDER . "
		<br>" . TEXT_DELETE_INSTALL_FILE . "</p>
		<P align='center'><a href='" .$_POST['admin_file'] . ".php'><input type='button' value='" . ADMINISTRATOR . "' ></a>
		<a href='index.php'><input type='button' value='" . SHOWMYSITE . "' ></a></p>";
        
        echo "<br><a href='http://www.nukelearn.com/page/catelog'>
		<img src='images/icon/help.png' border='0'>" . CHANGE_PERM_GUIDE . "</a>";
        echo '<div style="height:200px;overflow:auto;" ><table id="gradient-style" summary="' . TEXT_PERMISSION . '">
   		<thead>
		';
        echo "	<tr dir='rtl'  align='right'  bgcolor=\"$bgcolor4\">\n";
        echo "		<th scope='col' width=\"60%\">" . PERM_FOLDER_PATH . "</th>\n";
        echo "		<th scope='col' width=\"30%\">" . PERM_CHANGE_TO . "</th>\n";
        echo "	</tr></thead>
		<tfoot>
    	<tr>
        <td colspan='6'>" . TEXT_PERMISSION . "</td>
        </tr>
		</tfoot>
   		<tbody>\n";
        echo "	<tr>\n";
        echo "		<td align=\"center\">cache</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "	<tr>\n";
        echo "		<td align=\"center\">includes/upload/</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "		<td align=\"center\">images/links/</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "		<td align=\"center\">images/links/inc/</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "		<td align=\"center\">images/links/res</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "		<td align=\"center\">images/links/zips</td>\n";
        echo "		<td align=\"center\">777</td>\n";
        echo "	</tr>\n";
        echo "	<tr>\n";
        if ($MyBB_INST == 1) {
            echo "		<td align=\"center\">forums/inc/settings.php</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/uploads</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/uploads/avatars</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/inc/languages</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/admin/backups</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/inc/languages</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/cache</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">forums/cache/themes</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
        }
        elseif ($PHPBB_INST == 1) {
            echo "		<td align=\"center\">modules/phpBB3/Files</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">modules/phpBB3/cache</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">modules/phpBB3/store</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
            echo "	<tr>\n";
            echo "		<td align=\"center\">modules/phpBB3/images/avatars/upload</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
        } else {
            echo "	<tr>\n";
            echo "		<td align=\"center\">modules/Your_Account/images/upload/</td>\n";
            echo "		<td align=\"center\">777</td>\n";
            echo "	</tr>\n";
        }
        echo "		<td align=\"center\">config.php</td>\n";
        echo "		<td align=\"center\">644 - 444 ";
        if (is_writeable($_POST['PATH_CONFIG'] . 'config.php'))
            echo "<br><font color=\"red\"><b>" . WARNING . "</b></font></td>\n";
        echo "	</tr>\n";
       
        echo "</tbody>";
        echo "</table></div>\n";
        
        
        USV_INSTALL_FOOTER();
        
    }
}

function install_10()
{
?>
<h3><?php echo TEXT_PORTAL_DELETE;?></h3>
<hr>
<?php echo TEXT_PORTAL_DELETE_INFO;?>
<br>
<div class='frame_panel_short' style='padding-top:20px;'> 
<form action="<?php
    echo INSTALL_FILE;
?>.php" class="onboard_form" method="post">
<div class='field text_field'>
<label for="username"><?php echo TEXT_USERNAME;?></label>
</div> 
<div class='another_row'> 
<input class="autotab behavior" id="username" name="username" tabindex="1" type="text" /> 
</div> 
<div class='field text_field'>
<label for="password"><?php echo TEXT_PASSWORD;?></label>
</div> 
<div class='one_more_row'> 
<input id="password" name="password" tabindex="2" type="password" value="" />
</div> <br>

<div class='actions'>
<div class="right gistsubmit"><input name="commit" type="submit" value="<?php echo TEXT_DELETE_INFORMATION;?>" /><span></span></div>
<div class="clear"></div>
</div>
<input type="hidden" name="step" value="11">
<div class="clear"></div>
</form> 
</div> 
<?php
}

function install_11()
{  
	
	global $db,$dbname,$DB_USER_PREFIX;

    include("config.php");
    include("db/db.php");

    $myusername = $_POST['username'];
    $mypassword = $_POST['password'];
    // To protect MySQL injection (more detail about MySQL injection)
    $mypassword = mysql_real_escape_string(stripslashes($mypassword));
    $myusername = mysql_real_escape_string(stripslashes($myusername));
    
    $query = "SELECT * FROM ".$DB_USER_PREFIX."nuke_authors WHERE `aid`='$myusername' AND `pwd`='$mypassword'";
    $result = $db->sql_query($query) or mysql_error();
    if ($result) {

	  
	/* query all tables */
	$sql = "SHOW TABLES FROM $dbname";
	if($result = $db->sql_query($sql)){
	  /* add table name to array */
	  while($row = mysql_fetch_row($result)){
		$found_tables[]=$row[0];
	  }
	}
	else{
	  die("Error, could not list tables. MySQL Error: " . mysql_error());
	}
	  
	/* loop through and drop each table */
	echo "<div style='overflow:auto;height:300px;padding:10px;'>";
	foreach($found_tables as $table_name){
	  $sql = "DROP TABLE $dbname.$table_name";
	  if($result = $db->sql_query($sql)){
		echo $table_name. _TABLEDELETED."<br>";
	  }
	  else{
		echo _TABLEDELETEFAILED."<Br>" . mysql_error() . "";
	  }
	}
	echo "</div>";
	
	
	?> <h3 style="text-align:center;padding:20px;color:green"><?php
    echo TEXT_PORTAL_DELETED_SUCCESSFULLY."<br><br>"._GOBACK;
?></h3><?php
        exit;
    } else {
        die("<div class='error'>" . TEXT_PORTAL_DELETED_UNSUCCESSFULLY . "<Br>".mysql_error()."<br>"._GOBACK."</div>");
    }
	$db->sql_freeresult($result);
    
    echo " $username -$password ";
}
//-------------
function check_if_portal_installed()
{
    include("config.php");
    include("db/mysql.php"); 

	
    $db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
	$result = $db->sql_query("SELECT * FROM ".$prefix."_authors");
	
	if(!$db->db_connect_id OR empty($result)) {
        install_main();
    } else {
        uninstall_main();
    }
    
	$db->sql_freeresult($result);
}

function run_update()
{
    global $db;
    require_once("mainfile.php");
    include(INSTALL_PATH."update.php");
}

function run_convert()
{
    global $db;
    require_once("mainfile.php");
    require_once("convert.php");
}



?>