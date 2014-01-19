<?php
class mSPages extends searchmodule {
	function mSPages (){
		global $prefix;
		$this->name                  = 'Pages';
		$this->sql_col_time          = 'post_time';
		$this->sql_col_title         = 'title';
		$this->sql_col_id            = 'pid';
		$this->sql_col_desc          = 'text';
		$this->sql_table_with_prefix = $prefix.'_extpages';
		$this->sql_where_cols        = array('title', 
							'text');}
	function buildlink($id,$title){
		return '?name=News&amp;file=article&amp;sid='.$id.'&amp;title='.$title.'';}}
?>