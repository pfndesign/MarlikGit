<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/


@include("header.php");
DLadminmain();
echo "<br>\n";
OpenTable();
$perpage = $dl_config['perpage'];
if (!isset($min)) $min=0;
if (!isset($max)) $max=$min+$perpage;
$totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads"));
pagenums_admin($op, $totalselected, $perpage, $max);
		
		echo "<h2 style='text-align:center'>" . _DOWNLOADSLIST . "</h2><br>";

		echo '<table id="gradient-style" summary="Meeting Results"><thead>';
		echo "		<tr>\n";
		echo "		<th scope='col'>"._TITLE."</th>\n";
		echo "		<th scope='col' >"._FILESIZE."</th>\n";
		echo "		<th scope='col'>"._ADDED."</th>\n";
		echo "		<th scope='col'>"._FUNCTIONS."</th>\n";
		echo "		</tr></thead><tbody>\n";
$x = 0;
$result = $db->sql_query("SELECT * FROM $prefix"._nsngd_downloads." ORDER BY lid DESC LIMIT $min,$perpage");
while($lidinfo = $db->sql_fetchrow($result)) {
  echo "<tr><form method='post' action='".$admin_file.".php'>\n";
  echo "<input type='hidden' name='min' value='$min'>\n";
  echo "<input type='hidden' name='lid' value='".$lidinfo['lid']."'>\n";
  echo "<td align='center'>".$lidinfo['title']."</td>\n";
  echo "<td align='center'>".CoolSize($lidinfo['filesize'])."</td>\n";
  $mydate = $lidinfo['date'];
  $date = explode(" ", $mydate);
  echo "<td align='center'>" . hejridate($date[0], 1) . "</td>\n";
  echo "<td align='center'><select name='op'><option value='DownloadModify' selected>"._MODIFY."</option>\n";
  if ($lidinfo['active'] ==1) {
    echo "<option value='DownloadDeactivate'>"._DL_DEACTIVATE."</option>\n";
  } else {
    echo "<option value='DownloadActivate'>"._DL_ACTIVATE."</option>\n";
  }
  echo "<option value='DownloadDelete'>"._DL_DELETE."</option></select> ";
  echo "<input type='submit' value='"._DL_OK."'></td></tr>\n";
  echo "</form></tr>\n";
  $x++;
}
echo "</table>\n";
pagenums_admin($op, $totalselected, $perpage, $max);
CloseTable();
@include("footer.php");

?>