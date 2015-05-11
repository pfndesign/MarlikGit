<?php

/**

*

* @package Downloads Functions														

* @version $Id: functions.php 12:48 AM 1/21/2010 Aneeshtan $						

* @copyright (c) Marlik Group  http://www.MarlikCMS.com											

* @license http://opensource.org/licenses/gpl-license.php GNU Public License

*

*/



function of_group($gid) {

    global $prefix, $db, $user, $admin, $cookie;

    /*if (is_admin($admin)) {

        return 1;

    } else*/if (is_user($user)) {

        cookiedecode($user);

        $guid = $cookie[0];

        $currdate = time();

        $ingroup = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngr_users WHERE gid='$gid' AND uid='$guid' AND (edate>'$currdate' OR edate='0')"));

        if ($ingroup > 0) { return 1; }

    }

    return 0;

}



global $admin_file;

if(empty($admin_file)) { $admin_file= "admin"; }



function myimage($imgfile) {

    global $module_name;

    $ThemeSel = get_theme();

    if (file_exists("themes/$ThemeSel/images/downloads/$imgfile")) {

        $myimage = "themes/$ThemeSel/images/downloads/$imgfile";

    } else {

        $myimage = "modules/$module_name/images/$imgfile";

    }

    return($myimage);

}

function gdget_configs(){

    global $prefix, $db;

    $configresult = $db->sql_query("SELECT config_name, config_value FROM ".$prefix."_nsngd_config");

    while (list($config_name, $config_value) = $db->sql_fetchrow($configresult)) {

        $config[$config_name] = $config_value;

    }

    return $config;

}

function gdsave_config($config_name, $config_value){

    global $prefix, $db;

    $db->sql_query("UPDATE ".$prefix."_nsngd_config SET config_value='$config_value' WHERE config_name='$config_name'");

}

function CrawlLevelR($parentid) {

    global $prefix, $db, $crawler;

    $bresult = $db->sql_query("SELECT parentid FROM ".$prefix."_nsngd_categories WHERE cid='$parentid' ORDER BY title");

    while(list($parentid2)=$db->sql_fetchrow($bresult)){

        array_push($crawler,$parentid2);

        CrawlLevelR($parentid2);

    }

    return $crawler;

}

function CrawlLevel($cid) {

    global $prefix, $db, $crawled;

    $bresult = $db->sql_query("SELECT cid FROM ".$prefix."_nsngd_categories WHERE parentid='$cid' ORDER BY title");

    while(list($cid2)=$db->sql_fetchrow($bresult)){

        array_push($crawled,$cid2);

        CrawlLevel($cid2);

    }

    return $crawled;

}

function CoolSize($size) {

    $mb = 1024*1024;

    $gb = $mb*1024;

    if ( $size > $gb ) {

        $mysize = sprintf ("%01.2f",$size/$gb)." "._GB;

    } elseif ( $size > $mb ) {

        $mysize = sprintf ("%01.2f",$size/$mb)." "._MB;

    } elseif ( $size >= 1024 ) {

        $mysize = sprintf ("%01.2f",$size/1024)." "._KB;

    } else {

        $mysize = $size." "._BYTES;

    }

    return $mysize;

}

function CoolDate($date) {

    global $dl_config;

    $mydate = date ($dl_config['dateformat'], strtotime ("$date"));

    return $mydate;

}

function getcategoryinfo($catID){

    global $prefix, $db, $user;

    $category = array($catID);

    $cats_detected = 0;

    $downloads_detected = 0;

    while(count($category) != 0){

        sort($category, SORT_STRING);

        reset($category);

        $curr_category = end($category);

        $dresult = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads WHERE cid='$curr_category'");

        $catdownloads = $db->sql_numrows($dresult);

        $downloads_detected += $catdownloads;

        $cresult = $db->sql_query("SELECT cid FROM ".$prefix."_nsngd_categories WHERE parentid='$curr_category'");

        while (list($cid) = $db->sql_fetchrow($cresult)){

            array_unshift($category, "$cid");

            $cats_detected++;

        }

        array_pop($category);

    }

    $categoryinfo['categories'] = $cats_detected;

    $categoryinfo['downloads'] = $downloads_detected;

    return $categoryinfo;

}

