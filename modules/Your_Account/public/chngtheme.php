<?php

/**
*
* @package CHANGE THEME FILE													
* @version @1:57 PM 6/10/2010 $Aneeshtan 						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	header("Location: ../../../index.php");
	die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

cookiedecode($user);
getusrinfo($user);
define("_THEME_PREVIEW",true); // If you dont want to have a preview of themes just set the value to FALSE

if ((is_user($user)) AND (strtolower($userinfo[username]) == strtolower($cookie[1])) AND ($userinfo[user_password] == $cookie[2])) {
	include ("header.php");
	title(_THEMESELECTION);
	OpenTable();
	nav();
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<center>";
	$handle=opendir('themes');
	$counter = 0;
	while ($file = readdir($handle)) {
		if ( (!preg_match("/[.]/",$file) AND file_exists("themes/$file/theme.php") OR file_exists("themes/$file/table.inc") ) ) { $themelist .= "$file "; }
	}
	closedir($handle);
	
	$themelist = explode(" ", $themelist);
	sort($themelist);
	if (_THEME_PREVIEW == true) {
	echo "<h3 style='text-align:right'>".THEME_PREVIEW."</h3><hr><table><tr>";

	for ($i=0; $i < sizeof($themelist); $i++) {
		$counter++;
		if($themelist[$i]!="") {


			//----START--------- display image of the Template--------------
			$imglist='';

			$img_folder = "themes/$themelist[$i]/";

			mt_srand((double)microtime()*1000);

			$imgs = dir($img_folder);

			while ($file = $imgs->read()) {
				if (preg_match("/gif/", $file) || preg_match("/jpg/", $file) || preg_match("/png/", $file))
				$imglist .= "$file ";

			} closedir($imgs->handle);

			$imglist = explode(" ", $imglist);
			$image = $imglist[0];
			$s_shot ="$img_folder"."$image";
		
		
			//----START--------- display a highlight border arround the current theme

			if((($userinfo['theme']=="") && ($themelist[$i]=="$Default_Theme")) || ($userinfo[theme]==$themelist[$i])){
				$styletm = "border:4px solid #FFE100;";
				$titletm = "قالب کنونی";
			}else {
				$styletm="border:0px;";
				$titletm = "$themelist[$i]";
			}



			echo "<td><img src='$s_shot' style='$styletm'  title='$titletm' alt='$titletm' width='200px' height='150px' >&nbsp;&nbsp;";
	
			echo "<br><b>".$themelist[$i]."</b></td>\n";

			if ($counter == 3 ) {
				echo "</tr><tr>";
				$counter=0;
			}
		}
	}

	echo "</tr></table><br>";
		
	}
	echo "<form action=\"modules.php?name=$module_name&op=userinfo&username=$user\" method=\"post\">";
	echo "<h3 style='text-align:right'>"._SELECTTHEME." </h3><hr>";
	echo "<select name=\"theme\">";

	for ($i=0; $i < sizeof($themelist); $i++) {
		if($themelist[$i]!="") {
			echo "<option value=\"$themelist[$i]\" ";
			if((($userinfo[theme]=="") && ($themelist[$i]=="$Default_Theme")) || ($userinfo[theme]==$themelist[$i])) echo "selected";
			echo ">$themelist[$i]\n";
		}
	}
	if($userinfo[theme]=="") $userinfo[theme] = "$Default_Theme";
	echo "</select><br>";
	echo ""._THEMETEXT1."<br>";
	echo ""._THEMETEXT2."<br>";
	echo ""._THEMETEXT3."<br><br>";
	echo "<input type=\"hidden\" name=\"user_id\" value=\"$userinfo[user_id]\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"savetheme\">";
	echo "<input type=\"submit\" value=\""._SAVECHANGES."\">";
	echo "</form>";
	CloseTable();
	include ("footer.php");
} else {
	mmain($user);
}

?>