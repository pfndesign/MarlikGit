<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _DOWNLOADSADMIN.": "._DOWNLOADSWAITINGVAL;
@include("header.php");
$result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_new ORDER BY lid");
$numrows = $db->sql_numrows($result);
DLadminmain();
echo "<br>\n";
title("$pagetitle ($numrows)");

if ($numrows>0) {
	
    OpenTable();
    
		echo '<table class="widefat comments fixed">
   			<thead>';
		
		echo "		<tr>";
		echo "		<th scope='col' >"._TITLE."</th>\n";
		echo "		<th scope='col'>"._SUBIP."</th>\n";
		echo "		<th scope='col' >"._SUBMITTER."</th>\n";
		echo "		<th scope='col'>"._URL."</th>\n";
		echo "		<th scope='col'>"._CATEGORY."</th>\n";
		echo "		<th scope='col'>"._OPTIONS."</th>\n";
		echo "	
		</tr>
		</thead>";
		echo "      <tfoot>";
		echo "		<tr>";
		echo "		<th scope='col' >"._TITLE."</th>\n";
		echo "		<th scope='col'>"._SUBIP."</th>\n";
		echo "		<th scope='col' >"._SUBMITTER."</th>\n";
		echo "		<th scope='col'>"._URL."</th>\n";
		echo "		<th scope='col'>"._CATEGORY."</th>\n";
		echo "		<th scope='col'>"._OPTIONS."</th>\n";
		echo "		</tr>
		</tfoot>";
		echo "<tbody>\n";
		
  while($lidinfo = $db->sql_fetchrow($result)) {
    if ($lidinfo['submitter'] == "") { $lidinfo['submitter'] = $anonymous; }
    $lidinfo['homepage'] = str_replace("http://","",$lidinfo['homepage']);
    if ($lidinfo['homepage'] != "") { $lidinfo['homepage'] = "http://".$lidinfo['homepage']; }
		
    echo "<tr><td>".$lidinfo['title']." </td>\n";
    echo "<td><b>".$lidinfo['submitter']."</b></td>\n";
    echo "<td><b>".$lidinfo['sub_ip']."</b></td>\n";
    echo "<td><a href='".$lidinfo['url']."' target='_blank'><img src='images/icon/world.png'></a></td>\n";
    echo "<td><select name='cat'><option value='0'";
    if ($lidinfo['cid'] == 0) { echo " selected"; }
    echo ">"._DL_NONE."</option>\n";
    $result2 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories ORDER BY parentid,title");
    while($cidinfo = $db->sql_fetchrow($result2)) {
      if ($cidinfo['cid'] == $lidinfo['cid']) { $sel = "selected"; } else { $sel = ""; }
      if ($cidinfo['parentid'] != 0) $cidinfo['title'] = getparent($cidinfo['parentid'], $cidinfo['title']);
      echo "<option value='".$cidinfo['cid']."' $sel>".$cidinfo['title']."</option>\n";
    }
    echo "</select></td>\n";   
    echo "<td>
    <a href='".$admin_file.".php?op=DownloadNew&action=EditNewDownload&lid=".$lidinfo['lid']."'><img src='images/icon/tick.png' title='تایید' alt='تایید'></a>
    <a href='".$admin_file.".php?op=DownloadNewDelete&lid=".$lidinfo['lid']."'><img src='images/icon/delete.png' title='"._DELETEDOWNLOAD." ' alt='"._DELETEDOWNLOAD." '></a>
    
    </td>\n";
    $sel1 = $sel2 = $sel3 = "";
  }
  
    echo "</tr></tbody></table>\n";
    echo "<br>\n";
    
} else {
  echo "<b>"._DNODOWNLOADSWAITINGVAL."<b>\n";
}
CloseTable();

