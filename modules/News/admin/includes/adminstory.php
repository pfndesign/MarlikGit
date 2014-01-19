<?php
/**
 *
 * @package news'adminstory  														
 * @version $Id: adminstory.php 9:50 AM 7/29/2010 Aneeshtan & JAMES $						
 * @copyright (c) Nukelearn Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

/**
 * @ignore
 */

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
define("AutoSave",true);

$editor = true;
include("header.php");
GraphicAdmin();

if (defined("AutoSave")) {

	$draft_check = $db->sql_query("SELECT sid FROM ".$prefix."_stories WHERE title='draft' AND hometext='' ");
	if($db->sql_numrows($draft_check)> 0){
		list($story_id)= $db->sql_fetchrow($draft_check);
		$nfy_msg= _DRAFT_EXISTS;
	}else {
		$que = $db->sql_query("insert into ".$prefix."_stories (title,time,approved,section) VALUES('draft','0','3','news')");
		$story_id = mysql_insert_id();
		if ($que) {	$nfy_msg= _DRAFT_SAVED;	}

	}

	?>
	<script type="text/javascript">
	$(document).ready(function(){
		autosave();
		$('form').submit(function() {
			var title = $("#subject").val();
			if (title.length >0){
				return true;
			}
			else{
				alert("<?PHP echo _ARTICLE_TITLE_EMPTY ?>");
				return false;
			}
		});

	});

	function autosave()
	{
		var t = setTimeout("autosave()", 60000);

		var title = $("#subject").val();
		var hometext = escape(CKEDITOR.instances.hometext.getData());
		var phometext = hometext.length *100;
		var bodytext = escape(CKEDITOR.instances.bodytext.getData());
		var catid = $("#catid").val();
		var newsrefrence = $("#newsrefrence").val();
		var newsrefrencelink = $("#newsrefrencelink").val();
		var topic = $("#topic").val();
		var notes = $("#notes").val();
		var alanguage = $("#alanguage").val();
		var tags = $("#tags").val();

		var editorcontent = CKEDITOR.instances['hometext'].getData().replace(/&nbsp;<[^>]*>/gi, "");
		if (editorcontent.length > 10){

			$.ajax(
			{
				type: "POST",
				url: "<?php echo $ADMIN_OP?>autosave&",
				data: "story_id=" + '<?php echo $story_id?>' + "&title=" + title + "&hometext="
				+ hometext + "&bodytext=" + bodytext
				+ "&catid=" + catid  + "&newsrefrence=" + newsrefrence
				+ "&newsrefrencelink=" + newsrefrencelink+ "&topic=" + topic
				+ "&notes=" + notes + "&alanguage=" + alanguage + "&tags=" + tags  ,
				cache: false,
				success: function(message)
				{
					$("#timestamp").fadeIn("slow");
					$("#timestamp").empty().append(message);
				}
			});
		}
		return false;
	}
	</script>

<?php
}
?> <div style="clear:both;"></div> <?php
jq_show_info('info','800','15500');
if ($nfy_msg) {echo "<div id='info' class='notify' style='display:none;direction:ltr'>$nfy_msg</div>";}

echo "<center><h2><b>"._ARTICLEADMIN."</b></h2></center>";

$today = getdate();
$tday = $today[mday];
if ($tday < 10){
	$tday = "0$tday";
}
$tmonth = $today[month];
$ttmon = $today[mon];
if ($ttmon < 10){
	$ttmon = "0$ttmon";
}
$tyear = $today[year];
$thour = $today[hours];
if ($thour < 10){
	$thour = "0$thour";
}
$tmin = $today[minutes];
if ($tmin < 10){
	$tmin = "0$tmin";
}
$tsec = $today[seconds];
if ($tsec < 10){
	$tsec = "0$tsec";
}
$date = "$tyear-$ttmon-$tday $thour:$tmin:$tsec";
$date = hejridate($date, 4, 7);


echo "<table width='100%' style='overflow:auto;'><tr><td style='width:70%;vertical-align:top;padding:5px;'>";

OpenTable();
echo "<center><h2>"._ADDARTICLE."</h2></center>";
echo"<form name=\"news\" id='SubmitStory' action=\"".$admin_file.".php\"  method=\"post\" style='padding:8px;'>";

