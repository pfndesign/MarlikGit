<?php

/**
*
* @package phpBB3 Latest Forum Block with advanced Jquery Pagination												
* @version $Id:  1:00 PM 5/29/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
*
*/
if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $prefix, $db, $sitename;

?>
<link rel="StyleSheet" href="<?php echo MODS_PATH?>JQ_Forums/style/JQ_forums.css" type="text/css" />
<script type="text/javascript" language="JavaScript" src="<?php echo MODS_PATH?>JQ_Forums/style/JQ_forums.js"></script>
<?php

require_once(MODS_PATH."JQ_Forums/functions.php");
$latestForums = JQ_Forums_PAGE(1);

/*--- FORUMS CONSTANTS :
// 
*/
$TopicsPerPage  = 15; // change this if you are seeking to view more topics
//---------------------


$count = $db->sql_query("SELECT tid FROM mybb_threads order by lastpost");
$forumspost = $db->sql_numrows($count);
$pages = ceil($forumspost / $TopicsPerPage);
$prevIMG='<span style="padding-left:10px;"><a  class="button" style="color:666666;" href="javascript:changePage()"  id="prevPage"  title="'.$pages.'"  >قبلی </a></span>';
$nextIMG='<span id="NextPage" ><a class="button" href="javascript:changePage()"  id="nextPage"  title="'.$pages.'" > بعدی </a></span>';
$latestForumsBTN = "
	<input type='hidden' id='current_page' />
	<input type='hidden' id='show_per_page' />
	<center>$prevIMG <span id='ForumsLoading'></span>$nextIMG</center>";


$content .= '
		<div class="jq_forums" >
		<div id="showDIV" style="overflow:auto;"><span class="footerDiv1Span">'.$latestForums.'</span></div>
		<div style="clear:both;float:none;margin:0px;"></div>
		<div style="margin:0px auto;text-align:center;margin-top:20px;">'.$latestForumsBTN.'
		<br></div>
		</div>	';

?>