<?php


/************************************************************************/
/*                    Persian Calendar Class                            */
/*    This program is free software   and Created By:                   */
/* Author Email : haghparast@gmail.com                                  */
/* Published Date: 30 Jan 2006                                          */
/*                                                                      */
/*  Module For PHP-Nuke / PHP-Nuke INP Created by: http://irannuke.com  */
/************************************************************************/
/*                 INP Persian Calendar                                 */
/*         By: Iran Nuke Premium (info@irannuke.com)                    */
/*  http://www.irannuke.com                                             */
/* Copyright © 2003-2005 by Iran Nuke Premium                           */
/* Special Thanks To:                                                   */
/*                 haghparast@gmail.com                                 */
/************************************************************************/
/* INP-Nuke : Expect to be impressed                                    */
/* ===========================                                          */
/*                               COPYRIGHT                              */
/*                                                                      */
/* Copyright (c) 2005 - 2006 by http://www.irannuke.net                 */
/*                                                                      */
/*     Iran Nuke Portal                        (info@irannuke.net)      */
/*                                                                      */
/* Refer to irannuke.net for detailed information on INP-Nuke           */
/************************************************************************/

$author_name = "LombudXa (Rodmar)";
$author_user_email = "";
$author_homepage = "http://www.evolved-systems.net";
$license = "GNU/GPL";
$download_location = "http://www.evolved-systems.net/downloads-cat-21.html";
$module_version = "2.0.0";
$module_description = "Site Map generates a list with useful links from your website";

// DO NOT TOUCH THE FOLLOWING COPYRIGHT CODE. YOU'RE JUST ALLOWED TO CHANGE YOUR "OWN"
// MODULE'S DATA (SEE ABOVE) SO THE SYSTEM CAN BE ABLE TO SHOW THE COPYRIGHT NOTICE
// FOR YOUR MODULE/ADDON. PLAY FAIR WITH THE PEOPLE THAT WORKED CODING WHAT YOU USE!!
// YOU ARE NOT ALLOWED TO MODIFY ANYTHING ELSE THAN THE ABOVE REQUIRED INFORMATION.
// AND YOU ARE NOT ALLOWED TO DELETE THIS FILE NOR TO CHANGE ANYTHING FROM THIS FILE IF
// YOU'RE NOT THIS MODULE'S AUTHOR.

function show_copyright() {
    global $author_name, $author_user_email, $author_homepage, $license, $download_location, $module_version, $module_description;
    if (empty($author_name)) { $author_name = "N/A"; }
    if (empty($author_user_email)) { $author_user_email = "N/A"; }
    if (!empty($author_homepage)) { $homepage = "<a href='$author_homepage' target='_blank'>Author's Homepage</a>"; } else { $homepage = "No Website Available"; }
    if (empty($license)) { $license = "N/A"; }
    if (!empty($download_location)) { $download = "<a href='$download_location' target='_blank'>Module's Download</a>"; } else { $download = "No Download Available"; }
    if (empty($module_version)) { $module_version = "N/A"; }
    if (empty($module_description)) { $module_description = "N/A"; }
    $module_name = basename(dirname(__FILE__));
    $module_name = eregi_replace("_", " ", $module_name);
    echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n"
        ."<html>\n"
        ."<head>\n"
        ."<title>$module_name: Copyright Information</title>\n"
        ."<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>\n"
        ."<style type='text/css'>\n"
        ."<!--";
    echo '
body {
    font-size: 10;
    font-family: Verdana;
    color: black;
    background: lightgray;
}
a {
    font-size: 10;
    font-family: Verdana;
    color: black;
}        
';
    echo "//-->\n"
        ."</style>\n"
        ."</head>\n"
        ."<body>\n"
        ."<center><strong>Module Copyright &copy; Information</strong><br />"
        ."$module_name module for <a href='http://phpnuke.org' target='_blank'>PHP-Nuke</a> / <a href='http://www.irannuke.com' target='_blank'>Irannuke</a><br /><br /></center>\n"
."persian language by  IZONE ( Iranyad.com ) "
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>Module's Name:</strong> $module_name<br />\n"
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>Module's Version:</strong> $module_version<br />\n"
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>Module's Description:</strong> $module_description<br />\n"
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>License:</strong> $license<br />\n"
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>Author's Name:</strong> $author_name<br />\n"
        ."<img src='../../images/arrow.gif' border='0' alt=''>&nbsp;<strong>Author's Email:</strong> $author_user_email<br /><br />\n"
        ."<center>[ $homepage | $download | <a href='javascript:void(0)' onClick='javascript:self.close()'>Close</a> ]</font></center>\n"
        ."</body>\n"
        ."</html>";
}

show_copyright();

?>