<?php

include_once('securimage.php');
//include('cpatcha_config.php');

$img = new securimage();
$code_size = $_REQUEST['codesize'];
$img->show('',$code_size); // alternate use:  $img->show('/path/to/background.jpg');

?>