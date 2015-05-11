<?php
/*
	+-----------------------------------------------------------------------------------------------+
	|																								|
	|	* @package USV MarlikCMS PORTAL																|
	|	* @version : 1.0.0.599																		|
	|																								|
	|	* @copyright (c) Marlik Group															|
	|	* http://www.MarlikCMS.com																	|
	|	* http://nukeseo.com																		|
	|																						
   	|   ======================================== 													|
	|					You should not sell this product to others	 								|
	+-----------------------------------------------------------------------------------------------+
*/

function navigation_menu(){

global $db,$user,$ya_config,$usenukeNAV, $admin,$prefix, $admin_file;


//===========================================
//Configuration
//===========================================
// Hide = 0 Zero  , 1 =  Show 
define("Show_Search",1);
define("Show_Your_Account",1); // Turn OFF = 0 Zero 
define("Show_Modules_Admin",1); // Turn OFF = 0 Zero 
define("Show_Modules",1); // Turn OFF = 0 Zero 
define("Show_Forums",0); // Turn OFF = 0 Zero 
define("Show_Editorial",0); // Turn OFF = 0 Zero 




if (!isset($admin_file)) $admin_file = 'admin'; // may not be defined since this isn't always in admin file
 echo '<link rel="StyleSheet" href="'.MODS_PATH .'navigation/includes/navStyle.css" type="text/css" />'."\n";
 //echo '<script type="text/javascript" language="JavaScript" src="'.MODS_PATH .'navigation/includes/navScript.js"></script>'."\n";


if ( !function_exists('seoGetLang') )
{
  function seoGetLang($module) {
    global $currentlang, $language;
      if (file_exists(MODS_PATH .'navigation/language/lang-'.$currentlang.'.php')) {
        include_once(MODS_PATH .'navigation/language/lang-'.$currentlang.'.php');
      } elseif (file_exists(MODS_PATH .'navigation/language/lang-'.$language.'.php')) {
        include_once(MODS_PATH .'navigation/language/lang-'.$language.'.php');
      } elseif (file_exists(MODS_PATH .'navigation/language/lang-english.php')) {
        include_once(MODS_PATH .'navigation/language/lang-english.php');
      }
  }
}


seoGetLang('nukeNAV');

if (!defined('_MAINMODULE')) {
	$row = $db->sql_fetchrow($db->sql_query('SELECT * FROM ' . $prefix . '_main LIMIT 100'));
	define('_MAINMODULE', $row['main_module']);
}
$radminsuper = 0;
$radminname = '';


$where = 'WHERE title!=\'' . _MAINMODULE . '\'';
if (!is_admin($admin)) $where .= 'AND active=\'1\' AND inmenu=\'1\'';
$result = $db->sql_query('SELECT * FROM ' . $prefix . '_modules ' . $where . ' ORDER BY active DESC, inmenu DESC, custom_title ASC');
//$result = $db->sql_query('SELECT * FROM  '.$prefix.'_modules  ORDER BY active DESC, inmenu DESC, custom_title ASC');
$la = $lim = 1;
$activeModules = $hiddenModules = $inactiveModules = '';
$menuModules = array('Credits', 'Feedback', 'Forums', 'Legal', 'Member_List', 'News', 'nukeNAV', 'Private_Messages', 'Recommend_Us', 'rwsMetAuthors', 'Search', 'Sitemap', 'Statistics', 'Stories_Archive', 'Submit_News', 'Topics', 'Your_Account');
while ($row = $db->sql_fetchrow($result)) {
	$m_title = stripslashes($row['title']);
	$custom_title = $row['custom_title'];
	$view = intval($row['view']);
	$groups = $row['groups'];
	$active = intval($row['active']);
	$inmenu = intval($row['inmenu']);
	$m_title2 = str_replace('_', ' ', $m_title);
	if ($custom_title > '') $m_title2 = langit($custom_title);
	if ($inmenu <> $lim and $active == 1) $hiddenModules = '<li><a>'._INVISIBLEMODULES."</a>\n".'<ul>'."\n"; // Start hidden menu
	if ($active <> $la) {
		if ($lim == 0) $hiddenModules .= '</ul>'."\n".'</li>'."\n";		// Close hidden menu
		$inactiveModules = '<li><a>'._NOACTIVEMODULES."</a>\n".'<ul>'."\n";		// Start inactive menu
	}
	if (($view == 0) or ($view == 1 and is_user($user)) or ($view == 2 and is_admin($admin)) or ($view == 3 and paid()) or ($view > 3 AND in_groups($groups)) ) {
		$menuItem = '<li><a href="modules.php?name='.$m_title.'">'.$m_title2."</a></li>\n";
		if (in_array($m_title, $menuModules)) {}  // Module already on menu elsewhere
		elseif ($inmenu == 0 and $active == 1) $hiddenModules .= $menuItem;
		elseif ($active == 0) $inactiveModules .= $menuItem;
		else $activeModules .= $menuItem;
  }
	$la = $active; $lim = $inmenu;
}
if ($la == 0 or $lim == 0) $inactiveModules .= '</ul></li>';  // Close hidden or inactive menu
$nukeNAV = ''."\n";

$nukeNAV .= '<li><a href="'.ADMIN_PHP.'"><span class="l"></span><span class="r"></span><span class="t"><img src="images/icon/house.png"> '._NAV_ACP.'</span></a></li>'."\n";


if (is_superadmin($admin)) {
	$nukeNAV .= '
<li><a title=""> <span class="l"></span><span class="r"></span><span class="t">' . _NAV_ADMIN . '</span></a>
  <ul>
  <li><a title="">' . _NAV_APPEARANCE . '</a>
    <ul>
    <li><a href="'.$admin_file.'.php?op=BlocksAdmin" title="">' . _NAV_BLOCKS . '</a></li>
    <li><a href="'.$admin_file.'.php?op=modules" title="">' . _NAV_MODS . '</a></li>
    <li><a href="'.ADMIN_OP.'mod_users" title="">' . _NAV_LGL . '</a></li>
    <li><a href="'.$admin_file.'.php?op=Configure" title="">' . _NAV_SETTINGS . '</a></li>
    </ul>
  </li>
  <li><a title="">' . _USERS . '</a>
    <ul>
    <li><a href="'.$admin_file.'.php?op=mod_authors" title="">' . _NAV_ADMINS . '</a></li>
    <li><a href="'.ADMIN_OP.'mod_users" title="">' . _USERS . '</a></li>
    <li><a href="'.$admin_file.'.php?op=Points&act=gman" title="">' . _NAV_GROUPS . '</a></li>
    <li><a href="'.$admin_file.'.php?op=Points" title="">' . _NAV_POINTS . '</a></li>
    </ul>
  </li>
  <li><a href="'.$admin_file.'.php?op=ABMain" title="">' . _NAV_SECURITY . '</a></li>
  <li><a title="">' . _NAV_UTILS . '</a>
    <ul>
    <li><a href="'.$admin_file.'.php?op=database" title="">' . _NAV_BACKUP . '</a></li>
    <li><a href="'.$admin_file.'.php?op=optimize" title="">' . _NAV_OPTIMIZE . '</a></li>
    </ul>
  </li>
  <!--li><a title="">' . _WAITINGCONT . '</a></li-->
  <li><a href="'.$admin_file.'.php?op=adminStory" title="">' . _NAV_NEWSTORY . '</a></li>
  <li><a href="'.$admin_file.'.php?op=create" title="">' . _NAV_CHGPOLL . '</a></li>
  <li><a href="'.$admin_file.'.php?op=moderation_news" title="">' . _NAV_COMMENTS . '</a></li>
  <li><a href="'.$admin_file.'.php?op=logout" title="">' . _LOGOUT . '</a></li>
  </ul>
</li>
';
}


if (Show_Modules_Admin == 1 ) {
//if ($radminsuper == 1) $nukeNAV .= '
if (is_admin($admin))
	$nukeNAV .= '<li><a title=""> <span class="l"></span><span class="r"></span><span class="t">' . _NAV_ADMINMODS . '</span></a><ul>'.$hiddenModules.$inactiveModules.'</ul></li>';
}

if (Show_Editorial == 1 ) {
if (is_active('News')) {

	//            <span class="l"></span><span class="r"></span><span class="t">hhh</span>
	$nukeNAV .= '

<li><a href="modules.php?name=News" title=""><span class="l"></span><span class="r"></span><span class="t">' . _NAV_NEWS . '</span></a>';
	if (is_active('rwsMetAuthors') or is_active('Stories_Archive') or is_active('Topics') or is_active('Submit_News')) {
		$nukeNAV .= '
  <ul>';

		if (is_active('Stories_Archive')) $nukeNAV .= '
  <li><a href="modules.php?name=Stories_Archive" title="">' . _NAV_STORARCH . '</a></li>';
		if (is_active('Topics')) $nukeNAV .= '
  <li><a href="modules.php?name=Topics" title="">' . _NAV_TOPICS . '</a></li>';
		if (is_active('Submit_News')) $nukeNAV .= '
  <li><a href="modules.php?name=Submit_News" title="">' . _NAV_SUBMITNEWS . '</a></li>';
		$nukeNAV .= '
  </ul>';
	}
	$nukeNAV .= '
</li>';
}
}

if (Show_Your_Account == 1 ) {
	if (is_active('Your_Account')) {
	$nukeNAV .= '<li><a href="modules.php?name=Your_Account" title=""> <span class="l"></span><span class="r"></span><span class="t">' . _NAV_YOURACCOUNT . '</span></a>';
	//if (!isset($ya_config)) $ya_config = ya_get_configs();
	if (is_user($user)) {
		$nukeNAV .= '<ul>';
		if (is_active('Private_Messages')) $nukeNAV .= '<li><a href="modules.php?name=Private_Messages" title="">' . _NAV_PM . '</a></li>';
		$nukeNAV .= '<li><a href="modules.php?name=Your_Account&amp;op=edituser" title="">' . _NAV_PREFS . '</a></li>';
		if ($ya_config['allowusertheme']=='1') '<li><a href="modules.php?name=Your_Account&amp;op=chgtheme" title="">' . _NAV_CHGTHEME . '</a></li>';
		$nukeNAV .= '<li><a href="modules.php?name=Your_Account&amp;op=logout" title="">' . _LOGOUT . '</a></li></ul>';
	} elseif (is_active('Your_Account')) {
		$nukeNAV .= '
  <ul>';
		if (is_active('nukeNAV')) $nukeNAV .= '
  <li><a href="modules.php?app=mod&name=navigation&amp;op=login" class="colorbox" title="">' . _LOGIN . '</a></li>';
		else $nukeNAV .= '
  <li><a href="modules.php?name=Your_Account" title="">' . _LOGIN . '</a></li>';
		if ($ya_config['allowuserreg']=='1')$nukeNAV .= '
  <li><a href="modules.php?name=Your_Account&amp;op=new_user" title="">' . _BREG . '</a></li>';
		$nukeNAV .= '
  </ul>';
	}
	$nukeNAV .= '
</li>';
}
}
if (Show_Modules == 1 ) {
$nukeNAV .= '
<li><a> <span class="l"></span><span class="r"></span><span class="t">'._NUKEMENUMODULES.'</span></a><ul>'.$activeModules.'</ul></li>
';
}


if (Show_Search == 1 ) {
if (is_active('nukeNAV') and is_active('Search')) $nukeNAV .= '
<li><a href="modules.php?app=mod&name=navigation&amp;op=search" class="colorbox" title=""><span class="l"></span><span class="r"></span><span class="t">' . _SEARCH . '</span></a></li>';
}

$nukeNAV .= '<li><a href="./"><span class="l"></span><span class="r"></span><span class="t">'._HOME.'</span></a></li>'."\n";

//$nukeNAV .= '</ul>';
/*
 * $usenukeNAV =
 *  0 = Do not use
 *  1 = Display for super admin only (e.g. nukeSEO DH)
 *  2 = Display for all visitors
 */

if ($usenukeNAV == 0 or ($usenukeNAV == 1 and !is_admin($admin))) $nukeNAV = '';
	return $nukeNAV;
}

?>