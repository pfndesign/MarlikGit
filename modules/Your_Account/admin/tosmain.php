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
	OpenTable();
	// CHANGE STATUS OF PAGES IF ACTIVATING
	if ($status=='1')
	{
		$db->sql_query("UPDATE ".$prefix."_cnbya_tos SET status='0' WHERE status='1'");
		$db->sql_query("UPDATE ".$prefix."_cnbya_tos SET status='1' WHERE id='$id'");
		OpenTable();
		echo("" . _YATOSCHGACT . "");
		$page = "".ADMIN_OP."tosEdit";
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
		exit;
	}
	// CHANGE STATUS OF PAGE TOO INACTIVE
	if ($status=='0')
	{
		$db->sql_query("UPDATE ".$prefix."_cnbya_tos SET status='0' WHERE id='$id'");
		OpenTable();
		echo("" . _YATOSCHGDEACT . "");
		$page = "/".ADMIN_PHP."?op=tosEdit";
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
		exit;
	}
	echo "<a href=\"".ADMIN_OP."tosNew\"><b>" . _YATOSNEW . "</b></a>"
		."<br />"
		."" . _YATOSMULTI . "";
	// Request info
	$result = $db->sql_query("SELECT * FROM ".$prefix."_cnbya_tos ORDER BY status");
	if (!$result)
	{
		echo("<p>" . _YATOSERR1 . ": " .
		mysql_error() . "</p>");
		exit();
	}
	// Display the text
	while ( $row = $db->sql_fetchrow($result) )
	{
		$pid=$row["id"];
		$pdata=$row["data"];
		$pstat=$row["status"];
		$pdes=$row["des"];
		$time=$row["time"];
		$tlang=$row['language'];
		if ($pstat==1)
		{
			$comstat=" " . _YATOSDEACTIVATE . " ";
			$comstatnum="0";
		}
		else
		{
			$comstat=" " . _YATOSACTIVATE . " ";
			$comstatnum="1";
		}
		echo "<br /><br />"
		."<table>"
		."<tr>"
		."<td>$pid "
		."|<a href=\"".ADMIN_OP."tosEdit&amp;id=$pid\"> <img scr='images/icon/tab_edit.png'>" . _YATOSEDIT . " </a>"
		."|<a href=\"".ADMIN_OP."tosEdit&amp;id=$pid&amp;delete=true\"><img scr='images/icon/tab_delete.png'> " . _YATOSDELETE . " </a>"
		."|<a href=\"".ADMIN_OP."tosPreview&amp;id=$pid\" target=\"_blank\"><img scr='images/icon/table_sort.png'> " . _YATOSPREVIEW . " </a>"
		."|<a href=\"".ADMIN_OP."tosEdit&amp;id=$pid&amp;status=$comstatnum\"><img scr='images/icon/table_save.png'>$comstat</a>"
		."</td>"
		."</tr>"
		."<tr>"
		."<td width=\"95%\"><b>" . _YATOSDESCR . ":</b> $pdes&nbsp;&nbsp;&nbsp;<b>" . _YATOSLANG . ":</b> $tlang</td>"
		."</tr>"
		."</table>";
	}
	CloseTable();
	include ("footer.php");
}

?>