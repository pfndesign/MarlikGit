<?php
/**
*
* @package Downloads Showroom														
* @version $Id: Showroom.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
//if (!empty(sql_quote(intval($cid)))) { 

global $min,$max,$dl_config,$orderby;

if (!$min) $min=0;
if (!$max) $max=$min+$dl_config['perpage'];
if($orderby) { $orderby = convertorderbyin($orderby); } else { $orderby = "date DESC"; }

$cidinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".DOWNLOAD_CAT_TABLE." WHERE cid=$cid AND active>'0'"));
list($hit_num) =$db->sql_fetchrow($db->sql_query("SELECT SUM(hits) FROM ".DOWNLOAD_TABLE." WHERE cid='$cid'"));
list($dl_num) =$db->sql_fetchrow($db->sql_query("SELECT SUM(cid) FROM ".DOWNLOAD_TABLE." WHERE cid='$cid'"));

$dl_title = (!empty($cidinfo['title']) ? $cidinfo['title'] : _MAIN);
if ($dl_num>0) {
 echo " <h3 style='color:#888888;font-weight:none;text-align:center;'><b>".intval($dl_num)." " ._FILEIN."</b> ".$dl_title.", <b>".intval($hit_num)."</b> "._DOWNLOADS_CAT_STAT."</h3><br>";
 }
 
if ($cid == 0) {
  menu(0);
  $title = ""._MAIN."";
} else {
  menu(1);
  $title = getparentlink($cidinfo['parentid'], $cidinfo['title']);
  $title = "<a href=modules.php?name=$module_name>"._MAIN."</a> -&gt; $title";
}

echo "<br><br><span>"._CATEGORY.": $title<span><br>";
$listrows = $db->sql_numrows($db->sql_query("SELECT * FROM  ".DOWNLOAD_TABLE." WHERE active>'0' AND cid='$cid'"));
if ($listrows > 0) {
  $op = $query = "";
  $orderbyTrans = convertorderbytrans($orderby);
  
  $totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM  ".DOWNLOAD_TABLE." WHERE active='1' AND cid=$cid"));
  pagenums($cid, $query, $orderby, $op, $totalselected, $dl_config['perpage'], $max);

  // START LISTING
  $x = 0;
  $a = 0;
  
echo  _RESSORTED.": $orderbyTrans
<span style='position:relative;float:left'>
		"._TITLE."<a href='modules.php?name=$module_name&amp;cid=$cid&amp;orderby=titleA'><img src='images/up.gif' ></a>
		<a href='modules.php?name=$module_name&amp;cid=$cid&amp;orderby=titleD'><img src='images/down.gif'></a>
|
		"._DATE."<a href='modules.php?name=$module_name&amp;cid=$cid&amp;orderby=dateA'><img src='images/up.gif' ></a>
		<a href='modules.php?name=$module_name&amp;cid=$cid&amp;orderby=dateD'><img src='images/down.gif'></a>
</span>";
		
  $result=$db->sql_query("SELECT lid FROM  ".DOWNLOAD_TABLE." WHERE active>'0' AND cid=$cid ORDER BY $orderby LIMIT $min,".$dl_config['perpage']);


  echo "<div style='width:100%'><hr>";
  
  while(list($lid)=$db->sql_fetchrow($result)) {

showlisting($lid);

  }
  
  // END LISTING
  $orderby = convertorderbyout($orderby);
  pagenums($cid, $query, $orderby, $op, $totalselected, $dl_config['perpage'], $max);

  echo "</div>";
}


/*
}else {
	show_error(HACKING_ATTEMPT);
}

*/
?>