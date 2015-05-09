<?php
/**
*
* @package tags														
* @version $Id: tags.php 0999 2009-12-12 15:35:19Z JAMES $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
// this administration panel is solely written for use in the first version of Nukelearn USV
// and only works with that
// Written by Hamed Momeni
// this one still has lots of works ahead

function tag_man(){
		global $db,$prefix;
		include_once('header.php');
		GraphicAdmin();
		OpenTable();
?>
<script type="text/javascript">
function tedit(tid,tname,tslug,tact){
	tact = tact || 'tupdt';
	$("#tid").val(tid);
	$("#tname").val(tname);
	$("#tslug").val(tslug);
	$("#tact").val(tact);
	$(".add_tag").show('slow');
}
</script>
<?php


		$sql = 'SELECT `tid`,`tag`,`slug`,`count` FROM `'.$prefix.'_tags` ORDER by `tid` ASC';
		$result = $db->sql_query($sql);
		$num = $db->sql_numrows($result);

		echo "<h3>" . _TAGS_ADMIN . "</h3>";
		if (!empty($num)) {
		if ($num > 50 ) {
			$style = 'style="overflow:auto;height:600px"';
		}
		echo '<form name="tagmain" id="tagmain" method="post" action="'.ADMIN_OP.'Tags&act=trem">';
		echo '<div '.$style.' >		
		<table class="widefat comments fixed">
   			<thead>';
		
		echo "		<tr>";
		echo '		<th scope="col" >&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'tagmain\'), \'selectbox\', this.checked);" /></th>';
		echo "		<th scope='col' >"._TNAME."</th>\n";
		echo "		<th scope='col'>"._SLUG."</th>\n";
		echo "		<th scope='col' >"._COUNT."</th>\n";
		echo "		<th scope='col'>"._OPTIONS."</th>\n";
		echo "	
		</tr>
		</thead>";
		echo "      <tfoot>";
		echo "		<tr>";
		echo '		<th scope="col" >&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'tagmain\'), \'selectbox\', this.checked);" /></th>';
		echo "		<th scope='col' >"._TNAME."</th>\n";
		echo "		<th scope='col'>"._SLUG."</th>\n";
		echo "		<th scope='col' >"._COUNT."</th>\n";
		echo "		<th scope='col'>"._OPTIONS."</th>\n";
		echo "		</tr>
		</tfoot>";
		echo "<tbody>\n";
		

		while($row = $db->sql_fetchrow($result)){
			$tslug = sql_quote(Deslug($row['slug']));
		echo '<tr>
		
        <td><input type="checkbox" name="tag_ids[]" class="selectbox" value="',$row['tid'],'" /></td>	
        <td><a href="'.ADMIN_OP.'Tags&act=tedit&tid=',$row['tid'],'">',$row['tag'],'</a></td>
        <td>',DeSlug($row['slug']),'</td>
        <td>',$row['count'],'</td>
        <td><a href="'.ADMIN_OP.'Tags&act=tedit&tid=',$row['tid'],'" onclick=\'tedit("'.$row['tid'].'","'.$row['tag'].'","'.$tslug.'"); return false;\'>
        <img src="images/icon/page_edit.png" title="',_EDIT,'" /></a><a href="'.ADMIN_OP.'Tags&act=strem&tid=',$row['tid'],'">
        <img src="images/delete.gif" title="',_REMOVE,'"/></a></td>
        
        </tr>';
		}
		echo ' </tbody></table></div><br>';
		
		echo '<input type="submit" value="',_REMOVE_SELECTED,'" /></form>';
}else {
		echo _NO_TAG;
}
?>
<br><hr>
<a href="<?php echo ADMIN_OP ?>Tags&act=resetTagsCount" class="button"><?php echo  _RECOUNT." ". _TAG?> </a>
<button onclick="$('.add_tag').toggle('slow');tedit('','','','add_tag');"><?php echo _ADD_TAG; ?></button>
 <div class="add_tag" style="display:none;">
<form action="<?php echo ADMIN_OP ?>Tags" method="post">
<table class="widefat comments fixed" style="width:400px;margin:0px auto;text-align:center;">
<thead><tr><th colspan="2"><?php echo _ADD_TAG; ?></th></tr></thead>
<tbody><tr><td><?php echo _TNAME; ?>:</td><td><input id="tname" type="text" name="tname" /></td></tr>
<tr><td><?php echo _SLUG; ?>:</td><td><input id="tslug" type="text" name="tslug" /></td></tr>
</tbody>
<tfoot>
<tr><th colspan="2"><input type="submit" value="<?php echo _SUBMIT; ?>" /></th></tr>
</tfoot>
</table>
<input type="hidden" id="tid" name="tid" value="" />
<input type="hidden" id="tact" name="act" value="add_tag" />
</form>
</div>
<?php

		CloseTable();
		include_once('footer.php');
}
function tag_edit(){
		global $db,$prefix;
		include_once('header.php');
		GraphicAdmin();
		OpenTable();
		$tid = (int) $_REQUEST['tid'];
		$tid = sql_quote($tid);
		list($tag,$slug) = $db->sql_fetchrow($db->sql_query('SELECT `tag`,`slug` FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tid.'" LIMIT 1'));
		echo '<form action="'.ADMIN_OP.'Tags" method="post">
<table class="widefat comments fixed">
<thead><tr><th colspan="2">'._EDIT.'</th></tr></thead>
<tbody><tr><td>'._TNAME.':</td><td><input id="tname" type="text" name="tname" value="'.$tag.'" /></td></tr>
<tr><td>'._SLUG.':</td><td><input id="tslug" type="text" name="tslug" value="'.Deslug($slug).'" /></td></tr>
</tbody>
<tfoot>
<tr><th colspan="2"><input type="submit" value="'._SUBMIT.'" /></th></tr>
</tfoot>
</table>
<input type="hidden" id="tid" name="tid" value="'.$tid.'" />
<input type="hidden" id="tact" name="act" value="tupdt" />
</form>';
		CloseTable();
		include_once("footer.php");
}
function tag_update(){
	global $db,$prefix;

	$tid = (int) $_POST['tid'];
	$tname = sql_quote($_POST['tname']);
	if($_POST['tslug'] == "")
		$tslug = sql_quote(Slugit($_POST['tname']));
		else
		$tslug = sql_quote(Slugit($_POST['tslug']));
		
		
	if($_REQUEST['act'] == "add_tag")
		$tsql = 'INSERT INTO `'.$prefix.'_tags` (`tag`,`slug`) VALUES ("'.$tname.'","'.$tslug.'")';
		elseif($_REQUEST['act'] == "tupdt")
		$tsql = 'UPDATE `'.$prefix.'_tags` set `tag` = "'.$tname.'", `slug` = "'.$tslug.'" WHERE `tid` = "'.$tid.'" LIMIT 1';
	

	if(!$db->sql_query($tsql)){
	OpenTable();
	echo '<div style="text-align:center">';
		echo '<span style="color:red">',_TAG_UPD_FAILED,':</span>';
		echo  mysql_error();
	CloseTable();
	}

}
function tag_remove(){
	global $db,$prefix;
	$tids = $_POST['tag_ids'];
	$c = count($tids);
	$wclause = '';
	for($i=0;$i<$c;$i++){
		if($i == $c-1){
			$wclause .= 'tid = "'.$tids[$i].'"';
		}else{
			$wclause .= 'tid = "'.$tids[$i].'" OR ';
		}
		}
	include("header.php");
	OpenTable();
	echo '<div style="text-align:center">';
	if($db->sql_query('DELETE FROM `'.$prefix.'_tags` WHERE '.$wclause)){
		echo '<span style="color:green">',_TAG_UPD_DONE,'</span>';
		}else{
		
		echo '<span style="color:red">',_TAG_UPD_FAILED,':</span>';
		echo  mysql_error();
		}
		echo '<br /><a href="'.ADMIN_OP.'Tags">',_GO_BACK,'</a></div>';
	CloseTable();
	include_once("footer.php");
	}
function single_remove(){
	global $db,$prefix;
	$tid = (int) $_REQUEST['tid'];
	include("header.php");
	OpenTable();
	echo '<div style="text-align:center">';
	if($db->sql_query('DELETE FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tid.'" LIMIT 1')){
		echo '<span style="color:green">',_TAG_UPD_DONE,'</span>';
		}else{
		
		echo '<span style="color:red">',_TAG_UPD_FAILED,':</span>';
		echo  mysql_error();
		}
		echo '<br /><a href="'.ADMIN_OP.'Tags">',_GO_BACK,'</a></div>';
	CloseTable();
	include_once("footer.php");
	}
function resetTagsCount(){
		include_once('header.php');
		GraphicAdmin();
		OpenTable();
		require_once(INCLUDES_PATH."inc_tags.php");
		$tag = new Tags;
		$tag->resetTags_counts();
		echo "<a href='".ADMIN_OP."Tags'>"._GO_BACK."</a>";
		CloseTable();
		include_once('footer.php');
}
	
global $db,$prefix;
$act = $_REQUEST['act'];
switch($act){
		
	case 'query':

		$response = array();
		$r = 0;
		$sql = 'SELECT tag,count FROM '.$prefix.'_tags ORDER BY tag';
		$result = $db->sql_query($sql);
		if(!$result) echo mysql_error();
		while($row = $db->sql_fetchrow($result)){
			$qresult .= "".$row['tag'].",";
			$names = explode(",",$qresult);
		}
		sort($names);
		foreach ($names as $i => $name)
		{
			$rez =  $db->sql_query("SELECT count FROM ".$prefix."_tags WHERE tag='".$names[$r++]."' ");
			while($zrow = $db->sql_fetchrow($rez)){
				$count = intval($zrow['count']);
			}
			$response[] = array($name, $name, null,$name." » <b>(".$count.")</b> ");
		}
		header("Content-type: application/json; charset=UTF-8");
		echo json_encode($response);
		$db->sql_freeresult($result);
	break;
		
		
		default:
		case 'Tags_Man':
		tag_man();
		break;
		case 'tedit':
		tag_edit();
		break;
		case 'add_tag':
		case 'tupdt':
		tag_update();
		tag_man();
		break;
		case 'trem':
		tag_remove();
		break;
		case 'strem':
		single_remove();
		break;
		case 'resetTagsCount':
		resetTagsCount();
		break;
}
?>
