<?php

/**
*
* @package language system for Nukelearn CMS														
* @version $Id: languages.php 11:32 AM 9/19/2011  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

function updatelanguage() {

	$icons = '';

	if (!empty($_POST['lang'])) {
		$data = '$lang = \''.$_POST['lang'].'\';'."\r\n".'$rtl = '.$_POST['rtl'].';';

		configeditor('LANGUAGE',$data,0);
	}

	$_SESSION['cometchat']['error'] = 'Language details updated successfully';

	header("Location:?module=language");

}
function editlanguage() {


	addJSToHead(INCLUDES_ACP.'style/js/admin.js','file');
	addJSToHead(INCLUDES_ACP.'style/js/jquery-ui.min.js','file');
	addJSToHead(INCLUDES_ACP.'style/js/jquery.bgiframe-2.1.1.js','file');
	addJSToHead(INCLUDES_ACP.'style/js/jquery-ui-i18n.min.js','file');
	include ('header.php');
	GraphicAdmin();
	
	OpenTable();
	global $db;
	$lang = $_GET['data'];

	$filestoedit = array ("core" => "language",);

	if ($handle = opendir('modules/')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && file_exists('modules/'.$file.'/index.php') && file_exists('modules/'.$file.'/language/lang-'.$lang.'.php')) {
				$filestoedit["modules/".$file] = $file;
			}
		}
		closedir($handle);
	}
	// core language
	// admin language

	$data = '';

	foreach ($filestoedit as $name => $file) {

		if ($name=='core') {
			$namews = '';
		} else {
			$namews = $name.'/';
		}

		if (file_exists($namews.'language/lang-'.$lang.'.php')) {
			if ($name == '') {
				$data .= '<h4 style="color:white;background:#3A4C64;border:2px solid #C0C3D4;padding:5px;" onclick="javascript:$(\'#'.md5($name).'\').slideToggle(\'slow\')">core</h4>';
			} else {
				$data .= '<div style="clear:both"></div>
				<h4 style="color:white;background:#3A4C64;border:2px solid #C0C3D4;padding:5px;" onclick="javascript:$(\'#'.md5($name).'\').slideToggle(\'slow\')"><b>'.$name.'</b></h4>';
			}

			$data .= '<div id="'.md5($name).'" style="display:none;padding:10px;background:#E0E2DF;border:2px solid white"><form id="form-'.md5($name).'" action="'.ADMIN_OP.'language" method="post" enctype="multipart/form-data">';


		
			
			$Lines = file($namews.'language/lang-'.$lang.'.php');
			
			$Constants = array();
			$Constants2 = array();
			foreach ($Lines as $Line) {
				$Line = trim($Line);
				$Line = preg_replace('!/\*.*?\*/!s', '', $Line);
				$Line = str_replace("define(\"","",$Line);
				$Line = str_replace('define(\'','',$Line);
				$Line = str_replace("\");","",$Line);
				$Line = str_replace('\');','',$Line);
				$Line = str_replace("//","",$Line);

				$Pos = strpos($Line,"\",\"");
				$Left = substr($Line,0,$Pos);
				$Right = substr($Line,$Pos+3);
				$Constants[$Left] = $Right;
				
				
				//$singlequotearr = explode(",",$Line);
				//$Constants2[$singlequotearr[0]] = $singlequotearr[1];
				
				$Pos2 = strpos($Line,'\',\'');
				$Left2 = substr($Line,0,$Pos2);
				$Right2 = substr($Line,$Pos2+3);
				$Constants2[$Left2] = $Right2;
				
			}
				
			foreach(array_merge($Constants,$Constants2)  as $key => $val){
				if (!empty($key) AND strlen($key)>2) {
					$df_c ++;
					$data .= '<div style="clear:both"></div><small>'.$df_c. ' :  </small><div class="title" style="text-align:'.langstyle(align).';font-size:13px;">'. $key.' </div><div class="element"><textarea name="'.$key.'" class="inputbox inputboxlong" cols="100" rows="4" >'.(stripslashes($val)).'</textarea></div>';

				}
			}

			$data .= '<div style="clear:both;padding:7.5px;"></div><div style="float:right;margin-right:20px;"><input type="button" value="'._LANGUAGE_UPDATE.'" onclick="language_updatelanguage(\''.md5($name).'\',\''.$name.'\',\''.$file.'\',\''.$lang.'\')" class="button"></div><div style="clear:both;padding:7.5px;"></div></form></div>';
			
		}

	}
	$body = '
	<div id="rightcontent" style="direction:'.langStyle(direction).';text-align:'.langStyle(align).'">
		<h2> '._EDIT.' '._LANGUAGE.' '.$lang.'</h2> <font color="red"><b>'.$df_c.' ثابت زبانی</b> </font>
		<h3>'._LANGUAGE_SELECTMODULE.'</h3>
		<div>
			<div id="centernav" class="centernavextend">
				'.$data.'
				<div style="clear:both;padding:5px;"></div>
			</div>
		</div>

	</div>

	<div style="clear:both"></div>

';

	echo $body;
	echo $navigation;

	CloseTable();
	include ('footer.php');
}
function editlanguageprocess() {

	$language = $_POST['language'];
	$Rawlang = $_POST['Rawlang'];
	$lang = $_POST['lang'];
	
	if (!empty($_POST['id']) AND $_POST['id']=='core') {
		$fdir = './';
	}else {
		$fdir = $_POST['id'];
	}
	
	$data = '<?php
/**
*
* @package Language file : '.$_POST['id'].'												
* @version $Id: lang-'.$_POST['lang'].'.php 11:12 AM 5/10/2011 $ Nukelearn			
* @copyright (c) Marlik Group  http://www.nukelearn.com							
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/'."\r\n\r\n";

	for ($i=0; $i<sizeof($language) AND $i<sizeof($Rawlang); $i++ ){
		$data .= 'define("'.$Rawlang[$i].'","'.(str_replace('"', '\"', $language[$i])).'");'."\r\n";
	}
	$data .= '?>';
	
	$file = ''.$fdir.'language/lang-'.strtolower($lang).".php";
	$fh = fopen($file, 'w');
	if (fwrite($fh, $data) === FALSE) {
		echo _CANNOT_WRITEIT;
		exit;
	}
	fclose($fh);
	chmod($file, 0777);

	echo _LANG_UPDATED;
	exit;
}


//for our next version :
//import language files
// remove language files
// create if not exists for a language
// export
// backup all
//standardize a language file
?>