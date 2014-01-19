<?php
require_once("mainfile.php");
if(empty($_GET['page']) AND empty($_POST['page'])){
	show_error("YOU ARE NOT AUTHORIZED TO VIEW THIS FILE DIRECTLY");
}else {

$page = sql_quote($_GET['page']);
$page = (empty($page) ? "1" : $page );
require_once(MODS_PATH."JQ_Forums/functions.php");
echo JQ_Forums_PAGE($page);
}
?>