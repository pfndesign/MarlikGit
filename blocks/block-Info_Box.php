<?php
/**
*
* @package InfoBox Block 												
* @version $Id:  1:00 PM 5/29/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
*/

// how many newest members to show
$recent_member_count = 3;
// show online guests IP in online list
$show_guest_list = true;
// how long before inactive uses are dropped from online list
$max_session_mins = 60;
// maximum number of guests to display
$max_display_guests = 5;
// maximum number of members to display
$max_display_members = 10;
// notify users of private message by using a javascript drop box
$pm_notify_dropin = false;
// if set to true, users will only be notified of private messages once per visit
$pm_dropin_once = false;
// set the colors for the dropin box
$dropin_bgcolor = '#EEEEEE';
$dropin_bordercolor = '#4C44BA';


if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $db,$prefix,$userinfo,$user,$currentlang,$gfx_chk,$admin;

//Include the language
if (file_exists("language/Info-Box/info_box_$currentlang.php")) {
	include("language/Info-Box/info_box_$currentlang.php");
} else {
	include("language/Info-Box/info_box_persian.php");
}

$content = '
<!-- Start Info -->
<table width="100%">
';

// get user info/show login
if (is_user($user))
{

	$content .= '<tr><td style="border-bottom: 1px dotted #CCCCCC; padding-bottom: 4px; padding-top: 4px;">
  <a href="modules.php?name=Your_Account&amp;op=edituser" style="text-decoration: none" title="'._IB_EDITACCOUNT.'">
  <center><img src="'.avatar_me($userinfo[username]).'" alt="'._AVATAR.'" title="'._AVATAR.'" width="90px;" height="90px;" style="border:5px solid white;"></center><br>
  <img src="images/blocks/user.png" alt="" style="border: 0px;"> <span style="font-size: 14px;"><strong>'. $userinfo[username] .'</strong></span></a> 
	 <br />';
	$content .= '<div>';
	$content .= '<img src="images/blocks/your_ip.png" alt="">  <strong>'. $_SERVER['REMOTE_ADDR'] .'</strong><br />
	  <a href="modules.php?name=Your_Account&op=logout" style="color:red"><img src="images/icon/cross.png"><strong>'._LOGOUT.'</strong></a>';


}
else
{
	$content .= '
  <tr>
  <td style="border-bottom: 1px dotted #CCCCCC; padding-bottom: 4px; padding-top: 4px;">
  <a href="modules.php?name=Your_Account" style="text-decoration: none" title="'._IB_LOGIN_REGISTER.'"><img src="images/blocks/user.png" alt="" style="border: 0px;"> <span style="font-size: 14px;"><strong>'._IB_ANONYMOUS.'</strong></span></a><br />';
	$content .= '<div style="" title="'._IB_YOURIP.'">';
	$content .= '<img src="images/blocks/your_ip.png" alt="">  <strong>'. $_SERVER['REMOTE_ADDR'] .'</strong><br /></div>

  <form action="modules.php?name=Your_Account" method="post">
  '. _NICKNAME .':<br />
  <input type="text" name="username" size="15" maxlength="25"  value="" ><br />
  '. _PASSWORD .':<br />
  <input type="password" name="user_password" size="15" maxlength="20"  value=""><br />
  ';
   $content .= "<table border=\"0\">\n";
	// see if security code is enabled
	if (extension_loaded("gd") AND ($gfx_chk == 2 OR $gfx_chk == 4 OR $gfx_chk == 5  OR $gfx_chk == 7)) {
		$content .= "<tr><td colspan='2'><td>";
		global $wrong_code;
		if($wrong_code)
		$content .= "<div style='color:red;'>"._WRONG_CODE."</div>";
		$content .= show_captcha()."</td></tr>";
	}

   $content .= "</table>";

	$content .= '
  <br />
  <input type="hidden" name="op" value="login" />
  <input type="submit" name="login" value="'. _LOGIN .'" />
  <input type="button" onclick="parent.location=\'modules.php?name=Your_Account&amp;op=new_user\'" name="'. _BREG .'" title="'. _BREG .'" value="'. _BREG .'" />
  </form>
  </td></tr>';
}




$content .= '
<tr>
<td style="border-bottom: 1px dotted #CCCCCC; padding-bottom: 4px; padding-top: 4px;">
<img src="images/blocks/members.png" alt=""> <strong>'._IB_USERSTATS.':</strong>
<br />
';
// get new member info
$timestamp = time();
$today = date("M d, Y");
$yesterday = date("M d, Y", ($timestamp - 86400) );
$this_month = date("M");
$this_year = date("Y");

//Here we should samrt enought to union all these counts
//First Thing to do is build a nice joined mysql query
//Now We go :
$result = $db->sql_query("SELECT user_id,username FROM ". $prefix ."_users ORDER BY user_id DESC LIMIT $recent_member_count");
while( $row = $db->sql_fetchrow($result) ){
if ($row['user_id'] > 1) {
$latestusers .= '
  <div style="padding-left: 12px;">
  <img src="images/blocks/member_new.png" alt="" >
   <a href="modules.php?app=mod&name=navigation&amp;op=Account&value='.$row['user_id'].'" class="colorbox" title=" '.$row['username'].' : '._IB_VIEW_PROFILE.'">
   '.$row['username'].'</a>
  </div>
  ';
}
}
$db->sql_freeresult($result);



