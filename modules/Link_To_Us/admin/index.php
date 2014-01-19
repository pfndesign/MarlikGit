<?php
/**
*
* @package RSS Feed Class														
* @version $Id: $Kralpc --  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) http://codezwiz.com/  	Revised :  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('ADMIN_FILE')) {
   die ('Access Denied');
}
global $sitename;
$module_name = basename(dirname(dirname(__FILE__)));
get_lang($module_name);


global $prefix, $db,$admin, $admin_file;
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of("Link_To_Us",$admin)) {
/*********************************************************/
/* Index                                                 */
/*********************************************************/
$pagetitle = "مدیریت پیوندها";
      global $db, $prefix;
	$czlset = array();
	$sql = "SELECT * FROM ".$prefix."_linktous_config";
	$result = $db->sql_query($sql);
	while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
		$czlset[$config_name] = $config_value;
	}

function lmenu(){
    global $module_name,  $bgcolor1, $bgcolor2, $textcolor1, $sitename;
    GraphicAdmin();
    OpenTable();
    echo "<h3>"._MAINMENU."</h3>";
    echo "<center>\n<div><a href='".ADMIN_OP."resources' class='button'><img src='images/icon/heart.png'>"._RESOURCES."</a>&nbsp;&nbsp;\n"
    ."<a href='".ADMIN_OP."mylinks'  class='button'><img src='images/icon/user.png'>"._MYLINKS."</a>&nbsp;&nbsp;\n";
    echo "<a href='".ADMIN_OP."linktous_config'  class='button'><img src='images/icon/plugin_edit.png'>"._CONFIG."</a>";
    CloseTable();
    echo "<br />";
}

function resources() {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $sitename, $textcolor1, $czlset;
    $r_id = intval($r_id); 
    include ("header.php");
    echo "<SCRIPT LANGUAGE=\"javascript\" SRC=\"images/links/inc/link_java.js\"></SCRIPT>\n";
     lmenu();
    OpenTable();
    $sql = "SELECT * FROM ".$prefix."_linktous_resources ORDER BY r_id ASC";
    $result = $db->sql_query($sql);
    $num = $db->sql_numrows($result);
    if ($num > 0) {
    echo "<br><br><center><table width='100%' bgcolor='$textcolor1' cellspacing='1' cellpadding='3' class='widefat'>\n"
	  ."<thead><tr>\n";
    echo "<th  scope='col'>"._RESOURCENAME."</td>\n";
    echo "<th  scope='col'>"._RESOURCEIMAGE."</td>\n";
    echo "<th  scope='col'>"._RESOURCESTATUS."</td>\n";
    echo "<th  scope='col'>"._RESOURCESIZE."</td>\n";
    echo "<th  scope='col'>"._ACTION."</td>\n";
    echo "</tr></thead>";
    while ($row = $db->sql_fetchrow($result)) {
	$r_id = intval($row['r_id']);
      $r_name = $row['r_name'];
      $r_url = $row['r_url'];
      $r_image = $row['r_image'];
      $r_status = $row['r_status'];
      $r_size_width = $row['r_size_width'];
      $r_size_height = $row['r_size_height'];
     if ($r_status == "0") {
      $status = ""._ACTIVE."";
     } elseif ($r_status == "1") {
      $status = ""._NOTACTIVE."";
    }
      echo "<tr><td width='20%' align='center'><b>$r_name</b></td>\n";
      echo "<td width='20%' align='center'>\n";
      echo "<b><a href=\"$r_image\" class='colorbox'>"._VIEWIMAGE."</a></b></td><td width='20%' align='center'>\n";
      echo "<b>$status</b></td>";
      echo "<td width='20%' style='direction:ltr'><b>$r_size_width x $r_size_height</b></td>";
      echo "<td width='20%' align='center'>[ <a href=\"".ADMIN_OP."resedit&amp;r_id=$r_id\">"._EDIT."</a> | <a href=\"".ADMIN_OP."resdel&amp;r_id=$r_id&amp;ok=0\">"._DELETE."</a> ]</td></tr>";
   }
    echo "</table></center><br><br>";
  } else {
    echo "<center><b>"._NORESOURCESYET."</b><br /></center>\n";
  }
    CloseTable();
    echo "<br />";
    Opentable();
  echo "<br /><center><font class=\"option\"><b>"._ADDRESOURCE."</b></font></center>"
	."<form action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">"
	."<input type=\"hidden\" name=\"r_id\" value=\"$r_id\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td>"._RESOURCENAME.":</td><td><input type=\"text\" name=\"r_name\" size=\"31\"></td></tr>"
	."<tr><td>"._RESOURCEURL.":</td><td><input type=\"text\" dir='ltr' name=\"r_url\" size=\"31\"></td></tr>"
	."<tr><td>"._RESOURCEIMAGE.":</td><td><input type=\"file\" dir='ltr' name=\"r_image\" size=\"31\"></td></tr>"
	."<tr><td>"._RESOURCESTATUS.":</td><td><select name=\"r_status\">";    
  echo "<option value='0' selected>"._ACTIVE."</option>";
  echo "<option value='1'>"._NOTACTIVE."</option></td></tr>"
      ."</table><br />"                                                                                                                                               
	."<input type=\"hidden\" name=\"op\" value=\"resadd\">"
	."<input type=\"submit\" value='ارسال'> "._GOBACK.""
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
}

function resadd($r_id, $r_name, $r_url, $r_image, $r_status, $r_size_width, $r_size_height) {
    global $module_name, $prefix, $db, $czlset;
    $r_id = intval($r_id);
    if (($r_name=="")OR($r_url=="")OR($r_image=="")) {
    include("header.php");
    Opentable();
    echo "<br /><br /><center>"._MISSINGDATA."<br />\n";
    echo ""._GOBACK."\n";
    Closetable();
    } else { 
        $image_name = $_FILES['r_image']['name'];
        $image_temp = $_FILES['r_image']['tmp_name'];
        $ext = substr($image_name, strrpos($image_name,'.'), 5);
        $resname = ereg_replace(" ","_",$image_name);
        $resname = strtolower("$resname");
             if (move_uploaded_file($image_temp, "$czlset[path]/res/$resname$ext")) {

                chmod ("$czlset[path]/res/$resname$ext", 0755);
             if ($ext !=".swf") {
                $size = getimagesize("$czlset[path]/res/$resname$ext");
             }
                $r_image = "$czlset[path]/res/$resname$ext";
             } else {
                include("header.php");
                opentable();
                echo "<br><br>"._NOTHINGUPLOADED."<br>\n";
                echo ""._GOBACK."";
                closetable();
                include("footer.php");
                die(); 
             }
     
   if ($ext ==".swf") {
       $r_size_width= 0; 
       $r_size_height= 0;
   } else { 
       $r_size_width= $size[0]; 
       $r_size_height= $size[1];
   }

    $db->sql_query("INSERT INTO ".$prefix."_linktous_resources values (NULL, '$r_name', '$r_url', '$r_image', '$r_status', '$r_size_width', '$r_size_height', '')");
   if ($ext ==".swf") {
    header("Location: ".ADMIN_OP."resswf&r_id=$r_id");
   } else {
    header("Location: ".ADMIN_OP."resources");
   }
   }
}

