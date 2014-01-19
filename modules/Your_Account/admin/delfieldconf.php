<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {

    //$pagetitle = ": "._USERADMIN." - "._ACCTDENY;
    //include("header.php");
    //amain();
    //echo "<br>\n";		echo "tes44te";
    //OpenTable();
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_field WHERE fid='$fid'");
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value WHERE fid='$fid'");
    $db->sql_query("DELETE FROM ".$user_prefix."_cnbya_value_temp WHERE fid='$fid'");
    //CloseTable();
    //include("footer.php");
    Header("Location:".ADMIN_PHP."?op=addField");

}

?>