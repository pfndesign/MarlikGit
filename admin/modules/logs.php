<?php
/**
*
* @package Tigris 1.1.4														
* @version $Id: 1:25 PM 3/2/2010 Aneeshtan $						
* @version  http://www.ierealtor.com - phpnuke id: scottr $						
* @copyright (c) Marlik Group  http://www.MarlikCMS.com											
* @license http://creativecommons.org/licenses/by-nc-sa/3.0 Attribution-Noncommercial-Share Alikes
*
*/


function openFile($file, $mode, $input) {
    if ($mode == "READ") {
        if (file_exists($file)) {
            $handle = fopen($file, "r");
            $output = fread($handle, filesize($file));
            return $output; // output file text
        } else {
            return false; // failed.
        }
    } elseif ($mode == "WRITE") {
        $handle = fopen($file, "w");
        if (!fwrite($handle, $input)) {
            return false; // failed.
        } else {
            return true; //success.
        }
    } elseif ($mode == "READ/WRITE") {       
        if (file_exists($file) && isset($input)) {
            $handle = fopen($file , "r+");
            $read = fread($handle, filesize($file));
            $data = $read.$input;
            if (!fwrite($handle, $data)) {
                return false; // failed.
            } else {
                return true; // success.
            }
        } else {
            return false; // failed.
        }
    } else {
        return false; // failed.
    }
    fclose($handle);
}
 //echo openFile(INCLUDES_ACP."log/admin.log", "READ",''); // OUTPUT > Hello World!!!

function show_logs(){
		global $db,$prefix;
		include_once('header.php');
		GraphicAdmin();
				
		OpenTable();	

	
        $incsdir = dir("".INCLUDES_ACP."log/");
        while($func=$incsdir->read()) {
            if(substr($func, -4) == ".log") {
                $incslist .= "$func ";
            }
        }
        closedir($incsdir->handle);
        $incslist = explode(" ", $incslist);
        sort($incslist);
        for ($i=0; $i < sizeof($incslist); $i++) {
     if($incslist[$i]!="") {
    $counter = 0;
    echo '<h3 style="text-align:right;">'.$incslist[$i].'</h3>
    <table class="widefat comments fixed" summary="Latest News">
	<thead>
	<tr>
	<th scope="col" style="width:5%;text-align:right">ID</th>
	<th scope="col">Description</th>
	</tr>			
	</thead>
	</thead>
    <tfoot>	<tr>
	<th scope="col" style="width:5%;text-align:right">ID</th>
	<th scope="col">Description</th>
	</tr>		
	</tfoot>
    <tbody>';	    	
		
$fp =  fopen($incsdir->path."/$incslist[$i]", 'r');
 $i= 1;
   while(!feof($fp))
   {
      $line = fgets($fp);
		echo  '<tr>
       <td align="right">'.$i++.'</td>
        <td align="right">'.$line.'</td>
       </tr>';
	}
	echo '</tbody></table></div><br>';
    }else {
    	echo "NO LOG SAVED";
    }
    CloseTable();	
}
	include_once('footer.php');
}



global $db,$prefix;
$act = $_REQUEST['$op'];
switch($op){
		default:
		case 'show_logs':
		show_logs();
		break;
		case 'delete_logs':
		delete_logs();
		break;

}
?>