function resswf($r_id, $r_size_width, $r_size_height) {
    global $module_name, $bgcolor2, $textcolor1;
    include("header.php");
    lmenu();
    Opentable();
    echo "<br />";
    echo "<form action=\"".ADMIN_OP."linktous_config\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"r_id\" value=\"$r_id\">";
    echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>";
  echo "<tr><td>"._RESOURCESSWFSIZE.":</td><td>"._WIDTH.":<input type=\"text\" dir='ltr' name=\"r_size_width\" size=\"4\">&nbsp;&nbsp;&nbsp;"._HEIGHT.":<input type=\"text\" dir='ltr' name=\"r_size_height\" size=\"4\"><br /></td></tr>";
    echo "</table>\n"	
        ."<input type=\"hidden\" name=\"op\" value=\"resswfadd\">"
	  ."<input type=\"submit\" value="._ADD."> "._GOBACK.""
	  ."</form></center><br />";
    Closetable();
    include("footer.php");     
}

function resswfadd($r_id, $r_size_width, $r_size_height) {
    global $module_name, $prefix, $db, $czlset;
    $db->sql_query("update ".$prefix."_linktous_resources set r_size_width='$r_size_width', r_size_height='$r_size_height' where r_id='$r_id'");
    header("Location: ".ADMIN_OP."mylinks");
}

function resedit($r_id) {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $sitename, $textcolor1, $czlset;
    $r_id = intval($r_id); 
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>$sitename $sitename "._RESOURCES."</b></font></center>";
    CloseTable();
    echo "<br />";
    lmenu();
    $sql = "SELECT * FROM ".$prefix."_linktous_resources where r_id='$r_id'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
	$r_id = intval($row['r_id']);
      $r_name = $row['r_name'];
      $r_url = $row['r_url'];
      $r_image = $row['r_image'];
      $r_status = $row['r_status'];
      $r_size_width = $row['r_size_width'];
      $r_size_height = $row['r_size_height'];
     if ($r_status == "0") {
      $st1 = "selected";
      $st2 = "";
     } elseif ($r_status == "1") {
      $st1 = "";
      $st2 = "selected";
    }
    OpenTable();
    echo "<center><font class=\"option\"><b>"._EDITRESOURCE."</b><br /><br /></font></center>"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td align=\"center\">\n";
      $ext = substr($r_image, strrpos($r_image,'.'), 5);
   if ($ext == ".swf") {
  echo "<EMBED SRC=\"$r_image\" wmode=\"transparent\" WIDTH=\"$r_size_width\" HEIGHT=\"$r_size_height\">";
  echo "<NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED></td>";
   } else {
  echo "<a href=\"$r_url\" target=\"_blank\"><img border=\"0\" src=\"$r_image\" alt=\"$r_name\" title=\"$r_name\"></a></td>\n";
   }
  echo "</tr></table><br /><br />"
	."<form action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">";
  echo "<input type='hidden' name='old_image' value='$r_image'>";
  echo "<input type='hidden' name='old_image_width' value='$r_size_width'>";
  echo "<input type='hidden' name='old_image_height' value='$r_size_height'>"
	."<input type=\"hidden\" name=\"r_id\" value=\"$r_id\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td>"._RESOURCENAME.":</td><td><input type=\"text\" name=\"r_name\" size=\"31\" value=\"$r_name\"></td></tr>"
	."<tr><td>"._RESOURCEURL.":</td><td><input type=\"text\" dir='ltr' name=\"r_url\" size=\"31\" value=\"$r_url\"></td></tr>"
	."<tr><td>"._RESOURCEIMAGE.":</td><td><input type=\"file\" dir='ltr' name=\"new_image\" size=\"31\"><br />$r_image</td></tr>";
   if ($ext == ".swf") {
  echo "<tr><td>"._MYLINKSSWFSIZE.":</td><td>"._WIDTH.":<input type=\"text\" dir='ltr' name=\"new_size_width\" size=\"4\" value=\"$r_size_width\">&nbsp;&nbsp;&nbsp;"._HEIGHT.":<input type=\"text\" dir='ltr' name=\"new_size_height\" size=\"4\" value=\"$r_size_height\"><br /></td></tr>";
   }
  echo "<tr><td>"._RESOURCESTATUS.":</td><td><select name=\"r_status\">";    
  echo "<option value='0' $st1>"._ACTIVE."</option>";
  echo "<option value='1' $st2>"._NOTACTIVE."</option></td></tr>"
      ."</table><br />"                                                                                                                                               
	."<input type=\"hidden\" name=\"op\" value=\"ressave\">"
	."<input type=\"submit\" value=Update> "._GOBACK.""
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
 }
}

function ressave($r_id, $r_name, $r_url, $r_image, $r_status, $old_image, $new_image, $r_size_width, $r_size_height, $new_size_width, $new_size_height, $old_image_width, $old_image_height) {
    global $module_name, $prefix, $db, $czlset;
    $r_id = intval($r_id);
        $image_name = $_FILES['new_image']['name'];
        $image_temp = $_FILES['new_image']['tmp_name'];
        if ($image_name != "") {
        $ext = substr($image_name, strrpos($image_name,'.'), 5);
        $resname = ereg_replace(" ","_",$r_name);
        $resname = strtolower("$resname");
             if (move_uploaded_file($image_temp, "$czlset[path]/res/$resname$ext")) {
                chmod ("$czlset[path]/res/$resname$ext", 0755);
             if ($ext !=".swf") {
                $size = getimagesize("$czlset[path]/res/$resname$ext");
                $r_size_width = $size[0]; 
                $r_size_height = $size[1];
             } else {
                $r_size_width = $new_size_width; 
                $r_size_height = $new_size_height;
             }
                $r_image = "$czlset[path]/res/$resname$ext";
             } else {
                include("header.php");
                opentable();
                echo "<br><br>"._NOTHINGUPLOADED."<br>\n";
                echo ""._GOBACK."";
                closetable();
                include("footer.php");
                die(); 
            }
     
         } else {
        $r_image = "$old_image";
        $r_size_width = "$old_image_width"; 
        $r_size_height = "$old_image_height";
         }
    $db->sql_query("update ".$prefix."_linktous_resources set r_name='$r_name', r_url='$r_url', r_image='$r_image', r_status='$r_status', r_size_width='$r_size_width', r_size_height='$r_size_height' where r_id='$r_id'");
    header("Location: ".ADMIN_OP."resources");
}


