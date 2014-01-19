<?php



/*********************************************************************************/

/* CNB Your Account: An Advanced User Management System for phpnuke     		*/

/* ============================================                         		*/

/*                                                                      		*/

/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/

/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/

/*                                                                      		*/

/* Contact author: escudero@phpnuke.org.br                              		*/

/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/

/*                                                                      		*/

/* This program is free software. You can redistribute it and/or modify 		*/

/* it under the terms of the GNU General Public License as published by 		*/

/* the Free Software Foundation; either version 2 of the License.       		*/

/*                                                                      		*/

/*********************************************************************************/

/* CNB Your Account is the official successor of NSN Your Account by Bob Marion	*/

/*********************************************************************************/





if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {

    header("Location: ../../../index.php");

    die ();

}

if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }



    include("header.php");

    $ya_user_email = strtolower($ya_user_email);

    ya_userCheck($ya_username);

    ya_mailCheck($ya_user_email);

    $user_regdate = date("M d, Y");

    if (!isset($stop)) {

        $datekey = date("F j");

    /*    $rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $sitekey . $random_num . $datekey));

        $code = substr($rcode, 2, $ya_config['codesize']);



        if (extension_loaded("gd") AND $code != $gfx_check AND ($ya_config['usegfxcheck'] == 1 OR $ya_config['usegfxcheck'] == 3)) {



            Header("Location: modules.php?name=$module_name");

            die();

        }

       */
    
       mt_srand ((double)microtime()*1000000);

        $maxran = 1000000;

        $check_num = mt_rand(0, $maxran);

        $check_num = md5($check_num);


    	$time = time();

        $finishlink = "<a href=\"$nukeurl/modules.php?name=$module_name&op=activate&username=$ya_username&check_num=$check_num\">$nukeurl/modules.php?name=$module_name&op=activate&username=$ya_username&check_num=$check_num</a>";

        $new_password = md5($user_password);

        $ya_username = check_html($ya_username, nohtml);

        $ya_realname = check_html($ya_realname, nohtml);

        $ya_user_email = check_html($ya_user_email, nohtml);

        list($newest_uid) = $db->sql_fetchrow($db->sql_query("SELECT max(user_id) AS newest_uid FROM ".$user_prefix."_users_temp"));

        if ($newest_uid == "-1") { $new_uid = 1; } else { $new_uid = $newest_uid+1; }

        $result = $db->sql_query("INSERT INTO ".$user_prefix."_users_temp (user_id, username, realname, user_email, user_password, user_regdate, check_num, time) VALUES (".sql_quote($new_uid).", '".sql_quote($ya_username)."', '".sql_quote($ya_realname)."', '".sql_quote($ya_user_email)."', 

        '".sql_quote($new_password)."', '".sql_quote($user_regdate)."', '".sql_quote($check_num)."', '".sql_quote($time)."')");



		if ((count($nfield) > 0) AND ($result)) {

          foreach ($nfield as $key => $var) { 

  		    $db->sql_query("INSERT INTO ".$user_prefix."_cnbya_value_temp (uid, fid, value) VALUES ('$new_uid', '$key','$nfield[$key]')");				

		  }

		}

		

        if(!$result) {

            OpenTable();

            echo ""._ADDERROR."<br>";

            CloseTable();

        } else {

define("MAIL_CLASS",1); // ENABLING EMAIL SYSTEM TO RUN EMAIL CLASS         	
 if ($ya_config['servermail'] == 0) {

 	///****************** SENDING USER A CONFIRMATION MESSAGE ******************
	global $notify_from,$notify_email,$sitename,$nukeurl;
	
	$to_name="$ya_username";
	$to_address="$ya_user_email";

	$from_name= "$notify_from";
	$from_address= "$notify_email";

	$subject = "$sitename |  "._APPLICATIONSUB." : $ya_username ";


	$_message = "
	<p><b>" . _SUBJECT . ":</b> "._WELCOMETO." $sitename <a href=\"$nukeurl\">$nukeurl</a><br><b>"._APPLICATIONSUB."</b></p>
		<p><b>" . _UNICKNAME . ": </b><a href='$nukeurl/account/$ya_username' target='_blank'>$ya_username</a></p>
        <p><b>" . _UREALNAME . ": </b>$ya_realname</p>
        <p><b>" . _YOUUSEDEMAIL . ":</b> $ya_user_email</p>
        <p><b>" . _UPASSWORD . ":</b> $user_password</p>
		<p align=\"center\"><h3>خیلی مهم </h3><br><li>"._TOFINISHUSER."</li></p>\n\n\n\n<p align=\"center\">$finishlink<br><br></p>
		<br>\n";
        
	HtmlMail($to_address,$to_name,$from_address,$from_name,$subject,$_message);

    }   
    

            title(_USERREGLOGIN);

            OpenTable();

            echo "<center><b>"._ACCOUNTCREATED."</b><br><br>";

            echo ""._YOUAREREGISTERED."<br><br>";

            echo ""._FINISHUSERCONF."<br><br>";

            echo ""._THANKSUSER." $sitename!</center>";

            CloseTable();

 if ($ya_config['sendaddmail'] == 1 AND $ya_config['servermail'] == 0) {

  	///****************** SENDING ADMINISTRATOR A CONFIRMATION MESSAGE ******************

  	global $notify_from,$notify_email,$sitename,$nukeurl;

  	$_to_address="$notify_email";
  	$_to_name="$notify_from";

  	$_from_address= "$ya_user_email";
  	$_from_name= "$ya_username";


  	$_subject = "$sitename |  "._APPLICATIONSUB." : $ya_username ";

  	$_message2 = "<p><b>" . _SUBJECT . ":</b> "._WELCOMETO." $sitename <a href=\"$nukeurl\">$nukeurl</a><br><b>"._APPLICATIONSUB."</b></p>
		<p><b>" . _UNICKNAME . ": </b><a href='$nukeurl/account/$ya_username' target='_blank'>$ya_username</a></p>
        <p><b>" . _UREALNAME . ": </b>$ya_realname</p>
        <p><b>" . _YOUUSEDEMAIL . ":</b> $ya_user_email</p>
        <p><b>" . _YA_FROM . ":</b> ".getRealIpAddr()."</p>
		<br>\n";
  	
		$_message2 = Mail_AddStyle($_message2);
	@mail($_to_address, $_subject, $_message2, "From: $_from_address\nContent-Type: text/html; charset=utf-8");
  	
   }

        }

    } else {

        echo "$stop";

    }

    include("footer.php");



?>