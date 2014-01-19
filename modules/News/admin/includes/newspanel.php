<?php

/**
*
* @package News Panel														
* @version $Id: newspanel.php beta0.5   12/24/2009  5:51 PM  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $language, $admin, $aid, $prefix, $db,$admin_file,$pagenum,$nfy_msg;

include ('header.php');
GraphicAdmin();

jq_show_info('info','800','15500');
if ($nfy_msg) {
$nfy_msg = sql_quote($nfy_msg);
echo "<div id='info' class='notify' style='display:none;direction:ltr'>$nfy_msg</div>";
}


$dummy = 0;
$month = date('M');
$curDate2 = "%".$month[0].$month[1].$month[2]."%".date('d')."%".date('Y')."%";
$ty = time() - 86400;
$preday = strftime('%d', $ty);
$premonth = strftime('%B', $ty);
$preyear = strftime('%Y', $ty);
$curDateP = "%".$premonth[0].$premonth[1].$premonth[2]."%".$preday."%".$preyear."%";
$aid = substr($aid, 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper, admlanguage FROM ".$prefix."_authors WHERE aid='$aid'"));
$radminsuper = intval($row['radminsuper']);
$admlanguage = addslashes($row['admlanguage']);
$result = $db->sql_query("SELECT admins FROM ".$prefix."_modules WHERE title='News'");
$result2 = $db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'");
list($aidname) = $db->sql_fetchrow($result2);
$radminarticle = 0;
while (list($admins) = $db->sql_fetchrow($result)) {
	$admins = explode(",", $admins);
	$auth_user = 0;
	for ($i=0; $i < sizeof($admins); $i++) {
		if ($aidname == $admins[$i]) {
			$auth_user = 1;
		}
	}
	if ($auth_user == 1) {
		$radminarticle = 1;
	}
}
/*
if (!is_superadmin($admin)) {
	if (!empty($admlanguage)) {
		$queryalang = "WHERE alanguage='$admlanguage' ";
	} else {
		$queryalang = "";
	}
}
*/


function pagination_show(){
	global $db,$prefix;

?>
<style type="text/css">

a.page-numbers {
 background-color:#6C6B71;border-bottom:1px solid #b8d3e2;padding:3px;color:white;
}
a.page-numbers:hover {
 background-color:#9B9B9B;border-bottom:2px solid #CC0000;padding:3px;color:#CC0000;
}
.active {
 background-color:#98B3CE;border-bottom:2px solid #55A9F2;padding:4px;color:#FFFFCC;
}
</style>
<?php

$pagenum = $_GET['pagenum'];

$lim_num = 15;

$eachsidenum = 1;		// How many adjacent pages should be shown on each side?

$sql_pn = "select sid FROM ".$prefix."_stories";

$result_pn = $db->sql_query($sql_pn);

$totalnum = $db->sql_numrows($result_pn);

$numpages = ceil($totalnum / $lim_num);

$lpm1 = $numpages - 1;


if ($numpages > 1) {



	$prevpage = $pagenum - 1 ;
	$nextpage = $pagenum + 1 ;


	if (!$prevpage ==0 ) {
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$prevpage\">"._PREV_PAGE." »</a>";
	}


	if ($numpages < 7 + ($eachsidenum * 2))	//not enough pages to bother breaking it up
	{
		for ($counter = 1; $counter <= $numpages; $counter++)
		{
			if ($counter == $pagenum)
			$r .="<a  class='active' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\">&nbsp;$counter&nbsp;</a>";
			else
			$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\"  >&nbsp;$counter&nbsp;</a>";
		}

	}
	elseif($numpages > 5 + ($eachsidenum * 2))	//enough pages to hide some
	{			if($pagenum < 1 + ($eachsidenum * 2))
	{
		for ($counter = 1; $counter < 4 + ($eachsidenum * 2); $counter++)
		{
			if ($counter == $pagenum)
			$r .="<a  class=\"active\" href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\" >&nbsp;$counter&nbsp;</a>";
			else
			$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\">&nbsp;$counter&nbsp;</a>";
		}
		$r .="&nbsp; <a  class='page-numbers' href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$lpm1\"  >&nbsp;$lpm1&nbsp;</a>";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$numpages\" >&nbsp;$numpages&nbsp;</a>";
	}
	elseif($numpages - ($eachsidenum * 2) > $pagenum && $pagenum > ($eachsidenum * 2))
	{
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=1\" >&nbsp;1&nbsp;</a>";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=2\"  >&nbsp;2&nbsp;</a>";
		$r .="&nbsp; <a  class='page-numbers' href=\"\">&nbsp; ... &nbsp;</a>&nbsp;";
		for ($counter = $pagenum - $eachsidenum; $counter <= $pagenum + $eachsidenum; $counter++)
		{
			if ($counter == $pagenum)
			$r .="<a class=\"active\" href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\" >&nbsp;$counter&nbsp;</a>";
			else
			$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\" >&nbsp;$counter&nbsp;</a>";
		}
		$r .="&nbsp; <a  class='page-numbers' href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$lpm1\" >&nbsp;$lpm1&nbsp;</a>";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$numpages\" >&nbsp;$numpages&nbsp;</a>";
	}
	//close to end; only hide early pages
	else
	{
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=1\" >&nbsp;1&nbsp;</a>";
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=2\" >&nbsp;2&nbsp;</a>";
		$r .="&nbsp; <a  class='page-numbers' href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
		for ($counter = $numpages - (2 + ($eachsidenum * 2)); $counter <= $numpages; $counter++)
		{
			if ($counter == $pagenum)
			$r .="<a  class=\"active\" href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\" >&nbsp;$counter&nbsp;</a>";
			else
			$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$counter\" >&nbsp;$counter&nbsp;</a>";
		}
	}
	}

	if ($nextpage < $numpages ) {
		$r .="<a  class='page-numbers' href=\"".ADMIN_OP."ShowNewsPanel&pagenum=$nextpage\">« "._NEXT_PAGE."</a>";
	}

}
return  $r;

	
}
function count_post_status($value){
	global $db,$prefix;
	$num_post_status= $db->sql_numrows($db->sql_query("SELECT sid FROM ".$prefix."_stories WHERE approved='$value'"));
	return  $num_post_status ;
}