function resdel($r_id, $ok=0) {
    global $module_name, $prefix, $db, $sitename, $sitename;
    $r_id = intval($r_id);
    if($ok==1) {

    $result = $db->sql_query("select r_image from ".$prefix."_linktous_resources where r_id='$r_id'");
    list($r_image) = $db->sql_fetchrow($result); 

      $db->sql_query("delete from ".$prefix."_linktous_resources where r_id='$r_id'");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous_config");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous_resources");
      if (!@unlink($r_image)) {
                include("header.php");
                opentable();
                echo "<br><br>"._ERRORDELETINGIMAGE."<br>\n";
                echo "[ <a href=\"".ADMIN_OP."resources\">Go Back</a> ]";
                closetable();
                include("footer.php");
                die();  
      }
	header("Location: ".ADMIN_OP."resources");
    } else {
	include("header.php");
	OpenTable();
	echo "<center><font class=\"title\"><b>$sitename $sitename "._RESOURCES."</b></font></center>";
	CloseTable();
      echo "<br />";
      lmenu();
	OpenTable();
	echo "<br><center><b>"._AREYOUSUREDELRESOURCE."</b><br><br>";
    }
	echo "[ <a href=\"".ADMIN_OP."resdel&amp;r_id=$r_id&amp;ok=1\">"._YES."</a> | <a href=\"".ADMIN_OP."resources\">"._NO."</a> ]</center><br><br>";
	CloseTable(); 
       
	include("footer.php");
}
//===================================================================================================
function mylinks() {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $sitename, $textcolor1, $czlset;
    $l_id = intval($l_id); 
    include ("header.php");
    echo "<SCRIPT LANGUAGE=\"javascript\" SRC=\"images/links/inc/link_java.js\">\n"
        ."</SCRIPT>\n";
    lmenu();
    OpenTable();
    $sql = "SELECT * FROM ".$prefix."_linktous ORDER BY l_id ASC";
    $result = $db->sql_query($sql);
    $num = $db->sql_numrows($result);
    echo "<br><br>\n";
    if ($num > 0) {
    echo "<center><table width='100%' bgcolor='$textcolor1' cellspacing='1' cellpadding='2' class='widefat'>\n"
	  ."<thead><tr>\n";
   if ($czlset[blkziportext] == "1") {
    $tdwidth = "16%";
    echo "<th  scope='col' width='$tdwidth'>"._MYLINKSZIP."</td>\n";
    } else {
    $tdwidth = "20%";
    }
    echo "<th  scope='col' width='$tdwidth'>"._MYLINKSIMAGE."</td>\n";
    echo "<th  scope='col' width='$tdwidth'>"._MYLINKSSTATUS."</td>\n";
    echo "<th  scope='col' width='$tdwidth'>"._MYLINKSSIZE."</td>\n";
    echo "<th  scope='col' width='$tdwidth'>"._MYLINKSHITS."</td>\n";
    echo "<th  scope='col' width='$tdwidth'>"._ACTION."</td></tr><thead>";
    while ($row = $db->sql_fetchrow($result)) {
	$l_id = intval($row['l_id']);
      $l_zipurl = $row['l_zipurl'];
      $l_image = $row['l_image'];
      $l_mouseover = intval($row['l_mouseover']);
      $l_status = intval($row['l_status']);
      $l_size_width = intval($row['l_size_width']);
      $l_size_height = intval($row['l_size_height']);
      $l_hits = intval($row['l_hits']);
      $l_hits = number_format($l_hits, 0); 
     if ($l_status == "0") {
      $status = ""._ACTIVE."";
     } elseif ($l_status == "1") {
      $status = ""._NOTACTIVE."";
     }

      $path = "$czlset[path]/";
      $imagename = str_replace($path, "", $l_image);

      echo "<tr>\n";
   if ($czlset[blkziportext] == "1") {
      echo "<td width='$tdwidth' align='center'><b><a href=\"$l_zipurl\">$imagename</a></b></td>\n";
   }
      echo "<td width='$tdwidth' align='center'>\n";
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
      $view = "<a href=\"$l_image\" title=\""._VIEWIMAGE."\" class='colorbox' >"._VIEWIMAGE."</a>";
      echo "$view</td>\n";
      echo "<td width='$tdwidth' align='center'><b>$status</b></td>\n";
      echo "<td width='$tdwidth'  style='direction:ltr'><b>$l_size_width x $l_size_height</b></td>";
      echo "<td width='$tdwidth' align='center'><b>$l_hits</b></td>\n";
      echo "<td width='$tdwidth' align='center'>[ <a href=\"".ADMIN_OP."mylinksedit&amp;l_id=$l_id\">"._EDIT."</a> | <a href=\"".ADMIN_OP."mylinksdel&amp;l_id=$l_id&amp;ok=0\">"._DELETE."</a> ]</td></tr>";
  }
     echo "</table></center><br />";
 } else {
    echo "<br /><center><b>"._NOMYLINKSYET."</b><br /><br /></center>\n";
}
    CloseTable();
    echo "<br />";
    Opentable();
  //MAYBE WE HAVE TO DEBUG 
  //$base = str_repeat("../", substr_count(dirname($_SERVER["SCRIPT_NAME"]), "/"));
  //echo "$base";
  echo "<br /><center><font class=\"option\"><b>"._ADDMYLINKS."</b></font></center>"
	."<form id=\"mainform\" action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>";
  echo "<tr><td>"._MYLINKSIMAGEUPLOAD.":</td><td><input type=\"file\" name=\"l_image\" size=\"31\"><br /></td></tr>";
  echo "<tr><td>"._MYLINKSMOUSEOVER.":</td><td><textarea name=\"l_mouseover\" rows=\"2\" cols=\"60\"></textarea></td></tr>";
  echo "<tr><td>"._MYLINKSSTATUS.":</td><td><select name=\"l_status\">";    
  echo "<option value='0' selected>"._ACTIVE."</option>";
  echo "<option value='1'>"._NOTACTIVE."</option></select></td></tr>"
      ."</table><br />"                                                                                                                                               
	."<input type=\"hidden\" name=\"op\" value=\"mylinksadd\">"
	."<input type=\"submit\" value="._ADDMYLINK.">"
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
}

function mylinksadd($l_zipurl, $l_image, $l_mouseover, $l_status, $l_size_width, $l_size_height) {
    global $module_name, $prefix, $db, $sitename, $czlset, $slogan;
    $site = strtolower("$sitename");
    if ($l_image == "") {
    include("header.php");
    Opentable();
    echo "<br /><br /><center>".MISSINGDATA."<br /><br />\n";
    echo ""._GOBACK."\n";
    Closetable();
    include("footer.php");
    } else {

    $result = $db->sql_query("select l_id from ".$prefix."_linktous ORDER BY l_id DESC LIMIT 0,1");
    list($l_id) = $db->sql_fetchrow($result);
    if ($l_id == ""){
        $db->sql_query("DROP TABLE ".$prefix."_linktous");
        $db->sql_query("CREATE TABLE ".$prefix."_linktous(`l_id` int(11) NOT NULL auto_increment, `l_zipurl` varchar(255) NOT NULL default '', `l_image` varchar(255) NOT NULL default '', `l_mouseover` varchar(255) NOT NULL default '', `l_status` int(1) NOT NULL default '0', `l_size_width` char(3) NOT NULL default '0', `l_size_height` char(3) NOT NULL default '0', `l_hits` bigint(20) NOT NULL default '0', `l_linktype` int(1) NOT NULL default '0', PRIMARY KEY  (`l_id`), KEY `l_id` (`l_id`))"); 
        $ll_id = 1;
    } else { 
        $ll_id = $l_id + 1;
    }
        $image_name = $_FILES['l_image']['name'];
        $image_temp = $_FILES['l_image']['tmp_name'];
        $ext = substr($image_name, strrpos($image_name,'.'), 5);
             if (move_uploaded_file($image_temp, "$czlset[path]/$site$ll_id$ext")) {

                chmod ("$czlset[path]/$site$ll_id$ext", 0755);
             if ($ext !=".swf") {
                $size = getimagesize("$czlset[path]/$site$ll_id$ext");
             }
                $l_image = "$czlset[path]/$site$ll_id$ext";
             } else {
                include("header.php");
                opentable();
                echo "<br><br>"._NOTHINGUPLOADED."<br>\n";
                echo ""._GOBACK."";
                closetable();
                include("footer.php");
                die(); 
             }
     
         if (($l_mouseover=="") || ($ext !=".swf")) {
              $l_mouseover = "$sitename $slogan";
         }
   if ($ext ==".swf") {
       $l_size_width= 0; 
       $l_size_height= 0;
       $linktype = 1;
   } else { 
       $l_size_width= $size[0]; 
       $l_size_height= $size[1];
       $linktype = 0;
   }
    if ($l_id == ""){
    $db->sql_query("INSERT INTO ".$prefix."_linktous values (NULL, '', '$l_image', '$l_mouseover', '$l_status', '$l_size_width', '$l_size_height', '0', '$linktype')");
    } else {
    $db->sql_query("INSERT INTO ".$prefix."_linktous values ($ll_id, '', '$l_image', '$l_mouseover', '$l_status', '$l_size_width', '$l_size_height', '0', '$linktype')");
    }
if ($czlset[blkziportext] == "1") {
    $result = $db->sql_query("select l_id from ".$prefix."_linktous where l_image='$l_image'");
    list($l_id) = $db->sql_fetchrow($result);
   if ($ext ==".swf") {
    header("Location: ".ADMIN_OP."mylinksswf&l_id=$l_id");
   } else {
    header("Location: ".ADMIN_OP."zipset&l_id=$l_id");
   }
} else {
    header("Location: ".ADMIN_OP."mylinks");
}

    }
}

