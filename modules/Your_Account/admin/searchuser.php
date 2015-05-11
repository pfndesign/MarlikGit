<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}



if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._SEARCHUSERS;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN." - "._SEARCHUSERS);
    amain();
    echo "<br>\n";
    asearch();
    include("footer.php");

}

?>