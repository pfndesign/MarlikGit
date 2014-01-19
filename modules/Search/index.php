<?php

/**
 *
 * @package SEARCH MODULE - MODIFIED													
 * @version $Id: Aneeshtan $4:43 PM 8/10/2010
 * @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */


if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
require_once("mainfile.php");
$instory = ''; 
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$query = (!empty($_POST[query]) ? $_POST[query] : $_GET[query]);
$query = sql_quote($query);

global $admin, $prefix, $db, $module_name, $articlecomm, $multilingual, $admin_file;
if ($multilingual == 1) {
    $queryalang = "AND (s.alanguage='$currentlang' OR s.alanguage='')"; /* stories */
    $queryrlang = "AND rlanguage='$currentlang' "; /* reviews */
} else {
    $queryalang = "";
    $queryrlang = "";
    $queryslang = "";
}


	//if (!isset($query)) { $query = ""; }
	if (!isset($type)) { $type = ""; }
	if (!isset($category)) { $category = 0; }
	if (!isset($days)) { $days = 0; }
	if (!isset($author)) { $author = ""; }
	if (!isset($sid)) { $sid = 0; } else { $sid = intval($sid); }
	if (!isset($op)) { $op = ""; }
	
function formatdateago($olddate){
  // Takes a timestamp and returns a string telling how long ago that timestamp occured
  $date = time();
  $diff = $date - $olddate;
  if ($diff > 365 * 24 * 60 * 60){
    $yrs = floor($diff / (365 * 24 * 60 * 60));}
  if ($diff > 24 * 60 * 60){
    $days = floor($diff / (24 * 60 * 60));}
  if ($diff > 7 * 24 * 60 * 60){
    $weeks = floor($diff / (7 * 24 * 60 * 60));}
  if ($diff > 30 * 24 * 60 * 60){
    $months = floor($diff / ((365 * 24 * 60 * 60) / 12));}
  if ($diff > 60 * 60){
    $hours = floor($diff / (60 * 60));}
  if ($diff > 60){
    $minutes = floor($diff / 60);}
  if ($diff < 60){
    $secs = $diff;}
  if ($yrs){
    $string = "$yrs "._MSYEAR.($yrs == 1 ? '' : ''._MSPLURAL);
    if ($months % 12 > 0){
      $string .= ", ".($months - (12 * $yrs))." "._MSMONTH.(($months - (12 * $yrs)) == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
    else {
      $string .= ' '._MSAGO;}}
  else if ($months){
    $string = "$months "._MSMONTH.($months == 1 ? '' : ''._MSPLURAL);
    if ($weeks % 4 > 0){
      $string .= ", ".($weeks - (4 * $months))." "._MSWEEK.(($weeks - (4 * $months)) == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
    else {
      $string .= ' '._MSAGO;}}
  else if ($weeks){
    $string = "$weeks "._MSWEEK.($weeks == 1 ? '' : ''._MSPLURAL);
    if ($days % 7 > 0){
      $string .= ", ".($days - (7 * $weeks))." "._MSDAY.(($days - (7 * $weeks)) == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
    else {
      $string .= ' '._MSAGO;}}
  else if ($days){
    $string = "$days "._MSDAY.($days == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
  else if ($hours){
    $string = "$hours "._MSHOUR.($hours == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
  else if ($minutes){
    $string = "$minutes "._MSMINUTE.($minutes == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
  else if ($secs){
    $string = "$secs "._MSSECOND.($seconds == 1 ? '' : ''._MSPLURAL)." "._MSAGO;}
  return $string;}

function chopwords($str, $c){
  // Chop a string at a certain length, without cutting off any words.
  $s = explode(' ', $str);
  $x = 0;
  $string = '';
  foreach ($s as $word){
    $x += strlen($word)+1;
    if ($x < $c){
      $string .= $word.' ';}
    else {
      return $string;}}
  return $string;}

function asortbyindex($multiArray, $secondIndex) {
  // Sort a 2-Dimensional array.
  $GLOBALS['secondIndex'] = $secondIndex;
  usort($multiArray, create_function('$a, $b', '
    $secondIndex = $GLOBALS["secondIndex"];
    if ($a[$secondIndex] == $b[$secondIndex]) {
      return 0;}
    return ($a[$secondIndex] < $b[$secondIndex]) ? -1 : 1;'));
  return $multiArray;}

function mt_get_date_format(){
  // Get the date format and timezone from the user's settings.
  global $user, $db, $prefix;
  if(is_user($user)) {
    $cookie = explode(":", addslashes(base64_decode($user)));
    cookiedecode($user);
    $userr = $cookie[0];}
  else {
    $userr=1;}
  $i = $db->sql_fetchrow($db->sql_query('SELECT user_dateformat, user_timezone FROM '.$prefix.'_users WHERE user_id="'.$userr.'" LIMIT 1;'));
  if ($i['user_dateformat']){
    return array($i['user_dateformat'], $i['user_timezone']);}}

function mt_format_date($time){
  // Format a date to fit the user's settings.
  global $user, $db, $prefix;
  $i = mt_get_date_format();
  return gmdate($i[0], $time + ($i[1]*3600));}

// Module Functions

function get_all_results($what){
  // Find all the modules and collect their results into the database.
  global $module_name, $q;
  if ($what == 'all'){
    if ($handle = opendir('modules/'.$module_name.'/modules/')) {
      while (false !== ($file = readdir($handle))) {
        if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
          include('modules/'.$module_name.'/modules/'.$file);
           $cname = substr($file,0,-4);
          $cname2 = 'mS'.$cname;
          ${$cname} = new $cname2();
          if (${$cname}->useme()){
            $GLOBALS['mSar'][$cname] = ${$cname};
            ${$cname}->addquery('main', $q);
            ${$cname}->getresults();}}}
    closedir($handle);}}
  else {
    $file = addslashes(basename($what)).'.php';
    include('modules/'.$module_name.'/modules/'.$file);
    $cname = substr($file,0,-4);
    $cname2 = 'mS'.$cname;
    ${$cname} = new $cname2();
    $GLOBALS['mSar'][$cname] = ${$cname};
    ${$cname}->addquery('main', $q);
    ${$cname}->getresults();}}

function buildquery($p, $query){
  // Turn the query string entered into the search box into an
  // array, which can be used by the mSearch modules
  if ($p !== false){
    $q = explode('"', ' '.$query);
    $sc = 0;
    $ec = 0;
    if ($query[0] != '"'){
      $q = array_merge(explode(' ', $q[0]), array_slice($q, 1));}
    else{
      array_shift($q);}
    if ($query[strlen($query)-1] != '"'){
      $q = array_merge(explode(' ', $q[count($q)-1]), array_slice($q, 0,-1));}
    else{
      array_pop($q);}
    foreach ($q as $val){
      $val = trim($val);}}
  else {
    $query = $_REQUEST['query'];
    $q = explode(' ', $query);}
  for ($i=0,$x=count($q);$i<$x;$i++){
    if (strstr($q[$i], ' ') == false){
      $q[$i] = trim(str_replace($commonwords, '', ' '.$q[$i].' '));}}
  return $q;}

function showpage($start, $len, $fullen, $func, $pfunc){
  // Display a list of items on a page, using $func to format these
  // items, and $pfunc to show the links to new pages
  global $db;
  function pagenum($ar){
    $c = '';
    if (is_array($ar)){
      foreach($ar as $val){
        $c .= $val.' ';}}
    return $c;}
  $lastpage = 1;
  if ($len > 0){
    for ($x = $start + $len, $i = $start;$i < $x;$i++){
      $content .= $func($i);}
    $page = ($start / $len);
    $pagest = ceil(($fullen / $len));
    if ($page < 2){
      $page = 2;
    } else if ($page > $pagest - 3){
      $page = $pagest -2;
      if ($pagest == 3){
        $page = 2;}}
    $pages = array();
    if ( $fullen > $len){
      for ($x = $fullen / $len, $i = 0;$i < $x;$i++){
        $pages[] = (round($start/$len) != $i ? $pfunc($i*$len, $len) : '<b>'.($i+1).'</b>');}
        $x = 5;
        if ($pagest < 5){
          $x = $pagest;}
        for ($i = 0;$i < $x;$i++){
          $pages2[] = $pages[(($page - 2)+$i)];
          $lastpage = $i;}}}
  $startlen = ($len ? $start/$len : 0);
  return array($content, (round($startlen) > 2 && $pagest > 5 ? $pfunc(0, $len).' '._MSELIPSES.' ' : '').pagenum($pages2).(round($startlen) < $pagest-2 && $pagest > 5 ? ' ... '.$pfunc(($pagest-1)*$len, $len) : ''));}

// Module Code
// Create a list of commonly used words, to be ignored in a search
// query.
$cw = explode(' ', ''._MSCOMMONWORDS);
$commonwords = array();
foreach($cw as $word){
  $commonwords[] = ' '.$word.' ';}

// Get the current url
$url = str_replace('&', '&amp;', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = parse_url($url);

// Create a temporary table to hold the search results
$randkey = rand(0, 10000);
$tblname = $prefix.'_mSearch_'.$randkey;
$db->sql_query('CREATE TEMPORARY TABLE '.$tblname.' (
                `id` VARCHAR(20) NOT NULL ,
                `relevance` INT NOT NULL ,
                `date` INT NOT NULL ,
                `title` TEXT NOT NULL ,
                `rid` INT NOT NULL ,
                `desc` TEXT NOT NULL ,
                `author` TEXT NOT NULL ,
                `searchmodule` TEXT NOT NULL ,
                INDEX ( `relevance` ),
                INDEX ( `date` )
                ) ENGINE=MyISAM DEFAULT CHARSET="utf8";');

if (!preg_match("/modules.php/", $_SERVER['PHP_SELF'])) {
    die ("You can't access this file directly...");
}

class searchmodule {
  var $query;
  var $name;
  var $sql_col_time;
  var $sql_col_title;
  var $sql_col_id;
  var $sql_col_desc;
  var $sql_col_author;
  var $sql_table_with_prefix;
  var $sql_where_cols;

  function useme(){
    // Returns true if this module is to be used by mSearch
    global $db, $prefix;
    if ($this->databaseexists()){
      $res = $db->sql_fetchrow($db->sql_query('SELECT `use` FROM '.$prefix.'_msmodules WHERE `name`="'.$this->name.'"'));
      return ($res['use'] == 'no' ? 0 : 1);}
    return 0;}

  function databaseexists(){
    // Returns true if the database for this module is installed
    global $db;
    $res = $db->sql_query('SELECT "1" FROM '.$this->sql_table_with_prefix);
    return ($res ? 1 : 0);}

  function formatrss($result){
    // Format a result for an RSS feed
    global $url;
    return '
    <item>
      <title>'.$this->name.': '.$result['title'].'</title>
      <link>
        '.$url['scheme'].'://'.$url['host'].$url['path'].$this->buildlink($result['rid'],$result['title']).'
      </link>
      <description>
         '.chopwords(strip_tags($result['desc']),192).'
      </description>
    </item>';}

  function formatresult($result){
    // Format a result to be displayed in the module
    return '<b>'.$this->name.':</b> 
        <a href="modules.php'.$this->buildlink($result['rid'],$result['title']).'">
        '.$result['title'].'</a><br /><small>
        '.($result['author'] ? ''._MSBY.' '.$result['author'] : '').($result['date'] ? ', '.formatdateago($result['date']) : '').'
        </small><br />'.chopwords(strip_tags($result['desc']),192);}

  function gformatresult($result){
    // Format a result to be displayed in the group-display page
    return '<a href="modules.php'.$this->buildlink($result['rid'],$result['title']).'">
        '.$result['title'].'</a><br /><small>
        '.($result['author'] ? ''._MSBY.' '.$result['author'] : '').($result['date'] ? ', '.formatdateago($result['date']) : '').'
        </small><br />'.chopwords(strip_tags($result['desc']),192);}

  function doquery(){
    // Insert any results matching the users query into the main database
    global $prefix, $tblname, $db;
    $q = $this->query[0][1];
    foreach ($q as $query){
      $wheretext = '('.$this->sql_where_cols[0].' like \'%'.$query.'%\')';
      for ($i = 1,$x=count($this->sql_where_cols);$i<$x;$i++){
        $wheretext .= ' OR (`'.$this->sql_where_cols[$i].'` like \'%'.$query.'%\')';}
      $db->sql_query('INSERT INTO '.$tblname.' 
                     (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`)
                     SELECT CONCAT("'.$this->name.'", `'.$this->sql_col_id.'`) AS `id`, \'1\', 
                     '.($this->sql_col_time_unix ? '' : 
                     'UNIX_TIMESTAMP(`').$this->sql_col_time.($this->sql_col_time_unix ? '' : '`)').', 
                     `'.$this->sql_col_title.'`, `'.$this->sql_col_id.'`, `'.$this->sql_col_desc.'`,
                     `'.$this->sql_col_author.'`, "'.$this->name.'" FROM '.$this->sql_table_with_prefix.' 
                     WHERE ('.$wheretext.')');}}

  function addquery($type, $query){
    // Not sure why this is here :/
    $this->query[] = array($type, $query);}

  function getresults(){
    // Not sure why this is here either, but you probably shouldn't mess with these.
    global $db;
    return $this->doquery();}

  function options($var){
    // The html code to be used when a user clicks "More Options >"
    return $var.'[\''.$this->name.'\']=" '._MSWITHINLAST.' <select name=\"when\">\\
      <option value=\"0\">'._MSANYDATE.'</option>\\
      <option value=\"'.(time() - (3 * 24 * 60 * 60)).'\">'._MSTHREEDAYS.'</option>\\
      <option value=\"'.(time() - (7 * 24 * 60 * 60)).'\">'._MSONEWEEK.'</option>\\
      <option value=\"'.(time() - (7 * 4 * 24 * 60 * 60)).'\">'._MSONEMONTH.'</option>\\
      <option value=\"'.(time() - (6 * 7 * 4 * 24 * 60 * 60)).'\">'._MSSIXMONTHS.'</option>\\
      <option value=\"'.(time() - (12 * 7 * 4 * 24 * 60 * 60)).'\">'._MSONEYEAR.'</option>\\
      </select>"';}

  function buildlink($id,$title){
    // Used by the individual modules to define how a link to an item should be built
    }

  function buildquery(){
    // Not sure why this is here either, but it is
    }}

define('INDEX_FILE', true);
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = "- "._SEARCH."";

if ($_REQUEST['op'] == 'rss' || $_REQUEST['op'] == 'search' || $_REQUEST['op'] == 'gsearch'){
  // Take care of initializations for the rss and search pages,
  // without repitition or running them at the search page.
  $GLOBALS['mSar'] = array();
  if (isset($_GET['query'])){
  $_REQUEST['query'] = str_replace('\\quote', '"', $_REQUEST['query']);}
  $query = stripslashes($_REQUEST['query']);
  $p = strpos($query, '"');
  $q = buildquery($p, $query);
  get_all_results($_REQUEST['what']);}

if ($_REQUEST['op'] != 'rss'){
  $JS4noRss = '<script type="text/javascript">
    function changeBoxSize(showhide) {
      document.getElementById(\'msopt_hide\').style.display=\'none\';
      document.getElementById(\'msopt_show\').style.display=\'none\';
      document.getElementById(\'msopt_\'+showhide).style.display=\'block\';
    }
    var msstuff = new Array(20)
    msstuff[\'all\']=" '._MSWITHINLAST.' <select name=\"when\">\\
      <option value=\"0\">'._MSANYDATE.'</option>\\
      <option value=\"'.(time() - (3 * 24 * 60 * 60)).'\">'._MSTHREEDAYS.'</option>\\
      <option value=\"'.(time() - (7 * 24 * 60 * 60)).'\">'._MSONEWEEK.'</option>\\
      <option value=\"'.(time() - (7 * 4 * 24 * 60 * 60)).'\">'._MSONEMONTH.'</option>\\
      <option value=\"'.(time() - (6 * 7 * 4 * 24 * 60 * 60)).'\">'._MSSIXMONTHS.'</option>\\
      <option value=\"'.(time() - (12 * 7 * 4 * 24 * 60 * 60)).'\">'._MSONEYEAR.'</option>\\
      </select>"'."\n\n";
  if ($handle = opendir('modules/'.$module_name.'/modules/')) {
    while (false !== ($file = readdir($handle))) {
      if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
        include_once('modules/'.$module_name.'/modules/'.$file);
         $cname = substr($file,0,-4);
        $cname2 = 'mS'.$cname;
        ${$cname} = new $cname2();
        if (${$cname}->useme()){
          $GLOBALS['mSar'][$cname] = ${$cname};
           $JS4noRss .= ${$cname}->options('msstuff')."\n\n";}}}}
  $JS4noRss .= 'function msput(form)
    {
      option=form.what.options[form.what.selectedIndex].value
      txt=msstuff[option]
      document.getElementById(\'msopt\').innerHTML=txt
    }
    </script>';
  
addJSToBody($JS4noRss,'inline');

}

switch($op) {
  case 'rss':
    global $db, $tblname, $commonwords,$sitename,$nukeurl,$backend_title,$url;
    header('Content-Type:text/xml');
    $rq = $_REQUEST['query'];
    $rw = $_REQUEST['what'];

// Start RSS output
header("Content-Type: text/xml; charset=UTF-8");
echo '<?xml version="1.0" encoding="utf-8"?>',"\n";
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',"\n";
echo '<channel>',"\n";
echo"
  <title>".$sitename."</title>
  <link>".$nukeurl."</link>
  <description>".$backend_title."</description>
  <language>fa</language>
  <copyright>".$nukeurl."</copyright>     
  <managingEditor>".$sitename."</managingEditor>  
   <generator>".$sitename."</generator>
  <ttl>1</ttl>  
";
    
    echo "
      <title>"._MSSRF." $query</title>\n
      <link>\n"
      .'http://'.$url['host'].$url['path'].'?name=Search&amp;op=search&amp;query='.$rq.'&amp;what='.$rw."\n
      </link>
      <description>
      "._MSNEWRES."\"".$query."\"
      </description>\n";
    $GLOBALS['mSresult'] = $db->sql_query('SELECT `id`, count(`id`) as `rel`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule` 
                                           FROM '.$tblname.' GROUP BY id ORDER BY `rel` DESC, date DESC LIMIT 20');

    function showresult($x){
      // Temporary function used to define how a search result should
      // be formatted using RSS, passed to showpage().
      global $db;
      if ($i = $db->sql_fetchrow($GLOBALS['mSresult'])){
        return $GLOBALS['mSar'][$i['searchmodule']]->formatrss($i)."\n";}}
      $c = showpage(0, 20, 20, 'showresult', 0);
    echo $c[0]
         ."\n</channel>"
         ."\n</rss>";
    die();
    break;

  case 'search':
    include('header.php');
    global $db, $tblname, $commonwords, $module_name;
    OpenTable();
    echo '<LINK REL="alternate" TITLE="'._MSSEARCHRSS.'" HREF="modules.php?name=Search&op=rss&query='.urlencode(stripslashes(str_replace('"', '\\quote', $_REQUEST['query']))).'&what='.$_REQUEST['what'].'" TYPE="application/rss+xml" />
      <form method="get" action="modules.php?name=Search"><table border="0"><tr valign="center">
      <td><b>'._MSSEARCH.'</b></td><td><select name="what" onchange="msput(this.form)">
      <option value="all">'._MSALL.'</option>';
    if ($handle = opendir('modules/'.$module_name.'/modules/')) {
      while (false !== ($file = readdir($handle))) {
        if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
          include_once('modules/'.$module_name.'/modules/'.$file);
           $cname = substr($file,0,-4);
          $cname2 = 'mS'.$cname;
          ${$cname} = new $cname2();
          if (${$cname}->useme()){
            echo '<option value="'.str_replace('_', ' ', $cname).'">'.$cname.'</option>'."\n";}}}
      closedir($handle);}
    echo '</select></td><td> '._MSFOR.' </td>
      <td><input type="text" name="query"  value="'.htmlspecialchars(stripslashes($_REQUEST['query'])).'"/></td>
      <input type="hidden" name="name" value="'.$module_name.'" />
      <input type="hidden" name="op" value="search" />
      <td><input type="submit" value="'._MSGO.'" /></td></tr><tr><td colspan="3">
      <div id="msopt_hide" style="display: block;">
      &nbsp;<span onclick="changeBoxSize (\'show\'); return false;">
      <a href="#">'._MSMOREOPTIONS.'</a></span></div>
      <div id="msopt_show" style="display: none;">
      <table border="0">
      <tr><td id="msopt">
       '._MSWITHINLAST.' <select name="when">
        <option value="0">'._MSANYDATE.'</option>
        <option value="'.(time() - (3 * 24 * 60 * 60)).'">'._MSTHREEDAYS.'</option>
        <option value="'.(time() - (7 * 24 * 60 * 60)).'">'._MSONEWEEK.'</option>
        <option value="'.(time() - (7 * 4 * 24 * 60 * 60)).'">'._MSONEMONTH.'</option>
        <option value="'.(time() - (6 * 7 * 4 * 24 * 60 * 60)).'">'._MSSIXMONTHS.'</option>
        <option value="'.(time() - (12 * 7 * 4 * 24 * 60 * 60)).'">'._MSONEYEAR.'</option>
        </select>
      </td></tr></table>
      <span onclick="changeBoxSize (\'hide\'); return false;">
      <a href="#">'._MSMOREOPTIONSHIDE.'</a></span>
      </div>
      </td></tr></table></form>';
    CloseTable();
    echo '<br />';
    OpenTable();
    echo '<b>'._MSRESULTS.':</b><br /><div style="padding-left:15px">';
    $GLOBALS['mSresult'] = $db->sql_query('SELECT `id`, count(`id`) as `rel`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule` 
                   FROM '.$tblname.' '.($_REQUEST['when'] ? 'WHERE `date`>="'.$_REQUEST['when'].'" ' : '').' GROUP BY id ORDER BY `rel` DESC, date DESC LIMIT 99');

    function showresult($x){
      // Temporary function used to define how a search result should
      // be formatted, passed to showpage().
      global $db, $GLOBALS;
      if ($i = $db->sql_fetchrow($GLOBALS['mSresult'])){
        return '<p>'.$GLOBALS['mSar'][$i['searchmodule']]->formatresult($i).'</p>';}}
    function showpagee($il, $l){
      // Temporary function for formatting the page numbers in the 
      // bottom of the screen, passed to showpage().
      return '<a href="modules.php?name=Search&op=search&query='.urlencode(stripslashes(str_replace('"', '\\quote', $_REQUEST['query']))).'&what='.$_REQUEST['what'].'&start='.$il.'">'.(($il/$l)+1).'</a>';}

    $fullen = $db->sql_numrows($GLOBALS['mSresult']);
    $conf = $db->sql_fetchrow($db->sql_query('SELECT `value` FROM '.$prefix.'_msconfig 
                                              WHERE id="results-per-page" LIMIT 1'));
    $conf2 = $db->sql_fetchrow($db->sql_query('SELECT `value` FROM '.$prefix.'_msconfig 
                                               WHERE id="enable-rss" LIMIT 1'));
    if ($_REQUEST['start'] == 0){
      $_REQUEST['start'] = 0;} 
    else {
      for($i=0;$i<$_REQUEST['start'];$i++){
        $j = $db->sql_fetchrow($GLOBALS['mSresult']);}}
    if ($fullen < $conf['value']){
      $len = $fullen;} 
    else {
      $len = $conf['value'];}
    $c = showpage($_REQUEST['start'], $len, $fullen, 'showresult', 'showpagee');
    echo $c[0].'<br /><table width="100%" border="0"><tr><td>
        '.($conf2['value'] == 'on' ? '<a href="modules.php?name=Search&op=rss&query='.urlencode(stripslashes(str_replace('"', '\\quote', $_REQUEST['query']))).'&what='.$_REQUEST['what'].'">
        <img src="images/icon/rss_go.png">'._RSS.'</a>' : '').'
        </td><td align="right" width="80%" style="text-align:left;">'.$c[1].'</td></tr></table></div>';
    CloseTable();
    break;

  case 'gsearch':
    include('header.php');
    global $db, $tblname, $commonwords, $module_name;
    $time = time();
    OpenTable();

    echo '<LINK REL="alternate" TITLE="'._MSSEARCHRSS.'" HREF="modules.php?name=Search&op=rss&query='.urlencode(stripslashes(str_replace('"', '\\quote', $_REQUEST['query']))).'&what='.$_REQUEST['what'].'" TYPE="application/rss+xml" />
      <form method="get" action="modules.php?name=Search"><table border="0"><tr valign="center">
      <td><b>'._MSSEARCH.'</b></td><td><select id="what" name="what" onchange="msput(this.form)">
      <option value="all">'._MSALL.'</option>';
    if ($handle = opendir('modules/'.$module_name.'/modules/')) {
      while (false !== ($file = readdir($handle))) {
        if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
          include_once('modules/'.$module_name.'/modules/'.$file);
           $cname = substr($file,0,-4);
          $cname2 = 'mS'.$cname;
          ${$cname} = new $cname2();
          if (${$cname}->useme()){
            echo '<option value="'.str_replace('_', ' ', $cname).'">'.$cname.'</option>'."\n";}}}
      closedir($handle);}
    echo '</select></td><td> '._MSFOR.' </td>
      <td><input type="text" name="query" value="'.htmlspecialchars(stripslashes($_REQUEST['query'])).'"  /></td>
      <input type="hidden" name="name" value="'.$module_name.'" />
      <input type="hidden" name="op" value="gsearch" />
      <td><input type="submit" value="'._MSGO.'" /></td></tr><tr><td colspan="3">
      <div id="msopt_hide" style="display: block;">
      &nbsp;<span onclick="changeBoxSize (\'show\'); return false;">
      <a href="#">'._MSMOREOPTIONS.'</a></span></div>
      <div id="msopt_show" style="display: none;">
      <table border="0">
      <tr><td id="msopt">
       '._MSWITHINLAST.' <select name="when">
        <option value="0">'._MSANYDATE.'</option>
        <option value="'.(time() - (3 * 24 * 60 * 60)).'">'._MSTHREEDAYS.'</option>
        <option value="'.(time() - (7 * 24 * 60 * 60)).'">'._MSONEWEEK.'</option>
        <option value="'.(time() - (7 * 4 * 24 * 60 * 60)).'">'._MSONEMONTH.'</option>
        <option value="'.(time() - (6 * 7 * 4 * 24 * 60 * 60)).'">'._MSSIXMONTHS.'</option>
        <option value="'.(time() - (12 * 7 * 4 * 24 * 60 * 60)).'">'._MSONEYEAR.'</option>
        </select>
      </td></tr></table>
      <span onclick="changeBoxSize (\'hide\'); return false;">
      <a href="#">'._MSMOREOPTIONSHIDE.'</a></span>
      </div>
      </td></tr></table></form>';
    CloseTable();
    echo '<br />';
    OpenTable();
    echo '<b>'._MSRESULTS.':</b><br /><div style="padding-left:15px">';
    $GLOBALS['mSresult'] = $db->sql_query('SELECT `id`, count(`id`) as `rel`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule` 
                                           FROM '.$tblname.' '.($_REQUEST['when'] ? 'WHERE `date`>="'.$_REQUEST['when'].'" ' : '').' 
                                           GROUP BY id ORDER BY `searchmodule` ASC, `rel` DESC, date DESC');
    $gar = array();
    $lastgroup = '';
    while ($i = $db->sql_fetchrow($GLOBALS['mSresult'])){
      if ($i['searchmodule'] != $lastgroup){
        $lastgroup = $i['searchmodule'];
        $gar[$lastgroup] = array();
        $gar[$lastgroup]['m'] = $lastgroup;
        $gar[$lastgroup]['c'] .= '<h3 style="margin:0">'.$lastgroup.'</h3><hr style="margin:0;padding:0" width="100%"><div style="padding-left:20px;">';}
      $gar[$lastgroup]['n'] += 1;
      $gar[$lastgroup]['r'] = (float)((($gar[$lastgroup]['r'] * ($gar[$lastgroup]['n'] - 1)) + $i['rel']) / $gar[$lastgroup]['n']);
      $gar[$lastgroup]['rn'] = ($gar[$lastgroup]['r'] * 50) + $gar[$lastgroup]['n'];
      if ($gar[$lastgroup]['n'] < 4){
        $gar[$lastgroup]['c'] .= '<p'.($gar[$lastgroup]['n'] ? ' style="padding-top:0;margin-top:3px"' : '').'>'.$GLOBALS['mSar'][$i['searchmodule']]->gformatresult($i).'</p>';}}
    $gar = array_reverse(asortbyindex($gar, 'rn'));
    foreach ($gar as $val){
      echo $val['c'].($val['n'] > 3 ? '<div align="right" width="100%">
          <a href="modules.php?name='.$module_name.'&op=search&what='.$val['m'].'&query='.$_REQUEST['query'].'">'.
          $val['n'].' '._MSRESULTSLCASE.'</a></div></div>' : '</div>');}
    CloseTable();
    break;


  case "comments":
  break;

  default:
  	$ThemeSel = get_theme();
  	$offset=10;
  	if (!isset($min)) $min=0;
  	if (!isset($max)) $max=$min+$offset;
  	$min = intval($min);
  	$max = intval($max);
  	$query = sql_quote($query);
  	$pagetitle = ""._SEARCH."-".$query;
  	include("header.php");
  	$topic = intval($topic);
  	if ($topic>0) {
  		$row = $db->sql_fetchrow($db->sql_query("SELECT topicimage, topictext from ".$prefix."_topics where topicid='$topic'"));
  		$topicimage = check_words(check_html($row['topicimage'], "nohtml"));
  		$topictext = check_words(check_html($row['topictext'], "nohtml"));
  		$topicimage = "$tipath/$topicimage";
  	} else {
  		$topictext = ""._ALLTOPICS."";
  		$topicimage = "$tipath/AllTopics.gif";
  	}
  	if (file_exists("themes/$ThemeSel/images/topics/AllTopics.gif")) {
  		$alltop = "themes/$ThemeSel/images/topics/AllTopics.gif";
  	} else {
  		$alltop = "$tipath/AllTopics.gif";
  	}
  	OpenTable();
  	if ($type == "users") {
  		echo "<center><font class=\"title\"><b>"._SEARCHUSERS."</b></font></center><br>";
  	} elseif ($type == "comments" AND isset($sid)) {
  		$res = $db->sql_query("select title from ".$prefix."_stories Where time<=now() AND  approved='1' AND sid='$sid'");
  		list($st_title) = $db->sql_fetchrow($res);
  		$st_title = check_words(check_html($st_title, "nohtml"));
  		$instory = "AND sid='$sid'";
  		echo "<center><font class=\"title\"><b>"._SEARCHINSTORY." $st_title</b></font></center><br>";
  	} else {
  		echo "<center><font class=\"title\"><b>"._SEARCHIN." $topictext</b></font></center><br>";
  	}

  	echo "<table width=\"100%\" border=\"0\"><TR><TD>";
  	if (($type == "users")) {
  		echo "<img src=\"$alltop\" align=\"right\" border=\"0\" alt=\"\">";
  	} else {
  		echo "<img src=\"$topicimage\" align=\"right\" border=\"0\" alt=\"$topictext\">";
  	}
  	echo "<form action=\"modules.php?name=Search\" method=\"POST\">"
  	."<input size=\"35\" type=\"text\" name=\"query\" id=\"query\" value=\"$query\" >&nbsp;&nbsp;"
  	."<input type=\"submit\" value=\""._SEARCH."\"><br>";
  	if (isset($sid)) {
  		echo "<input type='hidden' name='sid' value='$sid'>";
  	}
  	echo "<!-- Topic Selection -->";
  	$toplist = $db->sql_query("SELECT topicid, topicname from ".$prefix."_topics order by topicname");
  	echo "<select name=\"topic\">";
  	echo "<option value=\"\">"._ALLTOPICS."</option>\n";
  	while($row2 = $db->sql_fetchrow($toplist)) {
  		$topicid = intval($row2['topicid']);
  		$topics = check_words(check_html($row2['topicname'], "nohtml"));
  		if ($topicid==$topic) { $sel = "selected "; } else { $sel = ""; }
  		echo "<option $sel value=\"$topicid\">$topics</option>\n";
  	}
  	echo "</select>";
  	/* Authors Selection */
  	$thing = $db->sql_query("SELECT aid from ".$prefix."_authors order by aid");
  	echo "&nbsp;<select name=\"author\">";
  	echo "<option value=\"\">"._ALLAUTHORS."</option>\n";
  	while($row4 = $db->sql_fetchrow($thing)) {
  		$authors = stripslashes($row4['aid']);
  		if ($authors==$author) { $sel = "selected "; } else { $sel = ""; }
  		echo "<option value=\"$authors\" $sel>$authors</option>\n";
  	}
  	echo "</select>";
                /* Date Selection */
                ?>
		&nbsp;<select name="days">
                        <option <?php echo $days == 0 ? "selected " : ""; ?> value="0"><?php echo _ALL ?></option>
                        <option <?php echo $days == 7 ? "selected " : ""; ?> value="7">1 <?php echo _WEEK ?></option>
                        <option <?php echo $days == 14 ? "selected " : ""; ?> value="14">2 <?php echo _WEEKS ?></option>
                        <option <?php echo $days == 30 ? "selected " : ""; ?> value="30">1 <?php echo _MONTH ?></option>
			<option <?php echo $days == 60 ? "selected " : ""; ?> value="60">2 <?php echo _MONTHS ?></option>
                        <option <?php echo $days == 90 ? "selected " : ""; ?> value="90">3 <?php echo _MONTHS ?></option>
                </select><br>
		<?php
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if (($type == "stories") OR (empty($type))) {
		    $sel1 = "checked";
		} elseif ($type == "comments") {
		    $sel2 = "checked";
		} elseif ($type == "users") {
		    $sel3 = "checked";
		}

		echo ""._SEARCHON."";
		echo "<input type=\"radio\" name=\"type\" value=\"stories\" $sel1> "._SSTORIES."";
		if ($articlecomm == 1) {
		    echo "<input type=\"radio\" name=\"type\" value=\"comments\" $sel2> "._SCOMMENTS."";
		}
		echo "<input type=\"radio\" name=\"type\" value=\"users\" $sel3> "._SUSERS."";

		echo "</form></td></tr></table>";
		$query = addslashes(check_words(check_html($query, "nohtml")));
	
	    CloseTable();
	    if ( !empty($query)) {

		OpenTable();
		if ($type=="stories" OR !$type) {

		$sql = "SELECT s.*,a.aid from ".$prefix."_stories AS s LEFT JOIN ".$prefix."_authors AS a  ON s.aid=a.aid WHERE s.time<=now() $queryalang AND s.approved='1'";
                if (!empty($query)) $sql .= "AND (s.title LIKE '%$query%' OR s.hometext LIKE '%$query%' OR s.bodytext LIKE '%$query%' OR s.notes LIKE '%$query%') ";
				if (empty($query)) $sql .= "AND s.informant=a.aid ";
                if (!empty($author)) $sql .= "AND s.aid='$author' ";
                if (!empty($topic)) $sql .= "AND FIND_IN_SET($topic, REPLACE(s.associated, '-', ','))";
                if (!empty($days) && $days!=0) $sql .= "AND TO_DAYS(NOW()) - TO_DAYS(time) <= '$days' ";
                $sql .= " ORDER BY s.time DESC LIMIT $min,$offset";
				$t = $topic;
				//die($sql);
                $result5 = $db->sql_query($sql);
                $nrows = $db->sql_numrows($result5);
                $x=0;

		//die($sql);

		echo "<center><b>"._SEARCHRESULTS."</b></center><br><br>";
                echo "<table width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
		if ($nrows>0) {
			while($row5 = $db->sql_fetchrow($result5)) {
            	$sid = intval($row5['sid']);
                $aid = check_words(check_html($row5['aid'], "nohtml"));
                $informant = check_words(check_html($row5['informant'], "nohtml"));
                $title = check_words(check_html($row5['title'], "nohtml"));
                $time = $row5['time'];
                $hometext = check_words(check_html($row5['hometext'], ""));
                $bodytext = check_words(check_html($row5['bodytext'], ""));
                $url = check_words(check_html($row5['url'], "nohtml"));
                $comments = intval($row5['comments']);
                $datetime = formatTimestamp($time);
                
                $furl = "modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."";

				 if (empty($informant)) {
				    $informant = $anonymous;
				} else {
				    $informant = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$informant\">$informant</a>";
				}
				if (!empty($query) AND $query != "*") {
				    if (preg_match("/quotemeta($query)/",$title)) {
					$a = 1;
				    }
				    $text = "$hometext$bodytext";
				    if (preg_match("/quotemeta($query)/",$text)) {
					$a = 2;
				    }
				    if (preg_match("/quotemeta($query)/",$text) AND eregi(quotemeta($query),$title)) {
					$a = 3;
				    }
				    if ($a == 1) {
					$match = _MATCHTITLE;
				    } elseif ($a == 2) {
					$match = _MATCHTEXT;
				    } elseif ($a == 3) {
					$match = _MATCHBOTH;
				    }
				    if (!isset($a)) {
					$match = "";
				    } else {
					$match = "$match<br>";
				    }
				}
                    printf("<tr><td><img src=\"images/folders.gif\" border=\"0\" alt=\"\">&nbsp;<font class=\"option\"><a href=\"%s\"><b>%s</b></a></font><br><font class=\"content\">"._CONTRIBUTEDBY." $informant<br>"._POSTEDBY." <a href=\"%s\">%s</a>",$furl,$title,$url,$aid,$informant);
                                echo " "._ON." $datetime<br>"
				    ."$match"
				    .""._TOPIC.": <a href=\"modules.php?name=$module_name&amp;query=&amp;topic=$topic\">$topictext</a> ";
				if ($comments == 0) {
				    echo "("._NOCOMMENTS.")";
				} elseif ($comments == 1) {
				    echo "($comments "._UCOMMENT.")";
                                } elseif ($comments >1) {
				    echo "($comments "._UCOMMENTS.")";
				}
				if (is_admin($admin)) {
				    echo " [ <a href=\"".$admin_file.".php?op=EditStory&amp;sid=$sid\">"._EDIT."</a> | <a href=\"".$admin_file.".php?op=RemoveStory&amp;sid=$sid\">"._DELETE."</a> ]";
				}
				echo "</font><br><br><br></td></tr>\n";
				$x++;
                        }
		$db->sql_freeresult($result5);
		echo "</table>";
		} else {
                        echo "<tr><td><center><font class=\"option\"><b>"._NOMATCHES."</b></font></center><br><br>";
			echo "</td></tr></table>";
                }

                $prev=$min-$offset;
				$query1 = stripslashes($query);
                if ($prev>=0) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$topic&amp;min=$prev&amp;query=$query1&amp;type=$type\">";
						
                        print "<b>$min "._PREVMATCHES."</b></a></center>";
                }

                $next=$min+$offset;
		if ($x>=9) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$t&amp;min=$max&amp;query=$query&amp;type=$type\">";
                        print "<b>"._NEXTMATCHES."</b></a></center>";
                }

	} elseif ($type=="comments") {

		$result8 = $db->sql_query("SELECT `cm.*`,`ns.title` from `".$prefix."_comments_moderated` AS cm 
		LEFT JOIN ".$prefix."_stories AS ns ON (ns.sid==cm.sid)
		where (`cm.subject` like '%$query%' OR `cm.comment` like '%$query%')  AND ns.time<=now() AND  ns.approved='1' order by cm.date DESC limit $min,$offset");
            $nrows = $db->sql_numrows($result8);
            $x=0;
	    if (!empty($query)) {
	    echo "<center><b>"._SEARCHRESULTS."$query</b></center><br><br>";
		echo "<table width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
		if ($nrows>0) {
			while($row8 = $db->sql_fetchrow($result8)) {
				$tid = intval($row8['tid']);
                $sid = intval($row8['sid']);
                $subject = check_words(check_html($row8['subject'], "nohtml"));
                $date = $row8['date'];
                $name = check_words(check_html($row8['name'], "nohtml"));
			    $title = check_words(check_html($row_res['title'], "nohtml"));
			    $furl = "modules.php?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."";
                if(!$name) {
					$name = "$anonymous";
			    } else {
					$name = "<a href=\"modules.php?name=Your_Account&amp;op=userinfo&amp;username=$name\">$name</a>";
			    }
			    $datetime = formatTimestamp($date);
				echo "<tr><td><img src=\"images/folders.gif\" border=\"0\" alt=\"\">&nbsp;<font class=\"option\"><a href=\"$furl\"><b>$subject</b></a></font><font class=\"content\"><br>"._POSTEDBY." $name"
                  	." "._ON." $datetime<br>"
					.""._ATTACHART.": $title<br>";
			    if ($reply == 1) {
					echo "($reply "._SREPLY.")";
					if (is_admin($admin)) {
				    	echo " [ <a href=\"".$admin_file.".php?op=RemoveComment&amp;tid=$tid&amp;sid=$sid\">"._DELETE."</a> ]";
					}
					echo "<br><br><br></td></tr>\n";
			    } else {
					echo "($reply "._SREPLIES.")";
					if (is_admin($admin)) {
				    	echo " [ <a href=\"".$admin_file.".php?op=RemoveComment&amp;tid=$tid&amp;sid=$sid\">"._DELETE."</a> ]";
					}
					echo "<br><br><br></td></tr>\n";
			    }
			    $x++;
        	}
		$db->sql_freeresult($result8);
			echo "</table>";
		} else {
            echo "<tr><td><center><font class=\"option\"><b>"._NOMATCHES."</b></font></center><br><br>";
			echo "</td></tr></table>";
        }

                $prev=$min-$offset;
                if ($prev>=0) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$topic&amp;min=$prev&amp;query=$query&amp;type=$type\">";
                        print "<b>$min "._PREVMATCHES."</b></a></center>";
                }

                $next=$min+$offset;
		if ($x>=9) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$topic&amp;min=$max&amp;query=$query1&amp;type=$type\">";
                        print "<b>"._NEXTMATCHES."</b></a></center>";
                }
	    }
	} elseif ($type=="users") {
            $res_n3 = $db->sql_query("SELECT user_id, username, name from ".$user_prefix."_users where (username like '%$query%' OR name like '%$query%' OR bio like '%$query%') order by username ASC limit $min,$offset");
            $nrows = $db->sql_numrows($res_n3);
            $x=0;
	    if (!empty($query)) {
		echo "<center><b>"._SEARCHRESULTS."</b></center><br><br>";
		echo "<table width=\"99%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
		if ($nrows>0) {
                        while($rown3 = $db->sql_fetchrow($res_n3)) {
                            $uid = intval($rown3['user_id']);
                            $uname = stripslashes($rown3['username']);
                            $name = stripslashes($rown3['name']);
			    $furl = "modules.php?name=Your_Account&amp;op=userinfo&amp;username=$uname";
			     if (empty($name)) {
				$name = ""._NONAME."";
			    }
                            echo "<tr><td><img src=\"images/folders.gif\" border=\"0\" alt=\"\">&nbsp;<font class=\"option\"><a href=\"$furl\"><b>$uname</b></a></font><font class=\"content\"> ($name)";
			    if (is_admin($admin)) {
				echo " [ <a href=\"".$admin_file.".php?chng_uid=$uid&amp;op=modifyUser\">"._EDIT."</a> | <a href=\"".$admin_file.".php?op=delUser&amp;chng_uid=$uid\">"._DELETE."</a> ]";
			    }
			    echo "</font></td></tr>\n";
                            $x++;
                        }

		echo "</table>";
		} else {
                        echo "<tr><td><center><font class=\"option\"><b>"._NOMATCHES."</b></font></center><br><br>";
			echo "</td></tr></table>";
                }

				$query1 = stripslashes($query);
                $prev=$min-$offset;
                if ($prev>=0) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$t&amp;min=$prev&amp;query=$query1&amp;type=$type\">";
                        print "<b>$min "._PREVMATCHES."</b></a></center>";
                }

                $next=$min+$offset;
		if ($x>=9) {
                        print "<br><br><center><a href=\"modules.php?name=$module_name&amp;author=$author&amp;topic=$t&amp;min=$max&amp;query=$query1&amp;type=$type\">";
                        print "<b>"._NEXTMATCHES."</b></a></center>";
                }
	    }
	}
	CloseTable();	    	
	}


    
   OpenTable();
    $conf = $db->sql_fetchrow($db->sql_query('SELECT `value` FROM '.$prefix.'_msconfig 
                  WHERE id="scope-on-front-page" LIMIT 1'));
    $conf2 = $db->sql_fetchrow($db->sql_query('SELECT `value` FROM '.$prefix.'_msconfig 
                  WHERE id="use-gsearch" LIMIT 1'));
    $str = '<b>'._MSFORCOLON.'</b><select name="what">
        <option value="all">'._MSALL.'</option>';
    if ($handle = opendir('modules/'.$module_name.'/modules/')) {
      while (false !== ($file = readdir($handle))) {
        if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
          include_once('modules/'.$module_name.'/modules/'.$file);
           $cname = substr($file,0,-4);
          $cname2 = 'mS'.$cname;
          ${$cname} = new $cname2();
          if (${$cname}->useme()){
            $file = substr($file,0,-4);
            $str .= '<option value="'.str_replace('_', ' ', $file).'">'.$file.'</option>'."\n";}}}
          closedir($handle);}
    $str .= '</select><br>';
    echo '<br /><div>
      <form method="get" action="modules.php?name=Search">
      '.($conf['value'] == 'on' ? $str : '<input type="hidden" name="what" value="all" />').'
      <input type="text" name="query" style="width:70%;height:30px;margin:15px;"/>
      <input type="hidden" name="name" value="'.$module_name.'" />
      <input type="hidden" name="op" value="'.($conf2['value'] == 'on' ? 'g' : '').'search" />
      <input type="hidden" name="showerrors" value="1" />
	  <input type="submit" value="'._SEARCH.'" /><br></form></div>';
    CloseTable();
    
    /*
	OpenTable();
	include("modules/Search/inlcudes/googleSearch.php");
	CloseTable();
	*/
	
	
    
    $mod1 = $mod2 = $mod3 = "";
	if (isset($query) AND !empty($query)) {
	echo "<br>";
	if (is_active("Downloads")) {
	    $dcnt = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_nsngd_downloads WHERE title LIKE '%$query%' OR description LIKE '%$query%'"));
	    $query1 = stripslashes($query);
  	    $mod1 = "<li> <a href=\"modules.php?name=Downloads&amp;d_op=search&amp;query=$query1\">"._DOWNLOADS."</a> ($dcnt "._SEARCHRESULTS.")";
	}
	if (is_active("Web_Links")) {
	    $lcnt = $db->sql_numrows($db->sql_query("SELECT * from ".$prefix."_links_links WHERE title LIKE '%$query%' OR description LIKE '%$query%'"));
	    $query1 = stripslashes($query);
  	                                 $mod2 = "<li> <a href=\"modules.php?name=Web_Links&amp;l_op=search&amp;query=$query1\">"._WEBLINKS."</a> ($lcnt "._SEARCHRESULTS.")";
	}
	if (is_active("Encyclopedia")) {
	    $ecnt1 = $db->sql_query("SELECT eid from ".$prefix."_encyclopedia WHERE active='1'");
	    $ecnt = 0;
	    while($row_e = $db->sql_fetchrow($ecnt1)) {
                $eid = intval($row_e['eid']);
		$ecnt2 = $db->sql_numrows($db->sql_query("select * from ".$prefix."_encyclopedia WHERE title LIKE '%$query%' OR description LIKE '%$query%' AND eid='$eid'"));
		$ecnt3 = $db->sql_numrows($db->sql_query("select * from ".$prefix."_encyclopedia_text WHERE title LIKE '%$query%' OR text LIKE '%$query%' AND eid='$eid'"));
		$ecnt = $ecnt+$ecnt2+$ecnt3;
	    }
	    $query1 = stripslashes($query);
  	                                 $mod3 = "<li> <a href=\"modules.php?name=Encyclopedia&amp;file=search&amp;query=$query1\">"._ENCYCLOPEDIA."</a> ($ecnt "._SEARCHRESULTS.")";
	}

    }
    

    include("footer.php");
    break;
}

?>