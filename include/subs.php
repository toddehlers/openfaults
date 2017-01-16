<?php

// Programmed by Timo Strube, updated 22.05.2015

// HTML-Header
function head($page) {
	echo '
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>' . $GLOBALS['cfg_title'] . (!empty($page) ? ' - ' . $page : '') . '</title>
	<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="faviconfavicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="faviconfavicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="faviconfavicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="favicon/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="faviconfavicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#a51e38">
	<meta name="msapplication-TileImage" content="favicon/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="css/template.css" />
	<link rel="stylesheet" href="css/media.css" />
	<link rel="stylesheet" href="css/jquery.multiselect.css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
	<script src="include/jquery.multiselect.js" type="text/javascript"></script>
	<script src="include/spin.min.js" type="text/javascript"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
';

require_once 'analytics.php';

echo '
</head>
<body>
<div id="wrapper">
';
	include "head.php";


}

// HTML-Footer
function foot() {
	$query = mysqliInitSelect('faults', array('MAX(last_update)'));
	$result = mysqliGetSingle($query);
	mysqliDeleteQuery($query);

	echo '</div><center><div style="margin-top: 10px; font-size: 10px;">Last updated on: ' .
		date('d.m.Y', strtotime($result['MAX(last_update)'])) .
		' &middot; <a href="trackinginfo.php" class="link_noblue">Tracking Information</a></div></center></body></html>';
	mysqliCloseConnection();
}

function arrayToCommaString($input) {
	$out = "";
	if (is_array($input)) {
		$first = true;
		foreach ($input as $i) {
			if ($first)
				$first = false;
			else
				$out .= ", ";

			$out .= $i;
		}
	} else
		$out = $input;
	return $out;
}

function issetReturn($var) {
	if (isset($var))
		return $var;
	else
		return '';
}

function issetReturnGET($var) {
	if (isset($_GET[$var]))
		return $_GET[$var];
	else
		return '';
}

function issetReturnPOST($var) {
	if (isset($_POST[$var]))
		return $_POST[$var];
	else
		return '';
}

///////////////////////
///// M Y S Q L i /////
///////////////////////

function mres($input) {
	if (is_array($input)) {
		foreach ($input as $key => $value)
			$output[$key] = mres($value);
		return $output;

	} else
		return $GLOBALS['db']->escape_string($input);
}

function mysqliInitSelect($table, $array_fields, $where = NULL, $order = NULL, $limit = NULL) {
	$sql = "SELECT " . arrayToCommaString($array_fields) . " FROM `" . $table . "`";

	if (!empty($where))
		$sql .= " WHERE " . $where;

	if (!empty($order))
		$sql .= " ORDER BY " . $order;

	if (!empty($limit))
		$sql .= " LIMIT " . $limit;

	if ($result = $GLOBALS['db']->query($sql)) {
		return $result;
	} else {
		echo $GLOBALS['db']->error;
		return false;
	}
}

function mysqliInitSelectAdvanced($sql) {
	if ($result = $GLOBALS['db']->query(mres($sql))) {
		return $result;
	} else {
		echo $GLOBALS['db']->error;
		return false;
	}
}

function mysqliGetNumber($query) {
	if ($query === false)
		return 0;
	return $query->num_rows;
}

function mysqliGetSingle($query) {
	if ($query !== false)
		return $query->fetch_assoc();
	return false;
}

function mysqliGetMultiple($query) {
	if ($query !== false) {
		$out = array();
		while ($row = $query->fetch_assoc())
			array_push($out, $row);
		return $out;
	} else
		return false;
}

function mysqliDeleteQuery($query) {
	if ($query)
		$query->free();
}

function mysqliInsert($table, $insert_array) {
	$keys = '';
	$values = '';
	foreach ($insert_array as $key => $value) {
		if (!empty($keys)) {
			$keys .= ", ";
			$values .= ", ";
		}
		$keys .= "`" . $key . "`";
		$values .= "'" . $value . "'";
	}

	if (!$GLOBALS['db']->query("INSERT INTO " . $GLOBALS['db_name'] . '.' . $table . " (" . $keys . ") VALUES (" . $values . ")")) {
		echo $GLOBALS['db']->error;
		return false;
	} else
		return $GLOBALS['db']->insert_id;
}

function mysqliUpdate($table, $update_array, $where) {
	foreach ($update_array as $key => $value) {
		if (!empty($values))
			$values .= ", ";
		$values .= "`" . $key . "`='" . $value . "'";
	}

	if ($GLOBALS['db']->query("UPDATE " . $GLOBALS['db_name'] . '.' . $table . " SET " . $values . " WHERE " .  $where)) {
		return true;
	} else {
		echo $GLOBALS['db']->error;
		return false;
	}
}

function mysqliDelete($table, $where) {
	if (!$GLOBALS['db']->query("DELETE FROM " . $GLOBALS['db_name'] . '.' . $table . " WHERE " . $where)) {
		return true;
	} else {
		echo $GLOBALS['db']->error;
		return false;
	}
}

function mysqliCloseConnection() {
	$GLOBALS['db']->close();
}

?>
