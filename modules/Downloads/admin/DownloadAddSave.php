<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/
$pagetitle = _DOWNLOADSADMIN;
$numrows = $db->sql_numrows($db->sql_query("SELECT url FROM ".$prefix."_nsngd_downloads WHERE url='$url'"));
if ($numrows>0) {
show_error(_ERRORURLEXIST);
} else {
  if ($title=="" || $url=="" || $description=="") {
    @include("header.php");
    title($pagetitle);
    adminmain();
    echo "<br>\n";
    OpenTable();
    if($title=="") { echo "<center><font class='content'><b>"._ERRORNOTITLE."</b></center><br>"; }
    if($url=="") { echo "<center><font class='content'><b>"._ERRORNOURL."</b></center><br>"; }
    if($description=="") { echo "<center><font class='content'><b>"._ERRORNODESCRIPTION."</b></center><br>"; }
    echo "<center>"._GOBACK."</center>";
    CloseTable();
    @include("footer.php");
  }
  $title = stripslashes(FixQuotes($title));
  $url = stripslashes(FixQuotes($url));
  $description = stripslashes(FixQuotes($description));
  $sname = stripslashes(FixQuotes($sname));
  $email = stripslashes(FixQuotes($email));
  $sub_ip = $_SERVER['REMOTE_ADDR'];
  // USV Build 3 -- Source and Password for Downloads by Hamed -- Begin 24/09/09
  $source = stripslashes(FixQuotes($source));
  $password = stripslashes(FixQuotes($password));
  
// USV BUILD 9 -- Tags -- This is the power of OOP
		$tag->add_tags($tags);
		$tag_ids = $tag->get_tag_ids($tags);
//----------------------------------------------

  if ($submitter == "") { $submitter = $aname; }
  // USV Build 3 -- Source and Password for Downloads by Hamed -- Begin 24/09/09 : vars added '$password','$source'
  $db->sql_query("INSERT INTO ".$prefix."_nsngd_downloads 
  (lid,cid,sid, title  , url , description  ,date ,name , email, hits  , submitter, sub_ip , filesize , version, homepage ,active , password ,source,tags)
  VALUES (NULL, '$cat', '$perm', '$title', '$url', '$description', now(), '$sname', '$email', '$hits', '$submitter', '$sub_ip', '$filesize', '$version', '$homepage', '1','$password','$source','$tag_ids')");

  // USV Build 3 -- Source and Password for Downloads by Hamed -- End
  echo "<br><center><font class='option'>"._NEWDOWNLOADADDED."<br><br>";
  echo "[ <a href='".$admin_file.".php?op=Downloads'>"._DOWNLOADSADMIN."</a> ]</center><br><br>";
  if ($new==1) {
    $result = $db->sql_numrows($db->sql_query("SELECT * FROM ".$prefix."_nsngd_accesses WHERE username='$sname'"));
    if ($result < 1) {
      $db->sql_query("INSERT INTO ".$prefix."_nsngd_accesses VALUES ('$sname', 0, 1)");
    } else {
      $db->sql_query("UPDATE ".$prefix."_nsngd_accesses SET uploads=uploads+1 WHERE username='$submitter'");
    }
    $db->sql_query("DELETE FROM ".$prefix."_nsngd_new WHERE lid='$lid'");
    if ($email!="") {
      $subject = ""._YOURDOWNLOADAT." $sitename";
      $message = ""._HELLO." $sname:\n\n"._DL_APPROVEDMSG."\n\n"._TITLE.": $title\n"._URL.": $url\n"._DESCRIPTION.": $description\n\n\n"._YOUCANBROWSEUS." $nukeurl/modules.php?name=$module_name\n\n"._THANKS4YOURSUBMISSION."\n\n$sitename "._TEAM."";
      $from = "$sitename";
      @mail($email, $subject, $message, "From: $from\nX-Mailer: PHP/" . phpversion());
    }
  }
  if($xop == "DownloadNew") { $zop = $xop; } else { $zop = "Downloads"; }
  header("Location: ".$admin_file.".php?op=".$zop);
}

?>