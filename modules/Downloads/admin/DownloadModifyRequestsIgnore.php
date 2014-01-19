<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$db->sql_query("DELETE FROM ".$prefix."_nsngd_mods WHERE rid='$rid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngd_mods");
Header("Location: ".$admin_file.".php?op=DownloadModifyRequests");

?>