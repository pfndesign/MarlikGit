<?php
/**
*
* @package acp														
* @version $Id: acp_dashboard.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
/**
* @ignore
*/
if (!defined('ADMIN_FILE')) {
	exit;
}
function admin_head() {
	?>
	<script type="text/javascript" src="includes/acp/style/js/admin.js"></script>

	<style type="text/css">body,h3,h2,h1,li,ul,form,.widefat td,.widefat th,.ver-zebra td,.ver-zebra th,.hor-zebra td,.hor-zebra th,.ul.tabs li,.tab_container,.notify,.error  {text-align:<?php echo langstyle(align)?>;direction:<?php echo langstyle(direction)?>}</style><?php
	if (defined("addCSSToHead")) {
		addCSSToHead(INCLUDES_ACP.'style/css/style.css','file');
		$inlineCSS2 = '<!--[if IE ]><link rel="stylesheet" href="'.INCLUDES_ACP.'style/css/ie.css" type="text/css" media="screen" /><![endif]-->';
		addCSSToHead($inlineCSS2,'inline');
	} else {
		echo '<link rel="StyleSheet" href="'.INCLUDES_ACP.'style/css/style.css" type="text/css" />';
		echo '<!--[if IE ]><link rel="stylesheet" href="'.INCLUDES_ACP.'style/css/ie.css" type="text/css" media="screen" /><![endif]-->';
	}
}
function adminheader() {
	include_once(MODS_PATH ."navigation/includes/menuNav.php");
	global $aid,$admin,$sitename,$admin_file,$log;
	?>
	<!-- navigation -->
	<div class="wrapperz">
	<div class="head_1">   
	<a href="<?php echo ADMIN_PHP ?>">
	<img src="<?php echo INCLUDES_ACP ?>style/images/admin_logo.png" border="0" alt="<?php echo $sitename ?>" title="<?php echo $sitename ?>">
	</a>
	<div class="head_right">
	<span style="font-size:14px;color:#000000"><?php echo _WELLCOME.' ';
	?>
	<a href="<?php echo ADMIN_OP ?>mod_authors" title="._EDITPROFILE." style="color:#226E97;">
	<?php echo $aid ?>
	</a>
	</span>
	<a  href="<?php echo ADMIN_OP;
echo('logout" style="color:red;" title='._ADMINLOGOUT.'><img src="images/icon/stop.png">'. _ADMINLOGOUT .'</a>');?>
</div>
</div>
<div class="usv-nav" >
<div class="l"></div>
<div class="r"></div>
<ul class="navMenu">
<div><?php echo navigation_menu()?></div>
</ul>
</div>
<?php
}
function adminfooter()
{
global $admin;
?>
</div>
<div class="pushz"></div>
<div class="footerz">
<div id="footer">
        <div class="container">
            <div class="footer-wrapper clearfix">
                <div class="footer-col1">
                    <a href="http://www.nukelearn.com"><img src="images/powered/footer-logo.png" alt="Nukelearn Portal" style="float:left;padding-left:50px;"></a>
                    <img src="images/powered/footer-slogan.png" alt="Software that changes your webmastering experience." class="slogan">
                        </div>
                <div class="footer-col2" style="text-align:<?php echo langstyle(align)?>">
                <div class="clearfix" >
<?php if (is_superadmin($admin)) { echo('
	                        <ul class="col1" style="float:right;">
	                            <li><a href="'.ADMIN_PHP.'">'._ADMIN_MAINPAGE.'</a></li>
	                            <hr>
	                            <li><a href="'.ADMIN_OP.'Configure">'._ADMIN_CONFIGUREADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'modules">'._ADMIN_MODULESADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'BlocksAdmin">'._ADMIN_BLOCKADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'mod_authors">'._EDITADMINS.'</a></li>
	                            <li><a href="'.ADMIN_OP.'ShowNewsPanel">'._ADMIN_MODULE_NEWSADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'DLMain">'._DOWNLOADS.'</a></li>
	                            <li><a href="'.ADMIN_OP.'mod_users">'._EDITUSERS.'</a></li>
	                        </ul>
	                        <ul class="col2">
	                            <li><a href="#">'._MODULES.'</a></li>
	                            <hr>
	                            <li><a href="'.ADMIN_OP.'adminStory">'._SUBMIT_NEW_PAGE.'</a></li>
	                            <li><a href="'.ADMIN_OP.'topicsmanager">'._TOPICS.'</a></li>
	                            <li><a href="'.ADMIN_OP.'Points">'._POINTS.'</a></li>
	                            <li><a href="'.ADMIN_OP.'MetaConfig">'._ADMIN_MODULE_META.'</a></li>
	                            <li><a href="'.ADMIN_OP.'moderation_news">'._ADMIN_MODERATIONADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'database">'._DATABASEADMIN.'</a></li>
	                            <li><a href="'.ADMIN_OP.'contact">'._ADMIN_MODULE_CONTACT.'</a></li>
	                        </ul>
	<?php
}
?>
                    </div>
                </div>
            </div>
        </div>
        ');?>
<div class='nukelearn-slogan'>
<?php

global $useflags, $currentlang;
echo "<div>"._SELECTGUILANG."";
if ($useflags == 1) {
    $content = "<center>"._SELECTGUILANG."";
    $langdir = dir("language");
    while($func=$langdir->read()) {
	if(substr($func, 0, 5) == "lang-") {
	    $menulist .= "$func ";
	}
    }
    closedir($langdir->handle);
    $menulist = explode(" ", $menulist);
    sort($menulist);
    for ($i=0; $i < sizeof($menulist); $i++) {
	if(!empty($menulist[$i])) {
	    $tl = str_replace("lang-","",$menulist[$i]);
	    $tl = str_replace(".php","",$tl);
	    $altlang = ucfirst($tl);
	    echo "<a href=\"index.php?newlang=$tl&page=".base64_encode(CurrentURL())."\"><img src=\"images/language/flag-$tl.png\" border=\"0\" alt=\"$altlang\" title=\"$altlang\" hspace=\"3\" vspace=\"3\"></a> ";
	}
    }
    echo "</div>";
} else {
    echo "<div align=\"center\">";
    echo "<form onsubmit=\"this.submit.disabled='true'\" action=\"index.php\" method=\"get\"><select name=\"newlanguage\" onchange=\"top.location.href=this.options[this.selectedIndex].value\">";
    $handle = opendir('language');
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
	if($languageslist[$i]!="") {
	  echo "<option value=\"index.php?newlang=".$languageslist[$i]."\" ";
	    if($languageslist[$i]==$currentlang) $content .= " selected";
	    echo ">".ucfirst($languageslist[$i])."</option>\n";
	}
    }
  echo "</select>
      <input type='hidden' name='page' value='".CurrentURL()."' />
  </form></div>";
}

echo('
<hr>
                <a href="'.ADMIN_OP.'about_us" class="colorbox"><img src="images/icon/cursor.png">'._ABOUTNUKELEARN.'</a>
                <a href="'.ADMIN_OP.'Logs"><img src="images/icon/lightbulb.png">'._SYSREP.'</a>
                <a  href="'.ADMIN_OP.'phpinfoDIV" class="colorbox"><img src="images/icon/lightbulb.png">'._SERVERINFO.'</a>
               ');
echo ('
</div> 
</div>
</div>
</center>
    '); 
   }
}
function admin_block($content){
	$tmpl_file = "".INCLUDES_ACP."style/temp/blocks.tpl";
	$thefile = implode("", file($tmpl_file));
	$thefile = addslashes($thefile);
	$thefile = "\$r_file=\"".$thefile."\";";
	eval($thefile);
	print $r_file;
}
//====Open BOX Syle ---
if (!function_exists(OpenTable)) {
	function OpenTable() {
?>
<center>
	<table  align="center" class="box_wrapper" style="width:98%">
		<tr>
			<td>
<?php
}
}
if (!function_exists(CloseTable)) {
	function CloseTable() {
?>     	                                         
			</td>
		</tr>
	</table>
</center>
<?php                        
}
}
if (!function_exists(OpenTable2)) {
	function OpenTable2() {
	echo "<div class=\"opentable\"><div style='border:1px solid black'>";
}
}
if (!function_exists(CloseTable2)) {
	function CloseTable2() {
	echo "</div></div>";
}
}
?>