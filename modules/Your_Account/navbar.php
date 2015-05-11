<?php
/**
 *
 * @package userinfo														
 * @version $Id: 02009-12-12 15:35:19Z Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com	
 *  Iran Nuke Portal                        (info@irannuke.net) 										
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike	
 *
 */

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    die ("You can't access this file directly...");
}
require_once("modules/Your_Account/includes/constants.php");
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
if (is_user($user)) {
require_once("mainfile.php");
get_lang("Your_Account");
include_once("modules/Your_Account/includes/functions.php");
global $prefix, $db, $user_prefix, $ya_config, $thmcount;

// menelaos: removed because it is already called in /modules/Your_Account/includes/mainfileend.php
$ya_config = ya_get_configs();

    function menuimg($gfile) {
        $ThemeSel = get_theme();
        if (file_exists("themes/$ThemeSel/images/menu/$gfile")) {
            $menuimg = "themes/$ThemeSel/images/menu/$gfile";
        } else {
            $menuimg = "modules/Your_Account/images/menu/$gfile";
        }
        return($menuimg);
    }

    // Set TD widths
    $tds = 3;
    $handle=opendir('themes');
    while ($file = readdir($handle)) { if ( (!preg_match("/[.]/",$file)) ) { $thmcount++; } }
    closedir($handle);
    if (is_active("Private_Messages")) { $tds++; }
    if (($thmcount > 1) AND ($ya_config['allowusertheme'] == 0)) { $tds++; }
    if ($articlecomm == 1) { $tds++; }
    if ($ya_config['allowuserdelete'] == 1) { $tds++; }
    $tdwidth = (int) ( (100/$tds) );
    // END Set TD widths

    function nav($main_up=0) {
        global $module_name, $admin, $ya_config, $thmcount, $tdwidth, $articlecomm;
        echo "<center><table border=\"0\" width=\"100%\" align=\"center\" style='text-align:center;'><tr>\n";

        $menuimg = menuimg("info.gif");
        echo "<td width=\"$tdwidth%\" >\n";
        echo "<a href=\"modules.php?name=Your_Account&op=edituser\"><img src=\"$menuimg\" border=\"0\" alt=\""._CHANGEYOURINFO."\" title=\""._CHANGEYOURINFO."\"></a><br>\n";
        echo "<a href=\"modules.php?name=Your_Account&op=edituser\">"._ACCTCHANGE."</a>\n";
        echo "</td>\n";

        $menuimg = menuimg("home.gif");
        echo "<td width=\"$tdwidth%\" >\n";
        echo "<a href=\"modules.php?name=Your_Account&op=edithome\"><img src=\"$menuimg\" border=\"0\" alt=\""._CHANGEHOME."\" title=\""._CHANGEHOME."\"></a><br>\n";
        echo "<a href=\"modules.php?name=Your_Account&op=edithome\">"._ACCTHOME."</a>\n";
        echo "</td>\n";

        if ($articlecomm == 1) {
            $menuimg = menuimg("comments.gif");
            echo "<td width=\"$tdwidth%\" >\n";
            echo "<a href=\"modules.php?name=Your_Account&op=editcomm\"><img src=\"$menuimg\" border=\"0\" alt=\""._CONFIGCOMMENTS."\" title=\""._CONFIGCOMMENTS."\"></a><br>\n";
            echo "<a href=\"modules.php?name=Your_Account&op=editcomm\">"._ACCTCOMMENTS."</a>\n";
            echo "</td>\n";
        }

        if (is_active("phpBB3")) {
        if (is_active("Private_Messages")) {
            $menuimg = menuimg("messages.gif");
            echo "<td width=\"$tdwidth%\" >\n";
            echo "<a href=\"modules.php?name=Private_Messages\"><img src=\"$menuimg\" border=\"0\" alt=\""._PRIVATEMESSAGES."\" title=\""._PRIVATEMESSAGES."\"></a><br>\n";
            echo "<a href=\"modules.php?name=Private_Messages\">"._MESSAGES."</a>\n";
            echo "</td>\n";
        }
        }

        if (($thmcount > 1) AND ($ya_config['allowusertheme'] == 0)) {
            $menuimg = menuimg("themes.gif");
            echo "<td width=\"$tdwidth%\" >\n";
            echo "<a href=\"modules.php?name=Your_Account&op=chgtheme\"><img src=\"$menuimg\" border=\"0\" alt=\""._SELECTTHETHEME."\" title=\""._SELECTTHETHEME."\"></a><br>\n";
            echo "<a href=\"modules.php?name=Your_Account&op=chgtheme\">"._ACCTTHEME."</a>\n";
            echo "</td>\n";
        }

        if ($ya_config['allowuserdelete'] == 1) {
            $menuimg = menuimg("delete.gif");
            echo "<td width=\"$tdwidth%\" >\n";
            echo "<a href=\"modules.php?name=Your_Account&op=delete\"><img src=\"$menuimg\" border=\"0\" alt=\""._DELETEACCT."\" height=\"48\" width=\"48\"></a><br>\n";
            echo "<a href=\"modules.php?name=Your_Account&op=delete\">"._DELETEACCT."</a>\n";
            echo "</td>\n";
        }

        $menuimg = menuimg("exit.gif");
        echo "<td width=\"$tdwidth%\" >\n";
        echo "<a href=\"modules.php?name=Your_Account&op=logout\"><img src=\"$menuimg\" border=\"0\" alt=\""._LOGOUTEXIT."\" title=\""._LOGOUTEXIT."\"></a><br>\n";
        echo "<a href=\"modules.php?name=Your_Account&op=logout\">"._ACCTEXIT."</a>\n";
        echo "</td>\n";

        echo "</tr></table></center>";
        if ($main_up != 1) { echo "<br><center>[ <a href=\"modules.php?name=Your_Account\">"._RETURNACCOUNT."</a> ]</center>\n"; }
    }

}

?>