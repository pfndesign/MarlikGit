<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$db->sql_query("DELETE FROM ".$prefix."_nsngd_mods WHERE lid='$lid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngd_mods");
$db->sql_query("DELETE FROM ".$prefix."_nsngd_downloads WHERE lid='$lid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngd_downloads");
Header("Location: ".$admin_file.".php?op=DownloadBroken");

?>