function mylinksswf($l_id, $l_size_width, $l_size_height) {
    global $module_name, $bgcolor2, $textcolor1;
    include("header.php");
    lmenu();
    Opentable();
    echo "<br />";
    echo "<form action=\"".ADMIN_OP."linktous_config\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"l_id\" value=\"$l_id\">";
    echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>";
  echo "<tr><td>"._MYLINKSSWFSIZE.":</td><td>"._WIDTH.":<input type=\"text\" dir='ltr' name=\"l_size_width\" size=\"4\">&nbsp;&nbsp;&nbsp;"._HEIGHT.":<input type=\"text\" dir='ltr' name=\"l_size_height\" size=\"4\"><br /></td></tr>";
    echo "</table>\n"	
        ."<input type=\"hidden\" name=\"op\" value=\"mylinksswfadd\">"
	  ."<input type=\"submit\" value="._ADD."> "._GOBACK.""
	  ."</form></center><br />";
    Closetable();
    include("footer.php");     
}

function mylinksswfadd($l_id, $l_size_width, $l_size_height) {
    global $module_name, $prefix, $db, $czlset;
    $db->sql_query("update ".$prefix."_linktous set l_size_width='$l_size_width', l_size_height='$l_size_height', l_linktype='1' where l_id='$l_id'");
    if ($czlset[blkziportext] == "1") {
    header("Location: ".ADMIN_OP."zipset&l_id=$l_id");
    } else {
    header("Location: ".ADMIN_OP."mylinks");
    }
}

function mylinksedit($l_id) {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $nukeurl, $sitename, $textcolor1, $czlset;
    $l_id = intval($l_id); 
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>$sitename $sitename "._MYLINKS."</b></font></center>";
    CloseTable();
    echo "<br />";
    lmenu();
    $sql = "SELECT * FROM ".$prefix."_linktous where l_id='$l_id'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
	$l_id = intval($row['l_id']);
      $l_zipurl = $row['l_zipurl'];
      $l_image = $row['l_image'];
      $l_mouseover = $row['l_mouseover'];
      $l_status = $row['l_status'];
      $l_size_width = $row['l_size_width'];
      $l_size_height = $row['l_size_height'];

     if ($l_status == "0") {
      $st1 = "selected";
      $st2 = "";
     } elseif ($l_status == "1") {
      $st1 = "";
      $st2 = "selected";
     }

    OpenTable();
  echo "<center><font class=\"option\"><b>"._EDITMYLINKS."</b><br /><br /></font></center>"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td align=\"center\">\n";
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
   if ($ext == ".swf") {
  echo "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\">";
  echo "<NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED></td>";
   } else {
  echo "<a href=\"$nukeurl\" target=\"_blank\"><img border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a></td>\n";
   }
  echo "</tr></table><br /><br />"
	."<form action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">"
	."<input type=\"hidden\" name=\"op\" value=\"mylinkssave\">"; 
  echo "<input type='hidden' name='old_image' value='$l_image'>";
  echo "<input type='hidden' name='old_image_width' value='$l_size_width'>";
  echo "<input type='hidden' name='old_image_height' value='$l_size_height'>";
  echo "<input type=\"hidden\" name=\"l_id\" value=\"$l_id\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>";
   if ($czlset[blkziportext] == "1") {
  echo "<tr><td>"._MYLINKSZIPURL.":</td><td>$l_zipurl&nbsp;&nbsp;[ <a href=\"".ADMIN_OP."zipsetedit&amp;l_id=$l_id\">"._EDIT."</a> ]</td></tr>";
   }
   if ($ext == ".swf") {
  echo "<tr><td>"._MYLINKSSWFSIZE.":</td><td>"._WIDTH.":<input type=\"text\" name=\"new_size_width\" size=\"4\" value=\"$l_size_width\">&nbsp;&nbsp;&nbsp;"._HEIGHT.":<input type=\"text\" name=\"new_size_height\" size=\"4\" value=\"$l_size_height\"><br /></td></tr>";
   }
  echo "<tr><td>"._MYLINKSIMAGEUPLOAD.":</td><td><input type=\"file\" name=\"new_image\" size=\"31\"><br />$l_image<br /></td></tr>";
  echo "<tr><td>"._MYLINKSMOUSEOVER.":</td><td><textarea name=\"l_mouseover\" rows=\"2\" cols=\"60\">$l_mouseover</textarea></td></tr>";
  echo "<tr><td>"._MYLINKSSTATUS.":</td><td><select name=\"l_status\">";    
  echo "<option value='0' $st1>"._ACTIVE."</option>";
  echo "<option value='1' $st2>"._NOTACTIVE."</option></select></td></tr>"
      ."</table><br />"                                                                                                                                           
	."<input type=\"submit\" value=Update> [ <a href=\"".ADMIN_OP."mylinksdel&amp;l_id=$l_id&amp;ok=0\">"._DELETE."</a> ] "._GOBACK.""
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
 }
}

function mylinkssave($l_id, $l_zipurl, $l_image, $l_mouseover, $l_status, $old_image, $new_image, $l_size_width, $l_size_height, $new_size_width, $new_size_height, $old_image_width, $old_image_height) 
{
    global $module_name, $prefix, $db, $sitename, $czlset, $slogan;
    $site = strtolower("$sitename");  
    $l_id = intval($l_id);

        $image_name = $_FILES['new_image']['name'];
        $image_temp = $_FILES['new_image']['tmp_name'];
        if ($image_name != "") {

        $ext = substr($image_name, strrpos($image_name,'.'), 5);
             if (move_uploaded_file($image_temp, "$czlset[path]/$site$l_id$ext")) {

                chmod ("$czlset[path]/$site$l_id$ext", 0755);
             if ($ext !=".swf") {
                $size = getimagesize("$czlset[path]/$site$l_id$ext");
                $l_size_width = $size[0]; 
                $l_size_height = $size[1];
             } else {
                $l_size_width = "$new_size_width"; 
                $l_size_height = "$new_size_height";
             } 
                $l_image = "$czlset[path]/$site$l_id$ext";
             } else {
                include("header.php");
                opentable();
                echo "<br><br>"._NOTHINGUPLOADED."<br>\n";
                echo ""._GOBACK."";
                closetable();
                include("footer.php");
                die(); 
            }
     
         } else {
        $l_image = "$old_image";
        $l_size_width = "$old_image_width"; 
        $l_size_height = "$old_image_height"; 
         }
                   $ext = substr($l_image, strrpos($l_image,'.'), 5);
                   if ($ext == ".swf") {
                   $linktype = 1;
                   } else {
                   $linktype = 0;
                   } 
        $db->sql_query("update ".$prefix."_linktous set l_image='$l_image', l_mouseover='$l_mouseover', l_status='$l_status', l_size_width='$l_size_width', l_size_height='$l_size_height', l_linktype='$linktype' where l_id='$l_id'");
    header("Location: ".ADMIN_OP."mylinks");
} 


