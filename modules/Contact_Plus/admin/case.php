<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                      */
/*                                                                                             */
/* Copyright (c) 2002 by Francisco Burzi                                  */
/* http://phpnuke.org                                                              */
/*                                                                                             */
/* NukeStyles Contact Plus v2.0                                             */
/* Copyright (c) 2003 by Shawn Archer                                   */
/* http://www.nukestyles.com                                                */
/*                                                                                            */
/* NukeStyles Contact Plus v2.2                                            */
/* Copyright (c) 2004 by Praine                                               */
/* http://prian.dyndns.org                                                       */
/*                                                                                            */
/* NS Contact Plus v2.3                                                         */
/* Copyright (c) 2005 by Rustin Phares                                   */
/* homepage: http://www.nuave.com                                   */
/***********************************************************************/
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

global $admin_file;
if (!stristr($_SERVER['SCRIPT_NAME'], "".$admin_file.".php")) { die ("Access Denied"); }
$module_name = "Contact_Plus";
include_once("modules/$module_name/admin/language/lang-".$currentlang.".php");

switch($op) {

    case "contact":
    case "showinfo":
    case "Add_Contact_Address":
    case "Add_Contact_US":
    case "contact_us_edit":
    case "contact_us_modify":
    case "contact_us_add":
    case "contact_us_delete":
    include("modules/$module_name/admin/index.php");
    break;

}

?>