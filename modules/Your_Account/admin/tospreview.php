<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1))
{
	global $db, $prefix;
    $pagetitle = ": "._USERADMIN." - "._EDITTOS;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN." - "._EDITTOS);
    amain();
    echo "<br />\n";
    OpenTable();
	// REQUEST INFO FROM DATABASE FOR MASTER ARTICLE
	$result = $db->sql_query("SELECT data FROM ".$prefix."_cnbya_tos WHERE id='$id'");
	list($cbyatos) = $db->sql_fetchrow($result);
	echo ("$cbyatos");
	CloseTable();
	include("footer.php");
}

?>