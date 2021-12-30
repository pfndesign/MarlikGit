<?php

/**
 *
 * @package comprehensive statistics											
 * @version $Id:  12:36 PM 4/8/2011 Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */

global $db, $admin, $trackip, $startdate, $prefix;

#-------------------Configuration -------------------------
if ($currentlang == "persian") {
    define("_numbers_format_Lng", "FA"); /// Change it into EN if u like to have numbers in english format;
} else {
    define("_numbers_format_Lng", "EN");
}
define("_Stories", true);
define("_Accounts", true);
define("_Comments", true);
define("_Downloads", true);
define("_Blogs", true);
define("_Onlines", true);
define("_Visits", true);
define("_alexaRank", false);
define("_googleRank", false);
define("_StartDate", true);
define("_SHOW_ONLINES_LIST_M", true); //Show online guests 
define("_SHOW_ONLINES_LIST_G", true); //Show online members 
define('GOOGLE_MAGIC', 0xE6359A60);

define('_LATESTUSERONLINE', true);
define('_LATESTUSERONLINELIST', true);
define('_NUM2SHOWLU', 3);
define('_ICON_STAT', 'images/icon/bullet_arrow_down.png');

#############################################################

include_once(INCLUDES_PATH . "inc_statistics.php");
$analytics = new statistics();
$analytics->_data();

if (_Stories == true) {
    $content .= '<img src="' . _ICON_STAT . '"><a href="modules.php?name=News">' . _STORIES_NUM . ' : </a><b>' . $analytics->FilterThisStat($analytics->countData['totalposts']) . '</b><br>';
}
if (_Comments == true) {
    $content .= '<img src="' . _ICON_STAT . '">' . _COMMENTS_NUM . ': <b>' . $analytics->FilterThisStat($analytics->countData['totalcomm']) . '</b><br>
';
}
if (_Downloads == true) {
    $content .= '<img src="' . _ICON_STAT . '"><a href="modules.php?name=Downloads">' . _DOWNSLOADS_NUM . ' :
</a> <b>' . $analytics->FilterThisStat($analytics->countData['totalfiles']) . '</b><br>';
}

if (_Accounts == true) {
    $content .= '<a href="modules.php?name=Your_Account&op=memberlist"><img src="' . _ICON_STAT . '">' . _ACCOUNTS_NUM . ': 
</a>
<b>' . $analytics->FilterThisStat($analytics->countData['userCount']) . '</b><br>';
}
if (_Visits == true) {
    if ($trackip == 1) {
        $content .= '
<img src="' . _ICON_STAT . '">' . _VIEWS_TODAY . ': <b>' . $analytics->FilterThisStat($analytics->countDataIPT['tv']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _VIEWS_YEST . ': <b>' . $analytics->FilterThisStat($analytics->countDataIPT['yv']) . '</b><br>

<img src="' . _ICON_STAT . '">' . _VISITS_TODAY . ' : <b>' . $analytics->FilterThisStat($analytics->countDataIPT['tuv']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _VISITS_YEST . ':<b>' . $analytics->FilterThisStat($analytics->countDataIPT['yuv']) . '</b><br>

<img src="' . _ICON_STAT . '">' . _VISITS_ALL . ': <b>' . $analytics->FilterThisStat($analytics->countData['totalVisits']) . '</b><br>
';
    } else {
        $content .= '
<img src="' . _ICON_STAT . '">' . _VIEWS_TODAY . ': <b>' . $analytics->FilterThisStat($analytics->countData['total_today']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _VIEWS_YEST . ': <b>' . $analytics->FilterThisStat($analytics->countData['total_yesterday']) . '</b><br>
';
    }
    $content .= '
<img src="' . _ICON_STAT . '">' . _VIEWS_ALL . ' : <b>' . $analytics->FilterThisStat($analytics->countData['totalPVisits']) . '</b><br>
';
}
if (_LATESTUSERONLINE == true) {
    $content .= '
<img src="' . _ICON_STAT . '">' . _MEMBERS_TODAY . ': <b>' . $analytics->FilterThisStat($analytics->countData['tusers']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _MEMBERS_YEST . ': <b>' . $analytics->FilterThisStat($analytics->countData['yusers']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _MEMBERS_MONTH . ': <b>' . $analytics->FilterThisStat($analytics->countData['premusers']) . '</b><br>
<img src="' . _ICON_STAT . '">' . _MEMBERS_YEAR . ': <b>' . $analytics->FilterThisStat($analytics->countData['preyusers']) . '</b><br>

';
}
if (_LATESTUSERONLINELIST == true) {
    $content .= '
<img src="' . _ICON_STAT . '">' . _MEMBERS_LATEST . ': <b>' . $analytics->GetLatestUsers(_NUM2SHOWLU) . '</b><br>
';
}



if (_Onlines == true) {
    $content .= '
<img src="' . _ICON_STAT . '">' . _MEMBERS_ONLINE . ':<b>' . $analytics->FilterThisStat($analytics->countData['uonline']) . '</b><br>';

    if (_SHOW_ONLINES_LIST_G == true) {
        $content .= '
<div style="padding: 5px;';
        if ($analytics->countData['uonline'] > 5) {
            $content .= 'height:100px;overflow:auto;';
        };
        $content .= '">
' . $analytics->GetOnlineList('m', 0, 120) . '
</div>
';
    }

    $content .= '<img src="' . _ICON_STAT . '">' . _GUESTZ . ': <b>' . $analytics->FilterThisStat($analytics->countData['gonline']) . '</b><br>';
    if (_SHOW_ONLINES_LIST_M == true) {
        $content .= '
<div style="padding-left: 12px;';
        if ($analytics->countData['gonline'] > 5) {
            $content .= 'height:100px;overflow:auto;';
        };
        $content .= 'direction:rtl;text-align:right;">
' . $analytics->GetOnlineList('g', 0, 120) . '
</div>
';
    }
    $content .= '<img src="' . _ICON_STAT . '">' . _ONLINES . ':<b>' . $analytics->FilterThisStat($analytics->countData['uonline'] + $analytics->countData['gonline']) . '</b><br>
';
}


if (_googleRank == true) {
    $content .= '<img src="' . _ICON_STAT . '">' . _RANK_GOOGLE . ':<span style="color:#000;padding-right:20px;padding-left:20px;border:2px solid #fff;background:#B4D56A;font-weight:bold;width:100px;height:10px;color:#333200">' . $analytics->getPageRank(USV_DOMAIN) . '</span><br>
';
}
if (_alexaRank == true) {
    $content .= '<img src="' . _ICON_STAT . '">' . _RANK_ALEXA . ':<span style="color:#000;padding-right:20px;padding-left:20px;border:2px solid #fff;background:#2FACD2;font-weight:bold;width:100px;height:10px;color:#FFFB00">' . number_format($analytics->alexaRank(USV_DOMAIN)) . '</span><br>';
}
if (_StartDate == true) {
    $content .= '
<img src="' . _ICON_STAT . '">' . _SITE_DAY . ': ' . $startdate . '<br>
';
}