$order = $_GET['orderby'];
$mode = $_GET['mode'];
$get_status = $_GET['post_status'];


if ($order) {
	$orderby = " ORDER BY $order $mode ";
}else {
	$orderby = " ORDER BY time DESC ";
}

if ($get_status == "publish") {
	$post_status = " WHERE approved='1'";
}
elseif ($get_status == "submission") {
	$post_status = " WHERE approved='2'";
}
elseif ($get_status == "draft") {
	$post_status = " WHERE approved='3'";
}else {
	$post_status = "WHERE title <> 'draft'";
}


if (($radminarticle==1) OR ($aid == $said) OR ($radminsuper==1)) {
	
$num = $db->sql_numrows($db->sql_query("SELECT sid FROM ".$prefix."_stories $post_status"));

//-------- pagination ---
	$lim_num = 15 ;
	if (empty($pagenum)) { $pagenum = 1 ; }
	$offset = ($pagenum-1) * $lim_num ;
///----------------	

		$mainrez = $db->sql_query("SELECT 
 		sid ,catid,aid,title,time,comments,counter,topic,informant,ihome,
 		alanguage,acomm,hotnews,haspoll,pollID,associated,tags,approved,section
		FROM ".STORY_TABLE."	
		$post_status  $orderby limit $offset, $lim_num");



		if ($num > 15) {
			$style = 'style="margin:0px 10px;height:100%;min-height:100%;overflow:auto;text-align:center;"';
		}

		OpenTable();
		
		echo "
		<a href='".$admin_file.".php?op=adminStory' >
		<span style='float:left;text-align:left;'  class='button'><img src='images/icon/add.png' alt='"._ADD_PAGE."' ><b>"._ADD_PAGE."</b></span></a><br>
		
		<h3><a href='".ADMIN_OP."ShowNewsPanel'>"._ARTICLES."</a></h3>

		
		<div style='width:100%;text-align:".langStyle('align').";padding-top:30px;'>
		<a href='".ADMIN_OP."ShowNewsPanel&post_status=all'>"._ALL." <font color='gray'>($num)</font> </a>
		&nbsp;<a href='".ADMIN_OP."ShowNewsPanel&post_status=publish'>"._PUBLISHED." <font color='gray'>(".count_post_status(1).")</font> </a> 
		&nbsp;<a href='".ADMIN_OP."ShowNewsPanel&post_status=draft'>"._DRAFT." <font color='gray'>(".count_post_status(3).")</font></a> 
		&nbsp;<a href='".ADMIN_OP."ShowNewsPanel&post_status=submission'>"._SUBMITED." <font color='gray'>(".count_post_status(2).")</font></a><br><br>";
		
	/*	<form action=\"".$admin_file.".php\" method=\"post\">"
		.""._STORYID.": <input type=\"text\" NAME=\"sid\" SIZE=\"10\">"
		."<select name=\"op\">"
		."<option value=\"EditStory\" SELECTED>"._EDIT."</option>"
		."<option value=\"RemoveStory\">"._DELETE."</option>"
		."&nbsp; <input type=\"submit\" value=\""._OK."\">"
		."</select></form>
	*/	
		echo "<span style='padding-right:20px;'><form action=\"".$admin_file.".php?op=multi_task\"  method=\"POST\"  name='adminnews'  id='adminnews'>
		<select name=\"order\">"
		."<option  value='' selected>"._ORDERBY."</option>"
		."<option value=\"counter-desc\">"._ORDERBY_HIT_DESC."</option>"
		."<option value=\"time-asc\">"._ORDERBY_DATE_ASC."</option>"
		."</select>"
		."&nbsp; <input type=\"submit\" value=\""._OK."\">
		</span>


		
		</div>"
	
	

//---- list container ----
		."<div $style >"
		.'<table class="widefat post fixed" style="line-height:20px;margin-top:10px;" >
		<thead> 
		<tr> 
		<th scope="col">&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" /></th>
		<th scope="col">'._TITLE.'</th>
			<th scope="col" >نویسنده</th> 
			<th scope="col">'._SECTION.'</th>
			  <th scope="col">'._TOPICS.'</th>
			  <th scope="col">'._HITS.'</th>
		     	  <th scope="col">'.COMMENTS.'</th>
		     	  <th scope="col">'._DATE.'</th>
				    </tr>
						</thead>
<tfoot>
	<tr> 
	<th scope="col">&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" /></th>
		<th scope="col">'._TITLE.'</th>
			<th scope="col" >نویسنده</th> 
			<th scope="col">'._SECTION.'</th>
			  <th scope="col">'._TOPICS.'</th>
			  <th scope="col">'._HITS.'</th>
		     	  <th scope="col">'.COMMENTS.'</th>
		     	  <th scope="col">'._DATE.'</th>
				    </tr>
   					 </tfoot>
   						 <tbody>';	   
	if ($num > 0) {

			while (list(
 		$sid ,$catid,$aid,$title,$time,$comments,$counter,$topic,$informant,$ihome,
 		$alanguage,$acomm,$hotnews,$haspoll,$pollID,$associated,$tags,$approved,$section
			) = $db->sql_fetchrow($mainrez)) {
				
				
			if (empty($informant)) {$informant = $aid;	}// Informant maybe Admin himself so what's den ?
					

				if (empty($alanguage)) {
					$alanguage = ""._ALL."";
				}


		    	$date = date("Y-m-j H:i:s");
			
				$approved = intval($approved);
				if ($approved == "1") {
					$approved_style = "";
					$approved_img = "images/icon/page_edit.png";
					$approved_title = "";
				
				}elseif ($approved == "2") {
					$approved_style = "style='background:#FFE49A;color:#293154'";
					$approved_img = "images/icon/tick.png";
					$approved_title = _SUBMITED."-";
				}else {
					$approved_style = "style='background:#F1EEF5;color:#293154'";
					$approved_img = "images/icon/tick.png";
					$approved_title =  _DRAFT." -";
				}
				
				if ($time > $date) {
					$approved_style = "style='background:#F2F2F2;color:#BBBBBB'";
					$approved_img = "images/icon/time.png";
					$approved_title = _SCHEDULED." -";
					
				}
				
			if (empty($title)) {
				$title = '( <b>'._NO_TITLE.' </b>) ';
			}

			
			//-----------Show  Array of Categoies--------
			/*
			list($topicname) = $db->sql_fetchrow($db->sql_query("SELECT topicname FROM ".$prefix."_topics WHERE topicid='$topic'"));
			$topicname = check_html($topicname, "nohtml");
			if ($topicname=="") {
			$topicname = _NOTOPICNAME;
			}
			*/
			$topicnameshow = "";
			$query = $db->sql_query("SELECT associated FROM ".$prefix."_stories WHERE sid='$sid'");
			list($associated) = $db->sql_fetchrow($query);
			if (empty($associated)) {
				$topicnameshow = "";
			}else {
				$asso_t = explode("-",$associated);
				for ($i=0; $i<sizeof($asso_t)-1; $i++) {
					if (!empty($asso_t[$i])) {
						$query = $db->sql_query("SELECT topicname from ".$prefix."_topics WHERE topicid='".$asso_t[$i]."'");
						list($topicname) = $db->sql_fetchrow($query);
						$topicnameshow .="<a href='".ADMIN_OP."topicedit&topicid=".$asso_t[$i]."'>$topicname</a>,";
					}
				}
		
			}
			$db->sql_freeresult($query);
			

			//-----------List of News -------------------------
			if ($section !="news") {
				$section = ""._MESSAGECONTENT."";
			}else {
				$section = ""._NEWS."";
			}
				
echo "<tr id='trview-$sid' onmouseover='document.getElementById(\"options$sid\").style.display= \"\" '
		  onmouseout='document.getElementById(\"options$sid\").style.display=\"none\"'
		   style='display:;height:55px;' >
	  
			<td  $approved_style><input type=\"checkbox\" name=\"selecionar[]\"  class=\"selectbox\" value=\"$sid\" /></td>
			<td  $approved_style style='height:45px;'><a href=\"".ADMIN_OP."EditStory&sid=$sid\">$title</a><font color='black'> $approved_title</font>

			<span id='options$sid' style='display:none;vertical-align: text-middle;'><br>
			<a  href='".ADMIN_OP."EditStory&sid=$sid'>"._EDIT."</a> | 
			<a href='".ADMIN_OP."q_editstory&sid=$sid' style='color:#0001FF' class=\"colorbox\"  >"._QUICKEDIT."</a> | 
			<a style='color:#BC0B0B' href='".ADMIN_OP."RemoveStory&sid=$sid'>"._DELETE." </a>| 
			<a href='modules.php?name=News&file=article&sid=$sid'>"._PREVIEW."</a>
			</span>";
				

				//Lets c if we can make it like wordpress comment counter ---
					list($Tcomments) = $db->sql_fetchrow($db->sql_query("SELECT COUNT('tid') FROM  ".COMMENTS_TABLE."  WHERE sid='$sid' AND active='1' "));
					list($TWcomments) = $db->sql_fetchrow($db->sql_query("SELECT COUNT('tid') FROM  ".COMMENTS_TABLE."  WHERE sid='$sid'  AND active='0'"));
					$comment_css = "<a  href='".ADMIN_OP."EditStory&sid=$sid' title='$TWcomments "._NOT_MODERATED_COMMENTS."'
					 class='post-com-count' ><span class='comment-count' >$Tcomments</span></a><div style='clear:both;float:none'></div>";
			
				//-------
			
			echo "</td>
		   <td $approved_style><a href='".ADMIN_OP."modifyadmin&chng_aid=$informant'>$informant</a></td>
		   <td $approved_style >$section</td>
		   <td $approved_style >$topicnameshow</td>
		   <td $approved_style style='text-align:center;'>$counter</td>
		   <td $approved_style style='text-align:center;'>$comment_css</td>
		   <td $approved_style >".hejridate($time,4,7);"</td>"
			.'</tr>';
				
		}
		} else {
			echo "<tr><td>"._NOCONTENT."</td></tr>";
		}


		
	echo '	</tbody></table>';


		echo "<div style='text-align:".langStyle('align').";float:".langStyle('align').";padding-top:10px;'>
		<select name=\"act\">"
		."<option  value='noaction'  selected>"._BULK_ACTIONS."</option>"
		."<option value=\"del_stories\" >"._DELETESELECTED."</option>"
		."<option value=\"hot_stories\">"._MAKEHOTSELECTED."</option>"
		."<option value=\"del_st_comments\">"._DELETECOMMENTSELECTED."</option>"
		."</select>"
		."&nbsp; <input type=\"submit\" value=\""._OK."\" name=\"doaction\" id=\"doaction\">		
		</div><br></form>

		<div style='text-align:left;float:left;'>".pagination_show()."
		
		</div>";

		CloseTable();
	}else {
		show_error("YOU CAN NOT ACCESS THIS PAGE , CAUSE YOU ARE NOT AUTHORISED");
	}

include("footer.php");


?>