<?php
require_once "sessionHeader.php";
require_once "../src/Theme.php";
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
$userID = 1; // TODO: User dynaimsch!
$date = date("d.m.Y", time());

//options for picture
$alt = "Bild zum Thema ".$headline; // alt for picture

try {
    // Picture sent
    if (isset($_POST['hasPicture']))
    {
        $picture = uploadDir . basename($_FILES['picture']['name']);
        $imageFileType = strtolower(pathinfo($picture, PATHINFO_EXTENSION));

        $pic = Picture::checkUpLoad($imageFileType, $_FILES['picture']['name'], $_FILES['picture']['tmp_name'],
            uploadDir, $_FILES['picture']['size'], $alt);


        if (!move_uploaded_file($_FILES['picture']['tmp_name'], uploadDir . basename($_FILES['picture']['name']))) {
            throw new Exception("Die Datei " . htmlspecialchars(basename($_FILES['picture']['name']))
                . " konnte nicht hochgeladen werden!");
        }

        unset($_FILES['picture']);

        $myTheme = new Theme($headline, $description, $pic->getId(), $userID);
    }
    else
    {
        $myTheme = new Theme($headline, $description, null, $userID); // -1 stands for no picture
    }

    if($myTheme->getId() > -1){
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