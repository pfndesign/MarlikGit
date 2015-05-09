<?php

/**
*
* @package jquery framework														
* @version $Id: framework.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
//===========================================
//Jquery Core
//===========================================
// THIS IS A PERFECT WAY OF FETCHING JQUERY LIB , BUT NEEDS INTERNETS
//addJSToHead('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', 'file'); 
addJSToHead(SCRIPT_PATH.'jquery.min.js', 'file');
addJSToHead(SCRIPT_SRC_PATH.'jquery.cookie.js', 'file');
//===========================================

//===========================================
//ADMINISTRATION MENU TAB
//===========================================
define("ajaxify_home", "".ADMIN_OP."GraphicAdminM");
if(defined('ADMIN_FILE')) {
addJSToHead(SCRIPT_SRC_PATH .'superfish.js','file');
addJSToHead(SCRIPT_SRC_PATH .'supersubs.js','file');
}
//===========================================
//FACEBOX PLUGIN JQUERY
//===========================================
include_once SCRIPT_PLUGINS_PATH . 'facebox/index.php';

//===========================================
//SOME HANDMADE JQUERY FUNCTIONS
//===========================================
function jq_toggle_box($id,$atb,$box){
echo "<script type=\"text/javascript\">
 $(document).ready(function() {
 // toggles the slickbox on clicking the noted link
  $('$atb#$id').click(function() {
 $('#$box').toggle(400);
 return false;
  });

});
</script>";
}

function jq_show_info($id,$fadein,$fadeout){
echo '<script type="text/javascript"> $(document).ready(function(){$("#'.$id.'").fadeIn('.$fadein.').fadeOut('.$fadeout.');});</script>';
}

?>