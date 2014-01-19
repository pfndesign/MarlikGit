<?php
/**
*
* @package Tigris 1.1.4														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $ JAMES					
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/


if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
global $currentlang;
require_once("language/Points/lang-$currentlang.php");
function main_menu(){

?>
	<style type="text/css">
<!--

#subscribe {
	list-style: none;
	margin: 0px;
}
#subscribe li {
	padding: 10px;
	position: relative;
	margin-top: 0;
	margin-right: 0;
	margin-bottom: 5px;
	margin-left: 0;
	height: 64px;

}

#subscribe li:hover {
	background-color: #FFF39D;
}

#subscribe li img {
	float: left;
	position: relative;
	padding: 0px;
	margin: 0px 10px 0px 0px;
}

#subscribe li h4 {
	margin: 0 0 5px 45px;
	font-size: 24px;
	line-height: 26px;
	color: #333333;
	font-family: Helvetica, Arial, sans-serif;
	font-weight: bold;
	clear: none;
}

#subscribe li p {
	margin: 0 0 0 45px;
	font-size: 13px;
	letter-spacing: -0.02em;
	clear: none;
}

#subscribe li a.linkblock {
	background: none;
	border: none;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 100%;
	position: absolute;
	z-index: 50;
}
.active li p {
	background-color: #FFCC00;
}
-->
</style>
<div id="content">

    <ul id="subscribe">
      <li> 
        <a class="linkblock" href="<?php echo ADMIN_OP ?>Points&act=pman"></a> 
        <img src="images/topics/Groups.png" alt="<?php echo _POINTS_MAN ?>" />
        <h3 ><?php echo _POINTS_MAN ?></h3>
        </a>

      </li>
      <li> 
        <a class="linkblock" href="<?php echo ADMIN_OP ?>Points&act=gman">
        <img src="images/topics/AllTopics.gif" alt="<?php echo _GROUPS_MAN ?>">
        <h3 <?php echo $active1 ?>><?php echo _GROUPS_MAN ?></h3>
        </a> 
      </li>
    </ul>

</div>
<hr>
	<?php
	}
function gr_man(){
	global $db,$prefix;
	$sql = 'SELECT * FROM `'.$prefix.'_groups` ORDER BY `id` ASC';
	$result = $db->sql_query($sql);
	if ($db->sql_numrows($result) > 0) {
		
?> 
<link rel="stylesheet" href="modules/Your_Account/includes/style/colors/farbtastic.css" type="text/css" />
 <script type="text/javascript" src="modules/Your_Account/includes/style/colors/farbtastic.js"></script>
 <script type="text/javascript">
$(document).ready(function(){var b=$.farbtastic("#picker");var c=$("#picker").css("opacity",0.25);var a;$(".colorwell").each(function(){b.linkTo(this);$(this).css("opacity",0.75)}).focus(function(){if(a){$(a).css("opacity",0.75).removeClass("colorwell-selected")}b.linkTo(this);c.css("opacity",1);$(a=this).css("opacity",1).addClass("colorwell-selected")});
});
 </script>
<?php
echo'<table class="widefat">
	<thead><tr>
       <th scope="col" width="5%">'. _GID .'</th>
		<th scope="col">'._GNAME.'</th>
			<th scope="col">'._GDESC.'</th>';
				/*
				<th scope="col">'._GPOSTS.'</th>
				<th scope="col">'._GPOSTS_MAX.'</th>
				*/
				echo'<th scope="col">'._GPOINTS.'</th>
					<th scope="col">'._GPOINTS_MAX.'</th>
						<th scope="col">'._GOPTS.'</th></tr></thead>
					</thead>
    <tbody>';	   
	
	while($row = $db->sql_fetchrow($result)){
		echo '<tr>';
		echo '<td>',$row['id'],'</td>';
		echo '<td><a style="color:'.$row['color'].'" href="'.ADMIN_OP.'Points&act=grp_edt&gid=',$row['id'],'"><b>',langit($row['name']),'</b></a></td>';
		echo '<td>',$row['description'],'</td>';
		/*echo '<td>',$row['post_min'],'</td>';
		echo '<td>',$row['post_max'],'</td>';
		*/
		echo '<td>',$row['point_min'],'</td>';
		echo '<td>',$row['point_max'],'</td>';
		echo '<td>
		<a href=\''.ADMIN_OP.'Points&act=grp_edt&gid=',$row['id'],'\'" class="button">
		<img src="images/icon/tab_edit.png" title="'._EDIT.'" alt="'._EDIT.'">',_EDIT,'</a> | 
		<a href=\''.ADMIN_OP.'Points&act=pman&gid='.$row['id'].'&type=normal\'" class="button">
		<img src="images/icon/world_edit.png" title="'._EDIT_POINTS.'" alt="'._EDIT_POINTS.'">',_EDIT_POINTS,'</a>
		<a href=\''.ADMIN_OP.'Points&act=grp_edt&gid='.$row['id'].'\'" class="button">
		<img src="images/icon/cross.png" title="'._GREM.'" alt="'._GREM.'"> ',_GREM,'</a>
		</td>';
		echo '</tr>';
		}
		echo '</table><br>';
		
	}

	echo '<HR><table><tr><td style="vertical-align:top;width:50%;"><form method="post" action="'.ADMIN_OP.'Points&act=add_grp">';
	echo '<h2>'._GADD.' </h2>';
	echo _GNAME,':  <br><input type="text" name="gname">'._LANGIT.'<br /><br />';
	echo _GDESC,': <br><textarea name="gdesc" rows="5" cols="50"></textarea><br /><br />';
	echo _GPOINTS,':  <br><input type="text" name="gpoints"><br /><br />';
	echo _GPOINTS_MAX,':  <br><input type="text" name="gpoints_max"><br /><br />';
	/*
	echo _GPOSTS,':  <br><input type="text" name="gposts"><br /><br />';
	echo _GPOSTS_MAX,':  <br><input type="text" name="gposts_max"><br /><br />';
	*/
	echo _GCOLOR,':  <br><input type="text" id="gcolor" name="gcolor" class="colorwell" value="#000000"><br /><br />';

	echo '<input type="submit" value="',_SUBMIT,'">';
	echo '</form>';
	echo '</td><td style="vertical-align:top;width:50%;line-height:30px;">'._GROUP_GUIDE.'<br>
	<div id="picker"></div>
	</td></tr></table>';
	}
