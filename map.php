<link rel="stylesheet" href="css/ol.css" type="text/css">
<script src="include/ol.js" type="text/javascript"></script>

<div id="map_wrapper">
	<div id="map_size"><div id="map"></div></div>
	<div id="latlon"><span style="font-size: 10px;">Latitude: N/A&nbsp;&nbsp;&nbsp;Longitude: N/A</span></div>
</div>
<div id="map_menu">
	<div>
		<h3>Earthquakes:</h3>
		<label><input type="checkbox" name="show" value="1" onchange="selectionChanged();" /> Show earthquakes</label>
	</div>

	<div class="quake_buttons" style="margin-top: 10px;">
		<h3>Earthquake catalogue:</h3>
		<label><input type="radio" name="catalogue" value="tipage" onchange="selectionChanged();" checked /> TIPAGE (2008 - 2010)</label><br />
		<label><input type="radio" name="catalogue" value="ferghana" onchange="selectionChanged();" /> Ferghana (2009 - 2010)</label><br />
		<label><input type="radio" name="catalogue" value="usgs" onchange="selectionChanged();" /> ANSS ComCat (1900 - 2014)</label>
	</div>

	<div class="quake_buttons" style="margin-top: 10px;">
		<h3>Magnitude:</h3>
		<label><input type="radio" name="mag" value="0" onchange="selectionChanged();" checked /> All</label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="mag" value="1" onchange="selectionChanged();" /> &lt; 5</label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="mag" value="2" onchange="selectionChanged();" /> &gt; 5</label>
	</div>

	<div class="quake_buttons" style="margin-top: 10px;">
		<h3>Depth:</h3>
		<label><input type="radio" name="depth" value="0" onchange="selectionChanged();" checked /> All</label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="depth" value="1" onchange="selectionChanged();" /> &lt; 70km</label>&nbsp;&nbsp;&nbsp;
		<label><input type="radio" name="depth" value="2" onchange="selectionChanged();" /> &gt; 70km</label>
	</div>

	<div id="map_buttons">
		<table>
			<tr>
				<td><img src="images/fault.png" class="fix" valign="middle" /></td>
				<td>Fault</td>
			</tr>
			<tr>
				<td><img src="images/mg5.png" class="fix" valign="middle" /></td>
				<td>Magnitude &gt; 5</td>
			</tr>
			<tr>
				<td><img src="images/ml5.png" class="fix" valign="middle" /></td>
				<td>Magnitude &lt; 5</td>
			</tr>
			<tr>
				<td><img src="images/dg70.png" class="fix" valign="middle" /></td>
				<td>Depth &gt; 70 km</td>
			</tr>
			<tr>
				<td><img src="images/dl70.png" class="fix" valign="middle" /></td>
				<td>Depth &lt; 70 km</td>
			</tr>
			<tr>
				<td><img src="images/after.png" class="fix" valign="middle" /></td>
				<td>Nura Earthquake Aftershocks</td>
			</tr>
		</table>
	</div>
</div>
<div class="clear"></div>

<div id="popup" style="background: white; border: 1px solid black; margin-left: 10px; padding: 0 10px;"></div>

<script src="jMap.js" type="text/javascript"></script>
