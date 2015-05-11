<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    if ($ya_config['autosuspend'] > 0){
        $st = time() - $ya_config['autosuspend'];
        $susresult = $db->sql_query("SELECT user_id FROM ".$user_prefix."_users WHERE user_lastvisit <= $st AND user_level > 0");
        while(list($sus_uid) = $db->sql_fetchrow($susresult)) {
            $db->sql_query("UPDATE ".$user_prefix."_users SET user_level='0', user_active='0' WHERE user_id='$sus_uid'");
        }
    }
    header("Location: ".ADMIN_OP."mod_users");

}

?>