<?php
/**
*
* @package Extra Page														
* @version $Id: page.php 12:43 PM 3/5/2010 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined("ADMIN_FILE")) {
	show_error(HACKING_ATTEMPT);
}
global $prefix, $db,$admin, $admin_file;
$module_name = basename(dirname(dirname(__FILE__)));
$aid = substr("$aid", 0,25);
if (is_superadmin($admin) OR is_admin_of($module_name,$admin)) {
	define("BASE_URL",'http://'. $_SERVER['HTTP_HOST'].rtrim((string)dirname($_SERVER['SCRIPT_NAME']), '/\\').'/') ;
	if (!defined("USV_VERSION")) {
		die("This only works on MarlikCMS Portal , So why don't You join us<br>http://www.MarlikCMS.com");
	}
	addCSSToHead("modules/Pages/admin/includes/css/pages.css",'file');
	addJSToBody('
<!-- extra-page-script -->
<script type="text/javascript">
$(document).ready(function(){$(".jqdelete").live("click",function(b){b.preventDefault();var a=$(this).parents("tr.box");if(confirm("از حذف این رکورد اطمینان دارید ؟")){$.ajax({type:"get",url:"'.ADMIN_OP.'quick_delete",data:"pid="+a.attr("id").replace("record-",""),beforeSend:function(){$("#list_pages").html("<img src=\'images/loading.gif\' />");},success:function(c){$("#list_pages").html(c);}});}});$(".jqactive").live("click",function(b){b.preventDefault();var a=$(this).parents("tr.box");if(confirm("از فعال سازی این رکورد اطیمنان دارید؟")){$.ajax({type:"get",url:"'.ADMIN_OP.'change_status",data:"pid="+a.attr("id").replace("record-",""),beforeSend:function(){$("#list_pages").html("<img src=\'images/loading.gif\' />");},success:function(c){$("#list_pages").html(c);}});}});$(".word").keyup(function(){var b=$(this).val();var a=$("#plink");a.val(b);$.post("'.ADMIN_OP.'ep_slug_title"+"&title="+b,function(c){$("#eplink").html(c).fadeIn("slow");});return false;});});</script>'."\n",'inline');
	function exmenu() {
		global $admin_file;
		OpenTable();
		echo "<h3>"._EP_ADMIN."</h3>
	<div style='width:98%;margin:auto;text-align:center;'>
	<a href=\"".$admin_file.".php?op=add_extpage\"  class='button'  style='padding:10px;position:relative;clear:both;'>"._EP_ADD."</a>
	<a href=\"".$admin_file.".php?op=extpage\" class='button' style='padding:10px;position:relative;clear:both;'>"._EP_ADDEDPAGES."</a>
	</div>";
		CloseTable();
	}
	function extpage() {
		global $admin,$prefix,$pagenum, $db,$admin_file;
		if (!isset($pagenum)) $pagenum=1;
		include("header.php");
		GraphicAdmin();
		exmenu();
		OpenTable();
		$num = $db->sql_numrows($db->sql_query("SELECT pid FROM ".$prefix."_extpages"));
		if ($num > 0) {
			echo "<div id='list_pages'>
			<center><b>"._EP_ADDEDPAGES."</b><br><br>	
			<h3>"._EP_ADMIN." </h3>";
			list_expages(10,'pid','');
			echo "</div>";
		} else {
			echo "صفحه ای برای نمایش وجود ندارد.";
		}
		CloseTable();
		include("footer.php");
	}
	function list_expages($exnum,$orderby,$condition) {
		global $admin,$prefix,$pagenum, $db,$admin_file;
		if (!isset($pagenum)) $pagenum=1;
		echo "<form action=\"\" method=\"POST\">
		 <table  class=\"widefat comments fixed\" ><thead>
		     <tr>
		      	<th>"._SELECT."</th>
			    <th>"._TITLE."</th>
			    <th>"._PERMISSIONS."</th>
			   <th>"._ADDRESS."</th>
			    <th>"._FUNCTIONS."</th>
			   <th>"._HITS."</th>
			 </tr></thead>";
		$exnum = (!empty($exnum)) ? $exnum : 10 ;
		$orderby= (!empty($orderby)) ? $orderby : 'pid' ;
		$condition= (!empty($condition)) ? $condition : ' ' ;
		$start_page=($pagenum-1)*$exnum;
		$resql = $db->sql_query("SELECT * from ". $prefix ."_extpages $condition ORDER BY $orderby DESC limit $start_page,$exnum");
		while ($row = $db->sql_fetchrow($resql)) {
			$pid = $row['pid'];
			$title = $row['title'];
			$slug = $row['slug'];
			$counter = $row['counter'];
			$epk = $row['perm'];
			$active = $row['active'];
			$nav = $row['nav'];
			$pages = $db->sql_numrows($resql);
			if ($epk==0) {
				$eki=""._ALL."";
			} elseif ($epk==1) {
				$eki=""._USERS."";
			} elseif ($epk==2) {
				$eki =""._ADMINS."";
			} elseif ($epk==3) {
				$eki =""._EP_GUESTS."";
			} elseif ($epk==4) {
				$eki =""._SUBSCRIBEDUSERS."";
			}
			$status_link = $active==1 ? "active.gif" : "inactive.gif";
			echo "<tr class='box' id='record-$pid'>
		  	   <td ><input type=\"checkbox\" name=\"".$row[pid]."\" id=\"".$row[pid]."\" value=\"".$row[pid]."\" /></td>
				   <td> <a href=\"".$admin_file.".php?op=edit_ep&pid=$pid\">$title</a></td>
				   <td >$eki </td>
				   <td><p ><a href=\"modules.php?name=Pages&pid=$pid\"><img src='images/icon/world_link.png' alt='"._UURL."' title='"._UURL."'></a>
				   &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"page/$slug\"><img src='images/icon/ruby_link.png' alt='page/$slug' title='page/$slug'>‌‌‍</a>
				   &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"page/$pid\"><img src='images/icon/brick_link.png' alt='page/$pid' title='page/$pid'>‌‌‍</a>
				   </td>
				   <td><a href='javascript:void(0)' class='jqdelete'><img src=\"images/delete.gif\" alt=\""._DELETE."\" title=\""._DELETE."\" border=\"0\" width=\"17\" height=\"17\"></a>
				      <a   href=\"".$admin_file.".php?op=edit_ep&pid=$pid\" ><img src=\"images/edit.gif\" alt=\""._EDIT."\" title=\""._EDIT."\" border=\"0\" width=\"17\" height=\"17\"></a>
					<span class='status_link'><a href='javascript:void(0)' class='jqactive'><img src='images/$status_link' id='$active'></a></span>
				      </td>
    			   <td><p >$counter</p></td>
  			   </tr>";
		}
		echo "</table><br><p align=\"right\"><input  type=\"submit\" name=\"perform\" id=\"perform\"  value=\""._DELETESELECTED."\"></form>";
		$sql_pn = "select * from ".$prefix."_extpages ";
		$result_pn = $db->sql_query($sql_pn);
		$totalnum = $db->sql_numrows($result_pn);
		$numpages = ceil($totalnum / $exnum);
		if ($numpages> 1) {
			echo "<center> "._TOTALPAGES."  :<font color=\"red\">$totalnum</font>(&nbsp;&nbsp;صفحه $pagenum  | "._EACHPAGE."$exnum)<br>";
			if ($pagenum > 1) {
				$prevpage = $pagenum - 1 ;
				$leftarrow = "images/right.gif" ;
				if(isset($new_topic)) {
					echo "<a href=\"".$admin_file.".php?op=extpage&&new_topic=$new_topic&pagenum=$prevpage\">";
					echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				} else {
					echo "<a href=\"".$admin_file.".php?op=extpage&pagenum=$prevpage\">";
					echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				}
			}
			echo "[ " ;
			for ($i=1; $i < $numpages+1; $i++) {
				if ($i == $pagenum) {
					echo "<b>$i</b>";
				} else {
					if(isset($new_topic)) {
						echo "<a href=\"".$admin_file.".php?op=extpage&new_topic=$new_topic&pagenum=$i\">$i</a>";
					} else {
						echo "<a href=\"".$admin_file.".php?op=extpage&pagenum=$i\">$i</a>";
					}
				}
				if ($i < $numpages) {
					echo " | ";
				} else {
					echo " ]";
				}
			}
			if ($pagenum < $numpages) {
				$nextpage = $pagenum + 1 ;
				$rightarrow = "images/left.gif" ;
				if(isset($new_topic)) {
					echo "<a href=\"".$admin_file.".php?op=extpage&&new_topic=$new_topic&pagenum=$nextpage\">";
					echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				} else {
					echo "<a href=\"".$admin_file.".php?op=extpage&&pagenum=$nextpage\">";
					echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				}
			}
			echo "</center>" ;
		}
		if($_POST['perform']) {
			foreach($_POST as $id) {
				$sql = $db->sql_query("DELETE FROM ". $prefix ."_extpages WHERE pid='$id' LIMIT 1");
				// Change yourtable and id. This deletes the record from the database
			}
		}
	}
	function change_status() {
		global $db,$prefix;
		if(isset($_GET['pid'])) {
			list($active) =  $db->sql_fetchrow($db->sql_query("select active from ".$prefix."_extpages where pid='".sql_quote($_GET['pid'])."'"));
			$status = $active==1 ? 0  : 1;
			$status_link = $active==1 ? "inactive.gif" : "active.gif";
			$sql= $db->sql_query("UPDATE ".$prefix."_extpages SET active='$status' WHERE pid='".sql_quote($_GET['pid'])."' limit 1")or die(mysql_error());
			if (!$sql) {
				list_expages(10,'pid','');
				die("<div class='error'>اشکالی در دیتابیس بوجود آمده است ! </div>");
			}
			echo "<div class='success'>با موفقیت اعمال شد..</div>";
			list_expages(10,'pid','');
		} else {
			list_expages(10,'pid','');
			die("<div class='error'>شناسه صحیح نمی باشد.</div>");
		}
	}
	function quick_delete() {
		global $prefix,$db;
		if(isset($_GET['pid'])) {
			$resql = $db->sql_query("delete from " . $prefix . "_extpages where pid='".sql_quote($_GET['pid'])."'");
			if (!$resql) {
				list_expages(10,'pid','');
				die("<div class='error'>اشکالی در دیتابیس بوجود آمده است ! </div>");
			}
			echo "<div class='success'>با موفقیت اعمال شد..</div>";
			list_expages(10,'pid','');
		} else {
			list_expages(10,'pid','');
			die("<div class='error'>شناسه صحیح نمی باشد.</div>");
		}
	}
	function quick_edit() {
		global $prefix,$db;
		if(isset($_GET['pid'])) {
			$pid = $_GET['pid'];
			$resql = $db->sql_query("SELECT * from " . $prefix . "_extpages where pid='$pid'");
			$row = $db->sql_fetchrow($resql);
			$title = sql_quote($row['title']);
			$slug = sql_quote($row['slug']);
			$text = $row['text'];
			$epk = sql_quote($row['active']);
			$nav = sql_quote($row['nav']);
			OpenTable();
			echo "<form action=\"".$admin_file.".php\" method=\"POST\">
  	<p>» "._TITLE.": <input type=\"text\" id=\"title\" name=\"title\"  class='word' size=\"50\" dir=\"rtl\" maxlength=\"255\"  value=\"$title\" > </p>";
			echo'<p>'._SLUG.' :
<span dir="ltr" style="direction:ltr;font-weight:bold;font-size:15px;">'.BASE_URL.'<input type="text" name="slug" id="slug"  class="word" style="direction:ltr;font-weight:bold;font-size:15px;" value="'.$slug.'"></span>
</p>';
			//wysiwyg_textarea('epcnt', "$text", 'PHPNukeAdmin', 50, 12);
			echo"<p>"._EP_NAVIGATION." "._YES."<input type=\"radio\" name=\"nav\" value=\"0\" > &nbsp;&nbsp;"._NO."<input type=\"radio\" name=\"nav\" value=\"1\"checked></p>";
			echo"<p>"._ACTIVATE2."<input type=\"radio\" name=\"active\" value=\"1\" checked > &nbsp;&nbsp;"._YES."<br>
			<input type=\"radio\" name=\"active\" value=\"0\"checked>"._NO."</p>";
			echo "<p>»"._VIEW." <select name=\"epk\" dir=\"rtl\"><option selected value=\"0\">"._ALL."</option><option value=\"1\">"._USERS."</option><option value=\"2\">"._ADMINS."</option><option value=\"3\">"._EP_GUESTS."</option><option value=\"4\">"._SUBSCRIBEDUSERS."</option></select></p>
  		  <p><input type=\"hidden\" name=\"pid\" value=\"$pid\"><input type=\"hidden\" name=\"op\" value=\"sedit_ep\"><input type=\"reset\" value=\""._CLEAR."\"><input type=\"submit\" value=\""._EDIT."\"></p></form>";
		} else {
			die("no id recieved");
		}
	}
	function add_extpage() {
		global $admin,$prefix, $db,$admin_file;
		addCSSToHead("modules/Pages/admin/includes/css/pages.css",'file');
		addJSToBody('
<!-- extra-page-script -->
<script type="text/javascript">
$(document).ready(function(){$(".jqdelete").live("click",function(b){b.preventDefault();var a=$(this).parents("tr.box");if(confirm("از حذف این رکورد اطمینان دارید ؟")){$.ajax({type:"get",url:"'.ADMIN_OP.'quick_delete",data:"pid="+a.attr("id").replace("record-",""),beforeSend:function(){$("#list_pages").html("<img src=\'images/loading.gif\' />");},success:function(c){$("#list_pages").html(c);}});}});$(".jqactive").live("click",function(b){b.preventDefault();var a=$(this).parents("tr.box");if(confirm("از فعال سازی این رکورد اطیمنان دارید؟")){$.ajax({type:"get",url:"'.ADMIN_OP.'change_status",data:"pid="+a.attr("id").replace("record-",""),beforeSend:function(){$("#list_pages").html("<img src=\'images/loading.gif\' />");},success:function(c){$("#list_pages").html(c);}});}});$(".word").keyup(function(){var b=$(this).val();var a=$("#plink");a.val(b);$.post("'.ADMIN_OP.'ep_slug_title"+"&title="+b,function(c){$("#eplink").html(c).fadeIn("slow");});return false;});});</script>'."\n",'inline');
		include("header.php");
		GraphicAdmin();
		exmenu();
		OpenTable();
		echo "<center><b> "._EP_ADD." </b></center><br>";
		echo "<form action=\"".$admin_file.".php\" method=\"POST\">
  	 <p>»  "._TITLE." : <input type=\"text\" id=\"title\" name=\"title\"  class='word' size=\"50\" dir=\"rtl\" maxlength=\"255\"> </p>"
				.'<p>'._SLUG.':
<span dir="ltr" style="direction:ltr;font-weight:bold;font-size:15px;">'.BASE_URL.'page/<span id="eplink" name="f" style="direction:ltr;font-weight:bold;font-size:15px;color:#ff0000" ></span>
<input type="text" name="plink" id="plink"  class="word" style="direction:ltr;font-weight:bold;font-size:15px;"></span>
</p>'
				."<p>»  "._VIEW."  <select name=\"epk\" dir=\"rtl\"><option selected value=\"0\"> "._ALL." </option><option value=\"1\"> "._USERS." </option><option value=\"2\"> "._ADMINS." </option><option value=\"3\"> "._EP_GUESTS." </option><option value=\"4\"> "._SUBSCRIBEDUSERS." </option></select></p>
	<p>
	<input type=\"hidden\" name=\"op\" value=\"add_ep\">";
		wysiwyg_textarea('epcnt', '', 'PHPNukeAdmin', 50, 12);
		echo"<p>"._EP_NAVIGATION." "._YES."<input type=\"radio\" name=\"nav\" value=\"0\" > &nbsp;&nbsp;"._NO."<input type=\"radio\" name=\"nav\" value=\"1\"checked></p>";
		echo "<P><input type=\"submit\" value=\""._ADD."\"><input type=\"reset\" value=\""._CLEAR."\"></p></form>";
		CloseTable();
		include("footer.php");
	}
	function ep_slug_title() {
		$title = $_GET['title'];
		$title = sql_quote($title);
		if (!empty($title)) {
			print  Deslug($title);
		} else {
			return false;
		}
	}
	function add_ep($title, $plink , $epcnt, $epk,$nav) {
		global $admin,$prefix, $db,$admin_file;
		include("header.php");
		GraphicAdmin();
		OpenTable();
		$title = sql_quote($title);
		$plink = sql_quote(Slugit($plink));
		$epcnt = sql_quote($epcnt);
		$epk = sql_quote(intval($epk));
		$nav = sql_quote(intval($nav));
		$resql = $db->sql_query("insert into  " . $prefix . "_extpages values ('', '$title','$plink','$epcnt',0,$epk,$nav,now(),1)");
		if (!$resql) {
			echo "<center><b>"._WARNING."</b><p>"._ERROR_ADDING."</p><p>[ <a href=\"".$admin_file.".php?op=extpage\">"._BACK."</a> ]</p></center>";
			CloseTable();
		} else {
			$resql2 = $db->sql_query("SELECT pid, title from " . $prefix . "_extpages where title='$title'");
			$row = $db->sql_fetchrow($resql2);
			$pid = $row['pid'];
			echo "<center><p><b></b></p><p>"._EP_PAGENAME."<b>$title</b> "._ADDEDTO."<br>
		<p>[<a href=\"".$admin_file.".php?op=extpage\"> "._BACK2ADMIN." ]</p><p>[<a href=\"".$admin_file.".php?op=add_extpage\"> "._ADDNEWPAGE."]</p></center>";
			CloseTable();
		}
		include("footer.php");
	}
	function del_ep($pid,$ok) {
		global $admin,$prefix, $db,$admin_file;
		include("header.php");
		if ($ok == 0) {
			OpenTable();
			echo "<center><p><b>"._WARNING."</b></p><p>"._DELETEQUEST."</p><p>[<a href=\"".$admin_file.".php?op=del_ep&pid=$pid&ok=1\"><font color=\"red\">"._YES." </font></a>] [<a href=\"".$admin_file.".php?op=extpage\">"._NO." </a>]</p>";
			CloseTable();
			@include("footer.php");
		}
		if ($ok == 1) {
			$resql = $db->sql_query("delete from " . $prefix . "_extpages where pid='$pid'");
			OpenTable();
			if (!$resql) {
				echo "<center><p><b>"._WARNING."</b></p><p>"._DELETENOTPOSSIBLE."!</p><p>[<a href=\"".$admin_file.".php?op=extpage\"> "._BACK2ADMIN." ]</p></center>";
				CloseTable();
				die();
			} else {
				echo "<center><p><b></b></p><p>"._DELETESUCCESS."</p><p>[<a href=\"".$admin_file.".php?op=extpage\">"._BACK2ADMIN." ]</p></center>";
			}
			CloseTable();
			include("footer.php");
		}
		if (!$ok==0 or !$ok==1) {
			OpenTable();
			echo "<center><p><b>"._WARNING."</b><br><br>"._INCORRECTENTRY."!<br></p>";
			CloseTable();
			die();
		}
	}
	function edit_ep($pid) {
		global $admin, $prefix, $db,$admin_file;
		include("header.php");
		GraphicAdmin();
		exmenu();
		$resql = $db->sql_query("SELECT * from " . $prefix . "_extpages where pid='$pid'");
		$row = $db->sql_fetchrow($resql);
		$title = sql_quote($row['title']);
		$slug = sql_quote($row['slug']);
		$text = $row['text'];
		$epk = sql_quote($row['active']);
		$nav = sql_quote($row['nav']);
		OpenTable();
		echo "<form action=\"".$admin_file.".php\" method=\"POST\">
  	<p>»"._TITLE." <input type=\"text\" id=\"title\" name=\"title\"  class='word' size=\"50\" dir=\"rtl\" maxlength=\"255\"  value=\"$title\" > </p>";
		echo'<p>'._SLUG.' :
<span dir="ltr" style="direction:ltr;font-weight:bold;font-size:15px;">'.BASE_URL.'<input type="text" name="slug" id="slug"  class="word" style="direction:ltr;font-weight:bold;font-size:15px;" value="'.$slug.'"></span>
</p>';
		wysiwyg_textarea('epcnt', "$text", 'PHPNukeAdmin', 50, 12);
		echo"<p>"._EP_NAVIGATION." "._YES."<input type=\"radio\" name=\"nav\" value=\"0\" > &nbsp;&nbsp;"._NO."<input type=\"radio\" name=\"nav\" value=\"1\"checked></p>";
		echo"<p>"._ACTIVATE2."<br>
		<input type=\"radio\" name=\"active\" value=\"1\" ".($epk==1 ? "checked" : "")." >"._YES."<br>
		<input type=\"radio\" name=\"active\" value=\"0\" ".($epk==0 ? "checked" : "")." >"._NO."</p>";
		echo "<p>»"._VIEW." <select name=\"epk\" dir=\"rtl\">
		<option value=\"0\" ".($row['perm']==0 ? "selected" : "").">"._ALL."</option>
		<option value=\"1\" ".($row['perm']==1 ? "selected" : "").">"._USERS."</option>
		<option value=\"2\" ".($row['perm']==2 ? "selected" : "").">"._ADMINS."</option>
		<option value=\"3\" ".($row['perm']==3 ? "selected" : "").">"._EP_GUESTS."</option>
		<option value=\"4\" ".($row['perm']==4 ? "selected" : "").">"._SUBSCRIBEDUSERS."</option></select></p>		
  		  <p><input type=\"hidden\" name=\"pid\" value=\"$pid\"><input type=\"hidden\" name=\"op\" value=\"sedit_ep\"><input type=\"reset\" value=\""._CLEAR."\"><input type=\"submit\" value=\""._EDIT."\"></p></form>";
		CloseTable();
		OpenTable();
		echo " <a href=\"".$admin_file.".php?op=extpage\"> "._BACK2ADMIN."</a>";
		CloseTable();
		include("footer.php");
	}
	function sedit_ep($pid,$title,$slug,$epcnt,$epk,$active,$nav) {
		global $admin,$prefix, $db,$admin_file;
		$title = sql_quote($title);
		$plink = sql_quote($plink);
		$epcnt = sql_quote($epcnt);
		$epk = sql_quote(intval($epk));
		$nav = sql_quote(intval($nav));
		$slug = Slugit($slug);
		$result = $db->sql_query("update " . $prefix . "_extpages set title='$title',slug='$slug', text='$epcnt', perm='$epk', nav='$nav', active='$active' WHERE pid='$pid'") or die(mysql_error());
		include("header.php");
		OpenTable();
		if (!$result) {
			echo "<center><p><b>"._WARNING."</b></p><p>"._EP_EDITFAILED."!</p><p><a href=\"".$admin_file.".php?op=extpage\" class='button'> "._BACK2ADMIN."</a></p></center>";
			CloseTable();
			die();
		} else {
			echo "<center><p><b></b></p><p>"._EP_EDITSUCCESS."</p><p><a href=\"".$admin_file.".php?op=extpage\" class='button'>"._BACK2ADMIN."</a></p></center>";
		}
		CloseTable();
		include("footer.php");
	}
	switch ($op) {
		default:
					extpage($new_topic="0");
		break;
		case "add_extpage":
					add_extpage();
		break;
		case "theindex":
					theindex($new_topic);
		break;
		case "add_ep":
					add_ep($title,$plink,$epcnt, $epk,$nav);
		break;
		case "del_ep":
					del_ep($pid,$ok);
		break;
		case "edit_ep":
					edit_ep($pid);
		break;
		case "sedit_ep":
					sedit_ep($pid,$title,$slug,$epcnt,$epk,$active,$nav);
		break;
		case "ep_slug_title":
					ep_slug_title();
		break;
		case "change_status":
					change_status();
		break;
		case "quick_delete":
					quick_delete();
		break;
		case "quick_edit":
					quick_edit();
		break;
	}
	
if (!defined("USV_VERSION")) {
	die(_HACKING_ATTEMPT);
}
} else {
die("Access Denied To $module_name administration");
}
?>