<?php
/**
*
* @package inc_functions														
* @version $Id: inc_functions.php 1.1.4 						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (stristr(htmlentities($_SERVER['PHP_SELF']), "inc_functions.php")) {
	die("Access Denied<br><b>".$_SERVER['PHP_SELF']."</b>");
}



//===========================================
//Validation / Check
//===========================================

function is_user($user) {
	if (!$user) { return 0; }
	static $userSave;
	if (isset($userSave)) return $userSave;
	if (!is_array($user)) {
		$user = base64_decode($user);
		$user = addslashes($user);
		$user = explode(":", $user);
	}
	$uid = $user[0];
	$pwd = $user[2];
	$uid = intval($uid);
	if (!empty($uid) AND !empty($pwd)) {
		global $db, $user_prefix;
		$sql = "SELECT user_password FROM ".$user_prefix."_users WHERE user_id='$uid' LIMIT 1";
		$result = $db->sql_query($sql);
		list($row) = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ($row == $pwd && !empty($row)) {
			return $userSave = 1;
		}
	}
	return $userSave = 0;
}

function is_group($user, $name) {
	global $prefix, $db, $user_prefix, $cookie, $user;
	if (is_user($user)) {
		if(!is_array($user)) {
			$cookie = cookiedecode($user);
			$uid = intval($cookie[0]);
		} else {
			$uid = intval($user[0]);
		}
		$result = $db->sql_query("SELECT points FROM ".$user_prefix."_users WHERE user_id='$uid'");
		$row = $db->sql_fetchrow($result);
		$points = intval($row['points']);
		$db->sql_freeresult($result);
		$result2 = $db->sql_query("SELECT mod_group FROM ".$prefix."_modules WHERE title='$name'");
		$row2 = $db->sql_fetchrow($result2);
		$mod_group = intval($row2['mod_group']);
		$db->sql_freeresult($result2);
		$result3 = $db->sql_query("SELECT points FROM ".$prefix."_groups WHERE id='$mod_group'");
		$row3 = $db->sql_fetchrow($result3);
		$grp = intval($row3['points']);
		$db->sql_freeresult($result3);
		if (($points >= 0 AND $points >= $grp) OR $mod_group == 0) {
			return 1;
		}
	}
	return 0;
}

function loginbox($gfx_check=false) {
	global $user, $sitekey, $gfx_chk;
	mt_srand ((double)microtime()*1000000);
	$maxran = 1000000;
	$random_num = mt_rand(0, $maxran);
	$datekey = date('F j');
	$rcode = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . $sitekey . $random_num . $datekey));
	$code = substr($rcode, 2, 6);
	if (!is_user($user)) {
		$title = _LOGIN;
		$boxstuff = '<form action="modules.php?name=Your_Account" method="post">';
		$boxstuff .= '<center><font class="content">'._NICKNAME.'<br />';
		$boxstuff .= '<input type="text" name="username" size="8" maxlength="25" /><br />';
		$boxstuff .= _PASSWORD.'<br />';
		$boxstuff .= '<input type="password" name="user_password" size="8" maxlength="20" /><br />';
		$boxstuff .= show_captcha();//show captcha code
		$boxstuff .= '<input type="hidden" name="op" value="login" />';
		$boxstuff .= '<input type="submit" value="'._LOGIN.'" /></font></center></form>';
		$boxstuff .= '<center><font class="content">'._ASREGISTERED.'</font></center>';
		themesidebox($title, $boxstuff);
	}
}

function paid() {
	global $db, $user, $cookie, $adminmail, $sitename, $nukeurl, $subscription_url, $user_prefix, $prefix;
	if (is_user($user)) {
		if (!empty($subscription_url)) {
			$renew = ""._SUBRENEW." $subscription_url";
		} else {
			$renew = "";
		}
		cookiedecode($user);
		$sql = "SELECT * FROM ".$prefix."_subscriptions WHERE userid='$cookie[0]'";
		$result = $db->sql_query($sql);
		$numrows = $db->sql_numrows($result);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		if ($numrows == 0) {
			return 0;
		} elseif ($numrows != 0) {
			$time = time();
			if ($row['subscription_expire'] <= $time) {
				$result = $db->sql_query("DELETE FROM ".$prefix."_subscriptions WHERE userid='$cookie[0]' AND id='".intval($row['id'])."'");
				$db->sql_freeresult($result);
				$from = "$sitename <$adminmail>";
				$subject = "$sitename: "._SUBEXPIRED."";
				$body = ""._HELLO." $cookie[1]:\n\n"._SUBSCRIPTIONAT." $sitename "._HASEXPIRED."\n$renew\n\n"._HOPESERVED."\n\n$sitename "._TEAM."\n$nukeurl";
				$row = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$user_prefix."_users WHERE id='$cookie[0]' AND nickname='$cookie[1]' AND password='$cookie[2]'"));
				mail($row['user_email'], $subject, $body, "From: $from\nX-Mailer: PHP/" . phpversion());
			}
			return 1;
		}
	} else {
		return 0;
	}
}

//Check if the email is valid
function validate_mail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ( !function_exists('version_compare') || version_compare( phpversion(), '5', '<' ) ){
      }else{
      	if ($isValid && !(checkdnsrr($domain,"MX") ||
      	checkdnsrr($domain,"A")))
      	{
      		$isValid = false;
      	}
      }

   }
   return $isValid;
}

function validate($url)
{
$pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
return preg_match($pattern, $url);
}

//Check if the ip if valid [SHOULD BE IMPROOVED]
function validIp($ip) {
	return (eregi("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$",$ip)) ? true : false ;
}

function makePass() {
	$cons = "bcdfghjklmnpqrstvwxyz";
	$vocs = "aeiou";
	for ($x=0; $x < 6; $x++) {
		mt_srand ((double) microtime() * 1000000);
		$con[$x] = substr($cons, mt_rand(0, strlen($cons)-1), 1);
		$voc[$x] = substr($vocs, mt_rand(0, strlen($vocs)-1), 1);
	}
	mt_srand((double)microtime()*1000000);
	$num1 = mt_rand(0, 9);
	$num2 = mt_rand(0, 9);
	$makepass = $con[0] . $voc[0] .$con[2] . $num1 . $num2 . $con[3] . $voc[3] . $con[4];
	return($makepass);
}

function is_active($module) {
	global $prefix, $db;
	static $save;
	if (is_array($save)) {
		if (isset($save[$module])) return ($save[$module]);
		return 0;
	}
	$sql = "SELECT title FROM ".$prefix."_modules WHERE active=1";
	$result = $db->sql_query($sql);
	while ($row = $db->sql_fetchrow($result)) {
		$save[$row[0]] = 1;
	}
	$db->sql_freeresult($result);
	if (isset($save[$module])) return ($save[$module]);
	return 0;
}

function formatAidHeader($aid) {
	$AidHeader = get_author($aid);
	echo $AidHeader;
}

function removecrlf($str) {
	return strtr($str, "\015\012", ' ');
}

function deep_in_array($value,$array,$case_insensitive = false){
	foreach($array as $item){
		if (is_array($item)) {
			$ret = deep_in_array($value,$item,$case_insensitive);
		} else {
			$ret = ($case_insensitive) ? strtolower($item)==$value : $item==$value;
		}
		if ($ret) { return $ret; }
	}
	return false;
}

function validate_field($form,$field,$msg){
	echo "
<script language=\"javascript\"   type=\"text/javascript\">
function validateForm($form)
{
if(\"\"==document.forms.$form.$field.value)
{
alert(\"$msg\");
return false;
}
}
</script>";

}

// get current url 
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}
function CurrentURL(){
    if(!isset($_SERVER['REQUEST_URI'])){
        $serverrequri = $_SERVER['PHP_SELF'];
    }else{
        $serverrequri =    $_SERVER['REQUEST_URI'];
    }
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;   
}


function get_lang($module) {
	global $currentlang, $language;
	if ($module == "admin" AND $module != "Forums") {
		if (file_exists(CORE_INCLUSION."admin/language/lang-".$currentlang.".php")) {
			include_once(CORE_INCLUSION."admin/language/lang-".$currentlang.".php");
		} elseif (file_exists(CORE_INCLUSION."admin/language/lang-".$language.".php")) {
			include_once(CORE_INCLUSION."admin/language/lang-".$language.".php");
		}
	} else {
		if (file_exists(CORE_INCLUSION."modules/$module/language/lang-".$currentlang.".php")) {
			include_once(CORE_INCLUSION."modules/$module/language/lang-".$currentlang.".php");
		} elseif (file_exists(CORE_INCLUSION."modules/$module/language/lang-".$language.".php")) {
			include_once(CORE_INCLUSION."modules/$module/language/lang-".$language.".php");
		}
	}
}
function selectlanguage() {
	global $useflags, $currentlang;
	if ($useflags == 1) {
		$title = _SELECTLANGUAGE;
		$content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br>";
		$langdir = dir("language");
		while($func=$langdir->read()) {
			if(substr($func, 0, 5) == "lang-") {
				$menulist .= "$func ";
			}
		}
		closedir($langdir->handle);
		$menulist = explode(" ", $menulist);
		sort($menulist);
		for ($i=0; $i < sizeof($menulist); $i++) {
			if($menulist[$i]!="") {
				$tl = str_replace("lang-","",$menulist[$i]);
				$tl = str_replace(".php","",$tl);
				$altlang = ucfirst($tl);
				$content .= "<a href=\"index.php?newlang=".$tl."\"><img src=\"images/language/flag-".$tl.".png\" border=\"0\" alt=\"$altlang\" title=\"$altlang\" hspace=\"3\" vspace=\"3\"></a> ";
			}
		}
		$content .= "</font></center>";
		themesidebox($title, $content);
	} else {
		$title = _SELECTLANGUAGE;
		$content = "<center><font class=\"content\">"._SELECTGUILANG."<br><br></font>";
		$content .= "<form action=\"index.php\" method=\"get\"><select name=\"newlanguage\" onChange=\"top.location.href=this.options[this.selectedIndex].value\">";
		$handle=opendir('language');
		$languageslist = "";
		while ($file = readdir($handle)) {
			if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
				$langFound = $matches[1];
				$languageslist .= "$langFound ";
			}
		}
		closedir($handle);
		$languageslist = explode(" ", $languageslist);
		sort($languageslist);
		for ($i=0; $i < sizeof($languageslist); $i++) {
			if($languageslist[$i]!="") {
				$content .= "<option value=\"index.php?newlang=$languageslist[$i]\" ";
				if($languageslist[$i]==$currentlang) $content .= " selected";
				$content .= ">".ucfirst($languageslist[$i])."</option>\n";
			}
		}
		$content .= "</select></form></center>";
		themesidebox($title, $content);
	}
}
//CONSTANT DEFINITION
define("_IOP","<div id='bd'  class=\"error\"><p class=\"error\"><img src='images/icon/exclamation.png' title='Attention' alt='Attention'>Illegal Operation:</b> Query not allowed.</p><div>");

//===========================================
//Theme Functions
//===========================================
function themepreview($title, $hometext, $newspicture="", $newspicturetext="", $bodytext="", $newsrefrence="",$newsrefrencelink="", $notes="") {
	global $module_name;
	echo "<b>$title</b><br><br>$hometext";
	if (!empty($newspicture)) {
		echo "<br><br><center><img src=\"modules/$module_name/NewsPictures/$newspicture\" alt=\"$newspicturetext\" title=\"$newspicturetext\"/></center>";
	}
	if (!empty($bodytext)) {
		echo "<br><br>$bodytext";
	}
	if (!empty($newsrefrence)) {
		if (!empty($newsrefrencelink))
		echo "<br/><br/><b>"._REFRENCENEW."</b>&nbsp;<a href=\"$newsrefrencelink\" target=\"_blank\">$newsrefrence</a>";
		else
		echo "$newsrefrence";
	}
	if (!empty($notes)) {
		echo "<br><br><b>"._NOTE."</b> <i>$notes</i>";
	}
}
function userblock() {
	global $user, $cookie, $db, $user_prefix, $userinfo;
	if(is_user($user)) {
		getusrinfo($user);
		if($userinfo['ublockon']) {
			$sql = "SELECT ublock FROM ".$user_prefix."_users WHERE user_id='$cookie[0]'";
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrow($result);
			$ublock = stripslashes(check_words(check_html($row['ublock'], "")));
			$title = _MENUFOR." ".$cookie[1];
			themesidebox($title, $ublock);
		}
	}
}
function adminblock() {
	global $admin, $prefix, $db, $admin_file;
	themesidebox($title, $content);
}
function render_blocks($side, $blockfile, $title, $content, $bid, $url) {
	if(!defined('BLOCK_FILE')) {
		define('BLOCK_FILE', true);
	}
	if (empty($url)) {
		if (empty($blockfile)) {
			global $nextGenBlock;
			if ($nextGenBlock == 1) {
				$content = nextGenTap(0, 0, $content);
			}
			if ($side == "c") {
				themecenterbox($title,$content,$bid,$blockfile);
			} elseif ($side == "d") {
				themecenterbox($title, $content,$bid,$blockfile);
			} else {
				themesidebox($title,$content,$side,$bid,$blockfile);
			}
		} else {
			if ($side == "c") {
				blockfileinc($title, $blockfile, 1);
			} elseif ($side == "d") {
				blockfileinc($title, $blockfile, 1);
			} else {
				blockfileinc($title, $blockfile,$side);
			}
		}
	} else {
		if ($side == "c" OR $side == "d") {
			headlines($bid,1);
		} else {
			headlines($bid);
		}
	}
}
function blocks($side) {
	global $storynum, $prefix, $multilingual, $currentlang, $db, $admin, $user;
	if ($multilingual == 1) {
		$querylang = "AND (blanguage='$currentlang' OR blanguage='')";
	} else {
		$querylang = "";
	}
	if (strtolower($side[0]) == "l") {
		$pos = "l";
	} elseif (strtolower($side[0]) == "r") {
		$pos = "r";
	}  elseif (strtolower($side[0]) == "c") {
		$pos = "c";
	} elseif  (strtolower($side[0]) == "d") {
		$pos = "d";
	}
	$side = $pos;
	$sql = "SELECT bid, bkey, title, content, url, blockfile, view, expire, action, subscription FROM ".$prefix."_blocks WHERE bposition='$pos' AND active='1' $querylang ORDER BY weight ASC";
	$result = $db->sql_query($sql);
	while($row = $db->sql_fetchrow($result)) {
		$bid = intval($row['bid']);
		$title = stripslashes(check_html(langit($row['title']), "nohtml"));
		$content = stripslashes($row['content']);
		$url = check_html($row['url'], "nohtml");
		$blockfile = check_html($row['blockfile'], "nohtml");
		$view = intval($row['view']);
		$expire = intval($row['expire']);
		$action = check_html($row['action'], "nohtml");
		$action = substr($action, 0,1);
		$now = time();
		$sub = intval($row['subscription']);
		if ($sub == 0 OR ($sub == 1 AND !paid())) {
			if ($expire != 0 AND $expire <= $now) {
				if ($action == "d") {
					$db->sql_query("UPDATE ".$prefix."_blocks SET active='0', expire='0' WHERE bid='$bid'");
					return;
				} elseif ($action == "r") {
					$db->sql_query("DELETE FROM ".$prefix."_blocks WHERE bid='$bid'");
					return;
				}
			}
			if ($row['bkey'] == "admin") {
				adminblock();
			} elseif ($row['bkey'] == "userbox") {
				userblock();
			} elseif (empty($row['bkey'])) {
				if ($view == 0) {
					render_blocks($side, $blockfile, $title, $content, $bid, $url);
				} elseif ($view == 1 AND is_user($user) || is_admin($admin)) {
					render_blocks($side, $blockfile, $title, $content, $bid, $url);
				} elseif ($view == 2 AND is_admin($admin)) {
					render_blocks($side, $blockfile, $title, $content, $bid, $url);
				} elseif ($view == 3 AND !is_user($user) || is_admin($admin)) {
					render_blocks($side, $blockfile, $title, $content, $bid, $url);
				}
			}
		}
	}
	$db->sql_freeresult($result);
}
function blockfileinc($title,$blockfile,$side) {
	if(!defined('BLOCK_FILE')) {
		define('BLOCK_FILE', true);
	}
	$blockfiletitle = langit($title);
	$file = file_exists("blocks/".$blockfile."");
	if (!$file) {
		$content = _BLOCKPROBLEM;
	} else {
		include("blocks/".$blockfile."");
	}
	if (empty($content)) {
		$content = _BLOCKPROBLEM2;
	}
	
	global $nextGenBlock;
	if ($nextGenBlock == 1) {
		$content = nextGenTap(0, 0, $content);
	}
	
	if ($side=="NULL") {
		return $content;
	}	elseif ($side == 1) {
		$blcstart = benchGetTime();
		themecenterbox($blockfiletitle, $content,'',$blockfile);
		$blcend = benchGetTime();
		if (BENCHMARK==true) {
			echo benchmark_overall($blcstart,$blcend,$blockfiletitle);
		}
	} elseif ($side == 2) {
		$blcstart = benchGetTime();
		themecenterbox($blockfiletitle, $content,'',$blockfile);
		$blcend = benchGetTime();
		if (BENCHMARK==true) {
			echo benchmark_overall($blcstart,$blcend,$blockfiletitle);
		}
	} else {
		$blstart = benchGetTime();
		themesidebox($blockfiletitle,$content,$side,'',$blockfile);
		$blend = benchGetTime();
		if (BENCHMARK==true) {
			echo benchmark_overall($blstart,$blend,$blockfiletitle);
		}
	}
		
	
}

function get_theme() {
	global $user,$ThemeDef,$userinfo, $Default_Theme, $name, $op;
	//if (isset($ThemeSelSave)) return $ThemeSelSave;

	///------------- IF You Are a user So :
	

	if (is_user($user)) {

			if(file_exists("themes/".$userinfo['theme']."/theme.php") OR  file_exists("themes/".$userinfo['theme']."/table.inc") )
			{
				$ThemeSel = $userinfo['theme'];
			}
			elseif(file_exists("themes/".$Default_Theme."/theme.php") || file_exists("themes/".$Default_Theme."/table.inc")) {
				$ThemeSel = $Default_Theme;
			}else {
				$ThemeSel = $ThemeDef ;
			}
	///----------- IF You Are NOT a USER :
	}else{

		if(file_exists("themes/".$Default_Theme."/theme.php") || file_exists("themes/".$Default_Theme."/table.inc")) {
			$ThemeSel = $Default_Theme;
		}
		else {
				$ThemeSel = $ThemeDef ;
		}
	}
		
	
	static $ThemeSelSave;
	$ThemeSelSave = $ThemeSel;
	return $ThemeSelSave;
}
function show_mod($name){
	$name = sql_quote($name);
	global $pagetitle;
    $pagetitle = "$pagetitle";
	if (!empty($name)) {
		require_once(CORE_INCLUSION."includes/mods/$name/index.php");
	}else {
		show_error(_MOD_IS_EMPTY);
	}
}
function langstyle($attr){
	global $ultramode,$currentlang;
	if ($ultramode==0 AND $currentlang<>"english" ) {
		$currentlang ="persian";
	}
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
function TableRow($cnt,$even,$odd) { 
return ($cnt%2) ? "class=\"$odd\"" : "class=\"$even\""; 
} 
function langit($value){
	//global $currentlang;
	//require_once("language/lang-$currentlang.php");
	if (defined($value)) {
		return constant(''.strtoupper($value).'');
	}else {
		return $value;
	}
}

//===========================================
// Story Functions
//===========================================

function StoryInfo($value) {
	global  $db , $storyinfo;
	$value = sql_quote(intval($value));
	if (!$value OR empty($value)) {
		return NULL;
	}

	$sql = "SELECT * FROM ".STORY_TABLE." WHERE sid='$value'";
	$result = $db->sql_query($sql);
	if ($db->sql_numrows($result) == 1) {
		static $storyrow;
		$storyrow = $db->sql_fetchrow($result);
		return $storyinfo = $storyrow;
	}
	$db->sql_freeresult($result);
	unset($storyinfo);
}

function title($text) {
	if (function_exists("OpenTable")) {OpenTable();}
	echo "<center><span class=\"title\"><strong>$text</strong></span></center>";
	if (function_exists("CloseTable")) {CloseTable();}
	echo "<br>";
}

function message_box() {
	global $bgcolor1, $bgcolor2, $user, $admin, $cookie, $textcolor2, $prefix, $multilingual, $currentlang, $db, $admin_file;
	if (isset($multilingual) && $multilingual == 1) {
		$querylang = "AND (alanguage='$currentlang' OR alanguage='')";
	} else {
		$querylang = "";
	}
	if (!empty($querylang))
	{
		$result = $db->sql_query("SELECT * FROM ".$prefix."_stories WHERE section='message' $querylang");
	}
	else
	{
		$result = $db->sql_query("SELECT * FROM ".$prefix."_stories WHERE section='message'");
	}
	if ($numrows = $db->sql_numrows($result) == 0) {
		return;
	} else {
		while ($row = $db->sql_fetchrow($result)) {
			$sid = intval($row['sid']);
			$title = stripslashes(check_html($row['title'], "nohtml"));
			$content = stripslashes($row['hometext']);
			$mdate = $row['time'];
			//$expire = intval($row['expire']);
			$view = intval($row['counter']);
			/*if (!empty($title) && !empty($content)) {
			if ($expire == 0) {
			$remain = _UNLIMITED;
			} else {
			$etime = (($mdate+$expire)-time())/3600;
			$etime = (int)$etime;
			if ($etime < 1) {
			$remain = _EXPIRELESSHOUR;
			} else {
			$remain = ""._EXPIREIN." $etime "._HOURS."";
			}
			}
			*/
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>";
			if (is_admin($admin)) {
				echo "<br><br><center><font class=\"content\">[ "._MVIEWALL." - $remain - <a href=\"".$admin_file.".php?op=EditStory&sid=$sid\">"._EDIT."</a> ]</font></center>";
			}
			CloseTable();

			/*

			if ($view == 5 AND paid()) {
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>";
			if (is_admin($admin)) {
			echo "<br><br><center><font class=\"content\">[ "._MVIEWSUBUSERS." - $remain - <a href=\"".$admin_file.".php?op=editmsg&amp;mid=$mid\">"._EDIT."</a> ]</font></center>";
			}
			CloseTable();
			echo "<br>";
			} elseif ($view == 4 AND is_admin($admin)) {
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>"
			."<br><br><center><font class=\"content\">[ "._MVIEWADMIN." - $remain - <a href=\"".$admin_file.".php?op=editmsg&amp;mid=$mid\">"._EDIT."</a> ]</font></center>";
			CloseTable();
			echo "<br>";
			} elseif ($view == 3 AND is_user($user) || is_admin($admin)) {
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>";
			if (is_admin($admin)) {
			echo "<br><br><center><font class=\"content\">[ "._MVIEWUSERS." - $remain - <a href=\"".$admin_file.".php?op=editmsg&amp;mid=$mid\">"._EDIT."</a> ]</font></center>";
			}
			CloseTable();
			echo "<br>";
			} elseif ($view == 2 AND !is_user($user) || is_admin($admin)) {
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>";
			if (is_admin($admin)) {
			echo "<br><br><center><font class=\"content\">[ "._MVIEWANON." - $remain - <a href=\"".$admin_file.".php?op=editmsg&amp;mid=$mid\">"._EDIT."</a> ]</font></center>";
			}
			CloseTable();
			echo "<br>";
			} elseif ($view == 1) {
			OpenTable();
			echo "<center><font class=\"option\" color=\"$textcolor2\"><b>$title</b></font></center><br>\n"
			."<font class=\"content\">$content</font>";
			if (is_admin($admin)) {
			echo "<br><br><center><font class=\"content\">[ "._MVIEWALL." - $remain - <a href=\"".$admin_file.".php?op=editmsg&amp;mid=$mid\">"._EDIT."</a> ]</font></center>";
			}
			CloseTable();
			echo "<br>";
			}
			if ($expire != 0) {
			$past = time()-$expire;
			if (isset($mid) && !empty($mid) && $mdate < $past) {
			$db->sql_query("UPDATE ".$prefix."_message SET active='0' WHERE mid='$mid'");
			}
			}
			}*/
		}
	}
}

