<?php
class mSBlog extends searchmodule {
	function mSBlog (){
		global $prefix;
		$this->name                  = 'Blog';
		$this->sql_table_with_prefix = $prefix.'_blogs';}

	function buildlink($id){
		return '?name=Your_Account';}

	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach($q as $query){
			$db->sql_query('INSERT INTO '.$tblname.' 
					    (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`) 
					    SELECT `bid`, `tid`, `content`, `date`, `sender_name`, `reciever_name` FROM '.$prefix.'_blogs 
					    WHERE ((`content` like \'%'.$query.'%\'))');}}}
?>