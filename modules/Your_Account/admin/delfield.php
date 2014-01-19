<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {
    $pagetitle = ": "._USERADMIN." - "._DELFIELD;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN." - "._DELFIELD);
    amain();
    echo "<br>\n";
    OpenTable();
  	echo "<center><table border='0'>\n";
    echo "<form action='".ADMIN_OP."delFieldConf' method='post'>\n";
    echo "<tr><td>"._CONFIRMDELLFIELD." $fid?</td></tr>";
	echo "\n";
	echo "<tr><td align='center'><input type='hidden' name='fid' value='$fid'><input type='submit' value='"._DELFIELD."'></td></tr>\n";
    echo "</form>\n";
    echo "<form action='".ADMIN_OP."addField' method='post'>\n";
    echo "<tr><td align='center'><input type='submit' value='"._CANCEL."'></td></tr>\n";
    echo "</form>\n";
    echo "</table>\n";
    CloseTable();
    include("footer.php"); 
}

?>