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



if(is_string($headline) and is_string($description) and is_int($userID) and is_string($date))
{
    //security for unescaped strings
    $connection->getConn()->real_escape_string($headline);
    $connection->getConn()->real_escape_string($description);

    // Send Data to DB
    try {
        $res = $connection->doQuery("INSERT INTO themes (headline, description, userID, views, answers, lastChange) VALUES ('" . $headline . "', '" . $description . "', " . $userID . ", 0, 0, '" . $date . "')");
        echo json_encode($res);
    } catch (Exception $e) {
        echo $e->getTrace();
    }

}
else
{
    echo "Falscher Datentyp eingegeben";
}

$connection->closeConnection();

