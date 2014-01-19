<?php

/**
*
* @package Admin_Story	categories													
* @version $Id: categories.php RC-7  2:03 AM 1/4/2010  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

	function SelectCategory($cat) {
		global $prefix, $db, $admin_file;
		$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat order by title");
		$a = 1;
		echo "&nbsp;&nbsp;<b>"._CATEGORY."</b> ";
		echo "<select name=\"catid\">";
		if ($cat == 0) {
			$sel = "selected";
		} else {
			$sel = "";
		}
		echo "<option name=\"catid\" value=\"0\" $sel>"._ARTICLES."</option>";
		while(list($catid, $title) = $db->sql_fetchrow($selcat)) {
			$catid = intval($catid);
			$title = check_html($title, "nohtml");
			if ($catid == $cat) {
				$sel = "selected";
			} else {
				$sel = "";
			}
			echo "<option name=\"catid\" value=\"$catid\" $sel>$title</option>";
			$a++;
		}
		echo "</select> &nbsp; <a href=\"".$admin_file.".php?op=AddCategory\"><img src=\"images/add.gif\" alt=\""._ADD."\" title=\""._ADD."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=EditCategory\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>  <a href=\"".$admin_file.".php?op=DelCategory\"><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>";
	}
	

	function AddCategory () {
		global $admin_file;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"option\"><b>"._CATEGORYADD."</b></font><br><br><br>"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<b>"._CATNAME.":</b> "
		."<input type=\"text\" name=\"cat_title\" size=\"22\" maxlength=\"20\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);><br><IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(title)><br> "
		."<input type=\"hidden\" name=\"op\" value=\"SaveCategory\">"
		."<input type=\"submit\" value=\""._SAVE."\">"
		."</form></center>";
		CloseTable();
		include("footer.php");
	}

	function EditCategory($catid) {
		global $prefix, $db, $admin_file;
		$catid = intval($catid);
		$result = $db->sql_query("select title from ".$prefix."_stories_cat where catid='$catid'");
		list($title) = $db->sql_fetchrow($result);
		$title = check_html($title, "nohtml");
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"option\"><b>"._EDITCATEGORY."</b></font><br>";
		if (!$catid) {
			$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat");
			echo "<form action=\"".$admin_file.".php\" method=\"post\">";
			echo "<b>"._ASELECTCATEGORY."</b>";
			echo "<select name=\"catid\">";
			echo "<option name=\"catid\" value=\"0\" $sel>Articles</option>";
			while(list($catid, $title) = $db->sql_fetchrow($selcat)) {
				$catid = intval($catid);
				$title = check_html($title, "nohtml");
				echo "<option name=\"catid\" value=\"$catid\" $sel>$title</option>";
			}
			echo "</select>";
			echo "<input type=\"hidden\" name=\"op\" value=\"EditCategory\">";
			echo "<input type=\"submit\" value=\""._EDIT."\"><br><br>";
			echo ""._NOARTCATEDIT."";
		} else {
			echo "<form action=\"".$admin_file.".php\" method=\"post\">";
			echo "<b>"._CATEGORYNAME.":</b> ";
			echo "<input type=\"text\" name=\"title\" size=\"22\" maxlength=\"20\" value=\"$title\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);><br><IMG src=\"images/fa2.gif\" style=\"CURSOR: hand\" onclick=change(title)><br> ";
			echo "<input type=\"hidden\" name=\"catid\" value=\"$catid\">";
			echo "<input type=\"hidden\" name=\"op\" value=\"SaveEditCategory\">";
			echo "<input type=\"submit\" value=\""._SAVECHANGES."\"><br><br>";
			echo ""._NOARTCATEDIT."";
			echo "</form>";
		}
		echo "</center>";
		CloseTable();
		include("footer.php");
	}

	function DelCategory($cat) {
		global $prefix, $db, $admin_file;
		$cat = intval($cat);
		$result = $db->sql_query("select title from ".$prefix."_stories_cat where catid='$cat'");
		list($title) = $db->sql_fetchrow($result);
		$title = check_html($title, "nohtml");
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"option\"><b>"._DELETECATEGORY."</b></font><br>";
		if (!$cat) {
			$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat");
			echo "<form action=\"".$admin_file.".php\" method=\"post\">"
			."<b>"._SELECTCATDEL.": </b>"
			."<select name=\"cat\">";
			while(list($catid, $title) = $db->sql_fetchrow($selcat)) {
				$catid = intval($catid);
				$title = check_html($title, "nohtml");
				echo "<option name=\"cat\" value=\"$catid\">$title</option>";
			}
			echo "</select>"
			."<input type=\"hidden\" name=\"op\" value=\"DelCategory\">"
			."<input type=\"submit\" value=\"Delete\">"
			."</form>";
		} else {
			$result2 = $db->sql_query("select * from ".$prefix."_stories where catid='$cat'");
			$numrows = $db->sql_numrows($result2);
			if ($numrows == 0) {
				$db->sql_query("delete from ".$prefix."_stories_cat where catid='$cat'");
				echo "<br><br>"._CATDELETED."<br><br>"._GOTOADMIN."";
			} else {
				echo "<br><br><b>"._WARNING.":</b> "._THECATEGORY." <b>$title</b> "._HAS." <b>$numrows</b> "._STORIESINSIDE."<br>"
				.""._DELCATWARNING1."<br>"
				.""._DELCATWARNING2."<br><br>"
				.""._DELCATWARNING3."<br><br>"
				."<b>[ <a href=\"".$admin_file.".php?op=YesDelCategory&amp;catid=$cat\">"._YESDEL."</a> | "
				."<a href=\"".$admin_file.".php?op=NoMoveCategory&amp;catid=$cat\">"._NOMOVE."</a> ]</b>";
			}
		}
		echo "</center>";
		CloseTable();
		include("footer.php");
	}

	function YesDelCategory($catid) {
		global $prefix, $db, $admin_file;
		$catid = intval($catid);
		$db->sql_query("delete from ".$prefix."_stories_cat where catid='$catid'");
		$result = $db->sql_query("select sid from ".$prefix."_stories where catid='$catid'");
		while(list($sid) = $db->sql_fetchrow($result)) {
			$sid = intval($sid);
			$db->sql_query("delete from ".$prefix."_stories where catid='$catid'");
			$db->sql_query("delete from ".$prefix."_comments where sid='$sid'");
		}
		Header("Location: ".$admin_file.".php");
	}

	function NoMoveCategory($catid, $newcat) {
		global $prefix, $db, $admin_file;
		$catid = intval($catid);
		$newcat = check_words(check_html(addslashes($newcat), "nohtml"));
		$result = $db->sql_query("select title from ".$prefix."_stories_cat where catid='$catid'");
		list($title) = $db->sql_fetchrow($result);
		$title = check_html($title, "nohtml");
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"option\"><b>"._MOVESTORIES."</b></font><br><br>";
		if (!$newcat) {
			echo ""._ALLSTORIES." <b>$title</b> "._WILLBEMOVED."<br><br>";
			$selcat = $db->sql_query("select catid, title from ".$prefix."_stories_cat");
			echo "<form action=\"".$admin_file.".php\" method=\"post\">";
			echo "<b>"._SELECTNEWCAT.":</b> ";
			echo "<select name=\"newcat\">";
			echo "<option name=\"newcat\" value=\"0\">"._ARTICLES."</option>";
			while(list($newcat, $title) = $db->sql_fetchrow($selcat)) {
				$title = check_html($title, "nohtml");
				echo "<option name=\"newcat\" value=\"$newcat\">$title</option>";
			}
			echo "</select>";
			echo "<input type=\"hidden\" name=\"catid\" value=\"$catid\">";
			echo "<input type=\"hidden\" name=\"op\" value=\"NoMoveCategory\">";
			echo "<input type=\"submit\" value=\""._OK."\">";
			echo "</form>";
		} else {
			$resultm = $db->sql_query("select sid from ".$prefix."_stories where catid='$catid'");
			while(list($sid) = $db->sql_fetchrow($resultm)) {
				$sid = intval($sid);
				$db->sql_query("update ".$prefix."_stories set catid='$newcat' where sid='$sid'");
			}
			$db->sql_query("delete from ".$prefix."_stories_cat where catid='$catid'");
			echo ""._MOVEDONE."";
		}
		CloseTable();
		include("footer.php");
	}

	function SaveEditCategory($catid, $title) {
		global $prefix, $db, $admin_file;
		$title = str_replace("\"","",$title);
		$result = $db->sql_query("select catid from ".$prefix."_stories_cat where title='$title'");
		$catid = intval($catid);
		$check = $db->sql_numrows($result);
		if ($check) {
			$what1 = _CATEXISTS;
			$what2 = _GOBACK;
		} else {
			$what1 = _CATSAVED;
			$what2 = "[ <a href=\"".$admin_file.".php\">"._GOTOADMIN."</a> ]";
			$result = $db->sql_query("update ".$prefix."_stories_cat set title='$title' where catid='$catid'");
			if (!$result) {
				return;
			}
		}
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"content\"><b>$what1</b></font><br><br>";
		echo "$what2</center>";
		CloseTable();
		include("footer.php");
	}

	function SaveCategory($title) {
		global $prefix, $db;
		$title = str_replace("\"","",$title);
		$result = $db->sql_query("select catid from ".$prefix."_stories_cat where title='$title'");
		$check = $db->sql_numrows($result);
		if ($check) {
			$what1 = _CATEXISTS;
			$what2 = _GOBACK;
		} else {
			$what1 = _CATADDED;
			$what2 = _GOTOADMIN;
			$result = $db->sql_query("insert into ".$prefix."_stories_cat values (NULL, '$title', '0')");
			if (!$result) {
				return;
			}
		}
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._CATEGORIESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"content\"><b>$what1</b></font><br><br>";
		echo "$what2</center>";
		CloseTable();
		include("footer.php");
	}
	
	switch($op) {
		case "EditCategory":
			EditCategory($catid);
			break;
			
		case "DelCategory":
			DelCategory($cat);
			break;

		case "YesDelCategory":
			YesDelCategory($catid);
			break;

		case "NoMoveCategory":
			NoMoveCategory($catid, $newcat);
			break;

		case "SaveEditCategory":
			SaveEditCategory($catid, $title);
			break;

		case "SelectCategory":
			SelectCategory($cat);
			break;

		case "AddCategory":
			AddCategory();
			break;

		case "SaveCategory":
			SaveCategory($cat_title);
			break;
	}
?>