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
/*********************************************************************************/
/* INP-Nuke : Expect to be impressed                                             */
/* ===========================                                                   */
/*                               COPYRIGHT                                       */
/*                                                                               */
/* Copyright (c) 2005 - 2006 by http://www.irannuke.net                          */
/*                                                                               */
/*     Iran Nuke Portal                        (info@irannuke.net)               */
/*                                                                               */
/* Refer to irannuke.net for detailed information on INP-Nuke                    */
/*********************************************************************************/

/********************************************************/
/* COPPA Pluggin sixonetonoffun http://www.netflake.com */
/* Minimal basic COPPA Compliance mod for CNBYA         */
/********************************************************/

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

$coppa=intval($_POST['coppa_yes']);
if (isset($_POST['coppa_yes']) AND $ya_config['coppa'] == intval(1)) {
	$coppa=intval($_POST['coppa_yes']); 
	if($coppa != intval(1)){
		include("header.php");
		title(_USERAPPLOGIN);
		OpenTable();
		echo "<center>"._YACOPPA2."</center>\n";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><font class=\"title\">"._YACOPPA1."</center><P>\n";
		echo "<font color=\"#FF3333\">"._YACOPPA4."</font>\n";
		echo "<font color=\"#FF3333\">"._YACOPPAFAX."</font>\n";
		CloseTable();
		include("footer.php");
	}
}

  $sel1 = "checked";
  $sel2 = "";
  include("header.php");
  title(_USERAPPLOGIN);
  OpenTable();
  echo "<center>"._YACOPPA2."</center>\n";
  CloseTable();
  echo "<br>";
  OpenTable();
  echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\"><tr>\n";
  echo "<form name=\"coppa1\" action=\"modules.php?name=$module_name&op=new_user\" method=\"POST\">\n";
  echo "<td align=\"center\" colspan=\"2\" class=\"title\">"._YACOPPA1."<P></td></tr>\n";
  echo "<tr><td align=\"center\" colspan=\"2\" ><p class=\"content\">"._YACOPPA3."<P></td></tr>\n";
  echo "<tr><td>"._YES."&nbsp;</td><td><input type=\"radio\" name=\"coppa_yes\" value='1' $sel2></td></tr>\n";
  echo "<tr><td>"._NO."&nbsp;</td><td><input type=\"radio\" name=\"coppa_yes\" value='0' $sel1></td></tr>\n";
  echo "<tr><td align=\"center\" colspan=\"2\"><br><input type=\"submit\" value='"._YA_CONTINUE."'>\n";
  echo "</td></form></tr>";
  echo "</table>\n";
  CloseTable();
  include("footer.php");

?>