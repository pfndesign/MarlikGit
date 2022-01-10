<?php

/**
 *
 * @package html editorial source														
 * @version  inc_htmlclean.php $Id: beta6 $ 2:12 AM 12/25/2009						
 * @copyright (c)Marlik Group  http://www.MarlikCMS.com											
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

if (stristr(htmlentities($_SERVER['PHP_SELF']), "inc_htmlclean.php")) {
	show_error(HACKING_ATTEMPT);
}



//define ( 'INCLUDES_PATH', 'includes/' );
//===========================================
//FILTER SETTING
//===========================================
$reasons = array("As Is", "Offtopic", "Flamebait", "Troll", "Redundant", "Insighful", "Interesting", "Informative", "Funny", "Overrated", "Underrated");
$badreasons = 4;
$AllowableHTML = array("img" => 2, "tr" => 1, "td" => 2, "table" => 2, "div" => 2, "p" => 2, "hr" => 1, "b" => 1, "i" => 1, "strike" => 1, "u" => 1, "font" => 2, "a" => 2, "em" => 1, "br" => 1, "strong" => 1, "blockquote" => 1, "tt" => 1, "li" => 1, "ol" => 1, "ul" => 1, "center" => 1, "embed" => 1, "span" => 1);



// Editor Functions

//-----------------------------------------------------------------------

function FixQuotes($what = "")
{

	$what = str_replace("'", "''", $what);

	while (stristr($what, "\\\\'")) {

		$what = str_replace("\\\\'", "'", $what);
	}

	return $what;
}
function check_words($Message)
{

	global $CensorMode, $CensorReplace, $EditedMessage, $CensorList;

	$EditedMessage = $Message;

	if ($CensorMode != 0) {

		if (is_array($CensorList)) {

			$Replace = $CensorReplace;

			if ($CensorMode == 1) {

				for ($i = 0; $i < count($CensorList); $i++) {

					$EditedMessage = preg_replace("_$CensorList[$i]([^a-zA-Z0-9])_", "$Replace\\1", $EditedMessage);
				}
			} elseif ($CensorMode == 2) {

				for ($i = 0; $i < count($CensorList); $i++) {

					$EditedMessage = preg_replace("_(^|[^[:alnum:]])$CensorList[$i]_", "\\1$Replace", $EditedMessage);
				}
			} elseif ($CensorMode == 3) {

				for ($i = 0; $i < count($CensorList); $i++) {

					$EditedMessage = preg_replace("_$CensorList [$i]_", $Replace, $EditedMessage);
				}
			}
		}
	}

	return $EditedMessage;
}
function delQuotes($string)
{

	/* no recursive function to add quote to an HTML tag if needed */

	/* and delete duplicate spaces between attribs. */

	$tmp = ""; # string buffer

	$result = ""; # result string

	$i = 0;

	$attrib = -1; # Are us in an HTML attrib ?   -1: no attrib   0: name of the attrib   1: value of the atrib

	$quote = 0; # Is a string quote delimited opened ? 0=no, 1=yes

	$len = strlen($string);

	while ($i < $len) {

		switch ($string[$i]) { # What car is it in the buffer ?

			case "\"": #"       # a quote.

				if ($quote == 0) {

					$quote = 1;
				} else {

					$quote = 0;

					if (($attrib > 0) && (isset($tmp))) {

						$result .= "=\"$tmp\"";
					}

					$tmp = "";

					$attrib = -1;
				}

				break;

			case "=": # an equal - attrib delimiter

				if ($quote == 0) { # Is it found in a string ?

					$attrib = 1;

					if ($tmp != "")

						$result .= " $tmp";

					$tmp = "";
				} else

					$tmp .= '=';

				break;

			case " ": # a blank ?

				if ($attrib > 0) { # add it to the string, if one opened.

					$tmp .= $string[$i];
				}

				break;

			default: # Other

				if ($attrib < 0) # If we weren't in an attrib, set attrib to 0

					$attrib = 0;

				$tmp .= $string[$i];

				break;
		}

		$i++;
	}

	if (($quote != 0) && (!empty($tmp))) {

		if ($attrib == 1)

			$result .= "=";

		/* If it is the value of an atrib, add the '=' */

		$result .= "\"$tmp\""; /* Add quote if needed (the reason of the function ;-) */
	}

	return $result;
}
function check_html($str, $strip = "")
{
	global $db;
	if ($strip == "nohtml") {
		$str = @trim($str);
		if (false) { //wtf ?
			$str = stripslashes($str);
		}
		return htmlentities($str, ENT_QUOTES, "utf-8");
	} else {

		$str = @trim($str);
		if (false) { // wtf ?
			$str = stripslashes($str);
		}
		return $str;
	}
}

