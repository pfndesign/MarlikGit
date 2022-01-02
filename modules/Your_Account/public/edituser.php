<?php
/**
*
* @package USER EDIT PAGE														
* @version $Id: 12:10 AM 7/21/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
*
* 
*/

if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
    header("Location: ../../../index.php");
    die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

	cookiedecode($user); 
	getusrinfo($user); 
	if ((is_user($user)) AND (strtolower($userinfo['username']) == strtolower($cookie[1])) AND ($userinfo['user_password'] == $cookie[2])) {
		$pagetitle= _YA_EDIT;
		include("header.php");
        title(_PERSONALINFO);
        OpenTable();
        nav();
        CloseTable();

//recup info user ----------------------------------
	$result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field");
	while ($sqlvalue = $db->sql_fetchrow($result)) {
	  list($value) = $db->sql_fetchrow( $db->sql_query("SELECT value FROM ".$user_prefix."_cnbya_value WHERE fid ='$sqlvalue[fid]' AND uid = '$userinfo[user_id]'"));
      $userinfo[$sqlvalue['name']] = $value;
      }
//--------------------------------------------

        if (!preg_match("/http/",$userinfo['user_website'])  && $userinfo['user_website'] != "http://") {
            $userinfo['user_website'] = "http://".$userinfo['user_website'];
        }
        if ($ya_config['allowmailchange'] < 1) {
            $changeEmail = "<li>"._UREALEMAIL.":<input type='text' dir='ltr' name='user_email' value=\"$userinfo[user_email]\" maxlength='255'><br>"._EMAILNOTPUBLIC."</li>";
        } else {
           $changeEmail = "<input type='hidden' dir='ltr' name='user_email' value=\"$userinfo[user_email]\">\n";
        }

        $spfieldsresult = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE need <> '0' ORDER BY pos");
        $numspfields = $db->sql_numrows($spfieldsresult);
        while ($sqlvalue = $db->sql_fetchrow($spfieldsresult)) {
        	$t = $sqlvalue['fid'];
        	$value2 = explode("::", $sqlvalue['value']);
        	if (substr($sqlvalue['name'],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue['name'];
        	$spfields .= "<li>$name_exit<li>";
        	if (count($value2) == 1) {
        		$spfields .= "<li><input type='text' name='nfield[$t]' value='".$userinfo[$sqlvalue['name']]."' size='20' maxlength='$sqlvalue[size]'></li>\n";
        		$sqlvalueMax = $sqlvalueMax - 1;
        	} else {
        		$spfields .= "<li><select name='nfield[$t]'>\n";
        		for ($i = 0; $i<count($value2); $i++) {
        			if (trim($userinfo[$sqlvalue['name']]) == trim($value2[$i])) $sel = "selected"; else $sel = "";
        			$spfields .= "<option value=\"".trim($value2[$i])."\" $sel>$value2[$i]</option>\n";
        		}
        		$spfields .= "</select></li>\n";
        	}
        }
        
        if ($userinfo['newsletter'] == 1) { $newsletter_ck1 = " selected"; $newsletter_ck2 = ""; } else { $newsletter_ck1 = ""; $newsletter_ck2 = " selected"; }
		$newsletter = "<select name='newsletter'><option value='1'$newsletter_ck1>"._YES."</option><option value='0'$newsletter_ck2>"._NO."</option></select>";

        if ($userinfo['user_viewemail'] == 1) { $viewemail_ck1 = " selected"; $viewemail_ck2 = ""; } else { $viewemail_ck1 = ""; $viewemail_ck2 = " selected"; }
		$viewemail = "<select name='user_viewemail'><option value='1'$viewemail_ck1>"._YES."</option><option value='0'$viewemail_ck2>"._NO."</option></select>";

        if ($userinfo['user_allow_viewonline'] == 0) { $viewonline_ck1 = " selected"; $viewonline_ck2 = ""; } else { $viewonline_ck1 = ""; $viewonline_ck2 = " selected"; }
		$viewonline = "<select name='user_allow_viewonline'><option value='0'$viewonline_ck1>"._YES."</option><option value='1'$viewonline_ck2>"._NO."</option></select>";

        if ($userinfo['user_notify'] == 1) { $notify_ck1 = " selected"; $notify_ck2 = ""; } else { $notify_ck1 = ""; $notify_ck2 = " selected"; }
		$notify_ = "<select name='user_notify'><option value='1'$notify_ck1>"._YES."</option><option value='0'$notify_ck2>"._NO."</option></select>";

        if ($userinfo['user_notify_pm'] == 1) { $notify_pm_ck1 = " selected"; $notify_pm_ck2 = ""; } else { $notify_pm_ck1 = ""; $notify_pm_ck2 = " selected"; }
		$notify_pm_ = "<select name='user_notify_pm'><option value='1'$notify_pm_ck1>"._YES."</option><option value='0'$notify_pm_ck2>"._NO."</option></select>";
		
        if ($userinfo['user_popup_pm'] == 1) { $popup_pm_ck1 = " selected"; $popup_pm_ck2 = ""; } else { $popup_pm_ck1 = ""; $popup_pm_ck2 = " selected"; }
		$popup_pm_ = "<select name='user_popup_pm'><option value='1'$popup_pm_ck1>"._YES."</option><option value='0'$popup_pm_ck2>"._NO."</option></select>";

        if ($userinfo['user_attachsig'] == 1) { $attachsig_ck1 = " selected"; $attachsig_ck2 = ""; } else { $attachsig_ck1 = ""; $attachsig_ck2 = " selected"; }
		$attachsig_ = "<select name='user_attachsig'><option value='1'$attachsig_ck1>"._YES."</option><option value='0'$attachsig_ck2>"._NO."</option></select>";

        if ($userinfo['user_allowbbcode'] == 1) { $allowbbcode_ck1 = " selected"; $allowbbcode_ck2 = ""; } else { $allowbbcode_ck1 = ""; $allowbbcode_ck2 = " selected"; }
		$allowbbcode_ = "<select name='user_allowbbcode'><option value='1'$allowbbcode_ck1>"._YES."</option><option value='0'$allowbbcode_ck1>"._NO."</option></select>";
		
        if ($userinfo['user_allowhtml'] == 1) { $allowhtml_ck1 = " selected"; $allowhtml_ck2 = ""; } else { $allowhtml_ck1 = ""; $allowhtml_ck2 = " selected"; }
		$allowhtml_ = "<select name='user_allowhtml'><option value='1'$allowhtml_ck1>"._YES."</option><option value='0'$allowhtml_ck2>"._NO."</option></select>";
		

        if ($userinfo['user_allowsmile'] == 1) { $allowsmile_ck1 = " selected"; $allowsmile_ck2 = ""; } else { $allowsmile_ck1 = ""; $allowsmile_ck2 = " selected"; }
		$allowsmile_ = "<select name='user_allowsmile'><option value='1'$allowsmile_ck1>"._YES."</option><option value='0'$allowsmile_ck2>"._NO."</option></select>";
		
        $FORUMSTIME_ = "<select name='user_timezone'>";
         $FORUMSTIME_ .= "<option name='user_timezone' value=\"0330\">GMT +3.5 تهران</option>";
        for ($i=-12; $i<13; $i++) {
            if ($i == 0) {
                $dummy = "GMT";
            } else {
                if (!preg_match("/-/", $i)) { $i = "+$i"; }
                $dummy = "GMT $i "._HOURS."";
            }
            if ($userinfo['user_timezone'] == $i) {
                $FORUMSTIME_ .= "<option name='user_timezone' value=\"$i\" selected>$dummy</option>";
            } else {
                $FORUMSTIME_ .= "<option name='user_timezone' value=\"$i\">$dummy</option>";
            }
        }
        $FORUMSTIME_ .= "</select>";
        //-- Style -up Codes ---
?><link rel="StyleSheet" href="modules/Your_Account/includes/style/EditProfile.css" type="text/css" />
<script type="text/javascript" src="modules/Your_Account/includes/style/EditProfile.js"></script>
<script src="modules/Your_Account/includes/style/EditAvatar.js" type="text/javascript"></script>
<style type="text/css">
ul.tabs li {
	text-align:<?php echo langStyle('align')?>;float:<?php echo langStyle('align')?>
}
</style>
<div class="container">
	<h1 style="text-align:<?php echo langStyle('align')?>;font-size:15px;margin:10px;"><?php echo _YA_EDIT." ". $userinfo['username']; ?></h1>
    <ul class="tabs">
			<li><a href="#generalSetting"><?PHP echo _YA_EDIT_GENERAL;?></a></li>
			<li><a href="#userinfoSetting"><?PHP echo _YA_EDIT_ACCOUNT;?></a></li>
			<li><a href="#contactSetting"><?PHP echo _YA_EDIT_NOTIFY;?></a></li>
			<li><a href="#accountSetting"><?PHP echo _YA_EDIT_SETTING;?></a></li>
			<li><a href="#blogSetting" class="delete_update"><?PHP echo _YA_EDIT_BLOG;?></a></li>
			<?php if (!empty($numspfields)) { echo '<li><a href="#specialSetting">'._YA_EDIT_OTHERS.'</a></li>';} ?>
	</ul>
    <div class="tab_container">
		<form name='Register' action='modules.php?name=<?php echo $module_name;?>&op=edituser' method='post'>
			<div id="generalSetting" class="tab_content">
					<li><?php echo _UREALNAME ;?><li></li><input type='text' name='realname' value="<?php echo $userinfo['name'];?>" size='50' maxlength='60'></li>
					<li><?php echo _YOCCUPATION ."<li></li><input type='text' name='user_occ' value=\"$userinfo[user_occ]\" size='30' maxlength='100'>";?></li>
					<li><?php echo _YINTERESTS ."<li></li><input type='text' name='user_interests' value=\"$userinfo[user_interests]\" size='30' maxlength='100'>" ;?></li>
					<li><?php echo _YA_CURRAV ?><div id='loadAvatarSeting'><img src="images/loading.gif"> <?php echo _LOADING?></div></li>				
			</div>
			<div id="userinfoSetting" class="tab_content">
					<li><?php echo _USRNICKNAME ."<b>$userinfo[username]</b>" ;?></li>
					<?php echo $changeEmail ;?>
					<li><?php echo _YOURHOMEPAGE ."<li></li><input type='text' dir='ltr' name='user_website' value=\"$userinfo[user_website]\" size='50' maxlength='255'>";?></li>
					<li><?php echo _PASSWORD ."<li></li><input type='password' dir='ltr' name='user_password' size='22' maxlength='".$ya_config['pass_max']."'>";?></li>
					<li><?php echo _TYPENEWPASSWORD ."<li></li><input type='password' dir='ltr' name='vpass' size='22' maxlength='".$ya_config['pass_max']."'>";?></li>
			</div>
			<div id="contactSetting"  class="tab_content">
					<li><?php echo _UFAKEMAIL ."<li></li><input type='text' name='femail' dir='ltr' value=\"$userinfo[femail]\" size='50' maxlength='255'><br>"._EMAILPUBLIC."";?></li>
					<li><?php echo _YICQ ."<li></li><input type='text' dir='ltr' name='user_icq' value=\"$userinfo[user_icq]\" size='30' maxlength='100'>";?></li>
					<li><?php echo _YAIM ."<li></li><input type='text' dir='ltr' name='user_aim' value=\"$userinfo[user_aim]\" size='30' maxlength='100'>";?></li>
					<li><?php echo _YYIM ."<li></li><input type='text' dir='ltr' name='user_yim' value=\"$userinfo[user_yim]\" size='30' maxlength='100'>";?></li>
					<li><?php echo _YMSNM ."<li></li><input type='text' dir='ltr' name='user_msnm' value=\"$userinfo[user_msnm]\" size='30' maxlength='100'>";?></li>
					<li><?php echo _YLOCATION ."<li></li><input type='text' name='user_from' value=\"$userinfo[user_from]\" size='30' maxlength='100'>";?></li>
					<?php if (is_active("phpBB3")) {
					?><li><?php echo _SIGNATURE ."<br>"._FORUMS."<a href='modules.php?name=phpBB3&file=ucp&i=profile&mode=signature'> "._SIGNITURE."</a>";?></li><?php
					}else {
					?><li><?php echo _SIGNATURE ."<br>"._NOHTML."<li></li><textarea wrap='virtual' cols='50' rows='5' name='user_sig'>$userinfo[user_sig]</textarea>";?></li><?php
					}

			?></div>

			<div id="accountSetting" class="tab_content" style="line-height:30px;">
					<li><?php echo _RECEIVENEWSLETTER ."$newsletter";?></li>
					<li><?php echo _ALWAYSSHOWEMAIL ."$viewemail";?></li>
					<li><?php echo _HIDEONLINE ."$viewonline";?></li>
					<li><?php echo _REPLYNOTIFY .":".$notify_;?></li>
					<li><?php echo _PMNOTIFY ."$notify_pm_";?></li>
					<li><?php echo _POPPM.":"."$popup_pm_";?></li>
					<li><?php echo _ATTACHSIG."$attachsig_";?></li>
					<li><?php echo _ALLOWBBCODE."$allowbbcode_";?></li>
					<li><?php echo _ALLOWHTMLCODE."$allowhtml_";?></li>
					<li><?php echo _ALLOWSMILIES."$allowsmile_";?></li>

			</div>
			<div id="blogSetting" class="tab_content">
					<li><div id='loadblogSeting'><img src="images/loading.gif"> <?php echo _LOADING?></div></li>
			</div>
			<div id="specialSetting" class="tab_content">
				<?php echo $spfields;?>
			</div>

			<?php

	        echo "<input type='hidden' name='username' value=\"$userinfo[username]\">";
	        echo "<input type='hidden' name='user_id' value=\"$userinfo[user_id]\">";
	        echo "<input type='hidden' name='sigmax' value=\"$bbconf[config_value]\">"; // MrFluffy
	        echo "<input type='hidden' name='op' value='saveuser'>";
	        echo "<p><input type='submit' value='"._SAVECHANGES."'></p>";
	        ?>
			</form>
    </div>
</div>
<div style="clear:both;margin:0px auto;"></div>
<script>
  $("#loadAvatarSeting").load("modules.php?name=Your_Account&op=avatarCroping", {"op": "avatarCroping"});
  $("#loadblogSeting").load("modules.php?name=Your_Account&op=YAB_Setting", {"op": "YAB_Setting"});
</script>

<?php
        include("footer.php");
	} else {
        mmain($user);
	}

?>