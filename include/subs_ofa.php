<?php
// Programmed by Timo Strube, updated 22.05.2015

function getFaultNameForID($id) {
	$query = mysqliInitSelect('faults', array('name'), 'id=' . $id);
	$result = mysqliGetSingle($query);
	mysqliDeleteQuery($query);
	
	return $result['name'];
}

function generateViewFromDBResult($result) {
	$sections = array();
	
	$linesFaultname = array();
	//$linesFaultname[] = array('Fault ID', issetReturn($result['id']));
	$linesFaultname[] = array('Name', issetReturn($result['name']));
	$linesFaultname[] = array('<i>comments</i>', issetReturn($result['name_comments']));
	$linesFaultname = checkLinesComments($linesFaultname);
	
	$linesGeographic = array();
	$linesGeographic[] = array('Country', issetReturn($result['country']));
	$linesGeographic[] = array('Province', issetReturn($result['province']));
	$linesGeographic[] = array('Exposure', issetReturn($result['exposure']));
	$linesGeographic[] = array('<i>comments</i>', issetReturn($result['exposure_comments']));
	$linesGeographic = checkLinesComments($linesGeographic);
	
	$linesSeismic = array();
	$linesSeismic[] = array('Geodetic slip rate (mm/yr)', (issetReturn($result['geodetic_min_reported_range']) == '' ? '?' : $result['geodetic_min_reported_range']) . ' - ' . (issetReturn($result['geodetic_max_reported_range']) == '' ? '?' : $result['geodetic_max_reported_range']));
	$linesSeismic[] = array('<i>comments</i>', issetReturn($result['geodetic_comments']));
	$linesSeismic[] = array('InSAR', issetReturn($result['InSAR']));
	$linesSeismic[] = array('Geologic slip rate (mm/yr)', (issetReturn($result['geologic_min_reported_range']) == '' ? '?' : $result['geologic_min_reported_range']) . ' - ' . (issetReturn($result['geologic_max_reported_range']) == '' ? '?' : $result['geologic_max_reported_range']));
	$linesSeismic[] = array('<i>comments</i>', issetReturn($result['geologic_comments']));
	$linesSeismic[] = array('Historic earthquake', issetReturn($result['earthquake']));
	$linesSeismic[] = array('Geomorphic expression', issetReturn($result['geomorphic']));
	$linesSeismic[] = array('Trench studies', issetReturn($result['trench']));
	$linesSeismic[] = array('Paleoseismic studies', issetReturn($result['paleoseismic_studies']));
	$linesSeismic[] = array('Paleomagnetic studies', issetReturn($result['paleomagnetic_studies']));
	$linesSeismic = checkLinesComments($linesSeismic);

	$linesStructural = array();
	$linesStructural[] = array('Primary sense of motion', issetReturn($result['motion']));
	$linesStructural[] = array('<i>comments</i>', issetReturn($result['motion_comments']));
	$linesStructural[] = array('Dip direction', issetReturn($result['dip_direction']));
	$linesStructural[] = array('<i>comments</i>', issetReturn($result['dip_direction_comments']));
	$linesStructural[] = array('Length', issetReturn($result['length']));
	$linesStructural[] = array('<i>comments</i>', issetReturn($result['length_comments']));
	$linesStructural[] = array('Average strike', issetReturn($result['strike']));
	$linesStructural[] = array('<i>comments</i>', issetReturn($result['strike_comments']));
	$linesStructural = checkLinesComments($linesStructural);

	$linesDescription = array(array('', issetReturn($result['description'])));

	// This gets removed and replaced by the new references-table
	$linesReferences = generateReferences($result['id']);
	
	if (!$linesReferences)
		$linesReferences = array(array('', issetReturn($result['references'])));

	$sections[] = array('', $linesFaultname);
	$sections[] = array('Geographic characteristics', $linesGeographic);
	$sections[] = array('Seismic characteristics', $linesSeismic);
	$sections[] = array('Structural characteristics', $linesStructural);
	$sections[] = array('Description', $linesDescription);
	$sections[] = array('References', $linesReferences);
	
	foreach ($sections as $section)
		generateViewSection($section);
}

function generateViewSection($section) {
	if (sectionHasContent($section)) {
		if ($section[0] != '')
			echo '		<h3 class="space">' . $section[0] . '</h3>
';

		foreach ($section[1] as $line)
			generateViewLine($line);
	}
}

function generateViewLine($line) {
	if ($line[1] != '' && $line[1] != '? - ?') {
		if ($line[0] == '') {
			echo '			<div class="view_content">' . $line[1] . '</div>
';
		} else {
			echo '			<div class="view_line">
				<div class="view_name' . (strpos($line[0], '<i>') !== false ? ' view_comment' : '') . '">' . $line[0] . '</div>
				<div class="view_content' . (strpos($line[0], '<i>') !== false ? ' view_comment' : '') . '">' . $line[1] . '</div>
			</div>
';
		}
	} 
}

function sectionHasContent($section) {
	$return = false;
	
	foreach ($section[1] as $line)
		$return = $return || ($line[1] != '' && $line[1] != '? - ?');
	
	return $return; 
}

// check lines with comments: Show a headline, when comments but no data in headline
function checkLinesComments($lines) {
	$output = array();
	foreach ($lines as $key => $value) {
		$output[$key] = $value;
		
		if (strpos($value[0], '</i>') !== false && 
			$value[1] != '' &&
			($output[$key - 1][1] == '' || $output[$key - 1][1] == '? - ?'))
				$output[$key - 1][1] = 'Insufficient Data';
	}
	return $output;
}

function generateReferences($id) {
	$query = mysqliInitSelect('references', array('display', 'title'), 'fault_id LIKE \'%,' . $id . ',%\'', 'display');
	$result = mysqliGetMultiple($query);
	mysqliDeleteQuery($query);

	if ($result) {
		$return = '';
		
		foreach ($result as $value) {
			if (!empty($return))
				$return .= '; ';
			
			if (!empty($value['title']))
				$return .= '<a target="_blank" href="https://scholar.google.com/scholar?q=' . $value['title'] . '">';
			
			$return .= $value['display'];
			
			if (!empty($value['title']))
				$return .= '</a>';
		}
		
		return array(array('', $return));
	} else 
		return false;
}

?>