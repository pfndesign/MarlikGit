<?php

/********************************************************/
/* NSN GR Downloads                                     */
/* By: NukeScripts Network (webmaster@nukescripts.net)  */
/* http://www.nukescripts.net                           */
/* Copyright © 2000-2005 by NukeScripts Network         */
/********************************************************/

$pagetitle = _CATEGORIESADMIN;
$categoryinfo = getcategoryinfo($cid);
@include("header.php");
title(_CATEGORIESADMIN);
DLadminmain();
echo "<br>\n";
OpenTable();
echo "<center>\n";
echo "<b>"._EZTHEREIS." ".$categoryinfo['categories']." "._EZSUBCAT." "._EZATTACHEDTOCAT."</b><br>\n";
echo "<b>"._EZTHEREIS." ".$categoryinfo['downloads']." "._DOWNLOADS." "._EZATTACHEDTOCAT."</b><br>\n";
echo "<br><b>"._DELEZDOWNLOADSCATWARNING."</b><br><br>\n";
echo "[ <a href='".$admin_file.".php?op=CategoryDeleteSave&amp;cid=$cid'>"._YES."</a> | <a href='".$admin_file.".php?op=Categories'>"._NO."</a> ]\n";
CloseTable();
@include("footer.php");

?>