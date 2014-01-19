<?php

/**
 *
 * @package html editorial source														
 * @version  inc_htmlclean.php $Id: beta6 $ 2:12 AM 12/25/2009						
 * @copyright (c)Nukelearn Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_statistics.php" )) {
	show_error ( HACKING_ATTEMPT );
}

define ( 'INCLUDES_PATH', 'includes/' );
require_once("mainfile.php");

class statistics {

	var $countData = array();
	var $countDataIPT = array();

	public function _data(){
		global $db,$trackip,$prefix;

		$today = date('Y-m-d');
		$yesterday = date('Y-m-d',time()-(3600 *24));
		$this_month = date("M");
		$this_year = date("Y");

		$result = $db->sql_query("
		SELECT (SELECT COUNT(*) from ".__USER_TABLE.") userCount,
       (SELECT  COUNT(`user_id`) from ".__USER_TABLE." WHERE `user_regdate`='".date("M d, Y")."')  tusers,
       (SELECT  COUNT(`user_id`) from  " . __USER_TABLE . " WHERE `user_regdate`='".date("M d, Y", time()-86400)."') yusers,
       (SELECT  SUM(SUBSTRING(user_regdate, 1, 4)='$this_month' AND SUBSTRING(user_regdate, 9, 12)='$this_year')
       from  " . __USER_TABLE . ") premusers,
       (SELECT COUNT(`user_id`) from  " . __USER_TABLE . " WHERE `user_regdate`LIKE '%".date("Y")."' ) preyusers,
       (SELECT COUNT(*) from  " . STORY_TABLE . ") totalposts,
       (SELECT COUNT(*) from " . COMMENTS_TABLE . ") totalcomm,
       (SELECT COUNT(*) from " . DOWNLOAD_TABLE . ") totalfiles,
       (SELECT COUNT(*) from  " . __SESSION_TABLE . ") totalonlines,
       (SELECT COUNT(DISTINCT `session_user_id`) from " . __SESSION_TABLE . " WHERE session_user_id > 0 ) uonline,
       (SELECT COUNT(DISTINCT `session_ip`) from " . __SESSION_TABLE . " WHERE session_user_id = '0' ) gonline,
       (SELECT `count` from " . __COUNTER_TABLE . " WHERE type = 'total_today') total_today,
       (SELECT `count` from " . __COUNTER_TABLE . " WHERE type = 'total_yesterday') total_yesterday,
       (SELECT `count` from " . __COUNTER_TABLE . " WHERE type = 'total' AND var = 'visits') totalVisits,
       (SELECT `count` from " . __COUNTER_TABLE . " WHERE type = 'total' AND var = 'pageviews') totalPVisits;
  ");
		
		$this->countData = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ($trackip==1) {
			$result = $db->sql_query("
	SELECT (SELECT COUNT(*) FROM " . __IPT_TABLE . " WHERE `date_time` BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tv,
	(SELECT COUNT(DISTINCT `ip_address`) FROM " . __IPT_TABLE . " WHERE `date_time` BETWEEN  '$today 00:00:00' AND '$today 23:59:59') tuv,
	(SELECT COUNT(*) FROM " . __IPT_TABLE . " WHERE `date_time` BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yv,
	(SELECT COUNT(DISTINCT `ip_address`) FROM " . __IPT_TABLE . " WHERE `date_time` BETWEEN  '$yesterday 00:00:00' AND '$yesterday 23:59:59') yuv;
	");
			$this->countDataIPT = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);

		}


	}
	
	

	public function _zeroFill($a, $b){
		$z = hexdec(80000000);
		if ($z & $a){
			$a = ($a>>1);
			$a &= (~$z);
			$a |= 0x40000000;
			$a = ($a>>($b-1));
		}else
		$a = ($a>>$b);
		return $a;
	}

	public function _mix($a,$b,$c){
		$a -= $b; $a -= $c; $a ^= ($this->_zeroFill($c,13));
		$b -= $c; $b -= $a; $b ^= ($a<<8);
		$c -= $a; $c -= $b; $c ^= ($this->_zeroFill($b,13));
		$a -= $b; $a -= $c; $a ^= ($this->_zeroFill($c,12));
		$b -= $c; $b -= $a; $b ^= ($a<<16);
		$c -= $a; $c -= $b; $c ^= ($this->_zeroFill($b,5));
		$a -= $b; $a -= $c; $a ^= ($this->_zeroFill($c,3));
		$b -= $c; $b -= $a; $b ^= ($a<<10);
		$c -= $a; $c -= $b; $c ^= ($this->_zeroFill($b,15));
		return array($a,$b,$c);
	}

	public function _GoogleCH($url, $length=null, $init=GOOGLE_MAGIC){
		if(is_null($length))
		$length = sizeof($url);
		$a = $b = 0x9E3779B9;
		$c = $init;
		$k = 0;
		$len = $length;
		while($len >= 12){
			$a += ($url[$k + 0] + ($url[$k + 1] << 8) + ($url[$k + 2] << 16) + ($url[$k + 3] << 24));
			$b += ($url[$k + 4] + ($url[$k + 5] << 8) + ($url[$k + 6] << 16) + ($url[$k + 7] << 24));
			$c += ($url[$k + 8] + ($url[$k + 9] << 8) + ($url[$k + 10] << 16) + ($url[$k + 11] << 24));
			$_mix = $this->_mix($a,$b,$c);
			$a = $_mix[0]; $b = $_mix[1]; $c = $_mix[2];
			$k += 12;
			$len -= 12;
		}
		$c += $length;
		switch($len){
			case 11: $c += ($url[$k + 10] << 24);
			case 10: $c += ($url[$k + 9] << 16);
			case 9 : $c += ($url[$k + 8] << 8);
			case 8 : $b += ($url[$k + 7] << 24);
			case 7 : $b += ($url[$k + 6] << 16);
			case 6 : $b += ($url[$k + 5] << 8);
			case 5 : $b += ($url[$k + 4]);
			case 4 : $a += ($url[$k + 3] << 24);
			case 3 : $a += ($url[$k + 2] << 16);
			case 2 : $a += ($url[$k + 1] << 8);
			case 1 : $a += ($url[$k + 0]);
		}
		$_mix = $this->_mix($a,$b,$c);
		return $_mix[2];
	}

	public function _strord($string){
		for($i = 0;$i < strlen($string);$i++)
		$result[$i] = ord($string{$i});
		return $result;
	}

	public function getPageRank($url){
		$pagerank = -1;
		$ch = "6".$this->_GoogleCH($this->_strord("info:" . $url));
		$fp = fsockopen("www.google.com", 80, $errno, $errstr, 30);
		if($fp){
			$out = "GET /search?client=navclient-auto&ch=" . $ch . "&features=Rank&q=info:" . $url . " HTTP/1.1\r\n";
			$out .= "Host: www.google.com\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fwrite($fp, $out);
			while (!feof($fp)){
				$data = fgets($fp, 128);
				$pos = strpos($data, "Rank_");
				if($pos === false){
				}else
				$pagerank = substr($data, $pos + 9);
			}
			fclose($fp);
		}
		return $pagerank;
	}

	public function alexaRank($domain){
		$remote_url = 'http://data.alexa.com/data?cli=10&dat=snbamz&url='.trim($domain);
		$search_for = '<POPULARITY URL';
		if ($handle = @fopen($remote_url, "r")) {
			while (!feof($handle)) {
				$part .= fread($handle, 100);
				$pos = strpos($part, $search_for);
				if ($pos === false)
				continue;
				else
				break;
			}
			$part .= fread($handle, 100);
			fclose($handle);
		}
		$str = explode($search_for, $part);
		$str = array_shift(explode('"/>', $str[1]));
		$str = explode('TEXT="', $str);

		return $str[1];
	}

	public function FilterThisStat($value){
		global $currentlang;
		$value = sql_quote($value);
		if (!empty($value)) {
			if ($currentlang=="persian" AND _numbers_format_Lng == "FA") {
				return Convertnumber2farsi(number_format($value));
			}				
			else {
				return number_format($value);
			}
		}else {
			return 0;
		}
	}

	public function GetOnlineList($gorm,$max_display,$max_session_mins){
			
		global $db,$prefix;
		if (file_exists("includes/geoip.inc")) {
			include_once("includes/geoip.inc");
			$gi = geoip_open("includes/GeoIP.dat",GEOIP_STANDARD);
			define("ACTIVATE_GEOIP",1);
		}

		$show_guest_list = true;
		// show whos online
		$members = '';
		$guests = '';
		$m = $g = 0;
		$max_display = ($max_display==0) ? 100 : $max_display;
		$max_session_mins = ($max_session_mins==0) ? 1 : $max_session_mins;
		if (!defined('_IB_VIEW_PROFILE')) define('_IB_VIEW_PROFILE', 'مشاهده مشخصات');

		$result = $db->sql_query("SELECT DISTINCT s.session_user_id, s.session_ip,u.username,u.user_id,g.color
	FROM ". $prefix ."_session AS s
  	left join ". $prefix ."_users AS u ON u.user_id = s.session_user_id
  	left join ". $prefix ."_groups AS g ON u.user_group_cp = g.id
  	WHERE s.session_time  > '".( time() - ($max_session_mins * 60) )."' 
  	ORDER BY s.session_user_id,s.session_time DESC");

 
		while( $row = $db->sql_fetchrow($result) )
		{

			if (ACTIVATE_GEOIP==1) {

				$country_code = geoip_country_code_by_addr($gi, $row['session_ip']);
				$country_code = (empty($country_code) ? "00" : (!file_exists("images/Guardian/countries/".strtolower($country_code).".png")) ? "00" : $country_code);
				$country_name = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);

			}else {
				$country_code ='01';
				$country_name ='Unknown';
			}
			
			if ($row['session_user_id'] != "0")
			{
				$m++;
				if ($m <= $max_display)
				{
					$members .= '
      <img src="images/Guardian/countries/'.strtolower($country_code).'.png" alt="'.$country_name.'">
      <a style="color:'.$row[color].'" href="modules.php?app=mod&name=navigation&amp;op=Account&value='.$row['session_user_id'].'" class="colorbox" title="'._IB_VIEW_PROFILE.': '.$row['username'].'"><b>'.$row['username'].'</b></a><br>
      ';
				}
			}
			else
			{
				$g++;
				if ($show_guest_list && $g <= $max_display)
				{
					if (is_admin($admin))
					{
						$uname = $row['session_ip'];
					}
					else
					{
						$ip = explode('.', $row['session_ip']);
						$gip = $ip[0].'.'.$ip[1].'.'.str_replace($ip[2],"x",$ip[2]).'.'.str_replace($ip[3],"x",$ip[3]);
					}
					$guests .= '<li style="direction:ltr;text-align:left;"><img src="images/Guardian/countries/'.strtolower($country_code).'.png"  alt="'.$country_name.'"> '.$gip.' </li>
      ';
				}
			}
		}


		$db->sql_freeresult($result);

		if ($gorm == 'm') {

			if ($m > 0)
			{
				$content .= ''.$members.'';
			}

		}elseif ($gorm == 'g'){

			if ($g > 0)
			{
				$content .= ''.$guests.'';
			}
		}else {
			$content .="";
		}

		return $content;
		
		geoip_close($gi);

	}

	public function GetLatestUsers($num2count){

		global $db;
		$num2count = sql_quote($num2count);
		$lISTusers = '';
		$result_LU = $db->sql_query("SELECT user_id,username FROM ".NK_USERS_TABLE." WHERE user_active  > 0 ORDER BY user_id DESC LIMIT 0,$num2count");
		while( $row = $db->sql_fetchrow($result_LU) )
		{
			$lISTusers .= '
      <div style="padding-left: 12px;">
      <img src="images/icon/user.png" alt="'._IB_VIEW_PROFILE.'">
      <a href="modules.php?app=mod&name=navigation&amp;op=Account&value='.$row['user_id'].'" class="colorbox" title="'._IB_VIEW_PROFILE.': '.$row['username'].'">'.$row['username'].'</a>
      </div>
      ';
		}
		$db->sql_freeresult($result_LU);

		return $lISTusers;

	}

}
?>