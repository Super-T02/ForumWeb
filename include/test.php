<?php
require "../src/db/db.php";
require_once "../src/Theme.php";
require_once "../src/Answer.php";

$connection = new DB_Connection();
$connection->connect();
try {


    $res = $connection->doQuery("SELECT * FROM articles WHERE themeID = 7");
    while ($row = $res->fetch_assoc())
    {

        $answer = new Answer(intval($row['themeID']), intval($row['userID']), $row['text'], intval($row['ID']),
            $row['date']);

       echo $answer;
    }


     $theme = Theme::loadByID(4);

     echo $theme->getId();
     echo $theme->getDate(). "<br>";
     echo $theme->getUserID(). "<br>";
     echo $theme->getHeadline(). "<br>";
     echo $theme->getDescription(). "<br>";
} catch (Exception $e) {
    echo $e->getMessage();
} finally {
    $connection->closeConnection();
}
