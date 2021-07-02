<?php
require_once "sessionHeader.php";

//Check all Post variables
if (!(isset($_POST['headline'], $_POST['description']))){
    $_SESSION['err_form'] = "Es wurden nicht alle notwendigen Daten gesendet!"; //error description
    header("Location: index.php"); // go back to index.php
}

// Get data from Post request:
$headline = $_POST['headline'];
$description = $_POST['description'];
$userID = 1; // TODO: User dynaimsch!
$date = date("d.m.Y", time());


if(is_string($headline) and is_string($description) and is_int($userID) and is_string($date))
{
    //DB Header
    include_once "../src/db/db.php";

    date_default_timezone_set("Europe/Berlin");
    $connection = new DB_Connection();
    $connection->connect();

    //security for unescaped strings
    $connection->getConn()->real_escape_string($headline);
    $connection->getConn()->real_escape_string($description);

    // Send Data to DB
    try {
        $connection->doQuery("INSERT INTO themes (headline, description, userID, views, answers, lastChange) VALUES ('" . $headline . "', '" . $description . "', " . $userID . ", 0, 0, '" . $date . "')");
        $_SESSION['successMessage'] = "Ein neues Thema mit dem Namen ".$headline." wurde erstellt";

        $res = $connection->doQuery("SELECT ID FROM themes WHERE 1 ORDER BY ID DESC"); // Gets the last ID
        $actualID = $res->fetch_assoc()['ID'];

    } catch (Exception $e) {
        $_SESSION['err'] = "The Query gets the error: " . $e->getMessage(); //error description
        $connection->closeConnection();
        header("Location: index.php"); // go back to index.php

    } finally {
        $connection->closeConnection();
        header("Location: ../article.php?themeID=".$actualID); // go to new theme index.php
    }


}
else
{
    unset($_POST['headline'], $_POST['description']);
    $_SESSION['err_form'] = "False Datatype!"; //error description
    header("Location: index.php"); // go back to index.php
}


