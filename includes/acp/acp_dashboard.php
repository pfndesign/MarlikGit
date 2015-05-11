<?php
/**
 *
 * @package acp														
 * @version $Id: acp_dashboard.php 6:45 PM 1/9/2010 Aneeshtan $						
 * @copyright (c) Marlik Group  http://www.MarlikCMS.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
/**
 * @ignore
 */
if (! defined ( 'ADMIN_FILE' )) {
	exit ();
}
require (INCLUDES_ACP . 'acp_style.php');
require (INCLUDES_ACP . 'acp_news.php');
function ADMIN_PANE() {
	if (! defined ( 'ADMIN_FILE' )) {
		die ( "Access Denied" );
	}
	global $language, $admin, $aid, $prefix, $file, $db, $sitename, $user_prefix, $admin_file, $bgcolor1, $locale, $USV_Version, $Default_Theme, $queries_count, $total_mem, $start_mem, $ab_config;
	if (is_admin($aid)) {
		jq_toggle_box ( 'xmain', 'a', 'pane_iframe' );
		$admin_home = ajaxify_home ;
		echo "<body>\n";
		?>
		<div class="helpLinks"><!-- divider --> <!-- PANE HIDE -->
		<div id="pane_iframe" style="text-align:center;">
		<table style="width: 100%">
			<tr>
				<td style="width: 50%" class="wrapperDIV">
				<div id="nav">
				<ul>
				<li><a class="selected" href="<?php	echo ADMIN_OP?>GraphicAdminM"><img src="images/icon/user_red.png"><?php
				echo _AP_SITEADMIN?></a></li>
				<li><a href="<?php	echo ADMIN_OP?>GraphicModules"><img src="images/icon/plugin.png"><?php
				echo _AP_MODULEADMIN?></a></li>
				</ul>
				</div>
				<hr>
				<div id="wrapper"></div>
				</td>
				<td style="width: 50%" class="wrapperDIV">
				<?php ADMIN_INFO ();
		?>
				</td>
			</tr>
		</table>
		</div>
		<script langauge="JavaScript"type="text/javascript">
		$(function() {
			function a(b) {
				$.get(b,function(c) {
					$("#wrapper").fadeIn('fast',function() {
						$(this).html(c).fadeIn('fast',function() {
						}
						)
					}
					)
				}
				)
			}
			$("div#nav ul li a").click(function() {
				$('#nav ul li a.selected').removeClass('selected');
				$(this).addClass('selected');
				a($(this).attr('href'));
				return false
			}
			);
			a('<?php echo $admin_home ?>')
		}
		);
		</script>
		<div style="font-size:11px;color:white;text-align:center;"><?php echo _HIDE_SHOW ?></div>
		</div>
		<div id="pane_iframe-toggle">
		<a href="#" id="xmain"><center><img src="<?php echo INCLUDES_ACP?>style/images/hide_show_panel.png" alt="Banner" border="0px" /></a>
		</div>
		<br>
		<div style="margin:0px auto;">
		<!-- END PANE -->
		<?php
		if (file_exists(INCLUDES_PATH."inc_errors.php")) {
			require_once(INCLUDES_PATH."inc_errors.php");
		}
		?></div><?php
	} else {
		show_error (HACKING_ATTEMPT);
	}
}
function ADMIN_NOTIFICATIONS() {
	if (! defined ( 'ADMIN_FILE' )) {
		die ( "Access Denied" );
	}
	global $language,$admin,$prefix, $file, $db, $sitename, $user_prefix, $admin_file, $bgcolor1, $locale, $USV_Version, $Default_Theme, $queries_count, $total_mem, $start_mem, $ab_config;
	if ((is_superadmin($admin)) || (is_admin_of('News',$admin))) {
		if (is_active ( "News" )) {
			echo '<table style="width:100%"><tr>';
			echo '<td  style="width:50%" class="box_wrapper"><br><br>';
			news_list ();
			echo '</td>' . //End Left sider
			'<td  style="width:50%" class="box_wrapper"><br><br>';
			if (!comments_moderated(0,'')) {
				acp_help();
			} else {
				echo comments_moderated ( '0', '' );
			}
			echo "</td>";
			//End Left sider
			echo "</tr></table>";
		} else {
			acp_help();
		}
	}
	?> 
			<script type="text/javascript" src="<?php echo INCLUDES_ACP?>style/js/showroom.js"></script>
			<script type="text/javascript">
			$(document).ready(function() {
		$("div#RSSLoad").html('<img src="images/loading.gif">');
		$.ajax( {
			cache:false,url:"<?php echo ADMIN_OP?>MarlikCMS_RSS",success:function(a) {
				$("#RSSLoad").html(a)
			}
			,error:function() {
				$("div#RSSDivLoad").html('<img src="images/loading.gif">')
			}
		}
		)
	}
	);
	</script>
			<div class='clear'></div>
			<div id='RSSLoad'></div>
		<?php
}
function acp_help() {
	global $db;
	$help_show = "<div class='notify'><a href='JavaScript:void(0);' id='openup' ><img src='images/icon/help.png'><img src='images/icon/arrow_out.png'>&nbsp;<b>"._ADMIN_HELP_NOTE."</b></a></div><br>
<div id='notes'  class='notify' style='direction:".langstyle("direction")."';text-align:".langstyle("align")."';>"._ADMIN_HELP_NOTE_NOTE."<br><br>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."Configure'> "._ADMIN_HELP_NOTE_CONFIGURATION."</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."adminStory'> "._ADMIN_HELP_NOTE_adminStory."		</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."mod_authors'> "._ADMIN_HELP_NOTE_mod_authors." 	</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."Configure'>"._ADMIN_HELP_NOTE_ABMain."				</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."BlocksAdmin'> "._ADMIN_HELP_NOTE_BlocksAdmin." 	</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."ipban'> "._ADMIN_HELP_NOTE_ipban."  				</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."Configure'> "._ADMIN_HELP_NOTE_CONFIGURATION2."	</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."tracking'> "._ADMIN_HELP_NOTE_CONFIGURATION3." 	</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."ShowNewsPanel'> "._ADMIN_HELP_NOTE_ShowNewsPanel."	</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."modules'> "._ADMIN_HELP_NOTE_modules." 			</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."database'> "._ADMIN_HELP_NOTE_database." 			</a></li>
<li><img src='images/icon/bullet_green.png'><a href='".ADMIN_OP."mod_users'> "._ADMIN_HELP_NOTE_mod_users."			</a></li>
</div>"
		.'<script>
    $("#openup").click(function () { 
    $("#notes").slideToggle();  
    });
</script>';
	echo $help_show;
}
function ADMIN_INFO() {
	global $language, $admin, $aid, $prefix, $file, $db, $sitename, $user_prefix, $admin_file, $locale, $USV_Version, $CacheSystem, $Default_Theme, $queries_count, $total_mem, $start_mem, $ab_config,$nuke_editor;
	if (is_admin($aid)) {
		list ( $main_module ) = $db->sql_fetchrow ( $db->sql_query ( "SELECT main_module from " . $prefix . "_main" ) );
		//0-- Fetch Registration Count
		$dummy = 0;
		$month = date ( 'M' );
		$curDate2 = "%" . $month [0] . $month [1] . $month [2] . "%" . date ( 'd' ) . "%" . date ( 'Y' ) . "%";
		$ty = time () - 86400;
		$preday = strftime ( '%d', $ty );
		$premonth = strftime ( '%B', $ty );
		$preyear = strftime ( '%Y', $ty );
		$curDateP = "%" . $premonth [0] . $premonth [1] . $premonth [2] . "%" . $preday . "%" . $preyear . "%";
		list($gfx_chk,$use_question)= $db->sql_fetchrow ( $db->sql_query ( "SELECT  gfx_chk,use_question FROM " . USV_CONFIGS_TABLE . ""));
		if ($use_question = 1) {
			$SECURITY_CODE = _SECURITYCODE;
		} else {
			$SECURITY_CODE = _SECURITY_QUESTION;
		}
		list ( $totaluser ) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(user_id) AS userCount from " . $user_prefix . "_users ") );
		list ( $userCount) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(user_id) AS userCount from " . $user_prefix . "_users WHERE user_regdate LIKE '$curDate2'"));
		list ( $userCount2) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(user_id) AS userCount FROM " . $user_prefix . "_users WHERE user_regdate LIKE '$curDateP'"));
		list($totalcomm) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(tid) AS totalcomm from " . COMMENTS_TABLE . ""));
		list($waiting_comm) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(tid) AS waiting_comm from " . COMMENTS_TABLE . " WHERE active='0'"));
		list($totalposts) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(sid) AS totalposts from " . STORY_TABLE . ""));
		list($waiting_posts) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(sid) AS waiting_posts from " . STORY_TABLE . " WHERE approved='2'"));
		list($totalfiles) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(lid) AS totalfiles from " . DOWNLOAD_TABLE . ""));
		list($waiting_files) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(lid) AS waiting_files from " . SUBMIT_DOWNLOAD_TABLE . ""));
		list($totaltags) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(tid) AS totaltags from " . TAGS_TABLE . ""));
		list($totalcats) = $db->sql_fetchrow ( $db->sql_query ( "SELECT COUNT(topicid) AS totalcats from " . USV_TOPICS_TABLE . ""));
		if (empty ( $USV_Version )) {
			$USV_Version = "Installation NOt Compeleted";
		}else {
			/*
			$file = fopen ("http://www.MarlikCMS.com/version.html", "r");
			while (!feof ($file)) {
				$line = fgets ($file, 1024);
				if (preg_match ("@\<title\>(.*)\</title\>@i", $line, $out)) {
					$USV_Version_online = $out[1];
					break;
				}
			}
			fclose($file);
			*/
			

		}
		
		
		$mouseover_effect = 'style="background-color:#F5F5F5;color:white" onMouseOver="this.style.backgroundColor=\'#FFCC00\'"
 onMouseOut="this.style.backgroundColor=\'#F5F5F5\'"';

		echo '
<center><table class="widefat comments fixed"  id="tableinfo">
    <colgroup>
    	<col />
    	<col />
    	<col />
        <col />
    </colgroup>
    <thead>
    	<tr ' . $mouseover_effect . '>
        	<th scope="col">' . _TITLE . '</th>
            <th scope="col">' . _DESCRIPTION . '</th>
            <th scope="col">' . _TITLE . '</th>
            <th scope="col">' . _DESCRIPTION . '</th>
        </tr>
    </thead>
    <tbody>
<tr ' . $mouseover_effect . '>
	<td>' . _SITENAME . ' </td> 
		<td><strong>' . $sitename . ' </strong></td> 
		<td>' . _MODULEINHOME . ' </td> 
		<td><strong>' . $main_module . '&nbsp;&nbsp;[ <a href="' . ADMIN_OP . 'modules"><img src="images/icon/building_edit.png"  border="0" width="16" height="16" alt="' . _CHANGE . '" title="' . _CHANGE . '"></a> ]</strong></td> 
	</tr> ';
		echo '<tr ' . $mouseover_effect . '>
		<td>' . _ALL . '&nbsp;' . _REGISTERED_USERS . ' </td> 
		<td><span  class="approved">' .$totaluser. '</span></td> 
		<td>' . _REGISTERED_USERS . '&nbsp;' . _BTD . ' 
		<strong>' . $userCount . '</strong>
		</td> 
		<td>
		' . _REGISTERED_USERS . '&nbsp;' . _BYD . '
		<strong>' . $userCount2 . '</strong></td> 
	</tr> ';
		echo '<tr ' . $mouseover_effect . '>
		<td>' . _USV_VERSION .'</td> 
		<td><strong>' . $USV_Version . '</strong></td> 
		<td>' . _CHK_VER . '</td> '
				.'<td><a href="http://www.MarlikCMS.com/version.html" target="_blank">'.($USV_Version == trim($USV_Version) ? '<img src="images/icon/tick.png">'._LATEST_MarlikCMS_VERSION : '<img src="images/icon/cross.png">'. _NEWVERSION).'</a></td>
		</tr>
	<tr ' . $mouseover_effect . '>
	<td><span class="approved">' . intval($totalposts) . '</span><a href="'.ADMIN_OP.'ShowNewsPanel">
		&nbsp;'._ARTICLES.' 
		</a></td> 
		<td><span class="waiting">' . intval($waiting_posts) . '</span><a href="'.ADMIN_OP.'ShowNewsPanel">
		&nbsp;'._WAITING.'&nbsp;'. _ARTICLES.' 
		</a></td> 
	<td><span class="approved">' . intval($totalcomm) . '</span><a href="'.ADMIN_OP.'moderation_news">&nbsp;'. _COMMENTS_ALL.' </a></td> 
		<td><span class="waiting">' . intval($waiting_comm) . ' </span> <a href="'.ADMIN_OP.'moderation_news">
		&nbsp;'._COMMENTS_WAITING.' 
		</a></td> 
	</tr>
	<tr ' . $mouseover_effect . '>
		<td><span class="approved">' . intval($totalfiles) . '</span><a href="'.ADMIN_OP.'DLMain">
		&nbsp;'._DOWNLOAD.' 
		</a></td> 
		<td><span class="waiting">' . intval($waiting_files) . '</span><a href="'.ADMIN_OP.'DownloadNew">
		&nbsp;'._WAITING.'&nbsp;'. _DOWNLOAD.' 
		</a></td>  
		<td><span class="approved">' . intval($totaltags) . '</span><a href="'.ADMIN_OP.'Tags">
		&nbsp;'._KEYWORDS.' 
		</a></td>  
		<td><span  class="approved">' . intval($totalcats) . '</span><a href="'.ADMIN_OP.'topicsmanager">
		&nbsp;'._TOPICS.' 
		</a></td>  
	</tr>';
		echo '<tr ' . $mouseover_effect . '>
		<td>' . _THEME_DEFAULT . '</td> 
		<td><strong>' . $Default_Theme . '</strong> &nbsp;&nbsp; <a href="' . ADMIN_OP . 'Configure">
		<img src="images/icon/building_edit.png"  border="0" width="16" height="16" alt="' . _CHANGE . '" title="' . _CHANGE . '"></a> </td> 
			<td>' . _CACHE_ACTIVE . ' </td> 
		<td><strong> ';
		if ($CacheSystem == 1) {
			echo "" . _ENABLED . "";
		} else {
			echo "" . _DISABLE . "";
		}
		echo '</strong></td>
        </tr>
 <tr '.$mouseover_effect.'>
		<td>'. _SECURITYCODE .'</td> 
		<td><strong>'.$SECURITY_CODE.'</strong> &nbsp;&nbsp;[ <a href="' . ADMIN_OP . 'UsersConfig"><img src="images/icon/building_edit.png"  border="0" width="16" height="16" alt="'. _CHANGE .'" title="'. _CHANGE .'"></a> ]</td> 
	<td>' . _EDITOR . ' </td> 
	<td><strong> ';
		if ($nuke_editor == 1) {
			echo "" . _ENABLED . "";
		} else {
			echo "" . _DISABLE . "";
		}
		echo '</strong></td>
      </tr>'
				. '</tbody>
    </table></center>';
	}
}
function GraphicAdmin() {
	ADMIN_PANE ();
}
function GraphicAdminM() {
	global $admin,$aid, $admingraphic, $language, $prefix, $db, $counter, $admin_file;
	$newsubs = $db->sql_numrows ( $db->sql_query ( "SELECT qid FROM " . $prefix . "_queue" ) );
	list($radminsuper) = $db->sql_fetchrow ( $db->sql_query ( "SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'" ) );
	if (is_superadmin($admin)) {
		echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\"><tr>";
		$linksdir = dir ( "admin/links" );
		$menulist = "";
		while ( $func = $linksdir->read () ) {
			if (substr ( $func, 0, 6 ) == "links.") {
				$menulist .= "$func ";
			}
		}
		closedir ( $linksdir->handle );
		$menulist = explode ( " ", $menulist );
		sort ( $menulist );
		for ($i = 0; $i < sizeof ( $menulist ); $i ++) {
			if (! empty ( $menulist [$i] )) {
				$sucounter = 0;
				include ($linksdir->path . "/$menulist[$i]");
			}
		}
		echo "</tr></table></center>";
		$counter = "";
		echo "<br>";
	} else {
		echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\"><tr>";
		include("admin/links/links.editadmins.php");
		echo "</tr></table></center>";
	}
}
function GraphicModules() {
	global $aid, $admingraphic, $language, $admin, $prefix, $db, $counter, $admin_file;
	$newsubs = $db->sql_numrows($db->sql_query("SELECT qid FROM ".$prefix."_queue"));
	$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM ".$prefix."_authors WHERE aid='$aid'"));
	$radminsuper = intval($row['radminsuper']);
	echo"<table border=\"0\" width=\"100%\" cellspacing=\"1\"><tr>";
	$handle=opendir('modules');
	$modlist = "";
	while ($file = readdir($handle)) {
		if ( (!stristr("[.]",$file)) ) {
			$modlist .= "$file ";
		}
	}
	closedir($handle);
	$modlist = explode(" ", $modlist);
	sort($modlist);
	for ($i=0; $i < sizeof($modlist); $i++) {
		if(!empty($modlist[$i])) {
			$row = $db->sql_fetchrow($db->sql_query("SELECT mid from " . $prefix . "_modules where title='$modlist[$i]'"));
			$mid = intval($row['mid']);
			if (empty($mid)) {
				$db->sql_query("insert into " . $prefix . "_modules values (NULL, '$modlist[$i]', '$modlist[$i]', '0', '0', '1', '0', '')");
			}
		}
	}
	$result = $db->sql_query("SELECT title, admins FROM ".$prefix."_modules ORDER BY title ASC");
	$row2 = $db->sql_fetchrow($db->sql_query("SELECT name FROM ".$prefix."_authors WHERE aid='$aid'"));
	while ($row = $db->sql_fetchrow($result)) {
		$admins = explode(",", $row['admins']);
		$auth_user = 0;
		for ($i=0; $i < sizeof($admins); $i++) {
			if ($row2['name'] == $admins[$i]) {
				$auth_user = 1;
			}
		}
		if ($radminsuper == 1 OR $auth_user == 1) {
			if (file_exists("modules/".$row['title']."/admin/index.php") AND file_exists("modules/".$row['title']."/admin/links.php") AND file_exists("modules/".$row['title']."/admin/case.php")) {
				include("modules/".$row['title']."/admin/links.php");
			}
		}
	}
	echo"</tr></table></center>";
}
//----ABOUT MarlikCMS ------
function about_us() {
	global $db;
	$help_show = "<div  style='background:#fff;width:500px;height:300px;padding:5px;' >".'
<p>
<img src="includes/acp/style/images/admin_logo.png" align="left" style="float:left;text-align:left;" /></p><hr>
<b>'._VERSION.' : 
'.USV_VERSION.'</b>
<p>
<div style="clear:both;float:none"></div>
MarlikCMS Content Management System
<a href="http://MarlikCMS.com">http://MarlikCMS.com</a>
</p>
<p>
<br>'._MarlikCMS_LICENSE.'
<a href="http://MarlikCMS.com/page/license">http://MarlikCMS.com/page/license</a>
</p>
<p>
Copyright @ MarlikCMS - Farshad Ghazanfari - All Right Reserved <br><br>
'._MarlikCMS_TEAM.'
<a href="http://MarlikCMS.com/page/team">http://MarlikCMS.com/page/team</a>
</p>
</div>';
	echo $help_show;
}
?>