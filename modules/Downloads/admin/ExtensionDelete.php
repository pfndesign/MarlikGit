<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$eid = intval($eid);
$db->sql_query("DELETE FROM ".$prefix."_nsngd_extensions WHERE eid='$eid'");
$db->sql_query("OPTIMIZE TABLE ".$prefix."_nsngd_extensions");
Header("Location: ".$admin_file.".php?op=Extensions&min=$min");

?>