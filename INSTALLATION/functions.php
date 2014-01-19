<?php
global $admin_file,$db;
define("ADMIN_OP",					"".$admin_file.".php?op=");
define("ADMIN_PHP",					"".$admin_file.".php");

if (!function_exists('create_first')) {
	function create_first($name, $url, $email, $pwd, $user_new) {
	global $con;

	
	$DB_USER_PREFIX = trim(stripslashes($_POST['DB_USER_PREFIX']));

	$first = $con->sql_numrows($con->sql_query("SELECT * FROM ".$DB_USER_PREFIX."_authors"));
	if (empty($first)) {
		$pwd = md5($pwd);
		$the_adm = "God";
		$rez = $con->sql_query("INSERT INTO `".$DB_USER_PREFIX."_authors` (`aid`, `name`, `url`, `email`, `pwd`, `counter`, `radminsuper`, `admlanguage`) VALUES
		 ('$name', '$the_adm', '$url', '$email', '$pwd', '0', '1', '')");
		if (!$rez) {
			die("<div class='error'>".TEXT_ERROR_DB."<br>".mysql_error()."<br>"._GOBACK."</div>");
		}
		$date = date("Y-m-d");
		$currentDomain = getenv("HTTP_HOST");
		$currenturl = !empty($currentDomain) ? $currentDomain : SPONSER_URL;

		$con->sql_query("UPDATE `".$DB_USER_PREFIX."_config` SET `startdate`= '$date'");
		$con->sql_query("UPDATE `".$DB_USER_PREFIX."_config` SET `nukeurl`= '$currenturl'");
				
		if ($user_new == 1) {
			$user_regdate = date("M d, Y");
			$user_avatar = "gallery/blank.gif";
			$commentlimit = 4096;
			if ($url == "http://") { $url = ""; }
			$phpbb3installed = $con->sql_numrows($con->sql_query("select group_id from ".$DB_USER_PREFIX."_bb3acl_groups"));
			$mybbinstalled = $con->sql_numrows($con->sql_query("select uid from  mybb_users"));
			$con->sql_query("INSERT INTO ".$DB_USER_PREFIX."_users (user_id, username, user_email, user_website, user_avatar, user_regdate, user_password, theme, commentmax, user_level, user_lang, user_dateformat) VALUES (NULL,'$name','$email','$url','$user_avatar','$user_regdate','$pwd','$Default_Theme','$commentlimit', '2', 'persian','D M d, Y g:i a')");
			if (!empty($phpbb3installed)) {
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3users` SET `user_regdate`='$user_regdate' WHERE `user_id`=2 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3users` SET `username`='" . addslashes($name) . "' WHERE `user_id`=2");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3users` SET `username_clean`='" . addslashes($name) . "' WHERE `user_id`=2 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3users` SET `user_password`='$pwd' WHERE `user_id`=2 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3users` SET `user_email`='" . addslashes($email) . "' WHERE `user_id`=2 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3forums` SET `forum_last_poster_name`='" . addslashes($name) . "' WHERE `forum_id`=1 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3forums` SET `forum_last_poster_name`='" . addslashes($name) . "' WHERE `forum_id`=2 ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_bb3topics` SET `topic_last_poster_name`='" . addslashes($name) . "' WHERE `topic_id`=1 ");
			}elseif (!empty($mybbinstalled)){
			$con->sql_query("INSERT INTO `".$DB_USER_PREFIX."_blocks` (`bid`, `bkey`, `title`, `content`, `url`, `bposition`, `weight`, `active`, `refresh`, `time`, `blanguage`, `blockfile`, `view`, `expire`, `action`, `subscription`) VALUES
(NULL, '', 'آخرین ارسال های انجمن های گفتگو', '', '', 'c', 2, 1, 3600, '', 'persian', 'block-mybb_forums.php', 0, '0', 'd', 0);
");
			}else {
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_modules` SET `active`='0' WHERE `title`='phpBB3' ");
			$con->sql_query("UPDATE `".$DB_USER_PREFIX."_blocks` SET `active`='0' WHERE `blockfile`='block-phpBB3_Forum_Center_NukeLearn.php' ");
			$con->sql_query("DELETE FROM `".$DB_USER_PREFIX."_tree_elements` WHERE `Id`='2' OR `Id`='11' OR `Id`='14' OR `Id`='15' OR `Id`='16' ");
			}	
		}
	}else {
		die("<div class='error'>
		مدیر سایت قبلا ایجاد شده است <br> ابتدا  دیتابیس را پاک کنید و مجدد نصب کنید"."
		</div>
		<p style='background-color:#E0D2CB'>فایلهای زیر را پاک کنید
		<br>پوشه INSTALLATION را پاک کنید
		<br>فایل install.php را پاک کنید</p>
		<P align='center'><a href='" .$_POST['admin_file'] . ".php'><input type='button' value='" . ADMINISTRATOR . "' ></a>
		<a href='index.php'><input type='button' value='" . SHOWMYSITE . "' ></a></p>"
		);
	}
}
}


require_once("includes/inc_functions.php");

function osc_in_array($value, $array) {
	if (!$array) $array = array();

	if (function_exists('in_array')) {
		if (is_array($value)) {
			for ($i=0; $i<sizeof($value); $i++) {
				if (in_array($value[$i], $array)) return true;
			}
			return false;
		} else {
			return in_array($value, $array);
		}
	} else {
		reset($array);
		while (list(,$key_value) = each($array)) {
			if (is_array($value)) {
				for ($i=0; $i<sizeof($value); $i++) {
					if ($key_value == $value[$i]) return true;
				}
				return false;
			} else {
				if ($key_value == $value) return true;
			}
		}
	}
	return false;
}
////
// Sets timeout for the current script.
// Cant be used in safe mode.
function osc_set_time_limit($limit) {
	if (!get_cfg_var('safe_mode')) {
		set_time_limit($limit);
	}
}

function osc_draw_input_field($name, $text = '', $type = 'text', $parameters = '', $reinsert_value = true) {
	$field = '<input type="' . $type . '" name="' . $name . '"';
	if ( ($key = $GLOBALS[$name]) || ($key = $GLOBALS['HTTP_GET_VARS'][$name]) || ($key = $GLOBALS['HTTP_POST_VARS'][$name]) || ($key = $GLOBALS['HTTP_SESSION_VARS'][$name]) && ($reinsert_value) ) {
		$field .= ' value="' . $key . '"';
	} elseif ($text != '') {
		$field .= ' value="' . $text . '"';
	}
	if ($parameters) $field.= ' ' . $parameters;
	$field .= '>';

	return $field;
}

function osc_draw_hidden_field($name, $value) {
	return '<input type="hidden" name="' . $name . '" value="' . $value . '">';
}

function osc_db_install($sql_file) {


	global $con;

	if (file_exists($sql_file)) {
		$fd = fopen($sql_file, 'rb');
		$restore_query = fread($fd, filesize($sql_file));
		fclose($fd);
	} else {
		return -1;
	}
	$num_tables = 0;
	$sql_array = array();
	$sql_length = strlen($restore_query);
	$pos = strpos($restore_query, ';');
	for ($i=$pos; $i<$sql_length; $i++) {
		if ($restore_query[0] == '#') {
			$restore_query = ltrim(substr($restore_query, strpos($restore_query, "\n")));
			$sql_length = strlen($restore_query);
			$i = strpos($restore_query, ';')-1;
			continue;
		}
		if ($restore_query[($i+1)] == "\n") {
			for ($j=($i+2); $j<$sql_length; $j++) {
				if (trim($restore_query[$j]) != '') {
					$next = substr($restore_query, $j, 6);
					if ($next[0] == '#') {
						// find out where the break position is so we can remove this line (#comment line)
						for ($k=$j; $k<$sql_length; $k++) {
							if ($restore_query[$k] == "\n") break;
						}
						$query = substr($restore_query, 0, $i+1);
						$restore_query = substr($restore_query, $k);
						// join the query before the comment appeared, with the rest of the dump
						$restore_query = $query . $restore_query;
						$sql_length = strlen($restore_query);
						$i = strpos($restore_query, ';')-1;
						continue 2;
					}
					break;
				}
			}
			if ($next == '') { // get the last insert query
				$next = 'insert';
			}
			if ( (preg_match('/create/i', $next)) || (preg_match('/insert/i', $next)) || (preg_match('/drop t/i', $next)) ) {
				if (preg_match('/create/i', $next)) $num_tables ++;
				$next = '';
				$sql_array[] = substr($restore_query, 0, $i);
				$restore_query = ltrim(substr($restore_query, $i+1));
				$sql_length = strlen($restore_query);
				$i = strpos($restore_query, ';')-1;
			}
		}
	}

	for ($i=0; $i<sizeof($sql_array); $i++) {
	global $con;
	$rez =$con->sql_query($sql_array[$i]); // or die(mysql_error())
	}
if (!$rez) {
	echo "ارتباط با دیتابیس برقرار نشد و اطلاعات به درون بانک اطلاعاتی ریخته نشده است.";
	
}
	return $num_tables;
}


//===========================================
//INSTALLATION Functions
//===========================================
function langstyle2($attr){

	$currentlang =(empty($_COOKIE['ilang']) ? "persian" : $_COOKIE['ilang'] );
	

	switch ($attr){
		case 'text-align':
			$attrValue = ($currentlang == 'persian') ? "right" : "left" ;
		break;
		case 'align':
			$attrValue = ($currentlang == 'persian') ? "right" : "left" ;
		break;
		case 'font':
			$attrValue = ($currentlang == 'persian') ? "Tahoma" : "arial,sans-serif" ;
		break;
		case 'direction':
			$attrValue = ($currentlang == 'persian') ? "rtl" : "ltr" ;
		break;
	}

	return $attrValue;
}
function USV_INSTALL_LANGUAGE() {
	if (defined('DEF_LANGUAGE') AND DEF_LANGUAGE<>"" ) {
	include(INSTALL_LANGUAGE_PATH."".DEF_LANGUAGE.".php");
	}else {
	include(INSTALL_LANGUAGE_PATH."persian.php");
	}
}
function USV_INSTALL_HEADER() {
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
	echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
	echo "<head>\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";

	if (isset($_POST['step']) && ($_POST['step'] == 1 || $_POST['step'] == 2 || $_POST['step'] == 3 || $_POST['step'] == 4 || $_POST['step'] == 5 || $_POST['step'] == 6 || $_POST['step'] == 7 || $_POST['step'] == 8|| $_POST['step'] == 9)){
		echo "<title>نصب پرتال نیوک لرن</title>\n";
	}
	USV_INSTALL_STYLE();
	echo "</head>\n";
	echo "<body>\n";
	?>
	<div class="head_1"><img
		src="<?php echo INCLUDES_ACP ?>style/images/admin_logo.png" border="0"	></div>
	<div class="head_2" style="margin-bottom: 20px;"><a
		href="./install.php"><img src="images/icon/house.png"></a>
	<a href="install.php?lang=english"><img src="images/language/flag-english.png"></a>
	<a href="install.php?lang=persian"><img src="images/language/flag-persian.png"></a>
	</div>
	<?php		

	if (isset($_POST['step']) && ($_POST['step'] == 1 || $_POST['step'] == 2 || $_POST['step'] == 3 
	|| $_POST['step'] == 4 || $_POST['step'] == 5 || $_POST['step'] == 6 || $_POST['step'] == 7 || $_POST['step'] == 8|| $_POST['step'] == 9)){
		$s = "";
		$r = '<div style="border:1px solid #B4AFB6;background:#F2F2F2 url(includes/acp/style/images/white-grad.png) repeat-x;">';

		if ($_POST['step'] == 1) {
			$r .= "<span style='padding-right:15px;background-color:#92BC00;'></span>" ;
			$s .= STEP_1;
		}

		if ($_POST['step'] == 2) {
			if ($_POST['choice'] != "on"){
				$r .= "<span style='padding-right:100px;background-color:#FF2525;'></span>" ;
				$s .= STEP_1 ;
			}else {
				$r .= "<span style='padding-right:100px;background-color:#92BC00;'></span>" ;
				$s .= STEP_4 ;
			}


		}
		if ($_POST['step'] == 3) {
			$r .= "<span style='padding-right:55px;background-color:#92BC00;'></span>" ;
			$s .= STEP_2 ;
		}
		if ($_POST['step'] == 4) {
			$r .= "<span style='padding-right:55px;background-color:red;'></span>" ;
			$s .= STEP_4;
		}

		if ($_POST['step'] == 5) {
			if (empty($_POST['DB_SERVER']) || empty($_POST['DB_SERVER_USERNAME']) || empty($_POST['DB_SERVER_PASSWORD']) || empty($_POST['DB_DATABASE'])) {
				$r .= "<span style='padding-right:200px;background-color:#FF2525;'></span>" ;
				$s .= STEP_4;
			}else {
				$r .= "<span style='padding-right:200px;background-color:#92BC00;'></span>" ;
				$s .= STEP_5 ;
			}

		}
		if ($_POST['step'] == 6) {
			if (!file_exists("config.php") && !is_writeable("config.php")) {
				$r .= "<span style='padding-right:200px;background-color:#FF2525;'></span>" ;
			} else {
				$r .= "<span style='padding-right:400px;background-color:#92BC00;'></span>" ;
			}

			$s .= STEP_6 ;
		}

		if ($_POST['step'] == 7) {

			if ($_POST['stop'] == 1 || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['pwd'])){
				$r .= "<span style='padding-right:400px;background-color:#FF2525;'></span>" ;
				$s .= STEP_6 ;
			}else {
				$r .= "<span style='padding-right:600px;background-color:#92BC00;'></span>" ;
				$s .= STEP_7 ;
			}
		}

		$r .= "</div>" ;

		echo "<h3 style='text-align:right'>$s</h3>";

		echo $r ;

	}
}
function USV_INSTALL_FOOTER() {
		echo "</body>\n";
	echo "</html>\n";
}
function USV_INSTALL_STYLE() {
	echo "
<style type=\"text/css\">
@import url( \"".INCLUDES_ACP."/style/css/style.css\");
@import url( \"INSTALLATION/style/install.css\");
body, h1, h2, h3, h4, h5, h6, blockquote, p, form, ul, li {
	text-align:".langstyle2('align').";
	direction: ".langstyle2('direction').";
}
</style>

";
}

//Function for replacing line in text file.
//Credit: Iiro Krankka
function replace_file($path, $string, $replace)
{
    set_time_limit(0);

    if (is_file($path) === true)
    {
        $file = fopen($path, 'r');
        $temp = tempnam('./', 'tmp');

        if (is_resource($file) === true)
        {
            while (feof($file) === false)
            {
                file_put_contents($temp, str_replace($string, $replace, fgets($file)), FILE_APPEND);
            }

            fclose($file);
        }

        unlink($path);
    }

    return rename($temp, $path);
}



?>