function mylinksdel($l_id, $ok=0) {
    global $module_name, $prefix, $db, $sitename, $sitename, $czlset;
    $l_id = intval($l_id);
    if($ok==1) {
     
    $result = $db->sql_query("select l_zipurl, l_image from ".$prefix."_linktous where l_id='$l_id'");
    list($l_zipurl, $l_image) = $db->sql_fetchrow($result);

      $db->sql_query("delete from ".$prefix."_linktous where l_id='$l_id'");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous_config");
      $db->sql_query("OPTIMIZE TABLE ".$prefix."_linktous_resources");

      if (!@unlink($l_image)) {
                include("header.php");
                opentable();
                echo "<br><br>"._ERRORDELETINGIMAGE."<br>\n";
                echo "[ <a href=\"".ADMIN_OP."mylinks\">Go Back</a> ]";
                closetable();
                include("footer.php");
                die();  
      }
      if ((!@unlink($l_zipurl)) && ($czlset['blkziportext'] == "1")) {
                include("header.php");
                opentable();
                echo "<br><br>"._ERRORDELETINGZIP."<br>\n";
                echo "[ <a href=\"".ADMIN_OP."mylinks\">Go Back</a> ]";
                closetable();
                include("footer.php");
                die();  
      }
	header("Location: ".ADMIN_OP."mylinks");

    } else {
	include("header.php");
	OpenTable();
	echo "<center><font class=\"title\"><b>$sitename $sitename "._MYLINKS."</b></font></center>";
	CloseTable();
      echo "<br />";
      lmenu();
	OpenTable();
	echo "<br><center><b>"._AREYOUSUREDELMYLINK."</b><br><br>";
    }
	echo "[ <a href=\"".ADMIN_OP."mylinksdel&amp;l_id=$l_id&amp;ok=1\">"._YES."</a> | <a href=\"".ADMIN_OP."mylinks\">"._NO."</a> ]</center><br><br>";
	CloseTable(); 
       
	include("footer.php");
}

function zipset($l_id) {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $sitename, $textcolor1, $czlset, $nukeurl;
    $l_id = intval($l_id); 
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>$sitename $sitename "._MYLINKS."</b></font></center>";
    CloseTable();
    echo "<br />";
    lmenu();
    $sql = "SELECT * FROM ".$prefix."_linktous where l_id='$l_id'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
	$l_id = intval($row['l_id']);
      $l_image = $row['l_image'];
      $l_mouseover = $row['l_mouseover'];
      $l_status = $row['l_status'];
      $l_size_width = $row['l_size_width'];
      $l_size_height = $row['l_size_height'];
    OpenTable();
  echo "<center><font class=\"option\"><b>"._ADDZIPMYLINKS."</b><br /><br /></font></center>"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td align=\"center\">\n";
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
   if ($ext == ".swf") {
  echo "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\">";
  echo "<NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED><br /><a href=\"$l_image\">Right click save as...</a></td>";
   } else {
  echo "<a href=\"$nukeurl\" target=\"_blank\"><img border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a></td>\n";
   }
  echo "</tr></table><br /><br />"
	."<form action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">"
	."<input type=\"hidden\" name=\"op\" value=\"zipsetadd\">"; 
  echo "<input type=\"hidden\" name=\"l_id\" value=\"$l_id\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td width=\40%\">"._MYLINKSIMAGEHTML.":</td><td width=\60%\">";
   if ($ext == ".swf") {
  echo "<textarea rows=4 cols=70><EMBED SRC='$nukeurl/$l_image' wmode='transparent' WIDTH='$l_size_width' HEIGHT='$l_size_height'>";
  echo "<NOEMBED><a href='http://www.macromedia.com/go/getflashplayer/'>Get Flash!</a></NOEMBED></EMBED></textarea></td></tr>\n";
   } else {
  echo "<textarea rows=4 cols=70><a href='$nukeurl' target='_blank'><img src='$nukeurl/$l_image' border='0' alt='$l_mouseover' width='$l_size_width' height='$l_size_height'></a></textarea></td></tr>";
  }
  echo "<tr><td width=\40%\">"._MYLINKSZIPUPLOAD.":</td><td width=\60%\"><input type=\"file\" name=\"l_zipurl\" size=\"31\"></td></tr>"
      ."</table><br />"                                                                                                                                           
	."<input type=\"submit\" value=Update> "._GOBACK.""
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
 }
}

function zipsetadd($l_id, $l_zipurl) 
{
    global $module_name, $prefix, $db, $sitename, $czlset;
    $site = strtolower("$sitename");  
    $l_id = intval($l_id);
    $result = $db->sql_query("select l_id from ".$prefix."_linktous ORDER BY l_id DESC LIMIT 0,1");
    list($l_id) = $db->sql_fetchrow($result);
    if ($l_id == ""){
        $ll_id = 1;
    } else {
        $ll_id = $l_id;
    }
        $zipurl = $_FILES['l_zipurl']['name'];
        $zipurl_temp = $_FILES['l_zipurl']['tmp_name'];
        //$ext = strrchr($_FILES['l_zipurl']['name'], '.');
             $ext = substr($zipurl, strrpos($zipurl,'.'), 5);
             if (move_uploaded_file($zipurl_temp, "$czlset[zippath]/$site$ll_id$ext")) {

                chmod ("$czlset[zippath]/$site$ll_id$ext", 0755);
                $l_zipurl = "$czlset[zippath]/$site$ll_id$ext";
             } else {
                include("header.php");
                opentable();
                echo "<br><br>"._NOTHINGUPLOADEDZIP."<br>\n";
                echo ""._GOBACK."";
                closetable();
                include("footer.php");
                die(); 
            }
     
    $db->sql_query("update ".$prefix."_linktous set l_zipurl='$l_zipurl' where l_id='$l_id'");
    header("Location: ".ADMIN_OP."mylinks");
}

function zipsetedit($l_id) {
    global $module_name, $admin, $bgcolor2, $prefix, $db, $sitename, $sitename, $textcolor1, $czlset, $nukeurl;
    $l_id = intval($l_id); 
    include ("header.php");
    OpenTable();
    echo "<center><font class=\"title\"><b>$sitename $sitename "._MYLINKS."</b></font></center>";
    CloseTable();
    echo "<br />";
    lmenu();
    $sql = "SELECT * FROM ".$prefix."_linktous where l_id='$l_id'";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetchrow($result)) {
	$l_id = intval($row['l_id']);
      $l_zipurl = $row['l_zipurl'];
      $l_image = $row['l_image'];
      $l_mouseover = $row['l_mouseover'];
      $l_status = $row['l_status'];
      $l_size_width = $row['l_size_width'];
      $l_size_height = $row['l_size_height'];

    OpenTable();
  echo "<center><font class=\"option\"><b>"._EDITZIPMYLINKS."</b><br /><br /></font></center>"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td align=\"center\">\n";
      $ext = substr($l_image, strrpos($l_image,'.'), 5);
   if ($ext == ".swf") {
  echo "<EMBED SRC=\"$l_image\" wmode=\"transparent\" WIDTH=\"$l_size_width\" HEIGHT=\"$l_size_height\">";
  echo "<NOEMBED><a href=\"http://www.macromedia.com/go/getflashplayer/\">Get Flash!</a></NOEMBED></EMBED><br /><a href=\"$l_image\">Right click save as...</a></td>";
   } else {
  echo "<a href=\"$nukeurl\" target=\"_blank\"><img border=\"0\" src=\"$l_image\" alt=\"$l_mouseover\" title=\"$l_mouseover\"></a></td>\n";
   }
  echo "</tr></table><br /><br />"
	."<form action=\"".ADMIN_OP."linktous_config\" method=\"post\" enctype=\"multipart/form-data\">"
	."<input type=\"hidden\" name=\"op\" value=\"zipsetsave\">";
  echo "<input type='hidden' name='old_l_zipurl' value='$l_zipurl'>"; 
  echo "<input type=\"hidden\" name=\"l_id\" value=\"$l_id\">"
	."<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
	."<tr><td width=\40%\">"._MYLINKSIMAGEHTML.":</td><td width=\60%\">";
   if ($ext == ".swf") {
  echo "<textarea rows=4 cols=70><EMBED SRC='$nukeurl/$l_image' wmode='transparent' WIDTH='$l_size_width' HEIGHT='$l_size_height'>";
  echo "<NOEMBED><a href='http://www.macromedia.com/go/getflashplayer/'>Get Flash!</a></NOEMBED></EMBED></textarea></td></tr>\n";
   } else {
  echo "<textarea rows=4 cols=70><a href='$nukeurl' target='_blank'><img src='$nukeurl/$l_image' border='0' alt='$l_mouseover' width='$l_size_width' height='$l_size_height'></a></textarea></td></tr>";
  }
  echo "<tr><td width=\40%\">"._MYLINKSZIPUPLOAD.":</td><td width=\60%\"><input type=\"file\" name=\"new_l_zipurl\" size=\"31\"><br />$l_zipurl</td></tr>";
  echo "</table><br />"                                                                                                                                           
	."<input type=\"submit\" value=Update> "._GOBACK.""
	."</form></center>";
   
    CloseTable();
    
    include("footer.php");
 }
}

