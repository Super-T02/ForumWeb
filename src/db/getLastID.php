<?php
include_once "db.php";
date_default_timezone_set("Europe/Berlin");
$connection = new DB_Connection();
$connection->connect();

// Send Data to DB
try {
    $res = $connection->doQuery("SELECT ID FROM themes WHERE 1 ORDER BY ID DESC");
    echo json_encode($res->fetch_assoc());
} catch (Exception $e) {
    echo $e->getTrace();
}

$connection->closeConnection();
