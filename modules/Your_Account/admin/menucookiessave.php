<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    ya_save_config('cookiecheck', $xcookiecheck);
    ya_save_config('cookiecleaner', $xcookiecleaner);
    ya_save_config('cookietimelife', $xcookietimelife, 'nohtml');
    ya_save_config('cookiepath', $xcookiepath, 'nohtml');
    ya_save_config('cookieinactivity', $xcookieinactivity, 'nohtml');

//    echo "<META HTTP-EQUIV=\"refresh\" content=\"2;URL=admin.php?op=UsersConfig\">";

    $pagetitle = ": "._COOKIECONFIG." - "._YA_USERS;
    include("header.php");
    title(_USERADMIN.": "._COOKIECONFIG);
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><h4>"._YACONFIGSAVED."</h4></center>";
    echo "<table align=\"center\"><tr><td><form><input type=\"button\" value=\""._COOKIECONFIG."\" onclick=\"javascript:location='".ADMIN_OP."CookieConfig';\"></form></td></tr></table>";
    CloseTable();
    include("footer.php");
}

?>