function add_grp(){
	global $db,$prefix;
	$gname = $_POST['gname'];
	$gdesc = $_POST['gdesc'];
	$gpoints = (int) $_POST['gpoints'];
	$gpoints_max = (int) $_POST['gpoints_max'];
	$gposts = (int) $_POST['gposts'];
	$gposts_max = (int) $_POST['gposts_max'];
	$gcolor = $_POST['gcolor'];

	if($gname == ''){
	echo _NAME_EMPTY;
	return 0;
	}
	$sql = 'INSERT INTO `'.$prefix.'_groups`  (`name`, `description`, `post_min`, `post_max`,`point_min`,`point_max`,`color`) VALUES ("'.$gname.'","'.$gdesc.'","'.$gposts.'","'.$gposts_max.'","'.$gpoints.'","'.$gpoints_max.'","'.$gcolor.'")';

	$result = $db->sql_query($sql)or die(mysql_error());
	if($result){
	echo _GROUP_ADDED; 
	}else{
	echo "<div class='success'>"._GROUP_NOT_ADDED.' --> '.mysql_error()."</div>";
		}
	}
function group_points(){
	global $db,$prefix;

	
	?>
	<script language="javascript">
   function SendToUrl(e){
       window.location=''+e
    }
</script>
	<?php
	$result1 = $db->sql_query('SELECT `id`,`name` FROM `'.$prefix.'_groups`');
	//$result2 = $db->sql_query('SELECT `group_id`,`group_name` FROM `'.$prefix.'_bb3groups` ORDER BY `group_id` ASC');
	echo '<div style="text-align:center">'._SELECT_GRP.'<br>';
	echo '<form method="post" action="'.ADMIN_OP.'Points&act=upd_pts">';
	echo '<select onchange="window.open(this.options[this.selectedIndex].value,\'_top\')">';
	$i = 0;
	while($row = $db->sql_fetchrow($result1)){
		if($i==0) $default_id = $row['id'];
	if($_REQUEST['gid'] == $row['id']) $selected = 'SELECTED'; else $selected = '';
	echo '<option ',$selected,' value="'.ADMIN_OP.'Points&act=pman&gid='.$row['id'].'&type=normal">'.$row['name'].'</option>';
	$i++;
	}
	/*while($row = $db->sql_fetchrow($result2)){
	if($_REQUEST['gid'] == $row['group_id']) $selected = 'SELECTED'; else $selected = '';
	echo '<option ',$selected,' onclick="window.location=\''.ADMIN_OP.'Points&act=pman&gid='.$row['group_id'].'&type=forum\'">'.$row['group_name'].'</option>';
	}*/
	echo '</select>';
	echo '</div>';
	if(isset($_REQUEST['gid'])){
	$gid = (int) $_REQUEST['gid'];
	}else{$gid = $default_id;}
	if($_REQUEST['type'] == 'forum'){
	$sql = 'SELECT `group_name`,`point_amount` FROM `'.$prefix.'_bb3groups` WHERE `group_id` = \''.$gid.'\' LIMIT 1';
	}else{
	$sql = 'SELECT `name`,`point_amount` FROM `'.$prefix.'_groups` WHERE `id` = \''.$gid.'\' LIMIT 1';
	}
	list($name,$points) = $db->sql_fetchrow($db->sql_query($sql));
	$point = explode("-",$points);
	echo '<br>',_MNG_GRP,': ',$name,'<br>';
	echo '<input name="type" value="',$_REQUEST['type'],'" type="hidden">';
	
echo'<table id="gradient-style" summary="'._POINTSSYSTEM.'">
	<thead><tr>
	<th scope="col" width="5%">'._ID.'</th>
       <th scope="col" width="5%">'. _NAME .'</th>
		<th scope="col">'._DESCRIPTION.'</th>
			<th scope="col">'._POINTS.'</th>
					</thead>
       			 <tfoot>
    			<tr>
    			<td colspan="4"><em><b>'._POINTSSYSTEM.'</b></em></td>
   		     </tr>
   		 </tfoot>
    <tbody>';	   
$i=0;
	echo'<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS01 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC01 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[0].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';

	echo'<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS02 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC02 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[1].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';

	echo'<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS03 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC03 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[2].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS04 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC04 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[3].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS05 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC05 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[4].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS06 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC06 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[5].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS07 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC07 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[6].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS08 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC08 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[7].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS09 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC09 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[8].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS10 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC10 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[9].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS11 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC11 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[10].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS12 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC12 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[11].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS13 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC13 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[12].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS14 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC14 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[13].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS15 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC15 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[14].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS16 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC16 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[15].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS17 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC17 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[16].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS18 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC18 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[17].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS19 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC19 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[18].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS20 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC20 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[19].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>'
	    .'<tr>';
	
	echo '<td>'.++$i.'</td><td align="right" nowrap>&nbsp;'. _POINTS21 .'&nbsp;</td>'
	    .'<td align="right">'. _DESC21 .'</td>'
	    .'<td align="center">&nbsp;<input type="text" value="'.(int) $point[20].'" size="5" name="points[]">&nbsp;</td>'
	    .'</tr>';
	    echo '<tr><td colspan="4" align="center"><input type="submit" value="'._UPDATE.'"></td></tr>';
	    echo '<input type="hidden" name="gid" value="'.$gid.'">';
	echo '</table></form>';
	}
