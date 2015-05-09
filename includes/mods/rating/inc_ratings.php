<?php

/**
 *
 * @package RATING														
 * @version  inc_ratings.php $Id: beta6 $ 2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_ratings.php" )) {
	show_error ( HACKING_ATTEMPT );
}

define('NEWS_SEC',1);
define('DOWNLOAD_SEC',2);
define('USERS_SEC',3);

addCSSToHead(MODS_PATH."rating/rating_style.css","file");
addJSToHead(MODS_PATH."rating/rating_update.js","file");


function getRating($rate,$rcount){


		if($rcount == 0) return '0%';
		
		$perc = ($rate/$rcount) * 20;
		
		//$newPerc = round($perc/5)*5;
		//return $newPerc.'%';
		
		$newPerc = round($perc,2);
		return $newPerc.'%';
}

function outOfFive($rate,$rcount){

		if($rcount == 0) return 0;
		$perc = ($rate/$rcount);
		
		return round($perc,2);
		//return round(($perc*2), 0)/2; // 3.5
	

}

function getVotes($rcount){
	return $rcount.' '._VOTE_NUM;
}

function pullRating($section='1',$rate,$rcount,$sid, $show5 = false, $showPerc = false, $showVotes = false, $static = NULL){
	global $userinfo,$db;
	// Check if they have already voted...
	$text = '';
		
		if($show5 || $showPerc || $showVotes){
			
			$text .= '<div class="rated_text">';
			
		}
			if($show5){
				$show5bool = 'true';
				$text .= 'درجه <span id="outOfFive_'.$sid.'" class="out5Class">'.outOfFive($rate, $rcount).'</span>/5';
			} else {
				$show5bool = 'false';
			}
			if($showPerc){
				$showPercbool = 'true';
				$text .= ' (<span id="percentage_'.$sid.'" class="percentClass">'.getRating($rate, $rcount).'</span>)';
			} else {
				$showPercbool = 'false';
			}
			if($showVotes){
				$showVotesbool = 'true';
				$text .= ' (<span id="showvotes_'.$sid.'" class="votesClass">'.getVotes($rcount).'</span>)';
			} else {
				$showVotesbool = 'false';	
			}
			
		if($show5 || $showPerc || $showVotes){	
		
			$text .= '</div>';
			
		}
		return $text.'
			<ul class="star-rating" id="rater_'.$sid.'">
				<li class="current-rating" style="width:'.getRating($rate, $rcount).';" id="ul_'.$sid.'"></li>
				<li><a rel="nofollow" onclick="rate(\'1\',\''.$sid.'\','.$show5bool.','.$showPercbool.','.$showVotesbool.',\''.$section.'\',\''.$sid.'\'); return false;" href="javascript:#" title="امتیاز 1 از 5" class="one-star" >1</a></li><div id="loading_'.$sid.'"></div>
				<li><a  rel="nofollow"onclick="rate(\'2\',\''.$sid.'\','.$show5bool.','.$showPercbool.','.$showVotesbool.',\''.$section.'\',\''.$sid.'\'); return false;" href="javascript:#" title="امتیاز2 از 5" class="two-stars">2</a></li>
				<li><a  rel="nofollow" onclick="rate(\'3\',\''.$sid.'\','.$show5bool.','.$showPercbool.','.$showVotesbool.',\''.$section.'\',\''.$sid.'\'); return false;" href="javascript:#" title="امتیاز3 از 5" class="three-stars">3</a></li>
				<li><a  rel="nofollow" onclick="rate(\'4\',\''.$sid.'\','.$show5bool.','.$showPercbool.','.$showVotesbool.',\''.$section.'\',\''.$sid.'\'); return false;" href="javascript:#" title="امتیاز4 از 5" class="four-stars">4</a></li>
				<li><a rel="nofollow" onclick="rate(\'5\',\''.$sid.'\','.$show5bool.','.$showPercbool.','.$showVotesbool.',\''.$section.'\',\''.$sid.'\'); return false;" href="javascript:#" title="امتیاز 5از 5" class="five-stars">5</a></li>
			</ul>';
	
	
}
// Added in version 1.5
// Fixed sort in version 1.7
function getTopRated($limit, $table, $idfield, $namefield){
global $db;	
	$result = '';
	
	$sql = "SELECT COUNT(ratings.id) as rates,ratings.rating_id,".$table.".".$namefield." as thenamefield,ROUND(AVG(ratings.rating_num),2) as rating 
			FROM rating_id,".$table." WHERE ".$table.".".$idfield." = ratings.rating_id GROUP BY rating_id 
			ORDER BY rates DESC,rating DESC LIMIT ".$limit."";
			
	$sel = $db->sql_query($sql);
	
	$result .= '<ul class="topRatedList">'."\n";
	
	while($data = @mysql_fetch_assoc($sel)){
		$result .= '<li>'.$data['thenamefield'].' ('.$data['rating'].')</li>'."\n";
	}
	
	$result .= '</ul>'."\n";
	
	return $result;
	
}

function setScore(){
	global $db;
	$section = sql_quote($_GET[section]);
	$mode = sql_quote($_GET[mode]);
	$id = sql_quote(intval($_GET[id]));
	
	if (empty($id) AND empty($mode) AND empty($section)) {
		die(_EMPTY_FEILD);
	}

	if (!empty($_COOKIE['vote_posneg_'.$id.''])) {
		die(_DUPLICATED);
	}
	switch ($section){
		
		case "comments":
			$sql= "UPDATE ".COMMENTS_TABLE." SET `score`= score$mode WHERE tid='$id'";
	 		$sql2= "SELECT `score` FROM ".COMMENTS_TABLE." WHERE tid='$id' LIMIT 1";
		break;
		
		case "news":
			$sql= "UPDATE ".STORY_TABLE." SET `rate` = rate$mode WHERE sid='$id'";
	 		$sql2= "SELECT `rate` FROM ".STORY_TABLE." WHERE sid='$id' LIMIT 1";
		break;
	
	}
	
	$result = $db->sql_query($sql);
	$db->sql_freeresult($result);
	list($cnumnow) = $db->sql_fetchrow($db->sql_query($sql2)) or die(mysql_error());
	setcookie('vote_posneg_'.$id.'','+1');

	die($cnumnow);

}
?>