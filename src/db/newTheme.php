<?php
include_once "db.php";
date_default_timezone_set("Europe/Berlin");
$connection = new DB_Connection();
$connection->connect();

// Get data from Post request:
$headline = $_POST['headline'];
$description = $_POST['description'];
$userID = 1; // TODO: User dynaimsch!
$date = date("d.m.Y", time());

// Send Data to DB
try {
    $connection->doQuery("INSERT INTO themes (headline, description, userID, views, answers, lastChange) VALUES ('".$headline."', '".$description."', " . $userID . ", 0, 0, '" . $date . "')");
} catch (Exception $e) {
    echo $e;
}

echo json_encode($connection->getResult());

$connection->closeConnection();
