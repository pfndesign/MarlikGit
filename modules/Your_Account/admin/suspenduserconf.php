<?php

/*********************************************************************************/
/* CNB Your Account: An Advanced User Management System for phpnuke     		*/
/* ============================================                         		*/
/*                                                                      		*/
/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/
/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/
/*                                                                      		*/
/* Contact author: escudero@phpnuke.org.br                              		*/
/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/
/*                                                                      		*/
/* This program is free software. You can redistribute it and/or modify 		*/
/* it under the terms of the GNU General Public License as published by 		*/
/* the Free Software Foundation; either version 2 of the License.       		*/
/*                                                                      		*/
/*********************************************************************************/
/* CNB Your Account is the official successor of NSN Your Account by Bob Marion	*/
/* INP-Nuke : Expect to be impressed                                             */
/* ===========================                                                   */
/*                               COPYRIGHT                                       */
/*                                                                               */
/* Copyright (c) 2005 - 2006 by http://www.irannuke.net                          */
/*                                                                               */
/*     Iran Nuke Portal                        (info@irannuke.net)               */
/*                                                                               */
/* Refer to i/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    list($email) = $db->sql_fetchrow($db->sql_query("SELECT user_email FROM ".$user_prefix."_users WHERE user_id='$sus_uid'"));
    if ($ya_config['servermail'] == 0) {
        $message = "<p align=\"center\">"._SORRYTO." $sitename "._HASSUSPEND."</p>";
        if ($suspendreason > "") {
            $suspendreason = stripslashes($suspendreason);
            $message .= "\r\n\r\n<p align=\"center\">"._SUSPENDREASON.":\r\n$suspendreason</p>";
        }
        $subject = _ACCTSUSPEND;
        $from  = "From: $adminmail\r\n";
        $from .= "Reply-To: $adminmail\r\n";
        $from .= "Return-Path: $adminmail\r\n";
		$message = FarsiMail($message);
        mail($email, $subject, $message, "From: \"$adminmail\" <$adminmail>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nContent-transfer-encoding: 8bit");
    }
    $db->sql_query("UPDATE ".$user_prefix."_users SET user_level='0', user_active='0' WHERE user_id='$sus_uid'");
    $pagetitle = ": "._USERADMIN." - "._ACCTSUSPEND;
    include("header.php");
    GraphicAdmin();
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><table align='center' border='0' cellpadding='2' cellspacing='2'>\n";
    echo "<form action='".ADMIN_OP."mod_users' method='post'>\n";
    if (isset($query)) { echo "<input type='hidden' name='query' value='$query'>\n"; }
    if (isset($min)) { echo "<input type='hidden' name='min' value='$min'>\n"; }
    if (isset($xop)) { echo "<input type='hidden' name='op' value='$xop'>\n"; }
    echo "<tr><td align='center'><b>"._ACCTSUSPEND."</b></td></tr>\n";
    echo "<tr><td align='center'><input type='submit' value='"._RETURN2."'></td></tr>\n";
    echo "</form>\n";
    echo "</table></center>\n";
    CloseTable();
    include("footer.php");

}

?>