<?php
require_once "sessionHeader.php";
require_once "../src/Theme.php";

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

try {
    $myTheme = new Theme($headline, $description, $userID);
    if($myTheme->getId() > -1) header("Location: ../article.php?themeID=" . $myTheme->getId()); // go to new theme index.php
    else header("Location: index.php"); // go back to index.php
} catch (Exception $e) {
    $_SESSION['err'] = $e->getMessage(); // save errormessage
    header("Location: index.php"); // go back to index.php
}