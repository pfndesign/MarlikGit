<?php

/** @package your_account admin files	12:59 AM 1/12/2010  Nukelearn $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


function this_field($fid,$name,$pos){
	$block_view ='
							<div class="widget" id="item'.$fid.'" >
								<div class="widget-top movable" >
										<div class="widget-title-action">
											<a class="widget-action hide-if-no-js"></a>
											<a class="widget-control-edit hide-if-js"></a>
									</div>
										<div class="widget-title" id="weight'.$pos.'">
											<h4>'.$name.'<span class="in-widget-title"></span></h4> <span style="float:left;margin:-4px;vertical-align:top"><a href="javascript:void(0)" class="jqdelete"><img src="images/delete.gif" alt="'._DELETE.'" title="'._DELETE.'" border="0" width="17" height="17"></a></span>
										</div>
									</div>
							</div>';
	print $block_view ;
}

if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ":  مدیریت ورودی اطلاعات ";
    include("header.php");
	GraphicAdmin();
    amain();
    echo "<br>\n";
?>
<link rel='stylesheet' href="modules/Your_Account/includes/style/YAregpanel.css">
<script type="text/javascript" src="includes/javascript/jquery/src/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="includes/javascript/jquery/src/jquery.json-2.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){$(".jqdelete").click(function(b){b.preventDefault();var a=$(this).parents("div.widget");if(confirm("آیا از حذف این مورد اطمینان دارید ؟")){$.ajax({type:"GET",url:"<?php echo ADMIN_OP; ?>fl_quick_delete",data:"fid="+a.attr("id").replace("item",""),beforeSend:function(){a.animate({backgroundColor:"#fb6c6c"},300)},success:function(c){a.slideUp(300,function(){a.remove();$("#console").html(c)})}})}return false})});$(function(){$("div.movable").click(function(){$(this).next().slideToggle("fast")})});$(function(){$(".widget").each(function(){$(this).hover(function(){$(this).find("h4").addClass("collapse")},function(){$(this).find("h4").removeClass("collapse")}).click(function(){updateWidgetData()}).end().find(".widget-inside").css("visibility","hidden")});$(".column").sortable({connectWith:".column",handle:"h4",cursor:"move",placeholder:"placeholder",forcePlaceholderSize:true,opacity:0.4,start:function(a,b){if($.browser.mozilla||$.browser.safari){$(b.item).find(".widget-inside").toggle()}},stop:function(a,b){b.item.css({top:"0",left:"0"});if(!$.browser.mozilla&&!$.browser.safari){updateWidgetData()}}}).disableSelection()});function updateWidgetData(){var b=[];$(".widget-title").each(function(){var d=$(this).attr("id");$(".column").each(function(){var e=$(this).attr("id");$(".widget",this).each(function(f){var h=0;if($(this).find(".widget-inside").css("display")=="none"){h=1}var g={id:$(this).attr("id"),collapsed:h,order:f,column:e,weight:d};b.push(g)})})});var a={items:b};var c=new Date();$.post("<?php echo ADMIN_OP; ?>save_field_change&","data="+$.toJSON(a),function(d){$("#console").html(d);setTimeout(function(){$("#console").fadeOut(31000)},2000)})};
</script>


<div style="width:100%;margin:0 auto;padding:10px">

<div id="wphead">
			<h2><?php echo _YA_SETTING_REGINPUTS ?></h2>
</div> 
			<div class="widget-liquid-left">
				<div id="widgets-left" >
					<div id="available-widgets" class="widgets-holder-wrap">
						<div class="sidebar-name movable">
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?PHP echo _YA_SETTING_REGINPUTS_ACTIVES?><span id="removing-widget">
							<span></span></span></h3>
						</div>
						<div class='widgets-sortables' style="width:100%">
							<p class="description"><?php echo _YA_SETTING_REGINPUTS_PROFILEINPUTS?></p>
							<div>
								<div class="column" id="c"  style="width:250px">
<?php
		$result = $db->sql_query("select * from ".$prefix."_cnbya_field WHERE need='1' order by pos");
		while ($row = $db->sql_fetchrow($result)) {
			$fid= intval($row['fid']);
			$name = sql_quote($row['name']);
			$pos = intval($row['pos']);
			this_field($fid,$name,$pos);
		}
?>
				</div>		
					</div>
						<br class='clear' /></div>
						<br class="clear" /></div>	
	
					<div class="widgets-holder-wrap"  >
						<div class="sidebar-name movable" >
							<div class="sidebar-name-arrow" >
								<br /></div>
							<h3 style="color:#B54C43"><?PHP echo _YA_SETTING_REGINPUTS_INACTIVES?></h3>
						</div>
						<div class="widget-holder inactive" style="background-color:#B54C43" >
							<p class="description" style="color:white;"><?PHP echo _YA_SETTING_REGINPUTS_DRAGNDROP?> </p>
							<div id='wp_inactive_widgets' class='widgets-sortables' style="background-color:#B54C43">
									<div class="column" id="i" >	
<?php
		$result = $db->sql_query("select * from ".$prefix."_cnbya_field WHERE need='0' order by pos");
		while ($row = $db->sql_fetchrow($result)) {
			$fid= intval($row['fid']);
			$name = sql_quote($row['name']);
			$pos = intval($row['pos']);
			this_field($fid,$name,$pos);
		}
?>
				
									
								</div>
							</div>
						<br class="clear" /></div>
					</div>
				</div>
			</div>


			
			<div class="widget-liquid-right">
				<div id="widgets-right">
					<div class="widgets-holder-wrap">
						<div class="sidebar-name movable" >
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?PHP echo _YA_SETTING_REGINPUTS_REQUIRED?></h3>
						</div>
						<div id='sidebar-1' class='widgets-sortables '>
							<p class="description"><?PHP echo _YA_SETTING_REGINPUTS_SIGNUP?> </p>
		<div class="column" id="l">
<?php
		$result = $db->sql_query("select * from ".$prefix."_cnbya_field WHERE need='3' order by pos");
		while ($row = $db->sql_fetchrow($result)) {
			$fid= intval($row['fid']);
			$name = sql_quote($row['name']);
			$pos = intval($row['pos']);
			this_field($fid,$name,$pos);
		}
		
/*
		
$exceptions_arr = array("LG","Sumsung");

while($columns = mysql_fetch_array($result, MSQL_ASSOC)) {  
   foreach($columns as $columnName => $columnValue)
   if (!in_array($columnName,$exceptions_arr)) {
      echo $columnValue; 
   }
}
	*/	
