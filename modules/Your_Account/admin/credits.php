<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}

if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._ADDUSER;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN." - "._ADDUSER);
    amain();
    echo "<br>\n";
    OpenTable();
	readfile("modules/$module_name/credits.html");
    CloseTable();
    include("footer.php");

}

?>