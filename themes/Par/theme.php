<?php 
//===========================================
//Theme Engine : SETTING
//===========================================
//define("hide_lside",true);  // HIDE LEFT SIDE
//define("hide_rside",true);  // HIDE RIGHT SIDE
//define("blocks_show",true); // HIDE BOTH SIDE
define("THEME_FILES_PREFIX","html"); 
//===========================================
//Theme Engine : EXAMPLE FOR DEFINING CONSTANTS
//===========================================
// just uncomment bellow texts to learn how we can define a contansts . 
// bellow constants is a simple welcome note that you can use anywhere in your html files  just by using [welcome_note]
// just consider that this is a simple usage of defining a constanst in TE and you can creat more advanced var and link to the database by using $db->
if (!function_exists('OpenTable')) {
function OpenTable() {
?>
<div class="site-body-sidebar-center">
<?php 
}
}
if (!function_exists('CloseTable')) {
function CloseTable() {
?>
</div>
 <div class="clear"><!-- --></div>
<?php 
}
}


if(!defined('BLOCK_FILE')) {
define('BLOCK_FILE', true);
}

global $user,$userinfo,$admin;

if(!is_user($user)){
$login_theme = '                           
	 <form action="modules.php?name=Your_Account" method="post" style="margin-top: 0px;">
        <div style="margin-top: auto;direction:rtl;">
          <label>[_USERNAME] : 
          <input type="text" name="username" id="username" class="logintxt" />
          </label>
          <label>[_PASSWORD] : 
          <input type="password" name="user_password" id="user_password" class="logintxt" /> 
         </label>
		<input type="hidden" name="op" value="login">
        <input type="submit" name="Login" id="Login" class="loginbtn" value="[_LOGIN]" />
        <a href="modules.php?name=Your_Account&op=new_user" class="button" > [_BREG] </a>
        </div>
</form>
'
;
}else{
$login_theme = '<div class="profile-box">
<img class="formsubmit" src="'.avatar_image($userinfo['user_avatar']).'">
<li>
<span style="font-size:15px"><b>'.$userinfo['username'].'</b> </span>  <img src="images/icon/cross.png"><a style="color:red" href="modules.php?name=Your_Account&op=logout"> '._LOGOUT.' </a>
</li>
<p> <img src="images/icon/user_green.png"><a href="modules.php?name=Your_Account"> '._ACCOUNT.' </a></p>';

if(is_admin($admin)){
$login_theme .= '<p> <img src="images/icon/user_gray.png"><a href="'.ADMIN_PHP.'"> '._ADMIN_MAINPAGE.' </a></p>';
}
$login_theme .= '
<p> <img src="images/icon/user_edit.png"><a href="modules.php?name=Your_Account&op=edituser"> '._ACCOUNT_EDIT.'</a></p>
<div class="clear"></div>
</div>
';
}


$varnamelist = array(
	'theme_login' => $login_theme,
	'theme_langs' => blockfileinc('','block-Languages.php','NULL'),
	'theme_tags' => blockfileinc('','block-TagsArrows.php','NULL'),
	'theme_topusers' => blockfileinc('','block-TopUsers.php','NULL'),
	'theme_lastarticles' => blockfileinc('','block-Last_Articles.php','NULL'),
	'theme_lastcomments' => blockfileinc('','block-Comments.php','NULL')
);


?>