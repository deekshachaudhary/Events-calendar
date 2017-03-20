<?php
 
$mysqli = new mysqli('localhost', 'cse330', 'cse330', 'calendar');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>