<?php
/**
*
* @package FireWall												
* @version $Id: Media.php 12:42 PM 2/10/2012 Aneeshtan $						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined("ADMIN_FILE")) {show_error(HACKING_ATTEMPT);}
global $prefix,$currentlang,$db, $admin_file;
if (!defined("USV_VERSION")) {die("This only works on Nukelearn Portal ,
<br>So why don't You join us<br><a href='http://www.nukelearn.com'>nukelearn.com</a>");
}

include("header.php");
GraphicAdmin();
OpenTable();
if (is_superadmin($admin)) {
		
if($_REQUEST['confirm']){
		
		$db->sql_query("
		UPDATE nuke_nsnst_config SET 
		config_value = ''
		
		");
		
}


$result = $db->sql_query("SELECT * FROM nuke_guardian");
$fw_array = array();
while($fw_row = $db->sql_fetchrow($result)){
		$fw_array[] = $fw_row;
}


//print_r($fw_array);
echo $fw_array['admin_contact']['config_value'] ;
		?>
		<form action="" method="POST">
		<h3> <?php echo _FIREWALL_CONFIG?> </h3> 
		
		<fieldset>
		<p><label><?php echo _FIREWALL_ACTIVE?></label>
		<select name='site_switch'> 
		<option value='0' <?php echo ($site_switch == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($site_switch == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
			
			
				
		<p><label><?php echo _FIREWALL_EMAILCONFIRM?></label>
		<select name='fw_pushmail'> 
		<option value='0' <?php echo ($fw_pushmail == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_pushmail == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_EMAIL?></label><input type="text" name="admin_contact" value="<?php echo $admin_contact?>"></p>

		<p><label><?php echo _FIREWALL_LOG?></label><input type="text" name="fw_logfile" value="<?php echo $_FIREWALL_LOG?>"></p>

				
		<p><label><?php echo _FIREWALL_GLOBAL?></label>
		<select name='fw_globals'> 
		<option value='0' <?php echo ($fw_globals == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_globals == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		</fieldset>
		<fieldset>
		<h3><?php echo _FIREWALL_IP?></h3>
				
		<p><label><?php echo _FIREWALL_IPRANGEBAN?></label>
		<select name='fw_ipdeny'> 
		<option value='0' <?php echo ($fw_ipdeny == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_ipdeny == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		<p><label><?php echo _FIREWALL_IPRANGESPAM?></label>
		<select name='fw_ipspam'> 
		<option value='0' <?php echo ($fw_ipspam == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_ipspam == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>

		<p><label><?php echo _FIREWALL_OVH_IP?></label>
		<select name='fw_ovh_ip'> 
		<option value='0' <?php echo ($fw_ovh_ip == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_ovh_ip == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		<p><label><?php echo _FIREWALL_KIMSUFI_IP?></label>
		<select name='fw_kimsufi_ip'> 
		<option value='0' <?php echo ($fw_kimsufi_ip == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_kimsufi_ip == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		<p><label><?php echo _FIREWALL_DEDIBOX_IP?></label>
		<select name='fw_dedibox_ip'> 
		<option value='0' <?php echo ($fw_dedibox_ip == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_dedibox_ip == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		<p><label><?php echo _FIREWALL_DIGICUBE_IP?></label>
		<select name='fw_digicube_ip'> 
		<option value='0' <?php echo ($fw_digicube_ip == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_digicube_ip == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		
		</fieldset>
		<fieldset>

				
		<h3><?php echo _FIREWALL_OTHER?></h3>		
		

		<p><label><?php echo _FIREWALL_URL?></label>
			<select name='fw_url'> 
		<option value='0' <?php echo ($fw_url == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_url == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		

		<p><label><?php echo _FIREWALL_REQUEST_SERVER?></label>
		<select name='fw_reqserver'> 
		<option value='0' <?php echo ($fw_reqserver == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_reqserver == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_FLOOD?></label>
		<select name='fw_flood'> 
		<option value='0' <?php echo ($fw_flood == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_flood == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>


		<p><label><?php echo _FIREWALL_VISITTIME?></label><input type="text" name="fw_floodtime" value="<?php echo $fw_floodtime?>"></p>
		
		
		<p><label><?php echo _FIREWALL_SANTY?></label>
		<select name='fw_santy'> 
		<option value='0' <?php echo ($fw_santy == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_santy == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_BOTS?></label>
		<select name='fw_bots'> 
		<option value='0' <?php echo ($fw_bots == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_bots == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_RQUESTMETHOD?></label>
		<select name='fw_rqmethod'> 
		<option value='0' <?php echo ($fw_rqmethod == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_rqmethod == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_DDOS?></label>
		<select name='fw_dos'> 
		<option value='0' <?php echo ($fw_dos == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_dos == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_SQL?></label>
		<select name='fw_unionsql'> 
		<option value='0' <?php echo ($fw_unionsql == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_unionsql == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_CLICK?></label>
		<select name='fw_click'> 
		<option value='0' <?php echo ($fw_click == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_click == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_XSS?></label>
		<select name='fw_xss'> 
		<option value='0' <?php echo ($fw_xss == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_xss == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_COOKIES?></label>
		<select name='fw_cookies'> 
		<option value='0' <?php echo ($fw_cookies == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_cookies == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_POST?></label>
		<select name='fw_post'> 
		<option value='0' <?php echo ($fw_post == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_post == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_GET?></label>
		<select name='fw_get'> 
		<option value='0' <?php echo ($fw_get == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_get == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_OVH?></label>
		<select name='fw_ovh'> 
		<option value='0' <?php echo ($fw_ovh == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_ovh == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		<p><label><?php echo _FIREWALL_KIMSUFI?></label>
		<select name='fw_kimsufi'> 
		<option value='0' <?php echo ($fw_kimsufi == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_kimsufi == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		<p><label><?php echo _FIREWALL_DEDIBOX?></label>
		<select name='fw_dedibox'> 
		<option value='0' <?php echo ($fw_dedibox == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_dedibox == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		<p><label><?php echo _FIREWALL_DIGICUBE?></label>
		<select name='fw_digicube'> 
		<option value='0' <?php echo ($fw_digicube == 0 ? "SELECTED" : "")?> > <?php echo _FIREWALL_DISABLE?> </option>
		<option value='1'<?php echo ($fw_digicube == 1 ? "SELECTED" : "")?> > <?php echo _ACTIVE?> </option>
		</select>
		</p>
		
		
		
		
		
		<input type="hidden" name="confirm" value="1">
		</form>
		
		
		
		<?php
		
		
}else{
echo _ADMIN_YOUARENOT;	
}
CloseTable();
include("footer.php");

?>