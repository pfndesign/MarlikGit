<?php
/**
 *
 * @package shoutbox
 * @version $Id: BASIC VERSION : Aneeshtan $
 * @copyright (c) INSPIRED BY : yensdesign.com AND Revised By Marlik Group  http://www.MarlikCMS.com
 * @license ONLY FOR MarlikCMS'S USERS
 *
 */
/************************
	FUNCTIONS
/************************/
global $db,$prefix;
define("NL_SHOUTBOX_TABLE","".$prefix."_shoutbox");
define("NL_SHOUTBOX_SMILEY_DIR","images/smiley/");
define("NL_SHOUTBOX_SMILEY_FORMAT",".gif");
class nl_shoutbox {
	var $data = array();
	public  function check_smiley_in_text($text) {
		$smiley_array =  array(
						':D'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_biggrin".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':)'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_smile".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':('		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_sad".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':o'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_surprised".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':shock:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_eek".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						 ':?'		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_confused".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						 ':?:'		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_question".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						'8)'	=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_cool".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':lol:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_lol".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':P'	=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_razz".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':red:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_redface".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':cry:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_cry".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':evil:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_evil".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						'twisted:'		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_twisted".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':roll:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_rolleyes".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':wink:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_wink".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						 ':!:'		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_exclaim".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':?:'		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_question".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':idea:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_idea".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':green:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_mrgreen".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':frown:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_frown".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':mad:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_mad".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':neutral:' 		=>"<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_neutral".NL_SHOUTBOX_SMILEY_FORMAT."'>",
						':arrow:'		=> "<img src='".NL_SHOUTBOX_SMILEY_DIR."icon_arrow".NL_SHOUTBOX_SMILEY_FORMAT."'>"
					);
		return (strtr($text, $smiley_array));
	}
	public  function check_smiley_to_code($text) {
		$smiley_array =  array(
						'icon_biggrin'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":D",
						'icon_smile'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":)",
						'icon_sad'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":(",
						'icon_surprised'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":o",
						'icon_eek'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":shock:",
						'icon_confused'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":?",
						'icon_question'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":?:",
						'icon_cool'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> "8)",
						'icon_lol'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":lol:",
						'icon_razz'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":P",
						'icon_redface'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":red:",
						'icon_cry'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":cry:",
						'icon_evil'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":evil:",
						'icon_twisted'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":twisted:",
						'icon_rolleyes'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":roll:",
						'icon_wink'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":wink:",
						'icon_exclaim'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":!:",
						'icon_question'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":?:",
						'icon_idea'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":idea:",
						'icon_mrgreen'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":green:",
						'icon_frown'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":frown:",
						'icon_mad'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":mad:",
						'icon_neutral'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":neutral:",
						'icon_arrow'.NL_SHOUTBOX_SMILEY_FORMAT.''		=> ":arrow:"
						);
		$links = array_keys($smiley_array);
		$codes = array_values($smiley_array);
		return str_replace($links, $codes, $text);
	}
	public  function read_smiley_dir() {
		if($handle = opendir(NL_SHOUTBOX_SMILEY_DIR)) {
			$content =  '';
			$counter = 0;
			while (false !== ($file = readdir($handle))) {
				$counter++;
				if(is_file(NL_SHOUTBOX_SMILEY_DIR.$file)) {
					if ((substr($file, -4) == NL_SHOUTBOX_SMILEY_FORMAT)) {
						$texted_ico = $this->check_smiley_to_code($file);
						$content .=  '&nbsp;<a href="javascript:emotion_add_'.$texted_ico.'" class="add_emo" id="'.$texted_ico.'"><img src="'.NL_SHOUTBOX_SMILEY_DIR.$file.'"></a>';
					}
				}
				if ($counter == 9) {
					$content .="<br>";
					$counter=0;
				}
			}
		}
		return $content;
	}
	public  function getContent($num) {
		global $db;
		$res = $db->sql_query("SELECT * FROM ".NL_SHOUTBOX_TABLE." ORDER BY date DESC LIMIT ".$num);
		if(!$res)
				die("Error: ".mysql_error()); else
				return $res;
	}
	public  function insertMessage($user, $message) {
		global $db;
		$ctime = date("Y-m-j H:i:s");
		list($checkexpost_date) = $db->sql_fetchrow($db->sql_query("SELECT `date` FROM  ".NL_SHOUTBOX_TABLE."  WHERE `user`='". sql_quote(strip_tags($user))."' 
	AND ABS(TIME_TO_SEC(TIMEDIFF(`date`, $ctime))) < 10 "));
		if (!empty($checkexpost_date)) {
			$res ="فاصله میان هر پست در سیستم پیام کوتاه 10 ثانیه است";
		} else {
			$query = sprintf("INSERT INTO ".NL_SHOUTBOX_TABLE."(user, message) VALUES('". sql_quote(strip_tags($user))."','".sql_quote(strip_tags($message))."')");
			$res = $db->sql_query($query);
		}
		return $res;
	}
	public  function deleteMessage($id) {
		global $db,$admin;
		if (is_admin($admin)) {
			$query = sprintf("DELETE FROM ".NL_SHOUTBOX_TABLE." WHERE id='". sql_quote(strip_tags($id))."'");
			$res = $db->sql_query($query);
			if(!$res) {
				die("Error: ".mysql_error());
			}
		} else {
			$res = _ADMIN_YOUARENOT;
		}
		return $res;
	}
	public  function row_news($cnt,$even,$odd) {
		echo ($cnt%2) ? "<li class=\"$odd\">" : "<li class=\"$even\">";
	}
	public  function _shoutbox_data() {
		global $userinfo,$db;
		$this->data = $db->sql_fetchrow($db->sql_query("
		SELECT (SELECT COUNT(*) from ".NL_SHOUTBOX_TABLE.") shoutCount,
		SELECT (SELECT COUNT(*) from ".NL_SHOUTBOX_TABLE." WHERE user='".$userinfo["username"]."' ) urshoutCount;
  "));
	}
	public  function FilterThis($value) {
		$value = sql_quote($value);
		if (!empty($value)) {
			if (_numbers_format_Lng == "FA") {
				return Convertnumber2farsi(number_format($value));
			} else {
				return number_format($value);
			}
		} else {
			return 0;
		}
	}
	public  function jq_toggle_box($id,$atb,$box) {
		echo "<script type=\"text/javascript\">
 $(document).ready(function() {
 // toggles the slickbox on clicking the noted link
  $('$atb#$id').click(function() {
 $('#$box').toggle(400);
 return false;
  });
});
</script>";
	}
}
?>