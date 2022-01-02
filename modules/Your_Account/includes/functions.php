<?php
/**
*
* @package  Your Account System														
* @version $Id: 3:52 PM 7/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

/*************************************************************************************/
// function Show_CNBYA_menu(){ [added by menelaos dot hetnet dot nl]
/*************************************************************************************/
function Show_CNBYA_menu() {
	global $stop, $module_name, $redirect, $mode, $t, $f, $ya_config;
	OpenTable ();
	if ($stop) {
		echo "<center><font class=\"title\"><b>" . _LOGININCOR . "</b></font></center>\n";
	} else {
		echo "<center><font class=\"title\"><b>" . _USERREGLOGIN . "</b></font></center>\n";
	}
	CloseTable ();
	echo "<br>";
	OpenTable ();
	echo "<CENTER><font class=\"content\">\n";
	echo "[ <a href=\"modules.php?name=$module_name\">" . _LOGIN . "</a> \n";
	echo "| <a href=\"modules.php?name=$module_name&op=new_user\">" . _REGNEWUSER . "</a> ]\n";
	echo "<BR><BR>\n";
	echo "[ <font class=\"content\"><a href=\"modules.php?name=$module_name&op=pass_lost\">" . _PASSWORDLOST . "</a> \n";
	echo "| <a href=\"modules.php?name=$module_name&op=ShowCookiesRedirect\">" . _YA_COOKIEDELALL . "</a> ]</font>\n";
	echo "</CENTER>\n";
	CloseTable ();
	echo "<br>";
}

function ya_userCheck($username) {
	global $stop, $user_prefix, $db, $ya_config;
	// Need to find a way to include extended caracters
	//if ((!$username) || ($username=="") || (ereg("[^�-�a-zA-Z0-9_-]",$username))) $stop = "<center>"._ERRORINVNICK."</center><br>";
	if ((! $username) || ($username == "") || (preg_match ( "/[^a-zA-Z0-9_-]/", $username )))
		$stop = "<center>" . _ERRORINVNICK . "</center><br>";
	if (strlen ( $username ) > $ya_config ['nick_max'])
		$stop = "<center>" . _YA_NICKLENGTH . "</center>";
	if (strlen ( $username ) < $ya_config ['nick_min'])
		$stop = "<center>" . _YA_NICKLENGTH . "</center>";
	if ($ya_config ['bad_nick'] > "") {
		$BadNickList = explode ( "\r\n", $ya_config ['bad_nick'] );
		for($i = 0; $i < count ( $BadNickList ); $i ++) {
			if (preg_match ( "/$BadNickList[$i]/i", $username ))
				$stop = "<center>" . _NAMERESTRICTED . "</center><br>";
		}
	}
	if (strrpos ( $username, ' ' ) > 0)
		$stop = "<center>" . _NICKNOSPACES . "</center>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT username FROM " . $user_prefix . "_users WHERE username='$username'" ) ) > 0)
		$stop = "<center>" . _NICKTAKEN . "</center><br>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT username FROM " . $user_prefix . "_users_temp WHERE username='$username'" ) ) > 0)
		$stop = "<center>" . _NICKTAKEN . "</center><br>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT username FROM " . $user_prefix . "_users WHERE LOWER(username) = LOWER('$username') " ) ) > 0)
		$stop = "<center>" . _NICKTAKEN . "</center><br>";
	
	return ($stop);
}

function ya_mail($email, $subject, $message, $from) {
	global $ya_config, $adminmail;
	if ($ya_config ['servermail'] == 0) {
		if (trim ( $from ) == '')
			$from = "From: $adminmail\r\n" . "Reply-To: $adminmail\r\n" . "Return-Path: $adminmail\r\n";
		mail ( "$email", "$subject", "$message", "$from" );
	}
}

function ya_mailCheck($user_email) {
	global $stop, $user_prefix, $db, $ya_config;
	$user_email = strtolower ( $user_email );
	if ((! $user_email) || ($user_email == "") || (! preg_match ( "/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/", $user_email )))
		$stop = "<center>" . _ERRORINVEMAIL . "</center><br>";
	if ($ya_config ['bad_mail'] > "") {
		$BadMailList = explode ( "\r\n", $ya_config ['bad_mail'] );
		for($i = 0; $i < count ( $BadMailList ); $i ++) {
			if (preg_match ( "/$BadMailList[$i]/i", $user_email ))
				$stop = "<center>" . _MAILBLOCKED . " <b>" . $BadMailList [$i] . "</b></center><br>";
		}
	}
	if (strrpos ( $user_email, ' ' ) > 0)
		$stop = "<center>" . _ERROREMAILSPACES . "</center><br>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT user_email FROM " . $user_prefix . "_users WHERE user_email='$user_email'" ) ) > 0)
		$stop = "<center>" . _EMAILREGISTERED . "</center><br>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT user_email FROM " . $user_prefix . "_users WHERE user_email='" . md5 ( $user_email ) . "'" ) ) > 0)
		$stop = "<center>" . _EMAILNOTUSABLE . "</center><br>";
	if ($db->sql_numrows ( $db->sql_query ( "SELECT user_email FROM " . $user_prefix . "_users_temp WHERE user_email='$user_email'" ) ) > 0)
		$stop = "<center>" . _EMAILREGISTERED . "</center><br>";
	return ($stop);
}

function ya_passCheck($user_pass1, $user_pass2) {
	global $stop, $ya_config;
	if (strlen ( $user_pass1 ) > $ya_config ['pass_max'])
		$stop = "<center>" . _YA_PASSLENGTH . "</center><br>";
	if (strlen ( $user_pass1 ) < $ya_config ['pass_min'])
		$stop = "<center>" . _YA_PASSLENGTH . "</center><br>";
	if ($user_pass1 != $user_pass2)
		$stop = "<center>" . _PASSWDNOMATCH . "</center><br>";
	return ($stop);
}

