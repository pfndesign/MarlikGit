<?php

/**
 * getElementList
 * @param $db
 * @param $sql
 * @param $pageName
 * @return unknown_type
 */
if (!function_exists('langit')) {
	function langit($value){
	//global $currentlang;
	//require_once("language/lang-$currentlang.php");
	if (defined($value)) {
		return constant(''.strtoupper($value).'');
	}else {
		return $value;
	}
}
}

//TODO: delete this function
function getElementList($db, $sql,$pageName)
{
	$str = false;
	$result = $db->sql_query($sql);
	if ( $result !== false )
	{
		if ($db->sql_numrows($result) > 0) {
			$str = NULL;
		}
		else {
			$str = NULL;
			//$str = "<li></li>";
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$supp = NULL;
			if ($row->slave == 0){
				$supp = "<ul class='ajax'>"
								."<li id='".$row->Id."'>{url:".$pageName."?action=getElementList&ownerEl=".$row->Id."}</li>"
						."</ul>";
			}

			$str .= "<li class='text' id='".$row->Id."'>"
						."<span>".langit($row->name)."</span>"
							. $supp
					."</li>";				
		}
	}
	return $str;
}
/**
 * 
 * @param $db
 * @param $Id
 * @return unknown_type
 */
//TODO: delete this function
function deleteData($db, $Id, &$i = 0) 
{
	// to check that whether child exists
	$sql = sprintf('SELECT
				 		Id, slave, position, ownerEl 
					FROM '
						. TREE_TABLE_PREFIX . '_elements
					WHERE 
						ownerEl = %d ',
					$Id);
	$row = NULL;
	$i++;		
	echo $i;
	if ($result = $db->sql_sql_fetchrow($sql))
	{		
		while ($row = $db->sql_fetchrow($result)) 
		{	  
			// if element type is not slave, 
			// there can be childs belonging to that master  	
			if ($row->slave == "0") 
			{
				// recursive operation, to reach the deepest element
				deleteData($db, $row->Id, $i);				
			}			
		}
	}
	$i--;
	
	// only update the elements' position on the same level of our first element
	if ($i == 0) 
	{
		$sql = sprintf('SELECT 
							position, ownerEl
						FROM '
							. TREE_TABLE_PREFIX . '_elements
						WHERE
							Id = %d',
						$Id);

					
		if ($result = $db->sql_query($sql)) 
		{			
			if ($row = $db->sql_fetchrow($result)) 
			{
				$sql = sprintf('UPDATE '
									. TREE_TABLE_PREFIX . '_elements
								SET 
									position = position - 1
								WHERE 
									ownerEl = %d
									AND
									position > %d',
								$row->ownerEl, $row->position);
				$db->sql_query($sql);
			}	
		}			
	}
		
	// start to delete it from bottom to top
	$sql = sprintf('DELETE FROM '
						. TREE_TABLE_PREFIX .'_elements
	        		WHERE 
			        	ownerEl = %d 
			        	OR
			        	Id = %d ',
					$Id, $Id);
	
	if (!$db->sql_query($sql)) {
		return false;
	}	
	return true;
}
/**
 * 
 * @param $string
 * @return unknown_type
 */
function checkVariable($string)
{
	return str_replace ( array ( '&', '"', "'", '<', '>' ),
	array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $string );
}


?>