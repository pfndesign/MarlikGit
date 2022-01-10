<?php
/************************************************/
/* Dynamic Keywords For PHP-Nuke 7.3++			*/
/* Written by: Jonathan Estrella				*/
/* http://slaytanic.sourceforge.net				*/
/* Copyright (c) 2006-2008 Jonathan Estrella	*/
/************************************************/

if (stristr(htmlentities($_SERVER['PHP_SELF']), 'dynamic_keywords.php')) {
    Header('Location: ../index.php');
    die();
}

// Dynamic meta tags Generation
function getkeywords() {
global $db, $prefix, $name;

	// Get the default keywords
	$result = $db->sql_query('SELECT keywords FROM ' . $prefix . '_keywords_main');
	$row = $db->sql_fetchrow($result);
	$mainkeywords = $row['keywords'];
	$db->sql_freeresult($result);
	// Now is time to print the proper keywords
	if($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/') {
		return $mainkeywords;
	} else {
	// Get keywords by module name
	$result = $db->sql_query('SELECT keywords FROM ' . $prefix . '_keywords WHERE title=\'' . $name . '\'');
	$row = $db->sql_fetchrow($result);
	$keywords= $row['keywords'];
	$db->sql_freeresult($result);
		if(!empty($keywords)){
			return $keywords;
		} else {
			return $mainkeywords;
		}
	}
}

function getdescription() {
global $db, $prefix, $name, $slogan;

	// Get default description, fallback to classic $slogan if empty
	$result = $db->sql_query('SELECT * FROM ' . $prefix . '_keywords_main');
	$row = $db->sql_fetchrow($result);
	$maindescription = $row['description'];
	$db->sql_freeresult($result);

	if(empty($maindescription)) {$maindescription=$slogan;}

	// Print proper description
	if($_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/') {
		return $maindescription;
	}else {
	// Get description by module name
	$result = $db->sql_query('SELECT description FROM ' . $prefix . '_keywords WHERE title=\'' . $name . '\'');
	$row = $db->sql_fetchrow($result);
	$description= $row['description'];
	$db->sql_freeresult($result);

	if (!empty($description)) {
		return $description;
	} else {
		return $maindescription;
	}
	
	}
	
}
