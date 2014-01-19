<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright � 2000-2005 by NukeScripts Network         */
/********************************************************/

if (!isset($min)) { $min = 0; }
$title = stripslashes(FixQuotes($title));
$url = stripslashes(FixQuotes($url));
$description = stripslashes(FixQuotes($description));
$name = stripslashes(FixQuotes($name));
$email = stripslashes(FixQuotes($email));
  // USV Build 3 -- Source and Password for Downloads by Hamed -- Begin 24/09/09
  $source = stripslashes(FixQuotes($source));
  $password = stripslashes(FixQuotes($password));
  // USV Build 3 -- Source and Password for Downloads by Hamed -- End
 // USV BUILD 9 -- Tags -- This is the power of OOP
		$tag->add_tags($tags);
		$tag_ids = $tag->get_tag_ids($tags);
//----------------------------------------------
$db->sql_query("UPDATE ".$prefix."_nsngd_downloads SET cid='$cat', sid='$perm', title='$title', url='$url', description='$description', name='$name', email='$email', hits='$hits', filesize='$filesize', version='$version', homepage='$homepage',password='$password',source='$source',tags='$tag_ids' WHERE lid='$lid'");
Header("Location: ".$admin_file.".php?op=Downloads&min=$min");

?>