function ya_fixtext($ya_fixtext) {
	if ($ya_fixtext == "") {
		return $ya_fixtext;
	}
	$ya_fixtext = stripslashes ( $ya_fixtext );
	$ya_fixtext = str_replace ( "\'", "", $ya_fixtext );
	$ya_fixtext = str_replace ( "\'", "&acute;", $ya_fixtext );
	$ya_fixtext = str_replace ( "\"", "&quot;", $ya_fixtext );
	$ya_fixtext = strip_tags ( $ya_fixtext );
	if (true) {
		$ya_fixtext = addslashes ( $ya_fixtext );
	}
	;
	$ya_fixtext = addslashes ( $ya_fixtext );
	return $ya_fixtext;
}

// function improved by Peter
function ya_save_config($config_name, $config_value, $config_param = "") {
	global $prefix, $db;
	if (true) {
		$config_value = addslashes ( $config_value );
	}
	if ($config_param == 'html') {
		$config_name = check_html ( $config_name, 'nohtml' );
		$config_value = check_html ( $config_value, 'html' );
		$db->sql_query ( "UPDATE " . $prefix . "_cnbya_config SET config_value='$config_value' WHERE config_name='$config_name'" );
	}
	if ($config_param == 'nohtml') {
		$config_name = check_html ( $config_name, 'nohtml' );
		$config_value = ya_fixtext ( check_html ( $config_value, 'nohtml' ) );
		$db->sql_query ( "UPDATE " . $prefix . "_cnbya_config SET config_value='$config_value' WHERE config_name='$config_name'" );
	} else {
		$config_name = check_html ( $config_name, 'nohtml' );
		$config_value = intval ( $config_value );
		$db->sql_query ( "UPDATE " . $prefix . "_cnbya_config SET config_value='$config_value' WHERE config_name='$config_name'" );
	}
}

function ya_get_configs() {
	global $prefix, $db, $gfx_chk;
	$configresult = $db->sql_query ( "SELECT config_name, config_value FROM " . $prefix . "_cnbya_config" );
	while ( list ( $config_name, $config_value ) = $db->sql_fetchrow ( $configresult ) ) {
		if (true) {
			$config_value = stripslashes ( $config_value );
		}
		$config [$config_name] = $config_value;
	}
	return $config;
}

function yacookie($setuid, $setusername, $setpass, $setstorynum = "", $setumode = "", $setuorder = "", $setthold = "", $setnoscore = "", $setublockon = "", $settheme = "", $setcommentmax = "") {
	global $ya_config,$prefix, $db;
	
	$infouser = base64_encode ( "$setuid:$setusername:$setpass:$setstorynum:$setumode:$setuorder:$setthold:$setnoscore:$setublockon:$settheme:$setcommentmax" );
	if (! empty ( $ya_config [cookietimelife] )) {
		@setcookie ( 'user', $infouser, time () + $ya_config [cookietimelife] );
	} elseif (! empty ( $ya_config [cookiepath] )) {
		@setcookie ( 'user', $infouser, time () + $ya_config [cookietimelife], "$ya_config[cookiepath]" );
	} else {
		@setcookie ( 'user', $infouser, time () + 36000 * 24 );
	}
	$ctime = date ( "Y-m-j H:i-1:s" );
	$ipaddr = $_SERVER["REMOTE_ADDR"];
	$db->sql_query ( "UPDATE " . $prefix . "_users SET `user_lastvisit`='$ctime' , `last_ip` ='$ipaddr' WHERE `user_id`='$setuid'" );
}

function YA_CoolSize($size) {
	$mb = 1024 * 1024;
	if ($size > $mb) {
		$mysize = sprintf ( "%01.2f", $size / $mb ) . " MB";
	} elseif ($size >= 1024) {
		$mysize = sprintf ( "%01.2f", $size / 1024 ) . " Kb";
	} else {
		$mysize = $size . " bytes";
	}
	return $mysize;
}

//Add karma System 
function change_karma($user_id, $karma) {
	global $admin, $user_prefix, $db, $module_name;
	if (! is_admin ( $admin )) {
		Header ( "location: index.php" );
		die ();
	} else {
		if ($user_id > 1) {
			$karma = intval ( $karma );
			$db->sql_query ( "UPDATE " . $user_prefix . "_users SET karma='$karma' WHERE user_id='$user_id'" );
			$row = $db->sql_fetchrow ( $db->sql_query ( "SELECT username FROM " . $user_prefix . "_users WHERE user_id='$user_id'" ) );
			$username = $row [username];
			Header ( "location: modules.php?name=$module_name&op=userinfo&username=$username" );
			die ();
		}
	}
}
//End karma system
function YA_MakePass() {
	$makepass = "";
	$strs = "abc2def3ghj4kmn5opq6rst7uvw8xyz9";
	for($x = 0; $x < 8; $x ++) {
		mt_srand ( ( double ) microtime () * 1000000 );
		$str [$x] = substr ( $strs, mt_rand ( 0, strlen ( $strs ) - 1 ), 1 );
		$makepass = $makepass . $str [$x];
	}
	return ($makepass);
}

function amain() {
	global $module_name;
	include ("modules/$module_name/admin/Showroom.php");
}

