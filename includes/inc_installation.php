<?php

/**
*
* @package INSTALLATION STYLE														
* @version $Id: inc_installation.php 9:22 PM 4/12/2011 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "inc_installation.php")) {
    Header("Location: ../index.php");
    die();
}

class install_class {

//===========================================
//FUNCTIONS
//===========================================
function install_style(){
echo '<link rel="StyleSheet" href="'.USV_DOMAIN.'/'.INCLUDES_ACP.'style/css/style.css" type="text/css" />';
echo '<link rel="StyleSheet" href="'.USV_DOMAIN.'/'.INCLUDES_ACP.'style/css/install.css" type="text/css" />';

}

function install_head(){
	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
	echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n";
	echo "<head>\n";
	echo "<base href=\"".USV_DOMAIN."\" />\n";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />\n";
	$this->install_style();
	echo "</head>\n";
	echo "<body>\n";
	?>
	<div class="head_1"><img
		src="<?php echo USV_DOMAIN.'/'.INCLUDES_ACP ?>style/images/admin_logo.png" border="0"
		alt="<?php echo $sitename ?>" title="<?php echo $sitename ?>"></div>
	<div class="head_2" style="margin-bottom: 20px;"><a
		href="<?php echo $nukeurl ?>"><img src="<?php echo USV_DOMAIN?>/images/icon/house.png"><?php echo $sitename ?></a></div>
	<?php	
		echo "<h3 style='text-align:right'>$s</h3>";
		echo $r ;
}

function install_body($content){
	echo "<div style='margin:0px auto;'>$content</div>";
}

function install_footer(){
	
		echo "<div style='height:100%px;padding:40px;text-align:left;font-size:10px;color:gray'>Copyright 2008-2011 <a href='http://www.MarlikCMS.com'>Marlik Group</a></div>\n";
		echo "</body>\n";
	echo "</html>\n";
}

}
?>