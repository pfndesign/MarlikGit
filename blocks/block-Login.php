<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


if(stripos($_SERVER['SCRIPT_NAME'],'block-Tag_Cloud.php')){
	die("Illegal Access!");
}

global $admin,$admin_file,$user,$userinfo,$gfx_chk, $admin_file;


if (is_admin($admin)) {
    $content .= "<center><a href=\"".ADMIN_PHP."\"><img src='images/icon/user_red.png'>"._ADMIN."</a>
    <br>[ <a href=\"".ADMIN_OP."logout\"><img src='images/icon/stop.png'>"._LOGOUT."</a> ]</center><hr>";
}

if (is_user($user)) {

    $content .= "<center>"._BWEL." <a href=\"modules.php?name=Your_Account&op=userinfo&username=".$userinfo[username]."\">
    <img src='images/icon/user.png'><b>".(!empty($userinfo[name]) ? $userinfo[name] : $userinfo[username])."</b></a>
    <br>[ <a href=\"modules.php?name=Your_Account&op=logout\"><img src='images/icon/stop.png'>"._LOGOUT."</a> ]
    </center>";
    
}else {

$content .= "<form action=\"modules.php?name=Your_Account\" method=\"post\">";
$content .= "<center><font class=\"content\">"._NICKNAME."<br>";
$content .= "<input type=\"text\" name=\"username\" size=\"10\" maxlength=\"25\"><br>";
$content .= ""._PASSWORD."<br>";
$content .= "<input type=\"password\" name=\"user_password\" size=\"10\" maxlength=\"20\"><br>";
	if (extension_loaded("gd") AND ($gfx_chk == 2 OR $gfx_chk == 4 OR $gfx_chk == 5  OR $gfx_chk == 7)) {
		global $wrong_code;
		if($wrong_code)
		$content .= "<div style='color:red;'>"._WRONG_CODE."</div>";
		$content .=  show_captcha();
	}
	
$content .= "<input type=\"hidden\" name=\"op\" value=\"login\">";
$content .= "<input type=\"submit\" value=\""._LOGIN."\"></font></center></form>";
$content .= "<center><font class=\"content\">"._ASREGISTERED."</font></center>";
	
}


?>