<?php

if (!isset($_GET['id']))
	$_GET['id'] = 0;

$links = array();
$unten = array();

array_push($links, array('index.php', 'SHOW MAP', true, null));
array_push($links, array('search.php', 'SEARCH FAULTS', true, null));
array_push($links, array('downloads.php', 'DOWNLOADS', true, null));
array_push($links, array('feedback.php', 'FEEDBACK', true, null));
array_push($links, array('about.php', 'ABOUT', true, null));

//array_push($unten, array('view.php?id=' . $_GET['id'], 'Information', $_GET['id'] != 0, $_GET['id'] > 0));
//array_push($unten, array('index.php?id=' . $_GET['id'], 'Location', $_GET['id'] != 0, $_GET['id'] > 0));

function gen_link($links) {
	foreach ($links as $value) {
		if ($value[2]) {
			$url = basename($_SERVER['PHP_SELF']);
			if ($url == $value[0] || $url == $value[3])
				echo '<li class="current">' . $value[1] . '</li>';
			else
				echo '<li><a href="' . $value[0] . '">' . $value[1] . '</a></li>';
		}
	}
}

?>

<div id="navigation">
	<ul>
		<?php gen_link($links); ?>
	</ul>
</div>
<div class="line"></div><br />

	<?php
		echo (!empty($page) ? '<h2>' . $page . '</h2>' : '');
	?>
