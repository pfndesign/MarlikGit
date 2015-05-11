<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

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
//	OpenTable(); // MrFluffy
	if ($delete == "true")
	{
		$sql = "DELETE FROM ".$prefix."_cnbya_tos WHERE id='$id'";
		OpenTable();
		if ($db->sql_query($sql))
		{
			echo("<center><h4>" . _YATOSPAGE . " # $id " . _YATOSDELETED . "</h4></center>");
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
			include ("footer.php");
		}
		else
		{
			echo("$sql");
			echo("<p>" . _YATOSERR2 . ": " .
			mysql_error() . "</p>");
		}
		exit();
	}
	if ($submit)
	{
		// UPDATE PAGE DETAILS
		$sql = "UPDATE ".$prefix."_cnbya_tos SET data='$newdata', des='$pdes', status='$newstatus', language='$tlanguage' WHERE id='$id'";
		if ($db->sql_query($sql)) {
			OpenTable();
			echo("<center><p><h4>" . _YATOSPAGE . " #$id " . _YATOSUPDATED . "</h4></p></center>");
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
	
		} else {
			echo("$sql");
			echo("<p>" . _YATOSERR2 . ": " .
			mysql_error() . "</p>");
		}
	}
	else
	{
		//CHECK TO SEE IF ACTIVE ARTICAL ALREADY EXIST.
		$result1 = $db->sql_query("SELECT id, status FROM ".$prefix."_cnbya_tos WHERE status=1");
		list($cid, $cstatus) = $db->sql_fetchrow($result1);
		if ($cstatus==1)
		{
			$comment="" . _YATOSPAGE . " #$cid " . _YATOSISACTIVE . "";
		}
		else
		{
			$comment="" . _YATOSONLY . "";
		}
		// REQUEST INFO FROM DATABASE FOR MASTER ARTICLE
		$result = $db->sql_query("SELECT data,des,status,language FROM " . $prefix . "_cnbya_tos WHERE id=$id");
		list($pdata, $pdes, $status, $tlang) = $db->sql_fetchrow($result);
		OpenTable();
		echo "<form action=\"".ADMIN_OP."mod_users\" method=\"post\">"
			."<p>&nbsp;</p>"
			."<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
			."<tr>"
			."<td>TOS ID#:</td>"
			."<td>$id</td>"
			."</tr>"
			."<tr>";
	    if ($multilingual == 1)
	    {
			echo "<td width=\"16%\">" . _YATOSLANG . ":</td>"
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
			    	if($languageslist[$i]==$tlang) echo "selected";
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
		echo "</tr>"
			."<tr>"
			."<td width=\"16%\">" . _YATOSDESCR . ":</td>"
			."<td><input name=\"pdes\" type=\"text\" id=\"pdes\" value=\"$pdes\" size=\"100\" maxlength=\"100\" onkeypress=\"return farsikey(this,event)\" onkeydown=changelang(this) /> <IMG src=\"images/fa2.gif\" align=\"absbottom\" style=\"CURSOR: hand\" onclick=change(pdes)></td>"
			."</tr>"
			."<tr>"
			."<td>&nbsp;</td>"
			."<td>&nbsp;</td>"
			."</tr>"
			."<tr valign=\"top\">"
			."<td width=\"16%\">" . _YATOSTEXT . ":</td>"
			."<td width=\"84%\"> ";
			//<textarea name=\"newdata\" wrap=\"virtual\" cols=\"100%\" rows=\"50%\" style=\"width:100%\">$pdata</textarea>
			wysiwyg_textarea("newdata", "$pdata", "PHPNukeAdmin", "50", "20");
			echo"</td></tr>"
			."<tr>"
			."<td width=\"16%\">" . _YATOSACTIVATE . ":</td>"
			."<td width=\"84%\">";
		if ($status==1) {
			echo "<input name=\"newstatus\" type=\"checkbox\" id=\"newstatus\" value=\"1\" checked />$comment";
		} else {
			echo "<input name=\"newstatus\" type=\"checkbox\" id=\"newstatus\" value=\"1\" />$comment";
		}
		echo "</td>"
			."</tr>"
			."<tr>"
			."<td width=\"16%\">&nbsp;</td>"
			."<td width=\"84%\"><input type=\"hidden\" name=\"op\" value=\"tosEdit\" />"
			."<input type=\"hidden\" name=\"id\" value=\"$id\" />"
			."<input type=\"submit\" name=\"submit\" value=\"" . _YATOSUPD . "\" /></td>"
			."</tr>"
			."</table>"
			."</form>";
		CloseTable();
		include ("footer.php");
	}
}

?>