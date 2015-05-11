<?php

/**
*
* @package MicroBlogging System														
* @version $Id: 3:52 PM 7/18/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php"))
{
	header("Location: ../../../index.php");
	die();
}
if (!defined('CNBYA'))
{
	echo "CNBYA protection";
	exit;
}

define("BLOG_POST_LIMIT", 50); //Change if you like to have more blog posts 
include("modules/Your_Account/includes/constants.php");

function postlimit_validator()
{
	global $db, $userinfo, $log;
	$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM " . BLOG_TABLE .
	" WHERE `sender_name`='" .  $userinfo['username'] . "'  AND `reciever_name`='" . $userinfo['username'] . "'"));
	if ($numrows > BLOG_POST_LIMIT)
	{
		define("LOG_INC",YES);
		$log->lwrite('users', "" . $userinfo['username'] ._YA_BLOG_LIMITATION);
		show_error("You reach " . BLOG_POST_LIMIT .
		_YA_BLOG_LIMITATION . BLOG_POST_LIMIT .
		"<br>"._YA_BLOG_LIMITATION_DELETE_SOME);
	}

}
function blog_post()
{
	global $db, $user,$prefix, $module_name,$the_message, $Rusername,$userinfo;

	$blogconfig = GET_USER_BLOG_CONFIG($userinfo['username']);
	$user_blog_colors = array();
	$user_blog_colors = explode("#",$blogconfig[user_blog_colors]);
	$blogPage = sql_quote($_GET['blogPage']);
	if (is_user($user)) {
	if($_POST['content'])
	{
		$the_message= strip_tags($_POST['content']);

		$sender_name = $userinfo['username'];
		$sender_id = $userinfo['user_id'];
		$numrows = $db->sql_numrows($db->sql_query("SELECT * FROM " . $prefix .
		"_public_messages WHERE who='" .$userinfo['username']. "' "));

		$pm = $_POST[pm];
		if ($pm==1)
		{
			//-------- START OF PUBLIC MESSAGING----------//

			if ($numrows == 0)
			{
				$date = date("Y-m-j H:i:s");
				$db->sql_query("INSERT INTO ".$prefix."_public_messages (content, date, who) VALUES ('$the_message','$date' ,'".$userinfo['username']."')") or die(mysql_error());
				update_points(20);
				echo "<center><div class='success'>" . _BROADCASTSENT . "<br><br></div></center>";
			}
			else
			{
				echo "<center><div class='error'>" . _BROADCASTNOTSENT . "<br><br></div></center>";
			}

		}
		else
		{
			//-------- START OF BLOG ROLLING-----------//
			postlimit_validator();
			// repeated input check
			$check = $db->sql_fetchrow($db->sql_query('SELECT COUNT(*) FROM '.BLOG_TABLE.' WHERE `sender` = "'.sql_quote($sender_id).'" AND `content` = "'.sql_quote($the_message).'"'));
			if(!empty($check[0])) {
				?>
				<script type="text/javascript">
				$(document).ready(function(){$('div#errorBlog').fadeOut(6500);});
				</script>
				<?php
				
				echo "<div style='padding:5px;color:#C90022;background:#E5B3BD;border:1px solid #C90022;' id='errorBlog'>";
				echo REPEATED_INPUT; 
				echo "</div>\n";
				echo "</li>\n";
				return false;
			}
			$db->sql_query("INSERT INTO " . BLOG_TABLE . " VALUES (NULL,'0', '" .sql_quote($the_message) ."', now(),
		 '" . sql_quote($sender_id) ."', '" . sql_quote($sender_name) ."',
		  '" . sql_quote($sender_id) ."','" . sql_quote($sender_name) . "'
			 ,'0','0')") or die(mysql_error());
				update_points(1);
				?>	<script type="text/javascript">	show_my_blog(<?php echo intval($sender_id)?>,<?php echo intval($blogPage)?>);	</script>		<?php

		}

	}
	else
	{
		die("متن ورودی معتبر نیست");

	}
	}else {
				 show_error(_NOTSUB."<br>"._ASREGISTERED);
	}
	
}
function blog_reply()
{
	global $db,$user, $prefix,$sitename,$module_name,$siteurl,$userinfo;
	$blogPage = sql_quote($_GET['blogPage']);
	if (is_user($user)) {

	if(isSet($_POST['comment_content']))
	{
		$the_message= strip_tags($_POST['comment_content']);
		
		$tid=  sql_quote($_POST['bid']);
		$recipient=  sql_quote($_POST['recipient']);
		
		if (empty($recipient)) {
			die("no reciver;");
		}
		$sender_name = $userinfo['username'];
		$sender_id = $userinfo['user_id'];


		list($reciver_name_r,$user_email_reply) = $db->sql_fetchrow($db->sql_query("SELECT `username`,`user_email`  FROM ".__USER_TABLE." WHERE `user_id`='$recipient'"))or die(mysql_error());

		$blogconfig = GET_USER_BLOG_CONFIG($reciver_name_r);
		$user_blog_colors = array();
		$user_blog_colors = explode("#",$blogconfig[user_blog_colors]);

		//-------- START OF BLOG REPLYINH-----------//
		// repeated input check
		$check = $db->sql_numrows($db->sql_query('SELECT bid FROM '.BLOG_TABLE.' WHERE `sender` = "'.sql_quote($sender_id).'" AND `content` = "'.sql_quote($the_message).'"'));
		if($check > 0) {
				?>
				<script type="text/javascript">
				$(document).ready(function(){$('div#errorBlog').fadeOut(5500);});
				</script>
				<?php
				echo "<center>";
				echo "<div style='padding:5px;color:#C90022;background:#E5B3BD;border:1px solid #C90022;' id='errorBlog'>";
				echo REPEATED_INPUT;
				echo "</div>\n";
				echo "</li>\n";
			return false;
		}
		
		$db->sql_query("INSERT INTO " . BLOG_TABLE . " VALUES (NULL,'$tid','" . stripslashes(FixQuotes($the_message)) . "', now(),
		 '" . sql_quote($sender_id) ."', '" . sql_quote($sender_name) ."',
		  '" . sql_quote($recipient) ."','" . sql_quote($reciver_name_r) . "',
		  '0','0')") or die(mysql_error());
				update_points(2);

		$bid = mysql_insert_id();

		if ($blogconfig["user_allowemails"] == 1) {
			//-- email To the Reciever---
			$to      = ''.$user_email_reply.'';
			$subject = 'پاسخی برای پست شما در وبلاگ سایت '.$sitename.'';
			$message = 'با سلام <br>پاسخی به مطلب شما در وبلاگ سایت  '.$sitename.' ارسال شده است . <br> مشاهده 
			آدرس پست : 
			'.USV_DOMAIN.'/modules.php?name=Your_Account&op=show_post&bid='.$tid.'';

		$message = Mail_AddStyle($message);
		@mail($to, $subject, $message, "From: ".$userinfo['user_email']."\nContent-Type: text/html; charset=utf-8");
		}
		//Header("Location: modules.php?name=$module_name&op=userinfo&username=$username_reply");
		echo "<center>";

		$classReply = ($sender_name==$reciver_name_r) ? "BAdminReplyRow" :  "BReplyRow";
		$ColorReply = ($sender_name==$reciver_name_r) ? "".$user_blog_colors[3]."" :  "".$user_blog_colors[2]."";

		?><script type="text/javascript">	show_my_blog(<?php echo $recipient?>,<?php echo intval($blogPage)?>);	</script>		<?php
	}
			
	}else {
				 show_error(_NOTSUB."<br>"._ASREGISTERED);
	}
}
function blog_del($bid)
{
	global $db, $module_name, $userinfo, $user, $admin,$log,$aid;
	$blogPage = sql_quote($_GET['blogPage']);
	if($_POST['bid'])
	{
		if (is_user($user)) {

		$id= sql_quote($_POST['bid']);

		list($tid,$sender, $reciever, $reciever_name) = $db->sql_fetchrow($db->sql_query("SELECT tid,sender,reciever,reciever_name FROM " .
		BLOG_TABLE . " WHERE bid = '" .$id. "'"));

		if ($userinfo['user_id'] = $sender or $userinfo['user_id'] = $reciever OR is_superadmin($admin))
		{
			$db->sql_query("DELETE FROM " . BLOG_TABLE . " WHERE bid='$id'") or	show_error(mysql_error());
			$db->sql_query("DELETE FROM " . BLOG_TABLE . " WHERE tid='$id'") or show_error(mysql_error());
			//delete posted blog point
			update_points(1,'-');
		?>	<script type="text/javascript">	show_my_blog(<?php echo $reciever?>,<?php echo intval($blogPage)?>);	</script>
		<?php
		}
		else
		{
			define("LOG_INC",YES);
			$log->lwrite('users', "" . $userinfo['username'] .
			"دسترسی لازم برای حذف این مطلب را ندارید");
			echo "دسترسی لازم برای حذف این مطلب را ندارید";
		}
	}
	}else {
			header("Location: index.php");
	}
}
function blog_edit()
{
	global $db, $module_name, $userinfo, $user, $admin, $log,$aid;
	if (is_user($user)) {
	$id = $_POST['bid'];
	$value = $_POST['edit_message'];
	$value=analyse_content($value,1,1,1);
	
	if($id && $value)
	{
		$id = sql_quote($id);

		list($sender, $reciever) = $db->sql_fetchrow($db->sql_query("SELECT sender,reciever FROM " .
		BLOG_TABLE . " WHERE tid = '" . sql_quote($bid) . "'"));
		
		if ($userinfo['user_id'] = $sender or $userinfo['user_id'] = $reciever OR is_superadmin($admin))
		{

			$sql = "update  " . BLOG_TABLE . " set content='$value' where bid='$id'";
			$db->sql_query($sql);

		}
		else{
			die("دسترسی لازم برای ویرایش این مطلب را ندارید");

		}
		echo $value;
	}else {
			header("Location: index.php");
	}

	}else {
		 die(_NOTSUB."<br>"._ASREGISTERED);
	}

}
function show_more_comments(){
	global $db, $prefix,$userinfo;
	if(isSet($_POST['msg_id']))
	{
		$tid=sql_quote($_POST['msg_id']);
		$username=$_POST['username'];
		$configblog = GET_USER_BLOG_CONFIG($username);
		$user_blog_colors = array();
		$user_blog_colors = explode("#",$configblog['user_blog_colors']);

		echo "<div id='all_comments'>";
		echo '<a href="javascript:view_comments_close('.$tid.');"  >
		<img src="images/icon/cross.png" alt="X" title-"'._CLOSE.'"></a>';
		$com=$db->sql_query("SELECT * FROM " . BLOG_TABLE . " WHERE tid = '$tid'  ORDER BY bid ASC ");
		$comment_count= $db->sql_numrows($com);
		while($r=$db->sql_fetchrow($com))
		{
			$reply_sender_id = $r['sender'];
			$reply_sender_name= $r['sender_name'];
			$reply_reciever_id = $r['reciever'];
			$reply_reciever_name = $r['reciever_name'];
			$reply_bid = $r['bid'];
			$reply_tid = $r['tid'];
			$content_r1 = stripslashes(FixQuotes($r['content']));
			$date_r1 = hejridate($r['date'],1,3);
			$like_r1 = sql_quote(intval($r['like']));
			$unlike_r1 = sql_quote(intval($r['unlike']));
			$usrblogcolor2 = ((get_brightness($user_blog_colors[2]) > 125) ? "black" : "white");
			$usrblogcolor3 = ((get_brightness($user_blog_colors[3]) > 125) ? "black" : "white");


			$classReply = ($reply_sender_name==$username) ? "BAdminReplyRow" :  "BReplyRow";
			$ColorReply = ($reply_sender_name==$username) ? "".$user_blog_colors[3]."" :  "".$user_blog_colors[2]."";
			$fontColorReply = ($reply_sender_name==$username) ? "".$usrblogcolor3."" :  "".$usrblogcolor2."";
			echo "<div style='background:#".$ColorReply.";color:$fontColorReply'  class='$classReply'  id='comment$reply_bid'>";
			blog_content($reply_bid,$reply_tid,$content_r1,$date_r1,$like_r1,$unlike_r1,$reply_sender_id,$reply_sender_name,$reply_reciever_id,$reply_reciever_name);
			echo '</div>';

		}
		echo '</div>';
		
	}else {
			header("Location: index.php");
	}
}
function show_my_blog(){
	global $db,$prefix;
	$username = sql_quote($_POST[blog_username]);
	$userid = sql_quote($_POST[blog_userid]);
	$Page = sql_quote($_POST[page]);
	
	if (empty($userid)) {
			header("Location: index.php");
	}else {
		$result =  $db->sql_query(
		"SELECT user_id,username,user_blog_password,user_blog_colors FROM ".__USER_TABLE." WHERE  user_id='".$userid."' limit 1 "
		);
		$row = $db->sql_fetchrow($result);
		$username = (empty($username) ? $row[username] : $username);
		$db->sql_freeresult($result);
		echo show_latest_blog($userid,$username,$row[user_blog_password],$row[user_blog_colors],$offset,5,$Page);
	}

	
}
function share_it($bid,$title){
global $prefix, $db, $name, $pagetitle, $nukeurl;
include_once("includes/inc_bookmark.php");
$content .= "<br><h3 style='text-align:center;'>"._YA_BLOG_SHARE."</h3>
<center><div styl='width:90%;margin:30px;'><br>";

$_SERVER['FULL_URL'] = 'http';
if($_SERVER['HTTPS']=='on'){
  $_SERVER['FULL_URL'] .=  's';
}
$_SERVER['FULL_URL'] .=  '://';
if($_SERVER['SERVER_PORT']!='80')
  $_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'].$_SERVER['SCRIPT_NAME'];
else
  $_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
if($_SERVER['QUERY_STRING']>' ')
{
  $_SERVER['FULL_URL'] .=  '?'.$_SERVER['QUERY_STRING'];
}

$blogurl = $_SERVER['FULL_URL']."modules.php?name=Your_Account&op=show_post&bid=$bid";
$content .= getBookmarkHTML($blogurl, $title, "&nbsp;","small");
$content .= "</div></center>";
echo $content;
}
function show_post($bid){


	
	global $db,$userinfo,$blogPage,$prefix;

	$blogPagez =(empty($blogPage) ? 1 : $blogPage);
	$offsetz = ($blogPagez-1) * $eachPage ;
	
	if (!empty($bid)) {
	

	$result = $db->sql_query("SELECT * FROM " . BLOG_TABLE . " WHERE bid = '$bid' AND tid='0'  LIMIT 1");
	$numit = $db->sql_numrows($result);
	$row = $db->sql_fetchrow($result);
	$blog_username = $row[sender_name];
	$infoBlog = GET_USER_BLOG_CONFIG($row[sender_name]);
	$user_blog_colors = explode("#",$infoBlog[user_blog_colors]);

	global $pagetitle;
	$pagetitle = "$row[content]";//====== PAGE TITLE =====================

	include_once("header.php");
	?>
	
<link rel="StyleSheet" href="modules/Your_Account/includes/style/ucp.css" type="text/css" /> 
<script type="text/javascript" src="modules/Your_Account/includes/style/YABC.js"></script> 
<script type="text/javascript" src="modules/Your_Account/includes/style/jquery.oembed.js"></script> 
<script type="text/javascript" src="modules/Your_Account/includes/style/jeditable.js"></script> 
	
	<?php
	OpenTable();
	
	echo "<div class='ucp_block_header'  title='$blog_username' id='BlogUsername'  style='text-align:right'>
	<a href='modules.php?name=Your_Account&op=userinfo&username=$blog_username' title='"._Viewing_profile_."'>
	<b> $blog_username </b>   
	<a href='modules.php?name=Your_Account&op=userinfo&username=demo&blogPage=1' onclick=\"javascript:refresh_blog(".$blog_userid."); return false;\" ><img src='images/icon/arrow_refresh.png' alt='refresh' title='"._YA_BLOG_REFRESH."'></a>
	";
	if ($userinfo[username] == $blog_username) {
		echo '<p style="float:left;text-align:left;margin-left:10px"><img src="images/icon/bricks.png">
		<a href="modules.php?name=Your_Account&op=edituser" class="setting_button" onclick=\'javascript:setting_blog('.$blog_userid.'); return false;\'>'._YA_BLOG_SETTING.'</a></p><div style="clear:both"></div> ';
	}
	echo"</div>\n\n";

	echo '<div id="flash" ></div> <!-- LODING UPDATE -->
	<div style="width:98%;"><!-- BLOG CONTAINER-->
		<ol  id="update" class="timeline"><!-- UPDATE BLGO POSTS -->
		</ol><!-- CLOSE UPDATE PAGE-->
	</div><!-- CLOSE BLOG CONTAINER-->
	';
	if ($userinfo[username] == $blog_username) {
		echo '<div id="setting" title="'.$blog_username.'" class="BlogSetting"></div>';
	}

	if (!empty($numit)) {


			$bid = sql_quote(intval($row['bid']));
			$tid = sql_quote(intval($row['tid']));
			$content = stripslashes(FixQuotes($row['content']));
			$date = hejridate($row['date'],1,3);
			$like = sql_quote(intval($row['like']));
			$unlike = sql_quote(intval($row['unlike']));

			$sender_id = $row['sender'];
			$sender_name= $row['sender_name'];
			$reciever_id = $row['reciever'];
			$reciever_name = $row['reciever_name'];

			$usrblogcolor = ((get_brightness($user_blog_colors[1]) > 125) ? "black" : "white");
			$usrblogcolor2 = ((get_brightness($user_blog_colors[2]) > 125) ? "black" : "white");
			$usrblogcolor3 = ((get_brightness($user_blog_colors[3]) > 125) ? "black" : "white");
			$fontColorReply = ($reply_sender_name==$username) ? "".$usrblogcolor3."" :  "".$usrblogcolor2."";
			echo "<p><li class='bar$bid'>\n
	<div style='background:#".$user_blog_colors[1].";color:$usrblogcolor' class='BPostRow'>\n";
			blog_content($bid,$tid,$content,$date,$like,$unlike,$sender_id,$sender_name,$reciever_id,$reciever_name);
			echo '</div>';
			echo '<div class="clear"></div>';

			//-- Reply 1st -------------------
			$comment_count = count_blog_posts($bid,$blog_username,'THIS_POST');
			echo '
<div id="fullbox" class="fullbox'.$bid.'">
	<div id="commentload'.$bid.'" ></div>
</div>  
<div id="view_comments'.$bid.'"></div>
<div id="two_comments'.$bid.'">
';

			$replysqlrez = $db->sql_query("SELECT * FROM " . BLOG_TABLE . " WHERE tid = '$bid' ORDER BY bid DESC ");

			while ($replyrow = $db->sql_fetchrow($replysqlrez)){
				$reply_sender_id = $replyrow['sender'];
				$reply_sender_name= $replyrow['sender_name'];
				$reply_reciever_id = $replyrow['reciever'];
				$reply_reciever_name = $replyrow['reciever_name'];
				$reply_bid = $replyrow['bid'];
				$reply_tid = $replyrow['tid'];
				$content_r1 = stripslashes(FixQuotes($replyrow['content']));
				$date_r1 = hejridate($replyrow['date'],1,3);
				$like_r1 = sql_quote(intval($replyrow['like']));
				$unlike_r1 = sql_quote(intval($replyrow['unlike']));

				$usrblogcolor2 = ((get_brightness($user_blog_colors[2]) > 125) ? "black" : "white");
				$usrblogcolor3 = ((get_brightness($user_blog_colors[3]) > 125) ? "black" : "white");
				$fontColorReply = ($reply_sender_name==$username) ? "".$usrblogcolor3."" :  "".$usrblogcolor2."";
				$classReply = ($reply_sender_name==$blog_username) ? "BAdminReplyRow" :  "BReplyRow";
				$ColorReply = ($reply_sender_name==$blog_username) ? "".$user_blog_colors[3]."" :  "".$user_blog_colors[2]."";

				echo "<div style='background:#".$ColorReply.";color:$fontColorReply'  class='$classReply'  id='comment$reply_bid'>";
				blog_content($reply_bid,$reply_tid,$content_r1,$date_r1,$like_r1,$unlike_r1,$reply_sender_id,$reply_sender_name,$reply_reciever_id,$reply_reciever_name);
				echo '</div>
	<div class="clear"></div>';

			}
			$db->sql_freeresult($replysqlrez);
			
			echo "</div>\n";
			echo "</li><p>\n\n";

	}else {
		echo "<div id='noblogpost'>
	<img src='images/icon/error.png'>
	"._YA_NOBLOGPOST."
	</div>";
	}

	echo '<br style="margin:0px auto;clear:both;">';

	echo "<div class='ucp_block_header' style='text-align:".langstyle(align)."'>";
		echo "<img src='images/icon/shape_align_bottom.png'>
"._YA_TOTAL_COMMENTS.":<b> ".count_blog_posts($bid,'','THIS_POST')."</b>";
	echo"</div>";
	echo "<br>";

	CloseTable();
	}else {
		header("Location: index.php");
	}
	include_once("footer.php");
}

function YAB_Setting(){
	global $userinfo,$user,$module_name,$username,$db;
	if (is_user($user)) {
	$user_blog_colors = array();
	$user_blog_colors = explode("#",$userinfo[user_blog_colors]);
	$blog_password = $userinfo[user_blog_password];

	if($userinfo['user_allowemails']==1){$YNotify = 'checked="checked"';}else {$NNotify = 'checked="checked"';}

			$usrblogcolor = ((get_brightness($user_blog_colors[1]) > 125) ? "black" : "white");
			$usrblogcolor2 = ((get_brightness($user_blog_colors[2]) > 125) ? "black" : "white");
			$usrblogcolor3 = ((get_brightness($user_blog_colors[3]) > 125) ? "black" : "white");
?> 
<link rel="stylesheet" href="modules/Your_Account/includes/style/colors/farbtastic.css" type="text/css" />
 <script type="text/javascript" src="modules/Your_Account/includes/style/colors/farbtastic.js"></script>
 <script type="text/javascript" src="modules/Your_Account/includes/style/YBCSetting.js"></script>
<script type="text/css">$(document).ready(function(){$('.updatesetting').click(function(){var e=$(this).attr("id");var b=$('#color1').val();var c=$('#color2').val();var d=$('#color3').val();if($("input[@name='password']:checked").val()=='0'){document.getElementById("blog_password").value=''}var f=$('#blog_password').val();if($("input[name='notifyblog']:checked").val()=='1')var a=1;else if($("input[@name='notifyblog']:checked").val()=='0')var a=0;else var a=0;var g='action='+e+'&color1='+b+'&color2='+c+'&color3='+d+'&password='+f+'¬ify='+a;$.ajax({type:"POST",url:"modules.php?name=Your_Account&op=YBSaveSetting",data:g,success:function(h){$("#setting").html("تنظیمات ذخیره شد").fadeIn(1200);$("#setting").load("modules.php?name=Your_Account&op=YAB_Setting")}});$(".BPostRow").css({'background-color':b,'color':});$(".BReplyRow").css({'background-color':c,'color':});$(".BAdminReplyRow").css({'background-color':d,'color':});return false})});
</script>
  
 <span class="close_setting" ><a  href="javascript:close_setting()" ><img src="images/icon/cross.png" title="<?php echo _CLOSE ?>" alt="<?php echo _CLOSE ?>"></a> </span>
 
 <div class="notify"></div>
<form action="modules.php?name=<?php echo $module_name?>" method="POST">
<h3><?php echo _YA_SETTING_BLOG; ?></h3>
  <div id="picker" style="float:<?php echo langStyle(align)?>;text-align:<?php echo langStyle(align)?>" ></div>
  <div class="form-item"><label><?php echo _YA_SETTING_BLOG_POSTCOLOR; ?></label>
  <input type="text" id="color1" name="color1" class="colorwell" value="#<?php echo $user_blog_colors[1];?>" /></div>
  <div class="form-item"><label><?php echo _YA_SETTING_BLOG_REPLYCOLOR; ?></label>
  <input type="text" id="color2" name="color2" class="colorwell"  value="#<?php echo $user_blog_colors[2];?>" /></div>
  <div class="form-item"><label><?php echo _YA_SETTING_BLOG_ADMINCOLOR; ?></label>
 <input type="text" id="color3" name="color3" class="colorwell" value="#<?php echo $user_blog_colors[3];?>" /></div>
<?php
if(!empty($blog_password)){$yes = 'checked="checked"';}else{$no='checked="checked"';$rstyle='style="display:none"';}
echo '<div class="form-item"><label>'. _YA_SETTING_BLOG_HIDE.'</label>';
echo '<input type="radio" name ="password" value="1" onclick=\'$("#blog_password_div").slideDown(300)\' ',$yes,' />',_YES,'
 <input   type="radio" name ="password" value="0" onclick=\'$("#blog_password_div").slideUp(300)\' ',$no,' />',_NO,'</div>';
echo "<div id='blog_password_div' $rstyle>
<input type='text'  id='blog_password' name='blog_password' value='".$blog_password." ' size='20' />
</div>";
?>
  <div class="form-item"><label><?php echo _YA_SETTING_BLOG_EMAILNTFY; ?></label>
<input type="radio" name ='notifyblog' value="1" <?php echo $YNotify ?> /><?php echo _YES ?>
<input type="radio" name ='notifyblog' value="0"  <?php echo $NNotify ?>/><?php echo _NO ?>
</div>

<input type="submit" id="updatesetting" name="updatesetting" class="updatesetting" value="<?php echo _SEND?>" />
<input type="submit" id="resetsetting" name="resetsetting"  class="resetsetting" value="<?php echo _YA_SETTING_BLOG_RESET?>" /><br>
</form>

<?php
	}else {
	 show_error(_NOTSUB."<br>"._ASREGISTERED);
	}

}
function YBSaveSetting(){

	global $userinfo,$user,$db,$prefix;
	if (is_user($user)) {
	
	if (isset($_POST["action"])) {

		$action = $_POST["action"];
		$color1 = $_POST["color1"];
		$color2 = $_POST["color2"];
		$color3 = $_POST["color3"];
		$blog_password = trim($_POST["password"]);
		$notify = $_POST["notify"];
		$colarr = array($color1, $color2,$color3);
		$colarrimp = implode("",$colarr);

		switch ($action)
		{

			case "updatesetting":
				$db->sql_query("UPDATE ".$prefix."_users SET user_blog_colors='$colarrimp',user_blog_password='$blog_password',user_allowemails='$notify'
 WHERE user_id='".$userinfo[user_id]."'");
				break;

			case "resetsetting":
				$db->sql_query("UPDATE ".$prefix."_users SET user_blog_colors='#F9F1A9#EEE4C6#EDFAC8',user_blog_password='',user_allowemails='1' WHERE user_id='".$userinfo[user_id]."'");
				break;

		}
	}
	}else {
		 show_error(_NOTSUB."<br>"._ASREGISTERED);
	}
	
}
function YB_Password(){
?>
 <script type="text/javascript" charset="utf-8">
$(document).ready(function(){$(".SubmitPassCls").click(function(){var c=$(".blog_password_div").attr("id");var a=$("#PassForBlog").val();var b="modules.php?name=Your_Account&op=userinfo&username="+c;var d="&password="+a+"&username="+c;$.ajax({type:"POST",url:"modules.php?name=Your_Account&op=YB_Password_CHK",data:d,success:function(f){$(".notify").html(f).fadeOut(1500);$(location).attr("href",b)}});return false});$(".close_setting").click(function(){$("#setting").fadeOut()})});
</script>
  <span class="close_setting" ><a  href="javascript:void()" ><img src="images/icon/lock.png" title="قفل" alt="قفل"></a> </span>
 <div class="notify"></div>
<form action="modules.php?name=<?php echo $module_name?>" method="POST">
<h3>وبلاگ مورد نظر مخفی است</h3> <br> <hr>
        <div class="blue_box"> 
              <dl> 
                 <dt>رمز عبور را وارد نمایید</dt> 
                    <dd class="password"> 
					<span class="input"><input type="password" id="PassForBlog" name="PassForBlog" value="" class="text" /> <br>
					<a href="#" style="line-height:300%;" id="forgot_my_password">رمز عبور را از صاحب این وبلاگ بگیرید</a></span> 
					</dd> 
            <input type="submit" id="SubmitPass" name="SubmitPass" class="SubmitPassCls" value="<?php echo _SEND?>" />
		</dl> 
	</div>
</form>
<?php
}
function YB_Password_CHK(){

	global $userinfo,$db,$prefix;
	if (isset($_POST["password"])) {
		$blog_password = $_POST["password"];
		$blog_owner = $_POST["username"];
		$configblog = GET_USER_BLOG_CONFIG($blog_owner);
		$md5stringpass = md5($configblog['user_blog_password']);

		if ($configblog['user_blog_password']!=$blog_password) {
			die("رمز عبور صحیح نیست-$blog_owner<br>");
		}else {
			setcookie("BlogUSER-$blog_owner",$md5stringpass);
		}
	}
	header("Location: ../../../index.php");
}
function flush_blog(){
	
	global $confirmed,$db,$user,$log,$prefix;
	if (is_user($user)) {
	if($_POST['blog_id'])
	{
		$blog_id=$_POST['blog_id'];

			$db->sql_query("DELETE FROM " . BLOG_TABLE . " WHERE sender='$blog_id' AND reciever='$blog_id'") or	show_error(mysql_error());
			//delete posted blog point
			update_points(1,'-');
				?>
				<script type="text/javascript">
				$.post("modules.php?name=Your_Account&op=show_my_blog",{op: "show_my_blog", blog_userid: "<?php echo $blog_id?>" ,  blog_page: "<?php echo $blog_id?>" },function(data){$("#blog_page").html(data);});
				</script>
				<?php
			
		}
		else
		{
			define("LOG_INC",YES);
			$log->lwrite('users', "" . $userinfo['username'] .
			"دسترسی لازم برای حذف این مطلب را ندارید");
			echo "دسترسی لازم برای حذف این مطلب را ندارید";
		}
	}else {
				 echo _NOTSUB."<br>"._ASREGISTERED;
	}
	
}
function edit_my_post(){
	global $db,$module_name;
	$bid = $_POST['bid'];
	$username = $_POST['username'];
	?>
	<script type="text/javascript">
	$(document).ready(function(){$("a.add_emo").click(function(){var emo = $(this).attr("id");$('#edit_message<? echo $bid;?>').val($('#edit_message<? echo $bid;?>').val() + emo + ' ');});
	});
	</script>
	<?php
	$result= $db->sql_query("SELECT content FROM " . BLOG_TABLE . " WHERE bid='$bid' LIMIT 1 ");
	list($content)= $db->sql_fetchrow($result);

	//Parsing the text and convert it into simple bbcode text along with the representation of smiley codes OR V.S. .
	require_once(INCLUDES_PATH.'inc_bbcode.php');
	$parser = new SimpleParser();

	if (intval($_POST['cancel']==1)) {
		$content=analyse_content($content,1,1,1);
		echo $content;
	}else {
	$parser->jq_toggle_box ( 'show_smiley_block'.$bid.'', 'a', 'smiley_block_div'.$bid.'' );
	$content= strip_tags($parser->unParseText($content));
	
	echo "<div style='text-align:right;width:90%;margin:0px auto;'>
	<form name='editform' id='editform' action=\"modules.php?name=$module_name\" method=\"post\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"broadcast\">";
	echo "<input type=\"hidden\" name=\"action\" value=\"blog_edit\">";
	echo "<br> <textarea style='height:50px;width:100%;'  id='edit_message$bid' class='txtar' name='limitedtextarea' onKeyDown='limitText(this.form.limitedtextarea,this.form.countdown,255);' onKeyUp='limitText(this.form.limitedtextarea,this.form.countdown,255);'>$content</textarea>".'<p>
      <input type="submit" class="editsend" id="'.$bid.'" value="'._SEND.'">
      <a href="javascript:cancel_reply('.$bid.')" id="cancel" class="button"> '._CANCEL.' </a>  
      <a href="javascript:show_smiley()"  id="show_smiley_block'.$bid.'" class="button"> '._SMILEY.' </a>  
      <div id="smiley_block_div'.$bid.'" class="smiley_box">';
	echo $parser->read_smiley_dir();
	echo '</div></p>';
	echo "</form>
	</div>";
	
	}
}



switch ($action)
{

	case "blog_post":
		blog_post();
		break;

	case "blog_reply":
		blog_reply();
		break;

	case "blog_like":
		blog_like($bid);
		break;

	case "blog_del":
		blog_del($bid);
		break;
	case "blog_edit":
		blog_edit();
		break;
	case "show_my_blog":
		show_my_blog();
		break;
	case "flush_blog":
		flush_blog();
		break;
}

?>