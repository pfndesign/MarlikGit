<?php 
/**
*
* @package News Class													
* @version $Id: 12:36 PM 6/9/2010 Created BY Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
global $prefix;
define("STORY_TABLE","".$prefix."_stories");
define("TAGS_TABLE","".$prefix."_tags");
/*IF YOUR TAGS ARE TOO LONG THEN DO THE	 BELOW QUERY 
$query = 'SET GLOBAL group_concat_max_len=15000';
mysql_query($query);
*/

class nk_posts
{

	var $data = array();

	
	
	public function _data($offset,$pagenum,$storyhome,$querylang,$qdb) {

		global $db, $pagenum, $storyhome, $user, $prefix, $multilingual, $currentlang, $articlecomm, $sitename, $userinfo,$nextg;

		$storyhome = (empty($storyhome) ? 5 : $storyhome);
		$this->storyhome	= $storyhome ;
		$this->pagenum		= $pagenum ;
		$this->offset		= ($pagenum-1) * $storyhome ;
		$this->ctime		= date("Y-m-j H:i:s");
		if(empty($qdb)){
		$this->qdb = "WHERE	ns.time <= '$this->ctime'  AND  ns.section='news' AND ns.approved='1' AND ns.title!='draft'";
		}else{
		$this->qdb = $qdb;
		}
		$this->totalnum		=$db->sql_numrows($db->sql_query("select sid from ".STORY_TABLE." $this->qdb $querylang"));
			
		$result = $db->sql_query("
		SELECT ns.*,ntg.tid,nto.topicid,
		GROUP_CONCAT(DISTINCT ntg.tag) AS mytags,
		GROUP_CONCAT(DISTINCT ntg.slug) AS tagslug,
		GROUP_CONCAT(DISTINCT nto.topicname) AS mytopics,
		GROUP_CONCAT(DISTINCT nto.slug) AS topicslug,
		ns.counter AS counter_num
		FROM ".$prefix."_stories AS ns		
		LEFT JOIN ".$prefix."_tags AS ntg ON FIND_IN_SET(ntg.tid, REPLACE(ns.tags, ' ', ','))
		LEFT JOIN ".$prefix."_topics AS nto ON FIND_IN_SET(nto.topicid, REPLACE(ns.associated, '-', ','))
		$this->qdb
		GROUP BY ns.sid
		ORDER BY ns.hotnews DESC,ns.sid DESC
		limit $this->offset,$this->storyhome
		");

		while ($this->data = $db->sql_fetchrow($result)) {

			$this->sid			=  $this->data['sid'];
			$this->catid		=  $this->data['catid'];
			$this->aid			=  $this->data['aid'];
			$this->title		=  $this->data['title'];
			$this->time			=  $this->data['time'];
			$this->hometext		=  $this->data['hometext'];
			$this->bodytext		=  $this->data['bodytext'];
			$this->newsref		=  $this->data['newsref'];
			$this->newsreflink	=  $this->data['newsreflink'];
			$this->comments		=  $this->data['comments'];
			$this->counter		=  $this->data['counter_num'];
			$this->topic		=  $this->data['topic'];
			$this->informant	=  $this->data['informant'];
			$this->notes		=  $this->data['notes'];
			$this->acomm		=  $this->data['acomm'];
			$this->rate			=  $this->data['rate'];
			$this->rates_count	=  $this->data['rates_count'];
			$this->tags			=  "";
			$this->associated	=  "";
			$this->topicimage	=  $this->data['topicimage'];
			$this->topictext	=  $this->data['topictext'];
			$this->_rating();
			$this->_tags();
			$this->_categories();
			$this->_output();

		}
		


	}
	public function _tags() {
		global $db,$prefix;
		$tags_t = ($this->data['tags'] == ' ') ? '' : explode(",",$this->data['mytags']);
		$tags_s = ($this->data['tags'] == ' ') ? '' : explode(",",$this->data['tagslug']);
			for ($i=0; $i<sizeof($tags_t) AND $i<sizeof($tags_s); $i++)
			{
				if (!empty($tags_t[$i])) {
						$this->tags .="<a href='modules.php?name=News&amp;file=tags&amp;tag=".$tags_s[$i]."'>".$tags_t[$i]."</a>&nbsp;";
				}
			}		
		}
	public function _categories() {
	global $db,$prefix;
		
	$asso_t = ($this->data['associated'] == '') ? '' : explode(",",$this->data['mytopics']);
	$asso_s = ($this->data['associated'] == '') ? '' : explode(",",$this->data['topicslug']);
			for ($i=0; $i<sizeof($asso_t) AND $i<sizeof($asso_t); $i++)
			{			
				if (!empty($asso_s[$i])) {
					$this->associated .="<a href='modules.php?name=News&amp;file=categories&amp;category=".$asso_s[$i]."'>".$asso_t[$i]."</a>&nbsp;";
				}
			}
		}
	public function _rating() {
		$this->rating = pullRating('1',$this->rate,$this->rates_count,$this->sid,false,false,false);
	}
	public function _pagination($mod,$value="") {
		news_pagination($this->totalnum,$mod,$value);
	}
	public function _output() {
		themeindex(
		$this->sid,
		$this->aid,
		$this->catid,
		$this->informant,
		$this->time,
		$this->title,
		$this->counter,
		$this->hometext,
		$this->bodytext,
		$this->notes,
		$this->morelink,
		$this->cattitle,
		$this->associated,
		$this->topicimage,
		$this->topictext,
		$this->tags,
		$this->rating,
		$this->comments
		);
	}
}

?>