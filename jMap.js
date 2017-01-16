// Programmed by Timo Strube, updated 24.05.2015

///////////////////////
/// M A I N   M A P ///
///////////////////////

// Init Map
var href = window.location.href;
var zoomlevel = href.search('search.php');

var view = new ol.View({
	center: ol.proj.transform([((zoomlevel > -1) ? 87 : 81), ((zoomlevel > -1) ? 33 : 35.5)], 'EPSG:4326', 'EPSG:3857'),
	resolution: ((zoomlevel > -1) ? 10000 : 5000),
	minResolution: 0,
	maxResolution: 50000
});

var scaleLineControl = new ol.control.ScaleLine();

var map = new ol.Map({
	controls: ol.control.defaults({
		attributionOptions: ({ collapsible: false })
	}).extend([
		scaleLineControl
	]),
    target: 'map',
	layers: [
		new ol.layer.Tile({
			source: new ol.source.BingMaps({
        key: 'Aj6DIWfGOpAqw6zYpiqoOQ4UWwc-wDWOxOi1_HBnBsShQyGLCY49lxDebO6UXZiu',
        imagerySet: 'Road',
				maxZoom: 19
      })
		})
	],
	view: view
});


/////////////////////////////
/// L O A D   F A U L T S ///
/////////////////////////////

var styleFaultCache = [];
var center = [];
var center_zoom;

// Load faults
var faultsLayer = new ol.layer.Vector({
	source: new ol.source.Vector({
		projection: 'EPSG:3857',
		url: 'openlayers/ol_faults.php?id='+getQueryVariable('id')+'&search='+getQueryVariable('search'),
		format: new ol.format.GeoJSON()
	}),
	style: (function(feature, resolution) {
		var zoom_res = view.getResolution();

		if (zoom_res >= 2500)
			zoom_res = 2;
		else if (zoom_res < 500)
			zoom_res = 9;
		else if (zoom_res < 1000)
			zoom_res = 7;
		else if (zoom_res < 2500)
			zoom_res = 5;

		var highlight = 'h' + feature.get('highlight') + 'z' + zoom_res;

		if (feature.get('center')) {
			center = feature.get('center');
			center_zoom = feature.get('zoom');
		}

		if (feature.get('highlight') == 1)
			var rgba = 'rgba(0, 0, 0, 1.0)';
		else
			var rgba = 'rgba(255, 0, 0, 0.6)';

		if (!styleFaultCache[highlight])
			styleFaultCache[highlight] = [new ol.style.Style({
				stroke: new ol.style.Stroke({
					color: rgba,
					width: Math.max(2, Math.min(10, zoom_res))
				})
			})];

		return styleFaultCache[highlight];
	})
});
map.addLayer(faultsLayer);

// center current fault
faultsLayer.getSource().on('change', function(e) {
	setTimeout(function() {
		if (center.length > 0) {
			var ani_pan = new ol.animation.pan({
				duration: 1000,
				source: view.getCenter()
			});

			var ani_zoom = ol.animation.zoom({
				resolution: view.getResolution()
			});

			map.beforeRender(ani_pan, ani_zoom);

			view.setCenter(ol.proj.transform(center, 'EPSG:4326', 'EPSG:3857'));
       		view.setResolution(view.getResolution() * center_zoom);
		}
	}, 100);
});

/////////////////////////////
/// L O A D   Q U A K E S ///
/////////////////////////////

var styleQuakeCache = [];
var vectorSource;

// Load earthquakes
function generateQuakeLayer(c, d, m) {
	vectorSource = new ol.source.Vector({
		projection: 'EPSG:3857',
		url: 'openlayers/ol_quakes.php?c='+c+'&d='+d+'&m='+m,
		format: new ol.format.GeoJSON()
	});

	return new ol.layer.Vector({
		source: vectorSource,
		style: (function(feature, resolution) {
			var radius = feature.get('magnitude') > 5 ? 10 : 5;

			if (feature.get('data_source') == 'aftershock') {
				var rgb = '125, 255, 0';
				var id = radius + 1;
			} else if (feature.get('depth') > 70) {
				var rgb = '0, 190, 255';
				var id = radius + 2;
			} else {
				var rgb = '255, 150, 0';
				var id = radius + 3;
			}

			if (!styleQuakeCache[id])
				styleQuakeCache[id] = [new ol.style.Style({
					image: new ol.style.Circle({
						radius: radius,
						fill: new ol.style.Fill({
							color: 'rgba('+rgb+', 0.2)'
						}),
						stroke: new ol.style.Stroke({
							color: 'rgba('+rgb+', 1)',
							width: 1
						})
					})
				})];

			return styleQuakeCache[id];
		})
	});
}

/////////////////////
/// B U T T O N S ///
/////////////////////
var quakeLayers = [];

//$(document).ready(function(){ $("#tipage").multiselect(); });
//$(document).ready(function(){ $("#usgs").multiselect(); });

//$("#tipage").change(function() { processMultiselect("#tipage"); });
//$("#usgs").change(function() { processMultiselect("#usgs"); });

