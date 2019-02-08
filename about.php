<?php
// include all the sub functions
require_once 'include/include.php';

head(''); ?>

<h2 class="nopad"><a href="#open">CAFD at a Glance</a></h2>
<h2 class="nopad"><a href="#why">Why CAFD?</a></h2>
<h2 class="nopad"><a href="#data">Data Sources and Processing</a></h2>
<h3 class="nopad" style="text-indent: 2em;"><a href="#p1">1. Fault Locations</a></h3>
<h3 class="nopad" style="text-indent: 2em;"><a href="#p2">2. Earthquake Locations</a></h3>
<table border="0" cellspacing="0" cellpadding="0" style="padding: 0; margin: 0; width: 0;"><tr><td style="padding: 0; margin: 0; width: 0;"><h2 class="nopad"><a href="#cit">Citation</a></h2></td><td style="padding: 0; padding-left: 10px; margin: 0; width: 0; vertical-align: middle;" nowrap>- how to cite this work</td></tr></table>
<h2 class="nopad"><a href="#ack">Acknowledgments</a></h2>
<h2 class="nopad"><a href="#ref">References</a></h2>

<hr />

<h2><a class="link_nodec" name="open">CAFD at a Glance</a></h2>

<p>The Central Asia Fault Database (CAFD) allows users to access information on active faults that are located in Central Asia and the surrounding regions. The <a target="_blank" href="index.php">interactive map</a> displays two different datasets related to seismic hazards in Central Asia including (1) 1,196 faults that are linked to an online database that displays detailed information and references about each fault, and (2) the locations of historic earthquakes. The <a target="_blank" href="search.php">database search</a> tool permits simple search options (e.g., by fault name or location) and more complex queries (e.g., by seismic and structural characteristics). In addition, users can <a target="_blank" href="downloads.php">download data</a> formatted for use in ESRI ArcMap (.shp) and Google Earth (.kml).</p><br />

<h2><a class="link_nodec" name="why">Why CAFD?</a></h2>

<p>The ongoing collision of the Indian subcontinent with Asia controls active tectonics and seismicity in Central Asia and the surrounding regions. It has created a complex zone of deformation that is characterized by an intricate network of faults, some of which have historically caused devastating earthquakes and continue to pose serious threats to the population at risk. Locating and characterizing faults accurately are crucial to our understanding of earthquakes and addressing earthquake hazards. In particular, fault locations, slip rates and earthquake history are important input data that are often used in calculations of earthquake shaking hazards and probabilities, and hence, can serve as the basis for developing earthquake forecasts.</p><br />

<p>Previous and current studies in Central Asia have produced a large amount of data that continue to enhance our understanding of regional- and continental-scale tectonics as well as seismic hazards in the region. Geodetic measurements and regional seismic catalogs continue to provide a more detailed pattern and rates of deformation associated with individual faults and other major structures. High resolution imagery allows for more accurate mapping of previously recognized faults and their geomorphic expressions, and a significant number of previously unknown active structures have been detected and interpreted based on satellite images and digital topographic data.</p><br />

<p>All of these scientific investigations have generated data that are documented in a wide range of formats (e.g., digital, texts, maps, and images) and are often archived in restricted access journals. This can make access, usage, and dissemination of fault data a time consuming and resource intensive task. Despite initiatives that aim to provide a centralized place for storage, maintenance, and display of fault data specific to other regions of the world (e.g., Quaternary Fault and Fold Database of the United States), little attention has been given to development of a database that can store, display and allow public access to important fault parameters for Central Asian faults. The HimaTibetMap of Taylor and Yin (2009) remains to be the only publically available digital database of active structures located in Central Asia. Users can download and view fault location data on a semi-interactive map. The fault data, however, are unsearchable and limited to location, name, sense of motion and data source.</p><br />

<p>Our work compliments previous efforts by providing an open-access and searchable database that includes an interactive map that is linked to an online database. Database users can generate simple and complex quarries to access and view not only fault locations, but also important fault parameters such as slip rates, earthquake history, and geomorphic features. All data on this website are the product of work in progress and subject to change based on <a target="_blank" href="feedback.php">community’s feedback</a> and future refinement as more studies become available.</p><br />

<h2><a class="link_nodec" name="data">Data Sources and Processing</a></h2>

<p>The data shown in the interactive map include fault locations (red lines), earthquakes (colored circles).The latter is displayed as a turn on/off static layer, plotted over topographic data and fault locations. The descriptions and sources for each data layer are summarized below.</p><br />

<h3><a class="link_nodec" name="p1">1. Fault Locations</a></h3>

<p>Locations of faults shown in the interactive map come from previously published literature and databases. A large number of fault traces are taken from the <a target="_blank" href="https://github.com/HimaTibetMap/HimaTibetMap">HimaTibetMap</a> which is an open-source digital database of active faults located in the Indo-Asian collision zone. The faults taken from the HimaTibetMap are based on field observations and interpretations of satellite images and digital topographic data by Taylor et al. (2003) and Taylor and Yin (2009) as well as other previously published work. When digitized data are not available, we digitally captured individual fault traces from maps and figures using ArcMap software. This step required a comprehensive review of published literature that led to the selection of over 20 different scientific manuscripts from which fault traces were captured. To digitize a fault, a map is first aligned to available datasets (e.g., country boundaries) and then georeferenced using more accurate data layers such as ASTER GDEM2 (30-meter resolution). The fault traces are then digitized and linked to an attribute table in ArcMap. The attribute table contains information about each fault including its name, sense of movement, references, and other important remarks such as variations in fault name or location. Fault location accuracy depends on the scale of observation used in previous investigations. When there are discrepancies in fault locations, we slightly adjusted the position of previously mapped faults to coincide with surface features visible in satellite imagery or digital topography data that are indicative of their trace.</p><br />

