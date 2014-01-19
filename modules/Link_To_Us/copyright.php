<?php
/**************************************************************************/
/* PHP-Nuke INP: Expect to be impressed                                   */
/* ===========================                                            */
/*                               COPYRIGHT                                */
/*                                                                        */
/* Copyright (c) 2003 - 2005 by http://www.irannuke.com                   */
/*                                                                        */
/*     Iran Nuke Premium                         (info@irannuke.com)      */
/*                                                                        */
/* Refer to irannuke.com for detailed information on PHP-Nuke INP         */
/**************************************************************************/
/* Site Links To Us Module for PHP-Nuke                 */
/* Version 2.0 UNIVERSAL 2-04-05                        */
/* By: Telli (telli@codezwiz.com)                       */
/* http://codezwiz.com/                                 */
/* Copyright © 2002-2005 by Codezwiz Network, LLC.      */
/********************************************************/

$author_name = "Telli";
$author_user_email = "telli@codezwiz.com";
$author_homepage = "http://www.codezwiz.com";
$license = "GNU/GPL";
$download_location = "http://www.codezwiz.com/scripts.html";
$module_version = "2.0 Universal";
$module_description = "Link To Us Module & Block";


function show_copyright() {
    global $author_name, $author_user_email, $author_homepage, $license, $download_location, $module_version, $module_description;
    if ($author_name == "") { $author_name = "N/A"; }
    if ($author_user_email == "") { $author_user_email = "N/A"; }
    if ($author_homepage == "") { $author_homepage = "N/A"; }
    if ($license == "") { $license = "N/A"; }
    if ($download_location == "") { $download_location = "N/A"; }
    if ($module_version == "") { $module_version = "N/A"; }
    if ($module_description == "") { $module_description = "N/A"; }
    $module_name = basename(dirname(__FILE__));
    $module_name = eregi_replace("_", " ", $module_name);
    echo "<html>\n"
        ."<body bgcolor=\"#dedede\" link=\"#000000\" alink=\"#000000\" vlink=\"#000000\">\n"
        ."<title>$module_name: Copyright Information</title>\n"
        ."<font size=\"1\" color=\"#000000\" face=\"Verdana, Helvetica\">\n"
        ."<center><b>Module Copyright &copy; Information</b><br>"
        ."<br><br></center>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>Module's Name:</b> $module_name<br>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>Module's Version:</b> $module_version<br>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>Module's Description:</b> $module_description<br>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>License:</b> $license<br>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>Author's Name:</b> $author_name<br>\n"
        ."<img src=\"../../images/arrow.gif\" border=\"0\">&nbsp;<b>Author's Email:</b> $author_user_email<br><br>\n"
        ."<center>[ <a href=\"$author_homepage\" target=\"new\">Author's HomePage</a> | <a href=\"$download_location\" target=\"new\">Module's Download</a> | <a href=\"javascript:void(0)\" onClick=javascript:self.close()>Close</a> ]</center>\n"
        ."</font>\n"
        ."</body>\n"
        ."</html>";
}

show_copyright();

?>