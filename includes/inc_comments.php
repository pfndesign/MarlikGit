<?php

/**
*
* @package inc_comments	
* Inspired by weblogina.com comment system appearance													
* @version $Id: comments.php $Aneeshtan 5:24 PM 10/5/2011				
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

class comments_class {

	// show all comments in this story
	function comment_showroom(){
		global $db,$sid,$pid,$userinfo,$pagenum,$commentlimit;
		
		if ($userinfo['uorder']==1){
			$commentOrder = " tid DESC";
		}elseif ($userinfo['uorder']==2){
			$commentOrder = " score DESC";
		}else {
			$commentOrder = " tid ASC";
		}

		
		$ppage = ($userinfo['thold']==0 ? $commentlimit : $userinfo['thold'] );
		$cpage = (empty($pagenum)) ? 1 : $pagenum;
		$offset  = ($cpage * $ppage) - $ppage;

		$sql1 = "SELECT * FROM ".COMMENTS_TABLE." WHERE `active`='1' AND `sid`='".intval($sid)."' AND `pid`='0'";
		$sql2 = $sql1."  ORDER BY $commentOrder LIMIT $offset,$ppage";
		$commenters = $db->sql_numrows($db->sql_query($sql1));
		$query = $db->sql_query($sql2);

?>
<script type="text/javascript" src="<?php echo MODS_PATH; ?>rating/posneg.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('#comment_submit').live("click",function(){
	//the main ajax request
	var commentjx = escape(CKEDITOR.instances.commentjx.getData());
	$("#commentjx").html(commentjx);
	var serialdata = $("#comments-form").serialize();

	
	$.ajax({
			type: "POST",
			data: decodeURIComponent(serialdata),
			cache: false,
			url: "modules.php?name=News",
			beforeSend : function (xhr) {
				$("#JcommentPosted").html("<img src='images/loading.gif'/><?php echo _LOADING ?>");
			},
			success: function(msg)
			{
				if(msg==="<div class='success'><?php echo _THANKS_COMMENT ?></div>"){
					 location.reload();
				}
				$("#JcommentPosted").html(msg);
			}
		});
		return false;
	});


});

</script>
<!-- Start Comments -->
<aside id="comments" class="comments">
<h2 class="comments-title"><?php echo intval($commenters). _COMMENTS_SNEDERS?> </h2>

<?php 
while($row=$db->sql_fetchrow($query)){
	$cnt++;
	$this->show_this_very_comment($row,($cnt%2) ? "odd" : "even");
}
?>
<!-- START Cooment PAGINATION -->
<?php echo make_pagination(10,$commenters,$ppage,$cpage,3,"modules.php?name=News&file=article&sid=1&pagenum",''); ?>
<!-- End  Cooment PAGINATION  -->

</aside>
<!-- End Comments -->
<div id='JcommentPosted'></div>
<!-- Start Comment Form -->
<?php $this->make_topic($sid); ?>
<!-- End Cooment Form -->

<?php
	}
	//show each comment in its own style
	function show_this_very_comment($row,$oe){
		//	print_r ($row);
		global $db,$userinfo;
		//whats his/her address !?! NOB
		$commenterLink = (is_user($row[5]) ?  "modules.php?name=Your_Account&op=userinfo&username=".$row[5]."" : $row[7] );
?>
<!-- Start Comment <?php echo $row[0] ?> -->
<article class="comment <?php echo $oe; ?>" id="comment-<?php echo $row[0] ?>">
<header class="head">
<figure class="avatar">
<img src="<?php echo avatar_me($row[5]) ?>" width="60" height="60"
	alt="<?php echo $row[5] ?>" />
</figure>

<cite class="author"><a target="_blank" href="<?php echo $commenterLink;?>"  rel="nofollow" ><?php echo $row[5] ?></a></cite>

<time datetime="<?php echo formatTimestamp($row[4]);?>" class="date">
<i><small><?php echo hejridate($row[4],4,3); ?></small></i>
</time>

<div class="rating" id="comments"><span class="rate-up" id="up_<?php echo $row[0] ?>"></span>
<span class="rate" id="rate_<?php echo $row[0] ?>"><?php echo $row[11] ?></span> <span
	class="rate-down" id="down_<?php echo $row[0] ?>"></span></div>


</header>

<div class="content">
<?php 
$context = preg_replace("/\r?\n/m", "", $row[10]);
if ($userinfo[commentmax]>0) {
$context = (strlen($context) > intval($userinfo[commentmax]) ? substr($context, 0, intval($userinfo[commentmax]))."..." : "$context"  );
}

if($row[11] < -5 ) {
	echo "<i>"._VOTE_HIDE."</i>
<div class='hiddenComm'>".	stripslashes(check_words(trim($context)))."</div>";
}elseif($row[11] > 10 ) {
	echo "<div class='popcomment'><i>"._VOTE_POP."</i><img src='images/icon/star.png'>".stripslashes(check_words(trim($context)))."</div>";
}else {
	echo "<p>".stripslashes(check_words(trim($context)))."</p>";
}

$sql1 = "SELECT * FROM ".COMMENTS_TABLE." WHERE active='1' AND pid='".$row[0]."'";
$query = $db->sql_query($sql1);
if ($query) {
	while ($result=$db->sql_fetchrow($query)) {
		$commenterLink = (is_user($result[5]) ?  "modules.php?name=Your_Account&op=userinfo&username=".$result[5]."" : $result[7] );
		echo "<span class='replyCm'>".strip_tags($result[10])." - <a href='".$commenterLink."' >".$result[5]."</a> ".hejridate($result[4],4,3)."</span>";
	};
}
$db->sql_freeresult($query);
?>
<span class="reply"><a title="<?php echo _REPLY ?>"	href="javascript:void(0);"
	onclick="mtReplyCommentOnClick(<?php echo $row[0] ?>, '<?php echo $row[5] ?>')"><?php echo _REPLY ?></a>
</span>
<span class="cdelete" style="display:none"><a title="<?php echo _DELETE ?>"	href="javascript:void(0);"
	onclick="javascript:cdeleteOnClick(<?php echo $row[0] ?>, '<?php echo $row[5] ?>')"><?php echo _DELETE ?></a>
</span>

</div>
<div class="clear"></div>
</article>

<!-- End Comment <?php echo $row[0] ?>-->
<?php
	}
	// lets create a box to create a comment
	function make_topic($sid){
		global $anonpost,$user,$module_name, $admin, $pid, $userinfo;
if ($anonpost==1 OR is_user($user)) {

?>

<div id="commentform">
<div class="<?php echo langStyle(align)?>">
<form method="post"
	action="modules.php?name=<?php echo $module_name ?>&amp;file=comments"
	name="comments_form" id="comments-form"
	onsubmit="return mtCommentOnSubmit()">
     <?php 
     echo "<input type=\"hidden\" name=\"pid\" value=\"$pid\">\n"
     ."<input type=\"hidden\" name=\"sid\" value=\"$sid\">\n"
     ."<input type=\"hidden\" name=\"op\" value=\"CreateTopic\">\n"
     ."<input type=\"hidden\" name=\"file\" value=\"comments\">\n";
	?>
            <input required aria-required="true" autocomplete="on"
	id="author-name" name="author" type="text"
	value="<?php echo (empty($userinfo['username']) ? _NAME : $userinfo['username'])?>" <?php echo (empty($userinfo['username']) ? "" : "readonly")?>  onfocus="if (this.value == '<?php echo _NAME;?>') {this.value = '';}"
	onblur="if (this.value == '') {this.value = '<?php echo _NAME;?>';}"
	onfocus="mtCommentFormOnFocus()" />  
    <input required	aria-required="true" autocomplete="on" id="author-email" name="email"
	type="email"
	value="<?php echo (empty($userinfo['user_email']) ? _EMAIL : $userinfo['user_email'])?>"
	onfocus="if (this.value == '<?php echo _EMAIL?>') {this.value = '';}"
	onblur="if (this.value == '') {this.value = '<?php echo _EMAIL?>';}"
	onfocus="mtCommentFormOnFocus()" /> <br />
<input id="author-url" name="url" type="text"
	value="<?php echo (empty($userinfo['user_website'])? 'http://" onfocus="mtCommentFormOnFocus()': $userinfo['user_website'])?>" onfocus="if (this.value == '<?php echo 'http://';?>') {this.value = '';}"
	onblur="if (this.value == '') {this.value = '<?php echo 'http://';?>';}"
	onfocus="mtCommentFormOnFocus()" />  
<br style="clear:both">
<?php wysiwyg_textarea('commentjx', '', 'PHPNuke', '50', '12');?>
 <!--<textarea required aria-required="true" id="comment-text" name="comment" rows="15" onfocus="mtCommentFormOnFocus()"></textarea> -->
<div class="clear"></div>
<button type="submit" class="submit" accesskey="s" name="post"
	id="comment_submit" onclick="mtCommentOnSubmit()"><?php echo _SEND?></button>
<div id="comment-form-reply" style="color:red;font-weight:700;display: none"><input
	type="checkbox" id="comment-reply" name="comment_reply" value=""
	onclick="mtSetCommentParentID()" /><label class="comment-cookie"
	for="comment-reply" id="comment-reply-label"></label>
	<input type="hidden" name="comment-reply-i" value="">
	<input type="hidden" name="replytratext" id="replytratext" value="<?php echo _REPLY_TO ?>">
</div>
</form>
</div>

<section class="comment-tips">
<h3 class="title">
<?php echo _BEFOR_COMMENTING?>
</section>

<div class="clear"></div>
</div>

<?php

}else {
	echo "<br>";
	OpenTable();
	echo "<center>"._NOANONCOMMENTS."</center>";
	CloseTable();
}
	}
	//save the posted comment's form
	function CreateTopic ($xanonpost,$author,$email,$url ,$subject, $comment,$pid, $sid, $host_name, $mode, $order,$thold,$comment_reply) {
		global $module_name, $user, $userinfo, $EditedMessage, $admin, $AllowableHTML, $ultramode, $user_prefix, $prefix, $anonpost, $articlecomm, $db,$notify,$notify_subject,$notify_email,$notify_from;

		cookiedecode($user);
		getusrinfo($user);
		$sid = intval($sid);
		$pid = intval($pid);
		$author = addslashes(check_html($author, "nohtml"));
		$url = addslashes(filter_text($url, "nohtml"));
		$email = addslashes(filter_text($email, "nohtml"));
		//$comment = smileAndText($comment);
		//$comment = addslashes(filter_text($comment));
		//$comment = nl2br(htmlspecialchars($comment));
		//$comment = check_html($comment,$AllowableHTML);
		$comment = sql_quote(filter_text($comment));
		$commentjx = sql_quote(unescape($_POST['commentjx']));

		$comment = (empty($comment) ? $commentjx : $comment);
		

		if (empty($author) OR empty($email) OR empty($comment) OR $author=="نام" ){
			echo '<div class="warning">'._EMPTY_FEILD.'</div>';		
			exit();
		}
		if(!validate_mail($email)) {
			echo '<div class="error">'._ERRORINVEMAIL.'</div>';
			exit();
		}


		$c_expire_num= $db->sql_numrows($db->sql_query("SELECT name FROM ".COMMENTS_TABLE." WHERE name='$author' AND active='0'"));
		if ($c_expire_num > 1) {
			echo '<div class="error">'._COMMENTS_WAITINGALREADY.'</div>';
			exit();
		}
		$db->sql_freeresult($c_expire_num);

		$mc_num= $db->sql_numrows($db->sql_query("SELECT * FROM ".COMMENTS_TABLE." WHERE comment='$comment' AND name ='$author' AND active='0' "));
		if ($mc_num > 0) {
			echo '<div class="error">'._COMMENTS_WAITINGALREADY.'</div>';
			exit();
		}
		$db->sql_freeresult($mc_num);

		$c_num= $db->sql_numrows($db->sql_query("SELECT * FROM ".COMMENTS_TABLE." WHERE comment='$comment'  AND name ='$author'  AND active='1' "));
		if ($c_num > 0) {
			echo '<div class="error">'._COMMENTS_ALREADYSAVED.'</div>';
			exit();
		}
		$db->sql_freeresult($c_num);


		/*-------Validation------------End-------------*/

		if(!isset($ip)) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}


		///lets find out is there really a story with this id ?
		$query = $db->sql_query("SELECT `title` FROM ".$prefix."_stories WHERE `sid`='$sid'");
		list($title_story)= $db->sql_fetchrow($query);
		$fake = $db->sql_numrows($query);
		$db->sql_freeresult($query);


		if ($fake == 1 AND $articlecomm == 1) {


			$krow = $db->sql_fetchrow($db->sql_query("SELECT karma FROM ".$user_prefix."_users WHERE username='$name'"));

			$koptions = "";
			$koptions .= "&mode=".$mode;
			$koptions .= "&order=".$order;
			$koptions .= "&thold=".$thold;
			$Story_address = "modules.php?name=$module_name&file=article&sid=$sid&title=".Slugit($title_story)."";

			if (is_admin($admin)) {
				$db->sql_query("INSERT INTO ".COMMENTS_TABLE." (tid,pid,sid,active,date,name,email,url,host_name,subject,comment,score,reason) VALUES
				 (NULL, '$comment_reply', '$sid', '1' , now(), '$author', '$email', '$url', '$ip', '$title_story', '$comment', '0', '0')")or die(mysql_error());
					die("<div class='success'>"._THANKS_COMMENT."</div>");
			} elseif ($krow['karma'] == 3) {
				show_error("Please Keep this in mind that You Cannot Post any further Comment  by name of <b>$author</b> . <br><br>Your username known as Evil one ");
				die();
			}else {
				$db->sql_query("INSERT INTO ".COMMENTS_TABLE."  (tid,pid,sid,active,date,name,email,url,host_name,subject,comment,score,reason) VALUES
				(NULL, '$comment_reply', '$sid', '0' , now(), '$author', '$email', '$url', '$ip', '$title_story', '$comment', '$score', '0')");
				//-- Comment Notification Mail ---
				if ($notify == "1") {
					$message = "<b>$author</b> By $email "._COMMENTS_SNEDERS." :<br><br>"._URL.":  ".USV_DOMAIN.$Story_address." <br><br> "._LASTIP." : $ip <br><br>"._COMMENT.":    $comment  <br><br><hr><br> مدیریت : <br> تایید این نظر : <br> ".USV_DOMAIN."admin.php?op=moderation_mc_view&id=".mysql_insert_id()."";

					$messagess = Mail_AddStyle($message);
					@mail($notify_email, $notify_subject, $messagess, "From: $notify_from\nContent-Type: text/html; charset=utf-8");

					die("<div class='success'>"._THANKS_COMMENT."</div>");
					//---
				}
			}//--End if user or admin


			update_points(5);
			$options = "";
			$options .= "&mode=".$mode;
			$options .= "&order=".$order;
			$options .= "&thold=".$thold;
			/*
			if (is_admin($admin)) {
				Header("Location: modules.php?name=$module_name&file=article&sid=$sid");
			}else {
				Header("Location: modules.php?name=$module_name&op=thanks");
			}
			*/

		}else {
			echo '<div class="error">'._COMMENTS_ACCESSDENIED.'</div>';
			exit();
		}

	}
	// can a superadmin delete this comment ?
	function delete_this_comment (){
		global $db;
		// not in this version dear: I'm so tired in this very late night . lets sleep you nerd!
	}

}


?>