<?php
/**
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV NUKELEARN PORTAL																|
	|	* @version : 1.0.0.219																		|
	|																								|
	|	* @copyright (c) Nukelearn Group															|
	|	* http://www.nukelearn.com																	|
	|																								|
	|	* @Portions of this software are based on PHP-Nuke											|
	|	* http://phpnuke.org - 2002, (c) Francisco Burzi											|
	|																								|
	|	* @license http://opensource.org/licenses/gpl-license.php GNU Public License				|
	|																								|
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
/*\--------------[ BEGIN:  USV-Kralpc.com RSS Block ]---------------\*/
if ( !defined('BLOCK_FILE') ) {
    Header("Location: ../index.php");
    die();
}
global $userinfo;
$content  =  "<div align=\"center\">";
$content  .= "        <table border=\"0\">";
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\"><a target=\"_blank\"  href=\"modules.php?name=News\">" . _RSS_NEWS . "</a></td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=News\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";

if (is_active("phpBB3")) {
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\"><a target=\"_blank\"  href=\"modules.php?name=phpBB3\">" . _BBFORUMS . "</a></td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Forums\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";
}
if (is_active("Downloads")) {
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\"><a target=\"_blank\"  href=\"modules.php?name=Downloads\">" ._RSS_DOWNLOADS . "</a></td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Downloads\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";
}
if (is_active("News")) {
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\">" . _RSS_LASTCOMMENTS . "</td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Comment\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";
}
if (is_active("Page")) {
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\">" . _RSS_ADMINMESSAGES . "</td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Message\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";
}

$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\">" . _RSS_ADMINBLOG . "</td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Blog&username=$userinfo[username]\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";



/*

$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\"><a target=\"_blank\"  href=\"modules.php?name=Content\">" . _RSS_CONTNET . "</a></td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Content\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";
$content  .= "                <tr>";
$content  .= "                        <td align=\"center\" width=\"105\">" . _RSS_EXTRAPAGE . "</td>";
$content  .= "                        <td align=\"center\" width=\"40\">";
$content  .= "                        <a target=\"_blank\"  href=\"feed.php?mod=Extpages\"><img border=\"0\" src=\"images/rss/rss.png\"  title=\"RSS\"></a></td>";
$content  .= "                </tr>";

*/

$content  .= "        </table>";
$content  .= "</div>";
/*\--------------[ END:  USV-Kralpc.com RSS Block ]---------------\*/
?>