function public_message() {
	global $prefix,$db, $user,$broadcast_msg;

	$ndate = date("Y-m-j H:i:s");
	
	//delete messages where they are old more that 1 minute.
	//debug : 
	//die("DELETE FROM ".$prefix."_public_messages  WHERE date < '$ndate'");
	$db->sql_query("DELETE FROM ".$prefix."_public_messages  WHERE date < '$ndate'");	
	
	if (is_user($user)) {	
		if ($broadcast_msg == 1) {
			cookiedecode($user);
				$t_off = "<br><p align=\"right\">[ <a href=\"modules.php?name=Your_Account&amp;op=edithome\">";
				$t_off .= "<font size=\"2\">"._TURNOFFMSG."</font></a> ]";
				$pm_show = 1;
			} else {
				$pm_show = 0;
			}
		} else {
			$pm_show = 0;
			$t_off = "";
		}
		
		// lets show the public_message
		$public_msg = "";
		if ($pm_show == 1) {
			$result2 = $db->sql_query("SELECT mid, content, date, who FROM ".$prefix."_public_messages ORDER BY date ASC LIMIT 1");
			$row2 = $db->sql_fetchrow($result2);
			$mid = intval($row2['mid']);
			$content = check_html($row2['content'], "nohtml");
			$tdate = $row2['date'];
			$who = check_html($row2['who'], "nohtml");
			if (!empty($mid)) {
				$public_msg .= "<div id='notify' >
				<b>"._BROADCASTFROM."<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$who\">$who</a></b> : \"$content\"";
				$public_msg .= "$t_off
				</div>";
			}
		}
	
	return $public_msg;
}

