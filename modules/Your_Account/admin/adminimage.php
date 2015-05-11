<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}

	$codeimg	= "/images/admin/users.gif";
	$code		= "4.4";
	include("themes/$ThemeSel/theme.php");
	$tcolor	= str_replace("#", "", $textcolor1);
	$tc_r	= hexdec(substr($tcolor, 0, 2));
	$tc_g	= hexdec(substr($tcolor, 2, 2));
	$tc_b	= hexdec(substr($tcolor, 4, 2));
	$image = ImageCreateFromPNG($codeimg);
	$text_color = ImageColorAllocate($image, $tc_r, $tc_g, $tc_b);
	Header("Content-type: image/png");
	ImageString ($image, 2, 3, 20, $code, $text_color);
	ImagePNG($image, '', 75);
	ImageDestroy($image);
//	die();
//	break;

?>