function getparent($parentid,$title) {

    global $prefix,$db;

    $result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories WHERE cid='$parentid'");

    $cidinfo = $db->sql_fetchrow($result);

    if ($cidinfo['title'] != "") $title = $cidinfo['title']." -> ".$title;

    if ($cidinfo['parentid'] != 0) { $title=getparent($cidinfo['parentid'], $title); }

    return $title;

}

function getparentlink($parentid,$title) {

    global $prefix, $db, $module_name;

    $parentid = intval($parentid);

    $cidinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories WHERE cid=$parentid"));

    if ($cidinfo['title'] != "") $title = "<a href=modules.php?name=$module_name&amp;cid=".$cidinfo['cid'].">".$cidinfo['title']."</a> -&gt; ".$title;

    if ($cidinfo['parentid'] != 0) { $title = getparentlink($cidinfo['parentid'],$title); }

    return $title;

}

function restricted($perm) {

    global $db, $prefix, $module_name;

    if ($perm == 1) {

        $who_view = _DL_USERS;

    } elseif ($perm == 2) {

        $who_view = _DL_ADMIN;

    } elseif ($perm >2) {

        $newView = $perm - 2;

        list($who_view) = $db->sql_fetchrow($db->sql_query("SELECT gname FROM ".$prefix."_nsngr_groups WHERE gid=$newView"));

        $who_view = $who_view." "._DL_ONLY;

    }

    $myimage = myimage("restricted.png");

    echo "<center><img src='$myimage'></center><br>\n";

    echo "<center>"._DL_DENIED."!</center><br>\n";

    echo "<center>"._DL_CANBEDOWN." $who_view</center><br>\n";

    echo "<center>"._GOBACK."</center>\n";

}

function restricted2($perm) {

    global $db, $prefix, $module_name;

    if ($perm == 1) {

        $who_view = _DL_USERS;

    } elseif ($perm == 2) {

        $who_view = _DL_ADMIN;

    } elseif ($perm >2) {

        $newView = $perm - 2;

        list($who_view) = $db->sql_fetchrow($db->sql_query("SELECT gname FROM ".$prefix."_nsngr_groups WHERE gid=$newView"));

        $who_view = $who_view." "._DL_ONLY;

    }

    echo "<center>"._DL_DENIED."!<br>\n";

    echo ""._DL_CANBEVIEW."<br><b>$who_view</b></center>\n";

}

function newdownloadgraphic($datetime, $time) {

    global $module_name;

    echo "&nbsp;";

    setlocale (LC_TIME, $locale);

    ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);

    $datetime = strftime(""._LINKSDATESTRING."", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));

    $datetime = ucfirst($datetime);

    $startdate = time();

    $count = 0;

    while ($count <= 14) {

        $daysold = date("d-M-Y", $startdate);

        if ("$daysold" == "$datetime") {

            $myimage = myimage("new_01.png");

            if ($count<=1) { echo "<img align='middle' src='$myimage' alt='"._NEWTODAY."' title='"._NEWTODAY."'>"; }

            $myimage = myimage("new_03.png");

            if ($count<=3 && $count>1) { echo "<img align='middle' src='$myimage' alt='"._NEWLAST3DAYS."' title='"._NEWLAST3DAYS."'>"; }

            $myimage = myimage("new_07.png");

            if ($count<=7 && $count>3) { echo "<img align='middle' src='$myimage' alt='"._NEWTHISWEEK."' title='"._NEWTHISWEEK."'>"; }

            $myimage = myimage("new_14.png");

            if ($count<=14 && $count>7) { echo "<img align='middle' src='$myimage' alt='"._NEWLAST2WEEKS."' title='"._NEWLAST2WEEKS."'>"; }

        }

        $count++;

        $startdate = (time()-(86400 * $count));

    }

}