function asearch() {
	global $module_name, $bgcolor2, $bgcolor1, $textcolor1, $find, $what, $match, $query;
	OpenTable ();
	echo "<table align='center' cellpadding='2' cellspacing='2' border='0' bgcolor='$bgcolor1'>\n";
	echo "<form method='post' action='" . ADMIN_OP . "mod_users'>\n";
	echo "<input type='hidden' name='op' value='listresults'>\n";
	echo "<tr>\n";
	echo "<td align='center'><b>" . _YA_FIND . ":</b></td>\n";
	echo "<td align='center'><b>" . _YA_BY . ":</b></td>\n";
	echo "<td align='center'><b>" . _YA_MATCH . ":</b></td>\n";
	echo "<td align='center'><b>" . _YA_QUERY . ":</b></td>\n";
	echo "</tr>\n<tr>\n";
	if ($find == "tempUser") {
		$sel1 = "";
		$sel2 = " selected";
	} else {
		$sel1 = " selected";
		$sel2 = "";
	}
	echo "<td align='center'><select name='find'>\n";
	echo "<option value='findUser'$sel1>" . _YA_REGLUSER . "</option>\n";
	echo "<option value='tempUser'$sel2>" . _YA_TEMPUSER . "</option>\n";
	echo "</select></td>\n";
	if ($what == "user_email") {
		$sel1 = "";
		$sel2 = "";
		$sel3 = "";
		$sel4 = " selected";
	} elseif ($what == "user_id") {
		$sel1 = "";
		$sel2 = "";
		$sel3 = " selected";
		$sel4 = "";
	} elseif ($what == "name") {
		$sel1 = "";
		$sel2 = " selected";
		$sel3 = "";
		$sel4 = "";
	} else {
		$sel1 = " selected";
		$sel2 = "";
		$sel3 = "";
		$sel4 = "";
	}
	echo "<td align='center'><select name='what'>\n";
	echo "<option value='username' $sel1>" . _USERNAME . "</option>\n";
	echo "<option value='name' $sel2>" . _UREALNAME . "</option>\n";
	echo "<option value='user_id' $sel3>" . _USERID . "</option>\n";
	echo "<option value='user_email' $sel4>" . _EMAIL . "</option>\n";
	echo "</select></td>\n";
	if ($match == "equal") {
		$sel1 = "";
		$sel2 = " selected";
	} else {
		$sel1 = " selected";
		$sel2 = "";
	}
	echo "<td align='center'><select name='match'>\n";
	//@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
	echo "<option value='like' $sel1>" . _YA_LIKE . "</option>\n";
	echo "<option value='equal' $sel2>" . _YA_EQUAL . "</option>\n";
	echo "</select></td>\n";
	echo "<td align='center'><input type='text' name='query' value='$query' size='30' maxlength='60'></td>\n";
	echo "<td align='center'><input type='submit' value='" . _YA_SEARCH . "'></td>\n";
	echo "</tr>\n";
	echo "</form>\n";
	echo "</table>\n";
	CloseTable ();
}

function mmain($user) {
	global $stop,$user, $userinfo,$module_name, $redirect, $mode, $t, $f, $ya_config, $gfx_chk;
	if (!is_user ($user )) {
		include ("header.php");
		Show_CNBYA_menu ();
		OpenTable ();
		echo "<table border=\"0\"><form action=\"modules.php?name=$module_name\" method=\"post\">\n";
		echo "<tr><td>" . _NICKNAME . ":</td><td><input type=\"text\" dir='ltr' name=\"username\" value='".$userinfo['username']."' size=\"15\" maxlength=\"25\"></td></tr>\n";
		echo "<tr><td>" . _PASSWORD . ":</td><td><input type=\"password\" dir='ltr' name=\"user_password\" size=\"15\" maxlength=\"20\" AutoComplete=\"off\"></td></tr>\n";
		if (extension_loaded ( "gd" ) and ($gfx_chk == 2 or $gfx_chk == 5 or $gfx_chk == 7)) {
			echo "<tr><td colspan='2'>";
			global $wrong_code;
			if ($wrong_code)
				echo "<div style='color:red;'>" . _WRONG_CODE . "</div>";
			echo show_captcha () . "</td></tr>";
		}
		echo "<input type=\"hidden\" name=\"redirect\" value=$redirect>\n";
		echo "<input type=\"hidden\" name=\"mode\" value=$mode>\n";
		echo "<input type=\"hidden\" name=\"f\" value=$f>\n";
		echo "<input type=\"hidden\" name=\"t\" value=$t>\n";
		echo "<input type=\"hidden\" name=\"op\" value=\"login\">\n";
		echo "<tr><td colspan='2'><input type=\"submit\" value=\"" . _LOGIN . "\">";
		if ($ya_config ['useactivate'] == 0) {
			echo "<br>(" . _BESUREACT . ")\n";
		}
		echo "</td></tr></form></table><br>\n\n";
		CloseTable ();
		include ("footer.php");
	} elseif (is_user($user)) {
Header ( "Location: modules.php?name=$module_name&op=userinfo&username=" . $userinfo [username] . "" );
	}
}

function yapagenums($op, $totalselected, $perpage, $max, $find, $what, $match, $query) {
	global $module_name;
	$pagesint = ($totalselected / $perpage);
	$pageremainder = ($totalselected % $perpage);
	if ($pageremainder != 0) {
		$pages = ceil ( $pagesint );
		if ($totalselected < $perpage) {
			$pageremainder = 0;
		}
	} else {
		$pages = $pagesint;
	}
	if ($pages != 1 && $pages != 0) {
		$counter = 1;
		$currentpage = ($max / $perpage);
		echo "<table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
		echo "<tr><form action='" . ADMIN_OP . "mod_users' method='post'>\n";
		echo "<input type='hidden' name='op' value='$op'>\n";
		if ($what > "") {
			echo "<input type='hidden' name='what' value='$what'>\n";
		}
		if ($find > "") {
			echo "<input type='hidden' name='find' value='$find'>\n";
		}
		if ($match > "") {
			echo "<input type='hidden' name='match' value='$match'>\n";
		}
		if ($query > "") {
			echo "<input type='hidden' name='query' value='$query'>\n";
		}
		echo "<td align='center'><b>" . _YA_SELECTPAGE . ": </b><select name='min'>\n";
		while ( $counter <= $pages ) {
			$cpage = $counter;
			$mintemp = ($perpage * $counter) - $perpage;
			echo "<option value='$mintemp'>$counter</option>\n";
			$counter ++;
		}
		echo "</select><b> " . _YA_OF . " $pages " . _YA_PAGES . "</b> <input type='submit' value='" . _YA_GO . "'></td>\n</form>\n</tr>\n";
		echo "</table>\n";
	}
}

function disabled() {
	include ("header.php");
	OpenTable ();
	echo "<font class='option'>" . _ACTDISABLED . "</font>";
	CloseTable ();
	include ("footer.php");
}

function notuser() {
	include ("header.php");
	OpenTable ();
	echo "<font class='option'>" . _MUSTBEUSER . "</font>";
	CloseTable ();
	include ("footer.php");
}

