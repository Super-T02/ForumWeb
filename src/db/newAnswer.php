<?php
include_once "db.php";
date_default_timezone_set("Europe/Berlin");
$connection = new DB_Connection();
$connection->connect();

// Get data from Post request:
$answer = $_POST['answer'];
$themeID = $_POST['themeID'];
$userID = 1; // TODO: User dynaimsch!
$date = date("d.m.Y", time());
$numOfAnswers = 0;



if(is_string($answer) and is_string($themeID) and is_int($userID) and is_string($date))
{
    //security for unescaped strings
    $connection->getConn()->real_escape_string($answer);
    $connection->getConn()->real_escape_string($themeID);

    // Send Data to DB
    try {
        $res = $connection->doQuery("INSERT INTO articles (text, userID, themeID, date) VALUES ('".$answer."', ".$userID.", ".$themeID.", '".$date."');");
        echo json_encode($res);
    } catch (Exception $e) {
        echo $e->getTrace();
    }


    //increases Number of Items
    try {
        $result = $connection->doQuery("SELECT themes.ID, themes.answers FROM themes WHERE themes.ID = " . $themeID);
    } catch (Exception $e) {
        echo $e->getTrace();
    }

    while ($row = $result->fetch_assoc()){
        $numOfAnswers = $row['answers'];
    }

    $numOfAnswers ++;

    try {
        $result = $connection->doQuery("UPDATE themes SET answers = ".$numOfAnswers." WHERE ID = " . $themeID);
    } catch (Exception $e) {
        echo $e->getTrace();
    }



}
else
{
    echo "Falscher Datentyp eingegeben";
}






$connection->closeConnection();