<?php
session_start();
require 'database.php';

if(isset($_POST['event_id'])){
	$event_id = $_POST['event_id'];
    $sessionUser = $_SESSION['username'];
	$stmt = $mysqli->prepare("DELETE from events
                             WHERE (event_id=? AND username=?)
                            ");
	if(!$stmt){
		echo "Failed";
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ss', $event_id, $username);
	$stmt->execute();
	$stmt->close();
	echo "Success";
}
?>