<?php

/************************************************************************
   Nuke-Evolution: Site Map
   ============================================
   Copyright � 2005 by The Nuke-Evolution Team - Nuke-Evolution.com
  
   Filename      : functions.php
   Author        : LombudXa (Rodmar) (www.evolved-Systems.net)
   Version       : 2.0.0
   Date          : 12/18/2005 (mm-dd-yyyy)

   Description   : Site Map generates a list of useful links from your
                   modules and displays them on one page. Goal is to
                   provide search engines like Google with a static page
                   of links to dynamic pages. You should link to this
                   page from your sites home page somewhere.
************************************************************************/
/* Based on NSN GR Downloads                                           */
/* By: NukeScripts Network (webmaster@nukescripts.net)                 */
/* http://www.nukescripts.net                                          */
/* Copyright � 2000-2005 by NukeScripts Network                        */
/***********************************************************************/

/*****[CHANGES]**********************************************************
-=[Base]=-
      Nuke Patched                             v3.1.0       06/26/2005
 ************************************************************************/

if(!defined('IN_SITEMAP')) {
  exit('Access Denied');
}

function sitemap_gentime() {
    global $total_time, $start_time;
    $mtime = microtime();
    $mtime = explode(" ",$mtime);
    $mtime = $mtime[1] + $mtime[0];
    $end_time = $mtime;
    $total_time = ($end_time - $start_time);
    $total_time = ""._PAGEGENERATION." ".substr($total_time,0,4)." "._SECONDS."";
    echo "<center><br />".$total_time."</center>\n";
}

// PLEASE LEAVE THIS COPYRIGHT ALONE!
function sitemap_copy() {
    global $module_name;
    echo "<script type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function openwindow(){\n";
    echo "	window.open (\"modules/$module_name/copyright.php\",\"Module_Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=400,height=200\");\n";
    echo "}\n";
    echo "//-->\n";
    echo "</script>\n\n";
}

// Copyright (c) 2003 --- NukeScripts Network ---
// Can not be reproduced in whole or in part without
// written consent from NukeScripts Network CEO
function sitemap_get_configs() {
    global $prefix, $db;
    static $config;
    if(isset($config)) return $config;
        $configresult = $db->sql_query("SELECT config_name, config_value FROM ".$prefix."_sitemap_config");
        while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {
            $config[$config_name] = $config_value;
        }
    return $config;
}

// Copyright (c) 2003 --- NukeScripts Network ---
// Can not be reproduced in whole or in part without
// written consent from NukeScripts Network CEO
function sitemap_save_config($config_name, $config_value) {
    global $prefix, $db;
    $db->sql_query("UPDATE ".$prefix."_sitemap_config SET config_value='$config_value' WHERE config_name='$config_name'");

}

function SMadminmain() {
    global $admin_file, $module_name, $sm_config;
    OpenTable();
    echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
    echo "<tr>\n";
    echo "<td align='center' width='25%'><a class='button' href='".$admin_file.".php?op=SMConfig'><img src=\"images/icon/cog_edit.png\"><b>"._SMGENCONFIG."</b></td>\n";
    echo "<td align='center' width='25%'><a class='button' href='".$admin_file.".php?op=SMMods'><img src=\"images/icon/plugin_add.png\"><b>"._SMMODS."</b></td>\n";
    echo "<td align='center' width='25%'><a class='button' href='".$admin_file.".php?op=SMLimits'><img src=\"images/icon/sitemap.png\"><b>"._SMLIMITS."</b></td>\n";
    echo "<td align='center' width='25%'><a class='button' href='".$admin_file.".php?op=SMGoogle'><img src=\"images/icon/page_white_go.png\"><b>"._SMGOOGLESETUP."</b></td>\n";
    echo "</table>\n";
    echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%'>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<tr>\n";
    if ($sm_config['use_gt'] == 1) {
    	require_once("mainfile.php");
        if (function_exists('nextGenTap')) {
            if ($nextGenOb = 1) {
                echo "<td align='center' width='100%'> [ <img src=\"images/sitemap.png\">&nbsp;<a href='site_map.html' target='_blank'>"._SM."</a> | <a href='".$admin_file.".php'>"._SMMAINADMIN."</a> ] </td>\n";
            }
        }
    } else {
        echo "<td align='center' width='100%'> [ <img src=\"images/sitemap.png\">&nbsp; <a href='modules.php?name=$module_name' target='_blank'>"._SM."</a> | <a href='".$admin_file.".php'>"._SMMAINADMIN."</a> ] </td>\n";
    }
    echo "</tr>\n";
    echo "</tr>\n";
    echo "</table>\n";
    CloseTable();
}

?>