<?php
require_once "sessionHeader.php";
require_once "../src/Answer.php";
require_once "../src/Theme.php";

//Check all Post variables
if (!(isset($_POST['answer'], $_POST['ID']))){
    $_SESSION['err_form'] = "Es wurden nicht alle notwendigen Daten gesendet!"; //error description

    if(!isset($_POST['ID']))  header("Location: index.php"); // go back to index.php
    else header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article
}

try {
    $answer = new Answer(intval($_POST['ID']), intval(1), $_POST['answer']); //TODO: User dynamisch
    $id = $answer->sendToDB();
    header("Location: ../article.php?themeID=". $_POST['ID']."#answer-".$id); // go back to article
} catch (Exception $e) {
    $_SESSION['err'] = "Die Antwort konnte nicht an die Datenbank übermittelt werden:". $e->getMessage();
    header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article
}

