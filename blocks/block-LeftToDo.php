<?php
/**
*
* @package BlogRoll														
* @version $Id: BlogRoll.php RC-7 4:09 PM 1/16/2010 $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}
// ok this block intends to show what is left to do for a user , like did he choose an avatar ? did he ... ?



global $user,$userinfo;

if (is_user($user)) {
if (empty($userinfo['name']) OR empty($userinfo['user_email']) OR empty($userinfo['user_website']) OR empty($userinfo['user_avatar'])){
$content .= '
<style type="text/css">#left2do{background-color:red;background-repeat:no-repeat;background-position:top left;margin-top:5px;margin-bottom:5px}#left2do b{color:#FFF}#left2do{background-repeat:no-repeat;background-position:bottom left;color:#FFF}#tasklist2do{margin:3px}#tasklist2do a{display:block;background-color:#FF8285;border-bottom:1px solid red;color:#FFF;background-repeat:no-repeat;background-position:0 1px;padding:4px 4px 5px 17px}#tasklist2do a:hover{background-color:#900}#tasklist2do a.last{background-position:0 0;border-bottom:0}#tasks2do{padding:5px 5px 2px}#tasks2do b{color:#FFF}#tasks2do a{height:15px;width:15px;display:block;}
</style>
';
$content .= '		
				<div id="left2do" style="display:block;">
							<div id="left2do">
								<div id="tasks2do">
									<b>'._WHATS_LEFT_2_DO.'</b><br>
								</div>
								<div style="clear:both;"></div>
								<div id="tasklist2do">';
								if (empty($userinfo['name']) OR empty($userinfo['user_email']) OR empty($userinfo['user_website'])) {
								$content .= '<a href="modules.php?name=Your_Account&op=edituser" class="frst">'._COMPLETE_MAIN_INFO.' </a><br>';
								}								
								if (empty($userinfo['user_avatar'])) {
								$content .= '<a href="modules.php?name=Your_Account&op=edituser" class="frst">'._CHOOSE_AVATAR.'</a><br>';									}
								$content .= '</div>
							</div>
						</div>
';

}else {
	$content .= '<br>';
}
}else {
	$content .= '<br>';
}

?>