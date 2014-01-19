<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/

	$tagSlug = sql_quote(Slugit($term));	
	list($tid) = $db->sql_fetchrow($db->sql_query("SELECT tid FROM ".TAGS_TABLE." where `slug`='$tagSlug' LIMIT 1"));
	if (empty($tid)) {
	show_error("شناسه تگ شما در بانک اطلاعاتی این سایت وجود ندارد<br>
	شناسه : <b>".Deslug($tagSlug)."</b>
	");
	}
	

include("header.php");
global  $dl_config;
if (!isset($min)) $min=0;
if (!isset($max)) $max=$min+$dl_config['perpage'];
if(isset($orderby)) { $orderby = convertorderbyin($orderby); } else { $orderby = "title ASC"; }


if (!isset($cid)) { $cid = 0; }
$cid = intval($cid);

echo "<br>";echo "<table style='width:100%;text-align:right;vertical-align:top;'><tr><td width='25%' valign='top'>";
      
OpenTable();
menu_cats();
CloseTable();
OpenTable();
SearchForm();
CloseTable();
menu_tags();

echo '</td><td width="70%"  valign="top">';	
$result=$db->sql_query("SELECT lid FROM ".$prefix."_nsngd_downloads WHERE active>'0' AND  FIND_IN_SET($tid, REPLACE(tags, ' ', ',')) ORDER BY $orderby LIMIT $min,".$dl_config['perpage']);
$listrows = $db->sql_numrows($result);
if ($listrows > 0) {
  $op = "tags";
  $orderbyTrans = convertorderbytrans($orderby);

  $totalselected = $db->sql_numrows($db->sql_query("SELECT lid FROM ".$prefix."_nsngd_downloads WHERE active>'0' AND  FIND_IN_SET($tid, REPLACE(tags, ' ', ','))"));
  pagenums($cid, $query, $orderby, $op, $totalselected, $dl_config['perpage'], $max,$tagSlug);
  // START LISTING
  $x = 0;
  $a = 0;
  while(list($lid)=$db->sql_fetchrow($result)) {
OpenTable();
showlisting($lid);
CloseTable();
  }
  // END LISTING
  $orderby = convertorderbyout($orderby);
  pagenums($cid, $query, $orderby, $op, $totalselected, $dl_config['perpage'], $max,$tagSlug);
  
}else {
	OpenTable();
	echo "<center><img src='images/alert.gif'><br><br>
	فایلی با کلید واژه مورد نظر شما یافت نشد<br>
	</center>"._GOBACK."";
	CloseTable();
}
echo '</td></tr></table>';
include("footer.php");

?>