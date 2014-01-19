<?php
/**************************************************************************/
/* PHP-Nuke INP: Expect to be impressed                                   */
/* ===========================                                            */
/*                               COPYRIGHT                                */
/*                                                                        */
/* Copyright (c) 2003 - 2005 by http://www.irannuke.com                   */
/*                                                                        */
/*     Iran Nuke Premium                         (info@irannuke.com)      */
/*                                                                        */
/* Refer to irannuke.com for detailed information on PHP-Nuke INP         */
/**************************************************************************/
/* Module Add-on for Resources and Site Links           */
/* By: Telli (telli@codezwiz.com)                       */
/* http://www.codezwiz.com/                             */
/* Copyright � 2002-2004 by Codezwiz                    */
/********************************************************/

if (!preg_match("/modules.php/", "$_SERVER[PHP_SELF]")) {     Header("Location: ../../index.php"); die(); }

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);

function getzip($l_id) {
    global $prefix, $db, $nukeurl;
    $l_id = intval($l_id);
    $result = $db->sql_query("select l_id, l_zipurl from ".$prefix."_linktous where l_id='$l_id'");
    list($l_id, $l_zipurl) = $db->sql_fetchrow($result);
    $db->sql_query("update ".$prefix."_linktous set l_hits=l_hits+1 where l_id='$l_id'");
    Header("Location: $nukeurl/$l_zipurl");
}

function getres($r_id) {
    global $prefix, $db, $nukeurl;
    $r_id = intval($r_id);
    $result = $db->sql_query("select r_url from ".$prefix."_linktous_resources where r_id='$r_id'");
    list($r_url) = $db->sql_fetchrow($result);
    $db->sql_query("update ".$prefix."_linktous_resources set r_hits=r_hits+1 where r_id='$r_id'");
    Header("Location: $r_url");
}

