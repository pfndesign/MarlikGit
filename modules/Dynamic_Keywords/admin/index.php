<?php
/**
 *
 * @package Dynamic Keyword														
 * @version $Id:9:50 AM 7/29/2010 Aneeshtan$						
 * @copyright (c) Nukelearn Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

$ver = "1.1.0";
global $currentlang;

if(file_exists("modules/Dynamic_Keywords/admin/language/lang-".$currentlang.".php")) {
	include("modules/Dynamic_Keywords/admin/language/lang-".$currentlang.".php");
} else {
	include("modules/Dynamic_Keywords/admin/language/lang-english.php");
}

global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of($module_name,$admin)) {
	

	function MetaConfig() {
		global $prefix, $db, $admin_file, $ver, $bgcolor4;
		include ("header.php");
		GraphicAdmin();
		OpenTable();

		// Seeking for new modules
		$handle=opendir('modules');
		$modlist = array();
		while ($file = readdir($handle)) {
			if ((!preg_match("/[.]/",$file))) {$modlist[] = $file;}
		}
		closedir($handle);
		sort($modlist);
		for ($i=0; $i < sizeof($modlist); $i++) {
			if(!empty($modlist[$i])) {
				$result = $db->sql_query("SELECT mid FROM ".$prefix."_keywords WHERE title='".$modlist[$i]."'");
				if ($result) {
					$row = $db->sql_fetchrow($result);
					$mid = intval($row['mid']);
					if ($mid == 0) {
						$db->sql_query("INSERT INTO ".$prefix."_keywords (mid , title , keywords, description) VALUES (NULL, '".$modlist[$i]."', '', '')");
					}
				}
			}
		}

		// Remove deleted modules
		$result = $db->sql_query("SELECT title from ".$prefix."_keywords");
		while ($row = $db->sql_fetchrow($result)) {
			$title = $row['title'];
			$a = 0;
			$handle=opendir('modules');
			while ($file = readdir($handle)) {
				if ($file == $title) {$a = 1;}
			}
			closedir($handle);
			if ($a == 0) {$db->sql_query("DELETE FROM ".$prefix."_keywords WHERE title='$title'");}
		}
		//
		echo "<div style=\"text-align: center;\">\n";
		echo "<b>"._DK_MAIN_KEYWORDS."</b><br />\n";
		echo ""._DK_MAIN_KEYWORDS_DESC."</div><br /><br />\n";
		echo '
		<table id="gradient-style" summary="'._DK_MAIN_KEYWORDS.'">
   		<thead>
		';
		echo "	<tr bgcolor=\"$bgcolor4\">\n";
		echo "		<th scope='col' width=\"10%\">"._DK_ID."</th>\n";
		echo "		<th scope='col' width=\"15%\">"._DK_TITLE."</th>\n";
		echo "		<th scope='col' width=\"30%\">"._DK_DESCRIPTION."</th>\n";
		echo "		<th scope='col' width=\"30%\">"._DK_KEYWORDS."</th>\n";
		echo "		<th scope='col' width=\"15%\">"._DK_OPTIONS."</th>\n";
		echo "	</tr></thead>
		<tfoot>
    	<tr>
        <td colspan='6'>Give General Description and keywords for every modules in your USV Portal</td>
        </tr>
		</tfoot>
   		<tbody>\n";
		echo "	<tr bgcolor=\"$bgcolor4\">\n";
		echo "		<td align=\"center\">"._DK_ALL."</td>\n";
		echo "		<td align=\"center\">"._DK_ALL."</td>\n";
		$result = $db->sql_query("SELECT keywords, description FROM ".$prefix."_keywords_main");
		$row = $db->sql_fetchrow($result);
		$mainkeywords = substr($row['keywords'], 0, 90);
		$description = substr($row['description'], 0, 90);
		echo "		<td>$description...</td>\n";
		echo "		<td>$mainkeywords...</td>\n";
		echo "		<td align=\"center\">[ <a href=\"".$admin_file.".php?op=MainMetaEdit\">"._DK_EDIT."</a> ]</td>\n";
		echo "	</tr>\n";
		echo "</tbody></table>\n";
		echo "<br /><hr noshade=\"noshade\" /><br />\n";
		echo "<div style=\"text-align: center;\">\n";
		echo "<b>"._DK_MODULE_KEYWORDS."</b><br />\n";
		echo ""._DK_MODULE_KEYWORDS_DESC."</div><br /><br />\n";
		echo '
		<table id="gradient-style" summary="Meeting Results">
   		<thead>
		';
		echo "	<tr bgcolor=\"$bgcolor4\">\n";
		echo "		<th scope='col' width=\"10%\">"._DK_ID."</th>\n";
		echo "		<th scope='col' width=\"15%\">"._DK_TITLE."</th>\n";
		echo "		<th scope='col' width=\"30%\">"._DK_DESCRIPTION."</th>\n";
		echo "		<th scope='col' width=\"30%\">"._DK_KEYWORDS."</th>\n";
		echo "		<th scope='col' width=\"15%\">"._DK_OPTIONS."</th>\n";
		echo "	</tr></thead><tbody>\n";
		$result = $db->sql_query("SELECT mid, title, keywords, description FROM ".$prefix."_keywords");
		while(list($mid, $title, $keywords, $description)=$db->sql_fetchrow($result)) {
			$title=str_replace("_", " ", $title);
			if (!empty($keywords)) {$keywords=substr($keywords, 0, 90)."...";} else {$keywords="<center>"._DK_DEFAULTS."</center>";}
			if (!empty($description)) {$description=substr($description, 0, 90)."...";} else {$description="<center>"._DK_DEFAULTS."</center>";}
			echo "	<tr bgcolor=\"$bgcolor4\">\n";
			echo "		<td align=\"center\">$mid</td>\n";
			echo "		<td align=\"center\">$title</td>\n";
			echo "		<td>$description</td>\n";
			echo "		<td>$keywords</td>\n";
			echo "		<td align=\"center\">[ <a href=\"",$admin_file.".php?op=ModuleMetaEdit&mid=$mid\">"._DK_EDIT."</a> ]</td>\n";
			echo "	</tr>";
		}
		echo "</tbody></table>\n";

		//}
		CloseTable();

		include ("footer.php");
	}

	function ModuleMetaEdit() {
		global $mid, $prefix, $db, $admin_file;
		$mid = sql_quote($mid);
		$result = $db->sql_query("SELECT title, keywords, description FROM ".$prefix."_keywords WHERE mid='$mid'");
		$row = $db->sql_fetchrow($result);
		$title = $row['title'];
		$keywords = $row['keywords'];
		$description = $row['description'];
		include('header.php');
		echo "<script type=\"text/javascript\" language=\"JavaScript\" src=\"modules/Dynamic_Keywords/tooltip.js\"></script>\n";
		OpenTable();
		echo "<table width=\"75%\" align=\"center\">\n";
		echo "	<tr>\n";
		echo "		<td align=\"center\">"._DK_MODULE_KEYWORDS2."<br /><b>".str_replace('_', ' ', $title)."</b><br /><br />\n";
		echo "			<form action=\"".$admin_file.".php\">\n";
		echo "				<b>"._DK_KEYWORDS."</b> <a href=\"#\" onMouseOver=\"toolTip('"._DK_WARNING_KW1."<br /><br />"._DK_WARNING_KW2."', 270, 80)\" onMouseOut=\"toolTip()\"><img src=\"modules/Dynamic_Keywords/images/help.png\" border=\"0\" /></a><br />\n";
		echo "				<textarea name=\"pkeywords\" cols=\"60\" rows=\"6\">$keywords</textarea><br /><br />\n";
		echo "				<b>"._DK_DESCRIPTION."</b> <a href=\"#\" onMouseOver=\"toolTip('"._DK_WARNING_DESC1."<br /><br />"._DK_WARNING_DESC2."', 270, 80)\" onMouseOut=\"toolTip()\"><img src=\"modules/Dynamic_Keywords/images/help.png\" border=\"0\" /></a><br />\n";
		echo "				<textarea name=\"pdescription\" cols=\"60\" rows=\"6\">$description</textarea><br /><br />\n";
		echo "				<input type=\"hidden\" name=\"op\" value=\"ModuleMetaSave\">\n";
		echo "				<input type=\"hidden\" name=\"pmid\" value=\"$mid\">\n";
		echo "				<input type=\"submit\" value=\""._DK_SUBMIT."\">\n";
		echo "			</form><br />"._GOBACK."\n";
		echo "		</td>\n";
		echo "	</tr>\n";
		echo "</table><br />\n";
		CloseTable();
		//DKCopyright();
		include('footer.php');
	}

	function MainMetaEdit() {
		global $mid, $prefix, $db, $pkeywords, $pdescription, $act, $admin_file;
		$result = $db->sql_query("SELECT keywords, description FROM ".$prefix."_keywords_main");
		$row = $db->sql_fetchrow($result);
		$keywords = $row['keywords'];
		$description = $row['description'];
		
		$pkeywords = sql_quote($pkeywords);
		$pdescription = sql_quote($pdescription);
		
		include('header.php');
		echo "<script type=\"text/javascript\" language=\"JavaScript\" src=\"modules/Dynamic_Keywords/tooltip.js\"></script>\n";
		OpenTable();
		if(!isset($act)) {
			echo "<table width=\"75%\" align=\"center\">\n";
			echo "	<tr>\n";
			echo "		<td align=\"center\">\n";
			echo "			<span style=\"font-weight: bold;\">"._DK_MAIN_KEYWORDS."</span><br />\n";
			echo "			"._DK_MAIN_KEYWORDS_DESC."<br /><br />\n";
			echo "			<form action=\"".$admin_file.".php\">\n";
			echo "				<b>"._DK_KEYWORDS."</b> <a href=\"#\" onMouseOver=\"toolTip('"._DK_WARNING_KW1."<br /><br />"._DK_WARNING_KW2."', 270, 80)\" onMouseOut=\"toolTip()\"><img src=\"modules/Dynamic_Keywords/images/help.png\" border=\"0\" /></a><br />\n";
			echo "				<textarea name=\"pkeywords\" cols=\"60\" rows=\"6\">$keywords</textarea><br /><br />\n";
			echo "				<b>"._DK_DESCRIPTION."</b> <a href=\"#\" onMouseOver=\"toolTip('"._DK_WARNING_DESC1."<br /><br />"._DK_WARNING_DESC2."', 270, 80)\" onMouseOut=\"toolTip()\"><img src=\"modules/Dynamic_Keywords/images/help.png\" border=\"0\" /></a><br />\n";
			echo "				<textarea name=\"pdescription\" cols=\"60\" rows=\"6\">$description</textarea><br /><br />\n";
			echo "				<input type=\"hidden\" name=\"op\" value=\"MainMetaEdit\">\n";
			echo "				<input type=\"hidden\" name=\"act\" value=\"Save\">\n";
			echo "				<input type=\"submit\" value=\""._DK_SUBMIT."\">\n";
			echo "			</form><br />"._GOBACK."</td></tr></table><br />\n";
		} elseif ($act=="Save") {
			$db->sql_query("UPDATE ".$prefix."_keywords_main SET keywords='$pkeywords', description='$pdescription'");
			header('Location: '.$admin_file.'.php?op=MetaConfig');
		}
		CloseTable();
		//DKCopyright();
		include('footer.php');
	}

	function ModuleMetaSave() {
		global $prefix, $db, $pmid, $pkeywords, $pdescription, $admin_file;
		
		$pkeywords = sql_quote($pkeywords);
		$pmid = sql_quote(intval($pmid));
		$pdescription = sql_quote($pdescription);
		
		$db->sql_query("UPDATE ".$prefix."_keywords SET keywords='$pkeywords', description='$pdescription' WHERE mid='$pmid'");
		header('Location: '.$admin_file.'.php?op=MetaConfig');
	}

	switch($op) {
		case "MetaConfig":
			MetaConfig();
			break;

		case "ModuleMetaEdit":
			ModuleMetaEdit();
			break;

		case "MainMetaEdit":
			MainMetaEdit();
			break;

		case "ModuleMetaSave":
			ModuleMetaSave();
			break;
	}
} else {
	echo "Access Denied";
}
?>