//--broadcasting functions
function blog_content($bid, $tid, $content, $date, $like, $unlike, $sender_id, $sender_name, $reciever_id, $reciever_name) {
	global $userinfo, $db, $user, $admin, $aid;
	if (isset ( $username )) {
		$pageowner = "$username";
	}
	
	$Vote = $like - $unlike;
	$group = my_group ( $sender_name );
	$effectiveVote = $Vote > 0 ? "<span style='font-weight:bold;color:green'>+$Vote</span>" : "<span style='font-weight:bold;color:red'>$Vote</span>";
	$classforedit = ($userinfo ['user_id'] == $sender_id or $userinfo ['username'] == $pageowner or is_admin ( $admin )) ? 'class="edit_text"' : 'style="text-align:right;"';
	if ($userinfo ['user_id'] == $sender_id or $userinfo ['user_id'] == $reciever_id or is_admin ( $admin )) {
		if (empty ( $tid )) {
			$delete_button = '<br><span class="tags_blog"><a  href="javascript:root_delete(' . $bid . ')" id="' . $bid . '"  class="delete_update">' . _DELETE . '</a></span>';
		} else {
			$delete_button = '<br><span class="tags_blog"><a  href="javascript:comment_delete(' . $bid . ')" id="' . $bid . '" class="cdelete_update">' . _DELETE . '</a></span> ';
		}
		$edit_button = '<span class="tags_blog"><span  class="edit_button" id="' . $bid . '"><a href="javascript:edit_my_post(' . $bid . ')">' . _EDIT . '</a></span></span>';
	}
	if ($tid == 0) {
		$share_link = '<span class="tags_blog"><a  href="modules.php?name=Your_Account&op=share_it&bid=' . $bid . '&title=' . strip_tags ( $content ) . '" id="' . $bid . '" class="colorbox">' . _SHARE . '</a></span>';
		$permanant_link = '<span class="tags_blog"><a  href="modules.php?name=Your_Account&op=show_post&bid=' . $bid . '" >' . _YA_BLOG_PLINK . '</a></span>';
	}
?>
<div class="stcommentbody" id="stcommentbody<?php echo $bid; ?>" style='direction:<?php echo langStyle(direction)?>;'>
<div class="stcommentimg" style='text-align:<?php echo langStyle(align)?>;float:<?php echo langStyle(align)?>'>
<img src='<?php echo avatar_me ( $sender_name )?>' alt='<?php echo $sender_name?>' title='<?php echo $sender_name?>' class='small_face' /></a>
</div> 
<div class="stcommenttext" style='text-align:<?php echo langStyle(align)?>;'>
<b><?php echo $sender_name; ?></b> 		<div id="content<?php echo $bid;?>"><p><?php	echo analyse_content ( $content, 1, 1, 1 );?></p></div>
<br style="clear:both;margin:0;padding:0">
<div><?php echo $delete_button. $edit_button . $share_link  .$permanant_link  ."<span class=\"tags_blog\">$date</span>";

	if (is_user ( $user ) and $userinfo ['username'] != $sender_name) {
		$key = ! empty ( $tid ) ? $tid : $bid;
		$ralign = ((langStyle(align)=="right") ? "left" : "right");
		echo "<span class=\"tags_blog\" style='font-weight:700;$ralign:0;'>
		<a class='comment' href=\"javascript:replycomment($key)\" id=\"$key\" title=\"$sender_name\" alt='".$sender_name."'>"._REPLY."</a>
		</span>\n";
	}


	if ($_COOKIE ['vbs_nkln-' . $bid . ''] != '' . $bid . '' and $userinfo ['username'] != $sender_name) {
	?>
	<style>
	.jc_comment_panel li {float:<?php echo $ralign?>;}
	.jomentry1 {float:<?php echo $ralign?>;}
	</style>
	<div class="jomentry1" id="vote_buttons">
	<ul class="jc_comment_panel" class='vote_buttons'	id='vote_buttons<?php echo $bid?>'>
		<li class="jc_comment_panel_up"><a
			href="javascript:voteDown(<?php
			echo $bid?>)" class='vote_up'
			id='<?php
			echo $bid?>' title="<?PHP
			echo _YA_BLOG_VOTEUP?>"></a></li>
			<li class="jc_comment_panel_total" id="<?php echo $bid?>"><?php echo $effectiveVote?></li>
			<li class="jc_comment_panel_down"><a
			href="javascript:voteUp(<?php
			echo $bid?>)" class='vote_down'	id='<?php echo $bid?>' title="<?PHP echo _YA_BLOG_VOTEDOWN?>"></a>
			</li>
	</ul>
	</div>
	<span class='votes_count' id='votes_count<?php echo $bid?>'></span>
	<?php

	} else {
		?><div class="jomentry1" id="vote_buttons">
		<span	class='votes_count' id='votes_count<?php echo $bid?>'>
		<?php echo $effectiveVote?> <?php echo _VOTE?> 
		</span>
		</div>
		<?php
	}
	