if ($_GET['action'] == "EditNewDownload") {
OpenTable();
$result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_new WHERE lid='".$_GET['lid']."'");
$numrows = $db->sql_numrows($result);
if ($numrows>0) {
	$lidinfo = $db->sql_fetchrow($result);
    if ($lidinfo['submitter'] == "") { $lidinfo['submitter'] = $anonymous; }
    $lidinfo['homepage'] = str_replace("http://","",$lidinfo['homepage']);
    if ($lidinfo['homepage'] != "") { $lidinfo['homepage'] = "http://".$lidinfo['homepage']; }

    echo "<table align='center' cellpadding='2' cellspacing='2' border='0'>\n";
    echo "<form action='".$admin_file.".php' method='post'>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._SUBMITTER.":</td><td><b>".$lidinfo['submitter']."</b></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._SUBIP.":</td><td><b>".$lidinfo['sub_ip']."</b></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._TITLE.":</td><td><input type='text' name='title' value='".$lidinfo['title']."' size='50' maxlength='100' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(title)> </td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._URL.":</td><td><input type='text' name='url' dir='ltr' value='".$lidinfo['url']."' size='50' maxlength='100'>&nbsp;[ <a href='".$lidinfo['url']."' target='_blank'>"._CHECK."</a> ]</td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._CATEGORY.":</td><td><select name='cat'><option value='0'";
    if ($lidinfo['cid'] == 0) { echo " selected"; }
    echo ">"._DL_NONE."</option>\n";
    $result2 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories ORDER BY parentid,title");
    while($cidinfo = $db->sql_fetchrow($result2)) {
      if ($cidinfo['cid'] == $lidinfo['cid']) { $sel = "selected"; } else { $sel = ""; }
      if ($cidinfo['parentid'] != 0) $cidinfo['title'] = getparent($cidinfo['parentid'], $cidinfo['title']);
      echo "<option value='".$cidinfo['cid']."' $sel>".$cidinfo['title']."</option>\n";
    }

    echo "</select></td></tr>\n";
    $sel1 = $sel2 = $sel3 = "";
    if ($lidinfo['sid'] == 0) { $sel1 = " selected"; } elseif ($lidinfo['sid'] == 1) { $sel2 = " selected"; } elseif ($lidinfo['sid'] == 2) { $sel3 = " selected"; }
    echo "<tr><td bgcolor='$bgcolor2'>"._DL_PERM.":</td><td><select name='perm'>\n";
    echo "<option value='0'$sel1>"._DL_ALL."</option>\n";
    echo "<option value='1'$sel2>"._DL_USERS."</option>\n";
    echo "<option value='2'$sel3>"._DL_ADMIN."</option>\n";
    $gresult = $db->sql_query("SELECT * FROM ".$prefix."_nsngr_groups ORDER BY gname");
    while($gidinfo = $db->sql_fetchrow($gresult)) {
      $gidinfo['gid'] = $gidinfo['gid'] + 2;
      if ($gidinfo['gid'] == $lidinfo['sid']) { $selected = " SELECTED"; } else { $selected = ""; }
      echo "<option value='".$gidinfo['gid']."'$selected>".$gidinfo['gname']." "._DL_ONLY."</option>\n";
    }
    echo "</select></td></tr>\n";
   echo "<tr><td bgcolor='$bgcolor2' valign='top'>"._DESCRIPTION.":</td><td>";
    
   wysiwyg_textarea('description', "".$lidinfo['description']."", 'PHPNukeAdmin', 50, 8);
   //<textarea name='description' cols='60' rows='10'>".$lidinfo['description']."</textarea>
   
    echo "</td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._AUTHORNAME.":</td><td><input type='text' name='sname' size='20' maxlength='100' value='".$lidinfo['name']."' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(sname)></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._AUTHOREMAIL.":</td><td><input type='text' dir='ltr' name='email' size='20' maxlength='100' value='".$lidinfo['email']."'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._FILESIZE.":</td><td><input type='text' dir='ltr' name='filesize' size='12' maxlength='20' value='".$lidinfo['filesize']."'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._VERSION.":</td><td><input type='text' dir='ltr' name='version' size='11' maxlength='20' value='".$lidinfo['version']."'></td></tr>\n";
    echo "<tr><td bgcolor='$bgcolor2'>"._HOMEPAGE.":</td><td><input type='text' dir='ltr' name='homepage' size='30' maxlength='255' value='".$lidinfo['homepage']."'> [ <a href='".$lidinfo['homepage']."' target='_blank'>"._VISIT."</a> ]</td></tr>\n";
    
// USV Build 3 -- Source and Password for Downloads by Hamed -- Begin 24/09/09
echo '<tr><td bgcolor="',$bgcolor2,'">',_PASSWORD,':</td><td><input type="text" dir="ltr" name="password" size="12" value="" /></td></tr>';
echo '<tr><td bgcolor="',$bgcolor2,'">',_SOURCE,':</td><td><input type="text" dir="ltr" name="source" size="50" value="http://" /></td></tr>';
echo '<tr><td bgcolor="',$bgcolor2,'"></td><td>';
echo $tag->input_tags("tags");
echo '</td></tr>';

    echo "<input type='hidden' name='sub_ip' value='".$lidinfo['sub_ip']."'>\n";
    echo "<input type='hidden' name='new' value='1'>\n";
    echo "<input type='hidden' name='hits' value='0'>\n";
    echo "<input type='hidden' name='lid' value='".$lidinfo['lid']."'>\n";
    echo "<input type='hidden' name='submitter' value='".$lidinfo['submitter']."'>\n";
    echo "<input type='hidden' name='op' value='DownloadAddSave'>\n";
    echo "<input type='hidden' name='xop' value='$op'>\n";
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._ADDDOWNLOAD."'></td></tr>\n";
    echo "</form>\n";
    echo "<form action='".$admin_file.".php' method='post'>\n";
    echo "<input type='hidden' name='lid' value='".$lidinfo['lid']."'>\n";
    echo "<input type='hidden' name='op' value='DownloadNewDelete'>\n";
    echo "<tr><td align='center' colspan='2'><input type='submit' value='"._DELETEDOWNLOAD."'></td></tr>\n";
    echo "</form>\n";
    echo "</table>\n";
    CloseTable();
    echo "<br>\n";
}
}




@include("footer.php");

?>