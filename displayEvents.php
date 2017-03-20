<?php
//https://bitbucket.org/czhang088/spring2017-module3-437121-452664/src/7da7a508d531a100932cf8302928e0e240989ecd/view_comments.php?at=master&fileviewer=file-view-default
session_start();
require 'database.php';

if(isset($_POST['event_year']) &&
   isset($_POST['event_month']) &&
   isset($_POST['event_day']) &&
   isset($_SESSION['username'])) {
    $sessionUser = $_SESSION['username'];
    $event_year = $_POST['event_year'];
    $event_month = $_POST['event_month'];
    $event_day = $_POST['event_day'];
    $stmt = $mysqli->prepare("SELECT event_id, username, event_time, event_name, event_description
                             FROM events
                             WHERE username=?
                             AND event_year=?
                             AND event_month=?
                             AND event_day=?");
                                
    if(!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ssss', $sessionUser, $event_year, $event_month, $event_day);
    $stmt->execute();
    $stmt->bind_result($event_id, $tempUser, $event_time, $event_name, $event_description);
    
    $eventsArray = array();
    $i = 0;
    while($stmt->fetch()){
        $event_date = $event_month.'/'.$event_day.'/'.$event_year;
        $event = array(htmlspecialchars($event_id),
                       htmlspecialchars($sessionUser),
                       htmlspecialchars($event_day),
                       htmlspecialchars($event_time),
                       htmlspecialchars($event_name),
                       htmlspecialchars($event_description),
                       htmlspecialchars($event_date)
                       );
        $eventsArray[$i] = $event;
        $i++;
    }
    $stmt->close();
    echo json_encode($eventsArray);
}

?>