function wysiwyg_textarea($inputName, $value, $config = 'NukeUser', $cols = 50, $rows = 10)
{
	global $nuke_editor, $admin, $currentlang, $oFCKeditor;
	$editorlang = ($currentlang == "persian" ? "fa" : "en");
	// Don't waste bandwidth by loading WYSIWYG editor for crawlers
	if ($nuke_editor == 0 or !isset($_COOKIE)) {
		echo '<textarea  name="' . $inputName . '" cols="' . $cols . '" rows="' . $rows . '" >' . $value . '</textarea>';
	} else {

		include_once("includes/ckeditor/ckeditor.php");

		echo '<textarea name="' . $inputName . '"  id="' . $inputName . '" cols="' . $cols . '" rows="' . $rows . '" >' . $value . '</textarea>';


		echo "<script type=\"text/javascript\">CKEDITOR.editorConfig = function( config ){	config.language = '$editorlang';	config.contentsLangDirection = 'rtl';	config.uiColor = '#D6DBDE';};</script>";

		if ($config == "PHPNuke") {
			echo "<script type=\"text/javascript\">CKEDITOR.replace( '$inputName',{toolbar : [ [  '-', 'Bold', 'Italic', 'Underline', 'Strike','-','Link', 'Unlink','-','TextColor','BGColor' ,'Smiley' ] ]});</script>";
		}

		if (is_admin($admin)) {
			echo "<script type='text/javascript'>CKEDITOR.replace('$inputName',{filebrowserBrowseUrl : 'includes/elfinder/filemanager.php'});
			</script>";
		}
	}
}
function filter_text($Message, $strip = '')
{
	global $EditedMessage;
	check_words($Message);
	$EditedMessage = check_html($EditedMessage, $strip);
	return $EditedMessage;
}
function filter($what, $strip = "", $save = "", $type = "")
{
	if ($strip == "nohtml") {
		$what = check_html($what, $strip);
		$what = htmlentities(trim($what), ENT_QUOTES, "utf-8");
		// If the variable $what doesn't comes from a preview screen should be converted
		if ($type != "preview" and $save != 1) {
			$what = html_entity_decode($what, ENT_QUOTES);
		}
	}
	if ($save == 1) {
		$what = check_words($what);
		$what = check_html($what, $strip);
		$what = addslashes($what);
	} else {
		$what = stripslashes(FixQuotes($what));
		$what = check_words($what);
		$what = check_html($what, $strip);
	}
	return ($what);
}

if (!function_exists('analyse_content')) {
	function analyse_content($content, $link = '0', $img = '0', $bbcode = '0')
	{
		$content = ($img == 1) ? url2img($content) : $content;
		$content = ($link == 1) ? url2link($content) : $content;
		$content = ($bbcode == 1) ? myBBcode($content) : $content;

		return $content;
	}
}