function zipsetsave($l_id, $l_zipurl, $old_l_zipurl, $new_l_zipurl) 
{
    global $module_name, $prefix, $db, $sitename, $czlset;
    $site = strtolower("$sitename");  
    $l_id = intval($l_id);
        $zipurl = $_FILES['new_l_zipurl']['name'];
        $zipurl_temp = $_FILES['new_l_zipurl']['tmp_name'];
        //$ext = strrchr($_FILES['new_l_zipurl']['name'], '.');
        if ($zipurl != "") {

             $ext = substr($zipurl, strrpos($zipurl,'.'), 5);
             if (move_uploaded_file($zipurl_temp, "$czlset[zippath]/$site$l_id$ext")) {

                chmod ("$czlset[zippath]/$site$l_id$ext", 0755);
                $l_zipurl = "$czlset[zippath]/$site$l_id$ext";
             } else {

                echo "<br><br>"._NOTHINGUPLOADEDZIP."<br>\n";
                echo ""._GOBACK."";
                die(); 
            }
     
         } else {
        $l_zipurl = "$old_l_zipurl";
       }
    $db->sql_query("update ".$prefix."_linktous set l_zipurl='$l_zipurl' where l_id='$l_id'");
    header("Location: ".ADMIN_OP."mylinks");
}

