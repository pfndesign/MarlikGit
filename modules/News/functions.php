<?php

/**
*
* @package News Module	 - Functions													
* @version $Id:  6:23 PM 1/8/2010  REVISION Aneeshtan $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/

if ( !defined('MODULE_FILE') )
{
	die("You can't access this file directly...");
}
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));



function news_pagination($totalnum,$pagin_mod,$value=""){

	global $storyhome,$pagenum;
	
	$storyhome = (empty($storyhome) ? 5 : $storyhome);
	$eachsidenum = 1;// How many adjacent pages should be shown on each side?
	$totalnum = intval($totalnum);
	$numpages = ceil($totalnum / $storyhome);
	$lpm1 = $numpages - 1;
	

	if ($numpages > 1) {

		OpenTable();

		echo "<div style=\"text-align: center;\">";

		if ($pagin_mod==2 or $pagin_mod==3 ){

			$prevpage = $pagenum - 1 ;
			$leftarrow = "images/right.gif" ;
			if(isset($new_topic)) {
				echo "<a href=\"modules.php?name=News&new_topic=$new_topic&pagenum=$prevpage\">";
				echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			} else {
				echo "<a href=\"modules.php?name=News&pagenum=$prevpage\">";
				echo "<img src=\"$leftarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
			}
		}

		if ($pagin_mod==1 or $pagin_mod==3 ){
			echo "<select name='$i' onChange='top.location.href=this.options[this.selectedIndex].value'> ";
			for ($i=1; $i < $numpages+1; $i++) {
				if ($i > $min){
					if(isset($new_topic)) {
						echo "<option value=\"modules.php?name=News&new_topic=$new_topic&pagenum=$i\">$i</option>";
					} else {
						echo "<option value=\"modules.php?name=News&pagenum=$i\">$i</option>";
					}
				}
			}
			echo "</select>" ;
		}


		if ($pagin_mod==2 or $pagin_mod==3){
			if ($pagenum < $numpages) {
				$nextpage = $pagenum + 1 ;
				$rightarrow = "images/left.gif" ;
				if(isset($new_topic)) {
					echo "<a href=\"modules.php?name=News&new_topic=$new_topic&pagenum=$nextpage\">";
					echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				} else {
					echo "<a href=\"modules.php?name=News&pagenum=$nextpage\">";
					echo "<img src=\"$rightarrow\" align=\"absmiddle\" border=\"0\" hspace=\"10\"></a>";
				}
			}
		}

		if ($pagin_mod==4 OR $pagin_mod==5  OR $pagin_mod==6 OR $pagin_mod==7  ){
			$prevpage = $pagenum - 1 ;
			$nextpage = $pagenum + 1 ;

			if ($pagin_mod==5) {
				$link = "modules.php?name=News&file=categories&amp;category=$value&pagenum";
			}elseif ($pagin_mod==6){
				$link = "modules.php?name=News&file=tags&amp;tag=$value&pagenum";
			}elseif ($pagin_mod==7){
				$link = "modules.php?name=News&file=article&sid=$value&pagenum";
			}else {
				$link ="modules.php?name=News&new_topic=$new_topic&pagenum";
			}
			
			echo "<div id='pagination-digg' >";

			if ($prevpage ==0 ) {
				echo '<a class="off">صفحه قبل  »</a>';
			}else {
				echo "<a href=\"$link=$prevpage\">صفحه قبل  »</a>";
			}


			if ($numpages < 7 + ($eachsidenum * 2))	//not enough pages to bother breaking it up
			{
				for ($counter = 1; $counter <= $numpages; $counter++)
				{
					if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
					else
					echo "<a href=\"$link=$counter\"  >&nbsp;$counter&nbsp;</a>";
				}

			}
			elseif($numpages > 5 + ($eachsidenum * 2))	//enough pages to hide some
			{			if($pagenum < 1 + ($eachsidenum * 2))
			{
				for ($counter = 1; $counter < 4 + ($eachsidenum * 2); $counter++)
				{
					if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
					else
					echo "<a href=\"$link=$counter\">&nbsp;$counter&nbsp;</a>";
				}
				echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				echo "<a href=\"$link=$lpm1\"  >&nbsp;$lpm1&nbsp;</a>";
				echo "<a href=\"$link=$numpages\" >&nbsp;$numpages&nbsp;</a>";
			}
			elseif($numpages - ($eachsidenum * 2) > $pagenum && $pagenum > ($eachsidenum * 2))
			{
				echo "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
				echo "<a href=\"$link=2\"  >&nbsp;2&nbsp;</a>";
				echo "&nbsp; <a href=\"\">&nbsp; ... &nbsp;</a>&nbsp;";
				for ($counter = $pagenum - $eachsidenum; $counter <= $pagenum + $eachsidenum; $counter++)
				{
					if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
					else
					echo "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
				}
				echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				echo "<a href=\"$link=$lpm1\" >&nbsp;$lpm1&nbsp;</a>";
				echo "<a href=\"$link=$numpages\" >&nbsp;$numpages&nbsp;</a>";
			}
			//close to end; only hide early pages
			else
			{
				echo "<a href=\"$link=1\" >&nbsp;1&nbsp;</a>";
				echo "<a href=\"$link=2\" >&nbsp;2&nbsp;</a>";
				echo "&nbsp; <a href=\"\"> &nbsp; ... &nbsp; </a>&nbsp;";
				for ($counter = $numpages - (2 + ($eachsidenum * 2)); $counter <= $numpages; $counter++)
				{
					if ($counter == $pagenum)
					echo "<a href=\"$link=$counter\" class=\"active\">&nbsp;$counter&nbsp;</a>";
					else
					echo "<a href=\"$link=$counter\" >&nbsp;$counter&nbsp;</a>";
				}
			}
			}

			if ($nextpage > $numpages ) {
				echo '<a class="off">« صفحه بعد';
			}else {
				echo "<a href=\"$link=$nextpage\">« صفحه بعد</a>";
			}

			echo "</div>";
		}
		echo "<br>"._STORIES." $totalnum ($numpages "._PAGES." | "._PERPAGE." $storyhome)";
		echo "</div>";
		CloseTable();

	}
}


?>