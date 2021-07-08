<?php
require_once "sessionHeader.php";
require_once "../src/Theme.php";
require_once "../src/ThemeWithPicture.php";
require_once "../src/Picture.php";
define("uploadDir", "../uploads/");

//Check all Post variables
if (!(isset($_POST['headline'], $_POST['description']))){
    $_SESSION['err_form'] = "Es wurden nicht alle notwendigen Daten gesendet!"; //error description
    header("Location: ../index.php"); // go back to index.php
}

// Get data from Post request:
$headline = $_POST['headline'];
$description = $_POST['description'];

if (isset($_SESSION['userID'])) $userID = $_SESSION['userID'];
else $userID = 1; // std user 'Gast'

$date = date("d.m.Y", time());

//options for picture
$alt = "Bild zum Thema ".$headline; // alt for picture

try {
    if (isset($_POST['hasPicture'])) // pictures uploaded
    {
        // define some variables
        $picture = uploadDir . basename($_FILES['picture']['name']); // file path in future
        $imageFileType = strtolower(pathinfo($picture, PATHINFO_EXTENSION)); // type of the file

        // Checks for duplicates, size and file format. successful -> new Picture
        $pic = Picture::checkUpLoad($imageFileType, $_FILES['picture']['name'], $_FILES['picture']['tmp_name'],
            uploadDir, $_FILES['picture']['size'], $alt);

        // try to move the file in the directory
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], uploadDir . basename($_FILES['picture']['name']))) {
            throw new Exception("Die Datei " . htmlspecialchars(basename($_FILES['picture']['name']))
                . " konnte nicht hochgeladen werden!");
        }

        unset($_FILES['picture']);

        // Generate new theme with picture
        $myTheme = new ThemeWithPicture($headline, $description, $pic->getId(), $userID);
    }
    else // no pictures uploaded
    {
        // Generate normal theme without picture
        $myTheme = new Theme($headline, $description, $userID);
    }

    // send theme to db
    $myTheme->sendToDB();

    if($myTheme->getId() > -1) // theme not sent to db
    {
        header("Location: ../article.php?themeID=" . $myTheme->getId()); // go to new theme index.php
    }
    else{
        $_SESSION['err'] = "Thema konnte nicht gesendet werden!";
        header("Location: ../index.php"); // go back to index.php
    }

}catch (Exception $e) {
    $_SESSION['err'] = "Thema konnte nicht erstellt werden: ".$e->getMessage(); // save errormessage
    header("Location: ../index.php"); // go back to index.php
}