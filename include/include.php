<?php
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'config.php';

// Connect to server and select database.
$prefix = $db_name;
$db = new mysqli($db_host, $db_username, $db_password, $db_name);

require_once 'subs.php';
require_once 'subs_ofa.php';

$db->query("SET character_set_results = 'utf8', character_set_client = 'utf8', 
	character_set_connection = 'utf8', character_set_database = 'utf8', 
	character_set_server = 'utf8'");

?>