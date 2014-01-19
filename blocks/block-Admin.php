<?php


if ( !defined('BLOCK_FILE') ) {
	Header("Location: ../index.php");
	die();
}

global $currentlang, $prefix, $db,$admin;
/*----------------------------------------------*/
if(is_admin($admin)) {
 
	$row  = $db->sql_fetchrow ( $db->sql_query ("SELECT (SELECT COUNT(tid)  from " . COMMENTS_TABLE . " WHERE active='0' ) waiting_comm,
	 (SELECT COUNT(sid) from " . STORY_TABLE . " WHERE approved='2' ) waiting_posts,
	 (SELECT COUNT(lid)  from " . SUBMIT_DOWNLOAD_TABLE . ") waiting_files; 
	 "));

		list($waiting_comm) =$row['waiting_comm'];
		list($waiting_posts) = $row['waiting_posts'];
		list($waiting_files) =  $row['waiting_files'];
		
$content .= '
	<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />
	<script src="modules/Topics/includes/jquery.treeview.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#adminPanel").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
';

	
 $content .= "<center><a href='".ADMIN_PHP."'><img src='images/icon/user_gray.png'>" ._ADMIN_MAINPAGE. "</a></center><hr>";
 $content .= '<ul id="adminPanel" class="filetree">'."\n";
 $content .= "<li><span class='folder'><b>" . _ADMIN . "</b></span>";
 $content .= "<ul>

					<li><span class='file'><a href=\"".ADMIN_OP."database\">". _DATABASEADMIN ."</span></span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."BlocksAdmin\">". _ADMIN_BLOCKADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."modules\">". _ADMIN_MODULESADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."mod_authors\">". _EDITADMINS ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."Menu\">". _ADMIN_MENUADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."moderation_news\">". _ADMIN_MODERATIONADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."Points\">". _ADMIN_POINTSADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."Configure\">". _ADMIN_CONFIGUREADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."Tags\">". _ADMIN_TAGESADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."tracking\">". _ADMIN_TRACKINGIPADMIN ."</span></a></li>
					<li><span class='file'><a href=\"".ADMIN_OP."StatMain\">". _ADMIN_STATADMIN ."</span></a></li>
			</ul>
			</li>
 <hr>";

 $content .= "<li><span class='folder'><b>". _ADMIN_MODULESADMIN. "</b></span>";
 $content .= "<ul>
				<li><span class='file'><a href=\"".ADMIN_OP."BannersAdmin\">". _BANNERS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."contact#Default\">". _ADMIN_MODULE_CONTACT ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."DLMain\">". _DOWNLOAD ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."MetaConfig\">". _ADMIN_MODULE_META ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."linktous_config\">". _ADMIN_MODULE_LINKTOUS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."ShowNewsPanel\">". _ADMIN_MODULE_NEWSADMIN ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."mSearch\">". _ADMIN_MODULE_MSEARCH ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."SMConfig\">". _ADMIN_MODULE_SITEMAP ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."polledit_select\">". _ADMPOLLS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."topicsmanager\">". _TOPICS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."Links\">". _WEBLINKS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."mod_users\">". _EDITUSERS ."</span></a></li>
				<li><span class='file'><a href=\"".ADMIN_OP."jCalendar\">". _ADMIN_MODULE_JCALENDAR ."</span></a></li>
			</ul>
			</li>
				<hr>";
				 
$content .= "<li><span class='folder'><b>". _WAITINGCONT ."</b></span>";
$content .= "<ul>
				<li><span class='file'><a href=\"".ADMIN_OP."ShowNewsPanel\">". _SUBMISSIONS ."</a> :<b> <font color=\"red\">$waiting_posts</font></b></span></li>
				<li><span class='file'><a href=\"".ADMIN_OP."DownloadNew\">". _ADMIN_WAIT_DOWNlOADSEND ."</a> : <b><font color=\"red\">$waiting_files</font></b> </span></li>
				<li><span class='file'><a href=\"".ADMIN_OP."moderation_news\">". _ADMIN_WAIT_MODERATION ."</a> : <b><font color=\"red\">$waiting_comm</font> </b></span></li>
			</ul>
			</li>
				<hr>";
$content .= "<center><a href='".ADMIN_OP."logout'><img src='images/icon/status_offline.png'>" ._ADMINLOGOUT ."</a></center><br>
</ul>";
}else {
        $content .= "<b>". _ADMIN_YOUARENOT ."</b>";
}
?>