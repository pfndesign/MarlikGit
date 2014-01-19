<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/*                   www.nukelearn.com                                  */
/*                                                                      */
/*                    Farshad Ghazanfari           				        */
/*                                                                      */
/*                    Block-Shamsi-Cal V.1.0.0    	 				    */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header('Location: ../index.php');
    die();
}
$content .= '
<style>
#SharedRss {
width:100%;
margin:0px auto;
text-align:right;
color: black;
font-size: 10pt;
direction:rtl;
line-height:17px;
}
#RSS-Link {
text-align:left;
float:left;
padding-left:10px;
}
</style>
';

 // You must include this PHP block in your template once
 // The required settings for Magpie
 define('MAGPIE_CACHE_DIR', 'includes/RSS/cache');
 define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
 // include the main file
 require_once('includes/RSS/rss_fetch.inc');

$content .="<div id='SharedRss'><img src='images/blocks/top.gif' >" . _RSSUSV_LATESTUPDATES . "<br><br>

"; 

 // Settings (modify as required):
 // your Google Reader shared items feed URL
 $sharedfeedurl = 'http://www.google.com/reader/public/atom/user%2F03807200757240051437%2Fstate%2Fcom.google%2Fbroadcast';
 // the (X)HTML page for your Google Reader shared items
 $sharedpageurl = 'http://www.google.com/reader/shared/nukelearn.com';
 // maximum number of items displayed
 $maxitems = 10;
 // This part displays the shared items feed
 $rss = fetch_rss($sharedfeedurl);
 $countitems = 1;
 foreach ($rss->items as $item ) {
 // get title
 $posttitle = $item["title"];
 // trim the title, if it's too long
 if ( strlen($showtitle) > 30) $showtitle = substr($showtitle, 0, 49) . ' ...';
 $posturl = $item["link_"];
 $siteurl = $item["link_"];
 $sitename = $item["title_"];
 // adjust the output format, if desired (otherwise style via CSS)
 $content .= "<li><a href=".$siteurl." > $posttitle</a></li>";
 //$content .= '<span>';
//$content .= '<br /> from <a title="' . $sitename . '" href="' . $siteurl . '" rel="external">' . $sitename . '</a>';

 $countitems += 1;
 if ($countitems > $maxitems) break;
 }

 $content .="<br><a href=".$sharedpageurl." rel=\"external\"><b>" . _RSSUSV_MORELINK . "</b></a>
 
 <div id='RSS-Link'><a href='$sharedpageurl' target='_blank'><img src='images/blocks/rss.gif' title='" . _RSSUSV_SHAREDLINKS . "'></div>
</div>";

 
 ?>