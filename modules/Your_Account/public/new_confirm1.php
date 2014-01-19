<?php
if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

    include("header.php");

    //$user_viewemail = "0";
    $ya_user_email = strtolower($ya_user_email);
    ya_userCheck($ya_username);
    ya_mailCheck($ya_user_email);

    // menelaos: makes the 'realname' field a required field
    if ($ya_realname == '') {
        OpenTable();
        echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
        echo "<font class='content'>"._YA_NOREALNAME."<br><br>"._GOBACK."</font></center>";
        CloseTable();
        include("footer.php");
        die();
    }

    // menelaos: added configurable doublecheck email routine
    if ($ya_config['doublecheckemail'] == 0) {
	$ya_user_email2 == $ya_user_email;
    } else {
    	if ($ya_user_email != $ya_user_email2) {
        OpenTable();
        echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
        echo "<font class='content'>"._EMAILDIFFERENT."<br><br>"._GOBACK."</font></center>";
        CloseTable();
        include("footer.php");
        die();
	}
    }

    if (!$stop) {
        $datekey = date("F j");


        //===========================================
        // SECURITY CHECKS
        //===========================================
        if (extension_loaded("gd") AND ($gfx_chk == 3 OR $gfx_chk == 4 OR $gfx_chk == 6 OR $gfx_chk == 7) AND !check_captcha()){
        	$wrong_code = true;
            OpenTable();
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>".SECURITY_CODE_FAILED."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
        }
        
        
               
        if ($user_password == "" AND $user_password2 == "") {
            $user_password = YA_MakePass();
        } elseif ($user_password != $user_password2) {
            OpenTable();
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._PASSDIFFERENT."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
            die();
        } elseif ($user_password == $user_password2 AND (strlen($user_password) < $ya_config['pass_min'] OR strlen($user_password) > $ya_config['pass_max'])) {
            OpenTable();
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._YA_PASSLENGTH."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
            die();
        }
		
		$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need = '3' ORDER BY pos");
	    while ($sqlvalue = $db->sql_fetchrow($result)) {
	      $t = $sqlvalue[fid];
          if ($nfield[$t] == "") {
		    OpenTable();
			if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
            echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
            echo "<font class='content'>"._YA_FILEDNEED1."$name_exit"._YA_FILEDNEED2."<br><br>"._GOBACK."</font></center>";
            CloseTable();
            include("footer.php");
            die();
		  };
	    }
		
        title(_USERAPPLOGIN);
        OpenTable();
        echo "<center><b>"._USERAPPFINALSTEP."</b><br><br>$ya_username, "._USERCHECKDATA."</center><br>";
        echo "<table align='center' border='0' align=\"center\">";
        echo "<tr><td width=\"50%\"><b>"._USERNAME.":</b></td><td>$ya_username<br></td></tr>";
        echo "<tr><td width=\"50%\"><b>"._UREALNAME.":</b></td><td>$ya_realname<br></td></tr>";
        echo "<tr><td width=\"50%\"><b>"._EMAIL.":</b></td><td>$ya_user_email</td></tr>";
// menelaos: removed display of the user password here. It is mailed to the user
//      echo "<tr><td align=\"right\"><b>"._YA_PASSWORD.":</b></td><td>$user_password<br></td></tr>";
        echo "</table><br>";
        //@RJR-Pwmg@Rncvkpwo@-@Eqratkijv@(e)@VgejIHZ.eqo
        echo "<center><b>"._NOTE."</b> "._WAITAPPROVAL."";
        echo "<center><form action='modules.php?name=$module_name' method='post' onSubmit=\"javascript:submit.disabled=true;\"> ";
		
		if (count($nfield) > 0) foreach ($nfield as $key => $var) echo "<input type='hidden' name='nfield[$key]' value='$nfield[$key]'>";
		
        echo "<input type='hidden' name='random_num' value=\"$random_num\">";
        echo "<input type='hidden' name='gfx_check' value=\"$gfx_check\">";
        echo "<input type='hidden' name='ya_username' value=\"$ya_username\">";
        echo "<input type='hidden' name='ya_realname' value=\"$ya_realname\">";
        echo "<input type='hidden' name='ya_user_email' value=\"$ya_user_email\">";
        echo "<input type='hidden' name='user_password' value=\"$user_password\">";
        echo "<input type='hidden' name='op' value='new_finish'><br>";
        echo "<input type='submit' name='submit' value='"._FINISH."'> &nbsp;&nbsp;"._GOBACK."</form></center>";
        CloseTable();
    } else {
        OpenTable();
        echo "<center><font class='title'><b>"._ERRORREG."</b></font><br><br>";
        echo "<font class='content'>$stop<br><br>"._GOBACK."</font></center>";
        CloseTable();
    }
    include("footer.php");

?>