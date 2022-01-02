<?php
class mSDownloads extends searchmodule {
	function __construct(){
		global $prefix;
		$this->name                  = 'Downloads';
		$this->sql_table_with_prefix = $prefix.'_downloads_downloads';}

	function formatrss($result){
		global $url;
		return '<item>
			  <title>Download: '.$result['title'].'</title>
			  <link>
			  '.$url['scheme'].'://'.$url['host'].$url['path'].'?name=Downloads&amp;d_op=viewdownloaddetails&amp;ttitle='.$result['title'].'&amp;lid='.$result['rid'].'
			  </link>
			  <description>
			  '.chopwords(strip_tags($result['desc']),192).'
			  </description>
			  </item>';}
	function gformatresult($result){
		return '<a href="modules.php?name=Downloads&d_op=viewdownloaddetails&ttitle='.$result['title'].'&lid='.$result['rid'].'">
			  '.$result['title'].'</a><br /><small>
			  By '.$result['author'].', '.formatdateago($result['date']).'
			  </small><br />'.chopwords(strip_tags($result['desc']),192);}
	function formatresult($result){
		return '<b>Download:</b> 
			  <a href="modules.php?name=Downloads&d_op=viewdownloaddetails&ttitle='.$result['title'].'&lid='.$result['rid'].'">
			  '.$result['title'].'</a><br /><small>
			  By '.$result['author'].', '.formatdateago($result['date']).'
			  </small><br />'.chopwords(strip_tags($result['desc']),192);}
	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach ($q as $query){
			$db->sql_query('INSERT INTO '.$tblname.'
					    (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`)
					    SELECT CONCAT("Downloads", `lid`) AS `id`, \'1\', UNIX_TIMESTAMP(`date`),
						     `title`, `lid`, `description`, `submitter`, "Downloads"
					    FROM '.$prefix.'_downloads_downloads
					    WHERE ((title like \'%'.$query.'%\')
						     OR (description like \'%'.$query.'%\'))');}}}
?>