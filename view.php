<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub-functions
require_once 'include/include.php';

// if an id is given, load and display the data
if (isset($_GET['id'])) {
	// init the query
	$query = mysqliInitSelect('faults', array('*'), 'id = '. $_GET['id'], '', '');
	
	// continue if not empty and generate output table
	// empty 'comment'-fields will be hidden
	if (mysqliGetNumber($query)) { 
		$result = mysqliGetSingle($query);
		mysqliDeleteQuery($query);
		head($result['name']);

		// Include the map
		require_once 'map.php';
		
		echo '<br /><br />';
	
		// This function is in subs_ofa.php
		generateViewFromDBResult($result); 
	
	} else echo 'ERROR : There is no entry with this ID (' . $_GET['id'] . ')';
} else header('location:index.php');
foot();
?>