?></div> 
</div>
</div>
<?php

	if (is_user ( $user ) and $userinfo ['username'] != $sender_name) {
		echo '
		<div class="comment_box" id="c' . $key . '">
		<form method="post" action="" name="' . $key . '">
		<textarea class="text_area" name="comment_value" id="textarea' . $key . '"></textarea>
		<input type="hidden" class="text_area" name="rec_id" id="rec_id' . $key . '" value="' . $reciever_id . '">
		<input type="submit" value=" ' . _SEND . ' " class="comment_submit" id="' . $key . '">
		</form>
		</div>
		<div class="clear"></div>
		';
	}
}
function count_blog_posts($bid, $user, $function) {
	global $db;
	
	switch ($function) {
		case "ALL" :
			$replysql = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE sender_name = '$user' or reciever_name ='$user' ORDER BY bid DESC" );
			break;
		
		case "BLOG_POSTS" :
			$replysql = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE sender_name = '$user' AND tid='0' ORDER BY bid DESC" );
			break;
		
		case "THIS_POST" :
			$replysql = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE tid = '$bid' ORDER BY bid DESC" );
			break;
	}
	
	$comment_count = $db->sql_numrows ( $replysql );
	
	return $comment_count;
}
function GET_USER_BLOG_CONFIG($username) {
	global $db, $prefix;
	
	$configblog = $db->sql_fetchrow ( $db->sql_query ( "SELECT user_blog_colors,user_blog_password,user_allowemails FROM " . __USER_TABLE . " WHERE  username='" . $username . "' limit 1 " ) );
	
	return $configblog;
}
function YB_Pagination($totalPages, $eachPage, $username) {
	
	global $blogPage;
	if (empty ( $blogPage )) {
		$blogPage = 1;
	}
	
	$totalPages = intval ( $totalPages );
	$Listpages = ceil ( $totalPages / $eachPage );
	
	if (! empty ( $totalPages ) and $Listpages > 1) {
		echo "<div id='pagination-digg' >";
		for($i = 1; $i < $Listpages + 1; $i ++) {
			if ($blogPage == $i) {
				echo "<a href=''  class=\"active\"><b>$i</b></a>";
			} else {
				echo "<a href='modules.php?name=Your_Account&op=userinfo&username=$username&blogPage=$i'><b>$i</b></a>";
			}
		}
		echo "</div> <br style='clear:both;margin:0px auto;'>";
	}

}
function live_Blog_pagination($totalnum, $eachPage) {
	
	global $pagenum;
	if (empty ( $pagenum )) {
		$pagenum = 1;
	}
	/*
	$totalPages = intval($totalPages);
	$Listpages = ceil($totalPages / $eachPage);
		
	if (!empty($totalPages) AND $Listpages>1 ) {
	echo "<div id='pagination-digg' >";
	for ($i=1; $i < $Listpages+1; $i++) {
	if ($blogPage==$i) {
		echo "<a href=''  class=\"active\"><b>$i</b></a>";
	}else {
		echo "<a href='modules.php?name=Your_Account&op=live_broadcast&page=$i'><b>$i</b></a>";
	}
	}
*/
	
	$storyhome = (empty ( $storyhome ) ? 5 : $storyhome);
	$eachsidenum = 1; // How many adjacent pages should be shown on each side?
	$totalnum = intval ( $totalnum );
	$numpages = ceil ( $totalnum / $storyhome );
	$lpm1 = $numpages - 1;
	$prevpage = $pagenum - 1;
	$nextpage = $pagenum + 1;
	$link = "modules.php?name=Your_Account&op=live_broadcast&page";
	
	echo "<div id='pagination-digg' >";
	if ($prevpage == 0) {
		echo '<a class="off">' . _YA_BLOG_PREVPAGE . ' »</a>';
	} else {
		echo "<a href=\"$link=$prevpage\">" . _YA_BLOG_PREVPAGE . "  »</a>";
	}
	
	if ($numpages < 7 + ($eachsidenum * 2)) //not enough pages to bother breaking it up
{
		for($counter = 1; $counter <= $numpages; $counter ++) {
			if ($counter == $pagenum)
				echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
			else
				echo "<a href=\"$link=$counter\"  >&nbsp;$counter&nbsp;</a>";
		}
	
	} elseif ($numpages > 5 + ($eachsidenum * 2)) //enough pages to hide some
{
		if ($pagenum < 1 + ($eachsidenum * 2)) {
			for($counter = 1; $counter < 4 + ($eachsidenum * 2); $counter ++) {
				if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
				else
					echo "<a href=\"$link=$counter\">&nbsp;$counter&nbsp;</a>";
			}
			echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
			echo "<a href=\"$link=$lpm1\"  >&nbsp;$lpm1&nbsp;</a>";
			echo "<a href=\"$link=$numpages\" >&nbsp;$numpages&nbsp;</a>";
		} elseif ($numpages - ($eachsidenum * 2) > $pagenum && $pagenum > ($eachsidenum * 2)) {
			echo "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
			echo "<a href=\"$link=2\"  >&nbsp;2&nbsp;</a>";
			echo "&nbsp; <a href=\"\">&nbsp; ... &nbsp;</a>&nbsp;";
			for($counter = $pagenum - $eachsidenum; $counter <= $pagenum + $eachsidenum; $counter ++) {
				if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
				else
					echo "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
			}
			echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
			echo "<a href=\"$link=$lpm1\" >&nbsp;$lpm1&nbsp;</a>";
			echo "<a href=\"$link=$numpages\" >&nbsp;$numpages&nbsp;</a>";
		} //close to end; only hide early pages
		else {
			echo "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
			echo "<a href=\"$link=2\" >&nbsp;2&nbsp;</a>";
			echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
			for($counter = $numpages - (2 + ($eachsidenum * 2)); $counter <= $numpages; $counter ++) {
				if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
				else
					echo "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
			}
		}
	}
	
	if ($nextpage > $numpages) {
		echo '<a class="off">« ' . _YA_BLOG_NEXTPAGE . '';
	} else {
		echo "<a href=\"$link=$nextpage\">« " . _YA_BLOG_NEXTPAGE . "</a>";
	}
	
	echo "</div>";
}
function live_broadcasting($page = '1') {
	global $db, $prefix, $user, $userinfo;
	
	//start_to_be_live
	$smstart = (! empty ( $_POST ['start'] ) ? hejridate ( date ( "Y-m-j H:i:s", $_POST ['start'] ), 4, 7 ) : 0);
	$ctime_str = time ();
	$differ_time = distanceOfTimeInWords ( $_POST ['start'], $ctime_str, true );
	$ctime = date ( "Y-m-j H:i:s" );
	define ( "BLOG_POST_IN_PAGE", 15 );
	$offset = ($page - 1) * BLOG_POST_IN_PAGE;
	if (! empty ( $_POST ['start'] )) {
		echo "<br>
	<img src='images/icon/time.png'>زمان کنونی :  " . hejridate ( date ( "Y-m-j H:i:s" ), 4, 7 ) . "<br>
	<img src='images/icon/control_play.png'> زمان شروع پخش زنده :  " . $smstart . " <br>
	<img src='images/icon/time.png'> مدت زمان گذشته : <b> $differ_time</b><br>
	 <img src='images/icon/time.png'>به روز رسانی هر  :  <b>60</b> ثانیه <br>
	<br>
	 ";
	}
	
	//-- LIST BLOG POSTS ---------------------
	

	$result = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE  tid='0' ORDER BY bid DESC 
limit $offset, " . BLOG_POST_IN_PAGE . "
" );
	$numit = $db->sql_numrows ( $result );
	$blog_name = ! empty ( $userrow [name] ) ? $userrow [name] : $Rusername;
	if (! empty ( $numit )) {
		echo "<div class='ucp_block_header'  title='$Rusername' id='BlogUsername' ><b>" . _LATESTBLOGPOSTS . " $blog_name</b></div>\n\n";
	}
	?>
<script type="text/javascript" language="JavaScript"
	src="modules/Your_Account/includes/style/jeditable.js"></script>
<script type="text/javascript" language="JavaScript"
	src="modules/Your_Account/includes/style/YABC.js"></script>
<script type="text/javascript" language="JavaScript"
	src="modules/Your_Account/includes/style/jquery.oembed.js"></script>

<div id="flash"></div>
<!-- LODING UPDATE -->
<div style='width: 98%;'><!-- BLOG CONTAINER-->
<ol id="update" class="timeline">
	<!-- UPDATE BLGO POSTS -->
</ol>
<!-- CLOSE UPDATE PAGE--></div>
<!-- CLOSE BLOG CONTAINER-->

<?php
	while ( $row = $db->sql_fetchrow ( $result ) ) {
		
		$BlogNum = sql_quote ( intval ( $row ['COUNT(bid)'] ) );
		$bid = sql_quote ( intval ( $row ['bid'] ) );
		$tid = sql_quote ( intval ( $row ['tid'] ) );
		$content = stripslashes ( FixQuotes ( $row ['content'] ) );
		$date = hejridate ( $row ['date'], 1, 3 );
		$like = sql_quote ( intval ( $row ['like'] ) );
		$unlike = sql_quote ( intval ( $row ['unlike'] ) );
		
		$sender_id = $row ['sender'];
		$sender_name = $row ['sender_name'];
		$reciever_id = $row ['reciever'];
		$reciever_name = $row ['reciever_name'];
		$comment_count = count_blog_posts ( $bid, $Rusername, 'THIS_POST' );
		
		echo "<li class='bar$bid'>\n
	<div  class='post' style='overflow:visible; display:block;' >\n";
		blog_content ( $bid, $tid, $content, $date, $like, $unlike, $sender_id, $sender_name, $reciever_id, $reciever_name );
		
		if ($comment_count > 0) {
			?>
<div class="comment_ui" id="view<?php
			echo $bid;
			?>"
	style="text-align: left; float: left; background: #CCE1FF; padding: 5px; border: 2px solid #6EB6F1; border-bottom: 0px;">
<img src='images/icon/tag_green.png'> <a href="#" class="view_comments"
	id="<?php
			echo $bid;
			?>">  <?php
			echo $comment_count;
			?> دیدگاه </a></div>
<?php
		}
		echo '</div><br>';
		?><div class="clear"></div><?php
		
		//-- Reply 1st -------------------
		

		?>
<div id="fullbox" class="fullbox<?php
		echo $bid;
		?>">
<div id="commentload<?php
		echo $bid;
		?>"></div>
</div>
<div id="view_comments<?php
		echo $bid;
		?>"
	style="border: 2px solid #6EB6F1; background: #CCE1FF; border-top: 0px;"></div>
<?php
		echo "</li>\n\n";
		echo '<div style="margin:0px auto;clear:both;"></div>';
	}
	$db->sql_freeresult ( $result );
	
	$result = $db->sql_query ( "SELECT COUNT(`bid`) FROM " . BLOG_TABLE . " WHERE `sender`=`reciever` LIMIT 1 " );
	list ( $BlogNum ) = $db->sql_fetchrow ( $result );
	live_Blog_pagination ( $BlogNum, BLOG_POST_IN_PAGE );
	$db->sql_freeresult ( $result );
}
//show list of blogs related to the variable that are sent through
function show_latest_blog($blog_userid, $blog_username, $user_blog_password, $user_blog_colors, $offset, $eachPage, $blogPage) {
	
	global $db, $userinfo, $admin, $blogPage, $prefix;
	
	$blogPagez = (empty ( $blogPage ) ? 1 : $blogPage);
	$offsetz = ($blogPagez - 1) * $eachPage;
	$user_blog_colors = explode ( "#", $user_blog_colors );
	
	$result = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE sender = '$blog_userid' AND tid='0'
ORDER BY bid DESC LIMIT $offsetz,$eachPage" );
	$numit = $db->sql_numrows ( $result );
	echo "<div class='ucp_block_header'  title='$blog_username' id='BlogUsername' ><b>" . _LATESTBLOGPOSTS . " $blog_username</b>   
	<a href='modules.php?name=Your_Account&op=userinfo&username=demo&blogPage=1' onclick=\"javascript:refresh_blog(" . $blog_userid . "); return false;\" ><img src='images/icon/arrow_refresh.png' alt='refresh' title='" . _YA_BLOG_REFRESH . "'></a>
	";
	if ($userinfo ['username'] == $blog_username) {
		echo '<h4 style="float:'.langStyle('align').';text-align:'.langStyle('align').';margin-left:10px"><img src="images/icon/bricks.png"><a href="modules.php?name=Your_Account&op=edituser" class="setting_button" onclick=\'javascript:setting_blog(' . $blog_userid . '); return false;\'>' . _YA_BLOG_SETTING . '</a></h4>';
	}
	echo "</div>\n\n";
	
	echo '<div id="flash" ></div> <!-- LODING UPDATE -->
	<div style="width:98%;"><!-- BLOG CONTAINER-->
		<ol  id="update" class="timeline"><!-- UPDATE BLGO POSTS -->
		</ol><!-- CLOSE UPDATE PAGE-->
	</div><!-- CLOSE BLOG CONTAINER-->
	';
	if ($userinfo ['username'] == $blog_username) {
		echo '<div id="setting" title="' . $blog_username . '" class="BlogSetting"></div>';
	}
	
	if (! empty ( $numit )) {
		
		while ( $row = $db->sql_fetchrow ( $result ) ) {
			
			$bid = sql_quote ( intval ( $row ['bid'] ) );
			$tid = sql_quote ( intval ( $row ['tid'] ) );
			$content = stripslashes ( FixQuotes ( $row ['content'] ) );
			$date = hejridate ( $row ['date'], 1, 3 );
			$like = sql_quote ( intval ( $row ['like'] ) );
			$unlike = sql_quote ( intval ( $row ['unlike'] ) );
			
			$sender_id = $row ['sender'];
			$sender_name = $row ['sender_name'];
			$reciever_id = $row ['reciever'];
			$reciever_name = $row ['reciever_name'];
			
			$usrblogcolor = ((get_brightness ( $user_blog_colors [1] ) > 125) ? "black" : "white");
			$usrblogcolor2 = ((get_brightness ( $user_blog_colors [2] ) > 125) ? "black" : "white");
			$usrblogcolor3 = ((get_brightness ( $user_blog_colors [3] ) > 125) ? "black" : "white");
			$fontColorReply = ($reply_sender_name == $username) ? "" . $usrblogcolor3 . "" : "" . $usrblogcolor2 . "";
			
			?>
<style type="text/css">
.BPostRow a:link {
	color: <?php echo $usrblogcolor?>
}

.tags_blog a:link {
	color: black;
}
</style>
<?php
			echo "<li class='bar$bid'>\n
			<div style='background:#" . $user_blog_colors [1] . ";color:$usrblogcolor' class='BPostRow'>\n";
			blog_content ( $bid, $tid, $content, $date, $like, $unlike, $sender_id, $sender_name, $reciever_id, $reciever_name );
			echo '</div>';
			echo '<div class="clear"></div>';
			
			//-- Reply 1st -------------------
			$comment_count = count_blog_posts ( $bid, $blog_username, 'THIS_POST' );
			echo '
<div id="fullbox" class="fullbox' . $bid . '">
	<div id="commentload' . $bid . '" ></div>
</div>  
<div id="view_comments' . $bid . '"></div>
<div id="two_comments' . $bid . '">
';
			
			$replysqlrez = $db->sql_query ( "SELECT * FROM " . BLOG_TABLE . " WHERE tid = '$bid' ORDER BY bid DESC limit 3 " );
			
			while ( $replyrow = $db->sql_fetchrow ( $replysqlrez ) ) {
				$reply_sender_id = $replyrow ['sender'];
				$reply_sender_name = $replyrow ['sender_name'];
				$reply_reciever_id = $replyrow ['reciever'];
				$reply_reciever_name = $replyrow ['reciever_name'];
				$reply_bid = $replyrow ['bid'];
				$reply_tid = $replyrow ['tid'];
				$content_r1 = stripslashes ( FixQuotes ( $replyrow ['content'] ) );
				$date_r1 = hejridate ( $replyrow ['date'], 1, 3 );
				$like_r1 = sql_quote ( intval ( $replyrow ['like'] ) );
				$unlike_r1 = sql_quote ( intval ( $replyrow ['unlike'] ) );
				
				$classReply = ($reply_sender_name == $blog_username) ? "BAdminReplyRow" : "BReplyRow";
				$ColorReply = ($reply_sender_name == $blog_username) ? "" . $user_blog_colors [3] . "" : "" . $user_blog_colors [2] . "";
				$fontColorReply = ($reply_sender_name == $username) ? "" . $usrblogcolor3 . "" : "" . $usrblogcolor2 . "";
				
				?>
<style type="text/css">
<?php 

   echo $classReply?>a:link {
	color: <?php echo $fontColorReply?>
}

.tags_blog a:link {
	color: black;
}
</style>
<?php
				echo "<div style='background:#" . $ColorReply . ";color:$fontColorReply'  class='$classReply'  id='comment$reply_bid'>";
				blog_content ( $reply_bid, $reply_tid, $content_r1, $date_r1, $like_r1, $unlike_r1, $reply_sender_id, $reply_sender_name, $reply_reciever_id, $reply_reciever_name );
				echo '</div>
	<div class="clear"></div>';
			
			}
			$db->sql_freeresult ( $replysqlrez );
			
			if ($comment_count > 3) {
				$second_count = $comment_count - 3;
				echo '
	<div class="comment_ui" id="view' . $bid . '">
	<img src="images/icon/shape_flip_vertical.png">	<a href="javascript:view_comments(' . $bid . ');" class="view_comments" id="' . $bid . '"> ' . _YA_BLOG_VIEWALL . '(' . $comment_count . ')
	</a>
	</div>
';
			} else {
				$second_count = 0;
			}
			echo "</div>\n";
			echo "</li>\n\n";
		}
		$db->sql_freeresult ( $result );
	} else {
		echo "<div id='noblogpost'>
	<img src='images/icon/error.png'>
	" . _YA_NOBLOGPOST . "
	</div>";
	}
	
	echo '<br style="margin:0px auto;clear:both;">';
	
	echo "<div class='ucp_block_header'>";
	if ($userinfo ['username'] == $blog_username) {
		echo "<img src='images/icon/shape_align_bottom.png'>
" . _YA_TOTAL_POSTS . ":<b> " . count_blog_posts ( 0, $blog_username, 'ALL' ) . "</b>
<img src='images/icon/chart_pie.png'>
" . _YA_BLOG_POSTS . "<b> " . count_blog_posts ( 0, $blog_username, 'BLOG_POSTS' ) . "</b>
";
	}
	
	echo "<a href='feed.php?mod=Blog&username=$blog_username'><span style='padding-right:10px;'>
	<img src='images/icon/rss.png' alt='rss' title='" . _YA_BLOG_RSS . "' >" . _YA_BLOG_RSS . "</span></a>";
	echo "<a href='modules.php?name=Your_Account&op=make_PDF&username=$blog_username'><span style='padding-right:10px;'>
	<img src='images/icon/pdf.png' ALT='PDF' TITLE='" . _YA_BLOG_PDF . "'>" . _YA_BLOG_PDF . "   </span></a>";
	if ($userinfo ['username'] == $blog_username or is_superadmin ( $admin )) {
		echo "<a style='color:red' href='modules.php?name=Your_Account&op=flush_blog' onclick=\"javascript:flush_blog(" . $blog_userid . "); return false;\">
		<img src='images/icon/cross.png' alt='delete' TITLE='" . _YA_BLOG_TRUNCATE . "'><b>" . _YA_BLOG_TRUNCATE . "</b></a>";
	}
	echo "</div>";
	echo "<br>";
	$blogposts = count_blog_posts ( 0, $blog_username, 'BLOG_POSTS' );
	YB_Pagination ( $blogposts, 5, $blog_username );

}
//show post box
function blog_post_box() {
	$parser = new SimpleParser ();
	$blog_post_box .= "<center><div class='Postblog'> ";
	$blog_post_box .= "<form action=\"modules.php?name=$module_name\" method=\"post\">";
	$blog_post_box .= "<input type=\"hidden\" name=\"op\" value=\"broadcast\">";
	$blog_post_box .= "<input type=\"hidden\" name=\"action\" value=\"blog_post\">";
	$blog_post_box .= "" . _WHATSONMIND . "<textarea style=''  name=\"the_message\" id='the_message' class='txtar' ></textarea>
        <input type=\"checkbox\" name=\"pm\"  id=\"pm\" value=\"pm\" > " . _PUBLIC_MESSAGE . "
        <div id='button_the_message'  style='text-align:center;position:relative;margin:0px auto;'> 
        <input type=\"submit\"  id='v' name='submit' class='comment_button'  value=\"" . _SEND . "\">
        <input type='submit' id='cancel' value=' " . _CANCEL . "' /> " . '
      <a href="javascript:show_smiley()" id="show_smiley" class="button" />' . _SMILEY . ' </a>  
      <div id="smiley_div" class="smiley_box">';
	$blog_post_box .= $parser->read_smiley_dir ();
	$blog_post_box .= '</div>' . "
<div style='text-align:right;position:relative;'><div id='counter'>200</div>
<div id='barbox'><div id='bar'></div></div></div><div style='clear:both;'></div>
        </div> ";
	$blog_post_box .= "</form></div></center><br>";
	
	return $blog_post_box;
}

