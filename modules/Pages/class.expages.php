<?php
/**
*
* @package Class For Extra Page														
* @version $Id: class.expages.php 12:43 PM 3/5/2010 Aneeshtan $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/
require_once("mainfile.php");
if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal , So why don't You join us<br>http://www.nukelearn.com");}
define("XPAGE_TABLE","".$prefix."_extpages");

class expage {
	
    /**
     * validate_page
     *
     * @param int $pid the pid is an id for our pages in the database table
     * @access public
     * @return string validate this page
     */
    
	var $data = array();
	var $term = '';
	
	
	public function validate_page($pid,$slug){

		global $prefix, $db,$user,$admin;
		define("XPAGE_TABLE","".$prefix."_extpages");
		
		if (empty($pid) AND empty($slug) ) {
		return show_error("PAGE YOU ARE REFERING IS TOTALY WRONG<br>EMPTY");
		}
	
		$sql= $db->sql_query("SELECT * FROM ".XPAGE_TABLE." WHERE pid='$pid' OR slug='".Slugit($slug)."'");
		
		$res = $db->sql_numrows($sql);
		if (empty($res)) {
		return show_error("صفحه مورد نظر موجود نیست <br><b>$slug</b>");
		}
		return ;
	}
		
	public function create_page(){
	global $pagetitle,$db,$prefix,$user,$admin;
	define("XPAGE_TABLE","".$prefix."_extpages");
	$this->term = sql_quote($_GET['term']);
	
	list($int_page) = $db->sql_fetchrow($db->sql_query("SELECT `pid` FROM ".XPAGE_TABLE." where `slug`='$this->term' LIMIT 1"));
	if (empty($int_page)) {
	list($int_page) = $db->sql_fetchrow($db->sql_query("SELECT `pid` FROM ".XPAGE_TABLE." where `slug`='".Slugit($this->term)."' LIMIT 1"));
			if (empty($int_page)) {
			list($int_page) = $db->sql_fetchrow($db->sql_query("SELECT `pid` FROM ".XPAGE_TABLE." where `pid`='$this->term' LIMIT 1"));
			}
			if (empty($int_page)) {
			list($int_page) = $db->sql_fetchrow($db->sql_query("SELECT `pid` FROM ".XPAGE_TABLE." where `pid`='".sql_quote($_GET['pid'])."' LIMIT 1"));
			}
			if (empty($int_page)) {
				show_error(_NO_RECORD_FOUND);
			}
	}
	

	//$this->validate_page($this->pid,$this->slug);
	
	$sql= $db->sql_query("SELECT * FROM ".XPAGE_TABLE." WHERE `pid`='$int_page'");
	
	$this->data = $db->sql_fetchrow($sql);
	$this->pid = empty($this->pid) ? $this->data['pid'] : $this->pid;
	$mytitle = stripslashes($this->data['title']);
	$slug = stripslashes($this->data['slug']);
	$pagetitle = "- صفحه $mytitle";
	$mytext = stripslashes($this->data['text']);
	$mycounter = intval($this->data['counter']);
	$myepk = intval($this->data['perm']);
	$nav = intval($this->data['nav']);
	$post_time = intval($this->data['post_time']);
	$f=true;

	if ($nav == 0) {

	list($prepage,$pretitle) = $db->sql_fetchrow($db->sql_query("SELECT `pid`,`title` FROM ".XPAGE_TABLE." WHERE `pid`<'$int_page' LIMIT 1"));
	list($nextpage,$nexttitle) = $db->sql_fetchrow($db->sql_query("SELECT `pid`,`title` FROM ".XPAGE_TABLE." WHERE `pid`>'$int_page' LIMIT 1"));
		
		if (!empty($prepage)) {
		$navs .= "<a href='modules.php?name=Pages&pid=".$prepage."'>
		<b></b>&nbsp;$pretitle</a>&nbsp;&nbsp;<img src='images/icon/arrow_right.png'>";
		}	

		$navs.= "<a href='modules.php?name=Pages&pid=".$int_page."'>&nbsp;$mytitle&nbsp;</a>&nbsp;&nbsp;";
		
		if (!empty($nextpage)) {
			$navs.= "<a href='modules.php?name=Pages&pid=".$nextpage."'>
		&nbsp;$nexttitle</a>&nbsp;&nbsp;<img src='images/icon/arrow_left.png'>";
		}

	}
	$pagetitle = $this->data['title'];
	
	if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal , So why don't You join us<br>http://www.nukelearn.com");}
	

	if ($myepk == 1 && !is_user($user)) {
		$st = "<center><p><b>:: اطلاعات ::</b></p><p><font color=\"red\">این صفحه فقط برای اعضای سایت قابل مشاهده است</font></p>";
		$st.= " <a href=\"modules.php?app=mod&amp;name=navigation&amp;op=login\" class=\"colorbox\" title=\"\">"._LOGIN."</a>&nbsp;&nbsp;<a href=\"modules.php?name=Your_Account&amp;op=new_user\">"._BREG."</a>";
		$f= false;
	}

	if ($myepk == 2 && (!is_admin($admin))) {
		$st = "<center><p><b>:: اطلاعات ::</b></p><p><font color=\"red\">این صفحه فقط برای مدير سایت قابل مشاهده است</font></p>";
		$st .= "[ <a href=\"".ADMIN_PHP."\">ورود</a> ] ";
		$f= false;
	}

	if ($myepk == 3 && is_user($user)){
		$st = "شما عضو سايت هستيد اين صفحه مختص كاربران غير عضو مي باشد.";
		$f= false;
	}

	if ($myepk == 4 && (!is_group($user,$name))) {
		$st = "<center><p><b>:: اطلاعات ::</b></p><p><font color=\"red\">این صفحه فقط برای اعضای رسمی سایت قابل مشاهده است</font></p>";
		$st .= "[ <a href=\"$admin_file.php\">ورود</a> ] ";
		$f= false;
	}
	if ($f) {
		$db->sql_query("UPDATE `".$prefix."_extpages` SET `counter`=counter+1 where `pid`='$this->pid'")or mysql_error();
		echo "<h3>$mytitle</h3><p>$mytext</p>";
		echo "<div align='right'>$navs </div><p><img src='images/icon/note.png' alt='hits' title='"._VISIT."'><b>$mycounter</b>"._VISIT."</p>";
	}else{
		title($st);
	}

	
	

	}

	public function Page_Directory($limit,$orderby,$condition=''){
		global $pagetitle,$db,$prefix,$user,$admin;
		define("XPAGE_TABLE","".$prefix."_extpages");
		require("header.php");
		OpenTable();
		if (empty($_GET[term]) AND empty($_GET[pid]) ) {
		echo "<h3>"._RSS_EXTRAPAGE."</h3>
		<ol>";
	$resql = $db->sql_query("SELECT * from  ".XPAGE_TABLE." $condition $orderby limit $limit");
			while ($row = $db->sql_fetchrow($resql)) {
				$pid = $row['pid'];
				$title = $row['title'];
				$slug = $row['slug'];
				$counter = $row['counter'];
				$epk = $row['perm'];
				$active = $row['active'];
				$nav = $row['nav'];
				$post_time =  hejridate($row['post_time'], 4, 4);
				
			echo "<li><a href='modules.php?name=Pages&term=".$slug."'>$title</a>  ($post_time) ( <b>$counter</b> "._VISIT.")</li>";			
		}
		echo "</ol>";
		echo "<p><a href='feed.php?mod=Pages&type=rss2'><img src='images/icon/rss.png' alt='feed' title='"._RSS."'>RSS "._RSS."</a> |  ";
		echo "<a href='feed.php?mod=Pages&type=atom'><img src='images/icon/rss.png' alt='feed' title='"._RSS."'>ATOM "._RSS."</a></p>";
		
		}else {
			$this->create_page();
		}
		CloseTable();
		include("footer.php");

		
		
	}
	
/*----------NEXT Version

public function nav($pid){
		
	}
	public function create_page($pid){
		
	}
----------NEXT Version*/


}


?>