// function processMultiselect(id) {
	// var bin = 0, new_bin = 0, c = '', d = 0, m = 0;
	// var input = $(id).val();
//
	// if (input !== null)
		// input.forEach(function (val) {
			// bin += parseInt(val);
		// });
//
	// // Depth
	// new_bin = bin % 8;
	// if (new_bin != bin)
		// d += 2;
	// bin = new_bin;
//
	// new_bin = bin % 4;
	// if (new_bin != bin)
		// d += 1;
	// bin = new_bin;
//
	// // Magnitude
	// new_bin = bin % 2;
	// if (new_bin != bin)
		// m += 2;
	// bin = new_bin;
//
	// new_bin = bin % 1;
	// if (new_bin != bin)
		// m += 1;
//
	// // Catalogue
	// c = id.substr(1);
//
	// showQuake(c, d, m);
// }


$(".quake_buttons").css("display", "none");

function selectionChanged() {
	var show = $("input[type='checkbox'][name='show']").is(':checked');
	var catalogue = $("input[type='radio'][name='catalogue']:checked").val();
	var mag = $("input[type='radio'][name='mag']:checked").val();
	var depth = $("input[type='radio'][name='depth']:checked").val();

	if (show) {
		$(".quake_buttons").css("display", "block");

		showQuake(catalogue, depth, mag);
	} else {
		$(".quake_buttons").css("display", "none");

		quakeLayers.forEach(function (val) {
			val.setVisible(false);
		});
	}
}

var opts = {
  lines: 13 // The number of lines to draw
, length: 28 // The length of each line
, width: 14 // The line thickness
, radius: 42 // The radius of the inner circle
, scale: 1 // Scales overall size of the spinner
, corners: 1 // Corner roundness (0..1)
, color: '#000' // #rgb or #rrggbb or array of colors
, opacity: 0.25 // Opacity of the lines
, rotate: 0 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 1 // Rounds per second
, trail: 60 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '50%' // Top position relative to parent
, left: '50%' // Left position relative to parent
, shadow: false // Whether to render a shadow
, hwaccel: false // Whether to use hardware acceleration
, position: 'relative' // Element positioning
};
var target = document.getElementById('map_size');
var spinner = new Spinner(opts);

function showQuake(c, d, m) {
	quakeLayers.forEach(function (val) {
		val.setVisible(false);
	});

    if (c == 'tipage')
  		var c_nr = '1';
    else if (c == 'usgs')
    	var c_nr = '2';
		else if (c == 'ferghana')
			var c_nr = '3';

	if (!quakeLayers[c_nr+d+m]) {
		spinner.spin(target);

		quakeLayers[c_nr+d+m] = generateQuakeLayer(c, d, m);
		map.addLayer(quakeLayers[c_nr+d+m]);

		var listenerKey = vectorSource.on('change', function(e) {
			if (vectorSource.getState() == 'ready') {
				spinner.stop();
				ol.Observable.unByKey(listenerKey);
			}
		});

	} else
		quakeLayers[c_nr+d+m].setVisible(true);
}


/////////////////
/// P O P U P ///
/////////////////

// Add popup functionality
var container = document.getElementById('popup');
var overlay = new ol.Overlay({ element: container });
map.addOverlay(overlay);

// Generate Info Box
var displayFeatureInfo = function(pixel, coords) {
	var feature = getFeature(pixel);

	if (feature && feature.get('fault_id') > 0 && feature.get('name') != '') {
		container.style.display = 'block';
		overlay.setPosition([coords[0] + view.getResolution() * 5, coords[1]]);
		container.innerHTML = feature.get('name');
		$("#map").css("cursor", "pointer");
	} else {
		container.style.display = 'none';
		$("#map").css("cursor", "move");
	}
};

// Open Fault Page
var openFaultInfo = function(pixel) {
	var feature = getFeature(pixel);
	if (feature && feature.get('fault_id') > 0)
		window.location = "view.php?id="+feature.get('fault_id');
};

// getFeature
var getFeature = function(pixel) {
	return map.forEachFeatureAtPixel(pixel, function(feature, layer) {
		return feature;
	});
};

// Track mouse movement
map.on('pointermove', function(evt) {
	if (evt.dragging)
		container.style.display = 'none';
	else
		displayFeatureInfo(map.getEventPixel(evt.originalEvent), evt.coordinate);

  	// Display coordinates
	var latlon = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
	document.getElementById('latlon').innerHTML = '<span style="font-size: 10px;">Latitude: '+latlon[1].toFixed(4)+'&nbsp;&nbsp;&nbsp;Longitude: '+latlon[0].toFixed(4)+'</span>';
});

// Track mouse clicks
map.on('click', function(evt) {
	openFaultInfo(map.getEventPixel(evt.originalEvent));
});



// Helper
function getQueryVariable(variable)
{
	   var query = window.location.search.substring(1);
	   var vars = query.split("&");
	   for (var i=0;i<vars.length;i++) {
	           var pair = vars[i].split("=");
	           if(pair[0] == variable){return pair[1];}
	   }
	   return(false);
}
