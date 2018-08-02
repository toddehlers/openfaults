<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub-functions
require_once 'include/include.php';
$check_line = '';

if (isset($_POST['submit']) && $_POST['pass'] == $cfg_import_pass) {
	$file = fopen($_FILES['file']['tmp_name'], "r");

	if ($file) {
		while(!feof($file)) {
			$line = fgets($file);
			if (strpos($line, ",") !== false)
				$lines[] = explode(',', $line);
			elseif (strpos($line, "N  ") !== false &&
				strpos($line, "E  ") !== false) {
					$lines[] = array(trim(substr($line, 23, 7)),
						trim(substr($line, 32, 8)),
						trim(substr($line, 42, 6)),
						trim(substr($line, 49, 4)));
					if ($check_line == '')
						$check_line = $line;
				}
		}

		fclose($file);

		if (strpos($lines[0][0], "latitude") !== false &&
			strpos($lines[0][1], "longitude") !== false &&
			strpos($lines[0][2], "depth") !== false &&
			strpos($lines[0][3], "mag") !== false)
			$offset = 0;
		elseif (strpos($lines[0][0], "OID") !== false &&
			strpos($lines[0][1], "Latitude") !== false &&
			strpos($lines[0][2], "Longitude") !== false &&
			strpos($lines[0][3], "Depth_km") !== false &&
			strpos($lines[0][4], "Local_magn") !== false)
			$offset = 1;
		elseif (strpos($check_line, "N  ") !== false &&
			strpos($check_line, "E  ") !== false)
			$offset = 0;
		else {
			echo 'File is in the wrong format.<br /><br />Debuginfo:<br /><br />';
			var_dump($lines[0]);
			exit;
		}

		if ($check_line == '')
			unset($lines[0]);

		$i = 0;
		foreach ($lines as $line) {
			$insert_array['lat'] = round($line[0 + $offset], 4);
			$insert_array['lon'] = round($line[1 + $offset], 4);
			$insert_array['depth'] = round($line[2 + $offset], 2);
			$insert_array['magnitude'] = round($line[3 + $offset], 2);
			$insert_array['data_source'] = $_POST['database'];

			$result = mysqliInsert('earthquakes', $insert_array);

			if (!$result) {
				$where  = 'lat="' . $insert_array['lat'] . '"';
				$where .= 'AND lon="' . $insert_array['lon'] . '"';
				$where .= 'AND depth="' . $insert_array['depth'] . '"';
				$where .= 'AND magnitude="' . $insert_array['magnitude'] . '"';
				$where .= 'AND data_source="' . $insert_array['data_source'] . '"';

				mysqliDelete('earthquakes', $where);

				$result = mysqliInsert('earthquakes', $insert_array);
			}

			if ($result) $i++;
		}

		echo '<br />' . $i . ' new entries';
		exit;

	} else {
		echo 'File could not be read.';
		exit;
	}
}

head('Import'); ?>

<form action="import.php" method="POST" autocomplete="false" enctype="multipart/form-data">
	<table border="0">
		<tr>
			<td>
				Database
			</td>
			<td>
				<select name="database">
					<option value=""></option>
					<option value="tipage">GFZ</option>
					<option value="ferghana">Ferghana</option>
					<option value="usgs">USGS</option>
					<option value="aftershock">Aftershock</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				File
			</td>
			<td>
				<input type="file" name="file" />
			</td>
		</tr>
		<tr>
			<td>
				Password
			</td>
			<td>
				<input type="password" name="pass" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" /></td>
		</tr>
	</table>
</form>

<?php foot(); ?>
