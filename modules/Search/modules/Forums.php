<?php
function getusernamefromid($id){
	global $db, $prefix;
	$res = $db->sql_query('SELECT username FROM '.$prefix.'_users WHERE user_id="'.$id.'" LIMIT 1;');
	$res = $db->sql_fetchrow($res);
	return $res['username'];}

class mSForums extends searchmodule {
	function __construct(){
		global $prefix;
		$this->name                  = 'phpBB3';
		$this->sql_table_with_prefix = $prefix.'_bb3posts';}

	function formatrss($result){
		global $db, $prefix, $url;
		$res = $db->sql_query('SELECT `post_time` as `time`, `poster_id` AS `aid`, `topic_id` AS `id` FROM '.$prefix.'_bb3posts WHERE post_id="'.$result['rid'].'" LIMIT 1;');
		$res = $db->sql_fetchrow($res);
		$result['date'] = $res['time'];
		$result['rid'] = $res['id'];
		$result['author'] = getusernamefromid($res['aid']);
		if (!trim($result['title'])){
			$result['title'] = 'View Result';}
		return '<item>
			  <title>Forums: '.$result['title'].'</title>
			  <link>
			  '.$url['scheme'].'://'.$url['host'].$url['path'].'?name=phpBB3&amp;file=viewtopic&amp;t='.$result['rid'].'&amp;mode=&amp;order=0&amp;thold=0
			  </link>
			  <description>
			  '.chopwords(strip_tags($result['desc']),192).'
			  </description>
			  </item>';}

	function gformatresult($result){
		global $db, $prefix;
		$res = $db->sql_query('SELECT `post_time` as `time`, `poster_id` AS `aid`, `topic_id` AS `id` FROM '.$prefix.'_bb3posts WHERE post_id="'.$result['rid'].'" LIMIT 1;');
		$res = $db->sql_fetchrow($res);
		$result['date'] = $res['time'];
		$result['rid'] = $res['id'];
		$result['author'] = getusernamefromid($res['aid']);
		if (!trim($result['title'])){
			$result['title'] = 'View Result';}
		return '<a href="modules.php?name=phpBB3&file=viewtopic&t='.$result['rid'].'&mode=&order=0&thold=0">'.$result['title'].'</a><br /><small>By '.$result['author'].', '.formatdateago($result['date']).'</small><br />'.chopwords(strip_tags($result['desc']),192);}

	function formatresult($result){
		global $db, $prefix;
		$res = $db->sql_query('SELECT `post_time` as `time`, `poster_id` AS `aid`, `post_id` AS `id`,`post_subject` AS `title`  FROM '.$prefix.'_bb3posts WHERE post_id="'.$result['rid'].'" LIMIT 1;');
		$res = $db->sql_fetchrow($res);
		$result['date'] = $res['time'];
		$result['rid'] = $res['id'];
		$result['title'] = $res['title'];
		$result['author'] = getusernamefromid($res['aid']);
		if (!trim($result['title'])){
			$result['title'] = 'مشاهده';}
		return '<a href="modules.php?name=phpBB3&file=viewtopic&p='.$result['rid'].'">'.$result['title'].'</a><br /><small>By '.$result['author'].', '.formatdateago($result['date']).'</small><br />'.chopwords(strip_tags($result['desc']),192);}

	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach ($q as $query){
			$db->sql_query('INSERT INTO '.$tblname.' 
					   (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`) 
					   SELECT CONCAT("Forums", `post_id`) AS `id`, \'1\', \'0\', `post_subject`, 
					   `post_id`, `post_text`, \'0\', "Forums" FROM '.$prefix.'_bb3posts 
					   WHERE ((post_subject like \'%'.$query.'%\') 
					   OR (post_text like \'%'.$query.'%\'))');}}}
?>