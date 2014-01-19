<?php
/**
*
* @package Tigris 1.1.4														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $ JAMES						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {

	/*********************************************************/
	/* Modules Functions                                     */
	/*********************************************************/

	function modules() {
		global $prefix, $db, $multilingual, $bgcolor2, $admin_file;
		include ("header.php");
		GraphicAdmin();
		echo '<script type="text/javascript">
		function module_update(mod_id){
			$("#waiting"+mod_id).html(\'<img src="images/loading.gif" />\');
			var mod_status = $("#mod"+mod_id+" > img.status").attr("alt");
			if(mod_status == "active") mod_status = 0;
			if(mod_status == "inactive") mod_status = 1;
			$.post("'.ADMIN_PHP.'", {op: "ajax_update", mid: mod_id, status: mod_status },
				function(data){
				$("#waiting"+mod_id).delay(2000).html(\'<img src="images/loading.gif" />\');
				if(jQuery.trim(data)== "enabled"){
				$("#mod"+mod_id+" > img.status").attr("src","images/active.gif");
				$("#mod"+mod_id+" > img.status").attr("alt","active");
				$("#mod"+mod_id+" > img.status").attr("title","',_ACTIVATE,'");
				$("#link"+mod_id+" > img").attr("src","images/inactive.gif");
				$("#waiting"+mod_id).html("");
				}else if(jQuery.trim(data)=="disabled"){
				$("#mod"+mod_id+" > img.status").attr("src","images/inactive.gif");
				$("#mod"+mod_id+" > img.status").attr("alt","inactive");
				$("#mod"+mod_id+" > img.status").attr("title","',_ACTIVATE,'");
				$("#link"+mod_id+" > img").attr("src","images/active.gif");
				$("#waiting"+mod_id).html("");
				}else{
					$("#waiting"+mod_id).delay(2000).html(\'<img src="images/error.png" />\'+data);
				}
					});
				}
			function make_home(mod_id){
				$("#waiting"+mod_id).html(\'<img src="images/loading.gif" />\');
				if(confirm("'._DEFHOMEMODULE.'?"))
				{
				$.post("'.ADMIN_PHP.'", {op: "ajax_home", mid: mod_id},
				function(data){
				if(data = "success"){
				$(".home").empty();
				$(".unhome").attr(\'src\',\'images/key.gif\');
				$("#shome"+mod_id).html(\'<img src="images/key.gif" />\');
				$(".mRow").css("background","");
				$("#mhome"+mod_id).attr(\'src\',\'images/key_x.gif\');
				}else{
				$("#waiting"+mod_id).delay(2000).html(\'<img src="images/error.png" />\');
				}
				});
		}
		$("#waiting"+mod_id).html(\'\');
		return false;
			}
		</script>';

		$handle=opendir('modules');
		$modlist = "";
		while ($file = readdir($handle)) {
			if ( (!preg_match("/[.]/i",$file)) && !empty($file) ) {
				$modlist .= "$file ";
			}
		}
		closedir($handle);
		$modlist = explode(" ", $modlist);
		sort($modlist);
		for ($i=0; $i < sizeof($modlist); $i++) {
			if(!empty($modlist[$i])) {
				$row = $db->sql_fetchrow($db->sql_query("SELECT mid from " . $prefix . "_modules where title='$modlist[$i]'"));
				$mid = intval($row['mid']);
				if (empty($mid)) {
					$db->sql_query("insert into " . $prefix . "_modules values (NULL, '$modlist[$i]', '$modlist[$i]', '0', '0', '1', '0', '')");
				}
			}
		}
		$result2 = $db->sql_query("SELECT title from " . $prefix . "_modules");
		while ($row2 = $db->sql_fetchrow($result2)) {
			$title = check_html($row2['title'], "nohtml");
			$a = 0;
			$handle=opendir('modules');
			while ($file = readdir($handle)) {
			if ( (!preg_match("/[.]/i",$file)) && !empty($file) ) {
				if ($file == $title) {
					$a = 1;
				}
			}
			}
			closedir($handle);
			if ($a == 0) {
				$db->sql_query("delete from " . $prefix . "_modules where title='$title'");
			}
		}
		echo "<br>";
		OpenTable();
		
        echo "<h3>" . _MODULESADMIN . "</h3>"		
		
		."<form action=\"".$admin_file.".php\" method=\"post\">";
	
		echo '<table id="gradient-style" summary="Modules List">
   		<thead>
		';
		echo "	<tr>\n";
		echo "		<th scope='col'>"._TITLE."</th>\n";
		echo "		<th scope='col' >"._CUSTOMTITLE."</th>\n";
		echo "		<th scope='col' >"._STATUS."</th>\n";
		echo "		<th scope='col'>"._VIEW."</th>\n";
		echo "		<th scope='col' >"._GROUP."</th>\n";
		echo "		<th scope='col'>"._FUNCTIONS."</th>\n";
		echo "	</tr></thead><tbody>\n";
				

		$main_m = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
		$main_module = $main_m['main_module'];
		$result3 = $db->sql_query("SELECT DISTINCT `mid`, `title`, `custom_title`, `active`, `view`, `inmenu`, `mod_group` from " . $prefix . "_modules WHERE `title` != ' ' order by title ASC");
		while ($row3 = $db->sql_fetchrow($result3)) {
			$mid = intval($row3['mid']);
			$title = check_html($row3['title'], "nohtml");
			$custom_title = langit(strip_tags($row3['custom_title']));
			$active = intval($row3['active']);
			$view = intval($row3['view']);
			$inmenu = intval($row3['inmenu']);
			$mod_group = intval($row3['mod_group']);
			if (empty($custom_title)) {
				$custom_title = str_replace("_"," ",$title);
				$db->sql_query("update " . $prefix . "_modules set custom_title='$custom_title' where mid='$mid'");
			}
			if ($active == 1) {
				$active = "<img class=\"status\" src=\"images/active.gif\" alt=\"active\" title=\""._ACTIVE."\" >";
				$change = "<img src=\"images/inactive.gif\" alt=\""._DEACTIVATE."\" title=\""._DEACTIVATE."\" >";
				$act = 0;
			} else {
				$active = "<img class=\"status\" src=\"images/inactive.gif\" alt=\"inactive\" title=\""._INACTIVE."\" >";
				$change = "<img src=\"images/active.gif\" alt=\""._ACTIVATE."\" title=\""._ACTIVATE."\" >";
				$act = 1;
			}
			if (empty($custom_title)) {
				$custom_title = str_replace("_", " ", $title);
			}
			if ($view == 0) {
				$who_view = _MVALL;
			} elseif ($view == 1) {
				$who_view = _MVUSERS;
			} elseif ($view == 2) {
				$who_view = _MVADMIN;
			} elseif ($view == 3) {
				$who_view = _SUBUSERS;
			}
			if ($title != $main_module AND $inmenu == 0) {
				$title = "[ <big><strong>&middot;</strong></big> ] $title";
			}
			if ($title == $main_module) {
				$title = "<b>$title</b>";
				$custom_title = "<b>$custom_title</b>";
				$active = "$active <div style=\"display:inline;\" class=\"home\" ><img src=\"images/key.gif\" alt=\""._INHOME."\" title=\""._INHOME."\" ></div>";
				$who_view = "<b>$who_view</b>";
				$puthome = "<div style=\"display:inline;\" ><img src=\"images/key_x.gif\"  id=\"mhome$mid\" alt=\""._INHOME."\" title=\""._INHOME."\"  class=\"unhome\" ></div>";
				$change_status = "$change";
				$background = "style='background:#FAE878'";
			} else {
				$puthome = "<a href=\"".$admin_file.".php?op=home_module&mid=$mid\" onclick=\"javascript:make_home('$mid'); return false;\"><img id=\"mhome$mid\"   src=\"images/key.gif\" alt=\""._PUTINHOME."\" title=\""._PUTINHOME."\"  class=\"unhome\" ></a>";
				$change_status = "<a id=\"link".$mid."\" href=\"".$admin_file.".php?op=module_status&mid=$mid&active=$act\" onclick=\"javascript:module_update(".$mid."); return false;\">$change</a>";
				$background = "";
			}
			if ($mod_group != 0) {
				$grp = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_groups WHERE id='$mod_group'"));
				$mod_group = $grp['name'];
			} else {
				$mod_group = _NONE;
			}
			echo "<tr><td $background align=\"center\" class='mRow'  id='mRow$mid' >&nbsp;$title</td><td align=\"center\" $background class='mRow'  id='mRow2$mid' >$custom_title</td><td id=\"mod".$mid."\" align=\"center\" $background class='mRow'  id='mRow3$mid' >$active <span  id=\"shome$mid\" class='home'></span></td><td align=\"center\" $background class='mRow'  id='mRow4$mid' >$who_view</td><td align=\"center\" $background class='mRow'  id='mRow5$mid' >$mod_group</td><td align=\"center\" $background class='mRow'  id='mRow6$mid' >&nbsp; <a href=\"".$admin_file.".php?op=module_edit&mid=$mid\"><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\"></a>  $change_status  <span id=\"puthome$mid\" >$puthome</span> &nbsp;<div class=\"waiting\" id=\"waiting".$mid."\"></div></td></tr>\n";
		}
		echo "</tbody></table>\n
		</form></center>";
		echo "<br>" . _MODULESADDONS . "<br><br>" . _MODULESACTIVATION . "<br>";
		
		CloseTable();
		include ("footer.php");
	}

	function home_module($mid, $ok=0) {
		global $prefix, $db, $admin_file;
		$mid = intval($mid);
		if ($ok == 0) {
			include ("header.php");
			GraphicAdmin();
			title("" . _HOMECONFIG . "");
			OpenTable();
			$row = $db->sql_fetchrow($db->sql_query("SELECT title from " . $prefix . "_modules where mid='$mid'"));
			$new_m = check_html($row['title'], "nohtml");
			$row2 = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
			$old_m = check_html($row2['main_module'], "nohtml");
			echo "<center><b>" . _DEFHOMEMODULE . "</b><br><br>"
			."" . _SURETOCHANGEMOD . " <b>$old_m</b> " . _TO . " <b>$new_m</b>?<br><br>"
			."[ <a href=\"".$admin_file.".php?op=modules\">" . _NO . "</a> | <a href=\"".$admin_file.".php?op=home_module&mid=$mid&ok=1\">" . _YES . "</a> ]</center>";
			CloseTable();
			include("footer.php");
		} else {
			$row3 = $db->sql_fetchrow($db->sql_query("SELECT title from " . $prefix . "_modules where mid='$mid'"));
			$title = addslashes(check_words(check_html($row3['title'], "nohtml")));
			$active = 1;
			$view = 0;
			$res = $db->sql_query("update " . $prefix . "_main set main_module='$title'");
			$res2 = $db->sql_query("update " . $prefix . "_modules set active='$active', view='$view' where mid='$mid'");
			Header("Location: ".$admin_file.".php?op=modules");
		}
	}
	function module_status($mid, $active) {
		global $prefix, $db, $admin_file;
		$mid = intval($mid);
		$db->sql_query("update " . $prefix . "_modules set active='$active' where mid='$mid'");
		Header("Location: ".$admin_file.".php?op=modules");
	}
	function module_edit($mid) {
		global $prefix, $db, $admin_file;
		$main_m = $db->sql_fetchrow($db->sql_query("SELECT main_module from " . $prefix . "_main"));
		$main_module = $main_m['main_module'];
		$mid = intval($mid);
		$row = $db->sql_fetchrow($db->sql_query("SELECT title, custom_title, view, inmenu, mod_group from " . $prefix . "_modules where mid='$mid'"));
		$title = check_html($row['title'], "nohtml");
		$custom_title = check_html($row['custom_title'], "nohtml");
		$view = intval($row['view']);
		$inmenu = intval($row['inmenu']);
		$mod_group = intval($row['mod_group']);
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if ($view == 0) {
			$sel1 = "selected";
		} elseif ($view == 1) {
			$sel2 = "selected";
		} elseif ($view == 2) {
			$sel3 = "selected";
		} elseif ($view == 3) {
			$sel4 = "selected";
		}
		if ($title == $main_module) {
			$a = " - " . _INHOME . "";
		} else {
			$a = "";
		}
		if ($inmenu == 1) {
			$insel1 = "checked";
			$insel2 = "";
		} elseif ($inmenu == 0) {
			$insel1 = "";
			$insel2 = "checked";
		}
		echo "<h3>" . _MODULEEDIT . "</h3>
		<center><b>" . _CHANGEMODNAME . "</b><br>($title$a)</center><br><br>"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<table border=\"0\"><tr><td>"
		."" . _CUSTOMMODNAME . "</td><td>"
		."<input type=\"text\" name=\"custom_title\" value=\"$custom_title\" size=\"50\">"._LANGIT."</td></tr>";
		if ($title == $main_module) {
			echo "<input type=\"hidden\" name=\"view\" value=\"0\">"
			."<input type=\"hidden\" name=\"inmenu\" value=\"$inmenu\">"
			."</table><br><br>";
		} else {
			echo "<tr><td>" . _VIEWPRIV . "</td><td><select name=\"view\">"
			."<option value=\"0\" $sel1>" . _MVALL . "</option>"
			."<option value=\"1\" $sel2>" . _MVUSERS . "</option>"
			."<option value=\"2\" $sel3>" . _MVADMIN . "</option>"
			."<option value=\"3\" $sel4>" . _SUBUSERS . "</option>"
			."</select></td></tr>";
			$numrow = $db->sql_numrows($db->sql_query("SELECT * FROM " . $prefix . "_groups"));
			if ($numrow > 0) {
				echo "<tr><td>" . _UGROUP . "</td><td><select name=\"mod_group\">";
				$result2 = $db->sql_query("SELECT id, name FROM " . $prefix . "_groups");
				while ($row2 = $db->sql_fetchrow($result2)) {
					if ($row2['id'] == $mod_group) { $gsel = "selected"; } else { $gsel = ""; }
					if ($dummy != 1) {
						if ($mod_group == 0) { $ggsel = "selected"; } else { $ggsel = ""; }
						echo "<option value=\"0\" $ggsel>" . _NONE . "</option>";
						$dummy = 1;
					}
					$row2['name'] = check_html($row2['name'], "nohtml");
					echo "<option value=\"".intval($row2['id'])."\" $gsel>".$row2['name']."</option>";
					$gsel = "";
				}
				echo "</select>&nbsp;<i>(" . _VALIDIFREG . ")</i></td></tr>";
			} else {
				echo "<input type=\"hidden\" name=\"mod_group\" value=\"0\">";
			}
			echo "<tr><td>"._SHOWINMENU."</td><td>"
			."<input type=\"radio\" name=\"inmenu\" value=\"1\" $insel1> " . _YES . " &nbsp;&nbsp; <input type=\"radio\" name=\"inmenu\" value=\"0\" $insel2> " . _NO . ""
			."</td></tr></table><br><br>";
		}
		if ($title != $main_module) {

		}
		echo "<input type=\"hidden\" name=\"mid\" value=\"$mid\">"
		."<input type=\"hidden\" name=\"op\" value=\"module_edit_save\">"
		."<input type=\"submit\" value=\"" . _SAVECHANGES . "\">"
		."</form>"
		."<br><br><center>" . _GOBACK . "</center>";
		CloseTable();
		include("footer.php");
	}
	function module_edit_save($mid, $custom_title, $view, $inmenu, $mod_group) {
		global $prefix, $db, $admin_file;
		$mid = intval($mid);
		$custom_title = addslashes(check_words(check_html($custom_title, "nohtml")));
		if ($view != 1) { $mod_group = 0; }
		$result = $db->sql_query("update " . $prefix . "_modules set custom_title='$custom_title', view='".intval($view)."', inmenu='".intval($inmenu)."', mod_group='".intval($mod_group)."' where mid='$mid'");
		Header("Location: ".$admin_file.".php?op=modules");
	}
	function Ajax_Update(){
		global $db,$prefix;
		$mid = intval($_POST['mid']);
		$status = intval($_POST['status']);
		$result = $db->sql_query('update '.$prefix.'_modules set active='.$status.' where mid='.$mid.' LIMIT 1');
		switch($result){
			case true:
				if($status === 1) echo 'enabled';
				else if($status === 0) echo 'disabled';
				break;
			}
	}
	function Ajax_Home(){
		global $db,$prefix;
		$mid = intval($_POST['mid']);
			$row3 = $db->sql_fetchrow($db->sql_query("SELECT title from " . $prefix . "_modules where mid='$mid'"));
			$title = addslashes(check_words(check_html($row3['title'], "nohtml")));
			$active = 1;
			$view = 0;
			$res = $db->sql_query("update ".$prefix."_main set main_module='$title'");
			$res2 = $db->sql_query("update ".$prefix."_modules set active='$active', view='$view' where mid='$mid'");
			if($res && $res2)
				echo 'success';
			else
			 echo 'failure';
		
	}

	switch ($op){

		case "modules":
		modules();
		break;

		case "module_status":
		module_status($mid, $active);
		break;

		case "module_edit":
		module_edit($mid);
		break;

		case "module_edit_save":
		module_edit_save($mid, $custom_title, $view, $inmenu, $mod_group);
		break;

		case "home_module":
		home_module($mid, $ok);
		break;
		case "ajax_update":
		Ajax_Update();
		break;
		case "ajax_home":
		Ajax_Home();
		break;

	}

} else {
	echo "Access Denied";
}

?>
