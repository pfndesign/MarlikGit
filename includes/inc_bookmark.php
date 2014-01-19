<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Nukelearn Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

###############################################################################
# nukeSEO Social Bookmarking Copyright (c) 2006 Kevin Guske  http://nukeSEO.com
###############################################################################
# This program is free software. You can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License.
###############################################################################

//if(!defined('ADMIN_FILE') and !defined('MODULE_FILE')) { header("Location: ../../index.php");  die(); }

function getBookmarkHTML($mynukeurl, $mynuketitle, $separator = "&nbsp;", $imgsize = "small")
{
###############################################################################
# Comment out, add and / or resort the $bookmarks array as desired.  Bookmark
# sites will be displayed in the order they appear in the $bookmarks array and
# all bookmarking sites in the array will be displayed.
###############################################################################

$bookmarks_IMG = "images/share/";
$bookmarks = array ();
$bookmarks["Blinklist"] = array (
                                        "siteurl"        => "http://blinklist.com/index.php?Action=Blink/addblink.php&amp;Description={MYNUKETITLE}&amp;Url={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."blinklist_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."blinklist_l.png",
                                        "imgalt"        => ""._OB_SENDTOBLINKLIST.""
                                );
$bookmarks["Del.icio.us"] = array (
                                        "siteurl"        => "http://del.icio.us/post?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."del.icio.us_sm.png",
                                        "siteimglg"        => "".$bookmarks_IMG."delicious_l.png",
                                        "imgalt"        => ""._OB_SENDTODEL.""
                                );
$bookmarks["Digg"] = array (
                                        "siteurl"        => "http://digg.com/submit?phase=2&amp;url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."digg_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."digg_l.png",
                                        "imgalt"        => ""._OB_SENDTODIGG.""
                                );
$bookmarks["Furl"] = array (
                                        "siteurl"        => "http://furl.net/storeIt.jsp?t={MYNUKETITLE}&amp;u={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."furl_sm.png",
                                        "siteimglg"        => "".$bookmarks_IMG."furl_l.png",
                                        "imgalt"        => ""._OB_SENDTOFURL.""
                                );
$bookmarks["Reddit"] = array (
                                        "siteurl"        => "http://reddit.com/submit?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."reddit_sm.png",
                                        "siteimglg"        => "".$bookmarks_IMG."reddit_l.png",
                                        "imgalt"        => ""._OB_SENDTOREDDIT.""
                                );
$bookmarks["Technorati"] = array (
                                        "siteurl"        => "http://technorati.com/cosmos/search.html?url={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."technorati_sm.png",
                                        "siteimglg"        => "".$bookmarks_IMG."technorati_l.png",
                                        "imgalt"        => ""._OB_SENDTOTECHNORATI.""
                                );
$bookmarks["YahooMyWeb"] = array(
                                        "siteurl"        => "http://myweb2.search.yahoo.com/myresults/bookmarklet?u={MYNUKEURL}&amp;t={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."yahoomyweb_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."yahoo_l.png",
                                        "imgalt"        => ""._OB_SENDTOYAHOOMYWEB.""
                                );
$bookmarks["Cloob"] = array(
                                        "siteurl"        => "http://www.cloob.com/share/link/add?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."cloob_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."cloob_l.gif",
                                        "imgalt"        => ""._OB_SENDTOCLOOB.""
                                );
$bookmarks["Balatarin"] = array(
                                        "siteurl"        => "https://balatarin.com/links/submit?phase=2&amp;url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."balatarin_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."balatarin_l.gif",
                                        "imgalt"        => ""._OB_SENDTOBALATARIN.""
                                );
$bookmarks["Donbaleh"] = array(
                                        "siteurl"        => "https://donbaleh.com/submit.php?url={MYNUKEURL}&amp;subject={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."donbaleh_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."donbaleh_l.png",
                                        "imgalt"        => ""._OB_SENDTODONBALEH.""
                                );
$bookmarks["Mohandes"] = array(
                                        "siteurl"        => "http://www.mohand.es/submit?phase=1&amp;url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."mohandes_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."mohandes_l.gif",
                                        "imgalt"        => ""._OB_SENDTOMOHANDES.""
                                );
$bookmarks["Stumbleupon"] = array(
                                        "siteurl"        => "http://www.stumbleupon.com/submit?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."stumbleupon_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."stumbleupon_l.png",
                                        "imgalt"        => ""._OB_SENDTOSTUMBLE.""
                                );
$bookmarks["Netvouz"] = array(
                                        "siteurl"        => "http://www.netvouz.com/action/submitBookmark?url={MYNUKEURL}&amp;title={MYNUKETITLE}&amp;popup=no",
                                        "siteimgsm"        => "".$bookmarks_IMG."netvouz_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."netvouz_l.png",
                                        "imgalt"        => ""._OB_SENDTONETVOUZ.""
                                );
$bookmarks["Friendfeed"] = array(
                                        "siteurl"        => "http://friendfeed.com/share?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."friendfeed_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."friendfeed_l.png",
                                        "imgalt"        => ""._OB_SENDTOFRIENDFEED.""
                                );
$bookmarks["Twitter"] = array(
                                        "siteurl"        => "http://twitthis.com/twit?url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."twitter_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."twitter_l.png",
                                        "imgalt"        => ""._OB_SENDTOTWITTER.""
                                );
$bookmarks["Facebook"] = array(
                                        "siteurl"        => "http://www.facebook.com/sharer.php?u={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."facebook_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."facebook_l.png",
                                        "imgalt"        => ""._OB_SENDTOFACEBOOK.""
                                );
$bookmarks["Simpy"] = array(
                                        "siteurl"        => "http://www.simpy.com/simpy/LinkAdd.do?href={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."simpy_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."simpy_l.png",
                                        "imgalt"        => ""._OB_SENDTOSIMPY.""
                                );
$bookmarks["Live"] = array(
                                        "siteurl"        => "https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&url={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."live_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."live_l.png",
                                        "imgalt"        => ""._OB_SENDTOLIVE.""
                                );
$bookmarks["Google"] = array(
                                        "siteurl"        => "http://www.google.com/bookmarks/mark?op=edit&bkmk={MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."google_sm.jpg",
                                        "siteimglg"        => "".$bookmarks_IMG."google_l.png",
                                        "imgalt"        => ""._OB_SENDTOGOOGLE.""
                                );
$bookmarks["Yahoo"] = array(
                                        "siteurl"        => "ymsgr:im?msg={MYNUKETITLE} - {MYNUKEURL}",
                                        "siteimgsm"        => "".$bookmarks_IMG."yahoom_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."yahoom_l.png",
                                        "imgalt"        => ""._OB_SENDTOYMASSENGER.""
                                );
$bookmarks["AddThis"] = array(
                                        "siteurl"        => "http://www.addthis.com/bookmark.php?pub=web3socialbookmark&amp;url={MYNUKEURL}&amp;title={MYNUKETITLE}",
                                        "siteimgsm"        => "".$bookmarks_IMG."addthis_sm.gif",
                                        "siteimglg"        => "".$bookmarks_IMG."addthis_l.png",
                                        "imgalt"        => ""._OB_SENDTOADDTHIS.""
                                );
###############################################################################
# You do not need to modify anything below this line
###############################################################################
        $bookmarkHTML = "";
        $mynukeurl = str_replace('&amp;', '&', $mynukeurl);
        $mynukeurl = htmlentities(urlencode($mynukeurl));
        $mynuketitle = str_replace('&amp;', '&', $mynuketitle);
        $mynuketitle = urlencode($mynuketitle);
        $numBookmarks = count($bookmarks);
        $numkey = 0;
        foreach ($bookmarks as $sitename => $sitedetails)
        {
                $siteurl = $sitedetails['siteurl'];
                $siteurl = str_replace("{MYNUKEURL}", $mynukeurl, $siteurl);
                $siteurl = str_replace("{MYNUKETITLE}", $mynuketitle, $siteurl);
                $imgalt = $sitedetails['imgalt'];
                $bookmarkHTML .= "<a href=\"$siteurl\" title=\"$imgalt\" target=\"_blank\">";
                if ($imgsize == "small") {
                        $siteimg = $sitedetails['siteimgsm'];
                } else {
                        $siteimg = $sitedetails['siteimglg'];
                }
                if ($imgsize == "text") {
                        $bookmarkHTML .= "$sitename";
                } else {
                        # XHTML fix courtesy of Guardian - http://code-authors.com
                        $bookmarkHTML .= "<img border=\"0\" src=\"$siteimg\" title=\"$imgalt\" alt=\"$imgalt\" />";
                }
                $bookmarkHTML .= "</a>";
                $numkey = $numkey + 1;
                if ($numkey < $numBookmarks) $bookmarkHTML .= "$separator";
        }
        return $bookmarkHTML;
}
?>