function getTopics($sid) {
	global $topicid, $topicimage,$nextg,$topicname, $topictext, $prefix, $db;

		$result = $db->sql_query("SELECT t.topicid, t.topicname, t.topicimage, t.topictext,s.associated FROM ".$prefix."_stories s LEFT JOIN ".$prefix."_topics t ON t.topicid = s.topic WHERE s.sid = '$sid'");
		list($topicid,$topicname,$topicimage,$topictext,$associated) = $db->sql_fetchrow();

		$asso_t = explode("-",$associated);

		if (!empty($associated)) {
			for ($i=0; $i<sizeof($asso_t); $i++)
			{
				if (!empty($asso_t[$i])) {
					$query = $db->sql_query("SELECT topicid,topicname,slug from ".$prefix."_topics WHERE topicid='".$asso_t[$i]."'");
					list($topicids,$topicnames,$slug) = $db->sql_fetchrow($query);
					$cat_LINK = ($nextg==1) ? 'category/' : 'modules.php?name=News&amp;file=categories&amp;category=' ;
					$topicname .="<a href='".$cat_LINK.$slug."'>$topicnames</a>,";
					$topicid   .="$topicids,";
					$db->sql_freeresult($query);
				}
			}
		}
		
		$db->sql_freeresult($result);

}

