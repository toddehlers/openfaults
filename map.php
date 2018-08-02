<link rel="stylesheet" href="css/ol.css" type="text/css">
<script src="include/ol.js" type="text/javascript"></script>

<div id="map_wrapper">
	<div id="map_size"><div id="map"></div></div>
	<div id="latlon"><span style="font-size: 10px;">Latitude: N/A&nbsp;&nbsp;&nbsp;Longitude: N/A</span></div>
</div>
<div id="map_menu">
	<!--<label><input type="checkbox" name="enableQuakeInduced" value="1" onchange="selectionChanged();" /> quake-induced landslides</label><br />-->
	<div> <!-- style="margin-top: 10px;" -->
		<h3>Display Layer:</h3>
		<select id="layer" onchange="selectionChanged();">
			<option value="" selected>Nothing</option>
			<option value="quake">Earthquakes</option>
			<option value="induced">Earthquake-induced Landslides</option>
			<option value="slide">Landslides</option>
		</select><br />
	</div>

	<div class="quake_buttons" style="margin-top: 10px; display: none;">
		<h3>Earthquake catalogue:</h3>
		<select id="quake_catalogue" onchange="selectionChanged();">
			<option value="tipage" selected>TIPAGE (2008 - 2010)</option>
			<option value="ferghana">Ferghana (2009 - 2010)</option>
			<option value="usgs">ANSS ComCat (1900 - 2014)</option>
		</select>
	</div>

	<div class="quake_buttons" style="margin-top: 10px; display: none;">
		<h3>Earthquake magnitude:</h3>
		<button onclick="clickQuakeMag(0)" class="quake_mag map_button selected">All</button><!--
     --><button onclick="clickQuakeMag(1)" class="quake_mag map_button">&lt; 5</button><!--
     --><button onclick="clickQuakeMag(2)" class="quake_mag map_button">&gt; 5</button>
	</div>

	<div class="quake_buttons" style="margin-top: 10px; display: none;">
		<h3>Earthquake depth:</h3>
		<button onclick="clickQuakeDepth(0)" class="quake_depth map_button selected">All</button><!--
     --><button onclick="clickQuakeDepth(1)" class="quake_depth map_button">&lt; 70 km</button><!--
     --><button onclick="clickQuakeDepth(2)" class="quake_depth map_button">&gt; 70 km</button>
	</div>

	<div class="slide_buttons" style="margin-top: 10px; display: none;">
		<h3>Landslide catalogue:</h3>
		<select id="slide_catalogue" onchange="selectionChanged();">
			<option value="Xu_etal_2015" selected>Xu et.al. (2015)</option>
		</select>
	</div>

	<div class="slide_buttons" style="margin-top: 10px; display: none;">
		<h3>Landslide area:</h3>
		<button onclick="clickSlideArea(0)" class="slide_area map_button selected">All</button><!--
		--><button onclick="clickSlideArea(1)" class="slide_area map_button">&lt; 10000 m2</button><!--
		--><button onclick="clickSlideArea(2)" class="slide_area map_button">&gt; 10000 m2</button>
	</div>

	<div id="map_buttons">
		<table class="quake_buttons" style="display: none;">
			<tr>
				<td><img src="images/fault.png" /></td>
				<td>Fault</td>
			</tr>
			<tr>
				<td><img src="images/mg5.png" /></td>
				<td>Magnitude &gt; 5</td>
			</tr>
			<tr>
				<td><img src="images/ml5.png" /></td>
				<td>Magnitude &lt; 5</td>
			</tr>
			<tr>
				<td><img src="images/dg70.png" /></td>
				<td>Depth &gt; 70 km</td>
			</tr>
			<tr>
				<td><img src="images/dl70.png" /></td>
				<td>Depth &lt; 70 km</td>
			</tr>
			<tr>
				<td><img src="images/after.png" /></td>
				<td>Nura Earthquake Aftershocks</td>
			</tr>
		</table>
		<table class="slide_buttons" style="display: none;">
			<tr>
				<td><img src="images/ll10k.png" /></td>
				<td>Area &lt; 10,000 m2</td>
			</tr>
			<tr>
				<td><img src="images/lg10k.png" /></td>
			    <td>Area &gt; 10,000 m2</td>
		    </tr>
			<tr>
				<td><img src="images/fault.png" /></td>
				<td>Fault</td>
		  	</tr>
		</table>
		<table class="quakeInduced_buttons" style="display: none;">
			<tr>
				<td><img src="images/ei.png" /></td>
				<td>Landslide Catalog Location</td>
			</tr>
			<tr>
	    		<td><img src="images/fault.png" /></td>
			  	<td>Fault</td>
			</tr>
  		</table>
	</div>
</div>
<div class="clear"></div>

<div id="tooltip" style="background: white; border: 1px solid black; margin-left: 10px; padding: 5px 10px;"></div>
<div id="infobox" style="background: white; border: 1px solid black; margin-left: 10px; padding: 5px 10px;"></div>

<script src="jMap.js" type="text/javascript"></script>
