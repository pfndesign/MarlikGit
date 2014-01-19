<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2005 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}

$content = "<form onSubmit=\"this.submit.disabled='true'\" action=\"modules.php?name=Search\" method=\"post\">";
$content .= "<br><center><input type=\"text\" name=\"query\"  style='width:70%;height:25px'>&nbsp;";
$content .= "<input type=\"submit\" value=\""._SEARCH."\"></center></form><br>";

?>