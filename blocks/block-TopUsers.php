<?php
/**
*
* @package TOP USERS Block														
* @version $Id: 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if(stripos($_SERVER['SCRIPT_NAME'],'block-Tag_Cloud.php')){
	die("Illegal Access!");
}
global $db,$prefix;
$content .= '
<style type="text/css">
.topuserStyle {
padding:2px;margin:2px;border:1px solid white;background:#E6E2DA;width:30px;height:30px;
}
.topuserDiv {
margin:0px auto;text-align:center;
}
</style>
';
$result = $db->sql_query('SELECT user_avatar,user_avatar_type,`username`,`points` FROM `'.$prefix.'_users` WHERE user_active > 0 ORDER BY `points` DESC LIMIT 12 ');

$content .= '
<center>
<div class="topuserDiv">';
while($row = $db->sql_fetchrow($result)){
	$user_avatar = $row["user_avatar"];
	$user_avatar_type = $row["user_avatar_type"];
	if (empty($user_avatar)) {
		if (file_exists("".INCLUDES_UCP."style/images/blank.gif")) {
			$avatar_show = "".INCLUDES_UCP."style/images/blank.gif";
		}else {
			$avatar_show = "".FORUMS_AVATAR_DIR."gallery/blank.gif";
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
	
	$content .= '<a href="modules.php?name=Your_Account&op=userinfo&username='.$row[username].'" title="'.$row[username].' : '.$row[points].' '._POINTS.'"> 
	<img class="topuserStyle"  src="'.$avatar_show.'"> </a>';
}
$content .= '</div></center>';
$db->sql_freeresult($result);
?>