<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    $tmp_nick = explode("\r\n",$xbad_nick);
    rsort($tmp_nick);
    for ($i=count($tmp_nick)-1; $i > -1; $i--) {
        if ($tmp_nick[$i] == "") { array_pop($tmp_nick); }
    }
    sort($tmp_nick);
    $xbad_nick = implode("\r\n",$tmp_nick);
    
    
    $tmp_mail = explode("\r\n",$xbad_mail);
    rsort($tmp_mail);
    for ($i=count($tmp_mail)-1; $i > -1; $i--) {
        if ($tmp_mail[$i] == "") { array_pop($tmp_mail); }
    }
    sort($tmp_mail);
    $xbad_mail = implode("\r\n",$tmp_mail);
    
    
    
    $tmp_headlines = explode("\r\n",$xheadlines);
    rsort($tmp_headlines);
    for ($i=count($tmp_headlines)-1; $i > -1; $i--) {
        if ($tmp_headlines[$i] == "") { array_pop($tmp_headlines); }
    }
    sort($tmp_headlines);
    $xheadlines = implode("\r\n",$tmp_headlines);
    
    
    
    ya_save_config('sendaddmail', $xsendaddmail, 'nohtml');
    ya_save_config('allowuserdelete', $xallowuserdelete);
    ya_save_config('doublecheckemail', $xdoublecheckemail);

    ya_save_config('coppa', $xcoppa);
    ya_save_config('tos', $xtos);
    ya_save_config('tosall', $xtosall);

    ya_save_config('senddeletemail', $xsenddeletemail);
    ya_save_config('allowusertheme', $xallowusertheme);
    ya_save_config('allowuserreg', $xallowuserreg);
    ya_save_config('allowmailchange', $xallowmailchange);
    ya_save_config('emailvalidate', $xemailvalidate);
    ya_save_config('requireadmin', $xrequireadmin);
    ya_save_config('servermail', $xservermail);
    ya_save_config('useactivate', $xuseactivate);
    ya_save_config('autosuspend', $xautosuspend);
    ya_save_config('perpage', $xperpage);
    ya_save_config('expiring', $xexpiring);

    ya_save_config('bad_nick', $xbad_nick, 'nohtml');
    ya_save_config('bad_mail', $xbad_mail, 'nohtml');
    ya_save_config('nick_min', $xnick_min);
    ya_save_config('nick_max', $xnick_max);
    ya_save_config('pass_min', $xpass_min);
    ya_save_config('pass_max', $xpass_max);
    ya_save_config('autosuspendmain', $xautosuspendmain);
    ya_save_config('headlines', $xheadlines, 'nohtml');

//    echo "<META HTTP-EQUIV=\"refresh\" content=\"2;URL=admin.php?op=UsersConfig\">";

    $pagetitle = ": "._USERADMIN." - "._YA_USERS;
    include("header.php");
    title(_USERADMIN.": "._YA_USERS);
    amain();
    echo "<br>\n";
    OpenTable();
    echo "<center><h4>"._YACONFIGSAVED."</h4></center>";
    echo "<table align=\"center\"><tr><td><form><input type=\"button\" value=\""._USERSCONFIG."\" onclick=\"javascript:location='".ADMIN_OP."UsersConfig';\"></form></td></tr></table>";
    CloseTable();
    include("footer.php");

}

?>