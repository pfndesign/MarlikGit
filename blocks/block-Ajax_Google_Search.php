<?php
/***************************************************************8***/
/* Clan Themes Google API Block
/* http://www.clanthemes.com
/* http://www.phpnukedownloads.com
/*******************************************************************/
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
/*******************************************************************/
/* Block Configuration                                       	  
/*******************************************************************/

$key = "ABQIAAAAJI2A0G5gSZoSQfTSxL_QZRR8imW08Ci_ZTHEwKVSJG2O5unZ9RRPvUbe2jWupPFBiPnW1RnerXp3rg"; //Your Google API Key
$sitelink ="".USV_DOMAIN.""; //The site you want to search other than Google
/*******************************************************************/
/* End Block Configuration                  
/*
/* Do not edit below this line
/*******************************************************************/

$content = '
<style type="text/css">
#queryContainer {margin-bottom:2em;width:180px!important;margin-left:auto;margin-right:auto}
div.introtext {font-size:11px !important;text-align:center;margin-bottom:5px}
#query {border:1px solid silver;width:160px;padding:6px;font-size:13px;font-family:tahoma}
#searchcontrol {width:90%;margin:0px auto;text-align:right;position:relative}
</style>
';
$content .= "<script src=\"http://www.google.com/jsapi?key=$key\" type=\"text/javascript\"></script>\n";
$content .= "    <script language=\"Javascript\" type=\"text/javascript\">\n";
$content .= "    //<![CDATA[\n";
$content .= "			   \n";
$content .= "    google.load(\"search\", \"1\");\n";
$content .= "	\n";
$content .= "    function OnLoad() {\n";
$content .= "      	// Create a search control\n";
$content .= "      	var searchControl = new google.search.SearchControl();\n";
$content .= "		\n";
$content .= "      	// add a regular web search, with a custom label web\n";
$content .= "		var webSrearch = new GwebSearch();\n";
$content .= "		webSrearch.setUserDefinedLabel(\"The Web\");\n";
$content .= "		searchControl.addSearcher(webSrearch);\n";
$content .= "	\n";
$content .= "		// add a site-limited web search, with a custom label\n";
$content .= "		var siteSearch = new GwebSearch();\n";
$content .= "		siteSearch.setUserDefinedLabel(\"This Site\");\n";
$content .= "		siteSearch.setSiteRestriction(\"$sitelink\");\n";
$content .= "		searchControl.addSearcher(siteSearch);\n";
$content .= "		\n";
$content .= "		// setting the draw mode for the Google search\n";
$content .= "		var drawOptions = new GdrawOptions();\n";
$content .= "		// use tabbed view\n";
$content .= "		drawOptions.setDrawMode(GSearchControl.DRAW_MODE_TABBED);\n";
$content .= "		// set the input field (instead of the default one)\n";
$content .= "		drawOptions.setInput(document.getElementById(\"query\"));\n";
$content .= "		// actually write the needed markup to the page\n";
$content .= "		searchControl.draw(document.getElementById(\"searchcontrol\"), drawOptions);\n";
$content .= "		// set the google logo container\n";
$content .= "		GSearch.getBranding(document.getElementById(\"branding\"));\n";
$content .= "		  	\n";
$content .= "		//add the ESC to clear the box\n";
$content .= "		var query = null;\n";
$content .= "		document.onkeydown = function(event) { kd(event); };\n";
$content .= "		function kd(e) {\n";
$content .= "		// make it work on FF and IE\n";
$content .= "		if (!e) e = event;\n";
$content .= "		// use ESC to clear the search results\n";
$content .= "		if (e.keyCode == 27)\n";
$content .= "			searchControl.clearAllResults();\n";
$content .= "		// get the input field\n";
$content .= "		if (query == null)\n";
$content .= "			query = document.getElementById(\"query\");\n";
$content .= "		// and move the focus in there\n";
//$content .= "		query.focus();\n";
$content .= "	}\n";
$content .= "      \n";
$content .= "	  // Execute an inital search\n";
$content .= "      searchControl.execute(\"\");\n";
$content .= "    }\n";
$content .= "    google.setOnLoadCallback(OnLoad);\n";
$content .= "    //]]>\n";
$content .= "    </script>\n";
$content .= "      \n";
//Call the content
$content .= "<div class=\"introtext\">" . _AJAXSEARCH_ENJOYGOOGLESEARCH . "</div>\n";
$content .= "	<div id=\"queryContainer\">\n";
$content .= "		  <input type=\"text\" name=\"query\" id=\"query\" /><br />\n";
$content .= "		<div id=\"branding\">" . _AJAXSEARCH_POWEREDBY . "</div>\n";
$content .= "   </div>\n";
$content .= "<div id=\"searchcontrol\"></div>\n";


?>