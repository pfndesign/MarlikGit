<?php
/**
*
* @package Downloads														
* @version $Id: getit.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
@include("header.php");

if (!isset($min)) $min=0;
if (!isset($max)) $max=$min+$dl_config['perpage'];
if(isset($orderby)) { $orderby = convertorderbyin($orderby); } else { $orderby = "title ASC"; }
if (!isset($cid)) { $cid = 0; }$cid = sql_quote(intval($cid));
$cidinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".DOWNLOAD_CAT_TABLE." WHERE cid=$cid AND active>'0'"));
echo "<h3 style='padding:10px;'><img src='images/icon/folder_go.png'>"._DIRECTORY." >> ".showroom_title($cid)."</h3>
<br> ".$cidinfo['cdescription']."";


echo "<table style='width:99%;'><tr>
<td width='20%' valign='top'>";
OpenTable();
menu_cats();
CloseTable();
if (!empty($cid)) {
menu_tags();
}
if (empty($cid)) {
echo '</td><td width="80%">';	

//searchbox
OpenTable();
SearchForm();
CloseTable();

// show all cats and their description
OpenTable();
cats_desc();
CloseTable();

//show uncategorized files 
OpenTable();
showroom($cid,$min,$max,$orderby);
CloseTable();

}else {
echo '</td><td width="60%" valign="top">';		
showroom($cid,$min,$max,$orderby);
echo '</td><td width="20%" valign="top">';	
showroom_block($cid,'date');
showroom_block($cid,'hits');
}

echo '</td></tr></table>';

@include("footer.php");



?>