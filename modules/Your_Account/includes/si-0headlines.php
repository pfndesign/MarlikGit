<?php

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
global $hid;
   if ($my_headlines == 1 AND $username == $owner_username) {
    echo "<br>";

    echo "<div class='ucp_block_header'>"._MYHEADLINES."</div><br>"
	.""._SELECTASITE."<br><br>"
	."<form action=\"modules.php?name=$module_name&op=userinfo&username=".$userinfo['username']."\" method=\"post\">"
	."<input type=\"hidden\" name=\"bypass\" value=\"$bypass\">"
	."<input type=\"hidden\" name=\"url\" value=\"0\">"
	."<select name=\"hid\" onChange='submit()'>\n"
	."<option value=\"0\">"._SELECTASITE2."</option>";

	$listheadlines = explode("\r\n",$ya_config['headlines']);
	for ($i=1; $i < count($listheadlines); $i++) {
	if ($hid == $i OR $_COOKIE['headline']==$listheadlines[$i] ) {
	    $sel = "selected";
	} else {
	    $sel = "";
	}
	echo "<option value=\"$i\" $sel>".$listheadlines[$i]."</option>\n";
    }
    echo "</select></form><br><br>"
	.""._ORTYPEURL."<br><br>"
	."<form action=\"modules.php?name=$module_name&op=userinfo&username=".$userinfo['username']."\" method=\"post\">"
	."<input type=\"hidden\" name=\"bypass\" value=\"$bypass\">"
	."<input type=\"hidden\" name=\"hid\" value=\"0\">"
	."<input type=\"text\" dir='ltr' name=\"url\" size=\"30\" maxlength=\"200\" value=\"http://\"><br><br>"
	."<input type=\"submit\" value=\""._GO."\"></form>"
	."<br><br>";
    if ($hid != 0 OR ($hid == 0 AND $url != "0" AND $url != "http://") AND $url != "") {
	if ($hid != 0) {

	$listheadlines = explode("\r\n",$ya_config['headlines']);
	for ($i=0; $i < count($listheadlines); $i++) {
		if ($hid==$i) {
	    $url = $listheadlines[$i];
	    $siteurl = str_replace("http://", "", $url);
		$nsitename = $siteurl;
	    $title = strip_tags($nsitename, "nohtml");
		}
	}
	} else {
	    if (!preg_match("_http://_", $url)) {
		$url = "http://$url";
	    }
	    $siteurl = str_replace("http://", "", $url);
	    $siteurl = explode("/", $siteurl);
	    $title = "http://$siteurl[0]";
	}
	
    }else {
    	$url = $_COOKIE['headline'];
    }
	
 // You must include this PHP block in your template once
 // The required settings for Magpie
 define('MAGPIE_CACHE_DIR', 'includes/RSS/cache');
 define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
 // include the main file
 require_once('includes/RSS/rss_fetch.inc');

 if (!empty($url)) {

$content ="<hr><div id='SharedRss'><img src='images/blocks/top.gif' >$url<br><br>

"; 
 // maximum number of items displayed
 $maxitems = 10;
 // This part displays the shared items feed
 $rss = fetch_rss($url);
 $countitems = 1;
 foreach ($rss->items as $item ) {
 // get title
 $posttitle = $item["title"];
 // trim the title, if it's too long
 if (strlen($showtitle) > 30) $showtitle = substr($showtitle, 0, 49) . ' ...';
 $posturl = $item["link_"];
$siteurl = $item["link"];
 $sitename = $item["title_"];
 // adjust the output format, if desired (otherwise style via CSS)
 $content .= "<li><a href=\"http://".$siteurl."\" > $posttitle</a></li>";
 //$content .= '<span>';
//$content .= '<br /> from <a title="' . $sitename . '" href="' . $siteurl . '" rel="external">' . $sitename . '</a>';

 $countitems += 1;
 if ($countitems > $maxitems) break;
 }

 $content .="<br><a href=\"http://".$url."\" rel=\"external\"><img src='images/blocks/rss.gif' title='"._RSS." '><b>"._RSSUSV_MORELINK."</b></a>

</div>";
 
 echo $content;
 //setcookie to save the chosen one 
 setcookie("headline", $url, time()+3600);  /* expire in 1 hour */
  	
 }
   
   }

?>