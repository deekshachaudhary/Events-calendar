<?php
session_start();
require 'database.php';

//if(isset($_POST['event_id'])
//   && isset($_POST['event_year'])
//   && isset($_POST['event_month'])
//   && isset($_POST['event_day'])
//   && isset($_POST['event_time'])
//   && isset($_POST['event_name'])
//   && isset($_POST['event_description'])
//   && isset($_SESSION['username'])){
	$event_id = $_POST['event_id'];
    $sessionUser = $_SESSION['username'];
	$event_year = $_POST['event_year'];
	$event_month = $_POST['event_month'];
	$event_day = $_POST['event_day'];
	$event_time = $_POST['event_time'];
	$event_name = $_POST['event_name'];
	$event_description = $_POST['event_description'];
	$stmt = $mysqli->prepare("UPDATE events
                             SET event_year=?,
                                event_month=?,
                                event_day=?,
                                event_time=?,
                                event_name=?,
                                event_description=?
                             WHERE event_id=? AND username=?
                            ");
	if(!$stmt){
		echo "Failed";
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	$stmt->bind_param('ssssssss', $event_year, $event_month, $event_day, $event_time,
                      $event_name, $event_description, $event_id, $sessionUser);
	$stmt->execute();
	$stmt->close();
	echo "Success";
//}
?>