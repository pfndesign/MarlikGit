<?php
/**
*
* @package inc_adminfunc														
* @version $Id: inc_adminfunc 1.1.6 						
* @copyright (c) Marlik Group  http://www.nukelearn.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alike
*
*/


if (stristr(htmlentities($_SERVER['PHP_SELF']), "inc_adminfunc.php")) {
	die("Access Denied<br><b>".$_SERVER['PHP_SELF']."</b>");
}



// download file from remote server

function curl_file($from, $to){
		if ($copy_file = curl_init($from)) {
			if ($open_file = fopen($to, "w")) {
				curl_setopt($copy_file, CURLOPT_FILE, $open_file);
				curl_setopt($copy_file, CURLOPT_HEADER, 0);
				curl_exec($copy_file);
				curl_close($copy_file);
				fclose($open_file);
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
}
function download_file ($url, $path) {

  $newfilename = $path;
  $file = fopen ($url, "rb");
  if ($file) {
    $newfile = fopen ($newfilename, "wb");
    if ($newfile)
    while(!feof($file)) {
      fwrite($newfile, fread($file, 1024 * 8 ), 1024 * 8 );
    }
  }

  if ($file) {
    fclose($file);
  }
  if ($newfile) {
    fclose($newfile);
  }
  
  if(file_exists($path)){
  return true;
  }else{
  return false;
  }
  
 }
function copy_file($from, $to) {
	global $settings;

	// regular copy()
	if (copy($from, $to)) {
		return true;
	} else {
		return false; // cannot download
	}
}
// use cURL to get content from remote server
function curl_get_contents($url) {
	if (!$curl = curl_init($url)) {
		return false;
	}

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($curl);
	curl_close($curl);

	return $result;
}

// try to get the contents through socket connection
function fsock_get_contents($url) {
	// parse URL
	if (!preg_match('#^http://([^/]*)(.*)$#', $url, $match)) {
		return false;
	}
	$host = $match[1];
	$request = $match[2];

	// build request
	$header  = "GET ". $request ." HTTP/1.1\r\nHost: ". $host ."\r\nConnection: Close\r\nUser-Agent: onArcade 2.3\r\n\r\n\r\n";
	$fpointer = @fsockopen($host, 80, $errno, $errstr, 10);
	$response = '';
	if ($fpointer) {
		@fwrite($fpointer, $header);
		while (!feof($fpointer)) {
			$response .= @fread($fpointer, 1024);
		}
	} else {
		return false;
	}
	@fclose($fpointer);

	preg_match('#Content-Length: ([0-9]*)#i', $response, $match);
	$content_length = (int) $match[1];
	if ($content_length == 0) {
		return false;
	} else {
		return substr($response, (-1) * $content_length);
	}
}



// this function is used to get contents from remote server
function get_remote_contents($from,$type) {
	
	switch($type){
		case 'file_get_contents':
				return file_get_contents($from);
		break;
		case 'curl_get_contents':
				return curl_get_contents($from);
		break;
		case 'fsock_get_contents':
				return fsock_get_contents($from);
		break;
	}
		
}

?>