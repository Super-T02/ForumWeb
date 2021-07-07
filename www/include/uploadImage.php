<?php
require_once "sessionHeader.php";
require_once "../src/db/db.php";
require_once "../src/Picture.php";

const uploadDir = "../uploads/";

try {
    if(!isset($_POST['submit'])) throw new RuntimeException("Es wurden"
        ." keine Daten gesnedet!");


    $picture = uploadDir . basename($_FILES['picture']['name']);
    $imageFileType = strtolower(pathinfo($picture, PATHINFO_EXTENSION));

    $pic = Picture::checkUpLoad($imageFileType, $_FILES['picture']['name'], $_FILES['picture']['tmp_name'], uploadDir,
        $_FILES['picture']['size'], 1, 0, 'test');

    if (!move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
        throw new Exception("Die Datei " . htmlspecialchars(basename($_FILES['picture']['name']))
            . " konnte nicht hochgeladen werden!");
    }

    echo $pic;
}
//Something is wrong with the upload
catch (RuntimeException $runtimeException){
    $_SESSION['err'] = $runtimeException->getMessage();
    header("Location: ../index.php");
}
//Something is wrong with the Query
catch (Exception $e) {

    if (isset($pic)) try {

        $pic->deleteFormDB();

    } catch (Exception $ex) {
        //Do nothing
    } finally{
        $_SESSION['err'] = $e->getMessage();
        header("Location: ../index.php");
    }

}

