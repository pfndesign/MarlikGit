<?php
/**
*
* @package Downloads														
* @version $Id: getit.php 0999 2009-12-12 15:35:19Z Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
$lid = intval($lid);
$result = $db->sql_query("SELECT * FROM ".$prefix."_nsngd_downloads WHERE lid=$lid AND active>'0'");
$lidinfo = $db->sql_fetchrow($result);
$pagetitle = "-".stripslashes($lidinfo['title']);
@include("header.php");


$uinfo = cookiedecode($user);
cookiedecode($user);
$username = $cookie[1];
global $userinfo;
$userkind = $userinfo['subscribed'];
$priv = $lidinfo['sid'] - 3;

if (($lidinfo['sid'] == 0) OR ($lidinfo['sid'] == 1 AND is_user($user))  OR ($lidinfo['sid'] == 2 AND  is_admin($admin)) OR ($lidinfo['sid'] == 3 AND ($userkind == '1')) OR ($lidinfo['sid'] > 3 AND of_group($priv))) {


	if ($lidinfo['lid'] == "" OR $lidinfo['active'] == 0) {
		title(_DOWNLOADPROFILE.": "._INVALIDDOWNLOAD);
		OpenTable();
		echo "<center><b>"._INVALIDDOWNLOAD."</b></center>\n";
	} else {



		echo "<table style='width:100%;text-align:right;vertical-align:top;'><tr><td width='25%' valign='top'>";
		
		OpenTable();
		menu_cats();
		CloseTable();
		OpenTable();
		SearchForm();
		CloseTable();
		echo '</td><td style="width:70%;text-align:right;vertical-align:top;">';

		echo "<form action='modules.php?name=$module_name' method='POST'>";


		$fetchid = base64_encode($lidinfo['url']);
		echo "<input type='hidden' name='op' value='go'>";
		echo "<input type='hidden' name='lid' value='".$lidinfo['lid']."'>";
		echo "<input type='hidden' name='fetchid' value='$fetchid'>";
		
		$title = stripslashes($lidinfo['title']);
		title(_DOWNLOADPROFILE.": $title");
		OpenTable();
		mt_srand ((double)microtime()*1000000);
		$maxran = 1000000;
		$random_num = mt_rand(0, $maxran);
		$lidinfo['description'] = stripslashes($lidinfo['description']);
		//  $lidinfo['description'] = ereg_replace ("\r\n", "<br>", $lidinfo['description']);
		if (is_admin($admin)) {
			$myimage = myimage("edit.png");
			echo "<a href='".$admin_file.".php?op=DownloadModify&amp;lid=$lid' target='$lid'><img align='middle' src='$myimage' border='0' alt='"._DL_EDIT."'></a>&nbsp;";
		} else {
			$myimage = myimage("show.png");
			echo "<img align='middle' src='$myimage' border='0' alt=''>&nbsp;";
		}
		echo "<font class='title'>"._DOWNLOADPROFILE.": $title</font>
    <div style='float:left;'>".pullRating('2',$lidinfo['rate'],$lidinfo['rates_count'],$lid,true,true,true)."</div>
    <br>
     <div style='clear:both;'></div>
    <hr>";
		echo "".$lidinfo['description']."<br><hr>";
		// USV Build 3 -- Ajax Star Rating -- by Hamed -- Begin /Wednesday, September 30 2009/
		echo '<script type="text/javascript" src="includes/javascript/rating_update.js"></script>';
		echo '<link rel="stylesheet" href="includes/css/rating_style.css" />';



		//---------------- TAGS --------------------------------
		$tags = explode(" ",$lidinfo['tags']);
		$c = count($tags);
		$tagss = '';
		for($i=1;$i<$c-1;$i++){
			list($tag,$tagSlug) = $db->sql_fetchrow($db->sql_query('SELECT `tag`,`slug` FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tags[$i].'" LIMIT 1'));
			$tagss .= '<a href="modules.php?name=Downloads&op=tags&term='.Slugit($tagSlug).'">'.$tag.'</a>,';
		}
		if (!empty($tagss)) {
			echo '<br /><br />'."<img src='images/icon/tag_blue.png' width='16px' height='16px' alt='"._TAG."' title='"._TAG."'>".'<b>',_TAG,':</b> ',$tagss ."<br><br>\n";
		}
		//-------------------------------------------------------

		$mydate = $lidinfo['date'];
		$date = explode(" ", $mydate);

		echo "<img src='images/icon/time.png' width='16px' height='16px' alt='"._ADDEDON."' title='"._ADDEDON."'><b>"._ADDEDON.":</b> " . hejridate($date[0], 1) . "<br>\n";

		echo "<img src='images/icon/chart_bar.png' width='16px' height='16px' alt='"._DOWNLOADS."' title='"._DOWNLOADS."'><b>"._DOWNLOADS.":</b> ".$lidinfo['hits']."<br>";

		if (CoolSize($lidinfo['filesize'])>0) {
			echo "<img src='images/icon/tag.png' width='16px' height='16px' alt='"._FILESIZE."' title='"._FILESIZE."'><b>"._FILESIZE.":</b> ".CoolSize($lidinfo['filesize'])."<br>";
		}

		if (!empty($lidinfo['version'])) {
			echo "<img src='images/icon/lightbulb.png' width='16px' height='16px' alt='"._VERSION."' title='"._VERSION."'><b>"._VERSION.":</b> ".$lidinfo['version']."<br>\n";
		}


		if (!empty($lidinfo['password'])) {
			echo "<img src='images/icon/key.png' width='16px' height='16px' alt='"._PASSWORD."' title='"._PASSWORD."'><b>"._PASSWORD.":</b> ".$lidinfo['password']."<br>\n";
		}

		if ($lidinfo['source'] == "" || $lidinfo['source'] == "http://") {

		} else {
			echo "<img src='images/icon/link.png' width='16px' height='16px' alt='"._SOURCE."' title='"._SOURCE."'><b>"._SOURCE.":</b> ";
			echo "<a href='".$lidinfo['source']."' target='new'>".$lidinfo['source']."</a><br />";
		}



		if ($lidinfo['homepage'] == "" || $lidinfo['homepage'] == "http://") {
		} else {
			echo "<img src='images/icon/world_link.png'width='16px' height='16px' alt='"._HOMEPAGE."' title='"._HOMEPAGE."'><b>"._HOMEPAGE.":</b> ";
			echo "<a href='".$lidinfo['homepage']."' target='new'>".$lidinfo['homepage']."</a><hr>";
		}

		if (($lidinfo['sid'] == 0) OR ($lidinfo['sid'] == 1 AND is_user($user))  OR ($lidinfo['sid'] == 2 AND  is_admin($admin)) OR ($lidinfo['sid'] == 3 AND ($userkind == '1')) OR ($lidinfo['sid'] > 3 AND of_group($priv))) {

			if ($dl_config['usegfxcheck'] == 1) {echo _DL_DIRECTIONS." "._DL_DLNOTES1."$title"._DL_DLNOTES2."</font><br><br>";}
			echo "<center><table border='0'>";

			if ($dl_config['usegfxcheck'] == 1) {
				if (extension_loaded("gd")) {
					echo "<tr><td><b>"._DL_YOURPASS.":</b></td><td><img src='modules.php?name=$module_name&amp;op=gfx&amp;random_num=$random_num' height='20' width='80' border='0' alt='"._DL_YOURPASS."' title='"._DL_YOURPASS."'></td></tr>";
					echo "<tr><td><b>"._DL_TYPEPASS.":</b></td><td><input type='text' name='passcode' size='10' maxlength='10'></td></tr>";
					echo "<input type='hidden' NAME='checkpass' value='$random_num'>";
				} else {
					$datekey = date("F j");
					$rcode = hexdec(md5($_SERVER[HTTP_USER_AGENT] . $sitekey . $random_num . $datekey));
					$code = substr($rcode, 2, 8);
					$ThemeSel = get_theme();
					if (file_exists("themes/$ThemeSel/images/downloads/code_bg.png")) {
						$imgpath = "themes/$ThemeSel/images";
					} else {
						$imgpath = "images";
					}
					echo "<tr><td><b>"._DL_YOURPASS.":</b></td><td height='20' width='80' background='$imgpath/code_bg.png' class='storytitle' align='center'><b>$code</b></td></tr>";
					echo "<tr><td><b>"._DL_TYPEPASS.":</b></td><td><input type='text' name='passcode' size='10' maxlength='10'></td></tr>";
					echo "<input type='hidden' name='checkpass' value='$code'>";
				}
			}
			echo "</table></center><br>";
			echo "<font class='content'>[ <a href='modules.php?name=$module_name&amp;op=modifydownloadrequest&amp;lid=$lid'><b>"._MODIFY."</b></a> ]</font><div style='text-align:center;'>
<input type='submit' name='"._DL_GOGET."' value='"._DL_GOGET."' 
style='width:200px;background:none;background-color:#D54E21;color:white;padding:10px 15px;'>
</div></form>\n";
		} else {
			restricted($lidinfo['sid']);
		}
	}
	CloseTable();
} else {
	OpenTable();
	restricted($lidinfo['sid']);
	CloseTable();
}
echo '</td></tr></table>';

@include("footer.php");
?>