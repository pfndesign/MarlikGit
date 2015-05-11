<?php

/** @package your_account admin files	12:59 AM 1/12/2010  MarlikCMS $ */	

if (!defined('ADMIN_FILE')) {show_error(HACKING_ATTEMPT);}


if (($radminsuper==1) OR ($radminuser==1)) {

    $pagetitle = ": "._USERADMIN." - "._WAITINGUSERS;
    include("header.php");
    GraphicAdmin();
    title(_USERADMIN.": "._WAITINGUSERS);
    amain();
    echo "<br>\n";
    OpenTable();
    if (!isset($min)) $min=0;
    if (!isset($max)) $max=$min+$ya_config['perpage'];
    $totalselected = $db->sql_numrows($db->sql_query("SELECT * FROM ".$user_prefix."_users_temp"));
	
    
    echo "<form action=\"".$admin_file.".php?op=YA_multi_task\"  method=\"POST\"  name='listpending'  id='listpending'>";

	echo "<div $style >"
		.'<table class="widefat post fixed" style="line-height:20px;margin-top:10px;" >
		<thead> 
		<tr> 
		<th scope="col">&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" /></th>
		<th scope="col">'._USERNAME.'</th>
			<th scope="col" >'._UREALNAME.'</th> 
			<th scope="col">'._EMAIL.'</th>
			  <th scope="col">'._REGDATE.'</th>
			  <th scope="col">'._FUNCTIONS.'</th>
				    </tr>
						</thead>
<tfoot>
	<tr> 
	<th scope="col">&nbsp;<input type="checkbox" onclick="checkAll(document.getElementById(\'adminnews\'), \'selectbox\', this.checked);" /></th>
		<th scope="col">'._USERNAME.'</th>
			<th scope="col" >'._UREALNAME.'</th> 
			<th scope="col">'._EMAIL.'</th>
			  <th scope="col">'._REGDATE.'</th>
			  <th scope="col">'._FUNCTIONS.'</th>
				    </tr>
   					 </tfoot>
   						 <tbody>';	   
    
    $result = $db->sql_query("SELECT * FROM ".$user_prefix."_users_temp ORDER BY username LIMIT $min,".$ya_config['perpage']."");
    while($chnginfo = $db->sql_fetchrow($result)) {
        echo "<tr bgcolor='$bgcolor1'>\n";
       	echo "<td><input type=\"checkbox\" name=\"selecionar[]\"  class=\"selectbox\" value=\"".$chnginfo['user_id']."\" /></td>";
        echo "<td>".$chnginfo['username']." (".$chnginfo['user_id'].")</td>\n";
        echo "<td align='center'>".$chnginfo['realname']."</td>\n";
        echo "<td align='center'>".$chnginfo['user_email']."</td>\n";
		$date_temp = explode(" ", $chnginfo['user_regdate']);
        $date_temp[1] = substr($date_temp[1], 0, 2);
        $date_temp[0] = month_number($date_temp[0], 2);
        $row['user_regdate'] = $date_temp[2] . "-" . $date_temp[0] . "-" . $date_temp[1];
		$regdateu = hejridate($row['user_regdate'], 1, 4);
        echo "<td align='center'>$regdateu</td>\n";
        echo "<td align='center'>"
		."</tr>\n";
    }
    echo "";
    echo "</td></table></div>\n";
    echo "<br>\n";
    
		echo "<span style='padding-right:20px;'><select name=\"act\">"
		."<option  value='-1' selected>"._FUNCTIONS."</option>"
		."<option value=\"approveUser\">"._YA_APPROVE."</option>"
		."<option value=\"activateUser\">"._YA_ACTIVATE."</option>"
		."<option value=\"denyUser\">"._DENY."</option>"
		."<option value=\"resendMail\">"._RESEND."</option>"
		."</select>"
		."&nbsp; <input type=\"submit\" value=\""._OK."\">
		</span>";
		
    
    yapagenums($op, $totalselected, $ya_config['perpage'], $max, "", "", "", "");
    CloseTable();
    include("footer.php");

}

?>