//*--------story textareas ------------------

echo"<div id=\"timestamp\"></div>
		<br><b>"._TITLE."</b><br>"
."<input type=\"text\" name=\"subject\"  id=\"subject\" size=\"50\" style='font-size:17px;font-family:arial;padding:4px;width:500px;border:1px solid #fff'><br><br>"
. "<b>"._STORYTEXT."</b><br><div style='display:block;position:relative;overflow:hidden;'>";
//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"hometext\" style=\"width:100%\"></textarea>"

wysiwyg_textarea('hometext', '', 'PHPNukeAdmin', 50, 20);

echo "<br><br><b>"._EXTENDEDTEXT."</b><br>";
//."<textarea wrap=\"virtual\" cols=\"50\" rows=\"20\" name=\"bodytext\" style=\"width:100%\"></textarea>"
wysiwyg_textarea('bodytext', '', 'PHPNukeAdmin', 50, 20);

echo "</div>";


//*--------story category ------------------
define("TOPIC_TABLE","".$prefix."_topics");
require_once("includes/inc_menuBuilder.php");
$newscategory ="<br><b>"._TOPIC."</b>  ";
$menu = new MenuBuilder();
/*---------------MENU CONFIG -----------*/
$sql = 'select * from '.TOPIC_TABLE.' order by topicname,parent asc limit 500';
$column_ID = 'topicid';
$column_TITLE = 'topicname';
$column_parent = 'parent';
$ui_id = 'categories';
/*--------------------------------------*/
$newscategory  .= $menu->get_menu_data($sql,$link,$column_ID,$column_parent,$column_TITLE,$ui_id,'','checkbox');
$newscategory  .= $menu->get_menu_html(0);

global $currentlang;
echo  "\n".'<link rel="stylesheet" href="modules/Topics/includes/jquery.treeview'.($currentlang=="persian" ? ".rtl" : "").'.css" />'. "\n";
?>	<script src="modules/Topics/includes/jquery.treeview.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#categories").treeview({
			animated: "fast",
			persist: "location",
			collapsed: true,
			unique: true
		});
	});
	</script>
<?php
$newscategory .= "<br><a href='javascript:#add_topic_' onclick=\"$('#add_box').slideToggle(300)\">
<img src='images/add.gif' alt='"._ADDTOPIC."'  title='"._ADDTOPIC."'> + "._ADDTOPIC."
</a>
<div id='add_box' style='display:none' ><br>".quick_topic_add()."</div>";


//*--------language ------------------*/

if ($multilingual == 1) {
	$newslanguage .= "<br><b>"._LANGUAGE.": </b>"
	."<select name=\"alanguage\" id=\"alanguage\">";
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
		if(!empty($languageslist[$i])) {
			$newslanguage .= "<option value=\"$languageslist[$i]\" ";
			if($languageslist[$i]==$language)
			$newslanguage .= "selected";
			$newslanguage .= ">".ucfirst($languageslist[$i])."</option>\n";
		}
	}
	$newslanguage .= "<option value=\"\">"._ALL."</option></select>";
} else {
	$newslanguage .= "<input type=\"hidden\" name=\"alanguage\" value=\"$language\">";
}


//*--------story tags ------------------
$tags = ""._TAGS."".$tag->input_tags('tags',false);
//*--------story reference ------------------

$reference = "<b>"._NEWSREFRENCE."</b><br>"
."<input type=\"text\" name=\"newsrefrence\" id=\"newsrefrence\"><br><br>"
."<b>"._NEWSREFRENCELINK."</b><br>"
."<input dir='ltr' type=\"text\" name=\"newsrefrencelink\" id=\"newsrefrencelink\" value=''>";


//*--------Progamming Story ------------------
$programstory ="<b>"._PROGRAMSTORY."</b><br>";
$programstory .='<input type="radio" name="automated" id="automated" value="1" onclick="document.getElementById(\'prost\').style.display= \'\';" />'._YES.'
    	 <input type="radio" name="automated"  id="automated" value="0" checked onclick="document.getElementById(\'prost\').style.display= \'none\';" />'._NO.'<br>';
