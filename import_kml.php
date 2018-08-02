<?php

exit; // disabled

require_once 'include/include.php';

// Init file
$txt_file = file_get_contents('faults.kml');
$rows = explode("\n", $txt_file);

// Init vars
$found_fid = false;
$found_fault_id = false;
$found_coordinates = false;
$good_id = false;
$result = array();

// Search lines
foreach ($rows as $line) {
	// Skip empty
    if (empty($line))
		continue;
    
	// Find fid
	if (strpos($line, 'FID')) {
		$found_fid = true;
		
	// Verify and extract fid
	} elseif ($found_fid) {
		$found_fid = false;
		$res_fid = substr($line, 4, strlen($line) - 9);
		if (is_numeric($res_fid))
			$good_id = true;
	
	// Find faultid
	} elseif (strpos($line, 'FaultID') && $good_id) {
		$found_fault_id = true;
		$good_id = false;
		
	// Verify and extract faultid
	} elseif ($found_fault_id) {
		$found_fault_id = false;
		$res_fault_id = substr($line, 4, strlen($line) - 9);
		if (is_numeric($res_fault_id))
			$good_id = true;
		
	// Extract style
	} elseif (strpos($line, '<styleUrl>') && $good_id) {
		$res_style = substr($line, 24, 1);
		
	// Find gps
	} elseif (strpos($line, '<coordinates>') && $good_id) {
		$found_coordinates = true;
		
	// Process and extract gps
	} elseif ($found_coordinates) {
		$found_coordinates = false;
		$good_id = false;
		$temp_coords = explode(",", $line);
		$temp_coords = str_replace("0 ", "", $temp_coords);
		$temp_coords = str_replace(" ", "", $temp_coords);
		$res_latlon = array();
		for ($i = 0; $i < count($temp_coords) - 1; $i = $i + 2) {
			$temp_latlon['lon'] = $temp_coords[$i];
			$temp_latlon['lat'] = $temp_coords[$i + 1];
			array_push($res_latlon, $temp_latlon);
		}
		
		// Compile result
		array_push($result, array("fault_id" => $res_fault_id, "fid" => $res_fid, "style" => $res_style, "latlon" => $res_latlon));
	}
}

// delete old information
if (!empty($result)) {
	$GLOBALS['db']->query("TRUNCATE TABLE solmaz.lines");
	$GLOBALS['db']->query("TRUNCATE TABLE solmaz.lines_points");
}

// Add group and insert coordinates into mysql
foreach ($result as $entry) {
	mysqliInsert('lines', array('fault_id' => $entry['fault_id'], 'fid' => $entry['fid'], 'type' => $entry['style']));
	
	$sql = "INSERT INTO lines_points (fid, lat, lon) VALUES";
	
	$first = true;
	foreach ($entry['latlon'] as $value) {
		if (!$first)
			$sql .= ",";
		else
			$first = false;
		$sql .= " (" . $entry['fid'] . ", " . $value['lat'] . ", " . $value['lon'] . ")";
	}
	
	$GLOBALS['db']->query($sql);
}

echo 'Done.';

mysqliCloseConnection();
?>