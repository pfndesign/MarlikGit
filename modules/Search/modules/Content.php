<?php
class mSContent extends searchmodule {
	function mSContent (){
		global $prefix;
		$this->name                  = 'Content';
		$this->sql_col_time          = 'date';
		$this->sql_col_title         = 'title';
		$this->sql_col_id            = 'pid';
		$this->sql_col_desc          = 'text';
		$this->sql_col_author        = '"none"';
		$this->sql_table_with_prefix = $prefix.'_pages';
		$this->sql_where_cols        = array('title',
							'page_footer',
							'signature',
							'text');}
	function buildlink($id){
		return '?name=Content&amp;pa=showpage&amp;pid='.$id;}
	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach ($q as $query){
			$db->sql_query('INSERT INTO '.$tblname.' (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`) 
					SELECT CONCAT("Content", `pid`) AS `id`, \'1\', UNIX_TIMESTAMP(`date`), `title`, `pid`, `text`, "none", 
					"Content" FROM '.$prefix.'_pages 
					WHERE ((title like \'%'.$query.'%\') 
						OR (page_footer like \'%'.$query.'%\') 
						OR (signature like \'%'.$query.'%\') 
						OR (text like \'%'.$query.'%\'))');}}}
?>