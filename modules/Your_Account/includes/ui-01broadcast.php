<?php
/**
*
* @package MicroBlogging System														
* @version $Id: 3:52 PM 7/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
* 
*/

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	header("Location: ../../../index.php");
	die ();
}
//_public_messages         <b>"._BROADCAST."</b><br><br>"._BROADCASTTEXT."<br><br>";
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
if ($broadcast_msg == 1) {
	//----------Color Setting ----------

?>
<script type="text/javascript" language="JavaScript" src="modules/Your_Account/includes/style/YABC.js"></script>
<?php

if (isset($username)) {
	$pageowner = "$username";
}

$Rusername = sql_quote($_GET['username']);
$blogPage = sql_quote($_GET['blogPage']);
$userrow = $db->sql_fetchrow( $db->sql_query("SELECT user_id,username,user_blog_password,user_blog_colors FROM ".__USER_TABLE." WHERE  username='".$Rusername."' limit 1 "));
$md5stringpass = md5($userrow['user_blog_password']);

if ($userinfo[username] == $Rusername OR is_admin($admin) OR empty($userrow['user_blog_password']) OR $_COOKIE["BlogUSER-$Rusername"]=="$md5stringpass") {

if ((strtolower($usrinfo['username']) == strtolower($cookie[1])) AND ($usrinfo['user_password'] == $cookie[2])) {


	require_once(INCLUDES_PATH.'inc_bbcode.php');
	$parser = new SimpleParser();
	$parser->jq_toggle_box ( 'show_smiley', 'a', 'smiley_div' );
	echo "<br>";
	OpenTable();
	echo blog_post_box();
	echo "
	    <b>"._BROADCAST."</b><br><br>"._BROADCASTTEXT."<br><br>
        <b>"._FIREBLOG."</b><br><br>"._FIREBLOGTXT."<br><br>";

	CloseTable();
	?>
	<script type="text/javascript">
	$(document).ready(function(){$("a.add_emo").click(function(){var emo = $(this).attr("id");$('#the_message').val($('#the_message').val() + emo + ' ');});});
	</script>
	<?php
}

//-- LIST BLOG POSTS ---------------------

	echo "<div id='blog_page'>
	<div class='blog_pagenum' id='$blogPage'></div>
	<div class='blog_username' id='".$userrow[username]."'></div>
	<div class='blog_userid' id='".$userrow[user_id]."'></div>
	";
	show_latest_blog($userrow[user_id],$userrow[username],$userrow[user_blog_password],$userrow[user_blog_colors],$offset,5,$blogPage);
	echo "</div>";

}else{
echo "<div class='blog_password_div' id='$Rusername'></div>";
}
}

?>