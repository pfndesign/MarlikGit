<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* mSearch Copyright (c) 2005 David Karn, All rights reserved        */
/* http://www.webdever.net/                                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of($module_name,$admin)) {



// Module code:

function configuration_page(){
  global $db, $prefix;
  $res = $db->sql_query('SELECT * FROM '.$prefix.'_msconfig');
  while ($i = $db->sql_fetchrow($res)){
    $results[$i['id']] = $i['value'];}
  $content = '<h2>'._mSCONFIG.'</h2><form action="'.ADMIN_PHP.'"><div style="padding-left:20px;"><table cellspacing="15px" border="0" width="80%">'
    .'<tr valign="top"><td width="30%">'._mSRPP.'</td><td><input type="text" name="rpp" value="'.$results['results-per-page'].'" style="width:10%" /></td></tr>'
    .'<tr valign="top"><td width="30%">'._mSSHOWRSS.'</td><td align="left"><input type="checkbox" name="showrss" '.($results['enable-rss'] == 'on' ? 'checked ' : '').'/></td></tr>'
    .'<tr valign="top"><td width="30%">'._mSSHOWGSEARCH.'</td><td align="left"><input type="checkbox" name="usegsearch" '.($results['use-gsearch'] == 'on' ? 'checked ' : '').'/></td></tr>'
    .'<tr valign="top"><td width="30%">'._mSSCOPEFRONT.'</td><td align="left"><input type="checkbox" name="scopefront" '.($results['scope-on-front-page'] == 'on' ? 'checked ' : '').'/></td></tr>'
    .'<tr><td colspan="2" align="right"><input type="reset" value="'._mSRESET.'" /><input type="submit" value="'._mSSUBMIT.'" /><input type="hidden" name="op" value="mSsubmitconfig" /></td></tr>'
    .'</table></div></form>';
  return $content;}

function submit_config(){
  global $db, $prefix;
  $res = $db->sql_query('UPDATE '.$prefix.'_msconfig SET value="'.addslashes($_REQUEST['rpp']).'" WHERE id="results-per-page"');
  $res2 = $db->sql_query('UPDATE '.$prefix.'_msconfig SET value="'.addslashes($_REQUEST['showrss']).'" WHERE id="enable-rss"');
  $res3 = $db->sql_query('UPDATE '.$prefix.'_msconfig SET value="'.addslashes($_REQUEST['usegsearch']).'" WHERE id="use-gsearch"');
  $res4 = $db->sql_query('UPDATE '.$prefix.'_msconfig SET value="'.addslashes($_REQUEST['scopefront']).'" WHERE id="scope-on-front-page"');
  if ($res && $res2 && $res3 && $res3){
    return '<center>'._mSCONFIGSUCCESS.'<br /><a href="'.ADMIN_OP.'mSconfig">'._mSGOBACK.'</a></center>';}
  else {
    return '<center>'._mSSORRY.'<br /><a href="'.ADMIN_OP.'mSconfig">'._mSGOBACK.'</a></center>';}}

function modules_list(){
  global $db, $prefix, $module_name;
  $content = '<h4>'._mSDISABLED.'</h4><div style="padding-left:10px"><br>';
  $res = $db->sql_query('SELECT * FROM '.$prefix.'_msmodules WHERE `use`="no"');
  while ($i = $db->sql_fetchrow($res)){
    $content .= $i['name'].' (<a href="'.ADMIN_OP.'mSaddmod&id='.$i['name'].'">remove</a>)<br />';}
  $content .= '</div><b>'._mSDISABLE.'</b><div style="padding-left:10px"><br>
      <form method="post" action="'.ADMIN_OP.'mSdisablemod"><select name="id">';
  if ($handle = opendir('modules/'.$module_name.'/modules/')) {
    while (false !== ($file = readdir($handle))) {
      if (!is_dir('modules/'.$module_name.'/modules/'.$file)) {
        include_once('modules/'.$module_name.'/modules/'.$file);
         $cname = substr($file,0,-4);
        $cname2 = 'mS'.$cname;
        ${$cname} = new $cname2();
        if (${$cname}->useme()){
          $file = substr($file,0,-4);
          $content .= '<option value="'.$file.'">'.$file.'</option>'."\n";}}}
        closedir($handle);}
  return $content.'</select><input type="submit" value="'._mSDIS.'"></form></div>';}

function restrict_module(){
  global $db, $prefix;
  $res = $db->sql_query('INSERT INTO `'.$prefix.'_msmodules` (`name`, `use`) VALUES("'.$_REQUEST['id'].'", "no");');
  return modules_list();}

function add_module(){
  global $db, $prefix;
  $res = $db->sql_query('DELETE FROM `'.$prefix.'_msmodules` WHERE `name`="'.$_REQUEST['id'].'"');
  return modules_list();}

// Header stuff:
  include("header.php");
  GraphicAdmin();
  OpenTable();
  echo '<center><h2>'._mS.'</h2>[ <a href="'.ADMIN_OP.'mSearch">'._mSCONFIG.'</a> | <a href="'.ADMIN_OP.'mSmodules">'._mSDISMOD.'</a> ]';
  CloseTable();
  echo '<br />';
  OpenTable();
  switch ($_REQUEST['op']){
    case 'mSdisablemod':
      echo restrict_module();
      break;
    case 'mSaddmod':
      echo add_module();
      break;
    case 'mSmodules':
      echo modules_list();
      break;
    case 'mSsubmitconfig':
      echo submit_config();
      break;
    default:
      echo configuration_page();
      break;}
  CloseTable();
  include("footer.php");

// Module Definition

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
        '.$url['scheme'].'://'.$url['host'].$url['path'].$this->buildlink($result['rid']).'
      </link>
      <description>
         '.chopwords(strip_tags($result['desc']),192).'
      </description>
    </item>';}

  function formatresult($result){
    // Format a result to be displayed in the module
    return '<b>'.$this->name.':</b> 
        <a href="modules.php'.$this->buildlink($result['rid']).'">
        '.$result['title'].'</a><br /><small>
        '.($result['author'] ? ''._MSBY.' '.$result['author'] : '').($result['date'] ? ', '.formatdateago($result['date']) : '').'
        </small><br />'.chopwords(strip_tags($result['desc']),192);}

  function gformatresult($result){
    // Format a result to be displayed in the group-display page
    return '<a href="modules.php'.$this->buildlink($result['rid']).'">
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

  function buildlink($id){
    // Used by the individual modules to define how a link to an item should be built
    }

  function buildquery(){
    // Not sure why this is here either, but it is
    }}

    
}else {
	die("Access Denied To $module_name administration");
}
?>