function newcategorygraphic($cat) {

    global $prefix, $db, $module_name;

    $cat = intval($cat);

    $newresult = $db->sql_query("SELECT date FROM ".$prefix."_nsngd_downloads WHERE cid=$cat ORDER BY date DESC LIMIT 1");

    list($time)=$db->sql_fetchrow($newresult);

    echo "&nbsp;";

    setlocale (LC_TIME, $locale);

    ereg ("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})", $time, $datetime);

    $datetime = strftime(""._LINKSDATESTRING."", mktime($datetime[4],$datetime[5],$datetime[6],$datetime[2],$datetime[3],$datetime[1]));

    $datetime = ucfirst($datetime);

    $startdate = time();

    $count = 0;

    while ($count <= 14) {

        $daysold = date("d-M-Y", $startdate);

        if ("$daysold" == "$datetime") {

            $myimage = myimage("new_01.png");

            if ($count<=1) { echo "<img align='middle' src='$myimage' alt='"._DCATNEWTODAY."' title='"._DCATNEWTODAY."'>"; }

            $myimage = myimage("new_03.png");

            if ($count<=3 && $count>1) { echo "<img align='middle' src='$myimage' alt='"._DCATLAST3DAYS."' title='"._DCATLAST3DAYS."'>"; }

            $myimage = myimage("new_07.png");

            if ($count<=7 && $count>3) { echo "<img align='middle' src='$myimage' alt='"._DCATTHISWEEK."' title='"._DCATTHISWEEK."'>"; }

            $myimage = myimage("new_14.png");

            if ($count<=14 && $count>7) { echo "<img align='middle' src='$myimage' alt='"._DCATLAST2WEEKS."' title='"._DCATLAST2WEEKS."'>"; }

        }

        $count++;

        $startdate = (time()-(86400 * $count));

    }

}

function popgraphic($hits) {

    global $module_name, $dl_config;

    $hits = intval($hits);

    $myimage = myimage("popular.png");

    if ($hits >= $dl_config['popular']) { echo "&nbsp;<img align='middle' src='$myimage' alt='"._POPULAR."' title='"._POPULAR."'>"; }

}

function DLadminmain() {

	GraphicAdmin();

    global $admin_file, $module_name, $prefix, $db, $textcolor1, $bgcolor1, $bgcolor2;

    $brokendownloads = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_mods WHERE brokendownload='1'"));

    $modrequests = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_mods WHERE brokendownload='0'"));

    $newdownloads = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_new"));

    OpenTable();

    ?><style type="text/css">.button{line-height:20px;}</style>    <?php

    echo "<table align='center' border='0' cellpadding='2' cellspacing='2' width='100%' >\n";

    echo "<tr>\n";

    echo "<td align='center' width='25%'><b>"._DOWNLOADS."</b><hr></td>\n";

    echo "<td align='center' width='25%'><b>"._CATEGORIES."</b><hr></td>\n";

    echo "<td align='center' width='25%'><b>"._EXTENSIONS."</b><hr></td>\n";

    echo "<td align='center' width='25%'><b>"._OTHERS."</b><hr></td>\n";

    echo "</tr>\n";

    echo "<tr align='right'>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DownloadAdd'>"._ADDDOWNLOAD."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=CategoryAdd'>"._ADDCATEGORY."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=ExtensionAdd'>"._ADDEXTENSION."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DLConfig'>"._DOWNCONFIG."</a></td>\n";

    echo "</tr>\n";

    echo "<tr align='right'>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=Downloads'>"._DOWNLOADSLIST."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=Categories'>"._CATEGORIESLIST."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=Extensions'>"._EXTENSIONSLIST."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php'>"._MAINADMIN."</a></td>\n";

    echo "</tr>\n";

    echo "<tr align='right'>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DownloadCheck'>"._VALIDATEDOWNLOADS."</a></td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=CategoryTransfer'>"._CATTRANS."</a></td>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DownloadBroken'>"._BROKENREP."</a> ($brokendownloads)</td>\n";

    echo "</tr>\n";

    echo "<tr align='right'>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=FilesizeCheck'>"._VALIDATESIZES."</a></td>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DownloadModifyRequests'>"._MODREQUEST."</a> ($modrequests)</td>\n";

    echo "</tr>\n";

    echo "<tr align='right'>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'>&nbsp;</td>\n";

    echo "<td  width='25%'><a class='button'  href='".$admin_file.".php?op=DownloadNew'>"._WAITINGDOWNLOADS."</a> ($newdownloads)</td>\n";

    echo "</tr>\n";

    echo "</table>\n";

    CloseTable();

}

function convertorderbyin($orderby) {

    if ($orderby == "titleA") $orderby = "title ASC";

    if ($orderby == "dateA") $orderby = "date ASC";

    if ($orderby == "hitsA") $orderby = "hits ASC";

    if ($orderby == "titleD") $orderby = "title DESC";

    if ($orderby == "dateD") $orderby = "date DESC";

    if ($orderby == "hitsD") $orderby = "hits DESC";

    return $orderby;

}

