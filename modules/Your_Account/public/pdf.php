<?php
/**
 *
 * @package Persian PDF Generator														
 * @version  pdf.php $Id: $Aneeshtan 3:53 PM 1/20/2010						
 * @copyright (c)Marlik Group  http://www.MarlikCMS.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
if ( !defined('MODULE_FILE') )
{
show_error(HACKING_ATTEMPT);
}
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);


$username = sql_quote($username);

if (empty($username) ) {
	show_error("BLOG USERNAME $username YOU ARE REFERING IS TOTALY WRONG");
}



global $db,$prefix,$sitename,$slogan,$currentlang;

$ctime = date("Y-m-j H:i-1:s");
$result = $db->sql_query("select * FROM ".$prefix."_users where username='$username'");
$numrows = $db->sql_numrows($result);
if (empty($numrows)) {
	show_error("BLOG USERNAME $username YOU ARE REFERING DOES NOT EXIST IN OUR DATABASE");
}
$owner = $db->sql_fetchrow($result);

	include_once(INCLUDES_PATH."inc_pdf.php");	

	global $db,$userinfo,$prefix;
	$user_blog_colors = explode("#",$owner['user_blog_colors']);
	$blog_userid = $owner['user_id'];
	$blog_username = $owner['username'];

	$db->sql_freeresult($result);
	$result = $db->sql_query("SELECT * FROM " . BLOG_TABLE . " WHERE sender = '$blog_userid' AND tid='0'
ORDER BY bid DESC");
	$numit = $db->sql_numrows($result);
	
	if (!empty($numit)) {

		while ($row = $db->sql_fetchrow($result)){

			$bid = sql_quote(intval($row['bid']));
			$tid = sql_quote(intval($row['tid']));
			$blogtext = stripslashes(FixQuotes($row['content']));
			$date = hejridate($row['date'],1,3);
			$like = sql_quote(intval($row['like']));
			$unlike = sql_quote(intval($row['unlike']));

			$sender_id = $row['sender'];
			$sender_name= $row['sender_name'];
			$reciever_id = $row['reciever'];
			$reciever_name = $row['reciever_name'];


			$content .= "<li class='bar$bid'>\n
			<div style='background:#".$user_blog_colors[1]."' class='BPostRow'>\n";
			$content .= '<p>تاریخ ارسال : '.$date.'<br><br>
			'.analyse_content($blogtext,1,0,1).'</p>';			
			$content .= '</div>';
			$content .= '<div class="clear"></div> <b>دیدگاه ها :</b><br>';

			//-- Reply 1st -------------------
			$comment_count = count_blog_posts($bid,$blog_username,'THIS_POST');


			$replysqlrez = $db->sql_query("SELECT * FROM " . BLOG_TABLE . " WHERE tid = '$bid' ORDER BY bid ASC ");

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


				$classReply = ($reply_sender_name==$blog_username) ? "BAdminReplyRow" :  "BReplyRow";
				$ColorReply = ($reply_sender_name==$blog_username) ? "".$user_blog_colors[3]."" :  "".$user_blog_colors[2]."";

				$content .= "<div style='background:#".$ColorReply."'  class='$classReply'  id='comment$reply_bid'>";
				$content .= '<blockquote>-- <b>'.$reply_sender_name.' : </b>'.analyse_content($content_r1,1,0,1).'</blockquote>';
				$content .= '</div>
				<div class="clear"></div>';
		
			}
			$db->sql_freeresult($replysqlrez);

			$content .= "<br><hr>\n";
			$content .= "</li>\n\n";
		}
		$db->sql_freeresult($result);
	}else {
		$content .= "<div id='noblogpost'>
	"._YA_NOBLOGPOST."
	</div>";
	}

	$content .= '<br style="margin:0px auto;clear:both;">';

	$content .= "<div class='ucp_block_header'>";
	if ($userinfo['username'] == $blog_username) {
		$content .= "
"._YA_TOTAL_POSTS.":<b> ".count_blog_posts(0,$blog_username,'ALL')."</b>
"._YA_BLOG_POSTS."<b> ".count_blog_posts(0,$blog_username,'BLOG_POSTS')."</b>
";
	}

	$content .="</div>";
	$content .= "<br>";
	
// ---------------------------------------------------------
// set document information
$pdf->SetHeaderData('', '', $sitename, $slogan);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(''.$author.'');
$pdf->SetTitle(''.$title.'');
// set font
$pdf->SetFont('dejavusans', '', 11);
// add a page
$pdf->AddPage();
$pdf->WriteHTML("دست نوشته های $username <hr><br>", true, 0, true, 0);
$pdf->WriteHTML($content, true, 0, true, 0);
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output(''.$sitename.'-post-'.$sid.'.pdf', 'I');

?>