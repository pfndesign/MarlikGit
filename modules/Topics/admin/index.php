<?php
/**
*
* @package Topics														
* @version $Id:  0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE'))
{
	die("Access Denied");
}

define("ADMIN_TOPIC_INC", "modules/Topics/admin/includes/");
if (!defined("USV_VERSION")) {die(HACKING_ATTEMPT);}
global $prefix, $db, $admin_file;

echo '<link rel="StyleSheet" href="modules/Topics/admin/includes/topic.css" type="text/css" /> ';

global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of($module_name,$admin)) {
	
	function selecttopics($parentID,$parentName)
	{
		global $prefix, $db;
		$result = $db->sql_query("SELECT * from " .
		$prefix . "_topics order by topicname");

		$selCats = '<select name="topicparent" id="topicparent">';
		if (!empty($parentID)) {
				$selCats .= '<option value="'.$parentID.'" selected>' . $parentName . '</option>';
		}
		$selCats .='<option value="-1">'._NONE.'</option>';
		while ($row = $db->sql_fetchrow($result))
		{

			$topicid = intval($row['topicid']);
			$parent = intval($row['parent']);
			$topicname = check_html($row['topicname'], "nohtml");
			$topicimage = check_html($row['topicimage'], "nohtml");
			$topictext = check_html($row['topictext'], "nohtml");

			if (!empty($parentID)) {
			if ($topicid <> $parentID) {
			$selCats .= '<option value="'.$topicid.'">' . $topicname . '</option>';
			}
			}else {
			$selCats .= '<option value="'.$topicid.'">' . $topicname . '</option>';
			}


		}
		$selCats .= '</select>';
		$db->sql_freeresult($result);
		return $selCats;
		echo $parentID,$parentName;
	}

	function CreateNewCat()
	{
		global $prefix, $db, $admin_file, $tipath;
		$CNC = "<h2 style='text-align:right;'>" . _ADDATOPIC . "</h2>" .
		"<form action=\"" . $admin_file . ".php\" method=\"post\" style='line-height:40px;'>" .
		"<label>" . _TOPICNAME . ":</label><br>" . "<input type=\"text\" name=\"topicname\" style='height:30px;width:500px'>
		 <br>
		 " . _TOPICNAME1 . "
		 <br>" . "<label>"._SLUG.":</label><br>" . "<input type=\"text\" name=\"slug\" style='height:30px;width:500px'>
		 <br>
		 "._SLUG_HELP."
		 <br>" . '<div class="form-field">
		<label>'._HEAD_CATEGORY.' : </label><br>' . selecttopics("","") . '
		<p>'._ADMIN_TOPICS_CATEGORY.' </p>

		</div>' . "<label>"._DESCRIPTION.":</label><br>" .
		"<textarea name='topictext' id='topictext' rows='5' cols='40' style='height:100px;width:500px'></textarea>
		<br>
		 " . _TOPICTEXT1 . "
		 <br>" . "<b>" . _TOPICIMAGE . ":</b>  " . "<select name=\"topicimage\" dir='ltr'>";
		$handle = opendir($tipath);
		while ($file = readdir($handle))
		{
			if ((preg_match("/^([_0-9a-zA-Z]+)([.]{1})([_0-9a-zA-Z]{3})$/", $file)) and $file !=
			"AllTopics.gif")
			{
				$tlist .= "$file ";
			}
		}
		closedir($handle);
		$tlist = explode(" ", $tlist);
		sort($tlist);
		for ($i = 0; $i < sizeof($tlist); $i++)
		{
			if (!empty($tlist[$i]))
			{
				$CNC .= "<option name=\"topicimage\" value=\"$tlist[$i]\">$tlist[$i]\n";
			}
		}
		$CNC .= "</select><br><br>" . "<input type=\"hidden\" name=\"op\" value=\"topicmake\">" .
		"
		<a href='".ADMIN_OP."resetTopics_counts' class='button'>"._RECOUNT ." "._TOPICS." </a>
		<input type=\"submit\" value=\"" . _ADDTOPIC . "\">" . "</form>";

		return $CNC;
	}

	function count_stories_topic($id){
		global $db,$prefix;
		$id = sql_quote($id);
		$query = $db->sql_query("SELECT * FROM ".$prefix."_stories WHERE associated LIKE '%{$id}%' ");
		$numstories =$db->sql_numrows($query);
		$db->sql_freeresult($query);
		return $numstories;	


	}

	function ListCats($total='15', $order='' , $condition)
	{
		global $prefix, $db, $admin_file, $tipath,$TPage;

		
		
		$listCats .= '
		<table class="widefat fixed" cellspacing="0">
   		<thead>
		<tr>
		<th scope="col"  style=""><input type="checkbox" /></th>
		<th scope="col"  style="">' . _TITLE . '</th>
		<th scope="col"  style="">' . _SLUG . '</th>
		<th scope="col"  style="">' . _IMAGE . '</th>
		<th scope="col"  style="">' . _POSTS . '</th>
		<th scope="col"  style="">' . _FUNCTIONS . '</th>
		</tr>
		</thead>';

		$listCats .= '<tfoot>
		<tr>
		<th scope="col"  style=""><input type="checkbox" /></th>
		<th scope="col"  style="">' . _TITLE . '</th>
		<th scope="col"  style="">' . _SLUG . '</th>
		<th scope="col"  style="">' . _IMAGE . '</th>
		<th scope="col"  style="">' . _POSTS . '</th>
		<th scope="col"  style="">' . _FUNCTIONS . '</th>
		</tr>
		</tfoot>
		<tbody>';


		$totalcats = $db->sql_numrows($db->sql_query("SELECT * From ".$prefix."_topics $condition"));
		if (empty($TPage)) { $TPage = 1 ; }
		$offset = ($TPage-1) * $total ;
		if($totalcats==0) die('<div class="error">موضوعی با کلیدواژه مورد نظر شما یافت نشد</div>');

		
		$result = $db->sql_query("SELECT * From ".$prefix."_topics $condition order by topicid DESC LIMIT $offset, $total")or die(mysql_error());
		while ($row = $db->sql_fetchrow($result))
		{
			$topicid = intval($row['topicid']);
			$topicname = check_html($row['topicname'], "nohtml");
			$topicname = htmlentities($topicname, ENT_QUOTES, "UTF-8");

			if(!empty($condition)){
			$query2highlight = preg_replace("/WHERE `topicname` LIKE '%/i","",$condition);
			$query2highlight = preg_replace("/%'/i","",$query2highlight);
				$topicname = preg_replace("/\w*?".urldecode($query2highlight)."\w*/i", "<font color='red'>$0</font>", $topicname);
			}
			
			
			$topicimage = check_html($row['topicimage'], "nohtml");
			$topictext = check_html($row['topictext'], "nohtml");
			$slug = Deslug($row['slug']);
			$counter = sql_quote(intval($row['counter']));
			$topicparent = sql_quote(intval($row['parent']));
			list($topicparentname)= $db->sql_fetchrow($db->sql_query("select topicname From ".$prefix."_topics Where topicid='$topicparent'"));
			$topicname = !empty($topicparent) ? "$topicname-<b>$topicparentname</b>" : "$topicname";



			$listCats .= "
			
			<th scope='row' class='check-column'>&nbsp; <input type='checkbox' name='delete_tags[]' value='1' /></th>
			<td>$topicname</td>"
			//<td>$topictext</td>
			."<td>$slug</td>
			<td><img src=\"$tipath/$topicimage\" border=\"0\" alt=\"\" width='25px' height='25px'> </td>
			<td>".count_stories_topic($topicid)."</td>
			<td><a href=\"" . $admin_file . ".php?op=topicedit&amp;topicid=$topicid\"><img src=\"images/edit.gif\">
			<a href=\"" . $admin_file . ".php?op=topicdelete&topicid=$topicid\"><img src=\"images/delete.gif\"></a></td></tr>";

		}

		$listCats .= "</tbody></table>";
		
		$listCats .= "<div style='position:relative;'><br>";
		$listCats .= T_Pagination($totalcats,15);
		
		return $listCats;
	}

	function T_Pagination($totalPages,$eachPage){

	global $TPage;
	if (empty($TPage)) {
		$TPage = 1;
	}
	
	$totalPages = intval($totalPages);
	$Listpages = ceil($totalPages / $eachPage);
	$output = "<div id='pagination-digg' >";

	for ($i=1; $i < $Listpages+1; $i++) {
	if ($TPage==$i) {
		$output .=  "<a href=''  class=\"active\"><b>$i</b></a>";
	}else {
		$output .=  "<a href='".ADMIN_OP."topicsmanager&TPage=$i'><b>$i</b></a>";
	}

	}
	
	return $output;

}
	
	function topicsmanager()
	{
		global $prefix, $db, $admin_file, $tipath;
		include ("header.php");
		GraphicAdmin();
		echo "<h2 style='text-align:right;padding:5px;'>" . _TOPICSMANAGER ."</h2><br>";
		echo "<table width='100%'><tr>
		<td style='width:40%;padding-right:50px;vertical-align:top'  class='box_wrapper'>";
		echo CreateNewCat();
		echo "</td><td style='width:50%;vertical-align:top' class='box_wrapper'>";
		echo "<h3 style='text-align:right;padding:5px;'>" . _CURRENTTOPICS .
		"</h3>";
				
		//LIVE SEARCH:
		echo "<script type='text/javascript'>
			$(document).ready(function(){

			$('#stq').keyup(function()	{
				searchtopics();
			});
			
			});
		</script>
		";	
		
		echo '<form action="'.ADMIN_OP.'SearchTopics" method="POST" class="box_wrapper" id="searchtopicsform" onSubmit="return searchtopics(); return false;"> <img src="images/view.gif">  '._SEARCH.' :  <input type="text" name="stq" id="stq" value=""> <input onClick="javascript:searchtopics(); return false;" type="submit" value="'._GO.'"></form>';
		echo '<div id="topiclist">'.ListCats('20','','').'</div>';
		echo "</td></tr></table>";
		include ("footer.php");
	}

	function topicedit($topicid)
	{
		global $prefix, $db, $admin_file, $tipath;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<h3 style='text-align:left;'><a href='".ADMIN_OP."topicsmanager'><img src='images/icon/arrow_undo.png'>"._TOPICSMANAGER."</h3></a>";
		$topicid = intval($topicid);
		$row = $db->sql_fetchrow($db->sql_query("SELECT * from " .
		$prefix . "_topics where topicid='$topicid'"));
		$topicid = intval($row['topicid']);
		$topicname = check_html($row['topicname'], "nohtml");
		$topicimage = check_html($row['topicimage'], "nohtml");
		$topictext = check_html($row['topictext'], "nohtml");
		$slug = sql_quote($row['slug']);
		$parent = intval($row['parent']);
		
		list($topicparentname)= $db->sql_fetchrow($db->sql_query("select topicname From ".$prefix."_topics Where topicid='$parent'"));

		echo "<img src=\"$tipath/$topicimage\" border=\"0\" align=\"right\" alt=\"$topictext\">" .
		"<h2><b>" . _EDITTOPIC . ": $topictext</b></h2>" .
		"<br><br>" . "<form action=\"" . $admin_file . ".php\" method=\"post\" style='line-height:30px;'><br>" .
		"<label>" . _TOPICNAME . ":</label><br>" . "<input type=\"text\" name=\"topicname\" style='height:30px;width:500px'  value='$topicname'>
		 <br>
		 " . _TOPICNAME1 . "
		 <br>" . "<label>"._SLUG."</label><br>" . "<input type=\"text\" name=\"slug\" style='height:30px;width:500px' value='".Deslug($slug)."'>
		 <br>
		"._SLUG_HELP."
		 <br>" . '<div class="form-field">
		<label>'._HEAD_CATEGORY.': </label><br>' . selecttopics($parent,$topicparentname) . '
		<p>'._ADMIN_TOPICS_CATEGORY.' </p>

		</div>'
		."<b>" . _TOPICIMAGE . ":</b><br>" . "<select name=\"topicimage\" dir='ltr'>";
		$handle = opendir($tipath);
		while ($file = readdir($handle))
		{
			if ((ereg("^([_0-9a-zA-Z]+)([.]{1})([_0-9a-zA-Z]{3})$", $file)) and $file !=
			"AllTopics.gif")
			{
				$tlist .= "$file ";
			}
		}
		closedir($handle);
		$tlist = explode(" ", $tlist);
		sort($tlist);
		for ($i = 0; $i < sizeof($tlist); $i++)
		{
			if (!empty($tlist[$i]))
			{
				if ($topicimage == $tlist[$i])
				{
					$sel = "selected";
				}
				else
				{
					$sel = "";
				}
				echo "<option name=\"topicimage\" value=\"$tlist[$i]\" $sel>$tlist[$i]\n";
			}
		}
		echo "</select><br>"

		. "<br><label>"._DESCRIPTION."</label><br>" .
		"<textarea name='topictext' id='topictext' rows='5' cols='40' style='height:100px;width:500px' > $topictext</textarea>
		<br>
		 " . _TOPICTEXT1 . "
		<hr><br>" . "<b>" . _ADDRELATED . ":</b><br>" . "" . _SITENAME .
		": <input type=\"text\" name=\"name\" size=\"30\" maxlength=\"30\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(name)><br>" .
		"" . _URL . ": <input type=\"text\" name=\"url\" value=\"http://\" size=\"50\" maxlength=\"200\" dir='ltr'><br><br>" .
		"<b>" . _ACTIVERELATEDLINKS . ":</b><br>" . "<table width=\"100%\" border=\"0\">";
		$res = $db->sql_query("SELECT rid, name, url from " . $prefix .
		"_related where tid='$topicid'");
		$num = $db->sql_numrows($res);
		if ($num == 0)
		{
			echo "<tr><td><font class=\"tiny\">" . _NORELATED . "</font></td></tr>";
		}
		while ($row2 = $db->sql_fetchrow($res))
		{
			$rid = intval($row2['rid']);
			$name = check_html($row2['name'], "nohtml");
			$url = check_html($row2['url'], "nohtml");
			echo "<tr><td align=\"left\"><font class=\"content\"><strong><big>&middot;</big></strong>&nbsp;&nbsp;<a href=\"$url\">$name</a></td>" .
			"<td align=\"center\"><font class=\"content\"><a href=\"$url\">$url</a></td><td align=\"right\"><font class=\"content\">[ <a href=\"" .
			$admin_file . ".php?op=relatededit&amp;tid=$topicid&amp;rid=$rid\">" . _EDIT .
			"</a> | <a href=\"" . $admin_file . ".php?op=relateddelete&amp;tid=$topicid&amp;rid=$rid\">" .
			_DELETE . "</a> ]</td></tr>";
		}
		echo "</table><br><br>" . "<input type=\"hidden\" name=\"topicid\" value=\"$topicid\">" .
		"<input type=\"hidden\" name=\"op\" value=\"topicchange\">" . "<INPUT type=\"submit\" value=\"" .
		_SAVECHANGES . "\"> <font class=\"content\">[ <a href=\"" . $admin_file .
		".php?op=topicdelete&amp;topicid=$topicid\">" . _DELETE . "</a> ]</font>" .
		"</form>";
		CloseTable();
		include ("footer.php");
	}

	function relatededit($tid, $rid)
	{
		global $prefix, $db, $admin_file, $tipath;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>" . _TOPICSMANAGER .
		"</b></font></center>";
		CloseTable();
		echo "<br>";
		$rid = intval($rid);
		$tid = intval($tid);
		$row = $db->sql_fetchrow($db->sql_query("SELECT name, url from " . $prefix .
		"_related where rid='$rid'"));
		$name = check_html($row['name'], "nohtml");
		$url = check_html($row['url'], "nohtml");
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT topictext, topicimage from " .
		$prefix . "_topics where topicid='$tid'"));
		$topicimage = check_html($row2['topicimage'], "nohtml");
		$topictext = check_html($row2['topictext'], "nohtml");
		OpenTable();
		echo "<center>" . "<img src=\"$tipath/$topicimage\" border=\"0\" alt=\"$topictext\" align=\"right\">" .
		"<font class=\"option\"><b>" . _EDITRELATED . "</b></font><br>" . "<b>" .
		_TOPIC . ":</b> $topictext</center>" . "<form action=\"" . $admin_file .
		".php\" method=\"post\">" . "" . _SITENAME . ": <input type=\"text\" name=\"name\" value=\"$name\" size=\"30\" maxlength=\"30\"><br><br>" .
		"" . _URL . ": <input type=\"text\" name=\"url\" value=\"$url\" size=\"60\" maxlength=\"200\"><br><br>" .
		"<input type=\"hidden\" name=\"op\" value=\"relatedsave\">" . "<input type=\"hidden\" name=\"tid\" value=\"$tid\">" .
		"<input type=\"hidden\" name=\"rid\" value=\"$rid\">" . "<input type=\"submit\" value=\"" .
		_SAVECHANGES . "\"> " . _GOBACK . "" . "</form>";
		CloseTable();
		include ("footer.php");
	}

	function relatedsave($tid, $rid, $name, $url)
	{
		global $prefix, $db, $admin_file;
		$rid = intval($rid);
		$name = addslashes(check_words(check_html($name, "nohtml")));
		$url = addslashes(check_words(check_html($url, "nohtml")));
		$db->sql_query("update " . $prefix . "_related set name='$name', url='$url' where rid='$rid'");
		Header("Location: " . $admin_file . ".php?op=topicedit&topicid=$tid");
	}

	function relateddelete($tid, $rid)
	{
		global $prefix, $db, $admin_file;
		$rid = intval($rid);
		$db->sql_query("delete from " . $prefix . "_related where rid='$rid'");
		Header("Location: " . $admin_file . ".php?op=topicedit&topicid=$tid");
	}

	function topicmake($topicname, $topicimage,$slug,$topictext,$topicparent)
	{
		global $prefix, $db, $admin_file;
		$topicimage = addslashes(check_words(check_html($topicimage, "nohtml")));
		$topictext = addslashes(check_words(check_html($topictext, "nohtml")));
		$topicname = addslashes(check_words(check_html($topicname, "nohtml")));
		$topicparent = sql_quote(intval($topicparent));
		$slug = sql_quote(Slugit($slug));
		if (empty($slug)) { $slug = Slugit($topicname);}
		
		$db->sql_query("INSERT INTO " . $prefix . "_topics VALUES (NULL,'$topicname','$slug','$topicimage','$topictext','$topicparent','0')");
		Header("Location: " . $admin_file . ".php?op=topicsmanager");
	}

	function topicchange($topicid, $topicname, $topicimage, $slug,$topictext,$topicparent, $name, $url)
	{
		global $prefix, $db, $admin_file, $tipath;
		$topicname = addslashes(check_words(check_html($topicname, "nohtml")));
		$topicname = addslashes(check_words(check_html($topicname, "nohtml")));
		$topicname = addslashes(check_words(check_html($topicname, "nohtml")));
		$topicname = addslashes(check_words(check_html($topicname, "nohtml")));
		$url = addslashes(check_words(check_html($url, "nohtml")));
		$topicid = intval($topicid);
		$topicparent = sql_quote(intval($topicparent));
		$slug = sql_quote(Slugit($slug));

		$db->sql_query("update " . $prefix . "_topics set topicname='$topicname', slug='$slug', topicimage='$topicimage', topictext='$topictext',parent='$topicparent' where topicid='$topicid'");
		if (!$name)
		{
		}
		else
		{
			$db->sql_query("insert into " . $prefix . "_related VALUES (NULL, '$topicid','$name','$url')");
		}
		Header("Location: " . $admin_file . ".php?op=topicsmanager");
	}

	function topicdelete($topicid, $ok = 0)
	{
		global $prefix, $db, $admin_file;
		$topicid = intval($topicid);
		if ($ok == 1)
		{
			$row = $db->sql_fetchrow($db->sql_query("SELECT sid from " . $prefix .
			"_stories where topic='$topicid'"));
			$sid = intval($row['sid']);
			$db->sql_query("delete from " . $prefix . "_stories where topic='$topicid'");
			$db->sql_query("delete from " . $prefix . "_topics where topicid='$topicid'");
			$db->sql_query("delete from " . $prefix . "_related where tid='$topicid'");
			$row2 = $db->sql_fetchrow($db->sql_query("SELECT sid from " . $prefix .
			"_comments where sid='$sid'"));
			$sid = intval($row2['sid']);
			$db->sql_query("delete from " . $prefix . "_comments where sid='$sid'");
			Header("Location: " . $admin_file . ".php?op=topicsmanager");
		}
		else
		{
			global $topicimage;
			include ("header.php");
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>" . _TOPICSMANAGER .
			"</b></font></center>";
			CloseTable();
			echo "<br>";
			$row3 = $db->sql_fetchrow($db->sql_query("SELECT topicimage, topictext from " .
			$prefix . "_topics where topicid='$topicid'"));
			$topicimage = check_html($row3['topicimage'], "nohtml");
			$topictext = check_html($row3['topictext'], "nohtml");
			OpenTable();
			echo "<center><img src=\"$tipath/$topicimage\" border=\"0\" alt=\"$topictext\"><br><br>" .
			"<b>" . _DELETETOPIC . " $topictext</b><br><br>" . "" . _TOPICDELSURE .
			" <i>$topictext</i>?<br>" . "" . _TOPICDELSURE1 . "<br><br>" . "[ <a href=\"" .
			$admin_file . ".php?op=topicsmanager\">" . _NO . "</a> | <a href=\"" . $admin_file .
			".php?op=topicdelete&amp;topicid=$topicid&amp;ok=1\">" . _YES .
			"</a> ]</center><br><br>";
			CloseTable();
			include ("footer.php");
		}
	}

	function resetTopics_counts(){
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		ListCats('20','','');
		
		global $db;
		$db->sql_query("UPDATE "._TOPICS_TABLE."  SET `counter`=0");
		$result = $db->sql_query("SELECT * FROM "._TOPICS_TABLE."");
		$a = 1;	
		while($row = $db->sql_fetchrow($result)) {
			list($CATcount) = $db->sql_fetchrow($db->sql_query("
			SELECT COUNT(*) from ".STORY_TABLE." WHERE 
			FIND_IN_SET('".$row['topicid']."', REPLACE(`associated`, '-', ','))"));
			$querycount = $db->sql_query("UPDATE "._TOPICS_TABLE." SET `counter`='$CATcount' WHERE `topicid`='".$row['topicid']."'");
			$success .= "#".$row['topicname']." : <b>$CATcount</b><br>";
		if (!$querycount) {
				$error .= "خطا در موضوع :
				".$row['topicname']."<br>
				";
		}
		}
		$db->sql_freeresult($result);
		if (!empty($success)) {
			echo "<div class='success'>$success</div>";
		}
		if (!empty($error)) {
			echo "<div class='error'>$error</div>";
		}
		echo "<b>بازشماری موضوعات به اتمام رسید</b><br>
		<br><br><a href='".ADMIN_OP."topicsmanager' class='button'>بازگشت به مدیریت موضوعات </a>
		";
		
		CloseTable();
		include ("footer.php");
	}

	
	//Search Live
	function SearchTopics(){
	
		$query = sql_quote($_POST['stq']);
		$query = htmlentities($query, ENT_QUOTES, "UTF-8");

		echo ListCats($total='20', $order='',"WHERE `topicname` LIKE '%".$query."%'");
		
	}
	
	
	switch ($op)
	{

		case "topicsmanager":
			topicsmanager();
			break;

		case "topicedit":
			topicedit($topicid);
			break;

		case "topicmake":
			topicmake($topicname, $topicimage,$slug,$topictext,$topicparent);
			break;

		case "topicdelete":
			topicdelete($topicid, $ok);
			break;

		case "topicchange":
			topicchange($topicid, $topicname, $topicimage, $slug,$topictext,$topicparent, $name, $url);
			break;

		case "relatedsave":
			relatedsave($tid, $rid, $name, $url);
			break;

		case "relatededit":
			relatededit($tid, $rid);
			break;

		case "relateddelete":
			relateddelete($tid, $rid);
			break;

		case "ListCats":
			ListCats($total='20', $order='',$condition);
			break;

		case "resetTopics_counts":
			resetTopics_counts();
			break;

		case "SearchTopics":
			SearchTopics();
			break;

	}


}else {
	die("Access Denied To $module_name administration");
}
?>