/// Validation Functions for Registration	
function get_brightness($hex) {
	// returns brightness value from 0 to 255
	

	// strip off any leading #
	//$hex = str_replace('#', '', $hex);
	

	$c_r = hexdec ( substr ( $hex, 0, 2 ) );
	$c_g = hexdec ( substr ( $hex, 2, 2 ) );
	$c_b = hexdec ( substr ( $hex, 4, 2 ) );
	
	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}
function checkRealname($ya_realname) {
	
	$length = strlen ( $ya_realname );
	
	if ($length < 4) {
		
		return false;
	
	}
	
	return true;

}
function checkUsername($ya_username) {
	
	$length = strlen ( $ya_username );
	
	if ($length < 4) {
		
		return false;
	
	}
	
	return true;

}
function check_email_address($ya_email) { // First, we check that there's one @ symbol, and that the lengths are right
	$isValid = true;
	$atIndex = strrpos ( $email, "@" );
	if (is_bool ( $atIndex ) && ! $atIndex) {
		$isValid = false;
	} else {
		$domain = substr ( $email, $atIndex + 1 );
		$local = substr ( $email, 0, $atIndex );
		$localLen = strlen ( $local );
		$domainLen = strlen ( $domain );
		if ($localLen < 1 || $localLen > 64) {
			$isValid = false;
		} else if ($domainLen < 1 || $domainLen > 255) {
			$isValid = false;
		} else if ($local [0] == '.' || $local [$localLen - 1] == '.') {
			$isValid = false;
		} else if (preg_match ( '/\\.\\./', $local )) {
			$isValid = false;
		} else if (! preg_match ( '/^[A-Za-z0-9\\-\\.]+$/', $domain )) {
			$isValid = false;
		} else if (preg_match ( '/\\.\\./', $domain )) {
			$isValid = false;
		} else if (! preg_match ( '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace ( "\\\\", "", $local ) )) {
			if (! preg_match ( '/^"(\\\\"|[^"])+"$/', str_replace ( "\\\\", "", $local ) )) {
				$isValid = false;
			}
		}
		if (! function_exists ( 'version_compare' ) || version_compare ( phpversion (), '5', '<' )) {
		} else {
			if ($isValid && ! (checkdnsrr ( $domain, "MX" ) || checkdnsrr ( $domain, "A" ))) {
				$isValid = false;
			}
		}
	
	}
	return $isValid;

}
function checkPassword($ya_password) {
	
	$length = strlen ( $ya_password );
	
	if ($length < 4) {
		
		return false;
	
	}
	
	return true;

}
function check_captcha_c($captcha_code) { // this one checks whether the entered code is right or not
	session_start ();
	include_once 'includes/captcha/securimage.php';
	$securimage = new Securimage ();
	if ($securimage->check ( $captcha_code ) == false) {
		ErrorDIV ( "<p style=\"color: red\"> " . SECURITY_CODE_FAILED . "</p>" );
	}
	session_destroy ();
}
function ErrorDIV($value) {
	OpenTable ();
	echo $value;
	echo _GOBACK;
	CloseTable ();
	include ("footer.php");
}
function validEmail($email) {
	$isValid = true;
	$atIndex = strrpos ( $email, "@" );
	if (is_bool ( $atIndex ) && ! $atIndex) {
		$isValid = false;
	} else {
		$domain = substr ( $email, $atIndex + 1 );
		$local = substr ( $email, 0, $atIndex );
		$localLen = strlen ( $local );
		$domainLen = strlen ( $domain );
		if ($localLen < 1 || $localLen > 64) {
			// local part length exceeded
			$isValid = false;
		} else if ($domainLen < 1 || $domainLen > 255) {
			// domain part length exceeded
			$isValid = false;
		} else if ($local [0] == '.' || $local [$localLen - 1] == '.') {
			// local part starts or ends with '.'
			$isValid = false;
		} else if (preg_match ( '/\\.\\./', $local )) {
			// local part has two consecutive dots
			$isValid = false;
		} else if (! preg_match ( '/^[A-Za-z0-9\\-\\.]+$/', $domain )) {
			// character not valid in domain part
			$isValid = false;
		} else if (preg_match ( '/\\.\\./', $domain )) {
			// domain part has two consecutive dots
			$isValid = false;
		} else if (! preg_match ( '/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace ( "\\\\", "", $local ) )) {
			// character not valid in local part unless 
			// local part is quoted
			if (! preg_match ( '/^"(\\\\"|[^"])+"$/', str_replace ( "\\\\", "", $local ) )) {
				$isValid = false;
			}
		}
		if (function_exists ( "checkdnsrr" )) {
			if ($isValid && ! (checkdnsrr ( $domain, "MX" ) || checkdnsrr ( $domain, "A" ))) {
				// domain not found in DNS
				$isValid = false;
			}
		}
	}
	return $isValid;
}

?>