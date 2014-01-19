<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$db->sql_query("UPDATE ".$prefix."_nsngd_downloads SET active='0' WHERE lid='$lid'");
Header("Location: ".$admin_file.".php?op=Downloads&min=$min");

?>