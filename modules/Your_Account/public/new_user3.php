<?php
if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php")) {
	header("Location: ../../../index.php");
	die ();
}
if (!defined('CNBYA')) { echo "CNBYA protection"; exit; }

define ("PAGE",THEME_PATH."registration.html");// Define ur html page path
if (file_exists(PAGE)) {
	TE_core(PAGE);// link to Core Template Engine Constans//
}else {
	include("header.php");
	echo '<link rel="StyleSheet" href="'.INCLUDES_UCP.'style/registration.css" type="text/css" /> ';
	title(_USERREGLOGIN);
	OpenTable();

	define("MDL_LINK","modules.php?name=Your_Account");
	?>
<div id="inputArea">

<form  action="<?php echo MDL_LINK; ?>" method="post" class="niceform">
<fieldset class="w_auto">
    	<legend><?php echo _USERREGLOGIN; ?></legend>
		<label><?php echo _NICKNAME  ?> (En) : &nbsp;<font class='tiny'><?php echo '*' ?></font></label>
		<div class="w_span_auto"><input type="text" name="ya_username" id="ya_username" class="w_auto" maxlength='<?php echo $ya_config['nick_max'] ?>'/></div>
		
		<label><?php echo _UREALNAME  ?> (FA): &nbsp;<font class='tiny'><?php echo '*' ?></font></label>
		<div class="w_span_auto"><input type="text" name="ya_realname" id="ya_realname" class="w_auto"  maxlength='60' /></div>
		
		<label><?php echo _EMAIL  ?> : </label>
		<div class="w_span_auto"><input type="text" name="ya_email" id="ya_email" class="w_auto"/></div>
		
<?php 
// menelaos: added configurable doublecheck email routine
if ($ya_config['doublecheckemail']==1) {
	?>
	<label><?php echo _RETYPEEMAIL  ?>:</label>
	<div class="w_span_auto"><input type='text' name='ya_user_email2' size='40' maxlength='255' class="w_auto"></div>
	<?php
} else {
	echo "<input type='hidden' name='ya_user_email2' value='ya_user_email'>\n";
}
?>
		


		<label><?php echo _PASSWORD  ?>:</label>
		<div class="w_span_auto"><input type="password" name="ya_password" id="ya_password" class="w_auto"/></div>
		
		<label><?php echo _RETYPEPASSWORD  ?>:</label>
		<div class="w_span_auto"><input type="password" name="ya_confirm_password" id="ya_confirm_password" class="w_auto"/></div>
		
         <?php

         $result = $db->sql_query("SELECT * FROM ".$user_prefix."_cnbya_field WHERE (need = '2') OR (need = '3') ORDER BY pos");
         while ($sqlvalue = $db->sql_fetchrow($result)) {
         	$reqfield = ($sqlvalue[need] == 3 ? "&nbsp;<font class='tiny' style='color:red'>"._REQUIRED."</font>" : "");
         	$t = $sqlvalue[fid];
         	$value2 = explode("::", $sqlvalue[value]);
         	if (substr($sqlvalue[name],0,1)=='_') eval( "\$name_exit = $sqlvalue[name];"); else $name_exit = $sqlvalue[name];
         	$maxlengthfield = ($sqlvalue[size]==0 ? "" : "maxlength='$sqlvalue[size]'");    		

         	if (count($value2) == 1) {
         		echo "<label>$name_exit $reqfield</label>";
         		echo "<div class='w_span_auto'><input class='w_auto' type='text' name='nfield[$t]' size='20' $maxlengthfield></div>\n";
         	} else {
         		echo "<label>$name_exit $reqfield</label>";
         		echo "<div class='w_span_auto'><select class='w_auto' name='nfield[$t]'>\n";
         		for ($i = 0; $i<count($value2); $i++) {
         			echo "<option value=\"".trim($value2[$i])."\">".trim($value2[$i])."</option>\n";
         		}
         		echo "</select></div>\n";
         	}

         }



         if (extension_loaded("gd") AND ($gfx_chk == 3 OR $gfx_chk == 4 OR $gfx_chk == 6 OR $gfx_chk == 7)) {
         	global $wrong_code;
         	if($wrong_code)
         	echo "<div style='color:red;'>"._WRONG_CODE."</div>";
         	echo show_captcha();
         }

         echo "  <input type='hidden' name='ip' id='ip' value='$ip'>\n";
         echo "<input type='hidden' name='op' value='new_confirm'>\n";
 ?>
 	<div style="text-align:center;">
 	<input class="button" type="submit" name="submit" id="submit" value="<?PHP echo REGONNOW ?>" /></div>

 	 	
    </fieldset>
</form>
</div>
<?php 	
// <div id='insert_response' class="msg"></div>
echo "<center><font class='content'>[ <a href='modules.php?name=$module_name'>"._USERLOGIN."</a> | <a href='modules.php?name=$module_name&op=pass_lost'>"._PASSWORDLOST."</a> ]</font></center>\n";

CloseTable();
include("footer.php");

}

?>