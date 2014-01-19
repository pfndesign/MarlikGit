<style type="text/css">
* {margin:0;padding:0}
form {margin:0 auto;text-align:center;width:350px;font-size:12px;direction:rtl}
legend {margin:1em;padding:0 1.5em;color:#036;background:transparent;font-size:13px}
label {float:right;width:110px;padding:0 1em;text-align:right}
fieldset input,select {width:150px;border-top:#555 1px solid;border-left:#555 1px solid;border-bottom:#ccc 1px solid;border-right:#ccc 1px solid;padding:1px;color:#333;margin-bottom:0.5em}
#fm-submit {clear:both;text-align:center;border:#333 1px solid;padding:1px;background:#555;color:#fff;width:7em;margin:1em auto}
#formHelp {background:#EFE8B8;text-align:right}
</style>

<form action='<?php echo ADMIN_OP?>saveaddField' method='post'>
    <fieldset>
    <legend>ایجاد ورودی اختصاصی</legend>

      <label class="fm-req"><?php echo _FIELDNAME ?></label>
     <input type='text' name='mfield_name' size='20' maxlength='20'>
      <label class="fm-req"><?php echo _FIELDVALUE ?></label>
	<input type='text' name='mfield_value' size='20' maxlength='255'>
      <label class="fm-req"><?php echo _FIELDSIZE ?></label>
	<input type='text' name='mfield_size' size='4' maxlength='4'>
      <label class="fm-req"><?php echo _FIELDNEED ?></label><?php
	echo "<select name='mfield_need'>\n";
	echo "<option value='1' selected>"._NEED1."</option>\n";
	echo "<option value='2'>"._NEED2."</option>\n";
	echo "<option value='3'>"._NEED3."</option>\n";
	echo "<option value='0'>"._NEED0."</option>\n";
	echo "</select>";
	?>
    <label class="fm-req"><?php echo _FIELDVPOS ?></label>
	<input type='text' name='mfield_pos' size=3 maxlength='3'>
      <label class="fm-req"><?php echo _YA_PUBLIC ?></label>
    <?php
	echo "<select name='mfield_public'>\n"; // MrFluffy
    echo "<option value=1 selected>"._YA_PUBLIC."</option>\n";
	echo "<option value=0>"._YA_PRIVATE."</option>\n";
	echo "</select>";
	?>
    </fieldset>

    
<?php
	echo "<div id='formHelp'>
	"._NAMECOMENT."<br />"._VALUECOMENT."<br />";
	echo "</div><br><br>\n";
	echo "<input type='hidden' name='op' value='saveaddField'>\n";
	echo "<input type='submit' value='"._ADDFIELD."'></form>\n";

	

?>