?>
	
							</div>				
						</div>
					</div>
					<div class="widgets-holder-wrap closed">
						<div class="sidebar-name movable">
							<div class="sidebar-name-arrow">
								<br /></div>
							<h3><?PHP echo _YA_SETTING_REGINPUTS_OPTIONAL?></h3>
						</div>
						<div id='sidebar-2' class='widgets-sortables'>
							<p class="description"><?PHP echo _YA_SETTING_REGINPUTS_OPTIONAL_SIGNUP?></p>
		<div class="column" id="r">
<?php
		$result = $db->sql_query("select * from ".$prefix."_cnbya_field WHERE need='2' order by pos");
		while ($row = $db->sql_fetchrow($result)) {
			$fid= intval($row['fid']);
			$name = sql_quote($row['name']);
			$pos = intval($row['pos']);
			this_field($fid,$name,$pos);
		}
?>
							</div>
						</div>
					</div>
				</div>

		<center><a href="<?php echo $admin_file?>.php?op=addField" class='colorbox'><img src="modules/Your_Account/includes/style/images/add-field.png" alt="<?PHP echo _ADDNEWBLOCK?>" title="<?PHP echo _ADDNEWBLOCK?>" ></a></center>
	
		<div id="console" ></div>

	<!-- wpbody-content -->
</div>

    <?php
	include("footer.php");

}

?>