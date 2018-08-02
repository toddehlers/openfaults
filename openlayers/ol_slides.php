<?php
// Programmed by Timo Strube, updated 03.05.2018

// include all the sub functions
require_once '../include/include.php';

// generate $where
if ($_GET['a'] == 1)
	$where = 'display_big = 0';
elseif ($_GET['a'] == 2)
	$where = 'display_big = 1';
else
	$where = '';

if ($where != '')
	$where .= ' AND ';

$where .= 'data_source="' . $_GET['c'] . '" GROUP BY lon, lat, display_big';

// query quakes
$query = mysqliInitSelect('landslides', array('id', 'lon', 'lat', 'display_big', 'count(*) AS count'), $where);
$landslides = mysqliGetMultiple($query);
mysqliDeleteQuery($query);

// loop quakes, generate result
foreach ($landslides as $slide) {
	$geometry = array('type' => 'Point',
			   'coordinates' => array((double)$slide['lon'],
			   						  (double)$slide['lat']));

	$feature = array('type' => 'Feature',
					   'id' => $slide['id'],
			   'properties' => array('display_big' => $slide['display_big'],
									 'count' 	   => $slide['count']),
				 'geometry' => $geometry);
	
	$result[] = $feature;
}

mysqliCloseConnection();

$json = array('type' => 'FeatureCollection',
		  'features' => $result);

echo json_encode($json);
?>
