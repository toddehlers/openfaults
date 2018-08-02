<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub functions
require_once '../include/include.php';

// query quakes
$query = mysqliInitSelect('quake_induced', array('*'));
$earthquakes = mysqliGetMultiple($query);
mysqliDeleteQuery($query);

// loop quakes, generate result
foreach ($earthquakes as $quake) {
	$geometry = array('type' => 'Point',
			   'coordinates' => array((double)$quake['lon'],
			   						  (double)$quake['lat']));

	$feature = array('type' => 'Feature',
					   'id' => $quake['id'],
			   'properties' => array(	  'name' => $quake['name'],
									 'magnitude' => $quake['magnitude'],
										  'time' => $quake['time'],
								   'slide_count' => $quake['slide_count'],
									  'download' => $quake['download']),
				 'geometry' => $geometry);

	$result[] = $feature;
}

mysqliCloseConnection();

$json = array('type' => 'FeatureCollection',
		  'features' => $result);

echo json_encode($json);
?>
