<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1))
{
	global $db, $prefix;
	
	$pagetitle = ": "._USERADMIN." - "._EDITTOS;
	include("header.php");
    GraphicAdmin();
	title(_USERADMIN." - "._EDITTOS);
	amain();
	echo "<br />\n";
	if ($submit)
	{
		$time = date("Y-m-d H:i");
		$sql = $db->sql_query("insert into ".$prefix."_cnbya_tos VALUES ('', '$newdata', '$status', '$pdes', '$tlanguage', '$time')");
		if (!$sql)
		{
			echo("<P>" . _YATOSERR . "" .
			mysql_error() . "</P>");
			exit();
		}
		OpenTable();
		echo("<center><p><h4>" . _YATOSCREATED . "</h4></p></center>");
		$page = "".ADMIN_OP."tosMain";
		echo ("<br /><center>" . _YATOSREFRESH . "</center>");
		CloseTable();
		?>
		<script language="Javascript" type="text/javascript">
		<!--
		function gotoThread() {
		window.location.href="<?php print $page ?>";
		}
		window.setTimeout("gotoThread()", 3000);
		//-->
		</script>
		<?php
	}
	else
	{

		OpenTable();
		echo "<form action=\"".ADMIN_OP."mod_users\" method=\"post\">"
			."<p>&nbsp;</p>"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
			."<tr>";
	    if ($multilingual == 1)
	    {
			echo "<td>" . _YATOSLANG . ":</td>"
				."<td>"
				."<select name=\"tlanguage\">";
			$handle=opendir('language');
			while ($file = readdir($handle))
			{
			    if (preg_match("/^lang\-(.+)\.php/", $file, $matches))
			    {
			        $langFound = $matches[1];
			        $languageslist .= "$langFound ";
			    }
			}
			closedir($handle);
			$languageslist = explode(" ", $languageslist);
			sort($languageslist);
			for ($i=0; $i < sizeof($languageslist); $i++)
			{
			    if($languageslist[$i]!="")
			    {
					echo "<option value=\"$languageslist[$i]\" ";
			    	if($languageslist[$i]==$currentlang) echo "selected";
					echo ">".ucfirst($languageslist[$i])."</option>\n";
			    }
			}
			echo "</select>";
    	}
    	else
    	{
    		echo "<input type=\"hidden\" name=\"tlanguage\" value=\"$language\">"
				."<td>&nbsp;</td>"
				."<td>&nbsp;";
    	}
		echo "</td>"
			."</tr>"
			."<tr>"
			."<td width=\"16%\">&nbsp;</td>"
			."<td>&nbsp;</td>"
			."</tr>"
			."<tr>"
			."<td width=\"16%\">" . _YATOSDESCR . ":</td>"
			."<td><input name=\"pdes\" type=\"text\" id=\"pdes\" size=\"100\" maxlength=\"100\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this); /> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(pdes)></td>"
			."</tr>"
			."<tr><td colspan=\"2\">&nbsp;</td></tr>"
			."<tr valign=\"top\">"
			."<td width=\"16%\">" . _YATOSTEXT . ":</td>"
			."<td width=\"84%\"> <textarea name=\"newdata\" wrap=\"virtual\" cols=\"100%\" rows=\"50%\" style=\"width:100%\">$pdata</textarea></td>"
			."</tr>"
			."<tr>"
			."<td width=\"16%\">" . _YATOSACTIVATE . ":</td>"
			."<td width=\"84%\"><input name=\"status\" type=\"checkbox\" id=\"status\" value=\"1\" /></td>"
			."</tr>"
			."<tr>"
			."<td width=\"16%\">&nbsp;</td>"
			."<td width=\"84%\"><input type=\"hidden\" name=\"op\" value=\"tosNew\" />"
			."<input type=\"submit\" name=\"submit\" value=\"" . _YATOSADD . "\" /></td>"
			."</tr>"
			."</table>"
			."</form>";
		CloseTable();
		include ("footer.php");
	}
}

?>