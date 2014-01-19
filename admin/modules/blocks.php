<?php
/**
*
* @package Tigris 1.1.4														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Nukelearn Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/

if (!preg_match("/".$admin_file.".php/", "$_SERVER[PHP_SELF]")) { die ("Access Denied"); }

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}

global $prefix, $db, $admin_file;
$aid = substr("$aid", 0,25);
$row = $db->sql_fetchrow($db->sql_query("SELECT radminsuper FROM " . $prefix . "_authors WHERE aid='$aid'"));
if ($row['radminsuper'] == 1) {


	function BlocksAdmin() {
		global $bgcolor2, $bgcolor4, $prefix, $db, $currentlang, $multilingual, $admin_file;
		include("header.php");
		GraphicAdmin();
?>
<script type="text/javascript" src="includes/javascript/jquery/src/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="includes/javascript/jquery/src/jquery.json-2.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){$(".jqdelete").click(function(b){b.preventDefault();var a=$(this).parents("div.widget");if(confirm("آیا از حذف این مورد اطمینان دارید ؟")){$.ajax({type:"get",url:"<?php echo ADMIN_OP?>bl_quick_delete",data:"bid="+a.attr("id").replace("item",""),beforeSend:function(){a.animate({backgroundColor:"#fb6c6c"},300)},success:function(){a.slideUp(300,function(){a.remove()})}})}return false});$(".jqedit").click(function(b){b.preventDefault();var a=$(this).parents("tr.box");$.ajax({type:"get",url:"<?php echo ADMIN_OP?>quick_edit",data:"pid="+a.attr("id").replace("record-",""),beforeSend:function(){a.animate({backgroundColor:"#fb6c6c"},300)},success:function(c){a.append(c)}})})});$(function(){$("div.movable").click(function(){$(this).next().slideToggle("fast")})});$(function(){$(".widget").each(function(){$(this).hover(function(){$(this).find("h4").addClass("collapse")},function(){$(this).find("h4").removeClass("collapse")}).click(function(){updateWidgetData()}).end().find(".widget-inside").css("visibility","hidden")});$(".column").sortable({connectWith:".column",handle:"h4",cursor:"move",placeholder:"placeholder",forcePlaceholderSize:true,opacity:0.4,start:function(a,b){if($.browser.mozilla||$.browser.safari){$(b.item).find(".widget-inside").toggle()}},stop:function(a,b){b.item.css({top:"0",left:"0"});if(!$.browser.mozilla&&!$.browser.safari){updateWidgetData()}}}).disableSelection()});function updateWidgetData(){var b=[];$(".widget-title").each(function(){var d=$(this).attr("id");$(".column").each(function(){var e=$(this).attr("id");$(".widget",this).each(function(f){var h=0;if($(this).find(".widget-inside").css("display")=="none"){h=1}var g={id:$(this).attr("id"),collapsed:h,order:f,column:e,weight:d};b.push(g)})})});var a={items:b};var c=new Date();$.post("<?php echo ADMIN_OP?>save_blocks_change&","data="+$.toJSON(a),function(d){$("#console").html(d);setTimeout(function(){$("#console").fadeOut(31000)},2000)})}$(document).ready(function(){$(".SaveBlock").click(function(b){b.preventDefault();var a=$(this).parents("tr.box");$.ajax({type:"get",url:"<?php echo ADMIN_OP?>Quick_SaveBlockData",data:"bid="+a.attr("id").replace("record-",""),beforeSend:function(){a.animate({backgroundColor:"#fb6c6c"},300)},success:function(){a.slideUp(300,function(){a.remove()})}})})});
</script>
<link rel='stylesheet' href="<?php echo INCLUDES_ACP ?>style/css/blocks.css">


<div id="wpwrap"> 
<div id="wpcontent">
<div id="wphead">
			<h2><?php echo _BLOCKSADMIN ?></h2>
</div> 
			<div class="widget-liquid-left">
				<div id="widgets-left">
					<div id="available-widgets" class="widgets-holder-wrap">
						<div class="sidebar-name movable">
							<div class="sidebar-name-arrow"></div>
							<h3><?php echo _ADMIN_BLOCKS_CENTER_UP ?><span id="removing-widget">
							<span></span></span></h3>
						</div>
						<div class='widgets-sortables' >
							<p class="description" ><?php echo _ADMIN_BLOCKS_CENTER_UP_DESC ?></p>
							<div>
								<div class="column" id="c"  style="width:500px">
<?php
$result = $db->sql_query("select * from ".$prefix."_blocks WHERE active='1' and  bposition='c'  order by bposition, weight");
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$title = sql_quote($row['title']);
	$weight = intval($row['weight']);
	block_this_mini($bid,$title,$weight);
}
?>
				</div>		
					</div>
						<br class='clear' /></div>
						<br class="clear" /></div>	
						<div id="available-widgets" class="widgets-holder-wrap">
						<div class="sidebar-name movable">
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?php echo _ADMIN_BLOCKS_CENTER_DOWN ?><span id="removing-widget">
							<span></span></span></h3>
						</div>
						<div  class='widgets-sortables' style="width:100%">
							<p class="description"><?php echo _ADMIN_BLOCKS_CENTER_DOWN_DESC ?></p>
							<div>
							<div class="column" id="d" style="width:500px">
	
<?php
$result = $db->sql_query("select * from ".$prefix."_blocks WHERE active='1' and  bposition='d'  order by bposition, weight");
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$title = sql_quote($row['title']);
	$weight = intval($row['weight']);
	block_this_mini($bid,$title,$weight);
}
?>
									</div>		
								</div>
							<br class='clear' /></div>
						<br class="clear" /></div>
						
						
					<div class="widgets-holder-wrap"  >
						<div class="sidebar-name movable" >
							<div class="sidebar-name-arrow" >
								<br /></div>
							<h3 style="color:#B54C43"><?php echo _ADMIN_BLOCKS_INACTIVE ?></h3>
						</div>
						<div class="widget-holder inactive" style="background-color:#B54C43" >
							<p class="description" style="color:white;"><?php echo _ADMIN_BLOCKS_INACTIVE_DESC ?></p>
							<div id='wp_inactive_widgets' class='widgets-sortables' style="background-color:#B54C43">
									<div class="column" id="i" >	
<?php
$result = $db->sql_query("select * from ".$prefix."_blocks WHERE active='0' order by bposition, weight");
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$title = sql_quote($row['title']);
	$weight = intval($row['weight']);
	block_this_mini($bid,$title,$weight);
}
?>
				
									
								</div>
							</div>
						<br class="clear" /></div>
					</div>
				</div>
			</div>
			</div>
			</div>
			
			<div class="widget-liquid-right">
				<div id="widgets-right">
					<div class="widgets-holder-wrap">
						<div class="sidebar-name movable" >
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?php echo _ADMIN_BLOCKS_RIGHT ?></h3>
						</div>
						<div id='sidebar-1' class='widgets-sortables '>
		<div class="column" id="l">
<?php
$result = $db->sql_query("select * from ".$prefix."_blocks WHERE active='1' AND bposition='l' order by weight");
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$title = sql_quote($row['title']);
	$weight = intval($row['weight']);
	block_this_mini($bid,$title,$weight);
}
?>
	
							</div>				
						</div>
					</div>
					<div class="widgets-holder-wrap closed">
						<div class="sidebar-name movable">
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?php echo _ADMIN_BLOCKS_LEFT ?></h3>
						</div>
						<div id='sidebar-2' class='widgets-sortables'>
		<div class="column" id="r">
<?php
$result = $db->sql_query("select * from ".$prefix."_blocks WHERE active='1' AND bposition='r' order by weight");
while ($row = $db->sql_fetchrow($result)) {
	$bid = intval($row['bid']);
	$title = sql_quote($row['title']);
	$weight = intval($row['weight']);
	block_this_mini($bid,$title,$weight);
}
?>
							</div>
						</div>
					</div>
				</div>
				
			<a href="<?php echo $admin_file?>.php?op=fixweight" class="button" style="padding:10px;position:relative;clear:both;"><?php echo _ADMIN_BLOCKS_OPTIMIZE?></a>
			<br><br><br>
			<a href="<?php echo $admin_file?>.php?op=block_ADD" class="button" style="padding:10px;position:relative;clear:both;"><?php echo _ADMIN_BLOCKS_ADDNEW?></a>

		<div id="console" ></div>
			</div>
		<br class="clear" /></div>
		<div class="clear"></div>
	</div>
	<!-- wpbody-content -->
	<div class="clear"></div>

	<div class="clear"></div>
</div>
</div>

<?php

//block_ADD();
include("footer.php");
	}

	function block_ADD(){
		global $prefix,$multilingual, $db, $admin_file;

		include("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"option\"><b>"._ADDNEWBLOCK."</b></font></center><br><br>"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<table border=\"0\" width=\"100%\">"
		."<tr><td>"._TITLE.":</td><td><input type=\"text\" name=\"title\" size=\"30\" maxlength=\"60\"></td></tr>"
		."<tr><td>"._RSSFILE.":</td><td><input type=\"text\" name=\"url\" size=\"30\" maxlength=\"200\">&nbsp;&nbsp;"
		."<select name=\"headline\">"
		."<option name=\"headline\" value=\"0\" selected>"._CUSTOM."</option>";
		$res3 = $db->sql_query("select hid, sitename from ".$prefix."_headlines");
		while ($row_res3 = $db->sql_fetchrow($res3)) {
			$hid = intval($row_res3['hid']);
			$htitle = check_html($row_res3['sitename'], "nohtml");
			echo "<option name=\"headline\" value=\"$hid\">$htitle</option>";
		}
		echo "</select>&nbsp;[ <a href=\"".$admin_file.".php?op=HeadlinesAdmin\">Setup</a> ]<br><font class=\"tiny\">";
		echo ""._SETUPHEADLINES."</font></td></tr>"
		."<tr><td>"._FILENAME.":</td><td>"
		."<select name=\"blockfile\">"
		."<option name=\"blockfile\" value=\"\" selected>"._NONE."</option>";
		$blocksdir = dir("blocks");
		while($func=$blocksdir->read()) {
			if(substr($func, 0, 6) == "block-") {
				$blockslist .= "$func ";
			}
		}
		closedir($blocksdir->handle);
		$blockslist = explode(" ", $blockslist);
		sort($blockslist);
		for ($i=0; $i < sizeof($blockslist); $i++) {
			if(!empty($blockslist[$i])) {
				$bl = str_replace("block-","",$blockslist[$i]);
				$bl = str_replace(".php","",$bl);
				$bl = str_replace("_"," ",$bl);
				$result2 = $db->sql_query("select * from ".$prefix."_blocks where blockfile='$blockslist[$i]'");
				$numrows = $db->sql_numrows($result2);
				if ($numrows == 0) {
					echo "<option value=\"$blockslist[$i]\">$bl</option>\n";
				}
			}
		}
		echo "</select>&nbsp;&nbsp;<font class=\"tiny\">"._FILEINCLUDE."</font></td></tr>"
		."<tr><td>"._CONTENT.":</td><td><a href='' id='jqeditor'>editor</a>";

		//<textarea name=\"content\" cols=\"70\" rows=\"15\"></textarea>";

		wysiwyg_textarea("content", "", "PHPNukeAdmin", "50", "10");

		echo "<br><font class=\"tiny\">"._IFRSSWARNING."</font></td></tr>"
		."<tr><td>"._POSITION.":</td><td><select name=\"bposition\"><option name=\"bposition\" value=\"l\">"._LEFT."</option>"
		."<option name=\"bposition\" value=\"c\">"._CENTERUP."</option>"
		."<option name=\"bposition\" value=\"d\">"._CENTERDOWN."</option>"
		."<option name=\"bposition\" value=\"r\">"._RIGHT."</option></select></td></tr>";
		if ($multilingual == 1) {
			echo "<tr><td>"._LANGUAGE.":</td><td>"
			."<select name=\"blanguage\">";
			$handle=opendir('language');
			$languageslist = "";
			while ($file = readdir($handle)) {
				if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
					$langFound = $matches[1];
					$languageslist .= "$langFound ";
				}
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++) {
				if($languageslist[$i]!="") {
					echo "<option value=\"$languageslist[$i]\" ";
					if($languageslist[$i]==$currentlang) echo "selected";
					echo ">".ucfirst($languageslist[$i])."</option>\n";
				}
			}
			echo "<option value=\"\">"._ALL."</option></select></td></tr>";
		} else {
			echo "<input type=\"hidden\" name=\"blanguage\" value=\"\">";
		}
		echo "<tr><td>"._ACTIVATE2."</td><td><input type=\"radio\" name=\"active\" value=\"1\" checked>"._YES." &nbsp;&nbsp;"
		."<input type=\"radio\" name=\"active\" value=\"0\">"._NO."</td></tr>"
		."<tr><td>"._EXPIRATION.":</td><td><input type=\"text\" name=\"expire\" size=\"4\" maxlength=\"3\" value=\"0\"> "._DAYS."</td></tr>"
		."<tr><td>"._AFTEREXPIRATION.":</td><td><select name=\"action\">"
		."<option name=\"action\" value=\"d\">"._DEACTIVATE."</option>"
		."<option name=\"action\" value=\"r\">"._DELETE."</option></select></td></tr>"
		."<tr><td>"._REFRESHTIME.":</td><td><select name=\"refresh\">"
		."<option name=\"refresh\" value=\"1800\">1/2 "._HOUR."</option>"
		."<option name=\"refresh\" value=\"3600\" selected>1 "._HOUR."</option>"
		."<option name=\"refresh\" value=\"18000\">5 "._HOURS."</option>"
		."<option name=\"refresh\" value=\"36000\">10 "._HOURS."</option>"
		."<option name=\"refresh\" value=\"86400\">24 "._HOURS."</option></select>&nbsp;<font class=\"tiny\">"._ONLYHEADLINES."</font></td></tr>"
		."<tr><td>"._VIEWPRIV."</td><td><select name=\"view\">"
		."<option value=\"0\" >"._MVALL."</option>"
		."<option value=\"1\" >"._MVUSERS."</option>"
		."<option value=\"2\" >"._MVADMIN."</option>"
		."<option value=\"3\" >"._MVANON."</option>"
		."</select></td></tr><tr><td nowrap>"
		.""._SUBVISIBLE."</td><td><input type=\"radio\" name=\"subscription\" value=\"0\" checked>"._YES." &nbsp;&nbsp;<input type=\"radio\" name=\"subscription\" value=\"1\">"._NO.""
		."</td></tr></table><br><br>"
		."<input type=\"hidden\" name=\"op\" value=\"BlocksAdd\">"
		."<input type=\"submit\" value=\""._CREATEBLOCK."\"></form>";
		CloseTable();
		include("footer.php");
	}

	function Inline_Block_EDIT($bid) {
		global $prefix, $db, $multilingual, $admin_file, $AllowableHTML;

		$bid = intval($bid);
		$row = $db->sql_fetchrow($db->sql_query("select bkey, title, content, url, bposition, weight, active, refresh, blanguage, blockfile, view, expire, action, subscription from ".$prefix."_blocks where bid='$bid'"));
		$bkey = check_html($row['bkey'], "nohtml");
		$title = stripslashes(check_html($row['title'], "nohtml"));
		//$content = stripslashes(check_html($row[content], ""));
		$content = $row['content'];
		$url = check_html($row['url'], "nohtml");
		$bposition = check_html($row['bposition'], "nohtml");
		$weight = intval($row['weight']);
		$active = intval($row['active']);
		$refresh = intval($row['refresh']);
		$blanguage = $row['blanguage'];
		$blockfile = check_html($row['blockfile'], "nohtml");
		$view = intval($row['view']);
		$expire = intval($row['expire']);
		$action = intval($row['action']);
		$subscription = intval($row['subscription']);
		if ($url != "") {
			$type = _RSSCONTENT;
		} elseif ($blockfile != "") {
			$type = _BLOCKFILE;
		}
		$inline_block_edit = "<center>"._BLOCK.": $title $type</b></center>"
		."<form action=\"".$admin_file.".php\" method=\"post\">
			<div class=\"widget-content\" style='line-height:29px;'>"
		.""._TITLE.":<br>
				<input type=\"text\" name=\"title\" size=\"30\" maxlength=\"60\" value=\"$title\"><br>";
		if ($blockfile != "") {
			$inline_block_edit .= ""._FILENAME.":<br>"
			."<select name=\"blockfile\">";
			$blocksdir = dir("blocks");
			while($func=$blocksdir->read()) {
				if(substr($func, 0, 6) == "block-") {
					$blockslist .= "$func ";
				}
			}
			closedir($blocksdir->handle);
			$blockslist = explode(" ", $blockslist);
			sort($blockslist);
			for ($i=0; $i < sizeof($blockslist); $i++) {
				if($blockslist[$i]!="") {
					$bl = str_replace("block-","",$blockslist[$i]);
					$bl = str_replace(".php","",$bl);
					$bl = str_replace("_"," ",$bl);
					$inline_block_edit .= "<option value=\"$blockslist[$i]\" ";
					if ($blockfile == $blockslist[$i]) { $inline_block_edit .=  "selected"; }
					$inline_block_edit .=  ">$bl</option>\n";
				}
			}
			$inline_block_edit .=  "</select><br>";
			//&nbsp;&nbsp;<font class=\"tiny\">"._FILEINCLUDE."</font>";
		} else {
			if ($url != "") {
				$inline_block_edit .=  "<tr><td>"._RSSFILE.":</td><td><input type=\"text\" name=\"url\" size=\"30\" maxlength=\"200\" value=\"$url\">&nbsp;&nbsp;<font class=\"tiny\">"._ONLYHEADLINES."</font>";
			} else {
				$inline_block_edit .=  ""._CONTENT.":";

				//	wysiwyg_textarea("content", "$content", "PHPNukeAdmin", "50", "10");

			}
		}
		$oldposition = $bposition;
		$inline_block_edit .=  "<input type=\"hidden\" name=\"oldposition\" value=\"$oldposition\">";
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if ($bposition == "l") {
			$sel1 = "selected";
		} elseif ($bposition == "c") {
			$sel2 = "selected";
		} elseif ($bposition == "r") {
			$sel3 = "selected";
		} elseif ($bposition == "d") {
			$sel4 = "selected";
		}
		$inline_block_edit .=  ""._POSITION.":<select name=\"bposition\">"
		."<option name=\"bposition\" value=\"l\" $sel1>"._LEFT."</option>"
		."<option name=\"bposition\" value=\"c\" $sel2>"._CENTERUP."</option>"
		."<option name=\"bposition\" value=\"d\" $sel4>"._CENTERDOWN."</option>"
		."<option name=\"bposition\" value=\"r\" $sel3>"._RIGHT."</option></select><br>";
		if ($multilingual == 1) {
			$inline_block_edit .=  ""._LANGUAGE.":"
			."<select name=\"blanguage\">";
			$handle=opendir('language');
			$languageslist = "";
			while ($file = readdir($handle)) {
				if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
					$langFound = $matches[1];
					$languageslist .= "$langFound ";
				}
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++) {
				if($languageslist[$i]!="") {
					$inline_block_edit .=  "<option value=\"$languageslist[$i]\" ";
					if($languageslist[$i]==$blanguage) $inline_block_edit.= "selected";
					$inline_block_edit .=  ">".ucfirst($languageslist[$i])."</option>\n";
				}
			}
			if ($blanguage != "") {
				$sel3 = "";
			} else {
				$sel3 = "selected";
			}
			$inline_block_edit .=  "<option value=\"\" $sel3>"._ALL."</option></select><br>";
		} else {
			$inline_block_edit .=  "<input type=\"hidden\" name=\"blanguage\" value=\"\">";
		}
		if ($active == 1) {
			$sel1 = "checked";
			$sel2 = "";
		} elseif ($active == 0) {
			$sel1 = "";
			$sel2 = "checked";
		}
		if ($expire != 0) {
			$oldexpire = $expire;
			$expire = intval(($expire - time()) / 3600);
			$exp_day = $expire / 24;
			$expire = "<input type=\"hidden\" name=\"expire\" value=\"$oldexpire\"><b>$expire "._HOURS." (".substr($exp_day,0,5)." "._DAYS.")</b> <input type='text' name='moretime' size='4'> "._MOREDAYS."";
		} else {
			$expire = "<input type=\"text\" name=\"expire\" value=\"0\" size=\"4\" maxlength=\"3\"> "._DAYS."";
		}
		if ($action == "d") {
			$selact1 = "selected";
			$selact2 = "";
		} elseif ($action == "r") {
			$selact1 = "";
			$selact2 = "selected";
		}
		$inline_block_edit .=  ""._ACTIVATE2."<input type=\"radio\" name=\"active\" value=\"1\" $sel1>"._YES." &nbsp;&nbsp;"
		."<input type=\"radio\" name=\"active\" value=\"0\" $sel2>"._NO.""
		."<br>"._EXPIRATION.":$expire"
		."<br>"._AFTEREXPIRATION.":<select name=\"action\">"
		."<option name=\"action\" value=\"d\" $selact1>"._DEACTIVATE."</option>"
		."<option name=\"action\" value=\"r\" $selact2>"._DELETE."</option></select><br>";
		if ($url != "") {
			$sel1 = $sel2 = $sel3 = $sel4 = $sel5 = "";
			if ($refresh == 1800) {
				$sel1 = "selected";
			} elseif ($refresh == 3600) {
				$sel2 = "selected";
			} elseif ($refresh == 18000) {
				$sel3 = "selected";
			} elseif ($refresh == 36000) {
				$sel4 = "selected";
			} elseif ($refresh == 86400) {
				$sel5 = "selected";
			}
			$inline_block_edit .=  ""._REFRESHTIME.":<select name=\"refresh\"><option name=\"refresh\" value=\"1800\" $sel1>1/2 "._HOUR."</option><br>"
			."<option name=\"refresh\" value=\"3600\" $sel2>1 "._HOUR."</option>"
			."<option name=\"refresh\" value=\"18000\" $sel3>5 "._HOURS."</option>"
			."<option name=\"refresh\" value=\"36000\" $sel4>10 "._HOURS."</option>"
			."<option name=\"refresh\" value=\"86400\" $sel5>24 "._HOURS."</option></select>&nbsp;<font class=\"tiny\">"._ONLYHEADLINES."</font>";
		}
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if ($view == 0) {
			$sel1 = "selected";
		} elseif ($view == 1) {
			$sel2 = "selected";
		} elseif ($view == 2) {
			$sel3 = "selected";
		} elseif ($view == 3) {
			$sel4 = "selected";
		}
		if ($subscription == 1) {
			$sub_c1 = "";
			$sub_c2 = "checked";
		} else {
			$sub_c1 = "checked";
			$sub_c2 = "";
		}
		$inline_block_edit .=  ""._VIEWPRIV."<select name=\"view\">"
		."<option value=\"0\" $sel1>"._MVALL."</option>"
		."<option value=\"1\" $sel2>"._MVUSERS."</option>"
		."<option value=\"2\" $sel3>"._MVADMIN."</option>"
		."<option value=\"3\" $sel4>"._MVANON."</option>"
		."</select>"
		."<br>"._SUBVISIBLE."<input type='radio' name='subscription' value='0' $sub_c1> "._YES."&nbsp;&nbsp;<input type='radio' name='subscription' value='1' $sub_c2> "._NO.""
		."<br><br>"
		."<input type=\"hidden\" name=\"bid\" value=\"$bid\">"
		."<input type=\"hidden\" name=\"bkey\" value=\"$bkey\">"
		."<input type=\"hidden\" name=\"weight\" value=\"$weight\">"
		."<div style='display:none' ><textarea name=\"content\">$content</textarea></div>"
		."<input type=\"hidden\" name=\"op\" value=\"BlocksEditSave\">"
		."<input type=\"submit\" value=\""._SAVEBLOCK."\">
		<a href='".ADMIN_OP."BlocksEdit&bid=$bid' class='button'>"._EDIT." "._BLOCK."   </a>
		</div>
		</form>
		";

		return $inline_block_edit ;

	}

	function block_this_mini($bid,$title,$weight){

		$block_view ='<div class="widget" id="item'.$bid.'" >
								<div class="widget-top movable" >
										<div class="widget-title-action">
											<a class="widget-action hide-if-no-js"></a>
											<a class="widget-control-edit hide-if-js"></a>
									</div>
										<div class="widget-title" id="weight'.$weight.'" style="text-align:center;">
											<h4>'.langit($title).'<span class="in-widget-title"></span></h4> <span  style="text-align:'.langStyle(align).';float:'.langStyle(align).'">
							<a href="javascript:void(0)" class="jqdelete"><img src="images/delete.gif" alt="'._DELETE.'" title="'._DELETE.'" border="0" height="17px" ></a></span>
										</div>
									</div>
								<div id="[bid]-content" class="widget-inside" style="display:none;text-align:right">
										<p>'.Inline_Block_EDIT($bid).'</p>
								</div>
					</div>';
		print $block_view ;
	}

	function bl_quick_delete() {
		global $prefix,$db;
		if(isset($_GET['bid']))
		{
			$row = $db->sql_fetchrow($db->sql_query("select bposition, weight from ".$prefix."_blocks where bid='".$_GET['bid']."'"));
			$bposition = check_html($row['bposition'], "nohtml");
			$weight = intval($row['weight']);
			$result2 = $db->sql_query("select bid from ".$prefix."_blocks where weight>'$weight' AND bposition='$bposition'");
			while ($row2 = $db->sql_fetchrow($result2)) {
				$nbid = intval($row2['bid']);
				$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$nbid'");
				$weight++;
			}
			$db->sql_query("delete from ".$prefix."_blocks where bid='".$_GET['bid']."'");

		}else {
			die("no id recieved");
		}
	}

	function save_blocks_change(){

		if (get_magic_quotes_gpc()) {
			function stripslashes_deep($value)
			{
				$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

				return $value;
			}

			$_POST = array_map('stripslashes_deep', $_POST);
			$_GET = array_map('stripslashes_deep', $_GET);
			$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
			$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
		}

		if(!$_POST["data"]){
			echo "Invalid data";
			exit;
		}
		//decode JSON data received from AJAX POST request
		$data=json_decode($_POST["data"]);

		global $db,$prefix;
		foreach($data->items as $item)
		{
			//Extract id of the panel
			$widget_id=preg_replace('/[^\d\s]/', '', $item->id);
			$sql="UPDATE ".$prefix."_blocks SET bposition='".$item->column."', weight='".$item->order."' , active='1' WHERE bid='".$widget_id."'";
			$db->sql_query($sql) or die('Error updating widget DB'.mysql_error());

			if ($item->column == "i") {
				$sql="UPDATE ".$prefix."_blocks SET active='0' WHERE bid='".$widget_id."'";
				$db->sql_query($sql) or die('Error updating widget DB'.mysql_error());
			}

		}
		echo "<div class=\"notify\" >"._BLOCKS_ORDER_SAVED."<br>
<b>".date('h:i:s A') ."</b>
</div>";

	}

	function block_show($bid) {
		global $prefix, $db, $admin_file;
		include("header.php");
		GraphicAdmin();
		title(""._BLOCKSADMIN."");
		OpenTable();
		echo "<br><center>";
		$bid = intval($bid);
		$row = $db->sql_fetchrow($db->sql_query("select bid, bkey, title, content, url, active, bposition, blockfile from ".$prefix."_blocks where bid='$bid'"));
		$bid = intval($row['bid']);
		$bkey = check_html($row['bkey'], "nohtml");
		$title = check_html($row['title'], "nohtml");
		$content = $row['content'];
		$url = check_html($row['url'], "nohtml");
		$active = intval($row['active']);
		$bposition = check_html($row['bposition'], "nohtml");
		$blockfile = check_html($row['blockfile'], "nohtml");
		if ($bkey == "main") {
			mainblock();
		} elseif ($bkey == "admin") {
			adminblock();
		} elseif ($bkey == "modules") {
			modules_block();
		} elseif ($bkey == "category") {
			category();
		} elseif ($bkey == "userbox") {
			userblock();
		} elseif (empty($bkey)) {
			if (empty($url)) {
				if (empty($blockfile)) {
					if ($bposition == "c") {
						themecenterbox($title, $content);
					} else {
						themesidebox($title, $content);
					}
				} else {
					if ($bposition == "c") {
						blockfileinc($title, $blockfile, 1);
					} else {
						blockfileinc($title, $blockfile);
					}
				}
			} else {
				headlines($bid);
			}
		}
		echo "</center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		if ($active == 1) {
			$act_chg = _DEACTIVATE;
		} elseif ($active == 0) {
			$act_chg = _ACTIVATE;
		}
		echo "<center><font class=\"option\"><b>"._BLOCKSADMIN.": "._FUNCTIONS."</b></font><br><br>"
		."[ <a href=\"".$admin_file.".php?op=ChangeStatus&bid=$bid\">$act_chg</a> | <a href=\"".$admin_file.".php?op=BlocksEdit&bid=$bid\">"._EDIT."</a> | ";
		if (empty($bkey)) {
			echo "<a href=\"".$admin_file.".php?op=BlocksDelete&bid=$bid\">"._DELETE."</a> | ";
		} else {
			echo ""._DELETE." | ";
		}
		echo "<a href=\"".$admin_file.".php?op=BlocksAdmin\">"._BLOCKSADMIN."</a> ]</center>";
		CloseTable();
		include("footer.php");
	}

	function fixweight() {
		global $prefix, $db, $admin_file;
		$leftpos = "l";
		$rightpos = "r";
		$centerpos = "c";
		$result = $db->sql_query("select bid from ".$prefix."_blocks where bposition='$leftpos' order by weight ASC");
		$weight = 0;
		while ($row = $db->sql_fetchrow($result)) {
			$bid = intval($row['bid']);
			$weight++;
			$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$bid'");
		}
		$result2 = $db->sql_query("select bid from ".$prefix."_blocks where bposition='$rightpos' order by weight ASC");
		$weight = 0;
		while ($row2 = $db->sql_fetchrow($result2)) {
			$bid = intval($row2['bid']);
			$weight++;
			$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$bid'");
		}
		$result3 = $db->sql_query("select bid from ".$prefix."_blocks where bposition='$centerpos' order by weight ASC");
		$weight = 0;
		while ($row3 = $db->sql_fetchrow($result3)) {
			$bid = intval($row3['bid']);
			$weight++;
			$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$bid'");
		}
		Header("Location: ".$admin_file.".php?op=BlocksAdmin");
	}

	function BlockOrder ($weightrep,$weight,$bidrep,$bidori) {
		global $prefix, $db, $admin_file;
		$bidrep = intval($bidrep);
		$bidori = intval($bidori);
		$result = $db->sql_query("update ".$prefix."_blocks set weight='".intval($weight)."' where bid='$bidrep'");
		$result2 = $db->sql_query("update ".$prefix."_blocks set weight='".intval($weightrep)."' where bid='$bidori'");
		Header("Location: ".$admin_file.".php?op=BlocksAdmin");
	}

	function rssfail() {
		include("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._BLOCKSADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<center><b>"._RSSFAIL."</b><br><br>"
		.""._RSSTRYAGAIN."<br><br>"
		.""._GOBACK."</center>";
		CloseTable();
		include("footer.php");
		die;
	}

	function BlocksAdd($title, $content, $url, $bposition, $active, $refresh, $headline, $blanguage, $blockfile, $view, $expire, $action, $subscription) {
		global $prefix, $db, $admin_file;
		if ($headline != 0) {
			$row = $db->sql_fetchrow($db->sql_query("select sitename, headlinesurl from ".$prefix."_headlines where hid='".intval($headline)."'"));
			$title = addslashes(check_words(check_html($row['sitename'], "")));
			$url = addslashes(check_words(check_html($row['headlinesurl'], "")));
		}
		$bposition = strtolower(substr($bposition,0,1));
		$row2 = $db->sql_fetchrow($db->sql_query("SELECT weight FROM ".$prefix."_blocks WHERE bposition='$bposition' ORDER BY weight DESC"));
		$weight = intval($row2['weight']);
		$weight++;
		$bkey = "";
		$btime = "";
		if (!empty($blockfile)) {
			$url = "";
			if (empty($title)) {
				$title = str_replace("block-","",$blockfile);
				$title = str_replace(".php","",$title);
				$title = str_replace("_"," ",$title);
			}
		}
		if (!empty($url)) {
			$btime = time();
			if (!preg_match("_http://_",$url)) {
				$url = "http://$url";
			}
			$rdf = parse_url($url);
			$fp = fsockopen($rdf['host'], 80, $errno, $errstr, 15);
			if (!$fp) {
				rssfail();
				exit;
			}
			if ($fp) {
				fputs($fp, "GET " . $rdf['path'] . "?" . $rdf['query'] . " HTTP/1.0\r\n");
				fputs($fp, "HOST: " . $rdf['host'] . "\r\n\r\n");
				$string = "";
				while(!feof($fp)) {
					$pagetext = fgets($fp,228);
					$string .= chop($pagetext);
				}
				fputs($fp,"Connection: close\r\n\r\n");
				fclose($fp);
				$items = explode("</item>",$string);
				$content = "<font class=\"content\">";
				for ($i=0;$i<10;$i++) {
					$link = str_replace(".*<link>","",$items[$i]);
					$link = str_replace("</link>.*","",$link);
					$title2 = str_replace(".*<title>","",$items[$i]);
					$title2 = str_replace("</title>.*","",$title2);
					if ($items[$i] == "" AND $cont != 1) {
						$content = "";
					} else {
						if (strcmp($link,$title2) AND !empty($items[$i])) {
							$cont = 1;
							$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"$link\" target=\"new\">$title2</a><br>\n";
						}
					}
				}
			}
		}
		$url = addslashes(check_words(check_html($url, "nohtml")));
		$title = addslashes(check_words(check_html($title, "nohtml")));
		//$content = addslashes(check_words(check_html($content, "")));
		$blanguage = addslashes(check_words(check_html($blanguage, "nohtml")));
		$blockfile = addslashes(check_words(check_html($blockfile, "nohtml")));
		$action = strtolower(substr($action,0,1));
		if (($content == "") AND ($blockfile == "")) {
			rssfail();
		} else {
			if ($expire == "") {
				$expire = 0;
			}
			if ($expire != 0) {
				$expire = time() + ($expire * 86400);
			}
			$db->sql_query("insert into ".$prefix."_blocks values (NULL, '$bkey', '$title', '$content', '$url', '$bposition', '$weight', '".intval($active)."', '".intval($refresh)."', '$btime', '$blanguage', '$blockfile', '".intval($view)."', '$expire', '$action', '$subscription')");
			Header("Location: ".$admin_file.".php?op=BlocksAdmin");
		}
	}

	function BlocksEdit($bid) {
		global $bgcolor2, $bgcolor4, $prefix, $db, $multilingual, $admin_file, $AllowableHTML;
		include("header.php");
		GraphicAdmin();
		echo "<br>";
		$bid = intval($bid);
		$row = $db->sql_fetchrow($db->sql_query("select bkey, title, content, url, bposition, weight, active, refresh, blanguage, blockfile, view, expire, action, subscription from ".$prefix."_blocks where bid='$bid'"));
		$bkey = check_html($row['bkey'], "nohtml");
		$title = stripslashes(check_html($row['title'], "nohtml"));
		$content = stripslashes($row['content']);
		$url = check_html($row['url'], "nohtml");
		$bposition = check_html($row['bposition'], "nohtml");
		$weight = intval($row['weight']);
		$active = intval($row['active']);
		$refresh = intval($row['refresh']);
		$blanguage = $row['blanguage'];
		$blockfile = check_html($row['blockfile'], "nohtml");
		$view = intval($row['view']);
		$expire = intval($row['expire']);
		$action = intval($row['action']);
		$subscription = intval($row['subscription']);
		if ($url != "") {
			$type = _RSSCONTENT;
		} elseif ($blockfile != "") {
			$type = _BLOCKFILE;
		}
		OpenTable();
		echo "<h3>"._EDITBLOCK."</h3><center><font class=\"option\"><b>"._BLOCK.": $title $type</b></font></center><br><br>"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<table border=\"0\" width=\"100%\">"
		."<tr><td>"._TITLE.":</td><td><input type=\"text\" name=\"title\" size=\"30\" maxlength=\"60\" value=\"$title\">"._LANGIT."</td></tr>";
		if ($blockfile != "") {
			echo "<tr><td>"._FILENAME.":</td><td>"
			."<select name=\"blockfile\">";
			$blocksdir = dir("blocks");
			while($func=$blocksdir->read()) {
				if(substr($func, 0, 6) == "block-") {
					$blockslist .= "$func ";
				}
			}
			closedir($blocksdir->handle);
			$blockslist = explode(" ", $blockslist);
			sort($blockslist);
			for ($i=0; $i < sizeof($blockslist); $i++) {
				if($blockslist[$i]!="") {
					$bl = str_replace("block-","",$blockslist[$i]);
					$bl = str_replace(".php","",$bl);
					$bl = str_replace("_"," ",$bl);
					echo "<option value=\"$blockslist[$i]\" ";
					if ($blockfile == $blockslist[$i]) { echo "selected"; }
					echo ">$bl</option>\n";
				}
			}
			echo "</select>&nbsp;&nbsp;<font class=\"tiny\">"._FILEINCLUDE."</font></td></tr>";
		} else {
			if ($url != "") {
				echo "<tr><td>"._RSSFILE.":</td><td><input type=\"text\" name=\"url\" size=\"30\" maxlength=\"200\" value=\"$url\">&nbsp;&nbsp;<font class=\"tiny\">"._ONLYHEADLINES."</font></td></tr>";
			} else {
				echo "<tr><td>"._CONTENT.":</td><td>";

				//<textarea name=\"content\" cols=\"70\" rows=\"15\">$content</textarea>";
				wysiwyg_textarea("content", "$content", "PHPNukeAdmin", "50", "10");

				echo "</td></tr>";
			}
		}
		$oldposition = $bposition;
		echo "<input type=\"hidden\" name=\"oldposition\" value=\"$oldposition\">";
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if ($bposition == "l") {
			$sel1 = "selected";
		} elseif ($bposition == "c") {
			$sel2 = "selected";
		} elseif ($bposition == "r") {
			$sel3 = "selected";
		} elseif ($bposition == "d") {
			$sel4 = "selected";
		}
		echo "<tr><td>"._POSITION.":</td><td><select name=\"bposition\">"
		."<option name=\"bposition\" value=\"l\" $sel1>"._LEFT."</option>"
		."<option name=\"bposition\" value=\"c\" $sel2>"._CENTERUP."</option>"
		."<option name=\"bposition\" value=\"d\" $sel4>"._CENTERDOWN."</option>"
		."<option name=\"bposition\" value=\"r\" $sel3>"._RIGHT."</option></select></td></tr>";
		if ($multilingual == 1) {
			echo "<tr><td>"._LANGUAGE.":</td><td>"
			."<select name=\"blanguage\">";
			$handle=opendir('language');
			$languageslist = "";
			while ($file = readdir($handle)) {
				if (preg_match("/^lang\-(.+)\.php/", $file, $matches)) {
					$langFound = $matches[1];
					$languageslist .= "$langFound ";
				}
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++) {
				if($languageslist[$i]!="") {
					echo "<option value=\"$languageslist[$i]\" ";
					if($languageslist[$i]==$blanguage) echo "selected";
					echo ">".ucfirst($languageslist[$i])."</option>\n";
				}
			}
			if ($blanguage != "") {
				$sel3 = "";
			} else {
				$sel3 = "selected";
			}
			echo "<option value=\"\" $sel3>"._ALL."</option></select></td></tr>";
		} else {
			echo "<input type=\"hidden\" name=\"blanguage\" value=\"\">";
		}
		if ($active == 1) {
			$sel1 = "checked";
			$sel2 = "";
		} elseif ($active == 0) {
			$sel1 = "";
			$sel2 = "checked";
		}
		if ($expire != 0) {
			$oldexpire = $expire;
			$expire = intval(($expire - time()) / 3600);
			$exp_day = $expire / 24;
			$expire = "<input type=\"hidden\" name=\"expire\" value=\"$oldexpire\"><b>$expire "._HOURS." (".substr($exp_day,0,5)." "._DAYS.")</b> <input type='text' name='moretime' size='4'> "._MOREDAYS."";
		} else {
			$expire = "<input type=\"text\" name=\"expire\" value=\"0\" size=\"4\" maxlength=\"3\"> "._DAYS."";
		}
		if ($action == "d") {
			$selact1 = "selected";
			$selact2 = "";
		} elseif ($action == "r") {
			$selact1 = "";
			$selact2 = "selected";
		}
		echo "<tr><td>"._ACTIVATE2."</td><td><input type=\"radio\" name=\"active\" value=\"1\" $sel1>"._YES." &nbsp;&nbsp;"
		."<input type=\"radio\" name=\"active\" value=\"0\" $sel2>"._NO."</td></tr>"
		."<tr><td>"._EXPIRATION.":</td><td>$expire</td></tr>"
		."<tr><td>"._AFTEREXPIRATION.":</td><td><select name=\"action\">"
		."<option name=\"action\" value=\"d\" $selact1>"._DEACTIVATE."</option>"
		."<option name=\"action\" value=\"r\" $selact2>"._DELETE."</option></select></td></tr>";
		if ($url != "") {
			$sel1 = $sel2 = $sel3 = $sel4 = $sel5 = "";
			if ($refresh == 1800) {
				$sel1 = "selected";
			} elseif ($refresh == 3600) {
				$sel2 = "selected";
			} elseif ($refresh == 18000) {
				$sel3 = "selected";
			} elseif ($refresh == 36000) {
				$sel4 = "selected";
			} elseif ($refresh == 86400) {
				$sel5 = "selected";
			}
			echo "<tr><td>"._REFRESHTIME.":</td><td><select name=\"refresh\"><option name=\"refresh\" value=\"1800\" $sel1>1/2 "._HOUR."</option>"
			."<option name=\"refresh\" value=\"3600\" $sel2>1 "._HOUR."</option>"
			."<option name=\"refresh\" value=\"18000\" $sel3>5 "._HOURS."</option>"
			."<option name=\"refresh\" value=\"36000\" $sel4>10 "._HOURS."</option>"
			."<option name=\"refresh\" value=\"86400\" $sel5>24 "._HOURS."</option></select>&nbsp;<font class=\"tiny\">"._ONLYHEADLINES."</font>";
		}
		$sel1 = $sel2 = $sel3 = $sel4 = "";
		if ($view == 0) {
			$sel1 = "selected";
		} elseif ($view == 1) {
			$sel2 = "selected";
		} elseif ($view == 2) {
			$sel3 = "selected";
		} elseif ($view == 3) {
			$sel4 = "selected";
		}
		if ($subscription == 1) {
			$sub_c1 = "";
			$sub_c2 = "checked";
		} else {
			$sub_c1 = "checked";
			$sub_c2 = "";
		}
		echo "</td></tr><tr><td>"._VIEWPRIV."</td><td><select name=\"view\">"
		."<option value=\"0\" $sel1>"._MVALL."</option>"
		."<option value=\"1\" $sel2>"._MVUSERS."</option>"
		."<option value=\"2\" $sel3>"._MVADMIN."</option>"
		."<option value=\"3\" $sel4>"._MVANON."</option>"
		."</select></td></tr><tr><td nowrap>"
		.""._SUBVISIBLE."</td><td><input type='radio' name='subscription' value='0' $sub_c1> "._YES."&nbsp;&nbsp;<input type='radio' name='subscription' value='1' $sub_c2> "._NO.""
		."</td></tr></table><br><br>"
		."<input type=\"hidden\" name=\"bid\" value=\"$bid\">"
		."<input type=\"hidden\" name=\"bkey\" value=\"$bkey\">"
		."<input type=\"hidden\" name=\"weight\" value=\"$weight\">"
		."<input type=\"hidden\" name=\"op\" value=\"BlocksEditSave\">"
		."<input type=\"submit\" value=\""._SAVEBLOCK."\"></form>";
		CloseTable();
		include("footer.php");
	}

	function SortWeight($bposition) {
		global $prefix, $db;
		$numbers = 1;
		$number_two = 1;
		$result = $db->sql_query("SELECT bid,weight FROM ".$prefix."_blocks WHERE bposition='$bposition' ORDER BY weight");
		while ($row = $db->sql_fetchrow($result)) {
			$bid = intval($row['bid']);
			$weight = intval($row['weight']);
			$result2 = $db->sql_query("update ".$prefix."_blocks set weight='$numbers' where bid='$bid'");
			$numbers++;
		}
		if ($bposition == l) {
			$position_two = "r";
		} else {
			$position_two = "l";
		}
		$result_two = $db->sql_query("SELECT bid,weight FROM ".$prefix."_blocks WHERE bposition='$position_two' ORDER BY weight");
		while ($row_two = $db->sql_fetchrow($result_two)) {
			$bid2 = intval($row_two['bid']);
			$weight = intval($row_two['weight']);
			$result_two2 = $db->sql_query("update ".$prefix."_blocks set weight='$number_two' where bid='$bid2'");
			$number_two++;
		}
		return $numbers;
	}

	function BlocksEditSave($bid, $bkey, $title, $content, $url, $oldposition, $bposition, $active, $refresh, $weight, $blanguage, $blockfile, $view, $expire, $action, $subscription, $moretime) {
		global $prefix, $db, $admin_file;
		if (!empty($moretime)) {
			$moretime = $moretime * 86400;
			$expire = $moretime + $expire;
		}
			$bid = intval($bid);
			$bposition = strtolower(substr($bposition,0,1));
			$oldposition = strtolower(substr($oldposition,0,1));
			$title = addslashes(check_words(check_html($title, "nohtml")));
			$content = stripslashes($content);
			$active = intval($active);
			$refresh = intval($refresh);
			$weight = intval($weight);
			$blanguage = addslashes(check_words(check_html($blanguage, "nohtml")));
			$blockfile = addslashes(check_words(check_html($blockfile, "nohtml")));
			$view = intval($view);
			$action = strtolower(substr($action,0,1));
			$subscription = intval($subscription);
		if (!empty($url)) {
			$bkey = "";
			$btime = time();
			if (!preg_match("_http://_",$url)) {
				$url = "http://$url";
			}
			$rdf = parse_url($url);
			$fp = fsockopen($rdf['host'], 80, $errno, $errstr, 15);
			if (!$fp) {
				rssfail();
				exit;
			}
			if ($fp) {
				fputs($fp, "GET " . $rdf['path'] . "?" . $rdf['query'] . " HTTP/1.0\r\n");
				fputs($fp, "HOST: " . $rdf['host'] . "\r\n\r\n");
				$string	= "";
				while(!feof($fp)) {
					$pagetext = fgets($fp,300);
					$string .= chop($pagetext);
				}
				fputs($fp,"Connection: close\r\n\r\n");
				fclose($fp);
				$items = explode("</item>",$string);
				$content = "<font class=\"content\">";
				for ($i=0;$i<10;$i++) {
					$link = preg_replace("_.*<link>_","",$items[$i]);
					$link = preg_replace("_</link>.*_","",$link);
					$title2 = preg_replace("_.*<title>_","",$items[$i]);
					$title2 = preg_replace("_</title>.*_","",$title2);
					if ($items[$i] == "" AND $cont != 1) {
						$content = "";
					} else {
						if (strcmp($link,$title2) AND $items[$i] != "") {
							$cont = 1;
							$content .= "<strong><big>&middot;</big></strong>&nbsp;<a href=\"$link\" target=\"new\">$title2</a><br>\n";
						}
					}
				}
			//$content = addslashes($content);
			}
			$url = addslashes(check_words(check_html($url, "nohtml")));
			if ($oldposition != $bposition) {
				$result = $db->sql_query("select bid from ".$prefix."_blocks where weight>='$weight' AND bposition='$bposition'");
				$fweight = $weight;
				$oweight = $weight;
				while ($row = $db->sql_fetchrow($result)) {
					$nbid = intval($row['bid']);
					$weight++;
					$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$nbid'");
				}
				$result2 = $db->sql_query("select bid from ".$prefix."_blocks where weight>'$oweight' AND bposition='$oldposition'");
				while ($row2 = $db->sql_fetchrow($result2)) {
					$obid = intval($row2['bid']);
					$db->sql_query("update ".$prefix."_blocks set weight='$oweight' where bid='$obid'");
					$oweight++;
				}
				$row3 = $db->sql_fetchrow($db->sql_query("select weight from ".$prefix."_blocks where bposition='$bposition' order by weight DESC limit 0,1"));
				$lastw = $row3['weight'];
				if ($lastw <= $fweight) {
					$lastw++;
					$db->sql_query("update ".$prefix."_blocks set title='$title', content='$content', bposition='$bposition', weight='$lastw', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', subscription='$subscription' where bid='$bid'");
				} else {
					$db->sql_query("update ".$prefix."_blocks set title='$title', content='$content', bposition='$bposition', weight='$fweight', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', subscription='$subscription' where bid='$bid'");
				}
			} else {
				$db->sql_query("update ".$prefix."_blocks set bkey='$bkey', title='$title', content='$content', url='$url', bposition='$bposition', weight='$weight', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', subscription='$subscription' where bid='$bid'");
			}
			Header("Location: ".$admin_file.".php?op=BlocksAdmin");
		} else {
			if ($oldposition != $bposition) {
				$result5 = $db->sql_query("select bid from ".$prefix."_blocks where weight>='$weight' AND bposition='$bposition'");
				$fweight = $weight;
				$oweight = $weight;
				while ($row5 = $db->sql_fetchrow($result5)) {
					$nbid = intval($row5['bid']);
					$weight++;
					$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$nbid'");
				}
				$result6 = $db->sql_query("select bid from ".$prefix."_blocks where weight>'$oweight' AND bposition='$oldposition'");
				while ($row6 = $db->sql_fetchrow($result6)) {
					$obid = intval($row6['bid']);
					$db->sql_query("update ".$prefix."_blocks set weight='$oweight' where bid='$obid'");
					$oweight++;
				}
				$row7 = $db->sql_fetchrow($db->sql_query("select weight from ".$prefix."_blocks where bposition='$bposition' order by weight DESC limit 0,1"));
				$lastw = $row7['weight'];
				if ($lastw <= $fweight) {
					$lastw++;
					$db->sql_query("update ".$prefix."_blocks set title='$title', content='$content', bposition='$bposition', weight='$lastw', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', subscription='$subscription' where bid='$bid'");
				} else {
					$db->sql_query("update ".$prefix."_blocks set title='$title', content='$content', bposition='$bposition', weight='$fweight', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', subscription='$subscription' where bid='$bid'");
				}
			} else {
				if (empty($expire)) {
					$expire = 0;
				}
				if ($expire != 0 AND $expire <= 999) {
					$expire = time() + ($expire * 86400);
				}
				$result8 = $db->sql_query("update ".$prefix."_blocks set bkey='$bkey', title='$title', content='$content', url='$url', bposition='$bposition', weight='$weight', active='$active', refresh='$refresh', blanguage='$blanguage', blockfile='$blockfile', view='$view', expire='$expire', action='$action', subscription='$subscription' where bid='$bid'");
			}
			Header("Location: ".$admin_file.".php?op=BlocksAdmin");
		}
	}
	

	function ChangeStatus($bid, $ok=0) {
		global $prefix, $db, $admin_file;
		$bid = intval($bid);
		$row = $db->sql_fetchrow($db->sql_query("select active from ".$prefix."_blocks where bid='$bid'"));
		$active = intval($row['active']);
		if (($ok) OR ($active == 1)) {
			if ($active == 0) {
				$active = 1;
			} elseif ($active == 1) {
				$active = 0;
			}
			$result2 = $db->sql_query("update ".$prefix."_blocks set active='$active' where bid='$bid'");
			Header("Location: ".$admin_file.".php?op=BlocksAdmin");
		} else {
			$row3 = $db->sql_fetchrow($db->sql_query("select title, content from ".$prefix."_blocks where bid='$bid'"));
			$title = check_html($row3['title'], "nohtml");
			$content = $row3['content'];
			include("header.php");
			GraphicAdmin();
			echo "<br>";
			OpenTable();
			echo "<center><font class=\"option\"><b>"._BLOCKACTIVATION."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			if (!empty($content)) {
				echo "<center>"._BLOCKPREVIEW." <i>$title</i><br><br>";
				themesidebox($title, $content);
			} else {
				echo "<center><i>$title</i><br><br>";
			}
			echo "<br>"._WANT2ACTIVATE."<br><br>"
			."[ <a href=\"".$admin_file.".php?op=BlocksAdmin\">"._NO."</a> | <a href=\"".$admin_file.".php?op=ChangeStatus&amp;bid=$bid&amp;ok=1\">"._YES."</a> ]"
			."</center>";
			CloseTable();
			include("footer.php");
		}
	}

	function BlocksDelete($bid, $ok=0) {
		global $prefix, $db, $admin_file;
		$bid = intval($bid);
		if ($ok) {
			$row = $db->sql_fetchrow($db->sql_query("select bposition, weight from ".$prefix."_blocks where bid='$bid'"));
			$bposition = check_html($row['bposition'], "nohtml");
			$weight = intval($row['weight']);
			$result2 = $db->sql_query("select bid from ".$prefix."_blocks where weight>'$weight' AND bposition='$bposition'");
			while ($row2 = $db->sql_fetchrow($result2)) {
				$nbid = intval($row2['bid']);
				$db->sql_query("update ".$prefix."_blocks set weight='$weight' where bid='$nbid'");
				$weight++;
			}
			$db->sql_query("delete from ".$prefix."_blocks where bid='$bid'");
			Header("Location: ".$admin_file.".php?op=BlocksAdmin");
		} else {
			$row3 = $db->sql_fetchrow($db->sql_query("select title from ".$prefix."_blocks where bid='$bid'"));
			$title = $row3['title'];
			include("header.php");
			GraphicAdmin();
			OpenTable();
			echo "<center><font class=\"title\"><b>"._BLOCKSADMIN."</b></font></center>";
			CloseTable();
			echo "<br>";
			OpenTable();
			echo "<center>"._ARESUREDELBLOCK." <i>$title</i>?";
			echo "<br><br>[ <a href=\"".$admin_file.".php?op=BlocksAdmin\">"._NO."</a> | <a href=\"".$admin_file.".php?op=BlocksDelete&amp;bid=$bid&amp;ok=1\">"._YES."</a> ]</center>";
			CloseTable();
			include("footer.php");
		}
	}

	function HeadlinesAdmin() {
		global $bgcolor1, $bgcolor2, $prefix, $db, $admin_file;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._HEADLINESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<form action=\"".$admin_file.".php\" method=\"post\">"
		."<table border=\"1\" width=\"100%\" align=\"center\"><tr>"
		."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._SITENAME."</b></td>"
		."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._URL."</b></td>"
		."<td bgcolor=\"$bgcolor2\" align=\"center\"><b>"._FUNCTIONS."</b></td><tr>";
		$result = $db->sql_query("select hid, sitename, headlinesurl from ".$prefix."_headlines order by hid");
		while ($row = $db->sql_fetchrow($result)) {
			$hid = intval($row['hid']);
			$sitename = check_html($row['sitename'], "nohtml");
			$headlinesurl = check_html($row['headlinesurl'], "nohtml");
			echo "<td bgcolor=\"$bgcolor1\" align=\"center\">$sitename</td>"
			."<td bgcolor=\"$bgcolor1\" align=\"center\"><a href=\"$headlinesurl\" target=\"new\">$headlinesurl</a></td>"
			."<td bgcolor=\"$bgcolor1\" align=\"center\">[ <a href=\"".$admin_file.".php?op=HeadlinesEdit&amp;hid=$hid\">"._EDIT."</a> | <a href=\"".$admin_file.".php?op=HeadlinesDel&amp;hid=$hid&amp;ok=0\">"._DELETE."</a> ]</td><tr>";
		}
		echo "</form></td></tr></table>";
		CloseTable();
		echo "<br>";
		OpenTable();
		echo "<font class=\"option\"><b>"._ADDHEADLINE."</b></font><br><br>"
		."<font class=\"content\">"
		."<form action=\"".$admin_file.".php\" method=\"post\">"
		."<table border=\"0\" width=\"100%\"><tr><td>"
		.""._SITENAME.":</td><td><input type=\"text\" name=\"xsitename\" size=\"31\" maxlength=\"30\"></td></tr><tr><td>"
		.""._RSSFILE.":</td><td><input type=\"text\" name=\"headlinesurl\" size=\"50\" maxlength=\"200\"></td></tr><tr><td>"
		."</td></tr></table>"
		."<input type=\"hidden\" name=\"op\" value=\"HeadlinesAdd\">"
		."<input type=\"submit\" value=\""._ADD."\">"
		."</form>";
		CloseTable();
		include("footer.php");
	}

	function HeadlinesEdit($hid) {
		global $prefix, $db, $admin_file;
		include ("header.php");
		GraphicAdmin();
		OpenTable();
		echo "<center><font class=\"title\"><b>"._HEADLINESADMIN."</b></font></center>";
		CloseTable();
		echo "<br>";
		$row = $db->sql_fetchrow($db->sql_query("select sitename, headlinesurl from ".$prefix."_headlines where hid='$hid'"));
		$xsitename = stripslashes(check_html($row['sitename'], "nohtml"));
		$headlinesurl = stripslashes(check_html($row['headlinesurl'], "nohtml"));
		OpenTable();
		echo "<center><font class=\"option\"><b>"._EDITHEADLINE."</b></font></center>
	<form action=\"".$admin_file.".php\" method=\"post\">
	<input type=\"hidden\" name=\"hid\" value=\"$hid\">
	<table border=\"0\" width=\"100%\"><tr><td>
	"._SITENAME.":</td><td><input type=\"text\" name=\"xsitename\" size=\"31\" maxlength=\"30\" value=\"$xsitename\"></td></tr><tr><td>
	"._RSSFILE.":</td><td><input type=\"text\" name=\"headlinesurl\" size=\"50\" maxlength=\"200\" value=\"$headlinesurl\"></td></tr><tr><td>
	</select></td></tr></table>
	<input type=\"hidden\" name=\"op\" value=\"HeadlinesSave\">
	<input type=\"submit\" value=\""._SAVECHANGES."\">
	</form>";
		CloseTable();
		include("footer.php");
	}

	function HeadlinesSave($hid, $xsitename, $headlinesurl) {
		global $prefix, $db, $admin_file;
		$hid = intval($hid);
		$xsitename = addslashes(check_words(check_html($xsitename, "nohtml")));
		$headlinesurl = addslashes(check_words(check_html($headlinesurl, "nohtml")));
		$xsitename = str_replace(" ", "", $xsitename);
		$db->sql_query("update ".$prefix."_headlines set sitename='$xsitename', headlinesurl='$headlinesurl' where hid='$hid'");
		Header("Location: ".$admin_file.".php?op=HeadlinesAdmin");
	}

	function HeadlinesAdd($xsitename, $headlinesurl) {
		global $prefix, $db, $admin_file;
		$xsitename = addslashes(check_words(check_html($xsitename, "nohtml")));
		$headlinesurl = addslashes(check_words(check_html($headlinesurl, "nohtml")));
		$xsitename = str_replace(" ", "", $xsitename);
		$db->sql_query("insert into ".$prefix."_headlines values (NULL, '$xsitename', '$headlinesurl')");
		Header("Location: ".$admin_file.".php?op=HeadlinesAdmin");
	}

	function HeadlinesDel($hid, $ok=0) {
		global $prefix, $db, $admin_file;
		$hid = intval($hid);
		if($ok==1) {
			$db->sql_query("delete from ".$prefix."_headlines where hid='$hid'");
			Header("Location: ".$admin_file.".php?op=HeadlinesAdmin");
		} else {
			include("header.php");
			GraphicAdmin();
			OpenTable();
			echo "<center><br>";
			echo "<font class=\"option\">";
			echo "<b>"._SURE2DELHEADLINE."</b></font><br><br>";
		}
		echo "[ <a href=\"".$admin_file.".php?op=HeadlinesDel&amp;hid=$hid&amp;ok=1\">"._YES."</a> | <a href=\"".$admin_file.".php?op=HeadlinesAdmin\">"._NO."</a> ]<br><br>";
		CloseTable();
		include("footer.php");
	}

	if (!isset($ok)) { $ok = ""; }
	if (!isset($de)) { $de = ""; }

	switch($op) {

		case "BlocksAdmin":
			BlocksAdmin();
			break;

		case "BlocksAdd":
			BlocksAdd($title, $content, $url, $bposition, $active, $refresh, $headline, $blanguage, $blockfile, $view, $expire, $action, $subscription);
			break;

		case "BlocksEdit":
			BlocksEdit($bid);
			break;

		case "BlocksEditSave":
			BlocksEditSave($bid, $bkey, $title, $content, $url, $oldposition, $bposition, $active, $refresh, $weight, $blanguage, $blockfile, $view, $expire, $action, $subscription, $moretime);
			break;

		case "ChangeStatus":
			ChangeStatus($bid, $ok, $de);
			break;

		case "BlocksDelete":
			BlocksDelete($bid, $ok);
			break;

		case "BlockOrder":
			BlockOrder ($weightrep,$weight,$bidrep,$bidori);
			break;

		case "HeadlinesDel":
			HeadlinesDel($hid, $ok);
			break;

		case "HeadlinesAdd":
			HeadlinesAdd($xsitename, $headlinesurl);
			break;

		case "HeadlinesSave":
			HeadlinesSave($hid, $xsitename, $headlinesurl);
			break;

		case "HeadlinesAdmin":
			HeadlinesAdmin();
			break;

		case "HeadlinesEdit":
			HeadlinesEdit($hid);
			break;

		case "fixweight":
			fixweight();
			break;

		case "block_show":
			block_show($bid);
			break;

		case "save_blocks_change":
			save_blocks_change();
			break;

		case "block_ADD":
			block_ADD();
			break;

		case "bl_quick_delete":
			bl_quick_delete();
			break;


	}

} else {
	echo "Access Denied";
}

?>