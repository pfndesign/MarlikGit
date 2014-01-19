<?php


if (!stristr($_SERVER['SCRIPT_NAME'], "modules.php"))
{
    header("Location: ../../../index.php");
    die();
}
if (!defined('CNBYA'))
{
    echo "CNBYA protection";
    exit;
}


function getAllVotes($id)
	{
global $db,$prefix;
	/**
	Returns an array whose first element is votes_up and the second one is votes_down
	**/
	$votes = array();
	$q = "SELECT * FROM ".BLOG_TABLE." WHERE bid = $id";
	$r = $db->sql_query($q);
	if($db->sql_numrows($r)==1)//id found in the table
		{
		$row =  $db->sql_fetchrow($r);
		$votes[0] = $row['like'];
		$votes[1] = $row['unlike'];
		}
	return $votes;
	}

function getEffectiveVotes($id)
	{
	/**
	Returns an integer
	**/
	$votes = getAllVotes($id);
	$Vote = $votes[0] - $votes[1];;
	$effectiveVote = $Vote >0 ? "<span style='font-weight:bold;color:green'>+$Vote</span>" : "<span style='font-weight:bold;color:red'>$Vote</span>";
	return $effectiveVote;
	}

global $db,$votes,$user,$prefix;

if (is_user($user)) {
$id = $_POST['id'];
$action = $_POST['action'];

//get the current votes
$cur_votes = getAllVotes($id);

//ok, now update the votes

if($action=='vote_up') //voting up
{
	$q = "update ".BLOG_TABLE." set `like`= `like`+1 WHERE `bid`='$id'";
}
elseif($action=='vote_down') //voting down
{
	$q = "update ".BLOG_TABLE." set `unlike`= unlike+1 WHERE `bid`='$id'";
}else {
	die(HACKING_ATTEMPT);
}
if ($_COOKIE['vbs_nkln-'.$id.'']!=''.$id.'') {
	setcookie("vbs_nkln-$id", ''.$id.'', time()+(60*60*24*30)); //cookie expires in one month
	$r = $db->sql_query($q);
}else {
	echo "<b><span style='color:red'>شما قبلا رای داده اید</span>&nbsp;</b>";
}

if($r) //voting done
	{
	$effectiveVote = getEffectiveVotes($id);
	echo ''.$effectiveVote." رای ";
	}
elseif(!$r) //voting failed
	{
	echo "مشکلی در ثبت رای به وجود آمده است!<br>".mysql_error()."";
	}
	}else {
				 show_error(_NOTSUB."<br>"._ASREGISTERED);
	}
	
?>