function upd_pts(){
	global $db,$prefix;
	$gid = (int) $_POST['gid'];
	$points = $_POST['points'];
	$m = count($points);
	$point = '';
	for($i=0;$i<$m;$i++){
	if(!$i) $point .= $points[$i];
	else $point .= '-'.$points[$i];
	}
	if($_POST['type'] == 'forum'){
	$sql = 'UPDATE `'.$prefix.'_bb3groups` SET `point_amount` = \''.$point.'\' WHERE `group_id` = \''.$gid.'\'';
	}else{
	$sql = 'UPDATE `'.$prefix.'_groups` SET `point_amount` = \''.$point.'\' WHERE `id` = \''.$gid.'\'';
	}
	if($db->sql_query($sql)) echo _POINTS_UPDATED;
	else echo _POINTS_UPD_FAILED;
	}
function grp_edt(){
	global $db,$prefix;
	$gid = (int) sql_quote($_REQUEST['gid']);
	
?> 
<link rel="stylesheet" href="modules/Your_Account/includes/style/colors/farbtastic.css" type="text/css" />
 <script type="text/javascript" src="modules/Your_Account/includes/style/colors/farbtastic.js"></script>
 <script type="text/javascript">
$(document).ready(function(){$("#demo").hide();var b=$.farbtastic("#picker");var c=$("#picker").css("opacity",0.25);var a;$(".colorwell").each(function(){b.linkTo(this);$(this).css("opacity",0.75)}).focus(function(){if(a){$(a).css("opacity",0.75).removeClass("colorwell-selected")}b.linkTo(this);c.css("opacity",1);$(a=this).css("opacity",1).addClass("colorwell-selected")});
});
 </script>
<?php
	
	list($name,$description,$post_min,$post_max,$point_min,$point_max,$gcolor) = $db->sql_fetchrow($db->sql_query('SELECT `name`,`description`,`post_min`,`post_max`,`point_min`,`point_max`,`color` FROM `'.$prefix.'_groups` WHERE `id` = "'.$gid.'" LIMIT 1'));
	echo "<h3>"._EDIT_GROUP,': ',langit($name)."</h3>";
	echo '<form method="post" action="'.ADMIN_OP.'Points&act=grp_upd">';
	echo '<div id="picker" style="position:relative;float:left;"></div>';
	/*echo _GPOSTS,': <input name="post_min" type="text" value="',$post_min,'"><br />';
	echo _GPOSTS_MAX,': <input name="post_max" type="text" value="',$post_max,'"><br />';
	*/
	echo _GROUP.': <input name="gname" type="text" value="',$name,'">'._LANGIT.'<br />';
	echo _GPOINTS,': <input name="point_min" type="text" value="',$point_min,'"><br />';
	echo _GPOINTS_MAX,': <input name="point_max" type="text" value="',$point_max,'"><br />';
	echo _GDESC,': <br><textarea name="gdesc" rows="5" cols="50">'.$description.'</textarea><br /><br /><br>';
	echo _GCOLOR,':  <br><input type="text" id="gcolor" name="gcolor" class="colorwell" value="'.$gcolor.'"><br /><br />';
	
		echo '<font color="red"><b>'._GREM,'</b></font> <input name="grem" value="1" type="checkbox"><br />
		<input name="gid" type="hidden" value=',$gid,'">
		<br><input type="submit" value="',_SUBMIT,'"><br>
		</form>';
	}