switch ($op) {

    default:
    global $module_name, $admin, $user, $prefix, $db, $sitename, $textcolor1, $nukeurl, $bgcolor2;
    $czml = array();
    $sql = "SELECT * FROM ".$prefix."_linktous_config";
    $result = $db->sql_query($sql);
    while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
    $czml[$config_name] = $config_value;
    }
    include("header.php");
    OpenTable();
    echo "<br />";
      if ($czml['blkziportext'] == "1") {
          $explain = ""._ZIPEXPLAIN."";
      } elseif ($czml['blkziportext'] == "0") {
          $explain = ""._TEXTEXPLAIN."";  
      }
    echo "<center><table width='100%' bgcolor='$textcolor1' cellspacing='1' cellpadding='5'>"
	."<tr bgcolor=\"$bgcolor2\"><td align=\"center\">\n"
      .""._SMALLBUTTONS."<br />$explain</td>\n";
    echo "</tr></table><br />";
    Closetable();
    echo "<br />";
    $i = 0;
      if ($czml['modorderbyml'] == "0") {
      $czmodule = $db->sql_query("SELECT * FROM ".$prefix."_linktous WHERE `l_status`='0' AND `l_size_width`<130 ORDER BY `l_id` ASC");
      } elseif ($czml['modorderbyml'] == "1") {
      $czmodule = $db->sql_query("SELECT * FROM ".$prefix."_linktous WHERE `l_status`='0' AND `l_size_width`<130 ORDER BY `l_id` DESC");
      } elseif ($czml['modorderbyml'] == "2") {
      $czmodule = $db->sql_query("SELECT * FROM ".$prefix."_linktous WHERE `l_status`='0' AND `l_size_width`<130 ORDER BY rand()");
      }
    $num = $db->sql_numrows($czmodule);
    if ($num > 0) {
    opentable();
    echo "<br />";
    echo "<table border='1' cellpadding='2' cellspacing='5' width='100%' class='row1'>";
    while (list($l_id, $l_zipurl, $l_image, $l_mouseover, $l_size_width, $l_size_height) = $db->sql_fetchrow($czmodule)) {
          if ($i == 0) { 
            echo "<tr>"; 
          }
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
      if (($czml['blkziportext'] == "1") && ($ext != ".swf")) {
          $zip = "<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>";
          $alt = "Click here to download our link!";
          $text = "";
          $flink = ""; 
      } elseif (($czml['blkziportext'] == "0") && ($ext != ".swf")) {
          $zip = "<a href='$nukeurl'>";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=17 dir=ltr align=left><a href=\"$nukeurl\" target=\"_blank\"><img src=\"$nukeurl/$l_image\" border=\"0\" alt=\"$l_mouseover\" width=\"$l_size_width\" height=\"$l_size_height\"></a></textarea>";
          $flink = "";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "1")) {
          $zip = "";
          $alt = "";
          $text = "";
          $flink = "<br /><a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>Download flash link!</a>";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "0")) {
          $zip = "";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=17><EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED></textarea>";
          $flink = "";
      }

      if (($czml['modalphaml'] == "1") && ($ext != ".swf")) {
      $alpha = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czml[modalphaml] == "0") {
      $alpha = "";
      } 

      if ($ext == ".swf") {
       $img = "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED>";
      } else {
       $img = "<img $alpha border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a>\n";
      }

            echo "<td width='25%' valign='top' class='row1'>";
            echo "<table border='0' width='100%'>";
            echo "<tr><td width='100%' align='center'><br />$zip$img$flink$text";
            echo "<br /><br /></td></tr>";
            echo "</table>";
            echo "</td>";
            $i++;
         if ($i == 4) { 
            echo "</tr>"; 
            $i = 0; 
         }
     }//END SQL LOOP
         if ($i ==1) { 
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "</tr></table>\n"; 
         } elseif ($i ==2) { 
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "</tr></table>\n"; 
         } elseif ($i ==3) { 
            echo "<td width='25%' class='row1'>&nbsp;</td></tr></table>"; 
         } else { 
            echo "</tr></table>";
         }
    CloseTable();
    echo "<br />";
    }else {
    echo "لینک و لوگوی وجود ندارد";
    }
    //BIGGER BANNERS...?
      if ($czml['modorderbyml'] == "0") {
      $czmodule2 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<250 AND l_size_width>130 ORDER BY l_id ASC");
      } elseif ($czml['modorderbyml'] == "1") {
      $czmodule2 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<250 AND l_size_width>130 ORDER BY l_id DESC");
      } elseif ($czml['modorderbyml'] == "2") {
      $czmodule2 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<250 AND l_size_width>130 ORDER BY rand()");
      }  
    $num = $db->sql_numrows($czmodule2);
    if ($num > 0) {
    OpenTable();
    echo "<br />";
      if ($czml['blkziportext'] == "1") {
          $explain = ""._ZIPEXPLAIN."";
      } elseif ($czml['blkziportext'] == "0") {
          $explain = ""._TEXTEXPLAIN."";  
      }
    echo "<center><table width='100%' bgcolor='$textcolor1' cellspacing='1' cellpadding='5'>"
	."<tr bgcolor=\"$bgcolor2\"><td align=\"center\">\n"
      .""._MEDIUMBUTTONS."<br />$explain</td>\n";
    echo "</tr></table><br />";
    Closetable();
    echo "<br />";
    Opentable();
    $i = 0;
    echo "<br /><table border='1' cellpadding='2' cellspacing='5' width='100%' class='row1'>";
    while (list($l_id, $l_zipurl, $l_image, $l_mouseover, $l_size_width, $l_size_height) = $db->sql_fetchrow($czmodule2)) {
          if ($i == 0) { 
            echo "<tr>"; 
          }
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
      if (($czml['blkziportext'] == "1") && ($ext != ".swf")) {
          $zip = "<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>";
          $alt = "Click here to download our link!";
          $text = ""; 
      } elseif (($czml['blkziportext'] == "0") && ($ext != ".swf")) {
          $zip = "<a href='$nukeurl'>";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=35><a href=\"$nukeurl\" target=\"_blank\"><img src=\"$nukeurl/$l_image\" border=\"0\" alt=\"$l_mouseover\" width=\"$l_size_width\" height=\"$l_size_height\"></a></textarea>";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "1")) {
          $zip = "<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>Download flash link!</a><br />";
          $alt = "";
          $text = "";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "0")) {
          $zip = "";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=35><EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED></textarea>";
      }

      if (($czml['modalphaml'] == "1") && ($ext != ".swf")) {
      $alpha = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czml[modalphaml] == "0") {
      $alpha = "";
      } 

      if ($ext == ".swf") {
       $img = "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED>";
      } else {
       $img = "<img $alpha border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a>\n";
      }
            echo "<td width='50%' valign='top' class='row1'>";
            echo "<table border='0' width='100%'>";
            echo "<tr><td width='100%' align='center'><br />$zip$img$text";
            echo "<br /><br /></td></tr>";
            echo "</table>";
            echo "</td>";
            $i++;
         if ($i == 2) { 
            echo "</tr>"; 
            $i = 0; 
         }
     }//END SQL LOOP
         if ($i ==1) { 
            echo "<td width='50%' class='row1'>&nbsp;</td>\n";
            echo "</tr></table>\n"; 
         } else { 
            echo "</tr></table>";
         }
    CloseTable();
    echo "<br />";
    }
    //AND EVEN BIGGER BANNERS...?
      if ($czml['modorderbyml'] == "0") {
      $czmodule3 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<500 AND l_size_width>250 ORDER BY l_id ASC");
      } elseif ($czml['modorderbyml'] == "1") {
      $czmodule3 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<500 AND l_size_width>250 ORDER BY l_id DESC");
      } elseif ($czml['modorderbyml'] == "2") {
      $czmodule3 = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<500 AND l_size_width>250 ORDER BY rand()");
      }    
    $num = $db->sql_numrows($czmodule3);
    if ($num > 0) {
    OpenTable();
    echo "<br />";
      if ($czml['blkziportext'] == "1") {
          $explain = ""._ZIPEXPLAIN."";
      } elseif ($czml['blkziportext'] == "0") {
          $explain = ""._TEXTEXPLAIN."";  
      }
    echo "<center><table width='100%' bgcolor='$textcolor1' cellspacing='1' cellpadding='5'>"
	."<tr bgcolor=\"$bgcolor2\"><td align=\"center\">\n"
      .""._LARGEBUTTONS."<br />$explain</td>\n";
    echo "</tr></table><br />";
    Closetable();
    echo "<br />";
    Opentable();
    echo "<br /><table border='1' cellpadding='2' cellspacing='5' width='100%' class='row1'><tr>";
    while (list($l_id, $l_zipurl, $l_image, $l_mouseover, $l_size_width, $l_size_height) = $db->sql_fetchrow($czmodule3)) {

       $ext = substr($l_image, strrpos($l_image,'.'), 5);
      if (($czml['blkziportext'] == "1") && ($ext != ".swf")) {
          $zip = "<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>";
          $alt = "Click here to download our link!";
          $text = ""; 
      } elseif (($czml['blkziportext'] == "0") && ($ext != ".swf")) {
          $zip = "<a href='$nukeurl'>";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=70><a href=\"$nukeurl\" target=\"_blank\"><img src=\"$nukeurl/$l_image\" border=\"0\" alt=\"$l_mouseover\" width=\"$l_size_width\" height=\"$l_size_height\"></a></textarea>";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "1")) {
          $zip = "<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>Download flash link!</a><br />";
          $alt = "";
          $text = "";
      } elseif (($ext == ".swf") && ($czml['blkziportext'] == "0")) {
          $zip = "";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=70><EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED></textarea>";
      }

      if (($czml['modalphaml'] == "1") && ($ext != ".swf")) {
      $alpha = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czml[modalphaml] == "0") {
      $alpha = "";
      } 

      if ($ext == ".swf") {
       $img = "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED>";
      } else {
       $img = "<img $alpha border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a>\n";
      }
            echo "<tr><td width='100%' valign='top' class='row1'>";
            echo "<table border='0' width='100%'>";
            echo "<tr><td width='100%' align='center'><br />$zip$img$text";
            echo "<br /><br /></td></tr>";
            echo "</table>";
            echo "</td></tr>";
     }//END SQL LOOP
            echo "</table><br /><br />\n"; 
    CloseTable();
    echo "<br />";
    }
      
      //START RESOURCES
      if ($czml['modactiveres'] == "1") {
      $i = 0;
      if ($czml['modorderbyres'] == "0") {
      $czmodule4 = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY r_id ASC");
      } elseif ($czml['modorderbyres'] == "1") {
      $czmodule4 = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY r_id DESC");
      } elseif ($czml['modorderbyres'] == "2") {
      $czmodule4 = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY rand()");
      }
    $num = $db->sql_numrows($czmodule4);
    if ($num > 0) {
    echo "<br />";
    opentable();
    echo "<br />";
     echo "<h3>"._RESOURCES."</h3><br />";
    echo "<table border='1' cellpadding='2' cellspacing='5' width='100%' class='row1'>";
    while (list($r_id, $r_name, $r_url, $r_image, $r_size_width, $r_size_height) = $db->sql_fetchrow($czmodule4)) {
          if ($i == 0) { 
            echo "<tr>"; 
          }
      $extres = substr($r_image, strrpos($r_image,'.'), 5);
      if (($czml['modalphares'] == "1") && ($extres != ".swf")) {
      $alphares = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czml[modalphares] == "0") {
      $alphares = "";
      } 

      if ($extres == ".swf") {
       $img = "<EMBED SRC=\"$r_image\" wmode=\"transparent\" WIDTH=\"$r_size_width\" HEIGHT=\"$r_size_height\"><NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED>";
      } else {
       $img = "<a href=\"modules.php?name=$module_name&amp;op=getres&amp;r_id=$r_id\" target=\"_blank\"><img $alphares border=\"0\" src=\"$r_image\" alt=\"$r_name\" title=\"$r_name\"></a>\n";
      }

            echo "<td width='25%' valign='top' class='row1'>";
            echo "<table border='0' width='100%'>";
            echo "<tr><td width='100%' align='center'><br />$img";
            echo "<br /><br /></td></tr>";
            echo "</table>";
            echo "</td>";
            $i++;
         if ($i == 4) { 
            echo "</tr>"; 
            $i = 0; 
         }
     }//END SQL LOOP
         if ($i ==1) { 
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "</tr></table>\n"; 
         } elseif ($i ==2) { 
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "<td width='25%' class='row1'>&nbsp;</td>\n";
            echo "</tr></table>\n"; 
         } elseif ($i ==3) { 
            echo "<td width='25%' class='row1'>&nbsp;</td></tr></table>"; 
         } else { 
            echo "</tr></table>";
         }
    CloseTable();
    echo "<br />";
    }
      }//END IF ACTIVE
  if (is_admin($admin)) {
    echo "<br /><center>[ <a href=\"".ADMIN_OP."linktous_config\">مدیریت لینک به ما</a> ]</center><br />\n";
  }

    include("footer.php");
    break; 
    
    case "getzip":
    getzip($l_id);
    break;

    case "getres":
    getres($r_id);
    break;

}

?>