function headlines($bid, $cenbox=0) {
	global $prefix, $db;
	$bid = intval($bid);
	$result = $db->sql_query("SELECT title, content, url, refresh, time FROM ".$prefix."_blocks WHERE bid='$bid'");
	$row = $db->sql_fetchrow($result);
	$title = stripslashes(check_html($row['title'], "nohtml"));
	$content = stripslashes(check_html($row['content'], ""));
	$url = check_html($row['url'], "nohtml");
	$refresh = intval($row['refresh']);
	$otime = $row['time'];
	$past = time()-$refresh;
	$cont = 0;
	if ($otime < $past) {
		$btime = time();
		$rdf = parse_url($url);
		$fp = fsockopen($rdf['host'], 80, $errno, $errstr, 15);
		if (!$fp) {
			$content = "";
			$db->sql_query("UPDATE ".$prefix."_blocks SET content='$content', time='$btime' WHERE bid='$bid'");
			$cont = 0;
			if ($cenbox == 0) {
				themesidebox($title, $content);
			} else {
				themecenterbox($title, $content);
			}
			return;
		}
		if ($fp) {
			if (!empty($rdf['query']))
			$rdf['query'] = "?" . $rdf['query'];

			fputs($fp, "GET " . $rdf['path'] . $rdf['query'] . " HTTP/1.0\r\n");
			fputs($fp, "HOST: " . $rdf['host'] . "\r\n\r\n");
			$string	= "";
			while(!feof($fp)) {
				$pagetext = fgets($fp,300);
				$string .= chop($pagetext);
			}
			fputs($fp,"Connection: close\r\n\r\n");
			fclose($fp);
			$items = explode("</item>",$string);
			$content = "<font class=\"content\">";
			for ($i=0;$i<10;$i++) {
				$link = str_replace(".*<link>","",$items[$i]);
				$link = str_replace("</link>.*","",$link);
				$title2 = str_replace(".*<title>","",$items[$i]);
				$title2 = str_replace("</title>.*","",$title2);
				$title2 = stripslashes($title2);
				if (empty($items[$i]) AND $cont != 1) {
					$content = "";
					$db->sql_query("UPDATE ".$prefix."_blocks SET content='$content', time='$btime' WHERE bid='$bid'");
					$cont = 0;
					if ($cenbox == 0) {
						themesidebox($title, $content);
					} else {
						themecenterbox($title, $content);
					}
					return;
				} else {
					if (strcmp($link,$title2) AND !empty($items[$i])) {
						$cont = 1;
						$content .= "<strong><big>&middot;</big></strong><a href=\"$link\" target=\"new\">$title2</a><br>\n";
					}
				}
			}

		}
		$db->sql_query("UPDATE ".$prefix."_blocks SET content='$content', time='$btime' WHERE bid='$bid'");
	}
	$siteurl = str_replace("http://","",$url);
	$siteurl = explode("/",$siteurl);
	if (($cont == 1) OR (!empty($content))) {
		$content .= "<br><a href=\"http://$siteurl[0]\" target=\"blank\"><b>"._HREADMORE."</b></a></font>";
	} elseif (($cont == 0) OR (empty($content))) {
		$content = "<font class=\"content\">"._RSSPROBLEM."</font>";
	}
	if ($cenbox == 0) {
		themesidebox($title,$content,$side,$bid,$blockfile);
	} else {
		themecenterbox($title, $content);
	}
}

function automated_news() {
	global $prefix, $multilingual, $currentlang, $db;
	if ($multilingual == 1) {
		$querylang = "WHERE (alanguage='$currentlang' OR alanguage='')";
	} else {
		$querylang = "";
	}
	$today = getdate();
	$day = $today['mday'];
	if ($day < 10) {
		$day = "0$day";
	}
	$month = $today['mon'];
	if ($month < 10) {
		$month = "0$month";
	}
	$year = $today['year'];
	$hour = $today['hours'];
	$min = $today['minutes'];
	$sec = "00";
	$result = $db->sql_query("SELECT anid, time FROM ".$prefix."_autonews $querylang");
	while ($row = $db->sql_fetchrow($result)) {
		$anid = intval($row['anid']);
		$time = $row['time'];
		ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $date);
		if (($date[1] <= $year) AND ($date[2] <= $month) AND ($date[3] <= $day)) {
			if (($date[4] < $hour) AND ($date[5] >= $min) OR ($date[4] <= $hour) AND ($date[5] <= $min)) {
				$result2 = $db->sql_query("SELECT * FROM ".$prefix."_autonews WHERE anid='$anid'");
				while ($row2 = $db->sql_fetchrow($result2)) {
					$title = addslashes(check_words(check_html($row2['title'], "nohtml")));
					$hometext = addslashes(check_words(check_html($row2['hometext'], "")));
					$bodytext = addslashes(check_words(check_html($row2['bodytext'], "")));
					$notes = check_html($row2['notes'], "");
					$catid2 = intval($row2['catid']);
					$aid2 = check_html($row2['aid'], "nohtml");
					$time2 = $row2['time'];
					$topic2 = intval($row2['topic']);
					$informant2 = check_html($row2['informant'], "nohtml");
					$ihome2 = intval($row2['ihome']);
					$alanguage2 = $row2['alanguage'];
					$acomm2 = intval($row2['acomm']);
					$associated2 = $row2['associated'];
					$num = $db->sql_numrows($db->sql_query("SELECT sid FROM ".$prefix."_stories WHERE title='$title'"));
					if ($num == 0) {
						$db->sql_query("DELETE FROM ".$prefix."_autonews WHERE anid='$anid'");
						$db->sql_query("INSERT INTO ".$prefix."_stories VALUES (NULL, '$catid2', '$aid2', '$title', '$time2', '$hometext', '$bodytext', '0', '0', '$topic2', '$informant2', '$notes', '$ihome2', '$alanguage2', '$acomm2', '0', '0', '0', '0', '0', '$associated2')");
					}
				}
				$db->sql_freeresult($result2);
			}
		}
	}
	$db->sql_freeresult($result);
}

