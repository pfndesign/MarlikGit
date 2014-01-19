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

global $sitename;
//EVERYWHERE
define("_GETZIPALT","Click here to download our link!");
define("_RESOURCES","Site Resource's");
//SIDEBLOCKS
define("_BLOCKTITLE","Link back to<br /><b>$sitename</b>");
define("_CLICKTOVIEW","<a href=\"modules.php?name=Link_To_Us\">Click here to view<br />all of our buttons.</a>");
define("_BLOCKRESOURCES","Resources");
//CENTERBLOCKS
define("_CLICKTOVIEWBIG","<a href=\"modules.php?name=Link_To_Us\">Click here to view all of our banners.</a>");
//MODULES
define("_SMALLBUTTONS","<b>Here is a collection of some of our smaller link to buttons.</b>");
define("_MEDIUMBUTTONS","<b>Here is a collection of some of our medium size link to buttons.</b>");
define("_LARGEBUTTONS","<b>Here is a collection of some of our full size banners.</b>");
define("_TEXTEXPLAIN","Copy and paste the html code into your website page.");
define("_ZIPEXPLAIN","Click the image for a conveniant zip with the button.<br />If it is a flash link click the link under it for the zip.");

//Admin
global $czlset;
define("_MAINMENU","Main Menu");
define("_RESOURCES","Resources");
define("_MYLINKS","Site links");
define("_BACKTOADMIN","Back to main admistration");
define("_RESOURCENAME","Resource Name");
define("_RESOURCEIMAGE","Resource Image");
define("_RESOURCESTATUS","Resource Status");
define("_EDITRESOURCE","Edit Resource");
define("_ACTIVATERES","Activate Resources");
define("_ADDRESOURCE","Add a new Resource.");
define("_RESOURCEURL","Resource URL");
define("_MYLINKSNAME","Link Name");
define("_MYLINKSIMAGE","Link Image URL");
define("_MYLINKSIMAGEUPLOAD","Link Image Upload");
define("_MYLINKSMOUSEOVER","When mouse over link");
define("_MYLINKSMOUSEOVEREXPLAIN","<br /><small>Only works when <b>NOT</b> using the zip method.</small>");
define("_MYLINKSIMAGEHTMLEXPLAIN","<br /><small>Right click and save your image. Copy and paste the above html into a text document and save. Zip it up and upload it here.</small>");
define("_MYLINKSSTATUS","Link Status");
define("_MYLINKSSIZE","Image Size");
define("_RESOURCESIZE","Image Size");
define("_MYLINKSURL","Site Link URL");
define("_MYLINKSZIPURL","ZIP URL");
define("_MYLINKSHITS","Downloaded");
define("_MYLINKSZIP","Zip File");
define("_ADDMYLINK","Add Link");
define("_VIEWIMAGE","View Image");
define("_VIEWSWF","View Flash");
define("_ACTION","Action");
define("_ACTIVE","Active");
define("_WHICHONE","");
define("_NOTACTIVE","Not Active");
define("_NORESOURCESYET","You don't have any Resources yet!");
define("_NOMYLINKSYET","You don't have any site links yet!");
define("_EDITMYLINKS","Edit Site Link");
define("_ADDMYLINKS","Add a Site Link");
define("_AREYOUSUREDELRESOURCE","Are you sure you want to delete this resource?");
define("_AREYOUSUREDELMYLINK","Are you sure you want to delete this site link?");
define("_NOTHINGUPLOADED","There was an error uploading make sure the file <b>$czlset[path]</b> is set chmod 777. Then try again.");
define("_NOTHINGUPLOADEDZIP","There was an error uploading make sure the file <b>$czlset[zippath]</b> is set chmod 777. Then try again.");
define("_ERRORDELETINGIMAGE","There was an error deleting the image you will have to do it manually.");
define("_ERRORDELETINGZIP","There was an error deleting the zip file you will have to do it manually.");
define("_MISSINGZIPS","<b>There are some site links that do not have zip files available for them. Below is a list. Please make sure that you add a zip file if your using the zip option otherwise they won't know how to link to you. After you have added the zip file then change the configuration to use zip's.</b>");
define("_ADDZIPMYLINKS","Add Your Zip Link");
define("_EDITZIPMYLINKS","Edit Your Zip Link");
define("_MYLINKSIMAGEHTML","Place in text file");
define("_MYLINKSZIPUPLOAD","Change zip file");
define("_PATHTOFILES","Path to images");
define("_PATHTOZIPFILES","Path to zip files");
define("_PATHTORESFILES","Path to resource images");
define("_PATHTOFILES2","<br /><small>(Default is usually best.)</small>");
define("_HOWMANY","How many shown");
define("_ZIPORTEXT","Zip or text for user");
define("_ZIP","Zip");
define("_TEXT","Text");
define("_SCROLLDIRECTION","Scroll");
define("_SCROLLHEIGHT","Scroll height");
define("_SCROLLDELAY","Scroll delay(speed)");
define("_SCROLLORDER","Order By");
define("_OTHERSIZE","Other size");
define("_WIDTHHEIGHT","Width <b>x</b> Height");
define("_WIDTH","Width");
define("_HEIGHT","Height");
define("_MYLINKSSWFSIZE","Flash dimensions");
define("_MOUSEROVERALPHA","Mouse over alpha script");
define("_YES","Yes");
define("_NO","No");
define("_MAINCONFIG","Main Configuration");
define("_MYLINKSSET","Site Links");
define("_RESOURCESSET","Site Resources");
define("_MODULESETTINGS","Module Settings");
define("_MISSINGDATA","Missing data!");
define("_SUBMIT","Submit");
define("_ADMINCZLINKTOUS","CZLink Us Admin");
define("_CLICKHERECZLINKTOUSD","Click here to download our link!");
?>