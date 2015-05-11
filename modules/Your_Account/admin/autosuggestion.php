<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}
global $db,$prefix;
//Administration ----- By Aneeshtan
define("NK_USER_TABLE","".$prefix."_users");
global $db;
if($_POST)
{
	$q=$_POST['searchword'];
	$q = sql_quote($q);
	$sql_res=$db->sql_query("select * from ".NK_USER_TABLE." where username like '%$q%' or name like '$q%' order by username LIMIT 5");
	$numrows = $db->sql_numrows($sql_res);
	if (!empty($numrows)) {
		while($row=$db->sql_fetchrow($sql_res))
		{
		$fname=$row['username'];
		$lname=$row['name'];
		$chng_uid=$row['user_id'];
		?>
		<div class="display_box">
		<img src="<?php echo avatar_me($fname); ?>" width="40px" height="40px"/>
		<?php echo "<b>$fname</b>"; ?>&nbsp;
		<?php echo "<b>$lname</b>"; ?>
		<span style="float:left;">
		<a href='<?php echo ADMIN_OP ?>deleteUser&chng_uid=<?php echo $chng_uid ?>'><img src='images/icon/delete.png'><?php echo _DELETE ?></a>
		<a href='<?php echo ADMIN_OP ?>modifyUser&chng_uid=<?php echo $chng_uid ?>'><img src='images/icon/user_edit.png'><?php echo _EDIT ?></a>
		</span>
		</div>
		<?php
		}
	}else {
		echo "<div class='display_box'>
		<span style='float:left;'><b>$q</b>&nbsp;&nbsp;<img src='images/icon/user_add.png'></span>
		چنین کاربری وجود ندارد . <br> این کاربر را به بانک اطلاعاتی خود
		<a href='".ADMIN_OP."addUser'><b> اضافه کنید</b><br>
		</div>
		";
	}
}

?>