$programstory .="<span id='prost' style='display:none'>"._NOWIS.": $date<br><br>";
$date = date("Y-m-d");
$date = hejridate($date, 1, 8);
$date_temp = explode("-", $date);
$day = $date_temp[2];
$month = $date_temp[1];
$programstory .= ""._DAY." : ";
$programstory .= get_hejri_day($month, "day", $day);
$programstory .= ""._UMONTH." : ";
$programstory .= get_hejri_month("month", $month);

$year = $date_temp[0];
$programstory .= ""._YEAR.": <input type=\"text\" dir=\"ltr\" name=\"year\" value=\"$year\" size=\"5\" maxlength=\"4\"><br><br>
		"._HOUR.": <select name=\"hour\">";
$hour = 0;
$cero = "0";
while ($hour <= 23) {
	$dummy = $hour;
	if ($hour < 10) {
		$hour = "$cero$hour";
	}
	if($hour == date("H")) $slct = "SELECTED"; else $slct = "";
	$programstory .= "<option name=\"hour\" $slct>$hour</option>";
	$hour = $dummy;
	$hour++;
}
$programstory .= "</select>"
.": <select name=\"min\">";
$min = 0;
while ($min <= 59) {
	if($min <= date('i') and date('i') < $min+5) $slct = "SELECTED"; else $slct = "";
	if (($min == 0) OR ($min == 5)) {
		$min = "0$min";
	}
	$programstory .= "<option name=\"min\" $slct>$min</option>";
	$min = $min + 5;
}
$programstory .= "</select></span>";

//*--------Choosing Section ------------------
$storysection = ""._STORY_SECTION_SELECT." : "
."<select  name=\"section\">"
."<option value=\"news\">"._STORY_NEWS."</option>"
//."<option value=\"content\">"._STORY_CONTENT."</option>"
."<option value=\"message\">"._STORY_ADMIN_MESSAGE."</option>"
//."<option value=\"expage\">"._STORY_EXPAGE."</option>"
."</select><br>";

//*--------Story Notes ------------------
$newsnotes = "<b>"._NOTES."</b><br>"
."<textarea  name=\"notes\" id=\"notes\" wrap=\"virtual\" cols=\"40\" rows=\"3\" ></textarea>";

//*--------Story Poll ------------------

if($_COOKIE['POLL_DIV'])	{if($_COOKIE['POLL_DIV'] == 'hidden'){
	$POLL_STYLE = " style=\"display:none;\"";$POLL_STYLE_IMG = "images/icon/shape_flip_horizontal.png";}
	else{$POLL_STYLE = "";$POLL_STYLE_IMG = "images/icon/shape_flip_horizontal.png";	}}
	else{$POLL_STYLE = " style=\"display:none;\"";$POLL_STYLE_IMG = "images/icon/shape_flip_vertical.png";}
	echo "<br><div><a href=\"javascript:expand('POLL_DIV','item2');\" onclick=\"$('#POLL_DIV').slideToggle(300)\"><img id=\"item2\" src=\"$POLL_STYLE_IMG\" /><b>"._ATTACHAPOLL."</b></a>";
	echo '<div id="POLL_DIV" '.$POLL_STYLE.' ><hr>';
	putpoll($pollTitle, $optionText);
	echo "</div><br>";

	//*--------Publishing Setting ------------------
	$publishnews ="<div style='text-align:center;'>";
	$publishnews .= "&nbsp;&nbsp;<input type=\"hidden\" name=\"op\" value=\"PostAdminStory\">
			<input type=\"hidden\" name=\"story_id\" value=\"$story_id\">"
	."<input type=\"submit\" value=\""._POSTSTORY."\"><div>";

	CloseTable();

	//-------- sider for plugins -----------//

	echo "</td><td style='width:20%;vertical-align:top;'>";


	OpenTable();

	puthome($ihome, $acomm, 0);
	admin_block($storysection);
	admin_block($publishnews);
	//SelectCategory($cat);
	admin_block($newscategory);
	admin_block($newslanguage);
	admin_block($tags);
	admin_block($reference);
	admin_block($newsnotes);
	admin_block($programstory);

	CloseTable();

	echo "</dt></tr></table>";

	echo "</form>";

	include ('footer.php');
?>