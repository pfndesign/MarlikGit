<?php

/**
 *
 * @package TAGS														
 * @version  inc_tags.php $Id: $JAMES  2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_tags.php" )) {
	show_error ( HACKING_ATTEMPT );
}

class Tags{
	function insert_tags($tags){ //in this function we pass tags through to be inserted or if they already exist increase their count
		global $db,$prefix;
		$count = count($tags);
		$tags = array_values($tags);
		$tag_sql = 'INSERT INTO `'.$prefix.'_tags` (`tag`,`slug`,`count`) VALUES ';
			for($i=0;$i<$count;$i++){
			$tags[$i] = mysql_real_escape_string($tags[$i]);
				list($tid) = $db->sql_fetchrow($db->sql_query('SELECT `tid` FROM `'.$prefix.'_tags` WHERE `tag` = "'.$tags[$i].'" LIMIT 1'));
				$tid = (int) $tid;
				if(!$tid AND $tags[$i] != ""){
					$tag_sql .= '("'.$tags[$i].'","'.sql_quote(Slugit($tags[$i])).'","1")';
					if($i != ($count - 1)) $tag_sql .= ','; else $tag_sql .= ';';
					}else{
						$db->sql_query('UPDATE `'.$prefix.'_tags` SET `count` = `count` + 1 WHERE `tid` = "'.$tid.'" LIMIT 1');				if($i == ($count - 1)){
						$tag_sql = rtrim($tag_sql,",");
						$tag_sql .= ';';
						}
						}
				}
				return $db->sql_query($tag_sql);
				}
		
	function remove_tag($tid){ //it does what it says
		global $db,$prefix;
		$tid = (int) $tid;
		return $db->sql_query('DELETE FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tid.'" LIMIT 1');
		}
	function update_tag($tid,$new_tag){ //it does what it says
		global $db,$prefix;
		$tid = (int) $tid;
		$new_tag = mysql_real_escape_string($new_tag);
		return $db->sql_query('UPDATE TABLE `'.$prefix.'_tags` SET `tag` = "'.$new_tag.'", `slug` = "'.sql_quote(Slugit($new_tag)).'" WHERE `tid` = "'.$tid.'"');
		}
	function get_countbyid($tid){ //it does what it says
		global $db,$prefix;
		$tid = (int) $tid;
		list($count) = $db->sql_fetchrow($db->sql_query('SELECT `count` FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tid.'" LIMIT 1'));
		return $count;
		}
	function get_countbytag($tag){//it does what it says
		global $db,$prefix;
		$tag = mysql_real_escape_string($tag);
		list($count) = $db->sql_fetchrow($db->sql_query('SELECT `count` FROM `'.$prefix.'_tags` WHERE `tag` = "'.$tag.'" LIMIT 1'));
		return $count;
		}
	function add_tags($tags){ // tags should be passed in this format: tag1,tag2,tag3,...
		global $db,$prefix;
		$tags = explode(",",$tags);
		return $this->insert_tags($tags);
			}
	function get_tag_ids($tags){ // tags should be passed in this format: tag1,tag2,tag3,...
		global $db,$prefix;
		$tags = explode(",",$tags);
		$count = count($tags);
		$tag_ids = ' ';
				for($i=0;$i<$count;$i++){
					if($tags[$i] != ""){
					list($tid) = $db->sql_fetchrow($db->sql_query('SELECT `tid` FROM `'.$prefix.'_tags` WHERE `tag` = "'.$tags[$i].'" LIMIT 1'));
					$tag_ids .= $tid.' ';
					}
					}
				return $tag_ids;
				}
	function change_story_tags($tags,$sid){// tags should be passed in this format: tag1,tag2,tag3,...
		global $db,$prefix;
		list($oldtag_ids) = $db->sql_fetchrow($db->sql_query('SELECT `tags` FROM `'.$prefix.'_stories` WHERE `sid` = "'.$sid.'" LIMIT 1'));
			$oldtags = $this->get_tag_by_ids($oldtag_ids);
			$oldtag_ids = explode(" ",$oldtag_ids);
			$newtag_ids = $this->get_tag_ids($tags);
			//$db->sql_query('UPDATE `'.$prefix.'_stories` SET `tags` = "'.$newtag_ids.'" WHERE `sid` = "'.$sid.'" LIMIT 1');
			$newtag_ids = explode(" ",$newtag_ids);
			$added_tags = array_diff($newtag_ids,$oldtag_ids);
			$removed_tags = array_diff(explode(",",$oldtags),explode(",",$tags));
			$newtags = array_diff(explode(",",$tags),explode(",",$oldtags));
			$this->countdown($removed_tags);
			$this->insert_tags($newtags);
		}
			
	function get_tag_by_ids($tids){//tag ids should be passed in this format to this function: ' id1 id2 id3 ... '
		global $db,$prefix;
		$tids = explode(" ",$tids);
		$c = count($tids);
		$wclse = '';
		for($i=0;$i<$c-1;$i++){
				if($tids[$i] != ''){
					$wclse .= '`tid`= "'.$tids[$i].'"';
					if($tids[$i+1] == '') break;
					$wclse .= ' OR ';
				}
		}
		$resultw = $db->sql_query('SELECT `tag` FROM `'.$prefix.'_tags` WHERE '.$wclse);
		$tagss = '';
		while($row = $db->sql_fetchrow($resultw))
		$tagss .= $row['tag'].',';
		return $tagss;
	}

	
	function input_tags ($name,$ex_tags = ''){ // this one creates the input area for entering tags
		global $db,$prefix;
			$tags = explode(" ",$ex_tags);
			$c = count($tags);
			$tagss = '';
			for($i=1;$i<$c-1;$i++){
				list($tag) = $db->sql_fetchrow($db->sql_query('SELECT `tag` FROM `'.$prefix.'_tags` WHERE `tid` = "'.$tags[$i].'" LIMIT 1'));
				$tag_arr = explode(",",$tag);
				if($tag_arr != "")
				 foreach ($tag_arr as $ti) {
				$tagss .= "t4.add('$ti');";
 					}
				}
		$t ='	
			<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/GrowingInput.js" type="text/javascript" charset="utf-8"></script>
			<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.js" type="text/javascript" charset="utf-8"></script>		
			<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8" ></script>';
		?>
		<script type="text/javascript" charset="utf-8">		
		$(function(){
			var t4 = new $.TextboxList('#tags', {unique: true, plugins: {autocomplete: {}}});
			<?php echo $tagss?>
			t4.getContainer().addClass('textboxlist-loading');
			$.ajax({url: '<?php echo ADMIN_OP?>Tags&act=query', dataType: 'json', success: function(r){
				t4.plugins['autocomplete'].setValues(r);
				t4.getContainer().removeClass('textboxlist-loading');
			}});

		});
		</script>
		<?php
		$t .='<style>
		@import url(\''.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.css\');
		@import url(\''.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.Autocomplete.css\');
		</style>';

		
$t .="
<div class=\"form_friends\" style='float:".langStyle(align).";text-align:".langStyle(align)."'>
<img src='images/icon/help.png' title='"._TAGS_MOVE."'>
<input type=\"text\"  name='$name' id='$name' value=\"\" />"._TAGS_PRESS_ENTER."
</div>
";
	
return $t ;

}
	function countdown($tags){ // and this is where we decrease tags' count by one
		global $db,$prefix;
		//$tag_ids = $this->get_tag_ids($tags);
		//$tag_ids = explode(" ",$tag_ids);
		$tags = array_values($tags);
		$c = count($tags);
		print_r($tags);
		$wcls = '';
		for($i=0;$i<$c;$i++){
			if($tags[$i] != ''){
				$wcls .= '`tag` = "'.$tags[$i].'"';
				$wcls .=' OR ';
			}
		}
		$wcls .= '`tid` = "tag"';
		echo $wcls;
		$db->sql_query('UPDATE `'.$prefix.'_tags` SET `count` = `count`-1 WHERE '.$wcls);
	}

	function resetTags_counts(){
		global $db,$prefix;

		define("TAGS_TABLE","".$prefix."_tags");
		define("STORIES_TABLE","".$prefix."_stories");
		define("DL_TABLE","".$prefix."_nsngd_downloads");

		$db->sql_query("UPDATE ".TAGS_TABLE."  SET `count`=0");
		$result = $db->sql_query("SELECT * FROM ".TAGS_TABLE."");
		$a = 1;
		while($row = $db->sql_fetchrow($result)) {
			$rowsql = $db->sql_fetchrow($db->sql_query("
	SELECT (SELECT COUNT(*) from ".DL_TABLE." WHERE FIND_IN_SET(".$row['tid'].", REPLACE(tags, ' ', ',')) ) dlcount,
    (SELECT COUNT(*) from  " . STORIES_TABLE . " WHERE FIND_IN_SET(".$row['tid'].", REPLACE(tags, ' ', ',')) ) nscount;"));
			$totalcount = $rowsql['dlcount']+$rowsql['nscount'];
			$querycount = $db->sql_query("UPDATE ".TAGS_TABLE." SET `count`='$totalcount' WHERE `tid`='".$row['tid']."'");
			echo "#".$row['tag']." : <b>$totalcount</b><br>";
		if (!$querycount) {
				echo _ERROR.":<br>";
		}
		}
		$db->sql_freeresult($result);
		$db->sql_query("DELETE FROM ".TAGS_TABLE."  WHERE `count`=0");
	}

}


	$tag = new Tags;
?>