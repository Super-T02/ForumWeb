<?php
require_once "sessionHeader.php";

//Check all Post variables
if (!(isset($_POST['answer'], $_POST['ID']))){
    $_SESSION['err_form'] = "Es wurden nicht alle notwendigen Daten gesendet!"; //error description
    if(!isset($_POST['ID']))  header("Location: index.php"); // go back to index.php
    else header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article
}

// Get data from Post request:
$answer = $_POST['answer'];
$themeID = $_POST['ID'];
$userID = 1; // TODO: User dynaimsch!
$date = date("d.m.Y", time());
$numOfAnswers = 0;

if(is_string($answer) and is_string($themeID) and is_int($userID) and is_string($date))
{
    require_once "../src/db/db.php";
    date_default_timezone_set("Europe/Berlin");
    $connection = new DB_Connection();
    $connection->connect();

    //security for unescaped strings
    $connection->getConn()->real_escape_string($answer);
    $connection->getConn()->real_escape_string($themeID);

    // Send Data to DB
    try {
        $res = $connection->doQuery("INSERT INTO articles (text, userID, themeID, date) VALUES ('".$answer."', ".$userID.", ".$themeID.", '".$date."');");
        echo json_encode($res);

    } catch (Exception $e) {
        $_SESSION['err'] = "The Query gets the error by inserting the answer: " . $e->getMessage(); //error description
        header("Location: ../article.php?themeID=".$themeID); // go back to article
    }


    //increases Number of Items
    try {
        $result = $connection->doQuery("SELECT themes.ID, themes.answers FROM themes WHERE themes.ID = " . $themeID);

        while ($row = $result->fetch_assoc()){
            $numOfAnswers = $row['answers'];
        }

        $numOfAnswers ++;

        $result = $connection->doQuery("UPDATE themes SET answers = ".$numOfAnswers." WHERE ID = " . $themeID);
    } catch (Exception $e) {
        $_SESSION['err'] = "The Query gets the error by increasing the num of answers on this theme: " . $e->getMessage(); //error description

    } finally {
        $connection->closeConnection();
        header("Location: ../article.php?themeID=".$themeID); // go back to article
    }
}
else
{
    unset($_POST['ID'], $_POST['answer']);
    $_SESSION['err_form'] = "Falscher Datentyp eingegeben!"; //error description
    header("Location: ../article.php?themeID=".$themeID); // go back to article
}

