<?php

/**
*
* @package Admin_Story general functions												
* @version $Id: functions.php RC-7  2:03 AM 1/4/2010  Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('ADMIN_FILE')) {
	die ("Access Denied");
}
function puthome($ihome, $acomm, $hotnews='0') {
	echo "<br><b>"._PUBLISHINHOME."</b>&nbsp;&nbsp;";
	if (($ihome == 0) OR (empty($ihome))) {
		$sel1 = "checked";
		$sel2 = "";
	}
	if ($ihome == 1) {
		$sel1 = "";
		$sel2 = "checked";
	}
	echo "<input type=\"radio\" name=\"ihome\" value=\"0\" $sel1>"._YES."&nbsp;"
	."<input type=\"radio\" name=\"ihome\" value=\"1\" $sel2>"._NO.""
	."&nbsp;&nbsp;<font >[ "._ONLYIFCATSELECTED." ]</font><br>";

	echo "<br><b>"._ACTIVATECOMMENTS."</b>&nbsp;&nbsp;";
	if (($acomm == 0) OR (empty($acomm))) {
		$sel1 = "checked";
		$sel2 = "";
	}
	if ($acomm == 1) {
		$sel1 = "";
		$sel2 = "checked";
	}
	echo "<input type=\"radio\" name=\"acomm\" value=\"0\" $sel1>"._YES."&nbsp;"
	."<input type=\"radio\" name=\"acomm\" value=\"1\" $sel2>"._NO."</font><br><br>";
	//@
	if (($hotnews == 0) OR (empty($hotnews))) {
		$Hsel1 = "";
		$Hsel2 = "checked";
	}
	if ($hotnews == 1) {
		$Hsel1 = "checked";
		$Hsel2 = "";
	}
	echo "<b>"._HOTNEWS."</b>&nbsp;&nbsp;";
	echo "<input type=\"radio\" name=\"hotnews\" value=\"1\" $Hsel1>"._YES."&nbsp;"
	."<input type=\"radio\" name=\"hotnews\" value=\"0\" $Hsel2>"._NO."<br><br>";
	//@
}

function putpoll($pollTitle, $optionText) {
	OpenTable();
	echo "<center><font class=\"title\"><b>"._ATTACHAPOLL."</b></font><br>"
	."<font class=\"tiny\">"._LEAVEBLANKTONOTATTACH."</font><br>"
	."<br><br>"._POLLTITLE.": <input type=\"text\" name=\"pollTitle\" size=\"50\" maxlength=\"100\" value=\"$pollTitle\"><br>"
	."<font>"._POLLEACHFIELD."<br>"
	."<table border=\"0\">";
	for($i = 1; $i <= 12; $i++)	{
		echo "<tr>"
		."<td>"._OPTION." $i:</td><td><input type=\"text\" name=\"optionText[$i]\" size=\"50\" maxlength=\"50\" value=\"$optionText[$i]\"></td>"
		."</tr>";
	}
	echo "</table>";
	CloseTable();
}

function quick_tags_add ($tgz=""){

	$t ='
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/GrowingInput.js" type="text/javascript" charset="utf-8"></script>
		<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.js" type="text/javascript" charset="utf-8"></script>		
		<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.Autocomplete.js" type="text/javascript" charset="utf-8" ></script>
		<script src="'.SCRIPT_PLUGINS_PATH.'autocomplete/TextboxList.Autocomplete.Binary.js" type="text/javascript" charset="utf-8"></script>';		
		?>
		<script type="text/javascript" charset="utf-8">		
		$(function(){
			var t4 = new $.TextboxList('#tags', {unique: true, plugins: {autocomplete: {}}});
			<?php echo $tgz?>
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


	$t .="<br>"._TAGS."<br><br><div class=\"form_friends\"><input type=\"text\"  name='tags' id='tags' size='20' value=\"\" /></div>";

	return $t ;

}

function quick_topic_add (){
	?>
	<script type="text/javascript">
	$(function(){$(".comment_button").click(function(){var c=$("#topicname").val();var a=$("#topicparent").val();var b="topicname="+c+"&topicparent="+a;if(c==""||a==""){alert("<?php echo _EMPTY_FEILD ?>")}else{$("#flash").show();$("#flash").fadeIn(400).html('<img src="images/loading.gif" align="absmiddle"><?php echo _LOADING?>');$.ajax({type:"POST",url:"<?php echo ADMIN_OP?>save_q_t_a&",data:b,cache:false,success:function(d){$("#categories").after(d);document.getElementById("topicname").value="";document.getElementById("topicparent").value="";$("#flash").hide()}})}return false})});
	</script>
	<?php
	$r =""
	."<b>"._TOPICNAME . ":</b><input type=\"text\" name=\"topicname\" id=\"topicname\" size=\"20\" maxlength=\"20\">
<img src='images/icon/help.png' title='"._TOPICNAME1 . "' width='16px' height='16px'><br>"
		.'<label>'._HEAD_CATEGORY.' : </label>' . selecttopics("","") . '<br /><br />'
		."<input type=\"submit\" value=\""._OK . "\" class=\"comment_button\">"
	.""
	.'<div id="flash"></div>';
	return $r ;

}

function selecttopics($parentID,$parentName)
{
	global $prefix, $db;
	$result = $db->sql_query("SELECT * from " .
	$prefix . "_topics order by topicname");

	$selCats = '<select name="topicparent" id="topicparent">';
	if (!empty($parentID)) {
		$selCats .= '<option value="'.$parentID.'" selected>' . $parentName . '</option>';
	}
	$selCats .='<option value="0">'._NONE.'</option>';
	while ($row = $db->sql_fetchrow($result))
	{
		$topicid = intval($row['topicid']);
		$parent = intval($row['parent']);
		$topicname = check_html($row['topicname'], "nohtml");
		$topicimage = check_html($row['topicimage'], "nohtml");
		$topictext = check_html($row['topictext'], "nohtml");

		if (!empty($parentID)) {
			if ($topicid <> $parentID) {
				$selCats .= '<option value="'.$topicid.'">' . $topicname . '</option>';
			}
		}else {
			$selCats .= '<option value="'.$topicid.'">' . $topicname . '</option>';
		}
	}
	$selCats .= '</select>';
	$db->sql_freeresult($result);
	return $selCats;
	echo $parentID,$parentName;
}

function save_q_t_a (){
	global $db, $prefix;

	if ($_POST)
	{

		$topicparent = intval($_POST['topicparent']);
		$topicname = strip_tags($_POST['topicname']);

		if (empty($topicname))
		{
			die(_EMPTY_FEILD);
		}
		
		$num = $db->sql_numrows($db->sql_query("Select topicname FROM " . $prefix ."_topics WHERE topicname = '$topicname' "));
		if (empty($num))
		{

			$result = $db->sql_query("INSERT INTO " . $prefix . "_topics (`topicname`,`slug`,`topictext`,`parent`) VALUES ('$topicname','".Slugit($topicname)."','','$topicparent')")or die(mysql_error());


			if ($result)
			{
				echo "<span style='background:#F7F797;'>
				<input type='checkbox' name='assotop[]' value='".mysql_insert_id()."'><b>" . $topicname. "</b>&nbsp;
				</span><br>";
			}

		}else {
			die(_DUPLICATED);
		}
	}
	else
	{
		return SQL_ERROR;
	}
}
?>