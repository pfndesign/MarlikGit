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


if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }
 
if (is_user($user)){
 if (is_active("phpBB3")) {
if ($username == $owner_username) {
//-------- USER SUDO LOVE $ HATE ONES -----------//

$phpROW = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM " . USERS_TABLE . " WHERE username = '$owner_username' "));

						$sql = 'SELECT z.*, u.username, u.username_clean
							FROM ' . ZEBRA_TABLE . ' z, ' . USERS_TABLE . ' u
							WHERE z.user_id = ' . $phpROW["user_id"] . '
								AND u.user_id = z.zebra_id';
						
						$result = $db->sql_query($sql);
						$numff = $db->sql_numrows($result);
						
					
							echo "<div class='ucp_block_header'>دوستان و دشمنان</div><br>";

							
							if (!empty($numff)) {	
						while ($row = $db->sql_fetchrow($result))
						{
							if ($row['friend'])
							{
						$friends .= "
						<tr><td style='width:32px;'><img src='".avatar_me($row['username'])."' style='width:32px;height:32px;border:2px solid white;'></td>
						<td><a href='modules.php?name=Your_Account&op=userinfo&username=".$row['username']."'  style='color:green;'>".sql_quote($row['username'])."</a></td>
						</tr>";
						}
						if ($row['foe'])
							{
						$foes .=  "
						<tr><td style='width:32px;'><img src='".avatar_me($row['username'])."' style='width:32px;height:32px;border:2px solid white;'></td>
						<td><a href='modules.php?name=Your_Account&op=userinfo&username=".$row['username']."'  style='color:red;'>".sql_quote($row['username'])."</a></td>
						</tr>";
							}
						
						}
							
					echo "<div style='width:100%;text-align:right;height:150px;overflow:auto;'><table><tr>
					$friends<hr>$foes
					</tr></table></div>";
					}
$db->sql_freeresult($result);

echo "<hr><br><br><a href='modules.php?name=phpBB3&file=ucp&i=zebra' class='button' >افزودن دوست یا دشمن </a><br><br>";
}
}
}

?>