<?php
/**
 *
 * @package Persian PDF Generator														
 * @version  pdf.php $Id: $Aneeshtan 3:53 PM 1/20/2010						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
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


$sid = sql_quote(intval($sid));
$title = sql_quote($title);

if (empty($sid) AND empty($title) ) {
	show_error("ARTICLE YOU ARE REFERING IS TOTALY WRONG<BR>EMPTY SID OR TITLE");
}


global $db,$sitename,$prefix,$slogan,$currentlang;

$ctime = date("Y-m-j H:i-1:s");
$result = $db->sql_query("select * FROM ".$prefix."_stories where `approved`='1'  AND `time` <= '$ctime' AND  `section`='news' AND (`sid`='$sid' OR `title`='$title') limit 1
");
$numrows = $db->sql_numrows($result);
if (empty($numrows)) {
	show_error("ARTICLE ADDRESS YOU ARE REFERING DOES NOT EXIST IN OUR DATABASE<BR><BR>[<B>$title</B><BR>$sid</A>]");
}
	include_once(INCLUDES_PATH."inc_pdf.php");	
	while ($row = $db->sql_fetchrow($result)) {
		$catid = intval($row['catid']);
		$aid = check_html($row['aid'], "nohtml");
		$title = stripslashes(check_words(check_html($row['title'], "nohtml")));
		$time = $row['time'];
		$hometext = stripslashes(check_words(check_html($row['hometext'], "")));
		$bodytext = stripslashes(check_words(check_html($row['bodytext'], "")));
		$comments = stripslashes(check_words(check_html($row['comments'], "")));
		$topic = intval($row['topic']);
		$informant = check_html($row['informant'], "nohtml");
		$notes = stripslashes(check_words(check_html($row['notes'], "")));
		$acomm = intval($row['acomm']);
		$newsref = intval($row['newsref']);
		$newsreflink = intval($row['newsreflink']);
		$tags_id = $row['tags'];
		if ($catid > 0) {
		list($cattitle) = $db->sql_fetchrow($db->sql_query("SELECT title FROM ".STORY_TABLE."_cat WHERE catid='$catid'"));
		}
		formatTimestamp($time);
		//------Date Conversion-------
		$datetime = hejridate($time);	
		if ($currentlang == "persian"){$times="$datetime";}else {$times="$time";}
		//------Fetch Author's name -------
		if($informant != "" OR $aid != "" ) {
			if (empty($informant)) {
				$informant=$aid;
			}
			$author = "<a href=\"account/$informant\">$informant </a> " ._WRITES." ";
		}else {$author = "<img src=\"images/icon/user.png\">$anonymous " ._WRITES."  ";}

		$content = "<h3>$title</h3><hr>$hometext<br>$bodytext<i>$notes</i><hr>$author | $datetime\n";
}
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
$pdf->WriteHTML($content, true, 0, true, 0);
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output(''.$sitename.'-post-'.$sid.'.pdf', 'I');

?>