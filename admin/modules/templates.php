<?php

/**
*
* @package template system for Nukelearn CMS														
* @version $Id: templates.php 11:32 AM 9/19/2011  Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

//include ADMIN FUNCS:
include_once('includes/inc_adminfunc.php');
class template_editorial {
	var $def_temp = '';
	var $temp_files = '';

	function file_put_contents($filename, $data) {
		if (!$file = @fopen($filename, 'w')) {
			return false;
		}
		$bytes = fwrite($file, $data);
		fclose($file);
		return $bytes;
	}

	function read_all_temps(){
		

		echo "<h3>"._TEMP_ADMIN." : "._TEMP_SHOW_ALL."</h3>
		<div>";
		$handle=opendir('themes');
		$counter = 0;
		while ($file = readdir($handle)) {
			if ( (!preg_match("/[.]/",$file) AND file_exists("themes/$file/theme.php") OR file_exists("themes/$file/table.inc") ) ) { $themelist .= "$file "; }
		}
		closedir($handle);

		$themelist = explode(" ", $themelist);
		sort($themelist);

		for ($i=0; $i < sizeof($themelist); $i++) {
			$counter++;
			if($themelist[$i]!="") {

				//----START--------- display image of the Template--------------
				$imglist='';

				$img_folder = "themes/$themelist[$i]/";

				mt_srand((double)microtime()*1000);

				$imgs = dir($img_folder);

				while ($file = $imgs->read()) {
					if (preg_match("/gif/", $file) || preg_match("/jpg/", $file) || preg_match("/png/", $file))
					$imglist .= "$file ";

				} closedir($imgs->handle);

				$imglist = explode(" ", $imglist);
				$image = $imglist[0];
				if (!empty($image)) {
					$s_shot ="$img_folder"."$image";
				}else {
					$s_shot ="images/preload.gif";
				}



				//----START--------- display a highlight border arround the current theme
				$ThemeSel = get_theme();
				if($ThemeSel==$themelist[$i]){
					$styletm = "border:4px solid #FFE100;";
					$titletm = _TEMP_CURRENT;
				}else {
					$styletm="border:0px;";
					$titletm = "$themelist[$i]";
				}

				echo "<div style='text-align:center;padding:10px;margin:5px;background:#F5F6F7;float:right'>
				<img src='$s_shot' style='$styletm'  title='$titletm' alt='$titletm' width='128px' height='128px' > <br>
				<a href='".ADMIN_OP."themes_set_def&t=".$themelist[$i]."' class='themes_set_def' ><img src='images/key.gif'>"._TEMP_SET_DEF."</a> | <img src='images/edit.gif'><a href='".ADMIN_OP."theme_edit&t=".$themelist[$i]."' class='themes_edit' >"._EDIT." </a> | <img src='images/icon/cross.png'><a href='".ADMIN_OP."remove_file&t=".$themelist[$i]."&f=*' class='themes_edit' >"._REMOVE."</a><br>
				";
				echo "<br><b>".$themelist[$i]."</b></div> \n";

				if ($counter == 3 ) {
					echo "<br>";
					$counter=0;
				}

			}
		}
		echo "</div>
		<div class='clear'></div>";

	}
	function read_online_temps(){
	?>
	
	<?php
		global $sitekey;

		if (check_writable(array('themes')) !== true) {
				_e("دسترسی پوشه قالب را تصحیح کنید و به 777 تغییر دهید ");
		}
		
		$url = 'adminfile='. urlencode(ADMIN_PHP) .'&url='. urlencode(base64_encode($_SERVER['SERVER_NAME']));
		
		if (!$content = get_remote_contents('http://www.nukelearn.com/remote.php?op=onlineThemes&'. $url, 'curl_get_contents')) {
				_e("متاسفانه ارتباط با سرور نیوک لرن برقرار نشد <br>
				$url	
				");
		}
		
		
		echo $content;

	}

	function read_files_temp($dir) {

		if($dh = opendir($dir)) {

			$files = Array();
			$inner_files = Array();

			while($file = readdir($dh)) {
				if($file != "." && $file != ".." && $file[0] != '.') {
					if(is_dir($dir . "/" . $file)) {
						$inner_files = $this->read_files_temp($dir . "/" . $file);
						if(is_array($inner_files)) $files = array_merge($files, $inner_files);
					} else {
						array_push($files, $dir . "/" . $file);
					}
				}
			}

			closedir($dh);
			return $files;
		}
	}

	function theme_edit_page($t,$f=''){
		include ('header.php');
		GraphicAdmin();
		OpenTable();

		$txt['template'] = $t;

		echo '<div id="edit_file">';
		if (!file_exists('themes/'. $txt['template'] .'/')) {
			die(_NO_FILE);
		}

		// template files
		$txt['files'] = array();
		foreach ($this->read_files_temp('themes/'. $txt['template'] .'') as $key=>$file){
			$file_type = strtolower(substr($file, -3)); // get file type
			if ($file_type == 'php' || $file_type == 'tml' || $file_type == 'css' || $file_type == '.js') {
				$countnf = strlen($txt['template'])+8;
				$file_name = strtolower(substr($file, $countnf));
				$txt['files'][] = array ($file_name, ''. $file_type .'.png');
			}
		}
		$this->temp_files = $txt['files'];

		echo "<h3>"._TEMP_ADMIN." -> "._EDIT." <a href='".ADMIN_OP."theme_edit&t=". $txt['template'] ."'><b>".$txt['template']."</b></a></h3><a href='".ADMIN_OP."templates'><img src='images/icon/arrow_undo.png'>"._TEMP_BACK_SHOWROOM."</a><br>
		"._TEMP_LIST_OF_FILES."
		<hr>
		 <ul>
		";
		//for ($i=0; $i<sizeof($this->temp_files ); $i++){
		foreach ($this->temp_files as $key => $value ){
			echo "<li><img src='".SCRIPT_PLUGINS_PATH."templates/".$value[1]."' ><a style='".($f==$value[0] ? "color:000;background:#F6F688;padding:2px;" : "")."' href='".ADMIN_OP."theme_edit&t=".$txt['template']."&f=".$value[0]."'> - ".$value[0]."</a></li>\n";
		}
		echo "</ul>";
		if (!empty($f)) {
	$tf_get_contents ='themes/'. $txt['template'] .'/'.$f.'';
	$th_get_contents = fopen($tf_get_contents, 'r');
	$to_get_contents = fread($th_get_contents, filesize($tf_get_contents));
	fclose($th_get_contents);
	
	echo '
    <link rel="stylesheet" href="'.SCRIPT_PLUGINS_PATH.'templates/lib/codemirror.css"> 
    <link rel="stylesheet" href="'.SCRIPT_PLUGINS_PATH.'templates/theme/default.css"> 
    <script src="'.SCRIPT_PLUGINS_PATH.'templates/lib/codemirror.js"></script> 
    <script src="'.SCRIPT_PLUGINS_PATH.'templates/mode/javascript/javascript.js"></script> 
    <script src="'.SCRIPT_PLUGINS_PATH.'templates/mode/scheme/scheme.js"></script> 

    <style type="text/css">   
        .fullscreen {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            margin: 0;
            padding: 0;
            border: 0px solid #BBBBBB;
            opacity: 1;
        }
    </style> ';

echo '<h1>'._EDIT.': <a style="color:blue" href="'.ADMIN_OP.'theme_edit&t='. $txt['template'] .'">'. $txt['template'] .'<a/> </font>
-> '._FILENAME.' :  
<font color="red">'.$f.'</font></h1> <br> 
<a href="'.ADMIN_OP.'theme_edit&t='.$txt['template'].'&f='.$f.'" class="refresh_file"><img src="images/icon/arrow_undo.png">'._TEMP_REFRESH.'</a>
<a href="'.ADMIN_OP.'remove_file&t='.$txt['template'].'&f='.$f.'" class="remove_file"><img src="images/icon/cross.png">'._REMOVE.'</a>
<form action="'.ADMIN_OP.'save_file_edit" method="POST">
<textarea id="code" name="code">'.$to_get_contents.'</textarea>
<input type="hidden" name="f" value="'.$f.'" />
<input type="hidden" name="t" value="'.$txt['template'].'" />
<input type="submit" value="'._SAVE.'" class="save_file" />
<br>
</form>
';

echo '
<script> 
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        theme: "default",
	    mode: "scheme",
	    lineNumbers: true,
	    matchBrackets: true,
	    tabMode: "indent",
	    onChange: function() {
	      clearTimeout(pending);
	      setTimeout(update, 400);
	    },
        onKeyEvent: function(i, e) {
          // Hook into F11
          if ((e.keyCode == 122 || e.keyCode == 27) && e.type == "keydown") {
            e.stop();
            return toggleFullscreenEditing();
          }
        }
    });
 
var lastPos = null, lastQuery = null, marked = [];
 
function unmark() {
  for (var i = 0; i < marked.length; ++i) marked[i]();
  marked.length = 0;
}
 
function search() {
  unmark();                     
  var text = document.getElementById("query").value;
  if (!text) return;
  for (var cursor = editor.getSearchCursor(text); cursor.findNext();)
    marked.push(editor.markText(cursor.from(), cursor.to(), "searched"));
 
  if (lastQuery != text) lastPos = null;
  var cursor = editor.getSearchCursor(text, lastPos || editor.getCursor());
  if (!cursor.findNext()) {
    cursor = editor.getSearchCursor(text);
    if (!cursor.findNext()) return;
  }
  editor.setSelection(cursor.from(), cursor.to());
  lastQuery = text; lastPos = cursor.to();
}
 
function replace() {
  unmark();
  var text = document.getElementById("query").value,
      replace = document.getElementById("replace").value;
  if (!text) return;
  for (var cursor = editor.getSearchCursor(text); cursor.findNext();)
    cursor.replace(replace);
}
function toggleFullscreenEditing()
    {
        var editorDiv = $(".CodeMirror-scroll");
        if (!editorDiv.hasClass("fullscreen")) {
            toggleFullscreenEditing.beforeFullscreen = { height: editorDiv.height(), width: editorDiv.width() }
            editorDiv.addClass("fullscreen");
            editorDiv.height("100%");
            editorDiv.width("100%");
            editor.refresh();
        }
        else {
            editorDiv.removeClass("fullscreen");
            editorDiv.height(toggleFullscreenEditing.beforeFullscreen.height);
            editorDiv.width(toggleFullscreenEditing.beforeFullscreen.width);
            editor.refresh();
        }
    }
    
	$(".refresh_file").live("click",function()
	{
		if(confirm("'._TEMP_REFRESH_ALERT.'"))
		{
		return true;
		}
		return false;
	});
	
	$(".save_file").live("click",function()
	{
		if(confirm("'._TEMP_SAVE_ALERT.'"))	{
		return true;
		}
		return false;
	});
	$(".remove_file").live("click",function()
	{
		if(confirm("'._TEMP_REMOVE_ALERT.'"))	{
		return true;
		}
		return false;
	});
	
    
 function updatePreview() {
        var preview = document.getElementById("preview").contentDocument;
        preview.open();
        preview.write(editor.getValue());
        preview.close();
      }
      setTimeout(updatePreview, 300);
    
    
</script>';
				echo '
<div style="background:#ccc;border:2px solid white;padding:10px;" >
<button type=button onclick="search()">'._SEARCH.'</button> 
<input type=text style="width: 5em" id=query value=""> <b> '. _OR .' </b>
<button type=button onclick="replace()">'._REPLACE.'</button> '._THIS_WORD.'
<input type=text style="width: 5em" id=replace> 
</div>
<p> '._TEMP_FULLSCREEN.' </p> <p> <a href=""><img src="images/icon/accept.png">'._PREVIEW.'</a>
    <iframe id=preview style="display:none;background:white;border:1px black solid;width:99%;height:300px;"></iframe> 
    </p> 

 ';
	}

		echo '</div>';

		CloseTable();
		include ('footer.php');

	}

	function save_file_edit($t,$f,$code){
		$code = trim($code);
		$file_name = "themes/$t/$f";
		if (!file_exists($file_name)) {
			die(_NO_FILE);
		}
		if (empty($code)) {
			die(_NO_CONTENT);
		}

		file_put_contents($file_name, $code);

		header("Location: ".ADMIN_OP."theme_edit&t=".$t."&f=".$f."");

	}

	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException('$dirPath must be a directory');
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}    
   	 rmdir($dirPath);
	}
	
	function remove_file($t,$f){

		if ($f=="*" AND $_GET['confirm_flush']<>1) {
			include ('header.php');
			GraphicAdmin();
			OpenTable();
			echo "<center><div class='error'>"._TEMP_FLUSH_ALERT."<br>
<br>
<a class='button' href='".ADMIN_OP."remove_file&t=".$t."&f=".$f."&confirm_flush=1&type=rmdir'><b>"._YES."</b></a>  -  
<a class='button' href='".ADMIN_OP."theme_edit&t=".$t."'><b>"._NO."</b></a>
</div>
			</center>";
			CloseTable();
			include ('footer.php');
		}
		if ($f=="*" AND $_GET['confirm_flush']==1) {
			header("Location: ".ADMIN_OP."theme_edit&t=".$t."&f=".$f."&confirm_flush=1&type=rmdir");
		}
		//delete a directory and all its files.
		if ($_GET['type']=="rmdir"	) {	
			   $this->deleteDir("themes/$t");
				header("Location: ".ADMIN_OP."templates");
		}else {

		//delete only a file 
		$file_name = "themes/$t/$f";
		if (!file_exists($file_name)) {
			die(_NO_FILE);
		}
		unlink($file_name);
		header("Location: ".ADMIN_OP."theme_edit&t=".$t."");
		}
		
	}

	function themes_set_def($t){
		global $db;
		if (empty($t)) {
			die(_NO_FILE);
		}
		$sql = "UPDATE ".__CONFIG_TABLE." SET `Default_Theme`='$t'";
		$db->sql_query($sql) or die(_e(mysql_error()));

		header("Location: ".ADMIN_OP."templates");
	}
	
	function themes_view_online($t){
		global $db;
	
		echo "<iframe  style='width:650px;height:400px;' src='http://www.nukelearn.com/remote.php?op=theme_page&lid=$t&adminfile=".USV_DOMAIN."/".ADMIN_PHP."'></iframe>";
	}
	
	
	function themes_download($t,$f){
	
	global $db,$prefix,$user;

	
	$file_url = sql_quote(base64_decode($f));
	$file_name = sql_quote($t);
	
	if(empty($file_url)){
	_e('اطلاعات دریافتی کامل نیست. این فایل نمی تواند روی هاست شما دانلود شود');
	}


	//move to user host: 
	if (!copy_file("$file_url","themes/"))
	{
					_e('دانلود قالب ممکن نبود. ما چند طریق کپی قالب رو امتحان کردیم. احتمال می دهیم دسترسی پوشه قالب ها برای انتقال فایل ها صحیح نیست');
	}
	
	echo "<div class='success'>با موفقیت نصب شد</div>";
	
	
	}
	
}




if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { show_error("Access Denied"); }
if (!defined('ADMIN_FILE')) {show_error("Access Denied");}

require_once("mainfile.php");
$pagetitle = _TEMP_ADMIN;

global $admin,$prefix,$db;

if (is_superadmin($admin)) {

	$template = new template_editorial();

	switch ($op){

		default:
			include ('header.php');
			GraphicAdmin();
			OpenTable();
	?>

<script>
			// Wait until the DOM has loaded before querying the document
			$(document).ready(function(){
				$('ul.tabs').each(function(){
					// For each set of tabs, we want to keep track of
					// which tab is active and it's associated content
					var $active, $content, $links = $(this).find('a');

					// If the location.hash matches one of the links, use that as the active tab.
					// If no match is found, use the first link as the initial active tab.
					$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
					$active.addClass('active');
					$content = $($active.attr('href'));

					// Hide the remaining content
					$links.not($active).each(function () {
						$($(this).attr('href')).hide();
					});

					// Bind the click event handler
					$(this).on('click', 'a', function(e){
						// Make the old tab inactive.
						$active.removeClass('active');
						$content.hide();

						// Update the variables with the new link and content
						$active = $(this);
						$content = $($(this).attr('href'));

						// Make the tab active.
						$active.addClass('active');
						$content.show();

						// Prevent the anchor's default click action
						e.preventDefault();
					});
				});
			});
		</script>

<style>
		
			.tabs li {
				list-style:none;
				display:inline;
			}

			.tabs a {
				padding:10px;
				display:inline-block;
				background:#666;
				color:#fff;
				text-decoration:none;
			}
			.tabs a:hover {
				background:#ff0000;
				color:#fff;
			}

			.tabs a.active {
				background:#ff0000;
				color:#fff;
			}
			#tab1,#tab2 {
			border:1px solid #ccc;margin:0px auto;width:94%;
			}
		</style>

		<ul class='tabs'>
			<li><a href='#tab1'>قالب های نصب شده</a></li>
			<li><a href='#tab2'>مخزن آنلاین قالب</a></li>
		</ul>
		<div id='tab1'>
			<?php $template->read_all_temps(); ?>
		</div>
		<div id='tab2'>
			<div id='showonlinethemes'><div class='info'><img src='images/loading.gif'> در حال دریافت اطلاعات از سرور نیوک لرن .<?php echo _LOADING ?></div></div>
			
			<script language='javascript' type='text/javascript'>
		jQuery('#showonlinethemes').load('<?php echo ADMIN_OP?>read_online_temps');
		$.getScript('<?php echo ADMIN_OP?>read_online_temps');
		</script>
		</div>


	<?php


			CloseTable();
			include ('footer.php');
			break;

		case 'themes_download':
			$template->themes_download("$t","$f");
			break;
		case 'theme_edit':
			$template->theme_edit_page("$t","$f");
			break;

		case 'save_file_edit':
			$template->save_file_edit("$t","$f","$code");
			break;

		case 'themes_set_def':
			$template->themes_set_def("$t");
			break;

		case 'themes_view_online':
			$template->themes_view_online("$t");
			break;

		case 'read_online_temps':
		$template->read_online_temps();
			break;

		case 'remove_file':
			$template->remove_file("$t","$f");
			break;



	}

}else {
	die(HACKING_ATTEMPT);
}
?>