<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub functions
require_once 'include/include.php';
head("");

// dropdown contens
$country = array('Afghanistan', 'China', 'India', 'Iran', 'Kazakhstan', 'Kyrgyzstan', 'Pakistan', 'Tajikistan', 'Uzbekistan');
$province = array('Pamir', 'Tien Shan', 'Alai Valley', 'Tarim Basin', 'Northern Tibet', 'Central Tibet', 
	'Southern Tibet', 'Eastern Tibet', 'Fergana Basin', 'Tajik Depression', 'North Afghan Platform', 'Makran', 'Hindu Kush-Pamir', 
	'Kirthar-Sulaiman', 'Himalaya', 'Mongolian-Gobi Altay', 'Qaidam Basin', 'Shangxi Graben', 'Alai Range');
sort($province);
$slip_rate = array('All', 'More than 5.0 mm/yr', 'Between 1.0 and 5.0 mm/yr', 'Between 0.2 and 1.0 mm/yr', 'Less than 0.2 mm/yr', 'Insufficient data');
$motion = array('All', 'Normal', 'Reverse/Thrust', 'Strike-slip', 'Dextral (right lateral)', 'Sinistral (left lateral)');

// process search
$_SESSION['map_search'] = '';
unset($_GET['id']);
if (!empty($_GET)) {
	// generate search string
	$search_array = array();
	
	// Check name
	if (!empty($_GET['name']))
		$search_array[] = 'name LIKE \'%' . mres($_GET['name']) . '%\' OR name_comments LIKE \'%' . mres($_GET['name']) . '%\'';

	// Check country
	$temp_string = '';
	if (!empty($_GET['country'])) {
		foreach ($_GET['country'] as $value) {
			if (!empty($temp_string))
				$temp_string .= ' OR ';
			
			$temp_string .= 'country LIKE \'%' . mres($value) . '%\'';
		}
		
		if (!empty($temp_string))
			$search_array[] = $temp_string;
	}
		
	// Check province
	$temp_string = '';
	if (!empty($_GET['province'])) {
		foreach ($_GET['province'] as $value) {
			if (!empty($temp_string))
				$temp_string .= ' OR ';
			
			$temp_string .= 'province LIKE \'%' . mres($value) . '%\'';
		}
		
		if (!empty($temp_string))
			$search_array[] = $temp_string;
	}
	
	// Geodetic Slip Rate
	if (!empty($_GET['geod_sr_min']))
		$search_array[] = 'geodetic_max_reported_range >= ' . mres($_GET['geod_sr_min']);
	if (!empty($_GET['geod_sr_max']))
		$search_array[] = 'geodetic_min_reported_range <= ' . mres($_GET['geod_sr_max']);
	
	// Quarternary Slip Rate
	if (!empty($_GET['quart_sr_min']))
		$search_array[] = 'geologic_max_reported_range >= ' . mres($_GET['quart_sr_min']);
	if (!empty($_GET['quart_sr_max']))
		$search_array[] = 'geologic_min_reported_range <= ' . mres($_GET['quart_sr_max']);

	// Check Earthquakes
	if (!empty($_GET['earthquakes']))
		switch($_GET['earthquakes']) {
		    case 'Yes':
				$search_array[] = 'earthquake IS NOT NULL OR NOT earthquake=\'\'';
		        break;
		    case 'No':
				$search_array[] = 'earthquake IS NULL OR earthquake=\'\'';
		        break;
		}
	
	// Check Expressions
	if (!empty($_GET['expressions']))
		switch($_GET['expressions']) {
		    case 'Yes':
				$search_array[] = 'geomorphic IS NOT NULL OR NOT earthquake=\'\'';
		        break;
		    case 'No':
				$search_array[] = 'geomorphic IS NULL OR earthquake=\'\'';
		        break;
		}
		
	//
	if (!empty($_GET['paleoseismic']))
		switch($_GET['paleoseismic']) {
		    case 'Yes':
				$search_array[] = 'paleoseismic_studies IS NOT NULL OR NOT paleoseismic_studies=\'\' OR trench IS NOT NULL OR NOT trench=\'\'';
		        break;
		    case 'No':
				$search_array[] = 'paleoseismic_studies IS NULL OR paleoseismic_studies=\'\' OR trench IS NULL OR trench=\'\'';
		        break;
		}

	// Check Sense of motion
	if (!empty($_GET['motion']))
		if ($_GET['motion'] != 'All')
			if ($_GET['motion'] == 'Reverse/Thrust') {
				$search_array[] = 'motion LIKE \'%reverse%\' OR motion LIKE \'%thrust%\'';
			} else 
				$search_array[] = 'motion LIKE \'%' . mres($_GET['motion']) . '%\'';
	
	if (!empty($search_array)) {
		$search_string = '(';
		foreach ($search_array as $value) {
			if ($search_string != '(')
				$search_string .= ') AND (';
			$search_string .= $value;
		}
		$search_string .= ')';
	} else
		$search_string = '';

	// start the query
	$query = mysqliInitSelect('faults', array('id', 'name'), $search_string, 'name ASC', '');
	
	// if something is found, continue to output a result list
	if (mysqliGetNumber($query)) {
		$result = mysqliGetMultiple($query);
		$number = mysqliGetNumber($query);
		mysqliDeleteQuery($query);
		
		foreach ($result as $val) {
			if (!empty($_SESSION['map_search']))
				$_SESSION['map_search'] .= ';';
			$_SESSION['map_search'] .= $val['id'];
		}
	}
}	
// search form
?>
<p>Fill in one or more fields and start search. The search tool permits searches on fault name and location. Users can also limit their search results by making queries on seismic and structural characteristics of faults.</p><br />

