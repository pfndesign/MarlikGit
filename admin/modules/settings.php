<?php

/**
*
* @package Setting														
* @version $Id: setting.php 0999 2009-12-17 15:35:19Z Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

/**
* @ignore
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { show_error("Access Denied"); }
if (!defined('ADMIN_FILE')) {show_error("Access Denied");}

$pagetitle = _GENERAL_OPTIONS;

global $admin,$prefix,$db;

if (is_superadmin($admin)) {

	function Configure() {
		global $admin_file;
		include ('header.php');
		GraphicAdmin();
		///OpenTable();

?>
<link rel="stylesheet" type="text/css" href="<?php echo INCLUDES_ACP ?>style/css/setting-style.css"/>
<script type="text/javascript">
$(document).ready(function() {
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).slideDown(); //Fade in the active content
		return false;
	});
});
</script>
<style type="text/css">
ul.tabs li {float:<?php echo langstyle("align");?>}
.tab_container {float:<?php echo langstyle("align");?>}
.ul.tabs {float:<?php echo langstyle("align");?>}
</style>
<div class="container">

	<h1 style="text-align:right;"><?php echo _SETTING_MANAGMENT?></h1>
    <ul class="tabs">
			<li><a href="#general_st"><?php echo _GENERAL_OPTIONS?></a></li>
			<li><a href="#security_st"><?php echo _SECURITY_OPTIONS?></a></li>
			<li><a href="#story_st"><?php echo _STORY_OPTIONS?></a></li>
			<li><a href="#optimisation_st"><?php echo _OPTIMIZATION_OPTIONS?></a></li>
			<li><a href="#language_st"><?php echo _LANGUAGE_OPTIONS?></a></li>
			<li><a href="#notification_st"><?php echo _NOTIFICATIONS?></a></li>
			<li><a href="#administration_st"><?php echo _ADMINISTRATION_OPTIONS?></a></li>
			<!--<li><a href="#footer_st"><?php echo _FOOTERMSG?></a></li>-->

    </ul>
    <div class="tab_container">
		<form id="settingForm" name="settingForm" action="<?php echo $admin_file ?>.php?op=ConfigSave" method="post">
        <div id="general_st" class="tab_content">
					<?php general_st(); ?>
        </div>
        <div id="security_st" class="tab_content">
					<?php security_st(); ?>
        </div>
        <div id="story_st" class="tab_content">
					<?php story_st(); ?>
        </div>
        <div id="optimisation_st" class="tab_content">
					<?php optimisation_st(); ?>
        </div>
        <div id="language_st" class="tab_content">
					<?php language_st(); ?>
        </div>
        <div id="notification_st" class="tab_content">
					<?php notification_st(); ?>
        </div>
        <div id="administration_st" class="tab_content">
					<?php administration_st(); ?>
        </div>
        <div id="footer_st" class="tab_content">
					<?php footer_st(); ?>
        </div>
			<p>
				<input id="SaveAccount" type="submit" value="<?php echo _SAVECHANGES?>" />
			</p>
			</form>
    </div>
</div>

<?php
///CloseTable();

include("footer.php");
	}
	function general_st(){
		global $sitename,$nukeurl,$site_logo,$slogan,$startdate,$adminmail,$loading,$Default_Theme;
		//--- GENERAL SETTINGS ----------------------
		echo "<fieldset>
            <legend>"._GENERAL_OPTIONS."</legend>
            <label for=\"" . _SITENAME . "\">" . _SITENAME . "</label>
            <input type='text' name='xsitename' value='$sitename' size='40' maxlength='255' />
            <label for=\"" . _SITEURL . "\">" . _SITEURL . "</label>
            <input type='text' name='xnukeurl' value='$nukeurl' size='40' maxlength='255' />
            <label for=\"" . _SITELOGO . "\">" . _SITELOGO . "</label> <font class='tiny'>[ " . _MUSTBEINIMG . " ]</font><br>
            <input type='text' name='xsite_logo' value='$site_logo' size='40' maxlength='255' />
            <label for=\"" . _SITESLOGAN . "\">" . _SITESLOGAN . "</label>
            <input type='text' name='xslogan' value='$slogan' size='40' maxlength='255' />
            <label for=\"" . _STARTDATE . "\">" . _STARTDATE . "</label>
            <input type='text' name='xstartdate' value='$startdate' size='40' maxlength='255' />
            <label for=\"" . _ADMINEMAIL . "\">" . _ADMINEMAIL . "</label>
            <input type='text' name='xadminmail' value='$adminmail' size='40' maxlength='255' />";
		echo "<label for=\"" . _SITELOADING . "\">" . _SITELOADING . "</label>";
		if ($loading==1) {
			echo "<input type='radio' name='xloading' value='1' checked>" . _YES . " &nbsp;"
			."<input type='radio' name='xloading' value='0'>" . _NO . "";
		} else {

			echo "<input type='radio' name='xloading' value='1'>" . _YES . " &nbsp;"
			."<input type='radio' name='xloading' value='0' checked>" . _NO . "";
		}


		echo "<label for=\"" . _DEFAULTTHEME . "\">" . _DEFAULTTHEME . "</label>
		<select name='xDefault_Theme'>";
		$handle=opendir('themes');
		while ($file = readdir($handle)) {
			if ( (!preg_match("/[.]/",$file)) ) {
				$themelist .= "$file ";
			}
		}
		closedir($handle);
		$themelist = explode(" ", $themelist);
		sort($themelist);
		for ($i=0; $i < sizeof($themelist); $i++) {
			if(!empty($themelist[$i])) {
				echo "<option name='xDefault_Theme' value='$themelist[$i]' ";
				if($themelist[$i]==$Default_Theme) echo "selected";
				echo ">$themelist[$i]\n";
			}
		}

		echo "</select>	<div id='site_activity_locked'>";
		site_activity_show();
		?>
		</div>
		<script type="text/javascript">
		$(document).ready(function(){

			$('#disable_switch_butt').live("click",function(){


				var site_switch=$('#site_switch').val();

				var disable_fyear=$('#disable_fyear').val();
				var disable_fmonth=$('#disable_fmonth').val();
				var disable_fday=$('#disable_fday').val();
				var disable_fhour=$('#disable_fhour').val();
				var disable_fmin=$('#disable_fmin').val();
				var disable_fsec=$('#disable_fsec').val();

				var disable_tyear=$('#disable_tyear').val();
				var disable_tmonth=$('#disable_tmonth').val();
				var disable_tday=$('#disable_tday').val();
				var disable_thour=$('#disable_thour').val();
				var disable_tmin=$('#disable_tmin').val();
				var disable_tsec=$('#disable_tsec').val();
				
				var disable_reason = escape(CKEDITOR.instances.disable_reason.getData());
				
				$.ajax({
					type: 'POST',
					data: 'op=siteActivityUpdate&site_switch='+site_switch+
					'&disable_fyear='+disable_fyear+'&disable_fmonth='+disable_fmonth+'&disable_fday='+disable_fday+'&disable_fhour='+disable_fhour+'&disable_fmin='+disable_fmin+'&disable_fsec='+disable_fsec+
					'&disable_tyear='+disable_tyear+'&disable_tmonth='+disable_tmonth+'&disable_tday='+disable_tday+'&disable_thour='+disable_thour+'&disable_tmin='+disable_tmin+'&disable_tsec='+disable_tsec + '&disable_reason=' + disable_reason ,

					url: '<?php echo ADMIN_PHP?>',
					cache: false,
					beforeSend: function() {
						$("#site_activity_locked").html("<img src='images/loading.gif' />");
					},
					success: function(x) {
						$("#site_activity_locked").html(x);
					}
				});
				return false;
			});
		});
		</script>
		<?php


		echo "</fieldset>";


	}
	function security_st(){
		global $gfx_chk,$use_question,$codesize,$sec_pass,$db,$prefix;

		//--- Security SETTINGS ----------------------


		echo "<fieldset>
            <legend>"._SECURITY_OPTIONS."</legend>";

		switch($gfx_chk){
			case 0:
				$ch0 = 'SELECTED';
				break;
			case 1:
				$ch1 = 'SELECTED';
				break;
			case 2:
				$ch2 = 'SELECTED';
				break;
			case 3:
				$ch3 = 'SELECTED';
				break;
			case 4:
				$ch4 = 'SELECTED';
				break;
			case 5:
				$ch5 = 'SELECTED';
				break;
			case 6:
				$ch6 = 'SELECTED';
				break;
			case 7:
				$ch7 = 'SELECTED';
				break;
		}
		echo '<label for="',_GFX_CHK,'">',_GFX_CHK,'</label>
        <select name="xgfx">
        <option value="0" ',$ch0,'>',_OFF,'</option>
        <option value="1" ',$ch1,'>',_ADM_LOGIN,'</option>
        <option value="2" ',$ch2,'>',_USR_LOGIN,'</option>
        <option value="3" ',$ch3,'>',_USR_REG,'</option>
        <option value="4" ',$ch4,'>',_USR_LOG_REG,'</option>
        <option value="5" ',$ch5,'>',_ADM_USR_LOG,'</option>
        <option value="6" ',$ch6,'>',_ADM_USR_REG,'</option>
        <option value="7" ',$ch7,'>',_EVERYWHERE,'</option>
        </select>';
		echo '<label for="',_CODESIZE,'">',_CODESIZE,'</label>
			<input type="text" name="xcodesize" value="',$codesize,'" />';
		if($use_question){$yes = 'checked="checked"';}else{$no='checked="checked"';$rstyle='style="display:none"';}
		echo '<label for="',_USE_Q_C,'">',_USE_Q_C,'<br><font style="color:red;font-size:9px"> (',_USE_Q_C_HELP,')</font></label>';
		echo '<input id="qy" name="question" type="radio" value="1" onclick=\'$("#sqs").slideDown(300)\' ',$yes,' />',_YES,' <input id="qn" name="question" type="radio" value="0" onclick=\'$("#sqs").slideUp(300)\' ',$no,' />',_NO,'<br />';
		echo '<div id="sqs" ',$rstyle,'>',_SQS,'<br />';
		$result = $db->sql_query('SELECT `qid`,`question`,`answer` FROM `'.$prefix.'_squestions` ORDER BY `qid` ASC');
		if(!$result) echo mysql_error();
		$i = 1;
		while($row = $db->sql_fetchrow($result)){
			echo $i,'. <input type="text" name="questions[',$row['qid'],']" value="',$row['question'],'" size="25" /> <input type="text" name="answers[',$row['qid'],']" value="',$row['answer'],'" size="10" /><br />';
			$i++;
		}
		echo $i,'. <input type="text" name="nquestion" value="" size="25" /> <input type="text" name="nanswer" value="" size="10" /><br />';
		echo '</div>';


		if(!empty($sec_pass)){$Syes = 'checked="checked"';}else{$Sno='checked="checked"';$Srstyle='style="display:none"';}
		echo "<label for=\"" . _SECOND_PASSWORD . "\">" . _SECOND_PASSWORD . "</label>";
		echo '<input name="use_sec_pass" type="radio" value="1" onclick=\'$("#secpassDiv").slideDown(300)\' ',$Syes,' />',_YES,'
    		<input name="use_sec_pass" type="radio" value="0" onclick=\'$("#secpassDiv").slideUp(300);$("#xsec_pass").attr("value", "");\' ',$Sno,' />',_NO,'<br />';
		echo "<div id='secpassDiv' $Srstyle>
       		<input type='text' name='xsec_pass'  id='xsec_pass' value='".$sec_pass."' size='20' maxlength='40' />
        	</div>";

		echo '</fieldset>';

	}
	function story_st(){
		global $top,$storyhome,$oldnum,$moderate,$anonpost,$anonymous,
		$commentlimit,$anonymous,$articlecomm,
		$articlecomm,$broadcast_msg,$my_headlines,
		$user_news,$nuke_editor,
		$db,$prefix;
		//--- STORY SETTINGS ----------------------

		echo "<fieldset>
        <legend>"._STORY_OPTIONS."</legend>

        <label for=\"" . _ITEMSTOP . "\">" . _ITEMSTOP . "</label>  
        <input type='text' name='xtop' value='$top'>

		<label for=\"" . _STORIESHOME . "\">" . _STORIESHOME . "</label>
         <input type='text' name='xstoryhome' value='$storyhome'>
		
        <label for=\"" . _OLDSTORIES . "\">" . _OLDSTORIES . "</label>
         <input type='text' name='xoldnum' value='$oldnum'>
       
            <label for=\"" . _MODTYPE . "\">" . _MODTYPE . "</label>
<select name='xmoderate'>";
		if ($moderate==1) {
			$sel1 = "selected";
			$sel2 = "";
			$sel3 = "";
		} elseif ($moderate==2) {
			$sel1 = "";
			$sel2 = "selected";
			$sel3 = "";
		} elseif ($moderate==0) {
			$sel1 = "";
			$sel2 = "";
			$sel3 = "selected";
		}
		echo "<option name='xmoderate' value='1' $sel1>" . _MODADMIN . "</option>"
		."<option name='xmoderate' value='2' $sel2>" . _MODUSERS . "</option>"
		."<option name='xmoderate' value='0' $sel3>" . _NOMOD . "</option>"
		."</select>";


		echo "<label for=\"" . _ALLOWANONPOST . "\">" . _ALLOWANONPOST . "</label>";
		if ($anonpost==1) {
			echo "<input type='radio' name='xanonpost' value='1' checked>" . _YES . " &nbsp;
		<input type='radio' name='xanonpost' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xanonpost' value='1'>" . _YES . " &nbsp;
		<input type='radio' name='xanonpost' value='0' checked>" . _NO . "";
		}

		echo "<label for=\"" . _ANONYMOUSNAME . "\">" . _ANONYMOUSNAME . "</label>
            <input type='text' name='xanonymous' value='$anonymous'/>
            <label for=\"" . _COMMENTSLIMIT . "\">" . _COMMENTSLIMIT . "</label>
            <input type='text' name='xcommentlimit' value='$commentlimit' size='3' maxlength='10' />";


		echo "<label for=\"" . _COMMENTSARTICLES . "\">" . _COMMENTSARTICLES . "</label>";
		if ($articlecomm==1) {
			echo "<input type='radio' name='xarticlecomm' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xarticlecomm' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xarticlecomm' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xarticlecomm' value='0' checked>" . _NO . "";
		}
		
		echo "<label for=\"" . _COMMENTSPOLLS . "\">" . _COMMENTSPOLLS . "</lable><br>";
		if ($pollcomm==1) {
			echo "<input type='radio' name='xpollcomm' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xpollcomm' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xpollcomm' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xpollcomm' value='0' checked>" . _NO . "";
		}

		echo " <label for=\"" . _BROADCASTMSG . "\">" . _BROADCASTMSG . "</label>";
		if ($broadcast_msg == 1) {
			echo "<input type='radio' name='xbroadcast_msg' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xbroadcast_msg' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xbroadcast_msg' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xbroadcast_msg' value='0' checked>" . _NO . "";
		}


		echo " <label for=\"" . _MYHEADLINES . "\">" . _MYHEADLINES . "</label>";
		if ($my_headlines == 1) {
			echo "<input type='radio' name='xmy_headlines' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xmy_headlines' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xmy_headlines' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xmy_headlines' value='0' checked>" . _NO . "";
		}


		echo " <label for=\"" . _USERSHOMENUM . "\">" . _USERSHOMENUM . "</label>";
		if ($user_news == 1) {
			echo "<input type='radio' name='xuser_news' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xuser_news' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xuser_news' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xuser_news' value='0' checked>" . _NO . "";
		}
		echo '<label for="',_NUKEEDITOR,'">',_NUKEEDITOR,'</label>';
		if ($nuke_editor == 1) {
			echo "<input type='radio' name='xnuke_editor' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xnuke_editor' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xnuke_editor' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xnuke_editor' value='0' checked>" . _NO . "";
		}



		echo "</fieldset>";

	}
	function language_st(){
		global $locale,$ultramode,$multilingual,$language,$useflags;

		//--- LANGUAGE SETTINGS ----------------------

		echo "<fieldset>
        <legend>"._LANGUAGE_OPTIONS."</legend>
        <label for=\"" . _SELLANGUAGE . "\">" . _SELLANGUAGE . "</label>
		<select name='xlanguage'>";
		$handle=opendir('language');
		$languageslist = "";
		while ($file = readdir($handle)) {
			if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
				$langFound = $matches[1];
				$languageslist .= "$langFound ";
			}
		}
		closedir($handle);
		$languageslist = explode(" ", $languageslist);
		sort($languageslist);
		$activelanguages = "";
		for ($i=0; $i < sizeof($languageslist); $i++) {
			if(!empty($languageslist[$i])) {
				echo "<option name='xlanguage' value='$languageslist[$i]' ";
				if($languageslist[$i]==$language) echo "selected";
				echo ">".ucfirst($languageslist[$i])."\n";
		
			$activelanguages .= '<li style="background:#C3E1EB;border:1px solid #C0C3D4;padding:5px;" id="'.$i.'" d1="'.$languageslist[$i].'">
			<span style="float:left;" id="'.$languageslist[$i].'_title"><b>'.$languageslist[$i].'</b></span>
			<span style="float:right;margin-top:2px;margin-right:5px;">
			<a href="'.ADMIN_OP.'language&action=editlanguage&data='.$languageslist[$i].'">'._EDIT.'</a>
			| <a href="javascript:void(0)" onclick="javascript:themes_removelanguage(\''.$languageslist[$i].'\')">'._REMOVE.'</a>
			</span><div style="clear:both">
			</div></li>';
			}
			
		}
		echo "</select>
		
        <label for=\"" . _LOCALEFORMAT . "\">" . _LOCALEFORMAT . "</label>
        <input type='text' name='xlocale' value='$locale' size='20' maxlength='40' />";


		echo " <label for=\"" . _ACTMULTILINGUAL . "\">" . _ACTMULTILINGUAL . "</label>";
		if ($multilingual==1) {
			echo "<input type='radio' name='xmultilingual' value='1' checked>" . _YES . " &nbsp;"
			."<input type='radio' name='xmultilingual' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xmultilingual' value='1'>" . _YES . " &nbsp;"
			."<input type='radio' name='xmultilingual' value='0' checked>" . _NO . "";
		}

		echo " <label for=\"" . _ACTUSEFLAGS . "\">" . _ACTUSEFLAGS . "</label>";
		if ($useflags==1) {
			echo "<input type='radio' name='xuseflags' value='1' checked>" . _YES . " &nbsp;"
			."<input type='radio' name='xuseflags' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xuseflags' value='1'>" . _YES . " &nbsp;"
			."<input type='radio' name='xuseflags' value='0' checked>" . _NO . "";
		}
		
		echo " <label for=\"" . _ACTULTRAMODE . "\">" . _ACTULTRAMODE . "</label>";
		if ($ultramode==1) {
			echo "<input type='radio' name='xultramode' value='1' checked>" . _YES . " &nbsp;"
			."<input type='radio' name='xultramode' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xultramode' value='1'>" . _YES . " &nbsp;"
			."<input type='radio' name='xultramode' value='0' checked>" . _NO . "";
		}
		echo '	<div style="clear:both;padding-top:20px;margin-top:20px;border-top:1px solid #ccc;">
					<ul id="modules_livelanguage">
						'.$activelanguages.'
					</ul>
				</div>	
		';
		echo "</fieldset>";

	}
	function optimisation_st(){
		global $httpref,$nextg,$cache_system,$clifetime;
		//--- OPTIMIZATION SETTINGS ----------------------

		echo "<fieldset>
        <legend>"._OPTIMIZATION_OPTIONS."</legend>
		";



		echo "<label for=\"" . _GOOGLETAP . "\">" . _GOOGLETAP . "</label>";
		if ($nextg==1) {
			echo "<input type='radio' name='xnextg' value='1' checked>" . _YES . " &nbsp;"
			."<input type='radio' name='xnextg' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xnextg' value='1'>" . _YES . " &nbsp;"
			."<input type='radio' name='xnextg' value='0' checked>" . _NO . "";
		}


		if($cache_system){$yes = 'checked="checked"';$rstyle='style="border:0px;"';}else{$no='checked="checked"';$rstyle='style="display:none"';}
		echo "<label for=\"" . _CACHESYS . "\">" . _CACHESYS . "</label>";
		echo '<input name="xcachesys" type="radio" value="1" onclick=\'$("#xlifetimeDiv").slideDown(300)\' ',$yes,' />',_YES,'
    	<input name="xcachesys" type="radio" value="0" onclick=\'$("#xlifetimeDiv").slideUp(300)\' ',$no,' />',_NO,'<br />';
		echo "<div id='xlifetimeDiv' $rstyle>";
		echo '<input type="text" name="xlifetime" value="',$clifetime,'" /> '._CLIFETIME.'';
		echo "</div>";


		echo " </fieldset>";

	}
	function notification_st(){
		global $backend_title,$backend_language,$notify,$notify_email,$notify_subject,$notify_message,$notify_from;
		//--- NOTIFICATION SETTINGS ----------------------
		echo "<fieldset>
            <legend>"._NOTIFICATIONS."</legend>

            <label for=\"" . _BACKENDTITLE . "\">" . _BACKENDTITLE . "</label>
            <input type='text' name='xbackend_title' value='$backend_title' size='40' maxlength='100' />
            <label for=\"" . _BACKENDLANG . "\">" . _BACKENDLANG . "</label>
            <input type='text' name='xbackend_language' value='$backend_language' size='10' maxlength='10' />

            
            <label for=\"" . _NOTIFYSUBMISSION . "\">" . _NOTIFYSUBMISSION . "</label>";
		if ($notify==1) {
			echo "<input type='radio' name='xnotify' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xnotify' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xnotify' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xnotify' value='0' checked>" . _NO . "";
		}

		echo "<label for=\"" . _EMAIL2SENDMSG . "\">" . _EMAIL2SENDMSG . "</label>
            <input type='text' name='xnotify_email' value='$notify_email' size='30' maxlength='100' />
            <label for=\"" . _EMAILSUBJECT . "\">" . _EMAILSUBJECT . "</label>
            <input type='text' name='xnotify_subject' value='$notify_subject' size='40' maxlength='100' />
            <label for=\"" . _EMAILMSG . "\">" . _EMAILMSG . "</label>
            <textarea name='xnotify_message' cols='50' rows='5'>$notify_message</textarea>
            <label for=\"" . _EMAILFROM . "\">" . _EMAILFROM . "</label>
            <input type='text' name='xnotify_from' value='$notify_from' size='15' maxlength='25' />
            
        </fieldset>";

	}
	function administration_st(){
		global $admingraphic,$httpref,$httprefmax,$minpass,$CensorMode,$CensorReplace;
		//--- ADMINISTRATION SETTINGS ----------------------
		echo "<fieldset>
            <legend>"._ADMINISTRATION_OPTIONS."</legend>";
		echo "<label for=\"" . _ADMINGRAPHIC . "\">" . _ADMINGRAPHIC . "</label>";
		if ($admingraphic==1) {
			echo "<input type='radio' name='xadmingraphic' value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name='xadmingraphic' value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xadmingraphic' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xadmingraphic' value='0' checked>" . _NO . "";
		}

		echo "<label for=\"" . _ACTIVATEHTTPREF . "\">" . _ACTIVATEHTTPREF . "</label>";
		if ($httpref==1) {
			echo "<input type='radio' name=xhttpref value='1' checked>" . _YES . " &nbsp;
	<input type='radio' name=xhttpref value='0'>" . _NO . "";
		} else {
			echo "<input type='radio' name='xhttpref' value='1'>" . _YES . " &nbsp;
	<input type='radio' name='xhttpref' value='0' checked>" . _NO . "";
		}


		echo "  <label for=\"" . _MAXREF . "\">" . _MAXREF . "</label>
<select name='xhttprefmax'>"
		."<option name='xhttprefmax' value='$httprefmax'>$httprefmax</option>"
		."<option name='xhttprefmax' value='100'>100</option>"
		."<option name='xhttprefmax' value='250'>250</option>"
		."<option name='xhttprefmax' value='500'>500</option>"
		."<option name='xhttprefmax' value='1000'>1000</option>"
		."<option name='xhttprefmax' value='2000'>2000</option>"
		."</select>";


		echo " <label for=\"" . _PASSWDLEN . "\">" . _PASSWDLEN . "</label>
<select name='xminpass'>"
		."<option name='xminpass' value='$minpass'>$minpass</option>"
		."<option name='xminpass' value='3'>3</option>"
		."<option name='xminpass' value='5'>5</option>"
		."<option name='xminpass' value='8'>8</option>"
		."<option name='xminpass' value='10'>10</option>"
		."</select>";



		if ($CensorMode == 0) {
			$sel0 = "selected";
			$sel1 = "";
			$sel2 = "";
			$sel3 = "";
		} elseif ($CensorMode == 1) {
			$sel0 = "";
			$sel1 = "selected";
			$sel2 = "";
			$sel3 = "";
		} elseif ($CensorMode == 2) {
			$sel0 = "";
			$sel1 = "";
			$sel2 = "selected";
			$sel3 = "";
		} elseif ($CensorMode == 3) {
			$sel0 = "";
			$sel1 = "";
			$sel2 = "";
			$sel3 = "selected";
		}

		echo "<label for=\"" . _CENSORMODE . "\">" . _CENSORMODE . "</label>
        <select name='xCensorMode'>"
		."<option name='xCensorMode' value='0' $sel0>" . _NOFILTERING . "</option>"
		."<option name='xCensorMode' value='1' $sel1>" . _EXACTMATCH . "</option>"
		."<option name='xCensorMode' value='2' $sel2>" . _MATCHBEG . "</option>"
		."<option name='xCensorMode' value='3' $sel3>" . _MATCHANY . "</option>"
		."</select>

		<label for=\"" . _CENSORREPLACE . "\">" . _CENSORREPLACE . "</label>
            <input type='text' name='xCensorReplace' value='$CensorReplace' size='10' maxlength='10' />";

		echo " </fieldset>";

	}
	function footer_st(){
		global $foot1,$foot2,$foot3;
		//--- Footer SETTINGS ----------------------
		echo "<fieldset>
            <legend>" . _FOOTERMSG . "</legend>
            <label for=\"" . _FOOTERLINE1 . "\">" . _FOOTERLINE1 . "</label>";
		//<textarea name='xfoot1' cols='70' rows='15'>" . stripslashes($foot1) . "</textarea>"
		wysiwyg_textarea('xfoot1', $foot1, 'PHPNuke', '80', '2');

		echo "<label for=\"" . _FOOTERLINE2 . "\">" . _FOOTERLINE2 . "</label>";
		//<textarea name='xfoot2' cols='70' rows='15'>" . stripslashes($foot2) . "</textarea>"
		wysiwyg_textarea('xfoot2', $foot2, 'PHPNuke', '50', '5');


		echo "<label for=\"" . _FOOTERLINE3 . "\">" . _FOOTERLINE3 . "</label>";
		//<textarea name='xfoot3' cols='70' rows='15'>" . stripslashes($foot3) . "</textarea>"
		wysiwyg_textarea('xfoot3', $foot3, 'PHPNuke', '80', '2');

		echo " </fieldset>";

		echo "<input type='hidden' name='op' value='ConfigSave'>";

	}
	function siteActivityUpdate(){
		global $db,$prefix;
		//2011-03-18 01:01:02  time pattern
		
		if (!empty($_POST['site_switch']) AND $_POST['site_switch']==1) {

		$disable_from_date = implode("-",array($_POST['disable_fyear'],$_POST['disable_fmonth'],$_POST['disable_fday']))." ".$_POST['disable_fhour'].":".$_POST['disable_fmin'].":".$_POST['disable_fsec']."";

		$disable_to_date = implode("-",array($_POST['disable_tyear'],$_POST['disable_tmonth'],$_POST['disable_tday']))." ".$_POST['disable_thour'].":".$_POST['disable_tmin'].":".$_POST['disable_tsec']."";


		$db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value` = '".sql_quote($_POST['site_switch'])."' WHERE `config_name`='site_switch' ")or die(mysql_error());
		$db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value` = '".sql_quote($disable_from_date)."' WHERE `config_name`='disable_from_date' ")or die(mysql_error());
		$db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value` = '".sql_quote($disable_to_date)."' WHERE `config_name`='disable_to_date' ")or die(mysql_error());
		$db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value` = '".sql_quote(unescape($_POST['disable_reason']))."' WHERE `config_name`='disable_reason' ")or die(mysql_error());
	
}else {
		$db->sql_query("UPDATE `".$prefix."_nsnst_config` SET `config_value` = '".sql_quote($_POST['site_switch'])."' WHERE `config_name`='site_switch' ")or die(mysql_error());
}
		site_activity_show();
		echo "<div class='success'>با موفیت به روز شد</div>";
	}
	function site_activity_show(){

		global $db,$prefix;

		$result=$db->sql_query("SELECT * FROM ".$prefix."_nsnst_config ");
		while ($activityCnfg = $db->sql_fetchrow($result)) {
		if ($activityCnfg['config_name']=='disable_from_date') {
			$disable_from_dateDB = strtotime($activityCnfg['config_value']);
			$disable_from_date =  array(
			date("Y", $disable_from_dateDB),
			date("d", $disable_from_dateDB),
			date("m", $disable_from_dateDB),
			date("g", $disable_from_dateDB),
			date("i", $disable_from_dateDB),
			date("s", $disable_from_dateDB)
			);
		}
		if ($activityCnfg['config_name']=='disable_to_date') {
			$disable_to_dateDB = strtotime($activityCnfg['config_value']);
			$disable_to_date =  array(
			date("Y", $disable_to_dateDB),
			date("d", $disable_to_dateDB),
			date("m", $disable_to_dateDB),
			date("g", $disable_to_dateDB),
			date("i", $disable_to_dateDB),
			date("s", $disable_to_dateDB)
			);
		}
		if ($activityCnfg['config_name']=='disable_reason') {
			$disable_reason = $activityCnfg['config_value'];
		}
		if ($activityCnfg['config_name']=='site_switch') {
			$site_switch = intval($activityCnfg['config_value']);
		}
		}
		echo "<br><div class='info'>
		<h3 style='text-align:".langStyle(align)."'>"._ACTIVITY."<img src='images/Guardian/".(($site_switch==0) ? "active.png" : "inactive.png")."' title='".(($site_switch==0) ? ""._SITE_ENABLED."" : ""._SITE_DISABLED."")."'></h3>
		"._DEACTIVATE_THIS_SITE."
		<select name='site_switch' id='site_switch'>
		<option value='1'  onclick=\"$('#form_insider_active').css('display','')\" ".(($site_switch==1) ? "SELECTED" : " ")."> "._YES."</option>
		<option value='0'  onclick=\"$('#form_insider_active').slideUp(300)\" ".(($site_switch==0) ? "SELECTED" : " ")."> "._NO."</option>
		</select><br>
		<br><img src='images/icon/time.png'> <b><b> "._TODAY." : </b>".date("Y/m/d g:i (A)")."<br></b><br>
		";
		echo "<div id='form_insider_active' style='".(($site_switch==0) ? "display:none" : "")."'>
		<p><b>"._FROM." : </b>
		"._YEAR." <input type='text' name='disable_fyear' id='disable_fyear' value='".(!empty($disable_from_date[0]) ? $disable_from_date[0] : date('Y'))."' size='8' style='width:40px;' />/
		"._DAY." <input type='text' name='disable_fday' id='disable_fday' value='".(!empty($disable_from_date[1]) ? $disable_from_date[1] : date('d'))."' size='8' style='width:40px;' />/
		"._MONTH." <input type='text' name='disable_fmonth' id='disable_fmonth' value='".(!empty($disable_from_date[2]) ? $disable_from_date[2] : date('m'))."' size='8' style='width:40px;' />
		   
		"._HOUR."  <input type='text' name='disable_fhour' id='disable_fhour' value='".(!empty($disable_from_date[3]) ? $disable_from_date[3] : date('g'))."' size='8' style='width:40px;' />
		"._MINUTES."  <input type='text' name='disable_fmin' id='disable_fmin' value='".(!empty($disable_from_date[4]) ? $disable_from_date[4] : date('i'))."' size='8' style='width:40px;' />
		"._SECONDS." <input type='text' name='disable_fsec' id='disable_fsec' value='".(!empty($disable_from_date[5]) ? $disable_from_date[5] : date('s'))."' size='8' style='width:40px;' />
		 <br>
		<b>"._TO.": </b>
		"._YEAR."  <input type='text' name='disable_tyear' id='disable_tyear' value='".(!empty($disable_to_date[0]) ? $disable_to_date[0] : date('Y'))."' size='8' style='width:40px;' />/
		"._DAY." <input type='text' name='disable_tday' id='disable_tday' value='".(!empty($disable_to_date[1]) ? $disable_to_date[1] : date('d'))."' size='8' style='width:40px;' />/
		"._MONTH." <input type='text' name='disable_tmonth' id='disable_tmonth' value='".(!empty($disable_to_date[2]) ? $disable_to_date[2] : date('m'))."' size='8' style='width:40px;' />
		   
		"._HOUR."  <input type='text' name='disable_thour' id='disable_thour' value='".(!empty($disable_to_date[3]) ? $disable_to_date[3] : date('g'))."' size='8' style='width:40px;' />
		"._MINUTES." <input type='text' name='disable_tmin' id='disable_tmin' value='".(!empty($disable_to_date[4]) ? $disable_to_date[4] : date('i'))."' size='8' style='width:40px;' />
		"._SECONDS." <input type='text' name='disable_tsec' id='disable_tsec' value='".(!empty($disable_to_date[5]) ? $disable_to_date[5] : date('s'))."' size='8' style='width:40px;' />
		";
		if (time() > $disable_to_dateDB) {
			echo "<img src='images/icon/date_error.png'><span style='color:red;'><b>"._DISABLE_IS_DONE."</b></span>";
		}

		echo "<br><br>
</p>
		توضیحات : 
		
		";
		//<textarea name='disable_reason' id='disable_reason' style='width:80%;min-height:200px;' >".(!empty($disable_reason) ? $disable_reason : "")."</textarea><br>
		wysiwyg_textarea('disable_reason', ''.(!empty($disable_reason) ? $disable_reason : "").'', 'PHPNukeAdmin', 50, 20);
		echo "
		<br>		
		</div>
		<input  type='button'  name='disable_switch_butt' id='disable_switch_butt' value='"._SEND."'>	
		</div>
		";

	}

	
	switch($op) {

		case "language":
				switch($action) {
					case "editlanguage":
						include_once("admin/modules/languages.php");
						editlanguage();
					break;
					case "editlanguageprocess":
						include_once("admin/modules/languages.php");
						editlanguageprocess();
					break;
				}
			break;
			
		case "Configure":
			Configure();
			break;
		case "general_st":
			general_st();
			break;
		case "security_st":
			security_st();
			break;
		case "story_st":
			story_st();
			break;
		case "optimisation_st":
			optimisation_st();
			break;
		case "language_st":
			language_st();
			break;
		case "notification_st":
			notification_st();
			break;
		case "administration_st":
			administration_st();
			break;
		case "footer_st":
			footer_st();
			break;
		case "footer_st":
			footer_st();
			break;
		case "siteActivityUpdate":
			siteActivityUpdate();
			break;

		case "ConfigSave":
			$xsitename = addslashes(check_words(check_html($xsitename, "nohtml")));
			$xnukeurl = addslashes(check_words(check_html($xnukeurl, "nohtml")));
			$xsite_logo = addslashes(check_words(check_html($xsite_logo, "nohtml")));
			$xslogan = addslashes(check_words(check_html($xslogan, "nohtml")));
			$xstartdate = addslashes(check_words(check_html($xstartdate, "nohtml")));
			$xadminmail = addslashes(check_words(check_html($xadminmail, "nohtml")));
			$xanonpost = intval($xanonpost);
			$xDefault_Theme = addslashes(check_words(check_html($xDefault_Theme, "nohtml")));
			$xfoot1 = addslashes(check_words(check_html($xfoot1, "")));
			$xfoot2 = addslashes(check_words(check_html($xfoot2, "")));
			$xfoot3 = addslashes(check_words(check_html($xfoot3, "")));
			$xcommentlimit = intval($xcommentlimit);
			$xanonymous = addslashes(check_words(check_html($xanonymous, "nohtml")));
			$xminpass = intval($xminpass);
			$xpollcomm = intval($xpollcomm);
			$xarticlecomm = intval($xarticlecomm);
			$xbroadcast_msg = intval($xbroadcast_msg);
			$xmy_headlines = intval($xmy_headlines);
			$xtop = intval($xtop);
			$xstoryhome = intval($xstoryhome);
			$xuser_news = intval($xuser_news);
			$xoldnum = intval($xoldnum);
			$xultramode = intval($xultramode);
			$xbanners = intval($xbanners);
			$xbackend_title = addslashes(check_words(check_html($xbackend_title, "nohtml")));
			$xbackend_language = addslashes(check_words(check_html($xbackend_language, "nohtml")));
			$xlanguage = addslashes(check_words(check_html($xlanguage, "nohtml")));
			$xlocale = addslashes(check_words(check_html($xlocale, "nohtml")));
			$xmultilingual = intval($xmultilingual);
			$xuseflags = intval($xuseflags);
			$xnotify = intval($xnotify);
			$xnotify_email = addslashes(check_words(check_html($xnotify_email, "nohtml")));
			$xnotify_subject = addslashes(check_words(check_html($xnotify_subject, "nohtml")));
			$xnotify_message = addslashes(check_words(check_html($xnotify_message, "nohtml")));
			$xnotify_from = addslashes(check_words(check_html($xnotify_from, "nohtml")));
			$xmoderate = intval($xmoderate);
			$xadmingraphic = intval($xadmingraphic);
			$xhttpref = intval($xhttpref);
			$xhttprefmax = intval($xhttprefmax);
			$xCensorMode = intval($xCensorMode);
			$xCensorReplace = addslashes(check_words(check_html($xCensorReplace, "nohtml")));
			$xgfx = (int) $xgfx;
			$xcodesize = (int) $xcodesize;
			$xcachesys = (int) $xcachesys;
			$xlifetime = (int) $xlifetime;
			$xnuke_editor = (int) $xnuke_editor;
			$xsec_pass = addslashes(check_words(check_html($xsec_pass, "nohtml")));
			$configstring = "sitename='$xsitename'\nnukeurl='$xnukeurl'\nsite_logo='$xsite_logo'\nslogan='$xslogan'\nstartdate='$xstartdate'\nadminmail='$xadminmail'\nanonpost='$xanonpost'\nDefault_Theme='$xDefault_Theme'\nfoot1='$xfoot1'\nfoot2='$xfoot2'\nfoot3='$xfoot3'\ncommentlimit='$xcommentlimit'\nanonymous='$xanonymous'\nminpass='$xminpass'\npollcomm='$xpollcomm'\narticlecomm='$xarticlecomm'\nbroadcast_msg='$xbroadcast_msg'\nmy_headlines='$xmy_headlines'\ntop='$xtop'\nstoryhome='$xstoryhome'\nuser_news='$xuser_news'\noldnum='$xoldnum'\nultramode='$xultramode'\nloading='$xloading'\nnextg='$xnextg'\nbanners='$xbanners'\nbackend_title='$xbackend_title'\nbackend_language='$xbackend_language'\nlanguage='$xlanguage'\nlocale='$xlocale'\nmultilingual='$xmultilingual'\nuseflags='$xuseflags'\nnotify='$xnotify'\nnotify_email='$xnotify_email'\nnotify_subject='$xnotify_subject'\nnotify_message='$xnotify_message'\nnotify_from='$xnotify_from'\nmoderate='$xmoderate'\nadmingraphic='$xadmingraphic'\nhttpref='$xhttpref'\nhttprefmax='$xhttprefmax'\nCensorMode='$xCensorMode'\nCensorReplace='$xCensorReplace'\ncopyright='Nukelearn Tigris &copy; 2009-2010 <a href=\"http://www.nukelearn.com\" target=\"_blank\">Nukelearn</a>'\nUSV_Version='Tigris 1.1.6'\nsupport='info@MarlikCMS.com'\ngfx_chk ='$xgfx'\nuse_question='$question'\ncodesize='$xcodesize'\ncache_system='$xcachesys'\ncache_lifetime='$xlifetime'\nnuke_editor='$xnuke_editor'\ntracking='1'\nsec_pass='$xsec_pass'";
			file_put_contents(BASE_PATH.".setting",$configstring);
			if($question){
				//global $db,$prefix;
				$qs = $questions;
				$as = $answers;
				foreach($qs as $qid => $qv){
					if($qv == ''){
						$db->sql_query('DELETE FROM `'.$prefix.'_squestions` WHERE `qid` = "'.$qid.'" LIMIT 1');
					}else{
						$db->sql_query('UPDATE `'.$prefix.'_squestions` SET `question` = "'.$qv.'", `answer`="'.$as[$qid].'" WHERE `qid` = "'.$qid.'" LIMIT 1');
					}
				}
			}
			if($nquestion != ''){
				$db->sql_query('INSERT INTO `'.$prefix.'_squestions` (`question`,`answer`) VALUES ("'.$nquestion.'","'.$nanswer.'")');
			}
			Header("Location: ".$admin_file.".php?op=Configure");
			break;

	}




} else {
	echo "Access Denied";
}

?>
