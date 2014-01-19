<?php
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

global $locale, $oldnum, $storynum, $storyhome, $cookie, $categories, $cat, $prefix, $multilingual, $currentlang, $db, $new_topic, $user_news, $userinfo, $user;

getusrinfo($user);
if ($multilingual == 1) {
    if ($categories == 1) {
    	$querylang = "where (alanguage='$currentlang' OR alanguage='')";
    } else {
    	$querylang = "where (alanguage='$currentlang' OR alanguage='')";
	if ($new_topic != 0) {
	    $querylang .= " AND FIND_IN_SET($cat, REPLACE(associated, '-', ',')) ";
	}
    }
} else {
    if ($categories == 1) {
   	$querylang = "where FIND_IN_SET($cat, REPLACE(associated, '-', ','))";
    } else {
	$querylang = "";
	if ($new_topic != 0) {
	    $querylang = "WHERE FIND_IN_SET($cat, REPLACE(associated, '-', ','))";
	}
    }
}
if (isset($userinfo['storynum']) AND $user_news == 1) {
    $storynum = $userinfo['storynum'];
} else {
    $storynum = $storyhome;
}
$boxstuff = "<table border=\"0\" width=\"100%\">";
$boxTitle = _PASTARTICLES;

$sql = "SELECT sid, title, time, comments FROM ".$prefix."_stories $querylang AND time <= '".date("Y-m-j H:i:s")."'  ORDER BY time DESC LIMIT $storynum, $oldnum";
$result = $db->sql_query($sql);
$vari = 0;

          if (!isset($mode) OR empty($mode)) {
            if(isset($userinfo['umode'])) {
              $mode = $userinfo['umode'];
            } else {
              $mode = "thread";
            }
          }
          if (!isset($order) OR empty($order)) {
            if(isset($userinfo['uorder'])) {
              $order = $userinfo['uorder'];
            } else {
              $order = 0;
            }
          }
          if (!isset($thold) OR empty($thold)) {
            if(isset($userinfo['thold'])) {
              $thold = $userinfo['thold'];
            } else {
              $thold = 0;
            }
          }
$r_options = "";
$r_options .= "&amp;mode=".$mode;
$r_options .= "&amp;order=".$order;
$r_options .= "&amp;thold=".$thold;

  	 $time2 = "";
while ($row = $db->sql_fetchrow($result)) {
    $sid = intval($row['sid']);
    $title = check_html($row['title'], "nohtml");
    $time = $row['time'];
    $comments = intval($row['comments']);
    $see = 1;
	
	$datetime2 = formatTimestamp($time);

    if (isset($articlecomm) AND ($articlecomm == 1)) {
	$comments = "(".$comments.")";
    } else {
	$comments = "";
    }
    if($time2==$datetime2) {
        $boxstuff .= "<tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid$r_options\">$title</a> $comments</td></tr>\n";
    } else {
        if(empty($a)) {
    	    $boxstuff .= "<tr><td colspan=\"2\"><b>$datetime2</b></td></tr><tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid$r_options\">$title</a> $comments</td></tr>\n";
	    $time2 = $datetime2;
	    $a = 1;
	} else {
	    $boxstuff .= "<tr><td colspan=\"2\"><b>$datetime2</b></td></tr><tr><td valign=\"top\"><strong><big>&middot;</big></strong></td><td> <a href=\"modules.php?name=News&amp;file=article&amp;sid=$sid$r_options\">$title</a> $comments</td></tr>\n";
	    $time2 = $datetime2;
	}
    }
    $vari++;
    if ($vari==$oldnum) {
	if (isset($userinfo['storyhome'])) {
	    $storynum = $userinfo['storyhome'];
	} else {
	    $storynum = $storyhome;
	}
	$min = $oldnum + $storynum;
	$dummy = 1;
    }
}

if (isset($articlecomm) AND ($articlecomm == 1)) {
    $boxstuff .= "</table><br><a href=\"modules.php?name=Stories_Archive\"><b>"._OLDERARTICLES."</b></a>\n";
} else {
    $boxstuff .= "</table>";
}

if ((isset($see)) AND ($see == 1)) {
    $content = $boxstuff;
}

?>