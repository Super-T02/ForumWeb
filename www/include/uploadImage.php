<?php
require_once "../src/db/db.php";

const uploadDir = "../uploads/";

if(isset($_POST['submit'])) {
    $picture = uploadDir . basename($_FILES['picture']['name']);
    $imageFileType = strtolower(pathinfo($picture, PATHINFO_EXTENSION));

    // Check if image file is a actual image
    $check = getimagesize($_FILES['picture']['tmp_name']);
    if($check === false) {
        throw new RuntimeException("Datei ist keine Bilddatei");
    }

    // Check already exist
    if(file_exists($picture)) {
        throw new RuntimeException("Datei mit diesem Namen bereits vorhanden");
    }

    // Check file size
    if ($_FILES['picture']['size'] > 500000000) { //larger than 5 MB
        throw new RuntimeException("Datei ist zu groß. Es sind maximal 5 MB zugelassen.");
    }

    // Check file type
    if($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        throw new RuntimeException("Es sind nur JPG, JPEG, PNG & GIF Dateien erlaubt.");
    }


    if (!move_uploaded_file($_FILES['picture']['tmp_name'], $picture)) {
        throw new RuntimeException("Die Datei " .htmlspecialchars( basename( $_FILES['picture']['name'])). " konnte nicht hochgeladen werden!");
    }

}