<h3><a class="link_nodec" name="p2">2. Earthquake Locations and Magnitudes</a></h3>

<p>The events shown in the earthquake layer of the interactive map are from the TIPAGE (TIen Shan PAmir GEodynamic Program) catalog of Sippl et al. (2013), the Ferghana catalog of Feld et al. (2015), and the <a target="_blank" href="http://earthquake.usgs.gov/earthquakes/search/">ANSS Comprehensive Catalog</a> (ANSS ComCat). There are over 9,000 events from Sippl et al. (2013) which were recorded over a period of two years from August 2008 to June 2010 in the Pamir and southwest Tien Shan regions. There are 210 events detected by the Ferghana seismic network during a 12-month period in 2009-2010 in the Ferghana region (southern Kyrgyzstan). There are over 25,000 events from the ANSS ComCat which were recorded during 1900-2014. For both datasets, circle sizes denote different earthquake magnitudes (i.e., small circles represent events with M<5 and large circles represent events with M>5). The colors denote different depth levels (i.e., events <70 km deep are shown in orange and events >70km deep are shown in blue).</p><br />

<h2><a class="link_nodec" name="cit">Citation</a></h2>

<p>The Central Asia Fault Database is produced by <a target="_blank" href="https://uni-tuebingen.de/fakultaeten/mathematisch-naturwissenschaftliche-fakultaet/fachbereiche/geowissenschaften/arbeitsgruppen/mineralogie-geodynamik/forschungsbereich/geologie/people/solmaz-mohadjer/">Solmaz Mohadjer</a>, <a target="_blank" href="mailto:cafd@timostrube.de">Timo Strube</a>, <a target="_blank" href="https://uni-tuebingen.de/fakultaeten/mathematisch-naturwissenschaftliche-fakultaet/fachbereiche/geowissenschaften/arbeitsgruppen/mineralogie-geodynamik/forschungsbereich/geologie/people/todd-ehlers/">Todd Ehlers</a>, <a target="_blank" href="http://www.hs.umt.edu/geosciences/faculty/bendick/">Rebecca Bendick</a>, and <a target="_blank" href="http://www.geo.uni-potsdam.de/mitarbeiterdetails/show/673/Konstanze_St%C3%BCbner.html">Konstanze Stübner</a>.If you use this website in your published work, we would greatly appreciate it if you cite this website and related open-access publication at:</p><br />

<p><span style="color: #A51E38">Website:</span> Mohadjer, S., Strube, T., Ehlers, T.A., Bendick, R., 2015, Central Asia Fault Database. [ONLINE] Available at <a target="_blank" href="https://esdynamics.geo.uni-tuebingen.de/faults/">esdynamics.geo.uni-tuebingen.de/faults/</a> [<?php echo date('m/d/y'); ?>]</p><br />

<p><span style="color: #A51E38">Publication:</span> Mohadjer, S., Ehlers, T.A., Bendick, R., Stübner, K., Strube, T.: A Quaternary fault database for central Asia, Nat. Hazards Earth Syst. Sci., 16, 529-542, doi:10.5194/nhess-16-529-2016, 2016. (PDF file <a target="_blank" href="http://www.nat-hazards-earth-syst-sci.net/16/529/2016/">here</a>)</p><br />

<p>Questions can be directed to the authors via the <a target="_blank" href="feedback.php">feedback form</a>.</p><br />

<h2><a class="link_nodec" name="ack">Acknowledgments</a></h2>

<p>Financial support for this work was provided by a German Federal Ministry of Education and Research (BMBF) grant (to T. Ehlers) and a German Research Foundation (DFG) grant (to T. Ehlers and K. Stübner). The ASTER GDEM2 is a product of METI and NASA.</p><br />

<h2><a class="link_nodec" name="ref">References</a></h2>

<p>Feld, C., Haberland, C., Schurr, B., Sippl, C., Wetzel, H.-U., Roessner, S., Ickrath, M., Abdybachaev, U., Orunbaev, S. (2015): Seismotectonic study of the Fergana Region (Southern Kyrgyzstan): distribution and kinematics of local seismicity. - Earth Planets and Space, 67.</p><br />

<p>Sippl, C., Schurr, B., Yuan, X., Mechie, J., Schneider, F.M., Gadoev, M., Orunbaev, S., Oimahmadov, I., Haberland, C., Abdybachaev, U., Minaev, V., Negmatullaev, S., and Radjabov, N., 2013, Geometry of the Pamir-Hindu Kush intermediate-depth earthquake zone from local seismic data, J. Geophys. Res. Solid Earth, 118, 1438–1457, doi:10.1002/jgrb.50128.</p><br />

<p>Taylor, M., and Yin, A., 2009, Active structures of the Himalayan-Tibetan orogen and their relationships to earthquake distribution, contemporary strain field, and Cenozoic volcanism, Geosphere v. 5, no. 3, pp 199-214.</p><br />

<p>Taylor, M., Yin, A., Ryerson, F., Kapp, P., and Ding, L., 2003, Conjugate strike slip fault accommodates coeval north-south shortening and east-west extension along the Bangong-Nujiang suture zone in central Tibet, Tectonics, v. 22, doi:10.1029/2002TC001361/</p>

<?php foot(); ?>