function convertorderbytrans($orderby) {

    if ($orderby == "hits ASC") $orderbyTrans = _POPULARITY1;

    if ($orderby == "hits DESC") $orderbyTrans = _POPULARITY2;

    if ($orderby == "title ASC") $orderbyTrans = _TITLEAZ;

    if ($orderby == "title DESC") $orderbyTrans = _TITLEZA;

    if ($orderby == "date ASC") $orderbyTrans = _DDATE1;

    if ($orderby == "date DESC") $orderbyTrans = _DDATE2;

    return $orderbyTrans;

}

function convertorderbyout($orderby) {

    if ($orderby == "title ASC") $orderby = "titleA";

    if ($orderby == "date ASC") $orderby = "dateA";

    if ($orderby == "hits ASC") $orderby = "hitsA";

    if ($orderby == "title DESC") $orderby = "titleD";

    if ($orderby == "date DESC") $orderby = "dateD";

    if ($orderby == "hits DESC") $orderby = "hitsD";

    return $orderby;

}

//1.1.3 +  FUNCTIONS -----------------


function menu($maindownload) {

    global $module_name;

 //   $myimage = myimage("logo.png");

 //   echo "<center><a href='modules.php?name=$module_name'><img src='$myimage' border='0' alt='' title=''></a></center><br>\n";

    SearchForm();

    echo "<br><center><font class='content'>[ ";

    if ($maindownload>0) { echo "<a href='modules.php?name=$module_name'>"._DOWNLOADSMAIN."</a> | "; }

    echo "<a href='modules.php?name=Submit_Downloads'>"._DL_ADD."</a>";

    echo " | <a href='modules.php?name=$module_name&amp;op=NewDownloads'>"._NEW."</a>";

    echo " | <a href='modules.php?name=$module_name&amp;op=MostPopular'>"._POPULAR."</a>";

    echo " ]</font></center>\n";





}

function SearchForm() {

    global $module_name, $query;

    echo "<table border='0' cellspacing='0' cellpadding='0' style='text-align:center;width:95%;'>\n";

    echo "<form action='modules.php?name=$module_name&amp;op=search' method='POST'>\n";

    echo "<tr><td><font class='content'>

    <input type='text' size='35' name='query' id='query' value='$query'>

    <input type='submit' value='"._DL_SEARCH."'><br></td></tr>\n";

    echo "</form>\n";

    echo "</table>\n";

}

function showlisting($lid) {

    global $admin_file, $module_name, $admin, $db, $prefix, $user, $dl_config;

    $lid = intval($lid);

    $result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads WHERE lid=$lid");

    $lidinfo = $db->sql_fetchrow($result);



 /*   $priv = $lidinfo['sid'] - 2;

    if (($lidinfo['sid'] == 0) || ($lidinfo['sid'] == 1 AND is_user($user))  || ($lidinfo['sid'] == 2 AND is_admin($admin)) || ($lidinfo['sid'] > 2 AND of_group($priv)) || $dl_config['show_download'] == '1') {

  */

       $lidinfo['title'] = stripslashes($lidinfo['title']);

        $lidinfo['description'] = stripslashes($lidinfo['description']);

//$nimg = newdownloadgraphic($datetime, $lidinfo['date']);

//$pimg = popgraphic($lidinfo['hits']);

if ( strlen($lidinfo['description']) > 70) $description = substr($lidinfo['description'], 0, 300) . '[ ...]-[..]';



      

        if ($lidinfo['sid'] == 0) {

            $who_view = _DL_ALL;

        } elseif ($lidinfo['sid'] == 1) {

            $who_view = _DL_USERS;

        } elseif ($lidinfo['sid'] == 2) {

            $who_view = _DL_ADMIN;

        } elseif ($lidinfo['sid'] == 3) {

            $who_view = "<span style='color:red;font-size:13px;'>"._SUBSCRIBERS." </span>";

        } elseif ($lidinfo['sid'] >3) {

            $newView = $lidinfo['sid'] - 3;

            list($who_view) = $db->sql_fetchrow($db->sql_query("SELECT gname FROM ".$prefix."_nsngr_groups WHERE gid=$newView"));

            $who_view = $who_view." "._DL_ONLY;

        }

        

        if ($lidinfo['sid'] == 0 || $lidinfo['sid'] == 1  || $lidinfo['sid'] == 2  || is_admin($admin)) {

        	$dl_butt =  "<a href='modules.php?name=$module_name&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($lidinfo['title'])."'><input type='button' value='"._DOWNLOAD." '

        	 onclick='javascript:location.href=\"modules.php?name=$module_name&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($lidinfo['title'])."\"'></a>";

        }else {

        	$dl_butt = $who_view ; 

        }



      $mydate = $lidinfo['date'];

      $date = explode(" ", $mydate);



   echo "<a href='modules.php?name=$module_name&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($lidinfo['title'])."'><b>".$lidinfo['title']."</b></a>
<p>
$description
</p>

	<p  style='clear:both;padding:10px;'><small>$dl_butt "._DOWNLOADS."(".$lidinfo['hits'].") -".$nimg. "-".$pimg.$who_view. hejridate($date[0], 1,3) . "";
        echo "<a href='mailto:".$lidinfo['email']."'>".$lidinfo['name']."</a></small></p>\n";
        echo "<hr>\n";

 }