function ads($position) {
	global $prefix, $db, $admin, $sitename, $adminmail, $nukeurl;
	$position = intval($position);
	if (paid()) {
		return;
	}	
	$sql = "SELECT * FROM ".$prefix."_banner WHERE position='$position' AND active='1' ORDER BY RAND() LIMIT 1";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$bid = intval($row['bid']);
	$imageurl = check_html($row['imageurl'], "nohtml");
	$clickurl = check_html($row['clickurl'], "nohtml");
	$alttext = check_html($row['alttext'], "nohtml");
	if($result) {
		$cid = intval($row['cid']);
		$imptotal = intval($row['imptotal']);
		$impmade = intval($row['impmade']);
		$clicks = intval($row['clicks']);
		$date = $row['date'];
		$ad_class = check_html($row['ad_class'], "nohtml");
		$ad_code = check_html($row['ad_code'], "nohtml");
		$ad_width = intval($row['ad_width']);
		$ad_height = intval($row['ad_height']);
		/* Check if this impression is the last one and print the banner */
		if (($imptotal <= $impmade) AND ($imptotal != 0)) {
			$db->sql_query("UPDATE ".$prefix."_banner SET active='0' WHERE bid='$bid'");
			$sql3 = "SELECT name, contact, email FROM ".$prefix."_banner_clients WHERE cid='$cid'";
			$result3 = $db->sql_query($sql3);
			$row3 = $db->sql_fetchrow($result3);
			$c_name = check_html($row3['name'], "nohtml");
			$c_contact = check_html($row3['contact'], "nohtml");
			$c_email = check_html($row3['email'], "nohtml");
			if (!empty($c_email)) {
				$from = "$sitename <$adminmail>";
				$to = "$c_contact <$c_email>";
				$message = _HELLO." $c_contact:\n\n";
				$message .= _THISISAUTOMATED."\n\n";
				$message .= _THERESULTS."\n\n";
				$message .= _TOTALIMPRESSIONS." $imptotal\n";
				$message .= _CLICKSRECEIVED." $clicks\n";
				$message .= _IMAGEURL." $imageurl\n";
				$message .= _CLICKURL." $clickurl\n";
				$message .= _ALTERNATETEXT." $alttext\n\n";
				$message .= _HOPEYOULIKED."\n\n";
				$message .= _THANKSUPPORT."\n\n";
				$message .= "- $sitename "._TEAM."\n";
				$message .= "$nukeurl";
				$subject = "$sitename: "._BANNERSFINNISHED."";
				$mailcommand = @mail($to, $subject, $message, "From: $from\nContent-Type: text/html; charset=utf-8");
				$mailcommand = removecrlf($mailcommand);
			}
		}
		if ($ad_class == "code") {
			$ad_code = stripslashes(FixQuotes($ad_code));
			$ads = "$ad_code";
		} elseif ($ad_class == "flash") {
			$ads = "
				<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"
				codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0\"
				WIDTH=\"$ad_width\" HEIGHT=\"$ad_height\" id=\"$bid\">
				<PARAM NAME=movie VALUE=\"$imageurl\">
				<PARAM NAME=quality VALUE=high>
				<EMBED src=\"$imageurl\" quality=high WIDTH=\"$ad_width\" HEIGHT=\"$ad_height\"
				NAME=\"$bid\" ALIGN=\"\" TYPE=\"application/x-shockwave-flash\"
				PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\">
				</EMBED>
				</OBJECT>
				";
		} else {
			$ads = "<a href=\"index.php?op=ad_click&amp;bid=$bid\" target=\"_blank\" title=\"$alttext\"><img src=\"$imageurl\" border=\"0\" alt=\"$alttext\" title=\"$alttext\"></a>";
		}

		$db->sql_query("UPDATE ".$prefix."_banner SET impmade=impmade+1 WHERE bid='$bid'");
		
	} else {
		$ads = "";
	}
	return $ads;
}

