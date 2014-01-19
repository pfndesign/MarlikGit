<?php

/**
 *
 * @package YA admin Functions												
 * @version $Id: Aneeshtan $4:43 PM 8/10/2010
 * @copyright (c) Nukelearn Group  http://www.nukelearn.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

if (stristr($_SERVER['SCRIPT_NAME'], "functions.php")) {
    header("Location: ../../../index.php");
    die ();
}


function fl_quick_delete() {
		global $prefix,$db;
		if(isset($_GET['fid']))
		{
			$fid = sql_quote($_GET['fid']);
			$row = $db->sql_fetchrow($db->sql_query("select bposition, weight from ".$prefix."_cnbya_field where fid='".$_GET['fid']."'"));
			$bposition = check_html($row['bposition'], "nohtml");
			$weight = intval($row['weight']);
			$result2 = $db->sql_query("select fid from ".$prefix."_cnbya_field where pos>'$weight'");
			while ($row2 = $db->sql_fetchrow($result2)) {
				$nbid = intval($row2['fid']);
				$db->sql_query("update ".$prefix."_cnbya_field set pos='$weight' where fid='$nbid'");
				$weight++;
			}
			$db->sql_query("delete from ".$prefix."_cnbya_field where fid='".$_GET['fid']."'");

		}else {
			die("no id recieved");
		}
	}
function save_field_change(){

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

		global $db;
		foreach($data->items as $item)
		{
			//Extract id of the panel
			$widget_id=preg_replace('/[^\d\s]/', '', $item->id);
			$sql="UPDATE nuke_cnbya_field SET  pos='".$item->order."' , need='1' WHERE fid='".$widget_id."'";
			$db->sql_query($sql) or die('مشکلی در ذخیره اطلاعات <br>
'.$widget_id.'');

			if ($item->column == "i") {
				$sql="UPDATE nuke_cnbya_field SET need='0' WHERE fid='".$widget_id."'";
				$db->sql_query($sql) or die('مشکلی در ذخیره اطلاعات <br>
'.$widget_id.'');
			}
			if ($item->column == "l") {
				$sql="UPDATE nuke_cnbya_field SET need='3' WHERE fid='".$widget_id."'";
				$db->sql_query($sql) or die('مشکلی در ذخیره اطلاعات ');
			}
			if ($item->column == "r") {
				$sql="UPDATE nuke_cnbya_field SET need='2' WHERE fid='".$widget_id."'";
				$db->sql_query($sql) or die('مشکلی در ذخیره اطلاعات ');
			}

		}
		echo "<div class=\"notify\" >ترتیب ورودی ها منظم شد <br>
<b>".date('h:i:s A') ."</b>
</div>";

	}


?>