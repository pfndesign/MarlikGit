<?php
class mSPolls extends searchmodule {
	function __construct (){
		global $prefix;
		$this->name                  = 'Polls';
		$this->sql_table_with_prefix = $prefix.'_poll_desc';}

	function formatrss($result){
		global $db, $prefix, $url;
		return '<item>
			<title>Polls: '.$result['title'].'</title>
			<link>
			'.$url['scheme'].'://'.$url['host'].$url['path'].'?name=Surveys&amp;op=results&amp;pollID='.$result['rid'].'
			</link>
			</item>';}
	function gformatresult($result){
		global $db, $prefix;
		return '<a href="modules.php?name=Surveys&amp;op=results&amp;pollID='.$result['rid'].'">
			  '.$result['title'].'</a>, '.formatdateago($result['date']);}
	function formatresult($result){
		global $db, $prefix;
		return '<b>Polls:</b>
			  <a href="modules.php?name=Surveys&amp;op=results&amp;pollID='.$result['rid'].'">
			  '.$result['title'].'</a>, '.formatdateago($result['date']);}
	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach ($q as $query){
			$db->sql_query('INSERT INTO '.$tblname.'
					   (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`)
					   SELECT CONCAT("Polls", `pollID`) AS `id`, \'1\', `timeStamp`,
						    `pollTitle`, `pollID`, `pollTitle`, \'1\', "Polls"
					   FROM '.$prefix.'_poll_desc WHERE
					   `pollTitle` like \'%'.$query.'%\';');}}}
?>