<div id="search_menu">
	<form action="search.php" action="get">
	<table>
		<tr>
			<td><h3>Fault Name</h3></td>
			<td><input type="text" name="name" value="<?php echo issetReturnGET('name'); ?>" /></td>
		</tr>
	</table>
	
	<br /><h3>Geographic Characteristics</h3>
	<table>
		<tr>
			<td>Country</td>
			<td><select name="country[]" id="country" multiple="multiple" />
				<?php 
					foreach ($country as $value) 
						echo '<option value="' . $value . '"' . (in_array($value, issetReturnGET('country')) ? ' selected' : '') . '>' . $value . '</option>'; 
				?>		
			</select></td>
		</tr>
		<tr>
			<td>Physiographic province</td>
			<td><select name="province[]" id="province" multiple="multiple" />
				<?php 
					foreach ($province as $value) 
						echo '<option value="' . $value . '"' . (in_array($value, issetReturnGET('province')) ? ' selected' : '') . '>' . $value . '</option>'; 
				?>		
			</select></td>
		</tr>
	</table>
	
	<br /><h3>Seismic Characteristics</h3>
	<table>
		<tr>
			<td>Geodetic Slip Rate (mm/yr)</td>
			<td>min: <input name="geod_sr_min" style="width: 30px;" value="<?php echo issetReturnGET('geod_sr_min'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				max: <input name="geod_sr_max" style="width: 30px;" value="<?php echo issetReturnGET('geod_sr_max'); ?>" /></td>
		</tr>
		<tr>
			<td>Quaternary Slip Rate (mm/yr)</td>
			<td>min: <input name="quart_sr_min" style="width: 30px;" value="<?php echo issetReturnGET('quart_sr_min'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				max: <input name="quart_sr_max" style="width: 30px;" value="<?php echo issetReturnGET('quart_sr_max'); ?>" /></td>
		</tr>
		<tr>
			<td>Historical Earthquakes</td>
			<td><select name="earthquakes" />
				<option<?php echo issetReturnGET('earthquakes') == 'All' ? ' selected' : ''; ?>>All</option>
				<option<?php echo issetReturnGET('earthquakes') == 'Yes' ? ' selected' : ''; ?>>Yes</option>
				<option<?php echo issetReturnGET('earthquakes') == 'No' ? ' selected' : ''; ?>>No</option>
			</select></td>
		</tr>
		<tr>
			<td>Geomorphic expressions</td>
			<td><select name="expressions" />
				<option<?php echo issetReturnGET('expressions') == 'All' ? ' selected' : ''; ?>>All</option>
				<option<?php echo issetReturnGET('expressions') == 'Yes' ? ' selected' : ''; ?>>Yes</option>
				<option<?php echo issetReturnGET('expressions') == 'No' ? ' selected' : ''; ?>>No</option>
			</select></td>
		</tr>
		<tr>
			<td>Paleoseismic studies</td>
			<td><select name="paleoseismic" />
				<option<?php echo issetReturnGET('paleoseismic') == 'All' ? ' selected' : ''; ?>>All</option>
				<option<?php echo issetReturnGET('paleoseismic') == 'Yes' ? ' selected' : ''; ?>>Yes</option>
				<option<?php echo issetReturnGET('paleoseismic') == 'No' ? ' selected' : ''; ?>>No</option>
			</select></td>
		</tr>
	</table>
	
	<br /><h3>Structural Characteristics</h3>
	<table>
		<tr>
			<td>Sense of movement</td>
			<td><select name="motion" />
				<?php 
					foreach ($motion as $value) 
						echo '<option value="' . $value . '"' . (issetReturnGET('motion') == $value ? ' selected' : '') . '>' . $value . '</option>'; 
				?>		
			</select></td>
		</tr><tr>
			<td></td>
			<td style="text-align: right;"><input type="submit" name="submit" value="Search" style="height: 40px; width: 100px; margin-top: 15px; font-size: 18px;" /></td>
		</tr>
	</table>
	</form>
</div>

<div id="search_results_wrapper">
	<div id="search_results">
		<div id="map"></div>
		<div id="latlon"><span style="font-size: 10px;">Latitude: N/A&nbsp;&nbsp;&nbsp;Longitude: N/A</span></div>
	</div>
</div>
<div class="clear"></div><br />
<?php
	if (!empty($_SESSION['map_search'])) {
		
		echo "<span style=\"color: #A51E38;\">" . $number . " fault" . ($number == 1 ? '' : 's') . " found.</span><br /><br />";
		
		echo '<table style="width: 100%;">';
		
		// loop through the results and generate the table
		foreach ($result as $value) {
			echo '<tr class="list hover" onClick="window.location.href=\'view.php?id=' . $value['id'] . '\'">
			<td>' . $value['name'] . '</td></tr>';	
		}
		
		echo '</table>';
	} else if (isset($_GET['submit'])) {
		echo "<span style=\"color: #A51E38;\">0 faults found.</span>";
	}
?>

<link rel="stylesheet" href="https://openlayers.org/en/v3.7.0/css/ol.css" type="text/css">
<script src="https://openlayers.org/en/v3.7.0/build/ol.js" type="text/javascript"></script>
<div id="popup" style="background: white; border: 1px solid black; margin-left: 10px; padding: 0 10px;"></div>
<script src="jMap.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
   $("#country").multiselect();
});
$(document).ready(function(){
   $("#province").multiselect();
});
</script>

<?php foot(); ?>
