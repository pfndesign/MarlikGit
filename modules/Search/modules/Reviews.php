<?php
class mSReviews extends searchmodule {
	function __construct (){
		global $prefix;
		$this->name                  = 'Reviews';
		$this->sql_col_time          = 'date';
		$this->sql_col_title         = 'title';
		$this->sql_col_id            = 'id';
		$this->sql_col_desc          = 'text';
		$this->sql_col_author        = 'reviewer';
		$this->sql_table_with_prefix = $prefix.'_reviews';
		$this->sql_where_cols        = array('title',
							'text');}
	function buildlink($id,$title){
		return '?name=Reviews&amp;rop=showcontent&amp;id='.$id;}
	function doquery(){
		global $prefix, $tblname, $db;
		$q = $this->query[0][1];
		foreach($q as $query){
		$db->sql_query('INSERT INTO '.$tblname.' 
				    (`id`, `relevance`, `date`, `title`, `rid`, `desc`, `author`, `searchmodule`) 
				    SELECT CONCAT("Reviews", id) AS idd, \'1\', UNIX_TIMESTAMP(`date`), `title`, `id`, 
				    `text`, `reviewer`, "Reviews" FROM '.$prefix.'_reviews 
				    WHERE ((`title` like \'%'.$query.'%\') 
					     OR (text like \'%'.$query.'%\'))');}}}
?>