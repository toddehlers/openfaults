<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub-functions
require_once 'include/include.php';

head("Download Data");

?>

<br /><h3><a href="downloads/faults_26012016.kmz">KML (Google Earth) File</a></b> (338 KB)</h3>
<p>Download the file and open into Google Earth to display fault data. The files will be added to the ‘Temporary Places’ folder and can be moved into the ‘My Places’ folder. Faults are colored-coded based on their sense of movement (red: normal, blue: strike-slip, black: reverse/thrust, grey: unclassified). Clicking on a fault trace will open a box that contains more information about the fault (e.g., its name, sense of movement, references and other remarks). In the near future, this box will contain a link to an information page that is connected to the online database. A fault can also be accessed through the Google Earth table of contents. The under the main folder (fault_merge), there is a list of fault names. Double-clicking on a fault name will take the user to the selected fault on the map.</p><br /><br />

<h3><a href="downloads/GIS_shapefiles.zip">GIS Shapefile</a></b> (281 KB zip file)</h3>
<p>The GIS Shapefiles can be opened in ArcMap. The attribute table includes information such as fault name, type, source, and other remarks. Some fields are automatically added, populated and maintained by ArcGIS (e.g., field ID, shape, x and y coordinates and shape length). Faults with no assigned names are labeled ‘unnamed’ in the Name field. Those with unknown sense of movement are labeled ‘unclassified’ in the Type field. The Source field includes references to studies that define the location of each fault trace. The Remark field includes information on variations in the fault name or location.</p><br />
<p>The ArcGIS files were updated on January 26, 2016 and are updated periodically with no set update time. Users are encouraged to regularly check the <a href="http://www.geo.uni-tuebingen.de/faults/">website</a> for the most updated version of the files.</p><br /><br />

<h3>Source Code</h3>
The source code behind the platform, engine and tools is openly available from a public <a href="https://github.com/timostrube/cafd">GitHub Repository</a>

<?php
foot();
?>