function make_pagination($pmode,$totalnum, $ppage='5', $cpage='1',$eachsidenum='3', $link,$econd=''){
	
	///--- pmode : change to mode to view different pagination type 1-10.
	///--- $totalnum : total pages we have in our pagination
	///--- ppage : pages per page , shows the number of links in our pagintaion
	///--- cpage : specifies the current page to highlight the current page to the user
	///--- eachsidenum : how many links should be in each side of the current page
	//---- link: what's the link for a page in the pagintion
	///--- econd : is there any more we haven't thought of yet ?
	
	//$pagination_content ="<span dir='ltr'>$pmode,$totalnum,$ppage,$cpage,$eachsidenum,$link,$econd</span>";
	$pagination_content ="";
			
	$totalp = ceil($totalnum / $ppage);
	$getpage  = (strpos($link, "?") === false) ? "?pagenum" : "&amp;pagenum";
	$lpage = $cpage-$eachsidenum;
	$upper =$cpage+$eachsidenum;
	
	if ($totalp > 1) {

	
	//NO LINK has been provided ???!! ok we do it on our own
	if (empty($link)) {
			if ($pmode==5) {
				$link = "modules.php?name=News&file=categories&amp;category=$econd&pagenum";
			}elseif ($pmode==6){
				$link = "modules.php?name=News&file=tags&amp;tag=$econd&pagenum";
			}elseif ($pmode==7){
				$link = "modules.php?name=News&file=article&sid=$econd&pagenum";
			}else {
				$link ="modules.php?name=News&new_topic=$new_topic&pagenum";
			}
	}
	
	
		$pagination_content .= "<center><div style=\"text-align: center;\">";

		if ($pmode==2 or $pmode==3 ){

			$prevpage = $cpage - 1 ;
			$leftarrow = "images/right.gif" ;
			if(isset($new_topic)) {
				$pagination_content .= "<a href=\"$link=$prevpage\">";
				$pagination_content .= "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			} else {
				$pagination_content .= "<a href=\"$link=$prevpage\">";
				$pagination_content .= "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			}
		}

		if ($pmode==1 or $pmode==3 ){
			$pagination_content .= "<select name='$i' onChange='top.location.href=this.options[this.selectedIndex].value'> ";
			for ($i=1; $i < $totalp+1; $i++) {
				if ($i > $min){
					if(isset($new_topic)) {
						$pagination_content .= "<option value=\"$link=$i\">$i</option>";
					} else {
						$pagination_content .= "<option value=\"$link=$i\">$i</option>";
					}
				}
			}
			$pagination_content .= "</select>" ;
		}


		if ($pmode==2 or $pmode==3){
			if ($cpage < $totalp) {
				$nextpage = $cpage + 1 ;
				$rightarrow = "images/left.gif" ;
				if(isset($new_topic)) {
					$pagination_content .= "<a href=\"$link=$nextpage\">";
					$pagination_content .= "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				} else {
					$pagination_content .= "<a href=\"$link=$nextpage\">";
					$pagination_content .= "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				}
			}
		}

		if ($pmode==4 OR $pmode==5  OR $pmode==6 OR $pmode==7 OR $pmode==10  ){
			$prevpage = $cpage - 1 ;
			$nextpage = $cpage + 1 ;


			$pagination_content .= "<div id='pagination-digg' >";
			if ($prevpage ==0 ) {
				$pagination_content .= '<a class="off">'._PREV_PAGE.'</a>';
			}else {
				$pagination_content .= "<a href=\"$link=$prevpage\">"._NEXT_PAGE."</a>";
			}


			if ($totalp < 7 + ($eachsidenum * 2))	//not enough pages to bother breaking it up
			{
				for ($counter = 1; $counter <= $totalp; $counter++)
				{
					if ($counter == $cpage)
					$pagination_content .= "<a href=\"$link=$counter\" class=\"active\" title='"._C_PAGE."'>&nbsp;$counter&nbsp;</a>";
					else
					$pagination_content .= "<a href=\"$link=$counter\"  >&nbsp;$counter&nbsp;</a>";
				}

			}
			elseif($totalp > 5 + ($eachsidenum * 2))	//enough pages to hide some
			{			if($cpage < 1 + ($eachsidenum * 2))
			{
				for ($counter = 1; $counter < 4 + ($eachsidenum * 2); $counter++)
				{
					if ($counter == $cpage)
					$pagination_content .= "<a href=\"$link=$counter\" class=\"active\" title='"._C_PAGE."'>&nbsp;$counter&nbsp;</a>";
					else
					$pagination_content .= "<a href=\"$link=$counter\">&nbsp;$counter&nbsp;</a>";
				}
				$pagination_content .= "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				$pagination_content .= "<a href=\"$link=$lpm1\"  >&nbsp;$lpm1&nbsp;</a>";
				$pagination_content .= "<a href=\"$link=$totalp\" >&nbsp;$totalp&nbsp;</a>";
			}
			elseif($totalp - ($eachsidenum * 2) > $cpage && $cpage > ($eachsidenum * 2))
			{
				$pagination_content .= "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
				$pagination_content .= "<a href=\"$link=2\"  >&nbsp;2&nbsp;</a>";
				$pagination_content .= "&nbsp; <a href=\"\">&nbsp; ... &nbsp;</a>&nbsp;";
				for ($counter = $cpage - $eachsidenum; $counter <= $cpage + $eachsidenum; $counter++)
				{
					if ($counter == $cpage)
					$pagination_content .= "<a href=\"$link=$counter\" class=\"active\" title='"._C_PAGE."'>&nbsp;$counter&nbsp;</a>";
					else
					$pagination_content .= "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
				}
				$pagination_content .= "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				$pagination_content .= "<a href=\"$link=$lpm1\" >&nbsp;$lpm1&nbsp;</a>";
				$pagination_content .= "<a href=\"$link=$totalp\" >&nbsp;$totalp&nbsp;</a>";
			}
			//close to end; only hide early pages
			else
			{
				$pagination_content .= "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
				$pagination_content .= "<a href=\"$link=2\" >&nbsp;2&nbsp;</a>";
				$pagination_content .= "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				for ($counter = $totalp - (2 + ($eachsidenum * 2)); $counter <= $totalp; $counter++)
				{
					if ($counter == $cpage)
					$pagination_content .= "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
					else
					$pagination_content .= "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
				}
			}
			}

			if ($nextpage > $totalp ) {
				$pagination_content .= '<a class="off">'._NEXT_PAGE.'</a>';
			}else {
				$pagination_content .= "<a href=\"$link=$nextpage\">"._NEXT_PAGE."</a>";
			}
			$pagination_content .= "</div>";
		}
		$pagination_content .= "<br>"._TOTALPAGE." $totalnum ($totalp "._PAGES." | "._PERPAGE." $ppage)";
		$pagination_content .= "</div></center>";


	}
	//$pagination_content ='بدون صفحه بندی';
	return $pagination_content;
}


//===========================================
//SECURITY Check
//===========================================
// This block of code makes sure $admin and $user are COOKIES
if((isset($admin) && $admin != $_COOKIE['admin']) OR (isset($user) && $user != $_COOKIE['user'])) {
	die(_IOP);
}
if(isset($admin) && $admin == $_COOKIE['admin'])
{
	$admin = base64_decode($admin);
	$admin = addslashes($admin);
	$admin = base64_encode($admin);
}
if(isset($user) && $user == $_COOKIE['user'])
{
	$user = base64_decode($user);
	$user = addslashes($user);
	$user = base64_encode($user);
}

// Die message for not allowed HTML tags
$htmltags = "<center><img src=\"images/logo.gif\"><br><br><b>";
$htmltags .= "The html tags you attempted to use are not allowed</b><br><br>";
$htmltags .= "[ <a href=\"javascript:history.go(-1)\"><b>Go Back</b></a> ]</center>";

//Check if the IP is in the range
function ipInRange($ip,$rangefrom,$rangeto) {
	$ip = explode(".",$ip);
	$rangefrom = explode(".",$rangefrom);
	$rangeto = explode(".",$rangeto);
	if (($ip[0]>=$rangefrom[0] AND $ip[0]<=$rangeto[0]) AND
	($ip[1]>=$rangefrom[1] AND $ip[1]<=$rangeto[1]) AND
	($ip[2]>=$rangefrom[2] AND $ip[2]<=$rangeto[2]) AND
	($ip[3]>=$rangefrom[3] AND $ip[3]<=$rangeto[3])) {
		return true;
	} else {
		return false;
	}
}
if (!defined('ADMIN_FILE')) {
	$postString = '';
	foreach ($_POST as $postkey => $postvalue) {
		if ($postString > '') {
			$postString .= '&'.$postkey.'='.$postvalue;
		} else {
			$postString .= $postkey.'='.$postvalue;
		}
	}
	str_replace('%09', '%20', $postString);
	$postString_64 = base64_decode($postString);
	if ((!isset($admin) OR (isset($admin) AND !is_admin($admin))) AND (stristr($postString,'%20union%20') OR stristr($postString,'*/union/*') OR      stristr($postString,' union ') OR stristr($postString_64,'%20union%20') OR stristr($postString_64,'*/union/*') OR stristr($postString_64,' union ') OR stristr($postString_64,'+union+') OR stristr($postString,'http-equiv') OR stristr($postString_64,'http-equiv') OR stristr($postString,'alert(') OR stristr($postString_64,'alert(') OR stristr($postString,'javascript:') OR stristr($postString_64,'javascript:') OR stristr($postString,'document.cookie') OR stristr($postString_64,'document.cookie') OR stristr($postString,'onmouseover=') OR stristr($postString_64,'onmouseover=') OR stristr($postString,'document.location') OR stristr($postString_64,'document.location'))) {
		header('Location: index.php');
		die(_IOP);
	}
}


//===========================================
// Persianized Functions
//===========================================

//(Farsi Mail Functions)
function FarsiMail($msg){
	return $msg;
}
function HtmlMail($_to_address,$_to_name,$_from_address,$_from_name,$_subject,$_message){
	define("MAIL_CLASS",1); // ENABLING EMAIL SYSTEM TO RUN EMAIL CLASS 
		require_once(INCLUDES_PATH."inc_messenger.php");
		$email_message= new email_message_class;

	$from_address="$_from_address";
	$from_name="$_from_name";

	$reply_name=$from_name;
	$reply_address=$from_address;
	$reply_address=$from_address;
	$error_delivery_name=$from_name;
	$error_delivery_address=$from_address;

	$to_name="$_to_name";
	$to_address="$_to_address";

	$subject="$_subject";

	$email_message->SetEncodedEmailHeader("To",$to_address,$to_name);
	$email_message->SetEncodedEmailHeader("From",$from_address,$from_name);
	$email_message->SetEncodedEmailHeader("Reply-To",$reply_address,$reply_name);
	$email_message->SetHeader("Sender",$from_address);

/*
 *  Set the Return-Path header to define the envelope sender address to which bounced messages are delivered.
 *  If you are using Windows, you need to use the smtp_message_class to set the return-path address.
 */
	if(defined("PHP_OS")
	&& strcmp(substr(PHP_OS,0,3),"WIN"))
		$email_message->SetHeader("Return-Path",$error_delivery_address);

	$email_message->SetEncodedHeader("Subject",$subject);
	$html_message = $email_message->AddStyle($_message);
	$email_message->CreateQuotedPrintableHTMLPart($html_message,"",$html_part);

	$text_message="This is an HTML message. Please use an HTML capable mail program to read this message.";
	$email_message->CreateQuotedPrintableTextPart($email_message->WrapText($text_message),"",$text_part);

/*
 *  Multiple alternative parts are gathered in multipart/alternative parts.
 *  It is important that the fanciest part, in this case the HTML part,
 *  is specified as the last part because that is the way that HTML capable
 *  mail programs will show that part and not the text version part.
 */
	$alternative_parts=array(
		$text_part,
		$html_part
	);
	$email_message->CreateAlternativeMultipart($alternative_parts,$alternative_part);

/*
 *  All related parts are gathered in a single multipart/related part.
 */
	$related_parts=array(
		$alternative_part,
		//$image_part,
		//$background_image_part
	);
	$email_message->AddRelatedMultipart($related_parts);

/*
 *  The message is now ready to be assembled and sent.
 *  Notice that most of the functions used before this point may fail due to
 *  programming errors in your script. You may safely ignore any errors until
 *  the message is sent to not bloat your scripts with too much error checking.
 */


	$error=$email_message->Send();
	if(strcmp($error,""))
		return false;
	else
		return true;
	var_dump($email_message->parts);
	
}
Function Mail_AddStyle($msg){
            	
		global $nukeurl,$sitename;
		
		$html_message = "<div style='margin: 0px; padding: 0px;'><div style='margin: 0px auto; padding: 0px 9px; font-family: tahoma; text-align: right; font-size: 12px; width: 482px;'><div style='border: 1px solid rgb(157, 157, 157); background-color: rgb(185, 220, 240);'>

<div style='min-height: 65px; text-align: center; background-color: rgb(86, 172, 215);'>

<a href='$nukeurl' target='_blank'><img src='$nukeurl/images/logo.gif' border='0'></a> </div><div style='border-top: 1px solid rgb(157, 157, 157); border-bottom: 1px solid rgb(157, 157, 157); background: rgb(239, 237, 215) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; line-height: 30px; font-size: 11px; text-align: center; padding-right: 5px;'>

$sitename</div><div style='border: 1px solid rgb(157, 157, 157); margin: 5px; padding: 10px; background: rgb(249, 249, 249) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(68, 68, 68); direction: rtl;'>";

	$html_message .= "<p>$msg</p>
	<br></div><div style='min-height: 1px;'></div></div></div></div>\n";
        
	return $html_message;
		
		
	}
	
//===========================================
// USER ACCOUNT FUNCTIONS
//===========================================
function avatar_me($username_1){
	global $db,$prefix;
	$username_1 = sql_quote($username_1);
	if (!is_active("phpBB3")) {
	$avatarRow = $db->sql_fetchrow($db->sql_query("SELECT user_avatar,user_avatar_type FROM ".$prefix."_users WHERE username='$username_1'"));
	}else {
	$avatarRow = $db->sql_fetchrow($db->sql_query("SELECT user_avatar,user_avatar_type FROM ".$prefix."_bb3users WHERE username='$username_1'"));
	}

	$user_avatar = $avatarRow["user_avatar"];
	$user_avatar_type = $avatarRow["user_avatar_type"];
	if (empty($user_avatar)) {
		if (file_exists("".INCLUDES_UCP."style/images/blank.gif")) {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
		}
	}else {
		if ($user_avatar_type == "2") {
			$avatar_show = "$user_avatar";
		}elseif ($user_avatar_type == "3"){
				$forum_av_ext = explode("?",$user_avatar);
				if (file_exists("".SITE_AVATAR_DIR."$user_avatar")) {
					$avatar_show = "".SITE_AVATAR_DIR."$user_avatar";
				}elseif(file_exists(FORUMS_AVATAR_DIR.$forum_av_ext[0])) {
					$avatar_show = FORUMS_AVATAR_DIR.$forum_av_ext[0];
				}else {
					$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
				}

		}
	}
	return $avatar_show;
}
function avatar_image($avatarlink){
	global $db,$prefix;

	if (empty($avatarlink)) {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
	}else {
				if (file_exists("".SITE_AVATAR_DIR."$avatarlink")) {
					$avatar_show = "".SITE_AVATAR_DIR."$avatarlink";
				}elseif(file_exists(FORUMS_AVATAR_DIR.avatarlink)) {
					$avatar_show = FORUMS_AVATAR_DIR.avatarlink;
				}else {
					$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
				}

	}
	return $avatar_show;
}
function user_block($content){
	$tmpl_file = "".INCLUDES_UCP."style/blocks.html";
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;
}
function update_points($section,$action='+') {
	global $db,$prefix,$user,$userinfo;
	$user_id = $userinfo['user_id'];
	if(is_user($user)){
		$user_id = intval($user_id);
		$section = sql_quote(intval($section)) - 1;
		// this is rather a complicated MySql query
		
		$sql = 'SELECT g.id,g.point_amount
				FROM '.$prefix.'_groups AS g
				JOIN '.$prefix.'_users AS u 
				ON u.points >= g.point_min
				AND u.points <= g.point_max
				AND u.user_id = "'.$user_id.'" LIMIT 1';
				
		$result = $db->sql_query($sql);
		//or die(mysql_error());
		list($gid,$point_amount) = $db->sql_fetchrow($result);
		$points = explode("-",$point_amount);
		return $db->sql_query("UPDATE ".$prefix."_users
		 SET `points` = `points`".$action."".$points[$section].",
		 `user_group_cp` = '$gid'		 
		 WHERE `user_id` = '$user_id' LIMIT 1");
		//or die(mysql_error());
	}
	return true;
}
function my_points($username){
	global $db,$prefix;
	$username = sql_quote($username);
	list($user_points) = $db->sql_fetchrow($db->sql_query('SELECT `points`  FROM '.$prefix.'_users WHERE `username` = "'.$username.'" LIMIT 1'));
	return intval($user_points);

}
function my_group($username){
	global $db,$prefix;
	$username = sql_quote($username);
	$grdb = $db->sql_fetchrow($db->sql_query('SELECT gr.name,gr.color,u.user_group_cp
	FROM '.$prefix.'_groups AS gr
	LEFT JOIN '.$prefix.'_users AS u 
	ON u.user_group_cp = gr.id
	WHERE u.username = "'.$username.'" LIMIT 1'));
	return $grdb;

}

//===========================================
// Dynamic CSS & JS LOADER   functions added to support dynamic and ordered loading of CSS and JS in <HEAD> and before </BODY>
//===========================================
function addCSSToHead($content, $type='file') {
	global $headCSS;
	// Duplicate external file?
	if (($type == 'file') and (count($headCSS)>0) and (in_array(array($type, $content), $headCSS))) return;
	$headCSS[] = array($type, $content);
	return;
}
function addJSToHead($content, $type='file') {
	global $headJS;
	// Duplicate external file?
	if (($type == 'file') and (count($headJS)>0) and (in_array(array($type, $content), $headJS))) return;
	$headJS[] = array($type, $content);
	return;
}
function addJSToBody($content, $type='file') {
	global $bodyJS;
	// Duplicate external file?
	if (($type == 'file') and (count($bodyJS)>0) and (in_array(array($type, $content), $bodyJS))) return;
	$bodyJS[] = array($type, $content);
	return;
}
function writeHEAD() {
	global $headCSS, $headJS;
	if (is_array($headCSS) and count($headCSS) > 0) {
		foreach($headCSS as $css) {
			if ($css[0]=='file') echo '<link rel="StyleSheet" href="'.$css[1].'" type="text/css" />'."\n";
			else echo $css[1];
		}
	}
	if (is_array($headJS) and count($headJS) > 0) {
		foreach($headJS as $js) {
			if ($js[0]=='file') echo '<script type="text/javascript" src="'.$js[1].'"></script>'."\n";
			else echo $js[1];
		}
	}
	return;
}
function writeBODYJS() {
	global $bodyJS;
	if (is_array($bodyJS) and count($bodyJS) > 0) {
		foreach($bodyJS as $js) {
			if ($js[0]=='file') echo '<script type="text/javascript" language="JavaScript" src="'.$js[1].'"></script>'."\n";
			else echo $js[1];
		}
	}
	return;
}
function readDIRtoArray($dir, $filter) {
	$files = array();
	$handle = opendir($dir);
	while (false !== ($file = readdir($handle))) {
		if (preg_match($filter, $file)) {
			$files[] = $file;
		}
	}
	closedir($handle);
	return $files;
}

//===========================================
// Boosting Functions
//===========================================
if (!function_exists('memory_get_usage')){
	function memory_get_usage()
	{
		if ( substr(PHP_OS,0,3) == 'WIN')
		{
			if ( substr( PHP_OS, 0, 3 ) == 'WIN' )
			{
				$output = array();
				@exec( 'tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output );

				return preg_replace( '/[\D]/', '', $output[5] ) * 1024;
			}
		}
		else
		{
			$pid = getmypid();
			@exec("ps -eo%mem,rss,pid | grep $pid", $output);
			$output = explode("  ", $output[0]);

			return $output[1] * 1024;
		}
	}
}

//===========================================
// Authors :  Fuctions
//===========================================
function is_superadmin($admin) {
	static $is_superadmin;

    if (!$admin) { return 0; }
    if (isset($is_superadmin)) return $is_superadmin;
    
   if (!is_array($admin)) {
        $admin = base64_decode($admin);
        $admin = addslashes($admin);
        $admin = explode(':', $admin);
    }
    $aid = $admin[0];
    $pwd = $admin[1];
    $aid = substr(addslashes($aid), 0, 25);
	global $prefix, $db;
    if (!empty($aid) && !empty($pwd)) {

        $sql = "SELECT pwd,radminsuper FROM ".$prefix."_authors WHERE aid='$aid'";
        $result = $db->sql_query($sql);
        list($pass,$radminsuper) = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);
        if ($pass == $pwd && !empty($pass) && $radminsuper==1) {
        	return $is_superadmin = 1;
        }
	}
    return $is_superadmin = 0;
    unset($aid);
}
function is_admin_of($section = false, $admin){

	static $is_admin_of;

    if (!$admin) { return 0; }
    if (isset($is_admin_of)) return $is_admin_of;
   if (!is_array($admin)) {
        $admin = base64_decode($admin);
        $admin = addslashes($admin);
        $admin = explode(':', $admin);
    }
    $aid = $admin[0];
    $pwd = $admin[1];
    $aid = substr(addslashes($aid), 0, 25);
    
    if (!empty($aid) && !empty($pwd) && !empty($section)) {
    
    	global $prefix,$db;
	
		$section = sql_quote($section);
		
		$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper, admlanguage FROM ".$prefix."_authors WHERE aid='$aid'"));

		$radminsuper = intval($row['radminsuper']);

		$admlanguage = addslashes($row['admlanguage']);

		$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='$section'");

		$result2 = $db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'");

		list($aidname) = $db->sql_fetchrow($result2);

		$radminarticle = 0;

		while (list($admins) = $db->sql_fetchrow($result)) {

			$admins = explode(",", $admins);

			$auth_user = 0;

			for ($i=0; $i < sizeof($admins); $i++) {

				if ($aidname == $admins[$i]) {

					$auth_user = 1;

				}

			}

			if ($auth_user == 1) {

				return $is_admin_of = 1;

			}
			return $is_admin_of = 0;

		}
	}
	return $is_admin_of = 0;
}

//===========================================
// Security Functions
//===========================================

//-- Security Captcha -----
function show_captcha(){ // function to display the cpatcha code
	global $db,$prefix,$gfx_chk;
	list($use_question,$codesize) = $db->sql_fetchrow($db->sql_query('SELECT `use_question`,`codesize` FROM `'.$prefix.'_config` LIMIT 1'));
	if($gfx_chk != 0 AND extension_loaded('gd') AND $use_question == 0){
		$capt = '<a href="javascript:void(0)">
		<img style="cursor:hand" src="includes/captcha/securimage_show.php?sid='.md5(uniqid(time())).'&codesize='.$codesize.'" title="'._RELOAD_CAPTCHA.'" onclick="this.src = \'includes/captcha/securimage_show.php?sid=\' + Math.random()+\'&codesize='.$codesize.'\'; return false" alt="'._SECURITY_CODE.'" title="'._SECURITY_CODE.'" id="captcha" />
		</a><br>';
		$capt .= _SECURITY_CODE.' <br>';
		$capt .= '<input name="captcha_code" id="captcha_code" type="text" class="intxt" />';
		return $capt;
	}elseif($gfx_chk != 0){
		$sql = 'SELECT `qid`,`question` FROM `'.$prefix.'_squestions` ORDER BY RAND() LIMIT 1';
		list($qid,$ques) = $db->sql_fetchrow($db->sql_query($sql));
		return '<div id="squestion">'._ANSWER_QUESTION.':<br />'.
		$ques.'<br /><input type="text" name="sanswer" value="" size="10" /><input type="hidden" name="qid" value="'.$qid.'" size="10" /><br>';
	}
}
function check_captcha(){ // this one checks whether the entered code is right or not
	global $db,$prefix,$gfx_chk;
	list($use_question) = $db->sql_fetchrow($db->sql_query('SELECT `use_question` FROM `'.$prefix.'_config` LIMIT 1'));
	if(!empty($_POST['captcha_code']) OR !empty($_POST['qid']) ) {
	if($gfx_chk != 0 AND extension_loaded('gd') AND $use_question == 0){
		session_start();
		include_once 'includes/captcha/securimage.php';
		$securimage = new Securimage();
		$valid = $securimage->check(sql_quote($_POST['captcha_code']));
		return $valid;
	}elseif($gfx_chk != 0){
		global $db,$prefix;
		$qid = sql_quote(intval($_POST['qid']));
		list($answer) = $db->sql_fetchrow($db->sql_query('SELECT `answer` FROM `'.$prefix.'_squestions` WHERE `qid` = "'.$qid.'" LIMIT 1'));
		if(sql_quote($_POST['sanswer']) == $answer) return true;
		else return false;
	}
	}else return false;
	
}


function show_error($value){
	global  $sitename,$currentlang ;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>خطا در صفحه <?php echo $sitename ?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<style type="text/css">
body{font-family:<?php echo langstyle('font'); ?>;direction:<?php echo langstyle('direction'); ?>;}
.content-box{min-height:250px;margin: 20% auto 0px auto; border:1px solid #AFAFAF; -moz-border-radius: 5px; -webkit-border-radius:5px; width:600px; height:200px;text-align:<?php echo langstyle('align');?>;background:#FFF;}
.content-box p{font-size:12px;padding:50px;text-align:<?php echo langstyle('align'); ?>;}
</style>
</head>
<body>
<?php
die("<div class='content-box'>
		<h4>"._ERROR_DANGERS."</h4>
		<p>$value</p><br>
		"._GOBACK."
	</div>
</body>");
}
function _e($value){show_error($value);}
function sql_quote( $value )
{
	if( get_magic_quotes_gpc() )
	{
		$value = stripslashes( $value );
	}
	//check if this function exists
	if( function_exists( "mysql_real_escape_string" ) )
	{
		$value = mysql_real_escape_string ( $value );
	}
	//for PHP version < 4.3.0 use addslashes
	else
	{
		$value = addslashes( $value );
	}
	return $value;
}
function VALIDATE_VERSION( $value )
{
	global $USV_Version;

	if(base64_encode(sha1($USV_Version)) == USV_VERSION )
	{
		//$value = $USV_Version.VALIDATE_VERSION_IMG($value) ;
		$value = VALIDATED ;
	}
	//for UNVALIDATED $VAR VALUE
	else
	{
		$value = UNVALIDATED ;
	}
	return $value;
}
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function is_crawlers() {

   $sites = 'bot|Slurp|Scooter|Spider|Infoseek|Google|Yahoo|msnbot|Bing'; // Add the rest of the search-engines 

   return (preg_match("/$sites/", $_SERVER['HTTP_USER_AGENT']) > 0) ? true : false;  

   }
function benchGetTime() {
    $timer = explode( ' ', microtime() );
    $timer = $timer[1] + $timer[0];
    return $timer;
}
function benchmark_overall($start,$end,$title) {
	global $admin,$db;
	if (is_admin($admin)) {
		if (!defined("ADMIN_FILE")) {
			$timeelps = round($end - $start,4);
			if ($timeelps < 0.5) {
				$warning_color = '75941F';
			}elseif ($timeelps < 1) {
				$warning_color = 'F79307';
			}else {
				$warning_color = 'EA5D5D';
			}
			$timepassed =  '<div style="margin:5px;padding:5px;border:1px solid #A5A5A5;background:#'.$warning_color.';color:white;width:99%;direction:ltr;text-align:center;">
    <strong>'._TIME_PASSED.': <b>'.$title.'</b> : </strong>: '.$timeelps.' '._SECONDS.' <br />'; 
			$timepassed .= ""._QUERIES ._TILLNOW .": <b>" . $db->num_queries."</b></div>";
			return $timepassed;
		}
	}
	return false;
}
function benchmark_listprocesses() {
 	global $admin,$db;
 	if (is_admin($admin)) {

 $timepassed = '<table style="width: 100%">
	<tr>
		<td>شناسه</td>
		<td>کاربر</td>
		<td>میزبان</td>
		<td>زمان</td>
		<td>وضعیت</td>
	</tr>';
 		$result = $db->sql_query("SELECT * FROM INFORMATION_SCHEMA.PROCESSLIST");

 		while($row = $db->sql_fetchrow($result)) {
 			$timepassed .= "
  		<tr>
		<td>".$row['ID']."</td>
		<td>".$row['USER']."</td>
		<td>".$row['HOST']."</td>
		<td>".$row['TIME']."</td>
		<td>".$row['STATE']."</td>
	</tr>	";  
 		}
 		$timepassed .= '</table>';
 		$db->sql_freeresult($result);

$result =mysql_list_processes($db->db_connect_id);
while ($row = $db->sql_fetchrow($result)){
  return  printf("%s %s %s %s %s\n", $row["Id"], $row["Host"], $row["db"],
        $row["Command"], $row["Time"])."<br>".$timepassed;
}
 		$db->sql_freeresult($result);
	}
return false;
}
if (!function_exists('eregi')) {
    function eregi($find, $str) {
        return stristr($str, $find);
    }
}


// check if files/directories are writable and return message
function check_writable($files) {
	global $lang;
	foreach ($files AS $file) {
		if (!is_writable($file)) {
			return str_replace('{$x}', $file, $lang['file_not_writable']);
		}
	}
	return true;
}
  
?>