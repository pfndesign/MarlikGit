<?php
$key = "ABQIAAAAJI2A0G5gSZoSQfTSxL_QZRR8imW08Ci_ZTHEwKVSJG2O5unZ9RRPvUbe2jWupPFBiPnW1RnerXp3rg"; //Your Google API Key

$content = '
<style type="text/css">
#queryContainer {margin-bottom:2em;width:90%;margin-left:auto;margin-right:auto}
div.introtext {font-size:11px !important;text-align:center;margin-bottom:5px}
#query {border:1px solid silver;width:90%;padding:6px;font-size:13px;font-family:tahoma}
#searchcontrol {width:90%;margin:0px auto;text-align:right;position:relative}
</style>';

$content .= "<script src=\"http://www.google.com/jsapi?key=$key\" type=\"text/javascript\"></script>\n";
$content .= "    <script language=\"Javascript\" type=\"text/javascript\">\n";
$content .= "    //<![CDATA[\n";
$content .= "			   \n";
$content .= "    google.load(\"search\", \"1\");\n";
$content .= "	\n";
$content .= "    function OnLoad() {\n";
$content .= "      	var searchControl = new google.search.SearchControl();\n";
$content .= "		\n";
$content .= "		var webSrearch = new GwebSearch();\n";
$content .= "		webSrearch.setUserDefinedLabel(\"دیگر سایت ها\");\n";
$content .= "		searchControl.addSearcher(webSrearch);\n";
$content .= "	\n";
$content .= "		var siteSearch = new GwebSearch();\n";
$content .= "		siteSearch.setUserDefinedLabel(\"جستجو در $sitename\");\n";
$content .= "		siteSearch.setSiteRestriction(\"".USV_DOMAIN."\");\n";
$content .= "		searchControl.addSearcher(siteSearch);\n";
$content .= "		\n";
$content .= "		var drawOptions = new GdrawOptions();\n";
$content .= "		drawOptions.setDrawMode(GSearchControl.DRAW_MODE_TABBED);\n";
$content .= "		drawOptions.setInput(document.getElementById(\"query\"));\n";
$content .= "		searchControl.draw(document.getElementById(\"searchcontrol\"), drawOptions);\n";
$content .= "		GSearch.getBranding(document.getElementById(\"branding\"));\n";
$content .= "		  	\n";
$content .= "		var query = null;\n";
$content .= "		document.getElementById(\"query\").onkeydown = function(event) { kd(event); };\n";
$content .= "		function kd(e) {\n";
$content .= "		if (!e) e = event;\n";
$content .= "		if (e.keyCode == 27)\n";
$content .= "			searchControl.clearAllResults();\n";
$content .= "		if (query == null)\n";
$content .= "			query = document.getElementById(\"query\");\n";
$content .= "		query.focus();\n";
$content .= "	}\n";
$content .= "      \n";
$content .= "      searchControl.execute(\"\");\n";
$content .= "    }\n";
$content .= "    google.setOnLoadCallback(OnLoad);\n";
$content .= "    //]]>\n";
$content .= "    </script>\n";
$content .= "      \n";
//Call the content
$content .= "<div class=\"introtext\">لذت جستجو در گوگل را با فناوری  آجاکس  داشته باشید </div>\n";
$content .= "	<div id=\"queryContainer\">\n";
$content .= "		  <input type=\"text\" name=\"query\" id=\"query\" /><br />\n";
$content .= "		<div id=\"branding\">Powered By Google</div>\n";
$content .= "   </div>\n";
$content .= "<div id=\"searchcontrol\"></div>\n";

echo $content;
?>