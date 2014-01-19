<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */


if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { show_error("Access Denied"); }

if (!defined('ADMIN_FILE')) {show_error("Access Denied");}


function YMenu(){
	global $ya_config, $module_name, $db, $user_prefix, $bgcolor2, $bgcolor1, $textcolor1, $find, $what, $match, $query, $admin_file;

	$menuValue ="<div style='line-height:19px;background:#E8E8E8;padding-right:20px;text-align:".langStyle(align).";'>"
	."<span><a href='".ADMIN_OP."mod_users'><img src='images/icon/house.png'>"._USERADMIN."</a></span><hr>"
	."<span><a href='".ADMIN_OP."addUser'><img src='images/icon/user_add.png'>"._ADDUSER."</a></span><hr>"
	."<span><a href='".ADMIN_OP."searchUser'><img src='images/icon/zoom.png'>"._SEARCHUSERS."</a></span><hr>"
	."<span><a href='".ADMIN_OP."UsersConfig'><img src='images/icon/bricks.png'>"._USERSCONFIG."</a></span><hr>"
	."<span><a href='".ADMIN_OP."CookieConfig'><img src='images/icon/coins.png'>"._COOKIECONFIG."</a></span><hr>"
	."<span><a href='".ADMIN_OP."tosMain'><img src='images/icon/user_edit.png'>"._EDITTOS."</a></span><hr>"
	."<span><a href='".ADMIN_OP."Yregpanel'><img src='images/icon/tag_blue_add.png'>"._YA_REGPANEL."</a></span>"
	."</div>";
	echo $menuValue;

}
function Ystats(){
	global $ya_config, $module_name, $db, $user_prefix, $bgcolor2, $bgcolor1, $textcolor1, $find, $what, $match, $query, $admin_file;

	$act = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_level>'0' AND user_id>'1'"));
	$sus = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_level='0' AND user_id>'1'"));
	$del = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_level='-1' AND user_id>'1'"));
	$nor = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users WHERE user_id>'1'"));
	$pen = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users_temp"));

	echo '<table class="widefat" style="line-height:32px;font-size:15px;" >
    <thead>
    	<tr>
        	<th scope="col">' . _TITLE . '</th>
            <th scope="col">' . _DESCRIPTION . '</th>
        </tr>
    </thead>
    <tbody>';


	echo "<tr>\n";
	echo "<td><a href='".ADMIN_OP."listnormal&query=a'>"._NORMALUSERS.":</a></td>";
	echo "<td class='approved'>$nor</td>\n";
	echo "</tr>\n";
	echo "<td><a href='".ADMIN_OP."listnormal&query=1'>"._ACTIVEUSERS.":</a></td>";
	echo "<td class='approved'>$act</td>\n";
	echo "</tr>\n";
	echo "<td><a href='".ADMIN_OP."listnormal&query=-1'>"._DELETEUSERS.":</a></td>";
	echo "<td class='waiting'>$del</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td><a href='".ADMIN_OP."listnormal&query=0'>"._SUSPENDUSERS.":</a></td>";
	echo "<td class='waiting'>$sus</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td><a href='".ADMIN_OP."listpending'>"._WAITINGUSERS.":</a></td>";
	echo "<td class='waiting'>$pen</td>\n";
	echo "</tr>\n";

	echo "</tbody></table>\n";

}
function YLSearch(){

?>
 <script type="text/javascript">
 $(document).ready(function(){$(".search").keyup(function(){var a=$(this).val();var b="searchword="+a;if(a==""){}else{$.ajax({type:"POST",url:"<?php echo ADMIN_OP?>YAutoSuggest",data:b,cache:false,success:function(c){$("#display").html(c).show()}})}return false})});
</script>
 <link rel="stylesheet" type="text/css" media="screen" href="modules/Your_Account/includes/style/YAdminPanel.css" />
<div id="searchdiv">
<input type="text" class="search" id="searchbox" /> <center><b><img src="images/icon/zoom.png"><?php echo _SEARCH_LIVE ?></b></center>
</div>
<div id="display"></div>


<?php

}

global $radminuser,$admin;
if (is_superadmin($admin) OR ($radminuser==1)) {

	$pagetitle = ": "._USERADMIN." - "._YA_USERS;

	OpenTable();
	echo "<h3>" . _USERADMIN ."</h3><br>";
	echo "<table width='100%' style='background:none;border:0px;'><tr>
		<td style='width:20%;padding-right:50px;vertical-align:top'>";

	echo YMenu();

	echo "</td><td style='width:30%;vertical-align:top'>";

	echo Ystats();

	echo "</td><td style='width:35%;vertical-align:top'>";

	echo YLSearch();

	echo "</td></tr></table>";
	CloseTable();

}else {
	show_error(HACKING_ATTEMPT);
}

?>