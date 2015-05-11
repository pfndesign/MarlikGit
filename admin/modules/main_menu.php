<?php
/**
*
* @package admin modules														
* @version $Id: main_menu.php 0999 2009-12-12 15:35:19Z James $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
function index(){
include("header.php");
GraphicAdmin();
global $db,$prefix;
define("IN_PHP", true);
require_once(''.MODS_PATH.'treemenu/common.php');
$treeElements = $treeManager->getElementList(null, 'modules.php?app=mod&name=treemenu');
?>
<link rel="stylesheet" type="text/css" href="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo MODS_PATH ?>treemenu/style.css" />
<script type="text/javascript" src="<?php echo MODS_PATH ?>treemenu/js/langManager.js" ></script>
<script type="text/javascript" src="<?php echo MODS_PATH ?>treemenu/js/treeOperations.js"></script>
<script type="text/javascript" src="<?php echo MODS_PATH ?>treemenu/js/init.js"></script>
<script type="text/javascript" src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/jquery.simple.tree.js"></script>
<script>
$(document).ready(function(){
	$("form#submit").submit(function() {
		var titlein = $('#titlein').val();
		var lang = $('#lang').val();
		var ltarget = $('#ltarget').val();
		var url = $('#link').val();
		var eid = $('#eid').val();
		var icon = $("#icon").val();
		var modulename = $('#modulename').val();
		$.ajax({
			type: "POST",
			url: '<?php echo ADMIN_OP?>save_menu_pop',
			cache:false,
			data: "titlein="+titlein+"&lang="+lang+"&ltarget="+ltarget+"&link="+encodeURIComponent(url)+"&modulename="+modulename+"&icon="+icon+"&eid="+eid,
			success: function(k) {
				$("#contentbox").hide();
				$("#resultmenu").html(k);
				alert(data);
			}
		});
		return false;
	});

	$('li.options').click(function(e) {
		$("#contentbox").show();
	});
	$("#icon").change(function(){
		var icon = $("#icon").val();
		$("#icon_prev").html('<img src="images/icon/'+icon+'" />');
	});
	$(".closemenutab").click(function(){
		$("#contentbox").fadeOut('slow');
	});
});
</script>
<div class="contextMenu" id="myMenu1">	
		<li class="addFolder">
			<img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/folder_add.png" /> </li>
		<li class="addDoc"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/page_add.png" /> </li>	
		<li class="edit"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/folder_edit.png" /> </li>
		<li class="options"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/options.png" /> </li>
		<li class="delete"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/folder_delete.png" /> </li>
		<li class="expandAll"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/expand.png"/> </li>
		<li class="collapseAll"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/collapse.png"/> </li>	
</div>

<div class="contextMenu" id="myMenu2">
		<li class="edit"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/page_edit.png" /> </li>
		<li class="options"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/options.png" /> </li>
		<li class="delete"><img src="<?php echo MODS_PATH ?>treemenu/js/jquery/plugins/simpleTree/images/page_delete.png" /> </li>
</div>
<table style="width:100%;direction:ltr;"><tr><td style="width:55%;vertical-align:top" valign="top">
<?php OpenTable(); ?>
<h3><?php echo _MANAGE_MENU; ?></h3>

<div id="wrap" style="padding-left:40px;>
	<div id="annualWizard">	
			<ul class="simpleTree" id='pdfTree'>		
					<li class="root" id='<?php echo $treeManager->getRootId();  ?>'><span><?php echo $rootName; ?></span>
						<ul><?php echo $treeElements; ?></ul>				
					</li>
			</ul>						
	</div>
</div>
<?php CloseTable(); ?>
</td><td style="width:40%;vertical-align:top;direction:<?php echo langStyle(direction)?>;text-align:<?php echo langStyle(align)?>;">
<?php OpenTable(); ?>
<h3><?php echo _HELP; ?></h3>
<?php echo _MENU_HELP_TEXT; ?>
	<center>
	<div id='contentbox' >
	<div class="menufrmdiv" style="text-align:<?php echo langStyle(align)?>;">
	<div style="position:relative;text-align:left;float:left;"><a href="javascript:void(0)" class="closemenutab" alt="close" title="<?php echo _CLOSE?>">
	<img src="images/icon/cross.png"  alt="close" title="<?php echo _CLOSE?>">
	</a>
	</div>
	<div style="clear:both"></div>
	<form id="submit" method="post" action=""  id="menufrmdiv"> 
	<b><?php echo _EDIT; ?></b><br>
	<input type="hidden" name="action" value="updateElementOpts" />
	<?php echo _TITLE; ?>: <input id="titlein" type="text" name="title" style="color: #888888;"   />
	<br />
	<?php
	//*--------language ------------------
global $multilingual;
if ($multilingual == 1) {
	$newslanguage .= "<b>"._LANGUAGE.": </b>"
	."<select name=\"lang\" id=\"lang\">";
	$handle=opendir('language');
	$languageslist = "";
	while ($file = readdir($handle)) {
		if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
			$langFound = $matches[1];
			$languageslist .= "$langFound ";
		}
	}
	closedir($handle);
	$languageslist = explode(" ", $languageslist);
	sort($languageslist);
	for ($i=0; $i < sizeof($languageslist); $i++) {
		if(!empty($languageslist[$i])) {
			$newslanguage .= "<option value=\"$languageslist[$i]\" ";
			if($languageslist[$i]==$language)
			$newslanguage .= "selected";
			$newslanguage .= ">".ucfirst($languageslist[$i])."</option>\n";
		}
	}
	$newslanguage .= "<option value=\"\">"._ALL."</option></select>";
} else {
	$newslanguage .= "<input type=\"hidden\" name=\"lang\" value=\"$language\">";
}
echo $newslanguage;
?>

	<br />
	<?php echo _MODULE; ?>: <select id="modulename" name="modulename">
	<option value=""></option>
	<?php
	$sql = 'SELECT `mid`,`title`,`custom_title` FROM `'.$prefix.'_modules`';
	$result = $mdb->query($sql);
	while($r = mysql_fetch_array($result))
		echo '<option value="'.$r['title'].'">'.langit($r['custom_title']).'</option>';
	?>
	</select>
	<br />
	<?php echo _LINK; ?>: <input type="text" id="link" name="link" value="" />
	<br />
	<?php echo _ICON; ?>: <select id="icon" name="icon">
	<option value=""></option>
	<?php
	if($handle = opendir('images/icon')){
		while (false !== ($file = readdir($handle))) {
			sort($file);
			if(strstr($file,".png") OR strstr($file,".jpg") OR strstr($file,".gif") ){
			if(is_file('images/icon/'.$file)){
			echo '<option value="'.$file.'">'.$file.'</option>';
				}
			}			
		}
    closedir($handle);
}
    ?>
	</select> <div style="display:inline" id="icon_prev"></div>
	<br />
	<?php echo _LINK_TARGET; ?>: <select id="ltarget" name="ltarget">
	<option value="_self">_self</option>
	<option value="_blank">_blank</option>
	</select>
	<input id="eid" name="eid" type="hidden" value="" />
	<button id="submit"><?php echo _SUBMIT; ?></button>
	</form></div>
	</div></center>
	<div id='processing'></div>
	</div>
<?php CloseTable(); ?>
</td></tr></table>	<div id='resultmenu'></div>
<?php
include("footer.php");
}

function save_menu_pop(){
global $db,$prefix;

	$eid = (int) $_POST['eid'];
	$title = mysql_real_escape_string($_POST['titlein']);
	$lang = mysql_real_escape_string($_POST['lang']);
	$modulename = mysql_real_escape_string($_POST['modulename']);
	$link = mysql_real_escape_string($_POST['link']);
	$ltarget = mysql_real_escape_string($_POST['ltarget']);
	$icon = mysql_real_escape_string($_POST['icon']);
	$ilink = $link.'|'.$ltarget;
	$msql = 'UPDATE `'.$prefix.'_tree_elements` SET `name` = "'.$title.'",`lang` = "'.$lang.'", `link` = "'.$ilink.'", `module` = "'.$modulename.'", `icon` = "'.$icon.'" WHERE `Id` = "'.$eid.'" LIMIT 1';
	$result = $db->sql_query($msql);
	if($result)
		echo '<div class="success">',_SUCCESSFUL,'</div>';
	else{
		echo '<div class="error">',_FAILED,'<br />',mysql_error(),'</div>';
	}
}

switch($_GET['op']) {

    default:
    index();
    break;

    case "save_menu_pop":
    save_menu_pop();
    break;

}

?>