<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _DOWNLOADSADMIN.": "._ADDDOWNLOAD;

include("header.php");
title($pagetitle);
DLadminmain();
echo "<br>\n";
OpenTable();
echo "<table align='center' cellpadding='2' cellspacing='2' border='0'>\n";
echo "<form action='".$admin_file.".php' method='post'>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._TITLE.":</td><td><input type='text' name='title' size='50' maxlength='100' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(title)></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._URL.":</td><td><input type='text' dir='ltr' name='url' size='50' maxlength='255' value='http://'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._CATEGORY.":</td><td><select name='cat'><option value='0'>"._DL_NONE."</option>\n";
$result2 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories ORDER BY parentid,title");
while($cidinfo = $db->sql_fetchrow($result2)) {
  if ($cidinfo['parentid'] != 0) $cidinfo['title'] = getparent($cidinfo['parentid'],$cidinfo['title']);
  echo "<option value='".$cidinfo['cid']."'>".$cidinfo['title']."</option>\n";
}
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._DL_PERM.":</td><td><select name='perm'>\n";
echo "<option value='0'>"._DL_ALL."</option>\n";
echo "<option value='1'>"._DL_USERS."</option>\n";
echo "<option value='2'>"._DL_ADMIN."</option>\n";
echo "<option value='3'>"._DL_SUBSC."</option>\n";
$gresult = $db->sql_query("SELECT * FROM ".$prefix."_nsngr_groups ORDER BY gname");
while($gidinfo = $db->sql_fetchrow($gresult)) {
  $gidinfo['gid'] = $gidinfo['gid'] + 2;
  echo "<option value='".$gidinfo['gid']."'>".$gidinfo['gname']." "._DL_ONLY."</option>\n";
}
echo "</select></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2' valign='top'>"._DESCRIPTION."</td><td>"; 

wysiwyg_textarea("description", "", "PHPNukeAdmin", "70", "10");
//<textarea name='description' cols='50' rows='5'></textarea><br><IMG src=\"images/fa.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(description)>
echo"</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._AUTHORNAME.":</td><td><input type='text' name='sname' size='30' maxlength='60' onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this);> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(sname)></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._AUTHOREMAIL.":</td><td><input type='text' dir='ltr' name='email' size='30' maxlength='60'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._FILESIZE.":</td><td><input type='text' dir='ltr' name='filesize' size='12' maxlength='20'> ("._INBYTES.")</td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._VERSION.":</td><td><input type='text' dir='ltr' name='version' size='11' maxlength='20'></td></tr>\n";
echo "<tr><td bgcolor='$bgcolor2'>"._HOMEPAGE.":</td><td><input type='text' dir='ltr' name='homepage' size='50' maxlength='255' value='http://'></td></tr>\n";
// USV Build 3 -- Source and Password for Downloads by Hamed -- Begin 24/09/09
echo '<tr><td bgcolor="',$bgcolor2,'">',_PASSWORD,':</td><td><input type="text" dir="ltr" name="password" size="12" value="" /></td></tr>';
echo '<tr><td bgcolor="',$bgcolor2,'">',_SOURCE,':</td><td><input type="text" dir="ltr" name="source" size="50" value="http://" /></td></tr>';
// USV Build 3 -- Source and Password for Downloads by Hamed -- End
// USV Build 3 -- Tags for Downloads by Hamed -- Begin Saturday, October 03 2009
echo '<tr><td bgcolor="',$bgcolor2,'">'._TAGS.'</td><td>';
echo $tag->input_tags("tags");
echo '</td></tr>';

// USV Build 3 -- Tags for Downloads by Hamed -- End
echo "<tr><td bgcolor='$bgcolor2'>"._HITS.":</td><td><input type='text' name='hits' size='12' maxlength='11'></td></tr>\n";
echo "<input type='hidden' name='op' value='DownloadAddSave'>\n";
echo "<input type='hidden' name='new' value='0'>\n";
echo "<input type='hidden' name='lid' value='0'>\n";
echo "<tr><td align='center' colspan='2'><input type='submit' value='"._ADDDOWNLOAD."'></td></tr>\n";
echo "</form>\n</table>\n";
CloseTable();
@include("footer.php");

?>