function grp_upd(){
	global $db,$prefix;
	$gid = (int) sql_quote($_POST['gid']);
	$point_min = (int) sql_quote($_POST['point_min']);
	$point_max = (int) sql_quote($_POST['point_max']);
	$post_min = (int) sql_quote($_POST['post_min']);
	$post_max = (int) sql_quote($_POST['post_max']);
	$gdesc = sql_quote(check_html($_POST['gdesc'],'nohtml'));
	$gcolor = sql_quote($_POST['gcolor']);
	$gname = sql_quote($_POST['gname']);
	if($_POST['grem']){
		$result = $db->sql_query('DELETE FROM `'.$prefix.'_groups` WHERE `id` = "'.$gid.'" LIMIT 1');
		if($result) echo _GRP_REMOVED;
		return 0;
		}
	$result = $db->sql_query('UPDATE `'.$prefix.'_groups` SET `description` = "'.$gdesc.'",
	`name` = "'.$gname.'",
	`point_min` = "'.$point_min.'",
	`point_max` = "'.$point_max.'",
	`post_min` = "'.$post_min.'",
	`post_max` = "'.$post_max.'",
	`color` = "'.$gcolor.'"  
	 WHERE `id` = "'.$gid.'" LIMIT 1');
	if($result) echo _GRP_UPDD;
		}

		
include("header.php");
GraphicAdmin();

OpenTable();
main_menu();
$act = $_REQUEST['act'];
switch($act){
	case 'pman':
		group_points();
		break;
	case 'gman':
		gr_man();
		break;
	case 'add_grp':
		add_grp();
		gr_man();
		break;
	case 'upd_pts':
		upd_pts();
		group_points();
		break;
	case 'grp_edt':
		grp_edt();
		break;
	case 'grp_upd':
		grp_upd();
		gr_man();
		break;
	}
CloseTable();
include("footer.php");
/*\--------------[ END ]---------------\*/ 
?>
