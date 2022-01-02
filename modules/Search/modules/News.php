<?php
class mSNews extends searchmodule {
	function __construct (){
		global $prefix;
		$this->name                  = 'News';
		$this->sql_col_time          = 'time';
		$this->sql_col_title         = 'title';
		$this->sql_col_id            = 'sid';
		$this->sql_col_desc          = 'hometext';
		$this->sql_col_author        = 'aid';
		$this->sql_table_with_prefix = $prefix.'_stories';
		$this->sql_where_cols        = array('title', 
							'hometext', 
							'bodytext');}
	function buildlink($id,$title){
		return "?name=News&amp;file=article&amp;sid=$sid&amp;title=".Slugit($title)."";}}
?>