function showresulting($lid) {

    global $admin_file, $module_name, $admin, $db, $prefix, $user, $dl_config;

    $lid = intval($lid);

    $lidinfo = $db->sql_fetchrow($db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads WHERE lid=$lid"));

    OpenTable();

    $priv = $lidinfo['sid'] - 2;

    if (($lidinfo['sid'] == 0) || ($lidinfo['sid'] == 1 AND is_user($user))  || ($lidinfo['sid'] == 2 AND is_admin($admin)) || ($lidinfo['sid'] > 2 AND of_group($priv)) || $dl_config['show_download'] == '1') {

        $lidinfo['title'] = stripslashes($lidinfo['title']);

        $lidinfo['description'] = stripslashes($lidinfo['description']);

        if (is_admin($admin)) {

            $myimage = myimage("edit.png");

            echo "<a href='".$admin_file.".php?op=DownloadModify&amp;lid=$lid' target='$lid'><img align='middle' src='$myimage' border='0' alt='"._DL_EDIT."' title='"._DL_EDIT."'></a>&nbsp;";

        } else {

            $myimage = myimage("show.png");

            echo "<img align='middle' src='$myimage' border='0' alt='' title=''>&nbsp;";

        }

        echo "<a href='modules.php?name=$module_name&amp;op=getit&amp;lid=$lid&amp;title=".Slugit($lidinfo['title'])."'><b>".$lidinfo['title']."</b></a>";

        newdownloadgraphic($datetime, $lidinfo['date']);

        popgraphic($lidinfo['hits']);

        echo "<br>\n";

        if ($lidinfo['sid'] == 0) {

            $who_view = _DL_ALL;

        } elseif ($lidinfo['sid'] == 1) {

            $who_view = _DL_USERS;

        } elseif ($lidinfo['sid'] == 2) {

            $who_view = _DL_ADMIN;

        } elseif ($lidinfo['sid'] >2) {

            $newView = $lidinfo['sid'] - 2;

            list($who_view) = $db->sql_fetchrow($db->sql_query("SELECT gname FROM ".$prefix."_nsngr_groups WHERE gid=$newView"));

            $who_view = $who_view." "._DL_ONLY;

        }

        echo "<b>"._DL_PERM.":</b> $who_view<br>\n";

        echo "<b>"._VERSION.":</b> ".$lidinfo['version']."<br>\n";

        echo "<b>"._FILESIZE.":</b> ".CoolSize($lidinfo['filesize'])."<br>\n";

		$mydate = $lidinfo['date'];

	    $date = explode(" ", $mydate);

        echo "<b>"._ADDEDON.":</b> " . hejridate($date[0], 1) . "<br>\n";

        echo "<b>"._DOWNLOADS.":</b> ".$lidinfo['hits']."<br>\n";

        echo "<b>"._HOMEPAGE.":</b> ";

        if ($lidinfo['homepage'] == "" || $lidinfo['homepage'] == "http://") {

            echo _DL_NOTLIST."<br>\n";

        } else {

            echo "<a href='".$lidinfo['homepage']."' target='new'>".$lidinfo['homepage']."</a><br>\n";

        }

        $result2 = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_categories WHERE cid='".$lidinfo['cid']."'");

        $cidinfo = $db->sql_fetchrow($result2);

        $cidinfo['title'] = "<a href=modules.php?name=$module_name&amp;cid=".$lidinfo['cid'].">".$cidinfo['title']."</a>";

        $cidinfo['title'] = getparentlink($cidinfo['parentid'], $cidinfo['title']);

        echo "<b>"._CATEGORY.":</b> ".$cidinfo['title']."\n";

    } else {

        restricted2($lidinfo['sid']);

    }

    CloseTable();

}

function pagenums_admin($op, $totalselected, $perpage, $max) {

    global $admin_file;

    $pagesint = ($totalselected / $perpage);

    $pageremainder = ($totalselected % $perpage);

    if ($pageremainder != 0) {

        $pages = ceil($pagesint);

        if ($totalselected < $perpage) { $pageremainder = 0; }

    } else {

        $pages = $pagesint;

    }

    if ($pages != 1 && $pages != 0) {

        $counter = 1;

        $currentpage = ($max / $perpage);

        echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>\n";

        echo "<tr><form action='".$admin_file.".php' method='post'>\n";

        echo "<td align='right'><b>"._DL_SELECTPAGE.": </b><select name='min' onChange='top.location.href=this.options[this.selectedIndex].value'>\n";

        while ($counter <= $pages ) {

            $cpage = $counter;

            $mintemp = ($perpage * $counter) - $perpage;

            if ($counter == $currentpage) {

                echo "<option selected>$counter</option>\n";

            } else {

                echo "<option value='".$admin_file.".php?op=$op&amp;min=$mintemp&amp;orderby=";

                if ($op > "" ) { echo "&amp;op=$op"; }

                if ($query > "") { echo "&amp;query=$query"; }

                if (isset($cid)) { echo "&amp;cid=$cid"; }

                echo "'>$counter</option>\n";

            }

            $counter++;

        }

        echo "</select><b> "._DL_OF." $pages "._DL_PAGES."</b></td>\n</form>\n</tr>\n";

        echo "</table>\n";

    }

}

function pagenums($cid, $query, $orderby, $op, $totalselected, $perpage, $max,$tag='') {

    global $module_name;

    $pagesint = ($totalselected / $perpage);

    $pageremainder = ($totalselected % $perpage);

    if ($pageremainder != 0) {

        $pages = ceil($pagesint);

        if ($totalselected < $perpage) { $pageremainder = 0; }

    } else {

        $pages = $pagesint;

    }

    if ($pages != 1 && $pages != 0) {

        $counter = 1;

        $currentpage = ($max / $perpage);

        echo "<table border='0' cellpadding='2' cellspacing='2' width='100%'>\n";

        echo "<tr><form action='modules.php?name=$module_name' method='post'>\n";

        echo "<td align='right'><b>"._DL_SELECTPAGE.": </b><select name='min' onChange='top.location.href=this.options[this.selectedIndex].value'>\n";

        while ($counter <= $pages ) {

            $cpage = $counter;

            $mintemp = ($perpage * $counter) - $perpage;

            if ($counter == $currentpage) {

                echo "<option selected>$counter</option>\n";

            } else {

                echo "<option value='modules.php?name=$module_name";

                if ($op > "" ) { echo "&amp;op=$op"; }

                if ($query > "") { echo "&amp;query=$query"; }

                if (!empty($tag)) { echo "&amp;term=$tag"; }

                if (isset($cid)) { echo "&amp;cid=$cid"; }

                echo "&amp;min=$mintemp&amp;orderby='>$counter</option>\n";

            }

            $counter++;

        }

        echo "</select><b> "._DL_OF." $pages "._DL_PAGES."</b></td>\n</form>\n</tr>\n";

        echo "</table>\n";

    }

}

function menu_cats(){

global $db,$admin,$user,$admin_file;

echo '<a href="'.MLink.'">'._MAIN.'</a> <hr>';

if (is_user($user)) {

if (is_active('Submit_Downloads')) {

echo '<br><a href="modules.php?name=Submit_Downloads">'._ADDNEWDOWNLOAD.'</a> <hr>';

}

}elseif (is_superadmin($admin)) {

echo '<br><a href="'.$admin_file.'.php?op=DownloadAdd">'._ADDNEWDOWNLOAD.'</a> <hr>';

}else {

}

if (is_superadmin($admin)) {

echo '<br><a href="'.$admin_file.'.php?op=CategoryAdd">'._ADDCATEGORY.'</a> <hr>';

}

$result = $db->sql_query("SELECT cid,title FROM ".DOWNLOAD_CAT_TABLE." ORDER BY title");

while (list($cid,$title)=$db->sql_fetchrow($result)) {

$title = sql_quote($title);

$cid = sql_quote(intval($cid));

echo "<a href='".MLink."&cid=$cid'>$title</a><hr>";

}

}

function cats_desc(){

global $db;

echo _DOWNLOADS_WELCOME;

$result = $db->sql_query("SELECT cid,title,cdescription FROM ".DOWNLOAD_CAT_TABLE." ORDER BY title");

while (list($cid,$title,$description)=$db->sql_fetchrow($result)) {

$cid = sql_quote(intval($cid));

$title = sql_quote($title);

$description = stripslashes(check_words(check_html($description, "")));

echo "<a href='".MLink."&cid=$cid'>$title</a><br>

$description<br><br>";

}

}

function showroom($cid){

global $prefix,$db,$dl_config,$module_name;

require_once(PATH.'public/showroom.php');

}

function showroom_block($cid,$order){

global $db;

$order = sql_quote($order);

if ($order == 'date') {

$block_title = _DOWNLOADS_TOPFILES;

}else{

$block_title = _DOWNLOADS_MOSTPOP;

}

OpenTable();

echo '<h3>'.$block_title.' »</h3> <hr>';

$result = $db->sql_query("SELECT lid,title,hits  FROM ".DOWNLOAD_TABLE." WHERE cid='$cid' ORDER BY $order DESC limit 10 ");

while (list($lid,$title,$hits)=$db->sql_fetchrow($result)) {

$title = sql_quote($title);

$lid = sql_quote(intval($lid));

$hit = sql_quote(intval($hit));

echo "<a href='".MLink."&op=getit&lid=$lid'>$title</a> <br>

$hits "._HITS."<hr>";

}

CloseTable();

}

function showroom_title($cid){

global $db;

if (empty($cid) ) {

$title = _MAIN;

}else {



$result = $db->sql_query("SELECT title FROM ".DOWNLOAD_CAT_TABLE." WHERE cid='$cid' ORDER BY title");

list($title)=$db->sql_fetchrow($result);

$title = sql_quote($title);

$cid = sql_quote(intval($cid));

}

return "<a href='".MLink."&cid=$cid'>$title</a>";

}

function count_tags($tag_id_ex){

global $db;

$result = $db->sql_query("SELECT tags FROM ".DOWNLOAD_TABLE." WHERE FIND_IN_SET($tag_id_ex, REPLACE(tags, ' ', ','))");

$tag_count = $db->sql_numrows($result);



return $tag_count ;

}

function menu_tags(){

global $db,$prefix;



OpenTable();

$content = _DOWNLOADS_MOSTPOPTAGS;



$result = $db->sql_query("SELECT d.tags,t.*,

		group_concat(DISTINCT t.tid ) as mytagsID,

		group_concat(DISTINCT t.tag ) as mytags,

		group_concat(DISTINCT t.slug ) as tagslug

		FROM ".DOWNLOAD_TABLE." AS d 

		LEFT JOIN ".TAGS_TABLE." AS t ON FIND_IN_SET(t.tid, REPLACE(d.tags, ' ', ','))

		WHERE active>'0' ");

	while($row = $db->sql_fetchrow($result)){

		$tags_i = ($row['tid'] == ' ') ? '' : explode(",",$row['mytagsID']);

		$tags_t = ($row['tags'] == ' ') ? '' : explode(",",$row['mytags']);

		$tags_s = ($row['tags'] == ' ') ? '' : explode(",",$row['tagslug']);

		for ($i=0; $i<sizeof($tags_t) AND $i<sizeof($tags_s) AND $i<sizeof($tags_i); $i++)

		{

			if (!empty($tags_t[$i])) {

			$content .="<a href='".MLink."&op=tags&term=".$tags_s[$i]."'>

			$tags_t[$i]<img src='images/icon/bullet_star.png' height='16px' width='16px' alt='"._HITS."' title='"._HITS."'>[".count_tags($tags_i[$i])."]</a><hr>";

			}

		}

	}

	echo $content;

	CloseTable();

}



?>