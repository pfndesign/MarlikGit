<?php
/**
 *
 * @package Google tab source														
 * @version  inc_nextGenTap.php $Id: beta6 $ 2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
 *
 */
if (stristr ( htmlentities ( $_SERVER ['PHP_SELF'] ), "inc_nextGenTap.php" )) {
	show_error ( HACKING_ATTEMPT );
}
if ($nextg==1) {
	$nextGenOb = 1;
}else{
	$nextGenOb = 0;
}

include_once(CORE_INCLUSION."google/Universal.php");		
	
$nextGenMainPath = "google/".$_REQUEST['name']; //<-- Name of Directory to GoogleTap
$uniGenPath = "google/Universal.php"; //<-- Name of Directory to GoogleTap
$nextGenBlock = 1; //<-- Enable Auto-Convert on Blocks
$nextGenAdmin = is_admin($admin); //<-- Do NOT Touch!

function nextGenTap($nextGenHead, $nextGenFoot, $nextGenContents) {
	global $prefix, $db, $admin,$name,$uniGenPath,$nextGenOb, $nextGenDebug, $nextGenMainPath, $nextGenBlock, $nextGenAdmin;
	
	
if($nextGenOb == 1) {
		
	// HEADER
	if ($nextGenHead == 1) {
			ob_start();
			return;
	}
	
	// FOOTER
	if ($nextGenFoot == 1) {

			$getNextGen = ob_get_contents();
			$getNextGen = preg_replace("(&(?!([a-zA-Z]{2,6}|[0-9\#]{1,6})[\;]))", "&amp;", $getNextGen);
			$getNextGen = str_replace(array("&amp;", "&amp;&amp;", "&amp;middot;", "&amp;nbsp;"), array("&", "&&", "&middot;", "&nbsp;"), $getNextGen);
			ob_end_clean();
			include_once(CORE_INCLUSION."google/Universal.php");		
			
			//include module
			if(file_exists(nextGenMainPath)){
				include_once(nextGenMainPath);
			}
			
			global $urlin,$urlout;
			//print_r($uurlout);
			$nextGenContent = preg_replace($urlin, $urlout, $getNextGen);
			die($nextGenContent);
			return;
	}
		return $nextGenContents;

		
	} else {
		return $nextGenContents;
	}
}

?>