function linktous_config(){
	global $module_name,  $bgcolor2, $db, $prefix, $sitename, $textcolor1, $sitename;
	include("header.php");
    lmenu();
	OpenTable();
	$czlconf = array();
	$sql = "SELECT * FROM ".$prefix."_linktous_config";
	$result = $db->sql_query($sql);
	while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
		$czlconf[$config_name] = $config_value;
	}
	echo "<center><br><br>"._MAINCONFIG."<hr width=550 /><br>\n";
      echo "<table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>\n"
		."<form action='".ADMIN_OP."linktous_config' method='post'>\n"
            ."<tr><td width='40%'>"._PATHTOFILES.":"._PATHTOFILES2."</td><td width='60%'>\n"
		."<input type='text' size='25' name='path' value='$czlconf[path]'></td></tr>\n"
            ."<tr><td width='40%'>"._PATHTOZIPFILES.":"._PATHTOFILES2."</td><td width='60%'>\n"
		."<input type='text' size='25' name='zippath' value='$czlconf[zippath]'></td></tr>\n"
            ."<tr><td width='40%'>"._PATHTORESFILES.":"._PATHTOFILES2."</td><td width='60%'>\n"
		."<input type='text' size='25' name='respath' value='$czlconf[respath]'></td></tr></table>\n";
	echo "<br><br><hr width=550 />"._MYLINKSSET."<hr width=550 /><br>\n";
      echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>\n"
            ."<tr><td width='40%'>"._HOWMANY.":</td><td width='60%'>\n"
            ."<input type='text' size='25' name='blktoshowml' value='$czlconf[blktoshowml]'></td></tr>\n"
		."<tr><td width='40%'>"._ZIPORTEXT.":</td><td width='60%'>\n"
		."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['blkziportext'] == "1"){            
		$sm1 = "CHECKED";
		$sm2 = "";
	} else {
		$sm1 = "";
		$sm2 = "CHECKED";
	}
	echo "<input type='radio' name='blkziportext' value='1' ".$sm1.">&nbsp;"._ZIP."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='blkziportext' value='0' ".$sm2.">&nbsp;"._TEXT."</td></tr>\n";
     if ($czlconf['blkscrollml'] == "0") {
      $siz1 = "selected";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollml'] == "1") {
      $siz1 = "";
      $siz2 = "selected";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollml'] == "2") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "selected";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollml'] == "3") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "selected";
      $siz5 = "";
     } elseif ($czlconf['blkscrollml'] == "4") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "selected";
     }
	echo "<tr><td width='40%'>"._SCROLLDIRECTION.":</td><td width='60%'>\n"
          ."<select name=\"blkscrollml\">";
      echo "<option value='0' $siz1>Off</option>";    
      echo "<option value='1' $siz2>Up</option>";
      echo "<option value='2' $siz3>Down</option>";
      echo "<option value='3' $siz4>Left</option>";
      echo "<option value='4' $siz5>Right</option>";
      echo "</select></td></tr>"
          ."<tr><td width='40%'>"._SCROLLHEIGHT.":</td><td width='60%'>\n"
          ."<input type='text' size='25' name='blkscrheightml' value='$czlconf[blkscrheightml]'></td></tr>\n";
     if ($czlconf['blkscrdelayml'] == "0") {
      $d1 = "selected";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "1") {
      $d1 = "";
      $d2 = "selected";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "2") {
      $d1 = "";
      $d2 = "";
      $d3 = "selected";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "3") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "selected";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "4") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "selected";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "5") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "selected";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "6") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "selected";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "7") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "selected";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "8") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "selected";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayml'] == "9") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "selected";
     }
	echo "<tr><td width='40%'>"._SCROLLDELAY.":</td><td width='60%'>\n"
          ."<select name=\"blkscrdelayml\">"; 
      echo "<option value='0' $d1>10</option>";   
      echo "<option value='1' $d2>20</option>";
      echo "<option value='2' $d3>30</option>";
      echo "<option value='3' $d4>40</option>";
      echo "<option value='4' $d5>50</option>";
      echo "<option value='5' $d6>60</option>";
      echo "<option value='6' $d7>70</option>";
      echo "<option value='7' $d8>80</option>";
      echo "<option value='8' $d9>90</option>";
      echo "<option value='9' $d10>100</option>";
      echo "</select></td></tr>";
     if ($czlconf['blkorderml'] == "0") {
      $sor1 = "selected";
      $sor2 = "";
      $sor3 = "";
     } elseif ($czlconf['blkorderml'] == "1") {
      $sor1 = "";
      $sor2 = "selected";
      $sor3 = "";
     } elseif ($czlconf['blkorderml'] == "2") {
      $sor1 = "";
      $sor2 = "";
      $sor3 = "selected";
     } 
	echo "<tr><td width='40%'>"._SCROLLORDER.":</td><td width='60%'>\n"
          ."<select name=\"blkorderml\">";
      echo "<option value='0' $sor1>Ascending</option>";    
      echo "<option value='1' $sor2>Descending</option>";
      echo "<option value='2' $sor3>Random</option>";
      echo "</select></td></tr>"
            ."<tr><td width='40%'>"._MOUSEROVERALPHA.":</td><td width='60%'>\n"
		."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['blkalphaml'] == "1"){
		$sm11 = "CHECKED";
		$sm22 = "";
	}
	else{
		$sm11 = "";
		$sm22 = "CHECKED";
	}
	echo "<input type='radio' name='blkalphaml' value='1' ".$sm11.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='blkalphaml' value='0' ".$sm22.">&nbsp;"._NO."</td></tr>\n";
      echo "</table>";
      //RESOURCES 
	echo "<br><br><hr width=550 />"._RESOURCESSET."<hr width=550 /><br>\n";
      echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>\n"
		."<tr><td width='40%'>"._ACTIVATERES.":</td><td width='60%'>\n"
		."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['blkactiveres'] == "1"){            
		$sar1 = "CHECKED";
		$sar2 = "";
	} else {
		$sar1 = "";
		$sar2 = "CHECKED";
	}
	echo "<input type='radio' name='blkactiveres' value='1' ".$sar1.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='blkactiveres' value='0' ".$sar2.">&nbsp;"._NO."</td></tr>\n"
            ."<tr><td width='40%'>"._HOWMANY.":</td><td width='60%'>\n"
            ."<input type='text' size='25' name='blktoshowres' value='$czlconf[blktoshowres]'></td></tr>\n";
     if ($czlconf['blkscrollres'] == "0") {
      $siz1 = "selected";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollres'] == "1") {
      $siz1 = "";
      $siz2 = "selected";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollres'] == "2") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "selected";
      $siz4 = "";
      $siz5 = "";
     } elseif ($czlconf['blkscrollres'] == "3") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "selected";
      $siz5 = "";
     } elseif ($czlconf['blkscrollres'] == "4") {
      $siz1 = "";
      $siz2 = "";
      $siz3 = "";
      $siz4 = "";
      $siz5 = "selected";
     }
	echo "<tr><td width='40%'>"._SCROLLDIRECTION.":</td><td width='60%'>\n"
          ."<select name=\"blkscrollres\">";
      echo "<option value='0' $siz1>Off</option>";    
      echo "<option value='1' $siz2>Up</option>";
      echo "<option value='2' $siz3>Down</option>";
      echo "<option value='3' $siz4>Left</option>";
      echo "<option value='4' $siz5>Right</option>";
      echo "</select></td></tr>"
          ."<tr><td width='40%'>"._SCROLLHEIGHT.":</td><td width='60%'>\n"
          ."<input type='text' size='25' name='blkscrheightres' value='$czlconf[blkscrheightres]'></td></tr>\n";
     if ($czlconf['blkscrdelayres'] == "0") {
      $d1 = "selected";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "1") {
      $d1 = "";
      $d2 = "selected";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "2") {
      $d1 = "";
      $d2 = "";
      $d3 = "selected";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "3") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "selected";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "4") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "selected";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "5") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "selected";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "6") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "selected";
      $d8 = "";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "7") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "selected";
      $d9 = "";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "8") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "selected";
      $d10 = "";
     } elseif ($czlconf['blkscrdelayres'] == "9") {
      $d1 = "";
      $d2 = "";
      $d3 = "";
      $d4 = "";
      $d5 = "";
      $d6 = "";
      $d7 = "";
      $d8 = "";
      $d9 = "";
      $d10 = "selected";
     }
	echo "<tr><td width='40%'>"._SCROLLDELAY.":</td><td width='60%'>\n"
          ."<select name=\"blkscrdelayres\">"; 
      echo "<option value='0' $d1>10</option>";   
      echo "<option value='1' $d2>20</option>";
      echo "<option value='2' $d3>30</option>";
      echo "<option value='3' $d4>40</option>";
      echo "<option value='4' $d5>50</option>";
      echo "<option value='5' $d6>60</option>";
      echo "<option value='6' $d7>70</option>";
      echo "<option value='7' $d8>80</option>";
      echo "<option value='8' $d9>90</option>";
      echo "<option value='9' $d10>100</option>";
      echo "</select></td></tr>";
     if ($czlconf['blkorderres'] == "0") {
      $sor1 = "selected";
      $sor2 = "";
      $sor3 = "";
     } elseif ($czlconf['blkorderres'] == "1") {
      $sor1 = "";
      $sor2 = "selected";
      $sor3 = "";
     } elseif ($czlconf['blkorderres'] == "2") {
      $sor1 = "";
      $sor2 = "";
      $sor3 = "selected";
     } 
	echo "<tr><td width='40%'>"._SCROLLORDER.":</td><td width='60%'>\n"
          ."<select name=\"blkorderres\">";
      echo "<option value='0' $sor1>Ascending</option>";    
      echo "<option value='1' $sor2>Descending</option>";
      echo "<option value='2' $sor3>Random</option>";
      echo "</select></td></tr>"
            ."<tr><td width='40%'>"._MOUSEROVERALPHA.":</td><td width='60%'>\n"
		."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['blkalphares'] == "1"){
		$sm11 = "CHECKED";
		$sm22 = "";
	}
	else{
		$sm11 = "";
		$sm22 = "CHECKED";
	}
	echo "<input type='radio' name='blkalphares' value='1' ".$sm11.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='blkalphares' value='0' ".$sm22.">&nbsp;"._NO."</td></tr>\n";
      echo "</table>";
      //MODULE SETTINGS 
	echo "<br><br><hr width=550 />"._MODULESETTINGS."<hr width=550 /><br>\n";
	echo "<br><hr width=550 />"._MYLINKSSET."<hr width=550 /><br>\n";
      echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>\n"
          ."<tr><td width='40%'>"._MOUSEROVERALPHA.":</td><td width='60%'>\n"
	      ."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['modalphaml'] == "1"){
		$smo11 = "CHECKED";
		$smo22 = "";
	}
	else{
		$smo11 = "";
		$smo22 = "CHECKED";
	}
	echo "<input type='radio' name='modalphaml' value='1' ".$smo11.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='modalphaml' value='0' ".$smo22.">&nbsp;"._NO."</td></tr>\n";
     if ($czlconf['modorderbyml'] == "0") {
      $soro1 = "selected";
      $soro2 = "";
      $soro3 = "";
     } elseif ($czlconf['modorderbyml'] == "1") {
      $soro1 = "";
      $soro2 = "selected";
      $soro3 = "";
     } elseif ($czlconf['modorderbyml'] == "2") {
      $soro1 = "";
      $soro2 = "";
      $soro3 = "selected";
     } 
	echo "<tr><td width='40%'>"._SCROLLORDER.":</td><td width='60%'>\n"
          ."<select name=\"modorderbyml\">";
      echo "<option value='0' $soro1>Ascending</option>";    
      echo "<option value='1' $soro2>Descending</option>";
      echo "<option value='2' $soro3>Random</option>";
      echo "</select></td></tr>";
      echo "</table>";
	echo "<br><br><hr width=550 />"._RESOURCESSET."<hr width=550 /><br>\n";
      echo "<center><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>\n"
		."<tr><td width='40%'>"._ACTIVATERES.":</td><td width='60%'>\n"
		."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['modactiveres'] == "1"){            
		$saro1 = "CHECKED";
		$saro2 = "";
	} else {
		$saro1 = "";
		$saro2 = "CHECKED";
	}
	echo "<input type='radio' name='modactiveres' value='1' ".$saro1.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
	    ."<input type='radio' name='modactiveres' value='0' ".$saro2.">&nbsp;"._NO."</td></tr>\n"
          ."<tr><td width='40%'>"._MOUSEROVERALPHA.":</td><td width='60%'>\n"
	    ."&nbsp;&nbsp;&nbsp;\n";
	if($czlconf['modalphares'] == "1"){
		$smoo11 = "CHECKED";
		$smoo22 = "";
	}
	else{
		$smoo11 = "";
		$smoo22 = "CHECKED";
	}
	echo "<input type='radio' name='modalphares' value='1' ".$smoo11.">&nbsp;"._YES."&nbsp;&nbsp;&nbsp;\n"
		."<input type='radio' name='modalphares' value='0' ".$smoo22.">&nbsp;"._NO."</td></tr>\n";
     if ($czlconf['modorderbyres'] == "0") {
      $soroo1 = "selected";
      $soroo2 = "";
      $soroo3 = "";
     } elseif ($czlconf['modorderbyres'] == "1") {
      $soroo1 = "";
      $soroo2 = "selected";
      $soroo3 = "";
     } elseif ($czlconf['modorderbyres'] == "2") {
      $soroo1 = "";
      $soroo2 = "";
      $soroo3 = "selected";
     } 
	echo "<tr><td width='40%'>"._SCROLLORDER.":</td><td width='60%'>\n"
          ."<select name=\"modorderbyres\">";
      echo "<option value='0' $soroo1>Ascending</option>";    
      echo "<option value='1' $soroo2>Descending</option>";
      echo "<option value='2' $soroo3>Random</option>";
      echo "</select></td></tr>";
      echo "</table>";
      echo "<center><br /><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>"
      	."<tr><td width='40%'>"._SUBMIT."</td><td>\n"
		."<input type='hidden' name='op' value='linktousconfigsave'>\n"
		."&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='submit'>\n"
		."&nbsp;&nbsp;&nbsp;<input type='reset' value='Reset'></td></tr>";
      echo "</form></table></center><br />\n";
    CloseTable();
    
    include("footer.php");
}
switch($op) {

    default:
	linktous_config();
   	break;

    case "linktousconfigsave":
    global $module_name, $db, $prefix;
    $newczlconfig = array();
    $newczlconfig['path'] = $path;
    $newczlconfig['zippath'] = $zippath;
    $newczlconfig['respath'] = $respath;
    $newczlconfig['blktoshowml'] = $blktoshowml;
    $newczlconfig['blkziportext'] = $blkziportext;
    $newczlconfig['blkscrollml'] = $blkscrollml;
    $newczlconfig['blkscrheightml'] = $blkscrheightml;
    $newczlconfig['blkscrdelayml'] = $blkscrdelayml;
    $newczlconfig['blkorderml'] = $blkorderml;
    $newczlconfig['blkalphaml'] = $blkalphaml;
    $newczlconfig['blkactiveres'] = $blkactiveres;
    $newczlconfig['blktoshowres'] = $blktoshowres;
    $newczlconfig['blkscrollres'] = $blkscrollres;
    $newczlconfig['blkscrheightres'] = $blkscrheightres;
    $newczlconfig['blkscrdelayres'] = $blkscrdelayres;
    $newczlconfig['blkorderres'] = $blkorderres;
    $newczlconfig['blkalphares'] = $blkalphares;
    $newczlconfig['modalphaml'] = $modalphaml;
    $newczlconfig['modorderbyml'] = $modorderbyml;
    $newczlconfig['modactiveres'] = $modactiveres;
    $newczlconfig['modalphares'] = $modalphares;
    $newczlconfig['modorderbyres'] = $modorderbyres;
if ($blkziportext == "1") {
    $result = $db->sql_query("select l_id from ".$prefix."_linktous where l_zipurl=''");
    list($l_id) = $db->sql_fetchrow($result);
    if ($l_id) {
      include("header.php");
      opentable();
      echo "<center><br /><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='4'>"
      	."<tr><td width='100%'>"._MISSINGZIPS."</td></tr>";
      echo "</table></center><br />\n";
      echo "<center><br /><table width='550' bgcolor='$textcolor1' cellspacing='1' cellpadding='2'>";
    $result = $db->sql_query("select l_id, l_image from ".$prefix."_linktous where l_zipurl=''");
    while (list($l_id, $l_image) = $db->sql_fetchrow($result)) {
      echo "<tr><td nowrap align='left'><a href=\"".ADMIN_OP."zipsetedit&l_id=$l_id\">$l_image</a></td></tr>";
    }
      echo "</table><br><br>"._GOBACK."</center>";
      closetable();
      include("footer.php");
    } else {
    header("Location: ".ADMIN_OP."linktous_config");
    $result = $db->sql_query("SELECT * FROM ".$prefix."_linktous_config");
    while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
    $db->sql_query("UPDATE ".$prefix."_linktous_config SET config_value='".$newczlconfig[$config_name]."' WHERE config_name='".$config_name."'");
  }
    }
} else {
    header("Location: ".ADMIN_OP."linktous_config");
    $result = $db->sql_query("SELECT * FROM ".$prefix."_linktous_config");
    while(list($config_name, $config_value) = $db->sql_fetchrow($result)){
    $db->sql_query("UPDATE ".$prefix."_linktous_config SET config_value='".$newczlconfig[$config_name]."' WHERE config_name='".$config_name."'");
  }
}
    break;



    case "resources":
    resources();
    break;

    case "resswf":
    resswf($r_id, $r_size_width, $r_size_height);
    break;

    case "resswfadd":
    resswfadd($r_id, $r_size_width, $r_size_height);
    break;

    case "resadd":
    resadd($r_id, $r_name, $r_url, $r_image, $r_status, $r_size_width, $r_size_height);
    break;


    case "resdel":
    resdel($r_id, $ok);
    break;

    case "resedit":
    resedit($r_id);
    break; 

    case "ressave":
    ressave($r_id, $r_name, $r_url, $r_image, $r_status, $old_image, $new_image, $r_size_width, $r_size_height, $new_size_width, $new_size_height, $old_image_width, $old_image_height);
    break;

    case "mylinks":
    mylinks();
    break;

    case "mylinksadd":
    mylinksadd($l_zipurl, $l_image, $l_mouseover, $l_status, $l_size_width, $l_size_height);
    break;

    case "mylinksswf":
    mylinksswf($l_id, $l_size_width, $l_size_height);
    break;

    case "mylinksswfadd":
    mylinksswfadd($l_id, $l_size_width, $l_size_height);
    break;

    case "mylinksdel":
    mylinksdel($l_id, $ok);
    break;

    case "mylinksedit":
    mylinksedit($l_id);
    break; 

    case "mylinkssave":
    mylinkssave($l_id, $l_zipurl, $l_image, $l_mouseover, $l_status, $old_image, $new_image, $l_size_width, $l_size_height, $new_size_width, $new_size_height, $old_image_width, $old_image_height);
    break;

    case "zipset":
    zipset($l_id);
    break;

    case "zipsetadd":
    zipsetadd($l_id, $l_zipurl);
    break;

    case "zipsetedit":
    zipsetedit($l_id);
    break; 

    case "zipsetsave":
    zipsetsave($l_id, $l_zipurl, $old_l_zipurl, $new_l_zipurl);
    break;

    case "linktous_install":
    linktous_install();
    break;

    case "linktousconfigsave":
    linktousconfigsave();
    break;
  }

} else {
    echo "Access Denied";
}

?>