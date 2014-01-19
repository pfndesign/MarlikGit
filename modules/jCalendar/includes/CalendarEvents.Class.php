<?php
/*
* Armin Randjbar-Daemi <www.omnistream.co.uk>
* armin.randjbar AT gmail.com
*
* GNU General Public License <opensource.org/licenses/gpl-license.html>
* Demo: http://www.omnistream.co.uk/calendar/
* last modified: march 2008 <ver 1.0>
*/

class CalendarEvents {

var $JSoutput;

function CalendarEvents($EventsMatrix) {
	
	if ($EventsMatrix==NULL) return 0;
	

		
	$this->CreateJS($EventsMatrix);
}

function CreateJS($EventsMatrix) {
	
}

function NewLine($i) {
	$order = array("\r\n", "\n", "\r");
	$replace = '<br />';
	$EventsMatrix['content'][$i] = str_replace($order, $replace, $EventsMatrix['content'][$i]);
}

}//Class End
?>