<?php
/**
 *
 * @package shoutbox
 * @version $Id: BASIC VERSION : Aneeshtan $
 * @copyright (c) INSPIRED BY : yensdesign.com AND Revised By Marlik Group  http://www.MarlikCMS.com
 * @license ONLY FOR MarlikCMS'S USERS
 *
 */
if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}
global $userinfo,$currentlang,$user;
$module_name = "JQ-Shoutbox";
define("NL_SHOUTBOX_SMILEY_DIR","images/smiley/");
define("NL_SHOUTBOX_PATH","".MODS_PATH."JQ-Shoutbox/");
define("_numbers_format_Lng","EA");
require_once(MODS_PATH."$module_name/language/lang-$currentlang.php");
require_once(NL_SHOUTBOX_PATH."class.shoutbox.php");

$NL_SHOUTBOX_CLASS = new nl_shoutbox();
$NL_SHOUTBOX_CLASS->jq_toggle_box ( 'show_smiley', 'a', 'smiley_div' );
//$NL_SHOUTBOX_CLASS->_shoutbox_data();
	$content = "
	<link rel='StyleSheet' href='".MODS_PATH.$module_name."/css/general.css' type='text/css' /> 
	<script type=\"text/javascript\" src=\"".MODS_PATH.$module_name."/js/shoutbox.js\"></script>";
	$content .='
    <div id="shoutbox-container">  
        <ul class="menu">  
            <li>'._NL_SHOUTBOX_LASTMESSAGES.' <a href="javascript:refresh_shoutbox()" class="refresh_shoutbox"><img src="images/icon/time_go.png" title="'._REFRESH.'" alt="'._REFRESH.'"></a></li>  
        </ul>  
        <span class="clear"></span>  
        <div id="shoutbox-content">  
            <div id="shoutbox-loading"><img src="images/loading.gif" alt="'._NL_SHOUTBOX_LOADING.'..." /></div>  
            <ul>  
            <ul>  
        </div>  
    </div>
    <div style="clear:both"></div>
     ';
    $content .='<div id="shoutbox-form" >
    ';
if (!is_user($user)) {
	$content .= _SHOUTBOX_ONLY_FOR_USERS ."<br>"._ASREGISTERED;
}else {
	$content .= '
    <form method="post">  
     <input class="text user" id="nick" readonly type="hidden" value="'.$userinfo[username].'" />
      '._NL_SHOUTBOX_MESSAGE.'<input class="text" id="message" type="text" MAXLENGTH="255" />
      		<br><br>
             <input id="send" type="submit" value="'._NL_SHOUTBOX_SEND.'" />
              <a href="javascript:show_smiley()" id="show_smiley" class="button" />'._SMILEY.'</a>  

    <div class="clear"></div>
    <div id="smiley_div" >';
	$content .= $NL_SHOUTBOX_CLASS->read_smiley_dir();
	$content .=  '</div>
    </form>   
     ';
}
	$content .=  '</div>';

?>