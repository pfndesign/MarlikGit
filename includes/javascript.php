<?php

/**
*
* @package javascript														
* @version $Id: javascript.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (stristr(htmlentities($_SERVER['PHP_SELF']), "javascript.php")) {
	Header("Location: ../index.php");
	die();
}

global $name,$admin,$loading ;

//===========================================
//ERROR FINDER
//===========================================
//CHECK IF USV IS INSTALLED OR THERE IS ANY ERROR
/*
if((is_admin($admin)) ){
include("includes/inc_errors.php");
}
*/
//===========================================
//Google Analytics
//===========================================
/*
?>
 <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-XXXXX-X']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
      })();

    </script>
<?php
*/


//===========================================
//AJAX FRAMEWORK
//===========================================
if (file_exists(JAVASCRIPT_PATH."/jquery/framework.php")) {
	include_once(JAVASCRIPT_PATH."/jquery/framework.php");
}

if (defined('ADMINT')) {
	echo "<script type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "function Disab() {\n";
	echo " frm=document.forms['createfirst']\n";
	echo " if(frm.term.checked)\n";
	echo " {frm.Submit.disabled=false}\n";
	echo " else {frm.Submit.disabled=true}\n";
	echo "}\n";
	echo "//-->\n";
	echo "</SCRIPT>\n\n";
}


//===========================================
//LOADING DIV
//===========================================

if ($loading == 1) {
?>
<div ID="waitDiv" style="position:absolute;left:150;top:150;visibility:hidden">
<table cellpadding="6" cellspacing="0" border="0" bordercolor="#000000" align="center"><tr><td><img src="./images/preload.gif" border="0"></td></tr></table></div> 
<script language="javascript" type="text/javascript">
<!--
var DHTML = (document.getElementById || document.all || document.layers);
function ap_getObj(name) {
	if (document.getElementById)
	{ return document.getElementById(name).style; }
	else if (document.all)
	{ return document.all[name].style; }
	else if (document.layers)
	{ return document.layers[name]; }
}
function ap_showWaitMessage(div,flag) {
	if (!DHTML) return;
	var x = ap_getObj(div); x.visibility = (flag) ? 'visible':'hidden'
	if(! document.getElementById) if(document.layers) x.left=280/2; return true; } ap_showWaitMessage('waitDiv', 1);
	//-->
</script>
<?php
}




//===========================================
//Ajax tools
//===========================================
addJSToHead(JAVASCRIPT_PATH.'ajaxtools.js', 'file');




//===========================================
//COPYRIGHT
//=========================================== 
if (defined('MODULE_FILE') AND file_exists("modules/".$name."/copyright.php")) {
	echo "<script type=\"text/javascript\">\n";
	echo "<!--\n";
	echo "function openwindow(){\n";
	echo "   window.open (\"modules/".$name."/copyright.php\",\"Copyright\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=400,height=200\");\n";
	echo "}\n";
	echo "//-->\n";
	echo "</SCRIPT>\n\n";
}


?>