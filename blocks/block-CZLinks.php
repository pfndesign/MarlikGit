<?php
/********************************************************/
/* Site Links To Us Module for PHP-Nuke                 */
/* Version 2.0 UNIVERSAL 2-04-05                        */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright � 2002-2005 by Codezwiz Network, LLC.      */
/********************************************************/
if (stristr("block-CZLinks.php",$_SERVER['SCRIPT_NAME'])) {
    Header("Location: ../index.php");
    die();
}
$module_name = "Link_To_Us";
get_lang("$module_name");

      global $prefix, $db, $user, $admin, $czbl, $nukeurl;
      $content = "<center>"._BLOCKTITLE."<br />\n";
      //START OUTPUT
      $content .= "<table border='0' width='100%'><tr><td align='center'>\n";
      global $db, $prefix;
	$czbl = array();
	$sql = "SELECT * FROM ".$prefix."_linktous_config";
	$result = $db->sql_query($sql);
	while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
		$czbl[$config_name] = $config_value;
	}

      if ($czbl['blkscrollml'] > "0") {
          if ($czbl['blkscrollml'] == "1") {
              $startmain = "";
              $start = "<center>";
              $end = "</center>";
              $endmain = "";
              $dir = "up";
              $hr = "<br /><hr width=\"95%\" /><br />";
          } elseif ($czbl['blkscrollml'] == "2") {
              $startmain = "";
              $start = "<center>";
              $end = "</center>";
              $endmain = "";
              $dir = "down";
              $hr = "<br /><hr width=\"95%\" /><br />";
          } elseif ($czbl['blkscrollml'] == "3") {
              $startmain = "<table border='0' width='100%' cellspacing='20'><tr>";
              $start = "<td align='center'>";
              $end = "</td>";
              $endmain = "</tr></table>\n";              
              $dir = "left";
              $hr = "";
          } elseif ($czbl['blkscrollml'] == "4") {
              $startmain = "<table border='0' width='100%' cellspacing='20'><tr>";
              $start = "<td align='center'>";
              $end = "</td>n";
              $endmain = "</tr></table>\n";
              $dir = "right";
              $hr = "";
          }
      $blkscrheightml = $czbl['blkscrheightml'];
      $blkscrdelayml = $czbl['blkscrdelayml'];
     if ($blkscrdelayml == "0") {
      $d = "10";
     } elseif ($blkscrdelayml == "1") {
      $d = "20";
     } elseif ($blkscrdelayml == "2") {
      $d = "30";
     } elseif ($blkscrdelayml == "3") {
      $d = "40";
     } elseif ($blkscrdelayml == "4") {
      $d = "50";
     } elseif ($blkscrdelayml == "5") {
      $d = "60";
     } elseif ($blkscrdelayml == "6") {
      $d = "70";
     } elseif ($blkscrdelayml == "7") {
      $d = "80";
     } elseif ($blkscrdelayml == "8") {
      $d = "90";
     } elseif ($blkscrdelayml == "9") {
      $d = "100";
     }
       
          $scroll = "<MARQUEE behavior='scroll' direction='$dir' height='$blkscrheightml' scrollamount='2' scrolldelay='$d' width='100%' onmouseover='this.stop()' onmouseout='this.start()'>\n";
          $scrollend = "</MARQUEE>\n"; 
      } else {
          $scroll = "<br />";
          $scrollend = "";
          $hr = "<br /><hr width=\"95%\" />"; 
      } 
      //START SCROLL
      $content .= "$scroll$startmain";

      //GET MYLINKS
      $toshow = $czbl['blktoshowml'];
      if ($czbl['blkorderml'] == "0") {
      $czml = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<130 AND l_linktype='0' ORDER BY l_id ASC LIMIT $toshow");
      } elseif ($czbl['blkorderml'] == "1") {
      $czml = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<130 AND l_linktype='0' ORDER BY l_id DESC LIMIT $toshow");
      } elseif ($czbl['blkorderml'] == "2") {
      $czml = $db->sql_query("SELECT l_id, l_zipurl, l_image, l_mouseover, l_size_width, l_size_height FROM ".$prefix."_linktous WHERE l_status='0' AND l_size_width<130 AND l_linktype='0' ORDER BY rand() LIMIT $toshow");
      }
      while (list($l_id, $l_zipurl, $l_image, $l_mouseover, $l_size_width, $l_size_height) = $db->sql_fetchrow($czml)) {

      $ext = substr($l_image, strrpos($l_image,'.'), 5);
if ($ext != ".swf") { 
      if (($czbl['blkziportext'] == "1") && ($ext != ".swf")) {
          $zip = "$start<a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>";
          $alt = ""._CLICKHERECZLINKTOUSD."";
          $text = "";
          $flink = ""; 
      } elseif (($czbl['blkziportext'] == "0") && ($ext != ".swf")) {
          $zip = "$start<a href='$nukeurl'>";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=17 dir=ltr align=left><a href=\"$nukeurl\" target=\"_blank\"><img src=\"$nukeurl/$l_image\" border=\"0\" alt=\"$l_mouseover\" width=\"$l_size_width\" height=\"$l_size_height\"></a></textarea>";
          $flink = "";
      } elseif (($ext == ".swf") && ($czbl['blkziportext'] == "1")) {
          $zip = "$start";
          $alt = "";
          $text = "";
          $flink = "<br /><a href='modules.php?name=$module_name&amp;op=getzip&amp;l_id=$l_id'>" . _CZLINKS_DOWNLOADLINK . "</a>";
      } elseif (($ext == ".swf") && ($czbl['blkziportext'] == "0")) {
          $zip = "$start";
          $alt = "";
          $text = "<br /><br /><textarea rows=3 cols=17><EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED>" . _CZLINKS_GETFLASH . "</NOEMBED></EMBED></textarea>";
          $flink = "";
      }

      if (($czbl['blkalphaml'] == "1") && ($ext != ".swf")) {
      $alpha = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czbl[blkalphaml] == "0") {
      $alpha = "";
      } 

      if ($ext == ".swf") {
       $img = "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED>" . _CZLINKS_GETFLASH . "</NOEMBED></EMBED>";
      } else {
       $img = "<img $alpha border=\"0\" src=\"$l_image\" alt=\"$alt\" title=\"$alt\"></a>\n";
      }
}//end swf
      //OUTPUT
      $content .= "$zip$img$flink$text$hr$end";
      }//END SQL LOOP  
      $content .= "$endmain$scrollend";
      $content .= "</td>\n</tr>\n</table>\n</center>\n";
      $content .= "<br /><b><center>"._CLICKTOVIEW."</center></b>\n";

      //START RESOURCES
      if ($czbl['blkactiveres'] == "1") {
      $content .= "<br /><br /><b><center>"._BLOCKRESOURCES."</center></b><br />\n";
      $content .= "<table border='0' width='100%'><tr><td align='center'>\n";
      if ($czbl['blkscrollres'] > "0") {
          if ($czbl['blkscrollres'] == "1") {
              $startmainres = "";
              $startres = "<center>";
              $endres = "</center>";
              $endmainres = "";
              $dirres = "up";
              $hrres = "<br /><hr width=\"95%\" /><br />";
          } elseif ($czbl['blkscrollres'] == "2") {
              $startmainres = "";
              $startres = "<center>";
              $endres = "</center>";
              $endmainres = "";
              $dirres = "down";
              $hrres = "<br /><hr width=\"95%\" /><br />";
          } elseif ($czbl['blkscrollres'] == "3") {
              $startmainres = "<table border='0' width='100%' cellspacing='20'><tr>";
              $startres = "<td align='center'>";
              $endres = "</td>";
              $endmainres = "</tr></table>\n";              
              $dirres = "left";
              $hrres = "";
          } elseif ($czbl['blkscrollres'] == "4") {
              $startmainres = "<table border='0' width='100%' cellspacing='20'><tr>";
              $startres = "<td align='center'>";
              $endres = "</td>n";
              $endmainres = "</tr></table>\n";
              $dirres = "right";
              $hrres = "";
          }
     $blkscrheightres = $czbl['blkscrheightres'];
     $blkscrdelayres = $czbl['blkscrdelayres'];
     if ($blkscrdelayres == "0") {
      $dd = "10";
     } elseif ($blkscrdelayres == "1") {
      $dd = "20";
     } elseif ($blkscrdelayres == "2") {
      $dd = "30";
     } elseif ($blkscrdelayres == "3") {
      $dd = "40";
     } elseif ($blkscrdelayres == "4") {
      $dd = "50";
     } elseif ($blkscrdelayres == "5") {
      $dd = "60";
     } elseif ($blkscrdelayres == "6") {
      $dd = "70";
     } elseif ($blkscrdelayres == "7") {
      $dd = "80";
     } elseif ($blkscrdelayres == "8") {
      $dd = "90";
     } elseif ($blkscrdelayres == "9") {
      $dd = "100";
     }
          $scrollres = "<MARQUEE behavior='scroll' direction='$dirres' height='$blkscrheightres' scrollamount='2' scrolldelay='$dd' width='100%' onmouseover='this.stop()' onmouseout='this.start()'>\n";
          $scrollendres = "</MARQUEE>\n"; 
      } else {
          $scrollres = "";
          $scrollendres = "";
          $hrres = "<br /><hr width=\"95%\" /><br />";
      } 
      //START SCROLL
      $content .= "$scrollres$startmainres";

      //GET RESOURCES
      $toshowres = $czbl['blktoshowres'];
      if ($czbl['blkorderres'] == "0") {
      $czres = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY r_id ASC LIMIT $toshowres");
      } elseif ($czbl['blkorderres'] == "1") {
      $czres = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY r_id DESC LIMIT $toshowres");
      } elseif ($czbl['blkorderres'] == "2") {
      $czres = $db->sql_query("SELECT r_id, r_name, r_url, r_image, r_size_width, r_size_height FROM ".$prefix."_linktous_resources WHERE r_status='0' AND r_size_width<130 ORDER BY rand() LIMIT $toshowres");
      }
      while (list($r_id, $r_name, $r_url, $r_image, $r_size_width, $r_size_height) = $db->sql_fetchrow($czres)) {

      $extres = substr($r_image, strrpos($r_image,'.'), 5);
      if (($czbl['blkalphares'] == "1") && ($extres != ".swf")) {
      $alphares = "onmouseover=high(this) style=\"FILTER: alpha(opacity=30); moz-opacity: 0.3\" onmouseout=low(this)";
      } elseif ($czbl[blkalphares] == "0") {
      $alphares = "";
      } 

      if ($extres == ".swf") {
       $imgres = "<EMBED SRC=\"$r_image\" wmode=\"transparent\" WIDTH=\"$r_size_width\" HEIGHT=\"$l_size_height\"><NOEMBED>" . _CZLINKS_GETFLASH . "</NOEMBED></EMBED>";
      } else {
       $imgres = "<a href='modules.php?name=$module_name&amp;op=getres&amp;r_id=$r_id' target='_blank'><img $alphares border='0' src='$r_image' height='$r_size_height' width='$r_size_width' alt='$r_name' title='$r_name'></a>\n";
      }
      //OUTPUT
      $content .= "$startres$imgres$hrres$endres";
      }//END SQL LOOP  
      $content .= "$endmainres$scrollendres";
      $content .= "</td>\n</tr>\n</table>\n</center>\n";
      }//END IF ACTIVE
  if (is_admin($admin)) {
      $content .= "<br /><br /><center>[ <a href=\"modules.php?name=Link_To_Us&amp;file=admin\">"._ADMINCZLINKTOUS."</a> ]</center>\n";
  }

?>
