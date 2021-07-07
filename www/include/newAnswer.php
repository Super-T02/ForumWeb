<?php
require_once "sessionHeader.php";
require_once "../src/Answer.php";
require_once "../src/AnswerWithPicture.php";
require_once "../src/Theme.php";

//Check all Post variables
if (!(isset($_POST['answer'], $_POST['ID']))){
    $_SESSION['err_form'] = "Es wurden nicht alle notwendigen Daten gesendet!"; //error description

    if(!isset($_POST['ID']))  header("Location: ../index.php?err_form=". $_SESSION['err_form']); // go back to index.php
    else header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article
}

try {
    if (isset($_POST['hasPicture'])) // Picture uploaded
    {
        // define some variables
        $picture = uploadDir . basename($_FILES['picture']['name']); // file path in future
        $imageFileType = strtolower(pathinfo($picture, PATHINFO_EXTENSION)); // type of the file

        // Checks for duplicates, size and file format. successful -> new Picture
        $pic = Picture::checkUpLoad($imageFileType, $_FILES['picture']['name'], $_FILES['picture']['tmp_name'],
            uploadDir, $_FILES['picture']['size'], "Bild");

        // try to move the file in the directory
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], uploadDir . basename($_FILES['picture']['name']))) {
            throw new Exception("Die Datei " . htmlspecialchars(basename($_FILES['picture']['name']))
                . " konnte nicht hochgeladen werden!");
        }

        unset($_FILES['picture']);

        // generate a answer with picture
        $answer = new AnswerWithPicture(intval($_POST['ID']), intval(1), $_POST['answer'], $pic->getId());
    }
    else // no picture upload
    {
        // generate a normal answer
        $answer = new Answer(intval($_POST['ID']), intval(1), $_POST['answer']);
    }

    // send Answer to database
    $id = $answer->sendToDB();

    header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article

}
catch (Exception $e)
{

    $_SESSION['err'] = "Die Antwort konnte nicht an die Datenbank übermittelt werden!";
    header("Location: ../article.php?themeID=". $_POST['ID']); // go back to article
}