$result = $db->sql_query("
SELECT SUM(user_regdate='$today') AS new_today,
   SUM(user_regdate='$yesterday') AS new_yesterday,
   SUM(SUBSTRING(user_regdate, 1, 4)='$this_month' AND SUBSTRING(user_regdate, 9, 12)='$this_year') AS new_month,
   SUM(SUBSTRING(user_regdate, 9, 12)='$this_year') AS new_year,
   SUM(user_active='1') AS total_users	FROM ". $prefix ."_users
");

list($new_today,$new_yesterday,$new_month,$new_year,$total_users) = $db->sql_fetchrow($result);
$db->sql_freeresult($result);
$content .= '
<div style="">
<img src="images/blocks/today.png" alt=""> '._IB_TODAY.': <strong>'. $new_today .'</strong><br />
<img src="images/blocks/yesterday.png" alt=""> '._IB_YESTERDAY.': <strong>'. $new_yesterday .'</strong><br />
<img src="images/blocks/month.png" alt=""> '._IB_THIS_MONTH.': <strong>'. $new_month .'</strong><br />
<img src="images/blocks/year.png" alt=""> '._IB_THIS_YEAR.': <strong>'. $new_year .'</strong><br />
<img src="images/blocks/total_users.png" alt=""> '._IB_TOTAL_USERS.': <strong>'. $total_users .'</strong><br />
</div>
</td>
</tr>
';

$content .= '
<tr>
<td style="border-bottom: 1px dotted #CCCCCC; padding-bottom: 4px; padding-top: 4px;">
<img src="images/blocks/new_users.png" alt=""> <strong>'._IB_MEMBERS.'&nbsp;'._IB_NEW.'';
$content .= $latestusers;



//That's the power of our team in MarlikCMS.com
$content .= '</td></tr>';


// show whos online
$members = '';
$guests = '';
$m = $g = 0;		

		$result = $db->sql_query("SELECT DISTINCT s.session_ip,s.session_user_id,u.username,u.user_id,g.color
	FROM ". $prefix ."_session AS s
  	left join ". $prefix ."_users AS u ON u.user_id = s.session_user_id
  	left join ". $prefix ."_groups AS g ON u.user_group_cp = g.id
  	WHERE s.session_time  > '".( time() - ($max_session_mins * 60) )."' 
  	ORDER BY s.session_user_id,s.session_time DESC");
$content .= '
<tr>
<td style="border-bottom: 1px dotted #CCCCCC; padding-bottom: 4px; padding-top: 4px;">
<img src="images/blocks/members.png" alt=""> <strong>'._IB_ONLINE_NOW.':</strong>
<br />';

while( $row = $db->sql_fetchrow($result) )
{
	if ($row['session_user_id'] != "0")
	{
		$m++;
		if ($m <= $max_display_members)
		{
			$members .= '
      <div style="padding-left: 12px;">
      <img src="images/blocks/online.png" alt=""> <a style="color:'.$row[color].'" href="modules.php?app=mod&name=navigation&amp;op=Account&value='.$row['session_user_id'].'" class="colorbox" title="'._IB_VIEW_PROFILE.': '.$row['username'].'">'.$row['username'].'</a>
      </div>
      ';
		}
	}
	else
	{
		$g++;
		if ($show_guest_list && $g <= $max_display_guests)
		{
			if (is_admin($admin))
			{
				$uname = $row['session_ip'];
			}
			else
			{
				// hide last 2 octets of guest ip's.
				$ip = explode('.', $row['session_ip']);
				$uname = $ip[0].'.'.$ip[1].'.'.preg_match("/[0-9]/", "x", $ip[2]).'.'.preg_match("/[0-9]/", "x", $ip[3]);
			}
			$guests .= '
      <div style="padding-left: 12px;">
      <img src="images/blocks/online_guest.png" alt=""> '.$uname.'
      </div>
      ';
		}
	}
}
$db->sql_freeresult($result);
if ($m > 0)
{
	$content .= '
  &nbsp; <em>'._IB_MEMBERS.'</em>: <strong>
  '. $m .'</strong><br />
  '.$members.'<br />';
}

if ($g > 0)
{
	$content .= '
  &nbsp; <em>'._IB_GUESTS.'</em>: <strong>
  '. $g .'</strong><br />
  '.$guests.'<br />';
}



$content .= '
&nbsp; <em>'._IB_TOTAL_ONLINE.'</em>: <strong>
  '. ($m + $g) .'</strong><br />
</td></tr>';

// change the date/time format below, php.net/date
$content .= '
<tr><td>
<img src="images/blocks/time.png" alt=""> <strong>'._IB_SERVER_TIME.':</strong><br />
<div style="padding-left: 18px;">
'. date('M d, Y <b\r /> h:i a T').'
</div>
</td></tr>
';

$content .= '
</table>
<!-- END Info -->';


//pm,users,sessions
?>