if (!function_exists('url2link')) {
	function url2link($str)
	{
		$pattern = "/[\"']?([^\"']?.*(png|jpg|gif))[\"']?/i";
		if (!preg_match($pattern, $str)) {
			$str = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|](?![^<>]*(?:>|<\/a>))/i', "<a href=\"\\0\" onclick=\"open_url('\\0')\";return false;><&nbsp;" . substr('\\0', 0, 50) . "</a>", $str);
		}
		return $str;
	}
}
if (!function_exists('url2img')) {
	function url2img($str)
	{
		$str =  preg_replace(
			'/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]?.*(png|jpg|gif)/i',
			"<a href=\"\\0\" class='colorbox'>&nbsp; [مشاهده تصویر] &nbsp;</a>",
			$str
		);
		return $str;
	}
}
if (!function_exists('myBBcode')) {
	function myBBcode($value)
	{
		require_once('includes/inc_bbcode.php');
		//Create an instance of simpleParser
		$parser = new SimpleParser();
		//Parse the text and store
		//$parser->parseText($text);
		//Just badwords
		//$parser->parseText($text,0,1);
		//Just smileys
		//$parser->parseText($text,1,0);
		//And finally turn the smileys back to text
		//$parser->unParseText($example);//Note this will not unfilter bad words 

		$result = $parser->parseText($value);
		return $result;
	}
}
//===========================================
//UTF-8 FUNCTIONS
//===========================================
function seems_utf8($str)
{
	$length = strlen($str);
	for ($i = 0; $i < $length; $i++) {
		$c = ord($str[$i]);
		if ($c < 0x80) $n = 0; # 0bbbbbbb
		elseif (($c & 0xE0) == 0xC0) $n = 1; # 110bbbbb
		elseif (($c & 0xF0) == 0xE0) $n = 2; # 1110bbbb
		elseif (($c & 0xF8) == 0xF0) $n = 3; # 11110bbb
		elseif (($c & 0xFC) == 0xF8) $n = 4; # 111110bb
		elseif (($c & 0xFE) == 0xFC) $n = 5; # 1111110b
		else return false; # Does not match any model
		for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
			if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
				return false;
		}
	}
	return true;
}
function utf8_uri_encode($utf8_string, $length = 0)
{
	$unicode = '';
	$values = array();
	$num_octets = 1;
	$unicode_length = 0;

	$string_length = strlen($utf8_string);
	for ($i = 0; $i < $string_length; $i++) {

		$value = ord($utf8_string[$i]);

		if ($value < 128) {
			if ($length && ($unicode_length >= $length))
				break;
			$unicode .= chr($value);
			$unicode_length++;
		} else {
			if (count($values) == 0) $num_octets = ($value < 224) ? 2 : 3;

			$values[] = $value;

			if ($length && ($unicode_length + ($num_octets * 3)) > $length)
				break;
			if (count($values) == $num_octets) {
				if ($num_octets == 3) {
					$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
					$unicode_length += 9;
				} else {
					$unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
					$unicode_length += 6;
				}

				$values = array();
				$num_octets = 1;
			}
		}
	}

	return $unicode;
}
function Slugit($title)
{
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);

	//$title = remove_accents($title);
	if (seems_utf8($title)) {
		if (function_exists('mb_strtolower')) {
			$title = mb_strtolower($title, 'UTF-8');
		}
		$title = utf8_uri_encode($title, 500);
	}

	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = str_replace('.', '-', $title);
	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}
function Deslug($title)
{

	$title = sql_quote($title);
	// Preserve escaped octets.
	$title = Slugit($title);
	// Remove percent signs that are not part of an octet.
	$title = rawurldecode($title);
	// Restore octets.
	$title = htmlspecialchars($title, ENT_NOQUOTES, 'UTF-8');

	return $title;
}

// these two functions are used to clone the unescape() function in javascript
if (!function_exists('code2utf')) {
	function code2utf($num)
	{
		if ($num < 128) return chr($num);
		if ($num < 2048) return chr(($num >> 6) + 192) . chr(($num & 63) + 128);
		if ($num < 65536) return chr(($num >> 12) + 224) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
		if ($num < 2097152) return chr(($num >> 18) + 240) . chr((($num >> 12) & 63) + 128) . chr((($num >> 6) & 63) + 128) . chr(($num & 63) + 128);
		return '';
	}
}

if (!function_exists('unescape')) {
	function unescape($source, $iconv_to = 'UTF-8')
	{
		$decodedStr = '';
		$pos = 0;
		$len = strlen($source);
		while ($pos < $len) {
			$charAt = substr($source, $pos, 1);
			if ($charAt == '%') {
				$pos++;
				$charAt = substr($source, $pos, 1);
				if ($charAt == 'u') {
					// we got a unicode character
					$pos++;
					$unicodeHexVal = substr($source, $pos, 4);
					$unicode = hexdec($unicodeHexVal);
					$decodedStr .= code2utf($unicode);
					$pos += 4;
				} else {
					// we have an escaped ascii character
					$hexVal = substr($source, $pos, 2);
					$decodedStr .= chr(hexdec($hexVal));
					$pos += 2;
				}
			} else {
				$decodedStr .= $charAt;
				$pos++;
			}
		}

		if ($iconv_to != "UTF-8") {
			$decodedStr = iconv("UTF-8", $iconv_to, $decodedStr);
		}

		return $decodedStr;
	}
}
//---------------------
